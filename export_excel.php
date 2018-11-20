<?php
header("Content-Type: text/html;charset=utf-8");
include_once("config.php");
if (!isset($_SESSION)) {
    session_start();
}
include_once("functions.php");
if (!func::checkLoginState($dbh)) {
    echo '<script language="javascript">window.location="login.php"</script>';
}
$count_grupo = 0;
$count_todos = 0;
$query = ' SELECT * FROM grupo';
$stmt = $dbh->prepare($query);
$stmt->execute();
$groups = $stmt->fetchAll(PDO::FETCH_ASSOC);

$suma_v_todos = 0;
$suma_m_todos = 0;
$suma_v_grupo = 0;
$suma_m_grupo = 0;
$sesion_1 = [];
$aux = [];
foreach ($groups as $g) {
    if ($g['nombre'] == "grupo de pruebas") {
        continue;
    }
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
    //echo '<b> ' . $g['nombre'] . '</b><br>';
    $aux['INSTITUCION'] = $g['nombre'];
    if ($count_grupo != 0) {
        $total_verbal_grupo = $suma_v_grupo / $count_grupo;
        $total_matematica_grupo = $suma_m_grupo / $count_grupo;
        //echo 'total verbal: ' . number_format($total_verbal_grupo, 3) . '<br> total matematico: ' . number_format($total_matematica_grupo, 3) . '<br>';
        $aux['TOTAL VERBAL'] = number_format($total_verbal_grupo, 3);
        $aux['TOTAL MATEMATICA'] = number_format($total_matematica_grupo, 3);
    } else {
        //echo 'no ha sido diligenciado aun <br>';
        $aux['TOTAL VERBAL'] = 'no ha sido diligenciado aun';
        $aux['TOTAL MATEMATICA'] = 'no ha sido diligenciado aun';
    }
    $count_grupo = 0;
    $suma_v_grupo = 0;
    $suma_m_grupo = 0;
    array_push($sesion_1, $aux);
}
$total_verbal_estudiantes = $suma_v_todos / $count_todos;
$total_matematica_estudiantes = $suma_m_todos / $count_todos;
$aux['INSTITUCION'] = 'Todos los participantes';
$aux['TOTAL VERBAL'] = number_format($total_verbal_estudiantes, 3);
$aux['TOTAL MATEMATICA'] = number_format($total_matematica_estudiantes, 3);
array_push($sesion_1, $aux);

