<?php
class cHTML_Body {
	public $elementos = [];
	public $js = [];
	public $scripts = [];
	
	public function AddHTML( $code = "" ){
		$this->elementos[] = $code;
	}	
	public function AddScript( $text ){
		$this->scripts[] = $text;
	}
	public function AddJS( $href ){
		$this->js[] = $href;
	}	
	public function AddDiv( $id = "", $class = "" ){
		$res = $this->ElementOpen( "div", $id, $class );
		$res .= "&nbsp</div>";
		$this->elementos[] = $res;
	}	
	
	public function DivOpen( $id = "", $class = "" ){
		$res = $this->ElementOpen( "div", $id, $class );
		$this->elementos[] = $res;
	}	
	
	public function DivClose(  ){
		$res = "</div>";
		$this->elementos[] = $res;
	}	

	public function TableOpen( $id = "", $class = "" ){
		$res = $this->ElementOpen( "table", $id, $class );
		$this->elementos[] = $res;
	}	
	
	public function TableClose(  ){
		$res = "</table>";
		$this->elementos[] = $res;
	}	
	
	public function ElementOpen( $elem = "", $id = "", $class = "" ){
		$res = "<".$elem;
		if( $id != "" ){
			$res .= " id='".$id."'";
		}
		if( $class != "" ){
			$res .= " class='".$class."'";
		}		
		$res .= ">";
		$this->elementos[] = $res;
	}	
	public function ElementClose( $elem = "" ){
		$res = "</".$elem;
		$res .= ">";
		$this->elementos[] = $res;
	}		
}
class cHTML_Head {
	public $titulo = "";
	public $css = [];
	public $js = [];
	public $meta = [];
	public $styles = [];
	// <link href="/css/base.css" rel="stylesheet" type="text/css" />
	public function AddCSS( $href ){
		$this->css[] = $href;
	}
	public function AddJS( $href ){
		$this->js[] = $href;
	}	
	public function AddMeta( $txt ){
		$this->meta[] = $txt;
	}	
	public function StyleAdd( $name, $def ){
		$this->styles[] = [ $name, $def ] ;
	}		
}
class cHTML{
	public $head ;
	public $body ;
	
	public function cHTML(){
		$this->head = new cHTML_Head();
		$this->body = new cHTML_Body();
	}
	
	public function Render(){
		// $doctype = "<!DOCTYPE HTML PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
		$esp = "<!DOCTYPE html>";
		$esp .= "<html>";
		$esp .= "<head>";
		foreach( $this->head->meta as $key => $value ){
			$esp .= "<meta ".$value.">";
		}		
		if( $this->head->titulo != "" ){
			$esp .= "<title>".$this->head->titulo;
			$esp .= "</title>";			
		}
		foreach( $this->head->css as $key => $value ){
			$esp .= "<link href='".$value."' rel='stylesheet' type='text/css' />\n";
		}
		if( count( $this->head->styles ) > 0 ){
			$esp .= "<style>";
		}
		foreach( $this->head->styles as $key => $value ){
			$esp .= $value[0]." { ". $value[1] . " }\n";
		}
		if( count( $this->head->styles ) > 0 ){
			$esp .= "</style>";
		}		
		foreach( $this->head->js as $key => $value ){
			$esp .= "<script type='text/javascript' src='".$value."' ></script>";
		}

		
		$esp .= "</head>";
		$esp .= "<body>";
		$esp .= $this->RenderBody();
		$esp .= "</body>";
		$esp .= "</html>";
		return $esp;
	}

	public function RenderBody(){
		$esp = "";
		foreach( $this->body->elementos as $key => $value ){
			$esp .= $value;
		}
		foreach( $this->body->js as $key => $value ){
			$esp .= "<script type='text/javascript' src='".$value."' ></script>";
			// $esp .= $value;
		}		
		if( count( $this->body->scripts ) > 0 ){
			$esp .= "<script>";
			$esp .= "$(document).ready(function(){ \n ";
		}
		foreach( $this->body->scripts as $key => $value ){
			$esp .= $value;
		}
		if( count( $this->body->scripts ) > 0 ){
			$esp .= "} ); \n </script>";
		}
		return $esp;
	}

}

?>
