<?php

include_once( "config.php" );

include_once( $DIST.$LIB."/fechas.php" );
include_once( $DIST.$LIB."/SQL.php" );

error_reporting(E_ALL);

/* para rellenar el almanaque con valores
*/ 
function ObtenerListaDias( $db, $post ){

	if( $db == null ){
		return null;
	}
	if( $post == null ){
		return null;
	}
	
	if( !GenerarListaCant_EsValido( $post ) ) {
		return null;
	}

	$periodo = $post['periodo'];
	$cli = $post['cli'];
	$prod = $post['prod'];
	
	$q = "call sp_AgendaEntregaLeerPeriodoClienteProducto(";
	$q .= "'". $cli . "',";
	$q .= "'". $prod . "',";
	$q .= "'". $periodo . "' );";
	// echo $q;
	// echo "query";
	try {
		$res = $db->query( $q );
	} catch ( Exception $e ) {
		$error = $e->getMessage() ;
		echo  $error;
		return;
	}
	if( $res === FALSE ) {
		$error = "Error: ". $db->error ;
		echo  $error;
		return;
	}
	
	$arr = [];
	if( $res ) {
		// echo "leyendo";
		while( $obj = $res->fetch_object() ){
			$dia = Sql2Fecha( $obj->fecage );
			$cant1 = $obj->cant1;
			$cant2 = $obj->cant2;
			$arr[] = [ $dia, $cant1, $cant2 ];
		}
		while( $db->more_results() ){
			$db->next_result();
		}
	}
	return $arr;
}


function GenerarListaCantidades( $db, $cli, $prod, $periodo  ){
	if( $db == null ){
		return null;
	}
	
	$q = "call sp_AgendaEntregaLeerPeriodoClienteProducto(";
	$q .= "'". $cli . "',";
	$q .= "'". $prod . "',";
	$q .= "'". $periodo . "' );";
	try {
		$res = $db->query( $q );
	} catch ( Exception $e ) {
		$error = $e->getMessage() ;
		echo  $error;
		return;
	}
	if( $res === FALSE ) {
		$error = "Error: ". $db->error ;
		echo  $error;
		return;
	}
	
	$arr = [];
	if( $res  ) {
		while( $obj = $res->fetch_object() ){
			$dia = substr(  Sql2Fecha( $obj->fecage ) , 0, 2 );
			$cant1 = $obj->cant1;
			$cant2 = $obj->cant2;
			$cant3 = $obj->cant3;
			$arr[] = [ $dia, $cant1, $cant2, $cant3 ];
		}
		while( $db->more_results() ){
			$db->next_result();
		}
	}
	// var_dump( $arr );
	$cantdias = CantidadDias( $periodo );
	/* generar array con cantidad de dias
	*/
	$listadias = [];
	for( $i = 1; $i <= $cantdias ; $i ++ ){
		$listadias[$i] = [0,0,0];
	}
	for( $i = 0; $i < count( $arr ) ; $i ++ ){
		$dia = intval( $arr[$i][0] );
		$listadias[ $dia  ] = [ $arr[$i][1], $arr[$i][2], $arr[$i][3] ];
	}
	
	return $listadias;
	
}

function GenerarListaCant_EsValido( $post ) {
	if( $post == null ){
		return false;
	}
	if( gettype( $post ) != "array" ){
		return false;
	}
	/* determinar que tenga los tres elementos
	*/
	if( ! array_key_exists( "periodo", $post ) ){
		return false;
	}
	if( ! array_key_exists( "cli", $post ) ){
		return false;
	}	
	if( ! array_key_exists( "prod", $post ) ){
		return false;
	}
	return true;
}
?>
