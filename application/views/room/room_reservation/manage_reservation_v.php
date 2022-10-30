<style type="text/css">
    th, td { white-space: nowrap; }
    div.dataTables_wrapper {
        margin: 0 auto;
    }
    #table-luar{
        font-size: 11px;
    }
    #filter { 
        border-spacing: 10px;
        border-collapse: separate;
    }
    .td-fixed{
        width: 30px;
    }
    .td-no{
        text-align: center;
    }
    .ddl{
        width: 100px;
        height: 30px;
    }
    .ddl2{
        width: 180px;
        height: 30px;
    }
</style>
<aside class="right-side">
    <section class="content-header">
        <ol class="breadcrumb">
            <li><a href="<?php echo base_url('index.php/basis/home_c/"') ?>"><span>Home</span></a></li>
            <li> <a href="#"><strong>Manage Reservation</strong></a></li>
        </ol>
    </section>

    <section class="content">
        <?php
        if ($msg != NULL) {
            echo $msg;
        }
        ?>

        <div class="row">
            <div class="col-md-12">
                <div class="grid">
                    <div class="grid-header">
                        <i class="fa fa-book"></i>
                        <span class="grid-title"><strong>MANAGE RESERVATION</strong></span>
                        <div class="pull-right">
                            <a href="<?php echo base_url('index.php/room/room_reservation_c/create_reservation') ?>" class="btn btn-default" data-toggle="tooltip" data-placement="left" title="Create Reservation" style="height:30px;font-size:13px;width:100px;">Create</a>
                        </div>
                    </div>
                    <div class="grid-body">
                        <div id="table-luar">
                            <table id="example1" class="table table-striped table-condensed table-hover display" cellspacing="0" width="100%">
                                <thead>
                                    <tr>
                                        <th>No</th>
                                        <th>Reservation</th>
                                        <th>Room</th>
                                        <th>Start Date</th>
                                        <th>Finish Date</th>
                                        <th>Start Time</th>
                                        <th>Finish Time</th>
                                        <th>Meeting</th>
                                        <th>Plant Tour</th>
                                        <th>TV Conference</th>
                                        <th style="text-align:center;">Actions</th>

                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    $yes = "style='background:#7DD488;";
                                    $no = "style='background:#E63F53;";

                                    $i = 1;
                                    foreach ($data as $isi) {
                                        echo "<tr class='gradeX'>";
                                        echo "<td>$i</td>";
                                        echo "<td>$isi->CHR_MEETING_DESC</td>";
                                        echo "<td>$isi->CHR_DESC</td>";

                                        echo "<td>" . date('d-m-Y', strtotime($isi->CHR_DATE_FROM)) . "</td>";
                                        echo "<td>" . date('d-m-Y', strtotime($isi->CHR_DATE_TO)) . "</td>";
                                        echo "<td>" . date('H:i', strtotime($isi->CHR_TIME_FROM)) . "</td>";
                                        echo "<td>" . date('H:i', strtotime($isi->CHR_TIME_TO)) . "</td>";
                                        if ($isi->INT_FLG_MEETING == 1) {
                                            echo "<td><img src='" . base_url() . "/assets/img/check1.png' width='25'></td>";
                                        } else {
                                            echo "<td><img src='" . base_url() . "/assets/img/error1.png' width='25'></td>";
                                        }
                                        if ($isi->INT_FLG_GENBA == 1) {
                                            echo "<td><img src='" . base_url() . "/assets/img/check1.png' width='25'></td>";
                                        } else {
                                            echo "<td><img src='" . base_url() . "/assets/img/error1.png' width='25'></td>";
                                        }
                                        if ($isi->INT_FLG_CONFERENCE == 1) {
                                            echo "<td><img src='" . base_url() . "/assets/img/check1.png' width='25'></td>";
                                        } else {
                                            echo "<td><img src='" . base_url() . "/assets/img/error1.png' width='25'></td>";
                                        }
                                        ?>
                                    <td>
                                        <a href="<?php echo base_url('index.php/room/room_reservation_c/view_reservation') . "/" . $isi->CHR_ID_RESERV; ?>" class="label label-success" data-placement="left" data-toggle="tooltip" title="View"><span class="fa fa-check"></span></a>
                                        <a href="<?php echo base_url('index.php/room/room_reservation_c/edit_reservation') . "/" . $isi->CHR_ID_RESERV; ?>" class="label label-warning" data-placement="top" data-toggle="tooltip" title="Edit"><span class="fa fa-pencil"></span></a>
                                        <a href="<?php echo base_url('index.php/room/room_reservation_c/delete_reservation') . "/" . $isi->CHR_ID_RESERV ?>" class="label label-danger" data-placement="right" data-toggle="tooltip" title="Delete" onclick="return confirm('Are you sure want to delete this reservation?');"><span class="fa fa-times"></span></a>
                                    </td>
                                    </tr>
                                    <?php
                                    $i++;
                                }
                                ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>

    </section>
</aside>



<script src="<?php echo base_url('assets/js/jquery-1.12.3.js') ?>"></script>
<script src="<?php echo base_url('assets/js/jquery.dataTables.min.js') ?>"></script>
<script src="<?php echo base_url('assets/js/dataTables.fixedColumns.min.js') ?>"></script>
<link rel="stylesheet" href="<?php echo base_url('assets/css/fixedColumns.dataTables.min.css'); ?>" >
<script>
                                        $(document).ready(function () {
                                            var table = $('#example1').DataTable({
                                                scrollY: "350px",
                                                scrollX: true,
                                                scrollCollapse: true,
                                                paging: true,
                                                bFilter: true,
                                                fixedColumns: {
                                                    leftColumns: 2
                                                }
                                            });
                                        });

</script>

