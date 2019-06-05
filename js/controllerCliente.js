$(document).ready(function(){
    recargaTabla();
});

function insertar(cvecte){
	var nombre = $("#nombre").val();
	var apep = $("#ApeP").val();
 	var apem = $("#ApeM").val();
 	var rfc = $("#RFC").val();
 	var error = 0 ; 
 	var estring = "" ;
 	if (nombre === "" || nombre === "Falta llenar este campo"){
 		$("#nombre").val("Falta llenar este campo");
 		error = 1 ;
 		estring += " [Nombre] ";
 	}
 	if (apep === "" || apep === "Falta llenar este campo"){
 		$("#ApeP").val("Falta llenar este campo");
 		error = 1 ;
 		estring += " [Apellido Paterno] ";
 	}
 	if (apem === "" || apem === "Falta llenar este campo"){
 		$("#ApeM").val("Falta llenar este campo");
 		error = 1 ;
 		estring += " [Apellido Materno] ";
 	}
 	if (rfc === "" || rfc === "Falta llenar este campo"){
 		$("#RFC").val("Falta llenar este campo");
 		error = 1 ;
 		estring += " [RFC] ";
 	}
	if(error == 1 ){
		$("#aviso").text(estring);
		$("#ErrorFMR").modal("show");
	}else{
		$.ajax({
        data : {"opc":1,"cvecte" : cvecte,"nombre" :nombre , "apep": apep ,"apem" :apem,"rfc":rfc},
        url: 'PHP/ModelCliente.php',
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
function select(cvecte){
    $.ajax({
        data : {"opc":2,"cvecte" : cvecte},
        url: 'PHP/ModelCliente.php',
        type: 'POST' , 
        beforeSend : function(){
            console.log("Usted esta realizando una transaccion en linea == tiene alkguna idea de lo que esta haciendo ?");
        },
        success: function(response){
            //console.log(JSON.stringify(response));
            //console.log(response);
            $("#nombre").val(response.Nombre);
            $("#ApeP").val(response.ApeP);
            $("#ApeM").val(response.ApeM);
            $("#RFC").val(response.RFC);
            cveglobal = cvecte;
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
        url: 'PHP/ModelCliente.php',
        type: 'POST' , 
        beforeSend : function(){
            console.log("Usted esta realizando una transaccion en linea == tiene alkguna idea de lo que esta haciendo ?");
        },
        success: function(response){
            $("#tableFrame").html(response);
        }
    });
}

function question(){
    $("#QuestionFRM").modal("show");
}