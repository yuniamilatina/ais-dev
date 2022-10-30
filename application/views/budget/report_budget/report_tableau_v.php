<?php 
    header("Content-type: text/html; charset=iso-8859-1");
?>
<script type="text/javascript" src="<?php echo base_url('assets/script/canvasjs.min.js') ?>"></script>
<script>
//    $(document).ready(function () {
//        var interval_close = setInterval(closeSideBar, 250);
//        function closeSideBar() { 
//            $("#hide-sub-menus").click();
//            clearInterval(interval_close);
//        }
//    });
</script>
<style>
#filter { 
        border-spacing: 5px;
        border-collapse: separate;
    }

div.scrollmenu {
    overflow: auto;
    white-space: nowrap;
    font-size: 11px;
}

</style>
<aside class="right-side">
    <section class="content-header">
        <ol class="breadcrumb">
            <li><a href="<?php echo base_url('index.php/basis/home_c') ?>"><span>Home</span></a></li>
            <li><a href="#"><strong>Report Budget Tableau</strong></a></li>
        </ol>
    </section>

    <section class="content">
        <div class="row">
            <div class="col-md-12">
                <div class="grid">
                    <div class="grid-header">
                        <i class="fa fa-book"></i>
                        <span class="grid-title"><strong>REPORT BUDGET USING TABLEAU</strong></span>
                        <div class="pull-right grid-tools">
                            <a data-widget="collapse" title="Collapse"><i class="fa fa-chevron-up"></i></a>
                        </div>
                         <div class="pull-right grid-tools">                            
                             <!--<a href="<?php echo base_url('index.php/budget/report_budget_c/refresh_tableau') ?>"><button type="submit" name="btn_refresh" value="1" class="btn btn-primary" data-placement="right"><i class="fa fa-refresh"></i> Refresh</button></a>-->
                         </div>
                    </div>
                    <div class="grid-body">
                        <!-- <script type='text/javascript' src='http://db-id02:8000/javascripts/api/viz_v1.js'></script>
                        <div class='tableauPlaceholder' style='width: 1600px; height: 628px;'>
                            <object class='tableauViz' width='1600' height='628' style='display:none;'>
                                <param name='host_url' value='http%3A%2F%2Fdb-id02%3A8000%2F' /> 
                                <param name='embed_code_version' value='3' /> 
                                <param name='site_root' value='' />
                                <param name='name' value='Energy&#47;Dashboard1' />
                                <param name='tabs' value='no' />
                                <param name='toolbar' value='yes' />
                                <param name='showAppBanner' value='false' />
                            </object>\
                        </div> -->                        
                    </div>
                </div>
            </div>
        </div>
    </section>
</aside>