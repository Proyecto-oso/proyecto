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
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
      if (isset($_POST['informe_grupo'])) {
        $originales = array("'", '"');
        $correctos = array("\'", '\"');
        $_POST['inf_s7'] = str_replace($originales, $correctos, $_POST['inf_s7']);
        $query = 'UPDATE `grupo` SET `inf_s7` = "' . $_POST['inf_s7'] . '" WHERE `grupo`.`id` = ' . $_SESSION['grupo_id'] . '; ';
        $dbh->beginTransaction();
        $stmt = $dbh->prepare($query);
        $stmt->execute();
        $dbh->commit();
        echo '<script language="javascript">';
        echo 'alert("Guardado correctamente")';
        echo '</script>';
        echo '<script language="javascript">window.location="sesion7.php"</script>';
      }
    }




   ?>

    <?php


    $query = ' SELECT * FROM `grupo` WHERE id = ' . $_SESSION['grupo_id'] . ' ';
    $stmt = $dbh->prepare($query);
    $stmt->execute([$_SESSION['grupo_id']]);
    $rows = $stmt->fetchAll(PDO::FETCH_ASSOC);
    foreach ($rows as $row) {
      echo '<form method="post" action="' . htmlspecialchars($_SERVER["PHP_SELF"]) . '"  id="form_mrb" >';
      echo '<div class="group_container">';
      echo '<input type="hidden" name="informe_grupo" value="" />';
      echo '<p class="titulo_informe" >INFORME METAS, RECURSOS Y BARRERAS DEL GRUPO</p>';
      echo '<td><textarea rows="6" cols="150" name="inf_s7"  form="form_mrb" class="informe_grupo"  >' . $row["inf_s7"] . ' </textarea></td></br>';
      echo '<td><input class="button" type="submit" value="Enviar informe del grupo"/></td>';
      echo '</div>';
      echo '</form>';

    }



    ?>

</body>
<?php
echo '
<div style="margin-left: 30px;">
<h2>Lista asistencia</h2>';
$path = 'uploads/sesion7/lista'.$_SESSION['grupo_id'].'';
if (glob($path . '.*')) {
$arr = glob($path . '.*');
echo '<h3><a href="' . $arr[0] . '">Ver Lista</a></h3>';

}
echo '<form action="upload.php" method="post" enctype="multipart/form-data">
    Selecciona el archivo:
    <input type="hidden" name="Sesion7" value="Sesion7" />
    <input type="hidden" name="redirect" value="sesion7" />
    <input type="hidden" name="image_id" value="lista'.$_SESSION['grupo_id'].'" />
    <input class="fileToUpload" type="file" name="fileToUpload" id="fileToUpload">
    <input class="upload" type="submit" value="Subir archivo" name="submit">
</form>
</div>';

echo '
<div style="margin-left: 30px;">
<h2>Acta Sesión</h2>';
$path = 'uploads/sesion7/acta'.$_SESSION['grupo_id'].'';
if (glob($path . '.*')) {
$arr = glob($path . '.*');
echo '<h3><a href="' . $arr[0] . '">Ver Acta</a></h3>';

}
echo '<form action="upload.php" method="post" enctype="multipart/form-data">
    Selecciona el archivo:
    <input type="hidden" name="Sesion7" value="Sesion7" />
    <input type="hidden" name="redirect" value="sesion7" />
    <input type="hidden" name="image_id" value="acta" />
    <input type="hidden" name="image_id" value="acta'.$_SESSION['grupo_id'].'" />
    <input class="upload" type="submit" value="Subir archivo" name="submit">
</form>
</div>';

include_once("footer.php");
?>
