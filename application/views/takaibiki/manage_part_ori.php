<script>
    $(document).ready(function() {


        var myVar = setInterval(function() {
            $("#hide-sub-menus").click();
            clearInterval(myVar)
        }, 0.5);

<?php foreach ($master_part as $mp) { ?>
            $('#row_activity_<?php echo $mp->p_no ?>').click(function() {
                var p_no = "<?php echo $mp->p_no; ?>";
                var b_no = "<?php echo $mp->b_no; ?>"
                $("#back_no").val(b_no);

            });
<?php } ?>

        $('#save-header').click(function() {
            var back_no = $("#back_no").val();
            window.location.assign("http://192.168.0.231/AIS_PP/index.php/takaibiki/home_c/edit_point/" + back_no)
        });
    });</script>



<script>
    function deleteThis(value) {
        document.getElementById("id_del_activity").value = value;
        document.getElementById("delete_activity").click();
    }
</script>

<aside class="right-side">
    <section class="content-header">
        <ol class="breadcrumb">
            <li><a href="<?php echo base_url('index.php/portal/calendar_c/') ?>"><span>Home</span></a></li>
            <li> <a href="#"><strong>MANAGE PART TAKAIBIKI </strong></a></li>
        </ol>
    </section>
    <section class="content">
        <?php
        $takaibiki = $this->load->database('takaibiki', TRUE);
        if ($msg != NULL) {
            echo $msg;
        }
        ?>
        <div class="row">
            <div class="col-md-4">
                <div class="grid">
                    <div class="grid-header">
                        <i class="fa fa-certificate"></i>
                        <span class="grid-title" id="stat-create2"><strong id="stat-create">MANAGE</strong> PART</span><span id="id-eci"></span>
                        <div class="pull-right grid-tools">
                            <div id="btn-publish" style="display:none;" type="submit" class="btn btn-primary" data-placement="left" data-toggle="tooltip" title="Publish ECI"><i class="fa fa-upload"></i> Publish</div>
                            <div id="published" style="display:none;background-color:#42CA51;border-color:#FFFFFF" class="btn btn-primary" data-placement="left" data-toggle="tooltip" title="Published"> Published</div>
                            <a href="<?php echo site_url("eci/schedule_c/list_eci") ?>"><div id="back-to-list" style="display:none;background-color:#42CA51;border-color:#FFFFFF" class="btn btn-danger" data-placement="right" data-toggle="tooltip" title="Published"> Published</div></a>
                            <a data-widget="collapse" title="Collapse" id="collapse-header"><i class="fa fa-chevron-up"></i></a>
                        </div>
                    </div>
                    <div class="grid-body">
                        <?php echo form_open('takaibiki/home_c/new_entry', 'class="form-horizontal"'); ?>
                        <div class=" form-group">
                            <label class="col-sm-2 control-label">Back No</label>
                            <div class="col-sm-3">
                                <input autofocus name="part_no" autocomplete="off" id="back_no" class="form-control" style="width:220px;text-transform: uppercase;" maxlength="50" required type="text">
                            </div>

                        </div>

                        <div class="form-group" id="btn-group-header" style="float:none">
                            <div class="col-sm-offset-3 col-sm-12" style="margin:30px 0 0 30px ;">
                                <div class="btn-group">
                                    <div id="save-header" type="submit" class="btn btn-primary" data-placement="left" data-toggle="tooltip" title="Vie Detail Part"><i class="fa fa-check"></i> View</div>
                                    <div style="display:none;"id="update-header" type="submit" class="btn btn-primary" data-placement="left" data-toggle="tooltip" title="Update this data"><i class="fa fa-refresh"></i> Update</div>
                                    <div id="cancel-header" type="submit" class="btn btn-default" data-placement="right" data-toggle="tooltip" title="Back to manage"> Cancel</div>
                                    <?php
                                    echo form_close();
                                    ?>

                                </div>
                            </div>
                        </div>

                    </div>
                </div>
            </div>
            <div class="col-md-8">
                <div class="grid">
                    <div class="grid-header">
                        <i class="fa fa-th-large"></i>
                        <span class="grid-title"><strong>ECI CATEGORY TABLE</strong></span>

                    </div>
                    <div class="grid-body">
                        <table id="dataTables1" class="table table-striped table-condensed table-hover display" cellspacing="0" width="100%">
                            <thead>
                                <tr>
                                    <th>No</th>
                                    <th>Part No</th>
                                    <th>Part Name</th>
                                    <th>Back No</th>
                                    <th>Picture</th>
                                    <th>Pointer</th>
                                    <!--th>Actions</th-->
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                $i = 1;
                                foreach ($master_part as $mp) {
                                    //echo "<tr class='gradeX'>";
                                    echo "<tr id=\"row_activity_$mp->p_no\">";
                                    echo "<td>$i</td>";
                                    echo "<td>$mp->p_no</td>";
                                    echo "<td>$mp->p_name</td>";
                                    echo "<td>$mp->b_no</td>";
                                    echo "<td>$mp->picture</td>";
                                    $flag_point = $takaibiki->query("select * from t_master_cek where p_no = '$mp->p_no'")->result();
                                    if(count($flag_point) > 0 ){
                                         echo "<td>T</td>";
                                    }else{
                                        echo "<td>F</td>";
                                    }
                                   
                                    // echo "<td>$isi->CHR_BUDGET_TYPE</td>";
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


    </section>
</aside>


