<style type="text/css">
    th, td { white-space: nowrap; }
    div.dataTables_wrapper {
        width: 100%;
        margin: 0 auto;
    }
    #table-luar{
        font-size: 12px;
    }
    #filter { 
        border-spacing: 10px;
        border-collapse: separate;
    }
    .td-fixed{
        width: 100px;
    }
    .ddl{
        width: 100px;
        height: 30px;
    }
    .ddl2{
        width: 180px;
        height: 30px;
    }
    .fileUpload {
        position: relative;
        overflow: hidden;
        width:100px;
        margin-left: 15px;
    }
    .fileUpload input.upload {
        position: absolute;
        top: 0;
        right: 0;
        margin: 0;
        padding: 0;
        font-size: 20px;
        cursor: pointer;
        opacity: 0;
        filter: alpha(opacity=0);
    }

    .input-upload{
        border:none;width:50px;background:transparent;
        text-align: right;
    }
</style>
<style>
/* The container */
.container-radio {
    /* display: block; */
    position: relative;
    padding-left: 30px;
    font-weight:400;
    cursor: pointer;
    /* font-size: 10pt; */
    -webkit-user-select: none;
    -moz-user-select: none;
    -ms-user-select: none;
}

/* Hide the browser's default radio button */
.container-radio input {
    position: absolute;
    opacity: 0;
    cursor: pointer;
}

/* Create a custom radio button */
.checkmark {
    position: absolute;
    top: 0;
    left: 0;
    height: 20px;
    width: 20px;
    background-color: #ccc;
    border-radius: 50%;
    /* margin-top: 22px; */
}

/* On mouse-over, add a grey background color */
.container-radio:hover input ~ .checkmark {
    background-color: darkgrey;
}

/* When the radio button is checked, add a blue background */
.container-radio input:checked ~ .checkmark {
    background-color: #2196F3;
}

/* Create the indicator (the dot/circle - hidden when not checked) */
.checkmark:after {
    content: "";
    position: absolute;
    display: none;
}

/* Show the indicator (dot/circle) when checked */
.container-radio input:checked ~ .checkmark:after {
    display: block;
}

/* Style the indicator (dot/circle) */
.container-radio .checkmark:after {
    top: 5px;
    left: 5px;
    width: 10px;
    height: 10px;
    border-radius: 50%;
    background: white;
}
</style>


