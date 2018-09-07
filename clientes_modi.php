<?php

include_once( "config.php" );
include_once( $DIST.$LIB."/SQL.php" );
include_once( $DIST.$CLASS."/cClientes.php" );

?>

<!DOCTYPE HTML PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html>

<head>
<title>EL POPULAR » Clientes Modificación</title>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
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
<div id="admtitulo">Clientes Modificacion</div>


<?php
if( isset( $_POST ) ){
	// se supone q venimos de clientes_modi2.php
	
	// falta validacion de POST para asegurar que tenga todas las claves
	if( count( $_POST ) > 0  ){
		
		
		$post = $_POST;
		$db = SQL_Conexion();
		$cod = $_POST['cod'];
		$raz = $_POST['raz'];
		$dom = $_POST['dom'];
		$loc = $_POST['loc'];
		$cpo = $_POST['cpo'];
		$tel = $_POST['tel'];
		$gan = $_POST['gan'];
		$zon = $_POST['zona'];
		$gru = $_POST['gru'];
		
		$cli = new cClientes();
		$cli->db = $db;
		$cli->cod = strtoupper( $cod );
		$cli->raz = strtoupper( $raz );
		$cli->dom = strtoupper( $dom );
		$cli->loc = strtoupper( $loc );
		$cli->cpo = strtoupper( $cpo );
		$cli->tel = strtoupper( $tel );
		$cli->zona=  strtoupper( $zon );
		$cli->grupo=  strtoupper( $gru );
		
		$gan = floatval( $gan );
		if( is_int( $gan ) or is_float( $gan ) ){
			$cli->gan = $gan;
		} else {
			$cli->gan = 0;
		}
		
		if ( ! $cli->GrabarModi() ){
			echo "<hr>Ocurrio un error al intentar modificar: ". $cli->DetalleError;
			return false;
		}
		echo "<hr>Modificacion Grabada: ".$cod." : ".$raz;
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
<form name="input" action="clientes_modi2.php" method="post">

	<div class="admitem">Codigo:</div>
	<input class="adminput" type=text value="" id="codcli" name="cod">
	<div class="admmensa">Escriba el codigo del cliente a modificar</div>
	
	<hr>	
	
	<input class="adminput" type="submit" value="Aceptar" id="OK">
</form>
<hr>
<div class="admitem"><a href='index.php'  >Volver al menú principal</a></div>
<hr>




</body>
</html>
