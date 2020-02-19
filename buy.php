<?php

    session_start();

    require 'crud.php';
    require 'tools.php';
    require 'config.php';

    $crud = new Crud;

    if (!isset($_SESSION['client_on']) || !isset($_GET['id'])) {
        redirect(BASE_URL);
    }
    
    $id = $_GET['id'];

    $crud->pay($_SESSION['client_token'], $id);


    redirect(BASE_URL . '/?buy=true');