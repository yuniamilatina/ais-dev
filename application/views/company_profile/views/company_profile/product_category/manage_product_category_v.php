<aside class="right-side">
    <section class="content-header">
        <ol class="breadcrumb">
            <li><a href="<?php echo base_url('index.php/basis/home_c/"') ?>"><span>Home</span></a></li>
            <li> <a href="#"><strong>Manage Product Category</strong></a></li>
        </ol>
    </section>

    <section class="content">
        <?php if ($msg != NULL) {
            echo $msg;
        } ?>

        <div class="row">
            <div class="col-md-12">
                <div class="grid">
                    <div class="grid-header">
                        <i class="fa fa-sitemap"></i>
                        <span class="grid-title"><strong>PRODUCT CATEGORY</strong> TABLE</span>
                        <div class="pull-right">
                            <a href="<?php echo base_url('index.php/company_profile/product_category_c/create_product_category/') ?>" class="btn btn-default" data-toggle="tooltip" data-placement="left" title="Create Product Category" style="height:30px;font-size:13px;width:100px;">Create</a>
                        </div>
                    </div>
                    <div class="grid-body">
                        <table id="dataTables1" class="table table-striped table-condensed table-hover display" cellspacing="0" width="100%">
                            <thead>
                                <tr>
                                    <th>No</th>
                                    <th>Product Category Name</th>
                                    <th>Product Category Photo</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                $i = 1;
                                foreach ($data as $isi) {
                                    echo "<tr class='gradeX'>";
                                    echo "<td>$i</td>";
                                    echo "<td>$isi->CHR_CATEGORY_NAME</td>";
                                    echo "<td><img src=\"".base_url()."assets/img/category/".$isi->CHR_CATEGORY_PHOTO."\" height=\"200px\" width=\"250px\"></td>";
                                    // echo "<td>$isi->CHR_CATEGORY_PHOTO</td>";
                                    ?>
                                <td>
                                    <a href="<?php echo base_url('index.php/company_profile/product_category_c/edit_product_category') . "/" . $isi->INT_ID_CATEGORY; ?>" class="label label-warning" data-placement="top" data-toggle="tooltip" title="Edit"><span class="fa fa-pencil"></span></a>
                                    <a href="<?php echo base_url('index.php/company_profile/product_category_c/delete_product_category') . "/" . $isi->INT_ID_CATEGORY; ?>" class="label label-danger" data-placement="top" data-toggle="tooltip" title="Delete" onclick="return confirm('Are you sure want to delete this product category?');"><span class="fa fa-times"></span></a>
                                    
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

    </section>
</aside>


