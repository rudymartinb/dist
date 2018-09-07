<?php
include_once( "config.php" );
include_once( $DIST.$LIB."/SQL.php" );

class cOrden {
	public $idx = 0;
	public $fecha = "";
	
	public $db;
	public $DetalleError;
	
	public function __set($name, $value){
	}

}

?>