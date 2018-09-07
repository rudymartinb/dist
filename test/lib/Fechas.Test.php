<?php

require( "config.php" );
require_once( $DIST.$LIB."/fechas.php" );
require_once( $DIST.$LIB."/cAlmanaque.php" );
error_reporting(E_ALL);

date_default_timezone_set( "America/Argentina/Buenos_Aires" );
class testFechas extends PHPUnit\Framework\TestCase {
	public function testFechaHora2SQL(){
	
		$cad = "2014-06-06 21:00";
		$correcto = "/^(\d{4})-(\d{1,2})-(\d{1,2}) (\d{1,2}):(\d{1,2})$/";
		preg_match($correcto, $cad, $matches);
		$this->assertEquals( 6, count( $matches ), "Validar $cad " );

		
		$cad = "06-06-2014 21:00";
		$resultado = FechaHora2SQL( $cad );
		$esperado = "2014-06-06 21:00";
		$this->assertEquals( $esperado, $resultado, "Validar $cad" );

		$sqlfh = $esperado;
		$resultado = ValidarFechaHoraSQL( $sqlfh );
		$esperado = true;
		$this->assertEquals( $esperado, $resultado, "Validar $sqlfh" );

		$resultado = Sql2FechaHora( $sqlfh );
		$esperado = $cad;
		$this->assertEquals( $esperado, $resultado, "Validar $cad" );
		
	}
	
	/* es relacionado, pero quiero agregar evaluacion de fechas y horas
	*/
	public function testValidarFechaHora(){
		// $cad = "2014-06-06 21:00";
		// $correcto = "/^(\d{4})-(\d{1,2})-(\d{1,2}) (\d{1,2}):(\d{1,2})$/";
		// preg_match($correcto, $cad, $matches);
		// $this->assertEquals( 6, count( $matches ), "Validar $cad " );

		
		$cad = "06-06-2014 21:00";
		$resultado = ValidarFechaHora( $cad );
		$esperado = true;
		$this->assertEquals( $esperado, $resultado, "Validar $cad" );
	
	}

	/* 
	estilo columna almanaque.
	voy a probar armar la grilla basandome en columnas primero
	*/

	/* como tendria que quedar (aprox) el codigo del lado del php
	la idea es que la cabecera sea una caja de dos renglones
	la de arriba indica el titulo
	la de abajo pone abreviado los dias.
	*/

	public function testProcesarAlmanaque1(){
		$a = new cAlmanaque();
		$a->periodo = "201410";
		$this->assertEquals( true, $a->Procesar(), "Procesar" );
		$this->assertEquals( true, count( $a->listadias ) >0, "Procesar" );
		// var_dump( $a->listadias );
		$this->assertEquals( true, $a->EsMesBuscadoSemDow( 1,1 ) , "MesBuscadoDOW ".$a->DetalleError );
	}
	
	
	public function testRenderCabeceraAlmanaque(){
		$a = new cAlmanaque();
		$a->periodo = "201405";
		$res =  $a->TituloMes();
		$esperado = "Mayo 2014";
		$this->assertEquals( $esperado, $res, "ValidarPeriodo" );
		
		/*
		*/
		$this->assertEquals( true, $a->Procesar(), "Procesar" );
		$cant = CantSemanas( $a->ano, $a->mes );
		
		$res = $a->ArmarCabecera();
		$esperado = "<div class='almanaqueTitulo'>";
		$esperado .= $a->TituloMes();
		$esperado .= "</div>";
		$this->assertEquals( $esperado, $res, "ArmarCabecera" );

		// $res = $a->ArmarCelda(0,0);
		// $esperado = "<div class='almanaqueCelda'>";
		// $esperado .= $a->TituloMes();
		// $esperado .= "</div>";
		// $this->assertEquals( $esperado, $res, "ArmarCabecera" );

		
		// $esperado = "<div class='almanaqueBordeExterior'>";
		
		// $esperado .= "<div class='almanaqueBordeInterior'>";
		// $esperado .= "<div class='almanaqueColumna'>";
		
		// $esperado .= "<div>Lun";
		// $esperado .= "</div>";
		// $esperado .= "<div id='almanaqueColumnaLunes'>";
		// $esperado .= "</div>";
		// $esperado .= "</div>"; // fin almanaqueColumna
		
		// $esperado .= "</div>"; // fin almanaqueBordeInterior
		
		
	
	}
	public function testRenderAlmanaque(){
	
		$a = new cAlmanaque();
		$a->periodo = "201405";
		$res =  $a->TituloMes();
		$mesyanio = "Mayo 2014";
		$this->assertEquals( $mesyanio, $res, "ValidarPeriodo" );

		$this->assertEquals( true, $a->Procesar(), "Procesar" );
		$cant = CantSemanas( $a->ano, $a->mes );
		
		$this->assertEquals( $mesyanio, $a->TituloMes(), "Titulo Mes" );
		$dias = [];
		$dias[] = "27 28 29 30 01 02 03 ";
		$dias[] = "04 05 06 07 08 09 10 ";
		$dias[] = "11 12 13 14 15 16 17 ";
		$dias[] = "18 19 20 21 22 23 24 ";
		$dias[] = "25 26 27 28 29 30 31 ";
		
		for( $w = 0; $w < $cant ; $w ++ ){
			$semana = "";
			for( $d = 0 ; $d <= 6 ; $d ++ ){
				$semana .= $a->DiaCelda( $w, $d )." ";
			}
			$this->assertEquals( $dias[ $w ], $semana, "semana ".$w );
		}
		
	}
	 
	
	public function testPeriodoEnLetras(){
		$res = PeriodoEnLetras( null );
		$esperado = "";
		$this->assertEquals( $esperado, $res, "MesEnLetras1 " );

		$res = PeriodoEnLetras( "201405" );
		$esperado = "Mayo 2014";
		$this->assertEquals( $esperado, $res, "MesEnLetras1 " );
		
	}
	
