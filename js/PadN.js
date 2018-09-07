function PadN( valor, lon ) {
	var n;
	var c;
	switch( typeof valor ) {
		case "number": {
			n = valor;
			break;
		}
		case "string": {
			n = parseInt( valor );
			break;
		} 
		default: {
			return "mal valor "+( typeof valor ); 
		}
	}
	
	switch( typeof lon ) {
		case "number": {
			c = lon;
			break;
		}
		case "string": {
			c = parseInt( lon );
			break;
		} 
		default: {

			return "mal cant"; 
		}
	}
	
	var res;
	
	if( c < 1 ){
		return "";
	}
	

	res = Array(c+1).join("0")+n;
	res = res.substring( res.length-c, res.length );
	return res;
	
}