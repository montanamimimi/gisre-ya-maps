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

require_once plugin_dir_path(__FILE__) . 'GetGeooptions.php';
$options = new GetGeooptions();
get_header();

$editing = true;

if (isset($_GET['id'])) {

  $geoData = gisre_get_one_geo($_GET['id']);

  if (!$geoData) {
    $editing = false;
  } else {
    $geoData->name = str_replace('"','&quot;', $geoData->name);
  }

} else {
  $editing = false;
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

      <a class="button" href="<?php echo home_url() . '/editgeodata'; ?>">Вернуться к списку месторождений</a>
      <br><Br>

      <h2 class="objects__add-header"><?php echo $editing ? 'Редактировать' : 'Добавить'; ?> месторождение: </h2>
      <form action="<?php echo esc_url(admin_url('admin-post.php')) ?>" class="objects__form" method="POST" enctype="multipart/form-data">
        <input type="hidden" name="action" value="creategeodata">

        <?php echo $editing ? '<input type="hidden" name="org_id" value="' . $geoData->id . '">' : ''; ?>
        
        <div class="objects__item">
          <label for="orgname" style="text-align: center;">Перевод готов?</label>
          <input type="checkbox" name="translated" <?php 
          
          if ($editing) {
            echo $geoData->translated ? 'checked' : '';
          }
          
           ?>>
        </div>
        <div class="objects__item">
          <label for="orgname">Название месторождения - RU</label>
          <input type="text" name="orgname" value="<?php echo $editing ? $geoData->name : ''; ?>" required>
          Название месторождения - En<input type="text" name="name_en" value="<?php echo $editing ? $geoData->name_en : ''; ?>">
        </div>

        <div class="objects__group">
          <div class="objects__item">
            <label for="lat">Широта</label>
            <input type="number" placeholder="lat" name="lat" value="<?php echo $editing ? $geoData->lat : ''; ?>" 
              step="0.000001" min="0" required>
          </div>
          <div class="objects__item">
            <label for="lon">Долгота</label>
            <input type="number" placeholder="lon" name="lon" value="<?php echo $editing ? $geoData->lon : ''; ?>" 
            step="0.000001" min="0" required>
          </div>
        </div>

        <div class="objects__item">
          <label for="type">Регион</label>
          <select name="type">
            <?php            
            foreach ($options->types as $key => $value) {
            
              echo '<option value="' . $key .'"'; 

              if ($editing) {
                if ($key == $geoData->type) {
                  echo ' selected';
                }
              }

              echo '>' . $value .'</option>';
            }

            ?>
          </select>
        </div>




        <div class="objects__item">
          <label for="location">Район - Ru</label>
          <input type="text" name="location" cols="60" rows="2" value="<?php echo $editing ? $geoData->location : ''; ?>">
          Район - En<input type="text" name="location_en" cols="60" rows="2" value="<?php echo $editing ? $geoData->location_en : ''; ?>">
        </div>


        <div class="objects__group">
          <div class="objects__item">
            Геотермальная провинция - Ru 
            <input type="text" name="holder" value="<?php echo $editing ? $geoData->holder : ''; ?>">
            Геотермальная провинция - En<input type="text" name="province_en" value="<?php echo $editing ? $geoData->province_en : ''; ?>">
          </div>
          <div class="objects__item">
            Температура на глубине - Ru</label>
            <input type="text" name="picture" value="<?php echo $editing ? $geoData->picture : ''; ?>">
            Температура на глубине - En<input type="text" name="temperaturedep_en" value="<?php echo $editing ? $geoData->temperaturedep_en : ''; ?>">
          </div>
        </div>


        <div class="objects__item">
            <label for="power">В состав какого ООПТ входит - Ru</label>
            <input type="text" name="power" value="<?php echo $editing ? $geoData->power : ''; ?>">
            В состав какого ООПТ входит - En<input type="text" name="oopt_en" value="<?php echo $editing ? $geoData->oopt_en : ''; ?>">
          </div>
          <div class="objects__item">
            <label for="link">Уровень подготовленности и использования - Ru</label>
            <input type="text" name="link" value="<?php echo $editing ? $geoData->link : ''; ?>">
            Уровень подготовленности и использования - En<input type="text" 
            name="ready_en" value="<?php echo $editing ? $geoData->ready_en : ''; ?>">
          </div>

        <div class="objects__group">
          <div class="objects__item">
            <label for="absolute">Абсолютная отметка</label>
            <input type="text" name="absolute" value="<?php echo $editing ? $geoData->absolute : ''; ?>">
          </div>
          <div class="objects__item">
            <label for="truthplace">Максимальная температура</label>
            <input type="text" name="truthplace" placeholder="формат: 48,5" value="<?php echo $editing ? $geoData->truthplace : ''; ?>">
          </div>
        </div>

        <div class="objects__group">
          <div class="objects__item">
            <label for="linkshort">pH</label>
            <input type="text" name="linkshort" value="<?php echo $editing ? $geoData->linkshort : ''; ?>">
          </div>

          <div class="objects__item">
            <label for="year">Минерализация г/л</label>
            <input type="text" name="year" value="<?php echo $editing ? $geoData->year : ''; ?>">
          </div>
        </div>

        <div class="objects__group">
          <div class="objects__item">
            <label for="source">Классификация по pH - Ru</label>
            <input type="text" name="source" value="<?php echo $editing ? $geoData->source : ''; ?>">
            Классификация по pH - En<input type="text" name="ph_en" value="<?php echo $editing ? $geoData->ph_en : ''; ?>">
          </div>
          <div class="objects__item">
            <label for="function">Классификация по минерализации</label>
            <input type="text" name="function" value="<?php echo $editing ? $geoData->function : ''; ?>">
            Классификация по минерализации - En<input type="text" 
            name="minclass_en" value="<?php echo $editing ? $geoData->minclass_en : ''; ?>">
          </div>


        </div>

        <div class="objects__group">
          <div class="objects__item">
            <label for="river">Бальнеологическая характеристика вод - Ru </label>
            <input type="text" name="river" value="<?php echo $editing ? $geoData->river : ''; ?>">
            Бальнеологическая характеристика вод - En<input type="text" name="balneol_en" 
            value="<?php echo $editing ? $geoData->balneol_en : ''; ?>">
          </div>
          <div class="objects__item">
            <label for="check_obj">Перспективная область эксплуатации - Ru</label>
            <input type="text" name="check_obj" value="<?php echo $editing ? $geoData->check_obj : ''; ?>">
            Перспективная область эксплуатации - En<input type="text" 
            name="perspective_en" value="<?php echo $editing ? $geoData->perspective_en : ''; ?>">
          </div>
        </div>

        <div class="objects__group">
          <div class="objects__item">
            Классификация по температуре - Ru 
            <input type="text" name="gen" value="<?php echo $editing ? $geoData->gen : ''; ?>">
            Классификация по температуре - En<input type="text" name="tclass_en" 
            value="<?php echo $editing ? $geoData->tclass_en: ''; ?>">
          </div>
          <div class="objects__item">
            Количество источников - Ru</label>
            <input type="text" name="date" value="<?php echo $editing ? $geoData->date : ''; ?>">
            Количество источников - En<input type="text" name="wellsnumber_en" 
            value="<?php echo $editing ? $geoData->wellsnumber_en : ''; ?>">
          </div>
        </div>


        <div class="objects__group">
          <div class="objects__item">
            Потенциальные ресурсы термальных вод - Ru 
            <input type="text" name="potresourse" value="<?php echo $editing ? $geoData->potresourse : ''; ?>">
            Потенциальные ресурсы термальных вод - En<input type="text" name="potresourse_en" 
            value="<?php echo $editing ? $geoData->potresourse_en : ''; ?>">
          </div>
          <div class="objects__item">
            Суммарный дебит, л/с или кг/с - Ru</label>
            <input type="text" name="debit" value="<?php echo $editing ? $geoData->debit : ''; ?>">
            Суммарный дебит, л/с или кг/с - En<input type="text" name="debit_en" 
            value="<?php echo $editing ? $geoData->debit_en : ''; ?>">
          </div>
        </div>

        <div class="objects__item">
          <label for="location">Современное использование - Ru</label>
          <input type="text" name="powerpr" value="<?php echo $editing ? $geoData->powerpr : ''; ?>">
          Современное использование - En<input type="text" name="powerpr_en" cols="60" rows="2" 
          value="<?php echo $editing ? $geoData->powerpr_en : ''; ?>">
        </div>
        
        <div class="objects__item">
          <label for="location">Дополнительные данные - Ru</label>
          <textarea name="pp" cols="60" rows="2"><?php echo $editing ? $geoData->pp : ''; ?></textarea>
          Дополнительные данные - En
          <textarea name="dop_en" cols="60" rows="2"><?php echo $editing ? $geoData->dop_en : ''; ?></textarea>
        </div>

        <div class="objects__item">
          <button class="button" type="submit"><?php echo $editing ? 'Редактировать' : 'Добавить'; ?></button>
        </div>




      </form>




    </div>
  </div>

  <div style="height: 100px;"></div>
</section>


<?php
get_footer();
?>