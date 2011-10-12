$("#EncDat3").css("border-color", "#0FF");


function VolRemitos(){

	var mod = document.getElementById("HabFunModCom").value;
	
	if(mod == 1){	

		$("#EncDat16").css("border-color", "transparent");
		$("#EncDat14").css("border-color", "#F90");	
		
		EnvAyuda("Ingrese importe de descuento.");
	
		document.getElementById("EDat14").value = "";
		
		document.getElementById("DondeE").value = "EDat14";
		document.getElementById("CantiE").value = "12";
		document.getElementById("QuePoE").value = "1";
		
		document.getElementById('LetEnt').innerHTML = '<button onclick="Descuento();" class="StyBoton" onmouseout="MM_swapImgRestore()" onmouseover="MM_swapImage(\'LetEntFac\',\'\',\'botones/ent-over.png\',0)"><img src="botones/ent-up.png" name="Enter" title="Enter" border="0" id="LetEntFac"/></button>';
		
		document.getElementById('NumVol').innerHTML = '<button onclick="VolFecDes();" class="StyBoton" onmouseout="MM_swapImgRestore()" onmouseover="MM_swapImage(\'LetVolChe\',\'\',\'botones/vol-over.png\',0)"><img src="botones/vol-up.png" name="Volver" title="Volver" border="0" id="LetVolChe"/></button>';
	
		SoloNone("LetTer");
		
		controlarcadainputcom("EDat14");
		
	}else{
	
		document.getElementById("EDat15").value = "";
		document.getElementById("EDat16").value = "";
	
		$("#EncDat16").css("border-color", "transparent");
		$("#EncDat15").css("border-color", "#F90");
		
		EnvAyuda("Enter: Continua. Consultar: Ingresa remitos al comprobante.");
				
		document.getElementById("DondeE").value = "EDat15";
		document.getElementById("CantiE").value = "0";
		document.getElementById("QuePoE").value = "1";
		
		document.getElementById('LetEnt').innerHTML = '<button onclick="Remitos();" class="StyBoton" onmouseout="MM_swapImgRestore()" onmouseover="MM_swapImage(\'LetEntFac\',\'\',\'botones/ent-over.png\',0)"><img src="botones/ent-up.png" name="Enter" title="Enter" border="0" id="LetEntFac"/></button>';
		
		document.getElementById('NumVol').innerHTML = '<button onclick="VolDescu();" class="StyBoton" onmouseout="MM_swapImgRestore()" onmouseover="MM_swapImage(\'LetVolChe\',\'\',\'botones/vol-over.png\',0)"><img src="botones/vol-up.png" name="Volver" title="Volver" border="0" id="LetVolChe"/></button>';
	
		controlarcadainputcom("EDat15");
	
		var rem = document.getElementById("EDat7_3").value;
		if(rem != "RE"){
		
			SoloBlock("LetTer");
			
			document.getElementById('LetTer').innerHTML = '<button onclick="ConRemitos();" class="StyBoton" onmouseout="MM_swapImgRestore()" onmouseover="MM_swapImage(\'LetConFac\',\'\',\'botones/con-over.png\',0)"><img src="botones/con-up.png" name="Consultar" title="Consultar" border="0" id="LetConFac"/></button>';
			
		}
	}
}

function Empresa(){

	var t = document.getElementById('EDat16').value;
	if(t.length == 0){

		document.getElementById('EDat16').value = document.getElementById('NumEmpresa').value;

		$("#EncDat15").css("border-color", "transparent");
		$("#EncDat16").css("border-color", "transparent");
		$("#EncDat17").css("border-color", "#F90");
		
		EnvAyuda("Ingrese la cantidad de cuotas del comprobante.");
				
		document.getElementById("DondeE").value = "EDat17";
		document.getElementById("CantiE").value = "2";
		document.getElementById("QuePoE").value = "1";
		
		document.getElementById('LetEnt').innerHTML = '<button onclick="Cuotas();" class="StyBoton" onmouseout="MM_swapImgRestore()" onmouseover="MM_swapImage(\'LetEntFac\',\'\',\'botones/ent-over.png\',0)"><img src="botones/ent-up.png" name="Enter" title="Enter" border="0" id="LetEntFac"/></button>';
		
		document.getElementById('NumVol').innerHTML = '<button onclick="VolEmpresa();" class="StyBoton" onmouseout="MM_swapImgRestore()" onmouseover="MM_swapImage(\'LetVolChe\',\'\',\'botones/vol-over.png\',0)"><img src="botones/vol-up.png" name="Volver" title="Volver" border="0" id="LetVolChe"/></button>';
		
		controlarcadainputcom("EDat17");
		
	}else{
		if (/^([0-9])*$/.test(t)){
			if(t != 0){

				$("#EncDat16").css("border-color", "transparent");
				$("#EncDat17").css("border-color", "#F90");
			
				EnvAyuda("Ingrese la cantidad de cuotas del comprobante.");
					
				document.getElementById("DondeE").value = "EDat17";
				document.getElementById("CantiE").value = "2";
				document.getElementById("QuePoE").value = "1";
				
				document.getElementById('LetEnt').innerHTML = '<button onclick="Cuotas();" class="StyBoton" onmouseout="MM_swapImgRestore()" onmouseover="MM_swapImage(\'LetEntFac\',\'\',\'botones/ent-over.png\',0)"><img src="botones/ent-up.png" name="Enter" title="Enter" border="0" id="LetEntFac"/></button>';
				
				document.getElementById('NumVol').innerHTML = '<button onclick="VolEmpresa();" class="StyBoton" onmouseout="MM_swapImgRestore()" onmouseover="MM_swapImage(\'LetVolChe\',\'\',\'botones/vol-over.png\',0)"><img src="botones/vol-up.png" name="Volver" title="Volver" border="0" id="LetVolChe"/></button>';
				
				controlarcadainputcom("EDat17");
						
			}
		}		
	}
}

function VolEmpresa(){
	
	document.getElementById("EDat16").value = "";
	document.getElementById("EDat17").value = "";

	$("#EncDat17").css("border-color", "transparent");
	$("#EncDat16").css("border-color", "#F90");
	
	EnvAyuda("Ingrese empresa del comprobante.");
						
	document.getElementById("DondeE").value = "EDat16";
	document.getElementById("CantiE").value = "8";
	document.getElementById("QuePoE").value = "1";
	
	document.getElementById('LetEnt').innerHTML = '<button onclick="Empresa();" class="StyBoton" onmouseout="MM_swapImgRestore()" onmouseover="MM_swapImage(\'LetEntFac\',\'\',\'botones/ent-over.png\',0)"><img src="botones/ent-up.png" name="Enter" title="Enter" border="0" id="LetEntFac"/></button>';
	
	document.getElementById('NumVol').innerHTML = '<button onclick="VolRemitos();" class="StyBoton" onmouseout="MM_swapImgRestore()" onmouseover="MM_swapImage(\'LetVolChe\',\'\',\'botones/vol-over.png\',0)"><img src="botones/vol-up.png" name="Volver" title="Volver" border="0" id="LetVolChe"/></button>';

	controlarcadainputcom("EDat16");

}

function Cuotas(){

	var t = document.getElementById('EDat17').value;
	if (/^([0-9])*$/.test(t)){	
		if(t != 0){
			if(t.length != 0){

				$("#EncDat17").css("border-color", "transparent");
				$("#EncDat18").css("border-color", "#F90");
				
				EnvAyuda("Ingrese Nota de pedido del comprobante.");
									
				document.getElementById("DondeE").value = "EDat18";
				document.getElementById("CantiE").value = "8";
				document.getElementById("QuePoE").value = "1";
				
				document.getElementById('LetEnt').innerHTML = '<button onclick="NotaPed();" class="StyBoton" onmouseout="MM_swapImgRestore()" onmouseover="MM_swapImage(\'LetEntFac\',\'\',\'botones/ent-over.png\',0)"><img src="botones/ent-up.png" name="Enter" title="Enter" border="0" id="LetEntFac"/></button>';
				
				document.getElementById('NumVol').innerHTML = '<button onclick="VolPedid();" class="StyBoton" onmouseout="MM_swapImgRestore()" onmouseover="MM_swapImage(\'LetVolChe\',\'\',\'botones/vol-over.png\',0)"><img src="botones/vol-up.png" name="Volver" title="Volver" border="0" id="LetVolChe"/></button>';

				controlarcadainputcom("EDat18");

			}
		}else{
			
			document.getElementById('EDat17').value = 1;

			$("#EncDat17").css("border-color", "transparent");
			$("#EncDat18").css("border-color", "#F90");
						
			EnvAyuda("Ingrese Nota de pedido del comprobante.");
				
			document.getElementById("DondeE").value = "EDat18";
			document.getElementById("CantiE").value = "8";
			document.getElementById("QuePoE").value = "1";
			
			document.getElementById('LetEnt').innerHTML = '<button onclick="NotaPed();" class="StyBoton" onmouseout="MM_swapImgRestore()" onmouseover="MM_swapImage(\'LetEntFac\',\'\',\'botones/ent-over.png\',0)"><img src="botones/ent-up.png" name="Enter" title="Enter" border="0" id="LetEntFac"/></button>';
			
			document.getElementById('NumVol').innerHTML = '<button onclick="VolPedid();" class="StyBoton" onmouseout="MM_swapImgRestore()" onmouseover="MM_swapImage(\'LetVolChe\',\'\',\'botones/vol-over.png\',0)"><img src="botones/vol-up.png" name="Volver" title="Volver" border="0" id="LetVolChe"/></button>';
		
			controlarcadainputcom("EDat18");
		
		}
	}

}

function VolPedid(){
	
	document.getElementById("EDat17").value = "";
	document.getElementById("EDat18").value = "";

	$("#EncDat18").css("border-color", "transparent");
	$("#EncDat17").css("border-color", "#F90");
	
	EnvAyuda("Ingrese la cantidad de cuotas del comprobante.");
			
	document.getElementById("DondeE").value = "EDat17";
	document.getElementById("CantiE").value = "2";
	document.getElementById("QuePoE").value = "1";
	
	document.getElementById('LetEnt').innerHTML = '<button onclick="Cuotas();" class="StyBoton" onmouseout="MM_swapImgRestore()" onmouseover="MM_swapImage(\'LetEntFac\',\'\',\'botones/ent-over.png\',0)"><img src="botones/ent-up.png" name="Enter" title="Enter" border="0" id="LetEntFac"/></button>';
	
	document.getElementById('NumVol').innerHTML = '<button onclick="VolEmpresa();" class="StyBoton" onmouseout="MM_swapImgRestore()" onmouseover="MM_swapImage(\'LetVolChe\',\'\',\'botones/vol-over.png\',0)"><img src="botones/vol-up.png" name="Volver" title="Volver" border="0" id="LetVolChe"/></button>';
	
	controlarcadainputcom("EDat17");
	
}

