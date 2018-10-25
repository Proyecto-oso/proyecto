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
    <link rel="stylesheet" type="text/css" href="styles/sesion1.css">
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
<body>
<div class="tb-container">
<body>
    <?php
    $query = ' SELECT * FROM estudiantes WHERE grupo_id = ? ';
    $stmt = $dbh->prepare($query);
    $stmt->execute([$_SESSION['grupo_id']]);
    $est = $stmt->fetchAll(PDO::FETCH_ASSOC);
    $est = [];
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
    } ?>
     <form id="form1" method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>"></form>
<table class="table" >
<thead >
    <tr class="titles">
    <th>Nombre</th>
    <th>Edad</th>
    <th>Sexo</th>
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
            //echo ' <form method = "post" action = "' . htmlspecialchars($_SERVER["PHP_SELF"]) . '" id="form_' . $s['id_estudiante'] . '" >';
            echo '<td><input class="in" type="text" name="' . $id . '_aptitud_verbal_' . (1) . '" value="" form="form1"/></td>';
            for ($i = 1; $i < 15; $i++) {
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
            echo '<td><textarea rows="4" cols="40" name="' . $id . '_observaciones" form="form1"> </textarea></td>';
            //} else {
              //  echo '<input type="hidden" name="' . $id . '_informe_via" value="" />';
            //}
            echo '<input type="hidden" name="name" value="' . $row['nombre'] . '" form="form1"/>';
            echo '<input type="hidden" name="id" value="' . $row['id'] . '" form="form1"/>';
           // echo '<td><input class="button" type="submit" value="Enviar"/></td>';
           // echo '</form>';
        } else {
            //echo '<form method="post" action="' . htmlspecialchars($_SERVER["PHP_SELF"]) . '" id="form_' . $s['id_estudiante'] . '" >';
            echo '<td><input class="in" type="text" name="' . $id . '_aptitud_verbal_' . 1 . '" value="' . $s["aptitud_verbal_1"] . '" form="form1"/></td>';
            for ($i = 2; $i <= 15; $i++) {
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
            echo '<td><textarea rows="4" cols="40" name="' . $id . '_observaciones" form="form1">' . $s["observaciones"] . ' </textarea></td>';
            /*} else {
                echo '<input type="hidden" name="' . $id . '_informe_via" value="' . $s["informe_via"] . '" />';
            }*/
            //echo '<td><input class="inf" type="text" name="informe_via" value="' . $s["informe_via"] . '" /></td>';
            //echo '<td><input class="button" type="submit" value="Enviar"/></td>';
            //echo '</form>';

        }
        echo '<td>';
        $path = 'uploads/sesion1/' . $row['id'];
        if (glob($path . '*')) {
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
    </tbody>
    </table>
    
    
</div>
<input class="button" type="submit" value="Enviar" form ="form1"/>
<br>
    <?php

    include_once("footer.php");
    ?>