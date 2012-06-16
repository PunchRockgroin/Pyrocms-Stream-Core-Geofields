Pyrocms-Stream-Core-Geofields
=============================

A very very simple implementation of Google Maps v3 API and Address - Latitude - Longitude storage for Stream Core API

Uses the Google Maps Javascript API v3 tied to a textfield to autocomplete geocode data in the location address field. When the address is selected, populates the map and fills in the read only lat/lng fields. Very very simple in what it does, in that it stores an address, latitude and longitude.


Typical usage:
<pre>
$fields = array(    
   array(
				'name'			=> 'Location address',
				'slug'			=> 'location_address',
				'namespace'		=> <your namespace>,
				'type'			=> 'geocode',
				'extra'			=> array(
					'max_length' => 255, 
					'latlng_fields' => array(
						'lat'=> 'location_lat', //required
						'lng'=> 'location_lng', //required
						'map_width' => '100%', //optional
						'map_height' => '300px' //optional
						)
				),
				'assign'		=> <assigned_to>,
			),    
   array(
				'name'			=> 'Location latitude',
				'slug'			=> 'location_lat',
				'namespace'   	=> <your namespace>,
				'type'			=> 'latlng',
				'assign'		=> <assigned_to>,
			),    
   array(
				'name'			=> 'Location longitude',
				'slug'			=> 'location_lng',
				'namespace'   	=> <your namespace>,
				'type'			=> 'latlng',
				'assign'		=> <assigned_to>,
			),
);
</pre>

It is essential that you match the latlng_fields to the correct slug of the location_lat and location_lng fields to allow the system to fill in the correct fields.

Works very well for what I used it for. Again very simple so should be quite extensible. Don't expect miracles and your milage may vary.
