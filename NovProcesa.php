<?
require("config/cnx.php");

try {////////////////////////////////////////////////////////////////////////////////////////////////// COMIENZO TRY //

mssql_query("begin transaction",$conexion) or die("Error SQL begin trans");

if(isset($_REQUEST['ideli']) ){
	$id = $_REQUEST['ideli'];
	$pla = $_REQUEST['plaeli'];

	$_SESSION['ParSQL'] = "DELETE NOVEDADES WHERE PLA =".$pla." AND ID=".$id.""; 
	$R1TB = mssql_query($_SESSION['ParSQL']) or die("Error SQL");
	rollback($R1TB);
		
	?>
	<script>
		jAlert('La Novedad ha sido eliminada.', 'Debo Retail - Global Business Solution');
		
		$("#Novedades").load("Novedades.php");
		$("#Novedades").fadeIn(500);

	</script>
	<?		

}else{
	
	exit();	
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