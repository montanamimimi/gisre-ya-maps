<?php 
require_once plugin_dir_path(__FILE__) . 'GetGeodata.php';
require_once plugin_dir_path(__FILE__) . 'GetGeooptions.php';
$geodata = new GetGeodata();
$geooptions = new GetGeooptions();

$searchType = false;

if (isset($_GET['type'])) {
  $searchType = $_GET['type'];
}

get_header(); ?>

<section class="single-banner">
  <div class="container">
    <div class="single-banner__content">
     <h1><?php the_title(); ?></h1>
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

<section>
    <div class="container">
        <div class="geodata__options">

            <form class="object-types-form" method="GET">
            <div class="object-types-form__type">
                <input type="radio" name="type" value="ALL" id="ALL"
                <?php if (!$searchType || $searchType == 'ALL') {
                    echo 'checked';
                } ?>
                >
                <label for="ALL"><?php echo __('Все регионы', 'gisre-plugin') ?></label>
            </div>
            <?php                                        
                foreach ($geooptions->types as $key => $value) { 
            ?>  <div class="object-types-form__type">
                    <input 
                    type="radio" 
                    name="type" 
                    id="<?php echo $key ?>" 
                    value="<?php echo $key ?>"
                    <?php if ($searchType === $key) {
                    echo 'checked';
                    } ?>
                    >
                    <label for="<?php echo $key ?>"><?php echo $value;  ?></label>
                </div>                  

            <?php } ?>   
            <button type="submit" class="object-types-form__button"><?php echo __('Применить фильтр', 'gisre-plugin') ?></button>
        </form>

        </div>
    </div>
</section>


<section>
    <div class="container">


 <?php foreach ($geodata->data as $row) {
 
  $name = $row -> name;
  $id = $row -> id;
  $lat = $row -> lat;
  $lon = $row -> lon;
  $oopt = $row ->oopt;
  $location = $row -> location;
  $truthplace = $row -> truthplace;
  $sovrIspolz = $row -> powerpr;
  $balneolog = $row -> balneol;
  $minerals = $row -> year;
  $function = $row -> minclass;
  $pp = $row -> dop;
  $gen = $row -> tclass;
  $holder = $row ->province;
  $source = $row -> ph;
  $link = $row -> ready;
  $linkshort = $row -> linkshort;
  $picture = $row -> temperaturedep;
  $date = $row -> wellsnumber;
  $check_obj = $row -> perspective;
  $absolute = $row -> absolute; 
  $potresourse = $row -> potresourse; 
  $debit = $row->debit;

  $objrequest = '<div class="gistables-tab"><input class="gistables-input" type="checkbox" id="chck' . $id .'">';

  $objrequest.= '<label class="tab-label" for="chck' . $id . '">' . $name;

  if ($location != null and $location != " ") {
    $objrequest.= ", " . $location;  };
  
  if ($holder != null and $holder != " ") {
        $objrequest.= ", " . __('геотермальная провинция', 'gisre-plugin') .": " . $holder; };    
  
  $objrequest.= '</label><div class="tab-content">'; 
                                                                         
  $objrequest.= "<b>" . __('Координаты', 'gisre-plugin') . "</b>: " . $lat . ", " . $lon . "<br>";

  if ($oopt != null and $oopt != " ") {
  $objrequest.= "<b>" . __('В состав какого ООПТ входит', 'gisre-plugin') .":</b> " . $oopt . "<br>";  };

  if ($holder != null and $holder != " ") {
  $objrequest.= "<b>" . __('Геотермальная провинция', 'gisre-plugin') .":</b> " . $holder . "<br>"; };

  if ($absolute != null and $absolute != " ") {
  $objrequest.= "<b>". __('Абсолютная отметка', 'gisre-plugin') . ":</b> " . $absolute . "<br>"; };

  if ($date != null and $date != " ") {
  $objrequest.= "<b>" . __('Количество источников', 'gisre-plugin') .":</b> " . $date . " <br>" ; }; 

  if ($sovrIspolz != null and $sovrIspolz != " ") {
  $objrequest.= "<b>" . __('Современное использование', 'gisre-plugin') . ":</b> " . $sovrIspolz . "<br>";  };

  if ($check_obj != null and $check_obj != " ") {
  $objrequest.= "<b>" . __('Перспективная область эксплуатации', 'gisre-plugin') . ":</b> " . $check_obj . " <br>" ; }; 
  
  if ($link != null and $link != " ") {
  $objrequest.= "<b>" . __('Уровень подготовленности и использования', 'gisre-plugin') . ":</b> " . $link . " <br>" ; }; 

  if ($balneolog != null and $balneolog != " ") {
  $objrequest.= "<b>" . __('Бальнеологическая характеристика вод', 'gisre-plugin') . ":</b> " . $balneolog . "<br>";  };

  if ($minerals != null and $minerals != " ") {
  $objrequest.= "<b>" . __('Минерализация г/л', 'gisre-plugin') . ":</b> " . $minerals . "<br>";  };

  if ($function != null and $function != " ") {
  $objrequest.= "<b>" . __('Классификация по минерализации', 'gisre-plugin') . ":</b> " . $function . "<br>";  };

  if ($linkshort != null and $linkshort != " ") {
  $objrequest.= "<b>pH: </b>" . $linkshort . " <br>" ; }; 

  if ($source != null and $source != " ") {
  $objrequest.= "<b>" . __('Классификация по pH', 'gisre-plugin') . ":</b> " . $source . "<br>" ; };
  
  if ($truthplace != null and $truthplace != " ") {
  $objrequest.= "<b>" . __('Максимальная температура', 'gisre-plugin') . ":</b> " . $truthplace . "&deg;C<br>" ;  };

  if ($gen != null and $gen != " ") {
  $objrequest.= "<b>" . __('Классификация по температуре', 'gisre-plugin') . ":</b> " . $gen . "<br>" ;  };

  if ($debit  != null and $debit  != " ") {
  $objrequest.= "<b>" . __('Суммарный дебит, л/с или кг/с', 'gisre-plugin') . ":</b> " . $debit  . " <br>" ; }; 

  if ($picture != null and $picture != " ") {
  $objrequest.= "<b>" . __('Температура на глубине', 'gisre-plugin') . ":</b> " . $picture . "&deg;C <br>";  };

  if ($potresourse != null and $potresourse != " ") {
  $objrequest.= "<b>" . __('Потенциальные ресурсы термальных вод', 'gisre-plugin') . ":</b> " . $potresourse . " <br>" ; }; 

  if ($pp != null and $pp != " ") {
    $objrequest.= $pp . " <br>" ; }; 


  $objrequest.= '</div></div>'; 

  echo $objrequest;

  }  ?>

    </div>
</section>


<?php get_footer(); ?>