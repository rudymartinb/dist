<?php
include_once("config.php");
include_once( $DIST.$LIB."/cHTML.php" );


function ArmarCabecera( $tituloPagina ){

	$p = new cHTML();

	$p->head->titulo = $tituloPagina;
	$p->head->AddMeta( "http-equiv='Content-Type' content='text/html; charset=iso-8859-1'"  );
	$p->head->AddCSS( "/css/base.css" );

	$p->head->StyleAdd( "#admtitulo",     	  "font-family:Verdana;font-weight:bold;text-align:left;font-size:16px;color:black;padding:1px;border:5px;width:100%;" );
	$p->head->StyleAdd( "#admtitulo2",     	  "font-family:Verdana;font-weight:bold;text-align:left;font-size:14px;color:black;padding:1px;border:5px;width:100%;" );
	$p->head->StyleAdd( ".admitem",     	  "font-family:Verdana;font-weight:bold;text-align:left;font-size:12px;color:black;padding:1px;border:5px;width:100%;" );

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

	
	$p->body->DivOpen( "admtitulo", "titulo" );
	$p->body->AddHTML( $tituloPagina );
	$p->body->DivClose( );

return $p;
}
?>