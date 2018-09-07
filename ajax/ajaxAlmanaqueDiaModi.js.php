<?php
/* 
** la idea del sscript como php es que se puede incorporar codigo php
** y recibir parametros tipo GET durante su carga 
** (ejemplo, variables del php que estan fuera del alcance de este fuente).
**
*/

// la linea que sigue esta simplemente para trampear al NotePad++
?>
// <script> 

function Setup(){
	var lista;
	var valores = [];
	lista = $(".inputText");
	
	<?php 	/* tomar lista de valores.	*/
	?>
	$(lista).each( function( idx ){
		valores.push( $(this).attr("value") );
	} );

	$(".inputText").keydown( function( data ) {
		var focused = $(":focus");
		var idx = lista.index( this );

		if( data.key == "ArrowUp"  ) {
			if( idx > 0 ){
				var ant = lista[ idx - 1 ];
				$(ant).focusEnd();
				$(ant).select();
			}
		}

		if( data.which == 13 ) {
			var nombre = focused.attr("name");
			var ori;
			var nuevo;
			var pak;
			ori = focused.attr( "value" );
			nuevo = focused.val();
			if( ori != nuevo ){
				// alert( ori +" "+nuevo );
				pak = periodo + codcli + codprod;
				pak = pak + nombre;
				pak = pak + PadN( nuevo, 6 );
				var este = { "href": pak  }
				if( MandarAjax( "/ajax/ajaxAlmanaqueDiaModi.php", este ) ){
					focused.attr( "value", nuevo )
				}
			}
			if( idx < lista.length - 1 ){
				var prox = lista[ idx + 1 ];
				$(prox).focusEnd();
				$(prox).select();
			}

			return false;
		}
		
		if( data.key == "ArrowDown" ){
			if( idx < lista.length - 1 ){
				var prox = lista[ idx + 1 ];
					$(prox).focusEnd();
					$(prox).select();
			}
		}
		

	} ); // fin KeyDown

} // fin Setup


