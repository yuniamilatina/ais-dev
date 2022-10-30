<style type="text/css">
    th,
    td {
        white-space: nowrap;
    }

    div.dataTables_wrapper {
        margin: 0 auto;
    }

    #table-luar {
        font-size: 11px;
    }

    #filter {
        border-spacing: 10px;
        border-collapse: separate;
    }

    .td-fixed {
        width: 30px;
    }

    .td-no {
        width: 10px;
    }

    .ddl {
        width: 100px;
        height: 30px;
    }

    .ddl2 {
        width: 180px;
        height: 30px;
    }
</style>

<script language="JavaScript">
    function angka(objek) {
        a = objek.value;
        b = a.replace(/[^\d]/g, "");
        c = "";
        panjang = b.length;
        j = 0;
        for (i = panjang; i > 0; i--) {
            j = j + 1;
            if (((j % 3) == 1) && (j != 1)) {
                c = b.substr(i - 1, 1) + "" + c;
            } else {
                c = b.substr(i - 1, 1) + c;
            }
        }
        objek.value = Number(c);
    }

    function Number(s) {
        while (s.substr(0, 1) == '0' && s.length > 1) {
            s = s.substr(1, 9999);
        }
        while (s.substr(0, 1) == '' && s.length > 1) {
            s = s.substr(1, 9999);
        }
        return s;
    }
</script>

