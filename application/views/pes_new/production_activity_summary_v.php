<script src="<?php echo base_url('assets/js/raphael-min.js') ?>"></script>
<script src="<?php echo base_url('assets/js/justgage.min.js') ?>"></script>
<script>
$(document).ready(function () {
        
    var date = new Date();
    $("#datepicker1").datepicker({dateFormat: 'yymmdd'}).val();

});
</script>


<style>
.gauge-content {
    padding-left: 8%;
    padding-right: 7%;
    padding-top: 3%;
}
.gauge {
    width:120px; 
    height:80px;
    display: inline-block;
}
</style>

<div class="row">
    <div class="grid-body">
        <div class="col-md-12">
        <table width="50%">
            <?php echo form_open('pes_new/production_activity_c/prod_activity_summary', 'class="form-horizontal"'); ?>
            <tr>
                <td width="5%">
                    <input name="CHR_DATE" id="datepicker1" class="form-control" autocomplete="off" required type="text" style="width:120px;" value="<?php echo $date; ?>">
                </td>
                <td width="95%" colspan="4">
                    <button type="submit" class="btn btn-primary" style="margin-top: 3px;margin-bottom: 2px;"><span class="fa fa-filter"></span>&nbsp;&nbsp;Filter</button></td>
                </td>
            </tr>
            <?php form_close(); ?>
        </table>

        <table width="100%" id='filter' border=0px>
            <?php if ($data_eff_per_group_date_up){ ?>
                <tr>
                    <td colspan="2" style="height: 250px; width: 100%;border: 1px solid #C4C1BB;"><div id="container_up" style="height: 250px; width: 100%;"></div></td>
                <tr>
            <?php } ?>
            <?php if ($data_eff_per_group_date_bp||$data_eff_per_group_date_dl){ ?>
                <tr>
                    <td style="height: 250px; width: 50%;border: 1px solid #C4C1BB;"><div id="container_bp" style="height: 250px; width: 100%;"></div></td>
                    <td style="height: 250px; width: 50%;border: 1px solid #C4C1BB;"><div id="container_dl" style="height: 250px; width: 100%;"></div></td>
                <tr>
            <?php } ?>
            <?php if ($data_eff_per_group_date_dr){ ?>
                <tr>
                    <td colspan="2" style="height: 250px; width: 100%;border: 1px solid #C4C1BB;"><div id="container_dr" style="height: 250px; width: 100%;"></div></td>
                <tr>
            <?php } ?>
            <?php if ($data_eff_per_group_date_mg){ ?>
                <tr>
                    <td colspan="2" style="height: 250px; width: 100%;border: 1px solid #C4C1BB;"><div id="container_mg" style="height: 250px; width: 100%;"></div></td>
                <tr>
            <?php } ?>
        </table>
       
	</div>
    </div>

    <a id='modal1-trigger' data-toggle="modal" data-target="#modal1"></a>

    <div class="modal fade" id="modal1" tabindex="-1" role="dialog" aria-labelledby="myModalLabel3" aria-hidden="true">
        <div class="modal-wrapper">
            <div class="modal-dialog">
                <div class="modal-content">
                        <div class="modal-header">
                            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                            <h4 class="modal-title" id="myModalLabel3" ><strong ><span id='work-center'></span> &nbsp;&nbsp;|&nbsp;&nbsp; <?php echo date("d-m-Y", strtotime($date)) ?></strong></h4>
                        </div>
                        <input type='hidden' id='work-center-value'>
                        <div class="modal-body" >     
                            <div class='form-group'>
                                <div class='gauge-content'>
                                    <div id="oee" class='gauge'></div>
                                    <div id="availability" class='gauge'></div>
                                    <div id="performance"  class='gauge'></div>
                                    <div id="quality"  class='gauge'></div>
                                </div>
                            </div>
                            <div  class="pull-right grid-tools" style="padding-right:2%;">
                                <a href="javascript:showDetailActivity()" style='color:#A3A3A3;' title='Show Detail'>&#8226; &#8226; &#8226;</a>
                            </div>   
                            <div class='form-group' id='chart_all_time' style="padding-left:1%;padding-right:1%;">
                            </div>  
                            <div class='form-group' id='list_pd' style="padding-left:1%;padding-right:1%;">
                            </div>
                            <hr>
                            <div class='form-group' id='chart_availability' style="padding-left:1%;padding-right:1%;">
                            </div> 
                            <div class='form-group' id='list_bd' style="padding-left:1%;padding-right:1%;">
                            </div>
                            <div class='form-group' id='list_ud' style="padding-left:1%;padding-right:1%;">
                            </div>
                            <hr>
                            <div class='form-group' id='chart_performance' style="padding-left:1%;padding-right:1%;">
                            </div> 
                            <div class='form-group' id='list_comment' style="padding-left:1%;padding-right:1%;">
                            </div>
                            <div class='form-group'>
                                <div class='alert alert-info' style='font-size:11px;font-style:italic;'>*Produksi aktual hanya inputan dari In Line Scan</div>                  
                            </div>
                            <hr>
                            <div class='form-group' id='chart_quality' style="padding-left:1%;padding-right:1%;">
                            </div> 
                            <div class='form-group' id='list_ng' style="padding-left:1%;padding-right:1%;">
                            </div>
                            <div class='form-group'>
                                <div class='alert alert-warning' style='font-size:11px;font-style:italic;'>*Reject hanya inputan dari In Line Scan</div>                  
                            </div>
                            
                        </div>
                        <div class="modal-footer">
                            <div class="btn-group">
                                <button type="button" class="btn btn-default" data-dismiss="modal"> Close</button>
                            </div>
                        </div>
                </div>
            </div>
        </div>
    </div>


