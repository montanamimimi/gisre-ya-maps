<?php

/*
  Plugin Name: Gis Objects on maps
  Version: 1.0
  Author: montana_mimimi
  Author URI: https://github.com/montanamimimi/
*/

if( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly
require_once plugin_dir_path(__FILE__) . 'inc/generateObject.php';
require_once(ABSPATH . 'wp-admin/includes/media.php');
require_once(ABSPATH . 'wp-admin/includes/file.php');
require_once(ABSPATH . 'wp-admin/includes/image.php');


class GisObjectsMapsPlugin {
  function __construct() {
    global $wpdb;
    $this->tablename = $wpdb->prefix . "reomap";
    $this->orgstable = $wpdb->prefix . "orgdata";
    $this->geotable = $wpdb->prefix . "geodata";
    $this->create_post_type();

    add_action('wp_enqueue_scripts', array($this, 'loadAssets'));    
    add_action('admin_post_createobject', array($this, 'createObject'));
    add_action('admin_post_nopriv_createobject', array($this, 'createObject'));
    add_action('admin_post_createorg', array($this, 'createOrg'));
    add_action('admin_post_nopriv_createorg', array($this, 'createOrg'));
    add_action('admin_post_deleteobject', array($this, 'deleteObject'));
    add_action('admin_post_deleteorg', array($this, 'deleteOrg'));
    add_action('admin_post_deletegeodata', array($this, 'deleteGeoItem'));
    add_action('admin_post_nopriv_deleteobject', array($this, 'deleteObject'));
    add_action('admin_post_editobject', array($this, 'editObject'));
    add_action('admin_post_nopriv_editobject', array($this, 'editObject'));
    add_filter('template_include', array($this, 'loadTemplate'), 99);
    add_filter('wp_nav_menu_items', [ $this, 'menuItems' ], 10, 2 );
    add_filter( 'widget_text', 'do_shortcode' );
  }

  protected function create_post_type() {
    add_action( 'init', array( $this, 'custom_post_type'));
  }

  function menuItems( $items, $args ) {

    if ( 'headerMenuLocation' === $args->theme_location ) {


      if( is_user_logged_in() ) {
 
        $user = wp_get_current_user();
     
        $roles = ( array ) $user->roles;
     
        if ($roles[0] == 'administrator') {
           $items      .= "<li class='menu-item item__cases'><a href='" . home_url() . "/gis-objects'>АДМИН</a></li>";
        }
     
      } 

		}

		return $items;

  }

  function custom_post_type() {
    register_post_type( 'ymap', [
      'public' => true, 
      'label' => 'YMaps',
      'menu_icon' => 'dashicons-location-alt',
      'show_in_rest' => true,
    ]);
  }

  function activate() {
    require_once plugin_dir_path( __FILE__) . 'inc/gisre-ya-maps-plugin-activate.php';
    GisreYaMapsActivate::activate();
  }

  function deactivate() {
    require_once plugin_dir_path( __FILE__) . 'inc/gisre-ya-maps-plugin-deactivate.php';
    GisreYaMapsPluginDeactivate::deactivate();
  }


  function editObject() {
    if (current_user_can('administrator')) {

      $id = sanitize_text_field($_POST['idtoedit']);

      $date = getdate();
      $date = date( 'Y-m-d H:i:s', $date[0] );    
      $image_id = '';

      if (isset($_FILES['picture'])){

        $uploaded_file = $_FILES['picture'];

        if ($uploaded_file['size']) {
          $upload_overrides = array( 'test_form' => false );
          $movefile = wp_handle_upload( $uploaded_file, $upload_overrides );
          if ( $movefile && ! isset( $movefile['error'] ) ) {
         
  
              $url  = $movefile['url'];
  
              $src = media_sideload_image( $url, null, null, 'src' );
              $image_id = attachment_url_to_postid( $src );
      
          } 
        } else if (isset($_POST['oldpicture'])) {
          $image_id = (int) $_POST['oldpicture'];
        } else if (isset($_POST['reloadpicture'])) {
          $src = media_sideload_image( $_POST['reloadpicture'], null, null, 'src' );
          $image_id = attachment_url_to_postid( $src );
        }

      } 

      $newdata = array (
        "name" => sanitize_text_field($_POST['objectname']),
        "type" => sanitize_text_field($_POST['objecttype']),
        "lat" => floatval($_POST['lat']),
        "lon" => floatval($_POST['lon']),
        "location" => sanitize_text_field($_POST['location']),
        'power' => $_POST['power'],
        "powerpr" => sanitize_text_field($_POST['powerpr']),
        "status" => sanitize_text_field($_POST['status']),
        "year" => sanitize_text_field($_POST['year']),
        "function" => sanitize_text_field($_POST['function']),
        "holder" => sanitize_text_field($_POST['holder']),
        "source" => sanitize_text_field($_POST['source']),
        "link" => sanitize_text_field($_POST['link']),
        "linkshort" => sanitize_text_field($_POST['linkshort']),
        "picture" => $image_id,
        "date" => $date,
      );
      $newdata['holder'] = str_replace('"','&quot;',$newdata['holder']);
      $newdata['holder'] = str_replace('\\','',$newdata['holder']);
      $newdata['name'] = str_replace('"','&quot;',$newdata['name']);
      $newdata['name'] = str_replace('\\','',$newdata['name']);


      if (isset($_POST['pp'])) {
        $newdata['pp'] = 1;
      } else {
        $newdata['pp'] = 0;
      }

      if (isset($_POST['gen'])) {
        $newdata['gen'] = 1;
      } else {
        $newdata['gen'] = 0;
      }

      if (isset($_POST['truthplace'])) {
        $newdata['truthplace'] = 1;
      } else {
        $newdata['truthplace'] = 0;
      }

      $object = generateObject($newdata);


      global $wpdb;
      $wpdb->delete($this->tablename, array('id' => $id));
      $wpdb->insert($this->tablename, $object);
      wp_safe_redirect(site_url('/gis-objects/'));

    } else {
      wp_safe_redirect(site_url());
    }

    exit;
  }


  function createObject() {
    if (current_user_can('administrator')) {

      $date = getdate();
      $date = date( 'Y-m-d H:i:s', $date[0] );     

      $image_id = '';


      if (isset($_FILES['picture'])){

        $uploaded_file = $_FILES['picture'];
        $upload_overrides = array( 'test_form' => false );
        $movefile = wp_handle_upload( $uploaded_file, $upload_overrides );
        if ( $movefile && ! isset( $movefile['error'] ) ) {
            // The file was uploaded successfully, do something with the $movefile array

            $url  = $movefile['url'];

            $src = media_sideload_image( $url, null, null, 'src' );
            $image_id = attachment_url_to_postid( $src );
    
        } else {
            $image_id = '';
        }

      }

      $newdata = array (
        "name" => sanitize_text_field($_POST['objectname']),
        "type" => sanitize_text_field($_POST['objecttype']),
        "lat" => floatval($_POST['lat']),
        "lon" => floatval($_POST['lon']),
        "status" => sanitize_text_field($_POST['status']),
        "function" => sanitize_text_field($_POST['function']),
        "picture" => $image_id,
        "date" => $date,
        "location" => sanitize_text_field($_POST['location']),
        'power' => $_POST['power'],
        "powerpr" => sanitize_text_field($_POST['powerpr']),
        "year" => sanitize_text_field($_POST['year']),
        "holder" => sanitize_text_field($_POST['holder']),
        "source" => sanitize_text_field($_POST['source']),
        "link" => sanitize_text_field($_POST['link']),
        "linkshort" => sanitize_text_field($_POST['linkshort']),
      );

      $newdata['holder'] = str_replace('"','&quot;',$newdata['holder']);
      $newdata['holder'] = str_replace('\\','',$newdata['holder']);
      $newdata['name'] = str_replace('"','&quot;',$newdata['name']);
      $newdata['name'] = str_replace('\\','',$newdata['name']);

      if (isset($_POST['pp'])) {
        $newdata['pp'] = 1;
      } else {
        $newdata['pp'] = 0;
      }

      if (isset($_POST['gen'])) {
        $newdata['gen'] = 1;
      } else {
        $newdata['gen'] = 0;
      }

      if (isset($_POST['truthplace'])) {
        $newdata['truthplace'] = 1;
      } else {
        $newdata['truthplace'] = 0;
      }

      $object = generateObject($newdata);

      global $wpdb;
      $wpdb->insert($this->tablename, $object);
      wp_safe_redirect(site_url('/gis-objects/'));

    } else {
      wp_safe_redirect(site_url());
    }

    exit;
  }

  function createOrg() {
    if (current_user_can('administrator')) {

      $newdata = array (
        "name" => sanitize_text_field($_POST['orgname']),
        "region" => sanitize_text_field($_POST['region']),
        "lat" => floatval($_POST['lat']),
        "lon" => floatval($_POST['lon']),
        "adress" => sanitize_text_field($_POST['adress']),
        "country" => sanitize_text_field($_POST['country']),
        "city" => sanitize_text_field($_POST['city']),
        "type_number" => sanitize_text_field($_POST['type_number']),
        "type" => sanitize_text_field($_POST['type']),
        "phone" => sanitize_text_field($_POST['phone']),
        "email" => sanitize_text_field($_POST['email']),
        "link" => sanitize_text_field($_POST['link']),
      );

      $newdata['name'] = str_replace('"','&quot;',$newdata['name']);
      $newdata['name'] = str_replace('\\','',$newdata['name']);

      $typesList = array('sune', 'sunt', 'wind', 'bio', 'gidro', 'geo', 'pri', 'tn');

      foreach ($typesList as $item) {
        if (isset($_POST[$item])) {
          $newdata[$item] = 1;
        } else {
          $newdata[$item] = 0;
        }
      }

      $newdata['published'] = 1;
      global $wpdb;

      if (isset($_POST['org_id'])) {
        $id = (int) $_POST['org_id'];
        $wpdb->delete($this->orgstable, array('id' => $id));
      }


      $wpdb->insert($this->orgstable, $newdata);
      wp_safe_redirect(site_url('/organizations/'));

    } else {
      wp_safe_redirect(site_url());
    }

    exit;
  }

  function deleteObject() {
    if (current_user_can('administrator')) {
     
      $id = sanitize_text_field($_POST['idtodelete']);
      global $wpdb;
      $wpdb->delete($this->tablename, array('id' => $id));
      wp_safe_redirect(site_url('/gis-objects/'));

    } else {
      wp_safe_redirect(site_url());
    }

    exit;
  }

  function deleteOrg() {
    if (current_user_can('administrator')) {
     
      $id = sanitize_text_field($_POST['idtodelete']);
      global $wpdb;
      $wpdb->delete($this->orgstable, array('id' => $id));
      wp_safe_redirect(site_url('/organizations/'));

    } else {
      wp_safe_redirect(site_url());
    }

    exit;
  }

  
  function deleteGeoItem() {
    if (current_user_can('administrator')) {
     
      $id = sanitize_text_field($_POST['idtodelete']);
      global $wpdb;
      $wpdb->delete($this->geotable, array('id' => $id));
      wp_safe_redirect(site_url('/editgeodata/'));

    } else {
      wp_safe_redirect(site_url());
    }

    exit;
  }

  function loadAssets() {
    wp_enqueue_style('reomapscss', plugin_dir_url(__FILE__) . 'build/index.css');
    wp_enqueue_script( 'reomapsjs', plugin_dir_url(__FILE__) . 'build/index.js', array(), null, true );
  }

  function loadTemplate($template) {
    if (is_page('gis-objects')) {
      return plugin_dir_path(__FILE__) . 'inc/template-gisobjects.php';
    } 

    if (is_page('gis-objects-map') OR is_page(1228)) {
      return plugin_dir_path(__FILE__) . 'inc/template-gisobjectsmap.php';
    } 

    if (is_page('map-sunres') OR is_page(1233)) {
      return plugin_dir_path(__FILE__) . 'inc/template-map-sunres.php';
    } 

    if (is_page('winddata') OR is_page(1237)) {
      return plugin_dir_path(__FILE__) . 'inc/template-winddata.php';
    } 

    if (is_page('geodata') OR is_page(1256)) {
      return plugin_dir_path(__FILE__) . 'inc/template-geodata.php';
    } 

    if (is_page('geomap') OR is_page(1253)) {
      return plugin_dir_path(__FILE__) . 'inc/template-geomap.php';
    } 

    if (is_page('orgmap') OR is_page(1248)) {
      return plugin_dir_path(__FILE__) . 'inc/template-orgmap.php';
    } 

    if (is_page('orgdata') OR is_page(1264)) {
      return plugin_dir_path(__FILE__) . 'inc/template-orgdata.php';
    } 

    if (is_page('mges-table') OR is_page(1260)) {
      return plugin_dir_path(__FILE__) . 'inc/template-mgesdata.php';
    } 

    if (is_page('newobject')) {
      return plugin_dir_path(__FILE__) . 'inc/template-newobject.php';
    } 

    if (is_page('neworg')) {
      return plugin_dir_path(__FILE__) . 'inc/template-neworg.php';
    } 

    if (is_page('newgeodata')) {
      return plugin_dir_path(__FILE__) . 'inc/template-newgeodata.php';
    } 

    if (is_page('editobject')) {
      return plugin_dir_path(__FILE__) . 'inc/template-editobject.php';
    } 

    if (is_page('editorg')) {
      return plugin_dir_path(__FILE__) . 'inc/template-editorg.php';
    } 

    if (is_page('organizations')) {
      return plugin_dir_path(__FILE__) . 'inc/template-organizations.php';
    } 

    if (is_page('editgeodata')) {
      return plugin_dir_path(__FILE__) . 'inc/template-editgeodata.php';
    } 

    return $template;
  }

}

$gisObjectsMapsPlugin = new GisObjectsMapsPlugin();


function gisre_get_one_object($id) {
  global $wpdb;
  $tablename = $wpdb->prefix . 'reomap';

  $query = "SELECT * FROM $tablename WHERE id = '%d'";

  $out = $wpdb->get_results($wpdb->prepare($query, array(
    $id
  )));

  if (isset($out[0])){
    $res = $out[0];
  } else {
    $res = false;
  }

  return $res;
}

function gisre_get_one_org($id) {
  global $wpdb;
  $tablename = $wpdb->prefix . 'orgdata';

  $query = "SELECT * FROM $tablename WHERE id = '%d'";

  $out = $wpdb->get_results($wpdb->prepare($query, array(
    $id
  )));

  if (isset($out[0])){
    $res = $out[0];
  } else {
    $res = false;
  }

  return $res;
}