<?php
/* esta clase es un elemento 
** que forma parte de cReporteProduccion
*/

require_once( "config.php" );
require_once( $DIST.$CLASS."/cBasica.php" );
require_once( $DIST.$LIB."/SQL.php" );

class cReporteTirada extends cBasica  {
	public $db;
	public $idx;
	public $idxrep;
	public $nro;
	public $horaini;
	public $horafin;
	public $MaqIni;
	public $MaqFin;
	public $TiradaBruta;
	public $Carga;
	public $Desperdicios;
	// public $TiradaNeta;
	public $Kgrs;
	public $pagtotal;
	public $pagcolor;

	
	public $DetalleError ;

	
	public function LeerIDX( $idx ){
		$db = $this->db;
		$q = "call sp_ReporteProduccionLeerTiradasXIDX2( ".$idx ." );";
		try {
			$res = $db->query( $q );
		} catch ( Exception $e ) {
			$this->DetalleError = $e->getMessage() ;
			return false;
		}
		if( $res === FALSE ) {
			$this->DetalleError = "Error: ". $db->error ;
			return false;
		}

		if( $obj = $res->fetch_object() ){
			$this->idx = $obj->idx;
			$this->nro = $obj->nrort;
			$this->horaini = $obj->inirt;
			$this->horafin = $obj->finrt;
			$this->MaqIni = $obj->maqinirt;
			$this->MaqFin = $obj->maqfinrt;
			$this->TiradaBruta = $obj->tirbrutart ;
			$this->Carga= $obj->cargart;
			$this->Desperdicios = $obj->desprt;

			$this->Kgrs = $obj->kgrsrt;
			$this->pagtotal = $obj->pagtotrt;
			$this->pagcolor = $obj->pagcolorrt;
			$this->idxrep = $obj->idxrep;
		} else {
			return false;
		}
		
		while ( $db->more_results() ){
			$db->next_result();
		}
		return true;

	}	
	
	
	public function GrabarAlta() {
		$this->DetalleError = "" ;
		$db = $this->db;
		if( ! $this->EsValido() ){
			return false;
		}
		$q = "call sp_ReporteProduccionTiradaAlta( ";
		$q .= "".$this->nro ." ,";
		$q .= "'".$this->horaini ."' ,";
		$q .= "'".$this->horafin ."' ,";
		$q .= "".$this->MaqIni ." ,";
		$q .= "".$this->MaqFin ." ,";
		$q .= "".$this->TiradaBruta ." ,";
		$q .= "".$this->Carga ." ,";
		$q .= "".$this->Desperdicios ." ,";
		$q .= "".$this->Kgrs ." ,";
		$q .= "".$this->pagtotal ." ,";
		$q .= "".$this->pagcolor ."  ,";
		$q .= "".$this->idxrep."  );";

		try {
			$res = $db->query( $q );
		} catch ( Exception $e ) {
			$this->DetalleError = $e->getMessage() ;
			return false;
		}
		if( $res === FALSE ) {
			$this->DetalleError = "Error: ". $db->error ;
			return false;
		}
		
		$idx = 0;
		if( $db->more_results() ) {
			if( $obj = $res->fetch_object() ){
				$idx = $obj->idx;
			}
			while ( $db->more_results() ){
				$db->next_result();
			}
		}
		if( ! last_result( $db ) ){
			$this->DetalleError = "FALLO SP grabar reporte tirada" ;
			return false;
		}
		if( $idx == 0 ){
			$this->DetalleError = "IDX 0" ;
			return false;
		}
		$this->idx = $idx;
		return true;
	}


