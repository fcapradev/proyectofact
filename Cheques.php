<?
require("config/cnx.php");
// Fabian Vallejo // 15/08/2011 15:12


try {////////////////////////////////////////////////////////////////////////////////////////////////// COMIENZO TRY //


if(isset($_REQUEST['se'])){
	$se = $_REQUEST['se'];
}else{
	$se = "a";
}


mssql_query("begin transaction",$conexion) or die("Error SQL begin trans");
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Agregar Cheques</title>
<? 

	require("CargaCheques/cheques.php");

?>
<style>
#<? echo $se; ?>Cheques{
	position:absolute;
	width:358px;
	height:260px;
	left:213px;
	top:10px;
	font: Gautami;
	font-weight:bold;
	color:#FFFFFF;
	font-size:12px;
	z-index:1;
}

#<? echo $se; ?>ChequesDetalles{
	position:absolute;
	width:357px; 
	height:269px;
	left:213px; 
	top:10px;
	font: Gautami; 
	font-weight:bold; 
	color:#FFFFFF; 
	font-size:12px; 
	z-index:2;
}

.fuente-che{
	font-family: "TPro";
	font-size:12px;
	position:absolute;
	height:16px;
}

.fon-che{
	font-family: "TPro";
	font-size:10px;
	position:absolute;
	height:10px;

}
</style>
</head>
<body>

<div id="<? echo $se; ?>Cheques"><img src="CargaCheques/banco.png" /></div>

<div id="<? echo $se; ?>ChequesDetalles">

	<?
	//PRIMERO BUSCAR LOS DATOS DEL TURNO para el encabezado.
	//conteos cargados
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
	?>
    
<form method="post" action="CheCar.php" id="<? echo $se; ?>formcheque" name="<? echo $se; ?>formcheque">

