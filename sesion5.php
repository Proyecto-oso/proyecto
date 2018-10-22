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
<body>
<?php
$query = ' SELECT * FROM estudiantes WHERE grupo_id = ? ';
$stmt = $dbh->prepare($query);
$stmt->execute([$_SESSION['grupo_id']]);
$rows = $stmt->fetchAll(PDO::FETCH_ASSOC);
$est = [];
foreach ($rows as $row) {
    $id = $row['id'];
    $query = ' SELECT * FROM sesion_5 WHERE id_estudiante = ? ';
    $stmt = $dbh->prepare($query);
    $stmt->execute([$id]);
    $s = $stmt->fetch(PDO::FETCH_ASSOC);
    $est["est$id"] = $s;
}
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_POST['dicc'])) {
        $query = 'UPDATE `grupo` SET `inf_s5_dicc` = "' . $_POST['inf_s5_dicc'] . '" WHERE `grupo`.`id` = ' . $_SESSION['grupo_id'] . '; ';
        $dbh->beginTransaction();
        $stmt = $dbh->prepare($query);
        $stmt->execute();
        $dbh->commit();
        echo '<script language="javascript">';
        echo 'alert("Guardado correctamente")';
        echo '</script>';
    } elseif (isset($_POST['diario'])) {
        $query = 'UPDATE `grupo` SET `inf_s5_diario` = "' . $_POST['inf_s5_diario'] . '" WHERE `grupo`.`id` = ' . $_SESSION['grupo_id'] . '; ';
        $dbh->beginTransaction();
        $stmt = $dbh->prepare($query);
        $stmt->execute();
        $dbh->commit();
        echo '<script language="javascript">';
        echo 'alert("Guardado correctamente")';
        echo '</script>';
    } else {
        foreach ($rows as $row) {
            $id = $row['id'];
            if (isset($_POST['id_ses' . $id])) {
                $query = 'UPDATE `sesion_5` SET';
                $query .= '`total`=' . $_POST[$id . '_total'] . ',';
                $est["est$id"]["total"] = $_POST[$id . '_total'];
                $query .= '`estilo`="' . $_POST[$id . '_estilo'] . '",';
                $est["est$id"]["estilo"] = $_POST[$id . '_estilo'];
                $query .= '`observaciones` = "' . $_POST[$id . '_observaciones'] . '" WHERE id_estudiante=' . $id . ' ';
                $est["est$id"]["observaciones"] = $_POST[$id . '_observaciones'];
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
                }
            } else {
                $query = 'INSERT INTO `sesion_5`(`id_estudiante`,`total`, `estilo`, `observaciones`) VALUES (';
                $query .= $row["id"] . ',';
                $query .= '' . $_POST[$id . '_total'] . ',';
                $est["est$id"]["total"] = $_POST[$id . '_total'];
                $query .= '"' . $_POST[$id . '_estilo'] . '", ';
                $est["est$id"]["estilo"] = $_POST[$id . '_estilo'];
                $query .= '"' . $_POST[$id . '_observaciones'] . '") ';
                $est["est$id"]["observaciones"] = $_POST[$id . '_observaciones'];
                $est["est$id"]['id_estudiante'] = $id;

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
                }
            }
        }
        echo '<script language="javascript">';
        echo 'alert("Guardado correctamente")';
        echo '</script>';
    }

} ?>
     <form id="form1" method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>"></form>
<table class="table" >
<thead >
    <tr class="titles">
    <th >Nombre</th>
    <th >Puntaje total</th>
    <th>estilo de toma de decisiones</th>
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
            echo '<td><input class="in" type="text" name="' . $id . '_total" value="0" form="form1"/></td>';
            //echo '<td><input class="inf" type="text" name="informe_via" value="" /></td>';
            //if ($_SESSION['usuario_tipo'] != 'co-tallerista') {
            echo '<td><textarea rows="4" cols="40" name="' . $id . '_estilo" form="form1"> </textarea></td>';
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

            echo '<input type="hidden" name="name" value="' . $row['nombre'] . '" form="form1"/>';
            echo '<input type="hidden" name="id" value="' . $row['id'] . '" form="form1"/>';
            echo '<input type="hidden" name="id_ses' . $s['id_estudiante'] . '" value="' . $s['id_estudiante'] . '" form="form1"/>';
            //if ($_SESSION['usuario_tipo'] != 'co-tallerista') {
            echo '<td><input class="in" type="text" name="' . $id . '_total" value="' . $s["total"] . '" form="form1"/></td>';
            echo '<td><textarea rows="4" cols="40" name="' . $id . '_estilo" form="form1">' . $s["estilo"] . ' </textarea></td>';
            echo '<td><textarea rows="4" cols="40" name="' . $id . '_observaciones" form="form1">' . $s["observaciones"] . ' </textarea></td>';
            /*} else {
                echo '<input type="hidden" name="' . $id . '_informe_via" value="' . $s["informe_via"] . '" />';
            }*/
            //echo '<td><input class="inf" type="text" name="informe_via" value="' . $s["informe_via"] . '" /></td>';
            //echo '<td><input class="button" type="submit" value="Enviar"/></td>';
            //echo '</form>';

        }
        echo '<td>';
        $path = 'uploads/sesion5/' . $row['id'];
        if (glob($path . '*')) {
            $arr = glob($path . '*');
            echo '<a href="' . $arr[0] . '">Ver archivo</a>';

        }
        echo '
                      <form action="upload.php" method="post" enctype="multipart/form-data">
                          Select image to upload:
                          <input type="hidden" name="Sesion5" value="Sesion5" />
                          <input type="hidden" name="redirect" value="sesion5" />
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
$row = $stmt->fetch(PDO::FETCH_ASSOC);
echo '<form method="post" action="' . htmlspecialchars($_SERVER["PHP_SELF"]) . '"  >';
echo '<div class="group_container">';
echo '<input type="hidden" name="dicc" value="" />';
echo '<h4 class="titulo_informe">Diccionario de problemas identificados en el grupo</h4>';
echo '<textarea rows="6" cols="150" name="inf_s5_dicc" class="informe_grupo"  >' . $row["inf_s5_dicc"] . ' </textarea></br>';
echo '<input class="button" type="submit" value="Enviar informe del grupo"/>';
echo '</div>';
echo '</form>';
echo '<form method="post" action="' . htmlspecialchars($_SERVER["PHP_SELF"]) . '"  >';
echo '<div class="group_container">';
echo '<input type="hidden" name="diario" value="" />';
echo '<h4 class="titulo_informe" >Diario de campo del taller sobre toma de decisiones</h4>';
echo '<textarea rows="6" cols="150" name="inf_s5_diario" class="informe_grupo"  >' . $row["inf_s5_diario"] . ' </textarea></br>';
echo '<input class="button" type="submit" value="Enviar informe del grupo"/>';
echo '</div>';
echo '</form>';
include_once("footer.php");
?>
