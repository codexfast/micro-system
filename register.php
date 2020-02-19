<?php

    session_start();
    
    require_once 'config.php';
    require_once 'crud.php';
    require_once 'tools.php';

    $crud = new Crud;


    if ($_SERVER['REQUEST_METHOD'] === "POST")
    {
        if(isset($_POST['email']) && isset($_POST['phone']) && isset($_POST['password']) && isset($_POST['repassword'])  && isset($_POST['address']) && isset($_POST['name']))
        {
            $email = $_POST['email'];
            $phone = $_POST['phone'];
            $password = $_POST['password'];
            $repassword = $_POST['repassword'];
            $address = $_POST['address'];
            $name = $_POST['name'];


            {

                // Simple validation
                
                if ($password !== $repassword)
                {
                    $_SESSION['REGISTER_ERROR']  = "Campo senha e repita senha não coencidem";
                }

                if ($has = $crud->has_user($email))
                {
                    $_SESSION['REGISTER_ERROR']  = "E-mail já cadastrado";
                }
            }

            $token = md5(uniqid(rand(), true));

            if(!$has)
            {
                if ($crud->register($name, $password, $email, $phone, $address, $token))
                {
                    $_SESSION['client_on']  = "true";
                    $_SESSION['client_token']  = $token;
                    $_SESSION['client_greating'] = "true";

                    redirect(BASE_URL);
                }
            }

        }
    }

    if (isset($_SESSION['REGISTER_ERROR']))
    {
        $message = $_SESSION['REGISTER_ERROR'];
        
        unset($_SESSION['REGISTER_ERROR']);
    }

    require __DIR__ . '/layout/bootstrap.register-client.php';

?>
