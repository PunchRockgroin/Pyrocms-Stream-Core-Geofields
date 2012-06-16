<?php defined('BASEPATH') or exit('No direct script access allowed');
/**
 * PyroStreams Geocode lat/lng field type
 *
 * @author		David Alberts
 * 
 */
class Field_latlng
{
  
   public $field_type_slug = 'latlng';

   public $db_col_type = 'float(10,6)';

   /**
* Output form input
*
* @access public
* @param array
* @return string
*/
   public function form_output($data)
   {
      $options['name']	= $data['form_slug'];
      $options['id']	= $data['form_slug'];
      $options['value']	= $data['value'];
      $options['readonly'] = 'readonly';

      return form_input($options);
   }

}