<?php 
require 'Conexion.php';
$bd = new Conexion();
$taza_financiamiento ;
$PEnganche ; 
$PlazoMaximo ; 
$Enganche = 0 ; 
$BEnganche = 0 ;
$Adeudo= 0 ;  
$registros = $bd->query("SELECT * FROM `configuracion`");
if ($registros->num_rows > 0 ){
    while($reg = mysqli_fetch_array($registros)){
        $taza_financiamiento = $reg[0];
        $PEnganche = $reg[1];
        $PlazoMaximo = $reg[2];
   }
}
switch ($_POST['opc']) {
	case 1:
		$bd->query("") or die ($bd->error);
		$bd->close();
		echo 'Venta Registrada Con Exito';
		break;
	case 2:
		break;
	case 3://creacion de la tabla 
		$tabla = '<table class="table" id = "tablaMaster">
            <thead>
              <tr class="table-primary">
                <th>Folio</th>
                <th>Clave Cliente</th>
                <th>Nombre</th>
                <th>Total</th>
                <th>Fecha</th>
                <th>Estatus</th>
              </tr>
            </thead>
            <tbody>';
		$registros = $bd->query("SELECT v.Folio,v.CveCte,cl.Nombre,cl.ApePat,cl.ApeMat,v.Total,v.Fecha,v.Estatus FROM ventas v INNER JOIN clientes cl on v.CveCte = cl.CveCte where v.Estatus like 'Activa' AND v.Status = 0");
        if ($registros->num_rows > 0 ){
            while($reg = mysqli_fetch_array($registros)){
                $tabla.='<tr class="table-success">';
                $tabla.='<td>'.str_pad($reg[0], 4, "0", STR_PAD_LEFT).'</td>';
                $tabla.='<td>'.str_pad($reg[1], 4, "0", STR_PAD_LEFT).'</td>';
                $tabla.='<td>'.utf8_encode($reg[2]).' '.utf8_encode($reg[3]).' '.utf8_encode($reg[4]).'</td>';
                $tabla.='<td>'.$reg[5].'</td>';
                $tabla.='<td>'.$reg[6].'</td>';
                $tabla.='<td>'.$reg[7].'</td>';
                $tabla.='</tr>';
            }
        }
        $bd->close();
        $tabla.='</tbody>
          </table>';
        echo $tabla;
		break;
    case 4://creacion de la tabla de las ventas x folio 
        $tabla = '<table class="table" id = "tabla">
            <thead class="thead-light">
              <tr class="table-primary">
                <th>Descripcion Articulo</th>
                <th>Modelo</th>
                <th>Cantidad</th>
                <th>Precio</th>
                <th>Importe</th>
                <th></th>
              </tr>
            </thead>
            <tbody>';
        echo $tabla;
        //$registros = $bd->query() or die ($bd->error());
    break;
    case 5 : 
    $bd->query("INSERT INTO `folios`(`Folio`, `CveArt`,`Cantidad`,`Importe`) VALUES (".$_POST['folio'].",".$_POST['cveart'].",1,(SELECT `Precio` FROM `articulos` WHERE `CveArt` =".$_POST['cveart']."))") or die ($bd->error);
     $tabla = '<table class="table" id = "tabla">
            <thead class="thead-light">
              <tr class="table-primary">
                <th>Descripcion Articulo</th>
                <th>Modelo</th>
                <th>Cantidad</th>
                <th>Precio</th>
                <th>Importe</th>
                <th></th>
              </tr>
            </thead>
            <tbody>';
    $registros = $bd->query("SELECT ar.Descripcion,ar.Modelo,ar.Precio,ar.Existencia,f.ID,f.Cantidad,f.Importe FROM folios f INNER JOIN articulos ar on f.CveArt = ar.CveArt WHERE f.Folio =".$_POST['folio'])or die ($bd->error);
    $x = 0 ; 
    if ($registros->num_rows > 0 ){
        while($reg = mysqli_fetch_array($registros)){
            $tabla.= '<tr>';
            $tabla.= '<td>'.$reg['Descripcion'].'</td>';
            $tabla.= '<td>'.$reg['Modelo'].'</td>';
            $tabla.= '<td><input type="number" min="0" max="'.$reg['Existencia'].'" id="x'.$x.'" onkeyup="editarPrecio('.$x.','.$reg['ID'].','.$reg['Existencia'].','.($reg['Precio']*(1+($taza_financiamiento*$PlazoMaximo)/100)).','.$_POST['folio'].')" value="'.$reg['Cantidad'].'"></td>';
            $tabla.= '<td>'.($reg['Precio']*(1+($taza_financiamiento*$PlazoMaximo)/100)).'</td>';
            $tabla.= '<td>'.$reg['Importe'].'</td>';
            $tabla.= '<td><button class="btn btn-warning" onclick="eliminar('.$reg['ID'].','.$_POST['folio'].')"><i class="fas fa-times"></i></button></td>';
            $tabla.= '</tr>';

            $x++ ; 
        }
    }
    $tabla .= '</tbody></table><hr>';
    $total = 0 ;
    $registros = $bd->query("SELECT sum(`Importe`) from folios where `Folio` =".$_POST['folio'])or die ($bd->error);
    if ($registros->num_rows > 0 ){
        while($reg = mysqli_fetch_array($registros)){
            $total = $reg[0];
        }
    }
    if(is_null($total))
    {
        $total = 0 ; 
    }else{
        $Enganche = ($PEnganche/100)*$total;
        $BEnganche = $Enganche*(($taza_financiamiento*$PlazoMaximo)/100);
        $Adeudo = $total - $Enganche - $BEnganche;
    }
    $tabla .= '<div style="margin-right: 10px" class="text-right"><table>
            <tr>
            <td><span class="btn btn-secondary">Enganche</span></td><td><div id="tbenganche">'.$Enganche.'</div></td>
            </tr><tr>
            <td><span class="btn btn-secondary">Bonificacion de Enganche</span></td><td><div id="tbbengancge">'.$BEnganche.'</div></td></tr>
            <tr>
            <td><span class="btn btn-secondary">Total</span></td><td><div id="tbtotal">'.$Adeudo.'</div></td></tr>
        </table></div>';
    $bd->close();
    echo $tabla;
    break ; 
    case 6 :
    $bd->query("DELETE FROM `folios` WHERE `ID` =".$_POST['id'])or die($bd->error);
    $tabla = '<table class="table" id = "tabla">
            <thead class="thead-light">
              <tr class="table-primary">
                <th>Descripcion Articulo</th>
                <th>Modelo</th>
                <th>Cantidad</th>
                <th>Precio</th>
                <th>Importe</th>
                <th></th>
              </tr>
            </thead>
            <tbody>';
    $registros = $bd->query("SELECT ar.Descripcion,ar.Modelo,ar.Precio,ar.Existencia,f.ID,f.Cantidad,f.Importe FROM folios f INNER JOIN articulos ar on f.CveArt = ar.CveArt WHERE f.Folio =".$_POST['folio'])or die ($bd->error);
    $x = 0 ; 
    if ($registros->num_rows > 0 ){
        while($reg = mysqli_fetch_array($registros)){
            $tabla.= '<tr>';
            $tabla.= '<td>'.$reg['Descripcion'].'</td>';
            $tabla.= '<td>'.$reg['Modelo'].'</td>';
            $tabla.= '<td><input type="number" min="0" max="'.$reg['Existencia'].'" id="x'.$x.'" onkeyup="editarPrecio('.$x.','.$reg['ID'].','.$reg['Existencia'].','.($reg['Precio']*(1+($taza_financiamiento*$PlazoMaximo)/100)).','.$_POST['folio'].')" value="'.$reg['Cantidad'].'"></td>';
            $tabla.= '<td>'.($reg['Precio']*(1+($taza_financiamiento*$PlazoMaximo)/100)).'</td>';
            $tabla.= '<td>'.$reg['Importe'].'</td>';
            $tabla.= '<td><button class="btn btn-warning" onclick="eliminar('.$reg['ID'].','.$_POST['folio'].')"><i class="fas fa-times"></i></button></td>';
            $tabla.= '</tr>';

            $x++ ; 
        }
    }
    $tabla .= '</tbody></table><hr>';
    $total = 0 ;
    $registros = $bd->query("SELECT sum(`Importe`) from folios where `Folio` =".$_POST['folio'])or die ($bd->error);
    if ($registros->num_rows > 0 ){
        while($reg = mysqli_fetch_array($registros)){
            $total = $reg[0];
        }
    }
    if(is_null($total))
    {
        $total = 0 ; 
    }else{
        $Enganche = ($PEnganche/100)*$total;
        $BEnganche = $Enganche*(($taza_financiamiento*$PlazoMaximo)/100);
        $Adeudo = $total - $Enganche - $BEnganche;
    }
    $tabla .= '<div style="margin-right: 10px" class="text-right"><table>
            <tr>
            <td><span class="btn btn-secondary">Enganche</span></td><td><div id="enganche">'.$Enganche.'</div></td>
            </tr><tr>
            <td><span class="btn btn-secondary">Bonificacion de Enganche</span></td><td>'.$BEnganche.'</td></tr>
            <tr>
            <td><span class="btn btn-secondary">Total</span></td><td>'.$Adeudo.'</td></tr>
        </table></div>';
    $bd->close();
    echo $tabla;
    break ; 
    case 7: //parte de actualizar el folio de la venta 
    //echo $_POST['ID'];
    //echo $_POST['cantidad'];
    //echo $_POST['precio'];
    $bd->query("UPDATE `folios` SET `Cantidad`=".$_POST['cantidad'].",`Importe`=".$_POST['cantidad']*$_POST['precio']."  WHERE `ID` =".$_POST['ID']) or die ($bd->error);
    $tabla = '<table class="table" id = "tabla">
            <thead class="thead-light">
              <tr class="table-primary">
                <th>Descripcion Articulo</th>
                <th>Modelo</th>
                <th>Cantidad</th>
                <th>Precio</th>
                <th>Importe</th>
                <th></th>
              </tr>
            </thead>
            <tbody>';
   $registros = $bd->query("SELECT ar.Descripcion,ar.Modelo,ar.Precio,ar.Existencia,f.ID,f.Cantidad,f.Importe FROM folios f INNER JOIN articulos ar on f.CveArt = ar.CveArt WHERE f.Folio =".$_POST['folio'])or die ($bd->error);
    $registros = $bd->query("SELECT ar.Descripcion,ar.Modelo,ar.Precio,ar.Existencia,f.ID,f.Cantidad,f.Importe FROM folios f INNER JOIN articulos ar on f.CveArt = ar.CveArt WHERE f.Folio =".$_POST['folio'])or die ($bd->error);
    $x = 0 ; 
    if ($registros->num_rows > 0 ){
        while($reg = mysqli_fetch_array($registros)){
            $tabla.= '<tr>';
            $tabla.= '<td>'.$reg['Descripcion'].'</td>';
            $tabla.= '<td>'.$reg['Modelo'].'</td>';
            $tabla.= '<td><input type="number" min="0" max="'.$reg['Existencia'].'" id="x'.$x.'" onkeyup="editarPrecio('.$x.','.$reg['ID'].','.$reg['Existencia'].','.($reg['Precio']*(1+($taza_financiamiento*$PlazoMaximo)/100)).','.$_POST['folio'].')" value="'.$reg['Cantidad'].'"></td>';
            $tabla.= '<td>'.($reg['Precio']*(1+($taza_financiamiento*$PlazoMaximo)/100)).'</td>';
            $tabla.= '<td>'.$reg['Importe'].'</td>';
            $tabla.= '<td><button class="btn btn-warning" onclick="eliminar('.$reg['ID'].','.$_POST['folio'].')"><i class="fas fa-times"></i></button></td>';
            $tabla.= '</tr>';

            $x++ ; 
        }
    }
    $tabla .= '</tbody></table><hr>';
    $total = 0 ;
    $registros = $bd->query("SELECT sum(`Importe`) from folios where `Folio` =".$_POST['folio'])or die ($bd->error);
    if ($registros->num_rows > 0 ){
        while($reg = mysqli_fetch_array($registros)){
            $total = $reg[0];
        }
    }
    if(is_null($total))
    {
        $total = 0 ; 
    }else{
        $Enganche = ($PEnganche/100)*$total;
        $BEnganche = $Enganche*(($taza_financiamiento*$PlazoMaximo)/100);
        $Adeudo = $total - $Enganche - $BEnganche;
    }
    $tabla .= '<div style="margin-right: 10px" class="text-right"><table>
            <tr>
            <td><span class="btn btn-secondary">Enganche</span></td><td><div id="tbenganche">'.$Enganche.'</div></td>
            </tr><tr>
            <td><span class="btn btn-secondary">Bonificacion de Enganche</span></td><td><div id="tbbengancge">'.$BEnganche.'</div></td></tr>
            <tr>
            <td><span class="btn btn-secondary">Total</span></td><td><div id="tbtotal">'.$Adeudo.'</div></td></tr>
        </table></div>';
    $bd->close();
    echo $tabla;
    break;
    case 8: //realiza la transaccion final 
    //Precio Contado = Total Adeudo / (1 + ((Tasa Financiamiento X Plazo Máximo) / 100))
    $tot = $_POST['total'];
    $precioContado = $tot /(1 + (( $taza_financiamiento * $PlazoMaximo)/100));
    //Total a Pagar = Precio Contado X (1 + (Tasa Financiamiento X Plazo) / 100) 
    $table = '<table class="table">
            <thead>
              <tr class="table-primary">
                <th colspan="5"><center>Abonos Mensuales</center></th>
              </tr>
            </thead>
            <tbody>
              <tr class="table-success">
                <td>3 Abonos De</td>
                <td>$ '.sprintf("%01.2f",(($precioContado * (1 + ($taza_financiamiento * 3)/100))/3)).'</td>
                <td>TOTAL A PAGAR: '.sprintf("%01.2f", ($precioContado * (1 + ($taza_financiamiento * 3)/100))).'</td>
                <td>SE AHORRA: '.sprintf("%01.2f",($tot -($precioContado * (1 + ($taza_financiamiento * 3)/100)))).'</td>
                <td><input type="radio" name="opcion" value='.$precioContado * (1 + ($taza_financiamiento * 3)/100).'></td>
              </tr>
              <tr class="table-success">
                <td>6 Abonos De</td>
                <td>$ '.sprintf("%01.2f", (($precioContado * (1 + ($taza_financiamiento * 3)/100))/6)).'</td>
                <td>TOTAL A PAGAR: '.sprintf("%01.2f", ($precioContado * (1 + ($taza_financiamiento * 6)/100))).' </td>
                <td>SE AHORRA: '.sprintf("%01.2f",($tot -($precioContado * (1 + ($taza_financiamiento * 6)/100)))).'</td>
                <td><input type="radio" name="opcion" value='.$precioContado * (1 + ($taza_financiamiento * 6)/100).'></td>
              </tr>
              <tr class="table-success">
                <td>9 Abonos De</td>
                <td>$ '.sprintf("%01.2f", (($precioContado * (1 + ($taza_financiamiento * 3)/100))/9)).'</td>
                <td>TOTAL A PAGAR: '.sprintf("%01.2f", ($precioContado * (1 + ($taza_financiamiento * 9)/100))).'</td>
                <td>SE AHORRA: '.sprintf("%01.2f",($tot -($precioContado * (1 + ($taza_financiamiento * 9)/100)))).'</td>
                <td><input type="radio" name="opcion" value='.$precioContado * (1 + ($taza_financiamiento * 9)/100).'></td>
              </tr>
              <tr class="table-success">
                <td>12 Abonos De</td>
                <td>$ '.sprintf("%01.2f", (($precioContado * (1 + ($taza_financiamiento * 3)/100))/12)).'</td>
                <td>TOTAL A PAGAR: '.sprintf("%01.2f", ($precioContado * (1 + ($taza_financiamiento * 12)/100))).'</td>
                <td>SE AHORRA: '.sprintf("%01.2f",($tot -($precioContado * (1 + ($taza_financiamiento * 12)/100)))).'</td>
                <td><input type="radio" name="opcion" value='.$precioContado * (1 + ($taza_financiamiento * 12)/100).'></td>
              </tr>
            </tbody>
          </table>';
    echo $table;
    break ; 
    case 9: //realiza la venta
    /*
    echo 'Entraste al caso 9 ';
    echo $_POST['total'];
    echo $_POST['Folio'];
    echo $_POST['RFC'];
    */
    $auxcve ;
    $registros = $bd->query("SELECT `CveCte` FROM `clientes` WHERE `RFC` like '".$_POST['RFC']."'");
    if ($registros->num_rows > 0 ){
        while($reg = mysqli_fetch_array($registros)){
            $auxcve = $reg[0];
        }
    }
    $bd->query("UPDATE `ventas` SET `CveCte`=".$auxcve.",`Total`=".$_POST['total'].",`Fecha`='".date("Y")."-".date("m")."-".date("d")."',`Estatus`='Activa',`Status`=0 WHERE `Folio` =".$_POST['Folio']) or die ($bd->error);
    echo 'Venta Registrada Con Exito';
    break ; 
}
?>