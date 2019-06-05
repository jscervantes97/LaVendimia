<?php 
require 'Conexion.php';
$bd = new Conexion();
switch ($_POST['opc']) {
	case 1:
		$bd->query("UPDATE `articulos` SET `Descripcion`='".$_POST['descripcion']."',`Modelo`='".$_POST['modelo']."',`Precio`=".$_POST['precio'].",`Existencia`=".$_POST['existencia'].",`Status`= 0 WHERE `CveArt` =".$_POST['cvep']) or die ($bd->error);
		$bd->close();
		echo 'Bien Hecho. El Articulo ha sido registrado correctamente';
		break;
	case 2:
		header('Content-Type: application/json');
		$datos; 
		$registros = $bd->query("SELECT `CveArt`, `Descripcion`, `Modelo`, `Precio`, `Existencia` FROM `articulos` WHERE `CveArt` =".$_POST['cveart']) or die ($bd->error);
		if ($registros->num_rows > 0 ){
            while($reg = mysqli_fetch_array($registros)){
            	$datos = array('CveArt' => $reg['CveArt'],'Descripcion' => utf8_encode($reg['Descripcion']),'Modelo' => utf8_encode($reg['Modelo']),'Precio' => $reg['Precio'],'Existencia' => $reg['Existencia']);
            }
        }
        $bd->close();
        echo json_encode($datos, JSON_FORCE_OBJECT);
		break;
	case 3://creacion de la tabla 
		$tabla = '<table class="table" id = "tablaMaster">
            <thead>
              <tr class="table-primary">
                <th>Clave Articulo</th>
                <th>Descripcion</th>
                <th></th>
              </tr>
            </thead>
            <tbody>';
		$registros = $bd->query("SELECT `CveArt`, `Descripcion`FROM `articulos` WHERE `Status` = 0");
        if ($registros->num_rows > 0 ){
            while($reg = mysqli_fetch_array($registros)){
                $tabla.='<tr class="table-success">';
                $tabla.='<td>'.str_pad($reg[0], 4, "0", STR_PAD_LEFT).'</td>';
                $tabla.='<td>'.utf8_encode($reg[1]).'</td>';
                $tabla.='<td class="text-right"><i class="fas fa-edit" onclick="select('.$reg[0].')"></i></td>';
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