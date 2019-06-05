<?php 
require 'php/Conexion.php'; 
$band = 0 ; 
$bd = new Conexion();
$registros = $bd->query("SELECT COUNT(*) FROM `configuracion`");
if ($registros->num_rows > 0 ){
    while($reg = mysqli_fetch_array($registros)){
      $band = $reg[0];
    }
}
if($band == 0){//para comprobar si no se ah configurado aun, se meten los valores por defecto
  $bd->query("INSERT INTO `configuracion`(`TazaFinanciamiento`, `Enganche`, `PlazoMaximo`) VALUES (2.8,20,12)") or die ($bd->error) ; 
}
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
        <div class="card-header bg-primary text-white"><h2>Configuracion Del Sistema</h2></div>
          <div class="card-body">
              <table border=0>
                <tr>
                  <td WIDTH="30%" class="text-right"><span style="margin-right: 10px">Taza de Financiamiento:</span></td>
                  <td style=" width: 100px" class="text-right"><input type="text" class="form-control" id="tzf" required=""></td>
                </tr>
                <tr>
                  <td WIDTH="50%" class="text-right"><span style="margin-right: 10px">% de Enganche:</span></td>
                  <td WIDTH="50%" class="text-right"><input type="number" class="form-control " id="pe" min="0"></td>
                </tr>
                <tr>
                  <td WIDTH="50%" class="text-right"><span style="margin-right: 10px">Plazo Maximo:</span></td>
                  <td WIDTH="50%" class="text-right"><input type="number" class="form-control" id="pm" min="0"></td>
                </tr>
                <tr><td></td><td></td></tr>
              </table>
          </div>
        </div>
        <br><div class ="text-right"><button onclick="question()" class="btn btn-success" style="margin-right: 30px">Cancelar</button><?php echo'<button class="btn btn-success" style="margin-right: 10px" onclick="registrar()">Guardar</button>';?></div>
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
          <h3>Desea Cancelar la Siguiente Operacion?</h3>
        </div>
        
        <div class="modal-footer">
          <a href="vistaClientes.php" class="btn btn-success">Si</a>
          <button class="btn btn-primary" onclick="$('#QuestionFRM').modal('hide')">No</button>
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
          <h3>Bien Hecho, la configuracion ha sido Registrada</h3>
        </div>
        
        <div class="modal-footer">
          <a href="vistaClientes.php" class="btn btn-success">Aceptar</a>
        </div>
        
      </div>
    </div>
  </div>
  <div class="modal fade" id="ErrorFMR">
    <div class="modal-dialog modal-dialog-centered">
      <div class="modal-content">
      
        <div class="modal-header">
          <h4 class="modal-title">Verifique Lo Siguiente</h4>
          <button type="button" class="close" data-dismiss="modal">&times;</button>
        </div>
        
        <div class="modal-body text-red">
          <p class="text-danger">No es posible continuar, faltan los siguientes datos:<br><div id="aviso" class="text-danger"></div></p>
        </div>
        
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
        </div>
        
      </div>
    </div>
  </div>
<script src = "js/controllerConfiguracion.js"></script>
</body>
</html>
