<?php
if(isset($_POST['usua'])){

	if(isset($_POST['cont'])){
	
	require("cnx.php");
		
		$idsusua = $_POST['usua'];
		$idscont = $_POST['cont'];
			
		$SQL = "SELECT CODVEN FROM VENDEDORES WHERE CLAVEN = '".$idscont."' AND CODVEN = '".$idsusua."'";
		$registros = mssql_query($SQL) or die("Error SQL");

		if(mssql_num_rows($registros) == 0){
			
			?>
			<script>
	
				jAlert('Por favor, Verifique Usuario y/o Contrase&ntilde;a.', 'Debo Retail - Global Business Solution');
				Vol_Usu();
				
			</script>
			<?
			
		}else{

			$SQL = "SELECT EST,NOMVEN FROM VENDEDORES WHERE CODVEN = '".$idsusua."'";
			$registros = mssql_query($SQL) or die("Error SQL");
			while ($reg=mssql_fetch_array($registros)){
				$EST = $reg['EST'];
				$idsusun = trim($reg['NOMVEN']);
			}
			mssql_free_result($registros);
			if($EST == 1){
				
				?>
				<script>
					
					jAlert('El operario NO se encuentra habilitado.', 'Debo Retail - Global Business Solution');
					Vol_Usu();
					
				</script>
				<?
			
			}else{		
				
				$idscont = md5(md5('FOCA SOFTWARE'.$idscont));
				setcookie('idsusua',$idsusua,time()+86400,"/");
				setcookie('idsusun',$idsusun,time()+86400,"/");	
				setcookie('idscont',$idscont,time()+86400,"/");
				
				?>
                <script>

				function cerrartimer2(){ 
					location.reload();
					clearTimeout(timer2);
				}
					EnvError('<br /><b style="color:#FF0000">En unos segundos será redirigido al sistema. Gracias.</b>');
					timer2 = setTimeout("cerrartimer2();", 2000);
					
				</script>

                <?
				
			}

		}
		
	}
	
}