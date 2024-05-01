<?php
require_once plugin_dir_path(__FILE__) . 'GetObjects.php';
require_once plugin_dir_path(__FILE__) . 'GetTypes.php';
$getObjects = new GetObjects();
$getTypes = new GetTypes();

if (isset($_GET['type'])) {
  $typesearch = $_GET['type'];
} else {
  $typesearch = false;
}

$searchtext = false;
if (isset($_GET['thename'])) {         
  $searchtext = $_GET['thename']; 
}

$availableColors = $getTypes->colors;

if (!$typesearch || $typesearch == "ALL") {
  $colorsArray = $availableColors;
} else {
  $typesForLegend = $getTypes->energy[$typesearch]['legend']; 
  $colorsArray = array();
  foreach ($availableColors as $key => $value) {
    if (in_array($key, $typesForLegend)) {
      $colorsArray[$key] = $value;
    }
  }
}

get_header();

$myCounter = 0;
?> 


  <script src="https://api-maps.yandex.ru/2.1/?apikey=b6a7a43d-4ce5-45d6-9b18-5eb8015dbbfa&lang=ru_RU" type="text/javascript"></script>
    <script type="text/javascript">
   ymaps.ready(function () {
    var myMap = new ymaps.Map('map', {

            <?php 

            if (count($getObjects->objects) == 1) {   
                $newLat = $getObjects->objects[0]->lat;
                $newLon = $getObjects->objects[0]->lon;                
                $mapcenter = "center: [" . $newLat . ", " . $newLon. "], zoom: 6,";

            } else {
                $mapcenter = "center: [60.76, 97.64], zoom: 3,";
            }

            echo $mapcenter;
            ?>
            
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
            gridSize: 5
        }),
	
 
        getPointData = function (index) {
            return {
                balloonContentHeader: '<font size=3><b><a target="_blank" href="https://yandex.ru">Здесь может быть ваша ссылка</a></b></font>',
                balloonContentBody: '<p>Ваше имя: <input name="login"></p><p>Телефон в формате 2xxx-xxx:  <input></p><p><input type="submit" value="Отправить"></p>',
                balloonContentFooter: '<font size=1>Информация предоставлена: </font> балуном <strong>метки ' + index + '</strong>',
                clusterCaption: 'метка <strong>' + index + '</strong>'
            };

        },

        getPointOptions = function () {
            return {
                preset: 'islands#violetIcon'
            };
        },
        geoObjects = [];

 <?php 
 
$index = 0;
 
 foreach ($getObjects->objects as $row): 

  $type = $row -> type;
  $name = $row -> name;
  $lat = $row -> lat;
  $lon = $row -> lon;
  $power = $row -> power;
  $powerpr = $row -> powerpr;
  $river = $row -> river;
  $year = $row -> year;
  $location = $row -> location;
  $status = $row -> status;
  $function = $row -> function;
  $pp = $row -> pp;
  $gen = $row -> gen;
  $holder = $row -> holder;
  $source = $row -> source;
  $link = $row -> link;
  $linkshort = $row -> linkshort;
  $picture = $row -> picture;
  $date = $row -> date;
  $pubdate = substr($date, 0, 10);

  if ($status) { trim($status); }
  if ($picture) { trim($picture); }
  if ($link) { trim($link); }
  if ($type) { trim($type); }

// Определяем цвет иконки. По дефолту розовый - поиск ошибок
$iconstyle = "{weight: 1, color: '#ff49e7'},";

    if ($type == "SES") {$iconstyle = "{weight: 1, color: '#e4dc0c'},";};
    if ($type == "SV") {$iconstyle = "{weight: 1, color: '#e4dc0c'},{weight: 1, color: '#116889'},";};
    if ($type == "SD") {$iconstyle = "{weight: 1, color: '#e4dc0c'},{weight: 1, color: '#000000'},";};
    if ($type == "SVD") {$iconstyle = "{weight: 1, color: '#e4dc0c'},{weight: 1, color: '#116889'},{weight: 1, color: '#000000'},";};
    if ($type == "SVU") {$iconstyle = "{weight: 1, color: '#f5a10a'},";};
    if ($type == "VES") {$iconstyle = "{weight: 1, color: '#116889'},";};
    if ($type == "VDES") {$iconstyle = "{weight: 1, color: '#116889'},{weight: 1, color: '#000000'},";};
    if ($type == "BIO") {$iconstyle = "{weight: 1, color: '#4d9c29'},";};
    if (($type== "BIOC") OR ($type == "BIOI") OR ($type == "BIOT") OR ($type == "BIOZ")) {$iconstyle = "{weight: 1, color: '#93de00'},";};
    if (($type == "GEOE") OR ($type == "GEOT") OR ($type == "GEOTE")) {$iconstyle = "{weight: 1, color: '#e32e0f'},";};
    if ($type == "TN") {$iconstyle = "{weight: 1, color: '#510337'},";};
    if ($type == "TNSVU") {$iconstyle = "{weight: 1, color: '#510337'},{weight: 1, color: '#f5a10a'},";};
    if ($type == "PES") {$iconstyle = "{weight: 1, color: '#17498c'},";};
    if ($type == "MGES") {$iconstyle = "{weight: 1, color: '#85b4f4'},";};
  

// Определяем размер кружка - корень от мощности

$radius = pow($power, 1/5.5);

if ($power == NULL) {
  $radius = 4;
};

if ($radius < 4) {
  $radius = 4;
};



// Проставляем статусы, строящиеся и проектируемые кружки серыми 

  if ($status == "s") { $status = "строящаяся"; $iconstyle = "{weight: 1, color: '#676767'},";} ;
  if ($status == "d") { $status = "действующая"; };
  if ($status == "z") { $status = "<font color=\"red\">не эксплуатируется</font>"; };
  if ($status == "x") { $status = "<font color=\"red\">объект не построен</font>"; $iconstyle = "{weight: 1, color: '#DDDDDD'},"; $radius = 4; };
  if ($status == "p") { $status = " проектируемая "; $iconstyle = "{weight: 1, color: '#DDDDDD'},"; $radius = 4;};

  $sprite = " iconPieChartRadius: " . $radius . ", iconPieChartCoreRadius: 0"; 

 
  $objrequest = "geoObjects[" . $index ."] = new ymaps.Placemark([" . $lat . ", " . $lon . "], { data: [ ";

  $objrequest.= $iconstyle . " ], iconContent: '";

  if ($function == 's') {
    $objrequest.= "&#9741;";
  } 
  $objrequest.="', balloonContentHeader: '" . $name . "', balloonContentBody: '"; 

  if ($picture != null and $picture != " ") {

    if (is_numeric($picture)) {
      $pictureUrl = wp_get_attachment_image_url($picture, 'medium');
    } else {    
      $pictureUrl = site_url() . "/wp-content/images/gismaps/" . $picture;
    }
    $objrequest.= "<br> <img src=\"" . $pictureUrl . "\"  style=\"max-height:150px; width: auto;\" ><br><br>";  

  };

  if ($power != null and $power != " " and $power != "0") {


     if ($status == "действующая") {
	    $myCounter += $power;
	};

    if ($power < 1000 ) {
      $powertext = $power . " Вт";
    } elseif ($power < 1000000 ) {
        $powertext = $power/1000 . " кВт" ;
    } elseif ($power < 1000000000 ) {
        $powertext = $power/1000000 . " МВт";
    } elseif ($power >= 1000000000 ) {
        $powertext = $power/1000000000 . " ГВт";
    };
    $objrequest.= "<b> Мощность: </b>" . $powertext . "<br>";  };

  if ($powerpr != null and $powerpr != " ") {
  $objrequest.= "" . $powerpr . "<br>";  };

  $objrequest.= "<b>Статус: </b>" . $status . "<br>" ;
  if ($river != null and $river != " ") {
  $objrequest.= "<b> Водный объект: </b>" . $river . "<br>";  };

  if ($function != null and $function != " ") {
    if ($function == 's') {
      $f = 'сетевая';
    }

    if ($function == 'a') {
      $f = 'автономная';
    } 
  $objrequest.= "<b>Назначение: </b> " . $f . "<br>";  };
  
  if ($gen == 1) {
  $objrequest.= "<font color=\"green\">Является квалифицированным генерирующим объектом, функционирующим на основе использования ВИЭ</font> <br>" ;  };

  if ($year != null and $year != " ") {
  $objrequest.= "<b> Год ввода в эксплуатацию: </b>" . $year . "<br>";  };


  $objrequest.= "<b>Район размещения: </b>" . $location . "<br>";
  
  if ($holder != null and $holder != " ") {
  $objrequest.= $holder . "<br>"; };

  if ($source != null and $source != " ") {
  $objrequest.= "<b>Источник: </b> " . $source . "<br>" ; };

  if ($link != null and $link != " ") {
  $objrequest.= "<b>Ссылка: </b> <a href=\"" . $link . "\" target=\"_blank\"> " . $linkshort . "</a> <br>" ; }; 

  $objrequest.= " ', balloonContentFooter: 'Обновление данных: " . $pubdate . "' }, { preset: 'islands#icon', iconLayout: 'default#pieChart', "; 
  $objrequest.= $sprite . ", })";  

  // echo 'geoObjects[' . $index .'] = new ymaps.Placemark([' . $lat . ', ' . $lon . '], getPointData(' . $index .'), getPointOptions());';
  echo $objrequest . PHP_EOL;
  $index++;

 endforeach; 

 ?>


 clusterer.add(geoObjects);
 myMap.geoObjects.add(clusterer);
    
});

    </script>

