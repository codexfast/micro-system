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