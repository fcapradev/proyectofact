<?
require("config/cnx.php");


try {////////////////////////////////////////////////////////////////////////////////////////////////// COMIENZO TRY //


mssql_query("begin transaction",$conexion) or die("Error SQL begin trans");

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Confirmar Caja</title>
<style>

#MCajaFon{ 
	position:absolute; 
	width:738px; 
	height:354px; 
	left:0px; 
	top:0px; 
	z-index:1;
}

#MCaja{
	position:absolute; 
	width:680px; 
	height:306px; 
	left:40px; 
	top:47px;
	z-index:2;
}

.CajaFonCC{ 
	background-image:url(ConCaja/FonC.png); 
	background-repeat:no-repeat; 
	font-family: "TPro"; 
	font-size:14px; 
	cursor:pointer;
	margin-top:2px;
	color:#FFF; 
	width:377px; 
}

.CajaFonSS{ 
	background-image:url(ConCaja/FonS.png); 
	background-repeat:no-repeat; 
	font-family: "TPro"; 
	font-size:14px; 
	cursor:pointer;
	margin-top:2px;
	color:#FFF; 
	width:377px; 
}

.cajaselst{
	position:absolute; 
	width:738px; 
	height:354px; 
	left:452px; 
	top:-25px;
	z-index:2;
}

.CajaSelI{ 
	position:absolute;
	font-family: "TPro"; 
	font-size:14px; 
	color:#FFF;
}

.cajatextarea{
	background-color:transparent;
	resize:none;
	border:0px; 
	width:207px; 
	height:168px;
	font-family: "TPro"; 
	font-size:12px; 
	color:#FFF;
}

</style>
<script>

function EnviarPla(t,c,pla){

document.getElementById('LetTer').innerHTML = '<button onclick="ConPla('+pla+');" class="StyBoton" onmouseout="MM_swapImgRestore()" onmouseover="MM_swapImage(\'LetTerCon1\',\'\',\'botones/cont-over.png\',0)"><img src="botones/cont-up.png" name="Continuar" title="Continuar" border="0" id="LetTerCon1"/></button>';
			
	SoloBlock('LetTer');
	
	for (i=1; i<=t; i++){
	
		if(i == c){
			$("#CajaN"+i).removeClass("CajaFonCC").addClass("CajaFonSS");
			SoloBlock('CajaSel'+i);
		}else{
			$("#CajaN"+i).removeClass("CajaFonSS").addClass("CajaFonCC");
			SoloNone('CajaSel'+i);
		}
		
	}

}

function ConPla(pla){
	
	$("#Confirmar").load("CCaja.php?pla="+pla);
	SoloNone('Marca, LetEnt, LetTer, NumVol, NumVolPro');
	EnvAyuda('Ocultar');

}

function salir(){
		
	Mos_Ocu('BotonesPri');
	SoloNone('Confirmar, fondotranspnumeros, TecladoNum, fondotranspletras, TecladoLet');
	SoloBlock('SobreFoca, Marca');
	EnvAyuda("Ocultar");

}

document.getElementById('LetSal').innerHTML = '<button onclick="salir();" class="StyBoton" onmouseout="MM_swapImgRestore()" onmouseover="MM_swapImage(\'LetSalconf\',\'\',\'botones/sal-over.png\',0)"><img src="botones/sal-up.png" name="Salir" title="Salir" border="0" id="LetSalconf"/></button>';

EnvAyuda("Seleccione la caja que desea confirmar.");
	
</script>
</head>
<body>

<div id="MCajaFon"><img src="ConCaja/MCaja.png" /></div>


<div id="MCaja">

<?
$_SESSION['ParSQL'] = "SELECT TOP 11 PLA, TUR, MTN, FAP, FCT, OPE, OBS_EFE_REC FROM ATURNOSO where CER = 'C' AND PLC = 'N' ORDER BY PLA DESC";
$registros = mssql_query($_SESSION['ParSQL']) or die("Error SQL");
rollback($registros);
$cc = mssql_num_rows($registros);
$c = 0;
while ($reg=mssql_fetch_array($registros)){

$c = $c + 1;

	$PLA = $reg['PLA'];
	$FAP = $reg['FAP'];
	$FCT = $reg['FCT'];
	$MTN = $reg['MTN'];
	$OPE = $reg['OPE'];
	$DES = $reg['OBS_EFE_REC'];
	
$M_PLA = "(".format($PLA,5,'0',STR_PAD_LEFT).")";
$M_MTN = format($MTN,2,'0',STR_PAD_LEFT);

if($FAP != NULL){
	$date = new DateTime($FAP);
	$M_FAP = $date->format('d-m-Y H:i');
}else{
	$M_FAP ="";
}
if($FCT != NULL){
	$date = new DateTime($FCT);
	$M_FCT = $date->format('d-m-Y H:i');
}else{
	$M_FCT = "";
}

?>

    <div id="CajaN<? echo $c; ?>" class="CajaFonCC" onclick="EnviarPla(<? echo $cc; ?>, <? echo $c; ?>, <? echo $PLA; ?>);">
    <table width="377" height="24" border="0">
    <tr>
    
        <td width="17">&nbsp;</td>
        <td width="52"><? echo $M_PLA; ?></td>
        <td width="20"><? echo $M_MTN; ?></td>
        <td width="134"><? echo $M_FAP; ?></td>
        <td width="134"><? echo $M_FCT; ?></td>
    
    </tr>
    </table>
    </div>
    
<div id="CajaSel<? echo $c; ?>" class="cajaselst" style="display:none;">
    <div class="CajaSelI" style="left:81px; top:7px;"><? echo $PLA; ?></div>
    <div class="CajaSelI" style="left:81px; top:27px;"><? echo $M_MTN; ?></div>
    <div class="CajaSelI" style="left:81px; top:45px;"><? echo $M_FAP; ?></div>
    <div class="CajaSelI" style="left:81px; top:63px;"><? echo $M_FCT; ?></div>
    <div class="CajaSelI" style="left:81px; top:81px;"><? echo $OPE; ?></div>
    <div class="CajaSelI" style="left:10px; top:145px;"><textarea class="cajatextarea"><? echo $DES; ?></textarea></div>
</div>

<?

}
mssql_free_result($registros);
?>

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