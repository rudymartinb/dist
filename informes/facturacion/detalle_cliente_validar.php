<?php

include_once( "config.php" );
include_once( $DIST."/informes/facturacion/GenerarListaInfoFacturacionDetallada.php" );
include_once( $DIST."/informes/facturacion/InfoFacturacionValidarPost.php" );
include_once( $DIST.$LIB."/fechas.php" );
include_once( $DIST.$LIB."/SQL.php" );
include_once( $DIST.$LIB."/cHTML.php" );

// $post = $_GET;

function InfoFactDetalleCli_ValidarPost( $post ){
	if( ! isset( $post ) ){
		return false;
	}
	if( $post === null ){
		return false;
	}
	if( gettype( $post ) != "array" ){
		return false;
	}
	if( count( $post ) != 4 ) {
		return false;
	}
	if( ! isset( $post['prod']  ) ){ return false; }
	if( ! isset( $post['cli']  ) ){ return false; }
	if( ! isset( $post['desde'] ) ){ return false; }
	if( ! isset( $post['hasta'] ) ){ return false; }
	return true;
}

?>