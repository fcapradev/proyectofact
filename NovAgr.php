<?
require("config/cnx.php");

try {////////////////////////////////////////////////////////////////////////////////////////////////// COMIENZO TRY //

mssql_query("begin transaction",$conexion) or die("Error SQL begin trans");

?>


<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Agregar Novedades</title>

<style>
.det-obs{
	font-family: "TPro";
	font-size:12px;
	position:absolute;
	height:16px;
}
#divs {
	background-color:#DD7927;
	border:0; 
	width:260px; 
	height:17px;
	font-family: "TPro";
}

#tipo {
	background-color:#DD7927;
	border:0; 
	width:260px; 
	height:17px;
	font-family: "TPro";
}
#des {
	background-color:#DD7927;
	border:0;
	width:260px;
	font-family: "TPro";
}

</style>

<script>

$(document).ready(function(){
	$('#formnov').submit(function(){
        $.ajax({
            type: 'POST',
            url: $(this).attr('action'),
            data: $(this).serialize(),
            success: function(data){
            $('#archivos').html(data);
			
			vol_nov();			
            }
        })
        return false;
    });
})

SoloBlock('Marca, fondotranspletras, TecladoLet, fondotranspnumeros, TecladoNum, LetEnt, NumVol, LetSal');
SoloNone('LetTer');

EnvAyuda("Presione Enter para buscar un tipo de Novedad.");

$("#tipodiv").css("border-color", "#F90");

document.getElementById("DondeE").value = "LetTex";
document.getElementById("CantiE").value = "0";
document.getElementById("QuePoE").value = "0";

function vol_nov(){

	SoloNone("fondotranspletras, fondotranspnumeros, TecladoNum, LetTer, CarAyuda, CarAyudaFon, TecladoLet, LetEnt");

	$("#Novedades").fadeOut(500);

	$("#Novedades").load("Novedades.php");

	$("#Novedades").fadeIn(500);
}
	
function siguiente_nov(){
	var idtipo = document.getElementById("idtipo").value;
	
	document.getElementById("idtipo").value = "";
	buscatip();

	document.getElementById('LetEnt').innerHTML = '<button id="BotLetEntFac" onclick="siguiente_nov1();" class="StyBoton" onmouseout="MM_swapImgRestore()" onmouseover="MM_swapImage(\'LetEntFac\',\'\',\'botones/ent-over.png\',0)"><img src="botones/ent-up.png" name="Enter" title="Enter" border="0" id="LetEntFac"/></button>';
	
	document.getElementById('NumVol').innerHTML = '<button id="LetVolNov" onclick="volver_nov1();" class="StyBoton" onmouseout="MM_swapImgRestore()" onmouseover="MM_swapImage(\'LetVolNov\',\'\',\'botones/vol-over.png\',0)"><img src="botones/vol-up.png" name="Volver" title="Volver" border="0" id="LetVolNov"/></button>';
}
	
function siguiente_nov1(){
	var iddesc = document.getElementById("iddesc").value;
	
	document.getElementById("iddesc").value = "";
	buscades();
	
	document.getElementById('LetEnt').innerHTML = '<button id="BotLetEntFac" onclick="siguiente_nov2();" class="StyBoton" onmouseout="MM_swapImgRestore()" onmouseover="MM_swapImage(\'LetEntFac\',\'\',\'botones/ent-over.png\',0)"><img src="botones/ent-up.png" name="Enter" title="Enter" border="0" id="LetEntFac"/></button>';
	
	document.getElementById('NumVol').innerHTML = '<button id="LetVolNov" onclick="volver_nov2();" class="StyBoton" onmouseout="MM_swapImgRestore()" onmouseover="MM_swapImage(\'LetVolNov\',\'\',\'botones/vol-over.png\',0)"><img src="botones/vol-up.png" name="Volver" title="Volver" border="0" id="LetVolNov"/></button>';
}

