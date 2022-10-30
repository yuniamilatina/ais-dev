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

<script>
    $(function () {
    $("#datepicker").datepicker({dateFormat: 'yy/mm/dd', maxDate: 'today'});
    $("#datepicker2").datepicker({dateFormat: 'yy/mm/dd', maxDate: 'today'});
    });</script>
<script>

    function updateField(id) {
    $.ajax({
    async: false,
            type: "POST",
            url: "<?php echo site_url('accounting/master_data_c/get_ap'); ?>",
            data: "id=" + id,
            dataType: "JSON",
            success: function (data) {
            $("#id_ap").val(data.id);
            $("#ap_name").val(data.name);
            }
    });
    }

    $(document).ready(function () {

    });</script> 
<script>     var tableToExcel = (function () {
var uri = 'data:application/vnd.ms-excel;base64,'
, template = '<html xmlns:o="urn:schemas-microsoft-com:office:office" xmlns:x="urn:schemas-microsoft-com:office:excel" xmlns="http://www.w3.org/TR/REC-html40"><head><!--[if gte mso 9]><xml><x:ExcelWorkbook><x:ExcelWorksheets><x:ExcelWorksheet><x:Name>{worksheet}</x:Name><x:WorksheetOptions><x:DisplayGridlines/></x:WorksheetOptions></x:ExcelWorksheet></x:ExcelWorksheets></x:ExcelWorkbook></xml><![endif]--></head><body><table>{table}</table></body></html>'
            , base64 = function (s) {
return window.btoa(unescape(encodeURIComponent(s)))
    }
, format = function (s, c) {
return s.replace(/{(\w+)}/g, function (m, p) {
    return c[p];
})
}
return function (table, name) {
if (!table.nodeType)
    table = document.getElementById(table)
var ctx = {worksheet: name || 'Worksheet', table: table.innerHTML}
window.location.href = uri + base64(format(template, ctx))
}
})()
</script>


