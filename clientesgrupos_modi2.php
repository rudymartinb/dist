<?php 
// clientesgrupos_alta.php

include_once( "config.php" );


include_once( $DIST.$LIB."/cHTML.php" );

include_once( $DIST.$LIB."/SQL.php" );
include_once( $DIST.$CLASS."/cClientesGrupos.php" );


error_reporting(E_ALL);


$db = SQL_Conexion();
	

$p = new cHTML();

$p->head->titulo = "Modificacion Grupos de Clientes";
$p->head->AddMeta( "http-equiv='Content-Type' content='text/html; charset=iso-8859-1'"  );
$p->head->AddCSS( "/css/base.css" );

$p->head->StyleAdd( "#admtitulo",     	  "font-family:courier new;font-weight:bold;text-align:left;font-size:28px;color:black;padding:1px;border:5px;width:100%;" );
$p->head->StyleAdd( "#admtitulo2",     	  "font-family:courier new;font-weight:bold;text-align:left;font-size:24px;color:black;padding:1px;border:5px;width:100%;" );
$p->head->StyleAdd( ".admitem",     	  "font-family:courier new;font-weight:bold;text-align:left;font-size:18px;color:black;padding:1px;border:5px;width:100%;" );
$p->head->StyleAdd( ".admmensa",     	  "font-family:courier new;font-weight:bold;text-align:left;font-size:14px;color:black;padding:1px;border:5px;width:100%;" );

$p->head->StyleAdd( ".adminput1",     	  	"width:50px;" );
$p->head->StyleAdd( ".adminput2",     	  	"width:250px;" );
$p->head->StyleAdd( ".adminput3",     	  	"width:150px;" );
$p->head->StyleAdd( ".inputText",     	  	"width:50px;" );
$p->head->StyleAdd( ".couriernew",     	  	"font-family:courier new;" );
$p->head->StyleAdd( ".fs12",     	  		"font-size:12px;" );
$p->head->StyleAdd( ".fs14",     	  		"font-size:14px;" );
$p->head->StyleAdd( ".ClearBoth",     	  	"clear:both;" );
$p->head->StyleAdd( ".floatLeft",     	  	"float:left;" );
$p->head->StyleAdd( ".textoCentrado",     	"text-align:center;" );
$p->head->StyleAdd( ".textoDerecha",     	"text-align:right;" );
$p->head->StyleAdd( ".borde1",    		  	"border-style:solid;border-width:1px;" );
$p->head->StyleAdd( ".fondoGrisClaro", 		"background-color:lightgray;" );
$p->head->StyleAdd( ".fondoRosa", 			"background-color:#FF9999;" );

$p->head->AddJS( "http://ww.elpopular/js/jquery-1.9.0.js" );


$p->head->AddJS( "/js/PadN.js" );
$p->head->AddJS( "/js/focus.js" );


/* generar listado clientes y productos.
*/
$post = $_POST;
if( $post != null ){
	// $pack = $post['ref'];
	$codgru = $post['cod'];
	// $desgru = $post['des'];
	// $abrgru = $post['abr'];
	$gru = new cClientesGrupos();
	$gru->db = $db;
	$gru->cod = $codgru;
	if( $gru->Leer() ){
		RenderCode( $p );
	} else {
		$p->body->DivOpen( "", "admitem ClearBoth" );
		$p->body->AddHTML( "Codigo de Grupo no encontrado" );
		$p->body->DivClose( );		
	};
	$desgru = $gru->des ;
	$abrgru = $gru->abr ;
	

}
$p->body->DivOpen( "", "admitem ClearBoth" );
$p->body->AddHTML( "<a href='index.php'  >Volver al menú principal</a>" );
$p->body->DivClose( );

$res = $p->Render();

echo $res;


function RenderCode( $p ){
$p->body->AddHTML( '<hr>' );
$p->body->DivOpen( "admtitulo", "titulo" );
$p->body->AddHTML( 'Modificacion Grupos Clientes' );
$p->body->DivClose(  );
$p->body->AddHTML( '<hr>' );

$p->body->AddHTML( '<form name="input" action="clientesgrupos_modi.php" method="post">' );


$p->body->AddHTML( '<div class="admitem">Codigo Grupo:</div>' );
$p->body->AddHTML( '<input class="adminput1" type=text value="'.$codgru.'" id="cod" name="cod" maxlength="3" > ' );
$p->body->AddHTML( '<div class="admmensa">Escriba el codigo de tres dígitos a utilizar</div>' );

$p->body->AddHTML( '<div class="admitem">Descripcion:</div>' );
$p->body->AddHTML( '<input class="adminput2" type=text value="'.$desgru.'" id="des" name="des" maxlength="45">' );
$p->body->AddHTML( '<div class="admmensa">Escriba la Razon Social correspondiente</div>' );

$p->body->AddHTML( '<div class="admitem">Abreviatura:</div>' );
$p->body->AddHTML( '<input class="adminput3" type=text value="'.$abrgru.'" id="abr" name="abr" maxlength="15">' );
$p->body->AddHTML( '<div class="admmensa">Escriba la Razon Social correspondiente</div>' );

$p->body->AddHTML( '<input class="adminput" type="submit" value="Modificar" id="OK">' );
$p->body->AddHTML( '</form>' );


	
$p->body->DivClose( );


$p->body->AddHTML( "\n" );
$p->body->DivOpen(  );


$txt = '
periodo = "'.$periodo.'";
codcli = "'.$codcli.'";
codprod = "'.$codprod.'";
Setup();
$("#des").focusEnd();
';


$p->body->AddScript( $txt  );

$p->body->DivClose( );


}
?>