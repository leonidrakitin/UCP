<?php
include_once $_SERVER['DOCUMENT_ROOT'] . '/main.php';
if (!isset($_SESSION['login'])) exit(redirect('../', 0));
if ($_SESSION['admin'] < 3) exit(redirect('../profile/list.php', 0));
if (!preg_match("/^([0-9]){1,11}$/", $_GET['id']) || $_GET['id'] < 1) exit(redirect("../profile/list.php", 0));
$user=R::getRow('SELECT username,last_ip FROM accounts WHERE id=?',[$_GET['id']]);
if(!isset($user['login'])) exit(redirect('../profile/list.php',0));
$unban_time=time()+(60*60*24*$_POST['time']);
R::exec('INSERT INTO blacklist(ip,username,admin,reason,ban_date,unban_date) VALUES (?,?,?,?,NOW(),FROM_UNIXTIME(?))',[$user['last_ip'],$user['login'],$_SESSION['login'],$_POST['reason'],$unban_time]);
$_SESSION['ban-result']=1;
exit(redirect($_SERVER['HTTP_REFERER'],0));
?>