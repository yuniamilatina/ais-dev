<script type="text/javascript">
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
            <li><a href="<?php echo base_url('index.php/home_c') ?>"><span>Home</span></a></li>
            <li class="active"> <a href="<?php echo base_url('index.php/mrp/manage_mrp_c/explode_material_by_chute') ?>"><strong>Explode Material by Chute</strong></a></li>
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
                        <span class="grid-title"><strong>Explode Material by Chute</strong></span>
                        <div class="pull-right">
                            <!-- <button id="btn_create" class="btn btn-default" data-placement="left" data-toggle="tooltip" title="Generate BOM" style="height:30px;font-size:13px;width:100px;">Add BOM</button> -->
                        </div>
                    </div>
                    <div class="grid-body">
                        <div class="pull">
                            <table width="15%" id='filter'>
                                <tr>
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
                                </tr>                            
                            </table>
                        </div>
                        <br>
                        <table id="dataTables1" class="table table-condensed table-striped table-hover display" cellspacing="0" width="100%">
                            <thead>
                                <tr>
                                    <th rowspan>No</th>
                                    <th>Work Center</th>
                                    <th>Part No</th>
                                    <th>Back No</th>
                                    <th>Part Name</th>
                                    <th>Qty of Month</th>
                                    <th>Part No Comp</th>
                                    <th>Back No Comp</th>
                                    <th>Comp Name</th>
                                    <th>Qty</th>
                                    <th>UoM</th>
                                    <th><?php echo $period;?></th>           
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
                                        echo "<td>" . substr($bom->CHR_CREATE_DATE,6,4) . "-" . substr($bom->CHR_CREATE_DATE,4,2) . "-" . substr($bom->CHR_CREATE_DATE,0,4) . " / " . substr($bom->CHR_CREATE_TIME,0,2) . ":" . substr($bom->CHR_CREATE_TIME,2,2) . "</td>";
                                        echo "<td>Generated</td>";
                                    } else {
                                        echo "<td>-</td>";
                                        echo "<td>Not Yet</td>";
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