<?
session_start();

set_time_limit(0);

require_once('PhpConsole.php');
PhpConsole::start();


class MyException extends Exception {
  public $file;
  public $line;
  public function errorHandler($errno, $errstr, $errfile, $errline) {
    $e = new self();
    $e->message = $errstr;
    $e->code = $errno;
    $e->file = $errfile;
    $e->line = $errline;

		$f = fopen('Log/ELog.log','a+');
		fwrite($f,"".date('Y-m-d h:i:s')." | ".$e." \r\n");
		fclose($f);

	throw $e;
  }
}

//set_error_handler(array('MyException', 'errorHandler'), E_ALL);

try{

	$conexion = mssql_connect($_SESSION["CnxSER"],$_SESSION["CnxUSU"],$_SESSION["CnxPWD"]) or die("Error de conexión.");
	mssql_select_db($_SESSION["CnxBDD"],$conexion) or die("Error de selección de base de datos.");

}catch(Exception $e){
	
	exit;

}

/********************************************************************************************************/
/********************************************************************************************************/
/********************************************************************************************************/
	$CONTROL = 0;
	if(isset($xaptur)){ $CONTROL = $xaptur; }
	if($CONTROL == 0){
		$_SESSION['ParSQL'] = "
		SELECT C.NplVen AS PLA, D.FAP AS FAP, A.MTN, A.DES, A.INI, A.FIN FROM ATURNOSH AS A 
		INNER JOIN APARPOS AS B ON B.ID = '".$_SESSION['ParPOS']."'
		INNER JOIN VENDEDORES AS C ON C.CodVen = B.OPE
		INNER JOIN ATURNOSO AS D ON D.PLA = C.NplVen
		WHERE A.MTN = D.MTN";
		$ATURNOSH = mssql_query($_SESSION['ParSQL']) or die("Error SQL");	
		if(mssql_num_rows($ATURNOSH) == 0){
			?>
			<script>
				location.reload();
			</script>
			<?
		}
	}
/********************************************************************************************************/
/********************************************************************************************************/
/********************************************************************************************************/

function rollback($reg){

	$LOG = $_SESSION['ParSQL'];
	esclog(1,$LOG,"Sql");

		if(!isset($reg)){
			mssql_query("rollback transaction") or die("Error SQL rollback");
			esclog(1,$LOG,"rollback");
	    	exit;
		}

}

function esclog($QUE,$LOG,$ID){
	
	/*
	if($QUE == 1){
		$f = fopen('Log/NSql.log','a+');
		fwrite($f,"--> ".$LOG." --> ".date('Y-m-d h:m:s')." --> ".$ID."\r\n");
		fclose($f);
	}
	
	if($QUE == 2){
		$f = fopen('Log/NArt.log','a+');
		fwrite($f,"--> ".$LOG." --> ".date('Y-m-d h:m:s')." --> ".$ID."\r\n");
		fclose($f);
	}
	*/
	if($QUE == 3){
		$f = fopen('Log/Npro.log','a+');
		fwrite($f,"--> ".$LOG." --> ".date('Y-m-d h:m:s')." --> ".$ID."\r\n");
		fclose($f);
	}
	/*
	if($QUE == 4){
		$f = fopen('Log/ELog.log','a+');
		fwrite($f,"--> ".$LOG." --> ".date('Y-m-d h:m:s')." --> ".$ID."\r\n");
		fclose($f);
	}
	*/
	
}

function format($t,$d,$c,$p){
	$v = str_pad($t,$d,$c,$p);
	return $v;
} //format(variable,2,'0',STR_PAD_LEFT);

function redondeado($numero, $decimales){ 
	$factor = pow(10, $decimales); 
	return (round($numero*$factor)/$factor);
}

function dec($v,$d) {
	$v = str_replace(",", "",$v);
	$v = number_format($v, $d, ".", ",");
	$v = str_replace(",", "",$v);
    return $v;
}

	/*
	function esccom($linea1,$linea2){
			
		$valor1 = substr($linea1, 0, 20).str_repeat(" ",20 - strlen(substr($linea1, 0, 20)));
		$valor2 = substr($linea2, 0, 20).str_repeat(" ",20 - strlen(substr($linea2, 0, 20)));
					
		$com = "COM1:";
		
		`mode $com: BAUD=9600 PARITY=N data=8 stop=1 xon=off`;
		$fp = fopen ($com, "w+");
		if(!$fp){
			//echo "Uh-oh. Port not opened.";
			fclose ($fp);
		}else{
			fputs ($fp, $valor1);
			fputs ($fp, $valor2);
			fclose ($fp);
		}
	
	}
	*/




?>