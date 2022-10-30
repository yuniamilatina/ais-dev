<?php
//var_dump ("reza",$last);
?>

<script src="<?php echo base_url('assets/js/jquery-1.9.1.js') ?>"></script>

<script type="text/javascript" src="<?php echo base_url(); ?>assets/js/tablemaster.js" ></script>
<script src="<?php echo base_url('assets/js/jquery.freezeheader.js') ?>"></script>
<script type="text/javascript"
src="http://ajax.googleapis.com/ajax/libs/jquery/1.7.2/jquery.min.js"></script>
<script type="text/javascript"
src="https://ajax.googleapis.com/ajax/libs/jqueryui/1.8.18/jquery-ui.min.js"></script>
<link rel="stylesheet" type="text/css"
      href="http://ajax.googleapis.com/ajax/libs/jqueryui/1.8/themes/base/jquery-ui.css" />

<script type="text/javascript">//CHR_BACK_NO
    $(document).ready(function () {
        var parts =<?php echo json_encode($back_number); ?>;

//						var str = parts.CHR_BACK_NO;
//						console.log(parts);
//						alert(parts);
        $("#search_back_number").autocomplete({
<?php /* ?>//source: '<?php echo site_url();?>/pes/promasdat_c/maintenance_part_select',<?php */ ?>
            source: <?php echo json_encode($back_number); ?>,
            minLength: 1
        });
    });
</script>
<script>
//        jQuery(document).ready(function($){            
//        	$('#dataTables1').freezeHeader({'offset': '5px' });
//        });
</script>
<script type="text/javascript">
    $(document).ready(function () {
        $('#dataTables1').DataTable({
            "scrollX": true
        });
    });

    function clearBoxPartNo() {
        document.getElementById("search_part_number").value = "";
        document.getElementById("search_part_number").disabled = false;
        document.getElementById("search_back_number").value = "";
        document.getElementById("search_back_number").disabled = true;
        document.getElementById("search_part_name").value = "";
        document.getElementById("search_part_name").disabled = true;
        $("#list_data tr td.part_name").parent().show();
    }

    function clearBoxBackNo() {
        document.getElementById("search_part_number").value = "";
        document.getElementById("search_part_number").disabled = true;
        document.getElementById("search_back_number").value = "";
        document.getElementById("search_back_number").disabled = false;
        document.getElementById("search_part_name").value = "";
        document.getElementById("search_part_name").disabled = true;
        $("#list_data tr td.part_name").parent().show();
    }

    function clearBoxPartName() {
        document.getElementById("search_part_number").value = "";
        document.getElementById("search_part_number").disabled = true;
        document.getElementById("search_back_number").value = "";
        document.getElementById("search_back_number").disabled = true;
        document.getElementById("search_part_name").value = "";
        document.getElementById("search_part_name").disabled = false;
        $("#list_data tr td.part_name").parent().show();
    }

    function writeEna(rowid) {

        var enableWc = "#wc_" + rowid;
        var enableTy = "#ty_" + rowid;
        var enableSl = "#sl_" + rowid;
        var enablePr = "#pr_" + rowid;

        $(enableWc).removeAttr('readonly');
        $(enableTy).removeAttr('readonly');
        $(enableSl).removeAttr('readonly');
        $(enablePr).removeAttr('readonly');
        document.getElementById("td_" + rowid).style.display = "none";
        document.getElementById("fd_" + rowid).style.display = "block";
    }
    function cancelEdit(rowid) {
        document.location.reload(true);
    }
    function saveEdit(rowid, partno, backno) {

        var v_pn = document.getElementById("pn_" + rowid).value;
        var v_bn = document.getElementById("bn_" + rowid).value;
        var v_nm = document.getElementById("nm_" + rowid).value;
        var v_wc = document.getElementById("wc_" + rowid).value;
        var v_ty = document.getElementById("ty_" + rowid).value;
        var v_sl = document.getElementById("sl_" + rowid).value;
        var v_pr = document.getElementById("pr_" + rowid).value;
        var urls = v_wc + "/" + v_pn + "/" + v_bn + "/" + v_ty + "/" + v_sl + "/" + v_pr;

        location.href = "<?php echo site_url() ?>/pes/promasdat_c/maintenance_part_save/" + urls;
    }

</script>
<style type="text/css">
    .vcenter {
        vertical-align: middle !important;
        text-align: center !important;
        white-space: nowrap !important;
    }

    .vleft{
        vertical-align: middle !important;
        text-align: left !important;
        white-space: nowrap !important;
        width:40px !important;
    }

    .vright{
        vertical-align: middle !important;
        //text-align: right; !important;
        white-space: nowrap !important;
        font-weight:bold;
    }

    .input-change{
        text-align: right;
        height: 24px !important;
        padding: 4px;
        font-weight:bold;
    }

    .app-check{
        height: 15px !important;
    }

