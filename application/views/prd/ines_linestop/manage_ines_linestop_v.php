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
            <li> <a href="#"><strong>MANAGE LINE STOP SUB ASSY</strong></a></li>
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
                        <span class="grid-title"><strong>MANAGE LINE STOP SUB ASSY</strong></span>
                        <div class="pull-right grid-tools">
                            <a href="#modal_linestop" class="btn btn-danger" data-toggle="modal" data-placement="left" title="New Line Stop" style="height:30px;font-size:13px;width:120px;color:#FFFFFF;">New Line Stop</a>
                        </div>
                    </div>
                    <div class="grid-body">
                        <table id="dataTables3" class="table table-condensed table-striped table-hover display" cellspacing="0" width="100%">
                            <thead>
                                <tr>
                                    <th  style='text-align:center;'>No</th>
                                    <th  style='text-align:center;'>Work Center</th>
                                    <th  style='text-align:center;'>LS Code</th>
                                    <th  style='text-align:center;'>Stop Start Time</th>
                                    <th  style='text-align:center;'>Wait Start time</th>
                                    <th  style='text-align:center;'>Followup Start time</th>
                                    <th  style='text-align:center;'>Followup by</th>
                                    <th  style='text-align:center;'>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                $i = 1;
                                foreach ($data as $row) {

                                    if($row->CHR_WAITING_TIME == '' && $row->CHR_FOLLOWUP_TIME == '' && $row->CHR_STOP_TIME == ''){ 
                                        $color = 'background:yellow;';
                                    } elseif($row->CHR_FOLLOWUP_TIME == '' && $row->CHR_STOP_TIME == '' ) { 
                                        $color = 'background:red;color:white;';
                                    } elseif($row->CHR_STOP_TIME == '' ) { 
                                        $color = 'background:blue;color:white;';
                                    }

                                    if($row->CHR_START_TIME == ''){
                                        $starttime = '-';
                                    }else{
                                        $starttime = date('H:i', strtotime($row->CHR_START_TIME));
                                    }
                                    if($row->CHR_WAITING_TIME == ''){
                                        $waittime = '-';
                                    }else{
                                        $waittime = date('H:i', strtotime($row->CHR_WAITING_TIME));
                                    }
                                    if($row->CHR_FOLLOWUP_TIME == ''){
                                        $followuptime = '-';
                                    }else{
                                        $followuptime = date('H:i', strtotime($row->CHR_FOLLOWUP_TIME));
                                    }

                                    echo "<tr class='gradeX'>";
                                    echo "<td style='text-align:center;$color'>$i</td>";
                                    echo "<td style='text-align:center;$color'>$row->CHR_WORK_CENTER</td>";
                                    echo "<td style='text-align:center;'>$row->CHR_LINE_STOP</td>";
                                    echo "<td style='text-align:center;'>$starttime</td>";
                                    echo "<td style='text-align:center;'>$waittime</td>";
                                    echo "<td style='text-align:center;'>$followuptime</td>";
                                    echo "<td style='text-align:center;'>$row->CHR_FOLLOWUP_BY</td>";
                                    ?>
                                <td  style='text-align:center;'>

                                    <?php if($row->CHR_WAITING_TIME == '' && $row->CHR_FOLLOWUP_TIME == '' && $row->CHR_STOP_TIME == ''){ ?>
                                        <a href="<?php echo base_url('index.php/prd/ines_linestop_c/call_support_linestop') . '/' . trim($row->INT_ID_LINE_STOP) . '/' . trim($row->CHR_WORK_CENTER); ?>" class="label label-danger" data-placement="top" data-toggle="tooltip" title="Call"><span class="fa fa-phone"></span></a>
                                        <a href="<?php echo base_url('index.php/prd/ines_linestop_c/stop_linestop') . "/" . trim($row->INT_ID_LINE_STOP). '/' . trim($row->CHR_WORK_CENTER); ?>" class="label label-success" data-placement="right" data-toggle="tooltip" title="Solve" ><span class="fa fa-smile-o"></span></a>
                                    <?php } elseif($row->CHR_FOLLOWUP_TIME == '' && $row->CHR_STOP_TIME == '' ) { ?>
                                        <a href="<?php echo base_url('index.php/prd/ines_linestop_c/follow_up_linestop') . "/" . trim($row->INT_ID_LINE_STOP). '/' . trim($row->CHR_WORK_CENTER); ?>" class="label label-info" data-placement="right" data-toggle="tooltip" title="Followup" ><span class="fa fa-wrench"></span></a>
                                    <?php } elseif($row->CHR_STOP_TIME == '' ) { ?>
                                        <a href="<?php echo base_url('index.php/prd/ines_linestop_c/stop_linestop') . "/" . trim($row->INT_ID_LINE_STOP). '/' . trim($row->CHR_WORK_CENTER); ?>" class="label label-success" data-placement="right" data-toggle="tooltip" title="Solve" ><span class="fa fa-smile-o"></span></a>
                                    <?php } ?>

                                </td>
                                </tr>
                                <?php
                                $i++;
                            }
                            ?>
                            </tbody>
                        </table>
                    
                        <div style="width: 60%;">
                            <table width="60%" id='filter' border=0px style="outline: thin ridge #DDDDDD">
                                <tr>
                                    <td width="3%" style='text-align:left;' colspan="4"><strong>L e g e n d   : </strong></td>
                                    <td width="10%">
                                        <button disabled style='border:0;background:yellow;width:25px;height:25px;color:white;' ></button> : Still tried
                                    </td>
									 <td width="10%">
                                        <button disabled style='border:0;background:red;width:25px;height:25px;color:white;' ></button> : Need help
                                    </td>
                                    <td width="10%">
                                        <button disabled style='border:0;background:blue;width:25px;height:25px;color:white;'></button> : On repair
                                    </td>
                                </tr>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <div class="modal fade" id="modal_linestop" tabindex="-1" role="dialog" aria-labelledby="myModalLabel3" aria-hidden="true">
        <div class="modal-wrapper">
                <div class="modal-dialog">
                    <div class="modal-content">
                                <?php
                                    echo form_open('prd/ines_linestop_c/start_linestop', 'class="form-horizontal"');
                                ?>
                            <div class="modal-header bg-blue">
                                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                                <h4 class="modal-title" id="myModalLabel3"><strong>New Line Stop</strong></h4>
                            </div>

                            <div class="modal-body" >

                                <div class="form-group">
                                    <label class="col-sm-4 control-label">Work Center</label>
                                    <div class="col-sm-5">
                                            <select id="e1" name="CHR_WORK_CENTER" class="form-control" style="width:150px;">
                                                    <?php
                                                    foreach ($all_work_centers as $row) {
                                                        ?>
                                                            <option value="<?php echo trim($row->CHR_WORK_CENTER); ?>" > <?php echo trim($row->CHR_WORK_CENTER); ?> </option>
                                                    <?php
                                                        }
                                                    ?>
                                            </select>
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label class="col-sm-4 control-label">Shift</label>
                                        <div class="col-sm-5">
                                            <div class="radio">
                                                <label><div class="iradio_square-blue" style="position: relative;"><input type="radio" name="INT_SHIFT" checked class="icheck" value='1'></div> SHIFT 1</label>
                                            </div>
                                            <div class="radio">
                                                <label><div class="iradio_square-blue" style="position: relative;"><input type="radio" name="INT_SHIFT" class="icheck" value='2'></div> SHIFT 2</label>
                                            </div>
                                            <div class="radio">
                                                <label><div class="iradio_square-blue" style="position: relative;"><input type="radio" name="INT_SHIFT" class="icheck" value='3'></div> SHIFT 3</label>
                                            </div>
                                            <div class="radio">
                                                <label><div class="iradio_square-blue" style="position: relative;"><input type="radio" name="INT_SHIFT" class="icheck"  value='4'></div> SHIFT 4</label>
                                            </div>
                                        </div>
                                </div>

                                <div class="form-group">
                                    <label class="col-sm-4 control-label">Shift Type</label>
                                        <div class="col-sm-5">
                                            <div class="radio-inline">
                                                <label><div class="iradio_square-blue" style="position: relative;"><input type="radio" name="INT_FLG_SHIFT" checked class="icheck" value='1'></div> LONG SHIFT</label>
                                            </div>
                                            <div class="radio-inline">
                                                <label><div class="iradio_square-blue" style="position: relative;"><input type="radio" name="INT_FLG_SHIFT" class="icheck" value='0'></div>NORMAL SHIFT</label>
                                            </div>
                                        </div>
                                </div>
                                
                                <div class="form-group">
                                    <label class="col-sm-4 control-label">Problem</label>
                                        <div class="col-sm-5">
                                            <div class="radio-inline">
                                                <label><div class="iradio_square-blue" style="position: relative;"><input type="radio" name="CHR_LS_CODE" checked class="icheck" value='LS4'></div> MACHINE</label>
                                            </div>
                                            <div class="radio-inline">
                                                <label><div class="iradio_square-blue" style="position: relative;"><input type="radio" name="CHR_LS_CODE" class="icheck" value='LS5'></div>DIES / JIG</label>
                                            </div>
                                        </div>
                                </div>
                            </div>

                            <div class="modal-footer">
                                <div class="btn-group">
                                    <button type="button" class="btn btn-default" data-dismiss="modal"> Close</button>
                                    <button type="submit" class="btn btn-primary"><i class="fa fa-check"></i> Submit</button>
                                </div>
                            </div>
                        <?php
                            echo form_close();
                        ?>
                    </div>
                </div>
            </div>
        </div>
    </div>


</aside>




