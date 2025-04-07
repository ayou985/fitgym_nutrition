<?php

namespace App\Controllers;

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

class ContactController
{
    public function contact()
    {

        $feedback = null;

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $name     = htmlspecialchars($_POST['name'] ?? '');
            $surname  = htmlspecialchars($_POST['last_name'] ?? '');
            $email    = filter_var($_POST['email'] ?? '', FILTER_VALIDATE_EMAIL);
            $message  = htmlspecialchars($_POST['message'] ?? '');

            // Vérification des champs
            if (!$email || empty($name) || empty($surname) || empty($message)) {
                $_SESSION['flash'] = ['type' => 'error', 'message' => 'Veuillez remplir tous les champs.'];
                header('Location: /contact');
                exit;
            }

            // Protection anti-spam basée sur l'email
            $lastSentTimes = $_SESSION['last_sent_times'] ?? [];

            if (isset($lastSentTimes[$email]) && time() - $lastSentTimes[$email] < 60) {
                $_SESSION['flash'] = [
                    'type' => 'error',
                    'message' => 'Merci d’attendre 1 minute entre chaque message pour cet email.'
                ];
                header('Location: /contact');
                exit;
            }

            // PHPMailer
            require_once(__DIR__ . '/../../vendor/autoload.php');

            $mail = new PHPMailer(true);

            try {
                $mail->isSMTP();
                $mail->Host       = 'smtp.gmail.com';
                $mail->SMTPAuth   = true;
                $mail->Username   = 'chelhayoub6@gmail.com'; // Ton Gmail
                $mail->Password   = 'tgvk frib jdpg wbev';    // Ton mot de passe d'application
                $mail->SMTPSecure = 'tls';
                $mail->Port       = 587;

                $mail->setFrom($email, "$name $surname");
                $mail->addAddress('chelhayoub6@gmail.com', 'Admin FitGym');

                $mail->Subject = "📬 Nouveau message de contact de $name $surname";
                $mail->Body    = "Nom : $name $surname\nEmail : $email\n\nMessage :\n$message";

                $mail->send();

                // Mettre à jour le timestamp pour cet email
                $_SESSION['last_sent_times'][$email] = time();

                $_SESSION['flash'] = ['type' => 'success', 'message' => 'Message envoyé avec succès.'];
            } catch (Exception $e) {
                $_SESSION['flash'] = ['type' => 'error', 'message' => "Erreur d'envoi : {$mail->ErrorInfo}"];
            }

            header('Location: /contact');
            exit;
        }

        require_once(__DIR__ . '/../Views/contact.view.php');
    }
}
