<?php
session_start();
?>
<script type="text/javascript">
$(document).ready(function () {
$(window).keydown(function(event){
        if(event.keyCode == 13) {
          event.preventDefault();
          return false;
        }
      });
    $("#backno").attr("readonly", false); 
    $("#quantity").attr("readonly", false);
    document.getElementById('backno').focus();

    $("#simpan").click(function () { 
        $("#backno").attr("readonly", true); 
        $("#quantity").attr("readonly", true);
    });
    $("#backno").focusout(function() {
    var backno = $("#backno").val();
    var backnol =backno.length;
    if (backnol>0) {
        $.ajax({
                url: '<?= base_url() ?>index.php/pes/return_material_c/getUom',
                data: {backno: $('#backno').val()},type: 'POST',
                success: function(data) {
                    $("#uom").val(data);
                }
        });
    };
        
    });

    
});
// end document ready
$(document).ready(function() {
// autocomplete
$('#backno').autocomplete({
    source: "<?php echo site_url('pes/return_material_c/search'); ?>",
    minLength:1 ,
});
}); //end document ready
</script>
<aside class="right-side">

    <section class="content-header">
        <ol class="breadcrumb">
            <li><a href="<?php echo base_url('index.php/basis/home_c/'); ?>"><span>Home</span></a></li>
            <li><a href="<?php echo base_url('index.php/pes/prodentry_c/'); ?>">Stock Transfer System</a></li>
            <li><a href="<?php echo base_url('index.php/pes/return_material_c/'); ?>">Stock Transfer Execution</a></li>
            <li><a href=""><strong>Stock Transfer</strong></a></li>
        </ol>
    </section>

    <section class="content">
        <div class="row">
            <div class="col-md-12 text-center">
                <div class="grid">
                    <div class="grid-header">
                        <div class="panel panel-default">
                            <div class="panel-heading">SELAMAT DATANG SILAHKAN MASUKKAN BARANG YANG INGIN ANDA KEMBALIKAN</div>
                        </div>
                    </div>
                    <div class="clearfix"></div>
                        <?php if($this->session->flashdata('message')<>''): ?>
                            <div class="alert alert-warning alert-dismissible" role="alert">
                            <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                                <?php echo $this->session->flashdata('message');?>
                            </div>
                            <br/>
                        <?php endif;?>
                    <div class="grid-body">
                        <div class="col-sm-12" style="width:100%; float: center">
                            <div class="row">
                                <div class="col-sm-2 col-sm-offset-10 box">
                                    <form method="post" action="<?= base_url() ?>index.php/pes/return_material_c/printData" onclick="return validatePrint()">
                                        <input type="submit" name="print" id="print" value="PRINT" style="background-color:#66ccff;width:100px;height:30px;font-color:#000000;font-weight:bold"> 
                                    
                                    </form>
                                </div>
                            </div>
                            <div class="row" style="margin-bottom:30px">
                            
                            <form id="test1" method="post" action="<?= base_url() ?>index.php/pes/return_material_c/addData/">
                                <div class="col-sm-2" style="width:auto">
                                    <label>From Location :</label>
                                </div>
                                <div class="col-sm-2">
                                    <input type="text" id="pilihloc" name="pilihloc" value="<?echo $pilih?>" readonly="readonly">
                                </div> <br><br>
                             
                                <div class="col-sm-2" style="width:auto">
                                    <input autocomplete="off" type="text" id="backno" name="backno" maxlength="6" style="width:150px" placeholder="Back No" autofocus="autofocus" readonly="readonly">
                                </div>
                                <div class="col-sm-2" style="width:auto">
                                    <input autocomplete="off" type="text" id="quantity" name="quantity" placeholder="Quantity" onkeypress="validate(event)" style="width:150px" readonly="readonly">
                                </div>
                                <div class="col-sm-2" style="width:auto">
                                    <input autocomplete="off" type="text" id="uom" name="uom" placeholder="UOM" style="width:50px;background-color:#f0f0f5;font-weight:bold;text-align:center" readonly="readonly">
                                </div>
                                <div class="col-sm-2">
                                    <input type="submit" id="add" name="add" value="Add Data" style="background-color:#66ccff;width:100px;height:30px;font-color:#000000;font-weight:bold" onclick="return validateAdd()">
                                </div>
                            </form>
                            <form method="post" action="<?= base_url() ?>index.php/pes/return_material_c/deleteData" onsubmit="return validateForm()">
                                <div class="col-sm-2" style="width:auto;margin-left:130px">
                                    <input type="submit" id="cancel" name="cancel" value="CANCEL" style="background-color:#66ccff;width:100px;height:30px;font-color:#000000;font-weight:bold" >
                                </div>
                                <input type="hidden" id="pr" name="pr" value="<?php echo $print; ?>"/>
                                <input type="hidden" id="save" name="pr" value="<?php echo $save; ?>"/>
                            </form>
                            <form method="post" action="<?= base_url() ?>index.php/pes/return_material_c/saveData">
                                <div class="col-sm-2" style="width:auto">
                                    <button type="btn" value="SAVE" name="simpan" id="simpan" style="background-color:#66ccff;width:100px;height:30px;font-color:#000000;font-weight:bold" onclick="return validateSave()" >SAVE</button>
                                    <input type="hidden" id="cekprint" name="cekprint" value="<?php echo $cekprint; ?>"/>
                                </div>
                            </div>

                            <div class="row">
                                    <p style="text-align:center"><strong>Barang yang anda kembalikan</strong></p>  
                            </div>
                        </div>
                        
                        <div class="table-content">
                        <!-- begin table content -->
                            <div style="width:100%;margin-left: auto;margin-right: auto;margin-top: 5px;border">
                            <table class="table table-bordered" name="dataTable" cellspacing="0" width="100%">
                            <thead>
                                <tr>    
                                    <th style="width:30px;text-align:center;">No</th>
                                    <th style="width:100px;text-align:center;">Back Number</th>
                                    <th style="width:100px;text-align:center;">Part Number</th>
                                    <th style="width:200px;text-align:center;">Part Name</th>
                                    <th style="width:30px;text-align:center;">Quantity</th>
                                    <th style="width:30px;text-align:center;">UOM</th>
                                </tr>
                            </thead> 
                            <tbody>
                                <?php $i=1;foreach( $alldata as $all):?>                                    
                                    <tr>
                                    <td><input style="width:30px;text-align:center;background-color:#f0f0f5;" type="text" name="no[]" id="no[]" value="<?php echo $all->no;?>" readonly="readonly"></td>
                                    <td><input style="width:80px;text-align:center;background-color:#f0f0f5;" type="text" name="bno[]" id="bno[]" value="<?php echo $all->CHR_BACK_NO;?>" readonly="readonly"></td>
                                    <td><input style="width:100px;text-align:center;background-color:#f0f0f5;" type="text" name="pno[]" id="pno[]" value="<?php echo $all->CHR_PART_NO;?>" readonly="readonly"></td>
                                    <td><input style="width:350px;text-align:center;background-color:#f0f0f5;" type="text" name="pna[]" id="pna[]" value="<?php echo $all->CHR_PART_NAME;?>" readonly="readonly"></td>
                                    <td><input style="text-align:center;background-color:#f0f0f5;" type="text" name="qtyperbox[]" id="qtyperbox[]" value="<?php echo $all->INT_QTY_PER_BOX;?>" onkeypress="validate(event)" readonly="readonly" ></td>
                                    <td><input style="width:30px;text-align:center;background-color:#f0f0f5;" type="text" name="uom1[]" id="uom1[]" value="<?php echo $all->CHR_PART_UOM;?>" readonly="readonly"></td>
                                    </tr>
                                <?php $i++;endforeach;?>
                            </tbody>
                            </table>
                            </div>
                        </div>    
                        <!-- end class table-content -->
                        </form>
                    </div>
                    
                </div>
                
            </div>
        </div>
    </section>
