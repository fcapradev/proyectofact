<?
require("config/cnx.php");


try {////////////////////////////////////////////////////////////////////////////////////////////////// COMIENZO TRY //


function VerificoDatosComprobante($tipo,$clase,$pvta,$nun){

	$_SESSION["ParSQL"] = "SELECT MAX(NCO) + 1 as NCO  FROM AMAEFACT WHERE TIP = '".$tipo."' AND TCO = '".$clase."' AND SUC = ".$pvta."";
	$registros = mssql_query($_SESSION["ParSQL"]) or die("Error SQL: ".$_SESSION["ParSQL"]);
	rollback($registros);
	while ($reg=mssql_fetch_array($registros)){
		
		if($reg['NCO'] == NULL){
			return 1;
		}else{
			$NCO = $reg['NCO'];
			return $NCO;
		}
		
	}
	
}


function New_GraboNumCom($ipm,$pve,$tip,$tco,$num){

	$_SESSION["ParSQL"] = "SELECT * FROM ANUMFACT WHERE TIP = '".$tip."' AND SUC = ".$pve." AND TCO = '".$tco."' AND IPM = '".$ipm."'";
	$registros = mssql_query($_SESSION["ParSQL"]) or die("Error SQL: ".$_SESSION["ParSQL"]);
	rollback($registros);
	
	if(mssql_num_rows($registros) == 0){
		
		$_SESSION["ParSQL"] = "INSERT INTO ANUMFACT (IPM,TIP,SUC,TCO,NUM) VALUES ('".$ipm."','".$tip."',".$pve.",'".$tco."',".$num.")";
		$registros = mssql_query($_SESSION["ParSQL"]) or die("Error SQL: ".$_SESSION["ParSQL"]);
		rollback($registros);
		
	}else{
		
		$_SESSION["ParSQL"] = "UPDATE ANUMFACT SET NUM = ".$num." WHERE TIP = '".$tip."' AND SUC = ".$pve." AND TCO = '".$tco."' AND IPM = '".$ipm."'";
		$registros = mssql_query($_SESSION["ParSQL"]) or die("Error SQL: ".$_SESSION["ParSQL"]);
		rollback($registros);
		
	}

}


function validarsucursal($tip,$tco,$suc,$nco){

	$_SESSION["ParSQL"] = "SELECT CYV,TIP,TCO,SUC,NCO,NMF,FEC FROM AMAEFACT WHERE TIP = '".$tip."' AND SUC = ".$suc." AND TCO = '".$tco."' AND NCO = ".$nco."";
	$registros = mssql_query($_SESSION["ParSQL"]) or die("Error SQL: ".$_SESSION["ParSQL"]);
	rollback($registros);
	if(mssql_num_rows($registros) == 0){
		return $suc;
	}else{
		$suc = $suc * 100;
		$_SESSION["ParSQL"] = "SELECT CYV,TIP,TCO,SUC,NCO,NMF,FEC FROM AMAEFACT WHERE TIP = '".$tip."' AND SUC = ".$suc." AND TCO = '".$tco."' AND NCO = ".$nco."";
		$registros = mssql_query($_SESSION["ParSQL"]) or die("Error SQL: ".$_SESSION["ParSQL"]);
		rollback($registros);
		if(mssql_num_rows($registros) == 0){
			return $suc;
		}else{
			
			for ( $i = 1 ; $i <= 9 ; $i ++) {
				$suc = $suc + i;
				$_SESSION["ParSQL"] = "SELECT CYV,TIP,TCO,SUC,NCO,NMF,FEC FROM AMAEFACT WHERE TIP='".$tip."' AND SUC=".$suc." AND TCO = '".$tco."' AND NCO = ".$nco;
				$registros = mssql_query($_SESSION["ParSQL"]) or die("Error SQL: ".$_SESSION["ParSQL"]);
				rollback($registros);
				if(mssql_num_rows($registros) == 0){
					return $suc;
				}
				return $suc;	
			}
			
		}
		
	}

}


function GuardarComprobantesCI($PLA,$reg){

	/* Esto queda pendiente auditoria
   'RECOPILA LOS DATOS DE LOS COMPROBANTES QUE QUEDARON PENDIENTES DE IMPRIMIR
   'PARA GUARDAR LOS TOTALES EN LA AUDITORIA
   sql = "select count(tco) as TCO , sum(tot) as TOT from tmaefact where dc1 = '' and pla= " & PLA_CI & " and lug= " & LUG_CI
   If tTMF.State = 1 Then tTMF.Close
   tTMF.Open sql, Cn

   If Not IsNull(tTMF!TOT) Then
      NCantComp = tTMF!TCO
      NImpComp = Format(tTMF!TOT, "0.00")
   Else
      NCantComp = 0
      NImpComp = 0
   End If
	*/
	
	$FechaGrabar = "'".date("Ymd H:i:s")."'";
	$comp_Vta = "V";
	$Clase_Comprobante = "CI";
	
	$TIP = $reg['TIP'];
	$SUC = $reg['SUC'];
	$NCO = $reg['NCO'];
	$DEL = $reg['DE1'];
	$NFI = $reg['NFI'];
	$TFI = $reg['TFI'];
	$PRO = $reg['PRO'];
	$NOM = substr($reg['NOM'],0,20);
	$FPA = $reg['FPA'];
	
	$xNCO = VerificoDatosComprobante($TIP,$Clase_Comprobante,$SUC,$NCO);

	New_GraboNumCom('I',$SUC,$TIP,$Clase_Comprobante,$xNCO);

	$SUCN = validarsucursal($TIP,$Clase_Comprobante,$SUC,$xNCO);

	if($DEL != 'T_C' and $NFI == ''){
		if($FPA == 3){
			$cNta = (int)substr($DEL,24,3);
			$cNcu = (int)substr($DEL,14,8);
		}else{
			$cNta = 0;
			$cNcu = 0;
		}
	}elseif($TFI == 0 and $TFI == ''){
	    $cNta = 10000;
    	$cNcu = $TFI;
    }else{
		$cNta = 1000;
		$m = strlen($DEL);
		$cNcu = substr($DEL,$m - 8,$m); 
	}
   $cFar = 0;
   if($PRO == 'Z' or $PRO == 'X' or $PRO == 'Y'){
   		$cFar = 1;
   }
	$cCai = " ";
	
	$_SESSION["ParSQL"] = "INSERT AMAEFACT (CYV, TIP, TCO, SUC, NCO, NMF, FEC, COD, CUI, TIV, FPA, TCA, PDT, DTO, NET, NEE, IRI, IRS, IMI, TOT, TUR, ZON, FEV, VEN, OPE, REC, REP, NPE, CPA, ENV, REM,PRO,ANU,NTA,NCU,CCU,NOM,PLA,LUG,LEG,CTA,FAR,CAI,FECCAI,CCO,PER,APR,IMI2) VALUES ('".$comp_Vta."', '".$TIP."', '".$Clase_Comprobante."', ".$SUCN.", ".$xNCO.", 0, ".$FechaGrabar.", ".$reg['CLI'].", '".trim($reg['CUI'])."', ".$reg['TIV'].", ".$reg['FPA'].", ".$reg['TCA'].", 0, ".$reg['DTO'].", ".$reg['NET'].", ".$reg['NEE'].", ".$reg['IRI'].", ".$reg['IRS'].", ".$reg['IMI'].", ".$reg['TOT'].", ".$reg['TUR'].", ".$reg['ZON'].", ".$FechaGrabar.", ".$reg['OPE'].", ".$reg['VEN'].", 0, 0, 0, 0, 0, 0, ' ', ' ', ".$cNta.", ".$cNcu.", 0, '".$NOM."', ".$reg['PLA'].", ".$reg['LUG'].", '".$reg['LEG']."', ".$reg['CTA'].", ".$cFar.", '".$cCai."', ".$FechaGrabar.", ".$reg['COD_CONT1'].", ".$reg['PER'].", 0, ".$reg['IMI2'].")";

//	echo $_SESSION["ParSQL"];

	$AMAEFACT = mssql_query($_SESSION["ParSQL"]) or die("Error SQL: ".$_SESSION["ParSQL"]);
	rollback($AMAEFACT);
	
	if((strlen($reg['DC1']) != 0 or strlen($reg['DC2']) != 0) and strlen($reg['PRO']) == 0){
		$_SESSION["ParSQL"] = "INSERT DET_CONDUCT_COMP (TIP,TCO,SUC,NCO,NMF,DET1,DET2,DET3,DET4) VALUES ('".$TIP."','".$TCO."',".$SUCN.",".$xNCO.",0 ,'".$reg['DC1']."','".$reg['DC2']."','','')";
		$DET_CONDUCT_COMP = mssql_query($_SESSION["ParSQL"]) or die("Error SQL: ".$_SESSION["ParSQL"]);
		rollback($DET_CONDUCT_COMP);	
	}
	
	if(trim($reg['TCO']) != 'TI' and (int)$reg['CLI'] > 0){
		
		/* SE DEJA EN 0
		if($reg['CCP'] == true){
		   $cRep = 1;
		}else{
		   $cRep = 0;
		}
    	*/
		$cRep = 0;
		 
		$_SESSION["ParSQL"] = "INSERT ACOBYPAG (CYV,COD,FEP,TIP,TCO,SUC,NCO,NMF,IPA,TCA,ZONA,FPA,REC,PRO,FEV,ANU,UCU,CCU,PLA,LUG,LEG,CTA,FAR,REP) VALUES ('".$comp_Vta."', ".$reg['CLI'].", ".$FechaGrabar.", '".$TIP."', '".$Clase_Comprobante."', ".$SUCN.", ".$xNCO.", 0, ".$reg['TOT'].", 1, ".$reg['ZON'].", ".$reg['FPA'].", 0, '', ".$FechaGrabar.", '', 0, 0, ".$reg['PLA'].", ".$reg['LUG'].", '".$reg['LEG']."', ".$reg['CTA'].", ".$cFar.", ".$cRep.")";
		
		$ACOBYPAG = mssql_query($_SESSION["ParSQL"]) or die("Error SQL: ".$_SESSION["ParSQL"]);
		rollback($ACOBYPAG);

	}


	$_SESSION["ParSQL"] = "SELECT * FROM TMOVFACT WHERE TIP = '".$reg['TIP']."' AND SUC = ".$reg['SUC']." AND TCO = '".$reg['TCO']."' AND NCO = ".$reg['NCO']."";
	$TMOVFACT = mssql_query($_SESSION["ParSQL"]) or die("Error SQL: ".$_SESSION["ParSQL"]);
	rollback($TMOVFACT);
	$Orden = 0;
	while ($regg=mssql_fetch_array($TMOVFACT)){//////////////////////////////////////////////// WHILE TMOVFACT
	
		if($regg['ESC'] == 1){
			$cEsc = 1;
		}else{
			$cEsc = 0;
		}

		$Orden = $Orden + 1;
		$Des = substr(trim($regg['DES']),0,30);
		
	    $_SESSION["ParSQL"] = "INSERT AMOVFACT (CYV,TIP,TCO,SUC,NCO,NMF,ORD,COD,ART,RUB,CON,TIO,LIO,CAN,PUN,IVA,IVS,NET,NEX,IMI,IMI2,PUT,TUR,LEG,CMF,PLA,LUG,ESC,CCO) VALUES ('".$comp_Vta."', '".$TIP."', '".$Clase_Comprobante."', ".$SUCN.", ".$xNCO.", 0, ".$Orden.", ".$regg['SEC'].", ".$regg['ART'].", ".$regg['RUB'].", 0, '".$Des."', '', ".$regg['CAN'].", ".$regg['PUN'].", ".$regg['IVA'].", ".$regg['IVS'].", ".$regg['NET'].", ".$regg['NEX'].", ".$regg['IMI'].", ".$regg['IMI2'].", ".$regg['PUT'].", ".$regg['TUR'].", ".$regg['LEG'].", ".$regg['CMF'].", ".$regg['PLA'].", ".$regg['LUG'].", ".$cEsc.", ".$regg['COD_CONT1'].")";
		
		$AMOVFACT = mssql_query($_SESSION["ParSQL"]) or die("Error SQL: ".$_SESSION["ParSQL"]);
		rollback($AMOVFACT);
			
			
		if($reg['PRO'] == "" or $reg['PRO'] == "A"){////////////////////////////////////////////////
		
			$cLug = $_SESSION['ParLUG'];
			
			$_SESSION["ParSQL"] = "INSERT AMOVSTOC (SEC,ART,FEC,CYV,TIP,TCO,PVE,NCO,NMF,ORD,CAN,PUN,COD,DTO,IMI,IMI2,PLA,LUG,TIM) VALUES (".$regg['SEC'].", ".$regg['ART'].", ".$FechaGrabar.", '".$comp_Vta."', '".$TIP."', '".$Clase_Comprobante."', ".$SUCN.", ".$xNCO.", 0, ".$Orden.", ".$regg['CAN'].", ".$regg['PUN'].", ".$reg['Cli'].", 0, ".$regg['IMI'].", ".$regg['IMI2'].", ".$regg['PLA'].", ".$cLug.", 'Ve')";
			
				$AMOVSTOC = mssql_query($_SESSION["ParSQL"]) or die("Error SQL: ".$_SESSION["ParSQL"]);
				rollback($AMOVSTOC);
			
			if($regg['sino'] == NULL){
				$sSino = "";
			}else{
				$sSino = $regg['sino'];
			}
			
			if($sSino == ""){
				$_SESSION["ParSQL"] = "SELECT * FROM AARTPRO WHERE SECP = ".$regg['SEC']." AND CODP = ".$regg['ART']." AND SINONIMO < 2 ORDER BY SECA,CODA";
			}else{
				$_SESSION["ParSQL"] = "SELECT * FROM AARTPRO WHERE SECP = ".$regg['SEC']." AND CODP = ".$regg['ART']." AND SINONIMO = 0 ORDER BY SECA,CODA";	
			}
			
			$AARTPRO1 = mssql_query($_SESSION["ParSQL"]) or die("Error SQL: ".$_SESSION["ParSQL"]);
			rollback($AARTPRO1);
			while ($reggg=mssql_fetch_array($AARTPRO1)){ //////////////////////////////////////////////// WHILE AARTPRO
		
		
				$_SESSION["ParSQL"] = "SELECT * FROM ARTICULOS WHERE CODSEC = ".$reggg['Seca']." AND CODART = ".$reggg['CodA']." ORDER BY CODSEC,CODART";
				$ARTICULOS1 = mssql_query($_SESSION["ParSQL"]) or die("Error SQL: ".$_SESSION["ParSQL"]);
				rollback($ARTICULOS1);
				while ($regggg=mssql_fetch_array($ARTICULOS1)){ 
			
					$CANA = $reggg['CANA'] * $regg['CAN'];
					
					$_SESSION["ParSQL"] = "INSERT AMOVSTOC (SEC,ART,FEC,CYV,TIP,TCO,PVE,NCO,NMF,ORD,CAN,PUN,COD,DTO,IMI,IMI2,PLA,LUG,TIM) VALUES (".$reggg['Seca'].", ".$reggg['Coda'].", ".$FechaGrabar.", '".$comp_Vta."', '".$TIP."', '".$Clase_Comprobante."', ".$SUCN.", ".$xNCO.", 0, ".$Orden.", ".$CANA.", ".$regggg['PreVen'].", ".$reg['Cli'].", 0, ".$regggg['ImpInt'].", ".$regggg['ImpInt2'].", ".$regg['PLA'].", ".$cLug.", 'Ve')";
					
					$AMOVSTOC = mssql_query($_SESSION["ParSQL"]) or die("Error SQL: ".$_SESSION["ParSQL"]);
					rollback($AMOVSTOC);
				}
						
				$_SESSION["ParSQL"] = "select * from aartpro where secp = ".$reggg['Seca']." and codp = ".$reggg['Coda']."";
				$AARTPRO2 = mssql_query($_SESSION["ParSQL"]) or die("Error SQL: ".$_SESSION["ParSQL"]);
				rollback($AARTPRO2);
				while ($reggggg=mssql_fetch_array($AARTPRO2)){ //////////////////////////////////////////////// WHILE AARTPRO
				
				
					$_SESSION["ParSQL"] = "SELECT * FROM ARTICULOS WHERE CODSEC = ".$reggggg['Seca']." AND CODART = ".$reggggg['CodA']." ORDER BY CODSEC,CODART";
					$ARTICULOS2 = mssql_query($_SESSION["ParSQL"]) or die("Error SQL: ".$_SESSION["ParSQL"]);
					rollback($ARTICULOS2);
					while ($regggggg=mssql_fetch_array($ARTICULOS2)){
				
						$CANA = $reggggg['CANA'] * $regg['CAN'];
						
						$_SESSION["ParSQL"] = "INSERT AMOVSTOC (SEC,ART,FEC,CYV,TIP,TCO,PVE,NCO,NMF,ORD,CAN,PUN,COD,DTO,IMI,IMI2,PLA,LUG,TIM) VALUES (".$reggggg['Seca'].", ".$reggggg['Coda'].", ".$FechaGrabar.", '".$comp_Vta."', '".$TIP."', '".$Clase_Comprobante."', ".$SUCN.", ".$xNCO.", 0, ".$Orden.", ".$CANA.", ".$regggggg['PreVen'].", ".$reg['Cli'].", 0, ".$regggggg['ImpInt'].", ".$regggggg['ImpInt2'].", ".$regg['PLA'].", ".$cLug.", 'Ve')";
						$AMOVSTOC = mssql_query($_SESSION["ParSQL"]) or die("Error SQL: ".$_SESSION["ParSQL"]);
						rollback($AMOVSTOC);
						
					}



				}
                 		
						
		
			}////////////////
			
			
			if($sSino != ""){
			
				$SECA = substr(trim($sSino),0,2);
				$CODA = substr(trim($sSino),4,4);
				
				$_SESSION["ParSQL"] = "SELECT * FROM AARTPRO WHERE SECP = ".$regg['SEC']." AND CODP = ".$regg['ART']." AND SECA = ".$SECA." AND CODA = ".$CODA." ORDER BY SECA,CODA";
				$registros = mssql_query($_SESSION["ParSQL"]) or die("Error SQL: ".$_SESSION["ParSQL"]);
				rollback($registros);
				
				while ($reg7=mssql_fetch_array($registros)){


					$_SESSION["ParSQL"] = "SELECT * FROM ARTICULOS WHERE CODSEC = ".$reg7['Seca']." AND CODART = ".$reg7['Coda']." ORDER BY CODSEC,CODART";
					$registros = mssql_query($_SESSION["ParSQL"]) or die("Error SQL: ".$_SESSION["ParSQL"]);
					rollback($registros);
					
					while ($reg8=mssql_fetch_array($registros)){
						
						$CANA = $reg7['CANA'] * $regg['CAN'];
						
						$_SESSION["ParSQL"] = "INSERT AMOVSTOC (SEC,ART,FEC,CYV,TIP,TCO,PVE,NCO,NMF,ORD,CAN,PUN,COD,DTO,IMI,IMI2,PLA,LUG,TIM) VALUES (".$reg7['Seca'].", ".$reg7['Coda'].", ".$FechaGrabar.", '".$comp_Vta."', '".$TIP."', '".$Clase_Comprobante."', ".$SUCN.", ".$xNCO.", 0, ".$Orden.", ".$CANA.", ".$re8['PreVen'].", ".$reg['Cli'].", 0, ".$reg8['ImpInt'].", ".$reg8['ImpInt2'].", ".$regg['PLA'].", ".$cLug.", 'Ve')";
						
						$registros = mssql_query($_SESSION["ParSQL"]) or die("Error SQL: ".$_SESSION["ParSQL"]);
						rollback($registros);
						
						
							$_SESSION["ParSQL"] = "select * from aartpro where secp = ".$reg7['Seca']." and codp = ".$reg7['Coda']."";
							$registros = mssql_query($_SESSION["ParSQL"]) or die("Error SQL: ".$_SESSION["ParSQL"]);
							rollback($registros);
							while ($reg9=mssql_fetch_array($registros)){
							
								$_SESSION["ParSQL"] = "SELECT * FROM ARTICULOS WHERE CODSEC = ".$reg9['Seca']." AND CODART = ".$reg9['Coda']." ORDER BY CODSEC,CODART";
								$registros = mssql_query($_SESSION["ParSQL"]) or die("Error SQL: ".$_SESSION["ParSQL"]);
								rollback($registros);
								while ($reg10=mssql_fetch_array($registros)){
								
								$CANA = $reg9['CANA'] * $regg['CAN'];
								
								$_SESSION["ParSQL"] = "INSERT AMOVSTOC (SEC,ART,FEC,CYV,TIP,TCO,PVE,NCO,NMF,ORD,CAN,PUN,COD,DTO,IMI,IMI2,PLA,LUG,TIM) VALUES (".$reg9['Seca'].", ".$reg9['Coda'].", ".$FechaGrabar.", '".$comp_Vta."', '".$TIP."', '".$Clase_Comprobante."', ".$SUCN.", ".$xNCO.", 0, ".$Orden.", ".$CANA.", ".$re8['PreVen'].", ".$reg['Cli'].", 0, ".$reg10['ImpInt'].", ".$reg10['ImpInt2'].", ".$regg['PLA'].", ".$cLug.", 'Ve')";
								
								$registros = mssql_query($_SESSION["ParSQL"]) or die("Error SQL: ".$_SESSION["ParSQL"]);
								rollback($registros);
								}							
								
							
							}
							
						
					}

				
				}
				
			
			}
			
						
		}	
		
			
	}
	

}


////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////

   
mssql_query("begin transaction",$conexion) or die("Error SQL begin trans");


$PLA = $_REQUEST['p'];
$PVE = $_SESSION['ParPV'];


	$_SESSION["ParSQL"] = "Select * from solicitud where pve = '$PVE' and TEX = 'CZ'";
	$registros = mssql_query($_SESSION["ParSQL"]) or die("Error SQL: ".$_SESSION["ParSQL"]);
	if(mssql_num_rows($registros) == 0){

		// INSERT
		$_SESSION["ParSQL"] = "INSERT INTO SOLICITUD (PVE, TEX) VALUES ($PVE,'CZ')";
		$registros = mssql_query($_SESSION["ParSQL"]) or die("Error SQL: ".$_SESSION["ParSQL"]);
		rollback($registros);

	}	
	rollback($registros);


	$_SESSION["ParSQL"] = "select BCICS from APARSIS";
	$registros = mssql_query($_SESSION["ParSQL"]) or die("Error SQL: ".$_SESSION["ParSQL"]);
	rollback($registros);
	while ($reg=mssql_fetch_array($registros)){
		$BCICS = $reg['BCICS'];
	}
	if($BCICS == true){



		$_SESSION["ParSQL"] = "SELECT * FROM TMAEFACT WHERE PLA= '".$PLA."' AND LUG = ".$_SESSION['ParLUG']." ORDER BY fec desc,tip desc";
		
		$registros = mssql_query($_SESSION["ParSQL"]) or die("Error SQL: ".$_SESSION["ParSQL"]);
		rollback($registros);
		while ($reg=mssql_fetch_array($registros)){

			GuardarComprobantesCI($PLA,$reg);

		}
/////////////////////////////////////////////////////////////////////////////////
/////////////////////////////////////////////////////////////////////////////////
//  VERIFICAR QUE LA TMAEFACT ESTA VACIA
	$_SESSION["ParSQL"] = "SELECT * FROM TMAEFACT WHERE PLA = ".$PLA;
	$STMAEFACT = mssql_query($_SESSION['ParSQL']) or die("Error SQL");
	rollback($STMAEFACT);
	if(mssql_num_rows($STMAEFACT) != 0){
		$_SESSION["ParSQL"] = "DELETE TMAEFACT WHERE PLA = ".$PLA;
		mssql_query($_SESSION["ParSQL"]) or die("Error SQL: ".$_SESSION["ParSQL"]);
		rollback($registros);	
	}

/////////////////////////////////////////////////////////////////////////////////
/////////////////////////////////////////////////////////////////////////////////

	}
	


$FCT = date("Ymd H:i:s");
$_SESSION["ParSQL"] = "UPDATE ATURNOSO SET CER = 'C', FCT = '".$FCT."' WHERE PLA = ".$PLA." AND LUG = '".$_SESSION['ParLUG']."'";
$registros = mssql_query($_SESSION["ParSQL"]) or die("Error SQL: ".$_SESSION["ParSQL"]);
rollback($registros);


$_SESSION["ParSQL"] = "UPDATE VENDEDORES SET NPLVEN = 0, TURVEN = 0 WHERE CODVEN = '".$_SESSION['idsusua']."'";
$registros = mssql_query($_SESSION["ParSQL"]) or die("Error SQL: ".$_SESSION["ParSQL"]);
rollback($registros);


/***************** COLOCAR PARAMETRO PARA PLANILLAS *****************/
	//$PLA_TER = 0;
	$COMMAND = mssql_query("SELECT PLA_TER FROM COMMAND") or die("Error SQL");
	while ($COMMAND_REG = mssql_fetch_array($COMMAND)){
		$PLA_TER = $COMMAND_REG['PLA_TER'];
	}
	mssql_free_result($COMMAND);
	if($PLA_TER == 0){
		$_SESSION["ParSQL"] = "UPDATE APARPOS SET OPE = 0, EST = 'C' WHERE OPE = '".$_SESSION['idsusua']."'";
		$registros = mssql_query($_SESSION["ParSQL"]) or die("Error SQL: ".$_SESSION["ParSQL"]);
		rollback($registros);
	}else{
		$_SESSION["ParSQL"] = "UPDATE APARPOS SET OPE = 0, EST = 'C'";
		$registros = mssql_query($_SESSION["ParSQL"]) or die("Error SQL: ".$_SESSION["ParSQL"]);
		rollback($registros);
	}
/*******************************************************************/


$_SESSION["ParSQL"] = "UPDATE ACONFTUO SET HAB = 'N' WHERE LUG = '".$_SESSION['ParLUG']."'";
$registros = mssql_query($_SESSION["ParSQL"]) or die("Error SQL: ".$_SESSION["ParSQL"]);
rollback($registros);


mssql_query("commit transaction") or die("Error SQL commit");


?>
<script>
	$('#Bloquear').fadeOut(500);
	jAlert('Turno Cerrado correctamete, Caja: <? echo $PLA; ?>', 'Debo Retail - Global Business Solution');

	SoloNone('CierreTurno');
	document.getElementById('CierreTurno').innerHTML = '';
	document.getElementById("CarAyuda").style.display="none";
	document.getElementById("CarAyudaFon").style.display="none";
	Mos_Ocu('BotonesPri');
	Mos_Ocu('fondotranspletras');
	Mos_Ocu('TecladoLet');
	Mos_Ocu('fondotranspnumeros');
	Mos_Ocu('TecladoNum');		
	
</script>
<?

}catch(Exception $e){////////////////////////////////////////////////////////////////////////////////////////////////// FIN DE TRY //
	
	?>
	<script>
		$('#Bloquear').fadeOut(500);
		jAlert('ERORR Reintente la operacion solicitada.', 'Debo Retail - Global Business Solution');
	</script>
	<?
exit;

}

?>