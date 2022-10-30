
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
            <li><a href=""><strong>Master Data Employee</strong></a></li>
        </ol>
    </section>

    <section class="content">

        <div class="row">
            <div class="col-md-12">
                <div class="grid">
                    <div class="grid-header">
                        <i class="fa fa-th-large"></i>
                        <span class="grid-title"><strong> Master Data Employee </strong></span>

                        <div class="pull-right grid-tools">
                            <button class="btn btn-primary" data-toggle="modal" data-target="#modalPrimary">Update</button>
                            <a data-widget="collapse" title="Collapse"><i class="fa fa-chevron-up"></i></a>
                        </div>
                    </div>

                    <div class="grid-body">

                        <div id="table-luar">
                            <table id="dataTables3" class="table table-condensed table-striped table-hover display" cellspacing="0" width="100%">
                                <thead>
                                    <tr class='gradeX'>
                                        <th rowspan="1" style="vertical-align: middle">No</th>
                                        <th rowspan="1" style="vertical-align: middle">NPK</th>
                                        <th rowspan="1" style="vertical-align: middle">Nama</th>
                                        <th rowspan="1" style="vertical-align: middle">Kode Dept</th>                                        
                                        <th rowspan="1" style="vertical-align: middle">Kode Group</th>
                                        <th rowspan="1" style="vertical-align: middle">Kode Section</th>
                                        <th rowspan="1" style="vertical-align: middle">Kode Sub Section</th> 
                                        <th rowspan="1" style="vertical-align: middle">Position</th> 
                                        <th rowspan="1" style="vertical-align: middle">Tunjangan Jabatan</th> 
                                        <th rowspan="1" style="vertical-align: middle">Tunjangan Transport</th> 
                                        <th rowspan="1" style="vertical-align: middle">Salary</th> 
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    $r = 1;
                                    $session = $this->session->all_userdata();
                                    if (count($data_karyawan) > 0) {
                                        foreach ($data_karyawan as $isi) {
                                            echo "<tr class='gradeX'>";
                                            echo "<td style=text-align:center;>$r</td>";
                                            echo "<td style=vertical-align: top;text-align: center;>$isi->NPK</td>";
                                            echo "<td style=vertical-align: top;text-align: left;>$isi->NAMA</td>";
                                            echo "<td style=text-align:center;>$isi->KD_DEPT</td>";
                                            echo "<td style=text-align:center;>$isi->KD_GROUP</td>";
                                            echo "<td style=text-align:center;>$isi->KD_SECTION</td>";
                                            echo "<td style=text-align:center;>$isi->KD_SUB_SECTION</td>";
                                            echo "<td style=text-align:center;>$isi->position</td>";
                                            echo "<td style=text-align:center;>$isi->tunj_jabatan</td>";
                                            echo "<td style=text-align:center;>$isi->tunj_transport</td>";
                                            echo "<td style=text-align:center;>$isi->salary</td>";
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
                        <form class="form-horizontal" method="post"  role="form" action="<?php echo base_url('index.php/aorta/master_data_c/upload_template_employee'); ?>"  enctype="multipart/form-data" role="form">
                            <div class="modal-header">
                                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                                <h4 class="modal-title" id="myModalLabel2" >Upload Master Data Emplyoee</h4>
                            </div>
                            <div class="modal-body" >
                                <div class="form-group" style="text-align:center;">
                                    <span style="text-align:center;"><a href="<?php echo base_url('index.php/aorta/master_data_c/generate_template/' . $kode_dept); ?>">Download Template Master Data</a></span>
                                </div>
                                <div class="form-group">
                                    <label class="col-sm-3 control-label">Input File</label>
                                    <div class="col-sm-7">
                                        <input type="file" class="form-control" name="import_salary" id="import_salary" size="20" value="">
                                    </div>
                                </div>
                            </div>
                            <div class="modal-footer">
                                <div class="btn-group">
                                    <button type="button" class="btn btn-default" data-dismiss="modal"> Close</button>
                                    <button class="btn btn-primary" value="1" name="upload_button"> Upload</button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>



    </section>
</aside>

