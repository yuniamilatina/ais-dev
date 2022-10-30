<script type="text/javascript">
    $(document).ready(function() {
        $("#INT_ID_DEPT").focusout(function() {
            $.ajax({
                url: "<?php echo base_url(); ?>index.php/budget/budget_expense_c/gen_ddl_section",
                data: {INT_ID_DEPT: $(this).val()}, type: "POST",
                success: function(data) {
                    $("#SECTION").html(data);
                }
            });

            $.ajax({
                url: "<?php echo base_url(); ?>index.php/budget/budget_expense_c/null_category",
                data: {INT_ID_DEPT: $(this).val()}, type: "POST",
                success: function(data) {
                    $("#BUDGET_CATEGORY").html(data);
                }
            });

            $.ajax({
                url: "<?php echo base_url(); ?>index.php/budget/budget_expense_c/show_more",
                data: {BUDGET_SUBGROUP: $('#BUDGET_SUBGROUP').val(), INT_ID_DEPT: $('#INT_ID_DEPT').val()}, type: "POST",
                success: function(data) {
                    $("#subcontent").html(data);
                }
            });
        });
//BUDGET_CATEGORY
        $("#INT_ID_DEPT").change(function() {
            $.ajax({
                url: "<?php echo base_url(); ?>index.php/budget/budget_expense_c/gen_ddl_section",
                data: {INT_ID_DEPT: $(this).val()}, type: "POST",
                success: function(data) {
                    $("#SECTION").html(data);
                }
            });

            $.ajax({
                url: "<?php echo base_url(); ?>index.php/budget/budget_expense_c/null_category",
                data: {INT_ID_DEPT: $(this).val()}, type: "POST",
                success: function(data) {
                    $("#BUDGET_CATEGORY").html(data);
                }
            });
            $.ajax({
                url: "<?php echo base_url(); ?>index.php/budget/budget_expense_c/show_more",
                data: {BUDGET_SUBGROUP: $('#BUDGET_SUBGROUP').val(), INT_ID_DEPT: $('#INT_ID_DEPT').val()}, type: "POST",
                success: function(data) {
                    $("#subcontent").html(data);
                }
            });
        });

        $("#BUDGET_SUBGROUP").change(function() {
            $.ajax({
                url: "<?php echo base_url(); ?>index.php/budget/budget_expense_c/show_more",
                data: {BUDGET_SUBGROUP: $(this).val(),
                    INT_ID_DEPT: $('#INT_ID_DEPT').val(),
                }, type: "POST",
                success: function(data) {
                    $("#subcontent").html(data);
                }
            });

        });
        $("#BUDGET_SUBGROUP").focusout(function() {
            $.ajax({
                url: "<?php echo base_url(); ?>index.php/budget/budget_expense_c/show_more",
                data: {BUDGET_SUBGROUP: $(this).val(), INT_ID_DEPT: $('#INT_ID_DEPT').val()}, type: "POST",
                success: function(data) {
                    $("#subcontent").html(data);
                }
            });

        });


        $("#INT_ID_FISCAL_YEAR").change(function() {
            $.ajax({
                url: "<?php echo base_url(); ?>index.php/budget/budget_expense_c/gen_fiscal_month",
                data: {INT_ID_FISCAL_YEAR: $(this).val()}, type: "POST",
                success: function(data) {
                    $("#fiscal_month").html(data);
                }
            });
        });
        $("#INT_ID_FISCAL_YEAR").focusout(function() {
            $.ajax({
                url: "<?php echo base_url(); ?>index.php/budget/budget_expense_c/gen_fiscal_month",
                data: {INT_ID_FISCAL_YEAR: $(this).val()}, type: "POST",
                success: function(data) {
                    $("#fiscal_month").html(data);
                }
            });
        });

    });
</script> 

