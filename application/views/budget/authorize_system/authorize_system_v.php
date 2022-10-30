
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
            <li><a href=""><strong>Authorized Upload</strong></a></li>
        </ol>
    </section>

    <section class="content">
        <div class="form-group">
        <form name="authorized_system" action="<?php echo site_url("budget/authorize_system_c/update_authorized_upload") ?>" method="post" >
        <div class="row">
            <div class="col-md-12">
                <div class="grid">
                    <div class="grid-header">
                        <i class="fa fa-th-large"></i>
                        <span class="grid-title"><strong> Authorized Upload</strong></span>
                        <div class="pull-right grid-tools">
                            <button type="submit" class="btn btn-primary" value="1" name="update"><i class="fa fa-refresh"></i> Update </button>
                        </div>
                    </div>
                    <?php if($this->session->flashdata('flashSuccess')){ ?>
                            <div class="grid-body">
                                <div class="alert alert-success">
                                    <strong>Success!</strong> Authorization system berhasil di Update.
                                </div>
                            </div>
                    <?php } ?>

                    <div class="grid-body">                        
                        <div id="table-luar">
                            <table id="example" class="table table-bordered table-condensed table-striped table-hover display" cellspacing="0" width="100%">
                                <thead>
                                    <tr class='gradeX'>
                                        <!------- HEADER TABLE ------->
                                        <th style="vertical-align: middle; text-align: center">No</th>
                                        <th style="vertical-align: middle; text-align: center">Budget Sub Group</th>
                                        <th style="vertical-align: middle; text-align: center">Budget Sub Group Desc</th>
                                        <?php
                                        $index = 1;
                                        $count_dept = count($all_dept);
                                        if($index < ($count_dept + 1)){
                                            foreach($all_dept as $data){
                                                echo "<th style='vertical-align: middle; text-align: center'>$data->CHR_DEPT</th>"; 
                                            $index++;
                                            }                                        
                                        }
                                        ?>                               
                                    </tr>
                                </thead>
                                <tbody>                                    
                                    <?php
                                        $no = 1;
                                        foreach($all_budget_sub_group as $bgt){
                                    ?>
                                    <tr class='gradeX'>
                                        <td><?php echo $no; ?></td>
                                        <td><?php echo ucfirst($bgt->CHR_BUDGET_SUB_GROUP); ?></td>
                                        <td><?php echo ucfirst($bgt->CHR_BUDGET_SUB_GROUP_DESC); ?></td>
                                        <?php
                                            $row = 1;
                                            if ($row < ($count_dept + 1)){
                                                foreach ($all_dept as $data) {
                                                    $check_name = trim($bgt->CHR_BUDGET_SUB_GROUP).trim($data->CHR_DEPT);
                                                    $cek_dept_author = $this->db->query("SELECT INT_ID_DEPT
                                                                                    FROM CPL.TT_MAPPING_AUTHORIZE_UPLOAD
                                                                                    WHERE INT_FLG_DELETE <> '1' AND INT_ID_BUDGET_SUB_GROUP = '$bgt->INT_ID_BUDGET_SUB_GROUP' AND INT_ID_DEPT = '$data->INT_ID_DEPT' AND INT_FLG_UPLOAD = 1")->num_rows();
                                        ?>
                                            <td style="text-align:center;"><input type="checkbox" class='icheck' id="checkbox" name="<?php echo $check_name; ?>" value="1"
                                        <?php
                                            if ($cek_dept_author > 0) {
                                                echo 'checked';
                                            }
                                        ?>
                                            ></td>
                                        <?php
                                                $row++;
                                                } 
                                            }
                                            $no++;
                                        }
                                        ?>                                   
                                    </tr>
                                </tbody>
                                
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        </form>
        </div>
    </section>
</aside>
<script src="<?php echo base_url('assets/js/jquery-1.12.3.js') ?>"></script>
<script src="<?php echo base_url('assets/js/jquery.dataTables.min.js') ?>"></script>
<script src="<?php echo base_url('assets/js/dataTables.fixedColumns.min.js') ?>"></script>
<link rel="stylesheet" href="<?php echo base_url('assets/css/fixedColumns.dataTables.min.css'); ?>" >
<script>
                                            $(document).ready(function() {
                                                var table = $('#example').DataTable({
                                                    scrollY: "350px",
                                                    scrollX: true,
                                                    scrollCollapse: true,
                                                    paging: false,
                                                    fixedColumns: {
                                                        leftColumns: 3,
                                                        rightColumns: 0
                                                    }
                                                });
                                            });
</script>