	public function testMesEnLetras(){
		$res = MesEnLetras( null );
		$esperado = "";
		$this->assertEquals( $esperado, $res, "MesEnLetras1 " );
		
		$res = MesEnLetras( 1 );
		$esperado = "Enero";
		$this->assertEquals( $esperado, $res, "MesEnLetras1 " );
	}
	
	public function testNroEnAlmanaque(){
		$ano = "2014";
		$mes = "05";
		$a = new cAlmanaque();
		$a->periodo = $ano.$mes;
		$this->assertEquals( true, $a->Procesar(), "Procesar" );
		
		// var_dump( $a->listadias );
		$res =  count( $a->listadias );
		$esperado = 5; // cant semanas
		$this->assertEquals( $esperado, $res, "FechaCelda" );

		$res =  $a->FechaCelda( 0,0 );
		$esperado = "27-04-2014"; 
		$this->assertEquals( $esperado, $res, "FechaCelda" );

		$res =  $a->FechaCelda( 0,1 );
		$esperado = "28-04-2014"; 
		$this->assertEquals( $esperado, $res, "FechaCelda" );
				
		$res =  $a->FechaCelda( 1,1 );
		$esperado = "05-05-2014"; 
		$this->assertEquals( $esperado, $res, "FechaCelda" );

		// errores
		$res =  $a->FechaCelda( null,null );
		$esperado = ""; 
		$this->assertEquals( $esperado, $res, "FechaCelda" );
				
		$res =  $a->FechaCelda( 1,null );
		$esperado = ""; 
		$this->assertEquals( $esperado, $res, "FechaCelda" );

		$res =  $a->FechaCelda( 8,8 );
		$esperado = ""; 
		$this->assertEquals( $esperado, $res, "FechaCelda" );
		
		
		// Parte DiaCelda
		$res =  $a->DiaCelda( 0,0 );
		$esperado = "27"; 
		$this->assertEquals( $esperado, $res, "DiaCelda" );

		$res =  $a->DiaCelda( 0,1 );
		$esperado = "28"; 
		$this->assertEquals( $esperado, $res, "DiaCelda" );

		$res =  $a->DiaCelda( 1,1 );
		$esperado = "05"; 
		$this->assertEquals( $esperado, $res, "DiaCelda" );
		
		// parte EsMesBuscado
		$res =  $a->EsMesBuscadoSemDow( 0,0 );
		$esperado = false; 
		$this->assertEquals( $esperado, $res, "EsMesBuscado" );

		$res =  $a->EsMesBuscadoSemDow( 1,1 );
		$esperado = true; 
		$this->assertEquals( $esperado, $res, "EsMesBuscado" );
		
	}
	
	

	
	public function testValidarPeriodo(){
		$periodo = "201405";
		
		$res = ValidarPeriodo( $periodo );
		$esperado = true;
		$this->assertEquals( $esperado, $res, "ValidarPeriodo" );

		$res = ValidarPeriodo( "" );
		$esperado = false;
		$this->assertEquals( $esperado, $res, "ValidarPeriodo" );
		
	}
	public function testCantDiasMes(){
		$periodo = "201410";
		
		// $agenda = new cAgenda();
		// $agenda->periodo = $periodo;

		$cantdias = CantidadDias( null );

		$res = $cantdias;
		$esperado = null;
		$this->assertEquals( $esperado, $res, "CantDias" );
		
		
		$periodo = "201406";
		$cantdias = CantidadDias( $periodo );

		$res = $cantdias;
		$esperado = 30;
		$this->assertEquals( $esperado, $res, "CantDias" );

		$periodo = "201410";
		$cantdias = CantidadDias( $periodo );

		$res = $cantdias;
		$esperado = 31;
		$this->assertEquals( $esperado, $res, "CantDias" );


	}

