<?php
include_once ("config.php");
include_once( $DIST.$CLASS."/cBasica.php" );
include_once( $DIST.$CLASS."/cReporteTirada.php" );
include_once( $DIST.$LIB."/SQL.php" );
include_once( $DIST.$LIB."/fechas.php" );
include_once( $DIST.$LIB."/TiposDatos.php" );

class cReporteProduccion extends cBasica  {
	public $TestMode = false;
	public $db;
	public $idx;
	public $fecha;
	
	public $TotalKgrs;
	public $TotalKgrsCapaBlanca;
	public $pro;
	public $TiradaNeta;
	
	public $Observaciones = "";
	
	public $DetalleError;
	public $tiradas = [];
	
	
	public function ClearAll(){
		$this->idx = null;
		$this->fecha = "";
		$this->TotalKgrs = "";
		$this->TotalKgrsCapaBlanca = "";
		$this->pro = "";
		$this->Observaciones = "";
		$this->DetalleError = "";
		$this->tiradas = [];
		
	}
	public function VerificarModiPost( $post ){
		$this->DetalleError = "";
		if( ! isset( $post['idx'] ) ){ $this->DetalleError = "falta idx"; return false; }
		if( ! isset( $post['fecha'] ) ){ $this->DetalleError = "falta indicar fecha"; return false; }
		if( ! isset( $post['totalkgrs'] ) ){ $this->DetalleError = "falta indicar total de kgrs"; return false; }
		if( ! isset( $post['totalkgrscb'] ) ){ $this->DetalleError = "falta indicar total de kgrs de capa blanca"; return false; }
		if( ! isset( $post['obs'] ) ){ $this->DetalleError = "falta obs"; return false; }
		if( ! isset( $post['pro'] ) ){ $this->DetalleError = "falta Producto"; return false; }
		if( ! isset( $post["tiradaneta"] ) ){ $this->DetalleError = "falta indicar tirada neta "; }

		if( strlen( $post["fecha"] ) != 10 ){ $this->DetalleError = "mal fecha"; return false; }		
		if( strlen( $post["pro"] ) != 3 ){ $this->DetalleError = "mal Producto"; return false; }		
		if( !ValidarFecha( $post["fecha"] )  ){ $this->DetalleError = "mal fecha (2)"; return false; }
		return $this->DetalleError == "";
	}
	public function GrabarModiCabeceraPost( $post ){
		if( ! $this->VerificarModiPost( $post ) ){
			return false;
		}
		if( ! SQL_EsValido( $this->db ) ){
			$this->DetalleError = "db no asignada";
			return false;
		}

		$db = $this->db;
		// $rp->TestMode = true;
		$this->idx = $post['idx'];
		$this->fecha = $post['fecha'];
		$this->TotalKgrs = (int) $post['totalkgrs'];
		$this->TotalKgrsCapaBlanca = (int) $post['totalkgrscb'];
		$this->Observaciones = $post['obs'];
		$this->pro = $post['pro'];
		$this->TiradaNeta = (int) $post["tiradaneta"];
		
		$q = "call sp_ReporteProduccionModi( ";
		$q .= " ".$this->idx ." ,";
		$q .= "'".Fecha2SQL( $this->fecha )."' ,";
		$q .= "".$this->TotalKgrs ." ,";
		$q .= "".$this->TotalKgrsCapaBlanca ." ,";
		$q .= "'".$this->Observaciones ."' ,";
		$q .= "'".$this->pro ."' ,";
		$q .= " ".$this->TiradaNeta ." );";
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
		
		// $this->DetalleError = "falta escribir resto";
		return true;	
	}
	
