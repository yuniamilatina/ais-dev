<style type="text/css">
    [class='xyz']  {
        display: none;
    }
    #table-luar{
        font-size: 12px;
    }
    #filter { 
        border-spacing: 5px;
    }
    .td-fixed{
        width: 10px;
    }
    #td_date{
        text-align:center;
        vertical-align:top;
    } 

    .filter { 
        border-spacing: 5px;
        border-collapse: separate;
    }

    #filterdiagram {
        border-spacing: 5px;
        border-color: #DDDDDD;
        background-color: #F3F4F5;
    }

    .btnt{
        border:none;
    }

    .btnt:focus{
        outline: none;
    }

    .btnt:hover {
        background: #428bca;
        background-image: -webkit-linear-gradient(top, #428bca, #428bca);
        background-image: -moz-linear-gradient(top, #428bca, #428bca);
        background-image: -ms-linear-gradient(top, #428bca, #428bca);
        background-image: -o-linear-gradient(top, #428bca, #428bca);
        background-image: linear-gradient(to bottom, #428bca, #428bca);
        color:white;
    }
</style>

<aside class="right-side">
    <section class="content-header">
        <ol class="breadcrumb">
            <li><a href="<?php echo base_url('index.php/home_c/') ?>">Home</a></li>
            <li><a href="<?php echo base_url('index.php/samanta/spare_parts_c') ?>">Manage Spare Part</a></li>
            <li> <a href="#"><strong>List Order</strong></a></li>
        </ol>
    </section>
    <section class="content">
        <div class="row">
            <div class="col-md-12">
                <div class="grid">
                    <div class="grid-header">
                        <form action="" method="POST" onSubmit="return confirmAction()">
                        <i class="fa fa-check-square-o"></i>
                        <span class="grid-title" id="stat-create2"><strong id="stat-create">LIST ORDER</strong> SPARE PART</span>
                        <div class="pull-right">
                            <button type="submit" name="btn_create" value="Create Order List" id="submit_create" title="Create Order List" class="btn btn-warning" style="font-size:12px;"><span class="fa fa-save"></span>&nbsp;Create Order List</button>
                            <!-- <a href="#" class="btn btn-warning" data-target="#modalUploadData" data-toggle="modal" data-placement="left" title="Submit Data Order" style="height:35px;font-size:13px;width:150px;">Submit & Export</a> -->
                        </div>
                    </div>
                    <div class="grid-body">
                        
                        <table width="45%">
                            <td>Warehouse Area</td>
                            <td>
                            </td>
                        </table>
                        <br>
                        <table id="example" class="table table-condensed table-bordered table-striped table-hover display" cellspacing="0" width="100%">
                            <thead>
                                <tr style="font-weight:bold; font-size:12px">
                                    <th rowspan="2" align='center' style="vertical-align: middle;">No</th>
                                    <th rowspan="2" align='center' style="vertical-align: middle;">Part No</th>
                                    <th rowspan="2" align='center' style="vertical-align: middle;">Spare Part Name</th>
                                    <th rowspan="2" align='center' style="vertical-align: middle;">Specification</th>
                                    <th rowspan="2" align='center' style="vertical-align: middle;">Component</th>
                                    <th rowspan="2" align='center' style="vertical-align: middle;">Model</th>
                                    <th rowspan="2" align='center' style="vertical-align: middle;">Qty Use</th>
                                    <th rowspan="2" align='center' style="vertical-align: middle;">Qty Min</th>
                                    <th rowspan="2" align='center' style="vertical-align: middle;">Qty Max</th>
                                    <th rowspan="2" align='center' style="vertical-align: middle;">Stock</th>
                                    <th rowspan="2" align='center' style="vertical-align: middle;">Total Out</th>
                                    <th colspan="2" style="vertical-align: middle; text-align:center;">Order</th>
                                </tr>
                                <tr style="font-weight:bold; font-size:12px">
                                    <td align='center' style="vertical-align: middle;">Qty</td>
                                    <td align='center' style="vertical-align: middle;">Amount</td>
                                </tr>
                            </thead>
                            <tbody>
                                <?php $i = 1;
                                foreach ($data_all_parts_trans as $datatable) {
                                echo "<tr>";
                                    echo "<td style='text-align:center'>$i</td>";
                                    ?>
                                    <input type="text" class="xyz" name="part_no[<?php echo $i; ?>]" value="<?php echo $datatable->CHR_PART_NO; ?>" />
                                    <input type="hidden" name="total_qty[<?php echo $i; ?>]" value="<?php echo $datatable->INT_QTY_OUT; ?>" />
                                    <input type="hidden" name="price[<?php echo $i; ?>]" value="<?php echo $datatable->CHR_PRICE; ?>" /> 
                                    <?php
                                    echo "<td style=text-align:center;>$datatable->CHR_PART_NO</td>";
                                    echo "<td>". substr($datatable->CHR_SPARE_PART_NAME,0,15) . " ..</td>";
                                    echo "<td>$datatable->CHR_SPECIFICATION</td>";
                                    echo "<td style=text-align:center;>$datatable->CHR_COMPONENT</td>";
                                    echo "<td style=text-align:center;>$datatable->CHR_MODEL</td>";
                                    echo "<td style=text-align:center;>$datatable->INT_QTY_USE</td>";
                                    echo "<td style=text-align:center;>$datatable->INT_QTY_MIN</td>";
                                    echo "<td style=text-align:center;>$datatable->INT_QTY_MAX</td>";
                                    echo "<td style=text-align:center;>$datatable->INT_QTY_ACT</td>";
                                    echo "<td style=text-align:center;>$datatable->INT_QTY_OUT</td>"; ?>
                                    <td><input autocomplete="off" data-toggle="tooltip" title="Qty Order"  onfocus="if (this.value == '0') { 
                                                this.value = '';
                                                this.style.outline = 'none';
                                                var thisRow = document.getElementById('thisRow');
                                                thisRow.style.backgroundColor = '#44D7A8';
                                                this.style.backgroundColor = '#44D7A8';
                                            }" 
                                            onblur="if (this.value == '') {
                                                        this.value = '0';
                                                        this.style.backgroundColor = '#7FFFD4';
                                                    }" 
                                            onkeypress="return isNumberKey(event)"
                                            style="text-align:right;padding-right:0px;width:60px;background: #7FFFD4;font-weight:bold;" 
                                            type="text" 
                                            size="1"
                                            value="<?php echo number_format($datatable->INT_QTY_ORDER, 0, ',', '.'); ?>"
                                            name="order_qty[<?php echo $i; ?>]">
                                    </td>
                                    <td style=text-align:center;><input id="amount_order[<?php echo $i; ?>]" name="amount_order[<?php echo $i; ?>]" disabled /></td>
                                    <?php
                                echo "</tr>";
                                $i++;
                                }
                                ?>
                            </tbody>
                        </table>
                        <input type="hidden" name="i" value="<?php echo $i - 1; ?>">
                        </form>
                    </div>
                </div>
            </div>           
        </div>
        </div>

    </section>
</aside>

<script src="<?php echo base_url('assets/js/jquery-1.12.3.js') ?>"></script>
<script src="<?php echo base_url('assets/js/jquery.dataTables.min.js') ?>"></script>
<script src="<?php echo base_url('assets/js/dataTables.fixedColumns.min.js') ?>"></script>
<script>
        $(document).ready(function () {
            var table = $('#example').DataTable({
                scrollY: "1000px",
                scrollX: false,
                scrollCollapse: true,
                paging: false,
                columnDefs: [{
                        sortable: false,
                        "class": "index",
                        targets: 0
                    }]
            });

            table.on('order.dt search.dt', function () {
                table.column(0, {search: 'applied', order: 'applied'}).nodes().each(function (cell, i) {
                    //cell.innerHTML = i + 1;
                });
            }).draw();
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

    function findTotalOrder(arrPart) {
        // $(".decimalFormat").maskMoney({thousands: '.', decimal: ',', precision: '0', allowZero: true});
        var tot = 0;
        for (var i = 1; i <<?php echo $i; ?>; i++) {
            var arr = document.getElementsByName('qty_order[' + i + ']');
            if (parseInt(arr[0].value.replace(".", "")))
                tot += parseInt(arr[0].value.replace(".", ""));
        }
        var a = tot;
        document.getElementById('tot_qty').value = tot;

        if (arrPart) {
            findTotalPart(arrPart);
        }
    }

    function isNumberKey(evt)
    {    
        // for (var i = 1; i <= <?php echo $i; ?>; i++) {
        //     var qty_order = document.getElementsByName('qty_order[' + i + ']').value;
        //     var price = document.getElementsByName('qty_order[' + i + ']').value;
        //     document.getElementById('amount_order[' + i + ']').value = price * qty_order;
        // }

        var charCode = (evt.which) ? evt.which : event.keyCode
        if (charCode > 31 && (charCode < 48 || charCode > 57))
            return false;

        return true;
    }

    function confirmAction() {
        return confirm("Anda yakin untuk membuat list order data?");
    }
</script>
