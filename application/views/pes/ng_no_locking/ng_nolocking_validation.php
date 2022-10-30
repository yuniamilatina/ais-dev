<?php if (isset($_GET['load']) && isset($nodata) ): ?>
    <meta http-equiv="refresh" content="0;<?php echo site_url('/pes/ng_no_locking/validation');?>">
<?php endif;?>
<div class="grid">
    <div class="grid-header">
        <i class="fa fa-wrench"></i>
        <span class="grid-title">TRANSAKSI APPROVAL NG </span>
    </div>

    <div class="grid-body">
        <h4 align="center">MASUKKAN KODE AREA</h4>
        <form method="POST" action="<?php echo site_url('pes/ng_no_locking/validation')?>" class="form-horizontal">
        <a href="<?php echo site_url('/pes/ng_no_locking/validation');?>" class="btn btn-primary pull-right" style="margin-left: 5px"> Reset</a>
        <input type="submit" value="Save" class="btn btn-primary pull-right" name="save"></input>
            <div class="clear-fix"></div>
            <div class="ng-screen-login">
                <div class="form-group">
                    <label class="col-sm-2 control-label">Area</label>
                    <div class="col-sm-4">
                        <select name="CHR_AREA" class="form-control">
                            <?php foreach ($area as $value): ?>
                             <option value="<?php echo str_replace(" ", "", $value->CHR_AREA);?>" <?php echo ($value->CHR_AREA == @$CHR_AREA)? "selected" : "";  ?>><?php echo $value->CHR_AREA.", ". $value->CHR_DESC_AREA;?></option>
                            <?php endforeach;?>
                        </select>
                    </div>
                 </div>
                 <div class="form-group">
                    <label class="col-sm-2 control-label">No LKB</label>
                    <div class="col-sm-4">
                        <input id="CHR_LKB_NO" type="text" name="CHR_LKB_NO" value="<?php echo @$CHR_LKB_NO;?>" class="form-control"></input>
                    </div>
                        <input type="submit" value="OK" class="btn btn-primary" name="load"></input>
                 </div>
        <div class="col-md-12" align="center"><h4 style="color: red;padding-bottom: 30px;"><?php echo @$message;?></h4></div>
        <div class="table">
            <?php echo $this->table->generate(@$table); ?>
        </div>
        </form>
    </div>
</div>
<script type="text/javascript">
    $(document).ready(function(){
        $("#CHR_LKB_NO").autocomplete({
            source:'<?php echo site_url();?>/pes/ng_no_locking/data/chr_lkb_no',
            minLength:1 ,
        });
    });
    $("#validAll").change(function () {
    $("input:checkbox").prop('checked', $(this).prop("checked"));
});
function check(e,value)
    {
        //Check Charater
        var unicode=e.charCode? e.charCode : e.keyCode;
        if (value.indexOf(".") != -1)if( unicode == 46 )return false;
        if (unicode!=8)if((unicode<48||unicode>57)&&unicode!=46)return false;
    }
    function checkLength()
    {
        var fieldLength = document.getElementById('num').value.length;
        //Suppose u want 4 number of character
        if(fieldLength <= 7){
            return true;
        }
        else
        {
            var str = document.getElementById('num').value;
            str = str.substring(0, str.length - 1);
            document.getElementById('num').value = str;
        }
    }
</script>
<input type="hidden" id="refreshed" value="no">
<script type="text/javascript">
    onload=function(){
    var e=document.getElementById("refreshed");
    if(e.value=="no")e.value="yes";
    else{e.value="no";window.location.href="<?php base_url('/pes/ng_no_locking/validation');?>";}
    }
</script>
<style type="text/css">
     input[type='checkbox'] { width: 20px; }
</style>
<?php if (isset($no_lkb)): ?>
<div class="modal hide fade" id="validation" style="background: #fff;width: 358px;height: 250px;">
  <div class="modal-header">
    <a class="close" data-dismiss="modal">×</a>
    <h3>NG Component telah divalidasi</h3>
  </div>
  <div class="modal-body">
    <p>No LKB : <?php echo $no_lkb;?></p>
  </div>
  <div class="modal-footer">
    <a href="#" class="btn btn-primary" data-dismiss="modal">Close</a>
  </div>
</div>
<script type="text/javascript">
    $(window).load(function(){
        $('#validation').modal('show');
        $('#validation').removeClass('hide');
    });
</script>
<?php endif;?>