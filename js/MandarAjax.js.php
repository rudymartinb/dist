// <script>
function MandarAjax(ajax, datos){
	var resultado;
	$.ajax({
		url: ajax,
		type: "POST",
		data: datos ,
		async: false,
		success: function( data ) {
			resultado = data ;
		}
	});	
	return resultado;
}

