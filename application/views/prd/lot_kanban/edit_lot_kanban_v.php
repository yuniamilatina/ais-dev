
<aside class="right-side">
    <section class="content-header">
        <ol class="breadcrumb">
            <li><a href="<?php echo base_url('index.php/basis/home_c/') ?>"><span>Home</span></a></li>
            <li><a href="<?php echo base_url('index.php/prd/lot_kanban_c/"') ?>">Manage Lot Schedule</a></li>
            <li class="active"> <a href="#"><strong>Edit Lot Kanban</strong></a></li>
    </section>
    <section class="content">
        <?php
        if (validation_errors()) {
            echo '<div class = "alert alert-danger"><strong>WARNING !</strong>' . validation_errors() . '</div >';
        }
        echo form_open('prd/lot_kanban_c/update_lot_kanban', 'class="form-horizontal"');
        ?>

        <div class="row">
            <div class="col-md-12">
                <div class="grid">
                    <div class="grid-header">
                        <i class="fa fa-clock-o"></i>
                        <span class="grid-title"><strong>EDIT LOT KANBAN</strong></span>
                        <div class="pull-right grid-tools">
                            <a data-widget="collapse" title="Collapse"><i class="fa fa-chevron-up"></i></a>
                        </div>
                    </div>
                    <input name="INT_ID_DEPT" class="form-control"  type="hidden" value="<?php echo $id_dept; ?>">

                    <div class="grid-body">
                        <div class="form-group">
                            <label class="col-sm-3 control-label">Work Center</label>
                            <div class="col-sm-3">
                                <input readonly name="CHR_WORK_CENTER" class="form-control" maxlength="50" required type="text" value="<?php echo $work_center; ?>">
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-3 control-label">Part No</label>
                            <div class="col-sm-3">
                                <input readonly name="CHR_PART_NO" class="form-control" maxlength="50" required type="text" value="<?php echo $data[0]->CHR_PART_NO; ?>">
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-3 control-label">Lot Size (Pcs)</label>
                            <div class="col-sm-5">
                                <input type="number" id="qty_pcs" name="INT_LOT_PCS" class="form-control" onkeyup="calc_kanban();" required value="<?php echo trim($data[0]->INT_LOT_SIZE * $data[0]->INT_QTY_PER_BOX) ?>" >
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-3 control-label">Qty per Box</label>
                            <div class="col-sm-5">
                                <input type="number" id="qty_per_box" name="INT_QTY_PER_BOX" class="form-control" readonly value="<?php echo $data[0]->INT_QTY_PER_BOX; ?>" >
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-3 control-label">Total Kanban</label>
                            <div class="col-sm-5">
                                <input type="number" id="qty_kanban" name="INT_LOT_SIZE" class="form-control" readonly value="<?php echo $data[0]->INT_LOT_SIZE; ?>" >
                            </div>
                        </div>
                        
                        <div class="form-group">
                            <div class="col-sm-offset-3 col-sm-5">
                                <div class="btn-group">
                                    <button type="submit" class="btn btn-primary"><i class="fa fa-check"></i> Update</button>
                                    <?php
                                    echo anchor('prd/lot_kanban_c', 'Cancel', 'class="btn btn-default"');
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
<script type="text/javascript" language="javascript">
    function calc_kanban(){
        var pcs = document.getElementById('qty_pcs').value;
        var qty_per_box = document.getElementById('qty_per_box').value;

        var tot_kanban = parseInt(pcs) / parseInt(qty_per_box);

        document.getElementById('qty_kanban').value = tot_kanban;
    }
</script>
