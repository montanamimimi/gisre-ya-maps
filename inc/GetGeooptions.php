<?php 

class GetGeooptions {

    public $types;
    public $entypes;
    
    function __construct() {
        $this->types = array(
            'KUR' =>  __('Курильские острова', 'gisre-plugin'), 
            'GEOE' => __('Камчатка', 'gisre-plugin'),
            'KAV' => __('Северный Кавказ', 'gisre-plugin')
            );      
        $this->entypes = $this->getEnTypes();     
    }

    function getEnTypes() {
        $newarray = array();

        foreach ($this->types as $key => $value ) {
            array_push($newarray, $key);
        }

        return $newarray;
    }

}
?>