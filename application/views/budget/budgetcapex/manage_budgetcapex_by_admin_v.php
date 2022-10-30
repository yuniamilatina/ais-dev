<script type="text/javascript">
    $(document).ready(function() {
        $("#fiscal").change(function() {
            $.ajax({
                url: "<?php echo base_url(); ?>index.php/budget/capex_plan_temp_c/change_datacapex",
                data: {id: $(this).val()}, type: "POST",
                success: function(data) {
                    $("#data").html(data);
                }
            });
        });
    });
</script>

<aside class="right-side">
    <section class="content-header">
        <ol class="breadcrumb">
            <li><a href="<?php echo base_url('index.php/basis/home_c/') ?>"><span>Home</span></a></li>
            <li> <a href="<?php echo base_url('index.php/budget/capex_plan_temp_c/') ?>"><strong>Manage Budget Capex</strong></a></li>
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
                        <i class="fa fa-shopping-cart"></i>
                        <span class="grid-title"><strong>PLANNING</strong> CAPEX <?php echo $fiscal ?></span>
                        <div class="pull-right grid-tools">
                            <?php if ($stat_commit == 0 && $permit_approve == 0) { ?>
                                <a href="<?php echo base_url('index.php/budget/capex_plan_temp_c/create_budgetcapex/') ?>" data-placement="left" class="btn btn-default" data-toggle="tooltip" title="Create Planning Capex" style="height:30px;font-size:13px;width:100px;">Create</a>
                            <?php } ?>
                        </div>
                    </div>
                    <div class="grid-body">
                        <strong>Has approved by :</strong>
                        <div class="pull btn-group">
                            <table class="table table-condensed table-bordered display" style='border:1px solid #cccccc;text-align: center'>
                                <tr>
                                    <td class="gradeX default"><a href="<?php echo base_url('index.php/budget/capex_plan_temp_c/select_no_approves'); ?>" style="color:#666666;">No one</a></td>
                                    <td class="gradeX warning"><a href="<?php echo base_url('index.php/budget/capex_plan_temp_c/select_manager_approves'); ?>" style="color:#666666;">Manager</a></td>
                                    <td class="gradeX success" style='width:60px'><a href="<?php echo base_url('index.php/budget/capex_plan_temp_c/select_gm_approves'); ?>" style="color:#666666;">GM</a></td>
                                    <td class="gradeX info"><a href="<?php echo base_url('index.php/budget/capex_plan_temp_c/select_director_approves'); ?>" style="color:#666666;">Director</a></td>
                                    <td class="gradeX danger"><a href="<?php echo base_url('index.php/budget/capex_plan_temp_c/select_rejected'); ?>" style="color:#666666;">Reject</a></td>
                                </tr>
                            </table>
                        </div>
                        <table id="dataTables1" class="table table-condensed table-hover display" cellspacing="0" width="100%">
                            <thead>
                                <tr>
                                    <th>No</th>
                                    <th>No Budget</th>
                                    <th>Section</th>
                                    <th>Sub Category</th>
                                    <th>Purpose</th>
                                    <th>Budget Name</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                $i = 1;
                                $session = $this->session->all_userdata();
                                foreach ($data as $isi) {

                                    if ($isi->INT_APPROVE1 == 1 && $isi->INT_APPROVE2 != 1 && $isi->INT_APPROVE3 != 1) {
                                        echo "<tr class='gradeX warning'>";
                                    } else if ($isi->INT_APPROVE1 == 1 && $isi->INT_APPROVE2 == 1 && $isi->INT_APPROVE3 != 1) {
                                        echo "<tr class='gradeX success'>";
                                    } else if ($isi->INT_APPROVE1 == 1 && $isi->INT_APPROVE2 == 1 && $isi->INT_APPROVE3 == 1) {
                                        echo "<tr class='gradeX info'>";
                                    } else if ($isi->INT_APPROVE1 == 2 || $isi->INT_APPROVE2 == 2 || $isi->INT_APPROVE3 == 2) {
                                        echo "<tr class='gradeX danger'>";
                                    } else if ($isi->INT_APPROVE1 == 0 && $isi->INT_APPROVE2 == 0 && $isi->INT_APPROVE3 == 0) {
                                        echo "<tr class='gradeX default'>";
                                    }

                                    echo "<td>$i</td>";
                                    echo "<td>$isi->INT_NO_BUDGET_CPX_TEMP</td>";
                                    echo "<td>$isi->CHR_SECTION</td>";
                                    echo "<td>$isi->CHR_BUDGET_SUB_CATEGORY_DESC</td>";
                                    echo "<td>$isi->CHR_PURPOSE_DESC</td>";
                                    echo "<td>$isi->CHR_BUDGET_NAME</td>";
                                    ?>
                                <td>
                                    <a href="<?php echo base_url('index.php/budget/capex_plan_temp_c/view_detail_capex_plan') . "/" . $isi->INT_NO_BUDGET_CPX_TEMP ?>" class="label label-success" data-placement="left" data-toggle="tooltip" title="View"><span class="fa fa-check"></span></a>
                                    <?php if ($isi->INT_APPROVE1 == 0 || $isi->INT_APPROVE1 == 2) { ?>
                                        <a href="<?php echo base_url('index.php/budget/capex_plan_temp_c/edit_budgetcapex') . "/" . $isi->INT_NO_BUDGET_CPX_TEMP ?>" class="label label-warning" data-placement="top" data-toggle="tooltip" title="Edit"><span class="fa fa-pencil"></span></a>
                                    <?php } ?>
                                    <a href="<?php echo base_url('index.php/budget/capex_plan_temp_c/delete_budgetcapex') . "/" . $isi->INT_NO_BUDGET_CPX_TEMP ?>" class="label label-danger" data-placement="right" data-toggle="tooltip" title="Delete" onclick="return confirm('Are you sure want to delete this budget plan?');"><span class="fa fa-times"></span></a>
                                </td>
                                </tr>
                                <?php
                                $i++;
                            }
                            ?>
                            </tbody>
                        </table>
                    </div>
                    <?php if ($permit_approve == 1) { ?>
                    <div class="grid-header">                        
                        <div class="grid-body">
                            <div class="pull-right">
                                <div class="form-group">
                                    <div class="btn-group">
                                        <?php echo form_open('budget/capex_plan_temp_c/commit_capex_plan_temp', 'class="form-horizontal"'); ?>
                                        <input name="INT_ID_FISCAL_YEAR" value="<?php echo $this_fiscal_year ?>" id="jYear" type="hidden">
                                        <button type="submit" name="submit" class="btn btn-primary" data-toggle="tooltip" data-placement="left" title="Commit this budget" onclick="return confirm('Are you sure want to commit this budget?');"><i class="fa fa-thumbs-up"></i> Commit</button>
                                        <?php echo form_close(); ?>
                                    </div>
                                </div>
                            </div>                    
                        </div>                       
                    </div>
                    <?php } ?>

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
                categories: ['Budgeting per Number']
            },
            yAxis: {
                title: {
                    text: 'Amount'
                }
            },
            series: [
<?php
foreach ($data as $row) {
    ?>
                    {
                        name: '<?php echo $row->INT_NO_BUDGET_CPX_TEMP; ?>',
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
                        <span class="grid-title"><strong>BUDGET</strong> CAPEX PLAN CHART</span>
                        <div class="pull-right grid-tools">
                            <a data-widget="collapse" title="Collapse" data-toggle="tooltip" data-placement="left" ><i class="fa fa-chevron-up"></i></a>
                        </div>
                    </div>
                    <div class="grid-body">
                        <div id="container"></div>
                    </div>
                </div>
            </div>

        </div>

    </section>
</aside>