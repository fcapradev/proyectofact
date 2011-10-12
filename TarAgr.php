<?
require("config/cnx.php");


try {////////////////////////////////////////////////////////////////////////////////////////////////// COMIENZO TRY //


mssql_query("begin transaction",$conexion) or die("Error SQL begin trans");


$se = $_REQUEST['se'];


$APARSIS = mssql_query("SELECT MINTSH, MINCSH FROM APARSIS");
rollback($APARSIS);
while ($APARSIS_REG = mssql_fetch_array($APARSIS)){

	$MINTSH = $APARSIS_REG['MINTSH'];
	$MINCSH = $APARSIS_REG['MINCSH'];

}
mssql_free_result($APARSIS);


$tarpau = "";
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Agregar Tarjetas</title>

<style>

#<? echo $se; ?>TarArgFondo{
	position:absolute;
	left:208px;
	z-index:1;
}

#<? echo $se; ?>TarAgrDetalle{
	position:absolute;
	top:50px;
	left:208px;
	z-index:2;
}

.fuente-tar{
	font-family: "TPro";
	font-size:12px;
	position:absolute;
	height:14px;
}

</style>

<script>

$(document).ready(function(){
	$('#<? echo $se; ?>formtar').submit(function(){
        $.ajax({
            type: 'POST',
            url: $(this).attr('action'),
            data: $(this).serialize(),
            success: function(data){
				$('#archivos').html(data);
				<? echo $se; ?>salir_tarjeta();
            }
        })
        return false;
    });
})

function <? echo $se; ?>salir_tarjeta(){
	
	var controldetar = "<? echo $se; ?>";
	if(controldetar == "a"){
			
		SoloNone("fondotranspletras, fondotranspnumeros, TecladoNum, LetTer, CarAyuda, CarAyudaFon, TecladoLet, LetSal, LetEnt, <? echo $se; ?>TarArgFondo, <? echo $se; ?>TarAgrDetalle, NumVol");
	
		$('#Tarjetas').fadeOut(500);
		document.getElementById('<? echo $se; ?>TarArgFondo').innerHTML = '';
		$("#Tarjetas").load("Tarjetas.php");		
		$('#Tarjetas').fadeIn(500);
		
	}
	/*
	else{
		sacarformapago();
	}
	*/

}

function <? echo $se; ?>buscatarjeta(){
	
	SoloBlock("<? echo $se; ?>fondodesctar, <? echo $se; ?>fondodesctarimg, <? echo $se; ?>descpidetipotar");
	$('#<? echo $se; ?>descpidetipotar').load("TarAgrSel.php?se=<? echo $se; ?>");
	
}

function <? echo $se; ?>siguiente_tar(){

	var tar  = document.getElementById("<? echo $se; ?>idtarjeta").value;
	if(tar == 0){
		
		<? echo $se; ?>buscatarjeta();
	
	}else{
		
		$('#<? echo $se; ?>descpidetipotar').load("TarAgrSel.php?se=<? echo $se; ?>&tar="+tar);
		$("#<? echo $se; ?>idtar").css("border-color", "transparent");
		$("#<? echo $se; ?>suc").css("border-color", "#F90");
		
	}

}

function <? echo $se; ?>volver_tar(){

	$("#<? echo $se; ?>suc").css("border-color", "transparent");
	$("#<? echo $se; ?>idtar").css("border-color", "#F90");

	$('#<? echo $se; ?>tipotar').attr('onclick', 'buscatarjeta();');
	
	document.getElementById("<? echo $se; ?>idtarjeta").value = "";
	
	EnvAyuda("Seleccione una Tarjeta de la Lista");
	
	document.getElementById("DondeE").value = "<? echo $se; ?>idtarjeta";
	document.getElementById("CantiE").value = "2";
	document.getElementById("QuePoE").value = "1";
	
	document.getElementById('LetEnt').innerHTML = '<button onclick="<? echo $se; ?>siguiente_tar();" class="StyBoton" onmouseout="MM_swapImgRestore()" onmouseover="MM_swapImage(\'<? echo $se; ?>LetEntTar\',\'\',\'botones/ent-over.png\',0)"><img src="botones/ent-up.png" name="<? echo $se; ?>Enter" title="Enter" border="0" id="<? echo $se; ?>LetEntTar"/></button>';
	
	document.getElementById('NumVol').innerHTML = "";

	$('#<? echo $se; ?>idtarjeta').focus();
	
	controlarcadainput('<? echo $se; ?>idtarjeta');
	
}

