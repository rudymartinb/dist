<?php
include_once( "config.php" );
include_once( $CLASS."cContacto.php" );
// include_once( "/develop/agenda/cAgenda.php" );
include_once( $AGENDA."baseSQL.php" );

/* 
para el testing este ajax debe devolver un arrar codificado.
*/
	// error_log( $AGENDA );
	$db = SQL_Conexion();
	echo ajaxDatos( $db, $_POST );
	// error_log( "ajax" );

function ajaxDatos( $db, $post ){
	if( ! isset( $db ) ){
		return "db" ;
	}

	$res = "";
		
	if( mysqli_connect_errno() ) {
		return mysqli_connect_error();
	}
	if( get_class( $db ) != "mysqli"){
		return "Error db";
	}
	
	$devolver = arrayDatos( $db, $post );
	return  json_encode( $devolver );
}

function arrayDatos( $db, $post ){
	if( ! isset( $db ) ){
		return "db" ;
	}

	$res = "";
		
	if( mysqli_connect_errno() ) {
		return mysqli_connect_error();
	}
	if( get_class( $db ) != "mysqli"){
		return "Error db";
	}
	$q = "select * from agenda.contactos order by raz;";
	try {
	$res = $db->query( $q );
	} catch ( Exception $e ) {
		$error = $e->getMessage() ;
		return  "<div>Error1: $error</div>";
	}
	if( $res === FALSE ) {
		$error = "Error: ". $db->error ;
		return  "<div>Error2: $db->error</div>";
	}

	$actual = 0;
	$devolver = [] ;
	
	while( $obj = $res->fetch_object() ){ 
	
		$nom = utf8_encode( $obj->raz );
		$dom = utf8_encode( $obj->dom );
		$loc = utf8_encode( $obj->loc );
		$cpo = utf8_encode( $obj->cpo );
		$tel = utf8_encode( $obj->tel );
		$cel = utf8_encode( $obj->celu );
		$ema = utf8_encode( $obj->email );
		$web = utf8_encode( $obj->web );
		$tw  = utf8_encode( $obj->tw );
		$fb  = utf8_encode( $obj->fb );
		$obs = utf8_encode( $obj->obs );
		$barrio = utf8_encode( $obj->barrio );
		$cat = utf8_encode( $obj->categoria );
		$con = utf8_encode( $obj->contacto );
		$empresa = utf8_encode( $obj->empresa );
		$cargo = utf8_encode( $obj->cargo );

		$arr = [];
		$arr['raz'] = $nom;
		$arr['dom'] = $dom;
		$arr['tel'] = $tel;
		$arr['cel'] = $cel;
		$arr['idx'] 	= $obj->idx;
		
		// if( $actual == $seleccion ) {
			$devolver[] = $arr;
		// }
		$actual ++;
	}
	$res->close();
	if( $db->more_results() ){
		$db->next_result();
	}
	// $db->close();
	return  $devolver ;
}

?>