</aside>

<script>
        function validateForm() {
            var status = false;
            var cekprint = document.getElementById('cekprint').value;
            var print = document.getElementById('pr').value;
            var save = document.getElementById('save').value;
            if(print == 'x' && save == 'x'){
                status = true;
                
            }else if (save=='n') {
                status = true;
            }else if(cekprint=='n'){
                status = false;
                alert("Harap diprint terlebih dahulu");
            }else if (save=='z') {
                status =true;
            }else if (cekprint=='') {
                status = false;
                alert("Tidak ada data. Silahkan masukkan data terlebih dahulu");
            }else{
                status = false;
                alert("Silahkan print kanban terlebih dahulu");
            }

            return status;

        }
        function validateAdd() {
            var status = true;
            var backno = document.getElementById('backno').value;
            var quantity = document.getElementById('quantity').value;

            if (backno=="" && quantity=="" ) {
                status = false;
                alert("Harap masukkan back no");
            }
            else if (backno=="") {
                status = false;
                alert("Harap masukkan back no");
            }else if (quantity==""){
                status = false;
                alert("Harap masukkan quantity");

            }
            return status
        }

        function validatePrint() {
            var status = false;
            var cekprint = document.getElementById('cekprint').value;
            if(cekprint=='n'){
                status = false;
                alert("Tidak ada data. Silahkan masukkan data terlebih dahulu");
            }else if (print=='z') {
                status = false;
                alert("Tidak ada data. Silahkan simpan data terlebih dahulu");
            }
            else if (cekprint=='') {
                status = false;
                alert("Tidak ada data. Silahkan masukkan data terlebih dahulu");
            }
            else if (cekprint=='o') {
                status = false;
                alert("Harap data disimpan terlebih dahulu");
            }
            else if(cekprint=='y'){
                window.location.href = "<?= base_url() ?>index.php/pes/return_material_c/printData";
            }

            return status;

        }
        function validateSave() {
            var status =false;
            var cekprint = document.getElementById('cekprint').value;
            var qty=document.getElementById('qtyperbox').value;

            if (cekprint=='') {
                status = false;
                alert("Tidak ada data. Silahkan masukkan data terlebih dahulu");
            }else if(qty==''){
                status = false;
                alert("Harap isi quantity");
            }else {
                status=true;
            }

            return status;

        }

        function validate(evt) {
            if(evt.keyCode!=8) {
                var theEvent = evt || window.event;
                var key      = theEvent.keyCode || theEvent.which;
                    key      = String.fromCharCode( key );
                var regex    = /[0-9]|\./;

            if( !regex.test(key) ){
                theEvent.returnValue = false;
                if(theEvent.preventDefault) theEvent.preventDefault();
                }
            }
            }

</script>