<?php

header("Content-Type: application/xls");
header("Content-Disposition: attachment; filename=sesion5.xls");


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


        $query = ' SELECT * FROM grupo INNER JOIN estudiantes Inner join sesion_5 on grupo.id=estudiantes.grupo_id and estudiantes.id=sesion_5.id_estudiante where grupo.id=? ';
        //echo $query;
        $stmt = $dbh->prepare($query);
        $stmt->execute([$g['id']]);
        $rows = $stmt->fetchAll(PDO::FETCH_ASSOC);
        $output .= "<tr>
                    <th>". $g['nombre'] ."</th>
                    </tr>";
        $output.="<tr>
                <th>Nombre</th>
                <th>item_1 </th>
                <th>item_2 </th>
                <th>item_3 </th>
                <th>item_4 </th>
                <th>item_5 </th>
                <th>item_6 </th>
                <th>item_7 </th>
                <th>item_8 </th>
                <th>item_9 </th>
                <th>item_10</th>
                <th>total</th>
                <th>estilo</th>
                <th>observaciones</th>
               
                </tr>";

        //echo '<b> Institucion: ' . $g['nombre'] . '</b><br>';
        
        foreach ($rows as $row) {
            if($row['asistencia'] != 1){
                continue;
              }

            $output.="<tr>
                    <th>". $row['nombre'] ."</th>
                    <th>". $row['item_1'] ."</th>
                    <th>". $row['item_2'] ."</th>
                    <th>". $row['item_3'] ."</th>
                    <th>". $row['item_4'] ."</th>
                    <th>". $row['item_5'] ."</th>
                    <th>". $row['item_6'] ."</th>
                    <th>". $row['item_7'] ."</th>
                    <th>". $row['item_8'] ."</th>
                    <th>". $row['item_9'] ."</th>
                    <th>". $row['item_10'] ."</th>
                    <th>". $row['total'] ."</th>
                    <th>". $row['estilo'] ."</th>
                    <th>". $row['observaciones'] ."</th>
                    
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