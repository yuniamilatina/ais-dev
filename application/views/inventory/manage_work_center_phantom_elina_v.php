
<style type="text/css">
    th, td { white-space: nowrap; }
    div.dataTables_wrapper {
        margin: 0 auto;
    }
    #table-luar{
        font-size: 12px;
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
            <li><a href="<?php echo base_url('index.php/inventory/temp_part_c/manage_phantom_work_center') ?>"><strong>Manage Work Center Phantom ELINA</strong></a></li>
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
                        <span class="grid-title"><strong>MANAGE WORK CENTER PHANTOM ELINA</strong></span>
                        <div class="pull-right grid-tools">
                            <a data-toggle="modal" data-target="#modalAddWC"  class="btn btn-primary" data-placement="left" title="Add Work Center" style="height:30px;font-size:13px;width:130px;color:white;margin-top:-5px;margin-bottom:-5px;">Add Work Center</a>
                        </div>
                    </div>
                    <div class="grid-body">
                        <div class="pull">
                            <table width="100%" id='filter' border=0px>
                                <tr>
                                    <td width="5%"></td>
                                    <td width="5%">
                                    </td>
                                    <td width="5%" colspan="4"></td>
                                    <td width="5%">
                                        
                                    </td>
                                    <td width="55%">
                                    </td>
                                    <td width="25%">
                                    </td>
                                </tr>
                                <tr> 
                                    <td width="5%">Dept</td>
                                        <td width="5%">
                                            <select name="INT_ID_DEPT" id="INT_ID_DEPT" class="ddl2" style="width:150px;" onChange="document.location.href = this.options[this.selectedIndex].value;">
                                                <?php
                                                foreach ($all_dept_prod as $row) {
                                                    if (trim($row->INT_ID_DEPT) == trim($id_dept)) {
                                                        ?>
                                                        <option selected value="<?php echo site_url('inventory/temp_part_c/manage_phantom_work_center/0/' . trim($row->INT_ID_DEPT)); ?>"><?php echo trim($row->CHR_DEPT); ?></option>
                                                    <?php } else { ?>
                                                        <option value="<?php echo site_url('inventory/temp_part_c/manage_phantom_work_center/0/' . trim($row->INT_ID_DEPT)); ?>"><?php echo trim($row->CHR_DEPT); ?></option>
                                                        <?php
                                                    }
                                                }
                                                ?>
                                            </select>
                                        </td>
                                    <td width="5%"></td>
                                    <td width="5%"></td>
                                    <td width="40%">
                                    </td>
                                </tr>
                            </table>
                            <?php echo form_close(); ?>
                        </div>

                        <div id="table-luar">
                            <table id="dataTables3" class="table table-condensed table-striped table-hover display" cellspacing="0" width="100%">
                                <thead>
                                    <tr>
                                        <th style='text-align:center;'>No</th>
                                        <th style="text-align:center;">Work Center</th> 
                                        <th style="text-align:center;">Status</th>
                                        <th style="text-align:center;">Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    $i = 1;
                                    foreach ($data as $isi) {
                                        echo "<tr class='gradeX'>";
                                        echo "<td style='text-align:center;'>$i</td>";
                                        echo "<td style='text-align:center;'>$isi->CHR_WORK_CENTER</td>"; 
                                        if($isi->INT_FLG_DELETE == 0 || $isi->INT_FLG_DELETE == NULL){
                                            echo "<td style='text-align:center;'><img src='" . base_url() . "/assets/img/ok_summary.png' width='20'></td>";  
                                        } else if($isi->INT_FLG_DELETE == 1) {
                                            echo "<td style='text-align:center;'><img src='" . base_url() . "/assets/img/ng_summary.png' width='20'></td>";  
                                        }
                                                                    
                                        ?>
                                    <td style='text-align:center;'>
                                        <?php if($isi->INT_FLG_DELETE == 0 || $isi->INT_FLG_DELETE == NULL){ ?>
                                        <a href="<?php echo base_url('index.php/inventory/temp_part_c/edit_phantom_work_center') . "/1/" . $isi->INT_ID . "/" . trim($id_dept) ?>" class="label label-danger" onclick="return confirm('Are you sure want to DISABLE this data?');" data-placement="top" data-toggle="tooltip" title="Disable"><span class="fa fa-times"></span></a>
                                        <?php } else if($isi->INT_FLG_DELETE == 1){ ?>
                                        <a href="<?php echo base_url('index.php/inventory/temp_part_c/edit_phantom_work_center') . "/0/" . $isi->INT_ID . "/" . trim($id_dept) ?>" class="label label-info" onclick="return confirm('Are you sure want to ENABLE this data?');" data-placement="top" data-toggle="tooltip" title="Enable"><span class="fa fa-check"></span></a>
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
                </div>
                
                    <div class="modal fade" id="modalAddWC" tabindex="-1" role="dialog" aria-labelledby="modalprogress" aria-hidden="true" style="display: none;">
                            <div class="modal-wrapper">
                                <div class="modal-dialog">
                                    
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                                            <h4 class="modal-title" id="modalprogress"><strong>Add Work Center Phantom ELINA</strong></h4>
                                        </div>
                                        
                                        <div class="modal-body">
                                        <?php echo form_open('inventory/temp_part_c/add_phantom_work_center', 'class="form-horizontal"'); ?>
                                            <input name="INT_ID_DEPT" class="form-control" required type="hidden" style="width: 300px;" value="<?php echo $id_dept; ?>">
                                            <div class="form-group">
                                                <label class="col-sm-3 control-label">Dept</label>
                                                <div class="col-sm-5">
                                                <select name="id_dept" id="id_dept" class="ddl2" style="width:150px;" onchange="get_data_work_center();">
                                                    <?php
                                                    foreach ($all_dept_prod as $row) {
                                                        if (trim($row->INT_ID_DEPT) == trim($id_dept)) {
                                                            ?>
                                                            <option selected value="<? echo $id_dept; ?>"><?php echo trim($row->CHR_DEPT); ?></option>
                                                        <?php } else { ?>
                                                            <option value="<? echo $row->INT_ID_DEPT; ?>"><?php echo trim($row->CHR_DEPT); ?></option>
                                                            <?php
                                                        }
                                                    }
                                                    ?>
                                                </select>
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <label class="col-sm-3 control-label">Work Center</label>
                                                <div class="col-sm-5">
                                                <select id="work_center" name="work_center" class="ddl2">
                                                    <?php
                                                    foreach ($all_work_center as $row) { ?>
                                                        <option value="<?php echo trim($row->CHR_WORK_CENTER); ?>" > <?php echo trim($row->CHR_WORK_CENTER); ?> </option>
                                                    <?php } ?>
                                                </select>
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
                    </div>
            </div>
        </div>
    </section>
</aside>
<script type="text/javascript" language="javascript">

function get_data_work_center(){
    var dept_to_work_center = document.getElementById('id_dept').value;

    $.ajax({
        async: false,
        type: "POST",
        dataType: 'json',
        url: "<?php echo site_url('prd/direct_backflush_general_c/get_work_center_by_id_dept'); ?>",
        data:  {
                INT_ID_DEPT: dept_to_work_center
                },
        success: function (json_data) {
            $("#work_center").html(json_data['data']);
        },
        error: function (request) {
            alert(request.responseText);
        }
    });
}
</script>