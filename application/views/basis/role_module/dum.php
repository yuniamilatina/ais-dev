

<script>

</script>
<aside class="right-side">
    <section class="content-header">
        <ol class="breadcrumb">
            <li><a href="<?php echo base_url('index.php/budget/home_c"') ?>"><span>Home</span></a></li>
            <li><a href="<?php echo base_url('index.php/role_module_c"') ?>">Manage Role Module</a></li>
            <li><a href="<?php echo base_url('index.php/role_module_c/create_role"') ?>"><strong>Create Role</strong></a></li>
        </ol>
    </section>

    <section class="content">

        <div class="row">
            <div class="grid">
                <div class="grid-header">
                    <i class="fa fa-th-large"></i>
                    <span class="grid-title">Create <strong>ROLE</strong></span>

                </div>
                <div class="grid-body">
                    <?php echo form_open('budget/role_module_c/save_role', 'class="form-horizontal"'); ?>

                    <?php
                    echo '<table class="table table-striped table-condensed table-hover display" cellspacing="0" width="100%">
                        <thead>
                            <tr>   
                                <th></th>
                                <th>Applications</th>
                                <th>Modules</th>
                                <th>Functions</th>
                            </tr>
                        </thead>
                        <tbody>';
                    ?>

                    <?php
                    $i = 1;


                    foreach ($all_app as $data_app) {
                        echo "<tr class='gradeX'>";
                        echo "<td>".$i."</td>";
                        echo "<td>" . ucfirst(strtolower($data_app->CHR_APP)) . "</td>";
                        echo "<td>";
                        foreach ($all_module as $data_module) {
                            echo "<p>".$data_module->CHR_MODULE."</p>";
                        }
                        echo "</td>";
                        $i++;
                    }
                    echo '</tbody>
                    </table>';
                    ?>




                    <div class="form-group">
                        <label class="col-sm-1 control-label">Role</label>
                        <div class="col-sm-3">
                            <input name="CHR_ROLE" autofocus class="form-control" maxlength="20" required type="text">
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="col-sm-1 control-label">Modules</label>
                        <div class="col-sm-3">
                            <select name="INT_ID_FUNCTION[]" multiple id="e2" class="form-control" style="width:240px">

                                <?php
                                foreach ($module as $module_data) {
                                    echo '<optgroup label="' . $module_data->CHR_MODULE . '">';
                                    foreach ($function as $function_data) {
                                        if ($module_data->INT_ID_MODULE == $function_data->INT_ID_MODULE) {
                                            ?>
                                            <option value="<?php echo $function_data->INT_ID_FUNCTION; ?>"><?php echo $function_data->CHR_FUNCTION; ?></option>
                                            <?php
                                        }
                                    }
                                    echo '</optgroup>';
                                }
                                ?> 

                            </select>
                        </div>
                    </div>


                    <div class="form-group text-center">
                        <div class="btn-group">
                            <button type="submit" class="btn btn-primary"><i class="fa fa-check"></i> Save</button>
                            <?php echo anchor('budget/role_module_c', 'Cancel', 'class="btn btn-default"'); ?>

                        </div>
                    </div>

                    <?php echo form_close(); ?>
                </div>
            </div>

        </div>

    </section>
</aside>