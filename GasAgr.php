<?
require("config/cnx.php");

try {////////////////////////////////////////////////////////////////////////////////////////////////// COMIENZO TRY //

mssql_query("begin transaction",$conexion) or die("Error SQL begin trans");

?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Gastos Formulario</title>


<style type="text/css">
#descripcion {
	background-color:#DD7927;
	border:0; 
	width:260px; 
	height:17px;
}

.fon-gas{
	font-family: "TPro";
	font-size:12px;
	position:absolute;
	height:16px;

}


</style>

<script>
$(document).ready(function(){
	$('#formgas').submit(function(){
        $.ajax({
            type: 'POST',
            url: $(this).attr('action'),
            data: $(this).serialize(),
            success: function(data){
            $('#archivos').html(data);	
            }
        })
        return false;
    });
})

$("#des").css("border-color", "#F90");

SoloBlock("LetSal, fondotranspletras, TecladoLet, fondotranspnumeros, TecladoNum, LetEnt, NumVol");
SoloNone('LetTer, Marca');

EnvAyuda("Presione Enter para listar los gastos.");

document.onkeydown = function(){

	if(window.event){
		
		if(window.event.keyCode == 13){
			
			if($('#agregargasto').length){
				
				siguiente_gas();
				
			}
			
		}
		
	}
	
}

function salir_gas(){
	
	SoloNone("fondotranspletras, fondotranspnumeros, TecladoNum, LetTer, CarAyuda, CarAyudaFon, TecladoLet, LetSal, LetEnt, NumVol");
	
	$('#Gastos').fadeOut(500);
	$("#Gastos").load("Gastos.php");
	$('#Gastos').fadeIn(500);
}

function siguiente_gas(){
	
	var des = document.getElementById("idtipogas").value;
	if(des == 0){

		buscagasto();

	}else{

		$("#obsgas").css("border-color", "#F90");
		$("#des").css("border-color", "transparent");

		EnvAyuda("Ingrese una observaci&oacute;n.");

		document.getElementById("DondeE").value = "obs";
		document.getElementById("CantiE").value = "100";
		document.getElementById("QuePoE").value = "0";
		
		controlarcadainputche('obs');
		$('#obs').focus();
		
		document.getElementById('LetEnt').innerHTML = '<button id="BotLetEntFac" onclick="siguiente_gas1();" class="StyBoton" onmouseout="MM_swapImgRestore()" onmouseover="MM_swapImage(\'LetEntFac\',\'\',\'botones/ent-over.png\',0)"><img src="botones/ent-up.png" name="Enter" title="Enter" border="0" id="LetEntFac"/></button>';

		document.getElementById('NumVol').innerHTML = '<button id="LetVolGas" onclick="volver_gas1();" class="StyBoton" onmouseout="MM_swapImgRestore()" onmouseover="MM_swapImage(\'LetVolGas\',\'\',\'botones/vol-over.png\',0)"><img src="botones/vol-up.png" name="Volver" title="Volver" border="0" id="LetVolGas"/></button>';
	}
}


function siguiente_gas1(){

	var retco = document.getElementById("obs").value.length;
	if(retco == 0){

		jAlert('Debes completar las Observaciones.', 'Debo Retail - Global Business Solution');

	}else{

		$("#tot").css("border-color", "#F90");
		$("#obsgas").css("border-color", "transparent");		

		EnvAyuda("Ingrese un total");

		document.getElementById("DondeE").value = "totalgas";
		document.getElementById("CantiE").value = "7";
		document.getElementById("QuePoE").value = "1";

		document.getElementById('LetEnt').innerHTML = '<button id="BotLetEntFac" onclick="siguiente_2gas();" class="StyBoton" onmouseout="MM_swapImgRestore()" onmouseover="MM_swapImage(\'LetEntFac\',\'\',\'botones/ent-over.png\',0)"><img src="botones/ent-up.png" name="Enter" title="Enter" border="0" id="LetEntFac"/></button>';

		document.getElementById('NumVol').innerHTML = '<button id="LetVolGas" onclick="volver_gas2();" class="StyBoton" onmouseout="MM_swapImgRestore()" onmouseover="MM_swapImage(\'LetVolGas\',\'\',\'botones/vol-over.png\',0)"><img src="botones/vol-up.png" name="Enter" title="Enter" border="0" id="LetVolGas"/></button>';
		
		controlarcadainputche('totalgas');
		$('#totalgas').focus();
	}
}


