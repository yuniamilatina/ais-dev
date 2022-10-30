<?php
  $this->load->library('session');
  $this->load->helper('cookie');
  if(!isset($_SESSION['name']))
  {
    session_start();
  }
?>
<aside class="right-side">
    <section class="content-header">
        <ol class="breadcrumb">
            <li><a href="<?php echo base_url('index.php/basis/home_c/"') ?>"><span>Home</span></a></li>
            <li> <a href="#"><strong>Manage News</strong></a></li>
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
                        <span class="grid-title"><strong>NEWS</strong> TABLE</span>
                        <div class="pull-right">
                            <a href="<?php echo base_url('index.php/company_profile/cp_news_c/create_news/') ?>" class="btn btn-default" data-toggle="tooltip" data-placement="left" title="Create News" style="height:30px;font-size:13px;width:100px;">Create</a>
                        </div>
                    </div>
                    <div class="grid-body">
                        <table id="dataTables1" class="table table-striped table-condensed table-hover display" cellspacing="0" width="100%">
                            <thead>
                                <tr>
                                    <th>No</th>
                                    <th>News Title</th>
                                    <th>News Detail</th>
									<th>Creator</th>
                                    <th>Date</th>
                                    <th>News Photo</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                $i = 1;
                                foreach ($data as $isi) {
									//$lines=explode("\n", $isi->CHR_NEWS_DETAIL);
                                    echo "<tr class='gradeX'>";
                                    echo "<td>$i</td>";
                                    echo "<td>$isi->CHR_NEWS_TITLE</td>";
                                    echo "<td>".$isi->CHR_NEWS_DETAIL."</td>";
                                    $tgl = $isi->CHR_CREATED_DATE; 
                                    $date = date("Y-m-d", strtotime($tgl));
									echo "<td>$isi->CHR_CREATED_BY</td>";
                                    echo "<td>$date</td>";
                                    echo "<td><img src=\"".DOCIMG."/image/cp_news/".$isi->CHR_NEWS_PHOTO."\" height=\"200px\" width=\"250px\"></td>";
                                    ?>
                                <td>
                                    <a href="<?php echo base_url('index.php/company_profile/cp_news_c/edit_news') . "/" . $isi->INT_ID_NEWS; ?>" class="label label-warning" data-placement="top" data-toggle="tooltip" title="Edit"><span class="fa fa-pencil"></span></a><br> <br>
                                    <a href="<?php echo base_url('index.php/company_profile/cp_news_c/delete_news') . "/" . $isi->INT_ID_NEWS; ?>" class="label label-danger" data-placement="top" data-toggle="tooltip" title="Delete" onclick="return confirm('Are you sure want to delete this news?');"><span class="fa fa-times"></span></a>
                                    
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


