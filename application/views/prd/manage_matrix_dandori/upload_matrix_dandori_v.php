<style type="text/css">
    th, td { white-space: nowrap; }
    div.dataTables_wrapper {
        width: 100%;
        margin: 0 auto;
    }
    #table-luar{
        font-size: 11px;
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
            <li><a href="<?php echo base_url('index.php/prd/lot_kanban_c/"') ?>">Manage Matrix Dandori Parts</a></li>
            <li class="active"> <a href="#"><strong>Matrix Dandori Parts</strong></a></li>
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
                        <span class="grid-title"><strong>UPLOAD MATRIX DANDORI PARTS</strong></span>
                        <div class="pull-right grid-tools">
                               <a  href="<?php echo base_url('index.php/prd/manage_matrix_dandori_c/download_template_matrix_dandori') ?>"  name="btn-download" data-toggle="tooltip" data-placement="right" title="Download template"><i class="fa fa-download"></i>&nbsp; Download Template</a>
                        </div>
                    </div>
                    <div class="grid-body" style="padding-top: 25px;">
                    <?php echo form_open_multipart('prd/manage_matrix_dandori_c/upload_matrix_dandori', 'class="form-horizontal"');?>
                        
                    <input name="INT_ID_DEPT" class="form-control" id='dept_id' type="hidden" style="width: 300px;" value="<?php echo trim($id_dept) ?>">
                    <input name="CHR_WORK_CENTER" class="form-control" id='work_center_id' type="hidden" style="width: 300px;" value="<?php echo trim($work_center) ?>">

                        <div class="pull" style="margin-top: -20px;">
                            <table width="100%" id='filter' border=0>
                                <tr>
                                    <td width="10%" style='text-align:left;' ></td>
                                    <td width="25%">
                                    </td>
                                    <td width="20%" style='text-align:left;display:none;' colspan="4">
                                    </td>
                                   
                                    <td width="20%"></td>
                                   
                                    <td width="5%" style='text-align:right;'>
                                        <strong></strong>       
                                    </td>
                                    <td width="50%" style='text-align:right;'>
                                       
                                    </td>
                                   
                            </table>
                        </div>
                        
                        <div class="pull" style="margin-top: -15px;">
                            <table width="100%" id='filter' border=0>
                                <tr>
                                <td width="10%" style='text-align:left;' ><strong>File (.xlsx)</strong></td>
                                    <td width="27%" style='text-align:left;' colspan="3">
                                        <input type="file" name="upload_matrix_dandori" class="form-control" id="import" required> 
                                    </td>
                                    <td width="43%">
                                        <button style="margin-left:-5px;margin-top:4px;" type="submit" name="submit" class="btn btn-primary" data-toggle="tooltip" data-placement="right" title="Lets Processing data"><i class="fa fa-upload"></i> Check Upload</button>
                                    </td>
                                    <td width="10%" style='text-align:right;'> </td>
                                    <td width="10%" style='text-align:right;'> </td>
                            </table>
                        </div>


                    </div >
                    <!-- 32150020150P0 -->
                    <?php echo form_close(); ?>
                    <?php echo form_open('prd/manage_matrix_dandori_c/save_upload_matrix_dandori', 'class="form-horizontal"'); ?>

                    <input name="INT_ID_DEPT" class="form-control" id='dept_id' type="hidden" style="width: 300px;" value="<?php echo trim($id_dept) ?>">
                    <input name="CHR_WORK_CENTER" class="form-control" id='work_center_id' type="hidden" style="width: 300px;" value="<?php echo trim($work_center) ?>">

                    <div class="grid-body" style="padding-top: 0px">
                             <table id="dataTables3" class="table table-condensed table-striped table-hover display" cellspacing="0" width="100%">
                                <thead>
                                    <tr>
                                        <th style="vertical-align: middle;text-align:center;">No</th>
                                        <th style="vertical-align: middle;text-align:center;">Part No</th>
                                        <th style="white-space:pre-wrap ; word-wrap:break-word;vertical-align: middle;text-align:center;">Dandori Group</th>
                                        <th style="vertical-align: middle;text-align:center;display:none;">Flag delete</th>
                                        <th style="vertical-align: middle;text-align:center;">Error message</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php

                                    $x = 1;
                                    for($y = 0; $y < $increment; $y++){
                                        ?>

                                        <tr class='gradeX'>
                                            <td><?php echo $x ?></td> 
                                            <td>
                                                <input readonly name="tableRow[<?php echo $y; ?>][CHR_PART_NO]" type='text' value="<?php echo $data[$y]['CHR_PART_NO'];?>"  style='border:none;width:150px;background:transparent;'></input>
                                            </td>
                                            <td >
                                                <input readonly name="tableRow[<?php echo $y; ?>][CHR_MATRIX_DANDORI]" type='text' value="<?php echo $data[$y]['CHR_MATRIX_DANDORI'];?>"  style='border:none;width:50px;background:transparent;'></input>
                                            </td>
                                            <td style="display:none;">
                                                <input readonly name="tableRow[<?php echo $y; ?>][FLG_DELETE]" type='text' value="<?php echo $data[$y]['FLG_DELETE'];?>"  style='border:none;width:50px;background:transparent;'></input>
                                            </td>
                                            <td style="display:none;">
                                                <input readonly name="tableRow[<?php echo $y; ?>][ERROR_MESSAGE]" type='text' value="<?php echo $data[$y]['FLG_DELETE'];?>"  style='border:none;width:50px;background:transparent;'></input>
                                            </td>
                                            
                                            <?php
                                            if ($data[$y]['FLG_DELETE'] == 1){
                                                $stat = "background:#FE2D45;color:#fff";
                                            } else {
                                                $stat = "background:#55D785;color:#fff";
                                            }
                                            
                                            if ($data[$y]['ERROR_MESSAGE'] != NULL){
                                                $stat = "background:#FE2D45;color:#fff";
                                            } else {
                                                $stat = "background:#55D785;color:#fff";
                                            }

                                            if ($data[$y]['ERROR_MESSAGE']){
                                                echo "<td style='$stat;vertical-align: middle;text-align:center'><strong>".$data[$y]['ERROR_MESSAGE']."</strong></td>";
                                            } else {
                                                echo "<td style='background:#55D785;color:#fff;vertical-align: middle;text-align:center'><strong>-</strong></td>";
                                            }
                                            
                                        echo "</tr>";
                                      
                                        $x++;
                                    }
                                    ?>
                                </tbody>
                            </table> 

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
                            
                                <?php if ($data == true) { ?>
                                    <button type="submit" name="submit" class="btn btn-success" value="1"  data-toggle="tooltip" data-placement="right" title="Save this data" style="width:150px;" onclick='return confirm("Data yang bermasalah tidak akan disimpan, melanjutkan perintah ?")'><i class="fa fa-check"></i> Save</button>
                                    <a href="<?php echo base_url('index.php/prd/manage_matrix_dandori_c') ?>" class="btn btn-default" data-toggle="tooltip" data-placement="left" title="Back">Back</a>
                                <?php } else { ?>
                                    <button type="submit" name="submit" disabled class="btn btn-success" data-toggle="tooltip" data-placement="right" title="Save this data" style="width:150px;" onclick='return confirm("Data yang bermasalah tidak akan disimpan, melanjutkan perintah ?")'><i class="fa fa-check"></i> Save</button>
                                    <a href="<?php echo base_url('index.php/prd/manage_matrix_dandori_c') ?>" class="btn btn-default" data-toggle="tooltip" data-placement="left" title="Back">Back</a>
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