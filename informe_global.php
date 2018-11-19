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
    <link rel="stylesheet" type="text/css" href="styles/test.css">
    <link rel="stylesheet" type="text/css" href="styles/test.css" media="print">
    <title>Proyecto Psicologia</title>
</head>
<?php 
$count_grupo = 0;
$count_todos = 0;
$query = ' SELECT id,nombre FROM grupo';
$stmt = $dbh->prepare($query);
$stmt->execute();
$groups = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>
<body>
<div class="container">
    <div class="page">
                <div class="img-header">
                <img src="uploads/informe header.png" >
                </div>
                <br>
                <div class="titulo"><h2>INFORME DE ORIENTACIÓN SOCIO OCUPACIONAL - SESIÓN 1</h2></div>
                <?php 
                $suma_v_todos = 0;
                $suma_m_todos = 0;
                $suma_v_grupo = 0;
                $suma_m_grupo = 0;
                foreach ($groups as $g) {

                    $query = ' SELECT grupo.id, estudiantes.id, sesion_1.total_aptitud_matematica, sesion_1.total_aptitud_verbal FROM grupo INNER JOIN estudiantes Inner join sesion_1 on grupo.id=estudiantes.grupo_id and estudiantes.id=sesion_1.id_estudiante where grupo.id=?';
                    //echo $query;
                    $stmt = $dbh->prepare($query);
                    $stmt->execute([$g['id']]);
                    $rows = $stmt->fetchAll(PDO::FETCH_ASSOC);
                    foreach ($rows as $row) {
                        $suma_v_todos += $row['total_aptitud_verbal'];
                        $suma_m_todos += $row['total_aptitud_matematica'];
                        $suma_v_grupo += $row['total_aptitud_verbal'];
                        $suma_m_grupo += $row['total_aptitud_matematica'];
                        $count_grupo++;
                        $count_todos++;
                    }
                    //echo $count_grupo.','.$suma_v_grupo.'<br>';
                    if ($count_grupo != 0) {
                        $total_verbal_grupo = $suma_v_grupo / $count_grupo;
                        $total_matematica_grupo = $suma_m_grupo / $count_grupo;
                        echo 'grupo: ' . $g['nombre'] . '    total verbal: ' . $total_verbal_grupo . ', total matematico: ' . $total_matematica_grupo . '<br>';
                    } else {
                        echo 'grupo: ' . $g['nombre'] . 'no ha sido diligenciado aun <br>';
                    }
                    $count_grupo = 0;
                    $suma_v_grupo = 0;
                    $suma_m_grupo = 0;
                }
                $total_verbal_estudiantes = $suma_v_todos / $count_todos;
                $total_matematica_estudiantes = $suma_m_todos / $count_todos;

                echo $total_verbal_estudiantes . ',' . $total_matematica_estudiantes;

                $total_verbal_estudiantes = 0;
                $total_matematica_estudiantes = 0;
                ?>
            </div>
    <div class="page">
        <div class="titulo"><h2>INFORME DE ORIENTACIÓN SOCIO OCUPACIONAL - SESIÓN 2</h2></div>
        <?php 
        foreach ($groups as $g) {

            $query = ' SELECT grupo.id, estudiantes.id, sesion_1.total_aptitud_matematica, sesion_1.total_aptitud_verbal FROM grupo INNER JOIN estudiantes Inner join sesion_1 on grupo.id=estudiantes.grupo_id and estudiantes.id=sesion_1.id_estudiante where grupo.id=?';
            //echo $query;
            $stmt = $dbh->prepare($query);
            $stmt->execute([$g['id']]);
            $rows = $stmt->fetchAll(PDO::FETCH_ASSOC);
            foreach ($rows as $row) {
                $suma_v_todos += $row['total_aptitud_verbal'];
                $suma_m_todos += $row['total_aptitud_matematica'];
                $suma_v_grupo += $row['total_aptitud_verbal'];
                $suma_m_grupo += $row['total_aptitud_matematica'];
                $count_grupo++;
                $count_todos++;
            }
            //echo $count_grupo.','.$suma_v_grupo.'<br>';
            if ($count_grupo != 0) {
                $total_verbal_grupo = $suma_v_grupo / $count_grupo;
                $total_matematica_grupo = $suma_m_grupo / $count_grupo;
                echo 'grupo: ' . $g['nombre'] . '    total verbal: ' . $total_verbal_grupo . ', total matematico: ' . $total_matematica_grupo . '<br>';
            } else {
                echo 'grupo: ' . $g['nombre'] . 'no ha sido diligenciado aun <br>';
            }
            $count_grupo = 0;
            $suma_v_grupo = 0;
            $suma_m_grupo = 0;
        }
        $total_verbal_estudiantes = $suma_v_todos / $count_todos;
        $total_matematica_estudiantes = $suma_m_todos / $count_todos;

        echo $total_verbal_estudiantes . ',' . $total_matematica_estudiantes;
        ?>
    </div>
</div>

</body>
