    function seleccionar_mozo_init(){
        $("#foc").focus();       
        $(".datos_mesa").hide();        
        $(".capa_lista_mozos, .lista_mozos").show(0, function(){
            if ($(".over").lenth==0) $("li.item_mozo").eq(0).addClass("over");
            
            $("li.item_mozo").mouseover(function(){
                $(".over").removeClass("over");
                $(this).addClass("over");
            })
            
            $(".capa_lista_mozos").focus();
             $_scrollMozo = _jscrollshow(".mozo_scroll");
             _bmostrar = true;
             $(".boton_seleccionar_mozo, .boton_unir_mesa, #btnListaParcial").hide();
             tm.set_tab(".capa_lista_mozos");
            $("#LetTexx").parent().removeClass("active");
            $("#LetTexx").attr("disabled","true");             
            
        });        
        
    }

    function up_mozo(){

        if ($(".lista_mozos li").length == 0 ) return;

        if ($(".lista_mozos .over").length == 0){
            $(".lista_mozos li").eq(0).addClass("over");
        }

        if ($(".lista_mozos .over").prev().prev().length > 0){
            var $prev = $(".lista_mozos .over").prev().prev();
            $(".over").removeClass("over");
            $prev.addClass("over");
            $_scrollMozo.scrollToElement($prev);
        }  
        else{
            $(".over").removeClass("over");
            $(".lista_mozos li").last().addClass("over");
             $_scrollMozo.scrollToElement($(".lista_mozos li:last"));
        }
    }   

    function down_mozo(){        
        if ($(".lista_mozos li").length == 0 ) return;
        
        if ($(".lista_mozos .over").length == 0){
            $(".lista_mozos li").eq(0).addClass("over");
        }
        
        if ($(".lista_mozos .over").next().next().length > 0){
            var $next = $(".lista_mozos .over").next().next();
            $(".over").removeClass("over");
            $next.addClass("over");
            $_scrollMozo.scrollToElement($next);
        }  
        else{
            $(".over").removeClass("over");
            $(".lista_mozos li").first().addClass("over");
             $_scrollMozo.scrollToElement($(".lista_mozos li:first"));

        }
    }
    
    
    function left_mozo(){
        if ($(".lista_mozos li").length == 0 ) return;
        
        if ($(".lista_mozos .over").length == 0){
            $(".lista_mozos li").eq(0).addClass("over");
        }
        
        if ($(".lista_mozos .over").prev().length > 0){
            var $prev = $(".lista_mozos .over").prev();
            $(".over").removeClass("over");
            $prev.addClass("over");
            $_scrollMozo.scrollToElement($prev);
        }  
    }   

    function right_mozo(){        
        if ($(".lista_mozos li").length == 0 ) return;
        
        if ($(".lista_mozos .over").length == 0){
            $(".lista_mozos li").eq(0).addClass("over");
        }
        
        if ($(".lista_mozos .over").next().length > 0){
            var $next = $(".lista_mozos .over").next();
            $(".over").removeClass("over");
            $next.addClass("over");
            $_scrollMozo.scrollToElement($next);
        }  
        else{

        }
    }
    
    function mozo_enter(){
        $("li.over").eq(0).click();
    }
    
    function salir_mozo(){
        if (_numero_mozo==-1){
            
            
            tm.set_tab("#Teclado_completo");            
            $(".capa_lista_mozos").hide();
            $(".datos_mesa").show();
            $("#foc").focus();       
   
        }
        else{
            busqueda_escape();
        }        
    }    