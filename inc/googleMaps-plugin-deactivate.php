<?php
/**
 * @package GooglePlugin
 */

class ClassCustomMapDeactivate{
    public static function deactivate(){
        flush_rewrite_rules();
    }
}