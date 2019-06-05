$(document).ready(function(){
    recargaTabla();
});
function insertar(cvep){
	var descripcion = $("#descripcion").val();
	var modelo = $("#modelo").val();
 	var precio = $("#precio").val();
 	var existencia = $("#existencia").val();
 	var error = 0 ; 
 	var estring = "" ;
 	if (descripcion === "" || descripcion === "Falta llenar este campo"){
 		$("#descripcion").val("Falta llenar este campo");
 		error = 1 ;
 		estring += " [Nombre] ";
 	}
    if(modelo === ""){
        modelo = "sin modelo";
    }
 	if (precio === "" || precio < 0){
 		error = 1 ;
 		estring += " [precio] ";
 	}
 	if (existencia === "" || existencia < 0){
 		error = 1 ;
 		estring += " [existencia] ";
 	}
	if(error == 1 ){
		$("#aviso").text(estring);
		$("#ErrorFMR").modal("show");
	}else{
		$.ajax({
        data : {"opc":1,"cvep" : cvep,"precio":precio,"descripcion" :descripcion , "modelo":modelo ,"existencia" :existencia},
        url: 'PHP/ModelArticulos.php',
        type: 'POST' , 
        beforeSend : function(){
            console.log("Usted esta realizando una transaccion en linea == tiene alkguna idea de lo que esta haciendo ?");
        },
        success: function(response){
            console.log(response);
            $("#msg").text(response);
            $("#SuccessFMR").modal("show");
        }
    });
	}
}
var cveglobal;
function select(cvep){
    alert(cvep);
    $.ajax({
        data : {"opc":2,"cveart":cvep},
        url: 'PHP/ModelArticulos.php',
        type: 'POST' ,  
        beforeSend : function(){
            console.log("Usted esta realizando una transaccion en linea == tiene alkguna idea de lo que esta haciendo ?");
        },
        success: function(response){
            //console.log(JSON.stringify(response));
            console.log(response);
            $("#descripcion").val(response.Descripcion);
            $("#modelo").val(response.Modelo);
            $("#precio").val(response.Precio);
            $("#existencia").val(response.Existencia);
            cveglobal = cvep;
            //console.log(response.Nombre);
            $("#MuestraFRM").modal("show");
            
        }
    });
}
function modificacion(){
    insertar(cveglobal);
    recargaTabla();
    $("#MuestraFRM").modal("hide");
}
function recargaTabla(){
    $.ajax({
        data : {"opc":3},
        url: 'PHP/ModelArticulos.php',
        type: 'POST' , 
        beforeSend : function(){
          },
        success: function(response){
            $("#tableFrame").html(response);
        }
    });
}

function question(){
    $("#QuestionFRM").modal("show");
}