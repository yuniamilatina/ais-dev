<script type="text/javascript">
    $(document).ready(function() {
        $("#fiscal").change(function() {
            $.ajax({
                url: "<?php echo base_url(); ?>index.php/budget/capex_plan_c/change_datacapex",
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
            <li><a href="<?php echo base_url('index.php/basis/home_c/"') ?>"><span>Home</span></a></li>
            <li> <a href="#"><strong>Manage Budget Capex</strong></a></li>
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
                <div class="grid ">
                    <div class="grid-header">
                        <i class="fa fa-th-large"></i>
                        <span class="grid-title"><strong>PLANNING</strong> CAPEX BUDGET</span>
                        <div class="pull-right grid-tools">
                            <a data-widget="collapse" title="Collapse"><i class="fa fa-chevron-up"></i></a>
                        </div>
                    </div>
                    <div class="grid-body">
                        <div class="pull">
                            <?php echo form_open('budget/capex_plan_c/search_budgetcapex', 'class="form-horizontal"'); ?>

                            <select name="INT_ID_FISCAL_YEAR" id="fiscal" class="ddl">
                                <?php
                                foreach ($data_fiscal as $isi) {
                                    if ($new_fiscal == $isi->INT_ID_FISCAL_YEAR) {
                                        ?> 
                                        <option selected="true" value="<?php echo $isi->INT_ID_FISCAL_YEAR; ?>"><?php echo $isi->CHR_FISCAL_YEAR; ?></option>
                                    <?php } else { ?>
                                        <option value="<?php echo $isi->INT_ID_FISCAL_YEAR; ?>"><?php echo $isi->CHR_FISCAL_YEAR; ?></option>
                                        <?php
                                    }
                                }
                                ?> 
                            </select>

                            <button type="submit" class="btn btn-default" data-toggle="tooltip" data-placement="right" title="Search" style="height:30px"><i class="fa fa-search"></i></button>
                            <?php echo form_close(); ?>

                        </div>
                        <?php
                        echo form_open('budget/capex_plan_c/print_capex_by_dept', 'class="form-horizontal"');
                        ?>
                        <table id='dataTables3' class="table table-condensed table-striped table-hover display" cellspacing="0" width="100%">
                            <thead>
                                <tr>
                                    <th>No</th>
                                    <th>No Budget</th>
                                    <th>Category</th>
                                    <th>Sub Category</th>
                                    <th>Purpose</th>
                                    <th>Section</th>
                                    <th>Budget Name</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                $r = 1;
                                $session = $this->session->all_userdata();
                                foreach ($data as $isi) {

                                    echo "<tr class='gradeX'>";
                                    echo "<td>$r</td>";
                                    echo "<td>$isi->INT_NO_BUDGET_CPX</td>";
                                    echo "<td>$isi->CHR_BUDGET_CATEGORY_DESC</td>";
                                    echo "<td>$isi->CHR_BUDGET_SUB_CATEGORY_DESC</td>";
                                    echo "<td>$isi->CHR_PURPOSE_DESC</td>";
                                    echo "<td>$isi->CHR_SECTION</td>";
                                    echo "<td>$isi->CHR_BUDGET_NAME</td>";
                                    ?>
                                <td>
                                    <a href="<?php echo base_url('index.php/budget/capex_plan_c/select_close_bc_by_id') . "/" . $isi->INT_NO_BUDGET_CPX ?>" class="label label-success" data-placement="left" data-toggle="tooltip" title="View"><span class="fa fa-check"></span></a>
                                </td>
                                </tr>
                                <?php
                                $r++;
                            }
                            ?>
                            </tbody>
                        </table>
                    </div>
                    <div class="grid-header">                        
                        <div class="pull-left">
                            <div class="form-group">
                                <div class="btn-group">
                                    <input name="INT_ID_FISCAL" value="<?php echo $new_fiscal ?>" type="hidden">
                                    <button type="submit" name="submit" class="btn btn-primary" data-toggle="tooltip" data-placement="right" title="Print this fiscal"><i class="fa fa-print"></i> Print</button>
                                    <?php echo form_close(); ?>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>


        </div>
    </section>
</aside>






