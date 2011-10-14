    var _panelEdicionMesa = {
        tab : ".lista_mesa",
        left : "left_mesa();",
        right : "right_mesa();",
        up : "up_mesa();",
        down : "down_mesa();",
        intro : "mesa_enter_edicion();",
        insert : "agregarMesa();",
        del : "eliminarMesa();",
        esc : "salir_mesa();",
        ctrl : "moverMesa();"
    };
    var _escape = 0;
    var tm_edit_mesa;

    var _mover_mesa = 0;
    
    
 
    $(".mesa_pos").mouseover(function(){
        $(".over").removeClass("over");
        $(this).addClass("over");
    });
        
        
        
        
    function insertarNuevo(){


        var numero = $("#selected_mesa").val().substr(5, ($("#selected_mesa").val().length-5))
        $("#mess_"+numero).removeClass("selected");
        $("#mess_"+numero).addClass("mesa_edicion");

        
        
        $("#mess_"+numero+" > .sp_numero_mesa").text($("#nombre").val());
        $("#mess_"+numero+" > .sp_numero_mesa").show();
        
        $(".capa_edicion").hide();
        $("#nombre").val("");
        $("#mover").val(0);
        $("#Teclado_Completo, #tec_num").hide();
        
      
    }
    
    function agregarMesa(){
      
        if ($(".mesa_pos.selected").length > 0  && $("#mover").val()==0){
            $(".capa_edicion").show();
            set_next("nombre", 15,0); 
            replace_func("NumVol",'cancelarEdicion();');  
            replace_func("LetEnt",'guardarMesa();');  
            $("#Teclado_Completo, #tec_num").show();
        }
    }
    
    function cancelarEdicion(){
        $("#nombre").unbind("keyup");
        
        replace_func("NumVol",'');  
        replace_func("LetEnt",''); 
        
        $("#nombre").val("");
        $("#mover").val(0);
        $("#Teclado_Completo, #tec_num").hide();     
        $(".capa_edicion").hide();

    }
    
    function guardarMesa(){
        set_next("foc", 15,0,1);     
        var numero_mesa = $("#selected_mesa").val().substr(5, ($("#selected_mesa").val().length-5));
        var descripcion = $("#nombre").val();
       

        $.ajax({url: "Restaurant_mesas.php", 
                data: {guardar: 1, numero_mesa: numero_mesa, descripcion: descripcion},
                type: "POST", 
                success: function(data){
                    if (data == 'existente'){
                        jAlert("Numero de mesa duplicado",'Debo Retail - Global Business Solution');
                        $(".capa_edicion").hide();
                        $("#nombre").val("");
                        $("#mover").val(0);
                        $("#Teclado_Completo, #tec_num").hide();
                    }
                    else{
                        
                        //$("#foc").focus();
                        insertarNuevo();
                        $(".selected_mesa").removeClass("selected_mesa");                                            
                        pos_click();
                    }

                }
        }) 
    }
    
    
    function eliminarMesa(){
        if ($(".mesa_pos.selected_mesa").length > 0 && $("#mover").val()==0){
            var numero_mesa = $("#selected_mesa").val().substr(5, ($("#selected_mesa").val().length-5));
            var descripcion = $("#mess_"+numero_mesa+" > .sp_numero_mesa").text();        
             $.ajax({url: "Restaurant_mesas.php", 
                    data: {eliminar: 1, numero_mesa: numero_mesa, descripcion: descripcion},
                    type: "POST", 
                    success: function(data){
                           //borra valor anterior
                        if (data == 'existente'){
                            jAlert("No se puede eliminar mesas con historial de movimientos",'Debo Retail - Global Business Solution');
                        }
                        else{
                           $("#mess_"+numero_mesa+" > .sp_numero_mesa").text("");  
                           $("#mess_"+numero_mesa).removeClass("mesa_edicion")  ;     
                           $("#btnMover").hide();
                           $("#btnEliminar").hide();
                           $(".selected_mesa").removeClass("selected_mesa");
                        }
                    }
            })               
        }
    }
    
    function moverMesa(){
         if ($(".mesa_pos.selected_mesa").length > 0){
            var numero_mesa = $("#selected_mesa").val().substr(5, ($("#selected_mesa").val().length-5));
            $("#mover").val(numero_mesa);
            $("#btnMover").hide();
            $("#btnEliminar").hide();
        }
    }
    


    function guardarMesaMove(pos1, pos2){
        
         $.ajax({url: "Restaurant_mesas.php", 
                data: {MOVER: 1, pos1: pos1, pos2: pos2},
                type: "POST", 
                success: function(data){
                       //borra valor anterior
                       $(".selected_mesa").removeClass("selected_mesa");
                 
                    
                }
        })       
    }
    
    function mesa_enter_edicion(){
        $(".mesa_pos.over").click();
    }
    
    
    
    
    function salir_mesa(){
        if (_escape == 0){
            jConfirm("Desea salir de edicion de mesas?","Debo Retail - Global Business Solution",function(r){
                if (r){
                 irASalon();
                }
                else busqueda_escape();
                })
        }
        _escape=0;

    }
    
    function pos_click(){
        $(".mesa_pos").click(function(){
            $("#selected_mesa").val($(this).attr("id"));            

            if ($(this).hasClass("mesa_edicion")){
                $("#btnMover").show();
                $("#btnEliminar").show();
                $("#btnAgregar").hide();
                $(".mesa_pos").removeClass("selected_mesa");
                $(".mesa_pos").removeClass("selected");
                $(this).addClass("selected_mesa"); 
            }
            else{
                //si se esta moviendo

                if ($("#mover").val()!=0){

                       $("#btnMover").hide();
                       $(".mesa_pos").removeClass("selected_mesa"); 
                       $(this).addClass("selected_mesa");
                       var id_mesa_copiada = "#mess_"+$("#mover").val();

                       //ingresa valor en input nombre para ser ingresada en funcion insertarNuevo
                       $("#nombre").val($(id_mesa_copiada+" .sp_numero_mesa").text());

                       var numero_mesa = $("#selected_mesa").val().substr(5, ($("#selected_mesa").val().length-5));
                       $(id_mesa_copiada).removeClass("mesa_edicion");
                       $(id_mesa_copiada+" .sp_numero_mesa").text("");
                       guardarMesaMove($("#mover").val(), numero_mesa);
                       //borra valor anterior


                       insertarNuevo();
                       $("#btnMover").hide();
                       $("#btnEliminar").hide();

                }
                else{
                    $("#mover").val($("#mover").val());                    
                    $("#btnEliminar").hide();
                    $("#btnAgregar").show();
                    $("#btnMover").hide();

                    $(".mesa_pos").removeClass("selected");
                    $(this).addClass("selected"); 
                    $(".mesa_pos").removeClass("selected_mesa");
                }
            }            
        });     
    }    
    
   $(document).ready(function(){
       
       
        $("#nombre").keyup(function(e){
            if (e.keyCode == "13"){
                guardarMesa();
            }
            else if (e.keyCode == "27"){
                _escape = 1;
                cancelarEdicion();
            }
        })


        var $css_new = $("#ajax_css").clone();
        $css_new.attr("id", "ajax_css_2");
        $css_new.attr("href","restaurant/mesas/mesas.css");
        
        
        tm_edit_mesa = new tabmanager();
        tm_edit_mesa.add(_panelEdicionMesa);
        tm_edit_mesa.set_tab(_panelEdicionMesa);
        
        
        
        $("head").append($css_new);
        $(".interna_salon").remove();
      
        $("#login_admin").hide("");
        $("#login_admin").html("");  
        $("#interna_mesa").hide();        

        $("#Teclado_Completo, #tec_num").hide();

        replace_button("NumVol","", "botones/vol-up.png", "botones/vol-over.png")

        $(".capa_edicion").hide();
        $(".mesa_pos .mesa_pos span").hide();
        $("#btnEliminar").hide();
        $("#btnAgregar").hide();
        $("#btnMover").hide();


        $("#NumVolPADiv").hide();
        $("#admin_mesas").show();
        $("#identificacion, #mesas_admin").show();
        $("#restaurant_base").slideUp(200);       
       
        pos_click();
              
   });
   
   