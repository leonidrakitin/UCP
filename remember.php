<?php
include_once $_SERVER['DOCUMENT_ROOT'] . '/main.php';

if (isset($_SESSION['login'])) exit(redirect("/profile/list.php", 0));

if (isset($_POST['login']) && isset($_POST['email'])) {
    $check = R::getRow('SELECT id FROM accounts WHERE login=? AND email=?', [$_POST['login'], $_POST['email']]);
    if (!isset($check)) {
        $_SESSION['recovery-mistake'] = 1;
        exit(redirect("../remember.php", 0));
    } else {
        $_SESSION['recovery-mail'] = $_POST['email'];
        $code_mail = get_rand_alphanumeric(10);
        $code_hash_mail = hash("whirlpool", $code_mail);
        require $_SERVER['DOCUMENT_ROOT'] . '/assets/class.phpmailer.php';
        try {
            $mail = new PHPMailer(true);
            $body = "Password reset link: <a href='http://rc-rp.ru/remember.php?code=" . $code_hash_mail . "'>http://rc-rp.ru/remember.php?code=" . $code_hash_mail . "</a>, IP-address: " . $_SERVER['REMOTE_ADDR'] . "";
            $body = preg_replace('/\\\\/', '', $body);
            $mail->IsSMTP();
            $mail->SMTPAuth = true;
            $mail->Port = 587;
            $mail->Host = "rc-rp.ru";
            $mail->Username = "support@rc-rp.ru";
            $mail->Password = "iItTcvvxOg";
            $mail->IsSendmail();
            $mail->AddReplyTo("support@rc-rp.ru", "RC:RP - PASSWORD RESET");
            $mail->From = "support@rc-rp.ru";
            $mail->FromName = "Red County Roleplay";
            $to = $_POST['email'];
            $mail->AddAddress($to);
            $mail->Subject = "RC:RP - Password retrieval";
            $mail->WordWrap = 80;
            $mail->MsgHTML($body);
            $mail->IsHTML(true);
            $mail->Send();
        } catch (phpmailerException $e) {
            echo $e->errorMessage();
        }
        $path_mail = $_SERVER['DOCUMENT_ROOT'] . '/cache/pass/' . $_SERVER['REMOTE_ADDR'];
        $to_put = "Hash: " . $code_hash_mail . "; IP: " . $_SERVER['REMOTE_ADDR'];
        file_put_contents($path_mail, $to_put);
        $_SESSION['recovery-status'] = 1;
    }
}
if (isset($_GET['code'])) {
    $code_hash_mail = "Hash: " . $_GET['code'] . "; IP: " . $_SERVER['REMOTE_ADDR'];
    $path_mail = $_SERVER['DOCUMENT_ROOT'] . '/cache/pass/' . $_SERVER['REMOTE_ADDR'];
    if (!file_exists($path_mail)) $_SESSION['recovery-status'] = 2;
    if (filemtime($path_mail) + 60 * 15 - time() < 0) $_SESSION['recovery-status'] = 3;
    if (file_get_contents($path_mail) == $code_hash_mail) {
        unlink($path_mail);
        $password = get_rand_alphanumeric(7);
        $hash_password = hash("whirlpool", $password);
        R::exec('UPDATE accounts SET password=? WHERE mail=?', [$hash_password, $_SESSION['recovery-mail']]);
        require $_SERVER['DOCUMENT_ROOT'] . '/assets/class.phpmailer.php';
        try {
            $mail = new PHPMailer(true);
            $body = "Your new password: " . $password;
            $body = preg_replace('/\\\\/', '', $body);
            $mail->IsSMTP();
            $mail->SMTPAuth = true;
            $mail->Port = 465;
            $mail->Host = "rc-rp.ru";
            $mail->Username = "support@ls-project.ru";
            $mail->Password = "GambitGovno123321";
            $mail->IsSendmail();
            $mail->AddReplyTo("support@ls-project.ru", "RC:RP - support");
            $mail->From = "support@ls-project.ru";
            $mail->FromName = "LSP";
            $to = $_SESSION['recovery-mail'];
            $mail->AddAddress($to);
            $mail->Subject = "RC:RP - Password retrieval";
            $mail->WordWrap = 80;
            $mail->MsgHTML($body);
            $mail->IsHTML(true);
            $mail->Send();
        } catch (phpmailerException $e) {
            echo $e->errorMessage();
        }
        $_SESSION['recovery-status'] = 4;
        exit(redirect('../', 0));
    }
}

ucp_header();
sidebar();
?>

<div class="content-wrapper">
    <section class="content">
        <?php
            if ($_SESSION['recovery-mistake'] == 1) {
                echo '<div class="alert alert-danger alert-dismissible"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button><h5><i class="icon fas fa-ban"></i> You entered a non-existent username or email address!</h5></div>';
                unset($_SESSION['recovery-mistake']);
            } else if ($_SESSION['recovery-status'] == 1) {
                echo '<div class="alert alert-info alert-dismissible"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button><h5><i class="icon fas fa-info"></i> Instructions for restoring access to your account have been sent to the specified mailing address!</h5></div>';
                unset($_SESSION['recovery-status']);
            } else if ($_SESSION['recovery-status'] == 2) {
                echo '<div class="alert alert-danger alert-dismissible"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button><h5><i class="icon fas fa-ban"></i> The code was not sent!</h5></div>';
                unset($_SESSION['recovery-status']);
            } else if ($_SESSION['recovery-status'] == 3) {
                echo '<div class="alert alert-danger alert-dismissible"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button><h5><i class="icon fas fa-ban"></i> The code has expired!</h5></div>';
                unset($_SESSION['recovery-status']);
            } else if ($_SESSION['recovery-status'] == 4) {
                echo '<div class="alert alert-success alert-dismissible"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button><h5><i class="icon fas fa-check"></i> Your new password has been sent to the specified mailing address!</h5></div>';
                unset($_SESSION['recovery-status']);
            }
        ?>
        <div class="login-box login-page">
            <div class="remember-box-body">
                <p class="login-box-msg">Password retrieval</p>
                <form action="remember.php" method="post">
                    <div class="form-group has-feedback">
                        <input type="text" name="login" class="form-control" placeholder="username">
                        <span class="fa fa-user form-control-feedback"></span>
                    </div>
                    <div class="form-group has-feedback">
                        <input type="email" name="email" class="form-control" placeholder="email">
                        <span class="fa fa-at form-control-feedback"></span>
                    </div>
                    <div class="row" style="margin-bottom: 30px;">
                        <div class="col-xs-12">
                            <button type="submit" class="btn btn-block btn-flat" style="background-color: #dd4b39;color: #fff;">Reset</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </section>
</div>
<?php ucp_footer(); ?>
<script src="./assets/jquery.min.js"></script>
<script src="./assets/bootstrap.min.js"></script>
<script src="./assets/icheck.min.js"></script>
<script>
    $(function () {
        $('input').iCheck({
            checkboxClass: 'icheckbox_square-blue',
            radioClass: 'iradio_square-blue',
            increaseArea: '20%'
        });
    });
</script>
</body>
</html>
