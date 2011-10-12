<?
require("config/cnx.php");

try {////////////////////////////////////////////////////////////////////////////////////////////////// COMIENZO TRY //

mssql_query("begin transaction",$conexion) or die("Error SQL begin trans");

$TAR = $_REQUEST['tar'];
$NCU = $_REQUEST['ncu'];
$NLO = $_REQUEST['nlo'];


$_SESSION['ParSQL'] = "
SELECT C.NplVen AS PLA, D.FAP AS FAP, A.MTN, A.DES, A.INI, A.FIN FROM ATURNOSH AS A 
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

	$PLA = $reg['PLA'];
}

$LUG = $_SESSION['ParLUG'];
$OPE = $_SESSION['idsusua'];
$NOM = $_SESSION['idsusun'];

///////////////////////////TRAIGO LOS DATOS COMPLETOS DE LA TARJETA ///////////////////////

$_SESSION['ParSQL'] = "SELECT * FROM ACUPONES WHERE TAR = ".$TAR." AND NCU = ".$NCU." AND NLO = ".$NLO."";

$registros = mssql_query($_SESSION['ParSQL']) or die("Error SQL");
rollback($registros);		

if(mssql_num_rows($registros)==0){
	exit;
}
while ($reg=mssql_fetch_array($registros)){

	$PAU = $reg['PAU']; //PRESENTACION
	$FEC = $reg['FEC']; //FECHA
	$SUC = $reg['SUC']; //SUCURSAL
	$NTE = $reg['NTE']; //TERMINAL
	$NCU = $reg['NCU']; //CUPON
	$IMP = $reg['IMP']; //IMPORTE
	$CCU = $reg['CCU']; //CUOTAS
}

///////////////// BUSCA EL NOMBRE DE LA TARJETA ///////////////
$_SESSION['ParSQL'] = "SELECT * FROM ATARJETAS WHERE ID = ".$TAR."";
$RSBTABLA = mssql_query($_SESSION['ParSQL']) or die("Error SQL");
rollback($RSBTABLA);

while ($r1=mssql_fetch_array($RSBTABLA)){

	$TARNOM=$r1['NOM'];
}

if($PAU == "S"){
	$tipo="AUTOMATICA";
}else{
	$tipo="MANUAL";
}

$fecha = $FEC;
$date = new DateTime($fecha);
$fecha = $date->format('d-m-Y H:i');

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Modificar Tarjetas</title>

<style>

#TarModFondo{
	position:absolute;
	left:208px;
	z-index:1;
}

#TarModDetalle{
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

.items-tarcon{
	font-family: "TPro";
	font-size:12px;
	text-align:center;
	position:absolute;
	color:#000;
	height:16px;
}
</style>

<script>

$(document).ready(function(){
	$('#formtarmod').submit(function(){
        $.ajax({
            type: 'POST',
            url: $(this).attr('action'),
            data: $(this).serialize(),
            success: function(data){
				$('#archivos').html(data);
				salir_tarjeta_mod();
            }
        })
        return false;
    });
})

function salir_tarjeta_mod(){

	SoloNone("fondotranspletras, fondotranspnumeros, TecladoNum, LetTer, CarAyuda, CarAyudaFon, TecladoLet, LetSal, LetEnt, TarModFondo, TarModDetalle, NumVol");

	$('#Tarjetas').fadeOut(500);
	document.getElementById('TarModFondo').innerHTML = '';
	$("#Tarjetas").load("Tarjetas.php");		
	$('#Tarjetas').fadeIn(500);
	

}

$("#imp_mod").css("border-color", "#F90");
$('#importe_mod').focus();


function siguiente_tar_Mod(){

	var imp  = document.getElementById("importe_mod").value;
	if( imp == 0 ){
			
		document.getElementById("importe_mod").value = "";
		jAlert('Debe ingresar un importe correctamente.', 'Debo Retail - Global Business Solution');
			
	}else{

		document.getElementById("importe_mod").value = dec(imp.replace(",","."));
	
		$("#imp_mod").css("border-color", "transparent");
		$('#importe_mod').focus();
	
		SoloNone("LetEnt");
		SoloBlock("LetTer");

		EnvAyuda("Presione Terminar para modificar la Tarjeta.");

		document.getElementById('LetTer').innerHTML = '<button class="StyBoton" onclick="terminartar_mod();" onmouseout="MM_swapImgRestore()" onmouseover="MM_swapImage(\'LetTerTarMod\',\'\',\'botones/ter-over.png\',0)"><img src="botones/ter-up.png" name="Terminar" title="Terminar" border="0" id="LetTerTarMod"/></button>';
	
		document.getElementById('NumVol').innerHTML = '<button class="StyBoton" onclick="volver_tar_mod();" onmouseout="MM_swapImgRestore()" onmouseover="MM_swapImage(\'LetVolTarMod\',\'\',\'botones/vol-over.png\',0)"><img src="botones/vol-up.png" name="Volver" title="Volver" border="0" id="LetVolTarMod"/></button>';
	}
}

