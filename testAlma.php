<?php
include_once( "config.php" );

include_once( $DIST.$LIB."/fechas.php" );
include_once( $DIST.$LIB."/cAlmanaque.php" );
include_once( $DIST.$LIB."/cHTML.php" );

error_reporting(E_ALL);

$p = new cHTML();

$p->head->titulo = "Prueba Agenda Produccion";
$p->head->AddMeta( "http-equiv='Content-Type' content='text/html; charset=iso-8859-1'"  );
$p->head->AddCSS( "/css/base.css" );
$p->head->StyleAdd( ".inputText",     	  "width:50px;" );
$p->head->StyleAdd( ".floatLeft",     	  "float:left;" );
$p->head->StyleAdd( ".textoCentrado",     "text-align:center;" );
$p->head->StyleAdd( ".borde1",    		  "border-style:solid;border-width:1px;" );
$p->head->StyleAdd( ".almanaqueCelda",    "width:100px;height:70px;" );
$p->head->StyleAdd( ".almanaqueCeldaFDM", "width:100px;height:70px;" );
$p->head->StyleAdd( ".fondoGrisClaro", "background-color:lightgray;" );
$p->head->StyleAdd( ".almanaqueRenglon",  "clear:both;" );
$p->head->AddJS( "http://ww.elpopular/js/jquery-1.9.0.js" );


// $p->head->AddJS( "/js/focus.js" );
// $p->head->AddJS( "/resources/qunit-1.13.0.js" );
// $p->body->AddJS( "/js/cBrowse.js" );


$p->body->DivOpen( "agenda1", "agenda" );

$a = new cAlmanaque();
$a->periodo = "201405";
$a->Procesar();
$p->body->AddHTML( $a->ArmarCabecera() );

$cant = CantSemanas( $a->ano, $a->mes );

$p->body->AddHTML( "\n" );
for( $w = 0; $w < $cant ; $w ++ ){
	$p->body->DivOpen( "", "almanaqueRenglon" );
	$p->body->AddHTML( "\n" );
	for( $d = 0 ; $d <= 6 ; $d ++ ){
		$dia = $a->DiaCelda( $w, $d );
		if( $a->EsMesBuscadoSemDow( $w, $d ) ){
			$p->body->DivOpen( "$w$d", "almanaqueCelda floatLeft borde1 textoCentrado" );
		} else {
			$p->body->DivOpen( "$w$d", "almanaqueCeldaFDM floatLeft borde1 textoCentrado fondoGrisClaro" );
		}
		$p->body->DivOpen(  );
		$p->body->AddHTML( $a->DiaCelda( $w, $d ) );
		$p->body->DivClose( ); // fin subcelda superior
		
		if( $a->EsMesBuscadoSemDow( $w, $d ) ){
			$p->body->AddHTML( "<input name='t1s$dia' type=text class='inputText borde1' ></input>"  );
			$p->body->AddHTML( "<input name='t2s$dia' type=text class='inputText borde1' ></input>"  );
		} else {
			$p->body->AddHTML( "&nbsp;" );
		}
		$p->body->DivClose( ); // fin subcelda inferior
		$p->body->DivClose( ); // fin celda
		$p->body->DivClose( ); // fin renglon
		$p->body->AddHTML( "\n" );
	}
	$p->body->DivClose( ); // fin renglon
	$p->body->AddHTML( "\n" );
	
	
}

$txt = '
$(".inputText").keydown(function( data ) {
	var $focused = $(":focus");
	if( data.which == 13  ) {
		alert( $focused.attr( "name") );
		return false;
	} 

} );
';


	$p->body->AddScript( $txt  );




$res = $p->Render();
echo $res;

?>


