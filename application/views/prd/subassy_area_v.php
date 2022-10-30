<style>
    #table-luar {
        font-size: 11px;
    }

    #td_date {
        text-align: center;
        vertical-align: top;
    }

    #filter {
        -webkit-border-horizontal-spacing: 0px;
        -webkit-border-vertical-spacing: 10px;
        border-collapse: separate;
        margin-bottom: 10px;
    }

    #filterdiagram {
        border-spacing: 5px;
        border-color: #DDDDDD;
        background-color: #F3F4F5;
        border: 1px;
    }

    #testDiv {
        width: 100%;
        white-space: nowrap;
        overflow-x: scroll;
        overflow-y: visible;
        font-size: 12px;
    }

    th,
    td {
        white-space: nowrap;
    }

    div.dataTables_wrapper {
        width: 100%;
        margin: 0 auto;
    }

    .td-fixed {
        width: 30px;
    }

    .ddl {
        width: 100px;
        height: 30px;
    }

    .ddl2 {
        width: 180px;
        height: 30px;
    }
</style>

<aside class="right-side">
    <section class="content-header">
        <ol class="breadcrumb">
            <li><a href="<?php echo base_url('index.php/basis/home_c/'); ?>"><span>HOME</span></a></li>
            <li><a href=""><strong>SUB ASSY AREA</strong></a></li>
        </ol>
    </section>

    <section class="content">
        <div class="row">
            <div class="col-lg-12">
                <div class="grid">
                    <div class="grid-header">
                        <i class="fa fa-users"></i>
                        <span class="grid-title"><strong>ALL SUB ASSY AREA</strong></span>
                        <div class="pull-right grid-tools">
                            <a data-toggle="modal" data-target="#modalAdd" data-placement="left" data-toggle="tooltip" title="Add SubAssy" class="btn btn-default">Add Sub Assy</a>
                        </div>
                    </div>
                    <div class="grid-body">
                        <div class="pull">
                            <div id="table-luar">
                                <table id="dataTables2" class="table table-condensed table-striped table-hover display" cellspacing="0" width="100%">
                                    <thead>
                                        <tr class='gradeX'>
                                            <th style="text-align:center;">No</th>
                                            <th style="text-align:center;">Work Center</th>
                                            <th style="text-align:center;">Pos</th>
                                            <th style="text-align:center;">Sub Assy Code</th>
                                            <th style="text-align:center;">Sub Assy Name</th>
                                            <th style='text-align:center;'>Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php
                                        $i = 1;
                                        foreach ($data as $isi) { ?>
                                            <tr class='gradeX'>
                                                <td style=text-align:center;><?php echo $i; ?></td>
                                                <td style=text-align:center;><?php echo $isi->CHR_WORK_CENTER; ?></td>
                                                <td style=text-align:center;><?php echo $isi->CHR_POS_PRD; ?></td>
                                                <td style=text-align:center;><?php echo $isi->CHR_PREPARE_AREA_CODE; ?></td>
                                                <td style=text-align:left;><?php echo $isi->CHR_PREPAER_AREA_DESC; ?></td>
                                                <td style='text-align:center;'>
                                                    <a onclick="getPosByWorkCenter('<?php echo trim($isi->CHR_WORK_CENTER); ?>')" data-toggle="modal" data-target="#modal_<?php echo $isi->INT_ID; ?>" class="label label-warning" data-placement="left" title="Edit"><span class="fa fa-pencil"></span></a>
                                                    <a href="<?php echo base_url('index.php/prd/subassy_area_c/deleteSubAssyArea') . "/" . trim($isi->INT_ID); ?>" class="label label-danger" data-placement="right" data-toggle="tooltip" title="Delete" onclick="return confirm('Are you sure want to delete this supplier?');"><span class="fa fa-times"></span></a>
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
            </div>
        </div>
        <!--GRID TO DISPLAY DETAIL LINE STOP GRID TABLE-->

        <div class="modal fade" id="modalAdd" tabindex="-1" role="dialog" aria-labelledby="modalprogress" aria-hidden="true" style="display: none;">
            <div class="modal-wrapper">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                            <h4 class="modal-title" id="modalprogress"><strong>Add Sub Assy Area</strong></h4>
                        </div>

                        <div class="modal-body">
                            <?php echo form_open('prd/subassy_area_c/saveSubAssySpareSpart', 'class="form-horizontal"'); ?>

                           
                            <div class="form-group">
                                <label class="col-sm-3 control-label">Work Center</label>
                                <div class="col-sm-6">
                                    <select name="CHR_WORK_CENTER" class="form-control" onchange="getPosByWorkCenter(this.value);">
                                        <?php
                                        foreach ($all_work_centers as $row) {
                                            if (trim($row->CHR_WORK_CENTER) == trim($work_center)) {
                                        ?>
                                                <option selected value="<?php echo trim($row->CHR_WORK_CENTER); ?>"> <?php echo trim($row->CHR_WORK_CENTER); ?> </option>
                                            <?php } else { ?>
                                                <option value="<?php echo trim($row->CHR_WORK_CENTER); ?>"> <?php echo trim($row->CHR_WORK_CENTER); ?> </option>
                                        <?php
                                            }
                                        }
                                        ?>
                                    </select>
                                </div>
                            </div>

                            <div class="form-group">
                                <label class="col-sm-3 control-label">Pos</label>
                                <div class="col-sm-6">
                                    <select id='pos' name="CHR_POS_PRD" class="form-control">
                                        <?php
                                        foreach ($all_pos as $row) {
                                            if (trim($row->CHR_POS_PRD) == trim($pos)) {
                                        ?>
                                                <option selected value="<?php echo trim($row->CHR_POS_PRD); ?>"> <?php echo trim($row->CHR_POS_PRD); ?> </option>
                                            <?php } else { ?>
                                                <option value="<?php echo trim($row->CHR_POS_PRD); ?>"> <?php echo trim($row->CHR_POS_PRD); ?> </option>
                                        <?php
                                            }
                                        }
                                        ?>
                                    </select>
                                </div>
                            </div>

                            <div class="form-group">
                                <label class="col-sm-3 control-label">Sub Assy Desc</label>
                                <div class="col-sm-6">
                                    <input name="CHR_PREPAER_AREA_DESC" autocomplete=off require class="form-control" required type="text">
                                </div>
                            </div>

                            <div class="modal-footer">
                                <div class="btn-group">
                                    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                                    <button type="submit" class="btn btn-primary" data-placement="left" data-toggle="tooltip" title="Save this data"><i class="fa fa-check"></i> Save</button>
                                </div>
                            </div>

                            <?php echo form_close(); ?>
                        </div>

                    </div>
                </div>
            </div>
        </div>

        <?php foreach ($data as $isi) { ?>
            <div class="modal fade" id="modal_<?php echo trim($isi->INT_ID) ?>" tabindex="-1" role="dialog" aria-labelledby="modalprogress" aria-hidden="true" style="display: none;">
                <div class="modal-wrapper">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <div class="modal-header">
                                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                                <h4 class="modal-title" id="modalprogress"><strong>Edit SubAssy Area</strong></h4>
                            </div>
                            <div class="modal-body">
                                <?php echo form_open('prd/subassy_area_c/updateSubAssyArea', 'class="form-horizontal"'); ?>

                                <div class="form-group" style='display:none;'>
                                    <label class="col-sm-3 control-label">Id</label>
                                    <div class="col-sm-6">
                                        <input name="INT_ID" autocomplete=off require class="form-control" required type="text" value="<?php echo trim($isi->INT_ID); ?>">
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label class="col-sm-3 control-label">SubAssy Code</label>
                                    <div class="col-sm-6">
                                        <input name="CHR_PREPARE_AREA_CODE" autocomplete=off readonly class="form-control" required type="text" value="<?php echo trim($isi->CHR_PREPARE_AREA_CODE); ?>">
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label class="col-sm-3 control-label">Work Center</label>
                                    <div class="col-sm-6">
                                        <select name="CHR_WORK_CENTER" class="form-control" onchange="getPosByWorkCenter(this.value);">
                                            <?php
                                            foreach ($all_work_centers as $row) {
                                                if (trim($row->CHR_WORK_CENTER) == trim($isi->CHR_WORK_CENTER)) {
                                            ?>
                                                    <option selected value="<?php echo trim($row->CHR_WORK_CENTER); ?>"> <?php echo trim($row->CHR_WORK_CENTER); ?> </option>
                                                <?php } else { ?>
                                                    <option value="<?php echo trim($row->CHR_WORK_CENTER); ?>"> <?php echo trim($row->CHR_WORK_CENTER); ?> </option>
                                            <?php
                                                }
                                            }
                                            ?>
                                        </select>
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label class="col-sm-3 control-label">Pos</label>
                                    <div class="col-sm-6">
                                        <select id='pos-edit' name="CHR_POS_PRD" class="form-control">
                                            <?php
                                            foreach ($all_pos as $row) {
                                                if (trim($row->CHR_POS_PRD) == trim($isi->CHR_POS_PRD)) {
                                            ?>
                                                    <option selected value="<?php echo trim($row->CHR_POS_PRD); ?>"> <?php echo trim($row->CHR_POS_PRD); ?> </option>
                                                <?php } else { ?>
                                                    <option value="<?php echo trim($row->CHR_POS_PRD); ?>"> <?php echo trim($row->CHR_POS_PRD); ?> </option>
                                            <?php
                                                }
                                            }
                                            ?>
                                        </select>
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label class="col-sm-3 control-label">SubAssy Name</label>
                                    <div class="col-sm-6">
                                        <input name="CHR_PREPAER_AREA_DESC" autocomplete=off require class="form-control" required type="text" value="<?php echo trim($isi->CHR_PREPAER_AREA_DESC); ?>">
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

<script type="text/javascript" language="javascript">
    function getPosByWorkCenter(e) {

        $.ajax({
            async: false,
            type: "POST",
            dataType: 'json',
            url: "<?php echo site_url('prd/pos_c/get_pos_by_work_center'); ?>",
            data: {
                CHR_WORK_CENTER: e
            },
            success: function(json_data) {
                $("#pos").html(json_data['data']);
                $("#pos-edit").html(json_data['data']);
            },
            error: function(request) {
                alert(request.responseText);
            }
        });
    }
</script>