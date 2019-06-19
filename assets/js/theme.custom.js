/* Add here all your JS customizations */
var infowindow;
var map;
var lat;
var lng;
function leadAjaxCall(p=0,geocoder,map,infowindow,lat,lng)
{   
    //console.log(lat +' '+lng);
    var locations = new Array();
    $.ajax({
        url : function_base_url,
        type : 'POST',
		data:{page:p,lat:lat,lng:lng } ,
        //dataType : 'json',
        success : function(data){
            location_data = jQuery.parseJSON(data);

            $(location_data).each(function(k,v) {
                //locations.push([v['company'], v['address']]);
                let latlngStr = v['latlng'].split(',', 2);
                let latlng = {lat: parseFloat(latlngStr[0]), lng: parseFloat(latlngStr[1])};
                locations.push([v['company'],latlng,v['address']]);
            });//return false;
            //console.log(locations);
            //return false;
            for (i = 0; i < locations.length; i++) {
				//console.log(locations[i]);
                geocodeAddress(locations[i]);               
            }
			if(locations.length > 0 && p < 6)
			{
                setTimeout(function(){ leadAjaxCall(p+3,geocoder,map,infowindow,lat,lng) }, 4000);
            	//leadAjaxCall(p,geocoder,map,infowindow);
			}
        }
		
    });
	function geocodeAddress(location) {
        geocoder.geocode( { 'location': location[1] }, function(results, status) {
        //geocoder.geocode( { 'address': location[0]+" "+location[1]}, function(results, status) {
        	//console.log("1 )"+status);
            if (status == google.maps.GeocoderStatus.OK) {
                //alert(results[0].geometry.location);
				//console.log(results[0].geometry.location);
                //map.setCenter(results[0].geometry.location);
                createMarker(results[0].geometry.location,location[0]+"<br>"+location[2]);
            } else  {
                console.log("1 = some problem in geocode " + status);
                //alert("some problem in geocode" + status);
            }
        }); 
    }

    function createMarker(latlng,html){
        var marker = new google.maps.Marker({
            icon: 'http://maps.google.com/mapfiles/ms/icons/blue-dot.png',
            position: latlng,
            map: map
        }); 

        google.maps.event.addListener(marker, 'mouseover', function() { 
            infowindow.setContent(html);
            infowindow.open(map, marker);
        });

        google.maps.event.addListener(marker, 'mouseout', function() { 
            infowindow.close();
        });
    }
	
}
function loadLeadMap(address='',postalcode='',function_base_url) {  

    var locations = [];

    var location_data = [];
    
    //console.log(dealer_sheet_data);return false;

    $("#lead_map").height("300px");
    /*var locations = [
      ['Bondi Beach', '1 Josephson Street,BELCONNEN ACT, 2617'],
      ['Coogee Beach', "4 O'Brien Place,GUNGAHLIN ACT, 2912"],
      ['Cronulla Beach', 'Cnr Princes Hwy & Miall Way,ALBION PARK NSW, 2527'],
      ['Manly Beach', '91 Markham Street,ARMIDALE NSW, 2350'],
      ['Maroubra Beach', '12 Marden Street,ARTARMON NSW, 2064']
    ];
    console.log(locations);*/
    
    var map = new google.maps.Map(document.getElementById('lead_map'), {
        zoom: 10,
        center: new google.maps.LatLng(-33.865143, 151.209900),
        mapTypeId: google.maps.MapTypeId.ROADMAP
    });

    var infowindow = new google.maps.InfoWindow();
    var geocoder = new google.maps.Geocoder();
    var lat;
    var lng;
	var marker, i;
		
    var region = 'AU';
    var zip = postalcode;
    var address = zip + ',' + region;
    geocoder.geocode({
        'address': address,
        'componentRestrictions': {
            'country': region,
            'postalCode': zip
        }
    }, function(results, status) {
        //check status
        if (status == google.maps.GeocoderStatus.OK) {
            lat = results[0].geometry.location.lat();
            lng = results[0].geometry.location.lng();
            console.log("1 ="+lng+ ' ' + lat);
            map.setCenter(results[0].geometry.location);
            //createMarker(address+" "+postalcode);
            createMarker(results[0].geometry.location,address+"<br>"+postalcode);
        } else {
            /*console.log('STATUS - ', status);
            console.log('Trying with only component restrictions.');*/
            geocoder.geocode({
                'componentRestrictions': {
                    'country': region,
                    'postalCode': zip
                }
            }, function(results, status) {
                if (status == google.maps.GeocoderStatus.OK) {
                    lat = results[0].geometry.location.lat();
                    lng = results[0].geometry.location.lng();
                    console.log("1 ="+lng+ ' ' + lat);
                    map.setCenter(results[0].geometry.location);
                    //createMarker(address+" "+postalcode);
                    createMarker(results[0].geometry.location,address+"<br>"+postalcode);
                    //console.log("Works! - ", status);
                } else {
                    console.log("noResults - ", status);
                }
            });
        }
    });
    
	        
      //console.log("2 ="+lng+ ' ' + lat); 
	  
    setTimeout(function(){ 
			//console.log("2 ="+lng+ ' ' + lat); 
			leadAjaxCall(0,geocoder,map,infowindow,lat,lng)
	}, 2000);
   // leadAjaxCall(10,geocoder,map,infowindow,lat,lng);

    
    /*function geocodeAddress(location) {
        geocoder.geocode( { 'address': location[0]+" "+location[1]}, function(results, status) {
        	console.log("1 )"+status);
            if (status == google.maps.GeocoderStatus.OK) {
                //alert(results[0].geometry.location);
                map.setCenter(results[0].geometry.location);
                createMarker(results[0].geometry.location,location[0]+"<br>"+location[1]);
            } else  {
                //alert("some problem in geocode" + status);
            }
        }); 
    }*/

    function createMarker(latlng,html){
        var marker = new google.maps.Marker({
            position: latlng,
            map: map
        }); 

        google.maps.event.addListener(marker, 'mouseover', function() { 
            infowindow.setContent(html);
            infowindow.open(map, marker);
        });

        google.maps.event.addListener(marker, 'mouseout', function() { 
            infowindow.close();
        });
    }
        
    /*var geocoder = new google.maps.Geocoder();
    //-33.767758,151.265958
    var latlng = new google.maps.LatLng(-33.767758, 151.265958);
    var mapOptions = {
        zoom: 7,
        center: latlng,
        streetViewControl: false,
        mapTypeControl: false,
        mapTypeControlOptions: {
          style: google.maps.MapTypeControlStyle.DEFAULT,
          position: google.maps.ControlPosition.BOTTOM_LEFT
        },
    }
    map = new google.maps.Map(document.getElementById('lead_map'), mapOptions); 

    if(address != '' || postalcode != '')
    {       
        var search_str = "car dealers in : "+address;
        if(postalcode != '')
        {
            search_str +=" "+postalcode;
        }
        search_str +=" - Australia Oceania";
        if(address == ''){
            var geocode_pram = { address : $.trim(search_str)};
        }else{
            var geocode_pram = { 
                componentRestrictions: {
                    country: 'AU',
                    postalCode: postalcode
                  }
            };
        }
        console.log(search_str);
        geocoder.geocode( geocode_pram, function(results, status) {
            
            if (status == 'OK') {
                var LatLng = results[0].geometry.location;
                map.setCenter(LatLng);
                var marker = new google.maps.Marker({
                    map: map,
                    position: LatLng,
                });
                infowindow = new google.maps.InfoWindow();
                var service = new google.maps.places.PlacesService(map);

                service.nearbySearch({
                  location: LatLng,
                  radius: 500,
                  type: ['car_dealer']
                }, callback);
            } 
        });
    }   */
}


