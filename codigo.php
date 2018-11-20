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
                <div class="titulo"><h2>INFORME DE ORIENTACIÓN SOCIO OCUPACIONAL - SESIÓN 2</h2></div>
                <?php

                //****************************
                $suma_total_factor_tncf_todos   = 0;
                $suma_total_factor_paf_todos    = 0;
                $suma_total_factor_icppf_todos  = 0;
                $suma_total_factor_tivf_todos   = 0;
                $suma_total_eet_economico_todos = 0;
                $suma_total_eet_laboral_todos   = 0;
                $suma_total_eet_familiar_todos  = 0;
                $suma_total_eet_vida_todos      = 0;
                $suma_total_eet_academico_todos = 0;

                //*****************************
                $suma_total_factor_tncf_grupo   = 0;
                $suma_total_factor_paf_grupo    = 0;
                $suma_total_factor_icppf_grupo  = 0;
                $suma_total_factor_tivf_grupo   = 0;
                $suma_total_eet_economico_grupo = 0;
                $suma_total_eet_laboral_grupo   = 0;
                $suma_total_eet_familiar_grupo  = 0;
                $suma_total_eet_vida_grupo      = 0;
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

                      $suma_total_factor_tncf_todos   += $row['total_factor_tncf'];
                      $suma_total_factor_paf_todos    += $row['total_factor_paf'];
                      $suma_total_factor_icppf_todos  += $row['total_factor_icppf'];
                      $suma_total_factor_tivf_todos   += $row['total_factor_tivf'];
                      $suma_total_eet_economico_todos += $row['total_eet_economico'];
                      $suma_total_eet_laboral_todos   += $row['total_eet_laboral'];
                      $suma_total_eet_familiar_todos  += $row['total_eet_familiar'];
                      $suma_total_eet_vida_todos      += $row['total_eet_vida'];
                      $suma_total_eet_academico_todos += $row['total_eet_academico'];

                      // suma grupos

                      $suma_total_factor_tncf_grupo   += $row['total_factor_tncf'];
                      $suma_total_factor_paf_grupo    += $row['total_factor_paf'];
                      $suma_total_factor_icppf_grupo  += $row['total_factor_icppf'];
                      $suma_total_factor_tivf_grupo   += $row['total_factor_tivf'];
                      $suma_total_eet_economico_grupo += $row['total_eet_economico'];
                      $suma_total_eet_laboral_grupo   += $row['total_eet_laboral'];
                      $suma_total_eet_familiar_grupo  += $row['total_eet_familiar'];
                      $suma_total_eet_vida_grupo      += $row['total_eet_vida'];
                      $suma_total_eet_academico_grupo += $row['total_eet_academico'];



                      $count_grupo++;
                      $count_todos++;
                    }

                    //echo $count_grupo.','.$suma_v_grupo.'<br>';
                    if ($count_grupo != 0) {

                      $total_factor_tncf_grupo   = $suma_total_factor_tncf_grupo/$count_grupo;
                      $total_factor_paf_grupo    = $suma_total_factor_paf_grupo/$count_grupo;
                      $total_factor_icppf_grupo  = $suma_total_factor_icppf_grupo/$count_grupo;
                      $total_factor_tivf_grupo   = $suma_total_factor_tivf_grupo/$count_grupo;
                      $total_eet_economico_grupo = $suma_total_eet_economico_grupo/$count_grupo;
                      $total_eet_laboral_grupo   = $suma_total_eet_laboral_grupo/$count_grupo;
                      $total_eet_familiar_grupo  = $suma_total_eet_familiar_grupo/$count_grupo;
                      $total_eet_vida_grupo      = $suma_total_eet_vida_grupo/$count_grupo;
                      $total_eet_academico_grupo = $suma_total_eet_academico_grupo/$count_grupo;

                        echo 'grupo: ' . $g['nombre'] . '<br>    promedio factor tendencia a no centrarse en el futuro: ' . number_format($total_factor_tncf_grupo,3) . '<br> promedio factor planeacion activa del futuro: ' . number_format($total_factor_paf_grupo,3) . '<br>';
                        echo 'promedio factor influencia de la conducta pasada y presente en el futuro: '.number_format($total_factor_icppf_grupo,3).'<br> promedio factor tendencia a imaginarse la vida en el futuro: '.number_format($total_factor_tivf_grupo,3).'<br>';
                        echo 'promedio escala de extension economico: '.number_format($total_eet_economico_grupo,3).'<br>promedio escala de extension laboral: '.number_format($total_eet_laboral_grupo,3).'<br>promedio escala de extension familiar: '.number_format($total_eet_familiar_grupo,3).'<br>promedio escala de extension vida: '.number_format($total_eet_vida_grupo,3).'<br>';
                        echo 'promedio escala de extension academico: '.number_format($total_eet_academico_grupo,3).'<br><br><br>';
                    }else {
                        echo 'grupo: ' . $g['nombre'] . ' no ha sido diligenciado aun <br><br><br>';
                    }
                    $count_grupo = 0;
                    $suma_total_factor_tncf_grupo   = 0;
                    $suma_total_factor_paf_grupo    = 0;
                    $suma_total_factor_icppf_grupo  = 0;
                    $suma_total_factor_tivf_grupo   = 0;
                    $suma_total_eet_economico_grupo = 0;
                    $suma_total_eet_laboral_grupo   = 0;
                    $suma_total_eet_familiar_grupo  = 0;
                    $suma_total_eet_vida_grupo      = 0;
                    $suma_total_eet_academico_grupo = 0;

                  }

                  $total_factor_tncf_estudiantes   = $suma_total_factor_tncf_todos/$count_todos;
                  $total_factor_paf_estudiantes    = $suma_total_factor_paf_todos/$count_todos;
                  $total_factor_icppf_estudiantes  = $suma_total_factor_icppf_todos/$count_todos;
                  $total_factor_tivf_estudiantes   = $suma_total_factor_tivf_todos/$count_todos;
                  $total_eet_economico_estudiantes = $suma_total_eet_economico_todos/$count_todos;
                  $total_eet_laboral_estudiantes   = $suma_total_eet_laboral_todos/$count_todos;
                  $total_eet_familiar_estudiantes  = $suma_total_eet_familiar_todos/$count_todos;
                  $total_eet_vida_estudiantes      = $suma_total_eet_vida_todos/$count_todos;
                  $total_eet_academico_estudiantes = $suma_total_eet_academico_todos/$count_todos;

                echo 'TODOS LOS ESTUDIANTES ' . '<br>    promedio total factor tendencia a no centrarse en el futuro: ' . number_format($total_factor_tncf_estudiantes,3) . '<br> promedio total factor planeacion activa del futuro: ' . number_format($total_factor_paf_estudiantes,3) . '<br>';
                echo 'promedio total factor influencia de la conducta pasada y presente en el futuro: '.number_format($total_factor_icppf_estudiantes,3).'<br> promedio total factor tendencia a imaginarse la vida en el futuro: '.number_format($total_factor_tivf_estudiantes,3).'<br>';
                echo 'promedio total escala de extension economico: '.number_format($total_eet_economico_estudiantes,3).'<br>promedio total escala de extension laboral: '.number_format($total_eet_laboral_estudiantes,3).'<br>promedio total escala de extension familiar: '.number_format($total_eet_familiar_estudiantes,3).'<br>promedio total escala de extension vida: '.number_format($total_eet_vida_grupo,3).'<br>';
                echo 'promedio total escala de extension academico: '.number_format($total_eet_academico_estudiantes,3).'<br><br><br>';

                $query = ' SELECT * FROM `grupo` WHERE id = ' . $_SESSION['grupo_id'] . ' ';
                $stmt = $dbh->prepare($query);
                $stmt->execute([$_SESSION['grupo_id']]);
                $rows = $stmt->fetchAll(PDO::FETCH_ASSOC);
                foreach ($rows as $row) {
                  echo 'INFORME SOBRE EVENTOS POSITIVOS Y NEGATIVOS DEL GRUPO: '.$row["informe_pn"].'<br>'  ;
                  echo 'INFORME METAS, RECURSOS Y BARRERAS DEL GRUPO: '.$row["informe_mrb"].'<br>' ;
                }

                $total_factor_tncf_estudiantes    = 0;
                $total_factor_paf_estudiantes     = 0;
                $total_factor_icppf_estudiantes   = 0;
                $total_factor_tivf_estudiantes    = 0;
                $total_eet_economico_estudiantes  = 0;
                $total_eet_laboral_estudiantes    = 0;
                $total_eet_familiar_estudiantes   = 0;
                $total_eet_vida_estudiantes       = 0;
                $total_eet_academico_estudiantes  = 0;

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
        $suma_amigos_todos  = 0;
        $suma_familia_todos = 0;
        $suma_otro_todos    = 0;
        $suma_total_todos  = 0;

        //*****************************
        $suma_amigos_grupo   = 0;
        $suma_familia_grupo  = 0;
        $suma_otro_grupo     = 0;
        $suma_total_grupo    = 0;

        foreach ($groups as $g) {

            $query = ' SELECT grupo.id, estudiantes.id, sesion_4.amigos, sesion_4.familia, sesion_4.otro, sesion_4.total FROM grupo INNER JOIN estudiantes Inner join sesion_4 on grupo.id=estudiantes.grupo_id and estudiantes.id=sesion_4.id_estudiante where grupo.id=?';
            //echo $query;
            $stmt = $dbh->prepare($query);
            $stmt->execute([$g['id']]);
            $rows = $stmt->fetchAll(PDO::FETCH_ASSOC);
            foreach ($rows as $row) {

              //****************************
              $suma_amigos_todos   += $row['amigos'];
              $suma_familia_todos  += $row['familia'];
              $suma_otro_todos     += $row['otro'];
              $suma_total_todos    += $row['total'];

              //*****************************
              $suma_amigos_grupo   += $row['amigos'];
              $suma_familia_grupo  += $row['familia'];
              $suma_otro_grupo     += $row['otro'];
              $suma_total_grupo    += $row['total'];

              $count_grupo++;
              $count_todos++;
            }
            //echo $count_grupo.','.$suma_v_grupo.'<br>';
            if ($count_grupo != 0) {
              $total_amigos_grupo = $suma_amigos_grupo/$count_grupo;
              $total_familia_grupo = $suma_familia_grupo/$count_grupo;
              $total_otro_grupo = $suma_otro_grupo/$count_grupo;
              $total_total_grupo = $suma_total_grupo/$count_grupo;

              echo 'grupo: ' . $g['nombre'] . '<br>   Total amigos: ' . number_format($total_amigos_grupo,3) . '<br> Total Familia: ' . number_format($total_familia_grupo,3) . '<br>';
              echo 'Total Otro significativo: '.number_format($total_otro_grupo,3).'<br> Puntaje total: '.number_format($total_total_grupo,3).'<br><br><br>';
            } else {
                echo 'grupo: ' . $g['nombre'] . ' no ha sido diligenciado aun '.'<br><br><br>';
            }
            $count_grupo = 0;
            $suma_amigos_grupo = 0;
            $suma_familia_grupo = 0;
            $suma_otro_grupo = 0;
            $suma_total_grupo = 0;

        }

        $total_amigos_estudiantes  = $suma_amigos_todos/ $count_todos;
        $total_familia_estudiantes = $suma_familia_todos/ $count_todos;
        $total_otro_estudiantes    = $suma_otro_todos/ $count_todos;
        $total_total_estudiantes   = $suma_total_todos/ $count_todos;


        echo 'TODOS LOS ESTUDIANTES ' . '<br>   Total amigos: ' . number_format($total_amigos_estudiantes,3) . '<br> Total Familia: ' . number_format($total_familia_estudiantes,3) . '<br>';
        echo 'Total Otro significativo: '.number_format($total_otro_estudiantes,3).'<br> Puntaje total: '.number_format($total_total_estudiantes,3).'<br><br><br>';
        ?>
    </div>
</div>

</body>
