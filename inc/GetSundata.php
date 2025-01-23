<?php 
require_once plugin_dir_path(__FILE__) . 'GetSunoptions.php';


class GetSundata {

    public $arg;
    public $data;
    
    function __construct() {
        global $wpdb;
        $tablename = $wpdb->prefix . 'mapsun';
        $this->arg = $this->getArg();       
        $query = "SELECT `lat`, `lon`, `id`, `" . $this->arg . "` as `data` FROM $tablename ";     
        $this->data = $wpdb->get_results($query);
    }

    function getArg() {

        $surface = sanitize_text_field($_GET['surface']);
        $period = sanitize_text_field($_GET['period']);

        $colomn = $surface . '_' . $period;

        $result = $this->checkData($colomn);

        return $result;
               
    }

    function checkData($data) {
      $sunOptions = new GetSunoptions();

      $availableColumns = array();

      foreach($sunOptions->surface as $key => $value) {
        foreach($value['periods'] as $en => $ru) {
          $newColumn = $key . '_' . $en;
          array_push($availableColumns, $newColumn);
        }
      }
      
      if (in_array($data, $availableColumns)) {
        $checkedData = $data;
      } else {
        $data = "move_warm";
      }

      return $checkedData;

    }
}

?>