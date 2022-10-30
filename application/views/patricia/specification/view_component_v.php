<script>
    function setLabel(unit) {
        if(unit!= "-- Choose Device --")
        {
            var unit=unit.split("(")[1];
            var unit = unit.split(")")[0];    
            var label1 = document.getElementById('STD').innerText.split("*")[0];
            var label2 = document.getElementById('Max').innerText.split("*")[0];
            var label3 = document.getElementById('Min').innerText.split("*")[0];
            var labelBintang = "*";
            var bintang = labelBintang.fontcolor("red");
            document.getElementById('STD').innerHTML = label1.split(" ")[0]+" "+label1.split(" ")[1]+" ("+unit+")"+bintang;
            document.getElementById('Max').innerHTML = label2.split(" ")[0]+" "+label2.split(" ")[1]+" ("+unit+")"+bintang;
            document.getElementById('Min').innerHTML = label3.split(" ")[0]+" "+label3.split(" ")[1]+" ("+unit+")"+bintang;
        }
        else
        {
            var label1 = document.getElementById('STD').innerText.split("*")[0];
            var label2 = document.getElementById('Max').innerText.split("*")[0];
            var label3 = document.getElementById('Min').innerText.split("*")[0];
            var labelBintang = "*";
            var bintang = labelBintang.fontcolor("red");
            document.getElementById('STD').innerHTML = label1.split(" ")[0]+" "+label1.split(" ")[1]+bintang;
            document.getElementById('Max').innerHTML = label2.split(" ")[0]+" "+label2.split(" ")[1]+bintang;
            document.getElementById('Min').innerHTML = label3.split(" ")[0]+" "+label3.split(" ")[1]+bintang;
        }
            
    }
