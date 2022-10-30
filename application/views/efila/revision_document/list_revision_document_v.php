<aside class="right-side">
    <section class="content-header">
        <ol class="breadcrumb">
            <li><a href="<?php echo base_url('index.php/basis/home_c/"') ?>"><span>Home</span></a></li>
            <li><a href="<?php echo base_url('index.php/efila/revision_document_c/"') ?>"><span>Manage Revision Document</span></a></li>
            <li> <a href="#"><strong>Revision Document</strong></a></li>
        </ol>
    </section>

    <section class="content">

        <div class="row">
            <div class="col-md-12">
                <div class="grid">
                    <div class="grid-header">
                        <i class="fa fa-sitemap"></i>
                        <span class="grid-title"><strong>DOCUMENT</strong> TABLE</span>
                        <div class="pull-right">
                            
                        </div>
                    </div>
                    <div class="grid-body">
                        <table id="dataTables1" class="table table-striped table-condensed table-hover display" cellspacing="0" width="100%">
                            <thead>
                                <tr>
                                    <th>No</th>
                                    <th>No Document</th>
                                    <th>Document Name</th>
                                    <th>Document Description</th>
                                    <th>Document Category</th>
                                    <th>Document</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                $i = 1;
                                foreach ($doc as $isi) {
                                    echo "<tr class='gradeX'>";
                                    echo "<td>$i</td>";
                                    echo "<td>$isi->CHR_NO_DOC</td>";
                                    echo "<td>$isi->CHR_DOCUMENT_NAME</td>";
                                    echo "<td>$isi->CHR_DOCUMENT_DESC</td>";
                                    echo "<td>$isi->CHR_CATEGORY_NAME</td>";
                                    ?>
                                    <td><a target="_blank" href="<?php echo base_url('index.php/efila/revision_document_c/view_doc') . "/" . $isi->CHR_DOC; ?>"><?php echo $isi->CHR_DOC; ?></a></td>
                                    <td><a href="<?php echo base_url('index.php/efila/revision_document_c/create_revision_document') . "/" . $isi->INT_ID_DOCUMENT; ?>" class="label label-warning" title="Revision Document" data-toggle="tooltip"><span class="fa fa-pencil"></span></a></td>
                                </tr>
                                <?php
                                $i++;
                            }
                            ?>
                            </tbody>
                        </table>
                        <?php echo anchor('efila/revision_document_c', 'Back', 'class="btn btn-default"');
                                    ?>
                    </div>
                </div>
            </div>
        </div>
    </section>
</aside>
