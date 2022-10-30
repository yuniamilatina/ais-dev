<aside class="right-side">
    <section class="content-header">
        <ol class="breadcrumb">
            <li><a href="<?php echo base_url('index.php/basis/home_c/"') ?>"><span>Home</span></a></li>
            <li> <a href="#"><strong>Manage Category Document</strong></a></li>
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
                        <span class="grid-title"><strong>CATEGORY DOCUMENT</strong> TABLE</span>
                        <div class="pull-right">
                            <a href="#modaladd" class="btn btn-default" data-toggle="modal" data-placement="left" title="Create Category Document" style="height:30px;font-size:13px;width:100px;">Create</a>
                        </div>
                    </div>
                    <div class="grid-body">
                        <table id="dataTables1" class="table table-striped table-condensed table-hover display" cellspacing="0" width="100%">
                            <thead>
                                <tr>
                                    <th>No</th>
                                    <th>Category Name</th>
                                    <th>Category Description</th>
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
                                    echo "<td style='white-space:pre-wrap ; word-wrap:break-word;'>".trim($isi->CHR_CATEGORY_DESC)."</td>";
                                    ?>
                                <td>
                                    <a data-toggle="modal" data-target="#modaledit<?php echo $isi->INT_ID_CATEGORY; ?>" data-placement="left" data-toggle="tooltip" title="Edit Category" class="label label-warning"><span class="fa fa-pencil"></span></a>
                                    <a href="<?php echo base_url('index.php/efila/category_doc_c/delete_category_doc') . "/" . $isi->INT_ID_CATEGORY; ?>" class="label label-danger" data-placement="top" data-toggle="tooltip" title="Delete" onclick="return confirm('Are you sure lwant to delete this category?');"><span class="fa fa-times"></span></a>
                                    
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

        <div class="modal fade" id="modaladd" tabindex="-1" role="dialog" aria-labelledby="modalprogress" aria-hidden="true" style="display: none;">
            <div class="modal-wrapper">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <button type="button" class="close" data-dismiss="modal" aria-hidden="true"><i class="fa fa-times"></i></button>
                            <h4 class="modal-title" id="modalprogress"><strong>Add Category Document</strong></h4>
                        </div>
                        <div class="modal-body">
                    <?php echo form_open('efila/category_doc_c/save_category_doc', 'class="form-horizontal"'); ?>

                            <div class="form-group">
                                <label class="col-sm-3 control-label">Category Document Name</label>
                                <div class="col-sm-5">
                                    <input name="CHR_CATEGORY_NAME" class="form-control" required type="text" required>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-sm-3 control-label">Category Document Description</label>
                                <div class="col-sm-5">
                                    <textarea name="CHR_CATEGORY_DESC" class="form-control">
                                    </textarea>
                                    <!-- <input name="CHR_CATEGORY_NAME" class="form-control" required type="text" required> -->
                                </div>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <div class="btn-group">
                                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                                <button type="submit" class="btn btn-primary" data-placement="left" data-toggle="tooltip" title="Save this data"><i class="fa fa-check"></i> Save</button>
                    <?php echo form_close(); ?>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

         <?php

                foreach ($data as $isi) {
                    ?>
                    <!--EDIT Vacancy-->
                    <div class="modal fade" id="modaledit<?php echo $isi->INT_ID_CATEGORY; ?>" tabindex="-1" role="dialog" aria-labelledby="modaledit" aria-hidden="true" style="display: none;">
                        <div class="modal-wrapper">
                            <div class="modal-dialog">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times</button>
                                        <h4 class="modal-title" id="modaledit"><strong>Edit Category</strong></h4>
                                    </div>
                                    <div class="modal-body">
                                    <?php echo form_open('efila/category_doc_c/update_category_doc', 'class="form-horizontal"'); ?>

                                        <input name="INT_ID_CATEGORY" class="form-control" required type="hidden" style="width: 300px;" value="<?php echo $isi->INT_ID_CATEGORY ?>">
                            
                                        <div class="form-group">
                                            <label class="col-sm-3 control-label">Category Description</label>
                                            <div class="col-sm-5">
                                                <textarea name="CHR_CATEGORY_DESC" class="form-control" required><?php echo trim($isi->CHR_CATEGORY_DESC); ?></textarea>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="modal-footer">
                                        <div class="btn-group">
                                            <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                                            <button type="submit" class="btn btn-primary" data-placement="left" data-toggle="tooltip" title="Save this data"><i class="fa fa-check"></i> Update</button>
                                    <?php echo form_close(); ?>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <?php
                    $i++;
                }
                ?>

    </section>
</aside>