function NotaPed(){
	
	var t = document.getElementById('EDat18').value;
	if (/^([0-9])*$/.test(t)){	
		if(t != 0){
			if(t.length != 0){
				
				SoloBlock("ImputarA");

				document.getElementById("EDat10").value = "";

				$("#EncDat18").css("border-color", "transparent");
				
				EnvAyuda("Seleccione una opción o ingrese el num que desea imputar.");
									
				document.getElementById("DondeE").value = "LetTex";
				document.getElementById("CantiE").value = "1";
				document.getElementById("QuePoE").value = "1";
				
				document.getElementById('LetEnt').innerHTML = '<button onclick="CambiarImp(1);" class="StyBoton" onmouseout="MM_swapImgRestore()" onmouseover="MM_swapImage(\'LetEntFac\',\'\',\'botones/ent-over.png\',0)"><img src="botones/ent-up.png" name="Enter" title="Enter" border="0" id="LetEntFac"/></button>';
				
				document.getElementById('NumVol').innerHTML = '<button onclick="VolImp();" class="StyBoton" onmouseout="MM_swapImgRestore()" onmouseover="MM_swapImage(\'LetVolChe\',\'\',\'botones/vol-over.png\',0)"><img src="botones/vol-up.png" name="Volver" title="Volver" border="0" id="LetVolChe"/></button>';
				
				controlarcadainputcom("EDat10");
			}
		}else{
		
			document.getElementById('EDat18').value = 0;
			
			SoloBlock("ImputarA");
				
			document.getElementById("EDat10").value = "";

			$("#EncDat18").css("border-color", "transparent");
			
			EnvAyuda("Seleccione una opción o ingrese el num que desea imputar.");
				
			document.getElementById("DondeE").value = "LetTex";
			document.getElementById("CantiE").value = "1";
			document.getElementById("QuePoE").value = "1";
			
			document.getElementById('LetEnt').innerHTML = '<button onclick="CambiarImp(1);" class="StyBoton" onmouseout="MM_swapImgRestore()" onmouseover="MM_swapImage(\'LetEntFac\',\'\',\'botones/ent-over.png\',0)"><img src="botones/ent-up.png" name="Enter" title="Enter" border="0" id="LetEntFac"/></button>';
			
			document.getElementById('NumVol').innerHTML = '<button onclick="VolImp();" class="StyBoton" onmouseout="MM_swapImgRestore()" onmouseover="MM_swapImage(\'LetVolChe\',\'\',\'botones/vol-over.png\',0)"><img src="botones/vol-up.png" name="Volver" title="Volver" border="0" id="LetVolChe"/></button>';			
			
			controlarcadainputcom("EDat10");
		}
	}
	
}

function VolImp(){

	document.getElementById("EDat18").value = "";
	
	var a = document.getElementById("EDat10").value;
	if(a.length == 1){
		if(!isNaN(a)){
			CambiarImp(a);
		}else{
			CambiarImp(1);
		}
	}else{
		var b = document.getElementById("EDat10Val").value;
		CambiarImp(b);
	}	
	
	SoloNone("ImputarA");
	
	$("#EncDat11").css("border-color", "transparent");
	$("#EncDat18").css("border-color", "#F90");
	
	EnvAyuda("Ingrese Nota de pedido del comprobante.");
						
	document.getElementById("DondeE").value = "EDat18";
	document.getElementById("CantiE").value = "8";
	document.getElementById("QuePoE").value = "1";
	
	document.getElementById('LetEnt').innerHTML = '<button onclick="NotaPed();" class="StyBoton" onmouseout="MM_swapImgRestore()" onmouseover="MM_swapImage(\'LetEntFac\',\'\',\'botones/ent-over.png\',0)"><img src="botones/ent-up.png" name="Enter" title="Enter" border="0" id="LetEntFac"/></button>';
	
	document.getElementById('NumVol').innerHTML = '<button onclick="VolPedid();" class="StyBoton" onmouseout="MM_swapImgRestore()" onmouseover="MM_swapImage(\'LetVolChe\',\'\',\'botones/vol-over.png\',0)"><img src="botones/vol-up.png" name="Volver" title="Volver" border="0" id="LetVolChe"/></button>';

	controlarcadainputcom("EDat18");

}

function CambiarImp(mp){

	$("#Imp"+mp).addClass("Imp"+mp+"-2");
	
	if(mp == 1){
		document.getElementById("EDat10Val").value = mp;
		document.getElementById("EDat10").value = "BIENES";
	}
	if(mp == 2){
		document.getElementById("EDat10Val").value = mp;
		document.getElementById("EDat10").value = "SERVICIOS";
	}
	if(mp == 3){
		document.getElementById("EDat10Val").value = mp;
		document.getElementById("EDat10").value = "CONTADO";
	}
	if(mp == 4){
		document.getElementById("EDat10Val").value = mp;
		document.getElementById("EDat10").value = "GASTOS A DETERMINAR";
	}
	
		for (i=1; i<=4; i++){
			
			if(i != mp){
				$("#Imp"+i).removeClass("Imp"+i+"-2");
			}
	
		}
	
	SoloNone("ImputarA");

	$("#EncDat11").css("border-color", "#F90");

	EnvAyuda("Ingrese el codigo de CAI.");
									
	document.getElementById("DondeE").value = "EDat11";
	document.getElementById("CantiE").value = "15";
	document.getElementById("QuePoE").value = "1";
	
	document.getElementById('LetEnt').innerHTML = '<button onclick="ImgCai();" class="StyBoton" onmouseout="MM_swapImgRestore()" onmouseover="MM_swapImage(\'LetEntFac\',\'\',\'botones/ent-over.png\',0)"><img src="botones/ent-up.png" name="Enter" title="Enter" border="0" id="LetEntFac"/></button>';

	document.getElementById('NumVol').innerHTML = '<button onclick="ImputarVol();" class="StyBoton" onmouseout="MM_swapImgRestore()" onmouseover="MM_swapImage(\'LetVolChe\',\'\',\'botones/vol-over.png\',0)"><img src="botones/vol-up.png" name="Volver" title="Volver" border="0" id="LetVolChe"/></button>';

	controlarcadainputcom("EDat11");

}

function ImputarVol(){

	document.getElementById("EDat11").value = "";
	document.getElementById("EDat10").value = "";
		
	SoloBlock("ImputarA");
	
	$("#EncDat11").css("border-color", "transparent");

	EnvAyuda("Seleccione una opción o ingrese el num que desea imputar.");

	document.getElementById("DondeE").value = "LetTex";
	document.getElementById("CantiE").value = "0";
	document.getElementById("QuePoE").value = "1";
	
	document.getElementById('LetEnt').innerHTML = '<button class="StyBoton" onmouseout="MM_swapImgRestore()" onmouseover="MM_swapImage(\'LetEntFac\',\'\',\'botones/ent-over.png\',0)"><img src="botones/ent-up.png" name="Enter" title="Enter" border="0" id="LetEntFac"/></button>';
	
	document.getElementById('NumVol').innerHTML = '<button onclick="VolImp();" class="StyBoton" onmouseout="MM_swapImgRestore()" onmouseover="MM_swapImage(\'LetVolChe\',\'\',\'botones/vol-over.png\',0)"><img src="botones/vol-up.png" name="Volver" title="Volver" border="0" id="LetVolChe"/></button>';
	
	controlarcadainputcom("EDat10");

}

function ImgCai(){
	
	var t = document.getElementById('EDat11').value;

	if(t.length == 0){

		$("#EncDat11").css("border-color", "transparent");
		$("#EncDat12").css("border-color", "#F90");
				
		EnvAyuda("Ingrese vencimiento del CAI.");
		
		document.getElementById('EDat11').value = "";
		
		document.getElementById("DondeE").value = "EDat12";
		document.getElementById("CantiE").value = "8";
		document.getElementById("QuePoE").value = "1";
		
		document.getElementById('LetEnt').innerHTML = '<button onclick="VenCai();" class="StyBoton" onmouseout="MM_swapImgRestore()" onmouseover="MM_swapImage(\'LetEntFac\',\'\',\'botones/ent-over.png\',0)"><img src="botones/ent-up.png" name="Enter" title="Enter" border="0" id="LetEntFac"/></button>';
		
		document.getElementById('NumVol').innerHTML = '<button onclick="VolVCai();" class="StyBoton" onmouseout="MM_swapImgRestore()" onmouseover="MM_swapImage(\'LetVolChe\',\'\',\'botones/vol-over.png\',0)"><img src="botones/vol-up.png" name="Volver" title="Volver" border="0" id="LetVolChe"/></button>';
		
		SoloNone("LetTer");
		
		controlarcadainputcom("EDat12");
	
	}else{	

		if (/^([0-9])*$/.test(t)){

			if(t != 0){

				$("#EncDat11").css("border-color", "transparent");
				$("#EncDat12").css("border-color", "#F90");
				
				EnvAyuda("Ingrese vencimiento del CAI.");
	
				document.getElementById("DondeE").value = "EDat12";
				document.getElementById("CantiE").value = "8";
				document.getElementById("QuePoE").value = "1";
				
				document.getElementById('LetEnt').innerHTML = '<button onclick="VenCai();" class="StyBoton" onmouseout="MM_swapImgRestore()" onmouseover="MM_swapImage(\'LetEntFac\',\'\',\'botones/ent-over.png\',0)"><img src="botones/ent-up.png" name="Enter" title="Enter" border="0" id="LetEntFac"/></button>';
				
				document.getElementById('NumVol').innerHTML = '<button onclick="VolVCai();" class="StyBoton" onmouseout="MM_swapImgRestore()" onmouseover="MM_swapImage(\'LetVolChe\',\'\',\'botones/vol-over.png\',0)"><img src="botones/vol-up.png" name="Volver" title="Volver" border="0" id="LetVolChe"/></button>';
				
				controlarcadainputcom("EDat12");
						
			}
		}		
	}
}

