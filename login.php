<?php
include_once("functions.php");
include_once("config.php");
if (!func::checkLoginState($dbh)) {
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
    <div  class="body-login">
      <div class="container">
         <div class="container container-login">
            <div class="row">
              <div class="col-sm-12 log-text">
                <h2>Ingresa</h2>
               </div>
            </div>
            <div class="row">
         <div class="col-sm-8 offset-sm-2 myform-cont">
                        <form role="form" action="verificar_token.php" method="post" class="">
                                <div class="form-group">
                                    <input type="text" name="correo" placeholder="Correo" class="form-control" id="correo"/>
                                </div>
                            <button type="submit" class="mybtn">Enviar</button>
                        </form>
                    </div>
                </div>
            </div>
         </div>
      </div>
    </div>  
    </div>
</section>
<?php 
} else {
    echo '<script language="javascript">window.location="index.php"</script>';
}
include_once("footer.php");
?>
