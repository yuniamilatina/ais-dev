

<aside class="right-side">
    <section class="content-header">
        <ol class="breadcrumb">
            <li><a href="<?php echo base_url('index.php/eci/category_c/') ?>"><span>Home</span></a></li>
            <li> <a href="#"><strong>View Absen</strong></a></li>
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
                        <i class="fa fa-th-large"></i>
                        <span class="grid-title"><strong>VIEW</strong> ABSEN</span>
                        <div class="pull-right">
                            <!--a href="<?php echo base_url('index.php/eci/category_c/create_category/') ?>"  class="btn btn-default" data-placement="left" data-toggle="tooltip" title="Create ECI Category" style="height:30px;font-size:13px;width:100px;">Create</a-->
                            <input name="CHR_DATE" id="datepicker" class="form-control" required type="text" readonly style="width: 140px;text-transform: uppercase;" >
                        </div>
                    </div>
                    <div class="grid-body">
                        <table id="example" class="table table-striped table-condensed table-hover display" cellspacing="0" width="100%">
                            <thead>
                                <tr>
                                    <th>Date</th>
                                    <th>Cust Code</th>
                                    <th>Cust Dest Code</th>
                                    <th>Cycle</th>
                                    <th>Cust Name</th>
                                    <th>Cust Dest</th>
                                    <th>Arrival Plan</th>
                                    <th>Arrival Act</th>
                                    <th>Departure Plan</th>
                                    <th>Departure Act</th>
                                    <!--th>Actions</th-->
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                $i = 1;
                                foreach ($data as $isi) {
                                    //echo "<tr class='gradeX'>";
                                    echo "<tr id=\"row_activity_$isi->CHR_DATE\">";
                                    echo "<td>$isi->CHR_DATE</td>";
                                    echo "<td>$isi->CHR_CUST_CODE</td>";
                                    echo "<td>$isi->CHR_CUST_DEST_CODE</td>";
                                    echo "<td>$isi->CHR_CYCLE</td>";
                                    echo "<td>$isi->CHR_CUST_NAME</td>";
                                    echo "<td>$isi->CHR_CUST_DEST</td>";
                                    echo "<td>$isi->CHR_ARRIVAL_PLAN</td>";
                                    echo "<td>$isi->CHR_ARRIVAL_ACT</td>";
                                    echo "<td>$isi->CHR_DEPARTURE_PLAN</td>";
                                    echo "<td>$isi->CHR_DEPARTURE_ACT</td>";

                                    ?>
 
                                </tr>
                                <?php
                                $i++;
                            }
                            ?>
                            </tbody>
                        </table>
                        <br /><br />
                    </div>
                </div>
            </div>
            
        </div>

    </section>
</aside>