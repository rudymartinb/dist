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

$("#codcli").focus();

});
</script>
</head>	
<body style='background-color:white;'>
<hr>
<div id="admtitulo">Producto Modificacion</div>


<?php
if( isset( $_POST ) ){
	// se supone q venimos de clientes_modi2.php
	if( count( $_POST ) >0  ){
		$post = $_POST;
		$db = SQL_Conexion();
		$cod = $_POST['cod'];
		$des = $_POST['des'];
		$abr = $_POST['abr'];
		$lun = $_POST['lun'];
		$mar = $_POST['mar'];
		$mie = $_POST['mie'];
		$jue = $_POST['jue'];
		$vie = $_POST['vie'];
		$sab = $_POST['sab'];
		$dom = $_POST['dom'];
		$ctl = $_POST['ctl'];
		$pre = $_POST['pre'];
		$gan = $_POST['gan'];
		$pre1 = $_POST['pre1'];
		$pre2 = $_POST['pre2'];
		$pre3 = $_POST['pre3'];
		$pre4 = $_POST['pre4'];
		$pre5 = $_POST['pre5'];
		$pre6 = $_POST['pre6'];
		$pre7 = $_POST['pre7'];
		
		$o = new cProducto();
		$o->db = $db;
		$o->cod = strtoupper( $cod );
		$o->des = strtoupper( $des );
		$o->abr = strtoupper( $abr );
		$o->lun = strtoupper( $lun );
		$o->mar = ( $mar );
		$o->mie = ( $mie );
		$o->jue = ( $jue );
		$o->vie = ( $vie );
		$o->sab = ( $sab );
		$o->dom = ( $dom );
		$o->controlpapelusado = ( $ctl );
		$o->precio = ( $pre );
		$o->precio1 = ( $pre1 );
		$o->precio2 = ( $pre2 );
		$o->precio3 = ( $pre3 );
		$o->precio4 = ( $pre4 );
		$o->precio5 = ( $pre5 );
		$o->precio6 = ( $pre6 );
		$o->precio7 = ( $pre7 );
		
		// $tipo = gettype( $gan );
		$gan = floatval( $gan );
		// echo gettype( $gan );
		if( is_int( $gan ) or is_float( $gan ) ){
			$o->gan = $gan;
		} else {
			$o->gan = 0;
		}
		
		if ( ! $o->GrabarModi() ){
			echo "<hr>Ocurrio un error al intentar modificar: ". $o->DetalleError;
			return false;
		}
		echo "<hr>Modificacion Grabada: ".$cod." : ".$des;
		// var_dump( $cli );
	} else {
		// return false;
	}
} else {
	/* falta redirigir ?
	*/
	// return false;
}

?>

<hr>
<form name="input" action="productos_modi2.php" method="post">

	<div class="admitem">Código:</div>
	<input class="adminput" type=text value="" id="cod" name="cod">
	<div class="admmensa">Escriba el código del cliente a modificar</div>
	
	<hr>	
	
	<input class="adminput" type="submit" value="Aceptar" id="OK">
</form>
<hr>
<div class="admitem"><a href='index.php'  >Volver al menú principal</a></div>
<hr>




</body>
</html>
