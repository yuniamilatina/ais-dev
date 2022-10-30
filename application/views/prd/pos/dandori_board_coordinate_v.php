<aside class="right-side">
    <section class="content-header">
        <ol class="breadcrumb">
            <li><a href="<?php echo base_url('index.php/basis/home_c/') ?>"><span>HOME</span></a></li>
            <li> <a href="<?php echo base_url('index.php/prd/pos_c/manageDandoriBoard') ?>">MANAGE DANDORI BOARD</a></li>
            <li> <a href="#"><strong>SET COORDINATE DANDORI BOARD</strong></a></li>
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
                        <i class="fa fa-image"></i>
                        <span class="grid-title" id="stat-create2"><strong id="stat-create">SET COORDINATE FOR DANDORI BOARD</strong></span>
                        <div class="pull-right grid-tools">
                            <a data-widget="collapse" title="Collapse" id="collapse-header"><i class="fa fa-chevron-up"></i></a>
                        </div>
                    </div>

                    <div class="grid-body">
                        <div class="form-group">
                            <div id="bg-big" style="width:900px; height:660px;background-image: url('<?php echo base_url($data->CHR_IMG_FILE_NAME); ?>');background-size: 900px 660px;background-repeat: no-repeat;margin: 0px 0px 0px 0px;position:relative;">
                                <?php
                                if (count($data_detail) > 0) {
                                    foreach ($data_detail as $row) {
                                        $left = $row->INT_COOR_X;
                                        $top = $row->INT_COOR_Y;
                                        $cek_no = $row->INT_ID;
                                        echo '<img id="img-point-' . $cek_no . '" src="' . base_url('/assets/img/pin.png') . '" style="width:60px;height:60px;position:absolute;top: ' . $top . 'px;left:' . $left . 'px;">';
                                    }
                                }
                                ?>
                            </div>

                            <div class="form-group" style='margin-bottom:30px;'>
                                <div class="col-sm-10">
                                    <span id="result"><strong>X: - | Y: -</strong></span>
                                </div>
                                <div class="col-sm-2">
                                    <?php
                                    echo anchor('prd/pos_c/index/' . $data->CHR_WORK_CENTER, 'Back', 'class="btn btn-default"');
                                    ?>
                                    <a class='btn btn-primary' data-toggle="modal" data-target="#modalKeyPoint" data-placement="left" data-toggle="tooltip" title="Save this data"><i class="fa fa-check"></i> Save</a>
                                    <!-- <div id="save-header" type="submit" class="btn btn-primary" data-placement="left" data-toggle="tooltip" title="Save this data"><i class="fa fa-check"></i> Save</div> -->
                                </div>
                            </div>
                        </div>
                    </div>

                </div>

                <div class="modal fade" id="modalKeyPoint" tabindex="-1" role="dialog" aria-labelledby="myModalLabel3" aria-hidden="true">
                    <div class="modal-wrapper">
                        <div class="modal-dialog">
                            <div class="modal-content">
                                <form>
                                    <div class="modal-header">
                                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                                        <h4 class="modal-title" id="myModalLabel3"><strong>Add key Point</strong></h4>
                                    </div>
                                    <div class="modal-body" style="padding-bottom:40px;">
                                        <div class="form-group">
                                            <label class="col-sm-2 control-label">Key Point</label>
                                            <div class="col-sm-5">
                                                <input class='form-control' type='text' id="CHR_KEY_POINT" name="CHR_KEY_POINT" style="width:300px;" ></input>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="modal-footer">
                                        <div class="btn-group">
                                            <button type="button" class="btn btn-success" id="save-header" data-dismiss="modal"> Save</button>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </section>
</aside>



<script>
    $(document).ready(function() {
        var intXPosition;
        var intYPosition;

        var myVar = setInterval(function() {
            $("#hide-sub-menus").click();
            clearInterval(myVar);
        }, 0.5);

        $('#save-header').click(function() {
            var id = "<?php echo $data->INT_ID; ?>";
            var keypoint = $('#CHR_KEY_POINT').val();

            if (intXPosition) {
                $.ajax({
                    type: "POST",
                    url: "<?php echo site_url('prd/pos_c/saveCoordinate'); ?>",
                    data: "INT_ID_POS=" + id + "&INT_COOR_X=" + intXPosition + "&INT_COOR_Y=" + intYPosition + "&CHR_KEY_POINT=" + keypoint,
                    success: function(data) {
                        alert("Data Berhasil Di simpan");
                        window.location.assign("<?php echo site_url('prd/pos_c/setCoordinate/' . $data->INT_ID); ?>");
                    }
                });
            } else {
                alert('Select the position you want to marked');
            }

        });

        $('#cancel-header').click(function() {
            window.location.assign("<?php echo site_url('prd/pos_c/manageDandoriBoard'); ?>");
        });

        $("#bg-big").click(function(e) {
            var parentOffset = $(this).parent().offset();
            var relativeXPosition = (e.pageX - parentOffset.left);
            var relativeYPosition = (e.pageY - parentOffset.top);

            intXPosition = parseInt(relativeXPosition);
            intXPosition = intXPosition - 65;
            intYPosition = parseInt(relativeYPosition);
            intYPosition = intYPosition - 60;
            $("#result").html("<p><strong>X: " + intXPosition + " | Y: " + intYPosition + "</strong></p>");
            $("#point_rep").remove("");
            $("#bg-big").append("<img id='point_rep' src='<?php echo base_url('/assets/img/pin.png') ?>' style='width:60px;height:60px;position:absolute;top: " + intYPosition + "px;left:" + intXPosition + "px;'>");
        });

        <?php
        if (count($data_detail) > 0) {
            foreach ($data_detail as $row) {
                $left = $row->INT_COOR_X;
                $top = $row->INT_COOR_Y;
                $cek_no = $row->INT_ID;
        ?>
                $("#img-point-<?php echo $cek_no ?>").click(function(e) {
                    var id = "<?php echo trim($data->INT_ID); ?>";
                    var cek_no = "<?php echo $row->INT_ID; ?>";
                    $.ajax({
                        type: "POST",
                        url: "<?php echo site_url('prd/pos_c/deleteCoordinate'); ?>",
                        data: "INT_ID_POS=" + id + "&INT_ID=" + cek_no,
                        success: function(data) {
                            alert("Berhasil di delete");
                            window.location.assign("<?php echo site_url('prd/pos_c/setCoordinate/' . trim($data->INT_ID)); ?>");
                        }
                    });
                });
        <?php
            }
        }
        ?>
    });
</script>