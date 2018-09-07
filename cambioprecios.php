<?php
include_once( "config.php" );
include_once( $DIST.$LIB."/SQL.php" );
include_once( $DIST.$LIB."/forms.php" );
include_once( $DIST.$CLASS."/cProducto.php" );
include_once( $DIST."/cambioprecios_soporte.php" );
include_once( $DIST.$LIB."/cHTML.php" );

error_reporting(E_ALL);


$db = SQL_Conexion();
	


$p = new cHTML();

$p->head->titulo = "Cambio Precios";
$p->head->AddMeta( "http-equiv='Content-Type' content='text/html; charset=iso-8859-1'"  );
$p->head->AddCSS( "/css/base.css" );

$p->head->StyleAdd( "#admtitulo",     	  "font-family:courier new;font-weight:bold;text-align:left;font-size:28px;color:black;padding:1px;border:5px;width:100%;" );
$p->head->StyleAdd( "#admtitulo2",     	  "font-family:courier new;font-weight:bold;text-align:left;font-size:24px;color:black;padding:1px;border:5px;width:100%;" );
$p->head->StyleAdd( ".admitem",     	  "font-family:courier new;font-weight:bold;text-align:left;font-size:18px;color:black;padding:1px;border:5px;width:100%;" );

$p->head->StyleAdd( ".col1",     	  		"width:150px;float:left;font-family:courier new;" );
$p->head->StyleAdd( ".col2",     	  		"width:100px;float:left;font-family:courier new;" );
$p->head->StyleAdd( ".col3",     	  		"width:100px;float:left;font-family:courier new;" );
$p->head->StyleAdd( ".col4",     	  		"width:100px;float:left;font-family:courier new;" );
$p->head->StyleAdd( ".col5",     	  		"width:100px;float:left;font-family:courier new;" );
$p->head->StyleAdd( ".col6",     	  		"width:100px;float:left;font-family:courier new;" );
$p->head->StyleAdd( ".col7",     	  		"width:100px;float:left;font-family:courier new;" );
$p->head->StyleAdd( ".col8",     	  		"width:100px;float:left;font-family:courier new;" );
$p->head->StyleAdd( ".inputText",     	  	"width:50px;" );
$p->head->StyleAdd( ".couriernew",     	  	"font-family:courier new;" );
$p->head->StyleAdd( ".fs12",     	  		"font-size:12px;" );
$p->head->StyleAdd( ".fs14",     	  		"font-size:14px;" );
$p->head->StyleAdd( ".ClearBoth",     	  	"clear:both;" );
$p->head->StyleAdd( ".floatLeft",     	  	"float:left;" );
$p->head->StyleAdd( ".textoCentrado",     	"text-align:center;" );
$p->head->StyleAdd( ".textoDerecha",     	"text-align:right;" );
$p->head->StyleAdd( ".borde1",    		  	"border-style:solid;border-width:1px;" );
$p->head->StyleAdd( ".almanaqueCelda",    	"width:100px;height:70px;" );
$p->head->StyleAdd( ".almanaqueCeldaFDM", 	"width:100px;height:70px;" );
$p->head->StyleAdd( ".fondoGrisClaro", 		"background-color:lightgray;" );
$p->head->StyleAdd( ".fondoRosa", 			"background-color:#FF9999;" );
$p->head->StyleAdd( ".almanaqueRenglon",  	"clear:both;" );
// $p->head->StyleAdd( ".almanaqueTitulo",  "font-size:18;font-face:verdana;" );

$p->head->AddJS( "http://ww.elpopular/js/jquery-1.9.0.js" );


$p->head->AddJS( "/js/PadN.js" );
$p->head->AddJS( "/js/focus.js" );
$p->head->AddJS( "/js/MandarAjax.js.php" );
// $p->head->AddJS( "/resources/qunit-1.13.0.js" );
// $p->body->AddJS( "/js/cBrowse.js" );


// $p->head->AddJS( "/ajax/ajaxAlmanaqueDiaModi.js.php" );


/* generar listado clientes y productos.
*/
$post = $_POST;
if( $post != null ){

	if( CambioPreciosAltaPost( $db, $post ) ){
		/* se supone que estamos en modo agregado.
		indicar ultimo cambio registrado.
		*/
		
	
	}
	// $pack = $post['ref'];
	// $periodo = substr( $pack, 0, 6 );
	// $codcli  = substr( $pack, 6, 3 );
	// $codprod = substr( $pack, 9, 3 );
}


// $cli = new cClientes();
// $cli->db = $db;
// $cli->cod = $codcli;
// $cli->Leer();

$prod = new cProducto();
$prod->db = $db;
// $prod->cod = $codprod;
// $prod->Leer();


$p->body->DivOpen( "admtitulo", "titulo" );
$p->body->AddHTML( "Cambio de Precios" );
$p->body->DivClose( );