function volver_nov1(){
	
	$("#tipodiv").css("border-color", "#F90");
	$("#desdiv").css("border-color", "transparent");
	
	$('#tipo').attr('onclick', 'buscatip();');
	
	$("#tipo").focus();
	controlarcadainputche("tipo");
	
	EnvAyuda("Presione Enter para buscar un tipo de Novedad.");
	
	document.getElementById('LetEnt').innerHTML = '<button id="BotLetEntFac" onclick="siguiente_nov();" class="StyBoton" onmouseout="MM_swapImgRestore()" onmouseover="MM_swapImage(\'LetEntFac\',\'\',\'botones/ent-over.png\',0)"><img src="botones/ent-up.png" name="Enter" title="Enter" border="0" id="LetEntFac"/></button>';
	
	document.getElementById('NumVol').innerHTML = '<button id="LetVolNov" onclick="volver_nov1();" class="StyBoton" onmouseout="MM_swapImgRestore()" onmouseover="MM_swapImage(\'LetVolNov\',\'\',\'botones/vol-over.png\',0)"><img src="botones/vol-up.png" name="Volver" title="Volver" border="0" id="LetVolNov"/></button>';

}
	
function siguiente_nov2(){
	var tip = document.getElementById("idtipo").value;
	if(tip <= 0){
		
		jAlert('Debes seleccionar un Tipo de Novedad.', 'Debo Retail - Global Business Solution');

	}else{

		EnvAyuda("CLICK en Descripción de la Novedad para seleccionar una opción");

		var desc = document.getElementById("iddesc").value;

		if(desc <= 0){

			jAlert('Debes seleccionar una Descripción.', 'Debo Retail - Global Business Solution');

		}else{

			$(document).ready(function(){
				$('#tipo').change(function(event){

				var id = $('#tipo').find(':selected').val();
				$('#descripcion').load('NovSel.php?id='+id);

				});
			});

		EnvAyuda("Ingrese una Observaci&oacute;n y presione ENTER");	

		var obs = document.getElementById("obs").value.length;

			if(obs <= 0 || obs > 300){

				jAlert('Debes completar con una observaci&oacute;n o has superado el l&iacute;mite m&aacute;ximo.', 'Debo Retail - Global Business Solution');

			}else{

				$("#texto").css("border-color", "transparent");	
				
				EnvAyuda("Presione Enter para Finalizar.");	
				
				//$("#obs").blur();
				
				SoloNone("LetEnt");
				SoloBlock("LetTer");
				
				document.getElementById('LetTer').innerHTML = '<button id="LetTerNov" onclick="siguiente_nov3();" class="StyBoton" onmouseout="MM_swapImgRestore()" onmouseover="MM_swapImage(\'LetTerNov\',\'\',\'botones/ter-over.png\',0)"><img src="botones/ter-up.png" name="Terminar" title="Terminar" border="0" id="LetTerNov"/></button>';

				document.getElementById('NumVol').innerHTML = '<button id="LetVolNov" onclick="volver_nov3();" class="StyBoton" onmouseout="MM_swapImgRestore()" onmouseover="MM_swapImage(\'LetVolNov\',\'\',\'botones/vol-over.png\',0)"><img src="botones/vol-up.png" name="Volver" title="Volver" border="0" id="LetVolNov"/></button>';
			}
		}	
	}
}
	
function volver_nov2(){

	$("#desdiv").css("border-color", "#F90");
	$("#texto").css("border-color", "transparent");

	$('#des').attr('onclick', 'buscades();');
	
	$("#des").focus();
	controlarcadainputche("des");
	
	document.getElementById('LetEnt').innerHTML = '<button id="BotLetEntFac" onclick="siguiente_nov1();" class="StyBoton" onmouseout="MM_swapImgRestore()" onmouseover="MM_swapImage(\'LetEntFac\',\'\',\'botones/ent-over.png\',0)"><img src="botones/ent-up.png" name="Enter" title="Enter" border="0" id="LetEntFac"/></button>';
	
	document.getElementById('NumVol').innerHTML = '<button id="LetVolNov" onclick="volver_nov1();" class="StyBoton" onmouseout="MM_swapImgRestore()" onmouseover="MM_swapImage(\'LetVolNov\',\'\',\'botones/vol-over.png\',0)"><img src="botones/vol-up.png" name="Volver" title="Volver" border="0" id="LetVolNov"/></button>';
	
	EnvAyuda("Presione Enter para buscar una Descripci&oacute;n.");
}

