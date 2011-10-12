<script>

// JavaScript Document
$(document).ready(function(){
	$('#<? echo $se; ?>formcheque').submit(function(){
        $.ajax({
			type: 'POST',
			url: $(this).attr('action'),
			data: $(this).serialize(),
			success: function(data){
				SoloNone('CarAyuda');
				SoloNone('CarAyudaFon');		
				$('#archivos').html(data);
			}
        })
        return false;
    });
})

function <? echo $se; ?>salir_che_car(){
	
	SoloNone("fondotranspletras, fondotranspnumeros, TecladoNum, LetTer, CarAyuda, CarAyudaFon, TecladoLet, LetSal, LetEnt, NumVol");

	$('#<? echo $se; ?>ChequesDetalles').fadeOut(500);
	$('#<? echo $se; ?>Cheques').fadeOut(500);	
	$('#ChequesCar').fadeOut(500);
	
	document.getElementById('<? echo $se; ?>Cheques').innerHTML = '';
	
	$("#ChequesCar").load("ChequesCar.php");
	$('#ChequesCar').fadeIn(500);
	
}

function <? echo $se; ?>buscabanco(){
	
	SoloBlock("<? echo $se; ?>fondodescban, <? echo $se; ?>fondodescbanimg, <? echo $se; ?>descpidetipoban");
	$('#<? echo $se; ?>descpidetipoban').load("CheAgrSel.php?se=<? echo $se; ?>");	
	
}

function <? echo $se; ?>buscaprovincia(){
	
	SoloBlock("<? echo $se; ?>fondodescpro, <? echo $se; ?>fondodescproimg, <? echo $se; ?>descpidetipopro");
	$('#<? echo $se; ?>descpidetipopro').load("CheAgrSelPro.php?se=<? echo $se; ?>");	
	
}

function <? echo $se; ?>siguiente_che(){
	
	var banco  = document.getElementById("<? echo $se; ?>banco").value;
	if(banco == 0 ){
		<? echo $se; ?>buscabanco();
	}else{
		$('#<? echo $se; ?>descpidetipoban').load("CheAgrSel.php?se=<? echo $se; ?>&ban="+banco+"");
	}

}

function <? echo $se; ?>siguiente_che2(){
	
	var numche  = document.getElementById("<? echo $se; ?>numcheque").value.length;
	if(numche < 5 ){
		
		document.getElementById("<? echo $se; ?>numcheque").value = "";
		jAlert('El numero del cheque debe ser mayor que 4 digitos.', 'Debo Retail - Global Business Solution');

	}else{
		
		$("#<? echo $se; ?>nomlib").css("border-color", "#0FF");
		$("#<? echo $se; ?>numche").css("border-color", "transparent");
		
		EnvAyuda("Ingrese el Nombre del Librador.");
		
		document.getElementById("DondeE").value = "<? echo $se; ?>nomlibra";
		document.getElementById("CantiE").value = "21";
		document.getElementById("QuePoE").value = "2";
		
		document.getElementById('LetEnt').innerHTML = '<button onclick="<? echo $se; ?>siguiente_che3();" class="StyBoton" onmouseout="MM_swapImgRestore()" onmouseover="MM_swapImage(\'<? echo $se; ?>LetEntChe\',\'\',\'botones/ent-over.png\',0)"><img src="botones/ent-up.png" name="Enter" title="Enter" border="0" id="<? echo $se; ?>LetEntChe"/></button>';
		
		document.getElementById("NumVol").innerHTML = '<button onclick="<? echo $se; ?>volver_che3();" class="StyBoton" onmouseout="MM_swapImgRestore()" onmouseover="MM_swapImage(\'<? echo $se; ?>LetVolChe\',\'\',\'botones/vol-over.png\',0)"><img src="botones/vol-up.png" name="Volver" title="Volver" border="0" id="<? echo $se; ?>LetVolChe"/></button>';
		
		$('#<? echo $se; ?>nomlibra').focus();
		
		controlarcadainputche('<? echo $se; ?>nomlibra');
		
	}
	
}

function <? echo $se; ?>volver_che2(){

	document.getElementById('<? echo $se; ?>banco').value = "";
	
	document.getElementById("DondeE").value = "<? echo $se; ?>banco";
	document.getElementById("CantiE").value = "3";
	document.getElementById("QuePoE").value = "6";
	
	$('#<? echo $se; ?>tipoban').attr('onclick', '<? echo $se; ?>buscabanco();');

	$("#<? echo $se; ?>ban").css("border-color", "#0FF");
	$("#<? echo $se; ?>numche").css("border-color", "transparent");
		
	EnvAyuda("Ingrese el n&uacute;mero del Banco o Enter para listar.");
	
	document.getElementById('LetEnt').innerHTML = '<button onclick="<? echo $se; ?>siguiente_che();" class="StyBoton" onmouseout="MM_swapImgRestore()" onmouseover="MM_swapImage(\'<? echo $se; ?>LetEntChe\',\'\',\'botones/ent-over.png\',0)"><img src="botones/ent-up.png" name="Enter" title="Enter" border="0" id="<? echo $se; ?>LetEntChe"/></button>';
	
	document.getElementById("NumVol").innerHTML = '';	
	
	$('#<? echo $se; ?>banco').focus();
	
	controlarcadainputche('<? echo $se; ?>banco');
	
}

