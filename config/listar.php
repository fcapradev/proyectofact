<?php

/*
$directorio = opendir("../botones");
while ($archivo = readdir($directorio)){
	echo '"'.'botones/'.$archivo.'", ';
}
closedir($directorio); 
*/


/*
$directorio = opendir("../teclado/Letras");
while ($archivo = readdir($directorio)){
	echo '"'.'teclado/Letras/'.$archivo.'", ';
}
closedir($directorio);
*/


/*
$directorio = opendir("../teclado/numeros");
while ($archivo = readdir($directorio)){
	echo '"'.'teclado/numeros/'.$archivo.'", ';
}
closedir($directorio); 
*/


$directorio = opendir("../PanPrin");
while ($archivo = readdir($directorio)){
	echo '"'.'PanPrin/'.$archivo.'", ';
}
closedir($directorio); 


?>