<script src="http://code.highcharts.com/highcharts.js"></script>
<script type="text/javascript" src="<?php echo base_url('assets/script/canvasjs.min.js') ?>"></script>
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

<aside class="right-side">
    <section class="content-header">
        <ol class="breadcrumb">
            <li><a href="<?php echo base_url('index.php/basis/home_c/'); ?>"><span>Home</span></a></li>
            <li><a href=""><strong>REPORT PRODUCTION ACCUMULATIVE</strong></a></li>
        </ol>
    </section>

    <section class="content">



        <div class="row">
            <div class="col-md-12">

                <script type="text/javascript">
                    var chart1;
                    $(document).ready(function () {
                        chart1 = new Highcharts.Chart({
                            chart: {
                                renderTo: 'container',
                                type: 'column',
                                plotBorderWidth: 1
                            },
                            credits: {
                                enabled: false
                            },
                            legend: {
                                borderColor: '#cccccc',
                                borderWidth: 1,
                                borderRadius: 3
                            },
                            tooltip: {
                                split: true,
                                valueSuffix: ' Pcs'
                            },
                            title: {
                                text: ''
                            },
                            xAxis: {
                                categories: ['Work Center']
                            },
                            yAxis: {
                                title: {
                                    text: 'Total Produksi'
                                }
                            },
                            series: [
<?php
foreach ($data_prod_entry_for_diagram as $row) {
    ?>
                                    {
                                        name: '<?php echo $row->CHR_WORK_CENTER; ?>',
                                        data: [<?php echo $row->INT_TOTAL_QTY; ?>]
                                    },
<?php } ?>
                            ]
                        });
                    });
                </script>

                <div class="grid">
                    <div class="grid-header">
                        <i class="fa fa-bar-chart-o"></i>
                        <span class="grid-title"><strong>PROD. ACCUMULATIVE CHART</strong></span>
                        <div class="pull-right grid-tools">
                            <a data-widget="collapse" title="Collapse"><i class="fa fa-chevron-up"></i></a>
                        </div>                       
                    </div>
                    <div class="grid-body">
                        <div class="pull">

                            <table width="100%" id='filter' border=0px>
                                <tr>
                                    <td width="15%">Periode</td>
                                    <td width="20%">
                                        <select class="ddl" id="tanggal" onChange="document.location.href = this.options[this.selectedIndex].value;">
                                            <?php for ($x = -5; $x <= 5; $x++) { ?>
                                                <option value="<? echo site_url('pes_new/report_prod_accu_c/search_accu/' . date("Ym", strtotime("+$x month")) . '/' . $id_prod . '/' . $work_center); ?>" <?php
                                                if ($selected_date == date("Ym", strtotime("+$x month"))) {
                                                    echo 'SELECTED';
                                                }
                                                ?> > <?php echo date("M Y", strtotime("+$x month")); ?> </option>
                                                    <?php } ?>
                                        </select>
                                    </td>
                                
                                    <td>Department</td>
                                    <td> 
                                        <? if ($role == 17 || $role == 16 || $role == 6 || $role == 5 || $role == 32 ) { ?>
                                            <select disabled style="cursor:not-allowed;background-color: #F3F4F5;" id="opt_wcenter" onChange="document.location.href = this.options[this.selectedIndex].value;" class="ddl">
                                            <?php } else { ?>
                                                <select id="opt_wcenter" onChange="document.location.href = this.options[this.selectedIndex].value;" class="ddl">
                                                <?php } ?>
                                                <?php foreach ($all_dept_prod as $row): ?>
                                                    <option value="<? echo site_url('pes_new/report_prod_accu_c/search_accu/' . $selected_date . '/' . $row->INT_ID_DEPT . '/' . $work_center); ?>" <?php
                                                    if ($id_prod == $row->INT_ID_DEPT) {
                                                        echo 'SELECTED';
                                                    }
                                                    ?> ><? echo trim($row->CHR_DEPT_DESC); ?></option>
                                                        <?php endforeach; ?>
                                                <option value="<?php echo site_url('pes_new/report_prod_accu_c/search_accu/' . $selected_date . '/' . 'ALL' . '/' . $work_center); ?>" <?php
                                                if ($id_prod == 'ALL') {
                                                    echo 'SELECTED';
                                                }
                                                ?> >ALL</option>
                                            </select>
                                    </td>
                                    <td>
                                    </td>
                                </tr>
                                <tr>
                                    <td>Work Center</td>
                                    <td> <select class="ddl" onChange="document.location.href = this.options[this.selectedIndex].value;" >
                                            <?php foreach ($all_work_centers as $row): ?>
                                                <option value="<? echo site_url('pes_new/report_prod_accu_c/search_accu/' . $selected_date . '/' . $id_prod . '/' . (trim($row->CHR_WORK_CENTER))); ?>" <?php
                                                if (trim($work_center) == trim($row->CHR_WORK_CENTER)) {
                                                    echo 'SELECTED';
                                                }
                                                ?> ><? echo trim($row->CHR_WORK_CENTER); ?></option>
                                                    <?php endforeach; ?>
                                            <option value="<? echo site_url('pes_new/report_prod_accu_c/search_accu/' . $selected_date . '/' . $id_prod . '/' . 'ALL'); ?>" <?php
                                            if ($work_center == 'ALL') {
                                                echo 'SELECTED';
                                            }
                                            ?> >ALL</option>
                                        </select>
                                    </td>
                                    
                                    <td></td>
                                    <td>
                                        <div style='font-size: 14px;' class="pull-right">
                                            <strong class='badge bg-blue'>TOTAL : <?php echo number_format($total); ?></strong>
                                        </div>
                                    </td>
                                </tr>
                            </table>

                        </div>

                        <?php if ($data_prod_entry_for_diagram == 0) { ?>
                            <table width=100% id='filterdiagram' ><td> No data available in diagram</td></table>
                        <?php } else { ?>
                            <div id="container"></div>
                        <?php } ?>
                    </div>
                </div>

            </div>
        </div>

        <div class="row">
            <div class="col-md-12">
                <div class="grid">
                    <div class="grid-header">
                        <i class="fa fa-th-large"></i>
                        <span class="grid-title"><strong>REPORT PROD. ACCUMULATIVE</strong></span>
                        <div class="pull-right grid-tools">
                            <a data-widget="collapse" title="Collapse"><i class="fa fa-chevron-up"></i></a>
                        </div>
                    </div>
                    <div class="grid-body">

