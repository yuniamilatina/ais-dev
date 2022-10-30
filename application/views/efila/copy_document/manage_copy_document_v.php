<aside class="right-side">
    <section class="content-header">
        <ol class="breadcrumb">
            <li><a href="<?php echo base_url('index.php/basis/home_c/"') ?>"><span>Home</span></a></li>
            <li> <a href="#"><strong>Manage Copy Document</strong></a></li>
        </ol>
    </section>
    <script>
        $(document).ready(function() {

            var interval_close = setInterval(closeSideBar, 250);
            function closeSideBar() {
                $("#hide-sub-menus").click();
                clearInterval(interval_close);
            }
        });
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
                        <span class="grid-title"><strong>COPY DOCUMENT</strong> TABLE</span>
                        <div class="pull-right">
                            <a href="<?php echo base_url('index.php/efila/copy_document_c/list_document/') ?>" class="btn btn-default" data-placement="left" title="Copy Document" style="height:30px;font-size:13px;width:auto;">Copy Document</a>
                        </div>
                    </div>
                    <div class="grid-body">
                        <table id="dataTables1" class="table table-striped table-condensed table-hover display" cellspacing="0" width="100%">
                            <thead>
                                <tr>
                                    <th>No</th>
                                    <th>Id Copy</th>
                                    <th>No Document</th>
                                    <th>Document Name</th>
                                    <th>Document Category</th>
                                    <th>Created By</th>
                                    <th>Type</th>
                                    <th>Total</th>
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
                                    echo "<td>Cop-".$isi->INT_ID_COPY."</td>";
                                    echo "<td>$isi->CHR_NO_DOC</td>";
                                    echo "<td>$isi->CHR_DOCUMENT_NAME</td>";
                                    echo "<td>$isi->CHR_CATEGORY_NAME</td>";
                                    echo "<td>$isi->CHR_CREATED_BY</td>";
                                    if($isi->INT_TYPE == 1){
                                        echo "<td>Controlled Copy</td>";
                                    } else {
                                        echo "<td>Uncontrolled Copy</td>";
                                    }
                                    echo "<td>$isi->INT_TOTAL</td>";
                                    echo "<td>$isi->CHR_INFO</td>";
                                    ?>
                                    
                                
                                <?php

                                    if($isi->INT_APPROVED_SPV == 1){
                                        
                                        if($isi->INT_APPROVED_MSU == 1){
                                            ?>
                                            <td style="white-space:pre-wrap ; word-wrap:break-word;vertical-align: middle;text-align:center;background: GREEN; color: white;">Approved By MSU</td>
                                            <?php
                                        } elseif ($isi->INT_APPROVED_MSU === 0) {
                                            echo "<td style=\"white-space:pre-wrap ; word-wrap:break-word;vertical-align: middle;text-align:center;background: BLACK; color: white;\">Rejected By MSU</td>";
                                        } else {
                                            echo "<td style=\"white-space:pre-wrap ; word-wrap:break-word;vertical-align: middle;text-align:center;background: YELLOW; color: BLACK;\">Approved By Supervisor</td>";
                                            
                                        }
                                     
                                    } elseif ($isi->INT_APPROVED_MANAGER === 0) {
                                        echo "<td style=\"white-space:pre-wrap ; word-wrap:break-word;vertical-align: middle;text-align:center;background: BLACK; color: white;\">Rejected By Supervisor</td>";
                                    } else {
                                        echo "<td style=\"white-space:pre-wrap ; word-wrap:break-word;vertical-align: middle;text-align:center;background: YELLOW; color: black;\">Pending</td>";
                                    }
                                        
                                    if($isi->INT_STATUS == 0) {
                                    ?>
                                            <td>
                                                <a href="<?php echo base_url('index.php/efila/copy_document_c/detail_copy_edit') . "/" . $isi->INT_ID_COPY; ?>" data-placement="left" data-toggle="tooltip" title="Detail" class="label label-warning"><span class="fa fa-search"></span></a>
                                                <a data-toggle="modal" data-target="#modaledit<?php echo $isi->INT_ID_COPY; ?>" data-placement="left" data-toggle="tooltip" title="Edit Copy" class="label label-warning"><span class="fa fa-pencil"></span></a>
                                                <a href="<?php echo base_url('index.php/efila/copy_document_c/delete_copy_document') . "/" . $isi->INT_ID_COPY. "/" . $isi->INT_ID_DOCUMENT; ?>" class="label label-danger" data-placement="top" data-toggle="tooltip" title="Delete" onclick="return confirm('Are you sure want to delete this copy document?');"><span class="fa fa-times"></span></a>
                                                <a href="<?php echo base_url('index.php/efila/copy_document_c/propose_copy_document') . "/" . $isi->INT_ID_COPY . "/" . $isi->INT_ID_DOCUMENT; ?>" class="label label-success" data-placement="top" data-toggle="tooltip" title="Propose" onclick="return confirm('Are you sure want to propose this copy document?');"><span class="fa fa-paper-plane"></span></a>
                                            </td>
                                    <?php
                                        } elseif ($isi->INT_APPROVED_SPV === 0 || $isi->INT_APPROVED_MSU === 0) {
                                    ?>
                                            <td>
                                                <a href="<?php echo base_url('index.php/efila/copy_document_c/detail_copy_edit') . "/" . $isi->INT_ID_COPY; ?>" data-placement="left" data-toggle="tooltip" title="Detail" class="label label-warning"><span class="fa fa-search"></span></a>
                                                <a data-toggle="modal" data-target="#modaledit<?php echo $isi->INT_ID_COPY; ?>" data-placement="left" data-toggle="tooltip" title="Edit Copy" class="label label-warning"><span class="fa fa-pencil"></span></a>
                                                <a href="<?php echo base_url('index.php/efila/copy_document_c/delete_copy_document') . "/" . $isi->INT_ID_COPY. "/" . $isi->INT_ID_DOCUMENT; ?>" class="label label-danger" data-placement="top" data-toggle="tooltip" title="Delete" onclick="return confirm('Are you sure want to delete this copy document?');"><span class="fa fa-times"></span></a>
                                                <a href="<?php echo base_url('index.php/efila/copy_document_c/propose_copy_document') . "/" . $isi->INT_ID_COPY . "/" . $isi->INT_ID_DOCUMENT; ?>" class="label label-success" data-placement="top" data-toggle="tooltip" title="Propose" onclick="return confirm('Are you sure want to propose this copy document?');"><span class="fa fa-paper-plane"></span></a>
                                            </td>
                                    <?php
                                        } 
                                        else {
                                    ?>
                                            <td>
                                                <a href="<?php echo base_url('index.php/efila/copy_document_c/detail_copy') . "/" . $isi->INT_ID_COPY; ?>" data-placement="left" data-toggle="tooltip" title="Detail" class="label label-warning"><span class="fa fa-search"></span></a>
                                            </td>
                                    <?php
                                        }
                                $i++;
                            }
                            ?>
                                </tr>
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
                <div class="modal fade" id="modaledit<?php echo $isi->INT_ID_COPY; ?>" tabindex="-1" role="dialog" aria-labelledby="modaledit" aria-hidden="true" style="display: none;">
                    <div class="modal-wrapper">
                        <div class="modal-dialog">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times</button>
                                    <h4 class="modal-title" id="modaledit"><strong>Edit Copy Document</strong></h4>
                                </div>
                                <div class="modal-body">
                                <?php
                                $attributes = array(
                                    'id' => 'form_mold',
                                    'class' => 'form-horizontal'
                                    ); 
                                echo form_open_multipart('efila/copy_document_c/update_copy_document', $attributes); 
                                    // echo form_open('', $attributes);
                                    ?>

                                    <input name="INT_ID_COPY" id="INT_ID_COPY" class="form-control" required type="hidden" style="width: 300px;" value="<?php echo $isi->INT_ID_COPY ?>">
                        
                                    <div class="form-group">
                                        <label class="col-sm-3 control-label">Document Name</label>
                                        <div class="col-sm-5">
                                            <input type="text" name="CHR_DOCUMENT_NAME" id="CHR_DOCUMENT_NAME" value="<?php echo $isi->CHR_DOCUMENT_NAME ?>" class="form-control" readonly>
                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <label class="col-sm-3 control-label">Category</label>
                                        <div class="col-sm-5">
                                            <input type="text" name="CHR_CATEGORY_NAME" id="CHR_CATEGORY_NAME" class="form-control" value="<?php echo $isi->CHR_CATEGORY_NAME ?>" readonly>
                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <label class="col-sm-3 control-label">Type</label>
                                        <div class="col-sm-5">
                                            <?php
                                                if($isi->INT_TYPE == 1){
                                                    ?>
                                                    <input type="radio" name="INT_TYPE" value="1" checked> Controlled Copy
                                                    <br>
                                                    <input type="radio" name="INT_TYPE" value="0"> Uncontrolled Copy
                                                    <?php
                                                } else {
                                                    ?>
                                                    <input type="radio" name="INT_TYPE" value="1"> Controlled Copy
                                                    <br>
                                                    <input type="radio" name="INT_TYPE" value="0" checked> Uncontrolled Copy
                                                    <?php
                                                }
                                            ?>
                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <label class="col-sm-3 control-label">Total</label>
                                        <div class="col-sm-5">
                                            <input type="text" name="INT_TOTAL" value="<?php echo $isi->INT_TOTAL ?>" class="form-control">
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
    </section>
</aside>
