<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Cliente Eventual</title>
<style>
.formeve{
	background-color:transparent;
	font-family: "TPro";
	font-size:12px;
	width:209px;
	height:15px; 
	border:0;
}
</style>
<script>

$(document).ready(function(){
	$('#FormNCliente').submit(function(){
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

function cuit_eve2_vol(){

	document.getElementById('responevef').value = 0;
	document.getElementById('responevef_tx').value = "";
	document.getElementById('cuitevef').value = "";
	
	document.getElementById("DondeE").value = "cuitevef";
	EnvAyuda('Ingrese cuit del cliente.');
	
	document.getElementById('LetEnt').innerHTML = '<button class="StyBoton" onclick="cuit_eve();" onmouseout="MM_swapImgRestore()" onmouseover="MM_swapImage(\'LetAbr\',\'\',\'botones/ent-over.png\',0)"><img src="botones/ent-up.png" name="Enter" title="Enter" border="0" id="LetAbr"/></button>';
	
	document.getElementById('NumVol').innerHTML = '<button class="StyBoton" onclick="direc_eve_vol();" onmouseout="MM_swapImgRestore()" onmouseover="MM_swapImage(\'NumVol1\',\'\',\'botones/vol-over.png\',0)"><img src="botones/vol-up.png" name="Enter" title="Enter" border="0" id="NumVol1"/></button>';
	
}

function enviar_eve(){
	
	var re = parseFloat(document.getElementById('responevef').value);
	var cu = document.getElementById('cuitevef').value;
	var cl = document.getElementById('cuitevef').value.length;
	var co = CPcuitValido(cu);
	
	var no = document.getElementById('nombreevef').value.length;
	var di = document.getElementById('direcevef').value.length;
	
	if(no == 0){ return false; }
	if(di == 0){ return false; }
	
	if(re != 3){
		
		if(co == true){
			
			if(cl == 13){
				
				$('#FormNCliente').submit();
				
			}else{

				var a = cu.substring(0,2);
				var b = cu.substring(2,10);
				var c = cu.substring(10,11);
				document.getElementById('cuitevef').value = ""; 
				document.getElementById('cuitevef').value = a +'-'+ b +'-'+ c;
				$('#FormNCliente').submit();
				document.getElementById("TerminarTic").value = 1;
				
			}
			
		}else{
			
			EnvAyuda('Ingrese cuit del cliente.');
			
			document.getElementById("DondeE").value = "cuitevef";
			
			SoloNone('LetTer');
			SoloBlock('LetEnt, NumVol');
			
			document.getElementById('LetEnt').innerHTML = '<button class="StyBoton" onclick="cuit_eve2();" onmouseout="MM_swapImgRestore()" onmouseover="MM_swapImage(\'LetAbr\',\'\',\'botones/ent-over.png\',0)"><img src="botones/ent-up.png" name="Enter" title="Enter" border="0" id="LetAbr"/></button>';
		
			document.getElementById('NumVol').innerHTML = '<button class="StyBoton" onclick="cuit_eve2_vol();" onmouseout="MM_swapImgRestore()" onmouseover="MM_swapImage(\'NumVol1\',\'\',\'botones/vol-over.png\',0)"><img src="botones/vol-up.png" name="Enter" title="Enter" border="0" id="NumVol1"/></button>';
			
		}
		
	}else{
		document.getElementById('cuitevef').value = ""; 
		$('#FormNCliente').submit();
	}
	
}

function nombre_eve_vol(){
	
	EnvAyuda('Ingrese nombre del cliente.');
	document.getElementById('nombreevef').value = "";
	document.getElementById('direcevef').value = "";
	document.getElementById("DondeE").value = "nombreevef";
	
	document.getElementById('LetEnt').innerHTML = '<button class="StyBoton" onclick="nombre_eve();" onmouseout="MM_swapImgRestore()" onmouseover="MM_swapImage(\'LetAbr\',\'\',\'botones/ent-over.png\',0)"><img src="botones/ent-up.png" name="Enter" title="Enter" border="0" id="LetAbr"/></button>';
		
	document.getElementById('NumVol').innerHTML = '<button class="StyBoton" onclick="nombre_eve();" onmouseout="MM_swapImgRestore()" onmouseover="MM_swapImage(\'NumVol1\',\'\',\'botones/ent-over.png\',0)"><img src="botones/ent-up.png" name="Enter" title="Enter" border="0" id="NumVol1"/></button>';

}

function nombre_eve(){

	var c = document.getElementById('nombreevef').value.length;
	if(c != 0){
		
		document.getElementById("DondeE").value = "direcevef";
		EnvAyuda('Ingrese domicilio del cliente.');
	
		document.getElementById('LetEnt').innerHTML = '<button class="StyBoton" onclick="direc_eve();" onmouseout="MM_swapImgRestore()" onmouseover="MM_swapImage(\'LetAbr\',\'\',\'botones/ent-over.png\',0)"><img src="botones/ent-up.png" name="Enter" title="Enter" border="0" id="LetAbr"/></button>';
	
		document.getElementById('NumVol').innerHTML = '<button class="StyBoton" onclick="nombre_eve_vol();" onmouseout="MM_swapImgRestore()" onmouseover="MM_swapImage(\'NumVol1\',\'\',\'botones/vol-over.png\',0)"><img src="botones/vol-up.png" name="Enter" title="Enter" border="0" id="NumVol1"/></button>';
	
	}
	
}	

function direc_eve_vol(){

	document.getElementById('direcevef').value = "";
	document.getElementById('cuitevef').value = "";
	document.getElementById("DondeE").value = "direcevef";
	
	document.getElementById("DondeE").value = "direcevef";
	EnvAyuda('Ingrese domicilio del cliente.');
	
	document.getElementById('LetEnt').innerHTML = '<button class="StyBoton" onclick="direc_eve();" onmouseout="MM_swapImgRestore()" onmouseover="MM_swapImage(\'LetAbr\',\'\',\'botones/ent-over.png\',0)"><img src="botones/ent-up.png" name="Enter" title="Enter" border="0" id="LetAbr"/></button>';
	
	document.getElementById('NumVol').innerHTML = '<button class="StyBoton" onclick="nombre_eve_vol();" onmouseout="MM_swapImgRestore()" onmouseover="MM_swapImage(\'NumVol1\',\'\',\'botones/vol-over.png\',0)"><img src="botones/vol-up.png" name="Enter" title="Enter" border="0" id="NumVol1"/></button>';
		
}

function direc_eve(){
	
	var c = document.getElementById('direcevef').value.length;
	if(c != 0){
		
		document.getElementById("DondeE").value = "cuitevef";
		EnvAyuda('Ingrese cuit del cliente.');
	
		document.getElementById('LetEnt').innerHTML = '<button class="StyBoton" onclick="cuit_eve();" onmouseout="MM_swapImgRestore()" onmouseover="MM_swapImage(\'LetAbr\',\'\',\'botones/ent-over.png\',0)"><img src="botones/ent-up.png" name="Enter" title="Enter" border="0" id="LetAbr"/></button>';
	
		document.getElementById('NumVol').innerHTML = '<button class="StyBoton" onclick="direc_eve_vol();" onmouseout="MM_swapImgRestore()" onmouseover="MM_swapImage(\'NumVol1\',\'\',\'botones/vol-over.png\',0)"><img src="botones/vol-up.png" name="Enter" title="Enter" border="0" id="NumVol1"/></button>';
	
	}
	
}

function cuit_eve(){

	var c = document.getElementById('cuitevef').value.length;
	
	if(c==0){

		respon();
		
	}else{
		
		var c = document.getElementById('cuitevef').value;
		var t = CPcuitValido(c);
		if(t == true){		
			respon();
		}else{
			document.getElementById('cuitevef').value = ""; 
			alert("Cuit incorrecto");
		}

	}
}


function cuit_eve2(){

	var cu = document.getElementById('cuitevef').value;
	var t = CPcuitValido(cu);
	
	if(t == true){
		
		respon();
		
	}else{
		document.getElementById('cuitevef').value = ""; 
		alert("Cuit incorrecto");
	}

}

function respon(){
	
	SoloNone('LetEnt, NumVol, LetTer');
	
	MostrarCombo();
		
	document.getElementById('LetTer').innerHTML = '<button class="StyBoton" onclick="enviar_eve();" onmouseout="MM_swapImgRestore()" onmouseover="MM_swapImage(\'LetTerminarEve\',\'\',\'botones/ter-over.png\',0)"><img src="botones/ter-up.png" name="Terminar" title="Terminar" border="0" id="LetTerminarEve"/></button>';
		
}

function MostrarCombo(){
	
	document.getElementById("TerminarTic").value = 0;
	SoloBlock('MostrarComboDiv');
	$("#MostrarComboDiv").load("ComFCli.php");

}

document.getElementById('LetEnt').innerHTML = '<button class="StyBoton" onclick="nombre_eve();" onmouseout="MM_swapImgRestore()" onmouseover="MM_swapImage(\'LetAbr\',\'\',\'botones/ent-over.png\',0)"><img src="botones/ent-up.png" name="Enter" title="Enter" border="0" id="LetAbr"/></button>';
	
document.getElementById('LetTer').innerHTML = '<button class="StyBoton" onclick="enviar_eve();" onmouseout="MM_swapImgRestore()" onmouseover="MM_swapImage(\'LetTerminarEve\',\'\',\'botones/ter-over.png\',0)"><img src="botones/ter-up.png" name="Terminar" title="Terminar" border="0" id="LetTerminarEve"/></button>';
	
document.getElementById('NumVol').innerHTML = '<button class="StyBoton" onclick="nombre_eve();" onmouseout="MM_swapImgRestore()" onmouseover="MM_swapImage(\'NumVol1\',\'\',\'botones/ent-over.png\',0)"><img src="botones/ent-up.png" name="Enter" title="Enter" border="0" id="NumVol1"/></button>';

SoloNone('LetTer');
SoloBlock('LetEnt, NumVol');

</script>

</head>
<body>

<form id="FormNCliente" name="FormNCliente" action="NCli.php">

<div id="mostrareventual" style="position:absolute; top:0px; left:10px;" >

<table width="470" border="0" cellpadding="0" cellspacing="0">
<tr>
<td valign="middle" headers="30">
	<img src="Clientes/tit.png" /><img src="Clientes/eve.png" />
</td>
<td>
	<table align="right" border="0" cellpadding="0" cellspacing="0">
	<tr>
	<td>&nbsp;</td>
	</tr>
	</table>
</td>
</tr>
</table>


    <div style="position:absolute; left:117px; top:40px;">
        <img src="Clientes/even.png" />
    </div>
    <div style="position:absolute; left:117px; top:40px;">
    
        <div style="position:absolute; width:210px; height:17px; left:13px; top:42px;">
            <input type="text" readonly="readonly" class="formeve" id="nombreevef" name="nombreevef" />
        </div>
        
        <div style="position:absolute; width:210px; height:17px; left:13px; top:81px;">
            <input type="text" readonly="readonly" class="formeve" id="direcevef" name="direcevef" />
        </div>
        
        <div style="position:absolute; width:210px; height:17px; left:13px; top:120px;">
            <input type="text" class="formeve" id="cuitevef" name="cuitevef" />
        </div>
        
        <div style="position:absolute; width:210px; height:17px; left:13px; top:158px;">
            <input type="hidden" id="responevef" name="responevef" value="0" />
            <input type="text" id="responevef_tx" name="responevef_tx" style="width:209px; height:15px; border:0;" onclick="MostrarCombo();" />            
        </div>
        
    </div>

</div>
</form>

</body>
</html>