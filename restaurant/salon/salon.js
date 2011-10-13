    //dentro de mesa
    var _inside_mesa;

    //teclado ante facturacion
    var teclado;
    
    //variables internas
    var _mesa_cerrada = 0;
    var _numero_mesa = -1;
    var _numero_mozo = -1;
    var _numero_comprobante = -1;
    var _item_seleccionado;
    var _is_modified = 0;
    
    var _assigned_event = 0;    
    var $_actual_scroll;   
    var $_scrollDetalle;    
    var $_scrollBusqueda;    
    var $_scrollMozo;    

    //objeto con item a agregar
    var _item = {};
    
    //si se estra mostrando un item (para que no pueda hacer foco en numtex
    var _bmostrar = false;

//para prevenir el keyup de la edicion
    var _bediting = false;

    //estado: 1- lista mesas, 2-destalle mesa 3-busqueda mesas para pasar
    var estado;
    var config = {};
    
    var _selected_element = {};
    

    shortcut.add("Ctrl+E",function() {
        if ($(".lista_mesa").attr("display")!='none'){
            $("#btnEditarMesa").click();
        }       
    });
    shortcut.add("Ctrl+M",function() {
        if ($(".lista_mesa").attr("display")!='none'){
            $("#btnEditarMozo").click();
        }       
    });
    
    
    shortcut.add("Shift+F",function() {
        if ($(".boton_parcial_facturar").attr("display")!='none'){
            facturaParcialMesa();
        }       
    });
    shortcut.add("Shift+E",function() {
        if ($(".boton_parcial_seleccionar_mesa").attr("display")!='none'){
            seleccionarMesa();
        }       
    });
    shortcut.add("Shift+U",function() {
        if ($(".boton_unir_mesa").attr("display")!='none'){
            unir_mesa_init();
        }       
    });
    shortcut.add("Shift+P",function() {
        if ($("#btnListaParcial").attr("display")!='none'){
            mostrar_parciales();
        }        
    });
    shortcut.add("Shift+M",function() {
        if ($(".boton_seleccionar_mozo").attr("display")!='none'){
            seleccionar_mozo_init();
        }
    });                                     

    
    var panel0 = {};
    panel0.tab = "#Teclado_completo";
    panel0.esc = "salir();";
    
    var _panelListaProducto = {
        tab : ".lista_productos",
        up : "arriba_lista();",
        down : "abajo_lista();",
        insert : "modificarItemMesa();",
        del : "eliminarItemMesa();",
        ctrol : "marcaItemTeclado();",
        intro : "mostrarProductoSeleccionado();",
        esc : "salir();",
        end : "enviarAFacTemporal();"
    };


    var _panelBusqueda = {
        tab : "#tblBusqueda",
        up : "busqueda_up();",
        down : "busqueda_down();",
        intro : "busqueda_enter();",
        esc : "busqueda_escape();"        
    };
    

    var _panelParciales = {
        tab : ".parciales",
        up : "arriba_parciales();",
        down : "abajo_parciales();",
        intro : "busqueda_enter();",
        esc : "busqueda_escape();"        
    }
    
    var _panelSeleccionMozo = {
        tab : ".capa_lista_mozos",
        left : "left_mozo();",
        right : "right_mozo();",
        up : "up_mozo();",
        down : "down_mozo();",
        intro : "mozo_enter();",
        esc : "salir_mozo();"
    }


    
    var panel5 = {};
    panel5.tab = ".capa_mesas_iconos";
    panel5.esc = "busqueda_escape();";    

    var panel6 = {};
    panel6.tab = ".lista_mesa";
    panel6.left = "left_mesa();";
    panel6.right = "right_mesa();";
    panel6.up = "up_mesa();";
    panel6.down = "down_mesa();";
    panel6.intro = "mesa_enter();";
    panel6.esc = "SalirSalon();";    

    
    
   //panel manager 
    var tm;
    


    function SalirSalon(){ 
        $("#numero_comprobante").val(0);
        $("#numero_mesa").val(0);        
        $("#mesa_cierre").val(0);        
        irAFactura();   
    }      

    function show_estate(){
        switch(estado){
            case 1:
                $("#Teclado_Completo, #BotMins, #BotonesFac").hide();
                $("#BarFac, #BarFacD").hide();
                break;
            case 2:
                $("#Facturador").show();
                $(".opciones_restaurant").hide();
                $(".opciones_salon").hide();
                $("#Teclado_Completo").show();
                $("#BotMins, #BotonesFac").hide();
                $("#BarFac, #BarFacD").hide();                    
                $("#micapa1, #MiProd").hide();      
                $("#Monedas, #MonedasFon").hide();
                $("#Tiquet").hide();
                break;
            case 3:
       //         $("#Teclado_Completo, #BotMins, #BotonesFac").hide();
         //       $("#BarFac, #BarFacD").hide();                
                break;
            case 4: //recuperar factura
                $("#micapa1, #MiProd").hide(); 
                $(".opciones_restaurant").hide();
                $(".interna_salon").hide();
                $("#Facturador").show();
                $("#Teclado_Completo").html(teclado);
                $("#Teclado_Completo").show();
                $("#BotMins, #BotonesFac").show();
                $("#BarFac, #BarFacD").show();                 
                $("#LetTer").show();                 
                break;
        }
    }


    /*
     lista_productos
     **/
    function mesaSaleccionada(num_mesa, mesa_target_ocupada){

        $(".capa_mesas_iconos").html("")
        $(".capa_mesas_iconos").hide()
         
        var data = [];

        $("table#parciales").find("tr").each(function(i){
            var newcant = $(this).find(".newcant").val();
            var old_cant = $(this).find(".old_cant").val();
            
            if (newcant <= old_cant && newcant > 0){
                data[i] = {
                    cod_articulo_lista : $(this).find(".cod_articulo_lista").val(),
                    cod_seccion_lista : $(this).find(".cod_seccion_lista").val(),
                    numero_lista : $(this).find(".numero_lista").val(),
                    descripcion_lista : $(this).find(".descripcion_lista").text(),
                    precio_lista : $(this).find(".precio_lista").text(),
                    newcant : newcant,
                    old_cant : old_cant
                };  
            }
        })
        
        var res = $.toJSON(data);
        
        $.ajax({data : {ACTUALIZAR_MESAS : 1, 
                    datos: res, 
                    mesa_actual : _numero_mesa,
                    mozo : _numero_mozo,
                    mesa_target : num_mesa,
                    mesa_target_ocupada : mesa_target_ocupada,
                    numero_comprobante : _numero_comprobante},
            url : "Restaurant_salon.php",
            type : "post", 
            success: function(result){
                obtenerProductosMesa();
                $("table#parciales tr").remove();
                estado = 2;
                show_estate()                
            }})
    }
    
    function irASalon(){
        AccBotFac(9);
    }
       
    
    function seleccionarMesa(){
        estado = 3;
        $(".boton_parcial_facturar, .boton_parcial_seleccionar_mesa").hide();

        
        show_estate()
        $.ajax({url: "Restaurant_salon.php", 
            data : {MESAS_ENVIO : 1},
            type : "post",
            success : function(data){
                if(data=="no"){
                    jAlert("no hay mesas disponibles",'Debo Retail - Global Business Solution');
                }
                else{
                    $("#LetTexx").parent().removeClass("active");
                    $("#LetTexx").attr("disabled","true");             
                    $(".capa_mesas_iconos").html(data);
                    $(".capa_mesas_iconos").show();                    
                }                                
            }}
        )
    }
    
    function cerrarCambioMesa(){
        busqueda_escape();
    }    
    

    
    function arriba_lista(){
        if ($("#lista_prod tr").length == 0 ) return;
        
        if ($("#lista_prod .product_selected").length == 0){
            $("#lista_prod tr").eq(0).addClass("product_selected");
        }
        if ($("#lista_prod .product_selected").prev().length>0){
            var $prev = $("#lista_prod .product_selected").prev();
            $_scrollDetalle.scrollToElement($prev);
            _seleccionarProducto($prev);
        }
    }   

    function abajo_lista(){
        
        if ($("#lista_prod tr").length == 0 ) return;
        
        if ($("#lista_prod .product_selected").length == 0){
            $("#lista_prod tr").eq(0).addClass("product_selected");
        }
        
        
        if ($("#lista_prod .product_selected").next().length > 0){
            var $next = $("#lista_prod .product_selected").next();
            $_scrollDetalle.scrollToElement($next);
            _seleccionarProducto($next);

        }  
        else{

        }
    }

    function seleccionarProductoView(elem){
        _seleccionarProducto($(elem).parent());
    }

    function _seleccionarProducto(elem){        //recive TR

        $("#lista_prod tr").removeClass("product_selected");
        $(elem).addClass("product_selected");
  
        var cod_sec = $(elem).find("input.cod_seccion_lista").val();
        var cod_art = $(elem).find("input.cod_articulo_lista").val();
        var numero_lista = $(elem).find("input.numero_lista").val();

        _selected_element.cod = cod_art;
        _selected_element.sec = cod_sec;
        _selected_element.num = numero_lista;
        
        _item_seleccionado = numero_lista;

        seleccionados_a_parciales();
        
        $("#LetTexx").focus();
        
    }
    
    //envia todos los items marcados en la lista a la lista de parciales
    function seleccionados_a_parciales(){
    
        $("table#parciales tr").remove();
        var exist_marcados = false;
        
        $("#lista_prod .item_marcado").each(function(i){
            var $inside_tr = ($(this).clone());
            var cant_actual = $(this).find("td.cantidad_lista").text();
            $inside_tr.find("td.marca").remove();
            $inside_tr.find("td.opcion_modificar").remove();
            $inside_tr.find("td.opcion_eliminar").remove();
            $inside_tr.find("td.opcion_ver").remove();
            $inside_tr.find("td").unbind("click");
            $inside_tr.find("td").removeAttr("onclick");
            $inside_tr.removeAttr("onclick");
            $inside_tr.unbind("click");
            $inside_tr.removeClass("item_marcado product_selected");
            $inside_tr.find(".cantidad_lista").html("<span class='cantidad_previa'>"+cant_actual+"</span><input id='new_"+i+"' type='text' class='newcant' value='"+cant_actual+"' /><input type='hidden' class='old_cant' value='"+cant_actual+"' />");

            $inside_tr.find("#new_"+i).click(function(){
                set_next($(this).attr("id"), 3, 3, 2);
            });
            
            $inside_tr.find(".newcant").keyup(function(){
                //que el numero ingresado no sea mayor al que hay en la lista principal
                var $oldValue = parseInt($(this).next().val());
                
                if(parseInt($(this).val()) > $oldValue) {
                    $(this).val($oldValue) ;
                }
                //calcular total de producto parcial
                if (!isNaN($(this).val()) ){
                    ($(this).parent().next().next().text(dec(parseInt($(this).val())*parseFloat($(this).parent().next().text()))));
                }
                else{
                    $(this).val($oldValue)
                }
                
                
                // calcular totales de parciales cada vez que se modifica un numero


                var total_parcial = 0;
                $("#parciales tr").each(function(){
                    
                    var cant = $(this).find(".newcant").val();

                    var put = $(this).find(".precio_lista").text();

                    total_parcial += parseInt(cant) * parseFloat(put);
                }) 
                $(".parcial_total").text( dec(parseFloat(total_parcial)));    
                

                       
            })
            _jscrollshow(".parciales_scroll");
  
            
            $("table#parciales").append($inside_tr);  
            exist_marcados = true;
        });    
        
        // calcular totales de parciales cada vez que se agrega un item
        var total_parcial = 0;
        $("table#parciales tr").each(function(){
            var cant = $(this).find(".newcant").val();
            var put = $(this).find(".precio_lista").text();

            total_parcial += parseInt(cant) * parseFloat(put);

        })            
        $(".parcial_total").text(dec(parseFloat(total_parcial))); 


        if (exist_marcados){
            $("#btnListaParcial").show();
        }
        else{
            $("#btnListaParcial").hide();
        }
    }    
    

    

    
    function eliminarItemMesa(){
           $.ajax({url :"Restaurant_salon.php", 
                data : {ELIMINAR_ITEM: 1,
                    codigo_articulo : _selected_element.cod,
                    sector_articulo : _selected_element.sec,
                    numero_item : _selected_element.num
                },
                type: "post",
                success : function(){
                    _selected_element.cod = 0;
                    _selected_element.sec = 0;
                    _selected_element.num = 0;
                    
                    $(".product_selected").remove();
                    _seleccionarProducto($("#lista_prod tr").first());
                     $_scrollDetalle.scrollToElement($("#lista_prod tr").first());
                }
        });        
    }
    
    function cargarProductoaMesa(){

        $(".datos_mesa").show();        
        $(".capa_ficha_producto").html("");
        $(".capa_ficha_producto").hide();
       
        var res = (parseFloat(_item.cantidad) * parseFloat(_item.precio));

//Si no se ingresa un numero valido
        if (isNaN(_item.cantidad) || _item.cantidad == 0 ) {
            set_next("NumTexx", 5, 1,1);return;
        }

        $("#LetTexx").focus();
        if ( _item.codigo == 0){
            return;
        }
        _bediting  = true;
//Si el producto esta siendo modificado
        if (_is_modified > 0){
            _is_modified = 0      

            $.ajax({url:"Restaurant_salon.php", 
                    data: {MODIFICAR_CANTIDAD_ITEM: 1, 
                            numero_mesa : _numero_mesa,
                            numero_comprobante : _numero_comprobante,
                            cantidad : _item.cantidad,
                            precio_unitario : _item.precio,
                            total : dec(res),                           
                            numero_orden : _item_seleccionado
                            },
                    type: "POST",
                    success: function(data){
                        var $selected = $(".product_selected");
                        $selected.find(".cantidad_lista").text(_item.cantidad);
                        
                        //recalcula total de mesa
                        var total = 0;
                        $("table#lista_prod .precio_total_lista").each(function(){
                            total = parseFloat($(this).text()) + total;
                        });
                        $(".res_total_mesa").text(dec(total));    
                        busqueda_escape();
                    }
                })   
        }
        else {            
//Si se agrega un producto    
            $.ajax({url:"Restaurant_salon.php", 
                    data: {AGREGAR_ITEM: 1, 
                            numero_mesa : _numero_mesa,
                            numero_comprobante : _numero_comprobante,
                            numero_mozo : _numero_mozo,
                            sector_articulo : _item.sector,
                            codigo_articulo : _item.codigo,
                            cantidad : _item.cantidad,
                            detalle : _item.detalle,
                            precio_unitario : _item.precio,
                            total : dec(res)                           
                            },
                    type: "POST",
                    success: function(data){                        
                        agregarItemHtml(data, _item.sector, _item.codigo, _item.detalle, _item.precio, _item.cantidad, res, 0);
                        $_scrollDetalle = _jscrollshow(".lista_productos");
                        _seleccionarProducto($("#lista_prod tr").last());
                        if ($("#lista_prod tr").length > 0)
                            $_scrollDetalle.scrollToElement($("#lista_prod tr").last());  
                        asignar_eventos_opciones_productos();
                        busqueda_escape();
                    }
            })    
        }                 
    }
    
    function agregarItemHtml(numero, codigo_sector, codigo_articulo, detalle, precio, cantidad, res, fac){
        $("#mod_lista .numero_lista").val(numero)  ;
        $("#mod_lista .cod_articulo_lista").val(codigo_articulo)  ;
        $("#mod_lista .cod_seccion_lista").val(codigo_sector)  ;
        $("#mod_lista .cod_articulo_seccion_lista").text(codigo_sector+"-"+codigo_articulo)  ;
        $("#mod_lista .descripcion_lista").text(detalle)  ;
        $("#mod_lista .precio_lista").text(dec(precio))  ;
        $("#mod_lista .cantidad_lista").text(cantidad)  ;
        $("#mod_lista .precio_total_lista").text(dec(res))  ;
        
        if (fac == 1){
            $("#mod_lista tr").addClass("item_marcado");
        }        
        else{
            $("#mod_lista tr").removeClass("item_marcado");
        }
        
        $("table#lista_prod tbody").append($("#mod_lista tbody").html());

        var total = 0;
        $("table#lista_prod .precio_total_lista").each(function(){
            total = parseFloat($(this).text()) + total;
        });

        $(".res_total_mesa").text(dec(total));          
    }
    
    //marca items para facturar o cambiar de mesa
    
    function marcaItemTeclado(){
        var $tr = $(".lista_productos tr.product_selected");
        
        if ($tr.hasClass("item_marcado")) {
            $tr.removeClass("item_marcado");
             }
        else {
            $tr.addClass("item_marcado");     
        }  
        _seleccionarProducto($tr);
    }
    
    function marcaItems(elem){
        var $tr = $(elem).parent();
            if ($tr.hasClass("item_marcado")) {
                $tr.removeClass("item_marcado");
                 }
            else {
                $tr.addClass("item_marcado");     
            }

    }
    //trae productos cargados previamente
    function obtenerProductosMesa(){
            $.ajax({url : "Restaurant_salon.php", 
                    type : "post",
                    dataType: "json",
                    data: {
                        OBTENER_PRODUCTOS_MESA: 1,   
                        numero_mesa : _numero_mesa,
                        numero_comprobante : _numero_comprobante
                    },
                    success : function(data){
                        $("table#lista_prod tbody tr").remove();
                        for(var i = 0 ; i < data.length; i++){
                            agregarItemHtml(data[i].ORD, data[i].COD, data[i].ART, data[i].TIO, data[i].PUN, data[i].CAN , data[i].PUT, data[i].FAC);
                        }
                        seleccionados_a_parciales();
                        $_scrollDetalle = _jscrollshow(".lista_productos");
                        
                        _seleccionarProducto($("#lista_prod tr").last());
                        if ($("#lista_prod tr").length > 0)
                            $_scrollDetalle.scrollToElement($("#lista_prod tr").last());     
                      
                        
                        asignar_eventos_opciones_productos();
                        
                        LetTerChange();
                    }
            });                    
    }
    function asignar_eventos_opciones_productos(){
            $(".opcion_modificar").unbind("click");
            $(".opcion_eliminar").unbind("click");
            $(".opcion_ver").unbind("click");
            
            $(".opcion_modificar").click(function(){
            if(!$(this).parent().hasClass("item_marcado"))
                modificarItemMesa();
            });               

            $(".opcion_eliminar").click(function(){
                if(!$(this).parent().hasClass("item_marcado"))
                    eliminarItemMesa();
            });                   

            $(".opcion_ver").click(function(){
                mostrarProductoSeleccionado();
            });    
    }
     
    function LetTerChange(){
        replace_button("LetTer","enviarAFacTemporal();","botones/ter-up.png","botones/ter-over.png");
        replace_func("LetEnt"," _inicio_busqueda();");
        replace_func("NumVol","_inicio_busqueda();")
    }
    
    
    //MOZOS
    function seleccionar_mozo(numero, nombre){
        $(".lblMozo").text(nombre);    
        $(".capa_lista_mozos").fadeOut(100);
       
        //si la mesa esta cerrada la abrimos
        if (_mesa_cerrada=='S'){
            $.ajax({url:"Restaurant_salon.php",
                    data: {ABRIR_MESA : 1,
                           numero_mesa : _numero_mesa,
                           mozo : numero},
                   type : "POST",
                   success:  function (data){
                       if (!isNaN(data)){
                           _mesa_cerrada = "N";
//                           $("#tec_num").show();
                           $("#Teclado_Completo").show();
                           
                           _numero_comprobante = data;
                           _numero_mozo = numero;
                           obtenerProductosMesa();
                           $('#LetTexx').focus();
                           busqueda_escape();
                       }         
                   }})
        }
        else{
            $.ajax({url:"Restaurant_salon.php",
                    data: {GUARDAR_MOZO : 1,
                           numero_mesa : _numero_mesa,
                           numero_comprobante : _numero_comprobante,
                           mozo : numero},
                   type : "POST",
                   success:  function (data){
                        if (!isNaN(data)){
                           _mesa_cerrada = "N";
                           _numero_mozo = numero;
                           obtenerProductosMesa();
                           $('#LetTexx').removeAttr("disabled"); 
                            $('#LetTexx').focus();
                            busqueda_escape();
                       }                           
                   } 
               })  
           }        
    }        
    

    //mesas desunidas    
    function desocupar_mesa(mesa_id){
        $.ajax({url:"Restaurant_salon.php", 
               data: {DESOCUPAR_MESAS: 1, nromesa: _numero_mesa, mesa :mesa_id},
                    type: "POST",
                    success: function(data){
                        if (data.toString().length==0){
                            $(".lblUnidas").text("[...]");
                        }
                        else{
                            $(".lblUnidas").text(data);
                        }
                        
                        
                    }
                })     
        $(".capa_mesas_iconos").html("");
        $(".capa_mesas_iconos").hide();              
        $(".lista_mesas").hide();              
        $(".capa_lista_mesas").hide();              
    }
    
    //mesas unidas
    function seleccionar_mesa(mesa_id){
       $.ajax({url:"Restaurant_salon.php", 
           data: {OCUPAR_MESAS: 1, mesas: mesa_id, nromesa: _numero_mesa},
                type: "POST",
                success: function(data){
                    $(".lblUnidas").text(data);                        
                }
            })
        $(".capa_mesas_iconos").html("");
        $(".capa_mesas_iconos").hide();    
        $(".lista_mesas").hide();    
        $(".capa_lista_mesas").hide();    
    }    
    
    //mesa ocupada
    function seleccionar_mesa_ocupada(mesa_id){
        jConfirm('Todos los productos de esta mesa pasaran a la mesa actual', 'Debo Retail - Global Business Solution', function(r) {
            if(r){
                $.ajax({data : {LINK_MESA : 1, 
                        mesa_actual : _numero_mesa,
                        mesa_source : mesa_id,
                        numero_comprobante : _numero_comprobante},
                url : "Restaurant_salon.php",
                type : "post", 
                success: function(data){
                    $(".capa_mesas_iconos").html("");
                    $(".capa_mesas_iconos").hide();    
                    $(".lista_mesas").hide();    
                    $(".capa_lista_mesas").hide();   
                    
                    obtenerProductosMesa();
                }})       

            }
        });
    }
    
    
