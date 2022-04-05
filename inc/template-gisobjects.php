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
                <a href="<?php echo get_permalink($theParent) ?>" >Go to <?php echo get_the_title($theParent) ?> </a>
                <?php 
            }
          ?>
     </p>
    </div>
  </div>
</section>

<section class="single-text">
  <div class="container">
      <div class="single-text__desc">
        
        <div class="single-text__content">
          <?php the_content(); ?>
        </div>

      </div>
  </div>
</section>

<section class="search-form">
  <div class="container">

      <?php 
      
      $searchtext = "";

      if ($_GET['thename']) { 
        
        $searchtext = $_GET['thename']; 

        ?>
        
      <p>Результат поиска для <?php echo "&quot;" . $searchtext . "&quot;" ?>. <a href="<?php echo site_url('/gis-objects/'); ?>">Очистить поиск</a></p>
      
      <?php }
      
      ?>
      <form class="search-form__body" method="GET">
        <input name="thename" id="thename" type="text" placeholder="Введите название..." value="<?php $searchtext ?>">
        <button type="submit">Поиск</button>
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
            <h2 class="objects__add-header">Добавить новый объект: </h2>
            <form action="<?php echo esc_url(admin_url('admin-post.php')) ?>" class="objects__form" method="POST">              
                <input type="hidden" name="action" value="createobject">

                <div class="objects__form-section">
                  <input type="text" name="objectname" placeholder="Имя..." required>    
                  <select name="objecttype">
                    <?php                                        
                    foreach ($getTypes->types as $key => $value) { 
                      ?>
                      <option value="<?php echo $value ?>"><?php echo $key ?></option>
                    <?php }
                    
                    ?>                  
                  </select>            
                  <input type="number" placeholder="lat" name="lat" step="0.000001" min="0" required>   
                  <input type="number" placeholder="lon" name="lon" step="0.000001" min="0" required>         
                </div>

                <div class="objects__form-section">                 
                  <textarea name="location" cols="60" rows="2" placeholder="Адрес..."></textarea>
                  <textarea name="powerpr" cols="30" rows="2" placeholder="Примечание к мощности..."></textarea>
                </div>

                <div class="objects__form-section">
                  <input type="number" name="power" placeholder="Мощность...">    
                 <input type="text" name="year" placeholder="Год запуска...">   
 
                 <select name="status">                                                        
                      <option value="d">Действующая</option>  
                      <option value="s">Строящаяся</option>  
                      <option value="p">Проектируемая</option>  
                      <option value="z">Закрыта</option>                                           
                  </select>     
                  <select name="function">   
                      <option value="">Неизвестно</option>                                                       
                      <option value="a">Автономная</option>  
                      <option value="s">Сетевая</option>                                          
                  </select>   
                  <label for="pp">ПП</label>
                  <input name="pp" type="checkbox" value="1">  
                  <label for="gen">Gen</label>
                  <input name="gen" type="checkbox" value="1">  
                  <label for="truthplace">Место??</label>
                  <input name="truthplace" type="checkbox" value="1">  
                </div>

                <div class="objects__form-section">
                  <input type="text" name="holder" placeholder="Владелец...">
                  <input type="text" name="source" placeholder="Источник...">      
                  <input type="text" name="link" placeholder="Ссылка...">
                  <input type="text" name="linkshort" placeholder="кор ссылка...">                  
                </div>

                <div class="objects__form-section">
                  <input type="picture" name="picture" placeholder="Картинка...">
                  <input type="date" name="date">
                </div>

                <button class="form__button">Добавить</button>
            </form>

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
            
            foreach ($getObjects->objects as $object) { ?>

            <tr>
            <td><?php echo $object->id ?></td>
            <td><?php echo $object->name ?></td>
            <td><?php echo $object->type ?></td>
            <td><?php echo $object->power ?></td>
            <td><?php echo $object->status ?></td>
            <?php 
                if (current_user_can('administrator')) { ?>
                    <td class="button-td">
                      <button class="edit-object-button" 
                        data-id="<?php echo $object->id ?>"
                        data-type="<?php echo $object->type ?>"
                        data-name="<?php echo $object->name ?>"
                        data-lat="<?php echo $object->lat ?>"
                        data-lon="<?php echo $object->lon ?>"
                        data-location="<?php echo $object->location ?>"
                        data-power="<?php echo $object->power ?>"
                        data-powerpr="<?php echo $object->powerpr ?>"
                        data-pp="<?php echo $object->pp ?>"
                        data-gen="<?php echo $object->gen ?>"
                        data-truthplace="<?php echo $object->truthplace ?>"
                        data-year="<?php echo $object->year ?>"
                        data-status="<?php echo $object->status ?>"
                        data-function="<?php echo $object->function ?>"
                        data-holder="<?php echo $object->holder ?>"
                        data-source="<?php echo $object->source ?>"
                        data-link="<?php echo $object->link ?>"
                        data-linkshort="<?php echo $object->linkshort ?>"
                        data-picture="<?php echo $object->picture ?>"
                        data-date="<?php echo $object->date ?>"
                        >Редактировать</button>
                    </td>
                    <td>
                    <form action="<?php echo esc_url(admin_url('admin-post.php')) ?>" method="POST">
                        <input type="hidden" name="action" value="deleteobject">               
                        <input type="hidden" name="idtodelete" value="<?php echo $object->id ?>">     
                        <button class="delete-object-button">X</button>
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

<section id="edit-overlay" class="edit-overlay">
                    <form action="<?php echo esc_url(admin_url('admin-post.php')) ?>" class="objects__edit objects__edit-open" method="POST">              
                          <input type="hidden" name="action" value="editobject">
                          <input type="hidden" name="idtoedit" value="" id="edit-post-id">
                          <div class="objects__form-section">
                            <input type="text" name="objectname" id="edit-post-name" placeholder="Имя..." required>    
                            <select name="objecttype" id="edit-post-type">
                              <?php                                        
                              foreach ($getTypes->types as $key => $value) { 
                                ?>
                                <option id="edit-post-type-<?php echo $value ?>" value="<?php echo $value ?>"><?php echo $key ?></option>
                              <?php }
                              
                              ?>                  
                            </select>            
                            <input type="number" id="edit-post-lat" placeholder="lat" name="lat" step="0.000001" min="0" required>   
                            <input type="number" id="edit-post-lon" placeholder="lon" name="lon" step="0.000001" min="0" required>         
                          </div>

                          <div class="objects__form-section">                 
                            <textarea name="location" id="edit-post-location" cols="60" rows="2" placeholder="Адрес..."></textarea>
                            <textarea name="powerpr" id="edit-post-powerpr" cols="30" rows="2" placeholder="Примечание к мощности..."></textarea>
                          </div>

                          <div class="objects__form-section">
                            <input type="number" name="power" id="edit-post-power" placeholder="Мощность...">    
                          <input type="text" name="year" id="edit-post-year" placeholder="Год запуска...">   
          
                          <select name="status">                                                        
                                <option id="edit-post-status-d" value="d">Действующая</option>  
                                <option id="edit-post-status-s" value="s">Строящаяся</option>  
                                <option id="edit-post-status-p" value="p">Проектируемая</option>  
                                <option id="edit-post-status-z" value="z">Закрыта</option>                                           
                            </select>     
                            <select name="function">   
                                <option value="" selected>Неизвестно</option>                                                       
                                <option id="edit-post-function-a" value="a">Автономная</option>  
                                <option id="edit-post-function-s" value="s">Сетевая</option>                                          
                            </select>   
                            <label for="pp">ПП</label>
                            <input name="pp" id="edit-post-pp" type="checkbox" value="1">  
                            <label for="gen">Gen</label>
                            <input name="gen" id="edit-post-gen" type="checkbox" value="1">  
                            <label for="truthplace">Место??</label>
                            <input name="truthplace" id="edit-post-truthplace" type="checkbox" value="1">  
                          </div>

                          <div class="objects__form-section">
                            <input type="text" id="edit-post-holder" name="holder" placeholder="Владелец...">
                            <input type="text" id="edit-post-source" name="source" placeholder="Источник...">      
                            <input type="text" id="edit-post-link" name="link" placeholder="Ссылка...">
                            <input type="text" id="edit-post-linkshort" name="linkshort" placeholder="кор ссылка...">                  
                          </div>

                          <div class="objects__form-section">
                            <input type="picture" id="edit-post-picture" name="picture" placeholder="Картинка...">
                            <input type="date" id="edit-post-date" name="date">
                          </div>

                          <button class="form__button" type="submit">Редактировать</button>
                          <a id="cansel-editing" class="cansel-editing">Отмена</a>
                      </form>
</section>

<?php 
get_footer();
?>