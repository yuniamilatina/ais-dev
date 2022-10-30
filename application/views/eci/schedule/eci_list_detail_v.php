<!DOCTYPE html>
<head>
	<meta http-equiv="Content-type" content="text/html; charset=utf-8">
	<title>Gantt Chart</title>
	<link rel="icon" href="<?php echo base_url('assets/img/LogoAisin.png'); ?>" > 
	<script src="<?php echo base_url('assets/js/jquery.js') ?>"></script>
    <script src="<?php echo base_url('assets/js/jquery1.6.1.js') ?>"></script>
    <script src="<?php echo base_url('assets/jquery-ui-1.10.4.custom.min.js') ?>"></script>
    <link rel="stylesheet" href="<?php echo base_url('assets/plugins/bootstrap/css/bootstrap.min.css'); ?>" >
    <link rel="stylesheet" href="<?php echo base_url('assets/plugins/font-awesome/css/font-awesome.min.css'); ?>" >
    <link rel="stylesheet" href="<?php echo base_url('assets/plugins/bootstrap-datetimepicker/css/bootstrap-datetimepicker.min.css'); ?>" >
    <link rel="stylesheet" href="<?php echo base_url('assets/css/jquery-ui.css'); ?>" >
	<script src="<?php echo base_url('assets/dhtmlx_gantt/codebase/dhtmlxgantt.js?v=4.0') ?>"></script>
	<script src="<?php echo base_url('assets/dhtmlx_gantt/codebase/ext/dhtmlxgantt_tooltip.js') ?>"></script>
	<script src="<?php echo base_url('assets/js/jquery.js') ?>"></script>
        <script src="<?php echo base_url('assets/js/jquery1.6.1.js') ?>"></script>
        <script src="<?php echo base_url('assets/jquery-ui-1.10.4.custom.min.js') ?>"></script>
	<!-- <link rel="stylesheet" href="<?php echo base_url('assets/dhtmlx_gantt/codebase/dhtmlxgantt.css?v=4.0'); ?>"> -->
	<link rel="stylesheet" href="<?php echo base_url('assets/dhtmlx_gantt/codebase/dhtmlxgantt_meadow.css'); ?>">
	<!--<script src="../common/testdata.js?v=6.1.1"></script>-->
	<style>
		.modal {
		  display: none; /* Hidden by default */
		  position: fixed; /* Stay in place */
		  z-index: 1; /* Sit on top */
		  padding-top: 100px; /* Location of the box */
		  left: 0;
		  top: 0;
		  width: 100%; /* Full width */
		  height: 100%; /* Full height */
		  overflow: auto; /* Enable scroll if needed */
		  background-color: rgb(0,0,0); /* Fallback color */
		  background-color: rgba(0,0,0,0.4); /* Black w/ opacity */
		}

		/* Modal Content */
		.modal-content {
		  background-color: #fefefe;
		  margin: auto;
		  padding: 20px;
		  border: 1px solid #888;
		  width: 80%;
		}

		/* The Close Button */
		.close {
		  color: #aaaaaa;
		  float: right;
		  font-size: 28px;
		  font-weight: bold;
		}

		.close:hover,
		.close:focus {
		  color: #000;
		  text-decoration: none;
		  cursor: pointer;
		}
		.owner_1{
			background:#d4faff;
			border-color:#64b2bc;
		}

		.high {
			border-color:#64b2bc;
			background: #d96c49;
		}
		.owner_1 .gantt_task_progress{
			background:#91d1d9;
		}
		html, body {
			height: 100%;
			padding: 0px;
			margin: 0px;
			overflow: hidden;
		}
		.gantt_task_progress{
			text-align: left;
		}
		.gantt_grid_data .gantt_cell {
		    border-right: 1px solid #ECECEC;
		}
		.gantt_task_content{
			padding-left:30px;
		}
		.gantt_task_progress span{
			color: #FFF;
			position: relative;
			z-index: 20;
			padding: 3px; margin-left:3px;
			border-radius: 3px;
		}
		.gantt_task_line.gantt_selected .gantt_task_progress_drag {
			display: none;
		}
		.nested_task .gantt_add{ display: none; }
		.high .gantt_task_progress{
			background: #db2536;
		}
		
	</style>
</head>

