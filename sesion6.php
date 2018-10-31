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
    <link rel="stylesheet" type="text/css" href="styles/sesion6.css">
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
            $query = ' SELECT * FROM sesion_6 WHERE id_estudiante = ? ';
            $stmt = $dbh->prepare($query);
            $stmt->execute([$id]);
            $s = $stmt->fetch(PDO::FETCH_ASSOC);
            $est["est$id"] = $s;
        }
        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            if (isset($_POST['diario'])) {
                $originales = array("'", '"');
                $correctos = array("\'", '\"');
                $_POST['inf_s6_diario'] = str_replace($originales, $correctos, $_POST['inf_s6_diario']);
                $query = 'UPDATE `grupo` SET `inf_s6_diario` = "' . $_POST['inf_s6_diario'] . '" WHERE `grupo`.`id` = ' . $_SESSION['grupo_id'] . '; ';
                $dbh->beginTransaction();
                $stmt = $dbh->prepare($query);
                $stmt->execute();
                $dbh->commit();
                echo '<script language="javascript">';
                echo 'alert("Guardado correctamente")';
                echo '</script>';
                echo '<script language="javascript">window.location="sesion6.php"</script>';
            } else {
                $originales = array("'", '"');
                $correctos = array("\'", '\"');
                foreach ($rows as $row) {
                    $id = $row['id'];
                    if (isset($_POST['id_ses' . $id])) {
                        $query = 'UPDATE `sesion_6` SET';
                        for ($i = 1; $i <= 10; $i++) {
                            if (isset($_POST[$id . '_item_' . $i])) {
                                $query .= '`item_' . $i . '`=' . $_POST[$id . '_item_' . $i] . ',';
                                $est["est$id"]["item_$i"] = $_POST[$id . '_item_' . $i];
                            } else {
                                $query .= '`item_' . $i . '`=' . '-1' . ',';
                                $est["est$id"]["item_$i"] = -1;
                            }
                        }
                        $query .= '`total`=' . $_POST[$id . '_total'] . ',';
                        $est["est$id"]["total"] = $_POST[$id . '_total'];
                        
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
                            if (strpos($e->getMessage(), 'Incorrect integer value')) {
                                echo '<script language="javascript">';
                                echo 'alert("ERROR: el total debe ser un número")';
                                echo '</script>';
                            }
                        }
                    } else {
                        $query = 'INSERT INTO `sesion_6`(`id_estudiante`, `item_1`, `item_2`, `item_3`, `item_4`, `item_5`, `item_6`, `item_7`, `item_8`, `item_9`, `item_10`,`total`, `observaciones`) VALUES (';
                        $query .= $row["id"] . ',';
                        for ($i = 1; $i <= 10; $i++) {
                            if (isset($_POST[$id . '_item_' . $i])) {
                                $query .= '' . $_POST[$id . '_item_' . $i] . ',';
                                $est["est$id"]["item_$i"] = $_POST[$id . '_item_' . $i];
                            } else {
                                $query .= '-1' . ',';
                                $est["est$id"]["item_$i"] = -1;
                            }
                        }
                        $query .= '' . $_POST[$id . '_total'] . ',';
                        $est["est$id"]["total"] = $_POST[$id . '_total'];
                        
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
                echo '<script language="javascript">window.location="sesion6.php"</script>';
            }

        } ?>
     <form id="form1" method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>"></form>
     <div class="tb-container">
    <table class="table" style="float: left;" >
    <thead>
    <tr class="titles">
    <th >Nombre</th>
    <th >Item 1</th>
    <th >Item 2</th>
    <th >Item 3</th>
    <th >Item 4</th>
    <th >Item 5</th>
    <th >Item 6</th>
    <th >Item 7</th>
    <th >Item 8</th>
    <th >Item 9</th>
    <th >Item 10</th>
    <th >Puntaje total</th>
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
            $items = [null, null, null, null, null, null, null, null, null, null];

            for ($i = 1; $i <= 10; $i++) {
                  //echo '<td><input class="in" type="number" name="items_' . ($i + 1) . '" value="" /></td>';
                ?>

            <td class="radio-cont">
                
              <?php echo '<input type="radio" form="form1" class="radioBttn" name= "' . $id . '_item_' . $i . '"'; ?>  <?php if (isset($items[$i - 1]) && $items[$i - 1] == "1") echo "checked"; ?> value="1">Incorrecto</br>
              <?php echo '<input type="radio" form="form1" class="radioBttn" name= "' . $id . '_item_' . $i . '"'; ?>  <?php if (isset($items[$i - 1]) && $items[$i - 1] == "2") echo "checked"; ?> value="2">Apenas cierto</br>
              <?php echo '<input type="radio" form="form1" class="radioBttn" name= "' . $id . '_item_' . $i . '"'; ?>  <?php if (isset($items[$i - 1]) && $items[$i - 1] == "3") echo "checked"; ?> value="3">Mas bien cierto</br>
              <?php echo '<input type="radio" form="form1" class="radioBttn" name= "' . $id . '_item_' . $i . '"'; ?>  <?php if (isset($items[$i - 1]) && $items[$i - 1] == "4") echo "checked"; ?> value="4">Cierto
            </td>
            <?php

        }

        echo '<td><input class="in" type="number" name="' . $id . '_total" value="0" form="form1"/></td>';
        echo '<td><textarea rows="8" cols="40" name="' . $id . '_observaciones" form="form1"> </textarea></td>';
        echo '<input type="hidden" name="name" value="' . $row['nombre'] . '" form="form1"/>';
        echo '<input type="hidden" name="id" value="' . $row['id'] . '" form="form1"/>';
           // echo '<td><input class="button" type="submit" value="Enviar"/></td>';
           // echo '</form>';
    } else {
            //echo '<form method="post" action="' . htmlspecialchars($_SERVER["PHP_SELF"]) . '" id="form_' . $s['id_estudiante'] . '" >';
        $items = [null, null, null, null, null, null, null, null, null, null];


        for ($i = 1; $i <= 10; $i++) {
            $items[$i - 1] = $s["item_$i"];
                  //echo '<td><input class="in" type="number" name="items_' . ($i + 1) . '" value="" /></td>';
            ?>

            <td class="radio-cont">
                
                <?php echo '<input type="radio" form="form1" class="radioBttn" name= "' . $id . '_item_' . $i . '"'; ?>  <?php if (isset($items[$i - 1]) && $items[$i - 1] == "1") echo "checked"; ?> value="1">Incorrecto</br>
                <?php echo '<input type="radio" form="form1" class="radioBttn" name= "' . $id . '_item_' . $i . '"'; ?>  <?php if (isset($items[$i - 1]) && $items[$i - 1] == "2") echo "checked"; ?> value="2">Apenas cierto</br>
                <?php echo '<input type="radio" form="form1" class="radioBttn" name= "' . $id . '_item_' . $i . '"'; ?>  <?php if (isset($items[$i - 1]) && $items[$i - 1] == "3") echo "checked"; ?> value="3">Mas bien cierto</br>
                <?php echo '<input type="radio" form="form1" class="radioBttn" name= "' . $id . '_item_' . $i . '"'; ?>  <?php if (isset($items[$i - 1]) && $items[$i - 1] == "4") echo "checked"; ?> value="4">Cierto
              </td>
            <?php

        }



        echo '<td><input class="in" type="number" name="' . $id . '_total" value="' . $s["total"] . '" form="form1"/></td>';
        echo '<td><textarea rows="8" cols="40" name="' . $id . '_observaciones" form="form1">' . $s["observaciones"] . ' </textarea></td>';
        echo '<input type="hidden" name="name" value="' . $row['nombre'] . '" form="form1"/>';
        echo '<input type="hidden" name="id" value="' . $row['id'] . '" form="form1"/>';
        echo '<input type="hidden" name="id_ses' . $s['id_estudiante'] . '" value="' . $s['id_estudiante'] . '" form="form1"/>';
            //echo '<td><input class="button" type="submit" value="Enviar"/></td>';
            //echo '</form>';

    }
    echo '<td>';
    $path = 'uploads/sesion6/' . $row['id'];
    if (glob($path . '.*')) {
        $arr = glob($path . '.*');
        echo '<a href="' . $arr[0] . '">Ver archivo</a>';

    }
    echo '
                      <form action="upload.php" method="post" enctype="multipart/form-data">
                          Select image to upload:
                          <input type="hidden" name="Sesion6" value="Sesion6" />
                          <input type="hidden" name="redirect" value="sesion6" />
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
echo '<input type="hidden" name="diario" value="" />';
echo '<h4 class="titulo_informe" >Diario de campo del taller sobre resolución de problemas</h4>';
echo '<textarea rows="8" cols="150" name="inf_s6_diario" class="informe_grupo"  >' . $row["inf_s6_diario"] . ' </textarea></br>';
echo '<input class="button" type="submit" value="Enviar informe del grupo"/>';
echo '</div>';
echo '</form>';
include_once("footer.php");
?>
