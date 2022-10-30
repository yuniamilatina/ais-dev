<script language="JavaScript">
    function angka(objek) {
        a = objek.value;
        b = a.replace(/[^\d]/g, "");
        c = "";
        panjang = b.length;
        j = 0;
        for (i = panjang; i > 0; i--) {
            j = j + 1;
            if (((j % 3) == 1) && (j != 1)) {
                c = b.substr(i - 1, 1) + "" + c;
            } else {
                c = b.substr(i - 1, 1) + c;
            }
        }
        objek.value = Number(c);
    }

    function Number(s) {

        while (s.substr(0, 1) == '' && s.length > 1) {
            s = s.substr(1, 9999);
        }
        return s;
    }
</script>
<aside class="right-side">
    <section class="content-header">
        <ol class="breadcrumb">
            <li><a href="<?php echo base_url('index.php/basis/home_c') ?>"><span>Home</span></a></li>
            <li><a href="<?php echo base_url('index.php/display_prod/message_display_prod_c') ?>">Manage Message Display</a></li>
            <li><a href="<?php echo base_url('index.php/display_prod/message_display_prod_c/edit_message') ?>"><strong>Edit Message Display</strong></a></li>
        </ol>
    </section>

    <section class="content">
        <?php
        if (validation_errors()) {
            echo '<div class = "alert alert-danger"><strong>WARNING !</strong>' . validation_errors() . '</div >';
        }
        echo form_open('display_prod/message_display_prod_c/update_message', 'class="form-horizontal"');
        ?>
        <div class="row">
            <div class="col-md-12">
                <div class="grid">
                    <div class="grid-header">
                        <i class="fa fa-pencil"></i>
                        <span class="grid-title"><strong>EDIT MESSAGE</strong></span>
                        <div class="pull-right grid-tools">
                            <a data-widget="collapse" title="Collapse"><i class="fa fa-chevron-up"></i></a>
                        </div>
                    </div>
                    <div class="grid-body">
                        <input name="INT_ID" class="form-control" type="hidden" value="<?php echo $data->INT_ID; ?>">
                        <input name="CHR_WO_NUMBER" class="form-control" type="hidden" value="<?php echo $data->CHR_WO_NUMBER; ?>">
                        
                        <!--<div class="form-group">
                            <label class="col-sm-3 control-label">TIME TARGET</label>
                            <div class="col-sm-2">
                                <input name="CHR_TARGET_SOLVE" class="form-control" autocomplete="off"  onkeyup="angka(this);" required type="text" max="60" maxlength="2" value="<?php echo trim($data->CHR_TARGET_SOLVE); ?>">
                            </div>
                            Menit
                        </div>-->
                        
                        <div class="form-group">
                            <label class="col-sm-3 control-label">Message</label>
                            <div class="col-sm-5">
                                <input name="CHR_MESSAGE" class="form-control" maxlength="20" required type="text" value="<?php echo trim($data->CHR_MESSAGE); ?>">
                            </div>
                        </div>

                        <div class="form-group">
                            <div class="col-sm-offset-3 col-sm-5">
                                <div class="btn-group">
                                    <button type="submit" class="btn btn-primary" data-placement="left" data-toggle="tooltip" title="Save this data"><i class="fa fa-refresh"></i> Update</button>
                                    <?php
                                    echo anchor('display_prod/message_display_prod_c', 'Cancel', 'class="btn btn-default" data-placement="right" data-toggle="tooltip" title="Back to manage"');
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
