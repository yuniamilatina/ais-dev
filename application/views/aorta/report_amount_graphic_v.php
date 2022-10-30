
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
    }
    .td-fixed{
        width: 10px;
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
            <li><a href=""><strong>REPORT OVERTIME BY AMOUNT</strong></a></li>
        </ol>
    </section>

    <section class="content">

        <div class="row">
            <div class="col-md-12">
                <script type="text/javascript">
                    window.onload = function () {
                        var chart = new CanvasJS.Chart("chartContainer",
                                {
                                    theme: "theme1",
                                    animationEnabled: true,
                                    title: {
                                        text: "",
                                        fontSize: 30
                                    },
                                    toolTip: {
                                        shared: true
                                    },
                                    axisY: {
                                        title: "Amount"
                                    },
                                    data: [
                                        {
                                            type: "column",
                                            name: "PLAN (Rp)",
                                            legendText: "PLAN",
                                            showInLegend: true,
                                            dataPoints: [
                                                <?php $row_plan = 1;
                                                    foreach ($data_summary_plan as $isi) { 
                                                        if ($row_plan != 2) { 
                                                            echo '{label: "' . $isi->SECT . '", y:' . $isi->AMOUNT . '},';
                                                        $row_plan++;
                                                        } else { 
                                                            echo '{label: "' . $isi->SECT . '", y:' . $isi->AMOUNT . '}';
                                                        }
                                                } ?>
                                            ]
                                        },
                                        {
                                            type: "column",
                                            name: "REALISASI (Rp)",
                                            legendText: "REALISASI",
                                            axisYType: "secondary",
                                            showInLegend: true,
                                            dataPoints: [
                                                <?php $row_act = 1;
                                                    foreach ($data_summary_real as $isi) { 
                                                        if ($row_act != 2) { 
                                                            echo '{label: "' . $isi->SECT . '", y:' . $isi->AMOUNT . '},';
                                                        $row_act++;
                                                        } else { 
                                                            echo '{label: "' . $isi->SECT . '", y:' . $isi->AMOUNT . '}';
                                                        }
                                                } ?>
                                            ]
                                        }

                                    ],
                                    legend: {
                                        cursor: "pointer",
                                                itemclick: function (e) {
                                                    if (typeof (e.dataSeries.visible) === "undefined" || e.dataSeries.visible) {
                                                        e.dataSeries.visible = false;
                                                    }
                                                    else {
                                                        e.dataSeries.visible = true;
                                                    }
                                                    chart.render();
                                                }
                                    }
                                });

                        chart.render();
                    }
                </script>
                
                <div class="grid">
                    <div class="grid-header">
                        <i class="fa fa-bar-chart-o"></i>
                        <span class="grid-title"><strong>OVERTIME COLUMN CHART</strong></span>
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
                                            <?php for ($x = -5; $x <= 5; $x++) {  $y = $x * 28 ?>
                                                <option value="<? echo site_url('aorta/report_amount_c/search_prod_entry/' . date("Ym", strtotime("+$y day")) . '/' . $id_prod . '/' . $work_center); ?>" <?php
                                                if ($selected_date == date("Ym", strtotime("+$y day"))) {
                                                    echo 'SELECTED';
                                                }
                                                ?> > <?php echo date("M Y", strtotime("+$y day")); ?> </option>
                                                    <?php } ?>
                                        </select>
                                    </td>
                                    <td>Department</td>
                                    <td>
                                        <select id="opt_wcenter" onChange="document.location.href = this.options[this.selectedIndex].value;" class="ddl">
                                            <?php foreach ($all_dept_prod as $row) { ?>
                                                <option value="<? echo site_url('pes_new/report_prod_line_c/search_prod_entry/' . $selected_date . '/' . $row->INT_ID_DEPT); ?>" <?php
                                                if ($id_prod == $row->INT_ID_DEPT) {
                                                    echo 'SELECTED';
                                                }
                                                ?> ><?php echo trim($row->CHR_DEPT_DESC); ?></option>
                                                    <?php } ?>
                                        </select>
                                    </td>
                                    <td>
                                    </td>
                                </tr>
                                <tr>
                                    <td>Section</td>
                                    <td> <select id="opt_wcenter" onChange="document.location.href = this.options[this.selectedIndex].value;" class="ddl">
                                            <?php foreach ($all_work_centers as $row) { ?>
                                                <option value="<? echo site_url('pes_new/report_prod_line_c/search_prod_entry/' . $selected_date . '/' . $id_prod . '/' . (trim($row->CHR_WORK_CENTER))); ?>" <?php
                                                if (trim($work_center) == trim($row->CHR_WORK_CENTER)) {
                                                    echo 'SELECTED';
                                                }
                                                ?> ><?php echo trim($row->CHR_WORK_CENTER); ?></option>
                                                    <?php } ?>
                                        </select>
                                    </td>

                                    <td></td>
                                    <td>
                                        <div style='font-size: 14px;' class="pull-right">
                                            <strong class='badge bg-blue'>TOTAL : <?php echo 'Total'; ?></strong>
                                        </div>
                                    </td>
                                </tr>
                            </table>

                        </div>

                        <?php if ($data_summary_plan == 0) { ?>
                            <table width=100% border:1px id='filterdiagram' ><td> No data available in diagram</td></table>
                        <?php } else { ?>
                            <div id="chartContainer" style="height: 350px; width: 100%;"></div>
                        <?php } ?>

                    </div>                    
                </div>
            </div>
        </div>

    </section>
</aside>
