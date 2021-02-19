<?php
include_once $_SERVER['DOCUMENT_ROOT'] . '/main.php';
if (!isset($_SESSION['login'])) exit(redirect('../', 0));
if ($_SESSION['admin'] < 4) exit(redirect('../profile/list.php', 0));
if(isset($_POST['name'])) {
    $check=R::getRow('SELECT id,cked FROM users WHERE name=?',[$_POST['name']]);
    if($_GET['action']=='status') {
        if(isset($check['id'])) {
            if($check['cked']==0) $message='active';
            if($check['cked']>0) $message='has killed';
            if($check['cked']<0) $message='not active';
        }
        else $message='isnt issets';
    }
    if($_GET['action']=='kill') {
        if(isset($check['id'])) {
            if ($check['cked']>0) $message='already killed';
            if($check['cked']==0) {
                R::exec('UPDATE characters SET cked=1 WHERE name=?', [$_POST['name']]);
                $message = 'killed';
            }
            if($check['cked']<0) $message='not active';
        }
        else $message='isnt issets';
    }
    if($_GET['action']=='revive') {
        if(isset($check['id'])) {
            if($check['cked']>0){
                R::exec('UPDATE characters SET cked=0 WHERE name=?',[$_POST['name']]);
                $message='revived';
            }
            if($check['cked']==0) $message='hasnt killed';
            if($check['cked']<0) $message='not active';
        }
        else $message='isnt issets';
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
                        <h3 class="box-title">Manage Character Kill</h3>
                    </div>
                    <div class="box-body">
                        <?php
                        if($message=='active') {
                            echo '
                            <div class="callout callout-info">
                                <p>Character active!</p>
                            </div>';
                            unset($message);
                        }
                        if($message=='has killed') {
                            echo '
                            <div class="callout callout-info">
                                <p>Character is dead!</p>
                            </div>';
                            unset($message);
                        }
                        if($message=='not active') {
                            echo '
                            <div class="callout callout-info">
                                <p>Character not active!</p>
                            </div>';
                            unset($message);
                        }
                        if($message=='isnt issets') {
                            echo '
                            <div class="callout callout-danger">
                                <p>Character not found!</p>
                            </div>';
                            unset($message);
                        }
                        if($message=='already killed') {
                            echo '
                            <div class="callout callout-danger">
                                <p>Character already killed!</p>
                            </div>';
                            unset($message);
                        }
                        if($message=='killed') {
                            echo '
                            <div class="callout callout-success">
                                <p>Character successfully killed!</p>
                            </div>';
                            unset($message);
                        }
                        if($message=='revived') {
                            echo '
                            <div class="callout callout-success">
                                <p>Character successfully revived!</p>
                            </div>';
                            unset($message);
                        }
                        if($message=='hasnt killed') {
                            echo '
                            <div class="callout callout-danger">
                                <p>Character hasnt killed!</p>
                            </div>';
                            unset($message);
                        }
                        ?>
                        <br>
                        <div class="col-md-8 col-md-offset-1">
                            <form method="post" action="../admin/ck.php">
                                <dl class="dl-horizontal">
                                    <dt>Character</dt>
                                    <dd>
                                        <div class="input-group input-group-sm">
                                            <input type="text" class="form-control" name="name" placeholder="Name_Surname">
                                            <span class="input-group-btn">
                                                <button type="submit" class="btn btn-primary btn-flat" formaction="../admin/ck.php?action=status">Status <i class="fa fa-question-circle" style="padding-left: 5px;"></i></button>
                                                <button type="submit" class="btn btn-danger btn-flat" formaction="../admin/ck.php?action=kill">Issue CK <i class="fa fa-user-times" style="padding-left: 5px;"></i></button>
                                                <button type="submit" class="btn btn-success btn-flat" formaction="../admin/ck.php?action=revive">Remove CK <i class="fa fa-user-plus" style="padding-left: 5px;"></i></button>
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