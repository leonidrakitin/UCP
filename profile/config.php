<?php
include_once $_SERVER['DOCUMENT_ROOT'] . '/main.php';

if (!isset($_SESSION['login'])) exit(redirect('../', 0));

$user = R::getRow('SELECT * FROM accounts WHERE id=?', [$_SESSION['id']]);
$characters = R::getAssocRow('SELECT * FROM users WHERE accountid=?', [$_SESSION['id']]);

ucp_header();
sidebar();
?>
<div class="content-wrapper">
    <section class="content-header">
        <?php
        if ($_SESSION['ban-result'] == 1) {
            unset($_SESSION['ban-result']);
            echo '<div class="callout callout-danger"><p>User is blocked!</p></div>';
        }
        ?>
    </section>
    <section class="invoice">
        <div class="row">
            <div class="col-xs-12">
                <h2 class="page-header">
                    Account - <b><?php echo $user['login']; ?></b>
                </h2>
            </div>
        </div>
        <div class="row">
            <div class="col-lg-4 col-md-6">
                <dl class="dl-horizontal">
                    <dt>ID</dt>
                    <dd><?php echo $user['id']; ?></dd>
                    <br>
                    <dt>Status</dt>
                    <dd><?php
                        $status = array();
                        if ($user['admin'] > 0) array_push($status, "<span class='text-primary'>Administrator (" . $user['admin'] . " lvl.)</span>");
                        if ($user['donate'] == 1) array_push($status, "<span style='color:#cd7f32;'>Bronze VIP</span>");
                        if ($user['donate'] == 2) array_push($status, "<span style='color:#969696;'>Silver VIP</span>");
                        if ($user['donate'] == 3) array_push($status, "<span style='color:#ffd700;'>Gold VIP</span>");
                        if ($user['donate'] == 4) array_push($status, "<span style='color:#ff0000;'>Platinum VIP</span>");
                        if (count($status) == 1) echo $status[0];
                        if (count($status) == 2) echo $status[0] . '<span class="text-primary">,</span> ' . $status[1];
                        if(empty($status)) echo 'Regular';
                        ?></dd>
                </dl>
            </div>
            <div class="col-lg-4 col-md-6">
                <dl class="dl-horizontal">
                    <dt>E-mail</dt>
                    <dd><?php echo $user['email']; ?></dd>
                    <br>
                    <dt>Last login</dt>
                    <dd><?php if (!empty($user['last_ucp_login'])) echo $user['last_ucp_login']; else echo 'None'; ?></dd>
                    <dd><?php if (!empty($user['last_ucp_ip'])) echo $user['last_ucp_ip']; ?></dd>
                </dl>
            </div>
            <div class="col-lg-4 col-md-6">
                <dl class="dl-horizontal">
                    <dt>Date of registration</dt>
                    <dd><?php echo $user['reg_date']; ?></dd>
                    <dd><?php echo $user['reg_ip']; ?></dd>
                    <br>
                    <dt>Donate coins</dt>
                    <dd><?php echo $user['donate']; ?></dd>
                </dl>
            </div>
        </div>
        <hr>
        <div class="row">
            <?php
            for ($i = 0; $i < count($characters); $i++) {
                if ($characters[$i]['status'] == 1) {
                    $link = R::getRow('SELECT id FROM users WHERE id=?', [$characters[$i]['id']]);
                    if($characters[$i]['online']) $status = '<spam style="color: green;background: white;margin: 5px;padding: 3px;border-radius: 5px;"> ONLINE</spam>';
                    else $status = '';
                    echo '
                            <div class="col-xs-6 col-md-4 col-lg-3">
                                <div class="small-box bg-green">
                                    <div class="icon">
                                        <i class="fa fa-user"></i>
                                    </div>
                                    <div class="inner">
                                        <p>' . $characters[$i]['name'] . '</p>
                                    </div>
                                    <a href="../admin/seen_request_info.php?id=' . $link['id'] . '" class="small-box-footer">Active <i class="fa fa-arrow-circle-right" style="margin-left: 5px; font-size: 14px; padding-top: 3px;"></i></a>
                                </div>
                            </div>';
                } else if ($characters[$i]['status'] == 0) {
                    $link = R::getRow('SELECT id FROM users WHERE id=?', [$characters[$i]['id']]);
                    echo '
                            <div class="col-xs-6 col-md-4 col-lg-3">
                                <div class="small-box bg-orange">
                                    <div class="icon">
                                        <i class="fa fa-user"></i>
                                    </div>
                                    <div class="inner">
                                        <p>' . $characters[$i]['name'] . '</p>
                                    </div>
                                    <a href="../admin/seen_request_info.php?id=' . $link['id'] . '" class="small-box-footer">Pending <i class="fa fa-arrow-circle-right" style="margin-left: 5px; font-size: 14px; padding-top: 3px;"></i></a>
                                </div>
                            </div>';
                } else if ($characters[$i]['status'] == 2) {
                    $link = R::getRow('SELECT id FROM users WHERE id=?', [$characters[$i]['id']]);
                    echo '
                            <div class="col-xs-6 col-md-4 col-lg-3">
                                <div class="small-box bg-red">
                                    <div class="icon">
                                        <i class="fa fa-user-times"></i>
                                    </div>
                                    <div class="inner">
                                        <p>' . $characters[$i]['name'] . '</p>
                                    </div>
                                    <a href="../admin/seen_request_info.php?id=' . $link['id'] . '" class="small-box-footer">Denied <i class="fa fa-arrow-circle-right" style="margin-left: 5px; font-size: 14px; padding-top: 3px;"></i></a>
                                </div>
                            </div>';
                } else if ($characters[$i]['status'] == 3) {
                    $link = R::getRow('SELECT id FROM users WHERE id=?', [$characters[$i]['id']]);
                    echo '
                            <div class="col-xs-6 col-md-4 col-lg-3">
                                <div class="small-box bg-red">
                                    <div class="icon">
                                        <i class="fa fa-user-times"></i>
                                    </div>
                                    <div class="inner">
                                        <p>' . $characters[$i]['name'] . '</p>
                                    </div>
                                    <a href="../admin/seen_request_info.php?id=' . $link['id'] . '" class="small-box-footer">Banned <i class="fa fa-arrow-circle-right" style="margin-left: 5px; font-size: 14px; padding-top: 3px;"></i></a>
                                </div>
                            </div>';
                }
            }
            ?>
        </div>
    </section>
</div>
<script src="../assets/jquery.min.js"></script>
<script src="../assets/bootstrap.min.js"></script>
<script src="../assets/adminlte.min.js"></script>
<script src="../assets/demo.js"></script>
</body>
</html>