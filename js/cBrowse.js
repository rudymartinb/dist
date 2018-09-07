function cBrowse(){
	this.colcount = 0;
	this.rowcount = 0;
	this.visibleColcount = 0;
	this.ClearAll();
	this.containerID = "";
	this.columnas = Array();
	this.columnas = Array();
	this.ajaxLeer = "";
	this.rows = [];
	this.Indices = [];
	
	this.idContenedor = "";
	
	this.ancho = 0;
	this.alto = 0;
	this.altomax = 0;
	this.altorenglon = 0;
	this.cantmaxren = 0;
	this.cantcolvis = 0;
	
	this.DetalleError = "";
	
	/* si es false entonces hay q "rearmar" el control
	*/
	this.estable = false;

	// renglon y columna relativos al vector de datos
	this.renglon = 0;
	this.columna = 0;
	/* coordenadas celda relativa a la ventana
	*/
	this.renact = 0; 
	this.colact = 0;
	
	/* banderas de bordes
	*/
	this.hitTop = false;
	this.hitBottom = false;
	this.hitLeft = false;
	this.hitRight = false;
	
	/* renglon absoluto inicial
	*/
	this.renini = 0;
	
	/* asunto colores
	*/
	this.color = 0 ;
	
};

cBrowse.prototype.Setup = function() {
	this.cantcolvis = this.CalcularCantMaxColVisibles();
};
/* manejo columnas
*/
cBrowse.prototype.ObtenerColumna = function( colname ) {
	var cols = this.columnas;
	for(i=0;i<this.columnas.length;i++){
		if( this.columnas[i].id == colname ){
			return i;
		}
	}
	this.DetalleError = "no se encontro columna "+colname;
	return null;
}
cBrowse.prototype.IdColActiva = function( nro ) {
	if( nro > this.columnas.length ){
		this.DetalleError = "Mal Nro Columna";
		return "";
	}
	return this.columnas[nro].id;
}
cBrowse.prototype.ValorCelda = function( ren, col ) {
	/* esto esta mal, 
	** col tiene q hacer referencia a la primera columan visible
	*/
	var res = "";
	
	if( ren >= this.rows.length ){
		this.DetalleError = "ValorCelda: mal renglon "+ren;
		return "";
	}
	if( col >= this.columnas.length ){
		this.DetalleError = "ValorCelda: mal columna (1) "+col;
		return "";
	}
	var colname = this.columnas[ col ].id ;
	if( colname == ""   ){
		this.DetalleError = "ValorCelda: mal columna (2) "+col;
		return "";		
	}
	if( colname == null ){
		this.DetalleError = "ValorCelda: mal columna (3) "+col;
		return "";		
	}	
	var valorcelda = this.rows[ ren ][ colname ];
	var res;
	if( valorcelda == null ){
		valorcelda = "&nbsp;"; // 
		valorcelda = "x"; // 
	}
	if( valorcelda != "" ){
		res = valorcelda;
		return res;
	}
	this.DetalleError = "ValorCelda: No se encontro propiedad";
	return "";

}
cBrowse.prototype.ArmarCelda = function( ren, col ) {
	/* esto esta mal, 
	** col tiene q hacer referencia a la primera columan visible
	** de momento las columnas invisibles deberan quedar al final de la lista
	*/
	var res = "";
	
	if( ren >= this.rows.length ){
		this.DetalleError = "ArmarCelda: mal renglon "+ren;
		return "";
	}
	if( col >= this.columnas.length ){
		this.DetalleError = "ArmarCelda: mal columna (1) "+col;
		return "";
	}
	var colname = this.columnas[ col ].id ;
	if( colname == ""   ){
		this.DetalleError = "ArmarCelda: mal columna (2) "+col;
		return "";		
	}
	if( colname == null ){
		this.DetalleError = "ArmarCelda: mal columna (3) "+col;
		return "";		
	}	
	var valorcelda = this.rows[ ren ][ colname ];
	var res;
	if( valorcelda == null ){
		valorcelda = "&nbsp;";
		valorcelda = "x";
	}
	if( valorcelda == "" ){
		valorcelda = "&nbsp;";
		valorcelda = "x";
	}

	if( valorcelda != "" ){
		/* aca deberiamos generar estilos?
		*/
		res = "<div style='";
		res += this.columnas[col].estilo;
		res += "'>";
		res += valorcelda;
		res += "</div>";
		return res;
	}
	this.DetalleError = "ArmarCelda: No se encontro propiedad";
	return "";
	
}

