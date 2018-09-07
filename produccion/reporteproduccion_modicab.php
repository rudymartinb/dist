<?php
include_once( "config.php" );
include_once( $DIST.$LIB."/SQL.php" );


include_once( $DIST.$LIB."/fechas.php" );
include_once( $DIST.$LIB."/cHTML.php" );
include_once( $DIST.$LIB."/forms.php" );
include_once( $DIST.$CLASS."/cReporteProduccion.php" );
error_reporting(E_ALL);


// $db = SQL_Conexion();
	
// $q = "start transaction;";
// try {
	// $res = $db->query( $q );
// } catch ( Exception $e ) {
	// $error = $e->getMessage() ;
	// echo  $error;
	// return;
// }
// if( $res === FALSE ) {
	// $error = "Error: ". $db->error ;
	// echo  $error;
	// return;
// }


$p = new cHTML();

$p->head->titulo = "Modificar Cabecera Reporte Produccion";
$p->head->AddMeta( "http-equiv='Content-Type' content='text/html; charset=iso-8859-1'"  );
$p->head->AddCSS( "/css/base.css" );
$p->head->AddJS( "/js/MandarAjax.js.php" );

$p->head->StyleAdd( "#admtitulo",     	  "font-family:courier new;font-weight:bold;text-align:left;font-size:28px;color:black;padding:1px;border:5px;width:100%;" );
$p->head->StyleAdd( "#admtitulo2",     	  "font-family:courier new;font-weight:bold;text-align:left;font-size:24px;color:black;padding:1px;border:5px;width:100%;" );
$p->head->StyleAdd( ".admitem",     	  "font-family:courier new;font-weight:bold;text-align:left;font-size:18px;color:black;padding:1px;border:5px;width:100%;" );
// $p->head->StyleAdd( "hr",     	  "border: none;height: 2px;color: #333;background-color: #333;" );


$p->head->StyleAdd( ".inputText",     	  	"width:50px;" );
$p->head->StyleAdd( ".marginright10",     	"margin-right:10px;" );
$p->head->StyleAdd( ".padright10",     	  	"padding-right:10px;" );
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
if( $post != null ){
	/* datos a grabar del reporte
	*/
	$db = SQL_Conexion();
	if( ! SQL_EsValido( $db ) ){
		// echo "no se pudo abrir la db " ;
		return false;
	}
	$idx = $post['idx'];
	$rep = new cReporteProduccion();
	$rep->db = $db;
	$rep->idx = $idx;

	if( ! $rep->VerificarModiPost($post) ){
		$p->body->DivOpen( "", "" );
		$p->body->AddHTML( "No se pudo validar el reporte: ".$rep->DetalleError );
		$p->body->DivClose( );
	} else {
		if( ! $rep->GrabarModiCabeceraPost($post) ){
			$p->body->DivOpen( "", "" );
			$p->body->AddHTML( "No se pudo registrar el reporte: ".$rep->DetalleError );
			$p->body->DivClose( );
		} else {
			$p->body->DivOpen( "", "" );
			$p->body->AddHTML( "Modificacion registrada con exito.-" );
			$p->body->DivClose( );
		}
	}
	
}

$post = $_GET;
if( $post != null ){
	// $fecha = $post['fecha'];
	$db = SQL_Conexion();
	if( ! SQL_EsValido( $db ) ){
		// echo "no se pudo abrir la db " ;
		return false;
	}
	$idx = $post['idx'];
	
	$rep = new cReporteProduccion();
	$rep->db = $db;
	$rep->idx = $idx;

	if( ! $rep->LeerIDX() ){
		$p->body->DivOpen( "", "" );
		$p->body->AddHTML( "No se encontro el reporte: ".$rep->DetalleError );
		$p->body->DivClose( );
	} else {
		$self = $_SERVER["PHP_SELF"];
		$p->body->AddHTML( '<form name="reporte" action="'.$self.'" method="post">' );
		
		$p->body->AddHTML( '<input type=hidden value="'.$idx.'" id="idx" name="idx" >' );
		$txt = GenerarInput( "Producto", "pro", "", 3, "pro", $rep->pro, "Escriba el codigo de producto" ); $p->body->AddHTML( $txt );
		$txt = GenerarInput( "Fecha", "fecha", "", 10, "fecha", $rep->fecha, "Escriba la Fecha del Reporte en formato DD-MM-AAAA" ); $p->body->AddHTML( $txt );
		$txt = GenerarInput( "Tirada Neta", "tiradaneta", "", 10, "tiradaneta", $rep->TiradaNeta, "Escriba la tirada neta" ); $p->body->AddHTML( $txt );
		$txt = GenerarInput( "Total Kgrs", "totalkgrs", "", 10, "totalkgrs", $rep->TotalKgrs, "Escriba el valor correspondiente" ); $p->body->AddHTML( $txt );
		$txt = GenerarInput( "Total Kgrs Capa Blanca", "totalkgrscb", "", 10, "totalkgrscb", $rep->TotalKgrsCapaBlanca, "Escriba el total de kgrs." ); $p->body->AddHTML( $txt );
		$txt = GenerarInput( "Observaciones", "obs", "", 10, "obs", $rep->Observaciones, "Escriba las observaciones correspondientes." ); $p->body->AddHTML( $txt );

		$p->body->AddHTML( '<input class="adminput" type="submit" value="Modificar Reporte" id="OK">' );
		
		$p->body->AddHTML( '</form>' );
		$p->body->DivOpen( "", "" );
		$p->body->AddHTML( "&nbsp;" );
		$p->body->DivClose( );

	}
	

		
} else {

// $self = $_SERVER["PHP_SELF"];
// $p->body->AddHTML( '<form name="reporte" action="'.$self.'" method="post">' );

// $p->body->AddHTML( '<input type=hidden value="1" id="nrotiradas" name="nrotiradas" >' );
// $txt = GenerarInput( "Desde Fecha", "fecini", "", 10, "fecini", "", "Escriba la Fecha Inicial a buscar en formato DD-MM-AAAA" ); $p->body->AddHTML( $txt );
// $txt = GenerarInput( "Hasta Fecha", "fecfin", "", 10, "fecfin", "", "Escriba la Fecha Final a buscar en formato DD-MM-AAAA" ); $p->body->AddHTML( $txt );

// $p->body->AddHTML( '<input class="adminput" type="submit" value="Agregar Tirada" id="AddTirada">' );
// $p->body->AddHTML( '<input class="adminput" type="submit" value="Consultar" id="OK">' );

// $p->body->AddHTML( '</form>' );

}

$p->body->DivOpen( "", "admitem ClearBoth " );
$p->body->AddHTML( "<a href='/index.php' class='ocultar'  >Volver al menú principal</a>" );
$p->body->DivClose( );


$res = $p->Render();
echo $res;



?>