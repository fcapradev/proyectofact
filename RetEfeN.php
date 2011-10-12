<?
require("config/cnx.php");

try {////////////////////////////////////////////////////////////////////////////////////////////////// COMIENZO TRY //

mssql_query("begin transaction",$conexion) or die("Error SQL begin trans");

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

//BUSCAR EL NUMERO DE LA PROXIMA RENDICION --> TIENE QUE HACERLO AL INGRESAR Y AL CONFIRMAR
$_SESSION['ParSQL'] = "SELECT isnull(MAX(NUM) + 1,1) AS NCO FROM ATURRPA WHERE PLA=".$pla_ver.""; 
$R1TB = mssql_query($_SESSION['ParSQL']) or die("Error SQL");
rollback($R1TB);
while ($RB1=mssql_fetch_array($R1TB)){
	$nco_var = $RB1['NCO'];
}

if(isset($_REQUEST['ban'])){
	if($_REQUEST['ban'] == 1){
		?>
        <script>
        	SoloBlock("RetirosAgregar");
			SoloNone("ValesAgregar");
			document.getElementById("tipo").value = 1;
			
			SoloBlock("LetSal");
			
			document.getElementById("DondeE").value = "retiro";
			document.getElementById("CantiE").value = "8";
			document.getElementById("QuePoE").value = "1";
			
			document.getElementById('LetSal').innerHTML = '<button class="StyBoton" onclick="salir_ret();" onmouseout="MM_swapImgRestore()" onmouseover="MM_swapImage(\'LetSalRetE\',\'\',\'botones/sal-over.png\',0)"><img src="botones/sal-up.png" name="Volver" title="Volver" border="0" id="LetSalRetE"/></button>';
			
			document.getElementById('LetEnt').innerHTML = '<button id="BotLetEntFac" onclick="siguiente();" class="StyBoton" onmouseout="MM_swapImgRestore()" onmouseover="MM_swapImage(\'LetEntFac\',\'\',\'botones/ent-over.png\',0)"><img src="botones/ent-up.png" name="Enter" title="Enter" border="0" id="LetEntFac"/></button>';
			
			document.getElementById('NumVol').innerHTML = '<button id="LetVolRet" onclick="salir_ret();" class="StyBoton" onmouseout="MM_swapImgRestore()" onmouseover="MM_swapImage(\'LetVolRet\',\'\',\'botones/vol-over.png\',0)"><img src="botones/vol-up.png" name="Volver" title="Volver" border="0" id="LetVolRet"/></button>';			

		</script>
        <?	
	}else{
		?>
        <script>
        	SoloNone("RetirosAgregar");
			SoloBlock("ValesAgregar");
			document.getElementById("tipo").value = 2;

			SoloBlock("LetSal");
			
			$("#valDiv").css("border-color", "#F90");
			
			EnvAyuda('Ingrese un Operario.');
			
			document.getElementById("DondeE").value = "inp_vale";
			document.getElementById("CantiE").value = "5";
			document.getElementById("QuePoE").value = "6";
			
			document.getElementById('LetSal').innerHTML = '<button class="StyBoton" onclick="salir_ret();" onmouseout="MM_swapImgRestore()" onmouseover="MM_swapImage(\'LetSalRetE\',\'\',\'botones/sal-over.png\',0)"><img src="botones/sal-up.png" name="Volver" title="Volver" border="0" id="LetSalRetE"/></button>';
			
			document.getElementById('LetEnt').innerHTML = '<button id="BotLetEntFac" onclick="selope();" class="StyBoton" onmouseout="MM_swapImgRestore()" onmouseover="MM_swapImage(\'LetEntFac\',\'\',\'botones/ent-over.png\',0)"><img src="botones/ent-up.png" name="Enter" title="Enter" border="0" id="LetEntFac"/></button>';
			
			document.getElementById('NumVol').innerHTML = '<button id="LetVolRet" onclick="salir_ret();" class="StyBoton" onmouseout="MM_swapImgRestore()" onmouseover="MM_swapImage(\'LetVolRet\',\'\',\'botones/vol-over.png\',0)"><img src="botones/vol-up.png" name="Volver" title="Volver" border="0" id="LetVolRet"/></button>';

		</script>
        <?	
	}
}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Retiro de efectivo</title>
<style>

.fon-ret-agr{
	font-family: "TPro";
	font-size:12px;
	position:absolute;
	height:16px;
	color:#FFFFFF;
}

.fon-ret-agr2{
	font-family: "TPro";
	font-size:12px;
	position:absolute;
	height:16px;
	color:#000000;
}

#agregarretiro{ position:absolute;
	top:139px;
	left:120px;
	width:560px;
	height:201;
}