function ImgCaiVol(){

	document.getElementById("EDat10").value = "";
	document.getElementById("EDat11").value = "";

	$("#EncDat12").css("border-color", "transparent");
	$("#EncDat11").css("border-color", "#F90");
	
	EnvAyuda("Ingrese el codigo de CAI.");
						
	document.getElementById("DondeE").value = "EDat11";
	document.getElementById("CantiE").value = "14";
	document.getElementById("QuePoE").value = "1";
	
	document.getElementById('LetEnt').innerHTML = '<button onclick="ImgCai();" class="StyBoton" onmouseout="MM_swapImgRestore()" onmouseover="MM_swapImage(\'LetEntFac\',\'\',\'botones/ent-over.png\',0)"><img src="botones/ent-up.png" name="Enter" title="Enter" border="0" id="LetEntFac"/></button>';

	document.getElementById('NumVol').innerHTML = '<button onclick="ImputarVol();" class="StyBoton" onmouseout="MM_swapImgRestore()" onmouseover="MM_swapImage(\'LetVolChe\',\'\',\'botones/vol-over.png\',0)"><img src="botones/vol-up.png" name="Volver" title="Volver" border="0" id="LetVolChe"/></button>';
	
	controlarcadainputcom("EDat11");
	
}

function VenCai(){

	var fecemision  = document.getElementById("EDat12").value.length;
	if(fecemision == 0){
	
		var now = new Date();
		var d = str_pad(now.getDate(), 2, '0', 'STR_PAD_LEFT');
		var m = str_pad(now.getMonth() + 1, 2, '0', 'STR_PAD_LEFT');
		var y = now.getFullYear();
		var fecha = d+"/"+m+"/"+y;	
		document.getElementById("EDat12").value = fecha;
		
		$("#EncDat12").css("border-color", "transparent");
		
		EnvAyuda("Seleccione unidades.");
				
		SoloNone('ComBotEncDiv, Encabezado, EncabezadoDat, ComBotCueDiv, ComBotPieDiv');
		SoloBlock('ComprasDfon, Cantidadesx, CantidadesxDat');

		controlarcadainputcom("EDatUnidades");

		document.getElementById("DondeE").value = "LetTex";
		document.getElementById("CantiE").value = "0";
		document.getElementById("QuePoE").value = "1";
		
		SoloNone("LetEnt");
		SoloNone("NumVol");
		
		document.getElementById('LetEnt').innerHTML = '<button class="StyBoton" onmouseout="MM_swapImgRestore()" onmouseover="MM_swapImage(\'LetEntFac\',\'\',\'botones/ent-over.png\',0)"><img src="botones/ent-up.png" name="Enter" title="Enter" border="0" id="LetEntFac"/></button>';
		
		document.getElementById('LetTer').innerHTML = '<button class="StyBoton" onclick="FormEncabezadoSub();" onmouseout="MM_swapImgRestore()" onmouseover="MM_swapImage(\'LetCont\',\'\',\'botones/cont-over.png\',0)"><img src="botones/cont-up.png" name="Continuar" title="Continuar" border="0" id="LetCont"/></button>';
		
		document.getElementById('NumVol').innerHTML = '<button class="StyBoton" onmouseout="MM_swapImgRestore()" onmouseover="MM_swapImage(\'LetVolChe\',\'\',\'botones/vol-over.png\',0)"><img src="botones/vol-up.png" name="Volver" title="Volver" border="0" id="LetVolChe"/></button>';

	}else{
		
	if(fecemision != 10){
		ErrorFecha("EDat12");
	}else{
		
		var femis  = document.getElementById("EDat12").value;
		var arreglo_e = femis.split("/");
		var fecha_ya = new Date();
		var anio = fecha_ya.getFullYear();
	
		var edia  = arreglo_e[0].length;
		var emes  = arreglo_e[1].length;		
		var eanio  = arreglo_e[2].length;
	
		if(arreglo_e[0] > 31 || arreglo_e[1] > 12 || arreglo_e[2] > anio ){
			ErrorFecha("EDat12");
		}else{
			
			if(arreglo_e[0] > 28 & arreglo_e[1] == 2){
				ErrorFecha("EDat12");
			}else{
			
				if( edia == 2){
					if( emes == 2){
						if( eanio == 4){
							
							EnvAyuda("Seleccione unidades.");
							
							document.getElementById("DondeE").value = "LetTex";
							document.getElementById("CantiE").value = "0";
							document.getElementById("QuePoE").value = "1";

							SoloNone('ComBotEncDiv, Encabezado, EncabezadoDat, LetEnt, NumVol, ComBotCueDiv, ComBotPieDiv');

							SoloBlock('ComprasDfon, Cantidadesx, CantidadesxDat');
							
							document.getElementById('LetEnt').innerHTML = '<button class="StyBoton" onmouseout="MM_swapImgRestore()" onmouseover="MM_swapImage(\'LetEntFac\',\'\',\'botones/ent-over.png\',0)"><img src="botones/ent-up.png" name="Enter" title="Enter" border="0" id="LetEntFac"/></button>';

							document.getElementById('LetTer').innerHTML = '<button class="StyBoton" onclick="FormEncabezadoSub();" onmouseout="MM_swapImgRestore()" onmouseover="MM_swapImage(\'LetCont\',\'\',\'botones/cont-over.png\',0)"><img src="botones/cont-up.png" name="Continuar" title="Continuar" border="0" id="LetCont"/></button>';

							document.getElementById('NumVol').innerHTML = '<button class="StyBoton" onmouseout="MM_swapImgRestore()" onmouseover="MM_swapImage(\'LetVolChe\',\'\',\'botones/vol-over.png\',0)"><img src="botones/vol-up.png" name="Volver" title="Volver" border="0" id="LetVolChe"/></button>';

							controlarcadainputcom("EDatUnidades");
							
						}else{
							ErrorFecha("EDat12");
						}
					}else{
						ErrorFecha("EDat12");
					}
				}else{
					ErrorFecha("EDat12");
				}
			}
		}
	}
  	}

}

function VolVCai(){
	
	document.getElementById("EDat10").value = "";
	document.getElementById("EDat11").value = "";

	$("#EncDat12").css("border-color", "transparent");
	$("#EncDat11").css("border-color", "#F90");
	
	EnvAyuda("Ingrese el codigo de CAI.");
						
	document.getElementById("DondeE").value = "EDat11";
	document.getElementById("CantiE").value = "14";
	document.getElementById("QuePoE").value = "1";

	document.getElementById('LetEnt').innerHTML = '<button onclick="ImgCai();" class="StyBoton" onmouseout="MM_swapImgRestore()" onmouseover="MM_swapImage(\'LetEntFac\',\'\',\'botones/ent-over.png\',0)"><img src="botones/ent-up.png" name="Enter" title="Enter" border="0" id="LetEntFac"/></button>';

	document.getElementById('NumVol').innerHTML = '<button onclick="ImputarVol();" class="StyBoton" onmouseout="MM_swapImgRestore()" onmouseover="MM_swapImage(\'LetVolChe\',\'\',\'botones/vol-over.png\',0)"><img src="botones/vol-up.png" name="Volver" title="Volver" border="0" id="LetVolChe"/></button>';
	
	controlarcadainputcom("EDat11");
	
}

function IngresoXCan(xu){
	
	document.getElementById("EDat19").value = xu;

//	FRANCO	//	
	if(xu == 2){
		
		$('#BotXUV').attr({
			src: 'Compras/botunidadventa-over.png',
		});
		
		$('#BotXUM').attr({
			src: 'Compras/botunidadmedida-up.png',
		});
		
	}else{
	
		$('#BotXUV').attr({
			src: 'Compras/botunidadventa-up.png',
		});
		
		$('#BotXUM').attr({
			src: 'Compras/botunidadmedida-over.png',
		});
		
	}
//////////////	

	controlarcadainputcom("EDatUnidadesCont");	
	
	EnvAyuda("Precione continuar para cargar los articulos.");
	SoloBlock("LetTer");
	
	return false;
	
}

function FormEncabezadoSub(){
	
	$("#CueDat1").css("border-color", "#F90");
	
	$('#Bloquear').fadeIn(500);
		SoloNone('Cantidadesx, CantidadesxDat');
	$('#FormEncabezadoCom').submit();	
	
}

//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////

function movpaga_icom(p){

	np = p - 1;
	document.getElementById('capa_icom'+p).style.display="none";	
	document.getElementById('capa_icom'+np).style.display="block";
	
return false;

}

function movpag_icom(p){

	np = p + 1;
	document.getElementById('capa_icom'+p).style.display="none";	
	document.getElementById('capa_icom'+np).style.display="block";
	
return false;

}

function listadocomcom(){
	
	$('#Bloquear').fadeIn(500);

	SoloNone('ComprasFondo, ComprasDatos, fondotranspletras, TecladoLet, fondotranspnumeros, TecladoNum, CarAyuda, CarAyudaFon, BotMins2');
	SoloBlock('LisFacComFon, LisFacComFon2, TituloLis, TituloNom, TituloLisFac, LisFacComLis, BotonesLis');

	var tip = document.getElementById("EDat7_2").value;
	var tco = document.getElementById("EDat7_3").value;
	var suc = document.getElementById("EDat7_1").value;
	var cod = document.getElementById("EDat3").value;
	
	$("#LisFacComLis").load("TFCompraP.php?tip="+tip+"&tco="+tco+"&suc="+suc+"&cod="+cod);

	//controlarcadainputcom("EscapeComprobantes");	
}

function SalLisCom(){
	
	$('#Bloquear').fadeIn(500);

		SoloBlock('ComprasFondo, ComprasDatos, fondotranspletras, TecladoLet, fondotranspnumeros, TecladoNum, CarAyuda, CarAyudaFon, BotMins2');
		SoloNone('LisFacComFon, LisFacComFon2, TituloLis, TituloNom, TituloLisFac, LisFacComLis, LisFacComDat, BotonesLis');

	$('#Bloquear').fadeOut(500);

}

function enviarbarra(){

	var cb = document.getElementById("CDat1").value;
	if(cb.length != 0){
		$("#archivos").load("Control2.php?xd=1&cb="+cb);
	}
}

