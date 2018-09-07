<?php
include_once( "config.php" );
include_once( $DIST.$CLASS."/cClientes.php" );

class cClientesDemo extends cClientes {
   function __construct() {
		$this->cod = "997";
		$this->raz = "SARASA";
		$this->dom = "PIEDRAS";
		$this->loc = "OLAVARRIA";
		$this->cpo = "7400";
		$this->tel = "00";
		$this->zona = "AA";
		$this->grupo = "997";
		$this->gan = 50.0;
	
	}
	public function Setup( $azar = false ){
		$this->cod = "997";
		$this->raz = "SARASA ";
		$this->dom = "PIEDRAS";
		$this->loc = "OLAVARRIA";
		$this->cpo = "7400";
		$this->tel = "00";
		$this->zona = "AA";
		$this->grupo = "997"; // se supone q el grupo esta creado de antes
		$this->gan = 50.0;

	}
}

?>