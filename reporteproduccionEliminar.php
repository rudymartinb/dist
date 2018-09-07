<?php 
// ordprod_nueva.php

include_once( "config.php" );


include_once( $DIST.$LIB."/fechas.php" );
include_once( $DIST.$LIB."/cHTML.php" );

include_once( $DIST.$LIB."/SQL.php" );
include_once( $DIST.$CLASS."/cProducto.php" );

include_once( $DIST.$CLASS."/cReporteProduccion.php" );
include_once( $DIST.$CLASS."/cReporteTirada.php" );

include_once( $DIST."/ProcesarReporteProduccion.php" );

error_reporting(E_ALL);


$db = SQL_Conexion();
	



$p = new cHTML();

$p->head->titulo = "Eliminacion de Reporte Produccion";
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
$p->body->AddHTML( "Consulta Reporte Produccion" );
$p->body->DivClose( );

$post = $_POST;
if( $post != null ){
	// $fecha = $post['fecha'];
	$db = SQL_Conexion();
	if( ! SQL_EsValido( $db ) ){
		// echo "no se pudo abrir la db " ;
		return false;
	}
	$fecini = $post['fecini'];
	$fecfin = $post['fecfin'];
	// $idx = $post['id'];
	$arr = ObtenerListaReportesProduccion( $db, $fecini, $fecfin );
	if( count( $arr ) == 0 ){
		$p->body->DivOpen( "", "" );
		$p->body->AddHTML( "No se encontraron reportes entre las fechas seleccionadas" );
		$p->body->DivClose( );
	} else {
		/* generar cabecera reporte
		*/
		$p->body->DivOpen( "", "size100 floatLeft couriernew bold marginright10" );
		$p->body->AddHTML( "Fecha" );
		$p->body->DivClose( );

		$p->body->DivOpen( "", "size200 floatLeft marginright10 couriernew bold" );
		$p->body->AddHTML( "PRODUCTO" );
		$p->body->DivClose( );
		
		$p->body->DivOpen( "", "size100 floatLeft textoDerecha marginright10 couriernew bold" );
		$p->body->AddHTML( "TOT.KGRS." );
		$p->body->DivClose( );
		
		$p->body->DivOpen( "", "size400 floatLeft couriernew bold" );
		$p->body->AddHTML( "OBSERVACIONES" );
		
		$p->body->DivClose( );

		$p->body->DivOpen( "", "" );
		$p->body->AddHTML( "&nbsp;" );
		$p->body->DivClose( );

		/* generar lista de repotes
		*/
		$self = "reporteproduccioneliminar2.php";
		for( $i = 0; $i < count( $arr ); $i++ ){
			// idx, fecrep, totkgrep, totkgcbrep, obsrep, regrep
			$p->body->DivOpen( "", "" );
				
				$p->body->DivOpen( "", "size100 floatLeft couriernew marginright10 " );
				$p->body->AddHTML( "<a href='".$self."?id=".$arr[$i]['idx']."'>".$arr[$i]['fecrep']."</a>" );
				$p->body->DivClose( );

				$p->body->DivOpen( "", "size200 floatLeft couriernew marginright10 " );
				$p->body->AddHTML( $arr[$i]['prorep']." ".$arr[$i]['despro'] );
				$p->body->DivClose( );
				
				$p->body->DivOpen( "", "size100 floatLeft textoDerecha marginright10 couriernew" );
				$p->body->AddHTML( $arr[$i]['totkgrep'] );
				$p->body->DivClose( );
				
				$p->body->DivOpen( "", "size400 floatLeft couriernew" );
				if( trim( $arr[$i]['obsrep'] ) != "" ){
					$p->body->AddHTML( $arr[$i]['obsrep'] );
				} else {
					$p->body->AddHTML( "&nbsp;" );
				}
				$p->body->DivClose( );

				$p->body->DivOpen( "", "" );
				$p->body->AddHTML( "&nbsp;" );
				$p->body->DivClose( );
				
			$p->body->DivClose( );
		}
	}

		
} else {

$self = $_SERVER["PHP_SELF"];
$p->body->AddHTML( '<form name="reporte" action="'.$self.'" method="post">' );

$p->body->AddHTML( '<input type=hidden value="1" id="nrotiradas" name="nrotiradas" >' );
$txt = GenerarInput( "Desde Fecha", "fecini", "", 10, "fecini", "", "Escriba la Fecha Inicial a buscar en formato DD-MM-AAAA" ); $p->body->AddHTML( $txt );
$txt = GenerarInput( "Hasta Fecha", "fecfin", "", 10, "fecfin", "", "Escriba la Fecha Final a buscar en formato DD-MM-AAAA" ); $p->body->AddHTML( $txt );

// $p->body->AddHTML( '<input class="adminput" type="submit" value="Agregar Tirada" id="AddTirada">' );
$p->body->AddHTML( '<input class="adminput" type="submit" value="Consultar" id="OK">' );

$p->body->AddHTML( '</form>' );

}

$p->body->DivOpen( "", "admitem ClearBoth " );
$p->body->AddHTML( "<a href='index.php' class='ocultar'  >Volver al menú principal</a>" );
$p->body->DivClose( );


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