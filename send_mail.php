<?php
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require 'PHPMailer-master/src/PHPMailer.php';
require 'PHPMailer-master/src/SMTP.php';
require 'PHPMailer-master/src/Exception.php';

$config = require 'config.php';

header('Content-Type: application/json');

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $nom = htmlspecialchars($_POST['nom']);
    $prenom = htmlspecialchars($_POST['prenom']);
    $entreprise = htmlspecialchars($_POST['entreprise']);
    $telephone = htmlspecialchars($_POST['telephone']);
    $email = htmlspecialchars($_POST['email']);
    $note = htmlspecialchars($_POST['note']);

    $subject = "Nouveau message de contact : $prenom $nom";
    $message = "
        <html>
        <head>
            <title>Nouveau message de contact</title>
        </head>
        <body>
            <h2>Informations de contact</h2>
            <p><strong>Nom :</strong> $nom</p>
            <p><strong>Prénom :</strong> $prenom</p>
            <p><strong>Entreprise :</strong> $entreprise</p>
            <p><strong>Téléphone :</strong> $telephone</p>
            <p><strong>Email :</strong> $email</p>
            <h2>Message :</h2>
            <p>$note</p>
        </body>
        </html>
    ";

    $mail = new PHPMailer(true);
    try {
        // Configuration SMTP
        $mail->isSMTP();
        $mail->Host = $config['smtp_host'];
        $mail->SMTPAuth = true;
        $mail->Username = $config['smtp_username'];
        $mail->Password = $config['smtp_password'];
        $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
        $mail->Port = $config['smtp_port'];

        // Informations de l'email
        $mail->setFrom($config['from_email'], $config['from_name']);
        $mail->addAddress($config['to_email']); 
        $mail->addReplyTo($email, "$prenom $nom");

        $mail->isHTML(true);
        $mail->Subject = $subject;
        $mail->Body = $message;
        $mail->AltBody = strip_tags($message);

        $mail->send();

        echo json_encode(["success" => true, "message" => "L'email a été envoyé avec succès !"]);
    } catch (Exception $e) {
        echo json_encode(["success" => false, "message" => "Erreur lors de l'envoi de l'email : {$mail->ErrorInfo}"]);
    }
} else {
    echo json_encode(["success" => false, "message" => "Méthode de requête invalide."]);
}
?>