function <? echo $se; ?>siguiente_tar4(){

	var suc  = document.getElementById("<? echo $se; ?>sucursal").value.length;
	if(suc == 0){

		$("#<? echo $se; ?>suc").css("border-color", "transparent");
		$("#<? echo $se; ?>cup").css("border-color", "#F90");

		document.getElementById("<? echo $se; ?>sucursal").value = "<? echo $_SESSION['ParPV']; ?>";
		document.getElementById("<? echo $se; ?>terminal").value = "<? echo $_SESSION['ParPOS']; ?>";

		EnvAyuda("Ingrese el número de Cupón");

		document.getElementById("DondeE").value = "<? echo $se; ?>cupon";
		document.getElementById("CantiE").value = "8";
		document.getElementById("QuePoE").value = "6";

		document.getElementById('LetEnt').innerHTML = '<button onclick="<? echo $se; ?>siguiente_tar6();" class="StyBoton" onmouseout="MM_swapImgRestore()" onmouseover="MM_swapImage(\'<? echo $se; ?>LetEntTar\',\'\',\'botones/ent-over.png\',0)"><img src="botones/ent-up.png" name="Enter" title="Enter" border="0" id="<? echo $se; ?>LetEntTar"/></button>';
		
		document.getElementById('NumVol').innerHTML = '<button onclick="<? echo $se; ?>volver_tar5();" class="StyBoton" onmouseout="MM_swapImgRestore()" onmouseover="MM_swapImage(\'<? echo $se; ?>LetVolTar\',\'\',\'botones/vol-over.png\',0)"><img src="botones/vol-up.png" name="Volver" title="Volver" border="0" id="<? echo $se; ?>LetVolTar"/></button>';
		
		$('#<? echo $se; ?>cupon').focus();
		
		controlarcadainput('<? echo $se; ?>cupon');
		
	}else{
		
		if( suc > 4 ){
			
			document.getElementById("<? echo $se; ?>sucursal").value = "";
			jAlert('Debe ingresar una sucursal correcta.', 'Debo Retail - Global Business Solution');
			
		}else{

			$("#<? echo $se; ?>suc").css("border-color", "transparent");
			$("#<? echo $se; ?>ter").css("border-color", "#F90");
			
			EnvAyuda("Ingrese el número de Terminal");
			
			document.getElementById("DondeE").value = "<? echo $se; ?>terminal";
			document.getElementById("CantiE").value = "4";
			document.getElementById("QuePoE").value = "1";
			
			document.getElementById('LetEnt').innerHTML = '<button onclick="<? echo $se; ?>siguiente_tar5();" class="StyBoton" onmouseout="MM_swapImgRestore()" onmouseover="MM_swapImage(\'<? echo $se; ?>LetEntTar\',\'\',\'botones/ent-over.png\',0)"><img src="botones/ent-up.png" name="Enter" title="Enter" border="0" id="<? echo $se; ?>LetEntTar"/></button>';
			
			document.getElementById('NumVol').innerHTML = '<button onclick="<? echo $se; ?>volver_tar4();" class="StyBoton" onmouseout="MM_swapImgRestore()" onmouseover="MM_swapImage(\'<? echo $se; ?>LetVolTar\',\'\',\'botones/vol-over.png\',0)"><img src="botones/vol-up.png" name="Volver" title="Volver" border="0" id="<? echo $se; ?>LetVolTar"/></button>';
		
			$('#<? echo $se; ?>terminal').focus();
			
			controlarcadainput('<? echo $se; ?>terminal');
			
		}
	}
}

function <? echo $se; ?>volver_tar4(){

	$("#<? echo $se; ?>ter").css("border-color", "transparent");
	$("#<? echo $se; ?>suc").css("border-color", "#F90");

	EnvAyuda("Ingrese el n&uacute;mero de Sucursal o Enter para Continuar.");

	document.getElementById("DondeE").value = "<? echo $se; ?>sucursal";
	document.getElementById("CantiE").value = "4";
	document.getElementById("QuePoE").value = "1";

	document.getElementById('LetEnt').innerHTML = '<button onclick="<? echo $se; ?>siguiente_tar4();" class="StyBoton" onmouseout="MM_swapImgRestore()" onmouseover="MM_swapImage(\'<? echo $se; ?>LetEntTar\',\'\',\'botones/ent-over.png\',0)"><img src="botones/ent-up.png" name="Enter" title="Enter" border="0" id="<? echo $se; ?>LetEntTar"/></button>';

	document.getElementById('NumVol').innerHTML = '<button onclick="<? echo $se; ?>volver_tar();" class="StyBoton" onmouseout="MM_swapImgRestore()" onmouseover="MM_swapImage(\'<? echo $se; ?>LetVolTar\',\'\',\'botones/vol-over.png\',0)"><img src="botones/vol-up.png" name="Volver" title="Volver" border="0" id="<? echo $se; ?>LetVolTar"/></button>';
	
	$('#<? echo $se; ?>sucursal').focus();
	
	controlarcadainput('<? echo $se; ?>sucursal');

}

function <? echo $se; ?>siguiente_tar5(){
	
	var ter  = document.getElementById("<? echo $se; ?>terminal").value.length;
	if(ter < 1 || ter > 4){
		
		document.getElementById("<? echo $se; ?>terminal").value = "";
		jAlert('Debe ingresar una terminal.', 'Debo Retail - Global Business Solution');
		
	}else{
		
		$("#<? echo $se; ?>ter").css("border-color", "transparent");
		$("#<? echo $se; ?>cup").css("border-color", "#F90");
		
		EnvAyuda("Ingrese el número de Cupón");
		
		document.getElementById("DondeE").value = "<? echo $se; ?>cupon";
		document.getElementById("CantiE").value = "8";
		document.getElementById("QuePoE").value = "6";
		
		document.getElementById('LetEnt').innerHTML = '<button onclick="<? echo $se; ?>siguiente_tar6();" class="StyBoton" onmouseout="MM_swapImgRestore()" onmouseover="MM_swapImage(\'<? echo $se; ?>LetEntTar\',\'\',\'botones/ent-over.png\',0)"><img src="botones/ent-up.png" name="Enter" title="Enter" border="0" id="<? echo $se; ?>LetEntTar"/></button>';
		
		document.getElementById('NumVol').innerHTML = '<button onclick="<? echo $se; ?>volver_tar5();" class="StyBoton" onmouseout="MM_swapImgRestore()" onmouseover="MM_swapImage(\'<? echo $se; ?>LetVolTar\',\'\',\'botones/vol-over.png\',0)"><img src="botones/vol-up.png" name="Volver" title="Volver" border="0" id="<? echo $se; ?>LetVolTar"/></button>';
		
		$('#<? echo $se; ?>cupon').focus();
		
		controlarcadainput('<? echo $se; ?>cupon');
		
	}
	
}

