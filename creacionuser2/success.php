<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registro Exitoso</title>
</head>
<body>
    <?php
    if (isset($_GET['nickname'])) {
        $nickname = htmlspecialchars($_GET['nickname']);
        echo "<h1>Registro Exitoso</h1>";
        echo "<p>Su nombre de usuario es: <strong>$nickname</strong></p>";
    } else {
        echo "<h1>Error en el Registro</h1>";
        echo "<p>No se pudo generar su nombre de usuario. Por favor, intente nuevamente.</p>";
    }
    ?>
    <a href="/dashboard/index.html">Regresar al Formulario</a>
</body>
</html>
