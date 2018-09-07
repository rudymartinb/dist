<?php
// este codigo sin cobertura de prueba

// <script src="https://code.jquery.com/jquery-1.12.4.js"></script>
// <link rel="stylesheet" href="/resources/demos/style.css">
error_reporting(E_ALL);
include_once( "config.php" );

// demasiado trivial como para requerir una prueba ?

function RenderMenu( $nombre, $opciones ){
	$html = "";
	
	$html .= '<li class="admtitulo2"><div>'.$nombre.'</div>';
	$html .= '<ul>';
	
	foreach( $opciones as $key => $value ){
			$html .= '<li class="admitem">';
			$html .= '<div>';
			$html .= '<a href='.$value['url'].'>'.$value['nombre'].'</a>';
			$html .= '</div>';
			$html .= '</li>';
		}
	$html .=  '</ul>';
	$html .=  '</li>';
	return $html;
}

?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html>
	<head>
		<title>EL POPULAR - Menú Distribución</title>
		<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
		
		<link href="css/base.css" rel="stylesheet" type="text/css" />
		<link href="css/head.css" rel="stylesheet" type="text/css" />
		<link rel="stylesheet" href="js//ui/1.12.1/jquery-ui.css">
		
		<script src="js/jquery-3.2.1.min.js"></script>
		<script src="js/ui/1.12.1/jquery-ui.js"></script>
	</head>	

	<body style='background-color:white;'>
		<hr>
			<div class="admtitulo">
				DISTRIBUCION (ver 2.0)
			</div>
		<hr>
		<ul id="menu">
		
		<?php
		

			$nombre = 'Clientes';
			$opciones = [];
			$opciones[] = [ 'nombre'=>'Altas de Clientes','url'=>'clientes_alta.php' ];
			$opciones[] = [ 'nombre'=>'Modif. Clientes','url'=>'clientes_modi.php' ];
			$opciones[] = [ 'nombre'=>'Consulta Clientes','url'=>'clientes_cons.php' ];
			echo RenderMenu( $nombre, $opciones );

			$nombre = 'Productos';
			$opciones = [];
			$opciones[] = [ 'nombre'=>'Altas de Productos','url'=>'productos_alta.php' ];
			$opciones[] = [ 'nombre'=>'Modif. Productops','url'=>'productos_modi.php' ];
			$opciones[] = [ 'nombre'=>'Consulta Productos','url'=>'productos_cons.php' ];
			$opciones[] = [ 'nombre'=>'Cambio de Precios','url'=>'cambioprecios.php' ];
			echo RenderMenu( $nombre, $opciones );

			$nombre = 'Producción';
			$opciones = [];
			$opciones[] = [ 'nombre'=> 'Agenda de Producción','url'=>'src/agendaproduccion/AgendaProduccion.php' ];
			$opciones[] = [ 'nombre'=> 'Tirada Diaria','url' => 'tiradadiaria.php'];
			$opciones[] = [ 'nombre'=> 'Reporte Producción','url'=>'reporteproduccion.php' ];
			$opciones[] = [ 'nombre'=> 'Consulta de Reporte Producción','url'=>'reporteproduccionconsulta.php' ];
			$opciones[] = [ 'nombre'=> 'Borrado de Reporte Producción','url'=>'reporteproduccionEliminar.php' ];
			echo RenderMenu( $nombre, $opciones );

			$nombre = 'Informes';
			$opciones = [];
			$opciones[] = [ 'nombre'=> 'Informe Detallado para Facturación', 'url'=>'/informes/facturacion/detallado.php' ];
			$opciones[] = [ 'nombre'=> 'Informe Detallado Notas de Crédito', 'url'=>'/informes/facturacion/detallado_nc.php' ];
			$opciones[] = [ 'nombre'=> 'Informe Mensual', 'url'=>'/informes/mensual/index.php' ];
			$opciones[] = [ 'nombre'=> 'Informe Circulacion Neta Mensual por Periodos', 'url'=>'/informes/mensualxp/index.php' ];
			echo RenderMenu( $nombre, $opciones );		

			$nombre = 'Tablas Básicas';
			$opciones = [];
			$opciones[] = [ 'nombre'=>'Altas Grupos de Clientes','url'=>'clientesgrupos_alta.php' ];
			$opciones[] = [ 'nombre'=>'Modif. Grupos Clientes','url'=>'clientesgrupos_modi.php' ];
			
			echo RenderMenu( $nombre, $opciones );
			
		?>
		</ul>
		<hr>

	</body>
</html>