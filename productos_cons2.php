<?php

include_once( "config.php" );
include_once( $DIST.$LIB."/SQL.php" );
include_once( $DIST.$CLASS."/cProducto.php" );

?>

<!DOCTYPE HTML PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html>

<head>
<title>EL POPULAR » Productos Consulta</title>
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
<div id="admtitulo">Productos Consulta</div>
<hr>
<div class="admitem"><a href='index.php'  >Volver al menú principal</a></div>
<hr>


<?php


if( isset( $_GET ) ){
	// 
	if( count( $_GET ) >0  ){
		// var_dump( $_POST );
		$post = $_GET;
		$db = SQL_Conexion();
		$cod = $post['cod'];
				
		$o = new cProducto();
		$o->db = $db;
		$o->cod = strtoupper( $cod );
		if( ! $o->Leer() ){
			echo "Codigo de Producto $cod no encontrado (Detalle: $o->DetalleError)";
			return false;
		};
	
		$des = $o->des;
		$abr = $o->abr;
		if( $o->lun ) {
			$lun = "checked";
		};
		if( $o->mar ) {
			$mar = "checked";
		};
		if( $o->mie ) {
			$mie = "checked";
		};
		if( $o->jue ) {
			$jue = "checked";
		};
		if( $o->vie ) {
			$vie = "checked";
		};
		if( $o->sab ) {
			$sab = "checked";
		};
		if( $o->dom ) {
			$dom = "checked";
		};
		if( $o->controlpapelusado ) {
			$ctl = "checked";
		};		

		$pre = $o->precio;
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
	
	<div class="admitem">Descripción:</div>
	<input class="adminput" type=text value="<?php echo $des;?>" id="des" name="des">
	<hr>

	<div class="admitem">Abreviatura:</div>
	<input class="adminput" type=text value="<?php echo $abr;?>" id="abr" name="abr">
	<hr>

	<div class="admitem">Lunes:</div>
	<input class="adminput" type="checkbox" value="true" id="lun" name="lun" <?php echo $lun;?>>
	<hr>

	<div class="admitem">Martes:</div>
	<input class="adminput" type="checkbox" value="true" id="mar" name="mar" <?php echo $mar;?>>
	<hr>

	<div class="admitem">Miércoles:</div>
	<input class="adminput" type="checkbox" value="true" id="mie" name="mie" <?php echo $mie;?>>
	<hr>

	<div class="admitem">Jueves:</div>
	<input class="adminput" type="checkbox" value="true" id="jue" name="jue" <?php echo $jue;?>>
	<hr>
	
	<div class="admitem">Viernes:</div>
	<input class="adminput" type="checkbox" value="true" id="vie" name="vie" <?php echo $vie;?>>
	<hr>
	
	<div class="admitem">Sábado:</div>
	<input class="adminput" type="checkbox" value="true" id="sab" name="sab" <?php echo $sab;?>>
	
	<hr>

	<div class="admitem">Domingo:</div>
	<input class="adminput" type="checkbox" value="true" id="dom" name="dom" <?php echo $dom;?>>
	
	<hr>
	
	<div class="admitem">Control Papel:</div>
	<input class="adminput" type="checkbox" value="true" id="ctl" name="ctl" <?php echo $ctl;?>>
	
	<hr>
	
	<div class="admitem">Precio:</div>
	<input class="adminput" type=text value="<?php echo $pre;?>" id="pre" name="pre">
	
	<hr>	
	
	
</form>
	
<hr>
<div class="admitem"><a href='index.php'  >Volver al menú principal</a></div>
<hr>




</body>
</html>
