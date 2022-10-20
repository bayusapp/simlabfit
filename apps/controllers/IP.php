<?php

class IP extends CI_Controller {
    
    public function index() {
        ob_start();
    system('getmac');
    $Content = ob_get_contents();
    ob_clean();
    echo substr($Content, strpos($Content,'\\')-20, 17);
    }
}