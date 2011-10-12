<?
$xaptur = 1;
require("config/cnx.php");


try {////////////////////////////////////////////////////////////////////////////////////////////////// COMIENZO TRY //


// VARIABLES
$h = $_POST['horario'];
$e = $_POST['AT_efe_rec'];
$o = $_POST['AT_obs'];


mssql_query("begin transaction",$conexion) or die("Error SQL begin trans");

	
	$SQL = "SELECT TOP 1 PLA FROM ATURNOSO ORDER BY PLA DESC";
	$registros = mssql_query($SQL) or die("Error SQL");
		
	if(mssql_num_rows($registros) == 0){ $p = 1; }
		
	if (!$registros){
		mssql_query("rollback transaction") or die("Error SQL rollback");
	    exit;
	}
	
	while ($reg=mssql_fetch_row($registros)){ $p = $reg[0] + 1; }
	
	mssql_free_result($registros);


   //-----------------------------------------------------
   // ABRIR TURNO TABLA ATURNOSO
   //-----------------------------------------------------
// INSERT INTO

$PLA = $p;
$TUR = 60 + $_SESSION['ParLUG'];
$MTN = $h;
$FAP = date("Ymd H:i:s"); 
$CAR = $e;
$LUG = $_SESSION['ParLUG'];
$OPE = $_SESSION['idsusua'];
$CER = "A";
$OBS_EFE_REC = $o;
$ZON = $_SESSION["ParEMP"];

$SQL = "INSERT INTO ATURNOSO (pla, tur, mtn, fap, car, lug, ope, cer, obs_efe_rec, zon) 
		VALUES (".$PLA.",".$TUR.",".$MTN.",'".$FAP."',".$CAR.",".$LUG.",".$OPE.",'".$CER."','".$OBS_EFE_REC."',".$ZON.")";
   
$registros = mssql_query($SQL) or die("Error SQL: ".$SQL);
	if (!$registros){
		mssql_query("rollback transaction") or die("Error SQL rollback");
	    exit;
	}


   //-----------------------------------------------------
   // MARCO EL VENDEDOR CON LA PLANILLA QUE USA
   //-----------------------------------------------------
// UPDATE

$SQL = "UPDATE VENDEDORES SET turven = '$MTN', nplven = '$PLA'  WHERE CODVEN = '$OPE'";

$registros = mssql_query($SQL) or die("Error SQL: ".$SQL);
	if (!$registros){
		mssql_query("rollback transaction") or die("Error SQL rollback");
	    exit;
	}


   //-----------------------------------------------------
   // MARCO EL TURNO COMO HABILITADO
   //-----------------------------------------------------
// UPDATE

$SQL = "UPDATE ACONFTUO SET hab = 'S' WHERE LUG = '$LUG' AND HOR = '$MTN'";

$registros = mssql_query($SQL) or die("Error SQL: ".$SQL);
	if (!$registros){
		mssql_query("rollback transaction") or die("Error SQL rollback");
	    exit;
	}


	//-----------------------------------------------------
    // ACTUALIZO TABLA DE ARTICULOS ENTRADAS SALIDAS
    //-----------------------------------------------------
// SELECT
	
	$SQL = "SELECT Sec FROM ACONFTUO WHERE LUG = '$LUG' AND HOR = '$MTN'";
//	$SQL = "SELECT Sec FROM ACONFTUO WHERE LUG = 2 AND HOR = '$MTN'";
	$registros = mssql_query($SQL) or die("Error SQL: ".$SQL);
	if(mssql_num_rows($registros) == 0){
		?>
		<script>
			jAlert('Mal Configurado no hay registro en la TABLA ACONFTUO', 'Debo Retail - Global Business Solution');
		</script>    
		<?
	}
	if (!$registros){
		mssql_query("rollback transaction") or die("Error SQL rollback");
	    exit;
	}
	while ($reg=mssql_fetch_array($registros)){
		$cd_sec = $reg['Sec'];
	}


// UPDATE

$SQL = "UPDATE ARTICULOS SET SINTUR = EXIVTA, ENTTUR = 0, SALTUR = 0, ENTADM = 0, SALADM = 0 WHERE CODSEC = '$cd_sec'";
$registros = mssql_query($SQL) or die("Error SQL: ".$SQL);
	if (!$registros){
		mssql_query("rollback transaction") or die("Error SQL rollback");
	    exit;
	}
	
//-----------------------------------------------------
// MARCO EL TURNO COMO HABILITADO
//-----------------------------------------------------
// UPDATE
/***************** COLOCAR PARAMETRO PARA PLANILLAS *****************/
	$PLA_TER = 0;
	$COMMAND = mssql_query("SELECT PLA_TER FROM COMMAND") or die("Error SQL");
	while ($COMMAND_REG = mssql_fetch_array($COMMAND)){
		$PLA_TER = $COMMAND_REG['PLA_TER'];
	}
	mssql_free_result($COMMAND);
	if($PLA_TER == 0){
		$SQL = "UPDATE APARPOS SET EST = 'A', OPE = '".$OPE."' WHERE ID = '".$_SESSION['ParPOS']."'";
		$registros = mssql_query($SQL) or die("Error SQL: ".$SQL);
		if (!$registros){
			mssql_query("rollback transaction") or die("Error SQL rollback");
			exit;
		}
	}else{
		$SQL = "UPDATE APARPOS SET EST = 'A', OPE = '".$OPE."'";
		$registros = mssql_query($SQL) or die("Error SQL: ".$SQL);
		if (!$registros){
			mssql_query("rollback transaction") or die("Error SQL rollback");
			exit;
		}
	}
/*******************************************************************/

   //-----------------------------------------------------
   // INGRESO DE OPERARIO
   //-----------------------------------------------------
// INSERT INTO

$nomven = $_SESSION['idsusun'];

$fecha = substr($FAP, 0, 10);
$hora = substr($FAP, 11, 8);

$SQL = "INSERT INTO OPE_PLA (codven, nomven, lugven, fecha, hora, nplven) VALUES (".$OPE.",'".$nomven."',".$LUG.",'".$fecha."','".$hora."',".$PLA.")";

$registros = mssql_query($SQL) or die("Error SQL: ".$SQL);
	if (!$registros){
		mssql_query("rollback transaction") or die("Error SQL rollback");
		exit;
	}
	

mssql_query("commit transaction") or die("Error SQL commit");


?>
<script>

	jAlert('Turno abierto correctamete, Caja: <? echo $p; ?>', 'Debo Retail - Global Business Solution');
	SoloNone('AperturaTurno');
	
	document.getElementById('AperturaTurno').innerHTML = '';
	document.getElementById("LetTer").style.display="none";
	document.getElementById("CarAyuda").style.display="none";
	document.getElementById("CarAyudaFon").style.display="none";

	Mos_Ocu('BotonesPri');
	
	Mos_Ocu('fondotranspletras');
	Mos_Ocu('TecladoLet');
	Mos_Ocu('fondotranspnumeros');
	Mos_Ocu('TecladoNum');
	
$('#Bloquear').fadeOut(500);
	
</script>
<?


}catch(Exception $e){////////////////////////////////////////////////////////////////////////////////////////////////// FIN DE TRY //
	
	?>
	<script>
		jAlert('ERORR Reintente la operacion solicitada.', 'Debo Retail - Global Business Solution');
	</script>
	<?
exit;

}
?>