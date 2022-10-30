<script type="text/javascript">
    $(document).ready(function() {
        $("#btn_create").click(function() {
            $.ajax({
                url: "<?php echo base_url(); ?>index.php/mte/master_preventive_c/show_create_manual",
                data: {id_type: + '<?php echo $group_line; ?>'}, type: "POST",
                success: function(data) {
                    $("#2nd_panel").html(data);
                }
            });
        });
    });

    $(document).ready(function () {
        var interval_close = setInterval(closeSideBar, 250);
        function closeSideBar() { 
            $("#hide-sub-menus").click();
            clearInterval(interval_close);
        }
    });
</script>
<aside class="right-side">
    <!-- BEGIN CONTENT HEADER -->
    <section class="content-header">
        <ol class="breadcrumb">
            <li><a href="<?php echo base_url('index.php/mte/home_c') ?>"><span>Home</span></a></li>
            <li class="active"> <a href="<?php echo base_url('index.php/mte/master_preventive_c/manage_manual') ?>"><strong>Manage Manual</strong></a></li>
        </ol>
    </section>
    <!-- END CONTENT HEADER -->
    <!-- BEGIN MAIN CONTENT -->
    <section class="content">
        <?php
        if ($msg != NULL) {
            echo $msg;
        }
        ?>
        <!-- BEGIN BASIC DATATABLES -->

        <div class="row">
            <div class="col-md-8">
                <div class="grid">
                    <div class="grid-header">
                        <i class="fa fa-th-large"></i>
                        <span class="grid-title"><strong>MANAGE MANUAL - <?php echo $group_type; ?></strong></span>
                        <div class="pull-right">
                            <button id="btn_create" class="btn btn-default" data-placement="left" data-toggle="tooltip" title="Add Manual (WI & FT)" style="height:30px;font-size:13px;width:100px;">Add New</button>
                        </div>
                    </div>
                    <div class="grid-body">
                        <div class="pull">
                            <table width="15%" id='filter'>
                                <tr>
                                    <td>Filter</td>
                                    <td>&nbsp;</td>
                                    <td style="vertical-align:middle">
                                        <select onChange="document.location.href = this.options[this.selectedIndex].value;" class="ddl2">
                                            <?php foreach ($all_group_line as $row) { ?>
                                                <option value="<?php echo site_url('mte/master_preventive_c/manage_manual/0/' . $row->ID . '/' . $manual_type); ?>" <?php
                                                if ($group_line == $row->ID) {
                                                    echo 'SELECTED';
                                                }
                                                ?> ><?php echo trim($row->CHR_GROUP_LINE); ?></option>
                                                    <?php } ?>
                                        </select>
                                    </td>    
                                </tr>
                                <tr>
                                    <td>Type</td>
                                    <td>&nbsp;</td>
                                    <td style="vertical-align:middle">
                                        <select onChange="document.location.href = this.options[this.selectedIndex].value;" class="ddl2">
                                            <option value="<?php echo site_url('mte/master_preventive_c/manage_manual/0/' . $group_line . '/WIS'); ?>" <?php if($manual_type == 'WIS') { echo 'SELECTED'; } ?>>WIS</option>
                                            <option value="<?php echo site_url('mte/master_preventive_c/manage_manual/0/' . $group_line . '/FTA'); ?>" <?php if($manual_type == 'FTA') { echo 'SELECTED'; } ?>>FTA</option>
                                        </select>
                                    </td>    
                                </tr>                            
                            </table>
                        </div>
                        <br>
                        <table id="dataTables1" class="table table-condensed table-striped table-hover display" cellspacing="0" width="100%">
                            <thead>
                                <tr>
                                    <th>No</th>
                                    <th>Manual Code</th>
                                    <th>Manual Name</th>
                                    <th>Manual Type</th>
                                    <th>Tool Code</th>
                                    <th>Last Update</th>
                                    <!-- <th>Update By</th> -->
                                    <th>Status</th>
                                    <th>Actions</th>

                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                $i = 1;
                                foreach ($data as $isi) {
                                    echo "<tr class='gradeX'>";
                                    echo "<td>$i</td>";
                                    echo "<td>" . $isi->CHR_WI_CODE . "</td>";
                                    echo "<td>$isi->CHR_WI_NAME</td>";
                                    echo "<td>$isi->CHR_WI_TYPE</td>";
                                    if($isi->INT_ID_PART == NULL || $isi->INT_ID_PART == ''){
                                        echo "<td>-</td>";
                                    } else {
                                        $id_part = $isi->INT_ID_PART;
                                        $get_part = $this->db->query("SELECT * FROM TM_PARTS_MTE WHERE INT_ID = '$id_part'");
                                        if($get_part->num_rows() > 0){
                                            $part = $get_part->row();
                                            echo "<td>$part->CHR_PART_CODE</td>";
                                        } else {
                                            echo "<td>N/A/td>";
                                        }                                        
                                    }

                                    if($isi->CHR_MODIFIED_DATE == NULL || $isi->CHR_MODIFIED_DATE == ''){
                                        echo "<td>$isi->CHR_CREATED_DATE</td>";
                                        // echo "<td>$isi->CHR_CREATED_BY</td>";
                                    } else {
                                        echo "<td>$isi->CHR_MODIFIED_DATE</td>";
                                        // echo "<td>$isi->CHR_MODIFIED_BY</td>";
                                    }
                                    
                                    if($isi->INT_FLG_DEL == 1){
                                        echo "<td>Disabled</td>";
                                    } else {
                                        echo "<td>Active</td>";
                                    }
                                    
                                    ?>
                                <td>
                                    <a href="<?php echo base_url('index.php/mte/master_preventive_c/edit_manual') . "/" . $isi->INT_ID ?>" class="label label-warning"><span class="fa fa-pencil"></span></a>
                                    <a data-target="#modalView<?php echo $isi->INT_ID; ?>" data-toggle="modal" class="label label-info"><span class="fa fa-eye"></span></a>
                                    <?php if($isi->INT_FLG_DEL == 0){ ?>
                                        <a href="<?php echo base_url('index.php/mte/master_preventive_c/disable_manual') . "/" . $isi->INT_ID . "/" . $group_line . "/" . $manual_type ?>" class="label label-danger"><span class="fa fa-times"></span></a>
                                    <?php } else { ?>
                                        <a href="<?php echo base_url('index.php/mte/master_preventive_c/enable_manual') . "/" . $isi->INT_ID . "/" . $group_line . "/" . $manual_type ?>" class="label label-default"><span class="fa fa-times"></span></a>
                                    <?php } ?>
                                    <!-- <a href="<?php echo base_url('index.php/mte/master_preventive_c/delete_manual') . "/" . $isi->INT_ID ?>" class="label label-danger" onclick="return confirm('Are you sure want to delete this checksheet?');"><span class="fa fa-times"></span></a> -->
                                </td>
                                </tr>
                                <?php
                                $i++;
                            }
                            ?>
                            </tbody>
                        </table>
                    </div>
                    <!-- START MODAL 2 -->  
                    <?php foreach ($data as $wi) { ?>                      
                    <div class="modal fade" id="modalView<?php echo $wi->INT_ID; ?>" tabindex="-1" role="dialog" aria-labelledby="modalprogress" aria-hidden="true" style="display: none;">
                        <div class="modal-wrapper">
                            <div class="modal-dialog">                                    
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                                        <h4 class="modal-title" id="modalprogress"><strong>View Manual (<?php echo $manual_type; ?>)</strong></h4>
                                    </div>
                                    <div class="modal-body">
                                        <div>
                                            <label><?php echo $wi->CHR_WI_NAME; ?></label>
                                        </div>
                                        <div>
                                            <img src="http://192.168.0.231/scan_preventive_v3/assets/images/wi/<?php echo $wi->CHR_FILE_WI; ?>">
                                        </div>                                          
                                    </div>
                                    <div class="modal-footer">
                                        <div class="btn-group">
                                            <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                                        </div>                                            
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <?php } ?>
                    <!-- END MODAL 2 -->
                </div>
            </div>
            <div id="2nd_panel" class="col-md-4">
                <?php
                if ($subcontent != NULL) {
                    $this->load->view($subcontent);
                }
                ?>
            </div>    <!-- END BASIC DATATABLES -->
        </div>

    </section>
    <!-- END MAIN CONTENT -->
</aside>