<?php
    include_once $_SERVER['DOCUMENT_ROOT'] . '/main.php';
    if (!isset($_SESSION['login'])) exit(redirect('../', 0));
    $characters = R::getAssocRow('SELECT id,`name`,status,skin FROM users WHERE accountid=? ORDER BY last_login ASC', [$_SESSION['id']]);

    ucp_head_character1();

    echo '<style>';

    for ($i = 0; $i < count($characters); $i++) {
        echo '.box-bg-' . $i . ' {
            background-image: url(../assets/list_skin/'. $characters[$i]['skin'] .'.png);
            background-color: #fff;
            background-repeat: no-repeat;
            background-position: 0px 0px;
            min-height: 200px;
            cursor: pointer;
            line-height: normal;
            box-shadow: 2px 2px 8px 0px rgba(0, 0, 0, 0.15);
            padding: 15px;
            box-sizing: border-box;
        }';
    }

    echo '</style>';

    ucp_head_character2(); 
    sidebar();
?>
<div class="content-wrapper">
    <section class="content">
        <div class="container">
            <div class="row">
                <div class="col-lg-7 col-6">
                    <h1>CHARACTERS:</h1><br>
                </div>
            </div>
            <div class="row">
            <?php
            for ($i = 0; $i < count($characters); $i++) {
                echo '
                    <div class="col-lg-4 col-6">
                        <a href="../profile/character.php?id=' . $characters[$i]['id'] . '" class="small-box box-bg-' . $i . '">
                            <div class="char_list_name">
                                <p>' . substr_replace($characters[$i]['name'], " ", strpos($characters[$i]['name'], "_"), 1) . '</p>';
                                if ($characters[$i]['status'] == 0)    echo '<h3 style="color:#FFA500">PENDING</h3>';
                                if ($characters[$i]['status'] == 1)    echo '<h3 style="color:#006400">APROVED</h3>';
                                if ($characters[$i]['status'] == 2)    echo '<h3 style="color:#dc1c20">DENIED</h3>';
                                if ($characters[$i]['status'] == 3)    echo '<h3 style="color:#000000">BLOCKED</h3>';
                                if ($characters[$i]['status'] == 4)    echo '<h3 style="color:#dc1c20">BANNED</h3>';
                echo'           <h3>CHARACTER ID: ' . $characters[$i]['id'] . '</h3>
                            </div>
                        </a>
                    </div>';
            }
            for ($o = 0; $o < 3 - count($characters); $o++) {
                echo '
                    <div class="col-lg-4 col-6">
                        <a href="../register/new_character.php" class="small-box bg-gray-active">
                            <div class="icon">
                                <i class="fa fa-user-plus"></i>
                            </div>
                        </a>
                    </div>';
            }
            ?>
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