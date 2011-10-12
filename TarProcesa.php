<?
require("config/cnx.php");

try {////////////////////////////////////////////////////////////////////////////////////////////////// COMIENZO TRY //

mssql_query("begin transaction",$conexion) or die("Error SQL begin trans");

///////////////////////////////////////////////////////
////// PARA MODIFICAR O ELIMINAR UNA TARJETA //////////
///////////////////////////////////////////////////////

if(isset($_POST['ban'])){		////	PARA MODIFICAR UNA TARJETA
	
		$TAR = $_POST['TAR'];
		$NCU = $_POST['NCU'];
		$NLO = $_POST['NLO'];
		$SUC = $_POST['SUC'];
		$IMP = $_POST['importe_mod'];
	
		$_SESSION['ParSQL'] = "UPDATE ACUPONES SET IMP = ".$IMP." WHERE TAR = ".$TAR." AND NCU = ".$NCU." AND NLO = ".$NLO." AND SUC = ".$SUC."";
		$registros = mssql_query($_SESSION['ParSQL']) or die("Error SQL");
		rollback($registros);		
	
		?>
		<script>
			jAlert('La Tarjeta ha sido modificada.', 'Debo Retail - Global Business Solution');
		</script>
		<?
}else{		////	ELIMINA UNA TARJETA

	$TAR = $_REQUEST['tar'];
	$NCU = $_REQUEST['ncu'];
	$NLO = $_REQUEST['nlo'];
	
	$_SESSION['ParSQL'] = "DELETE ACUPONES WHERE TAR = ".$TAR." AND NCU = ".$NCU." AND NLO = ".$NLO."";
	$registros = mssql_query($_SESSION['ParSQL']) or die("Error SQL");
	rollback($registros);		

	?>
	<script>
		jAlert('La Tarjeta ha sido eliminada.', 'Debo Retail - Global Business Solution');
		
		$("#Tarjetas").load("Tarjetas.php");		
		$('#Tarjetas').fadeIn(500);
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