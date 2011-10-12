<?
require("config/cnx.php");

try {////////////////////////////////////////////////////////////////////////////////////////////////// COMIENZO TRY //

$_SESSION['ParFacSec'] = 1;

?>

<script type="text/javascript" language="javascript" src="facturador/fac.js"></script>
<script type="text/JavaScript" language="javascript" src="js/quicksearch.js"></script>

<style>

.DatosFac{
	position:absolute; 
	font-family: Arial; 
	font-weight:bold;
	font-size:11px;
	color:#FFF;
	z-index:0;
}

.MosFac{ 
	background-color:transparent; 
	font-family: "TPro";
	position:absolute; 
	font-size:12px; 
	border:0px;
}

#TiquetComple{ 
	display:block;
}

#Tiquet{ 
	background-image:url(ticket/fonticket.png); 
	background-repeat:no-repeat;
	position:absolute;
	display:none;
	width:316px;
	height:295px;
	left:2px;
	top:90px;
	z-index:1;
}

#TiquetItemDet{ 
	background-image:url(ticket/detalle.png); 
	background-repeat:no-repeat;
	position:absolute;
	font-family: Arial; 
	font-size:10px; 
	color:#FFF;
	width:246px;
	height:14px;
	left:29px;
	top:0px;
}

#TiquetItem{ 
	position:absolute;
	overflow:hidden;
	width:312px;
	height:255px;
	left:3px;
	top:12px;
}

#TiquetDesglose{ 
	position:absolute; 
	cursor:pointer;
	height:20px;
	width:72px;
	left:6px;
	top:269px;
}

#TiquetDesgloseVol{ 
	background-image:url(ticket/vol-des.png); 
	background-repeat:no-repeat; 
	position:absolute; 
	display:none; 
	cursor:pointer;
	height:21px;
	width:71px;
	left:7px;
	top:359px;
}

#Desglose{ 
	display:none; 
	position:absolute; 
	left:74px;
	top:105px;
}

#DesgloseFon{
	display:none;  
	position:absolute; 
	left:74px;
	top:105px;
}

.vuelto{
	background-color:transparent; 
	text-align:center; 
	font-family: "TPro";
	font-size:16px; 
	width:135px; 
	height:18px; 
	outline-style:none; 
	border-style:none;
}

#Vuelto1{
	display:none; 
	position:absolute; 
	left:2px;
	top:242px;
}

#Vuelto2{
	display:none; 
	position:absolute; 
	left:2px;
	top:242px;
}

#MPromo{
	position:absolute;
	display:none;
	left:322px; 
	top:90px; 
	z-index:4; 
}

#EntraOpeF{ 
	position:absolute;
	display:none;
	left:322px; 
	top:90px; 
	z-index:4; 
}

#EntraOpe{ 
	position:absolute;
	display:none;
	left:322px; 
	top:90px; 
	z-index:4; 
}

.ParaDivS{
	position:absolute; 
	font-family: "TPro";
	font-size:12px;
	color:#FFFFFF;
}

.BotonOpe{ 
	background-color:transparent;
	width:73px; 
	height:13px; 
	font-family: "TPro";
	font-size:12px;
	color:#FFFFFF;
	border:0px;
}

.EstiloForm{
	background-color:transparent; 
	text-align:center;
	font-family: "TPro";
	font-size:16px;
	color:#FFFFFF;
	border:0px;
	height:16px;
	width:95px;
}

#MostrarComboDiv{ 
	background-image:url(otros/fon-der.png);
	background-repeat:no-repeat;
	display:none; 
	position:absolute; 
	width:475px; 
	height:293px; 
	z-index:1;	
	left:322px; 
	top:90px; 
}

#ReEmitirC{
	position:absolute;
	display:none;
	left:325px; 
	top:97px; 
	z-index:1; 
}

#MedioP{
	position:absolute;
	display:none;
	left:325px; 
	top:97px; 
	z-index:1; 
}

