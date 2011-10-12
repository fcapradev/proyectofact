<?
require("config/cnx.php");

try {////////////////////////////////////////////////////////////////////////////////////////////////// COMIENZO TRY //

mssql_query("begin transaction",$conexion) or die("Error SQL begin trans");

$_SESSION['ParSQL'] = "SELECT RIP,N_PLAC FROM APARSIS";
$REEIMPRESION = mssql_query($_SESSION['ParSQL']) or die("Error SQL");
rollback($REEIMPRESION);		
while ($RIMP=mssql_fetch_array($REEIMPRESION)){
	$RIP = $RIMP['RIP'];
	$N_PLAC = $RIMP['N_PLAC'];
}

$_SESSION['ParSQL'] = "
SELECT C.NplVen AS PLA FROM ATURNOSH AS A 
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
	$PLA_REIMP = $reg['PLA'];
}

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Cierre de Turno</title>
<link href="Estilo.css" rel="stylesheet" type="text/css" />
<script>

function enviar_ct(){
	$('#Bloquear').fadeIn(500);
	var p = document.getElementById("planilla").value;
	$("#archivos").load("CTur.php?p="+p);
	
}

function salir_ae(){
	
	SoloNone('CarAyudaFon, CarAyuda, NumVolPro');
	Mos_Ocu('BotonesPri');
	Mos_Ocu('fondotranspletras');
	Mos_Ocu('TecladoLet');
	Mos_Ocu('fondotranspnumeros');
	Mos_Ocu('TecladoNum');	
	Mos_Ocu('CierreTurno');
	
}

function mostrarhor(){

	EnvAyuda('Selecione cerrar o cancelar.');
	Mos_Ocu('desapar');
	Mos_Ocu('mostrarhorario');
	SoloBlock("LetEnt, LetTer");

}

function ReImpPla(){
	var pla = document.getElementById("LetTex").value;
	//alert(pla);	

	if(pla.length != 0){
		var pla_act = document.getElementById("pla").value;
		var rip = document.getElementById("rip").value;
		var nplac = document.getElementById("nplac").value;
		
		var dif = pla_act - nplac;
		
		if(rip == 1){
			if((pla < pla_act) && (pla >= dif)){
				
				SoloNone("Bloquear");
				Mos_Ocu('fondotranspletras');
				Mos_Ocu('TecladoLet');
				Mos_Ocu('fondotranspnumeros');
				Mos_Ocu('TecladoNum');
			
				SoloNone("Confirmar");
				$("#archivos").load("CCajaImp.php?pla="+pla);
				
			}else{
				jAlert('La Planilla ingresada no se encuentra habilitada para ser ReImpresa.', 'Debo Retail - Global Business Solution');
				document.getElementById("LetTex").value = "";
			}
		}else{
			jAlert('No está habilitada la ReImpresión de Planillas.', 'Debo Retail - Global Business Solution');
			document.getElementById("LetTex").value = "";
		}
	}else{
		
		jAlert('Ingrese la planilla que desea ReImprimir.', 'Debo Retail - Global Business Solution');
		document.getElementById("LetTex").value = "";
	}
}

function SalirImpre(){

	SoloNone("LetEnt, LetTer, ImpresionPdfDiv");
	SoloBlock("LetSal, NumVol, NumVolPro");
	SoloBlock('fondotranspletras, TecladoLet, fondotranspnumeros, TecladoNum, CierreTurno');
	EnvAyuda("Seleccione la caja a cerrar.O ingrese la planilla a Reimprimir.");
}
</script>
</head>
<body>

<!-- DATOS PARA REIMPRESION DE PLANILLAS -->

<input type="hidden" name="pla" id="pla" value="<? echo $PLA_REIMP; ?>" />
<input type="hidden" name="rip" id="rip" value="<? echo $RIP; ?>" />
<input type="hidden" name="nplac" id="nplac" value="<? echo $N_PLAC; ?>" />

<!-- ----------------------------------- -->

