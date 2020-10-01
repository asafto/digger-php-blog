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

if ( !function_exists('email_exist') ) {

    function email_exist($link, $email) {
        $exists = false;
        $sql = "SELECT email FROM users WHERE email = '$email'";
        $result = mysqli_query($link, $sql);
        if ( $result && mysqli_num_rows($result) > 0 ) {
            $exists = true;
        }

        return $exists;
    }
    
}
