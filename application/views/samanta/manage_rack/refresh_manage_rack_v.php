<style type="text/css">
    th, td { white-space: nowrap; }
    div.dataTables_wrapper {
        margin: 0 auto;
    }
    #table-luar{
        font-size: 11px;
    }
    #filter { 
        border-spacing: 10px;
        border-collapse: separate;
    }
    .td-fixed{
        width: 30px;
    }
    .td-no{
        width: 10px;
    }
    .ddl{
        width: 100px;
        height: 30px;
    }
    .ddl2{
        width: 180px;
        height: 30px;
    }
</style>
<table id="example2" class="table table-striped table-condensed table-hover display" cellspacing="0" width="100%">
    <thead>
        <tr>
            <th class="sorting_disabled" style="vertical-align: middle;text-align:center;"><input type="checkbox" id="flowcheckall" onchange="cekALL()" value=""></th>
            <th style="vertical-align: middle;text-align:center;">No</th>
            <th style="vertical-align: middle;text-align:center;">Part No</th>
            <th style="vertical-align: middle;text-align:center;">Address</th>
            <th style="vertical-align: middle;text-align:center;">Back No</th>
            <th style="vertical-align: middle;text-align:center;">Specification</th>
            <th style="vertical-align: middle;text-align:center;">Action</th>
        </tr>
    </thead>
    <tbody>
        <?php
        $i = 1;
        foreach ($data_filter as $dataRefresh) {
            echo "<tr class='gradeX'>"; ?>
            <td style=text-align:center;><input class="icheckbox" type="checkbox" name="options2[]" onclick="checkAddress(this)" id="options<?php echo $i; ?>" value="<?php echo trim($dataRefresh->INT_ID) ?>"></td>
            <?php
                echo "<td style=text-align:center;>$i</td>";
                echo "<td style=text-align:center;>$dataRefresh->CHR_PART_NO</td>";
                echo "<td style=text-align:center;>$dataRefresh->CHR_RACK_NO</td>";
                echo "<td style=text-align:center;>$dataRefresh->CHR_BACK_NO</td>";
                echo "<td style=text-align:left;>$dataRefresh->CHR_SPECIFICATION</td>";
            ?>
            <td style="vertical-align: middle;text-align:center;">
                <a onclick="window.top.location.href = '<?php echo base_url('index.php/samanta/spare_parts_rack_c_2/goto_edit_rack') . "/" . $dataRefresh->INT_ID; ?>'" class="label label-info" data-placement="top" data-toggle="tooltip" title="Edit"><span class="fa fa-pencil"></span></a>


                <a onclick="window.top.location.href = '<?php echo base_url('index.php/samanta/spare_parts_rack_c_2/delete_rack') . "/" . $dataRefresh->INT_ID; ?>'" class="label label-danger" data-placement="right" data-toggle="tooltip" title="Delete" onclick="return confirm('Are you sure want to delete this asset?');"><span class="fa fa-trash-o"></span></a>
            </td>
        </tr>
        <?php
        $i++;
    }
    ?>
    </tbody>
</table>

<script src="<?php echo base_url('assets/js/jquery-1.12.3.js') ?>"></script>
<script src="<?php echo base_url('assets/js/jquery.dataTables.min.js') ?>"></script>
<script src="<?php echo base_url('assets/js/dataTables.fixedColumns.min.js') ?>"></script>
<link rel="stylesheet" href="<?php echo base_url('assets/css/fixedColumns.dataTables.min.css'); ?>" >
<script>
    $(document).ready(function() {
        var table = $('#example2').DataTable({
            scrollY: "350px",
            scrollX: true,
            scrollCollapse: true,
            paging: false,
            bFilter: false,
            fixedColumns: {
                leftColumns: 2
            }
        });
    });
</script>
<script>
    // $("#flowcheckall").change(function () {
        
    //     $('tbody input[type="checkbox"]').prop('checked', this.checked);
    // });
    var cek =0;
    var cek2 =0;
    function cekALL(){
        if(cek==0)
        {
             $('tbody input[type="checkbox"]').prop('checked', true);
             cek++;
        }
        else
        {
             $('tbody input[type="checkbox"]').prop('checked', false);
             cek = cek-1;
        }
        
    }
    function cekSatu(id){
        alert(document.getElementById(id).value);
        alert(document.getElementById("options2").checked);
        alert(document.getElementById(id).value);
        document.getElementById("options3").checked = true;
    }
    
</script>