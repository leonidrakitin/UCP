<?php
session_start();
date_default_timezone_set('Europe/Moscow');
include_once $_SERVER['DOCUMENT_ROOT'] . '/cesar.php';
include $_SERVER['DOCUMENT_ROOT'] . '/mysql.php';
function redirect($url = '/', $seconds)
{
    echo "<meta http-equiv='refresh' content='" . $seconds . ";" . $url . "'>";
}

if (isset($_COOKIE['face']) && Cesar(md5($_COOKIE['face']), 9) != $_COOKIE['face_hash']) unset($_COOKIE['face']);
if (!isset($_COOKIE['face'])) {
    $newface = "FACE2.0_" . Cesar(md5(uniqid()), 17) . "_" . date("dmY");
    SetCookie("face", $newface, time() + 3600 * 24 * 365 * 10, "/");
    SetCookie("face_hash", Cesar(md5($newface), 9), time() + 3600 * 24 * 365 * 10, "/");
    exit(redirect($_SERVER['REQUEST_URI'], 0));
}
function exit_account()
{
    setcookie("rcrp_login", "", time() - 1, "/");
    setcookie("rcrp_pass", "", time() - 1, "/");
    @session_destroy();
}

function user_auth($login, $password)
{
    $rows = R::getRow('SELECT id,login,password,email,donate,helper,admin FROM accounts WHERE login=? AND password=?', [$login, $password]);
    if (!isset($rows['id'])) return 0;
    $_SESSION['id'] = $rows['id'];
    $_SESSION['login'] = $rows['login'];
    $_SESSION['password'] = $rows['password'];
    $_SESSION['admin'] = $rows['admin'];
    $_SESSION['helper'] = $rows['helper'];
    $_SESSION['donate'] = $rows['donate'];
    $_SESSION['email'] = $rows['email'];
    //$_SESSION['premium'] = $rows['premium'];
    R::exec('UPDATE accounts SET last_ucp_ip=?,last_ucp_login=? WHERE id=?', [real_ip(),date('d/m/Y, h:i:s', time()), $_SESSION['id']]);
    SetCookie("hash_a", md5($login . "RCRP"), time() + 3600 * 24 * 365, "/");
    exit(redirect($_SERVER['REQUEST_URI'], 1));
}

function format_by_count($number, $one, $two, $five)
{
    if (($number - $number % 10) % 100 != 10) {
        if ($number % 10 == 1) {
            $result = $one;
        } elseif ($number % 10 >= 2 && $number % 10 <= 4) {
            $result = $two;
        } else {
            $result = $five;
        }
    } else {
        $result = $five;
    }
    return $result;
}

function assign_rand_value($num)
{
    switch ($num) {
        case "1"  :
            $rand_value = "a";
            break;
        case "2"  :
            $rand_value = "b";
            break;
        case "3"  :
            $rand_value = "c";
            break;
        case "4"  :
            $rand_value = "d";
            break;
        case "5"  :
            $rand_value = "e";
            break;
        case "6"  :
            $rand_value = "f";
            break;
        case "7"  :
            $rand_value = "g";
            break;
        case "8"  :
            $rand_value = "h";
            break;
        case "9"  :
            $rand_value = "i";
            break;
        case "10" :
            $rand_value = "j";
            break;
        case "11" :
            $rand_value = "k";
            break;
        case "12" :
            $rand_value = "l";
            break;
        case "13" :
            $rand_value = "m";
            break;
        case "14" :
            $rand_value = "n";
            break;
        case "15" :
            $rand_value = "o";
            break;
        case "16" :
            $rand_value = "p";
            break;
        case "17" :
            $rand_value = "q";
            break;
        case "18" :
            $rand_value = "r";
            break;
        case "19" :
            $rand_value = "s";
            break;
        case "20" :
            $rand_value = "t";
            break;
        case "21" :
            $rand_value = "u";
            break;
        case "22" :
            $rand_value = "v";
            break;
        case "23" :
            $rand_value = "w";
            break;
        case "24" :
            $rand_value = "x";
            break;
        case "25" :
            $rand_value = "y";
            break;
        case "26" :
            $rand_value = "z";
            break;
        case "27" :
            $rand_value = "0";
            break;
        case "28" :
            $rand_value = "1";
            break;
        case "29" :
            $rand_value = "2";
            break;
        case "30" :
            $rand_value = "3";
            break;
        case "31" :
            $rand_value = "4";
            break;
        case "32" :
            $rand_value = "5";
            break;
        case "33" :
            $rand_value = "6";
            break;
        case "34" :
            $rand_value = "7";
            break;
        case "35" :
            $rand_value = "8";
            break;
        case "36" :
            $rand_value = "9";
            break;
    }
    return $rand_value;
}

