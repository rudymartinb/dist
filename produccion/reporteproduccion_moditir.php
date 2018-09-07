<?php
include_once( "config.php" );
include_once( $DIST.$LIB."/SQL.php" );


include_once( $DIST.$LIB."/fechas.php" );
include_once( $DIST.$LIB."/cHTML.php" );
include_once( $DIST.$LIB."/forms.php" );
include_once( $DIST.$CLASS."/cReporteProduccion.php" );
error_reporting(E_ALL);



$p = new cHTML();

$p->head->titulo = "Modificar Tirada Reporte Produccion";
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
		echo "no se pudo abrir la db " ;
		return false;
	}
	$idx = $post['idx'];
	$rep = new cReporteTirada();
	$rep->db = $db;
	// $rep->idx = $idx;
	$rep->LeerIDX($idx);

	if( ! $rep->VerificarModiTiradaPost($post) ){
		$p->body->DivOpen( "", "" );
		$p->body->AddHTML( "No se pudo validar el reporte(1): ".$rep->DetalleError );
		$p->body->DivClose( );
	} else {
		if( ! $rep->GrabarModiTiradaPost($post) ){
			$p->body->DivOpen( "", "" );
			$p->body->AddHTML( "No se pudo registrar el reporte(2): ".$rep->DetalleError );
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
	
	$rep = new cReporteTirada();
	$rep->db = $db;
	$rep->LeerIDX($idx);
	// $rep->idx = $idx;
	
	$self = $_SERVER["PHP_SELF"];
	$p->body->AddHTML( '<form name="reporte" action="'.$self.'" method="post">' );
	$p->body->AddHTML( '<input type=hidden value="'.$idx.'" id="idx" name="idx" >' );
	$p->body->DivOpen( 'tirada' );
	// $p->body->AddHTML( '<hr>' );
	// $p->body->AddHTML( '<div class="admitem">Tirada Nro '.$nro.'</div>' );


	$p->body->AddHTML( '<hr>' );

	$p->body->DivOpen( 'hora' );

	$nro = "";
	$p->body->DivOpen( 'hora_ini', 'size400 floatLeft' );
	$txt = GenerarInput( "Hora Inicial", "horaini".$nro, "", 5, "horaini".$nro, $rep->horaini, "Escriba la hora inicial" ); $p->body->AddHTML( $txt );
	$p->body->DivClose();

	$p->body->DivOpen( 'hora_fin', '' );
	$txt = GenerarInput( "Hora Final", "horafin".$nro, "", 5, "horafin".$nro, $rep->horafin, "Escriba la hora de finalización" );$p->body->AddHTML( $txt );
	$p->body->DivClose(); // horafin
	$p->body->DivClose(); // hora

	$p->body->DivOpen( 'nro_maqini' );
	$p->body->DivOpen( 'nromaqini' , 'size400 floatLeft' );
	$txt = GenerarInput( "Nro. Inicial Maquina", "maqini".$nro, "", 10, "maqini".$nro, $rep->MaqIni, "Escriba el nro inicial de maquina" );$p->body->AddHTML( $txt );
	$p->body->DivClose();

	$p->body->DivOpen( 'nro_maqfin' , '' );
	$txt = GenerarInput( "Nro. Final Maquina", "maqfin".$nro, "", 10, "maqfin".$nro, $rep->MaqFin, "Escriba el nro final de maquina" );$p->body->AddHTML( $txt );
	$p->body->DivClose();
	$p->body->DivClose();


	$txt = GenerarInput( "Tirada Bruta", "tiradabruta".$nro, "", 10, "tiradabruta".$nro, $rep->TiradaBruta, "Escriba la Tirada Bruta" ); $p->body->AddHTML( $txt );
	$txt = GenerarInput( "Carga", "carga".$nro, "", 10, "carga".$nro, $rep->Carga, "Escriba la carga" ); $p->body->AddHTML( $txt );
	$txt = GenerarInput( "Desperdicio", "desperdicio".$nro, "", 10, "desperdicio".$nro, $rep->Desperdicios, "Escriba el desperdicio" ); $p->body->AddHTML( $txt );
	$txt = GenerarInput( "Kgrs", "kgrs".$nro, "", 10, "kgrs".$nro, $rep->Kgrs, "Escriba los kgrs" ); $p->body->AddHTML( $txt );
	$txt = GenerarInput( "Cant. Páginas Color", "pagcolor".$nro, "", 10, "pagcolor".$nro, $rep->pagtotal, "Escriba la cantidad de paginas a color" ); $p->body->AddHTML( $txt );
	$txt = GenerarInput( "Cant. Páginas Total", "pagtotal".$nro, "", 10, "pagtotal".$nro, $rep->pagcolor, "Escriba la cantidad total de paginas " ); $p->body->AddHTML( $txt );

	$p->body->AddHTML( '<input class="adminput" type="submit" value="Modificar Reporte" id="OK">' );
	$p->body->AddHTML( '</form>' );


	$p->body->AddHTML( '<hr>' );
	$p->body->DivClose();

	// }
	

		
} else {


}

$p->body->DivOpen( "", "admitem ClearBoth " );
$p->body->AddHTML( "<a href='/index.php' class='ocultar'  >Volver al menú principal</a>" );
$p->body->DivClose( );


$res = $p->Render();
echo $res;



?>