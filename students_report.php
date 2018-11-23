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
$count_todos_estudiantes = 0;
$count_estudiantes = 0;
$query = ' SELECT * FROM grupo';
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
                $aux = 0;
                foreach ($groups as $g) {
                    if ($aux == 13) {
                        echo '</div><div class="page">';
                        $aux = 0;
                    }
                    if ($g['nombre'] == "grupo de pruebas") {
                      continue;
                    }
                    $aux++;
                    $query = ' SELECT grupo.id, estudiantes.id, sesion_1.total_aptitud_matematica, sesion_1.total_aptitud_verbal FROM grupo INNER JOIN estudiantes Inner join sesion_1 on grupo.id=estudiantes.grupo_id and estudiantes.id=sesion_1.id_estudiante where grupo.id=?';
                    //echo $query;
                    $stmt = $dbh->prepare($query);
                    $stmt->execute([$g['id']]);
                    $rows = $stmt->fetchAll(PDO::FETCH_ASSOC);
                    foreach ($rows as $row) {
                      if ($row['total_aptitud_verbal'] != 0 && $row['total_aptitud_matematica'] != 0) {
                        // code...
                        $count_grupo++;
                      }
                        $count_estudiantes++;
                    }
                    //echo $count_grupo.','.$suma_v_grupo.'<br>';
                    echo '<b> ' . $g['nombre'] . '</b><br>';
                    if ($count_grupo != 0) {
                        echo 'total estduiantes en el grupo: ' . $count_estudiantes . '<br> porcentaje que ha ingresado: ' . number_format($count_grupo/$count_estudiantes, 3) . '<br>';
                    } else {
                        echo 'no ha sido diligenciado aun <br>';
                    }
                    $count_grupo = 0;
                    $count_estudiantes = 0;
                }

                ?>
            </div>
    <div class="page">
        <div class="titulo"><h2>INFORME DE ORIENTACIÓN SOCIO OCUPACIONAL - SESIÓN 2</h2></div>
        <?php



        /*
          total_factor_tncf
          total_factor_paf
          total_factor_icppf
          total_factor_tivf
          total_eet_economico
          total_eet_laboral
          total_eet_familiar
          total_eet_vida
          total_eet_academico

        */
        $aux = 0;
        foreach ($groups as $g) {
          if ($aux == 13) {
              echo '</div><div class="page">';
              $aux = 0;
          }
          $aux++;
          if ($g['nombre'] == "grupo de pruebas") {
            continue;
          }

            $query = 'SELECT grupo.id, estudiantes.id, sesion_2.total_factor_tncf , sesion_2.total_factor_paf, sesion_2.total_factor_icppf, sesion_2.total_factor_tivf, sesion_2.total_eet_economico, sesion_2.total_eet_laboral, sesion_2.total_eet_familiar, sesion_2.total_eet_vida, sesion_2.total_eet_academico FROM grupo INNER JOIN estudiantes Inner join sesion_2 on grupo.id=estudiantes.grupo_id and estudiantes.id=sesion_2.id_estudiante where grupo.id=? ';
            //echo $query;
            $stmt = $dbh->prepare($query);
            $stmt->execute([$g['id']]);
            $rows = $stmt->fetchAll(PDO::FETCH_ASSOC);
            foreach ($rows as $row) {

              //suma todos
              if ($row['total_factor_tncf'] !=0 && $row['total_factor_paf']!=0 && $row['total_factor_icppf']!=0 && $row['total_factor_tivf']!=0 && $row['total_eet_economico']!=0 && $row['total_eet_laboral']!=0 && $row['total_eet_familiar']!=0 && $row['total_eet_vida']!=0 && $row['total_eet_academico']!=0 ) {
                $count_grupo++;
              }

              $count_estudiantes++;
            }
            //echo $count_grupo.','.$suma_v_grupo.'<br>';
            echo '<b> ' . $g['nombre'] . '</b><br>';
            if ($count_grupo != 0) {
                echo 'total estduiantes en el grupo: ' . $count_estudiantes . '<br> porcentaje que ha ingresado: ' . number_format($count_grupo/$count_estudiantes, 3) . '<br>';
            } else {
                echo 'no ha sido diligenciado aun <br>';
            }
            $count_grupo = 0;
            $count_estudiantes = 0;
          }
        ?>
    </div>
    <div class="page">
        <div class="titulo"><h2>INFORME DE ORIENTACIÓN SOCIO OCUPACIONAL - SESIÓN 3</h2></div>
        <?php

        $count_grupo = 0;
        $count_todos = 0;

        $aux = 0;
        foreach ($groups as $g) {
            if ($aux == 13) {
                echo '</div><div class="page">';
                $aux = 0;
            }
            if ($g['nombre'] == "grupo de pruebas") {
              continue;
            }
            $aux++;
            $query = ' SELECT grupo.id, estudiantes.id, sesion_3.t_activo, sesion_3.t_reflexivo, sesion_3.t_sensible, sesion_3.t_intuitivo, sesion_3.t_visual, sesion_3.t_verbal, sesion_3.t_secuencial, sesion_3.t_global FROM grupo INNER JOIN estudiantes Inner join sesion_3 on grupo.id=estudiantes.grupo_id and estudiantes.id=sesion_3.id_estudiante where grupo.id=?';
            //echo $query;
            $stmt = $dbh->prepare($query);
            $stmt->execute([$g['id']]);
            $rows = $stmt->fetchAll(PDO::FETCH_ASSOC);
            foreach ($rows as $row) {

              if ($row['t_activo'] != 0 && $row['t_reflexivo'] != 0 && $row['t_sensible'] != 0 && $row['t_intuitivo'] != 0 && $row['t_visual'] != 0 && $row['t_verbal'] !=0 && $row['t_secuencial'] != 0 && $row['t_global'] != 0 ) {
                // code...
                $count_grupo++;
              }
              $count_estudiantes++;
            }
            //echo $count_grupo.','.$suma_v_grupo.'<br>';
            echo '<b> ' . $g['nombre'] . '</b><br>';
            if ($count_grupo != 0) {
                echo 'total estduiantes en el grupo: ' . $count_estudiantes . '<br> porcentaje que ha ingresado: ' . number_format($count_grupo/$count_estudiantes, 3) . '<br>';
            } else {
                echo 'no ha sido diligenciado aun <br>';
            }
            $count_grupo = 0;
            $count_estudiantes = 0;
        }

        ?>
    </div>
    <div class="page">
        <div class="titulo"><h2>INFORME DE ORIENTACIÓN SOCIO OCUPACIONAL - SESIÓN 4</h2></div>
        <?php

        /*
          amigos
          familia
          otro
          total
        */

        $aux = 0;
        foreach ($groups as $g) {
          if ($aux == 13) {
              echo '</div><div class="page">';
              $aux = 0;
          }
          $aux++;
          if ($g['nombre'] == "grupo de pruebas") {
            continue;
          }
            $query = ' SELECT grupo.id, estudiantes.id, sesion_4.amigos, sesion_4.familia, sesion_4.otro, sesion_4.total FROM grupo INNER JOIN estudiantes Inner join sesion_4 on grupo.id=estudiantes.grupo_id and estudiantes.id=sesion_4.id_estudiante where grupo.id=?';
            //echo $query;
            $stmt = $dbh->prepare($query);
            $stmt->execute([$g['id']]);
            $rows = $stmt->fetchAll(PDO::FETCH_ASSOC);
            foreach ($rows as $row) {

              if ($row['amigos']!=0 && $row['familia'] != 0 && $row['otro'] != 0 && $row['total'] != 0 ) {
                // code...
                $count_grupo++;
              }
              $count_estudiantes++;
            }
            //echo $count_grupo.','.$suma_v_grupo.'<br>';
            echo '<b> ' . $g['nombre'] . '</b><br>';
            if ($count_grupo != 0) {
                echo 'total estduiantes en el grupo: ' . $count_estudiantes . '<br> porcentaje que ha ingresado: ' . number_format($count_grupo/$count_estudiantes, 3) . '<br>';
            } else {
                echo 'no ha sido diligenciado aun <br>';
            }
            $count_grupo = 0;
            $count_estudiantes = 0;
        }
      ?>
    </div>
    <div class="page">
    <div class="titulo"><h2>INFORME DE ORIENTACIÓN SOCIO OCUPACIONAL - SESIÓN 5</h2></div>
                <?php
                $aux = 0;
                foreach ($groups as $g) {
                    if ($aux == 20) {
                        echo '</div><div class="page">';
                        $aux = 0;
                    }
                    if ($g['nombre'] == "grupo de pruebas") {
                      continue;
                    }
                    $aux++;
                    $query = ' SELECT grupo.id, estudiantes.id, sesion_5.total FROM grupo INNER JOIN estudiantes Inner join sesion_5 on grupo.id=estudiantes.grupo_id and estudiantes.id=sesion_5.id_estudiante where grupo.id=? ';
                    //echo $query;
                    $stmt = $dbh->prepare($query);
                    $stmt->execute([$g['id']]);
                    $rows = $stmt->fetchAll(PDO::FETCH_ASSOC);
                    foreach ($rows as $row) {
                      if ($row['total'] != 0 && $row['total']!=0 ) {
                        // code...
                        $count_grupo++;
                      }
                      $count_estudiantes++;
                    }
                    //echo $count_grupo.','.$suma_v_grupo.'<br>';
                    echo '<b> ' . $g['nombre'] . '</b><br>';
                    if ($count_grupo != 0) {
                        echo 'total estduiantes en el grupo: ' . $count_estudiantes . '<br> porcentaje que ha ingresado: ' . number_format($count_grupo/$count_estudiantes, 3) . '<br>';
                    } else {
                        echo 'no ha sido diligenciado aun <br>';
                    }
                    $count_grupo = 0;
                    $count_estudiantes = 0;
                }
                ?>
            </div>
            <div class="page">
    <div class="titulo"><h2>INFORME DE ORIENTACIÓN SOCIO OCUPACIONAL - SESIÓN 6</h2></div>
                <?php
                $count_grupo = 0;
                $count_todos = 0;
                $aux = 0;
                foreach ($groups as $g) {
                    if ($aux == 20) {
                        echo '</div><div class="page">';
                        $aux = 0;
                    }
                    if ($g['nombre'] == "grupo de pruebas") {
                      continue;
                    }
                    $aux++;
                    $query = ' SELECT grupo.id, estudiantes.id, sesion_6.total FROM grupo INNER JOIN estudiantes Inner join sesion_6 on grupo.id=estudiantes.grupo_id and estudiantes.id=sesion_6.id_estudiante where grupo.id=? ';
                    //echo $query;
                    $stmt = $dbh->prepare($query);
                    $stmt->execute([$g['id']]);
                    $rows = $stmt->fetchAll(PDO::FETCH_ASSOC);
                    foreach ($rows as $row) {
                      if ($row['total'] != 0) {
                        // code...
                        $count_grupo++;
                      }
                      $count_estudiantes++;

                    }
                    //echo $count_grupo.','.$suma_v_grupo.'<br>';
                    echo '<b> ' . $g['nombre'] . '</b><br>';
                    if ($count_grupo != 0) {
                        echo 'total estduiantes en el grupo: ' . $count_estudiantes . '<br> porcentaje que ha ingresado: ' . number_format($count_grupo/$count_estudiantes, 3) . '<br>';
                    } else {
                        echo 'no ha sido diligenciado aun <br>';
                    }
                    $count_grupo = 0;
                    $count_estudiantes = 0;
                }

            ?>
            </div>
            <div class="page">
            <div class="titulo"><h2>INFORME DE ORIENTACIÓN SOCIO OCUPACIONAL - SESIÓN 7</h2></div>
                <?php
                $aux = 0;
                foreach ($groups as $g) {
                    if ($aux == 12) {
                        echo '</div><div class="page">';
                        $aux = 0;
                    }
                    if ($g['nombre'] == "grupo de pruebas") {
                      continue;
                    }
                    echo '<b> ' . $g['nombre'] . '</b><br>';
                    if ($g['inf_s7'] != '') {
                      // code...
                      echo 'Diligenciado<br>';
                    }else {
                      echo 'no ha sido diligenciado aun <br>';
                    }

                    $aux++;
                }
                ?>
            </div>
            <div class="page">
        <div class="titulo"><h2>INFORME DE ORIENTACIÓN SOCIO OCUPACIONAL - SESIÓN 8</h2></div>
        <?php

        $count_grupo = 0;
        $count_todos = 0;

        $aux = 0;
        foreach ($groups as $g) {
            if ($aux == 12) {
                echo '</div><div class="page">';
                $aux = 0;
            }
            if ($g['nombre'] == "grupo de pruebas") {
              continue;
            }
            $aux++;
            $query = ' SELECT grupo.id, estudiantes.id, sesion_8.temas_trabajados, sesion_8.ejercicios, sesion_8.tallerista, sesion_8.utilidad FROM grupo INNER JOIN estudiantes Inner join sesion_8 on grupo.id=estudiantes.grupo_id and estudiantes.id=sesion_8.id_estudiante where grupo.id=?';
            //echo $query;
            $stmt = $dbh->prepare($query);
            $stmt->execute([$g['id']]);
            $rows = $stmt->fetchAll(PDO::FETCH_ASSOC);
            foreach ($rows as $row) {
              if ($row['temas_trabajados'] != 0 && $row['ejercicios'] != 0 && $row['tallerista']!= 0 && $row['utilidad'] != 0) {
                // code...
                $count_grupo++;
              }
              $count_estudiantes++;

            }
            //echo $count_grupo.','.$suma_v_grupo.'<br>';
            echo '<b> ' . $g['nombre'] . '</b><br>';
            if ($count_grupo != 0) {
                echo 'total estduiantes en el grupo: ' . $count_estudiantes . '<br> porcentaje que ha ingresado: ' . number_format($count_grupo/$count_estudiantes, 3) . '<br>';
            } else {
                echo 'no ha sido diligenciado aun <br>';
            }
            $count_grupo = 0;
            $count_estudiantes = 0;
        }

      ?>
    </div>
</div>

</body>