cBrowse.prototype.ArmarTitulos = function() {
	var ren = "<div id='TITULOS'>";
	var i ;
	
	for( i = 0; i < this.columnas.length; i++){
		var col = this.columnas[i];
		if( col.visible ){
			// console.log( "ren: "+ren );
			var estilo = col.estilo;
			var id = col.id;
			var clase = col.clase;
			ren += "<div ";
			if( clase != "" ){
				ren += "class='"+clase+"' ";
			}			
			if( estilo != "" ){
				ren += "style='"+estilo+"' ";
			}
			if( id != "" ){
				ren += "id='"+id+"' ";
			}
			ren += ">";
			var valor = col.header;
			ren += valor;
			ren += "</div>";
		}
	}
	ren += "</div>";
	return ren;

}
cBrowse.prototype.ArmarRenglon = function( nro ) {
	var ren="";
	var i ;
	// ren += "<div >";
	for( i = 0; i < this.columnas.length; i++){
		var col = this.columnas[i];
		if( col.visible ){
			var estilo = col.ArmarEstilo();
			var id = col.id;
			var clase = col.clase;
			ren += "<div ";
			if( clase != "" ){
				ren += "class='"+clase+"' ";
			}			
			if( estilo != "" ){
				ren += "style='"+estilo+"' ";
			}
			if( id != "" ){
				ren += "id='"+id+"' ";
			}
			ren += ">";
			var valor = this.rows[nro][id];
			if( valor == "" ){
				valor = "&nbsp;";
				valor = "x";
			}
			if( valor == null ){
				valor = "&nbsp;";
				valor = "x";
			}				
			ren += valor;
			ren += "</div>";
		}
	}

	return ren;

}
cBrowse.prototype.CalcularAnchoContenedor = function() {
	return $(this.idContenedor).width();
}

/* la idea de este este metodo 
** es que se tiene q ejecutar una sola vez 
** cuando se arma el control.
*/
cBrowse.prototype.Render = function() {
	this.DetalleError = "";
	if( this.columnas == null ){
		this.DetalleError = "Sin columnas definidas";
		return false;
	}
	if( this.rows == null ){
		this.DetalleError = "Sin datos";
		return false;
	}
	if( this.cantmaxren == 0 ){
		this.DetalleError = "Sin datos";
		return false;
	}
	var i;

	$(this.idContenedor).empty();
	/* falta input text
	*/
	var html = "";
	html = "<input type='text' id='abuscar'>";
	$(this.idContenedor).append( html );
	$(this.idContenedor).append( this.ArmarTitulos() );
	
	for( i = 0; i< this.cantmaxren; i ++){
		if( i >= this.rowcount ){
			break;
		}
		var ren = "";
		ren += "<div id='RL"+i+"'>";
		ren += this.ArmarRenglon( i );
		ren += "</div>";
		$(this.idContenedor).append( ren );
	}
	this.estable = true;
	this.AsignarTeclas( "#abuscar" );
	return true;
}

