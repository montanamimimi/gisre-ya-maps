<?php 

class GetFotdata {

    public $arg;
    public $data;
    
    function __construct() {
        global $wpdb;
        $tablename = $wpdb->prefix . 'fotdata';
        $this->arg = $this->getArg();               
        $query = "SELECT * FROM $tablename ";
        $query .= $this->createWhereText();
        $this->data = $wpdb->get_results($wpdb->prepare($query, $this->arg));
    }

    function getArg() {
        $lat = $_GET['lat'] + 0.0;
        $lon = $_GET['lon'] + 0.0;

        if (is_float($lat) && is_float($lon)) {
            return array($lat, $lon);
        } 
    }

    function createWhereText() {
        
        $lat = $_GET['lat'] + 0.0;
        $lon = $_GET['lon'] + 0.0;

        if (is_float($lat) && is_float($lon)) {
            return " WHERE `lat` = %f AND `lon` = %f ORDER BY `module`, `alpha`, `comment`";
        } else {

            return "";

        }
    }

    function getType($items, $type) {

        $newData = new stdClass();
        $newData->param1 = array(); 
        $newData->param2 = array(); 

        foreach ($items as $item) {
            if ($item->module == $type) {
                $param1 = new stdClass();
                $param1->alpha = $item->alpha;
                $param1->comment = $item->comment;
                $param1->jan = $item->Jan_one;
                $param1->feb = $item->Feb_one;
                $param1->mar = $item->Mar_one;
                $param1->apr = $item->Apr_one;
                $param1->may = $item->May_one;
                $param1->jun = $item->Jun_one;
                $param1->jul = $item->Jul_one;
                $param1->aug = $item->Aug_one;
                $param1->sep = $item->Sep_one;
                $param1->oct = $item->Oct_one;
                $param1->nov = $item->Nov_one;
                $param1->dec = $item->Dec_one;
                $param1->year = $item->Year_one;

                $param2 = new stdClass();
                $param2->alpha = $item->alpha;
                $param2->comment = $item->comment;
                $param2->jan = $item->Jan_two;
                $param2->feb = $item->Feb_two;
                $param2->mar = $item->Mar_two;
                $param2->apr = $item->Apr_two;
                $param2->may = $item->May_two;
                $param2->jun = $item->Jun_two;
                $param2->jul = $item->Jul_two;
                $param2->aug = $item->Aug_two;
                $param2->sep = $item->Sep_two;
                $param2->oct = $item->Oct_two;
                $param2->nov = $item->Nov_two;
                $param2->dec = $item->Dec_two;
                $param2->year = $item->Year_two;

                array_push($newData->param1, $param1);
                array_push($newData->param2, $param2);
            }
        }

        return $newData;
    }

    function myTrim($item) {
        return rtrim(rtrim(number_format($item, 4, ',', ' '), '\0'), '\,');
    }

    function generateTable($params) {
        $table = '<div class="femtable">';

        $table .= '<div class="femtable__row first-row">
            <div class="femtable__col">
                Угол
            </div>
            <div class="femtable__col femtable__col-small">
               Наклон
            </div>
            <div class="femtable__col">
                Янв. 
            </div>
            <div class="femtable__col">
                Фев.
            </div>
            <div class="femtable__col">
                Март
            </div>
            <div class="femtable__col">
                Апр.
            </div>
            <div class="femtable__col">
                Май 
            </div>
            <div class="femtable__col">
                Июнь 
            </div>
            <div class="femtable__col">
                Июль
            </div>
            <div class="femtable__col">
                Авг.
            </div>
            <div class="femtable__col">
                Сен.
            </div>
            <div class="femtable__col">
                Окт.
            </div>
            <div class="femtable__col">
                Ноя.
            </div>
            <div class="femtable__col">
                Дек.
            </div>
            <div class="femtable__col">
                Год 
            </div></div>';

        foreach ($params as $param) {
            $table .= '<div class="femtable__row">';
            $table .= '<div class="femtable__col">';
            $table .= $param->alpha . '&deg;';
            $table .= '</div><div class="femtable__col femtable__col-small">';
            $table .= '<img src="' . plugin_dir_url(__FILE__) .'images/' . $param->comment . '_2.png" width="50px">';        
            $table .= '</div><div class="femtable__col">';
            $table .= $this->myTrim($param->jan);       
            $table .= '</div><div class="femtable__col">';
            $table .= $this->myTrim($param->feb);       
            $table .= '</div><div class="femtable__col">';
            $table .= $this->myTrim($param->mar);       
            $table .= '</div><div class="femtable__col">';
            $table .= $this->myTrim($param->apr);       
            $table .= '</div><div class="femtable__col">';
            $table .= $this->myTrim($param->may);       
            $table .= '</div><div class="femtable__col">';
            $table .= $this->myTrim($param->jun);       
            $table .= '</div><div class="femtable__col">';
            $table .= $this->myTrim($param->jul);       
            $table .= '</div><div class="femtable__col">';
            $table .= $this->myTrim($param->aug);       
            $table .= '</div><div class="femtable__col">';
            $table .= $this->myTrim($param->sep);       
            $table .= '</div><div class="femtable__col">';
            $table .= $this->myTrim($param->oct);       
            $table .= '</div><div class="femtable__col">';
            $table .= $this->myTrim($param->nov);       
            $table .= '</div><div class="femtable__col">';
            $table .= $this->myTrim($param->dec);       
            $table .= '</div><div class="femtable__col">';
            $table .= $this->myTrim($param->year);       
            $table .= '</div></div>';
        }

        $table .= '</div>';

        return $table;
    }

}



?>