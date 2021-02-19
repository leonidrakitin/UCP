<?php
include_once $_SERVER['DOCUMENT_ROOT'] . '/main.php';
if (!isset($_POST['name']) || !isset($_POST['surname']) || !isset($_POST['origin']) || !isset($_POST['gender']) || !isset($_POST['birth']) || !isset($_POST['skin']) || !isset($_POST['character'])) 
{
    exit(redirect('../register/new_character.php', 0));
}
if (empty($_POST['name']) || empty($_POST['surname']) || empty($_POST['origin'])  || empty($_POST['gender']) || empty($_POST['birth']) || empty($_POST['skin']) || empty($_POST['character']))
{
    exit(redirect('../register/new_character.php', 0));
}
if (!isset($_SESSION['login']) || empty($_SESSION['login'])) {
    exit_account();
    exit(redirect('../', 0));
}

@$first_name = str_replace(" ", "_", $_POST['name']);
@$surname = str_replace(" ", "_", $_POST['surname']);
$name = $first_name . '_' . $surname;
$gender = $_POST['gender'];
$birth = $_POST['birth'];
$skin = $_POST['skin'];
$character = $_POST['character'];
$origin = $_POST['origin'];
$phone_number = GetNewNumber();

if (isset($_POST['projects'])) $projects = $_POST['projects'];
if (isset($_POST['terms'])) $terms = $_POST['terms'];

$create_time = time();

if (!preg_match("/^[a-zA-Z0-9_]{2,25}$/", $name)) {
    $_SESSION['new_mistake'] = 2;
    $_SESSION['new_skin'] = $_POST['skin'];
    $_SESSION['new_character'] = $_POST['character'];

    if (isset($_POST['projects'])) $_SESSION['new_projects'] = $_POST['projects'];
    if (isset($_POST['terms'])) $_SESSION['new_terms'] = $_POST['terms'];

    exit(redirect('../register/new_character.php', 0));
}

if ($_POST['skin'] > 299 || $_POST['skin'] < 0)
{
    $_SESSION['new_mistake'] = 3;
    $_SESSION['new_character'] = $_POST['character'];

    if (isset($_POST['projects'])) $_SESSION['new_projects'] = $_POST['projects'];
    if (isset($_POST['terms'])) $_SESSION['new_terms'] = $_POST['terms'];

    exit(redirect('../register/new_character.php', 0));
}

if (2020 - idate('Y',strtotime($birth)) < 16) {
    $_SESSION['new_mistake'] = 4;
    $_SESSION['new_skin'] = $_POST['skin'];
    $_SESSION['new_character'] = $_POST['character'];

    if (isset($_POST['projects'])) $_SESSION['new_projects'] = $_POST['projects'];
    if (isset($_POST['terms'])) $_SESSION['new_terms'] = $_POST['terms'];

    exit(redirect('../register/new_character.php', 0));
}

$issets = R::getRow('SELECT id FROM users WHERE `name`=?', [$name]);
if (isset($issets['id'])) {
    $_SESSION['new_mistake'] = 1;
    $_SESSION['new_skin'] = $_POST['skin'];
    $_SESSION['new_character'] = $_POST['character'];
    if (isset($_POST['projects'])) $_SESSION['new_projects'] = $_POST['projects'];
    if (isset($_POST['terms'])) $_SESSION['new_terms'] = $_POST['terms'];
    exit(redirect('../register/new_character.php', 0));
} else {
    $characters = R::getAssocRow('SELECT id FROM users WHERE `accountid`=?', [$_SESSION['id']]);

    if(count($characters)) R::exec('INSERT INTO users (accountid,`origin`,`name`,sex,number,birthdate,skin,status,`answer1`,create_date,create_ip) VALUES (?,?,?,?,?,?,?,?,?,?,?)', [$_SESSION['id'], $origin, $name, $gender, $phone_number, $birth, $skin , '0', $character, $create_time,real_ip()]);
    else R::exec('INSERT INTO users (accountid,`origin`,`name`,sex,number,birthdate,skin,status,`answer1`,`answer2`,`answer3`,create_date,create_ip) VALUES (?,?,?,?,?,?,?,?,?,?,?,?,?)', [$_SESSION['id'], $origin, $name, $gender, $phone_number, $birth, $skin , '0', $character, $projects, $terms, $create_time,real_ip()]);
    
    exit(redirect('../profile/list.php', 0));
}
?>