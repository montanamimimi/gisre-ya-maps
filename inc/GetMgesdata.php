<?php 

require_once plugin_dir_path(__FILE__) . 'GetGeooptions.php';

class GetMgesdata {
    function __construct() {
        global $wpdb;
        $tablename = $wpdb->prefix . 'mges';             
        $query = "SELECT * FROM $tablename ";
        $this->data = $wpdb->get_results($query);
    }

}

?>