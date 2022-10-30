<script>
    $(document).ready(function () {
        var date = new Date();
        $("#datepicker1").datepicker({dateFormat: 'dd-mm-yy'}).val();
    });
</script>
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
        echo form_open('display_prod/feedback_recovery_prod_c/save_feedback', 'class="form-horizontal"');
        ?>

        <div class="row">
            <div class="col-md-12">
                <div class="grid">
                    <div class="grid-header">
                        <i class="fa fa-comment"></i>
                        <span class="grid-title"><strong>CREATE PROBLEM & CORRECTIVE ACT.</strong></span>
                        <div class="pull-right grid-tools">
                            <a data-widget="collapse" title="Collapse"><i class="fa fa-chevron-up"></i></a>
                        </div>
                    </div>
                    <div class="grid-body">
                        <input type='hidden' id='npk' value='<?php echo $npk ?>' name='CHR_NPK'>
                        <input type='hidden' id='username' value='<?php echo $username ?>' name='CHR_USERNAME'>
                        <input type='hidden' id='wo_number' value='<?php echo $wo_number ?>' name='CHR_WO_NUMBER'>

                        <div class="form-group">
                            <label class="col-sm-3 control-label">WO Number</label>
                            <div class="col-sm-2">
                                <select id="e1" class="form-control" style='width:250px;' onchange="document.getElementById('wo_number').value=this.options[this.selectedIndex].value;">
                                    <?php
                                    foreach ($last_all_wo_number as $wo) {
                                        if (trim($wo->CHR_WO_NUMBER) == $wo_number){
                                            echo'<option selected value="' . $wo->CHR_WO_NUMBER . '">' . $wo->CHR_WO_NUMBER . '</option>';
                                        }else{
                                            echo'<option value="' . $wo->CHR_WO_NUMBER . '">' . $wo->CHR_WO_NUMBER . '</option>';
                                        }
                                    }
                                    ?>
                                </select>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-3 control-label">Comment</label>
                            <div class="col-sm-5">
                                <textarea name="CHR_PROBLEM" id='comment_message' maxlength="50" cols="3" rows="3" class="form-control" type="text" required></textarea>
                            </div>
                        </div>
                        <div class="form-group"  >
                            <label class="col-sm-3 control-label">Corrective Act</label>
                            <div class="col-sm-5">
                                <textarea name="CHR_CORRECTIVE_ACTION" id='corrective_action' maxlength="150" cols="3" rows="3" class="form-control" type="text" required></textarea>
                            </div>
                        </div>

                        <div class="form-group" >
                            <label class="col-sm-3 control-label" style="padding-top:25px;">Start Time</label>
                            <div class="col-sm-1">Hour
                                <input value="<?php echo date('H'); ?>" name="START_HOUR" id="value_starth" autocomplete="off" onkeyup="angka(this);" class="inputs" maxlength="2" minlength="2" required type="text"  style="width: 40px;text-transform: uppercase;padding-left:11px;">
                            </div>
                            <div class="col-sm-1" style="margin-left:-25px;">Minutes
                                <input value="<?php echo date('i'); ?>" name="START_MINUTE" id="value_startm" autocomplete="off" onkeyup="angka(this);" class="inputs2" maxlength="2" minlength="2" required type="text"  style="width: 40px;text-transform: uppercase;padding-left:11px;">
                            </div>
                            </div>
                            <div class="form-group"  >
                            <label class="col-sm-3 control-label" style="padding-top:25px;">Until</label>
                            <div class="col-sm-1">Hour
                                <input value="<?php echo date('H'); ?>" name="END_HOUR" id="value_endh" autocomplete="off" onkeyup="angka(this);" class="inputs3" maxlength="2" minlength="2" required type="text"  style="width: 40px;text-transform: uppercase;padding-left:11px;">
                            </div>
                            <div class="col-sm-1" style="margin-left:-25px;">Minutes
                                <input value="<?php echo date('i'); ?>" name="END_MINUTE"  id="value_endm" autocomplete="off" onkeyup="angka(this);" class="inputs4" maxlength="2" minlength="2" required type="text"  style="width: 40px;text-transform: uppercase;padding-left:11px;">
                            </div>
                        </div>
                                            
                        <div class="form-group">
                            <div class="col-sm-offset-3 col-sm-5">
                                <div class="btn-group">
                                    <button id="btnPrepareSubmit" class="btn btn-primary"><i class="fa fa-check"></i> Save</button>
                                    <button type="submit" style="display:none;" id="btnTrueSubmit"> True Save</button>
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

<script>

$("#btnPrepareSubmit").on('click', function (event) {
        event.preventDefault();
        var el = $(this);

        if($("#value_endh").val() < $("#value_starth").val()){
            alert('Data waktu kurang tepat, mohon diperiksa kembali');
            return false;
        }

        if($("#value_endh").val() <= $("#value_starth").val() && $("#value_startm").val() > $("#value_endm").val()){
            alert('Data waktu kurang tepat, mohon diperiksa kembali');
            return false;
        }

        if($("#value_endh").val() > 23 || $("#value_starth").val() > 23){
            alert('jam tidak boleh dari 23');
            return false;
        }

        if($("#value_startm").val() > 59 || $("#value_endm").val() > 59){
            alert('Menit tidak boleh dari 59');
            return false;
        }

        if($("#value_starth").val().length == 1){
            $("#value_starth").val() = '0' + $("#value_starth").val();
        }

        if($("#value_startm").val().length == 1){
            $("#value_startm").val() = '0' + $("#value_startm").val();
        }

        if($("#value_endh").val().length == 1){
            $("#value_endh").val() = '0' + $("#value_endh").val();
        }

        if($("#value_endm").val().length == 1){
            $("#value_endm").val() = '0' + $("#value_endm").val();
        }

        if($("#comment_message").val() == '' || $("#comment_message").val() == null){
            alert('kosong');
            return false;
        }

        if($("#corrective_action").val() == '' || $("#corrective_action").val() == null){
            alert('kosong');
            return false;
        }

        var wo_number = $("#wo_number").val();
        var work_center = $("#wo_number").val().substring(0, 6);
        var comment_message = $("#comment_message").val();
        var corrective_action = $("#corrective_action").val();
        var start_time = $("#value_starth").val() + ':' + $("#value_startm").val() + ':00';
        var end_time = $("#value_endh").val() + ':' + $("#value_endm").val() + ':00';
        var commenter = $("#npk").val() + '-' + $("#username").val();

        $.ajax({
            type: "POST",
            contentType : "application/json",
            dataType: 'json',
            url: "http://192.168.0.251:3000/api/comment",
            crossDomain:true, 
            data:JSON.stringify({
                work_center: work_center,
                wo_number: wo_number,
                comment_message: comment_message,
                corrective_action: corrective_action,
                commenter: commenter,
                start_time: start_time,
                end_time: end_time
            })
        }).done(function ( data ) {
            console.log(data);

            $("#btnTrueSubmit").click();
            el.prop('disabled', true);

        }).fail(function(jqXHR){
            alert(jqXHR.responseText);
            console.log(jqXHR.responseText);
        });

    });

</script>