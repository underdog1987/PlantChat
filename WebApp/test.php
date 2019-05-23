<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Documento sin título</title>
<script src="https://code.jquery.com/jquery-3.3.1.js" integrity="sha256-2Kok7MbOyxpgUVvAk/HJ2jigOSYS2auK4Pfzbm7uH60=" crossorigin="anonymous"></script>
</head>

<body>
</body>
<script>
$.ajax({
	type: 'POST',
	url: './',
	data: '{"id":"1", "nombre":"pepe le pu", "edad":"19", "casado":false}',
	contentType: "application/json; charset=utf-8",
	traditional:true,
	dataType: 'json',
	success: function(data){
		console.log(data);	
	}
});
</script>
</html>
