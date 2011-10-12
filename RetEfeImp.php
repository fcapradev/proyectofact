<?
require("config/cnx.php");

try {////////////////////////////////////////////////////////////////////////////////////////////////// COMIENZO TRY //

mssql_query("begin transaction",$conexion) or die("Error SQL begin trans");
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Retiro de efectivo</title>

<script>

/**** RETIRO EFECTIVO ****/

function salir_ret(){

	Mos_Ocu('BotonesPri');
	Mos_Ocu('RetiroEfectivo');
	document.getElementById('RetiroEfectivo').innerHTML = '';
	
}
function RetiroEfectivo(t,p,mp,anu,e){

	for (i=1; i<=t; i++){
	
		if(i == p){
			$("#linea"+i).removeClass("lineare1").addClass("lineare2");
			
			if(anu == 'ANULADO'){
				
				document.getElementById("Ret_BotAnuM").style.display = "none";
			}else{
				document.getElementById("Ret_BotAnuM").style.display = "block";
				document.getElementById('Ret_BotAnuM').innerHTML = '<button class="StyBoton" onclick="AccBotRetEfe(2,'+e+','+mp+');" onmouseout="MM_swapImgRestore()" onmouseover="MM_swapImage(\'BotAnu\',\'\',\'botones/anu-over.png\',0)"><img src="botones/anu-up.png" name="Anular" title="Anular" border="0" id="BotAnu"/></button>';
			}

				document.getElementById('Ret_BotConM').innerHTML = '<button class="StyBoton" onclick="AccBotRetEfe(3,'+e+','+mp+');" onmouseout="MM_swapImgRestore()" onmouseover="MM_swapImage(\'BotCon\',\'\',\'botones/con-over.png\',0)"><img src="botones/con-up.png" name="Consultar" title="Consultar" border="0" id="BotCon"/></button>';
				document.getElementById('Ret_BotImpM').innerHTML = '<button class="StyBoton" onclick="AccBotRetEfe(4,'+e+','+mp+');" onmouseout="MM_swapImgRestore()" onmouseover="MM_swapImage(\'BotImp\',\'\',\'botones/imp-over.png\',0)"><img src="botones/imp-up.png" name="Imprimir" title="Imprimir" border="0" id="BotImp"/></button>';
			
						
		}else{
			$("#linea"+i).removeClass("lineare2").addClass("lineare1");
		}
		
	}
	
}



/*** FRANCO LUNES 11/04/11 ***/
function AccBotRetEfe(f,p,n){
	
	if(f == 1){
	
		$("#RetiroEfectivo").load("RetEfeN.php");
		
		
		document.getElementById('LetSal').innerHTML = '<button class="StyBoton" onclick="salir_ret();" onmouseout="MM_swapImgRestore()" onmouseover="MM_swapImage(\'LetSalRetEfe\',\'\',\'botones/sal-over.png\',0)"><img src="botones/sal-up.png" name="Volver" title="Volver" border="0" id="LetSalRetEfe"/></button>';
	
		document.getElementById('LetEnt').innerHTML = '<button id="BotLetEntFac" onclick="siguiente();" class="StyBoton" onmouseout="MM_swapImgRestore()" onmouseover="MM_swapImage(\'LetEntFac\',\'\',\'botones/ent-over.png\',0)"><img src="botones/ent-up.png" name="Enter" title="Enter" border="0" id="LetEntFac"/></button>';
	
		document.getElementById('NumVol').innerHTML = '<button id="BotLetEntFacV" onclick="siguiente();" class="StyBoton" onmouseout="MM_swapImgRestore()" onmouseover="MM_swapImage(\'LetEntFacV\',\'\',\'botones/ent-over.png\',0)"><img src="botones/ent-up.png" name="Enter" title="Enter" border="0" id="LetEntFacV"/></button>';
		
		Mos_Ocu('retiroefectivo');
		Mos_Ocu('retiroefectivoimagen');
		Mos_Ocu('retiroefectivoboton');
		
		Mos_Ocu('fondotranspletras');
		Mos_Ocu('TecladoLet');
		Mos_Ocu('fondotranspnumeros');
		Mos_Ocu('TecladoNum');
		
		Mos_Ocu('LetTer');
		
		document.getElementById("DondeE").value = "retiro";
		document.getElementById("CantiE").value = "12";
		document.getElementById("QuePoE").value = "1";
				
	}
		
	if(f == 2 ){
	
	  jConfirm("¿Est\u00e1 seguro que desea anular?", "Debo Retail - Global Business Solution", function(r){
			if(r == true ){
				$("#archivos").load("RetEfeT.php?f="+f+"&p="+p+"&n="+n+"");
			}
		});
		
	}
	
	if(f == 3){
		$("#RetiroEfectivo").load("RetEfeC.php?p="+p+"&n="+n+"");
	}
	
	if(f == 4){
		$("#archivos").load("RetEfeT.php?f="+f+"&p="+p+"&n="+n+"");
	}
	
}


</script>
</head>
<body>

<div id="retiroefectivoimagen">
	<img src="RetiroCaja/fondoytitulos.png" />
</div>

<div id="retiroefectivo">
	<table width="699" height="26" cellpadding="0" cellspacing="0">
		<tr>		
		<?
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
		
			$pla_ver = $reg['PLA'];
		}
		mssql_free_result($registros);
		$SQL = "SELECT top 10 PLA, NUM, OPE, B.NomVen, A.FEC, CASE ANU WHEN 1 THEN 'ANULADO' ELSE '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;' END AS ANU, (EFE+REF1+REF2+REF3+REF4+REF5+GAS+ANT+TAR+CHE) AS TOT FROM ATURRPA A INNER JOIN VENDEDORES B ON OPE=B.CodVen WHERE PLA = ".$pla_ver." ORDER BY PLA, NUM desc";
		
		$ATURRPA = mssql_query($SQL) or die("Error SQL");
		if(!mssql_num_rows($ATURRPA) == 0){
				
				$total = mssql_num_rows($ATURRPA);
				$c = 0;
				$cc = 0;
				
					
			while ($ATU=mssql_fetch_row($ATURRPA)){
				
				$c = $c + 1;
				$cc = $cc + 1;

				?>
				<tr>
					
					<td>
					
						<div class="lineare1" id="linea<? echo $cc; ?>" onclick="RetiroEfectivo(<? echo $total; ?>,<? echo $cc; ?>,<? echo $ATU[1]; ?>,'<? echo $ATU[5]; ?>',<? echo $ATU[0]; ?>);">
				
							<table width="699" height="26" border="0" cellpadding="0" cellspacing="0">
							<tr>
								<td width="50" align="center"><? echo $ATU[0]; ?></td>
								<td width="52" align="center"><? echo $ATU[1]; ?></td>
								<td width="93" align="center"><? echo $ATU[2]; ?></td>
								<td width="225" align="left"><? echo $ATU[3]; ?></td>
								<td width="105" align="center"><? echo $ATU[4]; ?></td>
								<td width="90" align="center"><? echo $ATU[5]; ?></td>
								<td width="84" align="right"><? echo dec($ATU[6],2); ?></td>
							</tr>
							</table>
						</div>
						
					</td>
					
				</tr>
				
				<?
				$c = 0;
			}
			mssql_free_result($ATURRPA);
		}	
		?>
		</tr>
	</table>
