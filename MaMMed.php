<?
require("config/cnx.php");


try {////////////////////////////////////////////////////////////////////////////////////////////////// COMIENZO TRY //


mssql_query("begin transaction",$conexion) or die("Error SQL begin trans");


?>

<style>

#MaMediosdepagoBarra{
	position:absolute; 
	left:-2px; 
	top:-4px;
}

#MaTarjetasEnFacturador{
	position:absolute; 
	display:none;
	left:-97px; 
	top:16px;
}

#MaChequesEnFacturador{
	position:absolute; 
	display:none;
	left:-109px; 
	top:5px;
}

</style>

<script>

function cEscForPago(){

	alert("falta");

}

function Mameddepagos(Mam){
	
	var Mamedimp2 = document.getElementById("Matotal").value;
	
	if(Mam == 1){
		
		var Mamedtarmin = document.getElementById("MaMedCatMinTar").value;	
		if(parseFloat(Mamedimp2) < parseFloat(Mamedtarmin)){
			
			jAlert('Debe ingresar un importe menor o igual al total, y mayor que el minimo.', 'Aukon - Global Business Solution');
			
		}else{
			
			SoloNone("MaChequesEnFacturador");
			SoloBlock("MaTarjetasEnFacturador");
			
			EnvAyuda("Ingrese el n&uacute;mero de Tarjeta o Enter para Listar.");
			
			$("#MaTarjetasEnFacturador").load("TarAgr.php?se=c");
			
		}
		
	}
	
	if(Mam == 2){
		
		var Mamedchemin = document.getElementById("MaMedCatMinChe").value;	
		if(parseFloat(Mamedimp2) < parseFloat(Mamedchemin)){
			
			jAlert('Debe ingresar un importe menor o igual al total, y mayor que el minimo.', 'Aukon - Global Business Solution');
			
		}else{
					
			SoloNone("MaTarjetasEnFacturador");
			SoloBlock("MaChequesEnFacturador");
			$("#MaChequesEnFacturador").load("Cheques.php?se=c");
			
			SoloBlock('LetEnt, LetSal');
			SoloNone('LetTer');
			
			EnvAyuda("Ingrese el n&uacute;mero del Banco o Enter para listar.");
			
		}
		
	}
		
}

</script>
<?

$MinTar = 1;

$_SESSION['ParSQL'] = "SELECT MINTSH, MINCSH FROM APARSIS";
$APARSIS = mssql_query($_SESSION['ParSQL']) or die("Error SQL");
rollback($APARSIS);
while ($APA_R = mssql_fetch_array($APARSIS)){
	$MinTar = $APA_R['MINTSH'];
	$MinChe = $APA_R['MINCSH'];
}
mssql_free_result($APARSIS);

?>
<div id="toda_la_busMP">

    <input type="hidden" id="MaMedCatMinTar" name="MaMedCatMinTar" value="<? echo $MinTar; ?>" />
    <input type="hidden" id="MaMedCatMinChe" name="MaMedCatMinChe" value="<? echo $MinChe; ?>" />

    <div id="MaMediosdepagoBarra">
    
    <table width="108">
        <tr>
        <td>
        <img src="MPago/fon.png" />
        </td>
        </tr>
        <tr>
        <td>
        <div align="center">
        <button class="StyBoton" onclick="Mameddepagos(1);" onMouseOut="MM_swapImgRestore()" onMouseOver="MM_swapImage('TarFacturador','','PanPrin/tar-over.png',0)">
        <img src="PanPrin/tar-up.png" border="0" id="TarFacturador"/></button>
        </div>
        </td>
        </tr>
        <tr>
        <td>
        <div align="center">
        <button class="StyBoton" onclick="Mameddepagos(2);" onMouseOut="MM_swapImgRestore()" onMouseOver="MM_swapImage('CheFacturador','','PanPrin/che-over.png',0)">
        <img src="PanPrin/che-up.png" border="0" id="CheFacturador"/></button>
        </div>
        </td>
        </tr>
    </table>
    
    </div>
        
    <div id="MaTarjetasEnFacturador"></div>
    
    <div id="MaChequesEnFacturador"></div>

</div>


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