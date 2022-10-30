<script type="text/javascript">
    $(document).ready(function() {
        $("#selectdept").change(function() {
            $.ajax({
                url: "<?php echo base_url(); ?>index.php/budget/purchase_request_c/buildDropSection",
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
                url: "<?php echo base_url(); ?>index.php/budget/purchase_request_c/buildDropSection",
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
                url: "<?php echo base_url(); ?>index.php/budget/purchase_request_c/buildsubcategory",
                data: {id: $(this).val()}, type: "POST",
                success: function(data) {
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
            <li><a href="<?php echo base_url('index.php/basis/home_c/') ?>">Home</a></li>
            <li><a href="<?php echo base_url('index.php/budget/purchase_request_c/') ?>">Manage Purchase Request</a></li>            
            <li> <a href="#"><strong>Edit Purchase Request</strong></a></li>
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
                        <span class="grid-title"><strong>PURCHASE</strong> REQUEST DETAIL</span>
                        <div class="pull-right grid-tools">
                            <a data-widget="collapse" title="Collapse"><i class="fa fa-chevron-up"></i></a>
                        </div>
                    </div>


                    <div class="grid-body">
                        <table class="table table-condensed table-bordered table-striped" cellspacing="0" width="100%">
                            <tr><td><strong>Fiscal Year</strong></td><td><?php echo $data->CHR_FISCAL_YEAR; ?></td></tr>
                            <tr><td><strong>Department</strong></td><td><?php echo $data->CHR_DEPT_DESC; ?></td></tr>
                            <tr><td><strong>Section</strong></td><td><?php echo $data->CHR_SECTION_DESC; ?></td></tr>
                            <tr><td><strong>Month Estimate</strong></td><td><?php echo $data->INT_MONTH_REAL; ?></td></tr>
                            <?php $mount = number_format($data->DEC_TOTAL, 0, '', '.'); ?>
                            <tr><td><strong>Total</strong></td><td><?php echo $mount; ?></td></tr>
                        </table>
                    </div>


                    <div class="grid-body">
                        <table id="dataTables1" class="table table-condensed table-striped table-bordered display" cellspacing="0" width="100%">
                            <thead>
                                <tr>
                                    <th>Budget</th>
                                    <th>Price Per Unit</th>
                                    <th>Qty</th>
                                    <th>Total</th>
                                    <th>Purchase Item</th>
                                    <th>Action</th>
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
                                    <a href="<?php echo base_url('index.php/budget/purchase_request_detail_c/edit_purchase_request_detail') . '/' . $isi->INT_NO_BUDGET . '/' . $isi->INT_NO_PUREQ ?>" class="label label-warning"><span class="fa fa-pencil"></span></a>
                                </td>
                                </tr>

                                <?php
                            }
                            ?>
                            </tbody>
                        </table>
                    </div>


                    <div class="grid-body">
                        <?php
                        echo anchor('budget/purchase_request_c/', 'Back', 'class="btn btn-default" data-toggle="tooltip" data-placement="right" title="Back to manage"');
                        ?>
                    </div>


                </div>
            </div>


            <?php
            if ($subcontent != NULL) {
                $this->load->view($subcontent);
            }
            ?>

        </div>

    </section>
</aside>