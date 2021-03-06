<?php get_header();


require_once plugin_dir_path(__FILE__) . 'GetWinddata.php';
require_once plugin_dir_path(__FILE__) . 'GetWindoptions.php';
$winddata = new GetWinddata();
$windoptions = new GetWindoptions();


$min = $winddata->min;
$max = $winddata->max;
$delta = $max - $min;

//$colorArray = array();

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


$windcolors = array(
  strval(ceil($min + $delta*0.1)) => 'd1d4ee',
  strval(ceil($min + $delta*0.2)) => 'b3b7dc',
  strval(ceil($min + $delta*0.3)) => '979ece',
  strval(ceil($min + $delta*0.4)) => '7f86bd',
  strval(ceil($min + $delta*0.5)) => '636ba8',
  strval(ceil($min + $delta*0.6)) => '424b8d',
  strval(ceil($min + $delta*0.7)) => '2c367a',
  strval(ceil($min + $delta*0.8)) => '1c266d',
  strval(ceil($min + $delta*0.9)) => '0c1457',
  '??????????' => '040b4d'
);


$mrect = "myRectangle" . $id . " = new ymaps.Rectangle([ [ ";
$mrect .= $lat . ", " . $lon . "] , [" . $lat1 . ", " . $lon1 . "] ], ";
$mrect .= " { hintContent: ' " . $windtype . " <br> " . $data . " " . $unittype . " ";
$mrect .= " <br> <br> ????????????: " . $lat . "&deg; <br> ??????????????: " . $lon . "&deg; ' }, { fillColor: '#" . $color . "', fillOpacity: 0.8, strokeWidth: 0, });";
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

<section >
  <div class="container">
      <div class="plugin-text">
        

          <?php the_content(); ?>
          

      </div>
  </div>
</section>

<section class="windres-option">
  <div class="container">

    <form class="windoptions__form" method="GET">    
      
      
      <div class="windoptions__form-item">

        <select id="datatype" name="datatype" class="windoptions__selector" required>
            <option value=""> -- ?????? ???????????? -- </option>
            <?php 
            foreach ($windoptions->options as $key => $value) { ?>
              <option value="<?php echo $key ?>" 
              <?php if ($key == $_GET['datatype']) { echo 'selected';} ?>
              ><?php echo $value['runame']; ?></option>
            <?php }
            ?>              
        </select> 
      </div>
      <div class="windoptions__form-item">
        <select id="height" name="height" class="windoptions__selector" required>
          <option value=""> -- ???????????????? -- </option>
          <?php 
            $currentDatatype = $_GET['datatype'];
            $currentHeight = $windoptions->options[$currentDatatype]['height'];        
            
            foreach ($currentHeight as $item) { ?>
              <option class="height-option" value="<?php echo $item; ?>"
              <?php if ($item == $_GET['height']) { echo 'selected';} ?>
              ><?php echo $item . ' ' . $windoptions->options[$currentDatatype]['ruoption']; ?></option>
            <?php }
          ?>                        
        </select> 
      </div>
      <div class="windoptions__form-item">
        <button type="submit" class="windoptions__button"> ????????????????</button>
      </div>
      
    </form>
  </div>
</section>
  
<section>
  <div class="container">
      <div class="suncolors__legend">
        <p>???????????????? ?? ????????????????: <?php echo  $unittype ?></p>
        <div class="suncolors__items">
          
          <?php 
            foreach ($windcolors as $key => $value) { ?>
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
              
            <?php echo strval(ceil($min)) . ' ' . $unittype ?>
          </div>
          <div class="to">
          <?php echo strval(ceil($max)) . ' ' . $unittype ?>
            </div>
        </div>
        <div class="windcolors__legend-mob-colors">

        </div>
      </div>
  </div>
</section>


<div id="YMapsID"  class="yandex-map"></div>


<?php get_footer(); ?>