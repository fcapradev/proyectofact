<?
require("config/cnx.php");


try {////////////////////////////////////////////////////////////////////////////////////////////////// COMIENZO TRY //


mssql_query("begin transaction",$conexion) or die("Error SQL begin trans");


if(isset($_REQUEST['p'])){

	$PLA = $_REQUEST['p'];
	$BCO = $_REQUEST['b'];
	$NUM = $_REQUEST['n'];
	$CON = $_REQUEST['c'];	

	$LUG = $_SESSION['ParLUG'];
	$OPE = $_SESSION['idsusua'];
	$NOM = $_SESSION['idsusun'];

}else{
	exit;
}

if($CON == 1){

	$_SESSION['ParSQL'] = "DELETE FROM TVALOR WHERE PLA = ".$PLA." AND BCO = ".$BCO." AND NUM = ".$NUM; 
	$R1TB = mssql_query($_SESSION['ParSQL']) or die("Error SQL");
	rollback($R1TB);
	
	?>
	<script>
		jAlert('El cheque ha sido eliminado del sistema.', 'Debo Retail - Global Business Solution');
		$("#ChequesCar").load("ChequesCar.php");
	</script>
	<?
	
}else{

	?>
	<script>
		jAlert('Imposible eliminar el cheque, intente en otro momento.', 'Debo Retail - Global Business Solution');
	</script>
	<?

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