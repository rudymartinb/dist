<?php 
// ordprod_nueva.php

include_once( "config.php" );


include_once( $DIST.$LIB."/fechas.php" );
include_once( $DIST.$LIB."/cHTML.php" );

include_once( $DIST.$LIB."/SQL.php" );
include_once( $DIST.$CLASS."/cProducto.php" );

include_once( $DIST."/reporteProduccion_botonAgregarTirada.php" );
include_once( $DIST."/ProcesarReporteProduccion.php" );

error_reporting(E_ALL);


$db = SQL_Conexion();


$p = new cHTML();

$p->head->titulo = "Reporte Produccion";
$p->head->AddMeta( "http-equiv='Content-Type' content='text/html; charset=iso-8859-1'"  );
$p->head->AddCSS( "/css/base.css" );
$p->head->AddJS( "/js/MandarAjax.js.php" );

$p->head->StyleAdd( "#admtitulo",     	  "font-family:courier new;font-weight:bold;text-align:left;font-size:28px;color:black;padding:1px;border:5px;width:100%;" );
$p->head->StyleAdd( "#admtitulo2",     	  "font-family:courier new;font-weight:bold;text-align:left;font-size:24px;color:black;padding:1px;border:5px;width:100%;" );
$p->head->StyleAdd( ".admitem",     	  "font-family:courier new;font-weight:bold;text-align:left;font-size:18px;color:black;padding:1px;border:5px;width:100%;" );
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
$p->body->AddHTML( "Reporte Produccion" );
$p->body->DivClose( );

/* generar listado clientes y productos.
*/
$post = $_POST;
if( $post != null ){
	$fecha = $post['fecha'];
	$db = SQL_Conexion();
	if( ! SQL_EsValido( $db ) ){
		// echo "no se pudo abrir la db " ;
		return false;
	}
	/* era todo risas hasta que hubo que recibir el post
	** el post debe venir con un indicativo de la cantidad de tiradas recibidas.
	** hace falta armar una funcion para desaparar los datos por tirada 
	** y grabarlos como vengan.
	*/
	// var_dump( $post );
	// $nrotiradas = $post['nrotiradas'];
	if( count( $_POST ) > 0 ){
		$DetalleError = ProcesarReporteProduccionVerificar( $_POST );
		if( $DetalleError != "" ){
			$p->body->AddHTML( $DetalleError );
			// echo ;
		} else {
			if( ProcesarReporteProduccion( $db , $_POST ) ){
				$p->body->AddHTML( "Reporte grabado exitosamente" );
			} else {
				$p->body->AddHTML( "Reporte NO grabado -- haga click en Atras y revise los datos.-" );

			}
		}
	}
	// return false;

		
} else {

$self = $_SERVER["PHP_SELF"];
$p->body->AddHTML( '<form name="reporte" action="'.$self.'" method="post">' );

$p->body->AddHTML( '<input type=hidden value="1" id="nrotiradas" name="nrotiradas" >' );
$txt = GenerarInput( "Producto", "pro", "", 3, "pro", "", "Escriba el codigo de producto" ); $p->body->AddHTML( $txt );
$txt = GenerarInput( "Fecha", "fecha", "", 10, "fecha", "", "Escriba la Fecha del Reporte en formato DD-MM-AAAA" ); $p->body->AddHTML( $txt );
$txt = GenerarInput( "Tirada Neta", "tiradaneta", "", 10, "tiradaneta", "", "Escriba la tirada neta" ); $p->body->AddHTML( $txt );
$txt = GenerarInput( "Total Kgrs", "totalkgrs", "", 10, "totalkgrs", "", "Escriba el valor correspondiente" ); $p->body->AddHTML( $txt );
$txt = GenerarInput( "Total Kgrs Capa Blanca", "totalkgrscb", "", 10, "totalkgrscb", "", "Escriba el total de kgrs." ); $p->body->AddHTML( $txt );
$txt = GenerarInput( "Observaciones", "obs", "", 200, "obs", "", "Escriba las observaciones correspondientes." ); $p->body->AddHTML( $txt );



$p->body->DivOpen( 'tiradas' );

$nro = 1;
$p->body->AddHTML( BotonAgregarTirada( $nro ) );


$p->body->DivClose();


$p->body->AddHTML( '<input class="adminput" type="submit" value="Agregar Tirada" id="AddTirada">' );
$p->body->AddScript( '
	
	$("#AddTirada").click( function(){
		
		AgregarTirada(  );
		return false;
	} );

	function AgregarTirada(  ){
		// $("#nrotiradas").val( nro );
		var nro = 1;
		nro = parseInt( $("#nrotiradas").val( ) );
		
		nro += 1;
		$("#nrotiradas").val( nro );
		
		var este = { "nro": nro  };
		data = MandarAjax( "/reporteProduccion_botonAgregarTirada.php", este );
		
		$("#tiradas").append(  data );
	}
	
' );

$p->body->AddHTML( '<input class="adminput" type="submit" value="Eliminar Ultima Tirada" id="DelTirada">' );
$p->body->AddHTML( '<script>
	$("#DelTirada").click( function() {
		var nro = 1;
		nro = parseInt($("#nrotiradas").val( ) );
		if( nro == 1 ){
			return false;
		}
		$("#tirada"+nro).remove();
		nro -= 1;
		$("#nrotiradas").val( nro );
		return false;
	} );
	</script>
' );


$p->body->AddHTML( '<input class="adminput" type="submit" value="Registrar Reporte" id="OK">' );

$p->body->AddHTML( '</form>' );

}

$p->body->DivOpen( "", "admitem ClearBoth " );
$p->body->AddHTML( "<a href='index.php' class='ocultar'  >Volver al menú principal</a>" );
$p->body->DivClose( );


$res = $p->Render();
echo $res;







?>