function get_rand_alphanumeric($length)
{
    if ($length > 0) {
        $rand_id = "";
        for ($i = 1; $i <= $length; $i++) {
            mt_srand((double)microtime() * 1000000);
            $num = mt_rand(1, 36);
            $rand_id .= assign_rand_value($num);
        }
    }
    return $rand_id;
}

function get_rand_numbers($length)
{
    if ($length > 0) {
        $rand_id = "";
        for ($i = 1; $i <= $length; $i++) {
            mt_srand((double)microtime() * 1000000);
            $num = mt_rand(27, 36);
            $rand_id .= assign_rand_value($num);
        }
    }
    return $rand_id;
}

function get_rand_letters($length)
{
    if ($length > 0) {
        $rand_id = "";
        for ($i = 1; $i <= $length; $i++) {
            mt_srand((double)microtime() * 1000000);
            $num = mt_rand(1, 26);
            $rand_id .= assign_rand_value($num);
        }
    }
    return $rand_id;
}

function ucp_header()
{
    ucp_head_character1();
    ucp_head_character2();
}

function ucp_head_character1() 
{
    echo '
    <!DOCTYPE html>
    <html>
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <title>Red County Roleplay</title>
        <link rel="shortcut icon" href="../assets/icon.png" type="image/x-icon">
        <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
        <link rel="stylesheet" href="../assets/bootstrap.min.css"> <!-- <link rel="stylesheet" href="../assets/font-awesome.min.css">-->
        <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.0.10/css/all.css" integrity="sha384-+d0P83n9kaQMCwj8F4RJB66tzIwOKmrdb46+porD/OvrJ+37WqIM7UoBtwHO6Nlg" crossorigin="anonymous">
        <link rel="stylesheet" href="../assets/ionicons.min.css">
        <link rel="stylesheet" href="../assets/AdminLTE.min.css">
        <link rel="stylesheet" href="../assets/_all-skins.min.css">
        <link rel="stylesheet" href="./assets/blue.css">
        <div id="fb-root"></div>
        <script async defer crossorigin="anonymous" src="https://connect.facebook.net/ru_RU/sdk.js#xfbml=1&version=v9.0" nonce="kwP1dToX"></script>
        <script src="https://vk.com/js/api/openapi.js?168" type="text/javascript"></script>
        <!--[if lt IE 9]>
        <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
        <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
        <![endif]-->
        <link rel="stylesheet"
              href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,600,700,300italic,400italic,600italic">';
}

