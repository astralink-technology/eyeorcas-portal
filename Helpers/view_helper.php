<?php
/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 * 
 */

/*
 * A helper to render a view from a file
 */
class cp_view_helper{
    function render($file, $variables = array()) {
        if ($variables == null){
        }else{
            extract($variables);
        }
        ob_start(); 
        include $file;
        $renderedView = ob_get_clean();

        return $renderedView;
    }
}
?>

