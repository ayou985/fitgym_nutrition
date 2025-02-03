<?php

namespace App\Controllers;
use App\Utils\AbstractController;


use App\Models\User;


class AccountsController extends AbstractController{
    public function accountRegister() {
        if (isset($_POST['email'], $_POST['password'], $_POST['firstName'], $_POST['lastName'] )) {
            $this->check('id', $_POST['id']);
            $this->check('email', $_POST['email']);
            $this->check('password', $_POST['password']);
            $this->check('firstName', $_POST['firstName']);
            $this->check('phoneNumber', $_POST['phoneNumber']);
            $this->check('address', $_POST['address']);
            $this->check('id_Role', $_POST['id_Role']);

            
            if (empty($this->arrayError)) {
                $email = htmlspecialchars($_POST['email']);
                $password = htmlspecialchars($_POST['password']);
                $firstName = htmlspecialchars($_POST['firstName']);
                $lastName = htmlspecialchars($_POST['lastName']);
                $phoneNumber = htmlspecialchars($_POST['phoneNumber']);
                $address = htmlspecialchars($_POST['address']);

                $id_role =  1;
                $passwordHash = password_hash($password, PASSWORD_DEFAULT);
                $user = new User(null, $email, $passwordHash, $firstName, $lastName, null , null , $id_role);
                $user->save();
                $this->redirectToRoute('/');
            }
    } require_once(__DIR__ . "/../Views/accountRegister.view.php");
}
}

