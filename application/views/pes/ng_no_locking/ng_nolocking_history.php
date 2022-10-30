<div class="grid">
    <div class="grid-header">
        <i class="fa fa-wrench"></i>
        <span class="grid-title">History LKB <?php echo @$detail;?></span>
    </div>

    <div class="grid-body">
        <?php if (!isset($detail)):?>
        <form method="GET" action="<?php echo site_url('pes/ng_no_locking/history')?>" class="form-horizontal">
        <a href="<?php echo site_url('/pes/ng_no_locking/history');?>" class="pull-right btn btn-primary">Reset</a>
        <input type="submit" value="Filter" class="btn btn-primary pull-right" style="margin-right:5px"></input>
            <div class="clear-fix"></div>
            <div class="ng-screen-login">
                <div class="form-group">
                    <label class="col-sm-2 control-label">NO LKB</label>
                    <div class="col-sm-4">
                        <input id="CHR_LKB_NO" type="text" name="CHR_LKB_NO" value="<?php echo @$CHR_LKB_NO;?>" class="form-control"></input>
                    </div>
                 </div>
                <div class="form-group" style="display: inline-block;">
                    <label class="col-sm-2 control-label">Date</label>
                    <div class="col-sm-2">
                        <div class="input-group date" data-provide="datepicker">
                        <input type="text" class="form-control datepicker" id="date" name="DATE_FROM">
                            <div class="input-group-addon">
                                <span class="glyphicon glyphicon-th"></span>
                            </div>
                    </div>
                    </div>
                    <div class="col-sm-2">
                        <div class="input-group date" data-provide="datepicker">
                        <input type="text" class="form-control datepicker" id="date2" name="DATE_TO">
                            <div class="input-group-addon">
                                <span class="glyphicon glyphicon-th"></span>
                            </div>
                    </div>
                    </div>
                </div>
        </form>
        
    </div>
        <?php endif;?>
        <div class="col-md-12" align="center"><h4 style="color: red;padding-bottom: 30px;"><?php echo @$print_error;?></h4></div>
        <div class="table" style="padding-bottom: 20px">
            <?php $this->table->set_template(array('table_open' => '<table id="example" class="tg table table-hover display dataTable no-footer" cellspacing="0" width="100%">'));?>
            <?php echo $this->table->generate(@$table); ?>
        </div>
</div>
<script type="text/javascript">
    $(document).ready(function(){
        $('#date').datepicker({dateFormat: "dd-mm-yy"}).datepicker('setDate', "<?php echo $date_from;?>");;
        $('#date2').datepicker({dateFormat: "dd-mm-yy"}).datepicker('setDate', "<?php echo $date_to;?>");;

        $("#CHR_LKB_NO").autocomplete({
            source: function(request, response) {
                $.ajax({
                    url: '<?php echo site_url();?>/pes/ng_no_locking/data/chr_lkb_no',
                    dataType: "json",
                    data: {
                        term : request.term,
                        date : $("#date").val()
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