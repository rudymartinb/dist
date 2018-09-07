<?php 
// ordprod_nueva.php

include_once( "config.php" );


include_once( $DIST.$LIB."/fechas.php" );
include_once( $DIST.$LIB."/cAlmanaque.php" );
include_once( $DIST.$LIB."/cHTML.php" );

include_once( $DIST.$LIB."/SQL.php" );
include_once( $DIST.$CLASS."/cClientes.php" );
include_once( $DIST.$CLASS."/cProducto.php" );

// include_once( "config.php" );
// include_once( $DIST.$LIB."/fechas.php" );
// include_once( $DIST.$CLASS."/cAgendaEntrega.php" );
// include_once( $DIST.$CLASS."/cAgendaListaDoble.php" );
// include_once( $DIST.$CLASS."/cProducto.php" );

include_once( $DIST."/GenerarListaCantidades.php" );


error_reporting(E_ALL);


$db = SQL_Conexion();
	

$p = new cHTML();

$p->head->titulo = "Agenda Produccion";
$p->head->AddMeta( "http-equiv='Content-Type' content='text/html; charset=uft-8'"  );
$p->head->AddMeta( "http-equiv='cache-control' content='max-age=0'"  );
$p->head->AddMeta( "http-equiv='cache-control' content='no-cache'"  );
$p->head->AddMeta( "http-equiv='expires' content='0'" );
$p->head->AddMeta( "http-equiv='expires' content='Tue, 01 Jan 1980 1:00:00 GMT'" );
$p->head->AddMeta( "http-equiv='pragma' content='no-cache'" );



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
$p->head->StyleAdd( ".almanaqueCelda",    	"width:100px;height:90px;" );
$p->head->StyleAdd( ".almanaqueCeldaFDM", 	"width:100px;height:90px;" );
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


$p->head->AddJS( "/ajax/ajaxAlmanaqueDiaModi.js.php?xversion=20160902" );


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


$a = new cAlmanaque();
$a->periodo = $periodo;
if( ! $a->Procesar() ){
	$p->body->AddHTML( "Ocurrio un error al procesar el periodo" );
};


$p->body->DivOpen( "admtitulo", "titulo" );
$p->body->AddHTML( "Agenda Produccion" );
$p->body->DivClose( );


$p->body->DivOpen( "", "admitem" );
$p->body->AddHTML( "Cliente: ". $codcli." ".$cli->raz  );
$p->body->DivClose( );

$p->body->DivOpen( "", "admitem" );
$p->body->AddHTML( "Producto: ". $codprod." ".$prod->des    );
$p->body->DivClose( );
$p->body->DivOpen( "", "admitem" );
$p->body->AddHTML( $a->ArmarCabecera() );
$p->body->DivClose( );


$lista = GenerarListaCantidades( $db, $codcli, $codprod, $periodo );
if( count( $lista ) == 0 ){
	$p->body->AddHTML( "Ocurrio un error al procesar el periodo (listacant)" );
};


$cant = CantSemanas( $a->ano, $a->mes );
if( $cant  == 0 ){
	$p->body->AddHTML( "Ocurrio un error al procesar el periodo (listacant)" );
};

$p->body->AddHTML( "\n" );
$p->body->DivOpen(  );
for( $w = 0; $w < $cant ; $w ++ ){
	$p->body->DivOpen( "", "almanaqueRenglon" );
	$p->body->AddHTML( "\n" );
	for( $d = 0 ; $d <= 6 ; $d ++ ){
		$dow = "";
		if( $w == 0 ){
			switch( $d ){
				case 0:{ $dow  = "Dom" ; break; }
				case 1:{ $dow  = "Lun" ; break; }
				case 2:{ $dow  = "Mar" ; break; }
				case 3:{ $dow  = "Mie" ; break; }
				case 4:{ $dow  = "Jue" ; break; }
				case 5:{ $dow  = "Vie" ; break; }
				case 6:{ $dow  = "Sab" ; break; }
			}
		}
		
		$dia = $a->DiaCelda( $w, $d );
		if( $a->EsMesBuscado( $a->listadias[$w][$d] ) ){
			/* la celda del dia corresponde al mes
			** ahora quiero saber si el producto es valido para este dia
			*/ 
			$diaok = true;
			$p->body->DivOpen( "$w$d", "almanaqueCelda floatLeft borde1 textoCentrado " );
		} else {
			$p->body->DivOpen( "$w$d", "almanaqueCeldaFDM floatLeft borde1 textoCentrado fondoGrisClaro" );
		}
		$p->body->DivOpen(  );
		$p->body->AddHTML( "<b>".$dow." ".$dia."</b> " );
		$p->body->DivClose( ); // fin subcelda superior
		if( $a->EsMesBuscado( $a->listadias[$w][$d] ) ){
			$val1 = $lista[ intval( $dia ) ][0];
			$val2 = $lista[ intval( $dia ) ][1];		
			$val3 = $lista[ intval( $dia ) ][2];
			if( $val1 =="0" ) {
				$val1 = "";
			}
			if( $val2 =="0" ) {
				$val2 = "";
			}			
			if( $val3 =="0" ) {
				$val3 = "";
			}			
			$p->body->DivOpen( "", "fs12 couriernew textoCentro" );
			$p->body->AddHTML( "CCC:<input id='t1s$dia' name='t1s$dia' type=text class='fs12 couriernew inputText borde1 textoDerecha' value='$val1' ></input>"  );
			$p->body->AddHTML( "CSC:<input id='t2s$dia' name='t2s$dia' type=text class='fs12 couriernew inputText borde1 textoDerecha' value='$val2' ></input>"  );
			$p->body->AddHTML( "DEV:<input id='t3s$dia' name='t3s$dia' type=text class='fs12 couriernew inputText borde1 textoDerecha' value='$val3' ></input>"  );
			$p->body->DivClose( );
		} else {
			$p->body->AddHTML( "&nbsp;" );
		}
		$p->body->DivClose( ); 
		$p->body->AddHTML( "\n" );
	}
	$p->body->DivClose( ); // fin renglon
	$p->body->AddHTML( "\n" );
	
	
}

$txt = '
periodo = "'.$periodo.'";
codcli = "'.$codcli.'";
codprod = "'.$codprod.'";
Setup();
$("#t1s01").focusEnd();
';


$p->body->AddScript( $txt  );

$p->body->DivClose( );
$p->body->DivOpen( "", "admitem ClearBoth" );
$p->body->AddHTML( "<a href='/index.php'  >Volver al menú principal</a>" );
$p->body->DivClose( );



$res = $p->Render();
echo $res;

?>