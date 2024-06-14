<?php
//SE CAMBIO CASI TODO EL CODIGOOOOOOOOOO

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require 'PHPmailer-master/PHPMailer-master/src/Exception.php';
require 'PHPmailer-master/PHPMailer-master/src/PHPMailer.php';
require 'PHPmailer-master/PHPMailer-master/src/SMTP.php';

// Configuración de conexión a la base de datos
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "tienda_masterbikes";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $nombre = htmlspecialchars($_POST['nombre']);
    $apellido = htmlspecialchars($_POST['apellido']);
    $correo = filter_var($_POST['correo'], FILTER_SANITIZE_EMAIL);
    $telefono = htmlspecialchars($_POST['telefono']);
    $password = generatePassword();

    if (filter_var($correo, FILTER_VALIDATE_EMAIL)) {
        // Conexión a la base de datos
        $conn = new mysqli($servername, $username, $password, $dbname);

        // Verificar la conexión
        if ($conn->connect_error) {
            die("Conexión fallida: " . $conn->connect_error);
        }

        // Hash de la contraseña
        $hashed_password = password_hash($password, PASSWORD_DEFAULT);

        // Insertar datos en la base de datos
        $stmt = $conn->prepare("INSERT INTO clientes (nombre, apellido, correo, telefono, password) VALUES (?, ?, ?, ?, ?)");
        $stmt->bind_param("sssss", $nombre, $apellido, $correo, $telefono, $hashed_password);

        if ($stmt->execute()) {
            $stmt->close();
            $conn->close();

            // Configuración de PHPMailer
            $mail = new PHPMailer(true);
            try {
                $mail->isSMTP();
                $mail->Host = 'smtp.gmail.com';
                $mail->SMTPAuth = true;
                $mail->Username = 'masterbikesweb@gmail.com';
                $mail->Password = 'ktxyhvmvohimifok';
                $mail->SMTPSecure = 'tls';
                $mail->Port = 587;

                $mail->setFrom('masterbikesweb@gmail.com', 'Tienda Masterbikes');
                $mail->addAddress($correo);

                $mail->isHTML(true);
                $mail->Subject = 'Registro Exitoso';
                $mail->Body    = "Hola $nombre $apellido,<br><br>Su registro fue exitoso.<br>Su clave es: <b>$password</b><br><br>Ahora puede iniciar sesión y solicitar nuestros servicios. Gracias por registrarse en Tienda Masterbikes.";
                $mail->CharSet = 'UTF-8';
                $mail->send();
                echo 'Correo enviado con éxito.';
            } catch (Exception $e) {
                echo "Error al enviar el correo: {$mail->ErrorInfo}";
            }
        } else {
            echo "Error al guardar los datos: " . $stmt->error;
        }
    } else {
        echo "Correo electrónico no válido.";
    }
}

function generatePassword() {
    return substr(str_shuffle('abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789'), 0, 8);
}
?>
