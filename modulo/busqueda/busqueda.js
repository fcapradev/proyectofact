var retorno;
$(function(){

    $("#tblBusqueda tbody tr").eq(0).addClass("over");
 
    
   $("#tblBusqueda tbody tr").mouseover(function(){
       $("#tblBusqueda tbody tr").removeClass("over");
       $(this).addClass("over");
        $("#cod_over").val($(this).find(".codigo").text());
        $("#sec_over").val($(this).find(".seccion").text());               
   })
   $("#tblBusqueda tbody tr").click(function(){
       busqueda_enter();
   })
   

   
   
  
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
            $("#cod_over").val($next.find(".codigo").text());
            $("#sec_over").val($next.find(".seccion").text());            
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
            $("#cod_over").val($prev.find(".codigo").text());
            $("#sec_over").val($prev.find(".seccion").text());
        }  
}