	public function testPrimerDiaAlmanaque(){
		$periodo = "201405";

		$dia = PrimerDiaAlmanaque( null );

		$res = $dia;
		$esperado = null;
		$this->assertEquals( $esperado, $res, "PrimerDiaAlmanaque" );

		$dia = PrimerDiaAlmanaque( "" );

		$res = $dia;
		$esperado = null;
		$this->assertEquals( $esperado, $res, "PrimerDiaAlmanaque" );

		
		$dia = PrimerDiaAlmanaque( $periodo );

		$res = $dia;
		$esperado = "27-04-2014";
		$this->assertEquals( $esperado, $res, "PrimerDiaAlmanaque" );
		
		// $ano = substr( $periodo, 0, 4 );
		// $mes = substr( $periodo, 4, 2 );
		// $this->cantdias = cal_days_in_month(CAL_GREGORIAN, $this->mes, $this->ano);;
		
		// $this->dia1 = "01-".$this->mes."-".$this->ano;
		// $this->ini = DiaDeSemanaDMA( $this->dia1 );
		// $this->diaX = FechaRestarDias( $this->dia1, $this->ini );
		
		// $this->cantsemanas =  CantSemanas( $this->ano, $this->mes ) ;
		
	}
	
	public function testCantSemanas(){
		$res = CantSemanas( "2014", "08" );
		$esperado = 6;
		$this->assertEquals( $esperado, $res, "testCantSemanas 8" );

		$res = CantSemanas( "2014", "07" );
		$esperado = 5;
		$this->assertEquals( $esperado, $res, "testCantSemanas 7" );

		$res = CantSemanas( "2009", "02" );
		$esperado = 4;
		$this->assertEquals( $esperado, $res, "testCantSemanas 7" );

		$res = CantSemanas( "2014", "03" );
		$esperado = 6;
		$this->assertEquals( $esperado, $res, "testCantSemanas 8" );

		$res = CantSemanas( "2014", "02" );
		$esperado = 5;
		$this->assertEquals( $esperado, $res, "testCantSemanas 8" );

		$res = CantSemanas( "2014", "01" );
		$esperado = 5;
		$this->assertEquals( $esperado, $res, "testCantSemanas 8" );

		$res = CantSemanas( "2013", "06" );
		$esperado = 6;
		$this->assertEquals( $esperado, $res, "testCantSemanas 8" );
		
		
	}
	public function testSumarDMA(){
		$fec1  = "01-05-2014";
		$dias = 1;
		// $f = strtotime( $fec1 );
		$esperado  = "02-05-2014";

		$res = FechaSumarDias( $fec1, $dias );
		$this->assertEquals( $esperado, $res, " sumar fecha " );
	}
	
	public function testRestaDMA(){
		$fec1  = "01-05-2014";
		$dias = DiaDeSemanaDMA( $fec1 );
		$f = strtotime( $fec1 );
		$esperado  = "27-04-2014";

		$res = FechaRestarDias( $fec1, $dias );
		$this->assertEquals( $esperado, $res, " restar fecha " );
	}
	
	public function testDOWDMA(){
		$fecha = "01-05-2014";
		$res = DiaDeSemanaDMA( $fecha );
		// 1 2 3 4 5 6 7
		$esperado = 4;
		$this->assertEquals( $esperado, $res, " Fecha 2 SQL " );
	}
	public function testFecha2SQL(){
		$fecha = "12-12-2012";
		$res = fecha2SQL( $fecha );
		$esperado = "2012-12-12";
		$this->assertEquals( $esperado, $res, " Fecha 2 SQL " );
	}

