<?php

require_once plugin_dir_path(__FILE__) . 'GetOrgdata.php';
require_once plugin_dir_path(__FILE__) . 'GetRegions.php';
$orgdata = new GetOrgdata();
$regions = new GetRegions();
$ruRegions = $regions->ruRegions;

if ($orgdata) {
    $data = $orgdata->data;
}

get_header();

if (isset($_GET['thename'])) {

  $searchtext = $_GET['thename'];
} else {
    $searchtext = "";
}

if (isset($_GET['type'])){
    $type = $_GET['type'];
} else {
    $type = 'ALL';
}

?>

<section class="single-banner">
  <div class="container">
    <div class="single-banner__content">
      <h1><?php the_title(); ?></h1>
    </div>
  </div>
</section>


<section class="search-form" style="margin-top:40px;">
  <div class="container">

    <div class="edit-switcher">
      <div class="edit-switcher__item edit-switcher__link"><h3><a href="<?php echo home_url() . '/gis-objects'; ?>">Редактирование объектов</a></h3></div>
      <div class="edit-switcher__item"><h3>Редактирование организаций</h3></div>
      <div class="edit-switcher__item edit-switcher__link"><h3><a href="<?php echo home_url() . '/editgeodata'; ?>">Редактирование георесурсы</a></h3></div>
    </div>
    <hr class="edit-switcher__divider">

    <?php


    if ($searchtext) {
      echo '<p>Результат поиска для "' . $searchtext . '". </p>';
    }
    ?>

    <form class="search-form__body" method="GET">
      <input name="thename" id="thename" type="text" placeholder="<?php echo __('Введите название...', 'gisre-plugin'); ?>" value="<?php echo $searchtext ?>">
      <button type="submit">Поиск</button>
      <?php

      if ($searchtext) {
        echo '<a href="' . site_url('/organizations/') . '">' . __('Очистить поиск', 'gisre-plugin') . '</a>';
      }
      ?>

    </form>
  </div>
</section>
<section class="new-button">
  <div class="container">
    <?php
    if (current_user_can('administrator')) { ?>
      <a class="button" href="<?php echo home_url() . '/neworg'; ?>">Добавить организацию</a>

    <?php }
    ?>
  </div>
</section>

<section class="objects">
  <div class="container">
    <div class="objects__table">

      <table class="gis-objects-table">
        <tr>
          <th>ID</th>
          <th>Название</th>
          <th>Регион</th>
          <?php
          if (current_user_can('administrator')) { ?>
            <th>Редактировать</th>
            <th>x</th>
          <?php }
          ?>
        </tr>
        <?php

        foreach ($data as $item) {           
          ?>

          <tr>
            <td><?php echo $item->id ?></td>
            <td><?php echo $item->name ?></td>
            <td><?php echo $ruRegions[$item->region]; ?></td>
            <?php
            if (current_user_can('administrator')) { ?>
              <td class="button-td">
                <a class="button" href="<?php echo site_url() . '/editorg/?id=' . $item->id; ?>" class="edit-object-button">Редактировать</a>
              </td>
              <td>
                <form id="delete-form-<?php echo $item->id ?>" action="<?php echo esc_url(admin_url('admin-post.php')) ?>" method="POST">
                  <input type="hidden" name="action" value="deleteorg">
                  <input type="hidden" name="idtodelete" value="<?php echo $item->id ?>">
                  <span class="delete-object-button" data-id="<?php echo $item->id ?>">X</span>
                </form>
              </td>

            <?php }
            ?>
          </tr>

        <?php }
        ?>
      </table>

    </div>
  </div>
</section>


<div class="modaldel" id="modaldel">
  <div class="modaldel-content">
    <h3>Вы уверены, что хотите удалить объект?</h3>

    <div class="modaldel-buttons">
      <span id="start" class="button button--primary button--middle">Удалить</span>
      <span id="stop" class="button button--primary button--middle">Отмена</span>
    </div>

  </div>

</div>

<?php
get_footer();
?>