	public function VerificarPost( $post ){
		$this->DetalleError = "";
		if( ! isset( $post['nrotiradas'] ) ){ $this->DetalleError = "falta indicar tiradas"; return false; }
		if( ! isset( $post['fecha'] ) ){ $this->DetalleError = "falta indicar fecha"; return false; }
		if( ! isset( $post['totalkgrs'] ) ){ $this->DetalleError = "falta indicar total de kgrs"; return false; }
		if( ! isset( $post['totalkgrscb'] ) ){ $this->DetalleError = "falta indicar total de kgrs de capa blanca"; return false; }
		if( ! isset( $post['obs'] ) ){ $this->DetalleError = "falta obs"; return false; }
		if( ! isset( $post['pro'] ) ){ $this->DetalleError = "falta Producto"; return false; }
		if( ! isset( $post["tiradaneta"] ) ){ $this->DetalleError = "falta indicar tirada neta "; }

		if( strlen( $post["fecha"] ) != 10 ){ $this->DetalleError = "mal fecha"; return false; }		
		if( strlen( $post["pro"] ) != 3 ){ $this->DetalleError = "mal Producto"; return false; }		
		if( !ValidarFecha( $post["fecha"] )  ){ $this->DetalleError = "mal fecha (2)"; return false; }		
		

		/* verificar que existan todos los datos
		*/
		// echo " hay tiradas? ";
		$nrotiradas = $post['nrotiradas'];
		if( $nrotiradas <= 0 or $nrotiradas > 10 ){
			return false;
		}

		for( $i = 1; $i <= $nrotiradas; $i++ ){
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
			
		}
		return $this->DetalleError == "";
	}
	
	public function GrabarAltaPost( $post ){
		if( ! SQL_EsValido( $this->db ) ){
			$this->DetalleError = "db no asignada";
			return false;
		}

		if( ! $this->VerificarPost( $post ) ){
			// echo $this->DetalleError;
			return false;
		}
		
		$nrotiradas = $post['nrotiradas'];
		if( $nrotiradas <= 0 or $nrotiradas > 10 ){
			$this->DetalleError = "mal nro tiradas";
			return false;
		}
		
		// $rp->TestMode = true;
		$this->fecha = $post['fecha'];
		$this->TotalKgrs = (int) $post['totalkgrs'];
		$this->TotalKgrsCapaBlanca = (int) $post['totalkgrscb'];
		$this->Observaciones = $post['obs'];
		$this->pro = $post['pro'];
		$this->TiradaNeta = (int) $post["tiradaneta"];
		
		for( $i = 1; $i <= $nrotiradas; $i++ ) {
			$rt = new cReporteTirada();
			$rt->db = $this->db;
			$rt->nro = $i;
			$rt->horaini = $post["horaini".$i];
			$rt->horafin = $post["horafin".$i];
			$rt->MaqIni = (int) $post["maqini".$i];
			$rt->MaqFin = (int) $post["maqfin".$i];
			$rt->TiradaBruta = (int) $post["tiradabruta".$i];
			$rt->Carga = (int) $post["carga".$i];
			$rt->Desperdicios = (int) $post["desperdicio".$i];
			
			$rt->Kgrs = (int) $post["kgrs".$i];
			$rt->pagcolor = (int) $post["pagcolor".$i];
			$rt->pagtotal = (int) $post["pagtotal".$i];
			$this->AgregarTirada( $rt );
		}
		
		if( ! $this->GrabarAlta( ) ){
			return false;
		}
		return true;
	}
	/* true si lo pudo leer.
	*/
	public function Leer( ){
		$db = $this->db;
		$this->DetalleError = "";
		if( ! EsClase( $db , "mysqli" ) ){
			$this->DetalleError = "falta DB";
			return false;
		}
		if( ! ValidarFecha( $this->fecha ) ){
			$this->DetalleError = "falta fecha";
			return false;
		}
		
		$q = "call sp_ReporteProduccionLeerXFecha( ";
		$q .= "'".Fecha2SQL( $this->fecha )."'  );";
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
		
		/* SP devuelve el idx en un select
		*/
		$idx = 0;
		if( $db->more_results() ) {
		
			/* por logica deberia ser 1 reporte por dia
			pero puede que tengamos que cambiar todo esto.
			*/
			if( $obj = $res->fetch_object() ){
				$this->idx =  $obj->idx ;
				// settype( $this->idx, "integer" );
				$fecrep = $obj->fecrep ;
				$totkgrep = $obj->totkgrep ;
				$totkgcbrep = $obj->totkgcbrep ;
				$obsrep = $obj->obsrep ;
				$TiradaNeta = $obj->tirneta;
			}
			
			while ( $db->more_results() ){
				$db->next_result();
			}
		} else {
			$this->DetalleError = "Sin IDX" ;
			return false;
		}
		

		// $this->idx = $idx;
		if( ! last_result( $db ) ){
			$this->DetalleError = "FALLO SP" ;
			return false;
		}
		return true;
		
	}