	public function GrabarModi() {
		$this->DetalleError = "" ;
		$db = $this->db;
		if( ! $this->EsValido() ){
			return false;
		}
		$q = "call sp_ReporteProduccionTiradaModi( ";
		$q .= "".$this->idx ." ,";
		$q .= "".$this->nro ." ,";
		$q .= "'".$this->horaini ."' ,";
		$q .= "'".$this->horafin ."' ,";
		$q .= "".$this->MaqIni ." ,";
		$q .= "".$this->MaqFin ." ,";
		$q .= "".$this->TiradaBruta ." ,";
		$q .= "".$this->Carga ." ,";
		$q .= "".$this->Desperdicios ." ,";
		$q .= "".$this->Kgrs ." ,";
		$q .= "".$this->pagtotal ." ,";
		$q .= "".$this->pagcolor ."  );";

		try {
			$res = $db->query( $q );
		} catch ( Exception $e ) {
			$this->DetalleError = $e->getMessage() ;
			return false;
		}
		if( $res === FALSE ) {
			$this->DetalleError = "Error: ". $db->error ;
			return false;
		}
		

		return true;
	}
	
	
	public function EsValido( ){
		if( ! EsInt( $this->nro ) ){
			$this->DetalleError = "mal nro";
			return false;
		}
		if( ! EsString ( $this->horaini ) ){
			$this->DetalleError = "mal horaini";
			return false;
		}		
		if( ! EsString ( $this->horafin ) ){
			$this->DetalleError = "mal horafin";
			return false;
		}		
		if( ! EsInt( $this->MaqIni ) ){
			$this->DetalleError = "mal maqini";
			return false;
		}
		if( ! EsInt( $this->MaqFin ) ){
			$this->DetalleError = "mal maqfin";
			return false;
		}
		if( ! EsInt( $this->TiradaBruta ) ){
			$this->DetalleError = "mal tiradabruta";
			return false;
		}
		if( ! EsInt( $this->Carga ) ){
			$this->DetalleError = "mal carga";
			return false;
		}
		if( ! EsInt( $this->Desperdicios ) ){
			$this->DetalleError = "mal desperdicios";
			return false;
		}
		if( ! EsInt( $this->Kgrs ) ){
			$this->DetalleError = "mal kgrs";
			return false;
		}
		if( ! EsInt( $this->pagtotal ) ){
			$this->DetalleError = "mal cant paginas total";
			return false;
		}		
		if( ! EsInt( $this->pagcolor ) ){
			$this->DetalleError = "mal cant paginas color";
			return false;
		}
		// if( ! EsInt( $this->idxrep ) ){
			// $this->DetalleError = "f idxrep";
			// return false;
		// }		
		return true;
	}
	public function VerificarModiTiradaPost( $post ){
		$this->DetalleError = "";
		$i = "";
			if( ! isset( $post["idx"] ) ){ $this->DetalleError = "falta indicar idx ".$i; }
			if( ! isset( $post["horaini".$i] ) ){ $this->DetalleError = "falta indicar hora inicio tirada ".$i; }
			if( ! isset( $post["horafin".$i] ) ){ $this->DetalleError = "falta indicar hora fin tirada ".$i; }
			if( ! isset( $post["maqini".$i] ) ){ $this->DetalleError = "falta indicar maquina inicio tirada ".$i; }
			if( ! isset( $post["maqfin".$i] ) ){ $this->DetalleError = "falta indicar maquina fin tirada ".$i; }
			if( ! isset( $post["tiradabruta".$i] ) ){ $this->DetalleError = "falta indicar tirada bruta ".$i; }
			if( ! isset( $post["carga".$i] ) ){ $this->DetalleError = "falta indicar carga ".$i; }
			if( ! isset( $post["desperdicio".$i] ) ){ $this->DetalleError = "falta indicar desperdicio ".$i; }
		
			if( ! isset( $post["kgrs".$i] ) ){ $this->DetalleError = "falta indicar kgrs ".$i; }
			if( ! isset( $post["pagtotal".$i] ) ){ $this->DetalleError = "falta indicar cant pag color ".$i; }
			if( ! isset( $post["pagcolor".$i] ) ){ $this->DetalleError = "falta indicar total paginas ".$i; }

			
			/* por logica se deberia validar
			** si los datos pasados son validos
			** despues vemos que hacemos exactamente con cada caso.
			*/
			if( strlen( $post["horaini".$i] ) != 5 ){ $this->DetalleError = "mal hora ini"; return false; }
			if( strlen( $post["horafin".$i] ) != 5 ){ $this->DetalleError = "mal hora fin"; return false; }
			if( strlen( $post["maqini".$i] ) == 0 ){ $this->DetalleError = "falta indicar maquina inicio"; return false; }
			if( strlen( $post["maqini".$i] ) == 0 ){ $this->DetalleError = "falta indicar maquina fin"; return false; }
			if( strlen( $post["tiradabruta".$i] ) == 0 ){ $this->DetalleError = "falta indicar tirada bruta"; return false; }
			if( strlen( $post["carga".$i] ) == 0 ){ $this->DetalleError = "falta indicar carga"; return false; }
			if( strlen( $post["desperdicio".$i] ) == 0 ){ $this->DetalleError = "falta indicar desperdicio"; return false; }
			// if( strlen( $post["tiradaneta".$i] ) == 0 ){ $this->DetalleError = "falta indicar tirada neta"; return false; }
			if( strlen( $post["kgrs".$i] ) == 0 ){ $this->DetalleError = "falta indicar kgrs"; return false; }
			if( strlen( $post["pagtotal".$i] ) == 0 ){ $this->DetalleError = "falta indicar total pags "; return false; }
			if( strlen( $post["pagcolor".$i] ) == 0 ){ $this->DetalleError = "falta indicar paginas color"; return false; }


		return $this->DetalleError == "";
	}	
	
	public function GrabarModiTiradaPost( $post ) {
		// $idx = $post['idx'];
		$horaini = $post['horaini'];
		$horafin = $post['horafin'];
		$MaqIni = $post['maqini'];
		$MaqFin = $post['maqfin'];
		$TiradaBruta = $post['tiradabruta'];
		$Carga = $post['carga'];
		$Desperdicios = $post['desperdicio'];
		$Kgrs = $post['kgrs'];
		$pagtotal = $post['pagtotal'];
		$pagcolor = $post['pagcolor'];
		
		$q = "call sp_ReporteProduccionTiradaModi( ";
		$q .= "".$this->idx ." ,";
		$q .= "'".$horaini ."' ,";
		$q .= "'".$horafin ."' ,";
		$q .= "".$MaqIni ." ,";
		$q .= "".$MaqFin ." ,";
		$q .= "".$TiradaBruta ." ,";
		$q .= "".$Carga ." ,";
		$q .= "".$Desperdicios ." ,";
		$q .= "".$Kgrs ." ,";
		$q .= "".$pagtotal ." ,";
		$q .= "".$pagcolor ." );";

		$db = $this->db;
		try {
			$res = $db->query( $q );
		} catch ( Exception $e ) {
			$this->DetalleError = $e->getMessage() ;
			return false;
		}
		if( $res === FALSE ) {
			$this->DetalleError = "Error: ". $db->error." ".$q ;
			return false;
		}
		return true;

	}


}
?>