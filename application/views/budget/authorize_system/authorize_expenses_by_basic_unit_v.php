
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
            <li><a href=""><strong>Authorized Expenses by Basic Unit</strong></a></li>
        </ol>
    </section>

    <section class="content">
        <div class="form-group">
            <form name="authorized_system" action="authorized_basic_unit" method="post" >
        <div class="row">
            <div class="col-md-12">
                <div class="grid">
                    <div class="grid-header">
                        <i class="fa fa-th-large"></i>
                        <span class="grid-title"><strong> Authorized Expenses by Basic Unit </strong></span>
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
                                        <!--<th style="vertical-align: middle; text-align: center">Form Type</th>-->
                                        <th style="vertical-align: middle; text-align: center">Transaction Menu Basic Unit</th>
                                        <?php
                                        $index = 1;
                                        $index_gm = 1;
                                        $count_dept = count($all_dept);
                                        $count_gm = count($all_gm);
                                        
                                        if($index < ($count_dept+1)){
                                            foreach($all_dept as $data){
                                                echo "<th style='vertical-align: middle; text-align: center'>$data->CHR_KODE_DEPARTMENT</th>";                                                
                                            }                                        
                                        }
                                        $index++;
                                        
                                        if ($index_gm < ($count_gm + 1)) {
                                                    foreach ($all_gm as $data) {
                                                        echo "<th style='vertical-align: middle; text-align: center'>$data->CHR_USERID</th>";
                                                    }
                                        }
                                        $index_gm++;
                                        ?>
                                        
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr class='gradeX'>
                                    <?php
                                    $row = 1;
                                    $session = $this->session->all_userdata();
                                    $abusdb = $this->load->database("abus", TRUE);
                                    $active_dept = array();
                                    $index_array = -1;
                                    if (count($trans_menu) > 0) {
                                        foreach ($trans_menu as $isi) {
                                                $modul = trim($isi->CHR_KODE_MODUL);
                                                $sub_modul = trim($isi->CHR_KODE_SUBMODUL);
                                                $form_menu = trim($isi->CHR_FORM_MENU);
                                                echo "<td style=text-align:center;>$row</td>";
                                                //echo "<td style=text-align:left;>$isi->MENU_TYPE</td>";
                                                echo "<td style=text-align:left;>$isi->CHR_FORM_MENU_DESCRIPTION</td>";
                                                $index = 1;
                                                $count_dept = count($all_dept);
                                                $index_gm = 1;
                                                $count_gm = count($all_gm);
                                                if ($index < ($count_dept+1)){
                                                    foreach($all_dept as $data){
                                                        $dept = trim($data->CHR_KODE_DEPARTMENT);
                                                        $dept_ori = $dept;
                                                        if ($dept == 'BD1'){
                                                            $dept = 'BOD001';
                                                        } else if ($dept == 'BD2'){
                                                            $dept = 'BOD002';
                                                        } else if ($dept == 'BD3') {
                                                            $dept = 'BOD003';
                                                        } else if ($dept == 'EXM') {
                                                            $dept = 'IMP';
                                                        }
                                                        $cek_user_author = $abusdb->query("SELECT [CHR_KODE_MODUL]
                                                                                                ,[CHR_KODE_SUBMODUL]
                                                                                                ,[CHR_FORM_MENU]
                                                                                                ,[CHR_USERID]
                                                                                                ,[CHR_FLG_DELETE]
                                                                                            FROM [ABUS_TM_USER_AUTHORIZE]
                                                                                            WHERE [CHR_FLG_DELETE] <> 1 
                                                                                                  AND ([CHR_USERID] LIKE '$dept%' OR [CHR_USERID] LIKE '%$dept' OR [CHR_USERID] LIKE '%$dept_ori') 
                                                                                                  AND (CHR_KODE_SUBMODUL = '$sub_modul' AND CHR_FORM_MENU = '$form_menu')")->num_rows();
                                                        //print_r($cek_user_author);
                                                        //echo '</br>';
                                                        ?>
                                                            <td style="text-align:center;"><input type="checkbox" class="icheck" name="<?php echo $form_menu.$dept ?>" value="1"
                                                        <?php
                                                            if($cek_user_author > 0){
                                                                $index_array = $index_array + 1;
                                                                $active_dept[] = $dept_ori;
                                                                echo 'checked';
                                                            }
                                                        ?>
                                                            ></td> 
                                                    <?php
                                                    }
                                                }
                                                $index++; 
                                                
                                                if ($index_gm < ($count_gm + 1)) {
                                                        foreach ($all_gm as $data) {
                                                            $gm = trim($data->CHR_USERID);
                                                            $cek_gm_author = $abusdb->query("SELECT [CHR_KODE_MODUL]
                                                                                            ,[CHR_KODE_SUBMODUL]
                                                                                            ,[CHR_FORM_MENU]
                                                                                            ,[CHR_USERID]
                                                                                            ,[CHR_FLG_DELETE]
                                                                                        FROM [ABUS_TM_USER_AUTHORIZE]
                                                                                        WHERE [CHR_FLG_DELETE] <> 1 
                                                                                              AND CHR_KODE_MODUL = '$modul' 
                                                                                              AND [CHR_USERID] = '$gm' 
                                                                                              AND (CHR_KODE_SUBMODUL = '$sub_modul' AND CHR_FORM_MENU LIKE '$form_menu%')")->num_rows();
                                                    ?>
                                                    <td style="text-align:center;"><input type="checkbox" class='icheck' id="checkbox" name="<?php echo $form_menu.$gm ?>" value="1"
                                                    <?php
                                                        if ($cek_gm_author > 0) {
                                                            echo 'checked';
                                                        }
                                                    ?>
                                                    ></td>
                                                    <?php
                                                }
                                            }
                                            $index_gm++;
                                            ?>
                                            </tr>
                                            <?php
                                            $row++;
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
                                                        leftColumns: 2,
                                                        rightColumns: 0
                                                    }
                                                });
                                            });
</script>

