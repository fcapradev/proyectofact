<?
require("config/cnx.php");

try {////////////////////////////////////////////////////////////////////////////////////////////////// COMIENZO TRY //

mssql_query("begin transaction",$conexion) or die("Error SQL begin trans");
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Detalle de Nota Alta y Nota Baja</title>
<style>
.lineareNanb1{
	background-image:url(Movimientos/fondo_n_naynb.png);
	background-repeat:repeat-x;
	font-family: "TPro";
	font-size:12px;
	height:28px;
	width:661px;
	margin-top:2px;
}


</style>

<script>

function movpag_a_movnanb(p){
	
	np = p - 1;
	document.getElementById("capa_movnanb"+np).style.display="block";
	document.getElementById("capa_movnanb"+p).style.display="none";

return false;
}

function movpag_b_movnanb(p){

	np = p + 1;	
	document.getElementById("capa_movnanb"+np).style.display="block";
	document.getElementById("capa_movnanb"+p).style.display="none";
	
return false;
}


function selecciona(t,f,tco,pve,nco,pla,est){

	for (i=1; i<=t; i++){
		if(i == f){			
			$("#linea"+f).removeClass("lineare1").addClass("lineareNanb1");
			
			if(est == 'Anulado'){
				
				SoloBlock("BotMovImprimir");
				SoloNone("BotMovAnular");
	
				document.getElementById('BotMovImprimir').innerHTML = '<button class="StyBoton" onclick="ImprimeNaNb(\''+tco+'\','+pve+','+nco+','+pla+');" onmouseout="MM_swapImgRestore()" onmouseover="MM_swapImage(\'BotImpNot\',\'\',\'botones/imp-over.png\',0)"><img src="botones/imp-up.png" name="Imprimir" title="Imprimir" border="0" id="BotImpNot"/></button>';
				
			}else{
				
				SoloBlock("BotMovAnular, BotMovImprimir");
	
				document.getElementById('BotMovAnular').innerHTML = '<button class="StyBoton" onclick="AnulaNaNb(\''+tco+'\','+pve+','+nco+','+pla+');" onmouseout="MM_swapImgRestore()" onmouseover="MM_swapImage(\'BotAnuNot\',\'\',\'botones/anu-over.png\',0)"><img src="botones/anu-up.png" name="Anular" title="Anular" border="0" id="BotAnuNot"/></button>';
	
				document.getElementById('BotMovImprimir').innerHTML = '<button class="StyBoton" onclick="ImprimeNaNb(\''+tco+'\','+pve+','+nco+','+pla+');" onmouseout="MM_swapImgRestore()" onmouseover="MM_swapImage(\'BotImpNot\',\'\',\'botones/imp-over.png\',0)"><img src="botones/imp-up.png" name="Imprimir" title="Imprimir" border="0" id="BotImpNot"/></button>';
			}

		}else{
			$("#linea"+i).removeClass("lineareNanb1").addClass("lineare1");
		}	
		
	}
	
}

function AnulaNaNb(tco,pve,nco,pla){

	 jConfirm("¿Está seguro que desea anular?", "Debo Retail - Global Business Solution", function(r){
		if(r == true ){
			$("#archivos").load("Movimientos/MovimientoProcesa.php?tipo=1&tco="+tco+"&pve="+pve+"&nco="+nco+"&pla="+pla+"");
		}
	});
}

function ImprimeNaNb(tco,pve,nco,pla){
	$("#archivos").load("Movimientos/MovimientoProcesa.php?tipo=2&tco="+tco+"&pve="+pve+"&nco="+nco+"&pla="+pla+"");
}
</script>
</head>

<body>
<div id="FondoNaNb" style="position:absolute; top:4px; left:11px; z-index:1;">
	<img src="Movimientos/nanb.png" />
</div>
<div style="position:absolute; top:57px; left:16px;">
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
	
	if(mssql_num_rows($registros)==0){
		exit;
	}
	while ($reg=mssql_fetch_array($registros)){
	
		$PLA = $reg['PLA'];
		
	}
  $LUG = $_SESSION['ParLUG'];
  $OPE = $_SESSION['idsusua'];


//traer na y nb --> estas se pueden anular y reimprimir

	$_SESSION['ParSQL'] = "SELECT TIP,TCO,PVE,NCO,TIM,ANU FROM AMOVSTOC WHERE PLA=".$PLA." AND TCO IN ('NA','NB') GROUP BY TIP,TCO,PVE,NCO,TIM,ANU";
	$NANB = mssql_query($_SESSION['ParSQL']) or die("Error SQL");
	rollback($NANB);
	
	while ($RNAB=mssql_fetch_array($NANB)){
		
		switch ($RNAB['TIM']){
			
    		case "DV":
               $sTipo_Movimiento = "Depósito a Ventas             ";
        		break;
            case "VV":
               $sTipo_Movimiento = "Ventas a Ventas               ";
        		break;
            case "VD":
               $sTipo_Movimiento = "Ventas a Depósito             ";
        		break;
            case "VX":
               $sTipo_Movimiento = "Retiro de Ventas              ";
        		break;
            case "DX":
               $sTipo_Movimiento = "Retiro de Depósito            ";
        		break;
            case "VR":
               $sTipo_Movimiento = "Retiro en Ventas              ";
        		break;
            case "DR":
               $sTipo_Movimiento = "Retiro de Depósito            ";
        		break;
            case "VQ":
               $sTipo_Movimiento = "Vencimiento de Ventas         ";
        		break;
            case "DQ":
               $sTipo_Movimiento = "Vencimiento de Depósito       ";
        		break;
            case "DO":
               $sTipo_Movimiento = "Deposito a Otros              ";
        		break;
            case "VO":
               $sTipo_Movimiento = "Ventas a Otros                ";
        		break;
            case "AC":
               $sTipo_Movimiento = "Antencion al Cliente          ";
        		break;
            case "OV":
               $sTipo_Movimiento = "Ingreso de Otros a Ventas     ";
        		break;
            case "OD":
               $sTipo_Movimiento = "Ingreso de Otros a Depósito   ";
        		break;
			default:
               $sTipo_Movimiento = "No Codificado                 ";
        		break;
			
		}
	

        $sEstado = "OK";
        if ($RNAB['ANU'] == "A"){ 
			$sEstado = "Anulado";
		}

		//datos a mostrar
		$TCO = $RNAB['TCO'];
		$PVE = $RNAB['PVE'];
		$NCO = $RNAB['NCO'];
		$sTipo_Movimiento ;
		
	}


$_SESSION['ParSQL'] = "SELECT TIP,TCO,PVE,NCO,TIM,ANU FROM AMOVSTOC WHERE PLA=".$PLA." AND TCO IN ('NA','NB') GROUP BY TIP,TCO,PVE,NCO,TIM,ANU";
$R1TB = mssql_query($_SESSION['ParSQL']) or die("Error SQL");
rollback($R1TB);		

$total = mssql_num_rows($R1TB);

$c = 0;
$cc = 0;
$s = 1;
$t = 0;
while ($ATU=mssql_fetch_row($R1TB)){
	
	switch ($ATU['4']){
			
    		case "DV":
               $sTipo_Movimiento = "Depósito a Ventas             ";
        		break;
            case "VV":
               $sTipo_Movimiento = "Ventas a Ventas               ";
        		break;
            case "VD":
               $sTipo_Movimiento = "Ventas a Depósito             ";
        		break;
            case "VX":
               $sTipo_Movimiento = "Retiro de Ventas              ";
        		break;
            case "DX":
               $sTipo_Movimiento = "Retiro de Depósito            ";
        		break;
            case "VR":
               $sTipo_Movimiento = "Retiro en Ventas              ";
        		break;
            case "DR":
               $sTipo_Movimiento = "Retiro de Depósito            ";
        		break;
            case "VQ":
               $sTipo_Movimiento = "Vencimiento de Ventas         ";
        		break;
            case "DQ":
               $sTipo_Movimiento = "Vencimiento de Depósito       ";
        		break;
            case "DO":
               $sTipo_Movimiento = "Deposito a Otros              ";
        		break;
            case "VO":
               $sTipo_Movimiento = "Ventas a Otros                ";
        		break;
            case "AC":
               $sTipo_Movimiento = "Antencion al Cliente          ";
        		break;
            case "OV":
               $sTipo_Movimiento = "Ingreso de Otros a Ventas     ";
        		break;
            case "OD":
               $sTipo_Movimiento = "Ingreso de Otros a Depósito   ";
        		break;
			default:
               $sTipo_Movimiento = "No Codificado                 ";
        		break;
			
		}
	

        $sEstado = "OK";
        if ($ATU['5'] == "A"){ 
			$sEstado = "Anulado";
		}

		//datos a mostrar
		$TCO = $ATU['1'];
		$PVE = $ATU['2'];
		$NCO = $ATU['3'];
		$sTipo_Movimiento;

	$c = $c + 1;
	$cc = $cc + 1;


	if ($c == 1){
		
			if($s == 1){
				$e = "block";
			}else{
				$e = "none";
			}
		
			echo "<div id=\"capa_movnanb".$s."\" style=\"display:".$e."\">";
			
			if($s <> 1){
				?>

				<div id="AnteriorNanb" style=" position:absolute; top:0px; left:674px;">
					<button class="StyBoton" onclick="return movpag_a_movnanb(<?php echo $s; ?>)" onMouseOut="MM_swapImgRestore()" onMouseOver="MM_swapImage('AnteriorMov_Nanb','','otros/scr_arri-over.png',0)"><img src="otros/scr_arri-up.png" border="0" id="AnteriorMov_Nanb"/></button>
</div>
	
				<?
	
			}
	
			}
	
			?>
			<div class="lineare1" id="linea<? echo $cc; ?>" onclick="selecciona(<? echo $total; ?>,<? echo $cc; ?>,'<? echo $ATU['1']; ?>',<? echo $ATU['2']; ?>,<? echo $ATU['3']; ?>,<? echo $PLA; ?>,'<? echo $sEstado; ?>');" style="cursor:pointer;">
				<table width="662" height="26" border="0" cellpadding="0" cellspacing="0">
					<tr>
						<td width="28" align="center"><? echo $cc; ?></td>
						<td width="42" align="center"><? echo $ATU['1']; ?></td>
						<td width="99" align="center"><? echo $ATU['2']; ?></td>
						<td width="104" align="center"><? echo $ATU['3']; ?></td>
						<td width="324" align="center"><? echo $sTipo_Movimiento; ?></td>
						<td width="59" align="center"><samp style="font-family:'TPro'; font-weight:bold;  font-size:13px"><b><? echo $sEstado; ?></b></samp></td>

					</tr>
			  </table>
			</div>
			<?
			$t = $c;
			
			if ($c == 7){
	
			?>
	
			<div id="SiguienteNanb<?php echo $s; ?>" style="position:absolute; top:178px;  left:674px;">
				<button class="StyBoton" onclick="return movpag_b_movnanb(<?php echo $s; ?>);" onMouseOut="MM_swapImgRestore()" onMouseOver="MM_swapImage('SiguienteMov_Nanb','','otros/scr_aba-over.png',0)"><img src="otros/scr_aba-up.png" border="0" id="SiguienteMov_Nanb"/></button>
</div>
		
</div>
			<?php

			$c = 0;
			$s = $s + 1;
	}
}

if ($t == 7){
	?>
	<script>
		SoloNone("SiguienteNanb<?php echo $s-1; ?>");
    </script>
	<?
}
?>
</div>



		
</body>
</html>
<?

mssql_query("commit transaction") or die("Error SQL commit");

}catch(Exception $e){////////////////////////////////////////////////////////////////////////////////////////////////// FIN DE TRY 	
	?>
	<script>
		jAlert('ERROR Reintente la operacion solicitada.', 'Debo Retail - Global Business Solution');
	</script>
	<?

exit;

}

?>