	public function testSQL2Fecha(){
		$fecha = "2012-12-12";
		$res = Sql2Fecha( $fecha );
		$esperado = "12-12-2012";
		$this->assertEquals( $esperado, $res, " Fecha 2 SQL " );
	}
	
	public function testREG(){
		
		$subject = "abcdef";
		$pattern = '/^def/';
		preg_match($pattern, $subject, $matches, PREG_OFFSET_CAPTURE, 3);
		$this->assertEquals( 0 , count( $matches ) , "reg 1" );
		
		$subject = "abcdef";
		$pattern = '/^def/';
		preg_match($pattern, substr($subject,3), $matches, PREG_OFFSET_CAPTURE);
		$this->assertEquals( 1 , count( $matches ) , "reg 1".preg_last_error() );
		
		$subject = "abcdef";
		$pattern = '#^[0-9]{1,2}$#';
		preg_match($pattern, substr($subject,3), $matches, PREG_OFFSET_CAPTURE);
		$this->assertEquals( 0 , count( $matches ) , "0-9 1,2 abcdef ".preg_last_error() );

		$subject = "a9";
		$pattern = '#^[0-9]{1,2}$#';
		preg_match($pattern, substr($subject,3), $matches, PREG_OFFSET_CAPTURE);
		$this->assertEquals( 0 , count( $matches ) , "0-9 1,2 abcdef ".preg_last_error() );

		$subject = "9";
		$pattern = '/[0-9]/';
		preg_match($pattern, substr($subject,3), $matches);
		$this->assertEquals( 0 , count( $matches ) , "0-9 1,2 abcdef ".preg_last_error() );
		
		$correcto = "/^(\d{1,2})-(\d{1,2})-(\d{4})$/";
		
		preg_match($correcto, "12-10-2020", $matches);
		$this->assertEquals( 4 , count( $matches ) , "0-9 1,2 abcdef ".preg_last_error() );		

		preg_match($correcto, "12-10-2020", $matches);
		$this->assertEquals( 4 , count( $matches ) , "0-9 1,2 abcdef ".preg_last_error() );		

		preg_match($correcto, "1-1-2020", $matches);
		$this->assertEquals( 4 , count( $matches ) , "0-9 1,2 abcdef ".preg_last_error() );		

		// errores
		preg_match($correcto, "1", $matches);
		$this->assertEquals( 0 , count( $matches ) , "0-9 1,2 abcdef ".preg_last_error() );		

		preg_match($correcto, "1-1-1", $matches);
		$this->assertEquals( 0 , count( $matches ) , "0-9 1,2 abcdef ".preg_last_error() );		

		preg_match($correcto, "1--1231", $matches);
		$this->assertEquals( 0 , count( $matches ) , "0-9 1,2 abcdef ".preg_last_error() );		

		preg_match($correcto, "-1-1231", $matches);
		$this->assertEquals( 0 , count( $matches ) , "0-9 1,2 abcdef ".preg_last_error() );		

		preg_match($correcto, "12-45-61890", $matches);
		$this->assertEquals( 0 , count( $matches ) , "0-9 1,2 abcdef ".preg_last_error() );		
		

	}
	public function testValidar(){
		$this->assertEquals( false , ValidarFecha( "" ), "ValidarFecha vacio" );
		$this->assertEquals( false , ValidarFecha( "x" ), "ValidarFecha x" );
		$this->assertEquals( false , ValidarFecha( "1234567890" ), "ValidarFecha 1234567890" );
		$this->assertEquals( false , ValidarFecha( "AA-AA-AAAA" ), "ValidarFecha 1234567890" );
		$this->assertEquals( true  , ValidarFecha( "12-12-1212" ), "ValidarFecha 12-12-1212" );
		
		$this->assertEquals( true  , ValidarFecha( "12-12-2012" ), "ValidarFecha 12-12-2012" );
		
	}
	
	public function testFechas1(){
	
		// obtener fecha de un form en formato string
		// y convertirlo a integer
		$uno  = strtotime('1985/02/09'); 
		// var_dump( $uno );
		
		// obtener formato para mostrar
		$dos = date( "d-m-Y", $uno );
		
		$this->assertEquals( $dos , "09-02-1985", "conversion time a string" );
		
		// formato para sql
		$asql = date( "Ymd", $uno );
		$this->assertEquals( $asql , "19850209", "converison time a string sql" );
		
		// $this->assertEquals( 0, date_create_from_format("",""), "date_create_from_format() vacio" );
		
		// date_create_from_format 
	}
	
	
}
?>

