<?php
    require_once 'crud.php';
    require_once 'tools.php';
    require_once 'config.php';
    
    $crud = new Crud;

    session_start();

    if ($_SERVER['REQUEST_METHOD'] === "POST")
    {
        if(isset($_POST['email']) && isset($_POST['password']))
        {
            $email = $_POST['email'];
            $password = $_POST['password'];

            if ($crud->has_user($email))
            {
                if($client_token = $crud->is_user($email, $password))
                {
                    $_SESSION['client_on'] = true;
                    $_SESSION['client_token'] = $client_token;

                    redirect(BASE_URL);
                } else {
                    $_SESSION['CLIENT_ERROR'] = "Senha ou Usuário Incorretos";
                }
            } else {
                $_SESSION['CLIENT_ERROR'] = "Não há esse usuario";
            }


        }
    }



    // if (!isset($_SESSION['client_on'])) {

    //     redirect(BASE_URL . '/login.php');
    // }

    $logged = isset($_SESSION['client_on']);
    
    if ($logged)
    {
      $user = $crud->get_client_by_token($_SESSION['client_token']);
    }

    $products = $crud->all_product();
    
    ?>



<!doctype html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <title>Micro Loja</title>


    <!-- Bootstrap core CSS -->
    <link href="https://getbootstrap.com/docs/4.4/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
    <link href="<?=BASE_URL?>/vendor/needim/noty/lib/noty.css" rel="stylesheet">
    
    <script src="<?=BASE_URL?>/vendor/needim/noty/lib/noty.js" type="text/javascript"></script>

    <meta name="theme-color" content="#563d7c">

    <script>
      const BASE_URL = "<?=BASE_URL?>";
    </script>

    <style>
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
    <!-- Custom styles for this template -->

  </head>
  <body>

<nav class="navbar navbar-expand-lg navbar-light bg-light bg-white border-bottom shadow-sm fixed-top">
  <div class="container">
  <a class="navbar-brand" href="<?=BASE_URL?>">SMARTS</a>
  <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
    <span class="navbar-toggler-icon"></span>
  </button>
  <div class="collapse navbar-collapse" id="navbarNav">
    <ul class="navbar-nav ml-auto">

    <?php 
    if ($logged):
    ?>

    <li class="nav-item">
      <a class="nav-link text-muted mr-1" href="<?=BASE_URL?>/cart.php" id="go_cart"><i class="fa fa-shopping-cart"></i> Cart <span class="badge badge-dark" id="badge-cart">0</span></a>
    </li>
    <li class="nav-item mr-2">
        <a class="nav-link text-muted" href="<?=BASE_URL?>/settings.php"> <i class="fa fa-cog mr-1"></i>Settings </a>
    </li>
    <li class="nav-item">
        <a class="btn btn-outline-primary" href="<?=BASE_URL?>/logout.php"></i>Log Out</a>
    </li>

    <?php 
      else:
    ?>

    <li class="nav-item mr-2">
      <a class="nav-link text-muted mr-1" href="<?=BASE_URL?>/cart.php" id="go_cart"><i class="fa fa-shopping-cart"></i> Cart <span class="badge badge-dark" id="badge-cart">0</span></a>
    </li>
    <li class="nav-item">
        <a class="btn btn-outline-primary" href="<?=BASE_URL?>/login.php"></i>Log In</a>
    </li>
    <?php 
      endif;
    ?>

    </ul>
  </div>
  </div>
</nav>

<div class="p-4"></div>
<?php

  if (isset($_GET['buy']))
  {
  
?>
<div class="container mt-5">
  <div class="alert alert-success" role="alert">
  <h4 class="alert-heading">Compra fake efetuada</h4>
  <p>Finja que foi efetuada uma compra e irá chegar em sua moradia</p>
  <hr>
  <p class="mb-0">Talvez na proxima atualização irei implementar o modo sandbox do mercado pago</p>
</div>
<?php 
  } 
?>
</div>
<div class="pricing-header px-3 py-3 pt-md-5 pb-md-4 mx-auto text-center">
  <h1 class="display-4">Micro loja</h1>
  <p class="lead container">Desfrute da variedade e faça uma compra agora mesmo, sem enrolação sem burocracia!</p>
</div>

<div class="container">
  
    <div class="row">
      <?php
      
      foreach ($products as $product){
      ?>
      <div class="card mb-4 shadow-sm col-md-4">
        <div class="card-header">
          <h4 class="my-0 font-weight-normal text-center"><?=$product->name?></h4>
        </div>
        <div class="card-body">
          <h1 class="card-title pricing-card-title text-center"> <small class="text-muted">R$</small> <?=replace_dot($product->price)?></h1>
          <p class="container text-justify" style="min-height: 100px;"><?=$product->description?></p>
          <button class="btn btn-lg btn-block btn-primary text-light" id="add_cart" data-id="<?=$product->id?>"><i class="fa fa-cart-plus mr-1"></i>ADD</button>
        </div>
      </div>
      <?php }?>
   
    </div>
  <footer class="pt-4 my-md-5 pt-md-5 border-top">
    <div class="row">
      <div class="col-12 col-md">

        <small class="d-block mb-3 text-muted">&copy; 2020</small>
      </div>

    </div>
  </footer>
</div>
  <script src="https://code.jquery.com/jquery-3.4.1.slim.min.js" integrity="sha384-J6qa4849blE2+poT4WnyKhv5vZF5SrPo0iEjwBvKU7imGFAV0wwj1yYfoRSJoZ+n" crossorigin="anonymous"></script>
  <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js" integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo" crossorigin="anonymous"></script>
  <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js" integrity="sha384-wfSDF2E50Y2D1uUdj0O3uMBJnjuUD4Ih7YwaYd1iqfktj0Uod8GCExl3Og8ifwB6" crossorigin="anonymous"></script>
  <script src="<?=BASE_URL?>/js/index.js"></script>
</body>
</html>
