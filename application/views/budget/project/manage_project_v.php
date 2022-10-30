<script type="text/javascript">
    $(document).ready(function() {
        $("#btn_create").click(function() {
            $.ajax({
                url: "<?php echo base_url(); ?>index.php/budget/project_c/show_create",
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
            <li><a href="<?php echo base_url('index.php/budget/project_c/') ?>"><strong>Manage Project</strong></a></li>
        </ol>
    </section>
    <section class="content">
        <?php
        if ($msg != NULL) {
            echo $msg;
        }
        ?>

        <div class="row">
            <div class="col-md-8">
                <div class="grid">
                    <div class="grid-header">
                        <i class="fa fa-th-large"></i>
                        <span class="grid-title"><strong>PROJECT</strong> TABLE</span>
                        <div class="pull-right">
                            <a href="<?php echo base_url('index.php/budget/project_c/create_project/') ?>"  class="btn btn-default" data-placement="left" data-toggle="tooltip" title="Create Project" style="height:30px;font-size:13px;width:100px;">Create</a>

                        </div>
                    </div>
                    <div class="grid-body">
                        <table id="dataTables1" class="table table-striped table-condensed table-hover display" cellspacing="0" width="100%">
                            <thead>
                                <tr>
                                    <th>No</th>
                                    <th>Project Code</th>
                                    <th>Project Description</th>
                                    <th>Customer</th>
                                    <th>Masspro</th>
                                    <th>Actions</th>

                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                $i = 1;
                                foreach ($data as $isi) {
                                    echo "<tr class='gradeX'>";
                                    echo "<td>$i</td>";
                                    $icon = "";
                                    if($isi->BIT_FLG_NEW_PROJECT == 1){
                                        $icon = "<span style='color:orange;' class='fa fa-star'></span>";
                                    }
                                    echo "<td>".trim($isi->CHR_PROJECT) . $icon . "</td>";
                                    echo "<td>$isi->CHR_PROJECT_DESC</td>";
                                    echo "<td>$isi->CHR_CUSTOMER</td>";
                                    if($isi->CHR_MASSPRO_DATE != NULL){
                                        echo "<td>" . strtoupper(date("F", mktime(null, null, null, substr($isi->CHR_MASSPRO_DATE, 4, 2)))).' '.substr($isi->CHR_MASSPRO_DATE, 0, 4) . "</td>";
                                    } else {
                                        echo "<td>-</td>";
                                    }
                                    ?>
                                <td>
                                    <a href="<?php echo base_url('index.php/budget/project_c/get_project_detail') . "/" . trim($isi->INT_ID_PROJECT) ?>" class="label label-success"><span class="fa fa-check"></span></a>
                                    <a href="<?php echo base_url('index.php/budget/project_c/edit_project') . "/" . $isi->INT_ID_PROJECT ?>" class="label label-warning"><span class="fa fa-pencil"></span></a>
                                    <a href="<?php echo base_url('index.php/budget/project_c/delete_project') . "/" . $isi->INT_ID_PROJECT ?>" class="label label-danger" onclick="return confirm('Are you sure want to delete this project?');"><span class="fa fa-times"></span></a>
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
            <div id="2nd_panel" class="col-md-4">
                <?php
                if ($subcontent != NULL) {
                    $this->load->view($subcontent);
                }
                ?>
            </div> 
        </div>

    </section>
</aside>