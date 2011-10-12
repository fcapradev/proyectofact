<?
require("config/cnx.php");
/////////////////////////////// COMPRAS

try {////////////////////////////////////////////////////////////////////////////////////////////////// COMIENZO TRY //

mssql_query("begin transaction",$conexion) or die("Error SQL begin trans");
/*
$ban = 0;
/* Aqui sacas la informacion de la session 
for($i = 1 ; $i <= $_SESSION['Articulos_Total'] ; $i++){
	$objeto = $_SESSION['Articulos'][$i];

	if($objeto['sec'][$i] == $SEC){
		$ban = 1;
		debug("EL SECTOR ES CORRECTO");
	}else{
		$ban = 0;
		debug("EL SECTOR NO ES CORRECTO");			
	}
	
	//debug($objeto['sec'][$i],"SEC");
	//debug($objeto['art'][$i],"ART"); 

}
*/

$LUG = $_SESSION['ParLUG'];

$busca = $_REQUEST['busca'];

////////////////////////////////////////////////////////////////////////////////////////////////////////////
////////////////////////////////////////////////////////////////////////////////////////////////////////////

if(isset($_REQUEST['dato'])){

	$ART = $_REQUEST['art'];
	$SEC = $_REQUEST['sec'];
	
	switch($busca){
		case '1':	//	BUSCA TODOS LOS ARTICULOS
			$_SESSION['ParSQL'] = "SELECT CODSEC, CODART, DETART, COSTO, EXIVTA, EXIDEP, DEPSN, CODRUB FROM ARTICULOS WHERE CODSEC = ".$SEC." AND CODART = ".$ART." AND NHA = 0 AND PRO = 0 AND CLA NOT IN (2,4,7) ORDER BY DETART ASC";
			break;

		case '2':	//	BUSCA TODOS LOS ARTICULOS CON DEPOSITOS
			$_SESSION['ParSQL'] = "SELECT CODSEC, CODART, DETART, COSTO, EXIVTA, EXIDEP, DEPSN, CODRUB FROM ARTICULOS WHERE CODSEC = ".$SEC." AND CODART = ".$ART." AND NHA = 0 AND PRO = 0 AND CLA NOT IN (2,4,7) AND DEPSN = 1 ORDER BY DETART ASC";
			break;

		case '3':	//	BUSCA TODOS LOS ARTICULOS CON DEPOSITOS
			$_SESSION['ParSQL'] = "SELECT CODSEC, CODART, DETART, COSTO, EXIVTA, EXIDEP, DEPSN, CODRUB FROM ARTICULOS WHERE CODSEC = ".$SEC." AND CODART = ".$ART." AND NHA = 0 AND PRO = 0 AND CLA NOT IN (2,4,7) AND EXIVTA > 0 ORDER BY DETART ASC";
			break;
			
	}
	
	$R1TB = mssql_query($_SESSION['ParSQL']) or die("Error SQL");
	rollback($R1TB);
	if(mssql_num_rows($R1TB) == 0){
		?>
		<script>
			jAlert('El Artículo ingresado no existe.', 'Debo Retail - Global Business Solution');
		
			document.getElementById('Producto').value = "";
			
			Ir_a("Producto",4,1);
			
			EnvAyuda("Ingrese el Articulo de Origen o Enter para listar.");
		
			document.getElementById('LetEnt').innerHTML = '<button onclick="BuscaOrigen();" class="StyBoton" onmouseout="MM_swapImgRestore()" onmouseover="MM_swapImage(\'LetEntTomInv3\',\'\',\'botones/ent-over.png\',0)"><img src="botones/ent-up.png" name="Enter" title="Enter" border="0" id="LetEntTomInv3"/></button>';
		
			document.getElementById('NumVol').innerHTML = '<button onclick="Vol_Sector();" class="StyBoton" onmouseout="MM_swapImgRestore()" onmouseover="MM_swapImage(\'LetVolTomInv0\',\'\',\'botones/vol-over.png\',0)"><img src="botones/vol-up.png" name="Volver" title="Volver" border="0" id="LetVolTomInv0"/></button>';
			
			$('#Bloquear').fadeOut(500);
		</script>    
		<?
		exit;
	}
	
	while ($reg=mssql_fetch_array($R1TB)){
		$CODSEC = $reg['CODSEC'];
		$CODART = $reg['CODART'];
		$DETART = substr($reg['DETART'],0,30);
		$EXIVTA = $reg['EXIVTA'];
		$EXIDEP = $reg['EXIDEP'];
		$COSTO = $reg['COSTO'];
		$CODRUB = $reg['CODRUB'];
	}
	
	?>
	<script>
		enviaarticuloIzq(<? echo $CODSEC; ?>,<? echo $CODART; ?>, '<? echo $DETART; ?>', <? echo $EXIVTA; ?>, <? echo $EXIDEP; ?>, <? echo $COSTO; ?>, <? echo $CODRUB; ?>);
	
	</script>
	<?


////////////////////////////////////////////////////////////////////////////////////////////////////////////
////////////////////////////////////////////////////////////////////////////////////////////////////////////

}else{

	switch($busca){
	
	//	BUSCA TODOS LOS ARTICULOS  //
		case '1':
			if(isset($_REQUEST['sec'])){
				$_SESSION['ParSQL'] = "SELECT CODSEC, CODART, DETART, COSTO, EXIVTA, EXIDEP, DEPSN, CODRUB FROM ARTICULOS WHERE CODSEC = ".$_REQUEST['sec']." AND NHA = 0 AND PRO = 0 AND CLA NOT IN (2,4,7) ORDER BY DETART ASC";
			}else{
				$_SESSION['ParSQL'] = "SELECT CODSEC, CODART, DETART, COSTO, EXIVTA, EXIDEP, DEPSN, CODRUB FROM ARTICULOS WHERE NHA = 0 AND PRO = 0 AND CLA NOT IN (2,4,7) ORDER BY DETART ASC";
			}
			break;
	
	//	BUSCA TODOS LOS ARTICULOS CON DEPOSITOS  //	
		case '2':
			if(isset($_REQUEST['sec'])){
				$_SESSION['ParSQL'] = "SELECT CODSEC, CODART, DETART, COSTO, EXIVTA, EXIDEP, DEPSN, CODRUB FROM ARTICULOS WHERE CODSEC = ".$_REQUEST['sec']." AND NHA = 0 AND PRO = 0 AND CLA NOT IN (2,4,7) AND DEPSN = 1 ORDER BY DETART ASC";
			}else{
				$_SESSION['ParSQL'] = "SELECT CODSEC, CODART, DETART, COSTO, EXIVTA, EXIDEP, DEPSN, CODRUB FROM ARTICULOS WHERE NHA = 0 AND PRO = 0 AND CLA NOT IN (2,4,7) AND DEPSN = 1 ORDER BY DETART ASC";
			}
			break;

	//	BUSCA TODOS LOS ARTICULOS CON EXIVTA > 0  //	
		case '3':
			if(isset($_REQUEST['sec'])){
				$_SESSION['ParSQL'] = "SELECT CODSEC, CODART, DETART, COSTO, EXIVTA, EXIDEP, DEPSN, CODRUB FROM ARTICULOS WHERE CODSEC = ".$_REQUEST['sec']." AND NHA = 0 AND PRO = 0 AND CLA NOT IN (2,4,7) AND EXIVTA > 0 ORDER BY DETART ASC";
			}else{
				$_SESSION['ParSQL'] = "SELECT CODSEC, CODART, DETART, COSTO, EXIVTA, EXIDEP, DEPSN, CODRUB FROM ARTICULOS WHERE NHA = 0 AND PRO = 0 AND CLA NOT IN (2,4,7) AND EXIVTA > 0 ORDER BY DETART ASC";
			}
			break;
		
	}



?>
<style>
.ItemLis33{
	background-image: url(Compras/Bus_Item.png);
	background-repeat:repeat-x;
	cursor:pointer;
	height:27px; 
	z-index:4; 
	color:#FFF; 
	font-family: "TPro"; 
	font-size:14px;
}

.ItemLis33:active{ 
	position:relative;
	left:1px;
	top:1px;
	
	-moz-box-shadow:0px 1px 0;
	-webkit-box-shadow:0px 1px 0;
}
</style>
<script>
function mov_ant_fac33(p){

	np = p - 1;	
	document.getElementById("CapFacComB"+np).style.display="block";
	document.getElementById("CapFacComB"+p).style.display="none";
	
	return false;
}

function mov_sig_fac33(p){
	
	np = p + 1;	
	document.getElementById("CapFacComB"+np).style.display="block";
	document.getElementById("CapFacComB"+p).style.display="none";
	
	return false;
}
</script>
	<?

	$c = 0;
	$s = 1;
	$t = 0;
	
////////////////////////////////////////////////////////////////////////
	
	$PMOVFACT = mssql_query($_SESSION['ParSQL']) or die("Error SQL");
	rollback($PMOVFACT);
	
	while ($PMOV_R = mssql_fetch_array($PMOVFACT)){

		$DETART = substr($PMOV_R['DETART'],0,30);
		$COSTO = $PMOV_R['COSTO'];
		$EXIVTA = $PMOV_R['EXIVTA'];
		$EXIDEP = $PMOV_R['EXIDEP'];
		$CODRUB = $PMOV_R['CODRUB'];
		
	++$c;


	if ($c == 1){
	
		if($s == 1){
			$e = "block";
		}else{
			$e = "none";
		}
	
		echo "<div id=\"CapFacComB".$s."\" style=\"display:".$e."\">";
		
		if($s <> 1){
			?>
		
			<div style="position:absolute; top:0px; left:460px;">
				<button class="StyBoton" onclick="mov_ant_fac33(<?php echo $s; ?>)" onMouseOut="MM_swapImgRestore()" onMouseOver="MM_swapImage('AntNaNbLis','','otros/scr_arri-over.png',0)"><img src="otros/scr_arri-up.png" border="0" id="AntNaNbLis"/></button>
			</div>
	
			<?
	
		}
	
	}
	
	?>
	<div class="ItemLis33" onClick="enviaarticuloIzq(<? echo $PMOV_R['CODSEC']; ?>,<? echo $PMOV_R['CODART']; ?>, '<? echo $DETART; ?>', <? echo $EXIVTA; ?>, <? echo $EXIDEP; ?>, <? echo $COSTO; ?>, <? echo $CODRUB; ?>);">
		<table width="458" border="0" cellpadding="0" cellspacing="0">
		<tr>
			<td width="35"><div align="center"><? echo format($PMOV_R['CODSEC'],2,'0',STR_PAD_LEFT); ?></div></td>
            <td width="50"><div align="center"><? echo format($PMOV_R['CODART'],4,'0',STR_PAD_LEFT); ?></div></td>
			<td width="260"><div align="left"  ><? echo $DETART; ?></div></td>
			<td width="85"><div align="center"><? echo $COSTO; ?></div></td>
		</tr>
	  </table>
	</div>
	<?php
    $t = $c;
	if ($c == 6){
	
		?>
	
		<div id="SigFacComCBid<?php echo $s; ?>" style="position:absolute; top:133px; left:460px;">
			<button class="StyBoton" onclick="mov_sig_fac33(<?php echo $s; ?>)" onMouseOut="MM_swapImgRestore()" onMouseOver="MM_swapImage('SigNaNbLis','','otros/scr_aba-over.png',0)"><img src="otros/scr_aba-up.png" border="0" id="SigNaNbLis"/></button>
		</div>
		
		</div>
		
		<?php
		
		$c = 0;
		$s = $s + 1;

	}
			
}
mssql_free_result($PMOVFACT);

if($t == 6){
	?>
    <script>
		SoloNone('SigFacComCBid<?php echo $s - 1; ?>');
	</script>
    <?
}

}

?>
<script>
	$('#Bloquear').fadeOut(500);
</script>
<?

mssql_query("commit transaction") or die("Error SQL commit");

}catch(Exception $e){////////////////////////////////////////////////////////////////////////////////////////////////// FIN DE TRY //
	
	?>
	<script>
		$('#Bloquear').fadeOut(500);
		jAlert('ERROR Reintente la operacion solicitada.', 'Debo Retail - Global Business Solution');
	</script>
	<?
exit;

}

?>