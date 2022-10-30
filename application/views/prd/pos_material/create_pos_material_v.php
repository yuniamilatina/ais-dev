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

<script language="JavaScript">
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
        objek.value = Number(c);
    }

    function Number(s) {
        while (s.substr(0, 1) == '0' && s.length > 1) {
            s = s.substr(1, 9999);
        }
        while (s.substr(0, 1) == '' && s.length > 1) {
            s = s.substr(1, 9999);
        }
        return s;
    }

</script>

<aside class="right-side">
    <section class="content-header">
        <ol class="breadcrumb">
            <li><a href="<?php echo base_url('index.php/basis/home_c/') ?>"><span>Home</span></a></li>
            <li> <a href="<?php echo base_url('index.php/prd/pos_material_c') ?>">MANAGE POS MATERIAL</a></li>
            <li> <a href="#"><strong>CREATE POS MATERIAL</strong></a></li>
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
                        <i class="fa  fa-puzzle-piece"></i>
                        <span class="grid-title" id="stat-create2"><strong id="stat-create">CREATE POS MATERIAL</strong></span>
                        <div class="pull-right grid-tools">
                            <a data-widget="collapse" title="Collapse" id="collapse-header"><i class="fa fa-chevron-up"></i></a>
                        </div>
                    </div>
                    <?php
                        echo form_open('prd/pos_material_c/search_component', 'class="form-horizontal"');
                        ?>
                    <div class="grid-body">
                    
                        <div class="form-group">
                            <label class="col-sm-3 control-label">Work Center</label>
                            <div class="col-sm-2">
                                    <select id="work_center" readonly name="CHR_WORK_CENTER" class="form-control" onchange="get_data_part();">
                                            <?php
                                            foreach ($all_work_centers as $row) {
                                                if (trim($row->CHR_WORK_CENTER) == trim($work_center)) {
                                                    ?>
                                                    <option selected value="<?php echo trim($row->CHR_WORK_CENTER); ?>" > <?php echo trim($row->CHR_WORK_CENTER); ?> </option>
                                                <?php } else { ?>
                                                    <option value="<?php echo trim($row->CHR_WORK_CENTER); ?>" > <?php echo trim($row->CHR_WORK_CENTER); ?> </option>
                                                    <?php
                                                }
                                            }
                                            ?>
                                    </select>
                            </div>
                        </div>

                        
                        <div class="form-group">
                            <label class="col-sm-3 control-label">Part No</label> <!--onchange="get_data_component();"-->
                            <div class="col-sm-3" >
                                <select class="form-control" name="CHR_PART_NO" id="e1"  required>
                                    <?php 
                                    foreach ($data_part_no as $row) {
                                        if (trim($row->CHR_PART_NO) == trim($part_no)) {
                                            ?>
                                            <option selected value="<?php echo trim($row->CHR_PART_NO); ?>" > <?php echo trim($row->CHR_PART_NO); ?> </option>
                                        <?php } else { ?>
                                            <option value="<?php echo trim($row->CHR_PART_NO); ?>" > <?php echo trim($row->CHR_PART_NO); ?> </option>
                                            <?php
                                        }
                                    }
                                    ?> 
                                </select>
                            </div>
                            <button type="submit" class="btn btn-success"><i class="fa fa-search"></i> Seacrh</button>
                        </div>

                        <?php
                         echo form_close();
                         echo form_open('prd/pos_material_c/save_pos_material', 'class="form-horizontal"');
                        ?>

                        <div class="pull">
                            <span style='text-decoration: underline;'></span>
                            <strong>Component Part</strong>
                        </div>

                         <div id="table-luar" >
                            <table style="margin-bottom:15px;" id="example2" class="table table-condensed table-striped table-hover display" cellspacing="0" width="100%">
                                <thead>
                                    <tr>
                                        <th style="text-align:left;background-color:#666666;color:#FFFFFF;">No</th>
                                        <th style="text-align:left;background-color:#666666;color:#FFFFFF;">Part No. Comp.</th>
                                        <th style="text-align:center;background-color:#666666;color:#FFFFFF;">Part Name Comp.</th>
                                        <!-- <th style="text-align:center;background-color:#666666;color:#FFFFFF;">Level</th> -->
                                        <th style="text-align:center;background-color:#666666;color:#FFFFFF;">Qty</th>
                                        <th style="text-align:center;background-color:#666666;color:#FFFFFF;">Pos</th>
                                    </tr>
                                </thead>
                                    <tbody>
                                            <?php
                                            $i = 1;
                                            $y = 0;
                                            $x = 1;
                                            $flag = 0;
                                            foreach ($data_bom['detail'] as $row) {
                                                
                                                if((int)substr($row['DGLVL'],'-1') == 1){
                                                    $flag = 0;
                                                    if($row['DUMPS'] <> 'X'){
                                                        
                                                        $qty = explode('.',$row['MNGLG']);
                                                            ?>
                                                            <tr class='gradeX'>
                                                                <!-- <input readonly name="tableRow[<?php //echo $y; ?>][INT_ID_DEPT]" type='hidden' value="<?php //echo $id_dept ?>"  style='width:200px;background:transparent;text-align:center;'></input> -->
                                                                <input readonly name="tableRow[<?php echo $y; ?>][CHR_WORK_CENTER]" type='hidden' value="<?php echo $work_center ?>"  style='width:200px;background:transparent;text-align:center;'></input>
                                                                <input readonly name="tableRow[<?php echo $y; ?>][CHR_PART_NO]" type='hidden' value="<?php echo $part_no ?>"  style='width:200px;background:transparent;text-align:center;'></input>

                                                                <td style="text-align:left;"><?php echo $i ?></td>
                                                                <td style="text-align:left;">
                                                                    <input style='border:none;width:100px;background:transparent;text-align:left;' readonly name="tableRow[<?php echo $y; ?>][DOBJT]" type='text' value="<?php echo $row['DOBJT'] ?>"  ></input>
                                                                </td>
                                                                <td>
                                                                    <input style='border:none;width:300px;background:transparent;text-align:left;' readonly name="tableRow[<?php echo $y; ?>][OJTXP]" type='text' value="<?php echo $row['OJTXP'] ?>"  ></input>
                                                                </td>
                                                                <!-- <td style="text-align:center;">
                                                                    <input style='border:none;width:50px;background:transparent;text-align:center;' readonly name="tableRow[<?php echo $y; ?>][DGLVL]" type='text' value="<?php echo (int)substr($row['DGLVL'],'-1').'-'.$row['DUMPS']?>"  ></input>
                                                                </td>  -->
                                                                <td style="text-align:center;">
                                                                    <input style='border:none;width:50px;background:transparent;text-align:center;' readonly name="tableRow[<?php echo $y; ?>][MNGKO]" type='text' value="<?php echo $qty[0] ?>" ></input>
                                                                </td>  
                                                                <td style="text-align:center;">
                                                                    <select required class="form-control" name="tableRow[<?php echo $y; ?>][CHR_POS_PRD]" >
                                                                    <?php 
                                                                    foreach ($data_pos as $row_pos) {
                                                                        if (trim($row_pos->CHR_POS_PRD) == trim($pos)) {
                                                                            ?>
                                                                            <option selected value="<?php echo trim($row_pos->CHR_POS_PRD); ?>" > <?php echo trim($row_pos->CHR_POS_PRD); ?> </option>
                                                                        <?php } else { ?>
                                                                            <option value="<?php echo trim($row_pos->CHR_POS_PRD); ?>" > <?php echo trim($row_pos->CHR_POS_PRD); ?> </option>
                                                                            <?php
                                                                        }
                                                                    }
                                                                    ?> 
                                                                    </select>
                                                                </td>
                                                                </tr>
                                                            <?php    
                                                                $i++;
                                                                $y++;

                                                        $flag = (int)substr($row['DGLVL'],'-1');
                                                    }
                                                }else{
                                                    if($flag >= (int)substr($row['DGLVL'],'-1') || $flag == 0){
                                                        
                                                        if($row['DUMPS'] <> 'X'){
                                                            
                                                            $qty = explode('.',$row['MNGLG']);
                                                            ?>
                                                            <tr class='gradeX'>
                                                                <!-- <input readonly name="tableRow[<?php //echo $y; ?>][INT_ID_DEPT]" type='hidden' value="<?php //echo $id_dept ?>"  style='width:200px;background:transparent;text-align:center;'></input> -->
                                                                <input readonly name="tableRow[<?php echo $y; ?>][CHR_WORK_CENTER]" type='hidden' value="<?php echo $work_center ?>"  style='width:200px;background:transparent;text-align:center;'></input>
                                                                <input readonly name="tableRow[<?php echo $y; ?>][CHR_PART_NO]" type='hidden' value="<?php echo $part_no ?>"  style='width:200px;background:transparent;text-align:center;'></input>

                                                                <td style="text-align:left;"><?php echo $i ?></td>
                                                                <td style="text-align:left;">
                                                                    <input style='border:none;width:100px;background:transparent;text-align:left;' readonly name="tableRow[<?php echo $y; ?>][DOBJT]" type='text' value="<?php echo $row['DOBJT'] ?>"  ></input>
                                                                </td>
                                                                <td>
                                                                    <input style='border:none;width:300px;background:transparent;text-align:left;' readonly name="tableRow[<?php echo $y; ?>][OJTXP]" type='text' value="<?php echo $row['OJTXP'] ?>"  ></input>
                                                                </td>
                                                                <!-- <td style="text-align:center;">
                                                                    <input style='border:none;width:50px;background:transparent;text-align:center;' readonly name="tableRow[<?php echo $y; ?>][DGLVL]" type='text' value="<?php echo (int)substr($row['DGLVL'],'-1').'-'.$row['DUMPS']?>"  ></input>
                                                                </td>  -->
                                                                <td style="text-align:center;">
                                                                    <input style='border:none;width:50px;background:transparent;text-align:center;' readonly name="tableRow[<?php echo $y; ?>][MNGKO]" type='text' value="<?php echo $qty[0] ?>" ></input>
                                                                </td>  
                                                                <td style="text-align:center;">
                                                                    <select required class="form-control" name="tableRow[<?php echo $y; ?>][CHR_POS_PRD]" >
                                                                    <?php 
                                                                    foreach ($data_pos as $row_pos) {
                                                                        if (trim($row_pos->CHR_POS_PRD) == trim($pos)) {
                                                                            ?>
                                                                            <option selected  value="<?php echo trim($row_pos->CHR_POS_PRD); ?>" > <?php echo trim($row_pos->CHR_POS_PRD); ?> </option>
                                                                        <?php } else { ?>
                                                                            <option  value="<?php echo trim($row_pos->CHR_POS_PRD); ?>" > <?php echo trim($row_pos->CHR_POS_PRD); ?> </option>
                                                                            <?php
                                                                        }
                                                                    }
                                                                    ?> 
                                                                    </select>
                                                                </td>
                                                                </tr>
                                                            <?php    
                                                                $i++;
                                                                $y++;
                                                                
                                                            $flag = (int)substr($row['DGLVL'],'-1');
                                                        }
                                                        if($flag == (int)substr($row['DGLVL'],'-1') AND $row['DUMPS'] == 'X'){
                                                            $flag = 0;
                                                        }
                                                    }
                                                    
                                                    
                                                }

                                               
                                            }
                                        ?>
                                </tbody>
                            </table>
                            <!-- <span >Showing 0 to 0 of 0 entries</span> -->
                    
                        <!-- <input type="hidden" name="INT_ID_DEPT" value="<?php //echo $id_dept ?>" ></input> -->
                        <input type="hidden" name="CHR_WORK_CENTER" value="<?php echo $work_center ?>" ></input>

                        <div class="form-group">
                            <div class="col-sm-offset-4 col-sm-5">
                                <div class="btn-group">
                                    <button type="submit" class="btn btn-primary"><i class="fa fa-check"></i> Save</button>
                                    <?php
                                    echo anchor('prd/pos_material_c/index/'.$work_center, 'Cancel', 'class="btn btn-default"');
                                    echo form_close();
                                    ?>
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
    var dept_to_work_center = document.getElementById('dept_to_work_center').value;

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