var types_in = 'car_dealer';
function callback(results, status) {
    if (status === google.maps.places.PlacesServiceStatus.OK) {
        
        for (var i = 0; i < results.length; i++) {
            var point_obj = results[i];     
            createMarker(point_obj);
        }
    }
}
/*function createMarker(place) {      
    if($.inArray(types_in,place.types) > -1)
    {
        var placeLoc = place.geometry.location;
        var marker = new google.maps.Marker({
            map: map,
            position: place.geometry.location
        });
        var latlng_str = placeLoc.lat()+","+placeLoc.lng();
        //var map_link = '<a href="https://maps.google.com/maps?ll='+latlng_str+'&z=15" style="display:block !important;"> View On Google Maps</a>';
        var map_link = '<a href="https://www.google.com/maps/search/?api=1&query='+place.name+'&query_place_id='+place.place_id+'" target="_blank" style="display:block !important;"> View On Google Maps</a>';
        google.maps.event.addListener(marker, 'click', function() {
        infowindow.setContent('<div><strong>' + place.name + '</strong><br> '+map_link+'</div>');
        //infowindow.setContent(map_link);
        infowindow.open(map, this);
        });
    }
}*/
function loadMapOnChange()
{
    var address = '';
    var postcode = '';
    $(".load_map").on("change",function(){
        var inputs = $(".load_map");
        $.each(inputs,function(key,v){
            if(key == 0)
            {
                address = $(v).val();
            }
            if(key == 1)
            {
                postcode = $(v).val();
            }
        });
        loadLeadMap(address+"  ",postcode);
    });
}
function loadLeadMap2(address,postalcode)
{

	var geocoder = new google.maps.Geocoder();

	geocoder.geocode( { 'address': address+" "+postalcode+" - Australia Oceania"}, function(results, status) {
		//console.log("1 )"+status);
		if (status == google.maps.GeocoderStatus.OK) {
			//alert(results[0].geometry.location);
			map.setCenter(results[0].geometry.location);
			createMarker(results[0].geometry.location,location[0]+"<br>"+location[1]);
		} else  {
			//alert("some problem in geocode" + status);
		}
	});
}

