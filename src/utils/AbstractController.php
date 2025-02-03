<?php

namespace App\Utils;


abstract class AbstractController
{
    protected array $arrayError = [];

    public function redirectToRoute($route)
    {
        http_response_code(303);
        header("Location: {$route} ");
        exit;
    }

    public function isNotEmpty($value)
    {
        if (empty($_POST[$value])) {
            $this->arrayError[$value] = "Le champ $value ne peut pas être vide.";
            return $this->arrayError;
        }
        return false;
    }

    public function checkFormat($nameInput, $value)
    {
        $regexName = '/^[a-zA-Zà-üÀ-Ü -_]{2,255}$/';
        $regexPassword = '/^(?=.*?[A-Z])(?=.*?[a-z])(?=.*?[0-9])(?=.*?[#?!@$%^&*-]).{8,}$/';
        $regexTitle = '/^[a-zA-Zà-üÀ-Ü0-9 #?!@$%^,.;&*-]{4,255}$/';
        $regexContent = '/^[a-zA-Zà-üÀ-Ü0-9 #?!@$%^,.;&*-]{4,}$/';
        $regexRole = '/^[12]$/';
        $regexDateTime = '/^[2][0][2-3][0-9][-][0-1][0-9][-][0-3][0-9][T][0-2][0-9][:][0-6][0-9]$/';
        $regexPoint = '/^[0-9]{1,}$/';

        switch ($nameInput) {
            case 'pseudo':
                if (!preg_match($regexName, $value)) {
                    $this->arrayError['pseudo'] = 'Merci de renseigner un pseudo correcte!';
                }
                break;
            case 'mail':
                if (!filter_var($value, FILTER_VALIDATE_EMAIL)) {
                    $this->arrayError['mail'] = 'Merci de renseigner un e-mail correcte!';
                }
                break;
            case 'password':
                if (!preg_match($regexPassword, $value)) {
                    $this->arrayError['password'] = 'Merci de donné un mot de passe avec au minimum : 8 caractères, 1 majuscule, 1 miniscule, 1 caractère spécial!';
                }
                break;
            case 'title':
                if (!preg_match($regexTitle, $value)) {
                    $this->arrayError['title'] = 'Merci de renseigner un titre correcte!';
                }
                break;
            case 'description':
                if (!preg_match($regexTitle, $value)) {
                    $this->arrayError['description'] = 'Merci de renseigner une description correcte!';
                }
                break;
            case 'content':
                if (!preg_match($regexContent, $value)) {
                    $this->arrayError['content'] = 'Merci de renseigner un contenu correcte!';
                }
                break;
            case 'idRole':
                if (!preg_match($regexRole, $value)) {
                    $this->arrayError['idRole'] = 'Merci de renseigner un role correcte!';
                }
                break;
            case 'start_task':
                if (!preg_match($regexDateTime, $value)) {
                    $this->arrayError['start_task'] = 'Merci de renseigner une date et heure correcte!';
                }
                break;
            case 'stop_task':
                if (!preg_match($regexDateTime, $value)) {
                    $this->arrayError['stop_task'] = 'Merci de renseigner une date et heure correcte!';
                }
                break;
            case 'point':
                if (!preg_match($regexPoint, $value)) {
                    $this->arrayError['point'] = 'Merci de renseigner un nombre de point/s correcte!';
                }
                break;
            case 'kid':
                if (!preg_match($regexPoint, $value)) {
                    $this->arrayError['kid'] = 'Merci de renseigner un enfant correcte!';
                }
                break;
            case 'status':
                if (!preg_match($regexName, $value)) {
                    $this->arrayError['status'] = 'Merci de renseigner un status correcte!';
                }
                break;
        }
    }

    public function check($nameInput, $value)
    {
        $this->isNotEmpty($nameInput);
        $value = htmlspecialchars($value);
        $this->checkFormat($nameInput, $value);
        return $this->arrayError;
    }
}