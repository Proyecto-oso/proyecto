<?php
include_once("config.php");
include_once("functions.php");
if (!isset($_SESSION)) {
    session_start();
  }
if (func::checkLoginState($dbh)) {
    echo'<script language="javascript">window.location="index.php"</script>';
}
if (isset($_POST['token'])) {
    $token_recibido = $_POST['token_recibido'];
    $token = $_POST['token'];
    $nombre = $_POST['nombre'];
    $id = $_POST['id'];
    $usuario_tipo = $_POST['usuario_tipo'];
    if ($token == $token_recibido) {
        func::createRecord($dbh, $nombre, $id, $token, $usuario_tipo);
            echo'<script language="javascript">window.location="index.php"</script>';
    } else {
        echo '<script language="javascript">';
        echo 'alert("Token incorrecto, intente de nuevo")';
        echo '</script>';
    }
}
?>
<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="theme-color" content="#000000">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.1.0/css/bootstrap.min.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.0/umd/popper.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.1.0/js/bootstrap.min.js"></script>
    <link href="https://fonts.googleapis.com/css?family=Kanit" rel="stylesheet">
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.3.1/css/all.css" integrity="sha384-mzrmE5qonljUremFsqc01SB46JvROS7bZs3IO2EmfFsd15uHvIt+Y8vEf7N7fWAU" crossorigin="anonymous">
    <title>Proyecto Psicologia</title>

<style>
    <?php include('styles/Log.css') ?>
</style>
</head>
<section class="parent">
    <div class="child">
<?php

function enviarCorreo($correo)
{
    $token = func::createToken(6);
    // El mensaje
    $mensaje = "El token de ingreso es el siguiente: \r\n$token";

    // Si cualquier línea es más larga de 70 caracteres, se debería usar wordwrap()
    $mensaje = wordwrap($mensaje, 70, "\r\n");
    $headers = array("From from@example.com", // missing colon
        "Reply To: replyto@example.com"      // missing hyphen
    );
    // Enviarlo
    $return =  mail( $correo, 'TOKEN DE INGRESO', $mensaje,$headers);
    if(!$return)
    {
      $message = "el mensaje no fue enviado exitosamente";
    }
    //el mensaje fue enviado
    else
    {
      $message = "El mensaje fue enviado exitosamente<br  /> nos comunicaremos contigo lo antes posible para aclarar dudas y acordar entragas ";
    }

    echo $message;

    return $token;
}
 if (isset($_POST['correo'])) {
    $query1 = "SELECT * FROM psicologos WHERE correo= :correo";
    $query2 = 'SELECT * FROM `co-talleristas` WHERE correo= :correo';
    $query3 = 'SELECT * FROM `directores` WHERE correo= :correo';
    $correo = $_POST['correo'];

    $stmt1 = $dbh->prepare($query1);
    $stmt1->execute(array(':correo' => $correo));

    $stmt2 = $dbh->prepare($query2);
    $stmt2->execute(array(':correo' => $correo));

    $stmt3 = $dbh->prepare($query3);
    $stmt3->execute(array(':correo' => $correo));

    $row1 = $stmt1->fetch(PDO::FETCH_ASSOC);
    if ($row1['id'] > 0) {
        $token = enviarCorreo($correo);
        echo $token . '<div class="row">
        <div class="col-sm-8 offset-sm-2 myform-cont">
            <form method="post" class="">
                <div class="form-group">
                    <input type="hidden" name="nombre" value="' . $row1['nombre'] . '" />
                    <input type="hidden" name="id" value="' . $row1['id'] . '" />
                    <input type="hidden" name="token" value="' . $token . '" />
                    <input type="hidden" name="usuario_tipo" value="psicologo" />
                    <input type="text" name="token_recibido" placeholder="Token" class="form-control" id="correo"/>
                </div>
                <button type="submit" class="mybtn">Ingresar</button>
            </form>
        </div>
    </div>';
    }
    $row2 = $stmt2->fetch(PDO::FETCH_ASSOC);
    if ($row2['id'] > 0) {
        $token = enviarCorreo($correo);
        echo $token . '<div class="row">
        <div class="col-sm-8 offset-sm-2 myform-cont">
        <form method="post" class="">
        <div class="form-group">
            <input type="hidden" name="nombre" value="' . $row2['nombre'] . '" />
            <input type="hidden" name="id" value="' . $row2['id'] . '" />
            <input type="hidden" name="token" value="' . $token . '" />
            <input type="hidden" name="usuario_tipo" value="co-tallerista" />
            <input type="text" name="token_recibido" placeholder="Token" class="form-control" id="correo"/>
        </div>
        <button type="submit" class="mybtn">Ingresar</button>
    </form>
        </div>
    </div>';
    }
    $row3 = $stmt3->fetch(PDO::FETCH_ASSOC);
    if ($row3['id'] > 0) {
        $token = enviarCorreo($correo);
        echo $token . '<div class="row">
        <div class="col-sm-8 offset-sm-2 myform-cont">
        <form method="post" class="">
        <div class="form-group">
            <input type="hidden" name="nombre" value="' . $row3['nombre'] . '" />
            <input type="hidden" name="id" value="' . $row3['id'] . '" />
            <input type="hidden" name="token" value="' . $token . '" />
            <input type="hidden" name="usuario_tipo" value="director" />
            <input type="text" name="token_recibido" placeholder="Token" class="form-control" id="correo"/>
        </div>
        <button type="submit" class="mybtn">Ingresar</button>
    </form>
        </div>
    </div>';
    }
    if (!$row1['id'] > 0 && !$row2['id'] > 0 && !$row3['id'] > 0) {
        echo '<div class="error"><h3 class="error">' . $row1['id'] . '</h3></div>';
        echo $row1['id'];
        echo $row2['id'];
        //header("location:login.php");
    }
} else {
        echo'<script language="javascript">window.location="index.php"</script>';
}

?>
</div>
</section>
<?php
include_once("footer.php");
?>