#agregarretirobac{
	position:absolute;
	top:139px;
	left:120px;
	width:560px;
	height:201;
}

.fon-ret-agr2textarea{
	background-color:transparent; 
	font-family: "TPro";
	font-size:12px;
	color:#000000;
	resize:none; 
	width:219px; 
	height:75px; 
	border:0;
	width:230px;;
	height:122px;
}

#ret{
	position:absolute; 
	left:152px; 
	top:83px;
}

#valDiv{
	position:absolute; 
	left:152px; 
	top:83px;
}

#impDiv{
	position:absolute; 
	left:152px; 
	top:107px;
}

#retobs{
	position:absolute; 
	left:307px; 
	top:59px;
	width:234px;
	height: 125px;
}

#antobs{
	position:absolute; 
	left:307px; 
	top:59px;
	width:234px;
	height: 125px;
}

/*
.div-red-nar{
	-webkit-border-radius:15px;
	border-color: transparent;
	border-style:groove;
}
*/
</style>

<script>

$(document).ready(function(){
	$('#retefe').submit(function(){
        $.ajax({
            type: 'POST',
            url: $(this).attr('action'),
            data: $(this).serialize(),
            success: function(data){
            $('#archivos').html(data);
			salir_ret();			
            }
        })
        return false;
    });
	$('#valeform').submit(function(){
        $.ajax({
            type: 'POST',
            url: $(this).attr('action'),
            data: $(this).serialize(),
            success: function(data){
            $('#archivos').html(data);
			salir_ret();			
            }
        })
        return false;
    });	
})

SoloBlock('Marca, fondotranspletras, TecladoLet, fondotranspnumeros, TecladoNum, LetEnt, NumVol');
SoloNone('LetTer');

EnvAyuda("Ingrese el Efectivo");

$("#ret").css("border-color", "#F90");

function salir_ret(){

	$('#RetiroEfectivo').fadeOut(500);

	$("#RetiroEfectivo").load("RetEfe.php?ban=<? echo $_REQUEST['ban']; ?>");

	$('#RetiroEfectivo').fadeIn(500);

	Mos_Ocu('fondotranspletras');
	Mos_Ocu('TecladoLet');
	Mos_Ocu('fondotranspnumeros');
	Mos_Ocu('TecladoNum');
	Mos_Ocu('LetTer');
	SoloNone('CarAyuda');
	SoloNone('CarAyudaFon');
}


///////////////////////////
// DAR FORMATO A NUMEROS //
///////////////////////////

function formato_numero(numero, decimales, separador_decimal, separador_miles){ // v2007-08-06
    numero=parseFloat(numero);
    if(isNaN(numero)){
        return "";
    }
    if(decimales!==undefined){
        // Redondeamos
        numero=numero.toFixed(decimales);
    }

    // Convertimos el punto en separador_decimal
    numero=numero.toString().replace(".", separador_decimal!==undefined ? separador_decimal : ",");

    if(separador_miles){
        // A�adimos los separadores de miles
        var miles=new RegExp("(-?[0-9]+)([0-9]{3})");
        while(miles.test(numero)) {
            numero=numero.replace(miles, "$1" + separador_miles + "$2");
        }
    }

    return numero;
}