cBrowse.prototype.AsignarTeclas = function( abuscar ){
	var browse = this;
	$( abuscar ).keydown(function( data ) {
		if( data.which == 45 ) {
			return false;
		}
		// if( data.which == 13 && seleccion >= 0 ) {
			// return false;
		// }
		// del
		// if( data.which == 46 && seleccion >= 0 ) {
			// return false;
		// }		
		// izquierda
		if( data.which == 37  ) {
			browse.Izquierda();
			return false;
		}		
		// derecha
		if( data.which == 39  ) {
			browse.Derecha();
			return false;
		}		
		// up
		if( data.which == 38  ) {
			browse.Arriba();
		}
		// abajo
		if( data.which == 40  ) {
			browse.Abajo();
		}
		// page down
		if( data.which == 34  ) {
			browse.PageDown();
		}
		// pageup
		if( data.which == 33  ) {
			browse.PageUp();
		}
		// home
		if( data.which == 36  ) {
			browse.Home();
			return false;
		}
		// end
		if( data.which == 35 ) {
			browse.End();
			return false;
		}
		
		// backspace
		if( data.which == 8 ){
			var valor;
			valor = $(abuscar).val();
			if( valor.length > 0){
				valor = valor.substring( 0, valor.length-1);
				$(abuscar).val(valor);
				browse.Buscar( valor, "raz" ); 
			}
			return false;
		}
		return true;
	});
	
	$( abuscar ).keypress(function(data) {
		var tmp;
		var valor;
		if( data.charCode > 8  ){
			valor = $(abuscar).val();
			tmp = String.fromCharCode(data.charCode);
			tmp = tmp.toUpperCase(tmp);
			valor += tmp;
			
			if( browse.Buscar( valor, "raz" ) ){
				$(abuscar).val(valor);
			}; 
		
			return false;
		}


		return true;
	});
}

cBrowse.prototype.Derecha = function(){
	if( this.colact >= this.cantcolvis-1  ){
		this.DetalleError = "Columna derecha";
		return false;
	}
	this.RenderRenglonActiva();
	this.colact ++;
	this.RenderCeldaActiva();
	return true;
}
cBrowse.prototype.Izquierda = function(){
	if( this.colact == 0 ){
		this.DetalleError = "Columna cero";
		return false;
	}
	this.RenderRenglonActiva();
	this.colact --;
	this.RenderCeldaActiva();
	return true;
}
/*
*/
cBrowse.prototype.Refrescar = function(){
	var i;
	var j;
	// renglon?

	for( i = 0; i <= this.cantmaxren-1; i++){
		var renid1 = "#RL"+i;
		var obj1 = $(renid1);
		for(j=0;j<this.cantcolvis;j++){
			var colid;
			var valor;
			colid = this.columnas[j].id;
			if( this.columnas[j].visible ){
				valor = this.rows[this.renini+i][colid];
				if( valor == "" ){
					valor = "&nbsp;";
				}
				if( valor == null ){
					valor = "&nbsp;";
				}				
				obj1.children( "#"+colid ).html( valor );
			}
		}
		
	}

	this.RenderRenglonActiva();
	this.RenderCeldaActiva();
	return true;
}

cBrowse.prototype.Home = function(){
	this.RenderRenglonNormal();
	this.renglon = 0;
	this.renact = 0;
	this.renini = 0;
	this.Refrescar();
	this.RenderRenglonActiva();
	this.RenderCeldaActiva();
	return true;
}
cBrowse.prototype.End = function(){
	this.RenderRenglonNormal();
	this.renglon = this.rowcount-1;
	this.renact = this.cantmaxren-1;
	this.renini = this.rowcount - this.cantmaxren ;
	this.Refrescar();
	this.RenderRenglonActiva();
	this.RenderCeldaActiva();
	return true;
}

cBrowse.prototype.PageUp = function(){
	// falta comprar renini con rowcount y cantmaxren
	if( this.renini - this.cantmaxren < 0 ){
		this.renini = 0;
	} else {
		this.renini -= this.cantmaxren;
	}
	this.Refrescar();
}
cBrowse.prototype.PageDown = function(){
	// falta comprar renini con rowcount y cantmaxren
	if( this.renini + this.cantmaxren >= this.rowcount - this.cantmaxren ){
		this.renini = this.rowcount - this.cantmaxren;
	} else {
		this.renini += this.cantmaxren;
	}
	this.Refrescar();
}

