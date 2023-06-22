<?php 

class GetWindoptions {
    function __construct() {
        $this->options = array(
            // "vp" => array(
            //     'runame' => 'Валовый потенциал',
            //     'ruunit' => 'МВт·ч/год',
            //     'height' => array('30', '50', '100', '120'),
            //     'ruoption' => 'м'
            // ),
            "lull" => array(
                'runame' => 'Энергетические затишья',
                'ruunit' => '%',
                'height' => array('30', '50', '100', '120'),
                'ruoption' => 'м'
            ),
            "den" => array(
                'runame' => 'Плотность энергии',
                'ruunit' => 'Вт/м<sup>2</sup>',
                'height' => array('30', '50', '100', '120'),
                'ruoption' => 'м'
            ),
            "ann" => array(
                'runame' => 'Повторяемость скорости ветра',
                'ruunit' => '%',
                'height' => array('0-2', '2-6', '6-10', '10-14', '14-18', '18-25'),
                'ruoption' => 'м/с'
            ),
            "speed" => array(
                'runame' => 'Скорость ветра',
                'ruunit' => 'м/с',
                'height' => array('10', '30', '50', '100', '120'),
                'ruoption' => 'м'
            ),
            // "pot" => array(
            //     'runame' => 'Технический потенциал',
            //     'ruunit' => 'МВт·ч/год',
            //     'height' => array('30', '50', '100', '120'),
            //     'ruoption' => 'м'
            // )
           
        );      
    }

}


?>