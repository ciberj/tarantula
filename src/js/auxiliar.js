
function buscarPvp(productos){
    var parametros = {
            "comercios" : "mediamarkt",
            "productos" : productos
            
    };
   // console.log(document.domain);
    $.ajax({
            data:  parametros,//parametros, //datos que se envian a traves de ajax
            
            url:   '/api/producto', //archivo que recibe la peticion no es necesario poner el dkominio si no se quiere.
            type:  'post', //método de envio
            beforeSend: function () {
                    $("#resultado").html('<div><img src="/src/image/ajax-loader.gif"/></div>');
            },
            success:  function (response) { //una vez que el archivo recibe el request lo procesa y lo devuelve
                    mostrarDatos(response);   
                    varGlobal=response;
/*
                varGlobal = response;// guardamos el response por si lo queremos grabar.
                var json = (JSON.parse(response));
                
                var result="";
                
                json.forEach(function(element) {
                    
                        result= result+ element.producto + "     ";
                        element.datos.forEach(function(e) {
                                result= result+e.comercio+ "     "+e.pvp+ "\t";
                        });
                        result=result+"<br>";
                        

                    });
                   
                    $("#resultado").html(result);
*/                  
                /*                
                    varGlobal = response;// guardamos el response por si lo queremos grabar.
                    //console.log(response);
                    var json = (JSON.parse(response));
                    var result="";
                    json.forEach(function(element) {
                        result= result+ element.producto + "     "+ element.pvp + "<br>";
                    });
                    //console.log(json)
                    $("#resultado").html(result);
                */
                    
            },
            error: function(result) {
            alert("Error en llamada ajax");
        }
    });

};	


function grabarDatos(){
                var parametros ={
                    "datos":varGlobal
                };
                
    
                $.ajax({
                        data: parametros,//parametros, //datos que s-de envian a traves de ajax
                        url:   '/api/grabar', //archivo que recibe la peticion
                        type:  'post', //método de envio
                        beforeSend: function () {
                               // $("#resultado").html("Procesando, espere por favor...");
                        },
                        success:  function (response) { //una vez que el archivo recibe el request lo procesa y lo devuelve
                                
                               // $("#resultado").html("DATOS GRABADOS CORRECTAMENTE");
                               
                                location.href = '/api/datos.csv';
                                //window.open("api/datos.csv"); 
    
    
                            
                                
                        },
                        error: function(result) {
                        alert("Error en llamada ajax");
                    }
                
                })};



function mostrarDatos(datos){ // devuelve una tabla html
    var json = (JSON.parse(datos));
                
    var result="";
   var tabla='<style type="text/css">'+'.tg  {border-collapse:collapse;border-spacing:0;margin:0px auto;}  .tg td{font-family:Arial, sans-serif;font-size:14px;padding:10px 5px;border-style:solid;border-width:0px;overflow:hidden;word-break:normal;border-top-width:1px;border-bottom-width:1px;}            .tg th{font-family:Arial, sans-serif;font-size:14px;font-weight:normal;padding:10px 5px;border-style:solid;border-width:0px;overflow:hidden;word-break:normal;border-top-width:1px;border-bottom-width:1px;}            .tg .tg-yw4l{text-align:center;vertical-align:top}            @media screen and (max-width: 767px) {.tg {width: auto !important;}.tg col {width: auto !important;}.tg-wrap {overflow-x: auto;-webkit-overflow-scrolling: touch;margin: auto 0px;}}'; 
    tabla+='table tr:hover {background-color: #f00;cursor: pointer;}';
    tabla+='</style>';
    tabla+='<div class="tg-wrap"><table class="tg table table-condensed">';

    tabla+='<tr><th class="tg-yw4l"></th><th class="tg-yw4l"><img src="/src/image/mediamarkt.gif"/></th><th class="tg-yw4l"><img src="/src/image/worten.gif"/></th><th class="tg-yw4l"><img src="/src/image/carrefour.gif"/></th><th class="tg-yw4l"><img src="/src/image/elcorteingles.gif"/></th><th class="tg-yw4l"><img src="/src/image/juanlucas.gif"/></th></tr>';
    
   
    json.forEach(function(element) {
        tabla+='  <tr>    <td class="tg-yw4l">'+element.producto+'</td>';

        element.datos.forEach(function(e){
            tabla+='<td class="tg-yw4l">'+'<a href="'+e.urlProducto+'"'+'target="_blank">'+e.pvp+'</a>'+'</td>';
        });
        tabla+='</tr>';
            /*
            result= result+ element.producto + "     ";
            element.datos.forEach(function(e) {
                    result= result+e.comercio+ "     "+e.pvp+ "\t";
            });
            result=result+"<br>";
            

        });*/
    });   
    tabla+='</table></div>';   
        $("#resultado").html(tabla);
}