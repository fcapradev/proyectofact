<?
require("config/cnx.php");

//CAPRA FRANCO - 15/08/11 - 15:12
//VALLEJO FABIAN - 12/09/11 - 12:30

//SESSION
$idope = $_SESSION['idsusua'];
$ope = $_SESSION['idsusun'];
$EMP = $_SESSION['ParEMP'];

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Compras</title>
<link href="Compras/ComCss.css" rel="stylesheet" type="text/css" />

<script type="text/javascript" language="javascript" src="Compras/ComJav1.js"></script>
<script type="text/javascript" language="javascript" src="Compras/ComJav2.js"></script>
<script type="text/javascript" language="javascript" src="Compras/ComJav3.js"></script>

<script>

$(document).ready(function(){
    $('#FormEncabezadoCom').submit(function() {
        $.ajax({
            type: 'POST',
            url: $(this).attr('action'),
            data: $(this).serialize(),
            success: function(data) {
                $('#archivos').html(data);
            }
        })        
        return false;
    });
    $('#FormPie').submit(function() {
        $.ajax({
            type: 'POST',
            url: $(this).attr('action'),
            data: $(this).serialize(),
            success: function(data) {
                $('#archivos').html(data);
            }
        })        
        return false;
    });
    $('#FormaPorEventual').submit(function() {
        $.ajax({
            type: 'POST',
            url: $(this).attr('action'),
            data: $(this).serialize(),
            success: function(data) {
                $('#archivos').html(data);
            }
        })        
        return false;
    });	
})

SoloNone("ComBotEncDiv");

$("#EncDat3").css("border-color", "#F90");


</script>

</head>
<body>


<input type="hidden" id="NumEmpresa" name="NumEmpresa" value="<? echo $EMP; ?>" />

<input type="hidden" id="HabFunModCom" name="HabFunModCom" value="0" />

<input type="hidden" id="pantallacompra" name="pantallacompra" value="0" />

<input type="hidden" id="Consulta" name="pantallacompra" value="0" />



<div id="botonComprasA" style="position:absolute; top:334px; left:695px; display:block; z-index:3;">
    <button class="StyBoton" onClick="comprasauto();" onMouseOut="MM_swapImgRestore()" onMouseOver="MM_swapImage('BotComAut','','Compras/comaut/botcomaut-over.png',0)" title="Compras Autom&aacute;ticas">
    <img src="Compras/comaut/botcomaut-up.png" border="0" id="BotComAut"/></button>
</div>


<div id="ComprasFondo">

	<img src="Compras/fon_tit.png" />
    <div id="botoncerrar">
        <button class="StyBoton" onClick="botoncerrar();" onMouseOut="MM_swapImgRestore()" onMouseOver="MM_swapImage('BotCerrar','','otros/cru-over.png',0)">
        <img src="otros/cru-up.png" border="0" id="BotCerrar"/></button>
    </div>

</div>

<div id="ComprasDatos">
	
    <div id="EncabezadoLat"><img src="Compras/enc_lat.png" /></div>
    <div id="EncabezadoDLat">
    
    	<div id="EncLat1">
        	<input type="text" class="texteca" id="EncLatI-1" name="EncLatI-1" value="<? echo $idope; ?>" style="width:67px;" />
        </div>
        <div id="EncLat2">
	        <input type="text" class="texteca" id="EncLatI-2" name="EncLatI-2" style="width:67px;" />
        </div>
        <div id="EncLat3">
	        <input type="text" class="texteca" id="EncLatI-3" name="EncLatI-3" style="width:67px;" />
        </div>
        <div id="EncLat4">
        	<input type="text" class="texteca" id="EncLatI-4" name="EncLatI-4" style="width:67px;" />
        </div>
        <div id="EncLat5">
        	<input type="text" class="texteca" id="EncLatI-5" name="EncLatI-5" style="width:67px;" />
        </div>
        <div id="EncLat6">
        	<input type="text" class="texteca" id="EncLatI-6" name="EncLatI-6" style="width:67px;" />
        </div>
    </div>
    
