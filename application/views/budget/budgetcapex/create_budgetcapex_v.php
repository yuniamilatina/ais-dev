<script type="text/javascript">
    $(document).ready(function () {
        $("#selectdept").change(function () {
            $.ajax({
                url: "<?php echo base_url(); ?>index.php/budget/capex_plan_temp_c/buildDropSection",
                data: {id: $(this).val()}, type: "POST",
                success: function (data) {
                    $("#section").html(data);
                }
            });
        });
    });

    $(document).ready(function () {
        $("#selectdept").focusout(function () {
            $.ajax({
                url: "<?php echo base_url(); ?>index.php/budget/capex_plan_temp_c/buildDropSection",
                data: {id: $(this).val()}, type: "POST",
                success: function (data) {
                    $("#section").html(data);
                }
            });
        });
    });

    $(document).ready(function () {
        $("#selectsec").change(function () {
            $.ajax({
                url: "<?php echo base_url(); ?>index.php/budget/capex_plan_temp_c/buildDropSection",
                data: {id: $(this).val()}, type: "POST",
                success: function (data) {
                    $("#section").html(data);
                }
            });
        });
    });

    $(document).ready(function () {
        $("#selectbudget").change(function () {
            $.ajax({
                url: "<?php echo base_url(); ?>index.php/budget/capex_plan_temp_c/buildsubcategory",
                data: {id: $(this).val()}, type: "POST",
                success: function (data) {
                    $("#budgetsubcategory").html(data);
                }
            });
        });
    });
</script>

<script language="JavaScript">
    function replaceChars(entry) {
        out = "."; // replace this
        add = ""; // with this
        temp = "" + entry; // temporary holder

        while (temp.indexOf(out) > -1) {
            pos = temp.indexOf(out);
            temp = "" + (temp.substring(0, pos) + add +
                    temp.substring((pos + out.length), temp.length));
        }
        document.f.DEC_PRICE_PER_UNIT.value = temp;
    }

    function trimNumber(s) {
        while (s.substr(0, 1) == '0' && s.length > 1) {
            s = s.substr(1, 9999);
        }
        while (s.substr(0, 1) == '.' && s.length > 1) {
            s = s.substr(1, 9999);
        }
        return s;
    }

    function formatangka(objek) {
        a = objek.value;
        b = a.replace(/[^\d]/g, "");
        c = "";
        panjang = b.length;
        j = 0;
        for (i = panjang; i > 0; i--) {
            j = j + 1;
            if (((j % 3) == 1) && (j != 1)) {
                c = b.substr(i - 1, 1) + "." + c;
            } else {
                c = b.substr(i - 1, 1) + c;
            }
        }
        objek.value = trimNumber(c);
    }

    function angka(objek) {
        a = objek.value;
        b = a.replace(/[^\d]/g, "");
        c = "";
        panjang = b.length;
        j = 0;
        for (i = panjang; i > 0; i--) {
            j = j + 1;
            if (((j % 3) == 1) && (j != 1)) {
                c = b.substr(i - 1, 1) + "" + c;
            } else {
                c = b.substr(i - 1, 1) + c;
            }
        }
        objek.value = Number(c);
    }

    function Number(s) {
        while (s.substr(0, 1) == '0' && s.length > 1) {
            s = s.substr(1, 9999);
        }
        while (s.substr(0, 1) == '' && s.length > 1) {
            s = s.substr(1, 9999);
        }
        return s;
    }
</script>

