<?php
session_start();

if(isset($_POST['ParaVolBot'])){

	if($_POST['ParaVolBot'] == 1){

		$_SESSION['ParFacSec'] = 1;
	
	}
	if($_POST['ParaVolBot'] == 2){

		$_SESSION['ParFacSec'] = 2;
		
	}

}else{
	$_SESSION['ParFacSec'] = 0;
}


/*
session_start();

if(isset($_POST['ParaVolBot'])){

?>
<script>

	alert("<? echo $_POST['ParaVolBot']; ?>");

</script>

<?

	if($_POST['ParaVolBot'] == 1){

		$_SESSION['ParFacSec'] = 1;
		
		$letsal = $_SESSION['ParFacBotSal1'];
		$letent = $_SESSION['ParFacBotEnt2'];
		$letter = $_SESSION['ParFacBotTer3'];
		$letvol = $_SESSION['ParFacBotVol4'];
		
//////////////////////////////////////////////////////////////////////////////
		$_SESSION['ParFacBotSal1'] = $_POST['ParaVolBotSal'];//////////////////
		$_SESSION['ParFacBotEnt2'] = $_POST['ParaVolBotEnt'];//////////////////
		$_SESSION['ParFacBotTer3'] = $_POST['ParaVolBotTer'];//////////////////
		$_SESSION['ParFacBotVol4'] = $_POST['ParaVolBotVol'];//////////////////
//////////////////////////////////////////////////////////////////////////////
		
	}
	if($_POST['ParaVolBot'] == 2){

		$_SESSION['ParFacSec'] = 2;
		
		$letsal = $_SESSION['ParFacBotSalMa'];
		$letent = $_SESSION['ParFacBotEntMa'];
		$letter = $_SESSION['ParFacBotTerMa'];
		$letvol = $_SESSION['ParFacBotVolMa'];
		
////////////////////////////////////////////////////////////////////////////////
		$_SESSION['ParFacBotSalMa'] = $_POST['ParaVolBotSal'];//////////////////
		$_SESSION['ParFacBotEntMa'] = $_POST['ParaVolBotEnt'];//////////////////
		$_SESSION['ParFacBotTerMa'] = $_POST['ParaVolBotTer'];//////////////////
		$_SESSION['ParFacBotVolMa'] = $_POST['ParaVolBotVol'];//////////////////
////////////////////////////////////////////////////////////////////////////////

	}

?>
<script>

alert("<? echo $letsal; ?>");
alert("<? echo $letent; ?>");
alert("<? echo $letter; ?>");
alert("<? echo $letvol; ?>");

	document.getElementById('LetSal').innerHTML = '<button class="StyBoton" onclick="<? echo $letsal; ?>" onmouseout="MM_swapImgRestore()" onmouseover="MM_swapImage(\'LSal\',\'\',\'botones/sal-over.png\',0)"><img src="botones/sal-up.png" name="Salir" title="Salir" border="0" id="LSal"/></button>';
				
	document.getElementById('LetEnt').innerHTML = '<button class="StyBoton" onclick="<? echo $letent; ?>" onmouseout="MM_swapImgRestore()" onmouseover="MM_swapImage(\'LEnt\',\'\',\'botones/ent-over.png\',0)"><img src="botones/ent-up.png" name="Enter" title="Enter" border="0" id="LEnt"/></button>';
		
	document.getElementById('LetTer').innerHTML = '<button class="StyBoton" onclick="<? echo $letter; ?>" onmouseout="MM_swapImgRestore()" onmouseover="MM_swapImage(\'LTer\',\'\',\'botones/ter-over.png\',0)"><img src="botones/ter-up.png" name="Terminar" title="Terminar" border="0" id="LTer"/></button>';
		
	document.getElementById('NumVol').innerHTML = '<button class="StyBoton" onclick="<? echo $letvol; ?>" onmouseout="MM_swapImgRestore()" onmouseover="MM_swapImage(\'LVol\',\'\',\'botones/ent-over.png\',0)"><img src="botones/ent-up.png" name="Volver" title="Volver" border="0" id="LVol"/></button>';
	
</script>
<?

}else{
	$_SESSION['ParFacSec'] = 0;
	$_SESSION['ParFacBot'] = "";
}

?>
<script>
	$('#Bloquear').fadeOut(500);
</script>
*/
?>
<script>
	$('#Bloquear').fadeOut(500);
</script>