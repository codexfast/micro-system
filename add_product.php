<?php

    session_start();

    require_once 'crud.php';
    require_once 'tools.php';
    require_once 'config.php';

    $crud = new Crud;

    if (!isset($_SESSION['admin_on']))
    {
        redirect(BASE_URL);
    }

    if ($_SERVER['REQUEST_METHOD'] === "POST") {
        if (isset($_POST['name_product']) && isset($_POST['price']) && isset($_POST['price_owner']) && isset($_POST['desc_product'])){

            $name = $_POST['name_product'];
            $price = $_POST['price'];
            $price_owner = $_POST['price_owner'];
            $description = $_POST['desc_product'];

            if ($crud->add_product($name, $price, $price_owner, $description))
            {
                redirect($_SERVER['HTTP_REFERER']);
            }
        } else {
            echo "Needed params";
        }
    }

?>