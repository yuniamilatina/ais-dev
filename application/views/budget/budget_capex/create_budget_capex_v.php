<script type="text/javascript">
    $(document).ready(function () {
        var interval_close = setInterval(closeSideBar, 250);
        function closeSideBar() { 
            $("#hide-sub-menus").click();
            clearInterval(interval_close);
        }
        
        $("#selectdept").change(function () {
            $.ajax({
                url: "<?php echo base_url(); ?>index.php/budget/budget_capex_c/buildDropSection",
                data: {id: $(this).val()}, type: "POST",
                success: function (data) {
                    $("#section").html(data);
                }
            });
        });
        
        $("#selectdept").focusout(function () {
            $.ajax({
                url: "<?php echo base_url(); ?>index.php/budget/budget_capex_c/buildDropSection",
                data: {id: $(this).val()}, type: "POST",
                success: function (data) {
                    $("#section").html(data);
                }
            });
        });
        
        $("#section").change(function () {
            $.ajax({
                type: "POST",
                url: "<?php echo base_url(); ?>index.php/budget/budget_capex_c/buildDropCostCenter",
                data: {id: $(this).val()},                 
                success: function (data) {
                    $("#costcenter").html(data);
                }
            });
        });
        
        $("#section").focusout(function () {
            $.ajax({
                type: "POST",
                url: "<?php echo base_url(); ?>index.php/budget/budget_capex_c/buildDropCostCenter",
                data: {id: $(this).val()},                 
                success: function (data) {
                    $("#costcenter").html(data);
                }
            });
        });
    
        $("#curr_input").change(function () {
            $.ajax({
                type: "POST",
                url: "<?php echo base_url(); ?>index.php/budget/budget_capex_c/getRateCurr",
                data: {id: $(this).val()},
                success: function (data) {
                    $("#rate_curr").val(data);
                }
            });
        });
    
        $("#selectcategory").change(function () {
            var cat = $(this).val();
            $.ajax({
                url: "<?php echo base_url(); ?>index.php/budget/budget_capex_c/buildsubcategory",
                data: {id: $(this).val()}, type: "POST",
                success: function (data) {
                    $("#budgetsubcategory").html(data);
                    if(cat == 1){
                        document.getElementById('project').style.display = 'block';
                        document.getElementById('project2').style.display = 'block';
                        document.getElementById('product').style.display = 'block';
                        document.getElementById('product2').style.display = 'block';
                    } else {
                        document.getElementById('project').style.display = 'none';
                        document.getElementById('project2').style.display = 'none';
                        document.getElementById('product').style.display = 'none';
                        document.getElementById('product2').style.display = 'none';
                    }
                }
            });
            
            $.ajax({
                url: "<?php echo base_url(); ?>index.php/budget/budget_capex_c/buildpurpose",
                data: {id: $(this).val()}, type: "POST",
                success: function (data) {
                    $("#budgetpurpose").html(data);
                }
            });
        });
    });
    
    function replaceChars(entry) {
        out = "."; // replace this
        add = ""; // with this
        temp = "" + entry; // temporary holder

        while (temp.indexOf(out) > -1) {
            pos = temp.indexOf(out);
            temp = "" + (temp.substring(0, pos) + add +
                    temp.substring((pos + out.length), temp.length));
        }
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
        echo form_open('budget/budget_capex_c/save_temp_budget_capex', 'class="form-horizontal" name="f" id="form-id"');
        ?>

        <div class="row">
            <div class="col-md-12">
                <div class="grid">
                    <div class="grid-header">
                        <i class="fa fa-shopping-cart"></i>
                        <span class="grid-title"><strong>CREATE PLANNING BUDGET CAPEX</strong></span>
                        <div class="pull-right grid-tools">
                            <a data-widget="collapse" title="Collapse"><i class="fa fa-chevron-up"></i></a>
                        </div>
                    </div>
                    <div class="grid-body">
                        <!-- START OF WIZARD -->
                        <div id="rootwizard">
                            <!-- START OF NAVIGATION BAR -->
                            <div class="navbar" style="background-color: white;">
                                <ul class="nav nav-pills">
                                    <li class="active"><a href="#tab1" data-toggle="tab">1</a><span>Basic info</span></li>
                                    <li class=""><a href="#tab2" data-toggle="tab">2</a><span>Budget Category & Purpose</span></li>
                                    <li class=""><a href="#tab3" data-toggle="tab">3</a><span>Budget Description</span></li>
                                    <li class=""><a href="#tab4" data-toggle="tab">4</a><span>Detail Price & Quantity</span></li>
                                </ul>
                            </div>
                            <!-- END OF NAVIGATION BAR -->
                            <!-- START OF PROGRESS BAR -->
                            <div id="bar" class="progress progress-striped active">
                                <div class="bar progress-bar progress-bar-primary" style="width: 25%;"></div>
                            </div>
                            <!-- END OF PROGRESS BAR -->
                            <!-- START OF CONTENT -->
                            <div class="tab-content">
                                <!-- BEGIN BASIC INFO -->
                                <div class="tab-pane active" id="tab1">
                                    <div class="form-horizontal">

                                        <?php $session = $this->session->all_userdata(); ?>
                                        <?php //if ($session['ROLE'] === 1 || $session['ROLE'] === 2) { ?>

                                            <div class="form-group">
                                                <label class="col-sm-2 control-label">Fiscal Year</label>
                                                <div class="col-sm-3">
                                                    <select name="INT_ID_FISCAL_YEAR" id="fiscal" class="form-control" style="width:120px;">
                                                        <?php
                                                        foreach ($data_fiscal as $isi) {
                                                            if ($fiscal_year == $isi->INT_ID_FISCAL_YEAR) {
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

                                                <label class="col-sm-2 control-label">Section <b class="mandatory">*</b></label>
                                                <div class="col-sm-4">
                                                    <select name="INT_ID_SECTION" id="section" class="form-control" style="width:300px" required>
                                                        <option value="">-- Select Department First --</option>
                                                    </select>  
                                                </div>
                                            </div>

                                            <div class="form-group">
                                                <label class="col-sm-2 control-label">Department <b class="mandatory">*</b></label>
                                                <div class="col-sm-3">
                                                    <select autofocus name="INT_ID_DEPT" id="selectdept" class="form-control" style="width:250px" required>
                                                        <option value="">-- Select Department --</option>
                                                        <?php
                                                        foreach ($data_dept as $isi) {
                                                            ?>
                                                            <option value="<?php echo $isi->INT_ID_DEPT; ?>"
                                                            <?php
                                                                if($user_dept == $isi->INT_ID_DEPT){
                                                                    echo ' SELECTED';
                                                                }
                                                            ?>><?php echo $isi->CHR_DEPT . ' - ' . $isi->CHR_DEPT_DESC; ?></option>
                                                            <?php
                                                        }
                                                        ?> 
                                                    </select>
                                                </div>

                                                <label class="col-sm-2 control-label">Cost Center <b class="mandatory">*</b></label>
                                                <div class="col-sm-4">
                                                    <select name="INT_ID_COST_CENTER" id="costcenter" class="form-control" style="width:300px" required>
                                                        <option value="">-- Select Section First --</option>
                                                    </select>  
                                                </div>
                                            </div>

                                            <hr>
                                        <?php //} ?>
                            
                                    </div>
                                </div>
                                <!-- END BASIC INFO -->
                                <!-- BEGIN BUDGET CATEGORY & PURPOSE -->
                                <div class="tab-pane" id="tab2">
                                    <div class="form-horizontal">

                                        <div class="form-group">
                                            <label class="col-sm-2 control-label">Type</label>
                                            <div class="col-sm-3">
                                                <label class="radio-inline"><input type="radio" name="CHR_STATUS_BUDGET" class="icheck" value="New" checked>  New</label>
                                                <label class="radio-inline"><input type="radio" name="CHR_STATUS_BUDGET" class="icheck" value="Carry Over">  Carry Over</label>
                                            </div>
                                        </div>

                                        <div class="form-group">
                                            <label class="col-sm-2 control-label">Category <b class="mandatory">*</b></label>
                                            <div class="col-sm-3">
                                                <select name="CHR_BUDGET_CATEGORY" id="selectcategory" class="form-control" style="width:250px" required>
                                                    <option value="">-- Select Category --</option>
                                                    <?php
                                                    foreach ($data_budgetcategory as $isi) {
                                                        ?>
                                                        <option value="<?php echo $isi->INT_ID_BUDGET_CATEGORY; ?>"><?php echo $isi->CHR_BUDGET_CATEGORY . ' - ' . $isi->CHR_BUDGET_CATEGORY_DESC; ?></option>
                                                        <?php
                                                    }
                                                    ?> 
                                                </select>
                                            </div>

                                            <label class="col-sm-2 control-label">Sub Category <b class="mandatory">*</b></label>
                                            <div class="col-sm-5">
                                                <select name="CHR_BUDGET_SUB_CATEGORY" id="budgetsubcategory" class="form-control" style="width:300px" onchange="showOwner()" required>
                                                    <?php
                //                                    foreach ($data_budgetsubcategory as $isi) {
                                                        ?>
                                                        <!--<option value="<?php echo $isi->CHR_BUDGET_SUB_CATEGORY; ?>"><?php echo $isi->CHR_BUDGET_SUB_CATEGORY . ' - ' . $isi->CHR_BUDGET_SUB_CATEGORY_DESC; ?></option>-->
                                                        <?php
                //                                    }
                                                    ?> 
                                                    <option value="">-- Select Category First --</option>
                                                </select>
                                            </div> 
                                        </div>

                                        <div class="form-group" id="owner" style="display:none;">
                                            <label class="col-sm-2 control-label">Tooling Owner</label>
                                            <div class="col-sm-3">
                                                <label class="radio-inline"><input type="radio" class="icheck" name="CHR_OWNER" value="Aisin" checked> Aisin</label>
                                                <label class="radio-inline"><input type="radio" class="icheck" name="CHR_OWNER" value="Customer"> Customer</label>
                                            </div>

                <!--                            <label class="col-sm-2 control-label">Owner</label>
                                            <div class="col-sm-4">
                                                <label class="radio"><input onchange="document.getElementById('show-me').style.display = 'none';" type="radio" name="CHR_OWNER" value="Aisin" checked> Aisin</label>
                                                <label class="radio"><input onchange="document.getElementById('show-me').style.display = 'block';" type="radio" name="CHR_OWNER" value="Customer"> Customer</label>
                                            </div>
                                            <div id='show-me' style='display:none'>
                                                <label class="col-sm-2 control-label">Supplier</label>
                                                <div class="col-sm-3">
                                                    <label class="radio-inline"><input type="radio" name="CHR_SUPPLIER" class="icheck" value="Local" checked> Local</label>
                                                    <label class="radio-inline"><input type="radio" name="CHR_SUPPLIER" class="icheck" value="Import"> Import</label>
                                                </div>
                                            </div>-->
                                        </div>

                                        <hr>

                                        <div class="form-group">
                                            <label class="col-sm-2 control-label">Purpose Budget <b class="mandatory">*</b></label>
                                            <div class="col-sm-3">
                                                <select name="CHR_PURPOSE" class="form-control" onchange="showProject()" style="width:250px" id="budgetpurpose">
                                                    <!--<option value="">-- Select Purpose --</option>-->
                                                    <?php
                //                                    foreach ($data_purposebudget as $isi) {
                                                        ?>
                                                        <!--<option value="<?php echo $isi->CHR_PURPOSE; ?>"><?php echo $isi->CHR_PURPOSE . ' - ' . $isi->CHR_PURPOSE_DESC; ?></option>-->
                                                        <?php
                //                                    }
                                                    ?> 
                                                    <option value="">-- Select Category First --</option>
                                                </select>
                                            </div>

                                            <!-- Mltiple value of Project -->
                                            <label class="col-sm-2 control-label" id="project" style="display:none;">Project <b class="mandatory" id="b1" hidden>*</b></label>
                                            <div class="col-sm-3" id="project2" style="display:none;">
                                                <select name="CHR_PROJECT[]" multiple id="e1" class="form-control" style="width:300px">
                                                    <?php
                                                    foreach ($data_project as $isi) {
                                                        ?>
                                                        <!-- <option value="<?php echo $isi->CHR_PROJECT; ?>"><?php echo $isi->CHR_PROJECT . ' - ' . $isi->CHR_PROJECT_DESC; ?></option> -->
                                                        <?php
                                                    }
                                                    ?> 
                                                </select>
                                            </div>

                                            <!-- Select single project -->
                <!--                            <label class="col-sm-2 control-label">Project</label>
                                            <div class="col-sm-3">
                                                <select name="CHR_PROJECT" id="e1" class="form-control" style="width:250px">
                                                    <?php
                                                    foreach ($data_project as $isi) {
                                                        ?>
                                                        <option value="<?php echo $isi->CHR_PROJECT; ?>"><?php echo $isi->CHR_PROJECT . ' - ' . $isi->CHR_PROJECT_DESC; ?></option>
                                                        <?php
                                                    }
                                                    ?> 
                                                </select>
                                            </div>-->
                                        </div>

                                        <div class="form-group">
                                            <!-- Mltiple value of Product -->
                                            <label class="col-sm-2 control-label" id="product" style="display:none;">Product <b class="mandatory" id="b2" hidden>*</b></label>
                                            <div class="col-sm-3" id="product2" style="display:none;">
                                                <select name="CHR_PRODUCT[]" multiple id="e2" class="form-control" style="width:250px">
                                                    <?php
                                                    foreach ($data_product as $isi) {
                                                        ?>
                                                        <option value="<?php echo $isi->CHR_PRODUCT; ?>"><?php echo $isi->CHR_PRODUCT . ' - ' . $isi->CHR_PRODUCT_DESC; ?></option>
                                                        <?php
                                                    }
                                                    ?> 
                                                </select>
                                            </div>

                                            <!-- Single select product -->
                <!--                            <label class="col-sm-2 control-label">Product</label>
                                            <div class="col-sm-5">
                                                <select name="CHR_PRODUCT" id="e2" class="form-control" style="width:300px">
                                                    <?php
                                                    foreach ($data_product as $isi) {
                                                        ?>
                                                        <option value="<?php echo $isi->CHR_PRODUCT; ?>"><?php echo $isi->CHR_PRODUCT . ' - ' . $isi->CHR_PRODUCT_DESC; ?></option>
                                                        <?php
                                                    }
                                                    ?> 
                                                </select>
                                            </div>-->
                                        </div>

                                        <div class="form-group">
                                            <label class="col-sm-2 control-label">CIP Type <b class="mandatory">*</b></label>
                                            <div class="col-sm-3">
                                                <label class="radio-inline"><input type="radio" name="INT_FLG_CIP" class="icheck" value=0 checked> Non-CIP</label>
                                                <label class="radio-inline"><input type="radio" name="INT_FLG_CIP" class="icheck" value=1> CIP</label>
                                            </div>
                                        </div>

                                        <hr>
                        
                                    </div>
                                </div>
                                <!-- END BUDGET CATEGORY & PURPOSE -->
                                <!-- BEGIN BUDGET DESCRIPTION -->
                                <div class="tab-pane" id="tab3">
                                    <div class="form-horizontal">

                                        <div class="form-group">
                                            <label class="col-sm-2 control-label">Budget Description <b class="mandatory">*</b></label>
                                            <div class="col-sm-5">
                                                <input name="CHR_BUDGET_DESC" class="form-control" maxlength="100" required type="text" style=" width:795px;">
                                            </div>
                                        </div>

                                        <div class="form-group">    
                                            <label class="col-sm-2 control-label">Supplier</label>
                                            <div class="col-sm-5">
                                                <label class="radio-inline"><input type="radio" name="CHR_SUPPLIER" class="icheck" value="Local" checked> Local</label>
                                                <label class="radio-inline"><input type="radio" name="CHR_SUPPLIER" class="icheck" value="Import"> Import</label>
                                            </div>
                                        </div>

                                        <hr>
                        
                                    </div>
                                </div>
                                <!-- END BUDGET DESCRIPTION -->
                                <!-- BEGIN DETAIL PRICE & QUANTITY -->
                                <div class="tab-pane" id="tab4">
                                    <div class="form-horizontal">

                                        <div class="form-group">
                                            <label class="col-sm-2 control-label">UoM </label>
                                            <div class="col-sm-3">  
                                                <select name="CHR_UNIT" id="uom_input" class="form-control" style="width:160px">*
                                                    <?php
                                                    foreach ($unit as $isi) {
                                                        ?>
                                                        <option value="<?php echo $isi->CHR_SATUAN; ?>"><?php echo $isi->CHR_SATUAN . ' - ' . $isi->CHR_SATUAN_DESC; ?></option>
                                                        <?php
                                                    }
                                                    ?> 
                                                </select>
                                            </div>

                                            <label class="col-sm-2 control-label">Run Depreciation <b class="mandatory">*</b></label>
                                            <div class="col-sm-2">
                                                <select name="CHR_DEPC_MONTH" class="form-control" id="month_run" style="width:160px" required onchange="cek_RunDep();">
                                                    <option value=""></option>
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
                                            <!--<input name="CHR_DEPC_YEAR" class="form-control" required type="number" value="2018" maxlength="4" style="width:80px">-->
                                            <select name="CHR_DEPC_YEAR" class="form-control" id="year_run" style="width:80px" required onchange="cek_RunDep();">
                                                    <option value=""></option>
                                                <?php for ($x = 0; $x <= 15; $x++) { ?>
                                                    <option value="<?php echo date("Y", strtotime("+$x year")); ?>" <?php
                                                    // if (date("Y") == date("Y", strtotime("+$x year"))) {
                                                    //     echo 'SELECTED';
                                                    // }
                                                    ?> > <?php echo date("Y", strtotime("+$x year")); ?> </option>
                                                        <?php } ?>
                                            </select>
                                        </div>

                                        <div class="form-group">
                                            <div class="col-sm-6">
                                                <strong><i id="alert_run_dep" style="color:red; display:block;"><span class="fa fa-exclamation-triangle"></span> Planning Run Depreciation minimal sesuai planning GR, tidak boleh lebih cepat</i></strong>
                                            </div>                                
                                        </div>

                                        <div class="form-group">
                                            <label class="col-sm-2 control-label">Currency</label>
                                            <div class="col-sm-2">
                                                <select name="CHR_CURRENCY" class="form-control" style="width:160px" id="curr_input" onchange="cekValue();">                                    
                                                    <?php foreach ($all_curr as $curr){ ?>
                                                    <option value="<?php echo $curr->INT_ID_CURRENCY; ?>"><?php echo $curr->CHR_CURRENCY . ' - ' . $curr->CHR_CURRENCY_DESC; ?></option>
                                                    <?php } ?>
                                                </select>                                
                                            </div>
                                            <input type="text" name="RATE_CURRENCY" class="form-control" id="rate_curr" value="1" style="width:80px" readonly>
                                        </div>

                <!--                        <div class="form-group">
                                            <label class="col-sm-2 control-label">Month Plan</label>
                                            <div class="col-sm-3">
                                                <select name="MONTH_PLAN" class="form-control" style="width:150px">                                    
                                                    <option value="<?php echo $year_start.'04' ?>">April <?php echo $year_start; ?></option>
                                                    <option value="<?php echo $year_start.'05' ?>">May <?php echo $year_start; ?></option>
                                                    <option value="<?php echo $year_start.'06' ?>">June <?php echo $year_start; ?></option>
                                                    <option value="<?php echo $year_start.'07' ?>">July <?php echo $year_start; ?></option>
                                                    <option value="<?php echo $year_start.'08' ?>">August <?php echo $year_start; ?></option>
                                                    <option value="<?php echo $year_start.'09' ?>">September <?php echo $year_start; ?></option>
                                                    <option value="<?php echo $year_start.'10' ?>">October <?php echo $year_start; ?></option>
                                                    <option value="<?php echo $year_start.'11' ?>">November <?php echo $year_start; ?></option>
                                                    <option value="<?php echo $year_start.'12' ?>">December <?php echo $year_start; ?></option>
                                                    <option value="<?php echo $year_end.'01' ?>">January <?php echo $year_end; ?></option>
                                                    <option value="<?php echo $year_end.'02' ?>">February <?php echo $year_end; ?></option>
                                                    <option value="<?php echo $year_end.'03' ?>">March <?php echo $year_end; ?></option>
                                                </select>
                                            </div>   
                                        </div>-->

                                        <div class="form-group">
                                            <label class="col-sm-2 control-label">Price per Unit (Ori) <b class="mandatory">*</b></label>
                                            <div class="col-sm-3">
                                                <input name="MON_PRICE" autocomplete="off" onkeyup="formatangka(this);replaceChars(document.f.a.value);" onchange="cekValue();" class="form-control" id="money" required type="text" value="0">
                                            </div>

                <!--                            <label class="col-sm-2 control-label">Qty <b class="mandatory">*</b></label>
                                            <div class="col-sm-2">
                                                <input name="INT_QTY" autocomplete="off" onkeyup="angka(this);" class="form-control" id="qty" required type="text" value="0">
                                            </div>-->
                                        </div>

                                        <div class="form-group">
                                            <label class="col-sm-2 control-label">Inklaring (+)</label>
                                            <div class="col-sm-3">
                                                <input name="MON_INKLARING" autocomplete="off" onkeyup="formatangka(this);replaceChars(document.f.a.value);" onchange="cekValue();"  class="form-control" id="inklaring" type="text" value="0">
                                            </div>
                                        </div>

                                        <div class="form-group">
                                            <label class="col-sm-2 control-label">Engineer Fee (+)</label>
                                            <div class="col-sm-3">
                                                <input name="MON_ENGFEE" autocomplete="off" onkeyup="formatangka(this);replaceChars(document.f.a.value);" onchange="cekValue();"  class="form-control" id="engfee" type="text" value="0">
                                            </div>
                                        </div>

                                        <div class="form-group">
                                            <label class="col-sm-2 control-label">Import Duty (+)</label>
                                            <div class="col-sm-3">
                                                <input name="MON_IMPORT_DUTY" autocomplete="off" onkeyup="formatangka(this);replaceChars(document.f.a.value);" onchange="cekValue();"  class="form-control" id="importduty" type="text" value="0">
                                            </div>
                                        </div>

                                        <div class="form-group">    
                                            <label class="col-sm-2 control-label"><strong>Price per Unit (IDR)</strong> </label>
                                            <div class="col-sm-3">
                                                <input name="MON_TOTAL" autocomplete="off" onkeyup="formatangka(this);replaceChars(document.f.a.value);" class="form-control" id="tot_money" required type="text" value="0" readonly style="font-weight:bold;">
                                            </div>
                                        </div>

                                        <input name="PRICE_PER_UNIT_ORI" id="PRICE_ORI" type="hidden" value="0">
                                        <input name="PRICE_PER_UNIT_IDR" id="PRICE_IDR" type="hidden" value="0">
                                        <input name="PRICE_INKLARING" id="PRICE_INK" type="hidden" value="0">
                                        <input name="PRICE_ENGFEE" id="PRICE_ENG" type="hidden" value="0">
                                        <input name="PRICE_IMPORT_DUTY" id="PRICE_IMP" type="hidden" value="0">
                                        <input name="TOT_PRICE_IDR" id="TOT_PRICE_IDR" type="hidden" value="0">

                                        <div class="form-group">
                                            <div class="col-sm-6">
                                                <strong><i id="alert_amo" style="color:red; display:block;"><span class="fa fa-exclamation-triangle"></span> Price per unit (IDR) untuk Capex tidak boleh KURANG dari Rp 3.000.000,00 </i></strong>
                                            </div>                                
                                        </div>

                                        <hr>

                                        <div class="form-group">
                                            <label class="col-sm-1 control-label">Qty <strong>APR</strong></label>
                                            <div class="col-sm-1">
                                                <input name="INT_QTY_4" autocomplete="off" onkeyup="angka(this);" onchange="cekValue();cek_RunDep();" class="form-control" id="qty_4" required type="text" value="0">
                                            </div>

                                            <label class="col-sm-1 control-label">Qty <strong>MAY</strong></label>
                                            <div class="col-sm-1">
                                                <input name="INT_QTY_5" autocomplete="off" onkeyup="angka(this);" onchange="cekValue();cek_RunDep();" class="form-control" id="qty_5" required type="text" value="0">
                                            </div> 

                                            <label class="col-sm-1 control-label">Qty <strong>JUN</strong></label>
                                            <div class="col-sm-1">
                                                <input name="INT_QTY_6" autocomplete="off" onkeyup="angka(this);" onchange="cekValue();cek_RunDep();" class="form-control" id="qty_6" required type="text" value="0">
                                            </div>

                                            <label class="col-sm-1 control-label">Qty <strong>JUL</strong></label>
                                            <div class="col-sm-1">
                                                <input name="INT_QTY_7" autocomplete="off" onkeyup="angka(this);" onchange="cekValue();cek_RunDep();" class="form-control" id="qty_7" required type="text" value="0">
                                            </div>

                                            <label class="col-sm-1 control-label">Qty <strong>AUG</strong></label>
                                            <div class="col-sm-1">
                                                <input name="INT_QTY_8" autocomplete="off" onkeyup="angka(this);" onchange="cekValue();cek_RunDep();" class="form-control" id="qty_8" required type="text" value="0">
                                            </div>

                                            <label class="col-sm-1 control-label">Qty <strong>SEP</strong></label>
                                            <div class="col-sm-1">
                                                <input name="INT_QTY_9" autocomplete="off" onkeyup="angka(this);" onchange="cekValue();cek_RunDep();" class="form-control" id="qty_9" required type="text" value="0">
                                            </div>
                                        </div>

                                        <div class="form-group">
                                            <label class="col-sm-1 control-label">Qty <strong>OCT</strong></label>
                                            <div class="col-sm-1">
                                                <input name="INT_QTY_10" autocomplete="off" onkeyup="angka(this);" onchange="cekValue();cek_RunDep();" class="form-control" id="qty_10" required type="text" value="0">
                                            </div>

                                            <label class="col-sm-1 control-label">Qty <strong>NOV</strong></label>
                                            <div class="col-sm-1">
                                                <input name="INT_QTY_11" autocomplete="off" onkeyup="angka(this);" onchange="cekValue();cek_RunDep();" class="form-control" id="qty_11" required type="text" value="0">
                                            </div> 

                                            <label class="col-sm-1 control-label">Qty <strong>DEC</strong></label>
                                            <div class="col-sm-1">
                                                <input name="INT_QTY_12" autocomplete="off" onkeyup="angka(this);" onchange="cekValue();cek_RunDep();" class="form-control" id="qty_12" required type="text" value="0">
                                            </div>

                                            <label class="col-sm-1 control-label">Qty <strong>JAN</strong></label>
                                            <div class="col-sm-1">
                                                <input name="INT_QTY_13" autocomplete="off" onkeyup="angka(this);" onchange="cekValue();cek_RunDep();" class="form-control" id="qty_13" required type="text" value="0">
                                            </div>

                                            <label class="col-sm-1 control-label">Qty <strong>FEB</strong></label>
                                            <div class="col-sm-1">
                                                <input name="INT_QTY_14" autocomplete="off" onkeyup="angka(this);" onchange="cekValue();cek_RunDep();" class="form-control" id="qty_14" required type="text" value="0">
                                            </div> 

                                            <label class="col-sm-1 control-label">Qty <strong>MAR</strong></label>
                                            <div class="col-sm-1">
                                                <input name="INT_QTY_15" autocomplete="off" onkeyup="angka(this);" onchange="cekValue();cek_RunDep();" class="form-control" id="qty_15" required type="text" value="0">
                                            </div>
                                        </div>

                                        <div class="form-group">
                                            <label class="col-sm-2 control-label"><strong>Total Qty</strong> </label>
                                            <div class="col-sm-3">
                                                <input name="TOT_QTY_ALL" autocomplete="off" onkeyup="formatangka(this);" class="form-control" id="tot_qty_all" required type="text" value="0" readonly style="font-weight:bold; width:100px;">
                                            </div>
                                        </div>

                                        <div class="form-group">
                                            <div class="col-sm-5">
                                                <strong><i id="alert_qty" style="color:red; display:block;"><span class="fa fa-exclamation-triangle"></span> Total quantity tidak boleh 0 </i></strong>
                                            </div>                                
                                        </div>

                                        <hr>

                                        <div class="form-group">
                                            <label class="col-sm-2 control-label"><strong>Total Amount (IDR)</strong> </label>
                                            <div class="col-sm-3">
                                                <input name="MON_TOTAL_ALL" autocomplete="off" onkeyup="formatangka(this);replaceChars(document.f.a.value);" class="form-control" id="tot_amount" required type="text" value="0" readonly style="font-weight:bold;">
                                            </div>
                                        </div>

                                        <div class="form-group">
                                            <div class="col-sm-offset-4 col-sm-5">
                                                <div class="btn-group">
                                                    <button type="submit" id="save" class="btn btn-primary" disabled><i class="fa fa-check"></i> Save</button>
                                                    <?php
                                                    echo anchor('budget/budget_capex_c', 'Cancel', 'class="btn btn-default"');
                                                    echo form_close();
                                                    ?>
                                                </div>
                                            </div>
                                        </div>
                                        <b class="mandatory">*</b> = mandatory
                        
                                    </div>
                                </div>
                                <!-- END PRICE & QUANTITY -->
										
                                <!-- BEGIN WIZARD NAVIGATION -->
                                <ul class="pager wizard">
                                    <li class="previous first disabled" style="display:none;"><a href="#">First</a></li>
                                    <li class="previous disabled"><a href="#">Previous</a></li>
                                    <li class="next last" style="display:none;"><a href="#">Last</a></li>
                                    <li class="next"><a href="#">Next</a></li>
                                </ul>
                                <!-- END WIZARD NAVIGATION -->                            
                            </div>
                            <!-- END CONTENT -->
                        </div>
                        <!-- END OF WIZARD -->
                    </div>
                </div>
            </div>
        </div>
    </section>
</aside>
<script>
//    $(document).on("change", "#money", function() {
//        var price = $(this).val().replace(/[.]/g,"");
//        var qty = document.getElementById('qty').value;
//        var curr = document.getElementById('rate_curr').value;
//        var inklaring = document.getElementById('inklaring').value.replace(/[.]/g,"");
//        var engfee = document.getElementById('engfee').value.replace(/[.]/g,"");
//        var impduty = document.getElementById('importduty').value.replace(/[.]/g,"");
//        var amount = (price*curr*qty) + parseInt(inklaring) + parseInt(engfee) + parseInt(impduty);
//        document.getElementById('tot_money').value = amount.toString().replace(/(\d)(?=(\d{3})+(?!\d))/g, "$1.");
//        
//        if(price < 3000000){
//            document.getElementById('alert_amo').style.display = 'block';
//            document.getElementById('save').disabled = true;
//        } else {
//            if(qty <= 0){
//                document.getElementById('alert_amo').style.display = 'none'; 
//                document.getElementById('alert_qty').style.display = 'block';
//                document.getElementById('save').disabled = true;
//            } else {
//                document.getElementById('alert_amo').style.display = 'none'; 
//                document.getElementById('alert_qty').style.display = 'none';
//                document.getElementById('save').disabled = false;
//            }            
//        }
//    });
//    
//    $(document).on("change", "#qty", function() {
//        var price = document.getElementById('money').value.replace(/[.]/g,"");
//        var qty = $(this).val();
//        var curr = document.getElementById('rate_curr').value;
//        var inklaring = document.getElementById('inklaring').value.replace(/[.]/g,"");
//        var engfee = document.getElementById('engfee').value.replace(/[.]/g,"");
//        var impduty = document.getElementById('importduty').value.replace(/[.]/g,"");
//        var amount = (price*curr*qty) + parseInt(inklaring) + parseInt(engfee) + parseInt(impduty);
//        document.getElementById('tot_money').value = amount.toString().replace(/(\d)(?=(\d{3})+(?!\d))/g, "$1.");
//        
//        if(qty <= 0){
//            document.getElementById('alert_qty').style.display = 'block';
//            document.getElementById('save').disabled = true;
//        } else {
//            if(price < 3000000){
//                document.getElementById('alert_amo').style.display = 'block';
//                document.getElementById('alert_qty').style.display = 'none'; 
//                document.getElementById('save').disabled = true;
//            } else {
//                document.getElementById('alert_amo').style.display = 'none';
//                document.getElementById('alert_qty').style.display = 'none';  
//                document.getElementById('save').disabled = false;
//            }            
//        }
//    });
//    
//    $(document).on("change", "#inklaring", function() {
//        var inklaring = $(this).val().replace(/[.]/g,"");
//        var qty = document.getElementById('qty').value;
//        var curr = document.getElementById('rate_curr').value;
//        var price = document.getElementById('money').value.replace(/[.]/g,"");
//        var engfee = document.getElementById('engfee').value.replace(/[.]/g,"");
//        var impduty = document.getElementById('importduty').value.replace(/[.]/g,"");
//        var amount = (price*curr*qty) + parseInt(inklaring) + parseInt(engfee) + parseInt(impduty);
//        document.getElementById('tot_money').value = amount.toString().replace(/(\d)(?=(\d{3})+(?!\d))/g, "$1.");
//    });
//    
//    $(document).on("change", "#engfee", function() {
//        var engfee = $(this).val().replace(/[.]/g,"");
//        var qty = document.getElementById('qty').value;
//        var curr = document.getElementById('rate_curr').value;
//        var inklaring = document.getElementById('inklaring').value.replace(/[.]/g,"");
//        var price = document.getElementById('money').value.replace(/[.]/g,"");
//        var impduty = document.getElementById('importduty').value.replace(/[.]/g,"");
//        var amount = (price*curr*qty) + parseInt(inklaring) + parseInt(engfee) + parseInt(impduty);
//        document.getElementById('tot_money').value = amount.toString().replace(/(\d)(?=(\d{3})+(?!\d))/g, "$1.");
//    });
//    
//    $(document).on("change", "#importduty", function() {
//        var impduty = $(this).val().replace(/[.]/g,"");
//        var qty = document.getElementById('qty').value;
//        var curr = document.getElementById('rate_curr').value;
//        var inklaring = document.getElementById('inklaring').value.replace(/[.]/g,"");
//        var engfee = document.getElementById('engfee').value.replace(/[.]/g,"");
//        var price = document.getElementById('money').value.replace(/[.]/g,"");
//        var amount = (price*curr*qty) + parseInt(inklaring) + parseInt(engfee) + parseInt(impduty);
//        document.getElementById('tot_money').value = amount.toString().replace(/(\d)(?=(\d{3})+(?!\d))/g, "$1.");
//    });

    function showOwner(){
        var subcat = document.getElementById('budgetsubcategory').value;
        if(subcat == '308' || subcat == '3'){
            document.getElementById('owner').style.display = 'block';
        } else {
            document.getElementById('owner').style.display = 'none';
        }
    }
    
    function showProject(){
        var purpose = document.getElementById('budgetpurpose').value;
        $.ajax({
                async: false,
                        type: "POST",
                        dataType: 'json',
                        url: "<?php echo site_url('budget/budget_capex_c/get_project_by_purpose'); ?>",
                        data: "chr_purpose=" + purpose,
                        success: function (data) {
                            // $("#project2").html(data.data);
                            $("#e1").html(data.data);
                            if(purpose === "PCA02"){
                                $("#e1").prop('required',true);
                                $("#b1").prop('hidden',false);
                                $("#b2").prop('hidden',false);
                                $("#e2").prop('required',true);
                            } else {
                                $("#e1").prop('required',false);
                                $("#b1").prop('hidden',true);
                                $("#b2").prop('hidden',true);
                                $("#e2").prop('required',false);
                            }
                        },
                        error: function(request) {
                            alert(request.responseText);
                        }
                });
    }

    function cekValue(){
        var price = document.getElementById('money').value.replace(/[.]/g,"");        
        var orgcurr = document.getElementById('curr_input').value;
        var curr = function(){
            var tmp = null;
            $.ajax({
                'async': false,
                'type': "POST",
                'global': false,
                'dataType': 'html',
                'url': "<?php echo base_url(); ?>index.php/budget/budget_capex_c/getRateCurr",
                'data': {id: orgcurr},
                'success': function (data) {
                    tmp = data;
                }
            });
            return tmp;
        }();
        
        var inklaring = document.getElementById('inklaring').value.replace(/[.]/g,"");
        var engfee = document.getElementById('engfee').value.replace(/[.]/g,"");
        var impduty = document.getElementById('importduty').value.replace(/[.]/g,"");
        var price_idr = price*curr;
        var tot_price = price_idr + parseInt(inklaring) + parseInt(engfee) + parseInt(impduty);  
        
        document.getElementById('PRICE_ORI').value = price;
        document.getElementById('PRICE_IDR').value = price_idr;
        document.getElementById('PRICE_INK').value = inklaring;
        document.getElementById('PRICE_ENG').value = engfee;
        document.getElementById('PRICE_IMP').value = impduty;
        document.getElementById('TOT_PRICE_IDR').value = tot_price;
        
        var qty_4 = document.getElementById('qty_4').value;
        var qty_5 = document.getElementById('qty_5').value;
        var qty_6 = document.getElementById('qty_6').value;
        var qty_7 = document.getElementById('qty_7').value;
        var qty_8 = document.getElementById('qty_8').value;
        var qty_9 = document.getElementById('qty_9').value;
        var qty_10 = document.getElementById('qty_10').value;
        var qty_11 = document.getElementById('qty_11').value;
        var qty_12 = document.getElementById('qty_12').value;
        var qty_13 = document.getElementById('qty_13').value;
        var qty_14 = document.getElementById('qty_14').value;
        var qty_15 = document.getElementById('qty_15').value;
        var tot_qty = parseInt(qty_4) + parseInt(qty_5) + parseInt(qty_6) + parseInt(qty_7) + parseInt(qty_8) + parseInt(qty_9) + parseInt(qty_10) + parseInt(qty_11) + parseInt(qty_12) + parseInt(qty_13) + parseInt(qty_14) + parseInt(qty_15);
        
        var tot_amount = tot_price * parseInt(tot_qty);
        
        if(tot_qty <= 0){
            document.getElementById('alert_qty').style.display = 'block';
            if(tot_price < 3000000){
                document.getElementById('alert_amo').style.display = 'block'; 
                document.getElementById('save').disabled = true;
            } else {
                document.getElementById('alert_amo').style.display = 'none';  
                document.getElementById('save').disabled = false;
            }
        } else {
            document.getElementById('alert_qty').style.display = 'none';
            if(tot_price < 3000000){
                document.getElementById('alert_amo').style.display = 'block';
                document.getElementById('save').disabled = true;
            } else {
                document.getElementById('alert_amo').style.display = 'none'; 
                document.getElementById('save').disabled = false;
            }            
        }
        
        document.getElementById('tot_qty_all').value = tot_qty;
        document.getElementById('tot_money').value = tot_price.toString().replace(/(\d)(?=(\d{3})+(?!\d))/g, "$1.");
        document.getElementById('tot_amount').value = tot_amount.toString().replace(/(\d)(?=(\d{3})+(?!\d))/g, "$1.");
    };

    function cek_RunDep(){
        var month = document.getElementById('month_run').value;
        var year = document.getElementById('year_run').value;
        var run_dep = year.concat(month);
        var fy_start = document.getElementById('fiscal').value;
        var fy_end = parseInt(fy_start) + 1;
        var gr = fy_start.concat("04");
        var stat = 'NG';

        if(run_dep == ""){
            run_dep = 0;
        }
        
        if(document.getElementById('qty_15').value > 0){
            gr = fy_end.concat("03");
            stat = 'OK';
        }
        if(document.getElementById('qty_14').value > 0){
            gr = fy_end.concat("02");
            stat = 'OK';
        }
        if(document.getElementById('qty_13').value > 0){
            gr = fy_end.concat("01");
            stat = 'OK';
        }
        if(document.getElementById('qty_12').value > 0){
            gr = fy_start.concat("12");
            stat = 'OK';
        }
        if(document.getElementById('qty_11').value > 0){
            gr = fy_start.concat("11");
            stat = 'OK';
        }
        if(document.getElementById('qty_10').value > 0){
            gr = fy_start.concat("10");
            stat = 'OK';
        }
        if(document.getElementById('qty_9').value > 0){
            gr = fy_start.concat("09");
            stat = 'OK';
        }
        if(document.getElementById('qty_8').value > 0){
            gr = fy_start.concat("08");
            stat = 'OK';
        }
        if(document.getElementById('qty_7').value > 0){
            gr = fy_start.concat("07");
            stat = 'OK';
        }
        if(document.getElementById('qty_6').value > 0){
            gr = fy_start.concat("06");
            stat = 'OK';
        }
        if(document.getElementById('qty_5').value > 0){
            gr = fy_start.concat("05");
            stat = 'OK';
        }
        if(document.getElementById('qty_4').value > 0){
            gr = fy_start.concat("04");
            stat = 'OK';
        }

        if(parseInt(run_dep) < parseInt(gr)){
            document.getElementById('alert_run_dep').style.display = 'block'; 
            document.getElementById('save').disabled = true;
        } else {
            document.getElementById('alert_run_dep').style.display = 'none';
            if(stat == 'OK'){
                document.getElementById('save').disabled = false;
            } else {
                document.getElementById('save').disabled = true;
            } 
        }        
    }
</script>
<!-- <script src="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap-wizard/1.2/jquery.bootstrap.wizard.js"></script> -->
<script src="<?php echo base_url('assets/js/jquery.bootstrap.wizard.js') ?>"></script>
<script type="text/javascript">
    /* FORM WIZARD */
    $('#rootwizard').bootstrapWizard({
            onTabShow: function(tab, navigation, index){
                    var $total = navigation.find('li').length;
                    var $current = index+1;
                    var $percent = ($current/$total) * 100;
                    $('#rootwizard').find('.bar').css({
                            width:$percent+'%'
                    });
            }
    });
</script>
