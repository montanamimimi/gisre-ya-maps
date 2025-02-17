<?php 

class GetSunoptions {

    public $surface;
    
    function __construct() {
        $this->surface = array(
            "gor" => array(
                'runame' => 'Горизонтальная поверхность',
                'periods' => array(
                    'year' => "Год", 
                    'warm' => "Полгода (апрель — сентябрь)", 
                    'summer' => "Лето (июнь — август)"
                    )
            ),
            "ver" => array(
                'runame' => 'Вертикальная поверхность',
                'periods' => array(
                    'year' => "Год", 
                    'warm' => "Полгода (апрель — сентябрь)", 
                    'summer' => "Лето (июнь — август)"
                )
            ),
            "m15" => array(
                'runame' => '-15 к широте поверхность',
                'periods' => array(
                    'year' => "Год", 
                    'warm' => "Полгода (апрель — сентябрь)", 
                    'summer' => "Лето (июнь — август)"
                )
            ),
            "p15" => array(
                'runame' => '-15 от широты',
                'periods' => array(
                    'warm' => "Полгода (апрель — сентябрь)", 
                    'summer' => "Лето (июнь — август)", 
                    'cold' => "Зима")
            ),
            "lat" => array(
                'runame' => 'Наклон равен широте',
                'periods' => array(
                    'year' => "Год", 
                    'warm' => "Полгода (апрель — сентябрь)", 
                    'summer' => "Лето (июнь — август)"
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
                    'warm' => "Полгода (апрель — сентябрь)", 
                    'summer' => "Лето (июнь — август)", 
                    'cold' => "Зима (декабрь - февраль)")
            ) 
        );      
    }

}



?>