function <? echo $se; ?>volver_tar5(){
	
	$("#<? echo $se; ?>cup").css("border-color", "transparent");
	$("#<? echo $se; ?>ter").css("border-color", "#F90");

	EnvAyuda("Ingrese el número de Terminal");

	document.getElementById("DondeE").value = "<? echo $se; ?>terminal";
	document.getElementById("CantiE").value = "4";
	document.getElementById("QuePoE").value = "1";

	document.getElementById('LetEnt').innerHTML = '<button onclick="<? echo $se; ?>siguiente_tar5();" class="StyBoton" onmouseout="MM_swapImgRestore()" onmouseover="MM_swapImage(\'<? echo $se; ?>LetEntTar\',\'\',\'botones/ent-over.png\',0)"><img src="botones/ent-up.png" name="Enter" title="Enter" border="0" id="<? echo $se; ?>LetEntTar"/></button>';

	document.getElementById('NumVol').innerHTML = '<button onclick="<? echo $se; ?>volver_tar4();" class="StyBoton" onmouseout="MM_swapImgRestore()" onmouseover="MM_swapImage(\'<? echo $se; ?>LetVolTar\',\'\',\'botones/vol-over.png\',0)"><img src="botones/vol-up.png" name="Volver" title="Volver" border="0" id="<? echo $se; ?>LetVolTar"/></button>';
	
	$('#<? echo $se; ?>terminal').focus();
	
	controlarcadainput('<? echo $se; ?>terminal');
	
}

function <? echo $se; ?>siguiente_tar6(){
	
	var cup  = document.getElementById("<? echo $se; ?>cupon").value.length;
	if(cup <= 8 && cup >=1 ){
		
		var controldetar = "<? echo $se; ?>";
		if(controldetar == "a"){

			$("#<? echo $se; ?>cup").css("border-color", "transparent");
			$("#<? echo $se; ?>imp").css("border-color", "#F90");
			
			EnvAyuda("Ingrese un importe");
			
			document.getElementById("DondeE").value = "<? echo $se; ?>importe";
			document.getElementById("CantiE").value = "8";
			document.getElementById("QuePoE").value = "1";
			
			document.getElementById('LetEnt').innerHTML = '<button onclick="<? echo $se; ?>siguiente_tar7();" class="StyBoton" onmouseout="MM_swapImgRestore()" onmouseover="MM_swapImage(\'<? echo $se; ?>LetEntTar\',\'\',\'botones/ent-over.png\',0)"><img src="botones/ent-up.png" name="Enter" title="Enter" border="0" id="<? echo $se; ?>LetEntTar"/></button>';
			
			document.getElementById('NumVol').innerHTML = '<button onclick="<? echo $se; ?>volver_tar6();" class="StyBoton" onmouseout="MM_swapImgRestore()" onmouseover="MM_swapImage(\'<? echo $se; ?>LetVolTar\',\'\',\'botones/vol-over.png\',0)"><img src="botones/vol-up.png" name="Volver" title="Volver" border="0" id="<? echo $se; ?>LetVolTar"/></button>';
			
			$('#<? echo $se; ?>importe').focus();
			
			controlarcadainput('<? echo $se; ?>importe');
			
		}else{
			
			$("#<? echo $se; ?>cup").css("border-color", "transparent");
			$("#<? echo $se; ?>cuo").css("border-color", "#F90");

			EnvAyuda("Ingrese la Cantidad de Cuotas");	
			
			document.getElementById("DondeE").value = "<? echo $se; ?>cuotas";
			document.getElementById("CantiE").value = "3";
			document.getElementById("QuePoE").value = "1";
			
			document.getElementById('LetEnt').innerHTML = '<button onclick="<? echo $se; ?>siguiente_tar8();" class="StyBoton" onmouseout="MM_swapImgRestore()" onmouseover="MM_swapImage(\'<? echo $se; ?>LetEntTar\',\'\',\'botones/ent-over.png\',0)"><img src="botones/ent-up.png" name="Enter" title="Enter" border="0" id="<? echo $se; ?>LetEntTar"/></button>';
			
			document.getElementById('NumVol').innerHTML = '<button onclick="<? echo $se; ?>volver_tar7();" class="StyBoton" onmouseout="MM_swapImgRestore()" onmouseover="MM_swapImage(\'<? echo $se; ?>LetVolTar\',\'\',\'botones/vol-over.png\',0)"><img src="botones/vol-up.png" name="Volvar" title="Volver" border="0" id="<? echo $se; ?>LetVolTar"/></button>';
			
			$('#<? echo $se; ?>cuotas').focus();
			
			controlarcadainput('<? echo $se; ?>cuotas');

		}

	}else{
		
		document.getElementById("<? echo $se; ?>cupon").value = "";
		jAlert('Debe ingresar un cupon correctamente.', 'Debo Retail - Global Business Solution');
		
	}
	
}

