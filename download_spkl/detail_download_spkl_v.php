<script>
    $(document).ready(function() {
        var interval_close = setInterval(closeSideBar, 250);

        function closeSideBar() {
            $("#hide-sub-menus").click();
            clearInterval(interval_close);
        }
    });
</script>
<style type="text/css">
    th,
    td {
        white-space: nowrap;
    }

    div.dataTables_wrapper {
        width: 100%;
        margin: 0 auto;
    }

    #table-luar {
        font-size: 11px;
    }

    #filter {
        -webkit-border-horizontal-spacing: 0px;
        -webkit-border-vertical-spacing: 10px;
        border-collapse: separate;
    }

    #filterx {
        -webkit-border-horizontal-spacing: 20px;
        -webkit-border-vertical-spacing: 10px;
        border-collapse: separate;
    }

    .td-fixed {
        width: 30px;
    }

    .td-no {
        width: 10px;
    }

    .ddl {
        width: 120px;
        height: 30px;
    }

    .ddl2 {
        width: 180px;
        height: 30px;
    }

    .fileUpload {
        position: relative;
        overflow: hidden;
        width: 100px;
        margin-left: 15px;
    }

    .fileUpload input.upload {
        position: absolute;
        top: 0;
        right: 0;
        margin: 0;
        padding: 0;
        font-size: 20px;
        cursor: pointer;
        opacity: 0;
        filter: alpha(opacity=0);
    }

    .input-upload {
        border: none;
        width: 50px;
        background: transparent;
        text-align: right;
    }

    /* The container */
    .container-radio {
        /* display: block; */
        position: relative;
        padding-left: 30px;
        font-weight: 400;
        cursor: pointer;
        /* font-size: 10pt; */
        -webkit-user-select: none;
        -moz-user-select: none;
        -ms-user-select: none;
    }

    /* Hide the browser's default radio button */
    .container-radio input {
        position: absolute;
        opacity: 0;
        cursor: pointer;
    }

    /* Create a custom radio button */
    .checkmark {
        position: absolute;
        top: 0;
        left: 0;
        height: 20px;
        width: 20px;
        background-color: #ccc;
        border-radius: 50%;
        /* margin-top: 22px; */
    }

    /* On mouse-over, add a grey background color */
    .container-radio:hover input~.checkmark {
        background-color: darkgrey;
    }

    /* When the radio button is checked, add a blue background */
    .container-radio input:checked~.checkmark {
        background-color: #2196F3;
    }

    /* Create the indicator (the dot/circle - hidden when not checked) */
    .checkmark:after {
        content: "";
        position: absolute;
        display: none;
    }

    /* Show the indicator (dot/circle) when checked */
    .container-radio input:checked~.checkmark:after {
        display: block;
    }

    /* Style the indicator (dot/circle) */
    .container-radio .checkmark:after {
        top: 5px;
        left: 5px;
        width: 10px;
        height: 10px;
        border-radius: 50%;
        background: white;
    }
</style>


<script>
    function exportTemplate() {
        alert('Save as data ke format .xlsx');
        tableToExcel('template_upload');
    }

    var tableToExcel = (function() {
        var uri = 'data:application/vnd.ms-excel;base64,',
            template = '<html xmlns:o="urn:schemas-microsoft-com:office:office" xmlns:x="urn:schemas-microsoft-com:office:excel" xmlns="https://www.w3.org/TR/html40/"><head><!--[if gte mso 9]><xml><x:ExcelWorkbook><x:ExcelWorksheets><x:ExcelWorksheet><x:Name>{worksheet}</x:Name><x:WorksheetOptions><x:DisplayGridlines/></x:WorksheetOptions></x:ExcelWorksheet></x:ExcelWorksheets></x:ExcelWorkbook></xml><![endif]--></head><body><table>{table}</table></body></html>',
            base64 = function(s) {
                return window.btoa(unescape(encodeURIComponent(s)))
            },
            format = function(s, c) {
                return s.replace(/{(\w+)}/g, function(m, p) {
                    return c[p];
                })
            }
        return function(table, name) {
            if (!table.nodeType)
                table = document.getElementById(table)
            var ctx = {
                worksheet: name || <?php echo $period; ?>,
                table: table.innerHTML
            }
            window.location.href = uri + base64(format(template, ctx))
        }
    })()
</script>



