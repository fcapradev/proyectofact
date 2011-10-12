<?
session_start();

?>
<table border="1">
<tr><td><div align="center" style="color:#0000FF">Session</div></td><td><div align="center" style="color:#0000FF">Valor</div></td></tr>
<?
foreach ($_SESSION as $k => $v){
    echo "<tr><td>" . $k ."</td><td>" . $v . "</td></tr>";
}
echo ""
?>
</table>