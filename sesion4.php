<?php
include_once("config.php");
if (!isset($_SESSION)) {
  session_start();
}
include_once("functions.php");
if (!func::checkLoginState($dbh)) {
  echo '<script language="javascript">window.location="login.php"</script>';
}
?>

<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="'.$id.'_viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="'.$id.'_theme-color" content="#000000">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.1.0/css/bootstrap.min.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.0/umd/popper.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.1.0/js/bootstrap.min.js"></script>
    <link href="https://fonts.googleapis.com/css?family=Kanit" rel="stylesheet">
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.3.1/css/all.css" integrity="sha384-mzrmE5qonljUremFsqc01SB46JvROS7bZs3IO2EmfFsd15uHvIt+Y8vEf7N7fWAU" crossorigin="anonymous">
    <link rel="stylesheet" type="text/css" href="styles/sesion2.css">
    <title>Proyecto Psicologia</title>
    <style>
/* Use overflow:scroll on your container to enable scrolling: */

.tb-container {
  max-width: 100%;
  max-height: 700px;
  overflow: scroll;
}


/* Use position: sticky to have it stick to the edge
 * and top, right, or left to choose which edge to stick to: */

thead th {
  position: sticky;
  top: 0;
}

tbody th {
  position: sticky;
  left: 0;
}


/* To have the header in the first column stick to the left: */

thead th:first-child {
  left: 0;
  z-index: 1;
}


/* Just to display it nicely: */

thead th {
    background-color: #4CAF50;
    color: white;
}

tbody th {
  background: #FFF;
  border-right: 1px solid #CCC;
}

table {
  border-collapse: collapse;
}

