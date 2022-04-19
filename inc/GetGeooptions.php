<?php 

class GetGeooptions {
    function __construct() {
        $this->types = array(
            'KUR' => 'Курильские острова', 
            'GEOE' => 'Камчатка',
            'KAV' => 'Северный Кавказ');      
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