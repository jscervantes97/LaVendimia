$(document).ready(function(){
    recargaTabla();
});
function recargaTabla(){
    $.ajax({
        data : {"opc":3},
        url: 'PHP/ModelVentas.php',
        type: 'POST' , 
        beforeSend : function(){
            //console.log("Usted esta realizando una transaccion en linea == tiene alkguna idea de lo que esta haciendo ?");
        },
        success: function(response){
            $("#tableFrame").html(response);
        }
    });
}
