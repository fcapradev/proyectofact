<?
require("config/cnx.php");

try {////////////////////////////////////////// COMIENZO TRY //

mssql_query("begin transaction",$conexion) or die("Error SQL begin trans");

if(isset($_REQUEST['ti']) ){
	$ti = $_REQUEST['ti'];
	$tc = $_REQUEST['tc'];
	$su = $_REQUEST['su'];
	$nc = $_REQUEST['nc'];
	$comprobante = $ti."  ".$tc."  ".format($su,4,'0',STR_PAD_LEFT)." - ".$nc;
}else{
	exit;	
}

$_SESSION['ParSQL'] = "SELECT a.zon AS emp,a.tip AS tip,a.tco AS tco,a.suc AS suc,a.nco AS nco,a.pro AS pro,a.fec AS fec,a.nom AS nom,a.estado AS estado FROM PMAEFACT_AUTO a INNER JOIN PMOVFACT_AUTO b ON a.tip=b.tip AND a.tco=b.tco AND a.suc=b.suc AND a.nco=b.nco WHERE estado = 10 and a.tip = '".$ti."' and a.tco = '".$tc."' and a.suc = ".$su." and a.nco = ".$nc." and a.emp = ".$_SESSION['ParEMP']." GROUP BY a.zon,a.tip,a.tco,a.suc,a.nco,a.pro ,a.fec ,a.nom ,a.estado ORDER BY fec,a.tip,a.tco,a.suc,a.nco";
	
	$R1TB = mssql_query($_SESSION['ParSQL']) or die("Error SQL");
	rollback($R1TB);
	
	if(!mssql_num_rows($R1TB) == 0){
		$total = mssql_num_rows($R1TB);
	}
	
	while ($ATU=mssql_fetch_row($R1TB)){
		$proveedor = format($ATU[5],5,'0',STR_PAD_LEFT)." - ".$ATU[7];
	}
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<title>Compras Autom&aacute;ticas Detalle</title>

<style>

#DetallesCompraAuto1{
 	position:absolute;
	width:700px; 
	height:237px;
	left:27px; 
	top:-576px;
	font: Gautami; 
	font-weight:bold; 
	color:#FFFFFF; 
	font-size:12px; 
	z-index:0;
}

#FondoCompraAuto1{
 	position:absolute;
	width:700px; 
	height:237px;
	left:27px; 
	top:0px;
	font: Gautami; 
	font-weight:bold; 
	color:#FFFFFF; 
	font-size:12px; 
	z-index:1;
	
}

.lineaComsel{
	background-image:url(Compras/comaut/fongrislis.png);
	background-repeat:repeat-x;
	font-family: "TPro";
	font-weight:100;
	height:27px;
	width:592px;
	margin-top:2px;
}

.lineaComsel:active{ 
	position:relative;
	left:1px;
	top:1px;
	
	-moz-box-shadow:0px 1px 0 ;
	-webkit-box-shadow:0px 1px 0 ;
}


.lineaComNar2{
	background-image:url(Compras/comaut/fonnarlis.png);
	background-repeat:repeat-x;
	font-family: "TPro";
	font-weight:100;
	height:27px;
	margin-top:2px;
}

.lineaComNar{
	background-image:url(Compras/comaut/fonnarlis.png);
	background-repeat:repeat-x;
	font-family: "TPro";
	font-weight:100;
	height:27px;
	margin-top:2px;
}
</style>

<script>


document.getElementById('pantallacompra').value = 2;
SoloBlock("todos");
EnvAyuda2("Seleccione los &iacute;tems verificados.Luego autorice el Comprobante.");

function cominicio(){
	
	$('#ComAutAce').fadeOut(500);
	$('#ComAut').fadeOut(500);

		SoloBlock("Teclado_Completo, BotMins2, CarAyuda, CarAyudaFon, NumAre, NumTexDiv");
		SoloNone("CarAyuda2, CarAyudaFon2");

	$('#Compras').fadeIn(500);
	
}