cBrowse.prototype.ScrollDown1 = function(){
	// falta comprar renini con rowcount y cantmaxren
	this.renini ++;
	this.Refrescar();
}
cBrowse.prototype.ScrollUp1 = function(){
	// falta comprar renini con rowcount y cantmaxren
	if( this.renini == 0){
		return false;
	}
	this.renini--;
	return this.Refrescar();
}

cBrowse.prototype.Abajo = function(){
	
	if( this.renact >= this.cantmaxren-1 ){
		if( this.renini + this.cantmaxren == this.rowcount ){
			return false;
		}
		this.ScrollDown1();
		this.renglon++;
		this.DetalleError = "Fin Ventana";
		return false;
	};
	this.RenderRenglonNormal();
	this.renact++;
	this.renglon++;
	this.RenderRenglonActiva();
	this.RenderCeldaActiva();
	return true;
}
cBrowse.prototype.Arriba = function(){
	if( this.renact == 0 ){
		if( this.renglon == 0 ){
			this.hitTop = true;
			return false; // ?
		} 
		// insertar renglon arriba, eliminar el ultimo.
		this.renglon --;
		this.ScrollUp1();
		
	} else {
		this.hitTop = false;
		this.RenderRenglonNormal();
		this.renact --;
		this.renglon --;
		this.RenderRenglonActiva();
		this.RenderCeldaActiva();
	}
	return true;
}

/* Goto( renglon )
** posicionarse en el elemento del vector 
*/
cBrowse.prototype.Goto = function( renglon ){
	if( renglon == null ){
		return false;
	}
	if( renglon >= this.rowcount ){
		return false; //??
	}
	
	/* determinar si tenemos que reubicar renact
	*/
	if( renglon < this.cantmaxren ){
		this.RenderRenglonNormal();
		this.renini = 0;
		this.renact = renglon;
		this.renglon = renglon;
		this.Refrescar();
		return true;
	}
	if( renglon > this.rowcount - this.cantmaxren ){
		this.RenderRenglonNormal();
		this.renini = this.rowcount - this.cantmaxren;
		this.renact = this.rowcount - renglon;
		this.renglon = renglon;
		this.Refrescar();
		return true;
	}
	this.RenderRenglonNormal();
	this.renini = renglon - this.renact;
	this.renglon = renglon;
	this.Refrescar();
	
	return true;
}
cBrowse.prototype.RenderRenglonActiva = function() {
	if( ! this.estable ){
		this.DetalleError = "Control no estable";
		return false;
	}
	/* determinar renglon logico
	*/
	var idren = 'RL'+this.renact ;
	/* determinar columna activa
	*/
	var idcol = this.columnas[this.colact].id;
	var estiloact = this.columnas[this.colact].ArmarEstiloActivo();
	var obj = $("#"+idren).children();
	// console.debug( obj );
	obj.css( "background-color","#FFCCFF");
	// obj.css( "background-color","magenta");
	obj.css( "color","black");
	
	this.columnas[this.colact].ArmarEstiloActivoObj( obj );
	
	return true;
}

cBrowse.prototype.RenderRenglonNormal = function() {
	if( ! this.estable ){
		this.DetalleError = "Control no estable";
		return false;
	}
	/* determinar renglon logico
	*/
	var idren = 'RL'+this.renact ;
	/* determinar columna activa
	*/
	var idcol = this.columnas[this.colact].id;
	var estiloact = this.columnas[this.colact].ArmarEstilo();
	var obj = $("#"+idren).children();
	// console.debug( obj );
	obj.css( "background-color","white");
	// obj.css( "background-color","magenta");
	obj.css( "color","black");
	
	this.columnas[this.colact].ArmarEstiloActivoObj( obj );
	
	return true;
}


