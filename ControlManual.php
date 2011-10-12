<?
require("config/cnx.php");


try {////////////////////////////////////////////////////////////////////////////////////////////////// COMIENZO TRY //


mssql_query("begin transaction",$conexion) or die("Error SQL begin trans");


$SUC = $_REQUEST['suc'];

if($SUC == 777777){
	$_SESSION['ParSQL'] = "SELECT PVE FROM ACONF_PVEMANU WHERE POS = ".$_SESSION['ParPOS']."";
	$ACONF_PVEMANU = mssql_query($_SESSION['ParSQL']) or die("Error SQL");
	rollback($ACONF_PVEMANU);
	while ($ACONF_PVEMANU_REG=mssql_fetch_array($ACONF_PVEMANU)){
		$SUC = $ACONF_PVEMANU_REG['PVE'];
	}
}


$_SESSION['ParSQL'] = "SELECT TIP, TCO FROM TMAEFACT_T WHERE TER = ".$_SESSION['ParPOSMa'];
$TMAEFACT_T = mssql_query($_SESSION['ParSQL']) or die("Error SQL");
rollback($TMAEFACT_T);
while ($TMAEFACT_T_REG=mssql_fetch_array($TMAEFACT_T)){
	
	$TIP = $TMAEFACT_T_REG['TIP'];
	$TCO = $TMAEFACT_T_REG['TCO'];
	
}
mssql_free_result($TMAEFACT_T);

$_SESSION['ParSQL'] = "SELECT PVE FROM ACONF_PVEMANU WHERE POS = ".$_SESSION['ParPOS']." AND PVE = ".$SUC;
$ACONF_PVEMANU = mssql_query($_SESSION['ParSQL']) or die("Error SQL");
rollback($ACONF_PVEMANU);
while ($ACONF_PVEMANU_REG=mssql_fetch_array($ACONF_PVEMANU)){
	
	$PVE = $ACONF_PVEMANU_REG['PVE'];
	$control = $_SESSION['ParPV'];
	
	if($PVE == (int)$control){
		?>
		<script>
			document.getElementById("EDat7Ma1").value = "";
			jAlert('El punto de venta es igual al actual.', 'Debo Retail - Global Business Solution');	
		</script>
		<?
		exit;
	}
	
}
if(mssql_num_rows($ACONF_PVEMANU) == 0){
	?>
	<script>
		document.getElementById("EDat7Ma1").value = "";
		$("#EDat7Ma1").focus();
		jAlert('Punto de venta manual mal cofigurado.', 'Debo Retail - Global Business Solution');	
	</script>
	<?
	exit;
}
mssql_free_result($ACONF_PVEMANU);

	
	
$_SESSION['ParSQL'] = "SELECT MAX(NCO) + 1 AS NCO FROM AMAEFACT WHERE TIP = '".$TIP."' AND TCO = '".$TCO."' AND SUC = ".$SUC;
$AMAEFACT = mssql_query($_SESSION['ParSQL']) or die("Error SQL");
rollback($AMAEFACT);
while ($AMAEFACTREG=mssql_fetch_array($AMAEFACT)){
	if($AMAEFACTREG['NCO'] == NULL){
		$NCO = 1;
	}else{
		$NCO = $AMAEFACTREG['NCO'];
	}
}

$SUC_N = format($SUC,4,'0',STR_PAD_LEFT);

mssql_query("commit transaction") or die("Error SQL commit");	

	?>
	<script>
	
		document.getElementById('EDat7Ma1').value = "<? echo $SUC_N; ?>";
		
		document.getElementById('EDat7Ma4').value = "<? echo $NCO; ?>";
	
		EnvAyuda('Ingrese número del comprobante.');
		
		$("#EstFormComprobanteDiv").css("border-color", "transparent");
		$("#EDat7Ma4Div").css("border-color", "#F90");
		
		document.getElementById("DondeE").value = "EDat7Ma4";
		document.getElementById("CantiE").value = "8";
		document.getElementById("QuePoE").value = "1";
						
		document.getElementById('LetEnt').innerHTML = '<button class="StyBoton" onclick="MaNumeroNco();" onmouseout="MM_swapImgRestore()" onmouseover="MM_swapImage(\'LetEntFac\',\'\',\'botones/ent-over.png\',0)"><img src="botones/ent-up.png" name="Enter" title="Enter" border="0" id="LetEntFac"/></button>';
			
		document.getElementById('NumVol').innerHTML = '<button class="StyBoton" onclick="MaVolNumNco();" onmouseout="MM_swapImgRestore()" onmouseover="MM_swapImage(\'LeVolCom\',\'\',\'botones/vol-over.png\',0)"><img src="botones/vol-up.png" name="Volver" title="Volver" border="0" id="LeVolCom"/></button>';
		
		document.getElementById('LetTer').innerHTML = '<button class="StyBoton" onclick="MaVolNumNco();" onmouseout="MM_swapImgRestore()" onmouseover="MM_swapImage(\'LeVolCom2\',\'\',\'botones/vol-over.png\',0)"><img src="botones/vol-up.png" name="Volver" title="Volver" border="0" id="LeVolCom2"/></button>';
		
//		Macancvuel();
		
		$("#EDat7Ma4").focus();
		
	</script>
	<?
	
		
}catch(Exception $e){////////////////////////////////////////////////////////////////////////////////////////////////// FIN DE TRY //
	
	?>
	<script>
		jAlert('ERROR Reintente la operacion solicitada.', 'Aukon - Global Business Solution');
	</script>
	<?
exit;

}
?>