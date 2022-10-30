<script type="text/javascript" src="<?php echo base_url('assets/script/canvasjs.min.js') ?>"></script>
<!-- <script src="https://code.highcharts.com/highcharts.js"></script> -->
<script src="<?php echo base_url('assets/js/jquery-1.12.3.js') ?>"></script>
<script type="text/javascript">
    setTimeout(function () {
        document.getElementById("hide-sub-menus").click();
    }, 30);
</script>
<!-- Onclick -->


<script>
window.onload = function () {    
    var chart = new CanvasJS.Chart("part_chart", {
        axisY: {
            title: "Value",
            minimum : <?php echo ($margin->DEC_TOLERANSI_MIN-0.5) ?>,
            maximum : <?php echo ($margin->DEC_TOLERANSI_MAX+0.5) ?>,
            stripLines: [
                {
                color:"#ff0000",
                labelFontSize:12,
                labelFontWeight:"Bold",
                labelMargin:10,
                labelPlacement: "outside",
                value: <?php echo $margin->DEC_TOLERANSI_MAX ?>,
                label: "Max (<?php echo $margin->DEC_TOLERANSI_MAX ?> )"
            },{
                color:"#ff0000",
                labelFontSize:12,
                labelFontWeight:"Bold",
                labelMargin:20,
                labelPlacement: "outside",
                value: <?php echo $margin->DEC_TOLERANSI_MIN ?>,
                label: "Min (<?php echo $margin->DEC_TOLERANSI_MIN ?> )"
            }]
        },
        axisX: 
        {
            title :"Number of Part",
        },
        data: [{
            showInLegend: true,
            legendText: "Value Specification Part",
            type: "spline",
            dataPoints: [
                <?php $i=1; foreach ($data as $row){ 
                    $label = $i;
                    if($row->DEC_NILAI > $margin->DEC_TOLERANSI_MAX || $row->DEC_NILAI < $margin->DEC_TOLERANSI_MIN)
                    {
                ?>
                        { y: <?php echo $row->DEC_NILAI ?>,indexLabel: "NG",color: "#ff3d00",label:<?php echo $label; ?>},
                        
                <?php
                    }
                    else
                    {
                ?>
                        { color: "#00c853",label:<?php echo $label; ?>,y: <?php echo $row->DEC_NILAI ?>},
                        
                <?php
                    }                    
                    $i=$i+1;} ?>
            ]
        }]
    });
    chart.render();    
}
</script>

