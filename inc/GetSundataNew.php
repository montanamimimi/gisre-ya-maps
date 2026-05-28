<?php 

class GetSundataNew {

    public array $data = [];
    public array $minmax = array('min' => "0.000", 'max' => '19.747');
    public array $convertedData = [];
    
    function __construct() {
        global $wpdb;
        $table = $wpdb->prefix . 'sun_2026';
        $filters = $this->getFilters();
        $params = [];
        $where = $this->buildWhere($filters, $params);
        $allowed_columns = [
          'prod1', 
          'prod2', 
          'prod3', 
          'prod4', 
          'prod5', 
          'prod6',
          'prod7',
          'prod8',
          'prod9',
          'prod10',
          'prod11',
          'prod12',
          'prod13',
          ];
        
        $column  = $_GET['period'] ?? 'prod13';          

        if (!in_array($column, $allowed_columns, true)) {
            $column = 'prod13'; 
        }

        $sql = "
            SELECT `id`, `lat`, `lon`, {$column} AS `data`
            FROM {$table}
            {$where}
            ORDER BY id DESC
        ";   

        if ($params) {
            $sql = $wpdb->prepare($sql, $params);
        }       

        $this->data = $wpdb->get_results($sql);
        $this->convertedData = $this->convert($this->data);    
    }

    private function convert($data) {
        $points = [];

        $min = (float)$this->minmax['min'];
        $max = (float)$this->minmax['max'];
        $delta = $max - $min;

        foreach ($data as $i => $obj) {

            $data = (float)$obj->data;
            
            if ($data < ($min + $delta*0.032)) {                
                $color = "#fffbbf";
            } else if ($data < ($min + $delta*0.064)) {$color = "#fff785";}
            else if ($data < ($min + $delta*0.096)) {$color = "#fff34d";}
            else if ($data < ($min + $delta*0.128)) {$color = "#ffed00";}
            else if ($data < ($min + $delta*0.160)) {$color = "#ffdc00";} 
            else if ($data < ($min + $delta*0.192)) {$color = "#fecc00";} 
            else if ($data < ($min + $delta*0.224)) {$color = "#fbba00";} 
            else if ($data < ($min + $delta*0.256)) {$color = "#f7a600";} 
            else if ($data < ($min + $delta*0.288)) {$color = "#f39100";} 
            else if ($data < ($min + $delta*0.32)) {$color = "#f07b00";} 
            else if ($data < ($min + $delta*0.353)) {$color = "#ec6500";} 
            else if ($data < ($min + $delta*0.385)) {$color = "#e84c03";} 
            else if ($data < ($min + $delta*0.417)) {$color = "#e52e0a";} 
            else if ($data < ($min + $delta*0.449)) {$color = "#e00202";} 
            else if ($data < ($min + $delta*0.481)) {$color = "#d00303";} 
            else {
                $color = "#c00000";
            }              

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
        } else {
          $filters['type'] = 1;
        }

        return $filters;
    }    

    private function buildWhere(array $filters, array &$params): string {

        global $wpdb;        

        $where = [];

        if (isset($filters['type'])) {          
            $where[]  = "`type` = %d";
            $params[] = $filters['type'];
        } 

        return 'WHERE ' . implode(' AND ', $where);
    }        
}

?>