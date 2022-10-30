<script src="http://code.highcharts.com/highcharts.js"></script>
<script type="text/javascript">
    function ChooseFiscal(data) {
        document.getElementById("jYear").value = data.value;
    }
</script> 
<?php $session = $this->session->all_userdata(); ?>
<aside class="right-side">
    <section class="content-header">
        <ol class="breadcrumb">
            <li><a href="<?php echo base_url('index.php/basis/home_c/"') ?>"><span>Home</span></a></li>
            <li> <a href="#"><strong>Group Dept List</strong></a></li>
        </ol>
    </section>

    <section class="content">
        <?php
        if ($msg != NULL) {
            echo $msg;
        }
        ?>
        <div class="row">
            <div class="col-md-6">
                <div class="grid">
                    <div class="grid-header">
                        <i class="fa fa-shopping-cart"></i>
                        <span class="grid-title"><strong>CAPEX</strong> <?php echo $group . ' [' . $fiscal . ']' ?></span>
                        <div class="pull-right grid-tools">
                            <a data-widget="collapse" title="Collapse" data-toggle="tooltip" data-placement="left" ><i class="fa fa-chevron-up"></i></a>
                        </div>
                    </div>
                    <div class="grid-body">
                        <div class="pull" hidden="true">
                            <?php echo form_open('budget/capex_plan_temp_c/search_prepare_approve_capex', 'class="form-horizontal"'); ?>
                            <select name="INT_ID_FISCAL_YEAR" autofocus onchange="ChooseFiscal(this);" class="ddl">
                                <?php
                                foreach ($data_fiscal as $isi) {
                                    if ($this_fiscal_year == $isi->INT_ID_FISCAL_YEAR) {
                                        ?> 
                                        <option selected="true" value="<?php echo $isi->INT_ID_FISCAL_YEAR; ?>"><?php echo $isi->CHR_FISCAL_YEAR; ?></option>
                                    <?php } else { ?>
                                        <option value="<?php echo $isi->INT_ID_FISCAL_YEAR; ?>"><?php echo $isi->CHR_FISCAL_YEAR; ?></option>
                                        <?php
                                    }
                                }
                                ?> 
                            </select>
                            <button type="submit" name="search" class="btn btn-default" title="Search" data-toggle="tooltip" data-placement="right"><i class="fa fa-search"></i></button>
                            <?php
                            echo form_close();
                            ?>
                        </div>
                        <?php echo form_open('budget/capex_plan_temp_c/recap_capex_plan_temp', 'class="form-horizontal"');
                        ?>
                        <table id="dataTables1" class="table table-condensed table-hover display" cellspacing="0" width="100%">
                            <thead>
                                <tr>
                                    <th>No</th>
                                    <th>Division</th>                
                                    <th>Total Budget</th>                
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                $i = 1;
                                foreach ($data as $isi) {
                                    if ($isi->INT_STATUS == 1) {
                                        echo "<tr class='gradeX success'>";
                                    } else  {
                                        echo "<tr class='gradeX default'>";
                                    } 
                                    echo "<td>$i</td>";
                                    echo "<td>$isi->CHR_DIVISION</td>";
                                    echo "<td>" . number_format($isi->total, 0, '', '.') . "</td>";
                                    ?>
                                <td>
                                    <a href="<?php echo base_url('index.php/budget/capex_plan_temp_c/view_detail_by_div') . '/' . $isi->INT_ID_DIVISION . '/' . $isi->INT_ID_FISCAL_YEAR ?>" class="label label-success" data-toggle="tooltip" data-placement="right" title="View"><span class="fa fa-check"></span></a>
                                </td>
                                <?php
                                $i++;
                            }
                            ?>
                            </tbody>
                        </table>
                    </div>

                    <div class="grid-header">                        
                        <div class="grid-body">
                            <div class="pull-right">
                                <div class="form-group">
                                    <div class="btn-group">
                                        <input name="INT_ID_FISCAL_YEAR" value="<?php echo $this_fiscal_year ?>" type="hidden" id="jYear">
                                        <?php if ($stat_commit == 0 && $permit_approve == 1) { ?>
                                            <button type = "submit" name = "submit" class = "btn btn-primary" data-toggle = "tooltip" data-placement = "top" title = "Commit this budget" onclick = "return confirm('Are you sure want to commit this budget?');"><i class = "fa fa-check"></i> Commit</button>
                                            <?php
                                        }else{
                                        ?>
                                            <hr>The Budget was commited
                                        <?php } echo form_close(); ?>
                                    </div>
                                </div>
                            </div>                    
                        </div>                       
                    </div>

                </div>
            </div>

            <script type="text/javascript">
    var chart1;
    $(document).ready(function() {
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
                valuePrefix: 'Rp.'
            },
            title: {
                text: ''
            },
            xAxis: {
                categories: ['Division']
            },
            yAxis: {
                title: {
                    text: 'Total Budget'
                }
            },
            series: [
<?php
foreach ($data as $row) {
    ?>
                    {
                        name: '<?php echo $row->CHR_DIVISION; ?>',
                        data: [<?php echo $row->total; ?>]
                    },
<?php } ?>
            ]
        });
    });
            </script>

            <div class="col-md-6">
                <div class="grid">
                    <div class="grid-header">
                        <i class="fa fa-bar-chart-o"></i>
                        <span class="grid-title"><strong>DIVISION </strong>BUDGETING CHART</span>
                        <div class="pull-right grid-tools">
                            <a data-widget="collapse" title="Collapse" data-toggle="tooltip" data-placement="left" ><i class="fa fa-chevron-up"></i></a>
                        </div>
                    </div>
                    <div class="grid-body">
                        <div id="container" ></div>
                    </div>
                </div>
            </div>

            <script type="text/javascript">
                        var chart2;
                        $(document).ready(function() {
                chart2 = new Highcharts.Chart({
                chart: {
                renderTo: 'container1',
                        type: 'bar',
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
                valuePrefix: 'Rp.'
                },
                        title: {
                text: ''
                },
                        xAxis: {
                categories: ['budget plan capex']
                },
                        yAxis: {
                title: {
                text: 'Budget per number'
                }
                },
                        series: [
<?php
foreach ($data_capex_detail as $row) {
    ?>
                    {
                    name: '<?php echo $row->INT_NO_BUDGET_CPX_TEMP . '[' . $row->CHR_SECTION . ']'; ?>',
                            data: [<?php echo $row->DEC_PRICE_PER_UNIT; ?>]
                    },
<?php } ?>
                ]
                });
                });
            </script>


            <div class="col-md-12">
                <div class="grid">
                    <div class="grid-header">
                        <i class="fa fa-bar-chart-o"></i>
                        <span class="grid-title"><strong>BUDGET </strong>PLANNING CHART</span>
                        <div class="pull-right grid-tools">
                            <a data-widget="collapse" title="Collapse" data-toggle="tooltip" data-placement="left" ><i class="fa fa-chevron-up"></i></a>
                        </div>
                    </div>
                    <div class="grid-body">
                        <div id="container1"></div>
                    </div>
                </div>
            </div>
            
        </div>

    </section>
</aside>