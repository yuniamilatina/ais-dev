<script type="text/javascript">
    $(document).ready(function() {
        $("#selectdept").change(function() {
            $.ajax({
                url: "<?php echo base_url(); ?>index.php/budget/capex_plan_temp_c/buildDropSection",
                data: {id: $(this).val()}, type: "POST",
                success: function(data) {
                    $("#section").html(data);
                }
            });
        });
    });
</script> 

<script type="text/javascript">
    $(document).ready(function() {
        $("#selectdept").focusout(function() {
            $.ajax({
                url: "<?php echo base_url(); ?>index.php/budget/capex_plan_temp_c/buildDropSection",
                data: {id: $(this).val()}, type: "POST",
                success: function(data) {
                    $("#section").html(data);
                }
            });
        });
    });
</script> 

<script type="text/javascript">
    $(document).ready(function() {
        $("#selectbudget").change(function() {
            $.ajax({
                url: "<?php echo base_url(); ?>index.php/budget/capex_plan_temp_c/buildsubcategory",
                data: {id: $(this).val()}, type: "POST",
                success: function(data) {
                    $("#budgetsubcategory").html(data);
                }
            });
        });
    });
</script>


<aside class="right-side">
    <section class="content-header">
        <ol class="breadcrumb">
            <li><a href="<?php echo base_url('index.php/basis/home_c/') ?>">Home</a></li>
            <li><a href="<?php echo base_url('index.php/budget/capex_plan_temp_c/') ?>">Manage Budget Capex</a></li>            
            <li> <a href="#"><strong>Edit Budget Planning</strong></a></li>
        </ol> 
    </section>

    <section class="content">
        <?php
        if (validation_errors()) {
            echo '<div class = "alert alert-danger"><strong>WARNING !</strong>' . validation_errors() . '</div >';
        }
        echo form_open('budget/capex_plan_temp_c/update_budgetcapex', 'class="form-horizontal"');
        ?>

        <div class="row">
            <div class="col-md-12">
                <div class="grid">
                    <div class="grid-header">
                        <i class="fa fa-pencil"></i>
                        <span class="grid-title"><strong>EDIT</strong> BUDGET PLANNING</span>
                        <div class="pull-right grid-tools">
                            <a data-widget="collapse" title="Collapse"><i class="fa fa-chevron-up"></i></a>
                        </div>
                    </div>
                    <div class="grid-body">
                        <input name="INT_NO_BUDGET_CPX_TEMP" class="form-control" required type="hidden" value="<?php echo $data->INT_NO_BUDGET_CPX_TEMP; ?>">

                        <?php $session = $this->session->all_userdata(); ?>
                        <?php if ($session['ROLE'] === 1 || $session['ROLE'] === 2) { ?>

                            <div class="form-group">
                                <label class="col-sm-2 control-label">Fiscal Year</label>
                                <div class="col-sm-5">
                                    <select name="INT_ID_FISCAL_YEAR" class="form-control" style="width:120px;">
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
                                </div>
                            </div>

                            <div class="form-group">
                                <label class="col-sm-2 control-label">Department</label>
                                <div class="col-sm-3">
                                    <select name="INT_ID_DEPT" id="selectdept" class="form-control" style="width:250px">
                                        <?php
                                        foreach ($data_dept as $isi) {
                                            if ($data->INT_ID_DEPT == $isi->INT_ID_DEPT) {
                                                ?> 
                                                <option selected="true" value="<?php echo $isi->INT_ID_DEPT; ?>"><?php echo $isi->CHR_DEPT . ' - ' . $isi->CHR_DEPT_DESC; ?></option>
                                            <?php } else { ?>
                                                <option value="<?php echo $isi->INT_ID_DEPT; ?>"><?php echo $isi->CHR_DEPT . ' - ' . $isi->CHR_DEPT_DESC; ?></option>
                                                <?php
                                            }
                                        }
                                        ?> 
                                    </select>
                                </div>

                                <label class="col-sm-2 control-label">Section</label>
                                <div class="col-sm-4">
                                    <select name="INT_ID_SECTION" id="section" class="form-control" style="width:250px">
                                        <?php
                                        foreach ($data_section as $isi) {
                                            if ($data->INT_ID_SECTION == $isi->INT_ID_SECTION) {
                                                ?> 
                                                <option selected="true" value="<?php echo $isi->INT_ID_SECTION; ?>"><?php echo $isi->CHR_SECTION . ' - ' . $isi->CHR_SECTION_DESC; ?></option>
                                            <?php } else { ?>
                                                <option value="<?php echo $isi->INT_ID_SECTION; ?>"><?php echo $isi->CHR_SECTION . ' - ' . $isi->CHR_SECTION_DESC; ?></option>
                                                <?php
                                            }
                                        }
                                        ?> 
                                    </select>
                                </div> 
                            </div>

                            <hr>
                        <?php } ?>

                        <div class="form-group">
                            <label class="col-sm-2 control-label">CIP Type</label>
                            <div class="col-sm-3">
                                <?php if ($data->CIP === 0) { ?>
                                    <label class="radio-inline"><input type="radio" name="BIT_FLG_CIP" class="icheck" value=FALSE checked> CIP</label>
                                    <label class="radio-inline"><input type="radio" name="BIT_FLG_CIP" class="icheck" value=TRUE> Non-CIP</label>
                                <?php } else if ($data->CIP === 1) { ?>
                                    <label class="radio-inline"><input type="radio" name="BIT_FLG_CIP" class="icheck" value=FALSE> CIP</label>
                                    <label class="radio-inline"><input type="radio" name="BIT_FLG_CIP" class="icheck" value=TRUE checked> Non-CIP</label>
                                <?php } ?>
                            </div>

                            <label class="col-sm-2 control-label">Type</label>
                            <div class="col-sm-5">
                                <?php if ($data->NEW === 0) { ?>
                                    <label class="radio-inline"><input type="radio" name="BIT_FLG_NEW" class="icheck" value=FALSE checked>  New</label>
                                    <label class="radio-inline"><input type="radio" name="BIT_FLG_NEW" class="icheck" value=TRUE>  Carry Over</label>
                                <?php } else if ($data->NEW === 1) { ?>
                                    <label class="radio-inline"><input type="radio" name="BIT_FLG_NEW" class="icheck" value=FALSE>  New</label>
                                    <label class="radio-inline"><input type="radio" name="BIT_FLG_NEW" class="icheck" value=TRUE checked>  Carry Over</label>
                                <?php } ?>
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="col-sm-2 control-label">Category</label>
                            <div class="col-sm-3">
                                <select name="INT_ID_BUDGET_CATEGORY" id="selectbudget" class="form-control" style="width:250px">
                                    <?php
                                    foreach ($data_budgetcategory as $isi) {
                                        if ($data->INT_ID_BUDGET_CATEGORY == $isi->INT_ID_BUDGET_CATEGORY) {
                                            ?> 
                                            <option selected="true" value="<?php echo $isi->INT_ID_BUDGET_CATEGORY; ?>"><?php echo $isi->CHR_BUDGET_CATEGORY . ' - ' . $isi->CHR_BUDGET_CATEGORY_DESC; ?></option>
                                        <?php } else { ?>
                                            <option value="<?php echo $isi->INT_ID_BUDGET_CATEGORY; ?>"><?php echo $isi->CHR_BUDGET_CATEGORY . ' - ' . $isi->CHR_BUDGET_CATEGORY_DESC; ?></option>
                                            <?php
                                        }
                                    }
                                    ?> 
                                </select>
                            </div>

                            <label class="col-sm-2 control-label">Sub Category</label>
                            <div class="col-sm-5">
                                <select name="INT_ID_BUDGET_SUB_CATEGORY" id="budgetsubcategory" class="form-control" style="width:300px">
                                    <?php
                                    foreach ($data_budgetsubcategory as $isi) {
                                        if ($data->INT_ID_BUDGET_SUB_CATEGORY == $isi->INT_ID_BUDGET_SUB_CATEGORY) {
                                            ?> 
                                            <option selected="true" value="<?php echo $isi->INT_ID_BUDGET_SUB_CATEGORY; ?>"><?php echo $isi->CHR_BUDGET_SUB_CATEGORY . ' - ' . $isi->CHR_BUDGET_SUB_CATEGORY_DESC; ?></option>
                                        <?php } else { ?>
                                            <option value="<?php echo $isi->INT_ID_BUDGET_SUB_CATEGORY; ?>"><?php echo $isi->CHR_BUDGET_SUB_CATEGORY . ' - ' . $isi->CHR_BUDGET_SUB_CATEGORY_DESC; ?></option>
                                            <?php
                                        }
                                    }
                                    ?> 
                                </select>
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="col-sm-2 control-label">Purpose Budget</label>
                            <div class="col-sm-3">
                                <select name="INT_ID_PURPOSE" class="form-control" style="width:250px">
                                    <?php
                                    foreach ($data_purposebudget as $isi) {
                                        if ($data->INT_ID_PURPOSE == $isi->INT_ID_PURPOSE) {
                                            ?> 
                                            <option selected="true" value="<?php echo $isi->INT_ID_PURPOSE; ?>"><?php echo $isi->CHR_PURPOSE . ' - ' . $isi->CHR_PURPOSE_DESC; ?></option>
                                        <?php } else { ?>
                                            <option value="<?php echo $isi->INT_ID_PURPOSE; ?>"><?php echo $isi->CHR_PURPOSE . ' - ' . $isi->CHR_PURPOSE_DESC; ?></option>
                                            <?php
                                        }
                                    }
                                    ?> 
                                </select>
                            </div>
                        </div>



                        <div class="form-group">
                            <label class="col-sm-2 control-label">Owner</label>
                            <div class="col-sm-3">
                                <?php if ($data->OWNER === 0) { ?>
                                    <label class="radio-inline"><input type="radio" name="BIT_FLG_OWNER" class="icheck" value=FALSE checked> Aisin</label>
                                    <label class="radio-inline"><input type="radio" name="BIT_FLG_OWNER" class="icheck" value=TRUE> Customer</label>
                                <?php } else if ($data->OWNER === 1) { ?>
                                    <label class="radio-inline"><input type="radio" name="BIT_FLG_OWNER" class="icheck" value=FALSE> Aisin</label>
                                    <label class="radio-inline"><input type="radio" name="BIT_FLG_OWNER" class="icheck" value=TRUE checked> Customer</label>
                                <?php } ?>
                            </div>
                            <label class="col-sm-2 control-label">Supplier</label>
                            <div class="col-sm-3">
                                <?php if ($data->LOCAL === 0) { ?>
                                    <label class="radio-inline"><input type="radio" name="BIT_FLG_LOCAL" class="icheck" value=FALSE checked> Local</label>
                                    <label class="radio-inline"><input type="radio" name="BIT_FLG_LOCAL" class="icheck" value=TRUE> Import</label>
                                <?php } else if ($data->LOCAL === 1) { ?>
                                    <label class="radio-inline"><input type="radio" name="BIT_FLG_LOCAL" class="icheck" value=FALSE> Local</label>
                                    <label class="radio-inline"><input type="radio" name="BIT_FLG_LOCAL" class="icheck" value=TRUE checked> Import</label>
                                <?php } ?>
                            </div>
                        </div>

                        <hr>

                        <div class="form-group">
                            <label class="col-sm-2 control-label">Project</label>
                            <div class="col-sm-3">
                                <select name="INT_ID_PROJECT[]" multiple id="e1" class="form-control" style="width:250px">
                                    <?php
                                    foreach ($data_project as $isi) {
                                        if ($data->INT_ID_PROJECT == $isi->INT_ID_PROJECT) {
                                            ?> 
                                            <option selected="true" value="<?php echo $isi->INT_ID_PROJECT; ?>"><?php echo $isi->CHR_PROJECT . ' - ' . $isi->CHR_PROJECT_DESC; ?></option>
                                        <?php } else { ?>
                                            <option value="<?php echo $isi->INT_ID_PROJECT; ?>"><?php echo $isi->CHR_PROJECT . ' - ' . $isi->CHR_PROJECT_DESC; ?></option>
                                            <?php
                                        }
                                    }
                                    ?> 
                                </select>
                            </div>

                            <label class="col-sm-2 control-label">Product</label>
                            <div class="col-sm-5">
                                <select name="INT_ID_PRODUCT[]" multiple id="e2" class="form-control" style="width:300px">
                                    <?php
                                    foreach ($data_product as $isi) {
                                        if ($data->INT_ID_PRODUCT == $isi->INT_ID_PRODUCT) {
                                            ?> 
                                            <option selected="true" value="<?php echo $isi->INT_ID_PRODUCT; ?>"><?php echo $isi->CHR_PRODUCT . ' - ' . $isi->CHR_PRODUCT_DESC; ?></option>
                                        <?php } else { ?>
                                            <option value="<?php echo $isi->INT_ID_PRODUCT; ?>"><?php echo $isi->CHR_PRODUCT . ' - ' . $isi->CHR_PRODUCT_DESC; ?></option>
                                            <?php
                                        }
                                    }
                                    ?>
                                </select>
                            </div>
                        </div>

                        <hr>

                        <div class="form-group">
                            <label class="col-sm-3 control-label">Budget Description <b class="mandatory">*</b></label>
                            <div class="col-sm-6">
                                <input name="CHR_BUDGET_NAME" class="form-control" maxlength="50" required type="text" value="<?php echo trim($data->CHR_BUDGET_NAME); ?>">
                            </div>
                        </div>

                        <hr>

                        <div class="form-group">
