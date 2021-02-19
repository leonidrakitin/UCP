<?php
include $_SERVER['DOCUMENT_ROOT'] . '/main.php';
if (!isset($_POST['login']) || !isset($_POST['password'])) exit(redirect("../news/index.php", 0));

$username = $_POST['login'];
$password = $_POST['password'];

$result = user_auth($username, hash("whirlpool", $password));

if (!isset($_POST['nosaveme'])) {
    SetCookie("rcrp_login", $username, time() + 3600 * 24 * 365, "/");
    SetCookie("rcrp_pass", hash("whirlpool", $password), time() + 3600 * 24 * 365, "/");
}
if (!$result) {
    $_SESSION['auth_fail'] = 1;
    redirect("../login.php",0);
} else {
    redirect('../news/',0);
}
?>