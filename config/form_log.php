	<br />
	<br />
	<br />
	<br />
<script>

$(document).ready(function(){
	$('#formulariousuario').submit(function() {
		$.ajax({
			type: 'POST',
			url: $(this).attr('action'),
			data: $(this).serialize(),
			success: function(data) {
				$('#enviodecoo2').html(data);
			}
		})        
		return false;
	});
})

$("#usuarioenform").css("border-color", "#F90");

</script>
<style>
.formlogin{
	background-color:transparent; 
	font-family: "TPro"; 
	font-size:12px;
	border:none; 
	color:#FFF; 
	outline-style:none; 
	border-style:none;
}
</style>

<div id="enviodecoo2"></div>

<form id="formulariousuario" name="formulariousuario" method="post" action="config/coo2.php">
    <table width="239" height="108" align="center" background="images/fonind.png" style="background-color:transparent; background-repeat:no-repeat; ">
    <tr>
    <td valign="bottom">
        <table width="224" align="center">
        <tr>
        <td background="images/usua.png" style="background-repeat:no-repeat;" width="218" height="21">
            <div align="right" id="usuarioenform" class="div-redondo" style="width:218px; height:22px; top:-5px; left:-2px; position:relative;">
                <input type="text" name="usua" id="usua" size="17" maxlength="8" class="formlogin" onkeypress="return ControlDeEventosUsu();" />
            </div>
        </td>
        </tr>
        <tr>
        <td background="images/cont.png" style="background-repeat:no-repeat;">
            <div align="right" id="contraenform" class="div-redondo" style="width:218px; height:22px; top:-5px; left:-2px; position:relative;">
                <input type="password" name="cont" id="cont" size="17" maxlength="8" class="formlogin" onkeypress="return ControlDeEventosCot();" onkeydown="return ControlDeEventosCotVol();" />
            </div>
        </td>
        </tr>
    
        </table>
    </td>
    </tr>
    </table>
</form>
<script>
	$("#usua").focus();
</script>