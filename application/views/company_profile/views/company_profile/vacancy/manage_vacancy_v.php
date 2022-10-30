<aside class="right-side">
    <section class="content-header">
        <ol class="breadcrumb">
            <li><a href="<?php echo base_url('index.php/basis/home_c/"') ?>"><span>Home</span></a></li>
            <li> <a href="#"><strong>Manage Vacancy</strong></a></li>
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
                        <span class="grid-title"><strong>VACANCY</strong> TABLE</span>
                        <div class="pull-right">
                            <!-- <a href="<?php echo base_url('index.php/company_profile/vacancy_c/create_vacancy/') ?>" class="btn btn-default" data-toggle="tooltip" data-placement="left" title="Create Vacancy" style="height:30px;font-size:13px;width:100px;">Create</a> -->
                            <a href="#modaladd" class="btn btn-default" data-toggle="modal" data-placement="left" title="Create Vacancy" style="height:30px;font-size:13px;width:100px;">Create</a>
                        </div>
                    </div>
                    <div class="grid-body">
                        <table id="dataTables1" class="table table-striped table-condensed table-hover display" cellspacing="0" width="100%">
                            <thead>
                                <tr>
                                    <th>No</th>
                                    <th>Vacancy Name</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                $i = 1;
                                foreach ($data as $isi) {
                                    echo "<tr class='gradeX'>";
                                    echo "<td>$i</td>";
                                    echo "<td>$isi->CHR_VACANCY_NAME</td>";    
                                ?>
                                <td>
                                    <a data-toggle="modal" data-target="#modaledit<?php echo $isi->INT_ID_VACANCY; ?>" data-placement="left" data-toggle="tooltip" title="Edit Vacancy" class="label label-warning"><span class="fa fa-pencil"></span></a>

                                    <a href="<?php echo base_url('index.php/company_profile/vacancy_detail_c/index'). "/" . $isi->INT_ID_VACANCY; ?>" class="label label-warning" data-placement="top" data-toggle="tooltip" title="View Requirements"><span class="fa fa-list"></a>

                                    <?php if($isi->INT_STATUS == 0) {?>
                                    <a href="<?php echo base_url('index.php/company_profile/vacancy_c/activate') . "/" . $isi->INT_ID_VACANCY; ?>" class="label label-danger" data-placement="top" data-toggle="tooltip" title="Activate" onclick="return confirm('Are you sure want to activate this vacancy?');"><span class="fa fa-power-off"></span></a>
                                    <?php } else { ?>
                                    <a href="<?php echo base_url('index.php/company_profile/vacancy_c/deactivate') . "/" . $isi->INT_ID_VACANCY; ?>" class="label label-success" data-placement="top" data-toggle="tooltip" title="Deactivate" onclick="return confirm('Are you sure want to deactivate this vacancy?');"><span class="fa fa-power-off"></span></a>
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

                <!-- Modal Add Vacancy -->
                <div class="modal fade" id="modaladd" tabindex="-1" role="dialog" aria-labelledby="modalprogress" aria-hidden="true" style="display: none;">
                    <div class="modal-wrapper">
                        <div class="modal-dialog">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                                    <h4 class="modal-title" id="modalprogress"><strong>Add Vacancy</strong></h4>
                                </div>
                                <div class="modal-body">
                            <?php echo form_open('company_profile/vacancy_c/save_vacancy', 'class="form-horizontal"'); ?>

                                    <div class="form-group">
                                        <label class="col-sm-3 control-label">Vacancy Name</label>
                                        <div class="col-sm-5">
                                            <input name="CHR_VACANCY_NAME" class="form-control" required type="text" required>
                                        </div>
                                    </div>
                                </div>
                                <div class="modal-footer">
                                    <div class="btn-group">
                                        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                                        <button type="submit" class="btn btn-primary" data-placement="left" data-toggle="tooltip" title="Save this data"><i class="fa fa-check"></i> Save</button>
                            <?php echo form_close(); ?>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <?php

                foreach ($data as $isi) {
                    ?>
                    <!--EDIT Vacancy-->
                    <div class="modal fade" id="modaledit<?php echo $isi->INT_ID_VACANCY; ?>" tabindex="-1" role="dialog" aria-labelledby="modaledit" aria-hidden="true" style="display: none;">
                        <div class="modal-wrapper">
                            <div class="modal-dialog">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                                        <h4 class="modal-title" id="modaledit"><strong>Edit Vacancy</strong></h4>
                                    </div>
                                    <div class="modal-body">
                                    <?php echo form_open('company_profile/vacancy_c/update_vacancy', 'class="form-horizontal"'); ?>

                                        <input name="INT_ID_VACANCY" class="form-control" required type="hidden" style="width: 300px;" value="<?php echo $isi->INT_ID_VACANCY ?>">
                            
                                        <div class="form-group">
                                            <label class="col-sm-3 control-label">Vacancy Name</label>
                                            <div class="col-sm-8">
                                                <input name="CHR_VACANCY_NAME" class="form-control" type="text" required value="<?php echo $isi->CHR_VACANCY_NAME; ?>">
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


