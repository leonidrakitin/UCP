<?php
include_once $_SERVER['DOCUMENT_ROOT'] . '/main.php';
if (!isset($_SESSION['login'])) exit(redirect('../profile/list.php', 0));

$check_characters = R::getAssocRow('SELECT status FROM users WHERE accountid=?', [$_SESSION['id']]);

$count_characters = 0;
$usable_characters = 0;

for ($i = 0; $i < count($check_characters); $i++) {
    $usable_characters++;
    if ($check_characters[$i]['status'] == 0) $count_characters++;
}
if ($count_characters) {
    echo "You already have a character under consideration. Please wait until it is verified.";
    exit(redirect('../profile/list.php', 3));
}

if ($usable_characters > 2)         exit(redirect('../profile/list.php', 0));
if (isset($_SESSION['new_skin']))   $continue = 1;
else                                $continue = 0;
if ($usable_characters == 0) $firstcharacter = 1;
else                         $firstcharacter = 0;

ucp_header();
sidebar();
?>

<div class="content-wrapper">
    <div class="container">
        <section class="content-header">
            <?php
            if(isset($_SESSION['new_mistake'])) {
                if ($_SESSION['new_mistake'] == 1) {
                    echo "<div class='alert alert-danger' role='alert'>A character with the specified name already exists!</div>";
                    unset($_SESSION['new_mistake']);
                }
                if ($_SESSION['new_mistake'] == 2) {
                    echo "<div class='alert alert-danger' role='alert'>Invalid characters in name!</div>";
                    unset($_SESSION['new_mistake']);
                }
                if ($_SESSION['new_mistake'] == 3) {
                    echo "<div class='alert alert-danger' role='alert'>Invalid character skin!</div>";
                    unset($_SESSION['new_mistake']);
                }
                if ($_SESSION['new_mistake'] == 4) {
                    echo "<div class='alert alert-danger' role='alert'>Invalid character date of birthday!</div>";
                    unset($_SESSION['new_mistake']);
                }
            }
            ?>
            <div class="callout callout-warning">
                <h5>Before you start, please read this message!</h5>
                <p>Before plaing on our project, you need to create a character in UCP. The administration of the project asks to treat this responsibly and collected. Familiarize yourself with the game rules, carefully read and give answers to the test part, as well as think over your character, his character, habits and features. Don't forget that each character is a person who has both positive (strengths) and negative (weaknesses). Please take this into account when creating it.</p>
            </div>
            <br>
            <h1>
                Registration<br>
                <?php
                if ($firstcharacter == 1) echo '<small>Step 3. Account creation</small>';
                else echo '<small>Additional step. Creation of the second and subsequent characters</small>';
                ?>
            </h1>
        </section>
        <section class="content">
            <form role="form" action="../register/new_character_complete.php" method="post">
                <div class="box">
                    <div class="box-header with-border">
                        <h3 class="box-title">Character`s name</h3>
                    </div>
                    <div class="box-body">
                        <div class="form-group">
                            <input type="text" class="form-control" name="name" placeholder="Name">
                        </div>
                    </div>
                </div>
                <div class="box">
                    <div class="box-header with-border">
                        <h3 class="box-title">Character`s surname</h3>
                    </div>
                    <div class="box-body">
                        <div class="form-group">
                            <input type="text" class="form-control" name="surname" placeholder="Surname">
                        </div>
                    </div>
                </div>
                <div class="box">
                    <div class="box-header with-border">
                        <h3 class="box-title">Character`s sex</h3>
                    </div>
                    <div class="box-body">
                        <div class="form-group">
                            <select class="form-control" name="gender">
                                <option value="1">Male</option>
                                <option value="2">Female</option>
                            </select>
                        </div>
                    </div>
                </div>
                <div class="box">
                    <div class="box-header with-border">
                        <h3 class="box-title">Birthplace</h3>
                    </div>
                    <div class="box-body">
                        <div class="form-group">
                            <input type="text" class="form-control" name="origin" placeholder="USA, SA, Palomino Creek">
                        </div>
                    </div>
                </div>
                <div class="box">
                    <div class="box-header with-border">
                        <h3 class="box-title">Date of Birth</h3>
                    </div>
                    <div class="box-body">
                        <div class="form-group">
                            <input type="text" class="form-control" name="birth" data-inputmask="'alias': 'dd/mm/yyyy'"
                                data-mask="" placeholder="dd/mm/yyyy">
                        </div>
                    </div>
                </div>
                <div class="box">
                    <div class="box-header with-border">
                        <h3 class="box-title">Character's skin</h3>
                        <h1 style="
                            font-size: 13.3px;
                            margin: 0px;
                        ">You can choose a skin <a href="https://wiki.sa-mp.com/wiki/Skins:All" target="_blank" style="
                            background-color: #ff833c;
                            color: #fff;
                            padding: 1px 7px;
                            border-radius: 10px;
                        ">here</a>.</h1>
                    </div>
                    <div class="box-body">
                        <div class="form-group">
                            <?php if ($continue == 1) {
                                echo '<input type="number" class="form-control" name="skin" value="' . $_SESSION['new_skin'] . '">';
                                unset($_SESSION['new_skin']);
                            } else echo '<input type="number" class="form-control" name="skin" placeholder="Skin">'; ?>
                        </div>
                    </div>
                </div>
                <?php
                if ($firstcharacter == 1) {
                    echo '
                    <div class="box">
                        <div class="box-header with-border">
                            <h3 class="box-title">How long have you been playing role-playing projects and what kind of projects were they?</h3>
                        </div>
                        <div class="box-body">
                            <div class="form-group">';
                    if ($continue == 1) {
                        echo '<input type="text" class="form-control" name="projects" value="' . $_SESSION['new_projects'] . '">';
                        unset($_SESSION['first_projects']);
                    } else echo '<textarea class="form-control" rows="3" name="projects"></textarea>';
                    echo '  </div>
                        </div>
                    </div>
                    <div class="box">
                        <div class="box-header with-border">
                            <h3 class="box-title">Give a detailed definition of the terms and give two examples: PowerGaming, MetaGaming, In Character.</h3>
                        </div>
                        <div class="box-body">
                            <div class="form-group">';
                    if ($continue == 1) {
                        echo '<input type="text" class="form-control" name="terms" value="' . $_SESSION['new_terms'] . '">';
                        unset($_SESSION['first_projects']);
                    } else echo '<textarea class="form-control" rows="3" name="terms"></textarea>';
                    echo '  </div>
                        </div>
                    </div>';
                }
                ?>
                <div class="box">
                    <div class="box-header with-border">
                        <h3 class="box-title">Full name, nature, character history, description of specific features, both external and internal. </h3>
                    </div>
                    <div class="box-body">
                        <div class="form-group">
                            <?php if ($continue == 1) {
                                echo '<input type="text" class="form-control" name="character" value="' . $_SESSION['new_character'] . '">';
                                unset($_SESSION['new_character']);
                            } else echo '<textarea class="form-control" rows="3" name="character"></textarea>'; ?>
                        </div>
                    </div>
                </div>
                <div class="row docs-premium-template">
                    <div style="margin-right: 1%;margin-left: 1%;">
                        <input type='submit' class='btn btn-block btn-success' value='Сontinue'><br><br>
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
<script src="../assets/select2.full.min.js"></script>
<script src="../assets/jquery.inputmask.js"></script>
<script src="../assets/jquery.inputmask.date.extensions.js"></script>
<script src="../assets/jquery.inputmask.extensions.js"></script>
<script src="../assets/adminlte.min.js"></script>
<script src="../assets/demo.js"></script>
<script>
    $(function () {
        $('.select2').select2()
        $('#datemask').inputmask('dd/mm/yyyy', {'placeholder': 'dd/mm/yyyy'})
        $('#datemask2').inputmask('mm/dd/yyyy', {'placeholder': 'mm/dd/yyyy'})
        $('[data-mask]').inputmask()
        $('#reservation').daterangepicker()
        $('#reservationtime').daterangepicker({timePicker: true, timePickerIncrement: 30, format: 'MM/DD/YYYY h:mm A'})
        $('#daterange-btn').daterangepicker(
            {
                ranges: {
                    'Today': [moment(), moment()],
                    'Yesterday': [moment().subtract(1, 'days'), moment().subtract(1, 'days')],
                    'Last 7 Days': [moment().subtract(6, 'days'), moment()],
                    'Last 30 Days': [moment().subtract(29, 'days'), moment()],
                    'This Month': [moment().startOf('month'), moment().endOf('month')],
                    'Last Month': [moment().subtract(1, 'month').startOf('month'), moment().subtract(1, 'month').endOf('month')]
                },
                startDate: moment().subtract(29, 'days'),
                endDate: moment()
            },
            function (start, end) {
                $('#daterange-btn span').html(start.format('MMMM D, YYYY') + ' - ' + end.format('MMMM D, YYYY'))
            }
        )
    })
</script>
</body>
</html>
