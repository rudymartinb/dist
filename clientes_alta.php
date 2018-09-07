<?php

	require_once( "config.php" );
	require_once( $DIST.$LIB."/SQL.php" );
	require_once( $DIST.$CLASS."/cClientes.php" );

?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html>
	<head>
		<title>EL POPULAR » Clientes Altas</title>
		<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
		<link href="css/base.css" rel="stylesheet" type="text/css" />
		<link href="clientes/clientes_alta.css" rel="stylesheet" type="text/css" />
		<script type="text/javascript" src="/js/jquery-3.2.1.min.js"></script>
	</head>	
	
	<body style='background-color:white;'>
		<script type="text/javascript" >
			$(document).ready(function(){
				$("#codcli").focus();
			});
		</script>
		
		<hr>
		<div id="admtitulo">Clientes Altas</div>
		<hr>
		<div class="admitem"><a href='index.php'  >Volver al menú principal</a></div>
		<hr>

		<?php
		if( isset( $_POST ) ){
			// 
			if( count( $_POST ) >0  ){
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
				$cli->zona = strtoupper( $zon );
				$cli->grupo = strtoupper( $gru );
				
				$gan = floatval( $gan );
				
				if( is_int( $gan ) or is_float( $gan ) ){
					$cli->gan = $gan;
				} else {
					$cli->gan = 0;
				}
				
				if ( ! $cli->GrabarAlta() ){
					echo "<hr>Ocurrio un error al intentar grabar: ". $cli->DetalleError;
					// return false;
				} else {
					echo "<hr>Datos grabados: ".$cod." : ".$raz;
				}
				// return false;
			}
		}

		?>
		
		<form name="input" action="clientes_alta.php" method="post">

			<div class="admitem">Codigo:</div>
			<input class="adminput" type=text value="" id="codcli" name="cod" maxlength="3">
			<div class="admmensa">Escriba el codigo de tres dígitos a utilizar</div>
			
			<div class="admitem">Razon Social:</div>
			<input class="adminput" type=text value="" id="razcli" name="raz" maxlength="200">
			<div class="admmensa">Escriba la Razon Social correspondiente</div>
			<hr>

			<div class="admitem">Domicilio:</div>
			<input class="adminput" type=text value="" id="domcli" name="dom" maxlength="100">
			<div class="admmensa">Escriba el domicilio</div>
			<hr>

			<div class="admitem">Localidad:</div>
			<input class="adminput" type=text value="" id="loccli" name="loc" maxlength="100">
			<div class="admmensa">Escriba el nombre de la Localidad</div>
			<hr>

			<div class="admitem">Cod. Postal:</div>
			<input class="adminput" type=text value="" id="cpocli" name="cpo" maxlength="10">
			<div class="admmensa">Escriba el código postal de la Localidad</div>
			<hr>

			<div class="admitem">Telefono:</div>
			<input class="adminput" type=text value="" id="telcli" name="tel" maxlength="20">
			<div class="admmensa">Escriba indique teléfono de contacto</div>
			<hr>

			<div class="admitem">Zona:</div>
			<input class="adminput" type=text value="" id="zona" name="zona" maxlength="2">
			<div class="admmensa">Escriba el código de la zona de distribuición</div>
			<hr>	
			
			<div class="admitem">Ganancia:</div>
			<input class="adminput" type=text value="" id="gancli" name="gan" maxlength="5">
			<div class="admmensa">Escriba el porcentaje de ganancia asignado</div>
			<hr>	

			<div class="admitem">Grupo:</div>
			<input class="adminput" type=text value="" id="grucli" name="gru" maxlength="3">
			<div class="admmensa">Escriba el codigo de grupo correspondiente</div>
			<hr>	
			
			<input class="adminput" type="submit" value="Agregar" id="OK">
		</form>
		<hr>
		<div class="admitem"><a href='index.php'  >Volver al menú principal</a></div>
		<hr>




	</body>
</html>