<body>
<script>
var selected_pic="";
 function selectpic($id)
 {
 	var dept = $id.value;
 	if (dept == "") {
        $("#select_pic").html('---CHOOSE PIC---');
    } else {
        $.ajax({
            async: false,
            type: "POST",
            url: "<?php echo site_url('eci/schedule_c/get_pic_by_dept'); ?>",
            data: "dept=" + dept,
            success: function (data) {
                $("#select_pic").html(data);
                $("#select_pic").value = selected_pic;
            }
        });
    }
 }

function initgantt() {
	var id_activity = $('#id_activity').val();
	var lock_role = $('#eci_lock_role').val();
	
	$.ajax({
        async: false,
        type: "POST",
        url: "<?php echo site_url('eci/schedule_c/detail_eci_2'); ?>",
        data: "id_activity=" + id_activity,
        dataType: 'json',
        success: function(get_data) {
			gantt.config.min_column_width = 70;
            gantt.config.scale_unit = "month";
            gantt.config.date_scale = "%M";
            gantt.config.scale_height = 60;
            gantt.config.subscales = [
					  { unit: "week", step: 1, date: "#%W" }
            ];

            gantt.config.grid_width = 380;
            gantt.config.xml_date = "%Y-%m-%d %H:%i:%s";
			gantt.config.add_column = false;
			//gantt.config.autosize = "y";
			gantt.config.columns = [
				{name: "no", label: "No", width: '50'},
				{name: "text", label: "Activity", tree: true, width: "300"},
				{name: "start_date", label: "Start Date", align: "center", width:"100"},
				{name:"dept", label:"DEPT", align: "center", width: '50'},
				{name: "pic", label: "PIC", align: "center", width: '150',hide:true},
				{name:"add",        label:"",           width:44 },
				{name:"id", label:"id", hide:true},
				{name:"eci_id", label:"id", hide:true},
				{name:"end_date", label:"end", hide:true},
				{name:"sequence", label:"sequence", hide:true},
				{name:"activity_id", label:"activity_id", hide:true},
				{name:"parent", label:"parent", hide:true},
				{name:"color", label:"color", hide:true},
				{name:"information", label:"information", hide:true},

			];
			gantt.templates.task_class = function(start, end, task){
				if(task.color == 4)
				return "high";
		    	if(task.parent > 0)
				return "owner_1";
			}
			gantt.templates.grid_row_class = function( start, end, task ){
		    if ( task.$level > 1 ){
			        return "nested_task"
			    }
			    return "";
			};
			gantt.templates.tooltip_text = function(start,end,task){
				var pr = Math.floor(task.progress * 100 * 10) / 10;
				var convert = gantt.date.date_to_str("%F %j");
				//var end_date = Date("Ymd", task.end_date);
			    return "<b>Task:</b> "+task.text+"<br/><b>Due Date:</b> " + convert(end)+"<br/><b>Progress:</b> " + pr+"%";
			};
			gantt.config.tooltip_offset_x = 30;
			gantt.config.tooltip_offset_y = -10000;

			var secondGridColumns = {
			columns: [
				{
					name: "info", label: "Information", width: 60, align: "left"/*, template: function (task) {
						var progress = task.progress || 0;
						return Math.floor(progress * 100) + "";
					}*/
				}
			]
		};

		gantt.config.layout = {
			css: "gantt_container",
			rows: [
				{
					cols: [
						{view: "grid", width: 320, scrollY: "scrollVer"},
						{resizer: true, width: 1},
						{view: "timeline", scrollX: "scrollHor", scrollY: "scrollVer"},
						{resizer: true, width: 1},
						{view: "grid", width: 200, bind: "task", scrollY: "scrollVer", config: secondGridColumns},
						{view: "scrollbar", id: "scrollVer"}
					]

				},
				{view: "scrollbar", id: "scrollHor", height: 20}
			]
		};

			
 
			gantt.init("gantt_here");
			gantt.attachEvent("onAfterTaskDrag", function (id, mode) {
				var task = gantt.getTask(id);
				if (mode == gantt.config.drag_mode.progress) {
					$.ajax({
			                async: false,
			                type: "POST",
			                url: "<?php echo site_url('eci/schedule_c/update_progress'); ?>",
			                data: "id_activity=" + task.activity_id+'&progress='+task.progress+'&id_eci='+task.eci_id,
			                success: function() {
			                	var pr = Math.floor(task.progress * 100 * 10) / 10;
								gantt.message(task.text + " is now " + pr + "% completed!");
			                   
			                },
			                error: function(xhr, status, error) {
							  var errorMessage = xhr.status + ': ' + xhr.statusText
 						      alert('Error - ' + errorMessage);
							}
			            });
				} /*else {
					var convert = gantt.date.date_to_str("%H:%i, %F %j");
					var s = convert(task.start_date);
					var e = convert(task.end_date);
					gantt.message(task.text + " starts at " + s + " and ends at " + e);
				}*/
			});
			gantt.attachEvent("onBeforeTaskDrag", function (id, mode) {
				var task = gantt.getTask(id);
				var message = task.text + " ";

				if (mode == gantt.config.drag_mode.progress) {
					message += "progress is being updated";
				} else {
					message += "is being ";
					if (mode == gantt.config.drag_mode.move)
						message += "moved";
					else if (mode == gantt.config.drag_mode.resize)
						message += "resized";
				}

				gantt.message(message);
				return true;
			});
			/*gantt.attachEvent("onLightboxSave", function (id, task, is_new) {
				//gantt.message("test");
				if(is_new){
					//var tasks = gantt.getTask(id);
					//var id_task = $('#id_task').val();
					//gantt.message(id_task);
					//gantt.message(tasks.parent);
					
				}
				else
				{
					//gantt.message("test");
					if(!task.text)
					{
						gantt.message({type:"error", text:"Enter task description!"});
						return false;
					}
					if(!task.progress)
					{
						gantt.message({type:"error", text:"Fill task progress!"});
						return false;
					}
					if(!task.pic)
					{
						gantt.message({type:"error", text:"Enter task PIC!"});
						return false;
					}
				}
				return true;
				
			});*/
			gantt.config.drag_resize = false; //unresizable       
            gantt.config.drag_move = false; //undraggable
            gantt.config.drag_links = false;
            if(lock_role==0)
            {
            	gantt.config.readonly = true;
            }

        	gantt.render();
			gantt.parse(get_data,"json");
				//gantt.showLightbox(2);
	    }
	});
	var taskId = null;
	// Get the modal
	var modal = document.getElementById('myModal');
	var span = document.getElementsByClassName("close")[0];
	function show(){
		modal.style.display = "block";
	}
	span.onclick = function() {
	  	modal.style.display = "none";
	}
	function clickGridButton(id, action) {
	    switch (action) {
	        case "lightbox1":
	        lightbox_type = lightbox1;                
	        break;
	    }
	}
	gantt.showLightbox = function(id) { 
	    taskId = id;
	 	var task = gantt.getTask(id);
	 	var lock_role = $('#eci_lock_role').val();
	 	var id_task = document.getElementById("id_task");
	 	id_task.value = 0;
	 	var id_parent = document.getElementById("id_parent");
	 	if(id<10000000)
	 	{
	 		id_task.value = taskId;
	 	} 
	  	var form = getForm();
	  	var input = form.querySelector("[name='txtsequence']");
		console.log(document.getElementsByName("txtsequence")[0]);
	    //console.log(input.value)
	    input.focus();
	    input.value = task.sequence;

	    var input = form.querySelector("[name='information']");
		console.log(document.getElementsByName("information")[0]);
	    //.log(input.value)
	    input.focus();
	    if(id<10000000)
	 	{
	 		input.value = task.information;
	 	} 
	    

	    var idActivity = task.activity_id;
	    id_parent.value = task.parent;

	    $("#datepicker1").datepicker("destroy");
	    $("#datepicker2").datepicker("destroy");

	    if(task.parent==0)
	    {
	    	
	    	   $( '#datepicker1' ).datepicker({
	    	 	dateFormat: 'yy-mm-dd',
		        minDate: new Date("<?php echo $eci_start_date; ?>"),
	    		maxDate: new Date("<?php echo $eci_end_date; ?>")
	    		
		    });
	    	 $( '#datepicker2' ).datepicker({
	    	 	dateFormat: 'yy-mm-dd',
	        	minDate: new Date("<?php echo $eci_start_date; ?>"),
    			maxDate: new Date("<?php echo $eci_end_date; ?>")
	    	});
	    }
	    else
	    {
	    	var taskparent = gantt.getTask(task.parent);

	    	$( '#datepicker1' ).datepicker({
	    		dateFormat: 'yy-mm-dd',
		        minDate: taskparent.start_date,
	    		maxDate: taskparent.end_date

		    });
	    	 $( '#datepicker2' ).datepicker({
	    	 	dateFormat: 'yy-mm-dd',
	        	minDate: taskparent.start_date,
	    		maxDate: taskparent.end_date
	    	});
	    }

	    
	    $("#activity option").filter(function() {
			return $(this).val() == idActivity}).prop('selected', true);


	    input = form.querySelector("[name='start']");
	    console.log(document.getElementsByName("start")[0]);
	    //console.log(input.value)
	    input.focus();
	    input.value = formatDate(task.start_date);



	    input = form.querySelector("[name='select_pic']");
	    console.log(document.getElementsByName("select_pic")[0]);
	    //console.log(input.value)
	    input.focus();
	    selected_pic = task.pic;
	    var dept = task.dept;
	    var pic = task.pic;

	    
	 	if (dept == "") {
	        $("#select_pic").html('---CHOOSE PIC---');
	    } else {
	        $.ajax({
	            async: false,
	            type: "POST",
	            url: "<?php echo site_url('eci/schedule_c/get_pic_by_dept'); ?>",
	            data: "dept=" + dept,
	            success: function (data) {
	                $("#select_pic").html(data);
	                $("#select_pic option").filter(function() {
					    return $(this).text() == ("    "+pic); 
					}).prop('selected', true);
					$("#pic_dept option").filter(function() {
					    return $(this).text() == (dept); 
					}).prop('selected', true);
	            }
	        });
	    }
	    input = form.querySelector("[name='end']");
	    console.log(document.getElementsByName("end")[0]);
	    //console.log(input.value)
	    input.focus();
	    input.value = formatDate(task.end_date);
	    if(lock_role == 1)
	    {
		    form.style.display = "block"; 

		    
		 	show();
		    form.querySelector("[name='cancel']").onclick = cancel;
		    form.querySelector("[name='bsave']").onclick = save;
		    form.querySelector("[name='bdelete']").onclick = remove;
		    if(id>10000000)
		    {
		    	form.querySelector("[name='bdelete']").style.display = "none"; 
		    }
		    else
		    {
		    	form.querySelector("[name='bdelete']").style.display = "inline-block"; 	
		    }
		    // form.querySelector("[name='delete']").onclick = remove;
		}
	    

	};

	function formatDate(date) {
		var monthNames = [
			"January", "February", "March",
			"April", "May", "June", "July",
			"August", "September", "October",
			"November", "December"
		];

		var day = date.getDate();
		var monthIndex = date.getMonth();
		var year = date.getFullYear();

	  	return day + ' ' + monthNames[monthIndex] + ' ' + year;
	}

	gantt.hideLightbox = function(){
	    getForm().style.display = "none"; 
	    taskId = null;
	}
	 
	 
	function getForm() { 
	    return document.getElementById("myModal");
	}; 


	 
	function save() {
	    var id_task = $('#id_task').val();
	    var id_parent = $('#id_parent').val();
	    var start = getForm().querySelector("[name='start']").value;
	    var pic = getForm().querySelector("[name='select_pic']").value;
	    //alert(id_parent);
	    var parent = id_parent;
	    //if(id_task!=0)
	    //{
		    //var task = gantt.getTask(id_task);
		    //parent = task.parent;
		//}
	    //var dept = getForm().querySelector("[name='pic_dept']").value;
	    var activity = getForm().querySelector("[name='activity']").value;
	    var end = getForm().querySelector("[name='end']").value;
	    var eci = $('#id_activity').val();
	    var sequence = getForm().querySelector("[name='txtsequence']").value;
	    var information = getForm().querySelector("[name='information']").value;

	    if(activity == "" || pic == "" || sequence == "")
	    {
	    	var task = gantt.getTask(taskId);
	 
		    if(task.$new)
		    gantt.deleteTask(task.id);
		    gantt.hideLightbox();
		    gantt.message({type:"error", text:"ALL DATA WITH * MARK MUST BE FILLED!"})
	    }
	    else
	    {

		    if(id_task>0)
		 	{
		 		$.ajax({
	                async: false,
	                type: "POST",
	                url: "<?php echo site_url('eci/schedule_c/update_activity'); ?>",
	                data: "id_activity=" + activity+'&start_date='+start+'&id_eci='+eci+'&pic='+pic+'&due_date='+end+'&txtsequence='+sequence+'&id_task='+id_task+'&information='+information,
	                success: function() {
		    		   gantt.hideLightbox();
		    		   gantt.clearAll();
	                   initgantt();
	                   gantt.message("Activity updated successfully!");
	                   
	                },
	                error: function(xhr, status, error) {
						var errorMessage = xhr.status + ': ' + xhr.statusText
	 					alert('Error - ' + errorMessage);
					}
	            });
		 	}
		 	else
		 	{
		 		$.ajax({
	                async: false,
	                type: "POST",
	                url: "<?php echo site_url('eci/schedule_c/add_activity'); ?>",
	                data: "id_activity=" + activity+'&start_date='+start+'&id_eci='+eci+'&pic='+pic+'&due_date='+end+'&txtsequence='+sequence+'&parent='+parent+'&information='+information,
	                success: function() {
		 				//if(task.$new)
		    		   //gantt.deleteTask(task.id);
		    		   gantt.hideLightbox();
		    		   gantt.clearAll();
	                   initgantt();
	                   gantt.message("New activity created!");
	                   
	                },
	                error: function(xhr, status, error) {
						var errorMessage = xhr.status + ': ' + xhr.statusText
	 					alert('Error - ' + errorMessage);
					}
	            });
		 	}
	    }

	}
	 
	function cancel() {
	    var task = gantt.getTask(taskId);
	 
	    if(task.$new)
	    gantt.deleteTask(task.id);
	    gantt.hideLightbox();
	}
	 
	function remove() {
		var id_task = $('#id_task').val();
		var eci = $('#id_activity').val();
		var task = gantt.getTask(id_task);
		var parent = task.parent;
		var box = gantt.confirm({
		    text: "Delete "+task.text+" activity ?",
		    ok:"Yes", 
		    cancel:"No",
		    callback: function(result){
		        if(result){
		            $.ajax({
		                async: false,
		                type: "POST",
		                url: "<?php echo site_url('eci/schedule_c/remove_activity'); ?>",
		                data: "id_eci="+eci+'&id_task='+id_task+'&parent='+parent,
		                success: function() {
			    		   gantt.hideLightbox();
			    		   gantt.clearAll();
		                   initgantt();
		                   gantt.message("Activity deleted successfully!");
		                   
		                },
		                error: function(xhr, status, error) {
							var errorMessage = xhr.status + ': ' + xhr.statusText
		 					alert('Error - ' + errorMessage);
						}
		            });
		        } else {
		            
		        }
		    }
		});   
	}
	var resourceConfig = {    
	    scale_height: 30      
	};
}
	gantt.templates.progress_text = function(start, end, task){
		return "<span>"+Math.round(task.progress*100)+ "% </span>";
	};
	gantt.templates.task_cell_class = function (item, date) {
        if (date.getDay() == 0 || date.getDay() == 6) {
            return "weekend"
        }
    };
    gantt.templates.task_class = function(start, end, task){
    	if(task.parent > 0)
		return "owner_1";
	}
	gantt.templates.grid_row_class = function(start, end, task){ if(task.$level > 0){ return "nested_task" } return ""; };
	
	$(function() {
        "use strict";
        initgantt();
    });
    

	
