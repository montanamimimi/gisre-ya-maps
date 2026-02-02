<?php

require_once plugin_dir_path(__FILE__) . 'GetObjects.php';
require_once plugin_dir_path(__FILE__) . 'GetTypes.php';

$getObjects = new GetObjects();
$getTypes = new GetTypes();

get_header();

$searchtext = "";
$searchtype = "";
$searchstatus = "";

if (isset($_GET['thename'])) {
  $searchtext = $_GET['thename'];
}

if (isset($_GET['type'])) {
  $searchtype = $_GET['type'];
}

if (isset($_GET['status'])) {
  $searchstatus = $_GET['status'];
}

if (isset($_GET['power'])) {
  $powerFrom = $_GET['power'];
} else {
  $powerFrom = 0;
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


<section class="search-form" style="margin-top:40px;">
  <div class="container">

    <div class="edit-switcher">
      <div class="edit-switcher__item edit-switcher__current"><h3>Редактирование объектов</h3></div>
      <div class="edit-switcher__item edit-switcher__link"><h3><a href="<?php echo home_url() . '/organizations'; ?>">Редактирование организаций</a></h3></div>
      <div class="edit-switcher__item edit-switcher__link"><h3><a href="<?php echo home_url() . '/editgeodata'; ?>">Редактирование георесурсы</a></h3></div>
    </div>
    <hr class="edit-switcher__divider">

    <?php


    if ($searchtext) {
      echo '<p>Фильтр по названию: "' . $searchtext . '". </p>';
    }    

    ?>

    <form class="admin-search" method="GET">
      <div class="admin-search__fields">      
        <input name="thename" id="thename" type="text" placeholder="<?php echo __('Введите название...', 'gisre-plugin'); ?>" value="<?php echo $searchtext ?>">
        <input id="power" type="number" name="power" placeholder="Мощность от (Вт)" value="<?php echo $powerFrom ? $powerFrom : ""; ?>">
        <select name="type" id="type">
          <option value="">Все типы</option>
          <?php 
          
          foreach ($getTypes->energy as $key => $type) { ?>
            <option value="<?php echo $key; ?>" <?php echo ($key == $searchtype) ? " selected " : ""; ?>>
              <?php echo $type['runame']; ?>
            </option>          
          <?php }
          
          ?>
        </select>
        <select name="status" id="status">
          <option value="">Все статусы</option>
          <option value="d" <?php echo ('d' == $searchstatus) ? " selected " : ""; ?>>Действующий</option>         
          <option value="s" <?php echo ('s' == $searchstatus) ? " selected " : ""; ?>>Строящийся</option>
           <option value="p" <?php echo ('p' == $searchstatus) ? " selected " : ""; ?>>Проектируемый</option>
          <option value="z" <?php echo ('z' == $searchstatus) ? " selected " : ""; ?>>Не эксплуатируется</option>
          <option value="x" <?php echo ('x' == $searchstatus) ? " selected " : ""; ?>>Не построен</option>
        </select>
        <button type="submit" style="cursor:pointer;">Поиск</button>
        <?php

        if ($searchtext || $powerFrom || $searchtype || $searchstatus) {
          echo '<a href="' . site_url('/gis-objects/') . '">Очистить поиск</a>';
        }
        ?>
      </div>
      


    </form>

  </div>
</section>

<section class="new-button">
  <div class="container">
    <?php
    if (current_user_can('administrator')) { ?>
      <a class="button" href="<?php echo home_url() . '/newobject'; ?>">Добавить новый объект</a>

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
          <th>Тип</th>
          <th>Мощность</th>
          <th>Статус</th>
          <?php
          if (current_user_can('administrator')) { ?>
            <th>Редактировать</th>
            <th>x</th>
          <?php }
          ?>
        </tr>
        <?php

        foreach ($getObjects->objects as $object) {   
          
          switch ($object->status) {
            case 's':
              $stat = 'строящийся';
              break;
            case 'd': 
              $stat = 'действующий';
              break;
            case 'p': 
              $stat = 'проектируемый';
              break;
            case 'z':
              $stat = 'не эксплуатируется';
              break;
            case 'x':
              $stat = 'не построен';
              break;
            default: 
              $stat = $object->status;
              break;
          }
          ?>

          <tr>
            <td><?php echo $object->id ?>
          </td>
            <td><?php echo $object->name ?></td>
            <td><?php echo $object->type ?></td>
            <td><?php echo $object->power ?></td>
            <td><?php echo $stat; ?></td>
            <?php
            if (current_user_can('administrator')) { ?>
              <td class="button-td">
                <a class="button" href="<?php echo site_url() . '/editobject/?id=' . $object->id; ?>" class="edit-object-button">Редактировать</a>
              </td>
              <td>
                <form id="delete-form-<?php echo $object->id ?>" action="<?php echo esc_url(admin_url('admin-post.php')) ?>" method="POST">
                  <input type="hidden" name="action" value="deleteobject">
                  <input type="hidden" name="idtodelete" value="<?php echo $object->id ?>">
                  <span class="delete-object-button" data-id="<?php echo $object->id ?>">X</span>
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