<?
require("config/cnx.php");


try {////////////////////////////////////////////////////////////////////////////////////////////////// COMIENZO TRY //


mssql_query("begin transaction",$conexion) or die("Error SQL begin trans");


if(isset($_REQUEST['cli'])){

///////////////////////////////////////////////////////
///////// PARA FAC MANUAL /////////////////////////////
///////////////////////////////////////////////////////
//SESSION
if($_SESSION['ParFacSec'] == 1){
	$TER = $_SESSION['ParPOS'];
}
if($_SESSION['ParFacSec'] == 2){
	$TER = $_SESSION['ParPOSMa'];
}
///////////////////////////////////////////////////////
///////////////////////////////////////////////////////
///////////////////////////////////////////////////////
//SESSION
$LISTA = $_SESSION['iListaBO'];
$ParCosto_Pb = $_SESSION['ParCosto_Pb'];
$IVAG = $_SESSION['ParIVAG'];
//SESSION
$ZON = $_SESSION['ParEMP'];
$OPE = $_SESSION['idsusua'];
$LUG = $_SESSION['ParLUG'];
$SUC = $_SESSION['ParPV'];


//REQUEST
$CLI = $_REQUEST['cli'];


///////////////////////////////////////////////////////
///////// PARA FAC MANUAL /////////////////////////////
///////////////////////////////////////////////////////
//SESSION
if($_SESSION['ParFacSec'] == 1){
	$_SESSION['ParOrn'] = 0;
	$_SESSION['ParCol'] = 0;
	
	?>
	<script>
	
		$("#Monedas").load("MMon.php?tot=0");
		
		Mos_Ocu('MiProd');
		Mos_Ocu('Tiquet');
		Mos_Ocu('FacTotal');
		SoloNone('MedioP, Cotizacion');
		
		document.getElementById('mostrar').innerHTML = '';
		document.getElementById('micapa1').innerHTML = '';
		document.getElementById('TiquetItem').innerHTML = '';
		
		document.getElementById('ComenzarTic').value = 0;
		document.getElementById('total').value = "0.00";
		document.getElementById('VUL').value = "";
		document.getElementById('PAG').value = "";
		document.getElementById("TARJ").value = 0;
		
		cancvuel();
		
		Mos_Ocu('LetSal');
		Mos_Ocu('LetEnt');
		Mos_Ocu('NumVol');
	
	</script>
	<?
}
if($_SESSION['ParFacSec'] == 2){
	$_SESSION['ParOrnMa'] = 0;
	$_SESSION['ParColMa'] = 0;
	
	?>
	<script>

		$("#MaMonedas").load("MMon.php?tot=0");
			
		Mos_Ocu('MaMiProd');
		Mos_Ocu('MaTiquet');
		Mos_Ocu('MaFacTotal');
		SoloNone('MaMedioP, MaCotizacion');
		
		document.getElementById('Mamostrar').innerHTML = '';
		document.getElementById('Mamicapa1').innerHTML = '';
		document.getElementById('MaTiquetItem').innerHTML = '';
		
		document.getElementById('MaComenzarTic').value = 0;
		document.getElementById('Matotal').value = "0.00";
		document.getElementById('MaVUL').value = "";
		document.getElementById('MaPAG').value = "";
		
		Macancvuel()
		
		Mos_Ocu('LetSal');
		Mos_Ocu('LetEnt');
		Mos_Ocu('NumVol');
	
	</script>
	<?
}
///////////////////////////////////////////////////////
///////////////////////////////////////////////////////
///////////////////////////////////////////////////////



	$_SESSION['ParSQL'] = "UPDATE TMAEFACT_T SET CLI = ".$CLI.", TER = TER + 2000  WHERE TER = ".$TER;
	$TMAEFACT_T = mssql_query($_SESSION['ParSQL']) or die("Error SQL");
	rollback($TMAEFACT_T);

	

	$TER2 = $TER + 2000;

	$SQL = "SELECT CLI FROM TMAEFACT_T WHERE TER = ".$TER2;
	$TMOVFACT_T = mssql_query($SQL) or die("Error SQL");
	while ($TMOV_R=mssql_fetch_array($TMOVFACT_T)){
		$CLI = $TMOV_R['CLI'];
	}

	$SQL = "SELECT SEC, ART, CAN, ESC, COL FROM TMOVFACT_T WHERE TER = ".$TER2." ORDER BY ORD";
	$TMOVFACT_T = mssql_query($SQL) or die("Error SQL");
	while ($TMOV_R=mssql_fetch_array($TMOVFACT_T)){
	
		$SEC = $TMOV_R['SEC'];
		$ART = $TMOV_R['ART'];
		$CAN = $TMOV_R['CAN'];		
		$ESC = $TMOV_R['ESC'];
		$COL = $TMOV_R['COL'];
		
		$cantc = $CAN ;
		$CodSec = format($SEC,2,'0',STR_PAD_LEFT);
		$CodArt = format($ART,4,'0',STR_PAD_LEFT);
		
		//////////////////////////////////////////				

		$MCDPRO = 1;
		
		$FechaGrabar = "'".date("Ymd H:i:s")."'";
			
			
				$_SESSION['ParSQL'] = "
				SELECT C.NplVen AS PLA, D.FAP AS FAP, A.MTN, A.DES, A.INI, A.FIN FROM ATURNOSH AS A 
				INNER JOIN APARPOS AS B ON B.ID = '".$_SESSION['ParPOS']."'
				INNER JOIN VENDEDORES AS C ON C.CodVen = B.OPE
				INNER JOIN ATURNOSO AS D ON D.PLA = C.NplVen
				WHERE A.MTN = D.MTN
				";
				
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
			
			if($ESC == 0){
			if($_SESSION['ParFacSec'] == 1){
				$_SESSION['ParOrn'] = $_SESSION['ParOrn'] + 1;
				$_SESSION['ParCol'] = $_SESSION['ParCol'] + 1;
				$ParOrnVal = $_SESSION['ParOrn'];
				$ParColVal = $_SESSION['ParCol'];
			}
			if($_SESSION['ParFacSec'] == 2){
				$_SESSION['ParOrnMa'] = $_SESSION['ParOrnMa'] + 1;
				$_SESSION['ParColMa'] = $_SESSION['ParColMa'] + 1;
				$ParOrnVal = $_SESSION['ParOrnMa'];
				$ParColVal = $_SESSION['ParColMa'];
			}
			}
			if($ParOrnVal == 1){
				
					$_SESSION['ParSQL'] = "
					SELECT A.IVA, A.NOM, A.CUIT, A.TIP, A.TCO, A.FPA, B.NOMBRE AS FPAN FROM CLIENTES AS A INNER JOIN FDPAGO AS B ON A.FPA = B.ID WHERE COD = ".$CLI."";
					$CLIENTES = mssql_query($_SESSION['ParSQL']) or die("Error SQL");
					rollback($CLIENTES);
					while ($CLIEN=mssql_fetch_array($CLIENTES)){
				
						$TIV = $CLIEN['IVA'];
						$TIP = $CLIEN['TIP'];
						$TCO = $CLIEN['TCO'];
						$NOM = $CLIEN['NOM'];		
						$CUI = $CLIEN['CUIT'];
						$FPA = $CLIEN['FPA'];
						$FPAN = $CLIEN['FPAN'];
						
					}
					
					$_SESSION['ParSQL'] = "SELECT MAX(NCO) + 1 AS NCO FROM AMAEFACT WHERE TIP = 'B' AND TCO = 'TI' AND SUC = ".$SUC."";
					$AMAEFACT = mssql_query($_SESSION['ParSQL']) or die("Error SQL");
					rollback($AMAEFACT);
					while ($AMAEFACTREG=mssql_fetch_array($AMAEFACT)){
						if($AMAEFACTREG['NCO'] == NULL){
							$NCO = 1;
						}else{
							$NCO = $AMAEFACTREG['NCO'];
						}
					}
			
				
				$_SESSION['ParSQL'] = "INSERT INTO TMAEFACT_T VALUES ('".$TIP."', '".$TCO."', ".$SUC.", ".$NCO.", ".$TER.", ".$FechaGrabar.", ".$CLI.", '".$CUI."', ".$TIV.", ".$FPA.", 0, 0, 0, 0, 0, 0, 0, ".$TUR.", ".$ZON.", ".$OPE.", ' ', '".$NOM."', ' ', ' ', ' ', ".$PLA.", ".$LUG.", ' ', 0, '*-No-Gra*', ' ', 1, ' ', 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0)";
				$TMAEFACT_T = mssql_query($_SESSION['ParSQL']) or die("Error SQL");
				rollback($TMAEFACT_T);
			
			
			}else{
				
			
				$_SESSION['ParSQL'] = "SELECT * FROM TMAEFACT_T WHERE TER = ".$TER."";
				$TMAEFACT_T = mssql_query($_SESSION['ParSQL']) or die("Error SQL");
				rollback($TMAEFACT_T);
				while ($TMA_INT=mssql_fetch_array($TMAEFACT_T)){
			
					$TIV = $TMA_INT['TIV'];
					$TIP = $TMA_INT['TIP'];
					$TCO = $TMA_INT['TCO'];
					$NCO = $TMA_INT['NCO'];
					$NOM = $TMA_INT['NOM'];		
					$CUI = $TMA_INT['CUI'];
					
				}
			
			
			}
			
			////////////////////////////////////////////////////////////////////////
			//////////////////////////////////////////////////////////////////////// COMIENZO CON ARTICULO
			////////////////////////////////////////////////////////////////////////
			
				$PRENEX = 0;
			
				$_SESSION['ParSQL'] = "
				SELECT DetArt, CodRub, PreNet, IMPIVA, ImpInt, ImpInt2, IvaCO, PreVen,ILPC,PRO FROM ARTICULOS WHERE CODSEC = ".$SEC." AND CODART = ".$ART."";
				$ARTICULOS = mssql_query($_SESSION['ParSQL']) or die("Error SQL");
				rollback($ARTICULOS);		
				while ($ARTT=mssql_fetch_array($ARTICULOS)){
					$DES = $ARTT['DetArt'];
					$RUB = $ARTT['CodRub'];
					$PRENET = $ARTT['PreNet'];
					$IMPIVA = $ARTT['IMPIVA'];
					$IMPINT1 = $ARTT['ImpInt'];
					$IMPINT2 = $ARTT['ImpInt2'];
					$IVACO = $ARTT['IvaCO'];
					$PUN = $ARTT['PreVen'];
					$ILPC = $ARTT['ILPC'];
					$PRO = $ARTT['PRO'];
				}
				$PRECIOV = $PUN;
				
				$_SESSION['ParSQL'] = "SELECT POR FROM ACODIVA WHERE ID = ".$IVACO."";
				$ACODIVA = mssql_query($_SESSION['ParSQL']) or die("Error SQL");
				rollback($ACODIVA);		
				while ($ACO=mssql_fetch_array($ACODIVA)){
					$TIVA = $ACO['POR'];
				}
				if($TIVA == 0){
					$PRENET = 0;
					$IMPIVA = 0;
					$PRENEX = $ARTT['PreNet'];
				}
				
			
			////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
			////////////// Buscar precio de producto por costo
			////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
			
			
			if($ParCosto_Pb == true){
				
				if($ILPC == false){
			
					$_SESSION['ParSQL'] = "SELECT TOP 1 RED FROM APAREMP";
					$APAREMRED = mssql_query($_SESSION['ParSQL']) or die("Error SQL");
					rollback($APAREMRED);
					while ($REGRED=mssql_fetch_array($APAREMRED)){
						$RED = $REGRED['RED'];			
					}
					if($RED == 0){
						$_SESSION['ParSQL'] = "SELECT preven FROM VI_CONSULTA_ARTICULOS_".$LISTA." WHERE sec = ".$SEC." and art = ".$ART." order by art";
					}else{
						$_SESSION['ParSQL'] = "SELECT preven FROM VI_CONSULTA_ARTICULOS_B".$LISTA." WHERE sec = ".$SEC." and art = ".$ART." order by art";
					}
			
					
					$VI_CONSULTA_ARTICULOS=mssql_query($_SESSION['ParSQL']) or die ("Error SQL");
					rollback($VI_CONSULTA_ARTICULOS);
					
					while ($VI_CONSULTA=mssql_fetch_array($VI_CONSULTA_ARTICULOS)){ 
					
						$PRECIOV = $VI_CONSULTA['preven'];
			
					}
					
					mssql_free_result($VI_CONSULTA_ARTICULOS);	
									
				}
						
			}////////////// fin de trabaka con lista de precios
			
			
			////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
			////////////// Buscar precio de producto por cleinte
			
				$_SESSION['ParSQL'] = "SELECT CONVERT(INT,MOD) AS MOD FROM CLIENTES WHERE NHA <> 1 AND COD = ".$CLI."";
				$CLIENTES = mssql_query($_SESSION['ParSQL']) or die("Error SQL");
				rollback($CLIENTES);
				while ($CLIEN=mssql_fetch_array($CLIENTES)){
					$MOD = $CLIEN['MOD'];			
				}
				
			$busco_por_costo = false;
			$SIM = '+';
			$POR = 0;
			
			if($MOD > 0){
				
				$_SESSION['ParSQL'] = "SELECT SIM, POR FROM LIS_VAR WHERE ID = '".$MOD."' and sec = ".$SEC." and rub = ".$RUB." and bus = 0";
				$LIS_VAR1 = mssql_query($_SESSION['ParSQL']) or die("Error SQL");
				rollback($LIS_VAR1);
				
				if(mssql_num_rows($LIS_VAR1)==0){
			
					$_SESSION['ParSQL'] = "SELECT SIM, POR FROM LIS_VAR WHERE ID = '".$MOD."' and sec = ".$SEC." and rub = ".$ART." and bus = 1";
					$LIS_VAR2 = mssql_query($_SESSION['ParSQL']) or die("Error SQL");
					rollback($LIS_VAR2);
				
					if(mssql_num_rows($LIS_VAR2)==0){
				
						$_SESSION['ParSQL'] = "SELECT SIM, POR FROM LIS_VAR WHERE ID = '".$MOD."' and sec = ".$SEC." and rub = 0";
						$LIS_VAR3 = mssql_query($_SESSION['ParSQL']) or die("Error SQL");
						rollback($LIS_VAR3);
			
						if(mssql_num_rows($LIS_VAR3)==0){
						
							$_SESSION['ParSQL'] = "SELECT SIM, POR FROM LIS_VAR WHERE ID = '".$MOD."' and sec = 0 and rub = 0 and bus=1";
							$LIS_VAR4 = mssql_query($_SESSION['ParSQL']) or die("Error SQL");
							rollback($LIS_VAR4);
			
								if(mssql_num_rows($LIS_VAR4) > 0){
									$busco_por_costo = true;
								}
						
						} 
						
						while ($LIS3=mssql_fetch_array($LIS_VAR3)){
							$SIM = $LIS3['SIM'];
							$POR = $LIS3['POR'];
						}
			
					
					
					} 
					
					while ($LIS2=mssql_fetch_array($LIS_VAR2)){
						$SIM = $LIS2['SIM'];
						$POR = $LIS2['POR'];
					}
			
			
				
				} 
				
				while ($LIS1=mssql_fetch_array($LIS_VAR1)){
					$SIM = $LIS1['SIM'];
					$POR = $LIS1['POR'];
				}
			
			
			if($busco_por_costo == true){
			
				if($ILPC == false){
					
					$_SESSION['ParSQL'] = "SELECT precio_".$MOD." AS PRECIO FROM Planilla_Costo WHERE sec = ".$SEC." and cod = ".$ART." and precio_".$MOD." > 0";
					$Planilla_Cos = mssql_query($_SESSION['ParSQL']) or die("Error SQL");
					rollback($Planilla_Cos);
					while ($Pla_Cos=mssql_fetch_array($Planilla_Cos)){
						$PRECIOV = $Pla_Cos['PRECIO'];			
					}
					
				}
			
			}else{
				
				if($POR > 0){
							
					if($SIM == '+'){
						$PRECIOV = $PRECIOV * ( 1 + ($POR / 100));
					}else{
						$PRECIOV = $PRECIOV * ( 1 - ($POR / 100));
					}
					
					$r = 0;
					$t = 0;
					$r = redondeado($PRECIOV ,1);
					$t = $PRECIOV - $r;
					
					if($t >= 0.01 and $t <= 0.05 and $PRECIOV > $r){
					
						$PRECIOV = $r + 0.05;
					
					}else{
						
						if($t >= 0.05 and $t <= 0.09 and $PRECIOV > $r){
							$PRECIOV = $r + 0.1;
						}elseif($PRECIOV - $r == 0.05){
							$PRECIOV = $r + 0.05;
						}else{
							$PRECIOV = $r;
						}
						
					}
					
					
				}/////////////////////////////// busco lit_var
				
			
			}/////////////////////////////// busco por costo	
			
			
			}//////////////////////REALIZA PRECIO DE LISTA PARA EL CLIENTE
			
			
				$_SESSION['ParSQL'] = "SELECT SIM, POR, FEV FROM Pro_Prom WHERE SEC = ".$SEC." and ART = ".$ART."";
				$Pro_Prom = mssql_query($_SESSION['ParSQL']) or die("Error SQL");
				rollback($Pro_Prom);
			
			
			if(mssql_num_rows($Pro_Prom) > 0){
			
				while ($Prom=mssql_fetch_array($Pro_Prom)){
					$SIM = $Prom['SIM'];
					$POR = $Prom['POR'];
					$FEV = $Prom['FEV'];
				}
				
				$FECHA = date("Ymd");
				
				$date = new DateTime($FEV);
				$date->format('Ymd');
				
				if(strtotime($FEV) >= strtotime($FECHA)){
				
					if($POR > 0){		
						
						if($SIM == '+'){
							$PRECIOV = $PRECIOV * ( 1 + ($POR / 100));
						}else{
							$PRECIOV = $PRECIOV * ( 1 - ($POR / 100));
						}
						
						$r = 0;
						$t = 0;
						$r = redondeado($PRECIOV ,1);
						$t = $PRECIOV - $r;
						
						if($t >= 0.01 and $t <= 0.05 and $PRECIOV > $r){
						
							$PRECIOV = $r + 0.05;
						
						}else{
							
							if($t >= 0.05 and $t <= 0.09 and $PRECIOV > $r){
								$PRECIOV = $r + 0.1;
							}elseif($PRECIOV - $r == 0.05){
								$PRECIOV = $r + 0.05;
							}else{
								$PRECIOV = $r;
							}
							
						}
							
					}
					
				}
				
			}////////////////////// REALIZA PRECIO POR OFERTA
			
			
			$POR_IVA = $TIVA;
			$POR_IVA = $POR_IVA / 100;
			
			
			if($PRENET > 0){
				
				$PRENET = $PRECIOV - ($IMPINT1 + $IMPINT2);
				$PRENET = $PRENET / (1 + $POR_IVA);
			
				$IMPIVA =  $PRECIOV - ($IMPINT1 + $IMPINT2 + $PRENET) ;
			
			}else{
			
				$PRENEX = $PRECIOV - ($IMPINT1 + $IMPINT2);
				
			}
			
			$TOT_TOT = $PRENET * $CAN + $PRENEX * $CAN + $IMPIVA * $CAN + $IMPINT1 * $CAN + $IMPINT2 * $CAN;
			
			if($ESC == 0){
				
			$_SESSION['ParSQL'] = "UPDATE TMAEFACT_T SET NET = NET + ".$PRENET * $CAN.", NEE = NEE + ".$PRENEX * $CAN.", IRI = IRI + ".$IMPIVA * $CAN.", IMI = IMI + ".$IMPINT1 * $CAN.",IMI2 = IMI2 + ".$IMPINT2 * $CAN.",TOT = TOT + ".$TOT_TOT." WHERE TIP = '".$TIP."' AND TCO = '".$TCO."' AND SUC = ".$SUC." AND NCO = ".$NCO." AND TER = ".$TER."";
			$TMAEFACT_T = mssql_query($_SESSION['ParSQL']) or die("Error SQL");
			rollback($TMAEFACT_T);
			
			$_SESSION['ParSQL'] = "INSERT INTO TMOVFACT_T VALUES ('".$TIP."', '".$TCO."', ".$SUC.", ".$NCO.", ".$TER.",".$ParOrnVal.", ".$SEC.", ".$ART.", ".$RUB.", 0, '".$DES."', ".$CAN.", ".$PRECIOV.", ".$PRENET.", ".$PRENEX.", ".$IMPIVA.", 0, ".$IMPINT1.", ".$PUN.", ".$TUR.", 0, ".$PLA.", ".$LUG.", 0, 0, 0, ".$TIVA.", ".$IMPINT2.", 0, 0,".$ParColVal.")";
			$TMOVFACT = mssql_query($_SESSION['ParSQL']) or die("Error SQL");
			rollback($TMOVFACT);
			
				
			///////////////////////////////////////////////////////
			///////// PARA FAC MANUAL /////////////////////////////
			///////////////////////////////////////////////////////
			//SESSION
			if($_SESSION['ParFacSec'] == 1){
			?>
			<script>
			  document.getElementById('modcli').value = 1;
			  NuevoIXCodigoB('<? echo $CodSec ?>','<? echo $CodArt; ?>',<? echo $PRECIOV; ?>,<? echo $CAN; ?>,'<? echo substr(htmlentities(trim($DES)), 0, 30); ?>');
			</script>
			<?
			}
			if($_SESSION['ParFacSec'] == 2){
			?>
			<script>
			  document.getElementById('Mamodcli').value = 1;
			  MaNuevoIXCodigoB('<? echo $CodSec ?>','<? echo $CodArt; ?>',<? echo $PRECIOV; ?>,<? echo $CAN; ?>,'<? echo substr(htmlentities(trim($DES)), 0, 30); ?>');
			</script>
			<?
			}
			///////////////////////////////////////////////////////
			///////////////////////////////////////////////////////
			///////////////////////////////////////////////////////
			
			}
			
			
			///////////////////////////////////////////////////////////////////////////////////////////////////
			////////////////////////////////////////// Es Promocion ///////////////////////////////////////////
			///////////////////////////////////////////////////////////////////////////////////////////////////
			if($PRO == 1){
			
			
			$_SESSION['ParSQL'] = "INSERT INTO AARTPRO_T SELECT CAN, SEC, ART, TER FROM TMOVFACT_T WHERE ESC = 1 AND TER = ".$TER2." AND COL = ".$COL;
			$INS_AARTPRO_T = mssql_query($_SESSION['ParSQL']) or die("Error SQL");
			rollback($INS_AARTPRO_T);
			
			$_SESSION['CON_INTEGRI'] = 1; 
			
						
				if($_SESSION['CON_INTEGRI'] == 1){
				
				
						$SQL = "SELECT * FROM AARTPRO WHERE SECP = ".$SEC." AND CODP = ".$ART."";
						$AARTPRO = mssql_query($SQL) or die("Error SQL");
						$CoPro = mssql_num_rows($AARTPRO);
						while ($AARC=mssql_fetch_array($AARTPRO)){
							
							$SEC = $AARC['SECA'];
							$ART = $AARC['CODA'];
							$CANA = $AARC['CANA'];
							$TIPOPRO = $AARC['TIPO_PROMOCION'];
							
						}
					
					if($CoPro == 0){
						
						
					
					}else{
						

						
						if($TIPOPRO == 'A'){
							
							// Promo tipo A
							$CAN = $CAN * $CANA;
							require('NArtXP.php');	
							
						}
						
						if($TIPOPRO == 'B'){
							// Promo tipo B
							$_SESSION['ParSQL'] = "SELECT * FROM AARTPRO_T WHERE TER = ".$TER2."";
							$AARTPRO_T = mssql_query($_SESSION['ParSQL']) or die("Error SQL");
							rollback($AARTPRO_T);
							while ($AARTT=mssql_fetch_array($AARTPRO_T)){
								
								$SEC = $AARTT['SECT'];
								$ART = $AARTT['ARTT'];
								$CANN = $AARTT['CAN'];
								if($MCDPRO == 1){
									$CAN = $CANN;
								}else{
									$CAN = $CANN * $CAN;
								}

								require('NArtXP.php');
								
							}
						}
					
						if($TIPOPRO == 'C'){
							
							// Promo tipo C
							$_SESSION['ParSQL'] = "SELECT * FROM AARTPRO_T WHERE TER = ".$TER2."";
							$AARTPRO_T = mssql_query($_SESSION['ParSQL']) or die("Error SQL");
							rollback($AARTPRO_T);
							while ($AARTT=mssql_fetch_array($AARTPRO_T)){
								
								$SEC = $AARTT['SECT'];
								$ART = $AARTT['ARTT'];
								$CANN = $AARTT['CAN'];
								if($MCDPRO == 1){
									$CAN = $CANN;
								}else{
									$CAN = $CANN * $CAN;
								}
								
								require('NArtXP.php');
						
							}
							
						}
						
						if($TIPOPRO == 'D'){
							
							////// FALTA TIP D RESETAS
						
						}
						
					
					}///////// Si hay datos en la AARTPRO
					
				}else{
					
					$LOG = "Control de integridad = 0: ".$SEC."~".$ART;
					$ID = "NArt.php";
					esclog(3,$LOG,$ID);
					
				}///////// Control de integridad
				
			}
			
			///////////////////////////////////////////////////////////////////////////////////////////////////
			$_SESSION['ParSQL'] = "DELETE AARTPRO_T WHERE TER = ".$TER2;
			$AARTPRO_TDE = mssql_query($_SESSION['ParSQL']) or die("Error SQL");
			rollback($AARTPRO_TDE);
			///////////////////////////////////////////////////////////////////////////////////////////////////
			
			
			///////////////////////////////////////////////////////////////////////////////////////////////////
			$CPARBON = mssql_query("SELECT ID FROM CPARBON") or die("Error SQL");
			if(mssql_num_rows($CPARBON) >= 1){
			
				if($_SESSION['ParFacSec'] == 1){
					?>
					<script>
			
						SoloBlock("MonedasFon, Monedas");
						var tot = document.getElementById('total').value;
						$("#Monedas").load("MMon.php?tot="+tot);
						
					</script>
					<?
				}
				if($_SESSION['ParFacSec'] == 2){
					?>
					<script>
						
						SoloBlock("MaMonedasFon, MaMonedas");
						var tot = document.getElementById('Matotal').value;
						$("#MaMonedas").load("MMon.php?tot="+tot);
						
					</script>
					<?
				}
				
				
			}
			///////////////////////////////////////////////////////////////////////////////////////////////////

		
	}
			

	$_SESSION['ParSQL'] = "DELETE TMAEFACT_T WHERE TER = ".$TER2;
	$DEL_TMAEFACT_T = mssql_query($_SESSION['ParSQL']) or die("Error SQL");
	rollback($DEL_TMAEFACT_T);
	
	$_SESSION['ParSQL'] = "DELETE TMOVFACT_T WHERE TER = ".$TER2;
	$DEL_TMOVFACT_T = mssql_query($_SESSION['ParSQL']) or die("Error SQL");
	rollback($DEL_TMOVFACT_T);


}


mssql_query("commit transaction") or die("Error SQL commit");



	///////////////////////////////////////////////////////
	///////// PARA FAC MANUAL /////////////////////////////
	///////////////////////////////////////////////////////
	//SESSION
	if($_SESSION['ParFacSec'] == 1){
		?>
		<script>
		
			$("#ClientesFa").fadeOut(tim);
			$("#BotonesParaO").fadeOut(tim);
			$("#toda_la_busC").fadeOut(tim);
			$("#mostrar").fadeOut(tim);
			$("#MiProd").fadeOut(tim);
			
			document.getElementById('modcli').value = 0;
			
			$('#Bloquear').fadeOut(500);
			
		</script>
		<?
	}
	if($_SESSION['ParFacSec'] == 2){
		?>
		<script>
		
			$("#MaClientesFa").fadeOut(tim);
			$("#MaBotonesParaO").fadeOut(tim);
			$("#Matoda_la_busC").fadeOut(tim);
			$("#Mamostrar").fadeOut(tim);
			$("#MaMiProd").fadeOut(tim);
			
			document.getElementById('Mamodcli').value = 0;
			
			$('#Bloquear').fadeOut(500);
			
		</script>
		<?
	}
	///////////////////////////////////////////////////////
	///////////////////////////////////////////////////////
	///////////////////////////////////////////////////////



}catch(Exception $e){////////////////////////////////////////////////////////////////////////////////////////////////// FIN DE TRY //
	
	?>
	<script>
		$('#Bloquear2').fadeOut(500);
		jAlert('ERROR Reintente la operacion solicitada.', 'Debo Retail - Global Business Solution');
	</script>
	<?
exit;

}
?>