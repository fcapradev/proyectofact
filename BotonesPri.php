<?php

/*
function esccomm($linea1,$linea2){
		
	$valor1 = substr($linea1, 0, 20).str_repeat(" ",20 - strlen(substr($linea1, 0, 20)));
	$valor2 = substr($linea2, 0, 20).str_repeat(" ",20 - strlen(substr($linea2, 0, 20)));
				
	$com = "COM1:";
	
	`mode $com: BAUD=9600 PARITY=N data=8 stop=1 xon=off`;
	$fp = fopen ($com, "w+");
	if(!$fp){
		//echo "Uh-oh. Port not opened.";
		fclose ($fp);
	}else{
		fputs ($fp, $valor1);
		fputs ($fp, $valor2);
		fclose ($fp);
	}

}

//esccomm("Bienvenido...","Aukon 2.0");
*/

for ($i = 1 ; $i <= 24 ; $i ++) {

switch($i){
   
	case 1:
	  $r = "ab-tur";
	  $t = "Abrir Turno";
	  break;
	case 2:
	  $r = "fac";
	  $t = "Facturar";
	  break;
	case 3:
	  $r = "cer-tur";
	  $t = "Cerrar Turno";
	  break;
	case 4:
	  $r = "che";
	  $t = "Cheques";
	  break;
	case 5:
	  $r = "tar";
	  $t = "Tarjetas";
	  break;
	case 6:
	  $r = "ret-efe";
	  $t = "Retiro De Efectivo";
	  break;
	case 7:
	  $r = "caj";
	  $t = "Caja";
	  break;
	case 8:
	  $r = "pro";
	  $t = "Productos";
	  break;
	case 9:
	  $r = "com";
	  $t = "Compras";
	  break;
	case 10:
	  $r = "cta-cte";
	  $t = "Cuentas_Corrientes";
	  break;
	case 11:
	  $r = "per-ope";
	  $t = "Permisos Operarios";
	  break;
	case 12:
	  $r = "mov";
	  $t = "Movimientos";
	  break;
	case 13:
      $r = "cip";
	  $t = "C.I.P.";
	  break;
	case 14:
	  $r = "tic-emi";
	  $t = "Tickets Emitidos";
	  break;
	case 15:
	  $r = "gas";
	  $t = "Gastos";
	  break;
	case 16:
	  $r = "cli";
	  $t = "Clientes";
	  break;
	case 17:
	  $r = "mov-sto";
	  $t = "Toma De Imventario";
	  break;
	case 18:
	  $r = "car-inv";
	  $t = "Carga De Inventario";
	  break;
	case 19:
	  $r = "anu";
	  $t = "Anulación";
	  break;
	case 20:
	  $r = "arq-caj";
	  $t = "Arqueo De Caja";
	  break;
	case 21:
	  $r = "nov";
	  $t = "Novedades";
	  break;
	case 22:
	  $r = "rec";
	  $t = "Recuento";
	  break;
	case 23:
	  $r = "sal";
	  $t = "Salir";
	  break;
	case 24:
	  $r = "facm";
	  $t = "Facturador Manual";
	  break;  
	  
}


$ii = $i;

if($i == 10 or $i == 11 or $i == 16 or $i == 19 or $i == 8){
	
}else{
	

if($i == 15){ $ii = 10; }

if($i == 22){ $ii = 16; }

if($i == 4) { $ii = 11; }

if($i == 3) { $ii = 4;  }

if($i == 24){ $ii = 3;  }

if($i == 5) { $ii = 8;  }

if($i == 7) { $ii = 5;  }

if($i == 20){ $ii = 7;  }

if($i == 21){ $ii = 15; }

$ww = 70; $hh = 50;

if($i == 23){ $ww = 55; $hh = 36; }

echo "<div id=\"boton".$ii."\" class=\"PosDiv\">";
echo "<button class=\"StyBoton\" id=\"AccBotPriDis".$i."\" onclick=\"AccBotPri(".$i.")\" onmouseout=\"MM_swapImgRestore()\" onmouseover=\"MM_swapImage('Image".$i."','','PanPrin/".$r."-over.png',0)\">";
echo "<img src=\"PanPrin/".$r."-up.png\" name=\"".$t."\" title=\"".$t."\" border=\"0\" id=\"Image".$i."\" width=\"".$ww."\" height=\"".$hh."\"/></button>";
echo "</div>";

}

}
?>
<script>
	SoloBlock("ProcesoSusp");
</script>