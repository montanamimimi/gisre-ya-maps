<?php 

class GetTypes {
    function __construct() {
        $this->types = array(
            "СЭС" => "SES",
            "Солнце+ветер" => "SV",
            "Солнце+дизель" => "SD",
            "Солнце-ветер-дилзель" => "SVD",
            "Теплоснабжение" => "SVU",
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
                "types" => array("SES", "SV", "SD", "SVD"),
                "legend" => array("SES", "VES", "DISEL", "STR", "PRO")
            ),
            "e-sunwater" => array(
                "runame" => "Солнечные коллекторы", 
                "enname" => "Sun waterheaters",
                "types" => array("SVU", "TNSVU"),
                "legend" => array("SVU", "TN", "STR", "PRO")
            ),
            "e-wind" => array(
                "runame" => "Ветровые станции", 
                "enname" => "Wind energy",
                "types" => array("SV", "SVD", "VES", "VDES"),
                "legend" => array("SES", "VES", "DISEL", "STR", "PRO")
            ),
            "e-water" => array(
                "runame" => "МГЭС и ПЭС", 
                "enname" => "Water energy",
                "types" => array("MGES", "PES"),
                "legend" => array("MGES", "PES", "STR", "PRO")
            ),
            "e-bio" => array(
                "runame" => "Биоэнергетика", 
                "enname" => "Bio energy",
                "types" => array("BIO", "BIOC"),
                "legend" => array("BIO", "STR", "PRO")
            ),
            "e-geo" => array(
                "runame" => "Геотермальные объекты", 
                "enname" => "Geo energy",
                "types" => array("GEOE", "TN", "TNSVU"),
                "legend" => array("GEO", "TN", "SVU", "STR", "PRO")
            ),
        );

        $this->orgs = array(
            'sune' => array(
                'name' => 'Солнечная электроэнергетика',
                'color' => '#f7f606'
            ),
            'sunt' => array(
                'name' => 'Солнечная теплоэнергетика',
                'color' => '#f5a10a'
            ),
            'wind' => array(
                'name' => 'Ветроэнергетика',
                'color' => '#062194'
            ),
            'bio' => array(
                'name' => 'Биоэнергетика',
                'color' => '#4d9c29'
            ),
            'gidro' => array(
                'name' => 'Малая гидроэнергетика',
                'color' => '#6bb7d9'
            ),
            'geo' => array(
                'name' => 'Геотермальная энергетика',
                'color' => '#e32e0f'
            ),
            'pri' => array(
                'name' => 'Приливная гидроэнергетика',
                'color' => '#305ec0'
            ),
            'tn' => array(
                'name' => 'Тепловые насосы',
                'color' => '#510337'
                )
        );  

        $this->colors = array (
            'SES' => array (
                'color' => '#e4dc0c',
                'name' => 'СЭС'
            ),
            'VES' => array (
                'color' => '#116889',
                'name' => 'ВЭС'
            ),
            'DISEL' => array (
                'color' => '#000000',
                'name' => 'Дизель'
            ),
            'SVU' => array (
                'color' => '#f5a10a',
                'name' => 'Теплоснабжение'
            ),
            'BIO' => array (
                'color' => '#4d9c29',
                'name' => 'Биоэнергетика'
            ),
            'GEO' => array (
                'color' => '#e32e0f',
                'name' => 'Электро-снабжение'
            ),
            'TN' => array (
                'color' => '#510337',
                'name' => 'Тепловой насос'
            ),
            'PES' => array (
                'color' => '#17498c',
                'name' => 'Приливная станция'
            ),
            'MGES' => array (
                'color' => '#85b4f4',
                'name' => 'Малая ГЭС'
            ),
            'STR' => array (
                'color' => '#676767',
                'name' => 'Строящийся объект'
            ),
            'PRO' => array (
                'color' => '#DDDDDD',
                'name' => 'Проектируемый объект'
            )
        );
    }

}

?>