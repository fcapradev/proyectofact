<div id="ficha">
    <span class="sp_imagen"><img src="<?=$path?>" width="490" height="255" /></span>
    <span class="sp_codigo"><?=$codigo?></span>
    <span class="sp_seccion"><?=$seccion?></span>
    <span class="sp_descripcion"><?=htmlentities(trim($detalle))?></span>
    <span class="sp_stock_deposito"><?=$stock_dep?></span>
    <span class="sp_stock_venta"><?=$stock_vta?></span>
    
    <span class="sp_check_espromo <?=$es_promo==0 ? "" : "none" ?>"></span>
    <span class="sp_check_fpp <?=$forma_parte_promo==0 ? "" : "none" ?>"></span>
    
    
    <span class="sp_precio"><?=$precio?></span>
</div>

    <button class="boton_canelar_mozo" onclick="busqueda_escape();" class="StyBoton" onmouseout="MM_swapImgRestore()" onmouseover="MM_swapImage('btnCancelarMozo','','botones/can-over.png',0)"><img src="botones/can-up.png" name="Enter" title="Enter" border="0" id="btnCancelarMozo"/></button>
    
    <input type="hidden" id="pid" value="<?=$pid?>" />