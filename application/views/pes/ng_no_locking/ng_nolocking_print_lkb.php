<div class="grid">
    <div class="grid-header">
        <i class="fa fa-wrench"></i>
        <span class="grid-title">GENERATE PRINT LKB </span>
    </div>

    <div class="grid-body">
        <h4 align="center">MASUKKAN KODE AREA</h4>
        <form method="POST">
            <a href="<?php echo site_url('/pes/ng_no_locking/print_lkb');?>" class="btn btn-primary pull-right" style="margin-left: 5px">Reset</a>
            <input type="submit" name="generate" value="Print" class="btn btn-primary pull-right"></input>
            <input type="hidden" name="CHR_LKB_NO" value="<?php echo @$CHR_LKB_NO;?>" class="form-control" autocomplete="off"></input>

        </form>
        <form method="get" action="<?php echo site_url('pes/ng_no_locking/print_lkb')?>" class="form-horizontal" id="print_lkb">
            <div class="clear-fix"></div>
            <div class="ng-screen-login">
                <!-- <div class="form-group">
                    <label class="col-sm-2 control-label">Area</label>
                    <div class="col-sm-4">
                        <input id="area" type="text" name="CHR_AREA" value="<?php echo @$CHR_AREA;?>" class="form-control"></input>
                    </div>
                 </div> -->
                 <div class="form-group">
                    <label class="col-sm-2 control-label">No LKB</label>
                    <div class="col-sm-4">
                        <input id="CHR_LKB_NO" type="text" name="CHR_LKB_NO" value="<?php echo @$CHR_LKB_NO;?>" class="form-control" autocomplete="off"></input>
                    </div>
                    <input type="submit" value="OK" class="btn btn-primary"></input>
                 </div>
        </form>
        <div class="col-md-12" align="center"><h4 style="color: red;padding-bottom: 30px;"><?php echo @$error;?></h4></div>
        
        <div class="table">
            <?php echo $this->table->generate(@$table); ?>
        </div>
    </div>
</div>
<script type="text/javascript">
    $(document).ready(function(){
        $("#CHR_LKB_NO").autocomplete({
            source:'<?php echo site_url();?>/pes/ng_no_locking/data/chr_lkb_no',
            minLength:1 ,
        });
    });
</script>
<input type="hidden" id="refreshed" value="no">
<script type="text/javascript">
    onload=function(){
    var e=document.getElementById("refreshed");
    if(e.value=="no")e.value="yes";
    else{e.value="no";location.reload();}
    }
</script>
<script type="text/javascript">
bajb_backdetect.OnBack = function()
{
   location.reload();
}
window.onhashchange = function() {
 location.reload();
}
</script>