		/* true si lo pudo leer.
	*/
	public function LeerIdx( ){
		$db = $this->db;
		$this->DetalleError = "";
		if( ! EsClase( $db , "mysqli" ) ){
			$this->DetalleError = "falta DB";
			return false;
		}
		// echo gettype( $this->idx);
		// echo gettype( $this->idx);
		if( !EsInt( (int) $this->idx ) ){
			$this->DetalleError = "falta idx ".$this->idx;
			return false;
		}
		// echo $this->idx;
		$q = "call sp_ReporteProduccionLeerXIDX( ";
		$q .= " ". $this->idx ." );";
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
		
		/* SP devuelve el idx en un select
		*/
		$idx = 0;
		if( $db->more_results() ) {
		
			/* por logica deberia ser 1 reporte por dia
			pero puede que tengamos que cambiar todo esto.
			*/
			if( $obj = $res->fetch_object() ){
				// idx, fecrep, totkgrep, totkgcbrep, obsrep
				// var_dump( $obj );
				// $this->idx = $obj->idx ;
				$this->fecha = SQL2Fecha( $obj->fecrep );
				$this->TotalKgrs = $obj->totkgrep ;
				$this->TotalKgrsCapaBlanca = $obj->totkgcbrep ;
				$this->Observaciones = $obj->obsrep ;
				$this->TiradaNeta = $obj->tirneta;
				$this->pro = $obj->prorep ;
			}
			
			while ( $db->more_results() ){
				$db->next_result();
			}
		} else {
			$this->DetalleError = "Sin IDX" ;
			return false;
		}
		

		// $this->idx = $idx;
		if( ! last_result( $db ) ){
			$this->DetalleError = "FALLO SP" ;
			return false;
		}
		
		/* ok pero falta determinar reportes de tiradas.
		sp_ReporteProduccionLeerTiradasXIDX
		*/
		
		$q = "call sp_ReporteProduccionLeerTiradasXIDX( ";
		$q .= " ".$this->idx ." );";
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
		
		/* SP devuelve el idx en un select
		*/
		// $idx = 0;
		if( $db->more_results() ) {
			while( $obj = $res->fetch_object() ){
				$rt = new cReporteTirada();
				$rt->idx = $obj->idx;
				$rt->nro = $obj->nrort;
				$rt->horaini = $obj->inirt;
				$rt->horafin = $obj->finrt;
				$rt->MaqIni = $obj->maqinirt;
				$rt->MaqFin = $obj->maqfinrt;
				$rt->TiradaBruta = $obj->tirbrutart ;
				$rt->Carga= $obj->cargart;
				$rt->Desperdicios = $obj->desprt;

				$rt->Kgrs = $obj->kgrsrt;
				$rt->pagtotal = $obj->pagtotrt;
				$rt->pagcolor = $obj->pagcolorrt;
				$rt->idxrep = $obj->idxrep;
				$this->tiradas[] = $rt;
			}
			
			while ( $db->more_results() ){
				$db->next_result();
			}

		} else {
			$this->DetalleError = "Sin IDX reporte tiradas ".$q ;
			return false;
		}
		

		$this->idx = $idx;
		if( ! last_result( $db ) ){
			$this->DetalleError = "FALLO SP" ;
			return false;
		}
		
		return true;
		
	}

