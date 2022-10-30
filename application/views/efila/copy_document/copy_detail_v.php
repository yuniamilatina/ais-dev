<aside class="right-side">
    <section class="content-header">
        <ol class="breadcrumb">
            <li><a href="<?php echo base_url('index.php/basis/home_c/"') ?>"><span>Home</span></a></li>
            <li><a href="<?php echo base_url('index.php/efila/copy_document_c/"') ?>"><span>Copy document</span></a></li>
            <li> <a href="#"><strong>Copy document Detail</strong></a></li>
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
                        <span class="grid-title"><strong>COPY DOCUMENT REASONS</strong> TABLE</span>
                        <div class="pull-right">
                        </div>
                    </div>
                    <div class="grid-body">
                        <table id="dataTables1" class="table table-striped table-condensed table-hover display" cellspacing="0" width="100%">
                            <thead>
                                <tr>
                                    <th>No</th>
                                    <th>REASONS</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                $i = 1;
                                foreach ($back as $isi) {
                                    echo "<tr class='gradeX'>";
                                    echo "<td>$i</td>";
                                    echo "<td>$isi->CHR_BACKGROUND</td>";
                                ?>
                                <td>
                                    <!-- <a href="<?php echo base_url('index.php/efila/copy_document_c/delete_copy_back') . "/" . $isi->INT_ID_BACKGROUND . "/" . $isi->INT_ID_COPY; ?>" class="label label-danger" data-placement="top" data-toggle="tooltip" title="Delete" onclick="return confirm('Are you sure want to delete this copy reason?');"><span class="fa fa-times"></span></a> -->
                                </td>
                                </tr>
                                <?php
                                $i++;
                            }
                            ?>
                            </tbody>
                        </table>
                        <?php echo anchor('efila/copy_document_c', 'Back', 'class="btn btn-default"');?>
                    </div>
                </div>
            </div>
        </div>
    </section>
</aside>


