<?php 
require_once plugin_dir_path(__FILE__) . 'GetSundata.php';
require_once plugin_dir_path(__FILE__) . 'GetSunoptions.php';
$rows = new GetSundata();
$sunOptions = new GetSunoptions();


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

<section class="single-text">
  <div class="container">
      <div class="single-text__desc">
        
        <div class="single-text__content">
          <?php the_content(); ?>
        </div>
      </div>
  </div>
</section>


<section>
    <div class="container">
        <div class="sunoptions">
                
            <?php                                        
                foreach ($sunOptions->surface as $key => $value) { 
            ?>  <div class="sunoptions__surface-item">
                    <form class="sunoptions__form" method="GET">
                    <input 
                    type="hidden" 
                    name="surface" 
                    id="<?php echo $key ?>" 
                    value="<?php echo $key ?>"
                    >
                    
                        <p class="sunoptions__desc"><?php echo $value['runame'] ?></p>
                        <img class="sunoptions__image" src="<?php echo plugin_dir_url(__FILE__) . "images/" . $key . ".png"; ?>">
      

                    <select name="period" class="sunoptions__selector">
                    <option 
                    
                    <?php 

                    if ($_GET['surface'] != $key) {
                      ?> selected="true" <?php  }  ?> 
                    
                    disabled="disabled"> -- выбрать -- </option>
                    <?php                                        
                    foreach ($value['periods'] as $period => $text) { 
                      ?>
                      <option value="<?php echo $period ?>" 
                      <?php  

                      if (($_GET['surface'] == $key) && $_GET['period'] == $period) {
                        ?> selected="true" <?php
                      }
                      
                      ?>  ><?php echo $text ?></option>
                    <?php }
                    
                    ?>                  
                    </select> 
                    <button type="submit" class="sunoptions__button"> Показать</button>
                    </form>
                </div>                  

            <?php } ?>   

        
      

        </div>
    </div>
</section>
  
<div id="YMapsID"  style="position: relative; width: 100%; height: 500px;"></div>




<?php get_footer(); ?>