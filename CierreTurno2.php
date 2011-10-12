<?
require("config/cnx.php");

try {////////////////////////////////////////////////////////////////////////////////////////////////// COMIENZO TRY //

mssql_query("begin transaction",$conexion) or die("Error SQL begin trans");

?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Cierre de Turnos - Fallidos</title>

<style>
#CT2Lista{
	position:absolute;
	width:277px;
	height:280px;
	left:7px;
	top:51px;
	font-weight:bold;
	color:#FFFFFF;
	font-size:12px;
	z-index:1;
}

#CT2Titulo{
	position:absolute;
	top:27px;
	left:8px;
}

#CT2Detalle{
	position:absolute; 
	width:473px; 
	height:308px;
	top:29px;
	left:292px;
	z-index:2;
}

#CT2DetalleFon{
	position:absolute; 
	width:473px; 
	height:308px;
	top:29px;
	left:292px;
	z-index:2;
}

.OcultarDetalle{
	display: none;
}


</style>
<script>

function salir_CT2(){

	Mos_Ocu("BotonesPri");

	$('#SobreFoca').fadeIn(500);
	
	$('#CierreTurno2').fadeOut(400);
	
	document.getElementById('CierreTurno2').innerHTML = '';
	
}

function CT2Sel(t,mp,tip,tco,suc,nco){
	
	$('#CT2Detalle').fadeOut(500);

	$("#CT2Detalle").load("CierreTurno2Det.php?tip="+tip+"&tco="+tco+"&suc="+suc+"&nco="+nco+"");
	
	$('#CT2Detalle').fadeIn(500);
	
	$("#CT2Detalle").removeClass("OcultarDetalle");
	
	$("#CT2DetalleFon").removeClass("OcultarDetalle");

	for (i=1; i<=t; i++){
	
		if(i == mp){
			
			$("#linea"+mp).removeClass("lineare1").addClass("lineare2");
/*			
				SoloBlock("BotAutoriza, BotImprime");

				document.getElementById('BotAutoriza').innerHTML = '<button class="StyBoton" onclick="AccBotAutTic(\''+tip+'\',\''+tco+'\','+suc+','+nco+');" onmouseout="MM_swapImgRestore()" onmouseover="MM_swapImage(\'BotAuto\',\'\',\'botones/com-aut-over.png\',0)"><img src="botones/com-aut-up.png" name="Autorizar" title="Autorizar" border="0" id="BotAuto"/></button>';

				document.getElementById('BotImprime').innerHTML = '<button class="StyBoton" onclick="AccBotImpTic(\''+tip+'\',\''+tco+'\','+suc+','+nco+');" onmouseout="MM_swapImgRestore()" onmouseover="MM_swapImage(\'BotImp\',\'\',\'botones/imp-over.png\',0)"><img src="botones/imp-up.png" name="Imprimir" title="Imprimir" border="0" id="BotImp"/></button>';
*/
					
		}else{

			$("#linea"+i).removeClass("lineare2").addClass("lineare1");
	
		}	
	}
}

function AccBotones(a){

	if( a == 1){
		
		jAlert('Los comprobantes que NO han sido Impresos, ser&aacute;n guardados como CI.','Debo Retail - Global Business Solution');
	
		$("#archivos").load("CierreTurno2Pro.php?ban=1");
		
	}else{
		
		jAlert('Esperando Impresi&oacute;n.', 'Debo Retail - Global Business Solution');
		
		$("#archivos").load("CierreTurno2Pro.php?ban=2");
	}
}

function movpag_a_CT2(p){
	
	np = p - 1;
	document.getElementById("capa_CT2"+np).style.display="block";
	document.getElementById("capa_CT2"+p).style.display="none";

return false;
}

function movpag_b_CT2(p){

	np = p + 1;	
	document.getElementById("capa_CT2"+np).style.display="block";
	document.getElementById("capa_CT2"+p).style.display="none";
	
return false;
}


</script>
</head>

<body>

<div id="CT2Fondo">
	<img src="cierre/COMPROBANTES SIN IMPRIMIR.png" />
</div>
<div id="CT2Titulo">
	<img src="cierre/barra de comprobantes.png" />
</div>


<div id="CT2Lista">
	
<?
$_SESSION['ParSQL'] = "
SELECT C.NplVen AS PLA FROM ATURNOSH AS A 
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

$_SESSION['ParSQL'] = "SELECT * FROM TMAEFACT ORDER BY NCO ASC"; 
//$_SESSION['ParSQL'] = "SELECT * FROM TMAEFACT WHERE PLA = ".$PLA." ORDER BY NCO ASC"; 
$R1TB = mssql_query($_SESSION['ParSQL']) or die("Error SQL");
rollback($R1TB);		

if(!mssql_num_rows($R1TB) == 0){
	$total = mssql_num_rows($R1TB);
}

$c = 0;
$cc = 0;
$s = 1;

