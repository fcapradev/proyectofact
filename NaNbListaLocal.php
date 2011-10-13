<?
require("config/cnx.php");
/////////////////////////////// COMPRAS


try {////////////////////////////////////////////////////////////////////////////////////////////////// COMIENZO TRY //


mssql_query("begin transaction",$conexion) or die("Error SQL begin trans");

$BAN = $_REQUEST['ban'];


if(isset($_REQUEST['loc'])){

	$loc = $_REQUEST['loc'];

	$_SESSION['ParSQL'] = "SELECT * FROM T_EMPRESA WHERE EMP = ".$loc."";
	$PMOVFACT = mssql_query($_SESSION['ParSQL']) or die("Error SQL");
	rollback($PMOVFACT);

	if(mssql_num_rows($PMOVFACT) == 0){	
		?>
		<script>
		
			jAlert('El Local ingresado no existe.', 'Debo Retail - Global Business Solution');

			document.getElementById('Local').value = "";
			
			Ir_a("Local",4,1);
							
		</script>    
		<?
		exit;
	}

	while ($PMOV_R = mssql_fetch_array($PMOVFACT)){

		$NOM = substr($PMOV_R['NOM'],0,60);
		$EMP = $PMOV_R['EMP'];
		$DIR = $PMOV_R['DIR'];
	}
	
	if($BAN == 1){
		?>
		<script>
		
			envialocal(<? echo $EMP; ?>,'<? echo trim($NOM); ?>','<? echo trim($DIR); ?>');
	
		</script>
		<?
	}else{
		?>
		<script>
		
			envialocalNB(<? echo $EMP; ?>,'<? echo trim($NOM); ?>','<? echo trim($DIR); ?>');
	
		</script>
		<?		
	}
}else{

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
	
	$_SESSION['ParSQL'] = "SELECT * FROM T_EMPRESA ORDER BY EMP ASC";
	
	$PMOVFACT = mssql_query($_SESSION['ParSQL']) or die("Error SQL");
	rollback($PMOVFACT);
	
	while ($PMOV_R = mssql_fetch_array($PMOVFACT)){

		$EMP = $PMOV_R['EMP'];
		$NOM = substr($PMOV_R['NOM'],0,37);
		$DIR = substr($PMOV_R['DIR'],0,37);
		
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
		
			<div style="position:absolute; top:0px; left:604px;">
				<button class="StyBoton" onclick="mov_ant_fac33(<?php echo $s; ?>)" onMouseOut="MM_swapImgRestore()" onMouseOver="MM_swapImage('AntNaNbLis<?php echo $s; ?>','','otros/scr_arri-over.png',0)"><img src="otros/scr_arri-up.png" border="0" id="AntNaNbLis<?php echo $s; ?>"/></button>
			</div>
	
			<?
	
		}
	
	}
	if($BAN == 1){
	?>
		<div class="ItemLis33" onClick="envialocal(<? echo $EMP; ?>,'<? echo trim($NOM); ?>','<? echo trim($DIR); ?>');">
    <?
	}else{
	?>
    	<div class="ItemLis33" onClick="envialocalNB(<? echo $EMP; ?>,'<? echo trim($NOM); ?>','<? echo trim($DIR); ?>');">
    <?
	}
	?>
		<table width="600" border="0" cellpadding="0" cellspacing="0">
		<tr>
			<td width="51"><div align="center"><? echo format($EMP,4,'0',STR_PAD_LEFT); ?></div></td>
			<td width="245"><div align="left"  ><? echo $NOM; ?></div></td>
			<td width="255"><div align="left"><? echo $DIR; ?></div></td>
		</tr>
	  </table>
	</div>
	<?php
    $t = $c;
	if ($c == 7){
	
		?>
	
		<div id="SigFacComCBid<?php echo $s; ?>" style="position:absolute; top:160px; left:604px;">
			<button class="StyBoton" onclick="mov_sig_fac33(<?php echo $s; ?>)" onMouseOut="MM_swapImgRestore()" onMouseOver="MM_swapImage('SigNaNbLis<?php echo $s; ?>','','otros/scr_aba-over.png',0)"><img src="otros/scr_aba-up.png" border="0" id="SigNaNbLis<?php echo $s; ?>"/></button>
		</div>
		
		</div>
		
		<?php
		
		$c = 0;
		$s = $s + 1;

	}
			
}
mssql_free_result($PMOVFACT);

if($t == 7){
	?>
    <script>
		SoloNone('SigFacComCBid<?php echo $s - 1; ?>');
	</script>
    <?
}

mssql_query("commit transaction") or die("Error SQL commit");

	?>
	<script>
		$('#Bloquear').fadeOut(500);
	</script>
	<?

}

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