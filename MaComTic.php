<?
require("config/cnx.php");


try {////////////////////////////////////////////////////////////////////////////////////////////////// COMIENZO TRY //


mssql_query("begin transaction",$conexion) or die("Error SQL begin trans");

	///////////////////////////////////////////////////////////////////////////////////
	// PARA FAC MANUAL
	///////////////////////////////////////////////////////////////////////////////////
	$_SESSION['ParSQL'] = "SQL";
	$_SESSION['ParOrnMa'] = 0;
	$_SESSION['ParColMa'] = 0;
	
	$DEL_TMAEFACT_T = mssql_query("DELETE TMAEFACT_T WHERE TER = ".$_SESSION["ParPOSMa"]."") or die("Error SQL: DELETE TMAEFACT_T");
	rollback($DEL_TMAEFACT_T);
	$DEL_TMOVFACT_T = mssql_query("DELETE TMOVFACT_T WHERE TER = ".$_SESSION["ParPOSMa"]."") or die("Error SQL: DELETE TMOVFACT_T");
	rollback($DEL_TMOVFACT_T);
	$DEL_AARTPRO_T = mssql_query("DELETE AARTPRO_T WHERE TER = ".$_SESSION["ParPOSMa"]."") or die("Error SQL: DELETE AARTPRO_T");
	rollback($DEL_AARTPRO_T);
	
	///////////////////////////////////////////////////////////////////////////////////
	// PARA FAC MANUAL
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
		
		SoloNone("FacturadorMa, fondotranspletras, TecladoLet, fondotranspnumeros, TecladoNum, CarAyudaFon, CarAyuda, BotMins1, NumAre, NumTexDiv");
		SoloBlock("Marca, ProcesoSusp");
		
		Mos_Ocu('BotonesPri');
		Mos_Ocu('MaMiProd');
		Mos_Ocu('MaTiquet');
		Mos_Ocu('MaFacTotal');

		SoloNone('MaMedioP, MaCotizacion, MaDesgloseFon, MaDesglose, MaVuelto1, MaVuelto2, ProcesoSusp2');

		document.getElementById('Mamostrar').innerHTML = '';
		document.getElementById('Mamicapa1').innerHTML = '';
		document.getElementById('MaTiquetItem').innerHTML = '';
		
		document.getElementById('MaComenzarTic').value = 0;
		document.getElementById('Matotal').value = "0.00";
		document.getElementById('MaVUL').value = "";
		document.getElementById('MaPAG').value = "";
		
		$("#SobreFoca").fadeIn(400);
		document.getElementById('FacturadorMa').innerHTML = '';
		
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