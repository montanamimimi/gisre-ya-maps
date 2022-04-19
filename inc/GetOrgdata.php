<?php 

class GetOrgdata {
    function __construct() {
        global $wpdb;
        $tablename = $wpdb->prefix . 'orgdata';
        $this->arg = $this->getArg();               
        $query = "SELECT * FROM $tablename ";
        $query .= $this->createWhereText();
        $this->data = $wpdb->get_results($wpdb->prepare($query, $this->arg));
    }

    function getArg() {

        $options = array('SCIENSE', 'SALES');

        $suggestedType = $_GET['type'];

        if ($suggestedType && in_array($suggestedType, $options)) {

            return $suggestedType;

        } else {

            return array();

        }      
    }

    function createWhereText() {

        $suggestedType = $_GET['type'];
        $options = array('SCIENSE', 'SALES');        

        if ($suggestedType && in_array($suggestedType, $options)) {

            return " WHERE `type_number` = %s";

        } else {

            return "";

        }

    }

}

?>