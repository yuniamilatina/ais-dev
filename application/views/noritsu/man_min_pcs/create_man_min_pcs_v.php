<aside class="right-side">
    <section class="content-header">
        <ol class="breadcrumb">
            <li><a href="<?php echo base_url('index.php/basis/home_c/') ?>">Home</a></li>
            <li><a href="<?php echo base_url('index.php/noritsu/man_min_pcs_c/') ?>">Manage Man Minute / Pcs</a></li>
            <li><a href="#"><strong>Create Man Minute / Pcs</strong></a></li>
        </ol>
    </section>

    <section class="content">
        <?php
        if (validation_errors()) {
            echo '<div class = "alert alert-danger"><strong>WARNING !</strong>' . validation_errors() . '</div >';
        }
        
        ?>
        <div class="row">
            <div class="col-md-12">
                <div class="grid">
                    <div class="grid-header">
                        <i class="fa fa-sitemap"></i>
                        <span class="grid-title"><strong>CREATE MAN MINUTE / PCS</strong> </span>
                        <div class="pull-right grid-tools">
                            <a data-widget="collapse" title="Collapse"><i class="fa fa-chevron-up"></i></a>
                        </div>
                    </div>
                    
                    <?php
                    $attributes = array('id' => 'form_mold');
                    echo form_open_multipart('noritsu/man_min_pcs_c/get_template', 'class="form-horizontal"', $attributes);
                    ?>
                    <div class="grid-body">
                        <div class="col-md-6">
                            <table border="0" width="100%">
                                <tr height="50px">
                                    <td><label class="control-label">Department</label></td>
                                    <td>
                                        <select id="CHR_DEPT" name="CHR_DEPT" class="form-control" required>
                                            <option value="0" selected disabled>--Select Department--</option>
                                        <?php
                                            foreach ($dept as $key) {
                                            ?>
                                            <option value="<?php echo $key->CHR_DEPT; ?>"><?php echo $key->CHR_DEPT_DESC; ?></option>
                                            <?php
                                            }
                                        ?>
                                        </select>
                                    </td>
                                </tr>
                                <tr height="50px">
                                    <td><label class="control-label">Work Center</label></td>
                                    <td>
                                        <select id="e2" name="CHR_WORK_CENTER" class="form-control" required>
                                        
                                        </select>
                                    </td>
                                </tr>
                                <tr height="50px">
                                    <td><label class="control-label">Template</label></td>
                                    <td>
                                        <button type="submit" class="btn btn-default"><i class="fa fa-download"></i> Download</button>
                                    </td>
                                </tr>
                            </table>
                        </div>
                        <?php
                        echo form_close();
                        ?>
                    
                    <?php 
                    $attributes = array('id' => 'form_2');
                    echo form_open_multipart('noritsu/man_min_pcs_c/upload_man_min_pcs', 'class="form-horizontal"', $attributes);
                    ?>
                        <div class="col-md-6">
                            <table border="0" width="100%">
                                <tr height="50px">
                                    <td><label class="control-label">Upload</label></td>
                                    <td><input name="upload_man_min" id="upload" type="file" required></td>
                                </tr>
                                <tr height="50px">
                                    <td></td>
                                    <td><button type="submit" class="btn btn-primary"><i class="fa fa-refresh"></i> Process Data</button></td>
                                </tr>
                            </table>
                        </div>
                        <?php
                        echo form_close();
                        ?>
                        <?php
                        $attributes = array('id' => 'form_man_min');
                        echo form_open_multipart('noritsu/man_min_pcs_c/save_man_min_pcs', 'class="form-horizontal"', $attributes);
                        ?>
                        <br>
                        <br>
                        <br><br><br><br><br>
                        <table id="dataTables1" class="table table-striped table-condensed table-hover display" cellspacing="0" width="100%">
                            <thead>
                                <tr>
                                    <th>No</th>
                                    <th>Work Center</th>
                                    <th>Part No</th>
                                    <th>Back No</th>
                                    <th>Part Name</th>
                                    <th>Man Min/Pcs</th>
                                    <th>Error Message</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                $i = 1;
                            if ($man_min != NULL) {
                                foreach ($man_min as $isi) {
                                    echo "<tr class='gradeX'>";
                                    echo "<td>$i</td>";
                                    echo "<td>".$isi['CHR_WORK_CENTER']."</td>";
                                    echo "<td>".$isi['CHR_PART_NO']."</td>";
                                    echo "<td>".$isi['CHR_BACK_NO']."</td>";
                                    echo "<td>".$isi['CHR_PART_NAME']."</td>";
                                    echo "<td><input type=\"hidden\" name=\"manmin[]\" value=\"".$isi['CHR_MAN_MIN_PCS']."\">".$isi['CHR_MAN_MIN_PCS']."</td>";
                                    // if($isi['CHR_ERROR'] != ""){ 
                                    //     echo "<td bgcolor=\"RED\">".$isi['CHR_ERROR']."</td>";
                                    // } else {
                                    //     echo "<td>".$isi['CHR_ERROR']."</td>";
                                    // }
                                    if($isi['CHR_ERROR'] != "0"){ 
                                    ?>
                                    <td style="white-space:pre-wrap ; word-wrap:break-word;vertical-align: middle;text-align:center;background: #ec2222; color: white;"><?php echo $isi['CHR_ERROR']; ?></td>
                                    <?php  
                                    } else {
                                    ?>
                                        <td style="white-space:pre-wrap ; word-wrap:break-word;vertical-align: middle;text-align:center;background: #F4F4F4"></td>
                                    <?php
                                    }
                                    ?>
                                </tr>
                                <?php
                                $i++;
                                }
                            }
                            ?>
                            </tbody>
                        </table>
                        <?php 
                        if ($man_min != NULL) {
                            foreach ($man_min as $value) {
                        ?>
                                <input type="hidden" name="list[]" value="<?php echo $value['CHR_PART_NO'].":".$value['CHR_MAN_MIN_PCS'].":".$value['CHR_ERROR'] ?>">
                        <?php
                            }
                        }
                        ?>
                        <button type="submit" class="btn btn-primary"><i class="fa fa-check"></i> Save</button>
                        <?php
                        echo form_close();
                        ?>

                    </div>  
                    </div>
                </div>
            </div>
        </div>
        <script type="text/javascript" language="javascript">
            $("#upload").fileinput({
                'showUpload': false
            });
        </script>
        <script>
            $(document).ready(function () {
                $("#CHR_DEPT").change(function () {
                    var val = $(this).val();
                    if (val == "PR1") {
                        $("#e2").html("<?php foreach($wc as $key){ if($key->Prd == "1"){?><option value='<?php echo $key->CHR_WORK_CENTER ?>'><?php echo $key->CHR_WORK_CENTER ?></option><?php } } ?>");
                    } else if (val == "PR2") {
                        $("#e2").html("<?php foreach($wc as $key){ if($key->Prd == "2"){?><option value='<?php echo $key->CHR_WORK_CENTER ?>'><?php echo $key->CHR_WORK_CENTER ?></option><?php } } ?>");
                    } else if (val == "PR3") {
                        $("#e2").html("<?php foreach($wc as $key){ if($key->Prd == "3"){?><option value='<?php echo $key->CHR_WORK_CENTER ?>'><?php echo $key->CHR_WORK_CENTER ?></option><?php } } ?>");
                    } else if (val == "PR4") {
                        $("#e2").html("<?php foreach($wc as $key){ if($key->Prd == "4"){?><option value='<?php echo $key->CHR_WORK_CENTER ?>'><?php echo $key->CHR_WORK_CENTER ?></option><?php } } ?>");
                    } 
                });
            });
        </script>
    </section>
</aside>