<script type="text/javascript">
    function PreviewImage(no) {
        var oFReader = new FileReader();
        oFReader.readAsDataURL(document.getElementById("uploadImage"+no).files[0]);

        oFReader.onload = function (oFRProduct) {
            document.getElementById("uploadPreview"+no).src = oFRProduct.target.result;
            document.getElementById("uploadPreview"+no).height = 100;
            document.getElementById("uploadPreview"+no).width = 100;
        };
    }
</script>

<aside class="right-side">
    <section class="content-header">
        <ol class="breadcrumb">
            <li><a href="<?php echo base_url('index.php/basis/home_c/') ?>">Home</a></li>
            <li><a href="<?php echo base_url('index.php/company_profile/product_c/') ?>">Manage product</a></li>
            <li><a href="#"><strong>Edit Product</strong></a></li>
        </ol>
    </section>

    <section class="content">
        <?php
        if (validation_errors()) {
            echo '<div class = "alert alert-danger"><strong>WARNING !</strong>' . validation_errors() . '</div >';
        }
        echo form_open_multipart('company_profile/product_c/update_product', 'class="form-horizontal"');
        ?>
        <div class="row">
            <div class="col-md-12">
                <div class="grid">
                    <div class="grid-header">
                        <i class="fa fa-sitemap"></i>
                        <span class="grid-title"><strong>EDIT</strong> PRODUCT</span>
                        <div class="pull-right grid-tools">
                            <a data-widget="collapse" title="Collapse"><i class="fa fa-chevron-up"></i></a>
                        </div>
                    </div>
                    <div class="grid-body">
                        <input type="hidden" name="INT_ID_PRODUCT" class="form-control" value="<?php echo $data->INT_ID_PRODUCT; ?>">

                        <div class="form-group">
                            <label class="col-sm-3 control-label">Product Name</label>
                            <div class="col-sm-5">
                                <input name="CHR_PRODUCT_NAME" class="form-control" value="<?php echo $data->CHR_PRODUCT_NAME; ?>" required type="text">
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-3 control-label">Product Category</label>
                            <div class="col-sm-5">
                                <select name="INT_ID_CATEGORY" class="form-control" required>
                                    <?php
                                        foreach ($ddl as $isi) {
                                    ?>
                                            <option value="<?php echo $isi->INT_ID_CATEGORY ?>" <?php if($isi->INT_ID_CATEGORY == $data->INT_ID_CATEGORY){ echo "selected";} ?>><?php echo $isi->CHR_CATEGORY_NAME; ?></option>        
                                    <?php
                                        }
                                    ?>
                                </select>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-3 control-label">Product Description</label>
                            <div class="col-sm-5">
                                <textarea name="CHR_PRODUCT_DESC" class="form-control" required><?php echo $data->CHR_PRODUCT_DESC; ?></textarea>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-3 control-label">Product Photo</label>
                            <div class="col-sm-5">
                                <img id="uploadPreview1" src="<?php echo base_url()."assets/img/product/".$data->CHR_PRODUCT_PHOTO; ?>" class="form-control" style="width: 150px; height: 150px; border: 5px solid #a1a1a1;">
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-3 control-label"></label>
                            <div class="col-sm-5">
                                <input name="uploadFoto" id="uploadImage1" onchange="PreviewImage(1);" type="file">
                            </div>
                        </div>
                        <input type="hidden" name="CHR_PRODUCT_PHOTO_OLD" class="form-control" value="<?php echo $data->CHR_PRODUCT_PHOTO; ?>">
                        <div class="form-group">
                            <div class="col-sm-offset-3 col-sm-5">
                                <div class="btn-group">
                                    <button type="submit" class="btn btn-primary"><i class="fa fa-check"></i> Update</button>
                                    <?php echo anchor('company_profile/product_c', 'Cancel', 'class="btn btn-default"');
                                    echo form_close();
                                    ?>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <script type="text/javascript" language="javascript">
            $("#uploadImage").fileinput({
                'showUpload': false
            });
        </script>
    </section>
</aside>