$total_verbal_estudiantes = 0;
$total_matematica_estudiantes = 0;


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
$aux = [];
$sesion_2 = [];
foreach ($groups as $g) {
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

        $suma_total_factor_tncf_todos += $row['total_factor_tncf'];
        $suma_total_factor_paf_todos += $row['total_factor_paf'];
        $suma_total_factor_icppf_todos += $row['total_factor_icppf'];
        $suma_total_factor_tivf_todos += $row['total_factor_tivf'];
        $suma_total_eet_economico_todos += $row['total_eet_economico'];
        $suma_total_eet_laboral_todos += $row['total_eet_laboral'];
        $suma_total_eet_familiar_todos += $row['total_eet_familiar'];
        $suma_total_eet_vida_todos += $row['total_eet_vida'];
        $suma_total_eet_academico_todos += $row['total_eet_academico'];

      // suma grupos

        $suma_total_factor_tncf_grupo += $row['total_factor_tncf'];
        $suma_total_factor_paf_grupo += $row['total_factor_paf'];
        $suma_total_factor_icppf_grupo += $row['total_factor_icppf'];
        $suma_total_factor_tivf_grupo += $row['total_factor_tivf'];
        $suma_total_eet_economico_grupo += $row['total_eet_economico'];
        $suma_total_eet_laboral_grupo += $row['total_eet_laboral'];
        $suma_total_eet_familiar_grupo += $row['total_eet_familiar'];
        $suma_total_eet_vida_grupo += $row['total_eet_vida'];
        $suma_total_eet_academico_grupo += $row['total_eet_academico'];



        $count_grupo++;
        $count_todos++;
    }

    //echo $count_grupo.','.$suma_v_grupo.'<br>';
    $aux['INSTITUCION'] = $g['nombre'];
    if ($count_grupo != 0) {

        $aux['FACTOR TENDENCIA A NO CENTRARSE EN EL FUTURO'] = number_format($suma_total_factor_tncf_grupo / $count_grupo, 3);
        $aux['FACTOR PLANEACION ACTIVA DEL FUTURO'] = number_format($suma_total_factor_paf_grupo / $count_grupo, 3);
        $aux['FACTOR INFLUENCIA DE LA CONDUCTA PASADA Y PRESENTE EN EL FUTURO'] = number_format($suma_total_factor_icppf_grupo / $count_grupo, 3);
        $aux['FACTOR TENDENCIA A IMAGINARSE LA VIDA EN EL FUTURO'] = number_format($suma_total_factor_tivf_grupo / $count_grupo, 3);
        $aux['ESCALA DE EXTENSION ECONOMICA'] = number_format($suma_total_eet_economico_grupo / $count_grupo, 3);
        $aux['ESCALA DE EXTENSION LABORAL'] = number_format($suma_total_eet_laboral_grupo / $count_grupo, 3);
        $aux['ESCALA DE EXTENSION FAMILIAR'] = number_format($suma_total_eet_familiar_grupo / $count_grupo, 3);
        $aux['ESCALA DE EXTENSION VIDA'] = number_format($suma_total_eet_vida_grupo / $count_grupo, 3);
        $aux['ESCALA DE EXTENSION ACADEMICO'] = number_format($suma_total_eet_academico_grupo / $count_grupo, 3);

    } else {
        $aux['FACTOR TENDENCIA A NO CENTRARSE EN EL FUTURO'] = 'NO diligenciado';
        $aux['FACTOR PLANEACION ACTIVA DEL FUTURO'] = 'NO diligenciado';
        $aux['FACTOR INFLUENCIA DE LA CONDUCTA PASADA Y PRESENTE EN EL FUTURO'] = 'NO diligenciado';
        $aux['FACTOR TENDENCIA A IMAGINARSE LA VIDA EN EL FUTURO'] = 'NO diligenciado';
        $aux['ESCALA DE EXTENSION ECONOMICA'] = 'NO diligenciado';
        $aux['ESCALA DE EXTENSION LABORAL'] = 'NO diligenciado';
        $aux['ESCALA DE EXTENSION FAMILIAR'] = 'NO diligenciado';
        $aux['ESCALA DE EXTENSION VIDA'] = 'NO diligenciado';
        $aux['ESCALA DE EXTENSION ACADEMICO'] = 'NO diligenciado';
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
    $aux['INFORME SOBRE EVENTOS POSITIVOS Y NEGATIVOS DEL GRUPO'] = $g["informe_mrb"];
    array_push($sesion_2, $aux);

}

$total_factor_tncf_estudiantes = $suma_total_factor_tncf_todos / $count_todos;
$total_factor_paf_estudiantes = $suma_total_factor_paf_todos / $count_todos;
$total_factor_icppf_estudiantes = $suma_total_factor_icppf_todos / $count_todos;
$total_factor_tivf_estudiantes = $suma_total_factor_tivf_todos / $count_todos;
$total_eet_economico_estudiantes = $suma_total_eet_economico_todos / $count_todos;
$total_eet_laboral_estudiantes = $suma_total_eet_laboral_todos / $count_todos;
$total_eet_familiar_estudiantes = $suma_total_eet_familiar_todos / $count_todos;
$total_eet_vida_estudiantes = $suma_total_eet_vida_todos / $count_todos;
$total_eet_academico_estudiantes = $suma_total_eet_academico_todos / $count_todos;