<aside class="right-side">
    <section class="content-header">
        <ol class="breadcrumb">
            <li><a href="<?php echo base_url('index.php/basis/home_c') ?>"><span>Home</span></a></li>
            <li><a href="<?php echo base_url('index.php/aorta/download_spkl_c') ?>"><span>Download SPKL</span></a></li>
            <li><a href="#"><strong>Detail SPKL</strong></a></li>

        </ol>
    </section>

    <section class="content">


        <div class="row">
            <div class="col-md-12">
                <div class="grid">
                    <div class="grid-header">
                        <i class="fas fa fa-solid fa-download"></i>
                        <span class="grid-title"><strong>DETAIL SPKL </strong></span>
                        <div class="pull-right grid-tools">

                        </div>
                    </div>
                    <div class="grid-body">
                        <div style="overflow-x:auto;">
                            <div id="table-luar">
                                <table id="dataTables3" class="table table-condensed  table-striped table-hover display" cellspacing="0" width="100%">
                                    <thead>
                                        <tr>

                                            <!--A -->
                                            <th style="vertical-align: middle;text-align:center;">Reference No</th>
                                            <!--B -->
                                            <th style="vertical-align: middle;text-align:center;">Employee ID</th>
                                            <!--C -->
                                            <th style="vertical-align: middle;text-align:center;">Overtime Date</th>
                                            <!--D -->
                                            <th style="vertical-align: middle;text-align:center;">Reference Date</th>
                                            <!--E -->
                                            <th style="vertical-align: middle;text-align:center;">Overtime In Date</th>
                                            <!--F -->
                                            <th style="vertical-align: middle;text-align:center;">Overtime In Time</th>
                                            <!--G -->
                                            <th style="vertical-align: middle;text-align:center;">Overtime Out Date</th>
                                            <!--H -->
                                            <th style="vertical-align: middle;text-align:center;">Overtime Out Time</th>
                                            <!--I -->
                                            <th style="vertical-align: middle;text-align:center;">Remark</th>

                                        </tr>
                                    </thead>
                                    <tbody>


                                        <?php foreach ($detail_data_download as $isi) : ?>
                                            <tr>
                                                <!--A -->
                                                <!--Reference NO -->
                                                <td style="vertical-align: middle;text-align:center;"><?= $isi->Reference ?></td>
                                                <!--B -->
                                                <!--Employee ID -->
                                                <td style="vertical-align: middle;text-align:center;"><?= $isi->NPK ?></td>
                                                <!--C -->
                                                <!--Overtime Date -->
                                                <td style="vertical-align: middle;text-align:center;"><?= $isi->TGL_OVERTIME ?></td>
                                                <!--D -->
                                                <!--Reference Date -->
                                                <td style="vertical-align: middle;text-align:center;"><?= $isi->TGL_ENTRY ?></td>
                                                <!--E -->
                                                <!--Overtime In Date -->
                                                <td style="vertical-align: middle;text-align:center;"><?= $isi->TGL_OVERTIME ?></td>
                                                <!--F -->
                                                <!--Overtime In Time -->
                                                <!-- --ambil 4 angka didepan-- LEFT di query -->
                                                <!-- --REAL_MULAI_OV_TIME-- -->
                                                <td style="vertical-align: middle;text-align:center;"><?= $isi->OVT_IN_TIME ?></td>
                                                <!--G -->
                                                <!-- Overtime Out Date -->
                                                <!-- --ada tambahan if-- CASE WHEN di query -->
                                                <td style="vertical-align: middle;text-align:center;"><?= $isi->OVT_OUT_DATE ?></td>
                                                <!--H -->
                                                <!-- Overtime Out Time -->
                                                <!-- --ambil 4 angka didepan-- LEFT di query -->
                                                <!-- --REAL_OV_TIME-- -->
                                                <td style="vertical-align: middle;text-align:center;"><?= $isi->OVT_OUT_TIME ?></td>
                                                <!--I -->
                                                <!-- Remark -->
                                                <!--NO SEQUENCE + CLOSE_TRANS -- CONCAT di query -->
                                                <td style="vertical-align: middle;text-align:center;"><?= $isi->Remark ?></td>


                                            </tr>

                                        <?php endforeach; ?>


                                    </tbody>
                                </table>

                            </div>
                        </div>
                    </div>



                </div>


            </div>
        </div>

    </section>
</aside>

<script src="<?php echo base_url('assets/js/jquery-1.12.3.js') ?>"></script>
<script src="<?php echo base_url('assets/js/jquery.dataTables.min.js') ?>"></script>
<!-- <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script> -->
<script src="<?php echo base_url('assets/js/dataTables.fixedColumns.min.js') ?>"></script>
<link rel="stylesheet" href="<?php echo base_url('assets/css/fixedColumns.dataTables.min.css'); ?>">
<script>
    //                                             $(document).ready(function () {
    //                                                 var table = $('#example').DataTable({
    //                                                     scrollY: "350px",
    //                                                     scrollX: true,
    //                                                     scrollCollapse: true,
    //                                                     paging: true,
    //                                                     fixedColumns: {
    //                                                         leftColumns: 4
    //                                                     }
    //                                                 });

    // //                                                    $('.dataTables_filter input').addClass('search-query');
    //                                                 $('.dataTables_filter input').attr('placeholder', 'Search');
    //                                             });

    // function get_data_detail(qrno, stat) {
    //     $("#data_detail").html("");
    //     $.ajax({
    //         async: false,
    //         type: "POST",
    //         // dataType: 'json',
    //         url: "<?php echo site_url('aorta/quota_employee_c/view_detail_quota_employee_by_user'); ?>",
    //         data: {
    //             qrno: qrno,
    //             stat: stat
    //         },
    //         success: function(data) {
    //             $("#data_detail" + qrno).html(data);
    //         },
    //         error: function(request, error) {
    //             alert(request.responseText);
    //         }
    //     });

    // }
</script>