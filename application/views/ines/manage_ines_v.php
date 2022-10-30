<script>
    function copythis(e) {
        var copyText = document.getElementById(e);
        copyText.select(); 
        document.execCommand("copy");
        document.getElementById("title").innerHTML = "Success copy!";
        document.getElementById("desc").innerHTML = "IP sudah dicopy";
    }
</script>

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
                        <i class="fa fa-cube"></i>
                        <span class="grid-title"><strong>MANAGE DEVICE</strong></span>
                        <div class="pull-right">
                            <a href="<?php echo base_url('index.php/ines/ines_c/create_ines/') ?>" class="btn btn-default" data-toggle="tooltip" data-placement="left" title="Create Prod Asset" style="height:30px;font-size:13px;width:100px;">Create</a>
                        </div>
                    </div>
                    <div class="grid-body">
                        <div class='alert alert-info' id="desc"><button type = 'button' class = 'close' data-dismiss = 'alert'>&times;</button><strong id='title'></strong></div >
                        <table id="example" class="table table-striped table-condensed table-hover display" cellspacing="0" width="100%">
                            <thead>
                                <tr>
                                    <th>No</th>
                                    <th style='text-align:center;'>Asset Code</th>
                                    <th style='text-align:center;'>Group Product</th>
                                    <th style='text-align:center;'>Work Center</th>
                                    <th style='text-align:center;'>Dept</th>
                                    <th style='text-align:center;'>IP Address</th>
                                    <th style='text-align:center;'>Port Address</th>
                                    <th style='text-align:center;'>URL Address</th>
                                    <th style='text-align:center;'>Usage</th>
                                    <th>Actions</th>

                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                $i = 1;
                                foreach ($data as $isi) {
                                    $a = NULL;
                                    if($isi->CHR_USAGE=='INES'){
                                        $a = $isi->CHR_WORK_CENTER;
                                    }
                                    echo "<tr class='gradeX'>";
                                    echo "<td>$i</td>";
                                    echo "<td style='text-align:left;'>$isi->CHR_ASSET_CODE</td>";
                                    echo "<td style='text-align:center;'>$isi->CHR_GROUP_PRODUCT</td>";
                                    echo "<td style='text-align:center;'>$isi->CHR_WORK_CENTER</td>";
                                    echo "<td style='text-align:center;'>$isi->CHR_DEPT</td>";
                                    echo "<td style='text-align:center;' class='bg-green'><input style='border: none;width:85px;outline: none;' class='bg-green' type='text' id='".$isi->INT_ID."' value='".trim($isi->CHR_IP)."' onclick='copythis(".$isi->INT_ID.");'/></td>";
                                    echo "<td style='text-align:left;'>$isi->CHR_PORT</td>";
                                    echo "<td style='text-align:left;'>$isi->CHR_URL$a</td>";
                                    echo "<td style='text-align:left;'>$isi->CHR_USAGE</td>";
                                    ?>
                                <td>
                                    <a href="<?php echo base_url('index.php/ines/ines_c/edit_ines') . "/" . $isi->INT_ID; ?>" class="label label-warning" data-placement="top" data-toggle="tooltip" title="Edit"><span class="fa fa-pencil"></span></a>
                                    <a href="<?php echo base_url('index.php/ines/ines_c/delete_ines') . "/" . $isi->INT_ID ?>" class="label label-danger" data-placement="right" data-toggle="tooltip" title="Delete" onclick="return confirm('Are you sure want to delete this asset In line Scan?');"><span class="fa fa-times"></span></a>
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

<script src="<?php echo base_url('assets/js/jquery-1.12.3.js') ?>"></script>
<script src="<?php echo base_url('assets/js/jquery.dataTables.min.js') ?>"></script>
<script src="<?php echo base_url('assets/js/dataTables.fixedColumns.min.js') ?>"></script>
<script>
    $(document).ready(function() {

        var table = $('#example').DataTable({
            scrollY: "500px",
            scrollX: true,
            scrollCollapse: true,
            paging: true,
            
            fixedColumns: {
                leftColumns: 4
            }
        });


    });
</script>
<!-- dataTables3, -->



