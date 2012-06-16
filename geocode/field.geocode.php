<?php defined('BASEPATH') or exit('No direct script access allowed');

/**
 * PyroStreams Geocode autocomplete address field type
 *
 * @author		David Alberts
 * 
 */
class Field_geocode
{
	public $field_type_slug			= 'geocode';
	
	public $db_col_type				= 'varchar';

	public $version					= '1.0';

	public $author					= array('name'=>'Dave Albers');
	
	public $custom_parameters		= array('latlng_fields', 'map_width', 'map_height');
 //Setting Defaults
 public $map_width = "100%";
 
 public $map_height = "300px";

	
	// --------------------------------------------------------------------------

 	/**
	 * Event
	 *
	 * Add the google maps api 
	 *
	 * @access	public
	 * @return	void
	 */
	public function event()
	{
		$this->CI->type->add_misc("<script type='text/javascript' src='http://maps.google.com/maps/api/js?sensor=false'></script>");
	}
 
 
	/**
	 * Output form input
	 * 
	 * @param	array
	 * @param	array
	 * @return	string
	 */
	public function form_output($data)
	{
  $options = array();   
		$options['name'] 	= $data['form_slug'];
		$options['id']		= $data['form_slug'];
		$options['value']	= $data['value'];
		$options['style']	= 'width:97%';
		
		if (isset($data['max_length']) and is_numeric($data['max_length']))
		{
			$options['maxlength'] = $data['max_length'];
		}
  $vars = "var input_text = $('#{$data['form_slug']}');";
  if (isset($data['custom']['latlng_fields']['lat']) && isset($data['custom']['latlng_fields']['lng'])){
      $vars .= "var input_lat = $('#{$data['custom']['latlng_fields']['lat']}'); var input_lng = $('#{$data['custom']['latlng_fields']['lng']}');";
  }
  //Change the height/width to desired params
  if(isset($data['custom']['map_width'])){$this->map_width = $data['custom']['map_width'];}
  if(isset($data['custom']['map_height'])){$this->map_height = $data['custom']['map_height'];}
  //add the map div
  $mapcode = "<div id='map' style='width:{$this->map_width};height:{$this->map_height}'></div>";
  //add the map code
  $mapcode .= '
  <script type="text/javascript">
 $(window).load(function() {
  var geocoder
    , map
    , infowindow
    , input_text
    , has_data;
  '.$vars.'
  
  //Party starting
  function initialize() {
    geocoder = new google.maps.Geocoder();
    var latlng = new google.maps.LatLng(39.810646,-98.556976);
    var myOptions = {
      zoom: 4,
      center: latlng,
      mapTypeId: google.maps.MapTypeId.ROADMAP
    }
    if(input_lat.val() && input_lng.val()){
        has_data = 1;
        var latlng = new google.maps.LatLng(parseFloat(input_lat.val()), parseFloat(input_lng.val()));
        myOptions = {
            zoom: 16,
            center: latlng,
            mapTypeId: google.maps.MapTypeId.ROADMAP
        }
    }
    map = new google.maps.Map(document.getElementById("map"), myOptions);
    if(has_data){
       var marker = new google.maps.Marker({
            position: latlng,
            map: map,
            title: input_text.val()
        });
    }
  }

  input_text.autocomplete({
      minLength: 10,
      //This bit uses the geocoder to fetch address values
      source: function(request, response) {
        geocoder.geocode( {"address": request.term}, function(results, status) {
          response($.map(results, function(item) {
            return {
              label:  item.formatted_address,
              value: item.formatted_address,
              components: item.address_components,
              lat: item.geometry.location.lat(),
              lng: item.geometry.location.lng(),
              latlng: item.geometry.location,
              location_type: item.geometry.location_type
            }
          }));
        })
      },
      //This bit is executed upon selection of an address
      select: function(event, ui) { 
         input_lat.val(ui.item.lat)
         input_lng.val(ui.item.lng)
         myOptions = {
            zoom: 16,
            center: ui.item.latlng,
            mapTypeId: google.maps.MapTypeId.ROADMAP
        }
         map.setOptions(myOptions)
         var marker = new google.maps.Marker({
            position: ui.item.latlng,
            map: map,
            title: input_text.val()
        });
      
      }

   })
  //You are go for throttle up
  initialize()
  });
  </script>    
  ';
		
		return form_input($options).$mapcode;
	}
	
}