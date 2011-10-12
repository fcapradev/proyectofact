<?
require("../config/cnx.php");
?>
<style>
.listabusqueda1{
	background-image:url(RetiroCaja/FonDef.png);
	background-repeat:repeat-x;
	cursor:pointer; 
	font-family: "TPro"; 
	color:#FFF;
	height:28px; 
	z-index:3; 
	margin-top:2px;
}

.listabusqueda2{
	background-image:url(RetiroCaja/FonSel.png); 
	background-repeat:repeat-x;
	cursor:pointer;
	font-family: "TPro";
	color:#FFF;
	height:28px; 
	z-index:3;
	margin-top:2px;
}
#toda_la_bus{ 
	display:block;
}

.textnuevo{
	color:#FFF;
	text-align:center;
	font-family: "TPro";
	margin-top:5px;
	font-size:16px;
	border:0px;
}
</style>
<script language="javascript" type="text/javascript">

$(document).ready(function(){
    $('#nuevoarticulo').submit(function() {
        $.ajax({
            type: 'POST',
            url: $(this).attr('action'),
            data: $(this).serialize(),
            success: function(data) {
                $('#archivos').html(data);
            }
        })        
        return false;
    });
})


var contador = 0;
var contador_cappp = 0;
var contador_capss = 1;
var contador_total = 0;

document.onkeydown = function(){

	if(window.event){
	if($('#toda_la_bus').length){
			
		if(window.event.keyCode == 38){
			
			var concontador = contador - 1;
			
			if(concontador <= 0){ 
				return false; 
			}else{
				
				for (i=1; i<=contador_total; i++){
				
					if(i != contador){
						$('#lineabusp'+contador).removeClass("listabusqueda2").addClass("listabusqueda1");
					}	
					
				}
				
				contador = contador - 1;
				contador_cappp = contador_cappp - 1;
			}

			if(document.getElementById('lineabusp'+contador).className == 'listabusqueda1'){
				$('#lineabusp'+contador).removeClass("listabusqueda1").addClass("listabusqueda2");
			}

			if(contador_cappp == 0){
				if(contador_capss != 0){
					contador_cappp = 8;
					movpaga_bu(contador_capss);
					contador_capss = contador_capss - 1;
				}
			}
		
		}
		if(window.event.keyCode == 40){
						
			if(contador < contador_total || contador == 0){

				for (i=1; i<=contador_total; i++){
				
					if(i != contador){
						$('#lineabusp'+contador).removeClass("listabusqueda2").addClass("listabusqueda1");
					}	
					
				}

				contador = contador + 1;
				contador_cappp = contador_cappp + 1;

				if(document.getElementById('lineabusp'+contador).className == 'listabusqueda1'){
					$('#lineabusp'+contador).removeClass("listabusqueda1").addClass("listabusqueda2");
				}
				
				if(contador_cappp == 9){
					if(contador_capss != 0){
						contador_cappp = 1;
						movpag_bu(contador_capss);
						contador_capss = contador_capss + 1;
					}
				}
			
			}
						
		}
		
		if(window.event.keyCode == 13){
			if(contador != 0){
				document.getElementById('lineabusp'+contador).onclick();
				return false;					
			}
		}
		
	}
	}
	
}

SoloNone('ClientesFac, BotonesParaO, EntraOpe, EntraOpeF, ReEmitirC, MedioP, Cotizacion');

function movpaga_bu(p){

	np = p - 1;
	document.getElementById('capa_bu'+p).style.display="none";	
	document.getElementById('capa_bu'+np).style.display="block";

return false;

}
function movpag_bu(p){

	np = p + 1;
	document.getElementById('capa_bu'+p).style.display="none";	
	document.getElementById('capa_bu'+np).style.display="block";

return false;

}

