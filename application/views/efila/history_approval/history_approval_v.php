<aside class="right-side">
    <section class="content-header">
        <ol class="breadcrumb">
            <li><a href="<?php echo base_url('index.php/basis/home_c/"') ?>"><span>Home</span></a></li>
            <li> <a href="#"><strong>History Approval</strong></a></li>
        </ol>
    </section>
    <!-- <script>
        setTimeout(function () {
            document.getElementById("hide-sub-menus").click();
        }, 10);
    </script> -->
    <section class="content">
        <?php if ($msg != NULL) {
            echo $msg;
        } ?>

        <div class="row">
            <div class="col-md-12">
                <div class="grid">
                    <div class="grid-header">
                        <i class="fa fa-sitemap"></i>
                        <span class="grid-title"><strong>HISTORY APPROVAL</strong> TABLE</span>
                        <div class="pull-right">
                            <!-- <a href="<?php echo base_url('index.php/efila/register_document_c/create_register_document/') ?>" class="btn btn-default" data-placement="left" title="Apply Register Document" style="height:30px;font-size:13px;width:auto;">New Register Document</a> -->
                        </div>
                    </div>
                    <div class="grid-body">
                        <table id="dataTables1" class="table table-striped table-condensed table-hover display" cellspacing="0" width="100%">
                            <thead>
                                <tr>
                                    <th>No</th>
                                    <th>Dept</th>
                                    <th>No Document</th>
                                    <th>Document Name</th>
                                    <th>Document Desc</th>
                                    <th>Category</th>
                                    <th>Revision</th>
                                    <th>Type</th>
                                    <th>Manager Approved</th>
                                    <th>GM Approved</th>
                                    <th>MSU Approved</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                $i = 1;
                                foreach ($data as $isi) {
                                    echo "<tr class='gradeX'>";
                                    echo "<td>$i</td>";
                                    echo "<td>$isi->CHR_DEPT</td>";
                                    echo "<td>$isi->CHR_NO_DOC</td>";
                                    echo "<td>$isi->CHR_DOCUMENT_NAME</td>";
                                    echo "<td>$isi->CHR_DOCUMENT_DESC</td>";
                                    echo "<td>$isi->CHR_CATEGORY_NAME</td>";
                                    echo "<td>$isi->INT_REVISION</td>";
                                    echo "<td>New Register</td>";
                                    $tgl = $isi->CHR_APPROVED_MANAGER_DATE; 
                                    $date = date("d-m-Y", strtotime($tgl));
                                    echo "<td>$date</td>";
                                    $tgl = $isi->CHR_APPROVED_GM_DATE; 
                                    $date = date("d-m-Y", strtotime($tgl));
                                    echo "<td>$date</td>";
                                    $tgl = $isi->CHR_APPROVED_MSU_DATE; 
                                    $date = date("d-m-Y", strtotime($tgl));
                                    echo "<td>$date</td>";
                                    $i++;
                                }
                                ?>
                                    
                                </tr>
                                <?php
                                foreach ($data1 as $isi1) {
                                    echo "<tr class='gradeX'>";
                                    echo "<td>$i</td>";
                                    echo "<td>$isi1->CHR_DEPT</td>";
                                    echo "<td>$isi1->CHR_NO_DOC</td>";
                                    echo "<td>$isi1->CHR_DOCUMENT_NAME</td>";
                                    echo "<td>$isi1->CHR_DOCUMENT_DESC</td>";
                                    echo "<td>$isi1->CHR_CATEGORY_NAME</td>";
                                    echo "<td>$isi1->INT_REVISION</td>";
                                    echo "<td>Revision</td>";
                                    $tgl = $isi1->CHR_APPROVED_MANAGER_DATE; 
                                    $date = date("d-m-Y", strtotime($tgl));
                                    echo "<td>$date</td>";
                                    $tgl = $isi1->CHR_APPROVED_GM_DATE; 
                                    $date = date("d-m-Y", strtotime($tgl));
                                    echo "<td>$date</td>";
                                    $tgl = $isi1->CHR_APPROVED_MSU_DATE; 
                                    $date = date("d-m-Y", strtotime($tgl));
                                    echo "<td>$date</td>";
                                    $i++;
                                }
                                    ?>
                                    
                                </tr>
                                <?php
                                foreach ($data2 as $isi2) {
                                    echo "<tr class='gradeX'>";
                                    echo "<td>$i</td>";
                                    echo "<td>$isi2->CHR_DEPT</td>";
                                    echo "<td>$isi2->CHR_NO_DOC</td>";
                                    echo "<td>$isi2->CHR_DOCUMENT_NAME</td>";
                                    echo "<td>$isi2->CHR_DOCUMENT_DESC</td>";
                                    echo "<td>$isi2->CHR_CATEGORY_NAME</td>";
                                    echo "<td>$isi2->INT_REVISION</td>";
                                    echo "<td>Obsolete</td>";
                                    $tgl = $isi2->CHR_APPROVED_MANAGER_DATE; 
                                    $date = date("d-m-Y", strtotime($tgl));
                                    echo "<td>$date</td>";
                                    echo "<td></td>";
                                    $tgl = $isi2->CHR_APPROVED_MSU_DATE; 
                                    $date = date("d-m-Y", strtotime($tgl));
                                    echo "<td>$date</td>";
                                    $i++;
                                }
                                    ?>
                                    
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </section>
</aside>
