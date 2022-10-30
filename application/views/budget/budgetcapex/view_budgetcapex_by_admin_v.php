
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
        document.g.DEC_PRICE_PER_UNIT.value = temp;
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
            <li><a href="<?php echo base_url('index.php/basis/home_c/') ?>">Home</a></li>
            <li><a href="<?php echo base_url('index.php/budget/capex_plan_temp_c/') ?>">Manage Budget Capex</a></li>            
            <li> <a href="#"><strong>View Detail Budget Capex</strong></a></li>
        </ol>
    </section>

    <section class="content">
        <?php
        if ($msg != NULL) {
            echo $msg;
        }
        ?>
        <div class="row">
            <div class="col-md-4">
                <div class="grid">
                    <div class="grid-header">
                        <i class="fa fa-file-text"></i>
                        <span class="grid-title"><strong><?php echo $data->INT_NO_BUDGET_CPX_TEMP; ?></strong></span>
                    </div>
                    <div class="grid-body">
                        <table class="table table-condensed table-bordered table-striped" cellspacing="0" width="100%">
                            <tr><td><strong>Fiscal Year</strong></td><td><?php echo $data->CHR_FISCAL_YEAR; ?></td></tr>
                            <tr><td><strong>Budget Name</strong></td><td><?php echo $data->CHR_BUDGET_NAME; ?></td></tr>
                            <tr><td><strong>Category</strong></td><td><?php echo $data->CHR_BUDGET_CATEGORY_DESC; ?></td></tr>
                            <tr><td><strong>Sub Category</strong></td><td><?php echo $data->CHR_BUDGET_SUB_CATEGORY_DESC; ?></td></tr>
                            <tr><td><strong>Purpose</strong></td><td><?php echo $data->CHR_PURPOSE_DESC; ?></td></tr>
                            <tr><td><strong>Department</strong></td><td><?php echo $data->CHR_DEPT_DESC; ?></td></tr>
                            <tr><td><strong>Section</strong></td><td><?php echo $data->CHR_SECTION_DESC; ?></td></tr>
                            <tr><td><strong>Owner</strong></td><td><?php echo $data->BIT_FLG_OWNER; ?></td></tr>
                            <tr><td><strong>New/Carry over</strong></td><td><?php echo $data->BIT_FLG_NEW; ?></td></tr>
                            <tr><td><strong>Type</strong></td><td><?php echo $data->BIT_FLG_CIP; ?></td></tr>
                            <tr><td><strong>Supplier</strong></td><td><?php echo $data->BIT_FLG_LOCAL; ?></td></tr>
                        </table>
                    </div>
                    <div class="grid-body">
                        <?php
                        echo anchor('budget/capex_plan_temp_c/', 'Back', 'class="btn btn-default" data-toggle="tooltip" data-placement="right" title="Back to manage"');
                        ?>
                    </div>
                </div>
            </div>

            <div class="col-md-4">
                <div class="grid">
                    <div class="grid-header">
                        <span class="grid-title">PROJECT(S)</span>
                        <?php if ($session['ROLE'] == 1 || $session['ROLE'] == 2 || $session['ROLE'] == 6) { ?>
                            <div class="pull-right  grid-tools">
                                <a data-toggle="modal" data-target="#modalProject" title="Add Project"><i class="fa fa-plus"></i></a>
                            </div>
                        <?php } ?>
                    </div>
                    <div class="grid-body">
                        <table class="table table-condensed table-striped display" cellspacing="0" width="100%">
                            <thead>
                                <tr>
                                    <th>No</th>
                                    <th>Project</th>
                                    <th>Project Desc</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                $i = 1;
                                foreach ($data_project as $isi) {
                                    echo "<tr class='gradeX'>";
                                    echo "<td>$i</td>";
                                    echo "<td>$isi->CHR_PROJECT</td>";
                                    echo "<td>$isi->CHR_PROJECT_DESC</td>";
                                    ?>
                                <td>
                                    <a href="<?php echo base_url('index.php/budget/budgetproject_c/delete_budgetproject') . "/" . $isi->INT_ID_PROJECT . "/" . $data->INT_NO_BUDGET_CPX_TEMP ?>" class="label label-danger" data-toggle="tooltip" data-placement="right" title="Remove" onclick="return confirm('Are you sure want to delete this project?');"><span class="fa fa-times"></span></a>
                                </td>
                                </tr>
                                <?php
                                $i++;
                            }
                            ?>
                            </tbody>
                        </table>

                        <div class="modal fade md-effect-18" id="modalProject" tabindex="-1" role="dialog" aria-labelledby="myModalLabel8" aria-hidden="true">
                            <div class="modal-wrapper">
                                <div class="modal-dialog">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                                            <h4 class="modal-title" id="myModalLabel8">ADD PROJECT(S)</h4>
                                        </div>
                                        <?php echo form_open('budget/budgetproject_c/save_budgetproject', 'class="form-horizontal"'); ?>
                                        <div class="modal-body">
                                            <div class="form-group">
                                                <label class="col-sm-4 control-label">No Budget</label>
                                                <div class="col-sm-5">
                                                    <input name="INT_NO_BUDGET_CPX_TEMP" class="form-control" readonly="true" type="text" value="<?php echo $data->INT_NO_BUDGET_CPX_TEMP; ?>">
                                                </div>
                                            </div>

                                            <div class="form-group">
                                                <label class="col-sm-4 control-label">Choose project(s)</label>
                                                <div class="col-sm-3">
                                                    <select name="INT_ID_PROJECT[]" multiple id="e1" class="form-control" style="width:300px">
                                                        <?php
                                                        foreach ($data_project_new as $isi) {
                                                            ?>
                                                            <option value="<?php echo $isi->INT_ID_PROJECT; ?>"><?php echo $isi->CHR_PROJECT . ' / ' . $isi->CHR_PROJECT_DESC; ?></option>
                                                            <?php
                                                        }
                                                        ?> 
                                                    </select>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="modal-footer">
                                            <div class="btn-group">
                                                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                                                <button type="submit" class="btn btn-primary"><i class="fa fa-check"></i>Add</button>
                                            </div>
                                        </div>
                                        <?php echo form_close(); ?>
                                    </div>
                                </div>
                            </div>
                        </div>


                    </div>
                </div>
            </div>

            <div class="col-md-4">
                <div class="grid">
                    <div class="grid-header">
                        <span class="grid-title">PRODUCT(S)</span>
                        <?php if ($session['ROLE'] == 1 || $session['ROLE'] == 2 || $session['ROLE'] == 6) { ?>
                            <div class="pull-right grid-tools">
                                <a data-toggle="modal" data-target="#modalProduct" title="Add product"><i class="fa fa-plus"></i></a>
                            </div>
                        <?php } ?>
                    </div>
                    <div class="grid-body">
                        <table  class="table table-condensed table-striped display" cellspacing="0" width="100%">
                            <thead>
                                <tr>
                                    <th>No</th>
                                    <th>Product</th>
                                    <th>Product Desc</th>
                                    <th>Actions</th>

                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                $i = 1;
                                foreach ($data_product as $isi) {
                                    echo "<tr class='gradeX'>";
                                    echo "<td>$i</td>";
                                    echo "<td>$isi->CHR_PRODUCT</td>";
                                    echo "<td>$isi->CHR_PRODUCT_DESC</td>";
                                    ?>
                                <td>
                                    <a href="<?php echo base_url('index.php/budget/budgetproduct_c/delete_budgetproduct') . "/" . $isi->INT_ID_PRODUCT . "/" . $data->INT_NO_BUDGET_CPX_TEMP ?>" class="label label-danger" data-toggle="tooltip" data-placement="right" title="Remove" onclick="return confirm('Are you sure want to delete this product?');"><span class="fa fa-times"></span></a>
                                </td>
                                </tr>
                                <?php
                                $i++;
                            }
                            ?>
                            </tbody>
                        </table>

                        <!--modal product-->
                        <div class="modal fade md-effect-6" id="modalProduct" tabindex="-1" role="dialog" aria-labelledby="myModalLabel8" aria-hidden="true">
                            <div class="modal-wrapper">
                                <div class="modal-dialog">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                                            <h4 class="modal-title" id="myModalLabel8">ADD PRODUCT(S)</h4>
                                        </div>
                                        <?php echo form_open('budget/budgetproduct_c/save_budgetproduct', 'class="form-horizontal"'); ?>
                                        <div class="modal-body">
                                            <div class="form-group">
                                                <label class="col-sm-4 control-label">No Budget</label>
                                                <div class="col-sm-5">
                                                    <input name="INT_NO_BUDGET_CPX_TEMP" class="form-control" readonly="true" type="text" value="<?php echo $data->INT_NO_BUDGET_CPX_TEMP; ?>">
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <label class="col-sm-4 control-label">Choose product(s)</label>
                                                <div class="col-sm-5">
                                                    <select name="INT_ID_PRODUCT[]" multiple id="e2"  class="form-control" style="width:300px">
                                                        <?php
                                                        foreach ($data_product_new as $isi) {
                                                            ?>
                                                            <option value="<?php echo $isi->INT_ID_PRODUCT; ?>"><?php echo $isi->CHR_PRODUCT . ' / ' . $isi->CHR_PRODUCT_DESC; ?></option>
                                                            <?php
                                                        }
                                                        ?> 
                                                    </select>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="modal-footer">
                                            <div class="btn-group">
                                                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                                                <button type="submit" class="btn btn-primary"><i class="fa fa-check"></i>Add</button>
                                            </div>
                                        </div>
                                        <?php echo form_close(); ?>
                                    </div>
                                </div>
                            </div>
                        </div>

                    </div>
                </div>
            </div>

            <!--Detail budget-->
            <div class="col-md-8">
                <div class="grid">
                    <div class="grid-header">
                        <span class="grid-title">DETAIL REVISE</span>
                        <?php if ($session['ROLE'] == 1 || $session['ROLE'] == 2 || $session['ROLE'] == 6) { ?>
                            <div class="pull-right  grid-tools">
                                <a data-toggle="modal" data-target="#modalDetail" title="Add revise"><i class="fa fa-plus"></i></a>
                            </div>
                        <?php } ?>
                    </div>
                    <div class="grid-body">
                        <table class="table table-condensed table-striped display" cellspacing="0" width="100%">
                            <thead>
                                <tr>
                                    <th>Revise</th>
                                    <th>Month</th>
                                    <th>Price /Unit</th>
                                    <th>Qty</th>
                                    <th>Total</th>
                                    <th>Manager</th>
                                    <th>GM</th>
                                    <th>Director</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                foreach ($data_detail as $isi) {
                                     if ($isi->INT_APPROVE1 == 1 && $isi->INT_APPROVE2 != 1 && $isi->INT_APPROVE3 != 1) {
                                        echo "<tr class='gradeX danger'>";
                                    } else if ($isi->INT_APPROVE1 == 1 && $isi->INT_APPROVE2 == 1 && $isi->INT_APPROVE3 != 1) {
                                        echo "<tr class='gradeX warning'>";
                                    } else if ($isi->INT_APPROVE3 == 1 && $isi->INT_APPROVE2 == 1 && $isi->INT_APPROVE1 == 1) {
                                        echo "<tr class='gradeX success'>";
                                    }
                                    echo "<td>Revise-$isi->INT_REVISE</td>";
                                    echo "<td>$isi->INT_MONTH_PLAN</td>";
                                    $price = number_format($isi->DEC_PRICE_PER_UNIT, 0, '', '.');
                                    $total = number_format($isi->JUMLAH, 0, '', '.');
                                    echo "<td>$price</td>";
                                    echo "<td>$isi->INT_QUANTITY</td>";
                                    echo "<td>$total</td>";
                                    echo "<td>$isi->CHR_APPROVE1</td>";
                                    echo "<td>$isi->CHR_APPROVE2</td>";
                                    echo "<td>$isi->CHR_APPROVE3</td>";
                                    echo "<td>";
                                    if ($isi->INT_APPROVE1 == 0) {
                                        ?> <a data-toggle="modal" data-target="#modalDetailEdit_<?php echo $data->INT_NO_BUDGET_CPX_TEMP . '-' . $isi->INT_REVISE; ?>" class="label label-warning"><span class="fa fa-pencil"></span></a> <?php
                                    } else {
                                        echo "";
                                    }
                                    echo "</td>";
                                    echo "</tr>";
                                }
                                ?>
                            </tbody>
                        </table>

                        <!--Modal Edit-->
                        <div class="modal fade md-effect-6" id="modalDetailEdit_<?php echo $data->INT_NO_BUDGET_CPX_TEMP . '-' . $isi->INT_REVISE; ?>" tabindex="-1" role="dialog" aria-labelledby="myModalLabel8" aria-hidden="true">
                            <div class="modal-wrapper">
                                <div class="modal-dialog">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                                            <h4 class="modal-title" id="myModalLabel8">EDIT REVISE</h4>
                                        </div>
                                        <?php echo form_open('budget/budgetcapexdetail_c/update_revise', 'class="form-horizontal" name="g"'); ?>
                                        <div class="modal-body">
                                            <div class="form-group">
                                                <label class="col-sm-4 control-label">No Budget</label>
                                                <div class="col-sm-5">
                                                    <input name="INT_NO_BUDGET_CPX_TEMP" class="form-control" readonly="true" type="text" value="<?php echo $data->INT_NO_BUDGET_CPX_TEMP; ?>">
                                                </div>
                                            </div>

                                            <div class="form-group">
                                                <label class="col-sm-4 control-label">Revise</label>
                                                <div class="col-sm-5">
                                                    <input name="INT_REVISE" class="form-control" readonly="true" type="text" value="<?php echo trim($isi->INT_REVISE); ?>">
                                                </div>
                                            </div>

                                            <?php $harga = number_format($isi->DEC_PRICE_PER_UNIT, 0, '', '.'); ?>

                                            <div class="form-group">
                                                <label class="col-sm-4 control-label">Price / Unit</label>
                                                <div class="col-sm-5">
                                                    <input name="a" autocomplete="off" onkeyup="formatangka(this);
        replaceChars(document.g.a.value);" class="form-control" required type="text" value="<?php echo $harga ?>">
                                                </div>
                                            </div>

                                            <input name="DEC_PRICE_PER_UNIT" type="hidden" value="<?php echo $isi->DEC_PRICE_PER_UNIT; ?>">

                                            <div class="form-group">
                                                <label class="col-sm-4 control-label">Month Plan</label>
                                                <div class="col-sm-5">
                                                    <select name="INT_MONTH_PLAN" id="source" class="form-control" style="width:170px">
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
                                            </div>

                                            <div class="form-group">
                                                <label class="col-sm-4 control-label">Qty</label>
                                                <div class="col-sm-5">
                                                    <input name="INT_QUANTITY" class="form-control" required onkeyup="angka(this);"  type="text" value="<?php echo trim($isi->INT_QUANTITY); ?>" style="width:70px">
                                                </div>
                                            </div>

                                            <div class="form-group">
                                                <label class="col-sm-4 control-label">Run Depreciation</label>
                                                <div class="col-sm-4">
                                                    <select name="CHR_DEPCY1" id="source" class="form-control" style="width:170px">
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
                                                <div class="col-sm-3">
                                                    <input name="CHR_DEPCY2" class="form-control" required type="number" value="2015" maxlength="4" style="width:80px">
                                                </div>
                                            </div>

                                        </div>
                                        <div class="modal-footer">
                                            <div class="btn-group">
                                                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                                                <button type="submit" class="btn btn-primary"><i class="fa fa-check"></i>Update</button>
                                            </div>
                                        </div>
                                        <?php echo form_close(); ?>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- modal add detail-->
                        <div class="modal fade md-effect-6" id="modalDetail" tabindex="-1" role="dialog" aria-labelledby="myModalLabel8" aria-hidden="true">
                            <div class="modal-wrapper">
                                <div class="modal-dialog">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                                            <h4 class="modal-title" id="myModalLabel8">REVISE-<?php echo intval($isi->INT_REVISE) + 1 ?></h4>
                                        </div>
                                        <?php echo form_open('budget/budgetcapexdetail_c/add_revise', 'class="form-horizontal" name="f"'); ?>
                                        <div class="modal-body">

                                            <div class="form-group">
                                                <label class="col-sm-4 control-label">No Budget</label>
                                                <div class="col-sm-5">
                                                    <input name="INT_NO_BUDGET_CPX_TEMP" class="form-control" readonly="true" type="text" value="<?php echo trim($isi->INT_NO_BUDGET_CPX_TEMP); ?>">
                                                </div>
                                            </div>

                                            <input name="INT_REVISE" class="form-control" type="hidden" value="<?php echo intval($isi->INT_REVISE) + 1 ?>">

                                            <div class="form-group">
                                                <label class="col-sm-4 control-label">Price / Unit</label>
                                                <div class="col-sm-5">
                                                    <input name="a" autocomplete="off" onkeyup="formatangka(this);
        replaceChars(document.f.a.value);" class="form-control" required type="text">
                                                </div>
                                            </div>

                                            <input name="DEC_PRICE_PER_UNIT" type="hidden">

                                            <div class="form-group">
                                                <label class="col-sm-4 control-label">Month Plan</label>
                                                <div class="col-sm-5">
                                                    <select name="INT_MONTH_PLAN" id="source" class="form-control" style="width:170px">
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
                                            </div>

                                            <div class="form-group">
                                                <label class="col-sm-4 control-label">Qty</label>
                                                <div class="col-sm-5">
                                                    <input name="INT_QUANTITY" autocomplete="off" onkeyup="angka(this);"  class="form-control" required type="text" value="0" style="width:70px">
                                                </div>
                                            </div>

                                            <div class="form-group">
                                                <label class="col-sm-4 control-label">Run Depreciation</label>
                                                <div class="col-sm-4">
                                                    <select name="CHR_DEPCY1" id="source" class="form-control" style="width:170px">
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
                                                <div class="col-sm-3">
                                                    <input name="CHR_DEPCY2" class="form-control" required type="number" value="2015" maxlength="4" style="width:80px">
                                                </div>
                                            </div>

                                        </div>
                                        <div class="modal-footer">
                                            <div class="btn-group">
                                                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                                                <button type="submit" class="btn btn-primary"><i class="fa fa-check"></i>Add</button>
                                            </div>
                                        </div>
                                        <?php echo form_close(); ?>
                                    </div>
                                </div>
                            </div>
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </section>
</aside>