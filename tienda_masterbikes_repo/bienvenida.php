<?php
session_start();
if (!isset($_SESSION['user_id'])) {
    header("Location: login.html");
    exit();
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Bienvenida - Tienda Masterbikes</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css"/>
</head>
<body>

<header>
    <div class="row align-items-center">
        <div class="col-4 col-md-1">
            <img src="./images/bikelogo.jpg" class="img-fluid img-logo" alt="Logo consulta" />
        </div>
        <div class="col-4 col-md-10">
            <nav class="navbar navbar-expand-lg navbar-light bg-green">
                <a class="navbar-brand" href="#" aria-label="test"></a>
                <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span>
                </button>
                <div class="collapse navbar-collapse" id="navbarNav">
                    <ul class="navbar-nav">
                        <li class="nav-item active">
                            <a class="nav-link" href="index.html">Home<span class="sr-only"></span></a>
                        <li class="nav-item">
                            <a class="nav-link" href="formulario.html">Servicios - Registro Clientes</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="login.html">Iniciar Sesión</a>
                        </li>
                    </ul>
                </div>
            </nav>
        </div>   
    </div>
</header>

<div class="container">
    <h1 class="mt-5">Bienvenido, <?php echo htmlspecialchars($_SESSION['user_name']); ?>!</h1>
    <p>Has iniciado sesión exitosamente.</p>
</div>

</body>
</html>
