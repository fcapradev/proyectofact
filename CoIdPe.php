<?
require("config/cnx.php");

try {////////////////////////////////////////////////////////////////////////////////////////////////// COMIENZO TRY //

mssql_query("begin transaction",$conexion) or die("Error SQL begin trans");
?>


<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>C&oacute;digo de Identificaci&oacute;n Personal</title>

<style>
.font-cio{
	font-family: "TPro";
	font-size:12px;
	position:absolute;
	color:#FFFFFF;
	height:16px;
}

#CipDetalle{	
	position:absolute;
	font: Gautami; 
	font-weight:bold; 
	color:#FFFFFF; 
	font-size:12px; 
	z-index:1;
}
#Codigo{
	position:absolute;
	font: Gautami; 
	font-weight:bold; 
	color:#FFFFFF; 
	font-size:12px; 
	z-index:1; 
	top:8px; 
	left:8px;
}


</style>

<script>

$(document).ready(function(){
	$('#cambiopsw').submit(function(){
        $.ajax({
            type: 'POST',
            url: $(this).attr('action'),
            data: $(this).serialize(),
            success: function(data){
			$('#archivos').html(data);
			salir_cip();
            }
        })
        return false;
    });
})


$("#cvieja").css("border-color", "#F90");

document.getElementById("DondeE").value = "clavev";
document.getElementById("CantiE").value = "25";
document.getElementById("QuePoE").value = "0";

SoloBlock("LetSal");

document.getElementById('LetSal').innerHTML = '<button class="StyBoton" onclick="salir_cip();" onmouseout="MM_swapImgRestore()" onmouseover="MM_swapImage(\'LetSalCip\',\'\',\'botones/sal-over.png\',0)"><img src="botones/sal-up.png" name="Salir" title="Salir" border="0" id="LetSalCip"/></button>';

document.getElementById('LetEnt').innerHTML = '<button onclick="siguiente_cip();" class="StyBoton" onmouseout="MM_swapImgRestore()" onmouseover="MM_swapImage(\'LetEntCip1\',\'\',\'botones/ent-over.png\',0)"><img src="botones/ent-up.png" name="Enter" title="Enter" border="0" id="LetEntCip1"/></button>';

document.getElementById('NumVol').innerHTML = '<button onclick="salir_cip();" class="StyBoton" onmouseout="MM_swapImgRestore()" onmouseover="MM_swapImage(\'LetVolFacVcip\',\'\',\'botones/vol-over.png\',0)"><img src="botones/vol-up.png" name="Volver" title="Volver" border="0" id="LetVolFacVcip"/></button>';

function salir_cip(){

	Mos_Ocu("BotonesPri");
	Mos_Ocu('CoIdPe');
	
	$('#SobreFoca').fadeIn(500);

	SoloNone('TecladoLet, TecladoNum, LetEnt, NumVol, fondotranspletras, fondotranspnumeros, CarAyuda, CarAyudaFon');

	document.getElementById('CoIdPe').innerHTML = '';
	
}
	
function siguiente_cip(){
	
	var psw1  = document.getElementById("clavev").value.length;
	var psw2  = document.getElementById("claveo").value;
	var psw3  = document.getElementById("clavev").value;	

	if(psw1 >3 ){
	
		if(psw2 == psw3){
		
			$("#cvieja").css("border-color", "transparent");
			$("#cnueva").css("border-color", "#F90");
			
			EnvAyuda("Ingrese una nueva contrasena");
			document.getElementById("DondeE").value = "claven";
			document.getElementById("CantiE").value = "25";
			document.getElementById("QuePoE").value = "0";
		
			document.getElementById('LetEnt').innerHTML = '<button onclick="siguiente_cip2();" class="StyBoton" onmouseout="MM_swapImgRestore()" onmouseover="MM_swapImage(\'LetEntFac\',\'\',\'botones/ent-over.png\',0)"><img src="botones/ent-up.png" name="Enter" title="Enter" border="0" id="LetEntCip"/></button>';
			
			document.getElementById('NumVol').innerHTML = '<button onclick="volver_cip2();" class="StyBoton" onmouseout="MM_swapImgRestore()" onmouseover="MM_swapImage(\'LetVolFacVcip2\',\'\',\'botones/vol-over.png\',0)"><img src="botones/vol-up.png" name="Volver" title="Volver" border="0" id="LetVolFacVcip2"/></button>';

		}else{
			document.getElementById("clavev").value = "";
			jAlert('Ingrese correctamente su contraseña.', 'Debo Retail - Global Business Solution');			
		}

		
		
	}else{
		document.getElementById("clavev").value = "";
		jAlert('La contraseña debe ser mayor a 3 dígitos.', 'Debo Retail - Global Business Solution');
	}
		
}
	
