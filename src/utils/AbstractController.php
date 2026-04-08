<?php

namespace App\Utils;

abstract class AbstractController
{
    protected array $arrayError = [];

    public static function getBaseUrl(): string
    {
        $host = $_SERVER['SERVER_NAME'] ?? 'localhost';
        return ($host === 'localhost' || $host === '127.0.0.1') ? '/fitgym_nutrition-main' : '';
    }

    public function redirectToRoute($route)
    {
        http_response_code(303);
        header("Location: " . self::getBaseUrl() . $route);
        exit;
    }

    public function isNotEmpty($nameInput, $value)
    {
        if (empty($value)) {
            $this->arrayError[$nameInput] = "Le champ $nameInput ne peut pas être vide.";
            return true;
        }
        return false;
    }

    public function checkFormat($nameInput, $value)
    {
        $regexPassword = '/^(?=.*?[A-Z])(?=.*?[a-z])(?=.*?[0-9])(?=.*?[#?!@$%^&*-]).{8,}$/';

        switch ($nameInput) {
            case 'mail':
                if (!filter_var($value, FILTER_VALIDATE_EMAIL)) {
                    $this->arrayError['mail'] = 'Merci de renseigner un e-mail valide.';
                }
                break;
            case 'password':
                if (!preg_match($regexPassword, $value)) {
                    $this->arrayError['password'] = 'Le mot de passe doit contenir au moins 8 caractères, 1 majuscule, 1 chiffre, 1 caractère spécial.';
                }
                break;
        }
    }

    public function check($nameInput, $value)
    {
        $this->isNotEmpty($nameInput, $value);
        $value = htmlspecialchars($value);
        $this->checkFormat($nameInput, $value);
        return $this->arrayError;
    }
}
