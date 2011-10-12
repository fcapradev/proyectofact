
 

    function insertarNuevo(){

        var numero_mesa = $("#selected_mesa").val().substr(5, ($("#selected_mesa").val().length-5));
    
        $(".capa_edicion").hide();
        $("#mess_"+numero_mesa).removeClass("selected");
        $("#mess_"+numero_mesa).addClass("mesa_edicion");

        
        
        $("#mess_"+numero_mesa+" > .sp_numero_mesa").text($("#nombre").val());
        $("#mess_"+numero_mesa+" > .sp_numero_mesa").show();

        $("#nombre").val("");
        $("#mover").val(0);
        $("#Teclado_Completo, #tec_num").hide();
        
      
    }
    
    function agregarMesa(){
        $(".capa_edicion").show();
        set_next("nombre", 15,0); 
        replace_func("LetEnt",'insertarNuevo();guardarMesa();');  
        $("#Teclado_Completo, #tec_num").show();
    }
    
    function guardarMesa(){
        var numero_mesa = $("#selected_mesa").val().substr(5, ($("#selected_mesa").val().length-5));
        var descripcion = $("#mess_"+numero_mesa+" > .sp_numero_mesa").text();
        
        $.ajax({url: "Restaurant_mesas.php", 
                data: {guardar: 1, numero_mesa: numero_mesa, descripcion: descripcion},
                type: "POST", 
                success: function(data){
                    
                }
        }) 
    }
    
    
    function eliminarMesa(){
        var numero_mesa = $("#selected_mesa").val().substr(5, ($("#selected_mesa").val().length-5));
        var descripcion = $("#mess_"+numero_mesa+" > .sp_numero_mesa").text();        
         $.ajax({url: "Restaurant_mesas.php", 
                data: {eliminar: 1, numero_mesa: numero_mesa, descripcion: descripcion},
                type: "POST", 
                success: function(data){
                       //borra valor anterior
                       $("#mess_"+numero_mesa+" > .sp_numero_mesa").text("");  
                       $("#mess_"+numero_mesa).removeClass("mesa_edicion")  ;                  
                    
                }
        })   
    }
    
    function moverMesa(){
 
        
        var numero_mesa = $("#selected_mesa").val().substr(5, ($("#selected_mesa").val().length-5));
        $("#mover").val(numero_mesa);
    }
    


    function guardarMesaMove(pos1, pos2){
        
         $.ajax({url: "Restaurant_mesas.php", 
                data: {MOVER: 1, pos1: pos1, pos2: pos2},
                type: "POST", 
                success: function(data){
                       //borra valor anterior
                 
                    
                }
        })       
    }
   $(document).ready(function(){
        var $css_new = $("#ajax_css").clone();
        $css_new.attr("id", "ajax_css_2");
        $css_new.attr("href","restaurant/mesas/mesas.css");
        
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
   });
   
   