// JavaScript Document

document.getElementById('LetTer').innerHTML = '<button onclick="enviarformulario();" class="StyBoton" onmouseout="MM_swapImgRestore()" onmouseover="MM_swapImage(\'LetTerCC\',\'\',\'botones/cof-over.png\',0)"><img src="botones/cof-up.png" name="Confirmar" title="Confirmar" border="0" id="LetTerCC"/></button>';
			
document.getElementById('LetEnt').innerHTML = '<button onclick="TexUN0();" class="StyBoton" onmouseout="MM_swapImgRestore()" onmouseover="MM_swapImage(\'LetEntCC\',\'\',\'botones/ent-over.png\',0)"><img src="botones/ent-up.png" name="Enter" title="Enter" border="0" id="LetEntCC"/></button>';

document.getElementById("DondeE").value = "TexU0";
document.getElementById("CantiE").value = "12";
document.getElementById("QuePoE").value = "1";

EnvAyuda("Ingrese efectivo a rendir.");

SoloBlock('LetEnt');

$(document).ready(function(){
	$('#FormCCaja').submit(function(){
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

function TexUN0(){
	
	var clength = document.getElementById('TexU0').value.length;
	var extexto = document.getElementById('TexU0').value;
	

	if (/^([0-9+\,])*$/.test(extexto)){
	
		if(clength > 0){
			
			$("#Div0").css("border-color", "transparent");
			$("#Div3").css("border-color", "#F90");
			
			EnvAyuda("Ingrese anticipos a rendir.");
			
			document.getElementById('LetEnt').innerHTML = '<button onclick="TexUN3();" class="StyBoton" onmouseout="MM_swapImgRestore()" onmouseover="MM_swapImage(\'LetEntCC\',\'\',\'botones/ent-over.png\',0)"><img src="botones/ent-up.png" name="Enter" title="Enter" border="0" id="LetEntCC"/></button>';
			
			SoloBlock('NumVol');
			
			document.getElementById('NumVol').innerHTML = '<button onclick="TexUN0VOL();" class="StyBoton" onmouseout="MM_swapImgRestore()" onmouseover="MM_swapImage(\'LetVolCC\',\'\',\'botones/vol-over.png\',0)"><img src="botones/vol-up.png" name="Volver" title="Volver" border="0" id="LetVolCC"/></button>';
			
			document.getElementById('TexU0').value = dec(document.getElementById('TexU0').value,2);
			document.getElementById('TexU1').value = dec(document.getElementById('TexU1').value,2);
			document.getElementById('TexU2').value = dec(document.getElementById('TexU2').value,2);
			
			document.getElementById('TexU3').value = "";
			
			document.getElementById("DondeE").value = "TexU3";
			//$("#TexU3").select();
			document.getElementById("CantiE").value = "12";
			document.getElementById("QuePoE").value = "1";
			
		}else{
		
			document.getElementById('TexU0').value = 0;

			$("#Div0").css("border-color", "transparent");
			$("#Div3").css("border-color", "#F90");

			EnvAyuda("Ingrese anticipos a rendir.");
			
			document.getElementById('LetEnt').innerHTML = '<button onclick="TexUN3();" class="StyBoton" onmouseout="MM_swapImgRestore()" onmouseover="MM_swapImage(\'LetEntCC\',\'\',\'botones/ent-over.png\',0)"><img src="botones/ent-up.png" name="Enter" title="Enter" border="0" id="LetEntCC"/></button>';
			
			SoloBlock('NumVol');
			
			document.getElementById('NumVol').innerHTML = '<button onclick="TexUN0VOL();" class="StyBoton" onmouseout="MM_swapImgRestore()" onmouseover="MM_swapImage(\'LetVolCC\',\'\',\'botones/vol-over.png\',0)"><img src="botones/vol-up.png" name="Volver" title="Volver" border="0" id="LetVolCC"/></button>';
			
			document.getElementById('TexU0').value = dec(document.getElementById('TexU0').value,2);
			document.getElementById('TexU1').value = dec(document.getElementById('TexU1').value,2);
			document.getElementById('TexU2').value = dec(document.getElementById('TexU2').value,2);
			
			document.getElementById('TexU3').value = "";
			//$("#TexU3").select();
			document.getElementById("DondeE").value = "TexU3";
			document.getElementById("CantiE").value = "12";
			document.getElementById("QuePoE").value = "1";
		
		}
	
	}
	
}

function TexUN0VOL(){
	
	$("#Div3").css("border-color", "transparent");
	$("#Div0").css("border-color", "#F90");

	EnvAyuda("Ingrese efectivo a rendir.");

	document.getElementById('LetEnt').innerHTML = '<button onclick="TexUN0();" class="StyBoton" onmouseout="MM_swapImgRestore()" onmouseover="MM_swapImage(\'LetEntCC\',\'\',\'botones/ent-over.png\',0)"><img src="botones/ent-up.png" name="Enter" title="Enter" border="0" id="LetEntCC"/></button>';
	
	document.getElementById('TexU0').value = "";
	document.getElementById("DondeE").value = "TexU0";
	document.getElementById("CantiE").value = "12";
	document.getElementById("QuePoE").value = "1";
	
	SoloNone("NumVol");
	
}

function TexUN3(){
	
	var clength = document.getElementById('TexU3').value.length;
	var extexto = document.getElementById('TexU3').value;
	
	if (/^([0-9+\,])*$/.test(extexto)){
	
		if(clength > 0){

			$("#Div3").css("border-color", "transparent");
			$("#Div6").css("border-color", "#F90");
			
			EnvAyuda("Ingrese efectivo entregado a rendir.");
			
			document.getElementById('LetEnt').innerHTML = '<button onclick="TexUN6();" class="StyBoton" onmouseout="MM_swapImgRestore()" onmouseover="MM_swapImage(\'LetEntCC\',\'\',\'botones/ent-over.png\',0)"><img src="botones/ent-up.png" name="Enter" title="Enter" border="0" id="LetEntCC"/></button>';
			
			document.getElementById('NumVol').innerHTML = '<button onclick="TexUN3VOL();" class="StyBoton" onmouseout="MM_swapImgRestore()" onmouseover="MM_swapImage(\'LetVolCC\',\'\',\'botones/vol-over.png\',0)"><img src="botones/vol-up.png" name="Volver" title="Volver" border="0" id="LetVolCC"/></button>';
			
			document.getElementById('TexU3').value = dec(document.getElementById('TexU3').value,2);
			
			document.getElementById("TexU6").value = "";
			//$("#TexU6").select();
			document.getElementById("DondeE").value = "TexU6";
			document.getElementById("CantiE").value = "12";
			document.getElementById("QuePoE").value = "1";
			
		}else{
			
			document.getElementById("TexU3").value = 0;
			
			$("#Div3").css("border-color", "transparent");
			$("#Div6").css("border-color", "#F90");

			EnvAyuda("Ingrese efectivo entregado a rendir.");
			
			document.getElementById('LetEnt').innerHTML = '<button onclick="TexUN6();" class="StyBoton" onmouseout="MM_swapImgRestore()" onmouseover="MM_swapImage(\'LetEntCC\',\'\',\'botones/ent-over.png\',0)"><img src="botones/ent-up.png" name="Enter" title="Enter" border="0" id="LetEntCC"/></button>';
			
			document.getElementById('NumVol').innerHTML = '<button onclick="TexUN3VOL();" class="StyBoton" onmouseout="MM_swapImgRestore()" onmouseover="MM_swapImage(\'LetVolCC\',\'\',\'botones/vol-over.png\',0)"><img src="botones/vol-up.png" name="Volver" title="Volver" border="0" id="LetVolCC"/></button>';
			
			document.getElementById('TexU3').value = dec(document.getElementById('TexU3').value,2);
			
			document.getElementById("TexU6").value = "";
			//$("#TexU6").select();
			document.getElementById("DondeE").value = "TexU6";
			document.getElementById("CantiE").value = "12";
			document.getElementById("QuePoE").value = "1";
		
		}
	
	}
	
}

function TexUN3VOL(){

	$("#Div6").css("border-color", "transparent");
	$("#Div3").css("border-color", "#F90");
	
	EnvAyuda("Ingrese anticipos a rendir.");
	
	document.getElementById('LetEnt').innerHTML = '<button onclick="TexUN3();" class="StyBoton" onmouseout="MM_swapImgRestore()" onmouseover="MM_swapImage(\'LetEntCC\',\'\',\'botones/ent-over.png\',0)"><img src="botones/ent-up.png" name="Enter" title="Enter" border="0" id="LetEntCC"/></button>';
	
	document.getElementById('NumVol').innerHTML = '<button onclick="TexUN0VOL();" class="StyBoton" onmouseout="MM_swapImgRestore()" onmouseover="MM_swapImage(\'LetVolCC\',\'\',\'botones/vol-over.png\',0)"><img src="botones/vol-up.png" name="Volver" title="Volver" border="0" id="LetVolCC"/></button>';
	
	document.getElementById('TexU3').value = "";
	//$("#TexU3").select();
	document.getElementById("DondeE").value = "TexU3";
	document.getElementById("CantiE").value = "12";
	document.getElementById("QuePoE").value = "1";

}

function TexUN6(){
	
	var clength = document.getElementById('TexU6').value.length;
	var extexto = document.getElementById('TexU6').value;
	
	if (/^([0-9+\,])*$/.test(extexto)){
	
		if(clength > 0){
			
			$("#Div6").css("border-color", "transparent");
			$("#DesEfeEntDiv").css("border-color", "#F90");
			
			EnvAyuda("Ingrese Obserbacion de Efectivo Entregado.");
			//ir a obs
			document.getElementById('TitDesX').innerHTML = 'Obs. Efectivo Entregado';
			SoloBlock('DesEfeEntDiv');
			
			document.getElementById('LetEnt').innerHTML = '<button onclick="TexUND1();" class="StyBoton" onmouseout="MM_swapImgRestore()" onmouseover="MM_swapImage(\'LetEntCC\',\'\',\'botones/ent-over.png\',0)"><img src="botones/ent-up.png" name="Enter" title="Enter" border="0" id="LetEntCC"/></button>';
			
			document.getElementById('NumVol').innerHTML = '<button onclick="TexUN6VOL();" class="StyBoton" onmouseout="MM_swapImgRestore()" onmouseover="MM_swapImage(\'LetVolCC\',\'\',\'botones/vol-over.png\',0)"><img src="botones/vol-up.png" name="Volver" title="Volver" border="0" id="LetVolCC"/></button>';
			
			document.getElementById('TexU6').value = dec(document.getElementById('TexU6').value,2);
			//$("#DesEfeEnt").select();
			
			document.getElementById('DesEfeEnt').value = "";
			document.getElementById("DondeE").value = "DesEfeEnt";
			document.getElementById("CantiE").value = "250";
			document.getElementById("QuePoE").value = "0";
			
		}else{
			
			document.getElementById("TexU6").value = 0;

			$("#Div6").css("border-color", "transparent");
			$("#DesEfeEntDiv").css("border-color", "#F90");
			
			EnvAyuda("Ingrese Obserbacion de Efectivo Entregado.");
			//ir a obs
			document.getElementById('TitDesX').innerHTML = 'Obs. Efectivo Entregado';
			SoloBlock('DesEfeEntDiv');
			
			document.getElementById('LetEnt').innerHTML = '<button onclick="TexUND1();" class="StyBoton" onmouseout="MM_swapImgRestore()" onmouseover="MM_swapImage(\'LetEntCC\',\'\',\'botones/ent-over.png\',0)"><img src="botones/ent-up.png" name="Enter" title="Enter" border="0" id="LetEntCC"/></button>';
			
			document.getElementById('NumVol').innerHTML = '<button onclick="TexUN6VOL();" class="StyBoton" onmouseout="MM_swapImgRestore()" onmouseover="MM_swapImage(\'LetVolCC\',\'\',\'botones/vol-over.png\',0)"><img src="botones/vol-up.png" name="Volver" title="Volver" border="0" id="LetVolCC"/></button>';
			
			document.getElementById('TexU6').value = dec(document.getElementById('TexU6').value,2);
			//$("#DesEfeEnt").select();
			document.getElementById('DesEfeEnt').value = "";
			document.getElementById("DondeE").value = "DesEfeEnt";
			document.getElementById("CantiE").value = "250";
			document.getElementById("QuePoE").value = "0";
			
		}
	
	}
	
}

function TexUN6VOL(){
	
	$("#DesEfeEntDiv").css("border-color", "transparent");
	$("#Div6").css("border-color", "#F90");
	
	EnvAyuda("Ingrese efectivo entregado a rendir.");
			
	document.getElementById('LetEnt').innerHTML = '<button onclick="TexUN6();" class="StyBoton" onmouseout="MM_swapImgRestore()" onmouseover="MM_swapImage(\'LetEntCC\',\'\',\'botones/ent-over.png\',0)"><img src="botones/ent-up.png" name="Enter" title="Enter" border="0" id="LetEntCC"/></button>';
	
	document.getElementById('NumVol').innerHTML = '<button onclick="TexUN3VOL();" class="StyBoton" onmouseout="MM_swapImgRestore()" onmouseover="MM_swapImage(\'LetVolCC\',\'\',\'botones/vol-over.png\',0)"><img src="botones/vol-up.png" name="Volver" title="Volver" border="0" id="LetVolCC"/></button>';
	document.getElementById('TexU6').value = "";
	//$("#TexU6").select();
	document.getElementById("DondeE").value = "TexU6";
	document.getElementById("CantiE").value = "12";
	document.getElementById("QuePoE").value = "1";

}

function TexUND1(){

	var clength = document.getElementById('DesEfeEnt').value.length;
	if(clength > 0){

		$("#DesEfeEntDiv").css("border-color", "transparent");
		$("#Div7").css("border-color", "#F90");
		
		EnvAyuda("Ingrese Bono Numero 1.");
		
		document.getElementById('LetEnt').innerHTML = '<button onclick="TexUN8();" class="StyBoton" onmouseout="MM_swapImgRestore()" onmouseover="MM_swapImage(\'LetEntCC\',\'\',\'botones/ent-over.png\',0)"><img src="botones/ent-up.png" name="Enter" title="Enter" border="0" id="LetEntCC"/></button>';
		
		document.getElementById('NumVol').innerHTML = '<button onclick="TexUND1VOL();" class="StyBoton" onmouseout="MM_swapImgRestore()" onmouseover="MM_swapImage(\'LetVolCC\',\'\',\'botones/vol-over.png\',0)"><img src="botones/vol-up.png" name="Volver" title="Volver" border="0" id="LetVolCC"/></button>';
		
		SoloNone('DesVueltoDiv');
		
		document.getElementById('TitDesX').innerHTML = 'Obs.';
		
		var texcat = document.getElementById("TexCat").value;
		if(texcat == 0){
			
			document.getElementById('LetEnt').style.display="none";
			document.getElementById('LetTer').style.display="block";
	
		}else{
		
			//$("#TexU7").select();
			document.getElementById('TexU7').value = "";
			document.getElementById("DondeE").value = "TexU7";
			document.getElementById("CantiE").value = "12";
			document.getElementById("QuePoE").value = "1";
		
		}
		
	}else{

		$("#DesEfeEntDiv").css("border-color", "transparent");
		$("#Div7").css("border-color", "#F90");

		EnvAyuda("Ingrese Bono Numero 1.");
		
		document.getElementById('DesVuelto').value = " ";
		
		document.getElementById('LetEnt').innerHTML = '<button onclick="TexUN8();" class="StyBoton" onmouseout="MM_swapImgRestore()" onmouseover="MM_swapImage(\'LetEntCC\',\'\',\'botones/ent-over.png\',0)"><img src="botones/ent-up.png" name="Enter" title="Enter" border="0" id="LetEntCC"/></button>';
		
		document.getElementById('NumVol').innerHTML = '<button onclick="TexUND1VOL();" class="StyBoton" onmouseout="MM_swapImgRestore()" onmouseover="MM_swapImage(\'LetVolCC\',\'\',\'botones/vol-over.png\',0)"><img src="botones/vol-up.png" name="Volver" title="Volver" border="0" id="LetVolCC"/></button>';
		
		SoloNone('DesVueltoDiv');
		
		document.getElementById('TitDesX').innerHTML = 'Obs.';
		
		var texcat = document.getElementById("TexCat").value;
		if(texcat == 0){
			
			document.getElementById('LetEnt').style.display="none";
			document.getElementById('LetTer').style.display="block";
	
		}else{
		
			//$("#TexU7").select();
			document.getElementById('TexU7').value = "";
			document.getElementById("DondeE").value = "TexU7";
			document.getElementById("CantiE").value = "12";
			document.getElementById("QuePoE").value = "1";
		
		}
	
	}


		/***** CAMPO PARA REGISTRAR EL VUELTO *****
		$("#DesEfeEntDiv").css("border-color", "transparent");
		$("#Div7").css("border-color", "#F90");
	
		EnvAyuda("Ingrese Vuelto a rendir.");
		
		document.getElementById('LetEnt').innerHTML = '<button onclick="TexUN7();" class="StyBoton" onmouseout="MM_swapImgRestore()" onmouseover="MM_swapImage(\'LetEntCC\',\'\',\'botones/ent-over.png\',0)"><img src="botones/ent-up.png" name="Enter" title="Enter" border="0" id="LetEntCC"/></button>';

		document.getElementById('NumVol').innerHTML = '<button onclick="TexUND1VOL();" class="StyBoton" onmouseout="MM_swapImgRestore()" onmouseover="MM_swapImage(\'LetVolCC\',\'\',\'botones/vol-over.png\',0)"><img src="botones/vol-up.png" name="Volver" title="Volver" border="0" id="LetVolCC"/></button>';
		
		document.getElementById('TexU7').value = "";
		
		document.getElementById("DondeE").value = "TexU7";
		document.getElementById("CantiE").value = "12";
		document.getElementById("QuePoE").value = "1";

	}else{

		document.getElementById('DesEfeEnt').value = " ";

		$("#DesEfeEntDiv").css("border-color", "transparent");
		$("#Div7").css("border-color", "#F90");
		
		EnvAyuda("Ingrese Vuelto a rendir.");
		
		document.getElementById('LetEnt').innerHTML = '<button onclick="TexUN7();" class="StyBoton" onmouseout="MM_swapImgRestore()" onmouseover="MM_swapImage(\'LetEntCC\',\'\',\'botones/ent-over.png\',0)"><img src="botones/ent-up.png" name="Enter" title="Enter" border="0" id="LetEntCC"/></button>';

		document.getElementById('NumVol').innerHTML = '<button onclick="TexUND1VOL();" class="StyBoton" onmouseout="MM_swapImgRestore()" onmouseover="MM_swapImage(\'LetVolCC\',\'\',\'botones/vol-over.png\',0)"><img src="botones/vol-up.png" name="Volver" title="Volver" border="0" id="LetVolCC"/></button>';
		
		document.getElementById('TexU7').value = "";
		
		document.getElementById("DondeE").value = "TexU7";
		document.getElementById("CantiE").value = "12";
		document.getElementById("QuePoE").value = "1";
		*/
	
}

function TexUND1VOL(){

	$("#Div7").css("border-color", "transparent");
	$("#DesEfeEntDiv").css("border-color", "#F90");
	
	EnvAyuda("Ingrese Obserbacion de Efectivo Entregado.");
	//ir a obs
	document.getElementById('TitDesX').innerHTML = 'Obs. Efectivo Entregado';
	SoloBlock('DesEfeEntDiv');
	
	document.getElementById('LetEnt').innerHTML = '<button onclick="TexUND1();" class="StyBoton" onmouseout="MM_swapImgRestore()" onmouseover="MM_swapImage(\'LetEntCC\',\'\',\'botones/ent-over.png\',0)"><img src="botones/ent-up.png" name="Enter" title="Enter" border="0" id="LetEntCC"/></button>';
	
	document.getElementById('NumVol').innerHTML = '<button onclick="TexUN6VOL();" class="StyBoton" onmouseout="MM_swapImgRestore()" onmouseover="MM_swapImage(\'LetVolCC\',\'\',\'botones/vol-over.png\',0)"><img src="botones/vol-up.png" name="Volver" title="Volver" border="0" id="LetVolCC"/></button>';
	
	document.getElementById('TexU6').value = dec(document.getElementById('TexU6').value,2);
	//$("#DesEfeEnt").select();
	document.getElementById('DesEfeEnt').value = "";
	document.getElementById("DondeE").value = "DesEfeEnt";
	document.getElementById("CantiE").value = "250";
	document.getElementById("QuePoE").value = "0";

}

function TexUN7(){
	
	var clength = document.getElementById('TexU7').value.length;
	var extexto = document.getElementById('TexU7').value;
	
	if (/^([0-9+\,])*$/.test(extexto)){
	
		if(clength > 0){
			
			$("#Div7").css("border-color", "transparent");
			$("#DesVueltoDiv").css("border-color", "#F90");
			
			EnvAyuda("Ingrese Observacion Vuelto.");
			
			//ir a obs
			SoloNone('DesEfeEntDiv');
			document.getElementById('TitDesX').innerHTML = 'Obs. Vuelto';
			SoloBlock('DesVueltoDiv');
			
			document.getElementById('LetEnt').innerHTML = '<button onclick="TexUND2();" class="StyBoton" onmouseout="MM_swapImgRestore()" onmouseover="MM_swapImage(\'LetEntCC\',\'\',\'botones/ent-over.png\',0)"><img src="botones/ent-up.png" name="Enter" title="Enter" border="0" id="LetEntCC"/></button>';
			
			document.getElementById('NumVol').innerHTML = '<button onclick="TexUN7VOL();" class="StyBoton" onmouseout="MM_swapImgRestore()" onmouseover="MM_swapImage(\'LetVolCC\',\'\',\'botones/vol-over.png\',0)"><img src="botones/vol-up.png" name="Volver" title="Volver" border="0" id="LetVolCC"/></button>';
			
			document.getElementById('TexU7').value = dec(document.getElementById('TexU7').value,2);
			
			document.getElementById('DesVuelto').value = "";
			document.getElementById("DondeE").value = "DesVuelto";
			document.getElementById("CantiE").value = "250";
			document.getElementById("QuePoE").value = "0";
			
		}else{
			
			document.getElementById("TexU7").value = 0;

			$("#Div7").css("border-color", "transparent");
			$("#DesVueltoDiv").css("border-color", "#F90");
			
			EnvAyuda("Ingrese Observacion Vuelto.");
			
			//ir a obs
			SoloNone('DesEfeEntDiv');
			document.getElementById('TitDesX').innerHTML = 'Obs. Vuelto';
			SoloBlock('DesVueltoDiv');
			
			document.getElementById('LetEnt').innerHTML = '<button onclick="TexUND2();" class="StyBoton" onmouseout="MM_swapImgRestore()" onmouseover="MM_swapImage(\'LetEntCC\',\'\',\'botones/ent-over.png\',0)"><img src="botones/ent-up.png" name="Enter" title="Enter" border="0" id="LetEntCC"/></button>';
			
			document.getElementById('NumVol').innerHTML = '<button onclick="TexUN7VOL();" class="StyBoton" onmouseout="MM_swapImgRestore()" onmouseover="MM_swapImage(\'LetVolCC\',\'\',\'botones/vol-over.png\',0)"><img src="botones/vol-up.png" name="Volver" title="Volver" border="0" id="LetVolCC"/></button>';
			
			document.getElementById('TexU7').value = dec(document.getElementById('TexU7').value,2);
			
			document.getElementById("DondeE").value = "DesVuelto";
			document.getElementById("CantiE").value = "250";
			document.getElementById("QuePoE").value = "0";
			
		}
	
	}
	
}

function TexUN7VOL(){

	$("#DesVueltoDiv").css("border-color", "transparent");
	$("#Div7").css("border-color", "#F90");

	EnvAyuda("Ingrese Vuelto a rendir.");

	document.getElementById('LetEnt').innerHTML = '<button onclick="TexUN7();" class="StyBoton" onmouseout="MM_swapImgRestore()" onmouseover="MM_swapImage(\'LetEntCC\',\'\',\'botones/ent-over.png\',0)"><img src="botones/ent-up.png" name="Enter" title="Enter" border="0" id="LetEntCC"/></button>';
	
	document.getElementById('NumVol').innerHTML = '<button onclick="TexUND1VOL();" class="StyBoton" onmouseout="MM_swapImgRestore()" onmouseover="MM_swapImage(\'LetVolCC\',\'\',\'botones/vol-over.png\',0)"><img src="botones/vol-up.png" name="Volver" title="Volver" border="0" id="LetVolCC"/></button>';
	
	//$("#TexU7").select();
	document.getElementById("TexU7").value = "";
	document.getElementById("DondeE").value = "TexU7";
	document.getElementById("CantiE").value = "12";
	document.getElementById("QuePoE").value = "1";

}
/***************************************************************************************************************************************************/
function TexUND2(){
	alert("ENTRO");
	var clength = document.getElementById('TexU7').value.length;
	var extexto = document.getElementById('TexU7').value;
	
	if (/^([0-9+\,])*$/.test(extexto)){
	
		if(clength > 0){
			
			document.getElementById('LetEnt').innerHTML = '<button onclick="TexUN9();" class="StyBoton" onmouseout="MM_swapImgRestore()" onmouseover="MM_swapImage(\'LetEntCC\',\'\',\'botones/ent-over.png\',0)"><img src="botones/ent-up.png" name="Enter" title="Enter" border="0" id="LetEntCC"/></button>';
			
			document.getElementById('NumVol').innerHTML = '<button onclick="TexU8VOL();" class="StyBoton" onmouseout="MM_swapImgRestore()" onmouseover="MM_swapImage(\'LetVolCC\',\'\',\'botones/vol-over.png\',0)"><img src="botones/vol-up.png" name="Volver" title="Volver" border="0" id="LetVolCC"/></button>';
				
			document.getElementById('TexU8').value = dec(document.getElementById('TexU8').value,2);
			
				$("#Div8").css("border-color", "transparent");
				$("#Div9").css("border-color", "#F90");

				EnvAyuda("Ingrese Bono Numero 2.");
				var tot = document.getElementById('TexU8').value;
				$("#archivos").load("Monn.php?id=1&elid=TexU8&tot="+tot);

			var texcat = document.getElementById("TexCat").value;
			if(texcat == 1){
				
				document.getElementById('LetEnt').style.display="none";
				document.getElementById('LetTer').style.display="block";
		
			}else{
				
				//$("#TexU9").select();
				document.getElementById("TexU9").value = "";
				document.getElementById("DondeE").value = "TexU9";
				document.getElementById("CantiE").value = "12";
				document.getElementById("QuePoE").value = "1";
				
			}
			
		}else{
			
			document.getElementById('LetEnt').innerHTML = '<button onclick="TexUN9();" class="StyBoton" onmouseout="MM_swapImgRestore()" onmouseover="MM_swapImage(\'LetEntCC\',\'\',\'botones/ent-over.png\',0)"><img src="botones/ent-up.png" name="Enter" title="Enter" border="0" id="LetEntCC"/></button>';
			
			document.getElementById('NumVol').innerHTML = '<button onclick="TexU8VOL();" class="StyBoton" onmouseout="MM_swapImgRestore()" onmouseover="MM_swapImage(\'LetVolCC\',\'\',\'botones/vol-over.png\',0)"><img src="botones/vol-up.png" name="Volver" title="Volver" border="0" id="LetVolCC"/></button>';
				
			document.getElementById('TexU8').value = dec(0,2);

			$("#Div8").css("border-color", "transparent");
			$("#Div9").css("border-color", "#F90");
			
			EnvAyuda("Ingrese Bono Numero 2.");
			
			var texcat = document.getElementById("TexCat").value;
			if(texcat == 1){
				
				document.getElementById('LetEnt').style.display="none";
				document.getElementById('LetTer').style.display="block";
		
			}else{
				
				//$("#TexU9").select();
				document.getElementById("TexU9").value = "";
				document.getElementById("DondeE").value = "TexU9";
				document.getElementById("CantiE").value = "12";
				document.getElementById("QuePoE").value = "1";
				
			}
			
		}
	}

}

//////////////////////////////////////////////////////////////////////////////////////////////////////////////
//////////////////////////////////////////////////////////////////////////////////////////////////////////////
function TexUND2VOL(){

	$("#Div7").css("border-color", "transparent");
	$("#DesEfeEntDiv").css("border-color", "#F90");
	
	EnvAyuda("Ingrese Obserbacion de Efectivo Entregado.");
	//ir a obs
	document.getElementById('TitDesX').innerHTML = 'Obs. Efectivo Entregado';
	SoloBlock('DesEfeEntDiv');
	
	document.getElementById('LetEnt').innerHTML = '<button onclick="TexUND1();" class="StyBoton" onmouseout="MM_swapImgRestore()" onmouseover="MM_swapImage(\'LetEntCC\',\'\',\'botones/ent-over.png\',0)"><img src="botones/ent-up.png" name="Enter" title="Enter" border="0" id="LetEntCC"/></button>';
	
	document.getElementById('NumVol').innerHTML = '<button onclick="TexUN6VOL();" class="StyBoton" onmouseout="MM_swapImgRestore()" onmouseover="MM_swapImage(\'LetVolCC\',\'\',\'botones/vol-over.png\',0)"><img src="botones/vol-up.png" name="Volver" title="Volver" border="0" id="LetVolCC"/></button>';
	
	//$("#DesEfeEnt").select();
	document.getElementById("DesEfeEnt").value = "";
	document.getElementById("DondeE").value = "DesEfeEnt";
	document.getElementById("CantiE").value = "250";
	document.getElementById("QuePoE").value = "0";
	
}


//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
function TexUN8(){

	var clength = document.getElementById('TexU7').value.length;
	var extexto = document.getElementById('TexU7').value;
	
	if (/^([0-9+\,])*$/.test(extexto)){
	
		if(clength > 0){
			
			document.getElementById('LetEnt').innerHTML = '<button onclick="TexUN9();" class="StyBoton" onmouseout="MM_swapImgRestore()" onmouseover="MM_swapImage(\'LetEntCC\',\'\',\'botones/ent-over.png\',0)"><img src="botones/ent-up.png" name="Enter" title="Enter" border="0" id="LetEntCC"/></button>';
			
			document.getElementById('NumVol').innerHTML = '<button onclick="TexU8VOL();" class="StyBoton" onmouseout="MM_swapImgRestore()" onmouseover="MM_swapImage(\'LetVolCC\',\'\',\'botones/vol-over.png\',0)"><img src="botones/vol-up.png" name="Volver" title="Volver" border="0" id="LetVolCC"/></button>';
				
			document.getElementById('TexU7').value = dec(document.getElementById('TexU7').value,2);
			
				$("#Div7").css("border-color", "transparent");
				$("#Div8").css("border-color", "#F90");

				EnvAyuda("Ingrese Bono Numero 2.");
				var tot = document.getElementById('TexU7').value;
				$("#archivos").load("Monn.php?id=1&elid=TexU7&tot="+tot);

			var texcat = document.getElementById("TexCat").value;
			if(texcat == 1){
				
				document.getElementById('LetEnt').style.display="none";
				document.getElementById('LetTer').style.display="block";
		
			}else{
				
				//$("#TexU8").select();
				document.getElementById("TexU8").value = "";
				document.getElementById("DondeE").value = "TexU8";
				document.getElementById("CantiE").value = "12";
				document.getElementById("QuePoE").value = "1";
				
			}
			
		}else{
			
			document.getElementById('LetEnt').innerHTML = '<button onclick="TexUN9();" class="StyBoton" onmouseout="MM_swapImgRestore()" onmouseover="MM_swapImage(\'LetEntCC\',\'\',\'botones/ent-over.png\',0)"><img src="botones/ent-up.png" name="Enter" title="Enter" border="0" id="LetEntCC"/></button>';
			
			document.getElementById('NumVol').innerHTML = '<button onclick="TexU8VOL();" class="StyBoton" onmouseout="MM_swapImgRestore()" onmouseover="MM_swapImage(\'LetVolCC\',\'\',\'botones/vol-over.png\',0)"><img src="botones/vol-up.png" name="Volver" title="Volver" border="0" id="LetVolCC"/></button>';
				
			document.getElementById('TexU7').value = dec(0,2);

			$("#Div7").css("border-color", "transparent");
			$("#Div8").css("border-color", "#F90");
			
			EnvAyuda("Ingrese Bono Numero 2.");
			
			var texcat = document.getElementById("TexCat").value;
			if(texcat == 1){
				
				document.getElementById('LetEnt').style.display="none";
				document.getElementById('LetTer').style.display="block";
		
			}else{
				
				//$("#TexU8").select();
				document.getElementById("TexU8").value = "";
				document.getElementById("DondeE").value = "TexU8";
				document.getElementById("CantiE").value = "12";
				document.getElementById("QuePoE").value = "1";
				
			}
			
		}
	
	}
	
}

function TexU8VOL(){ //////////////////////////////////////////////////////////////////////////////////////////////////////////////

	$("#Div8").css("border-color", "transparent");
	$("#Div7").css("border-color", "#F90");

	EnvAyuda("Ingrese Bono Numero 1.");
	//$("#TexU7").select();
	document.getElementById("TexU7").value = "";
	document.getElementById("DondeE").value = "TexU7";
	document.getElementById("CantiE").value = "12";
	document.getElementById("QuePoE").value = "1";
	
	document.getElementById('LetEnt').innerHTML = '<button onclick="TexUN8();" class="StyBoton" onmouseout="MM_swapImgRestore()" onmouseover="MM_swapImage(\'LetEntCC\',\'\',\'botones/ent-over.png\',0)"><img src="botones/ent-up.png" name="Enter" title="Enter" border="0" id="LetEntCC"/></button>';
	
	document.getElementById('NumVol').innerHTML = '<button onclick="TexUND2VOL();" class="StyBoton" onmouseout="MM_swapImgRestore()" onmouseover="MM_swapImage(\'LetVolCC\',\'\',\'botones/vol-over.png\',0)"><img src="botones/vol-up.png" name="Volver" title="Volver" border="0" id="LetVolCC"/></button>';

}

function TexUN9(){
	
	var clength = document.getElementById('TexU8').value.length;
	var extexto = document.getElementById('TexU8').value;

	if (/^([0-9+\,])*$/.test(extexto)){	
		if(clength > 0){
			
			document.getElementById('LetEnt').innerHTML = '<button onclick="TexUN10();" class="StyBoton" onmouseout="MM_swapImgRestore()" onmouseover="MM_swapImage(\'LetEntCC\',\'\',\'botones/ent-over.png\',0)"><img src="botones/ent-up.png" name="Enter" title="Enter" border="0" id="LetEntCC"/></button>';
			
			document.getElementById('NumVol').innerHTML = '<button onclick="TexU09VOL();" class="StyBoton" onmouseout="MM_swapImgRestore()" onmouseover="MM_swapImage(\'LetVolCC\',\'\',\'botones/vol-over.png\',0)"><img src="botones/vol-up.png" name="Volver" title="Volver" border="0" id="LetVolCC"/></button>';
			
			document.getElementById('TexU8').value = dec(document.getElementById('TexU8').value,2);

				$("#Div8").css("border-color", "transparent");
				$("#Div9").css("border-color", "#F90");

				EnvAyuda("Ingrese Bono Numero 3.");
				var tot = document.getElementById('TexU8').value;
				$("#archivos").load("Monn.php?id=2&elid=TexU8&tot="+tot);
				document.getElementById("TexU9").value = "";
				document.getElementById("DondeE").value = "TexU9";
				document.getElementById("CantiE").value = "12";
				document.getElementById("QuePoE").value = "1";

			var texcat = document.getElementById("TexCat").value;
			if(texcat == 2){
				
				document.getElementById('LetEnt').style.display="none";
				document.getElementById('LetTer').style.display="block";
				
			}else{
				//$("#TexU9").select();
				document.getElementById("TexU9").value = "";
				document.getElementById("DondeE").value = "TexU9";
				document.getElementById("CantiE").value = "12";
				document.getElementById("QuePoE").value = "1";
			}
			
		}else{
		
			document.getElementById('LetEnt').innerHTML = '<button onclick="TexUN10();" class="StyBoton" onmouseout="MM_swapImgRestore()" onmouseover="MM_swapImage(\'LetEntCC\',\'\',\'botones/ent-over.png\',0)"><img src="botones/ent-up.png" name="Enter" title="Enter" border="0" id="LetEntCC"/></button>';
			
			document.getElementById('NumVol').innerHTML = '<button onclick="TexU09VOL();" class="StyBoton" onmouseout="MM_swapImgRestore()" onmouseover="MM_swapImage(\'LetVolCC\',\'\',\'botones/vol-over.png\',0)"><img src="botones/vol-up.png" name="Volver" title="Volver" border="0" id="LetVolCC"/></button>';
			
			document.getElementById('TexU8').value = dec(0,2);
			
			$("#Div8").css("border-color", "transparent");
			$("#Div9").css("border-color", "#F90");

			EnvAyuda("Ingrese Bono Numero 3.");
			
			//$("#TexU9").select();
			document.getElementById("TexU9").value = "";
			document.getElementById("DondeE").value = "TexU9";
			document.getElementById("CantiE").value = "12";
			document.getElementById("QuePoE").value = "1";
			
			var texcat = document.getElementById("TexCat").value;
			if(texcat == 2){
				
				EnvAyuda("Confirmar la Caja.");
				
				document.getElementById('LetEnt').style.display="none";
				document.getElementById('LetTer').style.display="block";
				
			}else{
				//$("#TexU9").select();
				document.getElementById("TexU9").value = "";
				document.getElementById("DondeE").value = "TexU9";
				document.getElementById("CantiE").value = "12";
				document.getElementById("QuePoE").value = "1";
			}
		
		}
	
	}
	
}

function TexU9VOL(){ //////////////////////////////////////////////////////////////////////////////////////////////////////////////

	document.getElementById('LetEnt').innerHTML = '<button onclick="TexUN9();" class="StyBoton" onmouseout="MM_swapImgRestore()" onmouseover="MM_swapImage(\'LetEntCC\',\'\',\'botones/ent-over.png\',0)"><img src="botones/ent-up.png" name="Enter" title="Enter" border="0" id="LetEntCC"/></button>';
	
	document.getElementById('NumVol').innerHTML = '<button onclick="TexU08VOL();" class="StyBoton" onmouseout="MM_swapImgRestore()" onmouseover="MM_swapImage(\'LetVolCC\',\'\',\'botones/vol-over.png\',0)"><img src="botones/vol-up.png" name="Volver" title="Volver" border="0" id="LetVolCC"/></button>';
	
	
	$("#Div10").css("border-color", "transparent");
	$("#Div9").css("border-color", "#F90");

	//$("#TexU9").select();
	document.getElementById("TexU9").value = "";
	document.getElementById("DondeE").value = "TexU9";
	document.getElementById("CantiE").value = "12";
	document.getElementById("QuePoE").value = "1";

	EnvAyuda("Ingrese Bono Numero 3.");
	
	var texcat = document.getElementById("TexCat").value;

	if(texcat == 2){
	
		document.getElementById('LetEnt').style.display="block";
		document.getElementById('LetTer').style.display="none";
		
	}

}

function TexU09VOL(){ //////////////////////////////////////////////////////////////////////////////////////////////////////////////

	document.getElementById('LetEnt').innerHTML = '<button onclick="TexUN9();" class="StyBoton" onmouseout="MM_swapImgRestore()" onmouseover="MM_swapImage(\'LetEntCC\',\'\',\'botones/ent-over.png\',0)"><img src="botones/ent-up.png" name="Enter" title="Enter" border="0" id="LetEntCC"/></button>';
	
	document.getElementById('NumVol').innerHTML = '<button onclick="TexU8VOL();" class="StyBoton" onmouseout="MM_swapImgRestore()" onmouseover="MM_swapImage(\'LetVolCC\',\'\',\'botones/vol-over.png\',0)"><img src="botones/vol-up.png" name="Volver" title="Volver" border="0" id="LetVolCC"/></button>';
	
	$("#Div9").css("border-color", "transparent");
	$("#Div8").css("border-color", "#F90");

	EnvAyuda("Ingrese Bono Numero 2.");
	
	//$("#TexU8").select();
	document.getElementById("TexU8").value = "";
	document.getElementById("DondeE").value = "TexU8";
	document.getElementById("CantiE").value = "12";
	document.getElementById("QuePoE").value = "1";

	var texcat = document.getElementById("TexCat").value;
	if(texcat == 2){
	
		document.getElementById('LetEnt').style.display="block";
		document.getElementById('LetTer').style.display="none";
		
	}

}

function TexUN10(){
	
	var clength = document.getElementById('TexU10').value.length;
	var extexto = document.getElementById('TexU10').value;
	
	if (/^([0-9+\,])*$/.test(extexto)){
	
		if(clength > 0){
			
			document.getElementById('LetEnt').innerHTML = '<button onclick="TexUN11();" class="StyBoton" onmouseout="MM_swapImgRestore()" onmouseover="MM_swapImage(\'LetEntCC\',\'\',\'botones/ent-over.png\',0)"><img src="botones/ent-up.png" name="Enter" title="Enter" border="0" id="LetEntCC"/></button>';
			
			document.getElementById('NumVol').innerHTML = '<button onclick="TexU9VOL();" class="StyBoton" onmouseout="MM_swapImgRestore()" onmouseover="MM_swapImage(\'LetVolCC\',\'\',\'botones/vol-over.png\',0)"><img src="botones/vol-up.png" name="Volver" title="Volver" border="0" id="LetVolCC"/></button>';

			document.getElementById('TexU10').value = dec(document.getElementById('TexU10').value,2);

				$("#Div10").css("border-color", "transparent");
				$("#Div11").css("border-color", "#F90");
			
				EnvAyuda("Ingrese Bono Numero 4.");
				var tot = document.getElementById('TexU10').value;
				$("#archivos").load("Monn.php?id=3&elid=TexU10&tot="+tot);

			var texcat = document.getElementById("TexCat").value;
			if(texcat == 3){
				
				EnvAyuda("Confirmar la Caja.");
				
				document.getElementById('LetEnt').style.display="none";
				document.getElementById('LetTer').style.display="block";
		
			}else{
							
				document.getElementById('TexU11').value = "";
				
				document.getElementById("DondeE").value = "TexU11";
				document.getElementById("CantiE").value = "12";
				document.getElementById("QuePoE").value = "1";
				
			}
			
		}else{
			document.getElementById('LetEnt').innerHTML = '<button onclick="TexUN11();" class="StyBoton" onmouseout="MM_swapImgRestore()" onmouseover="MM_swapImage(\'LetEntCC\',\'\',\'botones/ent-over.png\',0)"><img src="botones/ent-up.png" name="Enter" title="Enter" border="0" id="LetEntCC"/></button>';
			
			document.getElementById('NumVol').innerHTML = '<button onclick="TexU9VOL();" class="StyBoton" onmouseout="MM_swapImgRestore()" onmouseover="MM_swapImage(\'LetVolCC\',\'\',\'botones/vol-over.png\',0)"><img src="botones/vol-up.png" name="Volver" title="Volver" border="0" id="LetVolCC"/></button>';

			document.getElementById('TexU10').value = dec(0,2);

			$("#Div10").css("border-color", "transparent");
			$("#Div11").css("border-color", "#F90");
			
			EnvAyuda("Ingrese Bono Numero 4.");
			
			var texcat = document.getElementById("TexCat").value;
			if(texcat == 3){
				
				EnvAyuda("Confirmar la Caja.");
				
				document.getElementById('LetEnt').style.display="none";
				document.getElementById('LetTer').style.display="block";
		
			}else{
							
				document.getElementById('TexU11').value = "";
				
				document.getElementById("DondeE").value = "TexU11";
				document.getElementById("CantiE").value = "12";
				document.getElementById("QuePoE").value = "1";
				
			}
			
		}
	
	}
	
}

function TexU10VOL(){ //////////////////////////////////////////////////////////////////////////////////////////////////////////////

	document.getElementById('LetEnt').innerHTML = '<button onclick="TexUN10();" class="StyBoton" onmouseout="MM_swapImgRestore()" onmouseover="MM_swapImage(\'LetEntCC\',\'\',\'botones/ent-over.png\',0)"><img src="botones/ent-up.png" name="Enter" title="Enter" border="0" id="LetEntCC"/></button>';
	
	document.getElementById('NumVol').innerHTML = '<button onclick="TexU09VOL();" class="StyBoton" onmouseout="MM_swapImgRestore()" onmouseover="MM_swapImage(\'LetVolCC\',\'\',\'botones/vol-over.png\',0)"><img src="botones/vol-up.png" name="Volver" title="Volver" border="0" id="LetVolCC"/></button>';
	
	$("#Div11").css("border-color", "transparent");
	$("#Div10").css("border-color", "#F90");
	
	EnvAyuda("Ingrese Bono Numero 3.");
	//$("#TexU10").select();
	document.getElementById('TexU10').value = "";
	document.getElementById("DondeE").value = "TexU10";
	document.getElementById("CantiE").value = "12";
	document.getElementById("QuePoE").value = "1";

}

function TexUN11(){
	
	var clength = document.getElementById('TexU11').value.length;
	var extexto = document.getElementById('TexU11').value;
	
	if (/^([0-9+\,])*$/.test(extexto)){
	
		if(clength > 0){
			
			document.getElementById('LetEnt').innerHTML = '<button onclick="TexUN12();" class="StyBoton" onmouseout="MM_swapImgRestore()" onmouseover="MM_swapImage(\'LetEntCC\',\'\',\'botones/ent-over.png\',0)"><img src="botones/ent-up.png" name="Enter" title="Enter" border="0" id="LetEntCC"/></button>';
			
			document.getElementById('NumVol').innerHTML = '<button onclick="TexU11VOL();" class="StyBoton" onmouseout="MM_swapImgRestore()" onmouseover="MM_swapImage(\'LetVolCC\',\'\',\'botones/vol-over.png\',0)"><img src="botones/vol-up.png" name="Volver" title="Volver" border="0" id="LetVolCC"/></button>';
			
			document.getElementById('TexU11').value = dec(document.getElementById('TexU11').value,2);

		
				EnvAyuda("Ingrese Bono Numero 5.");
				var tot = document.getElementById('TexU11').value;
				$("#archivos").load("Monn.php?id=4&elid=TexU11&tot="+tot);

			var texcat = document.getElementById("TexCat").value;
			if(texcat == 4){
				
				EnvAyuda("Confirmar la Caja.");
				
				document.getElementById('LetEnt').style.display="none";
				document.getElementById('LetTer').style.display="block";
		
			}else{
				
				//$("#TexU12").select();
				document.getElementById('TexU12').value = "";
				document.getElementById("DondeE").value = "TexU12";
				document.getElementById("CantiE").value = "12";
				document.getElementById("QuePoE").value = "1";
				
			}
			
				$("#Div11").css("border-color", "transparent");
				$("#Div12").css("border-color", "#F90");
		}else{
			
			document.getElementById('LetEnt').innerHTML = '<button onclick="TexUN12();" class="StyBoton" onmouseout="MM_swapImgRestore()" onmouseover="MM_swapImage(\'LetEntCC\',\'\',\'botones/ent-over.png\',0)"><img src="botones/ent-up.png" name="Enter" title="Enter" border="0" id="LetEntCC"/></button>';
			
			document.getElementById('NumVol').innerHTML = '<button onclick="TexU11VOL();" class="StyBoton" onmouseout="MM_swapImgRestore()" onmouseover="MM_swapImage(\'LetVolCC\',\'\',\'botones/vol-over.png\',0)"><img src="botones/vol-up.png" name="Volver" title="Volver" border="0" id="LetVolCC"/></button>';
			
			document.getElementById('TexU11').value = dec(0,2);

			$("#Div11").css("border-color", "transparent");
			$("#Div12").css("border-color", "#F90");
			
			EnvAyuda("Ingrese Bono Numero 5.");
				
			var texcat = document.getElementById("TexCat").value;
			if(texcat == 4){
				
				EnvAyuda("Confirmar la Caja.");
				
				document.getElementById('LetEnt').style.display="none";
				document.getElementById('LetTer').style.display="block";
		
			}else{
				
				//$("#TexU12").select();
				document.getElementById("TexU12").value = "";
				document.getElementById("DondeE").value = "TexU12";
				document.getElementById("CantiE").value = "12";
				document.getElementById("QuePoE").value = "1";
				
			}
			
		}
	
	}
	
}

function TexU11VOL(){ //////////////////////////////////////////////////////////////////////////////////////////////////////////////

	document.getElementById('LetEnt').innerHTML = '<button onclick="TexUN11();" class="StyBoton" onmouseout="MM_swapImgRestore()" onmouseover="MM_swapImage(\'LetEntCC\',\'\',\'botones/ent-over.png\',0)"><img src="botones/ent-up.png" name="Enter" title="Enter" border="0" id="LetEntCC"/></button>';
	
	document.getElementById('NumVol').innerHTML = '<button onclick="TexU10VOL();" class="StyBoton" onmouseout="MM_swapImgRestore()" onmouseover="MM_swapImage(\'LetVolCC\',\'\',\'botones/vol-over.png\',0)"><img src="botones/vol-up.png" name="Volver" title="Volver" border="0" id="LetVolCC"/></button>';
	
	document.getElementById('TexU12').value = "";
	document.getElementById('TexU11').value = "";

	EnvAyuda("Ingrese Bono Numero 4.");
	//$("#TexU11").select();
	document.getElementById("TexU11").value = "";
	document.getElementById("DondeE").value = "TexU11";
	document.getElementById("CantiE").value = "12";
	document.getElementById("QuePoE").value = "1";

	$("#Div11").css("border-color", "#F90");
	$("#Div12").css("border-color", "transparent");

}

function TexUN12(){
	
	var clength = document.getElementById('TexU12').value.length;
	var extexto = document.getElementById('TexU12').value;
	
	if (/^([0-9+\,])*$/.test(extexto)){
	
		if(clength > 0){
			
			document.getElementById('LetEnt').style.display="none";
			document.getElementById('LetTer').style.display="block";
			
			document.getElementById('NumVol').innerHTML = '<button onclick="TexU12VOL();" class="StyBoton" onmouseout="MM_swapImgRestore()" onmouseover="MM_swapImage(\'LetVolCC\',\'\',\'botones/vol-over.png\',0)"><img src="botones/vol-up.png" name="Volver" title="Volver" border="0" id="LetVolCC"/></button>';
			
			document.getElementById('TexU12').value = dec(document.getElementById('TexU12').value,2);

				$("#Div12").css("border-color", "transparent");
				$("#Div13").css("border-color", "#F90");

				EnvAyuda("Confirmar la Caja.");
				var tot = document.getElementById('TexU12').value;
				$("#archivos").load("Monn.php?id=5&elid=TexU12&tot="+tot);
			
			//$("#evitarcaracteres").select();
			document.getElementById("evitarcaracteres").value = "";
			document.getElementById("DondeE").value = "evitarcaracteres";
			document.getElementById("CantiE").value = "0";
			document.getElementById("QuePoE").value = "1";
			
		}else{
			
			document.getElementById('LetEnt').style.display="none";
			document.getElementById('LetTer').style.display="block";
			
			document.getElementById('NumVol').innerHTML = '<button onclick="TexU12VOL();" class="StyBoton" onmouseout="MM_swapImgRestore()" onmouseover="MM_swapImage(\'LetVolCC\',\'\',\'botones/vol-over.png\',0)"><img src="botones/vol-up.png" name="Volver" title="Volver" border="0" id="LetVolCC"/></button>';
			
			document.getElementById('TexU12').value = dec(0,2);

			$("#Div12").css("border-color", "transparent");
			$("#Div13").css("border-color", "#F90");
			
			EnvAyuda("Confirmar la Caja.");
			//$("#evitarcaracteres").select();
			document.getElementById("evitarcaracteres").value = "";
			document.getElementById("DondeE").value = "evitarcaracteres";
			document.getElementById("CantiE").value = "0";
			document.getElementById("QuePoE").value = "1";

		}
	
	}
	
}

function TexU12VOL(){ //////////////////////////////////////////////////////////////////////////////////////////////////////////////

	document.getElementById('LetEnt').innerHTML = '<button onclick="TexUN12();" class="StyBoton" onmouseout="MM_swapImgRestore()" onmouseover="MM_swapImage(\'LetEntCC\',\'\',\'botones/ent-over.png\',0)"><img src="botones/ent-up.png" name="Enter" title="Enter" border="0" id="LetEntCC"/></button>';
	
	document.getElementById('NumVol').innerHTML = '<button onclick="TexU11VOL();" class="StyBoton" onmouseout="MM_swapImgRestore()" onmouseover="MM_swapImage(\'LetVolCC\',\'\',\'botones/vol-over.png\',0)"><img src="botones/vol-up.png" name="Volver" title="Volver" border="0" id="LetVolCC"/></button>';
	
	$("#Div13").css("border-color", "transparent");
	$("#Div12").css("border-color", "#F90");
	
	EnvAyuda("Ingrese Bono Numero 5.");
	
	SoloNone('LetTer');
	SoloBlock('LetEnt');
	//$("#TexU12").select();
	document.getElementById("TexU12").value = "";
	document.getElementById("DondeE").value = "TexU12";
	document.getElementById("CantiE").value = "12";
	document.getElementById("QuePoE").value = "1";

}

function enviarformulario(){
	document.getElementById('TexU9').value = dec(0,2);
	
	SoloBlock("Bloquear");
	$('#FormCCaja').submit();

}

function SalirImp(){
	
	SoloNone('Confirmar, Impresion, ImpresionSal');
	document.getElementById('Confirmar').innerHTML = '';
	Mos_Ocu('BotonesPri');
	Mos_Ocu('Marca');
	
}

function ImpreImp(){
	
	window.print();
	
}

function SalirImpre(){
	
	SoloNone('Confirmar, ImpresionPdfDiv');
	document.getElementById('Confirmar').innerHTML = '';
	Mos_Ocu('BotonesPri');
	Mos_Ocu('Marca');
	
}