<style type="text/css">
    [class='xx'] {
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
    .ui-autocomplete { 
        position: absolute;
        list-style: none; 
        background-color: #f5f8f9;
        font-family: 'Ubuntu', sans-serif;
        float: left; 
        display: none; 
        min-width: 472px !important;
        padding: 0px 10px; 
        margin: 0 0 10px 25px;    
    }
</style>

<script>
    setTimeout(function () {
        document.getElementById("hide-sub-menus").click();
    }, 10);
</script>
<script type="text/javascript">

    $(document).ready(function () {
        //var c = document.getElementById("opt_sloc");
        $('#idsparepart').autocomplete({
            source: function(request, response) {
                $.getJSON('<?php echo site_url('/samanta/spare_parts_c/search_sp_ol/'); ?>', {
                    term: request.term
                }, response)

            },
            minLength: 1,
            focus: function( event, ui ) {
                $( "#idsparepart" ).val( ui.item.label );
                return false;
            },
            select: function( event, ui ) {
                $( "#idsparepart" ).val( ui.item.value+'- '+ui.item.spek );
                $( "#nopart" ).val( ui.item.value );
                $( "#namasp" ).val( ui.item.nama );
                $( "#speksp" ).val( ui.item.spek );
                $( "#compsp" ).val( ui.item.compo);
                $( "#pricesp" ).val( ui.item.price );
                $( "#modelsp" ).val( ui.item.model );
                $( "#qty_use" ).val( ui.item.qty_use );
                $( "#qty_min" ).val( ui.item.qty_min );
                $( "#qty_max" ).val( ui.item.qty_max );
                document.getElementById('add_temp_spare_part').style.display = 'block';
                $.ajax({
                    async: false,
                    type: "POST",
                    url: "<?php echo site_url('samanta/spare_parts_c/get_wh_by_partno'); ?>",
                    data: "partno=" + ui.item.value,
                    success: function (data) {
                        //alert(data);
                        $("#select_warehouse").html(data);
                        //$("#select_pic").value = selected_pic;
                    }
                });
                // $( "#compsp" ).val( ui.item.compo );
                return false;
            }        
        });
    }); 

    
</script>

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
                        <i class="fa fa-laptop"></i>
                        <span class="grid-title" id="stat-create2"><strong id="stat-create">ORDER LIST</strong> SPARE PART</span>
                        <!-- <div class="pull-right grid-tools" style="font-size:11px;" >
                        </div> -->
                         <div class="pull-right">
                            <button class="btn btn-default" data-toggle="modal" data-target="#modal_add_sparepart" data-placement="left" title="Add Sparepart" style="height:30px;font-size:13px;width:120px;">Add Spare Parts</a>
                        </div>
                    </div>
                    <div class="grid-body">
                        <div class="pull-right">                        
                        <table  width="100%" border="0px">
                            <tr>
                            <form action="" method="POST" onSubmit="return confirmAction()">
                                <td width="90%">
                                    <button type="submit" name="btn_create" value="Create Order List" id="submit_create" title="Create Order List" class="btn btn-warning" style="font-size:12px;"><span class="fa fa-save"></span>&nbsp;Create Order List</button>
                                </td>
                            </tr>
                        </table>
                        </div>
                        <br>
                        <table class="table table-condensed table-bordered table-striped table-hover display" id="list_data">
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
                                    <td align='center' style="vertical-align: middle;">Price</td>
                                </tr>
                            </thead>

                            <tbody> 
                            <?php $i = 1;
                                foreach ($data_all_parts_trans as $datatable) {
                                echo "<tr>";
                                    echo "<td style='text-align:center'>$i</td>";
                                    ?>
                                    <input type="hidden" name="part_no[<?php echo $i; ?>]" value="<?php echo $datatable->CHR_PART_NO; ?>" /> 
                                    <input type="text" class="xx" name="price[<?php echo $i; ?>]" value="<?php echo $datatable->CHR_PRICE; ?>" />
                                    <?php
                                    echo "<td style='text-align:center'>$datatable->CHR_PART_NO</td>";
                                    echo "<td>". substr($datatable->CHR_SPARE_PART_NAME,0,20) . "</td>";
                                    echo "<td>$datatable->CHR_SPECIFICATION</td>";
                                    echo "<td style='text-align:center'>$datatable->CHR_COMPONENT</td>";
                                    echo "<td style='text-align:center'>$datatable->CHR_MODEL</td>";
                                    echo "<td style='text-align:center'>$datatable->INT_QTY_USE</td>";
                                    echo "<td style='text-align:center'>$datatable->INT_QTY_MIN</td>";
                                    echo "<td style='text-align:center'>$datatable->INT_QTY_MAX</td>";
                                    if ($datatable->INT_QTY_ACT < $datatable->INT_QTY_MIN) {
                                        echo "<td style=text-align:center;><span class='badge bg-red'>$datatable->INT_QTY_ACT</span></td>";
                                    }
                                    elseif ($datatable->INT_QTY_ACT == $datatable->INT_QTY_MIN){
                                        echo "<td style=text-align:center;><span class='badge bg-yellow'>$datatable->INT_QTY_ACT</span></td>";
                                    }
                                    else {
                                        echo "<td style=text-align:center;>$datatable->INT_QTY_ACT</td>";
                                    } 
                                    echo "<td style='text-align:center'>$datatable->INT_QTY_OUT</td>"; ?>
                                    <td><input autocomplete="off" onkeypress="return isNumberKey(event)"
                                            style="text-align:right;padding-right:0px;width:60px;background: #7FFFD4;font-weight:bold;" 
                                            type="text" 
                                            size="1" 
                                            class="decimalFormat" 
                                            name="qty_order[<?php echo $i; ?>]" 
                                            value="<?php echo number_format($datatable->INT_QTY_ORDER, 0, ',', '.'); ?>">
                                    </td>
                                    <td style='text-align:center'>Rp&nbsp;<?php  $price_per_unit = (int)$datatable->CHR_PRICE;
                                        echo number_format($price_per_unit, 0, ',', '.'); ?></td>
                                </tr>
                                <?php
                                $i++; }
                            ?>
                            </tbody>
                        </table>
                        <input type="hidden" name="i" value="<?php echo $i - 1; ?>">
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </section>
</aside>

<div class="modal fade" id="modal_add_sparepart"  tabindex="-1" role="dialog" aria-labelledby="modalprogress" aria-hidden="true" style="display: none;">
    <div class="modal-wrapper" style="width: 900px;">
        <div class="modal-dialog">
            <div class="modal-content">
              
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">X</button>
                        <h4 class="modal-title" id="modalprogress"><strong>Add Spare Parts</strong></h4>
                        <input type="hidden" name="sloc" id="sloc">
                        <input type="hidden" name="tgl" id="tgl">
                </div>
                 <form method="POST" action="<?php echo base_url() ?>index.php/samanta/spare_parts_c/add_sp_ol" onSubmit="return confirmAction()">
                <div class="modal-body">
                    <div class="col-sm-6 col-lg-6">
                            <label class="col-sm-3 control-label">Spare Parts</label>
                            <div class="form-group ui-front">
                                <div class="col-sm-9">
                                   <input  class="form-control" name="sparepart" id="idsparepart" type="text"/>
                                   <input  class="form-control" name="nopart" id="nopart" type="hidden"/>
                                   <input  class="form-control" name="spek" id="speksp" type="hidden"/>
                                   <input  class="form-control" name="namasp" id="namasp" type="hidden"/>
                                   <input  class="form-control" name="compsp" id="compsp" type="hidden"/>
                                   <input  class="form-control" name="pricesp" id="pricesp" type="hidden"/>
                                   <input  class="form-control" name="modelsp" id="modelsp" type="hidden"/>
                                   <input  class="form-control" name="qty_use" id="qty_use" type="hidden"/>
                                   <input  class="form-control" name="qty_min" id="qty_min" type="hidden"/>
                                   <input  class="form-control" name="qty_max" id="qty_max" type="hidden"/>
                                   <input  class="form-control" name="qty_act" id="qty_act" type="hidden"/>
                                </div>
                            </div>
                            <br/><br/>
                            <div class="form-group">
                                 <div class="col-sm-5">
                                    <button type="submit" class="btn btn-primary" data-placement="left" data-toggle="tooltip" title="Add this data" style="display: none;" id="add_temp_spare_part"><i class="fa fa-check"></i>Add Spareparts</button>
                                </div>
                            </div>
                    </div>
                    <div class="col-sm-6 col-lg-6">
                        <label class="col-sm-3 control-label">Warehouse</label>
                        <div class="col-sm-4">
                            <select  id="select_warehouse" name="select_warehouse" required style="height:35px;width:200px;">
                                <!--<option value=""> &nbsp;&nbsp;&nbsp;&nbsp;---CHOOSE PIC---</option> -->
                            </select>
                        </div>
                    
                    </div>

                </div>
                <div class="modal-footer" style="border-top: none" >
                    
                </div>
                </form>
            </div>
        </div>
    </div>
</div>

<script type="text/javascript">   

    function confirmAction() { 
            return confirm("Anda yakin untuk menambah data?");
    }

    function isNumberKey(evt)
    {
        var charCode = (evt.which) ? evt.which : event.keyCode
        if (charCode > 31 && (charCode < 48 || charCode > 57))
            return false;

        return true;
    }
</script>

<script type="text/javascript">

    function findTotalOK(arrPart) {
        // $(".decimalFormat").maskMoney({thousands: '.', decimal: ',', precision: '0', allowZero: true});
        var tot = 0;
        for (var i = 1; i <<?php echo $i; ?>; i++) {
            var arr = document.getElementsByName('qty_ok[' + i + ']');
            if (parseInt(arr[0].value.replace(".", "")))
                tot += parseInt(arr[0].value.replace(".", ""));
        }
        var a = tot;
        document.getElementById('tot_qty').value = tot;

        if (arrPart) {
            findTotalPart(arrPart);
        }
    }
    
    function findTotalPart(arrPart) {
        var tot = 0;
        var arrqty_ok = document.getElementsByName('qty_ok[' + arrPart + ']');
        tot = parseInt(arrqty_ok[0].value.replace(".", ""));
        document.getElementById('sum_qty[' + arrPart + ']').value = tot;

        tot = 0;
        for (var i = 1; i <<?php echo $i; ?>; i++) {

            var arr = document.getElementsByName('sum_qty[' + i + ']');
            if (parseInt(arr[0].value.replace(".", "")))
                tot += parseInt(arr[0].value.replace(".", ""));
        }
        document.getElementById('tot_sum_qty').value = tot.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ",");
        ;
    }

    findTotalOK();

    var tot = 0;
    for (var i = 1; i <<?php echo $i; ?>; i++) {
        findTotalPart(i);
        var arr = document.getElementsByName('sum_qty[' + i + ']');
        if (parseInt(arr[0].value))
            tot += parseInt(arr[0].value);
    }
    document.getElementById('tot_sum_qty').value = tot;
