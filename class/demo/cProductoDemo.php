<?php
include_once( "config.php" );
include_once( $DIST.$CLASS."/cProducto.php" );

class cProductoDemo extends cProducto{
    function __construct() {
		$this->Setup(false);
	}
	public function Setup( $azar = false ){
		$cod = "998" ;
		$des = "DIARIO LUNES" ;
		$abr = "E.LUNES" ;
		$lun = true ;
		$mar = false ;
		$mie = false ;
		$jue = false ;
		$vie = false ;
		$sab = false ;
		$dom = false ;
		$precio = 5 ;
		$controlpapelusado = false ;

		$this->cod = "998" ;
		$this->des = $des ;
		$this->abr = $abr ;
		$this->lun = $lun ;
		$this->mar = $mar ;
		$this->mie = $mie ;
		$this->jue = $jue ;
		$this->vie = $vie ;
		$this->sab = $sab ;
		$this->dom = $dom ;
		$this->automatico = true;
		$this->precio = $precio ;
		$this->controlpapelusado = $controlpapelusado ;
		
	}
}

?>