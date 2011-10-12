el<?
require("config/cnx.php");
try {////////////////////////////////////////////////////////////////////////////////////////////////// COMIENZO TRY //
mssql_query("begin transaction",$conexion) or die("Error SQL begin trans");

if(isset($_REQUEST['inv'])){
	$num_inv = $_REQUEST['inv'];
///////		MARCA EL INV COMO FALLIDO
	$_SESSION['ParSQL'] = "UPDATE INV_PALM_REA SET dato_1=0, INV_REA = 1 WHERE NUM_INV =".$num_inv."";
	$INV_PALM_REA = mssql_query($_SESSION['ParSQL']) or die("Error SQL");
	rollback($INV_PALM_REA);			
	$_SESSION['ParSQL'] = "UPDATE ITOMINVC SET EST = 'F' WHERE ID = ".$num_inv."";
	$ITOMINVC = mssql_query($_SESSION['ParSQL']) or die("Error SQL");
	rollback($ITOMINVC);
}

///////		INSERTA EN INV_PALM_REA SI NO EXISTE INVENTARIO
if(isset($_REQUEST['iinv'])){
	$num_iinv = $_REQUEST['iinv'];
	$Fecha_iInv = $_REQUEST['Fecha_iInv'];

	$_SESSION['ParSQL'] = "SELECT * FROM INV_PALM_REA WHERE NUM_INV = ".$num_iinv."";
	echo $_SESSION['ParSQL'];
	$inv_palm_rea = mssql_query($_SESSION['ParSQL']) or die("Error SQL");
	rollback($inv_palm_rea);
	if(mssql_num_rows($inv_palm_rea)==0){
		$_SESSION['ParSQL'] = "INSERT INV_PALM_REA (NUM_INV,FEC_INV,INV_REA) VALUES (".$num_iinv.",'".$Fecha_iInv."',0)";
		$IINV_PALM_REA = mssql_query($_SESSION['ParSQL']) or die("Error SQL");
		echo "Inserta: ".$_SESSION['ParSQL'];
		rollback($IINV_PALM_REA);
		$ban = 1;
	}
}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>PROCESAR VARIABLES DE CARGA DE INVENTARIOS</title>
</head>

<body>
</body>



</html>

<?
mssql_query("commit transaction") or die("Error SQL commit");

}catch(Exception $e){/////////////////////////////////////////////////// FIN DE TRY //

	?>
	<script>
		jAlert('ERROR Reintente la operacion solicitada.', 'Debo Retail - Global Business Solution');
	</script>
	<?

exit;
}

?>