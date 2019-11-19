<?php
/**
 * @package GooglePlugin
 */

class ClassCustomMapActivate{
    public static function activate(){
        flush_rewrite_rules();
    }
}
 