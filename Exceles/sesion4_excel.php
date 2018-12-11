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
header("Content-Disposition: attachment; filename=sesion4.xls");
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


    $query = ' SELECT * FROM grupo INNER JOIN estudiantes Inner join sesion_4 on grupo.id=estudiantes.grupo_id and estudiantes.id=sesion_4.id_estudiante where grupo.id=?';
        //echo $query;
    $rowtmt = $dbh->prepare($query);
    $rowtmt->execute([$g['id']]);
    $rows = $rowtmt->fetchAll(PDO::FETCH_ASSOC);
    $output .= "<tr>
                    <th>" . $g['nombre'] . "</th>
                    </tr>";
    $output .= "<tr>
        <th>Nombre </th>
        <th>item 1 </th>
        <th>item 2 </th>
        <th>item 3 </th>
        <th>item 4 </th>
        <th>item 5 </th>
        <th>item 6 </th>
        <th>item 7 </th>
        <th>item 8 </th>
        <th>item 9 </th>
        <th>item 10 </th>
        <th>item 11 </th>
        <th>item 12 </th>
    
        <th>Amigos </th>
        <th>Familia </th>
        <th>Otro significativo </th>
        <th>Puntaje total </th>
        <th>Zonas de riesgo </th>
        <th>Zonas seguras  </th>
        <th>Zonas de ayuda </th>
        <th>Personas que ayudan </th>
        <th>Mecanismo utilizados de violencia </th>
        <th>Personas que ejercen la violencia </th>
        <th>Violencias vividas </th>
        <th>Zonas de violencia </th>
        <th>Cantidad  cigarrillos consumidos </th>
        <th>Frecuencia de consumo de cigarrillo </th>
        <th>Lugar de consumo de cigarrillo </th>
        <th>Cantidad  alcohol consumidos </th>
        <th>Frecuencia de consumo de alcohol </th>
        <th>Lugar de consumo de alcohol </th>
        <th>Cantidad  sustancias psicoactivas consumidos </th>
        <th>Frecuencia de consumo de sustancias psicoactivas </th>
        <th>Lugar de consumo de sustancias psicoactivas </th>
        <th>No. de parejas </th>
        <th>métodos para evitar el embarazo </th>
        <th>No. de embarazos </th>
        <th>No. de abortos </th>
        <th>Presencia de relaciones forzadas y número </th>
        <th>Diagnóstico de enfermedad de transmisión sexual </th>
        <th>Si ha vivido en la calle </th>
        <th>Observaciones </th>
                </tr>";

        //echo '<b> Institucion: ' . $g['nombre'] . '</b><br>';

    foreach ($rows as $row) {
        if ($row['asistencia'] != 1) {
            continue;
        }

        $output .= "<tr>
                        <th>" . $row['nombre'] . "</th>";

        for ($i = 1; $i <= 12; $i++) {
            $output .= "<td>" . $row["item_" . $i] . " </td>";
        }
        $output .= "<td>" . $row["amigos"] . "</td>
          <td>" . $row["familia"] . "</td>
          <td>" . $row["otro"] . "</td>
          <td>" . $row["total"] . "</td>





        <td>" . $row["zona_riesgo"] . "</td>
        <td>" . $row["zona_segura"] . "</td>
        <td>" . $row["zona_ayuda"] . "</td>
        <td>" . $row["per_ayudan"] . "</td>
        <td>" . $row["mec_violencia"] . "</td>
        <td>" . $row["per_violencia"] . "</td>
        <td>" . $row["vio_vividas"] . "</td>
        <td>" . $row["zon_violencia"] . "</td>
        <td>" . $row["cantidad_cigarrillos"] . "</td>
        <td>" . $row["frecuencia_cigarrillos"] . "</td>
        <td>" . $row["lugar_cigarrillos"] . "</td>
        <td>" . $row["cantidad_alcohol"] . "</td>
        <td>" . $row["frecuencia_alcohol"] . "</td>
        <td>" . $row["lugar_alcohol"] . "</td>
        <td>" . $row["cantidad_psicoactivas"] . "</td>
        <td>" . $row["frecuencia_psicoactivas"] . "</td>
        <td>" . $row["lugar_psicoactivas"] . "</td>
        <td>" . $row["n_parejas"] . "</td>
        <td>" . $row["met_embarazo"] . "</td>
        <td>" . $row["n_embarazo"] . "</td>
        <td>" . $row["n_abortos"] . "</td>
        <td>" . $row["pre_relacion_f"] . "</td>
        <td>" . $row["ets"] . "</td>
        <td>" . $row["calle"] . "</td>
        <td>" . $row["observaciones"] . "</td>
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