#MedioPBlock{ 
	position:absolute;
	display:none; 
	width:467px; 
	height:230px; 
	left:325px; 
	top:97px; 
	z-index:3; 
}

#Cotizacion{
	display:none;
	position:absolute;
	left:325px;
	top:97px;
	z-index:1;
}

#MonedasFon{
	background-image:url(facturador/mon.png);
	display:none; 
	position:absolute;
	width:93px; 
	height:86px;
	left:705px;
	top:2px;
	z-index:1;
}

#Monedas{
	display:none; 
	position:absolute;
	font-weight:bold;
	font-size:11px; 
	width:93px; 
	height:86px;
	left:705px;
	top:2px;
	z-index:1;
}


#ListaFPA{
	position:absolute; 
	left:252px;
	top:242px; 
	z-index:0;
}

#MultipleFormaPago{
	position:absolute; 
	display:none; 
	left:260px; 
	top:29px; 
	z-index:2;
}

#TotalesApagar{
	position:absolute; 
	left:287px;
	top:28px;  
	width:225px; 
	height:141px;
}

.paramultfpa{ 
	font-size:16px;
	position:absolute;
	text-align:center;
	width:120px;
	color:#FFF; 
	top:2px;
	left:0px;
}

.vuelto22{
	background-color:transparent; 
	text-align:center; 
	font-family: "TPro";
	font-size:16px; 
	width:120px; 
	height:16px;
	border:0px; 
}

#bloquerfactur{
	position:absolute; 
	display:none;
	top:0px; 
	left:0px; 
	width:800px; 
	height:385px; 
	z-index:3;
}

</style>

<link href="Estilo.css" rel="stylesheet" type="text/css" />

<div id="BotonesFac">
<?php
for ($i = 1 ; $i <= 9 ; $i ++) {

switch($i){
   
	case 1:
	  $r = "pro";
	  $t = "Productos";
	  break;
	case 2:
	  $r = "cli";
	  $t = "Clientes";
	  break;
	case 3:
	  $r = "med-pag";
	  $t = "Medio de Pago";
	  break;
	case 4:
	  $r = "t-rap";
	  $t = "Teclas Rapidas";
	  break;
	case 5:
	  $r = "com";
	  $t = "Compras";
	  break;
	case 6:
	  $r = "ent-ope";
	  $t = "Entrada Operario";
	  break;
	case 7:
	  $r = "re-emi-com";
	  $t = "Re Emitir Comprobante";
	  break;
	case 8:
	  $r = "cot";
	  $t = "Cotizaci&oacute;n";
	  break;
	case 9:
	  $r = "rest";
	  $t = "Restaurant_boton";
	  break;      
}  

if($i != 5){
echo "<div id=\"BotonFac".$i."\" class=\"PosDiv\">";
echo "<button class=\"StyBoton\" onclick=\"AccBotFac(".$i.")\" onmouseout=\"MM_swapImgRestore()\" onmouseover=\"MM_swapImage('BotFac".$i."','','facturador/barra_sup/".$r."-over.png',0)\">";
echo "<img src=\"facturador/barra_sup/".$r."-up.png\" name=\"".$t."\" title=\"".$t."\" border=\"0\" id=\"BotFac".$i."\"/></button>";
echo "</div>";
}

}

?>

</div>

<?


	$_SESSION['ParSQL'] = "
	SELECT C.NplVen AS PLA, D.FAP AS FAP, A.MTN, A.DES, A.INI, A.FIN FROM ATURNOSH AS A 
	INNER JOIN APARPOS AS B ON B.ID = '".$_SESSION['ParPOS']."'
	INNER JOIN VENDEDORES AS C ON C.CodVen = B.OPE
	INNER JOIN ATURNOSO AS D ON D.PLA = C.NplVen
	WHERE A.MTN = D.MTN
	";
	$registros = mssql_query($_SESSION['ParSQL']) or die("Error SQL");
	rollback($registros);		
	while ($reg=mssql_fetch_array($registros)){
	
		$PLA = $reg['PLA'];
		$FAP = $reg['FAP'];
		$MTN = $reg['MTN'];
		$DES = $reg['DES'];
		$INI = $reg['INI'];
		$FIN = $reg['FIN'];
		
	}
	mssql_free_result($registros);
	

