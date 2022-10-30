
<aside class="right-side">
    <section class="content-header">
        <ol class="breadcrumb">
            <li><a href="<?php echo base_url('index.php/basis/home_c/') ?>">Home</a></li>
            <li><a href="<?php echo base_url('index.php/prd/check_part_elina_c/'); ?>"><span>Data Part Kosong Order Elina</span></a></li>
            <li><a href=""><strong>Edit Data Part Kosong</strong></a></li>
        </ol>
    </section>

    <section class="content">
        <?php
        if (validation_errors()) {
            echo '<div class = "alert alert-danger"><strong>WARNING !</strong>' . validation_errors() . '</div >';
        }
        echo form_open('prd/check_part_elina_c/update_data_part', 'class="form-horizontal"');
        ?>
        <div class="row">
            <div class="col-md-12">
                <div class="grid">
                    <div class="grid-header">
                        <i class="fa fa-ticket"></i>
                        <span class="grid-title"><strong>EDIT DATA PART KOSONG</strong></span>
                        <div class="pull-right grid-tools">
                            <a data-widget="collapse" title="Collapse"><i class="fa fa-chevron-up"></i></a>
                        </div>
                    </div>
                    <div class="grid-body">
                        <div class="form-group">
                            <label class="col-sm-3 control-label">Part No</label>
                            <div class="col-sm-3">
                                <input name="CHR_PNO" class="form-control" readonly="" type="text" value="<?php echo $data->CHR_PART_NO; ?>">
                                <input type="hidden" name="chr_prodno" value="<?php echo $data->CHR_PRD_ORDER_NO; ?>">
                                <input type="hidden" name="chr_sloc" value="<?php echo $data->CHR_SLOC; ?>">
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-3 control-label">Back No</label>
                            <div class="col-sm-3">
                                <input name="CHR_BNO" class="form-control" readonly="" type="text" value="<?php echo $data->CHR_BACK_NO; ?>">
                            </div>
                        </div>                        
                        <div class="form-group">
                            <label class="col-sm-3 control-label">Order Box</label>
                            <div class="col-sm-3">
                                <input name="CHR_BOX" class="form-control" value="<?php echo trim($data->INT_ORDER_BOX) ?>"  readonly="" type="text">
                            </div>
                        </div>  
                        <div class="form-group">
                            <label class="col-sm-3 control-label">Order Pcs</label>
                            <div class="col-sm-3">
                                <input name="CHR_PCS" class="form-control" value="<?php echo trim($data->INT_ORDER_PCS) ?>"  readonly="" type="text">
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-3 control-label">Stock Aktual (PCS)</label>
                            <div class="col-sm-3">
                                <input name="CHR_STOCK" class="form-control" value="<?php echo trim($data->INT_PART_QTY) ?>"  required type="text">
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="col-sm-offset-3 col-sm-3">
                                <div class="btn-group">
                                    <button type="submit" class="btn btn-primary"><i class="fa fa-refresh"></i> Update</button>
                                    <?php
                                    echo anchor('prd/check_part_elina_c', 'Cancel', 'class="btn btn-default"');
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