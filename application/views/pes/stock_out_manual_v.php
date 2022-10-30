<?php
//var_dump ("reza",validation_errors());
?>
<script type="text/javascript" src="<?php echo base_url(); ?>assets/js/tablemaster.js" >
</script>
<aside class="right-side">

    <section class="content-header">
        <ol class="breadcrumb">
            <li><a href="<?php echo base_url('index.php/basis/home_c/'); ?>"><span>Home</span></a></li>
            <li><a href=""><strong>Stock Out Manual</strong></a></li>
        </ol>
    </section>

    <section class="content">
        <div class="row">
            <div class="col-md-12">
                <div class="grid">
                    <div class="grid-header">
                        <i class="fa fa-wrench"></i>
                        <span class="grid-title"><strong>STOCK</strong> OUT MANUAL</span>        
                    </div>
                    <div class="grid-body" >                    	   
                        <div style="width:100%">
                            <form method="POST" id="stockManual" action="<?= base_url() ?>index.php/pes/stock_out_manual_c/save_stock">
                                <table width="100%" class="table table-bordered">
                                    <tr>
                                        <td align="left">
                                            <input type="button" id="add" value="Add New Row" onClick="addRowStock('dataTables')" /> 
                                            <input type="button" id="del" value="Delete New Row" onClick="deleteRowStock('dataTables')" />
                                            <input name="btn_save" id="simpan" type="button" value="Save" />
                                            <!-- <input name="btn_reset" id="reset" type="reset" value="Reset" /> -->
                                        </td>
                                    </tr>
                                </table>

                                <table id="dataTables" width="100%" border="1">
                                    <thead>
                                        <tr>
                                            <th></th>
                                        <!-- <th>No</th> -->
                                            <th style="text-align:center !important">Back Number</th>
                                            <th style="text-align:center !important">Part Number</th>
                                            <th style="text-align:center !important">Part Name</th>
                                            <th style="text-align:center !important">Quantity</th>
                                            <th style="text-align:center !important">UoM</th>
                                            <th style="text-align:center !important">Location To</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php /* ?><?php $i=1;foreach( $parts as $part):?><?php */ ?>
                                        <tr>
                                            <td align="center" ><input type="checkbox" name="chk[]" id="ckbx"/></td>
                                        <!-- <td align="center"><label id="tx_no" value=""></label></td> -->
                                            <td><input type="text" maxlength="6" required="required" class="form-control" id="backno"  name="BACK_NO[]" width="100%" onchange="cekParts(this.value)"></td>
                                            <td><input type="text" readonly="readonly" required="required" class="form-control"  name="PART_NO[]" width="100%" ></td>
                                            <td><input type="text" readonly="readonly" required="required" class="form-control"  name="PART_NAME[]" width="100%" ></td>                          	
                                            <td><input type="text" maxlength="5" required="required" class="form-control"  name="QTY[]" width="100%" onkeypress='return validateQty(event);'></td>
                                            <td><input type="text" readonly="readonly" required="required" class="form-control"  name="UOM[]" width="100%" ></td>
                                                <!-- <td><?php
                                            $attributes = 'class = "form-control" id = "sloc" name="LOCATION[]"';
                                            echo form_dropdown('location', $sloc, set_value('LOCATION', $sloc[0]), $attributes);
                                            ?></td> -->
                                            <!--<td><input type="text" required="required" class="form-control"  name="LOCATION[]" width="100%"></td>-->	
                                            <td>
                                                <select class="form-control" id ="LOCATION" name="LOCATION[]" >
													<option value=""></option>
                                                    <?php foreach ($sloc as $loc): ?>
                                                        <option  value="<?php echo $loc->CHR_SLOC; ?>"><?php echo ucfirst($loc->CHR_SLOC); ?></option>
<?php endforeach; ?>
                                                </select>
                                            </td>
											
                                        </tr>
<?php /* ?><?php $i++;endforeach;?>   <?php */ ?>                       	
                                    <span ><?php echo validation_errors(); ?></span>
                                    </tbody>
                                </table>
                            </form>
                        </div>
                    </div>                                                      
                </div>
            </div>
        </div>

    </section>
</aside>
<script type="text/javascript">
    $(document).ready(function() {
        $('#simpan').click(function() {
            $('#simpan').hide();
            $.ajax({
                type: 'POST',
                url: '<?= base_url() ?>index.php/pes/stock_out_manual_c/save_stock',
                dataType: 'json',
                data: $('#stockManual').serialize(),
                success: function(data) {
                    // alert(data)
                    console.log(data);
                    if (data == true) {
                        // location.reload();
                        alert("Data telah tersimpan");
                        location.href = "<?php echo site_url() ?>/pes/stock_out_manual_c";
                    }
                    else if (data == 3) {
                        alert("Data Tidak Lengkap");
                        $('#simpan').show();
                    }
                    else {
                        alert("Data Back Number yang anda masukkan tidak boleh sama");
                        $('#simpan').show();
                        // location.href="<?php echo site_url() ?>/pes/stock_out_manual_c";
                    }
                }
            });
        });

    });
    function addRowStock(tableID) {
        var table = document.getElementById(tableID);
        var rowCount = table.rows.length;
        var newinput = rowCount - 1;

        var row = table.insertRow(rowCount);
        var colCount = table.rows[0].cells.length;
        for (var i = 0; i < colCount; i++) {
            // document.getElementById('tx_no').label = i;
            var newcell = row.insertCell(i);
            newcell.innerHTML = table.rows[newinput].cells[i].innerHTML;

        }

    }
    function deleteRowStock(tableID) {
        var table = document.getElementById(tableID);
        var rowCount = table.rows.length;
        var totLine = 2;
        for (var i = 0; i < rowCount; i++) {
            var row = table.rows[i];
            var chkbox = row.cells[0].childNodes[0];
            if (null != chkbox && true == chkbox.checked) {
                if (rowCount <= totLine) { 						// limit the user from removing all the fields
                    alert("Row tidak bisa dihapus semua.");
                    break;
                }
                table.deleteRow(i);
                rowCount--;
                i--;
            }
        }
    }
    function cekParts(val) {
        var backNo = document.getElementsByName('BACK_NO[]');
        var lines = backNo.length;

        var partNo = document.getElementsByName('PART_NO[]');
        var partName = document.getElementsByName('PART_NAME[]');
        var UoM = document.getElementsByName('UOM[]');
        for (var i = 0; i < lines; ) {
            if (backNo[i].value) {
                var pNo = '';
                var pName = '';
                var measurement = '';
                var a = backNo[i].value;

                $.ajax({
                    async: false,
                    type: 'POST',
                    url: '<?= base_url() ?>index.php/pes/stock_out_manual_c/get_data',
                    dataType: 'json',
                    data: {id: a},
                    success: function(data) {
                        console.log(data);
                        pNo = data[0]['CHR_PART_NO'];
                        pName = data[0]['CHR_PART_NAME'];
                        measurement = data[0]['CHR_PART_UOM'];
                    }
                });
                partNo[i].value = pNo;
                partName[i].value = pName;
                UoM[i].value = measurement;
            }
            i++
        }
        return;

    }
    function pausecomp(millis)
    {
        var date = new Date();
        var curDate = null;

        do {
            curDate = new Date();
        }
        while (curDate - date < millis);
    }
    function validateQty(event) {
        var key = window.event ? event.keyCode : event.which;

        if (event.keyCode == 8 || event.keyCode == 46
                || event.keyCode == 37 || event.keyCode == 39) {
            return true;
        }
        else if (key < 48 || key > 57) {
            return false;
        }
        else
            return true;
    }
    ;
</script>