function <? echo $se; ?>siguiente_che3(){
	
	var nomlibra  = document.getElementById("<? echo $se; ?>nomlibra").value.length;
	if(nomlibra < 2 ){
		
		document.getElementById("<? echo $se; ?>nomlibra").value = "";
		jAlert('Debe ingresar un nombre de librador.', 'Debo Retail - Global Business Solution');
		
	}else{

		$("#<? echo $se; ?>lug").css("border-color", "#0FF");
		$("#<? echo $se; ?>nomlib").css("border-color", "transparent");
		
		EnvAyuda("Ingrese el n&uacute;mero de Provincia o Enter para Listar.");
		
		$('#<? echo $se; ?>tipopro').attr('onclick', '<? echo $se; ?>buscaprovincia();');
		
		document.getElementById("DondeE").value = "<? echo $se; ?>lugar";
		document.getElementById("CantiE").value = "3";
		document.getElementById("QuePoE").value = "6";
		
		document.getElementById('LetEnt').innerHTML = '<button onclick="<? echo $se; ?>siguiente_che4();" class="StyBoton" onmouseout="MM_swapImgRestore()" onmouseover="MM_swapImage(\'<? echo $se; ?>LetEntChe\',\'\',\'botones/ent-over.png\',0)"><img src="botones/ent-up.png" name="Enter" title="Enter" border="0" id="<? echo $se; ?>LetEntChe"/></button>';
		
		document.getElementById("NumVol").innerHTML = '<button onclick="<? echo $se; ?>volver_che4();" class="StyBoton" onmouseout="MM_swapImgRestore()" onmouseover="MM_swapImage(\'<? echo $se; ?>LetVolChe\',\'\',\'botones/vol-over.png\',0)"><img src="botones/vol-up.png" name="Volver" title="Volver" border="0" id="<? echo $se; ?>LetVolChe"/></button>';
		
		$('#<? echo $se; ?>lugar').focus();
		
		controlarcadainputche('<? echo $se; ?>lugar');
		
	}
	
}

function <? echo $se; ?>volver_che3(){
	
	$("#<? echo $se; ?>numche").css("border-color", "#0FF");
	$("#<? echo $se; ?>nomlib").css("border-color", "transparent");
	
	EnvAyuda("Ingrese el Número del cheque");
	
	document.getElementById("DondeE").value = "<? echo $se; ?>numcheque";
	document.getElementById("CantiE").value = "8";
	document.getElementById("QuePoE").value = "6";
	
	document.getElementById('LetEnt').innerHTML = '<button onclick="<? echo $se; ?>siguiente_che2();" class="StyBoton" onmouseout="MM_swapImgRestore()" onmouseover="MM_swapImage(\'<? echo $se; ?>LetEntChe\',\'\',\'botones/ent-over.png\',0)"><img src="botones/ent-up.png" name="Enter" title="Enter" border="0" id="<? echo $se; ?>LetEntChe"/></button>';
	
	document.getElementById("NumVol").innerHTML = '<button onclick="<? echo $se; ?>volver_che2();" class="StyBoton" onmouseout="MM_swapImgRestore()" onmouseover="MM_swapImage(\'<? echo $se; ?>LetVolChe\',\'\',\'botones/vol-over.png\',0)"><img src="botones/vol-up.png" name="Volver" title="Volver" border="0" id="<? echo $se; ?>LetVolChe"/></button>';
	
	$('#<? echo $se; ?>numcheque').focus();
	
	controlarcadainputche('<? echo $se; ?>numcheque');
	
}

function <? echo $se; ?>siguiente_che4(){
	
	var pro  = document.getElementById("<? echo $se; ?>lugar").value;
	if(pro == 0){
		<? echo $se; ?>buscaprovincia();
	}else{
		$('#<? echo $se; ?>descpidetipopro').load("CheAgrSelPro.php?se=<? echo $se; ?>&pro="+pro);
	}
	
}