function enviarsucursal(){
	
	var cs = document.getElementById("CDat2").value;	
	if(cs.length != 0){
		
		document.getElementById("DondeE").value = "CDat3";
		document.getElementById("CantiE").value = "5";
		document.getElementById("QuePoE").value = "1";
		
		$("#CueDat2").css("border-color", "transparent");
		$("#CueDat3").css("border-color", "#F90");		
		
		EnvAyuda("Ingrese codigo de articulo.");
	
		document.getElementById('LetEnt').innerHTML = '<button class="StyBoton" onclick="enviarsucursal2();" onmouseout="MM_swapImgRestore()" onmouseover="MM_swapImage(\'LetEntFac\',\'\',\'botones/ent-over.png\',0)"><img src="botones/ent-up.png" name="Enter" title="Enter" border="0" id="LetEntFac"/></button>';
	
		SoloBlock("LetTer");
		
		document.getElementById('LetTer').innerHTML = '<button class="StyBoton" onclick="enviararticulo();" onmouseout="MM_swapImgRestore()" onmouseover="MM_swapImage(\'LetConFac\',\'\',\'botones/con-over.png\',0)"><img src="botones/con-up.png" name="Consultar" title="Consultar" border="0" id="LetConFac"/></button>';

		SoloBlock("NumVol");
		
		document.getElementById('NumVol').innerHTML = '<button class="StyBoton" onclick="volversuc();" onmouseout="MM_swapImgRestore()" onmouseover="MM_swapImage(\'LetNumFac\',\'\',\'botones/vol-over.png\',0)"><img src="botones/vol-up.png" name="Volver" title="Volver" border="0" id="LetNumFac"/></button>';
		
		controlarcadainputcom("CDat3");
		
	}
	
}

function enviarsucursal2(){

	var cs = document.getElementById("CDat2").value;
	var ca = document.getElementById("CDat3").value;
	if(cs.length != 0){
		if(ca.length != 0){
			
			$("#archivos").load("Control2.php?xd=2&cs="+cs+"&ca="+ca);
			SoloNone("LetTer");
			
		}
	}
}

function volversuc(){

	document.getElementById("CDat2").value = "";
	document.getElementById("CDat3").value = "";
	
	$("#CueDat3").css("border-color", "transparent");
	$("#CueDat2").css("border-color", "#F90");		

	EnvAyuda("Ingrese sucursal del articulo.");

	document.getElementById("DondeE").value = "CDat2";
	document.getElementById("CantiE").value = "2";
	document.getElementById("QuePoE").value = "1";
	
	document.getElementById('LetEnt').innerHTML = '<button class="StyBoton" onclick="enviarsucursal();" onmouseout="MM_swapImgRestore()" onmouseover="MM_swapImage(\'LetEntFac\',\'\',\'botones/ent-over.png\',0)"><img src="botones/ent-up.png" name="Enter" title="Enter" border="0" id="LetEntFac"/></button>';

	controlarcadainputcom("CDat2");

}

function enviararticulo(){
	
$('#Bloquear').fadeIn(500);
	
	SoloNone("CuerpoLista");
	
	var cs = document.getElementById("CDat2").value;
	$("#BusquedaCodDebo").load("ComFacBus.php?xd=1&cs="+cs);
	
	//$("#CueDat2").css("border-color", "transparent");
	controlarcadainputcom("CDat2");
	SoloBlock("BusquedaCodDebo");
	
}

function enviarorigen(){

	var co = document.getElementById("CDat1").value;
	var cp = document.getElementById("EDat3").value;
	if(co.length != 0){
		if(cp.length != 0){
			
			$("#archivos").load("Control2.php?xd=3&co="+co+"&cp="+cp);
			
			controlarcadainputcom("CDat4");
			
			SoloBlock("LetTer");
			
			document.getElementById('LetTer').innerHTML = '<button class="StyBoton" onclick="enviarcodorigen();" onmouseout="MM_swapImgRestore()" onmouseover="MM_swapImage(\'LetConFac\',\'\',\'botones/con-over.png\',0)"><img src="botones/con-up.png" name="Consultar" title="Consultar" border="0" id="LetConFac"/></button>';
			
		}
	}
}

function enviarcodorigen(){

$('#Bloquear').fadeIn(500);
	
	SoloNone("CuerpoLista");
	var cp = document.getElementById("EDat3").value;
	$("#BusquedaCodOrigen").load("ComFacBus.php?xd=2&cp="+cp);
	
	SoloBlock("BusquedaCodOrigen");

}


function enviaritmdbuscod(coo,ccs,cca){
	
	document.getElementById("CDat1").value = coo;
	
	$("#archivos").load("Control2.php?xd=2&cs="+ccs+"&ca="+cca);
	
}

function enviaritmdbus(ccs,cca){

	$("#archivos").load("Control2.php?xd=2&cs="+ccs+"&ca="+cca);
	
}

function enviarCodO(){

	var sec = document.getElementById("CDat2").value;
	var art = document.getElementById("CDat3").value;
	var coo = document.getElementById("CDat4").value;
	var coo1 = document.getElementById("CDat1").value;
	
	if(coo.length != 0){
	
		if(coo != 0){
			$("#archivos").load("RCodOri.php?sec="+sec+"&art="+art+"&coo="+coo+"&coo1="+coo1);
			controlarcadainputcom("CDat5");
		}
	
	}else{
		
		SoloNone('CueDat4');
		SoloNone('CueDat4-2');			
		
		document.getElementById('LetEnt').innerHTML = '<button class="StyBoton" onclick="ControlCan();" onmouseout="MM_swapImgRestore()" onmouseover="MM_swapImage(\'LetEntFac\',\'\',\'botones/ent-over.png\',0)"><img src="botones/ent-up.png" name="Enter" title="Enter" border="0" id="LetEntFac"/></button>';

		$("#CueDat4").css("border-color", "transparent");
		$("#CueDat5").css("border-color", "#F90");

		EnvAyuda("Ingrese cantidad.");
			
		document.getElementById("DondeE").value = "CDat5";
		document.getElementById("CantiE").value = "10";
		document.getElementById("QuePoE").value = "1";
		
		controlarcadainputcom("CDat5");
		
	}
	
}

function ControlCan(){

	var t = document.getElementById('CDat5').value;
	if (/^([0-9])*$/.test(t)){
		if(t != 0){
			if(t.length != 0){

/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
///////////////////////// CARGA POR REMITO //////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////

				
				SoloNone('CueDat4');
				SoloNone('CueDat4-2');	
		
				var tip = document.getElementById('EDat7_2').value;
				var tco = document.getElementById('EDat7_3').value;
				if(tip == 'R' && tco == 'RE'){
					
					SoloNone('LetEnt');
					SoloBlock('LetTer');
					
					var pre = document.getElementById('CDat8').value;
					var can = document.getElementById('CDat5').value;
					var tot = pre * can;  
					tot = tot.toFixed(2);
					document.getElementById('CDat10').value = tot;
					
					$("#CueDat5").css("border-color", "transparent");
					$("#CueDat10").css("border-color", "transparent");
					
					EnvAyuda("Continuar para confirmar la carga del item.");
					
					controlarcadainputcom("CDatContinuar");
					
					document.getElementById('LetTer').innerHTML = '<button class="StyBoton" onclick="confirmarI();" onmouseout="MM_swapImgRestore()" onmouseover="MM_swapImage(\'LetCont\',\'\',\'botones/cont-over.png\',0)"><img src="botones/cont-up.png" name="Continuar" title="Continuar" border="0" id="LetCont"/></button>';
				
				}else{
					
					$("#CueDat5").css("border-color", "transparent");
					$("#CueDat8").css("border-color", "#F90");
		
					EnvAyuda("Ingrese Costo o utilize el de la planilla.");
					
					document.getElementById('LetEnt').innerHTML = '<button class="StyBoton" onclick="ControlCosto();" onmouseout="MM_swapImgRestore()" onmouseover="MM_swapImage(\'LetEntFac\',\'\',\'botones/ent-over.png\',0)"><img src="botones/ent-up.png" name="Enter" title="Enter" border="0" id="LetEntFac"/></button>';
							
					document.getElementById("DondeE").value = "CDat8";
					document.getElementById("CantiE").value = "10";
					document.getElementById("QuePoE").value = "1";
					
					controlarcadainputcom("CDat8");
					
				}
				
			}
		}
	}
	
}

function ControlCosto(){
	
	var t = document.getElementById('CDat8').value;
	if (/^([0-9+\.])*$/.test(t)){
		if(t != 0){
			if(t.length != 0){
				
				////	CONTROLAR LA CANTIDAD INGRESADA HACE REFERENCIA AL COSTO TOTAL
				var cant = document.getElementById('CDat5').value;
				costo = parseFloat(t) / parseInt(cant);
				document.getElementById("CDat8").value = dec2(costo,4);
								
				$("#CueDat8").css("border-color", "transparent");
				$("#CueDat9").css("border-color", "#F90");
				
				EnvAyuda("Ingrese porcentaje de descuento.");
				
				document.getElementById('LetEnt').innerHTML = '<button class="StyBoton" onclick="DescuentoCosto();" onmouseout="MM_swapImgRestore()" onmouseover="MM_swapImage(\'LetEntFac\',\'\',\'botones/ent-over.png\',0)"><img src="botones/ent-up.png" name="Enter" title="Enter" border="0" id="LetEntFac"/></button>';	
				SoloBlock('CueDat9');
				SoloBlock('CueDat9-2');
				
				document.getElementById("DondeE").value = "CDat9";
				document.getElementById("CantiE").value = "3";
				document.getElementById("QuePoE").value = "1";
				
				controlarcadainputcom("CDat9");
				
			}
		}
	}
	
}

function DescuentoCosto(){
	
	var t = document.getElementById('CDat9').value;
	if(t.length == 0){

		SoloNone('CueDat9');
		SoloNone('CueDat9-2');
		
		$("#CueDat9").css("border-color", "transparent");
		$("#CueDat").css("border-color", "#F90");
		
		EnvAyuda("Enter para calcular sub totales.");
	
		document.getElementById("DondeE").value = "LetTex";
		document.getElementById("CantiE").value = "3";
		document.getElementById("QuePoE").value = "1";
					
		document.getElementById('LetEnt').innerHTML = '<button class="StyBoton" onclick="subtotalesdeI();" onmouseout="MM_swapImgRestore()" onmouseover="MM_swapImage(\'LetEntFac\',\'\',\'botones/ent-over.png\',0)"><img src="botones/ent-up.png" name="Enter" title="Enter" border="0" id="LetEntFac"/></button>';	

		controlarcadainputcom("CDatCalcSub");
		
	}else{
		if (/^([0-9+\.])*$/.test(t)){
			if(t != 0 && t <= 100){
			
				SoloNone('CueDat9');
				SoloNone('CueDat9-2');
				
				var pre = document.getElementById('CDat8').value;
				var por = document.getElementById('CDat9').value;
				por = (por / 100) + 1;
				var pre_n = pre / por;
				pre_n = pre_n.toFixed(4);
				document.getElementById('CDat8').value = pre_n;
				
				EnvAyuda("Enter para calcular sub totales.");
			
				document.getElementById("DondeE").value = "LetTex";
				document.getElementById("CantiE").value = "3";
				document.getElementById("QuePoE").value = "1";
							
				document.getElementById('LetEnt').innerHTML = '<button class="StyBoton" onclick="subtotalesdeI();" onmouseout="MM_swapImgRestore()" onmouseover="MM_swapImage(\'LetEntFac\',\'\',\'botones/ent-over.png\',0)"><img src="botones/ent-up.png" name="Enter" title="Enter" border="0" id="LetEntFac"/></button>';	

				controlarcadainputcom("CDatCalcSub");

			}
		}
	}
	
}

