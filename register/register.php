<?php
include_once $_SERVER['DOCUMENT_ROOT'] . '/main.php';
if (isset($_SESSION['login'])) exit(redirect("../news/index.php"));

ucp_header();
sidebar();

?>

<div class="content-wrapper">
    <div class="container">
        <div class="row">
            <div class="col-sm-2"></div>
            <div class="col-sm-8">
                <section class="content-header">
                    <h1>
                        Registration<br>
                        <small>Step 1. Testing. We recommend that you familiarize yourself with the project rules: <a href="https://forum.rc-rp.ru/viewtopic.php?p=73#p73"> /viewtopic.php?p=73#p73</a></small>
                    </h1>
                </section>
                <section class="content">
                    <?php
                    if(isset($_SESSION['mistakes_time']) || isset($_SESSION['mistakes'])) {

                        if (isset($mistake_time) && $mistake_time < 1) {
                            unset($_SESSION['mistakes_time']);
                            unset($_SESSION['mistakes']);
                            unset($mistake_time);
                            exit(redirect("../register/register.php", 0));
                        }
                        else if ($_SESSION['mistakes'] > 0) {
                            $mistake_time = (intval(date("i", $_SESSION['mistakes_time'])) + (date("G", $_SESSION['mistakes_time']) * 60)) - (intval(date("i", time())) + (date("G", time()) * 60));
                            echo "<div class='alert alert-danger' role='alert'>You answered correctly to <strong>" . (5 - $_SESSION['mistakes']) . " of 5 questions correctly</strong>. Try again in " . $mistake_time . " " . format_by_count($mistake_time, "minute", "minutes", "minute") . ".</div>";
                            if ($mistake_time < 1) {
                                unset($_SESSION['mistakes_time']);
                                unset($_SESSION['mistakes']);
                                unset($mistake_time);
                                exit(redirect("../register/register.php", 0));
                            }
                        }
                        else if ($_SESSION['mistakes'] == '-1') {
                            $mistake_time = (intval(date("i", $_SESSION['mistakes_time'])) + (date("G", $_SESSION['mistakes_time']) * 60)) - (intval(date("i", time())) + (date("G", time()) * 60));
                            echo "<div class='alert alert-danger' role='alert'>Don't try to be the smartest. Read the rules and try again through " . $mistake_time . " " . format_by_count($mistake_time, "minute", "minutes", "minute") . ".</div>";
                            if ($mistake_time < 1) {
                                unset($_SESSION['mistakes_time']);
                                unset($_SESSION['mistakes']);
                                unset($mistake_time);
                                exit(redirect("../register/register.php", 0));
                            }
                        }
                    }
                    ?>
                    <form role="form" action="../register/account.php" method="post">
                        <?php
                            $rows = R::getAssocRow('SELECT * FROM tests ORDER BY RAND() LIMIT 5');
                            for ($i = 0; $i < count($rows); $i++) {
                            echo '
                                <div class="box">
                                    <div class="box-header with-border">
                                        <h3 class="box-title">' . $rows[$i]['text'] . '</h3>
                                    </div>
                                    <div class="box-body">
                                        <ol>
                                            <li>' . $rows[$i]['ans_1'] . '</li>
                                            <li>' . $rows[$i]['ans_2'] . '</li>
                                            <li>' . $rows[$i]['ans_3'] . '</li>
                                            <li>' . $rows[$i]['ans_4'] . '</li>
                                        </ol>
                                    </div>
                                    <div class="box-footer">
                                        <input type="number" class="form-control" name="answer_' . $i . '" placeholder="Answer number" required>
                                        <input type="hidden" name="question_' . $i . '" value="' . $rows[$i]['id'] . '">
                                    </div>
                                </div>';
                            }
                          ?>
                        <div class="row docs-premium-template">
                            <div style="margin-right: 1%;margin-left: 1%;">
                                <input type='submit' class='btn btn-block btn-success' value='Next'><br><br>
                            </div>
                        </div>
                    </form>
                </section>
            </div>
        </div>
    </div>
</div>
<?php ucp_footer(); ?>
<script src="../assets/jquery.min.js"></script>
<script src="../assets/bootstrap.min.js"></script>
<script src="../assets/icheck.min.js"></script>
<script src="../assets/adminlte.min.js"></script>
<script src="../assets/demo.js"></script>
</body>
</html>
