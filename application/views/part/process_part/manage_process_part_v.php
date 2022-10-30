
<style type="text/css">
    th, td { white-space: nowrap; }
    div.dataTables_wrapper {
        margin: 0 auto;
    }
    #table-luar{
        font-size: 11px;
    }
    #filter { 
        /* border-spacing: 10px; */
        -webkit-border-horizontal-spacing: 0px;
        -webkit-border-vertical-spacing: 10px;
        border-collapse: separate;
    }
    .td-fixed{
        width: 30px;
    }
    .td-no{
        width: 10px;
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
            <li><a href="<?php echo base_url('index.php/part/process_part_c') ?>"><strong>Cycle Time</strong></a></li>
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
                        <span class="grid-title"><strong>MASTER CYCLE TIME</strong></span>
                        <div class="pull-right grid-tools">
                        <?php //if($id_role == 1){ ?>
                            <a href="<?php echo base_url('index.php/part/process_part_c/create_process_part/' . $work_center) ?>"  class="btn btn-primary" data-placement="left" data-toggle="tooltip" title="Upload Cycle Time" style="height:30px;font-size:13px;width:100px;color:white;margin-top:-5px;margin-bottom:-5px;">Upload</a>
                        <?php //} ?>
                        </div>
                    </div>
                    <div class="grid-body">
                        <div class="pull">
                            <table width="100%" id='filter'>
                                <tr>
                                    <td width="10%">
                                        <select id="e1" style='width:160px;' onChange="document.location.href = this.options[this.selectedIndex].value;">
                                            <?php foreach ($all_work_centers as $row) { ?>
                                                <option value="<?php echo site_url('part/process_part_c/index/' . trim($row->CHR_WORK_CENTER)); ?>"  <?php
                                                if (trim($work_center) == trim($row->CHR_WORK_CENTER)) {
                                                    echo 'selected';
                                                }
                                                ?> > <?php echo trim($row->CHR_WORK_CENTER); ?> </option>
                                            <?php } ?>
                                        </select>
                                    </td>
                                    <td width="90%"></td>
                                </tr>
                            </table>
                        </div>

                        <table id="dataTables3" class="table table-condensed table-striped table-hover display" cellspacing="0" width="100%">
                            <thead>
                                <tr>
                                    <th style="text-align:center;">No</th>
                                    <th style="text-align:center;">Work Center</th>
                                    <th style="text-align:center;">Part No AII</th>
                                    <th style="text-align:center;">Back No</th>
                                    <th style="text-align:center;">Cycle Time (s)</th>
                                    <th style="text-align:center;">Man Power</th>
                                    <?php if($id_role == 1){ ?>
                                        <th style="text-align:center;">Actions</th>
                                    <?php } ?>
                                </tr>
                            </thead>
                            <tbody>
                            <?php
                            $i = 1;
                            foreach ($data as $isi) {
                                echo "<td style='text-align:center;'>$i</td>";
                                echo "<td style='text-align:center;'>$isi->CHR_WORK_CENTER</td>";
                                echo "<td style='text-align:center;'>$isi->PART_NO</td>";
                                echo "<td style='text-align:center;'>$isi->CHR_BACK_NO</td>";
                                echo "<td style='text-align:center;'>$isi->INT_CYCLE_TIME</td>";
                                echo "<td style='text-align:center;'>$isi->INT_MP</td>";
                                ?>
                                <?php //if($id_role == 1){ ?>
                                <td style='text-align:center;'>
                                    <a data-toggle="modal" data-target="#modalEditCt<?php echo trim($isi->PART_NO) ?>" data-placement="left" data-toggle="tooltip" title="Edit Cycle Time" class="label label-warning"><span class="fa fa-pencil"></span></a>
                                </td>
                                <?php //} ?>
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
                    <div class="modal fade" id="modalEditCt<?php echo trim($isi->PART_NO) ?>" tabindex="-1" role="dialog" aria-labelledby="modalprogress" aria-hidden="true" style="display: none;">

                            <div class="modal-wrapper">
                                <div class="modal-dialog">
                                    
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                                            <h4 class="modal-title" id="modalprogress"><strong>Edit Cycle Time</strong></h4>
                                        </div>
                                        
                                        <div class="modal-body">
                                            <?php echo form_open('part/process_part_c/update_process_part', 'class="form-horizontal"'); ?>

                                            <input name="CHR_WORK_CENTER" class="form-control" id='work_center_id' type="hidden" style="width: 300px;" value="<?php echo trim($work_center) ?>">
                                            <input name="CHR_PART_NO" class="form-control" required type="hidden" style="width: 300px;" value="<?php echo trim($isi->PART_NO) ?>">

                                            <div class="form-group">
                                                <label class="col-sm-3 control-label">Cycle Time</label>
                                                <div class="col-sm-5">
                                                    <input type="number" step=".1" name="INT_CYCLE_TIME" class="form-control" required value="<?php echo trim($isi->INT_CYCLE_TIME) ?>" >
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

    </section>
</aside>
