<?
require("config/cnx.php");

try {////////////////////////////////////////////////////////////////////////////////////////////////// COMIENZO TRY //

mssql_query("begin transaction",$conexion) or die("Error SQL begin trans");

if(isset($_REQUEST['nco'])){

	$t = $_REQUEST['tip'];
	$c = $_REQUEST['tco'];
	$s = $_REQUEST['suc'];
	$n = $_REQUEST['nco'];

	}else{
		exit();
}

	//MARCA COMO ANULADA
	$_SESSION['ParSQL'] = "UPDATE  AMAEFACT SET ANU='A' WHERE TIP='".$t."' AND TCO='".$c."' AND SUC=".$s." AND NCO=".$n.""; 
	$R1TB = mssql_query($_SESSION['ParSQL']) or die("Error SQL");
	rollback($R1TB);		
	
	
	
	//BORRA LOS CUPONES SI SE ENCUENTRAN LA FORMA DE PAGO COMO 4 -- TARJETA DE CREDITO.
	$_SESSION['ParSQL'] = "SELECT PLA,NCO,FPA FROM  AMAEFACT WHERE TIP='".$t."' AND TCO='".$c."' AND SUC=".$s." AND NCO=".$n.""; 
	$R1TB = mssql_query($_SESSION['ParSQL']) or die("Error SQL");
	rollback($R1TB);		
	while ($R1=mssql_fetch_array($R1TB)){
		
         If ($R1['FPA'] == 4){
			$_SESSION['ParSQL'] = "DELETE ACUPONES WHERE PLA=".$R1['PLA']." AND SUBSTRING(NFA,6,8) = '" & dec($R1['NCO'], 8) & "'"; 
			$R1DEL = mssql_query($_SESSION['ParSQL']) or die("Error SQL");
			rollback($R1DEL);	 	
		 }
		
	}
	//ANULA ACOBYPAG
	$_SESSION['ParSQL'] = "UPDATE  ACOBYPAG SET ANU='A' WHERE TIP='".$t."' AND TCO='".$c."' AND SUC=".$s." AND NCO=".$n.""; 
	$R1TB = mssql_query($_SESSION['ParSQL']) or die("Error SQL");
	rollback($R1TB);		


	//ANULA AMOVSTOC
	$_SESSION['ParSQL'] = "UPDATE  AMOVSTOC SET ANU='A' WHERE CYV='V' AND TIP='".$t."' AND TCO='".$c."' AND PVE=".$s." AND NCO=".$n.""; 
	$R1TB = mssql_query($_SESSION['ParSQL']) or die("Error SQL");
	rollback($R1TB);	

	//ANULA AMOVSTOC
	$_SESSION['ParSQL'] = "UPDATE  AMOVTURN SET ANU='A' WHERE CYV='V' AND TIP='".$t."' AND TCO='".$c."' AND PVE=".$s." AND NCO=".$n.""; 
	$R1TB = mssql_query($_SESSION['ParSQL']) or die("Error SQL");
	rollback($R1TB);	
?>



<script>
	$("#TicketEM").load("TicketEM.php?ban=1");
</script>


<?

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