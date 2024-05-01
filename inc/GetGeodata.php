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
        $search = false;

        if (isset($_GET['type'])) {
            $suggestedType = $_GET['type'];
        }

        if (isset($_GET['thename'])) {
            $search = $_GET['thename'];
        }        

        if ($suggestedType && in_array($suggestedType, $options->entypes)) {

            return $suggestedType;

        } else if ($search) {

            return "%" . sanitize_text_field($search) . "%";
 
        } else {
            return 0;
        }     
    }

    function createWhereText() {
        $suggestedType = false;
        $search = false;
        
        if (isset($_GET['type'])) {
            $suggestedType = $_GET['type'];
        }
       
        if (isset($_GET['thename'])) {
            $search = $_GET['thename'];
        }   

        $options = new GetGeooptions();        

        if ($suggestedType && in_array($suggestedType, $options->entypes)) {

            return " WHERE `type` = %s ORDER BY id DESC" ;

        } else if ($search) {
            return " WHERE `name` LIKE %s ORDER BY id DESC";
        } else {

            return " WHERE `id` > %d ORDER BY id DESC";

        }

    }

}

?>