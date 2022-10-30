<aside class="right-side">
    <section class="content-header">
        <ol class="breadcrumb">
            <li><a href="<?php echo base_url('index.php/basis/home.c') ?>">Home</a></li>
            <li><a href="">Confirm Master Schedule Delivery</a></li>
        </ol>
    </section>

    <section class="content">
        <?php
        if (validation_errors()) {
            echo '<div class = "alert alert-danger"><strong>WARNING !</strong>' . validation_errors() . '</div >';
        }
        ?>
        <form method="post" class="form-horizontal" enctype="multipart/form-data" role="form">
            <div class="row">
                <div class="col-md-12">
                    <div class="grid">
                        <div class="grid-header">
                            <i class="fa fa-university"></i>
                            <span class="grid-title"><strong>Confirm</strong> Master Schedule Delivery </span>
                            <div class="pull-right grid-tools">
                                <a data-widget="collapse" title="Collapse"><i class="fa fa-chevron-up"></i></a>
                            </div>
                            <div class="pull-right grid-tools">
                                <div class="btn-group">
                                    <button type="submit" class="btn btn-primary" name="btn-confirm" value="1"><i class="fa fa-check"></i> Save</button>                                    
                                    <?php
                                    echo anchor('delivery/master_schedule_cust_c/index', 'Cancel', 'class="btn btn-default"');
                                    ?>
                                </div>
                            </div>
                        </div>
                        <div class="grid-body">
                            <div class="grid-body">
                                <div class="alert alert-info">
                                    <strong>Information!</strong> Periksa kembali data Anda apakah sudah sesuai dengan data yang akan diupload.
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="row">
                <!-- BEGIN RESPONSIVE TABLE -->
                <div class="col-md-12">
                    <div class="grid no-border">
                        <div class="grid-header">
                            <i class="fa fa-table"></i>
                            <span class="grid-title">Upload Data</span>
                            <div class="pull-right grid-tools">
                                <a data-widget="collapse" title="Collapse"><i class="fa fa-chevron-up"></i></a>
                                <a data-widget="reload" title="Reload"><i class="fa fa-refresh"></i></a>
                                <a data-widget="remove" title="Remove"><i class="fa fa-times"></i></a>
                            </div>
                        </div>
                        <div class="grid-body">
                            <div class="table-responsive">
                                <table class="table table-striped">
                                    <thead>
                                        <tr class='gradeX'>
                                            <th style="vertical-align: middle; text-align: center">No</th>
                                            <th style="vertical-align: middle; text-align: center">Customer</th>
                                            <th style="vertical-align: middle; text-align: center">Customer Desc</th>
                                            <th style="vertical-align: middle; text-align: center">Customer Address</th>
                                            <th style="vertical-align: middle; text-align: center">Dist Channel</th>
                                            <th style="vertical-align: middle; text-align: center">Cycle</th>
                                            <th style="vertical-align: middle; text-align: center">Dock</th>
                                            <th style="vertical-align: middle; text-align: center">Route</th>
                                            <th style="vertical-align: middle; text-align: center">Logistic Vendor</th>
                                            <th style="vertical-align: middle; text-align: center">AII Arrival</th>
                                            <th style="vertical-align: middle; text-align: center">AII Departure</th>
                                            <th style="vertical-align: middle; text-align: center">Cust Arrival</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php
                                        $no = 1;
                                        if (count($schedule) > 0) {
                                            foreach ($schedule as $isi) {
                                                echo "<tr class='gradeX'>";
                                                echo "<td style=text-align:center;>$no</td>";
                                                echo "<td>$isi->CHR_CUST</td>";
                                                echo "<td>$isi->CHR_CUST_DESC</td>";
                                                echo "<td>$isi->CHR_CUST_ADDRESS</td>";
                                                if($isi->CHR_DIS_CHANNEL == 'C1'){
                                                    echo "<td style=text-align:center;>C1 - OEM</td>";
                                                } else if($isi->CHR_DIS_CHANNEL == 'C2'){
                                                    echo "<td style=text-align:center;>C2 - AM</td>";
                                                } else if($isi->CHR_DIS_CHANNEL == 'C3'){
                                                    echo "<td style=text-align:center;>C3 - TRIAL</td>";
                                                } else {
                                                    echo "<td style=text-align:center;>C4 - OTHER</td>";
                                                } 
                                                echo "<td style=text-align:center;>$isi->INT_CYCLE</td>";
                                                echo "<td style=text-align:center;>$isi->CHR_CUST_DOCK</td>";
                                                echo "<td style=text-align:center;>$isi->CHR_ROUTE</td>";
                                                echo "<td style=text-align:center;>$isi->CHR_LOG_VENDOR</td>";
                                                echo "<td style=text-align:center;>" . substr($isi->CHR_AII_ARRIVAL,0,2) . ":" . substr($isi->CHR_AII_ARRIVAL,2,2) . "</td>";
                                                echo "<td style=text-align:center;>" . substr($isi->CHR_AII_DEPARTURE,0,2) . ":" . substr($isi->CHR_AII_DEPARTURE,2,2) . "</td>";
                                                echo "<td style=text-align:center;>" . substr($isi->CHR_CUST_ARRIVAL,0,2) . ":" . substr($isi->CHR_CUST_ARRIVAL,2,2) . "</td>";
                                                echo "</tr>";
                                            $no++;
                                            }
                                        }
                                        ?>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- END RESPONSIVE TABLE -->
            </div>
    </section>
</aside>