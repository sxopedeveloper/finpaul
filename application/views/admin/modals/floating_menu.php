<style type="text/css">
  
  #temp_email_modal{
    z-index: 10000000000000;
  }
  #assign_cqo{
  	z-index: 10000000000000;
  }
  #diarize_modal{
    z-index: 10000000000000;
  }
  #temp_tile_merger{
    z-index: 10000000000000;
  }
  #fq_emailer{
    z-index: 10000000000000;
  }
  #system_mail_template_model{
    z-index: 10000000000000;
  }
  #email_template_model{
    z-index: 100000000000000;
  }
  #preview_email_template_model {
    z-index: 100000000000001;
  }
  #open_email_modal{
    z-index: 100000000000000;
  }
  #create_email_modal{
    z-index: 100000000000000; 
  }
  #send_blank_email_modal{
    z-index: 100000000000000; 
  }
  #all_requirements_modal{
   z-index: 100000000000000 !important;
  }
  #abn_modal{
    z-index: 100000000000000 !important;
  }
  #annot_tile_modal{
   z-index: 100000000000000 !important; 
  }
  #edit_pdf_modal_final{
   z-index: 100000000000000 !important;  
  }
  #global_dep_modal{
   z-index: 100000000000000 !important; 
  }
  #view_sent_email{
   z-index: 100000000000000 !important;  
  }
  #map_lead_modal{
    z-index: 100000000000000 !important;  
  }
  #change_color_status_modal{
   z-index: 100000000000000 !important;   
  }
  #historical_quotes_modal{
    z-index: 100000000000000 !important;   
  }
  #modal-dialog-menu{
  	max-width: 400px;
  }
  #temp_email_modal .panel-heading{
    padding-top: 18px !important;
    padding-bottom: 10px !important;
  }

  /*.sort { list-style-type: none; margin: 20px 0; padding: 0; width: 450px; float: left; }
  .sort li { margin: 10px 10px 10px 10px; padding: 1px; float: left; width: 100px; height: 140px; font-size: 4em; text-align: center; }*/
  .sort { list-style-type: none; margin: 20px 0; padding: 5px; width: 100%; float: left; background: #eee; }
  .sort li { margin: 5px 5px 5px 0px; padding: 1px; float: left; min-width: 100px; min-height: 140px; font-size: 4em; text-align: center; }
  .sort2 { list-style-type: none; margin: 20px 0; padding: 5px; width: 100%; float: left; background: #eee; }
  .sort2 li { margin: 5px 5px 5px 0px; padding: 1px; float: left; min-width: 100px; min-height: 140px; font-size: 4em; text-align: center; }
  html>body .sort li { height: 1.5em; line-height: 1.2em; }
      .ui-state-highlight { height: 1.5em; line-height: 1.2em; }
  html>body .sort2 li { height: 1.5em; line-height: 1.2em; }
  .ui-state-highlight { height: 1.5em; line-height: 1.2em; }
  .close {
    height: 10px;
    z-index: 10000000;
    }
.sort_anon { list-style-type: none; margin: 20px 0; padding: 5px; width: 100%; float: left; background: #eee; }
.sort_anon li { margin: 5px 5px 5px 0px; padding: 1px; float: left; min-width: 100px; min-height: 140px; font-size: 4em; text-align: center; }
html>body .sort_anon li { height: 1.5em; line-height: 1.2em; }
  .ui-state-highlight { height: 1.5em; line-height: 1.2em; }
  
#assign_cqo  .modal-dialog {
    width: 1208px;
    padding-top: 30px;
    padding-bottom: 30px;
}

/* checkbox switch */
.switch {
  position: relative;
  display: inline-block;
  width: 60px;
  height: 34px;
  float:right;
}

/* Hide default HTML checkbox */
.switch input {display:none;}

/* The slider */
.slider {
  position: absolute;
  cursor: pointer;
  top: 0;
  left: 0;
  right: 0;
  bottom: 0;
  background-color: #ccc;
  -webkit-transition: .4s;
  transition: .4s;
}

.slider:before {
  position: absolute;
  content: "";
  height: 26px;
  width: 26px;
  left: 4px;
  bottom: 4px;
  background-color: white;
  -webkit-transition: .4s;
  transition: .4s;
}

input.default:checked + .slider {
  background-color: #444;
}
input.primary:checked + .slider {
  background-color: #2196F3;
}
input.success:checked + .slider {
  background-color: #8bc34a;
}
input.info:checked + .slider {
  background-color: #3de0f5;
}
input.warning:checked + .slider {
  background-color: #FFC107;
}
input.danger:checked + .slider {
  background-color: #f44336;
}

input:focus + .slider {
  box-shadow: 0 0 1px #2196F3;
}

input:checked + .slider:before {
  -webkit-transform: translateX(26px);
  -ms-transform: translateX(26px);
  transform: translateX(26px);
}

/* Rounded sliders */
.slider.round {
  border-radius: 34px;
}

.slider.round:before {
  border-radius: 50%;
}

#historical_quotes_table tr{
  color:black !important;
}
/**/
</style>
<div class="side_bar_buttons_container">
  <i class="fa fa-file-o btn-sidenote side_bar_button" style="background-color: #0088cc" data-toggle="tooltip" data-placement="left" title="Open Notes"></i>
  <br/>
  <?php if($admin_flag != 1){ ?>
    <div class="btn-toolbar pull-right" style="position: fixed;right: 100px;top: 50px;">
        <a href="javascript:;" class="btn btn-primary btn-save" onclick="save_fapplication_info_2(22)">Save And Reopen</a>
        <a href="javascript:;"  class="btn btn-primary btn-save" onclick="save_fapplication_info_2(1)">Save And Close</a>
    </div>
    <i class="fa fa-floppy-o btn-save side_bar_button" onclick="save_fapplication_info_2(1)" data-toggle="tooltip" data-placement="left" title="Save and Close" style="background-color: #47a447 !important;"></i>
  <?php 
    }
    else
    {
  ?>
  
    <i class="fa fa-ban admin-close side_bar_button"  data-toggle="tooltip" data-placement="left" title="Close" style="background-color: #47a447 !important;"></i>
  <?php 
    }
  $fq_admin_id = [327,259,272];
  $user_id_req = $this->session->userdata('user_id'); 
  if(in_array($user_id_req, $fq_admin_id))
  {
  ?>
  
  <br>
  
  <!--i class="fa fa-unlink unallocate_fk_lead side_bar_button" data-toggle="tooltip" data-placement="left" title="Unallocate Lead"></i-->
  <br/>
  <i class="fa fa-file-pdf-o btn-req-list side_bar_button" data-toggle="tooltip" data-placement="left" title="Edit Requirement List"></i>
  <br/>
  <i class="fa fa-cloud global_dep side_bar_button" data-toggle="tooltip" data-placement="left" title="Global Depository"></i>
  <?php 
  }
  ?>
  
  <br/>
  
  <i class="fa fa-share btn-submit submit_to_admin side_bar_button" data-toggle="tooltip" data-placement="left" title="Submit to Admin"></i>
  <br/>
  <i class="fa fa-dollar temp_email side_bar_button" data-toggle="tooltip" data-placement="left" title="Tax Invoice Email"></i>
  <br/>
  <i class="fa fa-file-image-o side_bar_button export_application" data-toggle="tooltip" data-placement="left" title="Export Application"></i>
  <br/>
  <i class="fa fa-user assign_cqo side_bar_button" data-toggle="tooltip" data-placement="left" title="Dealer Search"></i>
  <br/>
  <i class="fa fa-crosshairs open_lead_assign side_bar_button" data-toggle="tooltip" data-placement="left" title="Quote Search" id="open_lead_assign"></i>
  <!--br/>
  <i class="fa fa-users side_bar_button" data-toggle="tooltip" data-placement="left" title="Lead Pop-up" id="open_lead_popup" data-lead_id=""></i-->
  <br/>
  <i class="fa fa-calendar diarize_btn side_bar_button" data-toggle="tooltip" data-placement="left" title="Diarize"></i>
  <br/>
  <i class="fa fa-bar-chart-o update_status_btn side_bar_button" data-toggle="tooltip" data-placement="left" title="Update Status"></i>
  <br/>
  <i class="fa fa-envelope-o email_templates_modal side_bar_button" data-toggle="tooltip" data-placement="left" title="Email Templates"></i>
  <br/>
  <i class="fa fa-paper-plane-o sent_box_button side_bar_button" data-toggle="tooltip" data-placement="left" title="Email History"></i>
  <br/>
<?php if(in_array($user_id_req, $fq_admin_id)){ ?>
  <i class="fa fa-envelope system_email_templates_modal side_bar_button" data-toggle="tooltip" data-placement="left" title="System Email Templates"></i>
  <br/>
<?php } ?> 
    
<i class="fa fa-archive   historical_quotes_btn side_bar_button" data-toggle="tooltip" data-placement="left" title="All Historical Quotes"></i>
  <br>
  
  <i class="fa fa-list email_list_btn side_bar_button" data-toggle="tooltip" data-placement="left" title="Email List"></i>
  <br/>
  
  <i class="fa fa-trash-o delete_floating_btn side_bar_button" data-toggle="tooltip" data-placement="left" title="Delete Calendar Item" style="background-color: #d2322d !important;"></i>
</div>
<!-- Modal -->
<div class="modal fade" id="assign_cqo" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
  <div class="modal-dialog modal-sm" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h4 class="modal-title">Dealer Search</h4>
      </div>
      <div class="modal-body" id="assign_cqo_body">
        <div class="form-group" id='assign'>
          
        </div>
      </div>
    </div>
  </div>
</div>

<div class="modal fade" role="dialog" id="map_lead_modal">
  <div class="modal-dialog" style="width: 80%;">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title">Quote Search</h4>
      </div>
      <div class="modal-body" >
        <div class="search_lead_div_form">
          <div class="form-group" id="quotesearch">
            
          </div>
        </div>
      </div>
     
    </div><!-- /.modal-content -->
  </div><!-- /.modal-dialog -->
</div><!-- /.modal -->

<div id="temp_email_modal" class="modal fade">
  <div class="modal-dialog" style="width: 80%;">
    <section class="panel">
      <header class="panel-heading">
        <h2 class="panel-title">Send Email</h2>
      </header>
      <div class="panel-body">
        <div class="modal-wrapper">
          <div class="modal-text">
            <input value="" id="email_template_id" name="email_template_id" type="hidden">
            <div class="form-group">
              <input value="" class="form-control" id="email_recipients" name="email_recipients" type="text" placeholder="Recipients">
            </div>
            <div class="form-group">
              <input value="" class="form-control" id="email_subject" name="email_subject" type="text" placeholder="Subject">
            </div>
            <div class="form-group invoice_btn_div">
              <input value="" id="hidden_attachment" name="hidden_attachment" type="hidden">
              <span class="btn btn-primary attach_tax_invoice btn-sm">Produce Tax Invoice File</span>
            </div>            
            <div class="form-group">
              <div class="summernote" id="email_content" name="email_content" data-plugin-summernote data-plugin-options='{ "height": 240, "codemirror": { "theme": "ambiance" } }'></div>
              <!-- <textarea class="form-control" id="email_content" name="email_content" style="min-height: 400px;"></textarea> -->
            </div>
          </div>
        </div>
      </div>
      <footer class="panel-footer">
        <div class="row">
          <div class="col-md-12 text-right">
            <button type="button" class="btn btn-primary send_email_invoice" >Send Email</button>                     
          </div>
        </div>
      </footer>
    </section>          
  </div>
</div>
<div class="modal fade" id="diarize_modal" role="dialog" aria-labelledby="myModalLabel">
  <div class="modal-dialog modal-sm" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h4 class="modal-title">Diarize</h4>
      </div>
      <div class="modal-body" id="diarize_body">
        <div class="form-group">
          <div class="col-md-10">
              <div class="row">
                <div class="col-md-6">
                  <div class="input-group">
                    <span class="input-group-addon">
                      <i class="fa fa-calendar"></i>
                    </span>
                    <input type="text" class="form-control" id="diarize_date">
                  </div>
                  <!-- <input type="checkbox" name="alarm_status" id="alarm_status" value="0"> Set Alarm -->
                  <div>
                    Set Alarm
                    <label class="switch ">
                      <input type="checkbox" name="alarm_status" id="alarm_status" class="success">
                      <span class="slider round"></span>
                    </label>
                  </div>
                </div>              
                <div class="col-md-6">
                  <!-- <div class="input-group">
                    <span class="input-group-addon">
                      <i class="fa fa-clock-o"></i>
                    </span>
                    <input type="text" data-plugin-timepicker class="form-control" id="diarize_time" data-plugin-options='{ "minuteStep": 30 }'>
                  </div> -->
                  <?php
                  $currentTime = date('g:i');
                  $currentTime = strtotime($currentTime);
                  ?>
                  <select id="diarize_time" class="form-control input-xs">
                  <?php
                    $start=strtotime('00:00');
                    $end=strtotime('23:30');
                    for ($i=$start;$i<=$end;$i = $i + 30*60)
                    {
                      $disabled = '';
                      if($i <= $currentTime) {
                        $disabled = 'disabled';
                      }
                      echo "<option value='".date('g:i A',$i)."' ".$disabled.">".date('g:i A',$i)."</option>";
                    }
                  ?>
                  </select>
                </div>
              </div>
          </div>
          <div class="col-md-2">
            <button class="btn btn-primary btn-sm" id="diarize_submit">Diarize</button>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>
<div class="modal fade" id="temp_tile_merger" role="dialog" aria-labelledby="myModalLabel">
  <div class="modal-dialog modal-sm" role="document" style="width: 95%;">
    <div class="modal-content">
      <div class="modal-header">
        <h4 class="modal-title">Document Merger</h4>
      </div>
      <div class="modal-body" style="margin-bottom: 20px;">
        <div class="row">
          <div class="col-md-8" id="doc_merger_body">
          </div>
          <div class="col-md-4">
            <div class="row">
              <div class="col-md-12">
                <p>Drop Here</p>
                <ul id="sortX" class="sort2" style="background: #eee !important; border-width:4px; border-style:dashed; padding: 10px;">
                </ul>
              </div>
            </div>
            <div class="row">
              <div class="col-md-12">
                <form action="<?= site_url( 'fapplication/final_merge' );?>" method="post" id="hidden_form">
                  <input type="hidden" name="id_array" value="" id="id_array">
                  <input type="hidden" name="file_array" value="" id="id_array">
                  <input type="text" class="form-control input-sm" name="new_file_name" id="new_file_name" placeholder="New File Name">
                </form>
              </div>
            </div>
          </div>
        </div>
      </div>
      <footer class="panel-footer">
        <div class="row">
          <div class="col-md-12 text-right">
            <button type="button" class="btn btn-primary submit_merged">Merge</button>
            <button type="button" class="btn btn-primary close_merger_modal">Close</button>                    
          </div>
        </div>
      </footer>
    </div>
  </div>
</div>
<div class="modal fade" id="abn_modal" role="dialog" aria-labelledby="myModalLabel">
  <div class="modal-dialog modal-sm" role="document" style="width: 70%;">
    <div class="modal-content">
      <div class="modal-header">
        <h4 class="modal-title">ABN Search</h4>
      </div>
      <div class="modal-body">
        <div class="row">
          <div class="col-md-6">
            <ul class="nav nav-tabs" role="tablist">
              <li role="presentation" class="active"><a href="#abn_tab" aria-controls="abn_tab" role="tab" data-toggle="tab">ABN</a></li>
              <li role="presentation"><a href="#name_tab" aria-controls="name_tab" role="tab" data-toggle="tab">ABR NAME</a></li>
            </ul>
            <div class="tab-content">
              <div role="tabpanel" class="tab-pane active" id="abn_tab">
                <div class="input-group mb-md">
                  <input type="text" class="form-control input-sm abn" name="abn" placeholder="ABN">
<!--                     <span class="input-group-btn">
                      <button class="btn btn-primary btn-sm search_abn_btn" type="button">Search</button>
                    </span> -->
                </div>
              </div>
              <div role="tabpanel" class="tab-pane" id="name_tab">
                <div class="input-group mb-md">
                  <input type="text" class="form-control input-sm abr_name abn_name" name="abr_name" placeholder="ABR NAME">
                    <span class="input-group-btn">
                      <button class="btn btn-primary btn-sm search_abn_btn" type="button">Search</button>
                    </span>
                </div>
              </div>
            </div>
          </div>
        </div>
        <hr>
        <div class="row">
          <div class="col-md-12" id="anb_results">
          </div>
        </div>
      </div>
      <footer class="panel-footer">
        <div class="row">
          <div class="col-md-12 text-right">
            <button type="button" class="btn btn-primary close_abn_modal">Close</button>                    
          </div>
        </div>
      </footer>
    </div>
  </div>
</div>
<div class="modal fade" id="annot_tile_modal" role="dialog" aria-labelledby="myModalLabel">
  <div class="modal-dialog modal-sm" role="document" style="width: 70%;">
    <div class="modal-content">
      <div class="modal-header">
        <h4 class="modal-title">Annotate Document</h4>
      </div>
      <div class="modal-body">
        <div class="row">
          <input type="hidden" name="hidden_orig_file_name" id="hidden_orig_file_name" >
          <div class="col-md-12" id="annotate_body">
          </div>
        </div>
      </div>
      <footer class="panel-footer">
        <div class="row">
          <div class="col-md-12 text-right">
            <button type="button" class="btn btn-primary submit_annotations">Save PDF</button>
            <button type="button" class="btn btn-primary close_anon_modal">Close</button>                    
          </div>
        </div>
      </footer>
    </div>
  </div>
</div>
<div class="modal fade" id="edit_pdf_modal_final" role="dialog" aria-labelledby="myModalLabel">
  <div class="modal-dialog modal-sm" role="document" style="width: 70%;">
    <div class="modal-content">
      <div class="modal-body">
        <div class="row">
          <input type="hidden" name="hidden_page" id="hidden_page" >
          <img src="" style="display: none;" id="hidden_image">
          <div class="row">
            <div class="col-md-12 text-center">
              <form class="form-inline" style="padding-left: 15px;">
                <div class="form-group">
                  <label class="sr-only">Input Text</label>
                  <input type="text" class="form-control" id="input_txt" placeholder="Input Text">
                </div>
                <div class="form-group">
                  <label class="sr-only">Font</label>
                  <select class="form-control" id="font">
                    <option value="Helvetica">Helvetica</option>
                    <option value="Calibri">Calibri</option>
                  </select>
                </div>
                <div class="form-group">
                  <label class="sr-only">Font Size</label>
                  <select class="form-control" id="font_size">
                    <option value="11">11</option>
                    <option value="12">12</option>
                    <option value="13">13</option>
                    <option value="14">14</option>
                    <option value="15">15</option>
                    <option value="16">16</option>
                    <option value="17">17</option>
                    <option value="18">18</option>
                  </select>
                </div>
                <div class="form-group">
                  <label class="sr-only">Color</label>
                  <input type="text" data-plugin-colorpicker class="colorpicker-default form-control" value="#8fff00" placeholder="Color" id="anot_color" />
                </div>
                <span style="cursor: pointer;cursor: hand;" class="btn btn-default" id="input_anot_settings">Input</span>
                <span style="cursor: pointer;cursor: hand;" class="btn btn-default" id="input_signature">Input Signature</span>
                <span style="cursor: pointer;cursor: hand;" class="btn btn-default" id="input_check">Input Check</span>
                <span style="cursor: pointer;cursor: hand;" class="btn btn-success" id="finaliz_page">Flatten</span>
                <span style="cursor: pointer;cursor: hand;" class="btn btn-danger" id="clear_canvas">Clear All</span>
              </form>
            </div>
          </div>
          <hr>
          <div class="row">
            <div class="col-md-12 text-center" id="edit_pdf_body">
              <canvas id="anot_canvas" style="border:1px solid #000;"></canvas>
            </div>
          </div>
        </div>
      </div>
      <footer class="panel-footer">
        <div class="row">
          <div class="col-md-12 text-right">
            <button type="button" class="btn btn-primary close_edit_pdf_final">Close</button>                    
          </div>
        </div>
      </footer>
    </div>
  </div>
</div>
<div class="modal fade" tabindex="-1" role="dialog" id="global_dep_modal">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h4 class="modal-title">Global File Depository</h4>
      </div>
      <div class="modal-body" id="global_dep_body">
        <div class="row">
          <div class="col-md-12">
            <div class="dropzone global_upload" ></div>
          </div>
        </div>
        <!-- <br/> -->
        <hr>
        <div class="row">
          <div class="col-md-12">
            <table class="table table-striped">
              <tbody id="global_table_body">
              </tbody>
            </table>
          </div>
        </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" id="close_global_dep_modal">Close</button>
      </div>
    </div><!-- /.modal-content -->
  </div><!-- /.modal-dialog -->
</div><!-- /.modal -->
<div class="modal fade" tabindex="-1" role="dialog" id="view_sent_email">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-body">
        <p id="sent_email_body"></p>
      </div>
    </div><!-- /.modal-content -->
  </div><!-- /.modal-dialog -->
</div><!-- /.modal -->

<div class="modal fade" id="change_color_status_modal" role="dialog" aria-labelledby="myModalLabel">
  <div class="modal-dialog modal-sm" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h4 class="modal-title">Update Status</h4>
      </div>
      <div class="modal-body">
        <div class="row">
          <div class="col-md-12">
            <select class="form-control input-md update_status_color_field" id="update_status_color_field">
              <option value="1">Attempted</option>
              <option value="2">App Started</option>
              <option value="3">Submitted</option>
              <option value="4">Approved</option>
              <option value="5">Settlement</option>
              <option value="11">Ordered</option>
            </select>
          </div>
        </div>
      </div>
      <footer class="panel-footer">
        <div class="row">
          <div class="col-md-12 text-right">
            <button type="button" class="btn btn-primary" id="update_color_status_btn">Update</button>
          </div>
        </div>
      </footer>
    </div>
  </div>
</div>



<div class="modal fade" role="dialog" id="historical_quotes_modal">
  <div class="modal-dialog" style="width: 90%;">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title">Historiacal Quotes</h4>
      </div>
      <div class="modal-body" >
        <div class="historical_quotes_filter">
          <div class="row">
            <div class="col-md-2">
              <?php
              $carmakes = $this->car_model->get_makes();
              ?>
                <select class="form-control input-md" id="search_make" name="search_make">
                  <option value="">-Make-</option>
                  <?php 
                 
                    foreach ($carmakes as $m_key => $m_val) 
                    {
                      ?>
                      <option value="<?php echo $m_val->name;?>" data-id="<?php echo $m_val->id_make;?>"><?php echo $m_val->name;?></option>
                      <?php
                    }
                  ?>
                </select>
            </div>
            
            <div class="col-md-2">
              <select class="form-control input-md" id="search_model" name="search_model">
                <option value="">-Model-</option>
              </select>
            </div>

            <div class="col-md-4">
              <select class="form-control input-sm" id="search_rb_data" name="search_rb_data">
              <option value="">-Select Specific Car-</option></select>
            </div>

            <div class="col-md-3">
              <select class="form-control mb-md" name="seach_state" id="search_state">
                <option name="state" value="">-State-</option>
                <option name="state" value="ACT">ACT - Australian Capital Territory</option>
                <option name="state" value="NSW" >NSW - New South Wales</option>
                <option name="state" value="NT">NT - Northern Territory</option>
                <option name="state" value="QLD">QLD - Queensland</option>
                <option name="state" value="SA">SA - South Australia</option>
                <option name="state" value="TAS">TAS - Tasmania</option>
                <option name="state" value="VIC">VIC - Victoria</option>
                <option name="state" value="WA">WA - Western Australia</option>
              </select>
            </div>
          </div>
          <div class="row">
          
              <div class="col-md-2">
                <select class="form-control mb-md" name="seach_dealer" id="search_dealer">
                  <option  value="">-Dealer-</option>
                </select>
              </div>

              <div class="col-md-2">
              <input  class="form-control input-sm datepicker" name="filter_from_dt" id="filter_from_dt" type="readonly">
              </div>

              <div class="col-md-2">
              <input  class="form-control input-sm datepicker " name="filter_to_dt" id="filter_to_dt" type="readonly">
              </div>

          </div>
          
          <div class="row">
            <div class="col-md-8">
              
            </div>
            <div class="col-md-2">
              <button style="float:right" name="submit" class="btn btn-primary" id="all_quotes_filter" type="submit">Apply Filter</button>
            </div>
            <div class="col-md-2">
              <button  name="submit" class="btn btn-default" id="all_quotes_clear" type="submit">Clear Filter</button>
            </div>
          </div>
        </div>
        <div class="historical_quotes_form" style="margin-top:5%">
          <div class="form-group" id="historical_quotes_body">
            <table class="table table-bordered table-condensed mb-non " id="historical_quotes_table" cellspacing="0" cellpadding="0" style="white-space:nowrap;">
              <thead>
                  <tr style="background-color: #f9f9f9;color: black;">
                      <th><b>View</b></th>
                      <th><b>Make</b></th>
                      <th><b>Modal</b></th>
                      <th><b>Car Name</b></th>
                      <th><b>Registration Type</th>
                      <th><b>Dealer</b></th>
                      <th><b>State</b></th>
                      <th><b>Quoted Price</b></th>
                      <th><b>On Road</b></th>
                      <th><b>Car Off Road</b></th>
                      <th><b>Dealer Notes</b></th>
                      <th><b>Accessories</b></th>
                      <th><b>Datetime</b></th>
                  </tr>
              </thead>
              <tbody>
              </tbody>
            </table>
          </div>
        </div>
      </div>
     
      <footer class="panel-footer">
        <div class="row">
          <div class="col-md-12 text-right">
            <button type="button" class="btn btn-primary close_all_historical_quotes">Close</button>                    
          </div>
        </div>
      </footer>

    </div><!-- /.modal-content -->
  </div><!-- /.modal-dialog -->
</div><!-- /.modal -->
