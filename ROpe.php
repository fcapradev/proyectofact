<?
require("config/cnx.php");


try {////////////////////////////////////////////////////////////////////////////////////////////////// COMIENZO TRY //


mssql_query("begin transaction",$conexion) or die("Error SQL begin trans");


//REQUEST
$CodOpe = trim($_POST['CodOpe']);
$ConOpe = trim($_POST['ConOpe']);

/****************************************************************************************************************/

$_SESSION['ParSQL'] = "SELECT CODVEN FROM VENDEDORES WHERE CODVEN = ".$CodOpe." AND CLAVEN = '".$ConOpe."'";
$RevOpeCon = mssql_query($_SESSION['ParSQL']) or die("Error SQL");
rollback($RevOpeCon);
if(mssql_num_rows($RevOpeCon)==0){

?>
<script>
	EntradaConVol();
	jAlert('El codigo de operario o la contraseña es incorrecta.', 'Debo Retail - Global Business Solution');
</script>
<?

exit;

}

/****************************************************************************************************************/

$_SESSION['ParSQL'] = "SELECT EST, NomVen FROM VENDEDORES WHERE CodVen = ".$CodOpe." AND ClaVen = '".$ConOpe."'";
$RevOpe = mssql_query($_SESSION['ParSQL']) or die("Error SQL");
rollback($RevOpe);
while ($Ope=mssql_fetch_array($RevOpe)){
	$EST = $Ope['EST'];
	$NOM = $Ope['NomVen'];
}

if($EST == 1){

?>
<script>
	EntradaConVol();
	jAlert('El operario no se encuentra habilitado.', 'Debo Retail - Global Business Solution');
</script>
<?

exit;

}

/****************************************************************************************************************/

$_SESSION['ParSQL'] = "
SELECT C.NplVen AS PLA, A.MTN FROM ATURNOSH AS A 
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
	$MTN = $reg['MTN'];
}

$_SESSION['ParSQL'] = "SELECT CODVEN FROM Ope_Pla WHERE CODVEN = ".$CodOpe." AND NplVen = ".$PLA."";
$RevOpePla = mssql_query($_SESSION['ParSQL']) or die("Error SQL");
rollback($RevOpePla);
if(mssql_num_rows($RevOpePla)>=1){

?>
<script>
	EntradaConVol();
	jAlert('El operario ya se encuentra habilitado en la planilla: <? echo $PLA; ?>.', 'Debo Retail - Global Business Solution');
</script>
<?

exit;

}

$fecha = date("d/m/Y");
$hora = date("H:i:s");

?>
<script>

document.getElementById('FechOpe').innerHTML = "<? echo $fecha; ?>";
document.getElementById('TurnOpe').innerHTML = "<? echo $MTN; ?>";
document.getElementById('CajaOpe').innerHTML = "<? echo $PLA; ?>";
document.getElementById('HoraOpe').innerHTML = "<? echo $hora; ?>";

SoloBlock('LetTer');

</script>
<?

if(isset($_POST['insert'])){
	if($_POST['insert'] == 1){

		$LUG = $_SESSION['ParLUG'];		
		$_SESSION['ParSQL'] = "INSERT INTO Ope_Pla (CodVen, NomVen, LugVen, Fecha, Hora, NplVen) VALUES (".$CodOpe.",'".$NOM."',".$LUG.",'".$fecha."','".$hora."', ".$PLA.")";
		$RevOpePla = mssql_query($_SESSION['ParSQL']) or die("Error SQL");
		rollback($RevOpePla);
		
		?>
		<script>
			EntradaConVol();
			jAlert('El operario <? echo $CodOpe; ?> se habilito correctamente en la planilla: <? echo $PLA; ?>.', 'Debo Retail - Global Business Solution');
		</script>
		<?
	
	}
}


mssql_query("commit transaction") or die("Error SQL commit");
	
	
}catch(Exception $e){////////////////////////////////////////////////////////////////////////////////////////////////// FIN DE TRY //
	
	?>
	<script>
		VolverOpe();
		jAlert('ERROR Reintente la operacion solicitada.', 'Debo Retail - Global Business Solution');
	</script>
	<?
exit;

}
?>