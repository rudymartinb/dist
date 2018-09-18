<?php

// use SebastianBergmann\CodeCoverage\Node\Builder;
use mylib\mysql_query_mock;

// require_once( "config.php" );

// require_once( $DIST.$LIB."/SQL.php" );
// require_once( $DIST.$CLASS."/cProducto.php" );


error_reporting(E_ALL);

class cProductoTest extends PHPUnit\Framework\TestCase {
    
    public function testBuilder(){
        
        $prod = cProducto::Builder()->setDes("SARASA")->build();
         
        $this->assertTrue( $prod instanceof cProducto, "objeto debe ser cProducto" );
        
        // "DIARIO LUNES" se configura en demo()
        $this->assertEquals( "SARASA", $prod->getDes(), "objeto debe ser cProducto" );
    }
    
    // 
    
    public function testAlta(){
        // $db = SQL_Conexion();
        $db = mysql_query_mock::Builder()->build();

        $prod = cProducto::Builder()
        ->setDB( $db )
        ->setCod("997")
        ->setDes("PROD TEST")
        ->setAbr("PT")
        ->setCtrl( false )
        ->build();
        
        // $db->start_debug(); 
        $query = "call SP_ProductoAlta( '997', 'PROD TEST', 'PT', false  )";
            
        $db->esperar( $query, function() {
            $this->assertTrue( true );
        } );
        $prod->GrabarAlta();
        // $this->assertTrue( , "GrabarAlta" ) ;
        
    }
    
    
// 	public function testFalla(){
// 		$db = SQL_Conexion();
		
// 		$q = "start transaction;";
// 		$res = $db->query( $q );

// 		$q = "call dev_crema;";
// 		$res = $db->query( $q );
		
// 		$this->assertEquals( 0, QueryRecCount( $db, "select * from productos" ), "QueryRecCount productos" );
		
// 		$prod = new cProducto( $db );
//         $prod->Setup(FALSE);
        
// 		$cod = $prod->cod;
// 		$des = $prod->des;
		

// 		$this->assertTrue( $prod->GrabarAlta( ), "Producto GrabarAlta ". $prod->DetalleError );
// 		$this->assertTrue( $prod->GrabarModi( ), "Producto GrabarModi ". $prod->DetalleError );

// 		$prod->Clear();
// 		$this->assertEquals( "" , $prod->cod, "" );
		
// 		$prod->cod = $cod ;
// 		$prod->Leer();
		
// 		$this->assertEquals( $cod , $prod->cod, "" );
// 		$this->assertEquals( $des , $prod->des, "" );
// 		$prod->GrabarModi( );
		
// 		$prod->Clear();
// 		$this->assertEquals( "" , $prod->cod, "" );
// 		$prod->cod = $cod ;
		
// 		$this->assertTrue( $prod->Leer( ), "Producto Leer ". $prod->DetalleError );
// 		$this->assertEquals( $cod , $prod->cod, "" );
// 		$this->assertEquals( $des , $prod->des, "" );

// 		$q = "rollback;";
// 		$res = $db->query( $q );
		
// 	}


	
}
?>