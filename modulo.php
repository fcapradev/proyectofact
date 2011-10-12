
        

<?php


require("config/cnx.php");
require("util/utiles.php");



$modulo = $_GET['modulo'];

$data = new sqldata();


$DIR = "modulo/".$modulo."/";
?>

<link href="<?=$DIR.$modulo?>.css" rel="stylesheet" type="text/css" />

<script type="text/javascript"><?php echo file_get_contents($DIR.$modulo.".js"); ?></script>

<?php


include($DIR."controller.php");
include($DIR."view.php");



?>


