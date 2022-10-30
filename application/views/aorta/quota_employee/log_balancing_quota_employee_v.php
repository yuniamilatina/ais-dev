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
        border-spacing: 10px;
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
            <li><a href="<?php echo base_url('index.php/aorta/quota_employee_c') ?>"><strong>Manage Overtime </strong></a></li>
        </ol>
    </section>

    <section class="content">
        <div class="row">
            <div class="col-md-12">
                <div class="grid">
                    <div class="grid-header">
                        <i class="fa fa-book"></i>
                        <span class="grid-title"><strong>LOG BALANCING QUOTA</strong></span>
                        <div class="pull-right grid-tools">
                            <a data-widget="collapse" title="Collapse"><i class="fa fa-chevron-up"></i></a>
                        </div>
                    </div>
                    <div class="grid-body">
                        <div class="pull">
                            <table id='filter' width="100%">
                                <tr>
                                    <td width="10%" style='text-align:left;'><strong>Periode / Dept</strong></td>
                                    <td width="10%">
                                        <select class="ddl" id="tanggal" onChange="document.location.href = this.options[this.selectedIndex].value;">
                                            <?php for ($x = -5; $x <= 1; $x++) { ?>
                                                <option value="<? echo site_url('aorta/quota_employee_c/log_balancing/' . date("Ym", strtotime("+$x month")) . '/' . trim($dept)); ?>" <?php
                                                                                                                                                                                if ($period == date("Ym", strtotime("+$x month"))) {
                                                                                                                                                                                    echo 'SELECTED';
                                                                                                                                                                                }
                                                                                                                                                                                ?>> <?php echo date("M Y", strtotime("+$x month")); ?> </option>
                                            <?php } ?>
                                        </select>
                                    </td>
                                    <td width="10%" style='text-align:left;' colspan="4">
                                        <select onChange="document.location.href = this.options[this.selectedIndex].value;" class="ddl">
                                            <?php foreach ($all_dept as $row) { ?>
                                                <option value="<? echo site_url('aorta/quota_employee_c/log_balancing/' . $period . '/' . trim($row->CHR_DEPT)); ?>" <?php
                                                                                                                                                                if (trim($dept) == trim($row->CHR_DEPT)) {
                                                                                                                                                                    echo 'SELECTED';
                                                                                                                                                                }
                                                                                                                                                                ?>><?php echo trim($row->CHR_DEPT); ?></option>
                                            <?php } ?>
                                        </select>
                                    </td>
                                    <td width="70%">
                                    </td>
                            </table>
                        </div>
                        <div id="table-luar">
                            <table id="dataTables2" class="table table-condensed table-striped table-hover display" cellspacing="0" width="100%">
                                <thead>
                                    <tr>
                                        <th style='text-align:center;'>No</th>
                                        <th style="text-align:center;">NPK</th>
                                        <th style="text-align:center;">Employee Name</th>
                                        <th style="text-align:center;">Original Quota</th>
                                        <th style="text-align:center;">New Quota</th>
                                        <th style="text-align:center;">Changed Quota</th>
                                        <th style="text-align:center;">Balancing By</th>
                                        <th style="text-align:center;">Date</th>
                                        <th style="text-align:center;">Time</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    $i = 1;
                                    foreach ($data as $isi) {
                                        echo "<tr class='gradeX'>";
                                        echo "<td style='text-align:center;'>$i</td>";
                                        echo "<td style='text-align:center;'>$isi->CHR_NPK</td>";
                                        echo "<td style='text-align:left;'>$isi->NAMA</td>";
                                        echo "<td style='text-align:center;'>$isi->FLO_ORI_QUOTA</td>";
                                        echo "<td style='text-align:center;'>$isi->FLO_NEW_QUOTA</td>";
                                        echo "<td style='text-align:center;'>$isi->FLO_CHANGED_QUOTA</td>";
                                        echo "<td style='text-align:center;'>$isi->CHR_CREATED_BY</td>";
                                        echo "<td style='text-align:center;'>".date_format(date_create($isi->CHR_CREATED_DATE), "d-m-Y")."</td>";
                                        echo "<td style='text-align:center;'>".date_format(date_create($isi->CHR_CREATED_TIME), "H:i:s")."</td>";
                                    ?>
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