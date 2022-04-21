<?php 

class GetTypes {
    function __construct() {
        $this->types = array(
            "СЭС" => "SES",
            "Солнце+ветер" => "SV",
            "Солнце+дизель" => "SD",
            "Солнце-ветер-дилзель" => "SVD",
            "Водонагреватель" => "SVU",
            "ВЭС" => "VES",
            "Ветер+дизель" => "VDES",
            "Био" => "BIO",
            "Био-кластер" => "BIOC",
            "Гео" => "GEOE",
            "Насос" => "TN",
            "Насос+вода" => "TNSVU",
            "Приливная" => "PES",
            "Малые ГЭС" => "MGES"           
        );       

        $this->energy = array (
            "e-sun" => array(
                "runame" => "Солнечные электростанции", 
                "enname" => "Sun energy",
                "types" => array("SES", "SV", "SD", "SVD")
            ),
            "e-sunwater" => array(
                "runame" => "Солнечные коллекторы", 
                "enname" => "Sun waterheaters",
                "types" => array("SVU", "TNSVU")
            ),
            "e-wind" => array(
                "runame" => "Ветровые станции", 
                "enname" => "Wind energy",
                "types" => array("SV", "SVD", "VES", "VDES")
            ),
            "e-water" => array(
                "runame" => "МГЭС и ПЭС", 
                "enname" => "Water energy",
                "types" => array("MGES", "PES")
            ),
            "e-bio" => array(
                "runame" => "Биоэнергетика", 
                "enname" => "Bio energy",
                "types" => array("BIO", "BIOC")
            ),
            "e-geo" => array(
                "runame" => "Геоэнергетика", 
                "enname" => "Geo energy",
                "types" => array("GEOE", "TN", "TNSVU")
            ),
        );

        $this->orgs = array(
            'sune' => 'Солнечная электроэнергетика',
            'sunt' => 'Солнечная теплоэнергетика',
            'wind' => 'Ветроэнергетика',
            'bio' => 'Биоэнергетика',
            'gidro' => 'Малая гидроэнергетика',
            'geo' => 'Геотермальная энергетика',
            'pri' => 'Приливная гидроэнергетика',
            'tn' => 'Тепловые насосы'
        );  
    }

}


?>