<aside class="right-side">

    <section class="content-header">
        <ol class="breadcrumb">
            <li><a href="<?php echo base_url('index.php/basis/home_c/'); ?>"><span>Home</span></a></li>
            <li><a href="#"><strong>Manage News & Event</strong></a></li>
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
                        <i class="fa fa-comments"></i>
                        <span class="grid-title"><strong>MANAGE NEWS & EVENT</strong></span>
                        <div class="pull-right">
                            <a href="<?php echo base_url('index.php/portal/news_c/create_news"') ?>" class="btn btn-default" data-toggle="tooltip" data-placement="left" title="Create Ticket" style="height:30px;font-size:13px;width:100px;">Create</a>
                        </div>
                    </div>

                    <div class="grid-body">

                        <table id="dataTables1" class="table table-striped table-condensed table-hover display" cellspacing="0" width="100%">
                            <thead>
                                <tr>
                                    <th>News Title</th>
                                    <th>Description</th>
                                    <th>Creator</th>
                                    <th>Date</th>
                                    <th>Time</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>

                            <tbody>
                                <?php
                                $i = 1;
                                foreach ($data as $isi) {
                                    echo "<tr class='gradeX'>";
                                    
                                    echo "<td>$isi->CHR_NEWS_TITLE</td>";
                                    echo "<td>".substr($isi->CHR_NEWS_DESC , 0, 100)."...</td>";
                                    echo "<td>$isi->CHR_CREATED_BY</td>";
                                    echo "<td>$isi->CHR_CREATED_DATE</td>";
                                    echo "<td>$isi->CHR_CREATED_TIME</td>";
                                ?>
                                <td>
                                    <a href="<?php echo base_url('index.php/portal/news_c/select_by_id') . "/" . $isi->INT_ID_NEWS; ?>" class="label label-success" data-placement="left" data-toggle="tooltip" title="View"><span class="fa fa-check"></span></a>
                                    <a href="<?php echo base_url('index.php/portal/news_c/edit_news') . "/" . $isi->INT_ID_NEWS; ?>" class="label label-warning" data-placement="top" data-toggle="tooltip" title="Edit"><span class="fa fa-pencil"></span></a>
                                    <a href="<?php echo base_url('index.php/portal/news_c/delete_news') . "/" . $isi->INT_ID_NEWS; ?>" class="label label-danger" data-placement="right" data-toggle="tooltip" title="Delete" onclick="return confirm('Are you sure want to delete this news?');"><span class="fa fa-times"></span></a>
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