$_SESSION['ParSQL'] = "SELECT MAX(NCO) + 1 AS NCO FROM AMAEFACT WHERE TIP = 'B' AND TCO = 'TI' AND SUC = ".$_SESSION['ParPV']."";
$registros = mssql_query($_SESSION['ParSQL']) or die("Error SQL");
rollback($registros);
while ($reg=mssql_fetch_array($registros)){
	if($reg['NCO'] == NULL){
		$NCO = 1;
	}else{
		$NCO = $reg['NCO'];
	}
}
mssql_free_result($registros);

$fecha = date("d-m-Y");
$hora = date("H:i:s");

$NCO = format($NCO,8,'0',STR_PAD_LEFT);
$PLA = format($PLA,5,'0',STR_PAD_LEFT);

$APARSIS = mssql_query("SELECT MINTSH, MINCSH FROM APARSIS");
rollback($APARSIS);
while ($APARSIS_REG = mssql_fetch_array($APARSIS)){

	$MINTSH = $APARSIS_REG['MINTSH'];
	$MINCSH = $APARSIS_REG['MINCSH'];

}
mssql_free_result($APARSIS);

?>


	<input type="hidden" name="can_item" id="can_item" value="0" />
    <input type="hidden" name="PLA" id="PLA" value="<? echo $PLA; ?>" />
    <input type="hidden" name="TIP" id="TIP" value="B" />
    <input type="hidden" name="TCO" id="TCO" value="TI" />
    <input type="hidden" name="SUC" id="SUC" value="<? echo $_SESSION['ParPV']; ?>" />
    <input type="hidden" name="NCO" id="NCO" value="<? echo $NCO; ?>" />
    <input type="hidden" name="TUR" id="TUR" value="<? echo $MTN; ?>" />
    <input type="hidden" name="CLI" id="CLI" value="-1" />
    
	<input type="hidden" name="TARJ" id="TARJ" value="0" />
   	<input type="hidden" name="mod_item" id="mod_item" value="0" />
    <input type="hidden" name="EsPromo" id="EsPromo" value="0" />
    <input type="hidden" name="modcli" id="modcli" value="0" />

	<input type="hidden" name="PAR_MINTSH_FAC" id="PAR_MINTSH_FAC" value="<? echo $MINTSH; ?>" />
	<input type="hidden" name="PAR_MINCSH_FAC" id="PAR_MINCSH_FAC" value="<? echo $MINCSH; ?>" />


<div id="TituloFacAu" class="TituloFacCa">Facturador</div>

<div id="BarFac" style="z-index:0; position:absolute;"><img src="facturador/dat-tic.png" /></div>

<div id="BarFacD" class="DatosFac">
    
    <div style="position:absolute; width:70px; left:50px; top:6px;"><? echo $NCO; ?></div>
    <div style="position:absolute; width:70px; left:50px; top:20px;"><? echo $PLA; ?></div>
    <div style="position:absolute; width:80px; left:50px; top:36px;"><? echo $fecha; ?></div>
    <!-- <div style="position:absolute; width:70px; left:50px; top:51px;"><? echo $hora; ?></div> -->
    <div id="reloj" style="position:absolute; width:70px; left:50px; top:51px;"></div>
    <div style="position:absolute; width:180px; left:50px; top:67px;"><? echo $_SESSION['idsusua']; ?>, &nbsp;<? echo $_SESSION['idsusun']; ?></div>
    
</div>

<div id="MonedasFon"></div>
<div id="Monedas"></div>

