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




                    <div class="grid-body">
                        <div id="table-luar">
                            <table id="example" class="table table-condensed table-striped table-hover display" cellspacing="0" width="100%">
                                <thead>
                                    <tr class='gradeX'>
                                        <th rowspan="3" style="vertical-align: middle;">No</th>
                                        <th rowspan="3" style="vertical-align: middle;">Line</th>

                                        <th colspan='4' style="text-align:center;">Total Qty</th>
                                        <th colspan='4' style="text-align:center;">Total Amount</th>

                                        <th colspan='8' style="text-align:center;">Date </th>
                                        
                                    </tr>
                                    <tr class='gradeX'>

                                        <th rowspan="2" style="vertical-align: middle;">Process</th>
                                        <th rowspan="2" style="vertical-align: middle;">B.test</th>
                                        <th rowspan="2" style="vertical-align: middle;">Trial</th>
                                        <th rowspan="2" style="vertical-align: middle;">Setup</th>

                                        <th rowspan="2" style="vertical-align: middle;">Process</th>
                                        <th rowspan="2" style="vertical-align: middle;">B.test</th>
                                        <th rowspan="2" style="vertical-align: middle;">Trial</th>
                                        <th rowspan="2" style="vertical-align: middle;">Setup</th>

                                        <th colspan='31' style="vertical-align: middle;background:whitesmoke;">Qty Process</th>
                                        <th colspan='31' style="vertical-align: middle;background:whitesmoke;">Qty B.test</th>
                                        <th colspan='31' style="vertical-align: middle;background:whitesmoke;">Qty Trial</th>
                                        <th colspan='31' style="vertical-align: middle;background:whitesmoke;">Qty Setup</th>
                                        
                                        <th colspan='31' style="vertical-align: middle;background:whitesmoke;">Amount Process</th>
                                        <th colspan='31' style="vertical-align: middle;background:whitesmoke;">Amount B.test</th>
                                        <th colspan='31' style="vertical-align: middle;background:whitesmoke;">Amount Trial</th>
                                        <th colspan='31' style="vertical-align: middle;background:whitesmoke;">Amount Setup</th>

                                    </tr>
                                    <tr class='gradeX'>
                                        <?php
                                        for($y = 1; $y <= 8; $y++){
                                            for ($x = 1; $x <= 31; $x++) {
                                                echo "<td style='text-align:center;'><div class='td-fixed'>".$x."</div></td>";
                                            }
                                        }
                                        ?>
                                    </tr>
                                   
                                </thead>
                                <tbody>

                                    <?php
                                    $r = 1;
                                    foreach ($detail_reject_in_line as $isi) {

                                            echo "<tr style=text-align:center; >";
                                            echo "<td style=text-align:center;><strong>$r</strong></td>";
                                            echo "<td style=text-align:center;><strong>" . $isi->CHR_WORK_CENTER . "</strong></td>";

                                            $total_prc = $isi->PRC_01 
                                            + $isi->PRC_02
                                            + $isi->PRC_03
                                            + $isi->PRC_04
                                            + $isi->PRC_05
                                            + $isi->PRC_06
                                            + $isi->PRC_07
                                            + $isi->PRC_08
                                            + $isi->PRC_09
                                            + $isi->PRC_10
                                            + $isi->PRC_11
                                            + $isi->PRC_12
                                            + $isi->PRC_13
                                            + $isi->PRC_14
                                            + $isi->PRC_15
                                            + $isi->PRC_16
                                            + $isi->PRC_17
                                            + $isi->PRC_18
                                            + $isi->PRC_19
                                            + $isi->PRC_20
                                            + $isi->PRC_21
                                            + $isi->PRC_22
                                            + $isi->PRC_23
                                            + $isi->PRC_24
                                            + $isi->PRC_25
                                            + $isi->PRC_26
                                            + $isi->PRC_27
                                            + $isi->PRC_28
                                            + $isi->PRC_29
                                            + $isi->PRC_30
                                            + $isi->PRC_31;
                                                                                        
                                            $total_brk = $isi->BRK_01
                                            + $isi->BRK_02
                                            + $isi->BRK_03
                                            + $isi->BRK_04
                                            + $isi->BRK_05
                                            + $isi->BRK_06
                                            + $isi->BRK_07
                                            + $isi->BRK_08
                                            + $isi->BRK_09
                                            + $isi->BRK_10
                                            + $isi->BRK_11
                                            + $isi->BRK_12
                                            + $isi->BRK_13
                                            + $isi->BRK_14
                                            + $isi->BRK_15
                                            + $isi->BRK_16
                                            + $isi->BRK_17
                                            + $isi->BRK_18
                                            + $isi->BRK_19
                                            + $isi->BRK_20
                                            + $isi->BRK_21
                                            + $isi->BRK_22
                                            + $isi->BRK_23
                                            + $isi->BRK_24
                                            + $isi->BRK_25
                                            + $isi->BRK_26
                                            + $isi->BRK_27
                                            + $isi->BRK_28
                                            + $isi->BRK_29
                                            + $isi->BRK_30
                                            + $isi->BRK_31;

                                            $total_stu =  $isi->STU_01
                                            + $isi->STU_02
                                            + $isi->STU_03
                                            + $isi->STU_04
                                            + $isi->STU_05
                                            + $isi->STU_06
                                            + $isi->STU_07
                                            + $isi->STU_08
                                            + $isi->STU_09
                                            + $isi->STU_10
                                            + $isi->STU_11
                                            + $isi->STU_12
                                            + $isi->STU_13
                                            + $isi->STU_14
                                            + $isi->STU_15
                                            + $isi->STU_16
                                            + $isi->STU_17
                                            + $isi->STU_18
                                            + $isi->STU_19
                                            + $isi->STU_20
                                            + $isi->STU_21
                                            + $isi->STU_22
                                            + $isi->STU_23
                                            + $isi->STU_24
                                            + $isi->STU_25
                                            + $isi->STU_26
                                            + $isi->STU_27
                                            + $isi->STU_28
                                            + $isi->STU_29
                                            + $isi->STU_30
                                            + $isi->STU_31;

                                            $total_tri =  $isi->TRI_01
                                            + $isi->TRI_02
                                            + $isi->TRI_03
                                            + $isi->TRI_04
                                            + $isi->TRI_05
                                            + $isi->TRI_06
                                            + $isi->TRI_07
                                            + $isi->TRI_08
                                            + $isi->TRI_09
                                            + $isi->TRI_10
                                            + $isi->TRI_11
                                            + $isi->TRI_12
                                            + $isi->TRI_13
                                            + $isi->TRI_14
                                            + $isi->TRI_15
                                            + $isi->TRI_16
                                            + $isi->TRI_17
                                            + $isi->TRI_18
                                            + $isi->TRI_19
                                            + $isi->TRI_20
                                            + $isi->TRI_21
                                            + $isi->TRI_22
                                            + $isi->TRI_23
                                            + $isi->TRI_24
                                            + $isi->TRI_25
                                            + $isi->TRI_26
                                            + $isi->TRI_27
                                            + $isi->TRI_28
                                            + $isi->TRI_29
                                            + $isi->TRI_30
                                            + $isi->TRI_31;

                                            $total_amount_prc = $isi->APRC_01 
                                            + $isi->APRC_02
                                            + $isi->APRC_03
                                            + $isi->APRC_04
                                            + $isi->APRC_05
                                            + $isi->APRC_06
                                            + $isi->APRC_07
                                            + $isi->APRC_08
                                            + $isi->APRC_09
                                            + $isi->APRC_10
                                            + $isi->APRC_11
                                            + $isi->APRC_12
                                            + $isi->APRC_13
                                            + $isi->APRC_14
                                            + $isi->APRC_15
                                            + $isi->APRC_16
                                            + $isi->APRC_17
                                            + $isi->APRC_18
                                            + $isi->APRC_19
                                            + $isi->APRC_20
                                            + $isi->APRC_21
                                            + $isi->APRC_22
                                            + $isi->APRC_23
                                            + $isi->APRC_24
                                            + $isi->APRC_25
                                            + $isi->APRC_26
                                            + $isi->APRC_27
                                            + $isi->APRC_28
                                            + $isi->APRC_29
                                            + $isi->APRC_30
                                            + $isi->APRC_31;
                                                                                        
                                            $total_amount_brk = $isi->ABRK_01
                                            + $isi->ABRK_02
                                            + $isi->ABRK_03
                                            + $isi->ABRK_04
                                            + $isi->ABRK_05
                                            + $isi->ABRK_06
                                            + $isi->ABRK_07
                                            + $isi->ABRK_08
                                            + $isi->ABRK_09
                                            + $isi->ABRK_10
                                            + $isi->ABRK_11
                                            + $isi->ABRK_12
                                            + $isi->ABRK_13
                                            + $isi->ABRK_14
                                            + $isi->ABRK_15
                                            + $isi->ABRK_16
                                            + $isi->ABRK_17
                                            + $isi->ABRK_18
                                            + $isi->ABRK_19
                                            + $isi->ABRK_20
                                            + $isi->ABRK_21
                                            + $isi->ABRK_22
                                            + $isi->ABRK_23
                                            + $isi->ABRK_24
                                            + $isi->ABRK_25
                                            + $isi->ABRK_26
                                            + $isi->ABRK_27
                                            + $isi->ABRK_28
                                            + $isi->ABRK_29
                                            + $isi->ABRK_30
                                            + $isi->ABRK_31;

                                            $total_amount_stu =  $isi->ASTU_01
                                            + $isi->ASTU_02
                                            + $isi->ASTU_03
                                            + $isi->ASTU_04
                                            + $isi->ASTU_05
                                            + $isi->ASTU_06
                                            + $isi->ASTU_07
                                            + $isi->ASTU_08
                                            + $isi->ASTU_09
                                            + $isi->ASTU_10
                                            + $isi->ASTU_11
                                            + $isi->ASTU_12
                                            + $isi->ASTU_13
                                            + $isi->ASTU_14
                                            + $isi->ASTU_15
                                            + $isi->ASTU_16
                                            + $isi->ASTU_17
                                            + $isi->ASTU_18
                                            + $isi->ASTU_19
                                            + $isi->ASTU_20
                                            + $isi->ASTU_21
                                            + $isi->ASTU_22
                                            + $isi->ASTU_23
                                            + $isi->ASTU_24
                                            + $isi->ASTU_25
                                            + $isi->ASTU_26
                                            + $isi->ASTU_27
                                            + $isi->ASTU_28
                                            + $isi->ASTU_29
                                            + $isi->ASTU_30
                                            + $isi->ASTU_31;

                                            $total_amount_tri =  $isi->ATRI_01
                                            + $isi->ATRI_02
                                            + $isi->ATRI_03
                                            + $isi->ATRI_04
                                            + $isi->ATRI_05
                                            + $isi->ATRI_06
                                            + $isi->ATRI_07
                                            + $isi->ATRI_08
                                            + $isi->ATRI_09
                                            + $isi->ATRI_10
                                            + $isi->ATRI_11
                                            + $isi->ATRI_12
                                            + $isi->ATRI_13
                                            + $isi->ATRI_14
                                            + $isi->ATRI_15
                                            + $isi->ATRI_16
                                            + $isi->ATRI_17
                                            + $isi->ATRI_18
                                            + $isi->ATRI_19
                                            + $isi->ATRI_20
                                            + $isi->ATRI_21
                                            + $isi->ATRI_22
                                            + $isi->ATRI_23
                                            + $isi->ATRI_24
                                            + $isi->ATRI_25
                                            + $isi->ATRI_26
                                            + $isi->ATRI_27
                                            + $isi->ATRI_28
                                            + $isi->ATRI_29
                                            + $isi->ATRI_30
                                            + $isi->ATRI_31;

                                            echo "<td style='text-align:center;border-right: 1px solid #cdd0d4;'>" . number_format($total_prc). "</td>";
                                            echo "<td style='text-align:center;border-right: 1px solid #cdd0d4;'>" . number_format($total_brk). "</td>";
                                            echo "<td style='text-align:center;border-right: 1px solid #cdd0d4;'>" . number_format($total_stu). "</td>";
                                            echo "<td style='text-align:center;border-right: 1px solid #cdd0d4;'>" . number_format($total_tri). "</td>";
                                            echo "<td style='text-align:center;border-right: 1px solid #cdd0d4;'>" . number_format($total_amount_prc). "</td>";
                                            echo "<td style='text-align:center;border-right: 1px solid #cdd0d4;'>" . number_format($total_amount_brk). "</td>";
                                            echo "<td style='text-align:center;border-right: 1px solid #cdd0d4;'>" . number_format($total_amount_stu). "</td>";
                                            echo "<td style='text-align:center;border-right: 1px solid #cdd0d4;'>" . number_format($total_amount_tri). "</td>";

                                            echo "<td style='text-align:center;border-right: 1px solid #cdd0d4;'>" . number_format($isi->PRC_01). "</td>";
                                            echo "<td style='text-align:center;border-right: 1px solid #cdd0d4;'>" . number_format($isi->PRC_02). "</td>";
                                            echo "<td style='text-align:center;border-right: 1px solid #cdd0d4;'>" . number_format($isi->PRC_03). "</td>";
                                            echo "<td style='text-align:center;border-right: 1px solid #cdd0d4;'>" . number_format($isi->PRC_04). "</td>";
                                            echo "<td style='text-align:center;border-right: 1px solid #cdd0d4;'>" . number_format($isi->PRC_05). "</td>";
                                            echo "<td style='text-align:center;border-right: 1px solid #cdd0d4;'>" . number_format($isi->PRC_06). "</td>";
                                            echo "<td style='text-align:center;border-right: 1px solid #cdd0d4;'>" . number_format($isi->PRC_07). "</td>";
                                            echo "<td style='text-align:center;border-right: 1px solid #cdd0d4;'>" . number_format($isi->PRC_08). "</td>";
                                            echo "<td style='text-align:center;border-right: 1px solid #cdd0d4;'>" . number_format($isi->PRC_09). "</td>";
                                            echo "<td style='text-align:center;border-right: 1px solid #cdd0d4;'>" . number_format($isi->PRC_10). "</td>";
                                            echo "<td style='text-align:center;border-right: 1px solid #cdd0d4;'>" . number_format($isi->PRC_11). "</td>";
                                            echo "<td style='text-align:center;border-right: 1px solid #cdd0d4;'>" . number_format($isi->PRC_12). "</td>";
                                            echo "<td style='text-align:center;border-right: 1px solid #cdd0d4;'>" . number_format($isi->PRC_13). "</td>";
                                            echo "<td style='text-align:center;border-right: 1px solid #cdd0d4;'>" . number_format($isi->PRC_14). "</td>";
                                            echo "<td style='text-align:center;border-right: 1px solid #cdd0d4;'>" . number_format($isi->PRC_15). "</td>";
                                            echo "<td style='text-align:center;border-right: 1px solid #cdd0d4;'>" . number_format($isi->PRC_16). "</td>";
                                            echo "<td style='text-align:center;border-right: 1px solid #cdd0d4;'>" . number_format($isi->PRC_17). "</td>";
                                            echo "<td style='text-align:center;border-right: 1px solid #cdd0d4;'>" . number_format($isi->PRC_18). "</td>";
                                            echo "<td style='text-align:center;border-right: 1px solid #cdd0d4;'>" . number_format($isi->PRC_19). "</td>";
                                            echo "<td style='text-align:center;border-right: 1px solid #cdd0d4;'>" . number_format($isi->PRC_20). "</td>";
                                            echo "<td style='text-align:center;border-right: 1px solid #cdd0d4;'>" . number_format($isi->PRC_21). "</td>";
                                            echo "<td style='text-align:center;border-right: 1px solid #cdd0d4;'>" . number_format($isi->PRC_22). "</td>";
                                            echo "<td style='text-align:center;border-right: 1px solid #cdd0d4;'>" . number_format($isi->PRC_23). "</td>";
                                            echo "<td style='text-align:center;border-right: 1px solid #cdd0d4;'>" . number_format($isi->PRC_24). "</td>";
                                            echo "<td style='text-align:center;border-right: 1px solid #cdd0d4;'>" . number_format($isi->PRC_25). "</td>";
                                            echo "<td style='text-align:center;border-right: 1px solid #cdd0d4;'>" . number_format($isi->PRC_26). "</td>";
                                            echo "<td style='text-align:center;border-right: 1px solid #cdd0d4;'>" . number_format($isi->PRC_27). "</td>";
                                            echo "<td style='text-align:center;border-right: 1px solid #cdd0d4;'>" . number_format($isi->PRC_28). "</td>";
                                            echo "<td style='text-align:center;border-right: 1px solid #cdd0d4;'>" . number_format($isi->PRC_29). "</td>";
                                            echo "<td style='text-align:center;border-right: 1px solid #cdd0d4;'>" . number_format($isi->PRC_30). "</td>";
                                            echo "<td style='text-align:center;border-right: 1px solid #cdd0d4;'>" . number_format($isi->PRC_31). "</td>";
                                            
                                            echo "<td style='text-align:center;border-right: 1px solid #cdd0d4;'>" . number_format($isi->BRK_01). "</td>";
                                            echo "<td style='text-align:center;border-right: 1px solid #cdd0d4;'>" . number_format($isi->BRK_02). "</td>";
                                            echo "<td style='text-align:center;border-right: 1px solid #cdd0d4;'>" . number_format($isi->BRK_03). "</td>";
                                            echo "<td style='text-align:center;border-right: 1px solid #cdd0d4;'>" . number_format($isi->BRK_04). "</td>";
                                            echo "<td style='text-align:center;border-right: 1px solid #cdd0d4;'>" . number_format($isi->BRK_05). "</td>";
                                            echo "<td style='text-align:center;border-right: 1px solid #cdd0d4;'>" . number_format($isi->BRK_06). "</td>";
                                            echo "<td style='text-align:center;border-right: 1px solid #cdd0d4;'>" . number_format($isi->BRK_07). "</td>";
                                            echo "<td style='text-align:center;border-right: 1px solid #cdd0d4;'>" . number_format($isi->BRK_08). "</td>";
                                            echo "<td style='text-align:center;border-right: 1px solid #cdd0d4;'>" . number_format($isi->BRK_09). "</td>";
                                            echo "<td style='text-align:center;border-right: 1px solid #cdd0d4;'>" . number_format($isi->BRK_10). "</td>";
                                            echo "<td style='text-align:center;border-right: 1px solid #cdd0d4;'>" . number_format($isi->BRK_11). "</td>";
                                            echo "<td style='text-align:center;border-right: 1px solid #cdd0d4;'>" . number_format($isi->BRK_12). "</td>";
                                            echo "<td style='text-align:center;border-right: 1px solid #cdd0d4;'>" . number_format($isi->BRK_13). "</td>";
                                            echo "<td style='text-align:center;border-right: 1px solid #cdd0d4;'>" . number_format($isi->BRK_14). "</td>";
                                            echo "<td style='text-align:center;border-right: 1px solid #cdd0d4;'>" . number_format($isi->BRK_15). "</td>";
                                            echo "<td style='text-align:center;border-right: 1px solid #cdd0d4;'>" . number_format($isi->BRK_16). "</td>";
                                            echo "<td style='text-align:center;border-right: 1px solid #cdd0d4;'>" . number_format($isi->BRK_17). "</td>";
                                            echo "<td style='text-align:center;border-right: 1px solid #cdd0d4;'>" . number_format($isi->BRK_18). "</td>";
                                            echo "<td style='text-align:center;border-right: 1px solid #cdd0d4;'>" . number_format($isi->BRK_19). "</td>";
                                            echo "<td style='text-align:center;border-right: 1px solid #cdd0d4;'>" . number_format($isi->BRK_20). "</td>";
                                            echo "<td style='text-align:center;border-right: 1px solid #cdd0d4;'>" . number_format($isi->BRK_21). "</td>";
                                            echo "<td style='text-align:center;border-right: 1px solid #cdd0d4;'>" . number_format($isi->BRK_22). "</td>";
                                            echo "<td style='text-align:center;border-right: 1px solid #cdd0d4;'>" . number_format($isi->BRK_23). "</td>";
                                            echo "<td style='text-align:center;border-right: 1px solid #cdd0d4;'>" . number_format($isi->BRK_24). "</td>";
                                            echo "<td style='text-align:center;border-right: 1px solid #cdd0d4;'>" . number_format($isi->BRK_25). "</td>";
                                            echo "<td style='text-align:center;border-right: 1px solid #cdd0d4;'>" . number_format($isi->BRK_26). "</td>";
                                            echo "<td style='text-align:center;border-right: 1px solid #cdd0d4;'>" . number_format($isi->BRK_27). "</td>";
                                            echo "<td style='text-align:center;border-right: 1px solid #cdd0d4;'>" . number_format($isi->BRK_28). "</td>";
                                            echo "<td style='text-align:center;border-right: 1px solid #cdd0d4;'>" . number_format($isi->BRK_29). "</td>";
                                            echo "<td style='text-align:center;border-right: 1px solid #cdd0d4;'>" . number_format($isi->BRK_30). "</td>";
                                            echo "<td style='text-align:center;border-right: 1px solid #cdd0d4;'>" . number_format($isi->BRK_31). "</td>";

                                            echo "<td style='text-align:center;border-right: 1px solid #cdd0d4;'>" . number_format($isi->STU_01). "</td>";
                                            echo "<td style='text-align:center;border-right: 1px solid #cdd0d4;'>" . number_format($isi->STU_02). "</td>";
                                            echo "<td style='text-align:center;border-right: 1px solid #cdd0d4;'>" . number_format($isi->STU_03). "</td>";
                                            echo "<td style='text-align:center;border-right: 1px solid #cdd0d4;'>" . number_format($isi->STU_04). "</td>";
                                            echo "<td style='text-align:center;border-right: 1px solid #cdd0d4;'>" . number_format($isi->STU_05). "</td>";
                                            echo "<td style='text-align:center;border-right: 1px solid #cdd0d4;'>" . number_format($isi->STU_06). "</td>";
                                            echo "<td style='text-align:center;border-right: 1px solid #cdd0d4;'>" . number_format($isi->STU_07). "</td>";
                                            echo "<td style='text-align:center;border-right: 1px solid #cdd0d4;'>" . number_format($isi->STU_08). "</td>";
                                            echo "<td style='text-align:center;border-right: 1px solid #cdd0d4;'>" . number_format($isi->STU_09). "</td>";
                                            echo "<td style='text-align:center;border-right: 1px solid #cdd0d4;'>" . number_format($isi->STU_10). "</td>";
                                            echo "<td style='text-align:center;border-right: 1px solid #cdd0d4;'>" . number_format($isi->STU_11). "</td>";
                                            echo "<td style='text-align:center;border-right: 1px solid #cdd0d4;'>" . number_format($isi->STU_12). "</td>";
                                            echo "<td style='text-align:center;border-right: 1px solid #cdd0d4;'>" . number_format($isi->STU_13). "</td>";
                                            echo "<td style='text-align:center;border-right: 1px solid #cdd0d4;'>" . number_format($isi->STU_14). "</td>";
                                            echo "<td style='text-align:center;border-right: 1px solid #cdd0d4;'>" . number_format($isi->STU_15). "</td>";
                                            echo "<td style='text-align:center;border-right: 1px solid #cdd0d4;'>" . number_format($isi->STU_16). "</td>";
                                            echo "<td style='text-align:center;border-right: 1px solid #cdd0d4;'>" . number_format($isi->STU_17). "</td>";
                                            echo "<td style='text-align:center;border-right: 1px solid #cdd0d4;'>" . number_format($isi->STU_18). "</td>";
                                            echo "<td style='text-align:center;border-right: 1px solid #cdd0d4;'>" . number_format($isi->STU_19). "</td>";
                                            echo "<td style='text-align:center;border-right: 1px solid #cdd0d4;'>" . number_format($isi->STU_20). "</td>";
                                            echo "<td style='text-align:center;border-right: 1px solid #cdd0d4;'>" . number_format($isi->STU_21). "</td>";
                                            echo "<td style='text-align:center;border-right: 1px solid #cdd0d4;'>" . number_format($isi->STU_22). "</td>";
                                            echo "<td style='text-align:center;border-right: 1px solid #cdd0d4;'>" . number_format($isi->STU_23). "</td>";
                                            echo "<td style='text-align:center;border-right: 1px solid #cdd0d4;'>" . number_format($isi->STU_24). "</td>";
                                            echo "<td style='text-align:center;border-right: 1px solid #cdd0d4;'>" . number_format($isi->STU_25). "</td>";
                                            echo "<td style='text-align:center;border-right: 1px solid #cdd0d4;'>" . number_format($isi->STU_26). "</td>";
                                            echo "<td style='text-align:center;border-right: 1px solid #cdd0d4;'>" . number_format($isi->STU_27). "</td>";
                                            echo "<td style='text-align:center;border-right: 1px solid #cdd0d4;'>" . number_format($isi->STU_28). "</td>";
                                            echo "<td style='text-align:center;border-right: 1px solid #cdd0d4;'>" . number_format($isi->STU_29). "</td>";
                                            echo "<td style='text-align:center;border-right: 1px solid #cdd0d4;'>" . number_format($isi->STU_30). "</td>";
                                            echo "<td style='text-align:center;border-right: 1px solid #cdd0d4;'>" . number_format($isi->STU_31). "</td>";

                                            echo "<td style='text-align:center;border-right: 1px solid #cdd0d4;'>" . number_format($isi->TRI_01). "</td>";
                                            echo "<td style='text-align:center;border-right: 1px solid #cdd0d4;'>" . number_format($isi->TRI_02). "</td>";
                                            echo "<td style='text-align:center;border-right: 1px solid #cdd0d4;'>" . number_format($isi->TRI_03). "</td>";
                                            echo "<td style='text-align:center;border-right: 1px solid #cdd0d4;'>" . number_format($isi->TRI_04). "</td>";
                                            echo "<td style='text-align:center;border-right: 1px solid #cdd0d4;'>" . number_format($isi->TRI_05). "</td>";
                                            echo "<td style='text-align:center;border-right: 1px solid #cdd0d4;'>" . number_format($isi->TRI_06). "</td>";
                                            echo "<td style='text-align:center;border-right: 1px solid #cdd0d4;'>" . number_format($isi->TRI_07). "</td>";
                                            echo "<td style='text-align:center;border-right: 1px solid #cdd0d4;'>" . number_format($isi->TRI_08). "</td>";
                                            echo "<td style='text-align:center;border-right: 1px solid #cdd0d4;'>" . number_format($isi->TRI_09). "</td>";
                                            echo "<td style='text-align:center;border-right: 1px solid #cdd0d4;'>" . number_format($isi->TRI_10). "</td>";
                                            echo "<td style='text-align:center;border-right: 1px solid #cdd0d4;'>" . number_format($isi->TRI_11). "</td>";
                                            echo "<td style='text-align:center;border-right: 1px solid #cdd0d4;'>" . number_format($isi->TRI_12). "</td>";
                                            echo "<td style='text-align:center;border-right: 1px solid #cdd0d4;'>" . number_format($isi->TRI_13). "</td>";
                                            echo "<td style='text-align:center;border-right: 1px solid #cdd0d4;'>" . number_format($isi->TRI_14). "</td>";
                                            echo "<td style='text-align:center;border-right: 1px solid #cdd0d4;'>" . number_format($isi->TRI_15). "</td>";
                                            echo "<td style='text-align:center;border-right: 1px solid #cdd0d4;'>" . number_format($isi->TRI_16). "</td>";
                                            echo "<td style='text-align:center;border-right: 1px solid #cdd0d4;'>" . number_format($isi->TRI_17). "</td>";
                                            echo "<td style='text-align:center;border-right: 1px solid #cdd0d4;'>" . number_format($isi->TRI_18). "</td>";
                                            echo "<td style='text-align:center;border-right: 1px solid #cdd0d4;'>" . number_format($isi->TRI_19). "</td>";
                                            echo "<td style='text-align:center;border-right: 1px solid #cdd0d4;'>" . number_format($isi->TRI_20). "</td>";
                                            echo "<td style='text-align:center;border-right: 1px solid #cdd0d4;'>" . number_format($isi->TRI_21). "</td>";
                                            echo "<td style='text-align:center;border-right: 1px solid #cdd0d4;'>" . number_format($isi->TRI_22). "</td>";
                                            echo "<td style='text-align:center;border-right: 1px solid #cdd0d4;'>" . number_format($isi->TRI_23). "</td>";
                                            echo "<td style='text-align:center;border-right: 1px solid #cdd0d4;'>" . number_format($isi->TRI_24). "</td>";
                                            echo "<td style='text-align:center;border-right: 1px solid #cdd0d4;'>" . number_format($isi->TRI_25). "</td>";
                                            echo "<td style='text-align:center;border-right: 1px solid #cdd0d4;'>" . number_format($isi->TRI_26). "</td>";
                                            echo "<td style='text-align:center;border-right: 1px solid #cdd0d4;'>" . number_format($isi->TRI_27). "</td>";
                                            echo "<td style='text-align:center;border-right: 1px solid #cdd0d4;'>" . number_format($isi->TRI_28). "</td>";
                                            echo "<td style='text-align:center;border-right: 1px solid #cdd0d4;'>" . number_format($isi->TRI_29). "</td>";
                                            echo "<td style='text-align:center;border-right: 1px solid #cdd0d4;'>" . number_format($isi->TRI_30). "</td>";
                                            echo "<td style='text-align:center;border-right: 1px solid #cdd0d4;'>" . number_format($isi->TRI_31). "</td>";

                                            
                                            echo "<td style='text-align:center;border-right: 1px solid #cdd0d4;'>" . number_format($isi->APRC_01). "</td>";
                                            echo "<td style='text-align:center;border-right: 1px solid #cdd0d4;'>" . number_format($isi->APRC_02). "</td>";
                                            echo "<td style='text-align:center;border-right: 1px solid #cdd0d4;'>" . number_format($isi->APRC_03). "</td>";
                                            echo "<td style='text-align:center;border-right: 1px solid #cdd0d4;'>" . number_format($isi->APRC_04). "</td>";
                                            echo "<td style='text-align:center;border-right: 1px solid #cdd0d4;'>" . number_format($isi->APRC_05). "</td>";
                                            echo "<td style='text-align:center;border-right: 1px solid #cdd0d4;'>" . number_format($isi->APRC_06). "</td>";
                                            echo "<td style='text-align:center;border-right: 1px solid #cdd0d4;'>" . number_format($isi->APRC_07). "</td>";
                                            echo "<td style='text-align:center;border-right: 1px solid #cdd0d4;'>" . number_format($isi->APRC_08). "</td>";
                                            echo "<td style='text-align:center;border-right: 1px solid #cdd0d4;'>" . number_format($isi->APRC_09). "</td>";
                                            echo "<td style='text-align:center;border-right: 1px solid #cdd0d4;'>" . number_format($isi->APRC_10). "</td>";
                                            echo "<td style='text-align:center;border-right: 1px solid #cdd0d4;'>" . number_format($isi->APRC_11). "</td>";
                                            echo "<td style='text-align:center;border-right: 1px solid #cdd0d4;'>" . number_format($isi->APRC_12). "</td>";
                                            echo "<td style='text-align:center;border-right: 1px solid #cdd0d4;'>" . number_format($isi->APRC_13). "</td>";
                                            echo "<td style='text-align:center;border-right: 1px solid #cdd0d4;'>" . number_format($isi->APRC_14). "</td>";
                                            echo "<td style='text-align:center;border-right: 1px solid #cdd0d4;'>" . number_format($isi->APRC_15). "</td>";
                                            echo "<td style='text-align:center;border-right: 1px solid #cdd0d4;'>" . number_format($isi->APRC_16). "</td>";
                                            echo "<td style='text-align:center;border-right: 1px solid #cdd0d4;'>" . number_format($isi->APRC_17). "</td>";
                                            echo "<td style='text-align:center;border-right: 1px solid #cdd0d4;'>" . number_format($isi->APRC_18). "</td>";
                                            echo "<td style='text-align:center;border-right: 1px solid #cdd0d4;'>" . number_format($isi->APRC_19). "</td>";
                                            echo "<td style='text-align:center;border-right: 1px solid #cdd0d4;'>" . number_format($isi->APRC_20). "</td>";
                                            echo "<td style='text-align:center;border-right: 1px solid #cdd0d4;'>" . number_format($isi->APRC_21). "</td>";
                                            echo "<td style='text-align:center;border-right: 1px solid #cdd0d4;'>" . number_format($isi->APRC_22). "</td>";
                                            echo "<td style='text-align:center;border-right: 1px solid #cdd0d4;'>" . number_format($isi->APRC_23). "</td>";
                                            echo "<td style='text-align:center;border-right: 1px solid #cdd0d4;'>" . number_format($isi->APRC_24). "</td>";
                                            echo "<td style='text-align:center;border-right: 1px solid #cdd0d4;'>" . number_format($isi->APRC_25). "</td>";
                                            echo "<td style='text-align:center;border-right: 1px solid #cdd0d4;'>" . number_format($isi->APRC_26). "</td>";
                                            echo "<td style='text-align:center;border-right: 1px solid #cdd0d4;'>" . number_format($isi->APRC_27). "</td>";
                                            echo "<td style='text-align:center;border-right: 1px solid #cdd0d4;'>" . number_format($isi->APRC_28). "</td>";
                                            echo "<td style='text-align:center;border-right: 1px solid #cdd0d4;'>" . number_format($isi->APRC_29). "</td>";
                                            echo "<td style='text-align:center;border-right: 1px solid #cdd0d4;'>" . number_format($isi->APRC_30). "</td>";
                                            echo "<td style='text-align:center;border-right: 1px solid #cdd0d4;'>" . number_format($isi->APRC_31). "</td>";
                                            
                                            echo "<td style='text-align:center;border-right: 1px solid #cdd0d4;'>" . number_format($isi->ABRK_01). "</td>";
                                            echo "<td style='text-align:center;border-right: 1px solid #cdd0d4;'>" . number_format($isi->ABRK_02). "</td>";
                                            echo "<td style='text-align:center;border-right: 1px solid #cdd0d4;'>" . number_format($isi->ABRK_03). "</td>";
                                            echo "<td style='text-align:center;border-right: 1px solid #cdd0d4;'>" . number_format($isi->ABRK_04). "</td>";
                                            echo "<td style='text-align:center;border-right: 1px solid #cdd0d4;'>" . number_format($isi->ABRK_05). "</td>";
                                            echo "<td style='text-align:center;border-right: 1px solid #cdd0d4;'>" . number_format($isi->ABRK_06). "</td>";
                                            echo "<td style='text-align:center;border-right: 1px solid #cdd0d4;'>" . number_format($isi->ABRK_07). "</td>";
                                            echo "<td style='text-align:center;border-right: 1px solid #cdd0d4;'>" . number_format($isi->ABRK_08). "</td>";
                                            echo "<td style='text-align:center;border-right: 1px solid #cdd0d4;'>" . number_format($isi->ABRK_09). "</td>";
                                            echo "<td style='text-align:center;border-right: 1px solid #cdd0d4;'>" . number_format($isi->ABRK_10). "</td>";
                                            echo "<td style='text-align:center;border-right: 1px solid #cdd0d4;'>" . number_format($isi->ABRK_11). "</td>";
                                            echo "<td style='text-align:center;border-right: 1px solid #cdd0d4;'>" . number_format($isi->ABRK_12). "</td>";
                                            echo "<td style='text-align:center;border-right: 1px solid #cdd0d4;'>" . number_format($isi->ABRK_13). "</td>";
                                            echo "<td style='text-align:center;border-right: 1px solid #cdd0d4;'>" . number_format($isi->ABRK_14). "</td>";
                                            echo "<td style='text-align:center;border-right: 1px solid #cdd0d4;'>" . number_format($isi->ABRK_15). "</td>";
                                            echo "<td style='text-align:center;border-right: 1px solid #cdd0d4;'>" . number_format($isi->ABRK_16). "</td>";
                                            echo "<td style='text-align:center;border-right: 1px solid #cdd0d4;'>" . number_format($isi->ABRK_17). "</td>";
                                            echo "<td style='text-align:center;border-right: 1px solid #cdd0d4;'>" . number_format($isi->ABRK_18). "</td>";
                                            echo "<td style='text-align:center;border-right: 1px solid #cdd0d4;'>" . number_format($isi->ABRK_19). "</td>";
                                            echo "<td style='text-align:center;border-right: 1px solid #cdd0d4;'>" . number_format($isi->ABRK_20). "</td>";
                                            echo "<td style='text-align:center;border-right: 1px solid #cdd0d4;'>" . number_format($isi->ABRK_21). "</td>";
                                            echo "<td style='text-align:center;border-right: 1px solid #cdd0d4;'>" . number_format($isi->ABRK_22). "</td>";
                                            echo "<td style='text-align:center;border-right: 1px solid #cdd0d4;'>" . number_format($isi->ABRK_23). "</td>";
                                            echo "<td style='text-align:center;border-right: 1px solid #cdd0d4;'>" . number_format($isi->ABRK_24). "</td>";
                                            echo "<td style='text-align:center;border-right: 1px solid #cdd0d4;'>" . number_format($isi->ABRK_25). "</td>";
                                            echo "<td style='text-align:center;border-right: 1px solid #cdd0d4;'>" . number_format($isi->ABRK_26). "</td>";
                                            echo "<td style='text-align:center;border-right: 1px solid #cdd0d4;'>" . number_format($isi->ABRK_27). "</td>";
                                            echo "<td style='text-align:center;border-right: 1px solid #cdd0d4;'>" . number_format($isi->ABRK_28). "</td>";
                                            echo "<td style='text-align:center;border-right: 1px solid #cdd0d4;'>" . number_format($isi->ABRK_29). "</td>";
                                            echo "<td style='text-align:center;border-right: 1px solid #cdd0d4;'>" . number_format($isi->ABRK_30). "</td>";
                                            echo "<td style='text-align:center;border-right: 1px solid #cdd0d4;'>" . number_format($isi->ABRK_31). "</td>";

                                            echo "<td style='text-align:center;border-right: 1px solid #cdd0d4;'>" . number_format($isi->ASTU_01). "</td>";
                                            echo "<td style='text-align:center;border-right: 1px solid #cdd0d4;'>" . number_format($isi->ASTU_02). "</td>";
                                            echo "<td style='text-align:center;border-right: 1px solid #cdd0d4;'>" . number_format($isi->ASTU_03). "</td>";
                                            echo "<td style='text-align:center;border-right: 1px solid #cdd0d4;'>" . number_format($isi->ASTU_04). "</td>";
                                            echo "<td style='text-align:center;border-right: 1px solid #cdd0d4;'>" . number_format($isi->ASTU_05). "</td>";
                                            echo "<td style='text-align:center;border-right: 1px solid #cdd0d4;'>" . number_format($isi->ASTU_06). "</td>";
                                            echo "<td style='text-align:center;border-right: 1px solid #cdd0d4;'>" . number_format($isi->ASTU_07). "</td>";
                                            echo "<td style='text-align:center;border-right: 1px solid #cdd0d4;'>" . number_format($isi->ASTU_08). "</td>";
                                            echo "<td style='text-align:center;border-right: 1px solid #cdd0d4;'>" . number_format($isi->ASTU_09). "</td>";
                                            echo "<td style='text-align:center;border-right: 1px solid #cdd0d4;'>" . number_format($isi->ASTU_10). "</td>";
                                            echo "<td style='text-align:center;border-right: 1px solid #cdd0d4;'>" . number_format($isi->ASTU_11). "</td>";
                                            echo "<td style='text-align:center;border-right: 1px solid #cdd0d4;'>" . number_format($isi->ASTU_12). "</td>";
                                            echo "<td style='text-align:center;border-right: 1px solid #cdd0d4;'>" . number_format($isi->ASTU_13). "</td>";
                                            echo "<td style='text-align:center;border-right: 1px solid #cdd0d4;'>" . number_format($isi->ASTU_14). "</td>";
                                            echo "<td style='text-align:center;border-right: 1px solid #cdd0d4;'>" . number_format($isi->ASTU_15). "</td>";
                                            echo "<td style='text-align:center;border-right: 1px solid #cdd0d4;'>" . number_format($isi->ASTU_16). "</td>";
                                            echo "<td style='text-align:center;border-right: 1px solid #cdd0d4;'>" . number_format($isi->ASTU_17). "</td>";
                                            echo "<td style='text-align:center;border-right: 1px solid #cdd0d4;'>" . number_format($isi->ASTU_18). "</td>";
                                            echo "<td style='text-align:center;border-right: 1px solid #cdd0d4;'>" . number_format($isi->ASTU_19). "</td>";
                                            echo "<td style='text-align:center;border-right: 1px solid #cdd0d4;'>" . number_format($isi->ASTU_20). "</td>";
                                            echo "<td style='text-align:center;border-right: 1px solid #cdd0d4;'>" . number_format($isi->ASTU_21). "</td>";
                                            echo "<td style='text-align:center;border-right: 1px solid #cdd0d4;'>" . number_format($isi->ASTU_22). "</td>";
                                            echo "<td style='text-align:center;border-right: 1px solid #cdd0d4;'>" . number_format($isi->ASTU_23). "</td>";
                                            echo "<td style='text-align:center;border-right: 1px solid #cdd0d4;'>" . number_format($isi->ASTU_24). "</td>";
                                            echo "<td style='text-align:center;border-right: 1px solid #cdd0d4;'>" . number_format($isi->ASTU_25). "</td>";
                                            echo "<td style='text-align:center;border-right: 1px solid #cdd0d4;'>" . number_format($isi->ASTU_26). "</td>";
                                            echo "<td style='text-align:center;border-right: 1px solid #cdd0d4;'>" . number_format($isi->ASTU_27). "</td>";
                                            echo "<td style='text-align:center;border-right: 1px solid #cdd0d4;'>" . number_format($isi->ASTU_28). "</td>";
                                            echo "<td style='text-align:center;border-right: 1px solid #cdd0d4;'>" . number_format($isi->ASTU_29). "</td>";
                                            echo "<td style='text-align:center;border-right: 1px solid #cdd0d4;'>" . number_format($isi->ASTU_30). "</td>";
                                            echo "<td style='text-align:center;border-right: 1px solid #cdd0d4;'>" . number_format($isi->ASTU_31). "</td>";

                                            echo "<td style='text-align:center;border-right: 1px solid #cdd0d4;'>" . number_format($isi->ATRI_01). "</td>";
                                            echo "<td style='text-align:center;border-right: 1px solid #cdd0d4;'>" . number_format($isi->ATRI_02). "</td>";
                                            echo "<td style='text-align:center;border-right: 1px solid #cdd0d4;'>" . number_format($isi->ATRI_03). "</td>";
                                            echo "<td style='text-align:center;border-right: 1px solid #cdd0d4;'>" . number_format($isi->ATRI_04). "</td>";
                                            echo "<td style='text-align:center;border-right: 1px solid #cdd0d4;'>" . number_format($isi->ATRI_05). "</td>";
                                            echo "<td style='text-align:center;border-right: 1px solid #cdd0d4;'>" . number_format($isi->ATRI_06). "</td>";
                                            echo "<td style='text-align:center;border-right: 1px solid #cdd0d4;'>" . number_format($isi->ATRI_07). "</td>";
                                            echo "<td style='text-align:center;border-right: 1px solid #cdd0d4;'>" . number_format($isi->ATRI_08). "</td>";
                                            echo "<td style='text-align:center;border-right: 1px solid #cdd0d4;'>" . number_format($isi->ATRI_09). "</td>";
                                            echo "<td style='text-align:center;border-right: 1px solid #cdd0d4;'>" . number_format($isi->ATRI_10). "</td>";
                                            echo "<td style='text-align:center;border-right: 1px solid #cdd0d4;'>" . number_format($isi->ATRI_11). "</td>";
                                            echo "<td style='text-align:center;border-right: 1px solid #cdd0d4;'>" . number_format($isi->ATRI_12). "</td>";
                                            echo "<td style='text-align:center;border-right: 1px solid #cdd0d4;'>" . number_format($isi->ATRI_13). "</td>";
                                            echo "<td style='text-align:center;border-right: 1px solid #cdd0d4;'>" . number_format($isi->ATRI_14). "</td>";
                                            echo "<td style='text-align:center;border-right: 1px solid #cdd0d4;'>" . number_format($isi->ATRI_15). "</td>";
                                            echo "<td style='text-align:center;border-right: 1px solid #cdd0d4;'>" . number_format($isi->ATRI_16). "</td>";
                                            echo "<td style='text-align:center;border-right: 1px solid #cdd0d4;'>" . number_format($isi->ATRI_17). "</td>";
                                            echo "<td style='text-align:center;border-right: 1px solid #cdd0d4;'>" . number_format($isi->ATRI_18). "</td>";
                                            echo "<td style='text-align:center;border-right: 1px solid #cdd0d4;'>" . number_format($isi->ATRI_19). "</td>";
                                            echo "<td style='text-align:center;border-right: 1px solid #cdd0d4;'>" . number_format($isi->ATRI_20). "</td>";
                                            echo "<td style='text-align:center;border-right: 1px solid #cdd0d4;'>" . number_format($isi->ATRI_21). "</td>";
                                            echo "<td style='text-align:center;border-right: 1px solid #cdd0d4;'>" . number_format($isi->ATRI_22). "</td>";
                                            echo "<td style='text-align:center;border-right: 1px solid #cdd0d4;'>" . number_format($isi->ATRI_23). "</td>";
                                            echo "<td style='text-align:center;border-right: 1px solid #cdd0d4;'>" . number_format($isi->ATRI_24). "</td>";
                                            echo "<td style='text-align:center;border-right: 1px solid #cdd0d4;'>" . number_format($isi->ATRI_25). "</td>";
                                            echo "<td style='text-align:center;border-right: 1px solid #cdd0d4;'>" . number_format($isi->ATRI_26). "</td>";
                                            echo "<td style='text-align:center;border-right: 1px solid #cdd0d4;'>" . number_format($isi->ATRI_27). "</td>";
                                            echo "<td style='text-align:center;border-right: 1px solid #cdd0d4;'>" . number_format($isi->ATRI_28). "</td>";
                                            echo "<td style='text-align:center;border-right: 1px solid #cdd0d4;'>" . number_format($isi->ATRI_29). "</td>";
                                            echo "<td style='text-align:center;border-right: 1px solid #cdd0d4;'>" . number_format($isi->ATRI_30). "</td>";
                                            echo "<td style='text-align:center;border-right: 1px solid #cdd0d4;'>" . number_format($isi->ATRI_31). "</td>";

                                            
                                            $r++;
                                           ?>
                                            </tr>
                                            <?php
                                        } 
                                    ?>
                                </tbody>
                            </table>

                            <table id="exportToExcel" class="table table-condensed table-bordered table-striped table-hover display" cellspacing="0" width="100%"  style="display:none;">
                            </table>

                            <span style="margin-top:-26px;background:yellow;" class='pull-right'>Data was acquired at <strong></strong></span>
                        </div>
                    </div>
      

<script src="<?php echo base_url('assets/js/jquery-1.12.3.js') ?>"></script>
<script src="<?php echo base_url('assets/js/jquery.dataTables.min.js') ?>"></script>
<script src="<?php echo base_url('assets/js/dataTables.fixedColumns.min.js') ?>"></script>
<script>
                                                $(document).ready(function () {

                                                    var table = $('#example').DataTable({
                                                        scrollY: "600px",
                                                        scrollX: true,
                                                        scrollCollapse: true,
                                                        paging: false,
                                                        columnDefs: [{
                                                                sortable: false,
                                                                "class": "index",
                                                                targets: 0
                                                            }],
                                                        order: [[1, 'asc']],
                                                        fixedColumns: {
                                                            leftColumns: 2
                                                        }
                                                    });

                                                    table.on('order.dt search.dt', function () {
                                                        table.column(0, {search: 'applied', order: 'applied'}).nodes().each(function (cell, i) {
                                                            //cell.innerHTML = i + 1;
                                                        });
                                                    }).draw();
                                                });

</script>