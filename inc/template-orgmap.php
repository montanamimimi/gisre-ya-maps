<?php 
require_once plugin_dir_path(__FILE__) . 'GetOrgdata.php';
$rows = new GetOrgdata();

get_header(); 

if (isset($_GET['type'])){
    $type = $_GET['type'];
} else {
    $type = 'ALL';
}

?>


<script src="https://api-maps.yandex.ru/2.1/?apikey=b6a7a43d-4ce5-45d6-9b18-5eb8015dbbfa&lang=ru_RU" type="text/javascript"></script>
    <script type="text/javascript">
   ymaps.ready(function () {
    var myMap = new ymaps.Map('map', {
            center: [60.76, 97.64],
            zoom: 3,
            behaviors: ['default', 'scrollZoom'],
	    controls: ['zoomControl', 'searchControl', 'typeSelector',  'fullscreenControl']
        }, {
            searchControlProvider: 'yandex#search'
        })

    var customItemContentLayout = ymaps.templateLayoutFactory.createClass(
        // Флаг "raw" означает, что данные вставляют "как есть" без экранирования html.
        '<h4 class=ballon_header>{{ properties.balloonContentHeader|raw }}</h4>' +
        '<div class=ballon_body>{{ properties.balloonContentBody|raw }}</div>' +
        '<div class=ballon_footer><small>{{ properties.balloonContentFooter|raw }}<small></div>'
    );

         clusterer = new ymaps.Clusterer({
            preset: 'islands#invertedNightClusterIcons',
            groupByCoordinates: false,
            clusterDisableClickZoom: true,
            clusterHideIconOnBalloonOpen: false,
            geoObjectHideIconOnBalloonOpen: false,
	    clusterBalloonItemContentLayout: customItemContentLayout,
            gridSize: 20
        }),
		
    clusterer
<?php if ($rows):
foreach ($rows->data as $row): 
 
  $lat = $row -> lat;
  $lon = $row -> lon;
  $name = $row -> name;
  $city = $row -> city;
  $adress = $row -> adress;
  $phone = $row -> phone;
  $email = $row -> email;
  $link = $row -> link;
  $type = $row -> type;
  $sune = $row -> sune;
  $sunt = $row -> sunt;
  $wind = $row -> wind;
  $bio = $row -> bio;
  $gidro = $row -> gidro;
  $geo = $row -> geo;
  $pri = $row -> pri;
  $tn = $row -> tn;

  $name = trim(preg_replace('/\s{2,}/', ' ', $name));
  $adress = trim(preg_replace('/\s{2,}/', ' ', $adress));
  $type = trim(preg_replace('/\s{2,}/', ' ', $type));
  $link = trim(preg_replace('/\s{2,}/', ' ', $link));
  $phone = trim(preg_replace('/\s{2,}/', ' ', $phone));
  $email = trim(preg_replace('/\s{2,}/', ' ', $email));



  $objrequest = ".add(new ymaps.Placemark([" . $lat . ", " . $lon . "], { data: [ ";
  
  if ($sune == 1) {
  $objrequest.= "{weight: 1, color: '#f7f606'},";
  };

  if ($sunt == 1) {
  $objrequest.= "{weight: 1, color: '#f5a10a'},";
  };

  if ($wind == 1) {
  $objrequest.= "{weight: 1, color: '#062194'},";
  };

  if ($bio == 1) {
  $objrequest.= "{weight: 1, color: '#4d9c29'},";
  };

  if ($gidro == 1) {
  $objrequest.= "{weight: 1, color: '#6bb7d9'},";
  };

  if ($pri == 1) {
  $objrequest.= "{weight: 1, color: '#305ec0'},";
  };

  if ($geo == 1) {
  $objrequest.= "{weight: 1, color: '#e32e0f'},";
  };

  if ($tn == 1) {
  $objrequest.= "{weight: 1, color: '#510337'},";
  };


  $objrequest.= " ], iconContent: '', balloonContentHeader: '" . $name . "<br>', balloonContentBody: '". $city . ", " . $adress . " ";

  if ($phone != null and $phone != " ") {
  	$objrequest.= "<br><b>Телефон:</b> " . $phone . " ";
	};
  if ($email != null and $email != " ") {
  	$objrequest.= "<br><b>e-mail:</b> " . $email . " ";
	};
  if ($link != null and $link != " ") {
  	$objrequest.= "<br> <a href=\"" . $link . "\" target=\"_blank\">Веб-страница</a>";
	};


  $objrequest.= " <br><br><h4> Направление деятельности </h4> | ";
  
  if ($sune == "1") {
	  $objrequest.= "cолнечная электроэнергетика | ";
  };
  if ($sunt	 == "1") {
	  $objrequest.= "cолнечная теплоэнергетика | ";
  };
  if ($wind == "1") {
	  $objrequest.= "ветроэнергетика | ";
  };
  if ($bio == "1") {
	  $objrequest.= "биоэнергетика | ";
  };
  if ($gidro == "1") {
	  $objrequest.= "малая гидроэнергетика |";
  };
  if ($geo == "1") {
	  $objrequest.= "Геотермальная энергия |";
  };
  if ($pri == "1") {
	  $objrequest.= "приливная гидроэнергетика |";
  };
  if ($tn == "1") {
	  $objrequest.= "тепловые насосы |";
  };
  
  
  $objrequest.= "', balloonContentFooter: '<br><br>Тип организации: " . $type . "' }, ";
  $objrequest.= "{ preset: 'islands#icon', iconColor: '#0e4779', iconLayout: 'default#pieChart', iconPieChartRadius: 22, iconPieChartCoreRadius: 0, }))";
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
      <div >            
          <?php the_content(); ?>        
      </div>
  </div>
</section>

<section>
    <div class="container">
        <div class="geodata__options">

            <form class="object-types-form" method="GET">
            <div class="object-types-form__type">
                <input type="radio" name="type" value="ALL" id="ALL"
                <?php if ($type == 'ALL') {
                    echo 'checked';
                } ?>
                >
                <label for="ALL">Все организации</label>
            </div>
            <?php        
            
                $orgoptions = array('SCIENSE' => 'Научные организации', 'SALES' => 'Коммерческие организации');
                foreach ($orgoptions as $key => $value) { 
            ?>  <div class="object-types-form__type">
                    <input 
                    type="radio" 
                    name="type" 
                    id="<?php echo $key ?>" 
                    value="<?php echo $key ?>"
                    <?php if ($type === $key) {
                    echo 'checked';
                    } ?>
                    >
                    <label for="<?php echo $key ?>"><?php echo $value;  ?></label>
                </div>                  

            <?php } ?>   
            <button type="submit" class="object-types-form__button"> Применить фильтр </button>
        </form>

        </div>
    </div>
</section>

<div id="map" class="yandex-map"></div>

<?php get_footer(); ?>