function <? echo $se; ?>volver_che4(){

	$("#<? echo $se; ?>nomlib").css("border-color", "#0FF");
	$("#<? echo $se; ?>lug").css("border-color", "transparent");
	
	EnvAyuda("Ingrese el Nombre del Librador");

	document.getElementById("DondeE").value = "<? echo $se; ?>nomlibra";
	document.getElementById("CantiE").value = "21";
	document.getElementById("QuePoE").value = "2";

	document.getElementById('LetEnt').innerHTML = '<button onclick="<? echo $se; ?>siguiente_che3();" class="StyBoton" onmouseout="MM_swapImgRestore()" onmouseover="MM_swapImage(\'<? echo $se; ?>LetEntChe\',\'\',\'botones/ent-over.png\',0)"><img src="botones/ent-up.png" name="Enter" title="Enter" border="0" id="<? echo $se; ?>LetEntChe"/></button>';

	document.getElementById("NumVol").innerHTML = '<button onclick="<? echo $se; ?>volver_che3();" class="StyBoton" onmouseout="MM_swapImgRestore()" onmouseover="MM_swapImage(\'<? echo $se; ?>LetVolChe\',\'\',\'botones/vol-over.png\',0)"><img src="botones/vol-up.png" name="Volver" title="Volver" border="0" id="<? echo $se; ?>LetVolChe"/></button>';
	
	$('#<? echo $se; ?>nomlibra').focus();
	
	controlarcadainputche('<? echo $se; ?>nomlibra');
	
}

function <? echo $se; ?>siguiente_che5(){
	
	var importe  = document.getElementById("<? echo $se; ?>importeChe").value.length;
	if(importe == 0 ){
		
		document.getElementById("<? echo $se; ?>importeChe").value = "";
		jAlert('Debe ingresar un valor mayor.', 'Debo Retail - Global Business Solution');
		
	}else{
		
		var imp  = document.getElementById("<? echo $se; ?>importeChe").value;

		$("#<? echo $se; ?>fecemi").css("border-color", "#0FF");
		$("#<? echo $se; ?>imp").css("border-color", "transparent");

		EnvAyuda("Ingrese la fecha de emisión correctamente (dd/mm/aaaa)");
		
		document.getElementById("<? echo $se; ?>importeChe").value = dec(imp.replace(",","."));
		
		document.getElementById("DondeE").value = "<? echo $se; ?>fecemision";
		document.getElementById("CantiE").value = "10";
		document.getElementById("QuePoE").value = "1";
		
		document.getElementById('LetEnt').innerHTML = '<button onclick="<? echo $se; ?>siguiente_che6();" class="StyBoton" onmouseout="MM_swapImgRestore()" onmouseover="MM_swapImage(\'<? echo $se; ?>LetEntChe\',\'\',\'botones/ent-over.png\',0)"><img src="botones/ent-up.png" name="Enter" title="Enter" border="0" id="<? echo $se; ?>LetEntChe"/></button>';
		
		document.getElementById("NumVol").innerHTML = '<button onclick="<? echo $se; ?>volver_che6();" class="StyBoton" onmouseout="MM_swapImgRestore()" onmouseover="MM_swapImage(\'<? echo $se; ?>LetVolChe\',\'\',\'botones/vol-over.png\',0)"><img src="botones/vol-up.png" name="Enter" title="Enter" border="0" id="<? echo $se; ?>LetVolChe"/></button>';
		
		$('#<? echo $se; ?>fecemision').focus();
		
		controlarcadainputche('<? echo $se; ?>fecemision');
		
	}
}

function <? echo $se; ?>volver_che5(){
	
	$('#<? echo $se; ?>tipopro').attr('onclick', '<? echo $se; ?>buscaprovincia();');
	
	$("#<? echo $se; ?>lug").css("border-color", "#0FF");
	$("#<? echo $se; ?>imp").css("border-color", "transparent");
	
	EnvAyuda("Ingrese el n&uacute;mero de Provincia o Enter para Listar.");
	
	document.getElementById('<? echo $se; ?>lugar').value = "";
	
	document.getElementById("DondeE").value = "<? echo $se; ?>lugar";
	document.getElementById("CantiE").value = "3";
	document.getElementById("QuePoE").value = "6";
	
	document.getElementById('LetEnt').innerHTML = '<button onclick="<? echo $se; ?>siguiente_che4();" class="StyBoton" onmouseout="MM_swapImgRestore()" onmouseover="MM_swapImage(\'<? echo $se; ?>LetEntChe\',\'\',\'botones/ent-over.png\',0)"><img src="botones/ent-up.png" name="Enter" title="Enter" border="0" id="<? echo $se; ?>LetEntChe"/></button>';
	
	document.getElementById("NumVol").innerHTML = '<button onclick="<? echo $se; ?>volver_che4();" class="StyBoton" onmouseout="MM_swapImgRestore()" onmouseover="MM_swapImage(\'<? echo $se; ?>LetVolChe\',\'\',\'botones/vol-over.png\',0)"><img src="botones/vol-up.png" name="Volver" title="Volver" border="0" id="<? echo $se; ?>LetVolChe"/></button>';
	
	$('#<? echo $se; ?>lugar').focus();
	
	controlarcadainputche('<? echo $se; ?>lugar');
	
}