function ArtInsert(cs,ca,det){

	document.getElementById('sec').value = cs;
	document.getElementById('art').value = ca;
	document.getElementById('articulo').innerHTML = det;
	
	$("#artnuevo").fadeIn(400);
	$("#toda_la_bus").fadeOut(tim);
	
//	EnvAyuda('Ingrese código de barras o realice una búsqueda.');
	
	controlarcadainput('det');
	document.getElementById("DondeE").value = "det";
	document.getElementById("CantiE").value = "16";
	document.getElementById("QuePoE").value = "0";
	
	document.getElementById('LetEnt').innerHTML = '<button class="StyBoton" onclick="NuevaTecla();" onmouseout="MM_swapImgRestore()" onmouseover="MM_swapImage(\'LetEntFacNuevoArt\',\'\',\'botones/ent-over.png\',0)"><img src="botones/ent-up.png" name="Enter" title="Enter" border="0" id="LetEntFacNuevoArt"/></button>';

	document.getElementById('NumVol').innerHTML = '<button class="StyBoton" onclick="NuevaTecla();" onmouseout="MM_swapImgRestore()" onmouseover="MM_swapImage(\'LetVolFacNuevoArt\',\'\',\'botones/ent-over.png\',0)"><img src="botones/ent-up.png" name="Enter" title="Enter" border="0" id="LetVolFacNuevoArt"/></button>';


}

function NuevaTecla(){
	
	SoloNone("artnuevo");
	$('#nuevoarticulo').submit();
	
}


function controlarcadainput(cu){

	$("input").attr("readonly", "readonly");
	$("#"+cu).removeAttr("readonly");
	$("#"+cu).focus();

}


</script>

<div id="artnuevo" style="position:absolute; top:0px; left:0px; display:none; width:475px;; height:293px;">
<form id="nuevoarticulo" name="nuevoarticulo" method="post" action="facturador/Nuevo_Articulo.php">
	<div style="top:40px; left:100px; text-align:center; font-family: 'TPro'; color:#F90; font-size:36px;">Art&iacute;culo Seleccionado</div>
    
    <div id="articulo" style="top:60px; left:100px; text-align:center; font-family: 'TPro'; color:#FFF; font-size:26px;"> </div>

	<div style="position:absolute; top:93px; left:4px;"><img src="NaNb/fon-tip-mov.png" width="165" height="20"/></div>
	<div style="color:#FFF; position:absolute; top:92px; left:10px; width:150px; font-family: 'TPro'; color:#FFF; font-size:16px;" >Ingrese una descripci&oacute;n:  </div>

	<div style="position:absolute; top:93px; left:180px;"><img src="NaNb/fon-tip-mov-nar.png" width="175" height="20"/></div>
	<div style="color:#FFF; position:absolute; top:92px; left:180px; width:175px; font-family: 'TPro'; color:#FFF; font-size:16px;" >  
    	<input type="text" class="textnuevo" id="det" name="det" style="width:175px; top:-5px; left:3px; position:absolute; background:none; border:0; outline-style:none; border-style:none; " maxlength="16" />
        
        <input type="hidden" id="sec" name="sec" value="" />
        <input type="hidden" id="art" name="art" value="" />
        
    </div>
</form>
</div>
<?
	
