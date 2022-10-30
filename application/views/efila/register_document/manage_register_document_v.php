<aside class="right-side">
    <section class="content-header">
        <ol class="breadcrumb">
            <li><a href="<?php echo base_url('index.php/basis/home_c/"') ?>"><span>Home</span></a></li>
            <li> <a href="#"><strong>Manage Register Document</strong></a></li>
        </ol>
    </section>
    <script>
        setTimeout(function () {
            document.getElementById("hide-sub-menus").click();
        }, 10);
    </script>
    <section class="content">
        <?php if ($msg != NULL) {
            echo $msg;
        } ?>

        <div class="row">
            <div class="col-md-12">
                <div class="grid">
                    <div class="grid-header">
                        <i class="fa fa-sitemap"></i>
                        <span class="grid-title"><strong>REGISTER DOCUMENT</strong> TABLE</span>
                        <div class="pull-right">
                            <a href="<?php echo base_url('index.php/efila/register_document_c/create_register_document/') ?>" class="btn btn-default" data-placement="left" title="Apply Register Document" style="height:30px;font-size:13px;width:auto;">New Register Document</a>
                        </div>
                    </div>
                    <div class="grid-body">
                        <table id="dataTables1" class="table table-striped table-condensed table-hover display" cellspacing="0" width="100%">
                            <thead>
                                <tr>
                                    <th>No</th>
                                    <th>Id Register</th>
                                    <th>No Document</th>
                                    <th>Document Name</th>
                                    <th>Document Desc</th>
                                    <th>Category</th>
                                    <!-- <th>Document</th> -->
                                    <th>Created By</th>
                                    <th>Created Date</th>
                                    <th>Info</th>
                                    <th>Status</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                $i = 1;
                                foreach ($data as $isi) {
                                    echo "<tr class='gradeX'>";
                                    echo "<td>$i</td>";
                                    echo "<td>Reg-".$isi->INT_ID_REGISTER."</td>";
                                    echo "<td>$isi->CHR_NO_DOC</td>";
                                    echo "<td>$isi->CHR_DOCUMENT_NAME</td>";
                                    echo "<td>$isi->CHR_DOCUMENT_DESC</td>";
                                    echo "<td>$isi->CHR_CATEGORY_NAME</td>";
                                    ?>
                                    <!-- <td><a target="_blank" href="<?php echo base_url('index.php/efila/register_document_c/view_doc') . "/" . $isi->CHR_DOC; ?>"><?php echo $isi->CHR_DOC; ?></a></td> -->
                                    <?php
                                    echo "<td>$isi->CHR_CREATED_BY</td>";
                                    $tgl = $isi->CHR_CREATED_DATE; 
                                    $date = date("d-m-Y", strtotime($tgl));
                                    echo "<td>$date</td>";
                                    echo "<td>$isi->CHR_INFO</td>";
                                    if($isi->CHR_CATEGORY_NAME != "STD"){
                                        if($isi->INT_APPROVED_MANAGER == 1){
                                            if($isi->INT_APPROVED_GM == 1){
                                                if($isi->INT_APPROVED_MSU == 1){
                                                    ?>
                                                    <td style="white-space:pre-wrap ; word-wrap:break-word;vertical-align: middle;text-align:center;background: GREEN; color: white;">Approved By MSU</td>
                                                    <?php
                                                } elseif ($isi->INT_APPROVED_MSU === 0) {
                                                    echo "<td style=\"white-space:pre-wrap ; word-wrap:break-word;vertical-align: middle;text-align:center;background: BLACK; color: white;\">Rejected By MSU</td>";
                                                } else {
                                                    echo "<td style=\"white-space:pre-wrap ; word-wrap:break-word;vertical-align: middle;text-align:center;background: YELLOW; color: BLACK;\">Approved By Group Manager</td>";
                                                    
                                                }
                                            } elseif($isi->INT_APPROVED_GM === 0){
                                                echo "<td style=\"white-space:pre-wrap ; word-wrap:break-word;vertical-align: middle;text-align:center;background: BLACK; color: white;\">Rejected By Group Manager</td>";
                                            } else {
                                                echo "<td style=\"white-space:pre-wrap ; word-wrap:break-word;vertical-align: middle;text-align:center;background: YELLOW; color: BLACK;\">Approved By Manager</td>";
                                                
                                            }
                                        } elseif ($isi->INT_APPROVED_MANAGER === 0) {
                                            echo "<td style=\"white-space:pre-wrap ; word-wrap:break-word;vertical-align: middle;text-align:center;background: BLACK; color: white;\">Rejected By Manager</td>";
                                        } else {
                                            echo "<td style=\"white-space:pre-wrap ; word-wrap:break-word;vertical-align: middle;text-align:center;background: YELLOW; color: black;\">Pending</td>";
                                        }
                                    } else {
                                        if($isi->INT_APPROVED_MANAGER == 1){
                                            if($isi->INT_APPROVED_MSU == 1){
                                                ?>
                                                <td style="white-space:pre-wrap ; word-wrap:break-word;vertical-align: middle;text-align:center;background: GREEN; color: white;">Approved By MSU</td>
                                                <?php
                                            } elseif ($isi->INT_APPROVED_MSU === 0) {
                                                echo "<td style=\"white-space:pre-wrap ; word-wrap:break-word;vertical-align: middle;text-align:center;background: BLACK; color: white;\">Rejected By MSU</td>";
                                            } else {
                                                echo "<td style=\"white-space:pre-wrap ; word-wrap:break-word;vertical-align: middle;text-align:center;background: YELLOW; color: BLACK;\">Approved By Manager</td>";   
                                            }
                                         
                                        } elseif ($isi->INT_APPROVED_MANAGER === 0) {
                                            echo "<td style=\"white-space:pre-wrap ; word-wrap:break-word;vertical-align: middle;text-align:center;background: BLACK; color: white;\">Rejected By Manager</td>";
                                        } else {
                                            echo "<td style=\"white-space:pre-wrap ; word-wrap:break-word;vertical-align: middle;text-align:center;background: YELLOW; color: black;\">Pending</td>";
                                        }
                                    }                                    
                                    ?>
                                    <?php 
                                        if($isi->INT_STATUS == 0) {
                                    ?>
                                            <td width="160px">
                                                <a href="<?php echo base_url('index.php/efila/register_document_c/detail_edit_register') . "/" . $isi->INT_ID_REGISTER; ?>" data-placement="left" data-toggle="tooltip" title="Detail" class="label label-warning"><span class="fa fa-search"></span></a>
                                                <!-- <br><br> -->
                                                <a data-toggle="modal" data-target="#modaledit<?php echo $isi->INT_ID_REGISTER; ?>" data-placement="left" data-toggle="tooltip" title="Edit Register" class="label label-warning"><span class="fa fa-pencil"></span></a>
                                                <!-- <br><br> -->
                                                <a href="<?php echo base_url('index.php/efila/register_document_c/delete_register_document') . "/" . $isi->INT_ID_REGISTER. "/" . $isi->INT_ID_DOCUMENT; ?>" class="label label-danger" data-placement="top" data-toggle="tooltip" title="Delete" onclick="return confirm('Are you sure want to delete this register document?');"><span class="fa fa-times"></span></a>
                                                <!-- <br><br> -->
                                                <a href="<?php echo base_url('index.php/efila/register_document_c/propose_register_document') . "/" . $isi->INT_ID_REGISTER . "/" . $isi->INT_ID_DOCUMENT; ?>" class="label label-success" data-placement="top" data-toggle="tooltip" title="Propose" onclick="return confirm('Are you sure want to propose this register document?');"><span class="fa fa-paper-plane"></span></a>
                                            </td>
                                    <?php
                                        } elseif ($isi->INT_APPROVED_MANAGER === 0 || $isi->INT_APPROVED_GM === 0 || $isi->INT_APPROVED_MSU === 0) {
                                    ?>
                                            <td width="160px">
                                                <a href="<?php echo base_url('index.php/efila/register_document_c/detail_edit_register') . "/" . $isi->INT_ID_REGISTER; ?>" data-placement="left" data-toggle="tooltip" title="Detail" class="label label-warning"><span class="fa fa-search"></span></a>
                                                <!-- <br><br> -->
                                                <a data-toggle="modal" data-target="#modaledit<?php echo $isi->INT_ID_REGISTER; ?>" data-placement="left" data-toggle="tooltip" title="Edit Register" class="label label-warning"><span class="fa fa-pencil"></span></a>
                                                <!-- <br><br> -->
                                                <a href="<?php echo base_url('index.php/efila/register_document_c/delete_register_document') . "/" . $isi->INT_ID_REGISTER. "/" . $isi->INT_ID_DOCUMENT; ?>" class="label label-danger" data-placement="top" data-toggle="tooltip" title="Delete" onclick="return confirm('Are you sure want to delete this register document?');"><span class="fa fa-times"></span></a>
                                                <!-- <br><br> -->
                                                <a href="<?php echo base_url('index.php/efila/register_document_c/propose_register_document') . "/" . $isi->INT_ID_REGISTER . "/" . $isi->INT_ID_DOCUMENT; ?>" class="label label-success" data-placement="top" data-toggle="tooltip" title="Propose" onclick="return confirm('Are you sure want to propose this register document?');"><span class="fa fa-paper-plane"></span></a>
                                            </td>
                                    <?php
                                        } 
                                        else {
                                    ?>
                                            <td>
                                                <a href="<?php echo base_url('index.php/efila/register_document_c/detail_register') . "/" . $isi->INT_ID_REGISTER; ?>" data-placement="left" data-toggle="tooltip" title="Detail" class="label label-warning"><span class="fa fa-search"></span></a>
                                            </td>
                                    <?php
                                        }
                                    ?>
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

        <?php
            foreach ($data as $isi) {
                ?>
                <!--EDIT Vacancy-->
                <div class="modal fade" id="modaledit<?php echo $isi->INT_ID_REGISTER; ?>" tabindex="-1" role="dialog" aria-labelledby="modaledit" aria-hidden="true" style="display: none;">
                    <div class="modal-wrapper">
                        <div class="modal-dialog">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times</button>
                                    <h4 class="modal-title" id="modaledit"><strong>Edit Register Document</strong></h4>
                                </div>
                                <div class="modal-body">
                                <?php
                                $attributes = array(
                                    'id' => 'form_mold',
                                    'class' => 'form-horizontal'
                                    ); 
                                echo form_open_multipart('efila/register_document_c/update_register_document', $attributes); 
                                    // echo form_open('', $attributes);
                                    ?>

                                    <input name="INT_ID_REGISTER" id="INT_ID_REGISTER" class="form-control" required type="hidden" style="width: 300px;" value="<?php echo $isi->INT_ID_REGISTER ?>">
                                    <input name="INT_ID_DOCUMENT" id="INT_ID_DOCUMENT" class="form-control" required type="hidden" style="width: 300px;" value="<?php echo $isi->INT_ID_DOCUMENT ?>">
                                    <input name="DOC_OLD" id="DOC_OLD" class="form-control" required type="hidden" style="width: 300px;" value="<?php echo $isi->CHR_DOC ?>">
                                    
                        
                                    <div class="form-group">
                                        <label class="col-sm-3 control-label">Document Name</label>
                                        <div class="col-sm-5">
                                            <input type="text" name="CHR_DOCUMENT_NAME" id="CHR_DOCUMENT_NAME" value="<?php echo $isi->CHR_DOCUMENT_NAME ?>" class="form-control" required>
                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <label class="col-sm-3 control-label">Document Desc</label>
                                        <div class="col-sm-5">
                                            <textarea name="CHR_DOCUMENT_DESC" id="CHR_DOCUMENT_DESC" class="form-control" required><?php echo trim($isi->CHR_DOCUMENT_DESC) ?></textarea>
                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <label class="col-sm-3 control-label">Document</label>
                                        <div class="col-sm-5">
                                            <input name="uploadFile" id="uploadFile" type="file">
                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <label class="col-sm-3 control-label">Scope</label>
                                        <div class="col-sm-5">
                                            <?php 
                                            if($isi->CHR_SCOPE == "internal"){
                                            ?>
                                                <input type="radio" name="CHR_SCOPE" id="CHR_SCOPE" value="internal" checked> Internal
                                                <input type="radio" name="CHR_SCOPE" id="CHR_SCOPE" value="external"> External
                                            <?php    
                                            } else {
                                            ?>
                                                <input type="radio" name="CHR_SCOPE" id="CHR_SCOPE" value="internal"> Internal
                                                <input type="radio" name="CHR_SCOPE" id="CHR_SCOPE" checked value="external"> External
                                            <?php
                                            }
                                            ?>
                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <label class="col-sm-3 control-label">Effective Date</label>
                                        <div class="col-sm-5">
                                            <?php  
                                                $tgl = $isi->CHR_EFFECTIVE_DATE; 
                                                $date = date("Y-m-d", strtotime($tgl));
                                            ?>
                                            <input name="CHR_EFFECTIVE_DATE" id="CHR_EFFECTIVE_DATE" type="date" value="<?php echo $date ?>">
                                        </div>
                                    </div>
                                </div>
                                <div class="modal-footer">
                                    <div class="btn-group">
                                        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                                        <button type="submit" id="upload" class="btn btn-primary" data-placement="left" data-toggle="tooltip" title="Save this data" onclick="uploadFile()"><i class="fa fa-check"></i> Update</button>
                                        <!-- <input type="button" id="upload" class="btn btn-primary"data-placement="left" data-toggle="tooltip" title="Save this data" value="Update" onclick="uploadFile()"> -->
                                <?php echo form_close(); ?>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <?php
                $i++;
            }
            ?>


            <script type="text/javascript" language="javascript">
                $("#uploadFile").fileinput({
                    'showUpload': false
                });
            </script>
            <script>
                $(function(){
                    var dtToday = new Date();
                    
                    var month = dtToday.getMonth() + 1;
                    var day = dtToday.getDate();
                    var year = dtToday.getFullYear();
                    if(month < 10)
                        month = '0' + month.toString();
                    if(day < 10)
                        day = '0' + day.toString();
                    
                    var maxDate = year + '-' + month + '-' + day;
                    // alert(maxDate);
                    $('#CHR_EFFECTIVE_DATE').attr('min', maxDate);
                });
            </script>
    </section>
</aside>
