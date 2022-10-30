
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
            <li><a href="<?php echo base_url('index.php/part/process_part_c/method_part') ?>"><strong>Manage Methods Part</strong></a></li>
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
                        <i class="fa fa-table"></i>
                        <span class="grid-title"><strong>METHODS SCAN PART</strong></span>
                        <div class="pull-right grid-tools">
                            <a data-widget="collapse" title="Collapse"><i class="fa fa-chevron-up"></i></a>
                        </div>
                    </div>
                    <div class="grid-body">
                        <div class="pull">
                            <table width="20%" id='filter' border=0px>
                                <tr>
                                    <td width="5%">Work Center</td>
                                    <td width="10%">
                                        <select id="e2" onChange="document.location.href = this.options[this.selectedIndex].value;">
                                            <?php foreach ($all_work_centers as $row) { ?>
                                                <option value="<?php echo site_url('part/process_part_c/method_part/' . trim($row->CHR_WCENTER)); ?>"  <?php
                                                if ($work_center == trim($row->CHR_WCENTER)) {
                                                    echo 'selected';
                                                }
                                                ?> > <?php echo trim($row->CHR_WCENTER); ?> </option>
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
                                    <th style="text-align:center;">Part Name</th>
                                    <th style="text-align:center;">Part No Customer</th>
                                    <th style="text-align:center;">Back No</th>
                                    <th style="text-align:center;">Scan Method</th>
                                    <th style="text-align:center;">Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                            <?php
                            $i = 1;
                            foreach ($data as $isi) {
                                if($isi->INT_FLG_METHODS == 0 ){
                                    $scan_method = 'Kanban';
                                }elseif($isi->INT_FLG_METHODS == 1 ){
                                    $scan_method = 'Label';
                                }else{
                                    $scan_method = 'Product';
                                }
                                echo "<td style='text-align:center;'>$i</td>";
                                echo "<td style='text-align:center;'>$isi->CHR_WORK_CENTER</td>";
                                echo "<td style='text-align:center;'>$isi->CHR_PART_NO</td>";
                                echo "<td style='text-align:center;'>$isi->CHR_PART_NAME</td>";
                                echo "<td style='text-align:center;'>$isi->CHR_CUS_PART_NO</td>";
                                echo "<td style='text-align:center;'>$isi->CHR_BACK_NO</td>";
                                echo "<td style='text-align:center;'>$scan_method</td>";
                                ?>
                                <td style='text-align:center;'>
                                    <a data-toggle="modal" data-target="#modalEdit<?php echo trim($isi->CHR_PART_NO).trim($isi->CHR_WORK_CENTER) ?>" class="label label-warning" data-placement="top" data-toggle="tooltip" title="Edit"><span class="fa fa-pencil"></span></a>
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
            <div class="modal fade" id="modalEdit<?php echo trim($isi->CHR_PART_NO).trim($isi->CHR_WORK_CENTER) ?>" tabindex="-1" role="dialog" aria-labelledby="modalprogress" aria-hidden="true" style="display: none;">

                <div class="modal-wrapper">
                    <div class="modal-dialog">
                        
                        <div class="modal-content">
                            <div class="modal-header">
                                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                                <h4 class="modal-title" id="modalprogress"><strong>Edit Method</strong></h4>
                            </div>
                            
                            <div class="modal-body">
                                <?php echo form_open('part/process_part_c/update_method_part', 'class="form-horizontal"'); ?>

                                <div class="form-group">
                                    <label class="col-sm-4 control-label">Work Center</label>
                                    <div class="col-sm-3">
                                        <input name="CHR_WORK_CENTER" class="form-control" autocomplete="off" readonly value="<?php echo $isi->CHR_WORK_CENTER; ?>">
                                    </div>
                                </div>
                                
                                <div class="form-group">
                                        <label class="col-sm-4 control-label">Part No (Aisin)</label>
                                        <div class="col-sm-4" >
                                            <input name="CHR_PART_NO"  class="form-control" autocomplete="off" readonly value="<?php echo $isi->CHR_PART_NO; ?>">
                                        </div>
                                </div>

                                <div class="form-group">
                                        <label class="col-sm-4 control-label">Scan Method</label>
                                        <div class="col-sm-3" >
                                            <select class="form-control" name="INT_FLG_METHODS" required style="width:200px;">
                                                <option <?php if($isi->INT_FLG_METHODS == 0) echo 'selected' ?> value="0">Kanban</option>
                                                <option <?php if($isi->INT_FLG_METHODS == 1) echo 'selected' ?> value="1">Label</option>
                                                <option <?php if($isi->INT_FLG_METHODS == 2) echo 'selected' ?> value="2">Product</option>
                                            </select>
                                        </div>
                                </div>

                                <div class="modal-footer">
                                    <div class="btn-group">
                                        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                                        <button type="submit" class="btn btn-primary" data-placement="left" data-toggle="tooltip" title="Update this data"><i class="fa fa-refresh"></i> Update</button>
                                    <?php echo form_close(); ?>
                                    </div>
                                
                                </div>
                            </div>

                        </div>
                    </div>
                </div>
            </div>
            <?php } ?>

    </section>
</aside>
