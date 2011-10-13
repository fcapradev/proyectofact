

    


<input type="hidden" id="selected_mesa" value="" />

<div class="capa_edicion">
    <div class="nombre_mesa">
            <div class="div-redondo div-text" >
                <input type="text" maxlength="2" name="nombre" id="nombre" class="texteca" />
            </div>
    </div>
</div>
		
                    <div class="lista_mesa">
                        <?php 
                        $arr_mesas = $data->get_tabla("AMESAS");
                        $mesas = array();
                        for($i = 0 ; $i < count($arr_mesas) ; $i++){
                            $mesas[$arr_mesas[$i]['POS']] = $arr_mesas[$i];
                        }
                        
                        for($i = 0 ; $i < TOTAL_MESAS ; $i++){ ?>
                        <div class="mesa_pos <?=isset($mesas[$i]['POS'])?"mesa_edicion":""?>" id="mess_<?=$i?>">
                            <span class="sp_numero_mesa"><?=isset($mesas[$i]['POS']) ? $mesas[$i]['MRT'] : "" ?></span>
                            <span class="sp_nombre_mesa"></span>
                        </div>
                        <?php } ?>
                       
                    </div>



    
    <input type="hidden" id="mover" value="0" />
    
    
    

        <button id="btnAgregarMesa" onclick="agregarMesa();" class="StyBoton" onmouseout="MM_swapImgRestore()" onmouseover="MM_swapImage('btnAgregar','','botones/bot-agregar-mesa-over.png',0)"><img src="botones/bot-agregar-mesa-up.png" name="Enter" title="Enter" border="0" id="btnAgregar"/></button>

        <button id="btnEliminarMesa" onclick="eliminarMesa();" class="StyBoton" onmouseout="MM_swapImgRestore()" onmouseover="MM_swapImage('btnEliminar','','botones/eli-over.png',0)"><img src="botones/eli-up.png" name="Enter" title="Enter" border="0" id="btnEliminar"/></button>


        <button id="btnMoverMesa" onclick="moverMesa();" class="StyBoton" onmouseout="MM_swapImgRestore()" onmouseover="MM_swapImage('btnMover','','botones/bot-mover-mesa-over.png',0)"><img src="botones/bot-mover-mesa-up.png" name="Enter" title="Enter" border="0" id="btnMover"/></button>
        <button onclick="irASalon();" class="StyBoton" onmouseout="MM_swapImgRestore()" onmouseover="MM_swapImage('btnSalirEdicionMesa','','botones/botonvolver-over.png',0)"><img src="botones/botonvolver-up.png" name="Enter" title="Enter" border="0" id="btnSalirEdicionMesa"/></button>




