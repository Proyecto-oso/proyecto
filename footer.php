</footer>


<?php
include_once("functions.php");
print_r(error_get_last());
echo '
    <a href ="index.php">Inicio</a> |';
    if(func::checkLoginState($dbh)){
        echo '<a href="logout.php">Logout</a>';
    }else{
        echo '<a href="login.php">Login</a>';
    }


?>

</footer>
</html>
