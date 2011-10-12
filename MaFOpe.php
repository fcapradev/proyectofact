<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Entrada de Operario</title>

<script>

$(document).ready(function(){
	$('#MaEntradaOpeForm').submit(function(){
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

function MaTerminarOpe(){
	
	document.getElementById("insert").value = 1;
	$('#EntradaOpeForm').submit();
	
}

function MaEntradaCon(){
	
	var control = LValue('MaConOpe');
	if(control == 0){
	
	}else{

		$('#EntradaOpeForm').submit();
		
		Mos_Ocu('LetEnt');
		Mos_Ocu('NumVol');
		
	}
	
}

function MaEntradaCod(){
	
	var control = LValue('MaCodOpe');
	if(control == 0){
	
	}else{
		
		document.getElementById("DondeE").value = "ConOpe";
		
		document.getElementById('LetEnt').innerHTML = '<button class="StyBoton" onclick="MaEntradaCon();" onmouseout="MM_swapImgRestore()" onmouseover="MM_swapImage(\'LetEnt2Ope\',\'\',\'botones/ent-over.png\',0)"><img src="botones/ent-up.png" name="Enter" title="Enter" border="0" id="LetEnt2Ope"/></button>';
		
		document.getElementById('LetTer').innerHTML = '<button class="StyBoton" onclick="MaTerminarOpe();" onmouseout="MM_swapImgRestore()" onmouseover="MM_swapImage(\'LetTer2Ope\',\'\',\'botones/ter-over.png\',0)"><img src="botones/ter-up.png" name="Terminar" title="Terminar" border="0" id="LetTer2Ope"/></button>';
		
		document.getElementById('NumVol').innerHTML = '<button class="StyBoton" onclick="MaEntradaCon();" onmouseout="MM_swapImgRestore()" onmouseover="MM_swapImage(\'LetEnt2Ope2\',\'\',\'botones/ent-over.png\',0)"><img src="botones/ent-up.png" name="Enter" title="Enter" border="0" id="LetEnt2Ope2"/></button>';
	
	}
	
}

</script>

</head>

<body>

<form id="MaEntradaOpeForm" name="MaEntradaOpeForm" action="ROpe.php" method="post">
    <input type="hidden" id="insert" name="insert" value="0" />
    <div class="ParaDivS" style="left:155px; top:47px; ">
        <input readonly="readonly" class="BotonOpe" type="text" id="MaCodOpe" name="MaCodOpe" />
    </div>
    <div class="ParaDivS" style="left:155px; top:75px; ">
        <input readonly="readonly" class="BotonOpe" type="password" id="MaConOpe" name="MaConOpe" />
    </div>
</form>

<div class="ParaDivS" id="MaFechOpe" style="left:155px; top:103px;"></div>
<div class="ParaDivS" id="MaTurnOpe" style="left:335px; top:47px; "></div>
<div class="ParaDivS" id="MaCajaOpe" style="left:335px; top:75px; "></div>
<div class="ParaDivS" id="MaHoraOpe" style="left:335px; top:103px;"></div>

<script>

SoloNone("LetTer");
	
	document.getElementById("DondeE").value = "MaCodOpe";
	document.getElementById("CantiE").value = "10";
	document.getElementById("QuePoE").value = "0";
		
	BValue('MaCodOpe');
	BValue('MaConOpe');
	BValue('LetTex');
		
	document.getElementById('MaFechOpe').innerHTML = "";
	document.getElementById('MaTurnOpe').innerHTML = "";
	document.getElementById('MaCajaOpe').innerHTML = "";
	document.getElementById('MaHoraOpe').innerHTML = "";

</script> 

</body>
</html>