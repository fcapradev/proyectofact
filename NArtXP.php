<?

try {////////////////////////////////////////////////////////////////////////////////////////////////// COMIENZO TRY //


mssql_query("begin transaction",$conexion) or die("Error SQL begin trans");


if(isset($_REQUEST['cl'])){

	//REQUEST
	$CLI = $_REQUEST['cl']; 

}

//SESSION
$ZON = $_SESSION['ParEMP'];
$OPE = $_SESSION['idsusua'];
$LUG = $_SESSION['ParLUG'];
$SUC = $_SESSION['ParPV'];


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


$LISTA = $_SESSION['iListaBO'];
$ParCosto_Pb = $_SESSION['ParCosto_Pb'];


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


if($_SESSION['ParFacSec'] == 1){
	$_SESSION['ParOrn'] = $_SESSION['ParOrn'] + 1;
	$ParOrnVal = $_SESSION['ParOrn'];
	$ParColVal = $_SESSION['ParCol'];
}
if($_SESSION['ParFacSec'] == 2){
	$_SESSION['ParOrnMa'] = $_SESSION['ParOrnMa'] + 1;
	$ParOrnVal = $_SESSION['ParOrnMa'];
	$ParColVal = $_SESSION['ParColMa'];
}

if($ParOrnVal == 1){

	
		$_SESSION['ParSQL'] = "SELECT A.IVA, A.NOM, A.CUIT, A.TIP, A.TCO, A.FPA, B.NOMBRE AS FPAN FROM CLIENTES AS A INNER JOIN FDPAGO AS B ON A.FPA = B.ID WHERE COD = ".$CLI."";
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

	$_SESSION['ParSQL'] = "SELECT DetArt, CodRub, PreNet, IMPIVA, ImpInt, ImpInt2, IvaCO, PreVen, ILPC FROM ARTICULOS WHERE CODSEC = ".$SEC." AND CODART = ".$ART."";
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
	

////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
////////////// Buscar precio de producto por costo
////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////


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
			$_SESSION['ParSQL'] = "SELECT preven FROM VI_CONSULTA_ARTICULOS_B_".$LISTA." WHERE sec = ".$SEC." and art = ".$ART." order by art";
		}

        
		$VI_CONSULTA_ARTICULOS=mssql_query($_SESSION['ParSQL']) or die ("Error SQL");
		rollback($VI_CONSULTA_ARTICULOS);
		
		while ($VI_CONSULTA=mssql_fetch_array($VI_CONSULTA_ARTICULOS)){ 
		
			$PRECIOV = $VI_CONSULTA['preven'];

		}
		
		mssql_free_result($VI_CONSULTA_ARTICULOS);	
						
	}
			
}////////////// fin de trabaka con lista de precios


////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
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


$_SESSION['ParSQL'] = "INSERT INTO TMOVFACT_T VALUES ('".$TIP."', '".$TCO."', ".$SUC.", ".$NCO.", ".$TER.",".$ParOrnVal.", ".$SEC.", ".$ART.", ".$RUB.", 0, '".$DES."', ".$CAN.", ".$PRECIOV.", ".$PRENET.", ".$PRENEX.", ".$IMPIVA.", 0, ".$IMPINT1.", ".$PUN.", ".$TUR.", 0, ".$PLA.", ".$LUG.", 1, 0, 0, ".$TIVA.", ".$IMPINT2.", 0, 0, ".$ParColVal.")";
$TMOVFACT = mssql_query($_SESSION['ParSQL']) or die("Error SQL");
rollback($TMOVFACT);


mssql_query("commit transaction") or die("Error SQL commit");

	
}catch(Exception $e){////////////////////////////////////////////////////////////////////////////////////////////////// FIN DE TRY //
	
	?>
	<script>
		jAlert('ERROR Reintente la operacion solicitada.', 'Debo Retail - Global Business Solution');
	</script>
	<?
exit;

}