<aside class="right-side">
    <section class="content-header">
        <ol class="breadcrumb">
            <li><a href="<?php echo base_url('index.php/home_c/"') ?>">Home</a></li>
            <li><a href="<?php echo base_url('index.php/budget/capex_plan_temp_c/"') ?>">Manage Budget Capex</a></li>
            <li class="active"> <a href="#"><strong>Create Planning Capex</strong></a></li>
        </ol>
    </section>

    <section class="content">
        <?php
        if (validation_errors()) {
            echo '<div class = "alert alert-danger"><strong>WARNING !</strong>' . validation_errors() . '</div >';
        }
        echo form_open('budget/capex_plan_temp_c/save_budgetcapex', 'class="form-horizontal" name="f" id="form-id"');
        ?>

        <div class="row">
            <div class="col-md-12">
                <div class="grid">
                    <div class="grid-header">
                        <i class="fa fa-shopping-cart"></i>
                        <span class="grid-title"><strong>CREATE</strong> CAPEX BUDGET PLANNING</span>
                        <div class="pull-right grid-tools">
                            <a data-widget="collapse" title="Collapse"><i class="fa fa-chevron-up"></i></a>
                        </div>
                    </div>
                    <div class="grid-body">

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
                                    <select autofocus name="INT_ID_DEPT" id="selectdept" class="form-control" style="width:250px">
                                        <?php
                                        foreach ($data_dept as $isi) {
                                            ?>
                                            <option value="<?php echo $isi->INT_ID_DEPT; ?>"><?php echo $isi->CHR_DEPT . ' - ' . $isi->CHR_DEPT_DESC; ?></option>
                                            <?php
                                        }
                                        ?> 
                                    </select>
                                </div>

                                <label class="col-sm-2 control-label">Section</label>
                                <div class="col-sm-4">
                                    <select name="INT_ID_SECTION" id="section" class="form-control" style="width:350px">
                                        <option value="">--Select Department First--</option>
                                    </select>  
                                </div>
                            </div>

                            <hr>
                        <?php } ?>

                        <div class="form-group">
                            <label class="col-sm-2 control-label">CIP Type</label>
                            <div class="col-sm-3">
                                <label class="radio-inline"><input type="radio" name="BIT_FLG_CIP" class="icheck" value=FALSE checked> CIP</label>
                                <label class="radio-inline"><input type="radio" name="BIT_FLG_CIP" class="icheck" value=TRUE> Non-CIP</label>
                            </div>

                            <label class="col-sm-2 control-label">Type</label>
                            <div class="col-sm-5">
                                <label class="radio-inline"><input type="radio" name="BIT_FLG_NEW" class="icheck" value=FALSE checked>  New</label>
                                <label class="radio-inline"><input type="radio" name="BIT_FLG_NEW" class="icheck" value=TRUE>  Carry Over</label>
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="col-sm-2 control-label">Category</label>
                            <div class="col-sm-3">
                                <select name="INT_ID_BUDGET_CATEGORY" id="selectbudget" class="form-control" style="width:250px">
                                    <?php
                                    foreach ($data_budgetcategory as $isi) {
                                        ?>
                                        <option value="<?php echo $isi->INT_ID_BUDGET_CATEGORY; ?>"><?php echo $isi->CHR_BUDGET_CATEGORY . ' - ' . $isi->CHR_BUDGET_CATEGORY_DESC; ?></option>
                                        <?php
                                    }
                                    ?> 
                                </select>
                            </div>

                            <label class="col-sm-2 control-label">Sub Category</label>
                            <div class="col-sm-5">
                                <select name="INT_ID_BUDGET_SUB_CATEGORY" id="budgetsubcategory" class="form-control" style="width:300px">
                                    <?php
                                    foreach ($data_budgetsubcategory as $isi) {
                                        ?>
                                        <option value="<?php echo $isi->INT_ID_BUDGET_SUB_CATEGORY; ?>"><?php echo $isi->CHR_BUDGET_SUB_CATEGORY . ' - ' . $isi->CHR_BUDGET_SUB_CATEGORY_DESC; ?></option>
                                        <?php
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
                                        ?>
                                        <option value="<?php echo $isi->INT_ID_PURPOSE; ?>"><?php echo $isi->CHR_PURPOSE . ' - ' . $isi->CHR_PURPOSE_DESC; ?></option>
                                        <?php
                                    }
                                    ?> 
                                </select>
                            </div>
                        </div>



                        <div class="form-group">
                            <label class="col-sm-2 control-label">Owner</label>
                            <div class="col-sm-4">
                                <label class="radio"><input onchange="document.getElementById('show-me').style.display = 'none';" type="radio" name="BIT_FLG_OWNER" value=FALSE checked> Aisin</label>
                                <label class="radio"><input onchange="document.getElementById('show-me').style.display = 'block';" type="radio" name="BIT_FLG_OWNER" value=TRUE> Customer</label>
                            </div>
                            <div id='show-me' style='display:none'>
                                <label class="col-sm-2 control-label">Supplier</label>
                                <div class="col-sm-3">
                                    <label class="radio-inline"><input type="radio" name="BIT_FLG_LOCAL" class="icheck" value=FALSE checked> Local</label>
                                    <label class="radio-inline"><input type="radio" name="BIT_FLG_LOCAL" class="icheck" value=TRUE> Import</label>
                                </div>
                            </div>
                        </div>

                        <hr>

                        <div class="form-group">
                            <label class="col-sm-2 control-label">Project</label>
                            <div class="col-sm-3">
                                <select name="INT_ID_PROJECT[]" multiple id="e1" class="form-control" style="width:250px">
                                    <?php
                                    foreach ($data_project as $isi) {
                                        ?>
                                        <option value="<?php echo $isi->INT_ID_PROJECT; ?>"><?php echo $isi->CHR_PROJECT . ' - ' . $isi->CHR_PROJECT_DESC; ?></option>
                                        <?php
                                    }
                                    ?> 
                                </select>
                            </div>

                            <label class="col-sm-2 control-label">Product</label>
                            <div class="col-sm-5">
                                <select name="INT_ID_PRODUCT[]" multiple id="e2" class="form-control" style="width:300px">
                                    <?php
                                    foreach ($data_product as $isi) {
                                        ?>
                                        <option value="<?php echo $isi->INT_ID_PRODUCT; ?>"><?php echo $isi->CHR_PRODUCT . ' - ' . $isi->CHR_PRODUCT_DESC; ?></option>
                                        <?php
                                    }
                                    ?> 
                                </select>
                            </div>
                        </div>

                        <hr>

                        <div class="form-group">
                            <label class="col-sm-3 control-label">Budget Description <b class="mandatory">*</b></label>
                            <div class="col-sm-6">
                                <input name="CHR_BUDGET_NAME" class="form-control" maxlength="50" required type="text">
                            </div>
                        </div>

                        <hr>

                        <div class="form-group">

                            <label class="col-sm-2 control-label">UoM </label>
                            <div class="col-sm-3">  
                                <select name="INT_ID_UNIT" id="UOM_input" class="form-control" style="width:160px">*
                                    <?php
                                    foreach ($unit as $isi) {
                                        ?>
                                        <option value="<?php echo $isi->INT_ID_UNIT; ?>"><?php echo $isi->CHR_UNIT . ' - ' . $isi->CHR_UNIT_DESC; ?></option>
                                        <?php
                                    }
                                    ?> 
                                </select>
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="col-sm-2 control-label">Month Plan</label>
                            <div class="col-sm-3">
                                <select name="INT_MONTH_PLAN" class="form-control" style="width:150px">
                                    <option value="1">January</option>
                                    <option value="2">February</option>
                                    <option value="3">March</option>
                                    <option value="4">April</option>
                                    <option value="5">May</option>
                                    <option value="6">June</option>
                                    <option value="7">July</option>
                                    <option value="8">August</option>
                                    <option value="9">September</option>
                                    <option value="10">October</option>
                                    <option value="11">November</option>
                                    <option value="12">December</option>
                                </select>
                            </div>
                            
                            <label class="col-sm-2 control-label">Run Depreciation</label>
                            <div class="col-sm-2">
                                <select name="CHR_DEPCY1" class="form-control" style="width:150px">
                                    <option value="01">January</option>
                                    <option value="02">February</option>
                                    <option value="03">March</option>
                                    <option value="04">April</option>
                                    <option value="05">May</option>
                                    <option value="06">June</option>
                                    <option value="07">July</option>
                                    <option value="08">August</option>
                                    <option value="09">September</option>
                                    <option value="10">October</option>
                                    <option value="11">November</option>
                                    <option value="12">December</option>
                                </select>
                            </div>
                            <input name="CHR_DEPCY2" class="form-control" required type="number" value="2015" maxlength="4" style="width:80px">
                        </div>

                        <div class="form-group">
                            <label class="col-sm-2 control-label">Price per Unit (Rp) <b class="mandatory">*</b></label>
                            <div class="col-sm-3">
                                <input name="a" autocomplete="off" onkeyup="formatangka(this);
                                        replaceChars(document.f.a.value);" class="form-control" required type="text" >
                            </div>

                            <label class="col-sm-2 control-label">Qty <b class="mandatory">*</b></label>
                            <div class="col-sm-2">
                                <input name="INT_QUANTITY" autocomplete="off" onkeyup="angka(this);" class="form-control" required type="text"  value="0">
                            </div>
                        </div>

                        <input name="DEC_PRICE_PER_UNIT" type="hidden">

                        <div class="form-group">
                            <div class="col-sm-offset-4 col-sm-5">
                                <div class="btn-group">
                                    <button type="submit" class="btn btn-primary"><i class="fa fa-check"></i> Save</button>
                                    <?php
                                    echo anchor('budget/capex_plan_temp_c', 'Cancel', 'class="btn btn-default"');
                                    echo form_close();
                                    ?>
                                </div>
                            </div>
                        </div>
                         <b class="mandatory">*</b> = mandatory
                    </div>
                </div>
            </div>
        </div>


    </section>
</aside>