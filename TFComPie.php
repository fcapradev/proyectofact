<?
require("config/cnx.php");
/////////////////////////////// COMPRAS
/////////////////////////////// COMPRAS


try {////////////////////////////////////////////////////////////////////////////////////////////////// COMIENZO TRY //


mssql_query("begin transaction",$conexion) or die("Error SQL begin trans");


//SESSION
$TER = $_SESSION['ParPOS'];

//REQUEST
$r_tip = $_REQUEST['tip'];
$r_tco = $_REQUEST['tco'];
$r_suc = $_REQUEST['suc'];
$r_nco = $_REQUEST['nco'];
$r_cod = $_REQUEST['cod'];


	$_SESSION['ParSQL'] = "UPDATE PMAEFACT_T SET NET = 0, IMI = 0, IRI = 0, TOT = 0 
	WHERE TIP = '".$r_tip."' AND TCO = '".$r_tco."' AND SUC = ".$r_suc." AND NCO = ".$r_nco." AND COD = ".$r_cod." AND TER = ".$TER."";
	$PMAEFACT_T = mssql_query($_SESSION['ParSQL']) or die("Error SQL");
	rollback($PMAEFACT_T);
	

	$_SESSION['ParSQL'] = "
	SELECT COD, ART, CAN, PUN FROM PMOVFACT_T WHERE TIP = '".$r_tip."' AND TCO = '".$r_tco."' AND SUC = ".$r_suc." AND NCO = ".$r_nco." AND PRO = ".$r_cod;
	$RECALPMOVFACT_T = mssql_query($_SESSION['ParSQL']) or die("Error SQL");
	rollback($RECALPMOVFACT_T);
	while ($RECALPMOV_T=mssql_fetch_array($RECALPMOVFACT_T)){
		
		
		$CS = $RECALPMOV_T['COD'];
		$CA = $RECALPMOV_T['ART'];
		$CC = $RECALPMOV_T['CAN'];
		$CP = $RECALPMOV_T['PUN'];


		//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
		if($CS == 0 && $CA == 0){
		
			$RUB = 1;
			$IMI = 0;
			$TIVA = 0;
			
		}else{
			
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
			
		}
		
			$IMPIVA = ($CP * $TIVA) / 100;
			$IMPIVA = dec($IMPIVA,2);
			
			$CALIMI = $IMI * $CC;
			$CALIMI = dec($CALIMI,2);
			
			$TOT_TOT = ($CP * $CC) + ($IMPIVA * $CC) + ($CALIMI);

			$_SESSION['ParSQL'] = "UPDATE PMAEFACT_T SET NET = NET + ".$CP * $CC.", IMI = IMI + ".$CALIMI.", IRI = IRI + ".$IMPIVA * $CC.", TOT = TOT + ".$TOT_TOT." 
			WHERE TIP = '".$r_tip."' AND TCO = '".$r_tco."' AND SUC = ".$r_suc." AND NCO = ".$r_nco." AND COD = ".$r_cod." AND TER = ".$TER."";
			$PMAEFACT_T = mssql_query($_SESSION['ParSQL']) or die("Error SQL");
			rollback($PMAEFACT_T);
		//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////

	} 


	$_SESSION['ParSQL'] = "SELECT NET, NEE, RGA, IRI, IRS, RIB, PIV, RIV, IMI, CNG, CNG2, PDT, PER, TOT FROM 
	PMAEFACT_T WHERE TIP = '".$r_tip."' AND TCO = '".$r_tco."' AND SUC = ".$r_suc." AND NCO = ".$r_nco." AND COD = ".$r_cod;	
	$PMAEFACT = mssql_query($_SESSION['ParSQL']) or die("Error SQL");
	rollback($PMAEFACT);
	
	
	if(mssql_num_rows($PMAEFACT)==0){
		
	}else{

		while ($PMAE_R = mssql_fetch_array($PMAEFACT)){
			
			$PDat1 = $PMAE_R['NET'];
			$PDat2 = $PMAE_R['NEE'];
			$PDat3 = $PMAE_R['RGA'];
			$PDat4 = $PMAE_R['IRI'];
			$PDat5 = $PMAE_R['IRS'];
			$PDat6 = $PMAE_R['RIB'];
			$PDat7 = $PMAE_R['PIV'];
			$PDat8 = $PMAE_R['RIV'];
			$PDat9 = $PMAE_R['IMI'];
			$PDat10 = $PMAE_R['CNG'];
			$PDat11 = $PMAE_R['CNG2'];
			$PDat12 = $PMAE_R['PDT'];
			$PDat13 = $PMAE_R['PER'];
			$PDat14 = $PMAE_R['TOT'];
			
		}
		mssql_free_result($PMAEFACT);
		
		?>
		<script>

			document.getElementById("PDat1").value = "<? echo $PDat1; ?>";
			document.getElementById("PDat2").value = "<? echo $PDat2; ?>";
			document.getElementById("PDat3").value = "<? echo $PDat3; ?>";
			document.getElementById("PDat4").value = "<? echo $PDat4 ?>";
			document.getElementById("PDat5").value = "<? echo $PDat5; ?>";
			document.getElementById("PDat6").value = "<? echo $PDat6; ?>";
			document.getElementById("PDat7").value = "<? echo $PDat7; ?>";
			document.getElementById("PDat8").value = "<? echo $PDat8; ?>";
			document.getElementById("PDat9").value = "<? echo $PDat9; ?>";
			document.getElementById("PDat10").value = "<? echo $PDat10; ?>";
			document.getElementById("PDat11").value = "<? echo $PDat11; ?>";
			document.getElementById("PDat12").value = "<? echo $PDat12; ?>";
			document.getElementById("PDat13").value = "<? echo $PDat13; ?>";
			document.getElementById("PDat14").value = "<? echo $PDat14; ?>";

		</script>
		<?

	}


mssql_query("commit transaction") or die("Error SQL commit");


	?>
	<script>
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