function siguiente_cip2(){

	var pswn = document.getElementById("claven").value.length;
	var psw1  = document.getElementById("clavev").value;	
	var psw2  = document.getElementById("claven").value;	
	
	if(psw1 == psw2){
		document.getElementById("claven").value = "";
		jAlert('Las contraseñas no pueden ser iguales', 'Debo Retail - Global Business Solution');
	
	}else{
		if(pswn < 4){
			
			document.getElementById("claven").value = "";
			jAlert('Ingresar una contraseña mayor a 3 caracteres.', 'Debo Retail - Global Business Solution');
			
		}else{
			
			$("#cnueva").css("border-color", "transparent");
			$("#cnuevar").css("border-color", "#F90");
			
			EnvAyuda("Repita su contrasena nueva.");			
			document.getElementById("DondeE").value = "clavenr";
			document.getElementById("CantiE").value = "25";
			document.getElementById("QuePoE").value = "0";
			
			document.getElementById('LetEnt').innerHTML = '<button onclick="siguiente_cip3();" class="StyBoton" onmouseout="MM_swapImgRestore()" onmouseover="MM_swapImage(\'LetEntCipaa\',\'\',\'botones/ent-over.png\',0)"><img src="botones/ent-up.png" name="Enter" title="Enter" border="0" id="LetEntCipaa"/></button>';
			document.getElementById('NumVol').innerHTML = '<button onclick="volver_cip3();" class="StyBoton" onmouseout="MM_swapImgRestore()" onmouseover="MM_swapImage(\'LetVolFacVcip3\',\'\',\'botones/vol-over.png\',0)"><img src="botones/vol-up.png" name="Volver" title="Volver" border="0" id="LetVolFacVcip3"/></button>';
			
		}
	}
}	

function volver_cip2(){

	$("#cvieja").css("border-color", "#F90");
	$("#cnueva").css("border-color", "transparent");
	
	EnvAyuda("Ingrese una contraseña Actual.");
	
	document.getElementById("DondeE").value = "clavev";
	document.getElementById("CantiE").value = "25";
	document.getElementById("QuePoE").value = "0";
	
	document.getElementById('LetSal').innerHTML = '<button class="StyBoton" onclick="salir_cip();" onmouseout="MM_swapImgRestore()" onmouseover="MM_swapImage(\'LetSalCip\',\'\',\'botones/sal-over.png\',0)"><img src="botones/sal-up.png" name="Salir" title="Salir" border="0" id="LetSalCip"/></button>';
	
	document.getElementById('LetEnt').innerHTML = '<button onclick="siguiente_cip();" class="StyBoton" onmouseout="MM_swapImgRestore()" onmouseover="MM_swapImage(\'LetEntCip1\',\'\',\'botones/ent-over.png\',0)"><img src="botones/ent-up.png" name="Enter" title="Enter" border="0" id="LetEntCip1"/></button>';
	
	document.getElementById('NumVol').innerHTML = '<button onclick="salir_cip();" class="StyBoton" onmouseout="MM_swapImgRestore()" onmouseover="MM_swapImage(\'LetVolFacVcip\',\'\',\'botones/vol-over.png\',0)"><img src="botones/vol-up.png" name="Volver" title="Volver" border="0" id="LetVolFacVcip"/></button>';
	
}


