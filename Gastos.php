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

<style>
#GastosSeleccion{
 	position:absolute;
	width:726px; 
	height:260px;
	left:7px; 
	top:50px;
	font: Gautami; 
	font-weight:bold; 
	color:#FFFFFF; 
	font-size:12px; 
	z-index:1;
}
#gastosimagenbot{
	position:absolute;
	width:726px;
	height:260px;
	left:26px;
	top:317px;
	z-index:2;
}
.lineaGas{
	background-image:url(CargaGastos/fondo.png);
	background-repeat:repeat-x;
	font-family: "TPro";
	font-weight:100;
	height:27px;
	width:711px;
	margin-top:2px;
}

.lineaGas:active{ 
	position:relative;
	left:1px;
	top:1px;
	
	-moz-box-shadow:0px 1px 0 ;
	-webkit-box-shadow:0px 1px 0 ;
}

.lineaGasSel{
	background-image:url(CargaGastos/fondo-sel.png);
	background-repeat:repeat-x;
	font-family: "TPro";
	font-weight:100;
	height:27px;
	width:711px;
	margin-top:2px;
}

</style>

<script>


var contador = 0;
var contador_cappp = 0;
var contador_capss = 1;
var contador_total = 0;

var control_consulta = 0;
var	contador_numero = 0;
var contador_planilla = 0;
	
document.onkeydown = function(){

//alert(window.event.keyCode);

	if(window.event){
		
		if(window.event.keyCode == 38){
			
			var concontador = contador - 1;
			
			if(concontador <= 0){ 
				return false; 
			}else{
				contador = contador - 1;
			}
			if(document.getElementById('linea'+contador).className == 'lineaGas'){
				document.getElementById('linea'+contador).onclick();
			}
			if(contador_cappp == 10){
				contador_capss = contador_capss + 1;
				if(contador_capss != 0){
					movpag_a_tar(contador_capss);
				}
			}
		
		}
		if(window.event.keyCode == 40){

			if(contador < contador_total || contador == 0){
				
				contador = contador + 1;

				if(document.getElementById('linea'+contador).className == 'lineaGas'){
					document.getElementById('linea'+contador).onclick();
				}
				
				if(contador_cappp == 1){
					
					contador_capss = contador_capss - 1;
					if(contador_capss != 0){
						movpag_b_tar(contador_capss);
					}
					
				}
			
			}
						
		}
		
		if(window.event.keyCode == 13){
			if(control_consulta == 0){
				if(contador_planilla != 0){
					AccBotGas(3,contador_planilla,contador_numero);
				}
			}
		}
	
		if(window.event.keyCode == 27){
			if(control_consulta == 1){
				salir_gas_con();
				control_consulta = 0;
			}
		}
			
	}

}

SoloBlock("Marca");

function salir_gas(){

	$('#SobreFoca').fadeIn(500);
	Mos_Ocu("BotonesPri");
	Mos_Ocu('Gastos');
	document.getElementById('Gastos').innerHTML = '';

}

function GastosSel(t,p,mp,anu,e){
	

	contador = p;
	contador_total = t;
	
	contador_numero = mp;
	contador_planilla = e;
	
	for (i=1; i<=t; i++){
	
		if(i == p){
			
			$("#linea"+i).removeClass("lineaGas").addClass("lineaGasSel");
			
			if(anu == 'A'){
			
				document.getElementById("Gas_BotAnuM").style.display = "none";
				document.getElementById('Gas_BotAnuM').innerHTML = '<button class="StyBoton" onclick="AccBotGas(2,'+e+','+mp+');" onmouseout="MM_swapImgRestore()" onmouseover="MM_swapImage(\'BotAnu\',\'\',\'botones/anu-over.png\',0)"><img src="botones/anu-up.png" name="Anular" title="Anular" border="0" id="BotAnu"/></button>';
			
			}else{
				document.getElementById("Gas_BotAnuM").style.display = "block";
				document.getElementById('Gas_BotAnuM').innerHTML = '<button class="StyBoton" onclick="AccBotGas(2,'+e+','+mp+');" onmouseout="MM_swapImgRestore()" onmouseover="MM_swapImage(\'BotAnu\',\'\',\'botones/anu-over.png\',0)"><img src="botones/anu-up.png" name="Anular" title="Anular" border="0" id="BotAnu"/></button>';
								
			}
					
			
			document.getElementById('Gas_BotConM').innerHTML = '<button class="StyBoton" onclick="AccBotGas(3,'+e+','+mp+');" onmouseout="MM_swapImgRestore()" onmouseover="MM_swapImage(\'BotCon\',\'\',\'botones/con-over.png\',0)"><img src="botones/con-up.png" name="Consultar" title="Consultar" border="0" id="BotCon"/></button>';
						
		}else{
			$("#linea"+i).removeClass("lineaGasSel").addClass("lineaGas");
		}
		
	}
	
}