function <? echo $se; ?>volver_tar6(){

	$("#<? echo $se; ?>imp").css("border-color", "transparent");
	$("#<? echo $se; ?>cup").css("border-color", "#F90");

	EnvAyuda("Ingrese el número de Cupón");

	document.getElementById("DondeE").value = "<? echo $se; ?>cupon";
	document.getElementById("CantiE").value = "8";
	document.getElementById("QuePoE").value = "1";

	document.getElementById('LetEnt').innerHTML = '<button onclick="<? echo $se; ?>siguiente_tar6();" class="StyBoton" onmouseout="MM_swapImgRestore()" onmouseover="MM_swapImage(\'<? echo $se; ?>LetEntTar\',\'\',\'botones/ent-over.png\',0)"><img src="botones/ent-up.png" name="Enter" title="Enter" border="0" id="<? echo $se; ?>LetEntTar"/></button>';

	document.getElementById('NumVol').innerHTML = '<button onclick="<? echo $se; ?>volver_tar5();" class="StyBoton" onmouseout="MM_swapImgRestore()" onmouseover="MM_swapImage(\'<? echo $se; ?>LetVolTar\',\'\',\'botones/vol-over.png\',0)"><img src="botones/vol-up.png" name="Volver" title="Volver" border="0" id="<? echo $se; ?>LetVolTar"/></button>';
	
	$('#<? echo $se; ?>cupon').focus();
	
	controlarcadainput('<? echo $se; ?>cupon');
	
}

function <? echo $se; ?>siguiente_tar7(){

	var imp  = document.getElementById("<? echo $se; ?>importe").value;
	var controldetar = "<? echo $se; ?>";
	
	if(controldetar == "a"){

		var impmin = document.getElementById("PAR_MINTSH").value;

		if((imp == 0) || (imp <= impmin)){
			
			document.getElementById("<? echo $se; ?>importe").value = "";
			jAlert('Debe ingresar un importe correctamente.', 'Debo Retail - Global Business Solution');
			
		}else{
			
			var imp  = document.getElementById("<? echo $se; ?>importe").value;
			document.getElementById("<? echo $se; ?>importe").value = dec(imp.replace(",","."));
			
			$("#<? echo $se; ?>imp").css("border-color", "transparent");
			$("#<? echo $se; ?>cuo").css("border-color", "#F90");

			EnvAyuda("Ingrese la Cantidad de Cuotas");	
			
			document.getElementById("DondeE").value = "<? echo $se; ?>cuotas";
			document.getElementById("CantiE").value = "3";
			document.getElementById("QuePoE").value = "1";
			
			document.getElementById('LetEnt').innerHTML = '<button onclick="<? echo $se; ?>siguiente_tar8();" class="StyBoton" onmouseout="MM_swapImgRestore()" onmouseover="MM_swapImage(\'<? echo $se; ?>LetEntTar\',\'\',\'botones/ent-over.png\',0)"><img src="botones/ent-up.png" name="Enter" title="Enter" border="0" id="<? echo $se; ?>LetEntTar"/></button>';
			
			document.getElementById('NumVol').innerHTML = '<button onclick="<? echo $se; ?>volver_tar7();" class="StyBoton" onmouseout="MM_swapImgRestore()" onmouseover="MM_swapImage(\'<? echo $se; ?>LetVolTar\',\'\',\'botones/vol-over.png\',0)"><img src="botones/vol-up.png" name="Volvar" title="Volver" border="0" id="<? echo $se; ?>LetVolTar"/></button>';
			
			$('#<? echo $se; ?>cuotas').focus();
			
			controlarcadainput('<? echo $se; ?>cuotas');
			
		}	
	
	}else{
		
		var imp  = document.getElementById("<? echo $se; ?>importe").value;
		document.getElementById("<? echo $se; ?>importe").value = dec(imp.replace(",","."));

		$("#<? echo $se; ?>imp").css("border-color", "transparent");
		$("#<? echo $se; ?>cuo").css("border-color", "#F90");

		EnvAyuda("Ingrese la Cantidad de Cuotas");	

		document.getElementById("DondeE").value = "<? echo $se; ?>cuotas";
		document.getElementById("CantiE").value = "3";
		document.getElementById("QuePoE").value = "1";

		document.getElementById('LetEnt').innerHTML = '<button onclick="<? echo $se; ?>siguiente_tar8();" class="StyBoton" onmouseout="MM_swapImgRestore()" onmouseover="MM_swapImage(\'<? echo $se; ?>LetEntTar\',\'\',\'botones/ent-over.png\',0)"><img src="botones/ent-up.png" name="Enter" title="Enter" border="0" id="<? echo $se; ?>LetEntTar"/></button>';

		document.getElementById('NumVol').innerHTML = '<button onclick="<? echo $se; ?>volver_tar7();" class="StyBoton" onmouseout="MM_swapImgRestore()" onmouseover="MM_swapImage(\'<? echo $se; ?>LetVolTar\',\'\',\'botones/vol-over.png\',0)"><img src="botones/vol-up.png" name="Volvar" title="Volver" border="0" id="<? echo $se; ?>LetVolTar"/></button>';

		$('#<? echo $se; ?>cuotas').focus();
		
		controlarcadainput('<? echo $se; ?>cuotas');

	}
	
}

