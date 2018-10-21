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
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="theme-color" content="#000000">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.1.0/css/bootstrap.min.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.0/umd/popper.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.1.0/js/bootstrap.min.js"></script>
    <link href="https://fonts.googleapis.com/css?family=Kanit" rel="stylesheet">
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.3.1/css/all.css" integrity="sha384-mzrmE5qonljUremFsqc01SB46JvROS7bZs3IO2EmfFsd15uHvIt+Y8vEf7N7fWAU" crossorigin="anonymous">
    <link rel="stylesheet" type="text/css" href="styles/sesion1.css">
    <title>Proyecto Psicologia</title>
<style>
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
        $query = ' SELECT * FROM sesion_1 WHERE id_estudiante = ? ';
        $stmt = $dbh->prepare($query);
        $stmt->execute([$id]);
        $s = $stmt->fetch(PDO::FETCH_ASSOC);
        $est["est$id"] = $s;
    }
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        foreach ($rows as $row) {
            $id = $row['id'];
            if (isset($_POST['id_ses' . $id])) {
                $query = 'UPDATE `sesion_1` SET';
                for ($i = 1; $i <= 15; $i++) {
                    $query .= '`aptitud_verbal_' . $i . '`="' . $_POST[$id . '_aptitud_verbal_' . $i] . '",';
                    $est["est$id"]["aptitud_verbal_$i"] = $_POST[$id . '_aptitud_verbal_' . $i];
                }
                $query .= '`total_aptitud_verbal`="' . $_POST[$id . '_total_aptitud_verbal'] . '",';
                $est["est$id"]["total_aptitud_verbal"] = $_POST[$id . '_total_aptitud_verbal'];
                for ($i = 1; $i <= 15; $i++) {
                    $query .= '`aptitud_matematica_' . $i . '`="' . $_POST[$id . '_aptitud_matematica_' . $i] . '",';
                    $est["est$id"]["aptitud_matematica_$i"] = $_POST[$id . '_aptitud_matematica_' . $i];
                }
                $query .= '`total_aptitud_matematica`="' . $_POST[$id . '_total_aptitud_matematica'] . '",';
                $est["est$id"]["total_aptitud_matematica"] = $_POST[$id . '_total_aptitud_matematica'];
                $est["est$id"]["informe_via"] = $_POST[$id . '_informe_via'];
                $query .= '`informe_via` = "' . $_POST[$id . '_informe_via'] . '" WHERE id_estudiante=' . $id . ' ';
            //We start our transaction.
                $dbh->beginTransaction();

                try {
                    $stmt = $dbh->prepare($query);
                    $stmt->execute();
                    $dbh->commit();
                } catch (Exception $e) {
                    $dbh->rollBack();
                    if (strpos($e->getMessage(), 'Incorrect integer value')) {
                        echo '<script language="javascript">';
                        echo 'alert("ERROR: el total debe ser un número")';
                        echo '</script>';
                    }
                    if (strpos($e->getMessage(), ' Data too long for column')) {
                        echo '<script language="javascript">';
                        echo 'alert("ERROR: debe ser unicamente un caracter")';
                        echo '</script>';
                    }
                }
            } else {
                $query = 'INSERT INTO `sesion_1`(`id_estudiante`,`aptitud_verbal_1`, `aptitud_verbal_2`, `aptitud_verbal_3`, `aptitud_verbal_4`, `aptitud_verbal_5`, `aptitud_verbal_6`, `aptitud_verbal_7`, `aptitud_verbal_8`, `aptitud_verbal_9`, `aptitud_verbal_10`, `aptitud_verbal_11`, `aptitud_verbal_12`, `aptitud_verbal_13`, `aptitud_verbal_14`, `aptitud_verbal_15`, `aptitud_matematica_1`, `aptitud_matematica_2`, `aptitud_matematica_3`, `aptitud_matematica_4`, `aptitud_matematica_5`, `aptitud_matematica_6`, `aptitud_matematica_7`, `aptitud_matematica_8`, `aptitud_matematica_9`, `aptitud_matematica_10`, `aptitud_matematica_11`, `aptitud_matematica_12`, `aptitud_matematica_13`, `aptitud_matematica_14`, `aptitud_matematica_15`, `total_aptitud_matematica`, `total_aptitud_verbal`, `informe_via`) VALUES (';
                $query .= $row["id"] . ',';
                for ($i = 1; $i <= 15; $i++) {
                    $query .= '"' . $_POST[$id . '_aptitud_verbal_' . $i] . '",';
                    $est["est$id"]["aptitud_verbal_$i"] = $_POST[$id . '_aptitud_verbal_' . $i];
                }
                for ($i = 1; $i <= 15; $i++) {
                    $query .= '"' . $_POST[$id . '_aptitud_matematica_' . $i] . '",';
                    $est["est$id"]["aptitud_matematica_$i"] = $_POST[$id . '_aptitud_matematica_' . $i];
                }
                $query .= '"' . $_POST[$id . '_total_aptitud_matematica'] . '",';
                $est["est$id"]["total_aptitud_matematica"] = $_POST[$id . '_total_aptitud_matematica'];
                $query .= '"' . $_POST[$id . '_total_aptitud_verbal'] . '",';
                $est["est$id"]["total_aptitud_verbal"] = $_POST[$id . '_total_aptitud_verbal'];
                $query .= '"' . $_POST[$id . '_informe_via'] . '") ';
                $est["est$id"]["informe_via"] = $_POST[$id . '_informe_via'];
                $est["est$id"]['id_estudiante'] = $id;
            //We start our transaction.
                $dbh->beginTransaction();

                try {
                    $stmt = $dbh->prepare($query);
                    $stmt->execute();
                    $dbh->commit();

                } catch (Exception $e) {
                    $dbh->rollBack();
                    if (strpos($e->getMessage(), 'Incorrect integer value')) {
                        echo '<script language="javascript">';
                        echo 'alert("ERROR: el total debe ser un número")';
                        echo '</script>';
                    }
                    if (strpos($e->getMessage(), ' Data too long for column')) {
                        echo '<script language="javascript">';
                        echo 'alert("ERROR: debe ser unicamente un caracter")';
                        echo '</script>';
                    }
                }
            }
        }
        echo '<script language="javascript">';
        echo 'alert("Guardado correctamente")';
        echo '</script>';

    } ?>
    <div class="flow-container">

    <form id="form1" method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>"></form>


    <table class="tb" style="float: left;" >
    <tr class="titles">
    <th>Nombre</th>
    <th>AV 1</th>
    <th>AV 2</th>
    <th>AV 3</th>
    <th>AV 4</th>
    <th>AV 5</th>
    <th>AV 6</th>
    <th>AV 7</th>
    <th>AV 8</th>
    <th>AV 9</th>
    <th>AV 10</th>
    <th>AV 11</th>
    <th>AV 12</th>
    <th>AV 13</th>
    <th>AV 14</th>
    <th>AV 15</th>
    <th>TOTAL AV</th>
    <th>AM 1</th>
    <th>AM 2</th>
    <th>AM 3</th>
    <th>AM 4</th>
    <th>AM 5</th>
    <th>AM 6</th>
    <th>AM 7</th>
    <th>AM 8</th>
    <th>AM 9</th>
    <th>AM 10</th>
    <th>AM 11</th>
    <th>AM 12</th>
    <th>AM 13</th>
    <th>AM 14</th>
    <th>AM 15</th>
    <th>TOTAL AM</th>
    <th>Informe Valores, Intereses y Aptitudes</th>
    <th>Archivo</th>
    <!--<th>GUARDAR</th>-->
    </tr>
    <?php
    foreach ($rows as $row) {
        $id = $row['id'];
        $s = $est["est$id"];
        echo ' <tr>
                <th> ' . $row['nombre'] . ' </th> ';
        if (!isset($s['id_estudiante'])) {
            //echo ' <form method = "post" action = "' . htmlspecialchars($_SERVER["PHP_SELF"]) . '" id="form_' . $s['id_estudiante'] . '" >';
            for ($i = 0; $i < 15; $i++) {
                echo '<td><input class="in" type="text" name="' . $id . '_aptitud_verbal_' . ($i + 1) . '" value="" form="form1"/></td>';
            }
            echo '<td><input class="in" type="text" name="' . $id . '_total_aptitud_verbal" value="0" form="form1"/></td>';
            for ($i = 0; $i < 15; $i++) {
                echo '<td><input class="in" type="text" name="' . $id . '_aptitud_matematica_' . ($i + 1) . '" value="" form="form1"/></td>';
            }
            echo '<td><input class="in" type="text" name="' . $id . '_total_aptitud_matematica" value="0" form="form1"/></td>';
            //echo '<td><input class="inf" type="text" name="informe_via" value="" /></td>';
            //if ($_SESSION['usuario_tipo'] != 'co-tallerista') {
            echo '<td><textarea rows="4" cols="40" name="' . $id . '_informe_via" form="form1"> </textarea></td>';
            //} else {
              //  echo '<input type="hidden" name="' . $id . '_informe_via" value="" />';
            //}
            echo '<input type="hidden" name="name" value="' . $row['nombre'] . '" form="form1"/>';
            echo '<input type="hidden" name="id" value="' . $row['id'] . '" form="form1"/>';
           // echo '<td><input class="button" type="submit" value="Enviar"/></td>';
           // echo '</form>';
        } else {
            //echo '<form method="post" action="' . htmlspecialchars($_SERVER["PHP_SELF"]) . '" id="form_' . $s['id_estudiante'] . '" >';
            for ($i = 1; $i <= 15; $i++) {
                echo '<td><input class="in" type="text" name="' . $id . '_aptitud_verbal_' . $i . '" value="' . $s["aptitud_verbal_$i"] . '" form="form1"/></td>';
            }
            echo '<td><input class="in" type="text" name="' . $id . '_total_aptitud_verbal" value="' . $s["total_aptitud_verbal"] . '"form="form1" /></td>';
            for ($i = 1; $i <= 15; $i++) {
                echo '<td><input class="in" type="text" name="' . $id . '_aptitud_matematica_' . $i . '" value="' . $s["aptitud_matematica_$i"] . '" form="form1"/></td>';
            }
            echo '<input type="hidden" name="name" value="' . $row['nombre'] . '" form="form1"/>';
            echo '<input type="hidden" name="id" value="' . $row['id'] . '" form="form1"/>';
            echo '<input type="hidden" name="id_ses' . $s['id_estudiante'] . '" value="' . $s['id_estudiante'] . '" form="form1"/>';
            echo '<td><input class="in" type="text" name="' . $id . '_total_aptitud_matematica" value="' . $s["total_aptitud_matematica"] . '" form="form1"/></td>';
            //if ($_SESSION['usuario_tipo'] != 'co-tallerista') {
            echo '<td><textarea rows="4" cols="40" name="' . $id . '_informe_via" form="form1">' . $s["informe_via"] . ' </textarea></td>';
            /*} else {
                echo '<input type="hidden" name="' . $id . '_informe_via" value="' . $s["informe_via"] . '" />';
            }*/
            //echo '<td><input class="inf" type="text" name="informe_via" value="' . $s["informe_via"] . '" /></td>';
            //echo '<td><input class="button" type="submit" value="Enviar"/></td>';
            //echo '</form>';

        }
        echo '<td>';
        $path='uploads/sesion1/'.$row['id'];
        if(glob($path.'*')){
          $arr = glob($path . '*');
          echo '<a href="' . $arr[0] . '">Ver archivo</a>';
          
        }
        echo '
                      <form action="upload.php" method="post" enctype="multipart/form-data">
                          Select image to upload:
                          <input type="hidden" name="Sesion1" value="Sesion1" />
                          <input type="hidden" name="redirect" value="sesion1" />
                          <input type="hidden" name="image_id" value="' . $row['id'] . '" />
                          <input class="fileToUpload" type="file" name="fileToUpload" id="fileToUpload">
                          <input class="upload" type="submit" value="Upload Image" name="submit">
                      </form>
                    </td>';
        echo '</tr>';
    }
    ?>
    </table>
    <input class="button" type="submit" value="Enviar" form ="form1"/>
    </form>

    </div>
</body>
<?php

include_once("footer.php");
?>
