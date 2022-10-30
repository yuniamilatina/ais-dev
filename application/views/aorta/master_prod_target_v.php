
<style type="text/css">
    #table-luar{
        font-size: 12px;
    }
    #filter { 
        border-spacing: 10px;
    }
    .td-fixed{
        width: 10px;
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
    }

    .btn:hover {
        background: #1E90FF;
        background-image: -webkit-linear-gradient(top, #1E90FF, #1E90FF);
        background-image: -moz-linear-gradient(top, #1E90FF, #1E90FF);
        background-image: -ms-linear-gradient(top, #1E90FF, #1E90FF);
        background-image: -o-linear-gradient(top, #1E90FF, #1E90FF);
        background-image: linear-gradient(to bottom, #1E90FF, #1E90FF);
        color:white;
    }

</style>

<aside class="right-side">
    <section class="content-header">
        <ol class="breadcrumb">
            <li><a href="<?php echo base_url('index.php/basis/home_c/'); ?>"><span>Home</span></a></li>
            <li><a href=""><strong>Master Monthly Production Target</strong></a></li>
        </ol>
    </section>

    <section class="content">

        <div class="row">
            <div class="col-md-12">
                <div class="grid">
                    <div class="grid-header">
                        <i class="fa fa-th-large"></i>
                        <span class="grid-title"><strong> Master Monthly Production Target </strong></span>

                        <div class="pull-right grid-tools">
                            <button <?php if ($role == 3 || $role == 4) { echo 'disabled'; }?> class="btn btn-primary" data-toggle="modal" data-target="#modalPrimary">Update</button>
                            <a data-widget="collapse" title="Collapse"><i class="fa fa-chevron-up"></i></a>
                        </div>
                    </div>

                    <div class="grid-body">
                        <div class="pull">
                            <table width="100%" id='filter'>
                                <tr>
                                    <td width="10%">Periode</td>
                                    <td width="30%">
                                        <select class="ddl" id="tanggal" onChange="document.location.href = this.options[this.selectedIndex].value;">
                                            <?php for ($x = -5; $x <= 5; $x++) { ?>
                                                <option value="<?PHP echo site_url('aorta/master_prod_target_c/prod_target/' . date("Ym", strtotime("+$x month")). "/$id_prod/$id_section/$id_subsect"); ?>" <?php
                                                if ($selected_date == date("Ym", strtotime("+$x month"))) {
                                                    echo 'SELECTED';
                                                }
                                                ?> > <?php echo date("M Y", strtotime("+$x month")); ?> </option>
                                                    <?php } ?>
                                        </select>
                                    </td>
                                    <td>Section</td>
                                    <td>
                                        <select id="opt_wcenter" onChange="document.location.href = this.options[this.selectedIndex].value;" class="ddl2">
                                            <option value="<?php echo site_url('aorta/master_prod_target_c/prod_target/' . $selected_date . "/$id_prod/ALL/ALL") ?>">ALL</option>
                                            <?php foreach ($all_work_centers as $row) { ?>
                                                <option value="<?php echo site_url('aorta/master_prod_target_c/prod_target/' . $selected_date . "/$id_prod/".trim($row->KODE)."/ALL"); ?>" 
                                                <?php
                                                if (trim($id_section) == trim($row->KODE)) {
                                                    echo 'SELECTED';
                                                }
                                                ?> >
                                                    <?php echo trim($row->KODE); ?></option>
                                            <?php } ?>
                                        </select>
                                    </td>
                                    <td width="10%">
                                    </td>
                                </tr>
                                <tr>
                                    <td width="10%">Department</td>
                                    <td width="30%">
                                        <?php if ($role == 5) { ?>
                                            <select disabled style="cursor:not-allowed;background-color: #F3F4F5;" id="opt_wcenter" onChange="document.location.href = this.options[this.selectedIndex].value;" class="ddl2">
                                            <?php } else { ?>
                                                <select id="opt_wcenter" onChange="document.location.href = this.options[this.selectedIndex].value;" class="ddl2">
                                                <?php } ?>
                                                    <option value="<?php echo site_url('aorta/master_prod_target_c/prod_target/' . $selected_date . "/ALL/ALL/ALL") ?>">ALL</option>
                                                <?php foreach ($all_dept_prod as $row) { ?>
                                                    <option value="<?php echo site_url("aorta/master_prod_target_c/prod_target/" . $selected_date . '/' . $row->INT_ID_DEPT . "/ALL/ALL"); ?>" <?php
                                                    if ($id_prod == $row->INT_ID_DEPT) {
                                                        echo 'SELECTED';
                                                    }
                                                    ?> ><?php echo trim($row->CHR_DEPT_DESC); ?></option>
                                                        <?php } ?>
                                            </select>
                                    </td>
                                    <td>Sub Section</td>
                                    <td>
                                        <select id="opt_wcenter" onChange="document.location.href = this.options[this.selectedIndex].value;" class="ddl2">
                                            <option value="<?php echo site_url('aorta/master_prod_target_c/prod_target/' . $selected_date . "/$id_prod/$id_section/ALL") ?>">ALL</option>
                                            <?php foreach ($all_lines as $row) { ?>
                                                <option value="<?php echo site_url('aorta/master_prod_target_c/prod_target/' . $selected_date . "/$id_prod/$id_section/$row->KODE"); ?>" 
                                                <?php
                                                if (trim($id_subsect) == trim($row->KODE)) {
                                                    echo 'SELECTED';
                                                }
                                                ?> >
                                                    <?php echo trim($row->KODE); ?></option>
                                            <?php } ?>
                                        </select>
                                    </td>
                                    <td width="10%">        
                                    </td>
                                </tr>
                            </table>
                        </div>

                        <div id="table-luar">
                            <table id="dataTables3" class="table table-condensed table-striped table-hover display" cellspacing="0" width="100%">
                                <thead>
                                    <tr class='gradeX'>
                                        <!------- HEADER TABLE ------->
                                        <th rowspan="1" style="vertical-align: middle; text-align: center">No</th>
                                        <th rowspan="1" style="vertical-align: middle; text-align: center">Periode</th>
                                        <th rowspan="1" style="vertical-align: middle; text-align: center">Dept</th>
                                        <th rowspan="1" style="vertical-align: middle; text-align: center">Section</th>
                                        <th rowspan="1" style="vertical-align: middle; text-align: center">Line</th>
                                        <th rowspan="1" style="vertical-align: middle; text-align: center">Target Prod</th>
                                        <th rowspan="1" style="vertical-align: middle; text-align: center">Loading WO</th>                                        
                                        <th rowspan="1" style="vertical-align: middle; text-align: center">MP</th>
                                        <th rowspan="1" style="vertical-align: middle; text-align: center">Sigma CT</th>
                                        <th rowspan="1" style="vertical-align: middle; text-align: center">MH/pcs</th>
                                        <th rowspan="1" style="vertical-align: middle; text-align: center">Plan Shift</th>
                                        <th rowspan="1" style="vertical-align: middle; text-align: center">Working Days</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    $r = 1;
                                    $session = $this->session->all_userdata();
                                    if (count($data_prod_target) > 0) {
                                        foreach ($data_prod_target as $isi) {
                                            echo "<tr class='gradeX'>";
                                            echo "<td style=text-align:center;>$r</td>";
                                            echo "<td style=text-align:center;>$isi->CHR_DATE_PERIODE</td>";
                                            echo "<td style=text-align:center;>$isi->CHR_DEPT</td>";
                                            echo "<td style=text-align:center;>$isi->CHR_SECTION</td>";
                                            echo "<td style=text-align:center;>$isi->CHR_LINE</td>";
                                            echo "<td style=text-align:center;>$isi->INT_TARGET_PRD</td>";
                                            echo "<td style=text-align:center;>$isi->INT_LOAD</td>";
                                            echo "<td style=text-align:center;>$isi->INT_MP</td>";
                                            echo "<td style=text-align:center;>$isi->INT_CT</td>";
                                            echo "<td style=text-align:center;>$isi->FLT_MH_PCS</td>";
                                            echo "<td style=text-align:center;>$isi->INT_PLAN_SHIFT</td>";
                                            echo "<td style=text-align:center;>$isi->INT_WD</td>";
                                            ?>
                                            </tr>
                                            <?php
                                            $r++;
                                        }
                                    }
                                    ?>
                                </tbody>
                            </table>
                        </div>
                    </div>

                </div>
            </div>
        </div>



        <div class="modal fade" id="modalPrimary" tabindex="-1" role="dialog" aria-labelledby="myModalLabel2" aria-hidden="true">
            <div class="modal-wrapper">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <form class="form-horizontal" role="form" action="<?php echo base_url('index.php/aorta/master_prod_target_c/upload_template_prod_target'); ?>" method="post"  enctype="multipart/form-data">
                            <div class="modal-header">
                                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                                <h4 class="modal-title" id="myModalLabel2" >Upload Master Data Monthly Production Target</h4>
                            </div>
                            <div class="modal-body" >
                                <div class="form-group" style="text-align:center;">
                                    <span style="text-align:center;"><a href="<?php echo base_url('index.php/aorta/master_prod_target_c/generate_template/' . $kode_dept); ?>">Download Template Master Data</a></span>
                                </div>
                                <div class="form-group">
                                    <label class="col-sm-3 control-label"> Input File </label>
                                    <div class="col-sm-7">
                                        <input type="file" class="form-control" name="import_prod_target" id="import_prod_target" size="20" value="">
                                    </div>
                                    <label class="col-sm-3 control-label"> Periode </label>
                                    <div class="col-sm-7">
                                        <select class="ddl" id="periode" name="periode">
                                            <?php for ($x = -5; $x <= 5; $x++) { ?>
                                                <option value="<?PHP echo date("Ym", strtotime("+$x month")); ?>" <?php
                                                if ($selected_date == date("Ym", strtotime("+$x month"))) {
                                                    echo 'SELECTED';
                                                }
                                                ?> > <?php echo date("M Y", strtotime("+$x month")); ?> </option>
                                                    <?php } ?>
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <div class="modal-footer">
                                <div class="btn-group">
                                    <button type="button" class="btn btn-default" data-dismiss="modal"> Close </button>
                                    <button class="btn btn-primary" value="1" name="upload_button"> Upload </button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>



    </section>
</aside>

