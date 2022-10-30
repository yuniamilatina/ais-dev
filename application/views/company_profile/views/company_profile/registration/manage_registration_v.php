<aside class="right-side">
    <section class="content-header">
        <ol class="breadcrumb">
            <li><a href="<?php echo base_url('index.php/basis/home_c/"') ?>"><span>Home</span></a></li>
            <li> <a href="#"><strong>Manage Registration</strong></a></li>
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
                        <span class="grid-title"><strong>REGISTRATION</strong> TABLE</span>
                        <div class="pull-right">
                            <!-- <a href="<?php echo base_url('index.php/company_profile/registration_c/create_registration/') ?>" class="btn btn-default" data-toggle="tooltip" data-placement="left" title="Create Registration" style="height:30px;font-size:13px;width:100px;">Create</a> -->
                        </div>
                    </div>
                    <div class="grid-body">
                        <?php echo $this->session->flashdata('email_sent'); ?>
                    
                    <!-- Export Excel -->
                    <?php echo form_open('company_profile/registration_c/exportExcel', 'class="form-horizontal"'); ?>
                        <div class="col-md-5">
                            Register Date : <input type="date" name="CHR_DATE_START" class="form-control">
                        </div>
                        <div class="col-md-5">
                            End : <input type="date" name="CHR_DATE_END" class="form-control">
                        </div>
                        <div class="col-md-2">
                            <br>
                            <button type="submit" class="btn btn-primary"><i class="fa fa-download"></i> Export To Excel</button>
                        </div>
                        <br><br><br><br>
                    <?php echo form_close(); ?>

                    <?php echo form_open('company_profile/registration_c/reject_accept_mail', 'class="form-horizontal"'); ?>
                        <table id="dataTables1" class="table table-striped table-condensed table-hover display" cellspacing="0" width="100%" style="table-layout:fixed;">
                            <thead>
                                <tr>
                                    <th>Name</th>
                                    <th>Date Of Birth</th>
                                    <th>Sex</th>
                                    <th>Email</th>
                                    <th>Phone or Mobile</th>
                                    <th>Vacancy</th>
                                    <th>Academic</th>
                                    <th>University</th>
                                    <th>Faculty</th>
                                    <th>Departement</th>
                                    <th>IPK</th>
                                    <th>Step</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                $i = 1;
                                foreach ($data as $isi) {
                                    echo "<tr class='gradeX'>";
                                    echo "<td style='white-space:pre-wrap ; word-wrap:break-word;'>$isi->CHR_NAME</td>";
                                    $tgl = $isi->CHR_DATE; 
                                    $date = date("Y-m-d", strtotime($tgl));
                                    echo "<td>$date</td>";
                                    echo "<td>$isi->CHR_SEX</td>";
                                    echo "<td style='white-space:pre-wrap ; word-wrap:break-word;'>$isi->CHR_EMAIL</td>";
                                    // echo "<td>$isi->CHR_ADDRESS_KTP</td>";
                                    echo "<td style='white-space:pre-wrap ; word-wrap:break-word;'>$isi->CHR_PHONE</td>";
                                    echo "<td style='white-space:pre-wrap ; word-wrap:break-word;'>$isi->CHR_VACANCY_NAME</td>";
                                    echo "<td style='white-space:pre-wrap ; word-wrap:break-word;'>$isi->CHR_FINAL_ACADEMIC</td>";
                                    echo "<td style='white-space:pre-wrap ; word-wrap:break-word;'>$isi->CHR_UNIVERSITY</td>";
                                    echo "<td style='white-space:pre-wrap ; word-wrap:break-word;'>$isi->CHR_FACULTY</td>";
                                    echo "<td style='white-space:pre-wrap ; word-wrap:break-word;'>$isi->CHR_DEPARTEMENT</td>";
                                    echo "<td style='white-space:pre-wrap ; word-wrap:break-word;'>$isi->DEC_IPK</td>";
                                    ?>
                                    
                                    <?php if ($isi->STEP == 5) {?>
                                    <td style='white-space:pre-wrap ; word-wrap:break-word;'></td>
                                    <td style='white-space:pre-wrap ; word-wrap:break-word;'>
                                        Accepted
                                    </td>
                                    <?php } else {
                                            if($isi->STEP == 1) {?>
                                                <td style='white-space:pre-wrap ; word-wrap:break-word;'><?php echo "Administration"; ?></td>
                                                <td style='white-space:pre-wrap ; word-wrap:break-word;'>
                                                    <input type="checkbox" name="check_list[]" value="<?php echo $isi->INT_ID_REG; ?>">
                                                </td>
                                    <?php } elseif ($isi->STEP == 2) { ?>
                                                <td style='white-space:pre-wrap ; word-wrap:break-word;'><?php echo "Psikotest"; ?></td>
                                                <td style='white-space:pre-wrap ; word-wrap:break-word;'>
                                                    <input type="checkbox" name="check_list[]" value="<?php echo $isi->INT_ID_REG; ?>">
                                                </td>
                                    <?php } elseif ($isi->STEP == 3) { ?>
                                                <td style='white-space:pre-wrap ; word-wrap:break-word;'><?php echo "Interview"; ?></td>
                                                <td style='white-space:pre-wrap ; word-wrap:break-word;'>
                                                    <input type="checkbox" name="check_list[]" value="<?php echo $isi->INT_ID_REG; ?>">
                                                </td>
                                    <?php } elseif ($isi->STEP == 4) { ?>
                                                <td style='white-space:pre-wrap ; word-wrap:break-word;'><?php echo "Medical Check Up"; ?></td>
                                                <td style='white-space:pre-wrap ; word-wrap:break-word;'>
                                                    <input type="checkbox" name="check_list[]" value="<?php echo $isi->INT_ID_REG; ?>">
                                                </td>
                                    <?php } 
                                    } ?>
                                </tr>
                                <?php
                                $i++;
                            }
                            ?>
                            </tbody>
                        </table>
                    <input type="submit" name="accept" value="Accept" class="btn btn-default" data-toggle="tooltip" data-placement="left" title="Accept" onclick="return confirm('Are you sure want to accept this applicant?');">
                    <input type="submit" name="reject" value="Reject" class="btn btn-default" data-toggle="tooltip" data-placement="left" title="Reject" onclick="return confirm('Are you sure want to reject this applicant?');">
                    <?php echo form_close(); ?>
                    <!-- <a href="<?php echo base_url('index.php/company_profile/registration_c/exportExcel') ?>" class="btn btn-default" data-toggle="tooltip" data-placement="left" title="Export Excel" style="height:30px;font-size:13px;width:100px;">Export Excel</a> -->
                    </div>
                </div>
            </div>
        </div>

    </section>
</aside>