</script>
<div id="myModal" class="modal" >
  <!-- Modal content -->
  <div class="modal-content" class="col-sm-12" style="height: 400px;">
    <span name="close" class="close">&times;</span>
    <!--<form name="save" action="eci/schedule_c/save_schedule" style="padding-top: 50px"> -->
    <form name="saves" action="" style="padding-top: 50px">
    	
    	<div class=" form-group">
            <!--<label class="col-sm-2 control-label">Activity *</label>
            <div class="col-sm-4">
                <input class="form-control" type="text" name="text" value="" >
            </div> -->
            <label class="col-sm-2 control-label">Activity *</label>
            <div class="col-sm-4">
                <select  name="activity" id="activity" class="form-control" required style="width:250px">
                    <option value="">---CHOOSE ACTIVITY---</option>
                    <?php foreach ($data_activity as $activity_list) { ?>
                    	<option style="text-transform: uppercase;" value="<?php echo $activity_list->INT_ID_ACTIVITY; ?>"><?php echo utf8_encode($activity_list->CHR_ACTIVITY_NAME); ?></option>
                     <?php }
                    ?> 
                </select>
            </div>
            <label class="col-sm-2 control-label">DEPT PIC *</label>
            <div class="col-sm-4">
                <select  name="pic_dept" onchange="selectpic(this)" id="pic_dept" required class="form-control" >
                    <option value="">---CHOOSE DEPT---</option>
                    <?php foreach ($data_pic_dept as $pic_dept_list) { ?>
                        <option value="<?php echo $pic_dept_list->CHR_DEPT; ?>"><?php echo trim($pic_dept_list->CHR_DEPT); ?></option>
                    <?php }
                    ?> 
                </select>
            </div>
        </div>
        <br/>
    	<div class="form-group" style="padding-top: 20px">
            <label class="col-sm-2 control-label">Start Date *</label>
            <div class="col-sm-4">
                <input name="start" id="datepicker1" class="form-control" autocomplete="off" required type="text" style="width: 200px;text-transform: uppercase;" >
            </div>
            <label class="col-sm-2 control-label">PIC *</label>
            <div class="col-sm-4">
                <select  id="select_pic" name="select_pic" required style="height:35px;width:200px;">
                    <option value=""> &nbsp;&nbsp;&nbsp;&nbsp;---CHOOSE PIC---</option>
                </select>
            </div>

        </div>
        <div class="form-group">
            <label class="col-sm-2 control-label"  style="padding-top: 20px">Due Date *</label>
            <div class="col-sm-4"  style="padding-top: 20px">
                <input name="end" id="datepicker2" class="form-control" autocomplete="off" required type="text" style="width: 200px;text-transform: uppercase;" >
            </div>
            <label class="col-sm-2 control-label" style="padding-top: 20px">Sequence *</label>
            <div class="col-sm-4" style="padding-top: 20px">
                <input name="txtsequence" id="txtsequence" class="form-control" required type="number" style="width: 90px;text-transform: uppercase;" >
            </div>
        </div>
        <div class="form-group">
            <label class="col-sm-2 control-label"  style="padding-top: 20px">Information</label>
            <div class="col-sm-4"  style="padding-top: 20px">
             	<textarea name="information" id="information" class="form-control" maxlength="200" required type="textarea" rows="4" cols="50"></textarea>
            </div>
        </div>

		<div class="form-group" >
		 	<label class="col-sm-2 control-label"  style="padding-top: 120px"></label>
		 	<div class="col-sm-12">
		 		<input type="button" class="btn btn-primary" name="bsave" value="Save">
				<input type="button" class="btn btn-default" name="cancel" value="Cancel">
				<input type="button" class="btn btn-primary" name="bdelete" value="Delete" style="background-color: #f44336;">
		 	</div>
		</div>
				
	</form>
  </div>