function subtotalesdeI(){
	
	SoloNone('LetEnt');
	SoloBlock('LetTer');
	
	var pre = document.getElementById('CDat8').value;
	var can = document.getElementById('CDat5').value;
	var tot = pre * can;  
	tot = tot.toFixed(2);
	document.getElementById('CDat10').value = tot;
	
	EnvAyuda("Continuar para confirmar la carga del item.");
	
	document.getElementById('LetTer').innerHTML = '<button class="StyBoton" onclick="confirmarI();" onmouseout="MM_swapImgRestore()" onmouseover="MM_swapImage(\'LetCont\',\'\',\'botones/cont-over.png\',0)"><img src="botones/cont-up.png" name="Continuar" title="Continuar" border="0" id="LetCont"/></button>';
	
	controlarcadainputcom("CDatContinuar");
}

function confirmarI(){
	
$('#Bloquear').fadeIn(500);
	
	SoloNone('CueDat2, CueDat3, CueDat5, CuerpoLista2, CuerpoProdu2, LetTer');
	SoloBlock('CueDat1, CuerpoLista, CuerpoProdu3');
	
	var ccs = document.getElementById('CDat2').value;
	var cca = document.getElementById('CDat3').value;
	var ccp = document.getElementById('CDat8').value;
	var ccc = document.getElementById('CDat5').value;
	var ccd = document.getElementById('CDat6').value; 
	
	var cme = document.getElementById('ComenzarComPI').value;
	
	if(cme == 0){ 
		NuevoIFC(ccs,cca,ccp,ccc,ccd);
	}else{
		ModificarIFC(ccs,cca,ccp,ccc,ccd);
	}

	controlarcadainputcom("CDat1");
		
	document.getElementById("DondeE").value = "CDat1";
	document.getElementById("CantiE").value = "13";
	document.getElementById("QuePoE").value = "1";
			

	document.getElementById('CDat1').value = "";
	document.getElementById('CDat2').value = "";
	document.getElementById('CDat3').value = "";
	document.getElementById('CDat4').value = "";
	document.getElementById('CDat5').value = "";
	document.getElementById('CDat6').value = "";
	document.getElementById('CDat7').value = "";
	document.getElementById('CDat8').value = "";
	document.getElementById('CDat8-2').value = "";
	document.getElementById('CDat9').value = "";
	document.getElementById('CDat10').value = "";
	document.getElementById('CDat11').value = "";
	document.getElementById('CDat11-2').value = "";

	$("#CueDat1").css("border-color", "#F90");

	document.getElementById('LetEnt').innerHTML = '<button class="StyBoton" onclick="enviarorigen();" onmouseout="MM_swapImgRestore()" onmouseover="MM_swapImage(\'LetEntFac\',\'\',\'botones/ent-over.png\',0)"><img src="botones/ent-up.png" name="Enter" title="Enter" border="0" id="LetEntFac"/></button>';
	
	document.getElementById('LetTer').innerHTML = '<button class="StyBoton" onclick="EnvCuerpo();" onmouseout="MM_swapImgRestore()" onmouseover="MM_swapImage(\'LetCont\',\'\',\'botones/cont-over.png\',0)"><img src="botones/cont-up.png" name="Continuar" title="Continuar" border="0" id="LetCont"/></button>';

	SoloBlock('LetEnt, ComBotBusDiv, LetTer');
	
	
	$('#Bloquear').fadeOut(500);

}


function ModificarIFC(ccs,cca,ccp,ccc,ccd){

	EnvAyuda("Ingrese código de barras.");
	
	var cst = document.getElementById('CDat10').value;
	var ccp_v = document.getElementById('CDat8-2').value;
	var dep = document.getElementById('CDat11-2').value;	
	
	document.getElementById('LetEnt').innerHTML = '<button class="StyBoton" onclick="ReeCodigo()" onmouseout="MM_swapImgRestore()" onmouseover="MM_swapImage(\'LetEnttt\',\'\',\'botones/ent-over.png\',0)"><img src="botones/ent-up.png" name="Enter" title="Enter" border="0" id="LetEnttt"/></button>';
	
	var cme = document.getElementById('ComenzarComPI').value;
	if(ccs == 0 && cca == 0){
		var det = ccd.replace(/ /g, "~");
		$("#archivos").load("NCArt.php?xd="+cme+"&cc="+ccc+"&cp="+ccp+"&ccd="+det+"&cn=-1");
	}else{
		$("#archivos").load("NCArt.php?xd="+cme+"&cs="+ccs+"&ca="+cca+"&cc="+ccc+"&cp="+ccp);
	}

	document.getElementById('itmesdecom'+cme).innerHTML = "";

	/*  LISTA DE ITEMS CON DIVISIONES POR COLUMNA PERO SIN COLOR  */
	document.getElementById('itmesdecom'+cme).innerHTML = "<div class=\"itemslista\" onclick=\"env_ite_c("+ccs+","+cca+","+cme+");\"><table width=\"640\" cellpadding=\"0\" cellspacing=\"1\" align=\"center\" border=\"0\"><tr><td class=\"CCom\" width=\"21\"><div align=\"center\">"+cme+"</div></td><td class=\"CCom\" width=\"61\"><div align=\"center\">"+ccs+" - "+cca+"</div></td><td class=\"CCom\" width=\"65\"><div align=\"center\">"+ccc+"</div></td><td class=\"CCom\" width=\"156\"><div align=\"left\">"+ccd.substr(0,25)+"</div></td><td class=\"CCom\" width=\"92\"><div align=\"center\">"+ccp_v+"</div></td><td class=\"CCom\" width=\"92\"><div align=\"center\">"+ccp+"</div></td><td class=\"CCom\" width=\"92\"><div align=\"center\">"+cst+"</div></td><td class=\"CCom\" width=\"38\"><div align=\"center\">"+dep+"</div></td></tr></table></div>";

	document.getElementById('ComenzarComPI').value = 0;

}

////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////

function env_ite_c(ccs,cca,cN){

	document.getElementById('ComBotModDiv').innerHTML = '<button class="StyBoton" onClick="TarModFacItm('+ccs+','+cca+','+cN+');" onMouseOut="MM_swapImgRestore()" onMouseOver="MM_swapImage(\'ComBotMod\',\'\',\'botones/mod-over.png\',0)"><img src="botones/mod-up.png" border="0" id="ComBotMod"/></button>';
		
	document.getElementById('ComBotEliDiv').innerHTML = '<button class="StyBoton" onClick="TarEliFacItm('+ccs+','+cca+','+cN+');" onMouseOut="MM_swapImgRestore()" onMouseOver="MM_swapImage(\'ComBotEli\',\'\',\'botones/eli-over.png\',0)"><img src="botones/eli-up.png" border="0" id="ComBotEli"/></button>';
	
	SoloBlock('ComBotModDiv, ComBotEliDiv');
	
}

var capa = 1;
var cc = 0;

function envcosto(tot,cN){

	//fabian vallejo
	$('#Bloquear').fadeIn(500);
	
	if(tot <= cN){

		var cp = document.getElementById("ModCosto"+cN).value;
		var xd = cN;

		document.getElementById("ModCosto"+cN).value = dec(cp.replace(",","."));
		
		$("#celda"+cN).removeClass("CComSinP2").addClass("CComSinP1");
		
		document.getElementById('NumVol').innerHTML = '<button class="StyBoton" onclick="VolEnvCosto('+tot+','+cN+');" onmouseout="MM_swapImgRestore()" onmouseover="MM_swapImage(\'NumVolCos\',\'\',\'botones/vol-over.png\',0)"><img src="botones/vol-up.png" name="Volver" title="Volver" border="0" id="NumVolCos"/></button>';
		
		$("#archivos").load("NCArt.php?cn=0&xd="+xd+"&cp="+cp);
	
		document.getElementById("permiso").value = 0;
		
		controlarcadainputcom("CDatCosto");
		
		EnvAyuda("Continuar para completar totales.");
		SoloBlock("ComBotBusDiv, LetTer");
		SoloNone("LetEnt");
		
		cc = cc + 1;
		
		document.getElementById('LetTer').innerHTML = '<button class="StyBoton" onclick="EnvCuerpo();" onmouseout="MM_swapImgRestore()" onmouseover="MM_swapImage(\'LetCont\',\'\',\'botones/cont-over.png\',0)"><img src="botones/cont-up.png" name="Continuar" title="Continuar" border="0" id="LetCont"/></button>';
		
	}else{

		var costo = document.getElementById('ModCosto'+cN).value;

		if (/^([0.00-9+\,])*$/.test(costo)){	

			if(costo.length != 0){
			
				cc = cc + 1;

				if(cc == 6 && tot != 6){

					movaba_com(capa);
					capa = capa + 1;
					cc = 0;
					
				}
				
				var cp = document.getElementById("ModCosto"+cN).value;
				var xd = cN;

				SoloBlock('LetEnt, NumVol');
				
				document.getElementById("ModCosto"+cN).value = dec(cp.replace(",","."));
				
				$("#celda"+cN).removeClass("CComSinP2").addClass("CComSinP1");
				
				document.getElementById('NumVol').innerHTML = '<button class="StyBoton" onclick="VolEnvCosto('+tot+','+cN+');" onmouseout="MM_swapImgRestore()" onmouseover="MM_swapImage(\'NumVolCos\',\'\',\'botones/vol-over.png\',0)"><img src="botones/vol-up.png" name="Volver" title="Volver" border="0" id="NumVolCos"/></button>';
				
				cN = cN + 1;
				
				$("#celda"+cN).removeClass("CComSinP1").addClass("CComSinP2");
				
				EnvAyuda("Ingrese costo para el item "+cN);
								
				document.getElementById("DondeE").value = "ModCosto"+cN;
				document.getElementById("CantiE").value = "10";
				document.getElementById("QuePoE").value = "1";
						
				document.getElementById('LetEnt').innerHTML = '<button class="StyBoton" onclick="envcosto('+tot+','+cN+');" onmouseout="MM_swapImgRestore()" onmouseover="MM_swapImage(\'LetEntFac\',\'\',\'botones/ent-over.png\',0)"><img src="botones/ent-up.png" name="Enter" title="Enter" border="0" id="LetEntFac"/></button>';

				$("#archivos").load("NCArt.php?cn=0&xd="+xd+"&cp="+cp);
				
				controlarcadainputcom("ModCosto"+cN);
					
			}
		}
	}

	$('#Bloquear').fadeOut(500);

	
}

