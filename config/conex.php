<?
class MyException extends Exception {
  public $file;
  public $line;
  public function errorHandler($errno, $errstr, $errfile, $errline) {
    $e = new self();
    $e->message = $errstr;
    $e->code = $errno;
    $e->file = $errfile;
    $e->line = $errline;
	throw $e;
  }
}
set_error_handler(array('MyException', 'errorHandler'), E_ALL);

set_time_limit(0);

try{

$servidor = str_replace("/", "\"", $servidor);

$conexion = mssql_connect($servidor,$usuario,$pwd) or die("Error de conexión.");
mssql_select_db($basededatos) or die("Error de selección de base de datos.");

} catch (Exception $e) {
	
	echo "
    <br />
    <b style='color:#FF0000'>Error en la conexion.</b>	
	<br />".$e."<br />
	";
	
exit;

}


echo "
<br />
<b style='color:#FF0000'>Archivos de configuración Correctos.</b>
<br />
<br />
";

?>