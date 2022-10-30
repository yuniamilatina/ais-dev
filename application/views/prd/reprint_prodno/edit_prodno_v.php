
<aside class="right-side">
    <section class="content-header">
        <ol class="breadcrumb">
            <li><a href="<?php echo base_url('index.php/basis/home_c/') ?>">Home</a></li>
            <li><a href="<?php echo base_url('index.php/prd/reprint_prod_no_c/'); ?>"><span>Data Production Nomor</span></a></li>
            <li><a href=""><strong>Edit Data Production Nomor</strong></a></li>
        </ol>
    </section>

    <section class="content">
        <?php
        if (validation_errors()) {
            echo '<div class = "alert alert-danger"><strong>WARNING !</strong>' . validation_errors() . '</div >';
        }
        echo form_open('prd/reprint_prod_no_c/update_data', 'class="form-horizontal"');
        ?>
        <div class="row">
            <div class="col-md-12">
                <div class="grid">
                    <div class="grid-header">
                        <i class="fa fa-ticket"></i>
                        <span class="grid-title"><strong>EDIT PRODUCTION NOMOR YANG AKAN DIREPRINT</strong></span>
                        <div class="pull-right grid-tools">
                            <a data-widget="collapse" title="Collapse"><i class="fa fa-chevron-up"></i></a>
                        </div>
                    </div>
                    <div class="grid-body">
                        <div class="form-group">
                            <label class="col-sm-3 control-label">Part No FG</label>
                            <div class="col-sm-3">
                                <input name="CHR_PNO" class="form-control" readonly="" type="text" value="<?php echo $data->CHR_PART_NO_FG; ?>">
                                <input type="hidden" name="chr_id" value="<?php echo $data->INT_ID; ?>">
                                <input type="hidden" name="chr_prodno" value="<?php echo $data->CHR_PRD_ORDER_NO; ?>">
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-3 control-label">Back No FG</label>
                            <div class="col-sm-3">
                                <input name="CHR_BNO" class="form-control" readonly="" type="text" value="<?php echo $data->CHR_BACK_NO_FG; ?>">
                            </div>
                        </div>                        
                        <!-- <div class="form-group">
                            <label class="col-sm-3 control-label">Order Box</label>
                            <div class="col-sm-3">
                                <input name="CHR_BOX" class="form-control" value="<?php echo trim($data->INT_QTY_FG) ?>"  readonly="" type="text">
                            </div>
                        </div>   -->
                        <div class="form-group">
                            <label class="col-sm-3 control-label">Work Center</label>
                            <div class="col-sm-3">
                                <input name="CHR_WC" class="form-control" value="<?php echo trim($data->CHR_WORK_CENTER) ?>"  readonly="" type="text">
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-3 control-label">Area Prepare</label>
                            <div class="col-sm-3">
                                <?php if($data->CHR_PREPARE_AREA=='A') { ?>
                                    <input class="form-control" value="CKD ATAS" readonly="" type="text">
                                <?php }elseif($data->CHR_PREPARE_AREA=='B'){ ?>
                                    <input class="form-control" value="OUTHOUSE" readonly="" type="text">
                                <?php }else{ ?>
                                    <input class="form-control" value="INHOUSE" readonly="" type="text">
                                <?php } ?>
                                <input type="hidden" name="CHR_AREA" class="form-control" value="<?php echo trim($data->CHR_PREPARE_AREA) ?>"  readonly="" type="text">
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-3 control-label">Status Reprint (*Isi angka 1)</label>
                            <div class="col-sm-3">
                                <input name="CHR_REPRINT" class="form-control" required type="text">
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="col-sm-offset-3 col-sm-3">
                                <div class="btn-group">
                                    <button type="submit" class="btn btn-primary"><i class="fa fa-refresh"></i> Update</button>
                                    <?php
                                    echo anchor('prd/reprint_prod_no_c', 'Cancel', 'class="btn btn-default"');
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