<?
require("config/cnx.php");


try {////////////////////////////////////////////////////////////////////////////////////////////////// COMIENZO TRY //


mssql_query("begin transaction",$conexion) or die("Error SQL begin trans");


?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Cheques Cargados</title>
<style>
#ChequesGeneral{
	position:absolute;
	width:726px;
	height:400px;
}

#ChequesLista{
 	position:absolute;
	width:269px; 
	height:280px;
	left:10px; 
	top:51px;
	font: Gautami; 
	font-weight:bold; 
	color:#FFFFFF; 
	font-size:12px; 
	z-index:1;
}

#CheDetalle{
	position:absolute; 
	width:399px; 
	height:271px;
	top:47px;
	left:330px;
	z-index:2;
}

#CheDetalleFon{
	position:absolute; 
	width:399px; 
	height:271px;
	top:47px;
	left:330px;
	z-index:2;
}

.OcultarDetalle{
	display: none;
}

.lineare1:active{ 
	position:relative;
	left:1px;
	top:1px;
	
	-moz-box-shadow:0px 1px 0 ;
	-webkit-box-shadow:0px 1px 0 ;
}


#Titulos{
	position:absolute; 
	top:26px;
	left:6px;
	z-index:0;
}
</style>
<script>

SoloNone('CarAyudaFon, CarAyuda');


var contador = 0;
var contador_cappp = 0;
var contador_capss = 1;
var contador_total = 0;

var controlde = 0;

document.onkeydown = function(){

if(controlde == 0){

	var control = document.getElementById('controldepasoche').value;

		if(window.event && control == 0){
			
			if(window.event.keyCode == 38){
				
				document.getElementById('controldepasoche').value = 1;
				
				var concontador = contador - 1;
				
				if(concontador <= 0){ 
					return false; 
				}else{
					contador = contador - 1;
				}
				if(document.getElementById('linea'+contador).className == 'lineare1'){
					document.getElementById('linea'+contador).onclick();
				}
				if(contador_cappp == 10){
					contador_capss = contador_capss + 1;
					if(contador_capss != 0){
						movpag_a_checon(contador_capss);
					}
				}
			
			}
			if(window.event.keyCode == 40){
				
				document.getElementById('controldepasoche').value = 1;
				
				if(contador < contador_total || contador == 0){
					
					contador = contador + 1;
					
					if(document.getElementById('linea'+contador).className == 'lineare1'){
						document.getElementById('linea'+contador).onclick();
					}
					
					if(contador_cappp == 1){
						
						contador_capss = contador_capss - 1;
						if(contador_capss != 0){
							movpag_b_checon(contador_capss);
						}
						
					}
				
				}
							
			}
			
		}

	}
	
}

function salir_che(){
	
	Mos_Ocu("BotonesPri");
	$('#SobreFoca').fadeIn(500);
	Mos_Ocu('ChequesCar');
	document.getElementById('ChequesCar').innerHTML = '';

}

function AccBotChe(){

	$('#ChequesCar').fadeOut(500);
	$("#ChequesCar").load("Cheques.php?se=a");
	$('#ChequesCar').fadeIn(500);

	SoloBlock('Marca, fondotranspletras, TecladoLet, fondotranspnumeros, TecladoNum, LetEnt, NumVol, LetSal');
	SoloNone('LetTer');

	document.getElementById('LetSal').innerHTML = '<button class="StyBoton" onclick="asalir_che_car();" onmouseout="MM_swapImgRestore()" onmouseover="MM_swapImage(\'LetSalCheCar\',\'\',\'botones/sal-over.png\',0)"><img src="botones/sal-up.png" name="Salir" title="Salir" border="0" id="LetSalCheCar"/></button>';

}

function movpag_a_checon(p){
	
	np = p - 1;
	document.getElementById("capa_checar"+np).style.display="block";
	document.getElementById("capa_checar"+p).style.display="none";

return false;
}

function movpag_b_checon(p){

	np = p + 1;	
	document.getElementById("capa_checar"+np).style.display="block";
	document.getElementById("capa_checar"+p).style.display="none";
	
return false;
}

function select_che(t,mp,pla,bco,num){

	contador = mp;
	contador_total = t;
	
	contador_cappp = mp % 10;
	if(contador_cappp == 0){
		contador_cappp = 10;
		contador_capss = parseInt(mp / 10);
	}else{
		contador_capss = parseInt(mp / 10) + 1;
	}
	
	$('#CheDetalle').fadeOut(500);
	$("#CheDetalle").load("CheCon.php?pla="+pla+"&bco="+bco+"&num="+num+"");
	$('#CheDetalle').fadeIn(500);
	$("#CheDetalle").removeClass("OcultarDetalle");
	$("#CheDetalleFon").removeClass("OcultarDetalle");

	for (i=1; i<=t; i++){
	
		if(i == mp){
			
			$("#linea"+mp).removeClass("lineare1").addClass("lineare2");
		
			document.getElementById("Che_BotEliM").style.display = "block";
			
			document.getElementById('Che_BotEliM').innerHTML = '<button class="StyBoton" onclick="AccBotEliChe(\''+pla+'\',\''+bco+'\','+num+',1);" onmouseout="MM_swapImgRestore()" onmouseover="MM_swapImage(\'BotEli\',\'\',\'botones/eli-over.png\',0)"><img src="botones/eli-up.png" name="Eliminar" title="Eliminar" border="0" id="BotEli"/></button>';

		}else{
		
			$("#linea"+i).removeClass("lineare2").addClass("lineare1");
	
		}	
		
	}
}