function siguiente_nov3(){
	$('#formnov').submit();	
}

function volver_nov3(){
	
	$("#texto").css("border-color", "#F90");
	$("#obs").focus();
	controlarcadainputche("obs");
	
	SoloNone("LetTer");
	SoloBlock("LetEnt");
	
	document.getElementById('LetEnt').innerHTML = '<button id="LetEntNov" onclick="siguiente_nov2();" class="StyBoton" onmouseout="MM_swapImgRestore()" onmouseover="MM_swapImage(\'LetEntNov\',\'\',\'botones/ent-over.png\',0)"><img src="botones/ent-up.png" name="Terminar" title="Terminar" border="0" id="LetEntNov"/></button>';
	
	document.getElementById('NumVol').innerHTML = '<button id="LetVolNov" onclick="volver_nov2();" class="StyBoton" onmouseout="MM_swapImgRestore()" onmouseover="MM_swapImage(\'LetVolNov\',\'\',\'botones/vol-over.png\',0)"><img src="botones/vol-up.png" name="Volver" title="Volver" border="0" id="LetVolNov"/></button>';
}

///////////BUSCA EL SELECT////////////
function buscatip(){
	SoloBlock("fondopidetipo, descpidetipo, fondogeneral");
	$('#descpidetipo').load('NovSelTipo.php');
}

function buscades(){
	document.getElementById("fondopidetipo").style.display = "block";
	document.getElementById("descpidetipo").style.display = "block";
	document.getElementById("fondogeneral").style.display = "block";
	var tip = document.getElementById("idtipo").value;
	$('#descpidetipo').load("NovSelDes.php?d="+tip+"");
}



/****************************************************************************************************/
/****************************************************************************************************/
/****************************************************************************************************/

$('#tipo').focus();
$("#des").removeAttr("onclick");

function ControlTipoNov(){
	
	if(document.getElementById("tipodiv").style.borderColor == 'transparent'){
		return false;
	}	
	var k = window.event.keyCode;

	if(k == 13){
		siguiente_nov();
	}else{
		return false;	
	}
	
}

function ControlTipoNovVol(){
	
	if(document.getElementById("desdiv").style.borderColor == 'transparent'){
		return false;
	}	
	var k = window.event.keyCode;
	if(k == 27){
		volver_nov1();
	}

}

function ControlDesNov(){

	if(document.getElementById("desdiv").style.borderColor == 'transparent'){
		return false;
	}	
	var k = window.event.keyCode;
	if(k == 13){
		siguiente_nov1();
	}else{
		return false;	
	}
	
}

function ControlDesNovVol(){
	if(document.getElementById("texto").style.borderColor == 'transparent'){
		return false;
	}	
	var k = window.event.keyCode;
	if(k == 27){
		volver_nov2();
	}

}

function ControlTexNov(){

	if(document.getElementById("obs").value.length >= 250){ return false; }
	if(document.getElementById("texto").style.borderColor == 'transparent'){return false; }		
	
	var k = window.event.keyCode;
	if(!((k == 32) || (k == 13) || ((k >= 65) && (k <= 90)) || ((k >= 97) && (k <= 122)))){
		return false;
	}
	if(k == 13){
		siguiente_nov2();
	}

}

var controldepaso = 0;
function ControlTexNovVol(){

	var k = window.event.keyCode;
	if(k == 27){
		if(document.getElementById('texto').style.borderColor == "transparent"){
			volver_nov3();
			return false;
		}else{
			volver_nov2();
			return false;
		}
	}	
	if(k == 113){
		if(controldepaso == 0){
			if($('#LetTer').css('display') == 'block'){
				controldepaso = 1;
				siguiente_nov3();
			}
		}
	}
}

