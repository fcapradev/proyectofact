<table border="1">
<tr><td><div align="center" style="color:#0000FF">COOKIE</div></td><td><div align="center" style="color:#0000FF">Valor</div></td></tr>
<?
foreach ($_COOKIE as $k => $v){
    echo "<tr><td>".$k."</td><td>" . $v . "</td></tr>";
}
echo ""
?>
</table>