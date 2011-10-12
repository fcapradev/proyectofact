<?
require("config/cnx.php");


try {////////////////////////////////////////////////////////////////////////////////////////////////// COMIENZO TRY //


mssql_query("begin transaction",$conexion) or die("Error SQL begin trans");

if(isset($_REQUEST['idsup'])){

	$sup = $_REQUEST['idsup'];

	$_SESSION['ParSQL'] = "SELECT * FROM VENDEDORES WHERE ESENC = 1 and CodVen = ".$sup.""; 
	$R1TB = mssql_query($_SESSION['ParSQL']) or die("Error SQL");
	rollback($R1TB);
	if(mssql_num_rows($R1TB) == 0){	
		?>
		<script>
			jAlert('El Supervisor Ingresado no existe.', 'Debo Retail - Global Business Solution');
			
			document.getElementById('sup').value = "";
//			document.getElementById('supenom').value = "< ELEGIR UN SUPERVISOR >";
			
			controlarcadainput('sup');
			document.getElementById("DondeE").value = "sup";
			document.getElementById("CantiE").value = "4";
			document.getElementById("QuePoE").value = "1";
			
			EnvAyuda("Ingrese un n&uacute;mero de Supervisor o Enter para Listar.");
			
			document.getElementById('NumVolPADiv').innerHTML = '<button onclick="siguiente_arq1();" class="StyBoton" onmouseout="MM_swapImgRestore()" onmouseover="MM_swapImage(\'LetEntArqSup2\',\'\',\'botones/ent-over.png\',0)"><img src="botones/ent-up.png" name="Enter" title="Enter" border="0" id="LetEntArqSup2"/></button>';
		</script>    
		<?
		exit;
	}

	while ($reg=mssql_fetch_array($R1TB)){
	
		$NOMBRE = $reg['NomVen'];
		$ID = $reg['CodVen'];

	}
	?>
    <script>
		document.getElementById('supenom').value = "<? echo trim($NOMBRE); ?>";
		
		$("#efectivo").css("border-color", "#F90");
		$("#supnum").css("border-color", "transparent");
		
		SoloBlock("gastosf, chequesf, anticipof, tarjetasf, cargasf, retirof, gascon01");
		document.getElementById("monedas").style.display = "block";
				
		EnvAyuda("Ingrese el efectivo.");
		controlarcadainput('efe');
	
		document.getElementById("DondeE").value = "efe";
		document.getElementById("CantiE").value = "8";
		document.getElementById("QuePoE").value = "1";

		document.getElementById('NumVolPADiv').innerHTML = '<button onclick="siguiente_arq2();" class="StyBoton" onmouseout="MM_swapImgRestore()" onmouseover="MM_swapImage(\'LetEntArq6\',\'\',\'botones/ent-over.png\',0)"><img src="botones/ent-up.png" name="Enter" title="Enter" border="0" id="LetEntArq6"/></button>';

	</script>
	<?
}else{
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Selecciona el Operario</title>
<style>
#Anterior_SigO{
position:absolute;
top:30px;
left:430px;
}
#Siguiente_SigO{
position:absolute;
top:230px;
left:430px;
}

</style>
<script language="javascript" type="text/javascript">

function movpag_a_arqsel(p){
	
	np = p - 1;
	document.getElementById("capa_arqsel"+np).style.display="block";
	document.getElementById("capa_arqsel"+p).style.display="none";

return false;
}

function movpag_b_arqsel(p){

	np = p + 1;	
	document.getElementById("capa_arqsel"+np).style.display="block";
	document.getElementById("capa_arqsel"+p).style.display="none";
	
return false;
}

function envia_tip(id,des){

	document.getElementById('sup').value = id;
	document.getElementById('supenom').value = des;

	SoloNone("fondosuper, descpidesupe, fondogeneralsupe");

	SoloBlock("gastosf, chequesf, anticipof, tarjetasf, cargasf, retirof, gascon01");

	var cant =	document.getElementById("cant").value;
	document.getElementById("monedas").style.display = "block";

	$("#efectivo").css("border-color", "#F90");
	$("#supnum").css("border-color", "transparent");
	
	EnvAyuda("Ingrese el efectivo");

	controlarcadainput('efe');
	document.getElementById("DondeE").value = "efe";
	document.getElementById("CantiE").value = "8";
	document.getElementById("QuePoE").value = "1";
	document.getElementById("cruzope").style.display = "none";
	
	document.getElementById('NumVolPADiv').innerHTML = '<button onclick="siguiente_arq2();" class="StyBoton" onmouseout="MM_swapImgRestore()" onmouseover="MM_swapImage(\'LetEntArq6\',\'\',\'botones/ent-over.png\',0)"><img src="botones/ent-up.png" name="Enter" title="Enter" border="0" id="LetEntArq6"/></button>';

}

