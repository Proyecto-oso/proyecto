<style media="screen">

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

tr:nth-child(even) {
  background-color: #dddddd;
}

.titles {
  margin-top: 50px;

}

input{
  float: right;
}

.creation{
  float: left;
}

.new_element{
  display: none;
}

</style>



<?php
include_once("header.php");
include_once("footer.php");

?>
</head>
<section class="parent">
    <div class="child">
    <h1>director</h1>
    <a href="pruebas.php">Crear prueba</a>
    </div>
</section>


<?php

$arrayName = array();


?>


<h1 class="titles">Estudiantes</h1>
<form class="" action="report.php" method="post">
  <input type="submit" class="creation" name="create_student" value="Crear estudiante">
</form>

<table>
  <tr>
    <th>Nombre</th>
    <th>Identificacion</th>
    <th>grado</th>
    <th>edad</th>
    <th>colegio</th>
  </tr>



<?php
  // set the resulting array to associative
  $sql = 'SELECT * FROM estudiantes';
  foreach ($dbh->query($sql) as $row) {
    echo '
            <tr>
              <form class="" action="report.php" method="post">
                <input type="hidden" name="student" value="'.$row['id'].'">
                <th>'.$row['nombre'].'</th>
                <th>'.$row['documento'].'</th>
                <th>'.$row['grado'].'</th>
                <th>'.$row['edad'].'</th>
                <th>'.$row['colegio'].'
                <input type="submit" name="ver estduiante" value="Ver Estudiante"></th>
              </form>
            </tr>
          ';

  }

?>
</table>


<h1 class="titles">Psicologos</h1>

<form class="" action="report.php" method="post">
  <input type="submit" class="creation" name="create_psicologo" value="Crear psicologo">
</form>


<table>

    <tr>
      <th><a  > Nombre </a></th>
      <th>Correo</th>
    </tr>

<?php
  // set the resulting array to associative
  $sql = 'SELECT * FROM psicologos';

  foreach ($dbh->query($sql) as $row) {
    echo '
            <tr>
              <form class="" action="report.php" method="post">
                <input type="hidden" name="psicologo" value="'.$row['id'].'">
                <th>'.$row['nombre'].'</th>
                <th>'.$row['correo'].'
                <input type="submit" name="ver estduiante" value="Ver psicologo"></th>
              </form>
            </tr>
          ';
  }

?>
</table>

<h1 class="titles">co-talleristas</h1>

<form class="" action="report.php" method="post">
  <input type="submit" class="creation" name="create_co-tallerista" value="Crear co-tallerista">
</form>

<table>
  <tr>
    <th>Nombre</th>
    <th>Correo</th>
  </tr>

<?php
  // set the resulting array to associative
  $sql = 'SELECT * FROM `co-talleristas`';

  foreach ($dbh->query($sql) as $row) {

    echo '
            <tr>
              <form class="" action="report.php" method="post">
                <input type="hidden" name="co_tallerista" value="'.$row['id'].'">
                <th>'.$row['nombre'].'</th>
                <th>'.$row['correo'].'
                <input type="submit" name="ver estduiante" value="Ver co-tallerista"></th>
              </form>
            </tr>
          ';



  }

?>
</table>
