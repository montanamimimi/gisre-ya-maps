<?php 
require_once plugin_dir_path(__FILE__) . 'GetWindoptions.php';


class GetWinddata {

    public array $data = [];
    public array $minmax = [];
    public array $convertedData = [];
    
    function __construct() {
        global $wpdb;
        $table = $wpdb->prefix . 'wind_2026';
        $filters = $this->getFilters();
        $params = [];
        $where  = $this->buildWhere($filters, $params);
        $allowed_columns = [
          'mean_month1', 
          'mean_month2', 
          'mean_month3', 
          'mean_month4', 
          'mean_month5', 
          'mean_month6',
          'mean_month7',
          'mean_month8',
          'mean_month9',
          'mean_month10',
          'mean_month11',
          'mean_month12',
          'mean_year',
          ];
        
        $column  = $_GET['period'] ?? 'mean_year';          

        if (!in_array($column, $allowed_columns, true)) {
            $column = 'mean_year'; // fallback
        }

        $sql = "
            SELECT `id`, `lat`, `lon`, {$column} AS `data`
            FROM {$table}
            {$where}
            ORDER BY id DESC
        ";

        $sql2 = "
            SELECT MIN({$column}) AS min, MAX({$column}) AS max
            FROM {$table}
            {$where}
            ORDER BY id DESC
        ";        

        if ($params) {
            $sql = $wpdb->prepare($sql, $params);
            $sql2 = $wpdb->prepare($sql2, $params);
        }       

        $this->data = $wpdb->get_results($sql);
        $this->minmax = $wpdb->get_results($sql2);
        $this->convertedData = $this->convert($this->data);        
    }

    private function convert($data) {
        $points = [];

        $min = 0;
        $max = 0;

        if (isset($this->minmax[0])) {
            $min = (float)$this->minmax[0]->min;
            $max = (float)$this->minmax[0]->max;
            $delta = $max - $min;
        }

        foreach ($data as $i => $obj) {

            $data = (float)$obj->data;

            
            if ($data < ($min + $delta*0.1)) {                
                $color = "#d1d4ee";
            } else if ($data < ($min + $delta*0.2)) {$color = "#b3b7dc";}
            else if ($data < ($min + $delta*0.3)) {$color = "#979ece";}
            else if ($data < ($min + $delta*0.4)) {$color = "#7f86bd";}
            else if ($data < ($min + $delta*0.5)) {$color = "#636ba8";} 
            else if ($data < ($min + $delta*0.6)) {$color = "#424b8d";} 
            else if ($data < ($min + $delta*0.7)) {$color = "#2c367a";} 
            else if ($data < ($min + $delta*0.8)) {$color = "#1c266d";} 
            else if ($data < ($min + $delta*0.9)) {$color = "#0c1457";}                 

            $point = [
                'coords' => [(float)$obj->lat, (float)$obj->lon],
                'value'  => (float)$obj->data, 
                'color' => $color
            ];
            array_push($points, $point);

        }

        return $points;
    }
 
    private function getFilters(): array {

        $filters = [];

        if (!empty($_GET['datatype'])) {
          $filters['type'] = (int) $_GET['datatype'];
        }

        return $filters;
    }    

    private function buildWhere(array $filters, array &$params): string {

        global $wpdb;

        $where = [];

        if (!empty($filters['type'])) {
            $where[]  = "`type` = %d";
            $params[] = $filters['type'];
        }

        return 'WHERE ' . implode(' AND ', $where);
    }    

}

?>