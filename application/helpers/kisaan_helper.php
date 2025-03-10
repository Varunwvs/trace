<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

if (!function_exists('get_settings')) {
    function get_settings($key = '')
    {
        $CI = &get_instance();
        $CI->load->database();

        $CI->db->where('name', $key);
        $result = $CI->db->get('settings')->row('value');
        return $result;
    }
}

if(!function_exists('json_output')){
function json_output($statusHeader,$response)
  {
    $ci =& get_instance();
    $ci->output->set_content_type('application/json');
    $ci->output->set_status_header($statusHeader);
    $ci->output->set_output(json_encode($response));
  }
}
?>