function siguiente(){
	var retco = document.getElementById("retiro").value.length;
	if(retco == 0){
		jAlert('Debes ingresar un retiro.', 'Debo Retail - Global Business Solution');
	}else{

		var ret = document.getElementById("retiro").value;
		document.getElementById("retiro").value = dec(ret.replace(",","."));

		var total = parseFloat(ret);

		document.getElementById("total").value = formato_numero(total,2,",",".");
		
		document.getElementById("DondeE").value = "obsret";
		document.getElementById("CantiE").value = "25";	
		document.getElementById("QuePoE").value = "0";
		
		EnvAyuda('Escriba una Observaci&oacute;n del Retiro.');
		
		$("#ret").css("border-color", "transparent");
		$("#retobs").css("border-color", "#F90");
		
		document.getElementById('LetSal').innerHTML = '<button class="StyBoton" onclick="salir_ret();" onmouseout="MM_swapImgRestore()" onmouseover="MM_swapImage(\'LetSalRetEfe2\',\'\',\'botones/sal-over.png\',0)"><img src="botones/sal-up.png" name="Volver" title="Volver" border="0" id="LetSalRetEfe2"/></button>';
		
		document.getElementById('NumVol').innerHTML = '<button id="LetVolRet" onclick="volver_2();" class="StyBoton" onmouseout="MM_swapImgRestore()" onmouseover="MM_swapImage(\'LetVolRet\',\'\',\'botones/vol-over.png\',0)"><img src="botones/vol-up.png" name="Volver" title="Volver" border="0" id="LetVolRet"/></button>';

		document.getElementById('LetEnt').innerHTML = '<button id="BotLetEntFac" onclick="siguiente_3();" class="StyBoton" onmouseout="MM_swapImgRestore()" onmouseover="MM_swapImage(\'LetEntFac\',\'\',\'botones/ent-over.png\',0)"><img src="botones/ent-up.png" name="Enter" title="Enter" border="0" id="LetEntFac"/></button>';

	}
}

function volver_2(){
	
	$("#ret").css("border-color", "#F90");
	$("#retobs").css("border-color", "transparent");

	EnvAyuda("Ingrese el Efectivo");
	
	document.getElementById("DondeE").value = "retiro";
	document.getElementById("CantiE").value = "12";
	document.getElementById("QuePoE").value = "1";
	
	document.getElementById('LetSal').innerHTML = '<button class="StyBoton" onclick="salir_ret();" onmouseout="MM_swapImgRestore()" onmouseover="MM_swapImage(\'LetSalRetEfe4\',\'\',\'botones/sal-over.png\',0)"><img src="botones/sal-up.png" name="Volver" title="Volver" border="0" id="LetSalRetEfe4"/></button>';
	
	document.getElementById('LetEnt').innerHTML = '<button id="BotLetEntFac" onclick="siguiente();" class="StyBoton" onmouseout="MM_swapImgRestore()" onmouseover="MM_swapImage(\'LetEntFac\',\'\',\'botones/ent-over.png\',0)"><img src="botones/ent-up.png" name="Enter" title="Enter" border="0" id="LetEntFac"/></button>';
	
	document.getElementById('NumVol').innerHTML = '<button id="LetVolRet" onclick="salir_ret();" class="StyBoton" onmouseout="MM_swapImgRestore()" onmouseover="MM_swapImage(\'LetVolRet\',\'\',\'botones/vol-over.png\',0)"><img src="botones/vol-up.png" name="Volver" title="Volver" border="0" id="LetVolRet"/></button>';	
}

function siguiente_3(){
	
	var obsretco = document.getElementById("obsret").value.length;
	if(obsretco == 0){

		jAlert('Debe escribir un comentario.', 'Debo Retail - Global Business Solution');

	}else{

		$("#retobs").css("border-color", "transparent");

		SoloBlock("LetTer");
		SoloNone("LetEnt");
		
		EnvAyuda('Presione Terminar para Grabar el Retiro.');
		
		document.getElementById('LetSal').innerHTML = '<button class="StyBoton" onclick="salir_ret();" onmouseout="MM_swapImgRestore()" onmouseover="MM_swapImage(\'LetSalRetEfe8\',\'\',\'botones/sal-over.png\',0)"><img src="botones/sal-up.png" name="Volver" title="Volver" border="0" id="LetSalRetEfe8"/></button>';
		
		document.getElementById('LetTer').innerHTML = '<button id="LetTerRet" onclick="siguiente_5();" class="StyBoton" onmouseout="MM_swapImgRestore()" onmouseover="MM_swapImage(\'LetTerRet\',\'\',\'botones/ter-over.png\',0)"><img src="botones/ter-up.png" name="Enter" title="Enter" border="0" id="LetTerRet"/></button>';
		
		document.getElementById('NumVol').innerHTML = '<button id="LetVolRet" onclick="volver_5();" class="StyBoton" onmouseout="MM_swapImgRestore()" onmouseover="MM_swapImage(\'LetVolRet\',\'\',\'botones/vol-over.png\',0)"><img src="botones/vol-up.png" name="Volver" title="Volver" border="0" id="LetVolRet"/></button>';
		
	}	
}

