<?php

require_once plugin_dir_path(__FILE__) . 'GetObjects.php';
require_once plugin_dir_path(__FILE__) . 'GetTypes.php';

$getObjects = new GetObjects();
$getTypes = new GetTypes();

get_header();

$searchtext = "";

if (isset($_GET['thename'])) {

  $searchtext = $_GET['thename'];
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
      echo '<p>Результат поиска для "' . $searchtext . '". </p>';
    }
    ?>




    <form class="search-form__body" method="GET">
      <input name="thename" id="thename" type="text" placeholder="Введите название..." value="<?php echo $searchtext ?>">
      <button type="submit">Поиск</button>
      <?php

      if ($searchtext) {
        echo '<a href="' . site_url('/gis-objects/') . '">Очистить поиск</a>';
      }
      ?>

    </form>
  </div>
</section>


<section class="objects">
  <div class="container">
    <div class="objects__table">
      <p><?php



          ?></p>

      <?php


      if (current_user_can('administrator')) { ?>
        <a class="button" href="<?php echo home_url() . '/newobject'; ?>">Добавить новый объект</a>

      <?php }
      ?>
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