<aside class="right-side">
    <section class="content-header">
        <ol class="breadcrumb">
            <li><a href="<?php echo base_url('index.php/basis/home_c/') ?>">Home</a></li>
            <li><a href="#"><span><strong>Master Data Equalisasi</strong></span></a></li>
        </ol>
    </section>
    <section class="content">
        <div class="row">
            <?php echo form_open('accounting/report_c/equalisasi_tax', 'class="form-horizontal"', 'action="post"'); ?>

            <!-- BEGIN BASIC ELEMENTS -->
            <div class="col-md-12">
                <div class="grid">
                    <div class="grid-header">
                        <i class="fa fa-align-left"></i>
                        <span class="grid-title">Report Equalisasi Tax</span>
                        <div class="pull-right grid-tools">
                            <a data-widget="collapse" title="Collapse"><i class="fa fa-chevron-up"></i></a>
                            <a data-widget="reload" title="Reload"><i class="fa fa-refresh"></i></a>
                            <a data-widget="remove" title="Remove"><i class="fa fa-times"></i></a>
                        </div>
                    </div>
                    <div class="grid-body">
                        <form class="form-horizontal" role="form">
                            <div class="form-group">
                                <label class="col-sm-3 control-label">Company Code</label>
                                <div class="col-sm-7">
                                    <input name="company_code" id="company_code" value="J901" readonly type="text" maxlength="4" class="form-control" style="width:60px;">
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-sm-3 control-label">Fiscal Year</label>
                                <div class="col-sm-3">
                                    <input name="fiscal_year_start"  id="fiscal_year_start"  type="text"    class="form-control" style="width:60px;float:left; display:inline;" placeholder="Year" value="<?php echo $fiscal_year_start ?>">
                                    <button type="button" id="popup-fiscal-year" style="float:left; display:inline;margin-left:5px;" class="md-trigger btn btn-primary pull-left" data-modal="modal-1">
                                        <i class="fa fa-list-alt"></i>
                                    </button>
                                </div>
                                <div class="col-sm-1">
                                    To
                                </div>
                                <div class="col-sm-2">
                                    <input name="fiscal_year_end"  id="fiscal_year_end"  type="text"  class="form-control" style="width:60px;" placeholder="Year" value="<?php echo $fiscal_year_end ?>">
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-sm-3 control-label">Document Number</label>
                                <div class="col-sm-3">
                                    <input name="doc_num_start"  id="doc_num_start"  type="text"  class="form-control" style="width:120px;float:left; display:inline;" placeholder="Doc No" value="<?php echo $doc_num_start ?>">
                                    <button type="button" id="popup-doc-no" style="float:left; display:inline;margin-left:5px;" class="md-trigger btn btn-primary pull-left" data-modal="modal-2">
                                        <i class="fa fa-list-alt"></i>
                                    </button>
                                </div>
                                <div class="col-sm-1">
                                    To
                                </div>
                                <div class="col-sm-2">
                                    <input name="doc_num_end"  id="doc_num_end"  type="text"  class="form-control" style="width:120px;" placeholder="Doc No" value="<?php echo $doc_num_end ?>">
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-sm-3 control-label">Posting date</label>
                                <div class="col-sm-2">
                                    <input type="text" name="posting_date_start" value="<?php echo $posting_date_start ?>" class="ddl"  id="datepicker" placeholder="YYYY/MM/DD"  style="width:120px;float:left; display:inline;">
                                </div>
                                <div class="col-sm-1">
                                    To
                                </div>
                                <div class="col-sm-2">
                                    <input type="text" name="posting_date_end" value="<?php echo $posting_date_end ?>" class="ddl"  id="datepicker2" placeholder="YYYY/MM/DD" >
                                </div>
                            </div>

                            <div class="btn-group ">
                                <button type="submit" name="search" value="1" id="search" class="btn btn-primary" data-toggle="modal" data-target="#modal_process">Submit</button>
                                <button type="submit" class="btn btn-default">Cancel</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
            <?php
            echo form_close();
            ?>
            <!--END BASIC ELEMENTS -->
        </div>
        <div class="row">
            <!-- BEGIN BASIC ELEMENTS -->
            <div class="col-md-12">
                <div class="grid">
                    <div class="grid-header">
                        <i class="fa fa-align-left"></i>
                        <span class="grid-title">Table Report Equalisasi Tax</span>
                        <div class="pull-right grid-tools">
                            <a data-widget="collapse" title="Collapse"><i class="fa fa-chevron-up"></i></a>
                            <a data-widget="reload" title="Reload"><i class="fa fa-refresh"></i></a>
                            <a data-widget="remove" title="Remove"><i class="fa fa-times"></i></a>
                        </div>
                    </div>
                    <div class="grid-body">
                        <input type="button" onclick="tableToExcel('exportToExcel', 'W3C Example Table')" value="Export to Excel" style="margin-bottom: 20px;">
                        <table id="dataTables1" class="table table-striped table-condensed table-hover display" cellspacing="0" width="100%">
                            <thead>
                                <tr> 
