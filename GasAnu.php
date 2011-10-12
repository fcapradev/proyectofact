<?
require("config/cnx.php");
try {////////////////////////////////////////////////////////////////////////////////////////////////// COMIENZO TRY //
mssql_query("begin transaction",$conexion) or die("Error SQL begin trans");

if(isset($_REQUEST['f'])){

	$f = $_REQUEST['f'];

	if($f == 2){
		$p = $_REQUEST['p'];
		$n = $_REQUEST['n'];		
	}
	}else{
		exit();
}

?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Anular un Gasto</title>
</head>

<body>

<?
if( $f == 2){

$_SESSION['ParSQL'] = "UPDATE PMAEFACT SET ANU = 'A'  WHERE PLA =".$p." AND NCO=".$n.""; 
$R1TB = mssql_query($_SESSION['ParSQL']) or die("Error SQL");
rollback($R1TB);		
?>
<script>
	$("#Gastos").load("Gastos.php");
</script>
<?

}


?>

</body>
</html>
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
