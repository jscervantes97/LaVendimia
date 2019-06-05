function registrar(){
    var tzf = $("#tzf").val();
    var pe = $("#pe").val();
    var pm = $("#pm").val();
    var error = 0 ; 
    var estring = "" ;
    if (tzf === ""){
        error = 1 ;
        estring += " [Taza Financiamiento] ";
    }
    if (pe === ""){
        error = 1 ;
        estring += " [% de Enganche] ";
    }
    if (pm === ""){
        error = 1 ;
        estring += " [Plazo Maximo] ";
    }
    if(error == 1 ){
        $("#aviso").text(estring);
        $("#ErrorFMR").modal("show");
    }else{
        $.ajax({
            data : {"opc":1,"tzf": tzf,"pe": pe,"pm":pm},
            url: 'PHP/ModelConfiguracion.php',
            type: 'POST' , 
            beforeSend : function(){
                console.log("Usted esta realizando una transaccion en linea == tiene alkguna idea de lo que esta haciendo ?");
            },
            success: function(response){
                console.log(response);
                $("#msg").html(response);
                $("#SuccessFMR").modal("show");
            }
        });
    }
}