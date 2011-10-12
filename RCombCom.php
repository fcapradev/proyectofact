<?
require("config/cnx.php");
/////////////////////////////// COMPRAS


try {////////////////////////////////////////////////////////////////////////////////////////////////// COMIENZO TRY //


mssql_query("begin transaction",$conexion) or die("Error SQL begin trans");


$a = 0;
$a = $_REQUEST['a'];

switch($a){

case 1:
	if(isset($_REQUEST['pro'])){
			
		//REQUEST
		$PRO = $_REQUEST['pro'];
		
		if(strlen($PRO) == 0){
		
			?>
			<script>
				$("#ComDatos").load("CombPro.php?ord=1&tor=1&abc=1");
				SoloBlock('EncabezadoLat, EncabezadoDLat, Proveedores, ProveedoresDat');
				SoloNone('ComprasDfon, Encabezado, EncabezadoDat, ComBotEncDiv');

			</script>
			<?
	
		}else{
			
			if(!is_numeric($PRO)){

				?>
				<script>
					document.getElementById("EDat3").value = "";
					jAlert('El campo ingresado no es correcto.', 'Debo Retail - Global Business Solution');
				</script>
				<?
				exit;
		
			}
					
			$_SESSION['ParSQL'] = "SELECT COD, NOM, FPA, TIP FROM PROVEED WHERE COD = ".$PRO."";
			$PROVEED = mssql_query($_SESSION['ParSQL']) or die("Error SQL");
			rollback($PROVEED);
		
			if(mssql_num_rows($PROVEED)==0){
				?>
				<script>
					$("#ComDatos").load("CombPro.php?ord=1&tor=1&abc=1");
					SoloBlock('EncabezadoLat, EncabezadoDLat, Proveedores, ProveedoresDat');
					SoloNone('ComprasDfon, Encabezado, EncabezadoDat, ComBotEncDiv');
				</script>
				<?
			}
		
			while ($R_PRO=mssql_fetch_array($PROVEED)){
				
				$COD = format($R_PRO['COD'],5,'0',STR_PAD_LEFT);
				$NOM = htmlentities($R_PRO['NOM']);
				$FPA = $R_PRO['FPA'];
				$TIP = $R_PRO['TIP'];
	
				?>
				<script>
				
				var nom	= '<? echo $NOM; ?>';
				nom = nom.replace('&Ntilde;', 'Ñ');
				
				document.getElementById('EDat3').value = '<? echo $COD; ?>';
				document.getElementById('EDat4').value = nom;
				document.getElementById('EDat5').value = '<? echo $FPA; ?>';
				document.getElementById('EncLatI-2').value = '<? echo $COD; ?>';
				
				if(document.getElementById("Modifica").value != 1){
					document.getElementById('EDat7_2_T').value = '<? echo $TIP; ?>';
				}

				document.getElementById('LetEnt').innerHTML = '<button class="StyBoton" onclick="MosFpa();" onmouseout="MM_swapImgRestore()" onmouseover="MM_swapImage(\'LetEntFac\',\'\',\'botones/ent-over.png\',0)"><img src="botones/ent-up.png" name="Enter" title="Enter" border="0" id="LetEntFac"/></button>';

				var mod = document.getElementById("HabFunModCom").value;
				if(mod == 1){
					SoloNone("LetTer");
				}else{
					SoloBlock('LetTer');
				}
				
				document.getElementById('LetTer').innerHTML = '<button class="StyBoton" onclick="listadocomcom();" onmouseout="MM_swapImgRestore()" onmouseover="MM_swapImage(\'LetConsul\',\'\',\'botones/con-over.png\',0)"><img src="botones/con-up.png" name="Consultar" title="Consultar" border="0" id="LetConsul"/></button>';
				
				SoloBlock('NumVol');

				document.getElementById('NumVol').innerHTML = '<button class="StyBoton" onclick="VolProv()" onmouseout="MM_swapImgRestore()" onmouseover="MM_swapImage(\'LeVolCom\',\'\',\'botones/vol-over.png\',0)"><img src="botones/vol-up.png" name="Volver" title="Volver" border="0" id="LeVolCom"/></button>';
				
				$("#EncDat3").css("border-color", "transparent");
				$("#EncDat5").css("border-color", "#F90");

				EnvAyuda('Ingrese forma de pago. Enter para buscar.');
				
				document.getElementById('LetTex').value = "";
				
				document.getElementById("DondeE").value = "EDat5";
				document.getElementById("CantiE").value = "5";
				document.getElementById("QuePoE").value = "1";
				
				controlarcadainputcom("EDat5");
				
				</script>
				<?
			
			}
		
		}
		
	}
break;

case 2:
	if(isset($_REQUEST['fpa'])){
			
		//REQUEST
		$FPA = $_REQUEST['fpa'];

		if(strlen($FPA) == 0 or $FPA == 0){
		
			?>
			<script>
				$("#FormaPago").load("CombFpa.php");
				SoloBlock('FormaPago, FormaPagoFon');
			</script>
			<?
	
		}else{
		
			$_SESSION['ParSQL'] = "SELECT NOMBRE FROM FDPAGO WHERE ID = ".$FPA."";
			$FDPAGO = mssql_query($_SESSION['ParSQL']) or die("Error SQL");
			rollback($FDPAGO);
		
			if(mssql_num_rows($FDPAGO)==0){
				?>
				<script>
					$("#FormaPago").load("CombFpa.php");
					SoloBlock('FormaPago, FormaPagoFon');
				</script>
				<?
			}
		
			while ($R_FDP=mssql_fetch_array($FDPAGO)){
				
				$NOM = htmlentities($R_FDP['NOMBRE']);
	
				?>
				<script>
				
			var nom	= '<? echo $NOM; ?>';
			nom = nom.replace('&Ntilde;', 'Ñ');
			document.getElementById('EDat6').value = nom;
			
			var ban = document.getElementById("HabFunModCom").value;
			
			if(ban == 1){

				$("#EncDat5").css("border-color", "transparent");
				$("#EncDat8").css("border-color", "#F90");
				
				EnvAyuda('Ingrese fecha del comprobante.');
				document.getElementById('EncDat771').innerHTML = '<img src="Compras/com.png" />';

				//document.getElementById('EDat8').value = "";
					
				document.getElementById("DondeE").value = "EDat8";
				document.getElementById("CantiE").value = "10";
				document.getElementById("QuePoE").value = "1";
				
				document.getElementById('LetEnt').innerHTML = '<button class="StyBoton" onclick="FechaFac();" onmouseout="MM_swapImgRestore()" onmouseover="MM_swapImage(\'LetEntFac\',\'\',\'botones/ent-over.png\',0)"><img src="botones/ent-up.png" name="Enter" title="Enter" border="0" id="LetEntFac"/></button>';
	
				document.getElementById('NumVol').innerHTML = '<button class="StyBoton" onclick="VolNdcom();" onmouseout="MM_swapImgRestore()" onmouseover="MM_swapImage(\'LeVolCom\',\'\',\'botones/vol-over.png\',0)"><img src="botones/vol-up.png" name="Volver" title="Volver" border="0" id="LeVolCom"/></button>';

				controlarcadainputcom("EDat8");
				
			}else{

				EnvAyuda('Ingrese sucursal del comprobante.');
			
				$("#EncDat5").css("border-color", "transparent");
				$("#EncDat7-1").css("border-color", "#F90");
			
				document.getElementById("DondeE").value = "EDat7_1";
				document.getElementById("CantiE").value = "4";
				document.getElementById("QuePoE").value = "1";
	
				document.getElementById('EncDat771').innerHTML = '<img src="Compras/suc.png" />';
				
				document.getElementById('LetEnt').innerHTML = '<button class="StyBoton" onclick="Sucursal();" onmouseout="MM_swapImgRestore()" onmouseover="MM_swapImage(\'LetEntFac\',\'\',\'botones/ent-over.png\',0)"><img src="botones/ent-up.png" name="Enter" title="Enter" border="0" id="LetEntFac"/></button>';
				
				document.getElementById('NumVol').innerHTML = '<button class="StyBoton" onclick="VolFdpago()" onmouseout="MM_swapImgRestore()" onmouseover="MM_swapImage(\'LeVolCom\',\'\',\'botones/vol-over.png\',0)"><img src="botones/vol-up.png" name="Volver" title="Volver" border="0" id="LeVolCom"/></button>';
				
				controlarcadainputcom("EDat7_1");	

			}
				</script>
				<?
			
			}
		
		}
		
	}
	
break;



case 3:
	if(isset($_REQUEST['iva'])){
		
		$IVA = $_REQUEST['iva'];
	
		$_SESSION['ParSQL'] = "SELECT NOMBRE FROM IVA WHERE ID = ".$IVA."";
		$IVA = mssql_query($_SESSION['ParSQL']) or die("Error SQL");
		rollback($IVA);
	
		if(mssql_num_rows($IVA)==0){
			?>
			<script>
				$("#FormaPago").load("CombFpa.php");
				SoloBlock('FormaPago, FormaPagoFon');
			</script>
			<?
		}
	
		while ($IVA_R=mssql_fetch_array($IVA)){
			
			$NOM = htmlentities($IVA_R['NOMBRE']);
	
			?>
			<script>
	
				var nom	= '<? echo $NOM; ?>';
				nom = nom.replace('&Ntilde;', 'Ñ');
				document.getElementById('Eventual7').value = nom;
						
				SoloNone('LetEnt');
				
				$("#Eve6").css("border-color", "transparent");
				
				EnvAyuda("Continuar para finalizar carga del proveedor.");
				
				document.getElementById("DondeE").value = "LetTex";
				document.getElementById("CantiE").value = "0";
				document.getElementById("QuePoE").value = "1";
				
				document.getElementById('LetTer').innerHTML = '<button class="StyBoton" onclick="ConfEventual();" onmouseout="MM_swapImgRestore()" onmouseover="MM_swapImage(\'LetCont\',\'\',\'botones/cont-over.png\',0)"><img src="botones/cont-up.png" name="Continuar" title="Continuar" border="0" id="LetCont"/></button>';
				
				SoloBlock('LetTer');
		
			</script>
			<?
		}
	}
break;



default:
	?>
	<script>
		jAlert('Mal Configurado, default', 'Debo Retail - Global Business Solution');
	</script>
	<? 
break;

}

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