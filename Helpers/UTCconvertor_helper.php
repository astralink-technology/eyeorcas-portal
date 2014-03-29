<?php
/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 * 
 */

/*
 * A helper to convert any timestamp to UTC Format
 */

class cp_UTCconvertor_helper{
    function setDefaultUTC(){
        //set all the timezone to UTC
        date_default_timezone_set('UTC');
    }
    function getCurrentDateTime(){
        $this->setDefaultUTC();
        //get local time
        $localtime =  localtime(time(), true);
        $formatlocaltime = ($localtime['tm_year'] + 1900) . "-" . ($localtime['tm_mon'] + 1) . "-" . $localtime['tm_mday'] . " " . $localtime['tm_hour'] . ":" . $localtime['tm_min'] . ":" . $localtime['tm_sec'];
        
        return $formatlocaltime;
    }
}
 
?>

