
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
        document.f.MON_PRICE_PER_UNIT.value = temp;
        document.g.MON_PRICE_PER_UNIT.value = temp;
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
            <li><a href="<?php echo base_url('index.php/budget/purchase_request_c/') ?>">Manage Purchase Request</a></li>            
            <li><a href="#"><strong>View Detail Purchase Request</strong></a></li>
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
                        <span class="grid-title"><?php echo $data->INT_NO_PUREQ; ?></span>
                    </div>
                    <div class="grid-body">
                        <table class="table table-condensed table-bordered table-striped" cellspacing="0" width="100%">
                            <tr><td><strong>Fiscal Year</strong></td><td><?php echo $data->CHR_FISCAL_YEAR; ?></td></tr>
                            <tr><td><strong>Department</strong></td><td><?php echo $data->CHR_DEPT_DESC; ?></td></tr>
                            <tr><td><strong>Section</strong></td><td><?php echo $data->CHR_SECTION_DESC; ?></td></tr>
                            <tr><td><strong>Month Realization</strong></td><td><?php echo $data->INT_MONTH_REAL; ?></td></tr>
                            <?php $mount = number_format($data->DEC_TOTAL, 0, '', '.'); ?>
                            <tr><td><strong>Total</strong></td><td><?php echo $mount; ?></td></tr>
                        </table>
                    </div>
                    <div class="grid-body">
                        <?php
                        echo anchor('budget/purchase_request_c', 'Back', 'class="btn btn-default" data-toggle="tooltip" data-placement="right" title="Back to manage"');
                        ?>
                    </div>
                </div>
            </div>

            <!--Detail Purchase Request-->
            <div class="col-md-8">
                <div class="grid">
                    <div class="grid-header">
                        <i class="fa fa-file-text-o"></i>
                        <span class="grid-title"><strong>DETAIL</strong> PURCHASE REQUEST</span>
                        <div class="pull-right  grid-tools">
                            <a data-toggle="modal" data-target="#modalDetail" title="Add Purchase budget"><i class="fa fa-plus"></i></a>
                        </div>
                    </div>
                    <div class="grid-body">
                        <table class="table table-condensed table-striped display" cellspacing="0" width="100%">
                            <thead>
                                <tr>
                                    <th>No Bugdet</th>
                                    <th>Expenditure Cost</th>
                                    <th>Qty</th>
                                    <th>Purchase Item</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                foreach ($data_detail as $isi) {
                                    echo "<tr class='gradeX'>";
                                    echo "<td>$isi->INT_NO_BUDGET</td>";
                                    $mount = number_format($isi->DEC_PRICE_PER_UNIT, 0, '', '.');
                                    echo "<td>$mount</td>";
                                    echo "<td>$isi->INT_QUANTITY</td>";
                                    echo "<td>$isi->CHR_PURCHASE_ITEM</td>";
                                    echo "<td>";
                                    ?> 
                                <a data-toggle="modal" data-target="#modalDetailEdit_<?php echo $data->INT_NO_PUREQ; ?>" class="label label-warning" title="Edit"><span class="fa fa-pencil"></span></a> 
                                <?php
                                echo "</td>";
                                echo "</tr>";
                            }
                            ?>
                            </tbody>
                        </table>

                        <!--Modal Edit-->
                        <div class="modal fade md-effect-6" id="#modalDetailEdit_<?php echo $data->INT_NO_PUREQ; ?>" tabindex="-1" role="dialog" aria-labelledby="myModalLabel8" aria-hidden="true">
                            <div class="modal-wrapper">
                                <div class="modal-dialog">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                                            <h4 class="modal-title" id="myModalLabel8">EDIT PURCHASE DETAIL</h4>
                                        </div>
                                        <?php echo form_open('budget/purchase_request_c/update_purchase_request', 'class="form-horizontal" name="g"'); ?>
                                        <div class="modal-body">
                                            <div class="form-group">
                                                <label class="col-sm-4 control-label">No Budget</label>
                                                <div class="col-sm-5">
                                                    <input name="INT_NO_BUDGET" class="form-control" readonly="true" type="text" value="<?php echo '' ?>">
                                                </div>
                                            </div>

                                            <div class="form-group">
                                                <label class="col-sm-4 control-label">Expenditure Cost</label>
                                                <div class="col-sm-5">
                                                    <?php
                                                    $harga = number_format($isi->DEC_PRICE_PER_UNIT, 0, '', '.');
                                                    ?>
                                                    <input name="a" autocomplete="off" onkeyup="formatangka(this);
        replaceChars(document.g.a.value);" class="form-control" required type="text" value="<?php echo $harga ?>">
                                                </div>
                                            </div>

                                            <input name="DEC_PRICE_PER_UNIT" type="hidden">

                                            <div class="form-group">
                                                <label class="col-sm-4 control-label">Qty</label>
                                                <div class="col-sm-5">
                                                    <input name="INT_QUANTITY" class="form-control" required onkeyup="angka(this);"  type="text" value="<?php echo $isi->INT_QUANTITY; ?>" style="width:70px">
                                                </div>
                                            </div>

                                            <div class="form-group">
                                                <label class="col-sm-4 control-label">Purchase Item</label>
                                                <div class="col-sm-5">
                                                    <input name="CHR_PURCHASE_ITEM" class="form-control" type="text" value="<?php echo $isi->CHR_PURCHASE_ITEM; ?>">
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
                                            <h4 class="modal-title" id="myModalLabel8">Add Purchase Budget</h4>
                                        </div>
                                        <?php echo form_open('budget/purchase_request_c/save_purchase_request', 'class="form-horizontal" name="f"'); ?>
                                        <div class="modal-body">

                                            <div class="form-group">
                                                <label class="col-sm-4 control-label">No Budget</label>
                                                <div class="col-sm-5">
                                                    <input name="INT_NO_BUDGET" class="form-control" readonly="true" type="text" value="<?php echo '' ?>">
                                                </div>
                                            </div>

                                            <div class="form-group">
                                                <label class="col-sm-4 control-label">Expenditure Cost</label>
                                                <div class="col-sm-5">
                                                    <input name="a" autocomplete="off" onkeyup="formatangka(this);
        replaceChars(document.f.a.value);" class="form-control" required type="text">
                                                </div>
                                            </div>

                                            <input name="DEC_PRICE_PER_UNIT" type="hidden">

                                            <div class="form-group">
                                                <label class="col-sm-4 control-label">Qty</label>
                                                <div class="col-sm-5">
                                                    <input name="INT_QUANTITY" autocomplete="off" onkeyup="angka(this);"  class="form-control" required type="text" value="0" style="width:70px">
                                                </div>
                                            </div>

                                            <div class="form-group">
                                                <label class="col-sm-4 control-label">Purchase Item</label>
                                                <div class="col-sm-5">
                                                    <input name="CHR_PURCHASE_ITEM" class="form-control" type="text">
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