<form id="FormEncabezadoCom" name="FormEncabezadoCom" action="REncabezado.php" method="post">
    
	<div id="ComprasDfon"></div>

	<div id="Encabezado"><img src="Compras/encabezado.png" /></div>
	<div id="EncabezadoDat">
		
        <div id="EncDat1">
        	<input type="text" class="texteca" id="EDat1" name="EDat1" value="<? echo $idope; ?>" style="width:55px;" />
        </div>
        <div id="EncDat2">
			<input type="text" class="texteca" id="EDat2" name="EDat2" value="<? echo $ope; ?>" style="width:204px;" />
        </div>
        <div id="EncDat3" class="div-redondo" style="width:51px; height:20px;">
        	<input type="text" class="texteca" id="EDat3" name="EDat3" style="width:55px; top:-2px; left:-3px; position:absolute;" onkeypress="return ControlEDat3();" maxlength="5" />
        </div>
        <div id="EncDat4">
        	<input type="text" class="texteca" id="EDat4" name="EDat4" style="width:204px;" />
        </div>
        <div id="EncDat5" class="div-redondo" style="width:51px; height:20px;">
        	<input type="text" class="texteca" id="EDat5" name="EDat5" style="width:55px; top:-2px; left:-3px; position:absolute;" onkeypress="return ControlEDat5();" onkeydown="return ControlEDat5Vol();" maxlength="1" />
        </div>
        <div id="EncDat6">
        	<input type="text" class="texteca" id="EDat6" name="EDat6" style="width:204px;" />
        </div>
		
            <div id="EncDat771"><img src="Compras/com.png" /></div>
                <div id="EncDat7-1" class="div-redondo" style="width:51px; height:20px;">
                    <input type="text" class="texteca" id="EDat7_1" name="EDat7_1" style="width:55px; top:-2px; left:-3px; position:absolute;" onkeypress="return ControlEDat7_1();" onkeydown="return ControlEDat7_1Vol();" maxlength="4" />
                </div>        
                <div id="EncDat7-2" class="div-redondo" style="width:19px; height:20px;">
                    <input type="text" class="texteca" id="EDat7_2" name="EDat7_2" style="width:23px; top:-3px; left:-2px; position:absolute; text-transform:uppercase" onkeypress="return ControlEDat7_2();" onkeydown="return ControlEDat7_2Vol();" onkeyup="convertirL('EDat7_2');" maxlength="1" />
                    <input type="hidden" id="EDat7_2_T" name="EDat7_2_T">
                </div>
                <div id="EncDat7-3" class="div-redondo" style="width:21px; height:20px;">
                    <input type="text" class="texteca" id="EDat7_3" name="EDat7_3" style="width:26px; top:-3px; left:-2px; position:absolute;" onkeypress="return ControlEDat7_3();" onkeydown="return ControlEDat7_3Vol();"  onkeyup="convertirL('EDat7_3');" maxlength="2"/>
                </div>
                <div id="EncDat7-4" class="div-redondo" style="width:83px; height:20px;">
                    <input type="text" class="texteca" id="EDat7_4" name="EDat7_4" style="width:89px; top:-3px; left:-2px; position:absolute;"  onkeypress="return ControlEDat7_4();" onkeydown="return ControlEDat7_4Vol();" maxlength="8" />
                </div>
            <div id="EncDat772"><img src="Compras/nar_com.png" /></div>
        
        <div id="EncDat8" class="div-redondo" style="width:95px; height:19px;">
        	<input type="text" class="texteca" id="EDat8" name="EDat8" style="width:100px; top:-3px; left:-2px; position:absolute;"  onkeypress="return ControlEDat8();" onkeydown="return ControlEDat8Vol();"  maxlength="10" />
        </div>
        <div id="EncDat9" class="div-redondo" style="width:95px; height:19px;">
        	<input type="text" class="texteca" id="EDat9" name="EDat9" style="width:100px; top:-3px; left:-2px; position:absolute;" onkeypress="return ControlEDat9();" onkeydown="return ControlEDat9Vol();"  maxlength="10" />
        </div>
        <div id="EncDat10">
        	<input type="hidden" id="EDat10Val" name="EDat10Val" value="3" />
            <input type="text" class="texteca" id="EDat10" name="EDat10" readonly="readonly" style="width:137px; color:#FFF;" value="CONTADO" onkeypress="return ControlEDat10();" onkeydown="return ControlEDat10Vol();" />
        </div>
        <div id="EncDat11" class="div-redondo" style="width:146px; height:20px;">
        	<input type="text" class="texteca" id="EDat11" name="EDat11" style="width:152px; top:-2px; left:-3px; position:absolute;" / onkeypress="return ControlEDat11();" onkeydown="return ControlEDat11Vol();" maxlength="15">
        </div>
        <div id="EncDat12" class="div-redondo" style="width:95px; height:20px;">
        	<input type="text" class="texteca" id="EDat12" name="EDat12" style="width:99px; top:-2px; left:-3px; position:absolute;"  onkeypress="return ControlEDat12();" onkeydown="return ControlEDat12Vol();"  maxlength="10" />
        </div>
        <div id="EncDat13" class="div-redondo" style="width:98px; height:20px;">
        	<input type="text" class="texteca" id="EDat13" name="EDat13" style="width:103px; top:-2px; left:-3px; position:absolute;" / onkeypress="return ControlEDat13();" onkeydown="return ControlEDat13Vol();"  maxlength="10" >
        </div>
        <div id="EncDat14" class="div-redondo" style="width:98px; height:20px;">
        	<input type="text" class="texteca" id="EDat14" name="EDat14" style="width:103px; top:-2px; left:-3px; position:absolute;" / onkeypress="return ControlEDat14();" onkeydown="return ControlEDat14Vol();"  maxlength="8" >
        </div>
        <div id="EncDat15" class="div-redondo" style="width:98px; height:20px;">
        	<input type="text" class="texteca" id="EDat15" name="EDat15" style="width:103px; top:-2px; left:-3px; position:absolute;" / onkeypress="return ControlEDat15();" onkeydown="return ControlEDat15Vol();"  maxlength="10" >
        </div>
        <div id="EncDat16" class="div-redondo" style="width:98px; height:20px;">
        	<input type="text" class="texteca" id="EDat16" name="EDat16" style="width:103px; top:-2px; left:-3px; position:absolute;" / onkeypress="return ControlEDat16();" onkeydown="return ControlEDat16Vol();"  maxlength="4" >
        </div>
        <div id="EncDat17" class="div-redondo" style="width:98px; height:20px;">
        	<input type="text" class="texteca" id="EDat17" name="EDat17" style="width:103px; top:-2px; left:-3px; position:absolute;" / onkeypress="return ControlEDat17();" onkeydown="return ControlEDat17Vol();"  maxlength="2" >
        </div>
        <div id="EncDat18" class="div-redondo" style="width:98px; height:20px;">
        	<input type="text" class="texteca" id="EDat18" name="EDat18" style="width:103px; top:-2px; left:-3px; position:absolute;" / onkeypress="return ControlEDat18();" onkeydown="return ControlEDat18Vol();" maxlength="8" >
        </div>

    <input type="hidden" id="EDat19" name="EDat19" value="0" />
    
    <input type="hidden" id="Modifica" name="Modifica" value="0" />
    
    <input type="hidden" id="permiso" name="permiso" value="0" />
   
