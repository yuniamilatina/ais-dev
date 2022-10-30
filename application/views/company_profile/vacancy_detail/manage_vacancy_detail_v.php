<aside class="right-side">
    <section class="content-header">
        <ol class="breadcrumb">
            <li><a href="<?php echo base_url('index.php/basis/home_c/"') ?>"><span>Home</span></a></li>
            <li><a href="<?php echo base_url('index.php/company_profile/vacancy_c/"') ?>"><span>Manage Vacancy</span></a></li>
            <li> <a href="#"><strong>Manage Requirements</strong></a></li>
        </ol>
    </section>
    <?php
    foreach ($vacancy as $vac) {
        $vacancy = $vac->CHR_VACANCY_NAME;
        $id = $vac->INT_ID_VACANCY;
    }
    
    ?>
    <section class="content">
        <?php if ($msg != NULL) {
            echo $msg;
        } ?>

        <div class="row">
            <div class="col-md-12">
                <div class="grid">
                    <div class="grid-header">
                        <i class="fa fa-file-text"></i>
                        <span class="grid-title"><strong><?php echo $vacancy; ?></strong> REQUIREMENTS</span>
                        <div class="pull-right">
                            <!-- <button data-toggle="modal" data-target="#modaladd<?php echo $id; ?>" data-placement="left" data-toggle="tooltip" title="Give Feedback" class="btn btn-primary"><i class="fa fa-plus"></i>&nbsp; Add Requirement</button> -->

                            <a href="#modaladd<?php echo $id; ?>" class="btn btn-default" data-toggle="modal" data-placement="left" title="Create Vacancy" style="height:30px;font-size:13px;width:100px;">Create</a>
                        </div>
                    </div>
                    <div class="grid-body">
                        <div id="table-luar">
                            <table id="dataTables1" class="table table-condensed display" cellspacing="0" width="100%">
                                <thead>
                                <tr>
                                    <th>No</th>
                                    <th>Requirement</th>
                                    <th>Category</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                $i = 1;
                                foreach ($data as $isi) {
                                    echo "<tr class='gradeX'>";
                                    echo "<td>$i</td>";
                                    echo "<td>$isi->CHR_DESCRIPTION</td>";  
                                    echo "<td>$isi->CHR_CATEGORY</td>";    
                                ?>
                                <td>
                                    <a data-toggle="modal" data-target="#modaledit<?php echo $id . $isi->INT_ID_VACANCY_DETAIL; ?>" data-placement="left" data-toggle="tooltip" title="Edit Requirement" class="label label-warning"><span class="fa fa-pencil"></span></a>
                                </td>

                                </tr>
                                <?php
                                $i++;
                            }
                            ?>
                            </tbody>

                            </table>
                        </div>
                        
                        <!-- <button data-toggle="modal" data-target="#modaladd<?php echo $id; ?>" data-placement="left" data-toggle="tooltip" title="Give Feedback" class="btn btn-primary"><i class="fa fa-plus"></i>&nbsp; Add Requirement</button> -->
                    
                        <?php
                        echo anchor('company_profile/vacancy_c', 'Back', 'class="btn btn-default" data-toggle="tooltip" data-placement="right" title="Back to manage"');
                        ?>
                    </div>
                </div>

                <!-- Modal Add Requirement -->
                <div class="modal fade" id="modaladd<?php echo $id ?>" tabindex="-1" role="dialog" aria-labelledby="modalprogress" aria-hidden="true" style="display: none;">
                    <div class="modal-wrapper">
                        <div class="modal-dialog">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                                    <h4 class="modal-title" id="modalprogress"><strong>Add Requirement</strong></h4>
                                </div>
                                <div class="modal-body">
                            <?php echo form_open('company_profile/vacancy_detail_c/save_vacancy_detail', 'class="form-horizontal"'); ?>
                                
                                    <input name="INT_ID_VACANCY" class="form-control" required type="hidden" style="width: 300px;" value="<?php echo $id; ?>">

                                    <div class="form-group">
                                        <label class="col-sm-3 control-label">Requirement Desc</label>
                                        <div class="col-sm-5">
                                            <textarea rows="2" cols="500" name="CHR_DESCRIPTION" class="form-control" required></textarea>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label class="col-sm-3 control-label">Category</label>
                                        <div class="col-sm-5">
                                            <select name="CHR_CATEGORY" class="form-control" required>
                                                <option disabled selected>-- Select Category --</option>
                                                <option value="SMA/SMK" >SMA/SMK</option>
                                                <option value="D3">D3</option>
                                                <option value="D4/S1" >D4/S1</option>
                                            </select>
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

                <!-- Modal Edit Requirement -->
                <?php
                // $i = 1;
                // $numrows = $count_progress;

                foreach ($data as $isi_modal) {
                    ?>
                    <!--EDIT FEEDBACK-->
                    <div class="modal fade" id="modaledit<?php echo $id . $isi_modal->INT_ID_VACANCY_DETAIL; ?>" tabindex="-1" role="dialog" aria-labelledby="modaledit" aria-hidden="true" style="display: none;">
                        <div class="modal-wrapper">
                            <div class="modal-dialog">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                                        <h4 class="modal-title" id="modaledit"><strong>Edit Requirement</strong></h4>
                                    </div>
                                    <div class="modal-body">
                                <?php echo form_open('company_profile/vacancy_detail_c/update_vacancy_detail', 'class="form-horizontal"'); ?>

                                        <input name="INT_ID_VACANCY" class="form-control" required type="hidden" style="width: 300px;" value="<?php echo $isi_modal->INT_ID_VACANCY ?>">
                                        <input name="INT_ID_VACANCY_DETAIL" class="form-control" required type="hidden" style="width: 300px;" value="<?php echo $isi_modal->INT_ID_VACANCY_DETAIL ?>">

                                        <div class="form-group">
                                            <label class="col-sm-3 control-label">Requirement Desc</label>
                                            <div class="col-sm-8">
                                                <textarea rows="5" cols="500" name="CHR_DESCRIPTION" class="form-control" required><?php echo trim($isi_modal->CHR_DESCRIPTION); ?></textarea>
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label class="col-sm-3 control-label">Category</label>
                                            <div class="col-sm-8">
                                                <select name="CHR_CATEGORY" class="form-control" required>
                                                    <option disabled selected>-- Select Category --</option>
                                                    <option value="SMA/SMK" <?php if($isi_modal->CHR_CATEGORY=='SMA/SMK'){ echo 'selected';} ?>>SMA/SMK</option>
                                                    <option value="D3" <?php if(trim($isi_modal->CHR_CATEGORY)=='D3'){ echo 'selected';} ?>>D3</option>
                                                    <option value="D4/S1" <?php if(trim($isi_modal->CHR_CATEGORY)=='D4/S1'){ echo 'selected';} ?>>D4/S1</option>
                                                </select>
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


