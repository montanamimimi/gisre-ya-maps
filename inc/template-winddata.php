<?php get_header(); ?>

<?php 

require_once plugin_dir_path(__FILE__) . 'GetWinddata.php';
require_once plugin_dir_path(__FILE__) . 'GetWindoptions.php';

$winddata = new GetWinddata();
$windoptions = new GetWindoptions();
$min = 0;
$max = 0;

if (isset($winddata->minmax[0])) {
  $min = $winddata->minmax[0]->min;
  $max = $winddata->minmax[0]->max;
}
$delta = $max - $min;

if (isset($_GET['datatype'])) {
  $currentType = $_GET['datatype'];
} else {
  $currentType = '1';
}

if (isset($_GET['period'])) {
  $currentPeriod = $_GET['period'];
} else {
  $$currentPeriod = 'mean_year';
}

$windtype = $windoptions->options[$currentType]['runame'];
$unittype = $windoptions->options[$currentType]['ruunit'];
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
  'Более' => '040b4d'
);

?>

<script>
<?php echo 'const points = ' . wp_json_encode($winddata->convertedData) . ';'; ?>
<?php echo 'const max = ' . wp_json_encode($max) . ';'; ?>
<?php echo 'const min = ' . wp_json_encode($min) . ';'; ?>
<?php if (($currentType == 1) || ($currentType == 2) ) {

  echo 'const label = ' . wp_json_encode('Скорость ветра') . ';'; 
  echo 'const unit = ' . wp_json_encode('м/с') . ';'; 

} else if ($currentType == 3) {
  echo 'const label = ' . wp_json_encode('Плотность потока') . ';'; 
  echo 'const unit = ' . wp_json_encode('Вт/м2') . ';'; 
} 

?>
</script>

<script src="https://api-maps.yandex.ru/2.1/?apikey=c7787d5f-f9be-45c4-986a-6fa101bd672d&lang=ru_RU" type="text/javascript"></script>

<script type="text/javascript">
ymaps.ready(init);
const grid = {};

