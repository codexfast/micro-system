<?php

    include_once 'tools.php';

    // From Heroku
    define('BASE_URL', 'https://micro-system.herokuapp.com');
    
    // From localhost database
    // define('db_host', "localhost");
    // define('db_name', "micro-system");
    // define('db_username', "root");
    // define('db_password', "null");

    define('db_host', "85.10.205.173");
    define('db_name', "microsystem");
    define('db_username', "gilbertodev");
    define('db_password', "gilberto2020");
    

    trait DataBase {
        private $db_host = db_host;
        private $db_name = db_name;
        private $db_user = db_username;
        private $db_pass = db_password;
    }

?>