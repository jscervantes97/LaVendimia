<?php 
require 'php/Conexion.php';
$cve; 
$band = 0 ; 
$bd = new Conexion();
$registros = $bd->query("SELECT `Folio` FROM `ventas`WHERE `Status` = 1");
if ($registros->num_rows > 0 ){
    while($reg = mysqli_fetch_array($registros)){
      $cve = $reg['Folio'];
      $band = 1 ;
    }
}
if($band == 0 ){
  $bd->query("INSERT INTO `ventas`(`Status`) VALUES (1)")or die ($bd->error);
  $registros = $bd->query("SELECT `Folio` FROM `ventas`WHERE `Status` = 1");
  if ($registros->num_rows > 0 ){
      while($reg = mysqli_fetch_array($registros)){
        $cve = $reg['Folio'];
      }
  }
}
$bd->query("DELETE FROM `folios` where `Folio` =".$cve)or die ($bd->error);
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <title>Sistema La Vendimia</title>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.0/jquery.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js"></script>
  <link rel='stylesheet' href='https://use.fontawesome.com/releases/v5.7.0/css/all.css' integrity='sha384-lZN37f5QGtY3VHgisS14W3ExzMWZxybE1SJSEsQp9S+oqd12jhcu+A56Ebc1zFSJ' crossorigin='anonymous'>
  <link rel='stylesheet' href='https://cdn.datatables.net/1.10.19/css/dataTables.bootstrap4.min.css'>
  <script src="https://cdn.datatables.net/1.10.19/js/jquery.dataTables.min.js"></script>
  <script src="https://cdn.datatables.net/1.10.19/js/dataTables.bootstrap4.min.js"></script>
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
      
    </div>
    <div class="col-sm-8 text-left"> 
      <div class="container">
      <br>
      <div class="card card-login mx-auto mt-5">
        <div class="card-header bg-primary text-white"><h2>Registro de Ventas</h2></div>
          <div class="card-body">
            <div class="text-right" style="margin-right: 10px">Folio Venta: <?php echo str_pad($cve, 4, "0", STR_PAD_LEFT);?></div>
            <div class="form-inline" style="border-bottom:3px solid lightblue; padding-top: 7px; padding-bottom: 7px;">
              <span class = "btn btn-primary" style="margin-right: 20px">Cliente</span>
              <span style="margin-right: 20px"><input type="text" id="cliente" class="form-control" placeholder="buscar cliente"><button class="btn btn-secondary" data-toggle="modal" data-target="#frmBusqueda"><i class='fas fa-search'></i></button></span>
              <div id="refece"></div>
            </div>
            <div class="form-inline" style="border-bottom:3px solid black; padding-top: 7px; padding-bottom: 10px;">
              <span class = "btn btn-primary" style="margin-right: 20px">Articulo</span>
              <span style="margin-right: 20px"><input type="text" id="articulo" class="form-control" placeholder="
                buscar articulo"><button class="btn btn-secondary" data-toggle="modal" data-target="#frmBusquedaArt"><i class='fas fa-search'></i></button></span>
              <button class="btn btn-secondary"><i class='fas fa-plus'></i></button>
            </div>
            <div id="ticket"></div>
            <div id="abonos"></div>
          </div>
        </div>
        <br><div class ="text-right"><button onclick="question()" class="btn btn-success" style="margin-right: 30px">Cancelar</button><?php echo'<button id="tger" class="btn btn-success" style="margin-right: 10px" onclick="insertar('.$cve.')">Siguiente</button>';?></div>
        
      </div>
    </div>
  </div>
</div>
<!-- The Modal -->
<div class="modal " id="frmBusqueda">
  <div class="modal-dialog  modal-lg">
    <div class="modal-content">

      <!-- Modal Header -->
      <div class="modal-header">
        <h4 class="modal-title">Busqueda de Cliente</h4>
        <button type="button" class="close" data-dismiss="modal">&times;</button>
      </div>

      <!-- Modal body -->
      <div class="modal-body">
        <div id="tableFrame">
          
        </div>
      </div>

      <!-- Modal footer -->
      <div class="modal-footer">
        <button type="button" class="btn btn-danger" data-dismiss="modal">Cerrar</button>
      </div>

    </div>
  </div>
</div>

<!-- Busqueda de articulos -->
<div class="modal " id="frmBusquedaArt">
  <div class="modal-dialog  modal-lg">
    <div class="modal-content">

      <!-- Modal Header -->
      <div class="modal-header">
        <h4 class="modal-title">Busqueda de Articulos</h4>
        <button type="button" class="close" data-dismiss="modal">&times;</button>
      </div>

      <!-- Modal body -->
      <div class="modal-body">
        <table class="table" id = "tablaArticulos">
            <thead class="thead-light">
              <tr class="table-primary">
                <th>Clave Articulo</th>
                <th>Descripcion Articulo</th>
                <th>Modelo</th>
                <th>Precio</th>
                <th>Existencia Actual</th>
                <th></th>
              </tr>
            </thead>
            <tbody>
              <?php
                $registros = $bd->query("SELECT `CveArt`,`Descripcion`,`Modelo`,`Precio`,`Existencia` FROM `articulos` WHERE `Existencia` > 0 AND `Status` = 0") or die ($bd->error);
                if ($registros->num_rows > 0 ){
                    while($reg = mysqli_fetch_array($registros)){
                      echo '<tr>';
                      echo '<td>'.$reg[0].'</td>';
                      echo '<td>'.$reg[1].'</td>';
                      echo '<td>'.$reg[2].'</td>';
                      echo '<td>'.$reg[3].'</td>';
                      echo '<td>'.$reg[4].'</td>';
                      echo '<td><button class="btn btn-primary" onclick="agregar('.$cve.','.$reg[0].')">Seleccionar</button></td>';
                      echo '</tr>';
                    }
                }
              ?>
            </tbody>
          </table>
      </div>

      <!-- Modal footer -->
      <div class="modal-footer">
        <button type="button" class="btn btn-danger" data-dismiss="modal">Cerrar</button>
      </div>

    </div>
  </div>
</div>

<!-- Modal para mostrar el mensaje de que se registraron los datos correctamente  -->
  <div class="modal fade" id="SuccessFMR">
    <div class="modal-dialog modal-dialog-centered">
      <div class="modal-content">
      
        <div class="modal-header">
          <h4 class="modal-title">El sitio Dice Lo Siguiente</h4>
          <button type="button" class="close" data-dismiss="modal">&times;</button>
        </div>
        
        <div class="modal-body text-success" id="msg">
          
        </div>
        
        <div class="modal-footer">
          <a href="Ventas.php" class="btn btn-success">Aceptar</a>
        </div>
        
      </div>
    </div>
  </div>

<div class="modal fade" id="QuestionFRM">
    <div class="modal-dialog modal-dialog-centered">
      <div class="modal-content">
      
        <div class="modal-header">
          <h4 class="modal-title">Sistema La Vendimia</h4>
          <button type="button" class="close" data-dismiss="modal">&times;</button>
        </div>
        
        <div class="modal-body" id="msg">
          <h1>Desea Cancelar la Siguiente Operacion?</h1>
        </div>
        
        <div class="modal-footer">
          <a href="Ventas.php" class="btn btn-success">Si</a>
          <button class="btn btn-primary" onclick="$('#QuestionFRM').modal('hide')">No</button>
        </div>
        
      </div>
    </div>
  </div>
<script src = "js/controllerFolios.js"></script>
</body>
</html>
