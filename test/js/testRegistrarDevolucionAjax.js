// testRegistrarDevolucionAjax.js
test( "Registrar Devolucion AJAX", function() {

	fecha = "01-11-2014";
	cliente = "001";
	producto = "001";
	esperado = "true";
	resultado = RegistrarDevolucion( fecha, cliente, producto, 100 );
	strictEqual( resultado, esperado, "001" );

	

});
