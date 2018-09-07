<?php
/*
necesito una opcion donde se indique
producto
fecha
y traiga la lista existente de cambios de precios
permite agregar y borrar

quiero estrenar el achoice que hice para la agenda.

*/

include_once( "config.php" );
// include_once( $DIST.$CLASS."/cNuevaAgenda.php" );
// include_once( $DIST."/GenerarListaCantidades.php" );
include_once( $DIST.$LIB."/fechas.php" );
include_once( $DIST.$LIB."/SQL.php" );

error_reporting(E_ALL);

function CambioPrecioValidarPost( $post ){
	if( ! isset( $post ) ){
		return "sin post";
	}
	if( gettype( $post ) != "array" ){
		return "no es array";
	}
	if( count( $post ) != 9 ){
		return "faltan datos";
	}
	if( ! isset( $post['codpro'] ) ) { return false; }
	if( ! isset( $post['fecha'] ) ) { return false; }
	if( ! isset( $post['pre1'] ) ) { return false; }
	if( ! isset( $post['pre2'] ) ) { return false; }
	if( ! isset( $post['pre3'] ) ) { return false; }
	if( ! isset( $post['pre4'] ) ) { return false; }
	if( ! isset( $post['pre5'] ) ) { return false; }
	if( ! isset( $post['pre6'] ) ) { return false; }
	if( ! isset( $post['pre7'] ) ) { return false; }
	
	return true;
}

function CambioPreciosAltaPost( $db, $post ){
	if( ! CambioPrecioValidarPost( $post ) ){
		return false;
	}
	$pro =  $post['codpro'];
	$fec =  $post['fecha'] ;
	$pre1 =  $post['pre1'] ;
	$pre2 =  $post['pre2'] ;
	$pre3 =  $post['pre3'] ;
	$pre4 =  $post['pre4'] ;
	$pre5 =  $post['pre5'] ;
	$pre6 =  $post['pre6'] ;
	$pre7 =  $post['pre7'] ;
	
	return CambioPreciosAlta( $db, $pro, $fec,$pre1,$pre2,$pre3,$pre4,$pre5,$pre6,$pre7 )	;;
}


function ListaCambiosPrecios( $db, $pro ){
	$q = "call sp_CambioPrecioLista( '".$pro."' ); ";
	
	try {
		$res = $db->query( $q );
	} catch ( Exception $e ) {
		$error = $e->getMessage() ;
		return $error;
	}	
	if( ! $res ) {
		return $db->error;
	}
	$lista = [];
	while( $obj = $res->fetch_assoc() ){
		$lista[] = $obj;
	}
	while ( $db->more_results() ){
		$db->next_result();
	}

	return $lista;

}
function DeterminarPrecio( $db, $pro, $fec ) {
	$q = "select PrecioSegunFecha( '".$pro."', ";
	$q .= "'".fecha2SQL($fec)."' ) as precio";
	try {
		$res = $db->query( $q );
	} catch ( Exception $e ) {
		$error = $e->getMessage() ;
		// echo  $error;
		return $error;
	}	
	$precio = null;
	// if( $db->more_results() ) {
		if( $obj = $res->fetch_object() ){
			$precio = $obj->precio ;
		}
		while ( $db->more_results() ){
			$db->next_result();
		}
	// }

	return $precio;
	
}
function CambioPreciosAlta( $db, $pro, $fec,$pre1,$pre2,$pre3,$pre4,$pre5,$pre6,$pre7 ) {
	$q = "call sp_CambioPrecio( '".$pro."', ";
	$q .= "'".fecha2SQL($fec)."', ";
	$q .= $pre1.",";
	$q .= $pre2.",";
	$q .= $pre3.",";
	$q .= $pre4.",";
	$q .= $pre5.",";
	$q .= $pre6.",";
	$q .= $pre7." )";
	
	try {
		$res = $db->query( $q );
		return true;
	} catch ( Exception $e ) {
		$error = $e->getMessage() ;
		// echo  $error;
		return $error;
	}	
	return false; ;
}
?>