cBrowse.prototype.RenderCeldaActiva = function( ) {
	if( ! this.estable ){
		this.DetalleError = "Control no estable";
		return false;
	}
	/* determinar renglon logico
	*/
	var idren = 'RL'+this.renact ;
	/* determinar columna activa
	*/
	var idcol = this.columnas[this.colact].id;
	var estiloact = this.columnas[this.colact].ArmarEstiloActivo();
	var obj = $("#"+idren).children( "#"+idcol );
	$("#"+idren).css( "background-color","#FFCCFF");
	
	obj.css( "background-color","magenta");
	obj.css( "color","white");
	
	this.columnas[this.colact].ArmarEstiloActivoObj( obj );
	
	return true;
}

cBrowse.prototype.RenderCeldaNormal = function( ) {
	if( ! this.estable ){
		this.DetalleError = "Control no estable";
		return false;
	}
	/* determinar renglon logico
	*/
	var idren = 'RL'+this.renact ;
	/* determinar columna activa
	*/
	var idcol = this.columnas[this.colact].id;
	// var estiloact = this.columnas[this.colact].estilo;
	
	// $("#"+idren).css( "background-color","#FFCCFF");
	$("#"+idren).children( "#"+idcol ).css( "background-color","");
	$("#"+idren).children( "#"+idcol ).css( "color","");
	return true;
}


cBrowse.prototype.CalcularAlto = function( ) {
	if( this.idContenedor == "" ){
		return false;
	}
	if( this.alto > 0 ){
		return true;
	}
	var objCont = $(this.idContenedor);
	var alto = $(this.idContenedor).height();
	if( alto == 0 ){
		objCont = $(this.idContenedor).parent();
		alto = objCont.height();
	}
	if( alto > 0 ){
		this.alto = alto;
	}
	return alto > 0;

}

cBrowse.prototype.CalcularAncho = function( ) {
	if( this.idContenedor == "" ){
		return false;
	}
	if( this.ancho > 0 ){
		return true;
	}
	var objCont = $(this.idContenedor);
	var ancho = $(this.idContenedor).width();
	if( ancho == 0 ){
		objCont = $(this.idContenedor).parent();
		ancho = objCont.width();
	}
	return ancho > 0;

}

cBrowse.prototype.idPrimeraCol = function( ) {
	var ren = "";
	var i ;
	if( this.columnas.length == 0 ){
		this.DetalleError = "Sin columnas";
		return "";
	}
	for( i = 0; i < this.columnas.length; i++){
		var col = this.columnas[i];
		if( col.visible  ){
			return col.id;
		}
	}
	this.DetalleError = "Sin columnas visibles";
	return "";
}
cBrowse.prototype.CalcularAltoRenglon = function( ) {
	if( this.idContenedor == "" ){
		this.DetalleError = "idContenedor vacio";
		return false;
	}
	
	/* generar texto renglon simulado 
	en base a columnas visibles
	llevará id unico
	*/
	var ren = this.SimularRenglon();
	var alto = 0 ;
	
	var idcol = "#"+this.idPrimeraCol();
	
	$(this.idContenedor).append( ren );
	alto = $(idcol).height();
	$("#simutxt").remove();
	if( alto > 0 ) {
		this.altorenglon = alto;
		return true;
	}
	this.DetalleError = "alto = 0";
	return false;
}

