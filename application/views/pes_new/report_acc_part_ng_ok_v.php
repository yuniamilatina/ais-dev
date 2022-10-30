<style type="text/css">
    th, td { white-space: nowrap; }
    div.dataTables_wrapper {
        width: 100%;
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
    .ddl{
        width: 100px;
        height: 30px;
    }
    .ddl2{
        width: 180px;
        height: 30px;
    }
</style>

<?php
$status_spv = 1;
$status_mgr = 1;
$reject = base_url('assets/img/error.png');
$approve = base_url('assets/img/check.png');
$status_reject = "<img src=" . $reject . " width='15' height='15'>";
$status_approve = "<img src=" . $approve . " width='15' height='15'>";
?>

<aside class="right-side">
    <section class="content-header">
        <ol class="breadcrumb">
            <li><a href="<?php echo base_url('index.php/basis/home_c/'); ?>"><span>Home</span></a></li>
            <li><a href=""><strong>REPORT PRODUCTION ENTRY</strong></a></li>
        </ol>
    </section>

    <section class="content">
        <?php echo form_open('pes_new/report_prod_accu_part_ng_ok_c/print_report_prod_entry', 'class="form-horizontal"'); ?>
        <div class="row">
            <div class="col-md-12">
                <div class="grid">
                    <div class="grid-header">
                        <i class="fa fa-th-large"></i>
                        <span class="grid-title"><strong>REPORT PRODUCTION PER-PART </strong></span>
                        <div class="pull-right grid-tools">
                            <a data-widget="collapse" title="Collapse"><i class="fa fa-chevron-up"></i></a>
                        </div>
                    </div>
                    <div class="grid-body">
                        <div class="pull">
                            <table width="100%" id='filter' border=0px>
                                <tr>
                                    <td width="10%">Periode</td>
                                    <td width="60%">
                                        <select class="ddl" id="tanggal" onChange="document.location.href = this.options[this.selectedIndex].value;">
                                            <?php for ($x = -5; $x <= 5; $x++) { ?>
                                                <option value="<? echo site_url('pes_new/report_prod_accu_part_ng_ok_c/search_prod_part/' . date("Ym", strtotime("+$x month")) . '/' . $id_prod . '/' . $work_center); ?>" <?php
                                                if ($selected_date == date("Ym", strtotime("+$x month"))) {
                                                    echo 'SELECTED';
                                                }
                                                ?> > <?php echo date("Ym", strtotime("+$x month")); ?> </option>
                                                    <?php } ?>
                                        </select>
                                    </td>
                                    <td width="10%" colspan="4"></td>
                                    <td width="10%">
                                    </td>
                                    <td width="10%">
                                        <?php echo form_open('pes_new/report_prod_accu_part_ng_ok_c/print_report_prod_entry', 'class="form-horizontal"'); ?>
                                        <input name="CHR_DATE_SELECTED" value="<?php echo $selected_date ?>" type="hidden">
                                        <input name="CHR_DEPT_SELECTED" value="<?php echo $id_prod ?>" type="hidden">
                                        <input name="CHR_WC_SELECTED" value="<?php echo $work_center ?>" type="hidden">
                                        <button type="submit" name="btn_submit" value="1" class="btn btn-primary" data-placement="right"><i class="fa fa-download"></i> Export to Excel</button>
                                        <?php echo form_close() ?>
                                    </td>
                                </tr>
                                <tr>
                                    <td width="10%">Department</td>
                                    <td width="60%">
                                        <?php if ($role == 17 || $role == 16 || $role == 6 || $role == 5 || $role == 32 || $role == 60) { ?>
                                            <select disabled style="cursor:not-allowed;background-color: #F3F4F5;" id="opt_wcenter" onChange="document.location.href = this.options[this.selectedIndex].value;" class="ddl2">
                                            <?php } else { ?>
                                                <select id="opt_wcenter" onChange="document.location.href = this.options[this.selectedIndex].value;" class="ddl2">
                                                <?php } ?>
                                                <?php foreach ($all_dept_prod as $row) { ?>
                                                    <option value="<? echo site_url('pes_new/report_prod_accu_part_ng_ok_c/search_prod_part/' . $selected_date . '/' . $row->INT_ID_DEPT . '/' . $work_center); ?>" <?php
                                                    if ($id_prod == $row->INT_ID_DEPT) {
                                                        echo 'SELECTED';
                                                    }
                                                    ?> ><?php echo trim($row->CHR_DEPT_DESC); ?></option>
                                                        <?php } ?>
                                            </select>
                                    </td>
                                    <td width="10%" colspan="4"></td>
                                    <td width="10%">
                                    </td>
                                    <td width="10%">        
                                    </td>
                                </tr>
                                <tr>
                                    <td width="10%">Work Center</td>
                                    <td width="60%"> 
                                        <select id="e1" class="form-control" style="width:100px;" onChange="document.location.href = this.options[this.selectedIndex].value;" >
                                            <?php foreach ($all_work_centers as $row) { ?>
                                                <option value="<? echo site_url('pes_new/report_prod_accu_part_ng_ok_c/search_prod_part/' . $selected_date . '/' . $id_prod . '/' . trim($row->CHR_WORK_CENTER)); ?>" <?php
                                                if (trim($work_center) == trim($row->CHR_WORK_CENTER)) {
                                                    echo 'SELECTED';
                                                }
                                                ?> ><?php echo trim($row->CHR_WORK_CENTER); ?></option>
                                                    <?php } ?>
                                        </select>
                                    </td>
                                    <td width="10%" colspan="4"></td>
                                    <td width="10%">
                                    </td>
                                    <td width="10%">    

                                    </td>
                                </tr>
                            </table>

                        </div>
                        <div id="table-luar">
                            <table id="example" class="table table-condensed table-bordered table-striped table-hover display" cellspacing="0" width="100%">
                                <thead>
                                    <tr class='gradeX'>
                                        <th rowspan="3" style="vertical-align: middle;">No</th>
                                        <th rowspan="3" style="vertical-align: middle;">Back No</th>
                                        <th rowspan="3" style="vertical-align: middle;">Part No</th>
                                        <th rowspan="3" style="vertical-align: middle;">Part Name</th>
                                        <th colspan='124' style="text-align:center;">Date </th>
                                        <th rowspan="3" style="text-align:center;">Total </th>
                                    </tr>
                                    <tr class='gradeX'>
                                        <?php
                                        $date = new DateTime($first_saturday);
                                        $thisMonth = $date->format('m');

                                        $z = 0;
                                        while ($date->format('m') === $thisMonth) {
                                            $datesaturday[$z] = $date->format('j');
                                            $date->modify('next Saturday');
                                            $z++;
                                        }

                                        $date1 = new DateTime($first_sunday);
                                        $thisMonth1 = $date1->format('m');

                                        $y = 0;
                                        while ($date1->format('m') === $thisMonth1) {
                                            $datesunday[$y] = $date1->format('j');
                                            $date1->modify('next Sunday');
                                            $y++;
                                        }

                                        $k = 0;
                                        for ($a = 1; $a <= 31; $a++) {
                                            if ($y == 5 && $z == 5) {
                                                if ($datesunday[$k] == $a || $datesunday[$k + 1] == $a || $datesunday[$k + 2] == $a || $datesunday[$k + 3] == $a || $datesunday[$k + 4] == $a || $datesaturday[$k] == $a || $datesaturday[$k + 1] == $a || $datesaturday[$k + 2] == $a || $datesaturday[$k + 3] == $a || $datesaturday[$k + 4] == $a) {
                                                    if (date('Ymj') == $selected_date . $a) {
                                                        echo "<td colspan='4' style='text-align:center;background:#007FFF;color:white;border-left-width: 0.1em;'>$a</td>";
                                                    } else {
                                                        echo "<td colspan='4' style='text-align:center;background:#E34234;color:white;border-left-width: 0.1em;'>$a</td>";
                                                    }
                                                } else {
                                                    if (date('Ymj') == $selected_date . $a) {
                                                        echo "<td colspan='4' style='text-align:center;background:#007FFF;color:white;border-left-width: 0.1em;'>$a</td>";
                                                    } else {
                                                        echo "<td colspan='4' style='text-align:center;background:whitesmoke;border-left-width: 0.1em;'>$a</td>";
                                                    }
                                                }
                                            }
                                            if ($y == 4 && $z == 4) {
                                                if ($datesunday[$k] == $a || $datesunday[$k + 1] == $a || $datesunday[$k + 2] == $a || $datesunday[$k + 3] == $a || $datesaturday[$k] == $a || $datesaturday[$k + 1] == $a || $datesaturday[$k + 2] == $a || $datesaturday[$k + 3] == $a) {
                                                    if (date('Ymj') == $selected_date . $a) {
                                                        echo "<td colspan='4' style='text-align:center;background:#007FFF;color:white;border-left-width: 0.1em;'>$a</td>";
                                                    } else {
                                                        echo "<td colspan='4' style='text-align:center;background:#E34234;color:white;border-left-width: 0.1em;'>$a</td>";
                                                    }
                                                } else {
                                                    if (date('Ymj') == $selected_date . $a) {
                                                        echo "<td colspan='4' style='text-align:center;background:#007FFF;color:white;border-left-width: 0.1em;'>$a</td>";
                                                    } else {
                                                        echo "<td colspan='4' style='text-align:center;background:whitesmoke;border-left-width: 0.1em;'>$a</td>";
                                                    }
                                                }
                                            }
                                            if ($y == 5 && $z == 4) {
                                                if ($datesunday[$k] == $a || $datesunday[$k + 1] == $a || $datesunday[$k + 2] == $a || $datesunday[$k + 3] == $a || $datesunday[$k + 4] == $a || $datesaturday[$k] == $a || $datesaturday[$k + 1] == $a || $datesaturday[$k + 2] == $a || $datesaturday[$k + 3] == $a) {
                                                    if (date('Ymj') == $selected_date . $a) {
                                                        echo "<td colspan='4' style='text-align:center;background:#007FFF;color:white;border-left-width: 0.1em;'>$a</td>";
                                                    } else {
                                                        echo "<td colspan='4' style='text-align:center;background:#E34234;color:white;border-left-width: 0.1em;'>$a</td>";
                                                    }
                                                } else {
                                                    if (date('Ymj') == $selected_date . $a) {
                                                        echo "<td colspan='4' style='text-align:center;background:#007FFF;color:white;border-left-width: 0.1em;'>$a</td>";
                                                    } else {
                                                        echo "<td colspan='4' style='text-align:center;background:whitesmoke;border-left-width: 0.1em;'>$a</td>";
                                                    }
                                                }
                                            }
                                            if ($y == 4 && $z == 5) {
                                                if ($datesunday[$k] == $a || $datesunday[$k + 1] == $a || $datesunday[$k + 2] == $a || $datesunday[$k + 3] == $a || $datesaturday[$k] == $a || $datesaturday[$k + 1] == $a || $datesaturday[$k + 2] == $a || $datesaturday[$k + 3] == $a || $datesaturday[$k + 4] == $a) {
                                                    if (date('Ymj') == $selected_date . $a) {
                                                        echo "<td colspan='4' style='text-align:center;background:#007FFF;color:white;border-left-width: 0.1em;'>$a</td>";
                                                    } else {
                                                        echo "<td colspan='4' style='text-align:center;background:#E34234;color:white;border-left-width: 0.1em;'>$a</td>";
                                                    }
                                                } else {
                                                    if (date('Ymj') == $selected_date . $a) {
                                                        echo "<td colspan='4' style='text-align:center;background:#007FFF;color:white;border-left-width: 0.1em;'>$a</td>";
                                                    } else {
                                                        echo "<td colspan='4' style='text-align:center;background:whitesmoke;border-left-width: 0.1em;'>$a</td>";
                                                    }
                                                }
                                            }
                                        }
                                        ?>
                                    </tr>
                                    <tr class='gradeX'>
                                        <?php
                                        for ($x = 1; $x <= 62; $x++) {
                                            if ($x % 2 != 0) {
                                                echo "<td style='text-align:center;background:#03C03C;color:white;border-left-width: 0.1em;'><div class='td-fixed'>OK</div></td>";
                                            } else {
                                                echo "<td style='text-align:center;background:#E34234;color:white;border-right-width: 0;'><div class='td-fixed'>NG</div></td>";
                                                echo "<td style='text-align:center;background:white;border-right-width: 0;'>SPV</td>";
                                                echo "<td style='text-align:center;background:whitesmoke;color:black;border-right-width: 0;'>MGR</td>";
                                            }
                                        }
                                        ?>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    $r = 1;
                                    foreach ($data_prod_entry as $isi) {
                                        echo "<tr style='text-align:center;border-right-width: 0;'>";
                                        echo "<td style=text-align:center;>$r</td>";
                                        echo "<td style=text-align:center;>$isi->CHR_BACK_NO</td>";
                                        echo "<td style=text-align:center;>$isi->CHR_PART_NO</td>";
                                        echo "<td style=text-align:left;>$isi->CHR_PART_NAME</td>";
                                        if ($isi->OK_01 >= 100) {
                                            echo "<td style='text-align:center;background:#27DE55;border-left-width: 0.1em;border-right-width: 0;color:white;'>" . number_format($isi->OK_01) . "</td>";
                                        } else if ($isi->OK_01 < 100 && $isi->OK_01 > 0) {
                                            echo "<td style='text-align:center;background:#FFA812;border-left-width: 0.1em;border-right-width: 0;color:white;'>" . number_format($isi->OK_01) . "</td>";
                                        } else {
                                            echo "<td style='text-align:center;border-left-width: 0.1em;border-right-width: 0;'>" . number_format($isi->OK_01) . "</td>";
                                        }
                                        echo "<td style='text-align:center;'>" . number_format($isi->NG_01) . "</td>";
                                        echo "<td style='text-align:center;border-right-width: 0;'></td>";
                                        echo "<td style='text-align:center;border-right-width: 0.1em;'></td>";

                                        if ($isi->OK_02 >= 100) {
                                            echo "<td style='text-align:center;background:#27DE55;border-left-width: 0.1em;border-right-width: 0;color:white;'>" . number_format($isi->OK_02) . "</td>";
                                        } else if ($isi->OK_02 < 100 && $isi->OK_02 > 0) {
                                            echo "<td style='text-align:center;background:#FFA812;border-left-width: 0.1em;border-right-width: 0;color:white;'>" . number_format($isi->OK_02) . "</td>";
                                        } else {
                                            echo "<td style='text-align:center;border-left-width: 0.1em;border-right-width: 0;'>" . number_format($isi->OK_02) . "</td>";
                                        }
                                        echo "<td style='text-align:center;'>" . number_format($isi->NG_02) . "</td>";
                                        echo "<td style='text-align:center;border-right-width: 0;'></td>";
                                        echo "<td style='text-align:center;border-right-width: 0.1em;'></td>";

                                        if ($isi->OK_03 >= 100) {
                                            echo "<td style='text-align:center;background:#27DE55;border-left-width: 0.1em;border-right-width: 0;color:white;'>" . number_format($isi->OK_03) . "</td>";
                                        } else if ($isi->OK_03 < 100 && $isi->OK_03 > 0) {
                                            echo "<td style='text-align:center;background:#FFA812;border-left-width: 0.1em;border-right-width: 0;color:white;'>" . number_format($isi->OK_03) . "</td>";
                                        } else {
                                            echo "<td style='text-align:center;border-left-width: 0.1em;border-right-width: 0;'>" . number_format($isi->OK_03) . "</td>";
                                        }
                                        echo "<td style='text-align:center;'>" . number_format($isi->NG_03) . "</td>";
                                        echo "<td style='text-align:center;border-right-width: 0;'></td>";
                                        echo "<td style='text-align:center;border-right-width: 0.1em;'></td>";
                                        if ($isi->OK_04 >= 100) {
                                            echo "<td style='text-align:center;background:#27DE55;border-left-width: 0.1em;border-right-width: 0;color:white;'>" . number_format($isi->OK_04) . "</td>";
                                        } else if ($isi->OK_04 < 100 && $isi->OK_04 > 0) {
                                            echo "<td style='text-align:center;background:#FFA812;border-left-width: 0.1em;border-right-width: 0;color:white;'>" . number_format($isi->OK_04) . "</td>";
                                        } else {
                                            echo "<td style='text-align:center;border-left-width: 0.1em;border-right-width: 0;'>" . number_format($isi->OK_04) . "</td>";
                                        }
                                        echo "<td style='text-align:center;'>" . number_format($isi->NG_04) . "</td>";
                                        echo "<td style='text-align:center;border-right-width: 0;'></td>";
                                        echo "<td style='text-align:center;border-right-width: 0.1em;'></td>";
                                        if ($isi->OK_05 >= 100) {
                                            echo "<td style='text-align:center;background:#27DE55;border-left-width: 0.1em;border-right-width: 0;color:white;'>" . number_format($isi->OK_05) . "</td>";
                                        } else if ($isi->OK_05 < 100 && $isi->OK_05 > 0) {
                                            echo "<td style='text-align:center;background:#FFA812;border-left-width: 0.1em;border-right-width: 0;color:white;'>" . number_format($isi->OK_05) . "</td>";
                                        } else {
                                            echo "<td style='text-align:center;border-left-width: 0.1em;border-right-width: 0;'>" . number_format($isi->OK_05) . "</td>";
                                        }
                                        echo "<td style='text-align:center;'>" . number_format($isi->NG_05) . "</td>";
                                        echo "<td style='text-align:center;border-right-width: 0;'></td>";
                                        echo "<td style='text-align:center;border-right-width: 0.1em;'></td>";
                                        if ($isi->OK_06 >= 100) {
                                            echo "<td style='text-align:center;background:#27DE55;border-left-width: 0.1em;border-right-width: 0;color:white;'>" . number_format($isi->OK_06) . "</td>";
                                        } else if ($isi->OK_06 < 100 && $isi->OK_06 > 0) {
                                            echo "<td style='text-align:center;background:#FFA812;border-left-width: 0.1em;border-right-width: 0;color:white;'>" . number_format($isi->OK_06) . "</td>";
                                        } else {
                                            echo "<td style='text-align:center;border-left-width: 0.1em;border-right-width: 0;'>" . number_format($isi->OK_06) . "</td>";
                                        }
                                        echo "<td style='text-align:center;'>" . number_format($isi->NG_06) . "</td>";
                                        echo "<td style='text-align:center;border-right-width: 0;'></td>";
                                        echo "<td style='text-align:center;border-right-width: 0.1em;'></td>";
                                        if ($isi->OK_07 >= 100) {
                                            echo "<td style='text-align:center;background:#27DE55;border-left-width: 0.1em;border-right-width: 0;color:white;'>" . number_format($isi->OK_07) . "</td>";
                                        } else if ($isi->OK_07 < 100 && $isi->OK_06 > 0) {
                                            echo "<td style='text-align:center;background:#FFA812;border-left-width: 0.1em;border-right-width: 0;color:white;'>" . number_format($isi->OK_07) . "</td>";
                                        } else {
                                            echo "<td style='text-align:center;border-left-width: 0.1em;border-right-width: 0;'>" . number_format($isi->OK_07) . "</td>";
                                        } echo "<td style='text-align:center;'>" . number_format($isi->NG_07) . "</td>";
                                        echo "<td style='text-align:center;border-right-width: 0;'></td>";
                                        echo "<td style='text-align:center;border-right-width: 0.1em;'></td>";
                                        if ($isi->OK_08 >= 100) {
                                            echo "<td style='text-align:center;background:#27DE55;border-left-width: 0.1em;border-right-width: 0;color:white;'>" . number_format($isi->OK_08) . "</td>";
                                        } else if ($isi->OK_08 < 100 && $isi->OK_08 > 0) {
                                            echo "<td style='text-align:center;background:#FFA812;border-left-width: 0.1em;border-right-width: 0;color:white;'>" . number_format($isi->OK_08) . "</td>";
                                        } else {
                                            echo "<td style='text-align:center;border-left-width: 0.1em;border-right-width: 0;'>" . number_format($isi->OK_08) . "</td>";
                                        }
                                        echo "<td style='text-align:center;'>" . number_format($isi->NG_08) . "</td>";
                                        echo "<td style='text-align:center;border-right-width: 0;'></td>";
                                        echo "<td style='text-align:center;border-right-width: 0.1em;'></td>";
                                        if ($isi->OK_09 >= 100) {
                                            echo "<td style='text-align:center;background:#27DE55;border-left-width: 0.1em;border-right-width: 0;color:white;'>" . number_format($isi->OK_09) . "</td>";
                                        } else if ($isi->OK_09 < 100 && $isi->OK_09 > 0) {
                                            echo "<td style='text-align:center;background:#FFA812;border-left-width: 0.1em;border-right-width: 0;color:white;'>" . number_format($isi->OK_09) . "</td>";
                                        } else {
                                            echo "<td style='text-align:center;border-left-width: 0.1em;border-right-width: 0;'>" . number_format($isi->OK_09) . "</td>";
                                        } echo "<td style='text-align:center;'>" . number_format($isi->NG_09) . "</td>";
                                        echo "<td style='text-align:center;border-right-width: 0;'></td>";
                                        echo "<td style='text-align:center;border-right-width: 0.1em;'></td>";
                                        if ($isi->OK_10 >= 100) {
                                            echo "<td style='text-align:center;background:#27DE55;border-left-width: 0.1em;border-right-width: 0;color:white;'>" . number_format($isi->OK_10) . "</td>";
                                        } else if ($isi->OK_10 < 100 && $isi->OK_10 > 0) {
                                            echo "<td style='text-align:center;background:#FFA812;border-left-width: 0.1em;border-right-width: 0;color:white;'>" . number_format($isi->OK_10) . "</td>";
                                        } else {
                                            echo "<td style='text-align:center;border-left-width: 0.1em;border-right-width: 0;'>" . number_format($isi->OK_10) . "</td>";
                                        }
                                        echo "<td style='text-align:center;'>" . number_format($isi->NG_10) . "</td>";
                                        echo "<td style='text-align:center;border-right-width: 0;'></td>";
                                        echo "<td style='text-align:center;border-right-width: 0.1em;'></td>";
                                        if ($isi->OK_11 >= 100) {
                                            echo "<td style='text-align:center;background:#27DE55;border-left-width: 0.1em;border-right-width: 0;color:white;'>" . number_format($isi->OK_11) . "</td>";
                                        } else if ($isi->OK_11 < 100 && $isi->OK_11 > 0) {
                                            echo "<td style='text-align:center;background:#FFA812;border-left-width: 0.1em;border-right-width: 0;color:white;'>" . number_format($isi->OK_11) . "</td>";
                                        } else {
                                            echo "<td style='text-align:center;border-left-width: 0.1em;border-right-width: 0;'>" . number_format($isi->OK_11) . "</td>";
                                        }
                                        echo "<td style='text-align:center;'>" . number_format($isi->NG_11) . "</td>";
                                        echo "<td style='text-align:center;border-right-width: 0;'></td>";
                                        echo "<td style='text-align:center;border-right-width: 0.1em;'></td>";
                                        if ($isi->OK_12 >= 100) {
                                            echo "<td style='text-align:center;background:#27DE55;border-left-width: 0.1em;border-right-width: 0;color:white;'>" . number_format($isi->OK_12) . "</td>";
                                        } else if ($isi->OK_12 < 100 && $isi->OK_12 > 0) {
                                            echo "<td style='text-align:center;background:#FFA812;border-left-width: 0.1em;border-right-width: 0;color:white;'>" . number_format($isi->OK_12) . "</td>";
                                        } else {
                                            echo "<td style='text-align:center;border-left-width: 0.1em;border-right-width: 0;'>" . number_format($isi->OK_12) . "</td>";
                                        }
                                        echo "<td style='text-align:center;'>" . number_format($isi->NG_12) . "</td>";
                                        echo "<td style='text-align:center;border-right-width: 0;'></td>";
                                        echo "<td style='text-align:center;border-right-width: 0.1em;'></td>";
                                        if ($isi->OK_13 >= 100) {
                                            echo "<td style='text-align:center;background:#27DE55;border-left-width: 0.1em;border-right-width: 0;color:white;'>" . number_format($isi->OK_13) . "</td>";
                                        } else if ($isi->OK_13 < 100 && $isi->OK_13 > 0) {
                                            echo "<td style='text-align:center;background:#FFA812;border-left-width: 0.1em;border-right-width: 0;color:white;'>" . number_format($isi->OK_13) . "</td>";
                                        } else {
                                            echo "<td style='text-align:center;border-left-width: 0.1em;border-right-width: 0;'>" . number_format($isi->OK_13) . "</td>";
                                        }
                                        echo "<td style='text-align:center;'>" . number_format($isi->NG_13) . "</td>";
                                        echo "<td style='text-align:center;border-right-width: 0;'></td>";
                                        echo "<td style='text-align:center;border-right-width: 0.1em;'></td>";
                                        if ($isi->OK_14 >= 100) {
                                            echo "<td style='text-align:center;background:#27DE55;border-left-width: 0.1em;border-right-width: 0;color:white;'>" . number_format($isi->OK_14) . "</td>";
                                        } else if ($isi->OK_14 < 100 && $isi->OK_14 > 0) {
                                            echo "<td style='text-align:center;background:#FFA812;border-left-width: 0.1em;border-right-width: 0;color:white;'>" . number_format($isi->OK_14) . "</td>";
                                        } else {
                                            echo "<td style='text-align:center;border-left-width: 0.1em;border-right-width: 0;'>" . number_format($isi->OK_14) . "</td>";
                                        }
                                        echo "<td style='text-align:center;'>" . number_format($isi->NG_14) . "</td>";
                                        echo "<td style='text-align:center;border-right-width: 0;'></td>";
                                        echo "<td style='text-align:center;border-right-width: 0.1em;'></td>";
                                        if ($isi->OK_15 >= 100) {
                                            echo "<td style='text-align:center;background:#27DE55;border-left-width: 0.1em;border-right-width: 0;color:white;'>" . number_format($isi->OK_15) . "</td>";
                                        } else if ($isi->OK_15 < 100 && $isi->OK_15 > 0) {
                                            echo "<td style='text-align:center;background:#FFA812;border-left-width: 0.1em;border-right-width: 0;color:white;'>" . number_format($isi->OK_15) . "</td>";
                                        } else {
                                            echo "<td style='text-align:center;border-left-width: 0.1em;border-right-width: 0;'>" . number_format($isi->OK_15) . "</td>";
                                        }
                                        echo "<td style='text-align:center;'>" . number_format($isi->NG_15) . "</td>";
                                        echo "<td style='text-align:center;border-right-width: 0;'></td>";
                                        echo "<td style='text-align:center;border-right-width: 0.1em;'></td>";
                                        if ($isi->OK_16 >= 100) {
                                            echo "<td style='text-align:center;background:#27DE55;border-left-width: 0.1em;border-right-width: 0;color:white;'>" . number_format($isi->OK_16) . "</td>";
                                        } else if ($isi->OK_16 < 100 && $isi->OK_16 > 0) {
                                            echo "<td style='text-align:center;background:#FFA812;border-left-width: 0.1em;border-right-width: 0;color:white;'>" . number_format($isi->OK_16) . "</td>";
                                        } else {
                                            echo "<td style='text-align:center;border-left-width: 0.1em;border-right-width: 0;'>" . number_format($isi->OK_16) . "</td>";
                                        }
                                        echo "<td style='text-align:center;'>" . number_format($isi->NG_16) . "</td>";
                                        echo "<td style='text-align:center;border-right-width: 0;'></td>";
                                        echo "<td style='text-align:center;border-right-width: 0.1em;'></td>";
                                        if ($isi->OK_17 >= 100) {
                                            echo "<td style='text-align:center;background:#27DE55;border-left-width: 0.1em;border-right-width: 0;color:white;'>" . number_format($isi->OK_17) . "</td>";
                                        } else if ($isi->OK_17 < 100 && $isi->OK_17 > 0) {
                                            echo "<td style='text-align:center;background:#FFA812;border-left-width: 0.1em;border-right-width: 0;color:white;'>" . number_format($isi->OK_17) . "</td>";
                                        } else {
                                            echo "<td style='text-align:center;border-left-width: 0.1em;border-right-width: 0;'>" . number_format($isi->OK_17) . "</td>";
                                        }
                                        echo "<td style='text-align:center;'>" . number_format($isi->NG_17) . "</td>";
                                        echo "<td style='text-align:center;border-right-width: 0;'></td>";
                                        echo "<td style='text-align:center;border-right-width: 0.1em;'></td>";
                                        if ($isi->OK_18 >= 100) {
                                            echo "<td style='text-align:center;background:#27DE55;border-left-width: 0.1em;border-right-width: 0;color:white;'>" . number_format($isi->OK_18) . "</td>";
                                        } else if ($isi->OK_18 < 100 && $isi->OK_18 > 0) {
                                            echo "<td style='text-align:center;background:#FFA812;border-left-width: 0.1em;border-right-width: 0;color:white;'>" . number_format($isi->OK_18) . "</td>";
                                        } else {
                                            echo "<td style='text-align:center;border-left-width: 0.1em;border-right-width: 0;'>" . number_format($isi->OK_18) . "</td>";
                                        }
                                        echo "<td style='text-align:center;'>" . number_format($isi->NG_18) . "</td>";
                                        echo "<td style='text-align:center;border-right-width: 0;'></td>";
                                        echo "<td style='text-align:center;border-right-width: 0.1em;'></td>";
                                        if ($isi->OK_19 >= 100) {
                                            echo "<td style='text-align:center;background:#27DE55;border-left-width: 0.1em;border-right-width: 0;color:white;'>" . number_format($isi->OK_19) . "</td>";
                                        } else if ($isi->OK_19 < 100 && $isi->OK_19 > 0) {
                                            echo "<td style='text-align:center;background:#FFA812;border-left-width: 0.1em;border-right-width: 0;color:white;'>" . number_format($isi->OK_19) . "</td>";
                                        } else {
                                            echo "<td style='text-align:center;border-left-width: 0.1em;border-right-width: 0;'>" . number_format($isi->OK_19) . "</td>";
                                        }
                                        echo "<td style='text-align:center;'>" . number_format($isi->NG_19) . "</td>";
                                        echo "<td style='text-align:center;border-right-width: 0;'></td>";
                                        echo "<td style='text-align:center;border-right-width: 0.1em;'></td>";
                                        if ($isi->OK_20 >= 100) {
                                            echo "<td style='text-align:center;background:#27DE55;border-left-width: 0.1em;border-right-width: 0;color:white;'>" . number_format($isi->OK_20) . "</td>";
                                        } else if ($isi->OK_20 < 100 && $isi->OK_20 > 0) {
                                            echo "<td style='text-align:center;background:#FFA812;border-left-width: 0.1em;border-right-width: 0;color:white;'>" . number_format($isi->OK_20) . "</td>";
                                        } else {
                                            echo "<td style='text-align:center;border-left-width: 0.1em;border-right-width: 0;'>" . number_format($isi->OK_20) . "</td>";
                                        }
                                        echo "<td style='text-align:center;'>" . number_format($isi->NG_20) . "</td>";
                                        echo "<td style='text-align:center;border-right-width: 0;'></td>";
                                        echo "<td style='text-align:center;border-right-width: 0.1em;'></td>";
                                        if ($isi->OK_21 >= 100) {
                                            echo "<td style='text-align:center;background:#27DE55;border-left-width: 0.1em;border-right-width: 0;color:white;'>" . number_format($isi->OK_21) . "</td>";
                                        } else if ($isi->OK_21 < 100 && $isi->OK_21 > 0) {
                                            echo "<td style='text-align:center;background:#FFA812;border-left-width: 0.1em;border-right-width: 0;color:white;'>" . number_format($isi->OK_21) . "</td>";
                                        } else {
                                            echo "<td style='text-align:center;border-left-width: 0.1em;border-right-width: 0;'>" . number_format($isi->OK_21) . "</td>";
                                        }
                                        echo "<td style='text-align:center;'>" . number_format($isi->NG_21) . "</td>";
                                        echo "<td style='text-align:center;border-right-width: 0;'></td>";
                                        echo "<td style='text-align:center;border-right-width: 0.1em;'></td>";
                                        if ($isi->OK_22 >= 100) {
                                            echo "<td style='text-align:center;background:#27DE55;border-left-width: 0.1em;border-right-width: 0;color:white;'>" . number_format($isi->OK_22) . "</td>";
                                        } else if ($isi->OK_22 < 100 && $isi->OK_22 > 0) {
                                            echo "<td style='text-align:center;background:#FFA812;border-left-width: 0.1em;border-right-width: 0;color:white;'>" . number_format($isi->OK_22) . "</td>";
                                        } else {
                                            echo "<td style='text-align:center;border-left-width: 0.1em;border-right-width: 0;'>" . number_format($isi->OK_22) . "</td>";
                                        }
                                        echo "<td style='text-align:center;'>" . number_format($isi->NG_22) . "</td>";
                                        echo "<td style='text-align:center;border-right-width: 0;'></td>";
                                        echo "<td style='text-align:center;border-right-width: 0.1em;'></td>";
                                        if ($isi->OK_23 >= 100) {
                                            echo "<td style='text-align:center;background:#27DE55;border-left-width: 0.1em;border-right-width: 0;color:white;'>" . number_format($isi->OK_23) . "</td>";
                                        } else if ($isi->OK_23 < 100 && $isi->OK_23 > 0) {
                                            echo "<td style='text-align:center;background:#FFA812;border-left-width: 0.1em;border-right-width: 0;color:white;'>" . number_format($isi->OK_23) . "</td>";
                                        } else {
                                            echo "<td style='text-align:center;border-left-width: 0.1em;border-right-width: 0;'>" . number_format($isi->OK_23) . "</td>";
                                        }
                                        echo "<td style='text-align:center;'>" . number_format($isi->NG_23) . "</td>";
                                        echo "<td style='text-align:center;border-right-width: 0;'></td>";
                                        echo "<td style='text-align:center;border-right-width: 0.1em;'></td>";
                                        if ($isi->OK_24 >= 100) {
                                            echo "<td style='text-align:center;background:#27DE55;border-left-width: 0.1em;border-right-width: 0;color:white;'>" . number_format($isi->OK_24) . "</td>";
                                        } else if ($isi->OK_24 < 100 && $isi->OK_24 > 0) {
                                            echo "<td style='text-align:center;background:#FFA812;border-left-width: 0.1em;border-right-width: 0;color:white;'>" . number_format($isi->OK_24) . "</td>";
                                        } else {
                                            echo "<td style='text-align:center;border-left-width: 0.1em;border-right-width: 0;'>" . number_format($isi->OK_24) . "</td>";
                                        }
                                        echo "<td style='text-align:center;'>" . number_format($isi->NG_24) . "</td>";
                                        echo "<td style='text-align:center;border-right-width: 0;'></td>";
                                        echo "<td style='text-align:center;border-right-width: 0.1em;'></td>";
                                        if ($isi->OK_25 >= 100) {
                                            echo "<td style='text-align:center;background:#27DE55;border-left-width: 0.1em;border-right-width: 0;color:white;'>" . number_format($isi->OK_25) . "</td>";
                                        } else if ($isi->OK_25 < 100 && $isi->OK_25 > 0) {
                                            echo "<td style='text-align:center;background:#FFA812;border-left-width: 0.1em;border-right-width: 0;color:white;'>" . number_format($isi->OK_25) . "</td>";
                                        } else {
                                            echo "<td style='text-align:center;border-left-width: 0.1em;border-right-width: 0;'>" . number_format($isi->OK_25) . "</td>";
                                        }
                                        echo "<td style='text-align:center;'>" . number_format($isi->NG_25) . "</td>";
                                        echo "<td style='text-align:center;border-right-width: 0;'></td>";
                                        echo "<td style='text-align:center;border-right-width: 0.1em;'></td>";
                                        if ($isi->OK_26 >= 100) {
                                            echo "<td style='text-align:center;background:#27DE55;border-left-width: 0.1em;border-right-width: 0;color:white;'>" . number_format($isi->OK_26) . "</td>";
                                        } else if ($isi->OK_26 < 100 && $isi->OK_26 > 0) {
                                            echo "<td style='text-align:center;background:#FFA812;border-left-width: 0.1em;border-right-width: 0;color:white;'>" . number_format($isi->OK_26) . "</td>";
                                        } else {
                                            echo "<td style='text-align:center;border-left-width: 0.1em;border-right-width: 0;'>" . number_format($isi->OK_26) . "</td>";
                                        }
                                        echo "<td style='text-align:center;'>" . number_format($isi->NG_26) . "</td>";
                                        echo "<td style='text-align:center;border-right-width: 0;'></td>";
                                        echo "<td style='text-align:center;border-right-width: 0.1em;'></td>";
                                        if ($isi->OK_27 >= 100) {
                                            echo "<td style='text-align:center;background:#27DE55;border-left-width: 0.1em;border-right-width: 0;color:white;'>" . number_format($isi->OK_27) . "</td>";
                                        } else if ($isi->OK_27 < 100 && $isi->OK_27 > 0) {
                                            echo "<td style='text-align:center;background:#FFA812;border-left-width: 0.1em;border-right-width: 0;color:white;'>" . number_format($isi->OK_27) . "</td>";
                                        } else {
                                            echo "<td style='text-align:center;border-left-width: 0.1em;border-right-width: 0;'>" . number_format($isi->OK_27) . "</td>";
                                        }
                                        echo "<td style='text-align:center;'>" . number_format($isi->NG_27) . "</td>";
                                        echo "<td style='text-align:center;border-right-width: 0;'></td>";
                                        echo "<td style='text-align:center;border-right-width: 0.1em;'></td>";
                                        if ($isi->OK_28 >= 100) {
                                            echo "<td style='text-align:center;background:#27DE55;border-left-width: 0.1em;border-right-width: 0;color:white;'>" . number_format($isi->OK_28) . "</td>";
                                        } else if ($isi->OK_28 < 100 && $isi->OK_28 > 0) {
                                            echo "<td style='text-align:center;background:#FFA812;border-left-width: 0.1em;border-right-width: 0;color:white;'>" . number_format($isi->OK_28) . "</td>";
                                        } else {
                                            echo "<td style='text-align:center;border-left-width: 0.1em;border-right-width: 0;'>" . number_format($isi->OK_28) . "</td>";
                                        }
                                        echo "<td style='text-align:center;'>" . number_format($isi->NG_28) . "</td>";
                                        echo "<td style='text-align:center;border-right-width: 0;'></td>";
                                        echo "<td style='text-align:center;border-right-width: 0.1em;'></td>";
                                        if ($isi->OK_29 >= 100) {
                                            echo "<td style='text-align:center;background:#27DE55;border-left-width: 0.1em;border-right-width: 0;color:white;'>" . number_format($isi->OK_29) . "</td>";
                                        } else if ($isi->OK_29 < 100 && $isi->OK_29 > 0) {
                                            echo "<td style='text-align:center;background:#FFA812;border-left-width: 0.1em;border-right-width: 0;color:white;'>" . number_format($isi->OK_29) . "</td>";
                                        } else {
                                            echo "<td style='text-align:center;border-left-width: 0.1em;border-right-width: 0;'>" . number_format($isi->OK_29) . "</td>";
                                        }
                                        echo "<td style='text-align:center;'>" . number_format($isi->NG_29) . "</td>";
                                        echo "<td style='text-align:center;border-right-width: 0;'></td>";
                                        echo "<td style='text-align:center;border-right-width: 0.1em;'></td>";
                                        if ($isi->OK_30 >= 100) {
                                            echo "<td style='text-align:center;background:#27DE55;border-left-width: 0.1em;border-right-width: 0;color:white;'>" . number_format($isi->OK_30) . "</td>";
                                        } else if ($isi->OK_30 < 100 && $isi->OK_30 > 0) {
                                            echo "<td style='text-align:center;background:#FFA812;border-left-width: 0.1em;border-right-width: 0;color:white;'>" . number_format($isi->OK_30) . "</td>";
                                        } else {
                                            echo "<td style='text-align:center;border-left-width: 0.1em;border-right-width: 0;'>" . number_format($isi->OK_30) . "</td>";
                                        }
                                        echo "<td style='text-align:center;'>" . number_format($isi->NG_30) . "</td>";
                                        echo "<td style='text-align:center;border-right-width: 0;'></td>";
                                        echo "<td style='text-align:center;border-right-width: 0.1em;'></td>";
                                        if ($isi->OK_31 >= 100) {
                                            echo "<td style='text-align:center;background:#27DE55;border-left-width: 0.1em;border-right-width: 0;color:white;'>" . number_format($isi->OK_31) . "</td>";
                                        } else if ($isi->OK_31 < 100 && $isi->OK_31 > 0) {
                                            echo "<td style='text-align:center;background:#FFA812;border-left-width: 0.1em;border-right-width: 0;color:white;'>" . number_format($isi->OK_31) . "</td>";
                                        } else {
                                            echo "<td style='text-align:center;border-left-width: 0.1em;border-right-width: 0;'>" . number_format($isi->OK_31) . "</td>";
                                        }
                                        echo "<td style='text-align:center;'>" . number_format($isi->NG_31) . "</td>";
                                        echo "<td style='text-align:center;border-right-width: 0;'></td>";
                                        echo "<td style='text-align:center;border-right-width: 0.1em;'></td>";
                                        echo "<td style='text-align:center;border-right-width: 0.1em;'>" . number_format($isi->TOTAL) . "</td>";
                                        ?>
                                        </tr>
                                        <?php
                                        $r++;
                                    }
                                    ?>
                                </tbody>
                            </table>
                        </div>

                        <div class="pull">
                            <table width="40%" id='filter' border=0px style="outline: thin ridge #DDDDDD">
                                <tr>
                                    <td width="3%" style='text-align:left;' colspan="4"><strong>Legend :</strong></td>
                                    <td width="10%">
                                        <button disabled style='border:0;background:#03C03C;width:25px;height:25px;'></button> : > 100
                                    </td>
                                    <td width="10%">0 <
                                        <button disabled style='border:0;background:#FFA812;width:25px;height:25px;'></button> : < 100
                                    </td>
                                </tr>
                                <tr>
                                    <td width="3%" colspan="4"></td>
                                    <td width="10%">
                                        <button disabled style='background:#E34234;border:0;width:25px;height:25px;'><?php echo $status_reject; ?></button> : Reject by SPV
                                    </td>
                                    <td width="10%">        
                                        <button disabled style='background:#E34234;border:0;width:25px;height:25px;'><?php echo $status_approve; ?></button> : Approve by SPV
                                    </td>
                                </tr>
                                <tr>
                                    <td width="3%" colspan="4"></td>
                                    <td width="10%">
                                        <button disabled style='background:#007FFF;border:0;width:25px;height:25px;'><?php echo $status_reject; ?></button> : Reject by MGR
                                    </td>
                                    <td width="10%">        
                                        <button disabled style='background:#007FFF;border:0;width:25px;height:25px;'><?php echo $status_approve; ?></button> : Approve by MGR
                                    </td>
                                </tr>
                            </table>
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
                                                $(document).ready(function() {
                                                    var table = $('#example').DataTable({
                                                        scrollY: "350px",
                                                        scrollX: true,
                                                        scrollCollapse: true,
                                                        paging: false,
                                                        fixedColumns: {
                                                            leftColumns: 3
                                                        }
                                                    });
                                                });
</script>