function siguiente_5(){
	
	Mos_Ocu('NumVol');		
	Mos_Ocu('LetTer');
	Mos_Ocu('LetTer');
	Mos_Ocu('CarAyuda');
	Mos_Ocu('CarAyudaFon');
	$('#retefe').submit();	
	
}

function volver_5(){
	
	SoloBlock("LetEnt");
	SoloNone("LetTer");
	
	$("#retobs").css("border-color", "#F90");
	
	EnvAyuda('Escriba una Observaci&oacute;n del Retiro.');
	
	document.getElementById("DondeE").value = "obsret";
	document.getElementById("CantiE").value = "25";	
	document.getElementById("QuePoE").value = "0";
	
	document.getElementById('LetSal').innerHTML = '<button class="StyBoton" onclick="salir_ret();" onmouseout="MM_swapImgRestore()" onmouseover="MM_swapImage(\'LetSalRetEfe9\',\'\',\'botones/sal-over.png\',0)"><img src="botones/sal-up.png" name="Volver" title="Volver" border="0" id="LetSalRetEfe9"/></button>';
	
	document.getElementById('LetEnt').innerHTML = '<button id="BotLetEntFac" onclick="siguiente_3();" class="StyBoton" onmouseout="MM_swapImgRestore()" onmouseover="MM_swapImage(\'LetEntFac\',\'\',\'botones/ent-over.png\',0)"><img src="botones/ent-up.png" name="Enter" title="Enter" border="0" id="LetEntFac"/></button>';
	
	document.getElementById('NumVol').innerHTML = '<button id="LetVolRet" onclick="volver_2();" class="StyBoton" onmouseout="MM_swapImgRestore()" onmouseover="MM_swapImage(\'LetVolRet\',\'\',\'botones/vol-over.png\',0)"><img src="botones/vol-up.png" name="Volver" title="Volver" border="0" id="LetVolRet"/></button>';
	
}

////////////////////////////////////////////////////////////////////////////////////////////////////////////////
////////////////////////////////////////////////////////////////////////////////////////////////////////////////
////////////////////////////////////////////////////////////////////////////////////////////////////////////////


function selope(){
	
	var ope = document.getElementById("inp_vale").value;
	
	if(ope.length == 0){
		
		jAlert('Debe ingresar un Operario.', 'Debo Retail - Global Business Solution');
		
	}else{
		
		$("#archivos").load("RetEfeT.php?bus=1&ope="+ope);
		
	}
	
}

function Vol_Vale(){
	
	$("#impDiv").css("border-color", "transparent");
	$("#valDiv").css("border-color", "#F90");
	
	EnvAyuda('Ingrese un Operario.');
	
	document.getElementById("DondeE").value = "inp_vale";
	document.getElementById("CantiE").value = "5";
	document.getElementById("QuePoE").value = "6";
	
	document.getElementById('LetSal').innerHTML = '<button class="StyBoton" onclick="salir_ret();" onmouseout="MM_swapImgRestore()" onmouseover="MM_swapImage(\'LetSalRetE\',\'\',\'botones/sal-over.png\',0)"><img src="botones/sal-up.png" name="Volver" title="Volver" border="0" id="LetSalRetE"/></button>';
	
	document.getElementById('LetEnt').innerHTML = '<button id="BotLetEntFac" onclick="selope();" class="StyBoton" onmouseout="MM_swapImgRestore()" onmouseover="MM_swapImage(\'LetEntFac\',\'\',\'botones/ent-over.png\',0)"><img src="botones/ent-up.png" name="Enter" title="Enter" border="0" id="LetEntFac"/></button>';
	
	document.getElementById('NumVol').innerHTML = '<button id="LetVolRet" onclick="salir_ret();" class="StyBoton" onmouseout="MM_swapImgRestore()" onmouseover="MM_swapImage(\'LetVolRet\',\'\',\'botones/vol-over.png\',0)"><img src="botones/vol-up.png" name="Volver" title="Volver" border="0" id="LetVolRet"/></button>';
	
}

