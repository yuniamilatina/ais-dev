
<style type="text/css">
    th, td { white-space: nowrap; }
    div.dataTables_wrapper {
        margin: 0 auto;
    }
    #table-luar{
        font-size: 11px;
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


<script>     
    var tableToExcel = (function () {
    var uri = 'data:application/vnd.ms-excel;base64,'
    , template = '<html xmlns:o="urn:schemas-microsoft-com:office:office" xmlns:x="urn:schemas-microsoft-com:office:excel" xmlns="http://www.w3.org/TR/REC-html40"><head><!--[if gte mso 9]><xml><x:ExcelWorkbook><x:ExcelWorksheets><x:ExcelWorksheet><x:Name>{worksheet}</x:Name><x:WorksheetOptions><x:DisplayGridlines/></x:WorksheetOptions></x:ExcelWorksheet></x:ExcelWorksheets></x:ExcelWorkbook></xml><![endif]--></head><body><table>{table}</table></body></html>'
                , base64 = function (s) {
    return window.btoa(unescape(encodeURIComponent(s)))
        }
    , format = function (s, c) {
    return s.replace(/{(\w+)}/g, function (m, p) {
        return c[p];
    })
    }
    return function (table, name) {
    if (!table.nodeType)
        table = document.getElementById(table)
    var ctx = {worksheet: name || 'Sheet1', table: table.innerHTML}
    window.location.href = uri + base64(format(template, ctx))
    }
    })()
</script>

<aside class="right-side">
    <section class="content-header">
        <ol class="breadcrumb">
            <li><a href="<?php echo base_url('index.php/basis/home_c/') ?>"><span>Home</span></a></li>
            <li> <a href="#"><strong>LOAD TESTER</strong></a></li>
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
                        <span class="grid-title"><strong>LOAD TESTER</strong></span>
                        <div class="pull-right grid-tools">
                            <a href="<?php echo base_url('index.php/patricia/load_tester_c/prepare_upload_load_tester/') ?>" class="btn btn-default" data-toggle="tooltip" data-placement="left" title="Upload Load Tester" style="height:30px;font-size:13px;width:100px;color:#000000;">Upload</a>
                        </div>
                    </div>
                    <div class="grid-body">

                        <div class="pull">
                            <table width="100%" style="margin-bottom:-10px;" border=0px>
                                <tr>
                                    <td style="vertical-align:top" width="10%">
                                        <select class="ddl" onChange="document.location.href = this.options[this.selectedIndex].value;">
                                            <?php for ($x = -10; $x <= 0; $x++) { $y = $x * 28 ?>
                                                <option value="<?php echo site_url('patricia/load_tester_c/index/' . date("Ym", strtotime("+$y day")) ); ?>" <?php
                                                if ($period == date("Ym", strtotime("+$y day"))) {
                                                    echo 'SELECTED';
                                                }
                                                ?> > <?php echo date("Ym", strtotime("+$y day")); ?> 
                                                </option>
                                                    <?php } ?>

                                        </select>
                                    </td>
                                    <td >
                                    </td>
                                    <td width="75%" style="text-align:right;">
                                        <input type="submit" class="btn btn-primary" onclick="tableToExcel('exportToExcel', 'Load Tester')" value="Export to Excel" style="margin-bottom: 20px;"><i class="fa fa-download-up"></i></input>
                                    </td>
                               </tr>
                            </table>
                        </div>

                    <div id="table-luar">
                        <table id="dataTables3" class="table table-condensed table-striped table-hover display" cellspacing="0" width="100%">
                            <thead>
                                <tr>
                                    <th  style='text-align:center;'>No</th>
                                    <th  style='text-align:center;'>PDS No</th>
                                    <th  style='text-align:center;'>Part No</th>
                                    <th  style='text-align:center;'>Scale</th>
                                    <th  style='text-align:center;'>Load 1</th>
                                    <th  style='text-align:center;'>Load 2</th>
                                    <th  style='text-align:center;'>Load 3</th>
                                    <th  style='text-align:center;'>Generate Date</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                $i = 1;
                                foreach ($data as $row) {
                                    echo "<tr class='gradeX'>";
                                    echo "<td style='text-align:center;'>$i</td>";
                                    echo "<td style='text-align:center;'>$row->CHR_PDS_NO</td>";
                                    echo "<td style='text-align:center;'>$row->CHR_PART_NO</td>";
                                    echo "<td style='text-align:center;'>".str_replace('.',',',$row->INT_SCALE)."</td>";
                                    echo "<td style='text-align:center;'>".str_replace('.',',',$row->INT_LOAD1)."</td>";
                                    echo "<td style='text-align:center;'>".str_replace('.',',',$row->INT_LOAD2)."</td>";
                                    echo "<td style='text-align:center;'>".str_replace('.',',',$row->INT_LOAD3)."</td>";
                                    echo "<td style='text-align:center;'>".substr($row->CHR_TEST_DATE,6,2). '-' . substr($row->CHR_TEST_DATE,4,2) . '-' .substr($row->CHR_TEST_DATE,0,4)."</td>";
                                    
                                    ?>
                                </tr>
                                <?php
                                $i++;
                            }
                            ?>
                            </tbody>
                        </table>

                        <table id="exportToExcel" class="table table-condensed table-bordered table-striped table-hover display" cellspacing="0" width="100%"  style="display:none;">
                            <thead>
                                <tr>
                                    <th  style='text-align:center;'>No</th>
                                    <th  style='text-align:center;'>PDS No</th>
                                    <th  style='text-align:center;'>Part No</th>
                                    <th  style='text-align:center;'>Scale</th>
                                    <th  style='text-align:center;'>Load 1</th>
                                    <th  style='text-align:center;'>Load 2</th>
                                    <th  style='text-align:center;'>Load 3</th>
                                    <th  style='text-align:center;'>Generate Date</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                $i = 1;
                                foreach ($data as $row) {
                                    echo "<tr class='gradeX'>";
                                    echo "<td style='text-align:center;'>$i</td>";
                                    echo "<td style='text-align:center;'>$row->CHR_PDS_NO</td>";
                                    echo "<td style='text-align:center;'>$row->CHR_PART_NO</td>";
                                    echo "<td style='text-align:center;'>".str_replace('.',',',$row->INT_SCALE)."</td>";
                                    echo "<td style='text-align:center;'>".str_replace('.',',',$row->INT_LOAD1)."</td>";
                                    echo "<td style='text-align:center;'>".str_replace('.',',',$row->INT_LOAD2)."</td>";
                                    echo "<td style='text-align:center;'>".str_replace('.',',',$row->INT_LOAD3)."</td>";
                                    echo "<td style='text-align:center;'>".substr($row->CHR_TEST_DATE,6,2). '-' . substr($row->CHR_TEST_DATE,4,2) . '-' .substr($row->CHR_TEST_DATE,0,4)."</td>";
                                    
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