</form>	

	</div>

	<div id="Proveedores"><img src="Compras/con_nar_pro.png" /></div>
	<div id="ProveedoresDat">
    
        <div id="ComDatosFon"><img src="Compras/bus_pro.png" /></div>
    	
        <div id="ComDatos"></div>
        
        <div id="ComDatosEventualFon"><img src="Compras/fon_pro.png" /></div>
        
        <form id="FormaPorEventual" name="FormaPorEventual" action="ComModEve.php" method="post">
            <div id="ComDatosEventual">
                
                <div id="Eve1" class="div-redondo" style="position:absolute; top:66px; left:103px; width:212px; height:23px;">
                    <input type="text" id="Eventual1" name="Eventual1" class="texteca3" style="width:200px; position:absolute; top:-2px; left:5px;" />
                </div>
                <div id="Eve2" class="div-redondo" style="position:absolute; top:127px; left:103px; width:212px; height:23px;">
                    <input type="text" id="Eventual2" name="Eventual2" class="texteca3" style="width:200px; position:absolute; top:-2px; left:5px;" />
                </div>
                <div id="Eve3" class="div-redondo" style="position:absolute; top:187px; left:103px; width:212px; height:23px;">
                    <input type="text" id="Eventual3" name="Eventual3" class="texteca3" style="width:200px; position:absolute; top:-2px; left:5px;" />
                </div>
                <div id="Eve4" class="div-redondo" style="position:absolute; top:66px; left:341px; width:53px; height:23px;">
                    <input type="text" id="Eventual4" name="Eventual4" class="texteca3" style="width:40px; position:absolute; top:-2px; left:5px;" />
                </div>
                <div id="Eve5" class="div-redondo" style="position:absolute; top:66px; left:398px; width:153px; height:23px;">
                    <input type="text" id="Eventual5" name="Eventual5" class="texteca3" style="width:140px; position:absolute; top:-2px; left:5px;" />
                </div>
                <div id="Eve6" class="div-redondo" style="position:absolute; top:127px; left:341px; width:53px; height:23px;">
                    <input type="text" id="Eventual6" name="Eventual6" class="texteca3" style="width:40px; position:absolute; top:-2px; left:5px;" />
                </div>
                <div id="Eve7" class="div-redondo" style="position:absolute; top:127px; left:398px; width:153px; height:23px;">
                    <input type="text" id="Eventual7" name="Eventual7" class="texteca3" style="width:140px; position:absolute; top:-2px; left:5px;" />
                </div>
    
            </div>
		</form>
        
        <div id="ComDatosEventualBot" onClick="MeterTip(5);">
        	<div class="SinTilde" id="Tipo5"></div>
            <div class="TitTilde">&nbsp; Eventual</div>
        </div>
        
        
        <div id="ComDatosFor">
        	
        <table height="60" border="0" cellpadding="0" cellspacing="0">
        <tr>
        <td width="117">
        	<div onClick="MeterTip(1);">
                <div class="Sombra14 ConTilde" id="Tipo1"></div>
                <div class="TitTilde">&nbsp; Nombre</div>
			</div>
        </td>
        <td width="117">
        	<div onClick="MeterTip(4);">
                <div class="SinTilde" id="Tipo4"></div>
                <div class="TitTilde" >&nbsp; Alias</div>
			</div>
        </td>
        <td width="117">
        	<div onClick="MeterTip(2);">        
                <div class="SinTilde" id="Tipo2"></div>
                <div class="TitTilde" >&nbsp; Dirección</div>
			</div>
        </td>
        <td width="117">
        	<div onClick="MeterTip(3);">        
                <div class="SinTilde" id="Tipo3"></div>
                <div class="TitTilde" >&nbsp; Cuit</div>    
			</div>
        </td>
        <td width="123">&nbsp;</td>
        <td width="40" align="right">
            <div style="width:40px;">
              <button class="StyBoton" onClick="MeterTipo(1);" onMouseOut="MM_swapImgRestore()" onMouseOver="MM_swapImage('ComBotaz','','Compras/bot-az-over.png',0)">
              <img src="Compras/bot-az-up.png" border="0" id="ComBotaz" class="Sombra5" /></button>
            </div>
            <div style="width:40px;">
              <button class="StyBoton" onClick="MeterTipo(4);" onMouseOut="MM_swapImgRestore()" onMouseOver="MM_swapImage('ComBotcc','','Compras/bot-cc-over.png',0)">
              <img src="Compras/bot-cc-up.png" border="0" id="ComBotcc"/></button>
            </div>
        </td>
        <td width="10">&nbsp;</td>
        <td width="40" align="right">
            <div style="width:45px;">
              <button class="StyBoton" onClick="MeterTipo(2);" onMouseOut="MM_swapImgRestore()" onMouseOver="MM_swapImage('ComBotza','','Compras/bot-za-over.png',0)">
              <img src="Compras/bot-za-up.png" border="0" id="ComBotza" /></button>
            </div>
            <div style="width:45px;">
              <button class="StyBoton" onClick="MeterTipo(3);" onMouseOut="MM_swapImgRestore()" onMouseOver="MM_swapImage('ComBotab','','Compras/bot-abr-over.png',0)">
              <img src="Compras/bot-abr-up.png" border="0" id="ComBotab" class="Sombra5" /></button>
            </div>
        </td>
        </tr>
		</table>
        
        </div>
        
	</div>
	
    <div id="FormaPagoFon"><img src="Compras/fdpago.png" /></div>
	<div id="FormaPago">
	</div>
	    
    <div id="DesImputarAA">&nbsp;</div>
    <div id="ImputarA">
		<div id="Imp1" onClick="CambiarImp(1);"></div>
		<div id="Imp2" onClick="CambiarImp(2);"></div>
		<div id="Imp3" onClick="CambiarImp(3);"></div>
		<div id="Imp4" onClick="CambiarImp(4);"></div>
    </div>
    
