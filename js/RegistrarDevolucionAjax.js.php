<?php
include_once( "../config.php" );
$url = $AJAX."/ajaxRegistrarDevolucion.php";
?>
// <script>
/* RegistrarDevolucionAjax.js
*/
function RegistrarDevolucion( fecha, cliente, producto, cantidad ){
	var datos = { fecha:fecha, cli:cliente, prod:producto, cant:cantidad };
	return MandarAjax( "<?php echo $url ?>", datos );
}