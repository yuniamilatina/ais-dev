<script type="text/javascript">
    $(document).ready(function() {
        $("#datadept").focusout(function() {
            $.ajax({
                url: "<?php echo base_url(); ?>index.php/organization/section_c/initialSection",
                data: {id: $(this).val()}, type: "POST",
                success: function(data) {
                    $("#section").val(data);
                }
            });
        });
    });
</script> 

<script type="text/javascript">
    $(document).ready(function() {
        $("#datadept").change(function() {
            $.ajax({
                url: "<?php echo base_url(); ?>index.php/organization/section_c/initialSection",
                data: {id: $(this).val()}, type: "POST",
                success: function(data) {
                    $("#section").val(data);
                }
            });
        });
    });
</script>

<aside class="right-side">
    <section class="content-header">
        <ol class="breadcrumb">
            <li><a href="<?php echo base_url('index.php/basis/home_c/') ?>">Home</a></li>
            <li><a href="<?php echo base_url('index.php/organization/section_c/') ?>">Manage Section</a></li>
            <li><a href="#"><strong>Create Section</strong></a></li>
        </ol>
    </section>

    <section class="content">
        <?php
        if (validation_errors()) {
            echo '<div class = "alert alert-danger"><strong>WARNING !</strong>' . validation_errors() . '</div >';
        }
        echo form_open('organization/section_c/save_section', 'class="form-horizontal"');
        ?>
        <div class="row">
            <div class="col-md-12">
                <div class="grid">
                    <div class="grid-header">
                        <i class="fa fa-sitemap"></i>
                        <span class="grid-title"><strong>CREATE</strong> SECTION</span>
                        <div class="pull-right grid-tools">
                            <a data-widget="collapse" title="Collapse"><i class="fa fa-chevron-up"></i></a>
                        </div>
                    </div>
                    <div class="grid-body">
                        <div class="form-group">
                            <label class="col-sm-3 control-label">Department</label>
                            <div class="col-sm-5">
                                <select name="INT_ID_DEPT" autofocus id="datadept" class="form-control" style="width:400px">
                                    <?php
                                    foreach ($data_dept as $isi) {
                                        ?>
                                        <option value="<?php echo $isi->INT_ID_DEPT; ?>"><?php echo $isi->CHR_DEPT . ' - ' . $isi->CHR_DEPT_DESC; ?></option>
                                        <?php
                                    }
                                    ?> 
                                </select> 
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-3 control-label">Section Initial</label>
                            <div class="col-sm-5" >
                                <input name="CHR_SECTION" id="section" class="form-control" maxlength="7" required type="text" style="width: 100px;text-transform: uppercase;">
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="col-sm-3 control-label">Section Description</label>
                            <div class="col-sm-5">
                                <input name="CHR_SECTION_DESC" class="form-control" maxlength="40" required type="text">
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="col-sm-3 control-label">Cost Center</label>
                            <div class="col-sm-5">
                                <select name="INT_ID_COST_CENTER" id="source" class="form-control" style="width:400px">
                                    <?php
                                    foreach ($data_costcenter as $isi) {
                                        ?>
                                        <option value="<?php echo $isi->INT_ID_COST_CENTER; ?>"><?php echo $isi->CHR_COST_CENTER . ' - ' . $isi->CHR_COST_CENTER_DESC; ?></option>
                                        <?php
                                    }
                                    ?> 
                                </select>
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="col-sm-offset-3 col-sm-5">
                                <div class="btn-group">
                                    <button type="submit" class="btn btn-primary"><i class="fa fa-check"></i> Save</button>
                                    <?php
                                    echo anchor('organization/section_c', 'Cancel', 'class="btn btn-default"');
                                    echo form_close();
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