<script src="<?php echo base_url('assets/js/dropzone.js') ?>"></script>
<link rel="stylesheet" href="<?php echo base_url('assets/css/dropzone.css') ?>">
<aside class="right-side">
    <section class="content-header">
        <ol class="breadcrumb">
            <li><a href="<?php echo base_url('index.php/basis/home_c/') ?>"><span>Home</span></a></li>
            <li> <a href="<?php echo base_url('index.php/prd/pos_material_c') ?>">MANAGE POS MATERIAL</a></li>
            <li> <a href="#"><strong>CREATE POS MATERIAL</strong></a></li>
        </ol>
    </section>
    <section class="content">
        <?php
        if ($msg != null) {
            echo $msg;
        }
        ?>
        <div class="row">
            <div class="col-md-12">
                <div class="grid">
                    <div class="grid-header">
                        <i class="fa  fa-puzzle-piece"></i>
                        <span class="grid-title" id="stat-create2"><strong id="stat-create">MAPPING PART MATERIAL - POS</strong></span>
                        <div class="pull-right grid-tools">
                            <a data-widget="collapse" title="Collapse" id="collapse-header"><i class="fa fa-chevron-up"></i></a>
                        </div>
                    </div>
                    <?php
                    echo form_open('prd/pos_material_c/search_component', 'class="form-horizontal"');
                    ?>
                    <div class="grid-body">

                        <div class="form-group">
                            <label class="col-sm-3 control-label">Work Center</label>
                            <div class="col-sm-2">
                                <select id="work_center" readonly name="CHR_WORK_CENTER" class="form-control" onchange="get_data_part();">
                                    <?php
                                    foreach ($all_work_centers as $row) {
                                        if (trim($row->CHR_WORK_CENTER) == trim($work_center)) {
                                    ?>
                                            <option selected value="<?php echo trim($row->CHR_WORK_CENTER); ?>">
                                                <?php echo trim($row->CHR_WORK_CENTER); ?> </option>
                                        <?php } else { ?>
                                            <option value="<?php echo trim($row->CHR_WORK_CENTER); ?>">
                                                <?php echo trim($row->CHR_WORK_CENTER); ?> </option>
                                    <?php
                                        }
                                    }
                                    ?>
                                </select>
                            </div>
                            <div class="col-sm-3">
                                <select class="form-control" name="CHR_PART_NO" id="e1" required>
                                    <?php
                                    foreach ($data_part_no as $row) {
                                        if (trim($row->CHR_PART_NO) == trim($part_no)) {
                                    ?>
                                            <option selected value="<?php echo trim($row->CHR_PART_NO); ?>">
                                                <?php echo trim($row->CHR_PART_NO); ?> </option>
                                        <?php } else { ?>
                                            <option value="<?php echo trim($row->CHR_PART_NO); ?>">
                                                <?php echo trim($row->CHR_PART_NO); ?> </option>
                                    <?php
                                        }
                                    }
                                    ?>
                                </select>
                            </div>
                            <div class="col-sm-3">
                                <button type="submit" class="btn btn-default"><i class="fa fa-search"></i> Search</button>
                            </div>
                        </div>

                        <?php
                        echo form_close();
                        ?>
                        <hr>
                        <?php
                        echo form_open('prd/pos_material_c/save_pos_material', 'class="form-horizontal"');
                        ?>

                        <div class="form-group" style="margin-bottom:10px;margin-right:8px;margin-left:8px;">
                            <label class="col-sm-2">Component Part</label>
                            <div class="col-sm-10" style='text-align:right'>
                                <a href="#" id="add-sub-assy-id" class="btn btn-success" data-toggle="modal" data-target="#modalSubAssy" data-placement="left" title="Add Sub Assy"><i class="fa fa-plus"></i> Add Sub Assy</a>
                            </div>
                        </div>

                        <div id="table-luar" class="col-sm-12">
                            <table style="margin-bottom:15px;" id="" class="table table-condensed table-striped table-hover display" cellspacing="0" width="100%">
                                <thead>
                                    <tr>
                                        <th style="text-align:center;background-color:#666666;color:#FFFFFF;">No</th>
                                        <th style="text-align:center;background-color:#666666;color:#FFFFFF;">Image</th>
                                        <th style="text-align:center;background-color:#666666;color:#FFFFFF;">P/N Comp.</th>
                                        <th style="text-align:center;background-color:#666666;color:#FFFFFF;">B/N Comp.</th>
                                        <th style="text-align:left;background-color:#666666;color:#FFFFFF;">Description</th>
                                        <th style="text-align:left;background-color:#666666;color:#FFFFFF;">Ignore Scan</th>
                                        <th style="text-align:center;background-color:#666666;color:#FFFFFF;">Pos</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    $i = 1;
                                    foreach ($data_bom as $row) {
                                        echo "<tr class='gradeX'>";
                                        echo "<td style='text-align:center;vertical-align: middle;'>$i</td>";
                                        echo "<td style='text-align:center;vertical-align: middle;'><img data-enlargable width='50' style='cursor: zoom-in'; src='" . base_url() . trim($row->CHR_IMAGE_PIS_URL) . "?id=" . rand(10, 1000) . "' '></td>";
                                        echo "<td style='text-align:center;vertical-align: middle;'>$row->CHR_PART_NO_COMP</td>";
                                        echo "<td style='text-align:center;vertical-align: middle;'>$row->CHR_BACK_NO_COMP</td>";
                                        echo "<td style='text-align:left;vertical-align: middle;'>$row->CHR_PART_NAME</td>";
                                        if ($row->INT_FLG_IGNORE_SCAN == 1) {
                                            $flg_ignore = 'checked';
                                        } else {
                                            $flg_ignore = 'unchecked';
                                        }
                                    ?>
                                        <td style='text-align:center;vertical-align: middle;'><input type='checkbox' value='1' name="INT_FLG_IGNORE_SCAN[<?php echo trim($row->CHR_PART_NO_COMP) ?>]" <?php echo $flg_ignore; ?> class='icheck'></td>
                                        <td style='text-align:center;vertical-align: middle;'>
                                            <select required class="form-control" name="CHR_POS_PRD[<?php echo trim($row->CHR_PART_NO_COMP) ?>]">
                                                <option value=""></option>
                                                <?php foreach ($data_pos as $row_pos) { ?>
                                                    <option value="<?php echo trim($row_pos->CHR_POS_PRD) ?>" <?php echo (trim($row->CHR_POS_PRD) == trim($row_pos->CHR_POS_PRD) ? "selected" : false) ?>>
                                                        <?php echo trim($row_pos->CHR_POS_PRD); ?> </option>
                                                <?php } ?>
                                            </select>
                                        </td>
                                        </tr>
                                    <?php
                                        $i++;
                                    }
                                    ?>
                                </tbody>
                            </table>
                            <input type="hidden" name="CHR_WORK_CENTER" value="<?php echo $work_center ?>"></input>
                            <input type="hidden" name="CHR_PART_NO_FG" value="<?php echo $part_no ?>"></input>
                        </div>

                        <div id="table-add-sa" class="col-sm-12" style="margin-top:20px;font-size:11px;">
                            Matrix Sub Assy
                            <table style="margin-bottom:15px;" class="table table-striped table-condensed display" cellspacing="0" width="100%">
                                <thead>
                                    <tr style="text-align:center;background-color:#666666;color:#FFFFFF;">
                                        <th> No</th>
                                        <th> Image</th>
                                        <th> P/N Comp.</th>
                                        <th> B/N Comp.</th>
                                        <th> Description</th>
                                        <th> Flg Ignore</th>
                                        <th> Pos</th>
                                        <th> Action</th>
                                    </tr>
                                </thead>
                                <tbody id="detail-part-sa-id">
                                    <tr>
                                        <td rowspan="2" style="text-align:center;vertical-align: middle;">NO</td>
                                        <td rowspan="2" style="text-align:center;vertical-align: middle;">Image</td>
                                        <td rowspan="2" style="text-align:center;vertical-align: middle;">Desc</td>
                                        <td>P/N Comp</td>
                                        <td>B/N Comp</td>
                                        <td rowspan="2" style="text-align:center;vertical-align: middle;">Flg Ignore</td>
                                        <td rowspan="2" style="text-align:center;vertical-align: middle;">Pos</td>
                                        <td rowspan="2" style="text-align:center;vertical-align: middle;">Action</td>
                                    </tr>
                                    <tr>
                                        <td>P/N Comp</td>
                                        <td>B/N Comp</td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>

                        <div class="form-group">
                            <div class="col-sm-offset-4 col-sm-5">
                                <div class="btn-group">
                                    <button type="submit" class="btn btn-primary"><i class="fa fa-check"></i>
                                        Save</button>
                                    <?php
                                    echo anchor('prd/pos_material_c/index/' . $work_center, 'Cancel', 'class="btn btn-default"');
                                    echo form_close();
                                    ?>
                                </div>
                            </div>
                        </div>

                    </div>
                </div>
            </div>

            <!-- Modal Create Sub Assy -->
            <div class="modal fade" id="modalSubAssy" tabindex="-1" role="dialog" aria-labelledby="modalLabelMold" aria-hidden="true" style="display: none;">
                <div class="modal-wrapper">
                    <div class="modal-dialog" style="width:900px;">
                        <div class="modal-content">
                            <div class="modal-header">
                                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                                <h4 class="modal-title" id="modalLabelMold"><strong>ADD SUB ASSY PREPARATION </strong>
                                </h4>
                            </div>

                            <div class="modal-body" style="font-size:12px;">
                                <form class="form-horizontal" role="form" id="form-add-part-sa-id" enctype="multipart/form-data">
                                    <div class="form-group">
                                        <label class="col-sm-3 control-label">Desc</label>
                                        <div class="col-sm-4">
                                            <input type="text" class="form-control" id="description-id" name='description_sa'>
                                            <input type="hidden" name="CHR_WORK_CENTER" value="<?php echo $work_center ?>"></input>
                                            <input type="hidden" name="CHR_PART_NO_FG" value="<?php echo $part_no ?>"></input>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label class="col-sm-3 control-label">POS</label>
                                        <div class="col-sm-4">
                                            <select required class="form-control" name="pos_sa" id="pos-sa-id">
                                                <option value=""></option>
                                                <?php foreach ($data_pos as $row_pos) { ?>
                                                    <option value="<?php echo trim($row_pos->CHR_POS_PRD); ?>" <?php ($row->CHR_POS_PRD == $row_pos->CHR_POS_PRD ? "selected" : false) ?>>
                                                        <?php echo trim($row_pos->CHR_POS_PRD); ?> </option>
                                                <?php } ?>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label class="col-sm-3 control-label"></label>
                                        <div class="col-sm-5">
                                            <div class="checkbox">
                                                <input type="checkbox" value="1" name="INT_FLG_IGNORE_SCAN" unchecked class="icheck">&nbsp;&nbsp;<i>Pemindaian akan diabaikan</i>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label class="col-sm-3 control-label">PIS</label>
                                        <div class="col-sm-4">
                                            <div class="dropzone">
                                                <div class="dz-message">
                                                    <h3> Klik atau Drop gambar disini</h3>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <table id="example2" class="table table-striped table-condensed table-hover display" cellspacing="0" width="100%">
                                        <thead>
                                            <tr>
                                                <th style="text-align:center;background-color:#666666;color:#FFFFFF;">No
                                                </th>
                                                <th style="text-align:center;background-color:#666666;color:#FFFFFF;">Part
                                                    No. Comp.</th>
                                                <th style="text-align:center;background-color:#666666;color:#FFFFFF;">Back
                                                    No. Comp.</th>
                                                <th style="text-align:left;background-color:#666666;color:#FFFFFF;">
                                                    Part Name Comp.</th>
                                                <th style="text-align:center;background-color:#666666;color:#FFFFFF;">
                                                    Action</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php
                                            $i = 1;
                                            foreach ($data_bom as $row) {
                                                echo "<tr class='gradeX'>";
                                                echo "<td style='text-align:center;'>$i</td>";
                                                echo "<td style='text-align:center;'>$row->CHR_PART_NO_COMP</td>";
                                                echo "<td style='text-align:center;'>$row->CHR_BACK_NO_COMP</td>";
                                                echo "<td style='text-align:left;'>$row->CHR_PART_NAME</td>";
                                            ?>
                                                <td><input class='icheck' id="cb_part_sa" type="checkbox" name="cb_part_sa[<?php echo trim($row->CHR_PART_NO_COMP) ?>]" value="1"></td>
                                                </tr>
                                            <?php
                                                $i++;
                                            }
                                            ?>
                                        </tbody>

                                    </table>
                                </form>
                            </div>
                            <div class="modal-footer">
                                <div class="btn-group">
                                    <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
                                    <button type="submit" class="btn btn-primary" data-placement="left" title="Add Part Number" data-dismiss="modal" id="btn-add-sa-id"><i class="fa fa-check"></i> Add to List</button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Modal Edit Image Sub Assy -->
            <div class="modal fade" id="modalEditImageSubAssy" tabindex="-1" role="dialog" aria-labelledby="modalEditImageSubAssy" aria-hidden="true" style="display: none;">
                <div class="modal-wrapper">
                    <div class="modal-dialog" style="width:900px;">
                        <div class="modal-content">
                            <div class="modal-header">
                                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                                <h4 class="modal-title" id=""><strong>EDIT SUB ASSY PREPARATION </strong>
                                </h4>
                            </div>

                            <div class="modal-body" style="font-size:12px;">
                                <form class="form-horizontal" role="form" id="form-edit-part-sa-id" enctype="multipart/form-data">
                                    <div class="form-group">
                                        <label class="col-sm-3 control-label">Description</label>
                                        <div class="col-sm-7">
                                            <input type="text" class="form-control" id="edit-description-id" name='description_sa' readonly>
                                            <input type="hidden" name="CHR_WORK_CENTER" id="edit-work-center-id" value="<?php echo $work_center ?>"></input>
                                            <input type="hidden" name="CHR_PART_NO_SA" id="edit-part-no-sa-id" value=""></input>
                                            <input type="hidden" name="CHR_BACK_NO_SA" id="edit-back-no-sa-id" value=""></input>
                                            <input type="hidden" name="CHR_PART_NO_FG" id="edit-part-no-fg-id" value="<?php echo $part_no ?>"></input>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label class="col-sm-3 control-label">POS</label>
                                        <div class="col-sm-7">
                                            <select required class="form-control" name="pos_sa" id="edit-pos-sa-id" style="width:20%" readonly>
                                                <option value=""></option>
                                                <?php foreach ($data_pos as $row_pos) { ?>
                                                    <option value="<?php echo trim($row_pos->CHR_POS_PRD); ?>" <?php ($row->CHR_POS_PRD == $row_pos->CHR_POS_PRD ? "selected" : false) ?>>
                                                        <?php echo trim($row_pos->CHR_POS_PRD); ?> </option>
                                                <?php } ?>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label class="col-sm-3 control-label">Part Identification Sheet</label>
                                        <div class="col-sm-4">
                                            <div class="dropzone" id="dropzone-edit">
                                                <div class="dz-message">
                                                    <h3> Klik atau Drop gambar disini</h3>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </form>
                            </div>
                            <div class="modal-footer">
                                <div class="btn-group">
                                    <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
                                    <button type="submit" class="btn btn-primary" data-placement="left" title="Add Part Number" data-dismiss="modal" id="btn-edit-sa-id"><i class="fa fa-check"></i> Edit Image</button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>



            <script>
                var j = 0;

                function setTable(row) {
                    var checkedValue = null;
                    var inputElements = document.getElementsByName('chk_list[]');

                    var Parent = document.getElementById('partNumb');
                    while (Parent.hasChildNodes()) {
                        Parent.removeChild(Parent.firstChild);
                    }

                    var no = 1;
                    for (var i = 0; inputElements[i]; ++i) {
                        if (inputElements[i].checked) {
                            var mystr = inputElements[i].value;
                            var myarr = mystr.split(":");
                            var partNoComp = myarr[0];
                            var backNoComp = myarr[1];
                            var partName = myarr[2];

                            $('#example').append('<tr id="row' + j + '"><td>' + no + '</td><td>' + partNoComp +
                                '<input type="hidden" name="partnumb[]" value="' + inputElements[i].value +
                                '"></td><td>' + backNoComp + '</td><td>' + partName + '</td><td>' + 'pos' +
                                '</td><td><a href="#" class="label label-danger" onclick="removeRow(\'row' + j +
                                '\')"><span class="fa fa-times"></span></a></td></tr>');
                            j++;
                            ++no;
                        }
                    }
                }
            </script>

            <script>
                function removeRow(rowid) {
                    var row = document.getElementById(rowid);
                    row.parentNode.removeChild(row);
                }
            </script>

    </section>