$aux['INSTITUCION'] = 'Todos los participantes';
$aux['FACTOR TENDENCIA A NO CENTRARSE EN EL FUTURO'] = number_format($suma_total_factor_tncf_todos / $count_todos, 3);
$aux['FACTOR PLANEACION ACTIVA DEL FUTURO'] = number_format($suma_total_factor_paf_todos / $count_todos, 3);
$aux['FACTOR INFLUENCIA DE LA CONDUCTA PASADA Y PRESENTE EN EL FUTURO'] = number_format($suma_total_factor_icppf_todos / $count_todos, 3);
$aux['FACTOR TENDENCIA A IMAGINARSE LA VIDA EN EL FUTURO'] = number_format($suma_total_factor_tivf_todos / $count_todos, 3);
$aux['ESCALA DE EXTENSION ECONOMICA'] = number_format($suma_total_eet_economico_todos / $count_todos, 3);
$aux['ESCALA DE EXTENSION LABORAL'] = number_format($suma_total_eet_laboral_todos / $count_todos, 3);
$aux['ESCALA DE EXTENSION FAMILIAR'] = number_format($suma_total_eet_familiar_todos / $count_todos, 3);
$aux['ESCALA DE EXTENSION VIDA'] = number_format($suma_total_eet_vida_todos / $count_todos, 3);
$aux['ESCALA DE EXTENSION ACADEMICO'] = number_format($suma_total_eet_academico_todos / $count_todos, 3);
array_push($sesion_2, $aux);


$total_factor_tncf_estudiantes = 0;
$total_factor_paf_estudiantes = 0;
$total_factor_icppf_estudiantes = 0;
$total_factor_tivf_estudiantes = 0;
$total_eet_economico_estudiantes = 0;
$total_eet_laboral_estudiantes = 0;
$total_eet_familiar_estudiantes = 0;
$total_eet_vida_estudiantes = 0;
$total_eet_academico_estudiantes = 0;


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

$count_grupo = 0;
$count_todos = 0;