function controlarcadainputche(cu){

	var ii = new Array();
	
	ii[0] = "tipo";
	ii[1] = "des";
	ii[2] = "obs";
	
	var nunii = ii.length;
	
	for(k = 0; k < nunii; k++){
		
		if(ii[k] == cu){
			$("#"+ii[k]).removeAttr("readonly");	
		}else{
			$("#"+ii[k]).attr("readonly", "readonly");
		}
		
	}

}

</script>
</head>

<body>

<div id="FondoAgregar" style="position:absolute; top:20px; left:70px;">
	<img src="Novedades/agregar novedades.png" />
</div>

<div id="FondoAgregarNegro" style="position:absolute; top:20px; left:70px; z-index:-2;">
	<img src="Novedades/fondo negro.png" />
</div>


<div id="DetalleAgregar" style="position:absolute; top:20px; left:70px;">

<form method="post" action="NovAgrN.php" name="fornov" id="formnov">

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

	$OPE = $_SESSION['idsusua'];
	$NOM = $_SESSION['idsusun'];
?>

	<div id="divs" style="position:absolute; top:33px; left:77px; width:205px;" align="center"><? echo $OPE; ?></div>
	<div id="divs" style="position:absolute; top:55px; left:77px; width:205px;" align="center"><? echo $NOM; ?></div>	
	<div id="divs" style="position:absolute; top:77px; left:77px; width:205px;" align="center"><? echo $PLA; ?></div>

	
	
	<div id="tipodiv" class="div-redondo" style="position:absolute; top:133px; left:12px; width: 274px; height:16px;">
		<input type="hidden" name="idtipo" id="idtipo" />
		<input type="text" name="tipo" id="tipo" onclick="buscatip();" style="cursor:pointer; background-color:transparent; top:0px; left:2px; text-align:center; outline-style:none; border-style:none;" value="<SELECCIONE UN TIPO>" onkeypress="return ControlTipoNov();"/>
		
	</div>
	<div id="fondogeneral" style="position:absolute; width:600px; height:800px; z-index:1; display:none;"></div>
	<div id="fondopidetipo" style="position:absolute; top:-25px; left:58px; display:none; z-index:2;">
		<img src="otros/fon-der.png" />
	</div>
	<div id="descpidetipo" style="position:absolute; top:-25px; left:58px; display:none; z-index:2;"></div>
	<div id="cruz" style="position:absolute; top:-25px; left:493px; display:none; z-index:2;">
	<button class="StyBoton" onclick="sacatipos();" onmouseout="MM_swapImgRestore()" onmouseover="MM_swapImage('BotSal','','otros/cru-over.png',0)"><img src="otros/cru-up.png" name="Salir" title="Salir" border="0" id="BotSal"/></button>
</div>
    
    
	<div id="desdiv" class="div-redondo" style="position:absolute; top:193px; left:12px; width:274px; height:16px;">
		<input type="hidden" name="iddesc" id="iddesc" />
		<input type="text" name="des" id="des" onclick="buscades();" readonly="readonly" style="cursor:pointer; background-color:transparent; top:0px; left:2px; text-align:center; outline-style:none; border-style:none;" value="<SELECCIONE UNA DESCRIPCION>" onkeypress="return ControlDesNov();" onkeydown="return ControlTipoNovVol();"/>
    </div>


	<div id="texto" class="div-redondo" style="position:absolute; top:50px; left:312px; width:275px; height:130px;-webkit-border-radius: 11px; font-family: "TPro"">
		<textarea class="det-obs" id="obs" name="obs" readonly="readonly" style=" width:272px; height:130px; background-color:transparent; border:0; outline-style:none; border-style:none; text-transform:uppercase;" onkeypress="return ControlTexNov();" onkeydown="return ControlTexNovVol();"  maxlength="60" />
	</div>

</form>
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