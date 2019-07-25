<?php
  require_once 'backend/includes/_db.php';
  require_once 'backend/includes/_funciones.php';
  session_start();
  global $db;

  if(!isset($_COOKIE['lau']) || $_COOKIE['lau']==0){
    echo "Sesion no iniciada";
    header('Location: login.php');
    return false;
    exit();
  }else{
  $u_id=$_COOKIE['lau'];
  }
?>
<!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>Sistemita | Responsivas</title>
    <meta name="description" content="">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="robots" content="all,follow">
    <!-- Bootstrap CSS-->
    <link rel="stylesheet" href="vendor/bootstrap/css/bootstrap.min.css">
    <!-- Font Awesome CSS-->
    <link rel="stylesheet" href="vendor/font-awesome/css/font-awesome.min.css">
    <!-- Custom Font Icons CSS-->
    <link rel="stylesheet" href="css/font.css">
    <!-- Google fonts - Muli-->
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Muli:300,400,700">
    <!-- theme stylesheet-->
    <link rel="stylesheet" href="css/style.default.css" id="theme-stylesheet">
    <!-- Custom stylesheet - for your changes-->
    <link rel="stylesheet" href="css/custom.css">
    <!-- Favicon-->
    <link rel="shortcut icon" href="img/favicon.ico">
    <!-- Tweaks for older IEs--><!--[if lt IE 9]>
        <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
        <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script><![endif]-->
  </head>
  <body>
    <body>
      <header class="header">
        <nav class="navbar navbar-expand-lg">
          <div class="search-panel">
            <div class="search-inner d-flex align-items-center justify-content-center">
              <div class="close-btn">Cerrar <i class="fa fa-close"></i></div>
              <form id="searchForm" action="#">
                <div class="form-group">
                  <input type="search" name="search" placeholder="¿Que estas buscando?...">
                  <button type="submit" class="submit">Buscar</button>
                </div>
              </form>
            </div>
          </div>
          <div class="container-fluid d-flex align-items-center justify-content-between">
            <div class="navbar-header">
              <!-- Navbar Header-->
                <a href="index.html" class="navbar-brand">
                <div class="brand-text brand-big visible text-uppercase"><strong class="text-primary">Dark</strong><strong>Admin</strong></div>
                <div class="brand-text brand-sm"><strong class="text-primary">D</strong><strong>A</strong></div></a>
              <!-- Sidebar Toggle Btn-->
              <button class="sidebar-toggle"><i class="fa fa-long-arrow-left"></i></button>
            </div>
            <div class="right-menu list-inline no-margin-bottom">
              <div class="list-inline-item"><a href="#" class="search-open nav-link"><i class="icon-magnifying-glass-browser"></i></a></div>
              <!-- Log out               -->
              <div class="list-inline-item logout">
                <a id="logout" class="nav-link"> <span class="d-none d-sm-inline">Cerrar Sesión </span><i class="icon-logout"></i></a></div>
            </div>
          </div>
        </nav>
      </header>
      <div class="d-flex align-items-stretch">
        <!-- Sidebar Navigation-->
        <nav id="sidebar">
          <!-- Sidebar Header-->
          <div class="sidebar-header d-flex align-items-center">
            <div class="avatar"><img src="img/avatar-6.jpg" alt="..." class="img-fluid rounded-circle"></div>
            <div class="title">
              <h1 class="h5">Mark Stephen</h1>
              <p>Web Designer</p>
            </div>
          </div>
          <!-- Sidebar Navidation Menus--><span class="heading">Modulos</span>
          <ul class="list-unstyled">
            <li><a href="index.php"> <i class="icon-home"></i>Inicio </a></li>
            <li><a href="usuarios.php"> <i class="icon-user"></i>Usuarios </a></li>
            <li><a href="equipos.php"> <i class="icon-computer"></i>Equipos </a></li>
            <li class="active"><a href="responsivas.php"> <i class="icon-paper-and-pencil"></i>Responsivas </a></li>
            <li><a href="admins.php"> <i class="icon-user-1"></i>Administradores </a></li>
            <li><a href="deptos.php"> <i class="icon-presentation"></i>Departamentos </a></li>
            <li><a href="login.php"> <i class="icon-logout"></i>Cerrar Sesión </a></li>
        </nav>
        <!-- Sidebar Navigation end-->
        <div class="page-content">
          <!-- Page Header-->
          <div class="page-header no-margin-bottom">
            <div class="container-fluid">
              <h2 class="h5 no-margin-bottom">Responsivas</h2>
            </div>
          </div>
          <!-- Breadcrumb-->
          <div class="container-fluid">
            <ul class="breadcrumb">
              <li class="breadcrumb-item"><a href="index.php">Inicio</a></li>
              <li class="breadcrumb-item active">Responsivas        </li>
            </ul>
          </div>
          <section class="no-padding-top">
            <div class="container-fluid">
              <div class="row">
                <div class="col-lg-12">
                  <div class="block">
                    <div class="title">
                      <strong>Responsivas &nbsp; &nbsp;</strong>
                      <button id="export" href="backend/includes/excel.php" type="button" class="btn btn-primary">Exportar</button>
                    </div>
                    <div class="table-responsive">
                      <table class="table table-striped table-hover">
                        <thead>
                          <tr>
                            <th>#</th>
                            <th>Asignada a</th>
                            <th>Departamento</th>
                            <th>Equipo</th>

                            <th>Alta</th>
                            <th>Firmas</th>
                            <th>Editar</th>
                            <th>Eliminar</th>
                          </tr>
                        </thead>
                        <tbody>
                          <?php
                                            //SELECT tabla1  INNER JOIN tabla2    EN LOS ID'S coincidentes
                            $responsivas = $db->select("responsivas",["[><]persona" => ["res_per" => "per_id"],
                                                                      "[><]departamentos" => ["res_dpto" => "dpto_id"],
                                                                      "[><]equipos" => ["res_epo" => "epo_id"],
                                                                      "[><]administradores" => ["res_adm" => "adm_id"],
                                                                      "[><]avance" => ["res_av" => "av_id"]
                                                                      ],
                                                               ["responsivas.res_id",
                                                                "persona.per_nom",
                                                                "departamentos.dpto_nom",
                                                                "equipos.epo_nom",
                                                                "administradores.adm_nom",
                                                                "responsivas.res_fa",
                                                                "avance.av_nom"]);

                              foreach($responsivas as $key => $res){
                          ?>
                          <tr>
                            <th scope="row"><?php echo $res["res_id"];?></th>
                            <td><?php echo $res["per_nom"];?></td>
                            <td><?php echo $res["dpto_nom"];?></td>
                            <td><?php echo $res["epo_nom"];?></td>

                            <td><?php echo $res["res_fa"];?></td>
                            <td><?php echo $res["av_nom"];?></td>
                            <td>
                              <a href="#" class="editar_resp" data-id="<?php echo $res["res_id"];?>">
                                <i class="fa fa-pencil-square-o" aria-hidden="true"></i>
                              </a>
                            </td>
                            <td>
                              <a href="#" class="eliminar_resp" data-id="<?php echo $res["res_id"];?>">
                              <i class="fa fa-trash-o" aria-hidden="true"></i>
                              </a>
                            </td>
                            <?php
                                }
                             ?>
                          </tr>
                        </tbody>
                      </table>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </section>
          <footer class="footer">
            <div class="footer__block block no-margin-bottom">
              <div class="container-fluid text-center">
                <!-- Please do not remove the backlink to us unless you support us at https://bootstrapious.com/donate. It is part of the license conditions. Thank you for understanding :)-->
                <p class="no-margin-bottom">2019 &copy; Your company. Design by <a href="https://bootstrapious.com/p/bootstrap-4-dark-admin">Bootstrapious</a>.</p>
              </div>
            </div>
          </footer>
        </div>
      </div>
      <!-- JavaScript files-->
      <script src="vendor/jquery/jquery.min.js"></script>
      <script src="vendor/popper.js/umd/popper.min.js"> </script>
      <script src="vendor/bootstrap/js/bootstrap.min.js"></script>
      <script src="vendor/jquery.cookie/jquery.cookie.js"> </script>
      <script src="vendor/chart.js/Chart.min.js"></script>
      <script src="vendor/jquery-validation/jquery.validate.min.js"></script>
      <script src="js/front.js"></script>
      <script src="js/main.js"></script>
    </body>
</html>
