<?php

require_once $_SERVER['DOCUMENT_ROOT'] . '/Libraries/password_compat/lib/password.php';

/*
 * Copyright Chilli Panda
 * Created on 03-05-2013
 * Created by Shi Wei Eamon
 */

/*
 * A helper on encryption
 */
class cp_encryption_helper{
    public function generateSalt(){
        $keycode = "ch1ll1pandaw1llrul3th3w0rld0n3dybdefgijkmoqrstuvwxyzABCDEFGHIJKLMNOPQRSTUWXYZ23456789";
        $salt = array(); //remember to declare $pass as an array
        $saltgenerator = strlen($keycode) - 1; //put the length -1 in cache
        for ($i = 0; $i < 16; $i++) {
            $n = rand(0, $saltgenerator);
            $salt[] = $keycode[$n];
        }
        return implode($salt); //convert to string
    }
    
    public function hash($string, $salt = null){
        if ($salt == null){
            //new hashing method.
            $hash = password_hash($string, PASSWORD_BCRYPT, array("cost" => 10));
        }else{
            $hash = crypt($string, '$2y$10$' . $salt . '$');
        }
        return $hash;
    }

    public function verify($password, $hash){
        return password_verify($password, $hash);
    }
}
 
?>

