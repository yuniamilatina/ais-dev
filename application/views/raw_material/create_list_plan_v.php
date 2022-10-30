<aside class="right-side">
    <section class="content-header">
        <ol class="breadcrumb">
            <li><a href="<?php echo base_url('index.php/home_c/"') ?>">Home</a></li>
            <li><a href="<?php echo base_url('index.php/quality/inspec_plan_c"') ?>">Master Data Inspection Plan</a></li>
            <li class="active"> <a href="#"><strong>Create List Plan</strong></a></li>
        </ol>
    </section>

    <section class="content">
        <?php
        echo form_open_multipart('quality/inspec_plan_c/save_list_plan', 'class="form-horizontal"');
        ?>
        <div class="row">
            <div class="col-md-12">
                <div class="grid">
                    <div class="grid-header">
                        <i class="fa fa-comment"></i>
                        <span class="grid-title"><strong>CREATE NEW LIST PLAN - <?php echo $doc_id; ?></strong></span>
                    </div>
                    <div class="grid-body">
                        <input name="CHR_DOC_ID" class="form-control" type="hidden" value="<?php echo $doc_id; ?>">
                        <div class="form-group">
                            <label class="col-sm-3 control-label">Check Point <font color="red">(*)</font> </label>
                            <div class="col-sm-4">
                                <input type="text" name="CHR_POINT" id="CHR_POINT" class="form-control" required>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-3 control-label">Type <font color="red">(*)</font></label>
                            <div class="col-sm-2">
                                <select name="CHR_TYPE" class="form-control" onchange="yesnoCheck(this);" required>
                                    <option value="">- Silahkan Pilih -</option>
                                    <option value="QNT">QUANTITATIF</option>
                                    <option value="QLT">QUALITATIF</option>
                                </select>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-3 control-label">Recording <font color="red">(*)</font></label>
                            <div class="col-sm-2">
                                <select name="CHR_RECD" class="form-control" required>
                                    <option value="">- Silahkan Pilih -</option>
                                    <option value="Manual">Manual</option>
                                    <option value="Auto">Auto</option>
                                </select>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-3 control-label">Special Characteristic <font color="red">(*)</font></label>
                            <div class="col-sm-3">
                                <select name="CHR_SPCL" class="form-control" required>
                                    <option value="">- Silahkan Pilih -</option>
                                    <option value="Fit/Function">Fit/Function</option>
                                    <option value="Safety/Compliance">Safety/Compliance</option>
                                    <option value="None">None</option>
                                </select>
                            </div>
                        </div>
                        <div class="form-group" id="ifYes3" style="display: none;">
                            <label class="col-sm-3 control-label">Control </label>
                            <div class="col-sm-2">
                                <select name="CHR_CONT" class="form-control" onchange="cekCont(this);">
                                    <option value="">- Silahkan Pilih -</option>
                                    <option value="Max">Max</option>
                                    <option value="Min">Min</option>
                                    <option value="Range">Range</option>
                                </select>
                            </div>
                        </div>
                        <div class="form-group" id="sl1" style="display: none;">
                            <label class="col-sm-3 control-label">Target SL</label>
                            <div class="col-sm-2">
                                <input type="text" name="CHR_TSL" id="CHR_TSL" class="form-control">
                            </div>
                        </div>
                        <div class="form-group" id="sl2" style="display: none;">
                            <label class="col-sm-3 control-label">Range SL</label>
                            <div class="col-sm-2">
                                <input type="text" name="CHR_RSL" id="CHR_RSL" class="form-control">
                            </div>
                        </div>
                        <div class="form-group" id="sl3" style="display: none;">
                            <label class="col-sm-3 control-label">LSL</label>
                            <div class="col-sm-2">
                                <input type="text" name="CHR_LSL" id="CHR_LSL" class="form-control">
                            </div>
                        </div>
                        <div class="form-group" id="sl4" style="display: none;">
                            <label class="col-sm-3 control-label">USL</label>
                            <div class="col-sm-2">
                                <input type="text" name="CHR_USL" id="CHR_USL" class="form-control">
                            </div>
                        </div>
                        <div class="form-group" id="sl5" style="display: none;">
                            <label class="col-sm-3 control-label">Uom (SL)</label>
                            <div class="col-sm-2">
                                <select name="CHR_UOMSL" class="form-control">
                                    <option value="">- Silahkan Pilih -</option>
                                    <option value="">NONE</option>
                                    <?php
                                    foreach ($data_uom as $isi) {
                                    ?>
                                        <option value="<?php echo $isi->CHR_UOM; ?>"><?php echo $isi->CHR_UOM; ?></option>
                                    <?php
                                    }
                                    ?>
                                </select>
                            </div>
                        </div>
                        <div class="form-group" id="cl1" style="display: none;">
                            <label class="col-sm-3 control-label">Target CL</label>
                            <div class="col-sm-2">
                                <input type="text" name="CHR_TCL" id="CHR_TCL" class="form-control">
                            </div>
                        </div>
                        <div class="form-group" id="cl2" style="display: none;">
                            <label class="col-sm-3 control-label">Range CL</label>
                            <div class="col-sm-2">
                                <input type="text" name="CHR_RCL" id="CHR_RCL" class="form-control">
                            </div>
                        </div>
                        <div class="form-group" id="cl3" style="display: none;">
                            <label class="col-sm-3 control-label">LCL</label>
                            <div class="col-sm-2">
                                <input type="text" name="CHR_LCL" id="CHR_LCL" class="form-control">
                            </div>
                        </div>
                        <div class="form-group" id="cl4" style="display: none;">
                            <label class="col-sm-3 control-label">UCL</label>
                            <div class="col-sm-2">
                                <input type="text" name="CHR_UCL" id="CHR_UCL" class="form-control">
                            </div>
                        </div>
                        <div class="form-group" id="cl5" style="display: none;">
                            <label class="col-sm-3 control-label">Uom (CL)</label>
                            <div class="col-sm-2">
                                <select name="CHR_UOMCL" class="form-control">
                                    <option value="">- Silahkan Pilih -</option>
                                    <option value="">NONE</option>
                                    <?php
                                    foreach ($data_uom as $isi) {
                                    ?>
                                        <option value="<?php echo $isi->CHR_UOM; ?>"><?php echo $isi->CHR_UOM; ?></option>
                                    <?php
                                    }
                                    ?>
                                </select>
                            </div>
                        </div>
                        <div class="form-group" id="ifYes1" style="display: none;">
                            <label class="col-sm-3 control-label">Qlt CL</label>
                            <div class="col-sm-2">
                                <select name="CHR_QLTCL" class="form-control">
                                    <option value="">- Silahkan Pilih -</option>
                                    <option value="YES">YES</option>
                                    <option value="OK">OK</option>
                                </select>
                            </div>
                        </div>
                        <div class="form-group" id="ifYes2" style="display: none;">
                            <label class="col-sm-3 control-label">Qlt Val</label>
                            <div class="col-sm-2">
                                <select name="CHR_QLTVAL" class="form-control">
                                    <option value="">- Silahkan Pilih -</option>
                                    <option value="YES/NO">YES/NO</option>
                                    <option value="OK/NG">OK/NG</option>
                                </select>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-3 control-label">Sampling <font color="red">(*)</font></label>
                            <div class="col-sm-2">
                                <select name="CHR_SAMP" class="form-control" required onchange="sampCek(this);">
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
                            <label class="col-sm-3 control-label">Frequency <font color="red">(*)</font></label>
                            <div class="col-sm-2">
                                <input type="text" name="CHR_FREQ" id="CHR_FREQ" class="form-control" required="">
                            </div>
                        </div>
                        <div class="form-group" id="ifsamp" style="display: none;">
                            <label class="col-sm-3 control-label">Strategy </label>
                            <div class="col-sm-2">
                                <select name="CHR_STRAT" class="form-control">
                                    <option value="">- Silahkan Pilih -</option>
                                    <option value="FML">FML</option>
                                    <option value="FL">FL</option>
                                </select>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-3 control-label">Repetition <font color="red">(*)</font></label>
                            <div class="col-sm-2">
                                <input type="text" name="CHR_REP" id="CHR_REP" class="form-control" required="">
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-3 control-label">Image Check Point (format PNG/JPG) <font color="red">(*)</font></label>
                            <div class="col-sm-4">
                                <input name="CHR_IMAGE_LOC" id="upload" type="file">
                            </div>
                            <span color="red">Pastikan file tidak mengandung karakter titik - kecuali untuk ekstension</span>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-3 control-label">Test Equipment ID </label>
                            <div class="col-sm-4">
                                <select name="CHR_EQUIP" id="e2" class="form-control">
                                    <option value="">- Silahkan Pilih -</option>
                                    <?php
                                    foreach ($data_dev as $isi) {
                                    ?>
                                        <option value="<?php echo $isi->CHR_DEVICE_ID; ?>"><?php echo $isi->CHR_DEVICE_ID; ?> - <?php echo $isi->CHR_DEVICE_NAME; ?></option>
                                    <?php
                                    }
                                    ?>
                                </select>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-3 control-label">Remark</label>
                            <div class="col-sm-3">
                                <select name="CHR_REMARK" class="form-control">
                                    <option value="">- Tidak ada -</option>
                                    <option value="MESIN">Mesin Tester</option>
                                </select>
                                <!-- <input type="text" name="CHR_REMARK" id="CHR_REMARK" class="form-control"> -->
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="col-sm-offset-3 col-sm-5">
                                <div class="btn-group">
                                    <button type="submit" class="btn btn-primary" data-placement="left" data-toggle="tooltip" title="Save this data"><i class="fa fa-check"></i> Save</button>
                                    <?php
                                    echo anchor('quality/inspec_plan_c/view_list_plan/' . $doc_id, 'Back', 'class="btn btn-default"');
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
<script>
    $("#upload").fileinput({
        'showUpload': false
    });

    function yesnoCheck(that) {
        if (that.value == "QLT") {
            document.getElementById("ifYes1").style.display = "block";
            document.getElementById("ifYes2").style.display = "block";
            document.getElementById("ifYes3").style.display = "none";
        } else {
            document.getElementById("ifYes1").style.display = "none";
            document.getElementById("ifYes2").style.display = "none";
            document.getElementById("ifYes3").style.display = "block";
        }
    }

    function sampCek(that) {
        if ((that.value == "Per Lot") || (that.value == "Per Pcs")) {
            document.getElementById("ifsamp").style.display = "block";
        } else {
            document.getElementById("ifsamp").style.display = "none";
        }
    }

    function cekCont(that) {
        if (that.value == "Range") {
            document.getElementById("cl1").style.display = "block";
            document.getElementById("cl2").style.display = "block";
            document.getElementById("cl3").style.display = "block";
            document.getElementById("cl4").style.display = "block";
            document.getElementById("cl5").style.display = "block";
            document.getElementById("sl1").style.display = "block";
            document.getElementById("sl2").style.display = "block";
            document.getElementById("sl3").style.display = "block";
            document.getElementById("sl4").style.display = "block";
            document.getElementById("sl5").style.display = "block";
        } else if (that.value == "Max") {
            document.getElementById("cl1").style.display = "block";
            document.getElementById("cl2").style.display = "none";
            document.getElementById("cl3").style.display = "block";
            document.getElementById("cl4").style.display = "block";
            document.getElementById("cl5").style.display = "block";
            document.getElementById("sl1").style.display = "block";
            document.getElementById("sl2").style.display = "none";
            document.getElementById("sl3").style.display = "block";
            document.getElementById("sl4").style.display = "block";
            document.getElementById("sl5").style.display = "block";
        } else if (that.value == "Min") {
            document.getElementById("cl1").style.display = "block";
            document.getElementById("cl2").style.display = "none";
            document.getElementById("cl3").style.display = "block";
            document.getElementById("cl4").style.display = "block";
            document.getElementById("cl5").style.display = "block";
            document.getElementById("sl1").style.display = "block";
            document.getElementById("sl2").style.display = "none";
            document.getElementById("sl3").style.display = "block";
            document.getElementById("sl4").style.display = "block";
            document.getElementById("sl5").style.display = "block";
        }
    }
</script>