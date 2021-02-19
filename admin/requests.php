<?php
include_once $_SERVER['DOCUMENT_ROOT'] . '/main.php';
if (!isset($_SESSION['login'])) exit(redirect('../', 0));
if ($_SESSION['admin'] < 1) exit(redirect('../profile/list.php', 0));
ucp_header();
sidebar();
?>
<div class="content-wrapper">
    <section class="content">
        <div class="row">
            <div class="col-xs-12 col-md-8 col-md-offset-2"">
                <div class="nav-tabs-custom">
                    <ul class="nav nav-tabs">
                        <li class="active"><a href="#tab_active" data-toggle="tab" aria-expanded="true">Active applications</a></li>
                        <li class=""><a href="#tab_declined" data-toggle="tab" aria-expanded="false">Declined applications</a></li>
                        <li class=""><a href="#tab_accepted" data-toggle="tab" aria-expanded="false">Aproved applications</a></li>
                    </ul>
                    <div class="tab-content">
                        <div class="tab-pane active" id="tab_active">
                            <div id="requests_wrapper" class="dataTables_wrapper form-inline dt-bootstrap">
                                <div class="row">
                                    <div class="col-sm-6"></div>
                                    <div class="col-sm-6"></div>
                                </div>
                                <div class="row">
                                    <div class="col-sm-12">
                                        <table id="active_requests" class="table table-bordered table-hover dataTable"
                                               role="grid" aria-describedby="active_requests">
                                            <thead>
                                            <tr role="row">
                                                <th style="width: 10px;">№</th>
                                                <th>Character</th>
                                                <th>Account</th>
                                                <th>Date</th>
                                                <th class="disabled-sorting" style="width:30px;">Action</th>
                                            </tr>
                                            </thead>
                                            <tbody>
                                            <?php
                                            $qu = R::getAssocRow('SELECT * FROM users WHERE status=0 ORDER BY id ASC');
                                            for ($i = 0; $i < count($qu); $i++) {
                                                $qur = R::getRow('SELECT login FROM accounts WHERE id=? LIMIT 1', [$qu[$i]['accountid']]);
                                                $checkkey = '
                                                        <td>
                                                            <a href="/admin/request_info.php?id=' . $qu[$i]['id'] . '"><div class="bg_buttons" align="center">Check</div></a>
                                                        </td>';
                                                echo '
                                                        <tr role="row">
                                                            <td>' . $qu[$i]['id'] . '</td>
                                                            <td>' . $qu[$i]['name'] . '</td>
                                                            <td>' . $qur['login'] . '</td>
                                                            <td>' . date('d/m/y, h:m', $qu[$i]['create_date']) . '</td>
                                                            ' . $checkkey . '
                                                        </tr>';
                                            }
                                            ?>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="tab-pane" id="tab_declined">
                            <div id="requests_wrapper" class="dataTables_wrapper form-inline dt-bootstrap">
                                <div class="row">
                                    <div class="col-sm-6"></div>
                                    <div class="col-sm-6"></div>
                                </div>
                                <div class="row">
                                    <div class="col-sm-12">
                                        <table id="declined_requests" class="table table-bordered table-hover dataTable"
                                               role="grid" aria-describedby="declined_requests">
                                            <thead>
                                            <tr role="row">
                                                <th style="width: 10px;">№</th>
                                                <th>Character</th>
                                                <th>Account</th>
                                                <th>Date</th>
                                                <th>Administrator</th>
                                                <th class="disabled-sorting" style="width:30px;">Action</th>
                                            </tr>
                                            </thead>
                                            <tbody>
                                            <?php
                                            $qu = R::getAssocRow('SELECT * FROM users WHERE status=2 ORDER BY id DESC');
                                            for ($i = 0; $i < count($qu); $i++) {
                                                $qur = R::getRow('SELECT login FROM accounts WHERE id=? LIMIT 1', [$qu[$i]['accountid']]);
                                                $checkkey = '
                                                        <td>
                                                            <a href="/admin/seen_request_info.php?id=' . $qu[$i]['id'] . '"><div class="bg_buttons" align="center">Check</div></a>
                                                        </td>';
                                                echo '
                                                        <tr role="row">
                                                            <td>' . $qu[$i]['id'] . '</td>
                                                            <td>' . $qu[$i]['name'] . '</td>
                                                            <td>' . $qur['login'] . '</td>
                                                            <td>' . date('d/m/y, h:m', $qu[$i]['create_date']) . '</td>
                                                            <td>' . $qu[$i]['admin_name'] . '</td>
                                                            ' . $checkkey . '
                                                        </tr>';
                                            }
                                            ?>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="tab-pane" id="tab_accepted">
                            <div id="requests_wrapper" class="dataTables_wrapper form-inline dt-bootstrap">
                                <div class="row">
                                    <div class="col-sm-6"></div>
                                    <div class="col-sm-6"></div>
                                </div>
                                <div class="row">
                                    <div class="col-sm-12">
                                        <table id="accepted_requests" class="table table-bordered table-hover dataTable"
                                               role="grid" aria-describedby="accepted_requests">
                                            <thead>
                                            <tr role="row">
                                                <th style="width: 10px;">№</th>
                                                <th>Character</th>
                                                <th>Account</th>
                                                <th>Date</th>
                                                <th>Administrator</th>
                                                <th class="disabled-sorting" style="width:30px;">Action</th>
                                            </tr>
                                            </thead>
                                            <tbody>
                                            <?php
                                            $qu = R::getAssocRow('SELECT * FROM users WHERE status=1 ORDER BY id DESC');
                                            for ($i = 0; $i < count($qu); $i++) {
                                                $qur = R::getRow('SELECT login FROM accounts WHERE id=? LIMIT 1', [$qu[$i]['accountid']]);
                                                $checkkey = '
                                                        <td>
                                                            <a href="/admin/seen_request_info.php?id=' . $qu[$i]['id'] . '"><div class="bg_buttons" align="center">Check</div></a>
                                                        </td>';
                                                echo '
                                                        <tr role="row">
                                                            <td>' . $qu[$i]['id'] . '</td>
                                                            <td>' . $qu[$i]['name'] . '</td>
                                                            <td>' . $qur['login'] . '</td>
                                                            <td>' . date('d/m/y, h:m', $qu[$i]['create_date']) . '</td>
                                                            <td>' . $qu[$i]['admin_name'] . '</td>
                                                            ' . $checkkey . '
                                                        </tr>';
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
        $('#active_requests').DataTable({
            "searching": false,
            language: {
                "processing": "Waiting...",
                "search": "Search:",
                "info": "Displayed from _START_ to _END_ of _TOTAL_ application",
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
                '</select> applications'
            }
        });
        var table = $('#active_requests').DataTable();
    });
    $(document).ready(function () {
        $('#declined_requests').DataTable({
            "searching": false,
            "order": [[0,"desc"]],
            language: {
                "processing": "Waiting...",
                "search": "Search:",
                "info": "Displayed from _START_ to _END_ of _TOTAL_ application",
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
                '</select> applications'
            }
        });
        var table = $('#declined_requests').DataTable();
    });
    $(document).ready(function () {
        $('#accepted_requests').DataTable({
            "searching": false,
            "order": [[0,"desc"]],
            language: {
                "processing": "Waiting...",
                "search": "Search:",
                "info": "Displayed from _START_ to _END_ of _TOTAL_ application",
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
                '</select> applications'
            }
        });
        var table = $('#accepted_requests').DataTable();
    });
</script>
</body>
</html>