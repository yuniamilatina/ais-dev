
<script>
    $(document).ready(function () {
        var interval_close = setInterval(closeSideBar, 250);
        function closeSideBar() { 
            $("#hide-sub-menus").click();
            clearInterval(interval_close);
        }
    });
</script>
<style type="text/css">

    #table-luar{
        font-size: 11px;
    }
    #td_date{
        text-align:center;
        vertical-align:top;
    } 

    #filter { 
        -webkit-border-horizontal-spacing: 10px;
        -webkit-border-vertical-spacing: 10px;
        border-collapse: separate;
        margin-bottom: 10px;
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
    .legend {
        padding: 15px;
        margin-top: 5px;
        margin-bottom: 5px;
        /* border: 1px solid transparent; */
        border-radius: 4px;
        /* border-width: 0.4em;
        border-color: #bce8f1; */
    }

    .legend-info {
        color: #31708f;
        background-color: #d9edf7;
        border-color: #bce8f1;
        border-width: 0.4em;
        border-color: #bce8f1;
    }
</style>

<aside class="right-side">
    <section class="content-header">
        <ol class="breadcrumb">
            <li><a href="<?php echo base_url('index.php/basis/home_c/'); ?>"><span>Home</span></a></li>
            <li><a href=""><strong>MONTHLY PRODUCTION ACTIVITY</strong></a></li>
        </ol>
    </section>

    <section class="content">

        <div class="row">
            <div class="col-md-12">
                <div class="grid">
                    <div class="grid-header">
                        <i class="fa fa-th-large"></i>
                        <span class="grid-title"><strong>MONTHLY PRODUCTION ACTIVITY </strong></span>
                        <div class="pull-right grid-tools">
                            <a data-widget="collapse" title="Collapse"><i class="fa fa-chevron-up"></i></a>
                        </div>
                    </div>

                    <div class="grid-body" style='margin-bottom:-40px;'>
                        <div class="pull">
                            <div class="pull-right grid-tools">
                                <?php echo form_open('pes_new/production_activity_c/download_eff_production', 'class="form-horizontal"'); ?>
                            </div>
                            <table width="100%" id='filter' border=0px >
                                <tr>
                                    <td >
                                        <select class="ddl" id="tanggal" onChange="document.location.href = this.options[this.selectedIndex].value;">
                                            <?php for ($x = -2; $x <= 0; $x++) { ?>
                                                <option value="<?php echo site_url('pes_new/production_activity_c/summary_act_by_period/' . date("Ym", strtotime("+$x month")) ); ?>"<?php
                                                if ($period == date("Ym", strtotime("+$x month"))) {
                                                    echo 'SELECTED';
                                                }
                                                ?> > <?php echo date("M Y", strtotime("+$x month")); ?> </option>
                                                    <?php } ?>
                                        </select>
                                    </td>
                                    <td width="90%" style='text-align:right;'>
                                        <input type="submit" style="margin-top:4px;" class="btn btn-primary"   value="Export to Excel" ><i class="fa fa-download-up"></i></input>
                                    </td>
                                </tr>
                            </table>
                        </div>
                        <input name="CHR_PERIOD" value="<?php echo $period ?>" type="hidden">
                        <?php echo form_close() ?>
                    </div>

                    <div class="grid-body">
                        <div id="table-luar">
                            <table id="dataTables2" class="table table-condensed  table-striped table-hover display" cellspacing="0" width="100%">
                                <thead>
                                    <tr class='gradeX'>
                                        <th style='text-align:center;'>Work Center</th>
                                        <th style='text-align:center;'>Breaktime / Bridging (s)</th>
                                        <th style='text-align:center;'>Prod Time (s)</th>
                                        <th style='text-align:center;'>Line Stop (s)</th>
                                        <th style='text-align:center;'>Prod Runtime (s)</th>
                                        <th style='text-align:center;'>Total OK</th>
                                        <th style='text-align:center;'>Total NG</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    $r = 1;
                                    foreach ($data as $isi) {
                                        echo "<td style=text-align:center;>$isi->CHR_WORK_CENTER</td>";
                                        echo "<td style=text-align:center;>$isi->INT_PLANNED_DOWNTIME</td>";
                                        echo "<td style=text-align:center;>$isi->INT_PRODUCTION_TIME</td>";
                                        echo "<td style=text-align:center;>$isi->INT_UNPLANNED_DOWNTIME</td>";
                                        echo "<td style=text-align:center;>$isi->INT_PRODUCTION_RUNTIME</td>";
                                        echo "<td style=text-align:center;>$isi->INT_TOTAL_OK</td>";
                                        echo "<td style=text-align:center;>$isi->INT_TOTAL_NG</td>";
                                        ?>
                                        </tr>
                                        <?php
                                        $r++;
                                    }
                                    ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>

    </section>

</aside>
