<aside class="right-side">
    <section class="content-header">
        <ol class="breadcrumb">
            <li><a href="<?php echo base_url('index.php/basis/home_c/"') ?>"><span>Home</span></a></li>
            <li> <a href="#"><strong>Manage Mold</strong></a></li>
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
                        <span class="grid-title"><strong>MOLD</strong> TABLE</span>
                        <div class="pull-right">
                            <a href="<?php echo base_url('index.php/mte/mold_c/create_mold/') ?>" class="btn btn-default" data-toggle="tooltip" data-placement="left" title="Create Mold" style="height:30px;font-size:13px;width:100px;">Create</a>
                            <!-- <?php echo '<input type="button" data-toggle="modal" data-target="#modalmold" data-placement="left" title="Create Mold" class="btn btn-default" style="height:30px; width:100px;" value="Create">'; ?> -->
                        </div>
                    </div>
                    <div class="grid-body">
                        <table id="dataTables1" class="table table-striped table-condensed table-hover display" cellspacing="0" width="100%">
                            <thead>
                                <tr>
                                    <th>No</th>
                                    <th>Mold Code</th>
                                    <th>Mold Name</th>
                                    <th>Mold Model</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                $i = 1;
                                foreach ($data as $isi) {
                                    echo "<tr class='gradeX'>";
                                    echo "<td>$i</td>";
                                    echo "<td>$isi->CHR_CODE_MOLD</td>";
                                    echo "<td>$isi->CHR_MOLD_NAME</td>";
                                    echo "<td>$isi->CHR_MODEL</td>";
                                    ?>
                                <td>
                                    <a href="<?php echo base_url('index.php/mte/mold_c/detail_mold') . "/" . $isi->CHR_CODE_MOLD; ?>" class="label label-success" data-placement="top" data-toggle="tooltip" title="Detail"><span class="fa fa-list"></span></a>

                                    <a data-toggle="modal" data-target="#modaledit<?php echo $isi->CHR_CODE_MOLD; ?>" data-placement="left" data-toggle="tooltip" title="Edit Mold" class="label label-warning"><span class="fa fa-pencil"></span></a>
                                    <?php if($isi->INT_FLAG_DELETE == 1){?>
                                        <a href="<?php echo base_url('index.php/mte/mold_c/deactivate') . "/" . $isi->CHR_CODE_MOLD; ?>" class="label label-success" data-placement="top" data-toggle="tooltip" title="Deactivate" onclick="return confirm('Are you sure want to deactivate this mold?');"><span class="fa fa-power-off"></span></a>
                                    <?php } else { ?>
                                        <a href="<?php echo base_url('index.php/mte/mold_c/activate') . "/" . $isi->CHR_CODE_MOLD; ?>" class="label label-danger" data-placement="top" data-toggle="tooltip" title="Activate" onclick="return confirm('Are you sure want to activate this mold?');"><span class="fa fa-power-off"></span></a>
                                    <?php } ?>
                                    
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

                <?php

                foreach ($data as $isi) {
                    ?>
                    <!--EDIT Vacancy-->
                    <div class="modal fade" id="modaledit<?php echo $isi->CHR_CODE_MOLD; ?>" tabindex="-1" role="dialog" aria-labelledby="modaledit" aria-hidden="true" style="display: none;">
                        <div class="modal-wrapper">
                            <div class="modal-dialog">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true"><i class="fa fa-times"></i></button>
                                        <h4 class="modal-title" id="modaledit"><strong>Edit Mold</strong></h4>
                                    </div>
                                    <div class="modal-body">
                                    <?php echo form_open('mte/mold_c/update_mold', 'class="form-horizontal"'); ?>

                                        <input name="CHR_CODE_MOLD" class="form-control" required type="hidden" style="width: 300px;" value="<?php echo $isi->CHR_CODE_MOLD ?>">
                            
                                        <div class="form-group">
                                            <label class="col-sm-3 control-label">Mold Name</label>
                                            <div class="col-sm-8">
                                                <input name="CHR_MOLD_NAME" class="form-control" type="text" required value="<?php echo $isi->CHR_MOLD_NAME; ?>">
                                            </div>
                                        </div>

                                        <div class="form-group">
                                            <label class="col-sm-3 control-label">Model Name</label>
                                            <div class="col-sm-8">
                                                <input name="CHR_MODEL" class="form-control" type="text" required value="<?php echo $isi->CHR_MODEL; ?>">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="modal-footer">
                                        <div class="btn-group">
                                            <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                                            <button type="submit" class="btn btn-primary" data-placement="left" data-toggle="tooltip" title="Save this data"><i class="fa fa-check"></i> Update</button>
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

            </div>
        </div>
    </section>
</aside>


