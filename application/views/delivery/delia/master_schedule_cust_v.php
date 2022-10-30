
<script>
    setTimeout(function () {
        document.getElementById("hide-sub-menus").click();
    }, 10); 
    
    function angka(objek) {
        a = objek.value;
        b = a.replace(/[^\d]/g, "");
        c = "";
        panjang = b.length;
        j = 0;
        for (i = panjang; i > 0; i--) {
            j = j + 1;
            if (((j % 3) == 1) && (j != 1)) {
                c = b.substr(i - 1, 1) + "" + c;
            } else {
                c = b.substr(i - 1, 1) + c;
            }
        }
        objek.value = trimNumber(c);
    }
    
    function trimNumber(s) {
        while (s.substr(0, 1) == '' && s.length > 1) {
            s = s.substr(1, 9999);
        }
        return s;
    }
    
    function checkLength(el) {
        if (el.value.length != 4) {
            alert("Length must be exactly 4 characters")
            el.value = '0000';
        }
    }
</script>

<style type="text/css">
    #table-luar{
        font-size: 12px;
    }
    #filter { 
        border-spacing: 10px;
    }
    .td-fixed{
        width: 10px;
    }
    #td_date{
        text-align:center;
        vertical-align:top;
    } 

    #filter { 
        border-spacing: 10px;
        border-collapse: separate;
    }

    #filterdiagram {
        border-spacing: 5px;
        border-color: #DDDDDD;
        background-color: #F3F4F5;
    }

    .btn:hover {
        background: #1E90FF;
        background-image: -webkit-linear-gradient(top, #1E90FF, #1E90FF);
        background-image: -moz-linear-gradient(top, #1E90FF, #1E90FF);
        background-image: -ms-linear-gradient(top, #1E90FF, #1E90FF);
        background-image: -o-linear-gradient(top, #1E90FF, #1E90FF);
        background-image: linear-gradient(to bottom, #1E90FF, #1E90FF);
        color:white;
    }

</style>

<aside class="right-side">
    <section class="content-header">
        <ol class="breadcrumb">
            <li><a href="<?php echo base_url('index.php/basis/home_c/'); ?>"><span>Home</span></a></li>
            <li><a href=""><strong>Master Schedule Customer</strong></a></li>
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
                        <i class="fa fa-th-large"></i>
                        <span class="grid-title"><strong> Master Schedule Customer </strong></span>

                        <div class="pull-right grid-tools">
                            <button <?php if ($role == 3 || $role == 4) { echo 'disabled'; }?> class="btn btn-primary" data-toggle="modal" data-target="#modalPrimary"><i class="fa fa-upload"></i> Upload</button>
                            <a data-widget="collapse" title="Collapse"><i class="fa fa-chevron-up"></i></a>
                        </div>
                    </div>

                    <div class="grid-body">
                        <div class="pull">
                            <table width="100%" id='filter'>
                                <tr>
                                    <td width="10%">Periode</td>
                                    <td width="20%">
                                        <select class="ddl2" id="opt_wcenter" onChange="document.location.href = this.options[this.selectedIndex].value;">
                                            <?php for ($x = 0; $x <= 5; $x++) { ?>
                                                <option value="<?php echo site_url('delivery/master_schedule_cust_c/index/0/' . date("Ym", strtotime("+$x month"))); ?>" <?php
                                                if ($selected_date == date("Ym", strtotime("+$x month"))) {
                                                    echo 'SELECTED';
                                                }
                                                ?> > <?php echo date("M Y", strtotime("+$x month")); ?> </option>
                                                    <?php } ?>
                                        </select>
                                    </td>
                                    <td width="70%"></td>
                                </tr>
                            </table>
                        </div>

                        <div id="table-luar">
                            <table id="example" style="font-size:11px;" class="table table-condensed table-striped table-hover display" cellspacing="0" width="100%">
                                <thead>
                                    <tr class='gradeX'>
                                        <!------- HEADER TABLE ------->
                                        <th style="vertical-align: middle; text-align: center">No</th>
                                        <th style="vertical-align: middle; text-align: center">Customer</th>                                        
                                        <!--<th style="vertical-align: middle; text-align: center">Customer Address</th>-->                                        
                                        <th style="vertical-align: middle; text-align: center">Cycle</th>
                                        <th style="vertical-align: middle; text-align: center">Dock</th>
                                        <th style="vertical-align: middle; text-align: center">Route</th>
                                        <th style="vertical-align: middle; text-align: center">Logistic Vendor</th>
                                        <th style="vertical-align: middle; text-align: center">Customer Desc</th>  
                                        <th style="vertical-align: middle; text-align: center">Dist Channel</th>
                                        <th style="vertical-align: middle; text-align: center">AII Arrival</th>
                                        <th style="vertical-align: middle; text-align: center">Pulling Start</th>
                                        <th style="vertical-align: middle; text-align: center">Pulling End</th>
                                        <th style="vertical-align: middle; text-align: center">PDI Start</th>
                                        <th style="vertical-align: middle; text-align: center">PDI End</th>
                                        <th style="vertical-align: middle; text-align: center">AII Departure</th>
                                        <th style="vertical-align: middle; text-align: center">Cust Arrival</th>
                                        <th style="vertical-align: middle; text-align: center">Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                        $no = 1;
                                        if (count($schedule) > 0) {
                                            foreach ($schedule as $isi) {
                                                echo "<tr class='gradeX'>";
                                                echo "<td style=text-align:center;>$no</td>";
                                                echo "<td>$isi->CHR_CUST</td>";                                                
                                                //echo "<td style='font-size:10px;'>$isi->CHR_CUST_ADDRESS</td>";                                                                                                
                                                echo "<td style=text-align:center;>$isi->INT_CYCLE</td>";
                                                echo "<td style=text-align:center;>$isi->CHR_CUST_DOCK</td>";
                                                echo "<td style=text-align:center;>$isi->CHR_ROUTE</td>";
                                                echo "<td style=text-align:center;>$isi->CHR_LOG_VENDOR</td>";
                                                echo "<td style='font-size:10px;'>$isi->CHR_CUST_DESC</td>";
                                                if($isi->CHR_DIS_CHANNEL == 'C1'){
                                                    echo "<td style=text-align:center;>C1 - OEM</td>";
                                                } else if($isi->CHR_DIS_CHANNEL == 'C2'){
                                                    echo "<td style=text-align:center;>C2 - AM</td>";
                                                } else if($isi->CHR_DIS_CHANNEL == 'C3'){
                                                    echo "<td style=text-align:center;>C3 - TRIAL</td>";
                                                } else {
                                                    echo "<td style=text-align:center;>C4 - OTHER</td>";
                                                }
                                                echo "<td style=text-align:center;>" . substr($isi->CHR_AII_ARRIVAL,0,2) . ":" . substr($isi->CHR_AII_ARRIVAL,2,2) . "</td>";
                                                echo "<td style=text-align:center;>" . substr($isi->CHR_PULLING_START,0,2) . ":" . substr($isi->CHR_PULLING_START,2,2) . "</td>";
                                                echo "<td style=text-align:center;>" . substr($isi->CHR_PULLING_END,0,2) . ":" . substr($isi->CHR_PULLING_END,2,2) . "</td>";
                                                echo "<td style=text-align:center;>" . substr($isi->CHR_TAKAIBIKI_START,0,2) . ":" . substr($isi->CHR_TAKAIBIKI_START,2,2) . "</td>";
                                                echo "<td style=text-align:center;>" . substr($isi->CHR_TAKAIBIKI_END,0,2) . ":" . substr($isi->CHR_TAKAIBIKI_END,2,2) . "</td>";
                                                echo "<td style=text-align:center;>" . substr($isi->CHR_AII_DEPARTURE,0,2) . ":" . substr($isi->CHR_AII_DEPARTURE,2,2) . "</td>";
                                                echo "<td style=text-align:center;>" . substr($isi->CHR_CUST_ARRIVAL,0,2) . ":" . substr($isi->CHR_CUST_ARRIVAL,2,2) . "</td>";
                                        ?>
                                                <td>
                                                    <?php if($isi->CHR_FLG_DELETE == 0){ ?>
                                                        <a class="label label-warning" data-toggle="modal" data-target="#modalEdit<?php echo $isi->INT_ID ?>" data-placement="top" title="Edit"><span class="fa fa-pencil"></span></a>
                                                        <a href="<?php echo site_url('delivery/master_schedule_cust_c/delete_schedule/' . $isi->CHR_PERIODE . '/' . $isi->INT_ID); ?>" class="label label-danger" data-toggle="modal" data-placement="top" title="Disabled"><span class="fa fa-times"></span></a>
                                                    <?php } else {?>
                                                        <a class="label label-default" data-toggle="modal" data-target="#" data-placement="top" title="Edit"><span class="fa fa-pencil"></span></a>
                                                        <a href="<?php echo site_url('delivery/master_schedule_cust_c/delete_schedule/' . $isi->CHR_PERIODE . '/' . $isi->INT_ID); ?>" class="label label-success" data-toggle="modal" data-placement="top" title="Enabled"><span class="fa fa-check"></span></a>
                                                    <?php } ?>
                                                </td>
                                        <?php
                                                echo "</tr>";
                                            $no++;
                                            }
                                        }
                                        ?>
                                </tbody>
                            </table>
                        </div>
                    </div>

                </div>
            </div>
        </div>
        <div class="modal fade" id="modalPrimary" tabindex="-1" role="dialog" aria-labelledby="myModalLabel2" aria-hidden="true">
            <div class="modal-wrapper">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <form class="form-horizontal" role="form" action="<?php echo base_url('index.php/delivery/master_schedule_cust_c/upload_schedule'); ?>" method="post"  enctype="multipart/form-data">
                            <div class="modal-header">
                                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                                <h4 class="modal-title" id="myModalLabel2" >Upload Schedule Customer</h4>
                            </div>
                            <div class="modal-body" >
                                <div class="form-group" style="text-align:center;">
                                    <span style="text-align:center;"><a href="<?php echo base_url('index.php/delivery/master_schedule_cust_c/download_template/'); ?>">Download Template Schedule</a></span>
                                </div>
                                <div class="form-group">
                                    <label class="col-sm-3 control-label"> Periode </label>
                                    <div class="col-sm-7">
                                        <select class="ddl" id="periode" name="periode">
                                            <?php for ($x = -5; $x <= 5; $x++) { ?>
                                                <option value="<?PHP echo date("Ym", strtotime("+$x month")); ?>" <?php
                                                if ($selected_date == date("Ym", strtotime("+$x month"))) {
                                                    echo 'SELECTED';
                                                }
                                                ?> > <?php echo date("M Y", strtotime("+$x month")); ?> </option>
                                                    <?php } ?>
                                        </select>
                                    </div>                                      
                                </div>
                                <div class="form-group">
                                    <label class="col-sm-3 control-label"> Input File </label>
                                    <div class="col-sm-7">
                                        <input type="file" class="form-control" name="import_schedule" id="import__schedule" size="20" value="">
                                    </div>
                                </div>
                            </div>
                            <div class="modal-footer">
                                <div class="btn-group">
                                    <button type="button" class="btn btn-default" data-dismiss="modal"> Close </button>
                                    <button class="btn btn-primary" value="1" name="upload_button"> Upload </button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
        <?php
            foreach ($schedule as $edit){
                $dis_chan = '';
                if($isi->CHR_DIS_CHANNEL == 'C1'){
                    $dis_chan = 'C1 - OEM';
                } else if($isi->CHR_DIS_CHANNEL == 'C2'){
                    $dis_chan = 'C1 - AM';
                } else if($isi->CHR_DIS_CHANNEL == 'C3'){
                    $dis_chan = 'C1 - TRIAL';
                } else {
                    $dis_chan = 'C1 - OTHER';
                }
        ?>
            <div class="modal fade" id="modalEdit<?php echo $edit->INT_ID ?>" tabindex="-1" role="dialog" aria-labelledby="myModalLabel1" aria-hidden="true" style="display: none;">
                <div class="modal-wrapper">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <div class="modal-header bg-blue">
                                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">X</button>
                                <h4 class="modal-title" id="myModalLabel1"><strong>Edit Schedule Delivery</strong></h4>
                            </div>
                            <div class="modal-body">
                                <?php echo form_open('delivery/master_schedule_cust_c/update_schedule', 'class="form-horizontal"'); ?>
                                <div class="form-group">
                                    <label class="col-sm-4 control-label">Customer / Dock</label>
                                    <div class="col-sm-8">
                                        <input type='text' class="form-control" readonly name='cust' value="<?php echo $edit->CHR_CUST . ' / ' . $edit->CHR_CUST_DOCK ?>" ></input>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="col-sm-4 control-label">Customer No / Name</label>
                                    <div class="col-sm-8">
                                        <input type='text' class="form-control" readonly name='cust_desc' value="<?php echo trim($edit->CHR_CUST_SAP_NO) . ' / ' . $edit->CHR_CUST_DESC ?>" ></input>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="col-sm-4 control-label">Cycle / Dis Channel</label>
                                    <div class="col-sm-8">
                                        <input type='text' class="form-control" style='width:130px;' readonly name='cycle' value="<?php echo $edit->INT_CYCLE . ' / ' . $dis_chan ?>" ></input>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="col-sm-4 control-label">AII Arrival (Hm)</label>
                                    <div class="col-sm-8">
                                        <input type='text' class="form-control" style='width:100px;' placeholder='Hm' maxlength="4" onkeyup="angka(this);" onblur="checkLength(this);" value="<?php echo $edit->CHR_AII_ARRIVAL ?>" name='aii_arrival' />
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="col-sm-4 control-label">AII Departure (Hm)</label>
                                    <div class="col-sm-8">
                                        <input type='text' class="form-control" style='width:100px;' placeholder='Hm' maxlength="4" onkeyup="angka(this);" onblur="checkLength(this);" value="<?php echo $edit->CHR_AII_DEPARTURE ?>" name='aii_departure' />
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="col-sm-4 control-label">Cust Arrival (Hm)</label>
                                    <div class="col-sm-8">
                                        <input type='text' class="form-control" style='width:100px;' placeholder='Hm' maxlength="4" onkeyup="angka(this);" onblur="checkLength(this);" value="<?php echo $edit->CHR_CUST_ARRIVAL ?>" name='cust_arrival' />
                                    </div>
                                </div>
                                
                                <input type='hidden' value='<?php echo $edit->INT_ID; ?>' name='id_schedule' />
                                <input type='hidden' value='<?php echo $edit->CHR_PERIODE; ?>' name='periode' />
                            </div>

                            <div class="modal-footer">
                                <div class="btn-group">
                                    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                                    <button id="btn-ok" type="submit" class="btn btn-primary" data-placement="left" data-toggle="tooltip" title="Add To List" ><i class="fa fa-check"></i>Update</button>
                                    <?php echo form_close(); ?>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <?php }?>
    </section>
</aside>
<script src="<?php echo base_url('assets/js/jquery-1.12.3.js') ?>"></script>
<script src="<?php echo base_url('assets/js/jquery.dataTables.min.js') ?>"></script>
<script src="<?php echo base_url('assets/js/dataTables.fixedColumns.min.js') ?>"></script>
<script>
        $(document).ready(function() {
            $('#example').DataTable({
                scrollX: true,
                fixedColumns: {
                    leftColumns: 6,
                    rightColumns: 1
                }
            });
        });
</script>