<aside class="right-side">
    <section class="content-header">
        <ol class="breadcrumb">
            <li><a href="<?php echo base_url('index.php/basis/home_c/"') ?>"><span>Home</span></a></li>
            <li> <a href="#"><strong>PART SPESIFICATION CHART</strong></a></li>
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
                        <span class="grid-title"><strong>QC WIS CHART</strong> </span>
                    </div>
                    <div class="grid-body">
                        <div class="pull">
                                <table width="100%" border=0px>
                                <?php echo form_open('patricia/part_chart_c/get_chart_new', 'class="form-horizontal"'); ?>
                                    <!-- <tr>
                                        <td width="5%">Search By</td>
                                        <td width="10%" style='padding-right:5px;'>
                                            <input type="radio" onclick="CheckInput();" name="CHR_TYPE" id="inp_1" value="1" checked> &nbsp; Part No &nbsp;
                                            <input type="radio" onclick="CheckInput();" name="CHR_TYPE" id="inp_2" value="2"> &nbsp; Prod Order
                                        </td>
                                    </tr> -->
                                    <tr>
                                        <td width="5%">Part No</td>
                                        <td width="10%" >
                                            <select  name="CHR_PART_ID" id="e1" class="form-control" style="width:75%;" onchange="get_param_by_part();" >
                                                <?php foreach ($list_part as $list) { ?>
                                                    <option value="<?php echo trim($list->CHR_ID_PART); ?>" <?php
                                                    if ($selected_part == trim($list->CHR_ID_PART)) {
                                                        echo 'SELECTED';
                                                    }
                                                    ?> ><?php echo trim($list->CHR_ID_PART). " - " . trim($list->CHR_BACK_NO); ?></option>
                                                <?php } ?> 
                                            </select>
                                            <input name="SELECTED_CHR_COMPONENT_ID" value="<?php echo $selected_part ?>" type="hidden">
                                        </td>                                        
                                        <!-- <td width="1%"></td> -->
                                        <td width="5%">Parameter</td>
                                        <td width="10%">
                                            <select id='parameter' name="CHR_PARAM" class="form-control" style="width:220px" >
                                                <?php foreach ($list_param as $prm) { ?>
                                                    <option value="<?php echo trim($prm->CHR_ID_PARAM); ?>" <?php
                                                    if ($selected_spek == trim($prm->CHR_ID_PARAM)) {
                                                        echo 'SELECTED';
                                                    }
                                                    ?> ><?php echo trim($prm->CHR_PARAMETER); ?></option>
                                                <?php } ?>
                                            </select>
                                        </td>
                                        <!-- <td width="3%"></td>
                                        <td width="6%">Prod Order</td>
                                        <td width="10%" style='padding-right:5px;'>
                                            <select id="e2" name="CHR_PRD_ORDER_NO" class="form-control" style="width:220px; display:none;" >                                                
                                                <?php foreach ($list_prod as $row) { ?>
                                                    <option value="<?php echo trim($row->CHR_PRD_ORDER_NO); ?>" <?php
                                                    if (trim($prod_no) == trim($row->CHR_PRD_ORDER_NO)) {
                                                        echo 'SELECTED';
                                                    }
                                                    ?> ><?php echo trim($row->CHR_PRD_ORDER_NO). " - " . trim($row->CHR_PRD_ORDER_NO); ?></option>
                                                <?php } ?>
                                            </select>
                                        </td> -->
                                        <td width="10%">
                                            <button style="width: 90px;" type="submit" id="Search" name="Search" onclick="search()" value="1" class="btn btn-primary" data-placement="left" data-toggle="tooltip" title="Filter this data"><i class="fa fa-search"></i> Search</button>
                                        </td>
                                        
                                        <td width="15%">
                                            <?php if($selected_part!='' && $selected_spek!= '') { ?>
                                                <a style="width: 110px;" href="<?php echo site_url('patricia/part_chart_c/export_inline/'. trim($selected_part).'/'.$selected_spek.'/'.$date_from.'/'.$date_to); ?>" id="Search" name="Search"  class="btn btn-primary" data-placement="left" data-toggle="tooltip" title="Export to Excel"><i class="fa fa-download"></i> Export Excel</button>   
                                            <?php } ?>
                                        </td>
                                    </tr>
                                    <tr height="70">
                                        <td width="5%">Date from</td>
                                        <td width="10%">
                                            <input name="CHR_DATE_FROM" id="datepicker1" class="form-control" autocomplete="off" required type="text" style="width:130px;" value="<?php echo date("d-m-Y", strtotime($date_from)); ?>">
                                        </td>
                                        <td width="5%">to</td>
                                        <td width="10%" style="text-align:right;">
                                            <input name="CHR_DATE_TO" id="datepicker" class="form-control" autocomplete="off" required type="text" style="width:130px;" value="<?php echo date("d-m-Y", strtotime($date_to)); ?>">
                                        </td>      
                                        <?php echo form_close(); ?>      
                                    </tr>
                                </table>
                        </div>

                        <?php if ($data[0]->CHR_PART_ID == 0 && $data[0]->DEC_NILAI == 0) { ?>
                             <table width=100%  style="height: 50px; width: 100%;margin-top:20px;"><td>No data available in diagram</td></table>
                        <?php } else { ?>
                               <div id="part_chart" style="height: 300px; width: 100%;margin-top:20px;"></div>
                        <?php } ?>

                        <div class="pull" style='font-style: italic;'>
                            <table border=0px id="spek" <?php if(!$margin){ ?> style="display: none;" <?php } ?> >
                                <tr>
                                    <td>Hasil Nilai Max : &nbsp;</td>
                                    <td><strong><?php echo $dt_max->max.' mm';  ?></strong></td>
                                    <td></td>
                                </tr>
                                <tr>
                                    <td>Hasil Nilai Min : &nbsp;</td>
                                    <td><strong><?php echo $dt_min->min.' mm';  ?></strong></td>
                                    <td></td>
                                </tr>
                                <tr>
                                    <td>Tolerance :</td>
                                    <td>&nbsp;(MIN) &nbsp;<strong><?php echo $margin->DEC_TOLERANSI_MIN.' mm'; ?></strong>&nbsp;&nbsp;/</td>
                                    <td>&nbsp;(MAX) &nbsp;<strong><?php echo $margin->DEC_TOLERANSI_MAX.' mm'; ?></strong></td>
                                </tr>
                            </table>
                        </div>

                    </div>
                </div>
            </div>
        </div>
        
    </section>
</aside>

<script type="text/javascript" language="javascript">
            function get_param_by_part(){
                var partno = document.getElementById('e1').value;                
        
                $.ajax({
                    async: false,
                    type: "POST",
                    dataType: 'json',
                    url: "<?php echo site_url('patricia/part_chart_c/get_param_by_partno_inline'); ?>",
                    data:  {
                            CHR_PART_ID: partno
                            },
                    success: function (json_data) {
                        $("#parameter").html(json_data['data']);
                    },
                    error: function (request) {
                        alert(request.responseText);
                    }
                });
            }

            // function get_prod_order_by_part(){
            //     var partno = document.getElementById('e1').value;
            //     // var spek = document.getElementById('spesification').value;
        
            //     $.ajax({
            //         async: false,
            //         type: "POST",
            //         dataType: 'json',
            //         url: "<?php echo site_url('patricia/part_chart_c/get_prod_order_by_partno'); ?>",
            //         data:  {
            //                 CHR_COMPONENT_ID: partno
            //                 // ,CHR_SPEK: spek
            //                 },
            //         success: function (json_data) {
            //             $("#e2").html(json_data['data']);
            //         },
            //         error: function (request) {
            //             alert(request.responseText);
            //         }
            //     });
            // }

            // function CheckInput() {
            //     if (document.getElementById('inp_1').checked) {
            //         document.getElementById('e1').style.display = 'block';
            //         document.getElementById('e2').style.display = 'none';
            //     } else {
            //         document.getElementById('e1').style.display = 'none';
            //         document.getElementById('e2').style.display = 'block';
            //     }
            // }
</script>