function volver_tar_mod(){
			
		$("#imp_mod").css("border-color", "#F90");
		
		EnvAyuda("Ingrese un importe");
	
		document.getElementById("DondeE").value = "importe_mod";
		document.getElementById("CantiE").value = "8";
		document.getElementById("QuePoE").value = "1";

		SoloBlock("LetEnt");
		SoloNone("LetTer, NumVol");
	
		document.getElementById('LetEnt').innerHTML = '<button onclick="siguiente_tar_Mod();" class="StyBoton" onmouseout="MM_swapImgRestore()" onmouseover="MM_swapImage(\'LetEntTar\',\'\',\'botones/ent-over.png\',0)"><img src="botones/ent-up.png" name="Enter" title="Enter" border="0" id="LetEntTar"/></button>';
		
		$('#importe_mod').focus();
}


function terminartar_mod(){

	$('#formtarmod').submit();
	
}

/****************************************************************************************************/
/****************************************************************************************************/
/****************************************************************************************************/


function Controlimporte(){

	if(document.getElementById("imp_mod").style.borderColor == 'transparent'){
		return false;
	}
	var k = window.event.keyCode;
	if(!((k == 46) || (k == 13) || ((k >= 48) && (k <= 57)))){
		return false;
	}
	if(k == 13){
		siguiente_tar_Mod();
		return false;
	}

}

function ControlimporteVol(){

	var k = window.event.keyCode;

	if(k == 27){	
	
		if(document.getElementById("imp_mod").style.borderColor == 'transparent'){
			volver_tar_mod();
		}else{
			return false;	
		}
	}


	if(k == 113){

		if($('#LetTer').css('display') == 'block'){

			terminartar_mod();
		}
	}

}


</script>

</head>
<body>


<div id="TarModFondo"><img src="tarjetas/tarjeta.png" /></div>

<div id="TarModDetalle">

<form method="post" id="formtarmod" name="formtarmod" action="TarProcesa.php">
  
    <div class="fuente-tar" style="position:absolute; top:-14px; left:13px; background-color:#DD7927; width:50px; text-align:center; color:#FFF; font-weight:bold;">
        <? echo $OPE;?>
    </div>	
    <div class="fuente-tar" style="position:absolute; top:-14px; left:100px; width:200px; color:#FFF; font-weight:bold;">
        <? echo $NOM;?>
    </div>
    <div class="fuente-tar" style="position:absolute; top:7px; left:146px; background-color:#DD7927; width:95px; text-align:center; color:#FFF; font-weight:bold;">
        <? echo $PLA;?>
    </div>
    <div style="position:absolute; top:2px; left:-2px;">
        <div class="items-tarcon" style=" top:36px; left:145px; width:30px;" ><? echo $TAR; ?></div>
    
        <div class="items-tarcon" style=" top:36px; left:182px; width:161px; " ><? echo $TARNOM; ?></div>	
        
        <div class="items-tarcon" style="top:57px; left:145px; width:195px;" > <? echo $tipo; ?></div>
        
        <div class="items-tarcon" style="top:79px; left:97px; width:195px; height:16px;" > <? echo $fecha; ?></div>
        
        <div class="items-tarcon" style="top:102px; left:97px; width:195px; height:16px;" > <? echo $SUC; ?></div>
        
        <div class="items-tarcon" style="top:125px; left:97px; width:195px; height:16px;" > <? echo $NTE; ?></div>
        
        <div class="items-tarcon" style="top:147px; left:97px; width:195px; height:16px;" > <? echo $NCU; ?></div>
        
        <div id="imp_mod" class="div-redondo" style="position:absolute; top:167px; left:142px; width:103px; height:14px;" align="center">
        <input class="fuente-tar"  type="text" id="importe_mod" name="importe_mod" style="outline-style:none; border-style:none; width:95px; height:14px; border:0px;text-align:right; background-color:transparent;" maxlength="12" onkeypress="return Controlimporte();" onkeydown="return ControlimporteVol();" value="<? echo dec($IMP,2); ?>" />
        <input type="hidden" value="1" name="ban" id="ban" />
        <input type="hidden" value="<? echo $TAR; ?>" name="TAR" id="TAR" />
        <input type="hidden" value="<? echo $NCU; ?>" name="NCU" id="NCU" />
        <input type="hidden" value="<? echo $NLO; ?>" name="NLO" id="NLO" />
        <input type="hidden" value="<? echo $SUC; ?>" name="SUC" id="SUC" />
	    </div>
       
        <div class="items-tarcon" style="top:195px; left:97px; width:195px; height:16px;"> <? echo $CCU; ?></div>
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