$aux = [];
$sesion_3 = [];
foreach ($groups as $g) {
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
        $total_activo_todos += $row['t_activo'];
        $total_reflexivo_todos += $row['t_reflexivo'];
        $total_sensible_todos += $row['t_sensible'];
        $total_intuitivo_todos += $row['t_intuitivo'];
        $total_visual_todos += $row['t_visual'];
        $total_verbal_todos += $row['t_verbal'];
        $total_secuencial_todos += $row['t_secuencial'];
        $total_global_todos += $row['t_global'];

        $total_activo_grupo += $row['t_activo'];
        $total_reflexivo_grupo += $row['t_reflexivo'];
        $total_sensible_grupo += $row['t_sensible'];
        $total_intuitivo_grupo += $row['t_intuitivo'];
        $total_visual_grupo += $row['t_visual'];
        $total_verbal_grupo += $row['t_verbal'];
        $total_secuencial_grupo += $row['t_secuencial'];
        $total_global_grupo += $row['t_global'];
        $count_grupo++;
        $count_todos++;
    }
            //echo $count_grupo . ',' . $total_activo_grupo . ','. $total_activo_grupo / $count_grupo . '<br>';
    //echo '<b> ' . $g['nombre'] . '</b><br>';
    $aux['INSTITUCION'] = $g['nombre'];
    if ($count_grupo != 0) {
        $aux['TOTAL ACTIVO'] = number_format($total_activo_grupo / $count_grupo, 2);
        $aux['TOTAL REFLEXIVO'] = number_format($total_reflexivo_grupo / $count_grupo, 2);
        $aux['TOTAL SENSIBLE'] = number_format($total_sensible_grupo / $count_grupo, 2);
        $aux['TOTAL INTUITIVO'] = number_format($total_intuitivo_grupo / $count_grupo, 2);
        $aux['TOTAL VISUAL'] = number_format($total_visual_grupo / $count_grupo, 2);
        $aux['TOTAL VERBAL'] = number_format($total_verbal_grupo / $count_grupo, 2);
        $aux['TOTAL SECUENCIAL'] = number_format($total_secuencial_grupo / $count_grupo, 2);
        $aux['TOTAL GLOBAL'] = number_format($total_global_grupo / $count_grupo, 2);
    } else {
        $aux['TOTAL ACTIVO'] = 'NO diligenciado';
        $aux['TOTAL REFLEXIVO'] = 'NO diligenciado';
        $aux['TOTAL SENSIBLE'] = 'NO diligenciado';
        $aux['TOTAL INTUITIVO'] = 'NO diligenciado';
        $aux['TOTAL VISUAL'] = 'NO diligenciado';
        $aux['TOTAL VERBAL'] = 'NO diligenciado';
        $aux['TOTAL SECUENCIAL'] = 'NO diligenciado';
        $aux['TOTAL GLOBAL'] = 'NO diligenciado';
    }
    array_push($sesion_3, $aux);
    $count_grupo = 0;
    $total_activo_grupo = 0;
    $total_reflexivo_grupo = 0;
    $total_sensible_grupo = 0;
    $total_intuitivo_grupo = 0;
    $total_visual_grupo = 0;
    $total_verbal_grupo = 0;
    $total_secuencial_grupo = 0;
    $total_global_grupo = 0;
}
$aux['INSTITUCION'] = 'Todos los participantes';
$aux['TOTAL ACTIVO'] = number_format($total_activo_todos / $count_todos, 2);
$aux['TOTAL REFLEXIVO'] = number_format($total_reflexivo_todos / $count_todos, 2);
$aux['TOTAL SENSIBLE'] = number_format($total_sensible_todos / $count_todos, 2);
$aux['TOTAL INTUITIVO'] = number_format($total_intuitivo_todos / $count_todos, 2);
$aux['TOTAL VISUAL'] = number_format($total_visual_todos / $count_todos, 2);
$aux['TOTAL VERBAL'] = number_format($total_verbal_todos / $count_todos, 2);
$aux['TOTAL SECUENCIAL'] = number_format($total_secuencial_todos / $count_todos, 2);
$aux['TOTAL GLOBAL'] = number_format($total_global_todos / $count_todos, 2);
array_push($sesion_3, $aux);

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
$aux = [];
$sesion_4 = [];
foreach ($groups as $g) {
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
        $suma_amigos_todos += $row['amigos'];
        $suma_familia_todos += $row['familia'];
        $suma_otro_todos += $row['otro'];
        $suma_total_todos += $row['total'];

              //*****************************
        $suma_amigos_grupo += $row['amigos'];
        $suma_familia_grupo += $row['familia'];
        $suma_otro_grupo += $row['otro'];
        $suma_total_grupo += $row['total'];

        $count_grupo++;
        $count_todos++;
    }
            //echo $count_grupo.','.$suma_v_grupo.'<br>';
    $aux['INSTITUCION'] = $g['nombre'];
    if ($count_grupo != 0) {
        $aux['TOTAL AMIGOS'] = number_format($suma_amigos_grupo / $count_grupo, 3);
        $aux['TOTAL FAMILIA'] = number_format($suma_familia_grupo / $count_grupo, 3);
        $aux['TOTAL OTRO SIGNIFICATIVO'] = number_format($suma_otro_grupo / $count_grupo, 3);
        $aux['TOTAL TOTAL'] = number_format($suma_total_grupo / $count_grupo, 3);
    } else {
        $aux['TOTAL AMIGOS'] = 'NO diligenciado';
        $aux['TOTAL FAMILIA'] = 'NO diligenciado';
        $aux['TOTAL OTRO SIGNIFICATIVO'] = 'NO diligenciado';
        $aux['TOTAL TOTAL'] = 'NO diligenciado';
    }
    $count_grupo = 0;
    $suma_amigos_grupo = 0;
    $suma_familia_grupo = 0;
    $suma_otro_grupo = 0;
    $suma_total_grupo = 0;

    $aux['INFORME SOBRE LOS RECURSOS IDENTIFICADOS POR TODOS LOS PARTICIPANTES'] = $g['inf_s3'];
    array_push($sesion_4, $aux);

}
$aux['INSTITUCION'] = 'Todos los participantes';
$aux['TOTAL AMIGOS'] = number_format($suma_amigos_todos / $count_todos, 3);
$aux['TOTAL FAMILIA'] = number_format($suma_familia_todos / $count_todos, 3);
$aux['TOTAL OTRO SIGNIFICATIVO'] = number_format($suma_otro_todos / $count_todos, 3);
$aux['TOTAL TOTAL'] = number_format($suma_total_todos / $count_todos, 3);
$aux['INFORME SOBRE LOS RECURSOS IDENTIFICADOS POR TODOS LOS PARTICIPANTES'] = '';
array_push($sesion_4, $aux);