<!--                                <tr class='gradeX'> -->
                                    <th style="text-align:center;" rowspan="2">Doc No</th>
                                    <th style="text-align:center;" rowspan="2">Posting Date</th>
                                    <!--<th style="text-align:center;" rowspan="2">Accounting Doc</th>-->

                                    <?php
                                    foreach ($get_tm_equal as $value) {
                                        echo "<th style=\"text-align:center;\" colspan=\"4\">" . trim($value->CHR_NAME) . "</th>";
                                    }
                                    ?>
                                    <th style="text-align:center;" rowspan="2">Total</th>
                                    <th style="text-align:center;" rowspan="2">Clearing Doc</th>
                                    <th style="text-align:center;" rowspan="2">Text</th>
                                </tr>
                                <?php
                                for ($index = 0; $index < count($get_tm_equal); $index++) {
                                    echo "<th style=\"text-align:center;\">Account No</th>";
                                    echo "<th style=\"text-align:center;\">Description</th>";
                                    echo "<th style=\"text-align:center;\">Currency</th>";
                                    echo "<th style=\"text-align:center;\">Amount</th>";
                                }
                                ?>
                            </thead>
                            <tbody>
                                <?php
                                foreach ($get_no_doc as $value_doc_h) {
                                    echo "<tr class='gradeX'>
                                        <td style=\"text-align:center\">$value_doc_h->CHR_DOC_NO</td>
                                        <td style=\"text-align:center\">" . date("Y.m.d", strtotime($value_doc_h->CHR_POSTING_DATE)) . " </td>";
//                                        <td style=\"text-align:center\">$value_doc_h->CHR_ACC_DOC</td>

                                    foreach ($get_tm_equal as $tm_equal) {
                                        $id_equal = trim($tm_equal->CHR_ID_EQUALISASI);
                                        if ($id_equal == "0001") {
                                            $data = $this->db->query("SELECT     ACC.TW_EQUAL_TAX.CHR_ACC_NO_BANK AS 'CHR_ACC_NO', 0 AS 'CHR_AMOUNT_DEBIT', 
                                                    ACC.TW_EQUAL_TAX.CHR_AMOUNT_KREDIT_BANK AS 'CHR_AMOUNT_KREDIT', ACC.TW_EQUAL_TAX.CHR_TEXT_BANK ,
                                                    ACC.TM_GL_ACCOUNT.CHR_NAME  AS 'CHR_ACC_DESC'
                                                    FROM         ACC.TW_EQUAL_TAX INNER JOIN
                                                    ACC.TM_GL_ACCOUNT ON ACC.TW_EQUAL_TAX.CHR_ACC_NO_BANK = ACC.TM_GL_ACCOUNT.CHR_GL_ACCOUNT
                                                    WHERE     (ACC.TW_EQUAL_TAX.CHR_USER = '$user') AND (ACC.TW_EQUAL_TAX.CHR_DOC_NO = '$value_doc_h->CHR_DOC_NO ') AND (ACC.TW_EQUAL_TAX.CHR_ACC_NO_BANK IN
                                                        (SELECT     CHR_GL_ACCOUNT
                                                          FROM          ACC.TM_MAP_EQUAL_GL
                                                          WHERE      (CHR_ID_EQUALISASI = '$id_equal')))")->row();
                                        } else {
                                            $data = $this->db->query("select CHR_ACC_NO , CHR_AMOUNT_DEBIT , CHR_AMOUNT_KREDIT, CHR_ACC_DESC from   ACC.TW_EQUAL_TAX where CHR_USER = '$user' and CHR_DOC_NO = '$value_doc_h->CHR_DOC_NO' and  CHR_ACC_NO IN (SELECT CHR_GL_ACCOUNT FROM ACC.TM_MAP_EQUAL_GL WHERE CHR_ID_EQUALISASI = '$id_equal') ")->row();
                                        }
                                        if (count($data) <> 0) {
                                            $amount = str_replace(".", "", $data->CHR_AMOUNT_DEBIT) - str_replace(".", "", $data->CHR_AMOUNT_KREDIT);
                                            echo "<td style=\"text-align:center\">$data->CHR_ACC_NO</td>";
                                            echo "<td style=\"text-align:center\">$data->CHR_ACC_DESC</td>";
                                            echo "<td style=\"text-align:center\">IDR</td>";
                                            echo "<td style=\"text-align:center\">" . number_format($amount) . "</td>";
                                        } else {
                                            echo "<td style=\"text-align:center\">-</td>";
                                            echo "<td style=\"text-align:center\">-</td>";
                                            echo "<td style=\"text-align:center\">-</td>";
                                            echo "<td style=\"text-align:center\">-</td>";
                                        }
                                    }

                                    //get text
                                    $get_text = $this->db->query("select CHR_TEXT from  ACC.TW_EQUAL_TAX where CHR_DOC_NO = '$value_doc_h->CHR_DOC_NO' and CHR_TEXT <> ''")->row();
                                    if (count($get_text) == 0) {
                                        $get_text = $this->db->query("select CHR_TEXT_NON_PO from  ACC.TW_EQUAL_TAX where CHR_DOC_NO = '$value_doc_h->CHR_DOC_NO' and CHR_TEXT_NON_PO <> ''")->row();
                                        $CHR_TEXT = $get_text->CHR_TEXT_NON_PO;
                                    } else {
                                        $CHR_TEXT = $get_text->CHR_TEXT;
                                    }
                                    echo "<td style = \"text-align:center\">-</td> ";
                                    echo "<td style=\"text-align:center\">$value_doc_h->CHR_CLEARING_DOC</td>";
                                    echo "<td>$CHR_TEXT</td>";
                                    echo "</tr>";
                                }
                                ?>
                            </tbody>
                        </table>

                        <table id="exportToExcel" class="table table-striped table-condensed table-hover display" cellspacing="0" width="100%" style="display:none;">
                            <thead>
                                <tr> 
<!--                                <tr class='gradeX'> -->
                                    <th style="text-align:center;" rowspan="2">Doc No</th>
                                    <th style="text-align:center;" rowspan="2">Posting Date</th>
                                    <!--<th style="text-align:center;" rowspan="2">Accounting Doc</th>-->

                                    <?php
                                    foreach ($get_tm_equal as $value) {
                                        echo "<th style=\"text-align:center;\" colspan=\"4\">" . trim($value->CHR_NAME) . "</th>";
                                    }
                                    ?>
                                    <th style="text-align:center;" rowspan="2">Total</th>
                                    <th style="text-align:center;" rowspan="2">Clearing Doc</th>
                                    <th style="text-align:center;" rowspan="2">Text</th>
                                </tr>
                                <?php
                                for ($index = 0; $index < count($get_tm_equal); $index++) {
                                    echo "<th style=\"text-align:center;\">Account No</th>";
                                    echo "<th style=\"text-align:center;\">Description</th>";
                                    echo "<th style=\"text-align:center;\">Currency</th>";
                                    echo "<th style=\"text-align:center;\">Amount</th>";
                                }
                                ?>
                            </thead>
                            <tbody>
                                <?php
                                foreach ($get_no_doc as $value_doc_h) {
                                    echo "<tr class='gradeX'>
                                        <td style=\"text-align:center\">$value_doc_h->CHR_DOC_NO</td>
                                        <td style=\"text-align:center\">" . date("Y.m.d", strtotime($value_doc_h->CHR_POSTING_DATE)) . " </td>";
//                                        <td style=\"text-align:center\">$value_doc_h->CHR_ACC_DOC</td>

                                    foreach ($get_tm_equal as $tm_equal) {
                                        $id_equal = trim($tm_equal->CHR_ID_EQUALISASI);
                                        if ($id_equal == "0001") {
                                            $data = $this->db->query("SELECT     ACC.TW_EQUAL_TAX.CHR_ACC_NO_BANK AS 'CHR_ACC_NO', 0 AS 'CHR_AMOUNT_DEBIT', 
                                                    ACC.TW_EQUAL_TAX.CHR_AMOUNT_KREDIT_BANK AS 'CHR_AMOUNT_KREDIT', ACC.TW_EQUAL_TAX.CHR_TEXT_BANK ,
                                                    ACC.TM_GL_ACCOUNT.CHR_NAME  AS 'CHR_ACC_DESC'
                                                    FROM         ACC.TW_EQUAL_TAX INNER JOIN
                                                    ACC.TM_GL_ACCOUNT ON ACC.TW_EQUAL_TAX.CHR_ACC_NO_BANK = ACC.TM_GL_ACCOUNT.CHR_GL_ACCOUNT
                                                    WHERE     (ACC.TW_EQUAL_TAX.CHR_USER = '$user') AND (ACC.TW_EQUAL_TAX.CHR_DOC_NO = '$value_doc_h->CHR_DOC_NO ') AND (ACC.TW_EQUAL_TAX.CHR_ACC_NO_BANK IN
                                                        (SELECT     CHR_GL_ACCOUNT
                                                          FROM          ACC.TM_MAP_EQUAL_GL
                                                          WHERE      (CHR_ID_EQUALISASI = '$id_equal')))")->row();
                                        } else {
                                            $data = $this->db->query("select CHR_ACC_NO , CHR_AMOUNT_DEBIT , CHR_AMOUNT_KREDIT, CHR_ACC_DESC from   ACC.TW_EQUAL_TAX where CHR_USER = '$user' and CHR_DOC_NO = '$value_doc_h->CHR_DOC_NO' and  CHR_ACC_NO IN (SELECT CHR_GL_ACCOUNT FROM ACC.TM_MAP_EQUAL_GL WHERE CHR_ID_EQUALISASI = '$id_equal') ")->row();
                                        }
                                        if (count($data) <> 0) {
                                            $amount = str_replace(".", "", $data->CHR_AMOUNT_DEBIT) - str_replace(".", "", $data->CHR_AMOUNT_KREDIT);
                                            echo "<td style=\"text-align:center\">$data->CHR_ACC_NO</td>";
                                            echo "<td style=\"text-align:center\">$data->CHR_ACC_DESC</td>";
                                            echo "<td style=\"text-align:center\">IDR</td>";
                                            echo "<td style=\"text-align:center\">" . number_format($amount) . "</td>";
                                        } else {
                                            echo "<td style=\"text-align:center\">-</td>";
                                            echo "<td style=\"text-align:center\">-</td>";
                                            echo "<td style=\"text-align:center\">-</td>";
                                            echo "<td style=\"text-align:center\">-</td>";
                                        }
                                    }

                                    //get text
                                    $get_text = $this->db->query("select CHR_TEXT from  ACC.TW_EQUAL_TAX where CHR_DOC_NO = '$value_doc_h->CHR_DOC_NO' and CHR_TEXT <> ''")->row();
                                    if (count($get_text) == 0) {
                                        $get_text = $this->db->query("select CHR_TEXT_NON_PO from  ACC.TW_EQUAL_TAX where CHR_DOC_NO = '$value_doc_h->CHR_DOC_NO' and CHR_TEXT_NON_PO <> ''")->row();
                                        $CHR_TEXT = $get_text->CHR_TEXT_NON_PO;
                                    } else {
                                        $CHR_TEXT = $get_text->CHR_TEXT;
                                    }
                                    echo "<td style = \"text-align:center\">-</td> ";
                                    echo "<td style=\"text-align:center\">$value_doc_h->CHR_CLEARING_DOC</td>";
                                    echo "<td>$CHR_TEXT</td>";
                                    echo "</tr>";
                                }
                                ?>
                            </tbody>
                        </table>





                    </div>
                </div>
            </div>
    </section>
</aside>

<div class="md-modal md-effect-1" id="modal_process">
    <div class="md-content modal-content">
        <div class="modal-header">
            <h4 class="modal-title" id="myModalLabel19" style="text-align:center;">Please Wait ...</h4>
        </div>
        <div class="modal-body">
            <p style="text-align:center;">Connecting to sap Server </p>
            <div style="text-align:center;"><img src="<?php echo base_url('assets/img/ajax-loader-7.gif') ?>"></div>
        </div>
        <div class="modal-footer">
            <div class="btn-group">
                <button type="button" class="btn btn-default md-close" data-dismiss="modal" id="close-loading" style="display:none;">Close</button>
            </div>
        </div>
    </div>
</div>

<div class="md-modal md-effect-1" id="modal-1">
    <div class="md-content modal-content">
        <div class="modal-header">
            <h4 class="modal-title">FISCAL YEAR</h4>
        </div>
        <div class="modal-body">
            <textarea class="form-control" rows="10" id="text-area-fiscal-year"></textarea>
        </div>
        <div class="modal-footer">
            <div class="btn-group">
                <button type="button" class="btn btn-primary md-close" data-dismiss="modal" id="fiscal-year-ok">OK</button>
            </div>
        </div>
    </div>
</div>
<div class="md-modal md-effect-1" id="modal-2">
    <div class="md-content modal-content">
        <div class="modal-header">
            <h4 class="modal-title">DOC NUMBER</h4>
        </div>
        <div class="modal-body">
            <textarea class="form-control" rows="10" id="text-area-doc-number"></textarea>
        </div>
        <div class="modal-footer">
            <div class="btn-group">
                <button type="button" class="btn btn-primary md-close" data-dismiss="modal" id="doc-no-ok">OK</button>
            </div>
        </div>
    </div>
</div>


<script src="<?php echo base_url('assets/js/jquery-1.12.3.js') ?>"></script>
<script src="<?php echo base_url('assets/js/jquery.dataTables.min.js') ?>"></script>
<script src="<?php echo base_url('assets/js/dataTables.fixedColumns.min.js') ?>"></script>
<link rel="stylesheet" href="<?php echo base_url('assets/css/fixedColumns.dataTables.min.css'); ?>" >
<script>
                                    $(document).ready(function () {
                                    var table = $('#dataTables1').DataTable({
                                    scrollY: "350px",
                                            scrollX: true,
                                            scrollCollapse: true,
                                            paging: false,
                                            bFilter: false,
                                            fixedColumns: {
                                            leftColumns: 1
                                            }
                                    });
                                    });
                                    $(document).ready(function () {
                                    var table = $('#example2').DataTable({
                                    scrollY: "800px",
                                            scrollX: true,
                                            scrollCollapse: true,
                                            paging: false,
                                            bFilter: false,
                                            fixedColumns: {
                                            leftColumns: 1
                                            }
                                    });
                                    });
                                    $(document).ready(function () {
                                    var table = $('#example').DataTable({
                                    scrollY: "800px",
                                            scrollX: true,
                                            scrollCollapse: true,
                                            paging: false,
                                            fixedColumns: {
                                            leftColumns: 3
                                            }
                                    });
                                    });
                                    $(document).ready(function () {
                                    $("#fiscal-year-ok").click(function () {
                                    var fiscal_year_value = "";
                                    var fiscal_year = $("#text-area-fiscal-year").val().split("\n");
                                    $.each(fiscal_year, function (fiscal_years) {
                                    fiscal_year_value += fiscal_year[fiscal_years] + ";";
                                    });
                                    $("#fiscal_year_start").val(fiscal_year_value);
                                    });
                                    $("#doc-no-ok").click(function () {
                                    var doc_no_value = "";
                                    var doc_no = $("#text-area-doc-number").val().split("\n");
                                    $.each(doc_no, function (doc_nos) {
                                    doc_no_value += doc_no[doc_nos] + ";";
                                    });
                                    $("#doc_num_start").val(doc_no_value);
                                    });
                                    $("#popup-fiscal-year").click(function () {
                                    var fiscal_year_value = "";
                                    var fiscal_year = $("#fiscal_year_start").val().split(";");
                                    $.each(fiscal_year, function (fiscal_years) {
                                    if (!fiscal_year[fiscal_years] == "") {
                                    fiscal_year_value += fiscal_year[fiscal_years] + "\n";
                                    }
                                    });
                                    $("#text-area-fiscal-year").val(fiscal_year_value);
                                    });
                                    $("#popup-doc-no").click(function () {
                                    var doc_no_value = "";
                                    var doc_no = $("#doc_num_start").val().split(";");
                                    $.each(doc_no, function (doc_nos) {
                                    if (!doc_no[doc_nos] == "") {
                                    doc_no_value += doc_no[doc_nos] + "\n";
                                    }
                                    });
                                    $("#text-area-doc-number").val(doc_no_value);
                                    });
                                    });
</script>

