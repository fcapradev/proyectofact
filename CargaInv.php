<?
require("config/cnx.php");
try {////////////////////////////////////////////////////////////////////////////////////////////////// COMIENZO TRY //
mssql_query("begin transaction",$conexion) or die("Error SQL begin trans");

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Carga de Inventario</title>
<script type="text/javascript" language="javascript" src="CargaInvScript.js"></script>
<style>
.fon-car{
	font-family: "TPro";
	font-size:12px;
	position:absolute;
	color:#000;
	height:16px;
}
.fon-car1{
	font-family: "TPro";
	font-size:10px;
	position:absolute;
	color:#000;
	height:16px;
}
.fon-car2{
	font-family: "TPro";
	font-size:11px;
	position:absolute;
	color:#000;
	height:16px;
}
#botones_car{
	position:absolute;
	width:726px;
	height:58px;
	left:6px;
	top:309px;
	z-index:1;
}
#botones_car_ver{
	position:absolute;
	width:85px;
	height:272px;
	left:600px;
	top:40px;
	z-index:2;
}

#inv{
	width:63px; 
	height:13px;
	position:absolute;
	top:-1px;
	left:0px;
	font-family: "TPro";
	border:0px;
	text-align:center;
}

#espera{
	position:absolute;
	z-index:19;
	display:none;
	top:-6px;
	left:-65px;
	width:838px;
	height:598px;
	background-color: #000;
  	filter:alpha(opacity=60);
  	-moz-opacity: 0.6;
  	opacity: 0.6;
}

</style>

<script>
	$("#invent").css("border-color", "#F90");
</script>
</head>
<body>

<div id="espera">
	<img src="otros/loading.gif" style="position:absolute; top:215px; left:390px; z-index:20;" />
</div>
<div id="fondoimg">
	<img src="InventarioCarga/detalle_inv.png" style="position:absolute; left:38px;" />
    <img src="InventarioCarga/fondo negro.png" style="position:absolute; z-index:-1;left:38px;" />
</div>
<?
$OPE = $_SESSION['idsusua'];
?>
<div id="datos_planilla">
	<div id="ope" class="fon-car" style="position:absolute; top:52px; left:50px; width:70px;" align="center"><? echo $OPE; ?></div>
	
    <form method="post" action="CarInvLis.php" name="inventario" id="inventario">    
	
    <div id="invent" class="div-redondo" style="position:absolute; top:49px; left:123px; width:64px; height:13px;" align="center">
    	<input name="inv" type="text" id="inv" readonly="readonly" autocomplete="off" style=" font-size:12px; background-color:transparent;"/>
	</div>
	<input type="hidden" name="ordsel" id="ordsel" value="0" />
	
    </form>
</div>

<!-- LISTA DE ARTICULOS CARGADOS -->
<div id="fondolista" style="position:absolute; width:640px; height:205px; top:90px; left:48px; z-index:1; display:none;"></div>
<div id="descpidelista" style="position:absolute; top:174px; left:55px; display:none; z-index:2;"></div>	
<div id="descpidetitulo" style="position:absolute; top:79px; left:48px; display:none; z-index:4;">
	<img src="InventarioCarga/detalle cargado.png" />
</div>	

<!-- LISTA DE INVENTARIOS TRAIDOS POR COLECTOR -->
<div id="fondocolector" style="position:absolute; width:800px; height:600px; z-index:1; display:none;"></div>
<div id="fondopidecol" style="position:absolute; top:100px; left:158px; z-index:2; display:none;">
    <img src="otros/fon-der.png" />
</div>
<div id="descpideinv" style="position:absolute; top:100px; left:158px; display:none; z-index:2;"></div>
<div id="cruz" style="position:absolute; top:98px; left:591px; display:none; z-index:2;">
	<button class="StyBoton" onclick="salir_trae_invcd();" onmouseout="MM_swapImgRestore()" onmouseover="MM_swapImage('BotSal','','otros/cru-over.png',0)"><img src="otros/cru-up.png" name="Salir" title="Salir" border="0" id="BotSal"/></button>
</div>

