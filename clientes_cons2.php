<?php

include_once( "config.php" );
include_once( $DIST.$LIB."/SQL.php" );
include_once( $DIST.$CLASS."/cClientes.php" );

?>

<!DOCTYPE HTML PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html>

<head>
<title>EL POPULAR � Clientes Consulta</title>
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
<div id="admtitulo">Clientes Consulta</div>


<?php


if( isset( $_GET ) ){
	// 
	if( count( $_GET ) >0  ){
		// var_dump( $_POST );
		$post = $_GET;
		$db = SQL_Conexion();
		$cod = $post['cod'];
				
		$cli = new cClientes();
		$cli->db = $db;
		$cli->cod = strtoupper( $cod );
		if( ! $cli->Leer() ){
			echo "Codigo de Cliente $cod no encontrado (Detalle: $cli->DetalleError)";
			return false;
		};
	
		$raz = $cli->raz;
		$dom = $cli->dom;
		$loc = $cli->loc;
		$cpo = $cli->cpo;
		$tel = $cli->tel;
		$gan = $cli->gan;
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


	<div class="admitem">Codigo:</div>
	<input class="adminput" type=text value="<?php echo $cod;?>" id="codcli" name="cod"  >
	<div class="admmensa"></div>
	
	<div class="admitem">Razon Social:</div>
	<input class="adminput" type=text value="<?php echo $raz;?>" id="razcli" name="raz">
	<hr>

	<div class="admitem">Domicilio:</div>
	<input class="adminput" type=text value="<?php echo $dom;?>" id="domcli" name="dom">
	<hr>

	<div class="admitem">Localidad:</div>
	<input class="adminput" type=text value="<?php echo $loc;?>" id="loccli" name="loc">
	<hr>

	<div class="admitem">Cod. Postal:</div>
	<input class="adminput" type=text value="<?php echo $cpo;?>" id="cpocli" name="cpo">
	<hr>

	<div class="admitem">Telefono:</div>
	<input class="adminput" type=text value="<?php echo $tel;?>" id="telcli" name="tel">
	<hr>
	
	<div class="admitem">Ganancia:</div>
	<input class="adminput" type=text value="<?php echo $gan;?>" id="gancli" name="gan">
	<hr>	
	
	
<hr>
<div class="admitem"><a href='index.php'  >Volver al men� principal</a></div>
<hr>




</body>
</html>
