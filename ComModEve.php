<?
require("config/cnx.php");
/////////////////////////////// COMPRAS


try {////////////////////////////////////////////////////////////////////////////////////////////////// COMIENZO TRY //


mssql_query("begin transaction",$conexion) or die("Error SQL begin trans");


//$_POST
if(isset($_POST['Eventual1'])){
	
	$Eventual1 = $_POST['Eventual1'];
	$Eventual2 = $_POST['Eventual2'];
	$Eventual3 = $_POST['Eventual3'];
	$Eventual4 = $_POST['Eventual4'];
	$Eventual6 = $_POST['Eventual6'];


	$_SESSION['ParSQL'] = "SELECT COD FROM PROVEED WHERE COD = 0";
	$PROVEED = mssql_query($_SESSION['ParSQL']) or die("Error SQL");
	rollback($PROVEED);
	
	if(mssql_num_rows($PROVEED)==0){
		
		$_SESSION['ParSQL'] = "
		INSERT INTO PROVEED (COD, NOM, CON, DOM, CUIT, FPA, IVA) 
		VALUES (0, '".$Eventual1."', '".$Eventual1."', '".$Eventual2."', '".$Eventual3."', ".$Eventual4.", ".$Eventual6.")";
		$INSERT_PROVEED = mssql_query($_SESSION['ParSQL']) or die("Error SQL");
		rollback($INSERT_PROVEED);
	
	}else{
		
		$_SESSION['ParSQL'] = "
		UPDATE PROVEED SET 
			NOM = '".$Eventual1."',
			DOM = '".$Eventual2."',
			CUIT = '".$Eventual3."',
			FPA = ".$Eventual4.",
			IVA = ".$Eventual6."
		WHERE COD = 0
		";
		
		$UPDATE_PROVEED = mssql_query($_SESSION['ParSQL']) or die("Error SQL");
		rollback($UPDATE_PROVEED);

	}


mssql_query("commit transaction") or die("Error SQL commit");

	?>
	<script>
		document.getElementById('LetEnt').innerHTML = '<button class="StyBoton" onclick="ProEveNom();" onmouseout="MM_swapImgRestore()" onmouseover="MM_swapImage(\'LetEntFac\',\'\',\'botones/ent-over.png\',0)"><img src="botones/ent-up.png" name="Enter" title="Enter" border="0" id="LetEntFac"/></button>';
			
		IncProvee(0, '<? echo $Eventual1; ?>',<? echo $Eventual4; ?>);
	
		$('#Bloquear').fadeOut(500);
	</script>
	<?
	
}else{
	
	mssql_query("commit transaction") or die("Error SQL commit");
	
}

}catch(Exception $e){////////////////////////////////////////////////////////////////////////////////////////////////// FIN DE TRY //
	
	?>
	<script>
		jAlert('ERROR Reintente la operacion solicitada.', 'Debo Retail - Global Business Solution');
	</script>
	<?
exit;

}
?>