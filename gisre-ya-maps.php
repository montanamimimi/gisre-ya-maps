<?php

/*
  Plugin Name: Gis Objects on maps
  Version: 1.0
  Author: montana_mimimi
  Author URI: https://github.com/montanamimimi/
*/

if( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly
require_once plugin_dir_path(__FILE__) . 'inc/generateObject.php';


class GisObjectsMapsPlugin {
  function __construct() {
    global $wpdb;
    $this->tablename = $wpdb->prefix . "reomap";

    add_action('wp_enqueue_scripts', array($this, 'loadAssets'));    
    add_action('admin_post_createobject', array($this, 'createObject'));
    add_action('admin_post_nopriv_createobject', array($this, 'createObject'));
    add_action('admin_post_deleteobject', array($this, 'deleteObject'));
    add_action('admin_post_nopriv_deleteobject', array($this, 'deleteObject'));
    add_action('admin_post_editobject', array($this, 'editObject'));
    add_action('admin_post_nopriv_editobject', array($this, 'editObject'));
    add_filter('template_include', array($this, 'loadTemplate'), 99);
  }

  function editObject() {
    if (current_user_can('administrator')) {

      $id = sanitize_text_field($_POST['idtoedit']);

      if ($_POST['date']) {
        $date = $_POST['date'];
      } else {
        $date = getdate();
        $date = date( 'Y-m-d H:i:s', $date[0] );     
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
        "picture" => sanitize_text_field($_POST['picture']),
        "date" => $date,
        'pp' => intval($_POST['pp']),
        'gen' => intval($_POST['gen']),
        'truthplace' => intval($_POST['truthplace'])
      );

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

      if ($_POST['date']) {
        $date = $_POST['date'];
      } else {
        $date = getdate();
        $date = date( 'Y-m-d H:i:s', $date[0] );     
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
        "picture" => sanitize_text_field($_POST['picture']),
        "date" => $date,
        'pp' => intval($_POST['pp']),
        'gen' => intval($_POST['gen']),
        'truthplace' => intval($_POST['truthplace'])
      );

      $object = generateObject($newdata);

      global $wpdb;
      $wpdb->insert($this->tablename, $object);
      wp_safe_redirect(site_url('/gis-objects/'));

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

    return $template;
  }

}

$gisObjectsMapsPlugin = new GisObjectsMapsPlugin();