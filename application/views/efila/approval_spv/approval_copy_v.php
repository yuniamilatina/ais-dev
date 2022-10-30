<aside class="right-side">
    <section class="content-header">
        <ol class="breadcrumb">
            <li><a href="<?php echo base_url('index.php/basis/home_c/"') ?>"><span>Home</span></a></li>
            <li> <a href="#"><strong>Approval Copy document</strong></a></li>
        </ol>
    </section>

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
                                    <th>Revision</th>
                                    <th>Category</th>
                                    <th>Created By</th>
                                    <th>Type</th>
                                    <th>Total</th>
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
                                    echo "<td>$isi->INT_REVISION</td>";
                                    echo "<td>$isi->CHR_CATEGORY_NAME</td>";
                                    echo "<td>$isi->CHR_CREATED_BY</td>";
                                    if($isi->INT_TYPE == 1){
                                        echo "<td>Controlled Copy</td>";
                                    } else {
                                        echo "<td>Uncontrolled Copy</td>";
                                    }
                                    echo "<td>$isi->INT_TOTAL</td>";
                                    ?>
                                <td>
                                    <a href="<?php echo base_url('index.php/efila/approval_copy_spv_c/detail_copy') . "/" . $isi->INT_ID_COPY; ?>" data-placement="left" data-toggle="tooltip" title="Detail" class="label label-warning"><span class="fa fa-search"></span></a>
                                    <a href="<?php echo base_url('index.php/efila/approval_copy_spv_c/update_approval_spv') . "/1/" . $isi->INT_ID_COPY . "/" . $isi->INT_ID_DOCUMENT; ?>" data-placement="left" data-toggle="tooltip" title="Approve" class="label label-success" onclick="return confirm('Are you sure want to approve this document?');"><span class="fa fa-check"></span></a>
                                    <a href="#" data-toggle="modal" data-target="#modalreject<?php echo $isi->INT_ID_COPY; ?>" data-placement="left" title="Reject" class="label label-danger"><span class="fa fa-times"></span></a>
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

        <?php
            foreach ($data as $isi) {
                ?>
                <!--EDIT Vacancy-->
                <div class="modal fade" id="modalreject<?php echo $isi->INT_ID_COPY; ?>" tabindex="-1" role="dialog" aria-labelledby="modalreject" aria-hidden="true" style="display: none;">
                    <div class="modal-wrapper">
                        <div class="modal-dialog">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times</button>
                                    <h4 class="modal-title" id="modaledit"><strong>Reject Copy Document</strong></h4>
                                </div>
                                <div class="modal-body">
                                <?php echo form_open('efila/approval_copy_spv_c/update_approval_spv/0', 'class="form-horizontal"'); ?>

                                    <input name="INT_ID_COPY" class="form-control" required type="hidden" style="width: 300px;" value="<?php echo $isi->INT_ID_COPY ?>">
                        
                                    <div class="form-group">
                                        <label class="col-sm-3 control-label">Reason</label>
                                        <div class="col-sm-5">
                                            <!-- <input name="CHR_NO_DOC" class="form-control" required type="text" style="width: 300px;"> -->
                                            <textarea name="CHR_INFO" class="form-control" required></textarea>
                                        </div>
                                    </div>
                                </div>
                                <div class="modal-footer">
                                    <div class="btn-group">
                                        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                                        <button type="submit" class="btn btn-primary" data-placement="left" data-toggle="tooltip" title="Save this data"><i class="fa fa-times"></i> Reject</button>
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


