<?php

    session_start();

    require_once 'crud.php';
    require_once 'tools.php';
    require_once 'config.php';

    $crud = new Crud;

    if (!isset($_SESSION['client_on']) || !isset($_POST['product_id'])) {
        redirect(BASE_URL);
    }
    
    $product_id = $_POST['product_id'];

    foreach($product_id as $id)
        $crud->pay($_SESSION['client_token'], $id);


    redirect(BASE_URL . '/?buy=true');