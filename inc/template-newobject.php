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

      <h2 class="objects__add-header">Добавить новый объект: </h2>
      <form action="<?php echo esc_url(admin_url('admin-post.php')) ?>" class="objects__form" method="POST" enctype="multipart/form-data">
        <input type="hidden" name="action" value="createobject">

        <div class="objects__item">
          <label for="objectname">Название объекта</label>
          <input type="text" name="objectname" placeholder="Имя..." required>
        </div>

        <div class="objects__item">
          <label for="objecttype">Тип Объекта</label>
          <select name="objecttype">
            <?php
            foreach ($getTypes->types as $key => $value) {
            ?>
              <option value="<?php echo $value ?>"><?php echo $key ?></option>
            <?php }

            ?>
          </select>
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
          <label for="location">Адрес</label>
          <textarea name="location" cols="60" rows="2" placeholder="Адрес..."></textarea>
        </div>
        <div class="objects__item">
          <label for="pawerpr">Примечание к мощности</label>
          <textarea name="powerpr" cols="30" rows="2" placeholder="Примечание к мощности..."></textarea>
        </div>

        <div class="objects__group">
          <div class="objects__item">
            <label for="power">Мощность (Вт)</label>
            <input type="number" name="power" placeholder="Мощность...">
          </div>
          <div class="objects__item">
            <label for="year">Год запуска</label>
            <input type="text" name="year" placeholder="Год запуска...">
          </div>
        </div>
        <div class="objects__group">
          <div class="objects__item">
            <label for="status">Статус</label>
            <select name="status">
              <option value="d">Действующая</option>
              <option value="s">Строящаяся</option>
              <option value="p">Проектируемая</option>
              <option value="z">Закрыта</option>
            </select>
          </div>
          <div class="objects__item">
            <label for="function">Тип станции</label>
            <select name="function">
              <option value="">Неизвестно</option>
              <option value="a">Автономная</option>
              <option value="s">Сетевая</option>
            </select>
          </div>
        </div>

        <div class="objects__checkbox">
          <input name="pp" type="checkbox" value="1">
          <label for="pp">Построены по постановлению Правительства РФ</label>
        </div>
        <div class="objects__checkbox">
          <input name="gen" type="checkbox" value="1">
          <label for="gen">Является квалифицированным генерирующим объектом, функционирующим на основе использования ВИЭ </label>
        </div>
        <div class="objects__checkbox">
          <input name="truthplace" type="checkbox" value="1">
          <label for="truthplace">Местоположение на карте указано точно</label>
        </div>

        <div class="objects__item">
          <label for="holder">Владелец</label>
          <input type="text" name="holder" placeholder="Владелец...">
        </div>
        <div class="objects__item">
          <label for="source">Источник (текст, не обязательно)</label>
          <input type="text" name="source" placeholder="Источник...">
        </div>
        <div class="objects__item">
          <label for="link">Источник (ссылка)</label>
          <input type="url" name="link" placeholder="Ссылка...">
        </div>
        <div class="objects__item">
          <label for="linkshort">Короткая ссылка (для отображения, например test.com)</label>
          <input type="text" name="linkshort" placeholder="text.com">
        </div>

        <div class="objects__item">
          <label  for="picture">Прикрепите изображение</label>
          <img id="objectPictureIMG" class="objects__image" src="<?php echo plugin_dir_url(__FILE__) . 'images/emptyimg.jpg'; ?>" alt="">

          <input id="objectPicture" type="file" name="picture">


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