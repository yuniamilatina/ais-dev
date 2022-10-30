<style type="text/css">
    th, td { white-space: nowrap; }
    div.dataTables_wrapper {
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
    .td-no{
        width: 10px;
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
            <li> <a href="#"><strong>Upload WO</strong></a></li>
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
                        <i class="fa fa-upload"></i>
                        <span class="grid-title"><strong>UPLOAD WO</strong></span>
                        <div class="pull-right grid-tools">
                            <a href="<?php echo base_url('index.php/mte/preventive_schedule_c/generate_template'); ?>" data-toggle="tooltip" data-placement="right" title="Download template"><i class="fa fa-download"></i>&nbsp; Download template</a>
                        </div>
                    </div>
                    <div class="grid-body">
                        <?php echo form_open_multipart('mte/preventive_schedule_c/upload_wo', 'class="form-horizontal"');?>
                        <div class="pull" style="margin-top: -15px;">
                            <table width="100%" id='filter' border=0>
                                <tr>
                                <td width="10%" style='text-align:left;' ><strong>File (.xlsx)</strong></td>
                                    <td width="27%" style='text-align:left;' colspan="3">
                                        <input type="file" name="data_wo" class="form-control" id="import"> 
                                    </td>
                                    <td width="43%">
                                        <button style="margin-left:-5px;margin-top:4px;" type="submit" name="submit" class="btn btn-primary" data-toggle="tooltip" data-placement="right" title="Lets Processing data"><i class="fa fa-upload"></i> Upload</button>
                                    </td>
                                    <td width="10%" style='text-align:right;'> </td>
                                    <td width="10%" style='text-align:right;'> </td>
                            </table>
                        </div>
                        <?php echo form_close(); ?>
                        <div id="table-luar">
                            <table id="dataTables1" class="table table-striped table-condensed table-hover display" cellspacing="0" width="100%">
                                <thead>
                                    <tr>
                                        <th>No</th>
                                        <th style='text-align:center;'>Periode</th>
                                        <th style='text-align:center;'>Part Code</th>
                                        <th style='text-align:center;'>Model</th>
                                        <th style='text-align:center;'>Quantity WO /month</th>

                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    $i = 1;
                                    foreach ($data as $isi) {
                                        echo "<tr class='gradeX'>";
                                        echo "<td>$i</td>";
                                        echo "<td style='text-align:center;'>$isi->CHR_PERIODE</td>";
                                        echo "<td style='text-align:center;'>$isi->CHR_PART_CODE</td>";
                                        echo "<td style='text-align:center;'>$isi->CHR_MODEL</td>";
                                        echo "<td style='text-align:center;'>$isi->INT_QTY_WO</td>";
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
            </div>
        </div>
    </section>
</aside>