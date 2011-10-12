<?
require("config/cnx.php");
?>

<script language="javascript" type="text/javascript">

var Macontador = 0;
var Macontador_cappp = 0;
var Macontador_capss = 1;
var Macontador_total = 0;

document.onkeydown = function(){

	if(window.event){
	if($('#Matoda_la_bus').length){
			
		if(window.event.keyCode == 38){
			
			var conMacontador = Macontador - 1;
			
			if(conMacontador <= 0){ 
				return false; 
			}else{
				
				for (i=1; i<=Macontador_total; i++){
				
					if(i != Macontador){
						$('#Malineabusp'+Macontador).removeClass("Malistabusqueda2").addClass("Malistabusqueda1");
					}	
					
				}
				
				Macontador = Macontador - 1;
				Macontador_cappp = Macontador_cappp - 1;
			}

			if(document.getElementById('Malineabusp'+Macontador).className == 'Malistabusqueda1'){
				$('#Malineabusp'+Macontador).removeClass("Malistabusqueda1").addClass("Malistabusqueda2");
			}

			if(Macontador_cappp == 0){
				if(Macontador_capss != 0){
					Macontador_cappp = 8;
					MamovPag_ab(Macontador_capss);
					Macontador_capss = Macontador_capss - 1;
				}
			}
		
		}
		if(window.event.keyCode == 40){
						
			if(Macontador < Macontador_total || Macontador == 0){

				for (i=1; i<=Macontador_total; i++){
				
					if(i != Macontador){
						$('#Malineabusp'+Macontador).removeClass("Malistabusqueda2").addClass("Malistabusqueda1");
					}	
					
				}

				Macontador = Macontador + 1;
				Macontador_cappp = Macontador_cappp + 1;

				if(document.getElementById('Malineabusp'+Macontador).className == 'Malistabusqueda1'){
					$('#Malineabusp'+Macontador).removeClass("Malistabusqueda1").addClass("Malistabusqueda2");
				}
				
				if(Macontador_cappp == 9){
					if(Macontador_capss != 0){
						Macontador_cappp = 1;
						MamovPag_ar(Macontador_capss);
						Macontador_capss = Macontador_capss + 1;
					}
				}
			
			}
						
		}
		if(window.event.keyCode == 13){
			if(Macontador != 0){
				document.getElementById('Malineabusp'+Macontador).onclick();
				return false;s
			}
		}
		
	}		
	}
	
}

SoloNone('MaClientesFac, MaBotonesParaO, MaEntraOpe, MaEntraOpeF, MaReEmitirC, MaMedioP, MaCotizacion');

function MamovPag_ab(p){

	np = p - 1;
	document.getElementById('Macapa_bus'+p).style.display="none";
	document.getElementById('Macapa_bus'+np).style.display="block";

return false;

}
function MamovPag_ar(p){

	np = p + 1;
	document.getElementById('Macapa_bus'+p).style.display="none";
	document.getElementById('Macapa_bus'+np).style.display="block";

return false;

}

</script>
<style>
.Malistabusqueda1{
	background-image:url(RetiroCaja/FonDef.png);
	background-repeat:repeat-x;
	cursor:pointer; 
	font-family: "TPro"; 
	color:#FFF;
	height:28px; 
	z-index:3; 
	margin-top:2px;
}

