<?
require("config/cnx.php");

try {////////////////////////////////////////////////////////////////////////////////////////////////// COMIENZO TRY //

mssql_query("begin transaction",$conexion) or die("Error SQL begin trans");


if(isset($_POST['tipo'])){

	$tipo = $_POST['idtipo'];
	$desc = $_POST['iddesc'];
	$obs = $_POST['obs'];
	
}else{
	exit;
}

$_SESSION['ParSQL'] = "
	SELECT C.NplVen AS PLA FROM ATURNOSH AS A 
	INNER JOIN APARPOS AS B ON B.ID = '".$_SESSION['ParPOS']."'
	INNER JOIN VENDEDORES AS C ON C.CodVen = B.OPE
	INNER JOIN ATURNOSO AS D ON D.PLA = C.NplVen
	WHERE A.MTN = D.MTN
	";
	
	$registros = mssql_query($_SESSION['ParSQL']) or die("Error SQL");
	rollback($registros);		
	
	if(mssql_num_rows($registros)==0){
		exit;
	}
	while ($reg=mssql_fetch_array($registros)){
	
		$PLA = $reg['PLA'];
		
	}

$OPE = $_SESSION['idsusua'];

function numeroID($p){
	$_SESSION['ParSQL'] = "SELECT isnull(MAX(ID)+1,1) AS ID FROM NOVEDADES WHERE PLA=".$p.""; 
	$R1TB = mssql_query($_SESSION['ParSQL']) or die("Error SQL");
	rollback($R1TB);
	while ($R1=mssql_fetch_array($R1TB)){
    	return $R1['ID'];
	}
}

//////////////////RELLENO DE CEROS LOS NUMEROS////////////////

//$tipo = str_pad($tipo, 2, "0", STR_PAD_LEFT);
//$desc = str_pad($desc, 2, "0", STR_PAD_LEFT);

	$id = numeroID($PLA);

	$_SESSION['ParSQL'] = "INSERT INTO NOVEDADES (ID, PLA, OPE, TIPO, [DESC], OBS) VALUES (".$id.",".$PLA.",".$OPE.",".$tipo.",".$desc.",'".$obs."')"; 
	$R1TB = mssql_query($_SESSION['ParSQL']) or die("Error SQL");
	rollback($R1TB);		



?>

<script>
	jAlert('Novedad Cargada.', 'Debo Retail - Global Business Solution');
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