function <? echo $se; ?>siguiente_che6(){
	
	var fecemision  = document.getElementById("<? echo $se; ?>fecemision").value.length;
	if(fecemision == 0){
		
		var fecha=new Date();
		var diames=fecha.getDate();
		var diasemana=fecha.getDay();
		var mes=fecha.getMonth() +1 ;
		var ano=fecha.getFullYear();
		
		if (mes < 10){mes = '0' + mes;}
		if (diames < 10){ diames = '0' + diames;}
		
		var fe = diames+"/"+mes+"/"+ano;
		document.getElementById("<? echo $se; ?>fecemision").value = fe;
		
		$("#<? echo $se; ?>fechapre").css("border-color", "#0FF");
		$("#<? echo $se; ?>fecemi").css("border-color", "transparent");

		EnvAyuda("Ingrese la fecha de presentación correctamente (dd/mm/aaaa)");	

		document.getElementById("DondeE").value = "<? echo $se; ?>fecpresenta";
		document.getElementById("CantiE").value = "10";
		document.getElementById("QuePoE").value = "1";

		document.getElementById('LetEnt').innerHTML = '<button onclick="<? echo $se; ?>siguiente_che7();" class="StyBoton" onmouseout="MM_swapImgRestore()" onmouseover="MM_swapImage(\'<? echo $se; ?>LetEntChe\',\'\',\'botones/ent-over.png\',0)"><img src="botones/ent-up.png" name="Enter" title="Enter" border="0" id="<? echo $se; ?>LetEntChe"/></button>';

		document.getElementById("NumVol").innerHTML = '<button onclick="<? echo $se; ?>volver_che7();" class="StyBoton" onmouseout="MM_swapImgRestore()" onmouseover="MM_swapImage(\'<? echo $se; ?>LetVolChe\',\'\',\'botones/vol-over.png\',0)"><img src="botones/vol-up.png" name="Volver" title="Volver" border="0" id="<? echo $se; ?>LetVolChe"/></button>';

		$('#<? echo $se; ?>fecpresenta').focus();
		
		controlarcadainputche('<? echo $se; ?>fecpresenta');
		
	}else{

		if(fecemision != 10){
			
			document.getElementById("<? echo $se; ?>fecemision").value = "";
			jAlert('Debe ingresar una fecha correcta.', 'Debo Retail - Global Business Solution');
			
		}else{
			
			var femis  = document.getElementById("<? echo $se; ?>fecemision").value;
			var arreglo_e = femis.split("/");
			var fecha_ya = new Date();
			var anio = fecha_ya.getFullYear();
			var edia  = arreglo_e[0].length;
			var emes  = arreglo_e[1].length;		
			var eanio  = arreglo_e[2].length;
			
			if(arreglo_e[0] > 31 || arreglo_e[1] > 12 || arreglo_e[2] > anio ){
				document.getElementById("<? echo $se; ?>fecemision").value = "";
				jAlert('Debe ingresar una fecha correcta.', 'Debo Retail - Global Business Solution');
			}else{
				if(arreglo_e[0] > 28 & arreglo_e[1] == 2){
					document.getElementById("<? echo $se; ?>fecemision").value = "";
					jAlert('Debe ingresar una fecha correcta.', 'Debo Retail - Global Business Solution');
				}else{
					if( edia == 2){
						if( emes == 2){
							if( eanio == 4){

								$("#<? echo $se; ?>fechapre").css("border-color", "#0FF");
								$("#<? echo $se; ?>fecemi").css("border-color", "transparent");

								EnvAyuda("Ingrese la fecha de presentación correctamente (dd/mm/aaaa)");	

								document.getElementById("DondeE").value = "<? echo $se; ?>fecpresenta";
								document.getElementById("CantiE").value = "10";
								document.getElementById("QuePoE").value = "1";

								document.getElementById('LetEnt').innerHTML = '<button onclick="<? echo $se; ?>siguiente_che7();" class="StyBoton" onmouseout="MM_swapImgRestore()" onmouseover="MM_swapImage(\'<? echo $se; ?>LetEntChe\',\'\',\'botones/ent-over.png\',0)"><img src="botones/ent-up.png" name="Enter" title="Enter" border="0" id="<? echo $se; ?>LetEntChe"/></button>';

								document.getElementById("NumVol").innerHTML = '<button onclick="<? echo $se; ?>volver_che7();" class="StyBoton" onmouseout="MM_swapImgRestore()" onmouseover="MM_swapImage(\'<? echo $se; ?>LetVolChe\',\'\',\'botones/vol-over.png\',0)"><img src="botones/vol-up.png" name="Volver" title="Volver" border="0" id="<? echo $se; ?>LetVolChe"/></button>';
								
								$('#<? echo $se; ?>fecpresenta').focus();
								
								controlarcadainputche('<? echo $se; ?>fecpresenta');
								
							}else{

							document.getElementById("<? echo $se; ?>fecemision").value = "";
					jAlert('Debe ingresar una fecha correcta.', 'Debo Retail - Global Business Solution');
							}
						}else{
						document.getElementById("<? echo $se; ?>fecemision").value = "";
					jAlert('Debe ingresar una fecha correcta.', 'Debo Retail - Global Business Solution');
						}
					}else{
					document.getElementById("<? echo $se; ?>fecemision").value = "";
					jAlert('Debe ingresar una fecha correcta.', 'Debo Retail - Global Business Solution');
					}
				}
			}
		}
	}
}

