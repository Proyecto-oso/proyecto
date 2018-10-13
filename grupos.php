<div>
    <?php
    function getGrupos($dbh)
    {
        if ($_SESSION['usuario_tipo'] == 'psicologo') {
            $usuario_id = $_SESSION['usuario_id'];
            $query1 = 'SELECT * FROM `grupo` WHERE psicologo_id = :usuario_id;';
            $stmt = $dbh->prepare($query1);
            showGrupos($dbh, $stmt);
        } elseif (($_SESSION['usuario_tipo'] == 'co-tallerista')) {
            $usuario_id = $_SESSION['usuario_id'];
            $query1 = 'SELECT * FROM `grupo` WHERE  `co-tallerista_id`= :usuario_id;';
            $stmt = $dbh->prepare($query1);
            showGrupos($dbh, $stmt);
        } elseif (($_SESSION['usuario_tipo'] == 'director')) {
            echo '<script language="javascript">window.location="director.php"</script>';
        }
    }
    function showGrupos($dbh, $stmt)
    {
        $stmt->execute(array(':usuario_id' => $_SESSION['usuario_id']));
        $rows = $stmt->fetchAll(PDO::FETCH_ASSOC);
        foreach ($rows as $r) {
            echo '
            <form method="post" action="' . htmlspecialchars($_SERVER["PHP_SELF"]) . '">
            <input type="hidden" name="name" value="' . $r['nombre'] . '" />
            <input type="hidden" name="id" value="' . $r['id'] . '" />
                <button type="submit" name="nombre" class="estudiante">
                    <p><b>Institucion:</b> ' . $r['nombre'] . '</br>
                </button>
            </form>';
        }
    }
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $_SESSION['grupo_id'] = $_POST['id'];
        echo '<h3>Institucion: ' . $_POST['name'] . '</h3>';
        echo '<a href="sesion1.php"><h5>SESIÓN 1</h5></a>';
        echo '<a href="sesion2.php"><h5>SESIÓN 2</h5></a>';
    } else {
        echo '<h3>Instituciones:</h3>';
        getGrupos($dbh);
    }
    ?>
</div>
