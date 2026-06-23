<?php get_header(); ?>
<?php
require_once plugin_dir_path(__FILE__) . 'GetSundataNew.php';
require_once plugin_dir_path(__FILE__) . 'GetSunoptionsNew.php';
$sundata = new GetSundataNew();
$sunOptions = new GetSunoptionsNew();

$min = $sundata->minmax['min'];
$max = $sundata->minmax['max'];
$delta = $max - $min;

if (isset($_GET['datatype'])) {
  $currentType = $_GET['datatype'];
} else {
  $currentType = '1';
}

if (isset($_GET['period'])) {
  $currentPeriod = $_GET['period'];
} else {
  $currentPeriod = 'prod13';
}

$suntype = $sunOptions->options[$currentType]['runame'];

$suncolors = array(
  strval(round(($min + $delta*0.032), 2)) => 'fffbbf',
  strval(round(($min + $delta*0.064), 2)) => 'fff785',
  strval(round(($min + $delta*0.096), 2)) => 'fff34d',
  strval(round(($min + $delta*0.128), 2)) => 'ffed00',
  strval(round(($min + $delta*0.160), 2)) => 'ffdc00',
  strval(round(($min + $delta*0.192), 2)) => 'fecc00',
  strval(round(($min + $delta*0.224), 2)) => 'fbba00',
  strval(round(($min + $delta*0.256), 2)) => 'f7a600',
  strval(round(($min + $delta*0.288), 2)) => 'f39100',
  strval(round(($min + $delta*0.32), 2)) => 'f07b00',
  strval(round(($min + $delta*0.353), 2)) => 'ec6500',
  strval(round(($min + $delta*0.385), 2)) => 'e84c03',
  strval(round(($min + $delta*0.417), 2)) => 'e52e0a',
  strval(round(($min + $delta*0.449), 2)) => 'e00202',
  strval(round(($min + $delta*0.481), 2)) => 'd00303',
  'Более' => 'c00000'
);

?>
<script>
<?php echo 'const points = ' . wp_json_encode($sundata->convertedData) . ';'; ?>
<?php echo 'const max = ' . wp_json_encode($max) . ';'; ?>
<?php echo 'const min = ' . wp_json_encode($min) . ';'; ?>
<?php echo 'const label = ' . wp_json_encode('Солнечная радиация') . ';';  ?>
<?php echo 'const unit = ' . wp_json_encode('кВтч/м² в сутки') . ';'; ?>

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
        const step = 1;

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
                    ctx.globalAlpha = 0.9; 
                    ctx.fillStyle = cell.color;
                    ctx.fillRect(x, y, 4, 4);
                }
            }
        }

        return canvas.toDataURL();
    });

    map.layers.add(layer);

    map.events.add('click', function (e) {
        const geo = e.get('coords');
        const step = 1;

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
          <select id="datatype" name="datatype" class="windoptions__selector" style="font-size:14px;" required>
              <?php 
              foreach ($sunOptions->options as $key => $sunOption) { ?>
                 <option value="<?php echo $key; ?>" <?php echo $currentType == $key ? "selected" : "";  ?>><?php echo $sunOption['runame']; ?></option> 
              <?php } ?>      
          </select> 
        </div>
        <div class="windoptions__form-item">
          <select id="period" name="period" class="windoptions__selector" required>
            <option value="prod13" <?php echo $currentPeriod == 'prod13' ? "selected" : "";  ?>> Год </option>  
            <option value="prod1" <?php echo $currentPeriod == 'prod1' ? "selected" : "";  ?>>Январь</option>
            <option value="prod2" <?php echo $currentPeriod == 'prod2' ? "selected" : "";  ?>>Февраль</option>
            <option value="prod3" <?php echo $currentPeriod == 'prod3' ? "selected" : "";  ?>>Март</option>
            <option value="prod4" <?php echo $currentPeriod == 'prod4' ? "selected" : "";  ?>>Апрель</option>
            <option value="prod5" <?php echo $currentPeriod == 'prod5' ? "selected" : "";  ?>>Май</option>
            <option value="prod6" <?php echo $currentPeriod == 'prod6' ? "selected" : "";  ?>>Июнь</option>
            <option value="prod7" <?php echo $currentPeriod == 'prod7' ? "selected" : "";  ?>>Июль</option>
            <option value="prod8" <?php echo $currentPeriod == 'prod8' ? "selected" : "";  ?>>Август</option>
            <option value="prod9" <?php echo $currentPeriod == 'prod9' ? "selected" : "";  ?>>Сентябрь</option>
            <option value="prod10" <?php echo $currentPeriod == 'prod10' ? "selected" : "";  ?>>Октябрь</option>
            <option value="prod11" <?php echo $currentPeriod == 'prod11' ? "selected" : "";  ?>>Ноябрь</option>
            <option value="prod12" <?php echo $currentPeriod == 'prod12' ? "selected" : "";  ?>>Декабрь</option>
          </select> 
        </div>
        <div class="windoptions__form-item">
          <button type="submit" class="windoptions__button"> Показать</button>
        </div>
        
      </form>
      <div class="suncolors__legend">
        <p>Значение в единицах: кВтч/м² в сутки</p>
        <div class="suncolors__items">
          
          <?php 

            foreach ($suncolors as $key => $value) { ?>
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

<?php get_footer(); ?>