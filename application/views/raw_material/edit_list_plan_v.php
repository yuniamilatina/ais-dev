<aside class="right-side">
    <section class="content-header">
        <ol class="breadcrumb">
            <li><a href="<?php echo base_url('index.php/home_c/') ?>">HOME</a></li>
            <li><a href="<?php echo base_url('index.php/raw_material/komparasi_kbn_fg_c/') ?>">Master Data Inspection Plan</a></li>
            <li> <a href="#"><strong>UPDATE List INSPECTION PLAN</strong></a></li>
        </ol>
    </section>
    <section class="content">
        <?php
        // echo form_open_multipart('raw_material/komparasi_kbn_fg_c/update_list_plan', 'class="form-horizontal"');
        echo form_open_multipart('quality/inspec_plan_c/update_list_plan', 'class="form-horizontal"');
        ?>
        <div class="row">
            <div class="col-md-12">
                <div class="grid">
                    <div class="grid-header">
                        <i class="fa fa-thumb-tack"></i>
                        <span class="grid-title" id="stat-create2"><strong id="stat-create">UPDATE LIST INSPECTION PLAN</strong></span>
                        <div class="pull-right grid-tools">
                            <a data-widget="collapse" title="Collapse" id="collapse-header"><i class="fa fa-chevron-up"></i></a>
                        </div>
                    </div>
                    <div class="grid-body">
                        <input name="CHR_DRAW" class="form-control" type="hidden" value="<?php echo $data->CHR_IMG_CHECK; ?>">
                        <div class="form-group">
                            <label class="col-sm-3 control-label">DOC ID</label>
                            <div class="col-sm-3">
                                <input name="CHR_DOC_ID" class="form-control" type="text" value="<?php echo $data->CHR_DOC_ID; ?>" readonly>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-3 control-label">Sequence</label>
                            <div class="col-sm-2">
                                <input name="CHR_SEQ" class="form-control" type="text" value="<?php echo $data->CHR_SEQ; ?>" readonly>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-3 control-label">Check Point</label>
                            <div class="col-sm-3">
                                <input name="CHR_CHECK_POINT" class="form-control" type="text" value="<?php echo $data->CHR_CHECK_POINT; ?>">
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-3 control-label">Type</label>
                            <div class="col-sm-3">
                                <select name="CHR_TYPE" class="form-control">
                                    <option value="<?php echo $data->CHR_TYPE; ?>"><?php echo $data->CHR_TYPE; ?></option>
                                    <option value="">- Silahkan Pilih -</option>
                                    <option value="QNT">QUANTITATIF</option>
                                    <option value="QLT">QUALITATIF</option>
                                </select>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-3 control-label">Recording</label>
                            <div class="col-sm-3">
                                <select name="CHR_RECD" class="form-control">
                                    <option value="<?php echo $data->CHR_RECORDING; ?>"><?php echo $data->CHR_RECORDING; ?></option>
                                    <option value="">- Silahkan Pilih -</option>
                                    <option value="Manual">Manual</option>
                                    <option value="Auto">Auto</option>
                                </select>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-3 control-label">Special Characteristic</label>
                            <div class="col-sm-3">
                                <select name="CHR_SPCL" class="form-control">
                                    <option value="<?php echo $data->CHR_SPECIAL_CHAR; ?>"><?php echo $data->CHR_SPECIAL_CHAR; ?></option>
                                    <option value="">- Silahkan Pilih -</option>
                                    <option value="Fit/Function">Fit/Function</option>
                                    <option value="Safety/Compliance">Safety/Compliance</option>
                                    <option value="None">None</option>
                                </select>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-3 control-label">Control</label>
                            <div class="col-sm-3">
                                <select name="CHR_CONT" class="form-control">
                                    <option value="<?php echo $data->CHR_CONTROL; ?>"><?php echo $data->CHR_CONTROL; ?></option>
                                    <option value="">- Silahkan Pilih -</option>
                                    <option value="Max">Max</option>
                                    <option value="Min">Min</option>
                                    <option value="Range">Range</option>
                                </select>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-3 control-label">Target SL</label>
                            <div class="col-sm-2">
                                <input type="text" name="CHR_TSL" id="CHR_TSL" class="form-control" value="<?php echo $data->CHR_TARGET_SL; ?>">
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-3 control-label">Range SL</label>
                            <div class="col-sm-2">
                                <input type="text" name="CHR_RSL" id="CHR_RSL" class="form-control" value="<?php echo $data->CHR_RANGE_SL; ?>">
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-3 control-label">LSL</label>
                            <div class="col-sm-2">
                                <input type="text" name="CHR_LSL" id="CHR_LSL" class="form-control" value="<?php echo $data->CHR_LSL; ?>">
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-3 control-label">USL</label>
                            <div class="col-sm-2">
                                <input type="text" name="CHR_USL" id="CHR_USL" class="form-control" value="<?php echo $data->CHR_USL; ?>">
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-3 control-label">Uom (*SL)</label>
                            <div class="col-sm-2">
                                <select name="CHR_UOMSL" class="form-control">
                                    <?php
                                    foreach ($data_uom as $isi) {
                                        if (trim($data->CHR_UOM_SL) == trim($isi->CHR_UOM)) {
                                    ?>
                                            <option selected value="<?php echo $isi->CHR_UOM; ?>"><?php echo $isi->CHR_UOM; ?></option>
                                        <?php
                                        } else {
                                        ?><option value="<?php echo $isi->CHR_UOM; ?>"><?php echo $isi->CHR_UOM; ?></option>
                                    <?php
                                        }
                                    }
                                    ?>
                                    <option value="">--NONE--</option>
                                </select>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-3 control-label">Target CL</label>
                            <div class="col-sm-2">
                                <input type="text" name="CHR_TCL" id="CHR_TCL" class="form-control" value="<?php echo $data->CHR_TARGET_CL; ?>">
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-3 control-label">Range CL</label>
                            <div class="col-sm-2">
                                <input type="text" name="CHR_RCL" id="CHR_RCL" class="form-control" value="<?php echo $data->CHR_RANGE_CL; ?>">
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-3 control-label">LCL</label>
                            <div class="col-sm-2">
                                <input type="text" name="CHR_LCL" id="CHR_LCL" class="form-control" value="<?php echo $data->CHR_LCL; ?>">
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-3 control-label">UCL</label>
                            <div class="col-sm-2">
                                <input type="text" name="CHR_UCL" id="CHR_UCL" class="form-control" value="<?php echo $data->CHR_UCL; ?>">
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-3 control-label">Uom (*CL)</label>
                            <div class="col-sm-2">
                                <select name="CHR_UOMCL" class="form-control">
                                    <?php
                                    foreach ($data_uom as $isi) {
                                        if ($data->CHR_UOM_CL == $isi->CHR_UOM) {
                                    ?>
                                            <option selected value="<?php echo $isi->CHR_UOM; ?>"><?php echo $isi->CHR_UOM; ?></option>
                                        <?php
                                        } else {
                                        ?>
                                            <option value="<?php echo $isi->CHR_UOM; ?>"><?php echo $isi->CHR_UOM; ?></option>
                                    <?php
                                        }
                                    }
                                    ?>
                                    <option value="">--NONE--</option>
                                </select>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-3 control-label">Qlt CL</label>
                            <div class="col-sm-2">

                                <select name="CHR_QLTCL" class="form-control">
                                    <option value="<?php echo $data->CHR_QLT_CL; ?>"><?php echo $data->CHR_QLT_CL; ?></option>
                                    <option value="">- Silahkan Pilih -</option>
                                    <option value="YES">YES</option>
                                    <option value="OK">OK</option>
                                </select>

                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-3 control-label">Qlt Val</label>
                            <div class="col-sm-2">

                                <select name="CHR_QLTVAL" class="form-control">
                                    <option value="<?php echo $data->CHR_QLT_VAL; ?>"><?php echo $data->CHR_QLT_VAL; ?></option>
                                    <option value="">- Silahkan Pilih -</option>
                                    <option value="YES/NO">YES/NO</option>
                                    <option value="OK/NG">OK/NG</option>
                                </select>

                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-3 control-label">Sampling</label>
                            <div class="col-sm-2">
                                <select name="CHR_SAMP" class="form-control">
                                    <option value="<?php echo $data->CHR_SAMPLING; ?>"><?php echo $data->CHR_SAMPLING; ?></option>
                                    <option value="">- Silahkan Pilih -</option>
                                    <option value="Per Lot">Per Lot</option>
                                    <option value="Per Pcs">Per Pcs</option>
                                    <option value="Per Hour">Per Hour</option>
                                    <option value="Per Shift">Per Shift</option>
                                    <option value="Per Day">Per Day</option>
                                    <option value="Per Month">Per Month</option>
                                </select>
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="col-sm-3 control-label">Frequency</label>
                            <div class="col-sm-2">
                                <input type="text" name="CHR_FREQ" id="CHR_FREQ" class="form-control" value="<?php echo $data->CHR_FREQ; ?>">
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-3 control-label">Strategy</label>
                            <div class="col-sm-2">
                                <select name="CHR_STRAT" class="form-control">
                                    <option value="<?php echo $data->CHR_STRATEGY; ?>"><?php echo $data->CHR_STRATEGY; ?></option>
                                    <option value="">- Silahkan Pilih -</option>
                                    <option value="FML">FML</option>
                                    <option value="FL">FL</option>
                                </select>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-3 control-label">Repetition</label>
                            <div class="col-sm-2">
                                <input type="text" name="CHR_REP" id="CHR_REP" class="form-control" value="<?php echo $data->CHR_REPETITION; ?>">
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-3 control-label">Image Check Point (format PNG/JPG)</label>
                            <div class="col-sm-4">
                                <input name="CHR_IMAGE_LOC" id="upload" type="file">
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-3 control-label">Test Equipment ID</label>
                            <div class="col-sm-4">
                                <select name="CHR_EQUIP" id="e2" class="form-control">
                                    <?php if (trim($data->CHR_DEVICE_ID) == NULL) { ?>
                                        <option value="">--Tidak Ada--</option>
                                    <?php } ?>
                                    <?php foreach ($data_dev as $isi) {
                                        if (trim($data->CHR_DEVICE_ID) == trim($isi->CHR_DEVICE_ID)) {
                                    ?>
                                            <option selected value="<?php echo $isi->CHR_DEVICE_ID; ?>"><?php echo $isi->CHR_DEVICE_ID; ?> - <?php echo $isi->CHR_DEVICE_NAME; ?></option>

                                        <?php } else { ?>
                                            <option value="<?php echo $isi->CHR_DEVICE_ID; ?>"><?php echo $isi->CHR_DEVICE_ID; ?> - <?php echo $isi->CHR_DEVICE_NAME; ?></option>
                                    <?php
                                        }
                                    }
                                    ?>
                                    <option value="">--Tidak Ada--</option>
                                </select>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-3 control-label">Remark</label>
                            <div class="col-sm-2">
                                <select name="CHR_REMARK" class="form-control">
                                    <option value="<?php echo $data->CHR_REMARK; ?>"><?php echo $data->CHR_REMARK; ?></option>
                                    <option value="">- Tidak ada -</option>
                                    <option value="MESIN">Mesin Tester</option>
                                </select>
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="col-sm-offset-3 col-sm-5">
                                <div class="btn-group">
                                    <button type="submit" class="btn btn-primary"><i class="fa fa-check"></i> Save</button>
                                    <?php
                                    echo anchor('raw_material/komparasi_kbn_fg_c/view_list_plan/' . $data->CHR_DOC_ID, 'Cancel', 'class="btn btn-default"');
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
    $("#upload").fileinput({
        'showUpload': false
    });
</script>