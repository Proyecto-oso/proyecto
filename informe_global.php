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
                $suma_v_todos = 0;
                $suma_m_todos = 0;
                $suma_v_grupo = 0;
                $suma_m_grupo = 0;
                $count_grupo_v = 0;
                $count_todos_v = 0;
                $count_grupo_m = 0;
                $count_todos_m = 0;
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
                        if ($row['total_aptitud_verbal'] != -1) {
                            $suma_v_todos += $row['total_aptitud_verbal'];
                            $suma_v_grupo += $row['total_aptitud_verbal'];
                            $count_todos_v++;
                            $count_grupo_v++;
                        }
                        if ($row['total_aptitud_matematica'] != -1) {
                            $suma_m_todos += $row['total_aptitud_matematica'];
                            $suma_m_grupo += $row['total_aptitud_matematica'];
                            $count_todos_m++;
                            $count_grupo_m++;
                        }
                        $count_grupo++;
                        $count_todos++;
                    }
                    //echo $count_grupo.','.$suma_v_grupo.'<br>';
                    echo '<b> ' . $g['nombre'] . '</b><br>';
                    if ($count_grupo != 0) {
                        $total_verbal_grupo = $suma_v_grupo / $count_grupo_v;
                        $total_matematica_grupo = $suma_m_grupo / $count_grupo_m;
                        echo 'total verbal: ' . number_format($total_verbal_grupo, 3) . '<br> total matematico: ' . number_format($total_matematica_grupo, 3) . '<br><br><br>';
                    } else {
                        echo 'no ha sido diligenciado aun <br><br><br>';
                    }
                    $count_grupo = 0;
                    $count_grupo_v = 0;
                    $count_grupo_m = 0;
                    $suma_v_grupo = 0;
                    $suma_m_grupo = 0;
                }
                $total_verbal_estudiantes = $suma_v_todos / $count_todos_v;
                $total_matematica_estudiantes = $suma_m_todos / $count_todos_m;

                echo '<b>Todos los participantes</b><br>';
                echo $total_verbal_estudiantes . '<br>' . $total_matematica_estudiantes.'<br><br><br>';

                $total_verbal_estudiantes = 0;
                $total_matematica_estudiantes = 0;
                ?>
            </div>
    <div class="page">
        <div class="titulo"><h2>INFORME DE ORIENTACIÓN SOCIO OCUPACIONAL - SESIÓN 2</h2></div>
        <?php

        //****************************
        $suma_total_factor_tncf_todos = 0;
        $suma_total_factor_paf_todos = 0;
        $suma_total_factor_icppf_todos = 0;
        $suma_total_factor_tivf_todos = 0;
        $suma_total_eet_economico_todos = 0;
        $suma_total_eet_laboral_todos = 0;
        $suma_total_eet_familiar_todos = 0;
        $suma_total_eet_vida_todos = 0;
        $suma_total_eet_academico_todos = 0;

        //*****************************
        $suma_total_factor_tncf_grupo = 0;
        $suma_total_factor_paf_grupo = 0;
        $suma_total_factor_icppf_grupo = 0;
        $suma_total_factor_tivf_grupo = 0;
        $suma_total_eet_economico_grupo = 0;
        $suma_total_eet_laboral_grupo = 0;
        $suma_total_eet_familiar_grupo = 0;
        $suma_total_eet_vida_grupo = 0;
        $suma_total_eet_academico_grupo = 0;

        //****************************
        $count_factor_tncf_todos = 0;
        $count_factor_paf_todos = 0;
        $count_factor_icppf_todos = 0;
        $count_factor_tivf_todos = 0;
        $count_eet_economico_todos = 0;
        $count_eet_laboral_todos = 0;
        $count_eet_familiar_todos = 0;
        $count_eet_vida_todos = 0;
        $count_eet_academico_todos = 0;

        //*****************************
        $count_factor_tncf_grupo = 0;
        $count_factor_paf_grupo = 0;
        $count_factor_icppf_grupo = 0;
        $count_factor_tivf_grupo = 0;
        $count_eet_economico_grupo = 0;
        $count_eet_laboral_grupo = 0;
        $count_eet_familiar_grupo = 0;
        $count_eet_vida_grupo = 0;
        $count_eet_academico_grupo = 0;




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
            if ($aux == 1) {
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
                if ($row['total_factor_tncf'] != -1) {
                    $suma_total_factor_tncf_todos += $row['total_factor_tncf'];
                    $suma_total_factor_tncf_grupo += $row['total_factor_tncf'];
                    $count_factor_tncf_grupo++;
                    $count_factor_tncf_todos++;
                }
                if ($row['total_factor_paf'] != -1) {
                    $suma_total_factor_paf_todos += $row['total_factor_paf'];
                    $suma_total_factor_paf_grupo += $row['total_factor_paf'];
                    $count_factor_paf_grupo++;
                    $count_factor_paf_todos++;

                }
                if ($row['total_factor_icppf'] != -1) {
                    $suma_total_factor_icppf_todos += $row['total_factor_icppf'];
                    $suma_total_factor_icppf_grupo += $row['total_factor_icppf'];
                    $count_factor_icppf_grupo++;
                    $count_factor_icppf_todos++;

                }
                if ($row['total_factor_tivf'] != -1) {
                    $suma_total_factor_tivf_todos += $row['total_factor_tivf'];
                    $suma_total_factor_tivf_grupo += $row['total_factor_tivf'];
                    $count_factor_tivf_grupo++;
                    $count_factor_tivf_todos++;
                }
                if ($row['total_eet_economico'] != -1) {
                    $suma_total_eet_economico_todos += $row['total_eet_economico'];
                    $suma_total_eet_economico_grupo += $row['total_eet_economico'];
                    $count_eet_economico_grupo++;
                    $count_eet_economico_todos++;

                }
                if ($row['total_eet_laboral'] != -1) {
                    $suma_total_eet_laboral_todos += $row['total_eet_laboral'];
                    $suma_total_eet_laboral_grupo += $row['total_eet_laboral'];
                    $count_eet_laboral_grupo++;
                    $count_eet_laboral_todos++;

                }
                if ($row['total_eet_familiar'] != -1) {
                    $suma_total_eet_familiar_todos += $row['total_eet_familiar'];
                    $suma_total_eet_familiar_grupo += $row['total_eet_familiar'];
                    $count_eet_familiar_grupo++;
                    $count_eet_familiar_todos++;
                }
                if ($row['total_eet_vida'] != -1) {
                    $suma_total_eet_vida_todos += $row['total_eet_vida'];
                    $suma_total_eet_vida_grupo += $row['total_eet_vida'];
                    $count_eet_vida_grupo++;
                    $count_eet_vida_todos++;
                }
                if ($row['total_eet_academico'] != -1) {
                    $suma_total_eet_academico_todos += $row['total_eet_academico'];
                    $suma_total_eet_academico_grupo += $row['total_eet_academico'];
                    $count_eet_academico_grupo++;
                    $count_eet_academico_todos++;

                }
                $count_grupo++;
                $count_todos++;
            }

            //echo $count_grupo.','.$suma_v_grupo.'<br>';
            if ($count_grupo != 0) {

                $total_factor_tncf_grupo = $suma_total_factor_tncf_grupo / $count_factor_tncf_grupo;
                $total_factor_paf_grupo = $suma_total_factor_paf_grupo / $count_factor_paf_grupo;
                $total_factor_icppf_grupo = $suma_total_factor_icppf_grupo / $count_factor_icppf_grupo;
                $total_factor_tivf_grupo = $suma_total_factor_tivf_grupo / $count_factor_tivf_grupo;
                $total_eet_economico_grupo = $suma_total_eet_economico_grupo / $count_eet_economico_grupo;
                $total_eet_laboral_grupo = $suma_total_eet_laboral_grupo / $count_eet_laboral_grupo;
                $total_eet_familiar_grupo = $suma_total_eet_familiar_grupo / $count_eet_familiar_grupo;
                $total_eet_vida_grupo = $suma_total_eet_vida_grupo / $count_eet_vida_grupo;
                $total_eet_academico_grupo = $suma_total_eet_academico_grupo / $count_eet_academico_grupo;

                echo '<b> ' . $g['nombre'] . '</b><br>    promedio factor tendencia a no centrarse en el futuro: ' . number_format($total_factor_tncf_grupo, 3) . '<br> promedio factor planeacion activa del futuro: ' . number_format($total_factor_paf_grupo, 3) . '<br>';
                echo 'promedio factor influencia de la conducta pasada y presente en el futuro: ' . number_format($total_factor_icppf_grupo, 3) . '<br> promedio factor tendencia a imaginarse la vida en el futuro: ' . number_format($total_factor_tivf_grupo, 3) . '<br>';
                echo 'promedio escala de extension economico: ' . number_format($total_eet_economico_grupo, 3) . '<br>promedio escala de extension laboral: ' . number_format($total_eet_laboral_grupo, 3) . '<br>promedio escala de extension familiar: ' . number_format($total_eet_familiar_grupo, 3) . '<br>promedio escala de extension vida: ' . number_format($total_eet_vida_grupo, 3) . '<br>';
                echo 'promedio escala de extension academico: ' . number_format($total_eet_academico_grupo, 3) . '<br><br><br>';
            } else {
                echo '<b> ' . $g['nombre'] . ' no ha sido diligenciado aun</b> <br><br><br>';
            }
            $count_grupo = 0;
            $suma_total_factor_tncf_grupo = 0;
            $suma_total_factor_paf_grupo = 0;
            $suma_total_factor_icppf_grupo = 0;
            $suma_total_factor_tivf_grupo = 0;
            $suma_total_eet_economico_grupo = 0;
            $suma_total_eet_laboral_grupo = 0;
            $suma_total_eet_familiar_grupo = 0;
            $suma_total_eet_vida_grupo = 0;
            $suma_total_eet_academico_grupo = 0;
            $count_factor_tncf_grupo = 0;
            $count_factor_paf_grupo = 0;
            $count_factor_icppf_grupo = 0;
            $count_factor_tivf_grupo = 0;
            $count_eet_economico_grupo = 0;
            $count_eet_laboral_grupo = 0;
            $count_eet_familiar_grupo = 0;
            $count_eet_vida_grupo = 0;
            $count_eet_academico_grupo = 0;


            $query = ' SELECT * FROM `grupo` WHERE id = ' . $g['id'] . ' ';
            $stmt = $dbh->prepare($query);
            $stmt->execute([$g['id']]);
            $rows = $stmt->fetchAll(PDO::FETCH_ASSOC);
            foreach ($rows as $row) {
                echo '<b>INFORME SOBRE EVENTOS POSITIVOS Y NEGATIVOS DEL GRUPO: </b>' . $row["informe_pn"] . '<br>';
                echo '<b>INFORME METAS, RECURSOS Y BARRERAS DEL GRUPO: </b>' . $row["informe_mrb"] . '<br><br><br>';
            }
        }

        $total_factor_tncf_todos = $suma_total_factor_tncf_todos / $count_factor_tncf_todos;
        $total_factor_paf_todos = $suma_total_factor_paf_todos / $count_factor_paf_todos;
        $total_factor_icppf_todos = $suma_total_factor_icppf_todos / $count_factor_icppf_todos;
        $total_factor_tivf_todos = $suma_total_factor_tivf_todos / $count_factor_tivf_todos;
        $total_eet_economico_todos = $suma_total_eet_economico_todos / $count_eet_economico_todos;
        $total_eet_laboral_todos = $suma_total_eet_laboral_todos / $count_eet_laboral_todos;
        $total_eet_familiar_todos = $suma_total_eet_familiar_todos / $count_eet_familiar_todos;
        $total_eet_vida_todos = $suma_total_eet_vida_todos / $count_eet_vida_todos;
        $total_eet_academico_todos = $suma_total_eet_academico_todos / $count_eet_academico_todos;

        echo '<b>TODOS LOS todos </b>' . '<br>    promedio total factor tendencia a no centrarse en el futuro: ' . number_format($total_factor_tncf_todos, 3) . '<br> promedio total factor planeacion activa del futuro: ' . number_format($total_factor_paf_todos, 3) . '<br>';
        echo 'promedio total factor influencia de la conducta pasada y presente en el futuro: ' . number_format($total_factor_icppf_todos, 3) . '<br> promedio total factor tendencia a imaginarse la vida en el futuro: ' . number_format($total_factor_tivf_todos, 3) . '<br>';
        echo 'promedio total escala de extension economico: ' . number_format($total_eet_economico_todos, 3) . '<br>promedio total escala de extension laboral: ' . number_format($total_eet_laboral_todos, 3) . '<br>promedio total escala de extension familiar: ' . number_format($total_eet_familiar_todos, 3) . '<br>promedio total escala de extension vida: ' . number_format($total_eet_vida_grupo, 3) . '<br>';
        echo 'promedio total escala de extension academico: ' . number_format($total_eet_academico_todos, 3) . '<br><br><br>';



        $total_factor_tncf_estudiantes = 0;
        $total_factor_paf_estudiantes = 0;
        $total_factor_icppf_estudiantes = 0;
        $total_factor_tivf_estudiantes = 0;
        $total_eet_economico_estudiantes = 0;
        $total_eet_laboral_estudiantes = 0;
        $total_eet_familiar_estudiantes = 0;
        $total_eet_vida_estudiantes = 0;
        $total_eet_academico_estudiantes = 0;

        ?>
    </div>
    <div class="page">
        <div class="titulo"><h2>INFORME DE ORIENTACIÓN SOCIO OCUPACIONAL - SESIÓN 3</h2></div>
        <?php
        $total_activo_todos = 0;
        $total_reflexivo_todos = 0;
        $total_sensible_todos = 0;
        $total_intuitivo_todos = 0;
        $total_visual_todos = 0;
        $total_verbal_todos = 0;
        $total_secuencial_todos = 0;
        $total_global_todos = 0;

        $total_activo_grupo = 0;
        $total_reflexivo_grupo = 0;
        $total_sensible_grupo = 0;
        $total_intuitivo_grupo = 0;
        $total_visual_grupo = 0;
        $total_verbal_grupo = 0;
        $total_secuencial_grupo = 0;
        $total_global_grupo = 0;

        $count_activo_todos = 0;
        $count_reflexivo_todos = 0;
        $count_sensible_todos = 0;
        $count_intuitivo_todos = 0;
        $count_visual_todos = 0;
        $count_verbal_todos = 0;
        $count_secuencial_todos = 0;
        $count_global_todos = 0;

        $count_activo_grupo = 0;
        $count_reflexivo_grupo = 0;
        $count_sensible_grupo = 0;
        $count_intuitivo_grupo = 0;
        $count_visual_grupo = 0;
        $count_verbal_grupo = 0;
        $count_secuencial_grupo = 0;
        $count_global_grupo = 0;

        $count_grupo = 0;
        $count_todos = 0;

        $aux = 0;
        foreach ($groups as $g) {
            if ($aux == 5) {
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
                if ($row['t_activo'] != -1) {
                    $total_activo_todos += $row['t_activo'];
                    $total_activo_grupo += $row['t_activo'];
                    $count_activo_grupo++;
                    $count_activo_todos++;

                }
                if ($row['t_reflexivo'] != -1) {
                    $total_reflexivo_todos += $row['t_reflexivo'];
                    $total_reflexivo_grupo += $row['t_reflexivo'];
                    $count_reflexivo_grupo++;
                    $count_reflexivo_todos++;

                }
                if ($row['t_sensible'] != -1) {
                    $total_sensible_todos += $row['t_sensible'];
                    $total_sensible_grupo += $row['t_sensible'];
                    $count_sensible_grupo++;
                    $count_sensible_todos++;

                }
                if ($row['t_intuitivo'] != -1) {
                    $total_intuitivo_todos += $row['t_intuitivo'];
                    $total_intuitivo_grupo += $row['t_intuitivo'];
                    $count_intuitivo_grupo++;
                    $count_intuitivo_todos++;

                }
                if ($row['t_visual'] != -1) {
                    $total_visual_todos += $row['t_visual'];
                    $total_visual_grupo += $row['t_visual'];
                    $count_visual_grupo++;
                    $count_visual_todos++;

                }
                if ($row['t_verbal'] != -1) {
                    $total_verbal_todos += $row['t_verbal'];
                    $total_verbal_grupo += $row['t_verbal'];
                    $count_verbal_grupo++;
                    $count_verbal_todos++;

                }
                if ($row['t_secuencial'] != -1) {
                    $total_secuencial_todos += $row['t_secuencial'];
                    $total_secuencial_grupo += $row['t_secuencial'];
                    $count_secuencial_grupo++;
                    $count_secuencial_todos++;

                }
                if ($row['t_global'] != -1) {
                    $total_global_todos += $row['t_global'];
                    $total_global_grupo += $row['t_global'];
                    $count_global_grupo++;
                    $count_global_todos++;

                }

                $count_grupo++;
                $count_todos++;
            }
            //echo $count_grupo . ',' . $total_activo_grupo . ','. $total_activo_grupo / $count_grupo . '<br>';
            echo '<b> ' . $g['nombre'] . '</b><br>';
            if ($count_grupo != 0) {
                $total_activo_grupo = number_format($total_activo_grupo / $count_activo_grupo, 2);
                $total_reflexivo_grupo = number_format($total_reflexivo_grupo / $count_reflexivo_grupo, 2);
                $total_sensible_grupo = number_format($total_sensible_grupo / $count_sensible_grupo, 2);
                $total_intuitivo_grupo = number_format($total_intuitivo_grupo / $count_intuitivo_grupo, 2);
                $total_visual_grupo = number_format($total_visual_grupo / $count_visual_grupo, 2);
                $total_verbal_grupo = number_format($total_verbal_grupo / $count_verbal_grupo, 2);
                $total_secuencial_grupo = number_format($total_secuencial_grupo / $count_secuencial_grupo, 2);
                $total_global_grupo = number_format($total_global_grupo / $count_global_grupo, 2);
                echo 'total activo: ' . $total_activo_grupo . '<br>';
                echo 'total reflexivo: ' . $total_reflexivo_grupo . '<br>';
                echo 'total sensible: ' . $total_sensible_grupo . '<br>';
                echo 'total intuitivo: ' . $total_intuitivo_grupo . '<br>';
                echo 'total visual: ' . $total_visual_grupo . '<br>';
                echo 'total verbal: ' . $total_verbal_grupo . '<br>';
                echo 'total secuencial: ' . $total_secuencial_grupo . '<br>';
                echo 'total global: ' . $total_global_grupo . '<br><br><br>';
            } else {
                echo 'no ha sido diligenciado aun <br><br><br>';
            }
            $count_grupo = 0;
            $count_activo_grupo = 0;
            $count_reflexivo_grupo = 0;
            $count_sensible_grupo = 0;
            $count_intuitivo_grupo = 0;
            $count_visual_grupo = 0;
            $count_verbal_grupo = 0;
            $count_secuencial_grupo = 0;
            $count_global_grupo = 0;
            $total_activo_grupo = 0;
            $total_reflexivo_grupo = 0;
            $total_sensible_grupo = 0;
            $total_intuitivo_grupo = 0;
            $total_visual_grupo = 0;
            $total_verbal_grupo = 0;
            $total_secuencial_grupo = 0;
            $total_global_grupo = 0;
        }
        $total_activo_todos = number_format($total_activo_todos / $count_activo_todos, 2);
        $total_reflexivo_todos = number_format($total_reflexivo_todos / $count_reflexivo_todos, 2);
        $total_sensible_todos = number_format($total_sensible_todos / $count_sensible_todos, 2);
        $total_intuitivo_todos = number_format($total_intuitivo_todos / $count_intuitivo_todos, 2);
        $total_visual_todos = number_format($total_visual_todos / $count_visual_todos, 2);
        $total_verbal_todos = number_format($total_verbal_todos / $count_verbal_todos, 2);
        $total_secuencial_todos = number_format($total_secuencial_todos / $count_secuencial_todos, 2);
        $total_global_todos = number_format($total_global_todos / $count_global_todos, 2);
        echo '<b>Todos los participantes</b><br>';
        echo 'total activo: ' . $total_activo_todos . '<br>';
        echo 'total reflexivo: ' . $total_reflexivo_todos . '<br>';
        echo 'total sensible: ' . $total_sensible_todos . '<br>';
        echo 'total intuitivo: ' . $total_intuitivo_todos . '<br>';
        echo 'total visual: ' . $total_visual_todos . '<br>';
        echo 'total verbal: ' . $total_verbal_todos . '<br>';
        echo 'total secuencial: ' . $total_secuencial_todos . '<br>';
        echo 'total global: ' . $total_global_todos . '<br><br><br>';
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

        //****************************
        $suma_amigos_todos = 0;
        $suma_familia_todos = 0;
        $suma_otro_todos = 0;
        $suma_total_todos = 0;

        //*****************************
        $suma_amigos_grupo = 0;
        $suma_familia_grupo = 0;
        $suma_otro_grupo = 0;
        $suma_total_grupo = 0;

        $count_amigos_todos = 0;
        $count_familia_todos = 0;
        $count_otro_todos = 0;
        $count_total_todos = 0;

        //*****************************
        $count_amigos_grupo = 0;
        $count_familia_grupo = 0;
        $count_otro_grupo = 0;
        $count_total_grupo = 0;
        $aux = 0;
        foreach ($groups as $g) {
            if ($aux == 3) {
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

              //****************************
                if ($row['amigos'] != -1) {
                    $suma_amigos_todos += $row['amigos'];
                    $suma_amigos_grupo += $row['amigos'];
                    $count_amigos_todos++;
                    $count_amigos_grupo++;

                }
                if ($row['familia'] != -1) {
                    $suma_familia_todos += $row['familia'];
                    $suma_familia_grupo += $row['familia'];
                    $count_familia_todos++;
                    $count_familia_grupo++;
                }
                if ($row['otro'] != -1) {
                    $suma_otro_todos += $row['otro'];
                    $suma_otro_grupo += $row['otro'];
                    $count_otro_todos++;
                    $count_otro_grupo++;


                }
                if ($row['total'] != -1) {
                    $suma_total_todos += $row['total'];
                    $suma_total_grupo += $row['total'];
                    $count_total_todos++;
                    $count_total_grupo++;

                }

              //*****************************


                $count_grupo++;
                $count_todos++;
            }
            //echo $count_grupo.','.$suma_v_grupo.'<br>';
            if ($count_grupo != 0) {
                $total_amigos_grupo = $suma_amigos_grupo / $count_amigos_grupo;
                $total_familia_grupo = $suma_familia_grupo / $count_otro_grupo;
                $total_otro_grupo = $suma_otro_grupo / $count_otro_grupo;
                $total_total_grupo = $suma_total_grupo / $count_total_grupo;

                echo '<b>grupo: ' . $g['nombre'] . '</b><br>   Total amigos: ' . number_format($total_amigos_grupo, 3) . '<br> Total Familia: ' . number_format($total_familia_grupo, 3) . '<br>';
                echo 'Total Otro significativo: ' . number_format($total_otro_grupo, 3) . '<br> Puntaje total: ' . number_format($total_total_grupo, 3) . '<br><br><br>';
            } else {
                echo '<b>grupo: ' . $g['nombre'] . ' no ha sido diligenciado aun ' . '</b><br><br><br>';
            }
            $count_grupo = 0;
            $count_amigos_grupo = 0;
            $count_familia_grupo = 0;
            $count_otro_grupo = 0;
            $count_total_grupo = 0;
            $suma_amigos_grupo = 0;
            $suma_familia_grupo = 0;
            $suma_otro_grupo = 0;
            $suma_total_grupo = 0;

            $query = ' SELECT * FROM `grupo` WHERE id = ' . $g['id'] . ' ';
            $stmt = $dbh->prepare($query);
            $stmt->execute([$g['id']]);
            $rows = $stmt->fetchAll(PDO::FETCH_ASSOC);
            foreach ($rows as $row) {
                echo '<b>INFORME SOBRE LOS RECURSOS IDENTIFICADOS POR TODOS LOS PARTICIPANTES: </b>' . $row["inf_s3"] . '<br><br><br>';
            }

        }

        $total_amigos_estudiantes = $suma_amigos_todos / $count_amigos_todos;
        $total_familia_estudiantes = $suma_familia_todos / $count_otro_todos;
        $total_otro_estudiantes = $suma_otro_todos / $count_otro_todos;
        $total_total_estudiantes = $suma_total_todos / $count_total_todos;


        echo '<b>TODOS LOS ESTUDIANTES </b>' . '<br>   Total amigos: ' . number_format($total_amigos_estudiantes, 3) . '<br> Total Familia: ' . number_format($total_familia_estudiantes, 3) . '<br>';
        echo 'Total Otro significativo: ' . number_format($total_otro_estudiantes, 3) . '<br> Puntaje total: ' . number_format($total_total_estudiantes, 3) . '<br><br><br>';
        ?>
    </div>
    <div class="page">
    <div class="titulo"><h2>INFORME DE ORIENTACIÓN SOCIO OCUPACIONAL - SESIÓN 5</h2></div>
                <?php

                $total_todos = 0;
                $total_grupo = 0;

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
                    $query = ' SELECT grupo.id, estudiantes.id, sesion_5.total FROM grupo INNER JOIN estudiantes Inner join sesion_5 on grupo.id=estudiantes.grupo_id and estudiantes.id=sesion_5.id_estudiante where grupo.id=? ';
                    //echo $query;
                    $stmt = $dbh->prepare($query);
                    $stmt->execute([$g['id']]);
                    $rows = $stmt->fetchAll(PDO::FETCH_ASSOC);
                    foreach ($rows as $row) {
                        if ($row['total'] != -1) {
                            $total_todos += $row['total'];
                            $total_grupo += $row['total'];
                            $count_grupo++;
                            $count_todos++;
                        }

                    }
                    //echo $count_grupo.','.$suma_v_grupo.'<br>';
                    echo '<b> ' . $g['nombre'] . '</b><br>';
                    if ($count_grupo != 0) {
                        $total_grupo = $total_grupo / $count_grupo;
                        echo 'total: ' . number_format($total_grupo, 3) . '<br><br><br>';
                    } else {
                        echo 'no ha sido diligenciado aun <br><br><br>';
                    }
                    $count_grupo = 0;
                    $total_grupo = 0;
                }
                $total_todos = $total_todos / $count_todos;

                echo '<b>Todos los participantes</b><br>';
                echo $total_todos.'<br><br><br>';
                ?>
            </div>
            <div class="page">
    <div class="titulo"><h2>INFORME DE ORIENTACIÓN SOCIO OCUPACIONAL - SESIÓN 6</h2></div>
                <?php
                $total_todos = 0;
                $total_grupo = 0;

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
                        if ($row['total'] != -1) {
                            $total_todos += $row['total'];
                            $total_grupo += $row['total'];
                            $count_grupo++;
                            $count_todos++;
                        }
                    }
                    //echo $count_grupo.','.$suma_v_grupo.'<br>';
                    echo '<b> ' . $g['nombre'] . '</b><br>';
                    if ($count_grupo != 0) {
                        $total_grupo = $total_grupo / $count_grupo;
                        echo 'total: ' . number_format($total_grupo, 3) . '<br><br><br>';
                    } else {
                        echo 'no ha sido diligenciado aun <br><br><br>';
                    }
                    $count_grupo = 0;
                    $total_grupo = 0;
                }
                $total_todos = $total_todos / $count_todos;

                echo '<b>Todos los participantes</b><br>';
                echo $total_todos.'<br><br><br>';
                ?>
            </div>
            <div class="page">
            <div class="titulo"><h2>INFORME DE ORIENTACIÓN SOCIO OCUPACIONAL - SESIÓN 7</h2></div>
                <?php
                $aux = 0;
                foreach ($groups as $g) {
                    if ($aux == 2) {
                        echo '</div><div class="page">';
                        $aux = 0;
                    }
                    if ($g['nombre'] == "grupo de pruebas") {
                        continue;
                    }
                    $aux++;
                    echo '<b> ' . $g['nombre'] . '</b><br>';
                    echo ' informe metas, recursos y barreras: <br>';
                    echo $g['inf_s7'] . '<br><br><br>';
                }
                ?>
            </div>
            <div class="page">
        <div class="titulo"><h2>INFORME DE ORIENTACIÓN SOCIO OCUPACIONAL - SESIÓN 8</h2></div>
        <?php
        $total_temas_todos = 0;
        $total_ejercicios_todos = 0;
        $total_tallerista_todos = 0;
        $total_utilidad_todos = 0;

        $total_temas_grupo = 0;
        $total_ejercicios_grupo = 0;
        $total_tallerista_grupo = 0;
        $total_utilidad_grupo = 0;

        $count_temas_todos = 0;
        $count_ejercicios_todos = 0;
        $count_tallerista_todos = 0;
        $count_utilidad_todos = 0;

        $count_temas_grupo = 0;
        $count_ejercicios_grupo = 0;
        $count_tallerista_grupo = 0;
        $count_utilidad_grupo = 0;

        $count_grupo = 0;
        $count_todos = 0;

        $aux = 0;
        foreach ($groups as $g) {
            if ($aux == 2) {
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
                if ($row['temas_trabajados'] != -1) {
                    $total_temas_todos += $row['temas_trabajados'];
                    $total_temas_grupo += $row['temas_trabajados'];
                    $count_temas_grupo++;
                    $count_temas_todos++;
                }
                if ($row['ejercicios'] != -1) {
                    $total_ejercicios_todos += $row['ejercicios'];
                    $total_ejercicios_grupo += $row['ejercicios'];
                    $count_ejercicios_grupo++;
                    $count_ejercicios_todos++;
                }
                if ($row['tallerista'] != -1) {
                    $total_tallerista_todos += $row['tallerista'];
                    $total_tallerista_grupo += $row['tallerista'];
                    $count_tallerista_grupo++;
                    $count_tallerista_todos++;
                }
                if ($row['utilidad'] != -1) {
                    $total_utilidad_todos += $row['utilidad'];
                    $total_utilidad_grupo += $row['utilidad'];
                    $count_utilidad_grupo++;
                    $count_utilidad_todos++;
                }

                $count_grupo++;
                $count_todos++;
            }
            //echo $count_grupo . ',' . $total_temas_grupo . ','. $total_temas_grupo / $count_grupo . '<br>';
            echo '<b> ' . $g['nombre'] . '</b><br>';
            if ($count_grupo != 0) {
                $total_temas_grupo = number_format($total_temas_grupo / $count_temas_grupo, 2);
                $total_ejercicios_grupo = number_format($total_ejercicios_grupo / $count_ejercicios_grupo, 2);
                $total_tallerista_grupo = number_format($total_tallerista_grupo / $count_tallerista_grupo, 2);
                $total_utilidad_grupo = number_format($total_utilidad_grupo / $count_utilidad_grupo, 2);
                echo 'total temas trabajados: ' . $total_temas_grupo . '<br>';
                echo 'total ejercicios: ' . $total_ejercicios_grupo . '<br>';
                echo 'total direccion del tallerista: ' . $total_tallerista_grupo . '<br>';
                echo 'total utilidad diario vivir: ' . $total_utilidad_grupo . '<br><br><br>';

            } else {
                echo 'no ha sido diligenciado aun <br><br><br>';
            }
            echo ' Diario de campo del taller sobre Asertividad: <br>';
            echo $g['inf_s8'] . '<br><br><br>';
            $count_grupo = 0;
            $count_temas_grupo = 0;
            $count_ejercicios_grupo = 0;
            $count_tallerista_grupo = 0;
            $count_utilidad_grupo = 0;
            $total_temas_grupo = 0;
            $total_ejercicios_grupo = 0;
            $total_tallerista_grupo = 0;
            $total_utilidad_grupo = 0;
        }
        $total_temas_todos = number_format($total_temas_todos / $count_temas_todos, 2);
        $total_ejercicios_todos = number_format($total_ejercicios_todos / $count_ejercicios_todos, 2);
        $total_tallerista_todos = number_format($total_tallerista_todos / $count_tallerista_todos, 2);
        $total_utilidad_todos = number_format($total_utilidad_todos / $count_utilidad_todos, 2);
        echo '<b>Todos los participantes</b><br>';
        echo 'total temas trabajados: ' . $total_temas_todos . '<br>';
        echo 'total ejercicios: ' . $total_ejercicios_todos . '<br>';
        echo 'total direccion del tallerista: ' . $total_tallerista_todos . '<br>';
        echo 'total utilidad diario vivir: ' . $total_utilidad_todos . '<br><br><br>';
        ?>
    </div>
</div>

</body>