function <? echo $se; ?>volver_che6(){

	var controldeins = "<? echo $se; ?>";
	if(controldeins == "a"){

		$("#<? echo $se; ?>imp").css("border-color", "#0FF");
		$("#<? echo $se; ?>fecemi").css("border-color", "transparent");
	
		EnvAyuda("Ingrese un Importe");
	
		document.getElementById("DondeE").value = "<? echo $se; ?>importeChe";
		document.getElementById("CantiE").value = "10";
		document.getElementById("QuePoE").value = "1";
	
		document.getElementById('LetEnt').innerHTML = '<button onclick="<? echo $se; ?>siguiente_che5();" class="StyBoton" onmouseout="MM_swapImgRestore()" onmouseover="MM_swapImage(\'<? echo $se; ?>LetEntChe\',\'\',\'botones/ent-over.png\',0)"><img src="botones/ent-up.png" name="Enter" title="Enter" border="0" id="<? echo $se; ?>LetEntChe"/></button>';
	
		document.getElementById("NumVol").innerHTML = '<button onclick="<? echo $se; ?>volver_che5();" class="StyBoton" onmouseout="MM_swapImgRestore()" onmouseover="MM_swapImage(\'<? echo $se; ?>LetVolChe\',\'\',\'botones/vol-over.png\',0)"><img src="botones/vol-up.png" name="Volver" title="Volver" border="0" id="<? echo $se; ?>LetVolChe"/></button>';
		
		$('#<? echo $se; ?>importeChe').focus();
		
		controlarcadainputche('<? echo $se; ?>importeChe');
		
	}else{
		
		$('#<? echo $se; ?>tipopro').attr('onclick', '<? echo $se; ?>buscaprovincia();');
		
		$("#<? echo $se; ?>lug").css("border-color", "#0FF");
		$("#<? echo $se; ?>fecemi").css("border-color", "transparent");
		
		EnvAyuda("Ingrese el n&uacute;mero de Provincia o Enter para Listar.");
		
		document.getElementById('<? echo $se; ?>lugar').value = "";
		
		document.getElementById("DondeE").value = "<? echo $se; ?>lugar";
		document.getElementById("CantiE").value = "3";
		document.getElementById("QuePoE").value = "6";
		
		document.getElementById('LetEnt').innerHTML = '<button onclick="<? echo $se; ?>siguiente_che4();" class="StyBoton" onmouseout="MM_swapImgRestore()" onmouseover="MM_swapImage(\'<? echo $se; ?>LetEntChe\',\'\',\'botones/ent-over.png\',0)"><img src="botones/ent-up.png" name="Enter" title="Enter" border="0" id="<? echo $se; ?>LetEntChe"/></button>';
		
		document.getElementById("NumVol").innerHTML = '<button onclick="<? echo $se; ?>volver_che4();" class="StyBoton" onmouseout="MM_swapImgRestore()" onmouseover="MM_swapImage(\'<? echo $se; ?>LetVolChe\',\'\',\'botones/vol-over.png\',0)"><img src="botones/vol-up.png" name="Volver" title="Volver" border="0" id="<? echo $se; ?>LetVolChe"/></button>';
	
		$('#<? echo $se; ?>lugar').focus();
	
		controlarcadainputche('<? echo $se; ?>lugar');
		
	}
	
}

