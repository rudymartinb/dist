<?php 
// ordprod_nueva.php

include_once( "config.php" );

include_once( $DIST."/ArmarTiradaDiaria.php" );
include_once( $DIST.$LIB."/fechas.php" );
include_once( $DIST.$LIB."/cHTML.php" );

include_once( $DIST.$LIB."/SQL.php" );
include_once( $DIST.$CLASS."/cClientes.php" );
include_once( $DIST.$CLASS."/cProducto.php" );

// include_once( "config.php" );
// include_once( $DIST.$LIB."/fechas.php" );
// include_once( $DIST.$CLASS."/cAgendaEntrega.php" );
// include_once( $DIST.$CLASS."/cAgendaListaDoble.php" );
// include_once( $DIST.$CLASS."/cProducto.php" );

// include_once( $DIST."/GenerarListaCantidades.php" );


error_reporting(E_ALL);


$db = SQL_Conexion();


$p = new cHTML();

$p->head->titulo = "Tirada Diaria";
$p->head->AddMeta( "http-equiv='Content-Type' content='text/html; charset=iso-8859-1'"  );
$p->head->AddCSS( "/css/base.css" );

$p->head->StyleAdd( "#admtitulo",     	  "font-family:courier new;font-weight:bold;text-align:left;font-size:28px;color:black;padding:1px;border:5px;width:100%;" );
$p->head->StyleAdd( "#admtitulo2",     	  "font-family:courier new;font-weight:bold;text-align:left;font-size:24px;color:black;padding:1px;border:5px;width:100%;" );
$p->head->StyleAdd( ".admitem",     	  "font-family:courier new;font-weight:bold;text-align:left;font-size:18px;color:black;padding:1px;border:5px;width:100%;" );
// $p->head->StyleAdd( "hr",     	  "border: none;height: 2px;color: #333;background-color: #333;" );


$p->head->StyleAdd( ".col1",     	  		"width:300px;" );
$p->head->StyleAdd( ".col2",     	  		"width:150px;" );
$p->head->StyleAdd( ".col3",     	  		"width:50px;" );
$p->head->StyleAdd( ".col4",     	  		"width:50px;" );
$p->head->StyleAdd( ".col5",     	  		"width:50px;" );
$p->head->StyleAdd( ".inputText",     	  	"width:50px;" );
$p->head->StyleAdd( ".size50",     	  		"width:50px;" );
$p->head->StyleAdd( ".size100",     	  	"width:100px;" );
$p->head->StyleAdd( ".size150",     	  	"width:150px;" );
$p->head->StyleAdd( ".size200",     	  	"width:200px;" );
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
$p->body->AddHTML( "Tirada Diaria" );
$p->body->DivClose( );

/* generar listado clientes y productos.
*/
$post = $_POST;
if( $post != null ){
	$fecha = $post['fecha'];
	$db = SQL_Conexion();
	$arr = ArmarTiradaDiaria( $db, Fecha2SQL( $fecha ) );
	$pro = "";
	$gru = "";
	
	$p->body->DivOpen( "admtitulo", "titulo" );
	$p->body->AddHTML( "Fecha: ".$fecha );
	$p->body->DivClose( );
	
	for( $i = 0 ; $i < count( $arr ) ; $i++ ){
		$v = $arr[$i];
		if( $v['grucli'] != $gru ){
			if( $gru != "" ){
				TotalesGrupo( $p , $tot2 );
			}		
		}		
		if( $v['proage'] != $pro ){
			if( $pro != "" ){
				TotalesProd( $p , $tot1 );
			}
		}
		if( $v['proage'] != $pro ){
			$pro = $v['proage'];
			$p->body->AddHTML( "<hr>" );
			$p->body->DivOpen( "", "fs16 bold tahoma clearBoth" );
			$p->body->AddHTML( $v['despro'] );
			$p->body->DivClose( );
			$p->body->AddHTML( "<hr>" );
			
			$p->body->DivOpen( "", "fs12 " );
			$p->body->DivOpen( "", "col1 fs12 floatLeft  tahoma" );
			$p->body->AddHTML( "Cliente" );
			$p->body->DivClose( );				
			$p->body->DivOpen( "", "col2 fs12 floatLeft tahoma " );
			$p->body->AddHTML( "Localidad" );
			$p->body->DivClose( );				
			$p->body->DivOpen( "", "col3 fs12 floatLeft tahoma textoDerecha" );
			$p->body->AddHTML( "Cant. CC." );
			$p->body->DivClose( );				
			$p->body->DivOpen( "", "col4 fs12 floatLeft tahoma textoDerecha" );
			$p->body->AddHTML( "Cant. SC." );
			$p->body->DivClose( );				
			$p->body->DivOpen( "", "col5 fs12 floatLeft tahoma textoDerecha" );
			$p->body->AddHTML( "Total" );
			$p->body->DivClose( );				
			$p->body->DivOpen( "", "clearBoth" );
			$p->body->AddHTML( "&nbsp;" );
			$p->body->DivClose( );	
			$p->body->DivClose( );	
			$tot1 = [0,0,0];
		}

		if( $v['grucli'] != $gru ){
			$gru = $v['grucli'];
			$p->body->DivOpen( "", "clearBoth" );
			$p->body->AddHTML( "&nbsp;" );
			$p->body->DivClose( );	
			$p->body->DivOpen( "", "fs14 bold tahoma clearBoth textoIzquierda" );
			$p->body->AddHTML( $v['desgru']." (".$v['grucli'].")" );
			$p->body->DivClose( );			
			$tot2 = [0,0,0];
		}
		
		$p->body->DivOpen( "", "fs12 ClearBoth" );
		$p->body->DivOpen( "", "col1 fs12 floatLeft  tahoma" );
		$p->body->AddHTML( $v['cliage']." ".$v['razcli'] );
		$p->body->DivClose( );
		$p->body->DivOpen( "", "col2 fs12 floatLeft  tahoma" );
		$p->body->AddHTML( $v['loccli'] );
		$p->body->DivClose( );
		$p->body->DivOpen( "", "col3 fs12 floatLeft tahoma textoDerecha" );
		$p->body->AddHTML( $v['cant1'] );
		$p->body->DivClose( );				
		$p->body->DivOpen( "", "col4 fs12 floatLeft tahoma textoDerecha" );
		$p->body->AddHTML( $v['cant2'] );
		$p->body->DivClose( );				
		$p->body->DivOpen( "", "col5 fs12 floatLeft tahoma textoDerecha" );
		$p->body->AddHTML( "&nbsp;" );
		// $p->body->AddHTML( $v['cant1']+$v['cant2'] );
		$p->body->DivClose( );	
		$p->body->DivOpen( "", "clearBoth" );
		$p->body->AddHTML( "&nbsp;" );
		$p->body->DivClose( );				
		$tot1[0] += $v['cant1'];
		$tot2[0] += $v['cant1'];
		$tot1[1] += $v['cant2'];
		$tot2[1] += $v['cant2'];
		$tot1[2] += $v['cant1']+$v['cant2'];
		$tot2[2] += $v['cant1']+$v['cant2'];
		$p->body->DivClose( );				
		


	}
	
	if( $gru != "" ){
		TotalesGrupo( $p , $tot2 );
	}		
	
	if( $pro != "" ){
		TotalesProd( $p , $tot1 );
	}
	
		
} else {

$p->body->AddHTML( '<form name="input" action="tiradadiaria.php" method="post">' );
$p->body->AddHTML( '<div class="admitem">Fecha:</div>' );
$p->body->AddHTML( '<input class="adminput1" type=text value="" id="fecha" name="fecha" maxlength="10">' );
$p->body->AddHTML( '<div class="admmensa">Escriba la fecha en formato DD-MM-AAAA</div>' );
$p->body->AddHTML( '<input class="adminput" type="submit" value="Consultar" id="OK">' );
$p->body->AddHTML( '</form>' );

}

