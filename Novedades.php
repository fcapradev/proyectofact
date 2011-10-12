<?
require("config/cnx.php");

try {////////////////////////////////////////////////////////////////////////////////////////////////// COMIENZO TRY //

mssql_query("begin transaction",$conexion) or die("Error SQL begin trans");
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Novedades</title>
<style>

#NovedadesGeneral{
	position:absolute;
	width:726px;
	height:400px;
}
.lineaNov{
	background-image:url(Novedades/fondo_novedades.png);
	background-repeat:repeat-x;
	font-family: "TPro";
	font-weight:100;
	height:27px;
	width:700px;
	margin-top:2px;
}

.lineaNov:active{ 
	position:relative;
	left:1px;
	top:1px;
	
	-moz-box-shadow:0px 1px 0 ;
	-webkit-box-shadow:0px 1px 0 ;
}


#DetallesNovedades{
 	position:absolute;
	width:700px; 
	height:237px;
	left:12px; 
	top:60px;
	font: Gautami; 
	font-weight:bold; 
	color:#FFFFFF; 
	font-size:12px; 
	z-index:1;
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

	if(window.event){
		
		if(window.event.keyCode == 38){
			
			var concontador = contador - 1;
			
			if(concontador <= 0){ 
				return false; 
			}else{
				contador = contador - 1;
			}
			if(document.getElementById('linea'+contador).className == 'lineaNov'){
				document.getElementById('linea'+contador).onclick();
			}
			if(contador_cappp == 10){
				contador_capss = contador_capss + 1;
				if(contador_capss != 0){
					movpag_a_nov(contador_capss);
				}
			}
		
		}
		if(window.event.keyCode == 40){

			if(contador < contador_total || contador == 0){
				
				contador = contador + 1;

				if(document.getElementById('linea'+contador).className == 'lineaNov'){
					document.getElementById('linea'+contador).onclick();
				}
				
				if(contador_cappp == 1){
					
					contador_capss = contador_capss - 1;
					if(contador_capss != 0){
						movpag_b_nov(contador_capss);
					}
					
				}
			
			}
						
		}
		
		if(window.event.keyCode == 13){
			if(control_consulta == 0){
				if(contador_planilla != 0){
					ConNov(contador_numero, contador_planilla);
				}
			}
		}
	
		if(window.event.keyCode == 27){
			if(control_consulta == 1){
				volver_nov_con();
				control_consulta = 0;
			}
		}
			
	}

}



function salirNov(){
	
	Mos_Ocu("BotonesPri");
	Mos_Ocu('Novedades');
	$('#SobreFoca').fadeIn(500);

	document.getElementById('Novedades').innerHTML = '';
	
}

function movpag_a_nov(p){
	
	np = p - 1;
	document.getElementById("capa_nov"+np).style.display="block";
	document.getElementById("capa_nov"+p).style.display="none";

return false;
}

function movpag_b_nov(p){

	np = p + 1;	
	document.getElementById("capa_nov"+np).style.display="block";
	document.getElementById("capa_nov"+p).style.display="none";
	
return false;
}

function select_nov(t,mp,id,pla,ope){


	contador = mp;
	contador_total = t;
	
	contador_numero = id;
	contador_planilla = pla;
	
	document.getElementById('BotNovCon').innerHTML = '<button class="StyBoton" onclick="ConNov(\''+id+'\',\''+pla+'\');" onmouseout="MM_swapImgRestore()" onmouseover="MM_swapImage(\'BotCon\',\'\',\'botones/con-nov-over.png\',0)"><img src="botones/con-nov-up.png" name="Consultar" title="Consultar" border="0" id="BotCon"/></button>';
	
	document.getElementById('BotNovEli').innerHTML = '<button class="StyBoton" onclick="EliNov(\''+id+'\',\''+pla+'\');" onmouseout="MM_swapImgRestore()" onmouseover="MM_swapImage(\'BotEli\',\'\',\'botones/eli-over.png\',0)"><img src="botones/eli-up.png" name="Eliminar" title="Eliminar" border="0" id="BotEli"/></button>';
	
	
	for (i=1; i<=t; i++){
	
		if(i == mp){
			
			$("#linea"+mp).removeClass("lineaNov").addClass("lineare2");
		
		}else{
		
			$("#linea"+i).removeClass("lineare2").addClass("lineaNov");
	
		}	
		
	}
}

