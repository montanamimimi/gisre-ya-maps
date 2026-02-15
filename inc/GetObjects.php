    <?php 

    require_once plugin_dir_path(__FILE__) . 'GetTypes.php';

    class GetObjects {

    public array $objects = [];

    public function __construct() {
        global $wpdb;

        $table = $wpdb->prefix . 'reomap';

        $filters = $this->getFilters();

        $params = [];
        $where  = $this->buildWhere($filters, $params);

        $sql = "
            SELECT *
            FROM {$table}
            {$where}
            ORDER BY id DESC
        ";

        if ($params) {
            $sql = $wpdb->prepare($sql, $params);
        }

        $this->objects = $wpdb->get_results($sql);
    }

    /**
     * Normalize GET into filters
     */
    private function getFilters(): array {

        $filters = [];

        if (!empty($_GET['thename'])) {
            $filters['name'] = sanitize_text_field($_GET['thename']);
        }

        if (!empty($_GET['type'])) {
            $filters['type'] = sanitize_text_field($_GET['type']);            
        } 

        if (!empty($_GET['power'])) {
            $filters['power'] = (int) $_GET['power'];
        }

        if (!empty($_GET['smallonly'])) {
            $filters['smallonly'] = $_GET['smallonly'];
        }

        if (!empty($_GET['status'])) {            
            $filters['status'] = sanitize_text_field($_GET['status']);
        }      

        if (!empty($_GET['funct'])) {            
            $filters['function'] = sanitize_text_field($_GET['funct']);
        }   

        return $filters;
    }

    /**
     * Build SQL WHERE + params for wpdb->prepare
     */
    private function buildWhere(array $filters, array &$params): string {

        global $wpdb;

        $where = [];

        /* name LIKE */
        if (!empty($filters['name'])) {
            $where[]  = "`name` LIKE %s";
            $params[] = '%' . $wpdb->esc_like($filters['name']) . '%';
        }

        /* type logic */
        if (!empty($filters['type'])) {
            
            // unfinished → status = 'x'
            if ($filters['type'] === 'unfinished') {
                $where[]  = "`status` = %s";
                $params[] = 'x';
            } 
            else {
                // energy group → IN (...)
                $getTypes = new GetTypes();

                if (isset($getTypes->energy[$filters['type']]['types'])) {

                    $types = $getTypes->energy[$filters['type']]['types'];

                    $placeholders = implode(',', array_fill(0, count($types), '%s'));
                    $where[] = "`type` IN ($placeholders)";

                    foreach ($types as $t) {
                        $params[] = $t;
                    }
                }
            }
        }

        if (!empty($filters['power'])) {
            $where[]  = "`power` > %d";
            $params[] = $filters['power'];
        }

        if (!empty($filters['smallonly'])) {
            $where[]  = "`power` < 10000000";
        }        

        if (!empty($filters['status'])) {            
            $where[]  = "`status` = %s";
            $params[] = $filters['status'];
        }

        if (!empty($filters['function'])) {   
            
            if ($filters['function'] == "none") {
                $where[]  = "(`function` IS NULL OR TRIM(`function`) = '')";
            } else {
                $where[]  = "`function` = %s";
                $params[] = $filters['function'];
            }

        }


        if (!$where) {
            return '';
        }

        return 'WHERE ' . implode(' AND ', $where);
    }
}