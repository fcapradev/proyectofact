<?
require("config/cnx.php");


try {////////////////////////////////////////////////////////////////////////////////////////////////// COMIENZO TRY //


mssql_query("begin transaction",$conexion) or die("Error SQL begin trans");


//REQUEST
$id = $_REQUEST['id'];
$elid = $_REQUEST['elid'];
$TOT = $_REQUEST['tot'];

	$CPARBON = mssql_query("SELECT [COT] FROM CPARBON WHERE ID = $id") or die("Error SQL");
	while ($RCPAR = mssql_fetch_array($CPARBON)){
	
		$NTOT = $TOT * $RCPAR['COT'];
		$NTOT = dec($NTOT,2);
	  
	}
	mssql_free_result($CPARBON);

?>
<script>
	document.getElementById("<?=$elid?>").value = "<?=$NTOT?>";
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