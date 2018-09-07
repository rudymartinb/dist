<?php 
// ordprod_nueva.php

include_once( "config.php" );

include_once( $DIST.$LIB."/SQL.php" );
include_once ($DIST.$CLASS."/cReporteEntregaClientes.php");

include_once( $DIST.$LIB."/fechas.php" );
include_once( $DIST.$LIB."/cHTML.php" );


include_once( $DIST.$CLASS."/cProducto.php" );

// include_once( $DIST."/reporteProduccion_botonAgregarTirada.php" );
// include_once( $DIST."/reporteProduccion_botonAgregarTirada.php" );
// include_once( $DIST."/ProcesarReporteProduccion.php" );

error_reporting(E_ALL);

// $db = SQL_Conexion();

$p = new cHTML();
$p->head->titulo = "Reporte Entrega Productos";
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
$db = SQL_Conexion();
if( ! SQL_EsValido( $db ) ){
	echo "falta conexion";
	return false;
}

$rec = new cReporteEntregaClientes();
$rec->db = $db;
$rec->prefijo = "0001";
$q = "call sp_definirPrefijo('001','0001');";
$db->query( $q ) ;
$q = "call sp_definirRemito('001','51');";
$db->query( $q ) ;
		

if( $post != null and count( $post ) > 0 ){
	$fecha = $post['fecha'];
	if( ! $rec->DesglosarForm( $post ) ){
		$p->body->AddHTML( "Datos del form no son validos: ".$rec->DetalleError );
	} else {
	
		if( $rec->DesglosarForm( $form ) ){
			if( $rec->GrabarAlta() ) {
				$p->body->AddHTML( "Datos grabados!" );
			} else {
				$p->body->AddHTML( "Error al grabar: ".$rec->DetalleError );
			}
			
			
		}
		
		
	}
	
} else {

	$self = $_SERVER["PHP_SELF"];
	$p->body->AddHTML( '<form name="reporte" action="'.$self.'" method="post">' );

	$txt = GenerarInput( "Fecha", "fecha", "", 10, "fecha", "", "Escriba la Fecha del Reporte en formato DD-MM-AAAA" ); $p->body->AddHTML( $txt );
	$txt = GenerarInput( "Producto", "codprod", "", 3, "codprod", "", "Escriba el codigo de producto" ); $p->body->AddHTML( $txt );
	// $txt = GenerarInput( "Prefijo", "prefijo", "", 4, "prefijo", "", "Escriba el prefijo a utilizar" ); $p->body->AddHTML( $txt );


	$p->body->DivOpen( 'clientes' );


	$lista = $rec->ObtenerListaClientes();
	$i = 1;
		$p->body->DivOpen( "", "admitem floatLeft size400" );	
		$p->body->AddHTML( "Cliente" );
		$p->body->DivClose( );
		$p->body->DivOpen( "", "admitem floatLeft size50" );	
		$p->body->AddHTML( "CCC" );
		$p->body->DivClose( );
		$p->body->DivOpen( "", "admitem floatLeft size50" );	
		$p->body->AddHTML( "CSC" );
		$p->body->DivClose( );
		$p->body->DivOpen( "", "admitem ClearBoth" );	
		$p->body->AddHTML( "" );
		$p->body->DivClose( );		
		
	foreach( $lista as $key => $value ){
		$p->body->AddHTML( $rec->GenerarTitulo( $value['razcli'] ) );
		$p->body->AddHTML( $rec->GenerarInput( $value['razcli'], "CCC".PadN($i,3), "", 10, "", "" ) ) ;
		$p->body->AddHTML( $rec->GenerarInput( $value['razcli'], "CSC".PadN($i,3), "", 10, "", "" ) ) ;
		$p->body->AddHTML( $rec->GenerarHidden( $value['codcli'], "CLI".PadN($i,3)  ) ) ;
		$p->body->DivOpen( "", "admitem ClearBoth " );	
		$p->body->DivClose( );
		$i++;
	}
	$p->body->AddHTML( $rec->GenerarHidden( $i-1, "cantidad"  ) ) ;


	$p->body->DivClose();


	$p->body->AddHTML( '<input class="adminput" type="submit" value="Registrar Reporte" id="OK">' );

	$p->body->AddHTML( '</form>' );



	$p->body->DivOpen( "", "admitem ClearBoth " );
	$p->body->AddHTML( "<a href='index.php' class='ocultar'  >Volver al menú principal</a>" );
	$p->body->DivClose( );

}



$res = $p->Render();
echo $res;



function GenerarInput( $tit, $id, $idclass, $len, $name, $value, $mensa ){
	$txt = "";
	$txt .= '<div class="admitem">'.$tit.':</div>' ;
	$txt .= '<input class="adminput1 '.$idclass.'" type=text value="'.$value.'" id="'.$id.'" name="'.$name.'" maxlength="'.$len.'">' ;
	$txt .= '<div class="admmensa">'.$mensa.'</div>' ;
	return $txt;
}

?>