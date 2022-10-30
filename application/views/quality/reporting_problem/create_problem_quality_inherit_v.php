<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
<script type="text/javascript" src="http://w2ui.com/src/w2ui-1.4.2.min.js"></script>
<link rel="stylesheet" type="text/css" href="http://w2ui.com/src/w2ui-1.4.2.min.css" />

<script src="<?php echo base_url('assets/datetimepicker/jquery.timepicker.js') ?>"></script>
<link rel="stylesheet" href="<?php echo base_url('assets/datetimepicker/jquery.timepicker.css'); ?>" >
<script src="<?php echo base_url('assets/datetimepicker/lib/bootstrap-datepicker.js') ?>"></script>
<link rel="stylesheet" href="<?php echo base_url('assets/datetimepicker/lib/bootstrap-datepicker.css'); ?>" >

<style>
    .button{
        background-color: #3A89CF;
        font-size:13px; 
        transition-duration: 0.1s;
        border: none;
        cursor: pointer;
    }
    
    .button1:hover{
        background-color: #0075b0;
    }
</style>

<aside class="right-side">
    <section class="content-header">
        <ol class="breadcrumb">
            <li><a href="<?php echo base_url('index.php/basis/home_c/') ?>">Home</a></li>
            <li><a href="<?php echo base_url('index.php/quality/quality_problem_c/') ?>">Manage Quality Problem</a></li>
            <li><a href="#"><strong>Reporting Quality Problem</strong></a></li>
        </ol>
    </section>

    <section class="content">
        <?php
        if (validation_errors()) {
            echo '<div class = "alert alert-danger"><strong>WARNING !</strong>' . validation_errors() . '</div >';
        }
        ?>
        <div class="row">
            <div class="col-md-12">
                <div class="grid">
                    <div class="grid-header">
                        <i class="fa fa-edit"></i>
                        <span class="grid-title"><strong>REPORT QUALITY PROBLEM</strong></span>
                        <div class="pull-right grid-tools">
                            <a data-widget="collapse" title="Collapse"><i class="fa fa-chevron-up"></i></a>
                        </div>
                    </div>
                    <div class="grid-body">
                        <form method="post" action="<?php echo site_url("quality/quality_problem_c/save_quality_problem_inherit") ?>" class="form-horizontal" enctype="multipart/form-data" role="form">
                            <div class="form-group">
                                <label class="col-sm-3 control-label">No TR Parent</label>
                                <div class="col-sm-2">
                                    <input name="CHR_TR_NO" readonly class='form-control' required type="text" style="width: 300px;" value="<?php echo $data_detail->CHR_TR_NO; ?>">
                                    <input type="hidden" name="INT_ID" value="<?php echo $data_detail->INT_ID; ?>">
                                    <input type="hidden" name="INT_ID_PARENT" value="<?php echo $data_detail->INT_ID_PARENT; ?>">
                                    <input type="hidden" name="INT_ID_CHILD" value="<?php echo $data_detail->INT_ID_CHILD; ?>">
                                    <input type="hidden" name="CHR_WORK_CENTER" value="<?php echo $data_detail->CHR_WORK_CENTER; ?>">
                                </div>
                            </div>
                            
                            <div class="form-group">
                                <label class="col-sm-3 control-label">Back No</label>
                                <div class="col-sm-2">
                                    <select name="CHR_BACK_NO" id="e1" class="form-control" readonly>
                                        <option value="<?php echo $data_detail->CHR_BACK_NO; ?>" selected><?php echo $data_detail->CHR_BACK_NO; ?></option>
                                    </select>
                                </div>
                            </div>
                            
                            <div class="form-group">
                                <label class="col-sm-3 control-label">Part No</label>
                                <div class="col-sm-2">
                                    <select name="CHR_PART_NO" id="e2" class="form-control" readonly>
                                        <option value="<?php echo $data_detail->CHR_PART_NO; ?>" selected><?php echo $data_detail->CHR_PART_NO; ?></option>
                                    </select>
                                </div>
                            </div>
                            
                            <div class="form-group">
                                <label class="col-sm-3 control-label">Part Name</label>
                                <div class="col-sm-2">
                                    <input name="CHR_PART_NAME" readonly class='form-control' required type="text" style="width: 300px;" value="<?php echo $data_detail->CHR_PART_NAME; ?>">
                                </div>
                            </div>

                            <div class="form-group">
                                <label class="col-sm-3 control-label">Problem Type</label>
                                <div class="col-sm-3">
                                    <select name="CHR_QPROBLEM_TITLE" class="form-control" readonly>
                                        <option value="<?php echo $data_detail->CHR_QPROBLEM_TITLE; ?>"><?php echo $data_detail->CHR_QPROBLEM_TITLE; ?></option>                                      
                                    </select>
                                </div>
                            </div>

                            <div class="form-group">
                                <label class="col-sm-3 control-label">Detail of Problem</label>
                                <div class="col-sm-5">
                                    <textarea rows="4" cols="50" name="CHR_QPROBLEM_DESC" readonly required class="form-control" ><?php echo $data_detail->CHR_QPROBLEM_DESC ?></textarea>
                                </div>
                            </div>
                            
                            <div class="form-group">
                                <label class="col-sm-3 control-label">Class Problem</label>
                                <div class="col-sm-5">
                                    <?php if (trim($data_detail->CHR_CLASS_PROBLEM) == 'Visual Part'){ ?>
                                        <input type="radio" class="icheck" name="CHR_CLASS_PROBLEM" value="Visual Part" checked> &nbsp; Visual Part</br>
                                        <input type="radio" class="icheck" name="CHR_CLASS_PROBLEM" value="Function Part" disabled> &nbsp; Function Part</br>
                                        <input type="radio" class="icheck" name="CHR_CLASS_PROBLEM" value="Dimension Part" disabled> &nbsp; Dimension Part</br>
                                        <input type="radio" class="icheck" name="CHR_CLASS_PROBLEM" value="General Problem" disabled> &nbsp; General Problem</br>
                                    <?php } else if (trim($data_detail->CHR_CLASS_PROBLEM) == 'Function Part'){ ?>
                                        <input type="radio" class="icheck" name="CHR_CLASS_PROBLEM" value="Visual Part" disabled> &nbsp; Visual Part</br>
                                        <input type="radio" class="icheck" name="CHR_CLASS_PROBLEM" value="Function Part" checked> &nbsp; Function Part</br>
                                        <input type="radio" class="icheck" name="CHR_CLASS_PROBLEM" value="Dimension Part" disabled> &nbsp; Dimension Part</br>
                                        <input type="radio" class="icheck" name="CHR_CLASS_PROBLEM" value="General Problem" disabled> &nbsp; General Problem</br>
                                    <?php } else if (trim($data_detail->CHR_CLASS_PROBLEM) == 'Dimension Part'){ ?>
                                        <input type="radio" class="icheck" name="CHR_CLASS_PROBLEM" value="Visual Part" disabled> &nbsp; Visual Part</br>
                                        <input type="radio" class="icheck" name="CHR_CLASS_PROBLEM" value="Function Part" disabled> &nbsp; Function Part</br>
                                        <input type="radio" class="icheck" name="CHR_CLASS_PROBLEM" value="Dimension Part" checked> &nbsp; Dimension Part</br>
                                        <input type="radio" class="icheck" name="CHR_CLASS_PROBLEM" value="General Problem" disabled> &nbsp; General Problem</br>
                                    <?php } else { ?>
                                        <input type="radio" class="icheck" name="CHR_CLASS_PROBLEM" value="Visual Part" disabled> &nbsp; Visual Part</br>
                                        <input type="radio" class="icheck" name="CHR_CLASS_PROBLEM" value="Function Part" disabled> &nbsp; Function Part</br>
                                        <input type="radio" class="icheck" name="CHR_CLASS_PROBLEM" value="Dimension Part" disabled> &nbsp; Dimension Part</br>
                                        <input type="radio" class="icheck" name="CHR_CLASS_PROBLEM" value="General Problem" checked> &nbsp; General Problem</br>
                                    <?php } ?>
                                </div>
                            </div>
                            
                            <div class="form-group">
                                <label class="col-sm-3 control-label">Repeat Problem</label>
                                <div class="col-sm-5">
                                    <?php if($data_detail->INT_FLG_REPEAT == 0){ ?>
                                        <input type="radio" class="icheck" name="INT_FLG_REPEAT" value="0" checked> &nbsp; No</br>
                                        <input type="radio" class="icheck" name="INT_FLG_REPEAT" value="1" disabled> &nbsp; Yes</br>                                    
                                    <?php } else { ?>
                                        <input type="radio" class="icheck" name="INT_FLG_REPEAT" value="0" disabled> &nbsp; No</br>
                                        <input type="radio" class="icheck" name="INT_FLG_REPEAT" value="1" checked> &nbsp; Yes</br>
                                    <?php } ?>
                                </div>
                            </div>
                            
                            <div class="form-group">
                                <label class="col-sm-3 control-label">Defect Qty</label>
                                <div class="col-sm-1">
                                    <input name="INT_QTY" readonly required class="form-control" onkeyup="angka(this);" type="text" style="width: 80px;" value="<?php echo $data_detail->INT_QTY; ?>">
                                </div>
                                <div class="col-sm-2">
                                    <select name="CHR_UNIT" class="form-control" readonly>
                                        <option value="PCS"<?php if($data_detail->CHR_UNIT_TYPE == 'PCS'){ echo ' selected'; } ?>>PCS</option>
                                        <option value="KANBAN"<?php if($data_detail->CHR_UNIT_TYPE == 'KANBAN'){ echo ' selected'; } ?>>KANBAN</option>
                                    </select>
                                </div>
                            </div>
                            
                            <div class=" form-group" id="file-name1">
                                <label class="col-sm-3 control-label">Upload Image <span style="color:red">*</span></label>
                                <div class="col-sm-5">
                                    <input type="hidden" name="FILE_UPLOAD" id="import" size="20"  value="<?php echo $data_detail->CHR_FILENAME; ?>">
                                    <img class="btn popup_image" src="<?php echo base_url($data_detail->CHR_FILENAME); ?>" style ="width:100px; height:100px;">
                                </div>
                            </div>

                            <div id="datepairExample">
                                <div  class="form-group">
                                    <label class="col-sm-3 control-label">Defective Date</label>
                                    <div class="col-sm-3">
                                        <div class="input-group" >
                                            <input type="text" class="form-control date start" autocomplete="off" name="CHR_START_DATE" value='<?php echo $data_detail->CHR_START_DATE; ?>' readonly>
                                            <span class="input-group-addon"><i class="fa fa-calendar"></i></span>
                                        </div>
                                    </div>
                                    <div class="col-sm-2">
                                        <div class="input-group">
                                            <input type="text" class="form-control time start" autocomplete="off" name="CHR_START_TIME" value='<?php echo date("H:i", strtotime($data_detail->CHR_START_TIME)); ?>' readonly>
                                            <span class="input-group-addon"><i class="fa fa-clock-o"></i></span>
                                        </div>
                                    </div>
                                </div>
                            </div>   
                            
                            <div class="form-group">
                                <label class="col-sm-3 control-label">Inspector Section</label>
                                <div class="col-sm-3">
                                    <input name="SECTION_REQUESTOR" value="<?php echo $data_detail->CHR_SECTION_REQ.' - '.$data_detail->CHR_SECTION_REQ_DESC; ?>" readonly class='form-control' required type="text" style="width: 230px;">
                                    <input type="hidden" name="INT_ID_SECTION_REQUESTOR" value="<?php echo $data_detail->INT_ID_SECTION_REQUESTOR; ?>">
                                </div>
                            </div>
                            
                            <div class="form-group">
                                <label class="col-sm-3 control-label">Inspector</label>
                                <div class="col-sm-5">
                                    <input name="CHR_INSPECTOR" required class="form-control" type="text" style="width: 230px;" value="<?php echo $data_detail->CHR_REQUESTOR ?>" readonly>
                                </div>
                            </div>
                            
                            <div class="form-group">
                                <label class="col-sm-3 control-label">Section Before Process</label>
                                <div class="col-sm-3">
                                    <select name="INT_ID_SECTION_PIC" id="e1" class="form-control" onchange="getUser(value);">
                                        <?php foreach ($all_section as $isi) { ?>
                                            <option value="<?php echo $isi->INT_ID_SECTION; ?>"><?php echo $isi->CHR_SECTION.' - '.$isi->CHR_SECTION_DESC; ?></option>
                                        <?php } ?> 
                                    </select>
                                </div>
                            </div>
                            
                            <div class="form-group">
                                <label class="col-sm-3 control-label">PIC Before Process</label>
                                <div class="col-sm-3" >
                                    <select name='CHR_USERNAME' class='form-control' id="user_name"></select>
                                </div>
                            </div>

                            <div class="form-group">
                                <div class="col-sm-offset-3 col-sm-5">
                                    <div class="btn-group">
                                        <button type="submit" class="button button1" style="color: white; height:31px; width:80px;" data-placement="left" data-toggle="tooltip" title="Save this data"><i class="fa fa-check"></i> Save</button>
                                        <?php
                                        echo anchor('quality/quality_feedback_c/select_quality_problem_by_id/'.$data_detail->INT_ID, 'Cancel', 'class="btn btn-default" data-placement="right" data-toggle="tooltip" title="Back to manage"');
                                        ?>
                                    </div>
                                </div>
                            </div>
                        </form>
                        
                        <p><strong>NOTE : </strong></br> *  File gambar maksimal berukuran 910x380 (pixels) dengan maksimal file 3MB.</p>
                        
                    </div>
                </div>
            </div>
        </div>
        </div>
    </section>
</aside>

<script>
    $('#datepairExample .time').timepicker({
        'showDuration': true,
        'timeFormat': 'G:i'
    });

    $('#datepairExample .date').datepicker({
        'format': 'dd-mm-yyyy',
        'autoclose': true
    });

    $('#datepairExample').datepair();
</script>

<script>
    function getUser(value) {
        $.ajax({
            async: false,
            type: "POST",
            url: "<?php echo site_url('quality/quality_problem_c/get_user_by_dept'); ?>",
            data: "id_sect=" + value,
            success: function(data) {
                console.log(data);
                $("#user_name").html(data);
            }
        });
    }
    
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
    
    $(document).ready(function() {
      $(".popup_image").on('click', function() {
        w2popup.open({
          title : '<?php echo $data_detail->CHR_BACK_NO.' - '.$data_detail->CHR_QPROBLEM_TITLE ?>',
          width : 800, // width in px
          height: 800, // height in px
          body: '<div class="w2ui-centered"><img style="width:600px;height:600px;" src="' + $(this).attr('src') + '"></img></div>'
        });
      });
    });

</script>