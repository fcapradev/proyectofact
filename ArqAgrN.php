<?
require("config/cnx.php");

try {////////////////////////////////////////////////////////////////////////////////////////////////// COMIENZO TRY //

mssql_query("begin transaction",$conexion) or die("Error SQL begin trans");


if(isset($_POST['tot'])){

	$TOT = $_POST['tot'];
	$SUP = $_POST['sup'];
	$EFE = $_POST['efe'];
	$GAS = $_POST['gas'];
	$CHE = $_POST['che'];
	$ANT = $_POST['ant'];
	$TAR = $_POST['tar'];
	$CAR = $_POST['car'];
	$RET = $_POST['ret'];
	$GASCON = $_POST['gascon02'];
	
	$ban01 = 0;
	if(isset($_POST['m1'])){
		$ban01 = 1;
		$BO1 = $_POST['m1'];
		$BO1D = $_POST['mon1'];
	}else{
		$BO1 = dec(0,2);
		$BO1D = "";
	}

	
	$ban02 = 0;
	if(isset($_POST['m2'])){
		$ban02 = 1;
		$BO2 = $_POST['m2'];
		$BO2D = $_POST['mon2'];
	}else{
		$BO2 = dec(0,2);
		$BO2D = "";
	}

	
	$ban03 = 3;
	if(isset($_POST['m3'])){
		$ban03 = 1;
		$BO3 = $_POST['m3'];
		$BO3D = $_POST['mon3'];
	}else{
		$BO3 = dec(0,2);
		$BO3D = "";
	}

	
	$ban04 = 0;
	if(isset($_POST['m4'])){
		$ban04 = 1;
		$BO4 = $_POST['m4'];
		$BO4D = $_POST['mon4'];
	}else{
		$BO4 = dec(0,2);
		$BO4D = "";
	}


    $ban05 = 0;
	if(isset($_POST['m5'])){
		$ban05 = 1;
		$BO5 = $_POST['m5'];
		$BO5D = $_POST['mon5'];
	}else{
		$BO5 = dec(0,2);
		$BO5D = "";
	}
	
	$CBE = $_POST['cbe'];	
	
	$ban = 1;
}else{
	exit;
}
/*
echo "<br>".$TOT;
echo "<br>".$SUP;
echo "<br>".$EFE;
echo "<br>".$GAS;
echo "<br>".$CHE;
echo "<br>".$ANT;
echo "<br>".$TAR;
echo "<br>".$CAR;
echo "<br>".$RET;
echo "<br>".$BO1;
echo "<br>".$BO2;
echo "<br>".$BO3;
echo "<br>".$BO4;
echo "<br>".$BO5;
echo "<br>".$CBE;
*/


?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Imprimir Arqueo</title>

<script>

$(document).ready(function(){
	$('#arqueoimp').submit(function(){
        $.ajax({
            type: 'POST',
            url: $(this).attr('action'),
            data: $(this).serialize(),
            success: function(data){
            $('#archivos').html(data);
            }
        })
        return false;
    });
})
</script>



</head>
<?
$_SESSION['ParSQL'] = "
SELECT C.NplVen AS PLA FROM ATURNOSH AS A 
INNER JOIN APARPOS AS B ON B.ID = '".$_SESSION['ParPOS']."'
INNER JOIN VENDEDORES AS C ON C.CodVen = B.OPE
INNER JOIN ATURNOSO AS D ON D.PLA = C.NplVen
WHERE A.MTN = D.MTN
";

$registros = mssql_query($_SESSION['ParSQL']) or die("Error SQL");
rollback($registros);		

while ($reg=mssql_fetch_array($registros)){

	$PLA = $reg['PLA'];
	
}
$LUG = $_SESSION['ParLUG'];
$OPE = $_SESSION['idsusua'];
$ParPV = $_SESSION['ParPV'];

//graba e imprime
if($ban == 1){

   	$SaldoR = 0;
   //''todo lo que es facturacion que no sean de cuentas corrientes.
	$_SESSION['ParSQL'] = "Select sum(tot) as TOT from amaefact where anu<>'a' and not tco in('nc','ni') and fpa<>2 and pla = ".$PLA."";
	$SALDO = mssql_query($_SESSION['ParSQL']) or die("Error SQL");
	rollback($SALDO);		
	while ($RSAL=mssql_fetch_array($SALDO)){
		$SaldoR1 = $RSAL['TOT'];
	}		 
  
 //''todo lo que es creditos que no sean de cuentas corrientes.
     $_SESSION['ParSQL'] = "Select sum(tot) as TOT from amaefact where anu<>'a' and tco in('nc','ni') and fpa<>2 and pla = ".$PLA."";
	$SALDO = mssql_query($_SESSION['ParSQL']) or die("Error SQL");
	rollback($SALDO);		
	while ($RSAL=mssql_fetch_array($SALDO)){
		$SaldoR = $SaldoR1 - $RSAL['TOT'];
	}		 

   $Saldo_A_Rendir = $SaldoR;
   $Saldo_Rendido = $TOT + $GASCON;
   $Diferencia = $Saldo_A_Rendir - $Saldo_Rendido;
   
   
   $FechaArqueo = date("d/m/Y H:i");  //formato dd/mm/yyyyy HH:MM
	//la fecha no se llena por que la tabla la llena automaticamente
	$_SESSION['ParSQL'] = "INSERT INTO PLANILLA_ARQUEO (PLA,LUG,OPE_S,OPE_R,S_CA,S_RE,DIF,DR1,DR2,DR3,DR4,DR5,DR6,DR7,DR8,DR9,DR10,DR11)
				VALUES (".$PLA.", ".$LUG.", ".$OPE.", ".$SUP.", ".str_replace(",","",$Saldo_A_Rendir).", ".str_replace(",","",$Saldo_Rendido).", ".str_replace(",","",$Diferencia).", ".str_replace(",","",$EFE).",".str_replace(",","",$GAS).",".str_replace(",","",$CHE).",".str_replace(",","",$ANT).",".str_replace(",","",$TAR)." ,".str_replace(",","",$CAR)." ,".str_replace(",","",$RET)." ,".str_replace(",","",$BO1)." ,".str_replace(",","",$BO2)." ,".str_replace(",","",$BO3).",".str_replace(",","",$BO4)." )";
	$ARQUEO = mssql_query($_SESSION['ParSQL']) or die("Error SQL");
	rollback($ARQUEO);	

	?>
	<script>
		//jAlert('Arqueo Finalizado Correctamente.', 'Debo Retail - Global Business Solution');
	</script>
	<?

	$numArqueo = 0;
	$_SESSION['ParSQL'] = "SELECT COUNT(PLA) AS TOT FROM planilla_arqueo where pla = ".$PLA." and lug=".$LUG."";
	$ARQUEO = mssql_query($_SESSION['ParSQL']) or die("Error SQL");
	rollback($ARQUEO);	
	while ($RARQ=mssql_fetch_array($ARQUEO)){
		$numArqueo =  $RARQ['TOT'];
	}		
  
    $Impresion_Arqueo = false;
  
	$_SESSION['ParSQL'] = "SELECT imp_arq FROM APARSIS";
	$APARSIS = mssql_query($_SESSION['ParSQL']) or die("Error SQL");
	rollback($APARSIS);	
	while ($RPAR=mssql_fetch_array($APARSIS)){
		$Impresion_Arqueo =  $RPAR['imp_arq'];
	}		  
	
	$efe = dec($EFE, 2);
	if($Impresion_Arqueo == 1){

/////LLENO LOS DATOS PARA LA IMPRESION EN CONTROLADOR FISCAL/////
   $Imp_Linea[0] = "----ARQUEO DE CAJA  N° ".$numArqueo."-----";
   $Imp_Linea[1] = "PLANILLA N : ".$PLA;
   $Imp_Linea[2] = "SUPERVISOR : ".$SUP;
   $Imp_Linea[3] = "OPERARIO : ".$OPE;
   $Imp_Linea[4] = "FECHA : " . $FechaArqueo;
   $Imp_Linea[5] = "----------------------------------------";
   $Imp_Linea[6] = ".".str_repeat(" ",24 - strlen("TOTAL A RENDIR : "))."TOTAL A RENDIR : ".dec($Saldo_A_Rendir, 2);
   $Imp_Linea[7] = ".".str_repeat(" ",24 - strlen("TOTAL RENDIDO : "))."TOTAL RENDIDO : ".dec($Saldo_Rendido,2);
   $Imp_Linea[8] = ".".str_repeat(" ",24 - strlen("DIFERENCIA : "))."DIFERENCIA : ".dec($Diferencia * -1, 2);
   $Imp_Linea[9] = "-----------------DETALLE----------------";
   $Nli=9;
	if($EFE !== 0){ 
		$Nli = $Nli + 1;
		$Imp_Linea[10] = "." . str_repeat(" ",24 - strlen("EFECTIVO : "))."EFECTIVO : ".dec($EFE, 2);
	}
	if($GAS !== 0){ 
		$Nli = $Nli + 1;
		$Imp_Linea[11] = ".".str_repeat(" ",24 - strlen("GASTOS : "))."GASTOS : ".dec(str_replace(",","",$GAS), 2);
	}
	if($CHE !== 0){ 
		$Nli = $Nli + 1;
		$Imp_Linea[12] = ".".str_repeat(" ",24 - strlen("CHEQUES : "))."CHEQUES : ".dec($CHE, 2);
	}
	if($ANT !== 0){ 
		$Nli = $Nli + 1;
		$Imp_Linea[13] = ".".str_repeat(" ",24 - strlen("ANTICIPOS : "))."ANTICIPOS : ".dec($ANT, 2);
	}
	if($TAR !== 0){ 
		$Nli = $Nli + 1;
		$Imp_Linea[14] = ".".str_repeat(" ",24 - strlen("TARJETAS : "))."TARJETAS : ".dec($TAR, 2);
	}
	if($CAR !== 0){ 
		$Nli = $Nli + 1;
		$Imp_Linea[15] = ".".str_repeat(" ",24 - strlen("CAMBIO RECIBIDO : "))."CAMBIO RECIBIDO : ".dec($CAR, 2);
	}
	if($RET !== 0){ 
		$Nli = $Nli + 1;
		$Imp_Linea[16] = ".".str_repeat(" ",24 - strlen("RETIRO EFECTIVO : "))."RETIRO EFECTIVO : ".dec($RET, 2);
	}

	if($ban01 == 1){ 
		$Nli = $Nli + 1;
		$Imp_Linea[17] = ".".str_repeat(" ",23 - strlen("BON1 : ")).$BO1D." : ".dec($BO1, 2);
	}else{
		$Imp_Linea[17] = ""; 
	}


	if($ban02 == 1){ 
		$Nli = $Nli + 1;
		$Imp_Linea[18] = ".".str_repeat(" ",23 - strlen("BON2 : ")).$BO2D." : ".dec($BO2, 2);
	}else{
		$Imp_Linea[18] = ""; 
	}


	if($ban03 == 1){ 
		$Nli = $Nli + 1;
		$Imp_Linea[19] = ".".str_repeat(" ",23 - strlen("BON3 : ")).$BO3D." : ".dec($BO3, 2);
	}else{
		$Imp_Linea[19] = ""; 
	}

	if($ban04 == 1){ 
		$Nli = $Nli + 1;
		$Imp_Linea[20] = ".".str_repeat(" ",23 - strlen("BON4 : ")).$BO4D." : ".dec($BO4, 2);
	}else{
		$Imp_Linea[20] = ""; 
	}

	if($ban05 == 1){ 
		$Nli = $Nli + 1;
		$Imp_Linea[21] = ".".str_repeat(" ",23 - strlen("BON5 : ")).$BO5D." : ".dec($BO5, 2);
	}else{
		$Imp_Linea[21] = ""; 
	}

	if($CBE !== 0){ 
		$Nli = $Nli + 1;
		$Imp_Linea[22] = ".".str_repeat(" ",24 - strlen("COMP.EN EFECTIVO : "))."COMP.EN EFECTIVO : ".dec($CBE, 2);
	}
	
	
//	IMPRIME POR CONTROLADOR FISCAL

/*
   '***********************************************************************************************
   'MANDA A IMPRIMIR POR IMPRESORA GENERICA EL REPORTE DEL ARQUEO Y
   'ELIMINA EL REGISTRO EN RTURCIEO DEL ARQUEO PARA QUE NO SE IMPRIMA EN LA FISCAL
   'SI ESTA CONFIGURADO PARA QUE SALGA POR IMPRESORA GENERICA
*/  

	$_SESSION['ParSQL'] = "delete RTURCIEO where id=".$ParPV;
	$RTURCIEO = mssql_query($_SESSION['ParSQL']) or die("Error SQL");
	rollback($RTURCIEO);	

	$li = 0;
	$contador = 0;
	$cantidad = count($Imp_Linea);
	
	for($li ;$li < $cantidad ;$li++){
		if(strlen($Imp_Linea[$li]) > 0){
					
			$contador ++;

			$_SESSION['ParSQL'] = "INSERT INTO RTURCIEO (ID,TEX,ORD) VALUES(".$ParPV.",'".$Imp_Linea[$li]."',".$contador.")";
			$RTURCIEO = mssql_query($_SESSION['ParSQL']) or die("Error SQL");
			rollback($RTURCIEO);

		}
		
	}

	?>
	<script>
		jAlert('Arqueo Finalizado Correctamente. Impresi&oacute;n por Controlador Fiscal', 'Debo Retail - Global Business Solution');
		SoloNone('imprimirarq, BotonesPri, LetTer');

		$("#ArqAgr").load("ArqAgr.php");
	
		SoloBlock('Marca, fondotranspnumeros, TecladoNum, NumVolPADiv, NumVol, sal_arq, Arq_BotVer');
	
		document.getElementById('sup').value = '';
		document.getElementById('supenom').value = '';
		document.getElementById('efe').value = '';

		SoloNone("gastosf, chequesf, anticipof, tarjetasf, cargasf, retirof");

		var can = document.getElementById("can").value;
		if(can >= 1){
			document.getElementById('m1').value = "";
		}
		if(can >= 2){
			document.getElementById('m2').value = "";
		}
		if(can >= 3){
			document.getElementById('m3').value = "";
		}
		if(can >= 4){
			document.getElementById('m4').value = "";
		}
		if(can >= 5){
			document.getElementById('m5').value = "";
		}
		document.getElementById('tot').value = "";
		
		$("#supnum").css("border-color", "#F90");
	
		document.getElementById("DondeE").value = "sup";
		document.getElementById("CantiE").value = "4";
		document.getElementById("QuePoE").value = "1";
		
		EnvAyuda("Ingrese un n&uacute;mero de Supervisor o Enter para Listar.");
		
		document.getElementById('NumVolPADiv').innerHTML = '<button onclick="siguiente_arq1();" class="StyBoton" onmouseout="MM_swapImgRestore()" onmouseover="MM_swapImage(\'LetEntArqSup1\',\'\',\'botones/ent-over.png\',0)"><img src="botones/ent-up.png" name="Enter" title="Enter" border="0" id="LetEntArqSup1"/></button>';
	</script>
	<?

	
	}else{
		
//	MANDO A IMPRIMIR EN DISPOSITIVO GENERICO Y BORRO LOS DATOS DEL CF DE RTURCIEO

	$_SESSION['ParSQL'] = "delete RTURCIEO where id=".$ParPV;
	$RTURCIEO = mssql_query($_SESSION['ParSQL']) or die("Error SQL");
	rollback($RTURCIEO);	

		
/////LLENO LOS DATOS PARA LA IMPRESORA GENERICA Y PDF/////
   $Imp_Linea[0] = $numArqueo;
   $Imp_Linea[1] = "PLANILLA N : ".$PLA;
   $Imp_Linea[2] = "SUPERVISOR : ".$SUP;
   $Imp_Linea[3] = "OPERARIO : ".$OPE;
   $Imp_Linea[4] = "FECHA : " . $FechaArqueo;
   $Imp_Linea[5] = "-------------------------------------------------------------------------------------";
   $Imp_Linea[6] = dec($Saldo_A_Rendir, 2);
   $Imp_Linea[7] = dec($Saldo_Rendido,2);
   $Imp_Linea[8] = dec($Diferencia * -1, 2);
   $Imp_Linea[9] = "----------------------------------  DETALLE  -----------------------------------";
   $Nli=9;
	if($EFE !== 0){ 
		$Nli = $Nli + 1;
		$Imp_Linea[10] =dec($EFE, 2);
	}
	if($GAS !== 0){ 
		$Nli = $Nli + 1;
		$Imp_Linea[11] =dec(str_replace(",","",$GAS), 2);
	}
	if($CHE !== 0){ 
		$Nli = $Nli + 1;
		$Imp_Linea[12] =dec($CHE, 2);
	}
	if($ANT !== 0){ 
		$Nli = $Nli + 1;
		$Imp_Linea[13] =dec($ANT, 2);
	}
	if($TAR !== 0){ 
		$Nli = $Nli + 1;
		$Imp_Linea[14] =dec($TAR, 2);
	}
	if($CAR !== 0){ 
		$Nli = $Nli + 1;
		$Imp_Linea[15] =dec($CAR, 2);
	}
	if($RET !== 0){ 
		$Nli = $Nli + 1;
		$Imp_Linea[16] =dec($RET, 2);
	}

	if($ban01 == 1){ 
		$Nli = $Nli + 1;
		$Imp_Linea[17] =dec($BO1, 2);
	}else{
		$Imp_Linea[17] ="N";
	}

	if($ban02 == 1){ 
		$Nli = $Nli + 1;
		$Imp_Linea[18] =dec($BO2, 2);
	}else{
		$Imp_Linea[18] ="N";
	}

	if($ban03 == 1){ 
		$Nli = $Nli + 1;
		$Imp_Linea[19] =dec($BO3, 2);
	}else{
		$Imp_Linea[19] ="N";
	}

	if($ban04 == 1){ 
		$Nli = $Nli + 1;
		$Imp_Linea[20] =dec($BO4, 2);
	}else{
		$Imp_Linea[20] ="N";
	}

	if($ban05 == 1){ 
		$Nli = $Nli + 1;
		$Imp_Linea[21] =dec($BO5, 2);
	}else{
		$Imp_Linea[21] ="N";
	}

	if($CBE !== 0){ 
		$Nli = $Nli + 1;
		$Imp_Linea[22] =dec($CBE, 2);
	}	


//ENVIA FORMULARIO PARA GENERAR EL PDF E IMPRIMIRLO
	?>
    <body>
    <form action="ArqueImp.php" method="post" name="arqueoimp" id="arqueoimp">
        <input type="hidden" name="imp00" id="imp00" value="<? echo $Imp_Linea[0];?>" />
        <input type="hidden" name="imp01" id="imp01" value="<? echo $Imp_Linea[1];?>" />
        <input type="hidden" name="imp02" id="imp02" value="<? echo $Imp_Linea[2];?>" />
        <input type="hidden" name="imp03" id="imp03" value="<? echo $Imp_Linea[3];?>" />
        <input type="hidden" name="imp04" id="imp04" value="<? echo $Imp_Linea[4];?>" />
        <input type="hidden" name="imp05" id="imp05" value="<? echo $Imp_Linea[5];?>" />
        <input type="hidden" name="imp06" id="imp06" value="<? echo $Imp_Linea[6];?>" />
        <input type="hidden" name="imp07" id="imp07" value="<? echo $Imp_Linea[7];?>" />
        <input type="hidden" name="imp08" id="imp08" value="<? echo $Imp_Linea[8];?>" />
        <input type="hidden" name="imp09" id="imp09" value="<? echo $Imp_Linea[9];?>" />
        
        <input type="hidden" name="imp10" id="imp10" value="<? echo $Imp_Linea[10];?>" />
        <input type="hidden" name="imp11" id="imp11" value="<? echo $Imp_Linea[11];?>" />
        <input type="hidden" name="imp12" id="imp12" value="<? echo $Imp_Linea[12];?>" />
        <input type="hidden" name="imp13" id="imp13" value="<? echo $Imp_Linea[13];?>" />
        <input type="hidden" name="imp14" id="imp14" value="<? echo $Imp_Linea[14];?>" />
        <input type="hidden" name="imp15" id="imp15" value="<? echo $Imp_Linea[15];?>" />
        <input type="hidden" name="imp16" id="imp16" value="<? echo $Imp_Linea[16];?>" />
        
        <input type="hidden" name="imp17" id="imp17" value="<? echo $Imp_Linea[17];?>" />
        <input type="hidden" name="imp18" id="imp18" value="<? echo $Imp_Linea[18];?>" />
        <input type="hidden" name="imp19" id="imp19" value="<? echo $Imp_Linea[19];?>" />
        <input type="hidden" name="imp20" id="imp20" value="<? echo $Imp_Linea[20];?>" />
        <input type="hidden" name="imp21" id="imp21" value="<? echo $Imp_Linea[21];?>" />
        <input type="hidden" name="imp22" id="imp22" value="<? echo $Imp_Linea[22];?>" />

        <input type="hidden" name="imp23" id="imp23" value="<? echo $BO1D;?>" />
        <input type="hidden" name="imp24" id="imp24" value="<? echo $BO2D;?>" />
        <input type="hidden" name="imp25" id="imp25" value="<? echo $BO3D;?>" />
        <input type="hidden" name="imp26" id="imp26" value="<? echo $BO4D;?>" />
        <input type="hidden" name="imp27" id="imp27" value="<? echo $BO5D;?>" />

    
    </form>
    
    </body>
    </html>

	<script>
        jAlert('Arqueo Finalizado Correctamente.', 'Debo Retail - Global Business Solution');
    </script>
    
    <?
}




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
