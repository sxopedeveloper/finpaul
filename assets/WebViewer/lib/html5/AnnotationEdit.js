$(function() {
    'use strict';
    var readerControl, docViewer, am, userPrefs;
    var $colorButtons, $basicColorPicker, $basicColorPickerList, $fontSizePicker, $fontSizeRadio,
        $thicknessPicker, $thicknessRadio, $opacityPicker, $opacityRadio, $addColorButton, $removeColorButton,
        $advancedColorPicker, $addNewColorPicker, $advancedFontSizeSlider, $advancedThicknessSlider, $advancedOpacitySlider,
        $basicPropertyContainer, $advancedPropertyContainer;
    var $toolList, $overflowToolsContainer, $annotPreviewCanvas, annotPreviewCanvas;
    var $annotEditDialog, $annotEditButtons, $annotEditProperties, $addNewColor, $annotEditDelete, $annotEditStyle, $annotEditNote;
    var $basicPropertyEdit, $advancedPropertyEdit, $basicProperties, $advancedProperties, $cancelAddColor, $selectAddColor;
    var $signatureDialog, $signatureSelectionContainer;
    var $textSelectionContainer;

    var dialogClass = 'no-title annotEditDialog';
    var transparentDialogClass = dialogClass + ' dialogTransparent';
    var colorTypes = {
        color: 'StrokeColor',
        fillColor: 'FillColor',
        textColor: 'TextColor'
    };
    var selectedColorPicker = colorTypes.color;
    var isRemovingColors = false;
    var editMode = window.ControlUtils.editMode;
    var currentEditMode = editMode.basic;
    var currentToolColors;

    var dialogMode = {
        none: 0,
        annotEdit: 1,
        textSelect: 2,
        signature: 3
    };
    var currentDialogMode = dialogMode.none;
    var textSelectData = null;
    var signatureData = null;

    var IS_COPY_SUPPORTED = true;

    var DesktopPropertyManager = function(annotationProperty, $slider, $radioContainer) {
        window.ControlUtils.PropertyManager.apply(this, arguments);
        $radioContainer.buttonset();
    };

    DesktopPropertyManager.prototype = $.extend({}, window.ControlUtils.PropertyManager.prototype, {
        update: function(value) {
            window.ControlUtils.PropertyManager.prototype.update.apply(this, arguments);
            this.$radioContainer.buttonset('refresh');
            this.$slider.slider('option', 'value', value);
        }
    });

    $(document).on('viewerLoaded', function() {
        readerControl = window.readerControl;
        docViewer = readerControl.docViewer;
        am = docViewer.getAnnotationManager();
        userPrefs = window.ControlUtils.userPreferences;
        $('.annotTool').hide();
        $('#overflowTools').hide();

        $annotEditDialog = $('#annotEditDialog').dialog({
            autoOpen: false,
            draggable: false,
            resizable: false,
            minHeight: 'auto',
            width: 'auto',
            dialogClass: transparentDialogClass
        });
        $annotEditProperties = $annotEditDialog.find('#annotEditProperties');
        $basicColorPicker = $annotEditProperties.find('#colorPicker');
        $basicColorPickerList = $basicColorPicker.find('.colorPicker');
        $colorButtons = $annotEditProperties.find('.colorButton');
        $fontSizePicker = $annotEditProperties.find('.fontSizePicker');
        $fontSizeRadio = $annotEditProperties.find('#fontSizeRadio');
        $advancedFontSizeSlider = $annotEditProperties.find('#advancedFontSizeSlider');
        $thicknessPicker = $annotEditProperties.find('.thicknessPicker');
        $thicknessRadio = $annotEditProperties.find("#thicknessRadio");
        $advancedThicknessSlider = $annotEditProperties.find("#advancedThicknessSlider");
        $opacityPicker = $annotEditProperties.find('.opacityPicker');
        $opacityRadio = $annotEditProperties.find('#opacityRadio');
        $advancedOpacitySlider = $annotEditProperties.find('#advancedOpacitySlider');
        $basicProperties = $annotEditProperties.find('#basicProperties');
        $advancedProperties = $annotEditProperties.find('#advancedProperties');
        $advancedColorPicker = $advancedProperties.find('.colorPicker');
        $basicPropertyEdit = $annotEditProperties.find('#basicPropertyEdit');
        $advancedPropertyEdit = $annotEditProperties.find('#advancedPropertyEdit');
        $basicPropertyContainer = $annotEditProperties.find('#basicPropertyContainer');
        $advancedPropertyContainer = $annotEditProperties.find('#advancedPropertyContainer');
        $addNewColor = $annotEditDialog.find('#addNewColor');
        $addNewColorPicker = $addNewColor.find('.colorPicker');
        $cancelAddColor = $addNewColor.find('#cancelAddColor');
        $selectAddColor = $addNewColor.find('#selectAddColor');
        $addColorButton = $annotEditProperties.find('#addColorButton');
        $removeColorButton = $annotEditProperties.find('#removeColorButton');
        $annotEditButtons = $annotEditDialog.find('#annotEditButtons');
        $annotEditDelete = $annotEditButtons.find('#annotEditDelete');
        $annotEditStyle = $annotEditButtons.find('#annotEditStyle');
        $annotEditNote = $annotEditButtons.find('#annotEditNote');
        $toolList = $('#toolList');
        $overflowToolsContainer = $('#overflowToolsContainer');
        annotPreviewCanvas = document.getElementById('annotPreviewCanvas');
        $annotPreviewCanvas = $(annotPreviewCanvas);
        window.ControlUtils.setPreviewCanvas(annotPreviewCanvas, annotPreviewCanvas.width, annotPreviewCanvas.height);
        //set up the initial UI for the tool panel
        setupAnnotTools();
        setupAnnotationEditDialog();
        setupTextSelectionMenu();

        context.settings({
            click: true,
            right: true,
            minWidth: false
        });

        context.attach('#overflowTools', $overflowToolsContainer[0]);

        if (window.matchMedia) {
            var query = window.matchMedia("(max-width: 1024px)");
            query.addListener(widthChange);
            widthChange(query);
        }

        $signatureDialog = $('#signatureDialog').dialog({
            autoOpen: false,
            draggable: false,
            resizable: false,
            modal: true,
            dialogClass: 'noCloseButton',
            open: function() {
                var $this = $(this);
                var multiplier = window.utils.getCanvasMultiplier();
                var width = $this.width();
                // subtract hard coded height of buttons + some padding..
                var height = $this.height() - 35;

                $signatureCanvas.attr({
                    width: width * multiplier,
                    height: height * multiplier
                })
                .css({
                    width: width,
                    height: height
                });
                signatureTool.openSignature();
            },
            close: function() {
                signatureTool.clearSignatureCanvas();
            }
        });

        $signatureSelectionContainer = $('#signatureSelectionContainer');

        $('#signatureCancelButton').on('click', function() {
            $signatureDialog.dialog('close');
        });

        $('#signatureClearButton').on('click', function() {
            signatureTool.clearSignatureCanvas();
            var $signatureAddButton = $('#signatureAddButton');
            if(!$signatureAddButton.hasClass("unclickableButton")){
                $signatureAddButton.addClass("unclickableButton");
            }
        });

        $('#signatureAddButton').on('click', function() {
            var makeDefault = $makeDefaultCheckbox.prop('checked');

            var added = signatureTool.addSignature(makeDefault);
            if (added) {
                $signatureDialog.dialog('close');
            }
        });

        $('#mySignatureButton').on('click', function() {
            signatureTool.addDefaultSignature();
            hideAnnotationEditDialog();
        });

        $('#newSignatureButton').on('click', function() {
            openSignatureDialog();
            hideAnnotationEditDialog();
        });

        $('#makeDefaultSignatureText').on('click', function() {
            var checked = $makeDefaultCheckbox.prop('checked');
            $makeDefaultCheckbox.prop('checked', !checked);
        });

        function openSignatureDialog() {
            $makeDefaultCheckbox.prop('checked', false);
            var $signatureAddButton = $('#signatureAddButton');
            if(!$signatureAddButton.hasClass("unclickableButton")){
                $signatureAddButton.addClass("unclickableButton");
            }

            var width = window.innerWidth * (2 / 3);
            $signatureDialog.dialog('option', {
                width: width,
                height: width / 2
            });
            $signatureDialog.dialog('open');
        }

        var $makeDefaultCheckbox = $('#makeDefaultSignature');

        var signatureTool = readerControl.toolModeMap['AnnotationCreateSignature'];
        signatureTool.on('locationSelected', function(e, pageLocation) {
            if (signatureTool.hasDefaultSignature()) {
                currentDialogMode = dialogMode.signature;

                $signatureSelectionContainer.show();
                $textSelectionContainer.hide();
                $annotEditButtons.hide();

                showSignatureMenu(pageLocation);
            } else {
                openSignatureDialog();
            }
        });

        var $signatureAddButton = $('#signatureAddButton');
        var $signatureCanvas = $('#signatureCanvas');
        $(document).on('mouseup click touchend', function() {
            if($signatureAddButton.hasClass("unclickableButton") && !signatureTool.isEmptySignature()){
                $signatureAddButton.removeClass("unclickableButton");
            }
        });
        signatureTool.setSignatureCanvas($signatureCanvas);
    });

    function showSignatureMenu(pageLocation) {
        signatureData = pageLocation;

        var displayMode = readerControl.docViewer.getDisplayModeManager().getDisplayMode();
        var location = displayMode.pageToWindow({
            x: pageLocation.x,
            y: pageLocation.y
        }, pageLocation.pageIndex);

        location.y -= $scrollView.scrollTop();

        positionDialog(location, $scrollView.scrollLeft(), 'center center', function(location, dialog) {
            dialog.element.css(location);
        });
        $annotEditDialog.dialog('open');
    }

    function widthChange(query) {
        if (query.matches) {
            // move priority tools to overflow
            $toolList.find('.visiblePriority')
                .removeClass('active')
                .prependTo($overflowToolsContainer);
        } else {
            // move priority tools back
            $overflowToolsContainer.find('.visiblePriority')
                .insertAfter($toolList.find('[data-toolmode="TextSelect"]'));

            if ($('#overflowButton').hasClass('visiblePriority')) {
                // if the overflow button is one of the priority tools then replace it with a sticky note
                var defaultOverflow = $overflowToolsContainer.find('[data-toolmode="AnnotationCreateSticky"]');
                updateOverflowButton(defaultOverflow, false);
            }
        }

        updateToolMode(readerControl.getToolMode());
    }

    function updateOverflowButton(overflowTool, active) {
        // clone the overflow button and replace the current tool button in the overflow position with this button
        var replacingOverflowButton = overflowTool.clone()
            .attr('id', 'overflowButton');

        if (active) {
            replacingOverflowButton.addClass('active');
        }

        $toolList.find('#overflowButton').replaceWith(replacingOverflowButton);
    }

    function updateToolMode(toolname) {
        $toolList.find('[data-toolmode]').removeClass('active');

        var toolButton = $toolList.find('[data-toolmode="' + toolname + '"]');
        if (toolButton.length > 0 && toolButton.is(':visible')) {
            toolButton.addClass('active');
        } else {
            var overflowTool = $overflowToolsContainer.find('[data-toolmode="' + toolname + '"]');
            if (overflowTool.length > 0) {
                updateOverflowButton(overflowTool, true);
            }
        }
    }

    $(document).on('toolModeChanged', function(event, tool) {
        var toolname = '';
        for (var key in readerControl.toolModeMap) {
            if (tool === readerControl.toolModeMap[key]) {
                toolname = key;
                break;
            }
        }

        if (toolname) {
            updateToolMode(toolname);
        }
    });

    $(document).on("documentLoaded", function() {
        // we need to get the new annotation manager when a new document is loaded
        am = docViewer.getAnnotationManager();

        if (!am.getReadOnly() && readerControl.enableAnnotations) {
            // don't show the annotation tools when in readonly mode
            // unset the display instead of using show so jQuery doesn't add display: block
            $('.annotTool').css('display', '');
            $('#overflowTools').show();
        }

        // // example of customizing the popup element + attaching any custom events to the popup
        // // here are the default child elements in the popup:
        // // minimize button: $popupel.find('.popup-minimize-button')
        // // comment textarea: $popupel.find('.popup-comment')
        // am.on('annotationPopupCreated', function(e, annotation, $popupel) {
        //     var popupcomment = $popupel.find('.popup-comment');
        //     popupcomment[0].style.backgroundColor = 'red';
        //     popupcomment.bind("keyup", function(e) {
        //         annotation.setCustom(e.target.value);
        //     });
        // });

        am.on('annotationSelected', function(e, annotations, action) {
            /*jshint unused:false */
            if (annotations === null || annotations.length !== 1) {
                hideAnnotationEditDialog();
            }
        });

        am.on('annotationChanged', function(e, annotations, action) {
            if (!e.imported && action === 'delete') {
                // make sure to hide the dialog when deleting an annotation
                hideAnnotationEditDialog();
            }
        });
    });

    var DIALOG_OFFSET = 10;
    var TOOLBAR_OFFSET = $('#control').outerHeight();
    var $scrollView = $('#DocumentViewer');

    $scrollView.on('scroll', function() {
        hideAnnotationEditDialog();
    });

    function hideAnnotationEditDialog() {
        $annotEditDialog.dialog('close');

        $annotEditProperties.hide();
        $addNewColor.hide();
        $signatureSelectionContainer.hide();
        $textSelectionContainer.hide();
        $annotEditButtons.show();
        $annotEditDialog.dialog('option', 'dialogClass', transparentDialogClass);
        removingColors(false, true);
        currentDialogMode = dialogMode.none;
    }

    function showAnnotationEditDialog() {
        if (currentDialogMode === dialogMode.annotEdit || currentDialogMode === dialogMode.none) {
            if (!readerControl.enableAnnotations) {
                return;
            }

            var selectedAnnotations = am.getSelectedAnnotations();
            if (selectedAnnotations.length === 1) {
                var annotation = selectedAnnotations[0];

                var buttons = $annotEditButtons.find('button');
                buttons.removeClass('leftRounded rightRounded').show();

                if (am.getReadOnly()) {
                    $annotEditNote.attr('data-i18n', 'annotationPopup.buttonNote').i18n();
                    if (annotation.getContents() === "" || annotation instanceof Annotations.FreeTextAnnotation) {
                        $annotEditNote.hide();
                    }

                } else if (!am.canModify(annotation)) {
                    $annotEditNote.attr('data-i18n', 'annotationPopup.buttonReply').i18n();
                } else if (annotation instanceof Annotations.FreeTextAnnotation) {
                    $annotEditNote.attr('data-i18n', 'annotationPopup.buttonEditText').i18n();
                } else {
                    $annotEditNote.attr('data-i18n', 'annotationPopup.buttonNote').i18n();
                }

                if (!am.canModify(annotation)) {
                    $annotEditDelete.hide();
                    $annotEditStyle.hide();
                }

                // don't allow editing of stamp annotation appearance
                if (annotation instanceof Annotations.StampAnnotation) {
                    $annotEditStyle.hide();
                }

                var visibleButtons = buttons.filter(function() {
                    return $(this).css('display') !== 'none';
                });

                visibleButtons.first().addClass('leftRounded');
                visibleButtons.last().addClass('rightRounded');

                setEditPopupLocation(annotation);
            }
        } else if (currentDialogMode === dialogMode.textSelect) {
            showTextSelectMenu(textSelectData);
        } else if (currentDialogMode === dialogMode.signature) {
            showSignatureMenu(signatureData);
        }
    }

    function setEditPopupLocation(annotation) {
        var scrollTop = $scrollView.scrollTop();
        var scrollLeft = $scrollView.scrollLeft();
        var maxHeight = $scrollView.height();

        function openDialog(location, dialog) {
            dialog.element.css(location);
        }

        var pageIndex = annotation.PageNumber - 1;
        var pageX = annotation.getX() + (annotation.getWidth() / 2);
        var pageY = annotation.getY();

        var displayMode = readerControl.docViewer.getDisplayModeManager().getDisplayMode();
        var topLocation = displayMode.pageToWindow({
            x: pageX,
            y: pageY
        }, pageIndex);

        $annotEditDialog.dialog('open');

        // first try to position just above the annotation
        topLocation.y -= (scrollTop + DIALOG_OFFSET);
        positionDialog(topLocation, scrollLeft, 'center bottom', function(location, dialog) {
            if (location.top < TOOLBAR_OFFSET) {
                // if it doesn't fit there then try to position below the annotation
                var bottomLocation = displayMode.pageToWindow({
                    x: pageX,
                    y: annotation.getY() + annotation.getHeight()
                }, pageIndex);
                bottomLocation.y = bottomLocation.y - scrollTop + DIALOG_OFFSET;

                positionDialog(bottomLocation, scrollLeft, 'center top', function(location, dialog) {
                    if (location.top + dialog.height - TOOLBAR_OFFSET > maxHeight) {
                        // if it doesn't fit there then just position it in the middle of the screen
                        var centerLocation = displayMode.pageToWindow({
                            x: pageX,
                            y: 0
                        }, pageIndex);
                        centerLocation.y = maxHeight / 2;

                        positionDialog(centerLocation, scrollLeft, 'center center', function(location, dialog) {
                            openDialog(location, dialog);
                        });
                    } else {
                        openDialog(location, dialog);
                    }
                });
            } else {
                openDialog(location, dialog);
            }
        });
    }

    function positionDialog(location, scrollLeft, my, callback) {
        location.x -= scrollLeft;

        $annotEditDialog.dialog('option', 'position', {
            my: my,
            at: 'left+' + location.x + ' top+' + location.y,
            of: window,
            collision: 'fit',
            using: function(location, positions) {
                callback(location, positions.element);
            }
        });
    }

    function setColor(color, $colorPicker) {
        var colorName = colorToHex(color);
        deselectColor($colorPicker);
        selectColor($colorPicker.find('li[data-color="' + colorName + '"]'));
    }

    function selectColor($li) {
        $li.prepend('<div class="color-selected"></div>');
    }

    function deselectColor($colorPicker) {
        $colorPicker.find('div.color-selected').remove();
    }

    function createColorElement(color) {
        var $li = $('<li data-color="' + color + '"></li>');
        if (color === 'transparent') {
            color = 'url("Resources/color_none.png")';
        }
        var $colorSquare = $('<div></div>').css('background', color);
        $li.append($colorSquare);
        return $li;
    }

    function selectColorTab(colorType) {
        selectedColorPicker = colorType;
        var $tab, colors;
        if (colorType === colorTypes.color) {
            $tab = $annotEditProperties.find('#colorButton');
            colors = currentToolColors.colors;
        } else if (colorType === colorTypes.fillColor) {
            $tab = $annotEditProperties.find('#fillColorButton');
            colors = currentToolColors.fillColors;
        } else if (colorType === colorTypes.textColor) {
            $tab = $annotEditProperties.find('#textColorButton');
            colors = currentToolColors.textColors;
        }

        $removeColorButton.removeClass('removing');
        isRemovingColors = false;

        $colorButtons.removeClass('active');
        $tab.addClass('active');
        setTransparentColorVisibility();

        var annot = window.ControlUtils.getSelectedAnnotation();
        if (annot) {
            $basicColorPickerList.find('[data-color]').remove();
            colors.forEach(function(color) {
                $addColorButton.before(createColorElement(color));
            });

            setColor(annot[selectedColorPicker], $basicColorPicker);
            setColor(annot[selectedColorPicker], $advancedColorPicker);
        }
    }

    function colorSelectedHandler($element, $colorPicker) {
        var annotationProperty = selectedColorPicker;

        var annotation = window.ControlUtils.getSelectedAnnotation();
        if (!annotation) {
            return;
        }

        var color = colorNameToRGB($element.attr('data-color'));
        if (isRemovingColors) {
            var colorName = colorToHex(color);
            if (colorName !== 'transparent') {
                userPrefs.removeToolColor(annotation, annotationProperty, colorName);
                currentToolColors = userPrefs.getToolColors(annotation);
                $element.remove();
            }

        } else {
            deselectColor($colorPicker);
            selectColor($element);
            if (color) {
                annotation[annotationProperty] = color;
                am.updateAnnotation(annotation);
                am.trigger('annotationChanged', [[annotation], 'modify']);
                readerControl.fireEvent('defaultToolValueChanged', [annotation, annotationProperty, color]);
                window.ControlUtils.updateAnnotPreview(annotation);
            }
        }
    }

    function removingColors(isRemoving, isHiding) {
        isRemovingColors = isRemoving;
        if (isRemovingColors) {
            $removeColorButton.addClass('removing');

            $basicColorPickerList.find('li').each(function(i, element) {
                var color = element.getAttribute('data-color');

                if (color !== null && color !== 'transparent') {
                    var $element = $(element);
                    $element.find('div.color-selected').remove();
                    $element.prepend('<div class="color-removing"></div>');
                }
            });
        } else {
            $removeColorButton.removeClass('removing');

            $basicColorPickerList.find('div.color-removing').remove();
            if (!isHiding) {
                selectColorTab(selectedColorPicker);
            }
        }
    }

    // hide or show the transparent color box depending on which color tab is selected
    // it should only be shown for fill color
    function setTransparentColorVisibility() {
        var transparentColorBox = $advancedColorPicker.find('[data-color="transparent"]');
        if (selectedColorPicker === colorTypes.fillColor) {
            transparentColorBox.show();
        } else {
            transparentColorBox.hide();
        }
    }

    function setupAnnotationEditDialog() {
        $(document).on('sidePanelVisibilityChanged notesPanelVisibilityChanged', function() {
            showAnnotationEditDialog();
        });

        readerControl.docViewer.on('fitModeUpdated displayModeUpdated zoomUpdated', function () {
            if (readerControl.docViewer.getDocument()) {
                showAnnotationEditDialog();
            }
        });

        readerControl.docViewer.on('beforeDocumentLoaded pageNumberUpdated', function() {
            hideAnnotationEditDialog();
        });

        $annotEditDialog.find('#annotEditDone').on('click', function() {
            am.deselectAllAnnotations();
            hideAnnotationEditDialog();
        });

        $annotEditDialog.find('#annotEditDelete').on('click', function() {
            am.deleteAnnotations(am.getSelectedAnnotations());
        });

        $annotEditStyle.on('click', function() {
            $annotEditDialog.dialog('option', 'dialogClass', dialogClass);

            $annotEditProperties.show();
            $annotEditButtons.hide();

            var annotation = am.getSelectedAnnotations()[0];
            if (annotation) {
                currentDialogMode = dialogMode.annotEdit;
                currentToolColors = userPrefs.getToolColors(annotation);

                var strokeColor = annotation.StrokeColor;
                var fillColor = annotation.FillColor;
                var textColor = annotation.TextColor;

                var numberOfColors = 0;
                var $colorButtonContainer = $annotEditProperties.find('#colorType').show();
                $colorButtons.show();

                if (textColor) {
                    selectColorTab(colorTypes.textColor);
                    numberOfColors++;
                } else {
                    $annotEditProperties.find('#textColorButton').hide();
                }

                if (fillColor) {
                    selectColorTab(colorTypes.fillColor);
                    numberOfColors++;
                } else {
                    $annotEditProperties.find('#fillColorButton').hide();
                }

                if (strokeColor) {
                    selectColorTab(colorTypes.color);
                    numberOfColors++;
                } else {
                    $annotEditProperties.find('#colorButton').hide();
                }

                if (annotation.FontSize) {
                    fontSizeManager.update(parseFloat(annotation.FontSize), false);
                    $fontSizePicker.show();
                } else {
                    $fontSizePicker.hide();
                }

                if (annotation.StrokeThickness !== null && typeof annotation.StrokeThickness !== "undefined") {
                    $thicknessPicker.show();
                    if (annotation instanceof Annotations.FreeTextAnnotation && annotation.getIntent() === Annotations.FreeTextAnnotation.Intent.FreeText) {
                        $advancedThicknessSlider.slider('option', 'min', 0);
                    } else {
                        $advancedThicknessSlider.slider('option', 'min', 1);
                    }

                    thicknessManager.update(annotation.StrokeThickness, false);
                } else {
                    $thicknessPicker.hide();
                }

                if (annotation instanceof Annotations.TextHighlightAnnotation) {
                    $opacityPicker.hide();
                    $annotPreviewCanvas.hide();
                } else {
                    $opacityPicker.show();
                    opacityManager.update(annotation.Opacity * 100, false);
                    $annotPreviewCanvas.show();
                }

                if (numberOfColors <= 1) {
                    $colorButtonContainer.hide();
                } else if (numberOfColors === 2) {
                    $colorButtons.css('width', '50%');
                } else if (numberOfColors === 3) {
                    $colorButtons.css('width', '33%');
                }

                window.ControlUtils.updateAnnotPreview(annotation);

                setEditMode(userPrefs.getDefaultToolEditingMode(annotation));
                setEditPopupLocation(annotation);
            }
        });

        $annotEditProperties.find('#colorButton').on('click', function() {
            selectColorTab(colorTypes.color);
        });

        $annotEditProperties.find('#fillColorButton').on('click', function() {
            selectColorTab(colorTypes.fillColor);
        });

        $annotEditProperties.find('#textColorButton').on('click', function() {
            selectColorTab(colorTypes.textColor);
        });

        $annotEditNote.on('click', function() {
            var annotation = am.getSelectedAnnotations()[0];
            if (annotation) {
                if (am.useDefaultStickyNotes()) {
                    $(annotation).data('popup').show();
                    annotation.getPopup().setOpen(true);
                    am.drawAnnotations(annotation.PageNumber);
                }

                if (!am.canModify(annotation) && !am.getReadOnly()) {
                    $(document).trigger('startAddingReply', annotation);
                } else {
                    am.trigger('annotationDoubleClicked', annotation);
                }
            }
        });

        $basicColorPicker.on('click', 'li', function() {
            colorSelectedHandler($(this), $basicColorPicker);
        });

        var fontSizeManager = new DesktopPropertyManager('FontSize', $advancedFontSizeSlider, $fontSizeRadio);
        fontSizeManager.setAnnotationPropertyModifier(function(value) {
            return value + 'pt';
        });

        $advancedFontSizeSlider.slider({
            range: "min",
            min: 5,
            max: 72,
            value: 9,
            slide: function(event, ui) {
                var annotation = window.ControlUtils.getSelectedAnnotation();
                if (!annotation) {
                    return;
                }
                $(ui.handle).html(ui.value);
                fontSizeManager.update(ui.value);
            },
            stop: function(event, ui) {
                var annotation = window.ControlUtils.getSelectedAnnotation();
                if (!annotation) {
                    return;
                }
                am.trigger('annotationChanged', [[annotation], 'modify']);
                readerControl.fireEvent('defaultToolValueChanged', [annotation, 'FontSize', ui.value + 'pt']);
            },
            change: function(event, ui) {
                var $handle = $(ui.handle);
                $handle.attr('title', ui.value);
                $handle.html(ui.value);
            }
        });

        var thicknessManager = new DesktopPropertyManager('StrokeThickness', $advancedThicknessSlider, $thicknessRadio);
        thicknessManager.setDisplayUnit('pt');

        $advancedThicknessSlider.slider({
            range: "min",
            min: 1,
            max: 12,
            value: 1,
            slide: function(event, ui) {
                var annotation = window.ControlUtils.getSelectedAnnotation();
                if (!annotation) {
                    return;
                }
                $(ui.handle).html(ui.value);
                thicknessManager.update(ui.value);
            },
            stop: function(event, ui) {
                var annotation = window.ControlUtils.getSelectedAnnotation();
                if (!annotation) {
                    return;
                }
                am.trigger('annotationChanged', [[annotation], 'modify']);
                readerControl.fireEvent('defaultToolValueChanged', [annotation, 'StrokeThickness', ui.value]);
            },
            change: function(event, ui) {
                var $handle = $(ui.handle);
                $handle.attr('title', ui.value);
                $handle.html(ui.value);
            }
        });

        var opacityManager = new DesktopPropertyManager('Opacity', $advancedOpacitySlider, $opacityRadio);
        opacityManager.setDisplayUnit('%');
        opacityManager.setAnnotationPropertyModifier(function(value) {
            return value / 100;
        });

        function getTextValue(value) {
            // if it's 100 it doesn't fit on the slider handle so don't show any text
            return (value === 100) ? "" : value;
        }

        $advancedOpacitySlider.slider({
            range: "min",
            min: 0,
            max: 100,
            value: 100,
            slide: function(event, ui) {
                var annotation = window.ControlUtils.getSelectedAnnotation();
                if (!annotation) {
                    return;
                }
                $(ui.handle).html(getTextValue(ui.value));
                opacityManager.update(ui.value);
            },
            stop: function(event, ui) {
                var annotation = window.ControlUtils.getSelectedAnnotation();
                if (!annotation) {
                    return;
                }
                am.trigger('annotationChanged', [[annotation], 'modify']);
                readerControl.fireEvent('defaultToolValueChanged', [annotation, 'Opacity', ui.value / 100]);
            },
            change: function(event, ui) {
                var $handle = $(ui.handle);
                $handle.attr('title', ui.value);
                $handle.html(getTextValue(ui.value));
            }
        });

        var advancedColors = userPrefs.getAdvancedToolColors();
        advancedColors.forEach(function(color) {
            var $li = createColorElement(color);
            $addNewColorPicker.append($li);
            $advancedColorPicker.append($li.clone());
        });

        $advancedColorPicker.append(createColorElement('transparent'));

        $addColorButton.on('click', function(e) {
            e.stopImmediatePropagation();

            $annotEditProperties.hide();
            $addNewColor.show();

            deselectColor($addNewColorPicker);
            $selectAddColor.addClass('disabled');
        });

        $removeColorButton.on('click', function(e) {
            e.stopImmediatePropagation();

            removingColors(!isRemovingColors);
        });

        function setEditMode(mode) {
            currentEditMode = mode;
            selectColorTab(selectedColorPicker);

            if (currentEditMode === editMode.basic) {
                $basicPropertyEdit.addClass('selected');
                $basicProperties.show();
                $advancedPropertyEdit.removeClass('selected');
                $advancedProperties.hide();
                $annotPreviewCanvas.parent().insertBefore($basicPropertyContainer);
            } else if (currentEditMode === editMode.advanced) {
                $basicPropertyEdit.removeClass('selected');
                $basicProperties.hide();
                $advancedPropertyEdit.addClass('selected');
                $advancedProperties.show();
                $annotPreviewCanvas.parent().insertBefore($advancedPropertyContainer);
            }
        }

        $basicPropertyEdit.on('click', function() {
            setEditMode(editMode.basic);
            userPrefs.setDefaultToolEditingMode(window.ControlUtils.getSelectedAnnotation(), editMode.basic);
        });

        $advancedPropertyEdit.on('click', function() {
            setEditMode(editMode.advanced);
            userPrefs.setDefaultToolEditingMode(window.ControlUtils.getSelectedAnnotation(), editMode.advanced);
            setTransparentColorVisibility();
        });

        $advancedColorPicker.on('click', 'li', function() {
            colorSelectedHandler($(this), $advancedColorPicker);
        });

        $addNewColorPicker.on('click', 'li', function() {
            deselectColor($addNewColorPicker);
            selectColor($(this));
            $selectAddColor.removeClass('disabled');
        });

        function leaveAdvancedColorMenu() {
            $addNewColor.hide();
            $annotEditProperties.show();
        }

        $cancelAddColor.on('click', function() {
            leaveAdvancedColorMenu();
        });

        $selectAddColor.on('click', function() {
            if (!$(this).hasClass('disabled')) {
                var selectedColor = $addNewColorPicker.find('.color-selected').parent().attr('data-color');
                userPrefs.addToolColor(window.ControlUtils.getSelectedAnnotation(), selectedColorPicker, selectedColor);
                // refresh the list
                selectColorTab(selectedColorPicker);
                // automatically select the new color
                colorSelectedHandler($basicColorPickerList.find('li[data-color="' + selectedColor + '"]'), $basicColorPicker);
                leaveAdvancedColorMenu();
            }
        });
    }

    function showTextSelectMenu(startLocation) {
        textSelectData = startLocation;
        var quad = startLocation.quad;

        var pageLocation = {
            x: (quad.x1 + quad.x3) / 2,
            y: Math.min(quad.y1, quad.y3),
            pageIndex: startLocation.pageIndex
        };

        var displayMode = readerControl.docViewer.getDisplayModeManager().getDisplayMode();
        var location = displayMode.pageToWindow({
            x: pageLocation.x,
            y: pageLocation.y
        }, pageLocation.pageIndex);

        location.y -= $scrollView.scrollTop() + DIALOG_OFFSET;

        positionDialog(location, $scrollView.scrollLeft(), 'center bottom', function(location, dialog) {
            // if the dialog would be too close to the top then position it below the toolbar
            if (location.top < TOOLBAR_OFFSET) {
                location.top = TOOLBAR_OFFSET + DIALOG_OFFSET;
            }
            dialog.element.css(location);
        });
        $annotEditDialog.dialog('open');
    }

    function setupTextSelectionMenu() {
        var currentQuads = null;
        $textSelectionContainer = $('#textSelectionContainer');
        var $copyButton = $textSelectionContainer.find('#copyButton');

        if (!IS_COPY_SUPPORTED) {
            $copyButton.hide();
            $copyButton.next().addClass('leftRounded');
        }

        readerControl.docViewer.on('textSelected', function(e, quads) {
            // when the selection is cleared we should hide the dialog
            if (quads === null) {
                hideAnnotationEditDialog();
            }
        });

        var textSelectTool = readerControl.toolModeMap[window.PDFTron.WebViewer.ToolMode.TextSelect];
        textSelectTool.on('selectionComplete', function(e, startLocation, allQuads) {
            if (am.getReadOnly() || !readerControl.enableAnnotations) {
                // currently this is assuming that the only option besides creating annotations from a selection is copying
                if (!IS_COPY_SUPPORTED) {
                    // don't show selection menu in readonly mode
                    return;
                }
                $copyButton.siblings().hide();
                $copyButton.addClass('rightRounded');
            }

            currentDialogMode = dialogMode.textSelect;

            currentQuads = allQuads;
            $textSelectionContainer.show();
            $signatureSelectionContainer.hide();
            $annotEditButtons.hide();

            showTextSelectMenu(startLocation);
        });

        $copyButton.on('click', function() {
            readerControl.copyButtonHandler();
            hideAnnotationEditDialog();
        });

        function handleAnnotationCreate(buttonId, annotConstructor, annotTool) {
            /*jshint newcap:false */
            $textSelectionContainer.find('#' + buttonId).on('click', function() {
                for (var page in currentQuads) {
                    if (currentQuads.hasOwnProperty(page)) {
                        var pageIndex = parseInt(page, 10);
                        var pageQuads = currentQuads[pageIndex];
                        var textAnnot = new annotConstructor();
                        textAnnot.PageNumber = pageIndex + 1;
                        textAnnot.Quads = pageQuads;
                        textAnnot.Author = readerControl.getAnnotationUser();
                        textAnnot.StrokeColor = annotTool.defaults.StrokeColor;
                        if (Tools.TextAnnotationCreateTool.AUTO_SET_TEXT) {
                            textAnnot.setContents(readerControl.docViewer.getSelectedText());
                        }
                        am.addAnnotation(textAnnot);
                    }
                }

                readerControl.docViewer.clearSelection();
                hideAnnotationEditDialog();
            });
        }

        handleAnnotationCreate('selectHighlightButton', Annotations.TextHighlightAnnotation, readerControl.toolModeMap['AnnotationCreateTextHighlight']);
        handleAnnotationCreate('selectStrikeoutButton', Annotations.TextStrikeoutAnnotation, readerControl.toolModeMap['AnnotationCreateTextStrikeout']);
        handleAnnotationCreate('selectUnderlineButton', Annotations.TextUnderlineAnnotation, readerControl.toolModeMap['AnnotationCreateTextUnderline']);
        handleAnnotationCreate('selectSquigglyButton', Annotations.TextSquigglyAnnotation, readerControl.toolModeMap['AnnotationCreateTextSquiggly']);
    }

    function setupAnnotTools() {
        $toolList.on('click', 'span', function() {
            var $this = $(this);
            if ($this.attr('id') !== 'overflowTools') {
                var isAnnotTool = $this.hasClass('annotTool');

                if (isAnnotTool && am.getReadOnly()) {
                    docViewer.trigger('notify', 'readOnlyCreate');
                    return;
                }
                if (isAnnotTool && am.getMarkupOff()) {
                    docViewer.trigger('notify', 'markupOffCreate');
                    return;
                }

                var toolmode = $this.attr('data-toolmode');
                readerControl.setToolMode(toolmode);
            }
        });

        $overflowToolsContainer.on('click', 'span', function() {
            if (am.getReadOnly()) {
                docViewer.trigger('notify', 'readOnlyCreate');
                return;
            }
            if (am.getMarkupOff()) {
                docViewer.trigger('notify', 'markupOffCreate');
                return;
            }

            var $this = $(this);
            var toolmode = $this.attr('data-toolmode');
            readerControl.setToolMode(toolmode);
        });

        docViewer.on('mouseLeftDown', function() {
            hideAnnotationEditDialog();
        });

        docViewer.on('mouseLeftUp', function() {
            // setTimeout to work better with touch events
            setTimeout(function() {
                showAnnotationEditDialog();
            }, 0);
        });
    }

    function colorToHex(color) {
        var colorName = color.toHexString();
        if (!colorName) {
            colorName = 'transparent';
        }
        return colorName;
    }

    function colorNameToRGB(hexString) {
        if (hexString === 'transparent') {
            return new Annotations.Color(255, 255, 255, 0);
        } else {
            return new Annotations.Color(hexString);
        }
    }
});