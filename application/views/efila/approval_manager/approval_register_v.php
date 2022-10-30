<aside class="right-side">
    <section class="content-header">
        <ol class="breadcrumb">
            <li><a href="<?php echo base_url('index.php/basis/home_c/"') ?>"><span>Home</span></a></li>
            <li> <a href="#"><strong>Approval Register document</strong></a></li>
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
                        <span class="grid-title"><strong>REGISTER DOCUMENT</strong> TABLE</span>
                        <div class="pull-right">
                            
                        </div>
                    </div>
                    <div class="grid-body">
                        <table id="dataTables1" class="table table-striped table-condensed table-hover display" cellspacing="0" width="100%">
                            <thead>
                                <tr>
                                    <th>No</th>
                                    <th>Id Register</th>
                                    <th>Created By</th>
                                    <th>Created Date</th>
                                    <th>Category</th>
                                    <th>Document Description</th>
                                    <th>Document</th>
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
                                    echo "<td>$isi->CHR_CREATED_BY</td>";
                                    $tgl = $isi->CHR_CREATED_DATE; 
                                    $date = date("Y-m-d", strtotime($tgl));
                                    echo "<td>$date</td>";
                                    echo "<td>$isi->CHR_CATEGORY_NAME</td>";
                                    echo "<td>$isi->CHR_DOCUMENT_DESC</td>";
                                    ?>
                                    <td><a href="<?php echo base_url('index.php/efila/approval_register_manager_c/view_doc') . "/" . $isi->CHR_DOC; ?>"><?php echo $isi->CHR_DOC; ?></a></td>
                                <td>
                                    <a href="<?php echo base_url('index.php/efila/approval_register_manager_c/detail_register') . "/" . $isi->INT_ID_REGISTER; ?>" data-placement="left" data-toggle="tooltip" title="Detail" class="label label-warning"><span class="fa fa-search"></span></a>
                                    <a href="<?php echo base_url('index.php/efila/approval_register_manager_c/update_approval_manager') . "/1/" . $isi->INT_ID_REGISTER; ?>" data-placement="left" data-toggle="tooltip" title="Approve" class="label label-success" onclick="return confirm('Are you sure want to approve this document?');"><span class="fa fa-check"></span></a>
                                    <a href="#" data-toggle="modal" data-target="#modalreject<?php echo $isi->INT_ID_REGISTER; ?>" data-placement="left" title="Reject" class="label label-danger"><span class="fa fa-times"></span></a>
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
                <div class="modal fade" id="modalreject<?php echo $isi->INT_ID_REGISTER; ?>" tabindex="-1" role="dialog" aria-labelledby="modalreject" aria-hidden="true" style="display: none;">
                    <div class="modal-wrapper">
                        <div class="modal-dialog">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times</button>
                                    <h4 class="modal-title" id="modaledit"><strong>Reject Register Document</strong></h4>
                                </div>
                                <div class="modal-body">
                                <?php echo form_open('efila/approval_register_manager_c/update_approval_manager/0', 'class="form-horizontal"'); ?>

                                    <input name="INT_ID_REGISTER" class="form-control" required type="hidden" style="width: 300px;" value="<?php echo $isi->INT_ID_REGISTER ?>">
                        
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