<div id="table-luar">
                        <table id="dataTables3" class="table table-condensed table-striped table-hover display" cellspacing="0" width="100%">
                            <thead>
                                <tr class='gradeX'>
                                    <th rowspan="1" style="vertical-align: middle">No</th>
                                    <th rowspan="1" style="vertical-align: middle">Work Center</th>
                                    <th rowspan="1" style="vertical-align: middle">Part Number</th>
                                    <th rowspan="1" style="vertical-align: middle">Back No </th>                                        
                                    <th rowspan="1" style="vertical-align: middle">Part.Name & Model </th>
                                    <th rowspan="1" style="vertical-align: middle">Date </th> 
                                    <th rowspan="1" style="vertical-align: middle">Shift </th> 										
                                    <th rowspan="1" style="vertical-align: middle">OK </th>
                                    <th rowspan="1" style="vertical-align: middle">NG </th>
                                    <th rowspan="1" style="vertical-align: middle">Total </th>
                                </tr>
                               
                            </thead>
                            <tbody>
                                <?php
                                $r = 1;
                                $session = $this->session->all_userdata();
                                foreach ($data_prod_entry as $isi) {

                                    echo "<tr class='gradeX'>";
                                    echo "<td style=text-align:center;>$r</td>";
                                    echo "<td style=vertical-align: top;text-align: left;>$isi->CHR_WORK_CENTER</td>";
                                    echo "<td style=vertical-align: top;text-align: left;>$isi->CHR_PART_NO</td>";
                                    echo "<td style=text-align:center;>$isi->CHR_BACK_NO</td>";
                                    echo "<td style=vertical-align: top;text-align: left;>$isi->CHR_PART_NAME</td>";
                                    echo "<td style=text-align:center;>$isi->CHR_ONLY_DATE-$isi->CHR_ONLY_MONTH-$isi->CHR_ONLY_YEAR</td>";
                                    echo "<td style=text-align:center;>$isi->CHR_SHIFT</td>";
                                    echo "<td style=text-align:center;><label class='label label-success'>$isi->INT_TOTAL_QTY</div></td>";
                                    echo "<td style=text-align:center;><label class='label label-danger'>$isi->INT_TOTAL_NG</div></td>";
                                    echo "<td style=text-align:center;>$isi->INT_TOTAL</td>";
                                    ?>
                                    </tr>
                                    <?php
                                    $r++;
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

