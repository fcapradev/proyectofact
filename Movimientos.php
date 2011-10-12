<?
require("config/cnx.php");

try {////////////////////////////////////////////////////////////////////////////////////////////////// COMIENZO TRY //

mssql_query("begin transaction",$conexion) or die("Error SQL begin trans");
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Movimientos</title>
<style>
#FondoMovimientos{
	position:absolute;
	width:726px; 
	height:260px;
	left:9px; 
	top:7px;
	font: Gautami; 
	font-weight:bold; 
	color:#FFFFFF; 
	font-size:12px; 
	z-index:0;
}

#caja{
	position:absolute;
	top:298px;
	left:107px;
	width:50px;
	font-family: "TPro";
	font-size:15px;
}

#DetalleCompras{
	position:absolute; 
	width:735px; 
	height:230px;
	top:1px;
	left:3px;
	z-index:4;
}

#DetalleGastos{
	position:absolute; 
	width:735px; 
	height:230px;
	top:1px;
	left:3px;
	z-index:4;
}

#DetalleVentas{
	position:absolute; 
	width:735px; 
	height:230px;
	top:1px;
	left:3px;
	z-index:4;
}

#DetalleCtaCte{
	position:absolute; 
	width:735px; 
	height:230px;
	top:1px;
	left:3px;
	z-index:4;
}
</style>

<script>

function salir_Mov(){

	Mos_Ocu("BotonesPri");
	Mos_Ocu('Movimientos');
	$('#SobreFoca').fadeIn(500);
	document.getElementById('Movimientos').innerHTML = '';

}

function volver(){
	
	document.getElementById("BotMovCom").style.display = "block";
	//document.getElementById("BotMovCtaCte").style.display = "block";
	document.getElementById("BotMovGas").style.display = "block";
	document.getElementById("BotMovVen").style.display = "block";
	document.getElementById("BotMovNaNb").style.display = "block";
	document.getElementById("BotMovVol").style.display = "none";
	SoloBlock("BotMovSal");
	SoloNone("BotMovAnular, BotMovImprimir");

	$('#DetalleCompras').fadeOut(500);

	$('#DetalleGastos').fadeOut(500);

	$('#DetalleVentas').fadeOut(500);

	$('#DetalleNaNb').fadeOut(500);

	//$('#DetalleCtaCte').fadeOut(500);
}

function compras(){

	document.getElementById("BotMovCom").style.display = "none";
	document.getElementById("BotMovGas").style.display = "none";
	document.getElementById("BotMovVen").style.display = "none";
	document.getElementById("BotMovNaNb").style.display = "none";
	//document.getElementById("BotMovCtaCte").style.display = "none";
	document.getElementById("BotMovVol").style.display = "block";
	SoloNone("BotMovSal");

	$("#DetalleCompras").load("MovCom.php");
	
	$('#DetalleCompras').fadeIn(500);	
}

function gastos(){
	
	document.getElementById("BotMovCom").style.display = "none";
	document.getElementById("BotMovGas").style.display = "none";
	document.getElementById("BotMovVen").style.display = "none";
	document.getElementById("BotMovNaNb").style.display = "none";
	//document.getElementById("BotMovCtaCte").style.display = "none";	
	document.getElementById("BotMovVol").style.display = "block";
	SoloNone("BotMovSal");
	
	$("#DetalleGastos").load("MovGas.php");
	
	$('#DetalleGastos').fadeIn(500);
	
}

function ventas(){
	
	document.getElementById("BotMovCom").style.display = "none";
	document.getElementById("BotMovGas").style.display = "none";
	document.getElementById("BotMovVen").style.display = "none";
	document.getElementById("BotMovNaNb").style.display = "none";
	//document.getElementById("BotMovCtaCte").style.display = "none";	
	document.getElementById("BotMovVol").style.display = "block";
	SoloNone("BotMovSal");
	
	$("#DetalleVentas").load("MovVen.php");

	$('#DetalleVentas').fadeIn(500);
}

function naynb(){
	
	document.getElementById("BotMovCom").style.display = "none";
	document.getElementById("BotMovGas").style.display = "none";
	document.getElementById("BotMovVen").style.display = "none";
	document.getElementById("BotMovNaNb").style.display = "none";
	//document.getElementById("BotMovCtaCte").style.display = "none";	
	document.getElementById("BotMovVol").style.display = "block";
	SoloNone("BotMovSal");
	
	$("#DetalleNaNb").load("MovNaNb.php");
	
	$('#DetalleNaNb').fadeIn(500);
}

function ctacte(){
	
	document.getElementById("BotMovCom").style.display = "none";
	document.getElementById("BotMovGas").style.display = "none";
	document.getElementById("BotMovVen").style.display = "none";
	document.getElementById("BotMovNaNb").style.display = "none";
	document.getElementById("DetalleNaNb").style.display = "none";	
	document.getElementById("BotMovVol").style.display = "block";
	SoloNone("BotMovSal");
	
	$("#DetalleCtaCte").load("MovCtaCte.php");
	
	$('#DetalleCtaCte').fadeIn(500);
}


document.getElementById('LetSal').innerHTML = '<button class="StyBoton" onclick="salir_Mov();" onmouseout="MM_swapImgRestore()" onmouseover="MM_swapImage(\'LetSal\',\'\',\'botones/sal-over.png\',0)"><img src="botones/sal-up.png" name="Salir" title="Salir" border="0" id="LetSalMov"/></button>';


