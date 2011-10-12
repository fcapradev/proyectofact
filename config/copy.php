<?

//copy("http://190.15.195.24/usuario/imagen/foca.PNG","foca.PNG");


//$FAP = "09/03/2011 12:36:58";
$FAP = date("d/m/Y H:i:s");

$fecha = substr($FAP, 0, 10);
$hora = substr($FAP, 11, 8);

echo "fecha: ".$fecha."<br />";
echo "hora: ".$hora."<br />";

?>