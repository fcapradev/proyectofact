    

    var panel1 = {};
    panel1.tab = ".panel_edicion";
    panel1.up = "arriba_edicion();";
    panel1.down = "abajo_edicion();";
    panel1.intro = "abajo_edicion();";
    panel1.esc = "cancelar();";

    var panel2 = {};
    panel2.insert = "#lista_mozo";
    panel2.tab = "#lista_mozo";
    panel2.up = "lista_edicion_mozo_up();";
    panel2.down = "lista_edicion_mozo_down();";
    panel2.intro = "sel_editar_mozo();";
    
 
    var tm_mozo;
    
    var inp_num = {};
    inp_num.nombre = "num";
    inp_num.tipo = 1;
    inp_num.max_length = "2";

    var inp_nom = {};
    inp_nom.nombre = "nom";
    inp_nom.tipo = 2;
    inp_nom.max_length = "30";

    var inp_dire = {};
    inp_dire.nombre = "dire";
    inp_dire.tipo = 0;
    inp_dire.max_length = "30";

    var inp_comi = {};
    inp_comi.nombre = "comi";
    inp_comi.tipo = 0;
    inp_comi.max_length = "20";

    var inp_estado = {};
    inp_estado.nombre = "estado";
    inp_estado.tipo = 0;
    inp_estado.max_length = "30";

    var inputs_val = [];
    
    var _scroll_lista_mozo_edicion = 0;
    var _selected_input = 0;



    function lista_edicion_mozo_up(){
            if ($("#lista_mozo tr").length == 0 ) return;

            if ($("#lista_mozo .selected_item_mozo").length == 0){
                $("#lista_mozo  tr").eq(0).addClass("selected_item_mozo");
            }
        

            if ($("#lista_mozo .selected_item_mozo").prev().length>0){
                 var $prev = $("#lista_mozo  .selected_item_mozo").prev();
             
                $("#lista_mozo tr").removeClass("selected_item_mozo");
                $($prev).addClass("selected_item_mozo");
                _scroll_lista_mozo_edicion.scrollToElement($prev);
            }  
    }
    
    function lista_edicion_mozo_down(){

            if ($("#lista_mozo tr").length == 0 ) return;

            if ($("#lista_mozo .selected_item_mozo").length == 0){
                $("#lista_mozo  tr").eq(0).addClass("selected_item_mozo");
            }
        

            if ($("#lista_mozo .selected_item_mozo").next().length>0){
                 var $next = $("#lista_mozo  .selected_item_mozo").next();
             
                $("#lista_mozo tr").removeClass("selected_item_mozo");
                $($next).addClass("selected_item_mozo");
                _scroll_lista_mozo_edicion.scrollToElement($next);
       
            }  
    }    
    
    
    function insertarNuevo(){
           $("#num").removeClass("fondoNaranja");
           $("#num").removeAttr("disabled");
           $(".boton_agregar").hide();
           $("#num").addClass("fondoBlanco");
           $("#num").val("");
           $("#tipo").val(0);
           $("#nom").val("");
           $("#dire").val("");
           $("#comi").val("");
           $("#estado").val("")       
           set_next(inputs_val[0]['nombre'],inputs_val[0]['max_length'],inputs_val[0]['tipo'],2);
           
            $(".item_mozo_edit").click(function(){
                $(".boton_agregar").show();
                $(".item_mozo_edit").removeClass("selected_item_mozo");
                $(this).addClass("selected_item_mozo");

                $("#num").val($(this).find(".num_mozo").text());
                $("#nom").val($(this).find(".nom_mozo").text());
                $("#dire").val($(this).find(".dir_mozo").text());
                $("#comi").val($(this).find(".com_mozo").val());
                $("#estado").val($(this).find(".quey_mozo").val());
                $("#tipo").val(1); //1 edit - 0 nuevo
                $("#num").addClass("fondoNaranja");
                $("#num").attr("disabled","true");
                set_next(inputs_val[1]['nombre'],inputs_val[1]['max_length'],inputs_val[1]['tipo'],2);          
            });        

       
    }
    function guardar(){
        var comision = 0.1;
        
        try{
           comision = parseFloat($("#comi").val()) / 1.5;
        }
        catch(e){
            jAlert("El campo comision no tiene un numero valido",'Debo Retail - Global Business Solution');
            return;;
       }
       
       if (isNaN(comision)){
            jAlert("El campo comision no tiene un numero valido",'Debo Retail - Global Business Solution');
            return;;
       }
       if ($("#num").val()< 1){
            jAlert("El campo numero tiene que tener un valor mayor a 0",'Debo Retail - Global Business Solution');
            return;;
       }
       
       var tipo = $("#tipo").val();
       
       
       $.ajax({url: "Restaurant_mozos.php",
           data: {validarNumero: 1, nmo: $("#num").val()},
           type: "POST",
           success: function(dat){

               if (dat=='success' || tipo == 1){ //valida solo si es nuevo
                   
                   $.ajax({url: "Restaurant_mozos.php",
                       data: {nmo: $("#num").val(),
                              tipo: tipo,
                              nom: $("#nom").val(),
                              direccion: $("#dire").val(),
                              comision: $("#comi").val(),
                              estado: $("#estado").val(),
                              guardar: "1"
                       },
                       type: "POST",
                       success: function(data){
                           $("#lista_mozo").html(data, function(){
                               _scroll_lista_mozo_edicion = _jscrollshow("#lista_mozo");
                           });
                           
                           insertarNuevo();
                           jAlert("Registro de mozo guardado",'Debo Retail - Global Business Solution');
                       } 
                   })    
               }
               else{
                   jAlert("El numero del mozo se encuentra repetido",'Debo Retail - Global Business Solution');
               }
           }
       });

    }
    
    
    function arriba_edicion(){
        var id = 0;
        if ($(".panel_edicion .active").parent().parent().prev().length > 0 ){
            id = ($(".panel_edicion .active").parent().parent().prev().find("input[type=text]").attr("id"));
            seleccionarText(id);
        }
    }


    function abajo_edicion(){
        var id = 0;
        if ($(".panel_edicion .active").parent().parent().next().length > 0 ){
            id = ($(".panel_edicion .active").parent().parent().next().find("input[type=text]").attr("id"));
           seleccionarText(id);
        }
    }

    $(".panel_edicion input[type=text]").click(function(){
        seleccionarText($(this).attr("id"));
    });

    function seleccionarText(elem){        
        var i;
        for(i =  0 ; i < inputs_val.length ; i++){
            if (inputs_val[i]['nombre'] == elem){  
                break;
            }
        }
        _selected_input = i;
        $(".panel_edicion .active").removeClass("active");          
        $("#"+elem).parent().addClass("active");
        
        set_next(elem,inputs_val[i]['max_length'],inputs_val[i]['tipo'],2);
        
    }
    
    function sel_editar_mozo(){
            $(".boton_agregar").show();
            var $this = $(".selected_item_mozo");
            $("#num").val($this.find(".num_mozo").text());
            $("#nom").val($this.find(".nom_mozo").text());
            $("#dire").val($this.find(".dir_mozo").text());
            $("#comi").val($this.find(".com_mozo").val());
            $("#estado").val($this.find(".quey_mozo").val());
            $("#tipo").val(1); //1 edit - 0 nuevo
            $("#num").addClass("fondoNaranja");
            $("#num").attr("disabled","true");
            set_next(inputs_val[1]['nombre'],inputs_val[1]['max_length'],inputs_val[1]['tipo'],2);               
    }

   $(document).ready(function(){
        tm_mozo = new tabmanager();
        tm_mozo.add(panel1);
        tm_mozo.add(panel2);
        tm_mozo.get_tab();
        

/*Validacion de inputs*/    
        inputs_val.push(inp_num);
        inputs_val.push(inp_nom);
        inputs_val.push(inp_dire);
        inputs_val.push(inp_comi);
        inputs_val.push(inp_estado);        
 

        $(".PosDiv1").click(function(){
            $("#"+inputs_val[_selected_input].nombre).focus();
        })

        var $css_new = $("#ajax_css").clone();
        $css_new.attr("id", "ajax_css_2");
        $css_new.attr("href","restaurant/mozos/mozos.css");

        $("head").append($css_new);
        $(".interna_salon").remove();
   
        $("#login_admin").hide("");
        $("#login_admin").html("");
 
       _scroll_lista_mozo_edicion = _jscrollshow("#lista_mozo");
       
       
       replace_button("NumVol","irASalon();", "botones/vol-up.png", "botones/vol-over.png")
       
       
       $(".opciones_restaurant").hide();
       $("#Monedas").hide();
       $("#NumVolPADiv").hide();
       $("#admin_mozos").show();
        $("#identificacion, #mozos_admin").show();
        $("#restaurant_base").slideUp(200);       
       $("#Teclado_Completo, #tec_num").show();
       $("#LetTer").hide();
       
       


       
       insertarNuevo();

       
       
   });
   