<?
require("config/cnx.php");


try {////////////////////////////////////////////////////////////////////////////////////////////////// COMIENZO TRY //


mssql_query("begin transaction",$conexion) or die("Error SQL begin trans");

	///////////////////////////////////////////////////////////////////////////////////
	// PARA FAC
	///////////////////////////////////////////////////////////////////////////////////
	
	$DEL_TMAEFACT_T = mssql_query("DELETE PMAEFACT_T WHERE TER = ".$_SESSION["ParPOS"]."") or die("Error SQL: DELETE TMAEFACT_T");
	rollback($DEL_TMAEFACT_T);
	
	$DEL_TMOVFACT_T = mssql_query("DELETE PMOVFACT_T WHERE TER = ".$_SESSION["ParPOS"]."") or die("Error SQL: DELETE TMOVFACT_T");
	rollback($DEL_TMOVFACT_T);
	
	///////////////////////////////////////////////////////////////////////////////////
	// PARA FAC
	///////////////////////////////////////////////////////////////////////////////////
	
	$_SESSION['ParOrnC'] = 0;
	
mssql_query("commit transaction") or die("Error SQL commit");

	?>
	<script>

		$('#TecladoNum').attr({
			'style': 'top:-4px',
		}); 
		
		$('#NumVol').attr({
		   'style': 'left:625px; display:block;'
		});
		
		document.getElementById("YaFac").value = 0;		
		document.getElementById("YaFacCo").value = 0;
		
		
		Mos_Ocu('BotonesPri');
		Mos_Ocu('fondotranspletras');
		Mos_Ocu('TecladoLet');
		Mos_Ocu('fondotranspnumeros');
		Mos_Ocu('TecladoNum');
		Mos_Ocu('Marca');
		
		SoloNone("Compras, BotMins2, NumAre, NumTexDiv, ProcesoSusp3");
		SoloBlock("ProcesoSusp");
		
		EnvAyuda('Ocultar');
		
		$("#SobreFoca").fadeIn(400);
		document.getElementById('Compras').innerHTML = '';
				
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