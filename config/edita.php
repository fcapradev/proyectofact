<?
function T_Nom(){
	$a = "D".mt_rand(1,99999);
	if (file_exists($a)){
		T_Nom();
	}else{
   		return $a;
	}
}

function encrypt($string){
   $key = 'FOCA SOFTWARE';
   $result = '';
   for($i=0; $i<strlen($string); $i++) {
      $char = substr($string, $i, 1);
      $keychar = substr($key, ($i % strlen($key))-1, 1);
      $char = chr(ord($char)+ord($keychar));
      $result.=$char;
   }
   return base64_encode($result);
}

function decrypt($string){
   $key = 'FOCA SOFTWARE';
   $result = '';
   $string = base64_decode($string);
   for($i=0; $i<strlen($string); $i++) {
      $char = substr($string, $i, 1);
      $keychar = substr($key, ($i % strlen($key))-1, 1);
      $char = chr(ord($char)-ord($keychar));
      $result.=$char;
   }
   return $result;
}

if (isset($_POST['submit'])) {
	
	$archivoaeditar = $_POST['archivoaeditar'];
	
	$coddebo = $_POST['coddebo'];
	$empresa = $_POST['empresa'];
	$puerto = $_POST['puerto'];
	$servidor = $_POST['servidor'];
	$basededatos = $_POST['basededatos'];
	$usuario = $_POST['usuario'];
	$pwd = $_POST['pwd'];
	$terminal = $_POST['terminal'];
	$caminolocal = $_POST['caminolocal'];
	$lcontrol = $_POST['lcontrol'];
	$itipovisor = $_POST['itipovisor'];
	$ipuerto = $_POST['ipuerto'];

$texto = $coddebo.",".$empresa.",".$puerto.",".$servidor.",".$basededatos.",".$usuario.",".$pwd.",".$terminal.",".$caminolocal.",".$lcontrol.",".$itipovisor.",".$ipuerto;

	$nom = $_COOKIE['ids'];
	$ar = $archivoaeditar;
	
		if(isset($_COOKIE['ids'])){
			
			echo "Texto: ".$nom."<br />";
			echo "Texto des: ".$texto."<br />";
			echo "Texto enc: ".encrypt($texto)."<br />";
			
			$fp = fopen($ar,"w");
			fwrite($fp,encrypt($texto));
			fclose($fp);
			die;
			
		}else{
		
			exit("<br /><b style='color:#FF0000'>Debe habilitar las cookies para poder continuar. Contáctese con la mesa de ayuda.</b><br /><br />");
			
		}

die;

}

$ids = $_COOKIE['ids'];
$ar = md5(md5('FOCA SOFTWARE'.$ids));

echo "ids ----------> ".$ids."<br />";
echo "nombre -----> ".md5(md5('FOCA SOFTWARE'.$ids))."<br />";

if(file_exists($ar)){
	
	$archivo = file($ar);
	$lineas = count($archivo);
	
	for($i=0; $i < $lineas; $i++){ 
		$texto = decrypt($archivo[$i]); 
		//echo $texto;		
	} 
	
	$datos = explode(",",$texto);
	
	$coddebo = $datos[0];
	$empresa = $datos[1];
	$puerto = $datos[2];
	$servidor = $datos[3];
	$basededatos = $datos[4];
	$usuario = $datos[5];
	$pwd = $datos[6];
	$terminal = $datos[7];
	$caminolocal = $datos[8];
	$lcontrol = $datos[9];
	$itipovisor = $datos[10];
	$ipuerto = $datos[11];
	
	
?>


<form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post">

<input type="hidden" id="archivoaeditar" name="archivoaeditar" value="<? echo md5(md5('FOCA SOFTWARE'.$ids)); ?>" />

<table>
<tr>	
	<td>Codigo Debo:</td><td><input type="text" name="coddebo" value="<? echo $coddebo; ?>" /></td>
</tr>
<tr>
	<td>Empresa:</td><td><input type="text" name="empresa" value="<? echo $empresa; ?>" /></td>
</tr>
<tr>
	<td>Puerto:</td><td><input type="text" name="puerto" value="<? echo $puerto; ?>" /></td>
</tr>
<tr>
	<td>Servidor:</td><td><input type="text" name="servidor" value="<? echo $servidor; ?>" /></td>
</tr>
<tr>
	<td>Base De Datos:</td><td><input type="text" name="basededatos" value="<? echo $basededatos; ?>" /></td>
</tr>
<tr>
	<td>Usuario:</td><td><input type="text" name="usuario" value="<? echo $usuario; ?>" /></td>
</tr>
<tr>
	<td>Pwd:</td><td><input type="password" name="pwd" value="<? echo $pwd; ?>" /></td>
</tr>
<tr>
	<td>Terminal:</td><td><input type="text" name="terminal" value="<? echo $terminal; ?>" /></td>
</tr>
<tr>
	<td>Camino Local:</td><td><input type="text" name="caminolocal" value="<? echo $caminolocal; ?>" /></td>
</tr>
<tr>
	<td>L Control PVE:</td><td><input type="text" name="lcontrol" value="<? echo $lcontrol; ?>" /></td>
</tr>
<tr>
	<td>I Tipo Visor:</td><td><input type="text" name="itipovisor" value="<? echo $itipovisor; ?>" /></td>
</tr>
<tr>
	<td>I Puerto:</td><td><input type="text" name="ipuerto" value="<? echo $ipuerto; ?>" /></td>
</tr>
<tr>
	<td>&nbsp;</td><td><input type="submit" name="submit" value="Editar archivo de Conexion" /></td>
</tr>
</table>	
</form>
<?
}else{

	echo "<br /><b style='color:#FF0000'>Faltan archivos de configuración. Contáctese con la mesa de ayuda.</b><br /><br />";
}
?>