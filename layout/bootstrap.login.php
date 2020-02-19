<?php require_once 'config.php';?>

<!doctype html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <title>Login</title>


    <!-- Bootstrap core CSS -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css" integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">

    <meta name="theme-color" content="#563d7c">


    <style>
        html,

        body {
        height: 100%;
        }

        body {
        display: -ms-flexbox;
        display: flex;
        -ms-flex-align: center;
        align-items: center;
        padding-top: 40px;
        padding-bottom: 40px;
        background-color: #f5f5f5;
        }

        .form-signin {
        width: 100%;
        max-width: 330px;
        padding: 15px;
        margin: auto;
        }
        .form-signin .checkbox {
        font-weight: 400;
        }
        .form-signin .form-control {
        position: relative;
        box-sizing: border-box;
        height: auto;
        padding: 10px;
        font-size: 16px;
        }
        .form-signin .form-control:focus {
        z-index: 2;
        }
        .form-signin input[type="email"] {
        margin-bottom: -1px;
        border-bottom-right-radius: 0;
        border-bottom-left-radius: 0;
        }
        .form-signin input[type="password"] {
        margin-bottom: 10px;
        border-top-left-radius: 0;
        border-top-right-radius: 0;
        }
      .bd-placeholder-img {
        font-size: 1.125rem;
        text-anchor: middle;
        -webkit-user-select: none;
        -moz-user-select: none;
        -ms-user-select: none;
        user-select: none;
      }

      @media (min-width: 768px) {
        .bd-placeholder-img-lg {
          font-size: 3.5rem;
        }
      }

    </style>

  </head>
  <body class="text-center">
    <form class="form-signin" method="POST">
        <img class="mb-4" src="<?=BASE_URL?>/layout/assets/<?= isset($icon) ? $icon : 'main-icon.png' ?>" alt="" width="72" height="72">


        <h1 class="h3 mb-3 font-weight-normal"><?= isset($custom_form_title) ?$custom_form_title: 'Área de Login' ?></h1>

        <?php

          if (isset($message))
          {
        ?>

        <div class="alert alert-warning" role="alert">
          <?= $message?>
        </div>

        <?php }?>
        
        <div></div>
        <label for="inputEmail" class="sr-only">E-mail</label>
        <input type="email" id="inputEmail" class="form-control" placeholder="E-mail" required autofocus name="email">
        
        <label for="inputPassword" class="sr-only">Senha</label>
        <input type="password" id="inputPassword" class="form-control" placeholder="Senha" required name="password">

        <button class="btn btn-lg btn-primary btn-block" type="submit">Login</button>

        <?php

          $cad_btn = '<hr><a class="btn btn-lg btn-secondary btn-block text-light" href="'.BASE_URL.'/register.php">Cadastrar</a>';

          if (!isset($has_cad))
          {
            echo $cad_btn;
          } else {
            if ($has_cad)
            {
              echo $cad_btn;
            }
          }
        ?>
    </form>
  </body>
</html>
