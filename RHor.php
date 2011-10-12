<?

$ENTRO = 1;

require("config/cnx.php");
	
$ap = $_REQUEST['ap'];

if($ap != 0){

	$SQL = "SELECT * FROM ATURNOSH where MTN = ".$ap."";
	$registros = mssql_query($SQL) or die("Error SQL");
		
	if(mssql_num_rows($registros) == 0){
		
		?>
		<script>
			$("#AperturaTurno").load("AperturaTurno.php?co=1");
			jAlert('No existe el horario solicitado.', 'Debo Retail - Global Business Solution');
		</script>    
		<?
		exit;
		
	}else{
	
		?>
		<script>
			$("#AperturaTurno").load("AperturaTurno.php?co=0&ap=<? echo $ap; ?>");
		</script>    
		<?
		exit;
	
	}
	
}	
?>