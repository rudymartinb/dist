<?php
include_once( "config.php" );
include_once( $DIST.$LIB."/SQL.php" );
include_once( $DIST.$CLASS."/cReporteDevolucion.php" );

$post = $_POST;
if( isset( $post )  and count( $post ) == 4 ){
	$db = SQL_Conexion();
	echo ajaxRegistrarDevolucion( $db, $post );
}

function ajaxRegistrarDevolucion( $db, $post ){
	if( ! SQL_EsValido( $db ) ) {
		return false;
	}
	if( count( $post ) != 4 ){
		return false;
	}
	if( !isset( $post['cli'] ) ){
		return false;
	}
	if( !isset( $post['prod'] ) ){
		return false;
	}
	if( !isset( $post['cant'] ) ){
		return false;
	}
	if( !isset( $post['fecha'] ) ){
		return false;
	}
	
	$rep = new cReporteDevolucion();
	$rep->db = $db;
	$rep->fecha = $post['fecha'];
	$rep->cli = $post['cli'];
	$rep->prod = $post['prod'];
	$rep->cant = $post['cant'];
	if( !$rep->Registrar() ){
		return $rep->DetalleError;
	}
	return true;
	// $this->assertEquals( true,  , $rep->DetalleError );
}

?>