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


        $query = 'SELECT grupo.id, estudiantes.id, estudiantes.nombre, sesion_2.asistencia ,sesion_2.total_factor_tncf , sesion_2.total_factor_paf, sesion_2.total_factor_icppf, sesion_2.total_factor_tivf, sesion_2.total_eet_economico, sesion_2.total_eet_laboral, sesion_2.total_eet_familiar, sesion_2.total_eet_vida, sesion_2.total_eet_academico FROM grupo INNER JOIN estudiantes Inner join sesion_2 on grupo.id=estudiantes.grupo_id and estudiantes.id=sesion_2.id_estudiante where grupo.id=? ';
        //echo $query;
        $stmt = $dbh->prepare($query);
        $stmt->execute([$g['id']]);
        $rows = $stmt->fetchAll(PDO::FETCH_ASSOC);
        $output .= "<tr>
                    <th>". $g['nombre'] ."</th>
                    </tr>";
        $output.="<tr>
                <th>Nombre</th>
                <th>Tendencia a no centrarse en el futuro </th>
                <th>Factor planeacion activa del futuro </th>
                <th>Factor influencia de la conducta pasada y presente en el futuro </th>
                <th>Factor tendencia a imaginarse la vida en el futuro </th>
                <th>Escala de extension economico </th>
                <th>Escala de extension laboral   </th>
                <th>Escala de extension familiar  </th>
                <th>Escala de extension vida      </th>
                <th>Escala de extension academico </th>
                </tr>";

        //echo '<b> Institucion: ' . $g['nombre'] . '</b><br>';
        
        foreach ($rows as $row) {
            if($row['asistencia'] != 1){
                continue;
              }

            $output.="<tr>
                <th>". $row['nombre'] ."</th>
                <th>". $row['total_factor_tncf'] ."</th> 
                <th>". $row['total_factor_paf'] ."</th>
                <th>". $row['total_factor_icppf'] ."</th>
                <th>". $row['total_factor_tivf'] ."</th>
                <th>". $row['total_eet_economico'] ."</th>
                <th>". $row['total_eet_laboral'] ."</th>
                <th>". $row['total_eet_familiar'] ."</th>
                <th>". $row['total_eet_vida'] ."</th>
                <th>". $row['total_eet_academico'] ."</th>
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

    
    
    header("Content-Type: application/xls");
    header("Content-Disposition: attachment; filename=sesion2.xls");
    

    echo $output;
    
?>