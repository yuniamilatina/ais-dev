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

    // $(document).ready(function() {
    // $("#selectdept").focusout(function() {
    // $.ajax({
    // url: "<?php echo base_url(); ?>index.php/budget/capex_plan_temp_c/buildDropSection",
    // data: {id: $(this).val()}, type: "POST",
    // success: function(data) {
    // $("#section").html(data);
    // }
    // });
    // });
    // });

    $(document).ready(function() {
        $("#selectsec").change(function() {
            $.ajax({
                url: "<?php echo base_url(); ?>index.php/budget/capex_plan_temp_c/buildDropSection",
                data: {id: $(this).val()}, type: "POST",
                success: function(data) {
                    $("#section").html(data);
                }
            });
        });
    });

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

    function ChooseFiscal(data) {
        document.getElementById("jYear").value = data.value;
    }
    function ChooseSection(data) {
        document.getElementById("jSection").value = data.value;
    }
    function ChooseDept(data) {
        document.getElementById("jDept").value = data.value;
    }
    function ChooseMonth(data) {
        document.getElementById("jMonth").value = data.value;
    }
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
<?php $session = $this->session->all_userdata(); ?>
<aside class="right-side">
    <section class="content-header">
        <ol class="breadcrumb">
            <li><a href="<?php echo base_url('index.php/home_c/') ?>">Home</a></li>
            <li><a href="<?php echo base_url('index.php/budget/purchase_request_c/"') ?>">Manage Purchase Request</a></li>
            <li class="active"> <a href="#"><strong>Create Purchase Request</strong></a></li>
        </ol>
    </section>

    <section class="content">
        <?php
        if (validation_errors()) {
            echo '<div class = "alert alert-danger"><strong>WARNING !</strong>' . validation_errors() . '</div >';
        }
        ?>
        <div class="row">

            <div class="col-md-6">
                <div class="grid">
                    <div class="grid-header">
                        <i class="fa fa-th-large"></i>
                        <span class="grid-title"><strong>PLANNING</strong> BUDGET</span>
                        <div class="pull-right grid-tools">
                            <a data-widget="collapse" title="Collapse"><i class="fa fa-chevron-up"></i></a>
                        </div>
                    </div>
                    <div class="grid-body">
                        <div class="pull">
                            <?php echo form_open('budget/purchase_request_c/search_budget', 'class="form-horizontal"'); ?>

                            <?php if ($session['ROLE'] == 1 || $session['ROLE'] == 2) { ?>

                                <select autofocus name="INT_ID_DEPT" id="selectdept" class="ddl" onchange="ChooseDept(this);" style="width:200px">
                                    <option value="0">--Select Department--</option>
                                    <?php
                                    foreach ($data_dept as $isi) {
                                        if ($dept == $isi->INT_ID_DEPT) {
                                            ?>
                                            <option selected="true" value="<?php echo $isi->INT_ID_DEPT; ?>"><?php echo $isi->CHR_DEPT . ' - ' . $isi->CHR_DEPT_DESC; ?></option>
                                        <?php } else {
                                            ?>
                                            <option value="<?php echo $isi->INT_ID_DEPT; ?>"><?php echo $isi->CHR_DEPT . ' - ' . $isi->CHR_DEPT_DESC; ?></option>
                                            <?php
                                        }
                                    }
                                    ?> 
                                </select>

                                <select name="INT_ID_SECTION" id="section" class="ddl" onchange="ChooseSection(this);" style="width:200px">
                                    <option value="0">--Select Department First--</option>
                                </select>  
                                <br/>

                            <?php } ?>
                            <select name="INT_ID_BUDGET_TYPE" class="ddl" style="width:250px">
                                <option value="0">--Select Budget Type--</option>
                                <?php
                                foreach ($data_type as $isi) {
                                    if ($type == $isi->INT_ID_BUDGET_TYPE) {
                                        ?> 
                                        <option selected="true" value="<?php echo $isi->INT_ID_BUDGET_TYPE; ?>"><?php echo $isi->CHR_BUDGET_TYPE . ' - ' . $isi->CHR_BUDGET_TYPE_DESC; ?></option>
                                    <?php } else {
                                        ?>
                                        <option value="<?php echo $isi->INT_ID_BUDGET_TYPE; ?>"><?php echo $isi->CHR_BUDGET_TYPE . ' - ' . $isi->CHR_BUDGET_TYPE_DESC; ?></option>
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
                        <table id="dataTables3" class="table table-condensed table-striped table-bordered table-responsive display" cellspacing="0" width="100%">
                            <thead>
                                <tr>
                                    <th></th>
                                    <th>Budget</th>
                                    <th>Budget Decription</th>
                                    <th>Month Plan</th>
                                    <th>Total</th>
                                    <th>Act</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                $i = 1;
                                foreach ($data as $isi) {
                                    echo "<tr class='gradeX'>";
                                    echo "<td>$i</td>";
                                    echo "<td>$isi->INT_NO_BUDGET</td>";
                                    echo "<td>$isi->CHR_BUDGET_NAME</td>";
                                    echo "<td>$isi->INT_MONTH_PLAN</td>";
                                    $total = number_format($isi->DEC_TOTAL, 0, '', '.');
                                    echo "<td>$total</td>";
                                    ?>
                                <td>
                                    <a href="<?php echo base_url('index.php/budget/purchase_request_c/add_pureq_detail') . "/" . $isi->INT_NO_BUDGET . "/" . "0" . "/" . $type; ?>" class="label label-success"><span class="fa fa-plus"></span></a>
                                </td>
                                </tr>

                                <?php
                                $i++;
                            }
                            ?>
                            </tbody>
                        </table>

                    </div>
                </div>

            </div>


            <?php
            if ($subcontent != NULL) {
                $this->load->view($subcontent);
            }
            ?>

            <div class="col-md-6"></div>

            <?php
            if ($flag == false) {
                ?>
                <div class="col-md-6">
                    <div class="grid">
                        <div class="grid-header">
                            <i class="fa fa-th-large"></i>
                            <span class="grid-title"><strong>PURCHASE</strong> REQUEST</span>
                            <div class="pull-right grid-tools">
                                <a data-widget="collapse" title="Collapse"><i class="fa fa-chevron-up"></i></a>
                            </div>
                        </div>
                        <div class="grid-body">
                            <table id="dataTables1" class="table table-condensed table-striped table-bordered display" cellspacing="0" width="100%">
                                <thead>
                                    <tr>
                                        <th>Budget</th>
                                        <th>Price Per Unit</th>
                                        <th>Purchase Item</th>
                                        <th>Qty</th>
                                        <th>Total</th>
                                        <th>Act</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    foreach ($data_pr as $isi) {
                                        echo "<tr class='gradeX'>";
                                        $mount = number_format($isi->DEC_PRICE_PER_UNIT, 0, '', '.');
                                        $total_price = number_format($isi->TOTAL, 0, '', '.');
                                        echo "<td>$isi->INT_NO_BUDGET</td>";
                                        echo "<td>$mount</td>";
                                        echo "<td>$isi->CHR_PURCHASE_ITEM</td>";
                                        echo "<td>$isi->INT_QUANTITY</td>";
                                        echo "<td>$total_price</td>";
                                        ?>
                                    <td>
                                        <a href="<?php echo base_url('index.php/budget/purchase_request_detail_c/remove_budget') . '/' . $isi->INT_NO_BUDGET ?>" class="label label-danger"><span class="fa fa-times"></span></a>
                                    </td>
                                    </tr>

                                    <?php
                                }
                                ?>
                                </tbody>
                            </table>
                        </div>

                        <div class = "grid-header">
                            <div class = "grid-body">
                                <div class = "pull-right">
                                    <div class = "form-group">
                                        <div class = "btn-group">
                                            <?php
                                            echo form_open('budget/purchase_request_c/save_purchase_request', 'class="form-horizontal"');
                                            ?>
                                            <input name="INT_ID_FISCAL_YEAR" class="form-control" type="hidden" value="<?php echo $data_detail->INT_ID_FISCAL_YEAR; ?>">
                                            <input name="INT_ID_SECTION" class="form-control" type="hidden" value="<?php echo $data_detail->INT_ID_SECTION; ?>">
                                            <button type="submit" name="btn_commit" class="btn btn-primary" data-toggle="tooltip" data-placement="bottom" title = "Save Purchase Request" onclick = "return confirm('Are you sure want to Save this budget?');"><i class = "fa fa-check"></i> Save</button>
                                            <?php
                                            echo anchor('budget/purchase_request_c', 'Cancel', 'class="btn btn-default"');
                                            echo form_close();
                                            ?>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                    </div>
                </div>

            <?php }
            ?>

        </div>

    </section>
</aside>