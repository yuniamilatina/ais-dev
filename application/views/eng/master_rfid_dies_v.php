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
        width: 30px;
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
            <li><a href="<?php echo base_url('index.php/basis/home_c/"') ?>"><span>Home</span></a></li>
            <li><a href=#"><span><strong>Manage Master RFID Dies</strong></span></a></li>
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
                        <span class="grid-title"><strong>MANAGE</strong> MASTER MODEL RFID DIES</span>
                        <div class="pull-right">
                        <a href="<?php echo base_url('index.php/eng/dies_c/create_master_rfid_dies/"') ?>" class="btn btn-default" data-toggle="tooltip" data-placement="left" title="Create Model Twist" style="height:30px;font-size:13px;width:100px;">Create</a>
                        </div>
                    </div>
                    <div class="grid-body">
                        <div id="table-luar">
                            <table id="dataTables1" class="table table-striped table-condensed table-hover display" cellspacing="0" width="100%">
                                <thead>
                                    <tr>
                                        <th style="text-align: center">No</th>
                                        <th style="text-align: center">Create Date</th>
                                        <th style="text-align: center">Part Number</th>
                                        <th style="text-align: center">Back Number</th>
                                        <th style="text-align: center">Part Marking</th>
                                        <!-- <th style="text-align: center">ID Part Dies</th> -->
                                        <th style="text-align: center">Dies Code</th>
                                        <th style="text-align: center">RFID Code</th>
                                        <th style="text-align: center">Action</th>
                                        <!-- <th>Type Kanban</th> -->
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    $i = 1;
                                    foreach ($data as $isi) {
                                        echo "<tr class='gradeX'>";
                                        echo "<td style='text-align: center'>$i</td>";
                                        echo "<td style='text-align: center'>$isi->CREATE_DATE</td>";
                                        echo "<td style='text-align: center'>$isi->CHR_PART_NO</td>";
                                        echo "<td style='text-align: center'>$isi->CHR_BACK_NO</td>";
                                        echo "<td style='text-align: center'>$isi->CHR_PART_MODEL</td>";
                                        // echo "<td style='text-align: center'>$isi->INT_ID_PART_DIES</td>";
                                        echo "<td style='text-align: center'>$isi->CHR_DIES_CODE</td>";
                                        echo "<td style='text-align: center'>$isi->CHR_RFID_CODE</td>";
                                        ?>
                                        <td style='text-align: center'>
                                            <a href="<?php echo base_url('index.php/eng/dies_c/edit_master_rfid_dies') . "/" . $isi->CHR_PART_NO; ?>" class="label label-warning" data-placement="top" data-toggle="tooltip" title="Edit"><span class="fa fa-pencil"></span></a>
                                            <a href="<?php echo base_url('index.php/eng/dies_c/delete_master_rfid_dies') . "/" . $isi->CHR_PART_NO; ?>" class="label label-danger" data-placement="right" data-toggle="tooltip" title="Delete" onclick="return confirm('Are you sure want to delete this Model?');"><span class="fa fa-times"></span></a>
                                        </td
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