/* en este punto quiero generar una lista
con todos los cambios registrados.
*/
$lista = ListaCambiosPrecios( $db, "001" );
$p->body->DivOpen( "", "" );
	$p->body->DivOpen( "col1", "col1" ); $p->body->AddHTML( "Desde Fecha" ); $p->body->DivClose( );
	$p->body->DivOpen( "col2", "col2" ); $p->body->AddHTML( "Lun" ); $p->body->DivClose( );
	$p->body->DivOpen( "col3", "col3" ); $p->body->AddHTML( "Mar" ); $p->body->DivClose( );
	$p->body->DivOpen( "col4", "col4" ); $p->body->AddHTML( "Mie" ); $p->body->DivClose( );
	$p->body->DivOpen( "col5", "col5" ); $p->body->AddHTML( "Jue" ); $p->body->DivClose( );
	$p->body->DivOpen( "col6", "col6" ); $p->body->AddHTML( "Vie" ); $p->body->DivClose( );
	$p->body->DivOpen( "col7", "col7" ); $p->body->AddHTML( "Sab" ); $p->body->DivClose( );
	$p->body->DivOpen( "col8", "col8" ); $p->body->AddHTML( "Dom" ); $p->body->DivClose( );
	$p->body->DivOpen( "", "" ); $p->body->AddHTML( "&nbsp;" ); $p->body->DivClose( );

	foreach( $lista as $key => $value ){
		$p->body->DivOpen( "col1", "col1" ); $p->body->AddHTML( sql2fecha( $value['desdepre'] ) ); $p->body->DivClose( );
		$p->body->DivOpen( "col2", "col2" ); $p->body->AddHTML( number_format( $value['pre1'], 2) ); $p->body->DivClose( );
		$p->body->DivOpen( "col3", "col3" ); $p->body->AddHTML( number_format( $value['pre2'], 2) ); $p->body->DivClose( );
		$p->body->DivOpen( "col4", "col4" ); $p->body->AddHTML( number_format( $value['pre3'], 2) ); $p->body->DivClose( );
		$p->body->DivOpen( "col5", "col5" ); $p->body->AddHTML( number_format( $value['pre4'], 2) ); $p->body->DivClose( );
		$p->body->DivOpen( "col6", "col6" ); $p->body->AddHTML( number_format( $value['pre5'], 2) ); $p->body->DivClose( );
		$p->body->DivOpen( "col7", "col7" ); $p->body->AddHTML( number_format( $value['pre6'], 2) ); $p->body->DivClose( );
		$p->body->DivOpen( "col8", "col8" ); $p->body->AddHTML( number_format( $value['pre7'], 2) ); $p->body->DivClose( );
		$p->body->DivOpen( "", "" ); $p->body->AddHTML( "&nbsp;" ); $p->body->DivClose( );
	}

$p->body->DivClose( );
$p->body->AddHTML( "<hr>" );

// $p->body->DivOpen( "", "admitem" );
// $p->body->AddHTML( "Fecha: ". $fecha    );
// $p->body->DivClose( );

// $p->body->DivOpen( "", "admitem" );
// $p->body->AddHTML( "Cliente: ". $codcli." ".$cli->raz  );
// $p->body->DivClose( );

// $p->body->DivOpen( "", "admitem" );
// $p->body->AddHTML( "Producto: ". $codprod." ".$prod->des    );
// $p->body->DivClose( );



$self = $_SERVER["PHP_SELF"];
$p->body->AddHTML( '<form name="reporte" action="'.$self.'" method="post">' );

// $p->body->AddHTML( '<input type=hidden value="1" id="nrotiradas" name="nrotiradas" >' );
$txt = GenerarInput( "Producto", "codpro", "", 3, "codpro", "", "Escriba el codigo de producto" ); $p->body->AddHTML( $txt );
$txt = GenerarInput( "Desde Fecha", "fecha", "", 10, "fecha", "", "Escriba la fecha inicial de vigencia de los precios" ); $p->body->AddHTML( $txt );
$txt = GenerarInput( "Precio Lunes", "pre1", "", 10, "pre1", "", "Escriba el precio para el dia indicado" ); $p->body->AddHTML( $txt );
$txt = GenerarInput( "Precio Martes", "pre2", "", 10, "pre2", "", "Escriba el precio para el dia indicado" ); $p->body->AddHTML( $txt );
$txt = GenerarInput( "Precio Miércoles", "pre3", "", 10, "pre3", "", "Escriba el precio para el dia indicado" ); $p->body->AddHTML( $txt );
$txt = GenerarInput( "Precio Jueves", "pre4", "", 10, "pre4", "", "Escriba el precio para el dia indicado" ); $p->body->AddHTML( $txt );
$txt = GenerarInput( "Precio Viernes", "pre5", "", 10, "pre5", "", "Escriba el precio para el dia indicado" ); $p->body->AddHTML( $txt );
$txt = GenerarInput( "Precio Sábado", "pre6", "", 10, "pre6", "", "Escriba el precio para el dia indicado" ); $p->body->AddHTML( $txt );
$txt = GenerarInput( "Precio Domingo", "pre7", "", 10, "pre7", "", "Escriba el precio para el dia indicado" ); $p->body->AddHTML( $txt );

// $p->body->DivOpen( 'tiradas' );
// $p->body->DivClose();


$p->body->AddHTML( '<input class="adminput" type="submit" value="Registrar Cambio" id="OK">' );

$p->body->AddHTML( '</form>' );



$p->body->DivOpen( "", "admitem ClearBoth " );
$p->body->AddHTML( "<a href='index.php' class='ocultar'  >Volver al menú principal</a>" );
$p->body->DivClose( );


$res = $p->Render();
echo $res;
?>
