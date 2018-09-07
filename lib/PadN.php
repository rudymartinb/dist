<?php
function PadN( $txt, $lon ){
	if( $txt == null ){
		$txt = "";
	}
	if( $lon == null ){
		return null;
	}
	$res = str_repeat( "0", $lon ).$txt ;
	
	$res = substr( $res, strlen($res)-$lon,  $lon );
	return $res;

}

?>