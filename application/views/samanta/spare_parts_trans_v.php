<style type="text/css">
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
        var c = document.getElementById("opt_sloc");
        $('#idsparepart').autocomplete({
            source: function(request, response) {
                $.getJSON('<?php echo site_url('/samanta/spare_parts_trans_c/search/'); ?>', {
                    term: request.term,
                    loc: c.options[c.selectedIndex].text
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
                document.getElementById('compsp').value = ui.item.compo;
                $( "#pricesp" ).val( ui.item.price );
                
                // $( "#compsp" ).val( ui.item.compo );
                return false;
            }        
        });
    }); 

    
</script>
<aside class="right-side">
    <section class="content-header">
        <ol class="breadcrumb">
            <li><a href="<?php echo base_url('index.php/basis/home_c/'); ?>"><span>Home</span></a></li>
            <li><a href=""><strong>Samanta Transaction</strong></a></li>
        </ol>
    </section>

    <section class="content">
        <div class="row">
            <div class="col-md-12">
                <div class="grid">
                    <div class="grid-header">
                        <i class="fa fa-laptop"></i>
                        <span class="grid-title"><strong>SAMANTA TRANSACTION</strong></span>
                        <div class="pull-right">
                            <button class="btn btn-default" data-toggle="modal" data-target="#modal_add_sparepart" data-placement="left" title="Add Sparepart" <?php if ($set == '0') { echo "disabled"; } ?> style="height:30px;font-size:13px;width:120px;">Add Spare Parts</a>
                        </div>
                    </div>

                    <div class="grid-body">
                        <input type='hidden' value='<?php echo $set; ?>' name='set' />
                        <table width="80%" class="filter" border="0px">
                            <tr>
                                <td>Date</td>
                                <td>:</td>
                                <td>
                                    <input type="text" onchange="changeDate()" class="ddl" id="datepicker" placeholder="DD/MM/YYYY" value="<?php echo $date; ?>" <?php
                                    if ($set == 1) {
                                        echo 'disabled="yes"';
                                    } else {
                                        echo '';
                                    }
                                    ?>> <input type="submit" style="height:30px;width:70px;background:#428bca;border:none;color:white;" name="send" value="<?php
                                           if ($set == 1) {
                                               echo 'Un-Set';
                                           } else {
                                               echo 'Set';
                                           }
                                           ?>" id="submit" class="<?php
                                           if ($set == 1) {
                                               echo 'active';
                                           } else {
                                               echo 'button';
                                           }
                                           ?>" onClick="getLocation()">
                                </td>
                            </tr>
                            <tr>
                                <td>Warehouse</td>
                                <td>:</td>
                                <td>
                                    <select id="opt_sloc" style="width:150px" class="ddl" onChange="document.location.href = this.options[this.selectedIndex].value;" >
                                        <?php
                                        foreach ($w_sloc as $sloc):
                                            $sloc_choose = trim($sloc->CHR_SLOC);
                                            ?>
                                            <option value="<? echo site_url('samanta/spare_parts_trans_c/form/' . $date_l . '/' . $sloc_choose . '/' . $set); ?>" <?php
                                            if ($sloc2 == $sloc_choose) {
                                                echo 'SELECTED';
                                            }
                                            ?>><?php if (trim($sloc_choose) == 'MT01') { echo "DIES/MOLD MTE"; } 
                                            elseif (trim($sloc_choose) == 'MT02') { echo "DOOR FRAME MTE"; } 
                                            elseif (trim($sloc_choose) == 'MT03') { echo "MACHINE MTE"; }  
                                            elseif (trim($sloc_choose) == 'IT01') { echo "MIS"; } 
                                            elseif (trim($sloc_choose) == 'MS01') { echo "MSU"; } 
                                            elseif (trim($sloc_choose) == 'WH30') { echo "CONSUMABLE"; }
                                            elseif (trim($sloc_choose) == 'EN02') { echo "ENGINEERING"; }?></option>
                                                <?php endforeach; ?>
                                    </select>
                                </td>
                            </tr>                            
                        </table>
                    </div>
                    <div class="grid-body">
                        <div class="pull-right">
                        </div>
                        <table  width="100%" border="0px">
                            <tr>
                                <!-- <td >
                                    <button class="btn btn-danger" data-toggle="modal" data-target="#modalDefault" data-placement="left" data-toggle="tooltip" title="Add Part" style="display:block;"><span class="fa fa-plus"></span> &nbsp;&nbsp; Add Part</button>
                                </td> -->
                            <form action="" method="POST" onSubmit="return confirmAction()">
                                <td width="90%">
                                    <button type="submit" name="btn_save" value="Update All" id="submit_save" class="btn btn-success" <?php if ($set == '0') { echo "disabled"; } ?>><span class="fa fa-save"></span>&nbsp;&nbsp;Save All</button>
                                </td>
                                <td>
                                    <input id="search_spec" class="ddl" type="text" name="name" placeholder="Search Spec" autocomplete="off">
                                </td>
                                </tr>
                        </table>
                        <br>
                        <table class="table table-condensed table-bordered table-striped table-hover display" id="list_data">
                            <thead>
                                <tr>
                                    <th width="10px" style="text-align:center;vertical-align:middle">No</th>
                                    <th width="180px" style="text-align:center;vertical-align:middle">Spare Part No</th>
                                    <th width="150px" style="text-align:center;vertical-align:middle">Address</th>
                                    <th width="500px" style="vertical-align:middle">Spare Part Name & Specification</th>
                                    <th width="150px" style="text-align:center;vertical-align:middle">Transaction Type</th>
                                    <th width="150px" style="text-align:center;vertical-align:middle">Used By</th>
                                    <th width="150px" style="text-align:center;vertical-align:middle">Scan By</th>
                                    <th width="150px" style="text-align:center;vertical-align:middle">Time Scan</th>
                                    <th width="60px" style="text-align:center;vertical-align:middle">Qty</th>
                                </tr>
                            </thead>

                            <tbody> 
                            <?php $i = 1;
                                foreach ($parts as $part){
                                echo "<tr>";
                                    echo "<td style='text-align:center'>$i</td>";
                                    ?>
                                    <input type="hidden" name="int_id[<?php echo $i; ?>]" value="<?php echo $part->INT_ID; ?>" />
                                    <input type="hidden" name="part_number[<?php echo $i; ?>]" value="<?php echo $part->CHR_PART_NO; ?>" />
                                    <input type="hidden" name="rack_number[<?php echo $i; ?>]" value="<?php echo $part->CHR_RACK_NO; ?>" /> 
                                    <?php
                                    echo "<td class='part_number' style='text-align:center'>$part->CHR_PART_NO</td>";
                                    echo "<td class='rack_number' style='text-align:center'>$part->CHR_RACK_NO</td>";
                                    echo "<td class='spec'>$part->CHR_SPARE_PART_NAME - <strong>$part->CHR_SPECIFICATION</strong></td>";
                                    echo "<td style='text-align:center'>$part->CHR_TYPE_TRANS</td>";
                                    echo "<td style='text-align:center'>$part->CHR_LOCATION_TO</td>";
                                    echo "<td style='text-align:center'>$part->CHR_ENTRIED_BY</td>";
                                    echo "<td style='text-align:center'>". date('H:i:s', strtotime($part->CHR_ENTRIED_TIME)) ."</td>"; ?>
                                    <td><input autocomplete="off" data-toggle="tooltip" title="OK"  onfocus="if (this.value == '0') { 
                                                this.value = '';
                                                this.style.outline = 'none';
                                                var thisRow = document.getElementById('thisRow');
                                                thisRow.style.backgroundColor = '#44D7A8';
                                                this.style.backgroundColor = '#44D7A8';

                                            }" 
                                            onblur="if (this.value == '') {
                                                        this.value = '0';
                                                        this.style.backgroundColor = '#7FFFD4';
                                                    }" onkeypress="return isNumberKey(event)" 
                                                    onKeyUp="findTotalOK(<?php echo $i; ?>)" 
                                                    style="text-align:right;padding-right:0px;width:60px;background: #7FFFD4;font-weight:bold;" 
                                                    type="text" 
                                                    size="1" 
                                                    class="decimalFormat" step="0.1" 
                                                    name="qty_ok[<?php echo $i; ?>]" 
                                                    value="<?php echo number_format($part->INT_QTY, 0, ',', '.'); ?>" <?php
                                            if ($set == '0') {
                                                echo "disabled='yes'";
                                            } ?> >
                                    </td>
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
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                        <h4 class="modal-title" id="modalprogress"><strong>Add Spare Parts</strong></h4>
                        <input type="hidden" name="sloc" id="sloc">
                        <input type="hidden" name="tgl" id="tgl">
                </div>
                <div class="modal-body">
                    <div class="col-sm-6 col-lg-6">
                            <div class="form-group ui-front">
                                <label class="col-sm-3 control-label">Spare Part</label>
                                <div class="col-sm-9">
                                    <!-- <select name="spare_part" class="form-control" id="spare_part" required>
                                        <?php
                                            foreach ($full_parts as $parts):
                                                ?>
                                                <option value="<?php echo "$parts->CHR_PART_NO-$parts->CHR_SPECIFICATION+$parts->CHR_SPARE_PART_NAME"; ?>"><?php echo "$parts->CHR_PART_NO - <strong>$parts->CHR_SPECIFICATION</strong>" ?></option>
                                        <?php endforeach; ?>
                                    </select> -->
                                   <input  class="form-control" name="sparepart" id="idsparepart" type="text"/>
                                   <input  class="form-control" name="nopart" id="nopart" type="hidden"/>
                                   <input  class="form-control" name="spek" id="speksp" type="hidden"/>
                                   <input  class="form-control" name="namasp" id="namasp" type="hidden"/>
                                   <input  class="form-control" name="compsp" id="compsp" type="hidden"/>
                                   <input  class="form-control" name="pricesp" id="pricesp" type="hidden"/>
                                </div>
                            </div>
                            <br/><br/>
                            <div class="form-group">
                                <label class="col-sm-3 control-label">Quantity</label>
                                <div class="col-sm-9">
                                    <input class="form-control" name="quantity" id="quantity" type="text" autocomplete="off" onkeypress="return isNumberKey(event)" required/>
                                </div>
                            </div>
                            <br/><br/>
                            <div class="form-group">
                                 <div class="col-sm-5">
                                    <button type="button" class="btn btn-primary" data-placement="left" data-toggle="tooltip" title="Add this data" onclick="addtempsparepart()" id="add_temp_spare_part"><i class="fa fa-check"></i>Add</button>
                                </div>
                            </div>
                    </div>
                    <div class="col-sm-6 col-lg-6" id="tb_temp_spare_part" style="display: none;">
                      <form method="POST" action="<?php echo base_url() ?>index.php/samanta/spare_parts_trans_c/save_all_spare_part" onSubmit="return confirmAction()">
                        <table id="tableTempSparepart"  class="table table-striped table-condensed table-hover display" cellspacing="0" width="100%">
                            <thead>
                                <tr>
                                    <th>Spare Part</th>
                                    <th>Quantity</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody id="tr_temp_spare_part">
                                
                            </tbody>
                        </table>
                        <div><button style="display: none;" type="submit" name="btn_save_temp_spare_part" value="Save All" data-placement="left" data-toggle="tooltip" title="Save all data in table" id="btn_save_temp_spare_part" onSubmit="return confirmAction()" class="btn btn-success" ><span class="fa fa-save"></span>&nbsp;&nbsp;Save All</button></div>
                    </div>   
                    
                </div>
                <div class="modal-footer" style="border-top: none" >
                    
                </div>
                </form>
            </div>
        </div>
    </div>
