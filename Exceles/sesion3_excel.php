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


        $query = ' SELECT grupo.id, estudiantes.id, estudiantes.nombre, sesion_3.asistencia ,sesion_3.t_activo, sesion_3.t_reflexivo, sesion_3.t_sensible, sesion_3.t_intuitivo, sesion_3.t_visual, sesion_3.t_verbal, sesion_3.t_secuencial, sesion_3.t_global FROM grupo INNER JOIN estudiantes Inner join sesion_3 on grupo.id=estudiantes.grupo_id and estudiantes.id=sesion_3.id_estudiante where grupo.id=?';
        //echo $query;
        $stmt = $dbh->prepare($query);
        $stmt->execute([$g['id']]);
        $rows = $stmt->fetchAll(PDO::FETCH_ASSOC);
        $output .= "<tr>
                    <th>". $g['nombre'] ."</th>
                    </tr>";
        $output.="<tr>
                <th>Nombre</th>
                <th>Total activo </th>
                <th>Total reflexivo </th>
                <th>Total sensible </th>
                <th>Total intuitivo </th>
                <th>Total visual </th>
                <th>Total verbal </th>
                <th>Total secuencial </th>
                <th>Total global </th>
                </tr>";

        //echo '<b> Institucion: ' . $g['nombre'] . '</b><br>';
        
        
        foreach ($rows as $row) {
            if($row['asistencia'] != 1){
                continue;
              }

            $output.="<tr>
                <th>". $row['nombre'] ."</th>
                <th>". $row['t_activo'] ."</th>
                <th>". $row['t_reflexivo'] ."</th>
                <th>". $row['t_sensible'] ."</th>
                <th>". $row['t_intuitivo'] ."</th>
                <th>". $row['t_visual'] ."</th>
                <th>". $row['t_verbal'] ."</th>
                <th>". $row['t_secuencial'] ."</th>
                <th>". $row['t_global'] ."</th>
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
    //header("Content-Disposition: attachment; filename=sesion3.xls");
    

    echo $output;
    
?>