<?
$xaptur = 1;
require("config/cnx.php");


try {////////////////////////////////////////////////////////////////////////////////////////////////// COMIENZO TRY //   


mssql_query("begin transaction",$conexion) or die("Error SQL begin trans");


$a = 0;
$a = $_REQUEST['a'];


switch($a){

/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
case 1:

		$SQL = "SELECT OPE FROM APARPOS WHERE ID = '".$_SESSION["ParPOS"]."'";
		$registros = mssql_query($SQL) or die("Error SQL");	
			if(mssql_num_rows($registros) == 0){
				?>
				<script>
					$("#BotonesPri").load("BotonesPri.php");
					jAlert('No esta Configurado la Terminal', 'Debo Retail - Global Business Solution');
					$('#Bloquear').fadeOut(500);
				</script>    
				<?
				exit;
			}
		
		while ($reg=mssql_fetch_array($registros)){
			$OPE = $reg['OPE'];
		}	

		/*
		$SQLO = "SELECT OPE FROM APARPOS WHERE OPE = '".$OPE."'";
		$registrosO = mssql_query($SQLO) or die("Error SQL");
		if(mssql_num_rows($registrosO) >= 1){
			?>
			<script>
				jAlert('El Operario ya esta trabajando en una terminal. Mal Configurado.', 'Debo Retail - Global Business Solution');
			</script>    
			<?
			exit;
		}
		*/

	if($OPE > 0){

		$SQL = "SELECT * FROM VENDEDORES WHERE CODVEN = ".$OPE."";
		$registros = mssql_query($SQL) or die("Error SQL");
			if(mssql_num_rows($registros) == 0){
				?>
				<script>
					$("#BotonesPri").load("BotonesPri.php");
					jAlert('No esta Configurado la Terminal', 'Debo Retail - Global Business Solution');
					$('#Bloquear').fadeOut(500);
				</script>    
				<?
				exit;
			}
		
		while ($reg=mssql_fetch_array($registros)){
			
			$nplven = $reg['NplVen'];
			$turven = $reg['TurVen'];
			$OPEN = $reg['NomVen'];
			
			if($nplven == 0 and $turven == 0){
			
				//update aparpost
				?>
				<script>
					$("#BotonesPri").load("BotonesPri.php");
					jAlert('Hacer Update en la aparpost', 'Debo Retail - Global Business Solution');
					$('#Bloquear').fadeOut(500);
				</script>    
				<?
				exit;
				
			}else{
			
				?>
				<script>
		$("#BotonesPri").load("BotonesPri.php");
		jAlert('Existe Turno Abierto Caja: <? echo $nplven; ?> \n Operario: <? echo $OPE;  echo ", ";  echo $OPEN;?>', 'Debo Retail - Global Business Solution');
		$('#Bloquear').fadeOut(500);
				</script>
				<?
				exit;
				
			}	
			
		}
		
	}else{
		
	?>
	<script>
				
		$("#BotonesPri").fadeOut(400);
		$("#SobreFoca").fadeOut(400);

		Mos_Ocu('AperturaTurno');

		document.getElementById('LetEnt').innerHTML = '<button id="BotLetEnt7" onclick="enviarho();" class="StyBoton" onmouseout="MM_swapImgRestore()" onmouseover="MM_swapImage(\'LetEnttt7\',\'\',\'botones/ent-over.png\',0)"><img src="botones/ent-up.png" name="Enter" title="Enter" border="0" id="LetEnttt7"/></button>';
			
		document.getElementById('LetSal').innerHTML = '<button class="StyBoton" onclick="salir_a();" onmouseout="MM_swapImgRestore()" onmouseover="MM_swapImage(\'LetSalapertura\',\'\',\'botones/sal-over.png\',0)"><img src="botones/sal-up.png" name="Salir" title="Salir" border="0" id="LetSalapertura"/></button>';
		
		document.getElementById('NumVol').innerHTML = '<button class="StyBoton" onclick="salir_a();" onmouseout="MM_swapImgRestore()" onmouseover="MM_swapImage(\'NumVol1\',\'\',\'botones/vol-over.png\',0)"><img src="botones/vol-up.png" name="Volver" title="Volver" border="0" id="NumVol1"/></button>';
		
		document.getElementById('LetTexDiv').innerHTML = '<input type="text" name="LetTex" id="LetTex" style="outline-style:none; border-style:none; font-family:\'TPro\'; font-size:14px;" onkeypress="return enviodehorario();" />';		
				
		Mos_Ocu('fondotranspletras');
		Mos_Ocu('TecladoLet');
		Mos_Ocu('fondotranspnumeros');
		Mos_Ocu('TecladoNum');
		
		EnvAyuda('Seleccione horario para el turno.');
		
		document.getElementById('AccBotPriDis<? echo $a; ?>').disabled = false;
		
		SoloNone("LetTer");
		SoloBlock("LetSal, LetEnt, NumVol");
		
	</script>
	<?
			
	}

break;
/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
case 2:
	$SQL = "SELECT OPE FROM APARPOS WHERE ID = '".$_SESSION["ParPOS"]."'";
	
		$registros = mssql_query($SQL) or die("Error SQL");
			
			if(mssql_num_rows($registros) == 0){
				?>
				<script>
					$("#BotonesPri").load("BotonesPri.php");
					jAlert('No esta Configurado la Terminal', 'Debo Retail - Global Business Solution');
					$('#Bloquear').fadeOut(500);
				</script>    
				<?
				exit;
			}
		
			while ($reg=mssql_fetch_array($registros)){
				$OPE = $reg['OPE'];
			}

	if($OPE == 0){
		
		?>
		<script>
			$("#BotonesPri").load("BotonesPri.php");
			jAlert('No Hay Turnos Abiertos para Trabajar.', 'Debo Retail - Global Business Solution');	
			$('#Bloquear').fadeOut(500);
		</script>
		<?
		
	}else{


			if($OPE != $_SESSION["idsusua"]){
				?>
				<script>
					$("#BotonesPri").load("BotonesPri.php");
					jAlert('Usted no es el operario que abrio el turno. No puede ingresar.', 'Debo Retail - Global Business Solution');
					$('#Bloquear').fadeOut(500);
				</script>    
				<?
				exit;
			}

			
	$_SESSION['ParFacSec'] = 1;
	?>
	<script>

		document.getElementById('AccBotPriDis<? echo $a; ?>').disabled = false;

		$('#TecladoNum').attr({
		   'style': 'top:28px',
		});
		
		$('#NumVol').attr({
		   'style': 'left:747px; display:block;'
		});

//////////////////// para ingresar el codigo de barra ////////////////////////////////////////////////////
		document.getElementById("LetTexDiv").innerHTML = '<form id="ConReCodigo" name="ConReCodigo" method="post" onsubmit="return ReeCodigo();"><input type="text" name="LetTex" id="LetTex" style="outline-style:none; border-style:none; text-transform:uppercase; font-family:\'TPro\'; font-size:14px;" onkeypress="return ControlDeEnvioLetTexPres();" onkeydown="return ControlDeEnvioLetTexDown();" /></form>';
//////////////////////////////////////////////////////////////////////////////////////////////////////////
//////////////////// para ingresar cantidad de producto //////////////////////////////////////////////////
		document.getElementById("NumTexDiv").innerHTML = '<input style="outline-style:none; border-style:none;" type="text" name="NumTex" id="NumTex" maxlength="10" onkeypress="return Enviar_XEnter();"/>';
//////////////////////////////////////////////////////////////////////////////////////////////////////////

		var nocargar = document.getElementById("YaFacAu").value;
		if(nocargar==1){
			
			SoloNone("FacturadorMa, Compras, Marca, BotMins1, BotMins2, LetTer, ProcesoSusp");
			SoloBlock("fondotranspletras, TecladoLet, fondotranspnumeros, TecladoNum, BotMins, LetSal, LetEnt, NumVol, NumAre, NumTexDiv");
			
			//////////////////////////////////////////////////
			LeerCookies(1); //////////////////////////////////
			//////////////////////////////////////////////////
			
			SoloBlock('Facturador');

			//////////////////////////////////////////////////////////////////////
			$("#"+document.getElementById("DondeE").value).focus(); //////////////
			//////////////////////////////////////////////////////////////////////

		}else{
			
			Mos_Ocu('Facturador');
			
			document.getElementById("YaFacAu").value = 1;
			document.getElementById("YaFac").value = 1;
			
			
			document.getElementById("LetTex").value = "";
			document.getElementById("DondeE").value = "LetTex";
			document.getElementById("CantiE").value = "50";
			document.getElementById("QuePoE").value = "0";
	
			document.getElementById("LetSal").innerHTML = '<button class="StyBoton" onclick="AccBotFac(10);" onmouseout="MM_swapImgRestore()" onmouseover="MM_swapImage(\'LetSalfacfac\',\'\',\'botones/sal-over.png\',0)"><img src="botones/sal-up.png" name="Salir" title="Salir" border="0" id="LetSalfacfac"/></button>';
					
			document.getElementById("LetEnt").innerHTML = '<button class="StyBoton" onclick="ReeCodigo();" onmouseout="MM_swapImgRestore()" onmouseover="MM_swapImage(\'LetEntFac\',\'\',\'botones/ent-over.png\',0)"><img src="botones/ent-up.png" name="Enter" title="Enter" border="0" id="LetEntFac"/></button>';
			
			document.getElementById("LetTer").innerHTML = '<button class="StyBoton" onclick="TerminarVul();" onmouseout="MM_swapImgRestore()" onmouseover="MM_swapImage(\'LetTerFac\',\'\',\'botones/ter-over.png\',0)"><img src="botones/ter-up.png" name="Terminar" title="Terminar" border="0" id="LetTerFac"/></button>';
			
			document.getElementById("NumVol").innerHTML = '<button class="StyBoton" onclick="ReeCodigo();" onmouseout="MM_swapImgRestore()" onmouseover="MM_swapImage(\'LetEntFac2\',\'\',\'botones/ent-over.png\',0)"><img src="botones/ent-up.png" name="Enter" title="Enter" border="0" id="LetEntFac2"/></button>';


			EnvAyuda('Ingrese código de barras o realice una búsqueda.');
	
			$("#LetTex").focus();
			
			SoloNone("FacturadorMa, Compras, Marca, BotMins1, BotMins2, LetTer, ProcesoSusp");
			SoloBlock("fondotranspletras, TecladoLet, fondotranspnumeros, TecladoNum, BotMins, LetSal, LetEnt, NumVol, NumAre, NumTexDiv");
			
			///////////////////////////////////////////
			EscrCookies();/////////////////////////////
			///////////////////////////////////////////
			
		}
				
		$("#BotonesPri").fadeOut(400);
		$("#SobreFoca").fadeOut(400);

		if(document.getElementById('TarPorFacFor')){
			
			document.getElementById('TarPorFacFor').value = document.getElementById('bTarPorFac').value;
			
		}
					
	</script>
	<?
	}
	
break;
/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
case 3:

	$SQL = "SELECT OPE FROM APARPOS WHERE ID = '".$_SESSION["ParPOS"]."'";
	
		$registros = mssql_query($SQL) or die("Error SQL");
		
			if(mssql_num_rows($registros) == 0){
				?>
				<script>
					$("#BotonesPri").load("BotonesPri.php");
					jAlert('No esta Configurado la Terminal', 'Debo Retail - Global Business Solution');
					$('#Bloquear').fadeOut(500);
				</script>
				<?
				exit;
			}
		
		while ($reg=mssql_fetch_array($registros)){
			$OPE = $reg['OPE'];
		}
	
	if($OPE == 0){
		
		?>
		<script>
			$("#BotonesPri").load("BotonesPri.php");
			jAlert('No Hay Turnos Abiertos para Trabajar.', 'Debo Retail - Global Business Solution');
			$('#Bloquear').fadeOut(500);
		</script>
		<?		
		
	}else{ 

			if($OPE != $_SESSION["idsusua"]){
				?>
				<script>
					$("#BotonesPri").load("BotonesPri.php");
					jAlert('Usted no es el operario que abrio el turno. No puede ingresar.', 'Debo Retail - Global Business Solution');
					$('#Bloquear').fadeOut(500);
				</script>    
				<?
				exit;
			}

	$_SESSION['ParSQL'] = "
	SELECT C.NplVen AS PLA FROM ATURNOSH AS A 
	INNER JOIN APARPOS AS B ON B.ID = '".$_SESSION['ParPOS']."'
	INNER JOIN VENDEDORES AS C ON C.CodVen = B.OPE
	INNER JOIN ATURNOSO AS D ON D.PLA = C.NplVen
	WHERE A.MTN = D.MTN
	";
	
	$registros = mssql_query($_SESSION['ParSQL']) or die("Error SQL");
	rollback($registros);		
	
	if(mssql_num_rows($registros)==0){
		exit;
	}
	while ($reg=mssql_fetch_array($registros)){
	
		$PLA = $reg['PLA'];
		
	}


	$SQL = "SELECT * FROM TMAEFACT";
	$registros = mssql_query($SQL) or die("Error SQL");
	if(mssql_num_rows($registros) == 0){

		?>
		<script>
		
			$("#BotonesPri").fadeOut(400);
			$("#SobreFoca").fadeOut(400);
			
			$('#Bloquear').fadeOut(500);
	
			SoloNone("LetEnt, LetTer");
			SoloBlock("LetSal, NumVol, NumVolPro");
			
			Mos_Ocu('fondotranspletras');
			Mos_Ocu('TecladoLet');
			Mos_Ocu('fondotranspnumeros');
			Mos_Ocu('TecladoNum');
			Mos_Ocu('CierreTurno');
	
			document.getElementById("LetSal").innerHTML = '<button class="StyBoton" onclick="salir_ae();" onmouseout="MM_swapImgRestore()" onmouseover="MM_swapImage(\'LetSalCierre\',\'\',\'botones/sal-over.png\',0)"><img src="botones/sal-up.png" name="Salir" title="Salir" border="0" id="LetSalCierre"/></button>';
			
			document.getElementById("LetEnt").innerHTML = '<button class="StyBoton" onclick="enviar_ct();" onmouseout="MM_swapImgRestore()" onmouseover="MM_swapImage(\'LetEntCierre\',\'\',\'botones/cer-over.png\',0)"><img src="botones/cer-up.png" name="Cerrar" title="Cerrar" border="0" id="LetEntCierre"/></button>';
			
			document.getElementById("LetTer").innerHTML = '<button class="StyBoton" onclick="salir_ae();" onmouseout="MM_swapImgRestore()" onmouseover="MM_swapImage(\'LetTerCierre\',\'\',\'botones/can-over.png\',0)"><img src="botones/can-up.png" name="Cancelar" title="Cancelar" border="0" id="LetTerCierre"/></button>';
			
			document.getElementById("NumVol").innerHTML = '<button class="StyBoton" onclick="salir_ae();" onmouseout="MM_swapImgRestore()" onmouseover="MM_swapImage(\'NumVolCierre\',\'\',\'botones/vol-over.png\',0)"><img src="botones/vol-up.png" name="Volver" title="Volver" border="0" id="NumVolCierre"/></button>';
			
			document.getElementById('NumVolPro').innerHTML = '<button onclick="ReImpPla();" class="StyBoton" onmouseout="MM_swapImgRestore()" onmouseover="MM_swapImage(\'LetImpCC\',\'\',\'botones/imp-over.png\',0)"><img src="botones/imp-up.png" name="Imprimir" title="Imprimir" border="0" id="LetImpCC"/></button>';
			
			document.getElementById("DondeE").value = "LetTex";
			document.getElementById("CantiE").value = "6";
			document.getElementById("QuePoE").value = "1";
			
			EnvAyuda("Seleccione la caja a cerrar.O ingrese la planilla a Reimprimir.");
			
			document.getElementById('AccBotPriDis<? echo $a; ?>').disabled = false;

		</script>
		<?
		exit;

	}else{
		?>
		<script>

			$("#BotonesPri").fadeOut(400);
			$("#SobreFoca").fadeOut(400);
	
			SoloNone("LetEnt, LetTer");
			
			$("#CierreTurno2").load("CierreTurno2.php");
			$("#CierreTurno2").fadeIn(400);

			document.getElementById('AccBotPriDis<? echo $a; ?>').disabled = false;
			
		</script>
		<?
	}
}

break;
/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
case 4:
	$SQL = "SELECT OPE FROM APARPOS WHERE ID = '".$_SESSION["ParPOS"]."'";
	
		$registros = mssql_query($SQL) or die("Error SQL");
		
			if(mssql_num_rows($registros) == 0){
				?>
				<script>
					$("#BotonesPri").load("BotonesPri.php");
					jAlert('No esta Configurado la Terminal', 'Debo Retail - Global Business Solution');
					$('#Bloquear').fadeOut(500);
				</script>    
				<?
				exit;
			}
		
		while ($reg=mssql_fetch_array($registros)){
			$OPE = $reg['OPE'];
		}
	
	
	if($OPE == 0){
		?>
		<script>
			$("#BotonesPri").load("BotonesPri.php");
			jAlert('No Hay Turnos Abiertos para Trabajar.', 'Debo Retail - Global Business Solution');
			$('#Bloquear').fadeOut(500);
		</script>
		<? 
	}else{ 

	?>
	<script>

		jAlert('El módulo Cheques no se encuentra habilitado.', 'Debo Retail - Global Business Solution');
		$('#Bloquear').fadeOut(500);
/*
		$("#SobreFoca").fadeOut(400);
		
		$("#ChequesCar").load("ChequesCar.php");
		Mos_Ocu("ChequesCar");
*/				
		document.getElementById('AccBotPriDis<? echo $a; ?>').disabled = false;

	</script>
	<?
	}
break;
/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
case 5:
	$SQL = "SELECT OPE FROM APARPOS WHERE ID = '".$_SESSION["ParPOS"]."'";
	
		$registros = mssql_query($SQL) or die("Error SQL");
		
			if(mssql_num_rows($registros) == 0){
				?>
				<script>
					$("#BotonesPri").load("BotonesPri.php");
					jAlert('No esta Configurado la Terminal', 'Debo Retail - Global Business Solution');
					$('#Bloquear').fadeOut(500);
				</script>    
				<?
				exit;
			}
		
		while ($reg=mssql_fetch_array($registros)){
			$OPE = $reg['OPE'];
		}
	
	
	if($OPE == 0){
		?>
		<script>
			$("#BotonesPri").load("BotonesPri.php");
			jAlert('No Hay Turnos Abiertos para Trabajar.', 'Debo Retail - Global Business Solution');
			$('#Bloquear').fadeOut(500);
		</script>
		<?
	}else{ 

	?>
	<script>
		
		$("#BotonesPri").fadeOut(400);
		$("#SobreFoca").fadeOut(400);
		
		$("#Tarjetas").load("Tarjetas.php");
		
		Mos_Ocu("Tarjetas");

		document.getElementById('AccBotPriDis<? echo $a; ?>').disabled = false;

	</script>
	<?
	}
break;
/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
case 6:
	$SQL = "SELECT OPE FROM APARPOS WHERE ID = '".$_SESSION["ParPOS"]."'";
	
		$registros = mssql_query($SQL) or die("Error SQL");
		
			if(mssql_num_rows($registros) == 0){
				?>
				<script>
					$("#BotonesPri").load("BotonesPri.php");
					jAlert('No esta Configurado la Terminal', 'Debo Retail - Global Business Solution');
					$('#Bloquear').fadeOut(500);
				</script>    
				<?
				exit;
			}
		
		while ($reg=mssql_fetch_array($registros)){
			$OPE = $reg['OPE'];
		}
	
	
	if($OPE == 0){
		?>
		<script>
			$("#BotonesPri").load("BotonesPri.php");
			jAlert('No Hay Turnos Abiertos para Trabajar.', 'Debo Retail - Global Business Solution');
			$('#Bloquear').fadeOut(500);
		</script>
		<?
	}else{ 

	?>
	<script>
		
		$("#BotonesPri").fadeOut(400);
		$("#SobreFoca").fadeOut(400);
		
		$("#RetiroEfectivo").load("RetEfe.php");
		
		Mos_Ocu("RetiroEfectivo");
		
		document.getElementById('AccBotPriDis<? echo $a; ?>').disabled = false;
		
	</script>
	<?
	}
break;
/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
case 7:

	$_SESSION['ParSQL'] = "SELECT TOP 11 PLA, TUR, MTN, FAP, FCT, OPE, OBS_EFE_REC FROM ATURNOSO where CER = 'C' AND PLC = 'N' ORDER BY PLA DESC";
	$ATURNOSO = mssql_query($_SESSION['ParSQL']) or die("Error SQL");
	rollback($ATURNOSO);
	$cc = mssql_num_rows($ATURNOSO);

	if(mssql_num_rows($ATURNOSO) == 0){
			
		?>
		<script>
			$("#BotonesPri").load("BotonesPri.php");
			jAlert('No Hay Turnos Cerrados.', 'Debo Retail - Global Business Solution');
			$('#Bloquear').fadeOut(500);
		</script>
		<?
		exit;
		
	}else{ 

		?>
		<script>
	
			$("#BotonesPri").fadeOut(400);
			$("#SobreFoca").fadeOut(400);
	
			$("#Confirmar").load("MCaja.php");
			
			Mos_Ocu("Confirmar");
			
			Mos_Ocu('fondotranspletras');
			Mos_Ocu('TecladoLet');
			Mos_Ocu('fondotranspnumeros');
			Mos_Ocu('TecladoNum');
			
			SoloNone('Marca, LetEnt, LetTer, NumVolPro');
			
			document.getElementById('AccBotPriDis<? echo $a; ?>').disabled = false;
			
			document.getElementById("DondeE").value = "evitarcaracteres";
			document.getElementById("CantiE").value = "0";
			document.getElementById("QuePoE").value = "1";
			
		</script>
		<?
	}
	
break;
/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
case 9:
	$SQL = "SELECT OPE FROM APARPOS WHERE ID = '".$_SESSION["ParPOS"]."'";
	
		$registros = mssql_query($SQL) or die("Error SQL");
		
			if(mssql_num_rows($registros) == 0){
					?>
					<script>
						$("#BotonesPri").load("BotonesPri.php");
						jAlert('No esta Configurado la Terminal', 'Debo Retail - Global Business Solution');
						$('#Bloquear').fadeOut(500);
					</script>
					<?
				exit;
			}
		
			while ($reg=mssql_fetch_array($registros)){
				$OPE = $reg['OPE'];
			}

	if($OPE == 0){
		?>
		<script>
			$("#BotonesPri").load("BotonesPri.php");
			jAlert('No Hay Turnos Abiertos para Trabajar.', 'Debo Retail - Global Business Solution');
			$('#Bloquear').fadeOut(500);
		</script>
		<?
	}else{ 
	
			if($OPE != $_SESSION["idsusua"]){
				?>
				<script>
					$("#BotonesPri").load("BotonesPri.php");
					jAlert('Usted no es el operario que abrio el turno. No puede ingresar.', 'Debo Retail - Global Business Solution');
					$('#Bloquear').fadeOut(500);
				</script>    
				<?
				exit;
			}	
	
	?>
	<script>
	
		document.getElementById('AccBotPriDis<? echo $a; ?>').disabled = false;

		$('#TecladoNum').attr({
		   'style': 'top:28px',
		});
		
		$('#NumVol').attr({
		   'style': 'left:747px; display:block;'
		});
					
		var nocargar = document.getElementById("YaFacCo").value;
		if(nocargar==1){
			
			SoloNone('FacturadorMa, Facturador, NumVol, Marca, BotMins, BotMins1, ProcesoSusp');
			SoloBlock('BotMins2, fondotranspletras, TecladoLet, TecladoNum, fondotranspnumeros, NumAre, NumTexDiv, LetTer');
			
			//////////////////////////////////////////////////
			LeerCookies(3); //////////////////////////////////
			//////////////////////////////////////////////////

			SoloBlock('Compras');

		}else{

			Mos_Ocu("Compras");

			document.getElementById("YaFacCo").value = 1;
			document.getElementById("YaFac").value = 2;
	
			document.getElementById("LetSal").innerHTML = '<button onclick="SalirCompras();" class="StyBoton" onmouseout="MM_swapImgRestore()" onmouseover="MM_swapImage(\'LetSalcomocom\',\'\',\'botones/sal-over.png\',0)"><img src="botones/sal-up.png" name="Salir" title="Salir" border="0" id="LetSalcomocom"/></button>';
	
			document.getElementById("LetEnt").innerHTML = '<button class="StyBoton" onclick="MosPro();" onmouseout="MM_swapImgRestore()" onmouseover="MM_swapImage(\'LetEntFaccomcom\',\'\',\'botones/ent-over.png\',0)"><img src="botones/ent-up.png" name="Enter" title="Enter" border="0" id="LetEntFaccomcom"/></button>';
						
			document.getElementById("LetTer").innerHTML = '';

			document.getElementById("NumVol").innerHTML = '';
			
			EnvAyuda('Ingrese proveedor. Enter para buscar.');
			
			document.getElementById("DondeE").value = "EDat3";
			document.getElementById("CantiE").value = "5";
			document.getElementById("QuePoE").value = "1";
		
			SoloNone('FacturadorMa, Facturador, NumVol, LetTer, Marca, BotMins, BotMins1, ProcesoSusp');
			SoloBlock('BotMins2, fondotranspletras, TecladoLet, TecladoNum, fondotranspnumeros, NumAre, NumTexDiv, LetSal, LetEnt');
			
			///////////////////////////////////////////
			EscrCookies();/////////////////////////////
			///////////////////////////////////////////
			
		}

		$("#BotonesPri").fadeOut(400);
		$("#SobreFoca").fadeOut(400);
			
	</script>
	<?
	}
	
break;
/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
case 12:
	$SQL = "SELECT OPE FROM APARPOS WHERE ID = '".$_SESSION["ParPOS"]."'";
	
		$registros = mssql_query($SQL) or die("Error SQL");
		
			if(mssql_num_rows($registros) == 0){
				?>
				<script>
					$("#BotonesPri").load("BotonesPri.php");
					jAlert('No esta Configurado la Terminal', 'Debo Retail - Global Business Solution');
					$('#Bloquear').fadeOut(500);
				</script>    
				<?
				exit;
			}
		
		while ($reg=mssql_fetch_array($registros)){
			$OPE = $reg['OPE'];
		}
	
	
	if($OPE == 0){
		?>
		<script>
			$("#BotonesPri").load("BotonesPri.php");
			jAlert('No Hay Turnos Abiertos para Trabajar.', 'Debo Retail - Global Business Solution');
			$('#Bloquear').fadeOut(500);
		</script>
		<? 
	}else{ 

	?>
	<script>
		
		$("#BotonesPri").fadeOut(400);
		$("#SobreFoca").fadeOut(400);
		
		$("#Movimientos").load("Movimientos.php");
		
		Mos_Ocu("Movimientos");
		
		document.getElementById('AccBotPriDis<? echo $a; ?>').disabled = false;
		
	</script>
	<?
	}
	
break;
/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
case 13:
	$SQL = "SELECT OPE FROM APARPOS WHERE ID = '".$_SESSION["ParPOS"]."'";
	
		$registros = mssql_query($SQL) or die("Error SQL");
		
			if(mssql_num_rows($registros) == 0){
				?>
				<script>
					$("#BotonesPri").load("BotonesPri.php");
					jAlert('No esta Configurado la Terminal', 'Debo Retail - Global Business Solution');
					$('#Bloquear').fadeOut(500);
				</script>
				<?
				exit;
			}
		
		while ($reg=mssql_fetch_array($registros)){
			$OPE = $reg['OPE'];
		}
	
	
	if($OPE == 0){
		?>
		<script>
			$("#BotonesPri").load("BotonesPri.php");
			jAlert('No Hay Turnos Abiertos para Trabajar.', 'Debo Retail - Global Business Solution');
			$('#Bloquear').fadeOut(500);
		</script>
		<?
	}else{ 

	?>
	<script>

		$("#BotonesPri").fadeOut(400);
		$("#SobreFoca").fadeOut(400);

		$("#CoIdPe").load("CoIdPe.php");
		
		Mos_Ocu("CoIdPe");
		
		SoloBlock('Marca, fondotranspletras, TecladoLet, fondotranspnumeros, TecladoNum, LetEnt, NumVol, LetSal');
		SoloNone("LetTer");
		
		EnvAyuda("Ingrese su contrasena actual");
		
		document.getElementById('AccBotPriDis<? echo $a; ?>').disabled = false;
		
	</script>
	<?
	}
break;
/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
case 14:
	$SQL = "SELECT OPE FROM APARPOS WHERE ID = '".$_SESSION["ParPOS"]."'";
	
		$registros = mssql_query($SQL) or die("Error SQL");
		
			if(mssql_num_rows($registros) == 0){
				?>
				<script>
					$("#BotonesPri").load("BotonesPri.php");
					jAlert('No esta Configurado la Terminal', 'Debo Retail - Global Business Solution');
					$('#Bloquear').fadeOut(500);
				</script>
				<?
				exit;
			}
		
		while ($reg=mssql_fetch_array($registros)){
			$OPE = $reg['OPE'];
		}
	
	
	if($OPE == 0){
		?>
		<script>
			$("#BotonesPri").load("BotonesPri.php");
			jAlert('No Hay Turnos Abiertos para Trabajar.', 'Debo Retail - Global Business Solution');
			$('#Bloquear').fadeOut(500);
		</script>
		<?
	}else{ 

	?>
	<script>

		$("#BotonesPri").fadeOut(400);
		$("#SobreFoca").fadeOut(400);

		$("#TicketEM").load("TicketEM.php");
		
		Mos_Ocu("TicketEM");
		
		document.getElementById('AccBotPriDis<? echo $a; ?>').disabled = false;
		
	</script>
	<?
	}
break;
/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
case 15:
	$SQL = "SELECT OPE FROM APARPOS WHERE ID = '".$_SESSION["ParPOS"]."'";
	
		$registros = mssql_query($SQL) or die("Error SQL");
		
			if(mssql_num_rows($registros) == 0){
				?>
				<script>
					$("#BotonesPri").load("BotonesPri.php");
					jAlert('No esta Configurado la Terminal', 'Debo Retail - Global Business Solution');
					$('#Bloquear').fadeOut(500);
				</script>    
				<?
				exit;
			}
		
		while ($reg=mssql_fetch_array($registros)){
			$OPE = $reg['OPE'];
		}
	
	
	if($OPE == 0){
		?>
		<script>
			$("#BotonesPri").load("BotonesPri.php");
            jAlert('No Hay Turnos Abiertos para Trabajar.', 'Debo Retail - Global Business Solution');
            $('#Bloquear').fadeOut(500);
        </script>
        <? 
	}else{ 

	?>
	<script>
	
		$("#BotonesPri").fadeOut(400);
		$("#SobreFoca").fadeOut(400);

		$("#Gastos").load("Gastos.php");

		Mos_Ocu("Gastos");
		
		document.getElementById('AccBotPriDis<? echo $a; ?>').disabled = false;
		
	</script>
	<?
	}
break;
/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
case 17:
	$SQL = "SELECT OPE FROM APARPOS WHERE ID = '".$_SESSION["ParPOS"]."'";
	
		$registros = mssql_query($SQL) or die("Error SQL");
		
			if(mssql_num_rows($registros) == 0){
				?>
				<script>
					$("#BotonesPri").load("BotonesPri.php");
					jAlert('No esta Configurado la Terminal', 'Debo Retail - Global Business Solution');
					$('#Bloquear').fadeOut(500);
				</script>    
				<?
				exit;
			}
		
		while ($reg=mssql_fetch_array($registros)){
			$OPE = $reg['OPE'];
		}
	
	
	if($OPE == 0){
		
		?>
		<script>
			$("#BotonesPri").load("BotonesPri.php");
			jAlert('No Hay Turnos Abiertos para Trabajar.', 'Debo Retail - Global Business Solution');
			$('#Bloquear').fadeOut(500);
		</script>
		<? 
		
	}else{ 

	?>
	<script>
	

		$("#BotonesPri").fadeOut(400);
		$("#SobreFoca").fadeOut(400);

		$("#NaNb").load("NaNb.php");
		
		SoloNone("BotonesPri, NumVol, LetTer");
		SoloBlock('NaNb');
	
/*
		$("#BotonesPri").fadeOut(400);
		$("#SobreFoca").fadeOut(400);
		
		$("#TomaInv").load("TomaInv.php");
		
		SoloNone("BotonesPri, Marca, SobreFoca, NumVol, LetTer");	
		SoloBlock('fondotranspletras, TecladoLet, fondotranspnumeros, TecladoNum, LetEnt, TomaInv, LetSal');

		document.getElementById("DondeE").value = "";
		
		document.getElementById("LetSal").innerHTML = '<button class="StyBoton" onclick="salir_tom();" onmouseout="MM_swapImgRestore()" onmouseover="MM_swapImage(\'LetSalTomInv\',\'\',\'botones/sal-over.png\',0)"><img src="botones/sal-up.png" name="Salir" title="Salir" border="0" id="LetSalTomInv"/></button>';
		
		document.getElementById("LetEnt").innerHTML = '<button onclick="trae_num_inv();" class="StyBoton" onmouseout="MM_swapImgRestore()" onmouseover="MM_swapImage(\'LetEntTomInve\',\'\',\'botones/ent-over.png\',0)"><img src="botones/ent-up.png" name="Enter" title="Enter" border="0" id="LetEntTomInve"/></button>';
*/		
		document.getElementById('AccBotPriDis<? echo $a; ?>').disabled = false;
	
	</script>
	<?
	}
break;
/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
case 18:
	$SQL = "SELECT OPE FROM APARPOS WHERE ID = '".$_SESSION["ParPOS"]."'";
	
		$registros = mssql_query($SQL) or die("Error SQL");
		
			if(mssql_num_rows($registros) == 0){
				?>
				<script>
					$("#BotonesPri").load("BotonesPri.php");
					jAlert('No esta Configurado la Terminal', 'Debo Retail - Global Business Solution');
					$('#Bloquear').fadeOut(500);
				</script>    
				<?
				exit;
			}
		
		while ($reg=mssql_fetch_array($registros)){
			$OPE = $reg['OPE'];
		}
	
	
	if($OPE == 0){
	?>
	<script>
		$("#BotonesPri").load("BotonesPri.php");
		jAlert('No Hay Turnos Abiertos para Trabajar.', 'Debo Retail - Global Business Solution');
		$('#Bloquear').fadeOut(500);
	</script>
	<? 
	}else{ 

	?>
	<script>

		$("#BotonesPri").fadeOut(400);
		$("#SobreFoca").fadeOut(400);
		
		$("#CargaInv").load("CargaInv.php");
		
		SoloNone("BotonesPri, Marca, LetTer, NumVol, SobreFoca");
		SoloBlock('fondotranspletras, TecladoLet, fondotranspnumeros, TecladoNum, LetEnt, CargaInv, LetSal');
		
		EnvAyuda("Ingrese el n&uacute;mero de Inventario que desea cargar");
		
		document.getElementById("DondeE").value = "inv";
		document.getElementById("CantiE").value = "6";
		document.getElementById("QuePoE").value = "6";
		
		document.getElementById("LetSal").innerHTML = '<button class="StyBoton" onclick="salir_carga();" onmouseout="MM_swapImgRestore()" onmouseover="MM_swapImage(\'LetSalTomInv\',\'\',\'botones/sal-over.png\',0)"><img src="botones/sal-up.png" name="Salir" title="Salir" border="0" id="LetSalTomInv"/></button>';
		
		document.getElementById("LetEnt").innerHTML = '<button onclick="busca_num_inv();" class="StyBoton" onmouseout="MM_swapImgRestore()" onmouseover="MM_swapImage(\'LetEntTomInve\',\'\',\'botones/ent-over.png\',0)"><img src="botones/ent-up.png" name="Enter" title="Enter" border="0" id="LetEntTomInve"/></button>';
		
		document.getElementById("LetTer").innerHTML = '<button onclick="genera_pdf();" class="StyBoton" onmouseout="MM_swapImgRestore()" onmouseover="MM_swapImage(\'LetTerCarInv\',\'\',\'botones/ter-over.png\',0)"><img src="botones/ter-up.png" name="Terminar" title="Terminar" border="0" id="LetTerCarInv"/></button>';
		
		document.getElementById('AccBotPriDis<? echo $a; ?>').disabled = false;
	
	</script>
	<?
	}
break;
/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
case 20:
	$SQL = "SELECT OPE FROM APARPOS WHERE ID = '".$_SESSION["ParPOS"]."'";
	
		$registros = mssql_query($SQL) or die("Error SQL");
		
			if(mssql_num_rows($registros) == 0){
				?>
				<script>
					$("#BotonesPri").load("BotonesPri.php");
					jAlert('No esta Configurado la Terminal', 'Debo Retail - Global Business Solution');
					$('#Bloquear').fadeOut(500);
				</script>    
				<?
				exit;
			}
		
		while ($reg=mssql_fetch_array($registros)){
			$OPE = $reg['OPE'];
		}
	
	
	if($OPE == 0){
	?>
	<script>
		$("#BotonesPri").load("BotonesPri.php");
		jAlert('No Hay Turnos Abiertos para Trabajar.', 'Debo Retail - Global Business Solution');
		$('#Bloquear').fadeOut(500);
	</script>
	<? 
	}else{ 

	?>
	<script>

		$("#Arqueo").load("Arqueo.php");
		
		SoloNone("BotonesPri, NumVol, LetTer, SobreFoca");
		
		SoloBlock("Marca, fondotranspletras, TecladoLet, fondotranspnumeros, TecladoNum, Arqueo, LetEnt, LetSal");	

		document.getElementById("LetSal").innerHTML = '<button class="StyBoton" onclick="salir_arq();" onmouseout="MM_swapImgRestore()" onmouseover="MM_swapImage(\'LetSalArq\',\'\',\'botones/sal-over.png\',0)"><img src="botones/sal-up.png" name="Salir" title="Salir" border="0" id="LetSalArq"/></button>';
	</script>
	<?
	}
break;
/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
case 21:
	$SQL = "SELECT OPE FROM APARPOS WHERE ID = '".$_SESSION["ParPOS"]."'";
	
		$registros = mssql_query($SQL) or die("Error SQL");
		
			if(mssql_num_rows($registros) == 0){
				?>
				<script>
					$("#BotonesPri").load("BotonesPri.php");
					jAlert('No esta Configurado la Terminal', 'Debo Retail - Global Business Solution');
					$('#Bloquear').fadeOut(500);
				</script>
				<?
				exit;
			}
		
		while ($reg=mssql_fetch_array($registros)){
			$OPE = $reg['OPE'];
		}
	
	
	if($OPE == 0){
		?>
		<script>
			$("#BotonesPri").load("BotonesPri.php");
			jAlert('No Hay Turnos Abiertos para Trabajar.', 'Debo Retail - Global Business Solution');
			$('#Bloquear').fadeOut(500);
		</script>
		<? 
	}else{ 

	?>
	<script>

		$("#BotonesPri").fadeOut(400);
		$("#SobreFoca").fadeOut(400);

		$("#Novedades").load("Novedades.php");
		
		Mos_Ocu("Novedades");

		document.getElementById('AccBotPriDis<? echo $a; ?>').disabled = false;
		
	</script>
	<?
	}
break;
/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
case 22:
	$SQL = "SELECT OPE FROM APARPOS WHERE ID = '".$_SESSION["ParPOS"]."'";
	
		$registros = mssql_query($SQL) or die("Error SQL");
		
			if(mssql_num_rows($registros) == 0){
				?>
				<script>
					$("#BotonesPri").load("BotonesPri.php");
					jAlert('No esta Configurado la Terminal', 'Debo Retail - Global Business Solution');
					$('#Bloquear').fadeOut(500);
				</script>    
				<?
				exit;
			}
		
		while ($reg=mssql_fetch_array($registros)){
			$OPE = $reg['OPE'];
		}
	
	
	if($OPE == 0){
		?>
		<script>
			$("#BotonesPri").load("BotonesPri.php");
			jAlert('No Hay Turnos Abiertos para Trabajar.', 'Debo Retail - Global Business Solution');
			$('#Bloquear').fadeOut(500);
		</script>
		<? 
	}else{ 

	?>
	<script>
		
		$("#BotonesPri").fadeOut(400);
		$("#SobreFoca").fadeOut(400);
		
		$("#Recuento").load("Recuento.php");
		
		SoloBlock('Recuento, Marca, fondotranspletras, TecladoLet, fondotranspnumeros, TecladoNum, LetEnt, NumVol, LetSal');
		SoloNone('BotonesPri, LetTer');

		EnvAyuda("Ingrese un importe y presione Enter");		
		
		document.getElementById("DondeE").value = "importe";
		document.getElementById("CantiE").value = "7";
		document.getElementById("QuePoE").value = "6";
		
		document.getElementById("LetSal").innerHTML = '<button class="StyBoton" onclick="salir_rec();" onmouseout="MM_swapImgRestore()" onmouseover="MM_swapImage(\'LetSalRec\',\'\',\'botones/sal-over.png\',0)"><img src="botones/sal-up.png" name="Salir" title="Salir" border="0" id="LetSalRec"/></button>';
		
		document.getElementById("LetEnt").innerHTML = '<button onclick="siguiente_rec();" class="StyBoton" onmouseout="MM_swapImgRestore()" onmouseover="MM_swapImage(\'LetEntRec\',\'\',\'botones/ent-over.png\',0)"><img src="botones/ent-up.png" name="Enter" title="Enter" border="0" id="LetEntRec"/></button>';
		
		document.getElementById("NumVol").innerHTML = '<button onclick="siguiente_rec();" class="StyBoton" onmouseout="MM_swapImgRestore()" onmouseover="MM_swapImage(\'LetVolRec\',\'\',\'botones/ent-over.png\',0)"><img src="botones/ent-up.png" name="Enter" title="Enter" border="0" id="LetVolRec"/></button>';
		
		document.getElementById('AccBotPriDis<? echo $a; ?>').disabled = false;
		
	</script>
	<?
	}
break;
/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
case 24:
	$SQL = "SELECT OPE FROM APARPOS WHERE ID = '".$_SESSION["ParPOS"]."'";
	
		$registros = mssql_query($SQL) or die("Error SQL");
		
		if(mssql_num_rows($registros) == 0){
			?>
			<script>
				$("#BotonesPri").load("BotonesPri.php");
				jAlert('No esta Configurado la Terminal', 'Debo Retail - Global Business Solution');
				$('#Bloquear').fadeOut(500);
			</script>    
			<?
			exit;
		}
		
		while ($reg=mssql_fetch_array($registros)){
			$OPE = $reg['OPE'];
		}
		
	if($OPE == 0){
		?>
		<script>
			$("#BotonesPri").load("BotonesPri.php");
			jAlert('No Hay Turnos Abiertos para Trabajar.', 'Debo Retail - Global Business Solution');	
			$('#Bloquear').fadeOut(500);
		</script>
		<?
	}else{
		
		
		if($OPE != $_SESSION["idsusua"]){
			?>
			<script>
				$("#BotonesPri").load("BotonesPri.php");
				jAlert('Usted no es el operario que abrio el turno. No puede ingresar.', 'Debo Retail - Global Business Solution');
				$('#Bloquear').fadeOut(500);
			</script>    
			<?
			exit;
		}	

		$_SESSION['ParSQL'] = "SELECT PVE FROM ACONF_PVEMANU WHERE POS = ".$_SESSION['ParPOS'];
		$ACONF_PVEMANU = mssql_query($_SESSION['ParSQL']) or die("Error SQL");
		rollback($ACONF_PVEMANU);
		if(mssql_num_rows($ACONF_PVEMANU) == 0){
			?>
			<script>
                $("#BotonesPri").load("BotonesPri.php");
                jAlert('No Hay configurado punto de venta manual para Trabajar.', 'Debo Retail - Global Business Solution');	
                $('#Bloquear').fadeOut(500);
            </script>
            <?
			exit;
		}
		mssql_free_result($ACONF_PVEMANU);
		
			
	$_SESSION['ParFacSec'] = 2;	
	?>
	<script>
		
		document.getElementById('AccBotPriDis<? echo $a; ?>').disabled = false;	

		$('#TecladoNum').attr({
		   'style': 'top:28px',
		});
		
		$('#NumVol').attr({
		   'style': 'left:747px; display:block;'
		});
	
	//////////////////// para ingresar el codigo de barra ////////////////////////////////////////////////////
		document.getElementById("LetTexDiv").innerHTML = '<form id="MaConReCodigo" name="MaConReCodigo" method="post" onsubmit="return MaReeCodigo();"><input type="text" name="LetTex" id="LetTex" style="outline-style:none; border-style:none; text-transform:uppercase; font-family:\'TPro\'; font-size:14px;" onkeypress="return MaControlDeEnvioLetTexPres();" onkeydown="return MaControlDeEnvioLetTexDown();" /></form>';		
	//////////////////////////////////////////////////////////////////////////////////////////////////////////
	//////////////////// para ingresar cantidad de producto //////////////////////////////////////////////////
		document.getElementById("NumTexDiv").innerHTML = '<input type="text" name="NumTex" id="NumTex" maxlength="10" style="outline-style:none; border-style:none;" onkeypress="return MaEnviar_XEnter();"/>';
	//////////////////////////////////////////////////////////////////////////////////////////////////////////
		
		var nocargar = document.getElementById("YaFacMa").value;
		if(nocargar==1){

			SoloNone("Facturador, Compras, Marca, BotMins, BotMins2, LetTer, ProcesoSusp");
			SoloBlock("fondotranspletras, TecladoLet, fondotranspnumeros, TecladoNum, BotMins1, NumVol, NumAre, NumTexDiv");
			
			//////////////////////////////////////////////////
			LeerCookies(2); //////////////////////////////////
			//////////////////////////////////////////////////
	
			SoloBlock('FacturadorMa');		
			
			//////////////////////////////////////////////////////////////////////
			$("#"+document.getElementById("DondeE").value).focus(); //////////////
			//////////////////////////////////////////////////////////////////////

		}else{

			Mos_Ocu('FacturadorMa');

			document.getElementById("YaFacMa").value = 1;
			document.getElementById("YaFac").value = 3;

				
			document.getElementById('LetTex').value = "";		
			document.getElementById("DondeE").value = "LetTex";
			document.getElementById("CantiE").value = "50";
			document.getElementById("QuePoE").value = "0";
			
			document.getElementById("LetSal").innerHTML = '<button onclick="MaAccBotFac(10);" class="StyBoton" onmouseout="MM_swapImgRestore()" onmouseover="MM_swapImage(\'LetSalFacm\',\'\',\'botones/sal-over.png\',0)"><img src="botones/sal-up.png" name="Salir" title="Salir" border="0" id="LetSalFacm"/></button>';
								
			document.getElementById("LetEnt").innerHTML = '<button onclick="MaReeCodigo();" class="StyBoton" onmouseout="MM_swapImgRestore()" onmouseover="MM_swapImage(\'LetEntFac\',\'\',\'botones/ent-over.png\',0)"><img src="botones/ent-up.png" name="Enter" title="Enter" border="0" id="LetEntFac"/></button>';

			document.getElementById("LetTer").innerHTML = '<button onclick="MaTerminarVul();" class="StyBoton" onmouseout="MM_swapImgRestore()" onmouseover="MM_swapImage(\'LetTerFac\',\'\',\'botones/ter-over.png\',0)"><img src="botones/ter-up.png" name="Terminar" title="Terminar" border="0" id="LetTerFac"/></button>';
						
			document.getElementById("NumVol").innerHTML = '<button onclick="MaReeCodigo();" class="StyBoton" onmouseout="MM_swapImgRestore()" onmouseover="MM_swapImage(\'LetEntFac2\',\'\',\'botones/ent-over.png\',0)"><img src="botones/ent-up.png" name="Enter" title="Enter" border="0" id="LetEntFac2"/></button>';
	
			EnvAyuda('Ingrese código de barras o realice una búsqueda.');
			
			$("#LetTex").focus();
		
			SoloNone("Facturador, Compras, Marca, BotMins, BotMins2, LetTer, ProcesoSusp");
			SoloBlock("fondotranspletras, TecladoLet, fondotranspnumeros, TecladoNum, BotMins1, NumVol, NumAre, NumTexDiv");

			///////////////////////////////////////////
			EscrCookies();/////////////////////////////
			///////////////////////////////////////////

		}
		
		$("#BotonesPri").fadeOut(400);
		$("#SobreFoca").fadeOut(400);

		if(document.getElementById('TarPorFacFor')){
					
			document.getElementById('TarPorFacFor').value = document.getElementById('cTarPorFac').value;

		}
	
	</script>
	<?
	}

break;
/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
case 23:
	?>
    <script>
		$("#archivos").load("salir.php");
		timerID = setTimeout("fun()", 1000);
	</script>
	<?
break;
/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////

	default:
		?>
		<script>
			$("#BotonesPri").load("BotonesPri.php");
			jAlert('Mal Configurado, default', 'Debo Retail - Global Business Solution');
			$('#Bloquear').fadeOut(500);
		</script>
		<?
	break;

}


mssql_query("commit transaction") or die("Error SQL commit");

	?>
	<script>
		SoloNone("Bloquear");
	</script>
	<?

}catch(Exception $e){////////////////////////////////////////////////////////////////////////////////////////////////// FIN DE TRY //
	
	?>
	<script>
		jAlert('ERORR Reintente la operacion solicitada.', 'Debo Retail - Global Business Solution');
	</script>
	<?
exit;

}
?>