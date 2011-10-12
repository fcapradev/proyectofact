<?php

?>
<div id="contentTabla">
    <div id="tblBusquedaScroll">
    <table id="tblBusqueda">
        <tbody>
            <?php foreach($lista as $item){ ?>
            <tr>
                <td class="seccion"><?=$item['sec']?></td>
                <td class="codigo"><?=$item['art']?></td>
                <td class="descripcion"><?=htmlentities(trim($item['det']))?></td>
                <td class="precio"><?=$item['preven']?></td>
            </tr>
            <?php } ?>
        </tbody>
    </table>
    </div>
    <button class="boton_canelar_mozo" onclick="busqueda_escape();" class="StyBoton" onmouseout="MM_swapImgRestore()" onmouseover="MM_swapImage('btnCancelarMozo','','botones/can-over.png',0)"><img src="botones/can-up.png" name="Enter" title="Enter" border="0" id="btnCancelarMozo"/></button>

</div>



<!-- Cantidad de productos encontrados -->
<input type="hidden" id="cantidad_encontrado" value="<?=count($lista)?>" />


<!-- Datos del producto para la ficha -->
<input type="hidden" id="cod_over" value="<?=@$lista[0]['art']?>" />
<input type="hidden" id="sec_over" value="<?=@$lista[0]['sec']?>" />


<!-- Cantidad de productos autoselecionados para el codigo de barra -->
<input type="hidden" id="cant_prod_bar" value="<?=$cantidad?>" />