<section class="single-banner">
  <div class="container">
    <div>
     <h1><?php  
     
        if (!$typesearch || ($typesearch == 'ALL')) {
          the_title();
        } else {

          if (get_locale() == 'ru_RU') { 
            echo $getTypes->energy[$typesearch]['runame']; 
            echo ' на карте';
          } else { 
            echo $getTypes->energy[$typesearch]['enname']; 
            echo ' on map';
          }
         
        }
     ?></h1>
    </div>
  </div>
</section>

<section class="single-text">
  <div class="container">
    <div class="single-text__content">       
      <p><?php echo the_content(); ?></p>
    </div>
  </div>
</section>

<section class="map-container">
  <div class="container">
    <div class="legend">

        <div class="search-items">
          <form class="search-form" method="GET">
            <input name="thename" id="thename" type="text" placeholder="Название объекта..." value="<?php echo $searchtext ?>">
            <button class="btn btn--light btn--small" type="submit">Поиск</button>
          

          <?php 
        
        if ($searchtext) {         
          
          echo '<p>';
          echo  (count($getObjects->objects) == 0) ? "Ни одного объекта не найдено для " : "Результат поиска для ";
          echo "&quot;" . $searchtext . "&quot; .</p>";
          echo '<a class="btn btn--light btn--small" href="' . site_url('/gis-objects-map/') . '">' . __('Очистить поиск', 'gisre-plugin') . '</a>';
         }
        
        ?>
        </div>
        </form>

        <form method="GET">

          <div class="object-types-form">
          
            <div class="object-types-form__type">
              <input type="radio" name="type" value="ALL" id="ALL"
              <?php if (!$typesearch || $typesearch == 'ALL') {
                echo 'checked';
                    
              }  ?>
              >
              <label for="ALL">Все объекты</label>
            </div>
          <?php                                        
              foreach ($getTypes->energy as $key => $value) { 
          ?>  <div class="object-types-form__type">
                  <input 
                    type="radio" 
                    name="type" 
                    id="<?php echo $key ?>" 
                    value="<?php echo $key ?>"
                    <?php if ($typesearch === $key) {
                    echo 'checked';
                    } ?>
                    >
                  <label for="<?php echo $key ?>"><?php echo $value["runame"];  ?></label>
              </div>                  

          <?php } ?>   
          </div>
          <button type="submit" class="btn btn--light btn--small"> Применить фильтр </button>
        </form>

        <div class="map-legend">
            <h4>Условные обозначения:</h4>
            <div class="legend__items">
              <?php 
                foreach ($colorsArray as $key => $value) { ?>
                  <div class="legend__item">
                    <div class="legend__round" style="background-color: <?php echo $value['color'] ?>">

                    </div>
                    <div class="legend__desc">
                    <?php echo $value['name'] ?>
                    </div>
                  </div>
                <?php }
              ?>                
                  <div class="legend__item">
                    <div class="legend__round" style="background-color: #EEEEEE">
                    &#9741;
                    </div>
                    <div class="legend__desc">
                      Сетевой объект
                    </div>
                  </div>
                  <div class="legend__item">
                    <div class="legend-power">

                      <div class="legend-power__item legend-power__small"></div>
                      <div class="legend-power__item legend-power__divider">&#8594;</div>
                      <div class="legend-power__item legend-power__large"></div>

                    </div>
                    <div class="legend__desc">
                    Мощность<br>
                    1кВт &#8594; 30МВт
                    </div>
                  </div>
            </div>
          </div>
      
    </div>
    <div class="map">
      <div class="total"> 
        
                <p>
                <?php  

                //  RESULT POWER 

                    if ($myCounter > 999999 ) {

                        if ($myCounter < 1000000000 ) {
                            $myCounter = $myCounter/1000000;
                        $myCounter = round($myCounter, 2);
                            $myCounter.= " МВт";
                        } elseif ($myCounter >= 1000000000 ) {
                            $myCounter = $myCounter/1000000000;
                        $myCounter = round($myCounter, 2);
                            $myCounter.= " ГВт";
                        };

                        echo "Итого, известная мощность обозначенных на карте действующих объектов: " . $myCounter; 
                    }
                ?> 
                </p>
        
      </div>
      <div id="map" class="yandex-map"></div>
    </div>
  </div>
</section>


<?php get_footer(); ?>