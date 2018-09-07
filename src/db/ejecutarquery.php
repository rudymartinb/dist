<?php
error_reporting( E_ALL );

/*
 * ejecuta una consulta, devuelve un array con los registros si es consulta
 * o devuelve un bool si no tiene nada para devolver
 * 
 * TODO: hacer de todo esto un Singleton y que esto sea un metodo de una clase de objeto?
*/

function ejecutar_query( $query ){
	$db = MySQLDB();
	
	try{
		$resultado = $db->query( $query, MYSQLI_STORE_RESULT  );
	} catch( Exception $e ) {
		throw new Exception( $e->message.' --> '. $e->getTraceAsString() );
	}
	
	if( $db->errno != 0 ){
		throw new Exception( $db->error );
	}
	if( gettype( $resultado ) == "boolean" )
		return $resultado ;
		
	// $lista = $resultado->fetch_all( MYSQLI_ASSOC );
	$lista = [];
	while( $arr = $resultado->fetch_array( MYSQLI_ASSOC ) ){
		$lista[] = $arr;
	}
	// $resultado->fetch_all( MYSQLI_ASSOC );
	
	
	$resultado->free();
	
	/*
	 * las lineas q siguen estan pensadas para evitar el error
	 * "Exception: Commands out of sync; you can't run this command now"
	 * https://dev.mysql.com/doc/refman/5.7/en/commands-out-of-sync.html
	*/
	while( $db->more_results() ){
		$db->next_result();
		// TO-DO: estaria faltando obtener el resultado?
	}
		
	//
	return $lista;
}

?>
