<script>
    $(document).ready(function() {
        var interval_close = setInterval(closeSideBar, 250);

        function closeSideBar() {
            $("#hide-sub-menus").click();
            clearInterval(interval_close);
        }
    });
</script>
<style type="text/css">
    th,
    td {
        white-space: nowrap;
    }

    div.dataTables_wrapper {
        margin: 0 auto;
    }

    #table-luar {
        font-size: 11px;
    }

    #filter {
        -webkit-border-horizontal-spacing: 0px;
        -webkit-border-vertical-spacing: 10px;
        border-collapse: separate;
    }

    #filterx {
        -webkit-border-horizontal-spacing: 20px;
        -webkit-border-vertical-spacing: 10px;
        border-collapse: separate;
    }

    .td-fixed {
        width: 30px;
    }

    .td-no {
        width: 10px;
    }

    .ddl {
        width: 120px;
        height: 30px;
    }

    .ddl2 {
        width: 180px;
        height: 30px;
    }
</style>

<aside class="right-side">
    <section class="content-header">
        <ol class="breadcrumb">
            <li><a href="<?php echo base_url('index.php/basis/home_c') ?>"><span>Home</span></a></li>
            <li><a href="<?php echo base_url('index.php/aorta/view_spkl_c') ?>""><strong>View SPKL</strong></a></li>
        </ol>
    </section>

    <section class=" content">
                    <?php
                    if ($msg != NULL) {
                        echo $msg;
                    }
                    ?>

                    <div class="row">
                        <div class="col-md-12">
                            <div class="grid">
                                <div class="grid-header">
                                    <i class="fa fa-clock-o"></i>
                                    <span class="grid-title"><strong>VIEW SPKL</strong></span>
                                    <div class="pull-right grid-tools">

                                    </div>
                                </div>
                                <div class="grid-body">
                                    <div class="pull">
                                        <div class="pull">
                                            <table id='filter' width="100%">
                                                <tr>
                                                    <td width="10%">
                                                        <select class="ddl" id="tanggal" onChange="document.location.href = this.options[this.selectedIndex].value;">
                                                            <?php for ($x = -3; $x <= 1; $x++) {
                                                                $y = $x * 28 ?>
                                                                <option value="<?php echo site_url('aorta/view_spkl_c/index/' . date("Ym", strtotime("+$y day")) . '/' . trim($dept)); ?>" <?php
                                                                                                                                                                                            if ($period == date("Ym", strtotime("+$y day"))) {
                                                                                                                                                                                                echo 'SELECTED';
                                                                                                                                                                                            }
                                                                                                                                                                                            ?>> <?php echo date("M Y", strtotime("+$y day")); ?> </option>
                                                            <?php } ?>
                                                        </select>
                                                    </td>
                                                    <td width="10%" style='text-align:left;' colspan="4">
                                                        <select onChange="document.location.href = this.options[this.selectedIndex].value;" class="ddl">
                                                            <?php foreach ($all_dept as $row) { ?>
                                                                <option value="<?php echo site_url('aorta/view_spkl_c/index/'  . $period . '/' . trim($row->CHR_DEPT)); ?>" <?php
                                                                                                                                                                            if (trim($dept) == trim($row->CHR_DEPT)) {
                                                                                                                                                                                echo 'SELECTED';
                                                                                                                                                                            }
                                                                                                                                                                            ?>><?php echo trim($row->CHR_DEPT); ?></option>
                                                            <?php } ?>
                                                        </select>
                                                    </td>

                                                    <td width="60%">
                                                    </td>
                                            </table>
                                        </div>

                                        <div id="table-luar">
                                            <table id="dataTables3" class="table table-condensed  table-striped table-hover display" cellspacing="0" width="100%">
                                                <thead>
                                                    <tr>
                                                        <th style="vertical-align: middle;text-align:center;">Nama</th>
                                                        <th style="vertical-align: middle;text-align:center;">NPK</th>
                                                        <th style="vertical-align: middle;text-align:center;">DEPT</th>
                                                        <th style="vertical-align: middle;text-align:center;">Tanggal</th>
                                                        <th style="vertical-align: middle;text-align:center;">Jam Mulai</th>
                                                        <th style="vertical-align: middle;text-align:center;">Jam Selesai</th>
                                                    </tr>

                                                </thead>
                                                <tbody>
                                                    <?php foreach ($data_view as $isi) : ?>
                                                        <tr>
                                                            <td><?= $isi->NAMA ?></td> <!-- DARI TABEL TM_KRY -->
                                                            <td style="vertical-align: middle;text-align:center;"><?= $isi->NPK ?></td> <!-- DARI TABEL TT_KRY_OVERTIME -->
                                                            <td style="vertical-align: middle;text-align:center;"><?= $isi->KD_DEPT ?></td>
                                                            <td style="vertical-align: middle;text-align:center;"><?= $isi->TGL_OVERTIME ?></td>
                                                            <td style="vertical-align: middle;text-align:center;"><?= $isi->REAL_MULAI_OV_TIME ?></td>
                                                            <td style="vertical-align: middle;text-align:center;"><?= $isi->REAL_SELESAI_OV_TIME ?></td>


                                                        </tr>
                                                    <?php endforeach; ?>
                                                </tbody>
                                            </table>
                                        </div>


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
<link rel="stylesheet" href="<?php echo base_url('assets/css/fixedColumns.dataTables.min.css'); ?>">
<script>

</script>