function <? echo $se; ?>siguiente_che7(){

	var tam_presenta  = document.getElementById("<? echo $se; ?>fecpresenta").value.length;
	if(tam_presenta == 0){
		
		var fecha=new Date();
		var diames=fecha.getDate();
		var diasemana=fecha.getDay();
		var mes=fecha.getMonth() +1 ;
		var ano=fecha.getFullYear();
		
		if (mes < 10){mes = '0' + mes;}
		if (diames < 10){diames = '0' + diames;}
		
		var fe = diames+"/"+mes+"/"+ano;
		
		document.getElementById("<? echo $se; ?>fecpresenta").value = fe;
		
		SoloBlock("LetTer");
		SoloNone("LetEnt");

		$("#<? echo $se; ?>fechapre").css("border-color", "transparent");
		
		EnvAyuda("Presione Terminar para grabar el cheque");
		
		document.getElementById("LetTer").innerHTML = '<button onclick="<? echo $se; ?>siguiente_che8();" class="StyBoton" onmouseout="MM_swapImgRestore()" onmouseover="MM_swapImage(\'<? echo $se; ?>LetTerChe\',\'\',\'botones/ter-over.png\',0)"><img src="botones/ter-up.png" name="Terminar" title="Terminar" border="0" id="<? echo $se; ?>LetTerChe"/></button>';
		
		document.getElementById("NumVol").innerHTML = '<button onclick="<? echo $se; ?>volver_che8();" class="StyBoton" onmouseout="MM_swapImgRestore()" onmouseover="MM_swapImage(\'<? echo $se; ?>LetVolChe\',\'\',\'botones/vol-over.png\',0)"><img src="botones/vol-up.png" name="Volver" title="Volver" border="0" id="<? echo $se; ?>LetVolChe"/></button>';
		
	}else{
	
		if(tam_presenta != 10){
			
			document.getElementById("<? echo $se; ?>fecpresenta").value = "";
			jAlert('Debe ingresar una fecha correcta.', 'Debo Retail - Global Business Solution');
			
		}else{
			
			var fecemision  = document.getElementById("<? echo $se; ?>fecemision").value;
			var fecpresenta  = document.getElementById("<? echo $se; ?>fecpresenta").value;
			var fpres = document.getElementById("<? echo $se; ?>fecpresenta").value;
			var arreglo_p = fpres.split("/");
			var fecha_ya = new Date();
			var anio = fecha_ya.getFullYear();
			var pdia  = arreglo_p[0].length;
			var pmes  = arreglo_p[1].length;		
			var panio  = arreglo_p[2].length;
			if(arreglo_p[0] > 31 || arreglo_p[1] > 12 || arreglo_p[2] > anio ){
				document.getElementById("<? echo $se; ?>fecpresenta").value = "";
				jAlert('Debe ingresar una fecha correcta.', 'Debo Retail - Global Business Solution');
			}else{
				if(arreglo_p[0] > 28 & arreglo_p[1] == 2){
					document.getElementById("<? echo $se; ?>fecpresenta").value = "";
					jAlert('Debe ingresar una fecha correcta.', 'Debo Retail - Global Business Solution');
				}else{
					if( pdia == 2){
						if( pmes == 2){
							if( panio == 4){
								if(<? echo $se; ?>compara_fechas(fecpresenta, fecemision)){  

									SoloBlock("LetTer");
									SoloNone("LetEnt");
									
									$("#<? echo $se; ?>fechapre").css("border-color", "transparent");

									EnvAyuda("Presione Terminar para grabar el cheque");
									document.getElementById("LetTer").innerHTML = '<button onclick="<? echo $se; ?>siguiente_che8();" class="StyBoton" onmouseout="MM_swapImgRestore()" onmouseover="MM_swapImage(\'<? echo $se; ?>LetTerChe\',\'\',\'botones/ter-over.png\',0)"><img src="botones/ter-up.png" name="Terminar" title="Terminar" border="0" id="<? echo $se; ?>LetTerChe"/></button>';
									
									document.getElementById("NumVol").innerHTML = '<button onclick="<? echo $se; ?>volver_che8();" class="StyBoton" onmouseout="MM_swapImgRestore()" onmouseover="MM_swapImage(\'<? echo $se; ?>LetVolChe\',\'\',\'botones/vol-over.png\',0)"><img src="botones/vol-up.png" name="Volver" title="Volver" border="0" id="<? echo $se; ?>LetVolChe"/></button>';
									
								}else{  
								  document.getElementById("<? echo $se; ?>fecpresenta").value = "";
								  jAlert('Debe ingresar una fecha correcta.', 'Debo Retail - Global Business Solution');
								}
							}else{
								document.getElementById("<? echo $se; ?>fecpresenta").value = "";
								jAlert('Debe ingresar una fecha correcta.', 'Debo Retail - Global Business Solution');
							}
						}else{
							document.getElementById("<? echo $se; ?>fecpresenta").value = "";
							jAlert('Debe ingresar una fecha correcta.', 'Debo Retail - Global Business Solution');
						}
					}else{
					  document.getElementById("<? echo $se; ?>fecpresenta").value = "";
					  jAlert('Debe ingresar una fecha correcta.', 'Debo Retail - Global Business Solution');
					}
				}				
			}
		}
	}
}

