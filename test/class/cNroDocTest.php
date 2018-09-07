<?php

require_once( "config.php" );
require_once( $DIST.$LIB."/SQL.php" );
require_once( $DIST.$CLASS."/cNroDoc.php" );
error_reporting(E_ALL);
class cNroDocTest extends PHPUnit\Framework\TestCase {
	public function testAltaSQL(){
		$db = SQL_Conexion();
		$q = "start transaction;";
		$res = $db->query( $q );

		$prefijo = "0001";
		$despre = "TALONARIO 1";
		
		$obj = new cNroDoc();
		$obj->db = $db;
		$obj->prefijo = $prefijo;
		$obj->despre = $despre;
		
		$this->assertTrue( $obj->GrabarAlta(), "GrabarAlta" );

		$obj1 = new cNroDoc();
		$obj1->db = $db;
		$obj1->prefijo = $prefijo;
		$this->assertTrue( $obj1->Leer(), "Leer() ".$obj1->DetalleError." ".$db->error );
		$this->assertEquals( $obj1->prefijo, $prefijo, "prefijo" );
		$this->assertEquals( $obj1->despre, $despre, "despre" );
		
		$q = "rollback;";
		$res = $db->query( $q );		
	}

	
	public function testAlta(){
		$db = $this->getMock('mysqli');
		
		$l = [];
		$arr = [];
		$arr['result'] = true;
		$l[] = $arr;
		
		$res = $this->getMockBuilder('mysqli_result')
		->disableOriginalConstructor()
		->getMock();
			 
		$res->expects($this->at(0))
		->method('fetch_assoc')
		->will($this->returnValue($l[0]));

		$db->expects($this->at(0))
		->method('query')
		->will($this->returnValue($res));
		
		$db->expects($this->at(0))
		->method('more_results')
		->will($this->returnValue(false));
		

		$obj = new cNroDoc();
		$obj->db = $db;
		$obj->prefijo = "0001";
		$obj->despre = "TALONARIO 1";
		
		$this->assertTrue( $obj->GrabarAlta(), "GrabarAlta" );
	}
	
	public function testLeer(){
		$db = $this->getMock('mysqli');
		
		$prefijo = "0001";
		$despre = "TALONARIO 1";
		$l = [];
		$arr = [];
		$arr['prefijo'] = $prefijo;
		$arr['despre'] = $despre;
		$l[] = $arr;
		
		$res = $this->getMockBuilder('mysqli_result')
		->disableOriginalConstructor()
		->getMock();
			 
		$res->expects($this->at(0))
		->method('fetch_assoc')
		->will($this->returnValue($l[0]));

		$db->expects($this->at(0))
		->method('query')
		->will($this->returnValue($res));
		
		$db->expects($this->at(0))
		->method('more_results')
		->will($this->returnValue(false));
		

		$obj = new cNroDoc();
		$obj->db = $db;
		$this->assertTrue( $obj->Leer(), "Leer()" );
		
		$this->assertEquals( $obj->prefijo, $prefijo, "prefijo" );
		$this->assertEquals( $obj->despre, $despre, "despre" );
	}
	
	
}
?>