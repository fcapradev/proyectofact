<?
require("config/cnx.php");
/////////////////////////////// COMPRAS

try {////////////////////////////////////////////////////////////////////////////////////////////////// COMIENZO TRY //

mssql_query("begin transaction",$conexion) or die("Error SQL begin trans");
/*
$ban = 0;
/* Aqui sacas la informacion de la session 
for($i = 1 ; $i <= $_SESSION['Articulos_Total'] ; $i++){
	$objeto = $_SESSION['Articulos'][$i];

	if($objeto['sec'][$i] == $SEC){
		$ban = 1;
		debug("EL SECTOR ES CORRECTO");
	}else{
		$ban = 0;
		debug("EL SECTOR NO ES CORRECTO");			
	}
	
	//debug($objeto['sec'][$i],"SEC");
	//debug($objeto['art'][$i],"ART"); 

}
*/

$LUG = $_SESSION['ParLUG'];

$tn = $_REQUEST['tn'];
$movtip = $_REQUEST['movtip'];

if(isset($_REQUEST['sec'])){
	$SEC = $_REQUEST['sec'];
}else{
	$SEC = 0;
}

////////////////////////////////////////////////////////////////////////////////////////////////////////////
////////////////////////////////////////////////////////////////////////////////////////////////////////////

if(isset($_REQUEST['trae'])){
	
	if(isset($_REQUEST['sec'])){
		$SEC = $_REQUEST['sec'];

		if(isset($_REQUEST['art'])){
			$art = $_REQUEST['art'];
								//////////////////
			if($tn == 1){		// NOTA DE ALTA //
								//////////////////

				switch($movtip){
			
					case '0':	//	BUSCA TODOS LOS ARTICULOS
						if($SEC == 0){
							$_SESSION['ParSQL'] = "SELECT CODSEC, CODART, DETART, COSTO, EXIVTA, EXIDEP, DEPSN, CODRUB FROM ARTICULOS WHERE NHA = 0 AND PRO = 0 AND CLA NOT IN (2,4,7) ORDER BY DETART ASC";
						}else{
							$_SESSION['ParSQL'] = "SELECT CODSEC, CODART, DETART, COSTO, EXIVTA, EXIDEP, DEPSN, CODRUB FROM ARTICULOS WHERE CODSEC = ".$SEC." AND CODART = ".$art." AND NHA = 0 AND PRO = 0 AND CLA NOT IN (2,4,7) ORDER BY DETART ASC";
						}
						break;
			
					case '13':	//AJUSTE DE COMPRAS
					
						if($SEC == 0){
							$_SESSION['ParSQL'] = "SELECT CODSEC, CODART, DETART, COSTO, EXIVTA, EXIDEP, DEPSN, CODRUB FROM ARTICULOS WHERE NHA = 0 AND PRO = 0 AND CLA NOT IN (2,4,7) ORDER BY DETART ASC";
						}else{
							$_SESSION['ParSQL'] = "SELECT CODSEC, CODART, DETART, COSTO, EXIVTA, EXIDEP, DEPSN, CODRUB FROM ARTICULOS WHERE CODSEC = ".$SEC." AND CODART = ".$art." AND NHA = 0 AND PRO = 0 AND CLA NOT IN (2,4,7) ORDER BY DETART ASC";
						}
						break;
			
					case '14':	//DEPOSITO -> VENTAS (BUSCA ART CON DEPOSITO)
					
						$_SESSION['ParSQL'] = "SELECT CODSEC, CODART, DETART, COSTO, EXIVTA, EXIDEP, DEPSN, CODRUB FROM ARTICULOS WHERE CODSEC = ".$SEC." AND CODART = ".$art." AND NHA = 0 AND PRO = 0 AND CLA NOT IN (2,4,7) AND DEPSN = 1 ORDER BY DETART ASC";
		
						break;

					case '15':	//VENTAS -> VENTAS (BUSCA ART CON DEPOSITO)
					
						$_SESSION['ParSQL'] = "SELECT CODSEC, CODART, DETART, COSTO, EXIVTA, EXIDEP, DEPSN, CODRUB FROM ARTICULOS WHERE CODSEC = ".$SEC." AND CODART = ".$art." AND NHA = 0 AND PRO = 0 AND CLA NOT IN (2,4,7) ORDER BY DETART ASC";
		
						break;			
					
				}
								//////////////////
			}else{				// NOTA DE BAJA //
								//////////////////
				
				
				
			}
		
			$R1TB = mssql_query($_SESSION['ParSQL']) or die("Error SQL");
			rollback($R1TB);
			if(mssql_num_rows($R1TB) == 0){
				?>
				<script>
					jAlert('El Articulo ingresado no existe.', 'Debo Retail - Global Business Solution');
				
					document.getElementById('Producto').value = "";
					
					Ir_a("Producto",4,1);
					
					EnvAyuda("Ingrese el Articulo de Origen o Enter para listar.");
				
					document.getElementById('LetEnt').innerHTML = '<button onclick="Sig_Articulo(1);" class="StyBoton" onmouseout="MM_swapImgRestore()" onmouseover="MM_swapImage(\'LetEntTomInv3\',\'\',\'botones/ent-over.png\',0)"><img src="botones/ent-up.png" name="Enter" title="Enter" border="0" id="LetEntTomInv3"/></button>';
				
					document.getElementById('NumVol').innerHTML = '<button onclick="Vol_Sector();" class="StyBoton" onmouseout="MM_swapImgRestore()" onmouseover="MM_swapImage(\'LetVolTomInv0\',\'\',\'botones/vol-over.png\',0)"><img src="botones/vol-up.png" name="Volver" title="Volver" border="0" id="LetVolTomInv0"/></button>';
					
					$('#Bloquear').fadeOut(500);
				</script>    
				<?
				exit;
			}
		
			while ($reg=mssql_fetch_array($R1TB)){
				$CODSEC = $reg['CODSEC'];
				$CODART = $reg['CODART'];
				$DETART = substr($reg['DETART'],0,30);
				$EXIVTA = $reg['EXIVTA'];
				$EXIDEP = $reg['EXIDEP'];
				$COSTO = $reg['COSTO'];
				$CODRUB = $reg['CODRUB'];
		
				
			}
			
			?>
			<script>
				enviaarticuloIzq(<? echo $tn; ?>,<? echo $CODSEC; ?>,<? echo $CODART; ?>, '<? echo $DETART; ?>', <? echo $EXIVTA; ?>, <? echo $EXIDEP; ?>, <? echo $COSTO; ?>, <? echo $CODRUB; ?>);

				$("#ProductoDiv").css("border-color", "transparent");
				$("#SectorDivD").css("border-color", "#F90");
				
				Ir_a("SectorD",3,1);
						
				EnvAyuda("Ingrese el sector Destino.");
		
				document.getElementById('LetEnt').innerHTML = '<button onclick="Sig_CostoD();" class="StyBoton" onmouseout="MM_swapImgRestore()" onmouseover="MM_swapImage(\'LetEntTomInv6\',\'\',\'botones/ent-over.png\',0)"><img src="botones/ent-up.png" name="Enter" title="Enter" border="0" id="LetEntTomInv6"/></button>';
		
				document.getElementById('NumVol').innerHTML = '<button onclick="Vol_Sector();" class="StyBoton" onmouseout="MM_swapImgRestore()" onmouseover="MM_swapImage(\'LetVolTomInv3\',\'\',\'botones/vol-over.png\',0)"><img src="botones/vol-up.png" name="Volver" title="Volver" border="0" id="LetVolTomInv3"/></button>';
				
				
			</script>
			<?
			
		}else{

			$_SESSION['ParSQL'] = "SELECT * FROM SECTORES WHERE id not in(0) AND ID = ".$SEC.""; 
			$R1TB = mssql_query($_SESSION['ParSQL']) or die("Error SQL");
			rollback($R1TB);
			if(mssql_num_rows($R1TB) == 0){	
	
				?>
				<script>
					jAlert('El Sector ingresado no existe.', 'Debo Retail - Global Business Solution');
					document.getElementById('Sector').value = "";
					
					Ir_a("Sector",3,1);
					
					EnvAyuda("Ingrese el Sector de Origen o Enter para listar.");
				
					document.getElementById('LetEnt').innerHTML = '<button onclick="BuscaSector(1);" class="StyBoton" onmouseout="MM_swapImgRestore()" onmouseover="MM_swapImage(\'LetEntTomInv3\',\'\',\'botones/ent-over.png\',0)"><img src="botones/ent-up.png" name="Enter" title="Enter" border="0" id="LetEntTomInv3"/></button>';
				
					document.getElementById('NumVol').innerHTML = '<button onclick="VolOperacion();" class="StyBoton" onmouseout="MM_swapImgRestore()" onmouseover="MM_swapImage(\'LetVolTomInv0\',\'\',\'botones/vol-over.png\',0)"><img src="botones/vol-up.png" name="Volver" title="Volver" border="0" id="LetVolTomInv0"/></button>';
					
					$('#Bloquear').fadeOut(500);
				</script>    
				<?
				exit;
			}
		
			while ($reg=mssql_fetch_array($R1TB)){
				$ID = $reg['ID'];
			}
				$ban = 0;

			?>
			<script>
				document.getElementById('Sector').value = "<? echo $ID; ?>";
				$("#ProductoDiv").css("border-color", "#F90");
				$("#SectorDiv").css("border-color", "transparent");
			</script>
			<?
			
		}

	}
}else{

////////////////////////////////////////////////////////////////////////////////////////////////////////////
////////////////////////////////////////////////////////////////////////////////////////////////////////////

					//////////////////
if($tn == 1){		// NOTA DE ALTA //
					//////////////////
						
	switch($movtip){

		case '0':	//	BUSCA TODOS LOS ARTICULOS
			if($SEC == 0){
				$_SESSION['ParSQL'] = "SELECT CODSEC, CODART, DETART, COSTO, EXIVTA, EXIDEP, DEPSN, CODRUB FROM ARTICULOS WHERE NHA = 0 AND PRO = 0 AND CLA NOT IN (2,4,7) ORDER BY DETART ASC";
			}else{
				$_SESSION['ParSQL'] = "SELECT CODSEC, CODART, DETART, COSTO, EXIVTA, EXIDEP, DEPSN, CODRUB FROM ARTICULOS WHERE CODSEC = ".$SEC." AND NHA = 0 AND PRO = 0 AND CLA NOT IN (2,4,7) ORDER BY DETART ASC";
			}
			break;

		case '13':	//AJUSTE DE COMPRAS
		
			if($SEC == 0){
				$_SESSION['ParSQL'] = "SELECT CODSEC, CODART, DETART, COSTO, EXIVTA, EXIDEP, DEPSN, CODRUB FROM ARTICULOS WHERE NHA = 0 AND PRO = 0 AND CLA NOT IN (2,4,7) ORDER BY DETART ASC";
			}else{
				$_SESSION['ParSQL'] = "SELECT CODSEC, CODART, DETART, COSTO, EXIVTA, EXIDEP, DEPSN, CODRUB FROM ARTICULOS WHERE CODSEC = ".$SEC." AND NHA = 0 AND PRO = 0 AND CLA NOT IN (2,4,7) ORDER BY DETART ASC";
			}
			break;

		case '14':	//DEPOSITO -> VENTAS (BUSCA ART CON DEPOSITO)
		
			if($SEC == 0){
				$_SESSION['ParSQL'] = "SELECT CODSEC, CODART, DETART, COSTO, EXIVTA, EXIDEP, DEPSN, CODRUB FROM ARTICULOS WHERE NHA = 0 AND PRO = 0 AND CLA NOT IN (2,4,7) AND DEPSN = 1 ORDER BY DETART ASC";
			}else{
				$_SESSION['ParSQL'] = "SELECT CODSEC, CODART, DETART, COSTO, EXIVTA, EXIDEP, DEPSN, CODRUB FROM ARTICULOS WHERE CODSEC = ".$SEC." AND NHA = 0 AND PRO = 0 AND CLA NOT IN (2,4,7) AND DEPSN = 1 ORDER BY DETART ASC";
			}
			break;

		
	}
					//////////////////
}else{				// NOTA DE BAJA //
					//////////////////
	
	
	
}



?>
<style>
.ItemLis33{
	background-image: url(Compras/Bus_Item.png);
	background-repeat:repeat-x;
	cursor:pointer;
	height:27px; 
	z-index:4; 
	color:#FFF; 
	font-family: "TPro"; 
	font-size:14px;
}

.ItemLis33:active{ 
	position:relative;
	left:1px;
	top:1px;
	
	-moz-box-shadow:0px 1px 0;
	-webkit-box-shadow:0px 1px 0;
}
</style>
<script>
function mov_ant_fac33(p){

	np = p - 1;	
	document.getElementById("CapFacComB"+np).style.display="block";
	document.getElementById("CapFacComB"+p).style.display="none";
	
	return false;
}

function mov_sig_fac33(p){
	
	np = p + 1;	
	document.getElementById("CapFacComB"+np).style.display="block";
	document.getElementById("CapFacComB"+p).style.display="none";
	
	return false;
}
</script>
	<?

	$c = 0;
	$s = 1;
	$t = 0;
	
////////////////////////////////////////////////////////////////////////
	
	$PMOVFACT = mssql_query($_SESSION['ParSQL']) or die("Error SQL");
	rollback($PMOVFACT);
	
	while ($PMOV_R = mssql_fetch_array($PMOVFACT)){

		$DETART = substr($PMOV_R['DETART'],0,30);
		$COSTO = $PMOV_R['COSTO'];
		$EXIVTA = $PMOV_R['EXIVTA'];
		$EXIDEP = $PMOV_R['EXIDEP'];
		$CODRUB = $PMOV_R['CODRUB'];
		
	++$c;


	if ($c == 1){
	
		if($s == 1){
			$e = "block";
		}else{
			$e = "none";
		}
	
		echo "<div id=\"CapFacComB".$s."\" style=\"display:".$e."\">";
		
		if($s <> 1){
			?>
		
			<div style="position:absolute; top:0px; left:460px;">
				<button class="StyBoton" onclick="mov_ant_fac33(<?php echo $s; ?>)" onMouseOut="MM_swapImgRestore()" onMouseOver="MM_swapImage('AntNaNbLis','','otros/scr_arri-over.png',0)"><img src="otros/scr_arri-up.png" border="0" id="AntNaNbLis"/></button>
			</div>
	
			<?
	
		}
	
	}
	
	?>
	<div class="ItemLis33" onClick="enviaarticuloIzq(<? echo $tn; ?>,<? echo $PMOV_R['CODSEC']; ?>,<? echo $PMOV_R['CODART']; ?>, '<? echo $DETART; ?>', <? echo $EXIVTA; ?>, <? echo $EXIDEP; ?>, <? echo $COSTO; ?>, <? echo $CODRUB; ?>);">
		<table width="458" border="0" cellpadding="0" cellspacing="0">
		<tr>
			<td width="35"><div align="center"><? echo format($PMOV_R['CODSEC'],2,'0',STR_PAD_LEFT); ?></div></td>
            <td width="50"><div align="center"><? echo format($PMOV_R['CODART'],4,'0',STR_PAD_LEFT); ?></div></td>
			<td width="260"><div align="left"  ><? echo $DETART; ?></div></td>
			<td width="85"><div align="center"><? echo $COSTO; ?></div></td>
		</tr>
	  </table>
	</div>
	<?php
    $t = $c;
	if ($c == 6){
	
		?>
	
		<div id="SigFacComCBid<?php echo $s; ?>" style="position:absolute; top:133px; left:460px;">
			<button class="StyBoton" onclick="mov_sig_fac33(<?php echo $s; ?>)" onMouseOut="MM_swapImgRestore()" onMouseOver="MM_swapImage('SigNaNbLis','','otros/scr_aba-over.png',0)"><img src="otros/scr_aba-up.png" border="0" id="SigNaNbLis"/></button>
		</div>
		
		</div>
		
		<?php
		
		$c = 0;
		$s = $s + 1;

	}
			
}
mssql_free_result($PMOVFACT);

if($t == 6){
	?>
    <script>
		SoloNone('SigFacComCBid<?php echo $s - 1; ?>');
	</script>
    <?
}

}

?>
<script>
	$('#Bloquear').fadeOut(500);
</script>
<?

mssql_query("commit transaction") or die("Error SQL commit");

}catch(Exception $e){////////////////////////////////////////////////////////////////////////////////////////////////// FIN DE TRY //
	
	?>
	<script>
		$('#Bloquear').fadeOut(500);
		jAlert('ERROR Reintente la operacion solicitada.', 'Debo Retail - Global Business Solution');
	</script>
	<?
exit;

}

?>