<?php 

class GetObjects {
    function __construct() {
        global $wpdb;
        $tablename = $wpdb->prefix . 'reomap';
        $this->args = $this->getArgs();       
        $query = "SELECT * FROM $tablename ";
        $query .= $this->createWhereText();
        $this->objects = $wpdb->get_results($wpdb->prepare($query, $this->args));
    }

    function getArgs() {

        $temp = array(
            'type' => sanitize_text_field($_GET['type']),
            'status' => sanitize_text_field($_GET['status']),
            'name' => "%" . sanitize_text_field($_GET['thename']) . "%",
            'minpower' => sanitize_text_field($_GET['minpower'])
        );
        
        if ($_GET['type'] == 'ALL') {
            $temp['type'] = "%";
        }

        return array_filter($temp, function($x) {
            return $x;
        });
      
    }

    function createWhereText() {
        $whereQuery = "";

        if (count($this->args)) {
            $whereQuery .= "WHERE ";
        }

        $currentPosition = 0;
        foreach($this->args as $index => $item) {

            $whereQuery .= $this->specificQuery($index);
            if ($currentPosition != count($this->args) - 1) {
                $whereQuery .= " AND ";
            }
            $currentPosition++;
        }

        $whereQuery .= " ORDER BY `id` DESC";

        return $whereQuery;
    }

    function specificQuery($index) {
        switch ($index) {
            case "minpower":
                return "power >= %d";
            case "name":
                return "`name` LIKE %s";
            case "type": 
                return "`type` LIKE %s";       
            default: 
                return $index . " = %s";
        }
    }
}

?>