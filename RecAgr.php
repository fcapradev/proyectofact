<?
require("config/cnx.php");


try {////////////////////////////////////////////////////////////////////////////////////////////////// COMIENZO TRY //


mssql_query("begin transaction",$conexion) or die("Error SQL begin trans");


if(isset($_REQUEST['imp'])){

	$imp_0 = $_REQUEST['imp'];
	$hora = date("H:i");
	$FEC = date("Ymd H:i");
	
	$_SESSION['ParSQL'] = "
	SELECT C.NplVen AS PLA, D.FAP AS FAP, A.MTN, A.DES, A.INI, A.FIN FROM ATURNOSH AS A 
	INNER JOIN APARPOS AS B ON B.ID = '".$_SESSION['ParPOS']."'
	INNER JOIN VENDEDORES AS C ON C.CodVen = B.OPE
	INNER JOIN ATURNOSO AS D ON D.PLA = C.NplVen
	WHERE A.MTN = D.MTN
	";
	
	$registros = mssql_query($_SESSION['ParSQL']) or die("Error SQL");
	rollback($registros);		
	
	if(mssql_num_rows($registros)==0){ exit; }
	
	while ($reg=mssql_fetch_array($registros)){
		$PLA = $reg['PLA'];
	}
	
	$NOM = $_SESSION['idsusun'];
	$OPE = $_SESSION['idsusua'];
	$LUG = $_SESSION['ParLUG'];
		
	$imp_0 = str_replace(",",".",$imp_0);	
	
	$_SESSION['ParSQL'] = "SELECT PLA, LUG, FEC, HORA, OPE_R FROM CONTEO_PLANILLA WHERE PLA = ".$PLA." AND LUG = ".$LUG." AND FEC = '".$FEC."' AND OPE_R = ".$OPE;
	$RSBTABLA = mssql_query($_SESSION['ParSQL']) or die("Error SQL");
	rollback($RSBTABLA);
	if(mssql_num_rows($RSBTABLA)==0){

		//////////////////CONTROLAR QUE NO SE HAYA CARGADO ANTERIORMENTE /////////////////	
		$_SESSION['ParSQL'] = "INSERT INTO conteo_planilla (pla,lug,fec,hora,ope_r,imp_0) 
		VALUES (".$PLA.",".$LUG.",'".$FEC."','".$hora."',".$OPE.",".$imp_0.")";
		$RSBTABLA = mssql_query($_SESSION['ParSQL']) or die("Error SQL");
		rollback($RSBTABLA);
		
		?>
		<script>
			jAlert('Importe cargado correctamente.', 'Debo Retail - Global Business Solution');
			$("#Recuento").load("Recuento.php");
			controlrecuento = 0;
		</script>
		<?
		
		$hora = "";
		$FEC = "";
		
	}else{
		
		?>
		<script>
			jAlert('No puede ingresar otro recuento, intente dentro de unos minutos.', 'Debo Retail - Global Business Solution');
			$("#Recuento").load("Recuento.php");
			controlrecuento = 0;
		</script>
		<?
		
	}
}


mssql_query("commit transaction") or die("Error SQL commit");


}catch(Exception $e){////////////////////////////////////////////////////////////////////////////////////////////////// FIN DE TRY //
	
	?>
	<script>
		jAlert('ERROR Reintente la operacion solicitada.', 'Debo Retail - Global Business Solution');
		controlrecuento = 0;
	</script>
	<?
exit;

}

?>