<div id="botones_car">
<table width="726">
	<tr>
    	<td width="20">
        <div id="orden" class="fon-tom" style="position:absolute; top:10px; left:50px; display:none;" align="center">
			<img onClick="cam_ord(0);" src="producto/SinTil.png" width="24" name="Alfabetico" title="Alfabetico" border="0" id="ordalf"  style="position:absolute; top:9px; left:-10px; cursor:pointer">
			<div id="BotAlfSel" style="display:none;">
				<img src="producto/ConTil.png" width="24" border="0" style=" position:absolute; top:9px; left:-10px; cursor:pointer">
			</div>
			<img onClick="cam_ord(1);" src="producto/SinTil.png" width="24" name="Numerico" title="Numerico" border="0" id="ordnum" style=" position:absolute; top:27px; left:-10px; cursor:pointer" >
			<div id="BotNumSel" style="display:none;">
				<img src="producto/ConTil.png" width="24" border="0" style=" position:absolute; top:27px; left:-10px; cursor:pointer">
			</div>
		</div>
        </td>
		<td width="20">
        <div id="impresion" class="fon-tom" style="position:absolute; top:10px; left:145px; display:none;" align="center">
			<img onClick="cam_imp(0);" src="producto/SinTil.png" width="24" title="Resumida" name="impres" id="impres" border="0" style="position:absolute; top:9px; left:-9px; cursor:pointer">
			<div id="BotResSel" style="display:block;">
				<img src="producto/ConTil.png" width="24" border="0" style=" position:absolute; top:9px; left:-9px; cursor:pointer">
			</div>
			<img onClick="cam_imp(1);" src="producto/SinTil.png" width="24" title="Detallada" name="impdet" id="impdet" border="0" style=" position:absolute; top:27px; left:-9px; cursor:pointer" >
			<div id="BotDetSel" style="display:none;">
				<img src="producto/ConTil.png" width="24" border="0" style=" position:absolute; top:27px; left:-9px; cursor:pointer">
			</div>
		</div>
        </td>
		<td width="20">
        <div id="valor" class="fon-tom" style="position:absolute; top:10px; left:242px; display:none;" align="center">
			<img onClick="cam_val(0);" src="producto/SinTil.png" width="24" title="Precio de Costo" name="valcos" id="valcos" border="0" style="position:absolute; top:9px; left:-9px; cursor:pointer">
			<div id="BotCosSel" style="display:none;">
				<img src="producto/ConTil.png" width="24" border="0" style=" position:absolute; top:9px; left:-9px; cursor:pointer">
			</div>
			<img onClick="cam_val(1);" src="producto/SinTil.png" width="24" title="Precio de Venta" name="valven" id="valven" border="0" style=" position:absolute; top:27px; left:-9px; cursor:pointer" >
						
			<div id="BotVenSel" style="display:none;">
				<img src="producto/ConTil.png" width="24" border="0" style=" position:absolute; top:27px; left:-9px; cursor:pointer">
			</div>
		</div>
        </td>
		<td width="85">
		<div id="importar_car" style="position:absolute;  top:10px; left:375px; display:block;">
			<button onClick="buscainv();" class="StyBoton" onMouseOut="MM_swapImgRestore()" onMouseOver="MM_swapImage('ImportarCar','','botones/imp-palm-over.png',0)"><img src="botones/imp-palm-up.png" name="Importar" title="Importa de Palm" border="0" id="ImportarCar"></button>
		</div>		
		</td>
        <td width="85">
		<div id="cancelar" style="position:absolute;  top:10px; left:375px; display:none;">
			<button onClick="cancela();" class="StyBoton" onMouseOut="MM_swapImgRestore()" onMouseOver="MM_swapImage('ImportarCan','','botones/can-over.png',0)"><img src="botones/can-up.png" name="Cancelar" title="Cancelar Arqueo" border="0" id="ImportarCan"></button>
		</div>		
		</td>
		<td width="85">
		<div id="notomado_car" style="position:absolute;  top:10px; left:475px; display:none;">
			<button onClick="notomado();" class="StyBoton" onMouseOut="MM_swapImgRestore()" onMouseOver="MM_swapImage('NoTomCar','','botones/inv-car-nt-over.png',0)"><img src="botones/inv-car-nt-up.png" name="No Tomado" title="No Tomado" border="0" id="NoTomCar"></button>
		</div>				
		</td>
		<td width="85">
		<div id="grabar_car" style="position:absolute;  top:10px; left:575px; display:none">
			<button onClick="grabar_car();" class="StyBoton" onMouseOut="MM_swapImgRestore()" onMouseOver="MM_swapImage('GrabarCar','','botones/gra-over.png',0)"><img src="botones/gra-up.png" name="Grabar" title="Grabar" border="0" id="GrabarCar"></button>
		</div>
		</td>
	</tr>
</table>
</div>

</div>
<form action="" method="post" name="varios" id="varios">
    <input type="hidden" name="imps" id="imps" />
    <input type="hidden" name="vals" id="vals" />
    <input type="hidden" name="pdfs" id="pdfs" />
</form>
</body>
</html>

<?
mssql_query("commit transaction") or die("Error SQL commit");

}catch(Exception $e){////////////////////////////////////////////////////////////////////////////////////////////////// FIN DE TRY //
	?>
	<script>
		jAlert('ERROR Reintente la operacion solicitada.', 'Debo Retail - Global Business Solution');
	</script>
	<?

exit;
}
?>