<?
require("config/cnx.php");


try {////////////////////////////////////////////////////////////////////////////////////////////////// COMIENZO TRY //


mssql_query("begin transaction",$conexion) or die("Error SQL begin trans");
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Monedas</title>

<style>
.moned{ 
	font-family: Arial;
	font-size:11px;
	color:#FFF;
}
</style>

</head>
<body>
<div class="moned" style="position:absolute; left:0px; top:3px;">
<?

//REQUEST
$TOT = $_REQUEST['tot'];

$CPARBON = mssql_query("SELECT TOP 5 ABR, DES, [COT], LEN(ABR) AS CON FROM CPARBON") or die("Error SQL");
while ($RCPAR = mssql_fetch_array($CPARBON)){

	if($RCPAR['CON'] > 1){
		$ABR = $RCPAR['ABR'];
	}else{
		$ABR = '&nbsp;-&nbsp;';
	}
	
	//$ABR = $RCPAR['DES'];
	
    $NTOT = $TOT / $RCPAR['COT'];
	$NTOT = dec($NTOT,2);
	
	?>
    <div style="margin-right:2px;">
    <table width="90" cellpadding="0" cellspacing="1" border="0">
        <tr>
     	   <td><div align="right"><samp><? echo $ABR; ?></samp></div></td>
        	<td width="60" background="facturador/conn.png"><div align="center"><? echo $NTOT; ?></div></td>
        </tr>
    </table>
    </div>
	<?
  
}
mssql_free_result($CPARBON);


mssql_query("commit transaction") or die("Error SQL commit");


?>
</div>
</body>
</html>
<?

}catch(Exception $e){////////////////////////////////////////////////////////////////////////////////////////////////// FIN DE TRY //
	
	?>
	<script>
		jAlert('ERROR Reintente la operacion solicitada.', 'Debo Retail - Global Business Solution');
	</script>
	<?
exit;

}