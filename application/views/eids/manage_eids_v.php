<script src="<?php echo base_url('assets/js/jquery-1.12.3.js') ?>"></script>
<script src="<?php echo base_url('assets/js/jquery.dataTables.min.js') ?>"></script>
<script src="<?php echo base_url('assets/js/dataTables.fixedColumns.min.js') ?>"></script>
<link rel="stylesheet" href="<?php echo base_url('assets/css/fixedColumns.dataTables.min.css'); ?>" >
<script>
    $(document).ready(function () {
        var table = $('#example').DataTable({
            scrollY: "350px",
            scrollX: true,
            scrollCollapse: true,
            paging: true,
            fixedColumns: {
                leftColumns: 1
            }
        });
    });
</script>



<aside class="right-side">
    <section class="content-header">
        <ol class="breadcrumb">
            <li><a href="<?php echo base_url('index.php/basis/home_c/"') ?>"><span>Home</span></a></li>
            <li> <a href="#"><strong>Manage File EIDS</strong></a></li>
        </ol>
    </section>
    <script>
        setTimeout(function () {
            document.getElementById("hide-sub-menus").click();
        }, 10);
    </script>

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
                        <i class="fa fa-file"></i>
                        <span class="grid-title"><strong>FILE EIDS</strong></span>
                    </div>
                    <div class="grid-body">
                        <table id="filter">
                                <tr>
                                    <td width="10%">Document Type</td>
                                    <td width="20%">
                                        <select name="type" class="form-control" id="type" onChange="document.location.href = this.options[this.selectedIndex].value;">
                                            <?php foreach ($all_type as $row) { ?>
                                                <option value="<?php echo site_url('eids/eids_c/index/0/' . $row->doc_type); ?>" <?php
                                                if ($type == $row->doc_type) {
                                                    echo 'SELECTED';
                                                }
                                                ?> > <?php echo $row->doc_type; ?> </option>
                                                    <?php } ?>
                                        </select>
                                    </td>
                                    <td width="70%"></td>
                                </tr>
                        </table>
                        <div>&nbsp;</div>
                        <table id="example" class="table table-striped table-condensed table-hover display" cellspacing="0" style="width: 100%; font-size: 10px">
                            <thead>
                                <tr>
                                    <th>NO</th>
                                    <th>PRODUCT</th>
									<th>TYPE</th>
									<th>NO DOC.</th>
									<th>NO DOC.<br />CUSTOMER</th>
									<th>MODEL</th>
									<th>P/N AII</th>
									<th>P/N AII<br />ALTERNATIVE</th>
									<th>P/N CUSTOMER</th>
									<th>PART NAME</th>
									<th>REV</th>
									<th>STATUS</th>
									<th>ARRIVAL DATE</th>
									<th>INPUT DATE</th>
                                
                                    <th>Actions</th>

                                </tr>
                            </thead>
                            <tbody>
                            <?php
                                $i = 1;
                                foreach ($data as $isi) 
                                {
                                    echo "<tr class='gradeX'>";
                                    echo "<td>$i</td>";
                                    echo "<td>$isi->product</td>";
                                    echo "<td>$isi->doc_type</td>";
                                    echo "<td>$isi->no_dok</td>";
                                    echo "<td>$isi->no_dok_cus</td>";
                                    echo "<td>$isi->model</td>";
                                    echo "<td>$isi->part_num</td>";
                                    echo "<td>$isi->part_num_alt</td>";
                                    echo "<td>$isi->part_num_cus</td>";
                                    echo "<td>$isi->part_name</td>";
                                    echo "<td>$isi->rev</td>";
                                    echo "<td>$isi->status</td>";
                                    echo "<td>$isi->arrival_date</td>";
                                    echo "<td>$isi->input_date</td>";
                                    
								//	/* Download Cover File */
								//	if($isi->file_cover!="" && $isi->file_cover!=".zip")
								//	{
								//		echo ("<td align='center'><a href="."$dircoverfile"." name="."$id_doc"." onClick='myFunction(this.name)'>Download</a></td>");
								//	}
								//	else
								//	{
								//		echo "<td>-</td>";
                                //    }
                                
                                ?>
                                <td>
                                    <?php
                                    /* Download File */
									if($isi->file!="" && $isi->file!=".zip")
									{
                                        ?>
                                        <a href="<?php echo 'http://192.168.0.249/eng/eids' . "/" . $isi->file_dir; ?>" class="label label-warning" data-placement="top" data-toggle="tooltip" title="Download"><span class="fa fa-download"></span></a>
                                        
                                       <?
									}
                                    ?>
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