/***************************************************************************/    
    
    $(document).ready(function(){
        _inside_mesa = false;

/*tabmanager*/        
        tm = new tabmanager();
        tm.add(panel0);
        tm.add(_panelListaProducto);
        tm.add(_panelBusqueda);
        tm.add(_panelParciales);
        tm.add(_panelSeleccionMozo);
        tm.add(panel5);
        tm.add(panel6);
        tm.not_tab();
        tm.get_tab();
        
        tm.set_tab(".lista_mesa");
        
        $(".mesa_pos").mouseover(function(){
            $(".over").removeClass("over");
            $(this).addClass("over");
        })
        
        
        $("#ajax_css").attr("href","restaurant/salon/salon.css");
    
        $("#numero_comprobante").val(0);
        $("#numero_mesa").val(0);        
        $("#mesa_cierre").val(0);         
        LetTerChange();
        $("#Facturador").hide();
        $("#interna_mesa").hide();
        

        estado = 1;
     
        $(".capa_mesas_iconos").hide();
        
        $("#Restaurant").width(325);
        $(".capa_datos_mesa").hide();
        $(".capa_lista_productos, .capa_lista_mozos, .capa_lista_mesas").hide();
        $("#div_salon").show();
        $("#restaurant_base").hide();        
   
        show_estate();
        
        $(".mesa_desocupada, .mesa_ocupada, .mesa_ocupada_unida").click(function(){
            tm.set_tab("#Teclado_completo");
            
            _inside_mesa = true;
            $("button").bind("keypress keydown keyup", function(e){
                e.preventDefault();
            })
            
            replace_func("LetSal"," _irAFacturador();");

            //botones de la lista
            $(".lista_productos").focus(function(){
                $("#LetTexx").focus();
            });

            //remplaza letex
            $("#ConReCodigo").appendTo(".none");
            $("#LetTexDiv").html('<input class="teclado_letras" type="text" name="LetTexx" id="LetTexx" maxlength="20" />');
            
            replace_func("LetEnt"," _inicio_busqueda();");
            replace_func("NumVol","_inicio_busqueda();")
            
            
            $("#LetTexx").keyup(function(ev){
                if ($(this).val().length > 0){
                    $(".product_selected").removeClass("product_selected");
                }
                if (ev.keyCode == 13 ){
                        _inicio_busqueda();
                }
                
                if (ev.keyCode == 27 && !_bmostrar){
                    salir();
                }
                
                else if (ev.keyCode == 27 && _bmostrar) busqueda_escape();
                else if ((ev.keyCode == 38 || ev.keyCode == 40)  && $("#tblBusqueda").length == 0 ) {
                    tm.set_tab(_panelListaProducto);
                }
            });
                
            //remplaza numtex
            $("#NumTex").appendTo(".none");
            $("#NumTexDiv").html('<input class="teclado_numero" type="text" name="NumTexx" id="NumTexx" maxlength="6" />');
            $("#NumTexx").keyup(function(ev){
                if (ev.keyCode == 13){
                    
                }
            });
            
            $("#LetTexx").attr("disabled", true); 

            $("#LetTexx").focus(function(){
                LetTerChange();            
            });



            $("#LetTer").show(); 
            /*Efecto items tabla*/
            $(".capa table tr").hover(function(){$(this).addClass("selected_item")}, 
                                      function(){$(this).removeClass("selected_item")})


            $(".boton_seleccionar_mozo").click(function(){
                seleccionar_mozo_init();
            });
            $(".lblMozo").click(function(){
                seleccionar_mozo_init();
            });  
            
            
           $(".boton_unir_mesa").click(function(){
               unir_mesa_init();
            });
            
            $(".lblUnidas").click(function(){
                unir_mesa_init();
            });    
            
            $("#interna_mesa").show();
            $(".interna_salon").hide();
            
            
            $("#NumTexx").focus(function(){
                
                if ((_item.codigo > 0  && !_bmostrar) || _is_modified > 1){
                
                    $("#NumTexx").val("1");
                    $("#NumTexx").select();         
                    
                    replace_button("LetTer","busqueda_escape();","botones/vol-up.png","botones/vol-over.png");                      
                    
                    //asigna nueva funcion para agregar a la mesa                    
                    replace_func("LetEnt","enviar_cantidad();")
                    replace_func("NumVol","enviar_cantidad();")
                    $("#NumTexx").bind("keyup",function(event){
                        if (event.which == 13){
                            enviar_cantidad();
                        }
                        if (event.which == 27) busqueda_escape();
                        
                    });      
                    _is_modified = _is_modified - 1;                                        
                }
                else{
                    set_next("LetTexx", 20, 0,1);
                    $("#NumTexx").unbind("keyup");                    
                }
            })
            
            $(".opciones_restaurant").hide();
            $("#NumTexx").focusout(function(){
                  $("#NumTexx").val("");
            });
                      
            var sel_tmp  = $(this).find(".hnum_mesa").val();
            $(".lblMesa").text(sel_tmp);
            _numero_mesa = sel_tmp;
            $(".capa_datos_mesa").show(100, function(){
            $(".lista_mesa").hide();
                
                
            $.ajax({url:"Restaurant_salon.php", 
                    data: {MESAS: 1, nromesa: sel_tmp},
                    type: "POST",
                    dataType: "json",

                    success: function(data){
                        /*Datos de la mesa*/
                        $(".lblUnidas").text(data.mesas); 
                        $(".lblHora").text(data.hora); 
                        _mesa_cerrada = data.estado_mesa; 

                        if (data.mozo == 0) {
                            data.mozo = "[SEL. MOZO]";
                            $(".lblMozo").trigger("click");
                        }
                        else{
                            _numero_comprobante = data.numero_comprobante; 
                            $(".lblMozo").text(data.mozo); 
                            _numero_mozo = data.mozo_numero; 
                            $('#LetTexx').removeAttr("disabled"); 
                            obtenerProductosMesa();
                            set_next("LetTexx", 20, 0,1);return;
                            
                            
                        }     
                    }
                })  
                estado = 2;
                show_estate();             
              
            })            
              
        });        
    });
    
    
  
   // SOLO LOS ITEMS DE LA MESA SELECCIONADOS A FACTURA TEMPORAL SIN CIERRE DE LA MESA AL FINALIZAR 
    function facturaParcialMesa(){
         
        var data = [];

        $("table#parciales").find("tr").each(function(i){
            
            var newcant = $(this).find(".newcant").val();
            var old_cant = $(this).find(".old_cant").val();

            if (parseInt(newcant) <= parseInt(old_cant) && parseInt(newcant) > 0){
                data[i] = {
                    cod_articulo_lista : $(this).find(".cod_articulo_lista").val(),
                    cod_seccion_lista : $(this).find(".cod_seccion_lista").val(),
                    numero_lista : $(this).find(".numero_lista").val(),
                    descripcion_lista : $(this).find(".descripcion_lista").text(),
                    precio_lista : $(this).find(".precio_lista").text(),
                    newcant : newcant,
                    old_cant : old_cant
                };  
            }
        })
        
        var res = $.toJSON(data);
        
        
        //desgloza los items y devuelve los amovmesa que seran facturados
        
//se comprueba que no exista una factura previamente cargada
        $.ajax({url : "Restaurant_salon.php", 
                type: "post",                
                data :  {COMPROBAR_FACTURA_VACIA : 1},
               success: function(dat){
                   if (dat=="false"){
                       
                        $.ajax({data : {ENVIAR_A_FAC : 1, 
                                    datos: res, 
                                    mozo: _numero_mozo, 
                                    mesa_actual : _numero_mesa,
                                    numero_comprobante : _numero_comprobante},
                            url : "Restaurant_salon.php",
                            type : "post", 
                            success: function(){
                                for (var i = 0 ; i < data.length; i++){
//                                    alert( data[i].cod_seccion_lista+" - "+data[i].cod_articulo_lista+" - "+data[i].precio_lista+" - "+data[i].descripcion_lista+" - "+data[i].newcant);
                                    NUU( data[i].cod_seccion_lista ,data[i].cod_articulo_lista, data[i].precio_lista, data[i].descripcion_lista, data[i].newcant);
                                }
                                $("#numero_comprobante").val(_numero_comprobante);
                                $("#numero_mesa").val(_numero_mesa);

                                irAFactura();             
                            }});
                   }
                   else{
                       jAlert("No debe haber factura abierta",'Debo Retail - Global Business Solution');
                   }
               }
        });

    }

