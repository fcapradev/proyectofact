<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Entrada de Operario</title>

<script>

$(document).ready(function(){
	$('#EntradaOpeForm').submit(function(){
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

$("#CodOpeDiv").css("border-color", "#F90");
$("#CodOpe").focus();

function TerminarOpe(){
	
	document.getElementById("insert").value = 1;
	$('#EntradaOpeForm').submit();
	
}

function EntradaCon(){
	
	var control = LValue('ConOpe');
	if(control != 0){
		
		$('#EntradaOpeForm').submit();

		SoloNone("LetEnt, NumVol");
		
		$("#CodOpeDiv").css("border-color", "transparent");
		$("#ConOpeDiv").css("border-color", "transparent");
		
	}
	
}

function EntradaCod(){
	
	var control = LValue('CodOpe');
	if(control != 0){
		
		$("#ConOpeDiv").css("border-color", "#F90");
		$("#CodOpeDiv").css("border-color", "transparent");
					
		document.getElementById("DondeE").value = "ConOpe";
		document.getElementById("CantiE").value = "9";
		document.getElementById("QuePoE").value = "0";
	
		document.getElementById('LetEnt').innerHTML = '<button class="StyBoton" onclick="EntradaCon();" onmouseout="MM_swapImgRestore()" onmouseover="MM_swapImage(\'LetEntOpe\',\'\',\'botones/ent-over.png\',0)"><img src="botones/ent-up.png" name="Enter" title="Enter" border="0" id="LetEntOpe"/></button>';
		
		document.getElementById('LetTer').innerHTML = '<button class="StyBoton" onclick="TerminarOpe();" onmouseout="MM_swapImgRestore()" onmouseover="MM_swapImage(\'LetTerOpe\',\'\',\'botones/ter-over.png\',0)"><img src="botones/ter-up.png" name="Terminar" title="Terminar" border="0" id="LetTerOpe"/></button>';
		
		document.getElementById('NumVol').innerHTML = '<button class="StyBoton" onclick="EntradaConVol();" onmouseout="MM_swapImgRestore()" onmouseover="MM_swapImage(\'LetVolOpe2\',\'\',\'botones/vol-over.png\',0)"><img src="botones/vol-up.png" name="Volver" title="Volver" border="0" id="LetVolOpe2"/></button>';
		
		$("#ConOpe").focus();
			
	}
	
}

function EntradaConVol(){

	$("#CodOpeDiv").css("border-color", "#F90");
	$("#ConOpeDiv").css("border-color", "transparent");
	
	document.getElementById('FechOpe').innerHTML = "";
	document.getElementById('TurnOpe').innerHTML = "";
	document.getElementById('CajaOpe').innerHTML = "";
	document.getElementById('HoraOpe').innerHTML = "";
	
	document.getElementById("CodOpe").value = "";
	document.getElementById("ConOpe").value = "";
	
	document.getElementById("DondeE").value = "CodOpe";
	document.getElementById("CantiE").value = "9";
	document.getElementById("QuePoE").value = "0";

	document.getElementById('LetEnt').innerHTML = '<button class="StyBoton" onclick="EntradaCod();" onmouseout="MM_swapImgRestore()" onmouseover="MM_swapImage(\'LetEntOpe\',\'\',\'botones/ent-over.png\',0)"><img src="botones/ent-up.png" name="Enter" title="Enter" border="0" id="LetEntOpe"/></button>';
		
	document.getElementById('LetTer').innerHTML = '<button class="StyBoton" onclick="TerminarOpe();" onmouseout="MM_swapImgRestore()" onmouseover="MM_swapImage(\'LetTerOpe\',\'\',\'botones/ter-over.png\',0)"><img src="botones/ter-up.png" name="Terminar" title="Terminar" border="0" id="LetTerOpe"/></button>';
		
	document.getElementById('NumVol').innerHTML = '<button class="StyBoton" onclick="EntradaCod();" onmouseout="MM_swapImgRestore()" onmouseover="MM_swapImage(\'LetEntOpe2\',\'\',\'botones/ent-over.png\',0)"><img src="botones/ent-up.png" name="Enter" title="Enter" border="0" id="LetEntOpe2"/></button>';
	
	SoloBlock("LetEnt, NumVol");
	SoloNone("LetTer");
		
	$("#CodOpe").focus();

}

function ControlCodOpe(){

	var k = window.event.keyCode;
	if(!((k == 13) || ((k >= 48) && (k <= 57)))){
		return false;
	}
	if(k == 13){
		EntradaCod();
	}

}

function ControlConOpe(){

	var k = window.event.keyCode;
	if(!((k == 32) || (k == 13) || ((k >= 48) && (k <= 57)) || ((k >= 97) && (k <= 122)))){
		return false;
	}
	if(k == 13){
		EntradaCon();
	}

}

function ControlConOpeVol(){

	var k = window.event.keyCode;
	if(k == 27){
		EntradaConVol();
	}
	if(k == 113){
		if($("#LetTer").css('display') == 'block'){
			TerminarOpe();
		}
	}

}

</script>

</head>

<body>

<form id="EntradaOpeForm" name="EntradaOpeForm" method="post" action="ROpe.php">

    <input type="hidden" id="insert" name="insert" value="0" />
    
    <div id="CodOpeDiv" class="div-redondo" style="left:58px; top:41px; width:175px; height:19px; position:absolute; font-family: 'TPro'; font-size:12px; color:#FFFFFF;">
        <input class="BotonOpe" type="text" id="CodOpe" name="CodOpe" maxlength="9" style="left:92px; top:2px; position:absolute; outline-style:none; border-style:none;" onkeypress="return ControlCodOpe();" />
    </div>
    
    <div id="ConOpeDiv" class="div-redondo" style="left:58px; top:68px; width:175px; height:19px; position:absolute; font-family: 'TPro'; font-size:12px; color:#FFFFFF;">
        <input class="BotonOpe" type="password" id="ConOpe" name="ConOpe" maxlength="9" style="left:92px; top:2px; position:absolute; outline-style:none; border-style:none;" onkeypress="return ControlConOpe();" onkeydown="return ControlConOpeVol();" />
    </div>
    
</form>

<div class="ParaDivS" id="FechOpe" style="left:155px; top:103px;"></div>
<div class="ParaDivS" id="TurnOpe" style="left:335px; top:47px; "></div>
<div class="ParaDivS" id="CajaOpe" style="left:335px; top:75px; "></div>
<div class="ParaDivS" id="HoraOpe" style="left:335px; top:103px;"></div>
        
<script>

	SoloNone("LetTer");
		
	document.getElementById("DondeE").value = "CodOpe";
	document.getElementById("CantiE").value = "10";
	document.getElementById("QuePoE").value = "0";
		
	BValue('CodOpe');
	BValue('ConOpe');
	BValue('LetTex');
		
	document.getElementById('FechOpe').innerHTML = "";
	document.getElementById('TurnOpe').innerHTML = "";
	document.getElementById('CajaOpe').innerHTML = "";
	document.getElementById('HoraOpe').innerHTML = "";

</script>

</body>
</html>