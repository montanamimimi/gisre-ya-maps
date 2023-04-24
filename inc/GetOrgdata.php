<?php 

require_once plugin_dir_path(__FILE__) . 'GetTypes.php';


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

        $args = array();

        if (isset($_GET['type'])) {
            $suggestedType = $_GET['type'];
            if ($suggestedType && in_array($suggestedType, $options)) {
                return $suggestedType;
            }
        } 


        if (isset($_GET['thename'])) {
            return "%" . sanitize_text_field($_GET['thename']) . "%";
        }

        return 0;


    }

    function createWhereText() {

        $options = array('SCIENSE', 'SALES');    

        if (isset($_GET['type'])) {
            $suggestedType = $_GET['type'];
            if ($suggestedType && in_array($suggestedType, $options)) {
                return " WHERE `type_number` = %s ORDER BY id DESC";
            }
        } 


        if (isset($_GET['thename'])) {
            return " WHERE `name` LIKE %s ORDER BY `id` DESC";
        }

        return " WHERE id > %d ORDER BY id DESC";

    }
}



class GetOrgdatabase {
    function __construct() {
        global $wpdb;
        $tablename = $wpdb->prefix . 'orgdata';
        $this->arg = $this->getArg();               
        $query = "SELECT * FROM $tablename ";
        $query .= $this->createWhereText();
        $this->data = $wpdb->get_results($wpdb->prepare($query, $this->arg));
    }

    function checkIfAllTypes() {

        $allTypes = true;
        $getTypes = new GetTypes();
        
        foreach ($getTypes->orgs as $value => $runame) {
            if (!$_GET[$value]) {
                $allTypes = false;
            }
        }
        return $allTypes;
    }    

    function checkIfAll() {
        $options = array('SCIENSE', 'SALES', 'ALL');
        $suggestedType = $_GET['type'];
        if (!$suggestedType || !in_array($suggestedType, $options)) {
            return true;
        } 

        $allTypes = $this->checkIfAllTypes();

        $moMatterParams = ($_GET['regions'] == '-100') && $allTypes;

        if ($suggestedType == 'ALL' && $moMatterParams) {
            return true;
        }

        return false;
    }

    function getArg() {

        $params = array();

        if($this->checkIfAll()) {
            return $params;
        }

        $options = array('SCIENSE', 'SALES');
        if (in_array($_GET['type'], $options)) {
            array_push($params, $_GET['type']);
        }

        if ($_GET['regions'] != '-100') {
            array_push($params, $_GET['regions']);         
        } 

        return $params;

    }

    function createWhereText() {

        $whereText = "";

        if($this->checkIfAll()) {
            return $whereText;
        } else {
            $whereText = " WHERE ";
        }

        $addAnd = false;

        $options = array('SCIENSE', 'SALES');
        if (in_array($_GET['type'], $options)) {
            $whereText .= "`type_number` = %s";
            $addAnd = true;
        }

        if ($_GET['regions'] != '-100') {

            if ($addAnd) {
                $whereText .= ' AND ';
            }
            $whereText .= '`region` = %d'; 
            $addAnd = true;
        } 

        if ($this->checkIfAllTypes()) {
            return $whereText; 
        } else {

            if ($addAnd) {
                $whereText .= ' AND (';
                $finish = true;
            }

            $getTypes = new GetTypes();
        
            foreach ($getTypes->orgs as $value => $runame) {
                

                if ($_GET[$value]) {

                    if ($addOr) {
                        $whereText .= ' OR ';
                    }

                    $whereText .= "`" . $value . "` = 1";
                    $addOr = true;
                    
                }
            }

            if ($finish) {
                $whereText .= ')';
            }

        }

        return $whereText;

    }

    function createLegend($item) {

        $getTypes = new GetTypes();
        
        $legend = '';
        
        foreach ($getTypes->orgs as $key => $value) {
            if ($item->$key) {
                $legend.= '<div class="orgdata-results__item" style="background-color: ' . $value['color'] .'"></div>';
            }
        }
        
        return $legend;
        }

    function createMainLegend() {

        $getTypes = new GetTypes();
            
        $legend = '';
            
        foreach ($getTypes->orgs as $key => $value) {    
                $legend.= '<div class="orgdata-results__item" style="background-color: ' . $value['color'] .'"></div>';
            }
            
        return $legend;
        }    

}

?>




