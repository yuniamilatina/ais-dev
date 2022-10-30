<aside class="right-side">
    <section class="content-header">
        <ol class="breadcrumb">
            <li><a href="<?php echo base_url('index.php/home_c/') ?>">Home</a></li>
            <li><a href="<?php echo base_url('index.php/samanta/spare_parts_c') ?>">Manage Spare Part</a></li>
            <li> <a href="#"><strong>New Spare Part</strong></a></li>
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
                        <i class="fa fa-gear"></i>
                        <span class="grid-title"><strong>NEW SPARE PART</strong></span>
                        <div class="pull-right">
                            <a href="#" class="btn btn-warning" data-target="#modalUploadData" data-toggle="modal" data-placement="left" title="Upload massive data" style="height:35px;font-size:13px;width:150px;">Upload Data</a>
                        </div>
                    </div>
                    <div class="grid-body">

                        <?php echo form_open('samanta/spare_parts_c/save_spare_parts', 'class="form-horizontal"'); ?>

                        <div class="row">
                            <div class="col-md-6">

                                <div class="form-group">
                                    <label class="col-sm-4 control-label">Spare Part No*</label>
                                    <div class="col-sm-6">
                                        <input name="CHR_PART_NO" autofocus class="form-control" maxlength="15" type="text" autocomplete="off" required>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="col-sm-4 control-label">Warehouse</label>
                                    <div class="col-sm-6">
                                        <select class="form-control" name="CHR_SLOC">
                                            <option value="MT01">Dies/Mold MTE</option>
                                            <option value="MT02">Door Frame</option>
                                            <option value="MT03">Machine MTE</option>
                                            <option value="IT01">MIS MTE</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="col-sm-4 control-label">Address/Rack No</label>
                                    <div class="col-sm-6">
                                        <input name="CHR_RACK_NO" class="form-control" maxlength="15" required type="text" autocomplete="off">
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="col-sm-4 control-label">Type</label>
                                    <div class="col-sm-6">
                                        <select class="form-control" name="CHR_TYPE">
                                            <option value="D">D - Dies</option>
                                            <option value="E">E - Electric</option>
                                            <option value="H">H - Hardware</option>
                                            <option value="J">J - Mold</option>
                                            <option value="M">M - Mechanic</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="col-sm-4 control-label">Component</label>
                                    <div class="col-sm-6">
                                        <select class="form-control" name="CHR_COMPONENT">
                                            <option value="CC">CC</option>
                                            <option value="CC">CD</option>
                                            <option value="IM">IM</option>
                                            <option value="DF">DF</option>
                                            <option value="DL">DL</option>
                                            <option value="BP">BP</option>
                                            <option value="OT">OTHER</option>
                                        </select>
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label class="col-sm-4 control-label">Back No</label>
                                    <div class="col-sm-6">
                                        <input name="CHR_BACK_NO" class="form-control" maxlength="4" type="text" autocomplete="off">
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label class="col-sm-4 control-label">Model</label>
                                    <div class="col-sm-6">
                                        <input name="CHR_MODEL" class="form-control" maxlength="10" type="text" autocomplete="off">
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label class="col-sm-4 control-label">Spare Part Name</label>
                                    <div class="col-sm-6">
                                        <input name="CHR_SPARE_PART_NAME" class="form-control" maxlength="50" required type="text" autocomplete="off">
                                    </div>
                                </div>

                            </div>
                            <div class="col-md-6">

                                <table class="table table-condensed table-striped table-hover display" style='font-size:11px;'>
                                    <tr>
                                        <td colspan="6"><i>*Standard Pembuatan Spare Part Number (contoh)</i></td>
                                    </tr>
                                    <tr style="text-align: center">
                                        <td>Plant (<i>Default</i>)</td>
                                        <td>Type</td>
                                        <td>Sub Type</td>
                                        <td>Serial Code</td>
                                        <td>Eci Mark</td>
                                    </tr>
                                    <tr style="text-align: center">
                                        <td>600</td>
                                        <td>H</td>
                                        <td>10</td>
                                        <td>00001</td>
                                        <td>0</td>
                                    </tr>
                                    <tr>
                                        <td colspan="3"><i>Result : </i></td>
                                        <td colspan="3" style="font-weight:bold;text-align:right;">600H10000010</td>
                                    </tr>
                                </table>

                                <hr>
                                <div class="form-group">
                                    <label class="col-sm-3 control-label">Specification</label>
                                    <div class="col-sm-7">
                                        <input name="CHR_SPECIFICATION" class="form-control" maxlength="80" required type="text" autocomplete="off">
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="col-sm-3 control-label">Qty Use</label>
                                    <div class="col-sm-7">
                                        <input name="INT_QTY_USE" class="form-control" required type="number" autocomplete="off">
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="col-sm-3 control-label">Qty Minimum</label>
                                    <div class="col-sm-7">
                                        <input name="INT_QTY_MIN" class="form-control" required type="number" autocomplete="off">
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="col-sm-3 control-label">Qty Maximum</label>
                                    <div class="col-sm-7">
                                        <input name="INT_QTY_MAX" class="form-control" required type="number" autocomplete="off">
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="col-sm-3 control-label">Price (IDR)</label>
                                    <div class="col-sm-7">
                                        <input type="number" class="form-control" name="CHR_PRICE" id="date" placeholder="IDR " required>
                                    </div>
                                </div>

                            </div>
                        </div>

                        <div class="form-group">
                            <div class="col-sm-offset-3 col-sm-5">
                                <?php
                                echo anchor('samanta/spare_parts_c/', 'Cancel', 'class="btn btn-default"');
                                ?>
                                <button type="submit" class="btn btn-primary"><i class="fa fa-check"></i> Save</button>
                            </div>
                        </div>
                        <?php echo form_close(); ?>

                    </div>
                </div>
            </div>
        </div>

        <div class="modal fade" id="modalUploadData" tabindex="-1" role="dialog" aria-labelledby="myModalLabel1" aria-hidden="true">
            <div class="modal-wrapper">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <form class="form-horizontal" method="post" role="form" action="<?php echo base_url('index.php/samanta/spare_parts_c/upload_data_sp'); ?>" enctype="multipart/form-data" role="form">
                            <div class="modal-header">
                                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                                <h4 class="modal-title" id="myModalLabel2">Upload Data Spare Parts</h4>
                            </div>
                            <div class="modal-body">
                                <div class="form-group" style="text-align:center;">
                                    <span style="text-align:center;"><i class="fa fa-download"></i>&nbsp;<a href="<?php echo base_url('index.php/samanta/spare_parts_c/generate_template'); ?>">Download Template</a></span>
                                </div>
                                <div class="form-group">
                                    <label class="col-sm-3 control-label">Upload File</label>
                                    <div class="col-sm-7">
                                        <input type="file" class="form-control" name="import_data" id="import_data" size="20" value="">
                                    </div>
                                </div>
                            </div>
                            <div class="modal-footer">
                                <div class="btn-group">
                                    <button type="button" class="btn btn-default" data-dismiss="modal"> Close</button>
                                    <button class="btn btn-primary" value="1" name="upload_button"> Upload</button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>

    </section>
</aside>

<script type="text/javascript" language="javascript">
    function replaceChars(entry) {
        out = "."; // replace this
        add = ""; // with this
        temp = "" + entry; // temporary holder

        while (temp.indexOf(out) > -1) {
            pos = temp.indexOf(out);
            temp = "" + (temp.substring(0, pos) + add +
                temp.substring((pos + out.length), temp.length));
        }
    }
</script>