<aside class="right-side">

    <section class="content-header">
        <ol class="breadcrumb">
            <li><a href="<?php echo base_url('index.php/home_c/"') ?>">Home</a></li>
            <li><a href="<?php echo base_url('index.php/prd/schedule_kanban_c/"') ?>">Manage Schedule Kanban</a></li>
            <li class="active"> <a href="#"><strong>Upload Schedule Kanban</strong></a></li>
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
                        <i class="fa fa-upload"></i>
                        <span class="grid-title"><strong>UPLOAD SCHEDULE KANBAN</strong></span>
                        <div class="pull-right grid-tools">
                               <a  href="<?php echo base_url('index.php/prd/schedule_kanban_c/download_template_schedule_kanban') ?>"  name="btn-download" data-toggle="tooltip" data-placement="right" title="Download template"><i class="fa fa-download"></i>&nbsp; Download Template</a>
                        </div>
                    </div>
                    <div class="grid-body" style="padding-top: 25px;">
                    <?php echo form_open_multipart('prd/schedule_kanban_c/upload_schedule_kanban', 'class="form-horizontal"');?>
                        
                        <div class="pull" style="margin-top: -20px;">
                            <table width="100%" id='filter' border=0>
                                <tr>
                                    <td width="10%" style='text-align:left;' ><strong>Periode</strong></td>
                                    <td width="25%">
                                        <select class="ddl" id="tanggal" name="CHR_PERIOD" onchange="document.getElementById('id_period').value=this.options[this.selectedIndex].value; document.getElementById('period_strong').value=this.options[this.selectedIndex].value;">
                                            <?php for ($x = -1; $x <= 5; $x++) { ?>
                                                <option value="<?php echo date("Ym", strtotime("+$x month")); ?>" <?php
                                                if ($period == date("Ym", strtotime("+$x month"))) {
                                                    echo 'SELECTED';
                                                }
                                                ?> > <?php echo date("M Y", strtotime("+$x month")); ?> </option>
                                                    <?php } ?>
                                        </select>
                                    </td>
                                    <td width="20%" style='text-align:left;display:none;' colspan="4">
                                    </td>
                                   
                                    <td width="20%"></td>
                                   
                                    <td width="5%" style='text-align:right;'>
                                        
                                    </td>
                                    <td width="50%" style='text-align:right;'>
                                       
                                    </td>
                                   
                            </table>
                        </div>

                        <input type="hidden" name="INT_ID_DEPT" id="id_dept" value="<?php echo $id_dept; ?>"></input>
                        <input type="hidden" name="CHR_WORK_CENTER" id="id_work_center" value="<?php echo $work_center; ?>"></input>
                        
                        <div class="pull" style="margin-top: -15px;">
                            <table width="100%" id='filter' border=0>
                                <tr>
                                <td width="10%" style='text-align:left;' ><strong>File (.xlsx)</strong></td>
                                    <td width="27%" style='text-align:left;' colspan="3">
                                        <input type="file" name="upload_schedule" class="form-control" id="import" required> 
                                    </td>
                                    <td width="43%">
                                        <button style="margin-left:-5px;margin-top:4px;" type="submit" name="submit" class="btn btn-primary" data-toggle="tooltip" data-placement="right" title="Lets Processing data"><i class="fa fa-upload"></i> Check Upload</button>
                                    </td>
                                    <td width="10%" style='text-align:right;'> </td>
                                    <td width="10%" style='text-align:right;'> </td>
                            </table>
                        </div>


                    </div >
                    
                    <?php echo form_close(); ?>
                    <?php echo form_open('prd/schedule_kanban_c/save_schedule_kanban', 'class="form-horizontal"'); ?>

                    <div class="grid-body" style="padding-top: 0px">
                        <div id="table-luar">
                             <table id="example2" class="table table-condensed table-striped table-hover display" cellspacing="0" width="100%">
                                <thead>
                                    <tr>
                                    <th style="text-align:center;">No</th>
                                        <th style="white-space:pre-wrap ; word-wrap:break-word;text-align:center;">Row Excel</th>
                                        <th style="text-align:center;">Work Center</th>
                                        <th style="text-align:center;">Part No</th>
                                        <th style="text-align:center;">Date</th>
                                        <th style="white-space:pre-wrap ; word-wrap:break-word;text-align:center;">Max Lot</th>
                                        <th style="white-space:pre-wrap ; word-wrap:break-word;text-align:center;">Lot Size</th>
                                        <th style="text-align:center;">Qty/Box</th>
                                        <th style="text-align:center;">Total Qty Pcs</th>
                                        <th style="text-align:center;display:none;">Flag Delete</th>
                                        <th style="text-align:center;display:none;">Flg SO</th>
                                        <th style="text-align:center;">Special Order</th>
                                        <th style="white-space:pre-wrap ; word-wrap:break-word;text-align:center;">Error Message</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php

                                    $x = 1;
                                    $row_excel = null;
                                    for($y = 0; $y < $increment; $y++){
                                        $type = 'text';
                                        if($row_excel == $data[$y]['INT_SEQUENCE']){
                                            $type = 'hidden';
                                        }
                                        $row_excel = $data[$y]['INT_SEQUENCE'];
                                        ?>

                                        <tr class='gradeX'  <?php if($data[$y]['INT_FLG_SO'] == 1){ echo 'style="color:red;"';}  ?>>
                                            <td><?php echo $x ?></td> 
                                            <td style="text-align:center;">
                                                <input readonly name="tableRow[<?php echo $y; ?>][INT_SEQUENCE]" type='<?php echo $type; ?>' value="<?php echo $data[$y]['INT_SEQUENCE'];?>"  style='border:none;width:50px;background:transparent;text-align:center;'></input>
                                            </td >
                                            
                                            <td style="text-align:center;">
                                                <input readonly name="tableRow[<?php echo $y; ?>][CHR_WORK_CENTER]" type='text' value="<?php echo $data[$y]['CHR_WORK_CENTER'];?>"  style='border:none;width:50px;background:transparent;text-align:center;'></input>
                                            </td>
                                            <td style="text-align:center;">
                                                <input readonly name="tableRow[<?php echo $y; ?>][CHR_PART_NO]" type='text' value="<?php echo $data[$y]['CHR_PART_NO'];?>"  style='border:none;width:150px;background:transparent;text-align:center;'></input>
                                            </td>
                                            <td style="text-align:center;">
                                                <input readonly name="tableRow[<?php echo $y; ?>][CHR_DATE]" type='text' value="<?php echo $data[$y]['CHR_DATE'];?>"  style='border:none;width:150px;background:transparent;text-align:center;'></input>
                                            </td>
                                            <td style="text-align:center;">
                                                <input readonly name="tableRow[<?php echo $y; ?>][MAX_LOT_SIZE]" type='text' value="<?php echo $data[$y]['MAX_LOT_SIZE'];?>"  style='border:none;width:50px;background:transparent;text-align:center;'></input>
                                            </td>
                                            <td style="text-align:center;">
                                                <input readonly name="tableRow[<?php echo $y; ?>][INT_LOT_SIZE]" type='text' value="<?php echo $data[$y]['INT_LOT_SIZE'];?>"  style='border:none;width:50px;background:transparent;text-align:center;'></input>
                                            </td>
                                            <td style="text-align:center;">
                                                <input readonly name="tableRow[<?php echo $y; ?>][INT_QTY_PER_BOX]" type='text' value="<?php echo $data[$y]['INT_QTY_PER_BOX'];?>"  style='border:none;width:50px;background:transparent;text-align:center;'></input>
                                            </td>
                                            <td style="text-align:center;">
                                                <input readonly name="tableRow[<?php echo $y; ?>][INT_QTY_PCS]" type='text' value="<?php echo $data[$y]['INT_QTY_PCS'];?>"  style='border:none;width:50px;background:transparent;text-align:center;'></input>
                                            </td>
                                            <td style="display:none;">
                                                <input readonly name="tableRow[<?php echo $y; ?>][FLG_DELETE]" type='text' value="<?php echo $data[$y]['FLG_DELETE'];?>"  style='border:none;width:50px;background:transparent;text-align:center;'></input>
                                            </td>

                                            <?php

                                            if ($data[$y]['FLG_DELETE'] == 1){
                                                $stat = "background:#FE2D45;color:#fff";
                                            }else{
                                                $stat = "background:#55D785;color:#fff";
                                            }
                                            
                                            if ($data[$y]['ERROR_MESSAGE'] != NULL){
                                                $stat = "background:#FE2D45;color:#fff";
                                            }else{
                                                $stat = "background:#55D785;color:#fff";
                                            }
                                            
                                            if ($data[$y]['INT_FLG_SO'] == 1){
                                                $so = "Yes";
                                            }else{
                                                $so = "-";
                                            }                                            
                                            ?>
                                            
                                            <td style="display:none;">
                                                <input readonly name="tableRow[<?php echo $y; ?>][INT_FLG_SO]" type='text' value="<?php echo $data[$y]['INT_FLG_SO'];?>"  style='border:none;width:50px;background:transparent;text-align:center;'></input>
                                            </td>                                            
                                            <td style="text-align:center;">
                                                <input readonly name="" type='text' value="<?php echo $so;?>"  style='border:none;width:50px;background:transparent;text-align:center;'></input>
                                            </td>
                                                                                        
                                            <?php

                                            if ($data[$y]['ERROR_MESSAGE']){
                                                echo "<td style='$stat;white-space:pre-wrap ; word-wrap:break-word;text-align:left'><strong>".$data[$y]['ERROR_MESSAGE']."</strong></td>";
                                            }else{
                                                echo "<td style='background:#55D785;color:#fff;white-space:pre-wrap ; word-wrap:break-word;text-align:left'><strong>-</strong></td>";
                                            }
                                            
                                        echo "</tr>";
                                      
                                        $x++;
                                    }
                                    ?>
                                </tbody>
                            </table> 
                        </div>
                        
                        <div style="width: 30%;float:right;">
                            <table width="100%" id='filter' border=0px style="outline: thin ridge #DDDDDD">
                                <tr>
                                    <td width="3%" style='text-align:left;' colspan="4"><strong>L e g e n d   : </strong></td>
                                    <td width="10%">
                                        <button disabled style='border:0;background:#FE2D45;width:25px;height:25px;color:white;'></button> : Failed 
                                    </td>
                                    <td width="10%">
                                        <button disabled style='border:0;background:#55D785;width:25px;height:25px;color:white;'></button> : Success
                                    </td>
                                </tr>
                            </table>
                        </div>
                        <br>

                        
                            <input type="hidden" name="CHR_PERIOD" id="id_period" value="<?php echo $period; ?>"></input>
                            <input type="hidden" name="INT_ID_DEPT" id="id_dept" value="<?php echo $id_dept; ?>"></input>
                            <input type="hidden" name="CHR_WORK_CENTER" id="id_work_center" value="<?php echo $work_center; ?>"></input>

                                <?php if ($data == true) { ?>
                                    <button type="submit" name="submit" class="btn btn-success" value="1"  data-toggle="tooltip" data-placement="right" title="Save this data" style="width:180px;" onclick='return confirm("Data yang bermasalah tidak akan disimpan, melanjutkan perintah ?")'><i class="fa fa-check"></i> Save</button>
                                    <a href="<?php echo base_url('index.php/prd/schedule_kanban_c/search_schedule_kanban/' . $period . '/' . $id_dept . '/' . $work_center) ?>" class="btn btn-default" data-toggle="tooltip" data-placement="left" title="Back">Back</a>
                                <?php } else { ?>
                                    <button type="submit" name="submit" disabled class="btn btn-success" data-toggle="tooltip" data-placement="right" title="Save this data" style="width:180px;" onclick='return confirm("Data yang bermasalah tidak akan disimpan, melanjutkan perintah ?")'><i class="fa fa-check"></i> Save</button>
                                    <a href="<?php echo base_url('index.php/prd/schedule_kanban_c/search_schedule_kanban/' . $period . '/' . $id_dept . '/' . $work_center) ?>" class="btn btn-default" data-toggle="tooltip" data-placement="left" title="Back">Back</a>
                                <?php } ?>

                            <?php echo form_close(); ?>

                    </div>
                </div>
            </div>
        </div>
    </section>
