<?php
// TODO ESTO HABRIA QUE CAMBIARLO POR MOCKS DE MYSQLI

require( "config.php" );
// include_once( $DIST.$LIB."/SQL.php" );
// include_once( $DIST.$LIB."/fechas.php" );
// include_once( $DIST.$LIB."/PadN.php" );



// include_once( $DIST.$CLASS."/demo/cClientesGrupoDemo.php" );
// include_once( $DIST.$CLASS."/demo/cClientesGruposDemo.php" );
// include_once( $DIST.$CLASS."/demo/cClientesDemo.php" );
// include_once( $DIST.$CLASS."/demo/cProductoDemo.php" );
// include_once( $DIST.$CLASS."/cReporteEntrega.php" );
require_once( $DIST.$CLASS."/cReporteProduccion.php" );
// include_once( $DIST.$CLASS."/cReporteTirada.php" );
// include_once( $DIST."/ArmarTiradaDiaria.php" );

// include_once( $DIST."/ProcesarReporteProduccion.php" );

error_reporting(E_ALL);

class ReporteProduccionTest extends PHPUnit\Framework\TestCase {
	public function testValidacionFormularioAlta(){
		$post = [];
		$post['nrotiradas'] = 1;
		$post['fecha'] = '01-11-2014';
		$post['totalkgrs'] = '100';
		$post['totalkgrscb'] = '1';
		$post['obs'] = '';
		$post['pro'] = '001';
		$post['tiradaneta'] = '1000';
		
		$post['horaini1'] = '00:00';
		$post['horafin1'] = '01:00';
		$post['maqini1'] = '1';
		$post['maqfin1'] = '2';
		$post['tiradabruta1'] = '2';
		$post['carga1'] = '2';
		$post['desperdicio1'] = '2';
		$post['kgrs1'] = '2';
		$post['pagtotal1'] = '2';
		$post['pagcolor1'] = '2';
		
		$rp = new cReporteProduccion();
		$this->assertEquals( true, $rp->VerificarPost( $post ), "verify: ".$rp->DetalleError );
	}

	public function testValidacionFormularioModiCabecera(){
		$post = [];
		$post['idx'] = 1;
		$post['nrotiradas'] = 1;
		$post['fecha'] = '01-11-2014';
		$post['totalkgrs'] = '100';
		$post['totalkgrscb'] = '1';
		$post['obs'] = '';
		$post['pro'] = '001';
		$post['tiradaneta'] = '1000';
		
		$rp = new cReporteProduccion();
		$this->assertEquals( true, $rp->VerificarModiPost( $post ), "verify: ".$rp->DetalleError );
	}
	
	//~ public function testGrabarModiCabecera(){
		//~ $post = [];
		//~ $post['idx'] = 1;
		//~ $post['nrotiradas'] = 1;
		//~ $post['fecha'] = '01-11-2014';
		//~ $post['totalkgrs'] = '100';
		//~ $post['totalkgrscb'] = '1';
		//~ $post['obs'] = '';
		//~ $post['pro'] = '001';
		//~ $post['tiradaneta'] = '1000';
		
		//~ $db = $this->getMock('mysqli');
		//~ $db->expects($this->at(0))
		//~ ->method('query')
		//~ ->will($this->returnValue(true));
		
		//~ $rp = new cReporteProduccion();
		//~ $rp->db = $db;
		//~ $this->assertEquals( true, $rp->GrabarModiCabeceraPost( $post ), "GrabarModiCabeceraPost: ".$rp->DetalleError );
	//~ }


	
	
}	
?>