</div>
<input type="hidden" id="id_activity" value='<?php echo $content; ?>' />
<input type="hidden" id="eci_start_date" value='<?php echo $eci_start_date; ?>'/>
<input type="hidden" id="eci_end_date" value='<?php echo $eci_end_date; ?>'/>
<input type="hidden" id="eci_lock_role" value='<?php echo $lock_role; ?>'/>
<input type="hidden" id="id_task" value='0'/>
<input type="hidden" id="id_parent" value='0'/>
<div style="overflow-x: hidden; 
                overflow-x: auto;">

	<table style="width: 100%">
		<tr>
			<td bgcolor="#2980B9">
				<h3 align="center" style="color: white;"><strong><?php echo $eci_number; ?></strong></h3>
			</td>
		</tr>
	</table>
	<br>
	<div align="center">
		<div align="left" class="col-sm-2">
			<table border="0">
				<tr>
					<td style="width: 50px;">
						<img height="60px" width="230px" src="<?php echo base_url('assets/aii2.jpg') ?>">
					</td>
				</tr>
			</table>
		</div>
	</div>
	<div align="left" class="col-sm-3" style="font-family:Calibri;">
		<table border="0" style="margin-left: 40px">
			<tr>
				<td style="padding-left: 5px;padding-right: 5px">
					Model 
				</td>
				<td style="padding-left: 5px;padding-right: 5px">
					: <strong><?php echo $eci_model; ?></strong>
				</td>
			</tr>
			<tr>
				<td style="padding-left: 5px;padding-right: 5px">
					Purpose
				</td>
				<td style="padding-left: 5px;padding-right: 5px">
					: <strong><?php echo $eci_category; ?></strong>
				</td>
			</tr>
			<tr>
				<td style="padding-left: 5px;padding-right: 5px">
					Customer
				</td>
				<td style="padding-left: 5px;padding-right: 5px">
					: <strong><?php echo $eci_customer; ?></strong>
				</td>
			</tr>
		</table>
	</div>
	<div align="left" class="col-sm-3" style="font-family:Calibri;">
		<table border="0">
			<tr>
				<td style="padding-left: 5px;padding-right: 5px">
					Received Date
				</td>
				<td style="padding-left: 5px;padding-right: 5px">
					: <strong><?php echo $eci_start_date; ?></strong>
				</td>
			</tr>
			<tr>
				<td style="padding-left: 5px;padding-right: 5px">
					Implementing Date
				</td>
				<td style="padding-left: 5px;padding-right: 5px">
					: <strong><?php echo $eci_end_date; ?></strong>
				</td>
			</tr>
			<tr>
				<td style="padding-left: 5px;padding-right: 5px">
					Customer Request Date
				</td>
				<td style="padding-left: 5px;padding-right: 5px">
					: <strong><?php echo $eci_cust_date; ?></strong>
				</td>
			</tr>
		</table>
	</div>
	<div align="left" class="col-sm-3" style="font-family:Calibri;">
		<table border="0" >
			<tr>
				<td style="padding-left: 5px;padding-right: 5px">
					Content :
				</td>
			</tr>
			<tr>
				<td style="padding-left: 5px;padding-right: 5px">
					<strong><?php echo $eci_content; ?></strong>
				</td>
			</tr>
		</table>
	</div>
	
		<!--<left style="margin-left: 100px;"><label class="control-label">Model : <?php echo $eci_model; ?></label></left>
		<left style="margin-left: 100px;"><label class="control-label">Category : <?php echo $eci_category; ?></label></left>
		<left style="margin-left: 100px;"><label class="control-label">Customer : <?php echo $eci_customer; ?></label></left>
		<left style="margin-left: 100px;"><label class="control-label">Start Date : <?php echo $eci_start_date; ?></label></left>
		<left style="margin-left: 100px;"><label class="control-label">End Date : <?php echo $eci_end_date; ?></label></left> -->

	
	<div id="gantt_here" style="max-width:100%; max-height:500px;"></div>
	<div align="right" style="margin-top:80px;margin-right: 20px;padding-top: 10px;">
		<table border="0">
			<tr style="font-family:Calibri;">
				<td style="padding-left: 5px;padding-right: 5px;">
					Legend :&nbsp;&nbsp;&nbsp;&nbsp;
				</td>
				
				<td style="margin-left:20px;background: #a7d991 ;height: 20px;width:30px">
				</td>
				<td style="padding-left: 5px;padding-right: 5px; font-family:Calibri;">
					<strong>Main Activity Progress</strong>&nbsp;&nbsp;&nbsp;&nbsp;
				</td>
				<td style="margin-left:20px;background: #00CED1 ;height: 20px;width:30px">
				</td>
				<td style="padding-left: 5px;padding-right: 5px; font-family:Calibri;">
					<strong>Sub Activity Progress</strong>&nbsp;&nbsp;&nbsp;&nbsp;
				</td>
				<td style="width:30px;height: 20px;background: #db2536">
				</td>
				<td style="padding-left: 5px;padding-right: 5px; font-family:Calibri;">
					<strong>Delay</strong>&nbsp;&nbsp;&nbsp;&nbsp;
				</td>
			</tr>
		</table>
	</div>
</div>
<script src="https://code.jquery.com/jquery-1.12.4.js"></script>
<script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>

</body>