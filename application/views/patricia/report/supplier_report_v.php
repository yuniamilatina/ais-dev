<script type="text/javascript" src="<?php echo base_url('assets/script/canvasjs.min.js') ?>"></script>
<script src="<?php echo base_url('assets/js/jquery-1.12.3.js') ?>"></script>
<!-- <script >
window.onload = function () {
var chart = new CanvasJS.Chart("chart_supplier", {
    animationEnabled: true,
    axisX: {
            title: "Supplier Name",
        },
        axisY: {
            title: "Percentage (*in %)",
            gridThickness: 0.3
        },
    theme: "theme", // "light1", "light2", "dark1", "dark2"
    data: [{

        type: "column", //change type to bar, line, area, pie, etc

        indexLabelFontColor: "#5A5757",
        indexLabelPlacement: "outside",
        name: "Performa Supplier ",
        dataPoints: [
            <?php foreach ($data as $row) { ?>
                { label: '<?php echo $row->CHR_NAMA_VENDOR ?>', y: <?php echo $row->hasil ?> },
           <?php  } ?>

        ]
    }]
});
chart.render();

}

</script> -->

<script>

window.onload = function () {

var chart = new CanvasJS.Chart("chart_supplier", {
    animationEnabled: true,
    title: {
    },
    axisX: {
        valueFormatString: "MMM YYYY",
        interval: 1,
        intervalType: "month",
        crosshair: {
            enabled: true,
            snapToDataPoint: true
        }
    },
    axisY2: {
        title: "PERFORMANCE",
        suffix: "%"
    },
    toolTip: {
        shared: true
    },
    legend: {
        verticalAlign: "top",
        horizontalAlign: "center",
        dockInsidePlotArea: true,
        itemclick: toogleDataSeries
    },
    data: [
    <?php foreach ($daftarsupplier as $row) { ?>
        {
            type:"spline",
            axisYType: "secondary",
            name: '<?php echo $row->CHR_NAMA_VENDOR ?>',
            showInLegend: true,
            yValueFormatString: "#0.##",
            dataPoints: [
                <?php foreach ($data as $barisdata) { 
                    if($barisdata->CHR_NAMA_VENDOR == $row->CHR_NAMA_VENDOR) {
                ?>

                    { x: new Date(<?php echo substr($barisdata->Bulan,0,4);  ?>, <?php echo ((substr($barisdata->Bulan,4))-1) ?>, 01), y: <?php echo ($barisdata->hasil*100) ?> },
                <?php  } }?>
            ]
        },
   <?php  } ?>
    
    ]
});
chart.render();

function toogleDataSeries(e){
    if (typeof(e.dataSeries.visible) === "undefined" || e.dataSeries.visible) {
        e.dataSeries.visible = false;
    } else{
        e.dataSeries.visible = true;
    }
    chart.render();
}

}
</script>
<aside class="right-side">
    <section class="content-header">
        <ol class="breadcrumb">
            <li><a href="<?php echo base_url('index.php/basis/home_c/"') ?>"><span>Home</span></a></li>
            <li> <a href="#"><strong>REPORT SUPPLIER PERFORMANCE</strong></a></li>
        </ol>
    </section>

    <section class="content">
        <?php if ($msg != NULL) {
            echo $msg;
        } ?>


        <div class="row">
            <div class="col-md-12">
                <div class="grid">
                    <div class="grid-header">
                        <i class="fa fa-sitemap"></i>
                        <span class="grid-title"><strong>REPORT SUPPLIER PERFORMANCE</strong> CHART</span>
                    </div>
                    <!-- <div class="grid-body">
                        <input name="CHR_DATE_SELECTED" value="<?php echo $selected_date ?>" type="hidden">
                        <div class="pull">
                            <table width="70%" id='filter' border=0px>
                                <tr>
                                    <td width="5%">Periode</td>
                                    <td width="10%">
                                        <select id="tanggal" class="form-control" style="width:150px;" id="date" onchange="document.location.href = this.options[this.selectedIndex].value;">
                                            <?php for ($x = -8; $x <= 0; $x++) { ?>
                                                <option value="<?php echo site_url('patricia/supplier_report_c/search/' . date("Ym", strtotime("+$x month")).'/'.$selected_supplier.''); ?>"<?php
                                                if ($selected_date == date("Ym", strtotime("+$x month"))) {
                                                    echo 'SELECTED';
                                                }
                                                ?> > <?php echo date("M Y", strtotime("+$x month")); ?>
                                                </option>
                                            <?php } ?>
                                        </select>
                                    </td>
                                    <td width="5%">Supplier</td>
                                    <td width="15%">
                                        <select  id="e1" class="form-control" style="width:150px;" id="date" onchange="document.location.href = this.options[this.selectedIndex].value;">
                                            <option value="<?php echo site_url('patricia/supplier_report_c/search/'.$selected_date.'/ ') ?>">ALL</option>
                                            <?php foreach ($list_supplier as $list) { ?>
                                                
                                                <option value="<?php echo site_url('patricia/supplier_report_c/search/'.$selected_date.'/'.$list->CHR_KODE_VENDOR ); ?>"<?php
                                                if ($selected_supplier == $list->CHR_KODE_VENDOR) {
                                                    echo 'SELECTED';
                                                }
                                                ?> > <?php echo $list->CHR_NAMA_VENDOR; ?>
                                                </option>
                                            <?php } ?>
                                        </select>
                                    </td>
                            </table>
                        </div>
                        <br/>
                        <br/>
                        <div id="chart_supplier" style="height: 280px; width: 100%;">     
                        </div>
                        
                    </div> -->
                    <div class="grid-body">
                        <input name="CHR_DATE_SELECTED" value="<?php echo $selected_date ?>" type="hidden">
                        <div class="pull">
                            <form method="POST" action="<?php echo site_url('patricia/supplier_report_c/search/'); ?>">
                                <table width="100%" id='filter' border=0px>
                                    <tr>
                                        <td width="10%">Fiscal Year</td>
                                        <td width="5%">
                                            <select name="date"  class="form-control" style="width:150px;" id="date" >
                                                <?php for ($x = -8; $x <= 0; $x++) { ?>
                                                    <option value="<?php echo date("Y", strtotime("+$x year")) ?>"<?php
                                                    if ($selected_date == date("Y", strtotime("+$x year"))) {
                                                        echo 'SELECTED';
                                                    }
                                                    ?> > <?php echo date("Y", strtotime("+$x year")); ?>
                                                    </option>
                                                <?php } ?>
                                            </select>
                                        </td>
                                        <td width="10%">Supplier</td>
                                        <td width="10%">
                                            <select name="supplier"  id="e1" class="form-control" style="width:300px;" id="date" >
                                                <option value="">ALL</option>
                                                <?php foreach ($list_supplier as $list) { ?>
                                                    
                                                    <option value="<?php echo $list->CHR_KODE_VENDOR; ?>"<?php
                                                    if ($selected_supplier == $list->CHR_KODE_VENDOR) {
                                                        echo 'SELECTED';
                                                    }
                                                    ?> > <?php echo $list->CHR_NAMA_VENDOR; ?>
                                                    </option>
                                                <?php } ?>
                                            </select>
                                        </td>
                                        <td width=20%">
                                            <button type="submit" class="btn btn-primary" data-placement="left" data-toggle="tooltip" title="Filter this data"><i class="fa fa-search"></i> Search</button>       
                                        </td>
                                    </tr>
                                </table>
                            </form>
                        </div>
                        <br/>
                        <br/>
                        <?php if ($data == 0 ) { ?>
                             <table width=100% id='bp' ><td>No data available in diagram</td></table>
                        <?php } else { ?>
                               <div id="chart_supplier" style="height: 280px; width: 100%;"></div>
                        <?php } ?>
                        <br>
                        <!-- <div id="chart_supplier" style="height: 280px; width: 100%;">      -->
                        
                        
                    </div>
                </div>
                <div class="grid">
                    <div class="grid-header">
                        <i class="fa fa-sitemap"></i>
                        <span class="grid-title"><strong>REPORT SUPPLIER PERFORMANCE</strong> TABLE</span>
                    </div>
                    <div class="grid-body">
                        <table id="dataTables1" class="table table-striped table-condensed table-hover display" cellspacing="0" width="100%">
                            <thead>
                                <tr>
                                    <th>No</th>
                                    <th>Part Number</th>
                                    <th>Part Name</th>
                                    <th>Supplier Name</th>
                                    <th>Month</th>
                                    <th>Successful Check</th>
                                    <th>Number of Checks</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                    $i = 1;
                                    foreach ($datadetil as $isi) {
                                        if($isi->semua>0)
                                        {
                                            echo "<tr class='gradeX'>";
                                            echo "<td>$i</td>";
                                            echo "<td>$isi->CHR_ID_PART</td>";
                                            echo "<td>$isi->CHR_NAMA_PART</td>"; 
                                            echo "<td>$isi->CHR_NAMA_VENDOR</td>";
                                            echo "<td>".date("F Y", strtotime($isi->Bulan.'01'))."</td>";
                                            echo "<td>$isi->berhasil</td>";
                                            echo "<td>$isi->semua</td>";
                                             $i++;
                                        }
                                    ?>

                                    </tr>
                                 <?php
                                       
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


