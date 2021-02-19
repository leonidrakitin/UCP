<?php
include_once $_SERVER['DOCUMENT_ROOT'] . '/main.php';
if(isset($_SESSION['login'])) exit(redirect("../news/", 0));
ucp_header();
sidebar();
?>

<div class="content-wrapper">
    <section class="content">
        <?php 
            if(isset($_SESSION['recovery-status'])) {
                if ($_SESSION['recovery-status'] == 4) {
                    echo '<div class="alert alert-info alert-dismissible"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button><h5><i class="icon fas fa-info"></i> Your new password has been sent to a special mailing address!</h5></div>';
                    unset($_SESSION['recovery-status']);
                }
            }
            if(isset($_SESSION['auth_fail'])) {
                if ($_SESSION['auth_fail'] == 1) {
                    echo '<div class="alert alert-danger alert-dismissible"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button><h5><i class="icon fas fa-ban"></i> You entered an incorrect username or password!</h5></div>';
                    unset($_SESSION['auth_fail']);
                }
            }
        ?>
        <div class="login-box login-page">
            <div class="login-box-body">
                <p class="login-box-msg">Авторизация</p>
                <form action="../auth.php" method="post">
                    <div class="form-group has-feedback">
                        <input type="text" name="login" class="form-control" placeholder="username">
                        <span class="fa fa-user form-control-feedback"></span>
                    </div>
                    <div class="form-group has-feedback">
                        <input type="password" name="password" class="form-control" placeholder="password">
                        <span class="fa fa-lock form-control-feedback"></span>
                    </div>
                    <div class="row" style="margin-bottom: 30px;">
                        <div class="col-xs-8">
                            <div class="checkbox icheck">
                                <label>
                                    <input type="checkbox" name="nosaveme"> <span
                                            style="margin-left: 5px;">Remember me</span>
                                </label>
                            </div>
                        </div>
                        <div class="col-xs-4">
                            <button type="submit" class="btn btn-primary btn-block btn-flat">Log in</button>
                        </div>
                    </div>
                </form>
                <hr>
                <div class="social-auth-links text-center">
                    <p>Forgot your password?</p>
                </div>
                <p style="text-align: center;"><a href="../remember.php" style="background-color: #989898;padding: 5px 80px;color: #fff;border-radius: 4px;">Password retrieval</a></p>
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
<script src="../assets/adminlte.min.js"></script>
<script src="../assets/demo.js"></script>
</body>
</html>