function VolEnvCosto(tot,cN){

	if(cN == 1){
		
		cc = cc - 1;
				
		var a = cN + 1;
		$("#celda"+a).removeClass("CComSinP2").addClass("CComSinP1");
		
		$("#celda"+cN).removeClass("CComSinP1").addClass("CComSinP2");
		
		SoloNone("NumVol");

		EnvAyuda("Ingrese costo para el item "+cN);
						
		document.getElementById("DondeE").value = "ModCosto"+cN;
		document.getElementById("CantiE").value = "10";
		document.getElementById("QuePoE").value = "1";
		
		document.getElementById('LetEnt').innerHTML = '<button class="StyBoton" onclick="envcosto('+tot+','+cN+');" onmouseout="MM_swapImgRestore()" onmouseover="MM_swapImage(\'LetEntFac\',\'\',\'botones/ent-over.png\',0)"><img src="botones/ent-up.png" name="Enter" title="Enter" border="0" id="LetEntFac"/></button>';
		
		controlarcadainputcom("ModCosto"+cN);
		
	}else{
		
		if(tot == cN){
			SoloNone("ComBotBusDiv, LetTer");
			SoloBlock("LetEnt");
		}
		
		if(cc == 0 && tot != 0){
			movant_com(capa);
			capa = capa - 1;
			cc = 6;
			
		}else{
			cc = cc - 1;
		}
		
		var sig = cN + 1;
		$("#celda"+sig).removeClass("CComSinP2").addClass("CComSinP1");
		
		$("#celda"+cN).removeClass("CComSinP1").addClass("CComSinP2");
		
		EnvAyuda("Ingrese costo para el item "+cN);
						
		document.getElementById("DondeE").value = "ModCosto"+cN;
		document.getElementById("CantiE").value = "10";
		document.getElementById("QuePoE").value = "1";
		
		document.getElementById('LetEnt').innerHTML = '<button class="StyBoton" onclick="envcosto('+tot+','+cN+');" onmouseout="MM_swapImgRestore()" onmouseover="MM_swapImage(\'LetEntFac\',\'\',\'botones/ent-over.png\',0)"><img src="botones/ent-up.png" name="Enter" title="Enter" border="0" id="LetEntFac"/></button>';
		
		var ant = cN - 1;
		document.getElementById('NumVol').innerHTML = '<button class="StyBoton" onclick="VolEnvCosto('+tot+','+ant+');" onmouseout="MM_swapImgRestore()" onmouseover="MM_swapImage(\'NumVolCos\',\'\',\'botones/vol-over.png\',0)"><img src="botones/vol-up.png" name="Volver" title="Volver" border="0" id="NumVolCos"/></button>';

		controlarcadainputcom("ModCosto"+cN);
		
	}

}


////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////

function movant_com(p){

	np = p - 1;
	document.getElementById('comcapasitems'+p).style.display="none";	
	document.getElementById('comcapasitems'+np).style.display="block";

}

function movaba_com(p){

	np = p + 1;
	document.getElementById('comcapasitems'+p).style.display="none";	
	document.getElementById('comcapasitems'+np).style.display="block";

}

var cc = 0;
var cs = 1;
var cN = 0;

function NuevoIFC(ccs,cca,ccp,ccc,ccd){

	var comenzar = document.getElementById('ComenzarCom').value;
	
	if(comenzar == 0){
		cc = 0;
		cs = 1;
		cN = 0;
		document.getElementById('ComenzarCom').value = 1;
	}
	if(comenzar == 2){
		
		var pdv = document.getElementById('ComenzarComV2').value;
		pdv = parseInt(pdv);
		
		var i = pdv;
		var c = 6;
		
		var pe = i / c;
		pe = parseInt(pe);
	
		var va = pe * c;
		va = i - va;
	
		cc = va;
		cs = pe + 1;
		cN = i;
		document.getElementById('ComenzarCom').value = 1;
	}
	
		cN = cN + 1;
		cc = cc + 1;
		
		if (cc == 1){
				
			$("#CuerpoListaCI").append("<div id=\"comcapasitems"+cs+"\" style=\"display: block; left:2px; position:absolute;\">");
						
			if(cs != 1){
	
				$("#comcapasitems"+cs).append("<div id=\"Ant_Pro_TiC"+cs+"\" style=\"position:absolute; cursor:pointer; z-index:2; left:642px; top:27px;\"><button class=\"StyBoton\" onclick=\"return movant_com("+cs+");\" onMouseOut=\"MM_swapImgRestore()\" onMouseOver=\"MM_swapImage('AntProTiC','','otros/scr_arri-over.png',0)\"><img src=\"otros/scr_arri-up.png\" border=\"0\" id=\"AntProTiC\"/></button></div>");
				
				cnp = cs - 1;
				$("#comcapasitems"+cnp).fadeOut(tim);
				$("#comcapasitems"+cs).fadeIn(tim);
				
				$("#comcapasitems"+cnp).append("<div id=\"Aba_Pro_TiC"+cnp+"\" style=\"position:absolute; cursor:pointer; z-index:2; left:642px; top:156px;\"><button class=\"StyBoton\" onclick=\"return movaba_com("+cnp+");\" onMouseOut=\"MM_swapImgRestore()\" onMouseOver=\"MM_swapImage('AbaProTiC','','otros/scr_aba-over.png',0)\"><img src=\"otros/scr_aba-up.png\" border=\"0\" id=\"AbaProTiC\"/></button></div>");
				
			}
	
		}
	
		EnvAyuda("Ingrese código de barras.");
		
		var cst = document.getElementById('CDat10').value;
		var ccp_v = document.getElementById('CDat8-2').value;
		var dep = document.getElementById('CDat11-2').value;	
		
		document.getElementById('LetEnt').innerHTML = '<button class="StyBoton" onclick="ReeCodigo()" onmouseout="MM_swapImgRestore()" onmouseover="MM_swapImage(\'LetEnttt\',\'\',\'botones/ent-over.png\',0)"><img src="botones/ent-up.png" name="Enter" title="Enter" border="0" id="LetEnttt"/></button>';
		
		if(ccs == 0 && cca == 0){
			var det = ccd.replace(/ /g, "~");
			$("#archivos").load("NCArt.php?xd=0&cs="+ccs+"&ca="+cca+"&cc="+ccc+"&cp="+ccp+"&cd="+det);
		}else{
			$("#archivos").load("NCArt.php?xd=0&cs="+ccs+"&ca="+cca+"&cc="+ccc+"&cp="+ccp);
		}
		
	
		/*	LISTA DE ITEMS CON DIVISIONES POR COLUMNA PERO SIN COLOR  */
		$("#comcapasitems"+cs).append("<div id=\"itmesdecom"+cN+"\"><div class=\"itemslista\" onclick=\"env_ite_c("+ccs+","+cca+","+cN+");\"><table width=\"640\" cellpadding=\"0\" cellspacing=\"1\" align=\"center\" border=\"0\"><tr><td class=\"CCom\" width=\"21\"><div align=\"center\">"+cN+"</div></td><td class=\"CCom\" width=\"61\"><div align=\"center\">"+ccs+" - "+cca+"</div></td><td class=\"CCom\" width=\"65\"><div align=\"center\">"+ccc+"</div></td><td class=\"CCom\" width=\"156\"><div align=\"left\">"+ccd.substr(0,25)+"</div></td><td class=\"CCom\" width=\"92\"><div align=\"center\">"+ccp_v+"</div></td><td class=\"CCom\" width=\"92\"><div align=\"center\">"+ccp+"</div></td><td class=\"CCom\" width=\"92\"><div align=\"center\">"+cst+"</div></td><td class=\"CCom\" width=\"38\"><div align=\"center\">"+dep+"</div></td></tr></table></div></div>");
	
		if (cc == 6){
			
			cc = 0; 
			cs = cs + 1;
			
		}

}

function EnvCuerpo(){

$('#Bloquear').fadeIn(500);

	SoloNone("ComBotModDiv, ComBotEliDiv, NumVol");

	var tip = document.getElementById('EDat7_2').value;
	var tco = document.getElementById('EDat7_3').value;
	
	if(tip == 'R' && tco == 'RE'){
		
		SoloNone('LetTer');

		$("#PieDat14").css("border-color", "#F90");
			
		EnvAyuda("Ingrese Total.");
			
		document.getElementById("DondeE").value = "PDat14";
		document.getElementById("CantiE").value = "10";
		document.getElementById("QuePoE").value = "1";
			
		SoloBlock('LetEnt');
			
		document.getElementById('LetEnt').innerHTML = '<button class="StyBoton" onclick="ValidarXRE();" onmouseout="MM_swapImgRestore()" onmouseover="MM_swapImage(\'LetEntFac\',\'\',\'botones/ent-over.png\',0)"><img src="botones/ent-up.png" name="Enter" title="Enter" border="0" id="LetEntFac"/></button>';
	
		SoloNone('ComBotBusDiv, Cuerpo, CuerpoDat');	
		SoloBlock('ComBotPieDiv, ComprasDfon, Pie, PieDat');
		
		document.getElementById("PDat1").value = 0;
		document.getElementById("PDat2").value = 0;
		document.getElementById("PDat3").value = 0;
		document.getElementById("PDat4").value = 0;
		document.getElementById("PDat5").value = 0;
		document.getElementById("PDat6").value = 0;
		document.getElementById("PDat7").value = 0;
		document.getElementById("PDat8").value = 0;
		document.getElementById("PDat9").value = 0;
		document.getElementById("PDat10").value = 0;
		document.getElementById("PDat11").value = 0;
		document.getElementById("PDat12").value = 0;
		document.getElementById("PDat13").value = 0;
		
		$('#Bloquear').fadeOut(500);	
		
		controlarcadainputcom("PDat14");
				
	}else{
		
		SoloNone('LetTer');
		
		$("#PieDat1").css("border-color", "#F90");
		
		EnvAyuda("Ingrese Neto Grabado.");
			
		document.getElementById("DondeE").value = "PDat1";
		document.getElementById("CantiE").value = "10";
		document.getElementById("QuePoE").value = "1";
			
		SoloBlock('LetEnt');
			
		document.getElementById('LetEnt').innerHTML = '<button class="StyBoton" onclick="ValidarDP(1);" onmouseout="MM_swapImgRestore()" onmouseover="MM_swapImage(\'LetEntFac\',\'\',\'botones/ent-over.png\',0)"><img src="botones/ent-up.png" name="Enter" title="Enter" border="0" id="LetEntFac"/></button>';
	
		SoloNone('ComBotBusDiv, Cuerpo, CuerpoDat');	
		SoloBlock('ComBotPieDiv, ComprasDfon, Pie, PieDat');
		
		var tip = document.getElementById("EDat7_2").value;
		var tco = document.getElementById("EDat7_3").value;
		var suc = document.getElementById("EDat7_1").value;
		var nco = document.getElementById("EDat7_4").value;
		var cod = document.getElementById("EDat3").value;
		$("#archivos").load("TFComPie.php?tip="+tip+"&tco="+tco+"&suc="+suc+"&nco="+nco+"&cod="+cod);
		
		controlarcadainputcom("PDat1");
		
	}
	
}



