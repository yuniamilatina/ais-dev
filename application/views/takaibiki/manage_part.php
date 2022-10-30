<!--<script>
    $(document).ready(function () {
        var myVar = setInterval(function () {
            $("#hide-sub-menus").click();
            clearInterval(myVar)
        }, 0.5);

<?php foreach ($master_part as $mp) { ?>
            $('#row_activity_<?php echo $mp->p_no ?>').click(function () {
                var p_no = "<?php echo $mp->p_no; ?>";
                var b_no = "<?php echo $mp->b_no; ?>"
                $("#back_no").val(b_no);

            });
<?php } ?>

        $('#save-header').click(function () {
            var back_no = $("#back_no").val();
            window.location.assign("http://192.168.0.231/AIS_PP/index.php/takaibiki/home_c/edit_point/" + back_no);
        });


    });

    function redirectToEdit() {
        var back_no = $("#back_no").val();
        window.location.assign("http://192.168.0.231/AIS_PP/index.php/takaibiki/home_c/edit_point/" + back_no);
    }
</script>-->



<!--<script>
    function deleteThis(value) {
        document.getElementById("id_del_activity").value = value;
        document.getElementById("delete_activity").click();
    }
</script>-->

<aside class="right-side">
    <section class="content-header">
        <ol class="breadcrumb">
            <li><a href="<?php echo base_url('index.php/basis/home_c/') ?>"><span>Home</span></a></li>
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
<!--            <div class="col-md-4">
                <div class="grid">
                    <div class="grid-header">
                        <i class="fa fa-th"></i>
                        <span class="grid-title"><strong id="stat-create">MANAGE PART</strong></span>
                        <div class="pull-right grid-tools">
                            <a data-widget="collapse" title="Collapse"><i class="fa fa-chevron-up"></i></a>
                        </div>
                    </div>
                    <div class="grid-body" style="height:150px;">

                        <div class=" form-group">
                            <label class="col-sm-4 control-label">Back No</label>
                            <div class="col-sm-3">
                                <input autofocus name="part_no" autocomplete="off" id="back_no" class="form-control" style="width:150px;text-transform: uppercase;"  required type="text">
                            </div>
                        </div>

                        <div class="form-group" >
                            <div class="col-sm-offset-2 col-sm-12" style="margin:30px 0 0 30px ;">
                                <div class="btn-group">
                                    <div id="save-header" type="submit" class="btn btn-primary" data-placement="left" data-toggle="tooltip" title="View Detail Part" onclick="redirectToEdit()"><i class="fa fa-check"></i> View</div>
                                    <div  type="reset" class="btn btn-default" data-placement="right" data-toggle="tooltip" title="Reset"> Cancel</div>
                                </div>
                            </div>
                        </div>

                    </div>
                </div>
            </div>-->

            <div class="col-md-12">
                <div class="grid">
                    <div class="grid-header">
                        <i class="fa fa-th"></i>
                        <span class="grid-title"><strong>MANAGE PART TAKAIBIKI</strong></span>
                        <div class="pull-right grid-tools">
                            <a href="<?php echo base_url('index.php/takaibiki/takaibiki_c/add_new_part"') ?>" class="btn btn-default"  id="add_new_part"><i class="fa fa-plus"></i>&nbsp; New Part</a>
                            <a data-widget="collapse" title="Collapse"><i class="fa fa-chevron-up"></i></a>
                        </div>
                    </div>
                    <div class="grid-body">
                        <table id="dataTables3" class="table table-condensed  table-striped table-hover display" cellspacing="0" width="100%">
                            <thead>
                                <tr>
                                    <th>No</th>
                                    <th>Part No</th>
                                    <th>Part Name</th>
                                    <th style='vertical-align: middle;text-align:center;'>Back No</th>
                                    <th style='vertical-align: middle;text-align:center;'>Picture Name</th>
                                    <th style='vertical-align: middle;text-align:center;'>Pointer</th>
                                    <th style='vertical-align: middle;text-align:center;'>Actions</th>
                                </tr>
                            </thead>
                            <tbody> <!--geometri-->
                                <?php
                                $i = 1;
                                foreach ($master_part as $mp) {
                                    echo "<tr class='gradeX'>";
//                                    echo "<tr id=\"row_activity_$mp->p_no\">";
                                    echo "<td>$i</td>";
                                    echo "<td>$mp->p_no</td>";
                                    echo "<td>$mp->p_name</td>";
                                    echo "<td style='vertical-align: middle;text-align:center;'>$mp->b_no</td>";
                                    echo "<td style='vertical-align: middle;text-align:center;'>$mp->picture</td>";
                                    $flag_point = $takaibiki->query("select * from t_master_cek where p_no = '$mp->p_no'")->result();
                                    if (count($flag_point) > 0) {
                                        echo "<td style='vertical-align: middle;text-align:center;background:#55D785;color:#fff;'>True</td>";
                                    } else {
                                        echo "<td style='vertical-align: middle;text-align:center;background:#FE2D45;color:#fff;'>False</td>";
                                    }
                                    ?>
                                <td style='vertical-align: middle;text-align:center;'>
                                    <a href="<?php echo base_url('index.php/takaibiki/takaibiki_c/edit_point'). "/" . $mp->b_no;  ?>" class="label label-primary" data-placement="left" data-toggle="tooltip" title="View"><span class="fa fa-search"></span></a>
                                </td>
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


