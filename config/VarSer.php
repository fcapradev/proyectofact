<?
session_start();

if(isset($_REQUEST['v'])){
	
	$v = (int)$_REQUEST['v'];
	
	if($v == 1){
		$_SESSION['ParFacSec'] = 1;
	}
	if($v == 2){
		$_SESSION['ParFacSec'] = 2;
	}
	
}

?>