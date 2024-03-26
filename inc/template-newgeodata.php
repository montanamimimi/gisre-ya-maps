<?php

if (is_user_logged_in()) {

  $user = wp_get_current_user();

  $roles = (array) $user->roles;

  if (!($roles[0] == 'administrator')) {
    wp_redirect(home_url());
  }
} else {
  wp_redirect(home_url());
}

require_once plugin_dir_path(__FILE__) . 'GetGeodata.php';
require_once plugin_dir_path(__FILE__) . 'GetGeooptions.php';
$geodata = new GetGeodata();
$geooptions = new GetGeooptions();

get_header();
?>

<section class="single-banner">
  <div class="container">
    <div class="single-banner__content">
      <h1><?php the_title(); ?></h1>
    </div>
  </div>
</section>



<section class="objects">
  <div class="container" style="margin-top: 50px;">
    <div class="objects__table objects__new-object">

      <a class="button" href="<?php echo home_url() . '/editgeodata'; ?>">Вернуться к списку меторождений</a>
      <br><Br>

      <h2 class="objects__add-header">Добавить месторождение: </h2>
      <form action="<?php echo esc_url(admin_url('admin-post.php')) ?>" class="objects__form" method="POST" enctype="multipart/form-data">
        <input type="hidden" name="action" value="creategeodata">

        <div class="objects__item">
          <label for="orgname">Название месторождения</label>
          <input type="text" name="orgname" placeholder="Название..." required>
        </div>

        <div class="objects__group">
          <div class="objects__item">
            <label for="lat">Широта</label>
            <input type="number" placeholder="lat" name="lat" step="0.000001" min="0" required>
          </div>
          <div class="objects__item">
            <label for="lon">Долгота</label>
            <input type="number" placeholder="lon" name="lon" step="0.000001" min="0" required>
          </div>
        </div>

        <div class="objects__item">
          <label for="location">Район</label>
          <input type="text" name="location" placeholder="Административный округ..." required>
        </div>

        <div class="objects__item">
          <label for="power">В состав какого ООПТ входит</label>
          <input type="text" name="power">
        </div>


        <div class="objects__item">
          <label for="link">Уровень подготовленности и использования</label>
          <input type="text" name="link">
        </div>

        <div class="objects__group">
          <div class="objects__item">
            <label for="absolute">Абсолютная отметка</label>
            <input type="text" name="absolute">
          </div>
          <div class="objects__item">
            <label for="check_obj">Перспективная область эксплуатации</label>
            <input type="text" name="check_obj">
          </div>

        </div>

        <div class="objects__group">
          <div class="objects__item">
            <label for="river">Бальнеологическая характеристика вод</label>
            <input type="text" name="river">
          </div>
          <div class="objects__item">
            <label for="year">Минерализация г/л</label>
            <input type="text" name="year">
          </div>
        </div>

        <div class="objects__group">
          <div class="objects__item">
            <label for="function">Классификация по минерализации</label>
            <input type="text" name="function">
          </div>
          <div class="objects__item">
            <label for="truthplace">Максимальная температура</label>
            <input type="text" name="truthplace" placeholder="формат: 48,5">
          </div>
        </div>

        <div class="objects__group">
          <div class="objects__item">
            <label for="linkshort">pH</label>
            <input type="text" name="linkshort">
          </div>
          <div class="objects__item">
            <label for="source">Классификация по pH</label>
            <input type="text" name="source">
          </div>
        </div>



        <div class="objects__item">
          <button class="button" type="submit">Добавить</button>
        </div>




      </form>




    </div>
  </div>

  <div style="height: 100px;"></div>
</section>


<?php
get_footer();
?>