<!-- -------------------------------------------------------------------------------------------- -->
    <div id="BusquedaRemito"></div>
    <div id="BusquedaPedido"></div>
<!-- -------------------------------------------------------------------------------------------- -->

	<div id="Cantidadesx">
    <table width="100%" border="0">
      <tr>
    	<td align="center"><img src="Compras/ingr.png" /></td>
      </tr>
    </table>
    </div>
	<div id="CantidadesxDat">
    
		<input type="text" id="EDatUnidades" name="EDatUnidades" onkeypress="return ControlEDatUnidades();" onkeydown="return ControlEDatUnidadesVol();" style="position:absolute; left:650px; top:245px; width:1px;" />
		<input type="text" id="EDatUnidadesCont" name="EDatUnidadesCont" onkeypress="return ControlEDatUnidadesCont();" onkeydown="return ControlEDatUnidadesContVol();" style="position:absolute; left:650px; top:245px; width:1px;" />
        
    <table width="100%" border="0">
      <tr>
    	<td align="right">
			<button class="StyBoton" onClick="IngresoXCan(2);" ><img src="Compras/botunidadventa-up.png" border="0" id="BotXUV"/></button>
        </td>
        <td align="left">
        	<button class="StyBoton" onClick="IngresoXCan(1);" ><img src="Compras/botunidadmedida-up.png" border="0" id="BotXUM"/></button>
        </td>
      </tr>
    </table>
    </div>