$p->body->DivOpen( "", "admitem ClearBoth " );
$p->body->AddHTML( "<a href='index.php' class='ocultar'  >Volver al menú principal</a>" );
$p->body->DivClose( );




$res = $p->Render();
echo $res;

/* armado de totales
*/
function TotalesGrupo( $p , $tot2 ){
	$p->body->AddHTML( "<hr>" );
	$p->body->DivOpen( "", "fs12 " );
	$p->body->DivOpen( "", "col1 fs12 floatLeft  tahoma" );
	$p->body->AddHTML( "Totales Grupo" );
	$p->body->DivClose( );				
	$p->body->DivOpen( "", "col2 fs12 floatLeft  tahoma" );
	$p->body->AddHTML( "&nbsp;" );
	$p->body->DivClose( );				
	$p->body->DivOpen( "", "col3 fs12 floatLeft tahoma textoDerecha bold" );
	$p->body->AddHTML( $tot2[0] );
	$p->body->DivClose( );				
	$p->body->DivOpen( "", "col4 fs12 floatLeft tahoma textoDerecha bold" );
	$p->body->AddHTML( $tot2[1] );
	$p->body->DivClose( );				
	$p->body->DivOpen( "", "col5 fs12 floatLeft tahoma textoDerecha bold" );
	$p->body->AddHTML( $tot2[2] );
	$p->body->DivClose( );	
	$p->body->DivOpen( "", "clearBoth" );
	$p->body->AddHTML( "&nbsp;" );
	$p->body->DivClose( );	
	$p->body->DivClose( );	
	$p->body->AddHTML( "<hr>" );
}
function TotalesProd( $p , $tot1 ){
	$p->body->AddHTML( "<hr>" );
	$p->body->DivOpen( "", "fs12 " );
	$p->body->DivOpen( "", "col1 fs12 floatLeft  tahoma" );
	$p->body->AddHTML( "Totales Producto" );
	$p->body->DivClose( );				
	$p->body->DivOpen( "", "col2 fs12 floatLeft  tahoma" );
	$p->body->AddHTML( "&nbsp;" );
	$p->body->DivClose( );		
	$p->body->DivOpen( "", "col3 fs12 floatLeft tahoma textoDerecha" );
	$p->body->AddHTML( $tot1[0] );
	$p->body->DivClose( );				
	$p->body->DivOpen( "", "col4 fs12 floatLeft tahoma textoDerecha" );
	$p->body->AddHTML( $tot1[1] );
	$p->body->DivClose( );
	$p->body->DivOpen( "", "col5 fs12 floatLeft tahoma textoDerecha" );
	$p->body->AddHTML( $tot1[2] );
	$p->body->DivClose( );
	$p->body->DivOpen( "", "clearBoth" );
	$p->body->AddHTML( "&nbsp;" );
	$p->body->DivClose( );	
	$p->body->DivClose( );	
	$p->body->AddHTML( "<hr>" );
}


?>