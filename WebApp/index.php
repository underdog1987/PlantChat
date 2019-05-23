<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">
    <meta name="description" content="Plant Chat PoC">
    <meta name="author" content="@underdog1987">

    <title>🌱🌱 Plant Chat 🌱🌱</title>

    <!-- Bootstrap Core CSS -->
    <link href="bootstrap/bower_components/bootstrap/dist/css/bootstrap.min.css" rel="stylesheet">

    <!-- MetisMenu CSS -->
    <link href="bootstrap/bower_components/metisMenu/dist/metisMenu.min.css" rel="stylesheet">

    <!-- Timeline CSS -->
    <link href="bootstrap/dist/css/timeline.css" rel="stylesheet">

    <!-- Custom CSS -->
    <link href="bootstrap/dist/css/sb-admin-2.css" rel="stylesheet">

    <!-- Morris Charts CSS -->
    <link href="bootstrap/bower_components/morrisjs/morris.css" rel="stylesheet">

    <!-- Custom Fonts -->
    <link href="bootstrap/bower_components/font-awesome/css/font-awesome.min.css" rel="stylesheet" type="text/css">

    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
        <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
        <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
    <![endif]-->

	<link rel="author" type="./info/humans.txt" />
    <meta name="apple-mobile-web-app-capable" content="yes" />
    <meta name="apple-mobile-web-app-status-bar-style" content="black-translucent" />
    <link rel="apple-touch-startup-image" href="./external/startup.png">
    <link rel="apple-touch-icon" href="./external/apple.png" />
    <link rel="shortcut icon" type="image/png" href="./external/favicon.png" />
    <link rel="shortcut icon" type="image/x-icon" href="./external/favicon.ico" />


    <style>
		#messageArea{
			overflow-x:hidden;
			overflow-y:auto;
			max-height:500px;
		}
	</style>
    </head>
</head>

<body>

    <div id="wrapper">

        <!-- Navigation -->
        <nav class="navbar navbar-default navbar-static-top" role="navigation" style="margin-bottom: 0">
            <div class="navbar-header">
                <a class="navbar-brand" href="#">🌱 Plant Chat 🌱</a>
            </div>
        </nav>

        <div id="page-wrapper">
            <div class="row">
            	<div class="col-lg-2">&nbsp;</div>
                <div class="col-lg-8">
                    <div class="panel panel-default">
                        <div class="panel-heading">
                            <i class="fa fa-clock-o fa-fw"></i> Últimos Mensajes
                        </div>
                        <div class="panel-body">
                        	<div id="messageArea">
                                <ul class="timeline" id="losMensajes"></ul>
                            </div>
                        </div>
                    </div>
                </div>
            	<div class="col-lg-2">&nbsp;</div>
            </div>

        </div>


    </div>


    <!-- jQuery -->
    <script src="bootstrap/bower_components/jquery/dist/jquery.min.js"></script>

    <!-- Bootstrap Core JavaScript -->
    <script src="bootstrap/bower_components/bootstrap/dist/js/bootstrap.min.js"></script>

    <!-- Metis Menu Plugin JavaScript -->
    <script src="bootstrap/bower_components/metisMenu/dist/metisMenu.min.js"></script>

    <!-- Custom Theme JavaScript -->
    <script src="bootstrap/dist/js/sb-admin-2.js"></script>
    
    <script>
function reloadMessages(){
			// Get messages via ajax
			$.ajax({
				dataType: "json",
				type:"POST",
				url: "controller.php?c=getmessagesweb",
				async:true,
				success: function(json){
					try{
						if(json.mensajes){
							$('#losMensajes').html('');
							mensajes=json.mensajes;
							//console.log(mensajes.length);
							sender="";
							klass='class="timeline-inverted"'; //
							for(p=0;p<mensajes.length;p++){
								cha=mensajes[p];

								changeclass=(cha.from!=sender);
								showsender=(cha.from!=sender);
								
								sender=cha.from;
								
								respondiendo=cha.replyingTo==""?"":" en respuesta a " + cha.replyingTo;
								
								if(changeclass){
									c=klass==""?'class="timeline-inverted"':'';
									klass=c==""?'':'class="timeline-inverted"';
								}

								h='<li '+klass+'><div class="timeline-badge success"><i class="fa fa-leaf"></i></div><div class="timeline-panel"><div class="timeline-heading"><h4 class="timeline-title">'+cha.from+'</h4><p><small class="text-muted"><i class="fa fa-clock-o"></i> '+cha.fhMensaje+' ' + respondiendo + '</small></p></div><div class="timeline-body"><p>'+cha.mensaje+'</p></div></div></li>';
								$('#losMensajes').append(h);
							}
							document.getElementById('messageArea').scrollTop=document.getElementById('messageArea').scrollHeight;
						}else{
							alert("Error");
						}
					}catch(e){
						alert(e);
					}
				},
				error:function (xhr, ajaxOptions, thrownError){
					alert("Ocurrió un error al procesar la solicitud. ("+thrownError+")");
				}
			});
		}
		$(document).ready(function() { 
			reloadMessages();
			window.setInterval(function(){reloadMessages()},5000);
		 });
	</script>

</body>

</html>
