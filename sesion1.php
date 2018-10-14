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
    <title>Proyecto Psicologia</title>
<style>
<?php include('styles/Index.css'); ?>
</style>
</head>
<body>
    <?php
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        if (isset($_POST['id_ses'])) {
            $query = 'UPDATE `sesion_1` SET';
            for ($i = 1; $i <= 15; $i++) {
                $query .= '`aptitud_verbal_' . $i . '`="' . $_POST["aptitud_verbal_$i"] . '",';

            }
            $query .= '`total_aptitud_verbal`="' . $_POST["total_aptitud_verbal"] . '",';
            for ($i = 1; $i <= 15; $i++) {
                $query .= '`aptitud_matematica_' . $i . '`="' . $_POST["aptitud_matematica_$i"] . '",';
            }
            $query .= '`total_aptitud_matematica`="' . $_POST["total_aptitud_matematica"] . '",';
            $query .= '`informe_via` = "' . $_POST["informe_via"] . '" WHERE id_estudiante=' . $_POST['id_ses'] . ' ';
            //We start our transaction.
            $dbh->beginTransaction();

            try {
                $stmt = $dbh->prepare($query);
                $stmt->execute();
                $dbh->commit();
                echo '<script language="javascript">';
                echo 'alert("Guardado correctamente")';
                echo '</script>';
                echo '<script language="javascript">window.location="sesion1.php"</script>';

            } catch (Exception $e) {
                $dbh->rollBack();
                if (strpos($e->getMessage(), 'Incorrect integer value')) {
                    echo '<script language="javascript">';
                    echo 'alert("ERROR: el total debe ser un número")';
                    echo '</script>';
                    echo '<script language="javascript">window.location="sesion1.php"</script>';
                }/*else{
                    echo '<script language="javascript">';
                    echo 'alert("'.$e->getMessage().'")';
                    echo '</script>';
                    echo '<script language="javascript">window.location="sesion1.php"</script>';
                }*/
                if (strpos($e->getMessage(), ' Data too long for column')) {
                    echo '<script language="javascript">';
                    echo 'alert("ERROR: debe ser unicamente un caracter")';
                    echo '</script>';
                    echo '<script language="javascript">window.location="sesion1.php"</script>';
                }
            }
        } else {

            $query = 'INSERT INTO `sesion_1`(`id_estudiante`,`aptitud_verbal_1`, `aptitud_verbal_2`, `aptitud_verbal_3`, `aptitud_verbal_4`, `aptitud_verbal_5`, `aptitud_verbal_6`, `aptitud_verbal_7`, `aptitud_verbal_8`, `aptitud_verbal_9`, `aptitud_verbal_10`, `aptitud_verbal_11`, `aptitud_verbal_12`, `aptitud_verbal_13`, `aptitud_verbal_14`, `aptitud_verbal_15`, `aptitud_matematica_1`, `aptitud_matematica_2`, `aptitud_matematica_3`, `aptitud_matematica_4`, `aptitud_matematica_5`, `aptitud_matematica_6`, `aptitud_matematica_7`, `aptitud_matematica_8`, `aptitud_matematica_9`, `aptitud_matematica_10`, `aptitud_matematica_11`, `aptitud_matematica_12`, `aptitud_matematica_13`, `aptitud_matematica_14`, `aptitud_matematica_15`, `total_aptitud_matematica`, `total_aptitud_verbal`, `informe_via`) VALUES (';
            $query .= $_POST["id"] . ',';
            for ($i = 1; $i <= 15; $i++) {
                $query .= '"' . $_POST["aptitud_verbal_$i"] . '",';

            }
            for ($i = 1; $i <= 15; $i++) {
                $query .= '"' . $_POST["aptitud_matematica_$i"] . '",';
            }
            $query .= '"' . $_POST["total_aptitud_matematica"] . '",';
            $query .= '"' . $_POST["total_aptitud_verbal"] . '",';
            $query .= '"' . $_POST["informe_via"] . '") ';
            //We start our transaction.
            $dbh->beginTransaction();

            try {
                $stmt = $dbh->prepare($query);
                $stmt->execute();
                $dbh->commit();
                echo '<script language="javascript">';
                echo 'alert("Guardado correctamente")';
                echo '</script>';
                echo '<script language="javascript">window.location="sesion1.php"</script>';

            } catch (Exception $e) {
                $dbh->rollBack();
                if (strpos($e->getMessage(), 'Incorrect integer value')) {
                    echo '<script language="javascript">';
                    echo 'alert("ERROR: el total debe ser un número")';
                    echo '</script>';
                    echo '<script language="javascript">window.location="sesion1.php"</script>';
                }/*else{
                    echo '<script language="javascript">';
                    echo 'alert("'.$e->getMessage().'")';
                    echo '</script>';
                    echo '<script language="javascript">window.location="sesion1.php"</script>';
                }*/
                if (strpos($e->getMessage(), ' Data too long for column')) {
                    echo '<script language="javascript">';
                    echo 'alert("ERROR: debe ser unicamente un caracter")';
                    echo '</script>';
                    echo '<script language="javascript">window.location="sesion1.php"</script>';
                }
            }
        }

    } else { ?>
    <div class="flow-container">

    <table class="tb">
    <tr>
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
    <th>INFORME VIA</th>
    <th>GUARDAR</th>
    </tr>
    <?php
    $query = ' SELECT * FROM estudiantes WHERE grupo_id = ? ';
    $stmt = $dbh->prepare($query);
    $stmt->execute([$_SESSION['grupo_id']]);
    $rows = $stmt->fetchAll(PDO::FETCH_ASSOC);
    foreach ($rows as $row) {
        $id = $row['id'];
        $query = ' SELECT * FROM sesion_1 WHERE id_estudiante = ? ';
        $stmt = $dbh->prepare($query);
        $stmt->execute([$id]);
        $s = $stmt->fetch(PDO::FETCH_ASSOC);
        echo ' <tr>
                <th> ' . $row['nombre'] . ' </th> ';
        if (!isset($s['id_estudiante'])) {
            echo ' <form method = "post" action = "' . htmlspecialchars($_SERVER["PHP_SELF"]) . '">';
            for ($i = 0; $i < 15; $i++) {
                echo '<td><input class="in" type="text" name="aptitud_verbal_' . ($i + 1) . '" value="" /></td>';
            }
            echo '<td><input class="in" type="text" name="total_aptitud_verbal" value="0" /></td>';
            for ($i = 0; $i < 15; $i++) {
                echo '<td><input class="in" type="text" name="aptitud_matematica_' . ($i + 1) . '" value="" /></td>';
            }
            echo '<td><input class="in" type="text" name="total_aptitud_matematica" value="0" /></td>';
            echo '<td><input class="inf" type="text" name="informe_via" value="" /></td>';
            echo '<input type="hidden" name="name" value="' . $row['nombre'] . '" />';
            echo '<input type="hidden" name="id" value="' . $row['id'] . '" />';
            echo '<td><input type="submit" value="Enviar"/></td>';
            echo '</form>';
        } else {
            echo '<form method="post" action="' . htmlspecialchars($_SERVER["PHP_SELF"]) . '">';
            for ($i = 1; $i <= 15; $i++) {
                echo '<td><input class="in" type="text" name="aptitud_verbal_' . $i . '" value="' . $s["aptitud_verbal_$i"] . '" /></td>';
            }
            echo '<td><input class="in" type="text" name="total_aptitud_verbal" value="' . $s["total_aptitud_verbal"] . '" /></td>';
            for ($i = 1; $i <= 15; $i++) {
                echo '<td><input class="in" type="text" name="aptitud_matematica_' . $i . '" value="' . $s["aptitud_matematica_$i"] . '" /></td>';
            }
            echo '<input type="hidden" name="name" value="' . $row['nombre'] . '" />';
            echo '<input type="hidden" name="id" value="' . $row['id'] . '" />';
            echo '<input type="hidden" name="id_ses" value="' . $s['id_estudiante'] . '" />';
            echo '<td><input class="in" type="text" name="total_aptitud_matematica" value="' . $s["total_aptitud_matematica"] . '" /></td>';
            echo '<td><input class="inf" type="text" name="informe_via" value="' . $s["informe_via"] . '" /></td>';
            echo '<td><input type="submit" value="Enviar"/></td>';
            echo '</form>';
            /*?>
            <td><input type="text" name="aptitud_verbal_1" value="<?php $s['aptitud_verbal_1']?>" /></td>
            <td><input type="text" name="aptitud_verbal_2" value="<?php $s['aptitud_verbal_2']?>" /></td>
            <td><input type="text" name="aptitud_verbal_3" value="<?php $s['aptitud_verbal_3']?>" /></td>
            <td><input type="text" name="aptitud_verbal_4" value="<?php $s['aptitud_verbal_4']?>" /></td>
            <td><input type="text" name="aptitud_verbal_5" value="<?php $s['aptitud_verbal_5']?>" /></td>
            <td><input type="text" name="aptitud_verbal_6" value="<?php $s['aptitud_verbal_6']?>" /></td>
            <td><input type="text" name="aptitud_verbal_7" value="<?php $s['aptitud_verbal_7']?>" /></td>
            <td><input type="text" name="aptitud_verbal_8" value="<?php $s['aptitud_verbal_8']?>" /></td>
            <td><input type="text" name="aptitud_verbal_9" value="<?php $s['aptitud_verbal_9']?>" /></td>
            <td><input type="text" name="aptitud_verbal_10" value="<?php $s['aptitud_verbal_10']?>" /></td>
            <td><input type="text" name="aptitud_verbal_11" value="<?php $s['aptitud_verbal_11']?>" /></td>
            <td><input type="text" name="aptitud_verbal_12" value="<?php $s['aptitud_verbal_12']?>" /></td>
            <td><input type="text" name="aptitud_verbal_13" value="<?php $s['aptitud_verbal_13']?>" /></td>
            <td><input type="text" name="aptitud_verbal_14" value="<?php $s['aptitud_verbal_14']?>" /></td>
            <td><input type="text" name="aptitud_verbal_15" value="<?php $s['aptitud_verbal_15']?>" /></td>
            <td><input type="text" name="total_aptitud_verbal" value="<?php $s['total_aptitud_verbal']?>" /></td>
            <td><input type="text" name="aptitud_matematica_1" value="<?php $s['aptitud_matematica_1']?>" /></td>
            <td><input type="text" name="aptitud_matematica_2" value="<?php $s['aptitud_matematica_2']?>" /></td>
            <td><input type="text" name="aptitud_matematica_3" value="<?php $s['aptitud_matematica_3']?>" /></td>
            <td><input type="text" name="aptitud_matematica_4" value="<?php $s['aptitud_matematica_4']?>" /></td>
            <td><input type="text" name="aptitud_matematica_5" value="<?php $s['aptitud_matematica_5']?>" /></td>
            <td><input type="text" name="aptitud_matematica_6" value="<?php $s['aptitud_matematica_6']?>" /></td>
            <td><input type="text" name="aptitud_matematica_7" value="<?php $s['aptitud_matematica_7']?>" /></td>
            <td><input type="text" name="aptitud_matematica_8" value="<?php $s['aptitud_matematica_8']?>" /></td>
            <td><input type="text" name="aptitud_matematica_9" value="<?php $s['aptitud_matematica_9']?>" /></td>
            <td><input type="text" name="aptitud_matematica_10" value="<?php $s['aptitud_matematica_10']?>" /></td>
            <td><input type="text" name="aptitud_matematica_11" value="<?php $s['aptitud_matematica_11']?>" /></td>
            <td><input type="text" name="aptitud_matematica_12" value="<?php $s['aptitud_matematica_12']?>" /></td>
            <td><input type="text" name="aptitud_matematica_13" value="<?php $s['aptitud_matematica_13']?>" /></td>
            <td><input type="text" name="aptitud_matematica_14" value="<?php $s['aptitud_matematica_14']?>" /></td>
            <td><input type="text" name="aptitud_matematica_15" value="<?php $s['aptitud_matematica_15']?>" /></td>
            <td><input type="text" name="total_aptitud_matematica" value="<?php $s['total_aptitud_matematica']?>" /></td>
            <td><input type="text" name="informe_via" value="<?php $s['informe_via']?>" /></td>
        <?php*/
        }
        echo '</tr>';
    }


    ?>
    </table>
    </form>
    </div>
</body>
<?php

}
include_once("footer.php");
?>