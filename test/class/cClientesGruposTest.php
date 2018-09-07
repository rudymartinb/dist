<?php
require_once( "config.php" );
require_once( $DIST.$CLASS."/demo/cClientesGruposDemo.php" );
require_once( $DIST.$CLASS."/demo/cClientesDemo.php" );

error_reporting(E_ALL);

class cClientesGruposTest extends PHPUnit\Framework\TestCase {

	public function testOK(){
		
		$db = SQL_Conexion();

	
		$q = "start transaction;";
		try { 
			$res = $db->query( $q );
		} catch ( Exception $e ) {
			$error = $e->getMessage() ;
			echo  $error;
		}
		if( $res === FALSE ) {
			$error = "Error: ". $db->error ;
			echo  $error;
		}
		
		$gru = new cClientesGruposDemo();
		$gru->db = $db;
		$gru->GrabarAlta();
		$this->assertTrue( $gru->GrabarAlta() == 1 , "GrabarAlta : ". $gru->DetalleError ) ;
		
		$gru->cod = "997";
		
		$gru2 = new cClientesGruposDemo();
		$gru2->db = $db;
		$gru2->cod = "997";
		$this->assertEquals( "997", $gru->cod , "cod");
		
		$this->assertTrue( $gru2->Leer() == 1 , "Leer : ". $gru->DetalleError ) ;
		$this->assertEquals( $gru->des, $gru2->des , "des");
		$this->assertEquals( $gru->abr, $gru2->abr , "abr");
		
		$this->assertTrue( $gru->GrabarModi() == 1 , "GrabarAlta : ". $gru->DetalleError ) ;

		$gru->Clear();
		$this->assertEquals( "", $gru->cod , "cod");
		$this->assertEquals( "", $gru->des , "des");
		$this->assertEquals( "", $gru->abr , "abr");
		
		
		$q = "rollback;";
		try {
			$res = $db->query( $q );
		} catch ( Exception $e ) {
			$error = $e->getMessage() ;
			echo  $error;
		}
		if( $res === FALSE ) {
			$error = "Error: ". $db->error ;
			echo  $error;
		}		
		
	
		
	}


	
}
?>
