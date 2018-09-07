<?php
require_once ("config.php");
require_once ($DIST.$CLASS."/cReporteProduccion.php");
require_once ($DIST.$CLASS."/cReporteTirada.php");
error_reporting(E_ALL);
class testReporteProduccion extends PHPUnit\Framework\TestCase {
	
	/* settype devuelve un bool
	** cast es directo.
	*/
	// public function test2(){
		// $test = "a";
		// $res = settype( $test, "integer" );
		// $res = (integer) $test;
		// echo "test : ".$test ;
		// echo "res : ".$res ;
		// $this->assertEquals( "integer", gettype( $test ) );
		// $this->assertEquals( "integer", gettype( $res ) );
	// }
	public function testLeerIDX(){
	
		$obj= new stdClass();;
		$obj->idx  = (int) 1;
		$obj->nrort = 1;
		$obj->inirt = "01:00";
		$obj->finrt = "02:00";
		$obj->maqinirt = (int) 1;
		$obj->maqfinrt = (int) 2;
		$obj->tirbrutart = (int) 1000;
		$obj->cargart = (int) 50;
		$obj->desprt = (int) 5;
		$obj->kgrsrt = (int) 1000;
		$obj->pagtotrt = (int) 24;
		$obj->pagcolorrt = (int) 8;
		$obj->idxrep = 1;

		$db = $this->getMock('mysqli');

		
		// mysqli_result
		$res = $this->getMockBuilder('mysqli_result')
			 ->disableOriginalConstructor()
			 ->getMock();
			 
		$res->expects($this->at(0))
		->method('fetch_object')
		->will($this->returnValue($obj));

		// db->query
		$db->expects($this->at(0))
		->method('query')
		->will($this->returnValue($res));


		$rt = new cReporteTirada();
		$rt->db = $db;
		$this->assertTrue( $rt->LeerIDX( 1 ) , "LeerIDX" );
		
		$this->assertEquals( $obj->idx 			, $rt->idx , "" );
		$this->assertEquals( $obj->nrort 		, $rt->nro , "" );
		$this->assertEquals( $obj->inirt 		, $rt->horaini , "" );
		$this->assertEquals( $obj->finrt 		, $rt->horafin , "" );
		$this->assertEquals( $obj->maqinirt 	, $rt->MaqIni , "" );
		$this->assertEquals( $obj->maqfinrt 	, $rt->MaqFin , "" );
		$this->assertEquals( $obj->tirbrutart 	, $rt->TiradaBruta , "" );
		$this->assertEquals( $obj->cargart 		, $rt->Carga , "" );
		$this->assertEquals( $obj->desprt 		, $rt->Desperdicios , "" );
		$this->assertEquals( $obj->kgrsrt 		, $rt->Kgrs , "" );
		$this->assertEquals( $obj->pagtotrt 	, $rt->pagtotal , "" );
		$this->assertEquals( $obj->pagcolorrt 	, $rt->pagcolor , "" );
		$this->assertEquals( $obj->idxrep 		, $rt->idxrep , "" );
		
		$this->assertTrue( $rt->EsValido() , "GrabarModi ".$rt->DetalleError );
		
	}
	
	public function testGrabar(){
		$db = $this->getMock('mysqli');

		$db->expects($this->at(0))
		->method('query')
		->will($this->returnValue(true));
		
		$rt = new cReporteTirada();
		$rt->db = $db;
		
		$rt->nro = 1;
		$rt->horaini = "01:00";
		$rt->horafin = "02:00";
		$rt->MaqIni = 123;
		$rt->MaqFin = 124;
		$rt->TiradaBruta = 125;
		$rt->Carga = 126;
		$rt->Desperdicios = 127;
		
		$rt->Kgrs = 129;
		$rt->pagtotal = 130;
		$rt->pagcolor = 100;
		$rt->idxrep = 1;
		

		$this->assertTrue( $rt->GrabarModi() , "GrabarModi ".$rt->DetalleError );
		
	}
	
	public function testValidacionFormularioModiTirada(){
		$post = [];
		// idx tirada
		$post['idx'] = 1;
		$post['horaini'] = '00:00';
		$post['horafin'] = '01:00';
		$post['maqini'] = '1';
		$post['maqfin'] = '2';
		$post['tiradabruta'] = '2';
		$post['carga'] = '2';
		$post['desperdicio'] = '2';
		$post['kgrs'] = '2';
		$post['pagtotal'] = '2';
		$post['pagcolor'] = '2';
		
		$rt = new cReporteTirada();
		$this->assertEquals( true, $rt->VerificarModiTiradaPost( $post ), "verify: ".$rt->DetalleError );
	}
	
	public function testGrabarModiTiradaForm(){
		$post = [];
		// idx tirada
		$post['idx'] = 1;
		$post['horaini'] = '00:00';
		$post['horafin'] = '01:00';
		$post['maqini'] = '1';
		$post['maqfin'] = '2';
		$post['tiradabruta'] = '2';
		$post['carga'] = '2';
		$post['desperdicio'] = '2';
		$post['kgrs'] = '2';
		$post['pagtotal'] = '2';
		$post['pagcolor'] = '2';
		
		$db = $this->getMock('mysqli');
		$db->expects($this->at(0))
		->method('query')
		->will($this->returnValue(true));

		$rt = new cReporteTirada();
		$rt->db = $db;
		$this->assertEquals( true, $rt->GrabarModiTiradaPost( $post ), "verify: ".$rt->DetalleError );
	}
		
}
?>