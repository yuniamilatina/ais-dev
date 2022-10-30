<aside class="right-side">
    <section class="content-header">
        <ol class="breadcrumb">
            <li><a href="<?php echo base_url('index.php/basis/home_c/"') ?>"><span>Home</span></a></li>
            <li><a href="<?php echo base_url('index.php/efila/approval_msu_c/') ?>">List Section</a></li>
            <li><a href="#"><strong>List Document</strong></a></li>
        </ol>
    </section>

    <section class="content">

        <div class="row">
            <div class="col-md-12">
                <div class="grid">
                    <div class="grid-header">
                        <i class="fa fa-sitemap"></i>
                        <span class="grid-title"><strong>DOCUMENT</strong> TABLE</span>
                        <div class="pull-right">
                        </div>
                    </div>
                    <div class="grid-body">
                        <table id="dataTables1" class="table table-striped table-condensed table-hover display" cellspacing="0" width="100%">
                            <thead>
                                <tr>
                                    <th>No</th>
                                    <th>Document Name</th>
                                    <th>Document Description</th>
                                    <th>Category Name</th>
                                    <th>Document</th>
                                    <th>Created By</th>
                                    <!-- <th>Action</th> -->
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                $i = 1;
                                foreach ($data as $isi) {
                                    echo "<tr class='gradeX'>";
                                    echo "<td>$i</td>";
                                    echo "<td>$isi->DOC_NAME</td>";
                                    echo "<td>$isi->DOC_DESC</td>";
                                    echo "<td>$isi->CAT_NAME</td>"; ?>
                                    <td><a href="<?php echo base_url()."/assets/Document/".$isi->DOC; ?>"><?php echo $isi->DOC; ?></a></td>
                                    <?php
                                    echo "<td>$isi->CREA_BY</td>";
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

    </section>
</aside>


