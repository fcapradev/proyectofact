<?php

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

if(isset($_COOKIE['ids'])){

	$b = 'config/'.md5(md5('FOCA SOFTWARE'.$_COOKIE['ids']));
	if(file_exists($b)){
		
		$archivo = file($b);
		$lineas = count($archivo);
		
		for($i=0; $i < $lineas; $i++){ 
			$datos = decrypt($archivo[$i]);
		} 
		
		$datos = explode(",",$datos);

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
				fwrite($f,"".date('Y-m-d h:m:s')." | ".$e." \r\n");
				fclose($f);
		
			throw $e;
		  }
		  
		}
		set_error_handler(array('MyException', 'errorHandler'), E_ALL);
		
		try{
			
			/////////////////////////////////////////////////////////////////////////////////////////////////////////
			$conexion = mssql_connect($servidor,$usuario,$pwd) or die("Error de conexión."); ////////////////////////
			mssql_select_db($basededatos,$conexion) or die("Error de selección de base de datos."); /////////////////
			/////////////////////////////////////////////////////////////////////////////////////////////////////////
			
		$_SESSION["ids"] = $_COOKIE['ids'];		
		
		if(isset($_COOKIE['idsusua'])){
			$_SESSION["idsusua"] = $_COOKIE['idsusua'];
			$_SESSION["idsusun"] = $_COOKIE['idsusun'];
			$_SESSION["idscont"] = $_COOKIE['idscont'];
		}
		
		$_SESSION["ParEMPDEB"] = $coddebo;
		$_SESSION["ParEMP"] = $empresa;
		$_SESSION["ParPOS"] = $terminal;           // ESTE PARAMETRO ES EL TERMINAL
		$_SESSION["ParPOSMa"] = $terminal + 10000; // ESTE PARAMETRO ES EL TERMINAL MANUAL
		$_SESSION["ParPATH"] = $caminolocal;
		
		$_SESSION["CnxPUE"] = $puerto;
		$_SESSION["CnxSER"] = $servidor;
		$_SESSION["CnxBDD"] = $basededatos;
		$_SESSION["CnxUSU"] = $usuario;
		$_SESSION["CnxPWD"] = $pwd;
		
		$_SESSION["lcontrol"] = $lcontrol;
		$_SESSION["itipovisor"] = $itipovisor;
		$_SESSION["ipuerto"] = $ipuerto;
		
		
		$_SESSION['ParSQL'] = "SQL";
		$_SESSION['ParFacSec'] = 0;
		///////////////////////////////////////////////////////////////////////////////////
		// PARA FAC
		///////////////////////////////////////////////////////////////////////////////////
		$_SESSION['ParOrn'] = 0;
		$_SESSION['ParCol'] = 0;
		
		mssql_query("DELETE TMAEFACT_T WHERE TER = ".$_SESSION["ParPOS"]."") or die("Error SQL: DELETE TMAEFACT_T");
		mssql_query("DELETE TMOVFACT_T WHERE TER = ".$_SESSION["ParPOS"]."") or die("Error SQL: DELETE TMOVFACT_T");
		mssql_query("DELETE AARTPRO_T WHERE TER = ".$_SESSION["ParPOS"]."") or die("Error SQL: DELETE AARTPRO_T");
		mssql_query("DELETE ACUPONES WHERE NTE = ".$_SESSION["ParPOS"]." AND NFA IN ('1','2')") or die("Error SQL: DELETE ACUPONES T");
		mssql_query("DELETE AFPAFACT WHERE TER = ".$_SESSION["ParPOS"]." AND SUC = 0 AND NCO = 0") or die("Error SQL: DELETE AFPAFACT");
		
		///////////////////////////////////////////////////////////////////////////////////
		// PARA FAC
		///////////////////////////////////////////////////////////////////////////////////
		///////////////////////////////////////////////////////////////////////////////////
		///////////////////////////////////////////////////////////////////////////////////
		// PARA FAC MANUAL
		///////////////////////////////////////////////////////////////////////////////////
		$_SESSION['ParOrnMa'] = 0;
		$_SESSION['ParColMa'] = 0;
		
		mssql_query("DELETE TMAEFACT_T WHERE TER = ".$_SESSION["ParPOSMa"]."") or die("Error SQL: DELETE TMAEFACT_T");
		mssql_query("DELETE TMOVFACT_T WHERE TER = ".$_SESSION["ParPOSMa"]."") or die("Error SQL: DELETE TMOVFACT_T");
		mssql_query("DELETE AARTPRO_T WHERE TER = ".$_SESSION["ParPOSMa"]."") or die("Error SQL: DELETE AARTPRO_T");
		mssql_query("DELETE ACUPONES WHERE NTE = ".$_SESSION["ParPOSMa"]." AND NFA IN ('1','2')") or die("Error SQL: DELETE ACUPONES T");
		mssql_query("DELETE AFPAFACT WHERE TER = ".$_SESSION["ParPOSMa"]." AND SUC = 0 AND NCO = 0") or die("Error SQL: DELETE AFPAFACT");
		
		///////////////////////////////////////////////////////////////////////////////////
		// PARA FAC MANUAL
		///////////////////////////////////////////////////////////////////////////////////
		///////////////////////////////////////////////////////////////////////////////////
		///////////////////////////////////////////////////////////////////////////////////
		// PARA COMPRAS
		///////////////////////////////////////////////////////////////////////////////////
		$_SESSION['ParOrnC'] = 0;
		
		mssql_query("DELETE PMAEFACT_T WHERE TER = ".$_SESSION["ParPOS"]."") or die("Error SQL: DELETE PMAEFACT_T");
		mssql_query("DELETE PMOVFACT_T WHERE TER = ".$_SESSION["ParPOS"]."") or die("Error SQL: DELETE PMOVFACT_T");
		///////////////////////////////////////////////////////////////////////////////////
		// PARA COMPRAS
		///////////////////////////////////////////////////////////////////////////////////


		///////////////////////////////////////////////////////////////////////////////////
		// INICIO PARAMETROS DE LA TERMINAL
		///////////////////////////////////////////////////////////////////////////////////

		$SQL = "SELECT SEP, PMA, SNE, MINTSH, MINCSH, MINTPL, MINCPL, IVAG, IVAS, ARTVEN, VERSTK, IMP_ARQ, costo_pb FROM APARSIS";
		$registros = mssql_query($SQL) or die("Error SQL");
	
			if(mssql_num_rows($registros) == 0){
				?>
				<script>
					jAlert('Mal Configurado no hay registro en la TABLA APARSIS.', 'Debo Retail - Global Business Solution');
				</script>    
				<?
				exit;
			}

		while ($reg=mssql_fetch_array($registros)){
		
			$_SESSION['ParSEP'] = $reg['SEP'];
			$_SESSION['ParPMA'] = $reg['PMA'];
			$_SESSION['ParSNE'] = $reg['SNE'];
			$_SESSION['ParMINTSH'] = $reg['MINTSH'];
			$_SESSION['ParMINCSH'] = $reg['MINCSH'];
			$_SESSION['ParMINTPL'] = $reg['MINTPL'];
			$_SESSION['ParMINCPL'] = $reg['MINCPL'];
			$_SESSION['ParIVAG'] = $reg['IVAG'];
			$_SESSION['ParIVAS'] = $reg['IVAS'];
			$_SESSION['ParARTVEN'] = $reg['ARTVEN'];
			$_SESSION['ParVERSTK'] = $reg['VERSTK'];
			$_SESSION['ParIMPARQ'] = $reg['IMP_ARQ'];
			
			$_SESSION['ParCosto_Pb'] = $reg['costo_pb'];

		}
		mssql_free_result($registros);
		
		///////////////////////////////////////////////////////////////////////////////////		 		
		
		$SQL = "SELECT ID,NOM,PVE,EJE,TER_TOUCH,FON FROM APARPOS WHERE ID = '".$_SESSION["ParPOS"]."'";
		$registros = mssql_query($SQL) or die("Error SQL");
	
			if(mssql_num_rows($registros) == 0){
				?>
				<script>
					jAlert('Mal Configurado no hay registro en la TABLA APARPOS', 'Debo Retail - Global Business Solution');
				</script>    
				<?
				exit;
			}

		while ($reg=mssql_fetch_array($registros)){
		
			$_SESSION['ParPOS'] = $reg['ID'];
			$_SESSION['ParPOSNOM'] = $reg['NOM'];
			$_SESSION['ParPV'] = $reg['PVE'];
			$_SESSION['ParEJE'] = $reg['EJE'];
			$_SESSION['ParFON'] = $reg['FON'];
			
		}
		mssql_free_result($registros);
		
		///////////////////////////////////////////////////////////////////////////////////

		$SQL = "SELECT PVE, DES FROM APARPVE WHERE PVE = '".$_SESSION["ParPV"]."'";
		$registros = mssql_query($SQL) or die("Error SQL");
	
			if(mssql_num_rows($registros) == 0){
				?>
				<script>
					jAlert('Mal Configurado no hay registro en la TABLA APARPOS', 'Debo Retail - Global Business Solution');
				</script>    
				<?
				exit;
			}

		while ($reg=mssql_fetch_array($registros)){
		
			$_SESSION['ParPV'] = $reg['PVE'];
			$_SESSION['ParPVN'] = $reg['DES'];

		}
		mssql_free_result($registros);
		
		///////////////////////////////////////////////////////////////////////////////////
				
		$SQL = "SELECT SEP,LUG,DCC,CRE FROM APARFAC WHERE ID = '".$_SESSION["ParPOS"]."'";
		$registros = mssql_query($SQL) or die("Error SQL");
	
			if(mssql_num_rows($registros) == 0){
				?>
				<script>
					jAlert('Mal Configurado no hay registro en la TABLA APARFAC', 'Debo Retail - Global Business Solution');
				</script>    
				<?
				exit;
			}

		while ($reg=mssql_fetch_array($registros)){
	
			$_SESSION['ParSEP'] = $reg['SEP'];
			$_SESSION['ParLUG'] = $reg['LUG'];
			$_SESSION['ParDCC'] = $reg['DCC'];
			$_SESSION['ParCRE'] = $reg['CRE'];
			
		}
		mssql_free_result($registros);
		
		///////////////////////////////////////////////////////////////////////////////////
		
		$SQL = "SELECT NOM, DIR, TEL, LIST_DEFECTO FROM APAREMP WHERE ZON = ".$_SESSION["ParEMP"];
		$registros = mssql_query($SQL) or die("Error SQL");
	
			if(mssql_num_rows($registros) == 0){
				?>
				<script>
					jAlert('Mal Configurado no hay registro en la TABLA APAREMP.', 'Debo Retail - Global Business Solution');
				</script>    
				<?
				exit;
			}

		while ($reg=mssql_fetch_row($registros)){
	
			$_SESSION['EMP01'] = $reg[0];
			$_SESSION['EMP02'] = $reg[1];
			$_SESSION['EMP03'] = $reg[2];
			$_SESSION['iListaBO'] = $reg[3];
			
		}
		mssql_free_result($registros);
		///////////////////////////////////////////////////////////////////////////////////
		
		if($_SESSION['lcontrol'] <> $_SESSION['ParPV']){
			?>
			<script>
				jAlert('El punto de venta de PARAMETROS y el del REGISTRO son DIFERENTES.', 'Debo Retail - Global Business Solution');
			</script>    
			<?
			exit;
		}
		
		///////////////////////////////////////////////////////////////////////////////////
		// FIN PARAMETROS DE LA TERMINAL
		///////////////////////////////////////////////////////////////////////////////////
		
			?>
			<script>
				$("#LetAre").removeClass("sombrabor");
			</script>    
			<?
		
		}catch(Exception $e) {
			
			?>
			<script>
				jAlert('El sistema se encuentra mal configurado.', 'Debo Retail - Global Business Solution');
			</script>
			<?
		exit;
		
		}

	}else{

		?>
		<script>
			EnvError('<br /><b style="color:#FF0000">Faltan archivos de configuración.<br />Contáctese con la mesa de ayuda.<br />Puede volver a intentarlo haciendo clic <a href="#" onclick="vol_ide();">aquí.</a><br>Gracias.</b>');
		</script>	
		<?
		exit;
	
	}

}else{

	?>
	<script>
	
		function enviariden(){
				
			var let = document.getElementById("LetTex").value.length;
			if(let > 4){
				SoloNone("LetEnt");
				$("#codidenti").submit();
			}
			
		}

		EnvError('<b style="color:#FF0000">Debe habilitar las cookies para poder continuar.<br />Ingrese su codigo de identificacion.<br />Para habilitar el terminal.<br />Gracias.</b>');
	
		$("#LetTexDiv").css("border-color", "#F90");
		
		document.getElementById('LetTexDiv').innerHTML = '<form id="codidenti" name="codidenti" method="post" action="config/coo.php"><input type="text" name="LetTex" id="LetTex" style="outline-style:none; border-style:none; text-transform:uppercase; font-family:\'TPro\'; font-size:14px;" /></form>';

		document.getElementById('LetEnt').innerHTML = '<button id="botonentrar" class="StyBoton" onclick="enviariden();" onmouseout="MM_swapImgRestore()" onmouseover="MM_swapImage(\'LetEnttt\',\'\',\'botones/ent-over.png\',0)"><img src="botones/ent-up.png" name="Enter" title="Enter" border="0" id="LetEnttt"/></button>';

		EnvAyuda("Ingrese su codigo de identificacion.");
		
		SoloNone("LetSal, LetTer, NumVol");
		
		SoloBlock("ErrorConex, CarAyuda, fondotranspletras, TecladoLet, fondotranspnumeros, TecladoNum, LetEnt");
		
		$("#LetTex").focus();
		
	</script>	
	<?
	exit;

}

?>
