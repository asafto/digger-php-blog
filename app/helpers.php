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

if ( !function_exists('validate_image') ) {

    function validate_image($files) {
        
        $valid = false;
        $max_size = 1024 * 1024 * 5;
        $ex = ['png', 'jpeg', 'jpg', 'gif', 'bmp'];

        if ( $files['image']['size'] <= $max_size ) {
           
            $file_info = pathinfo($files['image']['name']);
            if( in_array(strtolower($file_info['extension']), $ex) ) {
                
                if (is_uploaded_file($files['image']['tmp_name'])) {
                    
                    $valid = true;
                    
                }
                
            }
            
        }

        return $valid;
    }
    
}
if (! function_exists('str_rand')) {
    function str_rand($len = 30){

        $chars = '0123456789ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz';
        $str_random = '';
        $max = strlen($chars) - 1;
      
        for( $x = 0; $x < $len; $x++ ){
      
          $str_random .= $chars[rand(0, $max)];
      
        }
      
        return $str_random;
    }      
}
