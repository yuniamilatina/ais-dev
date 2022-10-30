<aside class="right-side">
    <section class="content-header">
        <ol class="breadcrumb">
            <li><a href="<?php echo base_url('index.php/basis/home_c/"') ?>"><span>Home</span></a></li>
            <li> <a href="#"><strong>List Section</strong></a></li>
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
                        <span class="grid-title"><strong>SECTION</strong> TABLE</span>
                        <div class="pull-right">
                            <!-- <a href="<?php echo base_url('index.php/efila/document_c/create_document/') ?>" class="btn btn-default" data-placement="left" title="Apply Document" style="height:30px;font-size:13px;width:auto;">Apply Document</a> -->
                        </div>
                    </div>
                    <div class="grid-body">
                        <table id="dataTables1" class="table table-striped table-condensed table-hover display" cellspacing="0" width="100%">
                            <thead>
                                <tr>
                                    <th>No</th>
                                    <th>Section</th>
                                    <th>Section Description</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                $i = 1;
                                foreach ($data as $isi) {
                                    echo "<tr class='gradeX'>";
                                    echo "<td>$i</td>";
                                    echo "<td>$isi->NAME</td>";
                                    echo "<td>$isi->DESCRIPTION</td>";
                                    ?>
                                <td>
                                    <a href="<?php echo base_url('index.php/efila/approval_manager_c/list_doc') . "/" . $isi->ID_SECTION; ?>" data-placement="left" data-toggle="tooltip" title="Approval" class="label label-success"><span class="fa fa-pencil"></span></a>
                                    <a href="<?php echo base_url('index.php/efila/approval_manager_c/list_doc_approved') . "/" . $isi->ID_SECTION; ?>" data-placement="left" data-toggle="tooltip" title="List Document" class="label label-warning"><span class="fa fa-list"></span></a>
                                    
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