function <? echo $se; ?>volver_che7(){

	$("#<? echo $se; ?>fecemi").css("border-color", "#0FF");
	$("#<? echo $se; ?>fechapre").css("border-color", "transparent");

	EnvAyuda("Ingrese la fecha de emisión correctamente (dd/mm/aaaa)");

	document.getElementById("DondeE").value = "<? echo $se; ?>fecemision";
	document.getElementById("CantiE").value = "10";
	document.getElementById("QuePoE").value = "1";

	document.getElementById("LetEnt").innerHTML = '<button onclick="<? echo $se; ?>siguiente_che6();" class="StyBoton" onmouseout="MM_swapImgRestore()" onmouseover="MM_swapImage(\'<? echo $se; ?>LetEntChe\',\'\',\'botones/ent-over.png\',0)"><img src="botones/ent-up.png" name="Enter" title="Enter" border="0" id="<? echo $se; ?>LetEntChe"/></button>';

	document.getElementById("NumVol").innerHTML = '<button onclick="<? echo $se; ?>volver_che6();" class="StyBoton" onmouseout="MM_swapImgRestore()" onmouseover="MM_swapImage(\'<? echo $se; ?>LetVolChe\',\'\',\'botones/vol-over.png\',0)"><img src="botones/vol-up.png" name="Volver" title="Volver" border="0" id="<? echo $se; ?>LetVolChe"/></button>';

	$('#<? echo $se; ?>fecemision').focus();
	
	controlarcadainputche('<? echo $se; ?>fecemision');
	
}

function <? echo $se; ?>siguiente_che8(){
	
	SoloNone("LetTer");
	$('#<? echo $se; ?>formcheque').submit();
	
}

function <? echo $se; ?>volver_che8(){
	
	SoloBlock("LetEnt");
	SoloNone("LetTer");
	
	$("#<? echo $se; ?>fechapre").css("border-color", "#0FF");

	EnvAyuda("Ingrese la fecha de presentaci&oacute;n correctamente (dd/mm/aaaa)");

	document.getElementById("DondeE").value = "<? echo $se; ?>fecpresenta";
	document.getElementById("CantiE").value = "10";
	document.getElementById("QuePoE").value = "1";

	document.getElementById("LetEnt").innerHTML = '<button onclick="<? echo $se; ?>siguiente_che7();" class="StyBoton" onmouseout="MM_swapImgRestore()" onmouseover="MM_swapImage(\'<? echo $se; ?>LetEntChe\',\'\',\'botones/ent-over.png\',0)"><img src="botones/ent-up.png" name="Enter" title="Enter" border="0" id="<? echo $se; ?>LetEntChe"/></button>';

	document.getElementById("NumVol").innerHTML = '<button onclick="<? echo $se; ?>volver_che7();" class="StyBoton" onmouseout="MM_swapImgRestore()" onmouseover="MM_swapImage(\'<? echo $se; ?>LetVolChe\',\'\',\'botones/vol-over.png\',0)"><img src="botones/vol-up.png" name="Volver" title="Volver" border="0" id="<? echo $se; ?>LetVolChe"/></button>';
	
	$('#<? echo $se; ?>fecpresenta').focus();
	
	controlarcadainputche('<? echo $se; ?>fecpresenta');
	
}

function <? echo $se; ?>compara_fechas(fecha, fecha2){  

    var xMonth=fecha.substring(3, 5);  
    var xDay=fecha.substring(0, 2);  
    var xYear=fecha.substring(6,10);  
    var yMonth=fecha2.substring(3, 5);  
    var yDay=fecha2.substring(0, 2);  
    var yYear=fecha2.substring(6,10);
	
	if(xYear > yYear){  
		return(true);
	}else{
		if(xYear == yYear){   
			if(xMonth > yMonth){  
				return(true);
			}else{
				if(xMonth == yMonth){  
					if (xDay >= yDay){
						return(true);  
					}else{ 
						return(false);  
					}
				}else{
					return(false);  
				}
			}
		}else{
			return(false);  
		}
	}  
	
} 

/****************************************************************************************************/
/****************************************************************************************************/
/****************************************************************************************************/

function Control<? echo $se; ?>banco(){
	
	if(document.getElementById("<? echo $se; ?>ban").style.borderColor == 'transparent'){
		return false;
	}	
	var k = window.event.keyCode;
	if(!((k == 13) || ((k >= 48) && (k <= 57)))){
		return false;
	}
	if(k == 13){
		<? echo $se; ?>siguiente_che();
	}
	
}

function Control<? echo $se; ?>numcheque(){
	
	if(document.getElementById("<? echo $se; ?>numche").style.borderColor == 'transparent'){
		return false;
	}	
	var k = window.event.keyCode;
	if(!((k == 13) || ((k >= 48) && (k <= 57)))){
		return false;
	}
	if(k == 13){
		<? echo $se; ?>siguiente_che2();
	}
	
}

