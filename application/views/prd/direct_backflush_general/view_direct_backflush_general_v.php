
<aside class="right-side">
    <section class="content-header">
        <ol class="breadcrumb">
            <li><a href="<?php echo base_url('index.php/basis/home_c/') ?>"><span>Home</span></a></li>
            <li> <a href="<?php echo base_url('index.php/part/part_customer_c/manage_part_customer_wi') ?>">MANAGE PART CUSTOMER</a></li>
            <li> <a href="#"><strong>CREATE/UPLOAD PART CUST. WI </strong></a></li>
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
                        <i class="fa  fa-thumb-tack"></i>
                        <span class="grid-title" id="stat-create2"><strong id="stat-create">CREATE/UPLOAD PART CUST. WI </strong></span>
                        <div class="pull-right grid-tools">
                            <a data-widget="collapse" title="Collapse" id="collapse-header"><i class="fa fa-chevron-up"></i></a>
                        </div>
                    </div>

                    <div class="grid-body">
                    <div class="form-group">
                        <div id="bg-big" style="width:80%;height:600px;background-image: url('<?php echo base_url($data->CHR_IMG_FILE_NAME); ?>');background-size: 940px 600px;background-repeat: no-repeat;margin: 0px 0px 0px 0px;direct_backflush_generalition:relative;" >
                            <?php
                            if (count($data_detail) > 0) {
                                foreach ($data_detail as $row) {
                                    $left = $row->CHR_WIDTH;
                                    $top = $row->CHR_HEIGHT;
                                    $cek_no = $row->INT_ID;
                                    echo '<img id="img-point-' . $cek_no . '" src="'.base_url('/assets/img/pin.png').'" style="width:60px;height:60px;direct_backflush_generalition:absolute;top: ' . $top . 'px;left:' . $left . 'px;">';
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
                                echo anchor('part/part_customer_c/manage_part_customer_wi', 'Back', 'class="btn btn-default"');
                                ?>
                            <div id="save-header" type="submit" class="btn btn-primary" data-placement="left" data-toggle="tooltip" title="Save this data"><i class="fa fa-check"></i> Save</div>

                                </div>
                                
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
            var p_no = "<?php echo $data->CHR_CUS_PART_NO; ?>";

            if(intXPosition){
                $.ajax({
                    type: "POST",
                    url: "<?php echo site_url('part/part_customer_c/save_coordinate'); ?>",
                    data: "CHR_CUS_PART_NO=" + p_no + "&CHR_WIDTH=" + intXPosition + "&CHR_HEIGHT=" + intYPosition,
                    success: function(data) {
                        alert("Data Berhasil Di simpan");
                        window.location.assign("<?php echo site_url('part/part_customer_c/view_part_customer_wi/'.$data->CHR_CUS_PART_NO); ?>");
                    }
                });
            }else{
                alert('Select the direct_backflush_generalition you want to marked');
            }
            
        });

        $('#cancel-header').click(function() {
            window.location.assign("<?php echo site_url('part/part_customer_c/manage_part_customer_wi'); ?>");
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
            $("#bg-big").append("<img id='point_rep' src='<?php echo base_url('/assets/img/pin.png') ?>' style='width:60px;height:60px;direct_backflush_generalition:absolute;top: " + intYPosition + "px;left:" + intXPosition + "px;'>");
        });

    <?php 
    if (count($data_detail) > 0) {
        foreach ($data_detail as $row) {
            $left = $row->CHR_WIDTH;
            $top = $row->CHR_HEIGHT;
            $cek_no = $row->INT_ID;
            ?>
                    $("#img-point-<?php echo $cek_no ?>").click(function(e) {
                        var p_no = "<?php echo trim($data->CHR_CUS_PART_NO); ?>";
                        var cek_no = "<?php echo $row->INT_ID; ?>";
                        $.ajax({
                            type: "POST",
                            url: "<?php echo site_url('part/part_customer_c/delete_coordinate'); ?>",
                            data: "CHR_CUS_PART_NO=" + p_no + "&INT_ID=" + cek_no,
                            success: function(data) {
                                alert("Berhasil di delete");
                                window.location.assign("<?php echo site_url('part/part_customer_c/view_part_customer_wi/'.trim($data->CHR_CUS_PART_NO)); ?>");
                            }
                        });
                    });
            <?php
        }
    }
    ?>
});
</script>
