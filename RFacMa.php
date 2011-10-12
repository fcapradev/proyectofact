<?
require("config/cnx.php");


try {////////////////////////////////////////////////////////////////////////////////////////////////// COMIENZO TRY //


mssql_query("begin transaction",$conexion) or die("Error SQL begin trans");


//$_POST
$SUC = $_POST['EDat7Ma1'];
$TIP = $_POST['EDat7Ma2'];
$TCO = $_POST['EDat7Ma3'];
$NCO = $_POST['EDat7Ma4'];

$TER = $_SESSION['ParPOSMa'];
	
	///////////////////////// se modifica tipo de fpa
	$_SESSION['ParSQL'] = "SELECT FPA FROM TMAEFACT_T WHERE TER = ".$TER;
	$TMAEFACT_T = mssql_query($_SESSION['ParSQL']) or die("Error SQL");
	rollback($TMAEFACT_T);
	while ($REG_TMAEFACT_T=mssql_fetch_array($TMAEFACT_T)){
		$FPA = $REG_TMAEFACT_T['FPA'];
	}
	mssql_free_result($TMAEFACT_T);


	$_SESSION['ParSQL'] = "SELECT TIP FROM AMAEFACT WHERE TIP = '".$TIP."' AND TCO = '".$TCO."' AND SUC = ".$SUC." AND NCO = ".$NCO;
	$AMAEFACT = mssql_query($_SESSION['ParSQL']) or die("Error SQL");
	rollback($AMAEFACT);
	
	if(mssql_num_rows($AMAEFACT) == 0){
		
		if((int)$FPA == 1){
			?>
			<script>
				
				EnvAyuda('Continuar: Para finalizar el comprobante.');
				
				SoloNone("LetEnt");
				SoloBlock("LetTer");
				
				document.getElementById('LetTer').innerHTML = '<button class="StyBoton" onclick="ContinuarCarga();" onmouseout="MM_swapImgRestore()" onmouseover="MM_swapImage(\'LConFac\',\'\',\'botones/cont-over.png\',0)"><img src="botones/cont-up.png" name="Continuar" title="Continuar" border="0" id="LConFac"/></button>';
			
				$('#Bloquear').fadeOut(500);
			
			</script>
			<?
		}else{
			?>
			<script>

				ContinuarCargaFPA();
			
			</script>
			<?
		}
	}else{
		?>
		<script>
		
			jAlert('El comprobante ingresado ya se encuantra en el sistema. Reintente la operacion.', 'Debo Retail - Global Business Solution');
		
			document.getElementById("EDat7Ma1").value = "";
			document.getElementById("EDat7Ma4").value = "";
			
			EnvAyuda('Ingrese sucursal del comprobante.');
		
			document.getElementById("DondeE").value = "EDat7Ma1";
			document.getElementById("CantiE").value = "4";
			document.getElementById("QuePoE").value = "1";

			document.getElementById('LetEnt').innerHTML = '<button class="StyBoton" onclick="MaSucursal();" onmouseout="MM_swapImgRestore()" onmouseover="MM_swapImage(\'LetEntSucMa\',\'\',\'botones/ent-over.png\',0)"><img src="botones/ent-up.png" name="Enter" title="Enter" border="0" id="LetEntSucMa"/></button>';
		
			$('#Bloquear').fadeOut(500);
			
			$("#EDat7Ma1").focus();
					
		</script>
		<?		
	}
	mssql_free_result($AMAEFACT);


mssql_query("commit transaction") or die("Error SQL commit");

	
}catch(Exception $e){////////////////////////////////////////////////////////////////////////////////////////////////// FIN DE TRY //
	
	?>
	<script>
		jAlert('ERROR Reintente la operacion solicitada.', 'Debo Retail - Global Business Solution');
	</script>
	<?
exit;

}