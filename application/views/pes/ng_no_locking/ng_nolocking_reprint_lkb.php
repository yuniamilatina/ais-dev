<div class="grid" ><!--style="background-color: #94D1DC"-->
    <div class="grid-header">
        <i class="fa fa-wrench"></i>
        <span class="grid-title">GENERATE REPRINT LKB </span>
    </div>

    <div class="grid-body" style="padding-bottom: 1000px">
        <h4 align="center">MASUKKAN KODE AREA</h4>
        <form method="POST" action="<?php echo site_url('pes/ng_no_locking/reprint_lkb')?>" class="form-horizontal">
            <input type="submit" name="generate" value="Print" class="btn btn-primary"></input>
            <div class="clear-fix"></div>
            <div class="ng-screen-login">
                <div class="form-group">
                    <label class="col-sm-2 control-label">Date</label>
                    <div class="col-sm-4">
                        <div class="input-group date" data-provide="datepicker">
                        <input type="text" class="form-control datepicker" id="date">
                            <div class="input-group-addon">
                                <span class="glyphicon glyphicon-th"></span>
                            </div>
                    </div>
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-sm-2 control-label">NO LKB</label>
                    <div class="col-sm-4">
                        <input id="CHR_LKB_NO" type="text" name="CHR_LKB_NO" value="<?php echo @$CHR_LKB_NO;?>" class="form-control"></input>
                    </div>
                    <input type="submit" value="OK" class="btn btn-primary"></input>
                 </div>
        </form>
        <div class="col-md-12" align="center"><h4 style="color: red;padding-bottom: 30px;"><?php echo @$print_error;?></h4></div>
        
        <div class="table">
            <?php echo $this->table->generate(@$table); ?>
        </div>
    </div>
</div>
<script type="text/javascript">
    $(document).ready(function(){
        $('.datepicker').datepicker();

        $("#CHR_LKB_NO").autocomplete({
            source: function(request, response) {
                $.ajax({
                    url: '<?php echo site_url();?>/pes/ng_no_locking/data/chr_lkb_no',
                    data: {
                        term : request.term
                    },
                    success: function(data) {
                        response(data);
                    }
                });
            },
            min_length: 1,
        });
       
    });
</script>