<script type="text/javascript" src="<?php echo base_url('assets/script/canvasjs.min.js') ?>"></script>

                <!-- REPORT OVERTIME BY HOUR -->
                <script type="text/javascript">
                    window.onload = function () {
                        var chart = new CanvasJS.Chart("chartContainer1",
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
                                        labelFontSize: 11,
                                        interval: 1,
                                        labelAngle: 45
                                    },
                                    data: [                                        
<?php
$count = count($data_by_section);
$no = 1;      
$tot_days = date("t", strtotime($date_selected . "01"));
foreach($data_by_section as $data){
    if($no != $count){
        echo '{
                type: "stackedColumn",                                            
                name: "'.$data->CHR_SECTION.'",
                legendText: "'.$data->CHR_SECTION.'",
                toolTipContent: "'.$data->CHR_SECTION.'",
                showInLegend: true,
                dataPoints: [';
        $problem = $this->db->query("SELECT CHR_START_DATE
                                            ,COUNT([CHR_QPROBLEM_TITLE]) AS QTY_CASE        
                                    FROM [QUA].[TT_QUALITY_PROBLEM]
                                    WHERE INT_ID_SECTION_PIC = '$data->INT_ID_SECTION_PIC' AND CHR_START_DATE LIKE '$date_selected%'
                                    GROUP BY CHR_START_DATE")->result();
        $count_problem = count($problem);
        for ($row = 1; $row <= $tot_days ; $row++){
            $day = sprintf("%02d", $row);
            if($day == substr($data->CHR_START_DATE,6)){
                if ($row != $tot_days){
                    echo '{y:' . $data->QTY_CASE . ', label: "' . $day . '"},';
                } else {
                    echo '{y:' . $data->QTY_CASE . ', label: "' . $day . '"}'; 
                }                        
            } else {
                if ($row != $tot_days){
                    echo '{y:0, label: "' . $day . '"},';
                } else {
                    echo '{y:0, label: "' . $day . '"}'; 
                }
            }
        }
        echo ']},';
        
    } else {
        echo '{
                type: "stackedColumn",                                            
                name: "'.$data->CHR_SECTION.'",
                legendText: "'.$data->CHR_SECTION.'",
                toolTipContent: "'.$data->CHR_SECTION.'",
                indexLabel: "#total",
                indexLabelPlacement: "Outside",
                showInLegend: true,
                dataPoints: [';
        $problem = $this->db->query("SELECT CHR_START_DATE
                                            ,COUNT([CHR_QPROBLEM_TITLE]) AS QTY_CASE        
                                    FROM [QUA].[TT_QUALITY_PROBLEM]
                                    WHERE INT_ID_SECTION_PIC = '$data->INT_ID_SECTION_PIC' AND CHR_START_DATE LIKE '$date_selected%'
                                    GROUP BY CHR_START_DATE")->result();
        $count_problem = count($problem);
        for ($row = 1; $row <= $tot_days ; $row++){
            $day = sprintf("%02d", $row);
            if($day == substr($data->CHR_START_DATE,6)){
                if ($row != $tot_days){
                    echo '{y:' . $data->QTY_CASE . ', label: "' . $day . '"},';
                } else {
                    echo '{y:' . $data->QTY_CASE . ', label: "' . $day . '"}'; 
                }                        
            } else {
                if ($row != $tot_days){
                    echo '{y:0, label: "' . $day . '"},';
                } else {
                    echo '{y:0, label: "' . $day . '"}'; 
                }
            }
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
                
                    <div class="grid-body">
                        
                        <?php if ($data_by_section== null) { ?>
                            <table width=100% border:1px id='filterdiagram' ><td> No data available in diagram</td></table>
                        <?php } else { ?>
                            <div id="chartContainer1" style="height: 350px; width: 100%;"></div>
                        <?php } ?>

                    </div>