.Malistabusqueda2{
	background-image:url(RetiroCaja/FonSel.png); 
	background-repeat:repeat-x;
	cursor:pointer;
	font-family: "TPro";
	color:#FFF;
	height:28px; 
	z-index:3;
	margin-top:2px;
}
#Matoda_la_bus{ 
	display:block;
}
</style>
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
		
		if($l_env == "77CODIGOOCULTO77"){
			
			$_SESSION['ParSQL'] = "
			SELECT C.NplVen AS PLA, D.FAP AS FAP, A.MTN, A.DES, A.INI, A.FIN FROM ATURNOSH AS A 
			INNER JOIN APARPOS AS B ON B.ID = '".$_SESSION['ParPOS']."'
			INNER JOIN VENDEDORES AS C ON C.CodVen = B.OPE
			INNER JOIN ATURNOSO AS D ON D.PLA = C.NplVen
			WHERE A.MTN = D.MTN
			";
			$ATURNOSH = mssql_query($_SESSION['ParSQL']) or die("Error SQL");
			rollback($ATURNOSH);		
			while ($reg=mssql_fetch_array($ATURNOSH)){

				$p = $reg['PLA'];

			}
			mssql_free_result($ATURNOSH);

			$l_env = "Top 10 Mas Vendidos";
			$SQL = "
			SELECT TOP 10 A.COD AS sec, A.ART AS art, COUNT(A.CAN) AS CAN, MAX(A.TIO) AS det
			FROM AMOVFACT A
			INNER JOIN AMAEFACT B ON A.TIP=B.TIP AND A.TCO=B.TCO AND A.SUC=B.SUC AND A.NCO=B.NCO
			WHERE A.PLA = ".$p." AND B.ANU <> 'A'
			GROUP BY A.COD,A.ART
			ORDER BY COUNT(A.CAN) DESC
			";
			
		}
		
	}
	
	$registros = mssql_query($SQL) or die("Error SQL");	
	if(mssql_num_rows($registros) == 0){	
		?>
		<script>
			EnvAyuda("Busqueda: <? echo $l_env; ?> --> Items: 0");
			SoloNone("MaMiProd, MaLoading, Mamostrar");
        </script>    
		<?
		exit;
	}




?>

<div id="Matoda_la_bus">

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
		MaFX1(<? echo $reg['sec']; ?>, <? echo $reg['art']; ?>);
	</script>
	<?
	exit;
	
}else{
	
	?>
    <script>
		$("#Mamicapa1").fadeOut(tim);
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

		echo "<div id=\"Macapa_bus".$s."\" style=\"display:".$e."\">";
		
		if($s <> 1){
			?>
        
    	    <div id="Anterior_Pro">
			<button class="StyBoton" onClick="return MamovPag_ab(<?php echo $s; ?>)" onMouseOut="MM_swapImgRestore()" onMouseOver="MM_swapImage('Anterior_Pro<?php echo $s; ?>','','otros/scr_arri-over.png',0)"><img src="otros/scr_arri-up.png" border="0" id="Anterior_Pro<?php echo $s; ?>"/></button>			
			</div>

			<?

		}

	}

	?>
    <div id="Malineabusp<? echo $cc; ?>" class="Malistabusqueda1" onClick="MaFX1(<? echo $reg['sec']; ?>, <? echo $reg['art']; ?>)">
	<table width="415px" cellpadding="0" cellspacing="1">
        <tr> 
        	<td width="32"><div align="center"><? echo format($reg['sec'],2,'0',STR_PAD_LEFT); ?></div></td>	
        	<td width="50"><div align="center"><? echo format($reg['art'],4,'0',STR_PAD_LEFT); ?></div></td>
            <td width="349">&nbsp;<? echo htmlentities(substr($reg['det'], 0, 30)); ?></td>
        </tr>
	</table>  
    </div>
	<?
	
	if ($c == 8){

		?>
		
        <div id="Siguiente_Pro">
        <button class="StyBoton" onClick="return MamovPag_ar(<?php echo $s; ?>)" onMouseOut="MM_swapImgRestore()" onMouseOver="MM_swapImage('Siguiente_Pro<?php echo $s; ?>','','otros/scr_aba-over.png',0)"><img src="otros/scr_aba-up.png" border="0" id="Siguiente_Pro<?php echo $s; ?>"/></button>
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
	Macontador_total = <?php echo $co; ?>;
	EnvAyuda("Busqueda: <? echo $l_env; ?> --> Items: <? echo $cc; ?>");
	document.getElementById("MaLoading").style.display="none";	
</script> 