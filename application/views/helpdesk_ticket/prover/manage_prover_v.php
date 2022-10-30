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
        text-align: center;
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
            <li><a href="<?php echo base_url('index.php/basis/home_c/'); ?>"><span>Home</span></a></li>
            <li><a href="<?php echo base_url('index.php/helpdesk_ticket/prover_c/'); ?>"><strong>Manage Problem Solver</strong></a></li>
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
                        <i class="fa fa-user"></i>
                        <span class="grid-title"><strong>PROBLEM SOLVER</strong></span>
                        <div class="pull-right">
                            <a href="<?php echo base_url('index.php/helpdesk_ticket/prover_c/create_prover/') ?>" class="btn btn-default" data-toggle="tooltip" data-placement="left" title="Create Problem Solver" style="height:30px;font-size:13px;width:100px;">Create</a>
                        </div>
                    </div>
                    <div class="grid-body">
                        <div id="table-luar">
                            <table id="dataTables1" class="table table-striped table-condensed table-hover display" cellspacing="0" width="100%">
                                <thead>
                                    <tr>
                                        <th class='td-no'>No</th>
                                        <th class='td-no'>NPK</th>
                                        <th class='td-no'>Problem Solver</th>
                                        <th class='td-no'>Problem Solver Desc</th>
                                        <th class='td-no'>Actions</th>
                                    </tr>
                                </thead>

                                <tbody>
                                    <?php
                                    $i = 1;
                                    foreach ($data as $isi) {
                                        echo "<tr class='gradeX'>";
                                        echo "<td>$i</td>";
                                        echo "<td class='td-no'>$isi->CHR_NPK</td>";
                                        echo "<td class='td-no'>$isi->CHR_PROVER</td>";
                                        echo "<td>$isi->CHR_PROVER_DESC</td>";
                                        ?>
                                    <td class='td-no'>
                                        <a href="<?php echo base_url('index.php/helpdesk_ticket/prover_c/view_detail_prover') . "/" . $isi->INT_ID_PROVER; ?>" class="label label-success" data-placement="left" data-toggle="tooltip" title="View"><span class="fa fa-check"></span></a>
                                        <a href="<?php echo base_url('index.php/helpdesk_ticket/prover_c/edit_prover') . "/" . $isi->INT_ID_PROVER; ?>" class="label label-warning" data-placement="top" data-toggle="tooltip" title="Edit"><span class="fa fa-pencil"></span></a>
                                        <a href="<?php echo base_url('index.php/helpdesk_ticket/prover_c/delete_prover') . "/" . $isi->INT_ID_PROVER; ?>" class="label label-danger" data-placement="right" data-toggle="tooltip" title="Delete" onclick="return confirm('Are you sure want to delete this helpdesk_ticket?');"><span class="fa fa-times"></span></a>
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
        </div>

    </section>
</aside>