<?php 

class GetRegions {
    function __construct() {
        $this->ruRegions = $this->getRegions(); 
    }

    function getRegions() {
        return array(
            '-3' => 'Москва',
            '-2' => 'Московская область',
            '-1' => 'Санкт-Петербург',
            '1' => 'Автономная Республика Крым',
            '3' => 'Алтай',
            '4' => 'Алтайский край',
            '5' => 'Амурская область',
            '6' => 'Архангельская область',
            '8' => 'Республика Башкортостан',
            '9' => 'Белгородская область',
            '12' => 'Владимирская область',
            '13' => 'Волгоградская область',
            '15' => 'Воронежская область',
            '16' => 'Республика Дагестан',
            '18' => 'Забайкальский край',
            '19' => 'Ивановская область',
            '21' => 'Иркутская область',
            '25' => 'Калужская область',
            '29' => 'Кемеровская область',
            '30' => 'Кировская область',
            '33' => 'Краснодарский край',
            '34' => 'Красноярский край',
            '35' => 'Курганская область',
            '36' => 'Курская область',
            '37' => 'Ленинградская область',
            '39' => 'Магаданская область',
            '40' => 'Марий Эл',
            '41' => 'Мордовия',
            '44' => 'Мурманская область',
            '46' => 'Нижегородская область',
            '48' => 'Новосибирская область',
            '49' => 'Омская область',
            '50' => 'Оренбургская область',
            '53' => 'Пермский край',
            '54' => 'Приморский край',
            '56' => 'Ростовская область',
            '57' => 'Рязанская область',
            '58' => 'Самарская область',
            '60' => 'Саратовская область',
            '61' => 'Саха (Якутия)',
            '63' => 'Свердловская область',
            '66' => 'Смоленская область',
            '67' => 'Ставропольский край',
            '68' => 'Тамбовская область',
            '69' => 'Республика Татарстан',
            '70' => 'Тверская область',
            '71' => 'Томская область',
            '72' => 'Тульская область',
            '74' => 'Тюменская область',
            '75' => 'Удмуртская Республика',
            '76' => 'Ульяновская область',
            '77' => 'Хабаровский край',
            '80' => 'Челябинская область',
            '82' => 'Чувашская республика',
            '85' => 'Ярославская область'
        );
    }
}
?>           