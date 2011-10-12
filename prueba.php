<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Documento sin título</title>
</head>

<body>
		<div class="fuente-che" id="bansel" style="position:absolute; top:102px; left:185px; height:13px;" align="center">
			<?
			
			require("config/cnx.php");
			
			$_SESSION['ParSQL'] = "SELECT ID, desbco FROM BANCOS ORDER BY ID";
			$RSBTABLA = mssql_query($_SESSION['ParSQL']) or die("Error SQL");
			rollback($RSBTABLA);
			?>
			<select class="fuente-che" id="bancosel" name="bancosel" style="border:0; width:154px; height:17px; background-color:#DD7927;">
                <option value="0">Buscar Banco</option>
                <?
                while ($r1=mssql_fetch_array($RSBTABLA)){
                    $ID = $r1['ID'];
                    $NOMBCO = $r1['desbco'];
                    ?>
                        <option value="<? echo $ID; ?>" style="width:152px;  height:13px; border:0;"><? echo $NOMBCO; ?></option>
                    <?	
                }
                ?>
   			</select>
		</div>
</body>
</html>