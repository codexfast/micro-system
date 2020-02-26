<?php

    session_start();

    require_once 'crud.php';
    require_once 'tools.php';
    require_once 'config.php';

    $crud = new Crud;

    $icon = "main-icon-admin.png";
    $custom_form_title = "Admin";
    $has_cad = false;


    if ($_SERVER['REQUEST_METHOD'] === "POST")
    {
        if(isset($_POST['email']) && isset($_POST['password']))
        {
            $email = $_POST['email'];
            $password = $_POST['password'];

            if($crud->is_admin($email, $password))
            {
                $_SESSION['admin_on'] = true;

                redirect(BASE_URL.'/admin.php');
            } else {
                $_SESSION['ADMIN_ERROR'] = "Senha ou Usuário incorretos";
            }

        }
    }

    if (isset($_SESSION['ADMIN_ERROR']))
    {
        $message = $_SESSION['ADMIN_ERROR'];
        
        unset($_SESSION['ADMIN_ERROR']);
    }

    if (!isset($_SESSION['admin_on'])) {

        require __DIR__ . '/layout/bootstrap.login.php';
        exit;
    }

    $admin = $crud->get_admin();
    $products = $crud->all_product();
    $users = $crud->all_users();

    $sum = $crud->sum_payment();

    ?>

<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8" />
        <meta http-equiv="X-UA-Compatible" content="IE=edge" />
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
        <meta name="description" content="" />
        <meta name="author" content="" />
        <title>Dashboard - SB Admin</title>
        <link href="css/styles.css" rel="stylesheet" />

        
        <link href="https://cdn.datatables.net/1.10.20/css/dataTables.bootstrap4.min.css" rel="stylesheet" crossorigin="anonymous">
        
        <!-- <script src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.11.2/js/all.min.js" crossorigin="anonymous"></script> -->
        <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">

        <style>
            .card-chart i {
                position: absolute;
                right: 10px;
                top: 10px;
                color: rgba(0, 0, 0, .2);
                }

        </style>
    </head>
    <body class="sb-nav-fixed">
        <nav class="sb-topnav navbar navbar-expand navbar-dark bg-dark">
            <a class="navbar-brand" href="index.html">Admin</a><button class="btn btn-link btn-sm order-1 order-lg-0" id="sidebarToggle" href="#"><i class="fa fa-bars"></i></button
            ><!-- Navbar Search-->
            
            <!-- Navbar-->
            <ul class="navbar-nav ml-auto ">
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" id="userDropdown" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><i class="fa fa-user"></i></a>
                    <div class="dropdown-menu dropdown-menu-right" aria-labelledby="userDropdown">
 
                        <a class="dropdown-item" href="<?=BASE_URL?>/logout.php">Logout</a>
                    </div>
                </li>
            </ul>
        </nav>
        <div id="layoutSidenav">
            <div id="layoutSidenav_nav">
                <nav class="sb-sidenav accordion sb-sidenav-dark" id="sidenavAccordion">
                    <div class="sb-sidenav-menu">
                        <div class="nav">
                            <div class="sb-sidenav-menu-heading">Core</div>
                            <a class="nav-link actived" href="#"
                                ><div class="sb-nav-link-icon"><i class="fa fa-dashboard"></i></div>
                                Dashboard</a>
                                <a class="nav-link" href="#add_product"
                                ><div class="sb-nav-link-icon"><i class="fa fa-shopping-cart"></i></div>
                                Add Produtos</a>
                                <a class="nav-link" href="#product"
                                ><div class="sb-nav-link-icon"><i class="fa fa-shopping-cart"></i></div>
                                Produtos</a>
                                <a class="nav-link" href="#users"
                                ><div class="sb-nav-link-icon"><i class="fa fa-users"></i></div>
                                Usuários</a>
                                <a class="nav-link" href="<?=BASE_URL?>" target="_blank"
                                ><div class="sb-nav-link-icon"><i class="fa fa-feed"></i></div>
                                Abrir Loja</a>

                        </div>
                    </div>
                </nav>
            </div>
            <div id="layoutSidenav_content">
                <main>
                    <div class="container-fluid">

                        <h1 class="mt-4">Dashboard</h1>

                        <ol class="breadcrumb mb-4">
                            <li class="breadcrumb-item active">Dashboard</li>
                            
                        </ol>

                        <div class="row">
                            <div class="col-md-3">
                                
                                <div class="card card-chart bg-danger p-1 py-2 m-1" style="position: relative;">
                                    <div class="card-body" >
                                      <p class="card-title text-light">Usuários</p>
                                      <h3 class="card-text text-light"><?= count($users)?></h3>
                                      <i class="fa fa-4x fa-users"></i>
                                    </div>
                                  </div>
                            </div>
                            <div class="col-md-3">
                                
                                <div class="card card-chart bg-warning p-1 py-2 m-1" style="position: relative;">
                                    <div class="card-body" >
                                      <p class="card-title text-light">Produtos</p>
                                      <h3 class="card-text text-light"><?= count($products)?></h3>
                                      <i class="fa fa-4x fa-shopping-cart"></i>
                                    </div>
                                  </div>
                            </div>

                            <div class="col-md-3">
                                
                                <div class="card card-chart bg-success p-1 py-2 m-1" style="position: relative;">
                                    <div class="card-body" >
                                      <p class="card-title text-light">Lucro em Venda</p>
                                      <h3 class="card-text text-light">R$ <?= replace_dot(isset($sum->b) ? $sum->b: '0.00')?></h3>
                                      <i class="fa fa-4x fa-dollar"></i>
                                    </div>
                                  </div>
                            </div>

                            <div class="col-md-3">
                                
                                <div class="card card-chart bg-primary p-1 py-2 m-1" style="position: relative;">
                                    <div class="card-body" >
                                      <p class="card-title text-light">Total em Venda</p>
                                      <h3 class="card-text text-light">R$ <?=replace_dot(isset($sum->p) ? $sum->p: '0.00')?></h3>
                                      <i class="fa fa-4x fa-dollar"></i>
                                    </div>
                                  </div>
                            </div>

                        </div>
                        <hr>
                        <h3 class="my-5">Adicionar produtos</h3>

                        <form method="POST" class="my-5" id="add_product" action="<?=BASE_URL?>/add_product.php">
                            <div class="form-group">
                              <label for="name_product">Nome</label>
                              <input type="text" class="form-control" id="name_product" name="name_product" required>
                            </div>
                            <div class="input-group mb-3">
                                <div class="input-group-prepend">
                                  <span class="input-group-text">$</span>
                                </div>
                                <input type="text" class="form-control" placeholder="Preço" name="price" pattern="[0-9]+" required>
                                <div class="input-group-append">
                                  <span class="input-group-text">.00</span>
                                </div>
                              </div>

                              <div class="input-group mb-3">
                                <div class="input-group-prepend">
                                  <span class="input-group-text">$</span>
                                </div>
                                <input type="text" class="form-control" placeholder="Preço atacado" name="price_owner" pattern="[0-9]+" required>
                                <div class="input-group-append"> 
                                  <span class="input-group-text">.00</span>
                                </div>
                              </div>
                            <div class="form-group">
                                <label for="desc_procuct">Descrição</label>
                                <textarea class="form-control" id="desc_procuct" rows="3" name="desc_product" required></textarea>
                            </div>
                            <button type="submit" class="btn btn-primary">
                                <i class="fa fa-cart-plus"></i>
                                Adcionar</button>
                          </form>
                          <hr>
                          <h3 class="mb-5">Produtos</h3>
                        
                          <table id="product" class="table table-striped table-bordered my-5" style="width:100%" id="product">
                            <thead>
                                <tr>
                                    <th>Nome</th>
                                    <th>Preço</th>
                                    <th>Preço Atacado</th>
                                  
                                </tr>
                            </thead>
                            <tbody>

                            <?php

                                foreach ($products as $product)
                                {
                            ?>
                                <tr>
                                    <td>
                                        <a href="<?=BASE_URL?>/delete_product.php?id=<?=$product->id?>" class="btn "><i class="fa fa-remove text-danger"></i></a>
                                        <?=$product->name?>
                                    </td>
                                    <td>R$ <?=replace_dot($product->price)?></td>
                                    <td>R$ <?=replace_dot($product->price_owner)?></td>
                                </tr>
                            <?php }?>
                            </tbody>
                            <tfoot>
                                <tr>
                                    <th>Nome</th>
                                    <th>Preço</th>
                                    <th>Preço Atacado</th>
                                  
                                </tr>
                            </tfoot>
                        </table>
                        <hr>
                        <h3 class="mb-5">Usuários</h3>
                        
                          <table id="users" class="table table-striped table-bordered my-5" style="width:100%" id="users" >
                            <thead>
                                <tr>
                                    <th>Nome</th>
                                    <th>E-mail</th>
                                    <th>Endereço</th>
                                    <th>Telefone</th>
                                </tr>
                            </thead>
                            <tbody>
                                

                                <?php

                                foreach ($users as $user)
                                {
                                ?>
                                <tr>
                                    <td>
                                        <?=$user->name ?>
                                    </td>
                                    <td>
                                    <?=$user->email ?>

                                    </td>
                                    <td>
                                    <?=$user->address ?>

                                    </td>
                                    <td>
                                    <?=$user->phone ?>


                                    </td>
                                </tr>
                                <?php }?>
                                
                            </tbody>
                            <tfoot>
                                <tr>
                                    <th>Nome</th>
                                    <th>E-mail</th>
                                    <th>Endereço</th>
                                    <th>Telefone</th>
                                </tr>
                            </tfoot>
                        </table>
                    </div>
                </main>
                <footer class="py-4 bg-light mt-auto">
                    <div class="container-fluid">
                        <div class="d-flex align-items-center justify-content-between small">
                            <div class="text-muted">Copyright &copy; Admin - <?= $admin->name ?></div>
                            <div>
                                <a >Privacy Policy</a>
                                &middot;
                                <a >Terms &amp; Conditions</a>
                            </div>
                        </div>
                    </div>
                </footer>
            </div>
        </div>
        <script src="https://code.jquery.com/jquery-3.4.1.min.js" crossorigin="anonymous"></script>
        <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.bundle.min.js" crossorigin="anonymous"></script>
        <script src="//cdn.datatables.net/1.10.20/js/jquery.dataTables.min.js"></script>
        <script src="https://cdn.datatables.net/1.10.20/js/dataTables.bootstrap4.min.js" crossorigin="anonymous"></script>
        <script src="<?=BASE_URL?>/js/scripts.js"></script>
        
    </body>
</html>