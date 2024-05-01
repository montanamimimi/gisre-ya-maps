<?php 
require_once plugin_dir_path(__FILE__) . 'GetGeodata.php';
$rows = new GetGeodata();
$current_lang = apply_filters( 'wpml_current_language', NULL );

if ($current_lang == 'en') {
  $Toopt = 'Which protected area is included in';
  $Tprovince = 'Geothermal province';
  $Twellsnumber = 'Number of wells';
  $Tispolzovanie = 'Contemporary use';
  $Tperspective = 'Promising area of operation';
  $Tbalneolog = 'Balneological characteristics of waters';
  $Tminerals = 'Mineralization g/l';
  $Tfunction = 'Classification by mineralization';
  $Tmaxtemperature = 'Maximum temperature';
  $Ttemperatureclass = 'Temperature classification';
  $Tphclass = 'pH classification';
  $Treadyness = 'Level of amenities and use';
  $Ttemperaturedep = 'Temperature at depth';
  $Tabsolute = 'Absolute elevation'; 
  $Tpotresourse = 'Forecast parameters'; 
  $Tdebit = 'Total flow rate, l/s or kg/s';
} else {
  $Toopt = 'В состав какого ООПТ входит';
  $Tprovince = 'Геотермальная провинция';
  $Twellsnumber = 'Количество источников';
  $Tispolzovanie = 'Современное использование';
  $Tperspective = 'Перспективная область эксплуатации';
  $Tbalneolog = 'Бальнеологическая характеристика вод';
  $Tminerals = 'Минерализация г/л';
  $Tfunction = 'Классификация по минерализации';
  $Tmaxtemperature = 'Максимальная температура';
  $Ttemperatureclass = 'Классификация по температуре';
  $Tphclass = 'Классификация по pH';
  $Treadyness = 'Уровень подготовленности и использования';
  $Ttemperaturedep = 'Температура на глубине';
  $Tabsolute = 'Абсолютная отметка'; 
  $Tpotresourse = 'Потенциальные ресурсы термальных вод'; 
  $Tdebit = 'Суммарный дебит, л/с или кг/с';
}

$searchtext = "";

if (isset($_GET['thename'])) {

  $searchtext = $_GET['thename'];
}

get_header(); 

