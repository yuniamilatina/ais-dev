
<aside class="right-side">
    <section class="content-header">
        <ol class="breadcrumb">
            <li><a href="<?php echo base_url('index.php/home_c/"') ?>">Home</a></li>
            <li><a href="<?php echo base_url('index.php/organization/division_c/"') ?>">Manage Division</a></li>            
            <li><a href="#"><strong>View Division</strong></a></li>
        </ol>
    </section>

    <section class="content">
        <?php
        if ($msg != NULL) {
            echo $msg;
        }
        echo form_open('organization/division_c/moving_division', 'class="form-horizontal" name=form3');
        ?>

        <div class="row">
            <div class="col-md-12">
                <div class="grid">
                    <div class="grid-header">
                        <i class="fa fa-sitemap"></i>
                        <span class="grid-title"><strong><?php echo strtoupper($data->CHR_DIVISION); ?></strong> DIVISION </span>
                        <div class="pull-right grid-tools">
                            <a data-widget="collapse" title="Collapse"><i class="fa fa-chevron-up"></i></a>
                        </div>
                    </div>
                    <div class="grid-body">
                        <table id="dataTables1" class="table table-striped table-condensed table-hover display" cellspacing="0" width="100%">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>No</th>
                                    <th>Group Department Initial</th>
                                    <th>Group Department Description</th>

                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                $i = 1;
                                foreach ($data_groupdept as $isi) {
                                    echo "<tr class='gradeX'>";
                                    echo '<td><input class="icheck" type="checkbox" id="select" name="case[]" value="' . $isi->INT_ID_GROUP_DEPT . '"></input></td>';
                                    echo "<td>$i</td>";
                                    echo "<td>$isi->CHR_GROUP_DEPT</td>";
                                    echo "<td>$isi->CHR_GROUP_DEPT_DESC</td>";
                                    ?>
                                    </tr>
                                    <?php
                                    $i++;
                                }
                                ?>
                            </tbody>
                        </table>
                    </div>

                    <div class="grid-body">
                        <input type="hidden" name="INT_ID_DIVISION" value="<?php echo $data->INT_ID_DIVISION; ?>">
                        <div class="form-group">
                            <div class="col-sm-2">
                                <select  name="INT_ID_DIVISION_NEW" class="ddl" data-toggle="tooltip" data-placement="right" title="Choose division to move" style="width:250px">
                                    <?php
                                    foreach ($data_division as $isi) {
                                        if ($data->INT_ID_DIVISION === $isi->INT_ID_DIVISION) {
                                            ?> 
                                            <option selected="true" value="<?php echo $isi->INT_ID_DIVISION; ?>"><?php echo $isi->CHR_DIVISION . ' - ' . $isi->CHR_DIVISION_DESC; ?></option>
                                        <?php } else { ?>
                                            <option value="<?php echo $isi->INT_ID_DIVISION; ?>"><?php echo $isi->CHR_DIVISION . ' - ' . $isi->CHR_DIVISION_DESC; ?></option>
                                            <?php
                                        }
                                    }
                                    ?> 
                                </select>
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="col-sm-2">
                                <div class="btn-group">
                                    <button type="submit" name="submit" class="btn btn-primary" onclick="return confirm('Are you sure want to moving this group managers?');"><i class="fa fa-refresh"></i> Move</button>
                                    <?php
                                    echo anchor('organization/division_c', 'Back', 'class="btn btn-default"');
                                    echo form_close()
                                    ?>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </section>
</aside>