function get_data_part(){
                var work_center = document.getElementById('work_center').value;

                $.ajax({
                    async: false,
                    type: "POST",
                    dataType: 'json',
                    url: "<?php echo site_url('part/part_c/get_data_part_by_work_center'); ?>",
                    data:  {
                            CHR_WCENTER: work_center
                            },
                    success: function (json_data) {
                        $("#e1").html(json_data['data']);
                    },
                    error: function (request) {
                        alert(request.responseText);
                    }
                });
}

    // function get_data_component(){
    //             var work_center = document.getElementById('work_center').value;
    //             var part_no = document.getElementById('e1').value;

    //             $.ajax({
    //                 async: false,
    //                 type: "POST",
    //                 dataType: 'json',
    //                 url: "<?php echo site_url('part/part_c/get_data_part_component_by_part'); ?>",
    //                 data:  {
    //                         CHR_WORK_CENTER: work_center,
    //                         CHR_PART_NO: part_no
    //                         },
    //                 success: function (json_data) {
    //                     $("#component").html(json_data['data']);
    //                 },
    //                 error: function (request) {
    //                     alert(request.responseText);
    //                 }
    //             });
    // }
</script>

<script src="<?php echo base_url('assets/js/jquery-1.12.3.js') ?>"></script>
<script src="<?php echo base_url('assets/js/jquery.dataTables.min.js') ?>"></script>
<script src="<?php echo base_url('assets/js/dataTables.fixedColumns.min.js') ?>"></script>
<link rel="stylesheet" href="<?php echo base_url('assets/css/fixedColumns.dataTables.min.css'); ?>" >
<script>

                                                            $(document).ready(function () {
                                                    var table = $('#example2').DataTable({
                                                    scrollY: "450px",
                                                            scrollX: true,
                                                            scrollCollapse: true,
                                                            paging: false,
                                                            bFilter: false,
                                                            fixedColumns: {
                                                            leftColumns: 0
                                                            }
                                                    });
                                                    });

</script>