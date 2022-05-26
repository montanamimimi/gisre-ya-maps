<?php 
require_once plugin_dir_path(__FILE__) . 'GetFotdata.php';
$fotdata = new GetFotdata();

$optionsArray = array('gor', 'ver', 'opt', 'lat', 'm15', 'p15');

get_header(); ?>


<script src="https://api-maps.yandex.ru/2.1/?lang=ru_RU&amp;apikey=b6a7a43d-4ce5-45d6-9b18-5eb8015dbbfa" type="text/javascript"></script>




<section class="single-banner">
  <div class="container">
    <div class="single-banner__content">
     <h1><?php the_title(); ?></h1>
    </div>
  </div>
</section>



<section>
    <div class="container fot-container">
        <div class="fot-map">
            <h2>Выберите точку на карте</h2>            
            <div id="map" class="yandex-map-fot"></div>
        </div>
        <div class="fot-desc">
            <p>Для отображения данных по производительности ФЭМ выберите коориднаты на карте или введите в форму ниже.
                <!-- Диапазон допустимых значений: 41.5 - 81.5 градусов широты, 20.5 - 173.3 градусов долготы.  -->
            </p>

            <div class="fot-form">
                <form method="GET">
                    <div class="fot-form-items">
                        <div class="fot-form__item">
                            <label for="lat"> Широта</label>
                            <input type="number" name="lat" id="lat" step="1" min="41.5" max="81.5" required
                            <?php if ($_GET['lat']) { echo ' value="' . $_GET['lat'] . '"'; } ?>
                            >
                        </div>
                        <div class="fot-form__item">
                            <label for="lon"> Долгота</label>
                            <input type="number" name="lon" id="lon" step="1" min="20.5" max="173.5" required
                            <?php if ($_GET['lon']) { echo ' value="' . $_GET['lon'] . '"'; } ?>
                            >
                        </div>

                    </div>
                    <div class="fot-form-items">
                        <label for="model">Модель коллектора</label>
                        <select name="model" id="model">
                            <option value="FU345"
                            <?php if ($_GET['model'] == "FU345") { echo 'selected="true"'; } ?>
                            >FuturaSunZebra 345 W</option>
                            <option value="Hevel395"
                            <?php if ($_GET['model'] == "Hevel395") { echo 'selected="true"'; } ?>
                            >Hevel 395</option>
                            <option value="JAM72S"
                            <?php if ($_GET['model'] == "JAM72S") { echo 'selected="true"'; } ?>
                            >JaSolarHalfCellPERC 72 cellsJAM72S30</option>
                        </select>
                    </div>
                    <div class="fot-form-items">
                        <label for="comment">Угол наклона</label>
                        <select name="comment" id="comment">
                            <option value="ALL"
                            <?php if (($_GET['comment'] == "ALL") || !$_GET['comment']) { echo 'selected="true"'; } ?>
                            >Все значения</option>
                            <option value="gor"
                            <?php if ($_GET['comment'] == "gor") { echo 'selected="true"'; } ?>
                            >Горизонтальный</option>
                            <option value="m15"
                            <?php if ($_GET['comment'] == "m15") { echo 'selected="true"'; } ?>
                            >Минус 15&deg; широты</option>
                            <option value="opt"
                            <?php if ($_GET['comment'] == "opt") { echo 'selected="true"'; } ?>
                            >Оптимальный</option>
                            <option value="lat"
                            <?php if ($_GET['comment'] == "lat") { echo 'selected="true"'; } ?>
                            >Равен широте</option>
                            <option value="p15"
                            <?php if ($_GET['comment'] == "p15") { echo 'selected="true"'; } ?>
                            >Плюс 15&deg; широты</option>
                            <option value="ver"
                            <?php if ($_GET['comment'] == "ver") { echo 'selected="true"'; } ?>
                            >Вертикальный</option>
                        </select>
                    </div>
                    <div class="fot-form-items">
                        <div class="fot-form__item">
                            <input type="submit" value="Показать">
                        </div>
                    </div>
                    
                </form>
            </div>

            <?php if ($_GET['lat'] && $_GET['lon'])  {  
                echo '<p>Показаны данные для: <br> Широта: ' . $_GET['lat'] . '&deg;, Долгота: ' . $_GET['lon'] . '&deg;</p>';

                if (!$fotdata->data) {
                    echo '<h3>Для этих координат нет данных. Выберите точку на территории России</h3>';
                }
            }         
            
            ?>
        </div>

    </div>
