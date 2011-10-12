<?
session_start();
session_destroy();
session_unset();

setcookie('idsusua','',time()+86400,"/");
setcookie('idsusun','',time()+86400,"/");
setcookie('idscont','',time()+86400,"/");
?>