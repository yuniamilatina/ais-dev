<aside class="right-side">
    <section class="content-header">
        <ol class="breadcrumb">
            <li><a href="<?php echo base_url('index.php/home_c/"') ?>">Home</a></li>
            <li><a href="<?php echo base_url('index.php/raw_material/komparasi_kbn_fg_c"') ?>"><strong>Master Data Inspection Plan</strong></a></li>
            <li class="active"> <a href="#"><strong>Create Copy Plan</strong></a></li>
        </ol>
    </section>

    <section class="content">
        <?php

        echo form_open_multipart('raw_material/komparasi_kbn_fg_c/save_copy', 'class="form-horizontal"');
        ?>

        <div class="row">
            <div class="col-md-12">
                <div class="grid">
                    <div class="grid-header">
                        <i class="fa fa-comment"></i>
                        <span class="grid-title"><strong>CREATE COPY PLAN</strong></span>

                    </div>
                    <div class="grid-body">
                        <input name="CHR_DOC_ID" class="form-control" type="hidden" value="<?php echo $doc_id; ?>">
                        <div class="form-group">
                            <label class="col-sm-3 control-label">Part No <font color="red">(*)</font></label>
                            <div class="col-sm-3">
                                <select name="CHR_PARTNO" class="form-control" id="e1" required>
                                    <option value="">--- Pilih Partno ---</option>
                                    <?php
                                    foreach ($all_part as $isi) {
                                    ?>
                                        <option value="<?php echo $isi->CHR_PART_NO; ?>"><?php echo $isi->CHR_PART_NO; ?> - <?php echo $isi->CHR_BACK_NO; ?></option>
                                    <?php
                                    }
                                    ?>
                                </select>
                            </div>
                        </div>

                        <div class="form-group">
                            <div class="col-sm-offset-3 col-sm-5">
                                <div class="btn-group">
                                    <button type="submit" class="btn btn-primary" data-placement="left" data-toggle="tooltip" title="Save this data"><i class="fa fa-check"></i> Save</button>
                                    <?php
                                    echo anchor('raw_material/komparasi_kbn_fg_c', 'Back', 'class="btn btn-default"');
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