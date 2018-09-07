<?php

require_once( "config.php" );

require_once( $DIST.$LIB."/SQL.php" );
require_once( $DIST.$CLASS."/cProducto.php" );
require_once( $DIST.$CLASS.$DEMO."/cProductoDemo.php" );

error_reporting(E_ALL);

class cProductoTest extends PHPUnit\Framework\TestCase {
    public function test1(){
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
        
        $o = new cProductoDemo();
        $o->db = $db;
        // $cli->Setup( true );
        $this->assertTrue( $o->GrabarAlta(), "GrabarAlta" ) ;
        
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
	public function testFalla(){
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

		$q = "call dev_crema;";
		try {
			$res = $db->query( $q );
		} catch ( Exception $e ) {
			$error = $e->getMessage() ;
			$this->assertEquals( true, false , $error);
			return false;
		}
		if( $res === FALSE ) {
			$error = "Error: ". $db->error ;
			$this->assertEquals( true, false , $error);
			return false;
		}
		
		$this->assertEquals( 0, QueryRecCount( $db, "select * from productos" ), "QueryRecCount productos" );
		
		$prod = new cProducto();
		$prod->db = $db;

		$cod = "001" ;
		$des = "DIARIO LUNES" ;
		$abr = "E.LUNES" ;
		$controlpapelusado = false ;

		$prod->cod = $cod ;
		$prod->des = $des ;
		$prod->abr = $abr ;
		$prod->controlpapelusado = $controlpapelusado ;
		

		$this->assertTrue( $prod->GrabarAlta( ), "Producto GrabarAlta ". $prod->DetalleError );
		$this->assertTrue( $prod->GrabarModi( ), "Producto GrabarModi ". $prod->DetalleError );

		$prod->Clear();
		$this->assertEquals( "" , $prod->cod, "" );
		$prod->cod = $cod ;
		
		$this->assertTrue( $prod->Leer( ), "Producto Leer ". $prod->DetalleError );
		$this->assertEquals( $cod , $prod->cod, "" );
		$this->assertEquals( $des , $prod->des, "" );
		$this->assertTrue( $prod->GrabarModi( ), "Producto GrabarModi ". $prod->DetalleError );
		$prod->Clear();
		$this->assertEquals( "" , $prod->cod, "" );
		$prod->cod = $cod ;
		
		$this->assertTrue( $prod->Leer( ), "Producto Leer ". $prod->DetalleError );
		$this->assertEquals( $cod , $prod->cod, "" );
		$this->assertEquals( $des , $prod->des, "" );

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
