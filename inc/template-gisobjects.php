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
                      <option value="Автономная">Автономная</option>  
                      <option value="Сетевая">Сетевая</option>                                          
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
                    <td id="<?php echo $object->id ?>" class="button-td">
                      <button class="edit-object-button">Редактировать</button>
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

<section class="search-overlay">
                    <form action="<?php echo esc_url(admin_url('admin-post.php')) ?>" class="objects__edit objects__edit-open " method="POST">              
                          <input type="hidden" name="action" value="editobject">
                          <input type="hidden" name="idtoedit" value="<?php echo $object->id ?>"> 
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
                                <option value="Автономная">Автономная</option>  
                                <option value="Сетевая">Сетевая</option>                                          
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

                          <button class="form__button">Редактировать</button>
                      </form>
</section>

<?php 
get_footer();
?>