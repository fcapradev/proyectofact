<?
require("config/cnx.php");
try {////////////////////////////////////////////////////////////////////////////////////////////////// COMIENZO TRY //
mssql_query("begin transaction",$conexion) or die("Error SQL begin trans");

set_time_limit(1200);

//**	TRAE DATOS PARA INSERTAR CUANDO NO EXISTEN EN LA DB	
$b = $_POST['RealizadoPorPalm'];

//**	FUNCIONES DE ACTUALIZACION
function ActulizaExistenciasCDatosVen($CodSec ,$CodArt,$fecha){
	$ccod="";
	if ($CodArt > 0) {
	  $ccod = " AND CODART = ".$CodArt;
	}
	$nVta = 0;
	$nCom = 0;
	$nAju = 0;
 
   	$_SESSION['ParSQL'] = "SELECT DEPSN,CODSEC,CODART FROM ARTICULOS WHERE CODSEC = ".$CodSec.$ccod;
	$ARTICULOS = mssql_query($_SESSION['ParSQL']) or die("Error SQL");
	rollback($ARTICULOS);		
	while ($RART=mssql_fetch_array($ARTICULOS)){
		$nVta = 0;
      	$nCom = 0;
      	$nAju = 0;
		$_SESSION['ParSQL'] = "SELECT ISNULL(SUM(CAN),0) AS VTA 
					FROM AMOVSTOC WHERE CYV = 'V'  AND TCO NOT IN ('NC','NI') 
					AND TIM IN('Ve','VX','VV','VR','VQ','OV','VD','Aj','Ax','DV','VO','DO','AC')
					AND SEC = ".$RART['CODSEC']." AND ART = ".$RART['CODART']." AND DTO = 0 AND ANU <> 'A' AND FEC >= '".$fecha."'";
		$AMOVSTOC = mssql_query($_SESSION['ParSQL']) or die("Error SQL");
		rollback($AMOVSTOC);		
		while ($RAMOV=mssql_fetch_array($AMOVSTOC)){
			$nVta = $RAMOV['VTA'];
		}		
		$_SESSION['ParSQL'] = "SELECT ISNULL(SUM(CAN),0) AS COM 
					FROM AMOVSTOC WHERE CYV = 'V'  AND TCO IN ('NC','NI')
					AND TIM IN('Ve','VX','VV','VR','VQ','OV','VD')
					AND SEC = ".$RART['CODSEC']." AND ART = ".$RART['CODART']." AND DTO = 0 AND ANU <> 'A' AND FEC >= '".$fecha."'";
		$AMOVSTOC = mssql_query($_SESSION['ParSQL']) or die("Error SQL");
		rollback($AMOVSTOC);		
		while ($RAMOV=mssql_fetch_array($AMOVSTOC)){
			$nCom = $RAMOV['COM'];
		}		
		$_SESSION['ParSQL'] = "SELECT ISNULL(SUM(CAN),0) AS VTA 
					FROM AMOVSTOC WHERE CYV = 'C'  AND TCO IN ('NC','NI')
					AND TIM IN ('Co')
					AND SEC = ".$RART['CODSEC']." AND ART = ".$RART['CODART']." AND DTO = 0 AND ANU <> 'A' AND FEC >= '".$fecha."'";
		$AMOVSTOC = mssql_query($_SESSION['ParSQL']) or die("Error SQL");
		rollback($AMOVSTOC);		
		while ($RAMOV=mssql_fetch_array($AMOVSTOC)){
			$nVta = $nVta + $RAMOV['VTA'];
		}		
		$_SESSION['ParSQL'] = "SELECT ISNULL(SUM(CAN),0) AS COM 
					FROM AMOVSTOC WHERE CYV = 'C'  AND TCO IN ('NA')
					AND TIM IN ('VV')
					AND SEC = ".$RART['CODSEC']." AND ART = ".$RART['CODART']." AND DTO = 0 AND ANU <> 'A' AND FEC >= '".$fecha."'";
		$AMOVSTOC = mssql_query($_SESSION['ParSQL']) or die("Error SQL");
		rollback($AMOVSTOC);		
		while ($RAMOV=mssql_fetch_array($AMOVSTOC)){
			$nCom = $nCom + $RAMOV['COM'];
		}	
		$_SESSION['ParSQL'] = "SELECT ISNULL(SUM(CAN),0) AS COM 
					FROM AMOVSTOC WHERE CYV = 'C'  AND NOT TCO IN ( 'NC','NI')
					AND TIM IN ('Co','Aj','Ax','DV','VD','OD','DO','DX','DR')
					AND SEC = ".$RART['CODSEC']." AND ART = ".$RART['CODART']." AND DTO = 0 AND ANU <> 'A' AND FEC >= '".$fecha."'";
		$AMOVSTOC = mssql_query($_SESSION['ParSQL']) or die("Error SQL");
		rollback($AMOVSTOC);		
		while ($RAMOV=mssql_fetch_array($AMOVSTOC)){
			$nCom = $nCom + $RAMOV['COM'];
		}
		$nAju = $nCom - $nVta;
	}	
	return $nAju;
}

function ActulizaExistenciasCDatosDep($CodSec ,$CodArt,$fecha){
	$ccod="";
	if ($CodArt > 0) {
	  $ccod = " AND CODART = ".$CodArt;
	}
 	$nVta = 0;
	$nCom = 0;
	$nAju = 0;  
    $Sec = $CodSec;
   	$_SESSION['ParSQL'] = "SELECT DEPSN,CODSEC,CODART FROM ARTICULOS WHERE CODSEC = ".$CodSec.$ccod;
	$ARTICULOS = mssql_query($_SESSION['ParSQL']) or die("Error SQL");
	rollback($ARTICULOS);		
	while ($RART=mssql_fetch_array($ARTICULOS)){
		$nVta = 0;
      	$nCom = 0;
      	$nAju = 0;
		if ($RART['DEPSN']==true){
			$_SESSION['ParSQL'] = "SELECT ISNULL(SUM(CAN),0) AS VTA 
						FROM AMOVSTOC WHERE CYV = 'V' AND NOT TCO IN ('NC','NI')  
						AND TIM IN ('Ve','DV','OD','DX','DR','DQ','Aj','Ax','DV','DO') 
						AND SEC = ".$RART['CODSEC']." AND ART = ".$RART['CODART']." AND DTO = 1 AND ANU <> 'A' AND FEC >= '".$fecha."'";
			$AMOVSTOC = mssql_query($_SESSION['ParSQL']) or die("Error SQL");
			rollback($AMOVSTOC);		
			while ($RAMOV=mssql_fetch_array($AMOVSTOC)){
				$nVta=$RAMOV['VTA'];
			}
			$_SESSION['ParSQL'] = "SELECT ISNULL(SUM(CAN),0) AS COM 
						FROM AMOVSTOC WHERE CYV = 'C'  AND TCO IN ('NC','NI')  
						AND TIM IN ('Co') 
						AND SEC = ".$RART['CODSEC']." AND ART = ".$RART['CODART']." AND DTO = 1 AND ANU <> 'A' AND FEC >= '".$fecha."'";
			$AMOVSTOC = mssql_query($_SESSION['ParSQL']) or die("Error SQL");
			rollback($AMOVSTOC);		
			while ($RAMOV=mssql_fetch_array($AMOVSTOC)){
				$nVta = $nVta + $RAMOV['COM'];
			}
			$_SESSION['ParSQL'] = "SELECT ISNULL(SUM(CAN),0) AS COM 
						FROM AMOVSTOC WHERE CYV = 'C'  AND NOT TCO IN ('NC','NI') 
						AND TIM IN  ('Co','Aj','Ax','DV','VD','OD','DO','DX','DR')
						AND SEC = ".$RART['CODSEC']." AND ART = ".$RART['CODART']." AND DTO = 1 AND ANU <> 'A' AND FEC >= '".$fecha."'";
			$AMOVSTOC = mssql_query($_SESSION['ParSQL']) or die("Error SQL");
			rollback($AMOVSTOC);		
			while ($RAMOV=mssql_fetch_array($AMOVSTOC)){
				$nCom = $RAMOV['COM'];
			}
			$nAju = $nCom - $nVta;
		}
	}
	return $nAju;
}

function ActulizaExistencias($Sec,$Art){
	$ccod="";
	if ($Art > 0) {
	  $ccod = " AND CODART = ".$Art;
	}
   	$_SESSION['ParSQL'] = "SELECT DEPSN,CODSEC,CODART FROM ARTICULOS WHERE CODSEC = ".$Sec.$ccod;
	$ARTICULOS = mssql_query($_SESSION['ParSQL']) or die("Error SQL");
	rollback($ARTICULOS);		
	while ($RART=mssql_fetch_array($ARTICULOS)){
		$nVta = 0;
      	$nCom = 0;
      	$nAju = 0;
		if ($RART['DEPSN']==true){
			$_SESSION['ParSQL'] = "SELECT ISNULL(SUM(CAN),0) AS VTA 
						FROM AMOVSTOC WHERE CYV = 'V' AND NOT TCO IN ('NC','NI')  
						AND TIM IN ('Ve','DV','OD','DX','DR','DQ','Aj','Ax','DV','DO') 
						AND SEC = ".$RART['CODSEC']." AND ART = ".$RART['CODART']." AND DTO = 1 AND ANU <> 'A'";
			$AMOVSTOC = mssql_query($_SESSION['ParSQL']) or die("Error SQL");
			rollback($AMOVSTOC);		
			while ($RAMOV=mssql_fetch_array($AMOVSTOC)){
				$nVta=$RAMOV['VTA'];
			}
			$_SESSION['ParSQL'] = "SELECT ISNULL(SUM(CAN),0) AS COM 
						FROM AMOVSTOC WHERE CYV = 'C'  AND TCO IN ('NC','NI')  
						AND TIM IN ('Co') 
						AND SEC = ".$RART['CODSEC']." AND ART = ".$RART['CODART']." AND DTO = 1 AND ANU <> 'A'";
			$AMOVSTOC = mssql_query($_SESSION['ParSQL']) or die("Error SQL");
			rollback($AMOVSTOC);		
			while ($RAMOV=mssql_fetch_array($AMOVSTOC)){
				$nVta = $nVta + $RAMOV['COM'];
			}
			$_SESSION['ParSQL'] = "SELECT ISNULL(SUM(CAN),0) AS COM 
						FROM AMOVSTOC WHERE CYV = 'C'  AND NOT TCO IN ('NC','NI') 
						AND TIM IN ('Co','Aj','Ax','DV','VD','OD','DO','DX','DR')
						AND SEC = ".$RART['CODSEC']." AND ART = ".$RART['CODART']." AND DTO = 1 AND ANU <> 'A'";
			$AMOVSTOC = mssql_query($_SESSION['ParSQL']) or die("Error SQL");
			rollback($AMOVSTOC);		
			while ($RAMOV=mssql_fetch_array($AMOVSTOC)){
				$nCom = $RAMOV['COM'];
			}
			$nAju = $nCom - $nVta;
			$_SESSION['ParSQL'] = "UPDATE ARTICULOS 
				SET EXIDEP = ".str_replace(",",".",$nAju)." WHERE CodSec = ".$RART['CODSEC']." AND CodArt = ".$RART['CODART']."";
			$UARTICULOS = mssql_query($_SESSION['ParSQL']) or die("Error SQL");
			rollback($UARTICULOS);		
		}
		// ventas si o si
		$nVta = 0;
      	$nCom = 0;
      	$nAju = 0;
		$_SESSION['ParSQL'] = "SELECT ISNULL(SUM(CAN),0) AS VTA 
					FROM AMOVSTOC WHERE CYV = 'V'  AND TCO NOT IN ('NC','NI') 
					AND TIM IN('Ve','VX','VV','VR','VQ','OV','VD','Aj','Ax','DV','VO','DO','AC')
					AND SEC = ".$RART['CODSEC']." AND ART = ".$RART['CODART']." AND DTO = 0 AND ANU <> 'A'";
		$AMOVSTOC = mssql_query($_SESSION['ParSQL']) or die("Error SQL");
		rollback($AMOVSTOC);		
		while ($RAMOV=mssql_fetch_array($AMOVSTOC)){
			$nVta = $RAMOV['VTA'];
		}		
		$_SESSION['ParSQL'] = "SELECT ISNULL(SUM(CAN),0) AS COM 
					FROM AMOVSTOC WHERE CYV = 'V'  AND TCO IN ('NC','NI')
					AND TIM IN('Ve','VX','VV','VR','VQ','OV','VD')
					AND SEC = ".$RART['CODSEC']." AND ART = ".$RART['CODART']." AND DTO = 0 AND ANU <> 'A'";
		$AMOVSTOC = mssql_query($_SESSION['ParSQL']) or die("Error SQL");
		rollback($AMOVSTOC);		
		while ($RAMOV=mssql_fetch_array($AMOVSTOC)){
			$nCom = $RAMOV['COM'];
		}		
		$_SESSION['ParSQL'] = "SELECT ISNULL(SUM(CAN),0) AS VTA 
					FROM AMOVSTOC WHERE CYV = 'C'  AND TCO IN ('NC','NI')
					AND TIM IN ('Co')
					AND SEC = ".$RART['CODSEC']." AND ART = ".$RART['CODART']." AND DTO = 0 AND ANU <> 'A'";
		$AMOVSTOC = mssql_query($_SESSION['ParSQL']) or die("Error SQL");
		rollback($AMOVSTOC);		
		while ($RAMOV=mssql_fetch_array($AMOVSTOC)){
			$nVta = $nVta + $RAMOV['VTA'];
		}		
		$_SESSION['ParSQL'] = "SELECT ISNULL(SUM(CAN),0) AS COM 
					FROM AMOVSTOC WHERE CYV = 'C'  AND TCO IN ('NA')
					AND TIM IN ('VV')
					AND SEC = ".$RART['CODSEC']." AND ART = ".$RART['CODART']." AND DTO = 0 AND ANU <> 'A'";
		$AMOVSTOC = mssql_query($_SESSION['ParSQL']) or die("Error SQL");
		rollback($AMOVSTOC);		
		while ($RAMOV=mssql_fetch_array($AMOVSTOC)){
			$nCom = $nCom + $RAMOV['COM'];
		}	
		$_SESSION['ParSQL'] = "SELECT ISNULL(SUM(CAN),0) AS COM 
					FROM AMOVSTOC WHERE CYV = 'C'  AND NOT TCO IN ( 'NC','NI')
					AND TIM IN ('Co','Aj','Ax','DV','VD','OV')
					AND SEC = ".$RART['CODSEC']." AND ART = ".$RART['CODART']." AND DTO = 0 AND ANU <> 'A'";
		$AMOVSTOC = mssql_query($_SESSION['ParSQL']) or die("Error SQL");
		rollback($AMOVSTOC);		
		while ($RAMOV=mssql_fetch_array($AMOVSTOC)){
			$nCom = $nCom + $RAMOV['COM'];
		}
		$nAju = $nCom - $nVta;
		$_SESSION['ParSQL'] = "UPDATE ARTICULOS 
			SET EXIVTA = ".str_replace(",",".",$nAju)." WHERE CodSec = ".$RART['CODSEC']." AND CodArt = ".$RART['CODART']."";
		$UARTICULOS = mssql_query($_SESSION['ParSQL']) or die("Error SQL");
		rollback($UARTICULOS);			
	}
}

								//******************************************************//
								//**	VERIFICA SI LA CARGA SE HACE POR TXT O POR DB **//
								//******************************************************//

if(isset($_POST['RealizadoPorPalm'])){
	$RealizadoPorPalm = $_POST['RealizadoPorPalm'];
	$num_inv_db = $_POST['num_inv_db'];
	$teDET = $_POST['teDET'];
	$Fecha_Inv = $_POST['Fecha_Inv'];
	$Fecha_Inv2 = $_POST['Fecha_Inv2'];
	$teOPEt = $_POST['teOPEt'];
	$teTIP = $_POST['teTIP'];
	$sec = $_POST['sec'];
	$rub = $_POST['rub'];

	if($RealizadoPorPalm == 0){
		//**	INSERTO EN INV_PALM_REA
		$_SESSION['ParSQL'] = "SELECT * FROM INV_PALM_REA WHERE NUM_INV = ".$num_inv_db."";
		$inv_palm_rea = mssql_query($_SESSION['ParSQL']) or die("Error SQL");
		rollback($inv_palm_rea);
		if(mssql_num_rows($inv_palm_rea)==0){
			$_SESSION['ParSQL'] = "INSERT INV_PALM_REA (NUM_INV,FEC_INV,INV_REA) VALUES (".$num_inv_db.",'".$Fecha_Inv."',1)";
			$IINV_PALM_REA = mssql_query($_SESSION['ParSQL']) or die("Error SQL");
			rollback($IINV_PALM_REA);
		}
		//**	Traigo Sector
		$_SESSION['ParSQL'] = "SELECT NOMBRE FROM SECTORES WHERE ID = ".$sec."";
		$SECTOR = mssql_query($_SESSION['ParSQL']) or die("Error SQL");
		rollback($SECTOR);
		while ($RITO=mssql_fetch_array($SECTOR)){
			$sector = $RITO['NOMBRE'];
		}
		//**	Traigo Rubros
		$_SESSION['ParSQL'] = "SELECT NomRub FROM RUBROS WHERE CodSec = ".$sec." AND CodRub = ".$rub."";
		$RUBRO = mssql_query($_SESSION['ParSQL']) or die("Error SQL");
		rollback($RUBRO);
		while ($RITO=mssql_fetch_array($RUBRO)){
			$rubro = $RITO['NomRub'];
		}
		//**	Traigo Rubros Mayores
		$_SESSION['ParSQL'] = "SELECT RUBMAY FROM ARTICULOS WHERE CodRub = ".$rub." AND CodSec = ".$sec."";
		$RUMROM = mssql_query($_SESSION['ParSQL']) or die("Error SQL");
		rollback($RUMROM);
		while ($RRUM=mssql_fetch_array($RUMROM)){
			$NRUM=$RRUM['RUBMAY'];
		}
		$_SESSION['ParSQL'] = "select NomRub from RUBMAY WHERE CodRub = ".$NRUM."";
		$RUMROM = mssql_query($_SESSION['ParSQL']) or die("Error SQL");
		rollback($RUMROM);
		while ($RRUM=mssql_fetch_array($RUMROM)){
			$NOMRUM=$RRUM['NomRub'];
		}
		//**	INSERTO EN ITOMINVC
		$_SESSION['ParSQL'] = "SELECT * FROM ITOMINVC WHERE ID = ".$num_inv_db."";
		$itominvc = mssql_query($_SESSION['ParSQL']) or die("Error SQL");
		rollback($itominvc);
		
		//** SI DepSN (ARTICULOS) ES uno => ES DEPOSITO, SINO ES VENTAS
		if(mssql_num_rows($itominvc)==0){
			$_SESSION['ParSQL'] = "INSERT ITOMINVC (ID,DET,FET,EST,FEC,OPE,POS,DEP,DSE,DRM,DRU,RUB) VALUES (".$num_inv_db.",'".$teDET."','".$Fecha_Inv2."','C',getdate(),0,1,0,'".$sector."','".$NOMRUM."','".$rubro."',".$rub.")";
			$ITOMINVC = mssql_query($_SESSION['ParSQL']) or die("Error SQL");
			rollback($ITOMINVC);
		}
//**	INSERTA EN LA ITOMINVD LOS ITEMS
		$numinv = $_POST['nume'];
		$teTIP = $_POST['tipo'];

	////ACTUALIZO ITOMINVC CON FECHA DE CARGA	
		$OPE = $_SESSION['idsusua'];
		$parPV = $_SESSION['ParPV'];
		$LUG = $_SESSION['ParLUG'];
		$fec=date("Y-m-d H:i:s"); // ver el formato

	foreach($_POST['valores'] as $id => $value){
		$marca1 = 0;
		//	INSERTAR EN LA BASE DE DATOS LOS ITEMS!!! 
			$_SESSION['ParSQL'] = "SELECT * FROM ARTICULOS WHERE CodSec =".$sec." AND CodArt =".$id."";
			echo "<br>Articulo: ".$_SESSION['ParSQL'];
			$ARTICULOS = mssql_query($_SESSION['ParSQL']) or die("Error SQL");
			rollback($ARTICULOS);
			while ($RART=mssql_fetch_array($ARTICULOS)){
				$RUB=$RART['CodRub'];;
				$RUM=$RART['RubMay'];
				$COS=$RART['Costo'];
				$PRE=$RART['PreVen'];
				$DET=$RART['DetArt'];
				$DepSN=$RART['DepSN'];
			}
			if($value == "NO TOMADO"){
				$marca1 = -1;
				$value = 0;	
			}
			$_SESSION['ParSQL'] = "	INSERT ITOMINVD (INV,SEC,ART,RUM,RUB,DET,PRE,COS,TOM,CON,CAR,AJU,REA,DIF) 
									VALUES (".$numinv.",".$sec.",".$id.",".$RUM.",".$RUB.",'".$DET."',".$PRE.",".$COS.",".$marca1.",".$value.",0,0,0,0)";
			echo "<br>".$_SESSION['ParSQL'];
			$ARTICULOS = mssql_query($_SESSION['ParSQL']) or die("Error SQL");
			rollback($ARTICULOS);

		//** REALIZA EL PROCESO DE ACTUALIZACION (ANTERIORMENTE DEBE HABER INSERTADO LOS ITEMS)
			$nSec = $sec;
			$nArt = $id;
			$nRub = $RUB;
			if($value != "NO TOMADO"){
				ActulizaExistencias($nSec,$id);
				$_SESSION['ParSQL'] = "SELECT EXIVTA, EXIDEP, PREVEN, IMPINT, IMPINT2 FROM ARTICULOS WHERE CODSEC = ".$nSec." AND CODART = ".$nArt."";
				$ARTICULOS = mssql_query($_SESSION['ParSQL']) or die("Error SQL");
				rollback($ARTICULOS);		
				while ($RART=mssql_fetch_array($ARTICULOS)){
					$PREVEN = $RART['PREVEN'];
					$IMPINT = $RART['IMPINT'];
					$IMPINT2 = $RART['IMPINT2'];
					$sFecToma = $Fecha_Inv;
					$timestamp= strtotime($sFecToma) ;
					$sFecToma = date('Y-m-d H:i:s',$timestamp );		
					if($teTIP == "DEPOSITO"){
						$cExiAct = ActulizaExistenciasCDatosDep($nSec, $nArt, $sFecToma);
						$cCAR = $RART['EXIDEP'];
					}else{
						$cExiAct = ActulizaExistenciasCDatosVen($nSec, $nArt, $sFecToma);
						$cCAR =  $RART['EXIVTA'];
					}
					$cREA = $value + $cExiAct;
					$cDIF = $cREA - $cCAR;
					$_SESSION['ParSQL'] ="UPDATE ITOMINVD SET CON = ".str_replace(".",",",$value).", CAR = ".str_replace(".",",",$cCAR).", 
						AJU = ".str_replace(".",",",$cExiAct).", REA = ".str_replace(".",",",$cREA).", 
						DIF = ".str_replace(".",",",($value + $cExiAct) - $cCAR)." WHERE INV = ".$numinv." AND SEC = ".$nSec." AND ART = ".$nArt."";
					$IITOMINVD = mssql_query($_SESSION['ParSQL']) or die("Error SQL");
					rollback($IITOMINVD);
					if ($teTIP == "DEPOSITO"){
						$_SESSION['ParSQL'] =  " UPDATE ARTICULOS SET EXIDEP = ".str_replace(".",",",$cREA).", FID = getdate(), NID = ".$numinv." WHERE CODSEC = ".$nSec." AND CODART = ".$nArt."";
						$iDTO = 1;
					}else{
						$_SESSION['ParSQL'] =  " UPDATE ARTICULOS SET EXIVTA = ".str_replace(".",",",$cREA).", FIV = getdate(), NIV = ".$numinv." WHERE CODSEC = ".$nSec." AND CODART = ".$nArt."";
						$iDTO = 0;
					}
					if ($cDIF < 0) {
						$_SESSION['ParSQL'] =  "INSERT AMOVSTOC (SEC, ART, FEC, CYV, TIP, TCO, PVE, NCO, ORD, CAN, PUN, IMI, IMI2, LUG, TIM, E_HD, C_HD, DTO, OPE, JJN, JDJ) VALUES( ".$nSec.", ".$nArt.", getdate(), 'V', 'B', 'AJ', ".$parPV.", ".$numinv.", 1, ".str_replace(".",",",abs($cDIF)).", ".str_replace(".",",",$PREVEN).", ".str_replace(".",",",$IMPINT).", ".str_replace(".",",",$IMPINT2).", ".$LUG.", 'Aj', '', '', ".$iDTO.", 0,'CD','Toma colector local')";
					}elseif ($cDIF > 0) {
						$_SESSION['ParSQL'] =  "INSERT AMOVSTOC (SEC, ART, FEC, CYV, TIP, TCO, PVE, NCO, ORD, CAN, PUN, IMI, IMI2, LUG, TIM, E_HD, C_HD, DTO, OPE, JJN, JDJ) VALUES( ".$nSec.", ".$nArt.", getdate(), 'C', 'B', 'AJ', ".$parPV.", ".$numinv.", 1, ".str_replace(".",",",abs($cDIF)).", ".str_replace(".",",",$PREVEN).", ".str_replace(".",",",$IMPINT).", ".str_replace(".",",",$IMPINT2).", ".$LUG.", 'Aj', '', '', ".$iDTO.", 0,'CD','Toma colector local')";						
					}
				}	//FIN WHILE
			}
		}
	}else{
	$numinv = $_POST['nume'];
	$teTIP = $_POST['tipo'];
////ACTUALIZO ITOMINVC CON FECHA DE CARGA	
	$OPE = $_SESSION['idsusua'];
	$parPV = $_SESSION['ParPV'];
	$LUG = $_SESSION['ParLUG'];
	$_SESSION['ParSQL'] = "UPDATE INV_PALM_REA SET INV_REA = 1 WHERE NUM_INV = ".$numinv."";
	$Uinv_palm_rea = mssql_query($_SESSION['ParSQL']) or die("Error SQL");
	rollback($Uinv_palm_rea);

//	ACTUALIZAR SI EL INV VIENE DE UN COLECTOR DE DATOS
	$_SESSION['ParSQL'] = "UPDATE ITOMINVC SET EST='C', FEC = getdate(), OPE=".$OPE." WHERE ID = ".$numinv."";
	$UTOMINVC = mssql_query($_SESSION['ParSQL']) or die("Error SQL");
	rollback($UTOMINVC);
	foreach($_POST['valores'] as $id => $value){
		if($value != "NO TOMADO"){
			$_SESSION['ParSQL'] = "SELECT INV,SEC,ART,RUM,RUB FROM ITOMINVD WHERE INV = ".$numinv." and ART = ".$id."";
			$ARTICULOS = mssql_query($_SESSION['ParSQL']) or die("Error SQL");
			rollback($ARTICULOS);
			while ($RART=mssql_fetch_array($ARTICULOS)){
				$SEC=format($RART['SEC'],2,'0',STR_PAD_LEFT);
				$RUB=format($RART['RUB'],2,'0',STR_PAD_LEFT);
				$RUM=$RART['RUM'];
			}
			$nSec = $SEC;
			$nArt = $id;
			$nRub = $RUB;
			ActulizaExistencias($SEC,$id);
			$_SESSION['ParSQL'] = "SELECT EXIVTA, EXIDEP, PREVEN, IMPINT, IMPINT2 FROM ARTICULOS WHERE CODSEC = ".$nSec." AND CODART = ".$nArt."";
			$ARTICULOS = mssql_query($_SESSION['ParSQL']) or die("Error SQL");
			rollback($ARTICULOS);		
			while ($RART=mssql_fetch_array($ARTICULOS)){
				$PREVEN = $RART['PREVEN'];
				$IMPINT = $RART['IMPINT'];
				$IMPINT2 = $RART['IMPINT2'];
				$sFecToma = $Fecha_Inv;
				$timestamp= strtotime($sFecToma) ;
				$sFecToma = date('Y-m-d H:i:s',$timestamp );		
				if($teTIP == "DEPOSITO"){
					$cExiAct = ActulizaExistenciasCDatosDep($nSec, $nArt, $sFecToma);
					$cCAR = $RART['EXIDEP'];
				}else{
					$cExiAct = ActulizaExistenciasCDatosVen($nSec, $nArt, $sFecToma);
					$cCAR =  $RART['EXIVTA'];
				}
				$cREA = $value + $cExiAct;
				$cDIF = $cREA - $cCAR;

				$_SESSION['ParSQL'] ="UPDATE ITOMINVD SET CON = ".str_replace(".",",",$value).", CAR = ".str_replace(".",",",$cCAR).", 
					AJU = ".str_replace(".",",",$cExiAct).", REA = ".str_replace(".",",",$cREA).", 
					DIF = ".str_replace(".",",",($value + $cExiAct) - $cCAR)." WHERE INV = ".$numinv." AND SEC = ".$nSec." AND ART = ".$nArt."";
				$IITOMINVD = mssql_query($_SESSION['ParSQL']) or die("Error SQL");
				rollback($IITOMINVD);
				
				if ($teTIP == "DEPOSITO"){
					$_SESSION['ParSQL'] =  " UPDATE ARTICULOS SET EXIDEP = ".str_replace(".",",",$cREA).", FID = getdate(), NID = ".$numinv." WHERE CODSEC = ".$nSec." AND CODART = ".$nArt."";
					$iDTO = 1;
				}else{
					$_SESSION['ParSQL'] =  " UPDATE ARTICULOS SET EXIVTA = ".str_replace(".",",",$cREA).", FIV = getdate(), NIV = ".$numinv." WHERE CODSEC = ".$nSec." AND CODART = ".$nArt."";
					$iDTO = 0;
				}
				if ($cDIF < 0) {
					$_SESSION['ParSQL'] =  "INSERT AMOVSTOC (SEC, ART, FEC, CYV, TIP, TCO, PVE, NCO, ORD, CAN, PUN, IMI, IMI2, LUG, TIM, E_HD, C_HD, DTO, OPE, JJN, JDJ) VALUES( ".$nSec.", ".$nArt.", getdate(), 'V', 'B', 'AJ', ".$parPV.", ".$numinv.", 1, ".str_replace(".",",",abs($cDIF)).", ".str_replace(".",",",$PREVEN).", ".str_replace(".",",",$IMPINT).", ".str_replace(".",",",$IMPINT2).", ".$LUG.", 'Aj', '', '', ".$iDTO.", 0,'CD','Toma colector local')";
				}elseif ($cDIF > 0) {
					$_SESSION['ParSQL'] =  "INSERT AMOVSTOC (SEC, ART, FEC, CYV, TIP, TCO, PVE, NCO, ORD, CAN, PUN, IMI, IMI2, LUG, TIM, E_HD, C_HD, DTO, OPE, JJN, JDJ) VALUES( ".$nSec.", ".$nArt.", getdate(), 'C', 'B', 'AJ', ".$parPV.", ".$numinv.", 1, ".str_replace(".",",",abs($cDIF)).", ".str_replace(".",",",$PREVEN).", ".str_replace(".",",",$IMPINT).", ".str_replace(".",",",$IMPINT2).", ".$LUG.", 'Aj', '', '', ".$iDTO.", 0,'CD','Toma colector local')";						
				}
			}	//FIN WHILE
		}
	} 	//fin foreach 
}
?>
<script>
	$('#Bloquear').fadeOut(500);

	jAlert("El Inventario ya ha sido cargado y est&aacute; listo para ser impreso.", "Debo Retail - Global Business Solution");

	EnvAyuda("Seleccione el tipo de Impresi&oacute;n y presione Imprimir");
	
	SoloNone("LetEnt, cancelar, notomado_car, grabar_car, orden");
	SoloBlock("LetTer, impresion");

	document.getElementById("DondeE").value = "";
	document.getElementById("CantiE").value = "";
	document.getElementById("QuePoE").value = "";
</script>
<?
}	//fin if (principal)

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