<?php

include_once( "config.php" );
include_once( $DIST.$LIB."/SQL.php" );
include_once( $DIST.$CLASS."/cProducto.php" );

?>

<!DOCTYPE HTML PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html>

<head>
<title>EL POPULAR » Producto Modificacion</title>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<style>
#admtitulo{
	font-family:courier new;
	font-weight:bold;
	text-align:left;
	font-size:28px;
	color:black;
	padding:1px;
	border:5px;width:100%;
}

#admtitulo2{
	font-family:courier new;
	font-weight:bold;
	text-align:left;
	font-size:24px;
	color:black;
	padding:1px;
	border:5px;width:100%;
}

.admitem {
	font-family:courier new;
	font-weight:bold;
	text-align:left;
	font-size:18px;
	color:black;
	padding:1px;
	border:5px;width:100%;
}

</style>
<link href="css/base.css" rel="stylesheet" type="text/css" />
<script type="text/javascript" src="http://ww.elpopular/js/jquery-1.9.0.js"></script>
<script type="text/javascript" >
$(document).ready(function(){

$("#razcli").focus();

});
</script>
</head>	
<?php // 
?>
<body style='background-color:white;'>
<hr>
<div id="admtitulo">Producto Modificacion</div>

<hr>
<div class="admitem"><a href='index.php'  >Volver al menú principal</a></div>
<hr>

<?php


if( isset( $_POST ) ){
	// 
	if( count( $_POST ) >0  ){
		// var_dump( $_POST );
		$post = $_POST;
		$db = SQL_Conexion();
		$cod = $_POST['cod'];
				
		$o = new cProducto();
		$o->db = $db;
		$o->cod = strtoupper( $cod );
		if( ! $o->Leer() ){
			echo "Codigo de Producto no encontrado (Detalle: $o->DetalleError)";
			return false;
		};
	
		// $o->des = strtoupper( $dom );
		// $o->abr = strtoupper( $abr );
		// $o->lun = strtoupper( $lun );
		// $o->mar = ( $mar );
		// $o->mie = ( $mie );
		// $o->jue = ( $jue );
		// $o->vie = ( $vie );
		// $o->sab = ( $sab );
		// $o->dom = ( $dom );
		// $o->controlpapelusado = ( $ctl );
		// $o->precio = ( $pre );
		
		$des = $o->des;
		$abr = $o->abr;
		// if( $o->lun ) {
			// $lun = "checked";
		// };
		// if( $o->mar ) {
			// $mar = "checked";
		// };
		// if( $o->mie ) {
			// $mie = "checked";
		// };
		// if( $o->jue ) {
			// $jue = "checked";
		// };
		// if( $o->vie ) {
			// $vie = "checked";
		// };
		// if( $o->sab ) {
			// $sab = "checked";
		// };
		// if( $o->dom ) {
			// $dom = "checked";
		// };
		if( $o->controlpapelusado ) {
			$ctl = "checked";
		};		

		// $pre = $o->precio;
		// $pre1 = $o->precio1;
		// $pre2 = $o->precio2;
		// $pre3 = $o->precio3;
		// $pre4 = $o->precio4;
		// $pre5 = $o->precio5;
		// $pre6 = $o->precio6;
		// $pre7 = $o->precio7;
		// var_dump( $cli );
	} else {
		return false;
	}
} else {
	/* falta redirigir ?
	*/
	return false;
}

?>
<hr>
<form name="input" action="productos_modi.php" method="post">

	<div class="admitem">Código:</div>
	<input class="adminput" type=text value="<?php echo $cod;?>" id="cod" name="cod">
	<div class="admmensa">Escriba el código de tres dígitos a utilizar</div>
	
	<div class="admitem">Descripción:</div>
	<input class="adminput" type=text value="<?php echo $des;?>" id="des" name="des">
	<div class="admmensa">Escriba la Descripción correspondiente</div>
	<hr>

	<div class="admitem">Abreviatura:</div>
	<input class="adminput" type=text value="<?php echo $abr;?>" id="abr" name="abr">
	<div class="admmensa">Escriba la Abreviatura</div>
	<hr>

	<div class="admitem">Control Papel:</div>
	<input class="adminput" type="checkbox" value="true" id="ctl" name="ctl" <?php echo $ctl;?>>
	<div class="admmensa">Active la casilla para habilitar</div>
	<hr>
	
	
	<input class="adminput" type="submit" value="Modificar" id="OK">
</form>
<hr>
<div class="admitem"><a href='index.php'  >Volver al menú principal</a></div>
<hr>




</body>
</html>
