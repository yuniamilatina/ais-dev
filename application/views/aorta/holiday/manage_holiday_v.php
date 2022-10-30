<script type="text/javascript">
    $(document).ready(function() {
        $("#btn_create").click(function() {
            $.ajax({
                url: "<?php echo base_url(); ?>index.php/aorta/master_holiday_c/show_create",
                data: {tgl: $(this).val()}, type: "POST",
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
            <li><a href="<?php echo base_url('index.php/aorta/home_c') ?>"><span>Home</span></a></li>
            <li class="active"> <a href="<?php echo base_url('index.php/aorta/master_holiday_c') ?>"><strong>Manage Holiday</strong></a></li>
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
                        <span class="grid-title"><strong>MANAGE HOLIDAY</strong></span>
                        <div class="pull-right">
                            <button id="btn_create" class="btn btn-default" data-placement="left" data-toggle="tooltip" title="Create Holiday" style="height:30px;font-size:13px;width:100px;">Create</button>
                        </div>
                    </div>
                    <div class="grid-body">
                        <div class="pull">
                            <table width="100%">
                                <tr>
                                    <td width="10%">Year</td>
                                    <td width="90%">
                                        <select class="ddl" id="tanggal" onChange="document.location.href = this.options[this.selectedIndex].value;">
                                            <?php for ($x = -1; $x <= 1; $x++) { ?>
                                                <option value="<?PHP echo site_url('aorta/master_holiday_c/index/0/' . date("Y", strtotime("+$x year"))); ?>" <?php
                                                if ($year == date("Y", strtotime("+$x year"))) {
                                                    echo 'SELECTED';
                                                }
                                                ?> > <?php echo date("Y", strtotime("+$x year")); ?> </option>
                                                    <?php } ?>
                                        </select>
                                    </td>
                                </tr>                                
                            </table>                            
                        </div>
                        <div>&nbsp;</div>
                        <table id="dataTables1" class="table table-condensed table-striped table-hover display" cellspacing="0" width="100%">
                            <thead>
                                <tr>
                                    <th>No</th>
                                    <th>Year</th>
                                    <th>Date</th>
                                    <th>Description</th>
                                    <th>Type</th>
                                    <th>Actions</th>

                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                $i = 1;
                                foreach ($data as $isi) {
                                    echo "<tr class='gradeX'>";
                                    echo "<td>$i</td>";
                                    echo "<td>$year</td>";
                                    echo "<td>$isi->TGL_LIBUR</td>";
                                    echo "<td>$isi->KETERANGAN</td>";
                                    if($isi->CHR_TIPE_LB == 1){
                                        echo "<td>Weekend</td>";
                                    } else {
                                        echo "<td>Hari Raya</td>";
                                    }
                                    
                                    ?>
                                <td>
                                    <a href="<?php echo base_url('index.php/aorta/master_holiday_c/edit_holiday') . "/" . $year . "/" . $isi->TGL_LIBUR ?>" class="label label-warning"><span class="fa fa-pencil"></span></a>
                                    <a href="<?php echo base_url('index.php/aorta/master_holiday_c/delete_holiday') . "/" . $isi->TGL_LIBUR ?>" class="label label-danger" onclick="return confirm('Are you sure want to delete this holiday?');"><span class="fa fa-times"></span></a>
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