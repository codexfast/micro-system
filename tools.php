<?php

    function redirect($to)
    {
        header("Location: {$to}");
        exit;
    }

    function logout ()
    {
        session_start();

        unset($_SESSION['admin_on']);
        unset($_SESSION['client_on']);
    }

    function env(String $env_ref, String $default = null) : String
    {
       return (isset($_ENV[$env_ref])) ? $_ENV[$env_ref] : $default;
    }