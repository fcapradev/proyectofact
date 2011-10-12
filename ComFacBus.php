<?
require("config/cnx.php");
/////////////////////////////// COMPRAS


try {////////////////////////////////////////////////////////////////////////////////////////////////// COMIENZO TRY //


mssql_query("begin transaction",$conexion) or die("Error SQL begin trans");


//SESSION
$LUG = $_SESSION['ParLUG'];

//REQUEST
if(isset($_REQUEST['xd'])){

	$xd = $_REQUEST['xd'];

}else{
	
	?>
	<script>
		$('#Bloquear').fadeOut(500);
	</script>
	<?
	exit;

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
	
	if($xd == 1){
		
		$_SESSION['ParSQL'] = "SELECT CODSEC, CODART, DETART, COSTO FROM ARTICULOS WHERE NHA = 0 AND CLA NOT IN (2,4,7) ORDER BY DETART ASC";
		
		if(isset($_REQUEST['cs'])){

			$cs = $_REQUEST['cs'];
			$_SESSION['ParSQL'] = "SELECT CODSEC, CODART, DETART, COSTO FROM ARTICULOS WHERE NHA = 0 AND CLA NOT IN (2,4,7) AND CODSEC = ".$cs." ORDER BY DETART ASC";
			
		}else{
		
			$_SESSION['ParSQL'] = "SELECT CODSEC, CODART, DETART, COSTO FROM ARTICULOS WHERE NHA = 0 AND CLA NOT IN (2,4,7) ORDER BY DETART ASC";
		
		}
		
		$cs = (int)$cs;
		
		if($cs == 0){ 
		
			$_SESSION['ParSQL'] = "SELECT CODSEC, CODART, DETART, COSTO FROM ARTICULOS WHERE NHA = 0 AND CLA NOT IN (2,4,7) ORDER BY DETART ASC";
			
		}
		
		$PMOVFACT = mssql_query($_SESSION['ParSQL']) or die("Error SQL");
		rollback($PMOVFACT);
		
	}
	if($xd == 2){
		
		$cp = $_REQUEST['cp'];
		
		$_SESSION['ParSQL'] = "
		SELECT B.COO, A.CODSEC, A.CODART, A.DETART, A.COSTO FROM ARTICULOS AS A 
		INNER JOIN A_COD_ORI AS B ON A.CODSEC = B.SEC AND A.CODART = b.ART
		WHERE B.PRV = ".$cp." AND A.NHA = 0 AND A.CLA NOT IN (2,4,7) ORDER BY A.DETART ASC";
		$PMOVFACT = mssql_query($_SESSION['ParSQL']) or die("Error SQL");
		rollback($PMOVFACT);
	}
	
	
	if($xd == 1){
		$ima = '<img src="Compras/bus_cod_deb.png">';
	}
	if($xd == 2){
		$ima = '<img src="Compras/bus_cod_ori.png">';
	}
	
	echo '
    <table width="440" border="0" cellpadding="0" cellspacing="1">
    <tr>
  		<td>'.$ima.'</td>
    </tr>
    </table>
	';	
	
	
	while ($PMOV_R = mssql_fetch_array($PMOVFACT)){

		if($xd == 1){
			$CODIGO = format($PMOV_R['CODSEC'],2,'0',STR_PAD_LEFT)."-".format($PMOV_R['CODART'],4,'0',STR_PAD_LEFT);
		}
		If($xd == 2){
			$CODIGO = $PMOV_R['COO'];
		}
		$DETART = substr($PMOV_R['DETART'],0,30);
		
		$COSTO = $PMOV_R['COSTO'];
		

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
		
			<div style="position:absolute; top:36px; left:440px;">
				<button class="StyBoton" onclick="mov_ant_fac33(<?php echo $s; ?>)" onMouseOut="MM_swapImgRestore()" onMouseOver="MM_swapImage('AntFacComC','','otros/scr_arri-over.png',0)"><img src="otros/scr_arri-up.png" border="0" id="AntFacComC"/></button>
			</div>
	
			<?
	
		}
	
	}
	if($xd == 2){
	?>
	<div class="ItemLis33" onClick="enviaritmdbuscod(<? echo $CODIGO; ?>,<? echo $PMOV_R['CODSEC']; ?>,<? echo $PMOV_R['CODART']; ?>);">
    <?
	}else{
	?>
	<div class="ItemLis33" onClick="enviaritmdbus(<? echo $PMOV_R['CODSEC']; ?>,<? echo $PMOV_R['CODART']; ?>);">		
    <?
	}
	?>
		<table width="440" border="0" cellpadding="0" cellspacing="1">
		<tr>
			<td width="85"><div align="center"><? echo $CODIGO; ?></div></td>
			<td width="270"><div align="left"  ><? echo $DETART; ?></div></td>
			<td width="85"><div align="center"><? echo $COSTO; ?></div></td>
		</tr>
	  </table>
	</div>
	<?php
    $t = $c;
	if ($c == 6){
	
		?>
	
		<div id="SigFacComCBid<?php echo $s; ?>" style="position:absolute; top:171px; left:440px;">
			<button class="StyBoton" onclick="mov_sig_fac33(<?php echo $s; ?>)" onMouseOut="MM_swapImgRestore()" onMouseOver="MM_swapImage('SigFacComC','','otros/scr_aba-over.png',0)"><img src="otros/scr_aba-up.png" border="0" id="SigFacComC"/></button>
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

mssql_query("commit transaction") or die("Error SQL commit");

	?>
	<script>
		$('#Bloquear').fadeOut(500);
	</script>
	<?

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