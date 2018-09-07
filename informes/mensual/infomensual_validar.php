<?php
/* esta funcion es revisada por 
	/test/php/testReporteMensual.php
*/
function GenerarReporteMensual( $db, $prod, $desde, $hasta ){
	$lista = [];
	
	$q = "call sp_InformeMensual( '".fecha2sql($desde)."','".fecha2sql($hasta)."' )";
	$res = $db->query( $q );
	if( ! $res ) {
		echo $db->error;
		return ;
	}
	while( $arr = $res->fetch_assoc()){
		$lista[] = $arr;
	}
	$res->close();
	while ( $db->more_results() ){
		$db->next_result();
	}
	return $lista;
}

/* esta funcion es revisada por 
	/test/php/testReporteMensual.php
*/
function InfoMenusualPost( $db, $post ){
	if( ! InfoMenusualValidarPost ($post ) ){
		return false;
	}
	$prod = $post['codprod'];
	$desde = $post['desde'];
	$hasta = $post['hasta'];
	return GenerarReporteMensual( $db, $prod, $desde, $hasta );
	
}

/* esta funcion es revisada por 
	/test/php/testReporteMensual.php
*/
function InfoMenusualValidarPost( $post ){
	if( ! isset( $post ) ){
		return false;
	}
	if( gettype( $post  ) != "array" ){
		return false;
	}
	if( count( $post ) != 3 ){
		return false;
	}
	if ( !isset( $post['codprod'] ) ) { return false; }
	if ( !isset( $post['desde'] ) ){ return false; }
	if ( !isset( $post['hasta'] ) ){ return false; }
	return true;
}

?>