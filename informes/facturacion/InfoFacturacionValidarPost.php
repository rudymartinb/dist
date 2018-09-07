<?php

include_once("config.php");

function InfoFacturacionValidarPost( $post ){
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
	return true;
}
?>