function comlista(){

	$('#ComAut').fadeOut(500);	
	$('#ComAutAce').fadeOut(500);
	$("#ComAut").load("ComAut.php");
	$('#ComAut').fadeIn(200);

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


function sel_item(t,mp){
	var c = 0;
	for (i=1; i<=t; i++){
		
		var x = "fila" + i;	

		if(document.getElementById(x).checked == true){
			
			c = c + parseInt(1);
			
		}
		
		if( c == (t-parseInt(1))){
			SoloBlock("botonAutorizar, todosOn");
			SoloNone("todosOff");
		}else{
			SoloBlock("todosOff");
			SoloNone("todosOn");	
		}
	}
	
	for (i=1; i<=t; i++){
	
		var x = "fila" + i;	
		var xx = "ok" + i;	
		
		var it = document.getElementById(x).checked;

		if(i == mp){

			if(document.getElementById(x).checked == true){

				$("#linea"+i).removeClass("lineaComNar").addClass("lineaCom");
				
				document.getElementById(x).checked = false;
				
				SoloNone("botonAutorizar");
				SoloNone(xx);
				

			}else{

				$("#linea"+mp).removeClass("lineaCom").addClass("lineaComNar");
				document.getElementById(x).checked = true;
				SoloBlock(xx);

			}
			
		}

		
	}

}


//	FUNCION PARA SELECCIONAR TODOS LOS ITEMS
function seltodos(a){

	var t = document.getElementById("cantidad").value;

	if(a == 1){

		SoloNone("todosOff");
		SoloBlock("todosOn, botonAutorizar");	
		
		for (i=1; i<=t; i++){
		
			var x = "fila" + i;	
			var xx = "ok" + i;	
			SoloBlock(xx);
			$("#linea"+i).removeClass("lineaCom").addClass("lineaComNar");
			document.getElementById(x).checked = true;
			
	
		}
		
	}else{
		SoloNone("todosOn, botonAutorizar");
		SoloBlock("todosOff");		
		
		for (i=1; i<=t; i++){
		
			var x = "fila" + i;	
			var xx = "ok" + i;	
			SoloNone(xx);
	
			$("#linea"+i).removeClass("lineaComNar").addClass("lineaCom");
			document.getElementById(x).checked = false;
	
		}
		
	}
	
}

function autorizar(){
	
	createCookie('jAlertT','17000',1);
	
	jConfirm("¿Esta seguro que desea autorizar el comprobante: <? echo $comprobante; ?>?", "Debo Retail - Global Business Solution", function(r){
		if(r == true ){
			$('#Bloquear').fadeIn(500);
			document.getElementById('pantallacompra').value = 3;

			$("#archivos").load("ComAutPro.php?ban=1&ti="+'<? echo $ti; ?>'+"&tc="+'<? echo $tc; ?>'+"&su="+<? echo $su; ?>+"&nc="+<? echo $nc; ?>+"");
		}
	});
}

function rechazar(){
	
	createCookie('jAlertT','17000',1);
	
	jConfirm("¿Esta seguro que desea rechazar el comprobante: <? echo $comprobante; ?>?", "Debo Retail - Global Business Solution", function(r){
		if(r == true ){

			SoloNone("FondoCompraAuto1, DetalleParaBotones1, todos, botonComprasS1, botonComprasS2, botonRechazar, botonAutorizar, BotonesLet3, BotonesLet2, cabecera");
			
			SoloBlock("BotonesLet1, Teclado_Completo, NumVol, Marca");
			SoloNone("LetTer, LetSal");

			$("#rechazado").fadeIn(500);
			
			document.getElementById('LetEnt').innerHTML = '<button onclick="rechazaenvio();" class="StyBoton" onmouseout="MM_swapImgRestore()" onmouseover="MM_swapImage(\'LetEntComAutEnv2\',\'\',\'botones/ent-over.png\',0)"><img src="botones/ent-up.png" name="Enter" title="Enter" border="0" id="LetEntComAutEnv2"/></button>';
			
			document.getElementById('NumVol').innerHTML = '<button onclick="volverenvio();" class="StyBoton" onmouseout="MM_swapImgRestore()" onmouseover="MM_swapImage(\'NumVolComAutEnv2\',\'\',\'botones/vol-over.png\',0)"><img src="botones/vol-up.png" name="Volver" title="Volver" border="0" id="NumVolComAutEnv2"/></button>';
			
			EnvAyuda2("Ingrese una Observaci&oacute;n.");
			
			document.getElementById("YaFac").value = 1;
			
			document.getElementById("DondeE").value = "obs";
			document.getElementById("CantiE").value = "100";
			document.getElementById("QuePoE").value = "0";
					
		}
	});
}

function rechazaenvio(a){
	var obs = document.getElementById('obs').value;
	var obst = document.getElementById('obs').length;

	if(obst < 1){
		
		createCookie('jAlertT','14000',1);
		jConfirm("No ha ingresado una descripci&oacute;n, ¿Desea continuar? ", "Debo Retail - Global Business Solution", function(r){
			if(r == true ){

				$('#Bloquear').fadeIn(500);
				
				SoloNone("BotonesLet1, BotonesLet2");
				SoloBlock("BotonesLet3");
			
				document.getElementById("YaFac").value = 3;
				document.getElementById('pantallacompra').value = 3;
				
				var obs2 = ReplaceAll(obs," ","+");
			
				$("#archivos").load("ComAutPro.php?ban=2&obs="+obs2+"&ti="+'<? echo $ti; ?>'+"&tc="+'<? echo $tc; ?>'+"&su="+<? echo $su; ?>+"&nc="+<? echo $nc; ?>+"");
			
						
			}
		});
	}else{

		$('#Bloquear').fadeIn(500);
		
		SoloNone("BotonesLet1, BotonesLet2");
		SoloBlock("BotonesLet3");
	
		document.getElementById("YaFac").value = 3;
		document.getElementById('pantallacompra').value = 3;
		
		var obs2 = ReplaceAll(obs," ","+");
	
		$("#archivos").load("ComAutPro.php?ban=2&obs="+obs2+"&ti="+'<? echo $ti; ?>'+"&tc="+'<? echo $tc; ?>'+"&su="+<? echo $su; ?>+"&nc="+<? echo $nc; ?>+"");
		
	}
}

function volverenvio(){
	$("#rechazado").fadeOut(500);
	
	$("#ComAutAce").fadeIn(500);
	
	SoloBlock("FondoCompraAuto1, DetalleParaBotones1, todos, botonComprasS1, botonComprasS2, botonRechazar, BotonesLet3, BotonesLet2, cabecera");

	SoloNone("BotonesLet1, Teclado_Completo, NumVol, rechazado, botonAutorizar, LetTer, LetSal, Marca");

	EnvAyuda2("Seleccione los &iacute;tems verificados.Luego autorice el Comprobante.");
}




</script>
</head>
<body>

<!-- BOTON PARA INGRESAR A COMPRAS AUTOMATICAS - FRANCO -->
<div id="botonComprasS1" style="position:absolute; top:416px; left:32px; display:block; z-index:3;">
    <button class="StyBoton" onClick="cominicio();" onMouseOut="MM_swapImgRestore()" onMouseOver="MM_swapImage('BotComAutV','','botones/com-vol-over.png',0)" title="Volver a Compras">
    <img src="botones/com-vol-up.png" border="0" id="BotComAutV"/></button>
</div>

<div id="botonComprasS2" style="position:absolute;  top:416px; left:134px; display:block; z-index:3;">
    <button class="StyBoton" onClick="comlista();" onMouseOut="MM_swapImgRestore()" onMouseOver="MM_swapImage('BotComAutVC','','botones/vol-over.png',0)" title="Volver Comprobantes">
    <img src="botones/vol-up.png" border="0" id="BotComAutVC"/></button>
</div>

<div id="botonRechazar" style="position:absolute;  top:416px; left:334px; display:block; z-index:3;">
    <button class="StyBoton" onClick="rechazar();" onMouseOut="MM_swapImgRestore()" onMouseOver="MM_swapImage('BotComAutRe','','botones/com-rec-over.png',0)" title="Rechazar">
    <img src="botones/com-rec-up.png" border="0" id="BotComAutRe"/></button>
</div>

<div id="botonAutorizar" style="position:absolute;  top:416px; left:436px; display:none; z-index:3;">
    <button class="StyBoton" onClick="autorizar();" onMouseOut="MM_swapImgRestore()" onMouseOver="MM_swapImage('BotComAutAu','','botones/com-aut-over.png',0)" title="Autorizar">
    <img src="botones/com-aut-up.png" border="0" id="BotComAutAu"/></button>
</div>

<div id="BotComAce1" style=" position:absolute; top:235px; left:320px; z-index:4;"></div>


<!-- BOTON PARA SELECCIONAR TODOS LOS ITEMS -->

<div id="todos" style="position:absolute; top:68px; left:586px; display:none;">

    <div id="todosOff" style=" position:absolute; top:0px; left:113px; z-index:3;">
        <div style="position:absolute; top:22px; left:-117px;">
            <img src="Compras/comaut/bottodos-over.png" onclick="seltodos(1);" style="cursor:pointer;"/>
        </div>
    </div>
    <div id="todosOn" style="display:none; position:absolute; top:0px; left:113px; z-index:3;">
        <div style="position:absolute; top:22px; left:-117px;" align="center">
            <img src="Compras/comaut/bottodos-up.png" onclick="seltodos(2);" style="cursor:pointer;"/>
        </div>
    </div>

</div>


<!-- CABECERA DEL COMPROBANTE -->

<div id="cabecera" style="position:absolute; top:69px; left:49px; display:block;">

    <div id="comp" style="position:absolute; top:0px; left:109px; z-index:3; width:210px; font-family: 'TPro'">
		<? echo $proveedor; ?>		
    </div>
    <div id="prov" style="position:absolute; top:0px; left:433px; z-index:3; width:162px; font-family: 'TPro'">
    	<? echo $comprobante; ?>

    </div>

</div>



<div id="FondoCompraAuto1">
	<img src="Compras/comaut/control de compras rechazar.png" />
</div>

<div id="ComAutAce">
	<div id="DetalleParaBotones1">
		<?
	$_SESSION['ParSQL']="SELECT * FROM PMOVFACT_AUTO WHERE tip = '".$ti."' AND tco = '".$tc."' AND suc = ".$su." AND nco = ".$nc." ORDER BY ord";
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
	
		$cod = format($ATU[7],4,'0',STR_PAD_LEFT)." - ".format($ATU[8],4,'0',STR_PAD_LEFT);

		if ($c == 1){
		
			if($s == 1){
				$e = "block";
			}else{
				$e = "none";
			}
		
			echo "<div id=\"capa_nov".$s."\" style=\"display:".$e."\">";
			
			if($s <> 1){
				?>

				<div id="AnteriorNov" style=" position:absolute; top:0px; left:599px;">
					<button class="StyBoton" onclick="movpag_a_nov(<?php echo $s; ?>)" onMouseOut="MM_swapImgRestore()" onMouseOver="MM_swapImage('AnteriorNov<?php echo $s; ?>','','otros/scr_arri-over.png',0)"><img src="otros/scr_arri-up.png" border="0" id="AnteriorNov<?php echo $s; ?>"/></button>
</div>
	
				<?
	
			}
	
			}
	
			?>
		<div class="lineaComsel" id="linea<? echo $cc; ?>" >
				<table width="592" height="26" border="0" cellpadding="0" cellspacing="0" onclick="sel_item(<? echo $total; ?>,<? echo $cc; ?>);" style="cursor:pointer;">
						<tr>
							<td width="83" align="center"><? echo $cod; ?></td>
							<td width="243" align="center"><? echo $ATU[10]; ?></td>
							<td width="71" align="center"><? echo $ATU[12]; ?></td>
							<td width="99" align="center"><? echo dec($ATU[13],2); ?></td>
                            <td width="96" align="center">
                            	<div id="ok<? echo $cc; ?>" style="display:none;"> OK </div>
                            	<div id="check" style="display:none;"> 
		    		            	<input type="checkbox" name="item[]" id="fila<? echo $cc; ?>" >
                                    <input type="hidden" name="cantidad" id="cantidad" value="<? echo $total; ?>" >
                                </div>
							</td>
						</tr>
				</table>

		</div>
			<?
			
			if($c == 10){
			
			?>
			<div id="SiguienteNov" style="position:absolute; top:260px;  left:599px;">
				<button class="StyBoton" onclick="return movpag_b_nov(<?php echo $s; ?>);" onMouseOut="MM_swapImgRestore()" onMouseOver="MM_swapImage('SiguienteNov<?php echo $s; ?>','','otros/scr_aba-over.png',0)"><img src="otros/scr_aba-up.png" border="0" id="SiguienteNov<?php echo $s; ?>"/></button>
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
		$("#SiguienteNov<?php echo $s-1; ?>").fadeOut('fast');
    </script>
	<?
}
?>
</div>


</div>


<div id="rechazado" style="position:absolute; top:31px; left:180px; display:none;">
	
	<div style="position:absolute; top:-21px; left:81px; z-index:3; width:210px; font-family: 'TPro'">
        <? echo $proveedor; ?>		
    </div>
    
    <div style="position:absolute; top:5px; left:87px; z-index:3; width:162px; font-family: 'TPro'">
        <? echo $comprobante; ?>

    </div>
    
    <div style="position:absolute; top:-31px; left:-23px;">
		<img src="Compras/comaut/observaciones.png"/>
    </div>
    
    <div id="rechazadetalle" style="position:absolute; top:49px; left:3px; font-family: 'TPro';">
        <textarea class="det-obs" id="obs" name="obs" style=" width:273px; height:128px; font-family: 'TPro'; background-color:transparent; border:0;" />
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