<style type="text/css">

    #table-luar{
        font-size: 11px;
    }
    #td_date{
        text-align:center;
        vertical-align:top;
    } 

    #filter { 
        border-spacing: 10px;
        border-collapse: separate;
    }

    #filterdiagram {
        border-spacing: 5px;
        border-color: #DDDDDD;
        background-color: #F3F4F5;
        border : 1px;
    }

    #testDiv{
        width: 100%;
        white-space: nowrap; 
        overflow-x:scroll;
        overflow-y:visible;
        font-size: 12px;
    }
    th, td { white-space: nowrap; }
    div.dataTables_wrapper {
        width: 100%;
        margin: 0 auto;
    }
    .td-fixed{
        width: 30px;
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

<!--<script>
    setTimeout(function () {
        document.getElementById("hide-sub-menus").click();
    }, 10);
//    setInterval(function(){ alert("Hello"); }, 3000);
//    setInterval(document.getElementById("hide-sub-menus").click(), 3000));

</script>-->

<aside class="right-side">
    <section class="content-header">
        <ol class="breadcrumb">
            <li><a href="<?php echo base_url('index.php/basis/home_c/'); ?>"><span>Home</span></a></li>
            <li><a href=""><strong>REPORT PRODUCTION NG</strong></a></li>
        </ol>
    </section>
    <section class="content">

        <!--GRID TO DISPLAY DIAGRAM QUALITY-->
        <div class="row">
            <div class="col-md-12">
                <div class="grid">
                    <div class="grid-header">
                        <i class="fa fa-bar-chart-o"></i>
                        <span class="grid-title"><strong>PRODUCTION NG BY AMOUNT</strong></span>                        
                        <div class="pull-right grid-tools">                            
                            <a href="<?php echo base_url('index.php/pes_new/report_prod_ng_c/update_data_ng_amount"') ?>" class="btn btn-primary"  style="color:white;"><i class="fa fa-refresh"></i>&nbsp; Update Data</a>
                            <a data-widget="collapse" title="Collapse"><i class="fa fa-chevron-up"></i></a>
                        </div>
                        <div class="pull-right grid-tools">                            
                            <!--<a href="<?php echo base_url('index.php/pes_new/report_prod_ng_c/export_data_ng"') ?>" class="btn btn-primary"  style="color:white;"><i class="fa fa-download"></i>&nbsp; Export Data</a>-->   
                            <input type="button" data-toggle="modal" data-target="#modalexport" data-placement="left" title="Export Data" class="btn btn-primary" value="Detail Data">
                        </div>
                        <div class="pull-right grid-tools" valign="middle">
                            <?php
                                $db_report = $this->load->database("db_report", TRUE);
                                $last_updated = $db_report->query("SELECT TOP 1 CHR_CREATED_DATE, CHR_CREATED_TIME FROM TR_PROD_RESULT ORDER BY CHR_CREATED_DATE DESC")->row();
                                $date_updated = $last_updated->CHR_CREATED_DATE;
                                $time_updated = $last_updated->CHR_CREATED_TIME;
                            ?>
                            &nbsp;
                            <p style="font-size:11px;"><i>Last Updated: <?php echo substr($date_updated,6,2) . '/' . substr($date_updated,4,2) . '/' . substr($date_updated,0,4) . ' ' . substr($time_updated,0,2) . ':' . substr($time_updated,2,2) . ':' . substr($time_updated,3,2) ?></i></p>
                        </div>
                    </div>
                    <div class="grid-body">                        
                        <script type='text/javascript' src='http://db-id02:8000/javascripts/api/viz_v1.js'></script>
                        <div class='tableauPlaceholder' style='width: 100%; height: 870px;'>
                            <object class='tableauViz' width='100%' height='870' style='display:none;'>
                                <param name='host_url' value='http%3A%2F%2Fdb-id02%3A8000%2F' /> 
                                <param name='embed_code_version' value='3' /> 
                                <param name='site_root' value='' />
                                <param name='name' value='RILbyAmount&#47;RILbyAmount' />
                                <param name='tabs' value='no' /><param name='toolbar' value='yes' />
                                <param name='showAppBanner' value='false' />
                            </object>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="modal fade" id="modalexport" tabindex="-1" role="dialog" aria-labelledby="modalexport" aria-hidden="true" style="display: none;">
            <div class="modal-wrapper">
                <div class="modal-dialog" style="width:350px;">
                    <div class="modal-content">
                        <div class="modal-header">
                            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">x</button>
                            <h4 class="modal-title" id="modalexport"><strong>PLEASE SELECT PERIODE</strong></h4>
                        </div>
                        <div class="modal-body" style="font-size:12px;">
                            <?php echo form_open('pes_new/report_prod_ng_c/export_data_ng', 'class="form-horizontal" enctype="multipart/form-data"'); ?>
                            <table id="filter" width="100%">
                                <tr>
                                    <td>Year</td>
                                    <td>
                                        <select name="year" class="form-control" id="year">
                                            <?php for ($x = -1; $x <= 1; $x++) { ?>
                                                <option value="<?php echo date("Y", strtotime("+$x year")); ?>" <?php
                                                if ($year == date("Y", strtotime("+$x year"))) {
                                                    echo 'SELECTED';
                                                }
                                                ?> > <?php echo date("Y", strtotime("+$x year")); ?> </option>
                                                    <?php } ?>
                                        </select>
                                    </td>
                                </tr>
                                <tr>
                                    <td>Month</td>
                                    <td>
                                        <select name="month" class="form-control" id="month">
                                            <option value="all">All Month</option>
                                            <option value="01">January</option>
                                            <option value="02">February</option>
                                            <option value="03">March</option>
                                            <option value="04">April</option>
                                            <option value="05">May</option>
                                            <option value="06">June</option>
                                            <option value="07">July</option>
                                            <option value="08">August</option>                                           
                                            <option value="09">September</option>
                                            <option value="10">October</option>
                                            <option value="11">November</option>
                                            <option value="12">December</option>
                                        </select>
                                    </td>
                                    <td></td>
                                </tr>
                            </table>
                        </div>
                        <div class="modal-footer">
                            <div class="btn-group">
                                <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
                                <button type="submit" class="btn btn-primary" data-placement="left" title="Export Excel"><i class="fa fa-check"></i> Export</button>
                                <?php
                                echo form_close();
                                ?>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
</aside>