function Ingresa_Det(){
	
	var imp = document.getElementById("inp_importe").value;
	
	if(imp.length == 0){
		
		jAlert('Debe ingresar un Importe.', 'Debo Retail - Global Business Solution');
		
	}else{
		
		document.getElementById("inp_importe").value = dec(imp.replace(",","."));

		$("#impDiv").css("border-color", "transparent");
		$("#antobs").css("border-color", "#F90");
		
		EnvAyuda('Ingrese un Detalle.');
		
		document.getElementById("DondeE").value = "obsant";
		document.getElementById("CantiE").value = "25";
		document.getElementById("QuePoE").value = "2";
		
		document.getElementById('LetSal').innerHTML = '<button class="StyBoton" onclick="salir_ret();" onmouseout="MM_swapImgRestore()" onmouseover="MM_swapImage(\'LetSalRetE\',\'\',\'botones/sal-over.png\',0)"><img src="botones/sal-up.png" name="Volver" title="Volver" border="0" id="LetSalRetE"/></button>';
		
		document.getElementById('LetEnt').innerHTML = '<button id="BotLetEntFac" onclick="ConfirmaVale();" class="StyBoton" onmouseout="MM_swapImgRestore()" onmouseover="MM_swapImage(\'LetEntFac\',\'\',\'botones/ent-over.png\',0)"><img src="botones/ent-up.png" name="Enter" title="Enter" border="0" id="LetEntFac"/></button>';
		
		document.getElementById('NumVol').innerHTML = '<button id="LetVolRet" onclick="Vol_Importe();" class="StyBoton" onmouseout="MM_swapImgRestore()" onmouseover="MM_swapImage(\'LetVolRet\',\'\',\'botones/vol-over.png\',0)"><img src="botones/vol-up.png" name="Volver" title="Volver" border="0" id="LetVolRet"/></button>';
				
	}
}

function Vol_Importe(){

	$("#impDiv").css("border-color", "#F90");
	$("#antobs").css("border-color", "transparent");

	EnvAyuda("Ingrese el Importe");
	
	document.getElementById("DondeE").value = "inp_importe";
	document.getElementById("CantiE").value = "8";
	document.getElementById("QuePoE").value = "1";
	
	document.getElementById('LetSal').innerHTML = '<button class="StyBoton" onclick="salir_ret();" onmouseout="MM_swapImgRestore()" onmouseover="MM_swapImage(\'LetSalRetEfe4\',\'\',\'botones/sal-over.png\',0)"><img src="botones/sal-up.png" name="Volver" title="Volver" border="0" id="LetSalRetEfe4"/></button>';
	
	document.getElementById('LetEnt').innerHTML = '<button id="BotLetEntFac" onclick="Ingresa_Det();" class="StyBoton" onmouseout="MM_swapImgRestore()" onmouseover="MM_swapImage(\'LetEntFac\',\'\',\'botones/ent-over.png\',0)"><img src="botones/ent-up.png" name="Enter" title="Enter" border="0" id="LetEntFac"/></button>';
	
	document.getElementById('NumVol').innerHTML = '<button id="LetVolRet" onclick="Vol_Vale();" class="StyBoton" onmouseout="MM_swapImgRestore()" onmouseover="MM_swapImage(\'LetVolRet\',\'\',\'botones/vol-over.png\',0)"><img src="botones/vol-up.png" name="Volver" title="Volver" border="0" id="LetVolRet"/></button>';			
	
}