$total_todos = 0;
$total_grupo = 0;

$count_grupo = 0;
$count_todos = 0;
$aux = [];
$sesion_5 = [];
foreach ($groups as $g) {
    if ($g['nombre'] == "grupo de pruebas") {
        continue;
    }
    $query = ' SELECT grupo.id, estudiantes.id, sesion_5.total FROM grupo INNER JOIN estudiantes Inner join sesion_5 on grupo.id=estudiantes.grupo_id and estudiantes.id=sesion_5.id_estudiante where grupo.id=? ';
                    //echo $query;
    $stmt = $dbh->prepare($query);
    $stmt->execute([$g['id']]);
    $rows = $stmt->fetchAll(PDO::FETCH_ASSOC);
    foreach ($rows as $row) {
        $total_todos += $row['total'];
        $total_grupo += $row['total'];
        $count_grupo++;
        $count_todos++;
    }
                    //echo $count_grupo.','.$suma_v_grupo.'<br>';
    $aux['INSTITUCION'] = $g['nombre'];
    if ($count_grupo != 0) {
        $aux['TOTAL'] = number_format($total_grupo / $count_grupo, 3);
    } else {
        $aux['TOTAL'] = 'NO diligenciado';
    }
    array_push($sesion_5, $aux);
    $count_grupo = 0;
    $total_grupo = 0;
}

$aux['INSTITUCION'] = 'Todos los participantes';
$aux['TOTAL'] = number_format($total_todos / $count_todos, 3);
array_push($sesion_5, $aux);

$total_todos = 0;
$total_grupo = 0;

$count_grupo = 0;
$count_todos = 0;
$aux = [];
$sesion_6 = [];
foreach ($groups as $g) {
    if ($g['nombre'] == "grupo de pruebas") {
        continue;
    }
    $query = ' SELECT grupo.id, estudiantes.id, sesion_6.total FROM grupo INNER JOIN estudiantes Inner join sesion_6 on grupo.id=estudiantes.grupo_id and estudiantes.id=sesion_6.id_estudiante where grupo.id=? ';
                    //echo $query;
    $stmt = $dbh->prepare($query);
    $stmt->execute([$g['id']]);
    $rows = $stmt->fetchAll(PDO::FETCH_ASSOC);
    foreach ($rows as $row) {
        $total_todos += $row['total'];
        $total_grupo += $row['total'];
        $count_grupo++;
        $count_todos++;
    }
                    //echo $count_grupo.','.$suma_v_grupo.'<br>';
    $aux['INSTITUCION'] = $g['nombre'];
    if ($count_grupo != 0) {
        $aux['TOTAL'] = number_format($total_grupo / $count_grupo, 3);
    } else {
        $aux['TOTAL'] = 'NO diligenciado';
    }
    array_push($sesion_6, $aux);
    $count_grupo = 0;
    $total_grupo = 0;
}

$aux['INSTITUCION'] = 'Todos los participantes';
$aux['TOTAL'] = number_format($total_todos / $count_todos, 3);
array_push($sesion_6, $aux);

$aux = [];
$sesion_7 = [];
foreach ($groups as $g) {
    if ($g['nombre'] == "grupo de pruebas") {
        continue;
    }
    $aux['INSTITUCION'] = $g['nombre'];
    $aux['INFORME METAS, RECURSOS Y BARRERAS'] = $g['inf_s7'];
    array_push($sesion_7, $aux);
}

