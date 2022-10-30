<style type="text/css">
    #td_date{
        text-align:center;
        vertical-align:top;
    } 
    #table-luar{
        font-size: 12px;
    }
    #filter { 
        border-spacing: 10px;
    }
    .td-fixed{
        width: 20px;
    }
    #filter { 
        border-spacing: 10px;
        border-collapse: separate;
    }

    #filterdiagram {
        border-spacing: 5px;
        border-color: #DDDDDD;
        background-color: #F3F4F5;
    }

    .btn:hover {
        background: #1E90FF;
        background-image: -webkit-linear-gradient(top, #1E90FF, #1E90FF);
        background-image: -moz-linear-gradient(top, #1E90FF, #1E90FF);
        background-image: -ms-linear-gradient(top, #1E90FF, #1E90FF);
        background-image: -o-linear-gradient(top, #1E90FF, #1E90FF);
        background-image: linear-gradient(to bottom, #1E90FF, #1E90FF);
        color:white;
    }

</style>

<script>     var tableToExcel = (function () {
var uri = 'data:application/vnd.ms-excel;base64,'
, template = '<html xmlns:o="urn:schemas-microsoft-com:office:office" xmlns:x="urn:schemas-microsoft-com:office:excel" xmlns="http://www.w3.org/TR/REC-html40"><head><!--[if gte mso 9]><xml><x:ExcelWorkbook><x:ExcelWorksheets><x:ExcelWorksheet><x:Name>{worksheet}</x:Name><x:WorksheetOptions><x:DisplayGridlines/></x:WorksheetOptions></x:ExcelWorksheet></x:ExcelWorksheets></x:ExcelWorkbook></xml><![endif]--></head><body><table>{table}</table></body></html>'
            , base64 = function (s) {
return window.btoa(unescape(encodeURIComponent(s)))
    }
, format = function (s, c) {
return s.replace(/{(\w+)}/g, function (m, p) {
    return c[p];
})
}
return function (table, name) {
if (!table.nodeType)
    table = document.getElementById(table)
var ctx = {worksheet: name || 'Sheet1', table: table.innerHTML}
window.location.href = uri + base64(format(template, ctx))
}
})()
</script>

<aside class="right-side">
    <section class="content-header">
        <ol class="breadcrumb">
            <li><a href="<?php echo base_url('index.php/basis/home_c/'); ?>"><span>Home</span></a></li>
            <li><a href=""><strong>REPORT NORITSU</strong></a></li>
        </ol>
    </section>

    <section class="content">
               
    <div class="row">
            <div class="col-md-12">
                <div class="grid">
                    <div class="grid-header">
                        <i class="fa fa-th-large"></i>
                        <span class="grid-title"><strong>REPORT NORITSU </strong></span>
                        <div class="pull-right grid-tools">
                        <a data-widget="collapse" title="Collapse"><i class="fa fa-chevron-up"></i></a>
                            <a data-widget="reload" title="Reload"><i class="fa fa-refresh"></i></a>
                            <a data-widget="remove" title="Remove"><i class="fa fa-times"></i></a>
                        </div>
                    </div>
                    <div class="grid-body">
                    <div class="pull">
                    <div class="pull-right grid-tools">
                                <?php echo form_open('pes_new/report_noritsu_c/search_noritsu', 'class="form-horizontal"'); ?>
                            </div>
                            <table width="100%" id='filter' border=0px>
                                <tr>
                                    <td width="10%">Periode</td>
                                    <td width="10%">
                                        <select class="ddl" style="width:100px;" name="CHR_DATE_SELECTED">
                                            <?php for ($x = -5; $x <= 0; $x++) { ?>
                                                <option value="<?php echo date("Ym", strtotime("+$x month")); ?>"<?php
                                                if ($selected_date == date("Ym", strtotime("+$x month"))) {
                                                    echo 'SELECTED';
                                                }
                                                ?> > <?php echo date("M Y", strtotime("+$x month")); ?> </option>
                                                    <?php } ?>
                                        </select>

                                    </td>

                                    <td width="10%"></td>
                                    <td width="10%"></td>
                                    <td width="60%"></td>
                                <tr>
                                    <td>Dept</td>
                                    <td>
                                        <select id="CHR_DEPT" name="CHR_DEPT_SELECTED" style="width:100px;"  class="ddl">
                                            <?php foreach ($all_dept_prod as $row) { ?>
                                                    <option value="<?php echo $row->INT_ID_DEPT; ?>" <?php
                                                    if ($id_prod == $row->INT_ID_DEPT) {
                                                        echo 'SELECTED';
                                            }
                                            ?> ><?php echo trim($row->CHR_DEPT); ?></option>
                                            <?php } ?>
                                            </select>
                                    </td>
                                    <td> 
                                    <select name="CHR_WORK_CENTER_SELECTED" style="width:100px;"  class="ddl">
                                        <?php foreach ($all_work_centers as $row) { ?>
                                        <option value="<?php echo (trim($row->CHR_WORK_CENTER)); ?>" <?php
                                            if (trim($work_center) == trim($row->CHR_WORK_CENTER)) {
                                                echo 'SELECTED';
                                            }
                                            ?> ><?php echo trim($row->CHR_WORK_CENTER); ?></option>
                                        <?php } ?>
                                        </select>
                                    </td>
                                    <td>
                                        <button type="submit" name="submit" class="btn btn-success" data-placement="right"><i class="fa fa-search"></i> Filter</button>
                                    </td>
                                    <td style="text-align:right;">
                                        <input type="button" class="btn btn-primary" onclick="tableToExcel('exportToExcel', 'Summary Noritsu')" value="Export to Excel">
                                    </td>

                                </tr>
                            </table>

                        </div>
                        <?php echo form_close() ?>
                        <div id="table-luar">
                        <table id="example" class="table table-condensed table-bordered table-striped table-hover display" cellspacing="0" width="100%">
                            <thead>
                                <tr class='gradeX'>
                                    <th rowspan='2' style=text-align:center;>#</th>
                                    <th rowspan='2' style=text-align:center;>Part No </th>
                                    <th rowspan='2' style=text-align:center;>Back No </th>
                                    <th rowspan='2' style=text-align:center;>Part Name </th>
                                    <th colspan='31' style=text-align:center;>Date </th>
                                    <th rowspan='2' style=text-align:center;>AVG </th>
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
                                                        echo "<td style='text-align:center;background:#007FFF;color:white;border-left-width: 0.1em;'><div class='td-fixed'>$a</div></td>";
                                                    } else {
                                                        echo "<td style='text-align:center;background:#E34234;color:white;border-left-width: 0.1em;'><div class='td-fixed'>$a</div></td>";
                                                    }
                                                } else {
                                                    if (date('Ymj') == $selected_date . $a) {
                                                        echo "<td style='text-align:center;background:#007FFF;color:white;border-left-width: 0.1em;'><div class='td-fixed'>$a</div></td>";
                                                    } else {
                                                        echo "<td style='text-align:center;background:whitesmoke;border-left-width: 0.1em;'><div class='td-fixed'>$a</div></td>";
                                                    }
                                                }
                                            }
                                            if ($y == 4 && $z == 4) {
                                                if ($datesunday[$k] == $a || $datesunday[$k + 1] == $a || $datesunday[$k + 2] == $a || $datesunday[$k + 3] == $a || $datesaturday[$k] == $a || $datesaturday[$k + 1] == $a || $datesaturday[$k + 2] == $a || $datesaturday[$k + 3] == $a) {
                                                    if (date('Ymj') == $selected_date . $a) {
                                                        echo "<td style='text-align:center;background:#007FFF;color:white;border-left-width: 0.1em;'><div class='td-fixed'>$a</div></td>";
                                                    } else {
                                                        echo "<td style='text-align:center;background:#E34234;color:white;border-left-width: 0.1em;'><div class='td-fixed'>$a</div></td>";
                                                    }
                                                } else {
                                                    if (date('Ymj') == $selected_date . $a) {
                                                        echo "<td style='text-align:center;background:#007FFF;color:white;border-left-width: 0.1em;'><div class='td-fixed'>$a</div></td>";
                                                    } else {
                                                        echo "<td style='text-align:center;background:whitesmoke;border-left-width: 0.1em;'><div class='td-fixed'>$a</div></td>";
                                                    }
                                                }
                                            }
                                            if ($y == 5 && $z == 4) {
                                                if ($datesunday[$k] == $a || $datesunday[$k + 1] == $a || $datesunday[$k + 2] == $a || $datesunday[$k + 3] == $a || $datesunday[$k + 4] == $a || $datesaturday[$k] == $a || $datesaturday[$k + 1] == $a || $datesaturday[$k + 2] == $a || $datesaturday[$k + 3] == $a) {
                                                    if (date('Ymj') == $selected_date . $a) {
                                                        echo "<td style='text-align:center;background:#007FFF;color:white;border-left-width: 0.1em;'><div class='td-fixed'>$a</div></td>";
                                                    } else {
                                                        echo "<td style='text-align:center;background:#E34234;color:white;border-left-width: 0.1em;'><div class='td-fixed'>$a</div></td>";
                                                    }
                                                } else {
                                                    if (date('Ymj') == $selected_date . $a) {
                                                        echo "<td style='text-align:center;background:#007FFF;color:white;border-left-width: 0.1em;'><div class='td-fixed'>$a</div></td>";
                                                    } else {
                                                        echo "<td style='text-align:center;background:whitesmoke;border-left-width: 0.1em;'><div class='td-fixed'>$a</div></td>";
                                                    }
                                                }
                                            }
                                            if ($y == 4 && $z == 5) {
                                                if ($datesunday[$k] == $a || $datesunday[$k + 1] == $a || $datesunday[$k + 2] == $a || $datesunday[$k + 3] == $a || $datesaturday[$k] == $a || $datesaturday[$k + 1] == $a || $datesaturday[$k + 2] == $a || $datesaturday[$k + 3] == $a || $datesaturday[$k + 4] == $a) {
                                                    if (date('Ymj') == $selected_date . $a) {
                                                        echo "<td style='text-align:center;background:#007FFF;color:white;border-left-width: 0.1em;'><div class='td-fixed'>$a</div></td>";
                                                    } else {
                                                        echo "<td style='text-align:center;background:#E34234;color:white;border-left-width: 0.1em;'><div class='td-fixed'>$a</div></td>";
                                                    }
                                                } else {
                                                    if (date('Ymj') == $selected_date . $a) {
                                                        echo "<td style='text-align:center;background:#007FFF;color:white;border-left-width: 0.1em;'><div class='td-fixed'>$a</div></td>";
                                                    } else {
                                                        echo "<td style='text-align:center;background:whitesmoke;border-left-width: 0.1em;'><div class='td-fixed'>$a</div></td>";
                                                    }
                                                }
                                            }
                                        }
                                        ?>
                                    </tr>
                            </thead>
                            <tbody>
                                <?php
                                $date01 = 0;
                                $date02 = 0;
                                $date03 = 0;
                                $date04 = 0;
                                $date05 = 0;
                                $date06 = 0;
                                $date07 = 0;
                                $date08 = 0;
                                $date09 = 0;
                                $date10 = 0;
                                $date11 = 0;
                                $date12 = 0;
                                $date13 = 0;
                                $date14 = 0;
                                $date15 = 0;
                                $date16 = 0;
                                $date17 = 0;
                                $date18 = 0;
                                $date19 = 0;
                                $date20 = 0;
                                $date21 = 0;
                                $date22 = 0;
                                $date23 = 0;
                                $date24 = 0;
                                $date25 = 0;
                                $date26 = 0;
                                $date27 = 0;
                                $date28 = 0;
                                $date29 = 0;
                                $date30 = 0;
                                $date31 = 0;
                                $t = 1;
                                foreach ($data as $isi) {
                                    echo "<tr class='gradeX'>";
                                    echo "<td style=vertical-align: top;text-align: left;>$t</td>";
                                    echo "<td style=vertical-align: top;text-align: left;>$isi->CHR_PART_NO</td>";
                                    echo "<td style=vertical-align: top;text-align: left;>$isi->CHR_BACK_NO</td>";
                                    echo "<td style=vertical-align: top;text-align: left;>$isi->CHR_PART_NAME</td>"; ?>
                                    <td  style='text-align:center;border-left-width: 0.1em;border-right-width: 0;'><a href="<?php echo base_url('index.php/pes_new/report_noritsu_c/show_detail/'. $id_prod .'/'. $work_center.'/'.$selected_date.'01'.'/'.$isi->CHR_PART_NO); ?>"><?php echo $isi->DATE_01; ?></a></td>
                                    <td  style='text-align:center;border-left-width: 0.1em;border-right-width: 0;'><a href="<?php echo base_url('index.php/pes_new/report_noritsu_c/show_detail/'. $id_prod .'/'. $work_center.'/'.$selected_date.'02'.'/'.$isi->CHR_PART_NO); ?>"><?php echo $isi->DATE_02; ?></a></td>
                                    <td  style='text-align:center;border-left-width: 0.1em;border-right-width: 0;'><a href="<?php echo base_url('index.php/pes_new/report_noritsu_c/show_detail/'. $id_prod .'/'. $work_center.'/'.$selected_date.'03'.'/'.$isi->CHR_PART_NO); ?>"><?php echo $isi->DATE_03; ?></a></td>
                                    <td  style='text-align:center;border-left-width: 0.1em;border-right-width: 0;'><a href="<?php echo base_url('index.php/pes_new/report_noritsu_c/show_detail/'. $id_prod .'/'. $work_center.'/'.$selected_date.'04'.'/'.$isi->CHR_PART_NO); ?>"><?php echo $isi->DATE_04; ?></a></td>
                                    <td  style='text-align:center;border-left-width: 0.1em;border-right-width: 0;'><a href="<?php echo base_url('index.php/pes_new/report_noritsu_c/show_detail/'. $id_prod .'/'. $work_center.'/'.$selected_date.'05'.'/'.$isi->CHR_PART_NO); ?>"><?php echo $isi->DATE_05; ?></a></td>
                                    <td  style='text-align:center;border-left-width: 0.1em;border-right-width: 0;'><a href="<?php echo base_url('index.php/pes_new/report_noritsu_c/show_detail/'. $id_prod .'/'. $work_center.'/'.$selected_date.'06'.'/'.$isi->CHR_PART_NO); ?>"><?php echo $isi->DATE_06; ?></a></td>
                                    <td  style='text-align:center;border-left-width: 0.1em;border-right-width: 0;'><a href="<?php echo base_url('index.php/pes_new/report_noritsu_c/show_detail/'. $id_prod .'/'. $work_center.'/'.$selected_date.'07'.'/'.$isi->CHR_PART_NO); ?>"><?php echo $isi->DATE_07; ?></a></td>
                                    <td  style='text-align:center;border-left-width: 0.1em;border-right-width: 0;'><a href="<?php echo base_url('index.php/pes_new/report_noritsu_c/show_detail/'. $id_prod .'/'. $work_center.'/'.$selected_date.'08'.'/'.$isi->CHR_PART_NO); ?>"><?php echo $isi->DATE_08; ?></a></td>
                                    <td  style='text-align:center;border-left-width: 0.1em;border-right-width: 0;'><a href="<?php echo base_url('index.php/pes_new/report_noritsu_c/show_detail/'. $id_prod .'/'. $work_center.'/'.$selected_date.'09'.'/'.$isi->CHR_PART_NO); ?>"><?php echo $isi->DATE_09; ?></a></td>
                                    <td  style='text-align:center;border-left-width: 0.1em;border-right-width: 0;'><a href="<?php echo base_url('index.php/pes_new/report_noritsu_c/show_detail/'. $id_prod .'/'. $work_center.'/'.$selected_date.'10'.'/'.$isi->CHR_PART_NO); ?>"><?php echo $isi->DATE_10; ?></a></td>
                                    <td  style='text-align:center;border-left-width: 0.1em;border-right-width: 0;'><a href="<?php echo base_url('index.php/pes_new/report_noritsu_c/show_detail/'. $id_prod .'/'. $work_center.'/'.$selected_date.'11'.'/'.$isi->CHR_PART_NO); ?>"><?php echo $isi->DATE_11; ?></a></td>
                                    <td  style='text-align:center;border-left-width: 0.1em;border-right-width: 0;'><a href="<?php echo base_url('index.php/pes_new/report_noritsu_c/show_detail/'. $id_prod .'/'. $work_center.'/'.$selected_date.'12'.'/'.$isi->CHR_PART_NO); ?>"><?php echo $isi->DATE_12; ?></a></td>
                                    <td  style='text-align:center;border-left-width: 0.1em;border-right-width: 0;'><a href="<?php echo base_url('index.php/pes_new/report_noritsu_c/show_detail/'. $id_prod .'/'. $work_center.'/'.$selected_date.'13'.'/'.$isi->CHR_PART_NO); ?>"><?php echo $isi->DATE_13; ?></a></td>
                                    <td  style='text-align:center;border-left-width: 0.1em;border-right-width: 0;'><a href="<?php echo base_url('index.php/pes_new/report_noritsu_c/show_detail/'. $id_prod .'/'. $work_center.'/'.$selected_date.'14'.'/'.$isi->CHR_PART_NO); ?>"><?php echo $isi->DATE_14; ?></a></td>
                                    <td  style='text-align:center;border-left-width: 0.1em;border-right-width: 0;'><a href="<?php echo base_url('index.php/pes_new/report_noritsu_c/show_detail/'. $id_prod .'/'. $work_center.'/'.$selected_date.'15'.'/'.$isi->CHR_PART_NO); ?>"><?php echo $isi->DATE_15; ?></a></td>
                                    <td  style='text-align:center;border-left-width: 0.1em;border-right-width: 0;'><a href="<?php echo base_url('index.php/pes_new/report_noritsu_c/show_detail/'. $id_prod .'/'. $work_center.'/'.$selected_date.'16'.'/'.$isi->CHR_PART_NO); ?>"><?php echo $isi->DATE_16; ?></a></td>
                                    <td  style='text-align:center;border-left-width: 0.1em;border-right-width: 0;'><a href="<?php echo base_url('index.php/pes_new/report_noritsu_c/show_detail/'. $id_prod .'/'. $work_center.'/'.$selected_date.'17'.'/'.$isi->CHR_PART_NO); ?>"><?php echo $isi->DATE_17; ?></a></td>
                                    <td  style='text-align:center;border-left-width: 0.1em;border-right-width: 0;'><a href="<?php echo base_url('index.php/pes_new/report_noritsu_c/show_detail/'. $id_prod .'/'. $work_center.'/'.$selected_date.'18'.'/'.$isi->CHR_PART_NO); ?>"><?php echo $isi->DATE_18; ?></a></td>
                                    <td  style='text-align:center;border-left-width: 0.1em;border-right-width: 0;'><a href="<?php echo base_url('index.php/pes_new/report_noritsu_c/show_detail/'. $id_prod .'/'. $work_center.'/'.$selected_date.'19'.'/'.$isi->CHR_PART_NO); ?>"><?php echo $isi->DATE_19; ?></a></td>
                                    <td  style='text-align:center;border-left-width: 0.1em;border-right-width: 0;'><a href="<?php echo base_url('index.php/pes_new/report_noritsu_c/show_detail/'. $id_prod .'/'. $work_center.'/'.$selected_date.'20'.'/'.$isi->CHR_PART_NO); ?>"><?php echo $isi->DATE_20; ?></a></td>
                                    <td  style='text-align:center;border-left-width: 0.1em;border-right-width: 0;'><a href="<?php echo base_url('index.php/pes_new/report_noritsu_c/show_detail/'. $id_prod .'/'. $work_center.'/'.$selected_date.'21'.'/'.$isi->CHR_PART_NO); ?>"><?php echo $isi->DATE_21; ?></a></td>
                                    <td  style='text-align:center;border-left-width: 0.1em;border-right-width: 0;'><a href="<?php echo base_url('index.php/pes_new/report_noritsu_c/show_detail/'. $id_prod .'/'. $work_center.'/'.$selected_date.'22'.'/'.$isi->CHR_PART_NO); ?>"><?php echo $isi->DATE_22; ?></a></td>
                                    <td  style='text-align:center;border-left-width: 0.1em;border-right-width: 0;'><a href="<?php echo base_url('index.php/pes_new/report_noritsu_c/show_detail/'. $id_prod .'/'. $work_center.'/'.$selected_date.'23'.'/'.$isi->CHR_PART_NO); ?>"><?php echo $isi->DATE_23; ?></a></td>
                                    <td  style='text-align:center;border-left-width: 0.1em;border-right-width: 0;'><a href="<?php echo base_url('index.php/pes_new/report_noritsu_c/show_detail/'. $id_prod .'/'. $work_center.'/'.$selected_date.'24'.'/'.$isi->CHR_PART_NO); ?>"><?php echo $isi->DATE_24; ?></a></td>
                                    <td  style='text-align:center;border-left-width: 0.1em;border-right-width: 0;'><a href="<?php echo base_url('index.php/pes_new/report_noritsu_c/show_detail/'. $id_prod .'/'. $work_center.'/'.$selected_date.'25'.'/'.$isi->CHR_PART_NO); ?>"><?php echo $isi->DATE_25; ?></a></td>
                                    <td  style='text-align:center;border-left-width: 0.1em;border-right-width: 0;'><a href="<?php echo base_url('index.php/pes_new/report_noritsu_c/show_detail/'. $id_prod .'/'. $work_center.'/'.$selected_date.'26'.'/'.$isi->CHR_PART_NO); ?>"><?php echo $isi->DATE_26; ?></a></td>
                                    <td  style='text-align:center;border-left-width: 0.1em;border-right-width: 0;'><a href="<?php echo base_url('index.php/pes_new/report_noritsu_c/show_detail/'. $id_prod .'/'. $work_center.'/'.$selected_date.'27'.'/'.$isi->CHR_PART_NO); ?>"><?php echo $isi->DATE_27; ?></a></td>
                                    <td  style='text-align:center;border-left-width: 0.1em;border-right-width: 0;'><a href="<?php echo base_url('index.php/pes_new/report_noritsu_c/show_detail/'. $id_prod .'/'. $work_center.'/'.$selected_date.'28'.'/'.$isi->CHR_PART_NO); ?>"><?php echo $isi->DATE_28; ?></a></td>
                                    <td  style='text-align:center;border-left-width: 0.1em;border-right-width: 0;'><a href="<?php echo base_url('index.php/pes_new/report_noritsu_c/show_detail/'. $id_prod .'/'. $work_center.'/'.$selected_date.'29'.'/'.$isi->CHR_PART_NO); ?>"><?php echo $isi->DATE_29; ?></a></td>
                                    <td  style='text-align:center;border-left-width: 0.1em;border-right-width: 0;'><a href="<?php echo base_url('index.php/pes_new/report_noritsu_c/show_detail/'. $id_prod .'/'. $work_center.'/'.$selected_date.'30'.'/'.$isi->CHR_PART_NO); ?>"><?php echo $isi->DATE_30; ?></a></td>
                                    <td  style='text-align:center;border-left-width: 0.1em;border-right-width: 0;'><a href="<?php echo base_url('index.php/pes_new/report_noritsu_c/show_detail/'. $id_prod .'/'. $work_center.'/'.$selected_date.'31'.'/'.$isi->CHR_PART_NO); ?>"><?php echo $isi->DATE_31; ?></a></td>
                                    <td  style='text-align:center;border-left-width: 0.1em;border-right-width: 0;'><?php echo number_format($isi->INT_TOTAL) ?></td>
                                    </tr>
                                    
                                    <?php 
                                    																$date01 = $date01 +  $isi->DATE_01 ;
                                                                                                    $date02 = $date02 +  $isi->DATE_02 ;
                                                                                                    $date03 = $date03 +  $isi->DATE_03 ;
                                                                                                    $date04 = $date04 +  $isi->DATE_04 ;
                                                                                                    $date05 = $date05 +  $isi->DATE_05 ;
                                                                                                    $date06 = $date06 +  $isi->DATE_06 ;
                                                                                                    $date07 = $date07 +  $isi->DATE_07 ;
                                                                                                    $date08 = $date08 +  $isi->DATE_08 ;
                                                                                                    $date09 = $date09 +  $isi->DATE_09 ;
                                                                                                    $date10 = $date10 +  $isi->DATE_10 ;
                                                                                                    $date11 = $date11 +  $isi->DATE_11 ;
                                                                                                    $date12 = $date12 +  $isi->DATE_12 ;
                                                                                                    $date13 = $date13 +  $isi->DATE_13 ;
                                                                                                    $date14 = $date14 +  $isi->DATE_14 ;
                                                                                                    $date15 = $date15 +  $isi->DATE_15 ;
                                                                                                    $date16 = $date16 +  $isi->DATE_16 ;
                                                                                                    $date17 = $date17 +  $isi->DATE_17 ;
                                                                                                    $date18 = $date18 +  $isi->DATE_18 ;
                                                                                                    $date19 = $date19 +  $isi->DATE_19 ;
                                                                                                    $date20 = $date20 +  $isi->DATE_20 ;
                                                                                                    $date21 = $date21 +  $isi->DATE_21 ;
                                                                                                    $date22 = $date22 +  $isi->DATE_22 ;
                                                                                                    $date23 = $date23 +  $isi->DATE_23 ;
                                                                                                    $date24 = $date24 +  $isi->DATE_24 ;
                                                                                                    $date25 = $date25 +  $isi->DATE_25 ;
                                                                                                    $date26 = $date26 +  $isi->DATE_26 ;
                                                                                                    $date27 = $date27 +  $isi->DATE_27 ;
                                                                                                    $date28 = $date28 +  $isi->DATE_28 ;
                                                                                                    $date29 = $date29 +  $isi->DATE_29 ;
                                                                                                    $date30 = $date30 +  $isi->DATE_30 ;
                                                                                                    $date31 = $date31 +  $isi->DATE_31 ;	
                                    $t++;
                                }
                                ?>

                                    <tr class='gradeX'>
                                    <td style=vertical-align: top;text-align: left;><?php echo $t ?></td>
                                    <td style=vertical-align: top;text-align: left;>AVERAGE</td>
                                    <td style=vertical-align: top;text-align: left;></td>
                                    <td style=vertical-align: top;text-align: left;></td>
                                    <td style=vertical-align: top;text-align: left;><?php echo round($date01/($t-1),2) ?></td>
                                    <td style=vertical-align: top;text-align: left;><?php echo round($date02/($t-1),2) ?></td>
                                    <td style=vertical-align: top;text-align: left;><?php echo round($date03/($t-1),2) ?></td>
                                    <td style=vertical-align: top;text-align: left;><?php echo round($date04/($t-1),2) ?></td>
                                    <td style=vertical-align: top;text-align: left;><?php echo round($date05/($t-1),2) ?></td>
                                    <td style=vertical-align: top;text-align: left;><?php echo round($date06/($t-1),2) ?></td>
                                    <td style=vertical-align: top;text-align: left;><?php echo round($date07/($t-1),2) ?></td>
                                    <td style=vertical-align: top;text-align: left;><?php echo round($date08/($t-1),2) ?></td>
                                    <td style=vertical-align: top;text-align: left;><?php echo round($date09/($t-1),2) ?></td>
                                    <td style=vertical-align: top;text-align: left;><?php echo round($date10/($t-1),2) ?></td>
                                    <td style=vertical-align: top;text-align: left;><?php echo round($date11/($t-1),2) ?></td>
                                    <td style=vertical-align: top;text-align: left;><?php echo round($date12/($t-1),2) ?></td>
                                    <td style=vertical-align: top;text-align: left;><?php echo round($date13/($t-1),2) ?></td>
                                    <td style=vertical-align: top;text-align: left;><?php echo round($date14/($t-1),2) ?></td>
                                    <td style=vertical-align: top;text-align: left;><?php echo round($date15/($t-1),2) ?></td>
                                    <td style=vertical-align: top;text-align: left;><?php echo round($date16/($t-1),2) ?></td>
                                    <td style=vertical-align: top;text-align: left;><?php echo round($date17/($t-1),2) ?></td>
                                    <td style=vertical-align: top;text-align: left;><?php echo round($date18/($t-1),2) ?></td>
                                    <td style=vertical-align: top;text-align: left;><?php echo round($date19/($t-1),2) ?></td>
                                    <td style=vertical-align: top;text-align: left;><?php echo round($date20/($t-1),2) ?></td>
                                    <td style=vertical-align: top;text-align: left;><?php echo round($date21/($t-1),2) ?></td>
                                    <td style=vertical-align: top;text-align: left;><?php echo round($date22/($t-1),2) ?></td>
                                    <td style=vertical-align: top;text-align: left;><?php echo round($date23/($t-1),2) ?></td>
                                    <td style=vertical-align: top;text-align: left;><?php echo round($date24/($t-1),2) ?></td>
                                    <td style=vertical-align: top;text-align: left;><?php echo round($date25/($t-1),2) ?></td>
                                    <td style=vertical-align: top;text-align: left;><?php echo round($date26/($t-1),2) ?></td>
                                    <td style=vertical-align: top;text-align: left;><?php echo round($date27/($t-1),2) ?></td>
                                    <td style=vertical-align: top;text-align: left;><?php echo round($date28/($t-1),2) ?></td>
                                    <td style=vertical-align: top;text-align: left;><?php echo round($date29/($t-1),2) ?></td>
                                    <td style=vertical-align: top;text-align: left;><?php echo round($date30/($t-1),2) ?></td>
                                    <td style=vertical-align: top;text-align: left;><?php echo round($date31/($t-1),2) ?></td>
                                    <td></td>
                                    </tr> 

                            </tbody>
                        </table>

                        <table id="exportToExcel" class="table table-striped table-condensed table-hover display" cellspacing="0" width="100%" style="display:none;">
                        <thead>
                                <tr class='gradeX'>
                                    <th rowspan='2' style=text-align:center;>#</th>
                                    <th rowspan='2' style=text-align:center;>Part No </th>
                                    <th rowspan='2' style=text-align:center;>Back No </th>
                                    <th rowspan='2' style=text-align:center;>Part Name </th>
                                    <th colspan='31' style=text-align:center;>Date </th>
                                    <th rowspan='2' style=text-align:center;>AVG </th>
                                </tr>
                                <tr class='gradeX'>
                                <?php
                                for ($x = 1; $x <= 31; $x++) {
                                    echo "<td>$x</td>";
                                }
                                ?>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                $t = 1;
                                foreach ($data as $isi) {
                                    echo "<tr class='gradeX'>";
                                    echo "<td style=vertical-align: top;text-align: left;>$t</td>";
                                    echo "<td style=vertical-align: top;text-align: left;>$isi->CHR_PART_NO</td>";
                                    echo "<td style=vertical-align: top;text-align: left;>$isi->CHR_BACK_NO</td>";
                                    echo "<td style=vertical-align: top;text-align: left;>$isi->CHR_PART_NAME</td>"; ?>
                                    <td><a href="<?php echo base_url('index.php/pes_new/report_noritsu_c/show_detail/'. $id_prod .'/'. $work_center.'/'.$selected_date.'01'.'/'.$isi->CHR_PART_NO); ?>"><?php echo $isi->DATE_01; ?></a>
                                    <td><a href="<?php echo base_url('index.php/pes_new/report_noritsu_c/show_detail/'. $id_prod .'/'. $work_center.'/'.$selected_date.'02'.'/'.$isi->CHR_PART_NO); ?>"><?php echo $isi->DATE_02; ?></a>
                                    <td><a href="<?php echo base_url('index.php/pes_new/report_noritsu_c/show_detail/'. $id_prod .'/'. $work_center.'/'.$selected_date.'03'.'/'.$isi->CHR_PART_NO); ?>"><?php echo $isi->DATE_03; ?></a>
                                    <td><a href="<?php echo base_url('index.php/pes_new/report_noritsu_c/show_detail/'. $id_prod .'/'. $work_center.'/'.$selected_date.'04'.'/'.$isi->CHR_PART_NO); ?>"><?php echo $isi->DATE_04; ?></a>
                                    <td><a href="<?php echo base_url('index.php/pes_new/report_noritsu_c/show_detail/'. $id_prod .'/'. $work_center.'/'.$selected_date.'05'.'/'.$isi->CHR_PART_NO); ?>"><?php echo $isi->DATE_05; ?></a>
                                    <td><a href="<?php echo base_url('index.php/pes_new/report_noritsu_c/show_detail/'. $id_prod .'/'. $work_center.'/'.$selected_date.'06'.'/'.$isi->CHR_PART_NO); ?>"><?php echo $isi->DATE_06; ?></a>
                                    <td><a href="<?php echo base_url('index.php/pes_new/report_noritsu_c/show_detail/'. $id_prod .'/'. $work_center.'/'.$selected_date.'07'.'/'.$isi->CHR_PART_NO); ?>"><?php echo $isi->DATE_07; ?></a>
                                    <td><a href="<?php echo base_url('index.php/pes_new/report_noritsu_c/show_detail/'. $id_prod .'/'. $work_center.'/'.$selected_date.'08'.'/'.$isi->CHR_PART_NO); ?>"><?php echo $isi->DATE_08; ?></a>
                                    <td><a href="<?php echo base_url('index.php/pes_new/report_noritsu_c/show_detail/'. $id_prod .'/'. $work_center.'/'.$selected_date.'09'.'/'.$isi->CHR_PART_NO); ?>"><?php echo $isi->DATE_09; ?></a>
                                    <td><a href="<?php echo base_url('index.php/pes_new/report_noritsu_c/show_detail/'. $id_prod .'/'. $work_center.'/'.$selected_date.'10'.'/'.$isi->CHR_PART_NO); ?>"><?php echo $isi->DATE_10; ?></a>
                                    <td><a href="<?php echo base_url('index.php/pes_new/report_noritsu_c/show_detail/'. $id_prod .'/'. $work_center.'/'.$selected_date.'11'.'/'.$isi->CHR_PART_NO); ?>"><?php echo $isi->DATE_11; ?></a>
                                    <td><a href="<?php echo base_url('index.php/pes_new/report_noritsu_c/show_detail/'. $id_prod .'/'. $work_center.'/'.$selected_date.'12'.'/'.$isi->CHR_PART_NO); ?>"><?php echo $isi->DATE_12; ?></a>
                                    <td><a href="<?php echo base_url('index.php/pes_new/report_noritsu_c/show_detail/'. $id_prod .'/'. $work_center.'/'.$selected_date.'13'.'/'.$isi->CHR_PART_NO); ?>"><?php echo $isi->DATE_13; ?></a>
                                    <td><a href="<?php echo base_url('index.php/pes_new/report_noritsu_c/show_detail/'. $id_prod .'/'. $work_center.'/'.$selected_date.'14'.'/'.$isi->CHR_PART_NO); ?>"><?php echo $isi->DATE_14; ?></a>
                                    <td><a href="<?php echo base_url('index.php/pes_new/report_noritsu_c/show_detail/'. $id_prod .'/'. $work_center.'/'.$selected_date.'15'.'/'.$isi->CHR_PART_NO); ?>"><?php echo $isi->DATE_15; ?></a>
                                    <td><a href="<?php echo base_url('index.php/pes_new/report_noritsu_c/show_detail/'. $id_prod .'/'. $work_center.'/'.$selected_date.'16'.'/'.$isi->CHR_PART_NO); ?>"><?php echo $isi->DATE_16; ?></a>
                                    <td><a href="<?php echo base_url('index.php/pes_new/report_noritsu_c/show_detail/'. $id_prod .'/'. $work_center.'/'.$selected_date.'17'.'/'.$isi->CHR_PART_NO); ?>"><?php echo $isi->DATE_17; ?></a>
                                    <td><a href="<?php echo base_url('index.php/pes_new/report_noritsu_c/show_detail/'. $id_prod .'/'. $work_center.'/'.$selected_date.'18'.'/'.$isi->CHR_PART_NO); ?>"><?php echo $isi->DATE_18; ?></a>
                                    <td><a href="<?php echo base_url('index.php/pes_new/report_noritsu_c/show_detail/'. $id_prod .'/'. $work_center.'/'.$selected_date.'19'.'/'.$isi->CHR_PART_NO); ?>"><?php echo $isi->DATE_19; ?></a>
                                    <td><a href="<?php echo base_url('index.php/pes_new/report_noritsu_c/show_detail/'. $id_prod .'/'. $work_center.'/'.$selected_date.'20'.'/'.$isi->CHR_PART_NO); ?>"><?php echo $isi->DATE_20; ?></a>
                                    <td><a href="<?php echo base_url('index.php/pes_new/report_noritsu_c/show_detail/'. $id_prod .'/'. $work_center.'/'.$selected_date.'21'.'/'.$isi->CHR_PART_NO); ?>"><?php echo $isi->DATE_21; ?></a>
                                    <td><a href="<?php echo base_url('index.php/pes_new/report_noritsu_c/show_detail/'. $id_prod .'/'. $work_center.'/'.$selected_date.'22'.'/'.$isi->CHR_PART_NO); ?>"><?php echo $isi->DATE_22; ?></a>
                                    <td><a href="<?php echo base_url('index.php/pes_new/report_noritsu_c/show_detail/'. $id_prod .'/'. $work_center.'/'.$selected_date.'23'.'/'.$isi->CHR_PART_NO); ?>"><?php echo $isi->DATE_23; ?></a>
                                    <td><a href="<?php echo base_url('index.php/pes_new/report_noritsu_c/show_detail/'. $id_prod .'/'. $work_center.'/'.$selected_date.'24'.'/'.$isi->CHR_PART_NO); ?>"><?php echo $isi->DATE_24; ?></a>
                                    <td><a href="<?php echo base_url('index.php/pes_new/report_noritsu_c/show_detail/'. $id_prod .'/'. $work_center.'/'.$selected_date.'25'.'/'.$isi->CHR_PART_NO); ?>"><?php echo $isi->DATE_25; ?></a>
                                    <td><a href="<?php echo base_url('index.php/pes_new/report_noritsu_c/show_detail/'. $id_prod .'/'. $work_center.'/'.$selected_date.'26'.'/'.$isi->CHR_PART_NO); ?>"><?php echo $isi->DATE_26; ?></a>
                                    <td><a href="<?php echo base_url('index.php/pes_new/report_noritsu_c/show_detail/'. $id_prod .'/'. $work_center.'/'.$selected_date.'27'.'/'.$isi->CHR_PART_NO); ?>"><?php echo $isi->DATE_27; ?></a>
                                    <td><a href="<?php echo base_url('index.php/pes_new/report_noritsu_c/show_detail/'. $id_prod .'/'. $work_center.'/'.$selected_date.'28'.'/'.$isi->CHR_PART_NO); ?>"><?php echo $isi->DATE_28; ?></a>
                                    <td><a href="<?php echo base_url('index.php/pes_new/report_noritsu_c/show_detail/'. $id_prod .'/'. $work_center.'/'.$selected_date.'29'.'/'.$isi->CHR_PART_NO); ?>"><?php echo $isi->DATE_29; ?></a>
                                    <td><a href="<?php echo base_url('index.php/pes_new/report_noritsu_c/show_detail/'. $id_prod .'/'. $work_center.'/'.$selected_date.'30'.'/'.$isi->CHR_PART_NO); ?>"><?php echo $isi->DATE_30; ?></a>
                                    <td><a href="<?php echo base_url('index.php/pes_new/report_noritsu_c/show_detail/'. $id_prod .'/'. $work_center.'/'.$selected_date.'31'.'/'.$isi->CHR_PART_NO); ?>"><?php echo $isi->DATE_31; ?></a>
                                    <td><?php echo number_format($isi->INT_TOTAL) ?></td>
                                    </tr>
                                    <?php $t++;
                                }
                                ?>
                            </tbody>
                        </table>

                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-md-12">
                <div class="grid">
                    <div class="grid-header">
                        <i class="fa fa-th-large"></i>
                        <span class="grid-title"><strong>REPORT DETAIL NORITSU</strong></span>
                        <div class="pull-right grid-tools">
                            <a data-widget="collapse" title="Collapse"><i class="fa fa-chevron-up"></i></a>
                                <a data-widget="reload" title="Reload"><i class="fa fa-refresh"></i></a>
                                <a data-widget="remove" title="Remove"><i class="fa fa-times"></i></a>
                        </div>
                    </div>
                    <div class="grid-body">
                    <div class="pull">
                    <table width="100%" id='filter' border=0px>
                                <tr>
                                    <td width="10%"></td>
                                    <td width="10%"></td>
                                    <td width="10%"></td>
                                    <td width="10%"></td>
                                    <td width="60%"></td>
                                <tr>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                    <td style="text-align:right;">
                                        <input type="button" class="btn btn-primary" onclick="tableToExcel('exportToExcel2', 'Summary Noritsu')" value="Export to Excel">
                                    </td>

                                </tr>
                            </table>
                        </div>
                        
                        <div id="table-luar">
                        <table id="example1" class="table table-condensed table-bordered table-striped table-hover display" cellspacing="0" width="100%">
                            <thead>
                                <tr class='gradeX'>
                                    <th rowspan='2' style=text-align:center;>#</th>
                                    <th rowspan='2' style=text-align:center;>Part No </th>
                                    <th rowspan='2' style=text-align:center;>Back No </th>
                                    <th rowspan='2' style=text-align:center;>Part Name </th>
                                    <th rowspan='2' style=text-align:center;>PRD Result </th>
                                    <th rowspan='2' style=text-align:center;>Noritsu </th>
                                    <th colspan='4' style=text-align:center;>Man Minutes </th>
                                </tr>
                                <tr class='gradeX'>
                                    <td>PRD</td>
                                    <td>MH</td>
                                    <td>QUA</td>
                                    <td>MTE</td>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                $t = 1;
                                $total_man_minutes = 0;
                                $total_noritsu_mh = 0;
                                $total_noritsu_mprd = 0;
                                $total_noritsu_qua = 0;
                                $total_noritsu_mte = 0;
                                foreach ($data_detail as $isi) {
                                    echo "<tr class='gradeX'>";
                                    echo "<td style=vertical-align: top;text-align: left;>$t</td>";
                                    echo "<td style=vertical-align: top;text-align: left;>$isi->CHR_PART_NO</td>";
                                    echo "<td style=vertical-align: top;text-align: left;>$isi->CHR_BACK_NO</td>";
                                    echo "<td style=vertical-align: top;text-align: left;>$isi->CHR_PART_NAME</td>";
                                    echo "<td style=vertical-align: top;text-align: left;>$isi->INT_TOTAL_QTY</td>";
                                    echo "<td style=vertical-align: top;text-align: left;>$isi->TOTAL</td>";
                                    echo "<td style=vertical-align: top;text-align: left;>$isi->INT_DURASI_MPRD</td>";
                                    echo "<td style=vertical-align: top;text-align: left;>$isi->INT_DURASI_MMH</td>";
                                    echo "<td style=vertical-align: top;text-align: left;>$isi->INT_DURASI_QUA</td>";
                                    echo "<td style=vertical-align: top;text-align: left;>$isi->INT_DURASI_MTE</td>"; 
                                    $total_man_minutes = $total_man_minutes + $isi->TOTAL;
                                    $total_noritsu_mh = $total_noritsu_mh + $isi->INT_DURASI_MMH;
                                    $total_noritsu_mprd = $total_noritsu_mprd + $isi->INT_DURASI_MPRD;
                                    $total_noritsu_qua = $total_noritsu_qua + $isi->INT_DURASI_QUA;
                                    $total_noritsu_mte = $total_noritsu_mte + $isi->INT_DURASI_MTE;
                                    ?>
                                    </tr>
                                    <?php $t++;
                                }
                                ?>
                                    <tr class='gradeX'>
                                    <td style=vertical-align: top;text-align: left;>AVERAGE</td>
                                    <td style=vertical-align: top;text-align: left;></td>
                                    <td style=vertical-align: top;text-align: left;></td>
                                    <td style=vertical-align: top;text-align: left;></td>
                                    <td style=vertical-align: top;text-align: left;></td>
                                    <td style=vertical-align: top;text-align: left;><?php echo round($total_man_minutes/($t-1),2) ?></td>
                                    <td style=vertical-align: top;text-align: left;><?php echo round($total_noritsu_mprd/($t-1),2) ?></td>
                                    <td style=vertical-align: top;text-align: left;><?php echo round($total_noritsu_mh/($t-1),2) ?></td>
                                    <td style=vertical-align: top;text-align: left;><?php echo round($total_noritsu_qua/($t-1),2) ?></td>
                                    <td style=vertical-align: top;text-align: left;><?php echo round($total_noritsu_mte/($t-1),2) ?></td> 
                                    </tr>
                            </tbody>
                            
                        </table>

                        
                        <table id="exportToExcel2" class="table table-striped table-condensed table-hover display" cellspacing="0" width="100%" style="display:none;">
                        <thead>
                                <tr class='gradeX'>
                                    <th rowspan='2' style=text-align:center;>#</th>
                                    <th rowspan='2' style=text-align:center;>Part No </th>
                                    <th rowspan='2' style=text-align:center;>Back No </th>
                                    <th rowspan='2' style=text-align:center;>Part Name </th>
                                    <th rowspan='2' style=text-align:center;>PRD Result </th>
                                    <th rowspan='2' style=text-align:center;>Noritsu </th>
                                    <th colspan='4' style=text-align:center;>Man Minutes </th>
                                </tr>
                                <tr class='gradeX'>
                                    <td>PRD</td>
                                    <td>MH</td>
                                    <td>QUA</td>
                                    <td>MTE</td>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                $t = 1;
                                foreach ($data_detail as $isi) {
                                    echo "<tr class='gradeX'>";
                                    echo "<td style=vertical-align: top;text-align: left;>$t</td>";
                                    echo "<td style=vertical-align: top;text-align: left;>$isi->CHR_PART_NO</td>";
                                    echo "<td style=vertical-align: top;text-align: left;>$isi->CHR_BACK_NO</td>";
                                    echo "<td style=vertical-align: top;text-align: left;>$isi->CHR_PART_NAME</td>";
                                    echo "<td style=vertical-align: top;text-align: left;>$isi->INT_TOTAL_QTY</td>";
                                    echo "<td style=vertical-align: top;text-align: left;>$isi->TOTAL</td>";
                                    echo "<td style=vertical-align: top;text-align: left;>$isi->INT_DURASI_MPRD</td>";
                                    echo "<td style=vertical-align: top;text-align: left;>$isi->INT_DURASI_MMH</td>";
                                    echo "<td style=vertical-align: top;text-align: left;>$isi->INT_DURASI_QUA</td>";
                                    echo "<td style=vertical-align: top;text-align: left;>$isi->INT_DURASI_MTE</td>"; ?>
                                    </tr>
                                    <?php $t++;
                                }
                                ?>
                            </tbody>
                            
                        </table>

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
                                        var table = $('#example').DataTable({
                                        scrollY: "400px",
                                                scrollX: true,
                                                scrollCollapse: true,
                                                paging: false,
                                                bFilter: true,
                                                fixedColumns: {
                                                leftColumns: 3
                                                }
                                        });
                                        });



</script>
<script>
                                        $(document).ready(function () {
                                        var table = $('#example1').DataTable({
                                        scrollY: "350px",
                                                scrollX: true,
                                                scrollCollapse: true,
                                                paging: false,
                                                bFilter: true,
                                                fixedColumns: {
                                                leftColumns: 2
                                                }
                                        });
                                        });
</script>