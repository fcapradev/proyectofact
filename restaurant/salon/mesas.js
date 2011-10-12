function left_mesa(){

    if ($(".lista_mesa .mesa_pos").length == 0 ) return;

    if ($(".lista_mesa .over").length == 0){
        $(".lista_mesa .mesa_pos").eq(0).addClass("over");
    }

    if ($(".lista_mesa .over").prev().length > 0){
        var $prev = $(".lista_mesa .over").prev();
        $(".over").removeClass("over");
        $prev.addClass("over");
    }      
}

function right_mesa(){

    if ($(".lista_mesa .mesa_pos").length == 0 ) return;

    if ($(".lista_mesa .over").length == 0){
        $(".lista_mesa .mesa_pos").eq(0).addClass("over");
    }

    if ($(".lista_mesa .over").next().length > 0){
        var $next = $(".lista_mesa .over").next();
        $(".over").removeClass("over");
        $next.addClass("over");
    }      
}

function up_mesa(){
    var pos = $(".lista_mesa .over").index();
        
    if ($(".lista_mesa .mesa_pos").length == 0 ) return;

    if ($(".lista_mesa .over").length == 0){
        $(".lista_mesa .mesa_pos").eq(0).addClass("over");
    }
    
    
    if ($(".lista_mesa .mesa_pos").eq(pos - 6).length > 0){
        var $prev = $(".lista_mesa .mesa_pos").eq(pos - 6);
        $(".over").removeClass("over");
        $prev.addClass("over");
        
    }       
}

function down_mesa(){
    var pos = $(".lista_mesa .over").index();
        
    if ($(".lista_mesa .mesa_pos").length == 0 ) return;

    if ($(".lista_mesa .over").length == 0){
        $(".lista_mesa .mesa_pos").eq(0).addClass("over");
    }
    
    
    if ($(".lista_mesa .mesa_pos").eq(pos + 6).length > 0){
        var $next = $(".lista_mesa .mesa_pos").eq(pos + 6);
        $(".over").removeClass("over");
        $next.addClass("over");
        
    }  
}

function mesa_enter(){
    if ($(".mesa_pos.over").length > 0){
        if ($(".mesa_pos.over").is(".mesa_desocupada, .mesa_ocupada, .mesa_ocupada_unida")){
            $(".mesa_pos.over").click();
        }
    }
}

function salir_mesa(){
    
}