<?
require("config/cnx.php");

try {////////////////////////////////////////////////////////////////////////////////////////////////// COMIENZO TRY //

mssql_query("begin transaction",$conexion) or die("Error SQL begin trans");


	$codven = $_POST['codven'];
	$nombre = $_POST['nombre'];
	$clavev = $_POST['clavev'];
	$claven = $_POST['claven'];
	$clavenr = $_POST['clavenr'];


/*
         La longitud de la Clave debe ser mínimo de cuatro dígitos
         La Clave ingresada es igual a la Anterior (campo CLAVEN guarda contraseña anterior)
         La Clave Ingresada no es Válida, Intente Otra (por que otro usuario tiene la clave)
         La Clave es Igual al Nombre
         Caractér Ya ingresado en Clave (no se pueden ingresar 2 caracteres iguales)
*/


// para verificar que otro usuario tiene la clave que se esta ingresando
  
$_SESSION['ParSQL'] = "SELECT CodVen FROM VENDEDORES WHERE ClaVen='".$claven."'";
$RSBTABLA = mssql_query($_SESSION['ParSQL']) or die("Error SQL");
rollback($RSBTABLA);
if (mssql_num_rows($RSBTABLA) > 0){
	$bandera1 = 0;
	?>

	<script>
		jAlert('Ingrese otra clave por favor', 'Debo Retail - Global Business Solution');

		$("#CoIdPe").load("CoIdPe.php");
		SoloBlock("CoIdPe");

		
		
	</script>

	<?
}else{
	$bandera1 = 1;  
}

if( $bandera1 == 1){

	//update de la clave nueva
	$_SESSION['ParSQL'] = "UPDATE VENDEDORES SET ClaVen='".$claven."',CLAANT='".$clavev."' WHERE CodVen=".$codven."";
	$RSBTABLA = mssql_query($_SESSION['ParSQL']) or die("Error SQL");
	rollback($RSBTABLA);
	
	?>
	<script>
		jAlert('Su nueva contrase'+'\u00f1'+'a ha sido generada.', 'Debo Retail - Global Business Solution');
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

?>