	public function GrabarAlta( ){
		if( !$this->EsValido() ){
			return false;
		}
		$db = $this->db;
		
		if( ! $this->TestMode ) {
			$q = "start transaction;";
			try {
				$res = $db->query( $q );
			} catch ( Exception $e ) {
				$this->DetalleError  = $e->getMessage() ;
				return false;
			}
			if( $res === FALSE ) {
				$this->DetalleError  = "Error: ". $db->error ;
				return false;
			}

		}
		
		$q = "call sp_ReporteProduccionAlta( ";
		$q .= "'".Fecha2SQL( $this->fecha )."' ,";
		$q .= "".$this->TotalKgrs ." ,";
		$q .= "".$this->TotalKgrsCapaBlanca ." ,";
		$q .= "'".$this->Observaciones ."' ,";
		$q .= "'".$this->pro ."' ,";
		$q .= " ".$this->TiradaNeta ." );";
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
		
		/* SP devuelve el idx en un select
		*/
		$idx = 0;
		if( $db->more_results() ) {
			if( $obj = $res->fetch_object() ){
				$idx = $obj->idx ;
			}
			while ( $db->more_results() ){
				$db->next_result();
			}
		} else {
			$this->DetalleError = "Sin IDX" ;
			return false;
		}
		
		if( $idx == 0 ){
			$this->DetalleError = "IDX en cero" ;
			return false;
		}
		$this->idx = $idx;
		if( ! last_result( $db ) ){
			$this->DetalleError = "FALLO SP" ;
			return false;
		}
		
		/* grabar los items de reportes de tiradas
		*/
		for( $i = 0; $i < count( $this->tiradas ); $i ++ ){
			$this->tiradas[ $i ]->db = $this->db;
			$this->tiradas[ $i ]->idxrep = $idx;
			if( ! $this->tiradas[ $i ]->GrabarAlta() ){
				$this->DetalleError = "fallo grabar item $i: ".$this->tiradas[ $i ]->DetalleError ;
				$q = "rollback;";
				try {
					$res = $db->query( $q );
				} catch ( Exception $e ) {
					return false;
				}
				return false;
			}
		}

		
		if( ! $this->TestMode ) {
			$q = "commit;";
			try {
				$res = $db->query( $q );
			} catch ( Exception $e ) {
				$this->DetalleError = $e->getMessage() ;
				return false;
			}
			if( $res === FALSE ) {
				$this->DetalleError  = "Error: ". $db->error ;
				return false;
			}
		}
		return true;
	}
	
	
	
	public function EsValido( ){
		$this->DetalleError = "";
		if( ! ValidarFecha ( $this->fecha ) ){
			$this->DetalleError = "Fecha Invalida";
			return false;
		}
		if( ! EsInt( $this->TotalKgrs ) ){
			$this->DetalleError = "Total Kgrs Invalido";
			return false;		
		}
		if( ! EsInt( $this->TotalKgrsCapaBlanca ) ){
			$this->DetalleError = "Total Kgrs CB Invalido";
			return false;		
		}
		if( ! EsString( $this->Observaciones ) ){
			$this->DetalleError = "Observaciones Invalido";
			return false;		
		}
		
		if( count( $this->tiradas ) == 0 ){
			$this->DetalleError = "Sin reportes tiradas";
			return false;		
		}
		if( ! EsClase( $this->db, "mysqli" ) ){
			$this->DetalleError = "falta db";
			return false;		
		}		
		return true;
		
	}
	public function AgregarTirada( $rt ){
		if( ! EsClase( $rt, "cReporteTirada") ){
			$this->DetalleError = "RT Clase Invalida";
			return false;
		}
		if( ! $rt->EsValido() ){
			$this->DetalleError = "validacion tirada: ".$rt->DetalleError;
			return false;
		}
		$rt->db = $this->db;
		$this->tiradas[] = $rt;
		return true;
		
		
		
	}
	
}
?>
