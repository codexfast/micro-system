<?php

session_start();

    require_once 'crud.php';
    require_once 'tools.php';
    require_once 'config.php';

    if (!isset($_SESSION['admin_on']))
    {
        redirect(BASE_URL);
    }

    $crud = new Crud;

    // var_dump($_GET);
    // exit();

    if (isset($_GET['id']))
    {
        $id = $_GET['id'];

        $crud->delete_product_by_id($id);
        redirect($_SERVER['HTTP_REFERER']);

    } else {
        redirect(BASE_URL);
    }

?>