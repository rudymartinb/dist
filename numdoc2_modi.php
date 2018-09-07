<?php

include_once( "config.php" );

include_once( $DIST.$CLASS."/cNroDoc.php" );
include_once( $DIST.$LIB."/SQL.php" );
include_once( $DIST.$LIB."/cHTML.php" );

error_reporting(E_ALL);

$db = SQL_Conexion();
	

$p = new cHTML();

$p->head->titulo = "Actualizar Numeradores";
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



$p->body->AddHTML( '<hr>' );
$p->body->DivOpen( "admtitulo", "titulo" );
$p->body->AddHTML( $p->head->titulo );
$p->body->DivClose(  );
$p->body->AddHTML( '<hr>' );

/* generar listado clientes y productos.
*/
$post = $_POST;
if( $post == null ){
	$p->body->AddHTML( '<form name="input" action="'. $_SERVER['PHP_SELF'] . '" method="post">' );

	$p->body->AddHTML( '<div class="admitem">Prefijo:</div>' );
	$p->body->AddHTML( '<input class="adminput1" type=text value="" id="prefijo" name="prefijo" maxlength="4">' );
	$p->body->AddHTML( '<div class="admmensa">Escriba el prefijo de talonario a utilizar</div>' );


	$p->body->AddHTML( '<div class="admitem">Tipo Documento:</div>' );
	$p->body->AddHTML( '<input class="adminput1" type=text value="" id="codtd" name="codtd" maxlength="2">' );
	$p->body->AddHTML( '<div class="admmensa">Escriba el codigo de tipo de documento a utilizar</div>' );

	$p->body->AddHTML( '<div class="admitem">Proximo Numero:</div>' );
	$p->body->AddHTML( '<input class="adminput1" type=text value="" id="prox" name="prox" maxlength="8">' );
	$p->body->AddHTML( '<div class="admmensa">Escriba el proximo numero a utilziar</div>' );

	$p->body->AddHTML( '<input class="adminput" type="submit" value="Modificar" id="OK">' );
	$p->body->AddHTML( '</form>' );

} else {
	$cant = count( $post );
	if( true ){
		$prefijo = $post['prefijo'];
		$codtd = $post['codtd'];
		$prox = $post['prox'];
		
		$obj = new cNroDoc();
		$obj->db = $db;
		$obj->prefijo = $prefijo;
		if( ! $obj->Leer() ){
			$p->body->AddHTML( "No se encontro el prefijo ".$obj->DetalleError );
		} else {
			if( $obj->UpdateNro($prox,$codtd) ){
				$p->body->AddHTML( "Numerador Actualizado" );
			} else {
				$p->body->AddHTML( "Numerador NO Actualizado: ".$obj->DetalleError );
			}
			
			$arr = $obj->LeerNros();
			if( count( $arr ) > 0 ){
				$p->body->AddHTML( "<hr>" );
				foreach( $arr as $key => $value ){
					$p->body->AddHTML( $value['codtd']." " );
					$p->body->AddHTML( $value['destd']." " );
					$p->body->AddHTML( PadN( $value['prox'], 8 )."<br>" );
				}
				$p->body->AddHTML( "<hr>" );
			}
		}
		

		
	}

	
}


	
$p->body->DivClose( );

$p->body->AddHTML( "\n" );
$p->body->DivOpen(  );

$p->body->DivClose( );
$p->body->DivOpen( "", "admitem ClearBoth" );
$p->body->AddHTML( "<a href='index.php'  >Volver al menú principal</a>" );
$p->body->DivClose( );



$res = $p->Render();
echo $res;

?>
