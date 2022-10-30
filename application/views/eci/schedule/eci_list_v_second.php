
<!--<link rel="stylesheet" href="../../assets/dhtmlxgantt.css" type="text/css" media="screen" title="no title" charset="utf-8">-->
<!--<link rel="stylesheet" href="http://192.168.0.230/AIS/assets/css/dhtmlxgantt.css" type="text/css">-->
<link rel="stylesheet" href="<?php echo base_url('assets/css/dhtmlxgantt.css'); ?>" type="text/css">
<style type="text/css">
    .details{
        margin-bottom: 1250px;
    }
</style>
<script>
    function initDatatables2() {
    }
        /* ROW DETAILS */

        /*var nCloneTh = document.createElement('th');
        var nCloneTd = document.createElement('td');
        nCloneTd.innerHTML = '<i class="fa fa-angle-down link"></i>';
        nCloneTd.className = "center";

        $('#example thead tr').each(function() {
            this.insertBefore(nCloneTh, this.childNodes[0]);
        });

        $('#example tbody tr').each(function() {
            this.insertBefore(nCloneTd.cloneNode(true), this.childNodes[0]);
        });
        
        function fnFormatDetails(oTable, nTr) {
            var aData = oTable.fnGetData(nTr);
            var varData = "";
            var id_activity = aData[1];
         

            //alert(aData[1]);

            var sOut = '';
            //var sOut = '<table cellpadding="5" cellspacing="0" border="1" class="detail-row">';

            sOut += '<style>';
            sOut += '.weekend{ background: #f4f7f4 !important;}';
            sOut += '</style>';

            sOut += '	<div id="gantt_here" style="width:100%; height:300px;"></div>';
            sOut += '	<input type="hidden" id="id_eci" value="' + aData[1] + '" >';
            sOut += '	<input type="hidden" id="id_rev" value="' + aData[3] + '" >';
            //sOut += '</table>';


            return sOut;


        }

        function fnFormatDetails2(oTable, nTr) {
            var aData = oTable.fnGetData(nTr);
            var varData = "";
            var id_activity = aData[1];
         
            var id_rev = aData[3];
            var sOut = '';
            //var sOut = '<table cellpadding="5" cellspacing="0" border="1" class="detail-row">';

            $.ajax({
                async: false,
                type: "POST",
                url: "<?php echo site_url('eci/schedule_c/get_detil_eci'); ?>",
                data: "id_activity=" + id_activity,
                //+ "&id_rev=" + id_rev,
                dataType: 'json',
                //
                success: function(get_data) {
                    //val values = loadJSONArray("get_data.json");
                    // ShareInfoLength = get_data.data.length;
                    //alert(get_data.links[1].target);

                    //alert('asd');
                    //gantt.parse
                    //sOut += ' <div id="gantt_here" style="width:1020px; height:400px;"></div>	<script type="text/javascript">	gantt.config.xml_date = "%Y-%m-%d %H:%i:%s"; gantt.init("gantt_here"); gantt.load("<?php echo base_url('assets/gantt/common/data.json'); ?>", "json");';
                    //sOut += '	<div id="gantt_here" style="width:1020px; height:400px;"></div><script type="text/javascript">gantt.config.xml_date = "%Y-%m-%d %H:%i:%s";gantt.init("gantt_here");gantt.load("<?php echo base_url('assets/gantt/common/data.json'); ?>", "json");'

                    gantt.config.work_time = true;
                    //gantt.skip_off_time = true;
                    gantt.config.xml_date = "%Y-%m-%d %H:%i:%s";


                    gantt.config.columns = [
                        {name: "no", label: "No", width: '20'},
                        //{name:"start_date", label:"Start", width:'100' },
                        {name: "text", label: "Activity", width: '300'},
                        //{name:"start_date", label:"Start", width:'100' },
                        {name: "end_date", label: "Due Date", align: "right"},
                        //{name:"duration",   label:"Duration",   align: "center" },
                        {name: "pic", label: "PIC", align: "center", width: '150'},
                        {name: "dept", label: "Dept", width: '100'},
                        //{name:"add",        label:"" }

                    ];
                    gantt.config.autosize = false; //ini
                    //!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!! Scaling !!!!!!!!!!!!!!!!!!!!!!!!!!!
                    gantt.config.scale_unit = "year";
                    gantt.config.step = 1;
                    gantt.config.date_scale = "%Y";
                    gantt.config.min_column_width = 100;

                    gantt.config.scale_height = 90;

                    var monthScaleTemplate = function(date) {
                        var dateToStr = gantt.date.date_to_str("%M");
                        var endDate = gantt.date.add(date, 2, "month");
                        return dateToStr(date) + " - " + dateToStr(endDate);
                    };

                    gantt.config.subscales = [
                        //{unit:"month", step:3, template:monthScaleTemplate},
                        {unit: "month", step: 1, date: "%M"}
                    ];
                    //!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!! Scaling !!!!!!!!!!!!!!!!!!!!!!!!!!

                    gantt.templates.task_text = function(start, end, task) {
                        return "";
                    };

                    gantt.templates.task_class = function(start, end, task) {
                        switch (task.color) {
//                            case "1":
//                                return "ready";
//                                break;
//                            case "2":
//                                return "progress";
//                                break;
//                            case "3":
//                                return "feedback";
//                                break;
//                            default :
//                                return "delayed";
//                                break;
                            case "4":
                                return "delayed";
                                break;
                            case "3":
                                return "feedback";
                                break;
                            case "2":
                                return "progress";
                                break;
                            default :
                                return "ready";
                                break;
                        }
                    };
                    gantt.config.drag_resize = false; //unresizable
                    gantt.config.drag_progress = false; //undraggable
                    gantt.config.drag_move = false; //undraggable
                    gantt.config.readonly = true; //unclickable

                    gantt.init("gantt_here");
                    gantt.clearAll();
                    gantt.parse(get_data, "json");
                    /*
                     ShareInfoLength = get_data.length;
                     
                     if (ShareInfoLength > 0) {
                     sOut += '<tr>';
                     sOut += '<th>Activity Name</th>';
                     sOut += '<th>Duration</th>';
                     sOut += '<th>Start Date</th>';
                     sOut += '<th>Due Date</th>';
                     sOut += '</tr>';
                     }
                     
                     for (i = 0; i < ShareInfoLength ; i++) {
                     
                     sOut += '<tr>';
                     
                     sOut += '<td>'+get_data[i].CHR_ACTIVITY_NAME+'</td>';
                     sOut += '<td>'+get_data[i].INT_DURATION+'</td>';
                     sOut += '<td>'+get_data[i].CHR_START_DATE+'</td>';
                     sOut += '<td>'+get_data[i].CHR_DUE_DATE+'</td>';
                     
                     sOut += '</tr>';
                     
                     }
                     */
                /*}
            });
            //sOut += '	<div id="gantt_here" style="width:1020px; height:400px;"></div>'
            //sOut += '</table>';
            //return sOut;
        }

        var oTable = $('#example').dataTable({
            "aoColumnDefs": [{
                    "bSortable": false,
                    "aTargets": [0]
                }],
//            "scrollY": "500",
            //"scrollCollapse": false,
            "paging": false,
            "aaSorting": [[1, 'asc']]
        });

        $('#example tbody').on('click', 'i', function() {
            var nTr = $(this).parents('tr')[0];
            gantt.resetLightbox();
            if (oTable.fnIsOpen(nTr)) {
                $(this).removeClass("fa-angle-up").addClass("fa-angle-down");
                oTable.fnClose(nTr);
            } else {
                $(this).removeClass("fa-angle-down").addClass("fa-angle-up");
                //oTable.fnOpen(nTr,fnFormatDetails2());
                oTable.fnOpen(nTr, fnFormatDetails(oTable, nTr), 'details');
                oTable.fnOpen(nTr, fnFormatDetails2(oTable, nTr), 'details');
            }
        });
    }

    $(function() {
        "use strict";
        initDatatables2();
    });

</script>
<script>
    function newTabGantt(id_eci)
    {
        window.open('http://192.168.0.231/AIS_PP/index.php/eci/schedule_c/detail_eci/'+id_eci,"_blank");
    }
</script>
<style type="text/css"></style>
<aside class="right-side">
    <section class="content-header">
        <ol class="breadcrumb">
            <li><a href="<?php echo base_url('index.php/basis/home_c/') ?>">Home</a></li>
            <li> <a href="#"><strong>LIST PROJECT </strong></a></li>
        </ol>
    </section>
    <section class="content">
        <?php
        if ($msg != NULL) {
            echo $msg;
        }
        //$date_now = date('Ymd');
        //echo $date_now ;exit();
        ?>

        <div class="row">

            <div class="col-md-12">
                <div class="grid">
                    <div class="grid-header">
                        <i class="fa fa-th-large"></i>
                        <span class="grid-title"><strong>LIST</strong> PROJECT</span>
                        <!--div class="pull-right">
                            <a href="<?php echo base_url('index.php/portal/calendar_c/create_calendar/') ?>"  class="btn btn-default" data-placement="left" data-toggle="tooltip" title="Create ECI Category" style="height:30px;font-size:13px;width:100px;">Create</a>
                                                </div-->
                    </div>
                    <div class="grid-body">
                        <table id="example" class="table table-striped table-condensed table-hover display" cellspacing="0" width="100%">
                            <thead>
                                <tr>
                                    <th>ID ECI</th>
                                    <th>ECI Number</th>
                                    <th>Start Date</th>
                                    <th>Due Date</th>
                                    <th>Purpose</th>
                                    <th>Customer</th>
                                    <th>Action</th>
                                    <!--th>Actions</th-->
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                $i = 1;
                                foreach ($data as $isi) {
                                    //echo "<tr class='gradeX'>";
                                    echo "<tr id=\"row_activity_" . trim($isi->CHR_ID_ECI) . "\">";
                                    echo "<td>&nbsp;&nbsp;&nbsp;&nbsp;$isi->CHR_ID_ECI</td>";
                                    echo "<td>$isi->CHR_NAME</td>";
                                    echo "<td>" . date("d-m-Y", strtotime($isi->CHR_START_DATE)) . "</td>";
                                    echo "<td>" . date("d-m-Y", strtotime($isi->CHR_DUE_DATE)) . "</td>";
                                    echo "<td>$isi->CHR_CATEGORY_NAME</td>";
                                    echo "<td>$isi->CHR_CUSTOMER</td>";
                                    // echo "<td>$isi->CHR_BUDGET_TYPE</td>";
                                    ?>
                                <td>

                                            <!--<a href="<?php echo base_url('index.php/eci/schedule_c/print_eci') . "/" . $isi->CHR_ID_ECI . "/" . $isi->INT_REV; ?>" class="label label-info" data-placement="left" data-toggle="tooltip" title="Print"><span class="fa fa-print"></span></a>-->
                                    <!--<a onclick="gantt.exportToPDF({ 
                                            name:'gantt_view',
                                            header:'<h1><center><?php echo $isi->INT_TYPE; ?>/<?php echo $isi->CHR_FG_PARTNAME; ?></center></h1><br>No ECI	: <?php echo $isi->CHR_NAME; ?></br><br>Model	: <?php echo $isi->CHR_VEHICLE; ?></br><br>Content: <?php echo $isi->CHR_CONTENT; ?><?php echo "</br><style> table, th, td {border: 2px solid black; width:700px; height:100px;  align=right-side ;} .gantt_cell{font-size:12px;}  .delayed{ border:0px solid #FF0000;color: #FF0000;background: #FF0000; textcolor:#db2536; }  .delayed .gantt_task_progress{background: #db2536; textcolor:#db2536; }   .ready{border:0px solid #009900;color:#009900; text-color:#20ff00;  background: #009900;  }  .ready .gantt_task_progress{background: #20ff00; text-color:#20ff00; }  .feedback{	border:0px solid #0066ff;	color:#0066ff;	text-color:#6ba8e3; background: #0066ff;} .feedback .gantt_task_progress{background: #6ba8e3; text-color:#6ba8e3; }.progress{border:0px solid #cccc00;color:#cccc00; text-color:#547dab; background: #cccc00;} .progress .gantt_task_progress{background: #547dab; text-color:#547dab;}</style>'," ?>
                                            footer:'<br><?php echo $hariini; ?></br><table ><tr><td></td><td></td><td></td><td></td><td></td><td></td><td></td></tr></table>'})"  class="label label-info" data-placement="left" data-toggle="tooltip" title="Print via PDF"><span class="fa fa-print"></span></a>
                                    -->
        <!--<a href="<?php echo base_url('index.php/eci/schedule_c/print_eci') . "/" . $isi->CHR_ID_ECI; ?>" class="label label-info" data-placement="left" data-toggle="tooltip" title="Print via Excel"><span class="fa fa-print"></span></a>-->



                                            <!--<a href="<?php echo base_url('index.php/eci/schedule_c/publish_eci') . "/" . $isi->CHR_ID_ECI . "/" . $isi->INT_REV; ?>" class="label label-success" data-placement="left" data-toggle="tooltip" title="Publish" onclick="return confirm('Are you sure want to publish this data?');"><span class="fa fa-check"></span></a>
                                            <!--<a href="<?php echo base_url('index.php/eci/schedule_c/edit_eci') . "/" . $isi->CHR_ID_ECI . "/" . $isi->INT_REV; ?>" class="label label-warning" data-placement="top" data-toggle="tooltip" title="Edit"><span class="fa fa-pencil"></span></a>-->
                                    <a href="<?php echo base_url('index.php/eci/schedule_c/delete_eci') . "/" . $isi->CHR_ID_ECI . "/" . $isi->INT_REV; ?>" class="label label-danger" data-placement="top" data-toggle="tooltip" title="Delete" onclick="return confirm('Are you sure want to delete this data?');"><span class="fa fa-times"></span></a>
                                    <!--<link rel="stylesheet" href="http://192.168.0.230/AIS/assets/css/gantt.css" type="text/css"/>-->
                                    <!-- <a onclick="newTabGantt()" href="<?php echo base_url('index.php/eci/schedule_c/detail_eci') . "/" . $isi->CHR_ID_ECI; ?>" class="label label-info" data-placement="top" data-toggle="tooltip" title="Detail" ><span class="fa fa-info"></span></a> -->
                                    <a onclick="newTabGantt('<?php echo $isi->CHR_ID_ECI;?>')" id="delete" class="label label-info" data-placement="top" data-toggle="tooltip" title="Detail"><span class="fa fa-info"></span></a>
                                    </style>
                                </td>
                                </tr>

                                <?php
                                $i++;
                            }
                            ?>
                            </tbody>
                        </table>
                        <!--<table border="1px" style="color: #000;">
                            <tr>
                                <td width = "20%" style="background-color: green" border="1px">
                                </td>
                                <td>
                                    <font style="color: #000; ">Ready to Start</font>
                                </td>

                                <td width = "20%" style="background-color: yellow" border="1px">
                                </td>
                                <td>
                                    <font style="color: #000; ">Started</font>
                                </td>
                            </tr>
                            <tr>
                                <td width = "20%" style="background-color: blue" border="1px">
                                </td>
                                <td>
                                    <font style="color: #000; ">Finished</font>
                                </td>

                                <td width = "20%" style="background-color: red" border="1px">
                                </td>
                                <td>
                                    <font style="color: #000; ">Delayed</font>
                                </td>
                            </tr>
                        </table>-->

                    </div>

                </div>
            </div>

        </div>



    </section>
</aside>