function Control<? echo $se; ?>numchequeVol(){
	
	if(document.getElementById("<? echo $se; ?>numche").style.borderColor == 'transparent'){
		return false;
	}	
	var k = window.event.keyCode;
	if(k == 27){
		<? echo $se; ?>volver_che2();
	}

}

function Control<? echo $se; ?>nomlibra(){
	
	if(document.getElementById("<? echo $se; ?>nomlib").style.borderColor == 'transparent'){
		return false;
	}	
	var k = window.event.keyCode;
	if(!((k == 32) || (k == 13) || ((k >= 65) && (k <= 90)) || ((k >= 97) && (k <= 122)))){
		return false;
	}
	if(k == 13){
		<? echo $se; ?>siguiente_che3();
	}
	
}

function Control<? echo $se; ?>nomlibraVol(){
	
	if(document.getElementById("<? echo $se; ?>nomlib").style.borderColor == 'transparent'){
		return false;
	}	
	var k = window.event.keyCode;
	if(k == 27){
		<? echo $se; ?>volver_che3();
	}

}

function Control<? echo $se; ?>lugar(){
	
	if(document.getElementById("<? echo $se; ?>lug").style.borderColor == 'transparent'){
		return false;
	}	
	var k = window.event.keyCode;
	if(!((k == 13) || ((k >= 48) && (k <= 57)))){
		return false;
	}
	if(k == 13){
		<? echo $se; ?>siguiente_che4();
	}
	
}

function Control<? echo $se; ?>lugarVol(){
	
	if(document.getElementById("<? echo $se; ?>lug").style.borderColor == 'transparent'){
		return false;
	}
	var k = window.event.keyCode;
	if(k == 27){
		<? echo $se; ?>volver_che4();
	}

}

function Control<? echo $se; ?>importeChe(){
	
	if(document.getElementById("<? echo $se; ?>imp").style.borderColor == 'transparent'){
		return false;
	}
	var k = window.event.keyCode;
	if(!((k == 46) || (k == 13) || ((k >= 48) && (k <= 57)))){
		return false;
	}
	if(k == 13){
		<? echo $se; ?>siguiente_che5();
	}
	
}

function Control<? echo $se; ?>importeCheVol(){
	
	if(document.getElementById("<? echo $se; ?>imp").style.borderColor == 'transparent'){
		return false;
	}
	var k = window.event.keyCode;
	if(k == 27){
		<? echo $se; ?>volver_che5();
	}

}

function Control<? echo $se; ?>fecemision(){
	
	if(document.getElementById("<? echo $se; ?>fecemi").style.borderColor == 'transparent'){
		return false;
	}	
	var k = window.event.keyCode;
	if(!((k == 47) || (k == 13) || ((k >= 48) && (k <= 57)))){
		return false;
	}
	if(k == 13){
		<? echo $se; ?>siguiente_che6();
	}
	
}

function Control<? echo $se; ?>fecemisionVol(){
	
	if(document.getElementById("<? echo $se; ?>fecemi").style.borderColor == 'transparent'){
		return false;
	}	
	var k = window.event.keyCode;
	if(k == 27){
		<? echo $se; ?>volver_che6();
	}

}

function Control<? echo $se; ?>fecpresenta(){
	
	if(document.getElementById("<? echo $se; ?>fechapre").style.borderColor == 'transparent'){
		return false;
	}	
	var k = window.event.keyCode;
	if(!((k == 47) || (k == 13) || ((k >= 48) && (k <= 57)))){
		return false;
	}
	if(k == 13){
		<? echo $se; ?>siguiente_che7();
	}
	
}

var <? echo $se; ?>controldepaso = 0;
function Control<? echo $se; ?>fecpresentaVol(){
	
	var k = window.event.keyCode;
	if(k == 27){
		if(document.getElementById('<? echo $se; ?>fechapre').style.borderColor == "transparent"){
			<? echo $se; ?>volver_che8();
		}else{
			<? echo $se; ?>volver_che7();
		}		
	}
	if(k == 113){
		if(<? echo $se; ?>controldepaso == 0){
			if($('#LetTer').css('display') == 'block'){
				<? echo $se; ?>controldepaso = 1;
				<? echo $se; ?>siguiente_che8();
			}
		}
	}
}

function controlarcadainputche(cu){

var ii = new Array();

ii[0] = "<? echo $se; ?>banco";
ii[1] = "<? echo $se; ?>numcheque";
ii[2] = "<? echo $se; ?>nomlibra";
ii[3] = "<? echo $se; ?>lugar";
ii[4] = "<? echo $se; ?>importeChe";
ii[5] = "<? echo $se; ?>fecemision";
ii[6] = "<? echo $se; ?>fecpresenta";

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