function ConfirmaVale(){
	
	var ant = document.getElementById("obsant").value;
	if(ant.length == 0){

		jAlert('Debe escribir un comentario.', 'Debo Retail - Global Business Solution');

	}else{

		$("#antobs").css("border-color", "transparent");

		SoloBlock("LetTer");
		SoloNone("LetEnt");
		
		EnvAyuda('Presione Terminar para grabar el Vale.');
		
		document.getElementById('LetSal').innerHTML = '<button class="StyBoton" onclick="salir_ret();" onmouseout="MM_swapImgRestore()" onmouseover="MM_swapImage(\'LetSalRetEfe8\',\'\',\'botones/sal-over.png\',0)"><img src="botones/sal-up.png" name="Volver" title="Volver" border="0" id="LetSalRetEfe8"/></button>';
		
		document.getElementById('LetTer').innerHTML = '<button id="LetTerRet" onclick="TerminaVale();" class="StyBoton" onmouseout="MM_swapImgRestore()" onmouseover="MM_swapImage(\'LetTerRet\',\'\',\'botones/ter-over.png\',0)"><img src="botones/ter-up.png" name="Enter" title="Enter" border="0" id="LetTerRet"/></button>';
		
		document.getElementById('NumVol').innerHTML = '<button id="LetVolRet" onclick="Vol_Det();" class="StyBoton" onmouseout="MM_swapImgRestore()" onmouseover="MM_swapImage(\'LetVolRet\',\'\',\'botones/vol-over.png\',0)"><img src="botones/vol-up.png" name="Volver" title="Volver" border="0" id="LetVolRet"/></button>';
	}
}

function Vol_Det(){

	$("#antobs").css("border-color", "#F90");
	
	EnvAyuda('Ingrese un Detalle.');
	
	SoloNone("LetTer");
	SoloBlock("LetEnt");
	
	document.getElementById("DondeE").value = "obsant";
	document.getElementById("CantiE").value = "25";
	document.getElementById("QuePoE").value = "2";
	
	document.getElementById('LetSal').innerHTML = '<button class="StyBoton" onclick="salir_ret();" onmouseout="MM_swapImgRestore()" onmouseover="MM_swapImage(\'LetSalRetE\',\'\',\'botones/sal-over.png\',0)"><img src="botones/sal-up.png" name="Volver" title="Volver" border="0" id="LetSalRetE"/></button>';
	
	document.getElementById('LetEnt').innerHTML = '<button id="BotLetEntFac" onclick="selope();" class="StyBoton" onmouseout="MM_swapImgRestore()" onmouseover="MM_swapImage(\'LetEntFac\',\'\',\'botones/ent-over.png\',0)"><img src="botones/ent-up.png" name="Enter" title="Enter" border="0" id="LetEntFac"/></button>';
	
	document.getElementById('NumVol').innerHTML = '<button id="LetVolRet" onclick="Vol_Importe();" class="StyBoton" onmouseout="MM_swapImgRestore()" onmouseover="MM_swapImage(\'LetVolRet\',\'\',\'botones/vol-over.png\',0)"><img src="botones/vol-up.png" name="Volver" title="Volver" border="0" id="LetVolRet"/></button>';

}

function TerminaVale(){
	
	Mos_Ocu('NumVol');		
	Mos_Ocu('LetTer');
	Mos_Ocu('LetTer');
	Mos_Ocu('CarAyuda');
	Mos_Ocu('CarAyudaFon');
	$('#valeform').submit();	
	
}

</script>
</head>
<body>