function AccBotEliChe(p,b,n,c){
	jConfirm("¿Est\u00e1 seguro que desea eliminar?", "Debo Retail - Global Business Solution", function(r){
		if(r == true ){				
			$("#archivos").load("CheEli.php?p="+p+"&b="+b+"&n="+n+"&c="+c+"");
		}
	});	
}

</script>


</head>

<body>

<div id="ChequesFondo"><img src="CargaCheques/Fondo con t�tulos de cheque.png" /></div>

<div id="ChequesLista">
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

	$PLA = $reg['PLA'];
	
}

$_SESSION['ParSQL'] = "SELECT BCO, NUM, LIB, PLA, IMP FROM TVALOR WHERE PLA = ".$PLA." ORDER BY NUM DESC";
$R1TB = mssql_query($_SESSION['ParSQL']) or die("Error SQL");
rollback($R1TB);		

if(!mssql_num_rows($R1TB) == 0){
	$total = mssql_num_rows($R1TB);
}

$c = 0;
$cc = 0;
$s = 1;

while ($ATU=mssql_fetch_row($R1TB)){

	$c = $c + 1;
	$cc = $cc + 1;

	if ($c == 1){
		
		if($s == 1){
			$e = "block";
		}else{
			$e = "none";
		}
	
		echo "<div id=\"capa_checar".$s."\" style=\"display:".$e."\">";
		
		if($s <> 1){
			?>

			<div id="AnteriorChe" style=" position:absolute; top:298px; left:225px;">
				<button class="StyBoton" onclick="return movpag_a_checon(<?php echo $s; ?>)" onMouseOut="MM_swapImgRestore()" onMouseOver="MM_swapImage('AnteriorFac_Che','','otros/scr_arri-over.png',0)"><img src="otros/scr_arri-up.png" border="0" id="AnteriorFac_Che"/></button>
			</div>

			<?

		}

		}

		?>
		<div id="linea<? echo $cc; ?>" class="lineare1" style="width:269px;" onclick="select_che(<? echo $total; ?>,<? echo $cc; ?>,<? echo $ATU['3']; ?>,<? echo $ATU['0']; ?>,<? echo $ATU['1'];?>);">
		<table width="269" height="26" border="0" cellpadding="0" cellspacing="0">
			<tr>
				<td width="44" align="center"><? echo $ATU['3']; ?></td>
				<td width="50" align="center"><? echo $ATU['1']; ?></td>
				<td width="111" align="center"><? echo substr($ATU['2'],0,14); ?></td>
				<td width="64" align="right"><? echo dec($ATU['4'],2); ?></td>
			</tr>
		</table>
		</div>
		<?

		if ($c == 10){

		?>

		<div id="SiguienteChe" style="position:absolute; top:298px;  left:190px;">
			<button class="StyBoton" onclick="return movpag_b_checon(<?php echo $s; ?>)" onMouseOut="MM_swapImgRestore()" onMouseOver="MM_swapImage('SiguienteFac_Che','','otros/scr_aba-over.png',0)"><img src="otros/scr_aba-up.png" border="0" id="SiguienteFac_Che"/></button>
		</div>

		</div>

		<?php
	  
		$c = 0;
		$s = $s + 1;
			
	}
	
}
if ($cc == 10){
	?>
	<script>
		$("#SiguienteChe").fadeOut('fast');
    </script>
	<?
}
?>
</div>
</div>

<div id="Botones_Fondo" style="position:absolute; top:340px; left:5px;">
<table width="770" border="0">
	<tr>
		<td width="367">
        <div id="saleche">
        	<button onclick="salir_che();" class="StyBoton" onmouseout="MM_swapImgRestore()" onmouseover="MM_swapImage('LetSalirChe','','botones/sal-over.png',0)">
            <img src="botones/sal-up.png" name="Salir" title="Salir" border="0" id="LetSalirChe"></button>
        </div>
		</td>
		<td>	
        <div id="Che_BotAgrM">
        	<button class="StyBoton" onclick="AccBotChe(1,0,0);" onmouseout="MM_swapImgRestore()" onmouseover="MM_swapImage('BotAgr','','botones/agr-che-over.png',0)">
        	<img src="botones/agr-che-up.png" name="Agregar" title="Agregar" border="0" id="BotAgr"/></button>
        </div>
		</td>
		<td>
		<div id="Che_BotEliM" style="display:none;"></div>
		</td>
		<td>
		</td>
	</tr>
</table>

</div>

<div id="CheDetalleFon" class="OcultarDetalle"><img src="CargaCheques/cheque.png" /></div>

<div id="CheDetalle" class="OcultarDetalle" ></div>

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