td,
th {
  padding: 0.5em;
}
</style>
</head>
<body>
    <?php
    $query = ' SELECT * FROM estudiantes WHERE grupo_id = ? ';
    $stmt = $dbh->prepare($query);
    $stmt->execute([$_SESSION['grupo_id']]);
    $rows = $stmt->fetchAll(PDO::FETCH_ASSOC);
    $est = [];
    foreach ($rows as $row) {
      $id = $row['id'];
      $query = ' SELECT * FROM sesion_4 WHERE id_estudiante = ? ';
      $stmt = $dbh->prepare($query);
      $stmt->execute([$id]);
      $s = $stmt->fetch(PDO::FETCH_ASSOC);
      $est[$id] = $s;
    }

    if ($_SERVER["REQUEST_METHOD"] == "POST") {



      if (isset($_POST['informe_grupo'])) {
        $originales = array("'", '"');
        $correctos = array("\'", '\"');
        $_POST['inf_s3'] = str_replace($originales, $correctos, $_POST['inf_s3']);

        $query = 'UPDATE `grupo` SET `inf_s3` = "' . $_POST['inf_s3'] . '" WHERE `grupo`.`id` = ' . $_SESSION['grupo_id'] . '; ';
        $dbh->beginTransaction();
        $stmt = $dbh->prepare($query);
        $stmt->execute();
        $dbh->commit();
        echo '<script language="javascript">';
        echo 'alert("Guardado correctamente")';
        echo '</script>';
        echo '<script language="javascript">window.location="sesion4.php"</script>';
      } else {
        $arr = ["id_estudiante", "item_1", "item_2", "item_3", "item_4", "item_5", "item_6", "item_7", "item_8", "item_9", "item_10", "item_11", "item_12", "zona_riesgo", "zona_segura", "zona_ayuda", "per_ayudan", "mec_violencia", "per_violencia", "vio_vividas", "zon_violencia", "cantidad_cigarrillos", "frecuencia_cigarrillos", "lugar_cigarrillos", "cantidad_alcohol", "frecuencia_alcohol", "lugar_alcohol", "cantidad_psicoactivas", "frecuencia_psicoactivas", "lugar_psicoactivas", "n_parejas", "met_embarazo", "n_embarazo", "n_abortos", "pre_relacion_f", "ets", "calle", "observaciones"];
        $originales = array("'", '"');
        $correctos = array("\'", '\"');
        foreach ($rows as $row) {
          $id = $row['id'];

          if (isset($_POST[$id . '_id_ses'])) {
            $query = 'UPDATE `sesion_4` SET';

            for ($i = 1; $i < 13; $i++) {
              $query .= '`' . $arr[$i] . '` = ' . $_POST[$id . '_' . $arr[$i]] . ',';
              $est[$id][$i] = $_POST[$id . '_' . $arr[$i]];
            }
            for ($i = 13; $i < 37; $i++) {
              $_POST[$id . '_' . $arr[$i]] = str_replace($originales, $correctos, $_POST[$id . '_' . $arr[$i]]);
              $query .= '`' . $arr[$i] . '` = "' . $_POST[$id . '_' . $arr[$i]] . '",';
              $est[$id][$i] = $_POST[$id . '_' . $arr[$i]];
            }

            $_POST[$id . '_' . $arr[37]] = str_replace($originales, $correctos, $_POST[$id . '_' . $arr[37]]);
            $query .= '`' . $arr[37] . '` = "' . $_POST[$id . '_' . $arr[37]] . '"';
            $est[$id][37] = $_POST[$id . '_' . $arr[37]];

            $query .= ' WHERE id_estudiante=' . $id . ' ';
            $dbh->beginTransaction();
            try {
              $stmt = $dbh->prepare($query);
              $stmt->execute();
              $dbh->commit();

            } catch (Exception $e) {
              $dbh->rollBack();
              echo $query;
              echo '<script language="javascript">';
              echo 'alert("Erro al guardar intente nuevamente")';
              echo '</script>';
              //echo '<script language="javascript">window.location="sesion4.php"</script>';
            }


          } else {
            $query = 'INSERT INTO `sesion_4`(`id_estudiante`, `item_1`, `item_2`, `item_3`, `item_4`, `item_5`, `item_6`, `item_7`, `item_8`, `item_9`, `item_10`, `item_11`, `item_12`, `zona_riesgo`, `zona_segura`, `zona_ayuda`, `per_ayudan`, `mec_violencia`, `per_violencia`, `vio_vividas`, `zon_violencia`, `cantidad_cigarrillos`, `frecuencia_cigarrillos`, `lugar_cigarrillos`, `cantidad_alcohol`, `frecuencia_alcohol`, `lugar_alcohol`, `cantidad_psicoactivas`, `frecuencia_psicoactivas`, `lugar_psicoactivas`, `n_parejas`, `met_embarazo`, `n_embarazo`, `n_abortos`, `pre_relacion_f`, `ets`, `calle`, `observaciones`) VALUES(';


            for ($i = 0; $i < 13; $i++) {
              $query .= $_POST[$id . '_' . $arr[$i]] . ',';
              $est[$id][$i] = $_POST[$id . '_' . $arr[$i]];
            }

            for ($i = 13; $i < 37; $i++) {
              $_POST[$id . '_' . $arr[$i]] = str_replace($originales, $correctos, $_POST[$id . '_' . $arr[$i]]);
              $query .= '"' . $_POST[$id . '_' . $arr[$i]] . '",';
              $est[$id][$i] = $_POST[$id . '_' . $arr[$i]];
            }
            $_POST[$id . '_' . $arr[37]] = str_replace($originales, $correctos, $_POST[$id . '_' . $arr[37]]);
            $query .= '"' . $_POST[$id . '_' . $arr[37]] . '")';
            $est[$id][37] = $_POST[$id . '_' . $arr[37]];

            $est[$id]['id_estudiante'] = $id;

            $dbh->beginTransaction();
            try {
              $stmt = $dbh->prepare($query);
              $stmt->execute();
              $dbh->commit();

            } catch (Exception $e) {
              $dbh->rollBack();
              echo '<script language="javascript">';
              echo 'alert("Erro al guardar intente nuevamente")';
              echo '</script>';
            }
          }
        }
      }
      echo '<script language="javascript">';
      echo 'alert("Guardado correctamente")';
      echo '</script>';
      echo '<script language="javascript">window.location="sesion4.php"</script>';
    }
    ?>

    <form id="form1" method="post" action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>"></form>


    <div class="tb-container">
    <table class="table" style="float: left;" >
    <thead>
    <tr class="titles">
    <th>Nombre</th>
    <th>item 1 </th>
    <th>item 2 </th>
    <th>item 3 </th>
    <th>item 4 </th>
    <th>item 5 </th>
    <th>item 6 </th>
    <th>item 7 </th>
    <th>item 8 </th>
    <th>item 9 </th>
    <th>item 10 </th>
    <th>item 11 </th>
    <th>item 12 </th>

    <th>Amigos </th>
    <th>Familia </th>
    <th>Otro significativo </th>
    <th>Puntaje total </th>
    <th>Zonas de riesgo </th>
    <th>Zonas seguras  </th>
    <th>Zonas de ayuda </th>
    <th>Personas que ayudan </th>
    <th>Mecanismo utilizados de violencia </th>
    <th>Personas que ejercen la violencia </th>
    <th>Violencias vividas </th>
    <th>Zonas de violencia </th>
    <th>Cantidad  cigarrillos consumidos </th>
    <th>Frecuencia de consumo de cigarrillo </th>
    <th>Lugar de consumo de cigarrillo </th>
    <th>Cantidad  alcohol consumidos </th>
    <th>Frecuencia de consumo de alcohol </th>
    <th>Lugar de consumo de alcohol </th>
    <th>Cantidad  sustancias psicoactivas consumidos </th>
    <th>Frecuencia de consumo de sustancias psicoactivas </th>
    <th>Lugar de consumo de sustancias psicoactivas </th>
    <th>No. de parejas </th>
    <th>métodos para evitar el embarazo </th>
    <th>No. de embarazos </th>
    <th>No. de abortos </th>
    <th>Presencia de relaciones forzadas y número </th>
    <th>Diagnóstico de enfermedad de transmisión sexual </th>
    <th>Si ha vivido en la calle </th>
    <th>Observaciones </th>
    <th>Mapas hablantes </th>



    <!--<th>GUARDAR</th>-->
    </tr>
    </thead>
    <tbody>
    <?php
    foreach ($rows as $row) {
      $id = $row['id'];
      $s = $est[$id];
      $pregunta = 1;
      echo ' <tr>
                <th> ' . $row['nombre'] . ' </th> ';
        //si no esta creado se crean los espacios
      if (!isset($s['id_estudiante'])) {

        //echo ' <form method = "post" action = "' . htmlspecialchars($_SERVER["PHP_SELF"]) . '" id="form_' . $id . '" >';

        for ($i = 0; $i < 12; $i++) {
            // code...
          echo '<td><input type="number" name="' . $id . '_item_' . ($i + 1) . '" value="0" form="form1"/></td>';
        }

        echo '<td> 0 </td>';
        echo '<td> 0 </td>';
        echo '<td> 0 </td>';
        echo '<td> 0 </td>';

        echo '<td><textarea rows="4" cols="40" name="' . $id . '_zona_riesgo" form="form1"></textarea></td>';
        echo '<td><textarea rows="4" cols="40" name="' . $id . '_zona_segura" form="form1"></textarea></td>';
        echo '<td><textarea rows="4" cols="40" name="' . $id . '_zona_ayuda" form="form1"></textarea></td>';
        echo '<td><textarea rows="4" cols="40" name="' . $id . '_per_ayudan" form="form1"></textarea></td>';
        echo '<td><textarea rows="4" cols="40" name="' . $id . '_mec_violencia" form="form1"></textarea></td>';
        echo '<td><textarea rows="4" cols="40" name="' . $id . '_per_violencia" form="form1"></textarea></td>';
        echo '<td><textarea rows="4" cols="40" name="' . $id . '_vio_vividas" form="form1"></textarea></td>';
        echo '<td><textarea rows="4" cols="40" name="' . $id . '_zon_violencia" form="form1"></textarea></td>';
        echo '<td><textarea rows="4" cols="40" name="' . $id . '_cantidad_cigarrillos" form="form1"></textarea></td>';
        echo '<td><textarea rows="4" cols="40" name="' . $id . '_frecuencia_cigarrillos" form="form1"></textarea></td>';
        echo '<td><textarea rows="4" cols="40" name="' . $id . '_lugar_cigarrillos" form="form1"></textarea></td>';
        echo '<td><textarea rows="4" cols="40" name="' . $id . '_cantidad_alcohol" form="form1"></textarea></td>';
        echo '<td><textarea rows="4" cols="40" name="' . $id . '_frecuencia_alcohol" form="form1"></textarea></td>';
        echo '<td><textarea rows="4" cols="40" name="' . $id . '_lugar_alcohol" form="form1"></textarea></td>';
        echo '<td><textarea rows="4" cols="40" name="' . $id . '_cantidad_psicoactivas" form="form1"></textarea></td>';
        echo '<td><textarea rows="4" cols="40" name="' . $id . '_frecuencia_psicoactivas" form="form1"></textarea></td>';
        echo '<td><textarea rows="4" cols="40" name="' . $id . '_lugar_psicoactivas" form="form1"></textarea></td>';
        echo '<td><textarea rows="4" cols="40" name="' . $id . '_n_parejas" form="form1"></textarea></td>';
        echo '<td><textarea rows="4" cols="40" name="' . $id . '_met_embarazo" form="form1"></textarea></td>';
        echo '<td><textarea rows="4" cols="40" name="' . $id . '_n_embarazo" form="form1"></textarea></td>';
        echo '<td><textarea rows="4" cols="40" name="' . $id . '_n_abortos" form="form1"></textarea></td>';
        echo '<td><textarea rows="4" cols="40" name="' . $id . '_pre_relacion_f" form="form1"></textarea></td>';
        echo '<td><textarea rows="4" cols="40" name="' . $id . '_ets" form="form1"></textarea></td>';
        echo '<td><textarea rows="4" cols="40" name="' . $id . '_calle" form="form1"></textarea></td>';
        echo '<td><textarea rows="4" cols="40" name="' . $id . '_observaciones" form="form1"></textarea></td>';




        echo '<input type="hidden" name="' . $id . '_id_estudiante" value="' . $id . '" form="form1"/>';
        //echo '<td><input  class="button" type="submit" value="Guardar"/></td>';
        //echo ' </form>';

      } else {

       // echo '<form method = "post" action = "' . htmlspecialchars($_SERVER["PHP_SELF"]) . '" id="form_' . $id . '" >';

        $total = 0;
        $amigos = 0;
        $familia = 0;
        $otros = 0;

        for ($i = 1; $i <= 12; $i++) {
          $total += $s["item_" . $i];
          if ($i == 3 or $i == 4 or $i == 8 or $i == 11) {
            $familia += $s["item_" . $i];
          }
          if ($i == 6 or $i == 7 or $i == 9 or $i == 12) {
            $amigos += $s["item_" . $i];
          }
          if ($i == 1 or $i == 2 or $i == 5 or $i == 10) {
            $otros += $s["item_" . $i];
          }
          echo '<td><input type="number" name="' . $id . '_item_' . $i . '" value="' . $s["item_" . $i] . '" form="form1"/></td>';
        }
        echo '<td>' . ($amigos / 4) . '</td>';
        echo '<td>' . ($familia / 4) . '</td>';
        echo '<td>' . ($otros / 4) . '</td>';
        echo '<td>' . ($total / 12) . '</td>';

        echo '<td><textarea rows="4" cols="40" name="' . $id . '_zona_riesgo"              form="form1">' . $s["zona_riesgo"] . '</textarea></td>';
        echo '<td><textarea rows="4" cols="40" name="' . $id . '_zona_segura"              form="form1">' . $s["zona_segura"] . '</textarea></td>';
        echo '<td><textarea rows="4" cols="40" name="' . $id . '_zona_ayuda"               form="form1">' . $s["zona_ayuda"] . '</textarea></td>';
        echo '<td><textarea rows="4" cols="40" name="' . $id . '_per_ayudan"               form="form1">' . $s["per_ayudan"] . '</textarea></td>';
        echo '<td><textarea rows="4" cols="40" name="' . $id . '_mec_violencia"            form="form1">' . $s["mec_violencia"] . '</textarea></td>';
        echo '<td><textarea rows="4" cols="40" name="' . $id . '_per_violencia"            form="form1">' . $s["per_violencia"] . '</textarea></td>';
        echo '<td><textarea rows="4" cols="40" name="' . $id . '_vio_vividas"              form="form1">' . $s["vio_vividas"] . '</textarea></td>';
        echo '<td><textarea rows="4" cols="40" name="' . $id . '_zon_violencia"            form="form1">' . $s["zon_violencia"] . '</textarea></td>';
        echo '<td><textarea rows="4" cols="40" name="' . $id . '_cantidad_cigarrillos"     form="form1">' . $s["cantidad_cigarrillos"] . '</textarea></td>';
        echo '<td><textarea rows="4" cols="40" name="' . $id . '_frecuencia_cigarrillos"   form="form1">' . $s["frecuencia_cigarrillos"] . '</textarea></td>';
        echo '<td><textarea rows="4" cols="40" name="' . $id . '_lugar_cigarrillos"        form="form1">' . $s["lugar_cigarrillos"] . '</textarea></td>';
        echo '<td><textarea rows="4" cols="40" name="' . $id . '_cantidad_alcohol"         form="form1">' . $s["cantidad_alcohol"] . '</textarea></td>';
        echo '<td><textarea rows="4" cols="40" name="' . $id . '_frecuencia_alcohol"       form="form1">' . $s["frecuencia_alcohol"] . '</textarea></td>';
        echo '<td><textarea rows="4" cols="40" name="' . $id . '_lugar_alcohol"            form="form1">' . $s["lugar_alcohol"] . '</textarea></td>';
        echo '<td><textarea rows="4" cols="40" name="' . $id . '_cantidad_psicoactivas"    form="form1">' . $s["cantidad_psicoactivas"] . '</textarea></td>';
        echo '<td><textarea rows="4" cols="40" name="' . $id . '_frecuencia_psicoactivas"  form="form1">' . $s["frecuencia_psicoactivas"] . '</textarea></td>';
        echo '<td><textarea rows="4" cols="40" name="' . $id . '_lugar_psicoactivas"       form="form1">' . $s["lugar_psicoactivas"] . '</textarea></td>';
        echo '<td><textarea rows="4" cols="40" name="' . $id . '_n_parejas"                form="form1">' . $s["n_parejas"] . '</textarea></td>';
        echo '<td><textarea rows="4" cols="40" name="' . $id . '_met_embarazo"             form="form1">' . $s["met_embarazo"] . '</textarea></td>';
        echo '<td><textarea rows="4" cols="40" name="' . $id . '_n_embarazo"               form="form1">' . $s["n_embarazo"] . '</textarea></td>';
        echo '<td><textarea rows="4" cols="40" name="' . $id . '_n_abortos"                form="form1">' . $s["n_abortos"] . '</textarea></td>';
        echo '<td><textarea rows="4" cols="40" name="' . $id . '_pre_relacion_f"           form="form1">' . $s["pre_relacion_f"] . '</textarea></td>';
        echo '<td><textarea rows="4" cols="40" name="' . $id . '_ets"                      form="form1">' . $s["ets"] . '</textarea></td>';
        echo '<td><textarea rows="4" cols="40" name="' . $id . '_calle"                    form="form1">' . $s["calle"] . '</textarea></td>';
        echo '<td><textarea rows="4" cols="40" name="' . $id . '_observaciones"                    form="form1">' . $s["observaciones"] . '</textarea></td>';



        echo '<input type="hidden" name="' . $id . '_id_ses" value="' . $s['id_estudiante'] . '" form="form1"/>';
        //echo '<td><input  class="button" type="submit" value="Guardar"/></td>';
        //echo ' </form>';


      }



      echo '<td>';
      $path = 'uploads/sesion4/' . $row['id'];
      if (glob($path . '.*')) {
        $arr = glob($path . '.*');
        echo '<a href="' . $arr[0] . '">Ver archivo</a>';

      }
      echo '
                      <form action="upload.php" method="post" enctype="multipart/form-data">
                          Select image to upload:
                          <input type="hidden" name="Sesion4" value="Sesion4" />
                          <input type="hidden" name="redirect" value="sesion4" />
                          <input type="hidden" name="image_id" value="' . $row['id'] . '" />
                          <input class="fileToUpload" type="file" name="fileToUpload" id="fileToUpload">
                          <input class="upload" type="submit" value="Upload Image" name="submit">
                      </form>
                    </td>';
      echo '</tr>';
    }
    ?>
    </tbody>
    </table>
  </div>
  <input class="button" type="submit" value="Enviar" form ="form1"/>
  <br>
    

    <?php

    $query = ' SELECT * FROM `grupo` WHERE id = ' . $_SESSION['grupo_id'] . ' ';
    $stmt = $dbh->prepare($query);
    $stmt->execute([$_SESSION['grupo_id']]);
    $rows = $stmt->fetchAll(PDO::FETCH_ASSOC);
    foreach ($rows as $row) {
      echo '<form method="post" action="' . htmlspecialchars($_SERVER["PHP_SELF"]) . '"  id="form_pn" >';
      echo '<div class="group_container">';
      echo '<input type="hidden" name="informe_grupo" value="" />';
      echo '<p class="titulo_informe">INFORME SOBRE LOS RECURSOS IDENTIFICADOS POR TODOS LOS PARTICIPANTES</p>';
      echo '<td><textarea rows="6" cols="150" name="inf_s3"  form="form_pn" class="informe_grupo"  >' . $row["inf_s3"] . ' </textarea></td></br>';
      echo '<td><input class="button" type="submit" value="Enviar informe del grupo"/></td>';
      echo '</div>';
      echo '</form>';
    }

    ?>


</body>


<?php

include_once("footer.php");
?>
