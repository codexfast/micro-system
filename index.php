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

    if (isset($_SESSION['CLIENT_ERROR']))
    {
        $message = $_SESSION['CLIENT_ERROR'];
        
        unset($_SESSION['CLIENT_ERROR']);
    }

    if (!isset($_SESSION['client_on'])) {

        require __DIR__ . '/layout/bootstrap.login.php';
        exit;
    }

    $user = $crud->get_client_by_token($_SESSION['client_token']);
    $products = $crud->all_product();
    
    ?>



<!doctype html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="Mark Otto, Jacob Thornton, and Bootstrap contributors">
    <meta name="generator" content="Jekyll v3.8.6">
    <title>Micro Loja</title>

    <link rel="canonical" href="https://getbootstrap.com/docs/4.4/examples/pricing/">

    <!-- Bootstrap core CSS -->
<link href="https://getbootstrap.com/docs/4.4/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">


<meta name="theme-color" content="#563d7c">


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
    <link href="pricing.css" rel="stylesheet">
  </head>
  <body>
    <div class="d-flex flex-column flex-md-row align-items-center p-3 px-md-4 mb-3 bg-white border-bottom shadow-sm">
  <h5 class="my-0 mr-md-auto font-weight-normal"><?= $user->name?></h5>
  <nav class="my-2 my-md-0 mr-md-3">

  </nav>
  <a class="btn btn-link text-muted" href="<?=BASE_URL?>/settings.php">settings</a>

  <a class="btn btn-outline-primary" href="<?=BASE_URL?>/logout.php">Logout</a>
</div>

<?php

  if (isset($_GET['buy']))
  {
  
?>
<div class="container">
  <div class="alert alert-success" role="alert">
  <h4 class="alert-heading">Compra fake efetuada</h4>
  <p>Finja que foi efetuada uma compra e irá chegar em sua moradia</p>
  <hr>
  <p class="mb-0">Talvez na proxima atualização irei implementar o modo sandbox do mercado pago</p>
</div>
<?php } ?>
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
          <h1 class="card-title pricing-card-title text-center"> <small class="text-muted">R$</small> <?=str_replace('.', ',', $product->price)?></h1>
          <p class="container" style="min-height: 100px;"><?=$product->description?></p>
          <a class="btn btn-lg btn-block btn-primary text-light" href="<?=BASE_URL?>/buy.php?id=<?=$product->id?>">Comprar</a>
        </div>
      </div>
      <?php }?>
   
    </div>
  <footer class="pt-4 my-md-5 pt-md-5 border-top">
    <div class="row">
      <div class="col-12 col-md">

        <small class="d-block mb-3 text-muted">&copy; 2017-2019</small>
      </div>

    </div>
  </footer>
</div>
</body>
</html>
