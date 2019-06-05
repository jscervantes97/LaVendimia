$(document).ready(function(){
    recargaTabla();
    cargaFrmClientes();
    cargaFrmArticulos();
});
var itemslist = 0; 
function recargaTabla(){
    $.ajax({
        data : {"opc":4},
        url: 'PHP/ModelVentas.php',
        type: 'POST' , 
        beforeSend : function(){
            //console.log("Usted esta realizando una transaccion en linea == tiene alkguna idea de lo que esta haciendo ?");
        },
        success: function(response){
            $("#ticket").html(response);
        }
    });
}
function cargaFrmClientes(){
    $.ajax({
        data : {"opc":4},
        url: 'PHP/ModelCliente.php',
        type: 'POST' , 
        beforeSend : function(){
            console.log("Usted esta realizando una transaccion en linea == tiene alkguna idea de lo que esta haciendo ?");
        },
        success: function(response){
            $("#tableFrame").html(response);
            $('#tablaMaster').DataTable({
                "language": {
                    //"url": "//cdn.datatables.net/plug-ins/1.10.15/i18n/Spanish.json"
                    "decimal": "",
                    "emptyTable": "No hay información",
                    "info": "Mostrando _START_ a _END_ de _TOTAL_ Clientes Registrados",
                    "infoEmpty": "Mostrando 0 to 0 of 0 de Clientes Registrados",
                    "infoFiltered": "(Filtrado de _MAX_ Clientes Registrados)",
                    "infoPostFix": "",
                    "thousands": ",",
                    "lengthMenu": "Mostrar _MENU_ Clientes Registrados",
                    "loadingRecords": "Cargando...",
                    "processing": "Procesando...",
                    "search": "Buscar:",
                    "zeroRecords": "Sin resultados encontrados",
                    "paginate": {
                        "first": "Primero",
                        "last": "Ultimo",
                        "next": "Siguiente",
                        "previous": "Anterior"
                    }
                  }
            });
        }
    });
}
function cargaFrmArticulos(){
     
            /*$('#tablaArticulos').DataTable({
                "language": {
                    //"url": "//cdn.datatables.net/plug-ins/1.10.15/i18n/Spanish.json"
                    "decimal": "",
                    "emptyTable": "No hay información",
                    "info": "Mostrando _START_ a _END_ de _TOTAL_ Articulos Registrados",
                    "infoEmpty": "Mostrando 0 to 0 of 0 de Articulos Registrados",
                    "infoFiltered": "(Filtrado de _MAX_ Articulos Registrados)",
                    "infoPostFix": "",
                    "thousands": ",",
                    "lengthMenu": "Mostrar _MENU_ Articulos Registrados",
                    "loadingRecords": "Cargando...",
                    "processing": "Procesando...",
                    "search": "Buscar:",
                    "zeroRecords": "Sin resultados encontrados",
                    "paginate": {
                        "first": "Primero",
                        "last": "Ultimo",
                        "next": "Siguiente",
                        "previous": "Anterior"
                    }
                  }
            });*/
}
var clienteGlobal;
function select(cve,nombre,rfc){
    var cade = cve + " - " + nombre;
    clienteGlobal = cve ;
    $("#cliente").val(cade);
    $("#refece").html(rfc);
    $("#frmBusqueda").modal("hide");
}
var folioGlobal;
function agregar(folio,cveart){
    itemslist++;
    folioGlobal = folio;
    $("#frmBusquedaArt").modal("hide");
    $.ajax({
        data : {"opc":5,"folio":folio,"cveart": cveart},
        url: 'PHP/ModelVentas.php',
        type: 'POST' , 
        beforeSend : function(){
            //console.log("Usted esta realizando una transaccion en linea == tiene alkguna idea de lo que esta haciendo ?");
        },
        success: function(response){
            $("#ticket").html(response);
        }
    });
    //alert(folio);
}
function eliminar(id,folio){
    //alert(id +" " + folio);
    $.ajax({
        data : {"opc":6,"id":id,"folio":folio},
        url: 'PHP/ModelVentas.php',
        type: 'POST' , 
        beforeSend : function(){
            //console.log("Usted esta realizando una transaccion en linea == tiene alkguna idea de lo que esta haciendo ?");
        },
        success: function(response){
            $("#ticket").html(response);
            itemslist--;
        }
    });
}
function editarPrecio(x,ID,Existen,Precio,Folio){
    var cant = $("#x"+x).val();
    if(cant<=0){
        alert('Ingrese Cantidades que sean mayores a 0');
    }
    else if(cant > Existen){
        alert('La cantidad que usted pide excede la Existencia Actual');
    }else {
        $.ajax({
        data : {"opc":7,"cantidad" : cant,"ID" : ID,"precio":Precio,"folio":Folio},
        url: 'PHP/ModelVentas.php',
        type: 'POST' , 
        beforeSend : function(){
            //console.log("Usted esta realizando una transaccion en linea == tiene alkguna idea de lo que esta haciendo ?");
        },
        success: function(response){
            $("#ticket").html(response);
            //console.log(response);
        }
    });
    }
}
var bandera = false ; 
function insertar(Folio){
    var RFC = $("#refece").text()
    var Enganche = 0 ;
    var BFEnganche = 0 ;
    var Total = 0 ; 
    if(itemslist == 0){
        alert('No puedes Realizar una venta Vacia');
    }else{
        if(RFC === ""){
            alert('Selecciona Un Cliente Para Continuar');
        }else {
            Enganche = $("#tbenganche").text();
            BFEnganche = $("#tbbengancge").text();
            Total = $("#tbtotal").text();
            //alert('Datos Reportados ' + Enganche + ' ' + BFEnganche + ' ' + Total);
            if(!bandera){
                $.ajax({
                    data : {"opc":8,"total":Total},
                    url: 'PHP/ModelVentas.php',
                    type: 'POST' , 
                    beforeSend : function(){
                        //console.log("Usted esta realizando una transaccion en linea == tiene alkguna idea de lo que esta haciendo ?");
                    },
                    success: function(response){
                        $("#abonos").html(response);
                        bandera = true ; 
                        //console.log(response);
                    }
                });
            }else{
                //alert('Has entrado al otro procedimiento...');
                if($('input:radio[name=opcion]:checked').val()== undefined){
                    alert('Debe seleccionar un plazo para realizar el pago de su compra');
                }else{
                var total = parseFloat($('input:radio[name=opcion]:checked').val());
                //RFC
                    $.ajax({
                    data : {"opc":9,"total":total,'Folio':Folio,"RFC" : RFC},
                    url: 'PHP/ModelVentas.php',
                    type: 'POST' , 
                    beforeSend : function(){
                        //console.log("Usted esta realizando una transaccion en linea == tiene alkguna idea de lo que esta haciendo ?");
                    },
                    success: function(response){
                        //$("#abonos").html(response);
                        console.log(response);
                        $("#msg").text(response);
                        $("#SuccessFMR").modal("show");
                        //bandera = true ; 
                        //console.log(response);
                    }
                    });
                }
            }
        }
    }
    
}
