<?
require("config/cnx.php");

try {////////////////////////////////////////////////////////////////////////////////////////////////// COMIENZO TRY //

mssql_query("begin transaction",$conexion) or die("Error SQL begin trans");
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Recuento</title>
<style>
.det-rec{
	font-family: "TPro";
	font-size:12px;
	text-align:center;
	position:absolute;
	height:16px;
}
.lineaRec{
	background-image:url(Recuento/fon-lista.png);
	background-repeat:repeat-x;
	font-family: "TPro";
	font-weight:100;
	height:18px;
	width:455px;
	margin-top:1px;
}
</style>
<script>
function salir_rec(){
	
	Mos_Ocu('BotonesPri');
	Mos_Ocu('Recuento');
	Mos_Ocu('fondotranspletras');
	Mos_Ocu('TecladoLet');
	Mos_Ocu('fondotranspnumeros');
	Mos_Ocu('TecladoNum');
	Mos_Ocu('LetTer');
	Mos_Ocu('CarAyuda');
	Mos_Ocu('CarAyudaFon');
	
	SoloBlock("SobreFoca");
	
	document.getElementById('Recuento').innerHTML = '';
	
}

function movpag_a_rec(p){
	
	np = p - 1;
	document.getElementById("capa_rec"+np).style.display="block";
	document.getElementById("capa_rec"+p).style.display="none";
	
return false;
}

function movpag_b_rec(p){
	
	np = p + 1;	
	document.getElementById("capa_rec"+np).style.display="block";
	document.getElementById("capa_rec"+p).style.display="none";
	
return false;
}

function siguiente_rec(){
	
	var imp = document.getElementById("importe").value;
	document.getElementById("importe").value = dec(imp.replace(",","."));
	if(imp == 0){
		document.getElementById("importe").value = "";
		jAlert('Debe ingresar un importe correcto.', 'Debo Retail - Global Business Solution');
		controlrecuento = 0;
	}else{
	  jConfirm("¿Grabar este conteo?", "Debo Retail - Global Business Solution", function(r){
			if(r == true ){
				$("#archivos").load("RecAgr.php?imp="+imp+"");
				document.getElementById("importe").value = "";
			}
		});
	}
	
}

var controlrecuento = 0
function Controlimporte(){
	
	var k = window.event.keyCode;
	if(!((k == 46) || (k == 13) || ((k >= 48) && (k <= 57)))){
		return false;
	}
	if(k == 13){
		if(controlrecuento == 0){
			controlrecuento = 1;
			siguiente_rec();
		}
	}
	
}

function ControlimporteVol(){
	
	var k = window.event.keyCode;
	if(k == 27){
		salir_rec();
	}
	
}

$('#importe').focus();

</script>
</head>

<body>

<div id="ImgFondo" style=" height:298px; width:299px;"><img src="Recuento/recuento.png" width="498" height="292" /></div>

<?
$_SESSION['ParSQL'] = "
SELECT C.NplVen AS PLA, D.FAP AS FAP, A.MTN, A.DES, A.INI, A.FIN FROM ATURNOSH AS A 
INNER JOIN APARPOS AS B ON B.ID = '".$_SESSION['ParPOS']."'
INNER JOIN VENDEDORES AS C ON C.CodVen = B.OPE
INNER JOIN ATURNOSO AS D ON D.PLA = C.NplVen
WHERE A.MTN = D.MTN
";
	
$registros = mssql_query($_SESSION['ParSQL']) or die("Error SQL");
rollback($registros);		

if(mssql_num_rows($registros)==0){ exit; }

while ($reg=mssql_fetch_array($registros)){
	$PLA = $reg['PLA'];
}

$LUG = $_SESSION['ParLUG'];
$OPE = $_SESSION['idsusua'];
$OPENOM = $_SESSION['idsusun'];

$_SESSION['ParSQL'] = "SELECT CAR FROM ATurnoso WHERE PLA = ".$PLA."";		//SAQUE -->  WHERE LUG = ".$LUG." AND....
$RSBTABLA = mssql_query($_SESSION['ParSQL']) or die("Error SQL");
rollback($RSBTABLA);

while ($r1=mssql_fetch_array($RSBTABLA)){
	$CAR = $r1['CAR'];
}

// PARA LLENAR LA PANTALLA CON RECUENTOS EFECTUADOS.
$_SESSION['ParSQL'] = "SELECT FEC,HORA,IMP_0 FROM CONTEO_PLANILLA WHERE LUG=".$LUG." AND PLA = ".$PLA."";
$RSBTABLA = mssql_query($_SESSION['ParSQL']) or die("Error SQL");
rollback($RSBTABLA);

while ($r1=mssql_fetch_array($RSBTABLA)){
	$fec=$r1['FEC'];
	$Hora=$r1['HORA'];
	$imp=$r1['IMP_0'];
}

$_SESSION['ParSQL'] = "SELECT LUG FROM ALUGVTA WHERE ID=".$LUG."";
$registros = mssql_query($_SESSION['ParSQL']) or die("Error SQL");
rollback($registros);		
while ($reg=mssql_fetch_array($registros)){
	$LUGNOM = $reg['LUG'];
}

?>
<form method="post">

	<div class="det-rec" style="left:147px; top: 36px; width:98px;"><? echo $LUG;?> </div>
	<div class="det-rec" style="left:253px; top: 36px; width:233px;"><? echo $LUGNOM;?> </div>
	<div class="det-rec" style="left:147px; top: 59px; width:98px;"><? echo $PLA;?> </div>
	<div class="det-rec" style="left:391px; top: 59px; width:98px;"><? echo $CAR;?> </div>
	<div class="det-rec" style="left:147px; top: 82px; width:98px;"><? echo $OPE;?> </div>	
	<div class="det-rec" style="left:253px; top: 82px; width:233px;"><? echo $OPENOM;?> </div>	
	<div class="det-rec" style="left:268px; top: 111px; width:98px;">
		<input class="det-rec" type="text" id="hora" name="hora"  style="width:96px; border:0; height:14px; text-align:center; background-color:#DD7927;" value="<? echo date("H:i"); ?> "/>
	</div>
	<div class="det-rec" style="left:268px; top: 132px; width:96px;">
		<input class="det-rec" type="text" id="importe" name="importe" style="outline-style:none; border-style:none; width:96px; border:0; height:14px; text-align:center;" maxlength="8" onkeypress="return Controlimporte();" onkeydown="return ControlimporteVol();" />
	</div>
	
</form>	
	
<!-- MOSTRAR LA LISTA -->	

<div style="position:absolute; top:182px; left:6px;">
<?

// PARA LLENAR LA PANTALLA CON RECUENTOS EFECTUADOS.
$_SESSION['ParSQL'] = "SELECT FEC,HORA,IMP_0 FROM CONTEO_PLANILLA WHERE LUG=".$LUG." AND PLA = ".$PLA." ORDER BY FEC DESC";
$RSBTABLA = mssql_query($_SESSION['ParSQL']) or die("Error SQL");
rollback($RSBTABLA);

if(!mssql_num_rows($RSBTABLA) == 0){
	$total = mssql_num_rows($RSBTABLA);
}

$c = 0;
$cc = 0;
$s = 1;

while ($ATU=mssql_fetch_row($RSBTABLA)){

$fe = $ATU[0];
$date = new DateTime($fe);
$fe = $date->format('d-m-Y H:i');

	$c = $c + 1;
	$cc = $cc + 1;

	if ($c == 1){
	
		if($s == 1){
			$e = "block";
		}else{
			$e = "none";
		}
	
		echo "<div id=\"capa_rec".$s."\" style=\"display:".$e."\">";
		
		if($s <> 1){
			?>
			
			<div id="AnteriorRec" style=" position:absolute; top:-4px; left:451px;">
				<button class="StyBoton" onclick="return movpag_a_rec(<?php echo $s; ?>)" onMouseOut="MM_swapImgRestore()" onMouseOver="MM_swapImage('Anterior_Rto','','otros/scr_arri-over.png',0)"><img src="otros/scr_arri-up.png" border="0" id="Anterior_Rto"/></button>
			</div>
	
			<?
		}
	}
	
	?>
    <table  class="lineaRec" width="452" height="20" border="0" cellpadding="0" cellspacing="0">
    <tr>
        <td width="160" align="center"><? echo $fe; ?></td>
        <td width="132" align="center"><? echo $ATU['1']; ?></td>
        <td width="160" align="center"><? echo dec($ATU['2'],2); ?></td>
    </tr>
    </table>
	<?

	if ($c == 5){
	
		?>
	
		<div id="SiguienteRec" style="position:absolute; top:67px;  left:451px;">
			<button class="StyBoton" onclick="return movpag_b_rec(<?php echo $s; ?>)" onMouseOut="MM_swapImgRestore()" onMouseOver="MM_swapImage('Siguiente_Rto','','otros/scr_aba-over.png',0)"><img src="otros/scr_aba-up.png" border="0" id="Siguiente_Rto"/></button>		
		</div>
		
		</div>
		
		<?php
		  
		$c = 0;
		$s = $s + 1;
		
	}
}
if ($cc == 5){
	?>
	<script>
		$("#SiguienteRec").fadeOut('fast');
    </script>
	<?
}
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
		controlrecuento = 0;
	</script>
	<?
exit;

}

?>