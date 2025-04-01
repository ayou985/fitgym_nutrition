<?php
namespace App\Controllers;

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

class ContactController {
    public function contact() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $name = htmlspecialchars($_POST['name'] ?? '');
            $email = filter_var($_POST['email'] ?? '', FILTER_VALIDATE_EMAIL);
            $message = htmlspecialchars($_POST['message'] ?? '');

            if (!$email || empty($name) || empty($message)) {
                echo "Veuillez remplir tous les champs correctement.";
                return;
            }

            require_once(__DIR__ . '/../../vendor/autoload.php'); // Composer autoload

            $mail = new PHPMailer(true);

            try {
                // SMTP config Gmail
                $mail->isSMTP();
                $mail->Host = 'smtp.gmail.com';
                $mail->SMTPAuth = true;
                $mail->Username = 'chelhayoub6@gmail.com'; // 🔁 Ton email Gmail
                $mail->Password = 'tgvk frib jdpg wbev'; // 🔁 Mot de passe d'application Gmail
                $mail->SMTPSecure = 'tls';
                $mail->Port = 587;

                $mail->setFrom($email, $name);
                $mail->addAddress('chelhayoub6@gmail.com'); // 🔁 Destination

                $mail->Subject = "Nouveau message de contact";
                $mail->Body = "Nom: $name\nEmail: $email\n\nMessage:\n$message";

                $mail->send();
                echo "Message envoyé avec succès.";
            } catch (Exception $e) {
                echo "Erreur lors de l'envoi : {$mail->ErrorInfo}";
            }
        }

        require_once(__DIR__ . '/../Views/contact.view.php');
    }
}

