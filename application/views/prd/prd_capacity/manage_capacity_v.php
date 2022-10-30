
<aside class="right-side">
    <section class="content-header">
        <ol class="breadcrumb">
            <li><a href="<?php echo base_url('index.php/basis/home_c/') ?>"><span>Home</span></a></li>
            <li> <a href="#"><strong>MANAGE CAPACITY WORK CENTER</strong></a></li>
        </ol>
    </section>
    <section class="content">
        <?php
        if ($msg != NULL) {
            echo $msg;
        }
        ?>
        <div class="row">
            <div class="col-md-12">
                <div class="grid">
                    <div class="grid-header">
                        <i class="fa fa-th"></i>
                        <span class="grid-title"><strong>MANAGE CAPACITY & SCHEDULE WORK CENTER</strong></span>
                        <div class="pull-right grid-tools">
                            <a href="<?php echo base_url('index.php/prd/prd_capacity_c/create_capacity/') ?>" class="btn btn-default" data-toggle="tooltip" data-placement="left" title="Create Pos" style="height:30px;font-size:13px;width:100px;color:#000000;">Create</a>
                        </div>
                    </div>                    
                    <div class="grid-body">
                        <div class="pull">
                            <table width="100%" id='filter' border=0px>
                                <tr>
                                    <td width="5%">Dept</td>
                                    <td width="5%">
                                        <select class="ddl" onChange="document.location.href = this.options[this.selectedIndex].value;">
                                            <?php foreach ($all_dept_prod as $row) { ?>
                                                <option value="<?php echo site_url('prd/prd_capacity_c/index/0/' . trim($row->INT_ID_DEPT)); ?>"  <?php
                                            if ($id_dept == trim($row->INT_ID_DEPT)) {
                                                echo 'selected';
                                            }
                                                ?> > <?php echo trim($row->CHR_DEPT); ?> </option>
                                                    <?php } ?>
                                        </select>
                                    </td>
                                    <td width="5%" colspan="4"></td>
                                    <td width="5%"></td>
                                    <td width="55%"></td>
                                </tr>
                            </table>
                        </div>
                        <div>&nbsp;</div>
                        <table id="dataTables3" class="table table-condensed table-striped table-hover display" cellspacing="0" width="100%">
                            <thead>
                                <tr>
                                    <th style='vertical-align: middle;text-align:center;'>No</th>
                                    <th style='vertical-align: middle;text-align:center;'>Work Center</th>
                                    <th style='vertical-align: middle;text-align:center;'>Shift</th>
                                    <th style='vertical-align: middle;text-align:center;'>Capacity</th>
                                    <th style='vertical-align: middle;text-align:center;'>Schedule Chute</th>
                                    <th style='vertical-align: middle;text-align:center;'>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                $i = 1;
                                foreach ($data as $row) {
                                    echo "<tr class='gradeX'>";
                                    echo "<td style='text-align:center;'>$i</td>";
                                    echo "<td style='text-align:center;'>$row->CHR_WORK_CENTER</td>";
                                    echo "<td style='text-align:center;'>$row->INT_SHIFT</td>";
                                    echo "<td style='text-align:center;'>$row->INT_CAPACITY_PRD</td>";
                                    echo "<td style='text-align:center;'>" . substr($row->CHR_SCHEDULE_CHUTE, 0, 2) . ":" . substr($row->CHR_SCHEDULE_CHUTE, 2, 2) . "</td>";
                                   
                                    ?>
                                <td  style='text-align:center;'>
                                    <!--<a href="<?php echo base_url('index.php/prd/prd_capacity_c/view_capacity') . "/" . trim($row->INT_ID); ?>" class="label label-success" data-placement="left" data-toggle="tooltip" title="View"><span class="fa fa-check"></span></a>-->
                                    <a data-toggle="modal" data-target="#modalEditCapacity<?php echo trim($row->INT_ID); ?>" class="label label-warning" data-placement="top" data-toggle="tooltip" title="Edit"><span class="fa fa-pencil"></span></a>
                                    <!--<a href="<?php echo base_url('index.php/prd/prd_capacity_c/edit_capacity') . '/' . trim($row->INT_ID); ?>" class="label label-warning" data-placement="top" data-toggle="tooltip" title="Edit"><span class="fa fa-pencil"></span></a>-->
                                    <a href="<?php echo base_url('index.php/prd/prd_capacity_c/delete_capacity') . "/" . trim($row->INT_ID) . "/" . $id_dept ?>" class="label label-danger" data-placement="right" data-toggle="tooltip" title="Delete" onclick="return confirm('Are you sure want to DELETE this Capacity & Schedule ?');"><span class="fa fa-times"></span></a>
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
                <?php foreach ($data as $row) { ?>
                    <div class="modal fade" id="modalEditCapacity<?php echo $row->INT_ID; ?>" tabindex="-1" role="dialog" aria-labelledby="modalprogress" aria-hidden="true" style="display: none;">
                        <div class="modal-wrapper">
                            <div class="modal-dialog">                                    
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                                        <h4 class="modal-title" id="modalprogress"><strong>Edit Capacity & Schedule</strong></h4>
                                    </div>

                                    <div class="modal-body">
                                    <?php echo form_open('prd/prd_capacity_c/update_capacity', 'class="form-horizontal"'); ?>

                                        <input name="INT_ID" class="form-control" id='id' required type="hidden" style="width: 300px;" value="<?php echo $row->INT_ID; ?>">
                                        <input name="ID_DEPT" class="form-control" id='id_dept' required type="hidden" style="width: 300px;" value="<?php echo $id_dept; ?>">
                                        <div class="form-group">
                                            <label class="col-sm-3 control-label">Dept</label>
                                            <div class="col-sm-5">
                                                <input type="text" name="CHR_DEPT" class="form-control" readonly value="<?php echo trim($row->CHR_DEPT); ?>" >
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label class="col-sm-3 control-label">Work Center</label>
                                            <div class="col-sm-5">
                                                <input type="text" name="CHR_WORK_CENTER" class="form-control" readonly value="<?php echo trim($row->CHR_WORK_CENTER); ?>" >
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label class="col-sm-3 control-label">Shift</label>
                                            <div class="col-sm-5">
                                                <input type="number" min="1" max="4" name="INT_SHIFT" class="form-control" required value="<?php echo trim($row->INT_SHIFT); ?>" >
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label class="col-sm-3 control-label">Capacity</label>
                                            <div class="col-sm-5">
                                                <input type="number" min="0" name="INT_CAPACITY" class="form-control" required value="<?php echo trim($row->INT_CAPACITY_PRD); ?>" >
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label class="col-sm-3 control-label">Schedule Chute <i>(HHmm)</i></label>
                                            <div class="col-sm-5">
                                                <input type="text" name="CHR_SCHEDULE" class="form-control" pattern=".{4,4}" required placeholder="HHmm" value="<?php echo trim($row->CHR_SCHEDULE_CHUTE); ?>" >
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
                    </div>
                 <?php }   ?>
            </div>
        </div>
    </section>
</aside>