?>

  <script src="https://api-maps.yandex.ru/2.1/?apikey=b6a7a43d-4ce5-45d6-9b18-5eb8015dbbfa&lang=ru_RU" type="text/javascript"></script>
    <script type="text/javascript">
   ymaps.ready(function () {
    var myMap = new ymaps.Map('map', {
            center: [56, 97],
            zoom: 3,
            behaviors: ['default', 'scrollZoom'],
	    controls: ['zoomControl', 'searchControl', 'typeSelector',  'fullscreenControl']
        }, {
            searchControlProvider: 'yandex#search'
        })

    var customItemContentLayout = ymaps.templateLayoutFactory.createClass(
        '<h4 class=ballon_header>{{ properties.balloonContentHeader|raw }}</h4>' +
        '<div class=ballon_body>{{ properties.balloonContentBody|raw }}</div>' +
        '<div class=ballon_footer><small>{{ properties.balloonContentFooter|raw }}<small></div>'
    );

         clusterer = new ymaps.Clusterer({
            preset: 'islands#blackClusterIcons',
            groupByCoordinates: true,
            clusterDisableClickZoom: true,
            clusterHideIconOnBalloonOpen: false,
            geoObjectHideIconOnBalloonOpen: false,
	    clusterBalloonItemContentLayout: customItemContentLayout,
            gridSize: 15
        }),
	
	clusterer

 <?php if ($rows): ?>
 <?php foreach ($rows->data as $row): 

  if (($current_lang == 'en') && $row->translated) {
    $name = $row -> name_en;
    $oopt = $row -> oopt_en;
    $location = $row -> location_en;
    $readyness= $row -> ready_en;
    $phclass = $row -> ph_en;
    $function = $row -> minclass_en;
    $balneolog = $row -> balneol_en;
    $perspective = $row -> perspective_en;
    $ispolzovanie = $row -> powerpr_en;
    $pp = $row -> dop_en;
    $temperatureclass = $row -> tclass_en;
    $wellsnumber = $row -> wellsnumber_en;
    $province = $row -> province_en;
    $temperaturedep = $row -> temperaturedep_en;
    $potresourse = $row -> potresourse_en; 
    $debit = $row -> debit_en;
  } else {
    $name = $row -> name;
    $oopt = $row -> power;
    $location = $row -> location;
    $readyness= $row -> link;
    $phclass = $row -> source;
    $function = $row -> function;
    $balneolog = $row -> river;
    $perspective = $row -> check_obj;
    $ispolzovanie = $row -> powerpr;
    $pp = $row -> pp;
    $temperatureclass = $row -> gen;
    $wellsnumber = $row -> date;
    $province = $row -> holder;
    $temperaturedep = $row -> picture;
    $potresourse = $row -> potresourse; 
    $debit = $row -> debit;
  }
 
  $lat = $row -> lat;
  $lon = $row -> lon;
  $ph = $row -> linkshort;
  $absolute = $row -> absolute;
  $maxtemperature = $row -> truthplace;
  $minerals = $row -> year;
 
$iconstyle = "{weight: 1, color: '#e32e0f'},";

$radius = 10;



  $sprite = " iconPieChartRadius: " . $radius . ", iconPieChartCoreRadius: 0"; 


  $objrequest = ".add(new ymaps.Placemark([" . $lat . ", " . $lon . "], { data: [ ";

  $objrequest.= $iconstyle . " ], iconContent: '', balloonContentHeader: '" . $name . "', balloonContentBody: '"; 


                                                                         
  if ($location != null and $location != " ") {
  $objrequest.= $location . "<br>";  };

  if ($oopt != null and $oopt != " ") {
  $objrequest.= "<b>" . $Toopt . ":</b> " . $oopt . "<br>";  };

  if ($province != null and $province != " ") {
  $objrequest.= "<b>" . $Tprovince . ":</b> " . $province . "<br>"; };

  if ($absolute != null and $absolute != " ") {
  $objrequest.= "<b>" . $Tabsolute . ":</b> " . $absolute . "<br>"; };

  if ($wellsnumber != null and $wellsnumber != " ") {
  $objrequest.= "<b>" . $Twellsnumber . ":</b> " . $wellsnumber . " <br>" ; }; 

  if ($ispolzovanie != null and $ispolzovanie != " ") {
  $objrequest.= "<b>" . $Tispolzovanie . ":</b> " . $ispolzovanie . "<br>";  };

  if ($perspective != null and $perspective != " ") {
  $objrequest.= "<b>" . $Tperspective . ":</b> " . $perspective . " <br>" ; }; 
  
  if ($readyness!= null and $readyness!= " ") {
  $objrequest.= "<b>" . $Treadyness . ": </b>" . $readyness. " <br>" ; }; 

  if ($balneolog != null and $balneolog != " ") {
  $objrequest.= "<b>" . $Tbalneolog . ": </b>" . $balneolog . "<br>";  };

  if ($minerals != null and $minerals != " ") {
  $objrequest.= "<b>" . $Tminerals . ": </b>" . $minerals . "<br>";  };

  if ($function != null and $function != " ") {
  $objrequest.= "<b>" . $Tfunction . ": </b> " . $function . "<br>";  };

  if ($ph != null and $ph != " ") {
  $objrequest.= "<b>pH: </b>" . $ph . " <br>" ; }; 

  if ($phclass != null and $phclass != " ") {
  $objrequest.= "<b>" . $Tphclass . ":</b> " . $phclass . "<br>" ; };
  
  if ($maxtemperature != null and $maxtemperature != " ") {
  $objrequest.= "<b>" . $Tmaxtemperature . ": </b>" . $maxtemperature . "&deg;C<br>" ;  };

  if ($temperatureclass != null and $temperatureclass != " ") {
  $objrequest.= "<b>" . $Ttemperatureclass . ": </b>" . $temperatureclass . "<br>" ;  };

  if ($debit  != null and $debit  != " ") {
  $objrequest.= "<b>" . $Tdebit .": </b>" . $debit  . " <br>" ; }; 

  if ($temperaturedep != null and $temperaturedep != " ") {
  $objrequest.= "<b>" . $Ttemperaturedep .":</b> " . $temperaturedep . "&deg;C <br>";  };

  if ($potresourse != null and $potresourse != " ") {
  $objrequest.= "<b>" . $Tpotresourse . ": </b>" . $potresourse . " <br>" ; }; 

  if ($pp != null and $pp != " ") {
  $objrequest.= $pp . " <br>" ; }; 


  $objrequest.= "', balloonContentFooter: '' }, { preset: 'islands#icon', iconLayout: 'default#pieChart', "; 
  $objrequest.= $sprite . ", }))";  

  echo $objrequest;

 endforeach; endif; ?>
  
    myMap.geoObjects.add(clusterer);
    
});

    </script>


<section class="single-banner">
  <div class="container">
    <div class="single-banner__content">
     <h1><?php the_title(); ?></h1>
    </div>
  </div>
</section>

<section class="single-text">
  <div class="container">

  </div>
</section>

<section class="map-container">
  <div class="container">

    <div class="legend">
      <div class="">
        <form class="search-form__body" method="GET">
          <input name="thename" id="thename" type="text" placeholder="<?php echo __('Введите название...', 'gisre-plugin'); ?>" value="<?php echo $searchtext ?>">
          <button type="submit"><?php echo __('Поиск', 'gisre-plugin'); ?></button><br>
          <?php

          $page = get_page_by_path('geomap');
          $page_url = get_permalink( apply_filters( 'wpml_object_id', $page->id, 'page', true, $current_lang ) );

          if ($searchtext) {
            echo '<a href="' . $page_url . '">' . __('Очистить поиск', 'gisre-plugin') . '</a>';
          }
          ?>

        </form><br><br>
      </div>
    <?php the_content(); ?>
    </div>
    <div class="map">
      <div id="map" class="yandex-map"></div>
    </div>
  </div>
</section>



<?php get_footer(); ?>