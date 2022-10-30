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
            <li><a href=#"><span><strong>Manage Master Dies</strong></span></a></li>
        </ol>
    </section>

    <section class="content">
        <?php

        // if (validation_errors()) {
        //     echo '<div class = "alert alert-danger"><strong>WARNING !</strong>' . validation_errors() . '</div >';
        // }

        if ($msg != NULL) {
            echo $msg;
        }
        ?>

        <div class="row">
            <div class="col-md-12">
                <div class="grid">
                    <div class="grid-header">
                        <i class="fa fa-sitemap"></i>
                        <span class="grid-title"><strong>MANAGE MASTER DIES</strong></span>
                        <div class="pull-right">
                        <a href="#modal_addDies" class="btn btn-default" data-toggle="modal" data-placement="left" title="New Dies" style="height:30px;font-size:13px;width:120px;">New Dies</a>
                        </div>
                    </div>
                    <div class="grid-body">
                        <div id="table-luar">
                            <table id="dataTables1" class="table table-striped table-condensed table-hover display" cellspacing="0" width="100%">
                                <thead>
                                    <tr>
                                        <th style="text-align: center">No</th>
                                        <th style="text-align: center">Dies Code</th>
                                        <th style="text-align: center">Dies Name</th>
                                        <th style="text-align: center">Dies Desc</th>
                                        <th style="text-align: center">Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    $i = 1;
                                    foreach ($data as $isi) {
                                        echo "<tr class='gradeX'>";
                                        echo "<td style='text-align: center'>$i</td>";
                                        echo "<td style='text-align: center'>$isi->CHR_DIES_CODE</td>";
                                        echo "<td style='text-align: center'>$isi->CHR_DIES_NAME</td>";
                                        echo "<td style='text-align: center'>$isi->CHR_DIES_DESC</td>";
                                        ?>
                                        <td style='text-align: center'>
                                            <a data-toggle="modal" data-target="#modalEditDies<?php echo $isi->INT_ID; ?>" data-placement="left" data-toggle="tooltip" title="Edit Dies" class="label label-warning"><span class="fa fa-pencil"></span></a>
                                            <a href="<?php echo base_url('index.php/eng/dies_c/delete_dies') . "/" . $isi->INT_ID; ?>" class="label label-danger" data-placement="right" data-toggle="tooltip" title="Delete" onclick="return confirm('Are you sure want to delete this Dies?');"><span class="fa fa-times"></span></a>
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

                <?php foreach ($data as $isi) { ?>
                    <div class="modal fade" id="modalEditDies<?php echo trim($isi->INT_ID) ?>" tabindex="-1" role="dialog" aria-labelledby="modalprogress" aria-hidden="true" style="display: none;">

                            <div class="modal-wrapper">
                                <div class="modal-dialog">
                                    
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                                            <h4 class="modal-title" id="modalprogress"><strong>Edit Dies</strong></h4>
                                        </div>
                                        
                                        <div class="modal-body">
                                            <?php echo form_open('end/dies_c/update_dies', 'class="form-horizontal"'); ?>

                                            <input type="hidden" name="INT_ID" class="form-control" required value="<?php echo trim($isi->INT_ID) ?>" >

                                            <div class="form-group">
                                                <label class="col-sm-3 control-label">Dies Name</label>
                                                <div class="col-sm-4">
                                                    <input type="text" name="CHR_DIES_NAME" class="form-control" required value="<?php echo trim($isi->CHR_DIES_NAME) ?>" >
                                                </div>
                                            </div>

                                            <div class="form-group">
                                                <label class="col-sm-3 control-label">Dies Desc</label>
                                                <div class="col-sm-5">
                                                    <input type="text" name="CHR_DIES_DESC" class="form-control" required value="<?php echo trim($isi->CHR_DIES_DESC) ?>" >
                                                </div>
                                            </div>

                                            <div class="modal-footer">
                                                <div class="btn-group">
                                                    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                                                    <button type="submit" class="btn btn-primary" data-placement="left" data-toggle="tooltip" title="Save this data"><i class="fa fa-check"></i> Update</button>
                                                </div>
                                            </div>

                                            <?php echo form_close(); ?>

                                        </div>

                                    </div>
                                </div>
                            </div>
                    </div>
                 <?php }   ?>


            <div class="modal fade" id="modal_addDies" tabindex="-1" role="dialog" aria-labelledby="myModalLabel3" aria-hidden="true">
                <div class="modal-wrapper">
                        <div class="modal-dialog">
                            <div class="modal-content">
                                        <?php
                                            echo form_open('eng/dies_c/save_dies', 'class="form-horizontal"');
                                        ?>
                                    <div class="modal-header bg-blue">
                                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                                        <h4 class="modal-title" id="myModalLabel3"><strong>New Dies</strong></h4>
                                    </div>

                                    <div class="modal-body" >

                                        <div class="form-group">
                                            <label class="col-sm-4 control-label">Dies Code</label>
                                            <div class="col-sm-3">
                                                <input type="text" name="CHR_DIES_CODE" class="form-control" required>
                                            </div>
                                        </div>

                                        <div class="form-group">
                                            <label class="col-sm-4 control-label">Dies Name</label>
                                            <div class="col-sm-5">
                                                <input type="text" name="CHR_DIES_NAME" class="form-control" required>
                                            </div>
                                        </div>

                                        <div class="form-group">
                                            <label class="col-sm-4 control-label">Dies Desc</label>
                                            <div class="col-sm-5">
                                                <textarea name="CHR_DIES_DESC" class="form-control" rows="4" cols="50" required></textarea>
                                            </div>
                                        </div>

                                    <div class="modal-footer">
                                        <div class="btn-group">
                                            <button type="button" class="btn btn-default" data-dismiss="modal"> Close</button>
                                            <button type="submit" class="btn btn-primary"><i class="fa fa-check"></i> Submit</button>
                                        </div>
                                    </div>
                                <?php
                                    echo form_close();
                                ?>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

    </section>
</aside>


