<?
require("config/cnx.php");
/////////////////////////////// COMPRAS
/////////////////////////////// COMPRAS


try {////////////////////////////////////////////////////////////////////////////////////////////////// COMIENZO TRY //


mssql_query("begin transaction",$conexion) or die("Error SQL begin trans");


//REQUEST
$r_tar = $_REQUEST['tar'];
$r_tip = $_REQUEST['tip'];
$r_tco = $_REQUEST['tco'];
$r_suc = $_REQUEST['suc'];
$r_nco = $_REQUEST['nco'];
$r_cod = $_REQUEST['cod'];


	$_SESSION['ParSQL'] = "SELECT * FROM PMAEFACT WHERE TIP = '".$r_tip."' AND TCO = '".$r_tco."' AND SUC = ".$r_suc." AND NCO = ".$r_nco." AND COD = ".$r_cod."";
	$PMAEFACT = mssql_query($_SESSION['ParSQL']) or die("Error SQL");
	rollback($PMAEFACT);
	if(mssql_num_rows($PMAEFACT)==0){

	}else{

		$_SESSION['ParSQL'] = "SELECT * FROM PMOVFACT WHERE TIP = '".$r_tip."' AND TCO = '".$r_tco."' AND SUC = ".$r_suc." AND NCO = ".$r_nco." AND PRO = ".$r_cod."";		
		$PMOVFACT = mssql_query($_SESSION['ParSQL']) or die("Error SQL");
		rollback($PMOVFACT);
		if(mssql_num_rows($PMOVFACT)==0){

			?>
			<script>
		
				document.getElementById('LetEnt').innerHTML = '<button class="StyBoton" onclick="MosPro();" onmouseout="MM_swapImgRestore()" onmouseover="MM_swapImage(\'LetEntFac\',\'\',\'botones/ent-over.png\',0)"><img src="botones/ent-up.png" name="Enter" title="Enter" border="0" id="LetEntFac"/></button>';
				
				SoloBlock("LetEnt");
        
		        EnvAyuda("Factura de Compra incompleta.");

				$("div").css("border-color", "transparent");
				$("#EncDat3").css("border-color", "#F90");
			
				document.getElementById('EDat3').value = "";
				document.getElementById('EDat4').value = "";
				document.getElementById('EDat5').value = "";
				document.getElementById('EDat6').value = "";
				
				document.getElementById("EDat7_1").value = "";
				document.getElementById("EDat7_2").value = "";
				document.getElementById("EDat7_3").value = "";
				document.getElementById("EDat7_4").value = "";
				
				document.getElementById("DondeE").value = "EDat3";
				document.getElementById("CantiE").value = "5";
				document.getElementById("QuePoE").value = "1";


				$('#Bloquear').fadeOut(500);
				
            </script>
            <?
			echo $_SESSION['ParSQL'];
			exit;
			
		}

		while ($PMAE_R = mssql_fetch_array($PMAEFACT)){
	
			$TIP = $PMAE_R['TIP'];
			$TCO = $PMAE_R['TCO'];
			$SUC = $PMAE_R['SUC'];
			$NCO = $PMAE_R['NCO'];
			$COD = $PMAE_R['COD'];
			$EDat5 = $PMAE_R['FPA'];
			$EDat8 = $PMAE_R['FEC'];
			$EDat9 = $PMAE_R['FEV'];
			$EDat13 = $PMAE_R['FECVEN'];
			$EDat14 = $PMAE_R['PDT'];			
			$EDat16 = $PMAE_R['ZON'];
			$EDat11 = $PMAE_R['CAI'];
			$EDat12 = $PMAE_R['FECCAI'];
			
			if($PMAE_R['REM'] != 0){
				$EDat15 = "Con Remitos";
			}else{
				$EDat15 = "Sin Remitos";
			}

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
			$PDat12 = $PMAE_R['DTO'];
			$PDat13 = $PMAE_R['PER'];
			$PDat14 = $PMAE_R['TOT'];

		}
		mssql_free_result($PMAEFACT);
		
		$date = new DateTime($EDat8);
		$EDat8 = $date->format('d/m/Y');
		$EDat8Lat = $date->format('d/m/y');
		
		$date = new DateTime($EDat9);
		$EDat9 = $date->format('d/m/Y');
		
		$date = new DateTime($EDat13);
		$EDat13 = $date->format('d/m/Y');
		
		$date = new DateTime($EDat12);
		$EDat12 = $date->format('d/m/Y');
		
		$_SESSION['ParSQL'] = "SELECT NOMBRE FROM FDPAGO WHERE ID = ".$EDat5."";	
		$FDPAGO = mssql_query($_SESSION['ParSQL']) or die("Error SQL");
		rollback($PMAEFACT);
		while ($FDP_R = mssql_fetch_array($FDPAGO)){
			$EDat6 = $FDP_R['NOMBRE'];
		}
		mssql_free_result($FDPAGO);
		
		$EDat3Lat = format($SUC,4,'0',STR_PAD_LEFT);
		$EDat4Lat = $TIP." - ".$TCO;
		$EDat5Lat = format($NCO,8,'0',STR_PAD_LEFT);
		
		?>
		<script>
						
			////////////////////////////////////////////////////////////////////////////
			SoloNone('CueDat2, CueDat3, CueDat4, CueDat4-2, CueDat5, NumVol, LetTer');//
			////////////////////////////////////////////////////////////////////////////
			SoloBlock('CueDat1, LetEnt');///////////////////////////////////////////////////////
			////////////////////////////////////////////////////////////////////////////
			
			EnvAyuda("Factura de Compra cargada correctamente.");
			
			$("div").css("border-color", "transparent");
			$("#EncDat3").css("border-color", "#F90");

			document.getElementById("EDat5").value = "<? echo $EDat5; ?>";
			document.getElementById("EDat6").value = "<? echo $EDat6; ?>";
			
			document.getElementById("EDat8").value = "<? echo $EDat8; ?>";
				document.getElementById("EncLatI-6").value = "<? echo $EDat8Lat; ?>";
			
			document.getElementById("EDat9").value = "<? echo $EDat9; ?>";
			document.getElementById("EDat13").value = "<? echo $EDat13; ?>";
			document.getElementById("EDat14").value = "<? echo $EDat14; ?>";
			document.getElementById("EDat15").value = "<? echo $EDat15; ?>";
			
			document.getElementById("EDat16").value = "<? echo $EDat16; ?>";
			
			document.getElementById("EDat11").value = "<? echo trim($EDat11); ?>";
			document.getElementById("EDat12").value = "<? echo $EDat12; ?>";
			
			document.getElementById("EncLatI-3").value = "<? echo $EDat3Lat; ?>";
			document.getElementById("EncLatI-4").value = "<? echo $EDat4Lat; ?>";
			document.getElementById("EncLatI-5").value = "<? echo $EDat5Lat; ?>";
			
			document.getElementById("PDat1").value = "<? echo $PDat1; ?>";
			document.getElementById("PDat2").value = "<? echo $PDat2; ?>";
			document.getElementById("PDat3").value = "<? echo $PDat3; ?>";
			document.getElementById("PDat4").value = "<? echo $PDat4; ?>";
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
			
			SoloBlock('ComBotPieDiv, ComBotCueDiv');

			Mostrar_Encabezado();
			
			$("#CuerpoListaCI").load("TFCompraI.php?tar=<? echo $r_tar; ?>&tip=<? echo $r_tip; ?>&tco=<? echo $r_tco; ?>&suc=<? echo $r_suc;?>&nco=<? echo $r_nco; ?>&cod=<? echo $r_cod; ?>");

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