while ($ATU=mssql_fetch_array($R1TB)){

	$TIP = $ATU['TIP'];
	$TCO = $ATU['TCO'];
	$SUC = $ATU['SUC'];
	$NCO = $ATU['NCO'];
	$FEC = $ATU['FEC'];
	
	$date1 = new DateTime($FEC);
	$FEC = $date1->format('d-m-Y H:m');
/*
	$TIP = $ATU['TIP'];
	$TIP = $ATU['TIP'];
	$TIP = $ATU['TIP'];
*/	
	$c = $c + 1;
	$cc = $cc + 1;

	
	if ($c == 1){
	
		if($s == 1){
			$e = "block";
		}else{
			$e = "none";
		}
	
		echo "<div id=\"capa_CT2".$s."\" style=\"display:".$e."\">";
		
		if($s <> 1){
			?>
		
			<div id="AnteriorCT2" style=" position:absolute; top:298px; left:225px;">
					<button class="StyBoton" onclick="return movpag_a_CT2(<?php echo $s; ?>)" onMouseOut="MM_swapImgRestore()" onMouseOver="MM_swapImage('AnteriorCT_2','','otros/scr_arri-over.png',0)"><img src="otros/scr_arri-up.png" border="0" id="AnteriorCT_2"/></button>
			</div>
	
			<?
	
		}
	
	}
	
	?>
	<div class="lineare1" id="linea<? echo $cc; ?>" style="width:269px; left:10px;" onclick="CT2Sel(<? echo $total; ?>,<? echo $cc; ?>,'<? echo $TIP; ?>','<? echo $TCO; ?>',<? echo $SUC;?>,<? echo $NCO;?>);">
		<table height="26" border="0" cellpadding="0" cellspacing="0">
		<tr>
                   
			<td width="30" align="center"><? echo $TIP; ?></td>
			<!--TIP-->
			<td width="30" align="center"><? echo $TCO; ?></td>
			<!--,TCO-->
			<td width="30" align="center"><? echo $SUC; ?></td>
			<!--,SUC-->
			<td width="30" align="center"><? echo $NCO; ?></td>
			<!--,NCO-->
			<td width="137" align="right"><? echo $FEC; ?>&nbsp;</td>
			<!--,ANU-->
		</tr>
	  </table>
	</div>
	<?


	if ($c == 10){
	
		?>
	
		<div id="SiguienteCT2" style="position:absolute; top:298px;  left:190px;">
				<button class="StyBoton" onclick="return movpag_b_CT2(<?php echo $s; ?>)" onMouseOut="MM_swapImgRestore()" onMouseOver="MM_swapImage('SiguienteCT_2','','otros/scr_aba-over.png',0)"><img src="otros/scr_aba-up.png" border="0" id="SiguienteCT_2"/></button>
		</div>
		
		</div>
		
		<?php
		  
		$c = 0;
		$s = $s + 1;

	}
	
}

if ($cc == 10){
	?>
	<script>
		$("#SiguienteCT2").fadeOut('fast');
    </script>
	<?
}
?>
	
</div>

</div>


<div id="CT2Salir" style="position:absolute; left:5px; top:345px;">
	<button id="BotLetSalCP2" onclick="salir_CT2();" class="StyBoton" onmouseout="MM_swapImgRestore()" onmouseover="MM_swapImage('LetSalirCT2','','botones/sal-over.png',0)"><img src="botones/sal-up.png" name="Salir" title="Salir" border="0" id="LetSalirCT2"></button>
</div>

<div id="CT2DetalleFon" class="OcultarDetalle" >
	<img src="ticketEmitidos/comprobantes internos.png" />
</div>

<div id="CT2Detalle" class="OcultarDetalle" ></div>

<div id="BotAutoriza" style="position:absolute; top:345px; left:415px; display:block;">
	<button class="StyBoton" onclick="AccBotones(1);" onmouseout="MM_swapImgRestore()" onmouseover="MM_swapImage('BotAuto','','botones/com-aut-over.png',0)"><img src="botones/com-aut-up.png" name="Autorizar" title="Autorizar" border="0" id="BotAuto"/></button>
</div>

<div id="BotImprime" style="position:absolute; top:345px; left:515px; display:block;">
	<button class="StyBoton" onclick="AccBotones(2);" onmouseout="MM_swapImgRestore()" onmouseover="MM_swapImage('BotImp','','botones/imp-over.png',0)"><img src="botones/imp-up.png" name="Imprimir" title="Imprimir" border="0" id="BotImp"/></button>
</div>













</body>
</html>

<?

mssql_query("commit transaction") or die("Error SQL commit");

}catch(Exception $e){////////////////////////////////////////////////////////////////////////////////////////////////// FIN DE TRY //
	
	?>
	<script>
		jAlert('ERROR Reintente la operacion solicitada.', 'Aukon - Global Business Solution');
	</script>
	<?
exit;

}

?>