function ConNov(id,pla){

	$("#Novedades").fadeOut(500);

	$("#Novedades").load("NovCon.php?id="+id+"&pla="+pla+"");
	
	$("#Novedades").fadeIn(500);
	
	control_consulta = 1;
	
}

function EliNov(id,pla){

	 jConfirm("¿Est\u00e1 seguro que desea eliminar la Novedad?", "Debo Retail - Global Business Solution", function(r){
		if(r == true ){
			$("#archivos").load("NovProcesa.php?ideli="+id+"&plaeli="+pla+"");
		}
	});	
}

function AgregarNov(){
	
		$("#Novedades").fadeOut(500);
	
		$("#Novedades").load("NovAgr.php");

		$("#Novedades").fadeIn(500);

		document.getElementById('LetSal').innerHTML = '<button class="StyBoton" onclick="vol_nov();" onmouseout="MM_swapImgRestore()" onmouseover="MM_swapImage(\'LetSalNove\',\'\',\'botones/sal-over.png\',0)"><img src="botones/sal-up.png" name="Volver" title="Volver" border="0" id="LetSalNove"/></button>';
		
		document.getElementById('LetEnt').innerHTML = '<button id="BotLetEntFac" onclick="siguiente_nov();" class="StyBoton" onmouseout="MM_swapImgRestore()" onmouseover="MM_swapImage(\'LetEntFac\',\'\',\'botones/ent-over.png\',0)"><img src="botones/ent-up.png" name="Enter" title="Enter" border="0" id="LetEntFac"/></button>';
		
		document.getElementById('NumVol').innerHTML = '<button id="LetVolNov" onclick="vol_nov();" class="StyBoton" onmouseout="MM_swapImgRestore()" onmouseover="MM_swapImage(\'LetVolNov\',\'\',\'botones/vol-over.png\',0)"><img src="botones/vol-up.png" name="Volver" title="Volver" border="0" id="LetVolNov"/></button>';
		
}
</script>

</head>

<body>


<div id="NovedadesGeneral">

<div id="FondoNovedades">
	<img src="Novedades/novedades.png" />
</div>

<div id="DetallesNovedades">
	<div id="DetalleParaBotones">
		<?
//////////////////////////////FUNCIONES//////////////////////////
function buscar_nombre_operario($codven){
	$_SESSION['ParSQL'] = "SELECT NomVen FROM VENDEDORES WHERE CodVen=".$codven."";
	$RSBTABLA = mssql_query($_SESSION['ParSQL']) or die("Error SQL");
	rollback($RSBTABLA);	
	while ($RB=mssql_fetch_array($RSBTABLA)){
		return $RB['NomVen'];
	}
}

function buscar_tipo_novedad($id){
	$_SESSION['ParSQL'] = "SELECT * FROM TIPO_NOVEDADES WHERE id=".$id."";
	$RSBTABLA = mssql_query($_SESSION['ParSQL']) or die("Error SQL");
	rollback($RSBTABLA);	
	while ($RB=mssql_fetch_array($RSBTABLA)){
		return $RB['DESC'];
	}
}



