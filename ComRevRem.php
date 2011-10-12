<?
require("config/cnx.php");


try {////////////////////////////////////////////////////////////////////////////////////////////////// COMIENZO TRY //


mssql_query("begin transaction",$conexion) or die("Error SQL begin trans");


//SESSION
$ZON = $_SESSION['ParEMP'];
$LUG = $_SESSION['ParLUG'];
$TER = $_SESSION['ParPOS'];

//REQUEST
if(isset($_REQUEST['tot'])){
	
	$tot = $_REQUEST['tot'];
	
}else{

	$_SESSION['ParSQL'] = "DELETE PMOVFACT_T WHERE TER = ".$TER;
	$DEL_PMOVFACT_T = mssql_query($_SESSION['ParSQL']) or die("Error SQL");
	rollback($DEL_PMOVFACT_T);
	
	$_SESSION['ParSQL'] = "DELETE RFACCOM WHERE POS = ".$TER;
	$DEL_PMOVFACT_T = mssql_query($_SESSION['ParSQL']) or die("Error SQL");
	rollback($DEL_PMOVFACT_T);
	
	if(isset($_REQUEST['rev'])){
	
	}else{	
		?>
		<script>
			SoloNone("LetEnt");
			$('#Bloquear').fadeOut(500);
		</script>
		<?
	}
	exit;
	
}


$_SESSION['ParSQL'] = "DELETE PMOVFACT_T WHERE TER = ".$TER;
$DEL_PMOVFACT_T = mssql_query($_SESSION['ParSQL']) or die("Error SQL");
rollback($DEL_PMOVFACT_T);

$_SESSION['ParSQL'] = "DELETE RFACCOM WHERE POS = ".$TER;
$DEL_PMOVFACT_T = mssql_query($_SESSION['ParSQL']) or die("Error SQL");
rollback($DEL_PMOVFACT_T);

$remitos = $tot;

$tot = explode(",",$tot);
$c = 0;


for($j=0;$j<count($tot);$j++){


	$fac = explode("-",$tot[$j]);

	$TIP_R = $fac[0];
	$TCO_R = $fac[1];
	$SUC_R = format($fac[2],4,'0',STR_PAD_LEFT);
	$NCO_R = format($fac[3],8,'0',STR_PAD_LEFT);

	$_SESSION['ParSQL'] = "
	SELECT COD, ART, PRO, CAN, TIO, PUN, PLA FROM PMOVFACT WHERE TIP = '".$TIP_R."' AND TCO = '".$TCO_R."' AND SUC = ".$SUC_R." AND NCO = ".$NCO_R;
	$PMOVFACT = mssql_query($_SESSION['ParSQL']) or die("Error SQL");
	rollback($PMOVFACT);
	while ($PMOV_R = mssql_fetch_array($PMOVFACT)){


		$COD = "".format($PMOV_R['COD'],2,'0',STR_PAD_LEFT)."-".format($PMOV_R['ART'],4,'0',STR_PAD_LEFT)."";
		$PRO = $PMOV_R['PRO'];
		$CAN = $PMOV_R['CAN'];
		$DET = $PMOV_R['TIO'];
		$PUN = $PMOV_R['PUN'];
		$IMP = $PUN * $CAN;
				

		$_SESSION['ParSQL'] = "SELECT POS FROM RFACCOM WHERE POS = ".$TER." AND COD = '".$COD."'";
		$RFACCOM = mssql_query($_SESSION['ParSQL']) or die("Error SQL");
		rollback($RFACCOM);
		if(mssql_num_rows($RFACCOM)==0){
			
			$c++;

			$_SESSION['ParSQL'] = "INSERT INTO RFACCOM VALUES (".$TER.", '".$COD."', ".$CAN.", '".$DET."', ".$PUN.", ".$IMP.", ".$c.")";
			$INSERT_RFACCOM = mssql_query($_SESSION['ParSQL']) or die("Error SQL");
			rollback($INSERT_RFACCOM);

		}else{

			$_SESSION['ParSQL'] = "UPDATE RFACCOM SET CAN = CAN + ".$CAN.", IMP = IMP + ".$IMP." WHERE POS = ".$TER." AND COD = '".$COD."'";
			$UPDATE_RFACCOM = mssql_query($_SESSION['ParSQL']) or die("Error SQL");
			rollback($UPDATE_RFACCOM);
			
		}
		mssql_free_result($RFACCOM);


	}


}


mssql_query("commit transaction") or die("Error SQL commit");

	?>
	<script>
		
		document.getElementById('Tip_R').value = '<? echo $TIP_R; ?>';
		document.getElementById('Tco_R').value = '<? echo $TCO_R; ?>';
		document.getElementById('Suc_R').value = '<? echo $SUC_R; ?>';
		document.getElementById('Nco_R').value = '<? echo $NCO_R; ?>';
		document.getElementById('FacRec').value = 1;
		document.getElementById('todosremitos').value = '<? echo $remitos; ?>';
		
		
		SoloNone("BusquedaRemito");
		SoloBlock("ComBotEncDiv, Encabezado, EncabezadoDat, LetEnt");
	
		document.getElementById('EDat15').value = "Con Remitos";
		
		$("#EncDat15").css("border-color", "transparent");
		$("#EncDat16").css("border-color", "#F90");	
		
		controlarcadainputcom("EDat16");	

		document.getElementById("DondeE").value = "EDat16";
		document.getElementById("CantiE").value = "10";
		document.getElementById("QuePoE").value = "1";		

		EnvAyuda("Ingrese empresa del comprobante.");
	
		document.getElementById('LetEnt').innerHTML = '<button onclick="Empresa();" class="StyBoton" onmouseout="MM_swapImgRestore()" onmouseover="MM_swapImage(\'LetEntFac\',\'\',\'botones/ent-over.png\',0)"><img src="botones/ent-up.png" name="Enter" title="Enter" border="0" id="LetEntFac"/></button>';
	
		document.getElementById('NumVol').innerHTML = '<button onclick="VolRemitos();" class="StyBoton" onmouseout="MM_swapImgRestore()" onmouseover="MM_swapImage(\'LetVolChe\',\'\',\'botones/vol-over.png\',0)"><img src="botones/vol-up.png" name="Volver" title="Volver" border="0" id="LetVolChe"/></button>';
	
		$('#Bloquear').fadeOut(500);
	</script>
	<?

}catch(Exception $e){////////////////////////////////////////////////////////////////////////////////////////////////// FIN DE TRY //
	
	?>
	<script>
		jAlert('ERROR Reintente la operacion solicitada.', 'Debo Retail - Global Business Solution');
	</script>
	<?
exit;

}

?>