</div>
<!-- <div class="modal fade" id="modal_add_sparepart" tabindex="-1" role="dialog" aria-labelledby="modalprogress" aria-hidden="true" style="display: none;">
    <div class="modal-wrapper" style="width: 900px;">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                        <h4 class="modal-title" id="modalprogress"><strong>Add Spare Parts</strong></h4>
                </div>
                <div class="modal-body">
                    <form class="form-horizontal" id="form_add_sparepart" >
                        <div class="form-group">
                            <label class="col-sm-3 control-label">Spare Part</label>
                            <div class="col-sm-5">
                                
                                <input  class="form-control" name="sparepart" id="idsparepart" type="text"/>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-3 control-label">Quantity</label>
                            <div class="col-sm-5">
                                <input class="form-control" name="quantity" id="quantity" type="text" autocomplete="off" onkeypress="return isNumberKey(event)" required/>
                            </div>
                        </div>
                        <div class="form-group">
                             <div class="col-sm-5">
                                <button type="button" class="btn btn-primary" data-placement="left" data-toggle="tooltip" title="Add this data" onclick="addtempsparepart()" id="add_temp_spare_part"><i class="fa fa-check"></i>Add</button>
                            </div>
                        </div>
                    </form>                                        
                </div>
                <div class="modal-footer">
                     <div  id="temp_spare_part_table" style="display:none;">
                            <form method="POST" action="<?php echo base_url() ?>index.php/samanta/spare_parts_trans_c/save_all_spare_part">
                            <table  width="100%" border="0px">
                                <tr>
                                    <td width="90%">
                                        <button type="submit" name="btn_save_temp_spare_part" value="Save All" id="btn_save_temp_spare_part" class="btn btn-success"  onSubmit="return confirmAction()"><span class="fa fa-save"></span>&nbsp;&nbsp;Save All</button>
                                    </td>
                                    </tr>

                            </table>
                            <br/>
                            <table id="tb_temp_spare_part" class="table table-striped table-condensed table-hover display" cellspacing="0" width="100%">
                                <thead>
                                    <tr>
                                        <th>Spare Part</th>
                                        <th>Quantity</th>
                                        <th>Sloc</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody id="tr_temp_spare_part">
                                    
                                </tbody>
                            </table>
                            </form>
                     </div>
                </div>
            </div>
        </div>
    </div>
