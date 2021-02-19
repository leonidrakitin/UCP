<?php
include_once $_SERVER['DOCUMENT_ROOT'] . '/main.php';
if (isset($_SESSION['login'])) exit(redirect("../profile/list.php", 0));

if(!isset($_SESSION['second-mistakes'])) {
    if (isset($_SESSION['mistakes_time']))  if ($_SESSION['mistakes_time'] > 1) exit(redirect("../register/register.php", 0));

    $mistakes = 0;

    for ($i = 0; $i < 5; $i++) {
        if (!isset($_POST['answer_' . $i])) exit(redirect("../register/register.php", 0));
        $get_valid = R::getRow('SELECT right_answer FROM tests WHERE id =?', [$_POST['question_' . $i]]);
        if ($get_valid['right_answer'] != $_POST['answer_' . $i]) {
            $mistakes = $mistakes + 1;
        }
    }
    if ($mistakes > 0) {
        $_SESSION['mistakes'] = $mistakes;
        $_SESSION['mistakes_time'] = time() + (60 * 5);
        exit(redirect('../register/register.php', 0));
    }
}

ucp_header();
sidebar();
?>

<div class="content-wrapper">
    <div class="container">
        <section class="content-header">
            <h1>
                Registration<br>
                <small>Step 2. Account creation</small>
            </h1>
        </section>
        <section class="content">
            <?
            if(isset($_SESSION['second-mistakes'])) {
                if ($_SESSION['second-mistakes'] == 1) {
                    echo "<div class='alert alert-danger' role='alert'>User with this login is already registered.</div>";
                    unset($_SESSION['second-mistakes']);
                }
                else if ($_SESSION['second-mistakes'] == 2) {
                    echo "<div class='alert alert-danger' role='alert'>User with this email is already registered.</div>";
                    unset($_SESSION['second-mistakes']);
                }
                else if ($_SESSION['second-mistakes'] == 3) {
                    echo "<div class='alert alert-danger' role='alert'>Invalid characters in the login!</div>";
                    unset($_SESSION['second-mistakes']);
                }
                else if ($_SESSION['second-mistakes'] == 4) {
                    echo "<div class='alert alert-danger' role='alert'>Invalid characters in the password!</div>";
                    unset($_SESSION['second-mistakes']);
                }
            }
            ?>
            <form role="form" action="complete.php" method="post">
                <div class="box">
                    <div class="box-header with-border">
                        <h3 class="box-title">Username</h3>
                    </div>
                    <div class="box-body">
                        <div class="form-group has-feedback">
                            <input type="text" class="form-control" name="login" placeholder="Логин">
                            <span class="glyphicon glyphicon-user form-control-feedback"></span>
                        </div>
                    </div>
                </div>

                <div class="box">
                    <div class="box-header with-border">
                        <h3 class="box-title">Email</h3>
                    </div>
                    <div class="box-body">
                        <div class="form-group has-feedback">
                            <input type="mail" class="form-control" name="mail" placeholder="email@domain.com">
                            <span class="glyphicon glyphicon-envelope form-control-feedback"></span>
                        </div>
                    </div>
                </div>

                <div class="box">
                    <div class="box-header with-border">
                        <h3 class="box-title">Password</h3>
                    </div>
                    <div class="box-body">
                        <div class="form-group has-feedback">
                            <input type="password" class="form-control" name="password" placeholder="********">
                            <span class="glyphicon glyphicon-lock form-control-feedback"></span>
                        </div>
                    </div>
                </div>
                <div class="row docs-premium-template">
                    <div style="margin-right: 1%;margin-left: 1%;">
                        <input type='submit' class='btn btn-block btn-success' value='Continue'><br><br>
                    </div>
                </div>
            </form>
        </section>
    </div>
</div>
<?php ucp_footer(); ?>
<script src="../assets/jquery.min.js"></script>
<script src="../assets/bootstrap.min.js"></script>
<script src="../assets/icheck.min.js"></script>
</body>
</html>
