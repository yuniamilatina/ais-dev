<style type="text/css">
    #circle {
      width: 20px;
      height: 20px;
      -webkit-border-radius: 25px;
      -moz-border-radius: 25px;
      border-radius: 25px;
      background: yellow;
    }
    /*.example {
      width: 6000px;
    }*/
    /*table{
      margin: 0     ;
      width: 100%;
      clear: both;
      border-collapse: collapse;
      table-layout: auto; // ***********add this
      word-wrap:break-word; // ***********and this
    }*/
</style>
<aside class="right-side">
    <script>
        setTimeout(function () {
            document.getElementById("hide-sub-menus").click();
        }, 10);
    </script>
    <section class="content-header">
        <ol class="breadcrumb">
            <li><a href="<?php echo base_url('index.php/basis/home_c/"') ?>"><span>Home</span></a></li>
            <li> <a href="#"><strong>Manage Document</strong></a></li>
        </ol>
    </section>

    <section class="content">
        <div class="row">
            <div class="col-md-12">
                <div class="grid">
                    <div class="grid-header">
                        <i class="fa fa-th-large"></i>
                        <span class="grid-title"> <strong>MASTER LIST DOCUMENT</strong></span>
                        <div class="pull-right grid-tools">
                        <?php
                            //--- Specially for Function Download List Document
                            if($iddept == '' || $iddept == NULL){
                                $iddept_new = "a";
                            } else {
                                $iddept_new = $iddept;
                            }

                            //--- Specially for Function Download List Document
                            if($idcat == '' || $idcat == NULL){
                                $idcat_new = "a";
                            } else {
                                $idcat_new = $idcat;
                            }
                        ?>
                        <a href="<?php echo base_url('index.php/efila/document_c/export_master_list') . "/" . $iddept_new . "/" . $idcat_new; ?>" class="btn btn-primary" style="color:white;"><i class="fa fa-download"></i>&nbsp; Download List</a>
                            <a data-widget="collapse" data-toggle="tooltip"  title="Collapse">                            
                                <i class="fa fa-chevron-up"></i>
                            </a>
                        </div>
                    </div>
                    <div class="grid-body">
                        <div class="pull">
                            <?php echo form_open('efila/document_c/filter_category', 'class="form-inline"'); ?>
                            <table width="100%">
                                <tr>
                                    <td>Category</td>
                                    <td>
                                        <select name="INT_ID_CATEGORY" class="form-control">
                                            <?php  
                                            if($idcat == NULL) {
                                            ?>
                                                <option selected disabled>--Choose Category--</option>
                                            <?php
                                                foreach ($cat as $key) {
                                            ?>
                                                <option value="<?php echo $key->INT_ID_CATEGORY ?>"><?php echo $key->CHR_CATEGORY_NAME; ?></option>
                                            <?php
                                                }
                                            } else {
                                            ?>
                                                <option disabled>--Choose Category--</option>
                                            <?php
                                                foreach ($cat as $key) {
                                                    if($key->INT_ID_CATEGORY == $idcat){
                                            ?>
                                                    <option value="<?php echo $key->INT_ID_CATEGORY ?>" selected><?php echo $key->CHR_CATEGORY_NAME; ?></option>
                                            <?php
                                                    } else {
                                            ?>
                                                    <option value="<?php echo $key->INT_ID_CATEGORY ?>"><?php echo $key->CHR_CATEGORY_NAME; ?></option>
                                            <?php
                                                    }
                                                }
                                            }
                                            ?>
                                        </select>
                                    </td>
                                    <td>Department</td>
                                    <td width="30%">
                                        <select name="INT_ID_DEPT" id="e2" class="form-control" style="width: 200px">
                                            <?php  
                                            if($iddept == NULL) {
                                            ?>
                                                <option value="" selected>--Choose Department--</option>
                                            <?php
                                                foreach ($dept as $key) {
                                            ?>
                                                <option value="<?php echo $key->INT_ID_DEPT ?>"><?php echo $key->CHR_DEPT; ?></option>
                                            <?php
                                                }
                                            } else {
                                            ?>
                                            <option disabled>--Choose Department--</option>
                                            <?php
                                                foreach ($dept as $key) {
                                                    if($key->INT_ID_DEPT == $iddept){
                                            ?>
                                                    <option value="<?php echo $key->INT_ID_DEPT ?>" selected><?php echo $key->CHR_DEPT; ?></option>
                                            <?php
                                                    } else {
                                            ?>
                                                    <option value="<?php echo $key->INT_ID_DEPT ?>"><?php echo $key->CHR_DEPT; ?></option>
                                            <?php
                                                    }
                                                }
                                            }
                                            ?>
                                        </select>
                                    </td>
                                    <td><button type="submit" class="btn btn-primary" name="set"><i class="fa fa-check"></i> Set</button>
                                        <a href="<?php echo base_url('index.php/efila/document_c') ?>" class="btn btn-default">Clear</a>
                                        <?php if($this->session->userdata("ROLE") == 20){
                                        ?>
                                        <button type="submit" class="btn btn-primary" name="export"><i class="fa fa-download"></i> Export To Excel</button>
                                        <?php
                                        } ?>
                                        
                                    </td>
                                </tr>
                            </table>
                            <?php echo form_close(); ?>
                        </div>
                        <br>
                        <table id="dataTables1" class="table table-condensed table-striped table-hover display" cellspacing="0" width="100%">
                            <thead>
                                <tr class='gradeX'>
                                    <th rowspan="2">Dept</th>
                                    <th rowspan="2">Doc No</th>
                                    <th rowspan="2">Doc Name</th>
                                    <th rowspan="2">Doc Category</th>
                                    <th rowspan="2">Rev</th>
                                    <th rowspan="2">PIC</th>
                                    <th rowspan="2">Effective Date</th>
                                    <th rowspan="2">Doc</th>
                                    <!-- <th>Dept</th>
                                    <th>Doc No</th>
                                    <th>Doc Name</th>
                                    <th>Doc Category</th>
                                    <th>Rev</th>
                                    <th>PIC</th>
                                    <th>Effective Date</th>
                                    <th>Document</th>-->
                                    <th colspan="30" style="text-align: center;">Distribution</th>
                                </tr>
                                <tr>
                                    <?php  
                                        foreach ($dept as $key) {
                                            echo "<th>". $key->CHR_DEPT ."</th>";
                                        }
                                    ?>
                                </tr>

                            </thead>
                            
                            <tbody>
                                <?php
                                $i = 1;
                                $j = 0;
                                $k = 0;
                                foreach ($data as $isi) { 
                                    $id = $isi['INT_ID_DOCUMENT'];
                                    ?>
                                    <tr class='gradeX'>
                                        <td><?php echo $isi['CHR_DEPT']; ?></td>
                                        <td><?php echo $isi['CHR_NO_DOC']; ?></td>
                                        <td><?php echo $isi['CHR_DOCUMENT_NAME']; ?></td>
                                        <td><?php echo $isi['CHR_CATEGORY_NAME']; ?></td>
                                        <td><?php echo $isi['INT_REVISION']; ?></td>
                                        <td><?php echo $isi['CHR_PIC']; ?></td>
                                        <?php
                                        $tgl = $isi['CHR_EFFECTIVE_DATE']; 
                                        $date = date("d-m-Y", strtotime($tgl));
                                        ?>
                                        <td><?php echo $date; ?></td>
                                        <?php $doc = $isi['CHR_DOC']; ?>
                                        <td><a target="_blank" href="<?php echo base_url('index.php/efila/document_c/view_doc') . "/" . $doc; ?>"><i class="fa fa-download"></i></a></td>
                                    <?php 
                                    $query = $this->db->query("SELECT DOC.INT_ID_DOCUMENT, D.INT_ID_DEPT FROM MSU.TT_REGIST_DISTRIBUTION D JOIN MSU.TT_REGISTER_DOC R ON D.INT_ID_REGISTER = R.INT_ID_REGISTER JOIN MSU.TM_DOCUMENT DOC ON R.INT_ID_DOC = DOC.INT_ID_DOCUMENT WHERE DOC.INT_STATUS_APPROVED = 1 AND DOC.INT_ID_DOCUMENT = $id");
                                    // foreach ($query->result() as $key) {
                                    //     foreach ($dept as $de) {
                                    //         if($key->INT_ID_DEPT == $de->INT_ID_DEPT){
                                    //             echo "<td><div id=\"circle\"></div></td>";
                                    //             break;
                                    //         } else {
                                    //             echo "<td>-</td>";
                                    //         }  
                                    //     }        
                                    // }

                                    
                                    foreach ($dept as $key) {
                                        $dep = $key->INT_ID_DEPT;
                                        foreach ($query->result() as $dis) {
                                            if($dis->INT_ID_DEPT == $dep) {
                                                echo "<td><div id=\"circle\"></div></td>";
                                                $j = 0;
                                                break;
                                            } 
                                            else {
                                                $j++;
                                            } 
                                        }
                                        if($j != 0) {
                                            echo "<td>-</td>";
                                        }
                                    }
                                    ?>
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
        <script src="<?php echo base_url('assets/js/jquery-1.12.3.js') ?>"></script>
        <script src="<?php echo base_url('assets/js/jquery.dataTables.min.js') ?>"></script>
        <script src="<?php echo base_url('assets/js/dataTables.fixedColumns.min.js') ?>"></script>
        <script>
            $(document).ready(function() {
                $('#dataTables1').DataTable( {
                    scrollX:        true,
                    scrollCollapse: true,
                    autoWidth: false,
                    // columnDefs: [
                    //     { width: 10%, targets: 0,1,2,3,4,5,6,7 }
                    // ],
                    fixedColumns:   {
                        leftColumns: 8
                    }
                } );
            } );
        </script>
 
    </section>
</aside>
