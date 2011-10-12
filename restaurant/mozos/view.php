

    




		<div id="" class="lista" >
			
		
                    <div id="lista_mozo" style="cursor:pointer;" >
                        <?php mostrarMozos(); ?>
                    </div>
                </div>

<div class="panel_edicion">
    <table>
        <tr>           
            <td>
                <div class="div-redondo active" >
                    <input type="text" name="num" id="num" class="texteca fondoBlanco " />
                    <input type="hidden" name="tipo" id="tipo" value="0"/>
                </div>
            </td>
        </tr>
        <tr>
            <td>
                <div class="div-redondo" >
                    <input type="text" name="nom" id="nom" class="texteca fondoBlanco" />
                </div>
            </td>
        </tr>
        <tr>
            <td>
                <div class="div-redondo" >
                <input type="text" name="dire" id="dire" class="texteca fondoBlanco" />
            </div>
        </td>
        </tr>
        <tr>
            <td>
                <div class="div-redondo" >
                    <input type="text" name="comi" id="comi" class="texteca fondoBlanco" />
                </div>                
            </td>
        </tr>
        <tr>
            <td>
                <div class="div-redondo" >
                    <input type="text" name="estado" id="estado" class="texteca fondoBlanco" />
                </div>                
            </td>
        </tr>
    </table>
    <div class="boton_guardar">
        <button onclick="guardar();" class="StyBoton" onmouseout="MM_swapImgRestore()" onmouseover="MM_swapImage('btnGuardar','','botones/gra-over.png',0)"><img src="botones/gra-up.png" name="Enter" title="Enter" border="0" id="btnGuardar"/></button>
    </div>
    <div class="boton_agregar">
        <button onclick="insertarNuevo();" class="StyBoton" onmouseout="MM_swapImgRestore()" onmouseover="MM_swapImage('btnGuardar','','botones/bot-agregar-mozo-over.png',0)"><img src="botones/bot-agregar-mozo-up.png" name="Enter" title="Enter" border="0" id="btnGuardar"/></button>
    </div>
    
</div>