</aside>
<

<script type="text/javascript" language="javascript">
            $("#upload").fileinput({
                'showUpload': false
            });
</script>

<script type="text/javascript" language="javascript">

function get_data_work_center(){
    var dept_to_work_center = document.getElementById('dept_to_work_center').value;

    $.ajax({
        async: false,
        type: "POST",
        dataType: 'json',
        url: "<?php echo site_url('prd/direct_backflush_general_c/get_work_center_by_id_dept'); ?>",
        data:  {
                INT_ID_DEPT: dept_to_work_center
                },
        success: function (json_data) {
            $("#work_center").html(json_data['data']);
        },
        error: function (request) {
            alert(request.responseText);
        }
    });
}
</script>


<script src="<?php echo base_url('assets/js/jquery-1.12.3.js') ?>"></script>
<script src="<?php echo base_url('assets/js/jquery.dataTables.min.js') ?>"></script>
<script src="<?php echo base_url('assets/js/dataTables.fixedColumns.min.js') ?>"></script>
<link rel="stylesheet" href="<?php echo base_url('assets/css/fixedColumns.dataTables.min.css'); ?>" >
<script>

                                                            $(document).ready(function () {
                                                    var table = $('#example2').DataTable({
                                                    scrollY: "250px",
                                                            scrollX: true,
                                                            scrollCollapse: true,
                                                            paging: false,
                                                            bFilter: false,
                                                            fixedColumns: {
                                                            rightColumns: 0
                                                            }
                                                    });
                                                    });

</script>