</script>
<aside class="right-side">
    <section class="content-header">
        <ol class="breadcrumb">
            <li><a href="<?php echo base_url('index.php/basis/home_c/"') ?>"><span>Home</span></a></li>
            <li> <a href="#"><strong>View COMPONENT</strong></a></li>
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
                        <span class="grid-title"><strong>COMPONENT</strong> TABLE</span>
                        <div class="pull-right">
                            <a href="#modaladd" class="btn btn-default" data-toggle="modal" data-placement="left" title="Create Specification" style="height:30px;font-size:13px;width:100px;">Create</a>
                        </div>
                    </div>
                    <div class="grid-body">
                        <table id="dataTables1" class="table table-striped table-condensed table-hover display" cellspacing="0" width="100%">
                            <thead>
                                <tr>
                                    <th>No</th>
                                    <th>ID Part</th>
									<th>Part Name</th>
                                    <th>Back Number</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                 <?php
                                    $i = 1;
                                    foreach ($data as $isi) {
                                        echo "<tr class='gradeX'>";
                                        echo "<td>$i</td>";
                                        echo "<td>$isi->CHR_ID_PART</td>";
                                        echo "<td>$isi->CHR_NAMA_PART</td>";
                                        echo "<td>$isi->CHR_BACK_NO</td>";
                                        // echo "<td>$isi->CHR_NAMA_VENDOR</td>";   
                                    ?>
                                    <td>
                                        <a href="<?php echo base_url('index.php/patricia/specification_c/detail_spec') . "/" . $isi->CHR_ID_PART; ?>" id="detail" class="label label-info" data-placement="top" data-toggle="tooltip" title="Detail"><span class="fa fa-info"></span></a>
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
        </div><div class="modal fade" id="modaladd" tabindex="-1" role="dialog" aria-labelledby="modalprogress" aria-hidden="true" style="display: none;">
            <div class="modal-wrapper">
                <div class="modal-dialog">
                    <div class="modal-content">
                     <?php echo form_open_multipart('patricia/specification_c/save_specification_komponen/', 'class="form-horizontal"'); ?>
                        <div class="modal-header">
                            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                            <h4 class="modal-title" id="modalprogress"><strong>Add Specification</strong></h4>
                        </div>
                        <div class="modal-body">
                            <div class="form-group">
                                <label class="col-sm-4 control-label">Component <span style="color: red">*</span></label>
                                <div class="col-sm-5">
                                    <select  name="CHR_COMPONENT_ID" id="e2" class="form-control" style="width:350px;" required>
                                        <option value="">-- Choose Component --</option>
                                        <?php foreach ($list_part as $list) { ?>
                                            <option value="<?php echo trim($list->CHR_ID_PART); ?>"><?php echo $list->CHR_ID_PART." - " . trim($list->CHR_NAMA_PART); ?></option>
                                        <?php } ?> 
                                    </select>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-sm-4 control-label">Measurement Device <span style="color: red">*</span></label>
                                <div class="col-sm-5">
                                    <select  name="INT_DEVICE_ID" onchange="setLabel(this.options[this.selectedIndex].innerText);" class="form-control" style="width:350px" required="true">
                                        <option value="">-- Choose Device --</option>
                                        <?php foreach ($device as $list) { ?>
                                            <option value="<?php echo $list->INT_DEVICE_ID; ?>"><?php echo trim($list->CHR_DEVICE_DESC).' ( '.trim($list->CHR_UNIT).' )'; ?></option>
                                        <?php } ?> 
                                    </select>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-sm-4 control-label">Specification Desc <span style="color: red">*</span></label>
                                <div class="col-sm-5">
                                    <input name="CHR_SPECIFICATION" class="form-control" required type="text" required style="width:350px">
                                </div> 
                            </div>
                            <div class="form-group">
                                <label class="col-sm-4 control-label">Specification Index <span style="color: red">*</span></label>
                                <div class="col-sm-5">
                                    <input name="INT_INDEX" class="form-control" required style="width:350px" type="number" placeholder="1" step="1" min="1" max="10">
                                </div>
                            </div>
                            <div class="form-group">
                                <label id="STD" class="col-sm-4 control-label">Standard Value <span> </span> <span style="color: red">*</span></label>
                                <div class="col-sm-5">
                                    <input name="DEC_STD" class="form-control" required style="width:350px" type="number" placeholder="1.00" step="0.01" min="0" max="1000">
                                </div>
                            </div>
                            <div class="form-group">
                                <label id="Max" class="col-sm-4 control-label">Tolerance Max<span> </span><span style="color: red">*</span></label>
                                <div class="col-sm-5">
                                    <input name="DEC_TOLERANSI_MAX" class="form-control" required style="width:350px" type="number" placeholder="1.00" step="0.01" min="0" max="1000">
                                </div>
                            </div>
                            <div class="form-group">
                                <label id="Min" class="col-sm-4 control-label">Tolerance Min<span> </span><span style="color: red">*</span></label>
                                <div class="col-sm-5">
                                    <input name="DEC_TOLERANSI_MIN" class="form-control" required style="width:350px" type="number" placeholder="1.00" step="0.01" min="0" max="1000">
                                </div>
                            </div>
                            <!-- <div class="form-group">
                                <label class="col-sm-4 control-label">Unit of Measurement<span> </span><span style="color: red">*</span></label>
                                <div class="col-sm-5">
                                    <input name="CHR_UNIT" class="form-control" required style="width:350px" type="text" placeholder="MM / CM / N" onkeypress="return hanyaHuruf(event)" maxlength="10">
                                </div>
                            </div> -->
                            <div class="form-group">
                                <label class="col-sm-4 control-label">Image<span> </span><span style="color: red">*</span></label>
                                <div class="col-sm-5" style="width:382px">
                                    <input name="uploadFoto" id="uploadImage"  type="file" accept="image/*" required>
                                </div>
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
    </section>
</aside>
<script type="text/javascript" language="javascript">
    $("#uploadImage").fileinput({
        'showUpload': false
    });
    $("#uploadImageEdit").fileinput({
        'showUpload': false
    });

</script>