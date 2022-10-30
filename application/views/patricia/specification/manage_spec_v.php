<script>
    $(document).ready(function() {
        
        var interval_close = setInterval(closeSideBar, 250);
        function closeSideBar() {
            $("#hide-sub-menus").click();
            clearInterval(interval_close);
        }
        
        
    });
</script>
<script>
    function hanyaAngka(evt) {
      var charCode = (evt.which) ? evt.which : event.keyCode
       if (charCode > 31 && (charCode < 48 || charCode > 57 && charCode != 8))
        {
            return false;
        }
        else
        {
            return true;    
        }
      
    }
    function hanyaHuruf(evt) {
      var charCode = (evt.which) ? evt.which : event.keyCode
       if ((charCode > 95 && charCode < 123)||(charCode > 64 && charCode < 91)||charCode==32 || charCode==8)
        {
            return true;
        }
        else
        {
            return false;   
        }
      
    }
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
    function setLabelUbah(unit) {
        if(unit!= "-- Choose Device --")
        {
            var unit=unit.split("(")[1];
            var unit = unit.split(")")[0];    
            var label1 = document.getElementById('STD_UBAH').innerText.split("*")[0];
            var label2 = document.getElementById('MAX_UBAH').innerText.split("*")[0];
            var label3 = document.getElementById('MIN_UBAH').innerText.split("*")[0];
            var labelBintang = "*";
            var bintang = labelBintang.fontcolor("red");
            document.getElementById('STD_UBAH').innerHTML = label1.split(" ")[0]+" "+label1.split(" ")[1]+" ("+unit+")"+bintang;
            document.getElementById('MAX_UBAH').innerHTML = label2.split(" ")[0]+" "+label2.split(" ")[1]+" ("+unit+")"+bintang;
            document.getElementById('MIN_UBAH').innerHTML = label3.split(" ")[0]+" "+label3.split(" ")[1]+" ("+unit+")"+bintang;
        }
        else
        {
            var label1 = document.getElementById('STD_UBAH').innerText.split("*")[0];
            var label2 = document.getElementById('MAX_UBAH').innerText.split("*")[0];
            var label3 = document.getElementById('MIN_UBAH').innerText.split("*")[0];
            var labelBintang = "*";
            var bintang = labelBintang.fontcolor("red");
            document.getElementById('STD_UBAH').innerHTML = label1.split(" ")[0]+" "+label1.split(" ")[1]+bintang;
            document.getElementById('MAX_UBAH').innerHTML = label2.split(" ")[0]+" "+label2.split(" ")[1]+bintang;
            document.getElementById('MIN_UBAH').innerHTML = label3.split(" ")[0]+" "+label3.split(" ")[1]+bintang;
        }
            
    }
    
