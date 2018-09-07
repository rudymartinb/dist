<?php
include_once ("config.php");
include_once ($DIST.$LIB."/cBasica.php");
include_once ($DIST.$LIB."/TiposDatos.php");

class cListado extends cBasica {
	public $cols = [];
	public function AddCol( $nom, $ancho, $estilos ){
		if( ! EsString( $nom ) ){
			return false;
		}
		if( ! EsInt( $ancho ) ){
			return false;
		}
		if( ! EsString( $estilos ) ){
			return false;
		}
		$this->cols[] = [ $nom, $ancho, $estilos ];
		return true;
	}
}
?>