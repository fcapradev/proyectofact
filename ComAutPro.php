<?
require("config/cnx.php");

try {////////////////////////////////////////// COMIENZO TRY //

mssql_query("begin transaction",$conexion) or die("Error SQL begin trans");

$obs = "";
if(isset($_REQUEST['ban']) ){
	$ban = $_REQUEST['ban'];	
	$ti = $_REQUEST['ti'];
	$tc = $_REQUEST['tc'];
	$su = $_REQUEST['su'];
	$nc = $_REQUEST['nc'];

	if( $ban == 2 ){
		$obs = $_REQUEST['obs'];
	}
}else{
	exit;	
}
?>
<script>
	//alert("TI: <? echo $ti; ?>, TC: <? echo $tc; ?>, SU: <? echo $su; ?>, NC: <? echo $nc; ?>, Ban: <? echo $ban; ?>");
</script>
<?

if($ban == 1){

////////////////////////////////	
//		ENTRA SI AUTORIZA	  //
////////////////////////////////	

$_SESSION['ParSQL'] = "
SELECT C.NplVen AS PLA, C.CodVen AS OPE FROM ATURNOSH AS A 
INNER JOIN APARPOS AS B ON B.ID = 1
INNER JOIN VENDEDORES AS C ON C.CodVen = B.OPE
INNER JOIN ATURNOSO AS D ON D.PLA = C.NplVen
WHERE A.MTN = D.MTN";

$registros = mssql_query($_SESSION['ParSQL']) or die("Error SQL");
rollback($registros);		

if(mssql_num_rows($registros)==0){
	exit;
}
while ($reg=mssql_fetch_array($registros)){

	$PLA = $reg['PLA'];
	$OPE = $reg['OPE'];
	
}

/*
$_SESSION['ParSQL'] ="SELECT nplven,turven FROM vendedores WHERE codven = ".$OPE."";
$registros = mssql_query($_SESSION['ParSQL']) or die("Error SQL");
rollback($registros);		

if(mssql_num_rows($registros)==0){
	exit;
}
while ($reg=mssql_fetch_array($registros)){

	$nplven = $reg['nplven'];
	$turven = $reg['turven'];
	
}
*/


//PMAEFACT_AUTO

$_SESSION['ParSQL'] ="SELECT * FROM PMAEFACT_AUTO WHERE emp = ".$_SESSION['ParEMP']." and tip = '".$ti."' and tco = '".$tc."' and suc = ".$su." and NCO = ".$nc."";
$registros = mssql_query($_SESSION['ParSQL']) or die("Error SQL");
rollback($registros);		
while ($reg=mssql_fetch_array($registros)){
	$PRO = $reg['PRO'];
	$FEC = $reg['FEC'];
	$TIP = $reg['TIP'];
	$TCO = $reg['TCO'];
	$SUC = $reg['SUC'];
	$NCO = $reg['NCO'];
	$TOT = str_replace(",",".",$reg['TOT']);
	$FPA = $reg['FPA'];
	$FEV = $reg['FEV'];	
	
}

//PMOVFACT_AUTO

$_SESSION['ParSQL'] ="SELECT * FROM PMOVFACT_AUTO WHERE  tip = '".$ti."' and tco = '".$tc."' and suc = ".$su." and NCO = ".$nc."";
$registros = mssql_query($_SESSION['ParSQL']) or die("Error SQL");
rollback($registros);		
while ($reg=mssql_fetch_array($registros)){
	$ORD = $reg['ORD'];
}


//INSERT EN PCOBYPAG 

$_SESSION['ParSQL'] = "INSERT INTO PCOBYPAG (COD,FEP,TIP,TCO,SUC,NCO,IPA,SAL,TCA,ZONA,FPA,REC,FER,PRO,FEV,ANU,PLA,LUG,RES,CCU
,UCU,HOS ) VALUES (".$PRO.",'".$FEC."','".$TIP."','".$TCO."',
".$SUC.",".$NCO.",".$TOT.",0,0,".$_SESSION['ParEMP'].","
.$FPA.",0,'1900/01/01','','".$FEV."','',".$PLA.",".$_SESSION['ParLUG'].",0,0,0,'')";

$registros = mssql_query($_SESSION['ParSQL']) or die("Error SQL");
rollback($registros);



//INSERT EN PMAEFACT

$_SESSION['ParSQL'] = "
INSERT INTO PMAEFACT (TIP, TCO, SUC, NCO, COD, FEC, NOM, TIV, CUI, FPA, TCA, DTO, PDT, NET, NEE, IRI, IRS, IMI, RGA, RIB, PIV, CNG, TOT, ZON, FEV, OCP, REC, FEP, NPE, CPA, ENV, REM, PRO, ANU, TUR, PLA, LUG, ATO, CCO, IMA, CCA1, CCA2, CCA3, CCA4, CCA5, CCA6, CCA7, CCA8, CCA0, OBS, RIV, FECCAI, CAI, CHO, CTR, PER, CCA9, FECVEN, CNG2, CG, DETPRO) 

SELECT TIP, TCO, SUC, NCO, PRO, FEC, NOM, TIV, CUI, FPA, TCA, DTO, PDT, NET, NEE, IRI, IRS, IMI, RGA, RIB, PIV, CNG, TOT, ZON, FEV, OCP, REC, FEP, NPE, CPA, ENV, REM, PRO, ANU, TUR, PLA, LUG, ATO, CCO, IMA, CCA1, CCA2, CCA3, CCA4, CCA5, CCA6, CCA7, CCA8, CCA0, OBS, RIV, FECCAI, CAI, CHO, CTR, PER, CCA9, FECVEN, CNG2, CG, DETPRO 

FROM PMAEFACT_AUTO WHERE TIP = '".$TIP."' AND TCO = '".$TCO."' AND SUC =  ".$SUC." And Nco = ".$NCO."";

$registros = mssql_query($_SESSION['ParSQL']) or die("Error SQL");
rollback($registros);


//INSERT EN PMOVFACT

$_SESSION['ParSQL'] = "
INSERT INTO PMOVFACT (TIP,TCO,SUC,NCO,PRO,ORD,COD,ART,RUB,TIO,LI0,CAN,PUN,IMI,IVA,PUT,LEG,CMF,TUR,PLA,LUG,ESC,TAN,CCO,DTO) 

SELECT TIP,TCO,SUC,NCO,PRO,ORD,SEC,ART,RUB,LEFT(TIO,30),LI0,CAN,PUN,IMI,IVA,PUT,LEG,CMF,TUR,PLA,LUG,ESC,TAN,CCO,DTO 

FROM PMOVFACT_AUTO WHERE TIP = '".$TIP."' AND TCO = '".$TCO."' AND SUC =  ".$SUC." And Nco = ".$NCO." ";

$registros = mssql_query($_SESSION['ParSQL']) or die("Error SQL");
rollback($registros);


//INSERT EN AMOVSTOC

$_SESSION['ParSQL'] = "
INSERT INTO AMOVSTOC (SEC,ART,FEC,CYV,TIP,TCO,PVE,NCO,NMF,ORD,CAN,PUN,COD,IMI,PLA,LUG,ANU,TIM,OPE,IMI2) 

SELECT A.SEC,A.ART,B.FEC,'C',A.TIP,A.TCO,A.SUC,A.NCO,'',A.ORD,A.CAN,A.PUN,B.PRO,A.IMI,A.PLA,A.LUG,B.ANU,'Co',0,0 

FROM PMOVFACT_AUTO A INNER JOIN PMAEFACT_AUTO B ON A.TIP=B.TIP AND A.TCO=B.TCO AND A.SUC=B.SUC AND A.NCO=B.NCO WHERE A.TIP = '".$ti."' AND A.TCO = '".$tc."' AND A.SUC =  ".$su." And A.Nco = ".$nc." ";

$registros = mssql_query($_SESSION['ParSQL']) or die("Error SQL");
rollback($registros);

//	REALIZO EL UPDATE CON EL OPERARIO

$_SESSION['ParSQL'] = "UPDATE AMOVSTOC SET OPE = ".$OPE." WHERE TIP = '".$TIP."' AND TCO = '".$TCO."' AND PVE = ".$SUC." AND NCO = ".$NCO."";
$R1TB = mssql_query($_SESSION['ParSQL']) or die("Error SQL");
rollback($R1TB);


//	REALIZO EL UPDATE AL ESTADO

$_SESSION['ParSQL'] = "UPDATE PMAEFACT_AUTO SET ESTADO = 11, obs_A = 'Aceptado en PDV X Operador', C_HD = '',E_HD = '' WHERE tip = '".$ti."' AND tco = '".$tc."' AND suc = ".$su." AND nco = ".$nc."";
$R1TB = mssql_query($_SESSION['ParSQL']) or die("Error SQL");
rollback($R1TB);


?>
<script>
	$('#Bloquear').fadeOut(500);
	jAlert('El Comprobante ha sido autorizado.', 'Debo Retail - Global Business Solution');
</script>

<?

}else{

	////////////////////////////////	
	//		ENTRA SI RECHAZA	  //
	////////////////////////////////	
	
	$_SESSION['ParSQL'] = "UPDATE PMAEFACT_AUTO SET ESTADO = 12, OBS_A = '".$obs."' ,C_HD='',E_HD='' where tip = '".$ti."' and tco = '".$tc."' and suc = ".$su." and nco = ".$nc."";
	
	$R1TB = mssql_query($_SESSION['ParSQL']) or die("Error SQL");
	rollback($R1TB);
	
	?>
	<script>
		$('#Bloquear').fadeOut(500);
		jAlert('El Comprobante ha sido rechazado.', 'Debo Retail - Global Business Solution');
	</script>
	<?

}



?>
<script>
	cominicio();
</script>

<?

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