function buscar_tipo_novedad_desc($id,$ds){
	$_SESSION['ParSQL'] = "SELECT * FROM DESC_TIPO_NOVEDADES WHERE ID_TIPO_NOVEDAD=".$id." AND ID = ".$ds."";
	$RSBTABLA = mssql_query($_SESSION['ParSQL']) or die("Error SQL");
	rollback($RSBTABLA);	
	while ($RB=mssql_fetch_array($RSBTABLA)){
		return $RB['DESC'];
	}
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
mssql_free_result($registros);
		

	$_SESSION['ParSQL'] = "SELECT * FROM NOVEDADES WHERE PLA = ".$PLA." ORDER BY ID"; 
//	$_SESSION['ParSQL'] = "SELECT * FROM NOVEDADES ORDER BY ID"; 	
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
	
	
		$id =format($ATU[1],4,'0',STR_PAD_LEFT);
		$ide =$ATU[1];
		$pla =format($ATU[0],4,'0',STR_PAD_LEFT);
		$plae =$ATU[0];
		$ope_d =format($ATU[2],3,'0',STR_PAD_LEFT)."-".buscar_nombre_operario($ATU[2]);
		$nov_d =format($ATU[3],4,'0',STR_PAD_LEFT)."-".buscar_tipo_novedad($ATU[3]);	
		$nov_a =format($ATU[4],4,'0',STR_PAD_LEFT)."-".buscar_tipo_novedad_desc($ATU[3],$ATU[4]);
		
		if ($c == 1){
		
			if($s == 1){
				$e = "block";
			}else{
				$e = "none";
			}
		
			echo "<div id=\"capa_nov".$s."\" style=\"display:".$e."\">";
			
			if($s <> 1){
				?>

				<div id="AnteriorNov" style=" position:absolute; top:240px; left:624px;">
					<button class="StyBoton" onclick="movpag_a_nov(<?php echo $s; ?>)" onMouseOut="MM_swapImgRestore()" onMouseOver="MM_swapImage('AnteriorNov_1','','otros/scr_arri-over.png',0)"><img src="otros/scr_arri-up.png" border="0" id="AnteriorNov_1"/></button>
</div>
	
				<?
	
			}
	
			}
	
			?>
		<div class="lineaNov" id="linea<? echo $cc; ?>" onclick="select_nov(<? echo $total; ?>,<? echo $cc; ?>,'<? echo $ide; ?>','<? echo $plae; ?>','<? echo $ope_d;?>');">
				<table width="700" height="26" border="0" cellpadding="0" cellspacing="0"  style="cursor:pointer;">
						<tr>
							<td width="50" align="center"><? echo $id; ?></td>
							<td width="63" align="center"><? echo $pla; ?></td>
							<td width="136" align="center"><? echo $ope_d; ?></td>
							<td width="250" align="center"><? echo $nov_d; ?></td>
							<td width="201" align="center"><? echo $nov_a; ?></td>
						</tr>
				</table>
		</div>
			<?
			
			if($c == 8){
			
			?>
			<div id="SiguienteNov" style="position:absolute; top:240px;  left:664px;">
				<button class="StyBoton" onclick="return movpag_b_nov(<?php echo $s; ?>);" onMouseOut="MM_swapImgRestore()" onMouseOver="MM_swapImage('SiguienteNov_1','','otros/scr_aba-over.png',0)"><img src="otros/scr_aba-up.png" border="0" id="SiguienteNov_1"/></button>
</div>
		
</div>
			<?php
		  
			$c = 0;
			$s = $s + 1;
	}
}
if ($cc == 8){
	?>
	<script>
		$("#SiguienteNov").fadeOut('fast');
    </script>
	<?
}
?>
</div>

<!-- ------------- BOTONES --------------- -->

<div id="BotNovCon" style=" position:absolute; top:235px; left:320px; z-index:4;"></div>	

<div id="BotNovEli" style=" position:absolute; top:235px; left:520px; z-index:4;"></div>				

<div id="BotNovAgr" style=" position:absolute; top:235px; left:420px; z-index:4;">
	<button class="StyBoton" onclick="AgregarNov();" onmouseout="MM_swapImgRestore()" onmouseover="MM_swapImage('BotNovAgr','','botones/agr-nov-over.png',0)"><img src="botones/agr-nov-up.png" name="Agregar" title="Agregar" border="0" id="BotNovAgr"/></button>
</div>

<div id="BotNovSal" style=" position:absolute; top:235px; left:7px; z-index:4;">
	<button  onclick="salirNov();" class="StyBoton" onmouseout="MM_swapImgRestore()" onmouseover="MM_swapImage('BotNovSal','','botones/sal-over.png',0)"><img src="botones/sal-up.png" name="Salir" title="Salir" border="0" id="BotNovSal"></button>
</div>

</div>





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