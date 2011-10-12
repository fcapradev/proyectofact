<?
require("config/cnx.php");
/////////////////////////////// COMPRAS


try {////////////////////////////////////////////////////////////////////////////////////////////////// COMIENZO TRY //


mssql_query("begin transaction",$conexion) or die("Error SQL begin trans");
//MODIFICAR
$Mod = $_POST['Modifica'];

//SESSION
$ZON = $_SESSION['ParEMP'];
$LUG = $_SESSION['ParLUG'];
$TER = $_SESSION['ParPOS'];

//POST
$EDat1 = $_POST['EDat1'];
$EDat2 = $_POST['EDat2'];
$EDat3 = $_POST['EDat3'];
$EDat4 = $_POST['EDat4'];
$EDat5 = $_POST['EDat5'];
$EDat6 = $_POST['EDat6'];
	$TIP = $_POST['EDat7_2'];
	$TCO = $_POST['EDat7_3'];
	$SUC = $_POST['EDat7_1'];
	$NCO = $_POST['EDat7_4'];

$EDat8 = $_POST['EDat8'];
$EDat9 = $_POST['EDat9'];
$EDat10 = $_POST['EDat10'];
	$EDat10Val = $_POST['EDat10Val'];

$EDat11 = $_POST['EDat11'];
$EDat12 = $_POST['EDat12'];
$EDat13 = $_POST['EDat13'];
$EDat14 = $_POST['EDat14'];
$EDat15 = $_POST['EDat15'];
$EDat16 = $_POST['EDat16'];
$EDat17 = $_POST['EDat17'];
$EDat18 = $_POST['EDat18'];

	$_SESSION['ParSQL'] = "
	SELECT C.NplVen AS PLA, D.FAP AS FAP, A.MTN, A.DES, A.INI, A.FIN FROM ATURNOSH AS A 
	INNER JOIN APARPOS AS B ON B.ID = '".$_SESSION['ParPOS']."'
	INNER JOIN VENDEDORES AS C ON C.CodVen = B.OPE
	INNER JOIN ATURNOSO AS D ON D.PLA = C.NplVen
	WHERE A.MTN = D.MTN";
	$ATURNOSH = mssql_query($_SESSION['ParSQL']) or die("Error SQL");
	rollback($ATURNOSH);		
	while ($ATUR=mssql_fetch_array($ATURNOSH)){

		$PLA = $ATUR['PLA'];
		$FAP = $ATUR['FAP'];
		$MTN = $ATUR['MTN'];
		$DES = $ATUR['DES'];
		$INI = $ATUR['INI'];
		$FIN = $ATUR['FIN'];
		
	}
	mssql_free_result($ATURNOSH);
	$TUR = $MTN;

	
	$FEC = date("Ymd H:i");
	
	$fecha_12 = explode("/", $EDat12);
	$EDat12 = $fecha_12[2].$fecha_12[1].$fecha_12[0];
	
	$date = new DateTime($EDat12);
	$EDat12 = $date->format('Ymd H:i');
	
	$fecha_13 = explode("/", $EDat13);
	$EDat13 = $fecha_13[2].$fecha_13[1].$fecha_13[0];
	
	$date = new DateTime($EDat13);
	$EDat13 = $date->format('Ymd H:i');

				
	$_SESSION['ParSQL'] = "SELECT IVA, CUIT FROM PROVEED WHERE COD = ".$EDat3."";
	$PROVEED = mssql_query($_SESSION['ParSQL']) or die("Error SQL");
	rollback($PROVEED);
	while ($PRO_REG=mssql_fetch_array($PROVEED)){
		
		$TIV = $PRO_REG['IVA'];
		$CUIT = $PRO_REG['CUIT'];
	
	}

//////////////////////////////////////////////////////
//	INSERTO O MODIFICO EL ENCABEZADO DE LA FACTURA	//
//////////////////////////////////////////////////////

if($Mod == 1){
	
	$_SESSION['ParSQL'] = "
	UPDATE PMAEFACT_T SET COD = ".$EDat3.", FEC = '".$FEC."', NOM = '".$EDat4."', TIV = ".$TIV.", CUI = '".$CUIT."', FPA = ".$EDat5.", PDT = ".$EDat14.", ZON = ".$ZON.", FEV = '".$EDat13."', OPE = ".$EDat1.", FEP = '".$EDat13."', NPE = ".$EDat18.", TUR = ".$TUR.", PLA = ".$PLA.", LUG = ".$LUG.", IMA = ".$EDat10Val.", FECCAI = '".$EDat12."', CAI = '".$EDat11."', FECVEN = '".$EDat13."'	WHERE TIP = '".$TIP."' AND TCO = '".$TCO."' AND SUC = ".$SUC." AND NCO = ".$NCO." AND TER = ".$TER."";
	$PMAEFACT_T = mssql_query($_SESSION['ParSQL']) or die("Error SQL");
	rollback($PMAEFACT_T);

}else{
	
	$_SESSION['ParSQL'] = "
	INSERT INTO PMAEFACT_T (
	TIP, TCO, SUC, NCO, COD, FEC, NOM, TIV, CUI, FPA, TCA, DTO, PDT, NET, NEE, IRI, IRS, IMI, RGA, RIB, PIV, CNG, TOT, 
	ZON, FEV, OCP, OPE, REC, FEP, NPE, CPA, ENV, REM, PRO, ANU, 
	TUR, PLA, LUG, ATO, CCO, IMA, 
	CCA1, CCA2, CCA3, CCA4, CCA5, CCA6, CCA7, CCA8, CCA0, OBS, RIV, FECCAI, CAI, 	
	CHO, CTR, PER, CCA9, FECVEN, CNG2, E_HD, C_HD, E_OHO, E_HD2, C_HD2, CG, PFH, DETPRO, TER
	) VALUES ( 
	'".$TIP."', '".$TCO."ds', ".$SUC.", ".$NCO.", ".$EDat3.", '".$FEC."', '".$EDat4."', ".$TIV.", '".$CUIT."', ".$EDat5.", 1, 0, ".$EDat14.", 0, 0, 0, 0, 0, 0, 0, 0, 0, 0,".$ZON.", '".$EDat13."', 0, ".$EDat1.", 0, '".$EDat13."', ".$EDat18.", 0, 0, 0, 'N', '', ".$TUR.", ".$PLA.", ".$LUG.", 0, 0, ".$EDat10Val.",	0, 0, 0, 0, 0, 0, 0, 0, 0, '', 0, '".$EDat12."', '".$EDat11."', 1, '', 0, 0, '".$EDat13."', 0, '', '', '', '', '', 'C', 'N', 'P', ".$TER."
	);
	";
	$PMAEFACT_T = mssql_query($_SESSION['ParSQL']) or die("Error SQL");
	rollback($PMAEFACT_T);

}
	//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////	//////// PASAR TODA LA RFACCOM A LA PMOVFACT_T /////////////////////////////////////////////////////////////////////////////////////////
//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
	
$_SESSION['ParSQL'] = "SELECT COD, CAN, DET, PRE FROM RFACCOM WHERE POS = ".$TER."";
$RFACCOM = mssql_query($_SESSION['ParSQL']) or die("Error SQL");
rollback($RFACCOM);

$BAN = 0;

if(mssql_num_rows($RFACCOM)!=0){

	if($EDat15 == "Con Remitos"){
		
		$BAN = 1;
		
		while ($RFA_R = mssql_fetch_array($RFACCOM)){
		
			$COD = $RFA_R['COD'];
				$COD = explode("-",$COD);
					$CS = $COD[0];
					$CA = $COD[1];
			
			$TIO = $RFA_R['DET'];
			$CC = $RFA_R['CAN'];
			$CP = $RFA_R['PRE'];
			
			
//	FRANCO --> CUANDO MODIFICA, NO DEBE CORRERME EL ORDEN DE LOS ITEMS
	if($Mod == 1){
		
		$_SESSION['ParOrnC'] = $_SESSION['ParOrnC'];
		
	}else{
	
		$_SESSION['ParOrnC'] = $_SESSION['ParOrnC'] + 1;
	
	}


			$_SESSION['ParSQL'] = "SELECT CodRub, ImpInt, IvaCO FROM ARTICULOS WHERE CodSec = ".$CS." AND CodArt = ".$CA."";
			$ARTICULOS = mssql_query($_SESSION['ParSQL']) or die("Error SQL");
			rollback($ATURNOSH);
			while ($ART_R=mssql_fetch_array($ARTICULOS)){
		
				$RUB = $ART_R['CodRub'];
			
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
			
			
			if($Mod == 0){

				$_SESSION['ParSQL'] = "
				INSERT INTO PMOVFACT_T (TIP, TCO, SUC, NCO, PRO, ORD, COD, ART, RUB, TIO, LI0, CAN, PUN, IMI, IVA, PUT, LEG, CMF, TUR, PLA, LUG, ESC, TAN, CCO, TER) 
				VALUES ('".$TIP."', '".$TCO."', ".$SUC.", ".$NCO.", ".$EDat3.", ".$_SESSION['ParOrnC'].", ".$CS.", ".$CA.", ".$RUB.",
						'".$TIO."', '', ".$CC.", 0, ".$IMI.", ".$TIVA.", 0, ".$EDat1.", 0, ".$TUR.", ".$PLA.", ".$LUG.", 0, 0, 0, ".$TER.");";
				echo $_SESSION['ParSQL'];
				$PMOVFACT_T = mssql_query($_SESSION['ParSQL']) or die("Error SQL");
				rollback($PMOVFACT_T);
			
				$CALIMI = $IMI * $CC;
				$CALIMI = dec($CALIMI,2);
				
				$TOT_TOT = ($CP * $CC) + ($IMPIVA * $CC) + ($CALIMI);
			
				$_SESSION['ParSQL'] = "UPDATE PMAEFACT_T SET NET = NET + ".$CP * $CC.", IMI = IMI + ".$CALIMI.", IRI = IRI + ".$IMPIVA * $CC.", TOT = TOT + ".$TOT_TOT." 
				WHERE TIP = '".$TIP."' AND TCO = '".$TCO."' AND SUC = ".$SUC." AND NCO = ".$NCO." AND COD = ".$EDat3." AND TER = ".$TER."";
				$PMAEFACT_T = mssql_query($_SESSION['ParSQL']) or die("Error SQL");
				rollback($PMAEFACT_T);
				
			}
		}
		
	}
	
}



mssql_query("commit transaction") or die("Error SQL commit");

	if($BAN == 1){

	?>
	<script>
	
		$("#CuerpoListaCI").load("TFCompraI.php?tar=2&tip=<? echo $TIP; ?>&tco=<? echo $TCO; ?>&suc=<? echo $SUC;?>&nco=<? echo $NCO; ?>&cod=<? echo $EDat3; ?>");
		
	// BOTON UNID. VTA Y MED IGUALES
		$('#BotXUV').attr({
			src: 'Compras/botunidadventa-up.png',
		});
		
		$('#BotXUM').attr({
			src: 'Compras/botunidadmedida-up.png',
		});
	</script>
	<?
	
	}else{
	?>
	<script>
		var a = document.getElementById("HabFunModCom").value;

		if(document.getElementById("HabFunModCom").value == 1){
		
			SoloBlock("ComBotPieDiv");

		}
	
		SoloNone('LetTer');
	
		document.getElementById('LetTer').innerHTML = '';
		
		SoloNone('Encabezado, EncabezadoDat, ComprasDfon, CueDat2, CueDat3, CueDat4, CueDat4-2, CueDat5');
		
		SoloBlock('EncabezadoLat, EncabezadoDLat, ComBotBusDiv, ComBotEncDiv, ComBotCueDiv, Cuerpo, CuerpoDat');
				
		document.getElementById("HabFunModCom").value = 0;
		
		SoloNone("CueDat2, CueDat3, CueDat5, CuerpoProdu");
		SoloBlock("CueDat1, ComBotEncDiv, ComBotCueDiv, LetEnt, LetTer, CuerpoProdu3, CuerpoProduTxt");
		
		document.getElementById("CDat1").value = "";
		document.getElementById("CDat2").value = "";
		document.getElementById("CDat3").value = "";
		document.getElementById("CDat5").value = "";
		
		$("#CueDat1").css("border-color", "#F90");
		
		controlarcadainputcom("CDat1");
		
		EnvAyuda("Ingrese código de origen.");
			
		document.getElementById("DondeE").value = "CDat1";
		document.getElementById("CantiE").value = "15";
		document.getElementById("QuePoE").value = "1";
		
		document.getElementById('LetEnt').innerHTML = '<button class="StyBoton" onclick="enviarorigen();" onmouseout="MM_swapImgRestore()" onmouseover="MM_swapImage(\'LetEntFac\',\'\',\'botones/ent-over.png\',0)"><img src="botones/ent-up.png" name="Enter" title="Enter" border="0" id="LetEntFac"/></button>';
		
		// BOTON UNID. VTA Y MED IGUALES
		$('#BotXUV').attr({
			src: 'Compras/botunidadventa-up.png',
		});
		
		$('#BotXUM').attr({
			src: 'Compras/botunidadmedida-up.png',
		});
		
		$('#Bloquear').fadeOut(500);

	</script>
	<?
	}

}catch(Exception $e){////////////////////////////////////////////////////////////////////////////////////////////////// FIN DE TRY //
	
	?>
	<script>
		jAlert('ERROR Reintente la operacion solicitada.', 'Debo Retail - Global Business Solution');
	</script>
	<?
	
exit;

}