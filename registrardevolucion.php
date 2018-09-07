<?php 
// ordprod_nueva.php

require_once( "config.php" );


require_once( $DIST.$LIB."/fechas.php" );
require_once( $DIST.$LIB."/cAlmanaque.php" );
require_once( $DIST.$LIB."/cHTML.php" );

require_once( $DIST.$LIB."/SQL.php" );
require_once( $DIST.$CLASS."/cClientes.php" );
require_once( $DIST.$CLASS."/cProducto.php" );



error_reporting(E_ALL);


$db = SQL_Conexion();
	


$p = new cHTML();

$p->head->titulo = "Reporte Devolución";
$p->head->AddMeta( "http-equiv='Content-Type' content='text/html; charset=iso-8859-1'"  );
$p->head->AddCSS( "/css/base.css" );

$p->head->StyleAdd( "#admtitulo",     	  "font-family:courier new;font-weight:bold;text-align:left;font-size:28px;color:black;padding:1px;border:5px;width:100%;" );
$p->head->StyleAdd( "#admtitulo2",     	  "font-family:courier new;font-weight:bold;text-align:left;font-size:24px;color:black;padding:1px;border:5px;width:100%;" );
$p->head->StyleAdd( ".admitem",     	  "font-family:courier new;font-weight:bold;text-align:left;font-size:18px;color:black;padding:1px;border:5px;width:100%;" );

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
$post = $_GET;
if( $post != null ){
	$pack = $post['ref'];
	$periodo = substr( $pack, 0, 6 );
	$codcli  = substr( $pack, 6, 3 );
	$codprod = substr( $pack, 9, 3 );
}


$cli = new cClientes();
$cli->db = $db;
$cli->cod = $codcli;
$cli->Leer();

$prod = new cProducto();
$prod->db = $db;
$prod->cod = $codprod;
$prod->Leer();


$p->body->DivOpen( "admtitulo", "titulo" );
$p->body->AddHTML( "Reporte Devolución Productos" );
$p->body->DivClose( );


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

$p->body->AddHTML( '<input type=hidden value="1" id="nrotiradas" name="nrotiradas" >' );
$txt = GenerarInput( "Producto", "prod", "", 3, "prod", "", "Escriba el codigo de producto" ); $p->body->AddHTML( $txt );
$txt = GenerarInput( "Fecha", "fecha", "", 10, "fecha", "", "Escriba la Fecha del Reporte en formato DD-MM-AAAA" ); $p->body->AddHTML( $txt );
$txt = GenerarInput( "Cliente", "cli", "", 3, "cli", "", "Escriba el codigo de cliente." ); $p->body->AddHTML( $txt );
$txt = GenerarInput( "Cantidad", "cant", "", 10, "cant", "", "Escriba la cantidad correspondiente." ); $p->body->AddHTML( $txt );

$p->body->DivOpen( 'tiradas' );

// $nro = 1;
// $p->body->AddHTML( BotonAgregarTirada( $nro ) );

$p->body->DivClose();

$p->body->AddHTML( '<input class="adminput" type="submit" value="Registrar Reporte" id="registrar">' );
$p->body->AddScript( '
	var nro = 1;
	$("#registrar").click( function(){
	RegistrarDevolucion();
	// nro += 1;
	// AgregarTirada( nro );
	return false;
	} );

	function RegistrarDevolucion(){
		var este = { 
		"fecha": fecha ,
		"fecha": fecha };
		"fecha": fecha };
		$("#nrotiradas").val( nro );
		data = MandarAjax( "/reporteProduccion_botonAgregarTirada.php", este );
		
		$("#tiradas").append(  data );
	}
' );

$p->body->AddHTML( '<input class="adminput" type="submit" value="Registrar Reporte" id="OK">' );

$p->body->AddHTML( '</form>' );



$p->body->DivOpen( "", "admitem ClearBoth " );
$p->body->AddHTML( "<a href='index.php' class='ocultar'  >Volver al menú principal</a>" );
$p->body->DivClose( );


$res = $p->Render();
echo $res;
?>