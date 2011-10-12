<?
require("config/cnx.php");
try {////////////////////////////////////////////////////////////////////////////////////////////////// COMIENZO TRY //
mssql_query("begin transaction",$conexion) or die("Error SQL begin trans");

set_time_limit(0);
?>
<script>
	jAlert('Creando TXT.', 'Debo Retail - Global Business Solution');
</script>
<?

//////////// BUSCO LOS DATOS
$var = $_POST["var"];

if($var == 1){
	$SQL_2 = "SELECT TOP 1 ID FROM ITOMINVC ORDER BY ID DESC";
	$ARTICULOS2 = mssql_query($SQL_2) or die("Error SQL");
	rollback($ARTICULOS2);		
	while ($RART2=mssql_fetch_array($ARTICULOS2)){
		$num_inv = $RART2['ID'];
	}
}
mssql_free_result($ARTICULOS2);

$_SESSION['ParSQL'] = "SELECT zon FROM aparemp";
$APAREMP = mssql_query($_SESSION['ParSQL']) or die("Error SQL");
rollback($APAREMP);
while ($RSEC=mssql_fetch_array($APAREMP)){
	$numEmp = $RSEC['zon'];
}
mssql_free_result($APAREMP);

$archivo = "Pdf/TomaInventario/Tom_Inv".$num_inv.".txt";


$SQL_1 = "SELECT * FROM ITOMINVC WHERE ID = $num_inv";
$ARTICULOS1 = mssql_query($SQL_1) or die("Error SQL");
rollback($ARTICULOS1);		
while ($RART1=mssql_fetch_array($ARTICULOS1)){
	$inv = $RART1['ID'];
	$detalle = $RART1['DET'];
	$dep = $RART1['DEP'];
	$rubmay = $RART1['DRM'];
	$rub = $RART1['DRU'];
	$numrub = $RART1['RUB'];
	$ope = $RART1['OPE'];
	$fet = $RART1['FET'];
}
mssql_free_result($ARTICULOS1);

$date1 = new DateTime($fet);
$fet = $date1->format('d-m-Y H:m:i');

if($dep == 1){
	$dep = "DEPOSITO";
}else{
	$dep = "VENTAS";
}	
$_SESSION['ParSQL'] = "SELECT * FROM ITOMINVD WHERE INV = $num_inv"; 
$R1TB = mssql_query($_SESSION['ParSQL']) or die("Error SQL");
rollback($R1TB);
while ($ATU=mssql_fetch_array($R1TB)){
$sec = $ATU['SEC'];
}
mssql_free_result($R1TB);

$_SESSION['ParSQL'] = "SELECT * FROM sectores WHERE id = $sec";
$R1TB = mssql_query($_SESSION['ParSQL']) or die("Error SQL");
rollback($R1TB);
while ($ATU=mssql_fetch_row($R1TB)){
$nomsec = $ATU[1];
}
mssql_free_result($R1TB);

$cabecera = '
Descripción:'.trim($detalle).'
Sector:	  '.trim($nomsec).'
Operario: '.trim($ope).'
R. Mayor: '.trim($rubmay).'
Tipo:	  '.trim($dep).'
Rubro:	  '.trim($rub).'
Tomado:	  '.trim($fet).'
';

$f = fopen($archivo,'a+');
fwrite($f,$cabecera." \r\n");
fclose($f);

$salto ="\r\n";


$titulo = $salto. ' CÓDIGO   | RURBO |                    DETALLES                     |  CÓDIGO DE BARRAS  |  EXISTENCIA ';
$titulo .= $salto.'------------------------------------------------------------------------------------------------------'.$salto;
	
$f = fopen($archivo,'a+');
fwrite($f,$titulo." \r\n");
fclose($f);

$_SESSION['ParSQL'] = "SELECT * FROM ITOMINVD WHERE INV = $num_inv ORDER BY INV DESC"; 
$R1TB = mssql_query($_SESSION['ParSQL']) or die("Error SQL");
rollback($R1TB);
$c = 0;

while ($ATU=mssql_fetch_row($R1TB)){

	$_SESSION1['ParSQL'] = "SELECT * FROM CODBAR WHERE CodSec = $sec AND CodArt= $ATU[2]"; 
	$R1TB1A = mssql_query($_SESSION1['ParSQL']) or die("Error SQL");
	rollback($R1TB1A);

	$codbar="";

	while ($ATU1=mssql_fetch_row($R1TB1A)){
		$codbar = $ATU1[2];
	}
	mssql_free_result($R1TB1A);
	
	$SEC = format($ATU[1],2,'0',STR_PAD_LEFT);
	$ART = format($ATU[2],4,'0',STR_PAD_LEFT);
	$RUB = $ATU[4];
	$DET = trim($ATU[5]);

$c++;


$lista = " ".$SEC.'-'.$ART."  | ".str_repeat(" ",4 - strlen($RUB)).$RUB."  |  ".$DET.str_repeat(" ",43 - strlen($DET))."    |    ".$codbar."   |  __________";

$f = fopen($archivo,'a+');
fwrite($f,$lista." \r\n");
fclose($f);
	
}

mssql_free_result($R1TB);



$cant = $salto.'
Cantidad de Articulos:'.$c.'
';

$f = fopen($archivo,'a+');
fwrite($f,$cant." \r\n");
fclose($f);


?>
<div id="imptxt" style="position:absolute; top:-750px; left:100px; width:600px; height:800px; display:block; color:#333; background-color:#FFF">
<?
/*
$fp = fopen($archivo,"r");
$leer = fread($fp, 900000);
echo $leer;
fclose($fp);
*/

$ar = file_get_contents($archivo); //Guardamos archivo.txt en $archivo
$ar = ucfirst($ar); //Le damos un poco de formato
$ar = nl2br($ar); //Transforma todos los saltos de linea en tag <br/>
echo "<strong>Archivo de texto archivo.txt:</strong> ";
echo $ar;

?>
<!--
<table width="640" height="16" cellpadding="0" border="0" cellspacing="0">
	  <tr>
		<td colspan="2">&nbsp;<b>Descripci&oacute;n:</b> '.$detalle.'</td>
	  </tr>
	  <tr>
		<td width="75">&nbsp;<b>Sector:</b> </td>
		<td width="245">&nbsp;<? echo $nomsec; ?></td>
		<td width="58">&nbsp;<b>Operario:</b> </td>
		<td width="206">&nbsp;<? echo $ope; ?></td>
	  </tr>
	  <tr>
		<td>&nbsp;<b>Rubro Mayor:</b> </td>
		<td>&nbsp;<? echo $rubmay; ?></td>
		<td>&nbsp;<b>Tipo:</b></td>
		<td>&nbsp;<? echo $dep; ?></td>
	  </tr>
	  <tr>
		<td>&nbsp;<b>Rubro:</b> </td>
		<td>&nbsp;<? echo $rub; ?></td>
		<td>&nbsp;<b>Tomado:</b></td>
		<td>&nbsp;<? echo $fet; ?></td>
	  </tr>		
</table>

<table width="640" border="0" cellpadding="0" cellspacing="0">
    <tr bordercolor="#999999" bgcolor="#999999">
        <td width="120" align="center">C&oacute;digo</td>
        <td width="50" align="center">Rubro</td>
        <td width="270" align="center">Detalles</td>
        <td width="101" align="center">C&oacute;digo de Barras</td>
        <td width="100" align="center">Existencia</td>
    </tr>
    <tr bordercolor="#999999">
        <td width="120" align="center">&nbsp;</td>
        <td width="50" align="center">&nbsp;</td>
        <td width="270" align="center">&nbsp;</td>
        <td width="101" align="center">&nbsp;</td>
        <td width="100" align="center">&nbsp;</td>
    </tr>
</table>

<table width="640" border="0" cellpadding="-10" cellspacing="0">
    <tr>
        <td width="120" align="center">'.$ATU[1].'-'.$ATU[2].'</td>
        <td width="50" align="center">'.$ATU[4].'</td>
        <td width="270" align="left">&nbsp;&nbsp;&nbsp;&nbsp;'.$ATU[5].'</td>
        <td width="85" align="right">'.$codbar.'&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</td>
        <td width="100" align="right">____________&nbsp;&nbsp;&nbsp;</td>
    </tr>
</table>

<table  width="640">
  <tr>
    <td width="473" border="0">&nbsp;</td>
    <td align="center" width="105" border="1" bgcolor="#999999" bordercolor="#666666">Cantidad de Articulos:</td>
    <td align="center" width="60" border="1" bordercolor="#666666"><? echo $c; ?> </td>
  </tr>
</table>

-->

<? 
/*
echo $cabecera."<br>";
echo $titulo."<br>";
echo $lista."<br>";
echo $cant."<br>";
*/

 ?>

</div>
<div id="ImprimirInv" style="position:absolute; top:-700px; left:465px; display:block; z-index:1;">

	<button  class="StyBoton" onclick="imprimirtxt();" onmouseout="MM_swapImgRestore()" onmouseover="MM_swapImage('BotImpInva','','botones/imp-over.png',0)"><img src="botones/imp-up.png" name="Generar" title="Imprimir" border="0" id="BotImpInva" /></button>

</div>

<script>
	$('#Bloquear').fadeOut(500);
	
	SoloBlock("imptxt");
	SoloNone("LetTer, fondotranspletras, TecladoLet, fondotranspnumeros, TecladoNum, CarAyuda, CarAyudaFon, fondocompleto");
	
	/*
	document.getElementById('LetSal').innerHTML = '<button class="StyBoton" onclick="ImpreVolTom();" onmouseout="MM_swapImgRestore()" onmouseover="MM_swapImage(\'LetVolfacCom\',\'\',\'botones/vol-over.png\',0)"><img src="botones/vol-up.png" name="Volver" title="Volver" border="0" id="LetVolfacCom"/></button>';
*/


</script>
<?


mssql_query("commit transaction") or die("Error SQL commit");

//set_time_limit(60);

}catch(Exception $e){////////////////////////////////////////////////////////////////////////////////////////////////// FIN DE TRY //
	?>
	<script>
		jAlert('ERROR Reintente la operacion solicitada.', 'Debo Retail - Global Business Solution');
	</script>
	<?

exit;
}