<div id="RetirosAgregar" style="display:none;">
    <div id="agregarretiro" align="center" style="z-index:0; position:absolute;">
        <img src="RetiroCaja/Retiros.png" />
    </div>
    
    <form action="RetEfeT.php" id="retefe" name="retefe" method="post">
    
    	<input type="hidden" name="tipo" id="tipo"  />
        
    <div id="agregarretirobac" style="z-index:0; position:absolute; color:#CCCCCC; font:'Tekton Pro'; font-size:12px; font-weight:bold;">
    
    <div class="fon-ret-agr" style="position:absolute; left:129px; top:11px; width:46px;" align="center"><? echo $_SESSION['idsusua'];?></div>
    
    <div class="fon-ret-agr" style="position:absolute; left:358px; top:10px; width:15px;" align="center"><? echo $nco_var;?></div>
    
    <div class="fon-ret-agr" style="position:absolute; left:470px; top:10px; width:46px;" align="center"><? echo $pla_ver;?></div>
    
    <div class="fon-ret-agr" style="position:absolute; left:129px; top:31px; width:154px;" align="center"><? echo $_SESSION['idsusun'];?></div>
    
    <div class="fon-ret-agr" style="position:absolute; left:347px; top:24px; width:154px;" align="left"><? echo date("d/m/Y H:i:s"); ?></div>
    
    <div id="retobs" class="div-redondo">
      <textarea class="fon-ret-agr2textarea" id="obsret" name="obsret" readonly="readonly"/>
    </div>
    
    <div id="ret" class="div-redondo" style="width:126px; height:16px;">
        <input class="fon-ret-agr2" type="text" id="retiro" name="retiro" readonly="readonly" style="width:110px; background-color:transparent; border:0; height:14; text-align:right;" />
    </div>
    
    <div id="ant" class="div-redondo" style="width:126px; height:16px; display:none;">
        <input class="fon-ret-agr2" type="text" id="anticipo" name="anticipo" readonly="readonly" style="width:110px;  background-color:transparent; border:0;  text-align:right;" />
    </div>
        
    <div class="fon-ret-agr" style="position:absolute; left:161px; top:108px; text-align:right; width:116px;">0</div>
    
    <div class="fon-ret-agr" style="position:absolute; left:161px; top:129px; text-align:right; width:116px;">0</div>
    
    <div style="position:absolute; left:161px; top:169px;">
        <input class="fon-ret-agr2" type="text" id="total" readonly="readonly" style="width:110px;  background-color:transparent; border:0; " />
    </div>
        <input type="hidden" id="fe" name="fe" value="1" />
    </div>
    </form>  
</div>



<div id="ValesAgregar" style="display:none;">
    <div id="agregarretiro" align="center" style="z-index:0; position:absolute;">
        <img src="RetiroCaja/Vales.png" />
    </div>
    
    <form action="RetEfeT.php" id="valeform" name="valeform" method="post">
    
    <div id="agregarretirobac" style="z-index:0; position:absolute; color:#CCCCCC; font:'Tekton Pro'; font-size:12px; font-weight:bold;">
    
    <div class="fon-ret-agr" style="position:absolute; left:129px; top:11px; width:46px;" align="center"><? echo $_SESSION['idsusua'];?></div>
    
    <div class="fon-ret-agr" style="position:absolute; left:358px; top:10px; width:15px;" align="center"><? echo $nco_var;?></div>
    
    <div class="fon-ret-agr" style="position:absolute; left:470px; top:10px; width:46px;" align="center"><? echo $pla_ver;?></div>
    
    <div class="fon-ret-agr" style="position:absolute; left:129px; top:31px; width:154px;" align="center"><? echo $_SESSION['idsusun'];?></div>
    
    <div class="fon-ret-agr" style="position:absolute; left:347px; top:24px; width:154px;" align="left"><? echo date("d/m/Y H:i:s"); ?></div>
    
    <div id="antobs" class="div-redondo">
      <textarea class="fon-ret-agr2textarea" id="obsant" name="obsant" readonly="readonly"/>
    </div>
    
    
    <div id="valDiv" class="div-redondo" style="width:126px; height:16px;">
        <input class="fon-ret-agr2" type="text" id="inp_vale" name="inp_vale" readonly="readonly" style="width:110px; background-color:transparent; border:0; height:14; text-align:right;" />
    </div>
    
    <div id="impDiv" class="div-redondo" style="width:126px; height:16px;">
        <input class="fon-ret-agr2" type="text" id="inp_importe" name="inp_importe" readonly="readonly" style="width:110px;  background-color:transparent; border:0;  text-align:right;" />
    </div>
    
    <div style="position:absolute; left:161px; top:169px; display:none;">
        <input class="fon-ret-agr2" type="text" id="total" readonly="readonly" style="width:110px;  background-color:transparent; border:0; " />
    </div>
        <input type="hidden" id="fe" name="fe" value="1" />
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