cBrowse.prototype.CalcularCantMaxRen = function() {
	if( this.altorenglon == 0 ){
		this.DetalleError = "Falta Calcular Alto Renglon";
		return false;
	}
	if( this.alto == 0 ){
		this.DetalleError = "Falta Calcular Alto ";
		return false;
	}	
	if( this.altomax > 0 ){
		this.cantmaxren = Math.floor( this.altomax / this.altorenglon );
		return true;
	}
	this.cantmaxren = Math.floor( this.alto / this.altorenglon );
	return true;
}
cBrowse.prototype.SimularCelda = function( idcol ){
	var ren = "";
	// ren = this.SimularRenglon();
	
	var i ;
	ren += "<div id='simutxt'>";
	for( i = 0; i < this.columnas.length; i++){
		var col = this.columnas[i];
		if( col.visible  ){
			if( col.id == idcol ) {
				//console.log( "ren: "+ren );
				var estilo = col.estilo;
				var id = col.id;
				var clase = col.clase;
				ren += "<div ";
				if( clase != "" ){
					ren += "class='"+clase+"' ";
				}			
				if( estilo != "" ){
					ren += "style='"+estilo+"' ";
				}
				ren += "id='simucelda' >";
				ren += col.name;
				ren += "</div>";
				break;
			}
		}
	}
	ren += "</div>";
	return ren;
}
cBrowse.prototype.CalcularAnchoCelda = function ( idcol ){
	var ren = this.SimularCelda(idcol);
	var ancho = 0 ;
	
	$(this.idContenedor).append( ren );
	var ancho = $("#simucelda").width();
	$("#simutxt").remove();
	if( ancho > 0 ) {
		return ancho;
	}
	return 0;

};

/* esto esta mal, toma como referencia la primera columa
** y debe ser la primera visible.
*/
cBrowse.prototype.CalcularCantMaxColVisibles = function (){
	// if( this.ancho == 0 ){
		// return false;
	// }	
	var i;
	var resultado = 0;
	var cant = 0;
	var ren = "";
	ren += "<div id='simutxt'>";
	for( i = 0; i < this.columnas.length; i++){
		var col = this.columnas[i];
		if( col.visible ){
			var ancho = this.CalcularAnchoCelda( col.id );
			var evaluar ;
			evaluar += resultado + ancho;
			if( evaluar > this.ancho ){
				return cant;
			}
			cant ++;
		}
	}
	return cant;
}


cBrowse.prototype.SimularRenglon = function( ) {
	var ren = "";
	var i ;
	ren += "<div id='simutxt'>";
	for( i = 0; i < this.columnas.length; i++){
		var col = this.columnas[i];
		// console.log( "ren: "+ren );
		// console.log( col );
		// console.log( col.visible );
		if( col.visible ){
			// console.log( "ren: "+ren );
			var estilo = col.estilo;
			var id = col.id;
			var clase = col.clase;
			ren += "<div ";
			if( clase != "" ){
				ren += "class='"+clase+"' ";
			}			
			if( estilo != "" ){
				ren += "style='"+estilo+"' ";
			}
			if( id != "" ){
				ren += "id='"+id+"' ";
			}
			ren += ">";
			ren += col.name;
			ren += "</div>";
		}
	}
	ren += "</div>";
	
	// console.log( "ren: "+ren );
	return ren;
}


cBrowse.prototype.addCol = function( c ) {
	this.columnas.push( c );
	this.colcount = this.columnas.length;
	if( c.visible ) {
		this.visibleColcount ++;
	}
	return true;
}

cBrowse.prototype.addRow = function( r ) {
	this.rows.push( r );
	this.rowcount = this.rows.length;
	return true;
}


/* 
** ind = array de arrays de dos elementos,
** el primero es el nro elemento que hay q devolver
** el segundo es la clave en cuestion sobre la q hay q buscar
** que = dato a buscar
*/ 
function BuscarIndice( ind, que ){
	var pos = null;
	if( ind.length == 0 ){
		return -1;
	}
	var ini = 0;
	var	fin = ind.length-1;
	var medio ;
	var lon = que.length;
	var valor;
	
	/* determinar si estamos en rango de datos a buscar
	*/
	valor = ind[ini][1];
	if( que < valor ){
		return ind[ini][0];
	}
	valor = ind[fin][1];
	if( que > valor ){
		return ind[fin][0];
	}
	
	
	while( true ){
		medio = Math.floor( (ini+fin)/2);
		valor = ind[medio][1];
		if( que == valor.substring( 0, lon ) ){
			// return ind[medio][0];
			// console.log( valor );
			if( ini == fin ){
				return ind[medio][0];
			}
			if( ini+1 == fin ){
				return ind[medio][0];
			}			
			fin = medio;
		} else {
			/* para evitar que el bucle quede dando vueltas sin fin,
			** si le pasamos un dato no existente, devuelve lo ultimo q tiene
			*/
			if( ini == fin ){
				return null; // ind[medio][0];
			}
			if( ini+1 == fin ){
				return ind[fin][0];
			}
			if( que < valor.substring( 0, lon ) ){
				fin = medio;
			} else {
				ini = medio;
			}
		}
	}
	return pos;
}