</aside>

<script type="text/javascript" language="javascript">
    $("#upload").fileinput({
        'showUpload': false
    });

    function get_data_work_center() {
        var dept_to_work_center = document.getElementById('dept_to_work_center').value;

        $.ajax({
            async: false,
            type: "POST",
            dataType: 'json',
            url: "<?php echo site_url('prd/direct_backflush_general_c/get_work_center_by_id_dept'); ?>",
            data: {
                INT_ID_DEPT: dept_to_work_center
            },
            success: function(json_data) {
                $("#work_center").html(json_data['data']);
            },
            error: function(request) {
                alert(request.responseText);
            }
        });
    }

    function get_data_part() {
        var work_center = document.getElementById('work_center').value;

        $.ajax({
            async: false,
            type: "POST",
            dataType: 'json',
            url: "<?php echo site_url('part/part_c/get_data_part_by_work_center'); ?>",
            data: {
                CHR_WCENTER: work_center
            },
            success: function(json_data) {
                $("#e1").html(json_data['data']);
            },
            error: function(request) {
                alert(request.responseText);
            }
        });
    }
</script>

<script src="<?php echo base_url('assets/js/jquery-1.12.3.js') ?>"></script>
<script src="<?php echo base_url('assets/js/jquery.dataTables.min.js') ?>"></script>
<script src="<?php echo base_url('assets/js/dataTables.fixedColumns.min.js') ?>"></script>
<link rel="stylesheet" href="<?php echo base_url('assets/css/fixedColumns.dataTables.min.css'); ?>">
<script>
    $(document).ready(function() {
        var table = $('#example').DataTable({
            scrollY: "450px",
            scrollX: true,
            scrollCollapse: true,
            paging: false,
            bFilter: false,
            fixedColumns: {
                leftColumns: 0
            }
        });

        refresh_table_sa();

        var table = $('#example2').DataTable({
            scrollY: "400px",
            scrollX: true,
            scrollCollapse: true,
            paging: false,
            fixedColumns: {
                leftColumns: 0
            }
        });

        $('.dataTables_filter input').addClass('search-query');
        $('.dataTables_filter input').attr('placeholder', 'Search');
    });



    $("#btn-add-sa-id").click(function() {
        var frm_crud = $("#form-add-part-sa-id");
        var frm_data = frm_crud.serializeArray();
        $.ajax({
            url: "<?php echo site_url("/prd/pos_material_c/add_part_sa_tw") ?>",
            type: "POST",
            data: frm_data,
            success: function(data) {
                $("#description-id").val("");
                $("#pos-sa-id").val("");
                $('#pos-sa-id').trigger('change');
                $('#cb_part_sa').removeAttr('checked');
                refresh_table_sa();
            },
            error: function(data) {}
        });
    });

    $("#btn-edit-sa-id").click(function() {
        var frm_crud = $("#form-edit-part-sa-id");
        var frm_data = frm_crud.serializeArray();
        $.ajax({
            url: "<?php echo site_url("/prd/pos_material_c/edit_part_sa_tw") ?>",
            type: "POST",
            data: frm_data,
            success: function(data) {
                $("#description-id").val("");
                $("#pos-sa-id").val("");
                $('#pos-sa-id').trigger('change');
                $('#cb_part_sa').removeAttr('checked');
                refresh_table_sa();
            },
            error: function(data) {}
        });
    });

    $("#add-sub-assy-id").click(function() {
        $.ajax({
            url: "<?php echo site_url("/prd/pos_material_c/delete_pis_sa_user") ?>",
            type: "POST",
            success: function(data) {},
            error: function(data) {
                alert("error delete");
            }
        });
    });



    function editImageSubAsyy(part_no_sa) {
        var part_no = "<?php echo trim($part_no) ?>";
        var work_center = "<?php echo trim($work_center) ?>";
        $.ajax({
            url: "<?php echo site_url("/prd/pos_material_c/get_detail_part_no_sa") ?>",
            type: "POST",
            data: "part_no=" + part_no + "&work_center=" + work_center + "&part_no_sa=" + part_no_sa,
            success: function(data) {
                result = JSON.parse(data);
                console.log(result[0].INT_ID);
                $("#edit-description-id").val(result[0].CHR_DESC_SA);
                $("#edit-part-no-sa-id").val(result[0].CHR_PART_NO_SA);
                $("#edit-back-no-sa-id").val(result[0].CHR_BACK_NO_SA);
                $("#edit-pos-sa-id").val(result[0].CHR_POS_PRD).change();
            },
            error: function(data) {
                alert("error delete");
            }
        });
        $("#modalEditImageSubAssy").modal();
    }

    function refresh_table_sa() {
        var part_no = "<?php echo trim($part_no) ?>";
        var work_center = "<?php echo trim($work_center) ?>";
        console.log(part_no);
        $.ajax({
            url: "<?php echo site_url("/prd/pos_material_c/select_part_sa") ?>",
            type: "POST",
            data: "part_no=" + part_no + "&work_center=" + work_center,
            success: function(data) {
                $("#detail-part-sa-id").html(data);
            },
            error: function(data) {}
        });
    }

    function delete_material_sa(part_no_sa) {
        var part_no = "<?php echo trim($part_no) ?>";
        var work_center = "<?php echo trim($work_center) ?>";
        if (confirm("Are you sure you want to delete this Sub Assy?")) {
            $.ajax({
                url: "<?php echo site_url("/prd/pos_material_c/delete_material_sa") ?>",
                type: "POST",
                data: "part_no=" + part_no + "&work_center=" + work_center + "&part_no_sa=" + part_no_sa,
                success: function(data) {
                    refresh_table_sa();
                },
                error: function(data) {}
            });
        }
    }