</script>

<script>
    $(function () {
        //$("#datepicker").datepicker({ dateFormat: 'dd/mm/yy', maxDate: 'today'});
        //Add by bugsMaker to Preparation STO
        $("#datepicker").datepicker({ dateFormat: 'dd/mm/yy', minDate: '18/12/2017' , maxDate: 'today'});
    });
</script>

<script type="text/javascript">
    $.expr[':'].Contains = function (x, y, z) {
        return jQuery(x).text().toLowerCase().indexOf(z[3].toLowerCase()) >= 0;
    };

    $('#search_rack_number').keyup(function ()
    {
        var search = $('#search_rack_number').val();
        $('#list_data tr').show();
        if (search.length > 0)
        {

            $("#list_data tr td.rack_number").not(":Contains('" + search + "')").parent().hide();
        }
    });

    $('#search_part_number').keyup(function ()
    {
        var search = $('#search_part_number').val();
        $('#list_data tr').show();
        if (search.length > 0)
        {
            $("#list_data tr td.part_number").not(":Contains('" + search + "')").parent().hide();
        }
    });

    $('#search_spec').keyup(function ()
    {
        var search = $('#search_spec').val();
        $('#list_data tr').show();
        if (search.length > 0)
        {

            $("#list_data tr td.spec").not(":Contains('" + search + "')").parent().hide();
        }
    });
</script>

<script>
    $(':text').focus(function () {
        $(this).one('mouseup', function (event) {
            event.preventDefault();
        }).select();
    });
</script>