</script>
<aside class="right-side">
    <section class="content-header">
        <ol class="breadcrumb">
            <li><a href="<?php echo base_url('index.php/basis/home_c/"') ?>"><span>Home</span></a></li>
            <li> <a href="#"><strong>Manage Specification</strong></a></li>
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
                        <span class="grid-title"><strong>SPECIFICATION</strong> TABLE</span>
                        <div class="pull-right">
                            <a href="<?php echo base_url('index.php/patricia/specification_c/') ?>" class="btn btn-primary" data-toggle="modal" data-placement="left" title="Create Specification" style="height:30px;font-size:13px;width:130px;">View Component</a>&nbsp;&nbsp;
                            <a href="#modaladd" class="btn btn-default" data-toggle="modal" data-placement="left" title="Create Specification" style="height:30px;font-size:13px;width:80px;">Create</a>
                        </div>
                    </div>
                    <div class="grid-body">
                        <table id="dataTables1" class="table table-striped table-condensed table-hover display" cellspacing="0" width="100%">
                            <thead>
                                <tr>
                                    <th width="3%">No</th>
                                    <th width="5%">Spec Code</th>
                                    <th width="10%">Specification</th>
                                    <th width="5%">Part</th>
                                    <th width="3%" >Index</th>
                                    <th width="10%">Tools</th>
                                    <th width="3%">Standard</th>
                                    <th width="10%">Tolarance Max</th>
                                    <th width="10%">Tolarance Min</th>
                                    <!-- <th width="10%">Unit</th> -->
                                    <th width="10%">Image</th>
                                    <th width="10%">Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                 <?php
                                    $i = 1;
                                    foreach ($data as $isi) {
                                        echo "<tr class='gradeX'>";
                                        echo "<td style='text-align:center;'>$i</td>";
                                        echo "<td>$isi->CHR_SPEC_CODE</td>";
                                        echo "<td>$isi->CHR_SPECIFICATION </td>";
                                        echo "<td>$isi->CHR_ID_PART - $isi->CHR_NAMA_PART</td>";
                                        echo "<td style='text-align:center;'>$isi->INT_INDEX</td>";
                                        echo "<td style='text-align:center;'>$isi->CHR_DEVICE_DESC</td>";
                                        echo "<td style='text-align:right;'>$isi->DEC_STD</td>";
                                        echo "<td style='text-align:right;'>$isi->DEC_TOLERANSI_MAX</td>";
                                        echo "<td style='text-align:right;'>$isi->DEC_TOLERANSI_MIN</td>";
                                        // echo "<td style='text-align:center;'>$isi->CHR_UNIT</td>";
                                        if($isi->CHR_IMAGE=='')
                                        {
                                            echo "<td>No Image</td>";
                                        }
                                        else
                                        {
                                            echo "<td><img alt='No Image' src=\"".DOCIMG."/image/patricia/SPEC/".$isi->CHR_IMAGE."\"  width=\"90px\" ></td>";    
                                        }
                                        
                                    ?>
                                    <td style="width: 71px">
                                        <a type="button" data-toggle="modal" data-target="#modaledit" data-placement="left" data-toggle="tooltip" data-alat="<?php echo $isi->INT_DEVICE_ID; ?>" data-component="<?php echo $idcomponent; ?>" data-spek="<?php echo $isi->CHR_SPECIFICATION; ?>" data-std="<?php echo $isi->DEC_STD; ?>" data-tolmax="<?php echo $isi->DEC_TOLERANSI_MAX; ?>" data-tolmin="<?php echo $isi->DEC_TOLERANSI_MIN; ?>" data-index="<?php echo $isi->INT_INDEX; ?>" data-id="<?php echo $isi->INT_SPECIFICATION_ID; ?>" data-gambar="<?php echo $isi->CHR_IMAGE; ?>" 
                                            title="Edit Specification" class="label label-warning"><span class="fa fa-pencil"></span></a>
                                            <!-- data-unit="<?php echo $isi->CHR_UNIT; ?>" -->
                                        <a href="<?php echo base_url('index.php/patricia/specification_c/delete') . "/" . $isi->INT_SPECIFICATION_ID . "/" .$idcomponent; ?>" class="label label-danger" data-placement="top" data-toggle="tooltip" title="Delete" onclick="return confirm('Are you sure want to delete this specification?');"><span class="fa fa-times"></span></a>
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
        <div class="modal fade" id="modaladd" tabindex="-1" role="dialog" aria-labelledby="modalprogress" aria-hidden="true" style="display: none;">
            <div class="modal-wrapper">
                <div class="modal-dialog">
                    <div class="modal-content">
                     <?php echo form_open_multipart('patricia/specification_c/save_specification', 'class="form-horizontal"'); ?>
                        <div class="modal-header">
                            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">x</button>
                            <h4 class="modal-title" id="modalprogress"><strong>Add Specification</strong></h4>
                        </div>
                        <div class="modal-body">
                            <div class="form-group">
                                <label class="col-sm-4 control-label">Component <span style="color: red">*</span></label>
                                <div class="col-sm-5">
                                    <input name="CHR_COMPONENT_ID" style="width:350px;" class="form-control" readonly="true" type="text" value="<?php echo $idcomponent; ?>" required >
                                    
                                    <!-- <select  name="CHR_COMPONENT_ID" id="e1" class="form-control" style="width:350px" required="">
                                        <option value="">-- Choose Component --</option>
                                        <?php foreach ($list_part as $list) { ?>
                                            <option value="<?php echo $list->CHR_ID_PART; ?>"><?php echo trim($list->CHR_ID_PART) . " - " . trim($list->CHR_NAMA_PART); ?></option>
                                        <?php } ?> 
                                    </select> -->
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-sm-4 control-label">Measurement Device <span style="color: red">*</span></label>
                                <div class="col-sm-5">
                                    <select  name="INT_DEVICE_ID"  class="form-control" style="width:350px" onchange="setLabel(this.options[this.selectedIndex].innerText);" required="true" >
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
                                    <input name="INT_INDEX" class="form-control" required style="width:350px" type="number" placeholder="1" step="1" min="0" max="10">
                                </div>
                            </div>
                            <div class="form-group">
                                <label id="STD" class="col-sm-4 control-label">Standard Value<span> </span> <span style="color: red">*</span></label>
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
                                    <input name="CHR_UNIT" class="form-control" required style="width:350px" type="text" placeholder="mm / cm / N" onkeypress="return hanyaHuruf(event)" maxlength="10">
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
        <div class="modal fade" id="modaledit" tabindex="-1" role="dialog" aria-labelledby="modaledit" aria-hidden="true" style="display: none;">
                    <div class="modal-wrapper">
                        <div class="modal-dialog">
                            <div class="modal-content">
                                <?php echo form_open_multipart('patricia/specification_c/update', 'class="form-horizontal"'); ?>
                                    <div class="modal-header">
                                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">x</button>
                                        <h4 class="modal-title" id="modalprogress"><strong>Edit Specification</strong></h4>
                                    </div>
                                    <div class="modal-body">
                                        <div class="form-group">
                                            <label class="col-sm-4 control-label">Component <span style="color: red">*</span></label>
                                            <div class="col-sm-5">
                                                <input name="CHR_COMPONENT_ID" style="width:350px" value="<?php echo $idcomponent; ?>" readonly="true" class="form-control" required type="text" required>
                                                <input name="INT_SPECIFICATION_ID" style="width:350px" id="INT_SPECIFICATION_ID" class="form-control" required type="hidden" required style="width:350px">
                                                <input name="CHR_IMAGE" id="CHR_IMAGE" class="form-control" required type="hidden" required style="width:350px">
                                                <!-- <select  name="CHR_COMPONENT_ID" id="e1" class="form-control" style="width:350px" required="">
                                                    <option value="">-- Choose Component --</option>
                                                    <?php foreach ($list_part as $list) { ?>
                                                        <option value="<?php echo $list->CHR_ID_PART; ?>"><?php echo trim($list->CHR_ID_PART) . " - " . trim($list->CHR_NAMA_PART); ?></option>
                                                    <?php } ?> 
                                                </select> -->
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label class="col-sm-4 control-label">Measurement Device <span style="color: red">*</span></label>
                                            <div class="col-sm-5">
                                                <select  name="INT_DEVICE_ID" id="INT_DEVICE_ID" onchange="setLabelUbah(this.options[this.selectedIndex].innerText);" class="form-control" style="width:350px">
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
                                                <input name="CHR_SPECIFICATION" id="CHR_SPECIFICATION" class="form-control" required type="text" required style="width:350px">
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label class="col-sm-4 control-label">Specification Index <span style="color: red">*</span></label>
                                            <div class="col-sm-5">
                                                <input name="INT_INDEX" id="INT_INDEX" class="form-control" required style="width:350px" type="number" placeholder="1" step="1" min="0" max="10">
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label id="STD_UBAH" class="col-sm-4 control-label">Standard Value <span style="color: red">*</span></label>
                                            <div class="col-sm-5">
                                                <input name="DEC_STD" id="DEC_STD" class="form-control" required style="width:350px" type="number" placeholder="1.00" step="0.01" min="0" max="1000">
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label id="MAX_UBAH" class="col-sm-4 control-label">Tolerance Max<span style="color: red">*</span></label>
                                            <div class="col-sm-5">
                                                <input name="DEC_TOLERANSI_MAX" id="DEC_TOLERANSI_MAX" class="form-control" required style="width:350px" type="number" placeholder="1.00" step="0.01" min="0" max="1000">
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label id="MIN_UBAH" class="col-sm-4 control-label">Tolerance Min<span style="color: red">*</span></label>
                                            <div class="col-sm-5">
                                                <input name="DEC_TOLERANSI_MIN" id="DEC_TOLERANSI_MIN" class="form-control" required style="width:350px" type="number" placeholder="1.00" step="0.01" min="0" max="1000">
                                            </div>
                                        </div>
                                        <!-- <div class="form-group">
                                            <label class="col-sm-4 control-label">Unit of Measurement<span> </span><span style="color: red">*</span></label>
                                            <div class="col-sm-5">
                                                <input id="CHR_UNIT" name="CHR_UNIT" class="form-control" required style="width:350px" type="text" placeholder="mm / cm / N" onkeypress="return hanyaHuruf(event)" maxlength="10">
                                            </div>
                                        </div> -->
                                        <div class="form-group">
                                            <label class="col-sm-4 control-label">Specification Photo</label>
                                            <div class="col-sm-5">
                                                <img id="uploadPreview1" class="form-control" style="width: 150px; height: 150px; border: 5px solid #a1a1a1;">
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label class="col-sm-4 control-label"></label>
                                            <div class="col-sm-5" style="width:382px">
                                                <input name="uploadFotoEdit" id="uploadImageEdit" onchange="PreviewImage(1);" accept="image/*" type="file">
                                            </div>
                                        </div>
                                        <!-- <div class="form-group">
                                            <label class="col-sm-4 control-label">Standard Minimal <span>(mm)</span></label>
                                            <div class="col-sm-5">
                                                <input name="DEC_STD_MIN" id="DEC_STD_MIN" class="form-control" required style="width:350px" type="number" placeholder="1.0" step="0.01" min="0" max="1000">
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label class="col-sm-4 control-label">Standard Maximal <span>(mm)</span></label>
                                            <div class="col-sm-5">
                                                <input name="DEC_STD_MAX" id="DEC_STD_MAX" class="form-control" required style="width:350px" type="number" placeholder="1.0" step="0.01" min="0" max="1000">
                                                
                                            </div>
                                        </div> -->
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
    </section>
</aside>
<script type="text/javascript">
    $('#modaledit').on('show.bs.modal', function (event) {
        var button = $(event.relatedTarget);
        var alat = button.data('alat');
        var spek = button.data('spek');
        var std = button.data('std');
        var tolmax = button.data('tolmax');
        var tolmin = button.data('tolmin');
        var index = button.data('index');
        var id = button.data('id');
        var gambar = button.data('gambar');
        // var unit = button.data('unit');
        var modal = $(this);
        
        modal.find('.modal-body #INT_DEVICE_ID').val(alat);
        modal.find('.modal-body #CHR_SPECIFICATION').val(spek);
        modal.find('.modal-body #DEC_STD').val(std);
        modal.find('.modal-body #DEC_TOLERANSI_MAX').val(tolmax);
        modal.find('.modal-body #DEC_TOLERANSI_MIN').val(tolmin);
        modal.find('.modal-body #INT_INDEX').val(index);
        modal.find('.modal-body #INT_SPECIFICATION_ID').val(id);
        modal.find('.modal-body #CHR_IMAGE').val(gambar);
        // modal.find('.modal-body #CHR_UNIT').val(unit);
        modal.find('.modal-body #uploadPreview1').attr('src', '<?php echo DOCIMG."/image/patricia/SPEC/".''; ?>'+gambar);


    })
</script>
<script type="text/javascript" language="javascript">
    $("#uploadImage").fileinput({
        'showUpload': false
    });
    $("#uploadImageEdit").fileinput({
        'showUpload': false
    });

</script>


