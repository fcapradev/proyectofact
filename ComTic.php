<?
require("config/cnx.php");


try {////////////////////////////////////////////////////////////////////////////////////////////////// COMIENZO TRY //


mssql_query("begin transaction",$conexion) or die("Error SQL begin trans");

	///////////////////////////////////////////////////////////////////////////////////
	// PARA FAC
	///////////////////////////////////////////////////////////////////////////////////
	$_SESSION['ParSQL'] = "SQL";
	$_SESSION['ParOrn'] = 0;
	$_SESSION['ParCol'] = 0;
	
	$DEL_TMAEFACT_T = mssql_query("DELETE TMAEFACT_T WHERE TER = ".$_SESSION["ParPOS"]."") or die("Error SQL: DELETE TMAEFACT_T");
	rollback($DEL_TMAEFACT_T);
	$DEL_TMOVFACT_T = mssql_query("DELETE TMOVFACT_T WHERE TER = ".$_SESSION["ParPOS"]."") or die("Error SQL: DELETE TMOVFACT_T");
	rollback($DEL_TMOVFACT_T);
	$DEL_AARTPRO_T = mssql_query("DELETE AARTPRO_T WHERE TER = ".$_SESSION["ParPOS"]."") or die("Error SQL: DELETE AARTPRO_T");
	rollback($DEL_AARTPRO_T);
	
	///////////////////////////////////////////////////////////////////////////////////
	// PARA FAC
	///////////////////////////////////////////////////////////////////////////////////
	
mssql_query("commit transaction") or die("Error SQL commit");

	?>
	<script>

		$('#TecladoNum').attr({
		   'style': 'top:-4px',
		}); 
		
		$('#NumVol').attr({
		   'style': 'left:625px; display:block;'
		});
			
		$("#Monedas").load("MMon.php?tot=0");
		
		SoloNone("Facturador, fondotranspletras, TecladoLet, fondotranspnumeros, TecladoNum, CarAyudaFon, CarAyuda, BotMins, NumAre, NumTexDiv");
		SoloBlock("Marca, ProcesoSusp");
		
		Mos_Ocu('BotonesPri');
		Mos_Ocu('MiProd');
		Mos_Ocu('Tiquet');
		Mos_Ocu('FacTotal');

		SoloNone('MedioP, Cotizacion, DesgloseFon, Desglose, Vuelto1, Vuelto2, ProcesoSusp1');
		
		
		document.getElementById('mostrar').innerHTML = "";
		document.getElementById('micapa1').innerHTML = "";
		document.getElementById('TiquetItem').innerHTML = "";
		
		document.getElementById('ComenzarTic').value = 0;
		document.getElementById('total').value = "0.00";
		document.getElementById('VUL').value = "";
		document.getElementById('PAG').value = "";
		
		document.getElementById("YaFacAu").value = 0;
		
		$("#SobreFoca").fadeIn(400);
		//document.getElementById('Facturador').innerHTML = "";

	</script>
	<?	

}catch(Exception $e){////////////////////////////////////////////////////////////////////////////////////////////////// FIN DE TRY //
	
	?>
	<script>
		jAlert('ERROR Reintente la operacion solicitada.', 'Debo Retail - Global Business Solution');
	</script>
	<?
exit;

}
?>