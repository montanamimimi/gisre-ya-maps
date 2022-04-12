<?php 

require_once plugin_dir_path(__FILE__) . 'GetTypes.php';
$getTypes = new GetTypes();

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

        $temp = array();

        if ($_GET['type'] && $_GET['type'] != "ALL") {

            $getTypes = new GetTypes();

            $energyType = $_GET['type'];
            $energyArray = $getTypes->energy[$energyType]['types'];

            foreach ($energyArray as $energy) {
                array_push($temp, $energy);
            }        

            return $temp;
        }

        if ($_GET['thename']) {
            $temp = array(        
                'name' => "%" . sanitize_text_field($_GET['thename']) . "%"
                );

            return $temp;
        }           
    }

    function createWhereText() {
        $whereQuery = "";

        if ($_GET['thename']) {
            $whereQuery .= " WHERE `name` LIKE %s ORDER BY `id` DESC";
        }

        if ($_GET['type']) {

            if ($_GET['type'] != "ALL") {
                $whereQuery .= " WHERE ";

                $currentPosition = 0;
                
                foreach($this->args as $arg) {
    
                    $whereQuery .= " `type` = %s";

                    if ($currentPosition != count($this->args) - 1)  {
                        $whereQuery .= " OR ";
                    }
                    $currentPosition++;
                }
            }               
            $whereQuery .= " ORDER BY `id` DESC";
        }

        return $whereQuery;
    }

    // function specificQuery($index) {
    //     switch ($index) {
    //         case "name":
    //             return "`name` LIKE %s";
    //         case "type": {
    //             $typesRequest = "`type` = %s";
    //             return $typesRequest;   
    //         }                   
    //         default: 
    //             return $index . " = %s";
    //     }
    // }
}

?>