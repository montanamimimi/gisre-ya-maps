<?php 
require_once plugin_dir_path(__FILE__) . 'GetGeodata.php';
$rows = new GetGeodata();
$current_lang = apply_filters( 'wpml_current_language', NULL );

$Toopt = __('В состав какого ООПТ входит', 'gisre-plugin');
$Tprovince = __('Геотермальная провинция', 'gisre-plugin');
$Twellsnumber = __('Количество источников', 'gisre-plugin');
$Tispolzovanie = __('Современное использование', 'gisre-plugin');
$Tperspective = __('Перспективная область эксплуатации', 'gisre-plugin');
$Tbalneolog = __('Бальнеологическая характеристика вод', 'gisre-plugin');
$Tminerals = __('Минерализация г/л', 'gisre-plugin');
$Tfunction = __('Классификация по минерализации', 'gisre-plugin');
$Tmaxtemperature = __('Максимальная температура', 'gisre-plugin');
$Ttemperatureclass = __('Классификация по температуре', 'gisre-plugin');
$Tphclass = __('Классификация по pH', 'gisre-plugin');
$Treadyness = __('Уровень подготовленности и использования', 'gisre-plugin');
$Ttemperaturedep = __('Температура на глубине', 'gisre-plugin');
$Tabsolute = __('Абсолютная отметка', 'gisre-plugin'); 
$Tpotresourse = __('Потенциальные ресурсы термальных вод', 'gisre-plugin'); 
$Tdebit = __('Суммарный дебит, л/с или кг/с', 'gisre-plugin');

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

$name = $row -> name;
$oopt = $row -> oopt;
$location = $row -> location;
$readyness= $row -> ready;
$phclass = $row -> ph;
$function = $row -> minclass;
$balneolog = $row -> balneol;
$perspective = $row -> perspective;
$ispolzovanie = $row -> powerpr;
$pp = $row -> dop;
$temperatureclass = $row -> tclass;
$wellsnumber = $row -> wellsnumber;
$province = $row -> province;
$temperaturedep = $row -> temperaturedep;
$potresourse = $row -> potresourse; 
$debit = $row -> debit;
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