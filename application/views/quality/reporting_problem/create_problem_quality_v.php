
<script src="<?php echo base_url('assets/datetimepicker/jquery.timepicker.js') ?>"></script>
<link rel="stylesheet" href="<?php echo base_url('assets/datetimepicker/jquery.timepicker.css'); ?>" >
<script src="<?php echo base_url('assets/datetimepicker/lib/bootstrap-datepicker.js') ?>"></script>
<link rel="stylesheet" href="<?php echo base_url('assets/datetimepicker/lib/bootstrap-datepicker.css'); ?>" >

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
                        <form method="post" action="<?php echo site_url("quality/quality_problem_c/save_quality_problem") ?>" class="form-horizontal" enctype="multipart/form-data" role="form">
                            <div class="form-group">
                                <label class="col-sm-3 control-label">Input by</label>
                                <div class="col-sm-3">
                                    <input type="radio" onclick="javascript:CheckInput();" name="CHR_TYPE" id="inp_1" value="1"> &nbsp; Back No &nbsp;
                                    <input type="radio" onclick="javascript:CheckInput();" name="CHR_TYPE" id="inp_2" value="2"> &nbsp; Part No
                                </div>
                            </div>
                            <div class="form-group" id="group_1" style=" display: none;">
                                <label class="col-sm-3 control-label">Back No</label>
                                <div class="col-sm-2">
                                    <select name="CHR_BACK_NO" id="e1" class="form-control" onchange="getPartName(value);">
                                        <?php foreach ($all_back_no as $isi) { ?>
                                            <option value="<?php echo $isi->CHR_BACK_NO; ?>"><?php echo $isi->CHR_BACK_NO; ?></option>
                                        <?php } ?> 
                                    </select>
                                </div>
                            </div>
                            
                            <div class="form-group" id="group_2" style=" display: none;">
                                <label class="col-sm-3 control-label">Part No</label>
                                <div class="col-sm-2">
                                    <select name="CHR_PART_NO" id="e2" class="form-control" onchange="getPartName(value);">
                                        <?php foreach ($all_back_no as $isi) { ?>
                                            <option value="<?php echo $isi->CHR_BACK_NO; ?>"><?php echo $isi->CHR_PART_NO; ?></option>
                                        <?php } ?> 
                                    </select>
                                </div>
                            </div>
                            
                            <div class="form-group">
                                <label class="col-sm-3 control-label">Part Name</label>
                                <div class="col-sm-2">
                                    <input name="CHR_PART_NAME" readonly id="part_name" class='form-control' type="text" style="width: 300px;">
                                </div>
                            </div>

                            <div class="form-group">
                                <label class="col-sm-3 control-label">Problem Type</label>
                                <div class="col-sm-3">
                                    <select name="CHR_QPROBLEM_TITLE" class="form-control">
                                        <?php foreach ($all_list_problem as $isi) { ?>
                                            <option value="<?php echo $isi->CHR_PROBLEM; ?>"><?php echo $isi->CHR_PROBLEM; ?></option>
                                        <?php } ?> 
                                    </select>
                                </div>
                            </div>

                            <div class="form-group">
                                <label class="col-sm-3 control-label">Detail of Problem</label>
                                <div class="col-sm-5">
                                    <textarea rows="4" cols="50" name="CHR_QPROBLEM_DESC" required class="form-control" ></textarea>
                                </div>
                            </div>
                            
                            <div class="form-group">
                                <label class="col-sm-3 control-label">Class Problem</label>
                                <div class="col-sm-5">
                                    <input type="radio" class="icheck" name="CHR_CLASS_PROBLEM" value="Visual Part"> &nbsp; Visual Part</br>
                                    <input type="radio" class="icheck" name="CHR_CLASS_PROBLEM" value="Function Part"> &nbsp; Function Part</br>
                                    <input type="radio" class="icheck" name="CHR_CLASS_PROBLEM" value="Dimension Part"> &nbsp; Dimension Part</br>
                                    <input type="radio" class="icheck" name="CHR_CLASS_PROBLEM" value="General Problem"> &nbsp; General Problem</br>
                                </div>
                            </div>
                            
                            <div class="form-group">
                                <label class="col-sm-3 control-label">Repeat Problem</label>
                                <div class="col-sm-5">
                                    <input type="radio" class="icheck" name="INT_FLG_REPEAT" value="0"> &nbsp; No</br>
                                    <input type="radio" class="icheck" name="INT_FLG_REPEAT" value="1"> &nbsp; Yes</br>                                    
                                </div>
                            </div>
                            
                            <div class="form-group">
                                <label class="col-sm-3 control-label">Defect Qty</label>
                                <div class="col-sm-1">
                                    <input name="INT_QTY" required class="form-control" onkeyup="angka(this);" type="text" style="width: 80px;">
                                </div>
                                <div class="col-sm-2">
                                    <select name="CHR_UNIT" class="form-control">
                                        <option value="PCS">PCS</option>
                                        <option value="KANBAN">KANBAN</option>
                                    </select>
                                </div>
                            </div>
                            
                            <div class=" form-group" id="file-name1">
                                <label class="col-sm-3 control-label">Upload Image <span style="color:red">*</span></label>
                                <div class="col-sm-5">
                                    <input type="file" name="file" id="import" size="20"  value="">
                                </div>
                            </div>

                            <div id="datepairExample">
                                <div  class="form-group">
                                    <label class="col-sm-3 control-label">Defective Date</label>
                                    <div class="col-sm-3">
                                        <div class="input-group" >
                                            <input type="text" class="form-control date start" autocomplete="off" name="CHR_START_DATE" value='<?php echo date('d-m-Y'); ?>'>
                                            <span class="input-group-addon"><i class="fa fa-calendar"></i></span>
                                        </div>
                                    </div>
                                    <div class="col-sm-2">
                                        <div class="input-group">
                                            <input type="text" class="form-control time start" autocomplete="off" name="CHR_START_TIME" value='<?php echo date('H:i'); ?>'>
                                            <span class="input-group-addon"><i class="fa fa-clock-o"></i></span>
                                        </div>
                                    </div>
                                </div>

                                <!--                                <div  class="form-group" >
                                                                    <label class="col-sm-3 control-label">Due Date</label>
                                                                    <div class="col-sm-3">
                                                                        <div class="input-group" data-date-format="HH:ii" >
                                                                            <input type="text" class="form-control date end" autocomplete="off" name="CHR_DUE_DATE" value='<?php echo date('d-m-Y'); ?>'>
                                                                            <span class="input-group-addon"><i class="fa fa-calendar"></i></span>
                                                                        </div>
                                                                    </div>
                                                                    <div class="col-sm-2">
                                                                        <div class="input-group">
                                                                            <input type="text" class="form-control time end" autocomplete="off" name="CHR_DUE_TIME" value='<?php echo date('H:i'); ?>'>
                                                                            <span class="input-group-addon"><i class="fa fa-clock-o"></i></span>
                                                                        </div>
                                                                    </div>
                                                                </div>-->
                            </div>   
                            
                            <div class="form-group">
                                <label class="col-sm-3 control-label">Inspector Section</label>
                                <div class="col-sm-3">
                                    <input name="INT_ID_SECTION_REQUESTOR" value="<?php echo $inspector_sect->CHR_SECTION.' - '.$inspector_sect->CHR_SECTION_DESC; ?>" readonly class='form-control' required type="text" style="width: 230px;">
                                </div>
                            </div>
                            
                            <div class="form-group">
                                <label class="col-sm-3 control-label">Inspector</label>
                                <div class="col-sm-5">
                                    <input name="CHR_INSPECTOR" required class="form-control" type="text" style="width: 230px;">
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
                                        <button type="submit" class="btn btn-primary" data-placement="left" data-toggle="tooltip" title="Save this data"><i class="fa fa-check"></i> Save</button>
                                        <?php
                                        echo anchor('quality/quality_feedback_c', 'Cancel', 'class="btn btn-default" data-placement="right" data-toggle="tooltip" title="Back to manage"');
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
    function getPartName(value) {
        $.ajax({
            async: false,
            type: "POST",
            url: "<?php echo site_url('quality/quality_problem_c/get_part_name'); ?>",
            data: "back_no=" + value,
            success: function(data) {
                $("#part_name").val(data);
            }
        });
    }
    
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
    
    function CheckInput() {
        if (document.getElementById('inp_1').checked) {
            document.getElementById('group_1').style.display = 'block';
            document.getElementById('group_2').style.display = 'none';
        } else {
            document.getElementById('group_1').style.display = 'none';
            document.getElementById('group_2').style.display = 'block';
        }
    }
</script>