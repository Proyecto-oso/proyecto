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


        $query = ' SELECT grupo.id, estudiantes.id, estudiantes.nombre, sesion_8.temas_trabajados, sesion_8.ejercicios, sesion_8.tallerista, sesion_8.utilidad FROM grupo INNER JOIN estudiantes Inner join sesion_8 on grupo.id=estudiantes.grupo_id and estudiantes.id=sesion_8.id_estudiante where grupo.id=?';
        //echo $query;
        $stmt = $dbh->prepare($query);
        $stmt->execute([$g['id']]);
        $rows = $stmt->fetchAll(PDO::FETCH_ASSOC);
        $output .= "<tr>
                    <th>". $g['nombre'] ."</th>
                    </tr>";
        $output.="<tr>
                    <th>Nombre</th>
                    <th >Los temas trabajados</th>
                    <th >Los ejercicios</th>
                    <th >La direccion del tallerista</th>
                    <th >La utilidad para tu diario vivir</th>
                </tr>";

        //echo '<b> Institucion: ' . $g['nombre'] . '</b><br>';
        
        foreach ($rows as $row) {

            $output.="<tr>
                    <th>". $row['nombre'] ."</th>
                    <th>". $row['temas_trabajados'] ."</th>
                    <th>". $row['ejercicios'] ."</th>
                    <th>". $row['tallerista'] ."</th>
                    <th>". $row['utilidad'] ."</th>
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
    //header("Content-Disposition: attachment; filename=sesion8.xls");
    
    echo $output;
    
?>