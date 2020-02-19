<?php
    require_once 'crud.php';
    require_once 'tools.php';
    require_once 'config.php';
    
    $crud = new Crud;

    session_start();
    
    if ($_SERVER['REQUEST_METHOD'] === "POST")
    {
        if(isset($_POST['email']) && isset($_POST['address']) && isset($_POST['name']) && isset($_POST['phone']))
        {
            $email = $_POST['email'];
            $address = $_POST['address'];
            $name = $_POST['name'];
            $phone = $_POST['phone'];
            $client_token = $_SESSION['client_token'];

            $crud->update_client_by_token($client_token, [
                'email' => $email,
                'address' => $address,
                'name' => $name,
                'phone' => $phone,
            ]);
            
            $_SESSION['change_success'] = true;
        } else if (isset($_POST['password']) && isset($_POST['repassword']))
        {
            $password = $_POST['password'];
            $repassword = $_POST['repassword'];
            $client_token = $_SESSION['client_token'];

            if ($password === $repassword)
            {
                $crud->update_client_by_token($client_token, [
                    'password' => password_hash($password, PASSWORD_DEFAULT)
                ]);

                $_SESSION['change_success'] = true;
            } else {
                $_SESSION['change_success'] = false;

            }

            
        }
    }

    if (!isset($_SESSION['client_on'])) {
        redirect(BASE_URL);
    }

    $user = $crud->get_client_by_token($_SESSION['client_token']);
?>

<!doctype html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="Mark Otto, Jacob Thornton, and Bootstrap contributors">
    <meta name="generator" content="Jekyll v3.8.6">
    <title>Settings - <?= $user->name?></title>

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
  <a class="btn btn-link text-muted" href="<?=BASE_URL?>">home</a>

  <a class="btn btn-outline-primary" href="<?=BASE_URL?>/logout.php">Logout</a>
</div>


<div class="container">
      <?php
        if (isset($_SESSION['change_success']))
        {
            

            if ($_SESSION['change_success']) {

      ?>
      <div class="alert alert-success" role="alert">
        Mudanças feitas com successo
        </div>
      <?php } else {?>
        <div class="alert alert-danger" role="alert">
        Erro ao fazer mudanças
        </div>
    <?php

      }}
      unset($_SESSION['change_success']);
      ?>
  <h5 class="mb-3">Dados</h5>
<form method="POST">
  <div class="form-group">
    <label for="name">Nome</label>
    <input type="text" class="form-control" id="name" aria-describedby="emailHelp" name="name" value="<?=$user->name?>" required>
  </div>
  

  <div class="form-group">
    <label for="email">E-mail</label>
    <input type="email" class="form-control" id="email" name="email" value="<?=$user->email?>" required>
  </div>

  <div class="form-group">
    <label for="email">Telefone</label>
    <input type="tel" class="form-control" id="phone" pattern="[0-9]+" name="phone" value="<?=$user->phone?>" required>
  </div>

  <div class="form-group">
    <label for="address">Endereço</label>
    <input type="text" class="form-control" id="address" name="address" value="<?=$user->address?>" required>
  </div>

  <button type="submit" class="btn btn-primary">Atualizar</button>
</form>
<hr class="py-4">
<h5 class="mb-3">Senha</h5>

<form class="mb-5" method="POST">

  <div class="form-group">
    <label for="password">Nova senha</label>
    <input type="password" class="form-control" id="password" name="password" required>
  </div>

  <div class="form-group">
    <label for="repassword">Repita nova senha</label>
    <input type="password" class="form-control" id="repassword" name="repassword" required>
  </div>

  <button type="submit" class="btn btn-primary">Atualizar</button>
</form>
   
</div>

</div>
</body>
</html>
