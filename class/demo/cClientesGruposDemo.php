<?php
include_once( "config.php" );
include_once( $DIST.$CLASS."/cClientesGrupos.php" );

class cClientesGruposDemo extends cClientesGrupos{
   function __construct() {
		$this->cod = "997";
		$this->des = "GRUPO997";
		$this->abr = "GRP997";
	}
}

?>