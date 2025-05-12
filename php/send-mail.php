<?php
require __DIR__ . '/vendor/autoload.php';

use PHPMailer\PHPMailer\PHPMailer;
use Dotenv\Dotenv;

// Carga las variables de entorno
$dotenv = Dotenv::createImmutable(__DIR__);
$dotenv->load();

$mail = new PHPMailer(true);

try {
    // Configuración del servidor SMTP
    $mail->isSMTP();
    $mail->Host       = $_ENV['HOST'];
    $mail->SMTPAuth   = true;
    $mail->Username   = $_ENV['EMAIL'];
    $mail->Password   = $_ENV['PASSWORD'];
    $mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS; // Para puerto 465
    $mail->Port       = $_ENV['PORT'];

    // Remitente y destinatario
    $mail->setFrom($_ENV['EMAIL'], 'Sitio Web');
    $mail->addAddress($_ENV['EMAIL'], 'Administrador'); // Te lo envías a ti mismo

    // Contenido del correo
    $mail->isHTML(true);
    $mail->Subject = 'Nuevo mensaje del formulario de contacto';
    $mail->Body    = '
        <strong>Nombre:</strong> ' . $_POST['nombre'] . '<br>
        <strong>Teléfono:</strong> ' . $_POST['telefono'] . '<br>
        <strong>Correo:</strong> ' . $_POST['correo'] . '<br>
        <strong>Mensaje:</strong><br>' . nl2br($_POST['mensaje']);

    $mail->send();
    echo 'Mensaje enviado correctamente.';
} catch (Exception $e) {
    echo 'Error al enviar el mensaje: ' . $mail->ErrorInfo;
}
