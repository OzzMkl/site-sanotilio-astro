<?php
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require __DIR__ . '/vendor/autoload.php';

// Cargar variables desde .env
$env = parse_ini_file(__DIR__ . '/.env');

$mail = new PHPMailer;

try {
    // Configuración del servidor SMTP
    $mail->isSMTP();
    $mail->Host       = $env['HOST'];
    $mail->SMTPAuth   = true;
    $mail->Username   = $env['EMAIL'];
    $mail->Password   = $env['PASSWORD'];
    $mail->SMTPSecure = 'tls';
    $mail->Port       = $env['PUERTO'];

    // Remitente y destinatario
    $mail->setFrom($env['EMAIL'], 'Formulario Web');
    $mail->addAddress($env['EMAIL']); // Se envía a sí mismo

    // Contenido del correo
    $mail->isHTML(true);
    $mail->Subject = 'Nuevo mensaje desde el formulario';
    $mail->Body    = "
        <b>Nombre:</b> {$_POST['nombre']}<br>
        <b>Teléfono:</b> {$_POST['telefono']}<br>
        <b>Correo:</b> {$_POST['correo']}<br>
        <b>Mensaje:</b><br>{$_POST['mensaje']}
    ";

    $mail->send();

    echo 'Mensaje enviado con éxito';
} catch (Exception $e) {
    http_response_code(500);
    echo "Error al enviar el mensaje: {$mail->ErrorInfo}";
}