</div> -->



<script type="text/javascript">
    function clearBoxPartNo() {
        document.getElementById("search_part_number").value = "";
        document.getElementById("search_part_number").disabled = false;
        document.getElementById("search_rack_number").value = "";
        document.getElementById("search_rack_number").disabled = true;
        document.getElementById("search_spec").value = "";
        document.getElementById("search_spec").disabled = true;
        $("#list_data tr td.part_number").parent().show();
    }

    function clearBoxRackNo() {
        document.getElementById("search_part_number").value = "";
        document.getElementById("search_part_number").disabled = false;
        document.getElementById("search_rack_number").value = "";
        document.getElementById("search_rack_number").disabled = true;
        document.getElementById("search_spec").value = "";
        document.getElementById("search_spec").disabled = true;
        $("#list_data tr td.rack_number").parent().show();
    }

    function clearBoxPartName() {
        document.getElementById("search_part_number").value = "";
        document.getElementById("search_part_number").disabled = false;
        document.getElementById("search_rack_number").value = "";
        document.getElementById("search_rack_number").disabled = true;
        document.getElementById("search_spec").value = "";
        document.getElementById("search_spec").disabled = true;
        $("#list_data tr td.spec").parent().show();
    }

    function showAll() {
        document.getElementById("search_part_number").value = "";
        document.getElementById("search_rack_number").value = "";
        document.getElementById("search_spec").value = "";
        $("#list_data tr td.spec").parent().show();
    }
    
    function changeDate() {
        var t = document.getElementById('opt_sloc');
        var date_t = document.getElementById('datepicker').value;
        var date_fix = date_t.substr(6, 4) + date_t.substr(3, 2) + date_t.substr(0, 2)
        location.href = '<?php echo site_url() ?>/samanta/spare_parts_trans_c/form/' + date_fix + '/' + t.options[t.selectedIndex].text + '/0'
    }

    function getLocation() {
        var t = document.getElementById('opt_sloc'); 
        var date_t = document.getElementById('datepicker').value;
        var date_fix = date_t.substr(6, 4) + date_t.substr(3, 2) + date_t.substr(0, 2)
        if (<?php echo $set ?> == 0)
        {
            location.href = '<?php echo site_url() ?>/samanta/spare_parts_trans_c/form/' + date_fix + '/' + t.options[t.selectedIndex].text + '/1'
        } else
        {
            location.href = '<?php echo site_url() ?>/samanta/spare_parts_trans_c/form/' + date_fix + '/' + t.options[t.selectedIndex].text + '/0'
        }
    }

    function confirmAction() {

        if (document.getElementById("datepicker").disabled === false) {
            alert('Maaf, anda belum set tanggal');
            return false;
        } else {
            return confirm("Anda yakin untuk menyimpan data?");
        }
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

<script>
     var x = 0;
     var inum = 1;
     function removeRowTempSparePart(rowid){
        var row = document.getElementById(rowid);
        row.parentNode.removeChild(row);
           
        // var table = $('#modal_add_sparepart #tb_temp_spare_part').DataTable();      
        // var rows = document.getElementById(rowid);
        // table
        // .row($(_this).parents('tr'))
        // .remove()
        // .draw(false);
        inum--;
        if(inum==1)
        {
            document.getElementById('tb_temp_spare_part').style.display = 'none';
            document.getElementById('btn_save_temp_spare_part').style.display = 'none';
        }
      }
      
     function addtempsparepart()
     {
        var quantity = $("#modal_add_sparepart #quantity").val();
        if(quantity!=0 && quantity!='')
        {
            
            document.getElementById('tb_temp_spare_part').style.display = 'block';
            document.getElementById('btn_save_temp_spare_part').style.display = 'block';
            // alert('');
            // $("#modal_add_sparepart #nopart").val()
            var sparepart_partno =  document.getElementById('nopart').value;
            var sparepart_spek = $("#modal_add_sparepart #speksp").val();
            var sparepart_nama = $("#modal_add_sparepart #namasp").val();
            var comp =document.getElementById('compsp').value;
            var price =document.getElementById('pricesp').value;
            var t = document.getElementById('opt_sloc'); 
            var date_t = document.getElementById('datepicker').value;
            var date_fix = date_t.substr(6, 4) + date_t.substr(3, 2) + date_t.substr(0, 2)
            var location = t.options[t.selectedIndex].text;

            var i;
            var sama=0;
            var myTab = document.getElementById('tableTempSparepart').rows.length;
            //alert(myTab);
            for(i= 1;i<myTab;i++)
            {
                var index=parseInt(i)-1;
                var partno = document.getElementsByName('sparepart_val_no[]')[index].value;
                //alert(partno);
                var spek = document.getElementsByName('sparepart_val_spek[]')[index].value;
                var jumlah = document.getElementsByName('quantity[]')[index].value;
                if(partno==sparepart_partno && sparepart_spek==spek)
                {
                    
                    jumlah=parseInt(jumlah)+parseInt(quantity);
                    document.getElementsByName('quantity[]')[index].value = jumlah;
                    var tableObj = document.getElementById('tableTempSparepart');
                    
                    var myRow = tableObj.rows.item(i).cells;
                    myRow.item(1).innerHTML = jumlah;
                    sama=1;
                }
                
            }
            // myTab dimulai 1
            if(sama==0)
            {
                x++;
                inum++;
                $('#tr_temp_spare_part').append('<tr class="gradeX" id="row'+x+'">'+ '<td class="spare_name">' + sparepart_partno + ' - ' + sparepart_spek +'<input type="text" style="display:none;" id="partno'+x+'" name="sparepart_val_no[]" value="'+sparepart_partno+'">'+'<input type="text" style="display:none;" id="spek'+x+'" name="sparepart_val_spek[]" value="'+sparepart_spek+'">'+'<input type="text" style="display:none;" name="sparepart_val_name[]" value="'+sparepart_nama+'">' +'</td><td>' + quantity  +'</td>'+'<td>'+ '<input type="text" style="display:none;" name="quantity[]" id="jumlah'+x+'" value="'+quantity+'">'+'<input type="text" style="display:none;" name="sparepart_val_comp[]" value="'+comp+'">'+'<input type="text" style="display:none;" name="sparepart_val_price[]" value="'+price+'">'+'<input type="text" style="display:none;" name="date[]" value="'+date_fix+'">'+'<input type="text" style="display:none;" name="location[]" value="'+location+'"><a href="#temp_part" class="label label-danger" onclick="removeRowTempSparePart(\'row'+x+'\',this)"><span class="fa fa-times"></span></a></td></tr>');
            }
                

            document.getElementById('nopart').value ='';
            document.getElementById('speksp').value ='';
            document.getElementById('namasp').value ='';
            document.getElementById('quantity').value ='';
            document.getElementById('idsparepart').value ='';
            document.getElementById('compsp').value ='';
            document.getElementById('pricesp').value ='';
            // alert('');
            
            // var table = $('#modal_add_sparepart #tb_temp_spare_part').DataTable();                
            //     var newValue = ['<tr class="gradeX" id="row'+x+'"><input type="text" style="display:none;" name="sparepart_val_name[]" value="'+sparepart_nama+'">'+ '<td class="spare_name">' + sparepart_partno + ' - ' + sparepart_spek +'<input type="text" style="display:none;" name="sparepart_val_no[]" value="'+sparepart_partno+'"><input type="text" style="display:none;" name="sparepart_val_spek[]" value="'+sparepart_spek+'">' +'</td>', '<td>' + quantity + '<input type="text" style="display:none;" name="quantity[]" value="'+quantity+'">' + '<input type="text" style="display:none;" name="date[]" value="'+date_fix+'">' +'</td>','<td>' 
            //         + location + '<input type="text" style="display:none;" name="location[]" value="'+location+'">' +'</td>', '<td><a href="#temp_part" class="label label-danger" onclick="removeRowTempSparePart(\'row'+x+'\',this)"><span class="fa fa-times"></span></a></td></tr>'];
           
            // table.row.add(newValue).draw(false);
            //}
        
            }
        else
        {
            alert("Quantity Must Be More Than Zero!");
        }
        
         
        
         /*$('#modal_add_sparepart #tr_temp_spare_part').after('<tr class="gradeX" id="row'+x+'"><td>'+ inum +'<input type="text" style="display:none;" name="sparepart_val_name[]" value="'+sparepart_val_name+'">' +'</td><td>' + sparepart_val_no + ' - ' + sparepart_val_spec +'<input type="text" style="display:none;" name="sparepart_val_no[]" value="'+sparepart_val_no+'">' +'</td><td>' + quantity + '<input type="text" style="display:none;" name="quantity[]" value="'+quantity+'">' +'</td><td>' 
         + location + '<input type="text" style="display:none;" name="location[]" value="'+location+'">' +'</td><td><a href="#temp_part" class="label label-danger" onclick="removeRowTempSparePart(\'row'+x+'\')"><span class="fa fa-times"></span></a></td></tr>');*/

        //document.getElementById("pendidikanFormalModal").reset();
     }
  </script>