$total_temas_todos = 0;
$total_ejercicios_todos = 0;
$total_tallerista_todos = 0;
$total_utilidad_todos = 0;
$total_visual_todos = 0;
$total_verbal_todos = 0;
$total_secuencial_todos = 0;
$total_global_todos = 0;

$total_temas_grupo = 0;
$total_ejercicios_grupo = 0;
$total_tallerista_grupo = 0;
$total_utilidad_grupo = 0;
$total_visual_grupo = 0;
$total_verbal_grupo = 0;
$total_secuencial_grupo = 0;
$total_global_grupo = 0;

$count_grupo = 0;
$count_todos = 0;

$aux = [];
$sesion_8 = [];
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
        $total_temas_todos += $row['temas_trabajados'];
        $total_ejercicios_todos += $row['ejercicios'];
        $total_tallerista_todos += $row['tallerista'];
        $total_utilidad_todos += $row['utilidad'];

        $total_temas_grupo += $row['temas_trabajados'];
        $total_ejercicios_grupo += $row['ejercicios'];
        $total_tallerista_grupo += $row['tallerista'];
        $total_utilidad_grupo += $row['utilidad'];
        $count_grupo++;
        $count_todos++;
    }
            //echo $count_grupo . ',' . $total_temas_grupo . ','. $total_temas_grupo / $count_grupo . '<br>';
    $aux['INSTITUCION'] = $g['nombre'];
    if ($count_grupo != 0) {
        $aux['TEMAS TRABAJADOS'] = number_format($total_temas_grupo / $count_grupo, 2);
        $aux['EJERCICIOS'] = number_format($total_ejercicios_grupo / $count_grupo, 2);
        $aux['DERECCION DEL TALLERISTA'] = number_format($total_tallerista_grupo / $count_grupo, 2);
        $aux['UTILIDAD DIARIO VIVIR'] = number_format($total_utilidad_grupo / $count_grupo, 2);

    } else {
        $aux['TEMAS TRABAJADOS'] = 'NO diligenciado';
        $aux['EJERCICIOS'] = 'NO diligenciado';
        $aux['DERECCION DEL TALLERISTA'] = 'NO diligenciado';
        $aux['UTILIDAD DIARIO VIVIR'] = 'NO diligenciado';
    }
    $aux['DIARIO DE CAMPO DEL TALLER SOBRE ASERTIVIDAD'] = $g['inf_s8'];
    array_push($sesion_8, $aux);
    $count_grupo = 0;
    $total_temas_grupo = 0;
    $total_ejercicios_grupo = 0;
    $total_tallerista_grupo = 0;
    $total_utilidad_grupo = 0;
}
$aux['INSTITUCION'] = 'Todos los participantes';
$aux['TEMAS TRABAJADOS'] = number_format($total_temas_todos / $count_todos, 2);
$aux['EJERCICIOS'] = number_format($total_ejercicios_todos / $count_todos, 2);
$aux['DERECCION DEL TALLERISTA'] = number_format($total_tallerista_todos / $count_todos, 2);
$aux['UTILIDAD DIARIO VIVIR'] = number_format($total_utilidad_todos / $count_todos, 2);
$aux['DIARIO DE CAMPO DEL TALLER SOBRE ASERTIVIDAD'] = '';
array_push($sesion_8, $aux);


