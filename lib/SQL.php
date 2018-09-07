<?php
require_once( $DIST."/config.php" );
// echo $SERVER;
require_once( $DIST.$LIB."/PadN.php" );
require_once( $DIST.$LIB."/TiposDatos.php" );

function PostLogin( $post ){
	
	if( ! isset( $post ) ){
		// por logica esta linea de codigo nunca podria ejecutarse
		error_log( "sin post" );
		return false;
	}
	if( count( $post ) != 3 ){
		error_log( "sin post" );
		return false;
	}
	
	$user = $post['user'];
	$pass = $post['pass'];
	if( $user == null ){
		return false;
	}
	if( $pass == null ){
		return false;
	}
	$db = SQL_Login( $user , $pass );
	return $db;
}

function SQL_Login( $user = "", $pass = ""){
	if( $user == "" or $pass == "" )
		return false;
	
	$conectado = false;
	if( isset( $db ) ){
		if( gettype( $db ) == "object" ) {
			if( get_class(  $db  ) == "mysqli"){
				$conectado = true;
			}
		}
	}
	if( ! $conectado ){
		try {
			// $CATALOG = "dist"; en config.php
			$db = new mysqli("127.0.0.1" , $user, $pass, $CATALOG  );
		} catch ( Exception $e ) {
			return false;
		}
		if( mysqli_connect_errno() ) {
			return false;
		}
	}
	return $db;

}


function SQL_EsValido( $db ) {
	$valido = false;
	if( isset( $db ) ){
		if( gettype( $db ) == "object" ) {
			// puede que la clase sea un Mock
			if( strpos( get_class(  $db  ), "mysqli" ) >= 0  ){
				$valido = true;
			}
		}
	}
	return $valido;
}

function myquery( $db, $query ){
}

function last_result( $db ) {
	if( !SQL_EsValido( $db ) ){
		return false;
	}
	
	$q = "call dev_last_result()";
	try {
		$res = $db->query( $q );
	} catch ( Exception $e ) {
		$DetalleError = $e->getMessage() ;
		echo $DetalleError;
		return false;
	}
	if( $res === FALSE ) {
		$DetalleError = "Error: ". $db->error ;
		echo $DetalleError;
		return false;
	}
	$arr = [];
	$result = false;
	if( $db->more_results() ) {
		if( $obj = $res->fetch_object() ){
			$result = ( $obj->result == '1') ;
			
		}
		while ( $db->more_results() ){
			$db->next_result();
		}
	}
	return $result;
}


function SQL_DetalleError( $db ) {
	if( !SQL_EsValido( $db ) ){
		return false;
	}
	
	$q = "select @DetalleError as detalle";
	try {
		$res = $db->query( $q );
	} catch ( Exception $e ) {
		$DetalleError = $e->getMessage() ;
		echo $DetalleError;
		return false;
	}
	if( $res === FALSE ) {
		$DetalleError = "Error: ". $db->error ;
		echo $DetalleError;
		return false;
	}
	$arr = [];
	$result = false;
	if( $db->more_results() ) {
		if( $obj = $res->fetch_object() ){
			$result = $obj->detalle ;
		}
		while ( $db->more_results() ){
			$db->next_result();
		}
	}
	return $result;
}



function QueryRecCount( $db, $q ) {
	if( !SQL_EsValido( $db ) ){
		return -1;
	}
	
	try {
		$res = $db->query( $q );
	} catch ( Exception $e ) {
		$DetalleError = $e->getMessage() ;
		throw new Exception( "QueryRecCount query: ".$DetalleError );
		return -1;
	}
	if( $res === FALSE ) {
		$DetalleError = $db->error ;
		error_log( "QueryRecCount false: ".$DetalleError );
		return -1;
	}
	
	/* pesando para mocking, tiene sentido todo esto???
	*/
	if( !EsClase( $res, "mysqli_result" ) ){
		return 0;
	}
	$count = mysqli_num_rows( $res );
	while ( $db->more_results() ){
		$db->next_result();
	}
	return $count;
}


/* tiene q desaparecer, 
ademas deberia recibir DB por parametro
*/
function SQL_Conexion(){
	$conectado = false;
	if( isset( $db ) ){
		if( gettype( $db ) == "object" ) {
			if( get_class(  $db  ) == "mysqli"){
				$conectado = true;
			}
		}
	}
	
	global $SERVER, $USER, $PASS, $CATALOG;

	if( ! $conectado ){
		$db = new mysqli($SERVER , $USER, $PASS, $CATALOG  );
		if( mysqli_connect_errno() ) {
			return mysqli_connect_error();
		}
	} else {
		
	}
	return $db;
}


/* 
	tiene que desaparecer
	igual q la anterior pero conecta con diferente catalogo
	le falta parametro. probablemente las haya usando en clases demo
	y pasando parametro la puedo reutilizar
*/
function SQL_Conexion_Demo(){
	$conectado = false;
	if( isset( $db ) ){
		if( gettype( $db ) == "object" ) {
			if( get_class(  $db  ) == "mysqli"){
				$conectado = true;
			}
		}
	}
	if( ! $conectado ){
		$db = new mysqli("127.0.0.1" , "root", "sunpei42","dist"  );
		if( mysqli_connect_errno() ) {
			return mysqli_connect_error();
		}
	} else {
		
	}
	return $db;
}

?>
