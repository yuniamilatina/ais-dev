
<aside class="right-side">
    <section class="content-header">
        <ol class="breadcrumb">
            <li><a href="<?php echo base_url('index.php/basis/home_c/') ?>"><span>Home</span></a></li>
            <li> <a href="<?php echo base_url('index.php/prd/one_way_kanban_c/index') ?>">MANAGE ONE WAY KANBAN</a></li>
            <li> <a href="#"><strong>PRINT SPECIAL</strong></a></li>
        </ol>
    </section>
    <section class="content">
        <?php
        if ($msg != NULL) {
            echo $msg;
        }
        ?>
        <div class="row">
            <div class="col-md-12">
                <div class="grid">
                    <div class="grid-header">
                        <i class="fa fa-thumb-tack"></i>
                        <span class="grid-title" id="stat-create2"><strong id="stat-create">PRINT SPECIAL</strong></span>
                        <div class="pull-right grid-tools">
                            <a data-widget="collapse" title="Collapse" id="collapse-header"><i class="fa fa-chevron-up"></i></a>
                        </div>
                    </div>
                    <div class="grid-body">
                    <?php
                    echo form_open_multipart('prd/one_way_kanban_c/print_recovery_one_way', 'class="form-horizontal"');
                    ?>
                    
                    <div class="form-group">
                        <label class="col-sm-3 control-label">Prod Order No</label>
                        <div class="col-sm-4">
                            <input class="form-control" name="PRD_ORDER_NO" id="PRD_ORDER_NO" type="text" required style="width:250px;"> 
                        </div>
                    </div>
                    
                    <div class="form-group">
                        <label class="col-sm-3 control-label">Serial</label>
                        <div class="col-sm-4">
                            <input class="form-control" name="SERIAL" id="SERIAL" type="text" style="width:100px;"> 
                        </div>
                    </div>                        
                    
                    <div class="form-group">
                            <div class="col-sm-offset-3 col-sm-5">
                                <div class="btn-group">
                                    <button type="submit" class="btn btn-primary"><i class="fa fa-check"></i> Print</button>
                                    <?php
                                    echo anchor('prd/one_way_kanban_c/index/0/', 'Cancel', 'class="btn btn-default"');
                                    echo form_close();
                                    ?>
                                </div>
                            </div>
                    </div>
                </div>
            </div>           
        </div>
        </div>
    </section>
</aside>