//TOTAL DE LOS ITEMS DE LA MESA A FACTURA TEMPORAL Y CIERRE DE LA MISMA AL FINALIZAR
    function enviarAFacTemporal(){
        
        if ($("#lista_prod tr").length == 0){
            $.ajax({url : "Restaurant_salon.php", 
                    type: "post",                
                    data :  {CERRAR_MESA : 1, numero_mesa :_numero_mesa, 
                           numero_comprobante : _numero_comprobante},
                   success: function(data){
                        irASalon();
                   }
            });
        }
        else{

                
            //    tm.set_tab("#popup_container");
          //      tm.get_tab();
            jConfirm('La mesa se cierra y se facturan los productos. Esta seguro?', 'Debo Retail - Global Business Solution', function(r) {

                if(r){
                    $("#numero_comprobante").val(_numero_comprobante);
                    $("#numero_mesa").val(_numero_mesa);
                    $("#mesa_cierre").val($(".res_total_mesa").text());

//se comprueba que no exista una factura previamente cargada
                    $.ajax({url : "Restaurant_salon.php", 
                            type: "post",                
                            data :  {COMPROBAR_FACTURA_VACIA : 1},
                           success: function(data){
                               if (data=="false"){
                                   $("#lista_prod tr").each(function(i){
                                        NUU( $(this).find(".cod_seccion_lista").val(),$(this).find(".cod_articulo_lista").val(),$(this).find(".precio_lista").text(),$(this).find(".descripcion_lista").text(), $(this).find(".cantidad_lista").text());
                                   });

                                    irAFactura();   
                               }
                               else{
                                     jAlert("No debe haber factura abierta",'Debo Retail - Global Business Solution');
                               }

                           }
                    });
                }
                else{
                    busqueda_escape();
                }

            }); 
        }
        
    }

