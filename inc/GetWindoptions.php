<?php 

class GetWindoptions {

    public $options;

    function __construct() {
        $this->options = array(

            "1" => array(
                'runame' => 'Скорость ветра на 10м',
                'ruunit' => 'м/с',
            ),
            "2" => array(
                'runame' => 'Скорость ветра на 100м',
                'ruunit' => 'м/с',
            ),
            "3" => array(
                'runame' => 'Плотность потока энергии ветра на 100м',
                'ruunit' => 'Вт/м<sup>2</sup>',
            ),           
        );      
    }

}


?>