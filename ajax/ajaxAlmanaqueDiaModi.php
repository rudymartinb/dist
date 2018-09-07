<?php
/* 
t1201405001001000010
12345678901234567890
t1
201405
001
001
000010
		$pak = "201406001001t1s01000003";
		//		12345678901234567890123
 $periodo, $cli, $prod, $cant1, $cant2
*/
include_once( "config.php" );

include_once( $DIST.$LIB."/fechas.php" );
include_once( $DIST.$LIB."/SQL.php" );

require_once( $DIST."/src/db/mysqldb.php" );
require_once( $DIST."/src/db/ejecutarquery.php" );

/* true si se pudo efectuar la grabacion.
*/
if( isset( $_POST ) ){
	$post = $_POST;
	if( ajaxEsValidoPak( $post ) ){
		$db = MySQLDB();
		
		ejecutar_query( "start transaction;" );
		
		echo ajaxDiaModi( $db, $post );
		
		ejecutar_query( "commit;" );

		return ;
	}
	// echo "no era valido el pak? ".$post;
}
// echo "no habia post?";

function ajaxAbrirPak( $post ){
	if( ! ajaxEsValidoPak( $post ) ){
		return false;
	}
	$pak = $post['href'];
	$periodo = substr( $pak, 0,6 );
	$cli = substr( $pak, 6, 3 );
	$prod  = substr( $pak, 9, 3 );
	$tipo = substr( $pak, 12, 2 );
	// s entre medio de tipo y dia
	$dia = substr( $pak, 15, 2 );
	$cant  = substr( $pak, 17, 6 );
	
	$arr = [];
	$arr['tipo'] = $tipo;
	$arr['periodo'] = $periodo;
	$arr['cli'] = $cli;
	$arr['prod'] = $prod;
	$arr['cant'] = $cant;
	$arr['dia'] = $dia;
	
	return $arr;
}
function ajaxDiaModi( $db, $post ){
	$db = MySQLDB();
	/*
	if( ! SQL_EsValido( $db ) ){
		return false;
	}
	*/
	if( ! ajaxEsValidoPak( $post ) ) {
		return false;
	}
	$arr = ajaxAbrirPak( $post );
	$tipo = $arr['tipo'];
	$periodo = $arr['periodo'];
	$cli = $arr['cli'];
	$prod = $arr['prod'];
	$cant = $arr['cant'];
	$dia = $arr['dia'];
	
	// armar fecha.
	$ano = substr( $periodo, 0, 4 );
	$mes = substr( $periodo, 4, 2 );
	$fecha = fecha2SQL( $dia."-".$mes."-".$ano ) ;

	switch( $tipo ){
		case "t1":{
			$q = "call sp_AgendaActualizarCant1(";
			break;
		}
		case "t2":{
			$q = "call sp_AgendaActualizarCant2(";
			break;
		}
		case "t3":{
			$q = "call sp_AgendaActualizarCant3(";
			break;
		}
	}

	$q .= "'". $cli ."'," ;
	$q .= "'". $prod ."'," ;
	$q .= "'". $fecha ."'," ;
	$q .= "'". $cant ."')" ;
	
	ejecutar_query( $q );
	/*
	try {
		$res = $db->query( $q );
	} catch ( Exception $e ) {
		$DetalleError = $e->getMessage() ;
		echo $DetalleError;
		return false;
	}
	if( $res === FALSE ) {
		$DetalleError = "Error : ". $db->error ;
		echo $DetalleError;
		return false;
	}
	*/
	
	
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
	$result = false;
	if( $res ) {
		while( $obj = $res->fetch_object() ){
			// echo gettype( $obj->result );
			if( $obj->result == 1 ){
				$result = true ;
			}
		}
		while ( $db->more_results() ){
			$db->next_result();
		}
	}	
	
	return $result;
}

function ajaxEsValidoPak( $post ){
	if( !isset( $post ) ){
		return false;
	}
	if( gettype( $post ) != "array" ){
		return false;
	}
	if( ! array_key_exists( "href", $post ) ){
		return false;
	}
	$pak = $post['href'];
	return true;

}
?>
