
<script>
    setTimeout(function () {
        document.getElementById("hide-sub-menus").click();
    }, 30);
</script>
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
            var ctx = {worksheet: name || 'Worksheet', table: table.innerHTML}
            window.location.href = uri + base64(format(template, ctx))
        }
    })()
</script>
<!-- <script>
    $(document).ready(function () {
        var table = $('#dataTables1').DataTable({
            processing: true
        });

        $('#btn_refresh').on('click', function () {
            $(".dataTables_processing").show();
            setTimeout(function () {

                table.draw();
                $(".dataTables_processing").hide();
            }, 1000);
        });

    });
</script> -->

<style type="text/css">
    th, td { white-space: nowrap; }
    div.dataTables_wrapper {
        margin: 0 auto;
    }
    #table-luar{
        font-size: 12px;
    }
    #filter { 
        border-spacing: 10px;
        border-collapse: separate;
    }
    .td-fixed{
        width: 30px;
    }
    .td-no{
        width: 10px;
    }
    .ddl{
        width: 100px;
        height: 30px;
    }
    .ddl2{
        width: 180px;
        height: 30px;
    }

    .legend {
        padding: 15px;
        margin-top: 5px;
        margin-bottom: 5px;
        /* border: 1px solid transparent; */
        /* border-radius: 4px; */
        /* border-left-width: 0.4em;
        border-left-color: #bce8f1; */
    }

    .legend-info {
        color: #31708f;
        background-color: #d9edf7;
        /* border-color: #bce8f1; */
        border-left-width: 0.4em;
        border-left-color: #bce8f1;
}
</style>
<aside class="right-side">
    <section class="content-header">
        <ol class="breadcrumb">
            <li><a href="<?php echo base_url('index.php/home_c/"') ?>">Home</a></li>
            <li><a href="<?php echo base_url('index.php/portal/eform_c/weekly_report"') ?>"><strong>Month Healthy</strong></a></li>
        </ol>
    </section>

    <section class="content">
        

        <div class="row">
            <div class="col-md-12">
                <div class="grid">
                    <div class="grid-header">
                        <i class="fa fa-th-large"></i>
                        <span class="grid-title"><strong>MONTH REPORT HEALTHY MP</strong></span>
                       
                    </div>
                    <!-- </?php print_r ($selected_date); exit(); ?> -->

                    <div class="grid-body" style="padding-top: 10px">
                        <?php echo form_open('', 'class="form-horizontal"'); ?>
                        <table width="100%" id='filter' border=0px style="margin-bottom: 0px;">
                            
                            <tr>
                            <td width="5%">Dept</td>
                                    <td width="35%">
                                    <?php $session = $this->session->all_userdata(); ?>
                                    <?php if ($session['ROLE'] === 1  || $session['ROLE'] === 3 || $session['ROLE'] === 2 || $session['ROLE'] === 4) { ?>
                                        <select id="e1" name="CHR_DEPT_FIL" class="form-control" >
                                            <option value="">-- Pilih Dept --</option>
                                            <option value="ALL">All Dept</option>
                                        <?php
                                            foreach ($getdept as $key) {
                                                if($key->CHR_DEPT == $dept) {
                                            ?>
                                                    <option value="<?php echo $key->CHR_DEPT; ?>" selected><?php echo $key->CHR_DEPT ." - ". $key->CHR_DEPT_DESC; ?></option>
                                            <?php
                                                } else {
                                            ?>
                                                    <option value="<?php echo $key->CHR_DEPT; ?>"><?php echo $key->CHR_DEPT ." - ". $key->CHR_DEPT_DESC; ?></option>
                                            <?php
                                                }
                                            }
                                        ?>
                                        </select>
                                    <?php } else {?>
                                        <select id="e1" name="CHR_DEPT_FIL" class="form-control" >
                                            <option value="">-- Pilih Dept --</option>
                                        <?php
                                            foreach ($getdept as $key) {
                                                if($key->CHR_DEPT == $dept) {
                                            ?>
                                                    <option value="<?php echo $key->CHR_DEPT; ?>" selected><?php echo $key->CHR_DEPT ." - ". $key->CHR_DEPT_DESC; ?></option>
                                            <?php
                                                } else {
                                            ?>
                                                    <option value="<?php echo $key->CHR_DEPT; ?>"><?php echo $key->CHR_DEPT ." - ". $key->CHR_DEPT_DESC; ?></option>
                                            <?php
                                                }
                                            }
                                        ?>
                                        </select>
                                    <?php } ?>
                                    </td>
                                    <!-- <td width="5%"></td> -->
                                    <!-- <td width="5%"> -->
                                    </td>
                                    <td width="65%">
                                    <button type="submit" class="btn btn-primary" name="filter" value="1"><span class="fa fa-filter"></span>&nbsp;&nbsp;Filter</button>
                                    </td>
                                <!-- <td style="text-align:right;">
                                    
                                    <input type="button" onclick="tableToExcel('exportToExcel', 'W3C Example Table')" value="Expor to Excel" class="btn btn-primary">
                                </td> -->
                            </tr>
                            <tr>
                            <td width="5%">Month</td>
                                <td width="17%">
                                    <select class="ddl2" name="CHR_DATE" id="CHR_DATE">
                                        <?php for ($x = -7; $x <= 0; $x++) { $y = $x * 28 ?>                                        
                                            <option value="<?php echo date("Ym", strtotime("+$x month")); ?>" <?php
                                                if ($selected_date == date("Ym", strtotime("+$x month"))) {
                                                    echo 'SELECTED';
                                                }
                                                ?> > <?php echo date("M Y", strtotime("+$x month")); ?>
                                        <?php } ?>
                                    </select>
                                </td>
                                <td width="3%">
                                <!-- <button type="submit" class="btn btn-primary" name="filter" value="1"><span class="fa fa-filter"></span>&nbsp;&nbsp;Filter</button> -->
                                    <!-- to -->
                                </td>
                                <td width="10%" style="text-align:right;">
                                    <!-- <input name="CHR_DATE_TO" id="datepicker" class="form-control" autocomplete="off" required type="text" style="width:180px;" value="<?php echo date("d-m-Y", strtotime($date_to)); ?>"> -->
                                </td>
                                <td width="55%" >
                                <!-- <button type="submit" class="btn btn-primary" name="filter" value="1"><span class="fa fa-filter"></span>&nbsp;&nbsp;Filter</button> -->
                                </td>
                            </tr>
                        </table>
                        <?php form_close(); ?>

                        <div id="table-luar">
                        <table id="example" class="table table-condensed table-bordered table-striped table-hover display" cellspacing="0" width="100%">
                                <thead>
                                    <tr class='gradeX'>
                                        <th  style='text-align:center;'>No</th>
                                        <th  style='text-align:center;'>NPK</th>
                                        <th  style='text-align:center;'>Nama</th>
                                        <th style='text-align:center;'>Dept</th>
                                        <th style='text-align:center;'>1</th>
                                        <th style='text-align:center;'>2</th>
                                        <th style='text-align:center;'>3</th>
                                        <th style='text-align:center;'>4</th>
                                        <th style='text-align:center;'>5</th>
                                        <th style='text-align:center;'>6</th>
                                        <th style='text-align:center;'>7</th>
                                        <th style='text-align:center;'>8</th>
                                        <th style='text-align:center;'>9</th>
                                        <th style='text-align:center;'>10</th>
                                        <th style='text-align:center;'>11</th>
                                        <th style='text-align:center;'>12</th>
                                        <th style='text-align:center;'>13</th>
                                        <th style='text-align:center;'>14</th>
                                        <th style='text-align:center;'>15</th>
                                        <th style='text-align:center;'>16</th>
                                        <th style='text-align:center;'>17</th>
                                        <th style='text-align:center;'>18</th>
                                        <th style='text-align:center;'>19</th>
                                        <th style='text-align:center;'>20</th>
                                        <th style='text-align:center;'>21</th>
                                        <th style='text-align:center;'>22</th>
                                        <th style='text-align:center;'>23</th>
                                        <th style='text-align:center;'>24</th>
                                        <th style='text-align:center;'>25</th>
                                        <th style='text-align:center;'>26</th>
                                        <th style='text-align:center;'>27</th>
                                        <th style='text-align:center;'>28</th>
                                        <th style='text-align:center;'>29</th>
                                        <th style='text-align:center;'>30</th>
                                        <th style='text-align:center;'>31</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                        if($dt_week == 'NULL'){

                                        }else{
                                        $r = 1;
                                        foreach ($dt_week as $isi) {
                                            echo "<tr class='gradeX'>";
                                            echo "<td style='text-align:center;'>$r</td>";
                                            echo "<td style='text-align:center;'>$isi->npk</td>";
                                            echo "<td style='text-align:left;'>$isi->username</td>";
                                            echo "<td style='text-align:center;'>$isi->dept</td>";
                                            ?>
                                            <?php if ($isi->t_1=='0') {?>
                                                <td style='text-align:center;'><img src="<?php echo base_url() . "/assets/img/check1.png" ?>" width="25"></td>
                                            <?php } elseif ($isi->t_1=='') {?>
                                                <td style='text-align:center;'><strong>-</strong></td>
                                            <?php } else { ?>
                                                <td style='text-align:center;'><img src="<?php echo base_url() . "/assets/img/error1.png" ?>" width="25"></td>
                                            <?php } ?>
                                            <?php if ($isi->t_2=='0') {?>
                                                <td style='text-align:center;'><img src="<?php echo base_url() . "/assets/img/check1.png" ?>" width="25"></td>
                                            <?php } elseif ($isi->t_2=='') {?>
                                                <td style='text-align:center;'><strong>-</strong></td>
                                            <?php } else { ?>
                                                <td style='text-align:center;'><img src="<?php echo base_url() . "/assets/img/error1.png" ?>" width="25"></td>
                                            <?php } ?>
                                            <?php if ($isi->t_3=='0') {?>
                                                <td style='text-align:center;'><img src="<?php echo base_url() . "/assets/img/check1.png" ?>" width="25"></td>
                                            <?php } elseif ($isi->t_3=='') {?>
                                                <td style='text-align:center;'><strong>-</strong></td>
                                            <?php } else { ?>
                                                <td style='text-align:center;'><img src="<?php echo base_url() . "/assets/img/error1.png" ?>" width="25"></td>
                                            <?php } ?>
                                            <?php if ($isi->t_4=='0') {?>
                                                <td style='text-align:center;'><img src="<?php echo base_url() . "/assets/img/check1.png" ?>" width="25"></td>
                                            <?php } elseif ($isi->t_4=='') {?>
                                                <td style='text-align:center;'><strong>-</strong></td>
                                            <?php } else { ?>
                                                <td style='text-align:center;'><img src="<?php echo base_url() . "/assets/img/error1.png" ?>" width="25"></td>
                                            <?php } ?>
                                            <?php if ($isi->t_5=='0') {?>
                                                <td style='text-align:center;'><img src="<?php echo base_url() . "/assets/img/check1.png" ?>" width="25"></td>
                                            <?php } elseif ($isi->t_5=='') {?>
                                                <td style='text-align:center;'><strong>-</strong></td>
                                            <?php } else { ?>
                                                <td style='text-align:center;'><img src="<?php echo base_url() . "/assets/img/error1.png" ?>" width="25"></td>
                                            <?php } ?>
                                            <?php if ($isi->t_6=='0') {?>
                                                <td style='text-align:center;'><img src="<?php echo base_url() . "/assets/img/check1.png" ?>" width="25"></td>
                                            <?php } elseif ($isi->t_6=='') {?>
                                                <td style='text-align:center;'><strong>-</strong></td>
                                            <?php } else { ?>
                                                <td style='text-align:center;'><img src="<?php echo base_url() . "/assets/img/error1.png" ?>" width="25"></td>
                                            <?php } ?>
                                            <?php if ($isi->t_7=='0') {?>
                                                <td style='text-align:center;'><img src="<?php echo base_url() . "/assets/img/check1.png" ?>" width="25"></td>
                                            <?php } elseif ($isi->t_7=='') {?>
                                                <td style='text-align:center;'><strong>-</strong></td>
                                            <?php } else { ?>
                                                <td style='text-align:center;'><img src="<?php echo base_url() . "/assets/img/error1.png" ?>" width="25"></td>
                                            <?php } ?>
                                            <?php if ($isi->t_8=='0') {?>
                                                <td style='text-align:center;'><img src="<?php echo base_url() . "/assets/img/check1.png" ?>" width="25"></td>
                                            <?php } elseif ($isi->t_8=='') {?>
                                                <td style='text-align:center;'><strong>-</strong></td>
                                            <?php } else { ?>
                                                <td style='text-align:center;'><img src="<?php echo base_url() . "/assets/img/error1.png" ?>" width="25"></td>
                                            <?php } ?>
                                            <?php if ($isi->t_9=='0') {?>
                                                <td style='text-align:center;'><img src="<?php echo base_url() . "/assets/img/check1.png" ?>" width="25"></td>
                                            <?php } elseif ($isi->t_9=='') {?>
                                                <td style='text-align:center;'><strong>-</strong></td>
                                            <?php } else { ?>
                                                <td style='text-align:center;'><img src="<?php echo base_url() . "/assets/img/error1.png" ?>" width="25"></td>
                                            <?php } ?>
                                            <?php if ($isi->t_10=='0') {?>
                                                <td style='text-align:center;'><img src="<?php echo base_url() . "/assets/img/check1.png" ?>" width="25"></td>
                                            <?php } elseif ($isi->t_10=='') {?>
                                                <td style='text-align:center;'><strong>-</strong></td>
                                            <?php } else { ?>
                                                <td style='text-align:center;'><img src="<?php echo base_url() . "/assets/img/error1.png" ?>" width="25"></td>
                                            <?php } ?>
                                            <?php if ($isi->t_11=='0') {?>
                                                <td style='text-align:center;'><img src="<?php echo base_url() . "/assets/img/check1.png" ?>" width="25"></td>
                                            <?php } elseif ($isi->t_11=='') {?>
                                                <td style='text-align:center;'><strong>-</strong></td>
                                            <?php } else { ?>
                                                <td style='text-align:center;'><img src="<?php echo base_url() . "/assets/img/error1.png" ?>" width="25"></td>
                                            <?php } ?>
                                            <?php if ($isi->t_12=='0') {?>
                                                <td style='text-align:center;'><img src="<?php echo base_url() . "/assets/img/check1.png" ?>" width="25"></td>
                                            <?php } elseif ($isi->t_12=='') {?>
                                                <td style='text-align:center;'><strong>-</strong></td>
                                            <?php } else { ?>
                                                <td style='text-align:center;'><img src="<?php echo base_url() . "/assets/img/error1.png" ?>" width="25"></td>
                                            <?php } ?>
                                            <?php if ($isi->t_13=='0') {?>
                                                <td style='text-align:center;'><img src="<?php echo base_url() . "/assets/img/check1.png" ?>" width="25"></td>
                                            <?php } elseif ($isi->t_13=='') {?>
                                                <td style='text-align:center;'><strong>-</strong></td>
                                            <?php } else { ?>
                                                <td style='text-align:center;'><img src="<?php echo base_url() . "/assets/img/error1.png" ?>" width="25"></td>
                                            <?php } ?>
                                            <?php if ($isi->t_14=='0') {?>
                                                <td style='text-align:center;'><img src="<?php echo base_url() . "/assets/img/check1.png" ?>" width="25"></td>
                                            <?php } elseif ($isi->t_14=='') {?>
                                                <td style='text-align:center;'><strong>-</strong></td>
                                            <?php } else { ?>
                                                <td style='text-align:center;'><img src="<?php echo base_url() . "/assets/img/error1.png" ?>" width="25"></td>
                                            <?php } ?>
                                            <?php if ($isi->t_15=='0') {?>
                                                <td style='text-align:center;'><img src="<?php echo base_url() . "/assets/img/check1.png" ?>" width="25"></td>
                                            <?php } elseif ($isi->t_15=='') {?>
                                                <td style='text-align:center;'><strong>-</strong></td>
                                            <?php } else { ?>
                                                <td style='text-align:center;'><img src="<?php echo base_url() . "/assets/img/error1.png" ?>" width="25"></td>
                                            <?php } ?>
                                            <?php if ($isi->t_16=='0') {?>
                                                <td style='text-align:center;'><img src="<?php echo base_url() . "/assets/img/check1.png" ?>" width="25"></td>
                                            <?php } elseif ($isi->t_16=='') {?>
                                                <td style='text-align:center;'><strong>-</strong></td>
                                            <?php } else { ?>
                                                <td style='text-align:center;'><img src="<?php echo base_url() . "/assets/img/error1.png" ?>" width="25"></td>
                                            <?php } ?>
                                            <?php if ($isi->t_17=='0') {?>
                                                <td style='text-align:center;'><img src="<?php echo base_url() . "/assets/img/check1.png" ?>" width="25"></td>
                                            <?php } elseif ($isi->t_17=='') {?>
                                                <td style='text-align:center;'><strong>-</strong></td>
                                            <?php } else { ?>
                                                <td style='text-align:center;'><img src="<?php echo base_url() . "/assets/img/error1.png" ?>" width="25"></td>
                                            <?php } ?>
                                            <?php if ($isi->t_18=='0') {?>
                                                <td style='text-align:center;'><img src="<?php echo base_url() . "/assets/img/check1.png" ?>" width="25"></td>
                                            <?php } elseif ($isi->t_18=='') {?>
                                                <td style='text-align:center;'><strong>-</strong></td>
                                            <?php } else { ?>
                                                <td style='text-align:center;'><img src="<?php echo base_url() . "/assets/img/error1.png" ?>" width="25"></td>
                                            <?php } ?>
                                            <?php if ($isi->t_19=='0') {?>
                                                <td style='text-align:center;'><img src="<?php echo base_url() . "/assets/img/check1.png" ?>" width="25"></td>
                                            <?php } elseif ($isi->t_19=='') {?>
                                                <td style='text-align:center;'><strong>-</strong></td>
                                            <?php } else { ?>
                                                <td style='text-align:center;'><img src="<?php echo base_url() . "/assets/img/error1.png" ?>" width="25"></td>
                                            <?php } ?>
                                            <?php if ($isi->t_20=='0') {?>
                                                <td style='text-align:center;'><img src="<?php echo base_url() . "/assets/img/check1.png" ?>" width="25"></td>
                                            <?php } elseif ($isi->t_20=='') {?>
                                                <td style='text-align:center;'><strong>-</strong></td>
                                            <?php } else { ?>
                                                <td style='text-align:center;'><img src="<?php echo base_url() . "/assets/img/error1.png" ?>" width="25"></td>
                                            <?php } ?>
                                            <?php if ($isi->t_21=='0') {?>
                                                <td style='text-align:center;'><img src="<?php echo base_url() . "/assets/img/check1.png" ?>" width="25"></td>
                                            <?php } elseif ($isi->t_21=='') {?>
                                                <td style='text-align:center;'><strong>-</strong></td>
                                            <?php } else { ?>
                                                <td style='text-align:center;'><img src="<?php echo base_url() . "/assets/img/error1.png" ?>" width="25"></td>
                                            <?php } ?>
                                            <?php if ($isi->t_22=='0') {?>
                                                <td style='text-align:center;'><img src="<?php echo base_url() . "/assets/img/check1.png" ?>" width="25"></td>
                                            <?php } elseif ($isi->t_22=='') {?>
                                                <td style='text-align:center;'><strong>-</strong></td>
                                            <?php } else { ?>
                                                <td style='text-align:center;'><img src="<?php echo base_url() . "/assets/img/error1.png" ?>" width="25"></td>
                                            <?php } ?>
                                            <?php if ($isi->t_23=='0') {?>
                                                <td style='text-align:center;'><img src="<?php echo base_url() . "/assets/img/check1.png" ?>" width="25"></td>
                                            <?php } elseif ($isi->t_23=='') {?>
                                                <td style='text-align:center;'><strong>-</strong></td>
                                            <?php } else { ?>
                                                <td style='text-align:center;'><img src="<?php echo base_url() . "/assets/img/error1.png" ?>" width="25"></td>
                                            <?php } ?>
                                            <?php if ($isi->t_24=='0') {?>
                                                <td style='text-align:center;'><img src="<?php echo base_url() . "/assets/img/check1.png" ?>" width="25"></td>
                                            <?php } elseif ($isi->t_24=='') {?>
                                                <td style='text-align:center;'><strong>-</strong></td>
                                            <?php } else { ?>
                                                <td style='text-align:center;'><img src="<?php echo base_url() . "/assets/img/error1.png" ?>" width="25"></td>
                                            <?php } ?>    
                                            <?php if ($isi->t_25=='0') {?>
                                                <td style='text-align:center;'><img src="<?php echo base_url() . "/assets/img/check1.png" ?>" width="25"></td>
                                            <?php } elseif ($isi->t_25=='') {?>
                                                <td style='text-align:center;'><strong>-</strong></td>
                                            <?php } else { ?>
                                                <td style='text-align:center;'><img src="<?php echo base_url() . "/assets/img/error1.png" ?>" width="25"></td>
                                            <?php } ?>
                                            <?php if ($isi->t_26=='0') {?>
                                                <td style='text-align:center;'><img src="<?php echo base_url() . "/assets/img/check1.png" ?>" width="25"></td>
                                            <?php } elseif ($isi->t_26=='') {?>
                                                <td style='text-align:center;'><strong>-</strong></td>
                                            <?php } else { ?>
                                                <td style='text-align:center;'><img src="<?php echo base_url() . "/assets/img/error1.png" ?>" width="25"></td>
                                            <?php } ?>
                                            <?php if ($isi->t_27=='0') {?>
                                                <td style='text-align:center;'><img src="<?php echo base_url() . "/assets/img/check1.png" ?>" width="25"></td>
                                            <?php } elseif ($isi->t_27=='') {?>
                                                <td style='text-align:center;'><strong>-</strong></td>
                                            <?php } else { ?>
                                                <td style='text-align:center;'><img src="<?php echo base_url() . "/assets/img/error1.png" ?>" width="25"></td>
                                            <?php } ?>
                                            <?php if ($isi->t_28=='0') {?>
                                                <td style='text-align:center;'><img src="<?php echo base_url() . "/assets/img/check1.png" ?>" width="25"></td>
                                            <?php } elseif ($isi->t_28=='') {?>
                                                <td style='text-align:center;'><strong>-</strong></td>
                                            <?php } else { ?>
                                                <td style='text-align:center;'><img src="<?php echo base_url() . "/assets/img/error1.png" ?>" width="25"></td>
                                            <?php } ?>
                                            <?php if ($isi->t_29=='0') {?>
                                                <td style='text-align:center;'><img src="<?php echo base_url() . "/assets/img/check1.png" ?>" width="25"></td>
                                            <?php } elseif ($isi->t_29=='') {?>
                                                <td style='text-align:center;'><strong>-</strong></td>
                                            <?php } else { ?>
                                                <td style='text-align:center;'><img src="<?php echo base_url() . "/assets/img/error1.png" ?>" width="25"></td>
                                            <?php } ?>
                                            <?php if ($isi->t_30=='0') {?>
                                                <td style='text-align:center;'><img src="<?php echo base_url() . "/assets/img/check1.png" ?>" width="25"></td>
                                            <?php } elseif ($isi->t_30=='') {?>
                                                <td style='text-align:center;'><strong>-</strong></td>
                                            <?php } else { ?>
                                                <td style='text-align:center;'><img src="<?php echo base_url() . "/assets/img/error1.png" ?>" width="25"></td>
                                            <?php } ?>
                                            <?php if ($isi->t_31=='0') {?>
                                                <td style='text-align:center;'><img src="<?php echo base_url() . "/assets/img/check1.png" ?>" width="25"></td>
                                            <?php } elseif ($isi->t_31=='') {?>
                                                <td style='text-align:center;'><strong>-</strong></td>
                                            <?php } else { ?>
                                                <td style='text-align:center;'><img src="<?php echo base_url() . "/assets/img/error1.png" ?>" width="25"></td>
                                            <?php } ?>
                                        </tr>
                                        <?php
                                        $r++;
                                    }
                                }?>
                                </tbody>
                            </table>

                            <table id="exportToExcel" class="table table-striped table-condensed table-hover display" cellspacing="0" width="100%" style="display:none;">
                            <thead>
                                    <tr>
                                    <th style='text-align:center;'>No</th>
                                        <th style='text-align:center;'>NPK</th>
                                        <th style='text-align:center;'>Nama</th>
                                        <th style='text-align:center;'>Dept</th>
                                        <th style='text-align:center;'>1</th>
                                        <th style='text-align:center;'>2</th>
                                        <th style='text-align:center;'>3</th>
                                        <th style='text-align:center;'>4</th>
                                        <th style='text-align:center;'>5</th>
                                        <th style='text-align:center;'>6</th>
                                        <th style='text-align:center;'>7</th>
                                        <th style='text-align:center;'>8</th>
                                        <th style='text-align:center;'>9</th>
                                        <th style='text-align:center;'>10</th>
                                        <th style='text-align:center;'>11</th>
                                        <th style='text-align:center;'>12</th>
                                        <th style='text-align:center;'>13</th>
                                        <th style='text-align:center;'>14</th>
                                        <th style='text-align:center;'>15</th>
                                        <th style='text-align:center;'>16</th>
                                        <th style='text-align:center;'>17</th>
                                        <th style='text-align:center;'>18</th>
                                        <th style='text-align:center;'>19</th>
                                        <th style='text-align:center;'>20</th>
                                        <th style='text-align:center;'>21</th>
                                        <th style='text-align:center;'>22</th>
                                        <th style='text-align:center;'>23</th>
                                        <th style='text-align:center;'>24</th>
                                        <th style='text-align:center;'>25</th>
                                        <th style='text-align:center;'>26</th>
                                        <th style='text-align:center;'>27</th>
                                        <th style='text-align:center;'>28</th>
                                        <th style='text-align:center;'>29</th>
                                        <th style='text-align:center;'>30</th>
                                        <th style='text-align:center;'>31</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    if($dt_week == 'NULL'){

                                    }else{
                                        $r = 1;
                                        foreach ($dt_week as $isi) {
                                            echo "<tr class='gradeX'>";
                                            echo "<td style='text-align:center;'>$r</td>";
                                            echo "<td style='text-align:center;'>$isi->npk</td>";
                                            echo "<td style='text-align:center;'>$isi->username</td>";
                                            echo "<td style='text-align:center;'>$isi->dept</td>";
                                            ?>
                                            <?php if ($isi->t_1=='0') {?>
                                                <td style='text-align:center;'>NG</td>
                                            <?php } else { ?>
                                                <td style='text-align:center;'>OK</td>
                                            <?php } ?>
                                            <?php if ($isi->t_2=='0') {?>
                                                <td style='text-align:center;'>NG</td>
                                            <?php } else { ?>
                                                <td style='text-align:center;'>OK</td>
                                            <?php } ?>    
                                            <?php if ($isi->t_3=='1') {?>
                                                <td style='text-align:center;'>NG</td>
                                            <?php } else { ?>
                                                <td style='text-align:center;'>OK</td>
                                            <?php } ?>
                                            <?php if ($isi->t_4=='1') {?>
                                                <td style='text-align:center;'>NG</td>
                                            <?php } else { ?>
                                                <td style='text-align:center;'>OK</td>
                                            <?php } ?>
                                            <?php if ($isi->t_5=='1') {?>
                                                <td style='text-align:center;'>NG</td>
                                            <?php } else { ?>
                                                <td style='text-align:center;'>OK</td>
                                            <?php } ?>
                                            <?php if ($isi->t_6=='1') {?>
                                                <td style='text-align:center;'>NG</td>
                                            <?php } else { ?>
                                                <td style='text-align:center;'>OK</td>
                                            <?php } ?>
                                            <?php if ($isi->t_7=='1') {?>
                                                <td style='text-align:center;'>NG</td>
                                            <?php } else { ?>
                                                <td style='text-align:center;'>OK</td>
                                            <?php } ?>    
                                            <?php if ($isi->t_8=='1') {?>
                                                <td style='text-align:center;'>NG</td>
                                            <?php } else { ?>
                                                <td style='text-align:center;'>OK</td>
                                            <?php } ?>
                                            <?php if ($isi->t_9=='1') {?>
                                                <td style='text-align:center;'>NG</td>
                                            <?php } else { ?>
                                                <td style='text-align:center;'>OK</td>
                                            <?php } ?>
                                            <?php if ($isi->t_10=='1') {?>
                                                <td style='text-align:center;'>NG</td>
                                            <?php } else { ?>
                                                <td style='text-align:center;'>OK</td>
                                            <?php } ?>
                                            <?php if ($isi->t_11=='1') {?>
                                                <td style='text-align:center;'>NG</td>
                                            <?php } else { ?>
                                                <td style='text-align:center;'>OK</td>
                                            <?php } ?>
                                            <?php if ($isi->t_12=='1') {?>
                                                <td style='text-align:center;'>NG</td>
                                            <?php } else { ?>
                                                <td style='text-align:center;'>OK</td>
                                            <?php } ?>
                                            <?php if ($isi->t_13=='1') {?>
                                                <td style='text-align:center;'>NG</td>
                                            <?php } else { ?>
                                                <td style='text-align:center;'>OK</td>
                                            <?php } ?>
                                            <?php if ($isi->t_14=='1') {?>
                                                <td style='text-align:center;'>NG</td>
                                            <?php } else { ?>
                                                <td style='text-align:center;'>OK</td>
                                            <?php } ?>
                                            <?php if ($isi->t_15=='1') {?>
                                                <td style='text-align:center;'>NG</td>
                                            <?php } else { ?>
                                                <td style='text-align:center;'>OK</td>
                                            <?php } ?>
                                            <?php if ($isi->t_16=='1') {?>
                                                <td style='text-align:center;'>NG</td>
                                            <?php } else { ?>
                                                <td style='text-align:center;'>OK</td>
                                            <?php } ?>
                                            <?php if ($isi->t_17=='1') {?>
                                                <td style='text-align:center;'>NG</td>
                                            <?php } else { ?>
                                                <td style='text-align:center;'>OK</td>
                                            <?php } ?>
                                            <?php if ($isi->t_18=='1') {?>
                                                <td style='text-align:center;'>NG</td>
                                            <?php } else { ?>
                                                <td style='text-align:center;'>OK</td>
                                            <?php } ?>
                                            <?php if ($isi->t_19=='1') {?>
                                                <td style='text-align:center;'>NG</td>
                                            <?php } else { ?>
                                                <td style='text-align:center;'>OK</td>
                                            <?php } ?>
                                            <?php if ($isi->t_20=='1') {?>
                                                <td style='text-align:center;'>NG</td>
                                            <?php } else { ?>
                                                <td style='text-align:center;'>OK</td>
                                            <?php } ?>
                                            <?php if ($isi->t_21=='1') {?>
                                                <td style='text-align:center;'>NG</td>
                                            <?php } else { ?>
                                                <td style='text-align:center;'>OK</td>
                                            <?php } ?>
                                            <?php if ($isi->t_22=='1') {?>
                                                <td style='text-align:center;'>NG</td>
                                            <?php } else { ?>
                                                <td style='text-align:center;'>OK</td>
                                            <?php } ?>
                                            <?php if ($isi->t_23=='1') {?>
                                                <td style='text-align:center;'>NG</td>
                                            <?php } else { ?>
                                                <td style='text-align:center;'>OK</td>
                                            <?php } ?>
                                            <?php if ($isi->t_24=='1') {?>
                                                <td style='text-align:center;'>NG</td>
                                            <?php } else { ?>
                                                <td style='text-align:center;'>OK</td>
                                            <?php } ?>
                                            <?php if ($isi->t_25=='1') {?>
                                                <td style='text-align:center;'>NG</td>
                                            <?php } else { ?>
                                                <td style='text-align:center;'>OK</td>
                                            <?php } ?>
                                            <?php if ($isi->t_26=='1') {?>
                                                <td style='text-align:center;'>NG</td>
                                            <?php } else { ?>
                                                <td style='text-align:center;'>OK</td>
                                            <?php } ?>
                                            <?php if ($isi->t_27=='1') {?>
                                                <td style='text-align:center;'>NG</td>
                                            <?php } else { ?>
                                                <td style='text-align:center;'>OK</td>
                                            <?php } ?>
                                            <?php if ($isi->t_28=='1') {?>
                                                <td style='text-align:center;'>NG</td>
                                            <?php } else { ?>
                                                <td style='text-align:center;'>OK</td>
                                            <?php } ?>
                                            <?php if ($isi->t_29=='1') {?>
                                                <td style='text-align:center;'>NG</td>
                                            <?php } else { ?>
                                                <td style='text-align:center;'>OK</td>
                                            <?php } ?>
                                            <?php if ($isi->t_30=='1') {?>
                                                <td style='text-align:center;'>NG</td>
                                            <?php } else { ?>
                                                <td style='text-align:center;'>OK</td>
                                            <?php } ?>
                                            <?php if ($isi->t_31=='1') {?>
                                                <td style='text-align:center;'>NG</td>
                                            <?php } else { ?>
                                                <td style='text-align:center;'>OK</td>
                                            <?php } ?>
                                        </tr>
                                        <?php
                                        $r++;
                                    }
                                }?>
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
                                            var table = $('#example').DataTable({
                                                scrollY: "400px",
                                                scrollX: true,
                                                scrollCollapse: true,
                                                paging: false,
                                                fixedColumns: {
                                                    leftColumns: 4
                                                }
                                            });
                                        });

                                        document.getElementById("uploadBtn").onchange = function () {
                                            document.getElementById("uploadFile").value = this.value;
                                        };
</script>