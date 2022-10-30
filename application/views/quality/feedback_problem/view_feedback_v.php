<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
<script type="text/javascript" src="http://w2ui.com/src/w2ui-1.4.2.min.js"></script>
<link rel="stylesheet" type="text/css" href="http://w2ui.com/src/w2ui-1.4.2.min.css" />

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
    
    .button1:disabled{
        background-color: #83B3DC;
    }
</style>

<aside class="right-side">
    <section class="content-header">
        <ol class="breadcrumb">
            <li><a href="<?php echo base_url('index.php/home_c/') ?>">Home</a></li>
            <li><a href="<?php echo base_url('index.php/quality/quality_feedback_c/') ?>">Manage Feedback Problem</a></li>            
            <li><a href="#"><strong>View Feedback Problem</strong></a></li>
        </ol>
    </section>

    <section class="content">
        <?php
        if ($msg != NULL) {
            echo $msg;
        }
        ?>
        <div class="row">
            <div class="col-md-5">
                <div class="grid">
                    <div class="grid-header">
                        <i class="fa fa-folder-open"></i>
                        <span class="grid-title"><strong>PROBLEM DETAIL</strong></span>
                        <div class="pull-right grid-tools">
                            <a data-widget="collapse" title="Collapse"><i class="fa fa-chevron-up"></i></a>
                        </div>
                        <div class="pull-right">
                            <a href="<?php echo base_url('index.php/quality/quality_problem_c/export_new_tr') . '/' . $data_detail->INT_ID ?>"  class="btn btn-primary" style="font-size:11px;" data-placement="left" title="Print Detail TR"><i class="fa fa-download"></i> CAS</a>
                            <a href="<?php echo base_url('index.php/quality/quality_problem_c/export_tr') . '/' . $data_detail->INT_ID ?>"  class="btn btn-primary" style="font-size:11px;" data-placement="left" title="Print Detail TR"><i class="fa fa-download"></i> TR</a>
                        </div>                        
                    </div>
                    <div class="grid-body">
                        <table class="table table-condensed  display" cellspacing="0" width="100%">
                            <?php
                            if ($data_detail->INT_STATUS == 0) {
                                $status = 'Not Started';
                            } else if ($data_detail->INT_STATUS == 1) {
                                $status = 'On Progress';
                            } else if ($data_detail->INT_STATUS == 2){
                                $status = 'Complete';
                            } else {
                                $status = 'Closed';
                            }
                            
                            if ($data_detail->INT_FLG_REPEAT == 1) {
                                $repeat = 'Yes';
                            } else {
                                $repeat = 'No';
                            }
                            ?>
                            <tr>
                                <td>No Parent TR</td>
                                <td><?php 
                                    if($data_parent->CHR_TR_NO != $data_detail->CHR_TR_NO){ 
                                        echo $data_parent->CHR_TR_NO;
                                    } else { 
                                        echo "-";
                                    } ?></td>
                            </tr>
                            <tr>
                                <td>No TR</td>
                                <td><?php echo $data_detail->CHR_TR_NO; ?></td>
                            </tr>
                            <tr>
                                <td>Problem</td>
                                <td><?php echo $data_detail->CHR_QPROBLEM_TITLE; ?></td>
                            </tr>
                            <tr>
                                <td>Problem Desc</td>
                                <td><?php echo $data_detail->CHR_QPROBLEM_DESC; ?></td>
                            </tr>
                            <tr>
                                <td>Back No</td>
                                <td><?php echo $data_detail->CHR_BACK_NO; ?></td>
                            </tr>
                            <tr>
                                <td>Part Name</td>
                                <td><?php echo $data_detail->CHR_PART_NAME; ?></td>
                            </tr>
                            <tr>
                                <td>Class Problem</td>
                                <td><?php echo $data_detail->CHR_CLASS_PROBLEM; ?></td>
                            </tr>
                            <tr>
                                <td>Repeat Problem</td>
                                <td><?php echo $repeat; ?></td>
                            </tr>
                            <tr>
                                <td>Image Part NG</td>
                                <td><img class="btn popup_image" src="<?php echo base_url($data_detail->CHR_FILENAME); ?>" style ="width:100px; height:100px;"></td>
                            </tr>
                            <tr>
                                <td>Section Inspector</td>
                                <td><?php echo $data_detail->CHR_SECTION_REQ; ?></td>
                            </tr>
                            <tr>
                                <td>Inspector</td>
                                <td><?php echo $data_detail->CHR_REQUESTOR; ?></td>
                            </tr>
                            <tr>
                                <td>Section Before Process</td>
                                <td><?php echo $data_detail->CHR_SECTION_PIC; ?></td>
                            </tr>
                            <tr>
                                <td>PIC Before Process</td>
                                <td><?php echo $data_detail->CHR_PIC; ?></td>
                            </tr>
                            <tr>
                                <td>Qty Part NG</td>
                                <td><?php echo $data_detail->INT_QTY; ?></td>
                            </tr>
                            <tr>
                                <td>Defective Date</td>
                                <td><?php echo $data_detail->CHR_START_DATE; ?></td>
                            </tr>
                            <tr>
                                <td>Defective Time</td>
                                <td><?php echo date("H:i", strtotime($data_detail->CHR_START_TIME)); ?></td>
                            </tr>
                            <tr>
                                <td>Accepted Date</td>
                                <td><?php echo $data_detail->CHR_CREATED_DATE; ?></td>
                            </tr>
                            <tr>
                                <td>Accepted Time</td>
                                <td><?php echo date("H:i",strtotime($data_detail->CHR_CREATED_TIME)); ?></td>
                            </tr>
                            <tr>
                                <td>Due Date</td>
                                <td><?php echo $data_detail->CHR_DUE_DATE; ?></td>
                            </tr>
                            <tr>
                                <td>Due Time</td>
                                <td><?php echo date("H:i", strtotime($data_detail->CHR_DUE_TIME)); ?></td>
                            </tr>
                            <tr>
                                <td>Status</td>
                                <td style=" font-weight: bolder"><?php echo $status; ?></td>
                            </tr>
                        </table>
                        <?php 
                            echo anchor('quality/quality_feedback_c', 'Back', 'class="btn btn-default"');
                        ?>
                        
                        <?php
                        if ($data_detail->INT_STATUS != 3){
                            if($data_detail->INT_ID_CHILD == 0){
                                if ($user_logon == trim($data_detail->CHR_CREATED_BY)){
                                   echo "<a href='" . base_url('index.php/quality/quality_problem_c/edit_quality_problem') . "/" . $data_detail->INT_ID . "' class='btn btn-primary' data-placement='right'>Edit</a>"; 
                                }
                            }
                        } else {
                            if($data_detail->INT_ID_CHILD == 0){
                                if ($user_logon == trim($data_detail->CHR_CREATED_BY)){
                                   echo "<a href='" . base_url('index.php/quality/quality_feedback_c/open_problem') . "/" . $data_detail->INT_ID . "/" . $data_detail->INT_ID_PARENT . "' class='btn btn-primary' data-placement='right'>Open</a>"; 
                                }
                            }
                        }
                        ?> 
                        
                        <a href="<?php echo base_url('index.php/quality/quality_feedback_c/close_problem') . "/" . $data_detail->INT_ID . "/" . $data_detail->INT_ID_PARENT; ?>" class="btn btn-primary" data-placement="right" onclick="return confirm('Are you sure want to CLOSE this TR problem report?');"
                        <?php
                        if ($data_detail->INT_ID_CHILD != 0){
                            echo " disabled";
                        } else {
                            if ($user_logon != trim($data_detail->CHR_CREATED_BY)){                            
                                    echo " disabled";                            
                            } else {
                                if ($data_detail->INT_STATUS == 3){
                                    echo " disabled";
                                }
                            }
                        }
                        ?> 
                        >Close this TR</a>
                    </div>
                </div>
            </div>

            <div class="col-md-7">
                <div class="grid">
                    <div class="grid-header">
                        <i class="fa fa-edit"></i>
                        <span class="grid-title"><strong>CORRECTIVE ACTION</strong></span>
                        <div class="pull-right grid-tools">
                            <?php
                            if ($data_detail->INT_STATUS != 3){
                                $button = "<button data-toggle='modal' data-target='#modalfeedback" . $data_detail->INT_ID . "' data-placement='left' data-toggle='tooltip' title='Give Feedback' style='height:30px; width:120px; color:white;' class='button button1' disabled>Give Feedback</button>";
                                foreach ($user_respon as $user){
                                    if($user->CHR_NPK == $user_logon){
                                        $button = "<button data-toggle='modal' data-target='#modalfeedback" . $data_detail->INT_ID . "' data-placement='left' data-toggle='tooltip' title='Give Feedback' style='height:30px; width:120px; color:white;' class='button button1'>Give Feedback</button>";
                                    }
                                }
                                echo $button;
                            } else {
                                echo "<button data-toggle='modal' data-target='#modalfeedback" . $data_detail->INT_ID . "' data-placement='left' data-toggle='tooltip' title='Give Feedback' style='height:30px; width:120px; color:white;' class='button button1' disabled>Give Feedback</button>";
                            }
                            ?>
                            
                            <a href="<?php echo base_url('index.php/quality/quality_problem_c/create_inherit_tr') . "/" . $data_detail->INT_ID; ?>"  class="btn btn-primary" data-placement="left" title="Create Inheritance TR" style="height:30px; font-size:13px; width:120px; color:white;" 
                            <?php
                            $count_feedback = count($data_feedback);
                            
                                if($match_user_respon > 0){
                                    if($data_detail->INT_STATUS == 3){
                                        echo " disabled";
                                    } else {
                                        if ($count_feedback == 0){
                                            echo " disabled";
                                        } else {
                                            if($num_child != 0){
                                                echo " disabled";
                                            }
                                        }
                                    }
                                } else {
                                    echo " disabled";
                                }
                                
                            ?>>Create New TR</a>
                        </div>
                    </div>
                    <div class="grid-body">
                        <table id="example-1" class="table table-striped table-condensed table-hover display" cellspacing="0" width="100%">
                            <thead>
                                <tr>
                                    <th>No</th>
                                    <th>Feedback</th>
                                    <th>Evidence</th>
                                    <th>Date</th>
                                    <th>Time</th>
                                    <th>Status</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                $i = 1;
                                foreach ($data_feedback as $isi) {
                                    echo "<tr class='gradeX'>";
                                    echo "<td>$i</td>";
                                    echo "<td>$isi->CHR_FEEDBACK_DESC</td>";
                                    if($isi->CHR_FILEUPLOAD == NULL){
                                        echo "<td align='center'>No</td>";
                                    } else {
                                        echo "<td align='center'>Yes</td>";
                                    }
                                    echo "<td>$isi->CHR_CREATED_DATE</td>";
                                    echo "<td>$isi->CHR_CREATED_TIME</td>";
                                    echo "<td><strong>$isi->INT_ACTION_TYPE<strong></td>";
                                    ?>
                                <td>
                                    <a href="<?php echo base_url('index.php/quality/quality_feedback_c/view_detail_feedback') . "/" . $isi->INT_ID . "/" . $data_detail->INT_ID ?>" class="label label-primary" data-placement="right" title="View"><span class="fa fa-search"></span></a>
                                    <!--<a href="<?php // echo base_url('index.php/quality/quality_feedback_c/edit_feedback_problem') . "/" . $isi->INT_ID ?>" class="label label-warning" data-placement="top" data-toggle="tooltip" title="Edit"><span class="fa fa-pencil"></span></a>-->
                                    <?php
                                        //if ($user_logon != trim($isi->CHR_CREATED_BY)){
                                        //    echo " disabled";
                                        //}
                                        
                                        if ($match_user_respon != 0){
                                    ?> 
                                    <a href="<?php echo base_url('index.php/quality/quality_feedback_c/delete_feedback_problem') . "/" . $isi->INT_ID . "/" . $data_detail->INT_ID ?>" class="label label-danger" data-placement="right" title="Delete" onclick="return confirm('Are you sure want to delete this feedback?');"><span class="fa fa-times"></span></a>
                                    <?php } ?>
                                </td>
                                </tr>
                                <?php
                                $i++;
                            }
                            ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

            <!--CREATE FEEDBACK-->
            <div class="modal fade" id="modalfeedback<?php echo $data_detail->INT_ID ?>" tabindex="-1" role="dialog" aria-labelledby="modalLabelFeedback" aria-hidden="true" style="display: none;">
                <div class="modal-wrapper">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <div class="modal-header">
                                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                                <h4 class="modal-title" id="modalLabelFeedback"><strong>Give Corrective Action</strong></h4>
                            </div>
                            <div class="modal-body">
                                <?php echo form_open('quality/quality_feedback_c/send_feedback', 'class="form-horizontal" enctype="multipart/form-data"'); ?>
                                <input name="INT_ID_QPROBLEM" class="form-control" required type="hidden" style="width: 300px;" value="<?php echo $data_detail->INT_ID ?>">
                                <div class="form-group">
                                    <label class="col-sm-3 control-label">Cause Problem</label>
                                    <div class="col-sm-5">
                                        <select id="cause" name="INT_CAUSE_PROBLEM" class="form-control" style="width: 150px; font-weight: bold;">
                                            <option value="1" selected>Flow Out</option>
                                            <option value="2">Occurrence</option>
                                        </select>
                                    </div>
                                </div>
                                
                                <div class="form-group">
                                    <label class="col-sm-3 control-label">Action type</label>
                                    <div class="col-sm-5">
                                        <select name="INT_ACTION_TYPE" class="form-control" style="width: 150px; font-weight: bold;">
                                            <option value="1" selected>Temporary</option>
                                            <option id="fix_action" value="2" >Permanent</option>
                                        </select>
                                    </div>
                                </div>
                                
                                <div class="form-group">
                                    <label class="col-sm-3 control-label">Corrective Action</label>
                                    <div class="col-sm-5">
                                        <textarea rows="2" name="CHR_FEEDBACK_DESC" class="form-control" ></textarea>
                                    </div>
                                </div> 
                                
                                <div class="form-group">
                                    <label class="col-sm-3 control-label">Man Analysis</label>
                                    <div class="col-sm-5">
                                        <textarea rows="1" name="CHR_MAN_ANALYSIS" class="form-control" ></textarea>
                                    </div>
                                </div>
                                
                                <div class="form-group">
                                    <label class="col-sm-3 control-label">Material Analysis</label>
                                    <div class="col-sm-5">
                                        <textarea rows="1" name="CHR_MATERIAL_ANALYSIS" class="form-control" ></textarea>
                                    </div>
                                </div>
                                
                                <div class="form-group">
                                    <label class="col-sm-3 control-label">Machine Analysis</label>
                                    <div class="col-sm-5">
                                        <textarea rows="1" name="CHR_MACHINE_ANALYSIS" class="form-control" ></textarea>
                                    </div>
                                </div>
                                
                                <div class="form-group">
                                    <label class="col-sm-3 control-label">Methode Analysis</label>
                                    <div class="col-sm-5">
                                        <textarea rows="1" name="CHR_METHODE_ANALYSIS" class="form-control" ></textarea>
                                    </div>
                                </div>
                                
                                <div class="form-group"  id="file-name1">
                                    <label class="col-sm-3 control-label">Upload Evidence (Required)</label>
                                    <div class="col-sm-5">
                                        <input type="file" name="CHR_FILEUPLOAD" id="import" size="15" value="">
                                        <a href="<?php echo base_url("index.php/quality/quality_feedback_c/download_template_cm/" . $data_detail->INT_ID) ?>">Download Template C/M</a>
                                    </div>
                                </div>
                            </div>
                            <div class="modal-footer">
                                <div class="btn-group">
                                    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                                    <button id="btn-ok" type="submit" class="button button1" data-placement="left" title="Save this data" style="color:white; width:75px; height:28px;"><i class="fa fa-check"></i> Send</button>
                                    <?php
                                    echo form_close();
                                    ?>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>        
        <div class="row">
                <div class="col-md-12">
                    <div class="grid">
                        <div class="grid-header">
                            <i class="fa fa-table"></i>
                            <span class="grid-title"><strong>RELATED TECHNICAL REPORT (TR)</strong></span>
                            <div class="pull-right grid-tools">
                                <a data-widget="collapse" title="Collapse"><i class="fa fa-chevron-up"></i></a>
                            </div>
                        </div>
                        <div class="grid-body">
                            <table id="example" class="table table-striped table-condensed table-hover display" cellspacing="0" width="100%">
                                <thead>
                                    <tr>
                                        <th>No</th>
                                        <th>TR Type</th>
                                        <th>TR No</th>
                                        <th>Problem</th>                                    
                                        <th>Back No</th>
                                        <th>Part Name</th>
                                        <th>PIC (BP)</th>
                                        <th>Section (BP)</th>
                                        <th>Status</th>
                                        <th>Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    $i = 1;
                                    foreach ($data_related_tr as $isi) {
                                        echo "<tr class='gradeX'>";
                                        echo "<td>$i</td>";
                                        
                                        if ($isi->INT_ID_CHILD > $data_detail->INT_ID_CHILD) {
                                            echo "<td>Child</td>";
                                        } else {
                                            echo "<td>Parent</td>";
                                        }
                                            
                                        echo "<td>$isi->CHR_TR_NO</td>";
                                        echo "<td>$isi->CHR_QPROBLEM_TITLE</td>";                                    
                                        echo "<td>$isi->CHR_BACK_NO</td>";
                                        echo "<td>$isi->CHR_PART_NAME</td>";
                                        echo "<td>$isi->CHR_PIC</td>";
                                        echo "<td>$isi->CHR_SECTION_PIC</td>";
                                        
                                        if ($isi->INT_STATUS == 0) {
                                            $status = 'No Follow Up';
                                            if(date('Ymd') > $isi->CHR_DUE_DATE){
                                                echo "<td style='background-color: #E34234; color: white;'>$status</td>";
                                            } else {
                                                if(date('His') > $isi->CHR_DUE_TIME){
                                                    echo "<td style='background-color: #E34234; color: white;'>$status</td>";
                                                } else {
                                                    echo "<td style='background-color: #FFA812; color: white;'>$status</td>";
                                                }
                                            }
                                        } else if ($isi->INT_STATUS == 1) {
                                            $status = 'On Progress';
                                            echo "<td style='background-color: #FFA812; color: white;'>$status</td>";
                                        } else if (($isi->INT_STATUS == 2)) {
                                            $status = 'Complete';
                                            echo "<td style='background-color: #27DE55; color: white;'>$status</td>";
                                        } else {
                                            $status = 'Closed';
                                            echo "<td style='background-color: grey; color: white;'>$status</td>";
                                        }

                                        ?>
                                    <td>
                                        <a href="<?php echo base_url('index.php/quality/quality_feedback_c/select_quality_problem_by_id') . "/" . trim($isi->INT_ID); ?>" class="label label-primary" data-placement="left" title="View"><span class="fa fa-search" ></span></a>
                                        <?php
                                            if($user_logon == trim($isi->CHR_CREATED_BY)){                                                                          
                                        ?>
                                            <a href="<?php echo base_url('index.php/quality/quality_problem_c/delete_quality_problem') . "/" . trim($isi->INT_ID) ?>" class="label label-danger" data-placement="left" title="Delete" onclick="return confirm('Are you sure want to delete this TR?');"><span class="fa fa-times" ></span></a>
                                        <?php
                                            }
                                        ?>
                                    </td>
                                    </tr>
                                    <?php
                                    $i++;
                                }
                                ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
        </div>         
    </section>
</aside>

<script>
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
    
    $('#cause').on('change',function(){
        if( $(this).val()==="1"){
        $("#fix_action").hide()
        }
        else{
        $("#fix_action").show()
        }
    });
</script>