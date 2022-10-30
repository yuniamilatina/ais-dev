<script type="text/javascript" src="<?php echo base_url('assets/script/canvasjs.min.js') ?>"></script>
<script src="<?php echo base_url('assets/js/jquery-1.12.3.js') ?>"></script>
<script type="text/javascript">

    $(document).ready(function () {
        var c = document.getElementById("opt_sloc");
        $('#backno').autocomplete({
            source: function(request, response) {
                $.getJSON('<?php echo site_url('/samanta/spare_parts_trans_c/search/'); ?>', {
                    term: request.term,
                    loc: c.options[c.selectedIndex].text
                }, response)
            },
            minLength: 1,
            focus: function( event, ui ) {
                $( "#backno" ).val( ui.item.label );
                return false;
            },
            select: function( event, ui ) {
                $( "#backno" ).val( ui.item.value);
                return false;
            }        
        });
    }); 

    
</script>
<!-- Onclick -->

<?php echo $margin->DEC_TOLERANSI_MIN; ?>
<script>

window.onload = function () {
    
    var chart = new CanvasJS.Chart("part_chart", {
        // animationEnabled: true,
        // exportEnabled: true,
        axisY: {
            title: "Value",
            // interval: 0.2,
            minimum : <?php echo ($margin->DEC_TOLERANSI_MIN-1) ?>,            
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
                    
                $i=$i+1; } ?>
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
                        <span class="grid-title"><strong>PART SPESIFICATION CHART</strong> </span>
                    </div>
                    <div class="grid-body">
                        <div class="pull">
                                <table width="100%" border=0px>
                                    <tr>
                                        <?php echo form_open('patricia/part_chart_c/get_chart', 'class="form-horizontal"'); ?>
                                        <td width="5%">Part Number</td>
                                        <td width="10%" style='padding-right:5px;'>
                                            <select  name="CHR_COMPONENT_ID" id="e1" class="form-control" style="width:100%" onchange="get_spec_by_part();" >
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
                                        <td width="5%">Specification</td>
                                        <td width="10%">
                                            <select id='spesification' name="CHR_SPEK" class="form-control" style="width:220px" >
                                                <?php foreach ($list_spek as $row) { 
                                                    if (trim($selected_spek) == trim($row->INT_SPECIFICATION_ID)){  ?>
                                                         <option selected value="<?php echo $row->INT_SPECIFICATION_ID ?>"><?php echo $row->CHR_SPECIFICATION ?></option>
                                                    <?php } else {  ?>
                                                         <option value="<?php echo $row->INT_SPECIFICATION_ID ?>"><?php echo $row->CHR_SPECIFICATION ?></option>
                                                    <?php }
                                                } ?>
                                            </select>
                                        </td>
                                        <td width="10%">
                                            <button style="width: 110px;" type="submit" id="Search" name="Search" onclick="search()" class="btn btn-primary" data-placement="left" data-toggle="tooltip" title="Filter this data"><i class="fa fa-search"></i> Search</button>
                                        </td>
                                        <?php echo form_close(); ?>
                                        <td width="15%">
                                            <?php if($selected_part!='' && $selected_spek!= '') { ?>
                                                <a style="width: 110px;" href="<?php echo site_url('patricia/part_chart_c/export/'. trim($selected_part).'/'.$selected_spek); ?>" id="Search" name="Search"  class="btn btn-primary" data-placement="left" data-toggle="tooltip" title="Export to Excel"><i class="fa fa-download"></i> Export Excel</button>   
                                            <?php } ?>
                                        </td>
                                    </tr>
                                </table>
                        </div>

                        <?php if ($data[0]->CHR_COMPONENT_ID == 0 && $data[0]->DEC_NILAI == 0) { ?>
                             <table width=100%  style="height: 50px; width: 100%;margin-top:20px;"><td>No data available in diagram</td></table>
                        <?php } else { ?>
                               <div id="part_chart" style="height: 300px; width: 100%;margin-top:20px;"></div>
                        <?php } ?>

                        <div class="pull" style='font-style: italic;'>
                            <table border=0px id="spek" <?php if(!$margin){ ?> style="display: none;" <?php } ?> >
                                <tr>
                                    <td>Standard : </td>
                                    <td><strong><?php echo $margin->DEC_STD.' mm';  ?></strong></td>
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

            function get_spec_by_part(){
                var partno = document.getElementById('e1').value;
        
                $.ajax({
                    async: false,
                    type: "POST",
                    dataType: 'json',
                    url: "<?php echo site_url('patricia/part_chart_c/get_specification_by_partno'); ?>",
                    data:  {
                            CHR_COMPONENT_ID: partno
                            },
                    success: function (json_data) {
                        $("#spesification").html(json_data['data']);
                    },
                    error: function (request) {
                        alert(request.responseText);
                    }
                });
            }
</script>
