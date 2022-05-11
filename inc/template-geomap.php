<?php 
require_once plugin_dir_path(__FILE__) . 'GetGeodata.php';
$rows = new GetGeodata();

get_header(); ?>




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


  $lat = $row -> lat;
  $lon = $row -> lon;
  $oopt = $row -> power;
  $sovrIspolz = $row -> powerpr;
  $balneolog = $row -> river;
  $minerals = $row -> year;
  $location = $row -> location;
  $status = $row -> status;
  $function = $row -> function;
  $truthplace = $row -> truthplace;
  $pp = $row -> pp;
  $gen = $row -> gen;
  $holder = $row -> holder;
  $source = $row -> source;
  $link = $row -> link;
  $linkshort = $row -> linkshort;
  $picture = $row -> picture;
  $date = $row -> date;
  $check_obj = $row -> check_obj;
  $absolute = $row -> absolute; 
  $potresourse = $row -> potresourse; 
  $debit = $row -> debit;
 
 
 
$iconstyle = "{weight: 1, color: '#e32e0f'},";

$radius = 10;



  $sprite = " iconPieChartRadius: " . $radius . ", iconPieChartCoreRadius: 0"; 


  $objrequest = ".add(new ymaps.Placemark([" . $lat . ", " . $lon . "], { data: [ ";

  $objrequest.= $iconstyle . " ], iconContent: '', balloonContentHeader: '" . $name . "', balloonContentBody: '"; 


                                                                         
  if ($location != null and $location != " ") {
  $objrequest.= $location . "<br>";  };

  if ($oopt != null and $oopt != " ") {
  $objrequest.= "<b> В состав какого ООПТ входит: : </b>" . $oopt . "<br>";  };

  if ($holder != null and $holder != " ") {
  $objrequest.= "<b>Геотермальная провинция: </b>" . $holder . "<br>"; };

  if ($absolute != null and $absolute != " ") {
  $objrequest.= "<b>Абсолютная отметка: </b>" . $absolute . "<br>"; };

  if ($date != null and $date != " ") {
  $objrequest.= "<b>Количество источников: </b>" . $date . " <br>" ; }; 

  if ($sovrIspolz != null and $sovrIspoolz != " ") {
  $objrequest.= "<b>Современное использование: </b>" . $sovrIspolz . "<br>";  };

  if ($check_obj != null and $check_obj != " ") {
  $objrequest.= "<b>Перспективная область эксплуатации:  </b>" . $check_obj . " <br>" ; }; 
  
  if ($link != null and $link != " ") {
  $objrequest.= "<b>Уровень подготовленности и использования: </b>" . $link . " <br>" ; }; 

  if ($balneolog != null and $balneolog != " ") {
  $objrequest.= "<b> Бальнеологическая характеристика вод: </b>" . $balneolog . "<br>";  };

  if ($minerals != null and $minerals != " ") {
  $objrequest.= "<b> Минерализация г/л: </b>" . $minerals . "<br>";  };

  if ($function != null and $function != " ") {
  $objrequest.= "<b>Классификация по минерализации: </b> " . $function . "<br>";  };

  if ($linkshort != null and $linkshort != " ") {
  $objrequest.= "<b>pH: </b>" . $linkshort . " <br>" ; }; 

  if ($source != null and $source != " ") {
  $objrequest.= "<b>Классификация по pH: </b> " . $source . "<br>" ; };
  
  if ($truthplace != null and $truthplace != " ") {
  $objrequest.= "<b>Максимальная температура: </b>" . $truthplace . "&deg;C<br>" ;  };

  if ($gen != null and $gen != " ") {
  $objrequest.= "<b>Классификация по температуре: </b>" . $gen . "<br>" ;  };

  if ($debit  != null and $debit  != " ") {
  $objrequest.= "<b>Суммарный дебит,  л/с или кг/с: </b>" . $debit  . " <br>" ; }; 

  if ($picture != null and $picture != " ") {
  $objrequest.= "<b>Температура на глубине:</b> " . $picture . "&deg;C <br>";  };

  if ($potresourse != null and $potresourse != " ") {
  $objrequest.= "<b>Потенциальные ресурсы термальных вод: </b>" . $potresourse . " <br>" ; }; 

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
      <div class="single-text__desc">
        
        <div class="single-text__content">
          <?php the_content(); ?>
        </div>

      </div>
  </div>
</section>

<div id="map" class="yandex-map"></div>

<?php get_footer(); ?>