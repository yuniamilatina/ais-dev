<aside class="right-side">
    <section class="content-header">
        <ol class="breadcrumb">
            <li><a href="<?php echo base_url('index.php/basis/home_c/"') ?>"><span>Home</span></a></li>
            <li> <a href="#"><strong>App Control</strong></a></li>
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
                        <i class="fa fa-sitemap"></i>
                        <span class="grid-title"><strong>LIST APPLICATION CONTROL</strong></span>
                        <div class="pull-right">
                            <button class="btn btn-primary" data-toggle="modal" title="Update Data" data-target="#modalPrimary">Upload SAP Data</button>
                        </div>
                    </div>
                    <div class="grid-body">
                        <table id="dataTables1" class="table table-striped table-condensed table-hover display" cellspacing="0" width="100%">
                            <thead>
                                <tr>
                                    <th rowspan="2" style="vertical-align: middle;text-align:center;">No</th>
                                    <th rowspan="2" style="vertical-align: middle;text-align:center;">Posting Date</th>
                                    <th rowspan="2" style="vertical-align: middle;text-align:center;">PDS No</th>
                                    <th rowspan="2" style="vertical-align: middle;text-align:center;">Part No</th>
                                    <th colspan="2" style="vertical-align: middle;text-align:center;">3rd Part Qty</th>
                                    <th colspan="2" style="vertical-align: middle;text-align:center;">SAP Qty</th>
                                    <th colspan="2" style="vertical-align: middle;text-align:center;">Different</th>                                   
                                </tr>
                                <tr>
                                    <th style="vertical-align: middle;text-align:center;">OK</th>
                                    <th style="vertical-align: middle;text-align:center;">NG</th>
                                    <th style="vertical-align: middle;text-align:center;">OK</th>
                                    <th style="vertical-align: middle;text-align:center;">NG</th>
                                    <th style="vertical-align: middle;text-align:center;">OK</th>
                                    <th style="vertical-align: middle;text-align:center;">NG</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                $i = 1;
                                foreach ($data as $isi) {
                                   
                                    echo "<tr class='gradeX' style=text-align:center;>";
                                    echo "<td>$i</td>";
                                    echo "<td>$isi->CHR_DATE</td>";
                                    echo "<td>-</td>";
                                    echo "<td>$isi->CHR_PART_NO</td>";
                                    echo "<td>$isi->INT_TOTAL_QTY_AIS</td>";
                                    echo "<td>$isi->INT_TOTAL_NG_AIS</td>";
                                    echo "<td>$isi->INT_TOTAL_QTY_SAP</td>";
                                    echo "<td>$isi->INT_TOTAL_NG_SAP</td>";
                                    $diff_ok = $isi->INT_TOTAL_QTY_SAP - $isi->INT_TOTAL_QTY_AIS;
                                    $diff_ng = $isi->INT_TOTAL_NG_SAP - $isi->INT_TOTAL_NG_AIS;
                                    if ($diff_ok == 0) {
                                        echo "<td>$diff_ok</td>";
                                    }
                                    else {
                                        echo "<td style=background-color:orange;>$diff_ok</td>";
                                    }
                                    if ($diff_ok == 0) {
                                        echo "<td>$diff_ng</td>";
                                    }
                                    else {
                                        echo "<td style=background-color:orange;>$diff_ng</td>";
                                    }
                                    ?>
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
        
        <div class="modal fade" id="modalPrimary" tabindex="-1" role="dialog" aria-labelledby="myModalLabel2" aria-hidden="true">
            <div class="modal-wrapper">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <form class="form-horizontal" method="post"  role="form" action="<?php echo base_url('index.php/app_control/app_control_c/upload_data'); ?>"  enctype="multipart/form-data" role="form">
                            <div class="modal-header">
                                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                                <h4 class="modal-title" id="myModalLabel2" >Upload SAP Data</h4>
                            </div>
                            <div class="modal-body" >
                                <div class="form-group" style="text-align:center;">
                                    <span style="text-align:center;"><a href="<?php echo base_url('index.php/app_control/app_control_c/generate_template'); ?>">Download Template</a></span>
                                </div>
                                <div class="form-group">
                                    <label class="col-sm-3 control-label">Upload File</label>
                                    <div class="col-sm-7">
                                        <input type="file" class="form-control" name="import_data" id="import_data" size="20" value="">
                                    </div>
                                </div>
                            </div>
                            <div class="modal-footer">
                                <div class="btn-group">
                                    <button type="button" class="btn btn-default" data-dismiss="modal"> Close</button>
                                    <button class="btn btn-primary" value="1" name="upload_button"> Upload</button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>

    </section>
</aside>


