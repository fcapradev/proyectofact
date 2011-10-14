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

		case '3':	//	BUSCA TODOS LOS ARTICULOS Y EXIVTA > 0
			$_SESSION['ParSQL'] = "SELECT CODSEC, CODART, DETART, COSTO, EXIVTA, EXIDEP, DEPSN, CODRUB FROM ARTICULOS WHERE CODSEC = ".$SEC." AND CODART = ".$ART." AND NHA = 0 AND PRO = 0 AND CLA NOT IN (2,4,7) AND EXIVTA > 0 ORDER BY DETART ASC";
			break;

		case '4':	//	BUSCA TODOS LOS ARTICULOS CON DEPOSITOS Y EXIDEP > 0
			$_SESSION['ParSQL'] = "SELECT CODSEC, CODART, DETART, COSTO, EXIVTA, EXIDEP, DEPSN, CODRUB FROM ARTICULOS WHERE CODSEC = ".$SEC." AND CODART = ".$ART." AND NHA = 0 AND PRO = 0 AND CLA NOT IN (2,4,7) AND DEPSN = 1 AND EXIDEP > 0 ORDER BY DETART ASC";
			break;
			
	}
	
	$R1TB = mssql_query($_SESSION['ParSQL']) or die("Error SQL");
	rollback($R1TB);
	if(mssql_num_rows($R1TB) == 0){

		switch($busca){
			case '1':	//	BUSCA TODOS LOS ARTICULOS
				?>
				<script>
					jAlert('No es posible seleccionar el art&iacute;culo.', 'Debo Retail - Global Business Solution');
				</script>
                <?				
				break;
	
			case '2':	//	BUSCA TODOS LOS ARTICULOS CON DEPOSITOS
				?>
				<script>
					jAlert('El art&iacute;culo ingresado no posee Dep&oacute;sitos.', 'Debo Retail - Global Business Solution');
				</script>
                <?				
				break;
	
			case '3':	//	BUSCA TODOS LOS ARTICULOS Y EXIVTA > 0
				?>
				<script>
					jAlert('El art&iacute;culo ingresado no posee Stock de Venta.', 'Debo Retail - Global Business Solution');
				</script>
                <?				
				break;
	
			case '4':	//	BUSCA TODOS LOS ARTICULOS CON DEPOSITOS Y EXIDEP > 0
				?>
				<script>
					jAlert('El art&iacute;culo ingresado no posee Dep&oacute;sitos o Stock.', 'Debo Retail - Global Business Solution');				</script>
                <?				
				break;
				
		}		
		?>
		<script>
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

	//	BUSCA LOS ARTICULOS CON DEPOSITO Y EXIDEP > 0  //	
		case '4':
			if(isset($_REQUEST['sec'])){
				$_SESSION['ParSQL'] = "SELECT CODSEC, CODART, DETART, COSTO, EXIVTA, EXIDEP, DEPSN, CODRUB FROM ARTICULOS WHERE CODSEC = ".$_REQUEST['sec']." AND NHA = 0 AND PRO = 0 AND CLA NOT IN (2,4,7) AND DEPSN = 1 AND EXIDEP > 0 ORDER BY DETART ASC";
			}else{
				$_SESSION['ParSQL'] = "SELECT CODSEC, CODART, DETART, COSTO, EXIVTA, EXIDEP, DEPSN, CODRUB FROM ARTICULOS WHERE NHA = 0 AND PRO = 0 AND CLA NOT IN (2,4,7) AND DEPSN = 1 AND EXIDEP > 0 ORDER BY DETART ASC";
			}
			break;
		
	}

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />

<title>Busca Art&iacute;culos de Origen</title>

<style>
.ItemLis33{
	background-image: url(Compras/Bus_Item.png);
	background-repeat:repeat-x;
	cursor:pointer;
	height:27px;
	width:455px;
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

document.getElementById("LetTex").value = "";

Ir_a("LetTex",0,15);

EnvAyuda("Escriba una descripción del Artículo");
SoloNone("LetEnt");

document.getElementById('NumVol').innerHTML = '<button onclick="Vol_Sector();" class="StyBoton" onmouseout="MM_swapImgRestore()" onmouseover="MM_swapImage(\'LetVolTomInv0\',\'\',\'botones/vol-over.png\',0)"><img src="botones/vol-up.png" name="Volver" title="Volver" border="0" id="LetVolTomInv0"/></button>';

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

$(function(){
	$('input#LetTex').quicksearch('div#Lista');
	
	/*
	$('input#LetTex').quicksearch('div#Lista',{
		'show': function(){
			_jscrollshow("#Lista2");
		}
	});
	*/

});
</script>
</head>

<body>
<div id="Lista2" style="height:161px; width:500px;">
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


	
	
	?>
	<div id="Lista" class="ItemLis33" onClick="enviaarticuloIzq(<? echo $PMOV_R['CODSEC']; ?>,<? echo $PMOV_R['CODART']; ?>, '<? echo $DETART; ?>', <? echo $EXIVTA; ?>, <? echo $EXIDEP; ?>, <? echo $COSTO; ?>, <? echo $CODRUB; ?>);">
		<table id="table_example" width="458" border="0" cellpadding="0" cellspacing="0">
            <tbody>
	            <tr>
                    <th width="35"><div align="center"><? echo format($PMOV_R['CODSEC'],2,'0',STR_PAD_LEFT); ?></div></th>
                    <td width="50"><div align="center"><? echo format($PMOV_R['CODART'],4,'0',STR_PAD_LEFT); ?></div></td>
                    <td width="260"><div align="left"  ><? echo $DETART; ?></div></td>
                    <td width="85"><div align="center"><? echo $COSTO; ?></div></td>
                    </tr>
			</tbody>
		</table>
	</div>
	<?php

	
			
}
mssql_free_result($PMOVFACT);

}
?>


</div>





<script>
	$('#Bloquear').fadeOut(500);
</script>

</body>
</html>

<script>
	_jscrollshow("#Lista2");
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