<script>
    $(document).ready(function () {
        $("#datepicker1").datepicker({dateFormat: 'dd-mm-yy'}).val();

    });

    $(document).ready(function () {
        $("#datepicker2").datepicker({dateFormat: 'dd-mm-yy'}).val();

    });

    $(document).ready(function () {
        $('#e2').change(function () {
            var cust_no = $('#e2').val();
            $("#cus_no_excel").val(cust_no);

            $.ajax({
                url: "<?php echo site_url('marketing/purchase_order_c/update_filter'); ?>",
                type: 'POST',
                data: {cust_no: cust_no},
                success: function (data) {
                    $("#filter_cus_po").html(data);
                    //$("#filter_btn").click();
                },
                error: function (request) {
                    alert(request.responseText);
                }
            });
        });

        $('#e1').change(function () {
            var cust_po = $('#e1').val();
            $("#cus_po_excel").val(cust_po);
        });

        $('#cus_po_selected').change(function () {
            var cus_po = $('#cus_po_selected').val();
            $("#cus_po_excel").val(cus_po);
        });

    });
</script>

<style type="text/css">
    th, td { white-space: nowrap; }
    div.dataTables_wrapper {
        font-size: 11px;
    }
    #table-luar{
        font-size: 11px;
    }
    #filter { 
        border-spacing: 10px;
        border-collapse: separate;
    }
    .td-fixed{
        width: 30px;
    }
    .td-no{
        width: 10px;
    }
    .ddl3{
        width: 300px;
        height: 30px;
    }
</style>

<aside class="right-side">
    <section class="content-header">
        <ol class="breadcrumb">
            <li><a href="<?php echo base_url('index.php/basis/home_c/'); ?>"><span>Home</span></a></li>
            <li><a href=""><strong>REPORT STATUS PO</strong></a></li>
        </ol>
    </section>

    <section class="content">
        <!--GRID TO DISPLAY GRID TABLE SCAN-->
        <div class="row">
            <div class="col-md-12">
                <div class="grid">
                    <div class="grid-header">
                        <i class="fa fa-th-large"></i>
                        <span class="grid-title"> <strong>REPORT STATUS PO</strong></span>
                        <div class="pull-right grid-tools">
                            <a data-widget="collapse" data-toggle="tooltip"  title="Collapse">
                                <i class="fa fa-chevron-up"></i>
                            </a>
                        </div>
                    </div>
                    <div class="grid-body">
                        <div class="pull">
                            <?php echo form_open('marketing/purchase_order_c/search_purchase_order', 'class="form-horizontal"'); ?>
                            <table width="100%" id='filter' border=0px>
                                <tr>
                                    <td width="10%">Customer No
                                    </td>
                                    <td width="10%" id="filter_cus_no">   
                                        <select name="CHR_CUS_NO" class="ddl3" id="e2" style="width:100px;">
                                            <?php foreach ($all_cust_no as $row) { ?>
                                                <option value="<?php echo trim($row->CHR_CUS_NO) ?>" <?php
                                                if (trim($cust_no) == trim($row->CHR_CUS_NO)) {
                                                    echo 'SELECTED';
                                                }
                                                ?> >
                                                    &nbsp;&nbsp;<? echo trim($row->CHR_CUS_NO); ?></option>
                                            <?php } ?>
                                        </select>

                                    </td>
                                    <td width="10%">
                                    </td>
                                    <td width="50%">
                                    </td>
                                    <td width="10%">
                                    </td>
                                    <td width="10%">
                                    </td>
                                </tr>
                                <tr>
                                    <td width="10%">PO Customer No
                                    </td>
                                    <td width="10%" id="filter_cus_po">   
                                        <select name="CHR_CUS_PO" class="ddl3" id="e1" style="width:300px;">
                                            <?php foreach ($all_cust_po as $row) { ?>
                                                <option value="<?php echo trim($row->CHR_CUS_PO) ?>" <?php
                                                if (trim($cust_po) == trim($row->CHR_CUS_PO)) {
                                                    echo 'SELECTED';
                                                }
                                                ?> >
                                                    &nbsp;&nbsp;<? echo trim($row->CHR_CUS_PO); ?></option>
                                            <?php } ?>
                                        </select>
                                    </td>
                                    <td width="10%">
                                        <button type="submit" style="margin-top:10px;" name="btn_filter" value="1"  id="filter_btn" class="btn btn-primary" data-placement="right"><i class="fa fa-filter"></i> Filter</button>
                                        <?php echo form_close() ?>
                                    </td>
                                    <td width="50%">
                                    </td>
                                    <td width="10%">
                                    </td>
                                    <td width="10%">
                                        <?php echo form_open('marketing/purchase_order_c/print_purchase_order', 'class="form-horizontal"'); ?>
                                        <input name="CHR_CUS_PO_EXCEL" type="hidden" id="cus_po_excel" value="<?php echo $cust_po; ?>">
                                        <input name="CHR_CUS_NO_EXCEL" type="hidden" id="cus_no_excel" value="<?php echo $cust_no; ?>">
                                        <button type="submit" style="margin-top:10px;" name="btn_submit" value="1" class="btn btn-success" data-placement="right"><i class="fa fa-download"></i> Export to Excel</button>
                                        <?php echo form_close() ?>
                                    </td>
                                </tr>
                            </table>

                        </div>
                        <div id="table-luar">
                            <table id="dataTables1" class="table table-condensed table-striped table-hover display" cellspacing="0" width="100%">
                                <thead>
                                    <tr class='gradeX'>
                                        <th style="text-align:center;">No </th>
                                        <th style="text-align:center;">Part No Cust </th>
                                        <th style="text-align:center;">Part.Name </th>
                                        <th style="text-align:center;">PO. Number</th>
                                        <th style="text-align:center;">Dok To</th>
                                        <th style="text-align:center;">Qty PO</th> 
                                        <th style="text-align:center;">Act Delivery </th>
                                        <th style="text-align:center;">Balance </th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    $r = 1;
                                    foreach ($data_purchase_order as $isi) {
                                        echo "<tr class='gradeX'>";
                                        echo "<td style=text-align:center;>$r</td>";
                                        echo "<td style=text-align:center;>$isi->CHR_CUS_PART_NO</td>";
                                        echo "<td style=vertical-align: top;text-align: left;>$isi->CHR_PART_NAME</td>";
                                        echo "<td style=vertical-align: top;text-align: left;>$isi->CHR_CUS_PO</td>";
                                        echo "<td style=vertical-align: top;text-align: left;>$isi->CHR_DOK_TO</td>";
                                        echo "<td style=text-align:center;>$isi->INT_TOT_QTY</td>";
                                        echo "<td style=text-align:center;>$isi->INT_ACTUAL_DEL</td>";
                                        echo "<td style=text-align:center;>$isi->INT_BALANCE</td>";
                                        ?>
                                        </tr>
                                        <?php
                                        $r++;
                                    }
                                    ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>

    </section>
</aside>