<script type="text/javascript">
    $(document).ready(function() {
        $("#btn_create").click(function() {
            $.ajax({
                url: "<?php echo base_url(); ?>index.php/mte/master_preventive_c/show_create",
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
<script>
    var tableToExcel = (function() {
        var uri = 'data:application/vnd.ms-excel;base64,',
            template = '<html xmlns:o="urn:schemas-microsoft-com:office:office" xmlns:x="urn:schemas-microsoft-com:office:excel" xmlns="http://www.w3.org/TR/REC-html40"><head><!--[if gte mso 9]><xml><x:ExcelWorkbook><x:ExcelWorksheets><x:ExcelWorksheet><x:Name>{worksheet}</x:Name><x:WorksheetOptions><x:DisplayGridlines/></x:WorksheetOptions></x:ExcelWorksheet></x:ExcelWorksheets></x:ExcelWorkbook></xml><![endif]--></head><body><table>{table}</table></body></html>',
            base64 = function(s) {
                return window.btoa(unescape(encodeURIComponent(s)))
            },
            format = function(s, c) {
                return s.replace(/{(\w+)}/g, function(m, p) {
                    return c[p];
                })
            }
        return function(table, name) {
            if (!table.nodeType)
                table = document.getElementById(table)
            var ctx = {
                worksheet: name || 'Sheet1',
                table: table.innerHTML
            }
            window.location.href = uri + base64(format(template, ctx))
        }
    })()
</script>
<aside class="right-side">
    <!-- BEGIN CONTENT HEADER -->
    <section class="content-header">
        <ol class="breadcrumb">
            <li><a href="<?php echo base_url('index.php/home_c') ?>"><span>Home</span></a></li>
            <li class="active"> <a href="<?php echo base_url('index.php/mrp/manage_mrp_c/manage_bom') ?>"><strong>Manage Data BOM</strong></a></li>
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
            <div class="col-md-12">
                <div class="grid">
                    <div class="grid-header">
                        <i class="fa fa-th-large"></i>
                        <span class="grid-title"><strong>Manage Bill Of Material (BOM)</strong></span>
                        <div class="pull-right">
                            <!-- <button id="btn_create" class="btn btn-default" data-placement="left" data-toggle="tooltip" title="Generate BOM" style="height:30px;font-size:13px;width:100px;">Add BOM</button> -->
                            <input type="button" class="btn btn-primary" style="margin-top: 3px;margin-bottom: 2px;" onclick="tableToExcel('exportToExcel', 'report_history_setup_chute')" value="Export to Excel"><i class="fa fa-download-up"></i></input>
                        </div>
                    </div>
                    <div class="grid-body">
                        <div class="pull">
                            <table width="15%" id='filter'>
                                <!-- <tr>
                                    <td>Filter</td>
                                    <td>&nbsp;&nbsp;</td>
                                    <td style="vertical-align:top">
                                        <select onChange="document.location.href = this.options[this.selectedIndex].value;" class="ddl2">
                                            <?php foreach ($all_product_group as $row) { ?>
                                                <option value="<?php echo site_url('mrp/manage_mrp_c/manage_bom/0/' . $row->INT_ID); ?>" <?php
                                                if ($id_product_group == $row->INT_ID) {
                                                    echo 'SELECTED';
                                                }
                                                ?> ><?php echo trim($row->CHR_PRODUCT_GROUP); ?></option>
                                                    <?php } ?>
                                        </select>
                                    </td>    
                                </tr>  -->
                                <tr>
                                    <td>Filter</td>
                                    <td>&nbsp;&nbsp;</td>
                                    <td style="vertical-align:top">
                                        <select onChange="document.location.href = this.options[this.selectedIndex].value;" class="ddl2">
                                            <?php foreach ($all_product_group as $row) { ?>
                                                <option value="<?php echo site_url('mrp/manage_mrp_c/manage_bom/0/' . $row->CHR_GROUP_PRODUCT_CODE); ?>" <?php
                                                if ($id_product_group == $row->CHR_GROUP_PRODUCT_CODE) {
                                                    echo 'SELECTED';
                                                }
                                                ?> ><?php echo trim($row->CHR_GROUP_PRODUCT_DESC); ?></option>
                                                    <?php } ?>
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
                                    <th>Part No</th>
                                    <th>Part Name</th>
                                    <th>Back No</th>
                                    <th>SAP BOM</th>
                                    <th>Last Update (SAP)</th>
                                    <th>Ext BOM</th>
                                    <th>Last Update (EXT)</th>                                    
                                    <th>Actions</th>

                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                $i = 1;
                                foreach ($data as $isi) {
                                    echo "<tr class='gradeX'>";
                                    echo "<td>$i</td>";
                                    echo "<td>" . $isi->CHR_PART_NO . "</td>";
                                    echo "<td>" . $isi->CHR_PART_NAME . "</td>";
                                    echo "<td>" . $isi->CHR_BACK_NO . "</td>";

                                    $mrp_d = $this->load->database("mrp_d", TRUE);
		                            $query = $mrp_d->query("SELECT TOP 1 CHR_PART_NO_FG, CHR_CREATE_DATE, CHR_CREATE_TIME FROM TM_BOM_SAP WHERE CHR_PART_NO_FG = '$isi->CHR_PART_NO'");
                                    if($query->num_rows() > 0){
                                        $bom = $query->row();
                                        echo "<td>Generated</td>";
                                        echo "<td>" . substr($bom->CHR_CREATE_DATE,6,4) . "-" . substr($bom->CHR_CREATE_DATE,4,2) . "-" . substr($bom->CHR_CREATE_DATE,0,4) . " / " . substr($bom->CHR_CREATE_TIME,0,2) . ":" . substr($bom->CHR_CREATE_TIME,2,2) . "</td>";
                                    } else {
                                        echo "<td>-</td>";
                                        echo "<td>-</td>";                                        
                                    }

                                    $query2 = $mrp_d->query("SELECT TOP 1 CHR_PART_NO_FG, CHR_CREATE_DATE, CHR_CREATE_TIME FROM TM_BOM_EXTEND WHERE CHR_PART_NO_FG = '$isi->CHR_PART_NO' AND INT_FLG_DELETE = '0'");
                                    if($query2->num_rows() > 0){
                                        $bom_ext = $query2->row();
                                        echo "<td>OK</td>";
                                        echo "<td>" . substr($bom_ext->CHR_CREATE_DATE,6,4) . "-" . substr($bom_ext->CHR_CREATE_DATE,4,2) . "-" . substr($bom_ext->CHR_CREATE_DATE,0,4) . " / " . substr($bom_ext->CHR_CREATE_TIME,0,2) . ":" . substr($bom_ext->CHR_CREATE_TIME,2,2) . "</td>";
                                    } else {
                                        echo "<td>-</td>";
                                        echo "<td>-</td>";                                        
                                    }
                                    
                                    ?>
                                <td>
                                    <a href="<?php echo base_url('index.php/mrp/manage_mrp_c/view_detail_bom') . "/0/" . $isi->CHR_PART_NO ?>" class="label label-info"><span class="fa fa-bars"></span></a>
                                    <?php if($i == 0){ ?>
                                        <a href="<?php echo base_url('index.php/mrp/manage_mrp_c/disable_bom') . "/0/" . $isi->CHR_PART_NO ?>" class="label label-danger"><span class="fa fa-times"></span></a>
                                    <?php } else { ?>
                                        <a href="<?php echo base_url('index.php/mrp/manage_mrp_c/enable_bom') . "/0/" . $isi->CHR_PART_NO ?>" class="label label-default"><span class="fa fa-times"></span></a>
                                    <?php } ?>
                                </td>
                                </tr>
                                <?php
                                $i++;
                            }
                            ?>
                            </tbody>
                        </table>
                        <table id="exportToExcel" class="table table-condensed table-striped table-hover display" cellspacing="0" width="100%" style="display:none;">
                            <thead>
                                <tr>
                                    <th>No</th>
                                    <th>Part No</th>
                                    <th>Part Name</th>
                                    <th>Back No</th>
                                    <th>SAP BOM</th>
                                    <th>Last Update (SAP)</th>
                                    <th>Ext BOM</th>
                                    <th>Last Update (EXT)</th>                                    
                                    <th>Actions</th>

                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                $i = 1;
                                foreach ($data as $isi) {
                                    echo "<tr class='gradeX'>";
                                    echo "<td>$i</td>";
                                    echo "<td>" . $isi->CHR_PART_NO . "</td>";
                                    echo "<td>" . $isi->CHR_PART_NAME . "</td>";
                                    echo "<td>" . $isi->CHR_BACK_NO . "</td>";

                                    $mrp_d = $this->load->database("mrp_d", TRUE);
		                            $query = $mrp_d->query("SELECT TOP 1 CHR_PART_NO_FG, CHR_CREATE_DATE, CHR_CREATE_TIME FROM TM_BOM_SAP WHERE CHR_PART_NO_FG = '$isi->CHR_PART_NO'");
                                    if($query->num_rows() > 0){
                                        $bom = $query->row();
                                        echo "<td>Generated</td>";
                                        echo "<td>" . substr($bom->CHR_CREATE_DATE,6,4) . "-" . substr($bom->CHR_CREATE_DATE,4,2) . "-" . substr($bom->CHR_CREATE_DATE,0,4) . " / " . substr($bom->CHR_CREATE_TIME,0,2) . ":" . substr($bom->CHR_CREATE_TIME,2,2) . "</td>";
                                    } else {
                                        echo "<td>-</td>";
                                        echo "<td>-</td>";                                        
                                    }

                                    $query2 = $mrp_d->query("SELECT TOP 1 CHR_PART_NO_FG, CHR_CREATE_DATE, CHR_CREATE_TIME FROM TM_BOM_EXTEND WHERE CHR_PART_NO_FG = '$isi->CHR_PART_NO' AND INT_FLG_DELETE = '0'");
                                    if($query2->num_rows() > 0){
                                        $bom_ext = $query2->row();
                                        echo "<td>OK</td>";
                                        echo "<td>" . substr($bom_ext->CHR_CREATE_DATE,6,4) . "-" . substr($bom_ext->CHR_CREATE_DATE,4,2) . "-" . substr($bom_ext->CHR_CREATE_DATE,0,4) . " / " . substr($bom_ext->CHR_CREATE_TIME,0,2) . ":" . substr($bom_ext->CHR_CREATE_TIME,2,2) . "</td>";
                                    } else {
                                        echo "<td>-</td>";
                                        echo "<td>-</td>";                                        
                                    }
                                    
                                    ?>
                                <td>
                                    <a href="<?php echo base_url('index.php/mrp/manage_mrp_c/view_detail_bom') . "/0/" . $isi->CHR_PART_NO ?>" class="label label-info"><span class="fa fa-bars"></span></a>
                                    <?php if($i == 0){ ?>
                                        <a href="<?php echo base_url('index.php/mrp/manage_mrp_c/disable_bom') . "/0/" . $isi->CHR_PART_NO ?>" class="label label-danger"><span class="fa fa-times"></span></a>
                                    <?php } else { ?>
                                        <a href="<?php echo base_url('index.php/mrp/manage_mrp_c/enable_bom') . "/0/" . $isi->CHR_PART_NO ?>" class="label label-default"><span class="fa fa-times"></span></a>
                                    <?php } ?>
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

    </section>
    <!-- END MAIN CONTENT -->
</aside>