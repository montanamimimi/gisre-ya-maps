<?php get_header();


require_once plugin_dir_path(__FILE__) . 'GetWinddata.php';
require_once plugin_dir_path(__FILE__) . 'GetWindoptions.php';
$winddata = new GetWinddata();
$windoptions = new GetWindoptions();


$min = $winddata->min;
$max = $winddata->max;
$delta = $max - $min;

$colorArray = array();

$currentType = $_GET['datatype'];
$currentHeight = $_GET['height'];

$currentPosition = $currentType . $currentHeight;



$windtype = $windoptions->options[$currentType]['runame'];
$unittype = $windoptions->options[$currentType]['ruunit'];

?>

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



 <?php foreach ($winddata->data as $row): 
 

  $lat = $row -> lat;
  $lon = $row -> lon;
  $id = $row -> id;
  $data = $row -> data;

$lat1 = $lat + 1;
$lon1 = $lon + 1;


if ($data < $min + $delta*0.1) {$color = "d1d4ee";} 
elseif ($data < $min + $delta*0.2) {$color = "b3b7dc";}
elseif ($data < $min + $delta*0.3) {$color = "979ece";}
elseif ($data < $min + $delta*0.4) {$color = "7f86bd";}
elseif ($data < $min + $delta*0.5) {$color = "636ba8";} 
elseif ($data < $min + $delta*0.6) {$color = "424b8d";} 
elseif ($data < $min + $delta*0.7) {$color = "2c367a";} 
elseif ($data < $min + $delta*0.8) {$color = "1c266d";} 
elseif ($data < $min + $delta*0.9) {$color = "0c1457";} 
else { $color = "040b4d"; };


$mrect = "myRectangle" . $id . " = new ymaps.Rectangle([ [ ";
$mrect .= $lat . ", " . $lon . "] , [" . $lat1 . ", " . $lon1 . "] ], ";
$mrect .= " { hintContent: ' " . $windtype . " <br> " . $data . " " . $unittype . " ";
$mrect .= " <br> <br> Широта: " . $lat . "&deg; <br> Долгота: " . $lon . "&deg; ' }, { fillColor: '#" . $color . "', fillOpacity: 0.8, strokeWidth: 0, });";
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
                foreach ($windoptions->options as $key => $value) { 
            ?>  <div class="sunoptions__surface-item">
                    <form class="sunoptions__form" method="GET">
                    <input 
                    type="hidden" 
                    name="datatype" 
                    id="<?php echo $key ?>" 
                    value="<?php echo $key ?>"
                    >
                    
                        <p class="sunoptions__desc"><?php echo $value['runame'] ?></p>                      
      

                    <select name="height" class="sunoptions__selector">
                    <option disabled="disabled" 
                    <?php 
                    if ($currentType != $key) { ?> selected="true" <?php } ?>
                    > -- выбрать -- </option>
                    <?php                                        
                    foreach ($value['height'] as $height) { 
                      ?>
                      <option value="<?php echo $height ?>" 
                      <?php
                      if (($currentType == $key) && ($currentHeight == $height)) { ?>
                          selected="true" 
                      <?php }
                      ?>
                      ><?php echo $height . ' ' . $value['ruoption']?></option>
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