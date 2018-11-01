<!doctype html>
<html lang="es">
  <head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <!-- CSS -->
    <link rel="stylesheet" type="text/css" href="css/bootstrap.min.css">
    <link rel="stylesheet" type="text/css" href="css/statistics.css">
    <link rel="icon" type="image/png" href="favicon.png">
    <title>Estadística - Resultados</title>
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
        <div class="row">
          <div class="col-md-12">
<?php
  if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  $cont = 0;
  $archivo_csv="a";
  $directorio = opendir("uploads"); 
  while ($archivo = readdir($directorio)) {
    //verificamos si es o no un directorio
    if (is_dir($archivo)) {
      // no hacemos nada
    }
    else {
      $archivo_csv = "uploads/".$archivo;
      $cont++;
    }
  }
  $arr_nombres = array();
  $arr_datos = array();
  $mapa = array();
  $cant = 0;
  if( $cont==1 ) {
    // si el archivo se abrio correctamente
    if (($gestor = fopen($archivo_csv, "r")) !== FALSE) {
      $it = 0;
      while (($datos = fgetcsv($gestor, 1000, ",")) !== FALSE) {
          if( $it!=0 ) {
            $arr_nombres[] = $datos[0];
            $arr_datos[] = $datos[1];
            $cant++;            
          }
          $it++;
      }
      for ($i=0; $i<$cant; $i++ ) {
        $nombre = $arr_nombres[$i];
        $dato = $arr_datos[$i];
        $mapa[$nombre] = $dato;
      }
      fclose($gestor);
    }
    echo "<h2 class=\"justify-content-cente\">Detalles de los datos</h2>\n";
    echo "<h3>Datos originales</h3>\n";    
    echo "[ ";
    foreach ($mapa as $key => $value) {
      echo $key."=>".$value.", ";
    }
    echo " ]";
    asort($mapa);
    echo "<h3>Datos ordenados</h3>\n";
    echo "[ ";
    foreach ($mapa as $key => $value) {
      echo $key."=>".$value.", ";
    }
    echo " ]";    

    echo   "</div>
        </div>
      <hr>
      <div class=\"row\">
        <div class=\"col-md-12\">
          <h2>Medidas de tendencia central</h2>";

        $suma = 0;
        for( $i=0; $i<count($arr_datos); $i++ ) {
            $suma += $arr_datos[$i]; 
        }
        $media = $suma/count($arr_datos);
        echo "MEDIA = ".number_format($media, 2, '.', '')."<br>";

        sort($arr_datos);
        $count = count($arr_datos); 
        $middleval = floor(($count-1)/2); 
        if($count % 2) {
          $mediana = $arr_datos[$middleval];
        } else { 
          $low = $arr_datos[$middleval];
          $high = $arr_datos[$middleval+1];
          $mediana = (($low+$high)/2);
        }
        echo "MEDIANA = ".$mediana."<br>";
    
        $vall = 0;
        $cont_new = 0;
        $moda ="";
        $nuevo_array = array_count_values($arr_datos);
        arsort($nuevo_array);
        foreach ($nuevo_array as $key => $value) {
          $cont_new++;
          if($value < $vall){
            break;
          }
          else{
            $moda = $moda.$key;
            if($cont_new < $cant-1){
              $moda = $moda;
            } 
            $vall = $value;
          }
        }
        echo "MODA = ".$moda.", con frecuencia = ".$cont_new;
        echo "<br><br>";
        if( $media<$mediana ) {
          echo "<p>Notamos que la media es menor a la mediana, por lo tanto la distribución de los datos es asimétrica con cola a la izquierda (sesgada a la izquierda)</p>";
        }
        elseif($media>$mediana) {
            echo "<p>Aquí la media es mayor a la mediana, por tanto, la distribución es asimétrica con cola a la
derecha (sesgada a la derecha)</p>";
        }
        else {
          echo "<p>La distribución es simétrica.</p>";
        }

    echo   "</div>
        </div>
      <hr>
      <div class=\"row\">
        <div class=\"col-md-12\">
          <h2>Medidas de dispersión</h2>";
        $sum_var = 0;
        for( $i=0; $i<count($arr_datos); $i++ ) {
            $sum_var += ($arr_datos[$i]-$media)*($arr_datos[$i]-$media);
        }
        $varianza = $sum_var/(count($arr_datos)-1);
        echo "VARIANZA = ".number_format($varianza, 2, '.', '')."<br>";
        $desviacion = sqrt($varianza);
        echo "DESVIACIÓN ESTÁNDAR = ".number_format($desviacion, 2, '.', '')."<br>";
        $min = $arr_datos[0];
        $max = $arr_datos[$cant-1];
        $rango = $max-$min;
        echo "RANGO = ".$rango;

    echo   "</div>
        </div>
      <hr>
      <div class=\"row\">
        <div class=\"col-md-12\">
          <h2>Box-plot</h2>";
    echo "<div id=\"div-box-plot\"></div>";

    echo   "</div>
        </div>
      <hr>
      <div class=\"row\">
        <div class=\"col-md-12\">
          <h2>Histograma</h2>";
    echo "<div id=\"div-histogram\"></div>";

}
  else {
    echo "<h3>Algo salió mal, por favor vuelva a intentarlo</h3>";
  }
}

?>
        </div>
      </div>
			</div>
		</main>


    <!-- JavaScript -->
    <script src="js/jquery-3.3.1.min.js"></script>
    <script src="js/popper.min.js"></script>
    <script src="js/bootstrap.min.js"></script>
    <!-- Plotly.js -->
    <script src="https://cdn.plot.ly/plotly-latest.min.js"></script>
    <script>
      <?php
      $js_array = json_encode($arr_datos);
      echo "var arr_javascript = ". $js_array . ";\n";
      
      ?>

      var trace1 = {
        x: arr_javascript,
        type: 'box',
        name: 'Set 1'
      };

      var data = [trace1];
      var layout = {
        title: 'Box Plot'
      };
      Plotly.newPlot('div-box-plot', data, layout);

      var trace2 = {
          x: arr_javascript,
          type: 'histogram',
        };
      var data2 = [trace2];
      Plotly.newPlot('div-histogram', data2);

    </script>
  </body>
</html>