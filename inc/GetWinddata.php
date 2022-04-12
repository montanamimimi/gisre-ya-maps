<?php 
require_once plugin_dir_path(__FILE__) . 'GetWindoptions.php';


class GetWinddata {
    function __construct() {
        global $wpdb;
        $tablename = $wpdb->prefix . 'winddata';
        $this->arg = $this->getArg();       
        $query = "SELECT `lat`, `lon`, `id`, `" . $this->arg . "` as `data` FROM $tablename ";  
        $min = "SELECT MIN(0+`" . $this->arg ."`) FROM $tablename";
        $max = "SELECT MAX(0+`" . $this->arg ."`) FROM $tablename";
        $this->min = $wpdb->get_var($min);
        $this->max = $wpdb->get_var($max);
        $this->data = $wpdb->get_results($query);
    }

    function getArg() {

        $datatype = sanitize_text_field($_GET['datatype']);
        $height = sanitize_text_field($_GET['height']);

        $colomn = $datatype . $height;

        $result = $this->checkData($colomn);

        return $result;
               
    }

    function checkData($data) {
      $windOptions = new GetWindoptions();

      $availableColumns = array();

      foreach($windOptions->options as $key => $value) {
        foreach($value['height'] as $item) {
          $newColumn = $key . $item;
          array_push($availableColumns, $newColumn);
        }
      }
      
      if (in_array($data, $availableColumns)) {
        $checkedData = $data;
      } else {
        $data = "vp30";
      }

      return $checkedData;

    }
}

?>