<?
require("config/cnx.php");

try {////////////////////////////////////////////////////////////////////////////////////////////////// COMIENZO TRY //

mssql_query("begin transaction",$conexion) or die("Error SQL begin trans");
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Detalle de Ventas</title>
<style>
.lineareVen1{
	background-image:url(Movimientos/fondo_n_ventas.png);
	background-repeat:repeat-x;
	font-family: "TPro";
	font-size:12px;
	height:28px;
	width:676px;
	margin-top:2px;
}


</style>

<script>

function movpag_a_movven(p){
	
	np = p - 1;
	document.getElementById("capa_movven"+np).style.display="block";
	document.getElementById("capa_movven"+p).style.display="none";

return false;
}

function movpag_b_movven(p){

	np = p + 1;	
	document.getElementById("capa_movven"+np).style.display="block";
	document.getElementById("capa_movven"+p).style.display="none";
	
return false;
}

</script>
</head>

<body>
<div id="FondoVentas" style="position:absolute; top:4px; left:10px; z-index:1;">
	<img src="Movimientos/ventas.png" />
</div>
<div style="position:absolute; top:57px; left:14px; width: 678px; height: 61px;">
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

//eliminar los datos de la tabla de consulta para limpiarla
	$_SESSION['ParSQL'] = "DELETE FROM APROVEN"; 
	$APROVEN = mssql_query($_SESSION['ParSQL']) or die("Error SQL");
	rollback($APROVEN);		

//VENTAS
	$_SESSION['ParSQL'] = "SELECT B.COD,B.ART,B.TIO,SUM(B.CAN) AS CAN,SUM(B.PUN*B.CAN) AS IMP from AMAEFACT AS A JOIN AMOVFACT AS B ON A.TIP = B.TIP AND A.TCO=B.TCO AND  A.SUC = B.SUC AND A.NCO=B.NCO AND A.LUG = B.LUG AND A.PLA = B.PLA JOIN A_CTRL_VTA_RUB AS C ON B.COD = C.SEC AND B.RUB = C.RUB where  A.ANU <> 'A' AND A.FPA <> 2 AND A.PLA = ".$PLA." AND A.LUG = ".$LUG." AND A.ANU <> 'A' AND A.TCO <> 'NC' GROUP BY B.COD,B.ART,B.TIO ORDER BY B.COD,B.ART";
	
	$VENTAS = mssql_query($_SESSION['ParSQL']) or die("Error SQL");
	rollback($VENTAS);		
	while ($RVTA=mssql_fetch_array($VENTAS)){
		
		$_SESSION['ParSQL'] = "SELECT ART FROM APROVEN WHERE SEC=".$RVTA['COD']." AND ART=".$RVTA['ART']."";
		$APROVEN = mssql_query($_SESSION['ParSQL']) or die("Error SQL");
		rollback($APROVEN);		
		if(mssql_num_rows($APROVEN) == 0){
		//INSERT
			$_SESSION['ParSQL'] = "INSERT INTO APROVEN (SEC,ART,DES,CAE,IME) VALUES 
			(".$RVTA['COD'].", ".$RVTA['ART'].", '".$RVTA['TIO']."',".$RVTA['CAN'].",".$RVTA['IMP'].")";
			$AINS = mssql_query($_SESSION['ParSQL']) or die("Error SQL");
			rollback($AINS);			
  		}else{
			//update
			$_SESSION['ParSQL'] = "UPDATE APROVEN SET CAE = CAE + ".$RVTA['CAN'].", IME = IME +".$RVTA['IMP']." WHERE SEC=".$RVTA['COD']." AND ART=".$RVTA['ART']."";
			$AUPD = mssql_query($_SESSION['ParSQL']) or die("Error SQL");
			rollback($AUPD);				
		}
		
	}
	
	//CUENTAS CORRIENTES NO NC
	
	$_SESSION['ParSQL'] = "SELECT B.COD,B.ART,B.TIO,SUM(B.CAN) AS CAN,SUM(B.PUN*B.CAN) AS IMP from AMAEFACT AS A JOIN AMOVFACT AS B ON A.TIP = B.TIP AND A.TCO=B.TCO AND  A.SUC = B.SUC AND A.NCO=B.NCO AND A.LUG = B.LUG AND A.PLA = B.PLA JOIN A_CTRL_VTA_RUB AS C ON B.COD = C.SEC AND B.RUB = C.RUB where  A.ANU <> 'A' AND A.FPA = 2 AND A.PLA = ".$PLA." AND A.LUG = ".$LUG." AND A.ANU <> 'A' AND A.TCO <> 'NC' GROUP BY B.COD,B.ART,B.TIO ORDER BY B.COD,B.ART";
	
	$VENTAS = mssql_query($_SESSION['ParSQL']) or die("Error SQL");
	rollback($VENTAS);		
	while ($RVTA=mssql_fetch_array($VENTAS)){
		
		$_SESSION['ParSQL'] = "SELECT ART FROM APROVEN WHERE SEC=".$RVTA['COD']." AND ART=".$RVTA['ART']."";
		$APROVEN = mssql_query($_SESSION['ParSQL']) or die("Error SQL");
		rollback($APROVEN);		
		if(mssql_num_rows($APROVEN) == 0){
		//INSERT
			$_SESSION['ParSQL'] = "INSERT INTO APROVEN (SEC,ART,DES,CAC,IMC) VALUES 
			(".$RVTA['COD'].", ".$RVTA['ART'].", '".$RVTA['TIO']."',".$RVTA['CAN'].",".$RVTA['IMP'].")";
			$AINS = mssql_query($_SESSION['ParSQL']) or die("Error SQL");
			rollback($AINS);			
  		}else{
			//update
			$_SESSION['ParSQL'] = "UPDATE APROVEN SET CAC = CAC + ".$RVTA['CAN'].", IMC = IMC +".$RVTA['IMP']." WHERE SEC=".$RVTA['COD']." AND ART=".$RVTA['ART']."";
			$AUPD = mssql_query($_SESSION['ParSQL']) or die("Error SQL");
			rollback($AUPD);				
		}
		
	}	

	//CUENTAS CORRIENTES SI NC
	
	$_SESSION['ParSQL'] = "SELECT B.COD,B.ART,B.TIO,SUM(B.CAN) * - 1 AS CAN,SUM(B.PUN*B.CAN) * -1  AS IMP from AMAEFACT AS A JOIN AMOVFACT AS B ON A.TIP = B.TIP AND A.TCO=B.TCO AND  A.SUC = B.SUC AND A.NCO=B.NCO AND A.LUG = B.LUG AND A.PLA = B.PLA JOIN A_CTRL_VTA_RUB AS C ON B.COD = C.SEC AND B.RUB = C.RUB where  A.ANU <> 'A' AND A.FPA = 2 AND A.PLA = ".$PLA." AND A.LUG = ".$LUG." AND A.ANU <> 'A' AND A.TCO = 'NC' GROUP BY B.COD,B.ART,B.TIO ORDER BY B.COD,B.ART";
	
	$VENTAS = mssql_query($_SESSION['ParSQL']) or die("Error SQL");
	rollback($VENTAS);		
	while ($RVTA=mssql_fetch_array($VENTAS)){
		
		$_SESSION['ParSQL'] = "SELECT ART FROM APROVEN WHERE SEC=".$RVTA['COD']." AND ART=".$RVTA['ART']."";
		$APROVEN = mssql_query($_SESSION['ParSQL']) or die("Error SQL");
		rollback($APROVEN);		
		if(mssql_num_rows($APROVEN) == 0){
		//INSERT
			$_SESSION['ParSQL'] = "INSERT INTO APROVEN (SEC,ART,DES,CAC,IMC) VALUES 
			(".$RVTA['COD'].", ".$RVTA['ART'].", '".$RVTA['TIO']."',".$RVTA['CAN'].",".$RVTA['IMP'].")";
			$AINS = mssql_query($_SESSION['ParSQL']) or die("Error SQL");
			rollback($AINS);			
  		}else{
			//update
			$_SESSION['ParSQL'] = "UPDATE APROVEN SET CAC = CAC + ".$RVTA['CAN'].", IMC = IMC +".$RVTA['IMP']." WHERE SEC=".$RVTA['COD']." AND ART=".$RVTA['ART']."";
			$AUPD = mssql_query($_SESSION['ParSQL']) or die("Error SQL");
			rollback($AUPD);				
		}
		
	}	


$_SESSION['ParSQL'] = "SELECT * FROM APROVEN ORDER BY SEC,ART";

$R1TB = mssql_query($_SESSION['ParSQL']) or die("Error SQL");
rollback($R1TB);


if(!mssql_num_rows($R1TB) == 0){
	$total = mssql_num_rows($R1TB);
}

$c = 0;
$cc = 0;
$s = 1;
$t = 0;

while ($ATU=mssql_fetch_row($R1TB)){

	$c = $c + 1;
	$cc = $cc + 1;

	if ($c == 1){
		
			if($s == 1){
				$e = "block";
			}else{
				$e = "none";
			}
		
			echo "<div id=\"capa_movven".$s."\" style=\"display:".$e."\">";
			
			if($s <> 1){
				?>

				<div id="AnteriorVen" style=" position:absolute; top:0px; left:674px;">
					<button class="StyBoton" onclick="return movpag_a_movven(<?php echo $s; ?>)" onMouseOut="MM_swapImgRestore()" onMouseOver="MM_swapImage('AnteriorMov_Ven','','otros/scr_arri-over.png',0)"><img src="otros/scr_arri-up.png" border="0" id="AnteriorMov_Ven"/></button>
</div>
	
				<?
	
			}
	
			}
	
			?>
			<div class="lineareVen1" id="linea<? echo $cc; ?>">
				<table width="677" height="26" border="0" cellpadding="0" cellspacing="0">
					<tr>
						<td width="57" align="center"><? echo $cc; ?></td>
						<!-- TIP -->
						<td width="86" align="center"><? echo $ATU['0']."-".$ATU['1']; ?></td>
						<!-- SUC -->
						<td width="167" align="center"><? echo substr($ATU['2'],0,19); ?></td>
						<!-- NCO -->
						<td width="60" align="center"><? echo $ATU['3']; ?></td>
						<!-- ANU -->
						<td width="62" align="center"><? echo dec($ATU['4'],2); ?></td>
						<!-- ANU -->
						<td width="62" align="center"><? echo $ATU['5']; ?></td>
						<!-- TIP -->
						<td width="61" align="center"><? echo $ATU['6']; ?></td>
						<!-- SUC -->
						<td width="63" align="center">
						<?
						$can = $ATU['3'] + $ATU['5'];
						echo $can;
						 ?></td>
						<!-- NCO -->
						<td width="59" align="center"><?
						$tot = $ATU['4'] + $ATU['6'];
						echo dec($tot,2);
						?></td>
						<!-- ANU -->

					</tr>
			  </table>
			</div>
			<?
			$t = $c;

			if ($c == 7){
	
			?>
	
			<div id="SiguienteVen<?php echo $s; ?>" style="position:absolute; top:178px;  left:674px;">
				<button class="StyBoton" onclick="return movpag_b_movven(<?php echo $s; ?>);" onMouseOut="MM_swapImgRestore()" onMouseOver="MM_swapImage('SiguienteMov_Ven','','otros/scr_aba-over.png',0)"><img src="otros/scr_aba-up.png" border="0" id="SiguienteMov_Ven"/></button>
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
		SoloNone("SiguienteVen<?php echo $s-1; ?>");
    </script>
	<?
}
?>
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