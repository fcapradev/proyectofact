<?
require("config/cnx.php");

try {////////////////////////////////////////////////////////////////////////////////////////////////// COMIENZO TRY //

mssql_query("begin transaction",$conexion) or die("Error SQL begin trans");

////////////////////////////////////////////////
///////////////   BUSCA OPERARIO   /////////////
if(isset($_REQUEST['bus'])){
	$OPE = $_REQUEST['ope'];

	$_SESSION['ParSQL'] = "SELECT NomVen FROM VENDEDORES WHERE CodVen=".$OPE."";
	$RSBTABLA = mssql_query($_SESSION['ParSQL']) or die("Error SQL");
	rollback($RSBTABLA);
	
	if(mssql_num_rows($RSBTABLA) == 0){
		?>
			<script>
				jAlert('El Operario Ingresado no existe', 'Debo Retail - Global Business Solution');
				document.getElementById("inp_vale").value = "";
			</script>
		<?
	}else{
		?>
			<script>
				$("#impDiv").css("border-color", "#F90");
				$("#valDiv").css("border-color", "transparent");
			
				EnvAyuda("Ingrese el Importe");
				
				document.getElementById("DondeE").value = "inp_importe";
				document.getElementById("CantiE").value = "8";
				document.getElementById("QuePoE").value = "1";
				
				document.getElementById('LetSal').innerHTML = '<button class="StyBoton" onclick="salir_ret();" onmouseout="MM_swapImgRestore()" onmouseover="MM_swapImage(\'LetSalRetEfe4\',\'\',\'botones/sal-over.png\',0)"><img src="botones/sal-up.png" name="Volver" title="Volver" border="0" id="LetSalRetEfe4"/></button>';
				
				document.getElementById('LetEnt').innerHTML = '<button id="BotLetEntFac" onclick="Ingresa_Det();" class="StyBoton" onmouseout="MM_swapImgRestore()" onmouseover="MM_swapImage(\'LetEntFac\',\'\',\'botones/ent-over.png\',0)"><img src="botones/ent-up.png" name="Enter" title="Enter" border="0" id="LetEntFac"/></button>';
				
				document.getElementById('NumVol').innerHTML = '<button id="LetVolRet" onclick="Vol_Vale();" class="StyBoton" onmouseout="MM_swapImgRestore()" onmouseover="MM_swapImage(\'LetVolRet\',\'\',\'botones/vol-over.png\',0)"><img src="botones/vol-up.png" name="Volver" title="Volver" border="0" id="LetVolRet"/></button>';			
			</script>
		<?		
		
	}
	
	exit();
}


////////////////////////////////////////////////
////////////////////////////////////////////////



if(isset($_POST['fe'])){

	$f = 1;

	if(isset($_POST['retiro'])){
		$RET = $_POST['retiro'];
	}else{
		$RET = "";
	}

	if(isset($_POST['obsret'])){
		$OBS_RET = $_POST['obsret'];
	}else{
		$OBS_RET = "";
	}
	
	if(isset($_POST['obsant'])){
		$OBS_ANT = $_POST['obsant'];
	}else{
		$OBS_ANT = "";
	}

	if(isset($_POST['inp_vale'])){
		$USR_VALE = $_POST['inp_vale'];
	}else{
		$USR_VALE = "";
	}
	
	if(isset($_POST['inp_importe'])){
		$IMP_VALE = $_POST['inp_importe'];
	}else{
		$IMP_VALE = "";
	}

	if(isset($_POST['tipo'])){
		$tipo = $_POST['tipo'];
	}else{
		$tipo = "";
	}

}

if(isset($_REQUEST['f'])){
	$f=$_REQUEST['f'];
	if($f == 2){
		$p = $_REQUEST['p'];
		$n = $_REQUEST['n'];		
	}
	if($f == 3){
		$p = $_REQUEST['p'];
		$n = $_REQUEST['n'];		
	}
	if($f == 4){
		$p = $_REQUEST['p'];
		$n = $_REQUEST['n'];		
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
	
	
function imprimeRP($p,$n){

	$fila = 40;
	for ($i=0;$i <= $fila ;$i++){
		$imLin[$i]="NO";
	}
	
	$TOT = 0;
	$_SESSION['ParSQL'] = "SELECT * FROM ATURRPA WHERE PLA =".$p." AND NUM=".$n.""; 
	$R1TB = mssql_query($_SESSION['ParSQL']) or die("Error SQL");
	rollback($R1TB);
	while ($RB1=mssql_fetch_array($R1TB)){
		
		$imLIN[0] = "RETIRO DE EFECTIVO  ".format($RB1['NUM'],5,'0',STR_PAD_LEFT);
      	$imLIN[1] = str_repeat("-", 40);
      	$imLIN[2] = "Nro PLANILLA : ".trim($RB1['PLA'])."";
      	$imLIN[3] = "Nro OPERARIO : ".format($RB1['OPE'],5,'0',STR_PAD_LEFT).", ".buscar_nombre_operario($RB1['OPE']);
      	$imLIN[4] = str_repeat("-", 40);
      	$nLin = 4 + 1;	
	
		if ($RB1['EFE'] > 0){
	    	$imLIN[$nLin] = str_repeat(" ", 5)."EFECTIVO.....: ".str_repeat(" ",15 - strlen(dec($RB1['EFE'], 2))).dec($RB1['EFE'], 2)."";
         	$TOT = $RB1['EFE'];
         	$nLin = $nLin + 1;		
		}

		if ($RB1['GAS'] > 0){
	    	$imLIN[$nLin] = str_repeat(" ", 5)."GASTOS.......: ".str_repeat(" ",15 - strlen(dec($RB1['GAS'], 2))).dec($RB1['GAS'], 2)."";
         	$TOT = $RB1['GAS'];
         	$nLin = $nLin + 1;		
		}	 
		if ($RB1['ANT'] > 0){
	    	$imLIN[$nLin] = str_repeat(" ", 5)."ANTICIPOS....: ".str_repeat(" ",15 - strlen(dec($RB1['ANT'], 2))).dec($RB1['ANT'], 2)."";
         	$TOT = $RB1['ANT'];
         	$nLin = $nLin + 1;		
		}	
		if ($RB1['TAR'] > 0){
	    	$imLIN[$nLin] = str_repeat(" ", 5)."TARJETAS.....: ".str_repeat(" ",15 - strlen(dec($RB1['TAR'], 2))).dec($RB1['TAR'], 2)."";
         	$TOT = $RB1['TAR'];
         	$nLin = $nLin + 1;		
		}
		if ($RB1['CHE'] > 0){
	    	$imLIN[$nLin] = str_repeat(" ", 5)."CHEQUES......: ".str_repeat(" ",15 - strlen(dec($RB1['CHE'], 2))).dec($RB1['CHE'], 2)."";
         	$TOT = $RB1['CHE'];
         	$nLin = $nLin + 1;		
		}	
		
		if (trim($RB1['OBS_RETIRO']) <> ""){
         $imLIN[$nLin] = str_repeat("-", 40);
         $nLin = $nLin + 1;
         $imLIN[$nLin] = "OBSERVA RET.: ".trim($RB1['OBS_RETIRO'])."";
		 $nLin = $nLin + 1;
		}

		if (trim($RB1['OBS_ANTICIPO']) <> ""){
         $imLIN[$nLin] = str_repeat("-", 40);
         $nLin = $nLin + 1;
         $imLIN[$nLin] = "OBSERVA ANT.: ".trim($RB1['OBS_ANTICIPO'])."";
		 $nLin = $nLin + 1;
		}
		
		if($RB1['ANU'] = True) {
			$Anu="SI";
		}else{
			$Anu="NO";
		}
		$imLIN[$nLin] = str_repeat(" ", 5)."ANULADA......: ".$Anu;
		$nLin = $nLin + 1;
		$imLIN[$nLin] = str_repeat("-", 40);
        $nLin = $nLin + 1;		
		$imLIN[$nLin] = str_repeat(" ", 5)."TOTAL........: ".str_repeat(" ",15 - strlen(dec($TOT, 2))).dec($TOT, 2)."";
        $nLin = $nLin + 1;	
		$imLIN[$nLin] = str_repeat(" ", 40);	
		$nLin = $nLin + 1;	
      	$imLIN[$nLin] = "FIRMA:".str_repeat(" ", 5).str_repeat("_", 28);
		$nLin = $nLin + 1;	
		$imLIN[$nLin] = str_repeat(" ", 40);	
		$nLin = $nLin + 1;				
      	$imLIN[$nLin] = "ACLARACION:".str_repeat("_", 28);

	}
	
	//TOMAR EL DEL SESSION PARPV
	$_SESSION['ParSQL'] = "DELETE RTURCIEO WHERE ID =".$_SESSION['ParPV'].""; 
	$R1TB1 = mssql_query($_SESSION['ParSQL']) or die("Error SQL");
	rollback($R1TB1);		
	
	for ($i=0;$i <= $nLin;$i++){
		if ($imLIN[$i] != "NO"){

			$_SESSION['ParSQL'] = "INSERT RTURCIEO (ID,TEX,ORD) VALUES(".$_SESSION['ParPV'].",'".$imLIN[$i]."',".$i.")"; 
			$R1TB = mssql_query($_SESSION['ParSQL']) or die("Error SQL");
			rollback($R1TB);		
			
		}
	}	
	
	$TOT=0;
?>
	<script>
		jAlert('Impresi&oacute;n Realizada.', 'Debo Retail - Global Business Solution');
	</script>  
<?
}




switch($f){

	case 1:
	
		$TAR=0;
		$CHE=0;
		$REF1=0;
		$REF2=0;
		$REF3=0;
		$REF4=0;
		$REF5=0;
		$LUG=0;
		$GAS=0;
		
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
		
			$pla_ver = $reg['PLA'];
			
		}
		
	//BUSCAR EL NUMERO DE LA PROXIMA RENDICION --> TIENE QUE HACERLO AL INGRESAR Y AL CONFIRMAR
		$_SESSION['ParSQL'] = "SELECT isnull(MAX(NUM) + 1,1) AS NCO FROM ATURRPA WHERE PLA=".$pla_ver.""; 
		$R1TB = mssql_query($_SESSION['ParSQL']) or die("Error SQL");
		rollback($R1TB);
		while ($RB1=mssql_fetch_array($R1TB)){
			$nco_var = $RB1['NCO'];
		}
			
		//INSERTAR UNO NUEVO
		if($tipo == 1){
			
			$_SESSION['ParSQL'] = "INSERT INTO ATURRPA (PLA,NUM,OPE,FEC,EFE,GAS,ANT,TAR,CHE,REF1,REF2,REF3,REF4,REF5,LUG,OBS_RETIRO,OBS_ANTICIPO) VALUES (".$pla_ver.", ".$nco_var.", '".$_SESSION['idsusua']."', '".date("Ymd H:i:s")."',".$RET.",".$GAS.",0,".$TAR.",".$CHE.",".$REF1.",".$REF2.",".$REF3.",".$REF4.",".$REF5.",".$_SESSION['ParLUG'].",'".$OBS_RET."','".$OBS_ANT."')"; 
		
		$R1TB = mssql_query($_SESSION['ParSQL']) or die("Error SQL");
		rollback($R1TB);		
	
	
		?>
			<script>
				jAlert('Retiro Agregado Correctamente', 'Debo Retail - Global Business Solution');
			</script>  
		<?
		$p = "";
		$c = "";
		
	
		}else{
			
			$_SESSION['ParSQL'] = "INSERT INTO ATURRPA (PLA,NUM,OPE,FEC,EFE,GAS,ANT,TAR,CHE,REF1,REF2,REF3,REF4,REF5,LUG,OBS_RETIRO,OBS_ANTICIPO) VALUES (".$pla_ver.", ".$nco_var.", '".$USR_VALE."', '".date("Ymd H:i:s")."',0,".$GAS.",".$IMP_VALE.",".$TAR.",".$CHE.",".$REF1.",".$REF2.",".$REF3.",".$REF4.",".$REF5.",".$_SESSION['ParLUG'].",'Vale realizado por: ".$_SESSION['idsusua']."','".$OBS_ANT."')"; 		
	
		$R1TB = mssql_query($_SESSION['ParSQL']) or die("Error SQL");
		rollback($R1TB);		
	
	
		?>
			<script>
				jAlert('Vale Agregado Correctamente', 'Debo Retail - Global Business Solution');
			</script>  
		<?
		$p = "";
		$c = "";
			
		}
		
		
		/*
		$p = $_SESSION['idsusua'];
		$n = $_SESSION['idsusun'];
		imprimeRP($p,$n);
		*/
		
		
		break;
	
	
	case 2:
		
		if(isset($_REQUEST['ban'])){
			$BAN = $_REQUEST['ban'];
		}else{
			$BAN = 1;
		}
		//TIENE QUE RECIBIR LA PLANILLA Y EL NUMERO DE RENDICION PARCIAL O RETIRO DE CAJA
		$_SESSION['ParSQL'] = "UPDATE ATURRPA SET ANU = 1  WHERE PLA =".$p." AND NUM=".$n.""; 
		$R1TB = mssql_query($_SESSION['ParSQL']) or die("Error SQL");
		rollback($R1TB);		
		
		if($BAN == 1){
			?>
			<script>
				$("#RetiroEfectivo").load("RetEfe.php?ban=1");
			</script>
			<?
		}else{
			?>
			<script>
				$("#RetiroEfectivo").load("RetEfe.php?ban=2");
			</script>
			<?
		}
		
		break;
	
	case 3:
	?>
		<script>
			jAlert('<? echo $p;echo $n; ?>','Consulta');
		</script>  
	
	<?
	
	
	break;
	
	case 4:
	
	imprimeRP($p,$n);
	
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