//CONFIGURA LOS ELEMENTOS PARA VOLVER A OPERAR CON LA FACTURA
    function irAFactura(){
        shortcut.remove("Shift+U");
        shortcut.remove("Shift+P");
        shortcut.remove("Shift+M");               
        
        if (_inside_mesa){
            $("#NumTexDiv").html('');
            $("#NumTex").appendTo("#NumTexDiv");



            $("#LetTexDiv").html("");
            $("#ConReCodigo").appendTo("#LetTexDiv");                 
        }
        
 
       estado = 4;
       show_estate();
       replace_func("LetEnt","ReeCodigo()");
       replace_func("NumVol","ReeCodigo()");
       replace_func("LetTer","TerminarVul();");
       replace_func("LetSal","AccBotFac(10);");
        
       $("#Monedas").show();
       $("#Restaurant").hide();
    }
    
    function _irAFacturador(){

        jConfirm("¿Desea regresar al facturador?", 'Debo Retail - Global Business Solution', function(r) {
            if (r){
                j
                irAFactura()
            }
        });
        
    }

    function _inicio_busqueda(){
        
        if ($("#tblBusqueda").length == 0 && $("#LetTexx").val().length > 0){
            $(".capa_lista_productos").load("modulo.php?modulo=busqueda&param="+php_urlencode($("#LetTexx").val()),function(){
                $(".datos_mesa").hide();
                $(".boton_seleccionar_mozo, .boton_unir_mesa").hide();
                if ($("#cantidad_encontrado").val() > 1){
                     $(".capa_lista_productos").show(function(){
                         $_scrollBusqueda = _jscrollshow("#tblBusquedaScroll");
                         tm.set_tab(_panelBusqueda);
                         $(".capa_lista_productos").focus();
                       
                     });
                     replace_button("LetTer","busqueda_escape();","botones/vol-up.png","botones/vol-over.png");                      
                }
                else if ($("#cantidad_encontrado").val()==0){
                    busqueda_escape();
                    EnvAyuda("No se han encontrado productos para esta busqueda");
                    $("#LetTexx").select();
                    } else {
                        busqueda_enter();
                    }
            }); 
        }
    }

    function busqueda_enter(){     
        $(".datos_mesa").hide();
        
        var seccion =  $("#sec_over").val();
        var codigo =  $("#cod_over").val();
        var cantidad_cod_bar =  $("#cant_prod_bar").val();        
        
        $(".capa_lista_productos").html("");
        $(".capa_lista_productos").hide();        
        
        $("#LetTexx").val("");
        
        if (cantidad_cod_bar > 0){
            $(".capa_ficha_producto").load("modulo.php?modulo=ficha&codigo="+codigo+"&seccion="+seccion, function(){
                $(".capa_ficha_producto").hide();
                $("#NumTexx").val(cantidad_cod_bar);
                _item.sector = seccion;
                _item.codigo = codigo;
                _item.precio = $("#precio").val();
                _item.cantidad = $("#NumTexx").val();        
                _item.detalle = $("#detalle_articulo").val();  
                set_next("NumTexx", 5, 1,1);return;
                
            }) ;     
        }
        else{
            $(".capa_ficha_producto").load("modulo.php?modulo=ficha&codigo="+codigo+"&seccion="+seccion, function(){
                $(".capa_ficha_producto").show();
                _item.codigo = codigo;
                _item.sector = seccion;
                _item.precio = $("#precio").val();
                _item.detalle = $("#detalle_articulo").val();                    
                
                set_next("NumTexx", 5, 1,1);return;
            }) ;             
        }        
        tm.reset();
    }
    
    function busqueda_escape(){
        
        tm.set_tab("default");
        $("#LetTexx").removeAttr("disabled");               
        
        $(".capa_ficha_producto").html("");
        $(".capa_ficha_producto").hide(); 
        
        $(".capa_lista_productos").html("");
        $(".capa_lista_productos").hide(); 

        $(".capa_mesas_iconos").html("");
        $(".capa_mesas_iconos").hide(); 
        
        $(".capa_lista_mesas").hide(); 
        $(".lista_mesas").hide(); 
        
        
        $(".parciales").hide(); 
        $(".lista_mozos").hide();
        
        $(".datos_mesa").show();
        $(".in_parcial").hide();
        
        $(".boton_seleccionar_mozo, .boton_unir_mesa").show();
        
        $("#btnCerrarListaParcial").hide();
        if ($("#parciales tr").length > 0)
            $("#btnListaParcial").show();
        reset_item();
        $("#NumTexx").val("");
        _bmostrar = false;
        _bediting = false;
        
        set_next("LetTexx",30,0,2);
    }
    

    function reset_item(){
        _item.sector = $("#cod_seccion").val();
        _item.codigo = $("#cod_articulo").val();
        _item.precio = $("#precio").val();
        _item.cantidad = $("#NumTexx").val();        
        _item.detalle = $("#detalle_articulo").val();         
    }
    

    
    function modificarItemMesa(){       
        if ($("#LetTexx").val().length  == 0){
            _is_modified = 3;
            set_next("NumTexx", 5, 1,1);             
        }        
    }
    

    
    function mostrarProductoSeleccionado(){
        if (!_bediting){
            _bmostrar = true;
            $(".capa_ficha_producto").load("modulo.php?modulo=ficha&codigo="+_selected_element.cod+"&seccion="+_selected_element.sec, function(){
                $(".capa_lista_productos").html("");
                $(".capa_lista_productos").hide();

                $(".datos_mesa").hide();                
                $(".capa_ficha_producto").show();

                $(".boton_seleccionar_mozo, .boton_unir_mesa").hide();

            }) ;  
        }
        else{
            
        }
    }   
    
    function mostrar_parciales(){
        $(".boton_unir_mesa").eq(0).focus();
     

        
        
        if ($(".item_marcado").length == 0) return;
        $(".capa_ficha_producto").html("");
        $(".capa_ficha_producto").hide(); 
        
        $(".capa_lista_productos").html("");
        $(".capa_lista_productos").hide(); 
        
        $(".parciales").hide(); 
        $(".lista_mozos").hide();
  
        
        $(".boton_seleccionar_mozo, .boton_unir_mesa").hide();
        $(".datos_mesa").hide();
        
        _bmostrar = true;
        $(".parciales").show(function(){
            $(".newcant").eq(0).focus();
            tm.set_tab(_panelParciales);
        });
        $("#btnListaParcial").hide();
        $("#btnCerrarListaParcial").show();
        
        $(".selected_cant").removeClass("selected_cant");
        $("#parciales tr").first().addClass("selected_cant");
        $(".in_parcial").show();        
    }
    
    function arriba_parciales(){
        
        if ( $("#parciales tr.selected_cant").length > 0){
            if ($("tr.selected_cant").prev().length != 0 ){
                var $prev = $(".selected_cant").prev();
                $(".selected_cant").removeClass("selected_cant");
                $prev.addClass("selected_cant");
                $prev.find(".newcant").focus().select();
            }
        }
        else{
            $(".selected_cant").removeClass("selected_cant");
            $("#parciales tr").first().addClass("selected_cant");
            $("#parciales tr").find(".newcant").first().focus().select();
        }
    }
    
    function abajo_parciales(){
        
        if ( $("#parciales tr.selected_cant").length > 0){
            if ($("tr.selected_cant").next().length != 0 ){
                var $next = $(".selected_cant").next();
                $(".selected_cant").removeClass("selected_cant");
                $next.addClass("selected_cant");
                $next.find(".newcant").focus().select();                
            }
        }
        else{
            $(".selected_cant").removeClass("selected_cant");
            $("#parciales tr").first().addClass("selected_cant");
            $("#parciales tr").find(".newcant").first().focus().select();
        }
    }
    
    function enviar_cantidad(){
        if ($("#NumTexx").val()>0){ 
            _item.cantidad = $("#NumTexx").val();        
            cargarProductoaMesa();
            set_next("LetTexx", 20, 0,1);        
        }
    }



    

    

    

    
    function unir_mesa_init(){
        $(".boton_unir_mesa").hide();
        
        if (_numero_mozo < 0) {
            jAlert("Debe abrir la mesa seleccionando un mozo","Debo Retail - Global Business Solution")  ;
            return;
        }
        $(".capa_lista_mesas").show();            
        $.ajax({url:"Restaurant_salon.php", 
                data: {LISTA_MESAS: 1, numero_mesa: _numero_mesa},
                type: "POST",
                success: function(data){
                    $(".boton_unir_mesa, #btnListaParcial, .boton_seleccionar_mozo").hide();
                    $(".capa_mesas_iconos").html(data);
                    $(".capa_mesas_iconos").show();  
                    $("#LetTexx").parent().removeClass("active");
                    $("#LetTexx").attr("disabled","true");
                    tm.set_tab(".capa_mesas_iconos");
                }
            })  
    }
    
             
             
     function salir(){
         
         if ($("#LetTexx").val().length == 0){
             jConfirm("Desea salir de la mesa?","Debo Retail - Global Business Solution",function(r){
                 if (r){
                     irASalon();
                 }
                 else busqueda_escape();
             })
         }
         else{
             busqueda_escape();
         }
     }
     
     
