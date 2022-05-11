<?php 
require_once plugin_dir_path(__FILE__) . 'GetSundata.php';
require_once plugin_dir_path(__FILE__) . 'GetSunoptions.php';
$rows = new GetSundata();
$sunOptions = new GetSunoptions();

$suncolors = array (
  '2.0' => 'fffbbf',
  '2.5' => 'fff785',
  '3.0' => 'fff34d',
  '3.2' => 'ffed00',
  '3.4' => 'ffdc00',
  '3.6' => 'fecc00',
  '3.8' => 'fbba00',
  '4.0' => 'f7a600',
  '4.2' => 'f39100',
  '4.4' => 'f07b00',
  '4.6' => 'ec6500',
  '4.8' => 'e84c03',
  '5.0' => 'e52e0a',
  '5.5' => 'e00202',
  '6.5' => 'd00303',
  'Более' => 'c00000',
);


get_header(); ?>

    <script src="https://api-maps.yandex.ru/2.1/?apikey=c7787d5f-f9be-45c4-986a-6fa101bd672d&lang=ru_RU" type="text/javascript"></script>
    <script type="text/javascript">
ymaps.ready(init);
var myMap, myGeoObject, myRectangle;

function init () {
    myMap = new ymaps.Map('YMapsID', {
        center: [64.7667, 102.3165],
        zoom: 2,
        controls: ["zoomControl", "searchControl", "typeSelector", "fullscreenControl"]
    }, {
        searchControlProvider: 'yandex#search'
    });



 <?php foreach ($rows->data as $row): 
 

  $lat = $row -> lat;
  $lon = $row -> lon;
  $id = $row -> id;
  $data = $row -> data;
$data = round($data,1);

$lat1 = $lat + 1;
$lon1 = $lon + 1;

if ($data < 0) {$color = "ffffff";} 
elseif ($data < 2.0) {$color = "fffbbf";}
elseif ($data < 2.5) {$color = "fff785";} 
elseif ($data < 3.0) {$color = "fff34d";} 
elseif ($data < 3.2) {$color = "ffed00";} 
elseif ($data < 3.4) {$color = "ffdc00";} 
elseif ($data < 3.6) {$color = "fecc00";} 
elseif ($data < 3.8) {$color = "fbba00";} 
elseif ($data < 4.0) {$color = "f7a600";} 
elseif ($data < 4.2) {$color = "f39100";} 
elseif ($data < 4.4) {$color = "f07b00";} 
elseif ($data < 4.6) {$color = "ec6500";} 
elseif ($data < 4.8) {$color = "e84c03";} 
elseif ($data < 5.0) {$color = "e52e0a";} 
elseif ($data < 5.5) {$color = "e00202";} 
elseif ($data < 6.5) {$color = "d00303";} 
else { $color = "c00000"; };

if ($data < 0) {$data = "нет данных";} else {$data .= " кВтч/м<sup>2</sup> в день"; };

$mrect = "myRectangle" . $id . " = new ymaps.Rectangle([ [ ";
$mrect .= $lat . ", " . $lon . "] , [" . $lat1 . ", " . $lon1 . "] ], ";
$mrect .= " { hintContent: ' Солнечная радиация: <br> " . $data . " ";
$mrect .= " <br> <br> Широта: " . $lat . "&deg; <br> Долгота: " . $lon . "&deg; ' },";
$mrect .= " { fillColor: '#" . $color . "', fillOpacity: 0.8, strokeColor: '#ff0000', strokeOpacity: 0.05, strokeWidth: 1, });";
$mrect .= "  myMap.geoObjects .add(myRectangle" . $id . ");";

  echo $mrect;

  endforeach;  ?>




}

</script>


<section class="single-banner">
  <div class="container">
    <div class="single-banner__content">
     <h1><?php the_title(); ?></h1>
    </div>
  </div>
</section>

<section>
  <div class="container">
      <div class="plugin-text">
          <?php the_content(); ?>
      </div>
  </div>
</section>


<section class="sunoptions sunres-option">
  <div class="container">

    <form class="sunoptions__form" method="GET">    
      
      <div class="sunoptions__form-item">
        <img class="sunoptions__image" src="<?php echo plugin_dir_url(__FILE__) . "images/" . $_GET['surface'] . ".png"; ?>">
      </div>
      
      <div class="sunoptions__form-item">

        <select id="surface" name="surface" class="sunoptions__selector" required>
            <option value=""> -- угол наклона -- </option>
            <?php 
            foreach ($sunOptions->surface as $key => $value) { ?>
              <option value="<?php echo $key ?>" 
              <?php if ($key == $_GET['surface']) { echo 'selected';} ?>
              ><?php echo $value['runame']; ?></option>
            <?php }
            ?>              
        </select> 
      </div>
      <div class="sunoptions__form-item">
        <select id="period" name="period" class="sunoptions__selector" required>
          <option value=""> -- период -- </option>
          <?php 
            $currentSurface = $_GET['surface'];
            $currentPeriods = $sunOptions->surface[$currentSurface]['periods'];        
            
            foreach ($currentPeriods as $key => $value) { ?>
              <option class="period-option" value="<?php echo $key; ?>"
              <?php if ($key == $_GET['period']) { echo 'selected';} ?>
              ><?php echo $value; ?></option>
            <?php }
          ?>                        
        </select> 
      </div>
      <div class="sunoptions__form-item">
        <button type="submit" class="sunoptions__button"> Показать</button>
      </div>
      
    </form>
  </div>
</section>

<section>
  <div class="container">
      <div class="suncolors__legend">
        <p>Значения в кВтч/м<sup>2</sup> в день</p>
        <div class="suncolors__items">
              <div class="suncolors__item">
                <div class="suncolors__color-white" style="background-color: white;">

                </div>
                <div class="suncolors__desc">
                  <small>Нет&nbsp;данных</small>
                </div>
              </div>
          <?php 
            foreach ($suncolors as $key => $value) { ?>
              <div class="suncolors__item">
                <div class="suncolors__color" style="background-color: #<?php echo $value ?>;">

                </div>
                <div class="suncolors__desc">
                  <small><?php echo $key ?></small>
                </div>
              </div>
            <?php }
          
          ?>
        </div>
      </div>
      <div class="suncolors__legend-mob">
        <div class="suncolors__legend-mob-desc">
          <div class="from">
              
            2.0 кВтч/м<sup>2</sup> в день
          </div>
          <div class="to">
            6.5 кВтч/м<sup>2</sup> в день
            </div>
        </div>
        <div class="suncolors__legend-mob-colors">

        </div>
      </div>
  </div>
</section>


  
<div id="YMapsID"  class="yandex-map"></div>




<?php get_footer(); ?>