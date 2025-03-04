<?php
namespace App\Controllers;

class ContactController {
    public function contact() {
        include_once __DIR__ . '/../Views/contact.view.php';
    }

    public function index() {
        if ($_SERVER["REQUEST_METHOD"] === "POST") {
            $name = htmlspecialchars($_POST['name']);
            $email = htmlspecialchars($_POST['email']);
            $message = htmlspecialchars($_POST['message']);

            // Simule un envoi d'email (à remplacer par une vraie fonction d'envoi)
            $to = "ton-email@example.com";
            $subject = "Nouveau message de $name";
            $body = "Nom : $name\nEmail : $email\n\nMessage :\n$message";

            if (mail($to, $subject, $body)) {
                echo "Message envoyé avec succès !";
            } else {
                echo "Erreur lors de l'envoi du message.";
            }
        }
    }
}
