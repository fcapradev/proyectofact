<?
require("config/cnx.php");

try {////////////////////////////////////////////////////////////////////////////////////////////////// COMIENZO TRY //

mssql_query("begin transaction",$conexion) or die("Error SQL begin trans");

if(isset($_REQUEST['psw'])){

	$usr = $_REQUEST['usr'];
	$psw = $_REQUEST['psw'];
	
	////	BUSCA EL SUPERVISOR
	$_SESSION['ParSQL'] = "SELECT ClaVen, CodVen, ESENC FROM VENDEDORES WHERE CodVen=".$usr." AND ClaVen = '".$psw."' "; 
	$R1TB = mssql_query($_SESSION['ParSQL']) or die("Error SQL");
	rollback($R1TB);		

	if(mssql_num_rows($R1TB) == 1){
		while ($R3 = mssql_fetch_array($R1TB)){
			$ESENC = $R3['ESENC'];
		}
		if($ESENC == 1){
			?>
			<script>
				document.getElementById('LetSal').innerHTML = "";
				document.getElementById('LetEnt').innerHTML = "";
				SoloBlock("TicketGeneral");
				SoloNone("identificacion, fondotranspletras, TecladoLet, fondotranspnumeros, TecladoNum, LetSal, LetEnt, CarAyudaFon, CarAyuda");
			</script>	
			<?
		}else{
			?>
			<script>
				document.getElementById("psw").value = "";
				jAlert('El usuario no está autorizado.', 'Debo Retail - Global Business Solution');			
			</script>	
			<?	
		}
	}else{
		?>
		<script>
		
			document.getElementById("psw").value = "";
			jAlert('Ingrese correctamente su contraseña.', 'Debo Retail - Global Business Solution');			
		
		</script>	
            
		<?	
	}
	

}else{
	exit();
}



//mssql_query("commit transaction") or die("Error SQL commit");

}catch(Exception $e){////////////////////////////////////////////////////////////////////////////////////////////////// FIN DE TRY //
	
?>
<script>
	jAlert('ERROR Reintente la operacion solicitada.', 'Debo Retail - Global Business Solution');
</script>
<?

exit;

}

?>