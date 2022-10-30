
<aside class="right-side">
    <section class="content-header">
        <ol class="breadcrumb">
            <li><a href="<?php echo base_url('index.php/basis/home_c/') ?>"><span>Home</span></a></li>
            <li> <a href="<?php echo base_url('index.php/part/part_customer_c/manage_part_customer_wi') ?>">MANAGE POS</a></li>
            <li> <a href="#"><strong>VIEW POS </strong></a></li>
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
                        <span class="grid-title" id="stat-create2"><strong id="stat-create">VIEW POS</strong></span>
                        <div class="pull-right grid-tools">
                            <a data-widget="collapse" title="Collapse" id="collapse-header"><i class="fa fa-chevron-up"></i></a>
                        </div>
                    </div>
                    <div class="grid-body">
                    <?php
                    echo form_open('', 'class="form-horizontal"');
                    ?>
                   
                        <div class="form-group">
                            <label class="col-sm-1 control-label"></label>
                            <div class="col-sm-12" >
                                <input type="image" src='<?php echo base_url($data_detail->CHR_IMG_FILE_NAME); ?>' style="width:100%;" >
                            </div>
                        </div>

                    
                    <div class="form-group">
                            <div class="col-sm-1 col-sm-1">
                                <div class="btn-group">
                                    <?php
                                    echo anchor('prd/pos_c/index/'.$data_detail->CHR_WORK_CENTER, 'Back', 'class="btn btn-default"');
                                    echo form_close();?>
                                </div>
                            </div>
                    </div>
                </div>
            </div>           
        </div>
        </div>
    </section>
</aside>
