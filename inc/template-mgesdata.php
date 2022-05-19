<?php 
require_once plugin_dir_path(__FILE__) . 'GetMgesdata.php';
$mgesdata = new GetMgesdata();


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


 <?php foreach ($mgesdata->data as $row) {
 
  $name = $row -> name;
  $id = $row -> id;
  $power = $row -> power;
  $poweryear = $row -> poweryear;
  $year = $row -> year;
  $type = $row -> type;
  $description = $row -> description;
  $pdf = $row -> pdf;



  $objrequest = '<div class="gistables-tab"><input class="gistables-input" type="checkbox" id="chck' . $id .'">';

  $objrequest.= '<label class="tab-label" for="chck' . $id . '">' . $name;
  
  $objrequest.= '</label><div class="tab-content">'; 
  $objrequest.= $description . "<br>";                                 
  $objrequest.= "<b> Установленная мощность: </b>" . $power . "<br>";
  $objrequest.= "<b> Среднегодовая выработка: </b>" . $poweryear . "<br>";
  $objrequest.= "<b> Год запуска: </b>" . $year . "<br>";
  $objrequest.= "<b> Тип оборудования: </b>" . $type . "<br>";

  $objrequest.= '<b> <a href="' . site_url() . '/wp-content/files/' . $pdf .'.pdf" target="_blank">Скачать Pdf</a> </b><br><br>';

  $objrequest.= '</div></div>'; 

  echo $objrequest;

  }  ?>

    </div>
</section>


<?php get_footer(); ?>