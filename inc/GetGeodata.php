<?php 

require_once plugin_dir_path(__FILE__) . 'GetGeooptions.php';

class GetGeodata {
    function __construct() {
        global $wpdb;
        $tablename = $wpdb->prefix . 'geodata';
        $this->arg = $this->getArg();               
        $query = "SELECT * FROM $tablename ";
        $query .= $this->createWhereText();
        $this->data = $wpdb->get_results($wpdb->prepare($query, $this->arg));
    }

    function getArg() {

        $options = new GetGeooptions();

        $suggestedType = false;

        if (isset($_GET['type'])) {
            $suggestedType = $_GET['type'];
        }

        

        if ($suggestedType && in_array($suggestedType, $options->entypes)) {

            return $suggestedType;

        } else {

            return array();

        }      
    }

    function createWhereText() {
        $suggestedType = false;
        
        if (isset($_GET['type'])) {
            $suggestedType = $_GET['type'];
        }

       
        $options = new GetGeooptions();        

        if ($suggestedType && in_array($suggestedType, $options->entypes)) {

            return " WHERE `type` = %s";

        } else {

            return "";

        }

    }

}

?>