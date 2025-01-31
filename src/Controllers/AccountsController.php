<?php

namespace App\Controllers;
use App\Utils\AbstractController;



class AccountsController extends AbstractController{
    public function accountRegister() {
        require_once(__DIR__ . "/../Views/accountRegister.view.php");
}
}