function Indexar2D( arr, ind ){

	var resultado = [];

	// parametros inválidos
	if( arr == null ){
		return null;
	}
	if( ind == null ){
		return null;
	}
	
	// sin valores
	if( arr.length == 0 ){
		return resultado;
	}
	
	/* si tenemos un solo valor, devolvemos eso nomas
	*/
	if( arr.length == 1 ){
		return [ [0, arr[ind]] ];
	}
	
	var i;
	for( i = 0; i < arr.length; i++ ){
	
		var valor = arr[i][ind];
		var control = false;
		var ini, fin, medio;
		ini = 0;
		fin = resultado.length-1;
		
		/* primeramente determinamos si el valor a insertar 
		** esta fuera de los valores iniciales y finales.
		*/
		var comparar;
		if( resultado.length > 0 ){
			comparar = resultado[ini][1];
			if( valor < comparar ){
				resultado.splice( ini,0, [i, valor] );
				control = true;
				// break;
			} else {
				if( fin > 0 ){
					comparar = resultado[fin-1][1];
					if( valor > comparar ){
						resultado.push( [i,valor ] );
						control = true;
					}
				}
			}
		}
		
		/* determinar punto medio y comparar donde insertar el elemento
		*/
		while( resultado.length > 0 && ! control ){
			if( resultado.length == 1 ){
				if( valor < resultado[0][1] ){
					resultado.splice( ini,0, [i, valor] );
					control = true;
				} 
				break;
			}

			
			medio = Math.floor( (ini+fin)/2 );
			comparar = resultado[medio][1];
			if( valor < comparar ){
				fin = medio;
			} else {
				ini = medio;
			}
			if( ini == fin ){
				resultado.splice( ini,0, [i, valor] );
				control = true;
				break;
			}

			if( ini+1 == fin ){
				resultado.splice( fin,0, [i, valor] );
				control = true;
				break;
			}
			
		}
		if( ! control ){
			resultado.push( [i, valor] );
		}
		
	}
	return resultado;
}


cBrowse.prototype.Indexar = function( columna ) {

	var idx = Array();
	var i;
	// determinar q exista la columna
	var control = false;
	for( i = 0; i< this.colcount; i++ ){
		if( this.columnas[i].id == columna ){
			control = true;
			break;
		}
	}
	if( ! control ){
		return false;
	}
	// console.log( "Indexando" );
	this.Indices[ columna ] = Indexar2D( this.rows, columna );
	// console.log( this.Indices[ columna ] );
	return true;
	
}

/* que = valor a buscar
** indice = nombre columna indexada
*/
cBrowse.prototype.Buscar = function( que, indice ) {
	if( this.Indices[ indice ] == null ){
		return false; 
	}
	var pos ;
	pos = BuscarIndice(  this.Indices[ indice ] , que );
	if( pos == null ){
		return false;
	}
	if( que == this.rows[ pos ][indice].substring(0,que.length) ){
		this.Goto( pos );
		return true;
	}
	return false;
}
cBrowse.prototype.Leer = function() {
	if( this.ajaxLeer == "" ){
		return null;
	}
	
	var datos;
	
	var resultado;
	var ajax;
	var rows = Array();
	// var idx = Array();
	ajax = this.ajaxLeer;

	$.ajax({
		url: ajax,
		type: "POST",
		async: false,
		success: function( data ) {
			var i;
			var lon;
			var row;
			var obj = $.parseJSON( data );
			lon = obj.length;
			for ( i=0;i<lon;i++){
				row = obj[i];
				rows.push( row );
			}
			datos = rows;
		}
	});	
	this.rows = rows;
	this.rowcount = rows.length;
	return datos;
}
cBrowse.prototype.focus = function() {
	$( abuscar ).focus();
}
cBrowse.prototype.ClearAll = function() {
	// this.clase = "cBrowse"
	// this.clasetit = "columnatitulo"
	// this.id = "";
	// this.titulo = "";
	// this.visible = true;
	// this.congelada = false;
	// this.mostrable = true;
	// this.escondible = true;
};


