<?php 

require_once plugin_dir_path(__FILE__) . 'GetGeooptions.php';

class GetGeodata {

    public $data;
    
    function __construct() {
        $this->data = $this->getData();
    }

    function getData() {
        global $wpdb;

        $tablename = $wpdb->prefix . 'geodata';
        $arguments = $this->getArg();
        $query = "SELECT * FROM $tablename ";
        $query .= $this->createWhereText();
        $out =  $wpdb->get_results($wpdb->prepare($query, $arguments));
        $res = array();

        foreach ($out as $item) {


            $object = new stdClass();
            $current_lang = apply_filters( 'wpml_current_language', NULL );

            $object->id = $item->id;
            $object->lat = $item->lat;
            $object->lon = $item->lon;
            $object->linkshort = $item->linkshort;
            $object->absolute = $item->absolute;
            $object->truthplace = $item->truthplace;
            $object->year = $item->year;

            if ($item->translated && ($current_lang == 'en')) {                
                $object->name = $item->name_en;
                $object->oopt = $item->oopt_en;
                $object->location = $item->location_en;
                $object->ready = $item->ready_en;
                $object->ph = $item->ph_en;
                $object->minclass = $item->minclass_en;
                $object->balneol = $item->balneol_en;
                $object->perspective = $item->perspective_en;
                $object->powerpr = $item->powerpr_en;
                $object->dop = $item->dop_en;
                $object->tclass = $item->tclass_en;
                $object->wellsnumber = $item->wellsnumber_en;
                $object->province = $item->province_en;
                $object->temperaturedep = $item->temperaturedep_en;
                $object->potresourse = $item->potresourse_en;
                $object->debit = $item->debit_en;
                
            } else {
                $object->name = $item->name;
                $object->oopt = $item->power;
                $object->location = $item->location;
                $object->ready = $item->link;
                $object->ph = $item->source;
                $object->minclass = $item->function;
                $object->balneol = $item->river;
                $object->perspective = $item->check_obj;
                $object->powerpr = $item->powerpr;
                $object->dop = $item->pp;
                $object->tclass = $item->gen;
                $object->wellsnumber = $item->date;
                $object->province = $item->holder;
                $object->temperaturedep = $item->picture;
                $object->potresourse = $item->potresourse;
                $object->debit = $item->debit;
            }

            array_push($res, $object);
           
        }

        return $res;
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

            return array("%" . sanitize_text_field($search) . "%", "%" . sanitize_text_field($search) . "%");
 
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
            
            return " WHERE (`name` LIKE %s) OR (`name_en` LIKE %s) ORDER BY id DESC";
        } else {

            return " WHERE `id` > %d ORDER BY id DESC";

        }

    }

}

?>