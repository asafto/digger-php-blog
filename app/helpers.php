<?php

require_once 'db_config.php';

if ( ! function_exists('old') ) {
    /*
     * Keeping previous input value
     * 
     * @param string $fn input name
     * @param...
     * @return string 
     */
    function old($fn){
        return $_REQUEST[$fn] ?? '';
    }
     
}
