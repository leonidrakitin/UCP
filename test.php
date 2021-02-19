<?php
require $_SERVER['DOCUMENT_ROOT'] . '/rb.php';
R::ext('xdispense', function($table_name){
    return R::getRedBean()->dispense($table_name);
});

R::setup('mysql:host=185.248.199.32;dbname=irimiaorlando', 'irimiaorlando', 'GZUZROY0HqkvVT9d');

R::freeze(false);
if (!R::testConnection()) exit('<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>Red County Roleplay</title>
    <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
    <link rel="stylesheet" href="./assets/bootstrap.min.css">
    <link rel="stylesheet" href="./assets/font-awesome.min.css">
    <link rel="stylesheet" href="./assets/ionicons.min.css">
    <link rel="stylesheet" href="./assets/AdminLTE.min.css">
    <link rel="stylesheet" href="./assets/blue.css">
    <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
    <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <link rel="stylesheet"
          href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,600,700,300italic,400italic,600italic">
</head>
<body class="hold-transition login-page"
      style="background-image: url(https://i.imgur.com/nH6rKaN.png);height: auto;background-position: center center; background-repeat: no-repeat; background-attachment: fixed; background-size: cover;">
<div class="login-box">
    <div class="login-logo">
        <a href="../" style="color:white;">img src="../assets/logo.png" alt="<b>RC:RP</b>"></a>
    </div>
    <div class="login-box-body">
        <div class="social-auth-links text-center">
            <p>DEVELOPMENT.</p>
        </div>
    </div>
</div>
<script src="./assets/jquery.min.js"></script>
<script src="./assets/bootstrap.min.js"></script>
<script src="./assets/icheck.min.js"></script>
</body>
</html>');

$user_name=R::find('user_case','name=?',array('Jack'));
foreach ($user_name as $user) {
    echo $user->id;
}
?>