function siguiente_cip3(){
	var pswnv = document.getElementById("claven").value;
	var pswvv = document.getElementById("clavenr").value;
		
		if(pswnv == pswvv){

			$("#cnuevar").css("border-color", "transparent");
			
			EnvAyuda("Presione Terminar para Generar su Nueva Contraseña.");
			
			document.getElementById('NumVol').style.display="none";
			document.getElementById('LetEnt').style.display="none";			
			document.getElementById('LetTer').style.display="block";
			
			document.getElementById('LetTer').innerHTML = '<button onclick="enviar_form();" class="StyBoton" onmouseout="MM_swapImgRestore()" onmouseover="MM_swapImage(\'LetTerCipaa\',\'\',\'botones/ter-over.png\',0)"><img src="botones/ter-up.png" name="Terminar" title="Terminar" border="0" id="LetTerCipaa"/></button>';
			
		}else{
		
			document.getElementById("clavenr").value = "";
			jAlert('Las contraseñas no son iguales', 'Debo Retail - Global Business Solution');
			
		}

}	

function volver_cip3(){

	$("#cnuevar").css("border-color", "transparent");
	$("#cnueva").css("border-color", "#F90");
	
	EnvAyuda("Ingrese una nueva contraseña");

	document.getElementById("DondeE").value = "claven";
	document.getElementById("CantiE").value = "25";
	document.getElementById("QuePoE").value = "0";

	document.getElementById('LetEnt').innerHTML = '<button onclick="siguiente_cip2();" class="StyBoton" onmouseout="MM_swapImgRestore()" onmouseover="MM_swapImage(\'LetEntFac\',\'\',\'botones/ent-over.png\',0)"><img src="botones/ent-up.png" name="Enter" title="Enter" border="0" id="LetEntCip"/></button>';
	
	document.getElementById('NumVol').innerHTML = '<button onclick="volver_cip2();" class="StyBoton" onmouseout="MM_swapImgRestore()" onmouseover="MM_swapImage(\'LetVolFacVcip2\',\'\',\'botones/vol-over.png\',0)"><img src="botones/vol-up.png" name="Volver" title="Volver" border="0" id="LetVolFacVcip2"/></button>';
	
}

function enviar_form(){
	$('#cambiopsw').submit();
}
</script>



</head>

<body>

<div id="Cip">
	<img src="CIP/cip.png" />
</div>

<div id="Codigo">
<form method="post" action="CoIdPeCla.php" id="cambiopsw" name="cambiopsw">
	<?
	//SELECT PARA BUSCAR LOS DATOS ANTES
	$CodVen = $_SESSION['idsusua'];
	$_SESSION['ParSQL'] = "SELECT CodVen,NomVen,ClaVen,CLAANT FROM VENDEDORES WHERE CodVen=".$CodVen."";
	$RSBTABLA = mssql_query($_SESSION['ParSQL']) or die("Error SQL");
	rollback($RSBTABLA);
	while ($RB=mssql_fetch_array($RSBTABLA)){
	 $claant = $RB['CLAANT'];
	 $cla = $RB['ClaVen'];
	 $nom = $RB['NomVen'];
	}
	?>

	<div style="position:absolute; top:155px; left:345px;">
		<input class="font-cio" type="text" id="codven" name="codven" style="width:48px; height:15px; border:0; background-color:#DD7927;" value="<? echo $CodVen; ?>"/>
	</div>
	
	<div style="position:absolute; top:179px; left:345px;">
		<input class="font-cio" type="text" id="nombre" name="nombre" style="width:145px; height:15px; border:0; background-color:#DD7927;" value="<? echo $nom; ?>"/>
	</div>	
	
	<div id="cvieja" class="div-redondo" style="position:absolute; top:224px; left:410px; width:126px; height:15px;">
		<input type="password" id="clavev" name="clavev" style="width:110px; height:15px; border:0; background-color:transparent;"/>
	</div>	
	
	<div id="cnueva" class="div-redondo" style="position:absolute; top:250px; left:410px; width:126px; height:15px;">
		<input type="password" id="claven" name="claven" style="width:110px; height:15px; border:0; background-color:transparent;"/>
	</div>
	
	<div id="cnuevar" class="div-redondo" style="position:absolute; top:276px; left:410px; width:126px; height:15px;">
		<input type="password" id="clavenr" name="clavenr" style="width:110px; height:15px; border:0; background-color:transparent;"/>
	</div>
	
	<div style="position:absolute; display:none;">
		<input type="hidden" id="claveo" name="claveo" value="<? echo trim($cla); ?>" style="width:110px; height:15px; border:0; background-color:#E7E7E8;"/>
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