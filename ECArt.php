<?
require("config/cnx.php");
/////////////////////////////// COMPRAS


try {////////////////////////////////////////////////////////////////////////////////////////////////// COMIENZO TRY //


mssql_query("begin transaction",$conexion) or die("Error SQL begin trans");

//SESSION
$TER = $_SESSION['ParPOS'];

//REQUEST
$ccc = $_REQUEST['ccc'];

$TOT_NET = 0;
$TOT_IRI = 0;
$TOT_IMI = 0;

	$_SESSION['ParSQL'] = "SELECT TIP, TCO, SUC, NCO, COD FROM PMAEFACT_T WHERE TER = ".$TER;
	$PMAEFACT_T = mssql_query($_SESSION['ParSQL']) or die("Error SQL");
	rollback($PMAEFACT_T);
	while ($ATU_R=mssql_fetch_array($PMAEFACT_T)){

		$TIP = $ATU_R['TIP'];
		$TCO = $ATU_R['TCO'];
		$SUC = $ATU_R['SUC'];
		$NCO = $ATU_R['NCO'];
		$PRO = $ATU_R['COD'];
	
	}
	mssql_free_result($PMAEFACT_T);

	$_SESSION['ParSQL'] = "
	DELETE PMOVFACT_T WHERE TIP = '".$TIP."' AND TCO = '".$TCO."' AND SUC = ".$SUC." AND NCO = ".$NCO." AND PRO = ".$PRO." AND ORD = ".$ccc." AND TER = ".$TER;
	$PMOVFACT_T = mssql_query($_SESSION['ParSQL']) or die("Error SQL");
	rollback($PMOVFACT_T);


	////////////////////////////////////
	////////  ORDENAR ITEMS  ///////////
	////////////////////////////////////
	$_SESSION['ParSQL'] = "SELECT ORD FROM PMOVFACT_T WHERE TIP = '".$TIP."' AND TCO = '".$TCO."' AND SUC = ".$SUC." AND NCO = ".$NCO." AND PRO = ".$PRO;
	$PMOVFACT_T_TI = mssql_query($_SESSION['ParSQL']) or die("Error SQL");
	rollback($PMOVFACT_T_TI);
	$c = 0;
	while ($TMOV_TI = mssql_fetch_array($PMOVFACT_T_TI)){
		
		$ORD = $TMOV_TI['ORD'];
		$c = $c + 1;
		
		$_SESSION['ParSQL'] = "UPDATE PMOVFACT_T SET ORD = ".$c." 
		WHERE ORD = ".$ORD." AND TIP = '".$TIP."' AND TCO = '".$TCO."' AND SUC = ".$SUC." AND NCO = ".$NCO." AND PRO = ".$PRO." AND TER = ".$TER;
		$PMOVFACT_UP = mssql_query($_SESSION['ParSQL']) or die("Error SQL");
		rollback($PMOVFACT_UP);

	}
	mssql_free_result($PMOVFACT_T_TI);
	////////////////////////////////////
	////////////////////////////////////
	////////////////////////////////////


	$_SESSION['ParSQL'] = "
	SELECT COD, ART, CAN, PUN FROM PMOVFACT_T WHERE TIP = '".$TIP."' AND TCO = '".$TCO."' AND SUC = ".$SUC." AND NCO = ".$NCO." AND PRO = ".$PRO." AND TER = ".$TER;
	$RECALPMOVFACT_T = mssql_query($_SESSION['ParSQL']) or die("Error SQL");
	rollback($RECALPMOVFACT_T);
	$c = 0;
	while ($RECALPMOV_T=mssql_fetch_array($RECALPMOVFACT_T)){
		
		$c = $c + 1;
		
		$CS = $RECALPMOV_T['COD'];
		$CA = $RECALPMOV_T['ART'];
		$CC = $RECALPMOV_T['CAN'];
		$CP = $RECALPMOV_T['PUN'];

		//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
		$_SESSION['ParSQL'] = "SELECT ImpInt, IvaCO FROM ARTICULOS WHERE CodSec = ".$CS." AND CodArt = ".$CA."";
		$ARTICULOS = mssql_query($_SESSION['ParSQL']) or die("Error SQL");
		rollback($ARTICULOS);
		while ($ART_R=mssql_fetch_array($ARTICULOS)){
		
			$IMI = $ART_R['ImpInt'];
			$IVACO = $ART_R['IvaCO'];
			
		}
		mssql_free_result($ARTICULOS);
		
		
		$_SESSION['ParSQL'] = "SELECT POR FROM ACODIVA WHERE ID = ".$IVACO."";
		$ACODIVA = mssql_query($_SESSION['ParSQL']) or die("Error SQL");
		rollback($ACODIVA);		
		while ($ACO=mssql_fetch_array($ACODIVA)){
			$TIVA = $ACO['POR'];
		}
		mssql_free_result($ACODIVA);
		
		
		$IMPIVA = ($CP * $TIVA) / 100;
		$IMPIVA = dec($IMPIVA,2);
		
		$CALIMI = $IMI * $CC;
		$CALIMI = dec($CALIMI,2);
		
		$TOT_TOT = ($CP * $CC) + ($IMPIVA * $CC) + ($CALIMI);
	
		$_SESSION['ParSQL'] = "UPDATE PMAEFACT_T SET NET = NET + ".$CP * $CC.", IMI = IMI + ".$CALIMI.", IRI = IRI + ".$IMPIVA * $CC.", TOT = TOT + ".$TOT_TOT." 
		WHERE TIP = '".$TIP."' AND TCO = '".$TCO."' AND SUC = ".$SUC." AND NCO = ".$NCO." AND COD = ".$PRO." AND TER = ".$TER."";
		$PMAEFACT_T = mssql_query($_SESSION['ParSQL']) or die("Error SQL");
		rollback($PMAEFACT_T);
		//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////

	} 
	mssql_free_result($RECALPMOVFACT_T);


mssql_query("commit transaction") or die("Error SQL commit");


	?>
	<script>	
		document.getElementById('CuerpoListaCI').innerHTML = '';
		
		$("#CuerpoListaCI").load("TFCompraI.php?tar=3&tip=<? echo $TIP; ?>&tco=<? echo $TCO; ?>&suc=<? echo $SUC;?>&nco=<? echo $NCO; ?>&cod=<? echo $PRO; ?>");
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