<!-- -------------------------------------------------------------------------------------------- -->

	<div id="Cuerpo"><img src="Compras/con_nar_pro.png" /></div>
	<div id="CuerpoDat">
		
        <div id="botonesdebusqueda">
        <table width="400" align="center">
        <tr>
            <td>
            <button class="StyBoton" onClick="CodDebo();" onMouseOut="MM_swapImgRestore()" onMouseOver="MM_swapImage('BCDebo','','botones/cod-deb-over.png',0)">
            <img src="botones/cod-deb-up.png" border="0" id="BCDebo"/></button>
            </td>
            <td>
            <button class="StyBoton" onClick="CodBarra();" onMouseOut="MM_swapImgRestore()" onMouseOver="MM_swapImage('BCBarra','','botones/cod-bar-over.png',0)">
            <img src="botones/cod-bar-up.png" border="0" id="BCBarra"/></button>
            </td>
            <td>
            <button class="StyBoton" onClick="CodOrigen();" onMouseOut="MM_swapImgRestore()" onMouseOver="MM_swapImage('BCOrigen','','botones/cod-ori-over.png',0)">
            <img src="botones/cod-ori-up.png" border="0" id="BCOrigen"/></button>
            </td>
            <td>
            <button class="StyBoton" onClick="CodDetall();" onMouseOut="MM_swapImgRestore()" onMouseOver="MM_swapImage('BCDetall','','botones/cod-det-over.png',0)">
            <img src="botones/cod-det-up.png" border="0" id="BCDetall"/></button>
            </td>
        </tr>
        </table>
        </div>
        
        <div id="CuerpoLista">
            <table>
                <tr>
                    <td><img src="Compras/tit_cue.png" /></td>
                </tr>
            </table>
            <div id="CuerpoListaCI"></div>
        </div>
        
        
        <div id="BusquedaCodDebo"></div>

        <div id="BusquedaCodOrigen"></div>
        
        <div id="BusquedaCodDetalle"></div>
        

        <div id="CuerpoLista2">
			<img src="Compras/edi_sto.png" />

            <div id="StockTitulo"><img src="Compras/exienven.png" /></div>
            <div id="CuerpoListaStock">
                <div id="CueDatInf1"></div>
                <div id="CueDatInf2"></div>
                <div id="CueDatInf3"></div>
                <div id="CueDatInf4"></div>
                <div id="CueDatInf5"></div>
                <div id="CueDatInf6"></div>
                
                <div id="StockCriticoVta">
                    <div id="StockCriticoVta1"></div>
                    <div id="StockCriticoVta2"></div>
                    <div id="StockCriticoVta3"></div>
                    <div id="StockCriticoVta4"></div>
                    <div id="StockCriticoVta5">¡Atencion!</div>
                </div>
                <div id="StockCriticoBot">
			        <button class="StyBoton" onClick="MSDep();" onMouseOut="MM_swapImgRestore()" onMouseOver="MM_swapImage('BotDeposito','','botones/dep-over.png',0)">
        			<img src="botones/dep-up.png" border="0" id="BotDeposito"/></button>
                </div>
                <div id="StockCriticoDep">
                    <div id="StockCriticoDep1"></div>
                    <div id="StockCriticoDep2"></div>
                    <div id="StockCriticoDep3"></div>
                    <div id="StockCriticoDep4"></div>
                    <div id="StockCriticoDep5">¡Atencion!</div>
                </div>
                
            </div>
            
        </div>

        
        <div id="CuerpoProdu5"><img src="Compras/edi_cod_det.png" /></div>
        
        <div id="CuerpoProdu4"><img src="Compras/edi_cod_deb_bus.png" /></div>
                
        <div id="CuerpoProdu3"><img src="Compras/edi_cod_ori.png" /></div>

        <div id="CuerpoProdu2"><img src="Compras/edi_cod_deb.png" /></div>
        
        <div id="CuerpoProdu"><img src="Compras/edi_cod_bar.png" /></div>
		
        
        <div id="CuerpoProduTxt">
            <div id="CueDat1" class="div-redondo" style="width:168px; height:19px; left:0px; top:20px;"><!-- Codigo de barras -->
                <input type="text" class="texteca2" id="CDat1" name="CDat1" style="width:162px; top:-4px; left:2px; position:absolute;" onkeypress="return ControlCDat1();" onkeydown="return ControlCDat1Vol();" maxlength="10"/>
            </div>
            <div id="CueDat2" class="div-redondo" style="width:25px; height:17px; left:0.9px; top:22px;"><!-- Codigo de sector -->
                <input type="text" class="texteca2" id="CDat2" name="CDat2" style="width:20px; position:absolute; top:-4px; left:2px;" onkeypress="return ControlCDat2();" onkeydown="return ControlCDat2Vol();" maxlength="2"/>
            </div>
            <div id="CueDat3" class="div-redondo" style="width:75px; height:17px; left:30px; top:22px;"><!-- Codigo de articulo -->
                <input type="text" class="texteca2" id="CDat3" name="CDat3" style="width:67px; position:absolute; top:-4px; left:0.9px;" onkeypress="return ControlCDat3();" onkeydown="return ControlCDat3Vol();" maxlength="5"/>
            </div>
            <div id="CueDat4"><!-- Codigo de origen -->
                <input type="text" class="texteca2" id="CDat4" name="CDat4" style="width:122px; top:-3px; left:2px; position:absolute;" onkeypress="return ControlCDat4();" onkeydown="return ControlCDat4Vol();" maxlength="5"/>
            </div>
            <div id="CueDat4-2"><img src="Compras/ori_cue.png" /></div><!-- Imagen -->
            <div id="CueDat5" class="div-redondo" style="width:57px; height:19px; left:112px;"><!-- Cantidad del articulo -->
                <input type="text" class="texteca2" id="CDat5" name="CDat5" style="width:55px; position:absolute; top:-2px;"  onkeypress="return ControlCDat5();" onkeydown="return ControlCDat5Vol();" maxlength="4"/>
            </div>
            <div id="CueDat6" class="div-redondo" style="width:217px; height:19px; left:176px; top:22px;"><!-- Detalle de articulo -->
                <input type="text" class="texteca2" id="CDat6" name="CDat6" style="width:213px; position:absolute; top:-3px; text-transform:uppercase;" onkeypress="return ControlCDat6();" onkeydown="return ControlCDat6Vol();" onkeyup="convertirL('CDat6');" maxlength="25"/>

            </div>
            <div id="CueDat7"><!-- En ventas -->
                <input type="text" class="texteca2" id="CDat7" name="CDat7" style="width:91px;" />
            </div>
            <div id="CueDat8" class="div-redondo" style="width:95px; height:19px; left:497px; top:22px;"><!-- Costo -->
                <input type="text" class="texteca2" id="CDat8" name="CDat8" style="width:91px; position:absolute; top:-3px;" onkeypress="return ControlCDat8();" onkeydown="return ControlCDat8Vol();" maxlength="6"/>
                <input type="hidden" id="CDat8-2" name="CDat8-2" />
            </div>
            <div id="CueDat9"><!-- Descuento -->
                <input type="text" class="texteca2" id="CDat9" name="CDat9" style="width:91px;" onkeypress="return ControlCDat9();" onkeydown="return ControlCDat9Vol();" maxlength="6"/>
            </div>
            <div id="CueDat9-2"><img src="Compras/des_cue.png" /></div><!-- Imagen -->
            <div id="CueDat10" class="div-redondo" style="width:95px; height:19px; left:598px; top:22px;"><!-- Sub Total -->
                <input type="text" class="texteca2" id="CDat10" name="CDat10" style="width:91px; position:absolute; top:-3px;" onkeypress="return ControlCDat10();" onkeydown="return ControlCDat10Vol();" maxlength="1"/>
            </div>
            <div id="CueDat11"><!--Stock -->
                <input type="text" class="texteca2" id="CDat11" name="CDat11" style="width:91px;" />
            </div>
           	<input type="hidden" id="CDat11-2" name="CDat11-2" />

           	<input type="text" id="CDatCalcSub" name="CDatCalcSub" onkeypress="return ControlCDatCalcSub();" onkeydown="return ControlCDatCalcSubVol();" style="position:absolute; left:650px; top:65px; width:1px;" />
            
           	<input type="text" id="CDatContinuar" name="CDatContinuar" onkeypress="return ControlCDatContinuar();" onkeydown="return ControlCDatContinuarVol();" style="position:absolute; left:650px; top:65px; width:1px;" />
            
            <input type="text" id="CDatCosto" name="CDatCosto" onkeypress="return ControlCDatCosto();" onkeydown="return ControlCDatCostoVol();" style="position:absolute; left:650px; top:65px; width:1px;" />

            
		</div>

	</div>

