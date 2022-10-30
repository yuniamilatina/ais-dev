<aside class="right-side">
    <section class="content-header">
        <ol class="breadcrumb">
            <li><a href="<?php echo base_url('index.php/basis/home_c/"') ?>"><span>Home</span></a></li>
            <li> <a href="#"><strong>Manage Obsolete Document</strong></a></li>
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
                        <span class="grid-title"><strong>OBSOLETE DOCUMENT</strong> TABLE</span>
                        <div class="pull-right">
                            <a href="<?php echo base_url('index.php/efila/obsolete_document_c/list_document/') ?>" class="btn btn-default" data-placement="left" title="Obsolete Document" style="height:30px;font-size:13px;width:auto;">Obsolete Document</a>
                        </div>
                    </div>
                    <div class="grid-body">
                        <table id="dataTables1" class="table table-striped table-condensed table-hover display" cellspacing="0" width="100%">
                            <thead>
                                <tr>
                                    <th>No</th>
                                    <th>Id Obsolete</th>
                                    <th>No Document</th>
                                    <th>Document Name</th>
                                    <th>Document Category</th>
                                    <th>Created By</th>
                                    <!-- <th>Document</th> -->
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
                                    echo "<td>Obs-".$isi->INT_ID_OBSOLETE."</td>";
                                    echo "<td>$isi->CHR_NO_DOC</td>";
                                    echo "<td>$isi->CHR_DOCUMENT_NAME</td>";
                                    echo "<td>$isi->CHR_CATEGORY_NAME</td>";
                                    echo "<td>$isi->CHR_CREATED_BY</td>";
                                    ?>
                                    <!-- <td><a target="_blank" href="<?php echo base_url('index.php/efila/obsolete_document_c/view_doc') . "/" . $isi->CHR_DOC; ?>"><?php echo $isi->CHR_DOC; ?></a></td> -->
                                
                                <?php

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
                                        
                                        if($isi->INT_STATUS == 0) {
                                    ?>
                                            <td>
                                                <a href="<?php echo base_url('index.php/efila/obsolete_document_c/detail_obsolete_edit') . "/" . $isi->INT_ID_OBSOLETE; ?>" data-placement="left" data-toggle="tooltip" title="Detail" class="label label-warning"><span class="fa fa-search"></span></a>
                                                <!-- <a data-toggle="modal" data-target="#modaledit<?php echo $isi->INT_ID_OBSOLETE; ?>" data-placement="left" data-toggle="tooltip" title="Edit Obsolete" class="label label-warning"><span class="fa fa-pencil"></span> -->
                                                <a href="<?php echo base_url('index.php/efila/obsolete_document_c/delete_obsolete_document') . "/" . $isi->INT_ID_OBSOLETE; ?>" class="label label-danger" data-placement="top" data-toggle="tooltip" title="Delete" onclick="return confirm('Are you sure want to delete this obsolete document?');"><span class="fa fa-times"></span></a>
                                                <a href="<?php echo base_url('index.php/efila/obsolete_document_c/propose_obsolete_document') . "/" . $isi->INT_ID_OBSOLETE . "/" . $isi->INT_ID_DOCUMENT; ?>" class="label label-success" data-placement="top" data-toggle="tooltip" title="Propose" onclick="return confirm('Are you sure want to propose this obsolete document?');"><span class="fa fa-paper-plane"></span></a>
                                            </td>
                                    <?php
                                        } elseif ($isi->INT_APPROVED_MANAGER === 0 || $isi->INT_APPROVED_MSU === 0) {
                                    ?>
                                            <td>
                                                <a href="<?php echo base_url('index.php/efila/obsolete_document_c/detail_obsolete_edit') . "/" . $isi->INT_ID_OBSOLETE; ?>" data-placement="left" data-toggle="tooltip" title="Detail" class="label label-warning"><span class="fa fa-search"></span></a>
                                                <!-- <a data-toggle="modal" data-target="#modaledit<?php echo $isi->INT_ID_OBSOLETE; ?>" data-placement="left" data-toggle="tooltip" title="Edit Obsolete" class="label label-warning"><span class="fa fa-pencil"></span> -->
                                                <a href="<?php echo base_url('index.php/efila/obsolete_document_c/delete_obsolete_document') . "/" . $isi->INT_ID_OBSOLETE; ?>" class="label label-danger" data-placement="top" data-toggle="tooltip" title="Delete" onclick="return confirm('Are you sure want to delete this obsolete document?');"><span class="fa fa-times"></span></a>
                                                <a href="<?php echo base_url('index.php/efila/obsolete_document_c/propose_obsolete_document') . "/" . $isi->INT_ID_OBSOLETE . "/" . $isi->INT_ID_DOCUMENT; ?>" class="label label-success" data-placement="top" data-toggle="tooltip" title="Propose" onclick="return confirm('Are you sure want to propose this obsolete document?');"><span class="fa fa-paper-plane"></span></a>
                                            </td>
                                    <?php                                            
                                        } else {
                                    ?>
                                            <td>
                                                <a href="<?php echo base_url('index.php/efila/obsolete_document_c/detail_obsolete') . "/" . $isi->INT_ID_OBSOLETE; ?>" data-placement="left" data-toggle="tooltip" title="Detail" class="label label-warning"><span class="fa fa-search"></span></a>
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
    </section>
</aside>
