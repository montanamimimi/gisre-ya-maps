<?php 

/**
 * @package GisreYaMaps
 */

class GisreYaMapsPluginDeactivate {

    public static function deactivate() {        
        flush_rewrite_rules();
    }

}
