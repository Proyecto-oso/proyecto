<?php

class func
{
    public static function checkLoginState($dbh)
    {
        if (!isset($_SESSION)) {
            session_start();
        }
        if (isset($_COOKIE['usuario_id']) && isset($_COOKIE['token'])) {
            $query = "SELECT * FROM sessions WHERE usuario_id = :usuario_id AND token = :token;";

            $usuario_id = $_COOKIE['usuario_id'];
            $token = $_COOKIE['token'];

            $stmt = $dbh->prepare($query);
            $stmt->execute(array(':usuario_id' => $usuario_id, ':token' => $token));

            $row = $stmt->fetch(PDO::FETCH_ASSOC);
            if ($row['usuario_id'] > 0) {
                if ($row['usuario_id'] == $_COOKIE['usuario_id'] &&
                    $row['token'] == $_COOKIE['token']) {
                    if ($row['usuario_id'] == $_SESSION['usuario_id'] &&
                        $row['token'] == $_SESSION['token']) {
                        return true;
                    } else {
                        func::createSession($_COOKIE['usuario_nombre'], $_COOKIE['usuario_id'], $_COOKIE['token'], $_COOKIE['usuario_tipo']);
                        return true;
                    }
                }
            }
        }
    }

    public static function createRecord($dbh, $usuario_nombre, $usuario_id, $token, $usuario_tipo)
    {
        $dbh->prepare('DELETE FROM sessions WHERE usuario_id= :usuario_id;')->execute(array(':usuario_id' => $usuario_id));



        func::createCookie($usuario_nombre, $usuario_id, $token, $usuario_tipo);
        func::createSession($usuario_nombre, $usuario_id, $token, $usuario_tipo);

        $stmt = $dbh->prepare('INSERT INTO sessions (usuario_id, usuario_tipo, usuario_nombre, token, fecha) VALUES (:usuario_id,:usuario_tipo,:usuario_nombre,:token ,"' . date("Y-m-d h:i:sa") . '")');
        $stmt->execute(array(':usuario_id' => $usuario_id, ':usuario_nombre' => $usuario_nombre, ':token' => $token, ':usuario_tipo' => $usuario_tipo));


    }

    public static function createCookie($usuario_nombre, $usuario_id, $token, $usuario_tipo)
    {
        echo " create cookie ";
        setcookie('usuario_nombre', $usuario_nombre, time() + (86400), "/");
        setcookie('usuario_id', $usuario_id, time() + (86400), "/");
        setcookie('token', $token, time() + (86400), "/");
        setcookie('usuario_tipo', $usuario_tipo, time() + (86400), "/");
    }

    public static function deleteCookie()
    {
        setcookie('usuario_nombre', '', time() - 1, "/");
        setcookie('usuario_id', '', time() - 1, "/");
        setcookie('token', '', time() - 1, "/");
        setcookie('usuario_tipo', '', time() - 1, "/");
    }


    public static function createSession($usuario_nombre, $usuario_id, $token, $usuario_tipo)
    {
        echo " create session ";
        if (!isset($_SESSION)) {
            session_start();
        }
        $_SESSION['usuario_nombre'] = $usuario_nombre;
        $_SESSION['usuario_id'] = $usuario_id;
        $_SESSION['token'] = $token;
        $_SESSION['usuario_tipo'] = $usuario_tipo;
    }

    public static function createToken($len)
    {
        $string = "1qaz2wsx3edc4rfv5tgb6yhn7ujm8ik9ol0pASDFGHJKLZXCVBNMQWERTYUIOP";
        $s = '';
        $r_new = '';
        $r_old = '';
        for ($i = 1; $i < $len; $i++) {
            while ($r_old == $r_new) {
                $r_new = rand(0, 60);
            }
            $r_old = $r_new;
            $s = $s . $string[$r_new];
        }
        return substr(str_shuffle($string), 0, $len);
    }

    
}

?>