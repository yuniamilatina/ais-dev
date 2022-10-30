<aside class="right-side">
    <section class="content-header">
        <ol class="breadcrumb">
            <li><a href="<?php echo base_url('index.php/home_c') ?>"><span>Home</span></a></li>
            <li class="active"> <a href="<?php echo base_url('index.php/error_log_c/error_movement') ?>"><strong>Error Log Movement</strong></a></li>
        </ol>
    </section>
    <section class="content">
        <div class="row">
            <div class="col-md-12">
                <div class="grid">
                    <div class="grid-header">
                        <i class="fa fa-th-large"></i>
                        <span class="grid-title">ERROR <strong>LOG MOVEMENT</strong></span>

                    </div>
                    <div class="grid-body">
                        <table id="dataTables1" class="table table-condensed table-hover display" cellspacing="0" width="100%">
                            <thead>
                                <tr>
                                    <th>No</th>
                                    <th>Time</th>
                                    <th>User</th>
                                    <th>Action</th>
                                    <th>Data</th>
                                    <th>Object</th>
                                    <th>Application</th>
                                    <th>IP</th>
                                    <th>Application</th>
                                    <th>IP</th>
									<th>IP</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                $i = 1;
                                foreach ($data as $isi) {
                                    echo "<tr class='gradeX'>";
                                    echo "<td>$i</td>";
                                    echo "<td>" . trim($isi->CHR_DATE_UPLOAD) . "</td>";
                                    echo "<td>" . trim($isi->CHR_TIME_UPLOAD) . "</td>";
                                    echo "<td>" . trim($isi->CHR_UPLOAD) . "</td>";
                                    echo "<td>" . trim($isi->CHR_STATUS) . "</td>";
                                    echo "<td>" . trim($isi->CHR_MESSAGE) . "</td>";
                                    echo "<td>" . trim($isi->CHR_PART_NO) . "</td>";
                                    echo "<td>" . trim($isi->CHR_SLOC_FROM) . "</td>";
                                    echo "<td>" . trim($isi->CHR_SLOC_TO) . "</td>";
									echo "<td>" . trim($isi->INT_TOTAL_QTY) . "</td>";
									echo "<td>" . trim($isi->CHR_UOM) . "</td>";
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

    </section>
    <!-- END MAIN CONTENT -->
</aside>