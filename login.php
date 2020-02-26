<?php
session_start();

require_once 'config.php';
require_once 'crud.php';
require_once 'tools.php';

$crud = new Crud;


if ($_SERVER['REQUEST_METHOD'] === "POST")
{
    if(isset($_POST['email']) && isset($_POST['password']) )
    {
        $email = $_POST['email'];
        $password = $_POST['password'];

        
        if($client_token = $crud->is_user($email, $password))
        {

            $_SESSION['client_on']  = "true";
            $_SESSION['client_token']  = $client_token;

            redirect(BASE_URL);
            
        } else {
            $message = "Usuário ou senha incorretos!";
        }

    }
}

if (isset($_SESSION['CLIENT_ERROR']))
{
    $message = $_SESSION['CLIENT_ERROR'];
    
    unset($_SESSION['CLIENT_ERROR']);
}

require __DIR__ . '/layout/bootstrap.login.php';
