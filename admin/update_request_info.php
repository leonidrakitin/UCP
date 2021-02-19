<?php
include_once $_SERVER['DOCUMENT_ROOT'] . '/main.php';
if (!isset($_SESSION['login'])) exit(redirect('../', 0));
if ($_SESSION['admin'] < 1) exit(redirect('../profile/list.php', 0));

/*if (!preg_match("/^([0-9]){1,11}$/", $_GET['id']) || $_GET['id'] < 1) exit(redirect("../admin/requests.php", 0));*/
$rows = R::getRow('SELECT * FROM users WHERE id=?', [$_POST['req']]);

if ($rows['status'] != 0) {
    echo "This application has already been verified!";
    exit(redirect("../admin/requests.php", 2));
}

$reason = $_POST['admin_answer'];

if (isset($_POST['accept'])) {
    echo "You have approved the character. Your comment:<br><b>" . $reason . "</b>";
    R::exec('UPDATE users SET status=1, admin_name=?, reason=? WHERE id=?', [$_SESSION['login'], $reason, $_POST['req']]);
    exit(redirect("../admin/requests.php", 2));
} else {
    echo "You have denied the character. your comment:<br><b>" . $reason . "</b>";
    R::exec('UPDATE users SET status=2, admin_name=?, reason=? WHERE id=?', [$_SESSION['login'], $reason, $_POST['req']]);
    exit(redirect("../admin/requests.php", 2));
}
?>