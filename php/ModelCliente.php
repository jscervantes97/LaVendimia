<?php 
require 'Conexion.php';
$bd = new Conexion();
switch ($_POST['opc']) {
	case 1:
		$bd->query("UPDATE `clientes` SET `Nombre`='".utf8_decode($_POST['nombre'])."',`ApePat`='".utf8_decode($_POST['apep'])."',`ApeMat`='".utf8_decode($_POST['apem'])."',`RFC`='".$_POST['rfc']."',`Status`=0 WHERE `CveCte` =".$_POST['cvecte']) or die ($bd->error);
		$bd->close();
		echo 'Bien Hecho. El cliente ha sido registrado correctamente';
		break;
	case 2:
		header('Content-Type: application/json');
		$datos; 
		$registros = $bd->query("SELECT `CveCte`,`Nombre`,`ApePat`,`ApeMat`,`RFC` FROM `clientes` WHERE `CveCte` =".$_POST['cvecte']) or die ($bd->error);
		if ($registros->num_rows > 0 ){
            while($reg = mysqli_fetch_array($registros)){
            	$datos = array('cvecte' => $reg['CveCte'],'Nombre' => utf8_encode($reg['Nombre']),'ApeP' => utf8_encode($reg['ApePat']),'ApeM' => utf8_encode($reg['ApeMat']),'RFC' => utf8_encode($reg['RFC']));
            }
        }
        $bd->close();
        echo json_encode($datos, JSON_FORCE_OBJECT);
		break;
	case 3://creacion de la tabla 
		$tabla = '<table class="table" id = "tablaMaster">
            <thead>
              <tr class="table-primary">
                <th>Clave Cliente</th>
                <th>Nombre</th>
                <th></th>
              </tr>
            </thead>
            <tbody>';
		$registros = $bd->query("SELECT `CveCte`,`Nombre`,`ApePat`,`ApeMat` FROM `clientes` WHERE `Status` = 0");
        if ($registros->num_rows > 0 ){
            while($reg = mysqli_fetch_array($registros)){
                $tabla.='<tr class="table-success">';
                $tabla.='<td>'.str_pad($reg[0], 4, "0", STR_PAD_LEFT).'</td>';
                $tabla.='<td>'.utf8_encode($reg[1]).' '.utf8_encode($reg[2]).' '.utf8_encode($reg[3]).'</td>';
                $tabla.='<td class="text-right"><i class="fas fa-edit" onclick="select('.$reg[0].')"></i></td>';
                $tabla.='</tr>';
            }
        }
        $bd->close();
        $tabla.='</tbody>
          </table>';
        echo $tabla;
    break;
    case 4://creacion de la tabla 
        $tabla = '<table class="table" id = "tablaMaster">
            <thead>
              <tr class="table-primary">
                <th>Clave Cliente</th>
                <th>Nombre</th>
                <th></th>
              </tr>
            </thead>
            <tbody>';
        $registros = $bd->query("SELECT `CveCte`,`Nombre`,`ApePat`,`ApeMat`,`RFC` FROM `clientes` WHERE `Status` = 0");
        if ($registros->num_rows > 0 ){
            while($reg = mysqli_fetch_array($registros)){
                $tabla.='<tr class="table-success">';
                $tabla.='<td>'.str_pad($reg[0], 4, "0", STR_PAD_LEFT).'</td>';
                $tabla.='<td>'.utf8_encode($reg[1]).' '.utf8_encode($reg[2]).' '.utf8_encode($reg[3]).'</td>';
                $nombre = utf8_encode($reg[1]).' '.utf8_encode($reg[2]).' '.utf8_encode($reg[3]);
                $tabla.='<td class="text-right"><i class="fas fa-edit" onclick="select('.$reg[0].','."'".$nombre."','".$reg['RFC']."'".')"></i></td>';
                $tabla.='</tr>';
            }
        }
        $bd->close();
        $tabla.='</tbody>
          </table>';
        echo $tabla;
    break;
}
?>