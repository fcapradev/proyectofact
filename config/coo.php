<?
if(isset($_POST['LetTex'])){
	
	$LetTex = strtoupper($_POST['LetTex']);
	setcookie('ids',$LetTex,time()+31536000,"/");

	?>
    <script>

	function cerrartimer1(){ 
		location.reload();
		clearTimeout(timer1);
	}
	
		EnvError('<br /><b style="color:#FF0000">En unos segundos será redirigido al sistema. Gracias.</b>');
		timer1 = setTimeout("cerrartimer1();", 2000);
		
	</script>
    <?
	
}