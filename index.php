<!DOCTYPE html>
<html lang="ca">
  <head>
	<meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link href="css/bootstrap.min.css" rel="stylesheet">    
    <script>  
        function getIdioma(){
        var idioma= 'val',
        language = window.navigator.userLanguage || window.navigator.language;
        if (language.search('es-')!=-1)
          idioma='cas';
        return idioma;
        }
  
    </script>
    </head>
    
    
<body onLoad="carregaInicial('container','contenedorEstructura',getIdioma())">

  <div class='container'><hr/></div>
  <div id='contenedorEstructura'></div>
  <script src="js/jquery.min.js"></script>    
 <script src="js/bootstrap.min.js"></script>
 <script src="js/bootstrap-dialog.js"></script>  
 <script src="js/lliurex-downloader.js"></script>  
</body>
</html>