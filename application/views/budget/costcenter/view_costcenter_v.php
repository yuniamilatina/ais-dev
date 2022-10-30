<aside class="right-side">
    <section class="content-header">
        <ol class="breadcrumb">
            <li><a href="<?php echo base_url('index.php/basis/home_c/"') ?>">Home</a></li>
            <li><a href="<?php echo base_url('index.php/budget/costcenter_c/"') ?>">Manage Cost Center</a></li>            
            <li><a href="#"><strong>View Cost Center</strong></a></li>
        </ol>
    </section>

    <section class="content">
        <?php
        if ($msg != NULL) {
            echo $msg;
        }
        echo form_open('budget/costcenter_c/moving_costcenter', 'class="form-horizontal"');
        ?>

        <div class="row">
            <div class="col-md-12">
                <div class="grid">
                    <div class="grid-header">
                        <i class="fa fa-users"></i>
                        <span class="grid-title"><strong> <?php echo $data->CHR_COST_CENTER_DESC ?></strong> COST CENTER</span>
                        <div class="pull-right grid-tools">
                            <a data-widget="collapse" title="Collapse"><i class="fa fa-chevron-up"></i></a>
                        </div>
                    </div>
                    <div class="grid-body">
                        <table id="dataTables1" class="table table-condensed table-hover display" cellspacing="0" width="100%">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>No</th>
                                    <th>Section Initial</th>
                                    <th>Section Description</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                $i = 1;
                                foreach ($data_section as $isi) {
                                    echo "<tr class='gradeX'>";
                                    echo '<td><input class="icheck" type="checkbox" id="select" name="case[]" value="' . $isi->INT_ID_SECTION . '"></input></td>';
                                    echo "<td>$i</td>";
                                    echo "<td>$isi->CHR_SECTION</td>";
                                    echo "<td>$isi->CHR_SECTION_DESC</td>";
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
                        <input type="hidden" name="INT_ID_COST_CENTER" value="<?php echo $data->INT_ID_COST_CENTER; ?>">
                        <div class="form-group">
                            <div class="col-sm-2">
                                <select  name="INT_ID_COST_CENTER_NEW" class="ddl" data-toggle="tooltip" data-placement="right" title="Choose cost center to move" style="width:250px;">
                                    <?php
                                    foreach ($data_costcenter as $isi) {
                                        if ($data->INT_ID_COST_CENTER === $isi->INT_ID_COST_CENTER) {
                                            ?> 
                                            <option selected="true" value="<?php echo $isi->INT_ID_COST_CENTER; ?>"><?php echo $isi->CHR_COST_CENTER . ' - ' . $isi->CHR_COST_CENTER_DESC; ?></option>
                                        <?php } else { ?>
                                            <option value="<?php echo $isi->INT_ID_COST_CENTER; ?>"><?php echo $isi->CHR_COST_CENTER . ' - ' . $isi->CHR_COST_CENTER_DESC; ?></option>
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
                                    <button type="submit" name="submit" class="btn btn-primary" onclick="return confirm('Are you sure want to moving this sections?');"><i class="fa fa-refresh"></i> Move</button>
                                    <?php echo anchor('budget/costcenter_c', 'Back', 'class="btn btn-default"'); ?>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </section>
</aside>

