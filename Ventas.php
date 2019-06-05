<!DOCTYPE html>
<html lang="en">
<head>
  <title>Sistema La Vendimia</title>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.0/jquery.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js"></script>
  <link rel='stylesheet' href='https://use.fontawesome.com/releases/v5.7.0/css/all.css' integrity='sha384-lZN37f5QGtY3VHgisS14W3ExzMWZxybE1SJSEsQp9S+oqd12jhcu+A56Ebc1zFSJ' crossorigin='anonymous'>
  <link rel="stylesheet" href="https://www.w3schools.com/w3css/4/w3.css">
  <style>
    /* Remove the navbar's default margin-bottom and rounded borders */ 
    .a{
      color: white;
    }
    .navbar {
      margin-bottom: 0;
      border-radius: 0;
    }
    
    /* Set height of the grid so .sidenav can be 100% (adjust as needed) */
    .row.content {height: 1000px}
    
    /* Set gray background color and 100% height */
    .sidenav {
      /*
      padding-top: 20px;
      background-color: #f1f1f1;
      height: 100%;
      
      background-color: #f1f1f1;*/
      height: 100%;
    
    }
    
    /* Set black background color, white text and some padding */
    
    /* On small screens, set height to 'auto' for sidenav and grid */
   
  </style>
</head>
<body>
<nav class="navbar navbar-expand-sm bg-dark navbar-dark sticky-top">
  <!-- Brand -->
   <!-- Links -->
  <ul class="navbar-nav">
    <!-- Dropdown -->
    <li class="nav-item dropdown text-white">
      <a class="nav-link dropdown-toggle" href="#" id="navbardrop" data-toggle="dropdown">
        INICIO
      </a>
      <div class="dropdown-menu">
        <a class="dropdown-item" href="Ventas.php">Ventas</a>
        <a class="dropdown-item"><hr></a>
        <a class="dropdown-item" href="vistaArticulo.php">Articulos</a>
        <a class="dropdown-item" href="vistaClientes.php">Clientes</a>
        <a class="dropdown-item" href="Configuracion.php">Configuracion</a>
      </div>
    </li>
  </ul>
  <ul ul class="navbar-nav ml-auto">
    <li class="nav-item text-white"><h3>Fecha: <?php echo date("d")."/".date("m")."/".date("Y"); ?></h3></li>
  </ul>
</nav>
  
<div class="container-fluid text-center">    
  <div class="row content">
    <div class="col-sm-2 sidenav">
    <!-- no elmines esto , es para que haga el espacio de la slider -->  
    </div>
    <div class="col-sm-8 text-left"> 
      <div class="container">
        <div class ="text-right"><a href="NuevaVenta.php" class="btn btn-primary" style="margin-top: 30px"><span class="w3-badge w3-green"><i class='fas fa-plus'></i></span>Nueva Venta</a></div>
        <div style="margin-top: 10px;">
          Ventas Activas
        </div>
        <div id="tableFrame" style="margin-top: 10px;">
          
        </div>
      </div>
    </div>
  </div>
</div>



<script type="text/javascript" src="js/controllerVentas.js"></script>
</body>
</html>