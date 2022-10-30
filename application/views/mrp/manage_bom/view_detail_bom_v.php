<?php header("Content-type: text/html; charset=iso-8859-1"); ?>
<style>
    #filter { 
        border-spacing: 5px;
        border-collapse: separate;
    }
 
</style>
<aside class="right-side">
    <section class="content-header">
        <ol class="breadcrumb">
            <li><a href="<?php echo base_url('index.php/basis/home_c') ?>"><span>Home</span></a></li>
            <li><a href="#"><strong>View BOM Structure</strong></a></li>
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
                        <i class="fa fa-folder-open"></i>
                        <span class="grid-title"><strong>HEADER</strong></span>
                        <div class="pull-right grid-tools">
                            <a data-widget="collapse" title="Collapse"><i class="fa fa-chevron-up"></i></a>                            
                        </div>
                    </div>
                    <div class="grid-body">
                        <table id="dataTable" class="table table-striped table-condensed table-hover display" cellspacing="0" width="100%">
                            <thead>
                                <tr>
                                    <td align="center"><strong>Part No</strong></td>
                                    <td align="center"><strong>Part Name</strong></td>                                    
                                    <td align="center"><strong>Back No</strong></td>
                                    <td align="center"><strong>Qty</strong></td>
                                    <td align="center"><strong>Part No Cust (Cust)</strong></td>
                                    <td align="center"><strong>Prod Line (PV)</strong></td>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                if($data_part_no != NULL){
                                    echo "<tr class='gradeX'>";
                                    echo "<td align='center'>" . $data_part_no->CHR_PART_NO . "</td>";
                                    echo "<td align='center'>" . $data_part_no->CHR_PART_NAME . "</td>";
                                    echo "<td align='center'>" . $data_part_no->CHR_BACK_NO . "</td>";
                                    echo "<td align='center'>1 PC</td>";
                                    $query = $this->db->query("SELECT CHR_PART_NO, CHR_CUS_PART_NO, CHR_CUS_NO, CHR_DIS_CHANNEL 
                                            FROM TM_SHIPPING_PARTS WHERE CHR_PART_NO = '$data_part_no->CHR_PART_NO'");
                                    if($query->num_rows() > 0){
                                        foreach($query->result() as $dt){
                                            echo "<td align='center'>" . $dt->CHR_CUS_PART_NO . " (" . $dt->CHR_CUS_NO . "/" . $dt->CHR_DIS_CHANNEL . ")" . "</td>";
                                        }
                                    } else {
                                        echo "<td align='center'>-</td>";
                                    }

                                    $mrp_d = $this->load->database("mrp_d", TRUE);
                                    $query_pv = $mrp_d->query("SELECT CHR_WORK_CENTER, CHR_PV, CHR_MAIN_STATUS 
                                            FROM TM_ROUTING_MRP WHERE CHR_PART_NO = '$data_part_no->CHR_PART_NO'");
                                    if($query_pv->num_rows() > 0){
                                        echo "<td align='center'>";
                                        foreach($query_pv->result() as $rw){
                                             echo $rw->CHR_WORK_CENTER . " (" . $rw->CHR_PV . ")";
                                             if($rw->CHR_MAIN_STATUS ==  'T'){
                                                echo "<i class='fa fa-check-circle'></i>";
                                             }  
                                             echo "<br>";
                                        }
                                        echo "</td>";
                                    } else {
                                        echo "<td align='center'>-</td>";
                                    }
                                    echo "</tr>";
                                }
                                ?>
                            </tbody>                                
                        </table> 
                    </div>
                </div>
            </div>
            <div class="col-md-12">
                <div class="grid">
                    <div class="grid-header">
                        <i class="fa fa-sitemap"></i>
                        <span class="grid-title"><strong>BOM STRUCTURE</strong></span>
                        <div class="pull-right grid-tools">
                            <a data-target='#modalComp' class='btn btn-info' data-placement='left' data-toggle='modal' title='Add Component' style='color:white;'><i class='fa fa-plus'></i> Add Component</a>
                            <a data-widget="collapse" title="Collapse"><i class="fa fa-chevron-up"></i></a>                            
                        </div>
                    </div>
                    <div class="grid-body">
                        <div style="font-size:12px;">
                            <table id="dataTable" class="table table-striped table-condensed table-hover display" cellspacing="0" width="100%">
                                <thead>
                                    <tr>
                                        <td align="center"><strong>No</strong></td>
                                        <td align="center"><strong>Level No</strong></td>
                                        <td align="center"><strong>Part No</strong></td>
                                        <td align="center"><strong>Part Name</strong></td>
                                        <td align="center"><strong>Back No</strong></td>                                         
                                        <td align="center"><strong>Source</strong></td>
                                        <td align="center"><strong>Sloc</strong></td>
                                        <td align="center"><strong>Area</strong></td>
                                        <td align="center"><strong>Qty</strong></td>
                                        <td align="center"><strong>UoM</strong></td>                                        
                                        <td align="center"><strong>Phantom</strong></td>
                                        <td align="center"><strong>Action</strong></td>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                        if($data != NULL){
                                            $no = 1;
                                            foreach ($data as $row) {
                                                if($row->BY_SAP == 'A'){
                                                    echo "<tr class='gradeX'>";
                                                } else {
                                                    echo "<tr class='gradeX' style='color:blue;'>";
                                                }
                                                echo "<td align='left'>" . $no . "</td>";
                                                echo "<td align='left'>";
                                                    for($x=1;$x<=$row->INT_LEVEL_BOM;$x++){ 
                                                        echo "."; 
                                                    } 
                                                    echo $row->INT_LEVEL_BOM . "</td>";
                                                echo "<td align='left'>" . trim($row->CHR_PART_NO_COMP) . "</td>";
                                                echo "<td align='left'>" . $row->CHR_PART_NAME . "</td>";
                                                
                                                $partno_comp = trim($row->CHR_PART_NO_COMP);
                                                if($row->CHR_SOURCE == 'E'){
                                                    $get_backno = $this->db->query("SELECT TOP 1 CHR_BACK_NO FROM TM_KANBAN WHERE CHR_PART_NO = '$partno_comp' AND CHR_KANBAN_TYPE = '1' AND (CHR_FLAG_DELETE IS NULL OR CHR_FLAG_DELETE <> 'X')");
                                                    if($get_backno->num_rows() > 0){
                                                        $backno = $get_backno->row();
                                                        echo "<td align='center'>" . $backno->CHR_BACK_NO . "</td>"; 
                                                    } else {
                                                        echo "<td align='center'>-</td>";
                                                    }
                                                    echo "<td align='center'>(E) In-house</td>"; 
                                                } else if($row->CHR_SOURCE == 'F'){
                                                    $get_backno = $this->db->query("SELECT TOP 1 CHR_BACK_NO FROM TM_KANBAN WHERE CHR_PART_NO = '$partno_comp' AND CHR_KANBAN_TYPE = '0' AND (CHR_FLAG_DELETE IS NULL OR CHR_FLAG_DELETE <> 'X')");
                                                    if($get_backno->num_rows() > 0){
                                                        $backno = $get_backno->row();
                                                        echo "<td align='center'>" . $backno->CHR_BACK_NO . "</td>"; 
                                                    } else {
                                                        echo "<td align='center'>-</td>";
                                                    }
                                                    echo "<td align='center'>(F) External</td>"; 
                                                } else if($row->CHR_SOURCE == 'X'){
                                                    $get_backno = $this->db->query("SELECT CHR_BACK_NO FROM TM_KANBAN WHERE CHR_PART_NO = '$partno_comp' AND CHR_KANBAN_TYPE IN ('0','1') AND (CHR_FLAG_DELETE IS NULL OR CHR_FLAG_DELETE <> 'X')");
                                                    if($get_backno->num_rows() > 0){
                                                        $backno = $get_backno->result();
                                                        echo "<td align='center'>";
                                                        foreach($backno as $bn){
                                                            echo $bn->CHR_BACK_NO . ' ';
                                                        }
                                                        echo "</td>"; 
                                                    } else {
                                                        echo "<td align='center'>-</td>";
                                                    }
                                                    echo "<td align='center'>(X) Both Proc</td>"; 
                                                } else {
                                                    echo "<td align='center'>-</td>";
                                                    echo "<td align='center'>No Proc</td>";
                                                }

                                                echo "<td align='center'>" . $row->CHR_SLOC . "</td>";
                                                if($row->CHR_AREA == 'A'){
                                                    echo "<td align='center'>CKD</td>";
                                                } else if($row->CHR_AREA == 'B'){
                                                    echo "<td align='center'>OH</td>";
                                                } else if($row->CHR_AREA == 'C'){
                                                    echo "<td align='center'>IH</td>";
                                                } else {
                                                    echo "<td align='center'>RM/Other</td>";
                                                }

                                                if(trim($row->CHR_UOM) == "G" || trim($row->CHR_UOM) == "KG"){
                                                    echo "<td align='left'>" . number_format($row->QTY/1000,3,',','.') . "</td>";
                                                } else {
                                                    echo "<td align='left'>" . number_format($row->QTY,3,',','.') . "</td>";
                                                }                                               
                                                
                                                
                                                if(trim($row->CHR_UOM) == 'ST'){
                                                    echo "<td align='center'>PC</td>";
                                                } else {
                                                    echo "<td align='center'>" . $row->CHR_UOM . "</td>";
                                                }
                                                
                                                echo "<td align='center'>" . $row->CHR_FLG_PHANTOM . "</td>"; 
                                                $stat_edit = 'data-target="#modalEdit_' . $row->BY_SAP . '_' . $row->INT_ID . '" class="label label-warning"';
                                                if($row->BY_SAP == 'A' && ($row->CHR_SOURCE == 'E' || $row->CHR_SOURCE == '' || $row->CHR_SOURCE == NULL)){
                                                    $stat_edit = 'data-target="#" class="label label-default" disabled';
                                                }

                                                $stat_del = 'href="' . base_url('index.php/mrp/manage_mrp_c/delete_extend_component') . '/' . $row->INT_ID . '/' . trim($data_part_no->CHR_PART_NO) . '" class="label label-danger"';
                                                if($row->BY_SAP == 'A'){
                                                    $stat_del = 'href="#" class="label label-default" disabled';
                                                }
                                                echo "<td align='center'>";
                                        ?>
                                                <a data-toggle="modal" <?php echo $stat_edit; ?>><span class="fa fa-pencil"></span></a>                                        
                                                <a <?php echo $stat_del; ?> <?php if($row->BY_SAP <> 'A'){ ?> onclick="return confirm('Are you sure want to delete this component <?php echo trim($row->CHR_PART_NO_COMP); ?> ?');" <?php } ?>><span class="fa fa-times"></span></a>
                                        <?php
                                                echo "</td>";
                                                echo "</tr>";
                                                $no++;
                                            }
                                        } else {
                                            echo "<tr style='background-color: whitesmoke;'>";
                                            echo "<td colspan='10'><strong>No Data Available</strong></td>";
                                            echo "</tr>";
                                        }
                                    ?>
                                </tbody>                                
                            </table>                            
                        </div>
                        <!-- START MODAL 1 -->  
                        <div class="modal fade" id="modalComp" tabindex="-1" role="dialog" aria-labelledby="modalprogress" aria-hidden="true" style="display: none;">
                            <div class="modal-wrapper">
                                <div class="modal-dialog">                                    
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                                            <h4 class="modal-title" id="modalprogress"><strong>Add Component</strong></h4>
                                        </div>
                                        <?php echo form_open('mrp/manage_mrp_c/add_extend_component', 'class="form-horizontal"'); ?>
                                        <input name="CHR_PART_NO" class="form-control" type="hidden" value="<?php echo $data_part_no->CHR_PART_NO; ?>">
                                        <div class="modal-body">
                                            <div class="form-group">
                                                <label class="col-sm-3 control-label">Level No</strong></label>
                                                <div class="col-sm-5">
                                                <input type="number" id="level_no" name="CHR_LEVEL_NO" class="form-control" disabled value="1" >
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <label class="col-sm-3 control-label">Material Group</strong></label>
                                                <div class="col-sm-5">
                                                    <select name="CHR_PART_GROUP" id="e1" class="form-control" onchange="get_list_part_extend();">      
                                                    <?php foreach ($data_part_group as $group) { ?>
                                                        <option value="<?php echo $group->CHR_PART_GROUP; ?>"><?php echo $group->CHR_PART_GROUP . ' - ' . $group->CHR_PART_GROUP_DESC; ?></option>
                                                    <?php } ?>        
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <label class="col-sm-3 control-label">Component</strong></label>
                                                <div class="col-sm-5">
                                                    <select name="CHR_PART_NO_COMP" id="e2" class="form-control" onchange="get_uom_part_extend();get_supplier();">      
                                                        
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <label class="col-sm-3 control-label">UoM</strong></label>
                                                <div class="col-sm-5">
                                                    <input type="text" id="uom" name="CHR_UOM" class="form-control" required value="" >
                                                    <span style="font-style:italic; color: red;">Note:</span> <span style="font-style:italic">PC/G/KG</span>
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <label class="col-sm-3 control-label">Qty</strong></label>
                                                <div class="col-sm-5">
                                                    <input type="number" id="qty_comp" step="any" min="0" name="INT_QTY_COMP" class="form-control" required value="">
                                                    <span style="font-style:italic; color: red;">Note:</span> <span style="font-style:italic">Desimal gunakan titik/koma </span>
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <label class="col-sm-3 control-label">Source</strong></label>
                                                <div class="col-sm-5">
                                                    <select name="CHR_SOURCE" id="source" class="form-control" onchange="get_supplier();">   
                                                        <option value='F'>External Procurement</option>   
                                                        <option value='E'>In-house Production</option>
                                                        <option value='X'>Both Procurement Type</option>
                                                        <option value=''>No Procurement</option>
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="form-group" id="div_supp" style="display:block;">
                                                <label class="col-sm-3 control-label">Supplier</strong></label>
                                                <div class="col-sm-5">
                                                    <select name="CHR_SUPPLIER" id="supp" class="form-control">      
                                                        
                                                    </select>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="modal-footer">
                                            <div class="btn-group">
                                                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                                                <button type="submit" id="add_component" class="btn btn-primary" data-placement="left" data-toggle="tooltip" title="Save this data"><i class="fa fa-check"></i> Save</button>
                                            </div>                                            
                                        </div>
                                        <?php echo form_close(); ?>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!-- END MODAL 1 -->
                        <!-- START MODAL 2 -->  
                        <?php
                            foreach($data as $list){
                        ?>
                        <div class="modal fade" id="modalEdit_<?php echo $list->BY_SAP . '_' . $list->INT_ID; ?>" tabindex="-1" role="dialog" aria-labelledby="modalprogress" aria-hidden="true" style="display: none;">
                            <div class="modal-wrapper">
                                <div class="modal-dialog">                                    
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                                            <h4 class="modal-title" id="modalprogress"><strong>Edit Component</strong></h4>
                                        </div>
                                        <?php echo form_open('mrp/manage_mrp_c/edit_extend_component', 'class="form-horizontal"'); ?>
                                        <input name="CHR_PART_NO" class="form-control" type="hidden" value="<?php echo $data_part_no->CHR_PART_NO; ?>">
                                        <input name="BY_SAP" class="form-control" type="hidden" value="<?php echo $list->BY_SAP; ?>">
                                        <input name="INT_ID" class="form-control" type="hidden" value="<?php echo $list->INT_ID; ?>">
                                        <div class="modal-body">
                                            <div class="form-group">
                                                <label class="col-sm-3 control-label">Level No</strong></label>
                                                <div class="col-sm-5">
                                                    <input type="number" id="level_no" name="CHR_LEVEL_NO" class="form-control" disabled value="<?php echo $list->INT_LEVEL_BOM; ?>" >
                                                </div>
                                            </div>                                            
                                            <div class="form-group">
                                                <label class="col-sm-3 control-label">Component</strong></label>
                                                <div class="col-sm-5">
                                                    <select name="CHR_PART_NO_COMP" id="comp" class="form-control" style="width:330px;" disabled>      
                                                        <option value="<?php echo trim($list->CHR_PART_NO_COMP); ?>" ><?php echo trim($list->CHR_PART_NO_COMP) . ' - ' . $list->CHR_PART_NAME; ?></option>
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <label class="col-sm-3 control-label">Qty</strong></label>
                                                <div class="col-sm-5">
                                                    <input type="number" min="0" id="qty_comp" step="any" name="INT_QTY_COMP" <?php if($list->BY_SAP == 'A'){ echo "readonly"; } ?> class="form-control" required value="<?php echo $list->QTY; ?>" >
                                                    <span style="font-style:italic; color: red;">Note:</span> <span style="font-style:italic">Desimal gunakan titik/koma</span>
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <label class="col-sm-3 control-label">UoM</strong></label>
                                                <div class="col-sm-5">
                                                    <input type="text" class="form-control" disabled value="<?php if(trim($list->CHR_UOM) == 'ST'){ echo "PC"; } else { echo trim($list->CHR_UOM); } ?>" >
                                                </div>
                                            </div>                                            
                                            <div class="form-group">
                                                <label class="col-sm-3 control-label">Source</strong></label>
                                                <div class="col-sm-5">
                                                    <select name="CHR_SOURCE_EDIT" id="source_edit" disabled class="form-control">   
                                                        <option value='F' <?php if($list->CHR_SOURCE == 'F'){ echo "selected"; } ?>>External Procurement</option>   
                                                        <option value='E' <?php if($list->CHR_SOURCE == 'E'){ echo "selected"; } ?>>In-house Production</option>
                                                        <option value='X' <?php if($list->CHR_SOURCE == 'X'){ echo "selected"; } ?>>Both Procurement Type</option>
                                                        <option value='' <?php if($list->CHR_SOURCE == ''){ echo "selected"; } ?>>No Procurement</option>
                                                    </select>
                                                </div>
                                            </div>
                                            <?php
                                                if($list->CHR_SOURCE == 'F' || $list->CHR_SOURCE == 'X'){
                                                    $get_supp = $this->db->query("SELECT A.CHR_SUPPLIER_ID, B.CHR_SUPPLIER_NAME FROM TM_VENDOR_PARTS A LEFT JOIN TM_VENDOR B ON A.CHR_SUPPLIER_ID = B.CHR_SUPPLIER_ID WHERE CHR_PART_NO = '$list->CHR_PART_NO_COMP'")->result();
                                            ?>
                                            <div class="form-group" id="div_supp_edit" style="display:block;">
                                                <label class="col-sm-3 control-label">Supplier</strong></label>
                                                <div class="col-sm-5">
                                                    <select name="CHR_SUPPLIER_EDIT" id="supp_edit" class="form-control">      
                                                        <?php
                                                            foreach($get_supp as $supp){
                                                                echo '<option value="' . $supp->CHR_SUPPLIER_ID . '">' . $supp->CHR_SUPPLIER_ID . ' - ' . $supp->CHR_SUPPLIER_NAME . '</option>'; 
                                                            }
                                                        ?>
                                                    </select>
                                                </div>
                                            </div>
                                            <?php
                                                }
                                            ?>
                                        </div>
                                        <div class="modal-footer">
                                            <div class="btn-group">
                                                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                                                <button type="submit" id="add_component" class="btn btn-primary" data-placement="left" data-toggle="tooltip" title="Save this data"><i class="fa fa-check"></i> Save</button>
                                            </div>                                            
                                        </div>
                                        <?php echo form_close(); ?>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <?php } ?>
                        <!-- END MODAL 2 -->
                    </div>
                </div>
            </div>
        </div>
    </section>
</aside>
<script src="<?php echo base_url('assets/js/jquery-1.12.3.js') ?>"></script>
<script src="<?php echo base_url('assets/js/jquery.dataTables.min.js') ?>"></script>
<script src="<?php echo base_url('assets/js/dataTables.fixedColumns.min.js') ?>"></script>
<script>
    // $(document).ready(function () {
    //     var interval_close = setInterval(closeSideBar, 250);
    //     function closeSideBar() { 
    //         $("#hide-sub-menus").click();
    //         clearInterval(interval_close);
    //     }
    // });

    $(document).ready(function() {
        $('#example').DataTable({
            scrollX: true,
            fixedColumns: {
                leftColumns: 3
            }
        });
    });

    function get_list_part_extend(){
        var id = document.getElementById('e1').value;
        $.ajax({
            async: false,
            type: "POST",
            dataType: "json",
            url: "<?php echo site_url('mrp/manage_mrp_c/get_list_part_extend'); ?>",
            data: "id_grp=" + id,
            success: function (json_data) {
                // alert(data);     
                $("#e2").html(json_data['data']);
            },
            error: function (json_data) {
                alert(data.responseText);
            }
        });
    }

    function get_uom_part_extend(){
        var comp_no = document.getElementById('e2').value;
        $.ajax({
            async: false,
            type: "POST",
            dataType: "json",
            url: "<?php echo site_url('mrp/manage_mrp_c/get_uom_part_extend'); ?>",
            data: "part_no_comp=" + comp_no,
            success: function (json_data) {
                // alert(data);     
                document.getElementById('uom').value = json_data['data'];
            },
            error: function (json_data) {
                alert(data.responseText);
            }
        });
    }

    function get_supplier(){
        var comp_no = document.getElementById('comp').value;
        var proc_type = document.getElementById('source').value;
        if(proc_type === 'F' || proc_type === 'X'){
            document.getElementById('div_supp').style.display = 'block';
            $.ajax({
                async: false,
                type: "POST",
                dataType: "json",
                url: "<?php echo site_url('mrp/manage_mrp_c/get_supplier'); ?>",
                data: "part_no_comp=" + comp_no,
                success: function (json_data) {
                    // alert(data);     
                    $("#supp").html(json_data['data']);
                },
                error: function (json_data) {
                    alert(data.responseText);
                }
            });
        } else {
            document.getElementById('div_supp').style.display = 'none';
        }        
    }

</script>
