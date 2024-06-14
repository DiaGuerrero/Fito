<?php
session_start();

$servername = "localhost";
$username = "root";
$password = "";
$dbname = "tienda_masterbikes";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $correo = filter_var($_POST['correo'], FILTER_SANITIZE_EMAIL);
    $password = $_POST['password'];

    if (filter_var($correo, FILTER_VALIDATE_EMAIL)) {
        $conn = new mysqli($servername, $username, $password, $dbname);

        if ($conn->connect_error) {
            die("Conexión fallida: " . $conn->connect_error);
        }

        $stmt = $conn->prepare("SELECT id, nombre, apellido, password FROM clientes WHERE correo = ?");
        $stmt->bind_param("s", $correo);
        $stmt->execute();
        $stmt->store_result();
        $stmt->bind_result($id, $nombre, $apellido, $hashed_password);
        $stmt->fetch();

        if ($stmt->num_rows > 0 && password_verify($password, $hashed_password)) {
            $_SESSION['user_id'] = $id;
            $_SESSION['user_name'] = $nombre . ' ' . $apellido;
            header("Location: bienvenida.php");
            exit();
        } else {
            echo "Correo o contraseña incorrectos.";
        }

        $stmt->close();
        $conn->close();
    } else {
        echo "Correo electrónico no válido.";
    }
}
?>
