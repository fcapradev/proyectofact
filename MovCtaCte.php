<?
require("config/cnx.php");

try {////////////////////////////////////////////////////////////////////////////////////////////////// COMIENZO TRY //

mssql_query("begin transaction",$conexion) or die("Error SQL begin trans");
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Detalle de Cuenta Corriente</title>
<style>
.lineareCta1{
	background-image:url(Movimientos/fondoctacte.png);
	background-repeat:repeat-x;
	font-family: "TPro";
	font-size:12px;
	font-weight:100;
	height:28px;
	width:675px;
	margin-top:2px;
}


</style>

<script>

function movpag_a_movcta(p){
	
	np = p - 1;
	document.getElementById("capa_movcta"+np).style.display="block";
	document.getElementById("capa_movcta"+p).style.display="none";

return false;
}

function movpag_b_movcta(p){

	np = p + 1;	
	document.getElementById("capa_movcta"+np).style.display="block";
	document.getElementById("capa_movcta"+p).style.display="none";
	
return false;
}

</script>
</head>

<body>
<div id="FondoCtaCte" style="position:absolute; top:4px; left:11px; z-index:1;">
	<img src="Movimientos/Cuentas Corrientes.png" />
</div>
<div style="position:absolute; top:57px; left:15px; width: 675px;">
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

$nTotCta=0;

$_SESSION['ParSQL'] = "SELECT A.TIP, A.TCO, A.SUC, A.NCO, A.FEC, A.COD, A.NOM,(A.NEE+A.NET+A.IRI+A.IRS+A.IMI) AS IMP, A.VEN, 
					ISNULL(B.NOM,'Sin Nombre')  AS BNOM
					FROM AMAEFACT A INNER JOIN CLIENTES B ON A.COD = B.COD WHERE A.ANU <> 'A' 
   					AND A.FPA = 2 AND A.PLA = ".$PLA." AND A.LUG = ".$LUG." ORDER BY A.TIP,A.TCO,A.SUC,A.NCO,A.FEC";
					
$R1TB = mssql_query($_SESSION['ParSQL']) or die("Error SQL");
rollback($R1TB);		
$IDROW=1;

$c = 0;
$cc = 0;
$s = 1;
$t= 0;

while ($ATU=mssql_fetch_row($R1TB)){

	$COL0=format($IDROW,3,'0',STR_PAD_LEFT);
	$COL1=$ATU['0']." ".$ATU['1']." ".format($ATU['2'],4,'0',STR_PAD_LEFT)." ".format($ATU['3'],4,'0',STR_PAD_LEFT);
	$COL2=$ATU['4'];
	$COL3=format($ATU['5'],5,'0',STR_PAD_LEFT);
	$COL4=$ATU['9'];
	$COL5=dec($ATU['7'],2);
	$COL6=format($ATU['8'],3,'0',STR_PAD_LEFT);
	$nTotCta = $nTotCta + $ATU['7'];

$fecha = $ATU['4'];
$date = new DateTime($fecha);
$fecha = $date->format('d-m-Y');

	$c = $c + 1;
	$cc = $cc + 1;

	if ($c == 1){
		
			if($s == 1){
				$e = "block";
			}else{
				$e = "none";
			}
		
			echo "<div id=\"capa_movcta".$s."\" style=\"display:".$e."\">";
			
			if($s <> 1){
				?>

				<div id="AnteriorCta" style=" position:absolute; top:0px; left:674px;">
					<button class="StyBoton" onclick="return movpag_a_movcta(<?php echo $s; ?>)" onMouseOut="MM_swapImgRestore()" onMouseOver="MM_swapImage('AnteriorMov_Cta','','otros/scr_arri-over.png',0)"><img src="otros/scr_arri-up.png" border="0" id="AnteriorMov_Cta"/></button>
</div>
	
				<?
	
			}
	
			}
	
			?>
			<div class="lineareCta1" id="linea<? echo $cc; ?>">
				<table width="675" height="26" border="0" cellpadding="0" cellspacing="0">
					<tr>
						<td width="54" align="center"><? echo $COL0; ?></td>
						<td width="144" align="center"><? echo $COL1; ?></td>
						<td width="127" align="center"><? echo $fecha; ?></td>
						<td width="82" align="center"><? echo $COL3; ?></td>
						<td width="106" align="center"><? echo $COL4; ?></td>
						<td width="101" align="center"><? echo $COL5; ?></td>
						<td width="61" align="center"><? echo $COL6; ?></td>
					</tr>
			  </table>
			</div>
			<?
			$t = $c;
			if ($c == 7){
	
			?>
	
			<div id="SiguienteCta<?php echo $s; ?>" style="position:absolute; top:178px;  left:674px;">
				<button class="StyBoton" onclick="return movpag_b_movcta(<?php echo $s; ?>);" onMouseOut="MM_swapImgRestore()" onMouseOver="MM_swapImage('SiguienteMov_Cta','','otros/scr_aba-over.png',0)"><img src="otros/scr_aba-up.png" border="0" id="SiguienteMov_Cta"/></button>
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
		SoloNone("SiguienteCta<?php echo $s-1; ?>");
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