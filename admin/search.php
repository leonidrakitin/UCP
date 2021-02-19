<?php
include_once $_SERVER['DOCUMENT_ROOT'] . '/main.php';
if (!isset($_SESSION['login'])) exit(redirect('../', 0));
if ($_SESSION['admin'] < 1) exit(redirect('../profile/list.php', 0));

if (isset($_POST['login']) && !empty($_POST['login'])) {
    $user=R::getRow('SELECT id FROM accounts WHERE login=?',[$_POST['login']]);
    if(!isset($user['id'])) $error=1;
    else exit(redirect('../admin/user.php?id='.$user['id'],0));
}

if (isset($_POST['name']) && !empty($_POST['name'])) {
    $character=R::getRow('SELECT name FROM users WHERE name=?',[$_POST['name']]);
    if(!isset($character['name'])) $error=2;
    else {
        $link=R::getRow('SELECT id FROM users WHERE name=?',[$character['name']]);
        exit(redirect('../admin/seen_request_info.php?id='.$link['id'],0));
    }
}
ucp_header();
sidebar();
?>
<div class="content-wrapper">
    <section class="content">
        <div class="row">
            <div class="col-xs-12 col-md-8 col-md-offset-2"">
                <div class="box box-primary">
                    <div class="box-header with-border">
                        <h3 class="box-title">Account search</h3>
                    </div>
                    <div class="box-body">
                        <?php
                        if($error==1) {
                            echo '
                            <div class="callout callout-danger">
                                <p>Account not found!</p>
                            </div>';
                            unset($error);
                        }
                        if($error==2) {
                            echo '
                            <div class="callout callout-danger">
                                <p>Character not found!</p>
                            </div>';
                            unset($error);
                        }
                        ?>
                        <div class="col-md-8 col-md-offset-1">
                            <form method="post" action="../admin/search.php">
                                <dl class="dl-horizontal">
                                    <dt>Account</dt>
                                    <dd>
                                        <div class="input-group input-group-sm">
                                            <input type="text" class="form-control" name="login"
                                                   placeholder="Username">
                                            <span class="input-group-btn">
                                            <button type="submit" class="btn btn-primary btn-flat">Look up <i
                                                        class="fa fa-search" style="padding-left: 5px;"></i></button>
                                        </span>
                                        </div>
                                    </dd>
                                    <br>
                                    <dt>Character</dt>
                                    <dd>
                                        <div class="input-group input-group-sm">
                                            <input type="text" class="form-control" name="name"
                                                   placeholder="Name_Surname">
                                            <span class="input-group-btn">
                                            <button type="submit" class="btn btn-primary btn-flat">Look up <i
                                                        class="fa fa-search" style="padding-left: 5px;"></i></button>
                                        </span>
                                        </div>
                                    </dd>
                                </dl>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>
<script src="../assets/jquery.min.js"></script>
<script src="../assets/bootstrap.min.js"></script>
<script src="../assets/adminlte.min.js"></script>
<script src="../assets/demo.js"></script>
<script src="../assets/jquery.dataTables.min.js"></script>
<script src="../assets/dataTables.bootstrap.min.js"></script>

</body>
</html>