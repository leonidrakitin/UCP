<?php
include_once $_SERVER['DOCUMENT_ROOT'] . '/main.php';

if (isset($_SESSION['login'])) exit(redirect("../profile/list.php", 0));

if (!isset($_POST['login']) || !isset($_POST['password']) || !isset($_POST['mail'])) exit(redirect('../register/account.php', 0));
    
$check_user = R::getRow('SELECT id FROM accounts WHERE login=? LIMIT 1', [$_POST['login']]);
if (isset($check_user['id'])) {
    $_SESSION['second-mistakes'] = 1;
    exit(redirect('../register/account.php', 0));
}

$check_mail = R::getRow('SELECT id FROM accounts WHERE email=? LIMIT 1', [$_POST['mail']]);
if (isset($check_mail['id'])) {
    $_SESSION['second-mistakes'] = 2;
    exit(redirect('../register/account.php', 0));
}

if (!preg_match("/^([a-zA-Z0-9]){2,25}$/", $_POST['login'])) {
    $_SESSION['second-mistakes'] = 3;
    exit(redirect('../register/account.php', 0));
}

if (!preg_match("/^([_a-zA-Z0-9$#@!%^&*]){2,25}$/", $_POST['password'])) {
    $_SESSION['second-mistakes'] = 4;
    exit(redirect('../register/account.php', 0));
}

if (!isset($check_user['id']) && !isset($check_mail['id']) && !isset($_SESSION['second-mistakes'])) {
    $username = $_POST['login'];
    $password = hash("whirlpool", $_POST['password']);
    $mail = $_POST['mail'];
    $reg_date = date("d/m/Y, H:i");
    R::exec('INSERT INTO accounts (login,password,email,reg_date,reg_ip) VALUES (?,?,?,?,?)', [$username, $password, $mail, $reg_date, real_ip()]);
    exit_account();
    echo "You have successfully created an account!";
    exit(redirect("../", 2));
}