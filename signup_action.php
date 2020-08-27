<?php

require 'config.php';
require 'models/Auth.php';

$name = filter_input(INPUT_POST, 'name');
$email = filter_input(INPUT_POST, 'email', FILTER_VALIDATE_EMAIL);
$birthdate = filter_input(INPUT_POST, 'birthdate');
$password = filter_input(INPUT_POST, 'password');

if ($name && $email && $birthdate && $password) {
    $auth = new Auth($pdo, $base);

    $birthdate = explode('/', $birthdate);

    if ($birthdate[2] > date('Y')) {
        $_SESSION['flash'] = 'Data de nascimento inválida!';
        header("location: " . $base . "/signup.php");
        exit();
    }


    if (count($birthdate) != 3) {
        $_SESSION['flash'] = 'Data de nascimento inválida!';
        header("location: " . $base . "/signup.php");
        exit();
    }

    $birthdate = $birthdate[2] . '-' . $birthdate[1] . '-' . $birthdate[0];
    if (strtotime($birthdate) === false) {
        $_SESSION['flash'] = 'Data de nascimento inválida!';
        header("location: " . $base . "/signup.php");
        exit();
    }


    if (strtotime($birthdate) === false) {
        $_SESSION['flash'] = 'Data de nascimento inválida!';
        header("location: " . $base . "/signup.php");
        exit();
    }


    if ($auth->emailExists($email) === false) {

        $auth->registerUser($name, $email, $birthdate, $password);
        header("location: " . $base);
        exit();
    } else {
        $_SESSION['flash'] = 'E-mail já cadastrado!';
        header("location: " . $base . "/signup.php");
        exit();
    }
}

$_SESSION['flash'] = 'Preencha todos os campos!';
header("location: " . $base . "/signup.php");
exit();
