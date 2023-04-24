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

get_header();


if ($_GET['id']) {

  $orgData = gisre_get_one_org($_GET['id']);

  $orgData->name = str_replace('"','&quot;',$orgData->name);

  if (!$orgData) {
    echo 'ОШИБКА! Неверный id организации';
  }

} else {
  echo 'ОШИБКА! Неверный id организации';
}
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

      <h2 class="objects__add-header">Редактировать организацию: </h2>
      <form action="<?php echo esc_url(admin_url('admin-post.php')) ?>" class="objects__form" method="POST" enctype="multipart/form-data">
        <input type="hidden" name="action" value="createorg">
        <input type="hidden" name="org_id" value="<?php echo $orgData->id; ?>">

        <div class="objects__item">
          <label for="orgname">Название организации</label>
          <input type="text" name="orgname" value="<?php echo $orgData->name; ?>" required>
        </div>

        <div class="objects__group">
          <div class="objects__item">
            <label for="lat">Широта</label>
            <input type="number" placeholder="lat" name="lat" value="<?php echo $orgData->lat; ?>" step="0.000001" min="0" required>
          </div>
          <div class="objects__item">
            <label for="lon">Долгота</label>
            <input type="number" placeholder="lon" name="lon" value="<?php echo $orgData->lon; ?>" step="0.000001" min="0" required>
          </div>
        </div>

        <div class="objects__item">
          <label for="region">Регион</label>
          <select name="region">
            <?php
            foreach ($ruRegions as $key => $value) {
            
              echo '<option value="' . $key .'"'; 

              if ($key == $orgData->region) {
                echo ' selected';
              }
              echo '>' . $value .'</option>';
            }

            ?>
          </select>
        </div>




        <div class="objects__item">
          <label for="adress">Адрес</label>
          <input type="text" name="adress" cols="60" rows="2" value="<?php echo $orgData->adress; ?>">
        </div>
        <div class="objects__group">
          <div class="objects__item">
            <label for="country">Страна</label>
            <input type="text" name="country" value="<?php echo $orgData->country; ?>">
          </div>
          <div class="objects__item">
            <label for="city">Город</label>
            <input type="text" name="city" value="<?php echo $orgData->city; ?>">
          </div>

        </div>

        <div class="objects__group">
          <div class="objects__item">
            <label for="type_number">Тип</label>
            <select name="type_number">
              <option value="SCIENSE" <?php 
                            if ("SCIENSE" == $orgData->type_number) {
                              echo ' selected';
                            }
              
              ?>>Научная</option>
              <option value="SALES" <?php 
                            if ("SALES" == $orgData->type_number) {
                              echo ' selected';
                            }
              
              ?>>Коммерческая</option>
            </select>
          </div>
          <div class="objects__item">
            <label for="type">Направление</label>
            <input type="text" name="type" cols="60" rows="2" value="<?php echo $orgData->type; ?>">
          </div>
        </div>

        <div class="objects__group">
          <div class="objects__item">
            <label for="phone">Телефон</label>
            <input type="text" name="phone" value="<?php echo $orgData->phone; ?>">
          </div>
          <div class="objects__item">
            <label for="email">Email</label>
            <input type="email" name="email" value="<?php echo $orgData->email; ?>">
          </div>
        </div>

        <div class="objects__group">
          <div class="objects__item">
            <label for="link">Сайт</label>
            <input type="link" name="link" value="<?php echo $orgData->link; ?>">
          </div>
        </div>
        <div class="objects__checkbox">
          <input name="sune" type="checkbox" value="1" <?php echo $orgData->sune ? ' checked ' : ''; ?>>
          <label for="sune">Солнечная электроэнергетика</label>
        </div>
        <div class="objects__checkbox">
          <input name="sunt" type="checkbox" value="1" <?php echo $orgData->sunt ? ' checked ' : ''; ?>>
          <label for="sunt">Солнечная теплоэнергетика </label>
        </div>
        <div class="objects__checkbox">
          <input name="wind" type="checkbox" value="1" <?php echo $orgData->wind ? ' checked ' : ''; ?>>
          <label for="wind">Ветроэнергетика</label>
        </div>
        <div class="objects__checkbox">
          <input name="bio" type="checkbox" value="1" <?php echo $orgData->bio ? ' checked ' : ''; ?>>
          <label for="bio">Биоэнергетика</label>
        </div>
        <div class="objects__checkbox">
          <input name="gidro" type="checkbox" value="1" <?php echo $orgData->gidro ? ' checked ' : ''; ?>>
          <label for="gidro">Гидроэнергетика</label>
        </div>
        <div class="objects__checkbox">
          <input name="geo" type="checkbox" value="1" <?php echo $orgData->geo ? ' checked ' : ''; ?>>
          <label for="geo">Геотермальная энергетика</label>
        </div>
        <div class="objects__checkbox">
          <input name="pri" type="checkbox" value="1" <?php echo $orgData->pri ? ' checked ' : ''; ?>>
          <label for="pri">Приливная энергетика</label>
        </div>
        <div class="objects__checkbox">
          <input name="tn" type="checkbox" value="1" <?php echo $orgData->tn ? ' checked ' : ''; ?>>
          <label for="tn">Тепловые насосы</label>
        </div>



        <div class="objects__item">
          <button class="button" type="submit">Редактировать</button>
        </div>




      </form>




    </div>
  </div>

  <div style="height: 100px;"></div>
</section>


<?php
get_footer();
?>