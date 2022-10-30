<aside class="right-side">
    <section class="content-header">
        <ol class="breadcrumb">
            <li><a href="<?php echo base_url('index.php/basis/home_c/"') ?>"><span>Home</span></a></li>
            <li><a href="<?php echo base_url('index.php/mte/mold_c/"') ?>"><span>Manage Mold</span></a></li>
            <li> <a href="#"><strong>Manage Mold Detail</strong></a></li>
        </ol>
    </section>

    <section class="content">
        <?php if ($msg != NULL) {
            echo $msg;
        } ?>
        <div class="row">
            <div class="col-md-12">
                <div class="grid">
                    <div class="grid-header">
                        <i class="fa fa-sitemap"></i>

                        <span class="grid-title"><strong><?php echo strtoupper($ttl); ?> DETAIL</strong> TABLE</span>
                        <div class="pull-right">
                            <!-- <a href="<?php echo base_url('index.php/mte/mold_c/create_mold_detail/') ?>" class="btn btn-default" data-toggle="tooltip" data-placement="left" title="Create Mold_detail" style="height:30px;font-size:13px;width:100px;">Create</a> -->
                            <!-- <?php echo '<input type="button" data-toggle="modal" data-target="#modalmold_detail" data-placement="left" title="Create Mold_detail" class="btn btn-default" style="height:30px; width:100px;" value="Create">'; ?> -->
                        </div>
                    </div>
                    <div class="grid-body">
                        <table id="dataTables1" class="table table-striped table-condensed table-hover display" cellspacing="0" width="100%">
                            <thead>
                                <tr>
                                    <th>No</th>
                                    <th>Mold Code</th>
                                    <th>Part No</th>
                                    <th>Back No</th>
                                    <th>Part Name</th>
                                    <th>Work Center</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                $i = 1;
                                foreach ($data as $isi) {
                                    $a = "";
                                    $b = "";
                                    $c = "";
                                    $d = "";
                                    $partnumber = "";
                                    $partnum = trim($isi->CHR_PART_NO," ");
                                    $n = strlen($partnum);
                                    if($n == 11){
                                        $a = substr($partnum, 0, 6)."-";
                                        $b = substr($partnum, 6, 5);
                                        $partnumber = $a.$b;
                                    } elseif ($n == 13) {
                                        $a = substr($partnum, 0, 6)."-";
                                        $b = substr($partnum, 6, 5). "-";
                                        $c = substr($partnum, 11, 2);
                                        $partnumber = $a.$b.$c;
                                    } elseif($n > 13) {
                                        $a = substr($partnum, 0, 6)."-";
                                        $b = substr($partnum, 6, 5). "-";
                                        $c = substr($partnum, 11, 2). "-";
                                        $d = substr($partnum, 13, 2);
                                        $partnumber = $a.$b.$c.$d;
                                    }

                                    echo "<tr class='gradeX'>";
                                    echo "<td>$i</td>";
                                    echo "<td>$isi->CHR_CODE_MOLD</td>";
                                    echo "<td>$partnumber</td>";
                                    echo "<td>$isi->CHR_BACK_NO</td>";
                                    echo "<td>$isi->CHR_PART_NAME</td>";
                                    echo "<td>$isi->CHR_WORK_CENTER</td>";
                                    ?>
                                <td>
                                    <!-- <a href="<?php echo base_url('index.php/mte/mold_c/edit_mold_detail') . "/" . $isi->CHR_CODE_MOLD_DETAIL; ?>" class="label label-warning" data-placement="top" data-toggle="tooltip" title="Edit"><span class="fa fa-pencil"></span></a> -->
                                    <a href="<?php echo base_url('index.php/mte/mold_c/delete_mold_detail') . "/" . $isi->CHR_CODE_MOLD . "/" . trim($isi->CHR_PART_NO) . "/" . $isi->CHR_WORK_CENTER; ?>" class="label label-danger" data-placement="top" data-toggle="tooltip" title="Delete" onclick="return confirm('Are you sure want to delete this part number?');"><span class="fa fa-times"></span></a>
                                    
                                </td>
                                </tr>
                                <?php
                                $i++;
                            }
                            ?>
                            </tbody>
                        </table>
                        <a href="#" class="btn btn-primary" data-toggle="modal" data-target="#modalmold" data-placement="left" title="Add Part Number"><i class="fa fa-plus"></i> Add Part Number</a>
                        <?php echo anchor('mte/mold_c', 'Back', 'class="btn btn-default"'); ?>
                    </div>
                </div>
            </div>
        </div>

        <!-- Modal Create Mold -->
        <div class="modal fade" id="modalmold" tabindex="-1" role="dialog" aria-labelledby="modalLabelMold" aria-hidden="true" style="display: none;">
            <div class="modal-wrapper">
                <div class="modal-dialog" style="width:1150px;">
                    <div class="modal-content">
                        <div class="modal-header">
                            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">x</button>
                            <h4 class="modal-title" id="modalLabelMold"><strong>PART NUMBER</strong></h4>
                        </div>
                        <div class="modal-body" style="font-size:12px;">
                            <table id="dataTables2" class="table table-striped table-condensed table-hover display" cellspacing="0" width="100%">
                                <thead>
                                    <tr>
                                        <th>Part No</th>
                                        <th>Back No</th>
                                        <th>Part Name</th>
                                        <th>Work Center</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php 
                                    $i = 1;
                                    foreach ($part as $data) { 
                                        $a = "";
                                        $b = "";
                                        $c = "";
                                        $d = "";
                                        $partnumber = "";
                                            $partnum = trim($data->PartNo," ");
                                            $n = strlen($partnum);
                                            if($n == 11){
                                                $a = substr($partnum, 0, 6)."-";
                                                $b = substr($partnum, 6, 5);
                                                $partnumber = $a.$b;
                                            } elseif ($n == 13) {
                                                $a = substr($partnum, 0, 6)."-";
                                                $b = substr($partnum, 6, 5). "-";
                                                $c = substr($partnum, 11, 2);
                                                $partnumber = $a.$b.$c;
                                            } elseif($n > 13) {
                                                $a = substr($partnum, 0, 6)."-";
                                                $b = substr($partnum, 6, 5). "-";
                                                $c = substr($partnum, 11, 2). "-";
                                                $d = substr($partnum, 13, 2);
                                                $partnumber = $a.$b.$c.$d;
                                            }
                                    ?>
                                    <tr>
                                        <td><?php echo trim($partnumber); ?></td>
                                        <td><?php echo trim($data->BackNo); ?></td>
                                        <td><?php echo trim($data->PartName); ?></td>                                        
                                        <td><?php echo trim($data->WorkCenter); ?></td>
                                        <td><input type="checkbox" name="check_list<?php echo $i ?>" value="<?php echo $data->PartNo.":".$data->BackNo.":".$data->PartName.":".$data->WorkCenter ?>" onclick="$('#chk_list<?php echo $i ?>').click()"></td>
                                    </tr>
                                    <?php 
                                    $i++;
                                } ?>
                                </tbody>
                            </table>
                        </div>
                        <div class="modal-footer">
                            <div class="btn-group">
                                <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
                                <button type="submit" class="btn btn-primary" data-placement="left" title="Add Part Number" onclick="savePart()" data-dismiss="modal"><i class="fa fa-check"></i> Add to List</button>
                                <?php
                                echo form_close();
                                ?>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <table style="display:none;">
        <!-- <table> -->
            <tbody>
                <?php
                    $j = 1;
                    foreach ($part as $value_mb) {
                        ?>
                        <tr class="row_data">
                            <td style="text-align: center">
                                <!-- <input type="checkbox" name="chk_list<?php echo trim($value_mb->PartNo).trim($value_mb->WorkCenter) ?>" id="chk_list<?php echo trim($value_mb->PartNo).trim($data->WorkCenter) ?>" value="<?php echo $value_mb->PartNo.":".$value_mb->BackNo.":".$value_mb->PartName.":".$value_mb->WorkCenter ?>">  -->
                                <input type="checkbox" name="chk_list[]" id="chk_list<?php echo $j ?>" value="<?php echo $value_mb->PartNo.":".$value_mb->BackNo.":".$value_mb->PartName.":".$value_mb->WorkCenter ?>">      
                            </td>
                            <td style="text-align: center"><?php echo $value_mb->PartNo ?></td>
                        </tr>
                        <?php
                    $j++;
                    }
                ?>
            </tbody>
        </table>

    </section>


    <script>
        function savePart(){
            var checkedValue = null; 
            var inputElements = document.getElementsByName('chk_list[]');
            for(var i=0; inputElements[i]; ++i){
                if(inputElements[i].checked){
                    var mystr = inputElements[i].value;
                    //Splitting it with : as the separator
                    var myarr = mystr.split(":");
                    //Then read the values from the array where 0 is the first
                    var partNo = myarr[0];
                    var backNo = myarr[1];
                    var partName = myarr[2];
                    var wc = myarr[3];

                    $.ajax({
                        async: false,
                        type: "POST",
                        url: "<?php echo site_url('mte/mold_c/save_part'); ?>",
                        data: "CHR_CODE_MOLD=<?php echo $kode ?> &CHR_PART_NO=" + partNo + "&CHR_BACK_NO=" + backNo + "&CHR_PART_NAME=" + partName + "&CHR_WORK_CENTER=" + wc,
                        success: function(data) {
                            console.log(data);
                            var kode = "/<?php echo $kode ?>";
                            var param = "/2";
                            window.location = "<?php echo site_url('mte/mold_c/detail_mold/') ?>" + kode + param;
                        },
                        error: function(data){
                            console.log(data);
                            alert('error');
                        }
                    });
                }
            }
        }
    </script>

</aside>