<div id="DesgloseFon"><img src="facturador/desglose.png" /></div>
<div id="Desglose">
	
    <div class="MosFac" id="cliente_fac"     style="left:50px;  top:14px; width:210px;">&nbsp;</div>
    <div class="MosFac" id="cliente_fac_cui" style="left:307px; top:14px; width:100px;">&nbsp;</div>
    <div class="MosFac" id="cliente_fac_iva" style="left:437px; top:14px; width:200px;">&nbsp;</div>   
    <div class="MosFac" id="condicion_fac"   style="left:18px;  top:40px; width:237px;">&nbsp;</div>
    <div class="MosFac" id="neto_fac"        style="text-align:right; left:20px;  top:80px; width:135px;">&nbsp;</div>
    <div class="MosFac" id="netoexnto_fac"   style="text-align:right; left:178px; top:80px; width:135px;">&nbsp;</div>
    <div class="MosFac" id="iva_fac"         style="text-align:right; left:338px; top:80px; width:135px;">&nbsp;</div>
    <div class="MosFac" id="ivasserv_fac"    style="text-align:right; left:495px; top:80px; width:135px;">&nbsp;</div>
    <div class="MosFac" id="persep_fac"      style="text-align:right; left:20px;  top:105px; width:135px;">&nbsp;</div>
    <div class="MosFac" id="inpuestos1_fac"  style="text-align:right; left:178px; top:105px; width:135px;">&nbsp;</div>
    <div class="MosFac" id="inpuestos2_fac"  style="text-align:right; left:338px; top:105px; width:135px;">&nbsp;</div>
    <div class="MosFac" id="descuentos_fac"  style="text-align:right; left:495px; top:105px; width:135px;">&nbsp;</div>
    
</div>

<div id="bloquerfactur"></div>

