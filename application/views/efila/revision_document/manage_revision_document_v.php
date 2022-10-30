<aside class="right-side">
    <section class="content-header">
        <ol class="breadcrumb">
            <li><a href="<?php echo base_url('index.php/basis/home_c/"') ?>"><span>Home</span></a></li>
            <li> <a href="#"><strong>Manage Revision Document</strong></a></li>
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
                        <span class="grid-title"><strong>REVISION DOCUMENT</strong> TABLE</span>
                        <div class="pull-right">
                            <a href="<?php echo base_url('index.php/efila/revision_document_c/list_document/') ?>" class="btn btn-default" data-placement="left" title="Revision Document" style="height:30px;font-size:13px;width:auto;">Revision Document</a>
                        </div>
                    </div>
                    <div class="grid-body">
                        <table id="dataTables1" class="table table-striped table-condensed table-hover display" cellspacing="0" width="100%">
                            <thead>
                                <tr>
                                    <th>No</th>
                                    <th>Id Revision</th>
                                    <th>No Document</th>
                                    <th>Document Name</th>
                                    <th>Document Category</th>
                                    <th>Revision</th>
                                    <th>Revision Date</th>
                                    <th>Created By</th>
                                    <!-- <th>Document</th> -->
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
                                    echo "<td>Rev-".$isi->INT_ID_REVISION."</td>";
                                    echo "<td>$isi->CHR_NO_DOC</td>";
                                    echo "<td>$isi->CHR_DOCUMENT_NAME</td>";
                                    echo "<td>$isi->CHR_CATEGORY_NAME</td>";
                                    echo "<td>$isi->INT_REVISION</td>";
                                    $tgl = $isi->CHR_CREATED_DATE; 
                                    $date = date("d-m-Y", strtotime($tgl));
                                    echo "<td>$date</td>";
                                    echo "<td>$isi->CHR_MODIFIED_BY</td>";
                                    ?>
                                    <!-- <td><a target="_blank" href="<?php echo base_url('index.php/efila/revision_document_c/view_doc') . "/" . $isi->CHR_DOC; ?>"><?php echo $isi->CHR_DOC; ?></a></td>                                    -->
                                
                                <?php
                                    echo "<td>$isi->CHR_INFO</td>";
                                if($isi->CHR_CATEGORY_NAME != 'STD') {
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
                                        if($isi->INT_STATUS == 0) {
                                    ?>
                                            <td width="150px">
                                                <a href="<?php echo base_url('index.php/efila/revision_document_c/detail_revision_edit') . "/" . $isi->INT_ID_REVISION; ?>" data-placement="left" data-toggle="tooltip" title="Detail" class="label label-warning"><span class="fa fa-search"></span></a>
                                                <a data-toggle="modal" data-target="#modaledit<?php echo $isi->INT_ID_REVISION; ?>" data-placement="left" data-toggle="tooltip" title="Edit Revision" class="label label-warning"><span class="fa fa-pencil"></span></a>
                                                <a href="<?php echo base_url('index.php/efila/revision_document_c/delete_revision_document') . "/" . $isi->INT_ID_REVISION. "/" . $isi->INT_ID_DOCUMENT; ?>" class="label label-danger" data-placement="top" data-toggle="tooltip" title="Delete" onclick="return confirm('Are you sure want to delete this revision document?');"><span class="fa fa-times"></span></a>
                                                <a href="<?php echo base_url('index.php/efila/revision_document_c/propose_revision_document') . "/" . $isi->INT_ID_REVISION . "/" . $isi->INT_ID_DOCUMENT; ?>" class="label label-success" data-placement="top" data-toggle="tooltip" title="Propose" onclick="return confirm('Are you sure want to propose this revision document?');"><span class="fa fa-paper-plane"></span></a>
                                            </td>
                                    <?php
                                        } else {
                                    ?>
                                            <td width="150px">
                                                <a href="<?php echo base_url('index.php/efila/revision_document_c/detail_revision') . "/" . $isi->INT_ID_REVISION; ?>" data-placement="left" data-toggle="tooltip" title="Detail" class="label label-warning"><span class="fa fa-search"></span></a>
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
                <div class="modal fade" id="modaledit<?php echo $isi->INT_ID_REVISION; ?>" tabindex="-1" role="dialog" aria-labelledby="modaledit" aria-hidden="true" style="display: none;">
                    <div class="modal-wrapper">
                        <div class="modal-dialog">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times</button>
                                    <h4 class="modal-title" id="modaledit"><strong>Edit Revision Document</strong></h4>
                                </div>
                                <div class="modal-body">
                                <?php
                                $attributes = array(
                                    'id' => 'form_mold',
                                    'class' => 'form-horizontal'
                                    ); 
                                echo form_open_multipart('efila/revision_document_c/update_revision_document', $attributes); 
                                    // echo form_open('', $attributes);
                                    ?>

                                    <input name="INT_ID_REVISION" id="INT_ID_REVISION" class="form-control" required type="hidden" style="width: 300px;" value="<?php echo $isi->INT_ID_REVISION ?>">
                                    <input name="INT_ID_DOCUMENT" id="INT_ID_DOCUMENT" class="form-control" required type="hidden" style="width: 300px;" value="<?php echo $isi->INT_ID_DOCUMENT ?>">
                                    <input name="DOC_OLD" id="DOC_OLD" class="form-control" required type="hidden" style="width: 300px;" value="<?php echo $isi->CHR_DOC ?>">
                                    <input name="CHR_NO_DOC" id="CHR_NO_DOC" class="form-control" required type="hidden" style="width: 300px;" value="<?php echo $isi->CHR_NO_DOC ?>">


                                    <div class="form-group">
                                        <label class="col-sm-3 control-label">Document</label>
                                        <div class="col-sm-5">
                                            <input name="uploadFile" id="uploadFile" type="file" required>
                                        </div>
                                    </div>

                                </div>
                                <div class="modal-footer">
                                    <div class="btn-group">
                                        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                                        <button type="submit" id="upload" class="btn btn-primary" data-placement="left" data-toggle="tooltip" title="Save this data"><i class="fa fa-check"></i> Update</button>
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
