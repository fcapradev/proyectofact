<?
require("config/cnx.php");
/////////////////////////////// COMPRAS


try {////////////////////////////////////////////////////////////////////////////////////////////////// COMIENZO TRY //


mssql_query("begin transaction",$conexion) or die("Error SQL begin trans");

//SESSION
$TER = $_SESSION['ParPOS'];

//POST
$PDat1 = $_POST['PDat1'];
$PDat2 = $_POST['PDat2'];
$PDat3 = $_POST['PDat3'];
$PDat4 = $_POST['PDat4'];
$PDat5 = $_POST['PDat5'];
$PDat6 = $_POST['PDat6'];
$PDat7 = $_POST['PDat7'];
$PDat8 = $_POST['PDat8'];
$PDat9 = $_POST['PDat9'];
$PDat10 = $_POST['PDat10'];
$PDat11 = $_POST['PDat11'];
$PDat12 = $_POST['PDat12'];
	$PDat12n2 = $_POST['PDat12-2'];

$PDat13 = $_POST['PDat13'];
$PDat14 = $_POST['PDat14'];

if($PDat12 == 0){
	$PDat12n2 = 0;
}

	$_SESSION['ParSQL'] = "SELECT TIP, TCO, SUC, NCO, COD FROM PMAEFACT_T WHERE TER = ".$TER."";
	$PMAEFACT_T = mssql_query($_SESSION['ParSQL']) or die("Error SQL");
	rollback($PMAEFACT_T);
	while ($PMAE_R = mssql_fetch_array($PMAEFACT_T)){
			
		$TIP = $PMAE_R['TIP'];
		$TCO = $PMAE_R['TCO'];
		$SUC = $PMAE_R['SUC'];
		$NCO = $PMAE_R['NCO'];
		$COD = $PMAE_R['COD'];
		
	}

	////////////////////////////////////
	////////  ORDENAR ITEMS  ///////////
	////////////////////////////////////
	$_SESSION['ParSQL'] = "SELECT ORD FROM PMOVFACT_T WHERE TIP = '".$TIP."' AND TCO = '".$TCO."' AND SUC = ".$SUC." AND NCO = ".$NCO." AND PRO = ".$COD;
	$PMOVFACT_T_TI = mssql_query($_SESSION['ParSQL']) or die("Error SQL");
	rollback($PMOVFACT_T_TI);
	$c = 0;
	while ($TMOV_TI = mssql_fetch_array($PMOVFACT_T_TI)){
		
		$ORD = $TMOV_TI['ORD'];
		$c = $c + 1;
		
		$_SESSION['ParSQL'] = "UPDATE PMOVFACT_T SET ORD = ".$c." 
		WHERE ORD = ".$ORD." AND TIP = '".$TIP."' AND TCO = '".$TCO."' AND SUC = ".$SUC." AND NCO = ".$NCO." AND PRO = ".$COD;;
		$PMOVFACT_UP = mssql_query($_SESSION['ParSQL']) or die("Error SQL");
		rollback($PMOVFACT_UP);

	}
	mssql_free_result($PMOVFACT_T_TI);
	////////////////////////////////////
	////////////////////////////////////
	////////////////////////////////////

	if(mssql_num_rows($PMAEFACT_T)==0){
		?>
		<script>
			jAlert('Error en la grabación de factura reintente la operación.', 'Debo Retail - Global Business Solution');
			controlarcadainputcom("EDat3");
		</script>
		<?
		exit;
	}


	if($TIP == 'R' && $TCO == 'RE'){
		$PDat1 = $PDat14;
	}

	$_SESSION['ParSQL'] = "SELECT COD FROM PMOVFACT WHERE COD = 0";
	$PMOVFACT_DT = mssql_query($_SESSION['ParSQL']) or die("Error SQL");
	rollback($PMOVFACT_DT);
	
	if(mssql_num_rows($PMOVFACT_DT)==0){
		$XDET = "P";
	}else{
		$XDET = "D";
	}


	////////////////////////////////////////////////
	////	PARA HACER UNA FACTURA CON REMITO	////
	////////////////////////////////////////////////
	$ban = $_POST['FacRec'];

	if($ban == 1 ){
		
		$REMITOS = $_POST['todosremitos'];
		
		$REMITOS = explode(",",$REMITOS);
		$c = 0;
		
		for($j=0;$j<count($REMITOS);$j++){
		
			$fac = explode("-",$REMITOS[$j]);
		
			$SUC_R = $fac[2];
			$NCO_R = $fac[3];

		//	UPDATE AL REMITO CON EL NCO DE LA FACTURA
		$_SESSION['ParSQL'] = "UPDATE PMAEFACT SET REC = ".$NCO." WHERE TIP = 'R' AND TCO = 'RE' AND SUC = ".$SUC_R." AND NCO = ".$NCO_R;
		$PMAEFACT_TT = mssql_query($_SESSION['ParSQL']) or die("Error SQL");
		rollback($PMAEFACT_TT);

		}

		//	BUSCO EL NCO DEL REMITO
		$_SESSION['ParSQL'] = "SELECT NCO FROM PMAEFACT WHERE TIP = 'R' AND TCO = 'RE' AND SUC = ".$SUC_R." AND NCO = ".$NCO_R;
		$PMAEFACT_T = mssql_query($_SESSION['ParSQL']) or die("Error SQL");
		rollback($PMAEFACT_T);
		while ($PMAE_R = mssql_fetch_array($PMAEFACT_T)){
				
			$NCO_REMITO = $PMAE_R['NCO'];
			
		}
	
		//	UPDATE A LA FACTURA CON EL NCO DEL REMITO
		$_SESSION['ParSQL'] = "UPDATE PMAEFACT_T SET REM = ".$NCO_REMITO." WHERE TIP = '".$TIP."' AND TCO = '".$TCO."' AND SUC = ".$SUC." AND NCO = ".$NCO." AND TER = ".$TER."";
		$PMAEFACT_TT = mssql_query($_SESSION['ParSQL']) or die("Error SQL");
		rollback($PMAEFACT_TT);
	
	}else{
		
		$_SESSION['ParSQL'] = "UPDATE PMAEFACT_T SET NET = ".$PDat1.", NEE = ".$PDat2.", RGA = ".$PDat3.", IRI = ".$PDat4.", IRS = ".$PDat5.", RIB = ".$PDat6.", PIV = ".$PDat7.", RIV = ".$PDat8.", IMI = ".$PDat9.", CNG = ".$PDat10.", CNG2 = ".$PDat11.", DTO = ".$PDat12.", PDT = ".$PDat12n2.", PER = ".$PDat13.", TOT = ".$PDat14.", DETPRO = '".$XDET."' WHERE TIP = '".$TIP."' AND TCO = '".$TCO."' AND SUC = ".$SUC." AND NCO = ".$NCO." AND COD = ".$COD." AND TER = ".$TER."";
		$PMAEFACT_TT = mssql_query($_SESSION['ParSQL']) or die("Error SQL");
		rollback($PMAEFACT_TT);
	
	}

	if(mssql_num_rows($PMAEFACT_T)==1){

		$_SESSION['ParSQL'] = "INSERT INTO PMAEFACT SELECT TIP, TCO, SUC, NCO, COD, FEC, NOM, TIV, CUI, FPA, TCA, DTO, PDT, NET, NEE, IRI, IRS, IMI, RGA, RIB, PIV, CNG, TOT, ZON, FEV, OCP, OPE, REC, FEP, NPE, CPA, ENV, REM, PRO, ANU, TUR, PLA, LUG, ATO, CCO, IMA, CCA1, CCA2, CCA3, CCA4, CCA5, CCA6, CCA7, CCA8, CCA0, OBS, RIV, FECCAI, CAI, CHO, CTR, PER, CCA9, FECVEN, CNG2, E_HD, C_HD, E_OHO, E_HD2, C_HD2, CG, PFH, DETPRO FROM PMAEFACT_T WHERE TIP = '".$TIP."' AND TCO = '".$TCO."' AND SUC = ".$SUC." AND NCO = ".$NCO." AND COD = ".$COD." AND TER = ".$TER;
		$PMAEFACT = mssql_query($_SESSION['ParSQL']) or die("Error SQL");
		rollback($PMAEFACT);

		$_SESSION['ParSQL'] = "INSERT INTO PMOVFACT SELECT TIP, TCO, SUC, NCO, PRO, ORD, COD, ART, RUB, TIO, LI0, CAN, PUN, IMI, IVA, PUT, LEG, CMF, TUR, PLA, LUG, ESC, [TAN], CCO, E_HD, C_HD, DTO, E_OHO, E_HD2, C_HD2 FROM PMOVFACT_T WHERE TIP = '".$TIP."' AND TCO = '".$TCO."' AND SUC = ".$SUC." AND NCO = ".$NCO." AND PRO = ".$COD." AND TER = ".$TER;
		$PMOVFACT = mssql_query($_SESSION['ParSQL']) or die("Error SQL");
		rollback($PMOVFACT);
		
		$_SESSION['ParSQL'] = "DELETE PMAEFACT_T WHERE TIP = '".$TIP."' AND TCO = '".$TCO."' AND SUC = ".$SUC." AND NCO = ".$NCO." AND COD = ".$COD;
		$DEL_PMAEFACT = mssql_query($_SESSION['ParSQL']) or die("Error SQL");
		rollback($DEL_PMAEFACT);
	
		$_SESSION['ParSQL'] = "DELETE PMOVFACT_T WHERE TIP = '".$TIP."' AND TCO = '".$TCO."' AND SUC = ".$SUC." AND NCO = ".$NCO." AND PRO = ".$COD;
		$DEL_PMOVFACT = mssql_query($_SESSION['ParSQL']) or die("Error SQL");
		rollback($DEL_PMOVFACT);

	}


mssql_query("commit transaction") or die("Error SQL commit");

$_SESSION['ParOrnC'] = 0;
	?>
	<script>
	
		document.getElementById('FacRec').value = 0;
		document.getElementById("Modifica").value = 0;
		document.getElementById("HabFunModCom").value = 0;
	
		ComenzarCompras(1);
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