<script>
    $(document).ready(function () {
        $(".inputs").keyup(function () {
            if (this.value.length == this.maxLength) {
                  $(this).blur();
                  $(".inputs2").focus();
            }
        });

        $(".inputs2").keyup(function () {
            if (this.value.length == this.maxLength) {
                  $(this).blur();
                  $(".inputs3").focus();
            }
        });

        $(".inputs3").keyup(function () {
            if (this.value.length == this.maxLength) {
                  $(this).blur();
                  $(".inputs4").focus();
            }
        });

        $(".inputs4").keyup(function () {
            if (this.value.length == this.maxLength) {
                  $(this).blur();
                  $("#btn-ok").focus();
            }
        });

    });
</script>
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
//        while (s.substr(0, 1) == '0' && s.length > 1) {
//            s = s.substr(1, 9999);
//        }
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
            <li><a href="<?php echo base_url('index.php/display_prod/feedback_recovery_prod_c') ?>">Manage Problem & C/A</a></li>
            <li><a href="<?php echo base_url('index.php/display_prod/feedback_recovery_prod_c/create_feedback') ?>"><strong>Create Problem & C/A</strong></a></li>
        </ol>
    </section>

    <section class="content">
        <?php
        if (validation_errors()) {
            echo '<div class = "alert alert-danger"><strong>WARNING !</strong>' . validation_errors() . '</div >';
        }
        echo form_open('display_prod/feedback_recovery_prod_c/update_feedback', 'class="form-horizontal"');
        ?>

        <div class="row">
            <div class="col-md-12">
                <div class="grid">
                    <div class="grid-header">
                        <i class="fa fa-comment"></i>
                        <span class="grid-title"><strong>EDIT PROBLEM & CORRECTIVE ACT.</strong></span>
                        <div class="pull-right grid-tools">
                            <a data-widget="collapse" title="Collapse"><i class="fa fa-chevron-up"></i></a>
                        </div>
                    </div>
                    <div class="grid-body">
                    
                        <input type='hidden' name='INT_ID' value='<?php echo $data->INT_ID ?>'>
                        <div class="form-group">
                            <label class="col-sm-3 control-label">WORK CENTER *</label>
                            <div class="col-sm-2">
                                <input type='text' readonly class="form-control" value='<?php echo $data->CHR_WORK_CENTER; ?>'>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-3 control-label">PROBLEM *</label>
                            <div class="col-sm-5">
                                <textarea readonly name="CHR_PROBLEM" maxlength="50" cols="3" rows="3" class="form-control" type="text"><?php echo trim($data->CHR_PROBLEM); ?></textarea>
                            </div>
                        </div>
                        <div class="form-group"  >
                            <label class="col-sm-3 control-label">CORRECTIVE ACT *</label>
                            <div class="col-sm-5">
                                <textarea readonly name="CHR_CORRECTIVE_ACTION" maxlength="150" cols="3" rows="3" class="form-control" type="text"><?php echo trim($data->CHR_CORRECTIVE_ACTION); ?></textarea>
                            </div>
                        </div>
                        
                        <div class="form-group" >
                            <label class="col-sm-3 control-label" style="padding-top:25px;">PROBLEM START TIME *</label>
                            <div class="col-sm-1">Hour
                                <input disabled value="<?php echo $data->JAM_START; ?>" readonly name="START_HOUR" id="value_starth" autocomplete="off" onkeyup="angka(this);" class="inputs" maxlength="2" minlength="2" required type="text"  style="width: 40px;text-transform: uppercase;padding-left:11px;">
                            </div>
                            <div class="col-sm-1" style="margin-left:-25px;">Minutes
                                <input disabled value="<?php echo $data->MENIT_START; ?>" readonly name="START_MINUTE" id="value_startm" autocomplete="off" onkeyup="angka(this);" class="inputs2" maxlength="2" minlength="2" required type="text"  style="width: 40px;text-transform: uppercase;padding-left:11px;">
                            </div>
                        </div>

                        <div class="form-group">
                                <label class="col-sm-3 control-label" style="padding-top:25px;">UNTIL *</label>
                                <div class="col-sm-1">Hour
                                    <input value="<?php echo $data->JAM_END; ?>" name="END_HOUR" id="value_endh" autocomplete="off" onkeyup="angka(this);" class="inputs3" maxlength="2" minlength="2" required type="text"  style="width: 40px;text-transform: uppercase;padding-left:11px;">
                                </div>
                                <div class="col-sm-1" style="margin-left:-25px;">Minutes
                                    <input value="<?php echo $data->MENIT_END; ?>" name="END_MINUTE"  id="value_endm" autocomplete="off" onkeyup="angka(this);" class="inputs4" maxlength="2" minlength="2" required type="text"  style="width: 40px;text-transform: uppercase;padding-left:11px;">
                                </div>
                        </div>
                                            
                        * = mandatory
                        <div class="form-group">
                            <div class="col-sm-offset-3 col-sm-5">
                                <div class="btn-group">
                                    <button type="submit" class="btn btn-primary" data-placement="left" data-toggle="tooltip" title="Update this data"><i class="fa fa-refresh"></i> Update</button>
                                    <?php
                                    echo anchor('display_prod/feedback_recovery_prod_c', 'Cancel', 'class="btn btn-default" data-placement="right" data-toggle="tooltip" title="Back to manage"');
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
