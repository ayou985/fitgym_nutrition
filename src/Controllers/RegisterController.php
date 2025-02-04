<?php

namespace App\Controllers;
use App\Utils\AbstractController;


use App\Models\User;


class RegisterController  extends AbstractController{
    public function index() {
        if (isset($_POST['email'], $_POST['password'], $_POST['firstName'], $_POST['lastName'] )) {
            // $this->check('email', $_POST['email']);
            // $this->check('password', $_POST['password']);
            // $this->check('firstName', $_POST['firstName']);
            
            
            if (empty($this->arrayError)) {
                $email = htmlspecialchars($_POST['email']);
                $password = htmlspecialchars($_POST['password']);
                $firstName = htmlspecialchars($_POST['firstName']);
                $lastName = htmlspecialchars($_POST['lastName']);
                
                $id_role =  2;
                $passwordHash = password_hash($password, PASSWORD_DEFAULT);
                $user = new User(null, $email, $passwordHash, $firstName, $lastName, null , null , $id_role);
                $user->save();
                $this->redirectToRoute('/');
            }
    } require_once(__DIR__ . "/../Views/register.view.php");
}

public function product()
{
    (require_once __DIR__ . "/../Views/product.view.php");
}
}

