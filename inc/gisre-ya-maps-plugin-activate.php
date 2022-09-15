<?php 

/**
 * @package GisreYaMaps
 */

class GisreYaMapsPluginActivate {

    public static function activate() {        
        flush_rewrite_rules();
    }

}
