<!doctype html>
<html lang="es">
<head>
<meta charset="utf-8">
<title>jQuery UI Datepicker - Default functionality</title>
<link rel="stylesheet" href="//code.jquery.com/ui/1.11.0/themes/smoothness/jquery-ui.css">
<script src="//code.jquery.com/jquery-1.10.2.js"></script>
<script src="//code.jquery.com/ui/1.11.0/jquery-ui.js"></script>


 
<script>
$(function() {
$( "#datepicker" ).datepicker( $.datepicker.regional[ "es" ]);
});
</script>
</head>
<body>
<p>Date: <input type="text" id="datepicker"></p>
</body>
</html>