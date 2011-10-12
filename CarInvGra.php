<?
require("config/cnx.php");
try {////////////////////////////////////////////////////////////////////////////////////////////////// COMIENZO TRY //
mssql_query("begin transaction",$conexion) or die("Error SQL begin trans");

set_time_limit(1200);

if(isset($_POST['valores'])){
	$numinv = $_POST['nume'];
	$teTIP = $_POST['tipo'];

////ACTUALIZO ITOMINVC CON FECHA DE CARGA	
	$OPE = $_SESSION['idsusua'];
	$parPV = $_SESSION['ParPV'];
	$LUG = $_SESSION['ParLUG'];
	
	$fec=date("Y-m-d H:i:s"); // ver el formato

//	ACTUALIZAR SI EL INV VIENE DE UN COLECTOR DE DATOS
	$_SESSION['ParSQL'] = "UPDATE ITOMINVC SET EST='C', FEC= getdate(), OPE=".$OPE." WHERE ID = ".$numinv."";
	$UTOMINVC = mssql_query($_SESSION['ParSQL']) or die("Error SQL");
	rollback($UTOMINVC);

	foreach($_POST['valores'] as $id => $value){
		$_SESSION['ParSQL'] = "SELECT INV,SEC,ART,RUM,RUB FROM ITOMINVD WHERE INV = ".$numinv." and ART = ".$id."";
		$ARTICULOS = mssql_query($_SESSION['ParSQL']) or die("Error SQL");
		rollback($ARTICULOS);
		while ($RART=mssql_fetch_array($ARTICULOS)){
			$SEC=format($RART['SEC'],2,'0',STR_PAD_LEFT);
			$RUB=format($RART['RUB'],2,'0',STR_PAD_LEFT);
			$RUM=$RART['RUM'];
		}

		///ACTUALIZA EXISTENCIAS		
	$ccod="";
	$Art = $id;
	if ($Art > 0) {
	  $ccod = " AND CODART = ".$Art;
	}
   	$_SESSION['ParSQL'] = "SELECT DEPSN,CODSEC,CODART FROM ARTICULOS WHERE CODSEC = ".$SEC.$ccod;
	$ARTICULOS = mssql_query($_SESSION['ParSQL']) or die("Error SQL");
	rollback($ARTICULOS);		
	while ($RART=mssql_fetch_array($ARTICULOS)){
		$nVta = 0;
      	$nCom = 0;
      	$nAju = 0;
		if ($RART['DEPSN']== true){

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
					AND TIM IN ('Co','Aj','Ax','DV','VD','OD','DO','DX','DR')
					AND SEC = ".$RART['CODSEC']." AND ART = ".$RART['CODART']." AND DTO = 0 AND ANU <> 'A'";
		$AMOVSTOC = mssql_query($_SESSION['ParSQL']) or die("Error SQL");
		rollback($AMOVSTOC);		
		while ($RAMOV=mssql_fetch_array($AMOVSTOC)){
			$nCom = $nCom + $RAMOV['COM'];
		}
		$nAju = $nCom - $nVta;
		$_SESSION['ParSQL'] = "UPDATE ARTICULOS 
			SET EXIVTA = ".str_replace(",",".",$nAju)." WHERE CODSEC = ".$RART['CODSEC']." AND CODART = ".$RART['CODART']."";
		$UARTICULOS = mssql_query($_SESSION['ParSQL']) or die("Error SQL");
		rollback($UARTICULOS);			
	}
		$nSec = $SEC;
		$nArt = $id;
		$nRub = $RUB;

////	CARGO LOS DATOS EXTRAIDOS
		if ($value != "NO TOMADO"){
			
			$nExi = $value;

			$_SESSION['ParSQL'] = "SELECT EXIVTA, EXIDEP, PREVEN, IMPINT, IMPINT2 FROM ARTICULOS WHERE CODSEC = ".$nSec." AND CODART = ".$nArt."";
			$ARTICULOS = mssql_query($_SESSION['ParSQL']) or die("Error SQL");
			rollback($ARTICULOS);		
			
			while ($RART=mssql_fetch_array($ARTICULOS)){
				$PREVEN = $RART['PREVEN'];
				$IMPINT = $RART['IMPINT'];
				$IMPINT2 = $RART['IMPINT2'];
				if($teTIP == "DEPOSITO"){
					$CAR = $RART['EXIDEP'];
				}else{
					$CAR = $RART['EXIVTA'];
				}
			}
			
			$_SESSION['ParSQL'] = "UPDATE ITOMINVD SET CON = ".$nExi.", CAR = ".$CAR."  WHERE INV = ".$numinv." AND SEC = ".$nSec." AND ART = ".$nArt."";

			$UTOMINVD = mssql_query($_SESSION['ParSQL']) or die("Error SQL");
			rollback($UTOMINVD);	

			$_SESSION['ParSQL'] = "UPDATE ITOMINVD SET AJU = TOM-CAR, REA = CON-TOM-CAR,DIF = CON-TOM 
								WHERE INV = ".$numinv." AND SEC = ".$nSec." AND ART = ".$nArt."";
			$UTOMINVD = mssql_query($_SESSION['ParSQL']) or die("Error SQL");
			rollback($UTOMINVD);	

			$_SESSION['ParSQL'] = "SELECT REA, DIF FROM ITOMINVD WHERE INV = ".$numinv." AND SEC = ".$nSec." AND ART = ".$nArt."";
			$ITOMINVD = mssql_query($_SESSION['ParSQL']) or die("Error SQL");
			rollback($ITOMINVD);
			
			while ($RITOD=mssql_fetch_array($ITOMINVD)){
				$REA = $RITOD['REA'];
				$DIF = $RITOD['DIF'];
			}
			
			if ($teTIP == "DEPOSITO"){
			
				$_SESSION['ParSQL'] = "UPDATE ARTICULOS SET EXIDEP=".$REA.", FID= getdate(),NID=".$numinv." WHERE CODSEC = ".$nSec." AND CODART = ".$nArt."";
				$uARTICULOS = mssql_query($_SESSION['ParSQL']) or die("Error SQL");
				rollback($uARTICULOS);				
			
			}else{
			
				$_SESSION['ParSQL'] = "UPDATE ARTICULOS SET EXIVTA=".$REA.", FIV= getdate(),NIV=".$numinv." WHERE CODSEC = ".$nSec." AND CODART = ".$nArt."";
				$uARTICULOS = mssql_query($_SESSION['ParSQL']) or die("Error SQL");
				rollback($uARTICULOS);				
			}

			if ($teTIP == "DEPOSITO"){
				$DTO = 1;
			}else{
				$DTO = 0;
			}				

			if ($DIF < 0) {
				$_SESSION['ParSQL'] = "INSERT AMOVSTOC (SEC,ART,FEC,CYV,TIP,TCO,PVE,NCO,ORD,CAN,PUN,IMI,IMI2,LUG,TIM,DTO,OPE)
					VALUES(".$nSec.",".$nArt.",getdate(),'V','B','AJ',".$parPV.",".$numinv.",1,".abs($DIF).","
					.$PREVEN.",".$IMPINT.",".$IMPINT2.",".$LUG.",'Aj',".$DTO.",".$OPE.")";
				$IAMOVSTOC = mssql_query($_SESSION['ParSQL']) or die("Error SQL");
				rollback($IAMOVSTOC);							
			}else{
				$_SESSION['ParSQL'] = "INSERT AMOVSTOC (SEC,ART,FEC,CYV,TIP,TCO,PVE,NCO,ORD,CAN,PUN,IMI,IMI2,LUG,TIM,DTO,OPE)
					VALUES(".$nSec.",".$nArt.",getdate(),'C','B','AJ',".$parPV.",".$numinv.",1,".abs($DIF).","
					.$PREVEN.",".$IMPINT.",".$IMPINT2.",".$LUG.",'Aj',".$DTO.",".$OPE.")";
				$IAMOVSTOC = mssql_query($_SESSION['ParSQL']) or die("Error SQL");
				rollback($IAMOVSTOC);						
			}
		}
	}	//fin foreach
?>
<script>
	$('#Bloquear').fadeOut(500);
	//jAlert("El Inventario ya ha sido cargado y est&aacute; listo para ser impreso.", "Debo Retail - Global Business Solution");
	SoloNone("LetEnt, notomado_car");
	SoloBlock("LetTer");

	document.getElementById("orden").style.display = "none";

	document.getElementById("DondeE").value = "";
	document.getElementById("CantiE").value = "";
	document.getElementById("QuePoE").value = "";
	document.getElementById("impresion").style.display = "block";

	EnvAyuda("Seleccione el tipo de Impresi&oacute;n y presione Imprimir");
</script>
<?
}	//fin if (principal)
//exit();
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