<?php 
require_once plugin_dir_path(__FILE__) . 'GetOrgdata.php';
require_once plugin_dir_path(__FILE__) . 'GetRegions.php';
require_once plugin_dir_path(__FILE__) . 'GetTypes.php';
$getTypes = new GetTypes();
$rows = new GetOrgdata();
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
                    <div class="orgdata__section">
                        <p>Направление деятельности:</p>   
                                <span id="selectAll" class="selectAll">Выбрать все</span>                       
                            <?php  
                                foreach ($getTypes->orgs as $value => $runame) { ?>
                                    <div class="orgdata__type">
                                        <input 
                                        class="orgdata__type-item" 
                                        type="checkbox" 
                                        id="<?php echo $value ?>" 
                                        name="<?php echo $value ?>"
                                        checked>
                                        <label for="<?php echo $value ?>"><?php echo $runame ?></label>
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
                                    <option value="<?php echo $value ?>"><?php echo $runame ?></option>
                                <?php }
                            ?>
                        </select>
                    </div>
                    <div class="orgdata__section">
                        <p>Результаты поиска:</p>
                        <button type="submit" class="orgdata__button">Показать  </button>
                    </div>
                </div>
            </form>
        </div>
  </div>
</section>





<?php get_footer(); ?>