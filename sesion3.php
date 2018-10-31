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
    <meta name= "'.$id.'_viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name= "'.$id.'_theme-color" content="#000000">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.1.0/css/bootstrap.min.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.0/umd/popper.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.1.0/js/bootstrap.min.js"></script>
    <link href="https://fonts.googleapis.com/css?family=Kanit" rel="stylesheet">
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.3.1/css/all.css" integrity="sha384-mzrmE5qonljUremFsqc01SB46JvROS7bZs3IO2EmfFsd15uHvIt+Y8vEf7N7fWAU" crossorigin="anonymous">
    <link rel="stylesheet" type="text/css" href="styles/sesion1.css">
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
      $query = ' SELECT * FROM sesion_3 WHERE id_estudiante = ? ';
      $stmt = $dbh->prepare($query);
      $stmt->execute([$id]);
      $s = $stmt->fetch(PDO::FETCH_ASSOC);
      $est[$id] = $s;
    }
    if ($_SERVER['REQUEST_METHOD'] == "POST") {
      foreach ($rows as $row) {
        $id = $row['id'];
        if (isset($_POST[$id . '_id_ses'])) {
          $query = 'UPDATE `sesion_3` SET';
          $originales = array("'", '"');
          $correctos = array("\'", '\"');
          $_POST[$id . '_e_proceso'] = str_replace($originales, $correctos, $_POST[$id . '_e_proceso']);
          $query .= '`e_proceso` = "' . $_POST[$id . '_e_proceso'] . '",';
          $est[$id]['e_proceso'] = $_POST[$id . '_e_proceso'];

          for ($i = 1; $i <= 44; $i++) {
          // code...
            if (isset($_POST[$id . '_pregunta_' . $i])) {
              $query .= '`pregunta_' . $i . '`= ' . $_POST[$id . '_pregunta_' . $i] . ',';
              $est[$id]['pregunta_' . $i] = $_POST[$id . '_pregunta_' . $i];
            } else {
              $query .= '`pregunta_' . $i . '`= -1,';
              $est[$id]['pregunta_' . $i] = -1;
            }
          }
          
          $_POST[$id . '_mas_predominante'] = str_replace($originales, $correctos, $_POST[$id . '_mas_predominante']);
          $query .= '`mas_predominante`   = "' . $_POST[$id . '_mas_predominante'] . '",';
          $est[$id]['mas_predominante'] = $_POST[$id . '_mas_predominante'];
          
          $_POST[$id . '_menos_predominante'] = str_replace($originales, $correctos, $_POST[$id . '_menos_predominante']);
          $query .= '`menos_predominante` = "' . $_POST[$id . '_menos_predominante'] . '",';
          $est[$id]['menos_predominante'] = $_POST[$id . '_menos_predominante'];
          
          $_POST[$id . '_est_predominante'] = str_replace($originales, $correctos, $_POST[$id . '_est_predominante']);
          $query .= '`est_predominante` = "' . $_POST[$id . '_est_predominante'] . '",';
          $est[$id]['est_predominante'] = $_POST[$id . '_est_predominante'];

          $query .= '`temas_trabajados` =' . $_POST[$id . '_temas_trabajados'] . ',';
          $est[$id]['temas_trabajados'] = $_POST[$id . '_temas_trabajados'];
          $query .= '`ejercicios` =' . $_POST[$id . '_ejercicios'] . ',';
          $est[$id]['ejercicios'] = $_POST[$id . '_ejercicios'];
          $query .= '`tallerista` =' . $_POST[$id . '_tallerista'] . ',';
          $est[$id]['tallerista'] = $_POST[$id . '_tallerista'];
          $query .= '`utilidad` =' . $_POST[$id . '_utilidad'] . ',';
          $est[$id]['utilidad'] = $_POST[$id . '_utilidad'];
          
          $_POST[$id . '_observaciones'] = str_replace($originales, $correctos, $_POST[$id . '_observaciones']);
          $query .= '`observaciones` ="' . $_POST[$id . '_observaciones'] . '"';
          $est[$id]['observaciones'] = $_POST[$id . '_observaciones'];

          $query .= ' WHERE id_estudiante=' . $_POST[$id . '_id_ses'] . ' ';

          $dbh->beginTransaction();

          try {
            $stmt = $dbh->prepare($query);
            $stmt->execute();
            $dbh->commit();
            
          //echo '<script language="javascript">window.location="sesion3.php"</script>';

          } catch (Exception $e) {
            $dbh->rollBack();
            echo $query;
            echo '<script language="javascript">';
            echo 'alert("Erro al guardar intente nuevamente")';
            echo '</script>';
          //echo '<script language="javascript">window.location="sesion3.php"</script>';
          }

        } else {
          $query = 'INSERT INTO `sesion_3`(`id_estudiante`, `e_proceso`,`pregunta_1` ,`pregunta_2`, `pregunta_3`, `pregunta_4`, `pregunta_5`, `pregunta_6`, `pregunta_7`, `pregunta_8`, `pregunta_9`, `pregunta_10`, `pregunta_11`, `pregunta_12`, `pregunta_13`, `pregunta_14`, `pregunta_15`, `pregunta_16`, `pregunta_17`, `pregunta_18`, `pregunta_19`, `pregunta_20`, `pregunta_21`, `pregunta_22`, `pregunta_23`, `pregunta_24`, `pregunta_25`, `pregunta_26`, `pregunta_27`, `pregunta_28`, `pregunta_29`, `pregunta_30`, `pregunta_31`, `pregunta_32`, `pregunta_33`, `pregunta_34`, `pregunta_35`, `pregunta_36`, `pregunta_37`, `pregunta_38`, `pregunta_39`, `pregunta_40`, `pregunta_41`, `pregunta_42`, `pregunta_43`, `pregunta_44`,`mas_predominante`,`menos_predominante`,`est_predominante`, `temas_trabajados`, `ejercicios`, `tallerista`, `utilidad`, `observaciones`) VALUES (';

          $originales = array("'", '"');
          $correctos = array("\'", '\"');
          $_POST[$id . '_e_proceso'] = str_replace($originales, $correctos, $_POST[$id . '_e_proceso']);
          
          $query .= $id . ',';
          $query .= '"' . $_POST[$id . '_e_proceso'] . '"' . ',';
          $est[$id]['e_proceso'] = $_POST[$id . '_e_proceso'];

          for ($i = 1; $i <= 44; $i++) {
          // code...
            if (isset($_POST[$id . '_pregunta_' . $i])) {
              $query .= $_POST[$id . '_pregunta_' . $i] . ',';
              $est[$id]['pregunta_' . $i] = $_POST[$id . '_pregunta_' . $i];
            } else {
              $query .= "-1 ,";
              $est[$id]['pregunta_' . $i] = -1;
            }
          }

          $_POST[$id . '_mas_predominante'] = str_replace($originales, $correctos, $_POST[$id . '_mas_predominante']);
          $query .= '"' . $_POST[$id . '_mas_predominante'] . '",';
          $est[$id]['mas_predominante'] = $_POST[$id . '_mas_predominante'];
          
          $_POST[$id . '_menos_predominante'] = str_replace($originales, $correctos, $_POST[$id . '_menos_predominante']);
          $query .= '"' . $_POST[$id . '_menos_predominante'] . '",';
          $est[$id]['menos_predominante'] = $_POST[$id . '_menos_predominante'];

          $_POST[$id . '_est_predominante'] = str_replace($originales, $correctos, $_POST[$id . '_est_predominante']);
          $query .= '"' . $_POST[$id . '_est_predominante'] . '",';
          $est[$id]['est_predominante'] = $_POST[$id . '_est_predominante'];


          $query .= $_POST[$id . '_temas_trabajados'] . ',';
          $est[$id]['temas_trabajados'] = $_POST[$id . '_temas_trabajados'];
          $query .= $_POST[$id . '_ejercicios'] . ',';
          $est[$id]['ejercicios'] = $_POST[$id . '_ejercicios'];
          $query .= $_POST[$id . '_tallerista'] . ',';
          $est[$id]['tallerista'] = $_POST[$id . '_tallerista'];
          $query .= $_POST[$id . '_utilidad'] . ',';
          $est[$id]['utilidad'] = $_POST[$id . '_utilidad'];

          $_POST[$id . '_observaciones'] = str_replace($originales, $correctos, $_POST[$id . '_observaciones']);
          $query .= '"' . $_POST[$id . '_observaciones'] . '")';
          $est[$id]['observaciones'] = $_POST[$id . '_observaciones'];

          $est[$id]['id_estudiante'] = $id;

          $dbh->beginTransaction();

          try {
            $stmt = $dbh->prepare($query);
            $stmt->execute();
            $dbh->commit();

          //echo '<script language="javascript">window.location="sesion3.php"</script>';

          } catch (Exception $e) {
            $dbh->rollBack();
          #echo $query;
            echo '<script language="javascript">';
            echo 'alert("Error al guardar intente nuevamente")';
            echo '</script>';
          //echo '<script language="javascript">window.location="sesion3.php"</script>';
          }
        }
      }
      echo '<script language="javascript">';
      echo 'alert("Guardado correctamente")';
      echo '</script>';
      echo '<script language="javascript">window.location="sesion3.php"</script>';



    } ?>
    <div class="tb-container">
    <form id="form1" method="post" action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>"></form>
    <table class="table" style="float: left;" >
    <thead>
    <tr class="titles">
    <th>Nombre</th>
    <th>Evaluacion del proceso</th>
    <th>pregunta 1 </th>
    <th>pregunta 2 </th>
    <th>pregunta 3 </th>
    <th>pregunta 4 </th>
    <th>pregunta 5 </th>
    <th>pregunta 6 </th>
    <th>pregunta 7 </th>
    <th>pregunta 8 </th>
    <th>pregunta 9 </th>
    <th>pregunta 10 </th>
    <th>pregunta 11 </th>
    <th>pregunta 12 </th>
    <th>pregunta 13 </th>
    <th>pregunta 14 </th>
    <th>pregunta 15 </th>
    <th>pregunta 16 </th>
    <th>pregunta 17 </th>
    <th>pregunta 18 </th>
    <th>pregunta 19 </th>
    <th>pregunta 20 </th>
    <th>pregunta 21 </th>
    <th>pregunta 22 </th>
    <th>pregunta 23 </th>
    <th>pregunta 24 </th>
    <th>pregunta 25 </th>
    <th>pregunta 26 </th>
    <th>pregunta 27 </th>
    <th>pregunta 28 </th>
    <th>pregunta 29 </th>
    <th>pregunta 30 </th>
    <th>pregunta 31 </th>
    <th>pregunta 32 </th>
    <th>pregunta 33 </th>
    <th>pregunta 34 </th>
    <th>pregunta 35 </th>
    <th>pregunta 36 </th>
    <th>pregunta 37 </th>
    <th>pregunta 38 </th>
    <th>pregunta 39 </th>
    <th>pregunta 40 </th>
    <th>pregunta 41 </th>
    <th>pregunta 42 </th>
    <th>pregunta 43 </th>
    <th>pregunta 44 </th>
    <th>Total activo </th>
    <th>Total reflexivo </th>
    <th>Diferencia </th>
    <th>Total sensible </th>
    <th>Total intuitivo </th>
    <th>Diferencia </th>
    <th>Total visual </th>
    <th>Total verbal </th>
    <th>Diferencia </th>
    <th>Total secuencial </th>
    <th>Total global </th>
    <th>Diferencia </th>


    <th>interes mas predominante </th>
    <th>interes menos predominante </th>
    <th>estilo de aprendizaje predominante </th>
    <th>Aspecto de los temas trabajados </th>
    <th>Aspecto de los ejercicios  </th>
    <th>Aspecto de la dirección del tallerista </th>
    <th>Aspecto de la utilidad para tu diario vivir </th>
    <th>Observaciones </th>
    <th>Actividad del estudiante </th>



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
          //SI ES 1 ES A
          //SI ES 0 ES B

        echo '<td><textarea rows="4" cols="40" name="' . $id . '_e_proceso" form="form1"></textarea></td>';
          //echo ' <form method = "post" action = "' . htmlspecialchars($_SERVER['PHP_SELF']) . '" id="form_' . $id . '" >';
        $preguntas = [];
        $A = "";
        $B = "";
        for ($i = 0; $i < 44; $i++) {
          array_push($preguntas, null);
          if (($i + 1) % 4 == 1) {
            $A = "Activo";
            $B = "Reflexivo";
          } elseif (($i + 1) % 4 == 2) {
            $A = "Sensible";
            $B = "Intuitivo";
          } elseif (($i + 1) % 4 == 3) {
            $A = "Visual";
            $B = "Verbal";
          } elseif (($i + 1) % 4 == 0) {
            $A = "Secuencial";
            $B = "Global";
          }

          ?>
              <td>
                <div class="" style="width: 100px">
                  <input <?php echo ' type="radio" class="radioBttn" name= "' . $id . '_pregunta_' . ($i + 1) . '"'; ?>  <?php if (isset($preguntas[$i]) && $preguntas[$i] == "1") echo "checked"; ?> value="1" form="form1"><?php echo $A ?></br>
                  <input <?php echo ' type="radio" class="radioBttn" name= "' . $id . '_pregunta_' . ($i + 1) . '"'; ?>  <?php if (isset($preguntas[$i]) && $preguntas[$i] == "0") echo "checked"; ?> value="0" form="form1"><?php echo $B ?>
                </div>
              </td>
            <?php

          }
          echo '<td><div style="text-align: center;">0</div> </td>';
          echo '<td><div style="text-align: center;">0</div> </td>';
          echo '<td><div style="text-align: center;">0</div> </td>';
          echo '<td><div style="text-align: center;">0</div> </td>';
          echo '<td><div style="text-align: center;">0</div> </td>';
          echo '<td><div style="text-align: center;">0</div> </td>';
          echo '<td><div style="text-align: center;">0</div> </td>';
          echo '<td><div style="text-align: center;">0</div> </td>';
          echo '<td><div style="text-align: center;">0</div> </td>';
          echo '<td><div style="text-align: center;">0</div> </td>';
          echo '<td><div style="text-align: center;">0</div> </td>';
          echo '<td><div style="text-align: center;">0</div> </td>';


          echo '<td><textarea rows="4" cols="40" name= "' . $id . '_mas_predominante" form="form1"></textarea></td>';
          echo '<td><textarea rows="4" cols="40" name= "' . $id . '_menos_predominante" form="form1"></textarea></td>';

          echo '<td><textarea rows="4" cols="40" name= "' . $id . '_est_predominante" form="form1"></textarea></td>';

          echo '<td><input type="number" name= "' . $id . '_temas_trabajados" value="0" form="form1" /></td>';
          echo '<td><input type="number" name= "' . $id . '_ejercicios" value="0" form="form1" /></td>';
          echo '<td><input type="number" name= "' . $id . '_tallerista" value="0" form="form1" /></td>';
          echo '<td><input type="number" name= "' . $id . '_utilidad" value="0" form="form1" /></td>';
          echo '<td><textarea rows="4" cols="40" name= "' . $id . '_observaciones" form="form1"></textarea></td>';

          echo '<input type="hidden" name= "' . $id . '_id_estudiante" value="' . $id . '" />';
          //echo '<td><input  class="button" type="submit" value="Guardar"/></td>';
          //echo ' </form>';



        } else {

          //echo '<form method = "post" action = "' . htmlspecialchars($_SERVER['PHP_SELF']) . '" id="form_' . $id . '" >';
          echo '<td><textarea rows="4" cols="40" name= "' . $id . '_e_proceso" form="form1">' . $s['e_proceso'] . '</textarea></td>';

          $preguntas = [];
          $A = "";
          $B = "";
          $activo = 0;
          $reflexivo = 0;
          $sensible = 0;
          $intuitivo = 0;
          $visual = 0;
          $verbal = 0;
          $secuencial = 0;
          $global = 0;

          for ($i = 0; $i < 44; $i++) {
            array_push($preguntas, null);

            $I = $i + 1;
            $preguntas[$i] = $s['pregunta_' . $I];

            if (($i + 1) % 4 == 1) {
              $A = "Activo";
              $B = "Reflexivo";
              if ($preguntas[$i] != -1) {
                if ($preguntas[$i] == 1) {
                  $activo++;
                } else {
                  $reflexivo++;
                }
              }
            } elseif (($i + 1) % 4 == 2) {
              $A = "Sensible";
              $B = "Intuitivo";
              if ($preguntas[$i] != -1) {
                if ($preguntas[$i] == 1) {
                  $sensible++;
                } else {
                  $intuitivo++;
                }
              }
            } elseif (($i + 1) % 4 == 3) {
              $A = "Visual";
              $B = "Verbal";
              if ($preguntas[$i] != -1) {
                if ($preguntas[$i] == 1) {
                  $visual++;
                } else {
                  $verbal++;
                }
              }
            } elseif (($i + 1) % 4 == 0) {
              $A = "Secuencial";
              $B = "Global";
              if ($preguntas[$i] != -1) {
                if ($preguntas[$i] == 1) {
                  $secuencial++;
                } else {
                  $global++;
                }
              }
            }

            ?>
              <td>
                <div class="" style="width: 100px">
                   <?php echo '<input type="radio" class="radioBttn" name= "' . $id . '_pregunta_' . ($i + 1) . '"'; ?>  <?php if (isset($preguntas[$i]) && $preguntas[$i] == "1") echo "checked"; ?> value="1" form="form1"><?php echo $A ?></br>
                   <?php echo '<input type="radio" class="radioBttn" name= "' . $id . '_pregunta_' . ($i + 1) . '"'; ?>  <?php if (isset($preguntas[$i]) && $preguntas[$i] == "0") echo "checked"; ?> value="0" form="form1"><?php echo $B ?>
                </div>
              </td>
            <?php

          }

          echo '<td><div style="text-align: center;">' . $activo . '</div> </td>';
          echo '<td><div style="text-align: center;">' . $reflexivo . '</div> </td>';
          $diferencia = $activo - $reflexivo;
          echo '<td><div style="text-align: center;">' . $diferencia . '</div> </td>';
          echo '<td><div style="text-align: center;">' . $sensible . '</div> </td>';
          echo '<td><div style="text-align: center;">' . $intuitivo . '</div> </td>';
          $diferencia = $sensible - $intuitivo;
          echo '<td><div style="text-align: center;">' . $diferencia . '</div> </td>';
          echo '<td><div style="text-align: center;">' . $visual . '</div> </td>';
          echo '<td><div style="text-align: center;">' . $verbal . '</div> </td>';
          $diferencia = $visual - $verbal;
          echo '<td><div style="text-align: center;">' . $diferencia . '</div> </td>';
          echo '<td><div style="text-align: center;">' . $secuencial . '</div> </td>';
          echo '<td><div style="text-align: center;">' . $global . '</div> </td>';
          $diferencia = $secuencial - $global;
          echo '<td><div style="text-align: center;">' . $diferencia . '</div> </td>';


          echo '<td><textarea rows="4" cols="40" name= "' . $id . '_mas_predominante" form="form1"> ' . $s['mas_predominante'] . '</textarea></td>';
          echo '<td><textarea rows="4" cols="40" name= "' . $id . '_menos_predominante" form="form1">' . $s['menos_predominante'] . '</textarea></td>';

          echo '<td><textarea rows="4" cols="40" name= "' . $id . '_est_predominante" form="form1">' . $s['est_predominante'] . '</textarea></td>';

          echo '<td><input type="number" name= "' . $id . '_temas_trabajados" value="' . $s['temas_trabajados'] . '" form="form1"/></td>';
          echo '<td><input type="number" name= "' . $id . '_ejercicios"       value="' . $s['ejercicios'] . '" form="form1"/></td>';
          echo '<td><input type="number" name= "' . $id . '_tallerista"       value="' . $s['tallerista'] . '" form="form1"/></td>';
          echo '<td><input type="number" name= "' . $id . '_utilidad"         value="' . $s['utilidad'] . '" form="form1"/></td>';
          echo '<td><textarea rows="4" cols="40" name= "' . $id . '_observaciones" form="form1">' . $s['observaciones'] . '</textarea></td>';

          echo '<input type="hidden" name= "' . $id . '_id_ses" value="' . $s['id_estudiante'] . '" form="form1" />';
         // echo '<td><input  class="button" type="submit" value="Guardar"/></td>';
          //echo ' </form>';


        }



        echo '<td>';
        $path = 'uploads/sesion3/' . $row['id'];
        if (glob($path . '.*')) {
          $arr = glob($path . '.*');
          echo '<a href="' . $arr[0] . '">Ver archivo</a>';

        }
        echo '
                      <form action="upload.php" method="post" enctype="multipart/form-data">
                          Select image to upload:
                          <input type="hidden" name="Sesion3" value="Sesion3" />
                          <input type="hidden" name="redirect" value="sesion3" />
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


</body>


<?php
include_once("footer.php");
?>
