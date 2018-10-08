<?php
include_once("header.php");
include_once("functions.php");
if (!isset($_SESSION)) {
    session_start();
}
function test_input($data)
{
    $data = trim($data);
    $data = stripslashes($data);
    $data = htmlspecialchars($data);
    return $data;
}
?>
<style media="screen">
  body{
    text-align: center;
  }
  .input{

  }
</style>
 </head>
    <div>
    <?php
    if (isset($_GET['nombre_test']) || isset($_SESSION['nombre_test'])) {
        if(isset($_GET['nombre_test'])){
            $nombre_test = $_GET['nombre_test'];
            $_SESSION['nombre_test'] = $nombre_test;
            $_SESSION['id_estudiante'] = $_GET['id_estudiante'];
        }
        $nombre_test=$_SESSION['nombre_test'];
        $query = 'SELECT * FROM test WHERE nombre=?';
        $stmt = $dbh->prepare($query);
        $stmt->execute([$nombre_test]);
        $row = $stmt->fetch();
        $query1 = 'SELECT * FROM preguntas WHERE id_test=?';
        $stmt1 = $dbh->prepare($query1);
        $stmt1->execute([$row['id']]);
        $preguntas = $stmt1->fetchAll(PDO::FETCH_ASSOC);
        echo '<h1>' . $nombre_test . '</h1>';
        $i = 0;
        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            $score = 0;
            foreach ($preguntas as $pregunta) {
                if (isset($_POST['pregunta_' . $i]) && $_POST['pregunta_' . $i] == $pregunta['respuesta']) {
                    $score++;
                }
                $i++;
            }            
            $query = 'INSERT INTO `presentacion_test`(`id_estudiante`, `id_test`, `score`) VALUES (?,?,?)';
            
            $stmt = $dbh->prepare($query);
            $stmt->execute([$_SESSION['id_estudiante'], $row['id'], $score]);
            //echo $_SESSION['id_estudiante'].' '. $row['id'].' '. $score;
            echo '<script language="javascript">';
            echo 'alert("Puntuacion guardada correctamente")';
            echo '</script>';
            echo '<script language="javascript">window.location="index.php"</script>';
        }
        $i = 0;
        ?>
    <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
    <?php
    foreach ($preguntas as $pregunta) {
        $enunciado = $pregunta['enunciado'];
            // Ejemplo 1
        $aux = $pregunta['opciones'];
        $opciones = explode(";", $aux);

        $respuesta = $pregunta['respuesta'];
        ?>
            
        <h3><?php echo $enunciado ?></h3>
        <?php
        foreach ($opciones as $opcion) {
            echo '<input type="radio" name="pregunta_' . $i . '" value="' . $opcion . '">' . $opcion . ' </br>   ';
        }
        $i++;
    }

    ?>
        <input type="submit" name="submit" value="Enviar">
    </form>
<?php

}
include_once("footer.php");
?>