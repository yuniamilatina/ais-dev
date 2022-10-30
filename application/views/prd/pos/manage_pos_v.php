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
            <li><a href="<?php echo base_url('index.php/basis/home_c/') ?>"><span>Home</span></a></li>
            <li> <a href="#"><strong>MANAGE POS</strong></a></li>
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
                        <span class="grid-title"><strong>MANAGE POS</strong></span>
                        <div class="pull-right grid-tools">
                            <a href="<?php echo base_url('index.php/prd/pos_c/create_pos/' .  $work_center) ?>" class="btn btn-default" data-toggle="tooltip" data-placement="left" title="Create Pos" style="height:30px;font-size:13px;width:100px;color:#000000;">Create</a>
                        </div>
                    </div>
                    <div class="grid-body">
                        <div class="pull">
                            <table width="100%" id='filter' border=0px>
                                <tr>
                                    <td width="5%">Work Center</td>
                                    <td width="5%">
                                        <select class="ddl" onChange="document.location.href = this.options[this.selectedIndex].value;">
                                            <?php foreach ($all_work_centers as $row) { ?>
                                                <option value="<?php echo site_url('prd/pos_c/index/' .  trim($row->CHR_WORK_CENTER)); ?>"  <?php
                                                if ($work_center == trim($row->CHR_WORK_CENTER)) {
                                                    echo 'selected';
                                                }
                                                ?> > <?php echo trim($row->CHR_WORK_CENTER); ?> </option>
                                                    <?php } ?>
                                        </select>
                                    </td>
                                    <td width="5%" colspan="4">
                                        <!-- <button type="submit" class="btn btn-primary" style="margin-top: 3px;margin-bottom: 2px;"><span class="fa fa-filter"></span>&nbsp;&nbsp;Filter</button></td> -->
                                        <!-- <?php form_close(); ?></td> -->
                                    <td width="5%"></td>
                                    <td width="25%" style='text-align:right;'>
                                        <!-- <input type="button" class="btn btn-primary" onclick="tableToExcel('exportToExcel', 'Production Per Hour')" value="Export to Excel" style="margin-bottom: 0px;"> -->
                                    </td>
                                </tr>
                            </table>
                        </div>
                        <table id="dataTables3" class="table table-condensed table-striped table-hover display" cellspacing="0" width="100%">
                            <thead>
                                <tr>
                                    <th  style='text-align:center;'>No</th>
                                    <th  style='text-align:center;'>Work Center</th>
                                    <th  style='text-align:center;'>Pos</th>
                                    <th  style='text-align:center;'>Part No</th>
                                    <th  style='text-align:center;'>Back No</th>
                                    <th  style='text-align:center;'>Flg Dandori<br>board</th>
                                    <th  style='text-align:center;'>File name</th>
                                    <th  style='text-align:center;'>Image</th>
                                    <th  style='text-align:center;'>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                $i = 1;
                                foreach ($data as $row) {
                                    echo "<tr class='gradeX'>";
                                    echo "<td style='text-align:center;'>$i</td>";
                                    echo "<td style='text-align:center;'>$row->CHR_WORK_CENTER</td>";
                                    echo "<td style='text-align:center;'>$row->CHR_POS_PRD</td>";
                                    echo "<td style='text-align:center;'>$row->CHR_PART_NO</td>";
                                    echo "<td style='text-align:center;'>$row->CHR_BACK_NO</td>";
                                    if($row->INT_FLG_MODIFIED == 1){
                                        $flg_dandori_board = '<div class="checkbox">
                                        <input type="checkbox" disabled checked class="icheck"></div>';
                                    }else{
                                        $flg_dandori_board = '<div class="checkbox">
                                        <input type="checkbox" disabled unchecked class="icheck"></div>';
                                    }
                                    echo "<td style='text-align:center;'>$flg_dandori_board</td>";
                                    echo "<td style='text-align:left;'>".str_replace('assets/img/wi/','',$row->CHR_IMG_FILE_NAME)."</td>";
                                    echo "<td style='text-align:center;'><img data-enlargable width='25' style='cursor: zoom-in'; src='".base_url().trim($row->CHR_IMG_FILE_NAME)."?id=".rand(10, 1000). "'></td>";
                                    ?>
                                <td  style='text-align:center;'>
                                    <a data-toggle="modal" data-target="#modal_<?php echo $row->INT_ID; ?>" class="label label-primary"  data-placement="left" title="Give notes"><span class="fa fa-comment"></span></a>
                                    <a href="<?php echo base_url('index.php/prd/pos_c/viewCheckPoint') . '/' . trim($row->INT_ID . '/' . $row->CHR_WORK_CENTER . '/' . trim($row->CHR_PART_NO)); ?>" class="label label-default" data-placement="top" data-toggle="tooltip" title="View Key Point"><span class="fa fa-thumb-tack"></span></a>
                                    <a href="<?php echo base_url('index.php/prd/pos_c/edit_pos') . '/' . trim($row->INT_ID . '/' . $row->CHR_WORK_CENTER . '/' . trim($row->CHR_PART_NO)); ?>" class="label label-warning" data-placement="top" data-toggle="tooltip" title="Edit"><span class="fa fa-pencil"></span></a>
                                    <a href="<?php echo base_url('index.php/prd/pos_c/delete_pos') . "/" . trim($row->INT_ID . '/' . $row->CHR_WORK_CENTER); ?>" class="label label-danger" data-placement="right" data-toggle="tooltip" title="Delete" onclick="return confirm('Are you sure want to delete this pos?');"><span class="fa fa-times"></span></a>
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
    </section>
    <!-- =========================================================================================================================== -->
    <?php
    foreach ($data as $isi) {
        ?>
        <div class="modal fade" id="modal_<?php echo $isi->INT_ID; ?>" tabindex="-1" role="dialog" aria-labelledby="myModalLabel3" aria-hidden="true">
            <div class="modal-wrapper">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <form class="form-horizontal" method="post"  role="form" action="<?php echo base_url('index.php/prd/pos_c/update_notes'); ?>" >
                            <div class="modal-header">
                                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                                <h4 class="modal-title" id="myModalLabel3"><strong>ADD NOTES FOR <?php echo trim($isi->CHR_PART_NO) . " - POS " . trim($isi->CHR_POS_PRD) ?></strong></h4>
                            </div>
                            <div class="modal-body" >
                                <input name="CHR_WORK_CENTER" type='hidden' value='<?php echo $work_center ?>'/>
                                <input name="INT_ID" type='hidden' value='<?php echo $isi->INT_ID ?>' />

                                <div class="form-group">
                                    <label class="col-sm-2 control-label">Notes</label>
                                        <div class="col-sm-5">
                                            <textarea name="CHR_NOTE" rows="4" cols="50" ><?php echo trim($isi->CHR_NOTE); ?></textarea>
                                        </div>
                                </div>
                            </div>
                            <div class="modal-footer">
                                <div class="btn-group">
                                    <button type="button" class="btn btn-default" data-dismiss="modal"> Close</button>
                                    <button type="submit" class="btn btn-success"> Update</button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
        <?php
    }
    ?>
    <!-- =========================================================================================================================== -->

</aside>


<script>

$('img[data-enlargable]').addClass('img-enlargable').click(function(){
    var src = $(this).attr('src');
    $('<div>').css({
        background: 'RGBA(0,0,0,.5) url('+src+') no-repeat center',
        backgroundSize: 'contain',
        width:'100%', height:'100%',
        position:'fixed',
        zIndex:'10000',
        top:'0', left:'0',
        cursor: 'zoom-out'
    }).click(function(){
        $(this).remove();
    }).appendTo('body');
});

</script>
