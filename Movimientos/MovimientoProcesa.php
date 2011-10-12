<?
require("../config/cnx.php");
try {////////////////////////////////////////// COMIENZO TRY //
mssql_query("begin transaction",$conexion) or die("Error SQL begin trans");




if(isset($_REQUEST['tipo'])){
	$tipo = $_REQUEST['tipo'];
	
	$TCO = $_REQUEST['tco'];
	$PVE = $_REQUEST['pve'];
	$NCO = $_REQUEST['nco'];
	$PLA = $_REQUEST['pla'];

	if($tipo == 1){

//////////////////////////////////////////////////////////////
////////////////////////	ANULA	  ////////////////////////
//////////////////////////////////////////////////////////////

		$_SESSION['ParSQL'] = "UPDATE AMOVSTOC SET ANU = 'A' WHERE PLA = ".$PLA." AND PVE = ".$PVE." AND NCO = ".$NCO." AND TCO = '".$TCO."'";
		$UPDATEAMO = mssql_query($_SESSION['ParSQL']) or die("Error SQL");
		rollback($UPDATEAMO);		

		?>
		<script>
			jAlert('La Nota ha sido Anulada.', 'Debo Retail - Global Business Solution');	
			naynb();
		</script>
	    <?

	}else{

//////////////////////////////////////////////////////////////
/////////////////// 	IMPRIMIR NA y NB	  ////////////////
//////////////////////////////////////////////////////////////
		
		?>
		<script>
			jAlert('No Disponible.', 'Debo Retail - Global Business Solution');	
			naynb();
		</script>
	    <?
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