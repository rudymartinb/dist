<?php 
// ordprod_nueva.php

	require_once( "config.php" );
	require_once( $DIST.$LIB."/SQL.php" );
	require_once( $DIST.$CLASS."/cProducto.php" );
	require_once( $DIST.$CLASS."/cAgendaEntrega.php" );
	require_once( $DIST.$LIB."/fechas.php" );
	require_once( $DIST.$CLASS."/cAgendaListaDoble.php" );

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

		.renglonagenda {
			clear:both;
			floar:none;
		}
		.cabeceracol {
			font-family:tahoma;
			font-weight:bold;
			font-size:14px;
			border:1px;
			float:left;
			min-width:50px;
		}
		.col0 {
			border:1px;
			width:50px;
		}
		.col1{
			border:1px;
			width:350px;
		}
		.col2{
			border:1px;
			width:50px;
		}
		.col3{
			border:1px;
			width:150px;
			text-align:left;
		}
		.col4{
			border:1px;
			width:70px;
			text-align:right;
		}
		.col5{
			border:1px;
			width:70px;
			text-align:right;
		}
		.col6{
			border:1px;
			width:70px;
			text-align:right;
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


		<?php

		/* generar listado clientes y productos.
		*/
		$post = $_POST;
		if( $post != null ){
			$periodo = $post['periodo'];
			?>
			<div class='admitem'>Periodo: <?=$periodo?></div>
			<?php
			
			$db = SQL_Conexion();
			
			$web = new cAgendaListaDoble();
			$web->db = $db;
			$web->periodo = $periodo;
			
			$res = $web->ArmarLista();
			$res = $web->RenderHTML( $periodo );
			echo $res;
			
		}

		?>
		<div>&nbsp;</div>


		<hr>
		<div class="admitem"><a href='index.php'  >Volver al menú principal</a></div>
		<hr>




	</body>
</html>
