<?php 

class GetSunoptions {

    public $surface;
    
    function __construct() {
        $this->surface = array(
            "gor" => array(
                'runame' => 'Горизонтальная поверхность',
                'periods' => array(
                    'year' => "Год", 
                    'warm' => "Полгода", 
                    'summer' => "Лето"
                    )
            ),
            "ver" => array(
                'runame' => 'Вертикальная поверхность',
                'periods' => array(
                    'year' => "Год", 
                    'warm' => "Полгода", 
                    'summer' => "Лето"
                )
            ),
            "m15" => array(
                'runame' => '-15 к широте поверхность',
                'periods' => array(
                    'year' => "Год", 
                    'warm' => "Полгода", 
                    'summer' => "Лето"
                )
            ),
            "p15" => array(
                'runame' => '-15 от широты',
                'periods' => array(
                    'warm' => "Полгода", 
                    'summer' => "Лето", 
                    'cold' => "Зима")
            ),
            "lat" => array(
                'runame' => 'Наклон равен широте',
                'periods' => array(
                    'year' => "Год", 
                    'warm' => "Полгода", 
                    'summer' => "Лето"
                )
            ),
            "opt" => array(
                'runame' => 'Оптимально ориентированная',
                'periods' => array('year' => "Год")
            ),
            "move" => array(
                'runame' => 'Движущаяся поверхность',
                'periods' => array(
                    'year' => "Год", 
                    'warm' => "Полгода", 
                    'summer' => "Лето", 
                    'cold' => "Зима")
            ) 
        );      
    }

}



?>