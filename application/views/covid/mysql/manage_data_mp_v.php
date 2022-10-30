<style type="text/css">
    th, td { white-space: nowrap; }
    div.dataTables_wrapper {
        margin: 0 auto;
    }
    #table-luar{
        font-size: 11px;
    }
    #filter { 
        border-spacing: 10px;
        border-collapse: separate;
    }
    .td-fixed{
        width: 30px;
    }
    .td-no{
        text-align: center;
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
<aside class="right-side">
    <section class="content-header">
        <ol class="breadcrumb">
            <li><a href="<?php echo base_url('index.php/basis/home_c') ?>"><span>Home</span></a></li>
            <li><a href="<?php echo base_url('index.php/basis/user_c') ?>"><strong>Manage Data Man Power</strong></a></li>
        </ol>
    </section>

    <section class="content">
        <?php
        if ($msg != NULL) {
            echo $msg;
        }
        ?>

        <div class="row">
            <div class="col-md-12">
                <div class="grid">
                    <div class="grid-header">
                        <i class="fa fa-user"></i>
                        <span class="grid-title"><strong>MANAGE DATA MAN POWER (MP)</strong></span>
                        <div class="pull-right">
                            <a href="<?php echo base_url('index.php/portal/eform_c/upload_data_mp/') ?>"  class="btn btn-default" data-placement="left" data-toggle="tooltip" title="Upload Data MP" style="height:30px;font-size:13px;width:100px;">Upload</a>
                        </div>
                    </div>
                    <div class="grid-body">
                        <div class="pull">
                            <table width="100%" id='filter' border=0px>                                
                                <tr>
                                    <td width="5%">Group</td>
                                        <td width="10%">
                                        <select class="form-control" id="group" onChange="document.location.href = this.options[this.selectedIndex].value;">
                                            <option value=""></option>
                                            <?php foreach ($all_group as $row) { ?>
                                                <option value="<?PHP echo site_url('portal/eform_c/manage_data_mp/0/' . $row->group); ?>" <?php
                                                if ($group == $row->group) {
                                                    echo 'SELECTED';
                                                }
                                                ?> > <?php echo $row->group; ?> </option>
                                                    <?php } ?>
                                        </select>
                                        </td>
                                    <td width="5%" colspan="4"></td>
                                    <td width="5%"></td>
                                    <td width="50%">    
                                        
                                    </td>
                                    <td width="25%">
                                    </td>
                                </tr>
                            </table>
                            <div style="width: 60%;">                            
                        </div>
                        <div id="table-luar">
                            <table id="example" class="table table-striped table-condensed table-hover display" cellspacing="0" width="100%">
                                <thead>
                                    <tr>
                                        <th>No</th>
                                        <th>NPK</th>
                                        <th>Username</th>
                                        <th>Division</th>
                                        <th>Dept</th>
                                        <th>Section</th>
                                        <th>Direct Labour</th>
                                        <th>Actions</th>

                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    $i = 1;
                                    foreach ($data as $isi) {
                                        echo "<tr class='gradeX'>";
                                        echo "<td>$i</td>";
                                        echo "<td>$isi->npk</td>";
                                        echo "<td>$isi->username</td>";
                                        echo "<td>$isi->div</td>";
                                        echo "<td>$isi->dept</td>";
                                        echo "<td>$isi->section</td>";
                                        if($isi->flg_direct_labour == 0){
                                            echo "<td>No</td>";
                                        } else {
                                            echo "<td>Yes</td>";
                                        }
                                        ?>
                                    <td>
                                        <a href="<?php echo base_url('index.php/portal/eform_c/edit_data_mp') . "/" . trim($isi->npk) ?>" class="label label-warning" data-placement="top" data-toggle="tooltip" title="Edit"><span class="fa fa-pencil"></span></a>
                                        <a href="<?php echo base_url('index.php/portal/eform_c/delete_data_mp') . "/" . trim($isi->npk) ?>" class="label label-danger" data-placement="right" data-toggle="tooltip" title="Delete" onclick="return confirm('Are you sure want to delete this MP?');"><span class="fa fa-times"></span></a>
                                    </td>
                                    </tr>
                                    <?php
                                    $i++;
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
<script src="<?php echo base_url('assets/js/jquery-1.12.3.js') ?>"></script>
<script src="<?php echo base_url('assets/js/jquery.dataTables.min.js') ?>"></script>
<script src="<?php echo base_url('assets/js/dataTables.fixedColumns.min.js') ?>"></script>
<script>

                                        $(document).ready(function () {
                                            $('#example').DataTable({
                                                scrollX: true,
//                                                fixedColumns: {
//                                                    //leftColumns: 2
//                                                }
                                            });
                                        });
</script>