<?php 

	/*
	11:58 03/06/2014
	CUAL ES EL PLAN
	pide periodo
	luego muestra la lista de clientes y 
	un resumen indicando la cant de prod asignados y cantidades

	desde ahi mismo permite elegir cliente y producto.
	*/

	include_once( "config.php" );
	include_once( $DIST.$LIB."/SQL.php" );
	include_once( $DIST.$CLASS."/cProducto.php" );

	$periodoactual = date( "Ym" );

?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html>
	<head>
		<title>EL POPULAR » Agenda Produccion</title>
		<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
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

				$("#fec").focus();

			});
		</script>
	</head>	
	<body style='background-color:white;'>
		<hr>
		<div id="admtitulo">Agenda Produccion</div>



		<hr>
		<form name="input" action="AgendaProduccion2.php" method="post">

			<div class="admitem">Periodo:</div>
			<input class="adminput" type=text value="<?php echo $periodoactual ?>" id="periodo" name="periodo">
			<div class="admmensa">Escriba el periodo a generar en formato AAAAMM</div>
			
			<hr>	
			<input class="adminput" type="submit" value="Aceptar" id="OK">
		</form>
		<hr>
		<div class="admitem"><a href='index.php'  >Volver al menú principal</a></div>
		<hr>

	</body>
</html>