</div>

<script type="text/javascript">

    $(document).ready(function () {
        
        <?php if ($data_eff_per_group_date_up){ ?>

            chart1 = new Highcharts.Chart({
                chart: {
                    height: 250,
                    width:1320,
                    type: 'column',
                    renderTo: 'container_up',
                    plotBorderWidth: 1
                    
                },
                title: {
                    text: 'Unit Parts'
                },
                subtitle: {
                    text: ''
                },
                credits: {
                    enabled: false
                },
                xAxis: {
                    type: 'category',
                    crosshair: true
                },
                yAxis: {
                    max: 120,
                    title: {
                        text: ''
                    },
                    minorGridLineWidth: 0,
                    gridLineWidth: 0,
                    alternateGridColor: null,
                    plotBands: [
                        { 
                            from: 0,
                            to: 0,
                            color: '#FC4444',
                            label: {
                                text: '',
                                style: {
                                    color: '#D3EEF7'
                                }
                            }
                        },
                        { 
                            from: 95,
                            to: 100,
                            color: '#87FF9D'
                        }
                    ]
                },
                legend: {
                    enabled: false
                },
                plotOptions: {
                    series: {
                        cursor: 'pointer',
                        point: {
                            events: {
                                click: function () {
                                    showActivity(this);
                                }
                            }
                        },
                        dataLabels: {
                            enabled: true,
                            format: '{point.y:.1f}'
                        }
                    }
                },
                tooltip: {
                    headerFormat: '<span style="font-size:11px">{series.name}</span><br>',
                    pointFormat: '<span style="color:{point.color}">{point.name}</span>: <b>{point.y:.2f}%</b><br/>',
                    shared: true
                },
                series: [
                    {
                        name: 'OEE',
                        type: 'column',
                        colorByPoint: true,
                        data: [
                                <?php
                                    foreach ($data_eff_per_group_date_up as $isi) {
                                        ?>
                                        {
                                            name: "<?php echo $isi->CHR_WORK_CENTER; ?>",
                                            y: <?php echo $isi->OEE; ?>
                                        },
                                    <?php }
                                ?>
                        ]
                    }
                ],
            });

        <?php } ?>

        <?php if ($data_eff_per_group_date_bp){ ?>

            chart2 = new Highcharts.Chart({
                chart: {
                    height: 250,
                    width:650,
                    type: 'column',
                    renderTo: 'container_bp',
                    plotBorderWidth: 1
                },
                title: {
                    text: 'Body Parts'
                },
                subtitle: {
                    text: ''
                },
                credits: {
                    enabled: false
                },
                xAxis: {
                    type: 'category'
                },
                yAxis: {
                    max: 120,
                    title: {
                        text: ''
                    },
                    minorGridLineWidth: 0,
                    gridLineWidth: 0,
                    alternateGridColor: null,
                    plotBands: [
                        { 
                            from: 0,
                            to: 0,
                            color: '#FC4444',
                            label: {
                                text: '',
                                style: {
                                    color: '#D3EEF7'
                                }
                            }
                        },
                        { 
                            from: 95,
                            to: 100,
                            color: '#87FF9D'
                        }
                    ]
                },
                legend: {
                    enabled: false
                },
                plotOptions: {
                    series: {
                        cursor: 'pointer',
                        point: {
                            events: {
                                click: function () {
                                    showActivity(this);
                                }
                            }
                        },
                        dataLabels: {
                            enabled: true,
                            format: '{point.y:.1f}'
                        }
                    }
                },
                tooltip: {
                    headerFormat: '<span style="font-size:11px">{series.name}</span><br>',
                    pointFormat: '<span style="color:{point.color}">{point.name}</span>: <b>{point.y:.2f}%</b><br/>'
                },

                series: [
                    {
                        name: "Efficiency",
                        colorByPoint: true,
                        data: [
                                <?php
                                    foreach ($data_eff_per_group_date_bp as $isi) {
                                        ?>
                                        {
                                            "name": "<?php echo $isi->CHR_WORK_CENTER; ?>",
                                            "y": <?php echo $isi->OEE; ?>
                                        },
                                    <?php }
                                ?>
                        ]
                    }
                    
                ],
            });
        
        <?php } ?>

        <?php if ($data_eff_per_group_date_dl){ ?>

            chart3 = new Highcharts.Chart({
                chart: {
                    height: 250,
                    width:650,
                    type: 'column',
                    renderTo: 'container_dl',
                    plotBorderWidth: 1
                },
                title: {
                    text: 'Door lock'
                },
                subtitle: {
                    text: ''
                },
                credits: {
                    enabled: false
                },
                xAxis: {
                    type: 'category'
                },
                yAxis: {
                    // type: 'logarithmic',
                    max: 120,
                    title: {
                        text: ''
                    },
                    minorGridLineWidth: 0,
                    gridLineWidth: 0,
                    alternateGridColor: null,
                    plotBands: [
                        { 
                            from: 0,
                            to: 0,
                            color: '#FC4444',
                            label: {
                                text: '',
                                style: {
                                    color: '#D3EEF7'
                                }
                            }
                        },
                        { 
                            from: 95,
                            to: 100,
                            color: '#87FF9D'
                        }
                    ]
                },
                legend: {
                    enabled: false
                },
                plotOptions: {
                    series: {
                        cursor: 'pointer',
                        point: {
                            events: {
                                click: function () {
                                    showActivity(this);
                                }
                            }
                        },
                        dataLabels: {
                            enabled: true,
                            format: '{point.y:.1f}'
                        }
                    }
                },
                tooltip: {
                    headerFormat: '<span style="font-size:11px">{series.name}</span><br>',
                    pointFormat: '<span style="color:{point.color}">{point.name}</span>: <b>{point.y:.2f}%</b><br/>'
                },

                "series": [
                    {
                        "name": "Efficiency",
                        "colorByPoint": true,
                        "data": [
                                <?php
                                    foreach ($data_eff_per_group_date_dl as $isi) {
                                        ?>
                                        {
                                            "name": "<?php echo $isi->CHR_WORK_CENTER; ?>",
                                            "y": <?php echo $isi->OEE; ?>
                                        },
                                    <?php }
                                ?>
                        ]
                    }
                    
                ],
            });

        <?php } ?>

        <?php if ($data_eff_per_group_date_dr){ ?>

            chart4 = new Highcharts.Chart({
                chart: {
                    height: 250,
                    width:1320,
                    type: 'column',
                    renderTo: 'container_dr',
                    plotBorderWidth: 1
                },
                title: {
                    text: 'Door Frame'
                },
                subtitle: {
                    text: ''
                },
                credits: {
                    enabled: false
                },
                xAxis: {
                    type: 'category'
                },
                yAxis: {
                    max: 120,
                    title: {
                        text: ''
                    },
                    minorGridLineWidth: 0,
                    gridLineWidth: 0,
                    alternateGridColor: null,
                    plotBands: [
                        { 
                            from: 0,
                            to: 0,
                            color: '#FC4444',
                            label: {
                                text: '',
                                style: {
                                    color: '#D3EEF7'
                                }
                            }
                        },
                        { 
                            from: 95,
                            to: 100,
                            color: '#87FF9D'
                        }
                ]
                },
                legend: {
                    enabled: false
                },
                plotOptions: {
                    series: {
                        cursor: 'pointer',
                        point: {
                            events: {
                                click: function () {
                                    showActivity(this);
                                }
                            }
                        },
                        dataLabels: {
                            enabled: true,
                            format: '{point.y:.1f}'
                        }
                    }
                },
                tooltip: {
                    headerFormat: '<span style="font-size:11px">{series.name}</span><br>',
                    pointFormat: '<span style="color:{point.color}">{point.name}</span>: <b>{point.y:.2f}%</b><br/>'
                },

                "series": [
                    {
                        "name": "Efficiency",
                        "colorByPoint": true,
                        "data": [
                                <?php
                                    foreach ($data_eff_per_group_date_dr as $isi) {
                                        ?>
                                        {
                                            "name": "<?php echo $isi->CHR_WORK_CENTER; ?>",
                                            "y": <?php echo $isi->OEE; ?>
                                        },
                                    <?php }
                                ?>
                        ]
                    }
                    
                ],
            });

        <?php } ?>

        <?php if ($data_eff_per_group_date_mg){ ?>

            chart5 = new Highcharts.Chart({
                chart: {
                    height: 250,
                    width:1320,
                    type: 'column',
                    renderTo: 'container_mg',
                    plotBorderWidth: 1,
                    scrollablePlotArea: {
                        minWidth: 1320
                    }
                },
                title: {
                    text: 'Manufacture'
                },
                subtitle: {
                    text: ''
                },
                credits: {
                    enabled: false
                },
                xAxis: {
                    type: 'category'
                },
                yAxis: {
                    // type: 'logarithmic',
                    max: 120,
                    title: {
                        text: ''
                    },
                    minorGridLineWidth: 0,
                    gridLineWidth: 0,
                    alternateGridColor: null,
                    plotBands: [
                        { 
                            from: 0,
                            to: 0,
                            color: '#FC4444',
                            label: {
                                text: '',
                                style: {
                                    color: '#D3EEF7'
                                }
                            }
                        },
                        { 
                            from: 95,
                            to: 100,
                            color: '#87FF9D'
                        }
                    ]
                },
                legend: {
                    enabled: false
                },
                plotOptions: {
                    series: {
                        cursor: 'pointer',
                        point: {
                            events: {
                                click: function () {
                                    showActivity(this);
                                }
                            }
                        },
                        dataLabels: {
                            enabled: true,
                            format: '{point.y:.1f}'
                        }
                    }
                },
                tooltip: {
                    headerFormat: '<span style="font-size:11px">{series.name}</span><br>',
                    pointFormat: '<span style="color:{point.color}">{point.name}</span>: <b>{point.y:.2f}%</b><br/>'
                },

                "series": [
                    {
                        "name": "Efficiency",
                        "colorByPoint": true,
                        "data": [
                                <?php
                                    foreach ($data_eff_per_group_date_mg as $isi) {
                                        ?>
                                        {
                                            "name": "<?php echo $isi->CHR_WORK_CENTER; ?>",
                                            "y": <?php echo $isi->OEE; ?>
                                        },
                                    <?php }
                                ?>
                        ]
                    }
                    
                ],
            });

        <?php } ?>

    });

    var gauge_ava;
    var gauge_pro;
    var gauge_qua;
    var gauge_oee;

    gauge_ava = new JustGage({
        id: 'availability',
        value: 0,
        min: 0,
        max: 100,
        label: "availability",
        levelColorsGradient: false,
        valueFontColor: '#010101',
        valueMinFontSize: 13,
        levelColors: ["#f73434", "#f73434", "#f73434"],
            textRenderer: (v) => { return v + '%'},
    });

    gauge_pro = new JustGage({
        id: 'performance',
        value: 0,
        min: 0,
        max: 100,
        label: "performance",
        levelColorsGradient: false,
        valueFontColor: '#010101',
        valueMinFontSize: 13,
        levelColors: ["#025a9e", "#025a9e", "#025a9e"],
            textRenderer: (v) => { return v + '%'}
    });

    gauge_qua = new JustGage({
        id: 'quality',
        value: 0,
        min: 0,
        max: 100,
        label: "quality",
        levelColorsGradient: false,
        valueFontColor: '#010101',
        valueMinFontSize: 13,
        levelColors: ["#f9c802", "#f9c802", "#f9c802"],
            textRenderer: (v) => { return v + '%'}
    });

    gauge_oee = new JustGage({
        id: 'oee',
        value: 0,
        min: 0,
        max: 100,
        label: "oee",
        levelColorsGradient: false,
        valueFontColor: '#010101',
        valueMinFontSize: 13,
        levelColors: ["#2be332", "#2be332", "#2be332"],
            textRenderer: (v) => { return v + '%'}
    });

    function showActivity(e){
        $.ajax({
            async: false,
            type: "POST",
            dataType: 'json',
            url: "<?php echo site_url('pes_new/production_activity_c/get_data_by_work_center_and_date'); ?>",
            data: "CHR_WORK_CENTER=" + e.name + "&CHR_DATE=" + '<?php echo $date ?>',
            success: function (data) {
                document.getElementById('modal1-trigger').click();

                $("#list_pd").html(data.list_pd);
                $("#list_ud").html(data.list_ud);
                $("#list_bd").html(data.list_bd);
                $("#list_comment").html(data.list_comment);
                $("#list_ng").html(data.list_ng);

                $("#chart_all_time").html(data.chart_all_time);
                $("#chart_availability").html(data.chart_availability);
                $("#chart_performance").html(data.chart_performance);
                $("#chart_quality").html(data.chart_quality);
                
                gauge_ava.refresh(data.INT_AVAILABILITY);
                gauge_pro.refresh(data.INT_PRODUCTIVITY);
                gauge_qua.refresh(data.INT_QUALITY);
                gauge_oee.refresh(data.INT_OEE);

                document.getElementById('work-center').innerHTML=e.name;
                document.getElementById('work-center-value').value=e.name;
            },
            error: function(request) {
                alert(request.responseText);
            }
        });
    }

    function showDetailActivity() 
    { 
        var work_center = document.getElementById('work-center-value').value;
        var date = document.getElementById('datepicker1').value;

        var url = 'index/' + date + '/' + work_center;
        window.open(url); 
    } 

</script>