function <? echo $se; ?>volver_tar7(){
	
	var controldetar = "<? echo $se; ?>";
	
	if(controldetar == "a"){
			
		$("#<? echo $se; ?>cuo").css("border-color", "transparent");
		$("#<? echo $se; ?>imp").css("border-color", "#F90");
		
		EnvAyuda("Ingrese un importe");
	
		document.getElementById("DondeE").value = "<? echo $se; ?>importe";
		document.getElementById("CantiE").value = "8";
		document.getElementById("QuePoE").value = "1";
	
		document.getElementById('LetEnt').innerHTML = '<button onclick="<? echo $se; ?>siguiente_tar7();" class="StyBoton" onmouseout="MM_swapImgRestore()" onmouseover="MM_swapImage(\'<? echo $se; ?>LetEntTar\',\'\',\'botones/ent-over.png\',0)"><img src="botones/ent-up.png" name="Enter" title="Enter" border="0" id="<? echo $se; ?>LetEntTar"/></button>';
	
		document.getElementById('NumVol').innerHTML = '<button onclick="<? echo $se; ?>volver_tar6();" class="StyBoton" onmouseout="MM_swapImgRestore()" onmouseover="MM_swapImage(\'<? echo $se; ?>LetVolTar\',\'\',\'botones/vol-over.png\',0)"><img src="botones/vol-up.png" name="Volver" title="Volver" border="0" id="<? echo $se; ?>LetVolTar"/></button>';
		
		$('#<? echo $se; ?>importe').focus();

		controlarcadainput('<? echo $se; ?>importe');

	}else{
		
		$("#<? echo $se; ?>cuo").css("border-color", "transparent");
		$("#<? echo $se; ?>cup").css("border-color", "#F90");
		
		EnvAyuda("Ingrese el número de Cupón");
		
		document.getElementById("DondeE").value = "<? echo $se; ?>cupon";
		document.getElementById("CantiE").value = "8";
		document.getElementById("QuePoE").value = "6";
		
		document.getElementById('LetEnt').innerHTML = '<button onclick="<? echo $se; ?>siguiente_tar6();" class="StyBoton" onmouseout="MM_swapImgRestore()" onmouseover="MM_swapImage(\'<? echo $se; ?>LetEntTar\',\'\',\'botones/ent-over.png\',0)"><img src="botones/ent-up.png" name="Enter" title="Enter" border="0" id="<? echo $se; ?>LetEntTar"/></button>';
		
		document.getElementById('NumVol').innerHTML = '<button onclick="<? echo $se; ?>volver_tar5();" class="StyBoton" onmouseout="MM_swapImgRestore()" onmouseover="MM_swapImage(\'<? echo $se; ?>LetVolTar\',\'\',\'botones/vol-over.png\',0)"><img src="botones/vol-up.png" name="Volver" title="Volver" border="0" id="<? echo $se; ?>LetVolTar"/></button>';
		
		$('#<? echo $se; ?>cupon').focus();
		
		controlarcadainput('<? echo $se; ?>cupon');
				
	}
	
}

function <? echo $se; ?>siguiente_tar8(){
	
	var cuo  = document.getElementById("<? echo $se; ?>cuotas").value.length;
	if(cuo < 1){
		
		document.getElementById("<? echo $se; ?>cuotas").value = "";
		jAlert('Debe ingresar una cuota.', 'Debo Retail - Global Business Solution');
		
	}else{
		
		SoloNone("LetEnt");
		SoloBlock("LetTer");

		$("#<? echo $se; ?>cuo").css("border-color", "transparent");


		var controldetar = "<? echo $se; ?>";
		if(controldetar == "a"){
			
			EnvAyuda("Presione Terminar para grabar la Tarjeta");
			
		}else{
			
			EnvAyuda("Terminar para grabar la Tarjeta, y terminar el comprobante.");
					
		}

		document.getElementById('LetTer').innerHTML = '<button class="StyBoton" onclick="<? echo $se; ?>terminartar();" onmouseout="MM_swapImgRestore()" onmouseover="MM_swapImage(\'<? echo $se; ?>LetTerTar\',\'\',\'botones/ter-over.png\',0)"><img src="botones/ter-up.png" name="Terminar" title="Terminar" border="0" id="<? echo $se; ?>LetTerTar"/></button>';
	
		document.getElementById('NumVol').innerHTML = '<button class="StyBoton" onclick="<? echo $se; ?>volver_tar8();" onmouseout="MM_swapImgRestore()" onmouseover="MM_swapImage(\'<? echo $se; ?>LetVolTar\',\'\',\'botones/vol-over.png\',0)"><img src="botones/vol-up.png" name="Volver" title="Volver" border="0" id="<? echo $se; ?>LetVolTar"/></button>';
	
	}
	
}

