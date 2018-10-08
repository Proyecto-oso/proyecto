<?php
include_once("header.php");
if (!isset($_SESSION)) {
    session_start();
  }
?>
</head>
<section class="parent">
    <div class="child">
    <h1>director</h1>
    <a href="pruebas.php">Crear prueba</a>
    </div>
</section>
<?php
include_once("footer.php");
?>