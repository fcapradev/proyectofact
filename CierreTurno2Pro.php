<?
require("config/cnx.php");

try {////////////////////////////////////////////////////////////////////////////////////////////////// COMIENZO TRY //

mssql_query("begin transaction",$conexion) or die("Error SQL begin trans");

if(isset($_REQUEST['ban'])){

	$ban = $_REQUEST['ban'];

}else{

	exit();

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

if($ban == 2){

	//ACTUALIZO TODA LA TMAEFACT PARA PODER IMPRIMIR

	$_SESSION['ParSQL'] = "UPDATE TMAEFACT SET DC1='' WHERE PLA = ".$PLA.""; 
	$R1TB = mssql_query($_SESSION['ParSQL']) or die("Error SQL");
	rollback($R1TB);


	?>
    <script>

        $("#CierreTurno2").load("CierreTurno2.php");

    </script>
    <?
}


if($ban == 1){
	
	//AUTORIZA
	?>
    <script>
//		alert("entra");
		SoloBlock("fondotranspletras, TecladoLet, fondotranspnumeros, TecladoNum, CierreTurno, LetSal");
		SoloNone("CierreTurno2");

		$("#CierreTurno").load("CierreTurno.php");
		
		EnvAyuda('Selecione la caja a cerrar.');

		document.getElementById('LetSal').innerHTML = '<button class="StyBoton" onclick="salir_ae();" onmouseout="MM_swapImgRestore()" onmouseover="MM_swapImage(\'LetSalCierre2\',\'\',\'botones/sal-over.png\',0)"><img src="botones/sal-up.png" name="Salir" title="Salir" border="0" id="LetSalCierre2"/></button>';
		
		document.getElementById('LetEnt').innerHTML = '<button class="StyBoton" onclick="enviar_ct();" onmouseout="MM_swapImgRestore()" onmouseover="MM_swapImage(\'LetCerCierre2\',\'\',\'botones/cer-over.png\',0)"><img src="botones/cer-up.png" name="Cerrar" title="Cerrar" border="0" id="LetCerCierre2"/></button>';
		
		document.getElementById('LetTer').innerHTML = '<button class="StyBoton" onclick="salir_ae();" onmouseout="MM_swapImgRestore()" onmouseover="MM_swapImage(\'LetCan\',\'\',\'botones/can-over.png\',0)"><img src="botones/can-up.png" name="Cancelar" title="Cancelar" border="0" id="LetCan"/></button>';
		
		document.getElementById('NumVol').innerHTML = '<button class="StyBoton" onclick="salir_ae();" onmouseout="MM_swapImgRestore()" onmouseover="MM_swapImage(\'NumVolCierre2\',\'\',\'botones/vol-over.png\',0)"><img src="botones/vol-up.png" name="Volver" title="Volver" border="0" id="NumVolCierre2"/></button>';


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