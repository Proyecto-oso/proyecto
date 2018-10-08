<?php
include_once("header.php");
?>
<style>
    <?php include('styles/Log.css') ?>
</style>
</head>
<section class="parent">
    <div class="child">
<?php
function enviarCorreo($correo)
{
    $token = func::createToken(30);
    // El mensaje
    $mensaje = "El token de ingreso es el siguiente: \r\n$token";

    // Si cualquier línea es más larga de 70 caracteres, se debería usar wordwrap()
    $mensaje = wordwrap($mensaje, 70, "\r\n");
    // Enviarlo
    $return = mail($correo, 'TOKEN DE INGRESO', $mensaje);
    if(!$return){
      $message = "ERROR el mensaje no fue enviado de forma exitoas";
    }else {
      // code...
      $message = "el mensaje fue enviado de forma exitoas";
    }
    echo "<h1>$message</h1>";
    echo "<h1>$correo</h1>";
    echo "<h1>$token</h1>";
    return $token;
}
if (func::checkLoginState($dbh)) {
    header("location:index.php");

} else {
    if (isset($_POST['token'])) {
        $token_recibido = $_POST['token_recibido'];
        $token = $_POST['token'];
        $nombre = $_POST['nombre'];
        $id = $_POST['id'];
        $usuario_tipo = $_POST['usuario_tipo'];
        if ($token == $token_recibido) {
            func::createRecord($dbh, $nombre, $id, $token, $usuario_tipo);
            header("location:index.php");
        } else {
            echo '<script language="javascript">';
            echo 'alert("Token incorrecto, intente de nuevo")';
            echo '</script>';
        }
    } elseif (isset($_POST['correo'])) {
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
            echo '<div class="row">
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
            echo '<div class="row">
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
            echo '<div class="row">
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
        header("location:login.php");
    }
}
?>
</div>
</section>
<?php
include_once("footer.php");
?>
