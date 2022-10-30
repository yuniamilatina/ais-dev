<script>
    $(function () {
        $("#datepicker").datepicker(
                {
                    dateFormat: 'dd/mm/yy',
                    changeMonth: false,
                    minDate: '31/01/2018' , maxDate: 'today'
//                changeYear: false,
//                duration: 'fast'
//                stepMonths: 0
                }
        );
    });
</script>

<style type="text/css">
    #table-luar{
        font-size: 12px;
    }
    #filter { 
        border-spacing: 5px;
    }
    .td-fixed{
        width: 10px;
    }
    #td_date{
        text-align:center;
        vertical-align:top;
    } 

    .filter { 
        border-spacing: 5px;
        border-collapse: separate;
    }

    #filterdiagram {
        border-spacing: 5px;
        border-color: #DDDDDD;
        background-color: #F3F4F5;
    }

    .btnt{
        border:none;
    }

    .btnt:focus{
        outline: none;
    }

    .btnt:hover {
        background: #428bca;
        background-image: -webkit-linear-gradient(top, #428bca, #428bca);
        background-image: -moz-linear-gradient(top, #428bca, #428bca);
        background-image: -ms-linear-gradient(top, #428bca, #428bca);
        background-image: -o-linear-gradient(top, #428bca, #428bca);
        background-image: linear-gradient(to bottom, #428bca, #428bca);
        color:white;
    }

</style>

<script>
    setTimeout(function () {
        document.getElementById("hide-sub-menus").click();
    }, 10);
//    setInterval(function(){ alert("Hello"); }, 3000);
//    setInterval(document.getElementById("hide-sub-menus").click(), 3000));

</script>

<aside class="right-side">
    <section class="content-header">
        <ol class="breadcrumb">
            <li><a href="<?php echo base_url('index.php/basis/home_c/'); ?>"><span>Home</span></a></li>
            <li><a href=""><strong>ENTRY DATA PURGING</strong></a></li>
        </ol>
    </section>

    <section class="content">
        <div class="row">
            <div class="col-md-12">
                <div class="grid">
                    <div class="grid-header">
                        <i class="fa fa-laptop"></i>
                        <span class="grid-title"><strong>ENTRY DATA PURGING</strong></span>
                        <div class="pull-right grid-tools" style="font-size:11px;" >

                        </div>
                    </div>

                    <div class="grid-body">
                        <table width="100%" class="filter" border="0px">
                            <tr>
                                <td width="60%" rowspan="4"></td>
                                <td width="10%">Tanggal</td>
                                <td>
                                    <input type="text" onchange="changeDate()" class="ddl" id="datepicker" placeholder="DD/MM/YYYY" value="<?php echo $date; ?>">
                                </td>
                            </tr>
                            
                            <tr>
                                <td>Shift</td>
                                <td colspan="5">
                                    <input type="submit" name="send" value="1" class="btnt" id="submit" style="height:35px;width:35px;border-radius: 60px; <?php
                                    if ($shift == '1') {
                                        echo 'background-color: #428bca;color:white;';
                                    } else {
                                        echo 'background-color: #EBEBE4;border-color: #DDDDDD;';
                                    }
                                    ?>" onClick="location.href = '<?php echo site_url('pes/entry_ng_purging_c/form/' . $date_l . '/1/') ?>';">
                                    <input type="submit" name="send" value="2" class="btnt" id="submit" style="height:35px;width:35px;border-radius: 60px; <?php
                                    if ($shift == '2') {
                                        echo 'background-color: #428bca;color:white;';
                                    } else {
                                        echo 'background-color: #EBEBE4;border-color: #DDDDDD;';
                                    }
                                    ?>" onClick="location.href = '<?php echo site_url('pes/entry_ng_purging_c/form/' . $date_l . '/2/') ?>';">
                                    <input type="submit" name="send" value="3" class="btnt" id="submit" style="height:35px;width:35px;border-radius: 60px; <?php
                                    if ($shift == '3') {
                                        echo 'background-color: #428bca;color:white;';
                                    } else {
                                        echo 'background-color: #EBEBE4;border-color: #DDDDDD;';
                                    }
                                    ?>" onClick="location.href = '<?php echo site_url('pes/entry_ng_purging_c/form/' . $date_l . '/3/') ?>';">
                                    <input type="submit" name="send" value="4" class="btnt" id="submit" style="height:35px;width:35px;border-radius: 60px; <?php
                                    if ($shift == '4') {
                                        echo 'background-color: #428bca;color:white;';
                                    } else {
                                        echo 'background-color: #EBEBE4;border-color: #DDDDDD;';
                                    }
                                    ?>" onClick="location.href = '<?php echo site_url('pes/entry_ng_purging_c/form/' . $date_l . '/4/') ?>';">
                                </td>
                            </tr>
                        </table>

                    </div>
                    <div class="grid-body">
                        <div class="pull-right">
                        </div>

                        <table  width="100%" border="0px">
                            <tr>
                                <td >
                                    <button class="btn btn-danger" data-toggle="modal" data-target="#modalDefault" data-placement="left" data-toggle="tooltip" title="Add Part" style="display:block;"><span class="fa fa-plus"></span> &nbsp;&nbsp; Add Part</button>
                                </td>
                            </tr>
                        </table>

                        <table class="table table-condensed table-striped" id="list_data" >
                            <thead>
                                <tr>
                                    <th width="20px" rowspan="2" style="text-align:center;vertical-align:middle">No</th>
                                    <th width="180px" rowspan="2" style="text-align:center;vertical-align:middle">Part Number</th>
                                    <th width="360px" rowspan="2" style="text-align:center;vertical-align:middle">P.Name & Model</th>
                                    <th width="80px" rowspan="2" style="text-align:center;vertical-align:middle">Time Updated</th>
                                    <th width="80px" rowspan="2" style="text-align:center;vertical-align:middle">Date Updated</th>
                                    <th width="100px" rowspan="2" style="text-align:center;vertical-align:middle">Qty Purging (Gram)</th>
                                    <th width="80px" rowspan="2" style="text-align:center;vertical-align:middle">Action</th>
                                </tr>
                            </thead>

                            <tbody>
                                <?php $i=1;
                                foreach ($data_purging as $isi){
                                     echo "<tr>";
                                        echo "<td style='text-align:center'>$i</td>";
                                        echo "<td style='text-align:center'>$isi->CHR_PART_NO</td>";
                                        echo "<td style='text-align:center'>$isi->CHR_PART_NAME</td>";
                                        echo "<td style='text-align:center'>" . SUBSTR($isi->CHR_MODIFIED_TIME,0,2).":".SUBSTR($isi->CHR_MODIFIED_TIME,2,2).":".SUBSTR($isi->CHR_MODIFIED_TIME,4,2)."</td>";
                                        echo "<td style='text-align:center'>" . SUBSTR($isi->CHR_MODIFIED_DATE,6,2)."/".SUBSTR($isi->CHR_MODIFIED_DATE,4,2)."/".SUBSTR($isi->CHR_MODIFIED_DATE,0,4)."</td>";
                                        echo "<td style='text-align:center'>" . NUMBER_FORMAT($isi->INT_QTY,0,',','.' ) ."</td>";
                                       ?>
                                <td style='text-align:center'>
                                    <a class="label label-warning" style='width:35px;height:27px' data-toggle="modal" data-target="#modalEdit<?php echo $isi->INT_ID ?>" data-placement="top" title="Edit"><span class="fa fa-pencil"></span></a>
                                </td>
                                </tr>
                                <?php
                                $i++;
                            }
                            ?>
                             </tbody>
                        </table>

                        <div class="modal fade" id="modalDefault" tabindex="-1" role="dialog" aria-labelledby="myModalLabel1" aria-hidden="true" style="display: none;">
                            <div class="modal-wrapper">
                                <div class="modal-dialog">
                                    <div class="modal-content">
                                        <div class="modal-header bg-blue">
                                            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">X</button>
                                            <h4 class="modal-title" id="myModalLabel1"><strong>Add Part To List</strong></h4>
                                        </div>
                                        <div class="modal-body">
                                            <?php echo form_open('pes/entry_ng_purging_c/add_list_purging', 'class="form-horizontal"'); ?>

                                            <div class="form-group">
                                                <label class="col-sm-4 control-label">Back No</label>
                                                <div class="col-sm-8">
                                                    <select id='e1' name='back_no' style="width:380px" >
                                                        <?php foreach ($part_purging as $part_list) { ?>
                                                            <option name='back_no' value="<?php echo $part_list->CHR_PART_NO ?>"><?php echo $part_list->CHR_PART_NO . ' / ' . $part_list->part_name; ?></option>
                                                        <?php } ?>
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <label class="col-sm-4 control-label">Qty Purging (Gram)</label>
                                                <div class="col-sm-8">
                                                    <input type='text' placeholder='Gram' onkeyup="angka(this);" name='qty' required />
                                                </div>
                                            </div>
                                            <input type='hidden' value='<?php echo $date_l; ?>' name='date' />
                                            <input type='hidden' value='<?php echo $shift; ?>' name='shift' />
                                        </div>

                                        <div class="modal-footer">
                                            <div class="btn-group">
                                                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                                                <button id="btn-ok" type="submit" class="btn btn-primary" data-placement="left" data-toggle="tooltip" title="Add To List" ><i class="fa fa-check"></i> Add to List</button>
                                                <?php echo form_close(); ?>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <?php
                                foreach ($data_purging as $edit){
                                    ?>
                        <div class="modal fade" id="modalEdit<?php echo $edit->INT_ID ?>" tabindex="-1" role="dialog" aria-labelledby="myModalLabel1" aria-hidden="true" style="display: none;">
                            <div class="modal-wrapper">
                                <div class="modal-dialog">
                                    <div class="modal-content">
                                        <div class="modal-header bg-blue">
                                            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">X</button>
                                            <h4 class="modal-title" id="myModalLabel1"><strong>Edit Quantity Purging</strong></h4>
                                        </div>
                                        <div class="modal-body">
                                            <?php echo form_open('pes/entry_ng_purging_c/update_list_purging', 'class="form-horizontal"'); ?>
                                            <div class="form-group">
                                                <label class="col-sm-4 control-label">Back No</label>
                                                <div class="col-sm-8">
                                                    <input type='text' readonly name='back_no' value="<?php echo $edit->CHR_PART_NO ?>" ></input>
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <label class="col-sm-4 control-label">Qty Purging (Gram)</label>
                                                <div class="col-sm-8">
                                                    <input type='text' placeholder='Gram' onkeyup="angka(this);" value="<?php echo $edit->INT_QTY ?>" name='qty' />
                                                </div>
                                            </div>
                                            <input type='hidden' value='<?php echo $edit->INT_ID ?>' name='idupdate' />
                                            <input type='hidden' value='<?php echo $edit->INT_QTY ?>' name='qty_before' />
                                            <input type='hidden' value='<?php echo $edit->CHR_REMARKS ?>' name='remarks' />
                                            <input type='hidden' value='<?php echo $date_l; ?>' name='date' />
                                            <input type='hidden' value='<?php echo $shift; ?>' name='shift' />
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
                    </div>
                </div>
            </div>
        </div>
    </section>
</aside>
<script>   
    function changeDate() {
        var date_t = document.getElementById('datepicker').value;
        var date_fix = date_t.substr(6, 4) + date_t.substr(3, 2) + date_t.substr(0, 2);
        location.href = '<?php echo site_url() ?>/pes/entry_ng_purging_c/form/' + date_fix + '/' + <?php echo $shift; ?>;
    }
    
    function angka(objek) {
        a = objek.value;
        b = a.replace(/[^\d]/g, "");
        c = "";
        panjang = b.length;
        j = 0;
        for (i = panjang; i > 0; i--) {
            j = j + 1;
            if (((j % 3) == 1) && (j != 1)) {
                c = b.substr(i - 1, 1) + "." + c;
            } else {
                c = b.substr(i - 1, 1) + c;
            }
        }
        objek.value = trimNumber(c);
    }
    
    function trimNumber(s) {
        while (s.substr(0, 1) == '0' && s.length > 1) {
            s = s.substr(1, 9999);
        }
        while (s.substr(0, 1) == '.' && s.length > 1) {
            s = s.substr(1, 9999);
        }
        return s;
    }
    
</script>

