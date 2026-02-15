<?php 
require_once plugin_dir_path(__FILE__) . 'GetWindoptions.php';


class GetWinddata {

    public array $data = [];
    public array $minmax = [];
    
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