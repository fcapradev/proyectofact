
<!-- Restaurant Salon -->
<div id="salon_principal">
    
    <!-- Contenedor de la mesa seleccionada -->
    <div id="interna_mesa">
        <div id="opciones_mesas">
            <button onclick="irASalon();" class="StyBoton" onmouseout="MM_swapImgRestore()" onmouseover="MM_swapImage('btnSalon','','botones/botonvolver-over.png',0)"><img src="botones/botonvolver-up.png" name="Enter" title="Enter" border="0" id="btnSalon"/></button>
        </div>
        <div class="capa_datos_mesa">
            <div class="datos_mesa lista">   
                <label class="lblMesa">Mesa</label>
                <label class="lblHora">Hora</label>
                <label class="lblUnidas">[...]</label>
                <label class="lblMozo">[...]</label>
                <!-- scroll div, no puede tener elementos que no hagan scroll -->
                <div class="lista_productos">
                    <table id="lista_prod">
                        <tbody>
                        </tbody>
                   </table>   
                </div>
                <!--  Copia fila de tabla para la lista  -->
                <table id="mod_lista">
                    <tr>
                        <input type="hidden" class="cod_articulo_lista" />
                        <input type="hidden" class="cod_seccion_lista" />
                        <input type="hidden" class="numero_lista" />
                        
                        <td class="marca" onclick="marcaItems(this); seleccionarProductoView(this); "  ></td>
                        <td class="cod_articulo_seccion_lista"  onclick="seleccionarProductoView(this);"></td>  
                        <td class="descripcion_lista"  onclick="seleccionarProductoView(this);"></td>
                        <td class="cantidad_lista"  onclick="seleccionarProductoView(this);"></td>                        
                        <td class="precio_lista"  onclick="seleccionarProductoView(this);"></td>
                        <td class="precio_total_lista"  onclick="seleccionarProductoView(this);"></td>
                        <td class="opcion_modificar"  onclick="seleccionarProductoView(this);"></td>
                        <td class="opcion_eliminar"  onclick="seleccionarProductoView(this);"></td>
                        <td class="opcion_ver"   onclick="seleccionarProductoView(this);"></td>
                    </tr>
                </table>

                <label class="res_total_mesa">0</label>                          
            </div>    
            <!-- Mostrar items parciales para facturar o enviar a otra mesa -->
            <div class="parciales capa">
                <div class="parciales_scroll">
                    <table id="parciales">

                    </table>  
                </div>
                <label class="parcial_total"></label>
            </div> 
            
            <!-- seleccion de mozos -->
            <div class="capa_lista_mozos capa">
                <div class="lista_mozos lista">  
                    <div class="mozo_scroll">
                        <ul>
                        <?php foreach($mozos as $mozo){ ?>
                            <li onclick='seleccionar_mozo(<?=$mozo['NMO']?>, "<?=$mozo['NOM']?>");'  class="item_mozo">
                                <span ><?=$mozo['NOM']?></span>
                            </li>
            <?php            }?>
                        <ul>
                    </div>
                    <button class="boton_canelar_mozo" onclick="salir_mozo();" class="StyBoton" onmouseout="MM_swapImgRestore()" onmouseover="MM_swapImage('btnCancelarMozo','','botones/can-over.png',0)"><img src="botones/can-up.png" name="Enter" title="Enter" border="0" id="btnCancelarMozo"/></button>

                </div>    
            </div>
            
            
            <!-- Ficha Producto -->
            <div class="capa_ficha_producto">
            </div>
            
            
            <!-- Lista Productos -->
            <div class="capa_lista_productos capa">
            </div>


            <!-- seleccion de mesas -->
            <div class="capa_lista_mesas capa">
                <div class="lista_mesas lista" id="div_mesas">   

                </div>    
            </div>

            <!-- seleccion de mesa para enviar productos -->
            <div class="capa capa_mesas_iconos">
            </div>   
            
            <!-- Abrir Lista Parcial -->
            <button id="btnListaParcial" onclick="mostrar_parciales();" class="StyBoton" onmouseout="MM_swapImgRestore()" onmouseover="MM_swapImage('btnVerParciales','','botones/bot-lista-parcial-over.png',0)"><img src="botones/bot-lista-parcial-up.png" name="Enter" title="Enter" border="0" id="btnVerParciales"/></button>            
            <button id="btnCerrarListaParcial" onclick="busqueda_escape();" class="StyBoton" onmouseout="MM_swapImgRestore()" onmouseover="MM_swapImage('btnVerParciales','','botones/bot-ocultar-lista-over.png',0)"><img src="botones/bot-ocultar-lista-up.png" name="Enter" title="Enter" border="0" id="btnVerParciales"/></button>            

            <button class="in_parcial boton_parcial_facturar StyBoton " onclick="facturaParcialMesa();" onmouseout="MM_swapImgRestore()" onmouseover="MM_swapImage('btnFacParcial','','botones/boton-facturacion-parcial-over.png',0)"><img src="botones/boton-facturacion-parcial-up.png" name="Enter" title="Enter" border="0" id="btnSelMesa"/></button>
            <button class="in_parcial  boton_parcial_seleccionar_mesa StyBoton" onclick="seleccionarMesa();" onmouseout="MM_swapImgRestore()" onmouseover="MM_swapImage('btnSelMesa','','botonesboton-a-mesa-over.png',0)"><img src="botones/boton-a-mesa-up.png" name="Enter" title="Enter" border="0" id="btnSelMesa"/></button>

            <button class="boton_seleccionar_mozo StyBoton "  onmouseout="MM_swapImgRestore()" onmouseover="MM_swapImage('btnFacParcial','','botones/bot-cambiar-mozo-over.png',0)"><img src="botones/bot-cambiar-mozo-up.png" name="Enter" title="Enter" border="0" id="btnSelMesa"/></button>
            <button class="boton_unir_mesa StyBoton" onmouseout="MM_swapImgRestore()" onmouseover="MM_swapImage('btnSelMesa','','bot-unir-over.png',0)"><img src="botones/bot-unir-up.png" name="Enter" title="Enter" border="0" id="btnSelMesa"/></button>
            
            
        </div>  
    </div>
    
    <!-- BOTONES SUPERIORES -->
    <div class="opciones_salon interna_salon">
        <button onclick="EditarMesas();" class="StyBoton" onmouseout="MM_swapImgRestore()" onmouseover="MM_swapImage('btnEditarMesa','','botones/boton-editar-mesa-over.png',0)"><img src="botones/boton-editar-mesa-up.png" name="Enter" title="Enter" border="0" id="btnEditarMesa"/></button>
        <button onclick="EditarMozos();" class="StyBoton" onmouseout="MM_swapImgRestore()" onmouseover="MM_swapImage('btnEditarMozo','','botones/boton-editar-mozo-over.png',0)"><img src="botones/boton-editar-mozo-up.png" name="Enter" title="Enter" border="0" id="btnEditarMozo"/></button>
        <button onclick="SalirSalon();" class="StyBoton" onmouseout="MM_swapImgRestore()" onmouseover="MM_swapImage('btnSalirSalon','','botones/botonvolver-over.png',0)"><img src="botones/botonvolver-up.png" name="Enter" title="Enter" border="0" id="btnSalirSalon"/></button>
    </div>
   
    <!-- Grilla de mesas -->
    <div class="lista_mesa interna_salon">
        <?php 
        $arr_mesas = $data->get_tabla("AMESAS");
        $mesas = array();
        for($i = 0 ; $i < count($arr_mesas) ; $i++){
            $mesas[$arr_mesas[$i]['POS']] = $arr_mesas[$i];
        }

        for($i = 0 ; $i < 24 ; $i++){ 
            $class="mesa";
            
            if (isset($mesas[$i]['POS'])){
                $num_mesa = $mesas[$i]['MRT'];
                if($mesas[$i]['EST']=='O') 
                    if ($mesas[$i]['UNI']==0) $class="mesa_ocupada";
                    else  {
                        $class="mesa_ocupada_unida";
                        $num_mesa = $mesas[$i]['UNI'];
                    }
                else if ($mesas[$i]['EST']=='D') $class="mesa_desocupada";
            }

            ?>
        <div class="mesa_pos <?=isset($mesas[$i]['POS'])?$class:""?>" id="mesa_<?=$i?>">
            <span class="sp_numero_mesa"><?=isset($mesas[$i]['POS']) ? $mesas[$i]['MRT'] : "" ?></span>
            <input type="hidden" class="hnum_mesa" value="<?=isset($mesas[$i]['POS']) ? $num_mesa : "" ?>"/>
            <span class="sp_nombre_mesa"></span>
        </div>
        <?php } ?>

    </div>

    <!-- Internas de edicion y login para edicion -->
   <div id="login_admin" class="opciones_restaurant"></div>
   <div id="admin_mesas" class="opciones_restaurant"></div>
   <div id="admin_mozos" class="opciones_restaurant"></div> 
   <input type="hidden" id="numero_comprobante" value="-1"/>
</div>


<input type="hidden" value="" id="retorno_salon" />

<input type="text" id="foc" style="position: absolute; left:850px; top: 0px"/>