function ValidarXRE(){

	var t = document.getElementById('PDat14').value;
	if (/^([0-9+\.])*$/.test(t)){
		if(t.length != 0){
		
			SoloNone('LetEnt');
			
			$("#PieDat14").css("border-color", "transparent");
	
			EnvAyuda("Continuar para finalizar factura de compras.");
	
			document.getElementById("DondeE").value = "LetTex";
			document.getElementById("CantiE").value = "0";
			document.getElementById("QuePoE").value = "1";
	
			document.getElementById('LetTer').innerHTML = '<button class="StyBoton" onclick="ConFCom();" onmouseout="MM_swapImgRestore()" onmouseover="MM_swapImage(\'LetCont\',\'\',\'botones/cont-over.png\',0)"><img src="botones/cont-up.png" name="Continuar" title="Continuar" border="0" id="LetCont"/></button>';

			SoloBlock('LetTer');
			
		}
	}

}

function ValidarDP(c){
		
	var t = document.getElementById('PDat'+c).value;
	if (/^([0-9+\.])*$/.test(t)){
			if(t.length != 0){
				
				if(c == 12){
					if(t >= 99){
						
						return false;
					}
				}
				var ant = c;
				c = c + 1;
				
				if(c==1){
					
					$("#PieDat1").css("border-color", "#F90");
					
					EnvAyuda("Ingrese Neto grabado.");
				}
				if(c==2){

					$("#PieDat1").css("border-color", "transparent");
					$("#PieDat2").css("border-color", "#F90");
					
					EnvAyuda("Ingrese Neto exento.");
				}
				if(c==3){

					$("#PieDat2").css("border-color", "transparent");
					$("#PieDat3").css("border-color", "#F90");

					EnvAyuda("Ingrese Retencion de ganancias.");
				}
				if(c==4){

					$("#PieDat3").css("border-color", "transparent");
					$("#PieDat4").css("border-color", "#F90");

					EnvAyuda("Ingrese IVA resposable(21%).");
				}
				if(c==5){
					
					$("#PieDat4").css("border-color", "transparent");
					$("#PieDat5").css("border-color", "#F90");

					EnvAyuda("Ingrese IVA otros.");
				}
				if(c==6){
					
					$("#PieDat5").css("border-color", "transparent");
					$("#PieDat6").css("border-color", "#F90");

					EnvAyuda("Ingrese Retencion de ingresos brutos.");
				}
				if(c==7){
					
					$("#PieDat6").css("border-color", "transparent");
					$("#PieDat7").css("border-color", "#F90");

					EnvAyuda("Ingrese Percepciones de IVA.");
				}
				if(c==8){
					
					$("#PieDat7").css("border-color", "transparent");
					$("#PieDat8").css("border-color", "#F90");

					EnvAyuda("Ingrese Retenciones de IVA.");
				}
				if(c==9){
					
					$("#PieDat8").css("border-color", "transparent");
					$("#PieDat9").css("border-color", "#F90");

					EnvAyuda("Ingrese Impuesto interno.");
				}
				if(c==10){
					
					$("#PieDat9").css("border-color", "transparent");
					$("#PieDat10").css("border-color", "#F90");

					EnvAyuda("Ingrese Conceptos no grabados 1.");
				}
				if(c==11){
					
					$("#PieDat10").css("border-color", "transparent");
					$("#PieDat11").css("border-color", "#F90");

					EnvAyuda("Ingrese Conceptos no grabados 2.");
				}
				if(c==12){
					
					$("#PieDat11").css("border-color", "transparent");
					$("#PieDat12").css("border-color", "#F90");

					EnvAyuda("Ingrese Descuento.");
				}
				if(c==13){
					
					$("#PieDat12").css("border-color", "transparent");
					$("#PieDat13").css("border-color", "#F90");

					EnvAyuda("Ingrese Percepciones de ingresos brutos.");
				}
				if(c==14){
					
					$("#PieDat13").css("border-color", "transparent");
					$("#PieDat14").css("border-color", "#F90");

					EnvAyuda("Ingrese total");
				}


				if(c<15){
					if(c == 13){		
						ReCalcularDP(1);
					}else{
						ReCalcularDP(0);
					}

					document.getElementById("DondeE").value = "PDat"+c;
					document.getElementById("CantiE").value = "10";
					document.getElementById("QuePoE").value = "1";

					SoloBlock('LetEnt, NumVol');

					document.getElementById('LetEnt').innerHTML = '<button class="StyBoton" onclick="ValidarDP('+c+');" onmouseout="MM_swapImgRestore()" onmouseover="MM_swapImage(\'LetEntFac\',\'\',\'botones/ent-over.png\',0)"><img src="botones/ent-up.png" name="Enter" title="Enter" border="0" id="LetEntFac"/></button>';
					
					if(ant != 0){

						document.getElementById('NumVol').innerHTML = '<button class="StyBoton" onclick="Vol_ValidarDP('+ant+');" onmouseout="MM_swapImgRestore()" onmouseover="MM_swapImage(\'LetVolFac\',\'\',\'botones/vol-over.png\',0)"><img src="botones/vol-up.png" name="Volver" title="Volver" border="0" id="LetVolFac"/></button>';
					}else{
						SoloNone("NumVol");	
					}

					controlarcadainputcom("PDat"+c);
					
				}else{

					SoloBlock('LetTer');
					SoloNone('LetEnt');

					$("#PieDat14").css("border-color", "transparent");

					EnvAyuda("Continuar para finalizar factura de compras.");
					
					controlarcadainputcom("CDatContinuarPie");
					
					document.getElementById("DondeE").value = "LetTex";
					document.getElementById("CantiE").value = "0";
					document.getElementById("QuePoE").value = "1";

					document.getElementById('LetTer').innerHTML = '<button class="StyBoton" onclick="ConFCom();" onmouseout="MM_swapImgRestore()" onmouseover="MM_swapImage(\'LetCont\',\'\',\'botones/cont-over.png\',0)"><img src="botones/cont-up.png" name="Continuar" title="Continuar" border="0" id="LetCont"/></button>';

					document.getElementById('NumVol').innerHTML = '<button class="StyBoton" onclick="Vol_ValidarDP(14);" onmouseout="MM_swapImgRestore()" onmouseover="MM_swapImage(\'LetVolFac\',\'\',\'botones/vol-over.png\',0)"><img src="botones/vol-up.png" name="Volver" title="Volver" border="0" id="LetVolFac"/></button>';
					

				}
		}		
	}	
}

