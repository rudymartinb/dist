<?php
function ArmarTiradaDiaria( $db, $fec ){

	$q = "call sp_TiradaDiaria( '$fec' )";
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
	if( $db->more_results() ) {
		while( $obj = $res->fetch_object() ){
			$v = [];
			$v['proage'] = $obj->proage; 
			$v['despro'] = $obj->despro; 
			$v['grucli'] = $obj->grucli; 
			$v['desgru'] = $obj->desgru; 
			$v['cliage'] = $obj->cliage; 
			$v['razcli'] = $obj->razcli; 
			$v['loccli'] = $obj->loccli; 
			$v['cant1'] = $obj->cant1; 
			$v['cant2'] = $obj->cant2;
			$arr[] = $v;
		}
		while ( $db->more_results() ){
			$db->next_result();
		}
	}		
	return $arr;
}
?>