/*	=============================
	=============================
	=============================
*/
function cColumn(){
	this.id = "";
	this.header = "";

	/* resultados de ArmarEstilos
	*/
	this.estilo = "";
	this.estiloact = "";
	
	this.visible = true;
	this.clase = "";
	this.DetalleError = "";
	
	// dimensiones
	this.anchomin = "";
	this.ancho = "";
	this.altomin = "";
	this.alto = "";
	this.cfloat = ""; 
	this.cclear = ""; 
	
	this.bgcolor = "";
	this.bgcoloract = "";
	this.fgcolor = "";
	this.fgcoloract = "";
};

cColumn.prototype.ArmarEstilo = function() {
	var res="";
	// res += "float:left;";
	if( this.anchomin != "" ){
		res += "min-width:"+this.anchomin+";";
	}
	if( this.ancho != "" ){
		res += "width:"+this.ancho+";";
	}	
	if( this.altomin != "" ){
		res += "min-height:"+this.altomin+";";
	}	
	if( this.alto != "" ){
		res += "height:"+this.alto+";";
	}	
	if( this.cfloat != "" ){
		res += "float:"+this.cfloat+";";
	}
	if( this.cclear != "" ){
		res += "clear:"+this.cclear+";";
	}
	if( this.bgcolor != "" ){
		res += "background-color:"+this.bgcolor+";";
	}
	if( this.fgcolor != "" ){
		res += "color:"+this.fgcolor+";";
	}
	
	this.DetalleError = "";
	
	this.estilo = res;
	return res;
}

cColumn.prototype.ArmarEstiloActivoObj = function( obj ) {
	if( this.anchomin != "" ){
		obj.css( "min-width:", this.anchomin );
	}
	if( this.ancho != "" ){
		obj.css( "width:", this.ancho );
	}	
	if( this.altomin != "" ){
		obj.css( "min-height:", this.altomin );
	}	
	if( this.alto != "" ){
		obj.css( "height:", this.alto );
	}	
	if( this.cfloat != "" ){
		obj.css( "float:", this.cfloat );
	}
	if( this.cclear != "" ){
		obj.css( "clear:", this.cclear );
	}
	if( this.bgcoloract != "" ){
		obj.css( "background-color:", this.bgcoloract );
	}
	if( this.fgcoloract != "" ){
		obj.css( "color:"+this.fgcoloract );
	}
	this.DetalleError = "";
	return true;
}
cColumn.prototype.ArmarEstiloActivo = function() {
	var res="";
	// res += "float:left;";
	if( this.anchomin != "" ){
		res += "min-width:"+this.anchomin+";";
	}
	if( this.ancho != "" ){
		res += "width:"+this.ancho+";";
	}	
	if( this.altomin != "" ){
		res += "min-height:"+this.altomin+";";
	}	
	if( this.alto != "" ){
		res += "height:"+this.alto+";";
	}	
	// if( this.estiloact != "" ){
		// res += this.estiloact;
	// }	
	if( this.cfloat != "" ){
		res += "float:"+this.cfloat+";";
	}
	if( this.cclear != "" ){
		res += "clear:"+this.cclear+";";
	}
	if( this.bgcoloract != "" ){
		res += "background-color:"+this.bgcoloract+";";
	}
	if( this.fgcoloract != "" ){
		res += "color:"+this.fgcoloract+";";
	}
	
	this.DetalleError = "";
	
	// this.estilo = res;
	return res;
}