<?php
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


        $query = ' SELECT grupo.id, estudiantes.id, estudiantes.nombre, sesion_6.asistencia , sesion_6.total FROM grupo INNER JOIN estudiantes Inner join sesion_6 on grupo.id=estudiantes.grupo_id and estudiantes.id=sesion_6.id_estudiante where grupo.id=? ';
        //echo $query;
        $stmt = $dbh->prepare($query);
        $stmt->execute([$g['id']]);
        $rows = $stmt->fetchAll(PDO::FETCH_ASSOC);
        $output .= "<tr>
                    <th>". $g['nombre'] ."</th>
                    </tr>";
        $output.="<tr>
                <th>Nombre</th>
                <th>Autoeficacia total</th>
                </tr>";

        //echo '<b> Institucion: ' . $g['nombre'] . '</b><br>';
        
        foreach ($rows as $row) {
            if($row['asistencia'] != 1){
                continue;
              }

            $output.="<tr>
                <th>". $row['nombre'] ."</th>
                <th>". $row['total'] ." </th>
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

    
    
    //header("Content-Type: application/xls");
    //header("Content-Disposition: attachment; filename=sesion6.xls");
    

    echo $output;
    
?>