<!-- -------------------------------------------------------------------------------------------- -->
           
	<div id="Pie"><img src="Compras/con_pie.png" /></div>
    
	<form id="FormPie" name="FormPie" action="RFormPie.php" method="post">
	<div id="PieDat">
        <div id="PieDat1" class="div-redondo" style="width:121px; height:19px; top:-3px; left:126px;">
            <input type="text" class="texteca" id="PDat1" name="PDat1" style="width:117px; top:-2px; position:absolute;" onkeypress="return ControlPIE(1);" onkeydown="return ControlPIEVol(1);" />
        </div>
        <div id="PieDat2" class="div-redondo" style="width:121px; height:19px;  left:126px;">
            <input type="text" class="texteca" id="PDat2" name="PDat2" style="width:117px; top:-2px; position:absolute;" onkeypress="return ControlPIE(2);" onkeydown="return ControlPIEVol(2);"/>
        </div>
        <div id="PieDat3" class="div-redondo" style="width:121px; height:19px;  left:126px;">
            <input type="text" class="texteca" id="PDat3" name="PDat3" style="width:117px; top:-2px; position:absolute;" onkeypress="return ControlPIE(3);" onkeydown="return ControlPIEVol(3);"/>
        </div>
        <div id="PieDat4" class="div-redondo" style="width:121px; height:19px;  left:126px;">
            <input type="text" class="texteca" id="PDat4" name="PDat4" style="width:117px; top:-2px; position:absolute;" onkeypress="return ControlPIE(4);" onkeydown="return ControlPIEVol(4);"/>
        </div>
        <div id="PieDat5" class="div-redondo" style="width:121px; height:19px;  left:126px;">
            <input type="text" class="texteca" id="PDat5" name="PDat5" style="width:117px; top:-2px; position:absolute;" onkeypress="return ControlPIE(5);" onkeydown="return ControlPIEVol(5);"/>
        </div>
		<div id="PieDat6" class="div-redondo" style="width:121px; height:19px;  left:126px;">
            <input type="text" class="texteca" id="PDat6" name="PDat6" style="width:117px; top:-2px; position:absolute;" onkeypress="return ControlPIE(6);" onkeydown="return ControlPIEVol(6);"/>
        </div>
        <div id="PieDat7" class="div-redondo" style="width:121px; height:19px;  left:126px;">
            <input type="text" class="texteca" id="PDat7" name="PDat7" style="width:117px; top:-2px; position:absolute;" onkeypress="return ControlPIE(7);" onkeydown="return ControlPIEVol(7);"/>
        </div>
        <!-- -------------------------------------------------------------------------------------------- -->
        <div id="PieDat8" class="div-redondo" style="width:121px; height:19px;  left:413px;">
            <input type="text" class="texteca" id="PDat8" name="PDat8" style="width:117px; top:-2px; position:absolute;" onkeypress="return ControlPIE(8);" onkeydown="return ControlPIEVol(8);"/>
        </div>
        <div id="PieDat9" class="div-redondo" style="width:121px; height:19px;  left:413px;">
            <input type="text" class="texteca" id="PDat9" name="PDat9" style="width:117px; top:-2px; position:absolute;" onkeypress="return ControlPIE(9);" onkeydown="return ControlPIEVol(9);"/>
        </div>
        <div id="PieDat10" class="div-redondo" style="width:121px; height:19px;  left:413px;">
            <input type="text" class="texteca" id="PDat10" name="PDat10" style="width:117px; top:-2px; position:absolute;" onkeypress="return ControlPIE(10);" onkeydown="return ControlPIEVol(10);"/>
        </div>
        <div id="PieDat11" class="div-redondo" style="width:121px; height:19px;  left:413px;">
            <input type="text" class="texteca" id="PDat11" name="PDat11" style="width:117px; top:-2px; position:absolute;" onkeypress="return ControlPIE(11);" onkeydown="return ControlPIEVol(11);"/>
        </div>
        <div id="PieDat12" class="div-redondo" style="width:121px; height:19px;  left:413px;">
            <input type="text" class="texteca" id="PDat12" name="PDat12" style="width:117px; top:-2px; position:absolute;" onkeypress="return ControlPIE(12);" onkeydown="return ControlPIEVol(12);"/>
            <div id="PieDat12-2" style="position:absolute; top:-4px; left:-70px;">
	            <input type="text" class="texteca2" id="PDat12-2-1" name="PDat12-2-1" style="font-size:10px; color:#FFF; background-color:transparent; text-align:center;	font-family: 'TPro'; border:0px;" />
                <input type="text" class="texteca2" id="PDat12-2" name="PDat12-2" style="font-size:10px; color:#FFF; background-color:transparent; text-align:center;	font-family: 'TPro'; border:0px;" />
            </div>
        </div>
        <div id="PieDat13" class="div-redondo" style="width:121px; height:19px;  left:413px;">
            <input type="text" class="texteca" id="PDat13" name="PDat13" style="width:117px; top:-2px; position:absolute;" onkeypress="return ControlPIE(13);" onkeydown="return ControlPIEVol(13);"/>
        </div> 
        <div id="PieDat14" class="div-redondo" style="width:121px; height:19px;  left:412px;">
            <input type="text" class="texteca" id="PDat14" name="PDat14" style="width:117px; top:-2px; position:absolute;" onkeypress="return ControlPIE(14);" onkeydown="return ControlPIEVol(14);"/>
        </div>
        
        <input type="text" id="CDatContinuarPie" name="CDatContinuarPie" onkeypress="return ControlCDatContinuarPie();" onkeydown="return ControlPIEVol(14);" style="position:absolute; left:630px; top:245px; width:1px;" />
        
        <!-- -------------------------------------------------------------------------------------------- -->
        <!-- ----------------------- DATOS PARA ENVIAR SI SE CREA FAC CON REMITO ------------------------ -->
        <input type="hidden" class="texteca" id="Tip_R" name="Tip_R" />
        <input type="hidden" class="texteca" id="Tco_R" name="Tco_R" />
        <input type="hidden" class="texteca" id="Suc_R" name="Suc_R" />
        <input type="hidden" class="texteca" id="Nco_R" name="Nco_R" />
        <input type="hidden" class="texteca" id="FacRec" name="FacRec" />
        
        <input type="hidden" id="todosremitos" name="todosremitos" value="" />
               
    </div>
	</form>

	<div id="ComprasBot">

        <div id="ComBotBusDiv">
        <button class="StyBoton" onClick="Mostrar_Busqueda();" onMouseOut="MM_swapImgRestore()" onMouseOver="MM_swapImage('ComBotBus','','botones/bus-over.png',0)">
        <img src="botones/bus-up.png" border="0" id="ComBotBus"/></button>
        </div>

        <div id="ComBotEncDiv">
        <button class="StyBoton" onClick="Mostrar_Encabezado();" onMouseOut="MM_swapImgRestore()" onMouseOver="MM_swapImage('ComBotEnc','','botones/enc-over.png',0)">
        <img src="botones/enc-up.png" border="0" id="ComBotEnc"/></button>
        </div>

        <div id="ComBotCueDiv">
        <button class="StyBoton" onClick="Mostrar_Cuerpo();" onMouseOut="MM_swapImgRestore()" onMouseOver="MM_swapImage('ComBotCue','','botones/cue-over.png',0)">
        <img src="botones/cue-up.png" border="0" id="ComBotCue"/></button>
        </div>    

        <div id="ComBotPieDiv">
        <button class="StyBoton" onClick="Mostrar_Pie();" onMouseOut="MM_swapImgRestore()" onMouseOver="MM_swapImage('ComBotPie','','botones/pie-over.png',0)">
        <img src="botones/pie-up.png" border="0" id="ComBotPie"/></button>
        </div>    

        <div id="ComBotModDiv" align="right">
        <button class="StyBoton" onMouseOut="MM_swapImgRestore()" onMouseOver="MM_swapImage('ComBotMod','','botones/mod-over.png',0)">
        <img src="botones/mod-up.png" border="0" id="ComBotMod"/></button> 
        </div>

        <div id="ComBotEliDiv">
        <button class="StyBoton" onMouseOut="MM_swapImgRestore()" onMouseOver="MM_swapImage('ComBotEli','','botones/eli-over.png',0)">
        <img src="botones/eli-up.png" border="0" id="ComBotEli"/></button>
        </div>
        
    </div>
    
