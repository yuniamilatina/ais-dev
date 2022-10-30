<style type="text/css">
    th, td { white-space: nowrap; }
    div.dataTables_wrapper {
        width: 100%;
        margin: 0 auto;
    }
    #table-luar{
        font-size: 11px;
    }
    #filter { 
        border-spacing: 10px;
        border-collapse: separate;
    }
    .td-fixed{
        width: 100px;
    }
    .ddl{
        width: 100px;
        height: 30px;
    }
    .ddl2{
        width: 180px;
        height: 30px;
    }
    .fileUpload {
        position: relative;
        overflow: hidden;
        width:100px;
        margin-left: 15px;
    }
    .fileUpload input.upload {
        position: absolute;
        top: 0;
        right: 0;
        margin: 0;
        padding: 0;
        font-size: 20px;
        cursor: pointer;
        opacity: 0;
        filter: alpha(opacity=0);
    }

    .input-upload{
        border:none;width:50px;background:transparent;
        text-align: right;
    }
</style>

<aside class="right-side">

    <section class="content-header">
        <ol class="breadcrumb">
            <li><a href="<?php echo base_url('index.php/home_c/"') ?>">Home</a></li>
            <li><a href="<?php echo base_url('index.php/patricia/load_tester_c/"') ?>">Manage Load Tester</a></li>
            <li class="active"> <a href="#"><strong>Upload Load Tester</strong></a></li>
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
                        <i class="fa fa-refresh"></i>
                        <span class="grid-title"><strong>UPLOAD LOAD TESTER</strong></span>
                        <div class="pull-right grid-tools">
                        </div>
                    </div>
                    <div class="grid-body" style="margin-top: 5px;margin-bottom:-10px;">

                    <?php echo form_open_multipart('patricia/load_tester_c/update_load_tester', 'class="form-horizontal"'); ?>

                        <div class="pull">
                            <table width="100%" id='filter'>
                                <tr>
                                    <td width="10%" style='text-align:left;' ><strong>File (.xlsx)</strong></td>
                                    <td width="30%" style='text-align:left;' colspan="3">
                                        <input type="file" name="upload_load_tester" class="form-control" id="import" size="15"> 
                                    </td>
                                    <td width="60%">
                                        <button style="margin-left:-5px;margin-top:4px;" type="submit" name="submit" class="btn btn-primary" data-toggle="tooltip" data-placement="right" title="Lets Processing data"><i class="fa fa-upload"></i> Upload</button>
                                    </td>
                                </tr>
                            </table>
                        </div>

                    </div>
                    
                    <?php echo form_close(); ?>

                    <?php echo form_open('patricia/load_tester_c/update_balancing_load_tester', 'class="form-horizontal"'); ?>

                    <div class="grid-body" style="padding-top: 0px">
                        
                        <div id="table-luar">
                             <table id="example" class="table table-condensed table-bordered table-striped table-hover display" cellspacing="0" width="100%">
                                <thead>
                                    <tr>
                                        <th style="text-align:center;">No</th>
                                        <th style="text-align:center;">Jarak</th>
                                        <th style="text-align:center;">Load Part 1</th>
                                        <th style="text-align:center;">Load Part 2</th>
                                        <th style="text-align:center;">Load Part 3</th>
                                        <th style="text-align:center;">Date</th>
                                        <th style="text-align:center;">Part No</th>
                                        <th style="text-align:center;">Back No</th>
                                        <th style="display:none;">Flag Save</th>
                                        <th style="text-align:center;">Message</th>
                                        <th style="display:none;">Flag Error</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                   
                                    $x = 1;
                                    for($y = 0; $y < $data_exist; $y++){
                                        
                                        if($height_a == $data[$y]['INT_SCALE'] || $height_b == $data[$y]['INT_SCALE']){
                                            $color = 'style=text-align:center;background:#FFF582;"';
                                            $flg_save = 1;
                                        }else{
                                            $color = 'style="text-align:center;"';
                                            $flg_save = 0;
                                        }
                                        
                                        ?>

                                        <tr class='gradeX'>
                                        <td <?php echo $color; ?>><?php echo $x ?></td> 
                                        <td <?php echo $color; ?>>
                                            <input name="tableRow[<?php echo $y; ?>][INT_SCALE]" type='text' value="<?php echo $data[$y]['INT_SCALE'];?>"  style='border:none;width:80px;background:transparent;'></input>
                                        </td>
                                        <td <?php echo $color; ?>>
                                            <input name="tableRow[<?php echo $y; ?>][INT_LOAD1]" type='text' value="<?php echo $data[$y]['INT_LOAD1'];?>"  style='border:none;width:50px;background:transparent;'></input>
                                        </td>
                                        <td <?php echo $color; ?>>
                                            <input name="tableRow[<?php echo $y; ?>][INT_LOAD2]" type='text' value="<?php echo $data[$y]['INT_LOAD2'];?>"  style='border:none;width:50px;background:transparent;'></input>
                                        </td>
                                        <td <?php echo $color; ?>>
                                            <input name="tableRow[<?php echo $y; ?>][INT_LOAD3]" type='text' value="<?php echo $data[$y]['INT_LOAD3'];?>"  style='border:none;width:50px;background:transparent;'></input>
                                        </td>
                                        <td <?php echo $color; ?>>
                                            <input name="tableRow[<?php echo $y; ?>][CHR_TEST_DATE]" type='text' value="<?php echo $date_generate; ?>"  style='border:none;width:50px;background:transparent;'></input>
                                        </td>
                                        <td <?php echo $color; ?>>
                                            <input name="tableRow[<?php echo $y; ?>][CHR_PART_NO]" type='text' value="<?php echo trim($partno); ?>"  style='border:none;width:80px;background:transparent;'></input>
                                        </td>
                                        <td <?php echo $color; ?>>
                                            <input name="tableRow[<?php echo $y; ?>][CHR_BACK_NO]" type='text' value="<?php echo trim($backno); ?>"  style='border:none;width:40px;background:transparent;'></input>
                                        </td>
                                        <td style="display:none;">
                                            <input name="tableRow[<?php echo $y; ?>][INT_FLG_SAVE]" type='text' value="<?php echo $flg_save; ?>"  style='border:none;width:50px;background:transparent;'></input>
                                        </td>

                                        <td style="display:none;"><input name="tableRow[<?php echo $y; ?>][FLG_DELETE]" type='text' value="<?php echo $data[$y]['FLG_DELETE']; ?>" readonly style='border:none;width:50px;background:transparent;'></input></td>
                                        
                                        <?php
                                         if ($data[$y]['FLG_DELETE'] == 1){
                                            $stat = "background:#FE2D45;color:#fff";
                                         }else{
                                            $stat = "background:#55D785;color:#fff";
                                        }

                                        echo "<td style='$stat;vertical-align: middle;text-align:center'><strong>".$data[$y]['ERROR_MESSAGE']."</strong></td>";
                                        
                                        echo "</tr>";
                                      
                                        $x++;
                                    }?>
                                </tbody>
                            </table> 
                        </div>

                        <div class="pull" style='margin-top:10px;'>
                            <table width="100%">
                                <tr>
                                    <td width="10%" style='text-align:left;'><strong>PDS Number</strong></td>
                                    <td width="30%" style='text-align:left;'>
                                        <input name="CHR_PDS_NO" class="form-control" required type="text" style="width: 300px;">
                                    </td>
                                    <td width="60%" style='text-align:right;'>
                                        <?php if($data_exist > 0){ ?>
                                            <button type="submit" name="submit" class="btn btn-success" id="button-save" data-toggle="tooltip" data-placement="right" title="Save this data" style="width:180px;"><i class="fa fa-check"></i> Save</button>
                                        <?php } ?>
                                        <a href="<?php echo base_url('index.php/patricia/load_tester_c/index/'. date('Ym') ) ?>" class="btn btn-default" data-toggle="tooltip" data-placement="left" title="Back">Cancel</a>
                                    </td>
                                </tr>
                            </table>
                        </div>

                    </div>

                    <?php echo form_close(); ?>

                </div>
            </div>
        </div>
    </section>
</aside>
<script src="<?php echo base_url('assets/js/jquery-1.12.3.js') ?>"></script>
<script src="<?php echo base_url('assets/js/jquery.dataTables.min.js') ?>"></script>
<script src="<?php echo base_url('assets/js/dataTables.fixedColumns.min.js') ?>"></script>
<link rel="stylesheet" href="<?php echo base_url('assets/css/fixedColumns.dataTables.min.css'); ?>" >
<script>
                                    $(document).ready(function () {
                                        var table = $('#example').DataTable({
                                            // bFilter': false
                                            scrollY: "350px",
                                            scrollX: true,
                                            scrollCollapse: true,
                                            paging: false,
                                            fixedColumns: {
                                                leftColumns: 3
                                            }
                                        });
                                    });

                                    
</script>