<?php
    session_start();

    require_once 'crud.php';
    require_once 'tools.php';
    require_once 'config.php';
    
    $crud = new Crud;
    $c=[];

    $logged = isset($_SESSION['client_on']);

    if (!$logged) {

        redirect(BASE_URL + '/login.php');
    }

    if (!isset($_GET['cart']))
    {
        redirect(BASE_URL);
    }

    if (!$cart = base64_decode($_GET['cart']))
    {
        redirect(BASE_URL);
    }

    $cart = json_decode($cart, true);

    foreach($cart as $id)
    {
       $c[] = $crud->get_product_by_id($id);
    }

    print_r($c);

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
  <a class="navbar-brand" href="#">SMARTS</a>
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

</div>
<div class="pricing-header px-3 py-3 pt-md-5 pb-md-4 mx-auto text-center">
  <h2 class="display-4">Carrinho</h2>
  <!-- <p class="lead container">Desfrute da variedade e faça uma compra agora mesmo, sem enrolação sem burocracia!</p> -->
</div>

<div class="container">
<div class="accordion" id="accordionExample">
  <div class="card">
    <div class="card-header" id="headingOne">
      <h2 class="mb-0">
        <button class="btn btn-link" type="button" data-toggle="collapse" data-target="#collapseOne" aria-expanded="true" aria-controls="collapseOne">
          Collapsible Group Item #1
        </button>
      </h2>
    </div>

    <div id="collapseOne" class="collapse show" aria-labelledby="headingOne" data-parent="#accordionExample">
      <div class="card-body">
        Anim pariatur cliche reprehenderit, enim eiusmod high life accusamus terry richardson ad squid. 3 wolf moon officia aute, non cupidatat skateboard dolor brunch. Food truck quinoa nesciunt laborum eiusmod. Brunch 3 wolf moon tempor, sunt aliqua put a bird on it squid single-origin coffee nulla assumenda shoreditch et. Nihil anim keffiyeh helvetica, craft beer labore wes anderson cred nesciunt sapiente ea proident. Ad vegan excepteur butcher vice lomo. Leggings occaecat craft beer farm-to-table, raw denim aesthetic synth nesciunt you probably haven't heard of them accusamus labore sustainable VHS.
      </div>
    </div>
  </div>
  <div class="card">
    <div class="card-header" id="headingTwo">
      <h2 class="mb-0">
        <button class="btn btn-link collapsed" type="button" data-toggle="collapse" data-target="#collapseTwo" aria-expanded="false" aria-controls="collapseTwo">
          Collapsible Group Item #2
        </button>
      </h2>
    </div>
    <div id="collapseTwo" class="collapse" aria-labelledby="headingTwo" data-parent="#accordionExample">
      <div class="card-body">
        Anim pariatur cliche reprehenderit, enim eiusmod high life accusamus terry richardson ad squid. 3 wolf moon officia aute, non cupidatat skateboard dolor brunch. Food truck quinoa nesciunt laborum eiusmod. Brunch 3 wolf moon tempor, sunt aliqua put a bird on it squid single-origin coffee nulla assumenda shoreditch et. Nihil anim keffiyeh helvetica, craft beer labore wes anderson cred nesciunt sapiente ea proident. Ad vegan excepteur butcher vice lomo. Leggings occaecat craft beer farm-to-table, raw denim aesthetic synth nesciunt you probably haven't heard of them accusamus labore sustainable VHS.
      </div>
    </div>
  </div>
  <div class="card">
    <div class="card-header" id="headingThree">
      <h2 class="mb-0">
        <button class="btn btn-link collapsed" type="button" data-toggle="collapse" data-target="#collapseThree" aria-expanded="false" aria-controls="collapseThree">
          Collapsible Group Item #3
        </button>
      </h2>
    </div>
    <div id="collapseThree" class="collapse" aria-labelledby="headingThree" data-parent="#accordionExample">
      <div class="card-body">
        Anim pariatur cliche reprehenderit, enim eiusmod high life accusamus terry richardson ad squid. 3 wolf moon officia aute, non cupidatat skateboard dolor brunch. Food truck quinoa nesciunt laborum eiusmod. Brunch 3 wolf moon tempor, sunt aliqua put a bird on it squid single-origin coffee nulla assumenda shoreditch et. Nihil anim keffiyeh helvetica, craft beer labore wes anderson cred nesciunt sapiente ea proident. Ad vegan excepteur butcher vice lomo. Leggings occaecat craft beer farm-to-table, raw denim aesthetic synth nesciunt you probably haven't heard of them accusamus labore sustainable VHS.
      </div>
    </div>
  </div>
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