</div>

<div id="retiroefectivoboton">
<table width="726">
	<tr>
		
		<td width="367">
		<div id="saleret" style="position:absolute; top:11px; left:20px;">
			<button id="BotRetSal" onclick="salir_ret();" class="StyBoton" onmouseout="MM_swapImgRestore()" onmouseover="MM_swapImage('LetSalirRe','','botones/sal-over.png',0)"><img src="botones/sal-up.png" name="Salir" title="Salir" border="0" id="LetSalirRe"></button>
		</div>		
		</td>
		
		<td width="85">
		<div id="Ret_BotAgrM">
		<button style="position:absolute; top:11px; left:283px;" class="StyBoton" onclick="AccBotRetEfe(1);" onmouseout="MM_swapImgRestore()" onmouseover="MM_swapImage('BotAgr','','botones/agr-ret-over.png',0)"><img src="botones/agr-ret-up.png" name="Agregar" title="Agregar" border="0" id="BotAgr"/></button>
		</div>
		</td>
		<td width="85">
		<div id="Ret_BotAnuM" style="display:none; position:absolute; top:11px; left:394px;">

		</div>
		</td>
		<td width="85">
		<div id="Ret_BotConM" style="display:none; position:absolute; top:11px; ">
		</div>
		</td>
		<td width="85">
		<div id="Ret_BotImpM" style="display:none; position:absolute; top:11px; ">

		</div>
		</td>
	
	<td width="20"></td>
		
	</tr>
</table>

</div>	

</body>
</html>
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