<?
require("config/cnx.php");
/////////////////////////////// COMPRAS
/////////////////////////////// COMPRAS


try {////////////////////////////////////////////////////////////////////////////////////////////////// COMIENZO TRY //


mssql_query("begin transaction",$conexion) or die("Error SQL begin trans");


//SESSION
$LUG = $_SESSION['ParLUG'];

//REQUEST
$r_tip = $_REQUEST['tip'];
$r_tco = $_REQUEST['tco'];
$r_suc = $_REQUEST['suc'];
$r_nco = $_REQUEST['nco'];
$r_cod = $_REQUEST['cod'];


	?>
    <style>
		.ItemLis2{
			font-size:11px; 
			color:#FFF;
		}
	</style>
	<script>
	
		function mov_ant_fac2(p){

			np = p - 1;	
			document.getElementById("CapFacCom2"+np).style.display="block";
			document.getElementById("CapFacCom2"+p).style.display="none";
			
		return false;
		}
		function mov_sig_fac2(p){
			
			np = p + 1;	
			document.getElementById("CapFacCom2"+np).style.display="block";
			document.getElementById("CapFacCom2"+p).style.display="none";
			
		return false;
		}
	</script>
	<?

	$_SESSION['ParSQL'] = "SELECT NOM, OPE, FPA, FEC, FEV, NET, NEE, RGA, IRI, IRS, RIB, PIV, RIV, IMI, CNG, CNG2, DTO, PER, TOT, REC, REM, ANU FROM PMAEFACT WHERE TIP = '".$r_tip."' AND TCO = '".$r_tco."' AND SUC = ".$r_suc." AND NCO = ".$r_nco." AND COD = ".$r_cod;

	$PMAEFACT = mssql_query($_SESSION['ParSQL']) or die("Error SQL");
	rollback($PMAEFACT);
	while ($PMA_R = mssql_fetch_array($PMAEFACT)){
		
		$NOM = $PMA_R['NOM'];
		$OPE = $PMA_R['OPE'];	
		$FPA = $PMA_R['FPA'];
		
		$REC = $PMA_R['REC'];
		$REM = $PMA_R['REM'];
		
		$FEC = $PMA_R['FEC'];
		$FEV = $PMA_R['FEV'];
		
		$ANU = $PMA_R['ANU'];
	
		$NET = dec($PMA_R['NET'],2);
		$NEE = dec($PMA_R['NEE'],2);
		$RGA = dec($PMA_R['RGA'],2);
		$IRI = dec($PMA_R['IRI'],2);
		$IRS = dec($PMA_R['IRS'],2);
		$RIB = dec($PMA_R['RIB'],2);
		$PIV = dec($PMA_R['PIV'],2);
	
		$RIV = dec($PMA_R['RIV'],2);
		$IMI = dec($PMA_R['IMI'],2);
		$CNG = dec($PMA_R['CNG'],2);
		$CNG2 = dec($PMA_R['CNG2'],2);
		$DTO = $PMA_R['DTO'];
		$PER = dec($PMA_R['PER'],2);
		$TOT = dec($PMA_R['TOT'],2);
				
	}
	mssql_free_result($PMAEFACT);

	
	if($NET == 0){
		$NETO = $NEE;
	}else{
		$NETO = $NET;
	}
	$CNG3 = $CNG + $CNG2;
	$CNG3 = dec($CNG3,2);
		
	$_SESSION['ParSQL'] = "SELECT NOMBRE FROM FDPAGO WHERE ID = ".$FPA."";	
	$FDPAGO = mssql_query($_SESSION['ParSQL']) or die("Error SQL");
	rollback($PMAEFACT);
	while ($FDP_R = mssql_fetch_array($FDPAGO)){
		$PAGO = $FDP_R['NOMBRE'];
	}
	mssql_free_result($FDPAGO);
		
	if($ANU == "A"){
	?>
		<div style="position:absolute; top:232px; left:325px; "><img src="otros/anulado.png" /></div>
	<?				
	}
		
	
	$c = 0;
	$cc = 0;
	$s = 1;
	$t = 0;
	
	$_SESSION['ParSQL'] = "SELECT COD, ART, CAN, TIO, PUN FROM PMOVFACT 
	WHERE TIP = '".$r_tip."' AND TCO = '".$r_tco."' AND SUC = ".$r_suc." AND NCO = ".$r_nco." AND PRO = ".$r_cod;
	$PMOVFACT = mssql_query($_SESSION['ParSQL']) or die("Error SQL");
	rollback($PMOVFACT);
	while ($PMOV_R = mssql_fetch_array($PMOVFACT)){


		$FAC = format($PMOV_R['COD'],2,'0',STR_PAD_LEFT)."-".format($PMOV_R['ART'],4,'0',STR_PAD_LEFT);
		$CAN = $PMOV_R['CAN'];
		$TIO = $PMOV_R['TIO'];
		$PUN = $PMOV_R['PUN'];
		$SUB = $CAN * $PUN;
		$SUB = dec($SUB,2);
		$PUN = dec($PUN,2);

	++$c;
	++$cc;
	
	if ($c == 1){
	
		if($s == 1){
			$e = "block";
		}else{
			$e = "none";
		}
	
		echo "<div id=\"CapFacCom2".$s."\" style=\"display:".$e."\">";
		
		if($s <> 1){
			?>
		
			<div style="position:absolute; top:237px; left:434px;">
				<button class="StyBoton" onclick="mov_ant_fac2(<?php echo $s; ?>)" onMouseOut="MM_swapImgRestore()" onMouseOver="MM_swapImage('AntFacComC','','otros/scr_arri-over.png',0)"><img src="otros/scr_arri-up.png" border="0" id="AntFacComC"/></button>
			</div>
	
			<?
	
		}
	
	}
	
	?>
	<div class="ItemLis2">
		<table width="474" border="0" cellpadding="0" cellspacing="1">
		<tr>
			<td width="50" ><div align="center"><? echo $FAC; ?></div></td>
			<td width="87" ><div align="center"><? echo $CAN; ?></div></td>
			<td width="172"><div align="left"  ><? echo $TIO; ?></div></td>
			<td width="84" ><div align="center"><? echo $PUN; ?></div></td>
  			<td width="84" ><div align="center"><? echo $SUB; ?></div></td>
		</tr>
	  </table>
	</div>
	<?php
    $t = $c;
	if ($c == 7){
	
		?>
	
		<div id="SigFacComCid<?php echo $s; ?>" style="position:absolute; top:237px; left:390px;">
			<button class="StyBoton" onclick="mov_sig_fac2(<?php echo $s; ?>)" onMouseOut="MM_swapImgRestore()" onMouseOver="MM_swapImage('SigFacComC','','otros/scr_aba-over.png',0)"><img src="otros/scr_aba-up.png" border="0" id="SigFacComC"/></button>
		</div>
		
		</div>
		
		<?php
		
		$c = 0;
		$s = $s + 1;

	}
			
}
mssql_free_result($PMOVFACT);

if($t == 7){
	?>
    <script>
		SoloNone('SigFacComCid<?php echo $s - 1; ?>');
	</script>
    <?
}


$TIT1 = "Factura tipo: ".$r_tip."";
$TIT2 = "Forma de pago: ".$PAGO."   Cantidad de items: ".$cc."";

$ESTADO = "";

if($REC != 0){
	$ESTADO = "REMITO CANCELADO CON FACTURA Nº: ".format($REC,8,'0',STR_PAD_LEFT);
	?>
    <script>

		SoloBlock("BotonesLisTarImp");
		SoloNone("BotonesLisTarEli, BotonesLisTarMod");

	</script>
    
    <?
}else{
	?>
    <script>
		SoloBlock("BotonesLisTarImp, BotonesLisTarEli, BotonesLisTarMod");
	</script>
    <?	
}

if($REM != 0){
	$ESTADO = "ESTA FACTURA CANCELA REMITO Nº: ".format($REM,8,'0',STR_PAD_LEFT);
	?>
    <script>

		SoloBlock("BotonesLisTarImp, BotonesLisTarEli, BotonesLisTarMod");

	</script>
    <?
}


mssql_query("commit transaction") or die("Error SQL commit");

	?>
	<script>
	
		document.getElementById('tit1').innerHTML = "<? echo $TIT1; ?>";
		document.getElementById('estado').innerHTML = "<? echo $ESTADO; ?>";
		document.getElementById('tit2').innerHTML = "<? echo $TIT2; ?>";
		
		document.getElementById('det1').innerHTML = "<? echo $NETO; ?>";
		document.getElementById('det2').innerHTML = "<? echo $RGA; ?>";
		document.getElementById('det3').innerHTML = "<? echo $IRI; ?>";
		document.getElementById("det4").innerHTML = "<? echo $IRS; ?>";
		document.getElementById("det5").innerHTML = "<? echo $RIB; ?>";
		
		document.getElementById("det6").innerHTML = "<? echo $PIV; ?>";
		document.getElementById("det7").innerHTML = "<? echo $IMI; ?>";
		document.getElementById("det8").innerHTML = "<? echo $CNG3; ?>";
		document.getElementById("det9").innerHTML = "";
		document.getElementById('det10').innerHTML = "<? echo $DTO; ?>";
		document.getElementById('det11').innerHTML = "<? echo $TOT; ?>";
	
		SoloBlock('LisFacComDat');
		SoloBlock('BotonesLisTar');

		$('#Bloquear').fadeOut(500);
	</script>
	<?

}catch(Exception $e){////////////////////////////////////////////////////////////////////////////////////////////////// FIN DE TRY //
	
	?>
	<script>
		jAlert('ERROR Reintente la operacion solicitada.', 'Debo Retail - Global Business Solution');
	</script>
	<?

echo $e;
exit;

}

?>