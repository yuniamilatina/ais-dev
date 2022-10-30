<script type="text/javascript">
    $(document).ready(function() {
        $("#btn_create").click(function() {
            $.ajax({
                url: "<?php echo base_url(); ?>index.php/budget/donation_c/show_create",
                data: {INT_ID_DEPT: $(this).val()}, type: "POST",
                success: function(data) {
                    $("#2nd_panel").html(data);
                }
            });
        });
    });
</script>
<aside class="right-side">
    <section class="content-header">
        <ol class="breadcrumb">
            <li><a href="<?php echo base_url('index.php/budget/home_c/') ?>"><span>Home</span></a></li>
            <li> <a href="<?php echo base_url('index.php/budget/donation_c/') ?>"><strong>Manage Donation</strong></a></li>
        </ol>
    </section>
    <section class="content">
        <?php
        if ($msg != NULL) {
            echo $msg;
        }
        ?>

        <div class="row">
            <div class="col-md-7">
                <div class="grid">
                    <div class="grid-header">
                        <i class="fa fa-th-large"></i>
                        <span class="grid-title"><strong>DONATION</strong> TABLE</span>
                        <div class="pull-right">
                            <button id="btn_create" class="btn btn-default" data-placement="left" data-toggle="tooltip" title="Create Donation" style="height:30px;font-size:13px;width:100px;">Create</button>
                        </div>
                    </div>
                    <div class="grid-body">
                        <table id="dataTables1" class="table table-striped table-condensed table-hover display" cellspacing="0" width="100%">
                            <thead>
                                <tr>
                                    <th>No</th>
                                    <th>Donation</th>
                                    <th>Donation Description</th>
                                    <th>Actions</th>

                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                $i = 1;
                                foreach ($data as $isi) {
                                    echo "<tr class='gradeX'>";
                                    echo "<td>$i</td>";
                                    echo "<td>$isi->CHR_DONATION</td>";
                                    echo "<td>$isi->CHR_DONATION_DESC</td>";
                                    ?>
                                <td>
                                    <a href="<?php echo base_url('index.php/budget/donation_c/edit_donation') . "/" . $isi->INT_ID_DONATION ?>" class="label label-warning"><span class="fa fa-pencil"></span></a>
                                    <a href="<?php echo base_url('index.php/budget/donation_c/delete_donation') . "/" . $isi->INT_ID_DONATION ?>" class="label label-danger" onclick="return confirm('Are you sure want to delete this donation?');"><span class="fa fa-times"></span></a>
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
            <div id="2nd_panel" class="col-md-5">
                <?php
                if ($subcontent != NULL) {
                    $this->load->view($subcontent);
                }
                ?>
            </div>
            <!-- END BASIC DATATABLES -->
        </div>

    </section>
    <!-- END MAIN CONTENT -->
</aside>