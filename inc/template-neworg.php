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

require_once plugin_dir_path(__FILE__) . 'GetOrgdata.php';
require_once plugin_dir_path(__FILE__) . 'GetRegions.php';
$orgdata = new GetOrgdata();
$regions = new GetRegions();
$ruRegions = $regions->ruRegions;

//var_dump($ruRegions);

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

      <a class="button" href="<?php echo home_url() . '/organizations'; ?>">Вернуться к списку организаций</a>
      <br><Br>

      <h2 class="objects__add-header">Добавить организацию: </h2>
      <form action="<?php echo esc_url(admin_url('admin-post.php')) ?>" class="objects__form" method="POST" enctype="multipart/form-data">
        <input type="hidden" name="action" value="createorg">

        <div class="objects__item">
          <label for="orgname">Название организации</label>
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
          <label for="region">Регион</label>
          <select name="region">
            <?php
            foreach ($ruRegions as $key => $value) {
            ?>
              <option value="<?php echo $key ?>"><?php echo $value ?></option>
            <?php }

            ?>
          </select>
        </div>




        <div class="objects__item">
          <label for="adress">Адрес</label>
          <input type="text" name="adress" cols="60" rows="2" placeholder="Адрес...">
        </div>
        <div class="objects__group">
          <div class="objects__item">
            <label for="country">Страна</label>
            <input type="text" name="country" placeholder="Страна...">
          </div>
          <div class="objects__item">
            <label for="city">Город</label>
            <input type="text" name="city" placeholder="Город...">
          </div>

        </div>

        <div class="objects__group">
          <div class="objects__item">
            <label for="type_number">Тип</label>
            <select name="type_number">
              <option value="SCIENSE">Научная</option>
              <option value="SALES">Коммерческая</option>
            </select>
          </div>
          <div class="objects__item">
            <label for="type">Направление</label>
            <input type="text" name="type" cols="60" rows="2" placeholder="Нир, ниокр...">
          </div>
        </div>

        <div class="objects__group">
          <div class="objects__item">
            <label for="phone">Телефон</label>
            <input type="text" name="phone" placeholder="Телефон...">
          </div>
          <div class="objects__item">
            <label for="email">Email</label>
            <input type="email" name="email" placeholder="Email...">
          </div>
        </div>

        <div class="objects__group">
          <div class="objects__item">
            <label for="link">Сайт</label>
            <input type="link" name="link" placeholder="https://gisre.ru/...">
          </div>
        </div>
        <div class="objects__checkbox">
          <input name="sune" type="checkbox" value="1">
          <label for="sune">Солнечная электроэнергетика</label>
        </div>
        <div class="objects__checkbox">
          <input name="sunt" type="checkbox" value="1">
          <label for="sunt">Солнечная теплоэнергетика </label>
        </div>
        <div class="objects__checkbox">
          <input name="wind" type="checkbox" value="1">
          <label for="wind">Ветроэнергетика</label>
        </div>
        <div class="objects__checkbox">
          <input name="bio" type="checkbox" value="1">
          <label for="bio">Биоэнергетика</label>
        </div>
        <div class="objects__checkbox">
          <input name="gidro" type="checkbox" value="1">
          <label for="gidro">Гидроэнергетика</label>
        </div>
        <div class="objects__checkbox">
          <input name="geo" type="checkbox" value="1">
          <label for="geo">Геотермальная энергетика</label>
        </div>
        <div class="objects__checkbox">
          <input name="pri" type="checkbox" value="1">
          <label for="pri">Приливная энергетика</label>
        </div>
        <div class="objects__checkbox">
          <input name="tn" type="checkbox" value="1">
          <label for="tn">Тепловые насосы</label>
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