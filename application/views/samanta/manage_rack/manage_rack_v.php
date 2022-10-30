<script type="text/javascript">
    function refreshTable() {
            var opt_wcenter = $("#opt_wcenter option:selected").val();
            var filter = document.getElementById("filter").value;
            var url_iframe = "";
            var frame = document.getElementById("iframe");

            $.ajax({
                url: "<?php echo base_url(); ?>index.php/samanta/spare_parts_rack_c_2/refresh_table",
                type: "POST",
                dataType: 'json',
                data: {INT_ID_OPT_WCENTER: opt_wcenter, FILTER: filter},
                success: function(data) {
                    document.getElementById('sum_table').style.display = 'block';
                    url_iframe = data.url_iframe.trim();
                    frame.src = url_iframe;
                    frame.contentWindow.location = url_iframe;
                }
            });
        }

    $(document).ready(function() {
        var interval_close = setInterval(closeSideBar, 250);
        function closeSideBar() {
            $("#hide-sub-menus").click();
            clearInterval(interval_close);
        }        
        $("#opt_wcenter").change(function() {
            if (($("#opt_wcenter option:selected").val() != '')) {
                refreshTable();
            }
        });
        $('#filter').on('keyup', function(e){
            if(e.keyCode != 8 && e.keyCode != 46)
            {
                refreshTable();
            }              
        });        
    });

    function migrasi(){
        document.getElementById( 'append' ).innerHTML ='';
        var iframevar = document.getElementById("iframe");
        var checkboxes = window.frames['iframe'].document.getElementById('options1').value;
        var checked = window.frames['iframe'].document.getElementById('options1').checked;
        var x =1;
        while(checkboxes != '' )
        {
            if(window.frames['iframe'].$("#options"+x+":checked").val() != undefined)
            {
                //alert();
                var cb = document.createElement( "input" );
                cb.type = "checkbox";
                cb.id = "options"+x;
                cb.name = "options[]";
                cb.value = window.frames['iframe'].$("#options"+x+":checked").val();
                cb.checked = true;
                var text = document.createTextNode( "checkbox" );
                document.getElementById( 'append' ).appendChild( text );
                document.getElementById( 'append' ).appendChild( cb );
                
            }
            x =1 +x;
            checkboxes = window.frames['iframe'].document.getElementById("options"+x).value;
            checked = window.frames['iframe'].document.getElementById("options"+x).checked;
        }
        
    }
</script> 
<aside class="right-side">
    <section class="content-header">
        <ol class="breadcrumb">
            <li><a href="<?php echo base_url('index.php/basis/home_c/"') ?>"><span>Home</span></a></li>
            <li> <a href="#"><strong>Manage Rack Spare Parts</strong></a></li>
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
                        <span class="grid-title"><strong>MANAGE</strong> RACK SPARE PARTS</span>
                        <div class="pull-right">
                            <a href="<?php echo base_url('index.php/samanta/spare_parts_rack_c_2/create_rack/') ?>" class="btn btn-default" data-toggle="tooltip" data-placement="left" title="Create Rack No" style="height:30px;font-size:13px;width:100px;">Create</a>
                        </div>
                    </div>
                    <?php   
                        $attributes = array('target' => '_blank');
                        echo form_open('samanta/spare_parts_rack_c_2/generate_lable_part', $attributes); 
                    ?>
                    <div class="grid-body">
                        <div>
                            <table width="65%">
                            <!-- <td><a href="<?php $attributes = array('target' => '_blank'); echo base_url('index.php/samanta/spare_parts_rack_c_2/generate_lable_part_special/', $attributes) ?>" class="btn btn-default" data-toggle="tooltip" data-placement="left" title="Print" style="font-size:12px;height:31px;width:120px;"><i class="fa fa-print"></i>&nbsp;Label Special</a></td> -->
                            <td><button type="submit" name="gen_label" value="1" onclick="migrasi()" class="btn btn-warning tip-right" title="Print"/><i class="fa fa-print"></i>&nbsp;Print Label</button></td>
                            <td><button type="submit" name="gen_label" value="2" onclick="migrasi()" class="btn btn-default tip-right" title="Print"/><i class="fa fa-print"></i>&nbsp;Special</button></td>
                            <td witdh = "10%"></td>
                            <td>Warehouse Area</td>
                            <td>
                                <select id="opt_wcenter" name="CHR_DEPT_SELECTED" class="form-control" style="width:200px;">
                                    <option value="ALL">ALL</option>
                                    <?php foreach ($all_area as $row) { ?>
                                        <option value="<?php echo  $row->LOCATION; ?>" <?php
                                        if ($selected_area == trim($row->LOCATION)) {
                                            echo 'SELECTED';
                                        } ?>
                                        ><?php if (trim($row->LOCATION) == 'MT01') { echo "DIES/MOLD MTE"; }
                                        elseif (trim($row->LOCATION) == 'MT02') { echo "DOOR FRAME MTE"; }
                                        elseif (trim($row->LOCATION) == 'MT03') { echo "MACHINE MTE"; }
                                        elseif (trim($row->LOCATION) == 'IT01') { echo "MIS"; }
                                        elseif (trim($row->LOCATION) == 'MS01') { echo "MSU"; }
                                        elseif (trim($row->LOCATION) == 'WH30') { echo "CONSUMABLE"; }
                                        elseif (trim($row->LOCATION) == 'EN02') { echo "ENGINEERING"; } ?></option>
                                    <?php } ?>
                                </select>
                            </td>
                            <td>Filter</td>
                            <td width="250px"><input type="text" style="width: 200px" class="form-control" name="filter" id="filter"></td>
                            
                            </table>
                        </div>
                        <br>
                        <div  id="sum_table" style="display:none;">
                            <iframe frameBorder="0" id="iframe" name="iframe" width="100%" height="750" src="<?php echo $url_page ?>"></iframe>
                        </div>
                        <div id="append" name="append" style="display: none;"></div>
                        <?php
                            echo form_close();
                        ?> 
                    </div>
                </div>
            </div>
        </div>
    </section>
</aside>

<script src="<?php echo base_url('assets/js/jquery.dataTables.min.js') ?>"></script>
<script src="<?php echo base_url('assets/js/dataTables.fixedColumns.min.js') ?>"></script>
<link rel="stylesheet" href="<?php echo base_url('assets/css/fixedColumns.dataTables.min.css'); ?>" >
<script>
    $("#flowcheckall").change(function () {
        $('tbody input[type="checkbox"]').prop('checked', this.checked);
    });

    $(document).ready(function (){
        var table = $('#example2').DataTable({
            scrollY: "100px",
            scrollX: true,
            scrollCollapse: true,
            paging: false,
            bFilter: false
        });
    });
</script>