<!--                            <label class="col-sm-2 control-label">Currency</label>
                            <div class="col-sm-3">  
                                <select name="INT_ID_CURRENCY" id="CURRENCY" class="form-control" style="width:250px">
                                    <?php
                                    foreach ($data_currency as $isi) {
                                        if ($data->INT_ID_CURRENCY == $isi->INT_ID_CURRENCY) {
                                            ?> 
                                            <option selected="true" value="<?php echo $isi->INT_ID_CURRENCY; ?>"><?php echo $isi->CHR_CURRENCY . ' - ' . $isi->CHR_CURRENCY_DESC; ?></option>
                                        <?php } else { ?>
                                            <option value="<?php echo $isi->INT_ID_CURRENCY; ?>"><?php echo $isi->CHR_CURRENCY . ' - ' . $isi->CHR_CURRENCY_DESC; ?></option>
                                            <?php
                                        }
                                    }
                                    ?> 
                                </select>
                            </div>-->
                            <label class="col-sm-2 control-label">UoM</label>
                            <div class="col-sm-3">  
                                <select name="INT_ID_UNIT" id="UOM_input" class="form-control" style="width:200px">
                                    <?php
                                    foreach ($data_unit as $isi) {
                                        if ($data->INT_ID_UNIT == $isi->INT_ID_UNIT) {
                                            ?> 
                                            <option selected="true" value="<?php echo $isi->INT_ID_UNIT; ?>"><?php echo $isi->CHR_UNIT . ' - ' . $isi->CHR_UNIT_DESC; ?></option>
                                        <?php } else { ?>
                                            <option value="<?php echo $isi->INT_ID_UNIT; ?>"><?php echo $isi->CHR_UNIT . ' - ' . $isi->CHR_UNIT_DESC; ?></option>
                                            <?php
                                        }
                                    }
                                    ?>
                                </select>
                            </div>
                        </div>

                        <div class="form-group">
                            <div class="col-sm-offset-4 col-sm-6">
                                <div class="btn-group">
                                    <button type="submit" class="btn btn-primary"><i class="fa fa-refresh"></i> Update</button>
                                    <?php
                                    echo anchor('budget/capex_plan_temp_c', 'Cancel', 'class="btn btn-default"');
                                    echo form_close();
                                    ?>
                                </div>
                            </div>
                        </div>
                        <b class="mandatory">*</b>= mandatory
                    </div>
                </div>
            </div>
        </div>


    </section>
</aside>