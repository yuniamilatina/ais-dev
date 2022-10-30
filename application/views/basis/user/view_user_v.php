<aside class="right-side">
    <section class="content-header">
        <ol class="breadcrumb">
            <li><a href="<?php echo base_url('index.php/home_c/') ?>">Home</a></li>
            <li><a href="<?php echo base_url('index.php/basis/user_c/') ?>">Manage Employee</a></li>            
            <li><a href="#"><strong>View Employee</strong></a></li>
        </ol>
    </section>

    <section class="content">

        <div class="row">
            <div class="col-md-6">
                <div class="grid">
                    <div class="grid-header">
                        <i class="fa fa-user"></i>
                        <span class="grid-title"><strong><?php echo $data->CHR_USERNAME . '- ' . trim($data->CHR_NPK); ?> </strong>PROFILE</span>
                        <div class="pull-right grid-tools">
                            <a data-widget="collapse" title="Collapse"><i class="fa fa-chevron-up"></i></a>
                        </div>
                    </div>
                    <div class="grid-body">
                        <table class="table table-condensed  display" cellspacing="0" width="100%">
                            <tr><td>NPK</td><td><badge class="label label-success"><?php echo $data->CHR_NPK; ?></badge></td></tr>
                            <tr><td>Username</td><td><?php echo $data->CHR_USERNAME; ?></td></tr>
                            <tr><td>Role</td><td><?php echo $data->CHR_ROLE; ?></td></tr>
                            <tr><td>Company</td><td><?php echo $data->CHR_COMPANY_DESC; ?></td></tr>
                            <tr><td>Group Dept</td><td><?php echo $data->CHR_GROUP_DEPT; ?></td></tr>
                            <tr><td>Dept</td><td><?php echo $data->CHR_DEPT; ?></td></tr>
                            <tr><td>Section</td><td><?php echo $data->CHR_SECTION; ?></td></tr>
                            <tr><td>Sub Section</td><td><?php echo $data->CHR_SUB_SECTION; ?></td></tr>

                        </table>
                    <?php echo anchor('basis/user_c', 'Back', 'class="btn btn-default"'); ?>
                    </div>
                </div>
            </div>

            <div class="col-md-6">
                <div class="grid">
                    <div class="grid-header">
                        <i class="fa fa-user"></i>
                        <span class="grid-title"><strong>USER ACCESS</strong></span>
                        <div class="pull-right grid-tools">
                            <a data-widget="collapse" title="Collapse"><i class="fa fa-chevron-up"></i></a>
                        </div>
                    </div>
                    <div class="grid-body">
                        <table id="dataTables3" class="table table-striped table-condensed table-hover display" cellspacing="0" width="100%">
                            <thead>
                                <tr>
                                    <th>No</th>
                                    <th>Module</th>
                                    <th>Function</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                $i = 1;
                                foreach ($data_detail as $isi) {
                                    echo "<tr class='gradeX'>";
                                    echo "<td>$i</td>";
                                    echo "<td>$isi->CHR_MODULE</td>";
                                    echo "<td>$isi->CHR_FUNCTION</td>";
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
</aside>