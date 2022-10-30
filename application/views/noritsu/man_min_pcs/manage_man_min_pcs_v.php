<aside class="right-side">
    <section class="content-header">
        <ol class="breadcrumb">
            <li><a href="<?php echo base_url('index.php/basis/home_c/"') ?>"><span>Home</span></a></li>
            <li> <a href="#"><strong>Manage Man Minute / Pcs</strong></a></li>
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
                        <span class="grid-title"><strong>MAN MINUTE / PCS</strong> TABLE</span>
                        <div class="pull-right">
                            <a href="<?php echo base_url('index.php/noritsu/man_min_pcs_c/create_man_min_pcs/') ?>" class="btn btn-default" data-toggle="tooltip" data-placement="left" title="Create Man Minute / Pcs" style="height:30px;font-size:13px;width:100px;">Create</a>
                        </div>
                    </div>
                    <div class="grid-body">
                        <!-- Isi Table -->
                        <table id="dataTables1" class="table table-striped table-condensed table-hover display" cellspacing="0" width="100%">
                            <thead>
                                <tr>
                                    <th>No</th>
                                    <th>Work Center</th>
                                    <th>Part No</th>
                                    <th>Back No</th>
                                    <th>Part Name</th>
                                    <th>Man Min/Pcs</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                $i = 1;
                                foreach ($data as $isi) {
                                    echo "<tr class='gradeX'>";
                                    echo "<td>$i</td>";
                                    echo "<td>".trim($isi->CHR_WORK_CENTER)."</td>";
                                    echo "<td>".trim($isi->CHR_PART_NO)."</td>";
                                    echo "<td>".trim($isi->CHR_BACK_NO)."</td>";
                                    echo "<td>".trim($isi->CHR_PART_NAME)."</td>";
                                    echo "<td>$isi->CHR_MAN_MIN_PCS</td>";
                                    ?>
                                <td>
                                    <a data-toggle="modal" data-target="#modaledit<?php echo $i; ?>" data-placement="left" data-toggle="tooltip" title="Edit Man Min/Pcs" class="label label-warning"><span class="fa fa-pencil"></span></a>
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
                $j = 1;
                foreach ($data as $isi) {
                    ?>
                    <!--EDIT Vacancy-->
                    <div class="modal fade" id="modaledit<?php echo $j; ?>" tabindex="-1" role="dialog" aria-labelledby="modaledit" aria-hidden="true" style="display: none;">
                        <div class="modal-wrapper">
                            <div class="modal-dialog">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true"><i class="fa fa-times"></i></button>
                                        <h4 class="modal-title" id="modaledit"><strong>Edit Man Min/Pcs</strong></h4>
                                    </div>
                                    <div class="modal-body">
                                    <?php echo form_open('noritsu/man_min_pcs_c/update_man_min_pcs', 'class="form-horizontal"'); ?>

                                        <input name="CHR_PART_NO" class="form-control" required type="hidden" style="width: 300px;" value="<?php echo $isi->CHR_PART_NO ?>">
                            
                                        <div class="form-group">
                                            <label class="col-sm-3 control-label">Man Min/Pcs</label>
                                            <div class="col-sm-8">
                                                <input type="text" name="CHR_MAN_MIN_PCS" class="form-control" value="<?php echo trim($isi->CHR_MAN_MIN_PCS); ?>">  
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
                    $j++;
                }
                ?>

    </section>
</aside>


