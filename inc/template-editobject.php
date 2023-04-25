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

require_once plugin_dir_path(__FILE__) . 'GetTypes.php';

$getTypes = new GetTypes();

get_header();


if ($_GET['id']) {

  $objectData = gisre_get_one_object($_GET['id']);

  $objectData->name = str_replace('"','&quot;',$objectData->name);
  $objectData->holder = str_replace('"','&quot;',$objectData->holder);

}
?>

<section class="single-banner">
  <div class="container">
    <div class="single-banner__content">
      <h1><?php the_title(); ?></h1>
      <p>

        <?php
        $theParent = wp_get_post_parent_id(get_the_ID());

        if ($theParent) { ?>
          <a href="<?php echo get_permalink($theParent) ?>">Go to <?php echo get_the_title($theParent) ?> </a>
        <?php
        }
        ?>
      </p>
    </div>
  </div>
</section>



<section class="objects">
  <div class="container" style="margin-top: 50px;">
    <div class="objects__table objects__new-object">

      <a class="button" href="<?php echo home_url() . '/gis-objects'; ?>">Вернуться к списку объектов</a>
      <br><Br>

      <?php 
      
      if (!$objectData) {
        echo ' <h2 class="objects__add-header">Оьъект с таким ID не найден. </h2>';
      } else { 
        
        $oldpicture = false;
        $reloadpicture = false;

        if ($objectData->picture) {
         if (is_numeric($objectData->picture)) {
           $oldpicture = $objectData->picture;
           $pictureURL = wp_get_attachment_image_url($objectData->picture, 'medium');
         } else {  
           $reloadpicture = true;  
           $pictureURL = site_url() . "/wp-content/images/gismaps/" . $objectData->picture;
         }
        } else {
           $pictureURL = plugin_dir_url(__FILE__) . 'images/emptyimg.jpg';
        }        
        
        
        ?>

      
      <h2 class="objects__add-header">Редактировать объект: <?php echo $objectData->name; ?></h2>
      <form action="<?php echo esc_url(admin_url('admin-post.php')) ?>" class="objects__form" method="POST" enctype="multipart/form-data">
        <input type="hidden" name="action" value="editobject">
        <input type="hidden" name="idtoedit" value="<?php echo $objectData->id; ?>">
        <div class="objects__item">
          <label for="objectname">Название объекта</label>
          <input type="text" name="objectname" placeholder="Имя..." value="<?php echo $objectData->name; ?>" required>
        </div>

        <div class="objects__item">
          <label for="objecttype">Тип Объекта</label>
          <select name="objecttype">
            <?php
            foreach ($getTypes->types as $key => $value) {
            
            echo '<option value="' . $value  . '"';
            if ($value == $objectData->type) {
              echo ' selected';
            }
            echo '>'. $key . '</option>';
             }

            ?>
          </select>
        </div>

        <div class="objects__group">
          <div class="objects__item">
            <label for="lat">Широта</label>
            <input type="number" placeholder="lat" name="lat" step="0.000001" min="0" value="<?php echo $objectData->lat; ?>" required>
          </div>
          <div class="objects__item">
            <label for="lon">Долгота</label>
            <input type="number" placeholder="lon" name="lon" step="0.000001" min="0" value="<?php echo $objectData->lon; ?>" required>
          </div>
        </div>


        <div class="objects__item">
          <label for="location">Адрес</label>
          <textarea name="location" cols="60" rows="2" placeholder="Адрес..."><?php echo $objectData->location; ?></textarea>
        </div>
        <div class="objects__item">
          <label for="pawerpr">Примечание к мощности</label>
          <textarea name="powerpr" cols="30" rows="2" placeholder="Примечание к мощности..."><?php echo $objectData->powerpr; ?></textarea>
        </div>

        <div class="objects__group">
          <div class="objects__item">
            <label for="power">Мощность (Вт)</label>
            <input type="number" name="power" placeholder="Мощность..." value="<?php echo $objectData->power; ?>">
          </div>
          <div class="objects__item">
            <label for="year">Год запуска</label>
            <input type="text" name="year" placeholder="Год запуска..." value="<?php echo $objectData->year; ?>">
          </div>
        </div>
        <div class="objects__group">
          <div class="objects__item">
            <label for="status">Статус</label>
            <select name="status">
              <option value="d" <?php echo ($objectData->status == 'd') ? ' selected ' : ''; ?>>Действующая</option>
              <option value="s" <?php echo ($objectData->status == 's') ? ' selected ' : ''; ?>>Строящаяся</option>
              <option value="p" <?php echo ($objectData->status == 'p') ? ' selected ' : ''; ?>>Проектируемая</option>
              <option value="z" <?php echo ($objectData->status == 'z') ? ' selected ' : ''; ?>>Закрыта</option>
            </select>
          </div>
          <div class="objects__item">
            <label for="function">Тип станции</label>
            <select name="function">
              <option value="">Неизвестно</option>
              <option value="a" <?php echo ($objectData->function == 'a') ? ' selected ' : ''; ?>>Автономная</option>
              <option value="s" <?php echo ($objectData->function == 's') ? ' selected ' : ''; ?>>Сетевая</option>
            </select>
          </div>
        </div>

        <div class="objects__checkbox">
          <input name="pp" type="checkbox" value="1" <?php echo ($objectData->pp == '1') ? ' checked ' : ''; ?>>
          <label for="pp">Построены по постановлению Правительства РФ</label>
        </div>
        <div class="objects__checkbox">
          <input name="gen" type="checkbox" value="1" <?php echo ($objectData->gen == '1') ? ' checked ' : ''; ?>>
          <label for="gen">Является квалифицированным генерирующим объектом, функционирующим на основе использования ВИЭ </label>
        </div>
        <div class="objects__checkbox">
          <input name="truthplace" type="checkbox" value="1" <?php echo ($objectData->truthplace == '1') ? ' checked ' : ''; ?>>
          <label for="truthplace">Местоположение на карте указано точно</label>
        </div>

        <div class="objects__item">
          <label for="holder">Владелец</label>
          <input type="text" name="holder" placeholder="Владелец..." value="<?php echo $objectData->holder; ?>">
        </div>
        <div class="objects__item">
          <label for="source">Источник (текст, не обязательно)</label>
          <input type="text" name="source" placeholder="Источник..." value="<?php echo $objectData->source; ?>">
        </div>
        <div class="objects__item">
          <label for="link">Источник (ссылка)</label>
          <input type="url" name="link" placeholder="Ссылка..." value="<?php echo $objectData->link; ?>">
        </div>
        <div class="objects__item">
          <label for="linkshort">Короткая ссылка (для отображения, например test.com)</label>
          <input type="text" name="linkshort" placeholder="text.com" value="<?php echo $objectData->linkshort; ?>">
        </div>

        <div class="objects__item">
          <label  for="picture">Прикрепите изображение</label>
          <img id="objectPictureIMG" class="objects__image" src="<?php echo $pictureURL; ?>" alt="">

          <input id="objectPicture" type="file" name="picture">

          <?php 
          
          if ($oldpicture) {
            echo '<input type="hidden" name="oldpicture" value="' . $oldpicture . '">';
          } else if ($reloadpicture) {
            echo '<input type="hidden" name="reloadpicture" value="' . $pictureURL . '">';
          }
          
          ?>
          
          

        </div>
        <div class="objects__item">
          <button class="button" type="submit">Сохранить</button>
        </div>




      </form>

      <?php }
      
      ?>





    </div>
  </div>

  <div style="height: 100px;"></div>
</section>


<?php
get_footer();
?>