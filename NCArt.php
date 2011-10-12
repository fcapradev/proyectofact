<?
require("config/cnx.php");

try {////////////////////////////////////////////////////////////////////////////////////////////////// COMIENZO TRY //

mssql_query("begin transaction",$conexion) or die("Error SQL begin trans");

//SESSION
$ZON = $_SESSION['ParEMP'];
$LUG = $_SESSION['ParLUG'];
$TER = $_SESSION['ParPOS'];

//REQUEST
$xd = $_REQUEST['xd'];


if($xd == 0){////////////////////////////////////////////////////////////////////////////////////////////////////

$CS = $_REQUEST['cs'];
$CA = $_REQUEST['ca'];
$CC = $_REQUEST['cc'];
$CP = $_REQUEST['cp'];


$_SESSION['ParOrnC'] = $_SESSION['ParOrnC'] + 1;


if($_SESSION['ParOrnC'] >= 1){
	?>
	<script>
		SoloBlock('LetTer');
		
		document.getElementById('LetTer').innerHTML = '<button class="StyBoton" onclick="EnvCuerpo();" onmouseout="MM_swapImgRestore()" onmouseover="MM_swapImage(\'LetCont\',\'\',\'botones/cont-over.png\',0)"><img src="botones/cont-up.png" name="Continuar" title="Continuar" border="0" id="LetCont"/></button>';
    </script>
	<?
}

	$_SESSION['ParSQL'] = "SELECT TIP, TCO, SUC, NCO, COD, OPE, TUR, PLA FROM PMAEFACT_T WHERE TER = ".$TER."";
	$ATURNOSH = mssql_query($_SESSION['ParSQL']) or die("Error SQL");
	rollback($ATURNOSH);
	while ($ATU_R=mssql_fetch_array($ATURNOSH)){

		$TIP = $ATU_R['TIP'];
		$TCO = $ATU_R['TCO'];
		$SUC = $ATU_R['SUC'];
		$NCO = $ATU_R['NCO'];
		$PRO = $ATU_R['COD'];
		$OPE = $ATU_R['OPE'];
		$TUR = $ATU_R['TUR'];
		$PLA = $ATU_R['PLA'];

	}
	mssql_free_result($ATURNOSH);
	
	if($CS == 0 && $CA == 0){
		
		$RUB = 1;
		$IMI = 0;
		$TIVA = 0;
		$TIO = $_REQUEST['cd'];
		$TIO = str_ireplace("~"," ",$TIO);
		
	}else{
		
		$_SESSION['ParSQL'] = "SELECT CodRub, DetArt, ImpInt, IvaCO FROM ARTICULOS WHERE CodSec = ".$CS." AND CodArt = ".$CA."";
		$ARTICULOS = mssql_query($_SESSION['ParSQL']) or die("Error SQL");
		rollback($ATURNOSH);
		while ($ART_R=mssql_fetch_array($ARTICULOS)){
	
			$RUB = $ART_R['CodRub'];
			$TIO = substr($ART_R['DetArt'],0,25);
			
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
		
	}
	
	$IMPIVA = ($CP * $TIVA) / 100;
	$IMPIVA = dec($IMPIVA,2);
	
	$_SESSION['ParSQL'] = "
	INSERT INTO PMOVFACT_T (TIP, TCO, SUC, NCO, PRO, ORD, COD, ART, RUB, TIO, LI0, CAN, PUN, IMI, IVA, PUT, LEG, CMF, TUR, PLA, LUG, ESC, TAN, CCO, TER) VALUES ( 
		'".$TIP."', '".$TCO."', ".$SUC.", ".$NCO.", ".$PRO.", ".$_SESSION['ParOrnC'].", ".$CS.", ".$CA.", ".$RUB.",
		'".$TIO."', '', ".$CC.", ".$CP.", ".$IMI.", ".$TIVA.", 0, ".$OPE.", 0, ".$TUR.", ".$PLA.", ".$LUG.", 0, 0, 0, ".$TER."
	);";
	$PMOVFACT_T = mssql_query($_SESSION['ParSQL']) or die("Error SQL");
	rollback($PMOVFACT_T);

	$CALIMI = $IMI * $CC;
	$CALIMI = dec($CALIMI,2);
	
	$TOT_TOT = ($CP * $CC) + ($IMPIVA * $CC) + ($CALIMI);

	$_SESSION['ParSQL'] = "UPDATE PMAEFACT_T SET NET = NET + ".$CP * $CC.", IMI = IMI + ".$CALIMI.", IRI = IRI + ".$IMPIVA * $CC.", TOT = TOT + ".$TOT_TOT." 
	WHERE TIP = '".$TIP."' AND TCO = '".$TCO."' AND SUC = ".$SUC." AND NCO = ".$NCO." AND COD = ".$PRO." AND TER = ".$TER;	
	$PMAEFACT_T = mssql_query($_SESSION['ParSQL']) or die("Error SQL");
	rollback($PMAEFACT_T);

}


/////////////////////////////////////////////////////////////////////////////////////////////////////////////////
//////// MODIFICACION DE UN ITEM ////////////////////////////////////////////////////////////////////////////////
/////////////////////////////////////////////////////////////////////////////////////////////////////////////////
if($xd != 0){


	$_SESSION['ParSQL'] = "SELECT TIP, TCO, SUC, NCO, COD, OPE, TUR, PLA FROM PMAEFACT_T WHERE TER = ".$TER."";
	$ATURNOSH = mssql_query($_SESSION['ParSQL']) or die("Error SQL");
	rollback($ATURNOSH);
	while ($ATU_R=mssql_fetch_array($ATURNOSH)){

		$TIP = $ATU_R['TIP'];
		$TCO = $ATU_R['TCO'];
		$SUC = $ATU_R['SUC'];
		$NCO = $ATU_R['NCO'];
		$PRO = $ATU_R['COD'];
		$OPE = $ATU_R['OPE'];
		$TUR = $ATU_R['TUR'];
		$PLA = $ATU_R['PLA'];
		
	}
	mssql_free_result($ATURNOSH);
	
	
	if(isset($_REQUEST['cn'])){

	    if($_REQUEST['cn'] == -1){
			
			$CC = $_REQUEST['cc'];
			$TIO = $_REQUEST['ccd'];
			$TIO = str_ireplace("~"," ",$TIO);
						
			$CP = $_REQUEST['cp'];
			$CP = str_ireplace(",",".",$CP);

			$RUB = 1;
			$IMI = 0;
			$TIVA = 0;

			$IMPIVA = ($CP * $TIVA) / 100;
			$IMPIVA = dec($IMPIVA,2);
			
			$_SESSION['ParSQL'] = "
			UPDATE PMOVFACT_T SET
				TIO = '".$TIO."',
				CAN = ".$CC.",
				PUN = ".$CP.",  
				IMI = ".$IMI.", 
				IVA = ".$TIVA.", 
				LEG = ".$OPE."
			WHERE TIP = '".$TIP."' AND TCO = '".$TCO."' AND SUC = ".$SUC." AND NCO = ".$NCO." AND PRO = ".$PRO." AND ORD = ".$xd."";
			$PMOVFACT_T = mssql_query($_SESSION['ParSQL']) or die("Error SQL");
			rollback($PMOVFACT_T);
			
		}else{
	
		$CP = $_REQUEST['cp'];
		$CP = str_ireplace(",",".",$CP);
		
		
		$_SESSION['ParSQL'] = "
		SELECT COD, ART, CAN FROM PMOVFACT_T WHERE TIP = '".$TIP."' AND TCO = '".$TCO."' AND SUC = ".$SUC." AND NCO = ".$NCO." AND PRO = ".$PRO." AND ORD = ".$xd."";
		$PMOVFACT_TRE = mssql_query($_SESSION['ParSQL']) or die("Error SQL");
		rollback($PMOVFACT_TRE);
		while ($PMOVRET=mssql_fetch_array($PMOVFACT_TRE)){
		
			$CS = $PMOVRET['COD'];
			$CA = $PMOVRET['ART'];
			$CC = $PMOVRET['CAN'];

		}
		mssql_free_result($PMOVFACT_TRE);
	
	
		$_SESSION['ParSQL'] = "SELECT CodRub, DetArt, ImpInt, IvaCO FROM ARTICULOS WHERE CodSec = ".$CS." AND CodArt = ".$CA."";
		$ARTICULOS = mssql_query($_SESSION['ParSQL']) or die("Error SQL");
		rollback($ATURNOSH);
		while ($ART_R=mssql_fetch_array($ARTICULOS)){
	
			$RUB = $ART_R['CodRub'];
			$TIO = substr($ART_R['DetArt'],0,25);
			
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
		
		$IMPIVA = ($CP * $TIVA) / 100;
		$IMPIVA = dec($IMPIVA,2);
		
		$_SESSION['ParSQL'] = "
		UPDATE PMOVFACT_T SET
			CAN = ".$CC.",
			PUN = ".$CP.",  
			IMI = ".$IMI.", 
			IVA = ".$TIVA.", 
			LEG = ".$OPE."
		WHERE TIP = '".$TIP."' AND TCO = '".$TCO."' AND SUC = ".$SUC." AND NCO = ".$NCO." AND PRO = ".$PRO." AND ORD = ".$xd."";
		$PMOVFACT_T = mssql_query($_SESSION['ParSQL']) or die("Error SQL");
		rollback($PMOVFACT_T);
		
		}
		
	}else{


		$CS = $_REQUEST['cs'];
		$CA = $_REQUEST['ca'];
		$CC = $_REQUEST['cc'];
		$CP = $_REQUEST['cp'];
	
	
		$_SESSION['ParSQL'] = "UPDATE PMAEFACT_T SET NET = 0, IMI = 0, IRI = 0, TOT = 0 
		WHERE TIP = '".$TIP."' AND TCO = '".$TCO."' AND SUC = ".$SUC." AND NCO = ".$NCO." AND COD = ".$PRO." AND TER = ".$TER."";
		$PMAEFACT_T = mssql_query($_SESSION['ParSQL']) or die("Error SQL");
		rollback($PMAEFACT_T);
	
		$_SESSION['ParSQL'] = "SELECT CodRub, DetArt, ImpInt, IvaCO FROM ARTICULOS WHERE CodSec = ".$CS." AND CodArt = ".$CA."";
		$ARTICULOS = mssql_query($_SESSION['ParSQL']) or die("Error SQL");
		rollback($ATURNOSH);
		while ($ART_R=mssql_fetch_array($ARTICULOS)){
	
			$RUB = $ART_R['CodRub'];
			$TIO = substr($ART_R['DetArt'],0,25);
			
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
		
		$IMPIVA = ($CP * $TIVA) / 100;
		$IMPIVA = dec($IMPIVA,2);
		
		$_SESSION['ParSQL'] = "
		UPDATE PMOVFACT_T SET
			CAN = ".$CC.",
			PUN = ".$CP.",  
			IMI = ".$IMI.", 
			IVA = ".$TIVA.", 
			LEG = ".$OPE."
		WHERE TIP = '".$TIP."' AND TCO = '".$TCO."' AND SUC = ".$SUC." AND NCO = ".$NCO." AND PRO = ".$PRO." AND ORD = ".$xd."";
		$PMOVFACT_T = mssql_query($_SESSION['ParSQL']) or die("Error SQL");
		rollback($PMOVFACT_T);	

	}
	

//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
//////////// RE CALCULAR TODOS LOS ITEMS /////////////////////////////////////////////////////////////////////////////////////////////////
//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
  $_SESSION['ParSQL'] = "SELECT COD, ART, CAN, PUN FROM PMOVFACT_T WHERE TIP = '".$TIP."' AND TCO = '".$TCO."' AND SUC = ".$SUC." AND NCO = ".$NCO." AND PRO = ".$PRO;
	$RECALPMOVFACT_T = mssql_query($_SESSION['ParSQL']) or die("Error SQL");
	rollback($RECALPMOVFACT_T);
	while ($RECALPMOV_T=mssql_fetch_array($RECALPMOVFACT_T)){
		
		
		$CS = $RECALPMOV_T['COD'];
		$CA = $RECALPMOV_T['ART'];
		$CC = $RECALPMOV_T['CAN'];
		$CP = $RECALPMOV_T['PUN'];


		//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
		$IMI = 0;
		$IVACO = 0;
		$_SESSION['ParSQL'] = "SELECT ImpInt, IvaCO FROM ARTICULOS WHERE CodSec = ".$CS." AND CodArt = ".$CA."";
		$ARTICULOS = mssql_query($_SESSION['ParSQL']) or die("Error SQL");
		rollback($ARTICULOS);
		while ($ART_R=mssql_fetch_array($ARTICULOS)){
		
			$IMI = $ART_R['ImpInt'];
			$IVACO = $ART_R['IvaCO'];
			
		}
		mssql_free_result($ARTICULOS);
		
		$TIVA = 0;
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

	
}////////////////////////////////////////////////////////////////////////////////////////////////////////////////


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