<div id="Vuelto1"><img src="facturador/lista.png" /></div>
<div id="Vuelto2">

    <div id="TotalesApagar">
    <table border="0" cellpadding="2" cellspacing="2">
        <tr>
            <td><div align="right"><img src="facturador/pago/total.png" /></div></td>
            <td>
            <div style="position:relative;">
                <div style="position:relative;"><img src="facturador/pago/nar.png" /></div>
                <div style="position:absolute; margin-top:2px; top:0px; left:0px;">
                    <input class="vuelto" readonly="readonly" type="text" name="TOTO" id="TOTO" value="0" />
                </div>
            </div>    
            </td>
        </tr>
        <tr>
            <td><div align="right"><img src="facturador/pago/pago.png" /></div></td>
            <td>
            <div style="position:relative;">
                <div style="position:relative;"><img src="facturador/pago/bla.png" /></div>
                <div style="position:absolute; top:2px; left:0px;">
                    <input class="vuelto" type="text" name="PAG" id="PAG" value=""  maxlength="12" onkeypress="return Enviar_XEnterPag();" onkeydown="return ControlPagVol();" />
                </div>
            </div>
            </td>
        </tr>
        <tr>
            <td><div align="right"><img src="facturador/pago/vuelto.png" /></div></td>
            <td>
            <div style="position:relative;">
                <div style="position:relative;"><img src="facturador/pago/nar.png" /></div>
                <div style="position:absolute; top:2px; left:0px;">
                    <input class="vuelto" readonly="readonly" type="text" name="VUL" id="VUL" value="" />
                </div>
            </div>    
            </td>
        </tr>
    </table>
    </div>
   
    <div id="MultipleFormaPago">
    
	<form name="formfpafpa" id="formfpafpa" method="post" action="MultiplesFPA.php">
    
    <input type="hidden" name="dID_BONO" id="dID_BONO" value="0" />
    
    <table border="0" cellpadding="2" cellspacing="2">
        <tr>
            <td><div align="right"><img src="facturador/pago/pagar.png" /></div></td>
            <td colspan="3">
                <div style="position:relative;">
                    <div style="position:relative;"><img src="facturador/pago/bla.png" /></div>
                    <div style="position:absolute; top:2px; left:0px;">
                        <input class="vuelto" type="text" size="17" name="APagar" id="APagar" value="0" onkeypress="return Enviar_XEnterApagar();"  />
                    </div>
                </div>
            </td>
        </tr>
        <tr>
            <td>
                <div style="position:relative; cursor:pointer;">
                    <div style="position:relative;"><img src="facturador/pago/bot.png" width="120" /></div>
                    <div id="fpa_tarjetas" class="paramultfpa" onclick="nuevatarjeta();">TARJETAS</div>
                </div>
            </td>
            <td>
                 <div style="position:relative; cursor:pointer;">
                    <div style="position:relative;"><img src="facturador/pago/bot.png" width="120" /></div>
                    <div id="fpa_cheques" class="paramultfpa" onclick="nuevocheque();">CHEQUES</div>
                </div>
            </td>            
            <td>
                <div style="position:relative; cursor:pointer;">
                    <div style="position:relative;"><img src="facturador/pago/bot.png" width="120" /></div>
                    <div id="fpa_efectivo" class="paramultfpa" onclick="IngEfectivo();">EFECTIVO</div>
                </div>
            </td>
            <td>
                <div style="position:relative; cursor:pointer;">
                    <div style="position:relative;"><img src="facturador/pago/bot.png" width="120" /></div>
                    <div id="fpa_bonos" class="paramultfpa" onclick="IngBonos();">BONOS</div>
                </div>
            </td>            
        </tr>
        
        <tr>
            <td>
                <div style="position:relative;">
                    <div style="position:relative;"><img src="facturador/pago/bla.png" width="120" /></div>
                    <div style="position:absolute; top:0px; left:0px;">
                        <input class="vuelto22" readonly="readonly" type="text" size="9" name="CANTARJETAS" id="CANTARJETAS" value="0" />
                    </div>
                </div>
            </td>
            <td>
                <div style="position:relative;">
                    <div style="position:relative;"><img src="facturador/pago/bla.png" width="120" /></div>
                    <div style="position:absolute; top:0px; left:0px;">
                        <input class="vuelto22" readonly="readonly" type="text" size="9" name="CANCHEQUES" id="CANCHEQUES" value="0" />
                    </div>
                </div>
            </td>            
            <td>
                <div style="position:relative;">
                    <div style="position:relative;"><img src="facturador/pago/bla.png" width="120" /></div>
                    <div style="position:absolute; top:0px; left:0px;">
                        <input class="vuelto22" readonly="readonly" type="text" size="9" name="CANEFECTIVO" id="CANEFECTIVO" value="0" />
                    </div>
                </div>
            </td>
            <td>
                <div style="position:relative;">
                    <div style="position:relative;"><img src="facturador/pago/bla.png" width="120" /></div>
                    <div style="position:absolute; top:0px; left:0px;">
                        <input class="vuelto22" readonly="readonly" type="text" size="9" name="CANBONO" id="CANBONO" value="0" />
                    </div>
                </div>
            </td>
        </tr>
    </table>    
    </form>
    </div>
  
</div>


<div id="NuevaFormaPago" class="PosDiv" style="left:44px; top:112px; z-index:3;"></div>


<div id="ListaFPA">&nbsp;</div>


