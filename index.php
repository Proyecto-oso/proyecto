<?php
include_once("header.php");
?>
<style>
<?php include('styles/index.css'); ?>
</style>
</head>
  <body>
  <section class="parent">
    <div class="child">
        <?php
            if(!func::checkLoginState($dbh)){
                header("location: login.php");
            }
            echo "<h1>Bienvenido ".$_SESSION['usuario_nombre'] ." !!!!</h1></br>";
            include("estudiantes.php");
        ?>
    </div>
</section>
  </body>
  <?php
  include_once("footer.php");
  ?>