function Vol_ValidarDP(c){

	var t = document.getElementById('PDat'+c).value;
	if (/^([0-9+\.])*$/.test(t)){
			if(t.length != 0){
				
				if(c == 12){
					if(t >= 99){
						
						return false;
					}
				}

				var cc = c - 1;
				
				if(c==1){
					
					$("#PieDat2").css("border-color", "transparent");
					$("#PieDat1").css("border-color", "#F90");
					
					EnvAyuda("Ingrese Neto grabado.");
				}
				if(c==2){

					$("#PieDat3").css("border-color", "transparent");
					$("#PieDat2").css("border-color", "#F90");
					
					EnvAyuda("Ingrese Neto exento.");
				}
				if(c==3){

					$("#PieDat4").css("border-color", "transparent");
					$("#PieDat3").css("border-color", "#F90");

					EnvAyuda("Ingrese Retencion de ganancias.");
				}
				if(c==4){

					$("#PieDat5").css("border-color", "transparent");
					$("#PieDat4").css("border-color", "#F90");

					EnvAyuda("Ingrese IVA resposable(21%).");
				}
				if(c==5){
					
					$("#PieDat6").css("border-color", "transparent");
					$("#PieDat5").css("border-color", "#F90");

					EnvAyuda("Ingrese IVA otros.");
				}
				if(c==6){
					
					$("#PieDat7").css("border-color", "transparent");
					$("#PieDat6").css("border-color", "#F90");

					EnvAyuda("Ingrese Retencion de ingresos brutos.");
				}
				if(c==7){
					
					$("#PieDat8").css("border-color", "transparent");
					$("#PieDat7").css("border-color", "#F90");

					EnvAyuda("Ingrese Percepciones de IVA.");
				}
				if(c==8){
					
					$("#PieDat9").css("border-color", "transparent");
					$("#PieDat8").css("border-color", "#F90");

					EnvAyuda("Ingrese Retenciones de IVA.");
				}
				if(c==9){
					
					$("#PieDat10").css("border-color", "transparent");
					$("#PieDat9").css("border-color", "#F90");

					EnvAyuda("Ingrese Impuesto interno.");
				}
				if(c==10){
					
					$("#PieDat11").css("border-color", "transparent");
					$("#PieDat10").css("border-color", "#F90");

					EnvAyuda("Ingrese Conceptos no grabados 1.");
				}
				if(c==11){
					
					$("#PieDat12").css("border-color", "transparent");
					$("#PieDat11").css("border-color", "#F90");

					EnvAyuda("Ingrese Conceptos no grabados 2.");
				}
				if(c==12){
					
					$("#PieDat13").css("border-color", "transparent");
					$("#PieDat12").css("border-color", "#F90");

					EnvAyuda("Ingrese Descuento.");
				}
				if(c==13){
					
					$("#PieDat14").css("border-color", "transparent");
					$("#PieDat13").css("border-color", "#F90");

					EnvAyuda("Ingrese Percepciones de ingresos brutos.");
				}
				if(c==14){
					
					$("#PieDat15").css("border-color", "transparent");
					$("#PieDat14").css("border-color", "#F90");

					EnvAyuda("Ingrese total");
				}


				if(c<15){
					
					SoloNone("LetTer");
					if(c == 13){		
						ReCalcularDP(1);
					}else{
						ReCalcularDP(0);
					}

					document.getElementById("DondeE").value = "PDat"+c;
					document.getElementById("CantiE").value = "10";
					document.getElementById("QuePoE").value = "1";

					SoloBlock('LetEnt, NumVol');
					
					document.getElementById('LetEnt').innerHTML = '<button class="StyBoton" onclick="ValidarDP('+c+');" onmouseout="MM_swapImgRestore()" onmouseover="MM_swapImage(\'LetEntFac\',\'\',\'botones/ent-over.png\',0)"><img src="botones/ent-up.png" name="Enter" title="Enter" border="0" id="LetEntFac"/></button>';
					
					if(cc != 0){

						document.getElementById('NumVol').innerHTML = '<button class="StyBoton" onclick="Vol_ValidarDP('+cc+');" onmouseout="MM_swapImgRestore()" onmouseover="MM_swapImage(\'LetVolFac2\',\'\',\'botones/vol-over.png\',0)"><img src="botones/vol-up.png" name="Volver" title="Volver" border="0" id="LetVolFac2"/></button>';
					}else{
						SoloNone("NumVol");	
					}

					controlarcadainputcom("PDat"+c);
					
				}else{

					SoloNone('LetEnt');
					SoloBlock('LetTer');
					
					$("#PieDat14").css("border-color", "transparent");

					EnvAyuda("Continuar para finalizar factura de compras.");
					
					controlarcadainputcom("CDatContinuarPie");
					
					document.getElementById("DondeE").value = "LetTex";
					document.getElementById("CantiE").value = "0";
					document.getElementById("QuePoE").value = "1";

					document.getElementById('LetTer').innerHTML = '<button class="StyBoton" onclick="ConFCom();" onmouseout="MM_swapImgRestore()" onmouseover="MM_swapImage(\'LetCont\',\'\',\'botones/cont-over.png\',0)"><img src="botones/cont-up.png" name="Continuar" title="Continuar" border="0" id="LetCont"/></button>';

					document.getElementById('NumVol').innerHTML = '<button class="StyBoton" onclick="Vol_ValidarDP(14);" onmouseout="MM_swapImgRestore()" onmouseover="MM_swapImage(\'LetVolFac\',\'\',\'botones/vol-over.png\',0)"><img src="botones/vol-up.png" name="Volver" title="Volver" border="0" id="LetVolFac"/></button>';


				}
		}		
	}	
}


function toFixed_FixBug(number,n) {
	var k = Math.pow(10,n);
	return (Math.round(number*k)/k);
}

function ReCalcularDP(b){

	var PDat1 = parseFloat(document.getElementById("PDat1").value);
	var PDat2 = parseFloat(document.getElementById("PDat2").value);
	var PDat3 = parseFloat(document.getElementById("PDat3").value);
	var PDat4 = parseFloat(document.getElementById("PDat4").value);
	var PDat5 = parseFloat(document.getElementById("PDat5").value);
	var PDat6 = parseFloat(document.getElementById("PDat6").value);
	var PDat7 = parseFloat(document.getElementById("PDat7").value);
	var PDat8 = parseFloat(document.getElementById("PDat8").value);
	var PDat9 = parseFloat(document.getElementById("PDat9").value);
	var PDat10 = parseFloat(document.getElementById("PDat10").value);
	var PDat11 = parseFloat(document.getElementById("PDat11").value);
	var PDat12 = parseFloat(document.getElementById("PDat12").value);
	var PDat13 = parseFloat(document.getElementById("PDat13").value);
	var PDat14 = parseFloat(document.getElementById("PDat14").value);

	var des = 0.00;

	if(b == 1){

		if((PDat12 >= 0) && (PDat12 <= PDat14) ){

			if(PDat1 == 0){
				des = (parseFloat(PDat12) * parseFloat(100.00)) / parseFloat(PDat14);
				//document.getElementById("PDat12-2").value = "("+dec(parseFloat(des),2)+"%)";
				document.getElementById("PDat12-2").value = dec(parseFloat(des),2);

				/*
				var dindes = (PDat2 * PDat12) / 100;
				dindes = toFixed_FixBug(dindes,2);
				document.getElementById("PDat12-2").value = dindes;
				PDat2 = PDat2 - dindes;
				PDat2 = toFixed_FixBug(PDat2,2);
				document.getElementById("PDat2").value = PDat2;
				*/
			}else{
				des = (parseFloat(PDat12) * parseFloat(100.00)) / parseFloat(PDat14);
				//document.getElementById("PDat12-2").value = "("+dec(parseFloat(des),2)+"%)";
				document.getElementById("PDat12-2").value = dec(parseFloat(des),2);

				/*
				var dindes = (PDat1 * PDat12) / 100;
				dindes = toFixed_FixBug(dindes,2);
				document.getElementById("PDat12-2").value = dindes;
				PDat1 = PDat1 - dindes;
				PDat1 = toFixed_FixBug(PDat1,2);
				document.getElementById("PDat1").value = PDat1;
				*/
			}
		}else{
			jAlert('El descuento supera el total.', 'Debo Retail - Global Business Solution');
			document.getElementById("PDat12-2").value = 0;
			document.getElementById("PDat12").value = 0;
			PDat12 = 0.00;
			//document.getElementById("PDat12-2").value = "("+dec(0,2)+"%)";
			document.getElementById("PDat12-2").value = dec(0,2);
		}
	}else{
		PDat12 = 0;
		//document.getElementById("PDat12-2").value = "("+dec(0,2)+"%)";
		document.getElementById("PDat12-2").value = dec(0,2);
	}

var total = PDat1 + PDat2 + PDat3 + PDat4 + PDat5 + PDat6 + PDat7 + PDat8 + PDat9 + PDat10 + PDat11 + PDat13 - PDat12;
	total = toFixed_FixBug(total,2);
	document.getElementById("PDat14").value = total;

}

function ConFCom(){

	$('#Bloquear').fadeIn(500);
	$('#FormPie').submit();
}

function mov_ant_bus_rem(p){

	np = p - 1;	
	document.getElementById("CapFacComB"+np).style.display="block";
	document.getElementById("CapFacComB"+p).style.display="none";
	
}

function mov_sig_bus_rem(p){
	
	np = p + 1;	
	document.getElementById("CapFacComB"+np).style.display="block";
	document.getElementById("CapFacComB"+p).style.display="none";

}

function MSDep(){

	SoloNone("StockCriticoVta");
	SoloBlock("StockCriticoDep");
	
	document.getElementById('StockTitulo').innerHTML = '<img src="Compras/exiendep.png" />';
	
	document.getElementById('StockCriticoBot').innerHTML = '<button class="StyBoton" onclick="MSVta();" onmouseout="MM_swapImgRestore()" onmouseover="MM_swapImage(\'BotVentas\',\'	\',\'botones/vent-over.png\',0)"><img src="botones/vent-up.png" border="0" id="BotVentas"/></button>';

}

function MSVta(){
	
	SoloNone("StockCriticoDep");
	SoloBlock("StockCriticoVta");
	
	document.getElementById('StockTitulo').innerHTML = '<img src="Compras/exienven.png" />';
	
	document.getElementById('StockCriticoBot').innerHTML = '<button class="StyBoton" onclick="MSDep();" onmouseout="MM_swapImgRestore()" onmouseover="MM_swapImage(\'BotDeposito\',\'\',\'botones/dep-over.png\',0)"><img src="botones/dep-up.png" border="0" id="BotDeposito"/></button>';

}

function botoncerrar(){

	$('#Bloquear').fadeIn(500);
	
		//////////////////////////////////////////////////
		EscrCookies(); ///////////////////////////////////
		//////////////////////////////////////////////////
		
		$('#TecladoNum').attr({
		   'style': 'top:-4px',
		}); 
		
		$('#NumVol').attr({
		   'style': 'left:625px; display:block;'
		});

		document.getElementById("YaFac").value = 0;
	
		SoloNone("Compras");	
		Mos_Ocu('BotonesPri');
		Mos_Ocu('fondotranspletras');
		Mos_Ocu('TecladoLet');
		Mos_Ocu('fondotranspnumeros');
		Mos_Ocu('TecladoNum');
		Mos_Ocu('Marca');
		EnvAyuda('Ocultar');
		
		SoloNone("BotMins2, NumAre, NumTexDiv");
		SoloBlock("ProcesoSusp, ProcesoSusp3");
		
		$("#SobreFoca").fadeIn(400);
	
	$('#Bloquear').fadeOut(500);

}

function comprasauto(){

	var a = document.getElementById('pantallacompra').value;

	if( a == 0){
		
		$('#Compras').fadeOut(500);
	
		SoloNone("Teclado_Completo, BotMins2, Marca, CarAyuda, CarAyudaFon, NumAre, NumTexDiv");
		SoloBlock("CarAyuda2, CarAyudaFon2");

		$("#ComAut").load("ComAut.php");
		
		$('#ComAut').fadeIn(500);
	}else{
		if( a == 1){

			$('#Compras').fadeOut(500);
		
			SoloNone("Teclado_Completo, BotMins2, Marca, CarAyuda, CarAyudaFon, NumAre, NumTexDiv");
			SoloBlock("CarAyuda2, CarAyudaFon2");
			
			$('#ComAut').fadeIn(500);
		}else{
			if(a == 2){

				$('#Compras').fadeOut(500);
			
				SoloNone("Teclado_Completo, BotMins2, Marca, CarAyuda, CarAyudaFon, NumAre, NumTexDiv");
				SoloBlock("CarAyuda2, CarAyudaFon2");
				
				$('#ComAutAce').fadeIn(500);
				$('#ComAut').fadeIn(500);
			
			}else{
	
				$('#Compras').fadeOut(500);
			
				SoloNone("Teclado_Completo, BotMins2, Marca, CarAyuda, CarAyudaFon, NumAre, NumTexDiv");
				SoloBlock("CarAyuda2, CarAyudaFon2");
				
				$("#ComAut").load("ComAut.php");
				
				$('#ComAut').fadeIn(500);
				
			}
		}
	}
}
