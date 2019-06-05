<?php 
include 'Conexion.php';
$bd = new Conexion();
switch ($_POST['opc']) {
	case 1:
	$bd->query("UPDATE `configuracion` SET `TazaFinanciamiento`=".$_POST['tzf'].",`Enganche`=".$_POST['pe'].",`PlazoMaximo`=".$_POST['pe']) or die ($bd->error) ; 
	echo 'Bien Hecho, la configuracion ha sido Registrada';
	break;
}
?>