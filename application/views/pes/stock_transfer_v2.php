<?php
session_start();
?>
<script type="text/javascript">
$(document).ready(function () {
    $("#pilih").change(function () {
        var x = $(this).val();
        if (x == "WP01") {
            $(this).attr("disabled", true);
            $("#backno").attr("readonly", false); 
            $("#quantity").attr("readonly", false);
            document.getElementById('backno').focus(); 
        }
        else if (x == "PP01") {
            $(this).attr("disabled", true);
            $("#backno").attr("readonly", false); 
            $("#quantity").attr("readonly", false);
            document.getElementById('backno').focus();
        }
        else if (x == "PP02") {
            $(this).attr("disabled", true);
            $("#backno").attr("readonly", false); 
            $("#quantity").attr("readonly", false);
        }
        else if (x == "PP03") {
            $(this).attr("disabled", true);
            $("#backno").attr("readonly", false); 
            $("#quantity").attr("readonly", false);
        }
    });
});
// end document ready
</script>
<aside class="right-side">

    <section class="content-header">
        <ol class="breadcrumb">
            <li><a href="<?php echo base_url('index.php/basis/home_c/'); ?>"><span>Home</span></a></li>
            <li><a href="<?php echo base_url('index.php/pes/prodentry_c/'); ?>">Stock Transfer System</a></li>
            <li><a href="<?php echo base_url('index.php/pes/stock_transfer_c/'); ?>">Stock Transfer Execution</a></li>
            <li><a href=""><strong>Stock Transfer</strong></a></li>
        </ol>
    </section>

    <section class="content">
        <div class="row">
            <div class="col-md-12 text-center">
<div class="grid" ><!--style="background-color: #94D1DC"-->
    <div class="grid-header">
        <i class="fa fa-wrench"></i>
        <div class="panel panel-default">
            <div class="panel-heading">SELAMAT DATANG SILAHKAN MASUKKAN BARANG YANG INGIN ANDA KEMBALIKAN</div>
        </div>
    </div>
    <div class="grid-body">
            <div class="clear-fix"></div>
            <div class="ng-screen-login">
                <div class="form-group">
                    <label class="col-sm-2 control-label">From Location</label>
                    <div class="col-sm-4">
                        <select style="width:100px" id="pilih" name="pilih" class="pilih" onClick="changeReadOnly()">
                                        <option value=""></option>
                                        <option value="WP01" onClick="changeReadOnly()">WP01</option>
                                        <option value="PP01" onClick="changeReadOnly()">PP01</option>
                                        <option value="PP02" onClick="changeReadOnly()">PP02</option>
                                        <option value="PP03" onClick="changeReadOnly()">PP03</option>
                        </select>
                    </div>
                </div>
            </div>    
        <form method="POST" action="<?php echo site_url('pes/stock_transfer_c/add_session/engineering')?>" class="form-horizontal">

                <div class="clear-fix"></div>
                <div class="form-group">
                    <div class="col-sm-12">
                        <div class="col-sm-3">
                            <input type="text" name="CHR_BACK_NO" id="back_no" class="form-control" placeholder="Back Number"></input>    
                        </div>
                        <div class="col-sm-3"><input type="text" name="INT_TOTAL_QTY" class="form-control" placeholder="Quantity"></input></div>
                        <div class="col-sm-3"><input type="submit" class="btn btn-primary" value="Add"></input></div>
                    </div>
                </div>
                <div class="clear-fix"></div>
                <hr>
            </form>
            </div>
        <div class="table">
            <?php echo $this->table->generate($table);?>
        </div>
    </div>
</div>
</div>
        </div>
    </section>
</aside>



<script type="text/javascript">
    $(document).ready(function(){

        $("#back_no").autocomplete({
            source:'<?php echo site_url();?>/pes/stock_transfer_c/data/back_no',
            minLength:1 ,
        });
    });
</script>