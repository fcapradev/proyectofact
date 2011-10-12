<?
require("config/cnx.php");
/////////////////////////////// COMPRAS
/////////////////////////////// COMPRAS


try {////////////////////////////////////////////////////////////////////////////////////////////////// COMIENZO TRY //


mssql_query("begin transaction",$conexion) or die("Error SQL begin trans");


//SESSION
$TER = $_SESSION['ParPOS'];

//REQUEST
$SEC = $_REQUEST['sec'];
$ART = $_REQUEST['art'];
$COO = $_REQUEST['coo'];
$COO1 = $_REQUEST['coo1'];


	$_SESSION['ParSQL'] = "SELECT TOP 1 COD FROM PMAEFACT_T WHERE TER = ".$TER."";
	$PMAEFACT_TT = mssql_query($_SESSION['ParSQL']) or die("Error SQL");
	rollback($PMAEFACT_TT);
	while ($reg=mssql_fetch_array($PMAEFACT_TT)){ 
			$COD = $reg['COD'];
	}
	mssql_free_result($PMAEFACT_TT);

	$_SESSION['ParSQL'] = "SELECT COO FROM A_COD_ORI WHERE SEC = ".$SEC." AND ART = ".$ART." AND PRV = ".$COD."";
	$A_COD_ORI = mssql_query($_SESSION['ParSQL']) or die("Error SQL");
	rollback($A_COD_ORI);
	if(mssql_num_rows($A_COD_ORI)==0){
		
		$_SESSION['ParSQL'] = "SELECT COO FROM A_COD_ORI WHERE PRV = ".$COD." AND COO = '".$COO."'";
		$A_COD_ORI2 = mssql_query($_SESSION['ParSQL']) or die("Error SQL");
		rollback($A_COD_ORI2);
		
		if(mssql_num_rows($A_COD_ORI2)==0){
		
			$_SESSION['ParSQL'] = "INSERT INTO A_COD_ORI (SEC, ART, PRV, COO) VALUES (".$SEC.", ".$ART.", ".$COD.", ".$COO."); ";
			$INSERTA_COD_ORI = mssql_query($_SESSION['ParSQL']) or die("Error SQL");
			rollback($INSERTA_COD_ORI);
	
			?>
			<script>
				SoloNone('CueDat4');
				SoloNone('CueDat4-2');			
				
				EnvAyuda("Ingrese cantidad.");

				$("#CueDat5").css("border-color", "#F90");
							
				document.getElementById('LetEnt').innerHTML = '<button class="StyBoton" onclick="ControlCan();" onmouseout="MM_swapImgRestore()" onmouseover="MM_swapImage(\'LetEntFac\',\'\',\'botones/ent-over.png\',0)"><img src="botones/ent-up.png" name="Enter" title="Enter" border="0" id="LetEntFac"/></button>';
				
				controlarcadainputcom("CDat5");
				
				document.getElementById("DondeE").value = "CDat5";
				document.getElementById("CantiE").value = "10";
				document.getElementById("QuePoE").value = "1";
			</script>
			<?
			
		}else{
			?>
			<script>
				document.getElementById("CDat4").value = "";
				jAlert('El código de origen ya existe para otro producto.', 'Debo Retail - Global Business Solution');
			</script>
			<?		
		}
		
	}else{

		$_SESSION['ParSQL'] = "UPDATE A_COD_ORI SET COO = '".$COO."' WHERE SEC = ".$SEC." AND ART = ".$ART." AND PRV = ".$COD." AND COO = '".$COO1."'";
		$UPDATEA_COD_ORI = mssql_query($_SESSION['ParSQL']) or die("Error SQL");
		rollback($UPDATEA_COD_ORI);

		?>
		<script>
			SoloNone('CueDat4');
			SoloNone('CueDat4-2');			
		
			EnvAyuda("Ingrese cantidad.");

			controlarcadainputcom("CDat5");
			
			$("#CueDat5").css("border-color", "#F90");
			
			document.getElementById('LetEnt').innerHTML = '<button class="StyBoton" onclick="ControlCan();" onmouseout="MM_swapImgRestore()" onmouseover="MM_swapImage(\'LetEntFac\',\'\',\'botones/ent-over.png\',0)"><img src="botones/ent-up.png" name="Enter" title="Enter" border="0" id="LetEntFac"/></button>';
					
			document.getElementById("DondeE").value = "CDat5";
			document.getElementById("CantiE").value = "10";
			document.getElementById("QuePoE").value = "1";
		</script>
		<?
	
	}
	mssql_free_result($A_COD_ORI);

		
mssql_query("commit transaction") or die("Error SQL commit");

	
}catch(Exception $e){////////////////////////////////////////////////////////////////////////////////////////////////// FIN DE TRY //
	
	?>
	<script>
		jAlert('ERROR Reintente la operacion solicitada.', 'Debo Retail - Global Business Solution');
	</script>
	<?

echo $e;
exit;

}