function ucp_head_character2() 
{
    if (isset($_SESSION['login']) && isset($_SESSION['id'])) {
        $characters = R::getAssocRow('SELECT id,`name`,skin FROM users WHERE accountid=? ORDER BY last_login ASC', [$_SESSION['id']]);
        echo '<style>';

        for ($i = 0; $i < count($characters); $i++) {
            echo '.character-' . $i . ' {
                background-image: url(../assets/skins/'. $characters[$i]['skin'] .'.png);
                display: inline-block;
                width: 25px;
                height: 25px;
                background-size: 100%;
                background-position: center top 3px;
                background-repeat: no-repeat;
                border-radius: 50%;
                background-color: #ddd;
                cursor: pointer;
            }';
        }

        echo '</style>';
    }

    echo'</head>
    <body class="hold-transition skin-blue sidebar-mini sidebar-collapse">
    <div class="wrapper">
        <header class="main-header">
            <a href="../news/" class="logo">
                <span class="logo-mini"><img src="../assets/logo.png" width="50" alt="<b>RED COUNTY</b> ROLEPLAY"></span>
                <span class="logo-lg"><img src="../assets/logo.png" height="85" alt="<b>RED COUNTY</b> ROLEPLAY"></span>
            </a>
            <nav class="navbar navbar-static-top">
                <div class="container">
                    <a href="#" class="sidebar-toggle" data-toggle="push-menu" role="button" style="font-family: Source Sans Pro, Helvetica Neue, Helvetica, Arial, sans-serif;">
                        <i class="fas fa-bars"></i> MENU
                    </a>';
                if (isset($_SESSION['login'])) {
                    echo '<ul class="list-inline">
                        <li class="nav-item"><b>' . $_SESSION['login'] . '</b></li>
                        <li class="nav-item mr-3">
                            <a class="nav-link" data-toggle="dropdown" href="#" aria-expanded="false">
                                <i class="fa fa-fw fa-user icon" style="color: #fff;"></i>
                            </a>
                            <div class="dropdown-menu dropdown-menu-lg dropdown-menu-right" style="left: inherit;right: 0px;">
                                <div class="row">
                                    <div style="font-size: 17px;font-weight: 600;display: inline;" class="col-sm-8">
                                    ' . $_SESSION['login'] . '
                                    </div>
                                    <div class="col-sm-1" style="display: inline;">
                                        <a href="../profile/config.php">
                                            <i class="fa fa-fw fa-cogs menu-icon"></i>
                                        </a>
                                    </div>
                                    <div class="col-sm-1" style="display: inline;">
                                        <a href="../profile/logout.php">
                                            <i class="fa fa-fw fa-power-off menu-icon"></i>
                                        </a>
                                    </div>
                                </div>
                                <hr style="margin: 7px;">

                                <div class="row">';
                                for ($i = 0; $i < count($characters); $i++) {
                                    echo '<div class="col-sm-2" style="display: inline;">
                                        <a href="../profile/character.php?id=' . $characters[$i]['id'] . '">
                                            <div class="character-'. $i .'" tabindex="0" title="'.$characters[$i]['name'].'"></div>
                                        </a>
                                    </div>';
                                }
                            echo '</div>
                            </div>
                        </li>
                        <li class="nav-item mr-3">
                            <a class="nav-link" data-toggle="dropdown" href="#" aria-expanded="false">
                                <i class="icon fa fa-fw fa-bell" style="color: #fff;"></i>
                            </a>
                            <div class="dropdown-menu dropdown-menu-lg dropdown-menu-right" style="left: inherit;right: 0px;">
                                <div class="row">
                                    <div style="font-size: 16px;font-weight: 600;display: inline;text-align: center;" class="col-sm-12">
                                        Latest notifications
                                    </div>
                                </div>

                                <hr style="margin: 7px;">

                                <div class="row">
                                    <div class="col-sm-12" style="display: inline;text-align: center;font-size:12.5px">
                                        There is nothing here yet!
                                    </div>
                                </div>

                                <hr style="margin: 7px;">

                                <div class="row">
                                    <div style="display: inline;text-align: center;" class="col-sm-12">
                                        <a href="#">
                                            <spam style="background-color: #000000;padding: 5px 65px;border-radius: 15px;color: #fff;">Read all</spam>
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </li>
                    </ul>';
                }

    echo'       </div>
            </nav>
        </header>';
}


