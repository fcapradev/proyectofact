<?php
require('include/conexion.php');
require('include/funciones.php');
require('include/pagination.class.php');

$items = 8;
$page = 1;

if(isset($_GET['page']) and is_numeric($_GET['page']) and $page = $_GET['page'])
		$limit = " TOP ".(($page-1)*$items).",$items";
	else
		$limit = " TOP $items";

$CANT1 = (($page-1)*$items) + 1;
if($page == 1){
	$CANT2 = (($page-1)*$items) + 8;
}else{
	$CANT2 = (($page-1)*$items) + 8;
}

if(isset($_GET['q']) and !eregi('^ *$',$_GET['q'])){
		$q = sql_quote($_GET['q']); //para ejecutar consulta
		$busqueda = htmlentities($q); //para mostrar en pantalla

$sqlStr = "select * from (select * , row_number() OVER (order by DESBCO) as RowNumber from BANCOS  WHERE DESBCO LIKE '%$q%') Derived where RowNumber between ".$CANT1." and ".$CANT2."";
$sqlStrAux = "select count(*) as total from (select * , row_number() OVER (order by DESBCO) as RowNumber from BANCOS WHERE DESBCO LIKE '%$q%') Derived where RowNumber between 1 and 1000000000";


	}else{

$sqlStr = "select * from (select * , row_number() OVER (order by DESBCO) as RowNumber from BANCOS) Derived where RowNumber between ".$CANT1." and ".$CANT2."";		
$sqlStrAux = "select count(*) as total from (select * , row_number() OVER (order by DESBCO) as RowNumber from BANCOS) Derived where RowNumber between 1 and 1000000000";

	}
	
	
$aux = mssql_fetch_assoc(mssql_query($sqlStrAux,$link));
$query = mssql_query($sqlStr, $link);
?>	
<p>
<?php
		if($aux['total'] and isset($busqueda)){
				echo "{$aux['total']} Resultado".($aux['total']>1?'s':'')." que coinciden con tu b&uacute;squeda \"<strong>$busqueda</strong>\".";
			}elseif($aux['total'] and !isset($q)){
				echo "Total: {$aux['total']}";
			}elseif(!$aux['total'] and isset($q)){
				echo"No hay resultados que coincidan con tu b&uacute;squeda \"<strong>$busqueda</strong>\"";
			}
	?>
	</p>
	<?php 
		if($aux['total']>0){
			$p = new pagination;
			$p->Items($aux['total']);
			$p->limit($items);
			if(isset($q))
					$p->target("index.php?q=".urlencode($q));
				else
					$p->target("index.php");
			$p->currentPage($page);
			$p->show();
			
			echo "<table class=\"registros\" align=\"center\" width=\"420\" border=\"0\" cellpadding=\"0\" cellspacing=\"0\">";
			
			$r=0;
			while($row = mssql_fetch_assoc($query)){
			
			$ID = $row['ID'];
			$NOMBRE = $row['desbco'];	
			
		  echo "<tr class=\"row$r\">
				<td>
									
				<div style=\"cursor:pointer;\" onClick=\"enviarrespeve({$row['ID']})\">
					
					<table class=\"registros\" align=\"center\" width=\"420\" border=\"0\" cellpadding=\"1\" cellspacing=\"1\">
					<tr>
						<td>$NOMBRE</td>
					</tr>
					</table>
	
		    	</div>
				</td>
				
				</tr>\n";
		  
          if($r%2==0)++$r;else--$r;
        }
			echo "\t</table>\n";
		}
	?>