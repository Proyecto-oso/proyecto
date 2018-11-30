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
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.1.0/css/bootstrap.min.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.0/umd/popper.min.js"></script>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">
    <link href="https://fonts.googleapis.com/css?family=Kanit" rel="stylesheet">
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.3.1/css/all.css" integrity="sha384-mzrmE5qonljUremFsqc01SB46JvROS7bZs3IO2EmfFsd15uHvIt+Y8vEf7N7fWAU" crossorigin="anonymous">
    <link rel="stylesheet" type="text/css" href="styles/sesion2.css">
    <title>Proyecto Psicologia</title>
</head>
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
<body><?php
        $query = ' SELECT * FROM estudiantes WHERE grupo_id = ? ';
        $stmt = $dbh->prepare($query);
        $stmt->execute([$_SESSION['grupo_id']]);
        $rows = $stmt->fetchAll(PDO::FETCH_ASSOC);
        $est = [];
        foreach ($rows as $row) {
            $id = $row['id'];
            $query = ' SELECT * FROM sesion_8 WHERE id_estudiante = ? ';
            $stmt = $dbh->prepare($query);
            $stmt->execute([$id]);
            $s = $stmt->fetch(PDO::FETCH_ASSOC);
            $est["est$id"] = $s;
        }
        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            if (isset($_POST['diario'])) {
                $originales = array("'", '"');
                $correctos = array("\'", '\"');
                $_POST['inf_s8'] = str_replace($originales, $correctos, $_POST['inf_s8']);
                $query = 'UPDATE `grupo` SET `inf_s8` = "' . $_POST['inf_s8'] . '" WHERE `grupo`.`id` = ' . $_SESSION['grupo_id'] . '; ';
                $dbh->beginTransaction();
                $stmt = $dbh->prepare($query);
                $stmt->execute();
                $dbh->commit();
                echo '<script language="javascript">';
                echo 'alert("Guardado correctamente")';
                echo '</script>';
                echo '<script language="javascript">window.location="sesion8.php"</script>';
            } else {
                $originales = array("'", '"');
                $correctos = array("\'", '\"');
                foreach ($rows as $row) {
                    $id = $row['id'];
                    if (isset($_POST['id_ses' . $id])) {
                        $query = 'UPDATE `sesion_8` SET';
                        $query .= '`asistencia`= ' . $_POST[$id . "_asistencia"] . ',';

                        $query .= '`temas_trabajados`=' . $_POST[$id . '_temas_trabajados'] . ',';
                        $est["est$id"]["temas_trabajados"] = $_POST[$id . '_temas_trabajados'];

                        $query .= '`ejercicios`=' . $_POST[$id . '_ejercicios'] . ',';
                        $est["est$id"]["ejercicios"] = $_POST[$id . '_ejercicios'];

                        $query .= '`tallerista`=' . $_POST[$id . '_tallerista'] . ',';
                        $est["est$id"]["tallerista"] = $_POST[$id . '_tallerista'];

                        $query .= '`utilidad`=' . $_POST[$id . '_utilidad'] . ',';
                        $est["est$id"]["utilidad"] = $_POST[$id . '_utilidad'];

                        $_POST[$id . '_evaluacion1'] = str_replace($originales, $correctos, $_POST[$id . '_evaluacion1']);
                        $query .= '`evaluacion1` = "' . $_POST[$id . '_evaluacion1'] . '", ';
                        $est["est$id"]["evaluacion1"] = $_POST[$id . '_evaluacion1'];

                        $_POST[$id . '_evaluacion2'] = str_replace($originales, $correctos, $_POST[$id . '_evaluacion2']);
                        $query .= '`evaluacion2` = "' . $_POST[$id . '_evaluacion2'] . '", ';
                        $est["est$id"]["evaluacion2"] = $_POST[$id . '_evaluacion2'];

                        $_POST[$id . '_observaciones'] = str_replace($originales, $correctos, $_POST[$id . '_observaciones']);
                        $query .= '`observaciones` = "' . $_POST[$id . '_observaciones'] . '" WHERE id_estudiante=' . $id . ' ';
                        $est["est$id"]["observaciones"] = $_POST[$id . '_observaciones'];
                        $dbh->beginTransaction();
                        //echo $query;
                        try {
                            $stmt = $dbh->prepare($query);
                            $stmt->execute();
                            $dbh->commit();
                        } catch (Exception $e) {
                            $dbh->rollBack();
                            echo '<script language="javascript">';
                                echo 'alert("ERROR estudiante:'.$row['nombre'].'")';
                                echo '</script>';
                            if (strpos($e->getMessage(), 'Incorrect integer value')) {
                                echo '<script language="javascript">';
                                echo 'alert("ERROR: el total debe ser un número")';
                                echo '</script>';
                            }
                        }
                    } else {
                        $query = 'INSERT INTO `sesion_8`(`id_estudiante`,`asistencia`, `temas_trabajados`, `ejercicios`, `tallerista`, `utilidad`, `evaluacion1`, `evaluacion2`, `observaciones`) VALUES (';
                        $query .= $row["id"] . ',';
                        $query .=  $_POST[$id . "_asistencia"] . ',';

                        $query .= '' . $_POST[$id . '_temas_trabajados'] . ',';
                        $est["est$id"]["temas_trabajados"] = $_POST[$id . '_temas_trabajados'];

                        $query .= '' . $_POST[$id . '_ejercicios'] . ',';
                        $est["est$id"]["ejercicios"] = $_POST[$id . '_ejercicios'];

                        $query .= '' . $_POST[$id . '_tallerista'] . ',';
                        $est["est$id"]["tallerista"] = $_POST[$id . '_tallerista'];

                        $query .= '' . $_POST[$id . '_utilidad'] . ',';
                        $est["est$id"]["utilidad"] = $_POST[$id . '_utilidad'];

                        $_POST[$id . '_evaluacion1'] = str_replace($originales, $correctos, $_POST[$id . '_evaluacion1']);
                        $query .= '"' . $_POST[$id . '_evaluacion1'] . '", ';
                        $est["est$id"]["evaluacion1"] = $_POST[$id . '_evaluacion1'];

                        $_POST[$id . '_evaluacion2'] = str_replace($originales, $correctos, $_POST[$id . '_evaluacion2']);
                        $query .= '"' . $_POST[$id . '_evaluacion2'] . '", ';
                        $est["est$id"]["evaluacion2"] = $_POST[$id . '_evaluacion2'];


                        $_POST[$id . '_observaciones'] = str_replace($originales, $correctos, $_POST[$id . '_observaciones']);
                        $query .= '"' . $_POST[$id . '_observaciones'] . '") ';
                        $est["est$id"]["observaciones"] = $_POST[$id . '_observaciones'];
                        $est["est$id"]['id_estudiante'] = $id;
                        //echo $query;
                        $dbh->beginTransaction();

                        try {
                            $stmt = $dbh->prepare($query);
                            $stmt->execute();
                            $dbh->commit();

                        } catch (Exception $e) {
                            $dbh->rollBack();
                            echo '<script language="javascript">';
                                echo 'alert("ERROR estudiante:'.$row['nombre'].'")';
                                echo '</script>';
                            if (strpos($e->getMessage(), 'Incorrect integer value')) {
                                echo '<script language="javascript">';
                                echo 'alert("ERROR: el total debe ser un número")';
                                echo '</script>';
                            }
                        }
                    }
                }
                echo '<script language="javascript">';
                echo 'alert("Guardado correctamente")';
                echo '</script>';
                echo '<script language="javascript">window.location="sesion8.php"</script>';
            }

        } ?>
     <form id="form1" method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>"></form>
     <div class="tb-container">
    <table class="table" style="float: left;" >
    <thead>
    <tr class="titles">
    <th >Nombre</th>
    <th > <div style="width: 145px">Asistencia </div></th>
    <th >Los temas trabajados</th>
    <th >Los ejercicios</th>
    <th >La direccion del tallerista</th>
    <th >La utilidad para tu diario vivir</th>
    <th >¿En qué te ayudo el taller?</th>
    <th >¿Qué le mejorarias al taller?</th>
    <th>Observaciones</th>
    <th>Archivo</th>
    <!--<th>GUARDAR</th>-->
    </tr>
    </thead>
    <tbody>
    <?php
    foreach ($rows as $row) {
        $id = $row['id'];
        $s = $est["est$id"];
        echo ' <tr>
        <th>' . $row['nombre'] . '</th>';



        if (!isset($s['id_estudiante'])) {
          $asistencia = 0;
          ?>
          <td>
            <input <?php echo ' type="radio" class="radioBttn" name= "' . $id . "_asistencia".'"' ; ?>  <?php if ($asistencia == 1) echo "checked"; ?> value="1" form="form1">Si</br>
            <input <?php echo ' type="radio" class="radioBttn" name= "' . $id . "_asistencia".'"' ; ?>  <?php if ($asistencia == 2) echo "checked"; ?> value="2" form="form1">Si, pero no completo</br>
            <input <?php echo ' type="radio" class="radioBttn" name= "' . $id . "_asistencia".'"' ; ?>  <?php if ($asistencia == 0) echo "checked"; ?> value="0" form="form1">No
          </td>
          <?php
            //echo ' <form method = "post" action = "' . htmlspecialchars($_SERVER["PHP_SELF"]) . '" id="form_' . $s['id_estudiante'] . '" >';
            $items = [null, null, null, null, null, null, null, null, null, null];

        echo '<td><input class="in" type="number" name="' . $id . '_temas_trabajados" value="0" form="form1"/></td>';
        echo '<td><input class="in" type="number" name="' . $id . '_ejercicios" value="0" form="form1"/></td>';
        echo '<td><input class="in" type="number" name="' . $id . '_tallerista" value="0" form="form1"/></td>';
        echo '<td><input class="in" type="number" name="' . $id . '_utilidad" value="0" form="form1"/></td>';

        echo '<td><textarea rows="6" cols="40" name="' . $id . '_evaluacion1" form="form1"> </textarea></td>';
        echo '<td><textarea rows="6" cols="40" name="' . $id . '_evaluacion2" form="form1"> </textarea></td>';
        echo '<td><textarea rows="6" cols="40" name="' . $id . '_observaciones" form="form1"> </textarea></td>';
        echo '<input type="hidden" name="name" value="' . $row['nombre'] . '" form="form1"/>';
        echo '<input type="hidden" name="id" value="' . $row['id'] . '" form="form1"/>';
           // echo '<td><input class="button" type="submit" value="Enviar"/></td>';
           // echo '</form>';
    } else {

        $asistencia = $s["asistencia"];
        ?>
        <td>
          <?php echo '<input type="radio" class="radioBttn" name= "' . $id . "_asistencia".'"' ; ?>  <?php if ($asistencia == 1) echo "checked"; ?> value="1" form="form1">Si</br>
          <input <?php echo ' type="radio" class="radioBttn" name= "' . $id . "_asistencia".'"' ; ?>  <?php if ($asistencia == 2) echo "checked"; ?> value="2" form="form1">Si, pero no completo</br>
          <?php echo '<input type="radio" class="radioBttn" name= "' . $id . "_asistencia".'"' ; ?>  <?php if ($asistencia == 0) echo "checked"; ?> value="0" form="form1">No
        </td>
        <?php
            //echo '<form method="post" action="' . htmlspecialchars($_SERVER["PHP_SELF"]) . '" id="form_' . $s['id_estudiante'] . '" >';
        $items = [null, null, null, null, null, null, null, null, null, null];

        echo '<td><input class="in" type="number" name="' . $id . '_temas_trabajados" value="' . $s["temas_trabajados"] . '" form="form1"/></td>';
        echo '<td><input class="in" type="number" name="' . $id . '_ejercicios" value="' . $s["ejercicios"] . '" form="form1"/></td>';
        echo '<td><input class="in" type="number" name="' . $id . '_tallerista" value="' . $s["tallerista"] . '" form="form1"/></td>';
        echo '<td><input class="in" type="number" name="' . $id . '_utilidad" value="' . $s["utilidad"] . '" form="form1"/></td>';

        echo '<td><textarea rows="6" cols="40" name="' . $id . '_evaluacion1" form="form1">' . $s["evaluacion1"] . ' </textarea></td>';
        echo '<td><textarea rows="6" cols="40" name="' . $id . '_evaluacion2" form="form1">' . $s["evaluacion2"] . ' </textarea></td>';
        echo '<td><textarea rows="6" cols="40" name="' . $id . '_observaciones" form="form1">' . $s["observaciones"] . ' </textarea></td>';
        echo '<input type="hidden" name="name" value="' . $row['nombre'] . '" form="form1"/>';
        echo '<input type="hidden" name="id" value="' . $row['id'] . '" form="form1"/>';
        echo '<input type="hidden" name="id_ses' . $s['id_estudiante'] . '" value="' . $s['id_estudiante'] . '" form="form1"/>';
            //echo '<td><input class="button" type="submit" value="Enviar"/></td>';
            //echo '</form>';

    }
    echo '<td>';
    $path = 'uploads/sesion8/' . $row['id'];
    if (glob($path . '.*')) {
        $arr = glob($path . '.*');
        echo '<a href="' . $arr[0] . '">Ver archivo</a>';

    }
    echo '
                      <form action="upload.php" method="post" enctype="multipart/form-data">
                          Selecciona el archivo:
                          <input type="hidden" name="Sesion8" value="Sesion8" />
                          <input type="hidden" name="redirect" value="sesion8" />
                          <input type="hidden" name="image_id" value="' . $row['id'] . '" />
                          <input class="fileToUpload" type="file" name="fileToUpload" id="fileToUpload">
                          <input class="upload" type="submit" value="Subir archivo" name="submit">
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
$row = $stmt->fetch(PDO::FETCH_ASSOC);
echo '<form method="post" action="' . htmlspecialchars($_SERVER["PHP_SELF"]) . '"  >';
echo '<div class="group_container">';
echo '<input type="hidden" name="diario" value="" />';
echo '<h4 class="titulo_informe" >Diario de campo del taller sobre Asertividad</h4>';
echo '<textarea rows="6" cols="150" name="inf_s8" class="informe_grupo"  >' . $row["inf_s8"] . ' </textarea></br>';
echo '<input class="button" type="submit" value="Enviar informe del grupo"/>';
echo '</div>';
echo '</form>';
echo '
        <div style="margin-left: 30px;">
        <h2>Lista asistencia</h2>';
    $path = 'uploads/sesion8/lista'.$_SESSION['grupo_id'].'';
    if (glob($path . '.*')) {
        $arr = glob($path . '.*');
        echo '<h3><a href="' . $arr[0] . '">Ver Lista</a></h3>';

    }
    echo '<form action="upload.php" method="post" enctype="multipart/form-data">
            Selecciona el archivo:
            <input type="hidden" name="Sesion8" value="Sesion8" />
            <input type="hidden" name="redirect" value="sesion8" />
            <input type="hidden" name="image_id" value="lista'.$_SESSION['grupo_id'].'" />
            <input class="fileToUpload" type="file" name="fileToUpload" id="fileToUpload">
            <input class="upload" type="submit" value="Subir archivo" name="submit">
        </form>
        </div>';

    echo '
        <div style="margin-left: 30px;">
        <h2>Acta Sesión</h2>';
    $path = 'uploads/sesion8/acta'.$_SESSION['grupo_id'].'';
    if (glob($path . '.*')) {
        $arr = glob($path . '.*');
        echo '<h3><a href="' . $arr[0] . '">Ver Acta</a></h3>';

    }
    echo '<form action="upload.php" method="post" enctype="multipart/form-data">
            Selecciona el archivo:
            <input type="hidden" name="Sesion8" value="Sesion8" />
            <input type="hidden" name="redirect" value="sesion8" />
            <input type="hidden" name="image_id" value="acta'.$_SESSION['grupo_id'].'" />
            <input class="fileToUpload" type="file" name="fileToUpload" id="fileToUpload">
            <input class="upload" type="submit" value="Subir archivo" name="submit">
        </form>
        </div>';
include_once("footer.php");
?>
