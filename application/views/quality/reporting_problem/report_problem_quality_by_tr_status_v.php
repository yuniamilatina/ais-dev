
<script type="text/javascript" src="<?php echo base_url('assets/script/canvasjs.min.js') ?>"></script>
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
    #filterdiagram {
        border-spacing: 5px;
        border-color: #DDDDDD;
        background-color: #F3F4F5;
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
            <li><a href="<?php echo base_url('index.php/basis/home_c/'); ?>"><span>Home</span></a></li>
            <li><a href=""><strong>QUALITY PROBLEM REPORT</strong></a></li>
        </ol>
    </section>

    <section class="content">
        
        <div class="row">
            <div class="col-md-12">
                <!-- REPORT OVERTIME BY HOUR -->
                <script type="text/javascript">
                    window.onload = function () {
                        var chart = new CanvasJS.Chart("chartContainer",
                                {
                                    theme: "theme2",
                                    //animationEnabled: true,
                                    title: {
                                        //text: "",
                                        //fontSize: 30
                                    },                                    
                                    axisY: {
                                        title: "QTY Case",
                                        gridThickness:0.2,
                                        interval: 5
                                    },                                    
                                    axisX: {
                                        labelFontSize: 13,
                                        interval: 1
                                    },
                                    data: [

<?php
$count_status = count($tr_status);
$no = 1;
foreach($tr_status as $isi){
    if($no != $count_status) {
        echo '{
                type: "column",
                name: "'.$isi->STATUS.'",
                legendText: "'.$isi->STATUS.'",
                toolTipContent: "'.$isi->STATUS.'",
                indexLabelPlacement: "outside",
                indexLabelOrientation: "horizontal",
                indexLabelFontSize: 13,
                indexLabelFontColor: "black",
                showInLegend: true,
                dataPoints: [';
        
        $get_section = $this->db->query("SELECT A.INT_ID_SECTION_PIC AS INT_ID_SECTION_PIC
                                        ,B.CHR_SECTION AS CHR_SECTION
                                        ,B.CHR_SECTION_DESC AS CHR_SECTION_DESC
                                        ,A.INT_STATUS AS INT_STATUS
                                        ,COUNT(A.[CHR_QPROBLEM_TITLE]) AS QTY_CASE        
                                    FROM [QUA].[TT_QUALITY_PROBLEM] A
                                    LEFT JOIN [TM_SECTION] B ON A.INT_ID_SECTION_PIC = B.INT_ID_SECTION
                                    WHERE A.INT_STATUS = '$isi->INT_STATUS'
                                        AND A.CHR_START_DATE LIKE '$date_selected%'
                                        AND A.INT_ID_SECTION_PIC LIKE '$section%'
                                    GROUP BY A.INT_ID_SECTION_PIC, B.CHR_SECTION, A.INT_STATUS, B.CHR_SECTION_DESC                                          
                                    ORDER BY COUNT([CHR_QPROBLEM_TITLE]) DESC")->result();
        
        $count_sect = count($get_section);
        $count_all = count($data_section);        
        foreach($data_section as $data){
            $row = 1;
            foreach($get_section as $sect){
                if($data->INT_ID_SECTION_PIC == $sect->INT_ID_SECTION_PIC){
                    if ($row != $count_all){
                        echo '{y:' . $sect->QTY_CASE . ', label: "' . $data->CHR_SECTION . '", indexLabel: "'. $sect->QTY_CASE .'"},';
                    } else {
                        echo '{y:' . $sect->QTY_CASE . ', label: "' . $data->CHR_SECTION . '", indexLabel: "'. $sect->QTY_CASE.'"}'; 
                    }                        
                } else {
                    if ($row != $count_all){
                        echo '{y:0, label: "' . $data->CHR_SECTION . '"},';
                    } else {
                        echo '{y:0, label: "' . $data->CHR_SECTION . '"}'; 
                    }
                }
            }
            $row++;
        }
        echo ']},';    
    } else {
        echo '{
                type: "column",
                name: "'.$isi->STATUS.'",
                legendText: "'.$isi->STATUS.'",
                toolTipContent: "'.$isi->STATUS.'",
                indexLabelPlacement: "outside",
                indexLabelOrientation: "horizontal",
                indexLabelFontSize: 13,
                indexLabelFontColor: "black",
                showInLegend: true,
                dataPoints: [';
        
        $get_section = $this->db->query("SELECT A.INT_ID_SECTION_PIC AS INT_ID_SECTION_PIC
                                        ,B.CHR_SECTION AS CHR_SECTION
                                        ,B.CHR_SECTION_DESC AS CHR_SECTION_DESC
                                        ,A.INT_STATUS AS INT_STATUS
                                        ,COUNT(A.[CHR_QPROBLEM_TITLE]) AS QTY_CASE        
                                    FROM [QUA].[TT_QUALITY_PROBLEM] A
                                    LEFT JOIN [TM_SECTION] B ON A.INT_ID_SECTION_PIC = B.INT_ID_SECTION
                                    WHERE A.INT_STATUS = '$isi->INT_STATUS'
                                        AND A.CHR_START_DATE LIKE '$date_selected%'
                                        AND A.INT_ID_SECTION_PIC LIKE '$section%'
                                    GROUP BY A.INT_ID_SECTION_PIC, B.CHR_SECTION, A.INT_STATUS, B.CHR_SECTION_DESC                                          
                                    ORDER BY COUNT([CHR_QPROBLEM_TITLE]) DESC")->result();
        
        $count_sect = count($get_section);
        $count_all = count($data_section);        
        foreach($data_section as $data){
            $row = 1;
            foreach($get_section as $sect){
                if($data->INT_ID_SECTION_PIC == $sect->INT_ID_SECTION_PIC){
                    if ($row != $count_all){
                        echo '{y:' . $sect->QTY_CASE . ', label: "' . $data->CHR_SECTION . '", indexLabel: "'. $sect->QTY_CASE .'"},';
                    } else {
                        echo '{y:' . $sect->QTY_CASE . ', label: "' . $data->CHR_SECTION . '", indexLabel: "'. $sect->QTY_CASE .'"}'; 
                    }                        
                } else {
                    if ($row != $count_all){
                        echo '{y:0, label: "' . $data->CHR_SECTION . '"},';
                    } else {
                        echo '{y:0, label: "' . $data->CHR_SECTION . '"}'; 
                    }
                }
            }
            $row++;
        }
        echo ']}';
    }
    $no++;
}
?>

                                    ],
                                    legend: {
                                        cursor: "pointer",
                                        itemclick: function (e) {
                                            if (typeof (e.dataSeries.visible) === "undefined" || e.dataSeries.visible) {
                                                e.dataSeries.visible = false;
                                            }
                                            else {
                                                e.dataSeries.visible = true;
                                            }
                                            chart.render();
                                        }
                                    }
                                });

                        chart.render();
                    }
                </script>

                <div class="grid">
                    <div class="grid-header">
                        <i class="fa fa-bar-chart-o"></i>
                        <span class="grid-title">PROBLEM REPORT BY <strong>TR STATUS</strong></span>
                        <div class="pull-right grid-tools">
                            <a data-widget="collapse" title="Collapse"><i class="fa fa-chevron-up"></i></a>
                        </div>
                    </div>
                    <div class="grid-body">
                        <div>
                            <table width="100%" id='filter'>
                                <tr>
                                    <td width="10%">Periode</td>
                                    <td width="20%">
                                        <select class="ddl" id="tanggal" onChange="document.location.href = this.options[this.selectedIndex].value;">
                                            <?php for ($x = -5; $x <= 5; $x++) { ?>
                                                <option value="<?php echo site_url('quality/quality_problem_c/report_by_tr_status/' . date("Ym", strtotime("+$x month")) . '/ALL'); ?>" <?php
                                                if ($date_selected == date("Ym", strtotime("+$x month"))) {
                                                    echo 'SELECTED';
                                                }
                                                ?> > <?php echo date("M Y", strtotime("+$x month")); ?> </option>
                                                    <?php } ?>
                                        </select>
                                    </td>
                                    <td width="70%"></td>
                                </tr>
                                <tr>
                                    <td width="10%">Section (BP)</td>
                                    <td width="20%">
                                        <select class="ddl" id="section" onChange="document.location.href = this.options[this.selectedIndex].value;">
                                            <option value="<?php echo site_url('quality/quality_problem_c/report_by_tr_status/' . $date_selected . '/ALL'); ?>">ALL</option>
                                            <?php foreach ($data_section as $sect) { ?>
                                                <option value="<?php echo site_url('quality/quality_problem_c/report_by_tr_status/' . $date_selected . '/' . $sect->INT_ID_SECTION_PIC); ?>" <?php
                                                if ($section == $sect->INT_ID_SECTION_PIC) {
                                                    echo 'SELECTED';
                                                }
                                                ?> > <?php echo $sect->CHR_SECTION. ' (' .$sect->CHR_SECTION_DESC . ')'; ?> </option>
                                                    <?php } ?>
                                        </select>
                                    </td>
                                    <td width="70%"></td>                                    
                                </tr>
                                <tr></tr>
                                <tr></tr>
                            </table>
                        </div>
                        <?php if ($data_by_tr_status == null) { ?>
                            <table width=100% border:1px id='filterdiagram' ><td> No data available in diagram</td></table>
                        <?php } else { ?>
                            <div id="chartContainer" style="height: 350px; width: 100%;"></div>
                        <?php } ?>

                    </div>
                    
                </div>
            </div>
        </div>
       
    </section>
</aside>
