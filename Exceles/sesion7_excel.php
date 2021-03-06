<?php

header("Content-Type: application/xls");
header("Content-Disposition: attachment; filename=sesion7.xls");


include_once("../config.php");
if (!isset($_SESSION)) {
    session_start();
}
include_once("../functions.php");
if (!func::checkLoginState($dbh)) {
    echo '<script language="javascript">window.location="login.php"</script>';
}   
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

    foreach ($groups as $g){

        if ($g['nombre'] == "grupo de pruebas") {
            continue;
        }


        $query = ' SELECT grupo.id, estudiantes.id, estudiantes.nombre,sesion_1.total_aptitud_matematica, sesion_1.total_aptitud_verbal FROM grupo INNER JOIN estudiantes Inner join sesion_1 on grupo.id=estudiantes.grupo_id and estudiantes.id=sesion_1.id_estudiante where grupo.id=?';
        //echo $query;
        $stmt = $dbh->prepare($query);
        $stmt->execute([$g['id']]);
        $rows = $stmt->fetchAll(PDO::FETCH_ASSOC);
        $output .= "<tr>
                    <th class=\"colegio\" >" . $g['nombre'] . "</th>
                    </tr>";
        $output.="<tr>
                <th>Informe grupal </th>
                <th>".$g['inf_s7']." </th>
                </tr>";

        

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