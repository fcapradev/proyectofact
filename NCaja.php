<?
require("config/cnx.php");


try {////////////////////////////////////////////////////////////////////////////////////////////////// COMIENZO TRY //


mssql_query("begin transaction",$conexion) or die("Error SQL begin trans");


?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
</head>
<body>
<?

$PLA = $_POST['pla'];
$LUG = $_SESSION['ParLUG'];
$TER = $_SESSION['ParPOS'];

$catits = 12;

for($i=0; $i<$catits; $i++){	
	$teCOT[$i] = 0;
	$teREN[$i] = 0;
	$teTOT[$i] = 0;
	$tePAR[$i] = 0;
	
}

$catits2 = 7;
	
	$_SESSION['ParSQL'] = "SELECT ID FROM CPARBON";
	$CPARBON = mssql_query($_SESSION['ParSQL']) or die("Error SQL");	
	rollback($CPARBON);	
	$r = mssql_num_rows($CPARBON);
	$catits2 = $catits2 + $r;
	mssql_free_result($CPARBON);


for($i=0; $i<$catits2; $i++){
	$teREN[$i] = $_POST['TexU'.$i];
}

for($i=0; $i<$catits2; $i++){
	$tePAR[$i] = $_POST['TexP'.$i];
}

for($i=0; $i<$catits2; $i++){
	$teTOT[$i] = $_POST['TexT'.$i];
}

////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
$nTotRen = 0.00;////////////////////////////////////////////////////////////////////////////////////////////////////////////
$nTotTot = 0.00;////////////////////////////////////////////////////////////////////////////////////////////////////////////
////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////

for ($N1 = 0; $N1 <= $catits-1; $N1++){
  $teTOT[$N1] = dec($teREN[$N1] + $tePAR[$N1], 2);
  
  if($N1==5 || $N1==7){
	$nTotRen = $nTotRen - $teREN[$N1];
	$nTotTot = $nTotTot - $teTOT[$N1];		  
  }else{
	$nTotRen = $nTotRen + $teREN[$N1];
	$nTotTot = $nTotTot + $teTOT[$N1];		  
	  
  }
  $teTotRen = dec($nTotRen,2);
}


for($i=0; $i<$catits2; $i++){

	$v = dec($teREN[$i],2);
    ?>
	<script>
		IValue('<? echo "TexU".$i; ?>','<? echo $v; ?>');
	</script>
	<?

}

for($i=0; $i<$catits2; $i++){

	$v = dec($teTOT[$i],2);
    ?>
	<script>
		IValue('<? echo "TexT".$i; ?>','<? echo $v; ?>');
	</script>
	<?
	
}


$OBS_EFE_ENT = $_POST['DesEfeEnt'];
$OBS_VUELTO = $_POST['DesVuelto'];


//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
/////////////////////////// MARCELO AILLO ////////////////////////////////////////////////////////////////////////////////////////////////////////////////
//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
$_SESSION['FechaaGrabar'] = date('Ymd H:i:s');


	$_SESSION['ParSQL'] = "SELECT PDTGT, BCICS FROM APARSIS";
	$APARSIS = mssql_query($_SESSION['ParSQL']) or die("Error SQL");
	rollback($APARSIS);		
	while ($RAPA=mssql_fetch_array($APARSIS)){
		 $PDTGT = $RAPA['PDTGT'];// si $PDTGT = TRUE tiene gastos
		 $BCICS = $RAPA['BCICS'];// si elimina todos los comprobantes de la temaefcat
	}

	if($PDTGT == true){
		
	   $DET0 = substr($Detalle_0, 0, 45);
	   $DET1 = substr($Detalle_1, 0, 45);
	   $DET2 = substr($Detalle_2, 0, 45);
	   $DET3 = substr($Detalle_3, 0, 45);
	   
	   if(strlen($DET0) > 0 || strlen($DET1) > 0 || strlen($DET2) > 0 || strlen($DET3) > 0) {
		  
			$_SESSION['ParSQL'] = "SELECT * FROM ADETGAST where PLA = ".$PLA." AND LUG = ".$LUG."";
			$ADETGAST = mssql_query($_SESSION['ParSQL']) or die("Error SQL");
			rollback($ADETGAST);
			if(mssql_num_rows($ADETGAST)<>0){
				$_SESSION['ParSQL'] = "UPDATE ADETGAST SET DET0='".$DET0."', DET1='".$DET1."',DET2='".$DET2."',DET3='".$DET3."' where pla = ".$PLA." AND LUG = ".$LUG."";
				$UADETGAST = mssql_query($_SESSION['ParSQL']) or die("Error SQL");
				rollback($UADETGAST);	
			}else{
				
				$_SESSION['ParSQL'] = "INSERT ADETGAST (PLA,LUG,DET0,DET1,DET2,DET3) VALUES (".$PLA.",".$LUG.",'".$DET0."','".$DET1."','".$DET2."','".$DET3."')";
				$IADETGAST = mssql_query($_SESSION['ParSQL']) or die("Error SQL");
				rollback($IADETGAST);	
			}
	   }
	}
	
	if ($BCICS == true) {
		
		$_SESSION['ParSQL'] = "SELECT * FROM TMAEFACT WHERE PLA = ".$PLA."";
		$STMAEFACT = mssql_query($_SESSION['ParSQL']) or die("Error SQL");
		rollback($STMAEFACT);
		if(mssql_num_rows($STMAEFACT) != 0){
			$_SESSION['ParSQL'] = "DELETE TMAEFACT WHERE PLA = ".$PLA."";
			$DTMAEFACT = mssql_query($_SESSION['ParSQL']) or die("Error SQL");
			rollback($DTMAEFACT);			
		}
		
		$_SESSION['ParSQL'] = "SELECT * FROM TMAEFACT_T WHERE PLA = ".$PLA." AND TER = ".$TER."";
		$STMAEFACT = mssql_query($_SESSION['ParSQL']) or die("Error SQL");
		rollback($STMAEFACT);
		if(mssql_num_rows($STMAEFACT) != 0){
			$_SESSION['ParSQL'] = "DELETE TMAEFACT_T WHERE PLA = ".$PLA." AND TER = ".$TER."";
			$DTMAEFACT = mssql_query($_SESSION['ParSQL']) or die("Error SQL");
			rollback($DTMAEFACT);			
		}
	}
	
	
	//UPDATE DE LA ATURNOSO CON LOS DATOS CARGADOS

	$_SESSION['ParSQL'] = "SELECT DEF FROM COMMAND";
	$COMMAND = mssql_query($_SESSION['ParSQL']) or die("Error SQL");
	rollback($COMMAND);		
	while ($RCOM=mssql_fetch_array($COMMAND)){
		 $CierreEnTurno = $RCOM['DEF'];	 
	}
	
	$def = 0;
	if ($CierreEnTurno == true){
		$def = 1;	
	}
	
	$nTotCta=0;
	$nTotCtaR=0;
	$nTotEfe=0;
	
	$_SESSION['ParSQL'] = "SELECT TCO,FPA,NET,IVA,IMI,IMI2,PER FROM VTOTVTAPLF where pla = ".$PLA." AND LUG = ".$LUG."";
	$VTOTVTAPLF = mssql_query($_SESSION['ParSQL']) or die("Error SQL");
	rollback($VTOTVTAPLF);		
	while ($RVTA=mssql_fetch_array($VTOTVTAPLF)){
		if ($RVTA['TCO'] == "NC"){
			if ($RVTA['FPA'] <> 2){
				$nTotEfe = $nTotEfe - ($RVTA['NET'] + $RVTA['IVA'] + $RVTA['IMI'] + $RVTA['IMI2'] + $RVTA['PER']);
			}else{
				if ($RVTA['FPA'] == 2){
					$nTotCtaR = $nTotCtaR - ($RVTA['NET'] + $RVTA['IVA'] + $RVTA['IMI'] + $RVTA['IMI2'] + $RVTA['PER']);
				}else{
					$nTotCta = $nTotCta - ($RVTA['NET'] + $RVTA['IVA'] + $RVTA['IMI'] + $RVTA['IMI2'] + $RVTA['PER']);
				}
			}	 
			
		}else{
		
				if ($RVTA['FPA'] <> 2){
				$nTotEfe = $nTotEfe + ($RVTA['NET'] + $RVTA['IVA'] + $RVTA['IMI'] + $RVTA['IMI2'] + $RVTA['PER']);
			}else{
				if ($RVTA['FPA'] == 2){
					$nTotCtaR = $nTotCtaR + ($RVTA['NET'] + $RVTA['IVA'] + $RVTA['IMI'] + $RVTA['IMI2'] + $RVTA['PER']);
				}else{
					$nTotCta = $nTotCta + ($RVTA['NET'] + $RVTA['IVA'] + $RVTA['IMI'] + $RVTA['IMI2'] + $RVTA['PER']);
				}
			}	
		}	 
	}
	
	$nTotVta = $nTotEfe + $nTotCta + $nTotCtaR;
	$nTotAre = $teTOT[0]  + $teTOT[8] + $teTOT[9] + $teTOT[10] + $teTOT[11] + $teTOT[1] + $teTOT[2] + $teTOT[3] + $teTOT[4] +$teTOT[6] - $teTOT[5] - $teTOT[7];
	$nDifCaj = ($nTotAre + $nTotCta + $nTotCtaR) - $nTotVta;


//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
////// CREAR CAMPOS PARA COTIZACION ACTUAL ///////////////////////////////////////////////////////////////////////////////////////////////////////////////
//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
	$_SESSION['ParSQL'] = "SELECT [COT] FROM CPARBON";
	$CPARBON = mssql_query($_SESSION['ParSQL']) or die("Error SQL");
	rollback($CPARBON);	
	$i = 0;	
	$COT[0] = 0;
	$COT[1] = 0;
	$COT[2] = 0;
	$COT[3] = 0;
	$COT[4] = 0;
	while($CPA_R=mssql_fetch_array($CPARBON)){
		 $COT[$i] = $CPA_R['COT'];
		 $i = $i + 1;
	}
	mssql_free_result($CPARBON);
	
	$_SESSION['ParSQL'] = "
	UPDATE ATURNOSO SET
		REF=".$teTOT[0].",
		RGA=".$teTOT[1].",
		RVA=".$teTOT[2].",
		RAN=".$teTOT[3].",
		RTA=".$teTOT[4].",
		CAR=".$teTOT[5].",
		CAE=".$teTOT[6].",
		TCT=".dec($teTotRen,2).",
		REF1=".$teTOT[7].",
		REF2=".$teTOT[8].",
		REF3=".$teTOT[9].",
		REF4=".$teTOT[10].",
		REF5=".$teTOT[11].",
		CRL=0,
		DEF=".$def.",
		RCC=".$nTotCta.",
		RCR=".$nTotCtaR.",
		DCM=0,
		DIF=".$nDifCaj.",
		CER='C',
		PLC='S',
		OBS_VUELTO='',
		OBS_EFE_ENT='".$OBS_EFE_ENT."',
		COT1=".$COT[0].",
		COT2=".$COT[1].",
		COT3=".$COT[2].",
		COT4=".$COT[3].",
		COT5=".$COT[4]."
	WHERE PLA = ".$PLA." AND LUG = ".$LUG."";
	$ATURNOSO = mssql_query($_SESSION['ParSQL']) or die("Error SQL");
	rollback($ATURNOSO);
//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////


function insertar($datosR,$marcaR,$ordenR){

$TER = $_SESSION['ParPOS'];

$_SESSION['ParSQL'] = "INSERT INTO CONTROL_STOCK_IMPRE (POS,INF,REM,FEC,DET,ORD) VALUES (".$TER.",1,".$marcaR.",'".$_SESSION['FechaaGrabar']."','".$datosR."',".$ordenR.")";
$CONTROL_STOCK_IMPRE = mssql_query($_SESSION['ParSQL']) or die("Error SQL");
rollback($CONTROL_STOCK_IMPRE);		

}

function buscar_nombre_tarjeta($idTar){
	$_SESSION['ParSQL'] = "SELECT NOM FROM ATARJETAS WHERE ID=".$idTar."";
	$RSBTABLA = mssql_query($_SESSION['ParSQL']) or die("Error SQL");
	rollback($RSBTABLA);	
	while ($RB=mssql_fetch_array($RSBTABLA)){
		return $RB['NOM'];
	}
}

function buscar_nombre_bono($idbon){
	$_SESSION['ParSQL'] = "SELECT DES FROM CPARBON WHERE ID=".$idbon."";
	$RSBTABLA = mssql_query($_SESSION['ParSQL']) or die("Error SQL");
	rollback($RSBTABLA);	
	while ($RB=mssql_fetch_array($RSBTABLA)){
		return $RB['DES'];
	}
}

function buscar_nombre_operario($codven){
	$_SESSION['ParSQL'] = "SELECT NomVen FROM VENDEDORES WHERE CodVen=".$codven."";
	$RSBTABLA = mssql_query($_SESSION['ParSQL']) or die("Error SQL");
	rollback($RSBTABLA);	
	while ($RB=mssql_fetch_array($RSBTABLA)){
		return $RB['NomVen'];
	}
}

function buscar_nombre_rubro($cs,$cr){
	$_SESSION['ParSQL'] = "SELECT NomRub FROM RUBROS WHERE Codsec=".$cs." and CodRub=".$cr."";
	$RSBTABLA = mssql_query($_SESSION['ParSQL']) or die("Error SQL");
	rollback($RSBTABLA);	
	while ($RB=mssql_fetch_array($RSBTABLA)){
		return $RB['NomRub'];
	}
}

function busca_tipo($t){
	$_SESSION['ParSQL'] = "SELECT [DESC] FROM TIPO_NOVEDADES WHERE id=".$t."";
	$RSBTABLA = mssql_query($_SESSION['ParSQL']) or die("Error SQL");
	rollback($RSBTABLA);	
	while ($RB=mssql_fetch_array($RSBTABLA)){
		return $RB['DESC'];
	}

}

function busca_desc($t,$d){
	$_SESSION['ParSQL'] = "SELECT [DESC] FROM DESC_TIPO_NOVEDADES WHERE ID_TIPO_NOVEDAD = ".$t." AND ID = ".$d."";
	$RSBTABLA = mssql_query($_SESSION['ParSQL']) or die("Error SQL");
	rollback($RSBTABLA);	
	while ($RB=mssql_fetch_array($RSBTABLA)){
		return $RB['DESC'];
	}

}

//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////

//***********************************************************************************************************************************************
// limpiar para empezar
	$_SESSION['ParSQL'] = "DELETE CONTROL_STOCK_IMPRE WHERE POS = ".$TER." AND INF=1";
	$RS1TABLA = mssql_query($_SESSION['ParSQL']) or die("Error SQL");
	rollback($RS1TABLA);	


//***********************************************************************************************************************************************
//ENCABEZADO
   	$OPE=0;
	$orden=0;
	$_SESSION['ParSQL'] = "SELECT * FROM ATURNOSO WHERE PLA=".$PLA." AND LUG=".$LUG."";
	$RS1TABLA = mssql_query($_SESSION['ParSQL']) or die("Error SQL");
	rollback($RS1TABLA);	
	while ($R1=mssql_fetch_array($RS1TABLA)){
	
			$PLA = $R1['PLA'];
			$datoe = " Caja N&uacute;mero: ".$PLA;
			$orden = $orden + 1;
			$marca=0;
			insertar($datoe,$marca,$orden);

			//DAR FORMATO A LA FECHA A ENVIAR
			$fecha = $R1['FAP'];
			$date = new DateTime($fecha);
			$FAP = $date->format('d/m/Y H:i');
			
			$fecha = $R1['FCT'];
			$date = new DateTime($fecha);
			$FPC = $date->format('d/m/Y H:i');
			
			$datoe = " Apertura: ".$FAP." -  Cierre: ".$FPC."";
			$orden = $orden + 1;
			$marca = 0;			
			insertar($datoe,$marca,$orden);
			
			//NOMBRE OPERARIO
			$OPE=$R1['OPE'];
			$NOMOPE="No existe responsable";
			$_SESSION['ParSQL'] = "SELECT NomVen FROM VENDEDORES WHERE CODVEN=".$OPE."";
			$RS2TABLA = mssql_query($_SESSION['ParSQL']) or die("Error SQL");
			rollback($RS2TABLA);	
			while ($R2=mssql_fetch_array($RS2TABLA)){
				$NOMOPE=$R2['NomVen'];
			}
			
			$datoe=" Responsable: ".$NOMOPE;
			$orden=$orden + 1;
			$marca=0;			
			insertar($datoe,$marca,$orden);
			
			$datoe="";
			$orden=$orden + 1;
			$marca=0;			
			insertar($datoe,$marca,$orden);
			
 		    $datoe=str_repeat("_", 70);
			$orden=$orden + 1;
			$marca=0;			
			insertar($datoe,$marca,$orden);		    
			$datoe=" Operarios del Turno: ";
			$orden=$orden + 1;
			$marca=0;			
			insertar($datoe,$marca,$orden);

			//operarios habilitados
		    $datoe=" C&oacute;digo    Nombre Operario              Fecha Ingreso    Hora Ingreso";
			$orden=$orden + 1;
			$marca=0;			
			insertar($datoe,$marca,$orden);

			$_SESSION['ParSQL'] = "SELECT * FROM ope_pla WHERE NplVen = ".$PLA." order by fecha,hora";
			$RS3TABLA = mssql_query($_SESSION['ParSQL']) or die("Error SQL");
			rollback($RS3TABLA);	
			while ($R3=mssql_fetch_array($RS3TABLA)){
				$NOMOPE = trim($R3['NomVen']);
				$sTemp = $NOMOPE.str_repeat(" ", 25 - strlen($NOMOPE)); 
				$datoe = str_repeat(" ", 4).format($R3['CodVen'],4,'0',STR_PAD_LEFT).str_repeat(" ", 8).$sTemp.str_repeat(" ", 4).$R3['Fecha'].str_repeat(" ", 7).$R3['Hora'];
				$orden=$orden + 1;
				$marca=0;			
				insertar($datoe,$marca,$orden);
			}
	
		    $datoe=str_repeat("_", 70);
			$orden=$orden + 1;
			$marca=0;			
			insertar($datoe,$marca,$orden);
		    $datoe=" Comprobantes Emitidos: ";
			$orden=$orden + 1;
			$marca=0;			
			insertar($datoe,$marca,$orden);

			$HuboComprobantes = "N";
			$_SESSION['ParSQL'] = "SELECT TIP,TCO,SUC,MIN(NCO) AS 'PRIMERO' ,MAX(NCO) AS 'ULTIMO' FROM AMAEFACT WHERE PLA = ".$PLA." AND LUG = ".$LUG." AND TCO='TI' GROUP BY TIP,TCO,SUC";
			$RS4TABLA = mssql_query($_SESSION['ParSQL']) or die("Error SQL");
			rollback($RS4TABLA);	
			while ($R4=mssql_fetch_array($RS4TABLA)){
				$HuboComprobantes = "S";
				$datoe= str_repeat(" ", 3).$R4['TCO']." ".$R4['TIP']." ".format($R4['SUC'],4,'0',STR_PAD_LEFT)."-".format($R4['PRIMERO'],8,'0',STR_PAD_LEFT)." AL ".format($R4['SUC'],4,'0',STR_PAD_LEFT)."-".format($R4['ULTIMO'],8,'0',STR_PAD_LEFT);
				$orden=$orden + 1;
				$marca=0;			
				insertar($datoe,$marca,$orden);
			}

			$_SESSION['ParSQL'] = "SELECT TIP,TCO,SUC,MIN(NCO) AS 'PRIMERO' ,MAX(NCO) AS 'ULTIMO' FROM AMAEFACT WHERE PLA =".$PLA." AND LUG = " .$LUG. " AND TCO='FT' AND TIP='A' GROUP BY TIP,TCO,SUC ";
			$RS4TABLA = mssql_query($_SESSION['ParSQL']) or die("Error SQL");
			rollback($RS4TABLA);	
			while ($R4=mssql_fetch_array($RS4TABLA)){
				$HuboComprobantes = "S";
				$datoe= str_repeat(" ", 3).$R4['TCO']." ".$R4['TIP']." ".format($R4['SUC'],4,'0',STR_PAD_LEFT)."-".format($R4['PRIMERO'],8,'0',STR_PAD_LEFT)." AL ".format($R4['SUC'],4,'0',STR_PAD_LEFT)."-".format($R4['ULTIMO'],8,'0',STR_PAD_LEFT);
				$orden=$orden + 1;
				$marca=0;			
				insertar($datoe,$marca,$orden);
			}

			$_SESSION['ParSQL'] = "SELECT TIP,TCO,SUC,MIN(NCO) AS 'PRIMERO' ,MAX(NCO) AS 'ULTIMO' FROM AMAEFACT WHERE PLA = ".$PLA." AND LUG = ".$LUG." AND TCO='FT' AND TIP='B' GROUP BY TIP,TCO,SUC";
			$RS4TABLA = mssql_query($_SESSION['ParSQL']) or die("Error SQL");
			rollback($RS4TABLA);	
			while ($R4=mssql_fetch_array($RS4TABLA)){
				$HuboComprobantes = "S";
				$datoe= str_repeat(" ", 3).$R4['TCO']." ".$R4['TIP']." ".format($R4['SUC'],4,'0',STR_PAD_LEFT)."-".format($R4['PRIMERO'],8,'0',STR_PAD_LEFT)." AL ".format($R4['SUC'],4,'0',STR_PAD_LEFT)."-".format($R4['ULTIMO'],8,'0',STR_PAD_LEFT);
				$orden=$orden + 1;
				$marca=0;			
				insertar($datoe,$marca,$orden);
			}

	if(!$HuboComprobantes=="S"){
				$datoe=" SIN Comprobantes Emitidos"; 
				$orden=$orden + 1;
				$marca=0;			
				insertar($datoe,$marca,$orden);
		
		}			
	}

//***********************************************************************************************************************************************	
//Control_Vta_Rubro

	$_SESSION['ParSQL'] = "DELETE IMPRE_A_CTRL_VTA_RUB";
	$RS1TABLA = mssql_query($_SESSION['ParSQL']) or die("Error SQL");
	rollback($RS1TABLA);	
	
	$_SESSION['ParSQL'] = "SELECT A.PLA,A.COD, B.RUB, MAX(C.NOMRUB) AS NOM, SUM(CAN)AS CAN ,SUM(PUN*CAN) AS TOT FROM AMOVFACT AS A INNER JOIN A_CTRL_VTA_RUB AS B ON A.COD=B.SEC AND A.RUB=B.RUB INNER JOIN RUBROS AS C ON B.SEC=C.CODSEC AND B.RUB=C.CODRUB INNER JOIN AMAEFACT AS D ON D.CYV=A.CYV AND D.TIP=A.TIP AND D.TCO=A.TCO AND D.SUC=A.SUC AND D.NCO=A.NCO WHERE D.FPA NOT IN(2) AND D.ANU<>'A' AND A.PLA = ".$PLA." GROUP BY A.PLA,A.COD, B.RUB";
	$RS4TABLA = mssql_query($_SESSION['ParSQL']) or die("Error SQL");
	rollback($RS4TABLA);	
	while ($R4=mssql_fetch_array($RS4TABLA)){

		$_SESSION['ParSQL'] = "INSERT IMPRE_A_CTRL_VTA_RUB VALUES (".$R4['PLA'].", ".$R4['COD'].", ".$R4['RUB'].", '".$R4['NOM']."', ".$R4['CAN'].", ".$R4['TOT'].")";
		$RS1TABLA = mssql_query($_SESSION['ParSQL']) or die("Error SQL");
		rollback($RS1TABLA);	
	}
/*	
	$_SESSION['ParSQL'] = "SELECT A.PLA, SUM(CAN)AS CAN ,SUM(PUN*CAN) AS TOT FROM AMOVFACT as a inner join RUBROS as b ON a.cod=b.CODSEC AND a.RUB=b.CODRUB INNER JOIN AMAEFACT AS D ON D.CYV=A.CYV AND D.TIP=A.TIP AND D.TCO=A.TCO AND D.SUC=A.SUC AND D.NCO=A.NCO WHERE  not exists  (SELECT * FROM A_CTRL_VTA_RUB as c WHERE a.cod=c.sec and a.rub=c.rub )AND D.FPA NOT IN(2) AND D.ANU<>'A' AND A.PLA=".$PLA." GROUP BY A.PLA";
	$RS4TABLA = mssql_query($_SESSION['ParSQL']) or die("Error SQL");
	rollback($RS4TABLA);	
	while ($R4=mssql_fetch_array($RS4TABLA)){

		$_SESSION['ParSQL'] = "INSERT IMPRE_A_CTRL_VTA_RUB VALUES (".$R4['PLA'].", ".$R4['COD'].", ".$R4['RUB'].", '".$R4['NOM']."', ".$R4['CAN'].", ".$R4['TOT'].")";
		$RS1TABLA = mssql_query($_SESSION['ParSQL']) or die("Error SQL");
		rollback($RS1TABLA);	
	}	
*/

	$datoe=str_repeat("_", 70); 
	$orden=$orden + 1;
	$marca=0;			
	insertar($datoe,$marca,$orden);

	$datoe=" RESUMEN DE VENTAS "; 
	$orden=$orden + 1;
	$marca=1;			
	insertar($datoe,$marca,$orden);
	
	$datoe="Rubro   Nombre Rubro                         Cantidad    Importe"; 
	$orden=$orden + 1;
	$marca=0;			
	insertar($datoe,$marca,$orden);	


	$_SESSION['ParSQL'] = "SELECT * FROM IMPRE_A_CTRL_VTA_RUB WHERE SEC <> 0 AND RUB <> 0 AND PLA = ".$PLA."";
	$RS1TABLA = mssql_query($_SESSION['ParSQL']) or die("Error SQL");
	rollback($RS1TABLA);	
	while ($R1=mssql_fetch_array($RS1TABLA)){

		$datoe=" "; 
		$orden=$orden + 1;
		$marca=0;			
		insertar($datoe,$marca,$orden);		
		$datoe=format($R1['SEC'],2,'0',STR_PAD_LEFT)."-".
		format($R1['RUB'],3,'0',STR_PAD_LEFT)." "
		.trim($R1['DESC_RUB']).
		str_repeat(" ", 33 - strlen(trim($R1['DESC_RUB']))).
		str_repeat(" ", 11 - strlen(dec($R1['CANTIDAD'], 2))).
		dec($R1['CANTIDAD'], 2).
		str_repeat(" ", 11 - strlen(dec($R1['IMPORTE'], 2))).
		dec($R1['IMPORTE'], 2);
		$orden=$orden + 1;
		$marca=0;			
		insertar($datoe,$marca,$orden);	
	}	


	$_SESSION['ParSQL'] = "SELECT * FROM IMPRE_A_CTRL_VTA_RUB WHERE SEC = 0 AND RUB = 0 AND PLA = ".$PLA."";
	$RS1TABLA = mssql_query($_SESSION['ParSQL']) or die("Error SQL");
	rollback($RS1TABLA);	
	while ($R1=mssql_fetch_array($RS1TABLA)){

		$datoe=" "; 
		$orden=$orden + 1;
		$marca=0;			
		insertar($datoe,$marca,$orden);	
// AQUI ************************************************ REEMPLZAR	
//    Cargar_Linea "Ventas Generales                                           ".Format(tDato!Importe, "0.00")

		$datoe="Ventas Generales".str_repeat(" ", 43).dec($R1['IMPORTE'], 2); 
		$orden=$orden + 1;
		$marca=0;			
		insertar($datoe,$marca,$orden);	
	}	

	$cTOT=0;
	$_SESSION['ParSQL'] = "SELECT SUM(IMPORTE)IMP FROM IMPRE_A_CTRL_VTA_RUB WHERE PLA = ".$PLA." GROUP BY PLA";
	$RS1TABLA = mssql_query($_SESSION['ParSQL']) or die("Error SQL");
	rollback($RS1TABLA);	
	while ($R1=mssql_fetch_array($RS1TABLA)){
		$cTOT = $cTOT + $R1['IMP'];
	}	
	
	$datoe=" "; 
	$orden=$orden + 1;
	$marca=0;			
	insertar($datoe,$marca,$orden);	
// Cargar_Linea "TOTAL A RENDIR                                             ".Format(cTot, "0.00")
	$datoe="TOTAL A RENDIR".str_repeat(" ", 45).dec($cTOT, 2); 
	$orden=$orden + 1;
	$marca=0;			
	insertar($datoe,$marca,$orden);	

//***********************************************************************************************************************************************
//   Call Rendicion



    $sVuelto = "";
	$datoe=str_repeat("_", 70); 
	$orden=$orden + 1;
	$marca=0;			
	insertar($datoe,$marca,$orden);	

	$datoe=" RENDICION "; 
	$orden=$orden + 1;
	$marca=1;			
	insertar($datoe,$marca,$orden);	

	$Retiros=0;
	$_SESSION['ParSQL'] = "SELECT SUM(EFE) AS TOT FROM ATURRPA WHERE PLA = ".$PLA." AND EFE <> 0 AND ANU<>1";
	$RS1TABLA = mssql_query($_SESSION['ParSQL']) or die("Error SQL");
	rollback($RS1TABLA);	
	while ($R1=mssql_fetch_array($RS1TABLA)){
		$Retiros = $Retiros + $R1['TOT'];
	}	

	$_SESSION['ParSQL'] = "SELECT CAR,REF, REF1, REF2, REF3, REF4, REF5, RTA, CAE, RGA, CRL, OBS_VUELTO, OBS_EFE_REC, OBS_EFE_ENT FROM ATURNOSO WHERE PLA = ".$PLA."";
	$RS1TABLA = mssql_query($_SESSION['ParSQL']) or die("Error SQL");
	rollback($RS1TABLA);	
	while ($R1=mssql_fetch_array($RS1TABLA)){
//DAR FORMATO A TODOS 0.00
		$datoe=" + EFECTIVO RECIBIDO........: $ ".dec($R1['CAR'], 2).""; 
		$orden=$orden + 1;
		$marca=0;			
		insertar($datoe,$marca,$orden);	
		$CambioRecibido = $R1['CAR'];
		$Total_Efectivo = $R1['REF'];

		$datoe="- EFECTIVO.................: $ ".dec($Total_Efectivo, 2)."";
		$orden=$orden + 1;
		$marca=0;			
		insertar($datoe,$marca,$orden);	

//TRAER NOMBRE DEL BONO
		if($R1['REF1'] > 0){
			$nombono=buscar_nombre_bono(1);
			$datoe="- ".trim($nombono).str_repeat(".", 25 - strlen(trim($nombono))).": $ ".dec($R1['REF1'],2);
			$orden=$orden + 1;
			$marca=0;			
			insertar($datoe,$marca,$orden);	
		}
		if($R1['REF2'] > 0){
			$nombono=buscar_nombre_bono(2);
			$datoe="- ".trim($nombono).str_repeat(".", 25 - strlen(trim($nombono))).": $ ".dec($R1['REF2'],2);
			$orden=$orden + 1;
			$marca=0;			
			insertar($datoe,$marca,$orden);	
		}
		if($R1['REF3'] > 0){
			$nombono=buscar_nombre_bono(3);
			$datoe="- ".trim($nombono).str_repeat(".", 25 - strlen(trim($nombono))).": $ ".dec($R1['REF3'],2);
			$orden=$orden + 1;
			$marca=0;			
			insertar($datoe,$marca,$orden);	
		}
  
  		if($R1['REF4'] > 0){
			$nombono=buscar_nombre_bono(4);
			$datoe="- ".trim($nombono).str_repeat(".", 25 - strlen(trim($nombono))).": $ ".dec($R1['REF4'],2);
			$orden=$orden + 1;
			$marca=0;			
			insertar($datoe,$marca,$orden);	
		}

		if($R1['REF5'] > 0){
			$nombono=buscar_nombre_bono(5);
			$datoe="- ".trim($nombono).str_repeat(".", 25 - strlen(trim($nombono))).": $ ".dec($R1['REF5'],2);
			$orden=$orden + 1;
			$marca=0;			
			insertar($datoe,$marca,$orden);	
		}


		$datoe="- TARJETAS.................: $ ".dec($R1['RTA'],2)."";
		$orden=$orden + 1;
		$marca=0;			
		insertar($datoe,$marca,$orden);	

		$datoe="- VUELTO...................: $ ".dec($R1['CRL'],2)."";
		$orden=$orden + 1;
		$marca=0;			
		insertar($datoe,$marca,$orden);	

	    $ObsVuelto = $R1['OBS_VUELTO'];
		
		$datoe="- EFECTIVO ENTREGADO.......: $ ".dec($R1['CAE'],2)."";
		$orden=$orden + 1;
		$marca=0;			
		insertar($datoe,$marca,$orden);	
		
	    $CambioEntregado = $R1['CAE'];
      	$Valores = $Total_Efectivo + ($R1['REF1'] + $R1['REF2']  + $R1['REF3']  + $R1['REF4']  + $R1['REF5'] ) + $R1['RTA'];
		
		$datoe="VALORES DEL TURNO............: $ ".dec($Valores,2)."";
		$orden=$orden + 1;
		$marca=0;			
		insertar($datoe,$marca,$orden);	
		
		 $Gastos = $R1['RGA'];
		 $OBS_EFE_REC = $R1['OBS_EFE_REC'];
		 $OBS_VUELTO = $R1['OBS_VUELTO'];
		 $OBS_EFE_ENT = $R1['OBS_EFE_ENT'];
	}	

	$datoe=" ";
	$orden=$orden + 1;
	$marca=0;			
	insertar($datoe,$marca,$orden);	
   	if(!$Retiros == 0 ) {
		$datoe="- RETIROS..................: $ ".dec($Retiros,2)."";
		$orden=$orden + 1;
		$marca=0;			
		insertar($datoe,$marca,$orden);	
	}

	$Anticipos=0;
	$_SESSION['ParSQL'] = "SELECT isnull (SUM(ANT),0) AS TOT FROM ATURRPA WHERE PLA = ".$PLA." AND ANU<>1";
	$RS1TABLA = mssql_query($_SESSION['ParSQL']) or die("Error SQL");
	rollback($RS1TABLA);	
	while ($R1=mssql_fetch_array($RS1TABLA)){
		$datoe="- ANTICIPOS................: $ ".dec($R1['TOT'],2);
		$orden=$orden + 1;
		$marca=0;			
		insertar($datoe,$marca,$orden);			
		$Anticipos = $Anticipos + $R1['TOT'];
	}	

	$datoe="- PAGOS DEL TURNO..........: $ ".dec($Gastos,2)."";
	$orden=$orden + 1;
	$marca=0;			
	insertar($datoe,$marca,$orden);
	$Egresos = $Gastos + $Anticipos + $Retiros;
	
	$datoe="EGRESOS DEL TURNO............: $ ".dec($Egresos,2)."";
	$orden=$orden + 1;
	$marca=0;			
	insertar($datoe,$marca,$orden);
	
	$datoe=" ";
	$orden=$orden + 1;
	$marca=0;			
	insertar($datoe,$marca,$orden);
	
    $Total_Rendido = $Egresos + $Valores;
    $Total_Rendido = $CambioEntregado - $CambioRecibido + $Total_Rendido;
	
	$datoe="TOTAL RENDIDO................: $ ".dec($Total_Rendido,2)."";
	$orden=$orden + 1;
	$marca=0;			
	insertar($datoe,$marca,$orden);

	$datoe=" ";
	$orden=$orden + 1;
	$marca=0;			
	insertar($datoe,$marca,$orden);

	$DiferCaja = ($Valores - $Total_Rendido) * -1;
	$datoe="DIFERENCIA DE CAJA...........: $ ".dec($DiferCaja,2)."";
	$orden=$orden + 1;
	$marca=0;			
	insertar($datoe,$marca,$orden);

   	if(!strlen($OBS_EFE_REC) == 0 ){
		$datoe=" ";
		$orden=$orden + 1;
		$marca=0;			
		insertar($datoe,$marca,$orden);

		$orden=$orden + 1;
		insertar($datoe,$marca,$orden);

		$datoe="- OBS. DEL EFECTIVO RECIBIDO: ";
		$orden=$orden + 1;
		insertar($datoe,$marca,$orden);
		
		if(strlen($OBS_EFE_REC) > 99){
			$datoe=substr($OBS_EFE_REC, 99);
			$orden=$orden + 1;
			insertar($datoe,$marca,$orden);			
			
			$datoe=substr($OBS_EFE_REC, 100,199);
			$orden=$orden + 1;
			insertar($datoe,$marca,$orden);			
				  
			$datoe=substr($OBS_EFE_REC, 200);
			$orden=$orden + 1;
			insertar($datoe,$marca,$orden);		
		}else{
			$datoe=$OBS_EFE_REC;
			$orden=$orden + 1;
			insertar($datoe,$marca,$orden);		
		}

	}


   	if(!strlen($OBS_EFE_ENT) == 0 ){
		$datoe=" ";
		$orden=$orden + 1;
		$marca=0;			
		insertar($datoe,$marca,$orden);

		$orden=$orden + 1;
		insertar($datoe,$marca,$orden);

		$datoe="- OBS. DEL EFECTIVO ENTREGADO: ";
		$orden=$orden + 1;
		insertar($datoe,$marca,$orden);
		
		if( strlen($OBS_EFE_ENT) > 99){
			$datoe=substr($OBS_EFE_ENT, 99);
			$orden=$orden + 1;
			insertar($datoe,$marca,$orden);			
			
			$datoe=substr($OBS_EFE_ENT, 100,199);
			$orden=$orden + 1;
			insertar($datoe,$marca,$orden);			
				  
			$datoe=substr($OBS_EFE_ENT, 200);
			$orden=$orden + 1;
			insertar($datoe,$marca,$orden);		
		}else{
			$datoe=$OBS_EFE_ENT;
			$orden=$orden + 1;
			insertar($datoe,$marca,$orden);		
		}
	}


   	if(!strlen($OBS_VUELTO) == 0 ){
		$datoe=" ";
		$orden=$orden + 1;
		$marca=0;			
		insertar($datoe,$marca,$orden);

		$orden=$orden + 1;
		insertar($datoe,$marca,$orden);

		$datoe="- OBSERVACIÓN DEL VUELTO: ";
		$orden=$orden + 1;
		insertar($datoe,$marca,$orden);
		
		if( strlen($OBS_VUELTO) > 99){
			$datoe=substr($OBS_VUELTO, 99);
			$orden=$orden + 1;
			insertar($datoe,$marca,$orden);			
			
			$datoe=substr($OBS_VUELTO, 100,199);
			$orden=$orden + 1;
			insertar($datoe,$marca,$orden);			
				  
			$datoe=substr($OBS_VUELTO, 200);
			$orden=$orden + 1;
			insertar($datoe,$marca,$orden);		
		}else{
			$datoe=$OBS_VUELTO;
			$orden=$orden + 1;
			insertar($datoe,$marca,$orden);		
		}
	}

//***********************************************************************************************************************************************
//   Call Total_Tarjetas

	$TOTALES_TARJETAS = 0;
	
	$datoe=str_repeat("_", 70);
	$orden=$orden + 1;
	$marca=0;			
	insertar($datoe,$marca,$orden);

	$datoe=" ";
	$orden=$orden + 1;
	$marca=0;			
	insertar($datoe,$marca,$orden);

	$datoe=" TOTALES POR TARJETA ";
	$orden=$orden + 1;
	$marca=1;			
	insertar($datoe,$marca,$orden);

	$datoe=" ";
	$orden=$orden + 1;
	$marca=0;			
	insertar($datoe,$marca,$orden);

	$_SESSION['ParSQL'] = "SELECT TAR, SUM(IMP) AS IMP FROM ACUPONES WHERE PLA = ".$PLA." GROUP BY TAR";
	$RS1TABLA = mssql_query($_SESSION['ParSQL']) or die("Error SQL");
	rollback($RS1TABLA);	
	while ($R1=mssql_fetch_array($RS1TABLA)){
		// VER SI TOT NO ES NULL OJO Y DAR FORMATO 0.00
		$NomTar = buscar_nombre_tarjeta($R1['TAR']);
		$Temp = format($R1['TAR'],3,'0',STR_PAD_LEFT)." ".$NomTar;		

		$Temp = " ".trim($Temp).str_repeat(".", 25 - strlen(trim($Temp))).".................: $ ".dec($R1['IMP'], 2);
		$datoe=$Temp;
		$orden=$orden + 1;
		$marca=0;			
		insertar($datoe,$marca,$orden);			
		$TOTALES_TARJETAS = $TOTALES_TARJETAS + $R1['IMP'];

	}	

	if($TOTALES_TARJETAS > 0 ){
		$datoe="TOTAL TARJETAS.................................: $ ".dec($TOTALES_TARJETAS,2);
		$orden=$orden + 1;
		$marca=0;			
		insertar($datoe,$marca,$orden);			
		
	}else{
		$datoe="PLANILLA SIN TARJETAS";
		$orden=$orden + 1;
		$marca=0;			
		insertar($datoe,$marca,$orden);			
	}

//***********************************************************************************************************************************************
//   Call Rendiciones_Parciales

	$datoe=str_repeat("_", 70);
	$orden=$orden + 1;
	$marca=0;			
	insertar($datoe,$marca,$orden);			

	$datoe=" RETIRO DE EFECTIVO Y ANTICIPOS";
	$orden=$orden + 1;
	$marca=1;			
	insertar($datoe,$marca,$orden);			

	$datoe=" ";
	$orden=$orden + 1;
	$marca=0;			
	insertar($datoe,$marca,$orden);			

	$datoe="N&uacute;mero".str_repeat(" ", 3)."Operario".str_repeat(" ", 14)."Fecha".str_repeat(" ", 17)."Importe".str_repeat(" ", 7)."¿Anulada?".str_repeat(" ", 5)."Tipo";
	$orden=$orden + 1;
	$marca=0;			
	insertar($datoe,$marca,$orden);			

	$datoe=" ";
	$orden=$orden + 1;
	$marca=0;			
	insertar($datoe,$marca,$orden);			

	$TOTAL_ANTICIPO = 0;
	$TOTAL_RENDPAR = 0;
	$_SESSION['ParSQL'] = "SELECT * FROM ATURRPA WHERE PLA=".$PLA." AND LUG=".$LUG." ORDER BY FEC";
	$RS1TABLA = mssql_query($_SESSION['ParSQL']) or die("Error SQL");
	rollback($RS1TABLA);	
	while ($R1=mssql_fetch_array($RS1TABLA)){
         $tmpNomVen = buscar_nombre_operario($R1['OPE']);
         $Temp = format($R1['OPE'],5,'0',STR_PAD_LEFT)."-".$tmpNomVen;
		 $Aux = "NO";
		 if($R1['ANU']){
			 $Aux = "SI";
 		 }
		 if($R1['ANT'] > 0 ){
			 $Aux2= "Anticipo";
		 }elseif($R1['EFE'] > 0 ){
			 $Aux2= "Retiro";
		 }
		$SumaEfeAnt=$R1['EFE'] + $R1['ANT'];
		$datoe=format($R1['NUM'],5,'0',STR_PAD_LEFT)."    ".substr($Temp,0, 20).str_repeat(" ", 21 - strlen(substr($Temp,0, 20)))." ".$R1['FEC']."   ".dec($SumaEfeAnt, 2).str_repeat(" ", 10).$Aux.str_repeat(" ", 8).$Aux2;

		$orden=$orden + 1;
		$marca=0;			
		insertar($datoe,$marca,$orden);			
		if($Aux2 == "Anticipo"){
			if(strlen($R1['OBS_ANTICIPO'])> 0 ){
				$datoe="Observaciones: ".$R1['OBS_ANTICIPO']."";
				$orden=$orden + 1;
				$marca=0;			
				insertar($datoe,$marca,$orden);			
			}
			if ($Aux == "NO"){
				$TOTAL_ANTICIPO = $TOTAL_ANTICIPO + $R1['ANT'];
			} 
		}elseif($Aux2 = "Retiro"){
			if(strlen($R1['OBS_RETIRO'])> 0 ){
				$datoe="Observaciones: ".$R1['OBS_RETIRO']."";
				$orden=$orden + 1;
				$marca=0;			
				insertar($datoe,$marca,$orden);			
			}
			if ($Aux == "NO"){
				$TOTAL_RENDPAR = $TOTAL_RENDPAR + $R1['EFE'];
			} 
		}
	}
	if (!$TOTAL_RENDPAR==0){
// cambiar
		$datoe="TOTAL RETIROS........................................".dec($TOTAL_RENDPAR, 2);
		$orden=$orden + 1;
		$marca=0;			
		insertar($datoe,$marca,$orden);			
	}
	if(!$TOTAL_ANTICIPO==0){
		$datoe="TOTAL ANTICIPOS......................................".dec($TOTAL_ANTICIPO,2);
		$orden=$orden + 1;
		$marca=0;			
		insertar($datoe,$marca,$orden);		
	}
	if($TOTAL_RENDPAR==0 and $TOTAL_ANTICIPO==0){
		$datoe="Sin Retiro de Ventas y Anticipos";
		$orden=$orden + 1;
		$marca=0;			
		insertar($datoe,$marca,$orden);		
	}


//***********************************************************************************************************************************************
//   Call Compras

   	$TotComprasContado = 0;
   	$TotComprasCtaCte = 0;
	$datoe=" ";
	$orden=$orden + 1;
	$marca=0;			
	insertar($datoe,$marca,$orden);		

	$datoe=" PAGOS DEL TURNO ";
	$orden=$orden + 1;
	$marca=1;			
	insertar($datoe,$marca,$orden);		
	
	$datoe=str_repeat("_", 70);
	$orden=$orden + 1;
	$marca=0;			
	insertar($datoe,$marca,$orden);		


	$datoe=" DETALLE DE COMPRAS CONTADO ";
	$orden=$orden + 1;
	$marca=1;			
	insertar($datoe,$marca,$orden);		


	$datoe="Proveedor".str_repeat(" ", 25)."Comprobante".str_repeat(" ", 9)."Importe".str_repeat(" ", 14)."FH";
	$orden=$orden + 1;
	$marca=0;			
	insertar($datoe,$marca,$orden);		


	$TotComprasContado = 0;
	$TotFueradeHora = 0;
	$TotComprasCtaCte = 0;

	$_SESSION['ParSQL'] = "SELECT * FROM PMAEFACT  WHERE PLA = ".$PLA." AND LUG = ".$LUG." AND CG = 'C' AND FPA = 1";
	$RS1TABLA = mssql_query($_SESSION['ParSQL']) or die("Error SQL");
	rollback($RS1TABLA);	
	while ($R1=mssql_fetch_array($RS1TABLA)){
		
         $LineaEnvio = "";
		
		 $LineaEnvio = format($R1['COD'],5,'0',STR_PAD_LEFT)." "."-"." ".substr(trim($R1['NOM']),0, 19).str_repeat(" ",23 - strlen(substr(trim($R1['NOM']), 0,19))).$R1['TCO']." ".$R1['TIP']." ".format($R1['SUC'],4,'0',STR_PAD_LEFT)." "."-"." ".format($R1['NCO'],8,'0',STR_PAD_LEFT);
		 
		if($R1['TCO'] == "NC"){
			if($R1['FPA'] == 1){
				
               $LineaEnvio = $LineaEnvio.str_repeat(" ",11 - strlen(dec($R1['TOT'],2)))."$"." ".dec($R1['TOT'],2);
               $TotComprasContado = $TotComprasContado - $R1['TOT'];
			   
               if ($R1['PFH'] = "S"){
                  $TotFueradeHora = $TotFueradeHora - $R1['TOT'];
                  $LineaEnvio = $LineaEnvio.str_repeat(" ",30)."*";
			   }
			}else{
               $LineaEnvio = $LineaEnvio.str_repeat(" ",26 - strlen(dec($R1['TOT'],2)))."$"." ".dec($R1['TOT'],2);
               $TotComprasCtaCte = $TotComprasCtaCte - $R1['TOT'];
			}
		}else{
            if($R1['FPA']= 1){
               $LineaEnvio =$LineaEnvio.str_repeat(" ",11 - strlen(dec($R1['TOT'],2)))."$"." ".dec($R1['TOT'],2);
               $TotComprasContado = $TotComprasContado + $R1['TOT'];
			}else{
               $LineaEnvio =$LineaEnvio.str_repeat(" ",26 - strlen(dec($R1['TOT'],2)))."$"." ".dec($R1['TOT'],2);
               $TotComprasCtaCte = $TotComprasCtaCte + $R1['TOT'];
			}
		}

		$datoe=$LineaEnvio;
		$orden=$orden + 1;
		$marca=0;			
		insertar($datoe,$marca,$orden);		
	}
	
	$TotFueradeHora = 0;
	
	$_SESSION['ParSQL'] = "SELECT * FROM PMAEFACT WHERE PLA=".$PLA." AND LUG=".$LUG." AND CG='C' AND FPA=1";
	$RS1TABLA = mssql_query($_SESSION['ParSQL']) or die("Error SQL");
	rollback($RS1TABLA);

	while ($R1=mssql_fetch_array($RS1TABLA)){
		$LineaEnvio = "";
		$LineaEnvio = substr(trim($R1['NOM']),0,20).str_repeat(" ",31 - substr(trim($R1['NOM']),0,20)).$R1['TCO']." ".$R1['TIP']." ".format($R1['SUC'],4,'0',STR_PAD_LEFT)." "."-"." ".format($R1['NCO'],8,'0',STR_PAD_LEFT);
		if ($R1['FPA']= 1){
			// cargar variables
		   $LineaEnvio = $LineaEnvio.str_repeat(" ",11 - strlen(dec($R1['TOT'],2)))."$"." ".dec($R1['TOT'],2);
		}else{
			// cargar variables
		   $LineaEnvio = $LineaEnvio.str_repeat(" ",26 - strlen(dec($R1['TOT'],2)))."$"." ".dec($R1['TOT'],2);
		}
		// cargar variables
		$LineaEnvio = $LineaEnvio.str_repeat(" ",15).$R1['PFH'];
		$TotFueradeHora = $TotFueradeHora + $R1['TOT'];
		$datoe=$LineaEnvio;
		$orden=$orden + 1;
		$marca=0;			
		insertar($datoe,$marca,$orden);		
      	
		//cambiar formato
		$Total_Compras_Contado = dec($TotComprasContado,2);
		
		//string y formatos
		$datoe="TOTAL COMPRAS CONTADO".str_repeat(" ",33)."$ ".dec($TotComprasContado,2);
		$orden=$orden + 1;
		$marca=0;			
		insertar($datoe,$marca,$orden);		
	}
	//ver el signo de distinto
	if ($TotComprasContado <> 0 or $TotComprasCtaCte <> 0 or $TotFueradeHora <> 0 ){
		$datoe="    Sin Compras";
		$orden=$orden + 1;
		$marca=0;			
		insertar($datoe,$marca,$orden);		
		
	}

//***********************************************************************************************************************************************
//   Call Gastos

   	$TotGastosContado = 0;
 	$TotGastosCtaCte = 0;

	
	
	$datoe=str_repeat("_", 70);
	$orden=$orden + 1;
	$marca=0;			
	insertar($datoe,$marca,$orden);		

	$datoe=" DETALLE DE GASTOS  ";
	$orden=$orden + 1;
	$marca=1;			
	insertar($datoe,$marca,$orden);		

	$datoe=" Descripci&oacute;n del Gasto".str_repeat(" ",31)."Comprobante".str_repeat(" ",9)."Importe".str_repeat(" ",33)."FH";
	$orden=$orden + 1;
	$marca=0;			
	insertar($datoe,$marca,$orden);		

	
	$_SESSION['ParSQL'] = "SELECT * FROM PMAEFACT WHERE PLA=".$PLA." AND LUG=".$LUG." AND CG = 'G' AND FPA=1";
	$RS1TABLA = mssql_query($_SESSION['ParSQL']) or die("Error SQL");
	rollback($RS1TABLA);	
	while ($R1=mssql_fetch_array($RS1TABLA)){
         $LineaEnvio = "";
// VER TEMA DE FORMATOS		 
         $LineaEnvio = $LineaEnvio.substr(trim($R1['NOM']),0, 40).str_repeat(" ",48 - strlen(substr(trim($R1['NOM']),0,40))).$R1['TCO']." ".$R1['TIP']." ".format($R1['SUC'],4,'0',STR_PAD_LEFT)." "."-"." ".format($R1['NCO'],8,'0',STR_PAD_LEFT);
         if($R1['TCO'] == "NC"){
			if($R1['FPA'] == 1) {
				$LineaEnvio = $LineaEnvio.str_repeat(" ",11 - strlen(dec($R1['TOT'],2)))."$"." ".dec($R1['TOT'],2);
				$TotGastosContado = $TotGastosContado - $R1['TOT'];
				if($R1['PFH'] == "S"){
					$TotFueradeHora = $TotFueradeHora - $R1['TOT'];
                  	$LineaEnvio = $LineaEnvio.String(30, " ")."*";

				}
			}else{
               $LineaEnvio = $LineaEnvio.str_repeat(" ",26 - strlen(dec($R1['TOT'],2)))."$"." ".dec($R1['TOT'],2);
               $TotGastosCtaCte = $TotGastosCtaCte - $R1['TOT'];
			}
		 }else{
			 if($R1['FPA'] == 1) {
               $LineaEnvio = $LineaEnvio.str_repeat(" ",11 - strlen(dec($R1['TOT'],2)))."$"." ".dec($R1['TOT'],2);
               $TotGastosContado = $TotGastosContado + $R1['TOT'];
				 
			 }else{
               $LineaEnvio = $LineaEnvio.str_repeat(" ",26 - strlen(dec($R1['TOT'],2)))."$"." ".dec($R1['TOT'],2);
               $TotGastosCtaCte = $TotGastosCtaCte + $R1['TOT'];
			 }
		 }

		$datoe= $LineaEnvio;
		$orden=$orden + 1;
		$marca=0;			
		insertar($datoe,$marca,$orden);		

		$datoe= "Observaciones: ".$R1['OBS'];
		$orden=$orden + 1;
		$marca=0;			
		insertar($datoe,$marca,$orden);		
		 
	}

	$_SESSION['ParSQL'] = "SELECT * FROM COMP_FH WHERE PLA_ACT = ".$PLA." AND CG = 'G' AND FPA=1";
	$RS1TABLA = mssql_query($_SESSION['ParSQL']) or die("Error SQL");
	rollback($RS1TABLA);	
	while ($R1=mssql_fetch_array($RS1TABLA)){
            $LineaEnvio = "";
            $LineaEnvio = substr(trim($R1['TIO']),0, 40).str_repeat(" ",48 - strlen(substr(trim($R1['TIO']),0,40))).$R1['TCO']." ".$R1['TIP']." ".format($R1['SUC'],4,'0',STR_PAD_LEFT)." "."-"." ".format($R1['NCO'],8,'0',STR_PAD_LEFT);
						
            if ($R1['FPA'] == 1) {
				$LineaEnvio = $LineaEnvio.str_repeat(" ",11 - strlen(dec($R1['TOT'],2)))."$"." ".dec($R1['TOT'],2);
			}else{
				$LineaEnvio = $LineaEnvio.str_repeat(" ",26 - strlen(dec($R1['TOT'],2)))."$"." ".dec($R1['TOT'],2);
			}
               
            $LineaEnvio = $LineaEnvios.str_repeat(" ", 8).$R1['PLA_FH'];
            $TotFueradeHora = $TotFueradeHora + $R1['TOT'];

			$datoe= $LineaEnvio;
			$orden=$orden + 1;
			$marca=0;			
			insertar($datoe,$marca,$orden);		
			

			$datoe= "Observaciones: ".$R1['OBS'];
			$orden=$orden + 1;
			$marca=0;			
			insertar($datoe,$marca,$orden);		
	}
	$Total_Gastos = dec($TotGastosContado, 2);

	if ($Total_Gastos > 0){
		$datoe= "TOTAL GASTOS ".str_repeat(" ", 55).str_repeat(" ",11 - strlen($Total_Gastos))."$ ".$Total_Gastos;
		$orden=$orden + 1;
		$marca=0;			
		insertar($datoe,$marca,$orden);		
	}else{
		$datoe= "    Sin Gastos";
		$orden=$orden + 1;
		$marca=0;			
		insertar($datoe,$marca,$orden);		

	}
	

//***********************************************************************************************************************************************
//   Call Comprobantes_ListaPrecios


	$TotCompLP = 0;
	
	$datoe=str_repeat("_", 70);
	$orden=$orden + 1;
	$marca=0;			
	insertar($datoe,$marca,$orden);		


	$datoe="  DETALLE DE COMPROBANTES CON LISTA DE PRECIO";
	$orden=$orden + 1;
	$marca=1;			
	insertar($datoe,$marca,$orden);		

	$datoe="Cliente".str_repeat(" ", 23)."Comprobante".str_repeat(" ", 25)."Importe".str_repeat(" ", 8);
	$orden=$orden + 1;
	$marca=0;			
	insertar($datoe,$marca,$orden);		
   
	$_SESSION['ParSQL'] = "SELECT C.NOM, A.TIP,A.TCO,A.SUC,A.NCO, A.TOT FROM AMAEFACT AS A INNER JOIN AMOVFACT AS B ON A.CYV=B.CYV AND A.TIP=B.TIP AND A.TCO=B.TCO AND A.SUC=B.SUC AND A.NCO=B.NCO INNER JOIN CLIENTES AS C ON A.COD=C.COD WHERE A.PLA = ".$PLA." AND B.PUN<>B.PUT AND C.TLI='E' AND A.FPA=2";
	$RS1TABLA = mssql_query($_SESSION['ParSQL']) or die("Error SQL");
	rollback($RS1TABLA);	
	while ($R1=mssql_fetch_array($RS1TABLA)){

         $datoe=substr(trim($R1['NOM']),0, 25).str_repeat(" ",26 - strlen(substr(trim($R1['NOM']),0,25))).str_repeat(" ", 5).$R1['TIP']." ".$R1['TCO']." ".format($R1['SUC'],4,'0',STR_PAD_LEFT)." "."-"." ".format($R1['NCO'],8,'0',STR_PAD_LEFT).str_repeat(" ", 18).dec($R1['TOT'],2);

		$orden=$orden + 1;
		$marca=0;			
		insertar($datoe,$marca,$orden);		
        $TotCompLP = $TotCompLP + $R1['TOT'];
	}

	if($TotCompLP >0){
		$datoe="TOTAL COMPROBANTES CON LISTA DE PRECIO".str_repeat(" ", 24).str_repeat(" ",9 - strlen(dec($TotCompLP,2)))."$ ".dec($TotCompLP,2);
		$orden=$orden + 1;
		$marca=0;			
		insertar($datoe,$marca,$orden);		
		
	}else{
		$datoe=" Sin Comprobantes con Lista de Precio. ";
		$orden=$orden + 1;
		$marca=0;			
		insertar($datoe,$marca,$orden);		
		
	}

//***********************************************************************************************************************************************
//   Call Compras_Cta_Cte

   $TotComprasContado = 0;
   $TotComprasCtaCte = 0;


	$datoe=str_repeat("_", 70);
	$orden=$orden + 1;
	$marca=0;			
	insertar($datoe,$marca,$orden);		

	$datoe=" DETALLE DE COMPRAS EN CUENTA CORRIENTE ";
	$orden=$orden + 1;
	$marca=1;			
	insertar($datoe,$marca,$orden);		

	$datoe=" Proveedor".str_repeat(" ", 26)."Comprobante".str_repeat(" ", 27)."Importe".str_repeat(" ", 14);
	$orden=$orden + 1;
	$marca=0;			
	insertar($datoe,$marca,$orden);		


	$_SESSION['ParSQL'] = "SELECT * FROM PMAEFACT WHERE PLA=".$PLA." AND LUG=".$LUG." AND CG='C' AND FPA=2";
	$RS1TABLA = mssql_query($_SESSION['ParSQL']) or die("Error SQL");
	rollback($RS1TABLA);	
	while ($R1=mssql_fetch_array($RS1TABLA)){
      	$LineaEnvio = "";
        $LineaEnvio = format($R1['COD'],5,'0',STR_PAD_LEFT)." "."-"." ".substr(trim($R1['NOM']),0, 19).str_repeat(" ",23 - strlen(substr(trim($R1['NOM']),0,19))).$R1['TCO']." ".$R1['TIP']." ".format($R1['SUC'],4,'0',STR_PAD_LEFT)." "."-"." ".format($R1['NCO'],8,'0',STR_PAD_LEFT);
         if ($R1['TCO'] == "NC") {
			 if ($R1['FPA'] == 1) {
			   $LineaEnvio = $LineaEnvio.str_repeat(" ",11 - strlen(dec($R1['TOT'],2)))."$"." ".dec($R1['TOT'],2); 
               $TotComprasContado = $TotComprasContado - $R1['TOT'];
               if ($R1['PFH'] = "S") {
                  $TotFueradeHora = $TotFueradeHora - $R1['TOT'];
                  $LineaEnvio = $LineaEnvio.str_repeat(" ", 30)."*";
			   }
			 }else{
               $LineaEnvio = $LineaEnvio.str_repeat(" ",26 - strlen(dec($R1['TOT'],2)))."$"." ".dec($R1['TOT'],2); 
               $TotComprasCtaCte = $TotComprasCtaCte - $R1['TOT'];
			 }
		 }else{
            if ($R1['FPA'] = 1) {
               $LineaEnvio = $LineaEnvio.str_repeat(" ",11 - strlen(dec($R1['TOT'],2)))."$"." ".dec($R1['TOT'],2); 
               $TotComprasContado = $TotComprasContado + $R1['TOT'];
			}else{
               $LineaEnvio = $LineaEnvio.str_repeat(" ",26 - strlen(dec($R1['TOT'],2)))."$"." ".dec($R1['TOT'],2); 
               $TotComprasCtaCte = $TotComprasCtaCte + $R1['TOT'];
			}
		 }
		 
		$datoe=$LineaEnvio;
		$orden=$orden + 1;
		$marca=0;			
		insertar($datoe,$marca,$orden);		
	}


	$_SESSION['ParSQL'] = "SELECT * FROM COMP_FH WHERE PLA_ACT = ".$PLA." AND CG = 'C'  AND FPA=2";
	$RS1TABLA = mssql_query($_SESSION['ParSQL']) or die("Error SQL");
	rollback($RS1TABLA);	
	while ($R1=mssql_fetch_array($RS1TABLA)){
		$LineaEnvio = "";
		
		$LineaEnvio = substr(trim($R1['TIO']),0, 20).str_repeat(" ",31 - strlen(substr(trim($R1['TIO']),0,20))).$R1['TCO']." ".$R1['TIP']." ".format($R1['SUC'],4,'0',STR_PAD_LEFT)." "."-"." ".format($R1['NCO'],8,'0',STR_PAD_LEFT);
		if ($R1['FPA'] == 1) {
		   $LineaEnvio = $LineaEnvio.str_repeat(" ",11 - strlen(dec($R1['TOT'],2)))."$"." ".dec($R1['TOT'],2);
		}else{
		   $LineaEnvio =$LineaEnvio.str_repeat(" ",26 - strlen(dec($R1['TOT'],2)))."$"." ".dec($R1['TOT'],2);
		}
		$LineaEnvio = $LineaEnvio.str_repeat(" ", 15).$R1['PLA_FH'];
		$TotFueradeHora = $TotFueradeHora + $R1['TOT'];
		
		$datoe=$LineaEnvio;
		$orden=$orden + 1;
		$marca=0;			
		insertar($datoe,$marca,$orden);		
	}
	if($TotComprasCtaCte > 0) {
		$datoe="TOTAL COMPRAS CUENTA CORRIENTE".str_repeat(" ", 30).str_repeat(" ",15 - strlen(dec($TotComprasCtaCte,2))).str_repeat(" ", 3)."$".dec($TotComprasCtaCte, 2);
		$orden=$orden + 1;
		$marca=1;			
		insertar($datoe,$marca,$orden);		
	}else{
		$datoe="    Sin Compras en cuenta corriente";
		$orden=$orden + 1;
		$marca=0;			
		insertar($datoe,$marca,$orden);		
		
	}
	
//***********************************************************************************************************************************************
//   Call Datos_Informativos

	$SumaDI=0;
	$datoe=str_repeat("_", 70);
	$orden=$orden + 1;
	$marca=0;			
	insertar($datoe,$marca,$orden);		


	$datoe="  DATOS INFORMATIVOS ";
	$orden=$orden + 1;
	$marca=1;			
	insertar($datoe,$marca,$orden);		

	$datoe=" ";
	$orden=$orden + 1;
	$marca=0;			
	insertar($datoe,$marca,$orden);		
   
	$datoe=" Comprobantes Anulados  ";
	$orden=$orden + 1;
	$marca=1;			
	insertar($datoe,$marca,$orden);		


	
	$_SESSION['ParSQL'] = "SELECT NOM, TIP,TCO, SUC,NCO,TOT FROM AMAEFACT WHERE NOM NOT LIKE '%CAMBIO TI%' AND ANU='A' AND PLA = ".$PLA."";
	$RS1TABLA = mssql_query($_SESSION['ParSQL']) or die("Error SQL");
	rollback($RS1TABLA);	
	while ($R1=mssql_fetch_array($RS1TABLA)){
// CARGAR LAS VARIABLES
//		Cargar_Linea Trim($R1['NOM']).String(25 - Len(Trim($R1['NOM'])), " ").Trim($R1['TIP'])."-".Trim($R1['TCO'])."-".Format($R1['SUC'], "0000")."-".Format($R1['NCO'], "00000000")."$ ".Format($R1['TOT'], "0.00")
$LineaEnvio = substr(trim($R1['NOM']),0, 24).str_repeat(" ",25 - strlen(substr(trim($R1['NOM']),0,24))).$R1['TIP']." ".$R1['TCO']." ".format($R1['SUC'],4,'0',STR_PAD_LEFT)." "."-"." ".format($R1['NCO'],8,'0',STR_PAD_LEFT).str_repeat(" ", 26).dec($R1['TOT'],2);
		$datoe=" ";
		$orden=$orden + 1;
		$marca=0;			
		insertar($datoe,$marca,$orden);		
		$SumaDI= $SumaDI + $R1['TOT'];
	}
	
	if($SumaDI == 0){
		$datoe="No hay comprobantes anulados en esta planilla.";
		$orden=$orden + 1;
		$marca=0;			
		insertar($datoe,$marca,$orden);		
		
	}
	

//***********************************************************************************************************************************************
//   Call Recuentos

   $Fila = 0;
   $Contador = 0;
   $I = 1;

	$_SESSION['ParSQL'] = "SELECT count(pla) AS CANT FROM CONTEO_PLANILLA WHERE PLA=".$PLA." AND LUG=".$LUG."";
	$RS1TABLA = mssql_query($_SESSION['ParSQL']) or die("Error SQL");
	rollback($RS1TABLA);	
	while ($R1=mssql_fetch_array($RS1TABLA)){
		$CantRegistros = $R1['CANT'];
	}

   $CantFilas = (int)($CantRegistros / 3);
   $CMOD = $CantRegistros%3;
   if ($CMOD > 0) {
      $CantFilas = $CantFilas + 1;
   }
   if($CantFilas > 0) {
      $Fila[$CantFilas];
   }



	$SumaDI=0;
	$datoe=str_repeat("_", 70);
	$orden=$orden + 1;
	$marca=0;			
	insertar($datoe,$marca,$orden);		


	$datoe=" DETALLE DE RECUENTO DE CAJA ";
	$orden=$orden + 1;
	$marca=1;			
	insertar($datoe,$marca,$orden);		

	$datoe="Hora".str_repeat(" ", 9)."Importe".str_repeat(" ", 7)."Hora".str_repeat(" ", 8)."Importe".str_repeat(" ", 8)."Hora".str_repeat(" ", 9)."Importe";
	$orden=$orden + 1;
	$marca=0;			
	insertar($datoe,$marca,$orden);		

	$_SESSION['ParSQL'] = "SELECT * FROM CONTEO_PLANILLA WHERE PLA=".$PLA." AND LUG=".$LUG." ORDER BY FEC,HORA";
	$RS1TABLA = mssql_query($_SESSION['ParSQL']) or die("Error SQL");
	rollback($RS1TABLA);	
	$nr = mssql_num_rows($RS1TABLA); 
	$col = 0;
	$fila = "";
	if(!$nr == 0){
		while ($R1=mssql_fetch_array($RS1TABLA)){
						
			$col = $col + 1;
			$fila = $fila.$R1['HORA'].str_repeat(" ",12 - strlen(dec($R1['IMP_0'],2))).dec($R1['IMP_0'],2).str_repeat(" ", 7);
			
			if($col == 3){
				
				$datoe = $fila;
				$orden = ++$orden;
				$marca = 0;			
				insertar($datoe,$marca,$orden);		
				$col = 0;
				$fila = "";
				
			}
			 
		}
		if($col != 3){
					
			$datoe = $fila;
			$orden = ++$orden;
			$marca = 0;			
			insertar($datoe,$marca,$orden);		
			$col = 0;
			$fila = "";
					
		}
		
	}else{
		$datoe="Sin Recuentos de Caja";
		$orden=++$orden;
		$marca=0;			
		insertar($datoe,$marca,$orden);		
	}


//***********************************************************************************************************************************************
//   Call Control_Stock


	$_SESSION['ParSQL'] = "DELETE FROM CONTROL_STOCK";
	$RS1TABLA = mssql_query($_SESSION['ParSQL']) or die("Error SQL");
	rollback($RS1TABLA);	
	
	$_SESSION['ParSQL'] = "SELECT * FROM ACONF_CONTROL_STOCK";
	$RS1TABLA = mssql_query($_SESSION['ParSQL']) or die("Error SQL");
	rollback($RS1TABLA);	
	while ($R1=mssql_fetch_array($RS1TABLA)){
//			  'PRIMERO INSERTAMOS TODO LO REFERENTE AL RUBRO A CONTROLAR  -- REEMPLAZAR SECTOR Y RUBRO
		$_SESSION['ParSQL'] = "Insert Control_Stock(Sec, Art, Rub, Det) (SELECT CODSEC,CODART,CODRUB,DETART FROM ARTICULOS WHERE CODSEC=".$R1['SEC']." AND CODRUB=".$R1['RUB'].")";
		$RS2TABLA = mssql_query($_SESSION['ParSQL']) or die("Error SQL");
		rollback($RS2TABLA);	

		//'--MOVIMIENTO STOCK ANTERIOR - INGRESOS COMPRAS
		$_SESSION['ParSQL'] =  "SELECT SEC,ART,MIN(C.DETART) 'DETALLE',MIN(C.CODRUB) 'RUBRO', ((SELECT ISNULL(SUM(B.CAN),0) FROM AMOVSTOC B WHERE A.SEC = B.SEC AND A.ART = B.ART AND ANU <> 'A' AND B.TCO<>'NC' AND B.CYV='C')+ (SELECT ISNULL(SUM(B.CAN),0) * -1 FROM AMOVSTOC B WHERE A.SEC = B.SEC AND  A.ART = B.ART AND ANU <> 'A' AND B.TCO='NC' AND B.CYV='C')) -  ((SELECT ISNULL(SUM(B.CAN),0) FROM AMOVSTOC B WHERE A.SEC = B.SEC AND A.ART = B.ART AND ANU <> 'A' AND B.TCO<>'NC' AND B.CYV='V') + (SELECT ISNULL(SUM(B.CAN),0) * -1 FROM AMOVSTOC B WHERE A.SEC = B.SEC AND A.ART = B.ART AND ANU <> 'A' AND B.TCO='NC' AND B.CYV='V')) 'CANTIDAD_TOTAL_STOCK_ANTERIOR' FROM AMOVSTOC A INNER JOIN ARTICULOS C ON A.SEC=C.CODSEC AND A.ART=C.CODART Where A.PLA<".$PLA." AND A.LUG=".$LUG." And C.CODSEC = ".$R1['SEC']." And C.CODRUB in (".$R1['RUB'].") AND ANU <> 'A' GROUP BY SEC,ART ";
		$RS3TABLA = mssql_query($_SESSION['ParSQL']) or die("Error SQL");
		rollback($RS3TABLA);	
		while ($R3=mssql_fetch_array($RS3TABLA)){
            $_SESSION['ParSQL'] =  "UPDATE CONTROL_STOCK SET ST_ANT = ".str_replace(",",".",$R31['CANTIDAD_TOTAL_STOCK_ANTERIOR'])." WHERE SEC=".$R3['SEC']." AND ART=".$R3['ART']." AND RUB=".$R3['RUBRO']."";
		$RS2TABLA = mssql_query($_SESSION['ParSQL']) or die("Error SQL");
		rollback($RS2TABLA);	
			
		}
	
	//      '--MOVIMIENTO STOCK ACTUAL - INGRESOS COMPRAS
		  $_SESSION['ParSQL'] =  "SELECT SEC,ART,MIN(C.DETART) 'DETALLE',MIN(C.CODRUB) 'RUBRO', (SELECT ISNULL(SUM(B.CAN),0) FROM AMOVSTOC B WHERE A.SEC = B.SEC AND A.ART = B.ART AND B.ANU <> 'A' AND B.TCO<>'NC' AND B.CYV='C' AND B.PLA=".$PLA.") + (SELECT ISNULL(SUM(B.CAN),0) * -1 FROM AMOVSTOC B WHERE A.SEC = B.SEC AND A.ART = B.ART AND B.ANU <> 'A' AND B.TCO='NC' AND B.CYV='C' AND B.PLA=".$PLA.") 'CANTIDAD_TOTAL_COMPRA', (SELECT ISNULL(SUM(B.CAN),0) FROM AMOVSTOC B WHERE A.SEC = B.SEC AND A.ART = B.ART AND B.ANU <> 'A' AND B.TCO<>'NC' AND B.CYV='V' AND B.PLA=".$PLA.") + (SELECT ISNULL(SUM(B.CAN),0) * -1 FROM AMOVSTOC B WHERE A.SEC = B.SEC AND A.ART = B.ART AND B.ANU <> 'A' AND B.TCO='NC' AND B.CYV='V' AND B.PLA=".$PLA.") 'CANTIDAD_TOTAL_VENTA', ((SELECT ISNULL(SUM(B.CAN),0) FROM AMOVSTOC B WHERE A.SEC = B.SEC AND A.ART = B.ART AND B.ANU <> 'A' AND B.TCO<>'NC' AND B.CYV='C') + (SELECT ISNULL(SUM(B.CAN),0) * -1 FROM AMOVSTOC B WHERE A.SEC = B.SEC AND A.ART = B.ART AND B.ANU <> 'A' AND B.TCO='NC' AND B.CYV='C')) - ((SELECT ISNULL(SUM(B.CAN),0) FROM AMOVSTOC B WHERE A.SEC = B.SEC AND A.ART = B.ART AND B.ANU <> 'A' AND B.TCO<>'NC' AND B.CYV='V' AND B.PLA=".$PLA.") + (SELECT ISNULL(SUM(B.CAN),0) * -1 FROM AMOVSTOC B WHERE A.SEC = B.SEC AND A.ART = B.ART  AND B.ANU <> 'A' AND B.TCO='NC' AND B.CYV='V' AND B.PLA=".$PLA.")) 'CANTIDAD_TOTAL_STOCK' FROM AMOVSTOC A  FULL OUTER JOIN ARTICULOS C ON A.SEC=C.CODSEC AND A.ART=C.CODART Where A.PLA=".$PLA." AND A.LUG=".$LUG." And C.CODSEC = ".$R1['SEC']." And C.CODRUB in (".$R1['RUB'].") AND ANU <> 'A' GROUP BY SEC,ART";
		$RS3TABLA = mssql_query($_SESSION['ParSQL']) or die("Error SQL");
		rollback($RS3TABLA);	
		while ($R3=mssql_fetch_array($RS3TABLA)){

            $_SESSION['ParSQL'] = "UPDATE CONTROL_STOCK SET ST_COM = ".str_replace(",",".",$R3['CANTIDAD_TOTAL_COMPRA']).", ST_VEN = ".str_replace(",",".",$R3['ANTIDAD_TOTAL_VENTA']).", ST_TUR = ".str_replace(",",".",$R3['CANTIDAD_TOTAL_STOCK'])." WHERE SEC=".$R3['SEC']." AND ART=".$R3['ART']." AND RUB=".$R3['RUBRO']."";
			$RS2TABLA = mssql_query($_SESSION['ParSQL']) or die("Error SQL");
			rollback($RS2TABLA);	
		}
	}
					
	$_SESSION['ParSQL'] = "UPDATE CONTROL_STOCK SET ST_ACT = ST_ANT + ST_COM - ST_VEN";
	$RS2TABLA = mssql_query($_SESSION['ParSQL']) or die("Error SQL");
	rollback($RS2TABLA);	

 	$El_Rubro =0;
  	$El_Sector =0;

	$datoe=str_repeat("_", 70);
	$orden=++$orden;
	$marca=0;			
	insertar($datoe,$marca,$orden);		
	
	$datoe=" CONTROL STOCK ";
	$orden=++$orden;
	$marca=1;			
	insertar($datoe,$marca,$orden);		

	$datoe="Producto".str_repeat(" ", 30)."S.Inicial".str_repeat(" ", 4)."Ingresos".str_repeat(" ", 4)."Egresos".str_repeat(" ", 6)."S. Final";
	$orden=++$orden;
	$marca=0;			
	insertar($datoe,$marca,$orden);		
	
//   ' ACA SE DIVIDE EN DOS: AGRUPADOS Y NO AGRUPADOS POR RUBRO
      $El_Rubro = 0;
      $El_Sector = 0;

	$_SESSION['ParSQL'] =  "SELECT A.* FROM CONTROL_STOCK A INNER JOIN ACONF_CONTROL_STOCK B ON A.SEC=B.SEC AND A.RUB=B.RUB WHERE B.GROUPED = 0 ORDER BY A.SEC,A.RUB,A.ART";
	$RS3TABLA = mssql_query($_SESSION['ParSQL']) or die("Error SQL");
	rollback($RS3TABLA);	
	$nr = mssql_num_rows($RS3TABLA); 
	if(!$nr == 0){
		while ($R3=mssql_fetch_array($RS3TABLA)){
         if (($El_Rubro <> $R3['Rub']) Or ($El_Sector <> $R3['Sec'])) {

			$datoe=str_repeat(" ", 1);
			$orden=++$orden;
			$marca=0;			
			insertar($datoe,$marca,$orden);		

			$datoe=str_repeat(" ", 1);
			$orden=++$orden;
			$marca=0;			
			insertar($datoe,$marca,$orden);		

			$datoe=Format($R3['Sec'],2,'0',STR_PAD_LEFT)." ".Format($R3['Rub'],3,'0',STR_PAD_LEFT)." ".buscar_nombre_rubro($R3['Sec'], $R3['Rub']);
			$orden=++$orden;
			$marca=1;			
			insertar($datoe,$marca,$orden);		
			
            $El_Rubro = $R3['Rub'];
            $El_Sector = $R3['Sec'];
		 }
		 
         	$datoe= Format($R3['Art'],5,'0',STR_PAD_LEFT).str_repeat(" ",3).substr(trim($R3['Det']), 28).str_repeat(" ",29 - strlen(substr(trim($R3['Det']),0,28))).str_repeat(" ",8 - strlen(dec($R3['ST_ANT'], 2))).dec($R3['ST_ANT'], 2)." ".str_repeat(" ",8 - strlen(dec($R3['ST_COM'], 2))).dec($R3['ST_COM'], 2)." ".str_repeat(" ",8 - strlen(dec($R3['ST_VEN'], 2))).dec($R3['ST_VEN'], 2)." "." "." ".str_repeat(" ",8 - strlen(dec($R3['ST_ACT'], 2))).dec($R3['ST_ACT'], 2);
			
			$orden=++$orden;
			$marca=0;			
			insertar($datoe,$marca,$orden);		
			
			
		}
	}else{

		$datoe="   Sin configurar el control de stock";
		$orden=++$orden;
		$marca=0;			
		insertar($datoe,$marca,$orden);				
	}

//   ' AGRUPADOS


	$_SESSION['ParSQL'] =  "SELECT A.SEC,A.RUB,MIN(C.NOMRUB),SUM(ST_ANT) ST_ANT ,SUM(ST_COM) ST_COM,SUM(ST_VEN) ST_VEN ,SUM(ST_TUR) ST_TUR ,SUM(ST_ACT) ST_ACT FROM CONTROL_STOCK A INNER JOIN ACONF_CONTROL_STOCK B ON A.SEC=B.SEC AND A.RUB=B.RUB INNER JOIN RUBROS C ON A.SEC=C.CODSEC AND A.RUB=C.CODRUB Where b.GROUPED = 1  GROUP BY A.SEC,A.RUB";

	
	$RS3TABLA = mssql_query($_SESSION['ParSQL']) or die("Error SQL");
	rollback($RS3TABLA);	
	$nr = mssql_num_rows($RS3TABLA); 
	if(!$nr == 0){

		$datoe=str_repeat("_", 95);
		$orden=++$orden;
		$marca=0;			
		insertar($datoe,$marca,$orden);				

		$datoe=" CONTROL STOCK ";
		$orden=++$orden;
		$marca=	1;			
		insertar($datoe,$marca,$orden);				

      
		$datoe="Rubros".str_repeat(" ", 33)."S.Inicial".str_repeat(" ", 4)."Ingresos".str_repeat(" ", 4)."Egresos".str_repeat(" ", 4)."S. Final";
		$orden=++$orden;
		$marca=0;			
		insertar($datoe,$marca,$orden);				

		$datoe=str_repeat("_", 95);
		$orden=++$orden;
		$marca=0;			
		insertar($datoe,$marca,$orden);				

      	$El_Rubro = 0;
      	$El_Sector = 0;
		

		$datoe=" ";
		$orden=++$orden;
		$marca=0;			
		insertar($datoe,$marca,$orden);				


		$datoe="Resumen por Rubros";
		$orden=++$orden;
		$marca=0;			
		insertar($datoe,$marca,$orden);				

		$datoe=str_repeat("_", 36);
		$orden=++$orden;
		$marca=0;			
		insertar($datoe,$marca,$orden);				


		while ($R3=mssql_fetch_array($RS3TABLA)){
			 
         	$El_Nrub = buscar_nombre_rubro($R3['Sec'], $R3['Rub']);
         	$datoe= Format($R3['Sec'],2,'0',STR_PAD_LEFT)." ".Format($R3['Rub'],2,'0',STR_PAD_LEFT).str_repeat(" ",1).substr(trim($El_Nrub), 28).str_repeat(" ",29 - strlen(substr(trim($El_Nrub),0,28))).str_repeat(" ",8 - strlen(dec($R3['ST_ANT'], 2))).dec($R3['ST_ANT'], 2)." ".str_repeat(" ",8 - strlen(dec($R3['ST_COM'], 2))).dec($R3['ST_COM'], 2)." ".str_repeat(" ",8 - strlen(dec($R3['ST_VEN'], 2))).dec($R3['ST_VEN'], 2)." "." "." ".str_repeat(" ",8 - strlen(dec($R3['ST_ACT'], 2))).dec($R3['ST_ACT'], 2);
		$orden=++$orden;
		$marca=0;			
		insertar($datoe,$marca,$orden);				
		 
		}
	
		$_SESSION['ParSQL'] =  "SELECT A.SEC,SUM(ST_ANT) ST_ANT ,SUM(ST_COM) ST_COM,SUM(ST_VEN) ST_VEN ,SUM(ST_TUR) ST_TUR ,SUM(ST_ACT) ST_ACT FROM CONTROL_STOCK A INNER JOIN ACONF_CONTROL_STOCK B ON A.SEC=B.SEC AND A.RUB=B.RUB INNER JOIN RUBROS C ON A.SEC=C.CODSEC AND A.RUB=C.CODRUB Where b.GROUPED = 1  GROUP BY A.SEC";
		$RS3TABLA = mssql_query($_SESSION['ParSQL']) or die("Error SQL");
		rollback($RS3TABLA);	
		$nr = mssql_num_rows($RS3TABLA); 
		if(!$nr == 0){
			while ($R3=mssql_fetch_array($RS3TABLA)){
				
				$datoe=str_repeat("_", 35);
				$orden=++$orden;
				$marca=0;			
				insertar($datoe,$marca,$orden);				

				$datoe= "Totales Resumen por Rubros".str_repeat(" ", 10).str_repeat(" ",8 - strlen(dec($R3['ST_ANT'], 2))).dec($R3['ST_ANT'], 2)." ".str_repeat(" ",8 - strlen(dec($R3['ST_COM'], 2))).dec($R3['ST_COM'], 2)." ".str_repeat(" ",8 - strlen(dec($R3['ST_VEN'], 2))).dec($R3['ST_VEN'], 2)." "." "." ".str_repeat(" ",8 - strlen(dec($R3['ST_ACT'], 2))).dec($R3['ST_ACT'], 2);
				$orden=++$orden;
				$marca=0;			
				insertar($datoe,$marca,$orden);				

				$datoe=str_repeat("_", 35);
				$orden=++$orden;
				$marca=0;			
				insertar($datoe,$marca,$orden);				
					
			}
		}

	
	
	}

////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
//   Call Novedades

		$datoe=str_repeat("_", 70);
		$orden=++$orden;
		$marca=0;			
		insertar($datoe,$marca,$orden);				

		$datoe="  DETALLE DE NOVEDADES";
		$orden=++$orden;
		$marca=1;			


		$datoe=str_repeat("_", 70);
		$orden=++$orden;
		$marca=0;			
		insertar($datoe,$marca,$orden);	
		
	   
		$datoe="ID".str_repeat(" ", 7)."Tipo".str_repeat(" ", 30)."Descripci&oacute;n";
		$orden=++$orden;
		$marca=0;			
		insertar($datoe,$marca,$orden);	

		$_SESSION['ParSQL'] =  "SELECT * FROM NOVEDADES WHERE PLA = ".$PLA."";
		$RS3TABLA = mssql_query($_SESSION['ParSQL']) or die("Error SQL");
		rollback($RS3TABLA);	
		$nr = mssql_num_rows($RS3TABLA); 
		if(!$nr == 0){
			$desc = 0;
			while ($R3=mssql_fetch_array($RS3TABLA)){
				
				if(isset($R3['DESC'])){
					$desc = 0;
				}else{
					$desc = (int)$R3['DESC'];
				}
				
				$DatoTipo=busca_tipo($R3['TIPO']);
				$DatoDesc=busca_desc($R3['TIPO'],$desc);

				$datoe=format($R3['ID'],4,'0',STR_PAD_LEFT).str_repeat(" ", 5).format($R3['TIPO'],4,'0',STR_PAD_LEFT)."-".$DatoTipo.str_repeat(" ", 22).format($R3['DESC'],4,'0',STR_PAD_LEFT)."-".$DatoDesc;
				$orden=++$orden;
				$marca=0;			
				insertar($datoe,$marca,$orden);	

				$datoe="Observaci&oacute;n: ".$R3['OBS'];
				$orden=++$orden;
				$marca=0;			
				insertar($datoe,$marca,$orden);	
				
			}
		}else{
			$datoe=str_repeat(" ", 4)."Sin Novedades";
			$orden=++$orden;
			$marca=0;			
			insertar($datoe,$marca,$orden);	

		}

////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
//   Call Arqueos
		
		//fabian vallejo
		$NumeroCaja = $PLA;
		
		$_SESSION['ParSQL'] =  "SELECT * FROM PLANILLA_ARQUEO WHERE PLA = ".$PLA."";
		$RS3TABLA = mssql_query($_SESSION['ParSQL']) or die("Error SQL");
		rollback($RS3TABLA);	
		$nr = mssql_num_rows($RS3TABLA); 
		if(!$nr == 0){
			while ($R3=mssql_fetch_array($RS3TABLA)){

		 		$datoe=str_repeat(" ", 130);
				$orden=++$orden;
				$marca=0;			
				insertar($datoe,$marca,$orden);

		 		$datoe="CAJA NÚMERO: ".$NumeroCaja;
				$orden=++$orden;
				$marca=0;			
				insertar($datoe,$marca,$orden);
				
		 		$datoe=str_repeat(" ", 65);
				$orden=++$orden;
				$marca=0;			
				insertar($datoe,$marca,$orden);

		        $datoe = "Operador".str_repeat(" ", 13)."----------------".str_repeat(" ", 10).format($R3['OPE_S'],4,'0',STR_PAD_LEFT);
				$orden=++$orden;
				$marca=0;			
				insertar($datoe,$marca,$orden);

		        $datoe = "Fecha".str_repeat(" ", 16)."----------------".str_repeat(" ", 10).$R3['FEC'];
				$orden=++$orden;
				$marca=0;			
				insertar($datoe,$marca,$orden);


		        $datoe = "Total a Rendir".str_repeat(" ", 7)."----------------".str_repeat(" ", 10).dec($R3['S_CA'],2);
				$orden=++$orden;
				$marca=0;			
				insertar($datoe,$marca,$orden);

		        $datoe = "Total Rendido".str_repeat(" ", 8)."----------------".str_repeat(" ", 10).dec($R3['S_RE'],2);
				$orden=++$orden;
				$marca=0;			
				insertar($datoe,$marca,$orden);
				
		        $datoe = "Diferencia".str_repeat(" ", 11)."----------------".str_repeat(" ", 10).dec($R3['DIF'],2);
				$orden=++$orden;
				$marca=0;			
				insertar($datoe,$marca,$orden);
		
		        $NumeroCaja = $NumeroCaja + 1;

			}
		}else{
		        $datoe = str_repeat(" ", 3)."Sin Arqueos";
				$orden=++$orden;
				$marca=0;			
				insertar($datoe,$marca,$orden);
					
		}

////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
//   Call NotasAltasBajasStock

	$NumeroCaja =0;
	$sTipo_Movimiento="";


	$datoe=str_repeat("_", 70);
	$orden=++$orden;
	$marca=0;			
	insertar($datoe,$marca,$orden);

	$datoe="  DETALLE DE NA Y NB REALIZADAS EN TURNO (SALIDAS Y ENTRADAS STOCK)";
	$orden=++$orden;
	$marca=1;			
	insertar($datoe,$marca,$orden);

	$_SESSION['ParSQL'] = "SELECT CYV,TIP,TCO,PVE,NCO,TIM,COD,ANU FROM AMOVSTOC WHERE PLA=".$PLA." AND TCO IN ('NA','NB') GROUP BY CYV,TIP,TCO,PVE,NCO,TIM,COD,ANU ORDER BY CYV,TIP,TCO,PVE,NCO";
	$RS3TABLA = mssql_query($_SESSION['ParSQL']) or die("Error SQL");
	rollback($RS3TABLA);	
	$nr = mssql_num_rows($RS3TABLA); 
	if(!$nr == 0){
		
		$datoe=str_repeat(" ", 130);
		$orden=++$orden;
		$marca=0;			
		insertar($datoe,$marca,$orden);
		
		$datoe=" NA/NB SUCURSAL".str_repeat(" ", 3)."NUMERO".str_repeat(" ", 9)."TIPO MOVIMIENTO".str_repeat(" ", 16)."LOCAL ORIGEN/DESTINO".str_repeat(" ", 11)."ANULADO";
		$orden=++$orden;
		$marca=0;			
		insertar($datoe,$marca,$orden);
		
		while ($R3=mssql_fetch_array($RS3TABLA)){
			switch ($R3['TIM']){
			 case "DV":
				$sTipo_Movimiento = "Dep&oacute;sito a Ventas             ";
				 break;
			 case "VV":
				$sTipo_Movimiento = "Ventas a Ventas               ";
				 break;
			 case "VD":
				$sTipo_Movimiento = "Ventas a Dep&oacute;sito             ";
				 break;
			 case "VX":
				$sTipo_Movimiento = "Retiro de Ventas              ";
				 break;
			 case "DX":
				$sTipo_Movimiento = "Retiro de Dep&oacute;sito            ";
				 break;
			 case "VR":
				$sTipo_Movimiento = "Retiro en Ventas              ";
				 break;
			 case "DR":
				$sTipo_Movimiento = "Retiro de Dep&oacute;sito            ";
				 break;
			 case "VQ":
				$sTipo_Movimiento = "Vencimiento de Ventas         ";
				 break;
			 case "DQ":
				$sTipo_Movimiento = "Vencimiento de Dep&oacute;sito       ";
				 break;
			 case "DO":
				$sTipo_Movimiento = "Deposito a Otros              ";
				 break;
			 case "VO":
				$sTipo_Movimiento = "Ventas a Otros                ";
				 break;
			 case "AC":
				$sTipo_Movimiento = "Antencion al Cliente          ";
				 break;
			 case "OV":
				$sTipo_Movimiento = "Ingreso de Otros a Ventas     ";
				 break;
			 case "OD":
				$sTipo_Movimiento = "Ingreso de Otros a Dep&oacute;sito   ";
				 break;
			 default:
				$sTipo_Movimiento = "No Codificado                 ";
				 break;
			}

		if($R3['ANU'] == "A") {
			$Anu="SI";
		}else{
			$Anu="NO";
		}

        $datoe = " ".$R3['TCO'].str_repeat(" ", 5).format($R3['PVE'],4,'0',STR_PAD_LEFT).str_repeat(" ", 4).format($R3['NCO'],8,'0',STR_PAD_LEFT).str_repeat(" ", 19).$sTipo_Movimiento.str_repeat(" ", 11).$R3['COD'].str_repeat(" ", 24).$Anu;
		$orden=++$orden;
		$marca=0;			
		insertar($datoe,$marca,$orden);
			
			
		}
	}else{

		$datoe = str_repeat(" ", 3)."Sin NA Y NB";
		$orden=++$orden;
		$marca=0;			
		insertar($datoe,$marca,$orden);
		
	}


////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
//   Call Guarda_en_Historico

   
	$_SESSION['ParSQL'] = "DELETE FROM CONTROL_STOCK_IMPRE_HISTORICO WHERE LUG = ".$LUG." AND PLA = ".$PLA." AND POS = ".$TER." AND INF = 1";
	$RS1TABLA = mssql_query($_SESSION['ParSQL']) or die("Error SQL");
	rollback($RS1TABLA);	

	$_SESSION['ParSQL'] = "SELECT * FROM CONTROL_STOCK_IMPRE WHERE POS = ".$TER." AND INF = 1 ORDER BY ORD";
	$RS1TABLA = mssql_query($_SESSION['ParSQL']) or die("Error SQL");
	rollback($RS1TABLA);
	while ($R1=mssql_fetch_array($RS1TABLA)){

		$rem_b1 = 0;
		$rem_b = $R1['REM'];
		if ($rem_b == true){
			$rem_b1 = 1;
		}
		
		$fechahistorico = $R1['FEC'];
		$date = new DateTime($fechahistorico);
		$fechahistorico = $date->format('d-m-Y');
		
      	$_SESSION['ParSQL'] = "INSERT INTO CONTROL_STOCK_IMPRE_HISTORICO ([LUG],[PLA],[POS],[INF],[FEC],[ORD],[DET],[REM],[E_HD],[C_HD]) 
		VALUES (".$LUG.", ".$PLA.", ".$R1['POS'].", ".$R1['INF'].", '".$fechahistorico."', ".$R1['ORD'].", '".$R1['DET']."', ".$rem_b1.", '', '')";
		$RS2TABLA = mssql_query($_SESSION['ParSQL']) or die("Error SQL");
		rollback($RS2TABLA);
		
	}


//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////


mssql_query("commit transaction") or die("Error SQL commit");
	
	?>
	<script>
	
		SoloNone("Bloquear");
		
		Mos_Ocu('fondotranspletras');
		Mos_Ocu('TecladoLet');
		Mos_Ocu('fondotranspnumeros');
		Mos_Ocu('TecladoNum');

		SoloNone("Confirmar");
		$("#archivos").load("CCajaImp.php");

	</script>
    </body>
	</html>
	<?

}catch(Exception $e){////////////////////////////////////////////////////////////////////////////////////////////////// FIN DE TRY //
	
	?>
	<script>
		jAlert('ERROR Reintente la operacion solicitada.', 'Debo Retail - Global Business Solution');
	</script>
	<?
exit;

}
?>