<?php
include_once $_SERVER['DOCUMENT_ROOT'] . '/main.php';
if (!isset($_SESSION['login'])) exit(redirect('../', 0));
if (!preg_match("/^([0-9]){1,11}$/", $_GET['id']) || $_GET['id'] < 1) exit(redirect("../profile/list.php", 0));

$character = R::getRow('SELECT * FROM users WHERE id=? LIMIT 1', [$_GET['id']]);

if ($character['accountid'] != $_SESSION['id']) exit(redirect('../profile/list.php', 0));

if(isset($character['name']) && isset($_GET['delete'])) {
    if ($_GET['delete'] == 'accepted') {
        R::exec('DELETE FROM users WHERE `name`=? AND accountid=?', [$character['name'], $_SESSION['id']]);
        exit(redirect('../profile/list.php', 0));
    }
}

$fight_name = [
    0 => "Standard",
    1 => "Boxing",
    2 => "Kungfu", 
    3 => "Kneehead", 
    4 => "Grabkick"
];

ucp_header();
sidebar();
?>

<div class="content-wrapper">
    <section class="content">
        <div class="container">
            <?php if ($character['status'] == 0) {
                echo' <div class="alert alert-warning alert-dismissible">
                <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button><h5>
                <i class="far fa-clock"></i> 
                <b>YOUR CHARACTER APPLICATION STATUS: PENDING!</b></h5>
                While you are waiting for approval, you can flip through the section on the forum: <a href="http://forum.rc-rp.ru">http://forum.rc-rp.ru!</a>!
            </div>';
            } ?>
            <?php if ($character['status'] == 1) {
                echo' <div class="alert alert-success alert-dismissible">
                    <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button><h5>
                    <i class="icon fas fa-check"></i> 
                    <b>YOUR CHARACTER APPLICATION STATUS: APROVED!</b></h5><strong>Comment by '. $character['admin_name'] .': </strong>
                    '. $character['reason'] .'
                    <br><br>
                    Now you can log into the server and start the game! To log in, use your account name and password. Good game!
                </div>';
            } ?>
            <?php if ($character['status'] == 2) {
                echo' <div class="alert alert-danger alert-dismissible">
                    <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button><h5>
                    <i class="icon fas fa-ban"></i> 
                    <b>YOUR CHARACTER APPLICATION STATUS: DENIED!</b></h5><strong>Comment by '. $character['admin_name'] .': </strong>
                    '. $character['reason'] .'
                    <p style="margin-top: 15px;"><b>Attention!</b> Pressing the button will <b>delete</b> the current application!</p>
                    <a href="?id=' . $_GET['id'] . '&delete=accepted" class="btn btn-block btn-danger">Acquainted</a>
                </div>
                
                <div class="card">
                    <div class="card-header">Your Answer:</div>
                    <div class="card-body">
                        '. $character['answer1'] .'<br>
                        '. $character['answer2'] .'<br>
                        '. $character['answer3'] .'<br>
                    </div>
                    
                </div>';
            } ?>
            <?php if ($character['status'] == 3) {
                echo' <div class="alert alert-danger alert-dismissible">
                    <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button><h5>
                    <i class="icon fas fa-ban"></i> 
                    <b>YOUR CHARACTER APPLICATION STATUS: BLOCKED!</b></h5><br>
                    <strong>Administrator:</strong>'. $character['block_name'] .'
                    <strong>Reason:</strong>'. $character['block_reason'] .'
                    <br><br>
                    If you do not agree with the ban given to you, you can turn to a special section on the forum: <a href="http://forum.rc-rp.ru/viewforum.php?f=29">http://forum.rc-rp.ru/viewforum.php?f=29</a>. If you admit guilt and accept your punishment, you can see the <b>section of unban for payment</b> - another form of atonement for the project, equivalent to punishment. Link: http://forum.rc-rp.ru/viewtopic.php?f=29&t=30 
                </div>';
            } ?>
            <?php if ($character['status'] == 4) {
                $ban = R::getRow('SELECT `name`,`reason`,`ip`,`date`,`admin` FROM bans WHERE `name`=?', [$character['name']]);
                echo' <div class="alert alert-danger alert-dismissible">
                    <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button><h5>
                    <i class="icon fas fa-ban"></i> 
                    <b>YOUR CHARACTER APPLICATION STATUS: BANNED!</b></h5><br>
                    <strong>Date:</strong>'. $ban['date'] .'<br>
                    <strong>Administrator:</strong>'. $ban['admin'] .'<br>
                    <strong>Reason:</strong>'. $ban['reason'] .'<br>
                    <strong>IP:</strong>'. $ban['ip'] .'
                    <br><br>
                    If you do not agree with the ban given to you, you can turn to a special section on the forum: <a href="http://forum.rc-rp.ru/viewforum.php?f=29">http://forum.rc-rp.ru/viewforum.php?f=29</a>. If you admit guilt and accept your punishment, you can see the <b>section of unban for payment</b> - another form of atonement for the project, equivalent to punishment. Link: http://forum.rc-rp.ru/viewtopic.php?f=29&t=30 
                </div>';
            } ?>

            <?php echo '<h1>' . substr_replace($character['name'], " ", strpos($character['name'], "_"), 1) . '</h1><br>'; ?>

            <div class="row">
                <div class="col-sm-3">
                    <div class="card">
                        <div class="card-header">
                            <i class="fa fa-fw fa-child color-blue"></i><strong style="font-size: 18px;">Change character skin</strong>
                        </div>
                        <div class="card-body" style="margin-bottom: 51px;">
                            <?php echo '<img class="profile-user-img img-responsive" src="../assets/skins/'. $character['skin'] .'.png">'; ?>
                            <hr>
                            <?php echo '<p style="text-align: center;margin: 0px;"><small><b style="">SKIN ID:</b> '. $character['skin'] .'</small></p>'; ?>
                        </div>
                    </div>
                </div>

                <div class="col-sm-4">
                    <div class="card">
                        <div class="card-header">
                            <i class="fas fa-cloud color-blue"></i><strong style="font-size: 18px;"> OOC Info</strong>
                        </div>
                        <div class="card-body" style="margin-bottom: 35px;">
                            <div class="row">
                                <div class="col-sm-8">Player #</div>
                                <?php echo '<div class="col-sm-4"><p style="float: right; margin: 0px;">'. $character['accountid'] .'</p></div>'; ?>
                            </div>
                            <div class="row">
                                <div class="col-sm-8">Warnings</div>
                                <?php echo '<div class="col-sm-4"><p style="float: right; margin: 0px;">'. $character['warns'] .' / 3</p></div>'; ?>
                            </div>
                            <div class="row">
                                <div class="col-sm-4">Donation</div>
                                <?php echo '<div class="col-sm-8"><p style="float: right; margin: 0px;';
                                    if($character['vip'] == 0) echo 'color:black;">N/A</p></div>';
                                    else if($character['vip'] == 1) echo 'color:#ce5c19;">Bronze <spam style="color:black;">(until the '.date('d/m/y, h:m', $character['vip_time']).')</spam></p></div>';
                                    else if($character['vip'] == 2) echo 'color:#d4d4d4;">Silver <spam style="color:black;">(until the '.date('d/m/y, h:m', $character['vip_time']).')</spam></p></div>';
                                    else if($character['vip'] == 3) echo 'color:#f3e000;">Gold <spam style="color:black;">(until the '.date('d/m/y, h:m', $character['vip_time']).')</spam></p></div>';
                                ?>
                            </div>
                            <div class="row">
                                <div class="col-sm-8">Time played</div>
                                <?php echo '<div class="col-sm-4"><p style="float: right; margin: 0px;">'. $character['hours'] .'</p></div>'; ?>
                            </div>
                            <div class="row">
                                <div class="col-sm-8">PayDay</div>
                                <?php echo '<div class="col-sm-4"><p style="float: right; margin: 0px;">'. $character['paydaytime'] .'/<strong>60</strong></p></div>'; ?>
                            </div>
                            <br>
                            <div class="progress">
                                <?php echo '<div class="progress-bar bg-primary progress-bar-striped" role="progressbar" aria-valuenow="0" aria-valuemin="0" aria-valuemax="60" style="width: '. ($character['paydaytime']/60)*100 .'%;text-align: center;align-content: center;align-self: baseline;"></div>'; ?>
                            </div>
                        </div>
                    </div>

                    <div class="card">
                        <div class="card-header">
                            <i class="fas fa-shield-alt color-blue"></i><strong style="font-size: 18px;"> Security</strong>
                        </div>
                        <div class="card-body">
                            <div class="row">
                                <div class="col-sm-6">Last login</div>
                                <?php echo '<div class="col-sm-6"><p style="float: right; margin: 0px;">'. date('d/m/y, h:m', $character['last_login']) .'</p></div>'; ?>
                            </div>
                            <div class="row">
                                <div class="col-sm-6">Last IP address</div>
                                <?php echo '<div class="col-sm-6"><p style="float: right; margin: 0px;">'. $character['last_ip'] .'</p></div>'; ?>
                            </div>
                            <div class="row">
                                <div class="col-sm-7">Registration IP address</div>
                                <?php echo '<div class="col-sm-5"><p style="float: right; margin: 0px;">'. $character['create_ip'] .'</p></div>'; ?>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-sm-5">
                    <div class="card">
                        <div class="card-header">
                            <i class="fas fa-user color-blue"></i><strong style="font-size: 18px;"> IC Info</strong>
                        </div>
                        <div class="card-body">
                            <div class="row">
                                <div class="col-sm-5">Character`s name</div>
                                <?php echo '<div class="col-sm-7"><p style="float: right; margin: 0px;"><i class="fas fa-pencil-alt color-blue"></i> ' . substr_replace($character['name'], " ", strpos($character['name'], "_"), 1) . '</p></div>'; ?>
                            </div>    
                            <div class="row">
                                <div class="col-sm-5">Character gender</div>
                                <?php echo '<div class="col-sm-7"><p style="float: right; margin: 0px;"><i class="fas fa-pencil-alt color-blue"></i>';
                                    if($character['sex'] == 1) echo ' Male</p></div>'; 
                                    else if($character['sex'] == 2) echo ' Female</p></div>'; 
                                    else echo ' N/A</p></div>'; 
                                ?>
                            </div>
                            <div class="row">
                                <div class="col-sm-5">Date of Birth</div>
                                <?php echo '<div class="col-sm-7"><p style="float: right; margin: 0px;">'. $character['birthdate'] .'</p></div>'; ?>
                            </div>
                            <div class="row">
                                <div class="col-sm-5">Birthplace</div>
                                <?php echo '<div class="col-sm-7"><p style="float: right; margin: 0px;">'. $character['origin'] .'</p></div>'; ?>
                            </div>
                            <div class="row">
                                <div class="col-sm-5">Phone</div>
                                <?php echo '<div class="col-sm-7"><p style="float: right; margin: 0px;"><i class="fas fa-pencil-alt color-blue"></i> '. $character['number'] .'</p></div>'; ?>
                            </div>
                            <div class="row">
                                <div class="col-sm-5">Faction</div>
                                <div class="col-sm-7"><p style="float: right; margin: 0px;">
                                <?php 
                                    if($character['faction'] == 0) echo 'N/A</p></div>';
                                    else {
                                        $name_faction = R::getRow('SELECT `name` FROM factions WHERE id=?', [$character['faction']]);
                                        echo ''. $name_faction['name'] . '</p></div>';
                                    }
                                ?>
                            </div><br>
                            <div class="row">
                                <div class="col-sm-6">Cash</div>
                                <?php echo '<div class="col-sm-6"><p style="float: right; margin: 0px;">';
                                    if($character['cash'] > 0)  echo '<i class="fa fa-dollar-sign color-green"></i> '. $character['cash'] .'</p></div>';
                                    if($character['cash'] == 0) echo '<i class="fa fa-dollar-sign color-black"></i> '. $character['cash'] .'</p></div>'; 
                                    if($character['cash'] < 0)  echo '<i class="fa fa-dollar-sign color-red"></i> '. $character['cash'] .'</p></div>'; ?>
                            </div>
                            <div class="row">
                                <div class="col-sm-6">Bank Balance</div>
                                <?php echo '<div class="col-sm-6"><p style="float: right; margin: 0px;">';
                                    if($character['bank'] > 0)  echo '<i class="fa fa-dollar-sign color-green"></i> '. $character['bank'] .'</p></div>';
                                    if($character['bank'] == 0) echo '<i class="fa fa-dollar-sign color-black"></i> '. $character['bank'] .'</p></div>'; 
                                    if($character['bank'] < 0)  echo '<i class="fa fa-dollar-sign color-red"></i> '. $character['bank'] .'</p></div>'; ?>
                            </div>
                            <div class="row">
                                <div class="col-sm-6">Savings</div>
                                <?php echo '<div class="col-sm-6"><p style="float: right; margin: 0px;">';
                                    if($character['savings'] > 0)  echo '<i class="fa fa-dollar-sign color-green"></i> '. $character['savings'] .'</p></div>';
                                    if($character['savings'] == 0) echo '<i class="fa fa-dollar-sign color-black"></i> '. $character['savings'] .'</p></div>'; 
                                    if($character['savings'] < 0)  echo '<i class="fa fa-dollar-sign color-red"></i> '. $character['savings'] .'</p></div>'; ?>
                            </div>
                            <div class="row">
                                <div class="col-sm-6">Paycheck</div>
                                <?php echo '<div class="col-sm-6"><p style="float: right; margin: 0px;">';
                                    if($character['paycheck'] > 0)  echo '<i class="fa fa-dollar-sign color-green"></i> '. $character['paycheck'] .'</p></div>';
                                    if($character['paycheck'] == 0) echo '<i class="fa fa-dollar-sign color-black"></i> '. $character['paycheck'] .'</p></div>'; 
                                    if($character['paycheck'] < 0)  echo '<i class="fa fa-dollar-sign color-red"></i> '. $character['paycheck'] .'</p></div>'; ?>
                            </div><br>
                            <div class="row">
                                <div class="col-sm-4">Licenses</div>
                                <div class="col-sm-8"><p style="float: right; margin: 0px;">
                                    Taxi Driver:
                                    <?php   if($character['taxilic'] == 0)      echo '<spam style="font-weight: 600;color: #cc2828;">N/A</spam>,';
                                            else if($character['taxilic'] == 1) echo '<spam style="font-weight: 600;color: #009400;">YES</spam>,';
                                            else if($character['taxilic'] == 2) echo '<spam style="font-weight: 600;color: #000000;">BLACKLIST</spam>,';
                                            else                                echo '<spam style="font-weight: 600;color: #000000;">N/A</spam>,'; ?>
                                    Driving Licenses:
                                    <?php   if($character['carlic'] == 0)       echo '<spam style="font-weight: 600;color: #cc2828;">N/A</spam>,';
                                            else if($character['carlic'] == 1)  echo '<spam style="font-weight: 600;color: #009400;">YES</spam>
                                                                                    <spam style="font-weight: 600;color: #000000;">(' . $character['drivewarns'] . '/3),</spam>';
                                            else                                echo '<spam style="font-weight: 600;color: #000000;">N/A</spam>,'; ?>
                                    <br>Flight Licenses:
                                    <?php   if($character['flylic'] == 0)      echo '<spam style="font-weight: 600;color: #cc2828;">N/A</spam>,';
                                            else if($character['flylic'] == 1) echo '<spam style="font-weight: 600;color: #009400;">YES</spam>,';
                                            else if($character['flylic'] == 2) echo '<spam style="font-weight: 600;color: #000000;">BLACKLIST</spam>,';
                                            else                               echo '<spam style="font-weight: 600;color: #000000;">N/A</spam>,'; ?>
                                    Weapon:
                                    <?php   if($character['weplic'] == 0)       echo '<spam style="font-weight: 600;color: #cc2828;">N/A</spam>,';
                                            else if($character['weplic'] == 1)  echo '<spam style="font-weight: 600;color: #009400;">YES</spam> <spam style="font-weight: 600;color: #000000;">(' . $character['wepwarns'] . '/3),</spam>';
                                            else                                echo '<spam style="font-weight: 600;color: #000000;">N/A</spam>,'; ?>
                                </p></div>
                            </div><br>
                            <div class="row">
                                <div class="col-sm-6">Fight Style</div>
                                <?php echo '<div class="col-sm-6"><p style="float: right; margin: 0px;"><i class="fas fa-pencil-alt color-blue"></i> '. $fight_name[$character['fightstyle']] .'</p></div>'; ?>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>
<?php ucp_footer(); ?>
<script src="../assets/jquery.min.js"></script>
<script src="../assets/bootstrap.min.js"></script>
<script src="../assets/adminlte.min.js"></script>
<script src="../assets/demo.js"></script>
</body>
</html>