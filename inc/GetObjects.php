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

        if (isset($_GET['thename'])) {
            $temp = array(        
                'name' => "%" . sanitize_text_field($_GET['thename']) . "%"
                );

            return $temp;
        }      

        $temp = array();

    
        if (isset($_GET['type'])) {
            $typesearch = $_GET['type'];
        } else {
            $typesearch = 'ALL';
        }

        if ($typesearch != "ALL") {
            $getTypes = new GetTypes();

            $typesearch = $_GET['type'];
            $energyArray = $getTypes->energy[$typesearch]['types'];

            foreach ($energyArray as $energy) {
                array_push($temp, $energy);
            }        

         //   var_dump($temp);

            return $temp;
        } else {
            return 0;
        }

        

     
    }

    function createWhereText() {
        $whereQuery = "";

        if (isset($_GET['thename'])) {
            $whereQuery .= " WHERE `name` LIKE %s ORDER BY `id` DESC";
            return $whereQuery;
        } 

        if (isset($_GET['type'])) {
            $typesearch = $_GET['type'];
        } else {
            $typesearch = 'ALL';
        }

        if ($typesearch != "ALL") {
            $whereQuery .= " WHERE ";

            $currentPosition = 0;
            
            foreach($this->args as $arg) {

                $whereQuery .= " `type` = %s";

                if ($currentPosition != count($this->args) - 1)  {
                    $whereQuery .= " OR ";
                }
                $currentPosition++;
            }
        } else {
            $whereQuery .= " WHERE `id` > %d ";
        }

        $whereQuery .= " ORDER BY `id` DESC";
        return $whereQuery;
    }

}

?>