<?php 
require_once plugin_dir_path(__FILE__) . 'GetGeodata.php';
require_once plugin_dir_path(__FILE__) . 'GetGeooptions.php';
$geodata = new GetGeodata();
$geooptions = new GetGeooptions();

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
                <?php if (!$_GET['type'] || $_GET['type'] == 'ALL') {
                    echo 'checked';
                } ?>
                >
                <label for="ALL">Все регионы</label>
            </div>
            <?php                                        
                foreach ($geooptions->types as $key => $value) { 
            ?>  <div class="object-types-form__type">
                    <input 
                    type="radio" 
                    name="type" 
                    id="<?php echo $key ?>" 
                    value="<?php echo $key ?>"
                    <?php if ($_GET['type'] === $key) {
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


<section>
    <div class="container">


 <?php foreach ($geodata->data as $row) {
 
  $name = $row -> name;

  $id = $row -> id;
  $lat = $row -> lat;
  $lon = $row -> lon;
  $oopt = $row -> power;
  $sovrIspolz = $row -> powerpr;
  $balneolog = $row -> river;
  $minerals = $row -> year;
  $location = $row -> location;
  $status = $row -> status;
  $function = $row -> function;
  $truthplace = $row -> truthplace;
  $pp = $row -> pp;
  $gen = $row -> gen;
  $holder = $row -> holder;
  $source = $row -> source;
  $link = $row -> link;
  $linkshort = $row -> linkshort;
  $picture = $row -> picture;
  $date = $row -> date;
  $check_obj = $row -> check_obj;
  $absolute = $row -> absolute; 
  $potresourse = $row -> potresourse; 
  $debit = $row -> debit;


  $objrequest = '<div class="gistables-tab"><input class="gistables-input" type="checkbox" id="chck' . $id .'">';

  $objrequest.= '<label class="tab-label" for="chck' . $id . '">' . $name;

  if ($location != null and $location != " ") {
    $objrequest.= ", " . $location;  };
  
  if ($holder != null and $holder != " ") {
        $objrequest.= ", геотермальная провинция: " . $holder; };    
  
  $objrequest.= '</label><div class="tab-content">'; 
                                                                         
  $objrequest.= "<b> Координаты </b>" . $lat . ", " . $lon . "<br>";

  if ($oopt != null and $oopt != " ") {
  $objrequest.= "<b> В состав какого ООПТ входит: : </b>" . $oopt . "<br>";  };

  if ($holder != null and $holder != " ") {
  $objrequest.= "<b>Геотермальная провинция: </b>" . $holder . "<br>"; };

  if ($absolute != null and $absolute != " ") {
  $objrequest.= "<b>Абсолютная отметка: </b>" . $absolute . "<br>"; };

  if ($date != null and $date != " ") {
  $objrequest.= "<b>Количество источников: </b>" . $date . " <br>" ; }; 

  if ($sovrIspolz != null and $sovrIspoolz != " ") {
  $objrequest.= "<b>Современное использование: </b>" . $sovrIspolz . "<br>";  };

  if ($check_obj != null and $check_obj != " ") {
  $objrequest.= "<b>Перспективная область эксплуатации:  </b>" . $check_obj . " <br>" ; }; 
  
  if ($link != null and $link != " ") {
  $objrequest.= "<b>Уровень подготовленности и использования: </b>" . $link . " <br>" ; }; 

  if ($balneolog != null and $balneolog != " ") {
  $objrequest.= "<b> Бальнеологическая характеристика вод: </b>" . $balneolog . "<br>";  };

  if ($minerals != null and $minerals != " ") {
  $objrequest.= "<b> Минерализация г/л: </b>" . $minerals . "<br>";  };

  if ($function != null and $function != " ") {
  $objrequest.= "<b>Классификация по минерализации: </b> " . $function . "<br>";  };

  if ($linkshort != null and $linkshort != " ") {
  $objrequest.= "<b>pH: </b>" . $linkshort . " <br>" ; }; 

  if ($source != null and $source != " ") {
  $objrequest.= "<b>Классификация по pH: </b> " . $source . "<br>" ; };
  
  if ($truthplace != null and $truthplace != " ") {
  $objrequest.= "<b>Максимальная температура: </b>" . $truthplace . "&deg;C<br>" ;  };

  if ($gen != null and $gen != " ") {
  $objrequest.= "<b>Классификация по температуре: </b>" . $gen . "<br>" ;  };

  if ($debit  != null and $debit  != " ") {
  $objrequest.= "<b>Суммарный дебит,  л/с или кг/с: </b>" . $debit  . " <br>" ; }; 

  if ($picture != null and $picture != " ") {
  $objrequest.= "<b>Температура на глубине:</b> " . $picture . "&deg;C <br>";  };

  if ($potresourse != null and $potresourse != " ") {
  $objrequest.= "<b>Потенциальные ресурсы термальных вод: </b>" . $potresourse . " <br>" ; }; 

  if ($pp != null and $pp != " ") {
    $objrequest.= $pp . " <br>" ; }; 


  $objrequest.= '</div></div>'; 

  echo $objrequest;

  }  ?>

    </div>
</section>


<?php get_footer(); ?>