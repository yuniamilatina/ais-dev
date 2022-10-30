<aside class="right-side">
    <section class="content-header">
        <ol class="breadcrumb">
            <li><a href="<?php echo base_url('index.php/basis/home_c/') ?>">Home</a></li>
            <li><a href="<?php echo base_url('index.php/mte/mold_c/') ?>">Manage Mold</a></li>
            <li><a href="#"><strong>Create Mold</strong></a></li>
        </ol>
    </section>

    <section class="content">
        <?php if ($msg != NULL) {
            echo $msg;
        } ?> 
        <?php
        if (validation_errors()) {
            echo '<div class = "alert alert-danger"><strong>WARNING !</strong>' . validation_errors() . '</div >';
        }
        $attributes = array('id' => 'form_mold');
        echo form_open_multipart('mte/mold_c/save_mold', 'class="form-horizontal"', $attributes);
        ?>
        <div class="row">
            <div class="col-md-12">
                <div class="grid">
                    <div class="grid-header">
                        <i class="fa fa-sitemap"></i>
                        <span class="grid-title"><strong>CREATE MOLD</strong></span>
                        <div class="pull-right grid-tools">
                            <a data-widget="collapse" title="Collapse"><i class="fa fa-chevron-up"></i></a>
                        </div>
                    </div>
                    
                    <div class="grid-body">
                        <div class="form-group">
                            <label class="col-sm-3 control-label">Code Mold</label>
                            <div class="col-sm-5">
                                <input name="CHR_CODE_MOLD" class="form-control" required type="text">
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-3 control-label">Mold Name</label>
                            <div class="col-sm-5">
                                <input name="CHR_MOLD_NAME" class="form-control" required type="text">
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-3 control-label">Model Name</label>
                            <div class="col-sm-5">
                                <input name="CHR_MODEL" class="form-control" required type="text">
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-3 control-label">Part Number</label>
                            <div class="col-sm-5">
                                <table id="partNumber" style="font-size:12px;" id="example" class="table table-condensed table-hover display" cellspacing="0" width="100%">
                                    <thead>
                                        <tr>
                                            <th>Part No</th>
                                            <th>Back No</th>
                                            <th>Part Name</th>
                                            <th>Work Center</th>
                                            <th>Action</th>
                                        </tr>
                                    </thead>
                                    <tbody id="partNumb">
                                        
                                    </tbody>
                                </table>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-3 control-label"></label>
                                <div class="col-sm-5">
                                    <a href="#" class="btn label label-success" data-toggle="modal" data-target="#modalmold" onclick="getPartList()" data-placement="left" title="Add Part Number"><i class="fa fa-plus"></i> Add Part Number</a>   
                                </div>
                        </div>
                        <div class="form-group">
                            <div class="col-sm-offset-3 col-sm-5">
                                <div class="btn-group">
                                    <button type="submit" class="btn btn-primary"><i class="fa fa-check"></i> Save</button>
                                    <?php echo anchor('mte/mold_c', 'Cancel', 'class="btn btn-default"');
                                    ?>
                                </div>
                            </div>
                        </div>
                    </div>

                        
                        <?php
                        echo form_close();
                        ?>
                    </div>
                </div>
            </div>
        </div>

        <!-- Modal Add Part Number -->
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
                            <!-- <div id="all_list_part" style="overflow-y: scroll; max-height: 350px;"> -->
                            <table id="dataTables1" class="table table-striped table-condensed table-hover display" cellspacing="0" width="100%">
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
                                    foreach ($isi as $data) { 
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
                                        <!-- <td><input type="checkbox" name="check_list<?php echo trim($data->PartNo).trim($data->WorkCenter) ?>" value="<?php echo $data->PartNo.":".$data->BackNo.":".$data->PartName.":".$data->WorkCenter ?>" onclick="$('#chk_list<?php echo trim($data->PartNo).trim($data->WorkCenter) ?>').click()"></td> -->
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
                                <button type="submit" class="btn btn-primary" data-placement="left" title="Add Part Number" onclick="setTable(<?php echo ($i-1) ?>)" data-dismiss="modal"><i class="fa fa-check"></i> Add to List</button>
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
                    foreach ($isi as $value_mb) { 
                        ?>
                        <tr class="row_data">
                            <td style="text-align: center">
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


        <script>
            var j = 0;
            function setTable(row){
                var checkedValue = null; 
                var inputElements = document.getElementsByName('chk_list[]');
                // var arrInputs = document.getElementsByTagName("input");

                var Parent = document.getElementById('partNumb');
                while(Parent.hasChildNodes())
                {
                   Parent.removeChild(Parent.firstChild);
                }
                
                for(var i=0; inputElements[i]; ++i){
                      if(inputElements[i].checked){
                        var mystr = inputElements[i].value;
                        //Splitting it with : as the separator
                        var myarr = mystr.split(":");
                        //Then read the values from the array where 0 is the first
                        var partNo = myarr[0].trim();
                        var backNo = myarr[1].trim();
                        var partName = myarr[2].trim();
                        var wc = myarr[3].trim();
                        var a = "";
                        var b = "";
                        var c = "";
                        var d = "";
                        var partnumber = "";
                        var n = partNo.length;

                        if(n == 11){
                            a = partNo.substring(0,6)+'-';
                            b = partNo.substring(6,11);
                            partnumber = a + b;
                        } else if(n == 13) {
                            a = partNo.substring(0,6)+'-';
                            b = partNo.substring(6,11)+'-';
                            c = partNo.substring(11,13);
                            partnumber = a + b + c;
                        } else if(n > 13) {
                            a = partNo.substring(0,6)+'-';
                            b = partNo.substring(6,11)+'-';
                            c = partNo.substring(11,13)+'-';
                            d = partNo.substring(13,15);
                            partnumber = a + b + c + d;
                        }


                       $('#partNumber').append('<tr id="row'+j+'"><td>'+partnumber+'<input type="hidden" name="partnumb[]" value="'+inputElements[i].value+'"></td><td>'+backNo+'</td><td>'+partName+'</td><td>'+wc+'</td><td><a href="#" class="label label-danger" onclick="removeRow(\'row'+j+'\')"><span class="fa fa-times"></span></a></td></tr>');
                       j++;
                      }
                }
            }
        </script>

        <script>
            function removeRow(rowid){
                var row = document.getElementById(rowid);
                row.parentNode.removeChild(row);
            }
        </script>

    </section>
</aside>

