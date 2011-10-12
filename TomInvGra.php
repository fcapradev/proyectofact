<?
require("config/cnx.php");

try {////////////////////////////////////////////////////////////////////////// COMIENZO TRY //

mssql_query("begin transaction",$conexion) or die("Error SQL begin trans");

set_time_limit(5000);

if(isset($_POST['item'])){

if(isset($_POST['sector'])){
	$teNomSec = $_POST['sector'];
	$sec = $_POST['sectorid'];
	$teNomRum = $_POST['rubrom'];
	$rum = $_POST['rubromid'];
	$nomrub = $_POST['rubro'];
	$numrub = $_POST['rubroid'];
	$detinv = $_POST['detsec'];
	$LugarInv = $_POST['tiposel'];
	$numinv = $_POST['numinv'];
	$muchos = $_POST['muchos'];
	$gr = $_POST['Grava'];
	$bot2 = $_POST['bot2'];
	$fecinv = date("Y-m-d H:i:s");
	$opeinv = $_POST['opeinventario'];
	$TER = $_SESSION['ParPOS'];
	$col = $_POST['colector2'];
}


$tipoInv = 1;
// opcoin de si muestra o no stock actual
$swMueStock=false;
// SALTO DE LINEA PARA TXT
$salto ="\r\n";

$_SESSION['ParSQL'] = "
	SELECT C.NplVen AS PLA, D.FAP AS FAP, A.MTN, A.DES, A.INI, A.FIN FROM ATURNOSH AS A 
	INNER JOIN APARPOS AS B ON B.ID = '".$_SESSION['ParPOS']."'
	INNER JOIN VENDEDORES AS C ON C.CodVen = B.OPE
	INNER JOIN ATURNOSO AS D ON D.PLA = C.NplVen
	WHERE A.MTN = D.MTN	";
$registros = mssql_query($_SESSION['ParSQL']) or die("Error SQL");
rollback($registros);		
if(mssql_num_rows($registros)==0){
	exit;
}
while ($reg=mssql_fetch_array($registros)){
	$PLA = $reg['PLA'];
}

mssql_free_result($registros);

$LUG = $_SESSION['ParLUG'];
$OPE = $_SESSION['idsusua'];



if($col == 1){				

//**************************************************//
//*********	ENTRA ACA SI GRABA POR COLECTOR	********//
//**************************************************//

	$_SESSION['ParSQL'] = "SELECT zon FROM aparemp";
	$APAREMP = mssql_query($_SESSION['ParSQL']) or die("Error SQL");
	rollback($APAREMP);
	while ($RSEC=mssql_fetch_array($APAREMP)){
		$numEmp = $RSEC['zon'];/****** NOMBRE DE LA EMPRESA *******/
	}
	mssql_free_result($APAREMP);

	//**	HACE UN UPDATE A DONDE DEBERÍA APUNTAR EL COLECTOR DE DATOS		**//
	$_SESSION['ParSQL'] = "UPDATE COMMAND SET RUTA_COLECTOR_DATOS = '".getcwd()."/Colector/'";
	$COMMAND = mssql_query($_SESSION['ParSQL']) or die("Error SQL");
	rollback($COMMAND);		

	$numEmp = $numEmp."\\";	
																		//*****************************************//
	$_SESSION['ParSQL'] = "SELECT RUTA_COLECTOR_DATOS FROM COMMAND";	// RECORDAR CAMBIAR LA RUTA DEL DIRECTORIO //
	$COMMAND = mssql_query($_SESSION['ParSQL']) or die("Error SQL");	//	grabar en la db el dir con "\" al final//
	rollback($COMMAND);													//*****************************************//
	while ($RCOM=mssql_fetch_array($COMMAND)){
		$sRutaPalm = $RCOM['RUTA_COLECTOR_DATOS'];
	}
	mssql_free_result($COMMAND);

//BORRA LOS DATOS DE LOS ARCHIVOS SI TIENE INFORMACIÓN VIEJA Y CREA LA CARPETA CON NOM DE EMPRESA
	if($gr == 1){ ///// INGRESA LA PRIMERA VEZ
		
		$sRutaPalm = $sRutaPalm.$numEmp; 
		if(!is_dir($sRutaPalm)){ 
			@mkdir($sRutaPalm, 0777); //crea carpeta con nombre de la empresa
		}  
		$fin=substr($sRutaPalm,strlen($sRutaPalm)-2);
		if ($fin <> '\\') {
			$sRutaPalm = $sRutaPalm."\\";
		}
		$sol = $sRutaPalm."solicitudes.txt";
		$art = $sRutaPalm."articulos.txt";
		$clear = fopen($sol,'w');	//BORRA SOLICITUDES
		$clear = fopen($art,'w');	//BORRA ARTICULOS
		fclose($clear);
	}



	$handle = fopen($sRutaPalm."solicitudes.txt", "a+");
	fclose($handle);
	$handle = fopen($sRutaPalm."articulos.txt", "a+");
	fclose($handle);




// FUNCION PARA GENERA EL TXT ARCHIVOS Y SOLICITUD
function Grabar_Solicitud($s,$n,$sRutaPalm){
	
	// SALTO DE LINEA PARA TXT
	$salto ="\r\n";
 	
	$_SESSION['ParSQL'] = "SELECT zon FROM aparemp";
	$APAREMP = mssql_query($_SESSION['ParSQL']) or die("Error SQL");
	rollback($APAREMP);
	while ($RSEC=mssql_fetch_array($APAREMP)){
		$numEmp = $RSEC['zon'];/****** NOMBRE DE LA EMPRESA *******/
	}
	mssql_free_result($APAREMP);
	
	$_SESSION['ParSQL'] = "SELECT NOMBRE FROM SECTORES WHERE ID=".$s."";
	$SECTORES = mssql_query($_SESSION['ParSQL']) or die("Error SQL");
	rollback($SECTORES);
	if(mssql_num_rows($SECTORES)==0){
		?>
		<script>

			$('#Bloquear').fadeOut(500);
			jAlert('No se ha podido crear el Archivo.', 'Debo Retail - Global Business Solution');
			document.getElementById('rubrotodos1').style.zIndex=-1;
			salir_tom();

		</script>
		<?
	}
	while ($RSEC=mssql_fetch_array($SECTORES)){
		$Dato[0] = substr($RSEC['NOMBRE'],0,25);
	}	
	mssql_free_result($SECTORES);
	
	$Dato[0]= format($numEmp,5,'0',STR_PAD_LEFT).trim($Dato[0]).str_repeat(" ",25 - strlen(trim($Dato[0])));
	$Dato[1]= format($s,10,'0',STR_PAD_LEFT);
	$Dato[2]= format($n,10,'0',STR_PAD_LEFT);
	$Dato[3]= "1";
	$Dato[4]= "1";
	$tipoInv = 1;
	$Dato[5]= date("dmY"); // DAR FORMATO DDMMYYYY  OOOOJOOOO!!!
	if ($tipoInv == 1){	//al azar
		$Dato[6]= "01";
	}else{
		$Dato[6]= "00";
	}

	$Dato[10] = $Dato[0].$Dato[1].$Dato[2].$Dato[3].$Dato[4].$Dato[5].$Dato[6];
	$handle = fopen($sRutaPalm."solicitudes.txt", "a+");
	fwrite($handle,$Dato[10]);
	fclose($handle);

////////// GENERA EL ARCHIVO ARTICULOS
				
	$PLA_ART = "SELECT A.INV,A.SEC,A.ART,A.RUM,A.RUB,A.DET,A.PRE,A.COS,A.TOM,A.CON,A.CAR,A.AJU,A.REA,A.DIF,B.CodBar
				FROM ITOMINVD A FULL JOIN CODBAR B ON B.CodSec=A.SEC AND B.CodArt=A.ART
				WHERE A.INV=".$n."";
	$ITOMINVD3 = mssql_query($PLA_ART) or die("Error SQL");
	rollback($ITOMINVD3);
	while ($RIT5 = mssql_fetch_array($ITOMINVD3)){
		$Dato[0] = format($n,10,'0',STR_PAD_LEFT);
		$Dato[1] = format($RIT5['SEC'],10,'0',STR_PAD_LEFT);
		$Dato[2] = format($RIT5['ART'],10,'0',STR_PAD_LEFT);
		
		$sAux = substr($RIT5['DET'],0, 25);
		$Dato[3] = $sAux;

		if(strlen($RIT5['CodBar'] > 13)) {
			 $Dato[4] = substr($RIT5['CodBar'],0, 13);
		}else{
		   $Dato[4] = trim($RIT5['CodBar']).str_repeat(" ",14 - strlen(trim($RIT5['CodBar'])));		
		}
	
		$Dato[5] = $Dato[0].$Dato[1].$Dato[2].$Dato[3].$Dato[4].$salto;
		$handle = fopen($sRutaPalm."articulos.txt", "a+");
		fwrite($handle,$Dato[5]);
		fclose($handle);
	}
	mssql_free_result($ITOMINVD3);

//	ACTUALIZA CUANDO GUARDA POR COLECTOR DE DATOS
	$_SESSION['ParSQL'] = "update inv_palm_rea set inv_rea=0 where num_inv=".$n."";
	$Uinv_palm_rea = mssql_query($_SESSION['ParSQL']) or die("Error SQL");
	rollback($Uinv_palm_rea);

}


	///////////////// INCIO DE CARGA ////////////////////
	
		//**************************************************//
		//****** INGRESA CUANDO SE PRESIONA GRABAR	********//
		//**************************************************//
		

		$DEPO = 0;
		if ($LugarInv == 0) {
		  $DEPO = 1;
		}

	////// Verifica si se ya existe en la DB   ///////////
		$_SESSION['ParSQL'] = "SELECT ID FROM ITOMINVC WHERE ID=".$numinv."";
		$INVENTARIO = mssql_query($_SESSION['ParSQL']) or die("Error SQL");
		rollback($INVENTARIO);
		
		if(mssql_num_rows($INVENTARIO)==0){
			$SQL0 = "INSERT INTO ITOMINVC (ID,DET,FET,EST,OPE,POS,DEP,DSE,DRM,RUB,DRU) 
			VALUES (".$numinv.",'".$detinv."',getdate(),'T',".$opeinv.",".$TER.",".$DEPO.",'".$teNomSec."','".$teNomRum."',".$numrub.",'".$nomrub."')";
			$IITOMINVC = mssql_query($SQL0) or die("Error SQL");
			rollback($IITOMINVC);
			
		}else{
			$SQL1= "UPDATE ITOMINVC SET DRU = 'VARIOS', RUB = 0 WHERE ID = ".$numinv."";
			$IITOMINVC1 = mssql_query($SQL1) or die("Error SQL");
			rollback($IITOMINVC1);
		}
	
		$_SESSION['ParSQL'] = "SELECT LIST_DEFECTO FROM APAREMP";
		$APAREMP = mssql_query($_SESSION['ParSQL']) or die("Error SQL");
		rollback($APAREMP);	
		if(mssql_num_rows($APAREMP)==0){
			?>
			<script>
				$('#Bloquear').fadeOut(500);
				jAlert('No se ha seleccionado ninguna lista para la empresa.', 'Debo Retail - Global Business Solution');
				document.getElementById('rubrostodos').disabled = true;
				document.getElementById('rubrostodos').checked = false;
				document.getElementById('rubrotodos1').style.zIndex=-1;
				salir_tom();
			</script>
			<?	
		}
								
		while ($REMP=mssql_fetch_array($APAREMP)){
			$iLista=$REMP['LIST_DEFECTO'];
		}
		mssql_free_result($APAREMP);
		
		if($iLista==0){
			?>
			<script>

				$('#Bloquear').fadeOut(500);
				jAlert('No se ha seleccionado ninguna lista para la empresa.', 'Debo Retail - Global Business Solution');
				document.getElementById('rubrostodos').disabled = true;
				document.getElementById('rubrostodos').checked = false;
				document.getElementById('rubrotodos1').style.zIndex=-1;
				salir_tom();

			</script>
			<?	
		}					
			
		$cNHA = " and NHA = 0 ";
		$cDEP = "";
		$cRum = "";
		$cRub = "";
		$cSec = "";
		
		if ($sec <> "T") {
			$cSec = " AND A.CODSEC=".$sec ;
		} 
		if ($rum <> 0){
		  $cRum = " AND A.RUBMAY = ".$rum."";
		}
		
		if ($numrub <> 0){
		  $cRub = " AND A.CODRUB = ".$numrub."" ;
		}
		  
		$cDEP = " ";
		if ($LugarInv == 0) {
		  $cDEP = " AND A.DEPSN = 1 ";
		}
		
			//////////////////////    RECORRE LA LISTA DE ITEMS QUE SE EXTRAJO    /////////////////////
			foreach ($_POST['item'] as $item){ /////////// REPITE ESTE PROCESO SEGUN LA CANTIDAD DE ITEM SELECCIONADOS
				$_SESSION['ParSQL'] = "SELECT A.CODSEC,A.CODART,A.CODRUB,A.DETART,
				ISNULL((SELECT TOP 1 PRECIO_".$iLista." FROM PLANILLA_COSTO WHERE A.CODSEC=SEC AND A.CODART=COD ),0) AS PREVEN, 
				EXIVTA,EXIDEP,ISNULL((SELECT TOP 1 COSTO FROM PLANILLA_COSTO WHERE A.CODSEC=SEC AND A.CODART=COD ),0) AS COSTO,
				DEPSN FROM ARTICULOS A WHERE  A.TIP NOT IN ('L','G','A') and 
				A.DETART <> 'þNOþDISPONIBLE' ".$cSec." ".$cRum." ".$cRub." ".$cDEP." ".$cNHA." AND A.CODART = ".$item." ORDER BY 			
				A.DETART";
				
				$ARTICULOS = mssql_query($_SESSION['ParSQL']) or die("Error SQL");
				rollback($ARTICULOS);
				if(mssql_num_rows($ARTICULOS)<>0){
					while ($RART = mssql_fetch_array($ARTICULOS)){
						$COL0 = format($RART['CODSEC'],2,'0',STR_PAD_LEFT)."-".format($RART['CODART'],4,'0',STR_PAD_LEFT);
						$COL2 = "NO";
						if ($RART['DEPSN']== true){
							$COL2="SI";
						}
						if($LugarInv==1){
							$COL5 = $RART['EXIVTA'];
						}else{
							$COL5 = $RART['EXIDEP'];
						}
					
			///////// se mueve atravez de los item seleccionados  ///////////
						$nSec = substr($COL0,0, 2);
						$nArt = substr($COL0,4, 4);
						$nRub = $RART['CODRUB'];
						$cDet = $RART['DETART'];
						$nPre = $RART['PREVEN'];
						$nExi = $COL5;
						$nCos = $RART['COSTO'];
						
	
						////// Verifica si se ya existe en la DB   ///////////
						$_SESSION['ParSQL'] = "SELECT INV,ART FROM ITOMINVD WHERE INV=".$numinv." AND ART =".$item."";
						$INVENTARIO1 = mssql_query($_SESSION['ParSQL']) or die("Error SQL");
						rollback($INVENTARIO1);
						if(mssql_num_rows($INVENTARIO1)==0){
							$SQL_2 = "INSERT INTO ITOMINVD (INV,SEC,ART,RUM,RUB,DET,PRE,COS,TOM,CAR) 
							VALUES (".$numinv.",".$nSec.",".$item.",".$rum.",".$nRub.",'".substr($cDet,0,50)."',".$nPre.",".$nCos.",".$nExi.",0)";
							$ITOMINVD2 = mssql_query($SQL_2) or die("Error SQL");
							rollback($ITOMINVD2);
						}
						mssql_free_result($INVENTARIO1);
						
					}//fin WHILE
				}//fin IF
				mssql_free_result($ARTICULOS);
			}//fin FOREACH
	
	if($muchos == 0){

		// CUANDO TERMINA DE GRABAR EN LA DB, ENVIO LOS DATOS PARA GUARDAR LA INFO EN UN TXT PARA EL COLECTOR DE DATOS
		Grabar_Solicitud($sec, $numinv, $sRutaPalm);
	
		////// Verifica si se ya existe en la DB   ///////////	
		$_SESSION['ParSQL'] = "SELECT NUM_INV FROM INV_PALM_REA WHERE NUM_INV=".$numinv."";
		$INVENTARIO = mssql_query($_SESSION['ParSQL']) or die("Error SQL");
		rollback($INVENTARIO);	
		if(mssql_num_rows($INVENTARIO)==0){
			$_SESSION['ParSQL'] = "INSERT INTO INV_PALM_REA (NUM_INV,FEC_INV,INV_REA) 
			VALUES (".$numinv.",'".$fecinv."',0)";
			$INV_PALM_REA = mssql_query($_SESSION['ParSQL']) or die("Error SQL");
			rollback($INV_PALM_REA);
		}
		mssql_free_result($INVENTARIO);
		
	}else{
	
		$_SESSION["ActLis"] = 0;

		?>
		<script>
			
			$('#Bloquear').fadeOut(500);		
			jAlert('Rubro Cargado.', 'Debo Retail - Global Business Solution');
		
			$("#rub").css("border-color", "#F90");
			EnvAyuda("Ingrese un Rubro o Presione Enter para listar");
	
		</script>
		<?
	
	}

							
}else{						
	//**************************************************//
	//*********	ENTRA ACA SI TOMA MANUALMENTE	********//
	//**************************************************//

	$DEPO = 0;
	if ($LugarInv == 0) {
	  $DEPO = 1;
	}


	//**************************************************//
	//****** INGRESA CUANDO SE PRESIONA GRABAR	********//
	//**************************************************//
	
	
	////// CONTROLA SI EXISTE, SINO ESTA CARGANDO VARIOS RUBROS   ///////////
	
		$_SESSION['ParSQL'] = "SELECT ID FROM ITOMINVC WHERE ID=".$numinv."";
		$INVENTARIO = mssql_query($_SESSION['ParSQL']) or die("Error SQL");
		rollback($INVENTARIO);
		if(mssql_num_rows($INVENTARIO) == 0){			//	GRABA SI NO EXISTE
			$SQL0 = "INSERT INTO ITOMINVC (ID,DET,FET,EST,OPE,POS,DEP,DSE,DRM,RUB,DRU) 
			VALUES (".$numinv.",'".$detinv."',getdate(),'T',".$opeinv.",".$TER.",".$DEPO.",'".$teNomSec."','".$teNomRum."',".$numrub.",'".$nomrub."')";
			$IITOMINVC = mssql_query($SQL0) or die("Error SQL");
			rollback($IITOMINVC);
		}else{											//	ACTUALIZA EL DRU SI EXISTE
			$SQL1= "UPDATE ITOMINVC SET DRU = 'VARIOS', RUB = 0 WHERE ID = ".$numinv."";
			$IITOMINVC1 = mssql_query($SQL1) or die("Error SQL");
			rollback($IITOMINVC1);
		}
		mssql_free_result($INVENTARIO);
		
		$cNHA = " and NHA = 0 ";
		$cDEP = "";
		$cRum = "";
		$cRub = "";
		$cSec = "";
		
		if ($rum <> 0){
		  $cRum = " AND RUBMAY = ".$rum."";
		}
		
		if ($numrub <> 0){
		  $cRub = " AND CODRUB = ".$numrub."" ;
		}
		  
		$cDEP = " ";
		if ($LugarInv == 0) {
		  $cDEP = " AND DEPSN = 1 ";
		}
	
	
	//////////////////////    RECORRE LA LISTA DE ITEMS QUE SE EXTRAJO    /////////////////////
	
	
		foreach ($_POST['item'] as $item){ /////////// REPITE ESTE PROCESO SEGUN LA CANTIDAD DE ITEM SELECCIONADOS
			$_SESSION['ParSQL'] = "SELECT CODSEC,CODART,CODRUB,DEPSN,DETART,round(PREVEN,4,1) PREVEN,round(EXIVTA,4,1) EXIVTA, round(EXIDEP,4,1)EXIDEP,round(COSTO,4,1) COSTO 
			  FROM ARTICULOS 
			  WHERE TIP NOT IN ('L','G','A') and detart <> 'þNOþDISPONIBLE' 
			  AND CODSEC = ".$sec." ".$cRum." ".$cRub." ".$cDEP." ".$cNHA." AND CODART = ".$item." AND NOT CLA IN(3,4,7) ORDER BY DETART ";
			
			$ARTICULOS = mssql_query($_SESSION['ParSQL']) or die("Error SQL");
			rollback($ARTICULOS);
			if(mssql_num_rows($ARTICULOS)<>0){
				while ($RART = mssql_fetch_array($ARTICULOS)){
					$COL0=format($RART['CODSEC'],2,'0',STR_PAD_LEFT)."-".format($RART['CODART'],4,'0',STR_PAD_LEFT);
					$COL2="NO";
					if ($RART['DEPSN']== true){
						$COL2="SI";
					}
					if($LugarInv == 1){
						$COL5 = $RART['EXIVTA'];
					}else{
						$COL5 = $RART['EXIDEP'];
					}
				
	///////// se mueve atravez de los item seleccionados  ///////////
					$nSec = substr($COL0,0, 2);
					$nArt = substr($COL0,4, 4);
					$nRub = $RART['CODRUB'];
					$cDet = $RART['DETART'];
					$nPre = $RART['PREVEN'];
					$nExi = $COL5;
					$nCos = $RART['COSTO'];
					
	
	////// VERIFICA SI YA EXISTE EN LA TABLA ITOMINVD   ///////////
	
					$_SESSION['ParSQL'] = "SELECT INV,ART FROM ITOMINVD WHERE INV=".$numinv." AND ART =".$item."";
					$INVENTARIO1 = mssql_query($_SESSION['ParSQL']) or die("Error SQL");
					rollback($INVENTARIO1);
					if(mssql_num_rows($INVENTARIO1)==0){
						$nCos = str_replace(",",".",$nCos);
						$SQL_2 = "INSERT INTO ITOMINVD (INV,SEC,ART,RUM,RUB,DET,PRE,COS,TOM,CAR) 
						VALUES (".$numinv.",".$nSec.",".$item.",".$rum.",".$nRub.",'".substr($cDet,0,50)."',".$nPre.",".$nCos.",".$nExi.",0)";
						$ITOMINVD2 = mssql_query($SQL_2) or die("Error SQL");
						rollback($ITOMINVD2);
					}
					mssql_free_result($INVENTARIO1);
				}//fin WHILE
			}//fin IF
			mssql_free_result($ARTICULOS);
		}//fin FOREACH

		if($muchos == 1){
			
			$_SESSION["ActLis"] = 0;
			
			?>
			<script>

                $('#Bloquear').fadeOut(500);		
                jAlert('Rubro Cargado.', 'Debo Retail - Global Business Solution');

				$("#rub").css("border-color", "#F90");
				EnvAyuda("Ingrese un Rubro o Presione Enter para listar");
       
            </script>
            <?
			
		}

	}

?>
<script>
	var ban = document.getElementById("Grava").value;

	if(ban != 1){
		jAlert('Rubro Cargado Correctamente.', 'Debo Retail - Global Business Solution');
	}else{
		jAlert('Inventario Cargado Correctamente.', 'Debo Retail - Global Business Solution');
	}

	$('#Bloquear').fadeOut(500);
	document.getElementById("eliminar").value = "si";		

</script>
<?
$_SESSION["ActLis"] = 0;

}



////////////////////////////////////////////////////////////////////////////////////
//**	CUANDO SALE DE LA TOMA DE INVENTARIO DEBE BORRAR LO QUE HABIA GUARDADO	**//
////////////////////////////////////////////////////////////////////////////////////

if(isset($_REQUEST['eli'])){

	$eli = $_REQUEST['eli'];
	$inv = $_REQUEST['inv'];

	if( $eli == "si" ){

		//	BORRO DE LA ITOMINVC
		$_SESSION['ParSQL'] = "DELETE FROM ITOMINVC WHERE ID=".$inv."";
		$INVENTARIO1 = mssql_query($_SESSION['ParSQL']) or die("Error SQL");
		rollback($INVENTARIO1);
		
		//	BORRO DE LA ITOMINVD
		$_SESSION['ParSQL'] = "DELETE FROM ITOMINVD WHERE INV=".$inv."";
		$INVENTARIO1 = mssql_query($_SESSION['ParSQL']) or die("Error SQL");
		rollback($INVENTARIO1);

		//	BORRO DE LA INV_PALM_REA
		$_SESSION['ParSQL'] = "DELETE FROM INV_PALM_REA WHERE NUM_INV=".$inv."";
		$INVENTARIO1 = mssql_query($_SESSION['ParSQL']) or die("Error SQL");
		rollback($INVENTARIO1);
		
	}
}




mssql_query("commit transaction") or die("Error SQL commit");

}catch(Exception $e){////////////////////////////////////////////////////////////////////////////////////////////////// FIN DE TRY 

	?>
	<script>
		jAlert('ERROR Reintente la operacion solicitada.', 'Debo Retail - Global Business Solution');
	</script>
	<?

exit;

}

?>