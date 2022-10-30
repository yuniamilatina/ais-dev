<aside class="right-side">
    <section class="content-header">
        <ol class="breadcrumb">
            <li><a href="<?php echo base_url('index.php/home_c/') ?>">Home</a></li>
            <li><a href="<?php echo base_url('index.php/samanta/spare_parts_c') ?>">Manage Spare Part</a></li>
            <li> <a href="#"><strong>Update Qty Spare Part</strong></a></li>
        </ol>
    </section>
    <section class="content">
        <div class="row">
            <div class="col-md-12">
                <div class="grid">
                    <div class="grid-header">
                        <i class="fa fa-gear"></i>
                        <span class="grid-title" id="stat-create2"><strong id="stat-create">UPLOAD</strong> QTY SPARE PART</span>
                        <div class="pull-right">
                            <a href="#" class="btn btn-warning" data-target="#modalUploadDataSTO" data-toggle="modal" data-placement="left" title="Upload massive data" style="height:35px;font-size:13px;width:150px;">Upload Qty</a>
                        </div>
                    </div>
                    <div class="grid-body">
                    <h1>UNDER DEVELOPMENT MIS (PIC: ILHAM )</h1>
                    <br><br>
                    <?php echo form_open_multipart('samanta/spare_parts_c/save_sp', 'class="form-horizontal"'); ?>
                        <div class="form-group">
                            <label class="col-sm-4 control-label">Spare Part No</label>
                            <div class="col-sm-3">
                                <input name="CHR_PART_NO" autofocus class="form-control" maxlength="15" type="text" autocomplete="off" required >
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-4 control-label">Qty</label>
                            <div class="col-sm-3">
                                <input name="INT_QTY" class="form-control" required type="number" autocomplete="off" >
                            </div>
                        </div>
                        <br>
                        <div class="form-group">
                            <div class="col-sm-offset-4 col-sm-5">
                                <button type="submit" class="btn btn-primary"><i class="fa fa-check"></i> Save</button>
                                <?php
                                echo anchor('samanta/spare_parts_c/', 'Cancel', 'class="btn btn-default"');
                                ?>
                            </div>
                        </div>

                    <?php echo form_close(); ?>
                </div>
            </div>           
        </div>
        </div>

        
        <div class="modal fade" id="modalUploadDataSTO" tabindex="-1" role="dialog" aria-labelledby="myModalLabel1" aria-hidden="true">
            <div class="modal-wrapper">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <form class="form-horizontal" method="post"  role="form" action="<?php echo base_url('index.php/samanta/spare_parts_c/upload_data_sto'); ?>"  enctype="multipart/form-data" role="form">
                            <div class="modal-header">
                                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                                <h4 class="modal-title" id="myModalLabel2">Update Data Qty</h4>
                            </div>
                            <div class="modal-body" >
                                <div class="form-group" style="text-align:center;">
                                    <span style="text-align:center;"><i class="fa fa-download"></i>&nbsp;<a href="<?php echo base_url('index.php/samanta/spare_parts_c/generate_template_sto'); ?>">Download Template</a></span>
                                </div>
                                <div class="form-group">
                                    <label class="col-sm-3 control-label">Upload File</label>
                                    <div class="col-sm-7">
                                        <input type="file" class="form-control" name="import_data_sto" id="import_data_sto" size="20" value="">
                                    </div>
                                </div>
                            </div>
                            <div class="modal-footer">
                                <div class="btn-group">
                                    <button type="button" class="btn btn-default" data-dismiss="modal"> Close</button>
                                    <button class="btn btn-primary" value="1" name="upload_sto_button"> Upload</button>
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
