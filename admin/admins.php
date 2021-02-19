<?php
include_once $_SERVER['DOCUMENT_ROOT'] . '/main.php';
if (!isset($_SESSION['login'])) exit(redirect('../', 0));

if ($_SESSION['admin'] < 4) exit(redirect('../news/', 0));
if(isset($_POST['login'])) {
    if($_SESSION['admin']<4) $error=1;
    else {
        $check=R::getRow('SELECT admin FROM accounts WHERE login=?',[$_POST['login']]);
        if(isset($check['admin'])) {
            if($check['admin']>0) $error=3;
            else {
                R::exec('UPDATE accounts SET admin="1" WHERE login=?',[$_POST['login']]);
                exit(redirect('../admin/admins.php',0));
            }
        } else $error=2;
    }
}
if (isset($_POST['level']) && isset($_GET['id'])) {
    if($_SESSION['admin']<4) $error=1;
    else {
        R::exec('UPDATE accounts SET admin=? WHERE id=?',[$_POST['level'],$_GET['id']]);
        $_SESSION['success']=1;
        exit(redirect('../admin/admins.php',0));
    }
}

ucp_header();
sidebar();
?>
<div class="content-wrapper">
    <section class="content">
        <div class="row">
            <div class="col-xs-12 col-md-8 col-md-offset-2">
                <div class="box box-solid">
                    <div class="box-header with-border">
                        <h3 class="box-title">Administration</h3>
                    </div>
                    <div class="box-body">
                        <?php
                        if($error==1) {
                            echo '
                            <div class="callout callout-danger">
                                <p>Not enough rights!</p>
                            </div>';
                            unset($error);
                        }
                        if($_SESSION['success']==1) {
                            echo '
                            <div class="callout callout-success">
                                <p>Level updated successfully!</p>
                            </div>';
                            unset($_SESSION['success']);
                        }
                        if($error==2) {
                            echo '
                            <div class="callout callout-danger">
                                <p>Account not found!</p>
                            </div>';
                            unset($error);
                        }
                        if($error==3) {
                            echo '
                            <div class="callout callout-danger">
                                <p>The account is already an administrator!</p>
                            </div>';
                            unset($error);
                        }
                        ?>
                        <div id="requests_wrapper" class="dataTables_wrapper form-inline dt-bootstrap">
                            <div class="row">
                                <div class="col-xs-12">
                                    <table id="admins" class="table table-bordered table-hover dataTable" role="grid" aria-describedby="active_requests">
                                        <?php
                                        if($_SESSION['admin']>3) echo '<div class="input-group input-group-sm pull-right">
                                            <form method="post" action="../admin/admins.php">
                                                <input type="text" class="form-control" name="login" placeholder="Username">
                                                <span class="input-group-btn">
                                                    <button type="submit" class="btn btn-success btn-flat">Add <i class="fa fa-user-plus" style="padding-left: 5px;"></i></button>
                                                </span>
                                            </form>
                                        </div><br><hr>';
                                        ?>
                                        <thead>
                                            <tr role="row">
                                                <th style="width: 10px">level</th>
                                                <th>Account</th>
                                                <th class="disabled-sorting" style="width: 10px;">Action</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                        <?php
                                        $qu = R::getAssocRow('SELECT id,login,admin FROM accounts WHERE admin>0 ORDER BY id ASC');
                                        for ($i = 0; $i < count($qu); $i++) {
                                            echo '<tr role="row"><td>' . $qu[$i]['admin'] . '</td><td>' . $qu[$i]['login'] . '</td>';
                                            echo '<td><form method="post" action="../admin/admins.php?id='.$qu[$i]['id'].'"><div class="input-group input-group-sm pull-right">';
                                            if($_SESSION['admin']<4) echo '<input type="number" class="form-control" name="level" value="'.$qu[$i]['admin'].'" style="width:50px;" disabled>';
                                            else echo '<input type="number" class="form-control" name="level" value="'.$qu[$i]['admin'].'" style="width:50px;">';
                                            echo '<span class="input-group-btn">';
                                            if($_SESSION['admin']<4) echo '<button type="submit" class="btn btn-primary btn-flat" disabled>Update level</button>';
                                            else echo '<button type="submit" class="btn btn-primary btn-flat">Update level</button>';
                                            echo '</span></div></form></td></tr>';
                                        }
                                        ?>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>
</div>
<script src="../assets/jquery.min.js"></script>
<script src="../assets/bootstrap.min.js"></script>
<script src="../assets/adminlte.min.js"></script>
<script src="../assets/demo.js"></script>
<script src="../assets/jquery.dataTables.min.js"></script>
<script src="../assets/dataTables.bootstrap.min.js"></script>
<script type="text/javascript">
    $(document).ready(function () {
        $('#admins').DataTable({
            "searching": false,
            "order": [[0,"desc"]],
            language: {
                "processing": "Waiting...",
                "search": "Search:",
                "info": "",
                "infoEmpty": "",
                "infoFiltered": "(filtered out of _MAX_ applications)",
                "infoPostFix": "",
                "loadingRecords": "Loading records...",
                "zeroRecords": "There are no entries",
                "emptyTable": "There are no applications",
                "paginate": {
                    "first": "First",
                    "previous": "Previous",
                    "next": "Next",
                    "last": "Last"
                },
                "aria": {
                    "sortAscending": ": activate to sort the column in ascending order",
                    "sortDescending": ": activate to sort the column in descending order"
                },
                "lengthMenu": 'Show <select>' +
                '<option value="10">10</option>' +
                '<option value="20">20</option>' +
                '<option value="30">30</option>' +
                '<option value="40">40</option>' +
                '<option value="50">50</option>' +
                '</select> accounts'
            }
        });
        var table = $('#admins').DataTable();
    });
</script>
</body>
</html>