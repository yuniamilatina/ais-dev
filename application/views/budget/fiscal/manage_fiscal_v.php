<script type="text/javascript">
    $(document).ready(function() {
        $("#btn_create").click(function() {
            $.ajax({
                url: "<?php echo base_url(); ?>index.php/budget/fiscal_c/show_create",
                data: {INT_ID_DEPT: $(this).val()}, type: "POST",
                success: function(data) {
                    $("#2nd_panel").html(data);
                }
            });
        });
    });
</script>
<aside class="right-side">
    <!-- BEGIN CONTENT HEADER -->
    <section class="content-header">
        <ol class="breadcrumb">
            <li><a href="<?php echo base_url('index.php/budget/home_c') ?>"><span>Home</span></a></li>
            <li class="active"> <a href="<?php echo base_url('index.php/budget/fiscal_c') ?>"><strong>Manage Fiscal Year</strong></a></li>
        </ol>
    </section>
    <!-- END CONTENT HEADER -->
    <!-- BEGIN MAIN CONTENT -->
    <section class="content">
        <?php
        if ($msg != NULL) {
            echo $msg;
        }
        ?>
        <!-- BEGIN BASIC DATATABLES -->

        <div class="row">
            <div class="col-md-7">
                <div class="grid">
                    <div class="grid-header">
                        <i class="fa fa-th-large"></i>
                        <span class="grid-title"><strong>FISCAL YEAR</strong></span>
                        <div class="pull-right">
                            <button id="btn_create" class="btn btn-default" data-placement="left" data-toggle="tooltip" title="Create Fiscal" style="height:30px;font-size:13px;width:100px;">Create</button>
                        </div>
                    </div>
                    <div class="grid-body">
                        <table id="dataTables1" class="table table-condensed table-striped table-hover display" cellspacing="0" width="100%">
                            <thead>
                                <tr>
                                    <th>No</th>
                                    <th>Fiscal Year</th>
                                    <th>Fiscal Start</th>
                                    <th>Fiscal End</th>
                                    <th>Status</th>
                                    <th>Actions</th>

                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                $i = 1;
                                foreach ($data as $isi) {
                                    echo "<tr class='gradeX'>";
                                    echo "<td>$i</td>";
                                    echo "<td>$isi->CHR_FISCAL_YEAR</td>";
                                    echo "<td>$isi->CHR_FISCAL_YEAR_START / $isi->CHR_MONTH_START</td>";
                                    echo "<td>$isi->CHR_FISCAL_YEAR_END / $isi->CHR_MONTH_END</td>";
                                    if($isi->BIT_FLG_ACTIVE == 1){
                                        echo "<td>Enabled</td>";
                                    } else {
                                        echo "<td>Disabled</td>";
                                    }
                                    
                                    ?>
                                <td>
                                    <!--<a href="#"id="btn_edit" class="label label-warning"><span class="fa fa-pencil"></span></a>-->
                                    <a href="<?php echo base_url('index.php/budget/fiscal_c/edit_fiscal') . "/" . $isi->INT_ID_FISCAL_YEAR ?>" class="label label-warning"><span class="fa fa-pencil"></span></a>
<!--                                    <input id="<?php echo $i ?>" name="FISCAL_YEAR" class="form-control" type="hidden" value="<?php echo $isi->INT_ID_FISCAL_YEAR ?>">
                                        <button class="btn-xs btn-warning" id="btn_edit"><span class="fa fa-pencil"></span></button>-->
                                    <?php if($isi->BIT_FLG_ACTIVE == 1){ ?>
                                        <a href="<?php echo base_url('index.php/budget/fiscal_c/disable_fiscal') . "/" . $isi->INT_ID_FISCAL_YEAR ?>" class="label label-info"><span class="fa fa-unlock"></span></a>
                                    <?php } else { ?>
                                        <a href="<?php echo base_url('index.php/budget/fiscal_c/enable_fiscal') . "/" . $isi->INT_ID_FISCAL_YEAR ?>" class="label label-info"><span class="fa fa-lock"></span></a>
                                    <?php } ?>
                                    <a href="<?php echo base_url('index.php/budget/fiscal_c/delete_fiscal') . "/" . $isi->INT_ID_FISCAL_YEAR ?>" class="label label-danger" onclick="return confirm('Are you sure want to delete this fiscal year?');"><span class="fa fa-times"></span></a>
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
            </div>    <!-- END BASIC DATATABLES -->
        </div>

    </section>
    <!-- END MAIN CONTENT -->
</aside>