<?php
include_once $_SERVER['DOCUMENT_ROOT'] . '/main.php';

$all = R::getAssocRow('SELECT name,accountid,faction FROM users WHERE online=1');

$admins = array();
$admins_accountnames = array();
$testers = array();
$testers_accountnames = array();
$players = array();
$laws = array();
$f_laws = array();

for ($i = 0; $i < count($all); $i++) {
    $checkadmin = R::getRow('SELECT login,helper,admin FROM accounts WHERE id=? AND (admin > 0 OR helper > 0) LIMIT 1', [$all[$i]['accountid']]);
    if($checkadmin['admin'] > 0 && $checkadmin != NULL) {
        $admins_accountnames[] = $checkadmin['login'];
        $admins[] = $all[$i]['name'];
    } else if($checkadmin['helper'] > 0 && $checkadmin != NULL) {
        $testers_accountnames[] = $checkadmin['login'];
        $testers[] = $all[$i]['name'];
    } 

    if($all[$i]['faction'] != 1 && $all[$i]['faction'] != 2 && $all[$i]['faction'] != 3 && $all[$i]['faction'] != 4)
    {
        if($checkadmin == NULL) 
        {
            $players[] = $all[$i]['name'];
        }
    } else {
        $laws[] = $all[$i]['name'];
        $f_laws[] = $all[$i]['faction'];
    }
}

ucp_header();
sidebar();
?>

<div class="content-wrapper">
<section class="content">
        <div class="container">
            <?php echo ' <h3>Players Online - <spam style="font-size: 30px;font-weight: 700;">'. count($all) .'<spam></spam></spam></h3><br>'; ?>
            <div class="row">
                <div class="col-sm-8">
                    <div class="row">
                        <div class="col-sm-6">
                            <div class="card" style="border-top: 3px solid #529400;">
                                <div class="card-header" style="font-weight: 600;font-size: 17.5px;">
                                    <i class="fa fa-fw fa-gavel color-green"></i> Administrators
                                    <?php echo '<spam style="float: right;font-size: 25px;font-weight: 600;color: #8c8b8b;">' . count($admins) . '</spam>'; ?>
                                </div>
                                <div class="card-body">
                                    <?php 
                                        for ($i = 0; $i < count($admins); $i++) {
                                            if($i == count($admins)-1) { 
                                                echo '<spam style="font-size: 14px;font-weight: 700;">'. $admins_accountnames[$i] .' </spam>
                                                <spam style="font-size: 14px;font-weight: 450;color: gray;">('. $admins[$i] .')</spam>';
                                            } else {
                                                echo '<spam style="font-size: 14px;font-weight: 700;">'. $admins_accountnames[$i] .' </spam>
                                                <spam style="font-size: 14px;font-weight: 450;color: gray;">('. $admins[$i] .')</spam>, ';
                                            }
                                        }
                                    ?>
                                </div>
                            </div>
                        </div>
                    <div class="col-sm-6">
                            <div class="card" style="border-top: 3px solid #a52a2a;">
                                <div class="card-header" style="font-weight: 600;font-size: 17.5px;">
                                    <i class="fas fa-info" style="color: brown;"></i> Testers
                                    <?php echo '<spam style="float: right;font-size: 25px;font-weight: 600;color: #8c8b8b;">' . count($testers) . '</spam>'; ?>
                                </div>
                                <div class="card-body">
                                    <?php 
                                        for ($i = 0; $i < count($testers); $i++) {
                                            if($i == count($testers)-1) { 
                                                echo '<spam style="font-size: 14px;font-weight: 700;">'. $testers_accountnames[$i] .' </spam>
                                                <spam style="font-size: 14px;font-weight: 450;color: gray;">('. $testers[$i] .')</spam>';
                                            } else {
                                                echo '<spam style="font-size: 14px;font-weight: 700;">'. $testers_accountnames[$i] .' </spam>
                                                <spam style="font-size: 14px;font-weight: 450;color: gray;">('. $testers[$i] .')</spam>, ';
                                            }
                                        }
                                    ?>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-sm-12">
                            <div class="card" style="border-top: 3px solid #000;">
                                <div class="card-header" style="font-weight: 600;font-size: 17.5px;">
                                    <i class="fas fa-users"></i> Regular Players
                                    <?php echo '<spam style="float: right;font-size: 25px;font-weight: 600;color: #8c8b8b;">' . count($players) . '</spam>'; ?>
                                </div>
                                <div class="card-body">
                                    <?php 
                                        for ($i = 0; $i < count($players); $i++) {
                                            if($i == count($players)-1) echo '<spam style="font-size: 14px;font-weight: 510;">'. $players[$i] .' </spam>';
                                            else echo '<spam style="font-size: 14px;font-weight: 510;">'. $players[$i] .'</spam>, ';
                                        }
                                    ?>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-sm-4">
                    <div class="card" style="border-top: 3px solid #3667b1;">
                        <div class="card-header" style="font-weight: 600;font-size: 17.5px;">
                            <i class="fa fa-fw fa-ambulance" style="color: #3667b1;"></i> Law Enforcement
                            <?php echo '<spam style="float: right;font-size: 25px;font-weight: 600;color: #8c8b8b;">' . count($laws) . '</spam>'; ?>
                        </div>
                        <div class="card-body">
                            <?php 
                                for ($i = 0; $i < count($laws); $i++) {
                                    if($f_laws[$i] == 1)        $color = '008000'; // SASD
                                    else if($f_laws[$i] == 2)   $color = 'ff6347'; // FD
                                    else if($f_laws[$i] == 3)   $color = 'fd4762'; // EMS
                                    else if($f_laws[$i] == 4)   $color = '9fa900'; // GOV
                                    
                                    if($i == count($laws)-1) echo '<spam style="font-size: 14px;font-weight: 510; color:#'.$color.'">'. $laws[$i] .'</spam>';
                                    else echo '<spam style="font-size: 14px;font-weight: 510; color:#'.$color.'">'. $laws[$i] .'</spam>, ';
                                }
                            ?>
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