if(isset($_REQUEST['l_env'])){

$LISTA = $_SESSION['iListaBO'];
$l_env = strtoupper($_REQUEST['l_env']);

$b_cod = 0;
	
	if($b_cod == 0){

		$_SESSION['ParSQL'] = "SELECT TOP 1 RED FROM APAREMP";
		$APAREMRED = mssql_query($_SESSION['ParSQL']) or die("Error SQL");
		rollback($APAREMRED);
		while ($REGRED=mssql_fetch_array($APAREMRED)){
			$RED = $REGRED['RED'];			
		}
		if($RED == 0){
			$SQL = "SELECT * FROM VI_CONSULTA_ARTICULOS_".$LISTA." WHERE det like '%".$l_env."%' order by det";
		}else{
			$SQL = "SELECT * FROM VI_CONSULTA_ARTICULOS_B".$LISTA." WHERE det like '%".$l_env."%' order by det";
		}
	
		if(isset($_REQUEST['b_cod'])){

			$b_cod = $_REQUEST['b_cod'];		
			if($b_cod == 1){
				if($RED == 0){
					$SQL = "SELECT * FROM VI_CONSULTA_ARTICULOS_".$LISTA." WHERE art = ".$l_env." order by art";
				}else{
					$SQL = "SELECT * FROM VI_CONSULTA_ARTICULOS_B".$LISTA." WHERE art = ".$l_env." order by art";
				}
				
			}
			
		}
		
	}
	
	$registros = mssql_query($SQL) or die("Error SQL");	
	if(mssql_num_rows($registros) == 0){	
		?>
		<script>
			EnvAyuda("Busqueda: <? echo $l_env; ?> --> Items: 0");
			SoloNone("MiProd, Loading, mostrar");
        </script>    
		<?
		exit;
	}

?>
<div id="toda_la_bus" style="display:block;">

<table width="420" border="0" cellpadding="0" cellspacing="0">
<tr>
<td><div align="left"><img src="producto/Producto.png" /></div></td>
<td>
	<table align="right" border="0" cellpadding="0" cellspacing="0">
	<tr>
	<td>&nbsp;</td>
	</tr>
	</table>
</td>
</tr>
</table>

<?

$c = 0;
$cc = 0;
$s = 1;
	
$co = mssql_num_rows($registros); 
while ($reg=mssql_fetch_array($registros)){

if($co == 1){

	?>
    <script>
		ArtInsert(<? echo $reg['sec']; ?>, <? echo $reg['art']; ?>,'<? echo htmlentities(substr($reg['det'], 0, 30)); ?>');
	</script>
	<?
	exit;
	
}else{
	
	?>
    <script>
		$("#micapa1").fadeOut(500);
    </script>
	<?

}

	$c = $c + 1;
	$cc = $cc + 1;
	
	if ($c == 1){

		if($s == 1){
			$e = "block";
		}else{
			$e = "none";
		}

		echo "<div id=\"capa_bu".$s."\" style=\"display:".$e."\">";
		
		if($s <> 1){
			?>
        
    	    <div id="Anterior_Pro">
			<button class="StyBoton" onClick="return movpaga_bu(<?php echo $s; ?>)" onMouseOut="MM_swapImgRestore()" onMouseOver="MM_swapImage('Anterior_Pro<?php echo $s; ?>','','otros/scr_arri-over.png',0)"><img src="otros/scr_arri-up.png" border="0" id="Anterior_Pro<?php echo $s; ?>"/></button>
			</div>

			<?

		}

	}

	?>
    <div id="lineabusp<? echo $cc; ?>" class="listabusqueda1" onclick="ArtInsert(<? echo $reg['sec']; ?>, <? echo $reg['art']; ?>,'<? echo htmlentities(substr($reg['det'], 0, 30)); ?>');">
	<table width="415px" cellpadding="0" cellspacing="0" >
    	<tbody>
            <tr> 
                <td width="32"><div align="center"><? echo format($reg['sec'],2,'0',STR_PAD_LEFT); ?></div></td>	
                <td width="50"><div align="center"><? echo format($reg['art'],4,'0',STR_PAD_LEFT); ?></div></td>
                <td width="349">&nbsp;<? echo htmlentities(substr($reg['det'], 0, 30)); ?></td>
            </tr>
        </tbody>
	</table>  
    </div>
	<?
	
	if ($c == 8){

		?>

        <div id="Siguiente_Pro">
        <button class="StyBoton" onClick="return  movpag_bu(<?php echo $s; ?>)" onMouseOut="MM_swapImgRestore()" onMouseOver="MM_swapImage('Siguiente_Pro<?php echo $s; ?>','','otros/scr_aba-over.png',0)"><img src="otros/scr_aba-up.png" border="0" id="Siguiente_Pro<?php echo $s; ?>"/></button>
        </div>
        
        </div>
        
		<?php
    	  
		$c = 0; 
        $s = $s + 1;  
		
	}

}

mssql_close($conexion);
}

if ($cc == 8){
	?>
	<script>
		SoloNone("Siguiente_Pro");
    </script>
	<?
}

?>
</div>
<script>
	EnvAyuda("Seleccione el artículo que desea agregar a Teclas Rápidas.");
	document.getElementById("Loading").style.display="none";
</script>