<input type="hidden" id="<? echo $se; ?>PorFacCheques" name="<? echo $se; ?>PorFacCheques" value="<? echo $se; ?>" />

		<div class="fuente-che" id="<? echo $se; ?>ope" style="position:absolute; top:42px; left:36px; height:13px;"><? echo $OPE; ?></div>
		
        <div class="fuente-che" id="<? echo $se; ?>nom" style="position:absolute; top:42px; left:88px; height:13px;"><? echo $NOM; ?></div>		
		
        <div class="fuente-che" id="<? echo $se; ?>pla" style="position:absolute; width:49px; top:65px; left:85px; height:13px;" align="center"><? echo $PLA;?></div>
        
		<div class="div-redondo" id="<? echo $se; ?>ban" style="position:absolute; top:101px; left:144px; width:31px;" align="center">
			<input class="fuente-che" type="text" id="<? echo $se; ?>banco" name="<? echo $se; ?>banco" style="outline-style:none; border-style:none; width:30px;  height:13px; border:0px; text-align:center;  background-color:transparent;" maxlength="3" onkeypress="return Control<? echo $se; ?>banco();" />
		</div>
		
        <div style="position:absolute; top:104px; left:188px; width: 150px;">
        <input type="hidden" name="<? echo $se; ?>idtipoban" id="<? echo $se; ?>idtipoban">
        
        <input type="text" name="<? echo $se; ?>tipoban" readonly="readonly" id="<? echo $se; ?>tipoban" onclick="<? echo $se; ?>buscabanco();" style=" background-color:#DD7927; font-family: 'TPro'; font-size:12px; cursor:pointer; width:150px; height:13px; border:0; text-align:center;" value="&lt;&nbsp;ELEGIR UN BANCO&nbsp;&gt;">
        </div>

        <div id="<? echo $se; ?>fondodescban" style=" top:-7px; left:-199px; position:absolute; width:683px; height:479px; z-index:1; display:none;"></div>
        
        <div id="<? echo $se; ?>fondodescbanimg" style="position:absolute; top:1px; left:12px; display:none; z-index:2;">
            <img src="CargaGastos/fon-der.png" />
        </div>
        
        <div id="<? echo $se; ?>descpidetipoban" class="fon-gas" style="position:absolute; top:1px; left:12px; display:none; z-index:2;"></div>
		
		<div id="<? echo $se; ?>numche" class="div-redondo" style="position:absolute; top:124px; left:144px; width:101px;" align="center">
			<input class="fuente-che" type="text" id="<? echo $se; ?>numcheque" name="<? echo $se; ?>numcheque" style="outline-style:none; border-style:none; width:96px; height:14px; border:0px;text-align:center; background-color:transparent;" maxlength="8" onkeypress="return Control<? echo $se; ?>numcheque();" onkeydown="return Control<? echo $se; ?>numchequeVol();" />
		</div>
        
		<div id="<? echo $se; ?>nomlib" class="div-redondo" style="position:absolute; top:146px; left:142px; width:200px;" align="center">
			<input class="fuente-che" type="text" id="<? echo $se; ?>nomlibra" name="<? echo $se; ?>nomlibra" style="outline-style:none; border-style:none; width:190px; height:14px; left:2px; position:absolute; border:0px; background-color:transparent; text-transform:uppercase;" maxlength="21" onkeypress="return Control<? echo $se; ?>nomlibra();" onkeydown="return Control<? echo $se; ?>nomlibraVol();" />
		</div>
        
		<div id="<? echo $se; ?>lug" class="div-redondo" style="position:absolute; top:169px; left:144px; height:13px; width:31px;" align="center">
			<input class="fuente-che" type="text" id="<? echo $se; ?>lugar" name="<? echo $se; ?>lugar" style="outline-style:none; border-style:none; width:25px; height:14px; border:0px; text-align:center; background-color:transparent;" maxlength="3" onkeypress="return Control<? echo $se; ?>lugar();" onkeydown="return Control<? echo $se; ?>lugarVol();" />
		</div>

        <div style="position:absolute; top:171px; left:188px; width: 150px;">
        <input type="hidden" name="<? echo $se; ?>idtipopro" id="<? echo $se; ?>idtipopro">
        
        <input type="text" name="<? echo $se; ?>tipopro" readonly="readonly" id="<? echo $se; ?>tipopro" onclick="<? echo $se; ?>buscaprovincia();" style=" background-color:#DD7927; font-family: 'TPro'; font-size:12px; cursor:pointer; width:150px; height:13px; border:0; text-align:center;" value="&lt;&nbsp;ELEGIR UNA PROVINCIA&nbsp;&gt;">
        </div>

        <div id="<? echo $se; ?>fondodescpro" style=" top:-7px; left:-199px; position:absolute; width:683px; height:479px; z-index:1; display:none;"></div>
        
        <div id="<? echo $se; ?>fondodescproimg" style="position:absolute; top:1px; left:12px; display:none; z-index:2;">
        	<img src="CargaGastos/fon-der.png" />
        </div>
        
        <div id="<? echo $se; ?>descpidetipopro" class="fon-gas" style="position:absolute; top:1px; left:12px; display:none; z-index:2;"></div>

		<div id="<? echo $se; ?>imp" class="div-redondo" style="position:absolute; top:192px; left:144px; width:101px;">
			<input class="div-redondo" type="text" id="<? echo $se; ?>importeChe" name="<? echo $se; ?>importeChe" style="outline-style:none; border-style:none; width:96px;  height:13px; border:0px; text-align:right; background-color:transparent;" maxlength="10" onkeypress="return Control<? echo $se; ?>importeChe();" onkeydown="return Control<? echo $se; ?>importeCheVol();" />
		</div>

		<div id="<? echo $se; ?>fecemi" class="div-redondo" style="position:absolute; top:215px; left:144px; width:101px;">
			<input class="fuente-che" type="text" id="<? echo $se; ?>fecemision" name="<? echo $se; ?>fecemision" style="outline-style:none; border-style:none; width:96px; height:14px; border:0px;text-align:center; background-color:transparent;" maxlength="10" onkeypress="return Control<? echo $se; ?>fecemision();" onkeydown="return Control<? echo $se; ?>fecemisionVol();" />
		</div>
        
		<div class="fuente-che" style="position:absolute; top:218px; left:255px; z-index:3; color:#CCCCCC;">DD / MM / AAAA</div>
        
		<div id="<? echo $se; ?>fechapre" class="div-redondo" style="position:absolute; top:239px; left:144px; width:101px;" >
			<input class="fuente-che" type="text" id="<? echo $se; ?>fecpresenta" name="<? echo $se; ?>fecpresenta" style="outline-style:none; border-style:none; width:96px; height:14px; border:0px;text-align:center; background-color:transparent;" maxlength="10" onkeypress="return Control<? echo $se; ?>fecpresenta();" onkeydown="return Control<? echo $se; ?>fecpresentaVol();" />
		</div>
        
		<div class="fuente-che" style="position:absolute; top:241px; left:255px; height:13px; z-index:3; color:#CCCCCC;"> DD / MM / AAAA</div>
        