</section>

<script>

ymaps.ready(init);
var myMap;

function init () {
    myMap = new ymaps.Map("map", {
        center: [64.5, 97.5], 
        zoom: 3
    }, {
        balloonMaxWidth: 200,
        searchControlProvider: 'yandex#search'
    });

    const latForm = document.getElementById('lat');
    const lonForm = document.getElementById('lon');

    myMap.events.add('click', function (e) {

        var coords = e.get('coords');
        latForm.value = Math.round(coords[0]) + '.5';
        lonForm.value = Math.round(coords[1]) + '.5';
        latForm.classList.add('lat-selected');
        lonForm.classList.add('lat-selected');

        setTimeout(() => {
        latForm.classList.remove('lat-selected');
        lonForm.classList.remove('lat-selected');
        }, 800)

    });


    myMap.events.add('balloonopen', function (e) {
        myMap.hint.close();
    });
}
</script>


<section>
    <div class="container">
        <?php if ($fotdata->data) { ?>

            <h3>Данные по производительности ФЭМ:</h3>

            <?php if (($_GET['model'] == 'FU345') || !$_GET['model']) { ?>
            
                
                <h4>Солнечный фотоэлектрический модуль FuturaSunZebra 345 W</h4>
                <h5>Пиковая мощность модуля (кВтч/Вт)</h5>
                <?php 
                $fuData = $fotdata->getType($fotdata->data, 'FU345');

                if (in_array($_GET['comment'], $optionsArray)) {

                    $i = 0;

                    while ($i < 6) {
                        if ($fuData->param1[$i]->comment != $_GET['comment']) {
                            unset($fuData->param1[$i]);
                            unset($fuData->param2[$i]);
                        }

                        $i++;
                    }
                } 
                
                echo $fotdata->generateTable($fuData->param1); 
                
                               
                ?>

                <h5>Производительность на единицу площади (кВтч/м2) </h5>                                       
                <?php echo $fotdata->generateTable($fuData->param2); ?>

            <?php } ?>

            <?php if (($_GET['model'] == 'Hevel395') || !$_GET['model']) { ?>
            
                <h4>Солнечный фотоэлектрический модуль Hevel 395</h4>
                <h5>Пиковая мощность модуля (кВтч/Вт)</h5>                                        
                <?php

                $hevelData = $fotdata->getType($fotdata->data, 'Hevel395');
                echo $fotdata->generateTable($hevelData->param1); 

                ?> 
                <h5>Производительность на единицу площади (кВтч/м2) </h5>                                       
                <?php echo $fotdata->generateTable($hevelData->param2); ?> 
            <?php } ?>
    
            <?php if (($_GET['model'] == 'JAM72S') || !$_GET['model']) { ?>

                <h4>Солнечный фотоэлектрический модуль JaSolarHalfCellPERC 72 cellsJAM72S30  </h4>
                <h5>Пиковая мощность модуля (кВтч/Вт)</h5>                    
                
                <?php

                $jamData = $fotdata->getType($fotdata->data, 'JAM72S');
                echo $fotdata->generateTable($jamData->param1); 
                ?>
                <h5>Производительность на единицу площади (кВтч/м2) </h5> 
                <?php echo $fotdata->generateTable($jamData->param2); ?> 

            <?php } ?>
        <?php } ?>


        <div class="fot-description">
            <h3></h3>
        </div>
    </div>
</section>

<section class="single-text">
  <div class="container">

        
        <div class="single-text__content">
          <?php the_content();  ?> 
        </div>
  </div>
</section>

<?php get_footer(); ?>
