<aside class="right-side">
    <section class="content-header">
        <ol class="breadcrumb">
            <li><a href="<?php echo base_url('index.php/home_c') ?>"><span>Home</span></a></li>
            <li class="active"> <a href="<?php echo base_url('index.php/log_c') ?>"><strong>User Logs</strong></a></li>
        </ol>
    </section>
    <section class="content">
        <div class="row">
            <div class="col-md-12">
                <div class="grid">
                    <div class="grid-header">
                        <i class="fa fa-th-large"></i>
                        <span class="grid-title">USER <strong>LOGS</strong></span>

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

                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                $i = 1;
                                foreach ($data as $isi) {
                                    echo "<tr class='gradeX'>";
                                    echo "<td>$i</td>";
                                    echo "<td>" . date('d M Y - H.i.s', strtotime('20' . $isi->CHR_TIME)) . "</td>";
                                    echo "<td>" . trim($isi->CHR_USERNAME) . "</td>";
                                    echo "<td>" . trim($isi->CHR_ACTION) . "</td>";
                                    echo "<td>" . trim($isi->CHR_DATA) . "</td>";
                                    echo "<td>" . trim($isi->CHR_OBJECT) . "</td>";
                                    echo "<td>" . ucfirst(trim($isi->CHR_APP)) . "</td>";
                                    echo "<td>" . trim($isi->CHR_CPU) . "</td>";
                                    
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