if (isset($_POST["export_data"])) {
    function cleanData(&$str)
    {
        $str = mb_convert_encoding($str, "ISO-8859-1", "UTF-8");
        $str = preg_replace("/\t/", " ", $str);
        $str = preg_replace("/\r?\n/", " ", $str);
        if (strstr($str, '"')) $str = '"' . str_replace('"', '""', $str) . '"';
    }

  // filename for download
    $filename = "resultados_OSO_" . date('Ymd') . ".xls";

    header("Content-Type:   application/vnd.ms-excel;");
    header("Content-Disposition: attachment; filename=\"$filename\"");


    $flag = false;
    echo 'SESION 1' . "\r\n";
    foreach ($sesion_1 as $row) {
        if (!$flag) {
      // display field/column names as first row
            echo implode("\t", array_keys($row)) . "\r\n";
            $flag = true;
        }
        array_walk($row, __NAMESPACE__ . '\cleanData');
        echo implode("\t", array_values($row)) . "\r\n";
    }
    $flag = false;
    echo "\r\n";
    echo "\r\n";
    echo 'SESION 2' . "\r\n";
    foreach ($sesion_2 as $row) {
        if (!$flag) {
      // display field/column names as first row
            echo implode("\t", array_keys($row)) . "\r\n";
            $flag = true;
        }
        array_walk($row, __NAMESPACE__ . '\cleanData');
        echo implode("\t", array_values($row)) . "\r\n";
    }
    $flag = false;
    echo "\r\n";
    echo "\r\n";
    echo 'SESION 3' . "\r\n";
    foreach ($sesion_3 as $row) {
        if (!$flag) {
      // display field/column names as first row
            echo implode("\t", array_keys($row)) . "\r\n";
            $flag = true;
        }
        array_walk($row, __NAMESPACE__ . '\cleanData');
        echo implode("\t", array_values($row)) . "\r\n";
    }
    $flag = false;
    echo "\r\n";
    echo "\r\n";
    echo 'SESION 4' . "\r\n";
    foreach ($sesion_4 as $row) {
        if (!$flag) {
      // display field/column names as first row
            echo implode("\t", array_keys($row)) . "\r\n";
            $flag = true;
        }
        array_walk($row, __NAMESPACE__ . '\cleanData');
        echo implode("\t", array_values($row)) . "\r\n";
    }
    $flag = false;
    echo "\r\n";
    echo "\r\n";
    echo 'SESION 5' . "\r\n";
    foreach ($sesion_5 as $row) {
        if (!$flag) {
      // display field/column names as first row
            echo implode("\t", array_keys($row)) . "\r\n";
            $flag = true;
        }
        array_walk($row, __NAMESPACE__ . '\cleanData');
        echo implode("\t", array_values($row)) . "\r\n";
    }
    $flag = false;
    echo "\r\n";
    echo "\r\n";
    echo 'SESION 6' . "\r\n";
    foreach ($sesion_6 as $row) {
        if (!$flag) {
      // display field/column names as first row
            echo implode("\t", array_keys($row)) . "\r\n";
            $flag = true;
        }
        array_walk($row, __NAMESPACE__ . '\cleanData');
        echo implode("\t", array_values($row)) . "\r\n";
    }
    $flag = false;
    echo "\r\n";
    echo "\r\n";
    echo 'SESION 7' . "\r\n";
    foreach ($sesion_7 as $row) {
        if (!$flag) {
      // display field/column names as first row
            echo implode("\t", array_keys($row)) . "\r\n";
            $flag = true;
        }
        array_walk($row, __NAMESPACE__ . '\cleanData');
        echo implode("\t", array_values($row)) . "\r\n";
    }
    $flag = false;
    echo "\r\n";
    echo "\r\n";
    echo 'SESION 8' . "\r\n";
    foreach ($sesion_8 as $row) {
        if (!$flag) {
      // display field/column names as first row
            echo implode("\t", array_keys($row)) . "\r\n";
            $flag = true;
        }
        array_walk($row, __NAMESPACE__ . '\cleanData');
        echo implode("\t", array_values($row)) . "\r\n";
    }
    exit;
}
?>
<!DOCTYPE html>
<html>
  <head>
    <link rel="stylesheet" type="text/css" href="styles/test.css">
    <link rel="stylesheet" type="text/css" href="styles/test.css" media="print">
    <title>Proyecto Psicologia</title>
</head>

<body>

<div class="container">
 <h2>Exportar datos a Excel con PHP y MySQL</h2>

 <div class="well-sm col-sm-12">
 <div class="btn-group pull-right">
 <form action=" <?php echo $_SERVER["PHP_SELF"]; ?>" method="post">
 <button type="submit" id="export_data" name='export_data'
value="Export to excel" class="btn btn-info">Exportar a Excel</button>
 </form>
 </div>
 </div>
 <?php

?>
</body>


