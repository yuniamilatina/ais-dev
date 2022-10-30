<script>
    $(document).ready(function () {
        var interval_close = setInterval(closeSideBar, 250);
        function closeSideBar() { 
            $("#hide-sub-menus").click();
            clearInterval(interval_close);
        }
    });

    $(document).ready(function() {
        //var type = <?php echo $group_line; ?>;
        $("#btn_create").click(function() {
            $.ajax({
                url: "<?php echo base_url(); ?>index.php/mte/preventive_schedule_c/show_create/<?php echo $group_line; ?>",
                data: {INT_ID_DEPT: $(this).val()}, type: "POST",
                success: function(data) {
                    $("#2nd_panel").html(data);
                }
            });
        });
    });

    $(document).ready(function () {
        <?php 
            foreach ($data as $contain) { ?>
                $('#row_activity_<?php echo $contain->INT_ID ?>').click(function () {
                    var int_id = <?php echo trim($contain->INT_ID); ?>;
                    $.ajax({
                        async: false,
                        type: "POST",
                        url: "<?php echo site_url('mte/preventive_schedule_c/show_edit'); ?>",
                        data: "id=" + int_id,
                        success: function (data) {
                            $("#2nd_panel").html(data);
                        }
                    });
                });
            <?php } ?>
    });
</script>
<aside class="right-side">
    <section class="content-header">
        <ol class="breadcrumb">
            <li><a href="<?php echo base_url('index.php/basis/home_c/') ?>">Home</a></li>
            <li><a href="#"><span><strong>Manage Project PIC</strong></span></a></li>
        </ol>
    </section>
    <section class="content">
        <?php
        if ($msg != NULL) {
            echo $msg;
        }
        ?>
        <div class="row">            
            <div class="col-md-7">
                <div class="grid">
                    <div class="grid-header">
                        <i class="fa fa-th-large"></i>
                        <span class="grid-title"><strong>LIST PARTS PREVENTIVE - <?php echo $group_type; ?></strong></span>
                        <div class="pull-right grid-tools">
                            <!-- <a href="<?php echo base_url('index.php/mte/preventive_schedule_c/generate_template'); ?>" data-toggle="tooltip" data-placement="right" title="Download template"><i class="fa fa-download"></i>&nbsp; Download template</a> -->
                            <!-- <a href="<?php echo base_url('index.php/mte/preventive_schedule_c/go_to_upload_wo/') ?>" class="btn btn-primary" data-toggle="tooltip" data-placement="left" title="Upload WO" style="height:30px;font-size:12px;width:120px;color:white"><i class="fa fa-upload"></i>&nbsp;&nbsp;UPLOAD WO</a> -->
                            <button id="btn_create" class="btn btn-default" data-placement="left" data-toggle="tooltip" title="Add Part" style="height:30px;font-size:13px;width:100px;">Add Part</button>
                        </div>
                    </div>                    
                    <div class="grid-body">
                        <div class="pull">
                            <table width="15%" id='filter'>
                                <tr>
                                    <td>Filter</td>
                                    <td>&nbsp;</td>
                                    <td style="vertical-align:top">
                                        <select onChange="document.location.href = this.options[this.selectedIndex].value;" class="ddl2">
                                            <?php foreach ($all_group_line as $row) { ?>
                                                <option value="<?php echo site_url('mte/preventive_schedule_c/index/0/' . $row->ID); ?>" <?php
                                                if ($group_line == $row->ID) {
                                                    echo 'SELECTED';
                                                }
                                                ?> ><?php echo trim($row->CHR_GROUP_LINE); ?></option>
                                                    <?php } ?>
                                        </select>
                                    </td>    
                                </tr>                            
                            </table>
                        </div>
                        <br>
                        <table id="dataTables1" class="table table-striped table-condensed table-hover display" cellspacing="0" width="100%">
                            <thead>
                                <tr align="center">
                                    <th>No</th>                                   
                                    <th>Tooling Code</th>
                                    <th>Tooling Name</th>
                                    <th>Model</th>
                                    <?php if($group_line == 4 || $group_line == 7 || $group_line == 8){ ?>
                                        <th>Freq Prev</th>
                                    <?php } else { ?>
                                        <th>Std Stroke</th>
                                    <?php } ?>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody align="center">
                                <?php
                                $i = 1;
                                foreach ($data as $isi) { 
                                    echo "<tr>";
                                    echo "<td>" . $i . "</td>";
                                    echo "<td>$isi->CHR_PART_CODE</td>";
                                    echo "<td style='text-align:left;'>" . substr($isi->CHR_PART_NAME,0,13) . "</td>";
                                    echo "<td>$isi->CHR_MODEL</td>";
                                    if($group_line == 4 || $group_line == 7 || $group_line == 8){
                                        echo "<td>" . $isi->FLG_TYPE_PREV . " Months</td>";
                                    } else {
                                        echo "<td>$isi->INT_STROKE_SMALL_PREVENTIVE</td>";
                                    }
                                    
                                    ?>
                                    <td>
                                        <a href="<?php echo base_url('index.php/mte/preventive_schedule_c/add_detail') . "/" . $group_line . "/" . $isi->CHR_PART_CODE; ?>" class="label label-success" data-placement="right" data-toggle="tooltip" title="Add Detail"><span class="fa fa-list"></span></a>
                                        <a href="#" id="row_activity_<?php echo $isi->INT_ID;?>" class="label label-warning" data-placement="right" data-toggle="tooltip" title="Edit Part"><span class="fa fa-pencil"></span></a>
                                        <a href="<?php echo base_url('index.php/mte/preventive_schedule_c/delete') . "/" . $isi->CHR_PART_CODE; ?>" class="label label-danger" data-placement="right" data-toggle="tooltip" title="Delete" onclick="return confirm('Are you sure want to delete this Part?');"><span class="fa fa-times"></span></a>
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
            <div id="2nd_panel" class="col-md-5">
                <?php
                if ($subcontent != NULL) {
                    $this->load->view($subcontent);
                }
                ?>
            </div> 
        </div>        
    </section>
</aside>