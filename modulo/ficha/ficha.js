var retorno;
$(function(){
    retorno = $("#retorno").val();
    $("#tblBusqueda tbody tr").eq(0).addClass("over");
    
   $("#tblBusqueda tbody tr").mouseover(function(){
       $("#tblBusqueda tbody tr").removeClass("over");
       $(this).addClass("over");
   })
   $("#tblBusqueda tbody tr").click(function(){
       $("#tblBusqueda tbody tr").removeClass("selected");
       $(this).addClass("selected");
   })
   
   /*$(document).keyup(function(ev){
       if(ev.keyCode==38){
           busqueda_down();
       }
       if(ev.keyCode==40){
           busqueda_up();
       }
   });*/
   
   
  
});


function busqueda_down(){

        if ($("#tblBusqueda tbody tr").length == 0 ) return;

        if ($("#tblBusqueda .over").length == 0){
            $("#tblBusqueda tbody tr").eq(0).addClass("over");
        }
        
        if ($("#tblBusqueda tbody .over").next().length>0){
             var $next = $("#tblBusqueda tbody .over").next();
            $_scrollBusqueda.scrollToElement($next);
            $("#tblBusqueda tr").removeClass("over");
            $($next).addClass("over");
        }  
}
function busqueda_up(){
   
        if ($("#tblBusqueda tbody tr").length == 0 ) return;

        if ($("#tblBusqueda tbody .over").length == 0){
            $("#tblBusqueda tbody tr").eq(0).addClass("over");
        }
        
        if ($("#tblBusqueda tbody .over").prev().length>0){
            var $prev = $("#tblBusqueda tbody .over").prev();
            $_scrollBusqueda.scrollToElement($prev);
            $("#tblBusqueda tr").removeClass("over");
            $($prev).addClass("over");
        }  
}