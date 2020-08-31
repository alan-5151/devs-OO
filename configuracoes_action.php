<?php

require_once 'config.php';
require_once 'models/Auth.php';
require_once 'dao/UserDaoMysql.php';
include 'includes/cutImage.php';

$auth = new Auth($pdo, $base);
$userInfo = $auth->checkToken();
$firstName = current(explode(' ', $userInfo->name));

$userDao = new UserDaoMysql($pdo);

$name = filter_input(INPUT_POST, 'name', FILTER_SANITIZE_SPECIAL_CHARS);
$email = filter_input(INPUT_POST, 'email', FILTER_SANITIZE_SPECIAL_CHARS, FILTER_VALIDATE_EMAIL);
$birthdate = filter_input(INPUT_POST, 'birthdate', FILTER_SANITIZE_SPECIAL_CHARS);
$city = filter_input(INPUT_POST, 'city', FILTER_SANITIZE_SPECIAL_CHARS);
$work = filter_input(INPUT_POST, 'work', FILTER_SANITIZE_SPECIAL_CHARS);
$password = filter_input(INPUT_POST, 'password', FILTER_SANITIZE_SPECIAL_CHARS);
$password_confirmation = filter_input(INPUT_POST, 'password_confirmation', FILTER_SANITIZE_SPECIAL_CHARS);

if ($name && $email) {
    $userInfo->name = $name;
    $userInfo->city = $city;
    $userInfo->work = $work;

    // Verifica se email já existe no BD
    if ($userInfo->email != $email) {
        if ($userDao->findByEmail($email) === false) {
            $userInfo->email = $email;
        } else {
            $_SESSION['flash'] = 'E-mail já existe!';
            header("location:javascript://history.go(-1)");
            exit();
        }
    }
    // Verifica se data de nascimento é válida.
    $birthdate = explode('/', $birthdate);
    if ($birthdate[2] > date('Y') || $birthdate[2] < date('Y') - 100) {
        $_SESSION['flash'] = 'Data de nascimento inválida!';
        header("location: " . $base . "/configuracoes.php");
        exit();
    }
    if (count($birthdate) != 3) {
        $_SESSION['flash'] = 'Data de nascimento inválida!';
        header("location: " . $base . "/configuracoes.php");
        exit();
    }
    $birthdate = $birthdate[2] . '-' . $birthdate[1] . '-' . $birthdate[0];
    if (strtotime($birthdate) === false) {
        $_SESSION['flash'] = 'Data de nascimento inválida!';
        header("location: " . $base . "/configuracoes.php");
        exit();
    }
    if (strtotime($birthdate) === false) {
        $_SESSION['flash'] = 'Data de nascimento inválida!';
        header("location: " . $base . "/configuracoes.php");
        exit();
    }
    $userInfo->birthdate = $birthdate;

    // Trocar senha, se necessário

    if (!empty($password)) {
        if ($password === $password_confirmation) {
            $hash = password_hash($password, PASSWORD_DEFAULT);
            $userInfo->password = $hash;
        } else {
            $_SESSION['flash'] = 'As senhas digitadas não conferem!';
            header("location: " . $base . "/configuracoes.php");
            exit();
        }
    }


    // Avatar

    if (isset($_FILES['avatar']) && !empty($_FILES['avatar']['tmp_name'])) {
        $newAvatar = $_FILES['avatar'];
        $oldAvatar = $userInfo->avatar;
        if (in_array($newAvatar['type'], ['image/jpeg', 'image/jpg', 'image/png'])) {
            $avatarName = cutImage($newAvatar, 200, 200, 'media/avatars');
            $userInfo->avatar = $avatarName;

            if ($oldAvatar != 'default.jpg') {
                unlink("media/avatars/$oldAvatar");
            }
        }
    }

    // Cover

    if (isset($_FILES['cover']) && !empty($_FILES['cover']['tmp_name'])) {
        $newCover = $_FILES['cover'];
        $oldCover = $userInfo->cover;

        if (in_array($newCover['type'], ['image/jpeg', 'image/jpg', 'image/png'])) {
            $coverName = cutImage($newCover, 850, 313, 'media/covers');
            $userInfo->cover = $coverName;

            if ($oldAvatar != 'default.jpg') {
                unlink("media/covers/$oldCover");
            }
        }
    }

    $userDao->update($userInfo);
}

header("location: " . $base . "/configuracoes.php");
exit();