</div>


<!-- ------- ------- DIV ComprasDatos ------- ------- -->

	<div id="LisFacComFon">
    	<input type="text" id="EscapeComprobantes" name="EscapeComprobantes" onkeypress="return ControlEscapeComprobantes();" onkeydown="return ControlEscapeComprobantesVol();" style="position:absolute; left:38px; top:350px; width:1px;" />
    	<img src="Compras/con_com.png" />
    </div>
   	<div id="LisFacComFon2"><img src="Compras/compra.png" /></div>

    <div id="TituloLis">Consulta de comprbates de compra</div>
    <div id="TituloNom">
        <table width="100%" border="0">
            <tr>
                <td><div id="LisNom"></div></td>
                <td><div id="LisDom"></div></td>
            </tr>
        </table>    
    </div>
    <div id="TituloLisFac">
        <table width="100%" border="0">
            <tr>
                <td>TIP</td>
                <td>TCO</td>
                <td>SUC</td>
                <td>NCO</td>
            </tr>
        </table>
    </div>

       	<div id="LisFacComLis">
    	</div>
        
		<div id="LisFacComDat">
            <div id="LisFacComDatEnc">
            <table width="473" height="62">
                <tr>
	                <td>
                    	<div id="tit1"></div>
	                    <div id="estado" style="position:absolute; top:6px; left:143px; width:320px; color:#000;" ></div>
                    </td>
                </tr>
                <tr>
    	            <td><div id="tit2"></div></td>
                </tr>
            </table>
            </div>
            <div id="LisFacComDatMed"></div>
            <div id="LisFacComDatTot">
            <table width="473">
                <tr>
	                <td width="94" height="49"><div align="center" id="det1"></div></td>
                    <td width="94" height="49"><div align="center" id="det2"></div></td>
                    <td width="94" height="49"><div align="center" id="det3"></div></td>
                    <td width="94" height="49"><div align="center" id="det4"></div></td>
                    <td width="94" height="49"><div align="center" id="det5"></div></td>
                </tr>
                <tr>
    	            <td width="94" height="17"><div align="center" id="det6"></div></td>
                    <td width="94" height="17"><div align="center" id="det7"></div></td>
                    <td width="94" height="17"><div align="center" id="det8"></div></td>
                    <td width="94" height="17"><div align="center" id="det9"></div></td>
                    <td width="94" height="17"><div align="center" id="det10"></div></td>
                </tr>
                <tr>
    	            <td width="94">&nbsp;</td>
                    <td width="94">&nbsp;</td>
                    <td width="94">&nbsp;</td>
                    <td width="94">&nbsp;</td>
                    <td width="94"><div align="center" id="det11"></div></td>
                </tr>
            </table>
            </div>
		</div>
        
	<div id="BotonesLis">

    	<div id="BotonesLisSal">
        	<button class="StyBoton" onClick="SalLisCom();" onMouseOut="MM_swapImgRestore()" onMouseOver="MM_swapImage('BotLisConSal','','botones/sal-over.png',0)">
            <img src="botones/sal-up.png" name="Salir" title="Salir" border="0" id="BotLisConSal"/></button>
        </div>

    	<div id="BotonesLisTar">
        <table width="255" border="0">
        <tr>
        <td width="85">
        <div id="BotonesLisTarMod" style="display:none;">
	        <button class="StyBoton" onClick="ModLisCom();" onMouseOut="MM_swapImgRestore()" onMouseOver="MM_swapImage('BotLisConMod','','botones/mod-over.png',0)">
    	    <img src="botones/mod-up.png" name="Modificar" title="Modificar" border="0" id="BotLisConMod"/></button>
        </div>    
        </td>
        <td width="85">
        <div id="BotonesLisTarEli" style="display:none;">
	        <button class="StyBoton" onClick="EliLisCom();" onMouseOut="MM_swapImgRestore()" onMouseOver="MM_swapImage('BotLisConEli','','botones/eli-over.png',0)">
    	    <img src="botones/eli-up.png" name="Eliminar" title="Eliminar" border="0" id="BotLisConEli"/></button>
        </div>
        </td>
        <td width="85">
        <div id="BotonesLisTarImp" style="display:none;">
 	        <button class="StyBoton" onClick="ImpLisCom();" onMouseOut="MM_swapImgRestore()" onMouseOver="MM_swapImage('BotLisConImp','','botones/imp-over.png',0)">
	   	    <img src="botones/imp-up.png" name="Imprimir" title="Imprimir" border="0" id="BotLisConImp"/></button>
        </div>    
        </td>
        </tr>
        </table>
        </div>
    
    </div>

</body>
</html>