</script>

</head>

<body>

<div id="FondoNegro">
	<img src="Movimientos/fondo-ne-na.png" />
</div>	

<div id="FondoMovimientos">
	<img src="Movimientos/movimiento.png" />
<?
//primero muestra las planillas disponibles para realizar las consultas:
	//PRIMERO BUSCAR LOS DATOS DEL TURNO para el encabezado.
     //conteos cargados
	$_SESSION['ParSQL'] = "
	SELECT C.NplVen AS PLA, D.FAP AS FAP, A.MTN, A.DES, A.INI, A.FIN FROM ATURNOSH AS A 
	INNER JOIN APARPOS AS B ON B.ID = '".$_SESSION['ParPOS']."'
	INNER JOIN VENDEDORES AS C ON C.CodVen = B.OPE
	INNER JOIN ATURNOSO AS D ON D.PLA = C.NplVen
	WHERE A.MTN = D.MTN
	";
	
	$registros = mssql_query($_SESSION['ParSQL']) or die("Error SQL");
	rollback($registros);		
	
	if(mssql_num_rows($registros)==0){
		exit;
	}
	while ($reg=mssql_fetch_array($registros)){
	
		$PLA = $reg['PLA'];
		
	}
  $LUG = $_SESSION['ParLUG'];
  $OPE = $_SESSION['idsusua'];
?>

	<div id="caja" align="center"><? echo $PLA; ?></div>


</div>	




<!-- ------------- BOTONES --------------- -->

<!--
<div id="BotMovCtaCte" style="position:absolute;  top:288px; left:220px;" class="OcultarBoton">
	<button  onclick="ctacte();" class="StyBoton" onmouseout="MM_swapImgRestore()" onmouseover="MM_swapImage('BotMovCuenta','','botones/cta-over.png',0)"><img src="botones/cta-up.png" name="Cuenta Corriente" title="Cuenta Corriente" border="0" id="BotMovCuenta"></button>
</div>				
-->
<div id="BotMovNaNb" style="position:absolute;  top:288px; left:220px;">
	<button class="StyBoton" onclick="naynb();" onmouseout="MM_swapImgRestore()" onmouseover="MM_swapImage('BotMovNaNb1','','botones/na-nb-over.png',0)"><img src="botones/na-nb-up.png" name="Alta y Baja" title="Alta y Baja" border="0" id="BotMovNaNb1"/></button>
</div>

<div id="BotMovCom" style="position:absolute;  top:288px; left:320px;" class="OcultarBoton">
	<button  onclick="compras();" class="StyBoton" onmouseout="MM_swapImgRestore()" onmouseover="MM_swapImage('BotMovCompras','','botones/com-over.png',0)"><img src="botones/com-up.png" name="Compras" title="Compras" border="0" id="BotMovCompras"></button>
</div>				

<div id="BotMovGas" style="position:absolute; top:288px; left:420px;">
	<button class="StyBoton" onclick="gastos();" onmouseout="MM_swapImgRestore()" onmouseover="MM_swapImage('BotMovGastos','','botones/gas-over.png',0)"><img src="botones/gas-up.png" name="Gastos" title="Gastos" border="0" id="BotMovGastos"/></button>
</div>

<div id="BotMovVen" style="position:absolute;  top:288px; left:520px;">
	<button  onclick="ventas();" class="StyBoton" onmouseout="MM_swapImgRestore()" onmouseover="MM_swapImage('BotMovVentas','','botones/ven-over.png',0)"><img src="botones/ven-up.png" name="Ventas" title="Ventas" border="0" id="BotMovVentas"></button>
</div>				

<div id="BotMovVol" style="position:absolute; top:288px; left:640px; display:none;">
	<button class="StyBoton" onclick="volver();" onmouseout="MM_swapImgRestore()" onmouseover="MM_swapImage('BotMovVol','','botones/vol-over.png',0)"><img src="botones/vol-up.png" name="Volver" title="Volver" border="0" id="BotMovVol"/></button>
</div>


<div id="BotMovSal" style="position:absolute; top:288px; left:640px; display:block;">
	<button  onclick="salir_Mov();" class="StyBoton" onmouseout="MM_swapImgRestore()" onmouseover="MM_swapImage('LetSalirMov','','botones/sal-over.png',0)"><img src="botones/sal-up.png" name="Salir" title="Salir" border="0" id="LetSalirMov"></button>
</div>	


<!-- ------------- CAPAS --------------- -->

<div id="DetalleCtaCte" style="display:none;"> 
</div>
<div id="DetalleCompras" style="display:none;"> 
</div>
<div id="DetalleGastos" style="display:none;"> 
</div>
<div id="DetalleVentas" style="display:none;"> 
</div>
<div id="DetalleNaNb" style="display:none;">
</div>

<!-- ------------- BOTONES NA Y NB --------------- -->
<div id="BotMovAnular" style="position:absolute; top:288px; left:220px; display:none;">
</div>

<div id="BotMovImprimir" style="position:absolute; top:288px; left:320px; display:none;">
</div>


<div style="position:absolute; top:-3px; left:706px; z-index:5;">
	<button class="StyBoton" onclick="salir_Mov();" onmouseout="MM_swapImgRestore()" onmouseover="MM_swapImage('BotMovSal','','otros/cru-over.png',0)"><img src="otros/cru-up.png" name="Salir" title="Salir" border="0" id="BotMovSal"/></button>
</div>

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