</form>	
</div>

</body>
</html>
<?


mssql_query("commit transaction") or die("Error SQL commit");


?>
<script>

	EnvAyuda("Ingrese el n&uacute;mero del Banco o Enter para listar.");
	
	document.getElementById("DondeE").value = "<? echo $se; ?>banco";
	document.getElementById("CantiE").value = "3";
	document.getElementById("QuePoE").value = "6";
	
	SoloBlock("LetEnt");
	
	document.getElementById("LetEnt").innerHTML = '<button class="StyBoton" onclick="<? echo $se; ?>siguiente_che();" onmouseout="MM_swapImgRestore()" onmouseover="MM_swapImage(\'<? echo $se; ?>LetEntChe\',\'\',\'botones/ent-over.png\',0)"><img src="botones/ent-up.png" name="Enter" title="Enter" border="0" id="<? echo $se; ?>LetEntChe"/></button>';
	
	document.getElementById("NumVol").innerHTML = '';	
	document.getElementById("LetTer").innerHTML = '';
	
	$("#<? echo $se; ?>ban").css("border-color", "#0FF");
	
	$('#<? echo $se; ?>tipopro').removeAttr('onclick');

	$('#<? echo $se; ?>banco').focus();


	var chefacimp = "<? echo $se; ?>";
	if(chefacimp == "b"){
		document.getElementById("<? echo $se; ?>importeChe").value = document.getElementById("total").value;
	}
	if(chefacimp == "c"){
		document.getElementById("<? echo $se; ?>importeChe").value = document.getElementById("Matotal").value;
	}
	if(chefacimp == "d"){

		document.getElementById("<? echo $se; ?>importeChe").value = document.getElementById("APagar").value;

		SoloBlock("NumVol");
	
		document.getElementById('NumVol').innerHTML = '<button class="StyBoton" onclick="Vol_Fpa();" onmouseout="MM_swapImgRestore()" onmouseover="MM_swapImage(\'LetNumVolTarj\',\'\',\'botones/vol-over.png\',0)"><img src="botones/vol-up.png" name="Volver" title="Volver" border="0" id="LetNumVolTarj"/></button>';
		
	}
	if(chefacimp == "e"){

		document.getElementById("<? echo $se; ?>importeChe").value = document.getElementById("MaAPagar").value;
		
		SoloBlock("NumVol");

		document.getElementById('NumVol').innerHTML = '<button class="StyBoton" onclick="MaVol_Fpa();" onmouseout="MM_swapImgRestore()" onmouseover="MM_swapImage(\'LetNumVolTarj\',\'\',\'botones/vol-over.png\',0)"><img src="botones/vol-up.png" name="Volver" title="Volver" border="0" id="LetNumVolTarj"/></button>';
		
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