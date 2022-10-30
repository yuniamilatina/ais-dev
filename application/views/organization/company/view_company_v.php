<aside class="right-side">
    <section class="content-header">
        <ol class="breadcrumb">
            <li><a href="<?php echo base_url('index.php/basis/home_c/') ?>">Home</a></li>
            <li><a href="<?php echo base_url('index.php/organization/company_c/') ?>">Manage Company</a></li>            
            <li><a href="#"><strong>View Company</strong></a></li>
        </ol>
    </section>

    <section class="content">
        <?php
        if ($msg != NULL) {
            echo $msg;
        }
        echo form_open('organization/company_c/moving_company', 'class="form-horizontal" name=form3');
        ?>

        <div class="row">
            <div class="col-md-12">
                <div class="grid">
                    <div class="grid-header">
                        <i class="fa fa-university"></i>
                        <span class="grid-title"><strong><?php echo $data->CHR_COMPANY; ?></strong> COMPANY </span>
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
                                    <th>Division Initial</th>
                                    <th>Division Description</th>

                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                $i = 1;
                                foreach ($data_division as $isi) {
                                    echo "<tr class='gradeX'>";
                                    echo '<td><input class="icheck" type="checkbox" id="select" name="case[]" value="' . $isi->INT_ID_DIVISION . '"></input></td>';
                                    echo "<td>$i</td>";
                                    echo "<td>$isi->CHR_DIVISION</td>";
                                    echo "<td>$isi->CHR_DIVISION_DESC</td>";
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
                        <input type="hidden" name="INT_ID_COMPANY" value="<?php echo $data->INT_ID_COMPANY; ?>">
                        <div class="form-group">
                            <div class="col-sm-2">
                                <select name="INT_ID_COMPANY_NEW" class="ddl" data-toggle="tooltip" data-placement="right" title="Choose company to move" style="width:200px;">
                                    <?php
                                    foreach ($data_company as $isi) {
                                        if ($data->INT_ID_COMPANY == $isi->INT_ID_COMPANY) {
                                            ?> 
                                            <option selected="true" value="<?php echo $isi->INT_ID_COMPANY; ?>"><?php echo $isi->CHR_COMPANY . ' - ' . $isi->CHR_COMPANY_DESC; ?></option>
                                        <?php } else { ?>
                                            <option value="<?php echo $isi->INT_ID_COMPANY; ?>"><?php echo $isi->CHR_COMPANY . ' - ' . $isi->CHR_COMPANY_DESC; ?></option>
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
                                    echo anchor('organization/company_c', 'Back', 'class="btn btn-default"');
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