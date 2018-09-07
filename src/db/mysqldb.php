<?php

require( "config.php" );
require_once( $DIST.$CLASS."/cBasica.php" );
require_once( $DIST."/../myphplib/db/mysql_wrapper.php" );

error_reporting( E_ALL );

function MySQLDB( $dbname = "dist", $forzar = false ){
	static $db = null;
	if( $db !== null and ! $forzar )
		return $db;
		
	
	// $host = "192.168.111.13"; 
	$host = "127.0.0.1"; 
	$username = "root";
	$passwd = "sunpei42";
	$port = 3306;
	
	$db = new mysqli( $host, $username, $passwd, $dbname, $port );	

	if ( $db->connect_error ) {
		throw new Exception( 'Connect Error (' . $db->connect_errno . ') ' . $db->connect_error );
	}
	return $db;
}
?>
