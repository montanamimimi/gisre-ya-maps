<?php 
require_once plugin_dir_path(__FILE__) . 'GetOrgdata.php';
require_once plugin_dir_path(__FILE__) . 'GetRegions.php';
require_once plugin_dir_path(__FILE__) . 'GetTypes.php';
$getTypes = new GetTypes();
$orgdata = new GetOrgdatabase();
$regions = new GetRegions();

get_header();

?>




<section class="single-banner">
  <div class="container">
    <div class="single-banner__content">
     <h1><?php the_title(); ?></h1>
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

      <div class="orgdata">
            <form method="GET">
                <div class="orgdata__form">
                <p>Направление деятельности:</p>                           
                <span id="selectAll" class="selectAll">Выбрать все</span>    
                    <div class="orgdata__section">

                                                   
                            <?php  
                                foreach ($getTypes->orgs as $key => $value) { ?>
                                    <div class="orgdata__type">
                                        <input 
                                        class="orgdata__type-item" 
                                        type="checkbox" 
                                        id="<?php echo $key ?>" 
                                        name="<?php echo $key ?>"                                        
                                        <?php
                                        if (!$_GET['type'] || $_GET[$key]) { echo 'checked';}
                                        ?>                                        
                                        >
                                        <label for="<?php echo $key ?>"><?php echo $value['name'] ?>
                                            
                                        </label>
                                        <div style="width: 10px; height: 10px; background-color: <?php echo $value['color'] ?>;"></div>
                                    </div>
                                <?php }
                            ?>
                    </div>
                    <div class="orgdata__section">
                        <p>Регион поиска:</p>
                        <select name="regions" id="regions" class="orgdata__select">
                            <option value="-100">--- не важно ---</option>
                            <?php  
                                foreach ($regions->ruRegions as $value => $runame) { ?>
                                    <option 
                                        value="<?php echo $value ?>" 
                                        <?php
                                            if ($_GET['regions'] == $value) { echo 'selected';}
                                        ?>
                                        >
                                        <?php echo $runame ?> 

                                    </option>
                                <?php }
                            ?>
                        </select>
                    </div>
                    <div class="orgdata__section">
                        <p>Тип организации:</p>
                        <select name="type" id="type" class="orgdata__select">
                            <option value="ALL">--- не важно ---</option>
                            <option value="SCIENSE" 
                            <?php 
                                if ($_GET['type'] == 'SCIENSE') { echo 'selected';}
                            ?>
                            >Научные</option>
                            <option value="SALES"
                            <?php 
                                if ($_GET['type'] == 'SALES') { echo 'selected';}
                            ?>
                            >Коммерческие</option>
                        </select>
                    </div>
                    <div class="orgdata__section">
                        <p>Результаты поиска:</p>
                        <button type="submit" class="orgdata__button">Показать  </button>
                    </div>
                </div>
            </form>

        </div>

        <div class="orgdata-results">
            <?php

            if (!$orgdata->data) { echo '<p>Нет данных по введенным параметрам</p>'; }
 
            foreach ($orgdata->data as $item) { ?>
                 
                <div class="gistables-tab">
                    <input class="gistables-input" type="checkbox" id="chck<?php echo $item->id ?>">
                        <label 
                        class="tab-label orgdata-results__label" 
                        for="chck<?php echo $item->id ?>">
                            <?php echo $item->name . ', ' . $item->city?> 


                            <div class="orgdata-results__legend">
                                <?php echo $orgdata->createLegend($item); ?>
                            </div>
                        </label>
                    <div class="tab-content">
                        <p>
                            <b>Регион:</b> <?php echo $regions->ruRegions[$item->region]; ?> <br>
                            <b>Адрес:</b> <?php echo $item->adress; ?> <br>
                            <b>Направление:</b> <?php echo $item->type; ?> <br>
                            <?php if ($item->phone) { echo '<b>Телефон:</b> ' . $item->phone . '<br>';} ?>
                            <?php if ($item->email) { echo '<b>Email:</b> ' . $item->email . '<br>';} ?>
                            <?php if ($item->link) { ?>
                                <a href="<?php echo $item->link ?>" target="_blank">Перейти на сайт</a>
                            <?php } ?>
                        </p>
                        <?php 

                        
                        ?>
                    </div>
                </div>
              
            <?php }
            
            ?>
        </div>
  </div>
</section>



<?php get_footer(); ?>