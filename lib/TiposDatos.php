<?php

function EsString( $var ){
	if( $var === null ) {
		return false;
	}
	if( gettype( $var ) != "string" ){
		return false;
	}
	return true;
}

function EsInt( $var ){
	// echo "tipo:".gettype( $var )."///";
	if( $var === null ) {
		return false;
	}
	if( gettype( $var ) == "double" ){
		return true;
	}
	if( gettype( $var ) == "integer" ){
		return true;
	}
	return false;
}

function EsClase( $obj, $nomclase ){
	if( $obj === null ) {
		return false;
	}
	if( gettype( $obj ) != "object" ){
		return false;
	}
	if( $nomclase == null ) {
		return false;
	}
	if( gettype( $nomclase ) != "string" ){
		return false;
	}	

	if( get_class( $obj ) != $nomclase ){
		return false;
	}
	return true;
}
?>