function <? echo $se; ?>volver_tar8(){

	$("#<? echo $se; ?>cuo").css("border-color", "#F90");

	EnvAyuda("Ingrese la Cantidad de Cuotas");	

	document.getElementById("DondeE").value = "<? echo $se; ?>cuotas";
	document.getElementById("CantiE").value = "3";
	document.getElementById("QuePoE").value = "1";

	SoloBlock("LetEnt");
	SoloNone("LetTer");

	document.getElementById('LetEnt').innerHTML = '<button onclick="<? echo $se; ?>siguiente_tar8();" class="StyBoton" onmouseout="MM_swapImgRestore()" onmouseover="MM_swapImage(\'<? echo $se; ?>LetEntTar\',\'\',\'botones/ent-over.png\',0)"><img src="botones/ent-up.png" name="Enter" title="Enter" border="0" id="<? echo $se; ?>LetEntTar"/></button>';

	document.getElementById('NumVol').innerHTML = '<button onclick="<? echo $se; ?>volver_tar7();" class="StyBoton" onmouseout="MM_swapImgRestore()" onmouseover="MM_swapImage(\'<? echo $se; ?>LetVolTar\',\'\',\'botones/vol-over.png\',0)"><img src="botones/vol-up.png" name="Volvar" title="Volver" border="0" id="<? echo $se; ?>LetVolTar"/></button>';
	
	$('#<? echo $se; ?>cuotas').focus();
	
	controlarcadainput('<? echo $se; ?>cuotas');
	
}

function <? echo $se; ?>terminartar(){
	
	$('#<? echo $se; ?>formtar').submit();
	
}

/****************************************************************************************************/
/****************************************************************************************************/
/****************************************************************************************************/

function Control<? echo $se; ?>Idtarjeta(){

	if(document.getElementById("<? echo $se; ?>idtar").style.borderColor == 'transparent'){
		return false;
	}
	var k = window.event.keyCode;
	if(!((k == 46) || (k == 13) || ((k >= 48) && (k <= 57)))){
		return false;
	}
	if(k == 13){
		<? echo $se; ?>siguiente_tar();
	}
	
}

function Control<? echo $se; ?>sucursal(){

	if(document.getElementById("<? echo $se; ?>suc").style.borderColor == 'transparent'){
		return false;
	}
	var k = window.event.keyCode;
	if(!((k == 46) || (k == 13) || ((k >= 48) && (k <= 57)))){
		return false;
	}
	if(k == 13){
		<? echo $se; ?>siguiente_tar4();
	}

}

function Control<? echo $se; ?>sucursalVol(){
	
	if(document.getElementById("<? echo $se; ?>suc").style.borderColor == 'transparent'){
		return false;
	}	
	var k = window.event.keyCode;
	if(k == 27){
		<? echo $se; ?>volver_tar();
	}

}

function Control<? echo $se; ?>terminal(){
	
	if(document.getElementById("<? echo $se; ?>ter").style.borderColor == 'transparent'){
		return false;
	}	
	var k = window.event.keyCode;
	if(!((k == 46) || (k == 13) || ((k >= 48) && (k <= 57)))){
		return false;
	}
	if(k == 13){
		<? echo $se; ?>siguiente_tar5();
	}

}

function Control<? echo $se; ?>terminalVol(){
	
	if(document.getElementById("<? echo $se; ?>ter").style.borderColor == 'transparent'){
		return false;
	}		
	var k = window.event.keyCode;
	if(k == 27){
		<? echo $se; ?>volver_tar4();
	}

}

function Control<? echo $se; ?>cupon(){
	
	if(document.getElementById("<? echo $se; ?>cup").style.borderColor == 'transparent'){
		return false;
	}
	var k = window.event.keyCode;
	if(!((k == 46) || (k == 13) || ((k >= 48) && (k <= 57)))){
		return false;
	}
	if(k == 13){
		<? echo $se; ?>siguiente_tar6();
	}

}

function Control<? echo $se; ?>cuponVol(){
	
	if(document.getElementById("<? echo $se; ?>cup").style.borderColor == 'transparent'){
		return false;
	}	
	var k = window.event.keyCode;
	if(k == 27){
		<? echo $se; ?>volver_tar5();
	}

}

function Control<? echo $se; ?>importe(){

	if(document.getElementById("<? echo $se; ?>imp").style.borderColor == 'transparent'){
		return false;
	}
	var k = window.event.keyCode;
	if(!((k == 46) || (k == 13) || ((k >= 48) && (k <= 57)))){
		return false;
	}
	if(k == 13){
		<? echo $se; ?>siguiente_tar7();
	}

}

function Control<? echo $se; ?>importeVol(){
	
	if(document.getElementById("<? echo $se; ?>imp").style.borderColor == 'transparent'){
		return false;
	}	
	var k = window.event.keyCode;
	if(k == 27){
		<? echo $se; ?>volver_tar6();
	}

}

function Control<? echo $se; ?>cuotas(){
	
	if(document.getElementById("<? echo $se; ?>cuo").style.borderColor == 'transparent'){
		return false;
	}
	var k = window.event.keyCode;
	if(!((k == 46) || (k == 13) || ((k >= 48) && (k <= 57)))){
		return false;
	}
	if(k == 13){
		<? echo $se; ?>siguiente_tar8();
	}

}

var <? echo $se; ?>controldepaso = 0;
function Control<? echo $se; ?>cuotasVol(){
	
	var k = window.event.keyCode;
	if(k == 27){
		
		if(document.getElementById('<? echo $se; ?>cuo').style.borderColor == "transparent"){
			<? echo $se; ?>volver_tar8();
		}else{
			<? echo $se; ?>volver_tar7();
		}
		
	}
	if(k == 113){
		if(<? echo $se; ?>controldepaso == 0){
			if($('#LetTer').css('display') == 'block'){
				<? echo $se; ?>controldepaso = 1;
				<? echo $se; ?>terminartar();
			}
		}
	}
	
}

