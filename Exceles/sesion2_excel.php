<?php
include_once("../config.php");
if (!isset($_SESSION)) {
    session_start();
}
include_once("../functions.php");
if (!func::checkLoginState($dbh)) {
    echo '<script language="javascript">window.location="login.php"</script>';
}
header("Content-Type: application/xls");
header("Content-Disposition: attachment; filename=sesion2.xls");
?>



<style>
    table {
    font-family: arial, sans-serif;
    border-collapse: collapse;
    width: 100%;
    }

    td, th {
    border: 1px solid #dddddd;
    text-align: left;
    padding: 8px;
    }

}
</style>


<?php 
$query = ' SELECT * FROM grupo';
$rowtmt = $dbh->prepare($query);
$rowtmt->execute();
$groups = $rowtmt->fetchAll(PDO::FETCH_ASSOC);

$output = "<table>";

foreach ($groups as $g) {

    if ($g['nombre'] == "grupo de pruebas") {
        continue;
    }


    $query = 'SELECT * FROM grupo INNER JOIN estudiantes Inner join sesion_2 on grupo.id=estudiantes.grupo_id and estudiantes.id=sesion_2.id_estudiante where grupo.id=? ';
        //echo $query;
    $rowtmt = $dbh->prepare($query);
    $rowtmt->execute([$g['id']]);
    $rows = $rowtmt->fetchAll(PDO::FETCH_ASSOC);
    $output .= "<tr>
                    <th>" . $g['nombre'] . "</th>
                    </tr>";
    $output .= "<tr>
                <th>Nombre</th>
                <th>  factor tendencia a no centrarse en el futuro 1 </div> </th>
    <th>  factor tendencia a no centrarse en el futuro 2 </div> </th>
    <th>  factor tendencia a no centrarse en el futuro 3 </div> </th>
    <th>  factor tendencia a no centrarse en el futuro 4 </div> </th>
    <th>  factor tendencia a no centrarse en el futuro 5 </div> </th>
    <th>  factor tendencia a no centrarse en el futuro 6 </div> </th>
    <th>  factor tendencia a no centrarse en el futuro 7 </div> </th>
    <th>  factor tendencia a no centrarse en el futuro 8 </div> </th>
    <th>  factor planeacion activa del futuro 1 </div> </th>
    <th>  factor planeacion activa del futuro 2 </div> </th>
    <th>  factor planeacion activa del futuro 3 </div> </th>
    <th>  factor planeacion activa del futuro 4 </div> </th>
    <th>  factor influencia de la conducta pasada y presente en el futuro 1 </div> </th>
    <th>  factor influencia de la conducta pasada y presente en el futuro 2 </div> </th>
    <th>  factor influencia de la conducta pasada y presente en el futuro 3 </div> </th>
    <th>  factor influencia de la conducta pasada y presente en el futuro 4 </div> </th>
    <th>  factor influencia de la conducta pasada y presente en el futuro 5 </div> </th>
    <th>  factor tendencia a imaginarse la vida en el futuro 1 </div> </th>
    <th>  factor tendencia a imaginarse la vida en el futuro 2 </div> </th>
    <th>  factor tendencia a imaginarse la vida en el futuro 3 </div> </th>
    <th>  factor tendencia a imaginarse la vida en el futuro 4 </div> </th>

    <th>  total factor tendencia a no centrarse en el futuro  </div> </th>
    <th>  total factor planeacion activa del futuro  </div> </th>
    <th>  total factor influencia de la conducta pasada y presente en el futuro </div> </th>
    <th>  total factor tendencia a imaginarse la vida en el futuro  </div> </th>

    <th>  extension temporal economico comprar casa </div> </th>
    <th>  extension temporal economico comprar carro </div> </th>
    <th>  extension temporal laboral conseguir empleo estable </div> </th>
    <th>  extension temporal laboral terminar una carrera profesional </div> </th>
    <th>  extension temporal laboral crear negocio propio </div> </th>
    <th>  extension temporal familiar casarme o irme con mi pareja </div> </th>
    <th>  extension temporal familiar irme de mi casa o dejar de vivir con mis padres </div> </th>
    <th>  extension temporal familiar tener mi primer hijo </div> </th>
    <th>  ¿Cuantos años quisieras vivir? diferencia entre la edad acutal y la edad proyectada </div> </th>
    <th>  ¿Cuantos años crees que vas a vivir? diferencia entre la edad acutal y la edad proyectada </div> </th>
    <th>  extension temporal academico terminar mis estudios de bachillerato </div> </th>
    <th>  extension temporal academico irme al ejercito o la policia </div> </th>
    <th>  extension temporal academico ingresar a estudiar una carrera profesional </div> </th>
    <th>total escala de extension economico </th>
    <th>total escala de extension laboral </th>
    <th>total escala de extension familiar </th>
    <th>total escala de extension vida </th>
    <th>total escala de extension academico </th>
    <th>Observaciones </th>
                </tr>";

        //echo '<b> Institucion: ' . $g['nombre'] . '</b><br>';

    foreach ($rows as $row) {
        if ($row['asistencia'] != 1) {
            continue;
        }

        $output .= "<tr>
                <th>" . $row['nombre'] . "</th>";
        for ($i = 1; $i <= 8; $i++) {
            $output .= "<td>" . $row["factor_tncf_$i"] . "</td>";
        }
        for ($i = 1; $i <= 4; $i++) {
            $output .= "<td>" . $row["factor_paf_$i"] . "</td>";
        }
        for ($i = 1; $i <= 5; $i++) {
            $output .= "<td>" . $row["factor_icppf_$i"] . "</td>";

        }
        for ($i = 1; $i <= 4; $i++) {
            $output .= "<td>" . $row["factor_tivf_$i"] . "</td>";
        }

        $output .= "<td>" . $row["total_factor_tncf"] . " /></td>
                  <td> " . $row["total_factor_paf"] . "</td>
                  <td> " . $row["total_factor_icppf"] . "</td>
                  <td> " . $row["total_factor_tivf"] . "</td>";

        for ($i = 1; $i <= 2; $i++) {
            $output .= "<td>" . $row["eet_economico_$i"] . "</td>";
        }
        for ($i = 1; $i <= 3; $i++) {
            $output .= "<td>" . $row["eet_laboral_$i"] . "</td>";

        }
        for ($i = 1; $i <= 3; $i++) {
            $output .= "<td>" . $row["eet_familiar_$i"] . "</td>";

        }

        for ($i = 1; $i <= 2; $i++) {
            $output .= "<td>" . $row["eet_vida_$i"] . "</td>";

        }
        for ($i = 1; $i <= 3; $i++) {
            $output .= "<td>" . $row["eet_academico_$i"] . "</td>";

        }

        $output .= "<td> " . $row["total_eet_economico"] . "</td>
                  <td> " . $row["total_eet_laboral"] . "</td>
                  <td> " . $row["total_eet_familiar"] . "</td>
                  <td> " . $row["total_eet_vida"] . "</td>
                  <td> " . $row["total_eet_academico"] . "</td>
                  <td> " . $row["observaciones"] . "</td>
                </tr>";
    }


    $output .= "<tr>
                    <th></th>
                    </tr>
                    <tr>
                    <th></th>
                    </tr>
                    ";
}




$output = mb_convert_encoding($output, "ISO-8859-1", "UTF-8");

echo $output;

?>