<div id="Cierre_Fon" style="position:absolute; z-index:1; width:639px; height:235px; top:125px; left:81px;">
	<img src="cierre/cierredecaja.png" />
</div>

<div id="Cierre" style="position:absolute; z-index:2; width:639px; height:235px; top:125px; left:81px;">

		<?

		$SQL = "
		SELECT C.NplVen AS PLA, D.FAP AS FAP, A.MTN, A.DES, A.INI, A.FIN FROM ATURNOSH AS A 
		INNER JOIN APARPOS AS B ON B.ID = '".$_SESSION['ParPOS']."'
		INNER JOIN VENDEDORES AS C ON C.CodVen = B.OPE
		INNER JOIN ATURNOSO AS D ON D.PLA = C.NplVen
		WHERE A.MTN = D.MTN";
		
		$registros = mssql_query($SQL) or die("Error SQL");
			
		if(mssql_num_rows($registros) == 0){
			?>
			<script>
				jAlert('No Hay Turnos Abiertos para Trabajar.', 'Debo Retail - Global Business Solution');
			</script>    
			<?
			exit;
		}
		
		while ($reg=mssql_fetch_array($registros)){
		
			$PLA = $reg['PLA'];
			$FAP = $reg['FAP'];
			$MTN = $reg['MTN'];
			$DES = $reg['DES'];
			$INI = $reg['INI'];
			$FIN = $reg['FIN'];
			
		}
		mssql_free_result($registros);
		
		?>

	<div class="ParaDiv" style="left:17px; top:51px;"><img src="cierre/pla.png" /></div>
	
	<div class="ParaDiv" id="desapar" style="left:17px; top:49px; cursor:pointer; z-index:2;" onclick="mostrarhor();" >
		<table width="285" border="0">
		<tr>
		<td>&nbsp;</td>
		</tr>
		</table>
	</div>
	
	<input type="hidden" name="planilla" id="planilla" value="<? echo $PLA; ?>" />
		
	<div class="ParaDiv" style="left:17px; top:49px; z-index:0;" >
		<table width="285" border="0">
            <tr>
                <td width="70">
                	<div class="ParaDiv2" align="center">
						<? echo format($PLA,5,'0',STR_PAD_LEFT); ?>
                    </div>
                </td>
                <td width="70">
                	<div class="ParaDiv2" align="center">
						<? echo format($MTN,2,'0',STR_PAD_LEFT); ?>
                    </div>
                </td>			
                <td width="145">
                    <div class="ParaDiv2" align="right">
                        <? 
                        $date = new DateTime($FAP);
                        echo $date->format('d-m-Y H:i');
                        ?>
                    </div>
                </td>
            </tr>
		</table>
	</div>
    
	<div style="display:none;" id="mostrarhorario">
		
		<div class="ParaDiv" style="left:415px; top:68px;">
			<? echo format($MTN,2,'0',STR_PAD_LEFT); ?>&nbsp; - &nbsp;De: <? echo $INI; ?> a <? echo $FIN; ?>
		</div>
		
		<div class="ParaDiv" style="left:415px; top:30px;">
			<? echo format($PLA,5,'0',STR_PAD_LEFT); ?>
		</div>
					
		<div class="ParaDiv" style="left:415px; top:91px;">
		<? 
		$date = new DateTime($FAP);
		echo $date->format('d-m-Y H:i:s');
		?>
		</div>
		
		<div class="ParaDiv" style="left:415px; top:115px;">
			<? echo date('d-m-Y H:i:s'); ?>
		</div>
	
	</div>

</div>

</body>
</html>
<?

mssql_query("commit transaction") or die("Error SQL commit");


}catch(Exception $e){////////////////////////////////////////////////////////////////////////////////////////////////// FIN DE TRY //
	
	?>
	<script>
		jAlert('ERORR Reintente la operacion solicitada.', 'Debo Retail - Global Business Solution');
	</script>
	<?
exit;

}

?>