<aside class="right-side">

    <section class="content-header">
        <ol class="breadcrumb">
            <li><a href="<?php echo base_url('index.php/basis/home_c/'); ?>"><span>Home</span></a></li>
            <li><a href="<?php echo base_url('index.php/helpdesk_ticket/problem_type_c/'); ?>"><strong>Manage Problem Type</strong></a></li>
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
                        <i class="fa fa-th-large"></i>
                        <span class="grid-title"><strong>PROBLEM TYPE TABLE</strong></span>
                        <div class="pull-right">
                            <a href="<?php echo base_url('index.php/helpdesk_ticket/problem_type_c/create_problem_type/') ?>" class="btn btn-default" data-toggle="tooltip" data-placement="left" title="Create Problem type" style="height:30px;font-size:13px;width:100px;">Create</a>
                        </div>
                    </div>
                    <div class="grid-body">
                        <table id="dataTables1" class="table table-striped table-condensed table-hover display" cellspacing="0" width="100%">
                            <thead>
                                <tr>
                                    <th>No</th>
                                    <th>Problem Type Init</th>
                                    <th>Problem Type Desc</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>

                            <tbody>
                                <?php
                                $i = 1;
                                foreach ($data as $isi) {
                                    echo "<tr class='gradeX'>";
                                    echo "<td>$i</td>";
                                    echo "<td>$isi->CHR_PROBLEM_TYPE</td>";
                                    echo "<td>$isi->CHR_PROBLEM_TYPE_DESC</td>";
                                    ?>
                                <td>
                                    <a href="<?php echo base_url('index.php/helpdesk_ticket/problem_type_c/edit_problem_type') . "/" . $isi->INT_ID_PROBLEM_TYPE; ?>" class="label label-warning" data-placement="top" data-toggle="tooltip" title="Edit"><span class="fa fa-pencil"></span></a>
                                    <a href="<?php echo base_url('index.php/helpdesk_ticket/problem_type_c/delete_problem_type') . "/" . $isi->INT_ID_PROBLEM_TYPE; ?>" class="label label-danger" data-placement="right" data-toggle="tooltip" title="Delete" onclick="return confirm('Are you sure want to delete this helpdesk_ticket?');"><span class="fa fa-times"></span></a>
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
</aside>