function volver_gas1(){
	
	$("#obsgas").css("border-color", "transparent");	
	$("#des").css("border-color", "#F90");	
	
	$('#des').attr('onclick', 'buscagasto();');
	
	EnvAyuda("Seleccione una Descripción de la lista");
	
	document.getElementById('LetEnt').innerHTML = '<button id="BotLetEntFac" onclick="siguiente_gas();" class="StyBoton" onmouseout="MM_swapImgRestore()" onmouseover="MM_swapImage(\'LetEntFac\',\'\',\'botones/ent-over.png\',0)"><img src="botones/ent-up.png" name="Enter" title="Enter" border="0" id="LetEntFac"/></button>';
	
	document.getElementById('NumVol').innerHTML = '<button id="LetVolGas" onclick="salir_gas();" class="StyBoton" onmouseout="MM_swapImgRestore()" onmouseover="MM_swapImage(\'LetVolGas\',\'\',\'botones/vol-over.png\',0)"><img src="botones/vol-up.png" name="Volver" title="Volver" border="0" id="LetVolGas"/></button>';
	
	document.getElementById("DondeE").value = "obs";
	document.getElementById("CantiE").value = "60";
	document.getElementById("QuePoE").value = "0";
	
	controlarcadainputche('obs');
	$('#obs').focus();
	
}

function siguiente_2gas(){
	
	var totam = document.getElementById("totalgas").value.length;
	if(totam == 0){
		jAlert('Debes completar el total.', 'Debo Retail - Global Business Solution');
	}else{
		var totco = document.getElementById("totalgas").value;
		if(totco < 0){
			jAlert('El importe ingresado debe ser mayor o igual a cero.', 'Debo Retail - Global Business Solution');
		}else{

			var ret = document.getElementById("totalgas").value;
			document.getElementById("totalgas").value = dec(ret.replace(",","."));

			SoloNone("LetEnt");
			SoloBlock("LetTer");

			$("#tot").css("border-color", "transparent");		

			EnvAyuda("Presione Terminar para Agregar el Gasto");
			
			document.getElementById("DondeE").value = "LetTex";
			document.getElementById("CantiE").value = "0";
			document.getElementById("QuePoE").value = "0";	
			
			$('#LetTer').focus();
			
			document.getElementById('LetTer').innerHTML = '<button id="LetTerGas" onclick="siguiente_gas3();" class="StyBoton" onmouseout="MM_swapImgRestore()" onmouseover="MM_swapImage(\'LetTerGas\',\'\',\'botones/ter-over.png\',0)"><img src="botones/ter-up.png" name="Terminar" title="Terminar" border="0" id="LetTerGas"/></button>';
	
			document.getElementById('NumVol').innerHTML = '<button id="LetVolGas" onclick="volver_gas3();" class="StyBoton" onmouseout="MM_swapImgRestore()" onmouseover="MM_swapImage(\'LetVolGas\',\'\',\'botones/vol-over.png\',0)"><img src="botones/vol-up.png" name="Enter" title="Enter" border="0" id="LetVolGas"/></button>';
		}
	}
}

function volver_gas2(){

	$("#obsgas").css("border-color", "#F90");
	$("#tot").css("border-color", "transparent");		
	
	EnvAyuda("Ingrese una descripción");
	
	controlarcadainputche('obs');
	$('#obs').focus();
	
	document.getElementById("DondeE").value = "obs";
	document.getElementById("CantiE").value = "60";
	document.getElementById("QuePoE").value = "0";
		
	document.getElementById('LetEnt').innerHTML = '<button id="BotLetEntFac" onclick="siguiente_gas1();" class="StyBoton" onmouseout="MM_swapImgRestore()" onmouseover="MM_swapImage(\'LetEntFac\',\'\',\'botones/ent-over.png\',0)"><img src="botones/ent-up.png" name="Enter" title="Enter" border="0" id="LetEntFac"/></button>';
	
	document.getElementById('NumVol').innerHTML = '<button id="LetVolGas" onclick="volver_gas1();" class="StyBoton" onmouseout="MM_swapImgRestore()" onmouseover="MM_swapImage(\'LetVolGas\',\'\',\'botones/vol-over.png\',0)"><img src="botones/vol-up.png" name="Volver" title="Volver" border="0" id="LetVolGas"/></button>';
	

	
}

function volver_gas3(){
	
	SoloNone("LetTer");
	SoloBlock("LetEnt");
	
	$("#tot").css("border-color", "#F90");
	
	EnvAyuda("Ingrese un total");

	document.getElementById("DondeE").value = "totalgas";
	document.getElementById("CantiE").value = "7";
	document.getElementById("QuePoE").value = "1";

	document.getElementById('LetEnt').innerHTML = '<button id="BotLetEntFac" onclick="siguiente_2gas();" class="StyBoton" onmouseout="MM_swapImgRestore()" onmouseover="MM_swapImage(\'LetEntFac\',\'\',\'botones/ent-over.png\',0)"><img src="botones/ent-up.png" name="Enter" title="Enter" border="0" id="LetEntFac"/></button>';

	document.getElementById('NumVol').innerHTML = '<button id="LetVolGas" onclick="volver_gas2();" class="StyBoton" onmouseout="MM_swapImgRestore()" onmouseover="MM_swapImage(\'LetVolGas\',\'\',\'botones/vol-over.png\',0)"><img src="botones/vol-up.png" name="Enter" title="Enter" border="0" id="LetVolGas"/></button>';
	
	controlarcadainputche('totalgas');
	$('#totalgas').focus();
	
}

function buscagasto(){

	SoloBlock("fondodescgas, fondodescgasimg, descpidetipogas");
	$('#descpidetipogas').load('GasAgrDes.php');
	
}

