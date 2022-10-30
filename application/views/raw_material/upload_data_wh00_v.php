<aside class="right-side">

    <section class="content-header">
        <ol class="breadcrumb">
            <li><a href="<?php echo base_url('index.php/basis/home_c/'); ?>"><span>Home</span></a></li>
            <li><a href=""><strong>UPLOAD DATA WH00</strong></a></li>
        </ol>
    </section>

    <section class="content">
        <?php
        if ($msg != NULL) {
            echo $msg;
        }
        ?>

        <div class="row">
            <!-- BEGIN LIVE CHART -->
            <div class="col-md-12">
                <div class="grid">
                    <div class="grid-header">
                        <i class="fa fa-th-large"></i>
                        <span class="grid-title">Table Data WH00</span>
                        <div class="pull-right grid-tools">
                            <?php echo anchor("raw_material/raw_material_c/download", "Download Template Excel") ?>
                        </div>
                    </div>
                    <div class="grid-body">
                        <div class="pull">
                            <!--<form method="post" action='insert_temp_data_raw_material' class="form-horizontal" enctype="multipart/form-data" role="form">-->
                            <?php echo form_open_multipart('raw_material/raw_material_c/insert_temp_data_raw_material', 'class="form-horizontal"'); ?>

                            <div class="form-group" >
                                <label class="col-sm-2 control-label">Pilih File (.xls/.xlsx) :</label>
                                <div class="col-sm-4">
                                    <input type="file" name="import" class="form-control" maxlength="6" id="import" value="">
                                </div>
                                <button type="submit" name="submit" class="btn btn-primary" data-toggle="tooltip" data-placement="right" title="Lets Processing data"><i class="fa fa-refresh"></i> Processing Data</button>
                            </div>

                            </form>
                        </div>

                        <?php
                        echo form_open('raw_material/raw_material_c/upload_data_raw_material', 'class="form-horizontal"');
                        ?>

                        <table id="dataTables3" class="table table-condensed table-bordered table-striped table-hover display" cellspacing="0" width="100%">
                            <thead>
                                <tr class='gradeX'>
                                    <th style="vertical-align: middle">No</th>
                                    <th style="vertical-align: middle">Part Number</th>
                                    <th style="vertical-align: middle">GR RM</th>
                                    <th style="vertical-align: middle">MOVE RM</th>
                                    <th style="vertical-align: middle">SALDO AKHIR RM</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                $r = 1;
                                $session = $this->session->all_userdata();
                                foreach ($temp_data_wh00 as $isi) {

                                    echo "<tr class='gradeX'>";
                                    echo "<td style=text-align:center;>$r</td>";
                                    echo "<td style=text-align:center;>$isi->CHR_PART_NUMBER</td>";
                                    echo "<td style=text-align:center;>$isi->INT_GR_RM</td>";
                                    echo "<td style=text-align:center;>$isi->INT_MOVE_RM</td>";
                                    echo "<td style=text-align:center;>$isi->INT_SALDO_AKHIR_RM</td>";
                                    echo "</tr>";

                                    $r++;
                                }
                                ?>

                            </tbody>
                        </table>


                    </div>

                    <div class="grid-header">                        
                        <div class="pull-left">
                            <div class="form-group">
                                <div class="btn-group">
                                    <input name="INT_DATE" value="<?php echo $date ?>" type="hidden">
                                    <?php if ($exists == 1) { ?>
                                        <button type="submit" name="submit" class="btn btn-success" data-toggle="tooltip" data-placement="right" title="Upload this data"><i class="fa fa-upload"></i> Upload</button>
                                    <?php } else { ?>
                                        <button type="submit" name="submit" disabled="disabled" class="btn btn-success" data-toggle="tooltip" data-placement="right" title="Upload this data"><i class="fa fa-upload"></i> Upload</button>
                                    <?php } ?>

                                    <?php echo form_close(); ?>
                                </div>
                            </div>
                        </div>
                    </div>

                </div>
            </div>
        </div>


    </section>
</aside>
