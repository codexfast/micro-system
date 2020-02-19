<?php
    require 'tools.php';
    require 'config.php';

    logout();
    
    $referer = $_SERVER['HTTP_REFERER'];

    redirect(isset($referer) ? $referer : BASE_URL);