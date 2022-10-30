<aside class="right-side">
    <section class="content-header">
        <ol class="breadcrumb">
            <li><a href="<?php echo base_url('index.php/basis/home_c/"') ?>"><span>Home</span></a></li>
            <li><a href="<?php echo base_url('index.php/efila/approval_manager_c/"') ?>"><span>List Section</span></a></li>
            <li> <a href="#"><strong>List Document</strong></a></li>
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
                        <span class="grid-title"><strong>DOCUMENT</strong> TABLE</span>
                        <div class="pull-right">
                            <!-- <a href="<?php echo base_url('index.php/efila/document_c/create_document/') ?>" class="btn btn-default" data-placement="left" title="Apply Document" style="height:30px;font-size:13px;width:auto;">Apply Document</a> -->
                        </div>
                    </div>
                    <div class="grid-body">
                        <table id="dataTables1" class="table table-striped table-condensed table-hover display" cellspacing="0" width="100%">
                            <thead>
                                <tr>
                                    <th>No</th>
                                    <th>Document Name</th>
                                    <th>Document Description</th>
                                    <th>Category Name</th>
                                    <th>Document</th>
                                    <th>Created By</th>
                                    <th>Type</th>
                                    <th>Information</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                $i = 1;
                                foreach ($data as $isi) {
                                    echo "<tr class='gradeX'>";
                                    echo "<td>$i</td>";
                                    echo "<td>$isi->DOC_NAME</td>";
                                    echo "<td>$isi->DOC_DESC</td>";
                                    echo "<td>$isi->CAT_NAME</td>"; ?>
                                    <td><a href="<?php echo base_url()."/assets/Document/".$isi->DOC; ?>"><?php echo $isi->DOC; ?></a></td>
                                    <?php
                                    echo "<td>$isi->CREA_BY</td>";
                                    echo "<td>$isi->TIPE</td>";
                                    echo "<td>$isi->INFO</td>";
                                    ?>
                                <td>
                                    <a href="<?php echo base_url('index.php/efila/approval_manager_c/update_approval_manager') . "/" . $isi->ID . "/" . 1; ?>" data-placement="left" data-toggle="tooltip" title="Approve" class="label label-success" onclick="return confirm('Are you sure want to approve this document?');"><span class="fa fa-check"></span></a>
                                    <a href="<?php echo base_url('index.php/efila/approval_manager_c/update_approval_manager') . "/" . $isi->ID . "/" . 0; ?>" data-placement="left" data-toggle="tooltip" title="Reject" class="label label-danger" onclick="return confirm('Are you sure want to reject this document?');"><span class="fa fa-times"></span></a>
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