<aside class="right-side">
    <?php
    $u=null;
    $head=null;
    if($unbudget!=NULL){
        $u='u';
        $head='UN';
    }
    ?>
    <!-- BEGIN CONTENT HEADER -->
    <section class="content-header">
        <ol class="breadcrumb">
            <li><a href="<?php echo base_url('index.php/budget/home_c/"') ?>">Home</a></li>
            <li><a href="<?php echo base_url('index.php/budget/budget_expense_c/"') ?>">Manage Budget Expense</a></li>
            <li class="active"> <a href="<?php echo base_url('index.php/budget/budget_expense_c/create_expense/'.$u.'"') ?>"><strong>Create Budget Expense</strong></a></li>
        </ol>
    </section>
    <!-- END CONTENT HEADER -->

    <!-- BEGIN MAIN CONTENT -->
    <section class="content">

        <div class="row">
            <!-- BEGIN BASIC ELEMENTS -->

            <div class="grid">
                <div class="grid-header">
                    <i class="fa fa-certificate"></i>
                    <span class="grid-title">CREATE <strong><?php echo $head ?></strong>BUDGET <strong>EXPENSE</strong></span>
                    <div class="pull-right grid-tools">
                        <a data-widget="collapse" title="Collapse"><i class="fa fa-chevron-up"></i></a>
                    </div>
                </div>
                <div class="grid-body">
                    <?php echo form_open('budget/budget_expense_c/save_budget_expense/'.$u, 'class="form-horizontal"'); ?>
                    <?php
                    $session = $this->session->all_userdata();
                    if (($session['ROLE'] == '2') or ($session['ROLE'] == '1')) {
                        ?>
                        <div class=" form-group">
                            <label class="col-sm-2 control-label">Department</label>
                            <div class="col-sm-3">
                                <select autofocus name="INT_ID_DEPT" id="INT_ID_DEPT" required class="form-control" style="width:250px">
                                    <?php
                                    foreach ($dept as $isi) {
                                        ?>
                                        <option value="<?php echo $isi->INT_ID_DEPT; ?>"><?php echo $isi->CHR_DEPT . ' / ' . $isi->CHR_DEPT_DESC; ?></option>
                                        <?php
                                    }
                                    ?> 
                                </select>
                            </div>
                            <label class="col-sm-2 control-label">Section</label>
                            <div class="col-sm-3">
                                <select name="INT_ID_SECT" id="SECTION" required class="form-control" style="width:250px">
                                    <option value="">  -- Select Section -- </option>  
                                </select>  
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-2 control-label">Budget Sub Group</label>
                            <div class="col-sm-3">   
                                <select name="BUDGET_SUBGROUP" id="BUDGET_SUBGROUP" required class="form-control" style="width:250px">
                                    <option value=""> -- Select Budget Type -- </option>
                                    <?php
                                    foreach ($subgroup as $isi) {
                                        ?>
                                        <option value="<?php echo $isi->INT_ID_BUDGET_SUBGROUP; ?>"><?php echo $isi->CHR_BUDGET_SUBGROUP_DESC; ?></option>
                                        <?php
                                    }
                                    ?> 
                                </select>
                            </div>
                            <label class="col-sm-2 control-label">Fiscal Year</label>
                            <div class="col-sm-3">
                                <select name="INT_ID_FISCAL_YEAR" id="INT_ID_FISCAL_YEAR" required class="form-control" style="width:250px">
                                    <option value=""> -- Select Fiscal Year -- </option>
                                    <?php
                                    foreach ($data_fiscal as $isi) {
                                        ?>
                                        <option value="<?php echo $isi->INT_ID_FISCAL_YEAR; ?>"><?php echo $isi->CHR_FISCAL_YEAR; ?></option>
                                        <?php
                                    }
                                    ?> 

                                </select>
                            </div>


                        </div>
                    <? } else if ($session['ROLE'] == '6') { ?>
                    <div hidden class=" form-group">
                            <label class="col-sm-2 control-label">Department</label>
                            <div class="col-sm-3">
                                <select   name="INT_ID_DEPT" id="INT_ID_DEPT" required class="form-control" style="width:250px">
                                    <option value="<?php echo $organization->INT_ID_DEPT; ?>"><?php echo $organization->CHR_DEPT_DESC; ?></option>
                                </select>
                            </div>
                            <label class="col-sm-2 control-label">Section <?php echo $organization->INT_ID_SECTION ?></label>

                            <div class="col-sm-3">
                                <select name="INT_ID_SECT"  id="INT_ID_SECT" required class="form-control" style="width:250px">
                                    <option value="<?php echo $organization->INT_ID_SECTION; ?>"><?php echo $organization->CHR_SECTION_DESC; ?></option>
                                </select>  
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-2 control-label">Budget Sub Group</label>
                            <div class="col-sm-3">   
                                <select autofocus name="BUDGET_SUBGROUP" id="BUDGET_SUBGROUP" required class="form-control" style="width:250px">
                                    
                                    <?php
                                    foreach ($subgroup as $isi) {
                                        ?>
                                        <option value="<?php echo $isi->INT_ID_BUDGET_SUBGROUP; ?>"><?php echo $isi->CHR_BUDGET_SUBGROUP_DESC; ?></option>
                                        <?php
                                    }
                                    ?> 
                                </select>
                            </div>
                            <label class="col-sm-2 control-label">Fiscal Year</label>
                            <div class="col-sm-3">
                                <select name="INT_ID_FISCAL_YEAR" id="INT_ID_FISCAL_YEAR" required class="form-control" style="width:250px">
                                    <option value=""> -- Select Fiscal Year -- </option>
                                    <?php
                                    foreach ($data_fiscal as $isi) {
                                        ?>
                                        <option value="<?php echo $isi->INT_ID_FISCAL_YEAR; ?>"><?php echo $isi->CHR_FISCAL_YEAR; ?></option>
                                        <?php
                                    }
                                    ?> 

                                </select>
                            </div>


                        </div>
                        <?php
                    } else {
                        redirect('fail_c/auth');
                    }
                    ?>

                    <div class="form-group">
                        <label class="col-sm-2 control-label">Budget Planning Name</label>
                        <div class="col-sm-3">
                            <input name="CHR_BUDGET_NAME" autocomplete="off" id="CHR_BUDGET_NAME" class="form-control" style="width:250px" maxlength="50" required type="text">
                        </div>
                        <label class="col-sm-2 control-label">Budget Allocation</label>
                        <div class="col-sm-3">
                            <select name="BUDGET_ALLOCATION" id="BUDGET_ALLOCATION" class="form-control" required style="width:250px">
                                <option value="1">Regular (Preventive)</option>
                                <option value="2">Irregular</option>
                                <option value="3">New Project</option>
                            </select>
                        </div>
                    </div>

                    <div id="subcontent" class="col-sm-12">
                        <?php
                        if ($subcontent != NULL) {
                            $this->load->view($subcontent);
                        }
                        ?>
                    </div>

                    <div class="form-group"><hr></div>
                        <?php echo form_close(); ?>


                </div>

                <!-- END BASIC ELEMENTS -->
            </div>


    </section>
    <!-- END MAIN CONTENT -->
</aside>