
<style type="text/css">
    th, td { white-space: nowrap; }
    div.dataTables_wrapper {
        margin: 0 auto;
    }
    #table-luar{
        font-size: 12px;
    }
    #filter { 
        border-spacing: 10px;
        border-collapse: separate;
    }
    .td-fixed{
        width: 30px;
    }
    .td-no{
        width: 10px;
    }
    .ddl{
        width: 100px;
        height: 30px;
    }
    .ddl2{
        width: 180px;
        height: 30px;
    }
</style>

<aside class="right-side">
    <section class="content-header">
        <ol class="breadcrumb">
            <li><a href="<?php echo base_url('index.php/basis/home_c') ?>"><span>Home</span></a></li>
            <li><a href="<?php echo base_url('index.php/prd/manage_part_wcenter_c') ?>"><strong>Mapping Part to Work center</strong></a></li>
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
                        <i class="fa fa-clock-o"></i>
                        <span class="grid-title"><strong>MAPPING PART TO WORK CENTER</strong></span>
                        <div class="pull-right grid-tools">
                            <!-- <a href="#"  class="btn btn-default" data-placement="left" data-toggle="tooltip" title="Upload" style="height:30px;font-size:13px;width:100px;color:grey;margin-top:-5px;margin-bottom:-5px;">Upload</a> -->
                        </div>
                    </div>
                    <div class="grid-body">
                        <?php echo form_open('prd/manage_part_wcenter_c/search_part_no', 'class="form-horizontal"'); ?>
                        <div class="pull">
                            <table width="100%" id='filter' border=0px>
                                <tr>
                                    <td width="5%"></td>
                                    <td width="5%">
                                    </td>
                                    <td width="5%" colspan="4"></td>
                                    <td width="5%">
                                        
                                    </td>
                                    <td width="55%">
                                    </td>
                                    <td width="25%">
                                    </td>
                                </tr>
                                <tr>
                                    <td width="5%">Part No</td>
                                        <td width="5%">
                                            <input type="text" name="CHR_PART_NO" value="">
                                        </td>
                                    <td width="5%" colspan="4"></td>
                                    <td width="5%"></td>
                                    <td width="55%">    
                                        
                                    </td>
                                    <td width="25%">
                                    </td>
                                </tr>
                                <tr>
                                    <td width="5%">Back No</td>
                                    <td width="5%">
                                        <input type="text" name="CHR_BACK_NO" value="">
                                    <td width="5%" colspan="4">
                                        <button type="submit" class="btn btn-primary" style="margin-top: 3px;margin-bottom: 2px;"><span class="fa fa-filter"></span>&nbsp;&nbsp;Filter</button></td>
                                        <?php form_close(); ?></td>
                                    <td width="5%"></td>
                                    <td width="5%"></td>
                                    <td width="25%" style='text-align:right;'>
                                        <!-- <input type="button" class="btn btn-primary" onclick="tableToExcel('exportToExcel', 'Production Per Hour')" value="Export to Excel" style="margin-bottom: 0px;"> -->
                                    </td>
                                </tr>
                            </table>
                            <?php echo form_close(); ?>
                        </div>

                        <div id="table-luar">
                            <table id="dataTables3" class="table table-condensed table-striped table-hover display" cellspacing="0" width="100%">
                                <thead>
                                    <tr>
                                        <th style='text-align:center;'>No</th>
                                        <th style="text-align:center;">Part No</th>
                                        <th style="text-align:center;">Back No</th> 
                                        <th style="text-align:center;">Part Name</th>  
                                        <th style="text-align:center;">PV</th>                                     
                                        <th style="text-align:center;">Work Center</th>
                                        <th style="text-align:center;">Status</th>
                                        <th style="text-align:center;">Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php 
                                        $i = 1;
                                        foreach($data as $isi){
                                            echo "<tr class='gradeX'>";
                                            echo "<td align='center'>$i</td>";
                                            echo "<td align='center'>" . trim($isi->CHR_PART_NO) . "</td>";
                                            echo "<td align='center'>" . trim($isi->CHR_BACK_NO) . "</td>";
                                            echo "<td align='left'>" . $isi->CHR_PART_NAME . "</td>";
                                            echo "<td align='center'>" . trim($isi->CHR_PV) . "</td>";
                                            echo "<td align='center'>" . trim($isi->CHR_WORK_CENTER) . "</td>";
                                            if($isi->CHR_FLAG_ACTIVE == NULL || $isi->CHR_FLAG_ACTIVE == '0' || $isi->CHR_FLAG_ACTIVE == ''){
                                                echo "<td align='center'>-</td>";
                                            } else {
                                                echo "<td align='center'>Active</td>";
                                            }
                                    ?>
                                            <td align='center'>
                                                <?php if($isi->CHR_FLAG_ACTIVE == NULL || $isi->CHR_FLAG_ACTIVE == '0' || $isi->CHR_FLAG_ACTIVE == ''){ ?>
                                                    <a href="<?php echo site_url('prd/manage_part_wcenter_c/update_part/' . trim($isi->CHR_PART_NO) . '/' . trim($isi->CHR_WORK_CENTER) . '/1'); ?>" class="label label-primary" data-toggle="modal" data-placement="top" title="Enabled"><span class="fa fa-check"></span></a>
                                                    <a href="#" class="label label-default" data-toggle="modal" data-placement="top" title="Disabled"><span class="fa fa-times"></span></a>
                                                <?php } else {?>
                                                    <a href="#" class="label label-default" data-toggle="modal" data-placement="top" title="Enabled"><span class="fa fa-check"></span></a>
                                                    <a href="<?php echo site_url('prd/manage_part_wcenter_c/update_part/' . trim($isi->CHR_PART_NO) . '/' . trim($isi->CHR_WORK_CENTER) . '/0'); ?>" class="label label-danger" data-toggle="modal" data-placement="top" title="Disabled"><span class="fa fa-times"></span></a>
                                                <?php } ?>
                                            </td>
                                    <?php
                                            
                                            echo "</tr>";
                                            $i++;
                                        }
                                    ?>

                                </tbody>
                            </table>
                        </div>
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
    $(document).ready(function() {
        $('#dataTables3').DataTable({
            scrollX: true,
            lengthMenu: [[10, 25, 50, -1], [10, 25, 50, "All"]],
            fixedColumns: {
                leftColumns: 2               
            }
        });
    });
</script>