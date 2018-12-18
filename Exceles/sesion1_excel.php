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
header("Content-Disposition: attachment; filename=sesion1.xls");
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
    .colegio{
        background-color: #61AC59;
        font-size: 20px
    }

}
</style>


<?php 
$query = ' SELECT * FROM grupo';
$stmt = $dbh->prepare($query);
$stmt->execute();
$groups = $stmt->fetchAll(PDO::FETCH_ASSOC);

$output = "<table>";

foreach ($groups as $g) {

    if ($g['nombre'] == "grupo de pruebas") {
        continue;
    }


    $query = ' SELECT * FROM grupo INNER JOIN estudiantes Inner join sesion_1 on grupo.id=estudiantes.grupo_id and estudiantes.id=sesion_1.id_estudiante where grupo.id=?';
        //echo $query;
    $stmt = $dbh->prepare($query);
    $stmt->execute([$g['id']]);
    $rows = $stmt->fetchAll(PDO::FETCH_ASSOC);
    $output .= "<tr>
                <th class=\"colegio\" >" . $g['nombre'] . "</th>
                    </tr>";
    $output .= "<tr>
    <th>Institución</th>
                <th>Nombre</th>
                <th >AV 1</th>
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
    <th>Informe Valores, Intereses y Aptitudes</th>
    <th>Observaciones</th>
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
                <th>" . $row['nombre'] . "</th>
                <td>" . $row["aptitud_verbal_1"] . "</td>";
        for ($i = 2; $i <= 15; $i++) {
            $output .= "<td>" . $row["aptitud_verbal_$i"] . "</td>";
        }
        $output .= "<td>" . $row["total_aptitud_verbal"] . "</td>";
        for ($i = 1; $i <= 15; $i++) {
            $output .= "<td>" . $row["aptitud_matematica_$i"] . "</td>";
        }
        $output .= "<td>" . $row["total_aptitud_matematica"] . "</td>
                <td> " . $row["informe_via"] . "</td>
                <td>" . $row["observaciones"] . " </td>
                </tr>";

            //echo  $row["nombre"],$row['total_aptitud_verbal'],$row['total_aptitud_matematica'];
            //echo "<br/>";          
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