function controlarcadainput(cu){

var ii = new Array();

ii[0] = "<? echo $se; ?>idtarjeta";
ii[1] = "<? echo $se; ?>sucursal";
ii[2] = "<? echo $se; ?>terminal";
ii[3] = "<? echo $se; ?>cupon";
ii[4] = "<? echo $se; ?>importe";
ii[5] = "<? echo $se; ?>cuotas";

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


<div id="<? echo $se; ?>TarArgFondo"><img src="tarjetas/tarjeta.png" /></div>

<div id="<? echo $se; ?>TarAgrDetalle">

<form method="post" id="<? echo $se; ?>formtar" name="<? echo $se; ?>formtar" action="TarAgrN.php">

<input type="hidden" name="PAR_MINTSH" id="PAR_MINTSH" value="<? echo $MINTSH; ?>" />
<input type="hidden" name="PAR_MINCSH" id="PAR_MINCSH" value="<? echo $MINCSH; ?>" />
    
<?
$_SESSION['ParSQL'] = "
SELECT C.NplVen AS PLA, D.FAP AS FAP, A.MTN, A.DES, A.INI, A.FIN FROM ATURNOSH AS A 
INNER JOIN APARPOS AS B ON B.ID = '".$_SESSION['ParPOS']."'
INNER JOIN VENDEDORES AS C ON C.CodVen = B.OPE
INNER JOIN ATURNOSO AS D ON D.PLA = C.NplVen
WHERE A.MTN = D.MTN";
$registros = mssql_query($_SESSION['ParSQL']) or die("Error SQL");
rollback($registros);		

if(mssql_num_rows($registros)==0){ exit; }

while ($reg=mssql_fetch_array($registros)){
	$PLA = $reg['PLA'];
}

$NOM = $_SESSION['idsusun'];
$OPE = $_SESSION['idsusua'];

?>

<input type="hidden" id="<? echo $se; ?>PorFacTarjetas" name="<? echo $se; ?>PorFacTarjetas" value="<? echo $se; ?>" />

    <div class="fuente-tar" style="position:absolute; top:-14px; left:13px; background-color:#DD7927; width:50px; text-align:center; color:#FFF; font-weight:bold;">
        <? echo $OPE;?>
    </div>	
    <div class="fuente-tar" style="position:absolute; top:-14px; left:100px; width:200px; color:#FFF; font-weight:bold;">
        <? echo $NOM;?>
    </div>
    <div class="fuente-tar" style="position:absolute; top:7px; left:146px; background-color:#DD7927; width:95px; text-align:center; color:#FFF; font-weight:bold;">
        <? echo $PLA;?>
    </div>
    
    <div id="<? echo $se; ?>idtar" class="div-redondo" style="position:absolute; top:35px; left:141px; width:30px; height:15px;">
        <input class="fuente-tar" type="text" id="<? echo $se; ?>idtarjeta" name="<? echo $se; ?>idtarjeta" maxlength="3" style="outline-style:none; border-style:none; width:29px; height:13px; text-align:center; background-color:transparent;" onkeypress="return Control<? echo $se; ?>Idtarjeta();" />
    </div>

    <div style="position:absolute; top:37px; left:184px; width: 150px;">
    <input type="hidden" name="<? echo $se; ?>idtipotar" id="<? echo $se; ?>idtipotar">
    <input type="text" name="<? echo $se; ?>tipotar" readonly="readonly" id="<? echo $se; ?>tipotar" onclick="<? echo $se; ?>buscatarjeta();" style=" background-color:#DD7927; font-family: 'TPro'; font-size:12px; cursor:pointer; width:150px; height:13px; border:0; text-align:center;" value="&lt;&nbsp;BUSCAR UNA TARJETA&nbsp;&gt;">
    </div>

    <div id="<? echo $se; ?>fondodesctar" style=" top:-47px; left:-199px; position:absolute; width:683px; height:479px; z-index:1; display:none;"></div>
    <div id="<? echo $se; ?>fondodesctarimg" style="position:absolute; top:-41px; left:12px; display:none; z-index:2;">
        <img src="CargaGastos/fon-der.png" />
    </div>
    <div id="<? echo $se; ?>descpidetipotar" class="fon-gas" style="position:absolute; top:-41px; left:12px; display:none; z-index:2;"></div>

    <div style="position:absolute; top:60px; left:146px;" align="center">
        <input class="fuente-tar" type="text" id="<? echo $se; ?>tipo" readonly="readonly" name="<? echo $se; ?>tipo" style="width:190px; height:14px; border:0px;text-align:center" />
        
    </div>

    <div style="position:absolute; top:82px; left:156px;" align="center">
        <input class="fuente-tar" type="text" id="<? echo $se; ?>fecha" readonly="readonly" name="<? echo $se; ?>fecha" style="width:76px; height:14px; border:0px; text-align:center;" value="<? echo date("d-m-Y");?>" />
    </div>

    <div id="<? echo $se; ?>suc" class="div-redondo" style="position:absolute; top:102px; left:140px; width:103px; height:14px;" align="center">
        <input class="fuente-tar" type="text" id="<? echo $se; ?>sucursal" name="<? echo $se; ?>sucursal" style="outline-style:none; border-style:none; width:95px; height:15px; border:0px;text-align:center; background-color:transparent;" maxlength="4" onkeypress="return Control<? echo $se; ?>sucursal();" onkeydown="return Control<? echo $se; ?>sucursalVol();" readonly="readonly" />
    </div>

    <div id="<? echo $se; ?>ter" class="div-redondo" style="position:absolute; top:124px; left:140px; width:103px; height:14px;" align="center">
        <input class="fuente-tar" type="text" id="<? echo $se; ?>terminal" name="<? echo $se; ?>terminal" style="outline-style:none; border-style:none; width:95px; height:15px; border:0px;text-align:center; background-color:transparent;" maxlength="4" onkeypress="return Control<? echo $se; ?>terminal();" onkeydown="return Control<? echo $se; ?>terminalVol();" readonly="readonly" />
    </div>

    <div id="<? echo $se; ?>cup" class="div-redondo" style="position:absolute; top:147px; left:140px; width:103px; height:14px;" align="center">
        <input class="fuente-tar"  type="text" id="<? echo $se; ?>cupon" name="<? echo $se; ?>cupon" style="outline-style:none; border-style:none; width:95px; height:15px; border:0px;text-align:center; background-color:transparent;" maxlength="8" onkeypress="return Control<? echo $se; ?>cupon();" onkeydown="return Control<? echo $se; ?>cuponVol();" readonly="readonly" />
    </div>

    <div id="<? echo $se; ?>imp" class="div-redondo" style="position:absolute; top:169px; left:140px; width:103px; height:14px;" align="center">
        <input class="fuente-tar"  type="text" id="<? echo $se; ?>importe" name="<? echo $se; ?>importe" style="outline-style:none; border-style:none; width:95px; height:15px; border:0px;text-align:right; background-color:transparent;" maxlength="8" onkeypress="return Control<? echo $se; ?>importe();" onkeydown="return Control<? echo $se; ?>importeVol();" readonly="readonly" />
    </div>

    <div id="<? echo $se; ?>cuo" class="div-redondo" style="position:absolute; top:192px; left:140px; width:103px; height:14px;" align="center">
        <input class="fuente-tar" type="text" id="<? echo $se; ?>cuotas" name="<? echo $se; ?>cuotas" style="outline-style:none; border-style:none; width:95px; height:15px; border:0px;text-align:center; background-color:transparent;" value="1" maxlength="8" onkeypress="return Control<? echo $se; ?>cuotas();" onkeydown="return Control<? echo $se; ?>cuotasVol();" readonly="readonly" />
    </div>

	</form>
</div>

</body>
</html>
<?


mssql_query("commit transaction") or die("Error SQL commit");


?>
<script>

	EnvAyuda("Ingrese el n&uacute;mero de Tarjeta o Enter para Listar.");
						
	document.getElementById("DondeE").value = "<? echo $se; ?>idtarjeta";
	document.getElementById("CantiE").value = "2";
	document.getElementById("QuePoE").value = "1";
	
	document.getElementById('LetEnt').innerHTML = '<button class="StyBoton" onclick="<? echo $se; ?>siguiente_tar();" onmouseout="MM_swapImgRestore()" onmouseover="MM_swapImage(\'<? echo $se; ?>LetEntTar\',\'\',\'botones/ent-over.png\',0)"><img src="botones/ent-up.png" name="Enter" title="Enter" border="0" id="<? echo $se; ?>LetEntTar"/></button>';
	
	document.getElementById('LetTer').innerHTML = '';
	document.getElementById('NumVol').innerHTML = '';
	
	SoloBlock('LetEnt, NumVol');
	
	$('#<? echo $se; ?>idtarjeta').focus();
	$("#<? echo $se; ?>idtar").css("border-color", "#F90");
	
	var controldetar = "<? echo $se; ?>";
	if(controldetar == "b"){
		document.getElementById("<? echo $se; ?>importe").value = document.getElementById("total").value;
	}
	if(controldetar == "c"){
		document.getElementById("<? echo $se; ?>importe").value = document.getElementById("Matotal").value;
	}
	if(controldetar == "d"){
		
		document.getElementById("<? echo $se; ?>importe").value = document.getElementById("APagar").value;
		SoloBlock("NumVol");
		document.getElementById('NumVol').innerHTML = '<button class="StyBoton" onclick="Vol_Fpa();" onmouseout="MM_swapImgRestore()" onmouseover="MM_swapImage(\'LetNumVolTarj\',\'\',\'botones/vol-over.png\',0)"><img src="botones/vol-up.png" name="Volver" title="Volver" border="0" id="LetNumVolTarj"/></button>';
	
	}
	if(controldetar == "e"){
		
		document.getElementById("<? echo $se; ?>importe").value = document.getElementById("MaAPagar").value;
		SoloBlock("NumVol");
		document.getElementById('NumVol').innerHTML = '<button class="StyBoton" onclick="Vol_Fpa();" onmouseout="MM_swapImgRestore()" onmouseover="MM_swapImage(\'LetNumVolTarj\',\'\',\'botones/vol-over.png\',0)"><img src="botones/vol-up.png" name="Volver" title="Volver" border="0" id="LetNumVolTarj"/></button>';
	
	}
		
</script>
<?


}catch(Exception $e){////////////////////////////////////////////////////////////////////////////////////////////////// FIN DE TRY //
	
	?>
	<script>
		jAlert('ERROR Reintente la operacion solicitada.', 'Debo Retail - Global Business Solution');
	</script>
	<?
exit;

}
?>