
<style type="text/css">
    th, td { white-space: nowrap; }
    div.dataTables_wrapper {
        margin: 0 auto;
    }
    #table-luar{
        font-size: 11px;
    }
    #filter { 
        border-spacing: 10px;
        border-collapse: separate;
    }
    .ddl{
        width: 100px;
        height: 30px;
    }
    .ddl2{
        width: 180px;
        height: 30px;
    }
</style>

<aside class="right-side">
    <section class="content-header">
        <ol class="breadcrumb">
            <li><a href="<?php echo base_url('index.php/basis/home_c') ?>"><span>Home</span></a></li>
            <li><a href="<?php echo base_url('index.php/part/process_part_c/process_part_target') ?>"><strong>Manage Target Parts</strong></a></li>
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
                        <i class="fa fa-clock-o"></i>
                        <span class="grid-title"><strong>MANAGE TARGET PARTS</strong></span>
                        <div class="pull-right grid-tools">
                            <a href="<?php echo base_url('index.php/part/process_part_c/create_process_part_target/' . $group . '/' . $period) ?>"  class="btn btn-primary" data-placement="left" data-toggle="tooltip" title="Upload Target Parts" style="height:30px;font-size:13px;width:100px;color:white;margin-top:-5px;margin-bottom:-5px;">Upload</a>
                        </div>
                    </div>
                    <div class="grid-body">
                        <div class="pull">
                            <table width="100%" id='filter'>
                                <tr>
                                    <td>
                                        <select class="ddl2" onChange="document.location.href = this.options[this.selectedIndex].value;">
                                            <?php foreach ($all_group as $row) { ?>
                                                <option value="<?php echo site_url('part/process_part_c/process_part_target/' . trim($row->CHR_PRODUCT_GROUP) . '/' . $period); ?>"  <?php
                                            if ($group == trim($row->CHR_PRODUCT_GROUP)) {
                                                echo 'selected';
                                            }
                                                ?> > <?php echo trim($row->CHR_PRODUCT_GROUP); ?> </option>
                                                    <?php } ?>
                                        </select>
                                   
                                        <select class="ddl" onChange="document.location.href = this.options[this.selectedIndex].value;">
                                            <?php for ($x = -3; $x <= 3; $x++) { $y = $x * 28 ?>
                                                <option value="<?php echo site_url('part/process_part_c/process_part_target/' . $group .'/'. date("Ym", strtotime("+$x month"))); ?>" <?php
                                                if ($period == date("Ym", strtotime("+$x month"))) {
                                                    echo 'SELECTED';
                                                }
                                                ?> > <?php echo date("M Y", strtotime("+$x month")); ?> 
                                                </option>
                                                    <?php } ?>

                                         </select>
                                    </td>
                                </tr>
                            </table>
                        </div>

                        <table id="dataTables3" class="table table-condensed table-striped table-hover display" cellspacing="0" width="100%">
                            <thead>
                                <tr>
                                    <th style="text-align:center;">No</th>
                                    <th style="text-align:center;">Work Center</th>
                                    <th style="text-align:center;">Part No</th>
                                    <th style="text-align:center;">Prouction Version</th>
                                    <th style="text-align:center;">Target Production</th>
                                    <th style="text-align:center;">Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                            <?php
                            $i = 1;
                            foreach ($data as $isi) {
                                echo "<td style='text-align:center;'>$i</td>";
                                echo "<td style='text-align:center;'>$isi->CHR_WORK_CENTER</td>";
                                echo "<td style='text-align:center;'>$isi->CHR_PART_NO</td>";
                                echo "<td style='text-align:center;'>$isi->CHR_PV</td>";
                                echo "<td style='text-align:center;'>$isi->INT_TARGET_PRODUCTION</td>";
                                ?>
                                <td style='text-align:center;'>
                                    <a data-toggle="modal" data-target="#modalEditCt<?php echo trim($isi->CHR_PART_NO).trim($isi->CHR_WORK_CENTER).trim($isi->CHR_PV) ?>" data-placement="left" data-toggle="tooltip" title="Edit Target Part" class="label label-warning"><span class="fa fa-pencil"></span></a>
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

            <?php foreach ($data as $isi) { ?>
                    <div class="modal fade" id="modalEditCt<?php echo trim($isi->CHR_PART_NO).trim($isi->CHR_WORK_CENTER).trim($isi->CHR_PV) ?>" tabindex="-1" role="dialog" aria-labelledby="modalprogress" aria-hidden="true" style="display: none;">

                            <div class="modal-wrapper">
                                <div class="modal-dialog">
                                    
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                                            <h4 class="modal-title" id="modalprogress"><strong>Edit Target Part</strong></h4>
                                        </div>
                                        
                                        <div class="modal-body">
                                            <?php echo form_open('part/process_part_c/update_process_part_target', 'class="form-horizontal"'); ?>

                                            <input name="INT_PRODUCT_CODE" class="form-control" id='dept_id' type="hidden" style="width: 300px;" value="<?php echo trim($group) ?>">
                                            <input name="CHR_PERIOD" class="form-control" id='period_id' type="hidden" style="width: 300px;" value="<?php echo trim($period) ?>">
                                            <input name="CHR_PART_NO" class="form-control" required type="hidden" style="width: 300px;" value="<?php echo trim($isi->CHR_PART_NO) ?>">
                                            <input name="CHR_WORK_CENTER" class="form-control" required type="hidden" style="width: 300px;" value="<?php echo trim($isi->CHR_WORK_CENTER) ?>">
                                            <input name="CHR_PV" class="form-control" required type="hidden" style="width: 300px;" value="<?php echo trim($isi->CHR_PV) ?>">

                                            <div class="form-group">
                                                <label class="col-sm-3 control-label">Target Part</label>
                                                <div class="col-sm-5">
                                                    <input type="number" step=".1" name="INT_TARGET_PRODUCTION" class="form-control" required value="<?php echo trim($isi->INT_TARGET_PRODUCTION) ?>" >
                                                </div>
                                            </div>

                                            <div class="modal-footer">
                                                <div class="btn-group">
                                                    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                                                    <button type="submit" class="btn btn-primary" data-placement="left" data-toggle="tooltip" title="Save this data"><i class="fa fa-check"></i> Update</button>
                                                </div>
                                            </div>

                                            <?php echo form_close(); ?>

                                        </div>

                                    </div>
                                </div>
                            </div>
                    </div>
                 <?php }   ?>

    </section>
</aside>