function sidebar()
{
    echo '<aside class="main-sidebar">
        <section class="sidebar">
            <ul class="sidebar-menu tree" data-widget="tree">
                <li class="header">
                    Red County Roleplay
                </li>';
    
    if(basename($_SERVER['PHP_SELF']) == 'index.php') echo '<li class="active">';
    else echo '<li>';
    
    echo'
        <a href="../news/index.php">
                <i class="fas fa-home"></i><span style="padding-left: 5px;"> News</span>
            </a>
        </li>';

    if (isset($_SESSION['login'])) {
        if(basename($_SERVER['PHP_SELF']) == 'punishments.php') echo '<li class="active">';
        else echo '<li>';
            
        echo'
                <a href="../punishments.php">
                    <i class="fa fa-fw fa-gavel"></i><span style="padding-left: 3px;"> Punishments</span>
                </a>
            </li>';

        if(dirname($_SERVER['PHP_SELF']) == '/profile') echo '<li class="active">';
        else echo '<li>';
            
        echo'
                <a href="../profile/list.php">
                    <i class="fas fa-users"></i><span style="padding-left: 3px;"> Characters</span>
                </a>
            </li>';
    }
        
    if(basename($_SERVER['PHP_SELF']) == 'online.php') echo '<li class="active">';
    else echo '<li>';
       
    echo'
            <a href="../online.php">
                <i class="fas fa-street-view"></i><span style="padding-left: 7px;"> Players Online</span>
            </a>
        </li>';

    if(basename($_SERVER['PHP_SELF']) == 'map.php') echo '<li class="active">';
    else echo '<li>';
       
    echo'
            <a href="../map.php">
                <i class="far fa-map"></i><span style="padding-left: 5px;"> Map</span>
            </a>
        </li>';

    if (!isset($_SESSION['login']))
    {
        echo '<li';
        if(basename($_SERVER['PHP_SELF']) == 'login.php') echo ' class="active">';
        else echo '>';

        echo'
                    <a href="../login.php">
                        <i class="fas fa-sign-in-alt"></i><span style="padding-left: 7px;"> Authorization</span>
                    </a>
                </li>';
        echo '<li';
        if(basename($_SERVER['PHP_SELF']) == 'register.php') echo ' class="active">';
        else echo '>';
        
        echo'
                    <a href="../register/register.php">
                    <i class="fas fa-user-plus"></i><span style="padding-left: 3px;"> Registration</span>
                    </a>
                </li>';
    }

    if(isset($_SESSION['admin'])) {   
        if ($_SESSION['admin'] > 1) {
            $requests = R::getCell('SELECT COUNT(*) FROM users WHERE status=0');
            //$requests = $result->rowCount();

            if(dirname($_SERVER['PHP_SELF']) == '/admin') echo '<li class="treeview active">';
            else echo '<li class="treeview">';

            echo '<a href="#"><i class="fas fa-archive"></i><span style="padding-left: 7px;"> Admin panel</span>
                        <span class="pull-right-container">
                            <i class="fa fa-angle-left pull-right"></i>
                        </span>
                    </a>
                    <ul class="treeview-menu" style="display: none;">';
            echo '
                <li';
            $referer = explode("/", $_SERVER['SCRIPT_NAME']);
            if ($referer[1] . $referer[2] == 'adminrequests.php' || $referer[1] . $referer[2] == 'adminrequest_info.php' || $referer[1] . $referer[2] == 'adminseen_request_info.php') echo ' class="active"';
            echo '>
                    <a href="../admin/requests.php">
                        <i class="far fa-circle nav-icon"></i> 
                        <span>Check UCP</span>
                        <span class="pull-right-container">
                            <small class="label pull-right">' . $requests . '</small>
                        </span>
                    </a>
                </li>';
            echo '<li';
            if ($referer[1] . $referer[2] == 'adminsearch.php') echo ' class="active"';
            echo '>
                    <a href="../admin/search.php">
                        <i class="far fa-circle nav-icon"></i> 
                        <span>Account search</span>
                    </a>
                </li>';
            /*if($_SESSION['admin']>3) {
                echo '<li';
                if ($referer[1] . $referer[2] == 'adminck.php') echo ' class="active"';
                echo '>
                    <a href="../admin/ck.php">
                        <i class="far fa-circle nav-icon"></i> 
                        <span>Manage CK</span>
                    </a>
                </li>';
            }*/
            echo '<li';
            if ($referer[1] . $referer[2] == 'adminadmins.php') echo ' class="active"';
            echo '>
                    <a href="../admin/admins.php">
                        <i class="far fa-circle nav-icon"></i> 
                        <span>Administration</span>
                    </a>
                </li>';
            echo '<li';
            if ($referer[1] . $referer[2] == 'adminlog.php') echo ' class="active"';
            echo '>
                    <a href="../admin/log.php">
                        <i class="far fa-circle nav-icon"></i> 
                        <span>Action log</span>
                    </a>
                </li>';
            echo '
            </ul>
        </li>';
        }
    }
    echo '
                    <li class="header" style="margin-top: 30px;">
                        Useful Links
                    </li>
                    <li>
                        <a href="http://forum.rc-rp.ru">
                            <i class="fas fa-comments"></i><span style="padding-left: 5px;"> Community Forum</span>
                        </a>
                    </li>
                    <li>
                        <a href="http://vk.com/rc.roleplay">
                            <i class="fab fa-facebook-square"></i><span style="padding-left: 5px;"> Facebook page</span>
                        </a>
                    </li>
                    <li>
                        <a href="samp://server.rc-rp.ru:7777">
                            <i class="fas fa-server"></i><span style="padding-left: 7px;"> <b>IP:</b> server.rc-rp.ru:7777</span>
                        </a>
                    </li>
                 </ul>
            </section>
        </aside>';
}

