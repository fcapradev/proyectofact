<?
//session_start();
if(isset($_REQUEST['f'])){
	
	require("cnx.php");
	
	try{

	
		$SQL = "UPDATE APARPOS SET FON = ".$_REQUEST['f']." WHERE ID = ".$_SESSION["ParPOS"];
		$updatefon = mssql_query($SQL) or die("Error SQL");
		
		$_SESSION['ParFON'] = $_REQUEST['f'];

			
	}catch(Exception $e) {
	
		?>
		<script>
			jAlert('El sistema se encuntra mal configurado.', 'Debo Retail - Global Business Solution');
		</script>
		<?
	exit;
	
	}
	
}


if(isset($_FILES['upfile'])){

	require("cnx.php");
	
	try{


		$max = 1500000;
		
		$filesize = $_FILES['upfile']['size'];
		$filename = trim($_FILES['upfile']['name']);
		$tipo = $_FILES["upfile"]['type'];
		$archivo = $_FILES["upfile"]['name'];

		if($filesize < $max){
			
			if(($tipo == "image/png") || ($tipo == "image/PNG") || ($tipo == "image/jpg") || ($tipo == "image/jpeg")){
				
				$destino =  "../images/fondo5.png";
				if (copy($_FILES['upfile']['tmp_name'],$destino)) {

					header('Location: ../index.php?estado=1');	
				} else {
					header('Location: ../index.php?estado=2');	
				}
			}else{
				header('Location: ../index.php?estado=3');	
			}
		}else{
			header('Location: ../index.php?estado=4');	
		}

		
/*
		if($filesize < $max){
			if($filesize > 0){ 
				debug($directorio,"DIRE");
				if (move_uploaded_file("fondo5.png", "../imagen/")) {
					debug("CARGO");
					header('Location: ../index.php');
				} else {
					debug("NO CARGO");
					?>
					<script>
						jAlert('Error, reintente luego.', 'Debo Retail - Global Business Solution');
					</script>
					<?
					header('Location: ../index.php');					
				}

			}else{
				debug("NO HAY IMAGEN");
				?>
				<script>
					jAlert('Campo vac&iacute;o, no ha seleccionado ninguna imagen.', 'Debo Retail - Global Business Solution');
				</script>
				<?
				header('Location: ../index.php');				
			}
		}else{
			debug("IMG GRANDE");
			?>
			<script>
				jAlert('La imagen que ha intentado adjuntar es mayor de 1.5 Mb, si desea cambie el tamaño de la imágen y vuelva a intentarlo.', 'Debo Retail - Global Business Solution');
			</script>
			<?				
			header('Location: ../index.php');
		}
		
*/		
	}catch(Exception $e) {
	
		?>
		<script>
			jAlert('El sistema se encuntra mal configurado.', 'Debo Retail - Global Business Solution');
		</script>
		<?
	exit;
	
	}
	
}
?>