</script>


<script type="text/javascript">
    Dropzone.autoDiscover = false;
    var foto_upload = new Dropzone(".dropzone", {
        url: "<?php echo base_url('index.php/prd/pos_material_c/upload_pis_sa') ?>",
        maxFilesize: 1,
        method: "post",
        acceptedFiles: "image/*",
        paramName: "userfile",
        dictInvalidFileType: "Type file ini tidak dizinkan",
        addRemoveLinks: true,
    });

    var foto_edit = new Dropzone("#dropzone-edit", {
        url: "<?php echo base_url('index.php/prd/pos_material_c/upload_pis_sa') ?>",
        maxFilesize: 1,
        method: "post",
        acceptedFiles: "image/*",
        paramName: "userfile",
        dictInvalidFileType: "Type file ini tidak dizinkan",
        addRemoveLinks: true,
    });


    //Event ketika Memulai mengupload
    foto_upload.on("sending", function(a, b, c) {
        a.token = Math.random();
        c.append("token_foto", a.token); //Menmpersiapkan token untuk masing masing foto
    });


    $('img[data-enlargable]').addClass('img-enlargable').click(function() {
        var src = $(this).attr('src');
        $('<div>').css({
            background: 'RGBA(0,0,0,.5) url(' + src + ') no-repeat center',
            backgroundSize: 'contain',
            width: '100%',
            height: '100%',
            position: 'fixed',
            zIndex: '10000',
            top: '0',
            left: '0',
            cursor: 'zoom-out'
        }).click(function() {
            $(this).remove();
        }).appendTo('body');
    });
</script>