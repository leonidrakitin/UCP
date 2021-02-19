<?php
include_once $_SERVER['DOCUMENT_ROOT'] . '/main.php';
if (!isset($_SESSION['login'])) exit(redirect('../', 0));

ucp_header();
sidebar();
?>
<div class="content-wrapper">
    <section class="content">
        <div class="row">
            <div class="col-xs-12 col-md-8 col-md-offset-2"">
                <div class="nav-tabs-custom">
                    <ul class="nav nav-tabs">
                        <li class="active"><a href="#ban" data-toggle="tab" aria-expanded="true">Bans log</a></li>
                        <li class=""><a href="#kick" data-toggle="tab" aria-expanded="false">Kicks log</a></li>
                        <li class=""><a href="#ajail" data-toggle="tab" aria-expanded="false">Ajail log</a></li>
                        <li class=""><a href="#warn" data-toggle="tab" aria-expanded="false">Warns log</a></li>
                    </ul>
                    <div class="tab-content">
                        <div class="tab-pane active" id="ban">
                            <div id="requests_wrapper" class="dataTables_wrapper form-inline dt-bootstrap">
                                <div class="row">
                                    <div class="col-sm-6"></div>
                                    <div class="col-sm-6"></div>
                                </div>
                                <div class="row">
                                    <div class="col-sm-12">
                                        <table id="bans" class="table table-bordered table-hover dataTable"
                                               role="grid" aria-describedby="bans">
                                            <thead>
                                            <tr role="row">
                                                <th style="width: 10px;">№</th>
                                                <th>Log</th>
                                                <th>Date</th>
                                            </tr>
                                            </thead>
                                            <tbody>
                                            <?php
                                            $qu = R::getAssocRow('SELECT * FROM logs WHERE userid=? AND type=3 AND subtype=1 ORDER BY id DESC', [$_SESSION['id']]);
                                            for ($i = 0; $i < count($qu); $i++) {
                                                echo '
                                                        <tr role="row">
                                                            <td>' . $qu[$i]['id'] . '</td>
                                                            <td>' . $qu[$i]['text'] . '</td>
                                                            <td>' . $qu[$i]['data'] . '</td>
                                                        </tr>';
                                            }
                                            ?>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="tab-pane" id="kick">
                            <div id="requests_wrapper" class="dataTables_wrapper form-inline dt-bootstrap">
                                <div class="row">
                                    <div class="col-sm-6"></div>
                                    <div class="col-sm-6"></div>
                                </div>
                                <div class="row">
                                    <div class="col-sm-12">
                                        <table id="kicks" class="table table-bordered table-hover dataTable"
                                               role="grid" aria-describedby="kicks">
                                            <thead>
                                            <tr role="row">
                                                <th style="width: 10px;">№</th>
                                                <th>Log</th>
                                                <th>Date</th>
                                            </tr>
                                            </thead>
                                            <tbody>
                                            <?php
                                            $qu = R::getAssocRow('SELECT * FROM logs WHERE userid=? AND type=3 AND subtype=2 ORDER BY id DESC', [$_SESSION['id']]);
                                            for ($i = 0; $i < count($qu); $i++) {
                                                echo '
                                                        <tr role="row">
                                                            <td>' . $qu[$i]['id'] . '</td>
                                                            <td>' . $qu[$i]['text'] . '</td>
                                                            <td>' . $qu[$i]['data'] . '</td>
                                                        </tr>';
                                            }
                                            ?>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="tab-pane" id="ajail">
                            <div id="requests_wrapper" class="dataTables_wrapper form-inline dt-bootstrap">
                                <div class="row">
                                    <div class="col-sm-6"></div>
                                    <div class="col-sm-6"></div>
                                </div>
                                <div class="row">
                                    <div class="col-sm-12">
                                        <table id="ajails" class="table table-bordered table-hover dataTable"
                                               role="grid" aria-describedby="ajails">
                                            <thead>
                                            <tr role="row">
                                                <th style="width: 10px;">№</th>
                                                <th>Log</th>
                                                <th>Date</th>
                                            </tr>
                                            </thead>
                                            <tbody>
                                            <?php
                                            $qu = R::getAssocRow('SELECT * FROM logs WHERE userid=? AND type=3 AND subtype=5 ORDER BY id DESC', [$_SESSION['id']]);
                                            for ($i = 0; $i < count($qu); $i++) {
                                                echo '
                                                        <tr role="row">
                                                            <td>' . $qu[$i]['id'] . '</td>
                                                            <td>' . $qu[$i]['text'] . '</td>
                                                            <td>' . $qu[$i]['data'] . '</td>
                                                        </tr>';
                                            }
                                            ?>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="tab-pane" id="warn">
                            <div id="requests_wrapper" class="dataTables_wrapper form-inline dt-bootstrap">
                                <div class="row">
                                    <div class="col-sm-6"></div>
                                    <div class="col-sm-6"></div>
                                </div>
                                <div class="row">
                                    <div class="col-sm-12">
                                        <table id="warns" class="table table-bordered table-hover dataTable"
                                               role="grid" aria-describedby="warns">
                                            <thead>
                                            <tr role="row">
                                                <th style="width: 10px;">№</th>
                                                <th>Log</th>
                                                <th>Date</th>
                                            </tr>
                                            </thead>
                                            <tbody>
                                            <?php
                                            $qu = R::getAssocRow('SELECT * FROM logs WHERE userid=? AND type=3 AND subtype=5 ORDER BY id DESC', [$_SESSION['id']]);
                                            for ($i = 0; $i < count($qu); $i++) {
                                                echo '
                                                        <tr role="row">
                                                            <td>' . $qu[$i]['id'] . '</td>
                                                            <td>' . $qu[$i]['text'] . '</td>
                                                            <td>' . $qu[$i]['data'] . '</td>
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
<?php ucp_footer(); ?>
<script src="../assets/jquery.min.js"></script>
<script src="../assets/bootstrap.min.js"></script>
<script src="../assets/adminlte.min.js"></script>
<script src="../assets/demo.js"></script>
<script src="../assets/jquery.dataTables.min.js"></script>
<script src="../assets/dataTables.bootstrap.min.js"></script>
<script type="text/javascript">
    $(document).ready(function () {
        $('#bans').DataTable({
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
                "emptyTable": "There are no entries",
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
        var table = $('#bans').DataTable();
    });
    $(document).ready(function () {
        $('#kicks').DataTable({
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
                "emptyTable": "There are no entries",
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
        var table = $('#kicks').DataTable();
    });
    $(document).ready(function () {
        $('#ajails').DataTable({
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
                "emptyTable": "There are no entries",
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
        var table = $('#ajails').DataTable();
    });
    $(document).ready(function () {
        $('#warns').DataTable({
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
                "emptyTable": "There are no entries",
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
        var table = $('#warns').DataTable();
    });
</script>
</body>
</html>