function ucp_footer() {
    echo '
    <footer class="main-footer" style=" text-align: center;">
        <div class="float-right d-none d-sm-block">
            <a href="http://rc-rp.ru" style="color: gray;">Red County Roleplay</a>
        </div>
        BETA UCP v1.1
  </footer>';
}

function real_ip()
{
   $ip = $_SERVER['REMOTE_ADDR'];
    if (isset($_SERVER['HTTP_X_FORWARDED_FOR']) && preg_match_all('#\d{1,3}\.\d{1,3}\.\d{1,3}\.\d{1,3}#s', $_SERVER['HTTP_X_FORWARDED_FOR'], $matches)) {
        foreach ($matches[0] AS $xip) {
            if (!preg_match('#^(10|172\.16|192\.168)\.#', $xip)) {
                $ip = $xip;
                break;
            }
        }
    } elseif (isset($_SERVER['HTTP_CLIENT_IP']) && preg_match('/^([0-9]{1,3}\.){3}[0-9]{1,3}$/', $_SERVER['HTTP_CLIENT_IP'])) {
        $ip = $_SERVER['HTTP_CLIENT_IP'];
    } elseif (isset($_SERVER['HTTP_CF_CONNECTING_IP']) && preg_match('/^([0-9]{1,3}\.){3}[0-9]{1,3}$/', $_SERVER['HTTP_CF_CONNECTING_IP'])) {
        $ip = $_SERVER['HTTP_CF_CONNECTING_IP'];
    } elseif (isset($_SERVER['HTTP_X_REAL_IP']) && preg_match('/^([0-9]{1,3}\.){3}[0-9]{1,3}$/', $_SERVER['HTTP_X_REAL_IP'])) {
        $ip = $_SERVER['HTTP_X_REAL_IP'];
    }
    return $ip;

}

function GetNewNumber()
{
    do 
    {
        $number = rand(100100, 999999);
        $issets = R::getRow('SELECT id FROM users WHERE `number`=?', [$number]);
    } 
    while (!isset($issets['id']));

    return $number;
}

?>