</script>

</head>
<body>
<div id="detalletipos" style="position:absolute; top:40px; left:-146px;">

<table width="450" border="0" cellpadding="0" cellspacing="0">
<tr>
<td valign="middle">
	<table>
	<tr>
		<td width="100">
			<div align="center">
				<img src="ArqueoCaja/operario supervisor.png" /> 
			</div>
		</td>
		<td>
			<div style="font: 'TPro'; font-size:16px; color:#FFFFFF; font-weight:bold;">
				
			</div>
		</td>
	</tr>
	</table>
</td>

<td>

	<table align="right" border="0" cellpadding="0" cellspacing="0">
	<tr>
	<td>
	</td>
	</tr>
	</table>

</td>
</tr>
</table>

<form action="" name="monedas" id="monedas" method="post">
	
<?php
$_SESSION['ParSQL'] = "SELECT * FROM CPARBON";
$CAMBREC = mssql_query($_SESSION['ParSQL']) or die("Error SQL");
rollback($CAMBREC);		
$num_rows = mssql_num_rows($CAMBREC);

?>
<input type="hidden" name="cant" value="<? echo $num_rows;?>" id="cant" />
</form>
<?

$SQL = "SELECT * FROM VENDEDORES WHERE ESENC = 1";
$PARATIPOS = mssql_query($SQL) or die("Error SQL");
rollback($PARATIPOS);
if(mssql_num_rows($PARATIPOS) == 0){	
	?>
	<script>
		alert("No hay operarios en este momento.");
	</script>    
	<?
	exit;
}

$c = 0;
$cc = 0;
$s = 1;

while ($reg=mssql_fetch_array($PARATIPOS)){

$NOMVEN = $reg['NomVen'];
$CODVEN = $reg['CodVen'];

if($CODVEN == -1){ $CODVEN = 0; }


	$c = $c + 1;
	$cc = $cc + 1;
	
	if ($c == 1){

		if($s == 1){
			$e = "block";
		}else{
			$e = "none";
		}

		echo "<div id=\"capa_arqsel".$s."\" style=\"display:".$e."\">";
		
		if($s <> 1){
			?>
        
    	    <div id="Anterior_SigO">
			
			<button class="StyBoton" onClick="return movpag_a_arqsel(<?php echo $s; ?>)" onMouseOut="MM_swapImgRestore()" onMouseOver="MM_swapImage('Anterior_Sig<?php echo $s; ?>','','otros/scr_arri-over.png',0)"><img src="otros/scr_arri-up.png" border="0" id="Anterior_Sig<?php echo $s; ?>"/></button>
			
			</div>

			<?

		}

	}
	?>
                
    <div style="cursor:pointer;" onClick="envia_tip(<? echo $CODVEN; ?>,'<? echo trim($NOMVEN); ?>');">

	<table width="435px" cellpadding="0" cellspacing="1">
        <tr> 
            <td class="fon_itm" width="45"><div align="center"><? echo $CODVEN; ?></div></td>	
			<td class="fon_itm" width="390">&nbsp;&nbsp;&nbsp;<? echo $NOMVEN; ?></td>
        </tr>
	</table>  
    </div>
	
	<?

	if ($c == 8){

		?>
		
        <div id="Siguiente_SigO">
		
        <button class="StyBoton" onClick="return  movpag_b_arqsel(<?php echo $s; ?>)" onMouseOut="MM_swapImgRestore()" onMouseOver="MM_swapImage('Siguiente_Sig<?php echo $s; ?>','','otros/scr_aba-over.png',0)"><img src="otros/scr_aba-up.png" border="0" id="Siguiente_Sig<?php echo $s; ?>"/></button>
		
        </div>
        
        </div>
        
		<?php
    	  
		$c = 0; 
        $s = $s + 1;  
		
	}

}


if ($cc == 8){
	?>
	<script>
		$("#Siguiente_Sig").fadeOut('fast');
    </script>
	<?
}


?>

</div>

</body>
</html>
<?

}

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