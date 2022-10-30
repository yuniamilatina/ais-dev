<script>
    $(document).ready(function () {
        var interval_close = setInterval(closeSideBar, 250);
        function closeSideBar() { 
            $("#hide-sub-menus").click();
            clearInterval(interval_close);
        }
    });
</script>
<style type="text/css">
    th, td { white-space: nowrap; }
    div.dataTables_wrapper {
        margin: 0 auto;
    }
    #table-luar{
        font-size: 12px;
    }
    #filter { 
        border-spacing: 10px;
        border-collapse: separate;
    }
    .td-fixed{
        width: 30px;
    }
    .td-no{
        width: 10px;
    }
    .ddl{
        width: 100px;
        height: 30px;
    }
    .ddl2{
        width: 180px;
        height: 30px;
    }
</style>

<aside class="right-side">
    <section class="content-header">
        <ol class="breadcrumb">
            <li><a href="<?php echo base_url('index.php/basis/home_c/') ?>"><span>Home</span></a></li>
            <li> <a href="#"><strong>LOG IN LINE SCAN</strong></a></li>
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
                        <i class="fa fa-th"></i>
                        <span class="grid-title"><strong>LOG IN LINE SCAN</strong></span>
                    </div>
                    <div class="grid-body">
                        <div class="pull">
                            <table width="100%" id='filter' border=0px>
                                <tr>
                                    <td width="5%">Work Center</td>
                                    <td width="5%">
                                        <select class="ddl" onChange="document.location.href = this.options[this.selectedIndex].value;">
                                            <?php foreach ($all_work_centers as $row) { ?>
                                                <option value="<?php echo site_url('prd/logs_in_line_scan_c/index/' . trim($row->CHR_WORK_CENTER)); ?>"  <?php
                                                if ($work_center == trim($row->CHR_WORK_CENTER)) {
                                                    echo 'selected';
                                                }
                                                ?> > <?php echo trim($row->CHR_WORK_CENTER); ?> </option>
                                                    <?php } ?>
                                        </select>
                                    </td>
                                    <td width="90%"></td>
                                </tr>
                            </table>
                        </div>
                        <div id="table-luar">
                            <table id="dataTables3" class="table table-condensed table-striped table-hover display" cellspacing="0" width="100%">
                                <thead>
                                    <tr>
                                        <th  style='vertical-align: middle;text-align:center;'>No</th>
                                        <th  style='vertical-align: middle;text-align:center;'>Work Center</th>
                                        <th  style='vertical-align: middle;text-align:center;'>Prd Order No</th>
                                        <th  style='vertical-align: middle;text-align:center;'>Part No</th>
                                        <th  style='vertical-align: middle;text-align:center;'>Message</th>
                                        <th  style='vertical-align: middle;text-align:center;'>Barcode</th>
                                        <th  style='vertical-align: middle;text-align:center;'>Created Date</th>
                                        <th  style='vertical-align: middle;text-align:center;'>Created Time</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    $i = 1;
                                    foreach ($data as $row) {
                                        echo "<tr class='gradeX'>";
                                        echo "<td style='text-align:center;vertical-align: middle;'>$i</td>";
                                        echo "<td style='text-align:center;vertical-align: middle;'>$row->CHR_WORK_CENTER</td>";
                                        echo "<td style='text-align:center;vertical-align: middle;'>$row->CHR_PRD_ORDER_NO</td>";
                                        echo "<td style='text-align:center;vertical-align: middle;'>$row->CHR_PART_NO</td>";
                                        echo "<td style='text-align:center;vertical-align: middle;'>$row->CHR_MESSAGE</td>";
                                        echo "<td style='text-align:center;vertical-align: middle;'>$row->CHR_BARCODE</td>";
                                        echo "<td style='text-align:center;vertical-align: middle;'>$row->CHR_CREATED_DATE</td>";
                                        echo "<td style='text-align:center;vertical-align: middle;'>$row->CHR_CREATED_TIME</td>";
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
        </div>
    </section>
</aside>

