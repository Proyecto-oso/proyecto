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
header("Content-Disposition: attachment; filename=sesion3.xls");
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


    $query = ' SELECT * FROM grupo INNER JOIN estudiantes Inner join sesion_3 on grupo.id=estudiantes.grupo_id and estudiantes.id=sesion_3.id_estudiante where grupo.id=?';
        //echo $query;
    $rowtmt = $dbh->prepare($query);
    $rowtmt->execute([$g['id']]);
    $rows = $rowtmt->fetchAll(PDO::FETCH_ASSOC);
    $output .= "<tr>
                    <th>" . $g['nombre'] . "</th>
                    </tr>";
    $output .= "<tr>
    <th>Institución</th>
                <th>Nombre</th>
    <th>pregunta 1 </th>
    <th>pregunta 2 </th>
    <th>pregunta 3 </th>
    <th>pregunta 4 </th>
    <th>pregunta 5 </th>
    <th>pregunta 6 </th>
    <th>pregunta 7 </th>
    <th>pregunta 8 </th>
    <th>pregunta 9 </th>
    <th>pregunta 10 </th>
    <th>pregunta 11 </th>
    <th>pregunta 12 </th>
    <th>pregunta 13 </th>
    <th>pregunta 14 </th>
    <th>pregunta 15 </th>
    <th>pregunta 16 </th>
    <th>pregunta 17 </th>
    <th>pregunta 18 </th>
    <th>pregunta 19 </th>
    <th>pregunta 20 </th>
    <th>pregunta 21 </th>
    <th>pregunta 22 </th>
    <th>pregunta 23 </th>
    <th>pregunta 24 </th>
    <th>pregunta 25 </th>
    <th>pregunta 26 </th>
    <th>pregunta 27 </th>
    <th>pregunta 28 </th>
    <th>pregunta 29 </th>
    <th>pregunta 30 </th>
    <th>pregunta 31 </th>
    <th>pregunta 32 </th>
    <th>pregunta 33 </th>
    <th>pregunta 34 </th>
    <th>pregunta 35 </th>
    <th>pregunta 36 </th>
    <th>pregunta 37 </th>
    <th>pregunta 38 </th>
    <th>pregunta 39 </th>
    <th>pregunta 40 </th>
    <th>pregunta 41 </th>
    <th>pregunta 42 </th>
    <th>pregunta 43 </th>
    <th>pregunta 44 </th>
    <th>Total activo </th>
    <th>Total reflexivo </th>
    <th>Diferencia </th>
    <th>Total sensible </th>
    <th>Total intuitivo </th>
    <th>Diferencia </th>
    <th>Total visual </th>
    <th>Total verbal </th>
    <th>Diferencia </th>
    <th>Total secuencial </th>
    <th>Total global </th>
    <th>Diferencia </th>


    <th>interes mas predominante </th>
    <th>interes menos predominante </th>
    <th>estilo de aprendizaje predominante </th>
    <th>Aspecto de los temas trabajados </th>
    <th>Aspecto de los ejercicios  </th>
    <th>Aspecto de la dirección del tallerista </th>
    <th>Aspecto de la utilidad para tu diario vivir </th>
    <th>Observaciones </th>
                </tr>";

        //echo '<b> Institucion: ' . $g['nombre'] . '</b><br>';

    $tmp_id = [];

    foreach ($rows as $row) {
        if ($row['asistencia'] != 1) {
            continue;
        }
        if(in_array($row['id'], $tmp_id)){
            continue;
        }else{

            array_push($tmp_id,$row["id"]);
        }

        $output .= "<tr>
        <th>" . $g['nombre'] . "</th>
                <th>" . $row['nombre'] . "</th>";

        for ($i = 1; $i <= 44; $i++) {
            $output .= "<td>" . $row['pregunta_' . $i] . "</td>";
        }
        $output .= "<td>" . $row["t_activo"] . "</td>
            <td>" . $row["t_reflexivo"] . "</td>
            <td>" . $row["d_act_ref"] . "</td>
            <td>" . $row["t_sensible"] . "</td>
            <td>" . $row["t_intuitivo"] . "</td>
            <td>" . $row["d_sen_int"] . "</td>
            <td>" . $row["t_visual"] . "</td>
            <td>" . $row["t_verbal"] . "</td>
            <td>" . $row["d_vis_ver"] . "</td>
            <td>" . $row["t_secuencial"] . "</td>
            <td>" . $row["t_global"] . "</td>
            <td>" . $row["d_sec_glo"] . "</td>
            <td>" . $row['mas_predominante'] . "</td>
            <td>" . $row['menos_predominante'] . "</td>
            <td>" . $row['est_predominante'] . "</td>
            <td> " . $row['temas_trabajados'] . " </td>
            <td> " . $row['ejercicios'] . "</td>
            <td>" . $row['tallerista'] . "</td>
            <td> " . $row['utilidad'] . "</td> 
            <td>" . $row['observaciones'] . "</td>
        </tr> ";

            //echo    $row [ " nombre "],  $row ['total_aptitud_verbal'],  $row ['total_aptitud_matematica'];
            //echo  " < br / > ";          
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