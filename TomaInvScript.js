// Script para Toma de Inventario
$(document).ready(function(){
	$('#genera').submit(function(){
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

function seleccion(a){

	var comp = document.getElementById("comp").value;

	comp = 1; /////////////////////////////////////////////////////CAMBIAR CUANDO SE REALICE EN EL SISTEMA NUEVO!!!!!!!!!!!

	if(comp == 0){

		jAlert('Existen Comprobantes Pendientes de Impresion: debe controlar los mismos antes de Continuar.', 'Debo Retail - Global Business Solution');	
		
	}else{
	
		if(a == 1 ){
			$('#Seleccion').fadeOut(500);
			var numinv = document.getElementById('numinv').value;
			if(numinv != ''){
				
				EnvAyuda("Presione Enter para crear un nuevo inventario");		
				
				jAlert('Extraiga el Colector de Datos de la cuna para evitar la p&eacute;rdida de información. Colocarlo nuevamente cuando este seguro que no se realizaran m&aacute;s tomas de inventario.', 'Debo Retail - Global Business Solution');
				document.getElementById('colector').value = 1;
				
			}else{
				
				jAlert('No hay número de inventario disponible', 'Debo Retail - Global Business Solution');
			
			}
		}else{
			
			$('#Seleccion').fadeOut(500);
			document.getElementById('colector').value = 0;
			EnvAyuda("Presione Enter para crear un nuevo inventario");
		
		}
		
		var col = document.getElementById('colector').value;
		
		if(col == 1){
		
			document.getElementById('opeinventario').value = "";
		
		}
	}
}

function salir_tom(){
	jConfirm("¿Esta seguro que desea salir?.", "Debo Retail - Global Business Solution", function(r){
		if(r == true ){
			
			//ELIMINA TODO LO CARGADO EN LA ITMOINVD,C y INV_PALM_REA
			var eli = document.getElementById('eliminar').value;
			
			if( eli == "si"){
				
				var inv = document.getElementById('numinv').value;
				$('#archivos').load("TomInvGra.php?eli="+eli+"&inv="+inv+"");

			}
			
			$('#BotonesPri').fadeIn(500);
			$('#SobreFoca').fadeIn(500);
			Mos_Ocu('TomaInv');

			SoloBlock('SobreFoca, Marca');
			SoloNone('CarAyudaFon, CarAyuda, detallecar, fondotranspletras, TecladoLet, fondotranspnumeros, TecladoNum, fondocompleto');
			
			document.getElementById('TomaInv').innerHTML = '';
			document.getElementById('msj').innerHTML =" ";
		}
	});
}

////////////////   ENVIA FORMULARIO PARA GRABAR EN LAS TABLAS    /////////////////
function nuevalista(){
	
	SoloBlock("BotSelTodRubOff");
	SoloNone('BotSelTodRubOn, ordenalista');

	var cant = document.getElementById('cant').value;
	var t = 0;
	for (i=1; i<=cant; i++){
		var x = "fila" + i;
		if (document.getElementById(x).checked) {
			t = t+1;
		}
	}

	if(cant == 0){

		document.getElementById("rubroid").value = "";
		document.getElementById("rubro").value = "<RUBROS>";
		document.getElementById('GrabarInv').style.display = "none";
		var num = document.getElementById('numinv').value;
		document.getElementById('numinv').value = num;

		SoloBlock('LetEnt, NumVol');

	/////ME DEJA PRESIONADO EL BOTON DE DEPOSITO / VENTA y DESHABILITA LOS RUBROS
		var tip = document.getElementById('tiposel').value;
		if(tip == 0){
			seltipoinv(0);
		}else{
			seltipoinv(1);
		}
		
		document.getElementById('tiposel').disabled = false;
		
		document.getElementById('LetEnt').innerHTML = '<button onclick="siguiente_tominv3();" class="StyBoton" onmouseout="MM_swapImgRestore()" onmouseover="MM_swapImage(\'LetEntTomInv\',\'\',\'botones/ent-over.png\',0)"><img src="botones/ent-up.png" name="Enter" title="Enter" border="0" id="LetEntTomInv"/></button>';
		
		document.getElementById('NumVol').innerHTML = '<button onclick="volver_tominv2();" class="StyBoton" onmouseout="MM_swapImgRestore()" onmouseover="MM_swapImage(\'LetVolTomInv2\',\'\',\'botones/vol-over.png\',0)"><img src="botones/vol-up.png" name="Volver" title="Volver" border="0" id="LetVolTomInv2"/></button>';

		SoloNone("fondopidelista, descpidelista, fondolista, CarAyuda, CarAyudaFon");

	}
	if(t >= 1){
		

		$('#Bloquear').fadeIn(500);
		$('#formgravar').submit();

		$("#rub").css("border-color", "#F90");

		EnvAyuda("Ingrese un Rubro o Presione Enter para listar");
		
		document.getElementById('sacaletter').value = 1;
		document.getElementById("rubroid").value = "";
		document.getElementById("rubro").value = "<RUBROS>";
		document.getElementById('GrabarInv').style.display = "none";

		var num = document.getElementById('numinv').value;
		document.getElementById('numinv').value = num;
		
		SoloBlock('LetEnt, LetTer');
		SoloNone("Cancelar, CarAyuda, CarAyudaFon");

		document.getElementById('LetTer').innerHTML = '<button onclick="genera_pdf();" class="StyBoton" onmouseout="MM_swapImgRestore()" onmouseover="MM_swapImage(\'LetTerTomInv\',\'\',\'botones/imp-over.png\',0)"><img src="botones/imp-up.png" name="Grabar" title="Grabar" border="0" id="LetTerTomInv"/></button>';
		
		

/////ME DEJA PRESIONADO EL BOTON DE DEPOSITO / VENTA y DESHABILITA LOS RUBROS
		var tip = document.getElementById('tiposel').value;
		if(tip == 0){
			seltipoinv(0);
		}else{
			seltipoinv(1);
		}
		document.getElementById('tiposel').disabled = false;

		document.getElementById('LetEnt').innerHTML = '<button onclick="siguiente_tominv3();" class="StyBoton" onmouseout="MM_swapImgRestore()" onmouseover="MM_swapImage(\'LetEntTomInv\',\'\',\'botones/ent-over.png\',0)"><img src="botones/ent-up.png" name="Enter" title="Enter" border="0" id="LetEntTomInv"/></button>';

		SoloNone("fondopidelista, descpidelista, fondolista");

		

	}else{
		
		jAlert('No se ha seleccionado ning&uacute;n art&iacute;culo.', 'Debo Retail - Global Business Solution');
		SoloBlock("ordenalista");
	}
}

function genera_pdf(){
	$('#Bloquear').fadeIn(500);
	$('#genera').submit();
}

function imprimirtxt(){


}


function trae_num_inv(){
	var col = document.getElementById('colector').value;
	var cfMSG = document.getElementById('cfMSG').value;

	EnvAyuda("Ingrese un detalle del Inventario");

	jAlert('Todas las Facturas de compra deberán ser cargadas antes de hacer una Toma de Inventario.', 'Debo Retail - Global Business Solution');

	SoloBlock("numinv1, detinv, fecinv, opeinv");
	
	$("#detinv").css("border-color", "#F90");

	document.getElementById("DondeE").value = "detsec";
	document.getElementById("CantiE").value = "24";
	document.getElementById("QuePoE").value = "0";

	document.getElementById('LetEnt').innerHTML = '<button onclick="siguiente_tominv();" class="StyBoton" onmouseout="MM_swapImgRestore()" onmouseover="MM_swapImage(\'LetEntTomInv\',\'\',\'botones/ent-over.png\',0)"><img src="botones/ent-up.png" name="Enter" title="Enter" border="0" id="LetEntTomInv"/></button>';
}



function siguiente_tominv(){
	var col = document.getElementById('colector').value;
	var det = document.getElementById('detsec').value.length;
	if(det == 0 && col == 1){
		var emp = document.getElementById('numemp').value;
		document.getElementById('detsec').value= "Inv.Colector de Datos - Empresa:"+emp;
		
		$("#detinv").css("border-color", "transparent");
		
		EnvAyuda("Seleccione un Tipo");
		
		SoloBlock('NumVol');
		
		document.getElementById("DondeE").value = "LetTex";
		document.getElementById("CantiE").value = "0";
		document.getElementById("QuePoE").value = "1";
		
		document.getElementById('LetEnt').innerHTML = '<button onclick="siguiente_tominv0();" class="StyBoton" onmouseout="MM_swapImgRestore()" onmouseover="MM_swapImage(\'LetEntTomInv3\',\'\',\'botones/ent-over.png\',0)"><img src="botones/ent-up.png" name="Enter" title="Enter" border="0" id="LetEntTomInv3"/></button>';
		
		document.getElementById('NumVol').innerHTML = '<button onclick="volver_tominv0();" class="StyBoton" onmouseout="MM_swapImgRestore()" onmouseover="MM_swapImage(\'LetVolTomInv1\',\'\',\'botones/vol-over.png\',0)"><img src="botones/vol-up.png" name="Volver" title="Volver" border="0" id="LetVolTomInv1"/></button>';

	}else{

		if(det == 0){

			jAlert('Ingrese un detalle del inventario.', 'Debo Retail - Global Business Solution');
			document.getElementById("DondeE").value = "detsec";
			document.getElementById("CantiE").value = "24";
			document.getElementById("QuePoE").value = "0";

			document.getElementById('LetEnt').innerHTML = '<button onclick="siguiente_tominv();" class="StyBoton" onmouseout="MM_swapImgRestore()" onmouseover="MM_swapImage(\'LetEntTomInv3\',\'\',\'botones/ent-over.png\',0)"><img src="botones/ent-up.png" name="Enter" title="Enter" border="0" id="LetEntTomInv3"/></button>';

		}else{

			$("#detinv").css("border-color", "transparent");

			EnvAyuda("Seleccione un Tipo");

			SoloBlock('NumVol');

			document.getElementById("DondeE").value = "LetTex";
			document.getElementById("CantiE").value = "0";
			document.getElementById("QuePoE").value = "1";

			document.getElementById('LetEnt').innerHTML = '<button onclick="siguiente_tominv0();" class="StyBoton" onmouseout="MM_swapImgRestore()" onmouseover="MM_swapImage(\'LetEntTomInv3\',\'\',\'botones/ent-over.png\',0)"><img src="botones/ent-up.png" name="Enter" title="Enter" border="0" id="LetEntTomInv3"/></button>';
			
			document.getElementById('NumVol').innerHTML = '<button onclick="volver_tominv0();" class="StyBoton" onmouseout="MM_swapImgRestore()" onmouseover="MM_swapImage(\'LetVolTomInv0\',\'\',\'botones/vol-over.png\',0)"><img src="botones/vol-up.png" name="Volver" title="Volver" border="0" id="LetVolTomInv0"/></button>';

		}
	}
}

function volver_tominv0(){
	
	var col = document.getElementById('colector').value;
	if(col == 1){
		
		//document.formTomInv.opeinventario.select();

		document.getElementById("DondeE").value = "opeinventario";
		document.getElementById("CantiE").value = "3";
		document.getElementById("QuePoE").value = "1";

		$("#sectores").css("border-color", "transparent");
		$("#opeinv	").css("border-color", "#F90");

		EnvAyuda("Ingrese un Operario o Enter para listar");
		
		document.getElementById('LetEnt').innerHTML = '<button onclick="inv_colector();" class="StyBoton" onmouseout="MM_swapImgRestore()" onmouseover="MM_swapImage(\'LetEntTomInv3\',\'\',\'botones/ent-over.png\',0)"><img src="botones/ent-up.png" name="Enter" title="Enter" border="0" id="LetEntTomInv3"/></button>';
		
		document.getElementById('NumVol').innerHTML = '<button onclick="volver_tominv01();" class="StyBoton" onmouseout="MM_swapImgRestore()" onmouseover="MM_swapImage(\'LetVolTomInv0\',\'\',\'botones/vol-over.png\',0)"><img src="botones/vol-up.png" name="Volver" title="Volver" border="0" id="LetVolTomInv0"/></button>';
		
	}else{
		
		//document.formTomInv.detsec.select();
	
		document.getElementById("DondeE").value = "detsec";
		document.getElementById("CantiE").value = "30";
		document.getElementById("QuePoE").value = "0";
		
		$("#detinv").css("border-color", "#F90");
		$("#sectores").css("border-color", "transparent");
	
		EnvAyuda("Ingrese un detalle del Inventario");
	
		SoloNone('NumVol');
	
		document.getElementById('LetEnt').innerHTML = '<button onclick="siguiente_tominv();" class="StyBoton" onmouseout="MM_swapImgRestore()" onmouseover="MM_swapImage(\'LetEntTomInv3\',\'\',\'botones/ent-over.png\',0)"><img src="botones/ent-up.png" name="Enter" title="Enter" border="0" id="LetEntTomInv3"/></button>';
	
	}
}

function volver_tominv01(){
	
	document.getElementById("DondeE").value = "detsec";
	document.getElementById("CantiE").value = "30";
	document.getElementById("QuePoE").value = "0";
	
	$("#detinv").css("border-color", "#F90");

	EnvAyuda("Ingrese un detalle del Inventario");

	SoloNone('NumVol');

	document.getElementById('LetEnt').innerHTML = '<button onclick="siguiente_tominv();" class="StyBoton" onmouseout="MM_swapImgRestore()" onmouseover="MM_swapImage(\'LetEntTomInv3\',\'\',\'botones/ent-over.png\',0)"><img src="botones/ent-up.png" name="Enter" title="Enter" border="0" id="LetEntTomInv3"/></button>';
	
}

function siguiente_tominv0(){

	var seltipo = document.getElementById('tiposel').value;
	if(seltipo == '' ){
		
		$('#BotVen1Inv').attr({
		  src: 'InventarioToma/ventas-over.png',
		});

		document.getElementById("tiposel").value = 1;

		document.getElementById('rubromalf').checked = false;

		var col = document.getElementById('colector').value;

		if(col == 1){
			
			document.getElementById("DondeE").value = "opeinventario";
			document.getElementById("CantiE").value = "3";
			document.getElementById("QuePoE").value = "1";
			
			$("#opeinv").css("border-color", "#F90");
			$("#detinv").css("border-color", "transparent");

			EnvAyuda("Ingrese un Operario o Enter para listar");
			
			document.getElementById('LetEnt').innerHTML = '<button onclick="inv_colector();" class="StyBoton" onmouseout="MM_swapImgRestore()" onmouseover="MM_swapImage(\'LetEntTomInv3\',\'\',\'botones/ent-over.png\',0)"><img src="botones/ent-up.png" name="Enter" title="Enter" border="0" id="LetEntTomInv3"/></button>';

		
		}else{

			document.getElementById("DondeE").value = "sectorid";
			document.getElementById("CantiE").value = "3";
			document.getElementById("QuePoE").value = "1";
			
			$("#sectores").css("border-color", "#F90");
			$("#detinv").css("border-color", "transparent");
			$("#opeonv").css("border-color", "transparent");
			
			EnvAyuda("Ingrese un Sector o Presione Enter para listar");
		
			document.getElementById('LetEnt').innerHTML = '<button onclick="siguiente_tominv1();" class="StyBoton" onmouseout="MM_swapImgRestore()" onmouseover="MM_swapImage(\'LetEntTomInv3\',\'\',\'botones/ent-over.png\',0)"><img src="botones/ent-up.png" name="Enter" title="Enter" border="0" id="LetEntTomInv3"/></button>';
			
			document.getElementById('NumVol').innerHTML = '<button onclick="volver_tominv0();" class="StyBoton" onmouseout="MM_swapImgRestore()" onmouseover="MM_swapImage(\'LetVolTomInv0\',\'\',\'botones/vol-over.png\',0)"><img src="botones/vol-up.png" name="Volver" title="Volver" border="0" id="LetVolTomInv0"/></button>';
		
		}
		
	}else{
		
		var col = document.getElementById('colector').value;
		if(col == 1){

			document.getElementById("DondeE").value = "opeinventario";
			document.getElementById("CantiE").value = "3";
			document.getElementById("QuePoE").value = "1";
			
			$("#sectores").css("border-color", "#F90");
			$("#detinv").css("border-color", "transparent");
			$("#opeonv").css("border-color", "transparent");

			EnvAyuda("Ingrese un Sector o Presione Enter para listar");

			document.getElementById('LetEnt').innerHTML = '<button onclick="inv_colector();" class="StyBoton" onmouseout="MM_swapImgRestore()" onmouseover="MM_swapImage(\'LetEntTomInv3\',\'\',\'botones/ent-over.png\',0)"><img src="botones/ent-up.png" name="Enter" title="Enter" border="0" id="LetEntTomInv3"/></button>';
			
		}else{

			$("#sectores").css("border-color", "#F90");
			$("#detinv").css("border-color", "transparent");
			$("#opeonv").css("border-color", "transparent");

			EnvAyuda("Ingrese un Sector o Presione Enter para listar");
		
			document.getElementById('LetEnt').innerHTML = '<button onclick="siguiente_tominv1();" class="StyBoton" onmouseout="MM_swapImgRestore()" onmouseover="MM_swapImage(\'LetEntTomInv3\',\'\',\'botones/ent-over.png\',0)"><img src="botones/ent-up.png" name="Enter" title="Enter" border="0" id="LetEntTomInv3"/></button>';
		
		}
	}
}


function inv_colector(){
	
	var opei = document.getElementById('opeinventario').value;		
	if(opei == '' ){
		
		$('#Bloquear1').fadeIn(500);
		buscaope();
		
	}else{
		
		$('#descpideope').load("TomInvOpe.php?ope="+opei+"");

		document.getElementById("DondeE").value = "sectorid";
		document.getElementById("CantiE").value = "3";
		document.getElementById("QuePoE").value = "1";
		
		$("#sectores").css("border-color", "#F90");
		$("#detinv").css("border-color", "transparent");
		$("#opeonv").css("border-color", "transparent");

		EnvAyuda("Ingrese un Sector o Presione Enter para listar");
	
		document.getElementById('LetEnt').innerHTML = '<button onclick="siguiente_tominv1();" class="StyBoton" onmouseout="MM_swapImgRestore()" onmouseover="MM_swapImage(\'LetEntTomInv3\',\'\',\'botones/ent-over.png\',0)"><img src="botones/ent-up.png" name="Enter" title="Enter" border="0" id="LetEntTomInv3"/></button>';
		
		document.getElementById('NumVol').innerHTML = '<button onclick="volver_tominv0();" class="StyBoton" onmouseout="MM_swapImgRestore()" onmouseover="MM_swapImage(\'LetVolTomInv0\',\'\',\'botones/vol-over.png\',0)"><img src="botones/vol-up.png" name="Volver" title="Volver" border="0" id="LetVolTomInv0"/></button>';

	}
}



function siguiente_tominv1(){
	var sec = document.getElementById('sectorid').value;
	if(sec == '' ){
		
		$('#Bloquear1').fadeIn(500);
		buscasec();
		
	}else{
		
		$('#descpidesec').load("TomInvSec.php?sec="+sec+"");

		document.getElementById("DondeE").value = "rubromid";
		document.getElementById("CantiE").value = "3";
		document.getElementById("QuePoE").value = "1";

		EnvAyuda("Ingrese un Rubro Mayor o Presione Enter para listar");

		document.getElementById('LetEnt').innerHTML = '<button onclick="siguiente_tominv2();" class="StyBoton" onmouseout="MM_swapImgRestore()" onmouseover="MM_swapImage(\'LetEntTomInv5\',\'\',\'botones/ent-over.png\',0)"><img src="botones/ent-up.png" name="Enter" title="Enter" border="0" id="LetEntTomInv5"/></button>';

		document.getElementById('NumVol').innerHTML = '<button onclick="volver_tominv1();" class="StyBoton" onmouseout="MM_swapImgRestore()" onmouseover="MM_swapImage(\'LetVolTomInv1\',\'\',\'botones/vol-over.png\',0)"><img src="botones/vol-up.png" name="Volver" title="Volver" border="0" id="LetVolTomInv1"/></button>';

	}
}

function volver_tominv1(){
	
	document.getElementById("DondeE").value = "sectorid";
	document.getElementById("CantiE").value = "3";
	document.getElementById("QuePoE").value = "1";
	
	$("#sectores").css("border-color", "#F90");
	$("#rubmay").css("border-color", "transparent");

	EnvAyuda("Ingrese un Sector o Presione Enter para listar");

	document.getElementById('LetEnt').innerHTML = '<button onclick="siguiente_tominv1();" class="StyBoton" onmouseout="MM_swapImgRestore()" onmouseover="MM_swapImage(\'LetEntTomInv3\',\'\',\'botones/ent-over.png\',0)"><img src="botones/ent-up.png" name="Enter" title="Enter" border="0" id="LetEntTomInv3"/></button>';
	
	document.getElementById('NumVol').innerHTML = '<button onclick="volver_tominv0();" class="StyBoton" onmouseout="MM_swapImgRestore()" onmouseover="MM_swapImage(\'LetVolTomInv1\',\'\',\'botones/vol-over.png\',0)"><img src="botones/vol-up.png" name="Volver" title="Volver" border="0" id="LetVolTomInv1"/></button>';
	
}


function siguiente_tominv2(){
	
	var rubromid = document.getElementById('rubromid').value;
	if(rubromid == '' ){
		
		$('#Bloquear1').fadeIn(500);
		buscarubm(1);
		
	}else{
		
		$('#descpiderubm').load("TomInvRubM.php?rubm="+rubromid+"");
		
		document.getElementById("DondeE").value = "rubroid";
		document.getElementById("CantiE").value = "3";
		document.getElementById("QuePoE").value = "1";

		EnvAyuda("Ingrese un Rubro o Presione Enter para listar");
		
		document.getElementById('LetEnt').innerHTML = '<button onclick="siguiente_tominv3();" class="StyBoton" onmouseout="MM_swapImgRestore()" onmouseover="MM_swapImage(\'LetEntTomInv5\',\'\',\'botones/ent-over.png\',0)"><img src="botones/ent-up.png" name="Enter" title="Enter" border="0" id="LetEntTomInv5"/></button>';
		
		document.getElementById('NumVol').innerHTML = '<button onclick="volver_tominv2();" class="StyBoton" onmouseout="MM_swapImgRestore()" onmouseover="MM_swapImage(\'LetVolTomInv2\',\'\',\'botones/vol-over.png\',0)"><img src="botones/vol-up.png" name="Volver" title="Volver" border="0" id="LetVolTomInv2"/></button>';
		
	}
	
}


function volver_tominv2(){

	document.getElementById("DondeE").value = "rubromid";
	document.getElementById("CantiE").value = "3";
	document.getElementById("QuePoE").value = "1";

	$("#rubmay").css("border-color", "#F90");
	$("#rub").css("border-color", "transparent");

	EnvAyuda("Ingrese un Rubro Mayor o Presione Enter para listar");

	document.getElementById('LetEnt').innerHTML = '<button onclick="siguiente_tominv2();" class="StyBoton" onmouseout="MM_swapImgRestore()" onmouseover="MM_swapImage(\'LetEntTomInv5\',\'\',\'botones/ent-over.png\',0)"><img src="botones/ent-up.png" name="Enter" title="Enter" border="0" id="LetEntTomInv5"/></button>';

	document.getElementById('NumVol').innerHTML = '<button onclick="volver_tominv1();" class="StyBoton" onmouseout="MM_swapImgRestore()" onmouseover="MM_swapImage(\'LetVolTomInv1\',\'\',\'botones/vol-over.png\',0)"><img src="botones/vol-up.png" name="Volver" title="Volver" border="0" id="LetVolTomInv1"/></button>';
	
}


function siguiente_tominv3(){
	
	var rub = document.getElementById('rubroid').value;
	if (rub == '') {
		
		$('#Bloquear1').fadeIn(500);
		buscarub();
		
	}else{ 
		var sec = document.getElementById('sectorid').value;
		$('#descpiderub').load("TomInvRub.php?rub="+rub+"&sec="+sec+"");
		
//		$("#rub").css("border-color", "transparent");
		
		EnvAyuda("Presione Enter para Listar");

		document.getElementById('LetEnt').innerHTML = '<button onclick="siguiente_tominv4();" class="StyBoton" onmouseout="MM_swapImgRestore()" onmouseover="MM_swapImage(\'LetEntTomInv6\',\'\',\'botones/ent-over.png\',0)"><img src="botones/ent-up.png" name="Enter" title="Enter" border="0" id="LetEntTomInv6"/></button>';

		document.getElementById('NumVol').innerHTML = '<button onclick="volver_tominv3();" class="StyBoton" onmouseout="MM_swapImgRestore()" onmouseover="MM_swapImage(\'LetVolTomInv3\',\'\',\'botones/vol-over.png\',0)"><img src="botones/vol-up.png" name="Volver" title="Volver" border="0" id="LetVolTomInv3"/></button>';

	}
}

function volver_tominv3(){
	
	//document.formTomInv.rubroid.select();

	document.getElementById("DondeE").value = "rubroid";
	document.getElementById("CantiE").value = "3";
	document.getElementById("QuePoE").value = "1";
	
	$("#rub").css("border-color", "#F90");
	
	EnvAyuda("Ingrese un Rubro o Presione Enter para listar");
	
	document.getElementById('LetEnt').innerHTML = '<button onclick="siguiente_tominv3();" class="StyBoton" onmouseout="MM_swapImgRestore()" onmouseover="MM_swapImage(\'LetEntTomInv5\',\'\',\'botones/ent-over.png\',0)"><img src="botones/ent-up.png" name="Enter" title="Enter" border="0" id="LetEntTomInv5"/></button>';
	
	document.getElementById('NumVol').innerHTML = '<button onclick="volver_tominv2();" class="StyBoton" onmouseout="MM_swapImgRestore()" onmouseover="MM_swapImage(\'LetVolTomInv2\',\'\',\'botones/vol-over.png\',0)"><img src="botones/vol-up.png" name="Volver" title="Volver" border="0" id="LetVolTomInv2"/></button>';
	
}



////// TRAE LISTA DE INVENTARIOS //////
function siguiente_tominv4(){
	
	document.getElementById('msj').innerHTML ="AGUARDE, ESTE PROCESO PUEDE TOMAR VARIOS MINUTOS...";

	SoloNone("todartOn, LetTer");
	SoloBlock("todartOff");

	var col = document.getElementById('colector').value;
	var sec = document.getElementById('sectorid').value;
	var rum = document.getElementById('rubromid').value;
	var rub = document.getElementById('rubroid').value;
	var det = document.getElementById('detsec').value.length;
	var tip = document.getElementById('tiposel').value;
	var oi = document.getElementById('opeinventario').value;

		
	if(det == 0 ||tip == '' || rum == '?' || oi == '' || rub == '?'){
		
		if(det == 0){
			jAlert('Debes ingresar un Detalle.', 'Debo Retail - Global Business Solution');
			EnvAyuda("Verifique que todos los campos han sido completados");
			document.getElementById('LetEnt').innerHTML = '<button onclick="siguiente_tominv0();" class="StyBoton" onmouseout="MM_swapImgRestore()" onmouseover="MM_swapImage(\'LetEntTomInv7\',\'\',\'botones/ent-over.png\',0)"><img src="botones/ent-up.png" name="Enter" title="Enter" border="0" id="LetEntTomInv7"/></button>';
			exit;
		}
		
		if(tip == ''){
			jAlert('Debes seleccionar un Tipo.', 'Debo Retail - Global Business Solution');
			EnvAyuda("Seleccione un Tipo.");
			document.getElementById('LetEnt').innerHTML = '<button onclick="siguiente_tominv0();" class="StyBoton" onmouseout="MM_swapImgRestore()" onmouseover="MM_swapImage(\'LetEntTomInv7\',\'\',\'botones/ent-over.png\',0)"><img src="botones/ent-up.png" name="Enter" title="Enter" border="0" id="LetEntTomInv7"/></button>';
			exit;
		}
		
		if(oi == ''){
			jAlert('Debes seleccionar un operario.', 'Debo Retail - Global Business Solution');
			EnvAyuda("Presione Enter para listar Operarios");
			document.getElementById('LetEnt').innerHTML = '<button onclick="inv_colector()();" class="StyBoton" onmouseout="MM_swapImgRestore()" onmouseover="MM_swapImage(\'LetEntTomInv7\',\'\',\'botones/ent-over.png\',0)"><img src="botones/ent-up.png" name="Enter" title="Enter" border="0" id="LetEntTomInv7"/></button>';
			exit;
		}
		
		if(sec == ''){
			jAlert('Debes seleccionar un sector.', 'Debo Retail - Global Business Solution');
			EnvAyuda("Presione Enter para listar Sectores");	
			document.getElementById('LetEnt').innerHTML = '<button onclick="siguiente_tominv1();" class="StyBoton" onmouseout="MM_swapImgRestore()" onmouseover="MM_swapImage(\'LetEntTomInv7\',\'\',\'botones/ent-over.png\',0)"><img src="botones/ent-up.png" name="Enter" title="Enter" border="0" id="LetEntTomInv7"/></button>';
			exit;
		}
	
		if(rum == ''){
			jAlert('Debes seleccionar un Rubro Mayor.', 'Debo Retail - Global Business Solution');
			EnvAyuda("Presione Enter para listar Rubro Mayor");
			document.getElementById('LetEnt').innerHTML = '<button onclick="siguiente_tominv2();" class="StyBoton" onmouseout="MM_swapImgRestore()" onmouseover="MM_swapImage(\'LetEntTomInv7\',\'\',\'botones/ent-over.png\',0)"><img src="botones/ent-up.png" name="Enter" title="Enter" border="0" id="LetEntTomInv7"/></button>';

			exit;
		}
		
		if(rub == ''){
			jAlert('Debes seleccionar un Rubro.', 'Debo Retail - Global Business Solution');
			EnvAyuda("Presione Enter para listar Rubros");
			document.getElementById('LetEnt').innerHTML = '<button onclick="siguiente_tominv3();" class="StyBoton" onmouseout="MM_swapImgRestore()" onmouseover="MM_swapImage(\'LetEntTomInv7\',\'\',\'botones/ent-over.png\',0)"><img src="botones/ent-up.png" name="Enter" title="Enter" border="0" id="LetEntTomInv7"/></button>';

			exit;
		}
	
	
//		jAlert('Debes completar la b&uacute;squeda.', 'Debo Retail - Global Business Solution');
//		EnvAyuda("Verifique que todos los campos han sido completados");
	}else{
		$('#Bloquear').fadeIn(500);
		if(col == 1){
			document.getElementById('rubrotodos1').style.display = "none";
			document.getElementById('rubrostodos').style.display = "block";
		}
		
		//SoloBlock("ordenalista, rubrotodos1, rubrostodos, GrabarInv, GrabarInven, Cancelar");
		SoloNone('LetEnt, NumVol');
		
		EnvAyuda("Seleccione los items a guardar.");
		var a = 1;
		var tip = document.getElementById('tiposel').value;
		if(tip == 0){
			seltipoinv(0);
		}else{
			seltipoinv(1);
		}
		$('#formTomInv').submit();
	}	
}

////// ORDENA LISTA POR NUMERO O ALFABETICAMENTE //////
function ordenarlista(a){
	$('#Bloquear').fadeIn(500);
	if(a == 2){
		SoloBlock("rubromnumOn","rubromalfOff, todartOff");
		SoloNone("rubromalfOn, todartOn");
	}else{
		SoloNone("rubromnumOn, todartOn");
		SoloBlock("rubromalfOn","rubromnumOff, todartOff");
	}
	SoloNone('LetEnt, NumVol');
	SoloBlock("GrabarInv, fondopidelista, descpidelista, fondolista, todartOff");
	
	EnvAyuda("Seleccione los items a guardar.");

	var tip = document.getElementById('tiposel').value;
	if(tip == 0){
		seltipoinv(0);
	}else{
		seltipoinv(1);
	}

	document.getElementById('ordenlista').value = a;

	$('#formTomInv').submit();
}

function cancelalista(){
	
	var rub = document.getElementById("rubroid").value;

	if(rub == 0){

		SoloBlock("BotSelTodRubOn");
		SoloNone("BotSelTodRubOff");

	}else{

		SoloBlock("BotSelTodRubOff");
		SoloNone("BotSelTodRubOn");

	}

	var a = document.getElementById("sacaletter").value;

	if(a == 0){
		SoloNone("LetTer");
	}else{
		SoloBlock("LetTer");
	}

	SoloBlock('LetEnt, NumVol');
	SoloNone('ordenalista, descpidelista, fondopidelista, descpidelista, fondolista, Cancelar, GrabarInv');

	var num = document.getElementById('numinv').value;

	document.getElementById('numinv').value = num;


/////ME DEJA PRESIONADO EL BOTON DE DEPOSITO / VENTA y DESHABILITA LOS RUBROS

	var tip = document.getElementById('tiposel').value;

	if(tip == 0){
		seltipoinv(0);
	}else{
		seltipoinv(1);
	}
	
//VUELVE AL PUNTERO RUBRO

	document.getElementById("DondeE").value = "rubroid";
	document.getElementById("CantiE").value = "3";
	document.getElementById("QuePoE").value = "1";
	
	$("#rub").css("border-color", "#F90");
	
	EnvAyuda("Ingrese un Rubro o Presione Enter para listar");
	
	document.getElementById('LetEnt').innerHTML = '<button onclick="siguiente_tominv3();" class="StyBoton" onmouseout="MM_swapImgRestore()" onmouseover="MM_swapImage(\'LetEntTomInv5\',\'\',\'botones/ent-over.png\',0)"><img src="botones/ent-up.png" name="Enter" title="Enter" border="0" id="LetEntTomInv5"/></button>';
	
	document.getElementById('NumVol').innerHTML = '<button onclick="volver_tominv2();" class="StyBoton" onmouseout="MM_swapImgRestore()" onmouseover="MM_swapImage(\'LetVolTomInv2\',\'\',\'botones/vol-over.png\',0)"><img src="botones/vol-up.png" name="Volver" title="Volver" border="0" id="LetVolTomInv2"/></button>';
	
}

////// BOTON SELECCIONA DEPOSITO / VENTAS  //////
function seltipoinv(a){
	
	$("div").css("border-color", "transparent");
	
	var det = document.getElementById('detsec').value.length;
	if(det == 0 ){
		jAlert('Presione Enter para comenzar la carga de inventarios.', 'Debo Retail - Global Business Solution');
	}else{
		if(a == 0){

			$('#BotDep1Inv').attr({
			  src: 'InventarioToma/deposito-over.png',
			});

			$('#BotVen1Inv').attr({
			  src: 'InventarioToma/ventas-up.png',
			});

			document.getElementById("tiposel").value = 0;

			


		}else{

			$('#BotVen1Inv').attr({
			  src: 'InventarioToma/ventas-over.png',
			});
			
			$('#BotDep1Inv').attr({
			  src: 'InventarioToma/deposito-up.png',
			});

			document.getElementById("tiposel").value = 1;

			var col = document.getElementById('colector').value;

		}
	}
	
	return false;
}
////// TRAE LISTA DE OPERARIOS (COLECTOR) //////
function buscaope(){
	$('#Bloquear1').fadeIn(500);

	SoloBlock("fondopideope, descpideope, fondoope");
	SoloNone("fondopidesec, descpidesec, fondosec, fondopiderubm, descpiderubm, fondorubm, fondopiderub, descpiderub, fondorub");

	document.getElementById("LetTex").value = "";
	document.getElementById("DondeE").value = "LetTex";
	document.getElementById("CantiE").value = "25";
	document.getElementById("QuePoE").value = "0";

	EnvAyuda("Escriba el Operario que desea encontrar y presione Enter");

	$('#descpideope').load('TomInvOpe.php');
}

////// TRAE LISTA DE SECTORES //////
function buscasec(){
	
	var det = document.getElementById('detsec').value.length;
	if(det == 0 ){

		jAlert('Presione Enter para comenzar la carga de inventarios.', 'Debo Retail - Global Business Solution');

	}else{

		$('#Bloquear1').fadeIn(500);
		
		SoloBlock("fondopidesec, descpidesec, fondosec");
		SoloNone("fondopiderubm, descpiderubm, fondorubm, fondopiderub, descpiderub, fondorub, botbus, botbusr");
		
		$('#descpidesec').load('TomInvSec.php');

	}
}

////// TRAE LISTA DE RUBROS MAYORES //////
function buscarubm(){
	var det = document.getElementById('detsec').value.length;
	if(det == 0 ){
		jAlert('Presione Enter para comenzar la carga de inventarios.', 'Debo Retail - Global Business Solution');
	}else{
		$('#Bloquear1').fadeIn(500);
		var rid = document.getElementById('rubroid').value;
		if(rid != ""){
			EnvAyuda("Presione Enter para listar.");
		}
		
		SoloBlock("fondopiderubm, descpiderubm, fondorubm, botbus");
		SoloNone("fondopidesec, descpidesec, fondosec, fondopiderub, descpiderub, fondorub, botbusr");

		document.getElementById("LetTex").value = "";
		document.getElementById("DondeE").value = "LetTex";
		document.getElementById("CantiE").value = "25";
		document.getElementById("QuePoE").value = "0";

		EnvAyuda("Escriba el Rubro mayor que desea encontrar y presione Enter");

		document.getElementById('LetEnt').innerHTML = '<button onclick="buscarubmay();" class="StyBoton" onmouseout="MM_swapImgRestore()" onmouseover="MM_swapImage(\'LetEntTomInv8\',\'\',\'botones/ent-over.png\',0)"><img src="botones/ent-up.png" name="Enter" title="Enter" border="0" id="LetEntTomInv8"/></button>';

		$('#descpiderubm').load("TomInvRubM.php");
	}
}

function cambiabus(a){
	if(a == 1){
		SoloBlock("busrubmayComOn","busrubmayComOff");
		SoloNone("busrubmayConOn");
		document.getElementById("rubmbus").value = 2;
	}else{
		if(a == 2){
			SoloNone("busrubmayComOn");
			SoloBlock("busrubmayConOn","busrubmayComOff");
			document.getElementById("rubmbus").value = 1;
		}else{
			document.getElementById("rubmbus").value = 0;
		}	
	}
}

/*
function cambiaope(a){
	if(a == 2){
		document.getElementById('comope').checked = false;
		document.getElementById("opebus").value = 1;
	}else{
		if(a == 1){
			document.getElementById('conope').checked = false;
			document.getElementById("opebus").value = 2;		
		}else{
			document.getElementById("opebus").value = 0;
		}
	}
}

function buscaoperario(){
	$('#Bloquear1').fadeIn(500);
	document.getElementById('rubrotodos1').style.zIndex=3;
//	var let = document.getElementById("LetTex").value;			//** PARA BUSCAR OPERARIOS
//	var opebus = document.getElementById("opebus").value;		//** PARA BUSCAR OPERARIOS
	$('#descpideope').load("TomInvOpe.php?let="+let+"&tip="+opebus+"");
}
*/
function buscarubmay(){
	$('#Bloquear1').fadeIn(500);
	
	var rm = document.getElementById("rubmbus").value;
	if(rm == 0){
		SoloNone("busrubmayComOn");
		SoloBlock("busrubmayConOn","busrubmayComOff");
	}
	
	var let = document.getElementById("LetTex").value;
	var tipbus = document.getElementById("rubmbus").value;

	$('#descpiderubm').load("TomInvRubM.php?let="+let+"&tip="+tipbus+"");
}

////// TRAE LISTA DE RUBROS //////
function buscarub(){
	
	document.getElementById('rubrotodos1').style.zIndex=3;
	var secid = document.getElementById('sectorid').value;
	if( secid == '' || secid == '?' ){
		jAlert('Debes seleccionar un sector previamente.', 'Debo Retail - Global Business Solution');
		buscasec();
	}else{
		$('#Bloquear1').fadeIn(500);
		
		SoloBlock("fondopiderub, descpiderub, fondorub, botbusr");
		SoloNone("fondopidesec, descpidesec, fondosec, fondopiderubm, descpiderubm, fondorubm, botbus");

		document.getElementById("LetTex").value = "";
		document.getElementById("DondeE").value = "LetTex";
		document.getElementById("CantiE").value = "25";
		document.getElementById("QuePoE").value = "0";

		EnvAyuda("Escriba el Rubro que desea encontrar y presione Enter");

		document.getElementById('LetEnt').innerHTML = '<button onclick="buscarubros();" class="StyBoton" onmouseout="MM_swapImgRestore()" onmouseover="MM_swapImage(\'LetEntTomInv8\',\'\',\'botones/ent-over.png\',0)"><img src="botones/ent-up.png" name="Enter" title="Enter" border="0" id="LetEntTomInv8"/></button>';
		$('#descpiderub').load("TomInvRub.php?b="+secid+"");
	}
}

function cambiabusc(a){
	if(a == 1){
		SoloBlock("busrubComOn","busrubComOff");
		SoloNone("busrubConOn");
		document.getElementById("rubbus").value = 2;
	}else{
		if(a == 2){
			SoloNone("busrubComOn");
			SoloBlock("busrubConOn","busrubComOff");
			document.getElementById("rubbus").value = 1;
		}else{
			document.getElementById("rubbus").value = 0;
		}	
	}
	
	
/*	
	if(a == 2){
		document.getElementById('comie').checked = false;
		document.getElementById("rubbus").value = 1;
	}else{
		document.getElementById('conti').checked = false;
		document.getElementById("rubbus").value = 2;		
	}
	
*/	
}

function buscarubros(){
	$('#Bloquear1').fadeIn(500);

	var r = document.getElementById("rubbus").value;
	if(r == 0){
		SoloNone("busrubComOn");
		SoloBlock("busrubConOn","busrubComOff");
	}
	
	var secid = document.getElementById('sectorid').value;
	var let = document.getElementById("LetTex").value;
	var tipbus = document.getElementById("rubbus").value;
	document.getElementById('rubrotodos1').style.zIndex=3;

	$('#descpiderub').load("TomInvRub.php?let="+let+"&tip="+tipbus+"&b="+secid+"");
}

function ImpreVolTom(){

	SoloNone('ImpresionPdfDiv, Marca, LetTer');
	SoloBlock('fondotranspletras, TecladoLet, fondotranspnumeros, TecladoNum, LetEnt, NumVol');

	document.getElementById("DondeE").value = "";

	EnvAyuda("Presione Enter para Agregar un Nuevo Inventario");

	document.getElementById('LetSal').innerHTML = '<button class="StyBoton" onclick="salir_tom();" onmouseout="MM_swapImgRestore()" onmouseover="MM_swapImage(\'LetSalTomInv\',\'\',\'botones/sal-over.png\',0)"><img src="botones/sal-up.png" name="Salir" title="Salir" border="0" id="LetSalTomInv"/></button>';

	document.getElementById('LetEnt').innerHTML = '<button onclick="trae_num_inv();" class="StyBoton" onmouseout="MM_swapImgRestore()" onmouseover="MM_swapImage(\'LetEntTomInve\',\'\',\'botones/ent-over.png\',0)"><img src="botones/ent-up.png" name="Enter" title="Enter" border="0" id="LetEntTomInve"/></button>';

	$("#TomaInv").load("TomaInv.php");
}

/*
function nuevorub(){
	$('#Bloquear1').fadeIn(500);	
    
	SoloBlock("fondorub2, fondopiderub2, descpiderub2, botbusr");
	SoloNone("botbus");

	document.getElementById('rubrotodos1').style.zIndex=3;
	document.getElementById("LetTex").value = "";
	document.getElementById("DondeE").value = "LetTex";
	document.getElementById("CantiE").value = "25";
	document.getElementById("QuePoE").value = "0";

	EnvAyuda("Escriba el Rubro que desea encontrar y presione Enter");

	var sec = document.getElementById("sectorid").value;

	$('#descpiderub2').load("TomInvRub.php?s="+sec+"");
}
*/