<aside class="right-side">
    <section class="content-header">
        <ol class="breadcrumb">
            <li><a href="<?php echo base_url('index.php/basis/home_c/"') ?>"><span>Home</span></a></li>
            <li><a href="<?php echo base_url('index.php/efila/obsolete_document_c/"') ?>"><span>Obsolete document</span></a></li>
            <li> <a href="#"><strong>Obsolete document Detail</strong></a></li>
        </ol>
    </section>

    <section class="content">
        <?php if ($msg != NULL) {
            echo $msg;
        } 
        $count = 0;
        foreach ($back as $isi) {
            $count++;
        }
        ?>
        <div class="row">
            <div class="col-md-12">
                <div class="grid">
                    <div class="grid-header">
                        <i class="fa fa-sitemap"></i>
                        <span class="grid-title"><strong>OBSOLETE DOCUMENT REASONS</strong> TABLE</span>
                        <div class="pull-right">
                            <a href="#" data-toggle="modal" data-target="#modalreason" data-placement="left" title="Add Reason" class="btn btn-primary">Add</a>
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
                                    if($count == 1){
                                        echo "<td></td>";
                                    } else {
                                ?>
                                <td>
                                    <a href="<?php echo base_url('index.php/efila/obsolete_document_c/delete_obsolete_back') . "/" . $isi->INT_ID_BACKGROUND . "/" . $isi->INT_ID_OBSOLETE; ?>" class="label label-danger" data-placement="top" data-toggle="tooltip" title="Delete" onclick="return confirm('Are you sure want to delete this obsolete reason?');"><span class="fa fa-times"></span></a>
                                </td>
                            <?php } ?>
                                </tr>
                                <?php
                                $i++;
                            }
                            ?>
                            </tbody>
                        </table>
                        <?php echo anchor('efila/obsolete_document_c', 'Back', 'class="btn btn-default"');?>
                    </div>
                </div>
            </div>
        </div>

        <div class="modal fade" id="modalreason" tabindex="-1" role="dialog" aria-labelledby="modalLabelReason" aria-hidden="true" style="display: none;">
            <div class="modal-wrapper">
                <div class="modal-dialog" style="width:1150px;">
                    <div class="modal-content">
                        <?php
                        echo form_open('efila/obsolete_document_c/save_reason', 'class = "form-horizontal"');
                        ?>
                        <div class="modal-header">
                            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                            <h4 class="modal-title" id="modalLabelReason"><strong>REASON</strong></h4>
                        </div>
                        <div class="modal-body" style="font-size:12px;">
                            <input type="hidden" name="INT_ID_OBSOLETE" value="<?php echo $obs; ?>">
                            <div class="form-group">
                                <label class="col-sm-3 control-label">Reason<font color="red">*</font></label>
                                <div class="col-sm-5">
                                    <input name="CHR_BACKGROUND" class="form-control" required type="text">
                                </div>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <div class="btn-group">
                                <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
                                <button type="submit" class="btn btn-primary" data-placement="left" title="Save Reason"><i class="fa fa-check"></i> Save</button>
                            </div>
                        </div>
                        <?php
                        echo form_close();
                        ?>
                    </div>
                </div>
            </div>
        </div>

    </section>
</aside>


