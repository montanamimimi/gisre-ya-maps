<?php

require_once plugin_dir_path(__FILE__) . 'GetObjects.php';
require_once plugin_dir_path(__FILE__) . 'GetTypes.php';

$getObjects = new GetObjects();
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


<section class="search-form" style="margin-top:40px;">
  <div class="container">

    <?php

    $searchtext = "";

    if (isset($_GET['thename'])) {

      $searchtext = $_GET['thename'];
    }

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
          <th>Name</th>
          <th>Type</th>
          <th>Power</th>
          <th>Статус</th>
          <?php
          if (current_user_can('administrator')) { ?>
            <th>Edit</th>
            <th>x</th>
          <?php }
          ?>
        </tr>
        <?php

        foreach ($getObjects->objects as $object) { 

          //  $oldpicture = false;
          //  $reloadpicture = false;

          //  if ($object->picture) {
          //   if (is_numeric($object->picture)) {
          //     $oldpicture = $object->picture;
          //     $pictureURL = wp_get_attachment_image_url($object->picture, 'medium');
          //   } else {  
          //     $reloadpicture = true;  
          //     $pictureURL = site_url() . "/wp-content/images/gismaps/" . $object->picture;
          //   }
          //  } else {
          //     $pictureURL = plugin_dir_url(__FILE__) . 'images/emptyimg.jpg';
          //  }

          
          ?>

          <tr>
            <td><?php echo $object->id ?>
          
            <?php echo  ' - ' . $object->picture; ?>
          </td>
            <td><?php echo $object->name ?></td>
            <td><?php echo $object->type ?></td>
            <td><?php echo $object->power ?></td>
            <td><?php echo $object->status ?></td>
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