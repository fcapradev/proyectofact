<?
require("../config/cnx.php");
try {////////////////////////////////////////// COMIENZO TRY //
mssql_query("begin transaction",$conexion) or die("Error SQL begin trans");


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

//////////////////////////////////////////////////////////////
////////////////////////	NUMERO	  ////////////////////////
//////////////////////////////////////////////////////////////

if(isset($_REQUEST['tipo'])){
	$tipo = $_REQUEST['tipo'];

	if($tipo == 'A'){
		$_SESSION['ParSQL'] = "SELECT NUM+1 AS NUM FROM ANUMFACT WHERE TCO = 'NA' AND SUC = ".$_SESSION['ParEMP']." AND TIP = 'B' AND IPM = 'M'";
	}else{
		$_SESSION['ParSQL'] = "SELECT NUM+1 AS NUM FROM ANUMFACT WHERE TCO = 'NB' AND SUC = ".$_SESSION['ParEMP']." AND TIP = 'B' AND IPM = 'M'";
	}

	$TIPONOTA = mssql_query($_SESSION['ParSQL']) or die("Error SQL");
	rollback($TIPONOTA);
	while ($REG=mssql_fetch_array($TIPONOTA)){
		$NUM = $REG['NUM'];
	}
	?>
    <script>
		document.getElementById("Num").value = "<? echo $NUM; ?>";
		$("#TipoOperacionDiv").css("border-color", "#F90");
		$("#TipoNotaDiv").css("border-color", "transparent");

		SoloBlock("Pve, Fecha");
		document.getElementById("TipoOperacion").value = "";
		
		Ir_a("TipoOperacion",1,2);

		EnvAyuda("Seleccione un Tipo de Operaci&oacute;n.");
	
		document.getElementById('LetEnt').innerHTML = '<button onclick="SelTipOper();" class="StyBoton" onmouseout="MM_swapImgRestore()" onmouseover="MM_swapImage(\'LetEntTomInv3\',\'\',\'botones/ent-over.png\',0)"><img src="botones/ent-up.png" name="Enter" title="Enter" border="0" id="LetEntTomInv3"/></button>';
		
		document.getElementById('NumVol').innerHTML = '<button onclick="VolTipoNota();" class="StyBoton" onmouseout="MM_swapImgRestore()" onmouseover="MM_swapImage(\'LetVolTomInv0\',\'\',\'botones/vol-over.png\',0)"><img src="botones/vol-up.png" name="Volver" title="Volver" border="0" id="LetVolTomInv0"/></button>';

	</script>
    <?
}


//////////////////////////////////////////////////////////////
/////////////////// 	VALIDA USUARIO	  ////////////////////
//////////////////////////////////////////////////////////////

if(isset($_REQUEST['psw'])){

	$psw = $_REQUEST['psw'];
	$TipoN = $_REQUEST['tipoN'];
	
	////	BUSCA EL SUPERVISOR

	$_SESSION['ParSQL'] = "SELECT CodVen FROM VENDEDORES WHERE ClaVen = '".$psw."'"; 
	$R1TB = mssql_query($_SESSION['ParSQL']) or die("Error SQL");
	rollback($R1TB);		


	if(mssql_num_rows($R1TB) == 1){
		while ($REG=mssql_fetch_array($R1TB)){
			$CodVen = $REG['CodVen'];
		}
	
		$_SESSION['ParSQL'] = "SELECT OPE,TCO FROM AVENTCO WHERE OPE = ".$CodVen."";
		$AVE = mssql_query($_SESSION['ParSQL']) or die("Error SQL");
		rollback($AVE);		
		$NA = 0;
		$NB = 0;
		while ($AVEREG = mssql_fetch_array($AVE)){
			
			if($AVEREG['TCO'] == 'NA'){
				$NA = 1;
				$OPE = $AVEREG['OPE'];
			}
			if($AVEREG['TCO'] == 'NB'){
				$NB = 2;
				$OPE = $AVEREG['OPE'];
			}
		}
		
		if($TipoN == 1 && $NA == 1){
			?>
			<script>
				$("#OperadorDiv").css("border-color", "transparent");
				document.getElementById("OpeVal").value = <? echo $OPE; ?>;
				muestrasiguiente();
			</script>	
			<?
		}else{
			if($TipoN == 2 && $NB == 2){
				?>
				<script>
					$("#OperadorDiv").css("border-color", "transparent");
					document.getElementById("OpeVal").value = <? echo $OPE; ?>;
					muestrasiguiente();
				</script>	
				<?
			}else{
				?>
				<script>
					document.getElementById("Operador").value = "";
					jAlert('El Operario no tiene permisos para realizar Notas.', 'Debo Retail - Global Business Solution');			
				</script>	
				<?	
			}
		}
	}else{
		?>
		<script>
			document.getElementById("Operador").value = "";
			jAlert('Ingrese correctamente su contraseña.', 'Debo Retail - Global Business Solution');			
		</script>	
		<?	
	}
}


//////////////////////////////////////////////////////////////
////////////////// 	 ACTUALIZA ARTICULO	  ////////////////////
//////////////////////////////////////////////////////////////

if(isset($_REQUEST['act'])){

	$s = $_REQUEST['sec'];
	$art = $_REQUEST['art'];
	$codrub = $_REQUEST['codrub'];

	$_SESSION['ParSQL'] = "SELECT DEPSN,CODSEC,CODART FROM ARTICULOS WHERE CODSEC = ".$s." AND CODRUB = ".$codrub." AND CODART =".$art."";
	$ARTICULOS = mssql_query($_SESSION['ParSQL']) or die("Error SQL");
	rollback($ARTICULOS);		
	while ($RART=mssql_fetch_array($ARTICULOS)){
		$nVta = 0;
      	$nCom = 0;
      	$nAju = 0;
		
		if ($RART['DEPSN'] == true){

			$_SESSION['ParSQL'] = "
			SELECT ISNULL(SUM(CAN),0) AS VTA 
			FROM AMOVSTOC WHERE CYV = 'V' AND NOT TCO IN ('NC','NI')  AND TIM IN (
			'Ve','DV','OD','DX','DR','DQ','DO','Aj','Ax','DV') AND SEC = ".$RART['CODSEC']." AND ART = ".$RART['CODART']." AND DTO = 1 AND ANU <> 'A'";
			
			$AMOVSTOC = mssql_query($_SESSION['ParSQL']) or die("Error SQL");
			rollback($AMOVSTOC);		
			
			while ($RAMOV=mssql_fetch_array($AMOVSTOC)){
				$nVta=$RAMOV['VTA'];
			}
			mssql_free_result($AMOVSTOC);
		

			$_SESSION['ParSQL'] = "SELECT ISNULL(SUM(CAN),0) AS COM 
					FROM AMOVSTOC WHERE CYV = 'C' AND TCO IN ('NC','NI') AND TIM IN ('Co') 
					AND SEC = ".$RART['CODSEC']." AND ART = ".$RART['CODART']." AND DTO =1 AND ANU <> 'A'";
			$AMOVSTOC = mssql_query($_SESSION['ParSQL']) or die("Error SQL");
			rollback($AMOVSTOC);		
			
			while ($RAMOV=mssql_fetch_array($AMOVSTOC)){
				$nVta= $nVta + $RAMOV['COM'];
			}			
			mssql_free_result($AMOVSTOC);
			

			$_SESSION['ParSQL'] = "SELECT  ISNULL(SUM(CAN),0) AS COM 
					FROM AMOVSTOC WHERE CYV = 'C' AND TIM IN ('Co','Aj','Ax','DV','VD','OD','DO','DX','DR') 
					AND SEC = ".$RART['CODSEC']." AND ART = ".$RART['CODART']." AND NOT TCO IN ('NC','NI') AND DTO =1 AND ANU <> 'A'";
			$AMOVSTOC = mssql_query($_SESSION['ParSQL']) or die("Error SQL");
			rollback($AMOVSTOC);		
			while ($RAMOV=mssql_fetch_array($AMOVSTOC)){
				$nCom= $nCom + $RAMOV['COM'];
			}
			mssql_free_result($AMOVSTOC);

			$nAju = $nCom - $nVta;
			
			$_SESSION['ParSQL'] = "UPDATE ARTICULOS 
				SET EXIDEP = ".str_replace(",",".",$nAju)." WHERE CodSec = ".$RART['CODSEC']." AND CodArt = ".$RART['CODART']."";
			$UARTICULOS = mssql_query($_SESSION['ParSQL']) or die("Error SQL");
			rollback($UARTICULOS);			
		}
		
////////// VENTAS SIEMPRE HACE ESTO

		$nVta = 0;
      	$nCom = 0;
      	$nAju = 0;
		$_SESSION['ParSQL'] = "SELECT ISNULL(SUM(CAN),0) AS VTA FROM AMOVSTOC WHERE TCO NOT IN ('NC','NI')  
				AND CYV = 'V' AND TIM IN ('Ve','VX','VV','VR','VQ','OV','VD','VO','Aj','Ax','DV','DO','AC') 
				AND SEC = ".$RART['CODSEC']." AND ART = ".$RART['CODART']." AND DTO = 0 AND ANU <> 'A'";
		$AMOVSTOC = mssql_query($_SESSION['ParSQL']) or die("Error SQL");
		rollback($AMOVSTOC);		
		while ($RAMOV=mssql_fetch_array($AMOVSTOC)){
			$nVta=$RAMOV['VTA'];
		}
		mssql_free_result($AMOVSTOC);
		
		$_SESSION['ParSQL'] = "SELECT ISNULL(SUM(CAN),0)  AS COM 
				FROM AMOVSTOC WHERE TCO IN ('NC','NI')  AND CYV = 'V' AND TIM IN('Ve','VX','VV','VR','VQ','OV','VD','VO')
				AND SEC = ".$RART['CODSEC']." AND ART = ".$RART['CODART']." AND DTO = 0 AND ANU <> 'A'";
		$AMOVSTOC = mssql_query($_SESSION['ParSQL']) or die("Error SQL");
		rollback($AMOVSTOC);		
		while ($RAMOV=mssql_fetch_array($AMOVSTOC)){
			$nCom=$RAMOV['COM'];
		}
		mssql_free_result($AMOVSTOC);		

		$_SESSION['ParSQL'] = "SELECT ISNULL(SUM(CAN),0)  AS VTA 
				FROM AMOVSTOC WHERE CYV = 'C' AND TCO IN ('NC','NI')  AND TIM IN ('Co')  
				AND SEC = ".$RART['CODSEC']." AND ART = ".$RART['CODART']." AND DTO = 0 AND ANU <> 'A'";
		$AMOVSTOC = mssql_query($_SESSION['ParSQL']) or die("Error SQL");
		rollback($AMOVSTOC);		
		while ($RAMOV=mssql_fetch_array($AMOVSTOC)){
			$nVta=$nVta + $RAMOV['VTA'];
		}			
		mssql_free_result($AMOVSTOC);
		
		$_SESSION['ParSQL'] = "SELECT ISNULL(SUM(CAN),0)  AS COM 
				FROM AMOVSTOC WHERE  CYV = 'C' AND TCO IN ('NA') AND TIM IN ('VV')  
				AND SEC = ".$RART['CODSEC']." AND ART = ".$RART['CODART']." AND DTO = 0 AND ANU <> 'A'";
		$AMOVSTOC = mssql_query($_SESSION['ParSQL']) or die("Error SQL");
		rollback($AMOVSTOC);		
		while ($RAMOV=mssql_fetch_array($AMOVSTOC)){
			$nCom=$nCom + $RAMOV['COM'];
		}
		mssql_free_result($AMOVSTOC);


		$_SESSION['ParSQL'] = "SELECT ISNULL(SUM(CAN),0)  AS COM 
				FROM AMOVSTOC WHERE  CYV = 'C' AND TIM IN ('Co','Aj','Ax','DV','VD','OV')  AND NOT TCO IN ( 'NC','NI')
				AND SEC = ".$RART['CODSEC']." AND ART = ".$RART['CODART']." AND DTO = 0 AND ANU <> 'A'";
		$AMOVSTOC = mssql_query($_SESSION['ParSQL']) or die("Error SQL");
		rollback($AMOVSTOC);		
		while ($RAMOV=mssql_fetch_array($AMOVSTOC)){
			$nCom=$nCom + $RAMOV['COM'];
		}
		mssql_free_result($AMOVSTOC);		

		$nAju = $nCom - $nVta;
		
		$_SESSION['ParSQL'] = "UPDATE ARTICULOS SET EXIVTA = ".str_replace(",",".",$nAju)." WHERE CodSec = ".$RART['CODSEC']." AND CodArt = ".$RART['CODART']."";
		$UARTICULOS = mssql_query($_SESSION['ParSQL']) or die("Error SQL");
		rollback($UARTICULOS);		
		}
		mssql_free_result($ARTICULOS);

}


//////////////////////////////////////////////////////////////
/////////////////// 	NOTA DE ALTA	  ////////////////////
///////////////////   DEPOSITO ->VENTAS	  ////////////////////
//////////////////////////////////////////////////////////////

if(isset($_REQUEST['ter'])){

	$tn = $_REQUEST['tn'];
	$movtip = $_REQUEST['movtip'];	//TIPO DE NOTA
	$ord = $_REQUEST['i'];			//ORDEN DEL ITEM
	$ope = $_REQUEST['ope'];		//OPERARIO O LOCAL
	$co = $_REQUEST['co'];			//CODIGO ORIGEN
	$cd = $_REQUEST['cd'];			//CODIGO DESTINO
	$canDes = $_REQUEST['candes'];	//CANTIDAD
	$cosDes = $_REQUEST['cosdes'];	//COSTO

	$CodOri = explode("-", $co);
	$CodDes = explode("-", $cd);

	if($tn == 1){
		$tipo = "NA";
		$_SESSION['ParSQL'] = "SELECT NUM+1 AS NUM FROM ANUMFACT WHERE TCO = 'NA' AND SUC = ".$_SESSION['ParEMP']." AND TIP = 'B' AND IPM = 'M'";
	}else{
		$tipo = "NB";
		$_SESSION['ParSQL'] = "SELECT NUM+1 AS NUM FROM ANUMFACT WHERE TCO = 'NB' AND SUC = ".$_SESSION['ParEMP']." AND TIP = 'B' AND IPM = 'M'";
	}

	$TIPONOTA = mssql_query($_SESSION['ParSQL']) or die("Error SQL");
	rollback($TIPONOTA);
	while ($REG=mssql_fetch_array($TIPONOTA)){
		$nco = $REG['NUM'];
	}
	?>
    <script>
		document.getElementById("Num").value = <? echo $nco; ?>;
	</script>
    <?

	switch($movtip){

    case "1":

////////GUARDO SESIONES PARA PDF////////////////
		$producto['sec'][1] = $CodOri[0];	//SEC
		$producto['art'][1] = $CodOri[1]; 	//ART
		$producto['sec'][2] = $CodDes[0]; 	//SEC
		$producto['art'][2] = $CodDes[1]; 	//ART
		
		$_SESSION['Producto'] = $producto; 			
/////////////////////////////////////////////////
	
	////	INSERTO EN AMOVSTOC	()
		$_SESSION['ParSQL'] = "
		INSERT INTO AMOVSTOC (SEC,ART,FEC,CYV,TIP,TCO,PVE,NCO,ORD,CAN,PUN,COD,DTO,IMI,PLA,LUG,ANU,TIM,OPE,IMI2)
		VALUES(".$CodOri[0].",".$CodOri[1].",getdate(),'V','B','".$tipo."',".$_SESSION['ParEMP'].",".$nco.",".$ord.",".$canDes.",".$cosDes.",".$ope.",-1,0,".$PLA.",".$_SESSION['ParLUG'].",'','VA',".$ope.", 0 )";
		$AMOV2 = mssql_query($_SESSION['ParSQL']) or die("Error SQL");
		rollback($AMOV2);	
		
			$_SESSION['ParSQL'] = "SELECT EXIVTA FROM ARTICULOS WHERE CODSEC = ".$CodOri[0]." AND CodArt = ".$CodOri[1]."";
			$ARTICULOS = mssql_query($_SESSION['ParSQL']) or die("Error SQL");
			rollback($ARTICULOS);		
			while ($RART=mssql_fetch_array($ARTICULOS)){
				$exivta = $RART['EXIVTA'];
			}
			
			$stock2_ori = $exivta - $canDes;
			
			$_SESSION['ParSQL'] = "UPDATE ARTICULOS SET EXIVTA = ".$stock2_ori." WHERE CODSEC = ".$CodOri[0]." AND CodArt = ".$CodOri[1]."";
			$UARTICULOS = mssql_query($_SESSION['ParSQL']) or die("Error SQL");
			rollback($UARTICULOS);

        break;		

    case "2":
////	INSERTO EN AMOVSTOC	(LADO IZQUIERDO - > V)
		$_SESSION['ParSQL'] = "
		INSERT INTO AMOVSTOC (SEC,ART,FEC,CYV,TIP,TCO,PVE,NCO,ORD,CAN,PUN,COD,DTO,IMI,PLA,LUG,ANU,TIM,OPE,IMI2)
		VALUES(".$CodOri[0].",".$CodOri[1].",getdate(),'V','B','".$tipo."',".$_SESSION['ParEMP'].",".$nco.",".$ord.",".$canDes.",".$cosDes.",".$ope.",0,0,".$PLA.",".$_SESSION['ParLUG'].",'','VD',".$ope.", 0 )";
		$AMOV1 = mssql_query($_SESSION['ParSQL']) or die("Error SQL");
		rollback($AMOV1);
	
	////	INSERTO EN AMOVSTOC	(LADO DERECHO - > C)
		$_SESSION['ParSQL'] = "
		INSERT INTO AMOVSTOC (SEC,ART,FEC,CYV,TIP,TCO,PVE,NCO,ORD,CAN,PUN,COD,DTO,IMI,PLA,LUG,ANU,TIM,OPE,IMI2)
		VALUES(".$CodDes[0].",".$CodDes[1].",getdate(),'C','B','".$tipo."',".$_SESSION['ParEMP'].",".$nco.",".$ord.",".$canDes.",".$cosDes.",".$ope.",1,0,".$PLA.",".$_SESSION['ParLUG'].",'','VD',".$ope.", 0 )";
		$AMOV2 = mssql_query($_SESSION['ParSQL']) or die("Error SQL");
		rollback($AMOV2);	

////	ACTUALIZO ORIGEN (IZQUIERDA)		
		$_SESSION['ParSQL'] = "SELECT EXIDEP,EXIVTA FROM ARTICULOS WHERE CODSEC = ".$CodOri[0]." AND CodArt = ".$CodOri[1]."";
		$ARTICULOS = mssql_query($_SESSION['ParSQL']) or die("Error SQL");
		rollback($ARTICULOS);		
		while ($RART=mssql_fetch_array($ARTICULOS)){
			$exivta = $RART['EXIVTA'];
		}
		$stock2_des = $exivta - $canDes;
		
		$_SESSION['ParSQL'] = "UPDATE ARTICULOS SET EXIVTA = ".$stock2_des." WHERE CODSEC = ".$CodOri[0]." AND CodArt = ".$CodOri[1]."";
		$UARTICULOS = mssql_query($_SESSION['ParSQL']) or die("Error SQL");
		rollback($UARTICULOS);		
		
////	ACTUALIZO DESTINO (DERECHA)
		$_SESSION['ParSQL'] = "SELECT EXIDEP,EXIVTA FROM ARTICULOS WHERE CODSEC = ".$CodDes[0]." AND CodArt = ".$CodDes[1]."";
		$ARTICULOS = mssql_query($_SESSION['ParSQL']) or die("Error SQL");
		rollback($ARTICULOS);		
		while ($RART=mssql_fetch_array($ARTICULOS)){
			$exidep = $RART['EXIDEP'];
		}
		
		$stock1_ori = $exidep + $canDes;
		
		$_SESSION['ParSQL'] = "UPDATE ARTICULOS SET EXIDEP = ".$stock1_ori." WHERE CODSEC = ".$CodDes[0]." AND CodArt = ".$CodDes[1]."";
		$UARTICULOS = mssql_query($_SESSION['ParSQL']) or die("Error SQL");
		rollback($UARTICULOS);		


        break;

    case "3":

////////GUARDO SESIONES PARA PDF////////////////
		$producto['sec'][1] = $CodOri[0];	//SEC
		$producto['art'][1] = $CodOri[1]; 	//ART
		$producto['sec'][2] = $CodDes[0]; 	//SEC
		$producto['art'][2] = $CodDes[1]; 	//ART
		
		$_SESSION['Producto'] = $producto; 			
/////////////////////////////////////////////////
	
	////	INSERTO EN AMOVSTOC	()
		$_SESSION['ParSQL'] = "
		INSERT INTO AMOVSTOC (SEC,ART,FEC,CYV,TIP,TCO,PVE,NCO,ORD,CAN,PUN,COD,DTO,IMI,PLA,LUG,ANU,TIM,OPE,IMI2)
		VALUES(".$CodOri[0].",".$CodOri[1].",getdate(),'V','B','".$tipo."',".$_SESSION['ParEMP'].",".$nco.",".$ord.",".$canDes.",".$cosDes.",".$ope.",0,0,".$PLA.",".$_SESSION['ParLUG'].",'','VX',".$ope.", 0 )";
		$AMOV2 = mssql_query($_SESSION['ParSQL']) or die("Error SQL");
		rollback($AMOV2);	
		
			$_SESSION['ParSQL'] = "SELECT EXIVTA FROM ARTICULOS WHERE CODSEC = ".$CodOri[0]." AND CodArt = ".$CodOri[1]."";
			$ARTICULOS = mssql_query($_SESSION['ParSQL']) or die("Error SQL");
			rollback($ARTICULOS);		
			while ($RART=mssql_fetch_array($ARTICULOS)){
				$exivta = $RART['EXIVTA'];
			}
			
			$stock2_ori = $exivta - $canDes;
			
			$_SESSION['ParSQL'] = "UPDATE ARTICULOS SET EXIVTA = ".$stock2_ori." WHERE CODSEC = ".$CodOri[0]." AND CodArt = ".$CodOri[1]."";
			$UARTICULOS = mssql_query($_SESSION['ParSQL']) or die("Error SQL");
			rollback($UARTICULOS);

        break;		

    case "4":
////////GUARDO SESIONES PARA PDF////////////////
		$producto['sec'][1] = $CodOri[0]; 
		$producto['art'][1] = $CodOri[1]; 
		$producto['sec'][2] = $CodDes[0]; 
		$producto['art'][2] = $CodDes[1]; 
		
		$_SESSION['Producto'] = $producto; 			
/////////////////////////////////////////////////
	
	////	INSERTO EN AMOVSTOC	()
		$_SESSION['ParSQL'] = "
		INSERT INTO AMOVSTOC (SEC,ART,FEC,CYV,TIP,TCO,PVE,NCO,ORD,CAN,PUN,COD,DTO,IMI,PLA,LUG,ANU,TIM,OPE,IMI2)
		VALUES(".$CodOri[0].",".$CodOri[1].",getdate(),'V','B','".$tipo."',".$_SESSION['ParEMP'].",".$nco.",".$ord.",".$canDes.",".$cosDes.",".$ope.",1,0,".$PLA.",".$_SESSION['ParLUG'].",'','DX',".$ope.", 0 )";
		$AMOV2 = mssql_query($_SESSION['ParSQL']) or die("Error SQL");
		rollback($AMOV2);	
		
			$_SESSION['ParSQL'] = "SELECT EXIDEP FROM ARTICULOS WHERE CODSEC = ".$CodOri[0]." AND CodArt = ".$CodOri[1]."";
			$ARTICULOS = mssql_query($_SESSION['ParSQL']) or die("Error SQL");
			rollback($ARTICULOS);		
			while ($RART=mssql_fetch_array($ARTICULOS)){
				$exidep = $RART['EXIDEP'];
			}
			
			$stock2_ori = $exidep - $canDes;
			
			$_SESSION['ParSQL'] = "UPDATE ARTICULOS SET EXIDEP = ".$stock2_ori." WHERE CODSEC = ".$CodOri[0]." AND CodArt = ".$CodOri[1]."";
			$UARTICULOS = mssql_query($_SESSION['ParSQL']) or die("Error SQL");
			rollback($UARTICULOS);

        break;		

    case "5":

////////GUARDO SESIONES PARA PDF////////////////
		$producto['sec'][1] = $CodOri[0]; 
		$producto['art'][1] = $CodOri[1]; 
		$producto['sec'][2] = $CodDes[0]; 
		$producto['art'][2] = $CodDes[1]; 
		
		$_SESSION['Producto'] = $producto; 			
/////////////////////////////////////////////////
	
	////	INSERTO EN AMOVSTOC	()
		$_SESSION['ParSQL'] = "
		INSERT INTO AMOVSTOC (SEC,ART,FEC,CYV,TIP,TCO,PVE,NCO,ORD,CAN,PUN,COD,DTO,IMI,PLA,LUG,ANU,TIM,OPE,IMI2)
		VALUES(".$CodOri[0].",".$CodOri[1].",getdate(),'V','B','".$tipo."',".$_SESSION['ParEMP'].",".$nco.",".$ord.",".$canDes.",".$cosDes.",".$ope.",0,0,".$PLA.",".$_SESSION['ParLUG'].",'','VR',".$ope.", 0 )";
		$AMOV2 = mssql_query($_SESSION['ParSQL']) or die("Error SQL");
		rollback($AMOV2);	
		
			$_SESSION['ParSQL'] = "SELECT EXIVTA FROM ARTICULOS WHERE CODSEC = ".$CodOri[0]." AND CodArt = ".$CodOri[1]."";
			$ARTICULOS = mssql_query($_SESSION['ParSQL']) or die("Error SQL");
			rollback($ARTICULOS);		
			while ($RART=mssql_fetch_array($ARTICULOS)){
				$exivta = $RART['EXIVTA'];
			}
			
			$stock2_ori = $exivta - $canDes;
			
			$_SESSION['ParSQL'] = "UPDATE ARTICULOS SET EXIVTA = ".$stock2_ori." WHERE CODSEC = ".$CodOri[0]." AND CodArt = ".$CodOri[1]."";
			$UARTICULOS = mssql_query($_SESSION['ParSQL']) or die("Error SQL");
			rollback($UARTICULOS);

        break;		

    case "6":

////////GUARDO SESIONES PARA PDF////////////////
		$producto['sec'][1] = $CodOri[0]; 
		$producto['art'][1] = $CodOri[1]; 
		$producto['sec'][2] = $CodDes[0]; 
		$producto['art'][2] = $CodDes[1]; 
		
		$_SESSION['Producto'] = $producto; 			
/////////////////////////////////////////////////
	
	////	INSERTO EN AMOVSTOC	()
		$_SESSION['ParSQL'] = "
		INSERT INTO AMOVSTOC (SEC,ART,FEC,CYV,TIP,TCO,PVE,NCO,ORD,CAN,PUN,COD,DTO,IMI,PLA,LUG,ANU,TIM,OPE,IMI2)
		VALUES(".$CodOri[0].",".$CodOri[1].",getdate(),'V','B','".$tipo."',".$_SESSION['ParEMP'].",".$nco.",".$ord.",".$canDes.",".$cosDes.",".$ope.",1,0,".$PLA.",".$_SESSION['ParLUG'].",'','DR',".$ope.", 0 )";
		$AMOV2 = mssql_query($_SESSION['ParSQL']) or die("Error SQL");
		rollback($AMOV2);	
		
			$_SESSION['ParSQL'] = "SELECT EXIDEP FROM ARTICULOS WHERE CODSEC = ".$CodOri[0]." AND CodArt = ".$CodOri[1]."";
			$ARTICULOS = mssql_query($_SESSION['ParSQL']) or die("Error SQL");
			rollback($ARTICULOS);		
			while ($RART=mssql_fetch_array($ARTICULOS)){
				$exidep = $RART['EXIDEP'];
			}
			
			$stock2_ori = $exidep - $canDes;
			
			$_SESSION['ParSQL'] = "UPDATE ARTICULOS SET EXIDEP = ".$stock2_ori." WHERE CODSEC = ".$CodOri[0]." AND CodArt = ".$CodOri[1]."";
			$UARTICULOS = mssql_query($_SESSION['ParSQL']) or die("Error SQL");
			rollback($UARTICULOS);

        break;		

    case "7":

////////GUARDO SESIONES PARA PDF////////////////
		$producto['sec'][1] = $CodOri[0]; 
		$producto['art'][1] = $CodOri[1]; 
		$producto['sec'][2] = $CodDes[0]; 
		$producto['art'][2] = $CodDes[1]; 
		
		$_SESSION['Producto'] = $producto; 			
/////////////////////////////////////////////////
	
	////	INSERTO EN AMOVSTOC	()
		$_SESSION['ParSQL'] = "
		INSERT INTO AMOVSTOC (SEC,ART,FEC,CYV,TIP,TCO,PVE,NCO,ORD,CAN,PUN,COD,DTO,IMI,PLA,LUG,ANU,TIM,OPE,IMI2)
		VALUES(".$CodOri[0].",".$CodOri[1].",getdate(),'V','B','".$tipo."',".$_SESSION['ParEMP'].",".$nco.",".$ord.",".$canDes.",".$cosDes.",".$ope.",0,0,".$PLA.",".$_SESSION['ParLUG'].",'','VQ',".$ope.", 0 )";
		$AMOV2 = mssql_query($_SESSION['ParSQL']) or die("Error SQL");
		rollback($AMOV2);	
		
			$_SESSION['ParSQL'] = "SELECT EXIVTA FROM ARTICULOS WHERE CODSEC = ".$CodOri[0]." AND CodArt = ".$CodOri[1]."";
			$ARTICULOS = mssql_query($_SESSION['ParSQL']) or die("Error SQL");
			rollback($ARTICULOS);		
			while ($RART=mssql_fetch_array($ARTICULOS)){
				$exivta = $RART['EXIVTA'];
			}
			
			$stock2_ori = $exivta - $canDes;
			
			$_SESSION['ParSQL'] = "UPDATE ARTICULOS SET EXIVTA = ".$stock2_ori." WHERE CODSEC = ".$CodOri[0]." AND CodArt = ".$CodOri[1]."";
			$UARTICULOS = mssql_query($_SESSION['ParSQL']) or die("Error SQL");
			rollback($UARTICULOS);

        break;

    case "8":

////////GUARDO SESIONES PARA PDF////////////////
		$producto['sec'][1] = $CodOri[0]; 
		$producto['art'][1] = $CodOri[1]; 
		$producto['sec'][2] = $CodDes[0]; 
		$producto['art'][2] = $CodDes[1]; 
		
		$_SESSION['Producto'] = $producto; 			
/////////////////////////////////////////////////
	
	////	INSERTO EN AMOVSTOC	()
		$_SESSION['ParSQL'] = "
		INSERT INTO AMOVSTOC (SEC,ART,FEC,CYV,TIP,TCO,PVE,NCO,ORD,CAN,PUN,COD,DTO,IMI,PLA,LUG,ANU,TIM,OPE,IMI2)
		VALUES(".$CodOri[0].",".$CodOri[1].",getdate(),'V','B','".$tipo."',".$_SESSION['ParEMP'].",".$nco.",".$ord.",".$canDes.",".$cosDes.",".$ope.",1,0,".$PLA.",".$_SESSION['ParLUG'].",'','DQ',".$ope.", 0 )";
		$AMOV2 = mssql_query($_SESSION['ParSQL']) or die("Error SQL");
		rollback($AMOV2);	
		
			$_SESSION['ParSQL'] = "SELECT EXIDEP FROM ARTICULOS WHERE CODSEC = ".$CodOri[0]." AND CodArt = ".$CodOri[1]."";
			$ARTICULOS = mssql_query($_SESSION['ParSQL']) or die("Error SQL");
			rollback($ARTICULOS);		
			while ($RART=mssql_fetch_array($ARTICULOS)){
				$exidep = $RART['EXIDEP'];
			}
			
			$stock2_ori = $exidep - $canDes;
			
			$_SESSION['ParSQL'] = "UPDATE ARTICULOS SET EXIDEP = ".$stock2_ori." WHERE CODSEC = ".$CodOri[0]." AND CodArt = ".$CodOri[1]."";
			$UARTICULOS = mssql_query($_SESSION['ParSQL']) or die("Error SQL");
			rollback($UARTICULOS);

        break;

    case "9":

	$loc = $_REQUEST['local'];
	
////////GUARDO SESIONES PARA PDF////////////////
		$producto['sec'][1] = $CodOri[0]; 
		$producto['art'][1] = $CodOri[1]; 
		$producto['sec'][2] = $CodDes[0]; 
		$producto['art'][2] = $CodDes[1]; 
		
		$_SESSION['Producto'] = $producto; 			
/////////////////////////////////////////////////
	
	////	INSERTO EN AMOVSTOC	(LADO DERECHO - > C)
		$_SESSION['ParSQL'] = "
		INSERT INTO AMOVSTOC (SEC,ART,FEC,CYV,TIP,TCO,PVE,NCO,ORD,CAN,PUN,COD,DTO,IMI,PLA,LUG,ANU,TIM,OPE,IMI2,E_HD2)
		VALUES(".$CodDes[0].",".$CodDes[1].",getdate(),'V','B','".$tipo."',".$_SESSION['ParEMP'].",".$nco.",".$ord.",".$canDes.",".$cosDes.",".$loc.",0,0,".$PLA.",".$_SESSION['ParLUG'].",'','VO',".$ope.",0,0)";
		$AMOV2 = mssql_query($_SESSION['ParSQL']) or die("Error SQL");
		rollback($AMOV2);	
	
			$_SESSION['ParSQL'] = "SELECT EXIVTA FROM ARTICULOS WHERE CODSEC = ".$CodOri[0]." AND CodArt = ".$CodOri[1]."";
			$ARTICULOS = mssql_query($_SESSION['ParSQL']) or die("Error SQL");
			rollback($ARTICULOS);		
			while ($RART=mssql_fetch_array($ARTICULOS)){
				$exivta = $RART['EXIVTA'];
			}
			
			$stock2_ori = $exivta - $canDes;
			
			$_SESSION['ParSQL'] = "UPDATE ARTICULOS SET EXIVTA = ".$stock2_ori." WHERE CODSEC = ".$CodOri[0]." AND CodArt = ".$CodOri[1]."";
			$UARTICULOS = mssql_query($_SESSION['ParSQL']) or die("Error SQL");
			rollback($UARTICULOS);
	
        break;

    case "10":

	$loc = $_REQUEST['local'];
	
////////GUARDO SESIONES PARA PDF////////////////
		$producto['sec'][1] = $CodOri[0]; 
		$producto['art'][1] = $CodOri[1]; 
		$producto['sec'][2] = $CodDes[0]; 
		$producto['art'][2] = $CodDes[1]; 
		
		$_SESSION['Producto'] = $producto; 			
/////////////////////////////////////////////////
	
	////	INSERTO EN AMOVSTOC	(LADO DERECHO - > C)
		$_SESSION['ParSQL'] = "
		INSERT INTO AMOVSTOC (SEC,ART,FEC,CYV,TIP,TCO,PVE,NCO,ORD,CAN,PUN,COD,DTO,IMI,PLA,LUG,ANU,TIM,OPE,IMI2,E_HD2)
		VALUES(".$CodDes[0].",".$CodDes[1].",getdate(),'V','B','".$tipo."',".$_SESSION['ParEMP'].",".$nco.",".$ord.",".$canDes.",".$cosDes.",".$loc.",1,0,".$PLA.",".$_SESSION['ParLUG'].",'','DO',".$ope.",0,0)";
		$AMOV2 = mssql_query($_SESSION['ParSQL']) or die("Error SQL");
		rollback($AMOV2);	
	
			$_SESSION['ParSQL'] = "SELECT EXIDEP FROM ARTICULOS WHERE CODSEC = ".$CodOri[0]." AND CodArt = ".$CodOri[1]."";
			$ARTICULOS = mssql_query($_SESSION['ParSQL']) or die("Error SQL");
			rollback($ARTICULOS);		
			while ($RART=mssql_fetch_array($ARTICULOS)){
				$exidep = $RART['EXIDEP'];
			}
			
			$stock2_ori = $exidep - $canDes;
			
			$_SESSION['ParSQL'] = "UPDATE ARTICULOS SET EXIDEP = ".$stock2_ori." WHERE CODSEC = ".$CodOri[0]." AND CodArt = ".$CodOri[1]."";
			$UARTICULOS = mssql_query($_SESSION['ParSQL']) or die("Error SQL");
			rollback($UARTICULOS);
	
        break;

    case "12":

////////GUARDO SESIONES PARA PDF////////////////
		$producto['sec'][1] = $CodOri[0]; 
		$producto['art'][1] = $CodOri[1]; 
		$producto['sec'][2] = $CodDes[0]; 
		$producto['art'][2] = $CodDes[1]; 
		
		$_SESSION['Producto'] = $producto; 			
/////////////////////////////////////////////////
	
	////	INSERTO EN AMOVSTOC	()
		$_SESSION['ParSQL'] = "
		INSERT INTO AMOVSTOC (SEC,ART,FEC,CYV,TIP,TCO,PVE,NCO,ORD,CAN,PUN,COD,DTO,IMI,PLA,LUG,ANU,TIM,OPE,IMI2)
		VALUES(".$CodOri[0].",".$CodOri[1].",getdate(),'V','B','".$tipo."',".$_SESSION['ParEMP'].",".$nco.",".$ord.",".$canDes.",".$cosDes.",".$ope.",0,0,".$PLA.",".$_SESSION['ParLUG'].",'','AC',".$ope.", 0 )";
		$AMOV2 = mssql_query($_SESSION['ParSQL']) or die("Error SQL");
		rollback($AMOV2);	
		
			$_SESSION['ParSQL'] = "SELECT EXIVTA FROM ARTICULOS WHERE CODSEC = ".$CodOri[0]." AND CodArt = ".$CodOri[1]."";
			$ARTICULOS = mssql_query($_SESSION['ParSQL']) or die("Error SQL");
			rollback($ARTICULOS);		
			while ($RART=mssql_fetch_array($ARTICULOS)){
				$exivta = $RART['EXIVTA'];
			}
			
			$stock2_ori = $exivta - $canDes;
			
			$_SESSION['ParSQL'] = "UPDATE ARTICULOS SET EXIVTA = ".$stock2_ori." WHERE CODSEC = ".$CodOri[0]." AND CodArt = ".$CodOri[1]."";
			$UARTICULOS = mssql_query($_SESSION['ParSQL']) or die("Error SQL");
			rollback($UARTICULOS);

        break;
		
    case "13":
	
////////GUARDO SESIONES PARA PDF////////////////
		$producto['sec'][1] = $CodOri[0]; 
		$producto['art'][1] = $CodOri[1]; 
		$producto['sec'][2] = $CodDes[0]; 
		$producto['art'][2] = $CodDes[1]; 
		
		$_SESSION['Producto'] = $producto; 			
/////////////////////////////////////////////////
	
	////	INSERTO EN AMOVSTOC	(C)
		$_SESSION['ParSQL'] = "
		INSERT INTO AMOVSTOC (SEC,ART,FEC,CYV,TIP,TCO,PVE,NCO,ORD,CAN,PUN,COD,DTO,IMI,PLA,LUG,ANU,TIM,OPE,IMI2)
		VALUES(".$CodOri[0].",".$CodOri[1].",getdate(),'C','B','".$tipo."',".$_SESSION['ParEMP'].",".$nco.",".$ord.",".$canDes.",".$cosDes.",".$ope.",-1,0,".$PLA.",".$_SESSION['ParLUG'].",'','AV',".$ope.", 0 )";
		$AMOV2 = mssql_query($_SESSION['ParSQL']) or die("Error SQL");
		rollback($AMOV2);	
	
		
			$_SESSION['ParSQL'] = "SELECT EXIVTA FROM ARTICULOS WHERE CODSEC = ".$CodOri[0]." AND CodArt = ".$CodOri[1]."";
			$ARTICULOS = mssql_query($_SESSION['ParSQL']) or die("Error SQL");
			rollback($ARTICULOS);		
			while ($RART=mssql_fetch_array($ARTICULOS)){
				$exivta = $RART['EXIVTA'];
			}
			
			$stock2_ori = $exivta + $canDes;
			
			$_SESSION['ParSQL'] = "UPDATE ARTICULOS SET EXIVTA = ".$stock2_ori." WHERE CODSEC = ".$CodOri[0]." AND CodArt = ".$CodOri[1]."";
			$UARTICULOS = mssql_query($_SESSION['ParSQL']) or die("Error SQL");
			rollback($UARTICULOS);

        break;


    case "14":
////	INSERTO EN AMOVSTOC	(LADO IZQUIERDO - > V)
		$_SESSION['ParSQL'] = "
		INSERT INTO AMOVSTOC (SEC,ART,FEC,CYV,TIP,TCO,PVE,NCO,ORD,CAN,PUN,COD,DTO,IMI,PLA,LUG,ANU,TIM,OPE,IMI2)
		VALUES(".$CodOri[0].",".$CodOri[1].",getdate(),'V','B','".$tipo."',".$_SESSION['ParEMP'].",".$nco.",".$ord.",".$canDes.",".$cosDes.",".$ope.",1,0,".$PLA.",".$_SESSION['ParLUG'].",'','DV',".$ope.", 0 )";
		$AMOV1 = mssql_query($_SESSION['ParSQL']) or die("Error SQL");
		rollback($AMOV1);
	
	////	INSERTO EN AMOVSTOC	(LADO DERECHO - > C)
		$_SESSION['ParSQL'] = "
		INSERT INTO AMOVSTOC (SEC,ART,FEC,CYV,TIP,TCO,PVE,NCO,ORD,CAN,PUN,COD,DTO,IMI,PLA,LUG,ANU,TIM,OPE,IMI2)
		VALUES(".$CodDes[0].",".$CodDes[1].",getdate(),'C','B','".$tipo."',".$_SESSION['ParEMP'].",".$nco.",".$ord.",".$canDes.",".$cosDes.",".$ope.",0,0,".$PLA.",".$_SESSION['ParLUG'].",'','DV',".$ope.", 0 )";
		$AMOV2 = mssql_query($_SESSION['ParSQL']) or die("Error SQL");
		rollback($AMOV2);	
	
	
		if($co == $cd){					////	SI EL ORIGEN Y DESTINO SON IGUALES	
		////	ACTUALIZO ARTICULOS
		
			$_SESSION['ParSQL'] = "SELECT EXIDEP,EXIVTA FROM ARTICULOS WHERE CODSEC = ".$CodOri[0]." AND CodArt = ".$CodOri[1]."";
			$ARTICULOS = mssql_query($_SESSION['ParSQL']) or die("Error SQL");
			rollback($ARTICULOS);		
			while ($RART=mssql_fetch_array($ARTICULOS)){
				$exidep = $RART['EXIDEP'];
				$exivta = $RART['EXIVTA'];
			}
			
			$stock1_ori = $exidep - $canDes;
			$stock2_ori = $exivta + $canDes;
			
			$_SESSION['ParSQL'] = "UPDATE ARTICULOS SET EXIDEP = ".$stock1_ori.", EXIVTA = ".$stock2_ori." WHERE CODSEC = ".$CodOri[0]." AND CodArt = ".$CodOri[1]."";
			$UARTICULOS = mssql_query($_SESSION['ParSQL']) or die("Error SQL");
			rollback($UARTICULOS);
	
		
		}else{						////	SI EL ORIGEN Y DESTINO SON DISTINTOS
	
	////	ACTUALIZO ORIGEN (IZQUIERDA)		
			$_SESSION['ParSQL'] = "SELECT EXIDEP,EXIVTA FROM ARTICULOS WHERE CODSEC = ".$CodOri[0]." AND CodArt = ".$CodOri[1]."";
			$ARTICULOS = mssql_query($_SESSION['ParSQL']) or die("Error SQL");
			rollback($ARTICULOS);		
			while ($RART=mssql_fetch_array($ARTICULOS)){
				$exidep = $RART['EXIDEP'];
			}
			
			$stock1_ori = $exidep - $canDes;
			
			$_SESSION['ParSQL'] = "UPDATE ARTICULOS SET EXIDEP = ".$stock1_ori." WHERE CODSEC = ".$CodOri[0]." AND CodArt = ".$CodOri[1]."";
			$UARTICULOS = mssql_query($_SESSION['ParSQL']) or die("Error SQL");
			rollback($UARTICULOS);
			
	////	ACTUALIZO DESTINO (DERECHA)
			$_SESSION['ParSQL'] = "SELECT EXIDEP,EXIVTA FROM ARTICULOS WHERE CODSEC = ".$CodDes[0]." AND CodArt = ".$CodDes[1]."";
			$ARTICULOS = mssql_query($_SESSION['ParSQL']) or die("Error SQL");
			rollback($ARTICULOS);		
			while ($RART=mssql_fetch_array($ARTICULOS)){
				$exivta = $RART['EXIVTA'];
			}
			
			$stock2_des = $exivta + $canDes;
			
			$_SESSION['ParSQL'] = "UPDATE ARTICULOS SET EXIVTA = ".$stock2_des." WHERE CODSEC = ".$CodDes[0]." AND CodArt = ".$CodDes[1]."";
			$UARTICULOS = mssql_query($_SESSION['ParSQL']) or die("Error SQL");
			rollback($UARTICULOS);		
			
		}

        break;
		
		
    case "15":
////	INSERTO EN AMOVSTOC	(LADO IZQUIERDO - > V)
		$_SESSION['ParSQL'] = "
		INSERT INTO AMOVSTOC (SEC,ART,FEC,CYV,TIP,TCO,PVE,NCO,ORD,CAN,PUN,COD,DTO,IMI,PLA,LUG,ANU,TIM,OPE,IMI2)
		VALUES(".$CodOri[0].",".$CodOri[1].",getdate(),'V','B','".$tipo."',".$_SESSION['ParEMP'].",".$nco.",".$ord.",".$canDes.",".$cosDes.",".$ope.",0,0,".$PLA.",".$_SESSION['ParLUG'].",'','VV',".$ope.", 0 )";
		$AMOV1 = mssql_query($_SESSION['ParSQL']) or die("Error SQL");
		rollback($AMOV1);
	
	////	INSERTO EN AMOVSTOC	(LADO DERECHO - > C)
		$_SESSION['ParSQL'] = "
		INSERT INTO AMOVSTOC (SEC,ART,FEC,CYV,TIP,TCO,PVE,NCO,ORD,CAN,PUN,COD,DTO,IMI,PLA,LUG,ANU,TIM,OPE,IMI2)
		VALUES(".$CodDes[0].",".$CodDes[1].",getdate(),'C','B','".$tipo."',".$_SESSION['ParEMP'].",".$nco.",".$ord.",".$canDes.",".$cosDes.",".$ope.",0,0,".$PLA.",".$_SESSION['ParLUG'].",'','VV',".$ope.", 0 )";
		$AMOV2 = mssql_query($_SESSION['ParSQL']) or die("Error SQL");
		rollback($AMOV2);	
	
	
		if($co == $cd){					////	SI EL ORIGEN Y DESTINO SON IGUALES	
		////	ACTUALIZO ARTICULOS
		
			$_SESSION['ParSQL'] = "SELECT EXIDEP,EXIVTA FROM ARTICULOS WHERE CODSEC = ".$CodOri[0]." AND CodArt = ".$CodOri[1]."";
			$ARTICULOS = mssql_query($_SESSION['ParSQL']) or die("Error SQL");
			rollback($ARTICULOS);		
			while ($RART=mssql_fetch_array($ARTICULOS)){
				$exidep = $RART['EXIDEP'];
				$exivta = $RART['EXIVTA'];
			}
			
			$stock1_ori = $exidep - $canDes;
			$stock2_ori = $exivta + $canDes;
			
			$_SESSION['ParSQL'] = "UPDATE ARTICULOS SET EXIDEP = ".$stock1_ori.", EXIVTA = ".$stock2_ori." WHERE CODSEC = ".$CodOri[0]." AND CodArt = ".$CodOri[1]."";
			$UARTICULOS = mssql_query($_SESSION['ParSQL']) or die("Error SQL");
			rollback($UARTICULOS);
	
		
		}else{						////	SI EL ORIGEN Y DESTINO SON DISTINTOS
	
	////	ACTUALIZO ORIGEN (IZQUIERDA)		
			$_SESSION['ParSQL'] = "SELECT EXIDEP,EXIVTA FROM ARTICULOS WHERE CODSEC = ".$CodOri[0]." AND CodArt = ".$CodOri[1]."";
			$ARTICULOS = mssql_query($_SESSION['ParSQL']) or die("Error SQL");
			rollback($ARTICULOS);		
			while ($RART=mssql_fetch_array($ARTICULOS)){
				$exidep = $RART['EXIDEP'];
			}
			
			$stock1_ori = $exidep - $canDes;
			
			$_SESSION['ParSQL'] = "UPDATE ARTICULOS SET EXIDEP = ".$stock1_ori." WHERE CODSEC = ".$CodOri[0]." AND CodArt = ".$CodOri[1]."";
			$UARTICULOS = mssql_query($_SESSION['ParSQL']) or die("Error SQL");
			rollback($UARTICULOS);
			
	////	ACTUALIZO DESTINO (DERECHA)
			$_SESSION['ParSQL'] = "SELECT EXIDEP,EXIVTA FROM ARTICULOS WHERE CODSEC = ".$CodDes[0]." AND CodArt = ".$CodDes[1]."";
			$ARTICULOS = mssql_query($_SESSION['ParSQL']) or die("Error SQL");
			rollback($ARTICULOS);		
			while ($RART=mssql_fetch_array($ARTICULOS)){
				$exivta = $RART['EXIVTA'];
			}
			
			$stock2_des = $exivta + $canDes;
			
			$_SESSION['ParSQL'] = "UPDATE ARTICULOS SET EXIVTA = ".$stock2_des." WHERE CODSEC = ".$CodDes[0]." AND CodArt = ".$CodDes[1]."";
			$UARTICULOS = mssql_query($_SESSION['ParSQL']) or die("Error SQL");
			rollback($UARTICULOS);		
			
		}

        break;


    case "16":

	$loc = $_REQUEST['local'];
	$numnota = $_REQUEST['numnota'];
	
////////GUARDO SESIONES PARA PDF////////////////
		$producto['sec'][1] = $CodOri[0]; 
		$producto['art'][1] = $CodOri[1]; 
		$producto['sec'][2] = $CodDes[0]; 
		$producto['art'][2] = $CodDes[1]; 
		
		$_SESSION['Producto'] = $producto; 			
/////////////////////////////////////////////////
	
	////	INSERTO EN AMOVSTOC	(LADO DERECHO - > C)
		$_SESSION['ParSQL'] = "
		INSERT INTO AMOVSTOC (SEC,ART,FEC,CYV,TIP,TCO,PVE,NCO,ORD,CAN,PUN,COD,DTO,IMI,PLA,LUG,ANU,TIM,OPE,IMI2,E_HD2)
		VALUES(".$CodDes[0].",".$CodDes[1].",getdate(),'C','B','".$tipo."',".$_SESSION['ParEMP'].",".$nco.",".$ord.",".$canDes.",".$cosDes.",".$loc.",0,0,".$PLA.",".$_SESSION['ParLUG'].",'','OV',".$ope.",0,".$numnota.")";
		$AMOV2 = mssql_query($_SESSION['ParSQL']) or die("Error SQL");
		rollback($AMOV2);	
	
		if($co == $cd){					////	SI EL ORIGEN Y DESTINO SON IGUALES	
		////	ACTUALIZO ARTICULOS
		
			$_SESSION['ParSQL'] = "SELECT EXIDEP,EXIVTA FROM ARTICULOS WHERE CODSEC = ".$CodOri[0]." AND CodArt = ".$CodOri[1]."";
			$ARTICULOS = mssql_query($_SESSION['ParSQL']) or die("Error SQL");
			rollback($ARTICULOS);		
			while ($RART=mssql_fetch_array($ARTICULOS)){
				$exivta = $RART['EXIVTA'];
			}
			
			$stock2_ori = $exivta + $canDes;
			
			$_SESSION['ParSQL'] = "UPDATE ARTICULOS SET EXIVTA = ".$stock2_ori." WHERE CODSEC = ".$CodOri[0]." AND CodArt = ".$CodOri[1]."";
			$UARTICULOS = mssql_query($_SESSION['ParSQL']) or die("Error SQL");
			rollback($UARTICULOS);
	
		
		}else{						////	SI EL ORIGEN Y DESTINO SON DISTINTOS
	
	////	ACTUALIZO ORIGEN (IZQUIERDA)		
			$_SESSION['ParSQL'] = "SELECT EXIDEP,EXIVTA FROM ARTICULOS WHERE CODSEC = ".$CodOri[0]." AND CodArt = ".$CodOri[1]."";
			$ARTICULOS = mssql_query($_SESSION['ParSQL']) or die("Error SQL");
			rollback($ARTICULOS);		
			while ($RART=mssql_fetch_array($ARTICULOS)){
				$exivta = $RART['EXIVTA'];
			}
			
			$stock1_ori = $exivta + $canDes;
			
			$_SESSION['ParSQL'] = "UPDATE ARTICULOS SET EXIVTA = ".$stock1_ori." WHERE CODSEC = ".$CodOri[0]." AND CodArt = ".$CodOri[1]."";
			$UARTICULOS = mssql_query($_SESSION['ParSQL']) or die("Error SQL");
			rollback($UARTICULOS);
			
	////	ACTUALIZO DESTINO (DERECHA)
			$_SESSION['ParSQL'] = "SELECT EXIDEP,EXIVTA FROM ARTICULOS WHERE CODSEC = ".$CodDes[0]." AND CodArt = ".$CodDes[1]."";
			$ARTICULOS = mssql_query($_SESSION['ParSQL']) or die("Error SQL");
			rollback($ARTICULOS);		
			while ($RART=mssql_fetch_array($ARTICULOS)){
				$exivta = $RART['EXIVTA'];
			}
			
			$stock2_des = $exivta + $canDes;
			
			$_SESSION['ParSQL'] = "UPDATE ARTICULOS SET EXIVTA = ".$stock2_des." WHERE CODSEC = ".$CodDes[0]." AND CodArt = ".$CodDes[1]."";
			$UARTICULOS = mssql_query($_SESSION['ParSQL']) or die("Error SQL");
			rollback($UARTICULOS);		
			
		}

	
        break;

    case "17":

	$loc = $_REQUEST['local'];
	$numnota = $_REQUEST['numnota'];
	
	
////////GUARDO SESIONES PARA PDF////////////////
		$producto['sec'][1] = $CodOri[0]; 
		$producto['art'][1] = $CodOri[1]; 
		$producto['sec'][2] = $CodDes[0]; 
		$producto['art'][2] = $CodDes[1]; 
		
		$_SESSION['Producto'] = $producto; 			
/////////////////////////////////////////////////
	
	////	INSERTO EN AMOVSTOC	(LADO DERECHO - > C)
		$_SESSION['ParSQL'] = "
		INSERT INTO AMOVSTOC (SEC,ART,FEC,CYV,TIP,TCO,PVE,NCO,ORD,CAN,PUN,COD,DTO,IMI,PLA,LUG,ANU,TIM,OPE,IMI2,E_HD2)
		VALUES(".$CodDes[0].",".$CodDes[1].",getdate(),'C','B','".$tipo."',".$_SESSION['ParEMP'].",".$nco.",".$ord.",".$canDes.",".$cosDes.",".$loc.",0,0,".$PLA.",".$_SESSION['ParLUG'].",'','OD',".$ope.",0,".$numnota.")";
		$AMOV2 = mssql_query($_SESSION['ParSQL']) or die("Error SQL");
		rollback($AMOV2);	
	
		$_SESSION['ParSQL'] = "SELECT EXIDEP,EXIVTA FROM ARTICULOS WHERE CODSEC = ".$CodDes[0]." AND CodArt = ".$CodDes[1]."";
		$ARTICULOS = mssql_query($_SESSION['ParSQL']) or die("Error SQL");
		rollback($ARTICULOS);		
		while ($RART=mssql_fetch_array($ARTICULOS)){
			$exidep = $RART['EXIDEP'];
			$exivta = $RART['EXIVTA'];
		}
		
		$stock2_des = $exivta + $canDes;
		
		$_SESSION['ParSQL'] = "UPDATE ARTICULOS SET EXIVTA = ".$stock2_des." WHERE CODSEC = ".$CodDes[0]." AND CodArt = ".$CodDes[1]."";
		$UARTICULOS = mssql_query($_SESSION['ParSQL']) or die("Error SQL");
		rollback($UARTICULOS);
	
        break;

	}
	
	$_SESSION['ParSQL'] = "UPDATE ANUMFACT SET NUM = ".$nco." WHERE TCO = '".$tipo."' AND SUC = ".$_SESSION['ParEMP']." AND TIP = 'B' AND IPM = 'M'";
	$UARTICULOS = mssql_query($_SESSION['ParSQL']) or die("Error SQL");
	rollback($UARTICULOS);

	?>
	<script>
		$('#Bloquear').fadeOut(500);
	</script>
	<?
	
}


//////////////////////////////////////////////////////////////
/////////////////// 	NOTA DE ALTA	  ////////////////////
///////////////////   DEPOSITO ->VENTAS	  ////////////////////
//////////////////////////////////////////////////////////////

if(isset($_REQUEST['traven'])){

	if($_REQUEST['traven'] == 1){
		$sec = $_REQUEST['sec'];
		$art = $_REQUEST['art'];
		$codrub = $_REQUEST['codrub'];
	
		$ban = 0;
		/* Aqui sacas la informacion de la session */
		for($i = 1 ; $i <= $_SESSION['Articulos_Total'] ; $i++){
			$objeto = $_SESSION['Articulos'][$i];
		
			if(($objeto['sec'][$i] == $sec) && ($objeto['art'][$i] == $art)){
				
				?>
                <script>
                	document.getElementById("CanArt").value = <? echo $objeto['can'][$i]; ?>;
				</script>
                <?
				$ban = 1;
			}
		}
		
		if($ban != 1){
			?>
			<script>
				jAlert('El Artículo seleccionado no esta incluido en el comprobante de Compra.', 'Debo Retail - Global Business Solution');

				document.getElementById("Sector").value = "";
				document.getElementById("Producto").value = "";
				document.getElementById("Detalle").value = "";
				document.getElementById("Stock").value = "";
				document.getElementById("StockAct").value = "";
				document.getElementById("SectorD").value = "";
				document.getElementById("ProductoD").value = "";
				document.getElementById("DetalleD").value = "";
				document.getElementById("CostoD").value = "";
				document.getElementById("CantidadD").value = "";
				document.getElementById("StockD").value = "";
				
				Ir_a("Sector",4,1);

				$("div").css("border-color", "transparent");
				$("#SectorDiv").css("border-color", "#F90");
				
				document.getElementById('LetEnt').innerHTML = '<button onclick="BuscaOrigen(1);" class="StyBoton" onmouseout="MM_swapImgRestore()" onmouseover="MM_swapImage(\'LetEntTomInv3\',\'\',\'botones/ent-over.png\',0)"><img src="botones/ent-up.png" name="Enter" title="Enter" border="0" id="LetEntTomInv3"/></button>';

				document.getElementById('NumVol').innerHTML = '<button onclick="VolOperacion();" class="StyBoton" onmouseout="MM_swapImgRestore()" onmouseover="MM_swapImage(\'LetVolTomInv0\',\'\',\'botones/vol-over.png\',0)"><img src="botones/vol-up.png" name="Volver" title="Volver" border="0" id="LetVolTomInv0"/></button>';	

				
			</script>
			<?	
			exit;
		}
		$ban = 0;
	}
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