<div id="TiquetDesgloseVol" onclick="DesgloseVol();"></div>
<div id="TiquetComple">


    <div id="Tiquet">
        
        <div id="TiquetItemDet">&nbsp;&nbsp;&nbsp;Detalle</div>
        <div id="TiquetItem"></div>
      	<div id="TiquetDesglose" onclick="Desglose();"></div>

    </div>
    

    <div id="mostrar"></div>

    
    <div id="MostrarComboDiv"></div>
    
  
    <div id="MiProd"><img src="producto/busq-prod.png" /></div>
    
    
	<div id="FacTotal"><input type="text" name="total" id="total" value="0" readonly="yes" /></div>
    
    
    <div id="micapa1"></div>
    
    
    <div id="Loading">
        <table width="475" height="293" border="0" cellpadding="0" cellspacing="0">
            <tr>
           		<td><img src="otros/loading.gif" /></td>
            </tr>
        </table>
    </div>
    
    
    <div id="Promo"><img src="producto/busq-prod.png" /></div>
    
    
    <div id="MPromo">
        <table width="475" style="color:#FFF;">
        <tr>
            <td><div align="left"><img src="producto/Promo.png" /></div></td> 
        </tr>
        <tr>
            <td>
			<div style="width:475px; height:28px;" align="center">
    	        <div style="position:absolute; left:67px;"><img src="producto/Can_ASel.png" /></div>
	            <div style="position:absolute; left:298px;">
	                <input type="text" name="cant_per" id="cant_per" value="0" class="EstiloForm" readonly="readonly" disabled="disabled" />
                </div>
     		</div>
            </td> 
        </tr>
        <tr>
            <td>
            <div style="width:475px; height:28px;" align="center">
    	        <div style="position:absolute; left:67px;"><img src="producto/Can_Sel.png" /></div>
	            <div style="position:absolute; left:298px;">
                	<input type="text" name="cant_sel" id="cant_sel" value="0" class="EstiloForm" readonly="readonly" disabled="disabled" />
                </div>
     		</div>
            </td> 
        </tr>
        <tr>
            <td><div id="ItemsSel"></div></td>
        </tr>
        </table>        
      <input type="hidden" name="datospro" id="datospro" value="" />   
    </div>
        

    <div id="ClientesFac" style="display:none;">
    
        <div id="BotonesParaO" style="direction:none;">
        <table cellpadding="0" cellspacing="1" align="center">
        <tr> 
            <td>
            <button class="StyBoton" onClick="return Orden_Cli(1);" onMouseOut="MM_swapImgRestore()" onMouseOver="MM_swapImage('BotOrdenA','','botones/alf-over.png',0)"><img src="botones/alf-up.png" border="0" id="BotOrdenA"/></button>
            </td>
            <td>
            <button class="StyBoton" onClick="return Orden_Cli(2);" onMouseOut="MM_swapImgRestore()" onMouseOver="MM_swapImage('BotOrdenC','','botones/cod-over.png',0)"><img src="botones/cod-up.png" border="0" id="BotOrdenC"/></button>
            </td>
            <td>
            <button class="StyBoton" onClick="return Orden_Cli(3);" onMouseOut="MM_swapImgRestore()" onMouseOver="MM_swapImage('BotOrdenT','','botones/cta-over.png',0)"><img src="botones/cta-up.png" border="0" id="BotOrdenT"/></button>
            </td>
            <td>
            <button class="StyBoton" onClick="return ClienteEv();" onMouseOut="MM_swapImgRestore()" onMouseOver="MM_swapImage('BotOrdenE','','botones/eve-over.png',0)"><img src="botones/eve-up.png" border="0" id="BotOrdenE"/></button>
            </td>
        </tr>
        </table>
        </div>
        
    </div>


    <div id="EntraOpeF"><img src="facturador/EntOpe.png" /></div>
    <div id="EntraOpe"></div>


    <div id="ReEmitirC"></div>


	<div id="MedioP"></div>
    
    
    <div id="Cotizacion"></div>
    

</div>

<script>
	document.getElementById("ComenzarTic").value = 1;
	$('#LetTex').focus();
</script>
<?

}catch(Exception $e){////////////////////////////////////////////////////////////////////////////////////////////////// FIN DE TRY //
	
	?>
	<script>
		jAlert('ERORR Reintente la operacion solicitada.', 'Debo Retail - Global Business Solution');
	</script>
	<?
exit;

}

?>

        
        <input type="hidden" id="numero_comprobante" value="0" />
        <input type="hidden" id="numero_mesa" value="0"/>
        <input type="hidden" id="mesa_cierre" value="0"/>