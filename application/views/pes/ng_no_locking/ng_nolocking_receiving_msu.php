<div class="grid">
    <div class="grid-header">
        <i class="fa fa-wrench"></i>
        <span class="grid-title">PENERIMAAN KOMPONEN NG </span>
    </div>

    <div class="grid-body">
        <h4 align="center">SCAN LKB NO</h4>
        <div class="col-md-12" align="center"><h4 style="color: red;padding-bottom: 30px;"><?php echo @$error;?></h4></div>
        <form method="POST" action="<?php echo site_url('pes/ng_no_locking/receiving_msu')?>" class="form-horizontal">
            <div class="clear-fix"></div>
            <div class="ng-screen-login">
                <div class="form-group">
                    <div class="col-sm-4"></div>

                    <div class="col-sm-4">
                        <input type="text" autocomplete="off" name="CHR_LKB_NO" value="<?php echo @$CHR_LKB_NO;?>" placeholder="Scan LKB Number" class="form-control"></input>
                    </div>
                    <input type="submit" value="OK" class="btn btn-primary"></input>
                 </div>
        </form>
        <form method="POST" action="<?php echo site_url('pes/ng_no_locking/receiving_msu/data')?>" class="form-horizontal">
            <div class="col-sm-5"></div>
            <input type="hidden" name="CHR_LKB_NO" value="<?php echo @$CHR_LKB_NO;?>" autocomplete="off" placeholder="Scan LKB Number" class="form-control"></input>
            <input type="submit" value="Save" class="btn btn-primary"></input>
            <a href="" class="btn btn-primary" style="margin-left: 5px">Reset</a>
        </form>

        
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