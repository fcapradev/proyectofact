<?
require("config/cnx.php");

try {////////////////////////////////////////////////////////////////////////////////////////////////// COMIENZO TRY //

mssql_query("begin transaction",$conexion) or die("Error SQL begin trans");
?>


<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Arqueo de Caja</title>
<style>
.fon-arq{
	font-family: "TPro";
	font-size:12px;
	position:absolute;
	color:#FFFFFF;
	height:16px;
}

.texteca{
	background-color:transparent;
	color:#FFF;
	text-align:center;
	font-family: "TPro";
	margin-top:5px;
	font-size:12px;
	border:0px;
}
</style>

<script>

function salir_arq(){

	$('#SobreFoca').fadeIn(500);
	
	Mos_Ocu('BotonesPri');
	Mos_Ocu('Arqueo');
	
	SoloNone('TecladoLet, TecladoNum, NumVol, fondotranspletras, fondotranspnumeros, CarAyuda, CarAyudaFon');

	document.getElementById('Arqueo').innerHTML = '';
}

function siguiente_arq(){
	
	var psw  = document.getElementById("psw2").value;
	var pswori  = document.getElementById("pswori").value;


	if(psw == pswori){
		
		$('#Arqueo').fadeOut(500);
		$("#Arqueo").load("ArqAgr.php");
		$('#Arqueo').fadeIn(500);
		
		SoloNone('fondotranspletras, TecladoLet, NumVol');
		EnvAyuda("Seleccione un Supervisor");
		
	}else{
		document.getElementById("psw2").value = "";
		jAlert('Ingrese correctamente su contraseña.', 'Debo Retail - Global Business Solution');
		

	}		

	return false;		
}

function verpdf(){

	$("#Arqueo").load("ArqVerImp.php");
	SoloNone('fondotranspletras');
	SoloNone('TecladoLet');
	SoloNone('fondotranspnumeros');
	SoloNone('TecladoNum');

}

function Valida_Usuario (){

	var usr = document.getElementById("usua").value;
	var usrDB  = document.getElementById("claDB").value;


	if(usr <= 0){
		
		jAlert('Ingrese un Operario.', 'Debo Retail - Global Business Solution');
		document.getElementById("usua").value = "";
		controlarcadainput('usua');
		
	}else{

		$("#usrDiv").css("border-color", "transparent");
		$("#pswDiv").css("border-color", "#F90");
		
		$('#psw').focus();
		controlarcadainput('psw');
		document.getElementById("DondeE").value = "psw";
		document.getElementById("CantiE").value = "10";
		document.getElementById("QuePoE").value = "0";
		
		SoloBlock("NumVol");
		
		document.getElementById('LetEnt').innerHTML = '<button onclick="Valida_Password();" class="StyBoton" onmouseout="MM_swapImgRestore()" onmouseover="MM_swapImage(\'LetEntTicket\',\'\',\'botones/ent-over.png\',0)"><img src="botones/ent-up.png" name="Enter" title="Enter" border="0" id="LetEntTicket"/></button>';		

		document.getElementById('NumVol').innerHTML = '<button onclick="Volver_Usuario();" class="StyBoton" onmouseout="MM_swapImgRestore()" onmouseover="MM_swapImage(\'NumVolTicket\',\'\',\'botones/vol-over.png\',0)"><img src="botones/vol-up.png" name="Volver" title="Volver" border="0" id="NumVolTicket"/></button>';		
		
		EnvAyuda("Ingrese la contraseña del Operario.");
		
	}
}

function Volver_Usuario(){

	$("#usrDiv").css("border-color", "#F90");
	$("#pswDiv").css("border-color", "transparent");
	
	$('#usua').focus();	
	controlarcadainput('usua');
	
	document.getElementById("DondeE").value = "usua";
	document.getElementById("CantiE").value = "12";
	document.getElementById("QuePoE").value = "1";
	
	EnvAyuda("Ingrese la clave del operario Supervisor.");
	SoloNone("NumVol");
	
	document.getElementById('LetEnt').innerHTML = '<button onclick="Valida_Usuario();" class="StyBoton" onmouseout="MM_swapImgRestore()" onmouseover="MM_swapImage(\'LetEntTicket\',\'\',\'botones/ent-over.png\',0)"><img src="botones/ent-up.png" name="Enter" title="Enter" border="0" id="LetEntTicket"/></button>';		
	
}

function Valida_Password(){

	var usr  = document.getElementById("usua").value;
	var psw  = document.getElementById("psw").value;
	
	if(psw.length <= 0){
		
		jAlert('Ingrese una clave correcta.', 'Debo Retail - Global Business Solution');
		document.getElementById("psw").value = "";		
		controlarcadainput('psw');
	}else{
		
		$("#archivos").load("ArqueoCaja/ArqueoVal.php?usr="+usr+"&psw="+psw+"");
		
	}
}
/****************************************************************************************************/
/****************************************************************************************************/
/****************************************************************************************************/

function ControlUsr(){

	if(document.getElementById("usrDiv").style.borderColor == 'transparent'){
		return false;
	}
	var k = window.event.keyCode;
	if(!((k == 13) || ((k >= 48) && (k <= 57)))){		//SOLO NUMEROS
		return false;
	}
	if(k == 13){
		Valida_Usuario();
	}	
}

function ControlPsw(){

	if(document.getElementById("pswDiv").style.borderColor == 'transparent'){
		return false;
	}
	var k = window.event.keyCode;
	if(!((k == 32) || (k == 13) || ((k >= 65) && (k <= 90)) || ((k >= 48) && (k <= 57)) || ((k >= 97) && (k <= 122)))){	//ALFANUMERICO
		return false;
	}
	if(k == 13){
		Valida_Password();
	}

}

function ControlPswVol(){
	
	if(document.getElementById("pswDiv").style.borderColor == 'transparent'){
		return false;
	}	
	var k = window.event.keyCode;
	if(k == 27){
		Volver_Usuario();
	}

}

function ControlNivel(){

	if(document.getElementById("pas").style.borderColor == 'transparent'){
		return false;
	}
	var k = window.event.keyCode;
	if(!((k == 32) || (k == 13) || ((k >= 65) && (k <= 90)) || ((k >= 48) && (k <= 57)) || ((k >= 97) && (k <= 122)))){	//ALFANUMERICO
		return false;
	}
	if(k == 13){
		siguiente_arq();
	}

}

function controlarcadainput(cu){

	$("input").attr("readonly", "readonly");
	$("#"+cu).removeAttr("readonly");
	$("#"+cu).focus();
}

</script>
</head>

<body>
<?
	//SELECT PARA BUSCAR LA CLAVE DEL OPERARIO
	
	$_SESSION['ParSQL'] = "SELECT ESENC FROM VENDEDORES WHERE CodVen = ".$_SESSION['idsusua']."";
//	$_SESSION['ParSQL'] = "SELECT ESENC FROM VENDEDORES WHERE CodVen = 22";	
	$DBESENC = mssql_query($_SESSION['ParSQL']) or die("Error SQL");
	rollback($DBESENC);
	
	while ($RB=mssql_fetch_array($DBESENC)){
		$ESENC = $RB['ESENC'];
	}
	
	if($ESENC == 1){
	?>

<script>
	$("#pas").css("border-color", "#F90");
	
	controlarcadainput('psw2');
	document.getElementById("DondeE").value = "psw2";
	document.getElementById("CantiE").value = "12";
	document.getElementById("QuePoE").value = "0";	

	EnvAyuda("Ingrese la clave de Seguridad.");
	
	document.getElementById("LetEnt").innerHTML = '<button onclick="siguiente_arq();" class="StyBoton" onmouseout="MM_swapImgRestore()" onmouseover="MM_swapImage(\'LetEntArq2\',\'\',\'botones/ent-over.png\',0)"><img src="botones/ent-up.png" name="Enter" title="Enter" border="0" id="LetEntArq2"/></button>';
	
	
</script>    

<div id="seguridad">
    <div id="ImgFonArq" style="position:absolute; left:198px; top:77px; height:124px; width:340px; display:block;">
        <img src="ArqueoCaja/contraseña de arqueo.png" />
    </div>
    
    <?
        //SELECT PARA BUSCAR LA CLAVE DE SEGURIDAD SECUNDARIA
        $_SESSION['ParSQL'] = "SELECT CSeNiv FROM APARSIS";
        $RSBTABLA = mssql_query($_SESSION['ParSQL']) or die("Error SQL");
        rollback($RSBTABLA);
        
        while ($RB=mssql_fetch_array($RSBTABLA)){
            $CSeNiv = $RB['CSeNiv'];
        }
        ?>
    
    <div id="pas" class="div-redondo" style="position:absolute; left:257px; top:152px; width:216px; height:18px;">
    
        <input class="fon-arq" type="password" name="psw2" id="psw2" readonly="readonly" style="position:absolute; left:90px; top:2px; background:none; border:0; outline-style:none; border-style:none; text-align:center;" maxlength="12" onKeyPress="return ControlNivel();"/>
    
        <input type="hidden" value="<? echo trim($CSeNiv); ?>" id="pswori" name="pswori"/>
    
    </div>

</div>	
	<?
	}else{
	?>

<script>

	$("#usrDiv").css("border-color", "#F90");
	$('#usua').focus();
	controlarcadainput('usua');
	document.getElementById("DondeE").value = "usua";
	document.getElementById("CantiE").value = "12";
	document.getElementById("QuePoE").value = "1";
	
	EnvAyuda("Ingrese la clave del operario Supervisor.");
	
	document.getElementById('LetEnt').innerHTML = '<button onclick="Valida_Usuario();" class="StyBoton" onmouseout="MM_swapImgRestore()" onmouseover="MM_swapImage(\'LetEntArqueo\',\'\',\'botones/ent-over.png\',0)"><img src="botones/ent-up.png" name="Enter" title="Enter" border="0" id="LetEntArqueo"/></button>';
	

</script>

<div id="identificacion" style="position:absolute; top:70px; left:250px;">

<?
	//SELECT PARA BUSCAR LA CLAVE DEL OPERARIO
	
	$_SESSION['ParSQL'] = "SELECT CodVen, ClaVen FROM VENDEDORES";
	$RSBTABLA = mssql_query($_SESSION['ParSQL']) or die("Error SQL");
	rollback($RSBTABLA);
	
	while ($RB=mssql_fetch_array($RSBTABLA)){
		$CodVen = $RB['CodVen'];
		$ClaVen = $RB['ClaVen'];
	}
?>
<input type="hidden" value="<? echo trim($ClaVen); ?>" id="claDB" name="claDB" />
<input type="hidden" value="<? echo trim($CodVen); ?>" id="pswDB" name="pswDB" />

<div id="titulo" style="position:absolute; top:10px; left:40px; font-family:'TPro'">Ingrese el c&oacute;digo de Supervisor</div>

    <table width="239" height="108" align="center" background="tarjetas/fonind.png" style="background-color:transparent; background-repeat:no-repeat; ">
    <tr>
    <td valign="bottom">
        <table width="224" align="center">
       
        <tr>
        <td background="tarjetas/usua.png" style="background-repeat:no-repeat;" width="218" height="21">
            <div align="right" id="usrDiv" class="div-redondo" style="width:218px; height:22px; top:-5px; left:-2px; position:relative;">
                <input type="text" name="usua" id="usua" class="texteca" size="17" maxlength="8" onKeyPress="return ControlUsr();" style="position:absolute; left:80px; outline-style:none; border-style:none;" />
            </div>
        </td>
        </tr>
        <tr>
        <td background="tarjetas/cont.png" style="background-repeat:no-repeat;">
            <div align="right" id="pswDiv" class="div-redondo" style="width:218px; height:22px; top:-5px; left:-2px; position:relative;">
                <input type="password" name="psw" id="psw" class="texteca" size="17" maxlength="8" onKeyPress="return ControlPsw();" onKeyDown="return ControlPswVol();" style="position:absolute; left:80px; outline-style:none; border-style:none;"/>
            </div>
        </td>
        </tr>
    
        </table>
    </td>
    </tr>
    </table>

</div>



	<?
	}
	?>


</body>
</html>
<?

mssql_query("commit transaction") or die("Error SQL commit");
?>

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