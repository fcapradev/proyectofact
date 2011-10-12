<?
require("config/cnx.php");


try {////////////////////////////////////////////////////////////////////////////////////////////////// COMIENZO TRY //


mssql_query("begin transaction",$conexion) or die("Error SQL begin trans");


?>

<style>

#MediosdepagoBarra{
	position:absolute; 
	left:-2px; 
	top:-4px;
}

#TarjetasEnFacturador{
	position:absolute; 
	display:none;
	left:-97px; 
	top:16px;
}

#ChequesEnFacturador{
	position:absolute; 
	display:none;
	left:-109px; 
	top:5px;
}

</style>

<script>

function meddepagos(m){
	
	var medimp2 = document.getElementById("total").value;

	if(m == 1){
		
		var medtarmin = document.getElementById("MedCatMinTar").value;		
		if(parseFloat(medimp2) < parseFloat(medtarmin)){
			
			jAlert('Debe ingresar un importe menor o igual al total, y mayor que el minimo.', 'Aukon - Global Business Solution');
			
		}else{
			
			SoloNone("ChequesEnFacturador");
			SoloBlock("TarjetasEnFacturador");

			$("#TarjetasEnFacturador").load("TarAgr.php?se=b");

		}
		
	}
	
	if(m == 2){
		
		var medchemin = document.getElementById("MedCatMinChe").value;
		if(parseFloat(medimp2) < parseFloat(medchemin)){
			
			jAlert('Debe ingresar un importe menor o igual al total, y mayor que el minimo.', 'Aukon - Global Business Solution');
			
		}else{
	
			SoloNone("TarjetasEnFacturador");
			SoloBlock("ChequesEnFacturador");
			
			$("#ChequesEnFacturador").load("Cheques.php?se=b");
	
			SoloBlock('LetEnt, NumVol, LetSal');
			SoloNone('LetTer');
			
		}
		
	}
		
}

</script>
<?

$MinTar = 1;
$MinChe = 1;

$_SESSION['ParSQL'] = "SELECT MINTSH, MINCSH FROM APARSIS";
$APARSIS = mssql_query($_SESSION['ParSQL']) or die("Error SQL");
rollback($APARSIS);
while($APA_R = mssql_fetch_array($APARSIS)){
	$MinTar = $APA_R['MINTSH'];
	$MinChe = $APA_R['MINCSH'];
}
mssql_free_result($APARSIS);

?>
<div id="toda_la_busMP">

    <input type="hidden" id="MedCatMinTar" name="MedCatMinTar" value="<? echo $MinTar; ?>" />
    <input type="hidden" id="MedCatMinChe" name="MedCatMinChe" value="<? echo $MinChe; ?>" />

    <div id="MediosdepagoBarra">    
    <table width="108">
        <tr>
        <td>
        <img src="MPago/fon.png" />
        </td>
        </tr>
        <tr>
        <td>
        <div align="center">
            <button class="StyBoton" onclick="meddepagos(1);" onMouseOut="MM_swapImgRestore()" onMouseOver="MM_swapImage('TarFacturador','','PanPrin/tar-over.png',0)">
            <img src="PanPrin/tar-up.png" border="0" id="TarFacturador"/></button>
        </div>    
        </td>
        </tr>
        <tr>
        <td>
        <div align="center">
            <button class="StyBoton" onclick="meddepagos(2);" onMouseOut="MM_swapImgRestore()" onMouseOver="MM_swapImage('CheFacturador','','PanPrin/che-over.png',0)">
            <img src="PanPrin/che-up.png" border="0" id="CheFacturador"/></button>
        </div>    
        </td>
        </tr>
    </table>
    </div>
        
    <div id="TarjetasEnFacturador"></div>
    
    <div id="ChequesEnFacturador"></div>

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