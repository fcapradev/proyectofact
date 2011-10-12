<?
require("../config/cnx.php");

try {////////////////////////////////////////////////////////////////////////////////////////////////// COMIENZO TRY //

mssql_query("begin transaction",$conexion) or die("Error SQL begin trans");

//SESSION - REQUEST
if(isset($_POST['det'])){
	$SEC = $_POST['sec'];
	$ART = $_POST['art'];
	$DET = $_POST['det'];

$COD = format($SEC,2,'0',STR_PAD_LEFT)."-".format($ART,4,'0',STR_PAD_LEFT);
/////////////////////////////////////////////////////////////////////////

$_SESSION['ParSQL'] = "SELECT MAX(bot)+1 AS PROX FROM ACONF_TR WHERE COD <> '' AND POS = ".$_SESSION['ParPOS']."";
$R1TB = mssql_query($_SESSION['ParSQL']) or die("Error SQL");
rollback($R1TB);
		
while ($REG = mssql_fetch_array($R1TB)){
	$PROX = $REG['PROX'];
}

$_SESSION['ParSQL'] = "INSERT INTO ACONF_TR (POS,BOT,COD,DT1,DT2) VALUES (".$_SESSION['ParPOS'].",".$PROX.",'".$COD."','".$DET."','')";
$R1TB = mssql_query($_SESSION['ParSQL']) or die("Error SQL");
rollback($R1TB);

?>
<script>
	AccBotFac(4);
	jAlert('El articulo <? echo $DET; ?> ha sido agregado a Teclas Rapidas.', 'Debo Retail - Global Business Solution');
</script>

<?
}


//SESSION - REQUEST
if(isset($_REQUEST['cod'])){
	$COD = $_REQUEST['cod'];
/////////////////////////////////////////////////////////////////////////

	$_SESSION['ParSQL'] = "DELETE ACONF_TR WHERE COD = ".$COD." AND POS = ".$_SESSION['ParPOS']."";

		$f = fopen('../Log/ELog.log','a+');
		fwrite($f,"".date('Y-m-d h:i:s')." | ".$_SESSION['ParSQL']." \r\n");
		fclose($f);

	$R1TB = mssql_query($_SESSION['ParSQL']) or die("Error SQL");
	rollback($R1TB);
	
	?>
	<script>
		AccBotFac(4);
		jAlert('El articulo ha sido elimando a Teclas Rapidas.', 'Debo Retail - Global Business Solution');
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