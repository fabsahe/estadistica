<?php 
// Antes de empezar, limpiamos la carpetas de archivos subidos
$directorio = opendir("uploads"); 
while ($archivo = readdir($directorio)) {
  //verificamos si es o no un directorio
  if (is_dir($archivo)) {
      // no hacemos nada
  }
  else {
      unlink("uploads/".$archivo); // eliminamos el archivo
  }
}
?>
<!doctype html>
<html lang="es">
  <head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <!-- CSS -->
    <link rel="stylesheet" type="text/css" href="css/bootstrap.min.css">
    <link rel="stylesheet" type="text/css" href="css/dropzone.css">
    <link rel="stylesheet" type="text/css" href="css/statistics.css">
    <link rel="icon" type="image/png" href="favicon.png">
    <title>Estadística</title>
  </head>
  <body>

    <header>
      <div class="navbar navbar-dark bg-greenfab shadow-sm">
        <div class="container d-flex justify-content-between">
          <a href="index.php" class="navbar-brand d-flex align-items-center">
            Estadística
          </a>
        </div>
      </div>
    </header>

		<main role="main">
			<div class="container">
				<div class="upload">
					<form action="upload.php" class="dropzone" id="dropzoneForCsv">
					</form>
			  </div>

        <div class="row">
          <div id="btn-calc" class="col-12 text-center">
            <form action="calc.php" method="post">
              <button class="btn btn-success">Calcular</button>
            </form>
          </div>
        </div>

        <p id="info"></p>

			</div>
		</main>


    <!-- JavaScript -->
    <script src="js/jquery-3.3.1.min.js"></script>
    <script src="js/popper.min.js"></script>
    <script src="js/bootstrap.min.js"></script>
    <script src="js/dropzone.js"></script>
    <script>
    	Dropzone.options.dropzoneForCsv = {
  			paramName: "file", 
  			maxFilesize: 2, // MB
  			maxFiles: 1, // Solo se puede subir un archivo
  			acceptedFiles: ".csv", // Solo acepta archivos csv
  			dictDefaultMessage: "Arrastre su archivo csv aquí, o haga click para buscarlo",
        dictInvalidFileType: "Este tipo de archivo no es válido",
        dictMaxFilesExceeded: "Sólo puedes subir un archivo",
        success: function(file) {
          $( "#btn-calc" ).fadeIn( "slow" );
        },
        maxfilesexceeded: function() {
          this.disable();
        }
			};
		</script>
  </body>
</html>