function siguiente_gas3(){
	
	$('#formgas').submit();
	
}

/****************************************************************************************************/
/****************************************************************************************************/
/****************************************************************************************************/

$('#tipogas').focus();

function Controlobs(){
	
	if(document.getElementById("obs").value.length >= 250){ return false; }
	
	var k = window.event.keyCode;
	if(!((k == 32) || (k == 13) || ((k >= 65) && (k <= 90)) || ((k >= 97) && (k <= 122)))){
		return false;
	}
	if(k == 13){
		siguiente_gas1();
		return false;
	}
	
}

function ControlobsVol(){
		
	var k = window.event.keyCode;
	if(k == 27){
		buscagasto();
		return false;
	}
	
}

function Controltotalgas(){
	
	var k = window.event.keyCode;
	if(!((k == 46) || (k == 13) || ((k >= 48) && (k <= 57)))){
		return false;
	}
	if(k == 13){
		siguiente_2gas();
		return false;
	}
	
}

var controldepaso = 0;
function ControltotalgasVol(){
	
	var k = window.event.keyCode;
	if(k == 27){
		if(document.getElementById('tot').style.borderColor == "transparent"){
			volver_gas3();
			return false;
		}else{
			volver_gas2();
			return false;
		}
	}	
	if(k == 113){
		if(controldepaso == 0){
			if($('#LetTer').css('display') == 'block'){
				controldepaso = 1;
				siguiente_gas3();
			}
		}
	}
}









function controlarcadainputche(cu){

var ii = new Array();

ii[0] = "tipogas";
ii[1] = "totalgas";
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


<div id="agregargasto" style="position:absolute; left:90px; top:-27px;"><img src="CargaGastos/agregar_gastos.png" /></div>

<form method="post" name="formgas" id="formgas" action="GasAgrN.php">

<div id="agregaritem" style="z-index:0; position:absolute;">
	
	<div class="fon-gas" style="position:absolute; left:185px; top:20px;"><? echo $_SESSION['idsusua']; ?></div>
	<div class="fon-gas" style="position:absolute; left:185px; top:42px; width:200px;" align="left"><? echo $_SESSION['idsusun']; ?></div>
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
	while ($reg=mssql_fetch_array($registros)){ $PLA = $reg['PLA']; }
	
	$NCO = 1;
	//buscar el proximo numero disponible
	$_SESSION['ParSQL'] = "SELECT ISNULL(MAX(NCO) + 1,1) AS NCO FROM PMAEFACT WHERE TCO='CI' AND TIP='B' AND SUC = ".$_SESSION['ParPV'].""; 
	$R1TB1 = mssql_query($_SESSION['ParSQL']) or die("Error SQL");
	rollback($R1TB1);
	while ($R31=mssql_fetch_array($R1TB1)){ $NCO = $R31['NCO']; }
	?>
	
    <div class="fon-gas" style="position:absolute; left:185px; top:102px;"><? echo $NCO; ?></div>
    <div id="FecAct" class="fon-gas" style="position:absolute; left:165px; top:123px; width:129px;" align="center"><? echo date("d-m-Y H:i"); ?></div>		
	<div class="fon-gas" style="position:absolute; left:315px; top:102px;"><? echo $PLA;?></div>	
	
	<div id="obsgas" class="div-redondo" style="position:absolute; left:407px; top:40px; width:211px; height:177px;">
		<textarea class="fon-gas" id="obs" name="obs" readonly="readonly" style="outline-style:none; border-style:none; width:203px; height:175px; background-color:transparent; text-transform:uppercase;" onkeypress="return Controlobs();" onkeydown="return ControlobsVol();" maxlength="60" />
	</div>

	<div id="des" class="div-redondo" style="position:absolute; top:252px; left:109px; width:274px; height:16px;">
		<input type="hidden" name="idtipogas" id="idtipogas">
		<input type="text" name="tipogas" id="tipogas" onclick="buscagasto();" readonly="readonly" style="background-color:#DD7927; font-family: 'TPro'; cursor:pointer; width:250px; height:13px; border:0; text-align:center;" value="&lt;ELEGIR UNA DESCRIPCION&gt;">
	</div>
    
	<div id="fondodescgas" style="position:absolute; width:667px; height:479px; z-index:1; display:none;"></div>
	<div id="fondodescgasimg" style="position:absolute; top:62px; left:214px; display:none; z-index:2;">
		<img src="CargaGastos/fon-der.png" />
	</div>
    
	<div id="descpidetipogas" class="fon-gas" style="position:absolute; top:62px; left:214px; display:none; z-index:2;"></div>

	<div id="tot" class="div-redondo" style="position:absolute; left:405px; top:253px; width:216px; height:16px;">
    
	<input class="fon-gas" type="text" id="totalgas" readonly="readonly" name="totalgas" style="outline-style:none; border-style:none; background-color:transparent; text-align:right; width:211px; height:16px;" maxlength="11" onkeypress="return Controltotalgas();" onkeydown="return ControltotalgasVol();" />
    
	</div>

</div>
</form>

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
</body>
</html>