</style>
<style type="text/css">
    #td_date{
        text-align:center;
        vertical-align:top;
    } 
    #table-luar{
        font-size: 12px;
    }
    #filter { 
        border-spacing: 10px;
        border-collapse: separate;
    }

    #filterdiagram {
        border-spacing: 5px;
        border-color: #DDDDDD;
        background-color: #F3F4F5;
    }

    .btn:hover {
        background: #1E90FF;
        background-image: -webkit-linear-gradient(top, #1E90FF, #1E90FF);
        background-image: -moz-linear-gradient(top, #1E90FF, #1E90FF);
        background-image: -ms-linear-gradient(top, #1E90FF, #1E90FF);
        background-image: -o-linear-gradient(top, #1E90FF, #1E90FF);
        background-image: linear-gradient(to bottom, #1E90FF, #1E90FF);
        color:white;
    }
    .textlabel{
        border: 0px;
    }

</style>
<aside class="right-side">

    <section class="content-header">
        <ol class="breadcrumb">
            <li><a href="<?php echo base_url('index.php/basis/home_c/'); ?>"><span>Home</span></a></li>
            <li><a href="<?php echo base_url('index.php/pes/prodentry_c/'); ?>">Production Entry System</a></li>
            <li><a href="<?php echo base_url('index.php/pes/promasdat_c/'); ?>">Master Data Production Execution</a></li>
            <li><a href=""><strong>Maintenance Part</strong></a></li>
        </ol>
    </section>

    <section class="content">
        <div class="row">
            <div class="col-md-12">
                <div class="grid">
                    <div class="grid-header">
                        <i class="fa fa-wrench"></i>
                        <span class="grid-title"><strong>MAINTENANCE PART</strong></span>        
                    </div>
                    <div>
                    </div>
                    <div class="grid-body" > 

                        <form method="POST" id="area" action="">
                            <div style="padding:10px">
                                <table width="100%" >
                                    <tr>
                                        <td rowspan="4" width="10%" style="display:none">Sort By</td>
                                        <td width="10" style="display:none"><input type="radio" name="filter"  checked="checked" onclick = "clearBoxPartNo()"/></td>
                                        <td width="140" height="30" style="border-right:0px; display:none" >Part Number</td><td width="10" style="display:none">:</td><td style="display:none"><input id="search_part_number" type="text" name="name" placeholder="Part Number" size="30"></td>
                                        <td width="100"  height="30" >Work Center</td><td>:</td><td>
                                            <select  id="e1" onChange="document.location.href = this.options[this.selectedIndex].value;">
                                                <?php foreach ($wcenters as $wcenter): ?>
                                                    <option value="<? echo site_url('/pes/promasdat_c/maintenance_part/' . ($wcenter->CHR_WCENTER_MN)); ?>" <?php
                                                    if ($wcenter_l == $wcenter->CHR_WCENTER_MN) {
                                                        echo 'SELECTED';
                                                    }
                                                    ?> ><? echo $wcenter->CHR_WCENTER_MN; ?></option>
                                                        <?php endforeach; ?>
                                                <option value="<? echo site_url('/pes/promasdat_c/maintenance_part/ALL'); ?>" <?php
                                                if ($wcenter_l == 'ALL') {
                                                    echo 'SELECTED';
                                                }
                                                ?> >ALL</option>
                                            </select>
                                        </td>
                                    </tr>
                                    <tr style="display:none">
                                        <td width="10"><input type="radio" name="filter" onclick = "clearBoxBackNo()" /></td>
                                        <td width="140"  height="30" >Back Number</td><td>:</td><td><input id="search_back_number" type="text" name="name" placeholder="Back Number"  value="<?php echo @$parts->CHR_BACK_NO; ?>"></td>
                                        <td>

                                        </td>
                                    </tr>
                                    <tr style="display:none">
                                        <td width="10"><input type="radio" name="filter" onclick = "clearBoxPartName()" /></td>
                                        <td width="140"  height="30" >P. Name & Model</td><td>:</td><td><input id="search_part_name" type="text" name="name" placeholder="P. Name & Model" size="40" ></td>
                                    </tr>
                                    <td colspan="4">

                                    </td>
                                    </tr>					
                                </table>
                            </div>
                            <div >
                                <table id="dataTables1" width="100%" border="0"  class="table table-condensed table-bordered table-hover display">
                                    <thead>                          
                                        <tr>
                                            <th >No</th>
                                            <th >Part No</th>
                                            <th >Back No</th>
                                            <th >Part Name & Model</th>
                                            <th >Work Center</th>
                                            <th >Type</th>
                                            <th >Sloc</th>
                                            <th >Production</th>
                                            <th align="center">Action</th>
                                        </tr>                          
                                    </thead>

                                    <tbody>
                                        <?php
                                        $i = 1;
                                        foreach ($parts as $part):
                                            ?>
                                            <tr <?php
                                            If ($part->CHR_FLG_DELETE == 'X') {
                                                echo "style='background-color: #FFE4E1;'";
                                            }
                                            ?>>
                                                <td width="50px"> <input <?php
                                                    If ($part->CHR_FLG_DELETE == 'X') {
                                                        echo "style='background-color: #FFE4E1;'";
                                                    }
                                                    ?> class="textlabel" readonly="readonly" value="<?php echo $i; ?>" style="width:100% !important; "/></td>
                                                <td ><input <?php
                                                    If ($part->CHR_FLG_DELETE == 'X') {
                                                        echo "style='background-color: #FFE4E1;'";
                                                    }
                                                    ?> class="textlabel" readonly="readonly" name="part_no[]" 		id="pn_<?php echo $i; ?>"	value="<?php echo $part->CHR_PART_NO; ?>"/></td>
                                                <td > <input <?php
                                                    If ($part->CHR_FLG_DELETE == 'X') {
                                                        echo "style='background-color: #FFE4E1;'";
                                                    }
                                                    ?> class="textlabel" readonly="readonly" name="back_no[]" 		id="bn_<?php echo $i; ?>"	value="<?php echo $part->CHR_BACK_NO; ?>"/></td>
                                                <td ><input <?php
                                                    If ($part->CHR_FLG_DELETE == 'X') {
                                                        echo "style='background-color: #FFE4E1;'";
                                                    }
                                                    ?> class="textlabel" readonly="readonly" name="part_name[]" 	id="nm_<?php echo $i; ?>"	value="<?php echo $part->CHR_PART_NAME; ?>"/></td>
                                                <td > <input <?php
                                                    If ($part->CHR_FLG_DELETE == 'X') {
                                                        echo "style='background-color: #FFE4E1;'";
                                                    }
                                                    ?> class="textlabel" readonly="readonly" name="work_center[]" 	id="wc_<?php echo $i; ?>"	value="<?php echo $part->CHR_WCENTER; ?>"/></td>
                                                <td > <input <?php
                                                    If ($part->CHR_FLG_DELETE == 'X') {
                                                        echo "style='background-color: #FFE4E1;'";
                                                    }
                                                    ?> class="textlabel" readonly="readonly" name="txt_type[]" 		id="ty_<?php echo $i; ?>"	value="<?php echo $part->CHR_TYPE; ?>"/></td>
                                                <td > <input <?php
                                                    If ($part->CHR_FLG_DELETE == 'X') {
                                                        echo "style='background-color: #FFE4E1;'";
                                                    }
                                                    ?> class="textlabel" readonly="readonly" name="sloc[]" 			id="sl_<?php echo $i; ?>"	value="<?php echo $part->CHR_SLOC; ?>"/></td>
                                                <td > <input <?php
                                                    If ($part->CHR_FLG_DELETE == 'X') {
                                                        echo "style='background-color: #FFE4E1;'";
                                                    }
                                                    ?> class="textlabel" readonly="readonly" name="production[]" 	id="pr_<?php echo $i; ?>"	value="<?php echo $part->CHR_PROD; ?>"/></td>
                                                <td width="110px"><label id="td_<?php echo $i; ?>"><a onClick="writeEna('<?php echo $i; ?>')">edit</a> | <a href="<?php echo site_url() ?>/pes/promasdat_c/maintenance_part_delete/<? echo ($part->CHR_WCENTER) . '/' . ($part->CHR_PART_NO) . '/' . ($part->CHR_BACK_NO) . '/'; ?><?
                                                        if ($part->CHR_FLG_DELETE == 'X') {
                                                            echo NULL;
                                                        } else {
                                                            echo 'X';
                                                        }
                                                        ?>"><?
                                                                                                                                                                if ($part->CHR_FLG_DELETE == 'X') {
                                                                                                                                                                    echo 'un-delete';
                                                                                                                                                                } else {
                                                                                                                                                                    echo 'delete';
                                                                                                                                                                }
                                                                                                                                                                ?></a></label>
                                                    <label id="fd_<?php echo $i; ?>" style="display:none;"><a onClick="cancelEdit('<?php echo $i; ?>')">cancel</a> | <a onclick="saveEdit('<?php echo $i; ?>')">Save</a></label>
                                                </td>

                                            </tr>
                                            <?php
                                            $i++;
                                        endforeach;
                                        ?>
                                    </tbody>                                                  
                                </table>
                            </div>
                        </form>

                    </div>                                                      
                </div>
            </div>
        </div>

    </section>
</aside>