/*** FRANCO LUNES 11/04/11 ***/
function AccBotGas(f,p,n){
	
	if(f == 1){

		$('#Gastos').fadeOut(500);
		
		$("#Gastos").load("GasAgr.php");
		
		$('#Gastos').fadeIn(500);
		
		document.getElementById('LetSal').innerHTML = '<button class="StyBoton" onclick="salir_gas();" onmouseout="MM_swapImgRestore()" onmouseover="MM_swapImage(\'LetSalGasTos\',\'\',\'botones/sal-over.png\',0)"><img src="botones/sal-up.png" name="Volver" title="Volver" border="0" id="LetSalGasTos"/></button>';
		
		document.getElementById('LetEnt').innerHTML = '<button id="BotLetEntFac" onclick="siguiente_gas();" class="StyBoton" onmouseout="MM_swapImgRestore()" onmouseover="MM_swapImage(\'LetEntFac\',\'\',\'botones/ent-over.png\',0)"><img src="botones/ent-up.png" name="Enter" title="Enter" border="0" id="LetEntFac"/></button>';
		
		document.getElementById('NumVol').innerHTML = '<button id="LetVolGas" onclick="salir_gas();" class="StyBoton" onmouseout="MM_swapImgRestore()" onmouseover="MM_swapImage(\'LetVolGas\',\'\',\'botones/vol-over.png\',0)"><img src="botones/vol-up.png" name="Volver" title="Volver" border="0" id="LetVolGas"/></button>';
		
		document.getElementById("DondeE").value = "LetTex";
		document.getElementById("CantiE").value = "0";
		document.getElementById("QuePoE").value = "0";
		
	}
	
	if(f == 2 ){

		 jConfirm("¿Est\u00e1 seguro que desea anular?", "Debo Retail - Global Business Solution", function(r){
			if(r == true ){
				$("#archivos").load("GasAnu.php?f="+f+"&p="+p+"&n="+n+"");
			}
		});
	 
	}
	if(f == 3){

		$('#Gastos').fadeOut(500);
		$("#Gastos").load("GasCon.php?p="+p+"&n="+n+"");
		$('#Gastos').fadeIn(500);
		control_consulta = 1;
		
	}
	
	if(f == 4){
		$("#archivos").load("RetEfeT.php?f="+f+"&p="+p+"&n="+n+"");
	}
	
}

</script>
</head>
<body>

<div id="gastosimagen"><img src="CargaGastos/gastos.png" /></div>

<div id="GastosSeleccion">
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
		unset($reg);
		//SELECCIONO 
		$_SESSION['ParSQL'] = "SELECT top 9 TIP, TCO, SUC, NCO,FEC, OPE, PLA, NOM, TOT, ANU FROM PMAEFACT WHERE CG = 'G' AND PLA = ".$pla_ver." ORDER BY FEC asc";
		$R1TB = mssql_query($_SESSION['ParSQL']) or die("Error SQL");
		rollback($R1TB);		
		if(!mssql_num_rows($R1TB) == 0){
				
				$total = mssql_num_rows($R1TB);
		}
				$c = 0;
				$cc = 0;
		
			while ($ATU=mssql_fetch_row($R1TB)){
				$c = $c + 1;
				$cc = $cc + 1;
				
				$fecha = $ATU['4'];
				$date = new DateTime($fecha);
				$fecha = $date->format('d-m-Y H:i:s');

				$msj = "";
				if($ATU['9'] == 'A'){
					$msj = "[ANU]";
				}else{
					$msj = "";
				}
				
				?>

                <tr>
                	<td>
                	<div id="linea<? echo $cc; ?>" class="lineaGas" onclick="GastosSel(<? echo $total; ?>,<? echo $cc; ?>,<? echo $ATU['3']; ?>,'<? echo $ATU['9']; ?>','<? echo $ATU['6']; ?>');">
                      <table width="711" height="26" border="0" cellpadding="0" cellspacing="0" style="cursor:pointer;">
                        <tr>
                            <td width="50" align="center"><? echo $cc; ?></td>
                            <td width="58" align="center"><? echo $ATU['6']; ?></td>
                            <td width="84" align="center"><? echo $ATU['3']; echo ' '.'<samp style="color:#F00; font-weight:bold;  font-size:14px"><b>'.$msj.'</b></samp>'; ?></td>
                            <td width="72" align="center"><? echo $ATU['5']; ?></td>
                            <td width="256" align="center"><? echo $ATU['7']; ?></td>
                            <td width="105" align="center"><? echo $fecha; ?></td>
                            <td width="65" align="right"><? echo dec($ATU['8'],2); ?></td>
                            <td width="20">&nbsp;</td>
                        </tr>
                      </table>
                	</div>
                	</td>
				</tr>
				<?

				$c = 0;

			}
		?>
		</tr>
	</table>	

</div>

<div id="gastosimagenbot">
<table width="726">
	<tr>
		
		<td width="367">
		<div id="salegas" style="position:absolute;  top:3px; left:20px;">
			<button id="BotGasSal" onclick="salir_gas();" class="StyBoton" onmouseout="MM_swapImgRestore()" onmouseover="MM_swapImage('LetSalirGa','','botones/sal-over.png',0)"><img src="botones/sal-up.png" name="Salir" title="Salir" border="0" id="LetSalirGa"></button>
		</div>				
		
		</td>
		<td width="85">
		<div id="Gas_BotAgrM">
		<button style="position:absolute; top:3px; left:384px;" class="StyBoton" onclick="AccBotGas(1,0,0);" onmouseout="MM_swapImgRestore()" onmouseover="MM_swapImage('BotAgr','','botones/agr-gas-over.png',0)"><img src="botones/agr-gas-up.png" name="Agregar" title="Agregar" border="0" id="BotAgr"/></button>
		</div>
		</td>
		<td width="85">
		<div id="Gas_BotAnuM" style="display:none;"></div>
		</td>
		<td width="87">
		<div id="Gas_BotConM" style=" position:absolute; left:600px; top:3px;"></div>
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