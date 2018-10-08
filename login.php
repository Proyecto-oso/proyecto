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
        if (!func::checkLoginState($dbh)) {
            echo '
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
                    ';
        } else {
                header("location:index.php");
        }
        ?>
    </div>
</section>
<?php
include_once("footer.php");
?>
