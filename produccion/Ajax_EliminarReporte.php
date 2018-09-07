<?php
include_once( "config.php" );
include_once( $DIST.$LIB."/SQL.php" );

// 13:35 12/12/2014
// fuente verificado por testReporteProduccion_AjaxEliminar.php

/* esta seccion de codigo ejecutada desde navegador
*/
$post = $_POST;
if( ajax_EliminarReporteProduccion_ValidarPost( $post ) ){
	
}

// verificado por testValidarPost 
function ajax_EliminarReporteProduccion_ValidarPost( $post ){
	if( !isset( $post ) ){ return false; }
	if( gettype( $post ) != 'array' ){ return false; }
	if( !isset( $post['nro'] ) ){ return false; }
	return true;
}
function ajax_EliminarReporteProduccion( $db , $post ){
	if( ! ajax_EliminarReporteProduccion_ValidarPost( $post ) ){
		return false;
	}
	$idx = $post['nro'];
	$q = "call sp_ReporteProduccionEliminar( ".$idx." ); ";
	$res = $db->query( $q );
	return $res ;
	

}

?>