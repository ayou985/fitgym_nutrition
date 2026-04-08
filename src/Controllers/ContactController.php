<?php

namespace App\Controllers;

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

class ContactController
{
    public function contact()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $name     = htmlspecialchars($_POST['name'] ?? '');
            $surname  = htmlspecialchars($_POST['last_name'] ?? '');
            $email    = filter_var($_POST['email'] ?? '', FILTER_VALIDATE_EMAIL);
            $message  = strip_tags($_POST['message'] ?? '', '<h1><p><br><strong><em><ul><li>');

            // ✅ Vérification minimale : email et message obligatoires
            if (!$email || empty($message)) {
                $_SESSION['flash'] = [
                    'type' => 'error',
                    'message' => 'Veuillez renseigner au moins votre email et un message.'
                ];
                header('Location: /fitgym_nutrition-main/contact');
                exit;
            }

            // ✅ Anti-spam : limite 1 message/min par email
            $lastSentTimes = $_SESSION['last_sent_times'] ?? [];
            if (isset($lastSentTimes[$email]) && time() - $lastSentTimes[$email] < 60) {
                $_SESSION['flash'] = [
                    'type' => 'error',
                    'message' => 'Merci d’attendre 1 minute entre chaque message.'
                ];
                header('Location: /fitgym_nutrition-main/contact');
                exit;
            }

            // Envoi de mail via PHPMailer
            require_once(__DIR__ . '/../../vendor/autoload.php');
            $mail = new PHPMailer(true);
            $mail->SMTPDebug = 0;

            try {
                $mail->isSMTP();
                $mail->Host       = $_ENV['MAIL_HOST'] ?? 'smtp.gmail.com';
                $mail->SMTPAuth   = true;
                $mail->Username   = $_ENV['MAIL_USERNAME'] ?? '';
                $mail->Password   = $_ENV['MAIL_PASSWORD'] ?? '';
                $mail->SMTPSecure = $_ENV['MAIL_SECURE'] ?? 'tls';
                $mail->Port       = (int)($_ENV['MAIL_PORT'] ?? 587);

                $fullName = trim("$name $surname") ?: 'Utilisateur anonyme';

                $mail->setFrom($_ENV['MAIL_FROM'] ?? $mail->Username, $_ENV['MAIL_FROM_NAME'] ?? 'FitGym');
                $mail->addAddress($_ENV['MAIL_FROM'] ?? $mail->Username, $_ENV['MAIL_FROM_NAME'] ?? 'Admin FitGym');

                $mail->Subject = "Nouveau message de contact de $fullName";
                $mail->Body    = "Nom : $fullName\nEmail : $email\n\nMessage :\n$message";

                $mail->send();

                $_SESSION['last_sent_times'][$email] = time();

                $_SESSION['flash'] = [
                    'type' => 'success',
                    'message' => 'Message envoyé avec succès.'
                ];
            } catch (Exception $e) {
                error_log("Erreur envoi email : " . $mail->ErrorInfo);
                $_SESSION['flash'] = [
                    'type' => 'error',
                    'message' => "Une erreur est survenue lors de l'envoi. Veuillez réessayer."
                ];
            }

            header('Location: /fitgym_nutrition-main/contact');
            exit;
        }

        require_once(__DIR__ . '/../Views/contact.view.php');
    }
}