function init() {
    const map = new ymaps.Map('map', {
        center: [55.75, 37.61],
        zoom: 2
    });

    const layer = new ymaps.Layer(function (tile, zoom) {
        const canvas = document.createElement('canvas');
        canvas.width = 256;
        canvas.height = 256;

        const ctx = canvas.getContext('2d');

        const tileX = tile[0];
        const tileY = tile[1];
        const step = 0.25;

        function normalizeLon(lon) {
            return ((lon + 180) % 360 + 360) % 360 - 180;
        }

        points.forEach(p => {
            const lat = Math.floor(p.coords[0] / step) * step;
            const lon = Math.floor(normalizeLon(p.coords[1]) / step) * step;

            const key = `${lat.toFixed(2)}_${lon.toFixed(2)}`;

            grid[key] = {
                value: p.value,
                color: p.color
            };
        });

        for (let x = 0; x < 256; x += 4) {
            for (let y = 0; y < 256; y += 4) {

                const gx = tileX * 256 + x;
                const gy = tileY * 256 + y;

                const geo = ymaps.projection.wgs84Mercator
                    .fromGlobalPixels([gx, gy], zoom);                


                const lat = Math.floor(geo[0] / step) * step;
                const lonRaw = geo[1];
                const lonNorm = normalizeLon(lonRaw);
                const lon = Math.floor(lonNorm / step) * step;

                const key = `${lat.toFixed(2)}_${lon.toFixed(2)}`;

                const cell = grid[key];

                if (cell) {
                    ctx.globalAlpha = 0.9; // или убери, если цвет уже с альфой
                    ctx.fillStyle = cell.color;
                    ctx.fillRect(x, y, 4, 4);
                }
            }
        }

        return canvas.toDataURL();
    });

    map.layers.add(layer); // 👈 вместо MapType

    map.events.add('click', function (e) {
        const geo = e.get('coords');
        const step = 0.25;

        function normalizeLon(lon) {
            return ((lon + 180) % 360 + 360) % 360 - 180;
        }

        const lat = Math.floor(geo[0] / step) * step;
        const lon = Math.floor(normalizeLon(geo[1]) / step) * step;

        const key = `${lat.toFixed(2)}_${lon.toFixed(2)}`;
        const cell = grid[key];

        if (cell) {
            map.balloon.open(geo, {
                contentBody: label + '<br>Широта: ' + lat + '<br>Долгота: ' + lon + '<br>Значение: ' + cell.value + ' ' + unit
            });
        }
    });
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
      <div class="windswitcher">
        <?php 
        
          if (get_locale() == 'ru_RU') { 
            $link = get_permalink( get_page_by_path( 'winddata-lull' ) );
          } else { 
            $link = get_permalink( get_page_by_path( 'winddata-lull-en' ) );
          }
        
        ?>
        <div class="windswitcher__items">
          <div class="windswitcher__item windswitcher__item--active">            
              <?php echo __('Скорость ветра и плотность потока', 'gisre-plugin'); ?>                     
          </div>
          <a href="<?php echo $link . '?datatype=lull&height=30'; ?>" class="windswitcher__item ">            
             <?php echo __('Повторяемость и энергетические затишья', 'gisre-plugin'); ?>                       
          </a>
        </div>
      </div>
      <div >            
          <?php the_content(); ?>        
      </div>
  </div>
</section>

<section class="res-container">
  <div class="container">
    <div class="legend">
      <form class="windoptions__form" method="GET">    
        
        
        <div class="windoptions__form-item">

          <select id="datatype" name="datatype" class="windoptions__selector" required>
              <option value="1" <?php echo $currentType == '1' ? "selected" : "";  ?>>Скорость ветра на 10м</option>  
              <option value="2" <?php echo $currentType == '2' ? "selected" : "";  ?>>Скорость ветра на 100м</option>
              <option value="3" <?php echo $currentType == '3' ? "selected" : "";  ?>>Плотность потока энергии ветра на 100м</option>         
          </select> 
        </div>
        <div class="windoptions__form-item">
          <select id="period" name="period" class="windoptions__selector" required>
            <option value="mean_year" <?php echo $currentPeriod == 'mean_year' ? "selected" : "";  ?>> Год </option>  
            <option value="mean_month1" <?php echo $currentPeriod == 'mean_month1' ? "selected" : "";  ?>>Январь</option>
            <option value="mean_month2" <?php echo $currentPeriod == 'mean_month2' ? "selected" : "";  ?>>Февраль</option>
            <option value="mean_month3" <?php echo $currentPeriod == 'mean_month3' ? "selected" : "";  ?>>Март</option>
            <option value="mean_month4" <?php echo $currentPeriod == 'mean_month4' ? "selected" : "";  ?>>Апрель</option>
            <option value="mean_month5" <?php echo $currentPeriod == 'mean_month5' ? "selected" : "";  ?>>Май</option>
            <option value="mean_month6" <?php echo $currentPeriod == 'mean_month6' ? "selected" : "";  ?>>Июнь</option>
            <option value="mean_month7" <?php echo $currentPeriod == 'mean_month7' ? "selected" : "";  ?>>Июль</option>
            <option value="mean_month8" <?php echo $currentPeriod == 'mean_month8' ? "selected" : "";  ?>>Август</option>
            <option value="mean_month9" <?php echo $currentPeriod == 'mean_month9' ? "selected" : "";  ?>>Сентябрь</option>
            <option value="mean_month10" <?php echo $currentPeriod == 'mean_month10' ? "selected" : "";  ?>>Октябрь</option>
            <option value="mean_month11" <?php echo $currentPeriod == 'mean_month11' ? "selected" : "";  ?>>Ноябрь</option>
            <option value="mean_month12" <?php echo $currentPeriod == 'mean_month12' ? "selected" : "";  ?>>Декабрь</option>
          </select> 
        </div>
        <div class="windoptions__form-item">
          <button type="submit" class="windoptions__button"> Показать</button>
        </div>
        
      </form>
      <div class="suncolors__legend">
        <p>Значение в единицах: <?php echo  $unittype ?></p>
        <div class="suncolors__items">
          
          <?php 
            foreach ($windcolors as $key => $value) { ?>
              <div class="suncolors__item">
                <div class="suncolors__color" style="opacity:0.9;background-color: #<?php echo $value ?>;">

                </div>
                <div class="suncolors__desc">
                  <small><?php echo $key ?></small>
                </div>
              </div>
            <?php }
          
          ?>
        </div>
      </div>
    </div>

    <div class="map">
      <div id="map" class="yandex-map"></div>
    </div>
  </div>
</section>

<?php get_footer();