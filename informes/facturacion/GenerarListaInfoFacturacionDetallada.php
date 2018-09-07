<?php 
include_once( "config.php" );
include_once( $DIST.$LIB."/fechas.php" );
include_once( $DIST.$LIB."/SQL.php" );
// GenerarListaInfoFacturacionDetalleCliente
function InfoFacturacionPostDetalleCliente( $db, $post ){
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
	$codpro = $post['prod'];
	$md5cli = $post['cli'];
	$desde = $post['desde'];
	$hasta = $post['hasta'];
	return GenerarListaInfoFacturacionDetalleCliente( $db, $codpro, $md5cli, $desde, $hasta );
}
function InfoFacturacionPostGenerarListaClientes( $db, $post ){
	if( ! isset( $post ) ){
		return false;
	}
	if( $post === null ){
		return false;
	}
	if( gettype( $post ) != "array" ){
		return false;
	}
	if( count( $post ) != 3 ) {
		return false;
	}
	if( ! isset( $post['prod']  ) ){ return false; }
	if( ! isset( $post['desde'] ) ){ return false; }
	if( ! isset( $post['hasta'] ) ){ return false; }
	$codpro = $post['prod'];
	$desde = $post['desde'];
	$hasta = $post['hasta'];
	return GenerarListaInfoFacturacionClientes( $db, $codpro,  $desde, $hasta );
}

function GenerarListaInfoFacturacionDetallada( $db, $codpro, $desde, $hasta ){
	$q = "call sp_InfoFacturacion( ";
	$q .= "'". $codpro ."' , ";
	$q .= "'". fecha2sql( $desde ) ."' , ";
	$q .= "'". fecha2sql( $hasta ) ."' ) ";
	return Query2Array( $db, $q );

}

function GenerarListaInfoFacturacionClientes( $db, $codpro, $desde, $hasta ){
	$q = "call sp_InfoFacturacionClientes( ";
	$q .= "'". $codpro ."' , ";
	$q .= "'". fecha2sql( $desde ) ."' , ";
	$q .= "'". fecha2sql( $hasta ) ."' ) ";
	return Query2Array( $db, $q );
}
// GenerarListaInfoFacturacionDetalleCliente
function GenerarListaInfoFacturacionDetalleCliente( $db, $codpro, $md5cli, $desde, $hasta ){
	$q = "call sp_InfoFacturacionDetalleCliente( ";
	$q .= "'". $codpro ."' , ";
	$q .= "'". $md5cli ."' , ";
	$q .= "'". fecha2sql( $desde ) ."' , ";
	$q .= "'". fecha2sql( $hasta ) ."' ) ";
	return Query2Array( $db, $q );
}


function Query2Array( $db, $q ) {
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
	if( $res  ){
		while( $obj = $res->fetch_assoc() ){
			$lista[] = $obj;
		}
		while ( $db->more_results() ){
			$db->next_result();
		}
	} else {
		return $db->error;
	}
	return $lista;
}
?>