// lead tender email template model
$(document).ready(function(){
    $('.summernote_2').summernote({
        airMode: true,
        height: 250,
        toolbar: [
            ['style', ['style']],
            ['font', ['bold', 'italic', 'underline', 'clear']],
            ['fontname', ['fontname']],
            ['color', ['color']],
            ['para', ['ul', 'ol', 'paragraph']],
            ['height', ['height']],
            ['table', ['table']],
            ['insert', ['link', 'picture', 'video']],
            ['view', ['codeview']],
            ['help', ['help']]
        ],
        codemirror: {
            theme: 'monokai',
            htmlMode:true,
            lineNumbers: true,
            mode: 'text/html'
        }
    });
    $(document).on('click', '#open_email_paragraph_model', function() { 
        $("#email_template_paragraph_model").modal();       
        let template_data = $('#email_paragraph').val();        
    });

    $(document).on('submit', '#form_email_template', function () {
            var postData = new FormData(this);
            /*$.ajax({
                url: update_email_template_url,
                type: "POST",
                processData: false,
                contentType: false,
                cache: false,
                data: postData,
                success: function (response) {
                    var json = $.parseJSON(response);
                    console.log(json);
                    if (json['success'] == 'Added'){
                        window.location.href = "<?php echo base_url('special/discount') ?>";
                    }                    
                    return false;
                },
            });*/
            return false;
        });

    
});

function update_email_template ()
{
    //alert('');
    var email_template_id = $("#email_template_paragraph_model").find("#email_template_id").val();
    var email_content = CKEDITOR.instances.email_template_content.getData();
    /*email_content = replaceAll(email_content, '&quot;', '%27');
    email_content = replaceAll(email_content, '&lt;', '%3C');
    email_content = replaceAll(email_content, '&qt;', '%3E');
    email_content = replaceAll(email_content, '&amp;', '%26');
    email_content = replaceAll(email_content, '&', '%26');*/
    
    //var dataString = "&email_template_id="+email_template_id+"&email_content="+email_content;

    //console.log(email_content);
    $.ajax({
        type: "POST",
        url: update_email_template_url,
        data: {email_template_id :email_template_id, email_content:email_content },
        success: function(result){
            alert ("Email Template Updated successfully!");
            $("#email_template_paragraph_model").modal("hide");
        }
    });
}