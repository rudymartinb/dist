<?php

/*
 * codigo que probablemente estaba pensado para el desarrollo nuevo de distribudora
 * creo q conviene rever MVC antes de hacer refactoring aqui
 * 
*/


require_once( "config.php" );
require_once( $DIST.$LIB."/SQL.php" );
require_once( $DIST.$LIB."/fechas.php" );
require_once( $DIST.$LIB."/cHTML.php" );
require_once( $DIST.$CLASS."/cEmitirRemitos.php" );

error_reporting(E_ALL);

$p = new cHTML();
$p->head->titulo = "Emitir Remitos Clientes";
$p->head->AddMeta( "http-equiv='Content-Type' content='text/html; charset=iso-8859-1'"  );
$p->head->AddCSS( "/css/base.css" );
$p->head->AddJS( "/js/MandarAjax.js.php" );

$p->head->StyleAdd( "#admtitulo",     	  "font-family:courier new;font-weight:bold;text-align:left;font-size:28px;color:black;padding:1px;border:5px;width:100%;" );
$p->head->StyleAdd( "#admtitulo2",     	  "font-family:courier new;font-weight:bold;text-align:left;font-size:24px;color:black;padding:1px;border:5px;width:100%;" );
$p->head->StyleAdd( ".admitem",     	  "font-family:courier new;font-weight:bold;text-align:left;font-size:18px;color:black;padding:1px;border:5px;width:100%;" );
$p->head->StyleAdd( ".tituloInput",     	  "font-family:courier new;font-weight:bold;text-align:left;font-size:18px;color:black;padding:1px;border:5px;" );
// $p->head->StyleAdd( "hr",     	  "border: none;height: 2px;color: #333;background-color: #333;" );


$p->head->StyleAdd( ".inputText",     	  	"width:50px;" );
$p->head->StyleAdd( ".size50",     	  		"width:50px;" );
$p->head->StyleAdd( ".size100",     	  	"width:100px;" );
$p->head->StyleAdd( ".size150",     	  	"width:150px;" );
$p->head->StyleAdd( ".size400",     	  	"width:400px;" );
$p->head->StyleAdd( ".size600",     	  	"width:600px;" );
$p->head->StyleAdd( ".tahoma",     	  		"font-family:tahoma;" );
$p->head->StyleAdd( ".couriernew",     	  	"font-family:courier new;" );
$p->head->StyleAdd( ".bold",     	  		"font-weight:bold;" );
$p->head->StyleAdd( ".fs12",     	  		"font-size:12px;" );
$p->head->StyleAdd( ".fs14",     	  		"font-size:14px;" );
$p->head->StyleAdd( ".ClearBoth",     	  	"clear:both;" );
$p->head->StyleAdd( ".floatLeft",     	  	"float:left;" );
$p->head->StyleAdd( ".textoIzquierda",     	"text-align:left;" );
$p->head->StyleAdd( ".textoCentrado",     	"text-align:center;" );
$p->head->StyleAdd( ".textoDerecha",     	"text-align:right;" );
$p->head->StyleAdd( ".borde1",    		  	"border-style:solid;border-width:1px;" );
$p->head->StyleAdd( ".almanaqueCelda",    	"width:100px;height:70px;" );
$p->head->StyleAdd( ".almanaqueCeldaFDM", 	"width:100px;height:70px;" );
$p->head->StyleAdd( ".fondoGrisClaro", 		"background-color:lightgray;" );
$p->head->StyleAdd( ".fondoRosa", 			"background-color:#FF9999;" );
$p->head->StyleAdd( ".almanaqueRenglon",  	"clear:both;" );
$p->head->StyleAdd( "@media print { .ocultar", "display:none !important; }" );
// $p->head->StyleAdd( ".almanaqueTitulo",  "font-size:18;font-face:verdana;" );

$p->head->AddJS( "http://ww.elpopular/js/jquery-1.9.0.js" );


$p->head->AddJS( "/js/PadN.js" );
$p->head->AddJS( "/js/focus.js" );
$p->head->AddJS( "/js/MandarAjax.js.php" );
// $p->head->AddJS( "/resources/qunit-1.13.0.js" );
// $p->body->AddJS( "/js/cBrowse.js" );


$p->head->AddJS( "/ajax/ajaxAlmanaqueDiaModi.js.php" );


$p->body->DivOpen( "admtitulo", "titulo" );
$p->body->AddHTML( $p->head->titulo );
$p->body->DivClose( );

$post = $_POST;
if( count( $post ) == 0 ){

	$p->body->AddHTML( '<form name="input" action="'. $_SERVER['PHP_SELF'] . '" method="post">' );

	$p->body->AddHTML( '<div class="admitem">Fecha:</div>' );
	$p->body->AddHTML( '<input class="adminput1" type=text value="" id="fecha" name="fecha" maxlength="10">' );
	$p->body->AddHTML( '<div class="admmensa">Escriba la fecha correspondiente en formato DD-MM-AAAA </div>' );

	$p->body->AddHTML( '<input class="adminput" type="submit" value="Consultar" id="OK">' );
	$p->body->AddHTML( '</form>' );

	
} else {
	// tomar datos del form
	$db = SQL_Conexion();
	if( ! SQL_EsValido( $db ) ){
		echo "Falla conexion -- consulte con Sistemas" ;
		return false;
	}
	$obj = new cEmitirRemitos();
	$obj->fecha = $post['fecha'];
	$obj->db = $db;
	$lista = $obj->ObtenerListaRemitos();
	if( count( $lista ) == 0 ){
		$p->body->AddHTML( "No hay remitos pendientes de emitir para la fecha elegida" );
	} else {
		// /* 
		// ok para esta segunda etapa la idea es mostrar una lista de remitos a emitir.
		// a fin de no complicar la cosa, vamos a poner un link en cada remito
		// el mismo llevara a una pagina desde la cual se podra imprimir el remito en cuestion
		// */
		foreach( $lista as $key => $value ){
			$p->body->DivOpen( "", "admitem" );
			$p->body->AddHTML( "<a href='remitopdf.php?idx=".$value['idx']."'>".$value['nrorem1']."</a>"." ".$value['razcli']." (".$value['clirem1'].") ".$value['bimrem1'] );
			$p->body->DivClose( );
		}
	}
}

$res = $p->Render();
echo $res;

		

?>